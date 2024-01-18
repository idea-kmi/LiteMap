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

    if(!isset($USER->userid)){
        header('Location: index.php');
		exit();
    }

    $groupset = getMyAdminGroups();
    $groups = $groupset->groups;

	$countgroups = 0;
	if (is_countable($groups)) {
		$countgroups = count($groups);
	}

    if($countgroups == 0){
        echo $LNG->GROUP_FORM_NOT_GROUP_ADMIN_ANY;
        include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
        die;
    }

    $errors = array();

    $groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);

    //check user is an admin for the group.
    if($groupid != ""){
    	$group = getGroup($groupid);
        $group = $group->load();
        if(!$group->isgroupadmin($USER->userid)){
            echo $LNG->GROUP_FORM_NOT_GROUP_ADMIN;
            include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
            die;
        }

		if (isset($group)) {
			$groupname = stripslashes(optional_param("groupname",$group->name,PARAM_TEXT));
			$desc = optional_param("desc",$group->description,PARAM_HTML);
			$website = optional_param("website",$group->website,PARAM_URL);
			$newmembers = optional_param("newmembers","",PARAM_TEXT);

			$location = optional_param("location",$group->location,PARAM_ALPHANUM);
			$loccountry = optional_param("loccountry",$group->countrycode,PARAM_ALPHANUM);

			$countries = getCountryList();

			// set the group joining when first loading the page
			$isopenjoining = $group->isopenjoining;
		}

		// process the update if form submitted
		if(isset($_POST["updategroup"])){
			//get the group joining when saving the edit.
			$isopenjoining = optional_param("isopenjoining",'N',PARAM_ALPHA);

			$gu = new User($group->groupid);
			$gu = $gu->load();
			if ($groupname == ""){
				array_push($errors,$LNG->GROUP_FORM_NAME_ERROR);
			} else {
				$ge = new Group();
				$gee = $ge->groupNameExists($groupname,$group->groupid);
				if($gee instanceof Hub_Error){
					array_push($errors,$gee->message);
				} else {
					$gu->updateName($groupname);
					$gu->updateDescription($desc);
					$gu->updateWebsite($website);
					$gu->updateLocation($location,$loccountry);

					$ge->groupid = $group->groupid;
					$ge->updateIsOpenJoining($isopenjoining);

					if ($_FILES['photo']['error'] == 0) {
						$photofilename = uploadImageToFit('photo',$errors,$group->groupid);
						if($photofilename == ""){
							$photofilename = $CFG->DEFAULT_GROUP_PHOTO;
						}
						$gu->updatePhoto($photofilename);
					} else {
						if($gu->photo == ""){
							$gu->updatePhoto($CFG->DEFAULT_GROUP_PHOTO);
						}
					}
				}
			}

			if(empty($errors)){
				echo "<p>Group updated</p>";
			}

			//refresh loaded data
			$groupset = getMyAdminGroups();
			$groups = $groupset->groups;
			$group = getGroup($groupid);
		}
	}
	include($HUB_FLM->getCodeDirPath("ui/popuplib.php"));
?>

<script type="text/javascript">

	function init() {
		$('dialogheader').insert('<?php echo $LNG->GROUP_MANAGE_TITLE; ?>');
	}

	function loadgroup(){
		var groupid = $('groupid').options[$('groupid').selectedIndex].value;
		window.location.href = "?groupid="+groupid;
	}

	<?php if($groupid != ""){ ?>

	function admintoggle(user){
		var id = user.id.replace('admin-','');
		var service="removegroupadmin";
		if(user.checked){
			var service = "makegroupadmin";
		}

		var reqUrl = SERVICE_ROOT + "&method="+service+"&groupid=<?php echo $group->groupid;?>&userid="+id ;

		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
			}
		});
	}

	function deletemember(user){
		var id = user.id.replace('remove-','');
		var username = $('name-'+id).value;
		var answer = confirm("<?php echo $LNG->GROUP_FORM_REMOVE_MESSAGE_PART1;?> "+ username +" <?php echo $LNG->GROUP_FORM_REMOVE_MESSAGE_PART2; ?>");
		if(answer){
			//send request
			var reqUrl = SERVICE_ROOT + "&method=removegroupmember&groupid=<?php echo $group->groupid;?>&userid="+id ;
			new Ajax.Request(reqUrl, { method:'get',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}
					$('member-'+id).remove();
				}
			});

		} else {
			//uncheck
			$('remove-'+id).checked = false;
		}
	}

	function rejectpendingmember(user){
		var id = user.id.replace('reject-','');
		var username = $('pendingname-'+id).value;
		var answer = confirm("<?php echo $LNG->GROUP_FORM_REJECT_MESSAGE_PART1;?> "+ username +" <?php echo $LNG->GROUP_FORM_REJECT_MESSAGE_PART2; ?>");
		if(answer){
			//send request
			var reqUrl = SERVICE_ROOT + "&method=rejectgroupmemberjoin&groupid=<?php echo $group->groupid;?>&userid="+id ;
			new Ajax.Request(reqUrl, { method:'get',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}
					$('pendingmember-'+id).remove();
				}
			});

		} else {
			//uncheck
			$('reject-'+id).checked = false;
		}
	}

	function approvependingmember(user){
		var id = user.id.replace('approve-','');
		var username = $('pendingname-'+id).value;
		var answer = confirm("<?php echo $LNG->GROUP_FORM_APPROVE_MESSAGE_PART1;?> "+ username +" <?php echo $LNG->GROUP_FORM_APPROVE_MESSAGE_PART2; ?>");
		if(answer){
			//send request
			var reqUrl = SERVICE_ROOT + "&method=approvegroupmemberjoin&groupid=<?php echo $group->groupid;?>&userid="+id ;
			new Ajax.Request(reqUrl, { method:'get',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}

					// refresh page.
					window.location.reload();
					//$('pendingmember-'+id).remove();
				}
			});
		} else {
			//uncheck
			$('approve-'+id).checked = false;
		}
	}

	function deletegroup(){
		var answer = confirm("Are you sure you want to delete the group '<?php echo $group->name;?>'?");
		if(answer){
			//send request
			var reqUrl = SERVICE_ROOT + "&method=deletegroup&groupid=<?php echo $group->groupid;?>";

			new Ajax.Request(reqUrl, { method:'get',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}
					alert("Group '<?php echo $group->name;?>' has now been deleted.");
					window.location.href = "groupedit.php";
				}
			});

		}
	}

	function checkForm() {
		var checkname = ($('groupname').value).trim();
		if (checkname == ""){
			alert("<?php echo $LNG->GROUP_FORM_NAME_ERROR; ?>");
			return false;
		}

		$('addgroupform').style.cursor = 'wait';
		return true;
	}

	<?php } ?>

	window.onload = init;

