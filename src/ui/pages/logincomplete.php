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
    //if(isset($USER->userid) || $CFG->signupstatus == $CFG->SIGNUP_CLOSED){
    //    header('Location: '.$CFG->homeAddress.'index.php');
    //    return;
    //}

    $id = trim(required_param("id",PARAM_TEXT));
    $key = trim(required_param("key",PARAM_TEXT));
    $referrer = optional_param("referrer",$CFG->homeAddress."index.php",PARAM_URL);
	if ($referrer == "") {
		$referrer = $CFG->homeAddress."index.php";
	}

	if(empty($id) || empty($key)){
	    header('Location: '.$CFG->homeAddress.'index.php');
		exit();
	}

	$auth = new UserAuthentication($id);
	$userauth = $auth->load();

    $errors = array();

	if ($userauth instanceof UserAuthentication && $userauth->validateRegistrationKey($key)) {
		if ($userauth->completeVerification($key)) {
			$user = new User($userauth->getUserID());
			if ($user instanceof User) {
				$status = $user->getStatus();
				if ($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED){
					createSession($user);
					header('Location: '. $referrer);
					die;
				} else if ($status == $CFG->USER_STATUS_UNVALIDATED) {
					array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED);
				} else if ($status == $CFG->USER_STATUS_UNAUTHORIZED) {
					array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNAUTHORIZED);
				} else if ($status == $CFG->USER_STATUS_SUSPENDED) {
					array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_SUSPENDED);
				}
			} else {
				array_push($errors, $LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_USER);
			}
		} else {
			array_push($errors, $LNG->LOGIN_EXTERNAL_COMPLETE_FAILED);
		}
	} else {
		array_push($errors, $LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_INVALID);
	}

    include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));

	echo '<h1>'.$LNG->LOGIN_EXTERNAL_COMPLETE_TITLE.'</h1>';

	if(!empty($errors)){
		//echo "<div>".$LNG->FORM_ERROR_MESSAGE_LOGIN."<br><br>";
		echo '<div style="width:500px;">';
		foreach ($errors as $error){
			echo $error.'<br><br>';
		}
		echo '</div>';
	}

    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>