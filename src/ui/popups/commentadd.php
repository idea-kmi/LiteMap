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

	$isRemote = optional_param("isremote", false,PARAM_BOOL);
	$summary = optional_param("summary","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

    if(isset($_POST["addcomment"])){
        $private = optional_param("private","Y",PARAM_ALPHA);
    } else {
        $private = optional_param("private",$USER->privatedata,PARAM_ALPHA);
	}

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert any possible brackets
	$handler = parseToJSON($handler);

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

    if( isset($_POST["addcomment"]) ) {

		$label = $summary;
		trim($label);

        if ($label == ""){
            array_push($errors, $LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){

			$r = getRoleByName("Idea");
			$roleComment = $r->roleid;

			// CREATE THE NODE
			$commentnode = addNode($label,$desc, $private, $roleComment);

			if(empty($errors) && isset($commentnode) && !$commentnode instanceof Error){
				if ($_FILES['image']['error'] == 0) {
					$imagedir = $HUB_FLM->getUploadsNodeDir($commentnode->nodeid);
					$photofilename = uploadImageToFitComments('image',$errors,$imagedir, 155, 45);
					if($photofilename == ""){
						$photofilename = $CFG->DEFAULT_ISSUE_PHOTO;
					}
					$commentnode->updateImage($photofilename);
				}

				/** ADD RESOURCES **/
				$lt = getLinkTypeByLabel('is related to');
				$linkRelated = $lt->linktypeid;

				$i = 0;
				foreach($resourceurlarray as $resourceurl) {

					$resourcetitle = trim($resourcetitlearray[$i]);
					// If they have entered nothing, don't do anything.
					if ($resourcetitle == "" && ($resourceurl == "http://" || $resourceurl == "")) {
						break;
					}

					//check all fields entered
					if ($resourcetitle != "" && ($resourceurl == "http://" || $resourceurl == "")){
						array_push($errors,$LNG->FORM_RESOURCE_URL_REQUIRED);
						break;
					}

					$URLValidator = new mrsnk_URL_validation($resourceurl, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
					if($resourceurl != "" && !$URLValidator->isValid()){
						 array_push($errors,$LNG->FORM_RESOURCE_URL_FORMAT_ERROR);
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

				if (empty($errors)) {
					echo "<script type='text/javascript'>";
					if ($isRemote === false) {
						if (isset($handler) && $handler != "") {
							echo "window.opener.".$handler."('".$commentnode->nodeid."');";
						} else {
							echo "try { ";
							echo "var parent=window.opener.document; ";
							echo "if (window.opener && window.opener.loadSelecteditemNew) {";
							echo "	  window.opener.loadSelecteditemNew('".$commentnode->nodeid."','".$commentnode->name."'); }";
							echo 'else {';
							echo '	   window.opener.location.reload(true); }';
							echo "}";
							echo "catch(err) {";
							//CALLED FROM BOOKMARKET FROM A DIFFERNT DOMAIN
							//message about successfully saving?
							//echo "window.close();";
							echo "}";
						}
						echo "window.close();";
					} else {
						// For IE security message avoidance
						echo "var objWin = window.self;";
						echo "objWin.open('','_self','');";
						echo "objWin.close();";
					}

					echo "</script>";
					include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
					die;
				}
			}
		}
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
var noResources = <?php echo sizeof($resourceurlarray);?>;

function init() {
    $('dialogheader').insert('<?php echo $LNG->FORM_COMMENT_TITLE; ?>');
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

	<div class="formrow">
		<label class="formlabelbig" for="photo"><?php echo $LNG->GROUP_FORM_PHOTO; ?>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:white;">*</span>
		</label>
		<input class="hgrinput forminput" type="file" id="image" name="image" size="40">
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

	<?php if ($isRemote) {
			insertResourceForm('RemoteURLs');
		} else {
			insertResourceForm('URLs');
		}
	?>

    <br>
    <div class="hgrformrow">
		<label class="formlabelbig">&nbsp;</label>
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addcomment" name="addcomment">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>