</script>

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

			<div class="mb-3 d-flex gap-3">
				<label class="col-sm-3 col-form-label" for="groupid">Group to manage:</label>

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

				<?php if ($groupid != "") { ?>
					<input class="btn btn-danger" type="button" value="<?php echo $LNG->FORM_BUTTON_DELETE_GROUP; ?>" id="deletegroupbtn" name="deletegroupbtn" onclick="deletegroup();"/>
				<?php } ?>
			</div>

			<?php
				// if a groupid is not selected then end here
				if ($groupid == ""){ ?>
					<div class="mb-3 row">
                    	<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
							<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CLOSE; ?>" onclick="window.close();"/>
						</div>
					</div>
					<?php include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php")); 
					die; 
				}
			?>

			<hr class="hrline" />

			<form name="editgroup" action="" method="post" enctype="multipart/form-data">
				<div class="mb-3 row">
					<label  class="col-sm-3 col-form-label" for="groupname">
						<?php echo $LNG->GROUP_FORM_NAME; ?>
                        <span class="active" onMouseOver="showFormHint('GroupSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
                        </span>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="groupname" name="groupname" value="<?php echo( $groupname ); ?>" />
					</div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label"><?php echo $LNG->PROFILE_PHOTO_CURRENT_LABEL; ?></label>
					<div class="col-sm-9">
						<img class="img-fluid" src="<?php print $group->photo; ?>" alt="photo for <?php print $groupname; ?>" />
					</div>
				</div>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="photo"><?php echo $LNG->PROFILE_PHOTO_REPLACE_LABEL; ?></label>
					<div class="col-sm-9">
						<input class="form-control" type="file" id="photo" name="photo" />
                        <small><?php echo $LNG->GROUP_FORM_PHOTO_HELP; ?></small>
					</div>
				</div>

				<?php insertDescription('GroupDesc'); ?>

				<div class="mb-3 row">
					<label  class="col-sm-3 col-form-label" for="website">
						<?php echo $LNG->GROUP_FORM_WEBSITE; ?>						
                        <span class="active" onMouseOver="showFormHint('GroupWebsite', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
                        </span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website)) {print $website;} ?>" />
					</div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="isopenjoining"><?php echo $LNG->GROUP_FORM_IS_JOINING_OPEN_LABEL; ?></label>
					<div class="col-sm-9">                   
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="Y" id="isopenjoining" name="isopenjoining" <?php if($isopenjoining == "Y"){ echo ' checked="true"'; } ?> />
                            <label class="form-check-label" for="followsendemail">
                                <?php echo $LNG->GROUP_FORM_IS_JOINING_OPEN_HELP; ?>
                            </label>
                        </div>
					</div>
				</div>

                <div class="mb-3 row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
                        <input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="updategroup" name="updategroup" />
					</div>
				</div>
			</form>

			<hr class="hrline" />

			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="members"><?php echo $LNG->GROUP_FORM_MEMBERS_CURRENT; ?></label>
				<div id="members" style="float:left;margin-left:5px;width:500px;">
				<?php
					$userset = $group->members;
					$users = $userset->users;
					$count = 0;
					if (is_countable($users)) {
						$count = count($users);
					}
					if($count == 0){
						echo $LNG->GROUP_FORM_NO_MEMBERS;
					} else {
						echo "<table class='table' cellspacing='0' cellpadding='3' border='0'>";
						echo "<tr>";
						echo '<th width="200">'.$LNG->GROUP_FORM_NAME_LABEL.'</th>';
						echo '<th width="260">'.$LNG->GROUP_FORM_DESC_LABEL.'</th>';
						echo '<th width="20" class="table-th-center">'.$LNG->GROUP_FORM_ISADMIN_LABEL.'</th>';
						echo '<th width="20" class="table-th-center">'.$LNG->GROUP_FORM_REMOVE_LABEL.'</th>';

						echo "</tr>";
						foreach($users as $u){
							echo "<tr id='member-".$u->userid."'>";
							echo "<td>";
							echo '<input type="hidden" id="name-'.$u->userid.'" value="'.addSlashes($u->name).'">';
							//username
							if($u->name == ""){
								echo $u->getEmail();
							} else {
								echo '<a target="_blank" href='.$CFG->homeAddress.'user.php?userid='.$u->userid.'>'.$u->name.'</a>';
							}
							echo "</td>";
							echo "<td>";
							//desc
							if($u->description != ""){
								echo $u->description;
							}
							echo "</td>";
							echo "<td align='center'>";
							//if user is admin
							$disabled = "";
							if($u->userid == $USER->userid){
								$disabled = "disabled";
							}
							$checked = "";
							if($group->isgroupadmin($u->userid)){
								$checked = "checked='checked'";
							}
							echo "<input type='checkbox' id='admin-".$u->userid."' name='admin-".$u->userid."' ".$checked." ".$disabled." onchange='admintoggle(this);'>";
							echo "</td>";
							echo "<td align='center'>";
							//delete user field
							$disabled = "";
							if($u->userid == $USER->userid){
								$disabled = "disabled";
							}
							echo "<input type='checkbox' id='remove-".$u->userid."' name='remove-".$u->userid."' onchange='deletemember(this);' ".$disabled.">";
							echo "</td>";
							echo "</tr>";
						}
						echo "</table>";
					}
				?>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="members"><?php echo $LNG->GROUP_FORM_MEMBERS_PENDING; ?></label>
				<div id="members" style="float:left;margin-left:5px;width:500px;">
				<?php
					//$group = $group->loadpendingmembers();
					if (isset($group->pendingmembers)) {
						$userset = $group->pendingmembers;
						if (!$userset instanceof Hub_Error) {
							$users = $userset->users;
							$countusers = 0;
							if (is_countable($users)) {
								$countusers = count($users);
							}
							if($countusers == 0){
								echo $LNG->GROUP_FORM_NO_PENDING;
							} else {
								echo "<table class='table' cellspacing='0' cellpadding='3' border='0'>";
								echo "<tr>";
								echo '<th width="200">'.$LNG->GROUP_FORM_NAME_LABEL.'</th>';
								echo '<th width="260">'.$LNG->GROUP_FORM_DESC_LABEL.'</th>';
								echo '<th width="20" class="table-th-center">'.$LNG->GROUP_FORM_APPROVE_LABEL.'</th>';
								echo '<th width="20" class="table-th-center">'.$LNG->GROUP_FORM_REJECT_LABEL.'</th>';

								echo "</tr>";
								foreach($users as $u){
									echo "<tr id='pendingmember-".$u->userid."'>";
									echo "<td>";
									//username
									echo '<input type="hidden" id="pendingname-'.$u->userid.'" value="'.addSlashes($u->name).'">';
									if($u->name == ""){
										echo $u->getEmail();
									} else {
										echo '<a target="_blank" href='.$CFG->homeAddress.'user.php?userid='.$u->userid.'>'.$u->name.'</a>';
									}
									echo "</td>";
									echo "<td>";
									//desc
									if($u->description != ""){
										echo $u->description;
									}
									echo "</td>";
									echo "<td align='center'>";
									//if user is admin
									$disabled = "";
									if($u->userid == $USER->userid){
										$disabled = "disabled";
									}
									$checked = "";
									if($group->isgroupadmin($u->userid)){
										$checked = "checked='checked'";
									}
									echo "<input type='checkbox' id='approve-".$u->userid."' name='approve-".$u->userid."' ".$checked." ".$disabled." onchange='approvependingmember(this);'>";
									echo "</td>";
									echo "<td align='center'>";
									//delete user field
									$disabled = "";
									if($u->userid == $USER->userid){
										$disabled = "disabled";
									}
									echo "<input type='checkbox' id='reject-".$u->userid."' name='reject-".$u->userid."' onchange='rejectpendingmember(this);' ".$disabled.">";
									echo "</td>";
									echo "</tr>";
								}
								echo "</table>";
							}
						} else {
							echo $LNG->GROUP_FORM_NO_PENDING;
						}
					} else {
						echo $LNG->GROUP_FORM_NO_PENDING;
					}
				?>
				</div>
			</div>
			<div class="mb-3 row">
				<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
					<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
				</div>
			</div>
        </div>
    </div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>