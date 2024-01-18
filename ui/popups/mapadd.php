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

	$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);
	$maptitle = optional_param("maptitle","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

	$media = optional_param("media","",PARAM_URL);
	$youtubeid = optional_param("youtubeid","",PARAM_ALPHANUMEXT);
	$vimeoid = optional_param("vimeoid","",PARAM_ALPHANUMEXT);
	$moviewidth = optional_param("moviewidth","480",PARAM_INT);
	$movieheight = optional_param("movieheight","320",PARAM_INT);

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
			if (!$mapview instanceof Hub_Error) {

				if ($_FILES['image']['error'] == 0) {
					$imagedir = $HUB_FLM->getUploadsNodeDir($mapnode->nodeid);

					$photofilename = uploadImageToFit('image',$errors,$imagedir);
					//if($photofilename == ""){
					//	$photofilename = $CFG->DEFAULT_ISSUE_PHOTO;
					//}
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

				if ($media != "") {
					$mapnode->updateNodeProperty('media', $media);
					$mimetype = getMimeType($media);
					$mapnode->updateNodeProperty('mediatype', $mimetype);
					if ($mimetype != "" && substr ($mimetype, 0, 5) == "video") {
						$mapnode->updateNodeProperty('moviesize', $moviewidth.":".$movieheight);
					}
				} else if ($youtubeid != "") {
					$mapnode->updateNodeProperty('youtubeid', $youtubeid);
					$mapnode->updateNodeProperty('mediatype', '');
					$mapnode->updateNodeProperty('moviesize', $moviewidth.":".$movieheight);
				} else if ($vimeoid != "") {
					$mapnode->updateNodeProperty('vimeoid', $vimeoid);
					$mapnode->updateNodeProperty('mediatype', '');
					$mapnode->updateNodeProperty('moviesize', $moviewidth.":".$movieheight);
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

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<?php
				if(!empty($errors)){
					echo "<div class='alert alert-danger'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
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

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="image">
                        <?php echo $LNG->MAP_IMAGE_LABEL; ?>
						<span class="required">*</span>
                    </label>
					<div class="col-sm-9">
						<input type="file" class="form-control" id="image" name="image" />
                        <small><?php echo $LNG->GROUP_FORM_PHOTO_HELP; ?></small>
					</div>
                </div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="maptitle">
						<?php echo $LNG->FORM_MAP_LABEL_SUMMARY; ?>
						<span class="active" onMouseOver="showFormHint('MapSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="maptitle" name="maptitle" value="<?php print $maptitle; ?>" />
					</div>
				</div>

				<?php insertDescription('MapDesc'); ?>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="background">
                        <?php echo $LNG->MAP_BACKGROUND_LABEL; ?>
                    </label>
					<div class="col-sm-9">
						<input type="file" class="form-control" id="background" name="background" />
                        <small><?php echo $LNG->MAP_BACKGROUND_HELP; ?></small>
					</div>
                </div>

				<hr />

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="media">
						<?php echo $LNG->MAP_MEDIA_LABEL; ?>
						<span class="active" onMouseOver="showFormHint('MapMedia', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="media" name="media" value="<?php print $media; ?>" />
					</div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="youtubeid">
						<?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_LABEL; ?>
						<span class="active" onMouseOver="showFormHint('MapImportYouTubeMedia', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
					</label>
					<div class="col-sm-9 d-flex flex-wrap gap-3">
						<button class="btn btn-primary" onclick="extractYouTubeElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_BUTTON; ?></button>
						<input type="text" class="form-control w-auto" id="youtubeid" name="youtubeid" value="<?php print $youtubeid; ?>" />
						<button class="btn btn-secondary" onclick="clearYouTubeElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_CLEAR; ?></button>
					</div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="vimeoid">
						<?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_LABEL; ?>
						<span class="active" onMouseOver="showFormHint('MapImportVimeoMedia', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
					</label>
					<div class="col-sm-9 d-flex flex-wrap gap-3">
						<button class="btn btn-primary" onclick="extractVimeoElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_BUTTON; ?></button>
						<input type="text" class="form-control w-auto" id="vimeoid" name="vimeoid" value="<?php print $vimeoid; ?>" />
						<button class="btn btn-secondary" onclick="clearVimeoElements(); return false;"><?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_CLEAR; ?></button>
					</div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="media">
						<?php echo $LNG->MAP_MOVIE_WIDTH_LABEL; ?>
						<span class="active" onMouseOver="showFormHint('MapMovieWidth', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="moviewidth" name="moviewidth" value="<?php print $moviewidth; ?>" />
					</div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="media">
						<?php echo $LNG->MAP_MOVIE_HEIGHT_LABEL; ?>
						<span class="active" onMouseOver="showFormHint('MapMovieHeight', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="movieheight" name="movieheight" value="<?php print $movieheight; ?>" />
					</div>
				</div>

				<hr />

				<?php
					if (isset($groupid) && $groupid != "") {
						insertPrivate('MapPrivateGroup', $private);
					} else {
						insertPrivate('MapPrivate', $private);
					}
				?>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="groupid">
						<?php echo $LNG->MAP_FORM_ADD_TO_GROUP; ?>
						<span class="active" onMouseOver="showFormHint('MapGroup', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
					</label>
					<div class="col-sm-9">						
						<select class="form-select" name="groupid" id="groupid" onchange="loadgroup();">
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
				</div>

                <div class="mb-3 row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
                        <input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
                        <input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="addmap" name="addmap" />
                    </div>
                </div>
			</form>
        </div>
    </div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>