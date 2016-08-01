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
	require_once( $CFG->dirAddress.'core/lib/hybridauth-2.6.0/hybridauth/Hybrid/Auth.php' );

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    // check that user not already logged in
    if(isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
		exit();
    }

    $errors = array();

   	$provider = required_param("provider",PARAM_ALPHA);
   	$providerDisplay = ucfirst($provider);

    $referrer = optional_param("referrer",$CFG->homeAddress."index.php",PARAM_URL);
    if ($referrer == "") {
    	$referrer = $CFG->homeAddress."index.php";
    }
    $fromembed = optional_param("fromembed","false",PARAM_BOOL);

	$showEmailForm = false;
	$revalidateEmail = false;

    // USER ASKED ANOTHER VALIDATION EMAIL FOR A NEW ACCOUNT
 	if (isset($_POST["validateemail"])) {

		// send email to validate email address
        $authid = required_param("authid",PARAM_TEXT);
		$auth = new UserAuthentication($authid);
		$authentication = $auth->load();

        if ($authentication instanceof UserAuthentication
        		&& !$authentication->isEmailVerified()) {

			$u = new User($authentication->getUserID());
			$user = $u->load();
			if ($user instanceof User && !$user->isEmailValidated()
					&& strcmp($user->getRegistrationKey(),$authentication->getRegistrationKey()) == 0) {

				$registrationKey = $user->getRegistrationKey();

				// send email for validate ownership of email given, Validate email as External.
				$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$authentication->authid,$registrationKey,urlencode($referrer));
				sendMail("validateexternalnewuser",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

   				include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
				echo "<div class='messagediv2'><h1>".$LNG->LOGIN_EXTERNAL_TITLE."</h1><p>".$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE."</p></dir>";
				include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
				die;
			} else {
				//
			}
		} else {
			//
		}

	// EMAIL WAS REQUESTED FROM USER AS NOT GIVEN BY SERVICE PROVIDER
	} else if(isset($_POST["login"])){
    	$localemail = optional_param("localemail","", PARAM_TEXT);
		$provideruid = optional_param("provideruid", "", PARAM_TEXT);
		$firstname  =  optional_param("firstname","", PARAM_TEXT);
		$lastname   =  optional_param("lastname","", PARAM_TEXT);
		$displayname =  optional_param("displayname","", PARAM_TEXT);
		$websiteurl =  optional_param("websiteurl","", PARAM_URL);
		$profileurl =  optional_param("profileurl","", PARAM_URL);

		// we didn't have their email given by the provider and they didn't have an authentication profile,
		// But now check if there is an account with this email.

		$u = new User();
		$u->setEmail($localemail);
		$user = $u->getByEmail();
		if($user instanceof User) {
			$isEmailValidated = $user->isEmailValidated();
			$status = $user->getStatus();
			if ($isEmailValidated &&
				($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED)){

				// if there is an existing account with this email address we need to validate they own it.
				// send email and redirect to a page to complete login

				// create an user authentication record and log them in
				$registrationKey = createRegistrationKey();

				$authentication = new UserAuthentication();
				$authentication->add($user->userid, $provider, $provideruid, $localemail, $registrationKey);

				// send email for validate ownership of email given.
				$paramArray = array ($u->name,$CFG->SITE_TITLE,$CFG->homeAddress,$authentication->authid,$registrationKey,urlencode($referrer));
				sendMail("validateexternal",$LNG->VALIDATE_REGISTER_SUBJECT,$u->getEmail(),$paramArray);

				$title = $LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART1." ".$providerDisplay." ".$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART2;
				$message = $LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART1." ".$providerDisplay." ".$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART2;

   				include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
				echo "<div class='messagediv2'><h1>".$title."</h1><p>".$message."</p></dir>";
				include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
				die;
			} else {
				$title = $LNG->LOGIN_EXTERNAL_TITLE;
				$message = "";

				if (!$isEmailValidated &&
					($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED)){
					$title = $LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE;
					$message = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED_EXISTING;
				} else if ($status == $CFG->USER_STATUS_UNVALIDATED) {
					$title = $LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE;
					$message = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED;
				} else if ($status == $CFG->USER_STATUS_UNAUTHORIZED) {
					$message = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNAUTHORIZED;
				} else if ($status == $CFG->USER_STATUS_SUSPENDED) {
					$message = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_SUSPENDED;
				}

   				include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
				echo "<div class='messagediv2'><h1>".$title."</h1><p>".$message."</p></dir>";
				include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
				die;
			}
		} else {
			//# 4 - Email not in use
			// then check for Evidence Hub SIGNUP STATUS and act as required

			if ($CFG->signupstatus == $CFG->SIGNUP_CLOSED) {
				array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_REGISTRATION_CLOSED);
			} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
				// If the SIGNUP is by request only, display a message with a link to the register request page
				array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_REQUIRES_AUTHORISATION);
			} else if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {

				$name = $firstname;
				if ($name != "") {
					if ($lastname != "") {
						$name .= " ".$lastname;
					}
				} else {
					$name = $displayname;
				}

				// If it is an open SIGNUP system, automatically create them a user account.
				$u = new User();
				$user = $u->add($localemail,$name,"",$websiteurl,'N',$provider);

				$registrationKey = $user->getRegistrationKey();
				$authentication = new UserAuthentication();
				$authentication->add($user->userid, $provider, $provideruid, $localemail, $registrationKey);

				// send email for validate ownership of email given, Validate email as External.
				$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$authentication->authid,$registrationKey,urlencode($referrer));
				sendMail("validateexternalnewuser",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

				$message = $LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART1." ".$providerDisplay;
				$message .= " ".$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART2;
				$message .= " ".$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3;

   				include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
				echo "<div class='messagediv2'><h1>".$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_TITLE."</h1><p>".$message."</p></dir>";
				include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
				die;
			}
		}

	// INITIAL REDIRECT FROM LOGIN
	} else if ($provider != "" && $CFG->SOCIAL_SIGNON_ON) {

		// SOCIAL SIGN ON REQUESTED AND REDIRECTED BACK (no idea why this is need, but it it)
   		if( isset( $_REQUEST["redirect_to_idp"] ) ) {

			$userprofile = loginExternal($provider,$errors);

			//print_r($userprofile);

			if ($userprofile instanceof Hybrid_User_Profile) {

				$email        = $userprofile->email;
				$provideruid  = $userprofile->identifier;
				$firstname    = $userprofile->firstName;
				$lastname     = $userprofile->lastName;
				$displayname  = $userprofile->displayName;
				$websiteurl   = $userprofile->webSiteURL;
				if (!isset($websiteurl)) {
					$websiteurl = "";
				}
				$profileurl   = $userprofile->profileURL;
				$emailVerified   = $userprofile->emailVerified;

				//# 1 - check if user already have authenticated using this provider before
				$auth = new UserAuthentication();
				$authentication = $auth->loadByProvider($provider, $provideruid);

				//# 2 - if authentication exists in the database, then we check the user account status
				// and if appropriate set the user as connected and redirect him
				// else display the relevant message.
				if( $authentication instanceof UserAuthentication){
					if ($authentication->isEmailVerified()) {
						$u = new User($authentication->getUserID());
						$user = $u->load();

						if($user instanceof User){
							$isEmailValidated = $user->isEmailValidated();
							$status = $user->getStatus();
							if ($isEmailValidated &&
								($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED)){

								createSession($user);
								$user->resetInvitationCode(); // hang over from Cohere groups code
								if ($fromembed) {
									include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
									echo "<script type='text/javascript'>";
									echo "if (window.opener) {";
									echo "	  window.opener.location.reload(false);";
									echo "}";
									echo "window.close();";
									echo "</script>";
									include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
									die;
								} else {
									header('Location: '. $referrer);
									exit();
								}
							} else {
								//NOTE, if UserAuthorisation account exists
								// then really only Account Suspension should ever happen.
								// But all checks added for completeness and security

								$title = $LNG->LOGIN_EXTERNAL_TITLE;
								$message = "";

								if (!$isEmailValidated &&
									($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED)){
									$title = $LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE;
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED_EXISTING;
								} else if ($status == $CFG->USER_STATUS_UNVALIDATED) {
									$title = $LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE;
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED;
								} else if ($status == $CFG->USER_STATUS_UNAUTHORIZED) {
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNAUTHORIZED;
								} else if ($status == $CFG->USER_STATUS_SUSPENDED) {
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_SUSPENDED;
								}

								include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
								echo "<div class='messagediv2'><h1>".$title."</h1><p>".$message."</p></dir>";
								include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
								die;
							}
						} else {
							array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_USER_LOAD_FAILED." ".$user->message);
						}
					} else {
						$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED;
						$message .= " ".$providerDisplay." ".$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2;
						array_push($errors, $message);
						$revalidateEmail = true;
					}
				} else {
					//# 3 - else, here lets check if the user email we got from the provider already exists in our database ( for this example the email is UNIQUE for each user )

					// if authentication does not exist, but the email address returned  by the provider does exist in database,
					// then we tell the user that the email is already in use

					//echo $email;

					if( isset($email) && $email != ""){
						$u = new User();
						$u->setEmail($email);
						$user = $u->getByEmail();
						if($user instanceof User) {
							$isEmailValidated = $user->isEmailValidated();
							$status = $user->getStatus();
							if ($isEmailValidated &&
								($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED)){

								// if there is an existing account with a validated email address
								// create an user authentication record and log them in

								// MERGE PROFILES?
								$registrationKey = createRegistrationKey();
								$authentication = new UserAuthentication();
								$authentication->add($user->userid, $provider, $provideruid, $email, $registrationKey);

								// email validation has happened through service provider so do not need to revalidate.
								if ($email == $emailVerified) {
									$authentication->completeVerification($registrationKey);
									createSession($user);
									$user->resetInvitationCode(); // hang over from Cohere groups code
									if ($fromembed) {
										include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
										echo "<script type='text/javascript'>";
										echo "if (window.opener) {";
										echo "	  window.opener.location.reload(false);";
										echo "}";
										echo "window.close();";
										echo "</script>";
										include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
										die;
									} else {
										header('Location: '.'');
									}
								} else {
									// send email for validate ownership of email given.
									$paramArray = array ($u->name,$CFG->SITE_TITLE,$CFG->homeAddress,$authentication->authid,$registrationKey,urlencode($referrer));
									sendMail("validateexternal",$LNG->VALIDATE_REGISTER_SUBJECT,$u->getEmail(),$paramArray);
									if(empty($errors)){
										$message = $LNG->LOGIN_EXTERNAL_FIRST_TIME." ".$providerDisplay;
										$message .= $LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART1." ".$providerDisplay." ".$LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART2;
										array_push($errors, $message);
									}
								}
							} else {
								$title = $LNG->LOGIN_EXTERNAL_TITLE;
								$message = "";

								if (!$isEmailValidated &&
									($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED)){
									$title = $LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE;
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED_EXISTING;
								} else if ($status == $CFG->USER_STATUS_UNVALIDATED) {
									$title = $LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE;
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED;
								} else if ($status == $CFG->USER_STATUS_UNAUTHORIZED) {
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNAUTHORIZED;
								} else if ($status == $CFG->USER_STATUS_SUSPENDED) {
									$message = $LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_SUSPENDED;
								}

								include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
								echo "<div class='messagediv2'><h1>".$title."</h1><p>".$message."</p></dir>";
								include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
								die;
							}
						} else {
							//# 4 - if authentication does not exist and email was given and is not in use,
							// then check for Evidence Hub SIGNUP STATUS and act as required

							if ($CFG->signupstatus == $CFG->SIGNUP_CLOSED) {
								array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_REGISTRATION_CLOSED);
							} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
								// If the SIGNUP is by request only, display a message with a link to the register request page
								array_push($errors, $LNG->LOGIN_EXTERNAL_ERROR_REQUIRES_AUTHORISATION);
							} else if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {

								$name = $firstname;
								if ($name != "") {
									if ($lastname != "") {
										$name .= " ".$lastname;
									}
								} else {
									$name = $displayname;
								}

								// If it is an open SIGNUP system, automatically create them a user account.
								$u = new User();
								$user = $u->add($email,$name,"",$websiteurl,'N',$provider);

								if ($user instanceof USER) {
									$registrationKey = $user->getRegistrationKey();
									$authentication = new UserAuthentication();
									$authentication->add($user->userid, $provider, $provideruid, $email, $registrationKey);

									// Check to see if the external provider has verified the email address.
									// If we are happy that they have, we trust that they are who they say.
									// So complete the registration process automatically and set the email addresses as validated.
									if ($email == $emailVerified) {
										$user->completeRegistration($registrationKey);
										$authentication->completeVerification($registrationKey);

										// send completion email to user
										$paramArray = array ($user->name,$CFG->SITE_TITLE,$LNG->WELCOME_REGISTER_OPEN_BODY);
										sendMail("welcome",$LNG->WELCOME_REGISTER_OPEN_SUBJECT,$user->getEmail(),$paramArray);

										createSession($user);

										header('Location: '.$CFG->homeAddress.'/ui/pages/welcomeexternal.php?provider='.$provider."&referer=".$referrer);
										exit();
									} else {
										// send email for validate ownership of email given, Validate email as External.
										$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$authentication->authid,$registrationKey,urlencode($referrer));
										sendMail("validateexternalnewuser",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

										include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
										echo "<div class='messagediv2'><h1>".$LNG->REGISTRATION_SUCCESSFUL_TITLE."</h1><p>".$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2."</p></dir>";
										include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
										die;
									}
								} else {
									array_push($errors, $user->message);
								}
							}
						}
					} else {
						$showEmailForm = true;
						$message = $LNG->LOGIN_EXTERNAL_FIRST_TIME." ".$providerDisplay;
						$message .= " ".$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART1." ".$providerDisplay;
						$message .= " ".$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART2;
						array_push($errors, $message);
					}
				}
			}
        } else {?>
			<script>
				window.location.href = window.location.href + "&redirect_to_idp=1";
			</script>
        <?php
        	die();
		}
    }

    include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
