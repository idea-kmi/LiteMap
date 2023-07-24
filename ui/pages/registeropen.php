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
    if(isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
        return;
    }

    if ($CFG->signupstatus != $CFG->SIGNUP_OPEN) {
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

    $homepage = trim(optional_param("homepage","http://",PARAM_URL));

    $description = optional_param("description","",PARAM_TEXT);

    $location = optional_param("location","",PARAM_TEXT);
    $loccountry = optional_param("loccountry","",PARAM_TEXT);

    $agreeconditions = optional_param("agreeconditions","",PARAM_TEXT);
    $recentactivitiesemail = optional_param("recentactivitiesemail","N",PARAM_TEXT);
    if ($recentactivitiesemail == "") {
    	$recentactivitiesemail = 'N';
    }

    $recaptcha_response_field = optional_param("g-recaptcha-response","",PARAM_TEXT);

    $privatedata = optional_param("defaultaccess","N",PARAM_ALPHA);

    $ref = optional_param("ref",$CFG->homeAddress."index.php",PARAM_URL);

    if(isset($_POST["register"])){
    	if ($CFG->hasConditionsOfUseAgreement && $agreeconditions != "Y") {
            array_push($errors, $LNG->CONDITIONS_AGREE_FAILED_MESSAGE);
        } else {
			// check email, password & full name provided
			if (!validEmail($email)) {
				array_push($errors, $LNG->FORM_ERROR_EMAIL_INVALID);
			} else {
				if ($password == ""){
					array_push($errors, $LNG->FORM_ERROR_PASSWORD_MISSING);
				}
				if (strlen($password) < 8){
					array_push($errors, $LNG->LOGIN_PASSWORD_LENGTH);
				}
				if ($fullname == ""){
					array_push($errors, $LNG->FORM_ERROR_NAME_MISSING);
				}

				// check password & confirm password match
				if ($password != $confirmpassword){
					array_push($errors, $LNG->FORM_ERROR_PASSWORD_MISMATCH);
				}
				if ($interest == ""){
					array_push($errors, $LNG->FORM_ERROR_INTEREST_MISSING);
				}

				// check url
				if ($homepage == "http://") {
					$homepage = "";
				}
				if ($homepage != "") {
					$URLValidator = new mrsnk_URL_validation($homepage, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
					if($homepage != "" && !$URLValidator->isValid()){
						 array_push($errors, $LNG->FORM_ERROR_URL_INVALID);
					}
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
							// create new user

							$u->add($email,$fullname,$password,$homepage,'N',$CFG->AUTH_TYPE_EVHUB,$description,$CFG->USER_STATUS_UNVALIDATED);
							$u->updatePrivate($privatedata);
							$u->updateLocation($location,$loccountry);
							$u->setInterest($interest);

							// Recent Activities Email
							if ($CFG->RECENT_EMAIL_SENDING_ON) {
								$u->updateRecentActivitiesEmail($recentactivitiesemail);
							}

							// send validation email
            				$paramArray = array ($u->name,$CFG->SITE_TITLE,$CFG->homeAddress,$u->userid,$u->getRegistrationKey());
							sendMail("validate",$LNG->VALIDATE_REGISTER_SUBJECT,$u->getEmail(),$paramArray);

							// too large a photo can cause this to fail, so it should send the email before it
							// tries to process the image. This should not prevent the registration process.
							$photofilename = "";
							if(empty($errors)){
								// upload image if provided
								if (isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] != "") {
									// Can't upload photo without userid
									$USER = $u;
									$photofilename = uploadImage('photo',$errors,$CFG->IMAGE_WIDTH);
									if(!empty($errors)){
										echo "<div class='errors'>";
										foreach ($errors as $error){
											echo $error;
										}
										echo "<br>".$LNG->FORM_REGISTER_IMAGE_ERROR;
										echo "</div>";
										$errors = array();
									}
									$USER = null;
								} else {
									$photofilename = $CFG->DEFAULT_USER_PHOTO;
								}
							}

							$u->updatePhoto($photofilename);

							if(empty($errors)){
								echo "<div class=\"container-fluid\"><div class=\"row p-4 justify-content-center\"><div class=\"col-sm-12\"><h1>".$LNG->REGISTRATION_SUCCESSFUL_TITLE."</h1><p>".$LNG->REGISTRATION_SUCCESSFUL_MESSAGE."</p></div></div></div>";
								include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
								die;
							}
						}
					}
				}
			}
		}
    }

    $countries = getCountryList();
?>

