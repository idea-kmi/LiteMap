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
 * core.php
 *
 * Michelle Bachler (KMi)
 * Translation: Thomas Ullmann (KMi)
 *
 */

$LNG->CORE_UNKNOWN_USER_ERROR = 'Nutzer nicht bekannt';
$LNG->CORE_NOT_IMAGE_ERROR = 'Sie k&ouml;nnen nur Bilder hochladen.';
$LNG->CORE_NOT_IMAGE_TOO_LARGE_ERROR = 'Das Bild ist zu gross';
$LNG->CORE_NOT_IMAGE_UPLOAD_ERROR = 'Es gab einen Fehler beim Hochladen des Bildes';
$LNG->CORE_NOT_IMAGE_RESIZE_ERROR = 'Es gab einen Fehler bei der Verkleinerung oder Vergr&ouml;sserung des Bildes';
$LNG->CORE_NOT_IMAGE_SCALE_ERROR = 'Es gab einen Fehler bei der Skalierung des Bildes.';

$LNG->CORE_SESSION_OK = 'OK';
$LNG->CORE_SESSION_INVALID = 'Die Session ist nicht g&uuml;ltig';

$LNG->CORE_AUDIT_NOT_XML_ERROR = 'Dies ist keine zul&auml;ssige XML';
$LNG->CORE_AUDIT_CONNECTION_NOT_FOUND_ERROR = 'Verbindung nicht gefunden';
$LNG->CORE_AUDIT_NODE_NOT_FOUND_ERROR = 'Knoten nicht gefunden';
$LNG->CORE_AUDIT_URL_NOT_FOUND_ERROR = 'URL nicht gefunden';
$LNG->CORE_AUDIT_CONNECTION_ID_MISSING_ERROR = 'Es fehlt die Verbindungs ID - die Daten konnten nicht geladen werden';
$LNG->CORE_AUDIT_CONNECTION_DATA_MISSING_ERROR = 'Die Verbindungsdaten fehlen';
$LNG->CORE_AUDIT_NODE_ID_MISSING_ERROR = 'Die Knoten ID fehlt - die Daten des Knotens konnte nicht geladen werden';
$LNG->CORE_AUDIT_NODE_DATA_MISSING_ERROR = 'Die Daten des Knoten fehlen';
$LNG->CORE_AUDIT_URL_ID_MISSING_ERROR = 'Die ID der URL fehlt - die Daten der URL konnte nicht geladen werden';
$LNG->CORE_AUDIT_URL_DATA_MISSING_ERROR = 'Die Daten der URL fehlen';
$LNG->CORE_AUDIT_TAG_ID_MISSING_ERROR = 'Die Daten der Tag ID fehlen - Die Daten des Tags konnten nicht geladen werden';
$LNG->CORE_AUDIT_TAG_DATA_MISSING_ERROR = 'Die Tag Daten fehlen';
$LNG->CORE_AUDIT_USER_ID_MISSING_ERROR = 'Die Daten der Nutzer ID fehlen - Der Nutzer konnte nicht geladen werden';
$LNG->CORE_AUDIT_USER_DATA_MISSING_ERROR = 'Die Daten des Nutzers fehlen';
$LNG->CORE_AUDIT_GROUP_ID_MISSING_ERROR = 'Die ID der Gruppen Daten fehlt - Die Gruppe konnte nicht geladen werden';
$LNG->CORE_AUDIT_GROUP_DATA_MISSING_ERROR = 'Die Gruppendaten fehlen';
$LNG->CORE_AUDIT_ROLE_ID_MISSING_ERROR = 'Die ID des Knotentyps fehlt - Der Knotentyp konnte nicht geladen werden';
$LNG->CORE_AUDIT_ROLE_DATA_MISSING_ERROR = 'Der Type des Knoten fehlt';
$LNG->CORE_AUDIT_LINK_ID_MISSING_ERROR = 'Die Daten des Verbindungstype fehlen - Die Verbindung konnte nicht geladen werden';
$LNG->CORE_AUDIT_LINK_DATA_MISSING_ERROR = 'Die Daten des Verbindungstyp fehlen';

$LNG->CORE_FORMAT_NOT_IMPLEMENTED_MESSAGE = 'Leider noch nicht implementiert';
$LNG->CORE_FORMAT_INVALID_SELECTION_ERROR = 'Ein ung&uuml;ltiges Format wurde ausgew&auml;hlt';

$LNG->CORE_HELP_ERRORCODES_TITLE = 'Hilfe - Fehlercodes der API';
$LNG->CORE_HELP_ERRORCODES_CODE_HEADING = 'Code';
$LNG->CORE_HELP_ERRORCODES_MEANING_HEADING = 'Bedeutung';

