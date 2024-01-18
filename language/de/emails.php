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
 * emails.php
 *
 * See Also the mailtemplates subfolder for additional email texts to translate.
 *
 * Michelle Bachler (KMi)
 */

$LNG->WELCOME_REGISTER_OPEN_SUBJECT = "Willkommen zu ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_OPEN_BODY = 'Vielen Dank für Ihre Registrierung.<br><br>Weitere Informationen über LiteMap erhalten Sie über <a href="'.$CFG->homeAddress.'ui/pages/about.php">about page</a>.<br>Eine Einführung in die Benutzung des Hub erhalten Sie unter <a href="'.$CFG->homeAddress.'ui/pages/help.php">help page</a>.<br>Warum nicht heute mit Folgendem beginnen: <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a> .';

$LNG->VALIDATE_REGISTER_SUBJECT = "Schließen Sie Ihre Registrierung mit dem Klick auf folgenden link ab: ".$CFG->SITE_TITLE;

$LNG->WELCOME_REGISTER_REQUEST_SUBJECT = "Registrierungsanfrage für ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_REQUEST_BODY = 'Vielen Dank für Ihre Registrierungsanfrage <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a>.<br> So können wir erkennen, dass wir Ihre Anfrage erhalten haben.<br>Wir werden versuchen, Ihre Anfrage innerhalb von 24 Stunden zu bearbeiten, aber zu Stoßzeiten kann es etwas länger dauern.<br>Sie werden eine weitere E-Mail mit Ihren Anmeldedaten erhalten, sobald Ihre Anfrage bearbeitet.<br><br>Vielen Dank nochmals für Ihr Interesse.';
$LNG->WELCOME_REGISTER_REQUEST_BODY_ADMIN = "Ein neuer Benutzer hat ein Konto angefordert. Im Admin-Bereich können Sie den neuen Benutzer annehmen oder ablehnen.";

$LNG->WELCOME_REGISTER_CLOSED_SUBJECT = "Registrierung auf ".$CFG->SITE_TITLE;

$LNG->VALIDATE_GROUP_JOIN_SUBJECT = "Gruppe beitreten anfordern ".$CFG->SITE_TITLE;


/*** EMAIL DIGESTS ***/
$LNG->ADMIN_CRON_FOLLOW_USER_ACTIVITY_MESSAGE = 'Es gab eine Aktivität für';
$LNG->ADMIN_CRON_FOLLOW_SEE_ACTIVITY_LINK = 'Aktivität anschauen';
$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR = 'Aktivität für';
$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK = 'Anschauen';
$LNG->ADMIN_CRON_FOLLOW_ON_THE = 'darauf';
$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM = 'dieses Symbol';
$LNG->ADMIN_CRON_FOLLOW_STARTED = 'begann nach';
$LNG->ADMIN_CRON_FOLLOW_PROMOTED = 'höher bewertet';
$LNG->ADMIN_CRON_FOLLOW_DEMOTED = 'niedriger bewertet';
$LNG->ADMIN_CRON_FOLLOW_ADDED = 'hinzugefügt';
$LNG->ADMIN_CRON_FOLLOW_EDITED = 'editiert';
$LNG->ADMIN_CRON_FOLLOW_ADDED_RESOURCE = 'hinzugefügt '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_SUPPORTING_EVIDENCE = 'Unterstützung hinzugefügt '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_COUNTER_EVIDENCE = 'Zähler hinzugefügt '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_EVIDENCE = 'dieses mit jenem verbunden '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_WITH = 'dieses mit jenem verbunden';
$LNG->ADMIN_CRON_FOLLOW_REMOVED = 'entfernt';
$LNG->ADMIN_CRON_FOLLOW_REMOVED_RESOURCE = 'dies entfernt '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_EVIDENCE = 'dies entfernt '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_ASSOCIATION = 'Verbindung entfernt mit';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART1 = 'von';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART2 = 'nach';
$LNG->ADMIN_CRON_FOLLOW_HOURLY = 'Stündlich';
$LNG->ADMIN_CRON_FOLLOW_HOURLY_TITLE = 'Stündliche Digest für Activites auf '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_HOURLY_DIGEST_RUN = 'Stunden Digest für Activites auf '.$CFG->SITE_TITLE.' ausgeführt wurden';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY = 'Wöchentlich';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_TITLE = 'Wöchentlicher LiteMap Bericht';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_DIGEST_RUN = 'Wöchentlicher Bericht über Aktivitäten '.$CFG->SITE_TITLE.' Okay';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY = 'Monatlich';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_TITLE = 'Monatlicher LiteMap Bericht';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_DIGEST_RUN = 'Monatlicher Bericht über Aktivitäten '.$CFG->SITE_TITLE.' Okay';
$LNG->ADMIN_CRON_FOLLOW_DAILY = 'Täglich';
$LNG->ADMIN_CRON_FOLLOW_DAILY_TITLE = 'Täglicher LiteMap Bericht';
$LNG->ADMIN_CRON_FOLLOW_DAILY_DIGEST_RUN = 'Täglicher Bericht über Aktivitäten auf '.$CFG->SITE_TITLE.' Okay';
$LNG->ADMIN_CRON_FOLLOW_NO_DIGEST = 'Keine E-Mail-Benachrichtigungen über:';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART1 = 'So beenden Sie diese E-Mail zu verdauen bitte an den Hub anmelden und deaktivieren Sie \'E-Mail senden Benachrichtigungs der Neue Aktivitäten\' auf Ihrer';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART2 = $LNG->HEADER_MY_HUB_LINK.' Startseite';

$LNG->ADMIN_CRON_RECENT_ACTIVITY_DIGEST_RUN = 'Letzten Aktivitätsbericht anfordern '.$CFG->SITE_TITLE.' Okay';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_NO_DIGEST = 'Keinen Aktivitätsbericht für:';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_TITLE = 'Akueller LiteMap Aktivitäts-Bericht';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_MESSAGE = 'Hier finden Sie die Top 5 der meist genannten Begriffe, die in LiteMap Kategorien eingetragen wurde.';
?>
