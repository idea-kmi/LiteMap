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

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

    $errors = array();

 	$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);
	$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert any possible brackets
	$handler = parseToJSON($handler);

	$issue = optional_param("issue","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);
	$imagefilename = optional_param("imagefilename","",PARAM_TEXT);

    //$resourcetypesarray = optional_param("resourcetypesarray",[],PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray",[],PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray",[],PARAM_URL);
    $identifierarray = optional_param("identifierarray",[],PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray",[],PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray",[],PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray",[],PARAM_TEXT);

    if( isset($_POST["editissue"]) ) {
        if ($issue == ""){
            array_push($errors, $LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){
	        $private = optional_param("private","Y",PARAM_ALPHA);
			$currentUser = $USER;

			$issuenode = getNode($nodeid);

			$r = getRoleByName("Issue");
			$roleIssue = $r->roleid;

			$filename = "";
			if (isset($issuenode->filename)) {
				$filename = $issuenode->filename;
			}

			$issuenode->edit($issue, $desc, $private, $roleIssue, $imagefilename);

			if (!$issuenode instanceof Hub_Error) {
				$imagedelete = optional_param("imagedelete","N",PARAM_ALPHA);
				if ($imagedelete == 'Y') {
					$issuenode->updateImage("");
				} else {
					if ($_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0) {
						$imagedir = $HUB_FLM->getUploadsNodeDir($issuenode->nodeid);
						$photofilename = uploadImageToFitComments('image',$errors,$imagedir, 155, 45);
						if($photofilename != ""){
							$issuenode->updateImage($photofilename);
						}
					}
				}

				/** ADD RESOURCES/URLS **/
				if(empty($errors)){
					// remove all the existing urls so they can be re-added below
					$issuenode->removeAllURLs();

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
						$issuenode->addURL($urlObj->urlid, "");

						$i++;
					}
				}
			}

			echo "<script type='text/javascript'>";
			if (isset($handler) && $handler != "") {
				echo "try { ";
				echo "window.opener.".$handler."('".$issuenode->nodeid."');";
				echo "}";
				echo "catch(err) {";
				echo "}";
			} else {
				echo "try { ";
				echo 'window.opener.location.reload(true);';
				echo "}";
				echo "catch(err) {";
				echo "}";
			}

			echo "window.close();";
			echo "</script>";

			include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
			die;
        }
    } else if ($nodeid != "") {
    	$node = new CNode($nodeid);
    	$node = $node->load();
		$issue = $node->name;
		$desc = $node->description;
		$private = $node->private;
		$imagefilename = "";
		if (isset($node->filename)) {
			$imagefilename = $node->filename;
		}

		if(isset($node->urls)) {
			$urls = $node->urls;

			$count = 0;
			if (is_countable($urls)) {
				$count = count($urls);
			}
			for ($i=0; $i<$count;$i++) {
				$url = $urls[$i];
				//$resourcetypesarray[$i] = $url;
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
		echo "alert('".$LNG->FORM_ISSUE_NOT_FOUND."');";
		echo "window.close();";
		echo "</script>";
		die;
    }

    /**********************************************************************************/
?>

<script type="text/javascript">
	var noResources = <?php if (is_countable($resourceurlarray)) { echo count($resourceurlarray);} else {echo 0;}?>;

	function init() {
		$('dialogheader').insert('<?php echo $LNG->FORM_ISSUE_TITLE_EDIT; ?>');
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
		var checkname = ($('issue').value).trim();
		if (checkname == ""){
		alert("<?php echo $LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR; ?>");
		return false;
		}

		$('issueform').style.cursor = 'wait';

		return true;
	}

	window.onload = init;

</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">
		<div class="col">	
			<?php
				include("../popuplib.php");
				insertFormHeaderMessage();
			?>

			<form id="issueform" name="issueform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
				<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />
				<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
				<input type="hidden" id="imagefilename" name="imagefilename" value="<?php echo $imagefilename; ?>" />

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label"><?php echo $LNG->PROFILE_PHOTO_CURRENT_LABEL; ?></label>
					<div class="col-sm-9">
						<div style="max-height: 120px; max-width: 150px; border:1px solid gray; overflow: hidden">
							<img class="img-fluid" src="<?php print $node->image; ?>"/>
						</div>
					</div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="image"><?php echo $LNG->PROFILE_PHOTO_REPLACE_LABEL; ?></label>
					<div class="col-sm-9">
						<div class="d-flex flex-wrap">
							<input class="form-control" type="file" id="image" name="image" />
						</div>					
						<div class="form-check mt-2 d-flex align-items-center gap-2">
							<input class="form-check-input" type="checkbox" value="Y" id="imagedelete"  name="imagedelete">
							<label class="form-check-label" for="imagedelete">
								<?php echo $LNG->MAP_BACKGROUND_DELETE_LABEL; ?>
							</label>
						</div>
					</div>
				</div>

				<div class="mb-3 row">
					<label  class="col-sm-3 col-form-label" for="url"><span><?php echo $LNG->FORM_ISSUE_LABEL_SUMMARY; ?></span>
						<span class="active" onMouseOver="showFormHint('IssueSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">						
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
							<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input class="form-control" id="issue" name="issue" value="<?php echo $issue; ?>" />
					</div>
				</div>

				<?php insertDescription('IssueDesc'); ?>
				<?php insertPrivate('Private', $private); ?>
				<?php insertResourceForm('URLs'); ?>

                <div class="mb-3 row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
                        <input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
                        <input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="editissue" name="editissue" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>