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
 * admin.php
 *
 * Michelle Bachler (KMi)
 * Translation: Thomas Ullmann (KMi)
 */

$LNG->ADMIN_CREATE_LINK_TYPES_TITLE = 'Linktypen erstellen';
$LNG->ADMIN_CREATE_NODE_TYPES_TITLE = 'Benutzertypen erstellen';

$LNG->ADMIN_TITLE = "Bereich f&uuml;r Administratoren";
$LNG->ADMIN_BUTTON_HINT = "&Ouml;ffnet in einem neuen Fenster";
$LNG->ADMIN_STATS_BUTTON_HINT = "F&uuml;hrt zur Seite Analyse";
$LNG->ADMIN_REGISTER_NEW_USER_LINK = 'Registriere einen neuen Benutzer';
$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE = 'Sie m&uuml;ssen ein Adminstrator sein, um diese Seite besuchen zu k&ouml;nnen.';
$LNG->ADMIN_MANAGE_USERS_DELETE_ERROR = 'Es gab einen Fehler beim L&ouml;schen des Benutzers mit der folgenden ID:';

/** ADMIN USER REGISTRATION MANAGER **/
$LNG->REGSITRATION_ADMIN_MANAGER_LINK = "Anfrage zur Registrierung";
$LNG->REGSITRATION_ADMIN_TITLE = 'Verwaltung der Benutzerregistrierung';

$LNG->REGSITRATION_ADMIN_UNREGISTERED_TITLE = "Anfrage zur Registrierung";
$LNG->REGSITRATION_ADMIN_UNVALIDATED_TITLE = "Ung&uuml;lgite Registrierung";
$LNG->REGSITRATION_ADMIN_REVALIDATE_BUTTON = "Erneute validieren";
$LNG->REGSITRATION_ADMIN_REMOVE_BUTTON = "L&ouml;schen";
$LNG->REGSITRATION_ADMIN_REMOVE_CHECK_MESSAGE = "Sind Sie sicher, dass Sie die Registrierung des Nutzers l&ouml;schen m&ouml;chten?: ";
$LNG->REGSITRATION_ADMIN_REVALIDATE_CHECK_MESSAGE = "Sind Sie sicher, dass Sie eine weitere E-Mail zur Validierung an diesen Nutzer schicken m&ouml;chten?: ";
$LNG->REGSITRATION_ADMIN_USER_REMOVED = 'Account wurde im System gel&ouml;scht';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REVALIDATED = 'wurde eine E-Mail geschickt um mitzuteilen, dass die Anfrage wegen der Registrierung akzeptiert wurde';

$LNG->REGSITRATION_ADMIN_REJECT_CHECK_MESSAGE = "Sind Sie sicher, dass Sie die Ameldungsanfrage des Nutzers zur&uuml;ckweisen wollen?: ";
$LNG->REGSITRATION_ADMIN_ACCEPT_CHECK_MESSAGE = "Sind Sie sicher, dass sie die Anmelunngsanfrage des Nutzers akzeptieren m&ouml;chten?: ";
$LNG->REGSITRATION_ADMIN_NONE_MESSAGE = 'Derzeit gibt es keine Nutzer, die eine Anmeldung angefordert haben.';
$LNG->REGSITRATION_ADMIN_VALIDATION_NONE_MESSAGE = 'Es liegen noch keine Benutzer erwartet Validierung';
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_NAME = "Name";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_DESC = "Beschreibung";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_INTEREST = "Interesse";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_WEBSITE = "Webseite";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION = "Aktion";
$LNG->REGSITRATION_ADMIN_REJECT_BUTTON = 'Ablehnen';
$LNG->REGSITRATION_ADMIN_ACCEPT_BUTTON = 'Akzeptieren';
$LNG->REGSITRATION_ADMIN_ID_ERROR = "Die Anfrage des Nutzers konnte nicht bearbeitet werden, da die Nutzer ID fehlt";
$LNG->REGSITRATION_ADMIN_USER_EMAILED_ACCEPTANCE = 'wurde per E-Mail Benachrichtigt, dass die Registrierungsanfrage akzeptiert wurde';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REJECTION = 'wurde per E-Mail angeschrieben, dass die Registrierungsanfrage zur&uuml;ckgewiesen wurde';
$LNG->REGSITRATION_ADMIN_EMAIL_REQUEST_SUBJECT = "Registrierungsanfrage f&uuml;r ".$CFG->SITE_TITLE;

// %s will be replace with the name of the current Site. When translating please leave this in the sentence appropariately placed.
$LNG->REGSITRATION_ADMIN_EMAIL_REJECT_BODY = 'Vielen Dank f&uumlr; Ihre Registrierungsanfrage f&uuml;r %s.<br>Leider war Ihre Registrierungsanfrage f&uuml;r einen Benutzeraccount derzeit nicht erfolgreich.';

