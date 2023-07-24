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

    // check that user not already logged in
    if(isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
		exit();
    }

    $errors = array();
    $ref = optional_param("ref","",PARAM_URL);
    if ($ref == "") {
    	if (isset($_SERVER["REQUEST_URI"])) {
        	$ref = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        } else {
   			$ref = $CFG->homeAddress."index.php";
   		}
    }
    $fromembed = optional_param("fromembed","false",PARAM_BOOL);

	$revalidateEmail = false;

    // check to see if form submitted
    if(isset($_POST["login"])){
        $email = required_param("username",PARAM_TEXT);
        $password = required_param("password",PARAM_TEXT);

        $user = userLogin($email,$password);
        if($user instanceof Hub_Error) {
        	$error = $user;
           	array_push($errors, $error->message);
        	if ($error->code == $LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE) {
				$revalidateEmail = true;
        	}
        } else if ($user instanceof User) {
        	if (strlen($password) < 8) {
        		header('Location: '. $CFG->homeAddress.'/ui/pages/changepassword.php?update=y');
				exit();
        	} else {
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
	            	header('Location: '. $ref);
					exit();
	            }
	        }
            //header('Location: '. $ref);
        } else { // should never happen
        	if (empty($errors)) {
            	array_push($errors,$LNG->LOGIN_INVALID_ERROR);
            }
        }
    } else if (isset($_POST["validateemail"])) {
		// send email to validate email address
        $email = required_param("username",PARAM_TEXT);
		$user = new User();
		$user->setEmail($email);
		$user = $user->getByEmail();

		if (!$user->isEmailValidated()) {
			$user->resetRegistrationKey();
	   		$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$user->getRegistrationKey());
			sendMail("validateexisting",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

			echo '<script type="text/javascript">';
			echo 'fadeMessage("'.$user->name.'<br><br>'.$LNG->EMAIL_VALIDATE_MESSAGE.'");';
			echo '</script>';
		}
	}

    include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));
?>

