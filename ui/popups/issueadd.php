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

	$isRemote = optional_param("isremote", false,PARAM_BOOL);
	$handler = optional_param("handler","", PARAM_TEXT);
	//convert any possible brackets
	$handler = parseToJSON($handler);

	$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);
	$issue = optional_param("issue","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);
    $private = optional_param("private",$USER->privatedata,PARAM_ALPHA);

    //$resourcetypesarray = optional_param("resourcetypesarray",[],PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray",[],PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray",[],PARAM_URL);
    $identifierarray = optional_param("identifierarray",[],PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray",[],PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray",[],PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray",[],PARAM_TEXT);

    $clonenodeid = optional_param("clonenodeid","",PARAM_HTML);

    if(isset($_POST["addissue"])){
        $private = optional_param("private","Y",PARAM_ALPHA);
    } else {
        $private = optional_param("private",$USER->privatedata,PARAM_ALPHA);
	}

    if( isset($_POST["addissue"]) ) {

        if ($issue == ""){
            array_push($errors, $LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){

			// GET ROLES AND LINKS AS USER
			$r = getRoleByName("Issue");
			$roleIssue = $r->roleid;

			// CREATE THE ISSUE NODE
			$issuenode = addNode($issue, $desc, $private, $roleIssue);

			if (!$issuenode instanceof Hub_Error) {

				if ($_FILES['image']['error'] == 0) {
					$imagedir = $HUB_FLM->getUploadsNodeDir($issuenode->nodeid);
					$photofilename = uploadImageToFitComments('image',$errors,$imagedir, 155, 45);
					if($photofilename != ""){
						$issuenode->updateImage($photofilename);
					}
				}

				// Add a see also to the chat comment node this was cread from if chatnodeid exists
				if ($clonenodeid != "") {
					$clonenode = getNode($clonenodeid);
					$clonerolename = $clonenode->role->name;
					$r = getRoleByName($clonerolename);
					$roleClone = $r->roleid;

					$lt = getLinkTypeByLabel($CFG->LINK_COMMENT_BUILT_FROM);
					$linkComment = $lt->linktypeid;

					$connection = addConnection($issuenode->nodeid, $roleIssue, $linkComment, $clonenodeid, $roleClone, "N");
				}

				if (isset($groupid) && $groupid != "") {
					$issuenode->addGroup($groupid);
				}

				/** ADD RESOURCES **/
				if(empty($errors)){
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
							$issuenode->addURL($urlObj->urlid, "");

							$USER = $currentUser;

						$i++;
					}
				}

				echo '<script type=\'text/javascript\'>';
				if ($isRemote === false) {
					if (isset($handler) && $handler != "") {
						echo "window.opener.".$handler."('".$issuenode->nodeid."');";
					} else {
						echo "try { ";
						echo "var parent=window.opener.document; ";
						echo "if (window.opener && window.opener.loadSelecteditemNew) {";
						echo "	  window.opener.loadSelecteditemNew('".$issuenode->nodeid."','".$issuenode->name."'); }";
						echo 'else {';
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$issuenode->nodeid.'"; }';
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

				echo '</script>';

				//include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
				die;
 			} else {
  	           array_push($errors, $LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE." ".$issuenode->message);
			}
		}
    } else {
		if ($clonenodeid != "") {
			$clone = getNode($clonenodeid);
			$issue = $clone->name;
			$desc = $clone->description;
			$private = $clone->private;

			if(isset($clone->urls)) {
				$urls = $clone->urls;
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
		}
    }

	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    /**********************************************************************************/
?>

<script type="text/javascript">
	var noResources = <?php if (is_countable($resourceurlarray)) { echo count($resourceurlarray);} else {echo 0;}?>;

	function init() {
		$('dialogheader').insert('<?php echo $LNG->FORM_ISSUE_TITLE_ADD; ?>');
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

			<form id="issueform" name="issueform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
				<input type="hidden" id="clonenodeid" name="clonenodeid" value="<?php echo $clonenodeid; ?>" />

				<div class="mb-3 row">
					<label for="image" class="col-sm-3 col-form-label">
						<?php echo $LNG->GROUP_FORM_PHOTO; ?>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="file" class="form-control" id="image" name="image" />
						<small><?php echo $LNG->GROUP_FORM_PHOTO_HELP; ?></small>
					</div>
				</div>

				<div class="mb-3 row">
					<label for="issue" class="col-sm-3 col-form-label">
						<span><?php echo $LNG->FORM_ISSUE_LABEL_SUMMARY; ?></span>
						<span class="active" onMouseOver="showFormHint('IssueSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="issue" name="issue" value="<?php echo( $issue ); ?>" />
					</div>
				</div>

				<?php insertDescription('IssueDesc'); ?>
				<?php insertPrivate('Private', $private); ?>

				<?php if ($isRemote) {
						insertResourceForm('RemoteURLs');
					} else {
						insertResourceForm('URLs');
					}
				?>

				<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
					<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
					<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="addissue" name="addissue">
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>