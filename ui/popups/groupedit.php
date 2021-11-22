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

				// go through all the members and see if they match existing users if so add them to the group
				// show results back to user so they know who has/hasn't already got an account
				/*$memberArr = split(',',trim($newmembers));
				$countmembers = 0;
				if (is_countable($memberArr)) {
					$countmembers = count($memberArr);
				}
				if(trim($newmembers) != "" && $countmembers > 0 ){
					echo "<ul>";
					foreach($memberArr as $member){
						$member = trim($member);
						//check valid email address
						if(!validEmail($member)){
							echo "<li>".$member." is not a valid email address</li>";
						} else {
							//find out if existing user
							$u = new User();
							$u->setEmail($member);
							$user = $u->getByEmail();
							if($user instanceof User){
								//user already exists in db
								addGroupMember($group->groupid,$user->userid);
                                echo "<li>".$member." ".$LNG->GROUP_FORM_IS_MEMBER."</li>";

							} else {
								//user doesn't exist so create user and send them an invite code
								$newU = new User();
								$names = split('@',$member);
								$newU->add($member,$names[0],"","",'N',$CFG->AUTH_TYPE_EVHUB,"","","");
								$newU->setInvitationCode();
								addGroupMember($group->groupid,$newU->userid);
                                echo "<li>".$member." ".$LNG->GROUP_FORM_NOT_MEMBER."</li>";
							}
						}
					}
					echo "</ul>";
				}*/
			}

			//refresh loaded data
			$groupset = getMyAdminGroups();
			$groups = $groupset->groups;
			$group = getGroup($groupid);
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

<div class="formrow">
    <label class="formlabelbig" style="margin-top:3px;" for="groupid">Group to manage:</label>

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

	<?php if ($groupid != "") { ?>
    	<input style="margin-left:20px;" type="button" value="<?php echo $LNG->FORM_BUTTON_DELETE_GROUP; ?>" id="deletegroupbtn" name="deletegroupbtn" onclick="deletegroup();"/>
    <?php } ?>
</div>


<?php
    // if a groupid is not selected then end here
    if ($groupid == ""){ ?>
		<div class="hgrformrow">
			<input style="float:left;margin-left:10px;margin-top:20px;" type="button" value="<?php echo $LNG->FORM_BUTTON_CLOSE; ?>" onclick="window.close();"/>
		</div>
        <?php include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
        die;
    }
?>

<hr class="hrline" />

<form name="editgroup" action="" method="post" enctype="multipart/form-data">
    <div class="hgrformrow">
		<label  class="formlabelbig" for="groupname"><span style="vertical-align:top"><?php echo $LNG->GROUP_FORM_NAME; ?></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
			<span class="active" onMouseOver="showFormHint('GroupSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="groupname" name="groupname" value="<?php echo( $groupname ); ?>" />
	</div>

    <div class="hgrformrow">
    	<label class="formlabelbig" for="photo"><?php echo $LNG->PROFILE_PHOTO_CURRENT_LABEL; ?></label>
    	<img class="forminput" src="<?php print $group->photo; ?>"/>
    </div>
    <div class="formrow">
    	<label class="formlabelbig" for="photo"><?php echo $LNG->PROFILE_PHOTO_REPLACE_LABEL; ?></label>
    	<input class="forminput" type="file" id="photo" name="photo" size="40">
    </div>
	<div class="hgrformrow" style="padding-top:3px;">
		<label class="formlabelbig" style="height:30px;">&nbsp;</label>
		<div class="forminput"><?php echo $LNG->GROUP_FORM_PHOTO_HELP; ?></div>
	</div>

	<?php insertDescription('GroupDesc'); ?>

    <div class="hgrformrow">
		<label  class="formlabelbig" for="website"><span style="vertical-align:top"><?php echo $LNG->GROUP_FORM_WEBSITE; ?></span>
			<span class="active" onMouseOver="showFormHint('GroupWebsite', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		</label>
        <input class="forminput hgrwide" type="text" id="website" name="website" value="<?php if(isset($website)) {print $website;} ?>">
    </div>

    <div class="formrow">
        <label class="formlabelbig" style="margin-top:11px;" for="isopenjoining"><?php echo $LNG->GROUP_FORM_IS_JOINING_OPEN_LABEL; ?></label>
        <input style="float:left;margin-top:13px;" type="checkbox" class="forminput" id="isopenjoining" name="isopenjoining" value="Y"
        <?php
            if($isopenjoining == "Y"){
                echo ' checked="true"';
            }
        ?>
        >
        <span style="float:left;margin-top:11px;width:500px;margin-left:5px;"><?php echo $LNG->GROUP_FORM_IS_JOINING_OPEN_HELP; ?></span>
    </div>

    <!-- div class="hgrformrow">
		<label class="formlabelbig" for="location"><?php echo $LNG->GROUP_FORM_LOCATION; ?></label>
		<input class="forminput" id="location" name="location" style="width:160px;" value="<?php echo $location; ?>">
		<select id="loccountry" name="loccountry" style="margin-left: 5px;width:160px;">
	        <option value="" ><?php echo $LNG->PROFILE_COUNTRY; ?></option>
	        <?php
	            foreach($countries as $code=>$c){
	                echo "<option value='".$code."'";
	                if($code == $loccountry){
	                    echo " selected='true'";
	                }
	                echo ">".$c."</option>";
	            }
	        ?>
	    </select>
	</div -->

    <div class="hgrformrow">
		<label class="formlabel">&nbsp;</label>
        <input class="formsubmit" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="updategroup" name="updategroup"/>
    </div>
</form>

<hr class="hrline" />

<div class="hgrformrow">
	<label class="formlabelbig" for="members"><?php echo $LNG->GROUP_FORM_MEMBERS_CURRENT; ?></label>
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

<div class="hgrformrow">
	<label class="formlabelbig" for="members"><?php echo $LNG->GROUP_FORM_MEMBERS_PENDING; ?></label>
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
<div class="hgrformrow">
	<input style="float:left;margin-left:10px;margin-top:20px;" type="button" value="<?php echo $LNG->FORM_BUTTON_CLOSE; ?>" onclick="window.close();"/>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>