<div class="container-fluid">
	<div class="row p-4 justify-content-center">	
		<div class="col-sm-12 col-lg-8">
			<h1><?php echo $LNG->LOGIN_TITLE; ?></h1>
			<?php if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
				<p><?php echo $LNG->LOGIN_NOT_REGISTERED_MESSAGE; ?> <a href="<?php echo $CFG->homeAddress; ?>ui/pages/registeropen.php"><?php echo $LNG->LOGIN_SIGNUP_OPEN_LINK; ?></a>
			<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
				<p><?php echo $LNG->LOGIN_NOT_REGISTERED_MESSAGE; ?> <a href="<?php echo $CFG->homeAddress; ?>ui/pages/requestregister.php"><?php echo $LNG->LOGIN_SIGNUP_REGISTER_LINK; ?></a>
			<?php } else { ?>
				<p><?php echo $LNG->LOGIN_INVITIATION_ONLY_MESSAGE; ?></p>
			<?php } ?>
			<?php
				if(!empty($errors)){
					echo "<div class='alert alert-danger'>".$LNG->FORM_ERROR_MESSAGE_LOGIN."<ul>";
					foreach ($errors as $error){
						echo "<li>".$error."</li>";
					}
					if ($revalidateEmail && isset($user) && isset($user->userid)) {
						echo '<form id="emailvalidation" action="" enctype="multipart/form-data" method="post">';
						echo '<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />';
						echo '<input type="hidden" id="validateemail" name="validateemail" value="" />';
						echo '<input type="submit" title="'.$LNG->EMAIL_VALIDATE_HINT.'" id="validateemail" name="validateemail" value="'.$LNG->EMAIL_VALIDATE_TEXT.'" />';
						echo '</form>';
					}
					echo "</ul></div>";
				}
			?>

			<form name="login" action="<?php echo $CFG->homeAddress; ?>ui/pages/login.php" method="post">
				<input type="hidden" name="fromembed" value="<?php print $fromembed; ?>"/>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="username"><?php echo $LNG->LOGIN_USERNAME_LABEL; ?></label>
					<div class="col-sm-9">
						<input class="form-control" id="username" name="username" value="">
					</div>
				</div>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="password"><?php echo $LNG->LOGIN_PASSWORD_LABEL; ?></label>
					<div class="col-sm-9">
						<input class="form-control" id="password" name="password" type="password" >
					</div>
				</div>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-between mb-3">
						<?php if ($CFG->send_mail) { ?>
							<p><a href="<?php echo $CFG->homeAddress; ?>ui/pages/forgot.php"><?php echo $LNG->LOGIN_FORGOT_PASSWORD_LINK; ?></a></p>
						<?php } else { ?>
							<p><?php echo $LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART1; ?> <a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>"><?php echo $LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART2; ?></a></p>
						<?php } ?>						
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->LOGIN_LOGIN_BUTTON; ?>" id="login" name="login" />
					</div>
				</div>

				<?php if ($CFG->SOCIAL_SIGNON_ON) {?>
					<div class="mt-4">
						<hr />
						<fieldset class="row justify-content-center">	
							<legend class="d-block text-center mb-3 h5"><?php echo $LNG->LOGIN_SOCIAL_SIGNON; ?></legend>
							<?php if ($CFG->SOCIAL_SIGNON_GOOGLE_ON) {?>
								<div class="col-auto"><a title="Sign-in with Google" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=google&referrer=<?php echo urlencode( $ref ); ?>&fromembed=<?php echo urlencode( $fromembed ); ?>"><i class="fab fa-google fa-2x" title="Google"></i><span class="sr-only">Sign-in with Google</span></a></div>
							<?php } ?>

							<?php if ($CFG->SOCIAL_SIGNON_YAHOO_ON) {?>
								<div class="col-auto"><a title="Sign-in with Yahoo" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=yahoo&referrer=<?php echo urlencode( $ref ); ?>&fromembed=<?php echo urlencode( $fromembed ); ?>"><i class="fab fa-yahoo fa-2x" title="Yahoo"></i><span class="sr-only">Sign-in with Yahoo</span></a></div>
							<?php } ?>

							<?php if ($CFG->SOCIAL_SIGNON_FACEBOOK_ON) {?>
								<div class="col-auto"><a title="Sign-in with Facebook" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=facebook&referrer=<?php echo urlencode( $ref ); ?>&fromembed=<?php echo urlencode( $fromembed ); ?>"><i class="fab fa-facebook-f fa-2x" title="Facebook"></i><span class="sr-only">Sign-in with Facebook</span></a></div>
							<?php } ?>

							<?php if ($CFG->SOCIAL_SIGNON_TWITTER_ON) {?>
								<div class="col-auto"><a title="Sign-in with Twitter" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=twitter&referrer=<?php echo urlencode( $ref ); ?>&fromembed=<?php echo urlencode( $fromembed ); ?>"><i class="fab fa-twitter fa-2x" title="Twitter"></i><span class="sr-only">Sign-in with Twitter</span></a></div>
							<?php } ?>

							<?php if ($CFG->SOCIAL_SIGNON_LINKEDIN_ON) {?>
								<div class="col-auto"><a title="Sign-in with LinkedIn" href="<?php echo $CFG->homeAddress; ?>ui/pages/loginexternal.php?provider=linkedin&referrer=<?php echo urlencode( $ref ); ?>&fromembed=<?php echo urlencode( $fromembed ); ?>"><i class="fab fa-linkedin-in fa-2x" title="LinkedIn"></i><span class="sr-only">Sign-in with LinkedIn</span></a></div>
							<?php } ?>
							<div class="text-center mt-3"><p><?php echo $LNG->CONDITIONS_LOGIN_FORM_MESSAGE; ?></p></div>
						</fieldset>
					</div>
				<?php } ?>

				<input type="hidden" name="ref" value="<?php print htmlentities($ref); ?>"/>
			</form>
		</div>
	</div>
</div>
<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>