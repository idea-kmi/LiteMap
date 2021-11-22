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
								echo "<h1>".$LNG->REGISTRATION_SUCCESSFUL_TITLE."</h1><p>".$LNG->REGISTRATION_SUCCESSFUL_MESSAGE."</p>";
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
<h1><?php echo $LNG->FORM_REGISTER_OPEN_TITLE; ?></h1>

<?php
    if(!empty($errors)){
        echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE_REGISTRATION."<ul>";
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

<div style="clear:both;float:left;margin-top:0px;">

<p><span class="required">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS; ?></p>

<form name="register" action="" style="width:650px;" method="post" enctype="multipart/form-data" onsubmit="return checkForm();">

    <div class="formrow">
        <label class="formlabelbig" for="email"><?php echo $LNG->FORM_REGISTER_EMAIL; ?>
		<span class="required">*</span></label>
        <input class="forminput" id="email" name="email" size="40" value="<?php print $email; ?>">
    </div>
    <div class="formrow">
        <label class="formlabelbig" for="password"><?php echo $LNG->FORM_REGISTER_PASSWORD; ?>
		<span class="required">*</span></label>
        <input class="forminput" id="password" name="password" type="password"  size="30" value="<?php print $password; ?>">
    </div>
    <div class="formrow">
        <label class="formlabelbig" for="confirmpassword"><?php echo $LNG->FORM_REGISTER_PASSWORD_CONFIRM; ?>
        <span class="required">*</span></label>
        <input class="forminput" id="confirmpassword" name="confirmpassword" type="password" size="30" value="<?php print $confirmpassword; ?>">
    </div>
    <div class="formrow">
        <label class="formlabelbig" for="fullname"><?php echo $LNG->FORM_REGISTER_NAME; ?>
		<span class="required">*</span></label>
        <input class="forminput" type="text" id="fullname" name="fullname" size="40" value="<?php print $fullname; ?>">
    </div>
    <div class="formrow">
        <label class="formlabelbig" for="description"><?php echo $LNG->PROFILE_DESC_LABEL; ?></label>
        <textarea class="forminput" id="description" name="description" cols="40" rows="5"><?php print $description; ?></textarea>
    </div>
    <div class="formrow">
        <label class="formlabelbig" for="interest"><?php echo $LNG->FORM_REGISTER_INTEREST; ?>
		<span class="required">*</span></label>
        <textarea class="forminput" id="interest" name="interest" cols="40" rows="3"><?php print $interest; ?></textarea>
    </div>
    <div class="formrow">
		<label class="formlabelbig" for="location"><?php echo $LNG->FORM_REGISTER_LOCATION; ?></label>
		<input class="forminput" id="location" name="location" style="width:160px;" value="<?php echo $location; ?>">
		<select id="loccountry" name="loccountry" style="margin-left: 5px;width:160px;">
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

	<?php if ($CFG->hasUserHomePageOption) { ?>
	<div class="formrow">
        <label class="formlabelbig" for="homepage"><?php echo $LNG->FORM_REGISTER_HOMEPAGE; ?></label>
        <input class="forminput" type="text" id="homepage" name="homepage" size="40" value="<?php print $homepage; ?>">
    </div>
    <?php } ?>

    <div class="formrow">
        <label class="formlabelbig" for="photo"><?php echo $LNG->PROFILE_PHOTO_LABEL; ?></label>
        <input class="forminput" type="file" id="photo" name="photo" size="40">
    </div>

	<?php if ($CFG->RECENT_EMAIL_SENDING_ON) { ?>
		<div class="formrow">
			<label class="formlabelbig" for="recentactivitiesemail"><?php echo $LNG->RECENT_EMAIL_DIGEST_LABEL; ?></label>
			<input class="forminput" type="checkbox" name="recentactivitiesemail" <?php if ($recentactivitiesemail == 'Y') { echo "checked='true'"; } ?> value="Y" /> <?php echo $LNG->RECENT_EMAIL_DIGEST_REGISTER_MESSAGE; ?>
		</div>
	<?php } ?>

	<?php if($CFG->CAPTCHA_ON) { ?>
		<div class="formrow" style="width:800px;">
			<label class="formlabelbig" for="g-recaptcha"><?php echo $LNG->FORM_REGISTER_CAPTCHA; ?></label>
			<div class="g-recaptcha" data-sitekey="<?php echo $CFG->CAPTCHA_PUBLIC; ?>" style="float:left;margin-left:5px;"></div>
		</div>
	<?php } ?>

	<?php if ($CFG->hasConditionsOfUseAgreement) { ?>
		<div class="formrow" style="margin-left:10px;">
			<h2><?php echo $LNG->CONDITIONS_REGISTER_FORM_TITLE; ?><span class="required">*</span></h2>
			<p><?php echo $LNG->CONDITIONS_REGISTER_FORM_MESSAGE; ?></p>
			<input class="forminput" style="margin-right:10px;" type="checkbox" name="agreeconditions" id="agreeconditions" value="Y" /> <?php echo $LNG->CONDITIONS_AGREE_FORM_REGISTER_MESSAGE; ?>
		</div>

		<div class="formrow" style="margin-left:10px;margin-top:10px;">
			<label class="formlabelbig" for="register">&nbsp;</label>
			<input class="forminput" type="submit" value="<?php echo $LNG->FORM_REGISTER_SUBMIT_BUTTON; ?>" id="register" name="register">
		</div>
    <?php } else { ?>
		<div class="formrow">
			<label class="formlabelbig" for="register">&nbsp;</label>
			<input class="forminput" type="submit" value="<?php echo $LNG->FORM_REGISTER_SUBMIT_BUTTON; ?>" id="register" name="register">
		</div>
    <?php }?>

</form>
</div>

<?php if ($CFG->SOCIAL_SIGNON_ON) {?>
	<div style="float:left;margin-left:5px;margin-top:50px;">
		<fieldset>
			<legend><?php echo $LNG->LOGIN_SOCIAL_SIGNON; ?></legend>
			<?php if ($CFG->SOCIAL_SIGNON_GOOGLE_ON) {?>
				<div style="float:left;margin:10px;"><a title="Sign-in with Google" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=google&referrer=<?php echo urlencode( $ref ); ?>"><img width="40" height="40" border="0" src="<?php echo $HUB_FLM->getImagePath('icons/google.png'); ?>" /></a></div>
			<?php } ?>

			<?php if ($CFG->SOCIAL_SIGNON_YAHOO_ON) {?>
				<div style="float:left;margin:10px;"><a title="Sign-in with Yahoo" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=yahoo&referrer=<?php echo urlencode( $ref ); ?>"><img width="40" height="40" border="0" src="<?php echo $HUB_FLM->getImagePath('icons/yahoo.png'); ?>" /></a></div>
			<?php } ?>

			<?php if ($CFG->SOCIAL_SIGNON_FACEBOOK_ON) {?>
				<div style="float:left;margin:10px;"><a title="Sign-in with Facebook" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=facebook&referrer=<?php echo urlencode( $ref ); ?>"><img width="40" height="40" border="0" src="<?php echo $HUB_FLM->getImagePath('icons/facebook.png'); ?>" /></a></div>
			<?php } ?>

			<?php if ($CFG->SOCIAL_SIGNON_TWITTER_ON) {?>
				<div style="float:left;margin:10px;"><a title="Sign-in with Twitter" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=twitter&referrer=<?php echo urlencode( $ref ); ?>"><img width="40" height="40" border="0" src="<?php echo $HUB_FLM->getImagePath('icons/twitter.png'); ?>" /></a></div>
			<?php } ?>

			<?php if ($CFG->SOCIAL_SIGNON_LINKEDIN_ON) {?>
				<div style="float:left;margin:10px;"><a title="Sign-in with LinkedIn" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=linkedin&referrer=<?php echo urlencode( $ref ); ?>"><img width="40" height="40" border="0" src="<?php echo $HUB_FLM->getImagePath('icons/linkedin.png'); ?>" /></a></div>
			<?php } ?>
		</fieldset>
	</div>
<?php } ?>
<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>