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
/**
 * login&registration.php
 *
 * Michelle Bachler (KMi)
 *
 * This should eventually be broken up into separate files and become part of the internationalization of LiteMap
 */

/** LOGIN PAGE **/
$LNG->LOGIN_TITLE = 'Anmelden '.$CFG->SITE_TITLE;
$LNG->LOGIN_INVALID_ERROR = 'Anmeldung nicht möglich, bitte versuchen Sie es erneut.';
$LNG->LOGIN_NOT_REGISTERED_MESSAGE = 'Noch nicht registriert?';
$LNG->LOGIN_INVITIATION_ONLY_MESSAGE = ' Eine Registrierung für diese Seite ist momentan nur nach Einladung möglich.';
$LNG->LOGIN_SIGNUP_OPEN_LINK = 'Anmelden!';
$LNG->LOGIN_SIGNUP_REGISTER_LINK = 'Anmelden!';
$LNG->LOGIN_USERNAME_LABEL = 'Email:';
$LNG->LOGIN_PASSWORD_LABEL = 'Passwort:';
$LNG->LOGIN_LOGIN_BUTTON = 'Einloggen';
$LNG->LOGIN_FORGOT_PASSWORD_LINK = 'Passwort vergessen?';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART1 = 'Passwort vergessen? Bitte';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART2 = 'Kontaktieren Sie uns';
$LNG->LOGIN_PASSWORD_LENGTH = 'Ihr Passwort muss mindestens 8 Zeichen lang sein.';
$LNG->LOGIN_PASSWORD_LENGTH_UPDATE = 'Für zusätzliche Sicherheit wir jetzt erzwingen eine minimale Passwortlänge von 8 Zeichen für neue Konten . <br> Wir empfehlen, bestehende Kontoinhabern mit Passwörtern unter 8 Zeichen lang , dass sie ihre Passwörter. <br> Vielen Dank für Ihre Zusammenarbeit zurückgesetzt jetzt bei der Erhöhung der Sicherheit auf dieser Website.';
$LNG->LOGIN_SOCIAL_SIGNON = 'Oder benutzen Sie einen anderen Dienst';

/** REGISTER PAGE **/
$LNG->FORM_REGISTER_OPEN_TITLE = 'Registrierung';
$LNG->FORM_REGISTER_REQUEST_TITLE = 'Registrierungsanfrage';
$LNG->FORM_REGISTER_ADMIN_TITLE = 'Einen neuen Benutzer registrieren';
$LNG->FORM_REGISTER_EMAIL = 'Email:';
$LNG->FORM_REGISTER_DESC = 'Beschreibung:';
$LNG->FORM_REGISTER_PASSWORD = 'Passwort:';
$LNG->FORM_REGISTER_PASSWORD_CONFIRM = 'Passwort bestätigen:';
$LNG->FORM_REGISTER_NAME = 'Vor- und Zuname:';
$LNG->FORM_REGISTER_INTEREST = 'Interesse an LiteMap:';
$LNG->FORM_REGISTER_LOCATION = 'Ort';
$LNG->FORM_REGISTER_COUNTRY = 'Land...';
$LNG->FORM_REGISTER_HOMEPAGE = 'Homepage:';
$LNG->FORM_REGISTER_NEWSLETTER = 'Newsletter:';
$LNG->FORM_REGISTER_CAPTCHA = 'Sind Sie ein Mensch?';
$LNG->FORM_REGISTER_SUBMIT_BUTTON = 'Registrieren';
$LNG->FORM_REGISTER_REQUEST_DESC = 'Steckbrief:';
$LNG->FORM_REGISTER_IMAGE_ERROR = "Bearbeiten Sie Ihr Profil und lade ein anderes Bild , wenn Sie Ihre Registrierung abzuschließen.";

$LNG->REGISTRATION_SUCCESSFUL_TITLE = 'Registrierung erfolgreich';
$LNG->REGISTRATION_SUCCESSFUL_MESSAGE = 'Sie werden in Kürze eine E-Mail erhalten. Darin müssen Sie auf den link klicken, um Ihre Email-Adresse zu bestätigen und Ihre Registrierung abzuschließen.';
$LNG->REGISTRATION_COMPLETE_TITLE = 'Registrierung abgeschlossen';
$LNG->REGISTRATION_FAILED = 'Ihre Registrierung konnte nicht abgeschlossen werden. Bitte versuchen Sie es später noch einmal';
$LNG->REGISTRATION_FAILED_INVALID = 'Ihre Registrierung konnte nicht abgeschlossen werden, weil der dargestellte Registrieungs-Schlüssel ungültig war. Bitte versuchen Sie es noch einmal';
$LNG->REGISTRATION_SUCCESSFUL_LOGIN = "Sie können nun <a href='".$CFG->homeAddress."ui/pages/login.php'>log in</a>";

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE = 'Registrierungsanfrage erhalten';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE = 'Vielen Dank für Ihr Interesse an LiteMap.<br>Ihre Registrierungsanfrage wurde versendet und Sie werden in Kürze angeschrieben.';

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE_ADMIN = 'Registrierung des neuen Nutzers erfolgreich';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE_ADMIN = "Eine Email mit den Zugangsdaten wurde an den neuen Benutzer versendet";