$LNG->CORE_DATAMODEL_GROUP_CANNOT_REMOVE_MEMBER = 'Kann Benutzer nicht entfernen, da admin als Gruppe keine Admins haben';

/**
 * THESE ARE ERROR MESSAGE SENT FROM THE API CORE CODE
 * YOU MAY CHOOSE NOT TO TRANSLATE THESE
 */
$LNG->ERROR_REQUIRED_PARAMETER_MISSING_MESSAGE = "Die ben&ouml;tigten Parameter fehlen";
$LNG->ERROR_INVALID_METHOD_SPECIFIED_MESSAGE = "Eine ung&uuml;tige oder keine Methode ist spezifiziert";
$LNG->ERROR_INVALID_ORDERBY_MESSAGE = "Ung&uuml;ltige Auswahl von order by";
$LNG->ERROR_INVALID_SORT_MESSAGE = "Ung&uuml;ltige Auswahl von sort";
$LNG->ERROR_BLANK_NODEID_MESSAGE = "Die Element ID kann nicht leer sein.";
$LNG->ERROR_ACCESS_DENIED_MESSAGE = "Zugriff verboten";
$LNG->ERROR_LOGIN_FAILED_MESSAGE = "Der Login ist fehlgeschlagen: Entweder Ihre E-Mail oder Passwort stimmen nicht. Bitte probieren Sie es erneut.";
$LNG->ERROR_LOGIN_FAILED_UNAUTHORIZED_MESSAGE = "Der Login ist fehlgeschlagen: Ihr Account wurde noch nicht freigeschalten";
$LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE = "Der Login ist fehlgeschlagen: Der Account wurde suspendiert";
$LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE = "Der Login ist fehlgeschlagen: Dieser Account hat noch nicht den Registrierungsprozess abgeschlossen. Die E-Mail Adresse wurde noch nicht validiert.";
$LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE = "Der Account mit dieser E-Mail Adresse wurde mit einem externen Service erstellt und hat noch nicht ein lokales Passwort.<br>Sie m&uuml;ssen sich mit dem Folgenden anmelden:";

$LNG->ERROR_INVALID_JSON_ERROR_NONE = "Kein Fehler mit JSON";
$LNG->ERROR_INVALID_JSON_ERROR_DEPTH = "Die maximale H&ouml;he des JSON Stack wurde &uuml;berschritten";
$LNG->ERROR_INVALID_JSON_ERROR_STATE_MISMATCH = "Underflow oder modes Diskrepanz";
$LNG->ERROR_INVALID_JSON_ERROR_CTRL_CHAR = "Ein unerwartetes Steuerzeichen wurde im JSON gefunden";
$LNG->ERROR_INVALID_JSON_ERROR_SYNTAX = "Syntax Fehler, missgebildetes JSON";
$LNG->ERROR_INVALID_JSON_ERROR_UTF8 = "Missgebildetes UTF-8 Zeichen, m&ouml;glicherweise ung&uuml;ltig kodiert";
$LNG->ERROR_INVALID_JSON_ERROR_DEFAULT = "Es gab einen Fehler beim Dekodieren von JSON";

$LNG->ERROR_INVALID_METHOD_FOR_TYPE_MESSAGE = "Dies Methoded ist nicht f&uuml;r dieses Format erlaubt";
$LNG->ERROR_DUPLICATION_MESSAGE = "Duplizierungsfehler";
$LNG->ERROR_INVALID_EMAIL_FORMAT_MESSAGE = "Ung&uuml;ltiges E-Mail Format";
$LNG->ERROR_DATABASE_MESSAGE = "Fehler der Datenbank";
$LNG->ERROR_USER_NOT_FOUND_MESSAGE = 'Nutzer nicht in der Datenbank gefunden';
$LNG->ERROR_URL_NOT_FOUND_MESSAGE = 'Url nicht in der Datenbank gefunden';
$LNG->ERROR_TAG_NOT_FOUND_MESSAGE = 'Tag nicht in der Datenbank gefunden';
$LNG->ERROR_ROLE_NOT_FOUND_MESSAGE = 'Knotentyp (Rolle) nicht in der Datenbank gefunden';
$LNG->ERROR_LINKTYPE_NOT_FOUND_MESSAGE = 'Verbindungstyp nicht in der Datenbank gefunden';
$LNG->ERROR_NODE_NOT_FOUND_MESSAGE = 'Knoten nicht in der Datenbank gefunden';
$LNG->ERROR_CONNECTION_NOT_FOUND_MESSAGE = 'Verbindung nicht in der Datenbank gefunden';
$LNG->ERROR_INVALID_CONNECTION_MESSAGE = "Ung&uuml;ltige Kombination der Verbindung. Passt nicht zum Datenmodell.";
$LNG->ERROR_INVALID_PARAMETER_TYPE_MESSAGE = "Ung&uuml;ltiger Parametertyp";
?>