/** SPAM MANAGEMENT **/
$LNG->SPAM_ADMIN_MANAGER_SPAM_LINK = "Gemeldete Artikel";
$LNG->SPAM_ADMIN_SPAM_TITLE = "Gemeldete Artikel";
$LNG->SPAM_ADMIN_ARCHIVE_TITLE = "Archivierte Elemente";
$LNG->SPAM_ADMIN_TITLE = "Gemeldete Eintr&auml;ge Manager";
$LNG->SPAM_ADMIN_ID_ERROR = "Konnte die Anfrage nicht verarbeiten, da die Knoten ID fehlte";
$LNG->SPAM_ADMIN_TABLE_HEADING0 = "Gemeldet von";
$LNG->SPAM_ADMIN_TABLE_HEADING1 = "Titel";
$LNG->SPAM_ADMIN_TABLE_HEADING2 = "Aktion";
$LNG->SPAM_ADMIN_TABLE_HEADING3 = "Knotentyp";
$LNG->SPAM_ADMIN_DELETE_CHECK_MESSAGE = "Sind Sie sicher, dass Sie diesen Eintrag l&ouml;schen wollen?: ";
$LNG->SPAM_ADMIN_RESTORE_CHECK_MESSAGE = "Sind Sie sicher, dass Sie dies als kein Spam setzen m&ouml;chten?: ";
$LNG->SPAM_ADMIN_ARCHIVE_CHECK_MESSAGE = "Sind Sie sicher, dass Sie dieses Element archivieren möchten?: ";
$LNG->SPAM_ADMIN_RESTORE_BUTTON = "Wiederherstellen";
$LNG->SPAM_ADMIN_ARCHIVE_BUTTON = "Archiv";
$LNG->SPAM_ADMIN_DELETE_BUTTON = "L&ouml;schen";
$LNG->SPAM_ADMIN_VIEW_BUTTON = "Details anschauen";
$LNG->SPAM_ADMIN_NONE_MESSAGE = 'Derzeit gibt es keine Eintr&auml;ge, die als SPAM / nicht geeignet gemeldet wurden';

$LNG->SPAM_USER_ADMIN_TABLE_HEADING0 = "Gemeldet von";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING1 = "Benutzername";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING2 = "Aktion";
$LNG->SPAM_USER_ADMIN_VIEW_BUTTON = "Sehen Sie die Nutzerstartseite";
$LNG->SPAM_USER_ADMIN_VIEW_HINT = "&Ouuml;ffnet ein neues Fenster der Startseite dieses Nutzers";
$LNG->SPAM_USER_ADMIN_RESTORE_BUTTON = "Wiederherstellung des Accounts";
$LNG->SPAM_USER_ADMIN_RESTORE_HINT = "Setze diesen Nutzeraccount auf aktiv";
$LNG->SPAM_USER_ADMIN_DELETE_BUTTON = "L&ouml;sche Account";
$LNG->SPAM_USER_ADMIN_DELETE_HINT = "L&ouml;sche diesen Nutzeraccount und all Daten";
$LNG->SPAM_USER_ADMIN_SUSPEND_BUTTON = "Suspendiere diesen Account";
$LNG->SPAM_USER_ADMIN_SUSPEND_HINT = "Suspendieren Sie diesen Benutzeraccount und verhindern Sie, dass sich der Nutzer erneut einloggen kann";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "Sind Sie sicher, dass Sie den Nutzer l&ouml;schen m&ouml;chten: ";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Warnung: all Ihre Daten werden unwiderruflich gel&ouml;scht. Wenn Sie es noch nicht gemacht haben, dann sollten Sie diesen Beitrag zuvor pr&uuml;fen indem Sie hier klicken '".$LNG->SPAM_USER_ADMIN_VIEW_BUTTON."'";;
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "Sind Sie sicher, dass Sie den Account wiederherstellen m&ouml;chten? Benutzer: ";
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "Dies wird den Benutzer von der Liste widerrufen";
$LNG->SPAM_USER_ADMIN_SUSPEND_CHECK_MESSAGE = "Sind Sie sicher, dass sie den Account suspendieren m&ouml;chten? Benutzer: ";
$LNG->SPAM_USER_ADMIN_NONE_MESSAGE = 'Derzeit gibt es keine Nutzer, die als Spammer / ungeeignet gemeldet wurden';
$LNG->SPAM_USER_ADMIN_TITLE = "Verwaltung der Benutzereint&auml;ge";
$LNG->SPAM_USER_ADMIN_MANAGER_SPAM_LINK = "Gemeldete Nutzer";
$LNG->SPAM_USER_ADMIN_ID_ERROR = "Der Prozess kann nicht verarbeitet werden, da die Nutzer ID fehlt";
$LNG->SPAM_USER_ADMIN_NONE_SUSPENDED_MESSAGE = 'Derzeit ist kein Nutzer suspendiert';
$LNG->SPAM_USER_ADMIN_SPAM_TITLE = 'Gemeldete Nutzer';
$LNG->SPAM_USER_ADMIN_SUSPENDED_TITLE = 'Nutzer suspendiert';