/** EXTERNAL LOGIN PAGES/SYSTEM **/
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_0 = 'Unbekannter Fehler.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_1 = 'Hybrider Konfigurationsfehler.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_2 = 'Provider nicht richtig konfiguriert.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_3 = 'Unbekannter oder deaktivierter Anbieter.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_4 = 'Fehlende Anbieter-Anwendungs- und Anmeldeinformationen.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_5 = 'Authentifizierung fehlgeschlagen. Der Benutzer hat die Authentifizierung abgebrochen, oder der Anbieter hat der Verbindung nicht zu gestimmt.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_6 = 'Benutzerprofil-Anforderung fehlgeschlagen. Wahrscheinlich ist der Benutzer nicht mit dem Provider verbunden, und er sollte eine Authentifizierung erneut versuchen';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_7 = 'User not connected to the provider.';

$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED = 'Es existiert bereits ein LiteMap-Konto mit der gleichnamigen Email-Adresse, aber der Benutzer hat den Anmelde-Prozess nicht abgeschlossen.<br> Wenn dies Ihr Benutzerkonto ist, sollten Sie die Email beantworten, die Ihnen gesendet wurde, um Ihre Registrierung abzuschließen, damit Sie sich anmelden können.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = 'Es existiert bereits ein LiteMap-Konto mit der gleichnamigen Email-Adresse, aber LiteMap konnte die Email-Adresse bis jetzt nicht verifizieren.<br><br>Wenn dies Ihr LiteMap-Benutzerkonto ist, müssen Sie zuerst<a href="'.$CFG->homeAddress.'ui/pages/login.php">Sign In</a> und auf Ihrer Profilseite die Email-Adresse bestätigen, bevor Sie die externen Dienste und das Hub nutzen können.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNAUTHORIZED = 'Es existiert bereits ein LiteMap-Konto mit der gleichnamigen Email-Adresse , und das Konto wartet auf Genehmigung. Deshalb können Sie sich derzeit nicht einloggen.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_SUSPENDED = 'Es existiert bereits ein LiteMap-Konto mit der gleichnamigen Email-Adresse, aber das Konto ist im Moment inaktiv, weshalb Sie sich derzeit nicht einloggen können.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED = 'Es scheint als hätten Sie versucht, sich mit einem dieser Anbieter einzuloggen'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 = 'Die Email-Validierung wurde noch nicht abgeschlossen.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 .= '<br><br>Bitte antworten Sie auf die Email, die wir Ihnen gesendet haben, bevor Sie versuchen, sich anzumelden. Vielen Dank!';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 .= '<br><br> Alternativ können Sie mit einem Klick auf den Button unten erneut eine Verifizierungs-Email anfordern.';
$LNG->LOGIN_EXTERNAL_ERROR_USER_LOAD_FAILED = 'Fehler beim Laden des Benutzeraccounts: ';
$LNG->LOGIN_EXTERNAL_ERROR_REGISTRATION_CLOSED = "Basierend auf der E-Mail-Adresse, die Sie angegeben haben, können wir sehen, dass Sie noch nicht über ein Konto bei uns verfügen.<br><br>Leider ist eine Registrierung derzeit nur auf Einladung möglich.";
$LNG->LOGIN_EXTERNAL_ERROR_REQUIRES_AUTHORISATION = 'Basierend auf der E-Mail-Adresse, die Sie angegeben haben, können wir sehen, dass Sie noch nicht über ein Konto bei uns verfügen.<br><br>Sie müssen sich registrieren, um LiteMap nutzen zu können.<br>Bitte klincken Sie hier: <a href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">Sign Up</a> Dort können Sie ein Registrierungs-Formular ausfüllen.';

$LNG->LOGIN_EXTERNAL_FIRST_TIME = 'Wir können sehen, dass Sie zum ersten Mal diese Seite besuchen - wahrscheinlich sind Sie über einen dieser Anbieter auf unsere Seite gekommen'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART1 = '<br><br>Leider ist die Email-Adresse, mit der Sie sich versuchen anzumelden, nicht durch den jeweiligen Anbieter überprüft. Bevor wir das Profil auf dem Hub für Sie freigeben können, müssen wir die Email-Adresse überprüfen. <br><br>Dazu wurde Ihnen eine Email gesendet. Bitte klicken Sie darin auf den link, um die Registrierung bei Ihrem jeweiligen Anbieter abzuschließen:'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART2 = 'Profil auf diesem Hub.';

