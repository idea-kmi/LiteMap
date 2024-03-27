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

    if(isset($_POST["rejectuser"])){
		$userid = optional_param("userid","",PARAM_ALPHANUMEXT);
    	if ($userid != "") {
    		$user = new User($userid);
    		$user = $user->load();

	   		//$user->updateStatus($CFG->USER_STATUS_SUSPENDED);

	   		// send email to say request rejected
			$message = vsprintf($LNG->REGSITRATION_ADMIN_EMAIL_REJECT_BODY,array($CFG->SITE_TITLE));
       		$paramArray = array ($user->name, $message);
			sendMail("plain",$LNG->REGSITRATION_ADMIN_EMAIL_REQUEST_SUBJECT,$user->getEmail(),$paramArray);

			// delete user and any upload folder
			if (!adminDeleteUser($userid)) {
				echo $LNG->ADMIN_MANAGE_USERS_DELETE_ERROR." ".$userid;
			}

			echo '<script type="text/javascript">';
			echo 'fadeMessage("'.$user->name.'<br><br>'.$LNG->REGSITRATION_ADMIN_USER_EMAILED_REJECTION.'");';
			echo '</script>';
    	} else {
            array_push($errors,$LNG->REGSITRATION_ADMIN_ID_ERROR);
    	}
    } else if(isset($_POST["acceptuser"])){
		$userid = optional_param("userid","",PARAM_ALPHANUMEXT);
    	if ($userid != "") {
    		$user = new User($userid);
    		$user = $user->load();

	   		$user->updateStatus($CFG->USER_STATUS_UNVALIDATED);

	   		// send email to validate email address
       		$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$user->getRegistrationKey());
			sendMail("validate",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

			echo '<script type="text/javascript">';
			echo 'fadeMessage("'.$user->name.'<br><br>'.$LNG->REGSITRATION_ADMIN_USER_EMAILED_ACCEPTANCE.'");';
			echo '</script>';
    	} else {
            array_push($errors,$LNG->REGSITRATION_ADMIN_ID_ERROR);
    	}
    } else if(isset($_POST["revalidateuser"])){
		$userid = optional_param("userid","",PARAM_ALPHANUMEXT);
    	if ($userid != "") {
    		$user = new User($userid);
    		$user = $user->load();

	   		// send email to validate email address
       		$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$user->getRegistrationKey());
			sendMail("validate",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

			echo '<script type="text/javascript">';
			echo 'fadeMessage("'.$user->name.'<br><br>'.$LNG->REGSITRATION_ADMIN_USER_EMAILED_REVALIDATED.'");';
			echo '</script>';
    	} else {
            array_push($errors,$LNG->REGSITRATION_ADMIN_ID_ERROR);
    	}
    } else if(isset($_POST["removeuser"])){
		$userid = optional_param("userid","",PARAM_ALPHANUMEXT);
    	if ($userid != "") {
    		$user = new User($userid);
    		$user = $user->load();

			// delete user and any upload folder
			if (!adminDeleteUser($userid)) {
				echo $LNG->ADMIN_MANAGE_USERS_DELETE_ERROR." ".$userid;
			}

			echo '<script type="text/javascript">';
			echo 'fadeMessage("'.$user->name.'<br><br>'.$LNG->REGSITRATION_ADMIN_USER_REMOVED.'");';
			echo '</script>';
    	} else {
            array_push($errors,$LNG->REGSITRATION_ADMIN_ID_ERROR);
    	}
    }

	$us = getUsersByStatus($CFG->USER_STATUS_UNAUTHORIZED, 0, -1, 'date','ASC','long');
	$users = array();
	if ($us instanceof UserSet) {
	    $users = $us->users;
		$countRequests = count($users);
	} else {
		echo "$us->message";
	}

	$us2 = getUsersByStatus($CFG->USER_STATUS_UNVALIDATED, 0, -1, 'date','ASC','long');
	$users2 = array();
	if ($us2 instanceof UserSet) {
	    $users2 = $us2->users;
		$countUnvalidated = count($users2);
	} else {
		echo "$us2->message";
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

	function checkFormAccept(name) {
		var ans = confirm("<?php echo $LNG->REGSITRATION_ADMIN_ACCEPT_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormReject(name) {
		var ans = confirm("<?php echo $LNG->REGSITRATION_ADMIN_REJECT_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormRevalidate(name) {
		var ans = confirm("<?php echo $LNG->REGSITRATION_ADMIN_REVALIDATE_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormRemove(name) {
		var ans = confirm("<?php echo $LNG->REGSITRATION_ADMIN_REMOVE_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
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
			<h1 class="mb-3"><?php echo $LNG->REGSITRATION_ADMIN_TITLE; ?></h1>
			<div id="spamdiv"class="spamdiv">
				<div class="mb-5">
					<h3 class="mb-3 d-flex align-items-center gap-3">
						<?php echo $LNG->REGSITRATION_ADMIN_UNREGISTERED_TITLE;?>
						<span class="badge rounded-pill" style="background-color: #4E725F; font-size: 0.6em;"><?=$countRequests?></span>
					</h3>
					<div class="mb-3">
						<div id="users" class="forminput">
							<?php
								$count = (is_countable($users)) ? count($users) : 0;
								if ($count == 0) { ?>
									<p><?= $LNG->REGSITRATION_ADMIN_NONE_MESSAGE ?></p>
								<?php } else { ?>
									<table class='table table-sm table-striped table-hover compact'>
										<tr>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_DATE ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_NAME ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_EMAIL ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_DESC ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_INTEREST ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_WEBSITE ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION ?></th>
										</tr>
										
										<?php foreach($users as $user){ ?>
											<tr>
												<td><?= date('d M Y', $user->creationdate) ?></td>
												<td><?= $user->name ?></td>
												<td><?= $user->getEmail() ?></td>
												<td><?= $user->description ?></td>
												<td><?= $user->getInterest() ?></td>
												<td>
													<?php if (isset($user->website) && $user->website!="") { ?>	
														<a href="<?= $user->website ?>" target="_blank"><?= $user->website ?></a>
													<?php } ?>
												</td>
												<td>
													<?php echo '<form id="second-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormAccept(\''.htmlspecialchars($user->name).'\');">
														<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />'; ?>
														<input type="hidden" id="acceptuser" name="acceptuser" value="" />
														<?php echo '<span class="active" onclick="if (checkFormAccept(\''.htmlspecialchars($user->name).'\')){ $(\'second-'.$user->userid.'\').submit(); }" id="acceptuser" name="acceptuser">'.$LNG->REGSITRATION_ADMIN_ACCEPT_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td>
													<?php echo '<form id="third-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormReject(\''.htmlspecialchars($user->name).'\');">'; ?>
														<input type="hidden" id="userid" name="userid" value="<?= $user->userid ?>" />
														<input type="hidden" id="rejectuser" name="rejectuser" value="" />
														<?php echo '<span class="active" onclick="if (checkFormReject(\''.htmlspecialchars($user->name).'\')) { $(\'third-'.$user->userid.'\').submit(); }" id="rejectuser" name="rejectuser">'.$LNG->REGSITRATION_ADMIN_REJECT_BUTTON.'</span>'; ?>
													</form>
												</td>
											</tr>
										<?php } ?>
									</table>
								<?php } 
							?>
						</div>
					</div>
				</div>
				
				<div class="mb-5">
					<h3 class="mb-3 d-flex align-items-center gap-3">
						<?php echo $LNG->REGSITRATION_ADMIN_UNVALIDATED_TITLE;?>
						<span class="badge rounded-pill" style="background-color: #4E725F; font-size: 0.6em;"><?=$countUnvalidated?></span>
					</h3>
					<div class="mb-3">
						<div id="users2" class="forminput">
							<?php
								$count = (is_countable($users2)) ? count($users2) : 0;
								if ($count == 0) { ?>
									<p><?= $LNG->REGSITRATION_ADMIN_VALIDATION_NONE_MESSAGE ?></p>
								<?php } else { ?>
									<table class='table table-sm table-striped table-hover compact'>
										<tr>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_DATE ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_NAME ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_EMAIL ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_DESC ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_INTEREST ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_WEBSITE ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION ?></th>
											<th><?= $LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION ?></th>
										</tr>
										
										<?php foreach($users2 as $user){ ?>
											<tr>
												<td><?= date('d M Y', $user->creationdate) ?></td>
												<td><?= $user->name ?></td>
												<td><?= $user->getEmail() ?></td>
												<td><?= $user->description ?></td>
												<td><?= $user->getInterest() ?></td>
												<td>
													<?php if (isset($user->website) && $user->website!="") { ?>	
														<a href="<?= $user->website ?>" target="_blank"><?= $user->website ?></a>
													<?php } ?>
												</td>
												<td>
													<?php echo '<form id="second-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRevalidate(\''.htmlspecialchars($user->name).'\');">
														<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />'; ?>
														<input type="hidden" id="revalidateuser" name="revalidateuser" value="" />
														<?php echo '<span class="active" onclick="if (checkFormRevalidate(\''.htmlspecialchars($user->name).'\')){ $(\'second-'.$user->userid.'\').submit(); }" id="revalidateuser" name="revalidateuser">'.$LNG->REGSITRATION_ADMIN_REVALIDATE_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td>
													<?php echo '<form id="third-'.$user->userid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRemove(\''.htmlspecialchars($user->name).'\');">'; ?>
														<input type="hidden" id="userid" name="userid" value="<?= $user->userid ?>" />
														<input type="hidden" id="removeuser" name="removeuser" value="" />
														<?php echo '<span class="active" onclick="if (checkFormRemove(\''.htmlspecialchars($user->name).'\')) { $(\'third-'.$user->userid.'\').submit(); }" id="removeuser" name="removeuser">'.$LNG->REGSITRATION_ADMIN_REMOVE_BUTTON.'</span>'; ?>
													</form>
												</td>
											</tr>
										<?php } ?>
									</table>
								<?php } 
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>
