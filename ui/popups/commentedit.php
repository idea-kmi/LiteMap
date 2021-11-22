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

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

    $errors = array();

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert any possible brackets
	$handler = parseToJSON($handler);

 	$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);

	$summary = optional_param("summary","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);
	$imagefilename = optional_param("imagefilename","",PARAM_TEXT);

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

    if( isset($_POST["editcomment"]) ) {
		$label = $summary;
		trim($label);

        if ($label == ""){
            array_push($errors, $LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){
	        $private = optional_param("private","Y",PARAM_ALPHA);
			$currentUser = $USER;

			$commentnode = getNode($nodeid);

			$r = getRoleByName("Idea");
			$roleComment = $r->roleid;

			$filename = "";
			if (isset($commentnode->filename)) {
				$filename = $commentnode->filename;
			}

			$commentnode = $commentnode->edit($label, $desc, $private, $roleComment, $imagefilename);

			if (!$commentnode instanceof Hub_Error) {
				if(empty($errors)){

					$imagedelete = optional_param("imagedelete","N",PARAM_ALPHA);
					if ($imagedelete == 'Y') {
						$commentnode->updateImage("");
					} else {
						if ($_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0) {
							$imagedir = $HUB_FLM->getUploadsNodeDir($commentnode->nodeid);
							$photofilename = uploadImageToFitComments('image',$errors,$imagedir, 155, 45);
							if($photofilename != ""){
								$commentnode->updateImage($photofilename);
							}
						}
					}

					/** ADD RESOURCES/URLS **/
					if(empty($errors)){
						// remove all the existing urls so they can be re-added below
						$commentnode->removeAllURLs();

						$i = 0;
						foreach($resourceurlarray as $resourceurl) {

							$resourcetitle = trim($resourcetitlearray[$i]);
							// If they have entered nothing, don't do anything.
							if ($resourcetitle == "" && ($resourceurl == "http://" || $resourceurl == "")) {
								break;
							}

							//check all fields entered
							if ($resourcetitle != "" && ($resourceurl == "http://" || $resourceurl == "")){
								array_push($errors,$LNG->FORM_ERROR_URL_INVALID);
								break;
							}

							if ($resourcetitle == ""){
								$resourcetitle = $resourceurl;
							}

							// ADD URL TO REF and EVIDENCE
							$clip = "";
							$clippath = "";
							$identifier="";
							if (isset($resourcecliparray[$i])) {
								$clip = $resourcecliparray[$i];
							}
							if (isset($resourceclippatharray[$i])) {
								$clippath = $resourceclippatharray[$i];
							}
							if (isset($identifierarray[$i])) {
								$identifier= $identifierarray[$i];
							}

							$urlObj = addURL($resourceurl, $resourcetitle, "", $private, $clip, $clippath, "", "cohere", $identifier);
							$commentnode->addURL($urlObj->urlid, "");

							$i++;
						}
					}
				}
			}



			if (empty($errors)) {
				echo "<script type='text/javascript'>";
				if (isset($handler) && $handler != "") {
					echo "window.opener.".$handler."('".$commentnode->nodeid."');";
				} else {
					echo "window.opener.location.reload(true);";
				}
				echo "window.close();";
				echo "</script>";
				include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
				die;
			}
		}
    } else if ($nodeid != "") {
    	$node = new CNode($nodeid);
    	$node = $node->load();
    	$summary = $node->name;
		$desc = $node->description;
		$private = $node->private;
		$imagefilename = "";
		if (isset($node->filename)) {
			$imagefilename = $node->filename;
		}

		//if ($desc == "") {
		//	$desc = $node->name;
		//}
		if(isset($node->urls)) {
			$urls = $node->urls;
			$count = 0;
			if (is_countable($urls)) {
				$count = count($urls);
			}
			for ($i=0; $i<$count;$i++) {
				$url = $urls[$i];
				$resourcetypesarray[$i] = $url;
				$identifierarray[$i] = $url->identifier;
				$resourcetitlearray[$i] = $url->title;
				$resourceurlarray[$i] = $url->url;
				$resourcenodeidsarray[$i] = $url->urlid;
				$resourcecliparray[$i] = $url->clip;
				$resourceclippatharray[$i] = $url->clippath;
			}
		}
    } else {
		echo "<script type='text/javascript'>";
		echo "alert('".$LNG->FORM_COMMENT_NOT_FOUND."');";
		echo "window.close();";
		echo "</script>";
		die;
    }

	include($HUB_FLM->getCodeDirPath("ui/popuplib.php"));
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
var noResources = <?php if (is_countable($resourceurlarray)) { echo count($resourceurlarray);} else {echo 0;}?>;

function init() {
    $('dialogheader').insert('<?php echo $LNG->COMMENT_NAME; ?>');
}

function addSelectedResource(node, num) {
	$('resource'+num+'label').value=node.role[0].role.name;

	$('resourcetitle-'+num).value = node.name;
	$('resourcetitle-'+num).disabled = true;
	$('resourcenodeidsarray-'+num).value = node.nodeid;

	if ($('identifierdiv-'+num)) {
		$('identifierdiv-'+num).style.display="none";
	}

	$('typehiddendiv-'+num).style.display="block";
	$('typediv-'+num).style.display="none";
	$('resourceurldiv-'+num).style.display="none";
	$('resourcedescdiv-'+num).style.display="none";
}

function removeSelectedResource(num) {
	$('resourcetitle-'+num).value = "";
	$('resourcetitle-'+num).disabled = false;
	$('resourcedesc-'+num).value = "";
	$('resourcenodeidsarray-'+num).value = "";

	$('typehiddendiv-'+num).style.display="none";
	$('typediv-'+num).style.display="block";
	$('resourceurldiv-'+num).style.display="block";
	$('resourcedescdiv-'+num).style.display="block";
}

function checkForm() {
	var checkname = ($('summary').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }

    $('commentform').style.cursor = 'wait';
	return true;
}

window.onload = init;

</script>

<?php insertFormHeaderMessageShort(); ?>

<form id="commentform" name="commentform" commentform="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
	<input type="hidden" id="imagefilename" name="imagefilename" value="<?php echo $imagefilename; ?>" />

    <div class="hgrformrow">
		<label class="formlabelbig" style="padding-right:5px;"><?php echo $LNG->PROFILE_PHOTO_CURRENT_LABEL; ?></label>
		<div style="position:relative;overflow:hidden;border:1px solid gray;width:160px;height:120;max-width:160px;min-width:160px;min-height:120px;overflow:auto">
			<img style="position:absolute; top:0px left:0px;cursor:move;width:150px" id="dragableElement" border="0" src="<?php print $node->image; ?>"/>
		</div>
    </div>
    <div class="hgrformrow">
		<label class="formlabelbig" for="image"><?php echo $LNG->PROFILE_PHOTO_REPLACE_LABEL; ?></label>
		<input class="forminput" type="file" id="image" name="image" size="40">
		<input id="imagedelete" class="forminput" type="checkbox" name="imagedelete" value="Y" /><?php echo $LNG->MAP_BACKGROUND_DELETE_LABEL; ?>
    </div>

    <div class="formrow">
		<label  class="formlabelbig" for="url"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_SUMMARY; ?></span>
			<span class="active" onMouseOver="showFormHint('CommentSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="summary" name="summary" value="<?php echo( $summary ); ?>" />
	</div>

	<?php insertDescription('CommentDesc') ?>

	<?php insertPrivate('Private', $private); ?>

	<?php insertResourceForm('URLs'); ?>

    <br>
    <div class="hgrformrow">
		<label class="formlabelbig">&nbsp;</label>
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="editcomment" name="editcomment">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>