$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART1 = '<br><br>Leider hat uns'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART2 = ' nicht Ihre Email-Adresse mitgeteilt, so dass wir nicht überprüfen können, ob Sie bereits einen Account bei uns haben. Bitte erstellen Sie falls nötig, einen neuen.<br><br>Dazu tippen Sie bitte Ihre für LiteMap gewünschte Email-Addresse unten ein und klicken auf Login.';

$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE = 'Sie werden in Kürze eine Email erhalten.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE .= '<br>Sie müssen darin auf den link klicken, um die Registrierung für dieses Hub abzuschließen.';

$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 = 'Es gab kein Hub-Benutzerkonto für Ihre Emailadresse - also haben wir eines erstellt und  so we have now created one and es mit Ihrem KOnto verknüpft.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 .= '<br>Die E-Mail-Adresse ist jedoch nicht vom externen Dienstleister validiert. Bevor Sie also Ihre Registrierung abschließen können, müssen wir erst sicherstellen, dass dies Ihre Email-Adresse ist.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_TITLE = 'Social Sign On';

$LNG->LOGIN_EXTERNAL_COMPLETE_TITLE = 'SOCIAL SIGN ON - Email-Bestätigung abschließen';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED = 'Das Social sign on record mit dieser ID ist nicht mehr verfügbar. Bitte versuchen Sie sich erneut anzumelden.';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED = 'Ihre Email-Bestätigung konnte nicht abgeschlossen werden, weil die  zugewiesene ID ungültig ist. Bitte versuchen Sie sich erneut anzumelden.';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_USER = 'Das bestehende Benutzerkonto, das mit der angebenen Email-Adresse verknüpft ist, ist nicht mehr verfügbar.';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_INVALID = 'Ihre Email-Bestätigung konnte nicht abgeschlossen werden, weil der vom externen Provider zugewiesene Validierungsschlüssel ungültig war. <br><br>Bitte versuchen Sie es mit einem anderen Provider noch einmal, oder erstellen Sie ein lokales LiteMap-Benutzerkonto.';
$LNG->LOGIN_EXTERNAL_REGISTER_COMPLETE_FAILED = 'Ihre Registrierung konnte nicht abgeschlossen werden, da die zugewiesene Benutzer-ID dem externen Provider nicht zugewiesen werden konnte..<br><br>Bitte versuchen Sie es mit einem anderen Provider noch einmal, oder erstellen Sie ein lokales LiteMap-Benutzerkonto.';

// Messages used when the provider didn't supply the email address so the user was asked to
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS = 'Es besteht bereits ein LiteMap-Benutzerkonto auf dieser Seite, das die von Ihnen mitgeteile Email-Adresse benutzt.';

$LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE = 'Bestätigen Sie Ihre LiteMap-Email-Adresse.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', aber dieses Benutzerkonto hat den Anmeldevorgang bis jetzt nicht abgschlossen.<br><br>Wenn Sie der Eigentümer dieses LiteMap-Benutzerkontos sind, müssen Sie die erhaltene Email beantworten, um die Registrierung abzuschließen, bevor Sie die externen Dienste nutzen können, um sich in dieses Hub einzuloggen.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', aber dieses LiteMap-Benutzerkonto hat bis jetzt nicht die Email-Adresse bestätigt.<br><br>Wenn Sie der Eigentümer dieses LiteMap-Benutzerkontos sind, müssen Sie zuerst <a href="'.$CFG->homeAddress.'ui/pages/login.php">Sign In</a> und auf Ihrer Profilseite Ihre Emailadresse bestätigen, bevor Sie die externen Dienste nutzen können, um sich zukünftig in dieses Hub einzuloggen.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNAUTHORIZED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', Dieses Konto wartet jedoch noch auf Autorisierung, so dass wir Sie zum jetzigen Zeitpunkt nicht einloggen können.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_SUSPENDED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', Das KOnto ist jedoch derzeit deaktiviert, so dass wir Sie zum jetzigen Zeitpunkt nicht einloggen können.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART1 = 'Bestätigen Sie Ihre';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART2 = 'Email-Addresse';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART1 = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.'. Damit wir dieses LiteMap-Benutzerkonto einem Konto zuordnen können:'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART2 = 'zuerst müssen wir sicherstellen, dass Sie der Eigentümer der uns mitgeteilten Email-Adresse sind.<br><br>Dazu haben wir Ihnen eine Email gesendet. Bitte klicken Sie auf den link darin, um Ihre Email-Adresse zu bestätigen und schließen somit Ihre Registrierung ab.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_TITLE = 'Registrierung erfolgreich';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART1 = 'Es existierte kein LiteMap-Benutzerkonto für die uns mitgeteilte Email-Adresse, also haben wir eines erstellt und mit Ihrem Konto verbunden:'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART2 = '.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 = '<br>Jeodch müssen wir, um Ihre Registrierung abzuschlißen, zuerst überprüfen, dass sie der Eigentümer der uns mitgeteilten Email-Adresse sind.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_WELCOME_TITLE = 'Willkommen bei LiteMap';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART1 = 'Es bestand kein LiteMap-Benutzerkonto für diese Email-Adresse:';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART2 = ', also haben wir eines erstellt und Ihrem Konto '; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART3 = 'zugeordnet.';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART4 = 'In Kürze sollten Sie eine Email erhalten.';

