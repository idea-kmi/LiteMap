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

	// check if user already logged in
    if(isset($USER->userid) || $CFG->signupstatus == $CFG->SIGNUP_CLOSED){
        header('Location: '.$CFG->homeAddress.'index.php');
		exit();
    }

    $userid = trim(required_param("userid",PARAM_ALPHANUMEXT));

    $id = trim(required_param("id",PARAM_TEXT));
    $key = trim(required_param("key",PARAM_TEXT));
    $referrer = optional_param("referrer",$CFG->homeAddress."index.php",PARAM_URL);

	if(empty($userid)){
	    header('Location: '.$CFG->homeAddress.'index.php');
		exit();
	}

	if(empty($id) || empty($key)){
	    header('Location: '.$CFG->homeAddress.'index.php');
		exit();
	}

	if ($referrer == "") {
		$referrer = $CFG->homeAddress."index.php";
	}

    $errors = array();

	$auth = new UserAuthentication($id);
	$userauth = $auth->load();

	$user = new User($userid);
	$user = $user->load();

	// If the authentication account does not belong to the user account, abort.
	if (strcmp($userauth->getUserID(),$user->userid) != 0){
		array_push($errors, $LNG->LOGIN_EXTERNAL_REGISTER_COMPLETE_FAILED);
	} else {
		if ($user instanceof User && $user->validateRegistrationKey($key)) {
			if ($user->completeRegistration($key)) {
				if ($userauth instanceof UserAuthentication && $userauth->validateRegistrationKey($key)) {
					if ($userauth->completeVerification($key)) {
						$status = $user->getStatus();
						if ($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED){
							// send completion email to user
							$paramArray = array ($user->name,$CFG->SITE_TITLE,$LNG->WELCOME_REGISTER_OPEN_BODY);
							sendMail("welcome",$LNG->WELCOME_REGISTER_OPEN_SUBJECT,$user->getEmail(),$paramArray);

							createSession($user);
							header('Location: '. $referrer);
							exit();
						} else if ($status == $CFG->USER_STATUS_UNVALIDATED) {
							array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED);
						} else if ($status == $CFG->USER_STATUS_UNAUTHORIZED) {
							array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNAUTHORIZED);
						} else if ($status == $CFG->USER_STATUS_SUSPENDED) {
							array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_SUSPENDED);
						}
					} else {
						array_push($errors, $LNG->LOGIN_EXTERNAL_COMPLETE_FAILED);
					}
				} else {
					array_push($errors, $LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_INVALID);
				}
			} else {
				echo '<p>'.$LNG->REGISTRATION_FAILED_INVALID.'</p>';
			}
		} else {
			array_push($errors, $LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_USER);
		}
	}

    include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));

	echo '<h1>'.$LNG->LOGIN_EXTERNAL_COMPLETE_TITLE.'</h1>';

	if(!empty($errors)){
		echo '<div style="width:500px;">';
		foreach ($errors as $error){
			echo $error.'<br><br>';
		}
		echo '</div>';
	}

    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>