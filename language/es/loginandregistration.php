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
$LNG->LOGIN_TITLE = 'Inicie sesión '.$CFG->SITE_TITLE;
$LNG->LOGIN_INVALID_ERROR = 'Inicio de sesión no válido, por favor inténtelo de nuevo.';
$LNG->LOGIN_NOT_REGISTERED_MESSAGE = '¿Todavía no estás registrado?';
$LNG->LOGIN_INVITIATION_ONLY_MESSAGE = 'El registro para este sitio actualmente es sólo por invitación.';
$LNG->LOGIN_SIGNUP_OPEN_LINK = 'Regístrate!';
$LNG->LOGIN_SIGNUP_REGISTER_LINK = 'Regístrate!';
$LNG->LOGIN_USERNAME_LABEL = 'Email:';
$LNG->LOGIN_PASSWORD_LABEL = 'Contraseña:';
$LNG->LOGIN_LOGIN_BUTTON = 'Iniciar sesión';
$LNG->LOGIN_FORGOT_PASSWORD_LINK = '¿Olvidó su contraseña?';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART1 = '¿Olvidó su contraseña? Por favor';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART2 = 'Contacte con nosotros';
$LNG->LOGIN_PASSWORD_LENGTH = 'Tu contraseña debe tener al menos 8 caracteres de longitud.';
$LNG->LOGIN_PASSWORD_LENGTH_UPDATE = 'Para mayor seguridad ahora aplicamos una longitud mínima de contraseña de 8 caracteres en nuevas cuentas.<br>Recomendamos a los titulares de cuentas existentes con contraseñas de 8 caracteres de longitud que restablezcan sus contraseñas ahora.<br>Gracias por su cooperación que en el aumento de la seguridad de este sitio.';
$LNG->LOGIN_SOCIAL_SIGNON = 'O utiliza otro servicio';

/** REGISTER PAGE **/
$LNG->FORM_REGISTER_OPEN_TITLE = 'Registro';
$LNG->FORM_REGISTER_REQUEST_TITLE = 'Solicitud de registro';
$LNG->FORM_REGISTER_ADMIN_TITLE = 'REgistrar un nuevo usuario';
$LNG->FORM_REGISTER_EMAIL = 'Email:';
$LNG->FORM_REGISTER_DESC = 'Descripción:';
$LNG->FORM_REGISTER_PASSWORD = 'Contraseña:';
$LNG->FORM_REGISTER_PASSWORD_CONFIRM = 'Confirmar contraseña:';
$LNG->FORM_REGISTER_NAME = 'nombre completo:';
$LNG->FORM_REGISTER_INTEREST = 'Interes en LiteMap:';
$LNG->FORM_REGISTER_LOCATION = 'Ubicación: (pueblo/ciudad)';
$LNG->FORM_REGISTER_COUNTRY = 'País...';
$LNG->FORM_REGISTER_HOMEPAGE = 'Página principal:';
$LNG->FORM_REGISTER_NEWSLETTER = 'Newsletter:';
$LNG->FORM_REGISTER_CAPTCHA = '¿Eres humano??';
$LNG->FORM_REGISTER_SUBMIT_BUTTON = 'Registro';
$LNG->FORM_REGISTER_REQUEST_DESC = 'Descripción personal:';
$LNG->FORM_REGISTER_IMAGE_ERROR = "Por favor, editar tu perfil y subir una imagen diferente una vez que complete su registro.";

$LNG->REGISTRATION_SUCCESSFUL_TITLE = 'registro realizado con éxito';
$LNG->REGISTRATION_SUCCESSFUL_MESSAGE = 'En breve recibirás un correo electrónico. Debe hacer clic en el enlace para validar su correo electrónico y completar su registro.';
$LNG->REGISTRATION_COMPLETE_TITLE = 'REgistro completado';
$LNG->REGISTRATION_FAILED = 'Su registro no se pudo completar. Por favor, registrate de nuevo';
$LNG->REGISTRATION_FAILED_INVALID = 'Su registro no se pudo completar, la clave de registro no era válida para el usuario dado. Por favor, registrate de nuevo';
$LNG->REGISTRATION_SUCCESSFUL_LOGIN = "Tu puedes ahora <a href='".$CFG->homeAddress."ui/pages/login.php'>log in</a>";

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE = 'Solicitud de registro recibida';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE = 'Gracias por su interés en contribuir a LiteMap.<br>Su solicitud de registro ha sido enviado y usted será contactado en breve.';

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE_ADMIN = 'Registro de usuario nuevo realizado con éxito';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE_ADMIN = "Un correo electrónico ha sido enviado al nuevo usuario con detalles de ingreso";

/** EXTERNAL LOGIN PAGES/SYSTEM **/
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_0 = 'Error inespecífico.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_1 = 'Error de configuración Hybriauth.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_2 = 'Proveedor no configurado correctamente.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_3 = 'Proveedor Desconocido o no capacitado.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_4 = 'Faltan credenciales de la aplicación del proveedor.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_5 = 'Error de autenticación. El usuario ha cancelado la autentificación o el proveedor negó la conexión.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_6 = 'Solicitud de perfil de usuario falló. Lo más probable es que el usuario no está conectado al proveedor y debe tratar de autentificarse de nuevo';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_7 = 'Usuario no está conectado al proveedor.';

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

$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE = 'You will shortly receive an email.';
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
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS = 'Una cuenta de usuario LiteMap ya existe en este sitio utilizando la dirección de correo electrónico que nos ha dado';

$LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE = 'Validar su LiteMap dirección de email';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', pero esa cuenta de usuario no ha completado su proceso de registro.<br><br>Si usted administra esa cuenta de usuario LiteMap tienes que responder al correo electrónico a donde envió para completar su registro, antes de poder utilizar cualquiera de los servicios externos entrar para este Hub.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', pero esa cuenta de usuario de LiteMap no había validado aún su dirección.<br><br>Si usted administra esa cuenta de usuario LiteMap primero tiene que <a href="'.$CFG->homeAddress.'ui/pages/login.php">Entrar</a> utilizando esa cuenta y validar su dirección de correo de su página de perfil, para poder utilizar cualquiera de los servicios externos entrar para este HUB en el futuro.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNAUTHORIZED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', sin embargo, esta cuenta esta pendiente de la autorización, por lo que no podemos entrar en este momento.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_SUSPENDED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', sin embargo, la cuenta en la actualidad se ha suspendido, por lo que no se puede iniciar sesión en este momento.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART1 = 'Validar su';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART2 = 'Dirección de email';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART1 = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.'. Para que podamos asociar su'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART2 = 'cuenta con esta cuenta de usuario LiteMap que primero tiene que validar que usted es el propietario de la dirección de correo electrónico que nos ha dado.<br><br>Therefore we have sent you an email. Por favor, haga clic en el enlace dentro de validar su correo electrónico y completar el registro de su perfil exterior con nosotros.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_TITLE = 'Registro realizado con éxito';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART1 = 'No había ninguna cuenta de usuario LiteMap existente para la dirección de correo electrónico que nos has dado, por lo que ahora han creado una asociado a su'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART2 = 'perfil.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 = '<br>Sin embargo, para completar su registro con nosotros, primero debe validar que usted es el propietario de la dirección de correo electrónico que nos ha dado.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_WELCOME_TITLE = 'Bienvenido LiteMap';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART1 = 'No había ninguna cuenta de usuario LiteMap existente para la dirección de correo electrónico:';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART2 = ', por lo que ahora hemos creado una asociado a su'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART3 = 'perfil.';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART4 = 'Usted debe recibir un mensaje de bienvenida en breve.';

$LNG->LOGIN_EXTERNAL_ENTER_BUTTON = 'Introduzca Site';

$LNG->VALIDATION_COMPLETE_TITLE = 'Dirección de correo electrónico de validación';
$LNG->VALIDATION_FAILED = 'Tu dirección de correo electrónico de validación no se pudo completar. Por favor, inténtalo de nuevo';
$LNG->VALIDATION_FAILED_INVALID = 'Tu dirección de correo electrónico de validación no se pudo completar como la clave de validación no era válida para el usuario dado. Por favor, inténtalo de nuevo';
$LNG->VALIDATION_SUCCESSFUL_LOGIN = "Gracias por validar su dirección de correo electrónico con nosotros.</a>";

$LNG->EMAIL_VALIDATE_TEXT = 'Enviar Nuevo mensaje de validación';
$LNG->EMAIL_VALIDATE_HINT = 'Haga clic aquí para enviar otro correo electrónico de validación para que pueda completar su registro de este perfil externo con nosotros.';
$LNG->EMAIL_VALIDATE_MESSAGE = 'Se le ha enviado un correo electrónico para validar que es el propietario de la dirección de correo electrónico que ha intentado entrar con.';

/** CHANGE PASSWORD PAGE **/
$LNG->CHANGE_PASSWORD_TITLE = 'Cambiar la contraseña';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_ERROR = 'Introduzca su contraseña actual.';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_ERROR = 'Introduzca su nueva contraseña.';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_ERROR = 'Por favor, confirme su nueva contraseña.';
$LNG->CHANGE_PASSWORD_PASSWORD_INCORRECT_ERROR = 'Su contraseña actual es incorrecta. Por favor, inténtalo de nuevo.';
$LNG->CHANGE_PASSWORD_CONFIRM_MISSMATCH_ERROR = "La confirmación de la contraseña y la contraseña no coinciden.";
$LNG->CHANGE_PASSWORD_PROVIDE_PASSWORD_ERROR = 'Debe proporcionar una contraseña.';
$LNG->CHANGE_PASSWORD_SUCCESSFUL_UPDATE = 'Contraseña actualizada correctamente';
$LNG->CHANGE_PASSWORD_BACK_TO_PROFILE = 'Ir a mi Perfil';
$LNG->CHANGE_PASSWORD_GO_TO_MY_HOME = 'Ir a mi página';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_LABEL = 'Contraseña actual:';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_LABEL = 'Nueva contraseña:';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_LABEL = 'Confirmar contraseña:';
$LNG->CHANGE_PASSWORD_UPDATE_BUTTON = 'Actualización';

/** FORGOT PASSWORD PAGE **/
$LNG->FORGOT_PASSWORD_TITLE = '¿Olvidó su contraseña?';
$LNG->FORGOT_PASSWORD_HEADER_MESSAGE = "Introduzca su dirección de correo electrónico y te enviaremos un enlace donde se puede restablecer su contraseña.";
$LNG->FORGOT_PASSWORD_EMAIL_NOT_FOUND_ERROR = 'Dirección de email no encontrada';
$LNG->FORGOT_PASSWORD_EMAIL_SUMMARY = 'Restablecer contraseña de LiteMap';
$LNG->FORGOT_PASSWORD_EMAIL_SENT_MESSAGE = 'Un correo electrónico ha sido enviado para restablecer su contraseña.';
$LNG->FORGOT_PASSWORD_EMAIL_LABEL = 'Email:';
$LNG->FORGOT_PASSWORD_SUBMIT_BUTTON = 'Presentar';
?>