$LNG->LOGIN_EXTERNAL_ENTER_BUTTON = 'Seite aufrufen';

$LNG->VALIDATION_COMPLETE_TITLE = 'Email-Bestätigung';
$LNG->VALIDATION_FAILED = 'Ihre Email-Adressen-Bestätigung konnte nicht abgeschlossen werden. Bitte versuchen Sie es erneut.';
$LNG->VALIDATION_FAILED_INVALID = 'Ihre Email-Adressen-Bestätigung konnte nicht abgeschlossen werden, da der Bestätigungs-Schlüssel des Nutzers ungültig war. Bitte versuchen Sie es erneut.';
$LNG->VALIDATION_SUCCESSFUL_LOGIN = "Vielen Dank für die Bestätigung Ihrer Email-Adresse.</a>";

$LNG->EMAIL_VALIDATE_TEXT = 'Neue Bestätigungs-Email senden';
$LNG->EMAIL_VALIDATE_HINT = 'Klicken Sie hier, um eine neue Bestätigungs-Email zu erhalten, um Ihre Registrierung bei uns abzuschließen.';
$LNG->EMAIL_VALIDATE_MESSAGE = 'Sie haben eine neue Email erhalten, um zu bestätigen, dass Sie der Eigentümer der Email-Adresse sind, mit der Sie sich einloggen wollten.';

/** CHANGE PASSWORD PAGE **/
$LNG->CHANGE_PASSWORD_TITLE = 'Passwort ändern';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_ERROR = 'Bitte tregen Sie Ihr aktuelles Passwort ein.';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_ERROR = 'Bitte tragen Sie Ihr neues Passwort ein.';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_ERROR = 'Bitte bestätigen Sie Ihr neues Passwort.';
$LNG->CHANGE_PASSWORD_PASSWORD_INCORRECT_ERROR = 'Ihr akutelles Passwort ist nicht korrekt. Bitte versuchen Sie es erneut.';
$LNG->CHANGE_PASSWORD_CONFIRM_MISSMATCH_ERROR = "Beide neuen Passwörter stimmen nicht überein.";
$LNG->CHANGE_PASSWORD_PROVIDE_PASSWORD_ERROR = 'Sie müssen ein Passwort angeben.';
$LNG->CHANGE_PASSWORD_SUCCESSFUL_UPDATE = 'Passwort erfolgreich geändert';
$LNG->CHANGE_PASSWORD_BACK_TO_PROFILE = 'Gehe zu Mein Profil';
$LNG->CHANGE_PASSWORD_GO_TO_MY_HOME = 'Gehe zu meiner Home Page';
$LNG->CHANGE_PASSWORD_CURRENT_PASSWORD_LABEL = 'Aktuelles Passwort:';
$LNG->CHANGE_PASSWORD_NEW_PASSWORD_LABEL = 'Neues Passwort:';
$LNG->CHANGE_PASSWORD_CONFIRM_PASSWORD_LABEL = 'Passwort bestätigen:';
$LNG->CHANGE_PASSWORD_UPDATE_BUTTON = 'Aktualisieren';

/** FORGOT PASSWORD PAGE **/
$LNG->FORGOT_PASSWORD_TITLE = 'Passwort vergessen?';
$LNG->FORGOT_PASSWORD_HEADER_MESSAGE = "Bitte tragen Sie Ihre Email-Adresse ein und wir werden Ihnen einen link senden, mit dem Sie Ihr Passwort zurücksetzen können.";
$LNG->FORGOT_PASSWORD_EMAIL_NOT_FOUND_ERROR = 'Email-Adresse nicht gefunden';
$LNG->FORGOT_PASSWORD_EMAIL_SUMMARY = 'LiteMap- Passwort zurücksetzen';
$LNG->FORGOT_PASSWORD_EMAIL_SENT_MESSAGE = 'Sie haben eine Email erhalten, um Ihr Passwort zurückzusetzen.';
$LNG->FORGOT_PASSWORD_EMAIL_LABEL = 'Email:';
$LNG->FORGOT_PASSWORD_SUBMIT_BUTTON = 'Bestätigen';
?>
