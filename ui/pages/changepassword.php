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

	include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));

    // check that user logged in
    if(!isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
		exit();
    }

	 /**
	  * Check that the User has a Evidence Hub account not an external one. I
	  * If an external one, they have got to this page in an unorthodox way, so send them to the index
	  */
    if ($USER->getAuthType() != $CFG->AUTH_TYPE_EVHUB) {
        header('Location: '.$CFG->homeAddress.'index.php');
		exit();
	}

    echo "<h1>".$LNG->CHANGE_PASSWORD_TITLE."</h1>";

    $errors = array();

    $fromreset = optional_param("fromreset","N",PARAM_ALPHA);
    $currentpassword = optional_param("currentpassword","",PARAM_TEXT);
    $newpassword = optional_param("newpassword","",PARAM_TEXT);
    $confirmnewpassword = optional_param("confirmnewpassword","",PARAM_TEXT);

    $update = optional_param("update","",PARAM_TEXT);

	$u = new User($USER->userid);
	$user = $u->load();

    if(isset($_POST["update"])){
		if ($fromreset == 'N' && $currentpassword == "") {
            array_push($errors,$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_ERROR);
		}
		if ($newpassword == "") {
            array_push($errors,$LNG->CHANGE_PASSWORD_NEW_PASSWORD_ERROR);
		}
		if (strlen($newpassword) < 8){
			array_push($errors, $LNG->LOGIN_PASSWORD_LENGTH);
		}
		if ($confirmnewpassword == "") {
            array_push($errors,$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_ERROR);
		}

		if(empty($errors)) {

			if ($fromreset == 'N' && !$user->validPassword($currentpassword)) {
				array_push($errors,$LNG->CHANGE_PASSWORD_PASSWORD_INCORRECT_ERROR);
			} else {
				// update password
				if($newpassword != ""){
					if ($newpassword != $confirmnewpassword){
						array_push($errors,$LNG->CHANGE_PASSWORD_CONFIRM_MISSMATCH_ERROR);
					} else {
						$user->updatePassword($newpassword);
					}
				} else if($user->getInvitationCode() != "" && $newpassword == ""){
					array_push($errors,$LNG->CHANGE_PASSWORD_PROVIDE_PASSWORD_ERROR);
				}

				if(empty($errors)){
					//reset validation code
					$user->resetInvitationCode();
					echo $LNG->CHANGE_PASSWORD_SUCCESSFUL_UPDATE;

					echo '<br><br><a href="'.$CFG->homeAddress.'ui/pages/profile.php">'.$LNG->CHANGE_PASSWORD_BACK_TO_PROFILE.'</a> | <a href="'.$CFG->homeAddress.'user.php?userid='.$USER->userid.'#home-list">'.$LNG->CHANGE_PASSWORD_GO_TO_MY_HOME.'</a>';

					include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
					die;
				}

				$USER = new User($_SESSION["session_userid"]);
				$USER = $USER->load();
			}
		}
    }
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

<?php if ($update == 'y') { ?>
<p style="color:red"><?php echo $LNG->LOGIN_PASSWORD_LENGTH_UPDATE; ?></p>
<?php } ?>

<p><span class="required">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS; ?></p>
<form name="changepassword" action="<?php echo $CFG->homeAddress; ?>ui/pages/changepassword.php" method="post" enctype="multipart/form-data">

	<input type="hidden" id="fromreset" name="fromreset" value="<?php echo $fromreset; ?>" />


	<?php if ($fromreset == 'N') { ?>
		<div class="formrow">
			<label class="formlabelbig" for="currentpassword"><?php echo $LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_LABEL; ?><span class="required">*</span></label>
			<input class="forminput" id="currentpassword" name="currentpassword" type="password"  size="30" value="">
	   </div><br><br>
	<?php } ?>

    <div class="formrow">
        <label class="formlabelbig" for="newpassword"><?php echo $LNG->CHANGE_PASSWORD_NEW_PASSWORD_LABEL; ?><span class="required">*</span></label>
        <input class="forminput" id="newpassword" name="newpassword" type="password"  size="30" value="<?php echo $newpassword; ?>">
    </div>

    <div class="formrow">
        <label class="formlabelbig" for="confirmnewpassword"><?php echo $LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_LABEL; ?>
        <span class="required">*</span></label>
        <input class="forminput" id="confirmnewpassword" name="confirmnewpassword" type="password" size="30" value="<?php echo $confirmnewpassword; ?>">
    </div>

	<div class="formrow">
        <input class="formsubmit" type="submit" value="<?php echo $LNG->CHANGE_PASSWORD_UPDATE_BUTTON; ?>" id="update" name="update">
    </div>

</form>


<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>