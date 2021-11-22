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
 * users.php
 *
 * Michelle Bachler (KMi)
 */

/** SPAM REPORTING OF USERS **/
$LNG->SPAM_USER_REPORTED = 'Nutzer wurde als Spammer gemeldet';
$LNG->SPAM_USER_REPORT = 'Melden Sie diesen Nutzer als Spammer';
$LNG->SPAM_USER_LOGIN_REPORT = 'Einloggen, um Nutzer oder Gruppe als Spam zu melden';
$LNG->SPAM_USER_REPORTED_ALT = 'Gemeldet';
$LNG->SPAM_USER_REPORT_ALT = 'Melden';
$LNG->SPAM_USER_LOGIN_REPORT_ALT = 'Einloggen, um zu melden';

/** USER AREA **/
$LNG->TAB_USER_DATA = 'Meine Dateien';
$LNG->TAB_USER_GROUP = 'Meine '.$LNG->GROUPS_NAME;
$LNG->TAB_USER_SOCIAL = 'Mein Soziales Netzwerk';
$LNG->TAB_USER_HOME = 'Meine Seite';
$LNG->TAB_USER_MAP = 'Mein'.$LNG->MAPS_NAME_SHORT;
$LNG->TAB_USER_CHALLENGE = 'Mein '.$LNG->CHALLENGES_NAME_SHORT;
$LNG->TAB_USER_ISSUE = 'Mein '.$LNG->ISSUES_NAME_SHORT;
$LNG->TAB_USER_SOLUTION = 'Mein '.$LNG->SOLUTIONS_NAME_SHORT;
$LNG->TAB_USER_PRO = 'Mein '.$LNG->PROS_NAME_SHORT;
$LNG->TAB_USER_CON = 'Mein '.$LNG->CONS_NAME;
$LNG->TAB_USER_EVIDENCE = 'Mein '.$LNG->ARGUMENTS_NAME_SHORT;
$LNG->TAB_USER_RESOURCE = 'Mein '.$LNG->RESOURCES_NAME_SHORT;
$LNG->TAB_USER_CHAT = 'Mein '.$LNG->CHATS_NAME;
$LNG->TAB_USER_COMMENT = 'Mein '.$LNG->COMMENTS_NAME;
$LNG->TAB_USER_USED_COMMENT = 'Meine verwendeten'.$LNG->COMMENTS_NAME;

$LNG->LIST_NAV_USER_NO_CON = "Kein ".$LNG->CONS_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_PRO = "Kein ".$LNG->PROS_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_ISSUE = "Kein ".$LNG->ISSUES_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_SOLUTION = "Kein ".$LNG->SOLUTIONS_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_EVIDENCE = "Kein ".$LNG->ARGUMENTS_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_RESOURCE = "Kein ".$LNG->RESOURCES_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_COMMENT = "Kein ".$LNG->COMMENTS_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_MAP = "Kein ".$LNG->MAPS_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_CHALLENGE = "Kein ".$LNG->CHALLENGES_NAME.' gefunden';
$LNG->LIST_NAV_USER_NO_CHAT = "Kein ".$LNG->CHATS_NAME.' gefunden';

/** USER HOME PAGE **/
$LNG->USER_HOME_LOCATION_LABEL = 'Ort:';
$LNG->USER_HOME_TABLE_ITEM_TYPE = 'Artikeltyp';
$LNG->USER_HOME_TABLE_CREATION_COUNT = 'Zähler über Erstellung';
$LNG->USER_HOME_TABLE_VIEW = 'Ansehen';
$LNG->USER_HOME_TABLE_TYPE = 'Typ';
$LNG->USER_HOME_TABLE_NAME = 'Name';
$LNG->USER_HOME_TABLE_ACTION = 'Aktion';
$LNG->USER_HOME_TABLE_PICTURE = 'Bild';
$LNG->USER_HOME_PROFILE_HEADING = 'Profil';
$LNG->USER_HOME_VIEW_CONTENT_HEADING = 'Zusammenfassung über erstellten Inhalt';
$LNG->USER_HOME_VIEW_ACTIVITIES_LINK = "( Alle Aktivitäten dieses Nutzers ansehen )";
$LNG->USER_HOME_VIEW_ACTIVITIES_HINT =  "Dies öffnet ein neues Fenster und könnte etwas Zeit zum Laden benötigen - je nach Umfang der Aktivitäten des Nutzers";
$LNG->USER_HOME_FOLLOWING_HEADING = 'folgen';
$LNG->USER_HOME_ACTIVITY_ALERT = 'Bei neuer Aktivität Benachrichtigung senden';
$LNG->USER_HOME_EMAIL_HOURLY = 'Stündlich';
$LNG->USER_HOME_EMAIL_DAILY = 'Täglich';
$LNG->USER_HOME_EMAIL_WEEKLY = 'Wöchentlich';
$LNG->USER_HOME_EMAIL_MONTHLY = 'Monatlich';
$LNG->USER_HOME_PERSON_LABEL = 'Person';
$LNG->USER_HOME_UNFOLLOW_LINK = 'nicht mehr folgen';
$LNG->USER_HOME_EXPLORE_LINK = 'untersuchen';
$LNG->USER_HOME_ACTIVITY_LINK = 'Aktivität';
$LNG->USER_HOME_NOT_FOLLOWING_MESSAGE = 'Folgt derzeit weder Nutzern noch Artikeln.';
$LNG->USER_HOME_FOLLOWERS_HEADING = 'Followers';
$LNG->USER_HOME_NO_FOLLOWERS_MESSAGE = 'Derzeit keine Follower.';
$LNG->USER_HOME_ANALYTICS_LINK_TEXT = '( Statistiken für diesen Nutzer ansehen )';
$LNG->USER_HOME_ANALYTICS_LINK_HINT =  "Dies öffnet ein neues Fenster und könnte etwas Zeit zum Laden benötigen - je nach Umfang der Aktivitäten des Nutzers";

