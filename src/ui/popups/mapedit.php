<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015 The Open University UK                                   *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/

    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

    $errors = array();

 	$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);
   	$node = new CNode($nodeid);
	$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert any possible brackets
	$handler = parseToJSON($handler);

	$maptitle = optional_param("maptitle","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

	$media = optional_param("media","",PARAM_URL);
	$youtubeid = optional_param("youtubeid","",PARAM_ALPHANUMEXT);
	$vimeoid = optional_param("vimeoid","",PARAM_ALPHANUMEXT);

	$moviewidth = optional_param("moviewidth","480",PARAM_INT);
	$movieheight = optional_param("movieheight","320",PARAM_INT);

    // only want to set the default privacy if the form hasn't been posted yet
    // WHY!!!!
    if(isset($_POST["editmap"])){
        $private = optional_param("private","Y",PARAM_ALPHA);
    } else {
        $private = optional_param("private",$USER->privatedata,PARAM_ALPHA);
	}

    if( isset($_POST["editmap"]) ) {
        if ($maptitle == ""){
            array_push($errors, $LNG->FORM_MAP_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){
			$r = getRoleByName("Map");
			$roleMap = $r->roleid;
			$mapnode = getNode($nodeid);

			$filename = "";
			if (isset($mapnode->filename)) {
				$filename = $mapnode->filename;
			}

			$mapnode = $mapnode->edit($maptitle, $desc, $private, $roleMap, $filename, '');
			if (!$mapnode instanceof Error) {

				$imagedelete = optional_param("imagedelete","N",PARAM_ALPHA);
				if ($imagedelete == 'Y') {
					$mapnode->updateImage($CFG->DEFAULT_ISSUE_PHOTO);
				} else {
					if ($_FILES['image']['error'] == 0) {
						$imagedir = $HUB_FLM->getUploadsNodeDir($mapnode->nodeid);
						$photofilename = uploadImageToFit('image',$errors,$imagedir);
						if($photofilename == ""){
							$photofilename = $CFG->DEFAULT_ISSUE_PHOTO;
						}
						$mapnode->updateImage($photofilename);
					}
				}

				$backimagedelete = optional_param("backimagedelete","N",PARAM_ALPHA);
				if ($backimagedelete == 'Y') {
					$mapnode->updateNodeProperty('background', '');
				} else {
					if ($_FILES['background']['error'] == 0) {
						$imagedir = $HUB_FLM->getUploadsNodeDir($mapnode->nodeid);
						$backgroundfilename = uploadImage('background',$errors,0,$imagedir);
						if($backgroundfilename != ""){
							$target_path = $HUB_FLM->getUploadsWebPath($imagedir."/");
							$mapnode->updateNodeProperty('background', $target_path.$backgroundfilename);
						}
					}
				}

				// This should always be an either or media or youtube or vimeo
				$oldmedia = $mapnode->getNodeProperty('media');
				if ($media != $oldmedia || !isset($oldmedia)) {
					$mimetype = getMimeType($media);
					$mapnode->updateNodeProperty('media', $media);
					$mapnode->updateNodeProperty('mediatype', $mimetype);
				} else {
					$oldyoutubeid = $mapnode->getNodeProperty('youtubeid');
					if ($youtubeid != $oldyoutubeid || !isset($oldyoutubeid)) {
						$mapnode->updateNodeProperty('youtubeid', $youtubeid);
						$mapnode->updateNodeProperty('mediatype', '');
					} else {
						$oldvimeoid = $mapnode->getNodeProperty('vimeoid');
						if ($vimeoid != $oldvimeoid || !isset($oldvimeoid)) {
							$mapnode->updateNodeProperty('vimeoid', $vimeoid);
							$mapnode->updateNodeProperty('mediatype', '');
						}
					}
				}

				$oldmoviesize = $mapnode->getNodeProperty('moviesize');
				if (isset($oldmoviesize)) {
					$size = explode(':', $oldmoviesize);
					if ((int)$size[0] != $moviewidth || (int)$size[1] != $movieheight) {
						$mapnode->updateNodeProperty('moviesize', $moviewidth.":".$movieheight);
					}
				} else {
					$mapnode->updateNodeProperty('moviesize', $moviewidth.":".$movieheight);
				}

			} else {
			   array_push($errors, $LNG->FORM_MAP_CREATE_ERROR_MESSAGE." ".$mapnode->message);
			}

			if (empty($errors)) {
				echo "<script type='text/javascript'>";
				echo "try { ";
					echo 'window.opener.location.reload(true);';
				echo "}";
				echo "catch(err) {";
				echo "}";

				echo "window.close();";
				echo "</script>";

				include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
				die;
			}
        }
    } else if ($nodeid != "") {
    	$node = $node->load('long');
		$maptitle = $node->name;
		$desc = $node->description;
		$private = $node->private;
		$background = $node->getNodeProperty('background');
		$media = $node->getNodeProperty('media');
		$youtubeid = $node->getNodeProperty('youtubeid');
		$vimeoid = $node->getNodeProperty('vimeoid');
		$moviesize = $node->getNodeProperty('moviesize');
		if (isset($moviesize)) {
			$size = explode(':', $moviesize);
			$moviewidth = (int)$size[0];
			$movieheight = (int)$size[1];
		}
    } else {
		echo "<script type='text/javascript'>";
		echo "alert('".$LNG->FORM_MAP_NOT_FOUND."');";
		echo "window.close();";
		echo "</script>";
		die;
    }

	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    /**********************************************************************************/
?>
<?php
if(!empty($errors)){
   	$node = new CNode($nodeid);
	$background = $node->getNodeProperty('background');

    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>

<script type="text/javascript">

function init() {
	$('dialogheader').insert('<?php echo $LNG->FORM_MAP_TITLE_EDIT; ?>');
}

function checkForm() {
	var checkname = ($('maptitle').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_MAP_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }

    $('mapform').style.cursor = 'wait';

    return true;
}

window.onload = init;

function clearVimeoElements() {
	$('media').value = '';
	$('media').disabled = false;
	$('vimeoid').value = '';
	$('moviewidth').value = '';
	$('movieheight').value = '';
	return false;
}

function extractVimeoElements() {
	var text = prompt("<?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_PROMPT; ?>");
	if (text != null) {

		var ID = '';
		var width = 0;
		var height= 0;

		var striptags = text.replace(/(>|<)/gi,'');

		// Get ID
		var firstsplit = striptags.split(/(vi\/|v=|\/v\/|vimeo\.be\/|\/video\/)/);
		if(firstsplit[2] !== undefined) {
			ID = firstsplit[2].split(/[^0-9a-z_\-]/i);
			ID = ID[0];
		} else {
			ID = firstsplit;
		}
		if (ID != "") {
			$('media').value = '';
			$('media').disabled = true;
			$('vimeoid').value = ID;
		}

		// Get width / height
		var widthsplit = striptags.split(/width=/);
		if (widthsplit[1] !== undefined) {
			var end = widthsplit[1].indexOf('"', 1);
			width = widthsplit[1].substr(1,end-1);
		}
		var heightsplit = striptags.split(/height=/);
		if (heightsplit[1] !== undefined) {
			var end = heightsplit[1].indexOf('"', 1);
			height = heightsplit[1].substr(1,end-1);
		}

		if (width > 0) {
			$('moviewidth').value = width;
		}
		if (height > 0) {
			$('movieheight').value = height;
		}
		if (width == 0 && height == 0) {
			alert('<?php echo $LNG->MAP_MOVIE_SIZE_MESSAGE;?>');
		}
	}
	return false;
}

function clearYouTubeElements() {
	$('media').value = '';
	$('media').disabled = false;
	$('youtubeid').value = '';
	$('moviewidth').value = '';
	$('movieheight').value = '';
	return false;
}

function extractYouTubeElements() {
	var text = prompt("<?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_PROMPT; ?>");
	if (text != null) {

		var ID = '';
		var width = 0;
		var height= 0;

		var striptags = text.replace(/(>|<)/gi,'');

		// Get ID
		var firstsplit = striptags.split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
		if(firstsplit[2] !== undefined) {
			ID = firstsplit[2].split(/[^0-9a-z_\-]/i);
			ID = ID[0];
		} else {
			ID = firstsplit;
		}
		if (ID != "") {
			$('media').value = '';
			$('media').disabled = true;
			$('youtubeid').value = ID;
		}

		// Get width / height
		var widthsplit = striptags.split(/width=/);
		if (widthsplit[1] !== undefined) {
			var end = widthsplit[1].indexOf('"', 1);
			width = widthsplit[1].substr(1,end-1);
		}
		var heightsplit = striptags.split(/height=/);
		if (heightsplit[1] !== undefined) {
			var end = heightsplit[1].indexOf('"', 1);
			height = heightsplit[1].substr(1,end-1);
		}

		if (width > 0) {
			$('moviewidth').value = width;
		}
		if (height > 0) {
			$('movieheight').value = height;
		}
		if (width == 0 && height == 0) {
			alert('<?php echo $LNG->MAP_MOVIE_SIZE_MESSAGE;?>');
		}
	}
	return false;
}


function toggleGroups() {
	if ( $("groupsdiv").style.display == "block") {
		$("groupsdiv").style.display = "none";
		$("groupsimg").src=URL_ROOT+"images/arrow-down-green.png";
	} else {
		$("groupsdiv").style.display = "block";
		$("groupsimg").src=URL_ROOT+"images/arrow-up-green.png";
	}
}
</script>

<form id="mapform" name="mapform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
	<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />
	<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">

    <div class="hgrformrow">
		<label class="formlabelbig" style="padding-right:5px;"><?php echo $LNG->PROFILE_PHOTO_CURRENT_LABEL; ?></label>
		<div style="position:relative;overflow:hidden;border:1px solid gray;width:160px;height:120;max-width:160px;max-height:120px;min-width:160px;min-height:120px;">
			<img style="position:absolute; top:0px left:0px;cursor:move;" id="dragableElement" border="0" src="<?php print $node->image; ?>"/>
		</div>
    </div>
    <div class="hgrformrow">
		<label class="formlabelbig" for="image"><?php echo $LNG->PROFILE_PHOTO_REPLACE_LABEL; ?></label>
		<input class="forminput" type="file" id="image" name="image" size="40">
		<input id="imagedelete" class="forminput" type="checkbox" name="imagedelete" value="Y" /><?php echo $LNG->MAP_BACKGROUND_DELETE_LABEL; ?>
    </div>
	<div class="formrow">
		<label class="formlabelbig" style="height:30px;">&nbsp;</label>
		<span class="forminput"><?php echo $LNG->GROUP_FORM_PHOTO_HELP; ?></span>
	</div>

	<hr style="clear:both;float:left; width:100%;border: 0;color: #E8E8E8; background-color:#E8E8E8; height: 1px;" />

    <div class="formrow">
		<label  class="formlabelbig" for="url"><span style="vertical-align:top"><?php echo $LNG->FORM_MAP_LABEL_SUMMARY; ?></span>
			<span class="active" onMouseOver="showFormHint('MapSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="maptitle" name="maptitle" value="<?php echo $maptitle; ?>" />
	</div>

	<?php insertDescription('MapDesc'); ?>

	<?php
		if (isset($groupid) && $groupid != "") {
			insertPrivate('MapPrivateGroup', $private);
		} else {
			insertPrivate('MapPrivate', $private);
		}
	?>

	<hr style="clear:both;float:left; width:100%;border: 0;color: #E8E8E8; background-color:#E8E8E8; height: 1px;" />

	<?php
		if ($background != "") {?>
		<div class="hgrformrow">
			<label class="formlabelbig"><?php echo $LNG->MAP_BACKGROUND_LABEL; ?></label>
			<div style="float:left;margin-left:6px;width:500px;height:250px;overflow:auto;">
				<img border="0" src="<?php echo $background; ?>"/>
			</div>
		</div>
		<div class="formrow">
			<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_BACKGROUND_REPLACE_LABEL; ?>
				<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:white;">*</span>
			</label>
			<input class="hgrinput forminput" type="file" id="background" name="background" size="40">
			<input id="backimagedelete" class="forminput" type="checkbox" name="backimagedelete" value="Y" /><?php echo $LNG->MAP_BACKGROUND_DELETE_LABEL; ?>
		</div>
		<div class="formrow">
			<label class="formlabelbig">&nbsp;</label>
			<div style="float:left;margin-left:5px;width:500px;"><?php echo $LNG->MAP_BACKGROUND_HELP; ?></div>
		</div>
	<?php } else { ?>
		<div class="formrow">
			<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_BACKGROUND_LABEL; ?>
				<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:white;">*</span>
			</label>
			<input class="hgrinput forminput" type="file" id="background" name="background" size="40">
		</div>
		<div class="formrow">
			<label class="formlabelbig">&nbsp;</label>
			<div style="float:left;margin-left:5px;width:500px;"><?php echo $LNG->MAP_BACKGROUND_HELP; ?></div>
		</div>
	<?php } ?>

	<hr style="clear:both;float:left; width:100%;border: 0;color: #E8E8E8; background-color:#E8E8E8; height: 1px;" />

	<div class="formrow">
		<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_MEDIA_LABEL; ?>
			<span class="active" onMouseOver="showFormHint('MapMedia', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:transparent;">*</span>
		</label>
		<?php if ($youtubeid != "") { ?>
			<input class="hgrinput forminput" disabled id="media" name="media" size="40" value="<?php echo $media; ?>">
		<?php } else { ?>
			<input class="hgrinput forminput" id="media" name="media" size="40" value="<?php echo $media; ?>">
		<?php } ?>
	</div>

	<div class="formrow">
		<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_LABEL; ?>
			<span class="active" onMouseOver="showFormHint('MapImportYouTubeMedia', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:transparent;">*</span>
		</label>
		<button class="forminput" onclick="extractYouTubeElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_BUTTON; ?></button>
		<input class="forminput" id="youtubeid" name="youtubeid" size="20" value="<?php echo $youtubeid; ?>">
		<button class="forminput" onclick="clearYouTubeElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_CLEAR; ?></button>
	</div>

	<div class="formrow">
		<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_LABEL; ?>
			<span class="active" onMouseOver="showFormHint('MapImportVimeoMedia', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:transparent;">*</span>
		</label>
		<button class="forminput" onclick="extractVimeoElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_BUTTON; ?></button>
		<input class="forminput" id="vimeoid" name="vimeoid" size="20" value="<?php echo $vimeoid; ?>">
		<button class="forminput" onclick="clearVomeoElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_CLEAR; ?></button>
	</div>

	<div class="formrow">
		<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_MOVIE_WIDTH_LABEL; ?>
			<span class="active" onMouseOver="showFormHint('MapMovieWidth', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:transparent;">*</span>
		</label>
		<input class="forminput" id="moviewidth" name="moviewidth" size="10" value="<?php echo $moviewidth; ?>">
	</div>
	<div class="formrow">
		<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_MOVIE_HEIGHT_LABEL; ?>
			<span class="active" onMouseOver="showFormHint('MapMovieHeight', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:transparent;">*</span>
		</label>
		<input class="forminput" id="movieheight" name="movieheight" size="10" value="<?php echo $movieheight; ?>">
	</div>

	<hr style="clear:both;float:left; width:100%;border: 0;color: #E8E8E8; background-color:#E8E8E8; height: 1px;" />

    <div class="hgrformrow">
		<label class="formlabelbig">&nbsp;</label>
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="editmap" name="editmap">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>