?>

<div style="margin-left:20px;">

<h1><?php echo $LNG->LOGIN_EXTERNAL_TITLE; ?></h1>

<?php
if(!empty($errors)){
    echo '<div style="width:500px;">';
    foreach ($errors as $error){
        echo $error.'<br><br>';
    }

    if ($revalidateEmail && isset($authentication) && isset($authentication->authid)) {
		echo '<form id="emailvalidation" action="" enctype="multipart/form-data" method="post">';
		echo '<input type="hidden" name="referrer" value="<?php print htmlentities($referrer); ?>"/>';
		echo '<input type="hidden" name="provider" value="<?php print $provider; ?>"/>';
		echo '<input type="hidden" name="fromembed" value="<?php print $fromembed; ?>"/>';
		echo '<input type="hidden" id="authid" name="authid" value="'.$authentication->authid.'" />';
		echo '<input type="hidden" id="validateemail" name="validateemail" value="" />';
		echo '<input type="submit" title="'.$LNG->EMAIL_VALIDATE_HINT.'" id="validateemail" name="validateemail" value="'.$LNG->EMAIL_VALIDATE_TEXT.'" />';
		echo '</form>';
    }

    echo '</div>';
}
?>

<?php if ($showEmailForm) { ?>
<form name="login" action="" method="post">
	<input type="hidden" name="referrer" value="<?php print htmlentities($referrer); ?>"/>
	<input type="hidden" name="provider" value="<?php print $provider; ?>"/>
	<input type="hidden" name="fromembed" value="<?php print $fromembed; ?>"/>

	<input type="hidden" name="provideruid" value="<?php print $provideruid; ?>"/>
	<input type="hidden" name="profileurl" value="<?php print $profileurl; ?>"/>
	<input type="hidden" name="firstname" value="<?php print $firstname; ?>"/>
	<input type="hidden" name="lastname" value="<?php print $lastname; ?>"/>
	<input type="hidden" name="websiteurl" value="<?php print $websiteurl; ?>"/>
	<input type="hidden" name="profileurl" value="<?php print $profileurl; ?>"/>

	<div class="formrownopad" style="margin-top:20px;">
		<label for="localemail" class="formlabelsm"><?php echo $LNG->LOGIN_USERNAME_LABEL; ?></label>
		<input class="forminput" id="localemail" name="localemail" size="40" value="">
	</div>
	<div class="formrownopad">
		<input class="formsubmitsm" style="margin-top:20px;" type="submit" value="<?php echo $LNG->LOGIN_LOGIN_BUTTON; ?>" id="login" name="login">
	</div>
</form>
<?php } ?>

</div>
<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>