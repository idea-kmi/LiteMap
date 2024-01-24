<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2013-2023 The Open University UK                              *
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

    include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));

    if($USER == null || $USER->getIsAdmin() == "N"){
        echo "<div class='errors'>.".$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE."</div>";
        include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
        die;
	}

    $errors = array();

    if(isset($_POST["deleteuser"])){
		$userid = optional_param("userid","",PARAM_ALPHANUMEXT);
    	if ($userid != "") {
    		$user = new User($userid);
			// delete user and any upload folder
			if (!adminDeleteUser($userid)) {
				echo $LNG->ADMIN_MANAGE_USERS_DELETE_ERROR." ".$userid;
			}
    	} else {
            array_push($errors,$LNG->SPAM_USER_ADMIN_ID_ERROR);
    	}
    } else if(isset($_POST["suspenduser"])){
		$userid = optional_param("userid","",PARAM_ALPHANUMEXT);
    	if ($userid != "") {
    		$user = new User($userid);
	   		$user->updateStatus($CFG->USER_STATUS_SUSPENDED);
    	} else {
            array_push($errors,$LNG->SPAM_USER_ADMIN_ID_ERROR);
    	}
    } else if(isset($_POST["restoreuser"])){
		$userid = optional_param("userid","",PARAM_ALPHANUMEXT);
    	if ($userid != "") {
    		$user = new User($userid);
	   		$user->updateStatus($CFG->USER_STATUS_ACTIVE);
    	} else {
            array_push($errors,$LNG->SPAM_USER_ADMIN_ID_ERROR);
    	}
    }

	$us = getUsersByStatus($CFG->USER_STATUS_REPORTED, 0,-1,'name','ASC','long');
    $users = $us->users;

	$count = 0;
	if (is_countable($users)) {
		$count = count($users);
	}
    for ($i=0; $i<$count;$i++) {
    	$user = $users[$i];
    	$reporterid = getSpamReporter($user->userid);
    	if ($reporterid != false) {
    		$reporter = new User($reporterid);
    		$reporter = $reporter->load();
    		$user->reporter = $reporter;
    	}
    }

	$us2 = getUsersByStatus($CFG->USER_STATUS_SUSPENDED, 0,-1,'name','ASC','long');
    $userssuspended = $us2->users;

	$count2 = 0;
	if (is_countable($userssuspended)) {
		$count2 = count($userssuspended);
	}
    for ($i=0; $i<$count2;$i++) {
    	$user = $userssuspended[$i];
    	$reporterid = getSpamReporter($user->userid);
    	if ($reporterid != false) {
    		$reporter = new User($reporterid);
    		$reporter = $reporter->load();
    		$user->reporter = $reporter;
    	}
    }
?>