/** USERS **/
$LNG->USERS_UNFOLLOW = 'Diesem Nutzer nicht mehr folgen...';
$LNG->USERS_FOLLOW = 'Diesem Nutzer folgen...';
$LNG->USERS_FOLLOW_ICON_ALT = 'Follow';
$LNG->USERS_STARTED_FOLLOWING_ON = 'Hat angefangen diesem Nutzer zu folgen:';
$LNG->USERS_LAST_LOGIN = 'Letze Anmeldung:';
$LNG->USERS_LAST_ACTIVE = 'Zuletzt aktiv:';
$LNG->USERS_DATE_JOINED = 'Anmeldedatum:';

/** USER PAGE **/
$LNG->USER_FOLLOW_HINT = 'Diesem Nutzer folgen...';
$LNG->USER_FOLLOW_BUTTON = 'folgen';
$LNG->USER_UNFOLLOW_HINT = 'Diesem Nutzer nicht mehr folgen...';
$LNG->USER_UNFOLLOW_BUTTON = 'Nicht mehr folgen';
$LNG->USER_RSS_HINT = 'Ein RSS Feed abonnieren für ';
$LNG->USER_RSS_BUTTON = 'RSS Feed';

/** PROFILE PAGE **/
$LNG->PROFILE_TITLE = 'Profil bearbeiten';
$LNG->PROFILE_CHANGE_PASSWORD_LINK = '(Passwort ändern)';
$LNG->PROFILE_INVALID_EMAIL_ERROR = "Bitte tragen Sie eine gültige Email-Adresse ein.";
$LNG->PROFILE_EMAIL_IN_USE_ERROR = "Diese Email-Adresse wird bereits verwendet, bitte benutzen Sie eine andere.";
$LNG->PROFILE_FULL_NAME_ERROR = "Bitte tragen Sie Ihren vollen Namen ein.";
$LNG->PROFILE_HOMEPAGE_URL_ERROR = "Bitte tragen Sie als Name Ihrer Homepage eine gültige URL ein (including 'http://').";
$LNG->PROFILE_SUCCESSFULLY_UPDATED_MESSAGE = 'Profil erfolgreich bearbeitet';
$LNG->PROFILE_UPDATE_BUTTON = 'Aktualisieren';
$LNG->PROFILE_DESC_LABEL = 'Beschreibung:';
$LNG->PROFILE_PHOTO_CURRENT_LABEL = 'Aktuelles Bild:';
$LNG->PROFILE_PHOTO_REPLACE_LABEL = 'Bild austauschen mit:';
$LNG->PROFILE_PHOTO_LABEL = 'Photo:';
$LNG->PROFILE_LOCATION = 'Ort: (Stadt)';
$LNG->PROFILE_COUNTRY = 'Land...';
$LNG->PROFILE_HOMEPAGE = 'Homepage:';
$LNG->PROFILE_EMAIL_VALIDATE_TEXT = 'Gültige Email-Adresse';
$LNG->PROFILE_EMAIL_VALIDATE_HINT = 'Ihre Email-Adresse wurde nicht bestätigt. Wenn Sie Social Login verwenden wollen, müssen Sie bestätigen, dass diese Email-Adresse zu Ihnen gehört.';
$LNG->PROFILE_EMAIL_VALIDATE_MESSAGE = 'Sie haben eine Email erhalten, um zu bestätigen, dass Ihre angegebene Email-Adresse korrekt ist.';
$LNG->PROFILE_EMAIL_VALIDATE_COMPLETE = 'Diese Email-Adresse wurde bestätigt.';
$LNG->PROFILE_EMAIL_CHANGE_CONFIRM = 'Sie haben Ihre Email-Adresse geändert.\nDiese neue Email-Adresse muss verifiziert werden.\n\nIhr Benutzer-Profil wird nun gesperrt, Sie werden ausgeloggt und erhalten eine neue Bestätigungs-Email.\nBitte klicken Sie darin auf den link, um die Änderung Ihrer Email-Adresse zu bestätigen.\n\nSind Sie sicher, dass Sie fortfahren möchten?';
$LNG->PROFILE_PRIVACY_MESSAGE = 'Standardmäßig meine Daten speichern:';
$LNG->PROFILE_PRIVACY_YES = '>Privat';
$LNG->PROFILE_PRIVACY_NO = '>Öffentlich';

