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

	$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);
	$maptitle = optional_param("maptitle","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert any possible brackets
	$handler = parseToJSON($handler);

    // only want to set the default privacy if the form hasn't been posted yet
    if(isset($_POST["addmap"])){
        $private = optional_param("private","Y",PARAM_ALPHA);
    } else {
        $private = optional_param("private",$USER->privatedata,PARAM_ALPHA);
	}

    $groupset = getMyGroups();
    $groups = $groupset->groups;

    if( isset($_POST["addmap"]) ) {

        if ($maptitle == ""){
            array_push($errors, $LNG->FORM_MAP_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){

			$r = getRoleByName("Map");
			$roleMap = $r->roleid;

			// CREATE THE MAP NODE
			$mapview = addView($maptitle, $desc, $private, $roleMap, $groupid, 0, 0);
			$mapnode = $mapview->viewnode;
			if (!$mapview instanceof Error) {
				if ($_FILES['image']['error'] == 0) {
					$imagedir = $HUB_FLM->getUploadsNodeDir($mapnode->nodeid);

					$photofilename = uploadImageToFit('image',$errors,$imagedir);
					if($photofilename == ""){
						$photofilename = $CFG->DEFAULT_ISSUE_PHOTO;
					}
					$mapnode->updateImage($photofilename);
				}

				if ($_FILES['background']['error'] == 0) {
					$imagedir = $HUB_FLM->getUploadsNodeDir($mapnode->nodeid);
					$backgroundfilename = uploadImage('background',$errors,0,$imagedir);
					if($backgroundfilename != ""){
						$target_path = $HUB_FLM->getUploadsWebPath($imagedir."/");
						$mapnode->updateNodeProperty('background', $target_path.$backgroundfilename);
					}
				}

				if (empty($errors)) {
					echo '<script type=\'text/javascript\'>';
					if (isset($handler) && $handler != "") {
						if ($handler == 'importAssignMap') {
							echo "window.opener.".$handler."('".$mapnode->nodeid."', '".$mapnode->name."', '".$private."');";
						} else if ($handler == 'reloadEditBarItems') {
							echo "window.opener.".$handler."();";
						} else {
							echo "window.opener.".$handler."('".$mapnode->nodeid."');";
						}
					} else {
						// Go to the map explore page to view/edit the map
						echo 'window.opener.location.href = "'.$CFG->homeAddress.'map.php?id='.$mapview->nodeid.'";';
					}
					//echo 'window.opener.location.href = "'.$CFG->homeAddress.'map.php?id='.$mapview->nodeid.'";';
					echo "window.close();";
					echo '</script>';
					die;
				}
			} else {
			   array_push($errors, $LNG->FORM_MAP_CREATE_ERROR_MESSAGE." ".$mapnode->message);
			}
		}
    }

	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    /**********************************************************************************/
?>
<?php
if(!empty($errors)){
    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>

<script type="text/javascript">
function init() {
   	$('dialogheader').insert('<?php echo $LNG->FORM_MAP_TITLE_ADD; ?>');
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

</script>

<form id="mapform" name="mapform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">

	<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">

	<div class="formrow">
		<label class="formlabelbig" for="photo"><?php echo $LNG->MAP_IMAGE_LABEL; ?>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:white;">*</span>
		</label>
		<input class="hgrinput forminput" type="file" id="image" name="image" size="40">
	</div>
	<div class="formrow" style="margin-top:0px;">
		<label class="formlabelbig" style="height:30px;">&nbsp;</label>
		<span class="forminput"><?php echo $LNG->GROUP_FORM_PHOTO_HELP; ?></span>
	</div>

    <div class="formrow">
		<label  class="formlabelbig" for="url"><span style="vertical-align:top"><?php echo $LNG->FORM_MAP_LABEL_SUMMARY; ?></span>
			<span class="active" onMouseOver="showFormHint('MapSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="maptitle" name="maptitle" value="<?php echo( $maptitle ); ?>" />
	</div>

	<?php insertDescription('MapDesc'); ?>

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

	<?php
		if (isset($groupid) && $groupid != "") {
			insertPrivate('MapPrivateGroup', $private);
		} else {
			insertPrivate('MapPrivate', $private);
		}
	?>

	<div class="formrow">
		<label class="formlabelbig" for="groupid"><?php echo $LNG->MAP_FORM_ADD_TO_GROUP; ?>
			<span class="active" onMouseOver="showFormHint('MapGroup', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		</label>

		<select class="forminput" name="groupid" id="groupid" onchange="loadgroup();">
			<option value=""><?php echo $LNG->GROUP_FORM_SELECT; ?></option>
			<?php
				foreach($groups as $g){
				   echo "<option value='".$g->groupid."' ";
				   if($g->groupid == $groupid){
						echo "selected='true'";
				   }
				   echo ">".$g->name."</option>";
				}
			?>
		</select>
	</div>

    <br>
    <div class="hgrformrow">
		<label class="formlabelbig" style="height:30px;">&nbsp;</label>
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="addmap" name="addmap">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>