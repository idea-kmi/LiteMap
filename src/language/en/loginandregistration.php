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
/**
 * login&registration.php
 *
 * Michelle Bachler (KMi)
 *
 * This should eventually be broken up into separate files and become part of the internationalization of LiteMap
 */

/** LOGIN PAGE **/
$LNG->LOGIN_TITLE = 'Sign In to the '.$CFG->SITE_TITLE;
$LNG->LOGIN_INVALID_ERROR = 'Invalid Sign In, please try again.';
$LNG->LOGIN_NOT_REGISTERED_MESSAGE = 'Not yet registered?';
$LNG->LOGIN_INVITIATION_ONLY_MESSAGE = 'Registration for this site is currently by invitation only.';
$LNG->LOGIN_SIGNUP_OPEN_LINK = 'Sign Up!';
$LNG->LOGIN_SIGNUP_REGISTER_LINK = 'Sign Up!';
$LNG->LOGIN_USERNAME_LABEL = 'Email:';
$LNG->LOGIN_PASSWORD_LABEL = 'Password:';
$LNG->LOGIN_LOGIN_BUTTON = 'Login';
$LNG->LOGIN_FORGOT_PASSWORD_LINK = 'Forgotten password?';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART1 = 'Forgotten password? Please';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART2 = 'Contact Us';
$LNG->LOGIN_PASSWORD_LENGTH = 'Your password must be at least 8 characters long.';
$LNG->LOGIN_PASSWORD_LENGTH_UPDATE = 'For added security we now enforce a minimum password length of 8 characters on new accounts.<br>We recommend to existing account holders with passwords under 8 characters in length that they reset their passwords now.<br>Thank you for your co-operation in increasing security on this site.';
$LNG->LOGIN_SOCIAL_SIGNON = 'Or use another service';

/** REGISTER PAGE **/
$LNG->FORM_REGISTER_OPEN_TITLE = 'Register';
$LNG->FORM_REGISTER_REQUEST_TITLE = 'Registration Request';
$LNG->FORM_REGISTER_ADMIN_TITLE = 'Register a New User';
$LNG->FORM_REGISTER_EMAIL = 'Email:';
$LNG->FORM_REGISTER_DESC = 'Description:';
$LNG->FORM_REGISTER_PASSWORD = 'Password:';
$LNG->FORM_REGISTER_PASSWORD_CONFIRM = 'Confirm Password:';
$LNG->FORM_REGISTER_NAME = 'Full name:';
$LNG->FORM_REGISTER_INTEREST = 'Interest in LiteMap:';
$LNG->FORM_REGISTER_LOCATION = 'Location: (town/city)';
$LNG->FORM_REGISTER_COUNTRY = 'Country...';
$LNG->FORM_REGISTER_HOMEPAGE = 'Homepage:';
$LNG->FORM_REGISTER_NEWSLETTER = 'Newsletter:';
$LNG->FORM_REGISTER_CAPTCHA = 'Are you human?';
$LNG->FORM_REGISTER_SUBMIT_BUTTON = 'Register';
$LNG->FORM_REGISTER_REQUEST_DESC = 'Personal Description:';
$LNG->FORM_REGISTER_IMAGE_ERROR = "Please edit your profile and upload a different image once you complete your registration.";

$LNG->REGISTRATION_SUCCESSFUL_TITLE = 'Registration Successful';
$LNG->REGISTRATION_SUCCESSFUL_MESSAGE = 'You will shortly receive an email. You must click on the link inside it to validate your email address and complete your registration.';
$LNG->REGISTRATION_COMPLETE_TITLE = 'Registration Complete';
$LNG->REGISTRATION_FAILED = 'Your registration could not be completed. Please try registering again';
$LNG->REGISTRATION_FAILED_INVALID = 'Your registration could not be completed as the Registration key was invalid for the given user. Please try registering again';
$LNG->REGISTRATION_SUCCESSFUL_LOGIN = "You can now <a href='".$CFG->homeAddress."ui/pages/login.php'>log in</a>";

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE = 'Registration Request Recieved';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE = 'Thank you for your interest in contributing to LiteMap.<br>Your registration request has been sent and you will be contacted shortly.';

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE_ADMIN = 'Registration of new user successful';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE_ADMIN = "An email has been sent to the new User with their Sign In details";