<script type="text/javascript">
	function getParentWindowHeight(){
		var viewportHeight = 900;
		if (window.opener.innerHeight) {
			viewportHeight = window.opener.innerHeight;
		} else if (window.opener.document.documentElement && document.documentElement.clientHeight) {
			viewportHeight = window.opener.document.documentElement.clientHeight;
		} else if (window.opener.document.body)  {
			viewportHeight = window.opener.document.body.clientHeight;
		}
		return viewportHeight;
	}

	function getParentWindowWidth(){
		var viewportWidth = 700;
		if (window.opener.innerHeight) {
			viewportWidth = window.opener.innerWidth;
		} else if (window.opener.document.documentElement && document.documentElement.clientHeight) {
			viewportWidth = window.opener.document.documentElement.clientWidth;
		} else if (window.opener.document.body)  {
			viewportWidth = window.opener.document.body.clientWidth;
		}
		return viewportWidth;
	}

	function viewSpamUserDetails(userid) {
		var width = window.screen.width - 400;
		var height = window.screen.height - 400;

		loadDialog('user', URL_ROOT+"user.php?userid="+userid, width, height);
	}

	function checkFormRestore(name) {
		var ans = confirm("<?php echo $LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART1; ?>\n\n"+name+"?\n\n<?php echo $LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART2; ?>\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormDelete(name) {
		var ans = confirm("<?php echo $LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART1; ?>\n\n"+name+"?\n\n<?php echo $LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART2; ?>\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormSuspend(name) {
		var ans = confirm("<?php echo $LNG->SPAM_USER_ADMIN_SUSPEND_CHECK_MESSAGE; ?>\n\n"+name+"?\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	window.onload = init;

</script>

<?php
	if(!empty($errors)){
		echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
		foreach ($errors as $error){
			echo "<li>".$error."</li>";
		}
		echo "</ul></div>";
	}
?>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">

			<h1 class="mb-3"><?php echo $LNG->SPAM_USER_ADMIN_TITLE; ?></h1>

			<div id="spamdiv">
				<h3><?php echo $LNG->SPAM_USER_ADMIN_SPAM_TITLE; ?></h3>

				<div class="mb-3">
					<div id="users" class="forminput">
						<?php
							$count = 0;
							if (is_countable($users)) {
								$count = count($users);
							}
							if ($count == 0) {
								echo "<p>".$LNG->SPAM_USER_ADMIN_NONE_MESSAGE."</p>";
							} else {
								echo "<table class='table'>";
								echo "<tr>";
								echo "<th width='50%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING1."</th>";
								echo "<th width='10%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING2."</th>";
								echo "<th width='10%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING2."</th>";
								echo "<th width='10%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING2."</th>";
								echo "<th width='20%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING0."</th>";
								echo "</tr>";

								foreach($users as $user){
									echo '<tr>';
										echo '<td>';
										echo $user->name;
										echo '</td>';
										echo '<td>';
										echo '<span title="'.$LNG->SPAM_USER_ADMIN_VIEW_HINT.'" class="active" onclick="viewSpamUserDetails(\''.$user->userid.'\');">'.$LNG->SPAM_USER_ADMIN_VIEW_BUTTON.'</span>';
										echo '</td>';
										echo '<td>';
										echo '<form id="second-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRestore(\''.htmlspecialchars($user->name).'\');">';
										echo '<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />';
										echo '<input type="hidden" id="restoreuser" name="restoreuser" value="" />';
										echo '<span title="'.$LNG->SPAM_USER_ADMIN_RESTORE_HINT.'" class="active" onclick="if (checkFormRestore(\''.htmlspecialchars($user->name).'\')){ $(\'second-'.$user->userid.'\').submit(); }" id="restorenode" name="restorenode">'.$LNG->SPAM_USER_ADMIN_RESTORE_BUTTON.'</a>';
										echo '</form>';
										echo '</td>';
										echo '<td>';
										echo '<form id="fourth-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormSuspend(\''.htmlspecialchars($user->name).'\');">';
										echo '<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />';
										echo '<input type="hidden" id="suspenduser" name="suspenduser" value="" />';
										echo '<span title="'.$LNG->SPAM_USER_ADMIN_SUSPEND_HINT.'" class="active" onclick="if (checkFormSuspend(\''.htmlspecialchars($user->name).'\')) { $(\'fourth-'.$user->userid.'\').submit(); }" id="suspenduser" name="suspenduser">'.$LNG->SPAM_USER_ADMIN_SUSPEND_BUTTON.'</a>';
										echo '</form>';
										echo '</td>';
										echo '<td>';
										if (isset($user->reporter)) {
											echo '<a href="'. $CFG->homeAddress .'user.php?userid='. $user->reporter->userid .'" class="active" target="_blank">'.$user->reporter->name.'</a>';
										} else {
											echo $LNG->CORE_UNKNOWN_USER_ERROR;
										}
										echo '</td>';
									echo '</tr>';
								}
								echo "</table>";
							}
						?>
					</div>
				</div>

				<h3><?php echo $LNG->SPAM_USER_ADMIN_SUSPENDED_TITLE; ?></h3>

				<div class="mb-3">
					<div id="suspendedusers" class="forminput">
						<?php

							$countu = 0;
							if (is_countable($userssuspended)) {
								$countu = count($userssuspended);
							}
							if ($countu == 0) {
								echo "<p>".$LNG->SPAM_USER_ADMIN_NONE_SUSPENDED_MESSAGE."</p>";
							} else {
								echo "<table width='700' class='table' cellspacing='0' cellpadding='3' border='0' style='margin: 0px;'>";
								echo "<tr>";
								echo "<th width='50%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING1."</th>";
								echo "<th width='10%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING2."</th>";
								echo "<th width='10%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING2."</th>";
								echo "<th width='10%' class='d-none'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING2."</th>";
								echo "<th width='20%'>".$LNG->SPAM_USER_ADMIN_TABLE_HEADING0."</th>";
								echo "</tr>";

								foreach($userssuspended as $user){
									echo '<tr>';
										echo '<td>';
										echo $user->name;
										echo '</td>';
										echo '<td>';
										echo '<span title="'.$LNG->SPAM_USER_ADMIN_VIEW_HINT.'" class="active" onclick="viewSpamUserDetails(\''.$user->userid.'\');">'.$LNG->SPAM_USER_ADMIN_VIEW_BUTTON.'</a>';
										echo '</td>';
										echo '<td>';
										echo '<form id="second-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRestore(\''.htmlspecialchars($user->name).'\');">';
										echo '<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />';
										echo '<input type="hidden" id="restoreuser" name="restoreuser" value="" />';
										echo '<span title="'.$LNG->SPAM_USER_ADMIN_RESTORE_HINT.'" class="active" onclick="if (checkFormRestore(\''.htmlspecialchars($user->name).'\')){ $(\'second-'.$user->userid.'\').submit(); }" id="restorenode" name="restorenode">'.$LNG->SPAM_USER_ADMIN_RESTORE_BUTTON.'</a>';
										echo '</form>';
										echo '</td>';
										echo '<td class="d-none">';
										echo $LNG->SPAM_USER_ADMIN_DELETE_BUTTON;
										//echo '<form id="third-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormDelete(\''.htmlspecialchars($user->name).'\');">';
										//echo '<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />';
										//echo '<input type="hidden" id="deleteuser" name="deleteuser" value="" />';
										//echo '<span title="'.$LNG->SPAM_USER_ADMIN_DELETE_HINT.'" class="active" onclick="if (checkFormDelete(\''.htmlspecialchars($user->name).'\')) { $(\'third-'.$user->userid.'\').submit(); }" id="deletenode" name="deletenode">'.$LNG->SPAM_USER_ADMIN_DELETE_BUTTON.'</a>';
										//echo '</form>';
										echo '</td>';
										echo '<td>';
										if (isset($user->reporter)) {
											echo '<span title="'.$LNG->SPAM_USER_ADMIN_VIEW_HINT.'" class="active" onclick="viewSpamUserDetails(\''.$user->reporter->userid.'\');">'.$user->reporter->name.'</span>';
										} else {
											echo $LNG->CORE_UNKNOWN_USER_ERROR;
										}
										echo '</td>';
									echo '</tr>';
								}
								echo "</table>";
							}
						?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>
