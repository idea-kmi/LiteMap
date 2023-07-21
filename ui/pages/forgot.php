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

    // check that user not already logged in
    if(isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
		exit();
    }
?>

<h1><?php echo $LNG->FORGOT_PASSWORD_TITLE; ?></h1>

<?php
    $errors = array();

    // check to see if form submitted
    if(isset($_POST["reset"])){
        $email = required_param("email",PARAM_TEXT);

        $u = new User();
        $u->setEmail($email);
        $user = $u->getByEmail();

        //check user exists
        if(!$user instanceof User || $user->getAuthType() != $CFG->AUTH_TYPE_EVHUB){
            array_push($errors,$LNG->FORGOT_PASSWORD_EMAIL_NOT_FOUND_ERROR);
        } else {
            //set validation code
            if($user->getInvitationCode() == ""){
                $user->setInvitationCode();
            }
            //send email
            $paramArray = array ($user->name,$CFG->homeAddress,$user->userid,$user->getInvitationCode());
            sendMail("resetpassword",$LNG->FORGOT_PASSWORD_EMAIL_SUMMARY,$user->getEmail(),$paramArray);
            echo $LNG->FORGOT_PASSWORD_EMAIL_SENT_MESSAGE;
            include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
            die;
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

<p><?php echo $LNG->FORGOT_PASSWORD_HEADER_MESSAGE; ?></p>

<form name="forgot" action="<?php echo $CFG->homeAddress; ?>ui/pages/forgot.php" method="post">
    <div class="formrow">
        <label class="formlabel" for="email"><?php echo $LNG->FORGOT_PASSWORD_EMAIL_LABEL; ?></label>
        <input class="forminput" id="email" name="email" size="30" value="">

    </div>
    <div class="formrow">
        <input class="formsubmit" type="submit" value="<?php echo $LNG->FORGOT_PASSWORD_SUBMIT_BUTTON; ?>" id="reset" name="reset">
    </div>

</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
