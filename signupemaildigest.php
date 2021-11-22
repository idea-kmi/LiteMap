<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2018 The Open University UK                                   *
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
    include_once("config.php");

	// check if user already logged in
    if(isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
        return;
    }

	if ($CFG->RECENT_EMAIL_SENDING_ON == false) {
		header('Location: '.$CFG->homeAddress.'index.php');
        return;
	}

    $userid = trim(required_param("id",PARAM_TEXT));
    $key = trim(required_param("key",PARAM_TEXT));

	if(empty($userid) || empty($key)){
	    header('Location: '.$CFG->homeAddress.'index.php');
	  	return;
	}

    include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));

	echo '<div style="float:left;margin:20px;">';
	echo '<h1>Email Digest Confirmation</h1>';

	$user = new User($userid);
	if ($user instanceof User) {
		$user->load();

		// Get GDPR key and check it matches
		$params = array();
		$sql = "Select GDPRKey from Users where UserID = ?";
		$params[0] = $user->userid;
		$resArray = $DB->select($sql, $params);
		$array = $resArray[0];
		$gdprKey = $array["GDPRKey"];

		if (isset($gdprKey) && $gdprKey != "" && $gdprKey == $key) {
			if ($user->status == 0) {
				if ($user->recentactivitiesemail === 'Y') {
					echo '<p>You have already signed up to our Email Digest of recent activities.<br><br>To change your mind, please go to your <a href="'.$CFG->homeAddress.'ui/pages/profile.php">profile page</a> and deselect the \'Email Digest\' option.</p>';
				} else {
					$user->updateRecentActivitiesEmail('Y');
					echo '<p>You have now been signed up to our Email Digest of recent activities.<br><br> To change your mind, please go to your <a href="'.$CFG->homeAddress.'ui/pages/profile.php">profile page</a> and deselect the \'Email Digest\' option.</p>';
				}
			} else {
				echo '<p>Your account is not active or has not had it\'s email address verified yet.</p>';
			}
		} else {
			echo '<p>Email Digest link invalid</p>';
		}
	} else {
		echo '<p>Email Digest Confirmation Failed</p>';
	}
	echo '</div>';

    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>