$LNG->SPAM_GROUP_REPORTED = 'Die Gruppe wurde als Spammer/Unangemessen gemeldet';
$LNG->SPAM_GROUP_REPORT = 'Melden Sie diese Gruppe als Spam/Unangemessen';
$LNG->SPAM_GROUP_LOGIN_REPORT = 'Melden Sie sich an, um diese Gruppe als Spam/Unangemessen zu melden';
$LNG->SPAM_GROUP_REPORTED_ALT = 'Gemeldet';
$LNG->SPAM_GROUP_REPORT_ALT = 'Bericht';
$LNG->SPAM_GROUP_LOGIN_REPORT_ALT = 'Zum Melden anmelden';
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING0 = "Berichtet von";
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING1 = "Gruppenname";
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 = "Aktion";
$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON = "Gruppe anzeigen";
$LNG->SPAM_GROUP_ADMIN_VIEW_HINT = "Öffnen Sie ein neues Fenster mit der Homepage dieser Gruppe";
$LNG->SPAM_GROUP_ADMIN_RESTORE_BUTTON = "Gruppe wiederherstellen";
$LNG->SPAM_GROUP_ADMIN_RESTORE_HINT = "Setzen Sie diese Gruppe wieder auf aktiv";
$LNG->SPAM_GROUP_ADMIN_DELETE_BUTTON = "Gruppe löschen";
$LNG->SPAM_GROUP_ADMIN_DELETE_HINT = "Diese Gruppe löschen";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_BUTTON = "Archivieren Sie diese Gruppe";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_HINT = "Archivieren Sie diese Gruppe und alle darin enthaltenen Karten";
$LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "Sind Sie sicher, dass Sie die Gruppe löschen möchten:";
$LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Seien Sie gewarnt: Gruppenmitglieder werden aus der Gruppe entfernt und mit der Gruppe verbundene Knoten und Triples verlieren diese Verbindung. Wenn Sie dies noch nicht getan haben, sollten Sie zunächst die Gruppenmitglieder und Inhalte durch Klicken überprüfen '".$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON."'";;
$LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "Sind Sie sicher, dass Sie die Gruppe wiederherstellen möchten: ";
$LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "Dadurch wird diese Gruppe aus dieser Liste entfernt";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_CHECK_MESSAGE = "Sind Sie sicher, dass Sie die Gruppe archivieren möchten:";
$LNG->SPAM_GROUP_ADMIN_NONE_MESSAGE = 'Derzeit sind keine Gruppen als Spammer/Unangemessen gemeldet';
$LNG->SPAM_GROUP_ADMIN_TITLE = "Gruppenberichtsmanager";
$LNG->SPAM_GROUP_ADMIN_MANAGER_SPAM_LINK = "Gemeldete Gruppen";
$LNG->SPAM_GROUP_ADMIN_ID_ERROR = "Die Anfrage kann nicht verarbeitet werden, da die Gruppen-ID fehlt";
$LNG->SPAM_GROUP_ADMIN_NONE_ARCHIVED_MESSAGE = 'Derzeit sind keine Gruppen archiviert';
$LNG->SPAM_GROUP_ADMIN_SPAM_TITLE = 'Gemeldete Gruppen';
$LNG->SPAM_GROUP_ADMIN_ARCHIVED_TITLE = 'Gruppen archiviert';

/** NEWS ADMINSTRATION **/
$LNG->ADMIN_MANAGE_NEWS_LINK = "Verwalte ".$LNG->NEWSS_NAME;
$LNG->ADMIN_MANAGE_NEWS_DELETE_ERROR = 'Es gab ein Problem bei der L&ouml;schen von '.$LNG->NEWS_NAME.' mit der ID:';
$LNG->ADMIN_NEWS_MISSING_NAME_ERROR = 'Sie m&uuml;ssen einen '.$LNG->NEWS_NAME.' Titel eingeben.';
$LNG->ADMIN_NEWS_ID_ERROR  = 'Fehler bei der Verarbeitung von '.$LNG->NEWS_NAME.' ID.';
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART1 = 'Sind Sie sicher, dass Sie dies l&ouml;schen m&ouml;chten '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART2 = '?';
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART1 = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART2 = 'ist nun gel&ouml;scht.';
$LNG->ADMIN_NEWS_TITLE = "Verwalte ".$LNG->NEWSS_NAME;
$LNG->ADMIN_NEWS_ADD_NEW_LINK = 'F&ouml;ge hinzu '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_NAME_LABEL = 'Titel:';
$LNG->ADMIN_NEWS_DESC_LABEL = 'Beschreibung:';
$LNG->ADMIN_NEWS_TITLE_HEADING = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_ACTION_HEADING = 'Aktion';
$LNG->ADMIN_NEWS_EDIT_LINK = 'editieren';
$LNG->ADMIN_NEWS_DELETE_LINK = 'l&ouml;schen';

/** USER STATS **/
$LNG->ADMIN_NEWS_USERS = 'Benutzer';
$LNG->ADMIN_NEWS_GROUPS = 'Gruppen';
$LNG->ADMIN_DASHBOARD = 'Admin-Dashboard';
?>