/** ACTIVITY POPUP PAGES **/
$LNG->FORM_ACTIVITY_HEADING = 'Akutelle Aktivitäten';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DATE = 'Datum';
$LNG->FORM_ACTIVITY_TABLE_HEADING_TYPE = 'Typ';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DONEBY = 'Vollzogen von';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ACTION = 'Aktion';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ITEM = 'Artikel';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING = 'begann zu folgen';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING_ITEM = 'begann diesem Artikel zu folgen';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED = 'gefördert';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED = 'degradiert';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED_ITEM = 'diesen Artikel gefördert';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED_ITEM = 'diesen Artikel degradiert';
$LNG->FORM_ACTIVITY_ACTION_ADDED = 'hinzugefügt';
$LNG->FORM_ACTIVITY_ACTION_EDITED = 'bearbeitet';
$LNG->FORM_ACTIVITY_ACTION_ADDED_ITEM = 'diesen Artikel hinzugefügt';
$LNG->FORM_ACTIVITY_ACTION_EDITED_ITEM = 'diesen Artikel bearbeitet';
$LNG->FORM_ACTIVITY_ACTION_ASSOCIATED = 'assoziiert';
$LNG->FORM_ACTIVITY_ACTION_DESOCIATED = 'Verbindung gelöscht';
$LNG->FORM_ACTIVITY_ACTION_ADDED_RESOURCE = "fügte hinzu ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_PRO = "Pro-Argument hinzugefügt ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_CON = "Kontra-Argument hinzugefügt ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE = "verband dies mit ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ASSOCIATED_WITH = "verband dies mit jenem";
$LNG->FORM_ACTIVITY_ACTION_REMOVED = "entfernt";
$LNG->FORM_ACTIVITY_ACTION_REMOVED_RESOURCE = "enfernte ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_EVIDENCE = "entfernte dies ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_ASSOCIATION = "entfernte Verbindung mit";
$LNG->FORM_ACTIVITY_ACTION_INDICATED_THAT = 'zeigte, dass';
$LNG->FORM_ACTIVITY_ACTION_STRONG_SOLUTION = 'war ein starkes '.$LNG->SOLUTION_NAME_SHORT.' für';
$LNG->FORM_ACTIVITY_ACTION_CONVINCING_EVIDENCE = 'war unterstützend '.$LNG->ARGUMENT_NAME.' für';
$LNG->FORM_ACTIVITY_ACTION_SOUND_EVIDENCE = 'war solide '.$LNG->ARGUMENT_NAME.' für';
$LNG->FORM_ACTIVITY_ACTION_PROMOTED = 'sollte gefördert werden gegen';
$LNG->FORM_ACTIVITY_ACTION_WEAK_SOLUTION = 'war schwach '.$LNG->SOLUTION_NAME_SHORT.' für';
$LNG->FORM_ACTIVITY_ACTION_UNCONVINCING_EVIDENCE = 'war nicht überzeugend '.$LNG->ARGUMENT_NAME.' für';
$LNG->FORM_ACTIVITY_ACTION_UNSOUND_EVIDENCE = 'war unsolide '.$LNG->ARGUMENT_NAME.' für';
$LNG->FORM_ACTIVITY_ACTION_DEMOTED = 'sollte gegen degradiert werden';
$LNG->FORM_ACTIVITY_LABEL_WITH = 'mit';
$LNG->FORM_ACTIVITY_LABEL_FROM = 'von';
$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE = 'Die folgenden Probleme wurden beim Abrufen der Daten-Aktivitäten gefunden: ';
?>
