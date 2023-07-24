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

    $errors = array();

    $groupname = optional_param("groupname","",PARAM_TEXT);
    $desc = optional_param("desc","",PARAM_HTML);
    $website = optional_param("website","",PARAM_TEXT);
    $members = optional_param("members","",PARAM_TEXT);
	$isopenjoining = optional_param("isopenjoining","N",PARAM_ALPHA);

    if(isset($_POST["creategroup"])){
		if ($groupname == ""){
			array_push($errors, $LNG->GROUP_FORM_NAME_ERROR);
		}

		if(empty($errors)){
            $group = addGroup($groupname);
            if($group instanceof Hub_Error){
                array_push($errors,$group->message);
            } else {
            	//group is a new user Ha!

                $gu = new User($group->groupid);
                $gu = $gu->load();
                $gu->updateDescription($desc);
                $gu->updateWebsite($website);

				$group->updateIsOpenJoining($isopenjoining);

			    if ($_FILES['photo']['error'] == 0) {
					$photofilename = uploadImageToFit('photo',$errors,$group->groupid);
					if($photofilename == ""){
						$photofilename = $CFG->DEFAULT_GROUP_PHOTO;
					}
					$gu->updatePhoto($photofilename);
				}

                echo "<p>Group created</p>";

                // go through all the members and see if they match existing users if so add them to the group
                // show results back to user so they know who has/hasn't already got an account
                $memberArr = split(',',trim($members));
				$countmembers = 0;
				if (is_countable($memberArr)) {
					$countmembers = count($memberArr);
				}
                if(trim($members) != "" && $countmembers > 0 ){
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
                }

				echo '<script type=\'text/javascript\'>';
				echo "window.opener.location.reload(true);";
				echo "window.close();";
				echo '</script>';
				die;

                //echo "<p>Visit the <a href='javascript:closeGroupDialog(".$gu->userid.");'>group page</a>.</p>";
                //include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
                //die;
            }
        }
    }

	include($HUB_FLM->getCodeDirPath("ui/popuplib.php"));
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
                    $('dialogheader').insert('<?php echo $LNG->GROUP_CREATE_TITLE; ?>');
                }
                function closeGroupDialog(groupid){
                    try {
                        var newurl = URL_ROOT + "group.php?groupid="+groupid;
                        window.opener.location.href = newurl;
                    } catch(err) {
                        //do nothing
                    }
                    window.close();
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
                window.onload = init;
            </script>

            <?php insertFormHeaderMessage(); ?>

            <form name="addgroupform" action="" method="post" enctype="multipart/form-data" onsubmit="return checkForm();">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="photo">
                        <?php echo $LNG->GROUP_FORM_PHOTO; ?>
                        <span class="active" onMouseOver="showFormHint('GroupPhoto', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
                        </span>
                    </label>
					<div class="col-sm-9">
						<input type="file" class="form-control" id="photo" name="photo" />
                        <small><?php echo $LNG->GROUP_FORM_PHOTO_HELP; ?></small>
					</div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="groupname">
                        <?php echo $LNG->GROUP_FORM_NAME; ?>
                        <span class="active" onMouseOver="showFormHint('GroupSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
                        </span>
						<span class="required">*</span>
                    </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="groupname" name="groupname" value="<?php print $groupname; ?>" />
					</div>
                </div>

                <?php insertDescription('GroupDesc'); ?>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="website">
                        <?php echo $LNG->GROUP_FORM_WEBSITE; ?>
                        <span class="active" onMouseOver="showFormHint('GroupWebsite', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
                        </span>
                    </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="website" name="website" value="<?php print $website; ?>" />
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
                        <input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
                        <input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="creategroup" name="creategroup" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>
