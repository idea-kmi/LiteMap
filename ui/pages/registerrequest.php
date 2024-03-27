<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2015 - 2024 The Open University UK                            *
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
    if(isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
        return;
    }

    if ($CFG->signupstatus != $CFG->SIGNUP_REQUEST) {
	    header('Location: '.$CFG->homeAddress.'index.php');
	  	return;
	}

    if($CFG->CAPTCHA_ON) {
		array_push($HEADER,'<script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>');
	}

    include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
    require_once($HUB_FLM->getCodeDirPath("core/lib/recaptcha/autoload.php"));
    require_once($HUB_FLM->getCodeDirPath("core/lib/url-validation.class.php"));
	
    $errors = array();

    $email = trim(optional_param("email","",PARAM_TEXT));
    $password = trim(optional_param("password","",PARAM_TEXT));
    $confirmpassword = trim(optional_param("confirmpassword","",PARAM_TEXT));
    $fullname = trim(optional_param("fullname","",PARAM_TEXT));
    $interest = trim(optional_param("interest","",PARAM_TEXT));
    $description = optional_param("description","",PARAM_TEXT);
    $recaptcha_response_field = optional_param("g-recaptcha-response","",PARAM_TEXT);
    $agreeconditions = optional_param("agreeconditions","",PARAM_TEXT);
    $recentactivitiesemail = optional_param("recentactivitiesemail","N",PARAM_TEXT);
    if ($recentactivitiesemail == "") {
    	$recentactivitiesemail = 'N';
    }
    $privatedata = optional_param("defaultaccess","N",PARAM_ALPHA);

	/* black list for emails to try reduce spammers */
	$emailBlocklist = include_once($HUB_FLM->getCodeDirPath("core/email-blocklist.php"));
	$emailDomain = substr(strrchr($email, "@"), 1);

    if(isset($_POST["register"])){
    	if ($CFG->hasConditionsOfUseAgreement && $agreeconditions != "Y") {
            array_push($errors, $LNG->CONDITIONS_AGREE_FAILED_MESSAGE);
        } else {
			// check email & full name provided
			if (!validEmail($email)) {
				array_push($errors, $LNG->FORM_ERROR_EMAIL_INVALID);
			} else if (in_array($emailDomain, $emailBlocklist)) {
				array_push($errors, $LNG->FORM_ERROR_EMAIL_NOT_ALLOWED);
			} else {
				if ($password == ""){
					array_push($errors, $LNG->FORM_ERROR_PASSWORD_MISSING);
				}
				if (strlen($password) < 8){
					array_push($errors, $LNG->LOGIN_PASSWORD_LENGTH);
				}
				// check password & confirm password match
				if ($password != $confirmpassword){
					array_push($errors, $LNG->FORM_ERROR_PASSWORD_MISMATCH);
				}
				if ($fullname == ""){
					array_push($errors, $LNG->FORM_ERROR_NAME_MISSING);
				}
				if ($interest == ""){
					array_push($errors, $LNG->FORM_ERROR_INTEREST_MISSING);
				}

				if (empty($errors)) {
					// check email not already in use
					$u = new User();
					$u->setEmail($email);
					$user = $u->getByEmail();

					if($user instanceof User){
						array_push($errors, $LNG->FORM_ERROR_EMAIL_USED);
					} else {
						if($CFG->CAPTCHA_ON) {
							$reCaptcha = new \ReCaptcha\ReCaptcha($CFG->CAPTCHA_PRIVATE);
							$response = $reCaptcha->setExpectedHostname($CFG->CAPTCHA_DOMAIN)
								->verify(
									$recaptcha_response_field,
									$_SERVER["REMOTE_ADDR"]
							);

							if ($response == null || !$response->isSuccess()) {
								array_push($errors, $LNG->FORM_ERROR_CAPTCHA_INVALID);
							}
						}

						if(empty($errors)){
							// only create user if no error so far
							// create new user but status unauthorized

							$u->add($email,$fullname,$password,'','N',$CFG->AUTH_TYPE_EVHUB,$description,$CFG->USER_STATUS_UNAUTHORIZED);
							if ($u instanceof User) {
								$u->updatePrivate($privatedata);
								$u->setInterest($interest);

								$photofilename = "";
								if(empty($errors)){
									// upload image if provided
									if ($_FILES['photo']['tmp_name'] != "") {
										// Can't upload photo without userid
										$USER = $u;
										$photofilename = uploadImage('photo',$errors,$CFG->IMAGE_WIDTH);
										$USER = null;
									} else {
										$photofilename = $CFG->DEFAULT_USER_PHOTO;
									}
								}

								$u->updatePhoto($photofilename);

								// Recent Activities Email
								if ($CFG->RECENT_EMAIL_SENDING_ON) {
									$u->updateRecentActivitiesEmail($recentactivitiesemail);
								}

								// Email to administrator
								$headpath = $HUB_FLM->getMailTemplatePath("emailhead.txt");
								$headtemp = loadFileToString($headpath);
								$head = vsprintf($headtemp,array($HUB_FLM->getImagePath('evidence-hub-logo-email.png')));

								$footpath = $HUB_FLM->getMailTemplatePath("emailfoot.txt");
								$foottemp = loadFileToString($footpath);
								$foot = vsprintf($foottemp,array ($CFG->homeAddress));

								$message = $LNG->WELCOME_REGISTER_REQUEST_BODY_ADMIN;
								$message = $head.$message.$foot;

								$headers = "Content-type: text/html; charset=utf-8\r\n";
								ini_set("sendmail_from", $CFG->EMAIL_FROM_ADDRESS );
								$headers .= "From: ".$CFG->EMAIL_FROM_NAME ." <".$CFG->EMAIL_FROM_ADDRESS .">\r\n";
								$headers .= "Reply-To: ".$CFG->EMAIL_REPLY_TO."\r\n";

								if ($CFG->signuprequestemail != "") {
									mail($CFG->signuprequestemail,$LNG->WELCOME_REGISTER_REQUEST_SUBJECT,$message,$headers);
								} else {
									mail($CFG->EMAIL_REPLY_TO,$LNG->WELCOME_REGISTER_REQUEST_SUBJECT,$message,$headers);
								}

								// Email to potential new User
								$paramArray = array ($fullname,$LNG->WELCOME_REGISTER_REQUEST_BODY);
								sendMail("plain",$LNG->WELCOME_REGISTER_REQUEST_SUBJECT,$email,$paramArray);

								echo "<div class=\"container-fluid\"><div class=\"row p-4 justify-content-center\"><div class=\"col-sm-12\"><h1>".$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE."</h1><p>".$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE."</p></div></div></div>";

								include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
								die;
							} else {
								array_push($errors, "Problem adding user:".$u->message);
							}
						}
					}
				}
			}
        }
    }
