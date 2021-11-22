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

    //if ($CFG->signupstatus == $CFG->SIGNUP_CLOSED) {
	//    header('Location: '.$CFG->homeAddress.'index.php');
	//  	return;
	//}

    $userid = trim(required_param("id",PARAM_ALPHANUMEXT));
    $key = trim(required_param("key",PARAM_TEXT));

	// check if user already logged in
    if(isset($USER->userid) && $USER->userid != $userid){
        header('Location: '.$CFG->homeAddress.'index.php');
		exit();
    }

	if(empty($userid) || empty($key)){
	    header('Location: '.$CFG->homeAddress.'index.php');
		exit();
	}

    include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));

	echo '<h1>'.$LNG->VALIDATION_COMPLETE_TITLE.'</h1>';

	$user = new User($userid);
	if ($user instanceof User && $user->validateRegistrationKey($key)) {
		$user = $user->load();

		// check if link already clicked and account validated.
		if ($user->isEmailValidated()) {
				echo '<p>'.$LNG->VALIDATION_SUCCESSFUL_LOGIN.'</p>';
		} else {
			if ($user->completeRegistration($key)) {
				echo '<p>'.$LNG->VALIDATION_SUCCESSFUL_LOGIN.'</p>';
			} else {
				echo '<p>'.$LNG->VALIDATION_FAILED.'</p>';
			}
		}
	} else {
		echo '<p>'.$LNG->VALIDATION_FAILED_INVALID.'</p>';
	}

    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>