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
 * translated by Alexandre Marino Costa
 *
 * This should eventually be broken up into separate files and become part of the internationalization of LiteMap
 */

/** LOGIN PAGE **/
$LNG->LOGIN_TITLE = 'Inicie a seção '.$CFG->SITE_TITLE;
$LNG->LOGIN_INVALID_ERROR = 'Inicio de seção não válida, por favor tente novamente.';
$LNG->LOGIN_NOT_REGISTERED_MESSAGE = '¿No momento você não esta registrado?';
$LNG->LOGIN_INVITIATION_ONLY_MESSAGE = 'O registro para este site atualmente é apenas por indicação.';
$LNG->LOGIN_SIGNUP_OPEN_LINK = 'Registrado!';
$LNG->LOGIN_SIGNUP_REGISTER_LINK = 'Registrado!';
$LNG->LOGIN_USERNAME_LABEL = 'Email:';
$LNG->LOGIN_PASSWORD_LABEL = 'Senha:';
$LNG->LOGIN_LOGIN_BUTTON = 'Iniciar seção';
$LNG->LOGIN_FORGOT_PASSWORD_LINK = '¿Entre com sua senha?';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART1 = '¿Entre com sua senha? Por favor';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART2 = 'Favor entrar em contato conosco';
$LNG->LOGIN_PASSWORD_LENGTH = 'Sua senha deve ter pelo menos 8 caracteres de longitude.';
$LNG->LOGIN_PASSWORD_LENGTH_UPDATE = 'Para maior segurança agora aplicamos uma longitude mínima de senha de 8 caracteres em novas contas.<br>Recomendamos aos titulares de contas existentes com senhas de 8 caracteres de longitude que restabeçam suas senhas agora.<br>Agradecemos por sua cooperação para o aumento da segurança deste site.';
$LNG->LOGIN_SOCIAL_SIGNON = 'Ou utilize outro serviço';

/** REGISTER PAGE **/
$LNG->FORM_REGISTER_OPEN_TITLE = 'Registro';
$LNG->FORM_REGISTER_REQUEST_TITLE = 'Solicitação de registro';
$LNG->FORM_REGISTER_ADMIN_TITLE = 'Registrar um novo usuário';
$LNG->FORM_REGISTER_EMAIL = 'Email:';
$LNG->FORM_REGISTER_DESC = 'Descrição:';
$LNG->FORM_REGISTER_PASSWORD = 'Senha:';
$LNG->FORM_REGISTER_PASSWORD_CONFIRM = 'Confirmar senha:';
$LNG->FORM_REGISTER_NAME = 'nome completo:';
$LNG->FORM_REGISTER_INTEREST = 'Interesse em LiteMap:';
$LNG->FORM_REGISTER_LOCATION = 'Localização: (estado/cidade)';
$LNG->FORM_REGISTER_COUNTRY = 'País...';
$LNG->FORM_REGISTER_HOMEPAGE = 'Página principal:';
$LNG->FORM_REGISTER_NEWSLETTER = 'Newsletter:';
$LNG->FORM_REGISTER_CAPTCHA = '¿Seres humano??';
$LNG->FORM_REGISTER_SUBMIT_BUTTON = 'Registro';
$LNG->FORM_REGISTER_REQUEST_DESC = 'Descrição pessoal:';
$LNG->FORM_REGISTER_IMAGE_ERROR = "Por favor editar o seu perfil e fazer upload de uma imagem diferente uma vez que você completar o seu registo.";

$LNG->REGISTRATION_SUCCESSFUL_TITLE = 'registro realizado com êxito';
$LNG->REGISTRATION_SUCCESSFUL_MESSAGE = 'Em breve você receberá um e-mail. Você deverá acessar o link para validar seu e-mail e completar seu registro.';
$LNG->REGISTRATION_COMPLETE_TITLE = 'Registro completado';
$LNG->REGISTRATION_FAILED = 'Seu registro não pode ser completado. Por favor, registre-se novamente';
$LNG->REGISTRATION_FAILED_INVALID = 'Seu registro não pode ser completado, a chave de registro não é válida para o usuário informado. Por favor, registre-se novamente';
$LNG->REGISTRATION_SUCCESSFUL_LOGIN = "Você pode agora <a href='".$CFG->homeAddress."ui/pages/login.php'>log in</a>";

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE = 'Solicitação de registro recebida';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE = 'Agradecemos seu interesse em contribuir com a LiteMap.<br>Su solicitação de registro foi enviado e você será contatado em breve.';

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE_ADMIN = 'Registro de usuário novo realizado com êxito';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE_ADMIN = "Um e-mail foi enviado ao novo usuário com detalhes de ingresso";

/** EXTERNAL LOGIN PAGES/SYSTEM **/
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_0 = 'Erro não especificado.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_1 = 'Erro de configuração Hybriauth.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_2 = 'Provedor não configurado corretamente.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_3 = 'Provedor desconhecido ou não capacitado.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_4 = 'Faltam credenciais da aplicação do provedor.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_5 = 'Erro de autenticação. O usuário cancelou a autenticação ou o provedor negou a conexão.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_6 = 'Solicitação de perfil de usuário falhou. O mais provável é que o usuário não está conectado ao provedor e deve tratar de autenticar de novo';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_7 = 'Usuário não está conectado ao provedor.';

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
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS = 'Uma conta de usuário LiteMap já existe neste site utilizando o endereço de e-mail que nos foi dado';

$LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE = 'Validar seu LiteMap endereço de email';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', mas essa conta de usuário não completou seu processo de registro.<br><br>Se você administra essa conta de usuário LiteMap tem que responder ao e-mail enviado para completar seu registro, antes de poder utilizar qualquer dos serviços externos para entrar neste Hub.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', mas essa conta de usuário LiteMap não foi validada nem seu endereço.<br><br>Se você administra essa conta de usuário LiteMap primero tem que <a href="'.$CFG->homeAddress.'ui/pages/login.php">Entrar</a> utilizando essa conta e validar seu endereço de e-mail em sua página de perfil, para poder utilizar qualquer dos serviços externos entrar para este HUB no futuro.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNAUTHORIZED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', sem embargo, esta conta esta pendente de autorização, por esse motivo não podemos entrar neste momento.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_SUSPENDED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', sem embargo, a conta atual foi suspendida, por esse motivo não podemos iniciar a seção neste momento.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART1 = 'Validar sua';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART2 = 'Endereço de email';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART1 = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.'. Para que podamos asociar su'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART2 = 'conta com esta conta de usuário LiteMap que primeiro tem que confirmar que você é o proprietário do endereço de e-mail que nos foi informado.<br><br>Therefore we have sent you an email. Por favor, faça clic no link para validar seu e-mail e completar o registro de seu perfil exterior conosco.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_TITLE = 'Registro realizado com êxito';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART1 = 'Não havia nenhuma conta de usuário LiteMap existente para o endereço de e-mail que nos foi informado, neste momento foi criada uma associação ao seu'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART2 = 'perfil.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 = '<br>Sem embargo, para completar seu registro conosco, primero deve confirmar que você é o propietario do endereço de e-mail que nos foi informado.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_WELCOME_TITLE = 'Bem-vindo ao LiteMap';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART1 = 'Não havia nenhuma conta de usuário LiteMap existente para o endereço de e-mail:';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART2 = ', para agora foi criada uma associação ao seu'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART3 = 'perfil.';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART4 = 'Você deve receber uma mensagem de boas vindas em breve.';

$LNG->LOGIN_EXTERNAL_ENTER_BUTTON = 'Informe o Site';

$LNG->VALIDATION_COMPLETE_TITLE = 'Endereço de e-mail de validação';
$LNG->VALIDATION_FAILED = 'Seu endereço de e-mail de validação não pode ser completar. Por favor, tente novamente';
$LNG->VALIDATION_FAILED_INVALID = 'Seu endereço de e-mail de validação não pode ser completado como a chave de validação não válida para o usuário informado. Por favor, tente novamente';
$LNG->VALIDATION_SUCCESSFUL_LOGIN = "Agradecemos por validar seu endereço de e-mail conosco.</a>";

$LNG->EMAIL_VALIDATE_TEXT = 'Enviar nova mensagem de validação';
$LNG->EMAIL_VALIDATE_HINT = 'Faça clic aquí para enviar outro e-mail de validação para que se possa completar seu registro deste perfil externo conosco.';
$LNG->EMAIL_VALIDATE_MESSAGE = 'Será enviado um e-mail para confirmar que você é o proprietário do endereço de e-mail que foi tentado para entrar com.';

/** CHANGE PASSWORD PAGE **/
$LNG->CHANGE_PASSWORD_TITLE = 'Trocar a senha';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_ERROR = 'Informe sua senha atual.';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_ERROR = 'Informe sua nova senha.';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_ERROR = 'Por favor, confirme sua nova senha.';
$LNG->CHANGE_PASSWORD_PASSWORD_INCORRECT_ERROR = 'Sua senha atual esta incorreta. Por favor, tente novamente.';
$LNG->CHANGE_PASSWORD_CONFIRM_MISSMATCH_ERROR = "A confirmação de senha não coincide.";
$LNG->CHANGE_PASSWORD_PROVIDE_PASSWORD_ERROR = 'Deve proporcionar uma senha.';
$LNG->CHANGE_PASSWORD_SUCCESSFUL_UPDATE = 'Senha atualizada corretamente';
$LNG->CHANGE_PASSWORD_BACK_TO_PROFILE = 'Ir ao meu Perfil';
$LNG->CHANGE_PASSWORD_GO_TO_MY_HOME = 'Ir a minha página';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_LABEL = 'Senha actual:';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_LABEL = 'Nova senha:';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_LABEL = 'Confirmar senha:';
$LNG->CHANGE_PASSWORD_UPDATE_BUTTON = 'Atualização';

/** FORGOT PASSWORD PAGE **/
$LNG->FORGOT_PASSWORD_TITLE = '¿Informe sua senha?';
$LNG->FORGOT_PASSWORD_HEADER_MESSAGE = "Informe o endereço de e-mail e te enviaremos um link que será possível  restabelecer sua senha.";
$LNG->FORGOT_PASSWORD_EMAIL_NOT_FOUND_ERROR = 'Endereço de e-mail não encontrado';
$LNG->FORGOT_PASSWORD_EMAIL_SUMMARY = 'Restabelecer senha de LiteMap';
$LNG->FORGOT_PASSWORD_EMAIL_SENT_MESSAGE = 'Um e-mail foi enviado para restabelecer sua senha.';
$LNG->FORGOT_PASSWORD_EMAIL_LABEL = 'Email:';
$LNG->FORGOT_PASSWORD_SUBMIT_BUTTON = 'Submeter';
?>