?>

<div class="container-fluid">
	<div class="row p-4 justify-content-center">	
		<div class="col-sm-12 col-lg-8">
			<h1><?php echo $LNG->FORM_REGISTER_REQUEST_TITLE; ?></h1>
			<?php
				if(!empty($errors)){
					echo "<div class='alert alert-danger'>".$LNG->FORM_ERROR_MESSAGE_REGISTRATION."<ul>";
					foreach ($errors as $error){
						echo "<li>".$error."</li>";
					}
					echo "</ul></div>";
				}
			?>
			<script type="text/javascript">
				function checkForm() {
					if ($('agreeconditions') && $('agreeconditions').checked == false){
					alert("<?php echo $LNG->CONDITIONS_AGREE_FAILED_MESSAGE; ?>");
					return false;
					}
					$('register').style.cursor = 'wait';
					return true;
				}
			</script>
			<p class="text-end"><span class="required">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS; ?></p>
		</div>

		<form name="register" action="" method="post" enctype="multipart/form-data" onsubmit="return checkForm();" class="col-sm-12 col-lg-8">

			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="email"><?php echo $LNG->FORM_REGISTER_EMAIL; ?>
				<span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" id="email" name="email" value="<?php print $email; ?>">
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="password"><?php echo $LNG->FORM_REGISTER_PASSWORD; ?>
				<span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" id="password" name="password" type="password" value="<?php print $password; ?>">
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="confirmpassword"><?php echo $LNG->FORM_REGISTER_PASSWORD_CONFIRM; ?>
				<span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" id="confirmpassword" name="confirmpassword" type="password" value="<?php print $confirmpassword; ?>">
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="fullname"><?php echo $LNG->FORM_REGISTER_NAME; ?>
				<span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" type="text" id="fullname" name="fullname" value="<?php print $fullname; ?>">
					<div id="validationFullname" class="form-text text-danger"></div>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="description"><?php echo $LNG->FORM_REGISTER_REQUEST_DESC; ?></label>
				<div class="col-sm-9">
					<textarea class="form-control" id="description" name="description" rows="3"><?php print $description; ?></textarea>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="interest"><?php echo $LNG->FORM_REGISTER_INTEREST; ?>
				<span class="required">*</span></label>
				<div class="col-sm-9">
					<textarea class="form-control" id="interest" name="interest" rows="3"><?php print $interest; ?></textarea>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="photo"><?php echo $LNG->PROFILE_PHOTO_LABEL; ?></label>
				<div class="col-sm-9">
					<input class="form-control" type="file" id="photo" name="photo">
				</div>
			</div>

			<?php if ($CFG->RECENT_EMAIL_SENDING_ON) { ?>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label"><?php echo $LNG->RECENT_EMAIL_DIGEST_LABEL; ?></label>
					<div class="col-sm-9">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="recentactivitiesemail" name="recentactivitiesemail" <?php if ($recentactivitiesemail == 'Y') { echo "checked='true'"; } ?> value="Y" /> 
							<label class="form-check-label" for="recentactivitiesemail"><?php echo $LNG->RECENT_EMAIL_DIGEST_REGISTER_MESSAGE; ?></label> 
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($CFG->CAPTCHA_ON) { ?>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="g-recaptcha-response"><?php echo $LNG->FORM_REGISTER_CAPTCHA; ?> <span class="required">*</span></label>
					<div class="col-sm-9">
						<div class="g-recaptcha" data-sitekey="<?php echo $CFG->CAPTCHA_PUBLIC; ?>"></div>
					</div>
				</div>
			<?php } ?>

			<div class="mb-3 pt-3 row">
				<hr />
				<?php if ($CFG->hasConditionsOfUseAgreement) { ?>
					<div class="col">
						<h2><?php echo $LNG->CONDITIONS_REGISTER_FORM_TITLE; ?></h2>
						<p><?php echo $LNG->CONDITIONS_REGISTER_FORM_MESSAGE; ?></p>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="agreeconditions" id="agreeconditions" value="Y" /> 
							<label class="form-check-label" for="agreeconditions"><span class="required">*</span> <?php echo $LNG->CONDITIONS_AGREE_FORM_REGISTER_MESSAGE; ?></label>
						</div>
					</div>
				<?php }?>
				<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
					<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_REGISTER_SUBMIT_BUTTON; ?>" id="register" name="register">
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	document.getElementById('fullname').addEventListener('input', function() {
		var nameInput = this;
		var errorDiv = document.getElementById('validationFullname');
    	var submitBtn = document.getElementById('register');
		// Pattern to include Unicode characters
		var regex = /^[\p{L}\s'-]+$/u;
		
		if (!regex.test(nameInput.value)) {
			// Disable the submit button
			submitBtn.disabled = true;
			// Display error message if validation fails
			errorDiv.textContent = "Name can only contain letters, spaces, hyphens, and apostrophes.";
		} else {
			// Enable  the submit button
			submitBtn.disabled = false;
			// Clear error message if validation passes
			errorDiv.textContent = '';
		}		
	});
</script>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>