/** EXTERNAL LOGIN PAGES/SYSTEM **/
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_0 = 'Unspecified error.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_1 = 'Hybriauth configuration error.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_2 = 'Provider not properly configured.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_3 = 'Unknown or disabled provider.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_4 = 'Missing provider application credentials.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_5 = 'Authentication failed. The user has canceled the authentication or the provider refused the connection.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_6 = 'User profile request failed. Most likely the user is not connected to the provider and he should try to authenticate again';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_7 = 'User not connected to the provider.';

$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED = 'A LiteMap user account already exists on this site using the email address from your external profile, but that user account has not completed the registration process.<br>If you own that user account you need to reply to the email you where sent to complete your registration, before you can Sign In.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = 'A LiteMap user account already exists on this site using the email address from your external profile, but that LiteMap user account has not had the email address verify yet.<br><br>If you own that LiteMap user account you first need to <a href="'.$CFG->homeAddress.'ui/pages/login.php">Sign In</a> using that account and verify your email address from your profile page, before you can use any external services to Sign In to this Hub in the future.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNAUTHORIZED = 'A LiteMap user account already exists using the email address from your external profile, however that account is awaiting authorization, so we cannot log you in at this time.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_SUSPENDED = 'A LiteMap user account already exists on this site using the email address on your external profile, however the account has currently been suspended, so we cannot log you in at this time.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED = 'It seems you have tried to sign in with'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 = 'before but did not complete the email validation required.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 .= '<br><br>Please respond to the email you where sent, before you try to Sign In with this service again.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 .= '<br><br>Alternatively, request another validation email by clicking the button below.';
$LNG->LOGIN_EXTERNAL_ERROR_USER_LOAD_FAILED = 'Failed to load user acount: ';
$LNG->LOGIN_EXTERNAL_ERROR_REGISTRATION_CLOSED = "Based on the email address given we can see that you do not have an account with us yet.<br><br>Unfortunately registration on this site is currently by invitation only.";
$LNG->LOGIN_EXTERNAL_ERROR_REQUIRES_AUTHORISATION = 'Based on the email address given we can see that you do not have an account with us yet.<br><br>This LiteMap currently requires registration requests to be authorised.<br>So please go to the <a href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">Sign Up</a> page and complete the registration request form.';

$LNG->LOGIN_EXTERNAL_FIRST_TIME = 'We can see that this is the first time you have tried to sign in to this site using'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART1 = '<br><br>Unfortunately the email address on the profile information they hold on you has not been verified by them. So before we can associated this external profile to an account in our Hub we need to validate the email address.<br><br>Therefore you have now been sent an email. Please click on the link in the email to complete the registration of your'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART2 = 'profile on this Hub.';

$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART1 = '<br><br>Unfortunately'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART2 = 'has not given us your email address, so we cannot check if you have an account with us already or create a new one if required.<br><br>Therefore, please enter the Email address you wish to use on this LiteMap below and press Login.';

$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE .= 'You will shortly receive an email.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE .= '<br>You must click on the link inside to complete your registration on this Hub.';

$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 = 'There was no existing Hub user account for the email address on your external profile, so we have now created one and associated it to that external profile.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 .= '<br>However, the email address has not been validated by the external service provider, so before we can complete your registration we must first validate that email address belongs to you.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_TITLE = 'Social Sign On';

$LNG->LOGIN_EXTERNAL_COMPLETE_TITLE = 'SOCIAL SIGN ON - Completing Email Validation';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED = 'The Social sign on record associated with the given id is no longer available. Please try Signing Up/In again';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED = 'Your email validation could not be completed as the record id given was invalid. Please try Signing Up/In again';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_USER = 'The existing User account that is associated with the given email address is no longer available';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_INVALID = 'Your email validation could not be completed as the validation key given was invalid for the given external provider record id. <br><br>Please try again using a different provider, or create a local LiteMap account';
$LNG->LOGIN_EXTERNAL_REGISTER_COMPLETE_FAILED = 'Your registration could not be completed as the user id given did not belong to the external provider record given.<br><br>Please try again using a different provider, or create a local LiteMap account';

// Messages used when the provider didn't supply the email address so the user was asked to
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS = 'An LiteMap user account already exists on this site using the email address you have given us';

$LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE = 'Validate Your LiteMap Email Address';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', but that user account has not completed its registration process.<br><br>If you own that LiteMap user account you need to reply to the email you where sent to complete your registration, before you can use any external services to Sign In to this Hub.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', but that LiteMap user account has not had its email address validated yet.<br><br>If you own that LiteMap user account you first need to <a href="'.$CFG->homeAddress.'ui/pages/login.php">Sign In</a> using that account and validate your email address from your profile page, before you can use any external services to Sign In to this Hub in the future.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNAUTHORIZED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', however that account is awaiting authorization, so we cannot log you in at this time.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_SUSPENDED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', however the account has currently been suspended, so we cannot log you in at this time.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART1 = 'Validate Your';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART2 = 'Email Address';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART1 = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.'. In order for us to associate your'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART2 = 'account with this LiteMap user account we first need to validate that you are the owner of the email address you have given us.<br><br>Therefore we have sent you an email. Please click on the link inside to validate your email address and complete the registration of your external profile with us.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_TITLE = 'Registration Successful';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART1 = 'There was no existing LiteMap user account for the email address you have given us, so we have now created one and associated it to your'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART2 = 'profile.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 = '<br>However, to complete your registration with us we must first validate that you are the owner of the email address you have given us.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_WELCOME_TITLE = 'Welcome to LiteMap';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART1 = 'There was no existing LiteMap user account for the email address:';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART2 = ', so we have now created one and associated it to your'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART3 = 'profile.';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART4 = 'You should receive a welcome email shortly.';

$LNG->LOGIN_EXTERNAL_ENTER_BUTTON = 'Enter Site';

$LNG->VALIDATION_COMPLETE_TITLE = 'Email Address Validation';
$LNG->VALIDATION_FAILED = 'Your email address validation could not be completed. Please try again';
$LNG->VALIDATION_FAILED_INVALID = 'Your email address validation could not be completed as the Validation key was invalid for the given user. Please try again';
$LNG->VALIDATION_SUCCESSFUL_LOGIN = "Thank you for validating your email address with us.</a>";

$LNG->EMAIL_VALIDATE_TEXT = 'Send New Validation Email';
$LNG->EMAIL_VALIDATE_HINT = 'Click here to be sent another validation email for you to complete your registration of this external profile with us.';
$LNG->EMAIL_VALIDATE_MESSAGE = 'You have been sent an email to validate that you own the email address you tried to Sign In with.';

/** CHANGE PASSWORD PAGE **/
$LNG->CHANGE_PASSWORD_TITLE = 'Change Password';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_ERROR = 'Please enter your current password.';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_ERROR = 'Please enter your new password.';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_ERROR = 'Please confirm your new password.';
$LNG->CHANGE_PASSWORD_PASSWORD_INCORRECT_ERROR = 'Your current password is incorrect. Please try again.';
$LNG->CHANGE_PASSWORD_CONFIRM_MISSMATCH_ERROR = "The password and password confirmation don't match.";
$LNG->CHANGE_PASSWORD_PROVIDE_PASSWORD_ERROR = 'You must provide a password.';
$LNG->CHANGE_PASSWORD_SUCCESSFUL_UPDATE = 'Password successfully updated';
$LNG->CHANGE_PASSWORD_BACK_TO_PROFILE = 'Go To My Profile';
$LNG->CHANGE_PASSWORD_GO_TO_MY_HOME = 'Go To My Home Page';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_LABEL = 'Current Password:';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_LABEL = 'New Password:';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_LABEL = 'Confirm Password:';
$LNG->CHANGE_PASSWORD_UPDATE_BUTTON = 'Update';

/** FORGOT PASSWORD PAGE **/
$LNG->FORGOT_PASSWORD_TITLE = 'Forgotten password?';
$LNG->FORGOT_PASSWORD_HEADER_MESSAGE = "Please enter your email address and we'll send you a link where you can reset your password.";
$LNG->FORGOT_PASSWORD_EMAIL_NOT_FOUND_ERROR = 'Email address not found';
$LNG->FORGOT_PASSWORD_EMAIL_SUMMARY = 'Reset LiteMap password';
$LNG->FORGOT_PASSWORD_EMAIL_SENT_MESSAGE = 'An email has been sent for you to reset your password.';
$LNG->FORGOT_PASSWORD_EMAIL_LABEL = 'Email:';
$LNG->FORGOT_PASSWORD_SUBMIT_BUTTON = 'Submit';
?>