<div class="container-fluid">
	<div class="row p-4 justify-content-center">	
		<div class="col-sm-12 col-lg-8">
			<h1><?php echo $LNG->FORM_REGISTER_OPEN_TITLE; ?></h1>
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
				<label class="col-sm-3 col-form-label" for="email"><?php echo $LNG->FORM_REGISTER_EMAIL; ?> <span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" id="email" name="email" value="<?php print $email; ?>">
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="password"><?php echo $LNG->FORM_REGISTER_PASSWORD; ?> <span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" id="password" name="password" type="password" value="<?php print $password; ?>">
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="confirmpassword"><?php echo $LNG->FORM_REGISTER_PASSWORD_CONFIRM; ?><span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" id="confirmpassword" name="confirmpassword" type="password" value="<?php print $confirmpassword; ?>">
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="fullname"><?php echo $LNG->FORM_REGISTER_NAME; ?> <span class="required">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" type="text" id="fullname" name="fullname" value="<?php print $fullname; ?>">
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="description"><?php echo $LNG->PROFILE_DESC_LABEL; ?></label>
				<div class="col-sm-9">
					<textarea class="form-control" id="description" name="description" rows="3"><?php print $description; ?></textarea>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="interest"><?php echo $LNG->FORM_REGISTER_INTEREST; ?> <span class="required">*</span></label>
				<div class="col-sm-9">
					<textarea class="form-control" id="interest" name="interest" rows="3"><?php print $interest; ?></textarea>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="location"><?php echo $LNG->FORM_REGISTER_LOCATION; ?></label>
				<div class="col-sm-5">
					<input class="form-control" id="location" name="location" value="<?php echo $location; ?>">
				</div>
				<div class="col-sm-4">
					<select id="loccountry" name="loccountry" class="form-select" aria-label="Select country" >
						<option value="" ><?php echo $LNG->FORM_REGISTER_COUNTRY; ?></option>
						<?php
							foreach($countries as $code=>$c){
								echo "<option value='".$code."'";
								if($code == $loccountry){
									echo " selected='true'";
								}
								echo ">".$c."</option>";
							}
						?>
					</select>
				</div>
			</div>	

			<?php if ($CFG->hasUserHomePageOption) { ?>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="homepage"><?php echo $LNG->FORM_REGISTER_HOMEPAGE; ?></label>
					<div class="col-sm-9">
						<input class="form-control" type="text" id="homepage" name="homepage" value="<?php print $homepage; ?>">
					</div>
				</div>
			<?php } ?>

			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label" for="photo"><?php echo $LNG->PROFILE_PHOTO_LABEL; ?></label>
				<div class="col-sm-9">
					<input class="form-control" type="file" id="photo" name="photo">
				</div>
			</div>

			<?php if ($CFG->RECENT_EMAIL_SENDING_ON) { ?>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="recentactivitiesemail"><?php echo $LNG->RECENT_EMAIL_DIGEST_LABEL; ?></label>
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
					<label class="col-sm-3 col-form-label" for="g-recaptcha"><?php echo $LNG->FORM_REGISTER_CAPTCHA; ?> <span class="required">*</span></label>
					<div class="col-sm-9">
						<div class="g-recaptcha" data-sitekey="<?php echo $CFG->CAPTCHA_PUBLIC; ?>"></div>
					</div>
				</div>
			<?php } ?>

			<div class="mb-3 row">
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
				<?php } else { ?>
					<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_REGISTER_SUBMIT_BUTTON; ?>" id="register" name="register" />
					</div>
				<?php }?>
				</div>
			</div>
		</form>

		<?php if ($CFG->SOCIAL_SIGNON_ON) {?>
			<div class="mt-4 col-sm-12 col-lg-8">
				<hr />
				<fieldset class="row justify-content-center">					
					<legend class="d-block text-center mb-3"><div>Or use another service</div></legend>
					<?php if ($CFG->SOCIAL_SIGNON_GOOGLE_ON) {?>
						<div class="col-auto"><a title="Sign-in with Google" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=google&referrer=<?php echo urlencode( $ref ); ?>"><i class="fab fa-google fa-2x" title="Google"></i><span class="sr-only">Sign-in with Google</span></a></div>
					<?php } ?>
					<?php if ($CFG->SOCIAL_SIGNON_YAHOO_ON) {?>
						<div class="col-auto"><a title="Sign-in with Yahoo" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=yahoo&referrer=<?php echo urlencode( $ref ); ?>"><i class="fab fa-yahoo fa-2x" title="Yahoo"></i><span class="sr-only">Sign-in with Yahoo</span></a></div>
					<?php } ?>
					<?php if ($CFG->SOCIAL_SIGNON_FACEBOOK_ON) {?>
						<div class="col-auto"><a title="Sign-in with Facebook" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=facebook&referrer=<?php echo urlencode( $ref ); ?>"><i class="fab fa-facebook-f fa-2x" title="Facebook"></i><span class="sr-only">Sign-in with Facebook</span></a></div>
					<?php } ?>
					<?php if ($CFG->SOCIAL_SIGNON_TWITTER_ON) {?>
						<div class="col-auto"><a title="Sign-in with Twitter" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=twitter&referrer=<?php echo urlencode( $ref ); ?>"><i class="fab fa-twitter fa-2x" title="Twitter"></i><span class="sr-only">Sign-in with Twitter</span></a></div>
					<?php } ?>
					<?php if ($CFG->SOCIAL_SIGNON_LINKEDIN_ON) {?>
						<div class="col-auto"><a title="Sign-in with LinkedIn" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=linkedin&referrer=<?php echo urlencode( $ref ); ?>"><i class="fab fa-linkedin-in fa-2x" title="LinkedIn"></i><span class="sr-only">Sign-in with LinkedIn</span></a></div>
					<?php } ?>
				</fieldset>
			</div>
		<?php } ?>
	</div>
</div>
<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>