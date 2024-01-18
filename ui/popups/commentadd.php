<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015 - 2024 The Open University UK                            *
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

			if(empty($errors) && isset($commentnode) && !$commentnode instanceof Hub_Error){
				if ($_FILES['image']['error'] == 0) {
					$imagedir = $HUB_FLM->getUploadsNodeDir($commentnode->nodeid);
					$photofilename = uploadImageToFitComments('image',$errors,$imagedir, 155, 45);
					if($photofilename != ""){
						$commentnode->updateImage($photofilename);
					}
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

<script type="text/javascript">
	var noResources = <?php if (is_countable($resourceurlarray)) { echo count($resourceurlarray);} else {echo 0;}?>;

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

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<?php
				if(!empty($errors)){ ?>
					<div class="alert alert-info">
						<?php echo $LNG->FORM_ERROR_MESSAGE; ?>
						<ul>
							<?php
								foreach ($errors as $error){
									echo "<li>".$error."</li>";
								}
							?>
						</ul>
					</div>
			<?php } ?>
			<?php insertFormHeaderMessageShort(); ?>

			<form id="commentform" name="commentform" commentform="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="image">
						<?php echo $LNG->GROUP_FORM_PHOTO; ?>
					</label>
					<div class="col-sm-9">
						<input class="form-control" type="file" id="image" name="image" />
					</div>
				</div>

				<div class="mb-3 row">
					<label  class="col-sm-3 col-form-label" for="url">
						<span><?php echo $LNG->FORM_LABEL_SUMMARY; ?></span>
						<span class="active" onMouseOver="showFormHint('CommentSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input class="form-control" id="summary" name="summary" value="<?php echo( $summary ); ?>" />
					</div>
				</div>

				<?php insertDescription('CommentDesc') ?>
				<?php insertPrivate('Private', $private); ?>

				<?php if ($isRemote) {
						insertResourceForm('RemoteURLs');
					} else {
						insertResourceForm('URLs');
					}
				?>

				<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
					<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
					<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addcomment" name="addcomment" />
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>