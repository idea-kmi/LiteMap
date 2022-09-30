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
 * languageui.php
 *
 * Michelle Bachler (KMi)
 *
 */

/** HOMEPAGE **/
$LNG->HOMEPAGE_TITLE = 'Willkommen zur Übersichtskarte';

$LNG->HOMEPAGE_FIRST_PARA = '<b>'.$CFG->SITE_TITLE.'</b> ist ein kollaboratives Online-Tool, das hilft komplexe Probleme visuell zu strukturieren und zu verstehen. Mit '.$CFG->SITE_TITLE.' können Face-to-Face- und Online-Diskussionen mit Wissenskarten visuell abgebildet werden, wie zum Beispiel Konzeptkarten, Argumentationskarten, oder auch Problemkarten. Dies sind Netzwerkkarten mit unterschiedlichen semantische Datenmodellen. Diese können für unterschiedliche Bedürfnisse der kollektiven Wissenskonstruktion benutzt werden (wie z.B. Brainstorming, kollaborative Diskussion und Aufbau von gegenseitigem Verständnis).';
$LNG->HOMEPAGE_SECOND_PARA_PART2 = '<p>Die Verwendung von '.$CFG->SITE_TITLE.' kann face-to-face Konversationen mit Dialogabbildungsfunktionen erleichtern und macht die Vermischung der online und offline Teilnahme an kollektiven Denkprozessen möglich.</p>';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<p>'.$CFG->SITE_TITLE.' wurde im Rahmen eines kürzlich durchgeführten FP7-Projekts CATALYST (<a href="http://catalyst-fp7.eu/">http://catalyst-fp7.eu/</a>) - Collective Applied Intelligence and Analytics for Social Innovation - entwickelt. Seit der ersten Veröffentlichung in 2015 wurde '.$CFG->SITE_TITLE.' von mehr als 1300 Nutzern in 10 verschiedenen Ländern von 100 verschiedenen Gruppen genutzt. Diese erstellten mehr als 500 Wissenskarten. Dies zeigt den Einfluss von '.$CFG->SITE_TITLE.' auf Öffentlichkeit und Bildung.</p>';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<p>'.$CFG->SITE_TITLE.' wurde in verschiedenen Bereichen eingesetzt: soziale Innovation, soziales Unternehmertum, europäische Forschung, naturwissenschaftlicher Unterricht und Sekundarschulbildung. '.$CFG->SITE_TITLE.' war auch Gegenstand eines von der Europäischen Kommission veröffentlichten Politikberichts über verantwortungsvolle Forschung und Innovation.</p>';

$LNG->HOMEPAGE_KEEP_READING = 'Weiterlesen';
$LNG->HOMEPAGE_READ_LESS = 'Weniger lesen';
$LNG->HOMEPAGE_TOOLS_TITLE = 'Tools:';
$LNG->HOMEPAGE_TOOLS_LINK = 'Die LiteMap Toolbar herunterladen';
$LNG->HOMEPAGE_VIEW_ALL = 'Alles anzeigen ';
$LNG->HOMEPAGE_NEWS_TITLE = 'Die neuesten Nachrichten';

$LNG->HOMEPAGE_MOST_POPULAR_GROUPS_TITLE = 'Beliebteste '.$LNG->GROUPS_NAME;
$LNG->HOMEPAGE_MOST_RECENT_GROUPS_TITLE = 'Die neuesten '.$LNG->GROUPS_NAME;
$LNG->HOMEPAGE_MOST_RECENT_MAPS_TITLE = 'Die neuesten '.$LNG->MAPS_NAME;

$LNG->HOME_MY_GROUPS_TITLE = 'Meine '.$LNG->GROUPS_NAME;
$LNG->HOME_MY_GROUPS_AREA_LINK = 'Sehen Sie meine '.$LNG->GROUPS_NAME.' Bereich';
$LNG->HOME_MY_MAPS_TITLE = 'Meine '.$LNG->MAPS_NAME;
$LNG->HOME_MY_MAPS_AREA_LINK = 'Sehen Sie meine '.$LNG->MAPS_NAME.' Bereich';

/** HELP PAGES **/
$LNG->HELP_NETWORKMAP_TITLE = 'Hilfe mit der Karte';
$LNG->HELP_NETWORKMAP_BODY = '<b>Die Hintergrundfl&auml;che der Karte:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-top:0px;margin-bottom:0px;padding-bottom:0px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Linksklick und ziehen Leinwand zu schwenken.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Rechtsklicken Sie , um ein Menü zu erhalten, um frei schwebende Knoten zu einer Karte hinzufügen. Nur verfügbar, wenn Sie eingeloggt und Berechtigungen, um die Karte zu bearbeiten.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';

$LNG->HELP_NETWORKMAP_BODY .= '<br><b>Links:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<span style="padding-left:10px;">Klicken Sie mit der linken Maustaste, um das Link Men&uuml; zu sehen. Dort k&ouml;nnen Sie ausw&auml;hlen ob Sie die Seite des Autoren besuchen m&ouml;chten oder, falls Sie eingloggt sind, k&ouml;nnen Sie auch den Link von der Karte l&ouml;schen. </span><br><br>';

$LNG->HELP_NETWORKMAP_BODY .= '<b>Elemente:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-top:0px;margin-bottom:0px;padding-bottom:0px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">ctrl+einfacher oder mehrfacher Linksklick auf Elemente, um sie auszuw&auml;len. Knoten auf Nur-Lese- Karten zur Verfügung.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">alt+Linksklick auf ein Element, um einen Baum von Knoten auszuwählen. Knoten auf Nur-Lese- Karten zur Verfügung.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Linksklick</b> mit gehaltener Maustaste um das Element zu verschieben oder zu auszuw&auml;hlen</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Rechte Maustaste und ziehen Sie von einem Knoten -and-Drop auf einen anderen Knoten, um sie zu verbinden (vorausgesetzt, sie nicht bereits verbunden sind und Verknüpfungsregeln erlauben ). Nur verfügbar, wenn Sie eingeloggt und Berechtigungen, um die Karte zu bearbeiten.<br><b>Für Opera nur</ b> ist es Strg + rechte Maustaste per Drag & Drop, um Link -Knoten.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Rechtsklicken Sie auf einen Kommentar Knoten mit einem Bild , um eine Vergrößerung Version des Bildes zu sehen.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li>Rollover &uuml;ber das Typ Icon, um den Namen des Typs zu sehen</li></ul>';

$LNG->HELP_NETWORKMAP_BODY .= '<br><h2>Karten-Symbolleiste</h2><img style="width:640px;border-bottom:1px solid gray" src="'.$HUB_FLM->getImagePath('help/maptoolbar.png').'" />';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-bottom:0px;padding-bottom:0px;margin-top:5px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('enlarge2.gif').'">Klicken Sie zum Vergrößern auf die Abbildung Bereich . Dies entfernt Kopf- und Fußbereich und Kartentitel Box und vergrößert den Mapping-Bereich , um thier Raum zu füllen. <img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('reduce.gif').'">Klicken Sie erneut , um die Karte wieder nach unten senken.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;">Bearbeiten Bar: Sie sehen nur diese Option Sie Berechtigungen haben , um die Karte zu bearbeiten und sind in einem editierbaren Ansicht. Klicken Sie tp Öffnen und Schließen der linken Seite Bearbeitungsleiste. Hier finden Sie eine Liste der von Ihnen erstellten Einträge zu finden. Ein Ort, um zu suchen Alle Einträge und Schaltflächen, um neue Einträge zu erstellen. Sie ziehen Sie einfach Einträge auf der Karte. Um einen neuen Eintrag zu erstellen entweder per Drag & Drop auf die Symbole auf der Karte, die Sie gerade für den Titel fragen wird, oder klicken Sie auf die Symbole, um die volle \'Add New\' bildet.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;">Benachrichtigungs Bar: Wenn Warnungen wurden zu aktivieren auf Ihrer Website diese Schaltfläche Öffnen und Schließen der rechten Seite Benachrichtigungsbarbereich . Hier Warnungen mit Empfehlungen auf der Grundlage des aktuellen Status der Karte angezeigt.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-minus.png').'">Klicken Sie hier um die Karte zu vergrößern out . Sie können auch das Mausrad nach hinten.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-plus.png').'">Klicken Sie auf die Karte zoomen. Sie können auch das Mausrad nach vorne zu blättern.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-ratio1-1.png').'">Vergrößern Sie die Karte zu 100% Sizing.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-fit.png').'">Zoom in der Karte , so dass alle Einzelteile passen in den sichtbaren Bereich.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('printer.png').'">Drucken Sie die Karte.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('info.png').'">Öffnen Sie diese Hilfe-Fenster.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('selectall2.png').'" width="18" height="18">Click to select/deselect all items in the map. Not seen on read-only embeddable maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('search.png').'">Enter text to search on the search box and then press enter or click this icon to search. Any matches will be highlighted in the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('search-clear.png').'">This clears any search text in the search field and clears and item selections in the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('knowledge-tree.png').'">This button allows you to view a readonly linear represenation of the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:21px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('embed.png').'">This opens a text box from which you can copy the iframe code to embed the current map as an read-only map in another site. Not seen on embeddable maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:32px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('embededit.png').'">This opens a text box from which you can copy the iframe code to embed the current map as an editable map in another site. Not seen on embeddable maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:24px;height:18px;" border="0" src="'.$HUB_FLM->getImagePath('json-ld-data-24.png').'">This opens a text box from which you can copy the url to get the jsonld data for this map. Not seen on embeddable maps.</li>';
//$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><b>Connections:</b> At the end of the first row you will see a count of how many connections are in the current map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';

$LNG->HELP_NETWORKMAP_BODY .= '<h2>Werkzeugleiste</h2><img src="'.$HUB_FLM->getImagePath('help/nodetoolbar.png').'" border="0" />';
$LNG->HELP_NETWORKMAP_BODY .= '<ul><li style="margin-bottom:5px;"><b>2:</b> Falls ein Element mehrmals in einer Karte auftaucht, dann wird die H&auml;ufigkeit des Auftretens in anderen Karten mit einer Nummer in der Werkzeugleiste angezeigt. In diesem Beispiel ist die H&auml;figkeit 2, aber es kann auch mehr sein. Rollover &uuml;ber die Nummer, um eine Liste aller Karten zu bekommen, die das Element enthalten. Klicke auf den Namen der Karte, um die Karte zu sehen.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('desc-gray.png').'" width="16" height="16">Rollover das wei&szlig;e Rechteck, um weiteren Titeltext oder beschreibenden Text zu erhalten. Ein Klick &ouml;ffnet ein Fenster mit allen Einzelheiten. </li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('thumb-up-empty.png').'" width="16" height="16">Wenn Sie eingeloggt sind, dann k&auml;nnen Sie f&uuml;r ein Element abstimmen indem Sie auf das Symbol mit dem Daumen der nach oben zeigt dr&uuml;cken. Die Nummer auf der rechten Seite zeigt wie h&auml;fig f&uuml;r diese Element abgestimmt wurde.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('thumb-down-empty.png').'" width="16" height="16">Wenn Sie eingeloggt sind, dann k&ouml;nnen Sie gegen ein Element abstimmen, indem Sie auf den Daumen der nach unten zeigt klicken. Die Nummer auf der rechten Seite neben dem Daumen zeigt wie h&auml;fig gegen das Element abgestimmt wurde.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('edit.png').'" width="16" height="16">Wenn Sie eingeloggt sind und Sie sind der Eigent&uuml;mer des Elements, dann werden Sie ein Bearbeitungssymbol sehen. Klicken Sie auf dieses, um das Bearbeitungsformular zu &ouml;ffnen und um &Auml;nderungen durchzuf&uuml;hren. Falls dieses Element in mehreren Karten verwendet wurde, dann beachten Sie bitte, dass eine &Auml;nderung hier sich durch alle Karten in dem das Element auswirken wird und daher die Logik in anderen Karten &auml;nnen k&ouml;nnte.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('delete.png').'" width="16" height="16">Wenn Sie eingeloggt sind dann werden Sie ein x Symbol im Men&uuml; sehen. Klicken Sie darauf, um das Element aus der Karte zu l&ouml;schen. Sie werden dann gefragt, ob Sie das Element wirklich l&ouml;schen m&ouml;chten. Wenn Sie das Element hier l&ouml;schen, dann wird das Element nicht von den anderen Karten gel&ouml;scht. </li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('link.png').'" width="16" height="16">Rollover dieses Symbol, um die assoziierten Webseiten aufzurufen. Ein kleines Popup erscheint, dass all URLs auflistet, die zu diesem Element hinzugef&uuml;gt wurden. Klicken Sie auf einen solchen Link um die Webseite zu besuchen.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('lock-32.png').'" width="18" height="18">Wenn Sie ein Schloss in der Werkzeugleiste sehen, dann bedeutet dies, dass das Element privat ist. Sie werden es daher nur unter Ihren eigenen privaten Elementen sehen oder auf privaten Elementen in Gruppen den Sie angeh&ouml;ren.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li><img style="vertical-align:middle;padding-right:5px;" border="0" src="'.$HUB_FLM->getImagePath('rightarrowlarge.gif').'" width="16" height="16">Wenn Sie eingeloggt sind dann werden Sie einen Pfeil am Ende der Werkzeugleiste sehen. Dies &Ouml;fnet den Men&uuml des Editors. Rollover diesen Pfeil, um das Men&ouml; zu sehen. Dort finden Sie Optionen um Elemente zur Karte zu erstellen/hinzuf&oumlgen arrow und zu verbinden.</li></ul>';

/** IMPORT CIF **/
$LNG->IMPORT_CIF_TITLE = 'Import CIF';
$LNG->IMPORT_CIF_DATA_URL = 'CIF Daten url:';
$LNG->IMPORT_CIF_DATA_URL_PLACEHOLDER = 'http:// <URL zu Ihrem CIF formatierte Daten>';
$LNG->IMPORT_CIF_DATA_URL_ERROR = 'Bitte fügen Sie Ihre CIF-Daten url';
$LNG->IMPORT_CIF_DATA_URL_INVALID = 'Sie haben keine gültigen Daten url eingetragen. Bitte versuchen Sie es erneut';
$LNG->IMPORT_CIF_LOAD = 'Last und Vorschau';
$LNG->IMPORT_CIF_CLEAR_LOAD = 'Klar Letzte Last';
$LNG->IMPORT_CIF_NODES_ONLY = 'Import Nodes Nur';
$LNG->IMPORT_CIF_IMPORT_MESSAGE = '<b>'.$LNG->IMPORT_CIF_NODES_ONLY.':</b> Hier können Sie die Knoten auswählen , die Sie importieren können Sie über die Kontrollkästchen in der Knoten Wunschliste . Alle Knoten sind standardmäßig ausgewählt. Die Knoten werden Ihrem \'Meine LiteMap\' Datenbereich hinzugefügt werden und erscheinen in Ihrem \'Inbox\' auf der Map -Editor bar bei der Bearbeitung von Karten.';
$LNG->IMPORT_CIF_IMPORT_MESSAGE2 = '<b>Import Knoten und Verbindungen:</b> Beim Importieren von Knoten und Verbindungen, (\''.$LNG->IMPORT_CIF_NODES_ONLY.'\' Nicht ausgewählt ist) können Sie die Knoten, wählen Sie für den Import auf dem Knoten -Liste oder der Linearansicht (erste Schaltfläche auf der Karte -Symbolleiste). Alle Verbindungen zwischen ausgewählten Knoten werden importiert. Sie werden aufgefordert, eine neue Karte, um sie zu importieren, zu schaffen. Sie können neu ordnen die Karte Layout vor dem Import in der Vorschau Karte.';
$LNG->IMPORT_CIF_NODE_COUNT = 'Knoten Graf:';
$LNG->IMPORT_CIF_CONNECTION_COUNT = 'Verbindungsanzahl:';
$LNG->IMPORT_CIF_IMPORT = 'Import';
$LNG->IMPORT_CIF_IMPORT_INTO = 'Import in:';
$LNG->IMPORT_CIF_IMPORT_INTO_HELP = 'Bitte craete eine '.$LNG->MAP_NAME.', um die Knoten und Verbindungen importieren.';
$LNG->IMPORT_CIF_FORMAT_LINK = 'Catalyt interchange Format';
$LNG->IMPORT_CIF_SELECT_ALL = 'Alle auswählen';
$LNG->IMPORT_CIF_DESELECT_ALL = 'Alle Abwählen';
$LNG->IMPORT_CIF_PRIVACY_HINT = "Wenn dies für die öffentliche alle importierten Knoten gesetzt werden von niemandem gesehen werden. Wenn es um Privat nur dem Besitzer festgelegt ist / Importeur kann sie sehen, oder ob sie in einer ".$LNG->MAP_NAME.", die in einer ".$LNG->GROUP_NAME." importiert werden, können andere Mitglieder der ".$LNG->GROUP_NAME." zu sehen.";
$LNG->IMPORT_CIF_LOADING = 'Importieren von Daten';
$LNG->IMPORT_CIF_LIMIT_MESSAGE = 'Wir haben derzeit ein '.$CFG->ImportLimit.' Knoten Importgrenze. Sie müssen einige Ihrer Knoten vor dem Importieren deaktivieren.';
$LNG->IMPORT_CIF_LIMIT_MESSAGE_REACHED = 'Sie haben mehr als '.$CFG->ImportLimit.' Knoten ausgewählt. Bitte deaktivieren Sie einige Knoten vor dem Import.';
$LNG->IMPORT_CIF_CONDITIONS_MESSAGE = 'Wir möchten Sie daran erinnern, dass ein Mitglied dieser Hub Sie unsere <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Nutzungs Benutzer</a> zugestimmt haben.<br>Bevor Sie diese Daten importieren möchten wir Ihre Aufmerksamkeit insbesondere auf <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php#section2">Abschnitt 2</a> zu ziehen.';

$LNG->USER_HOME_IMPORT_CIF_LINK = 'Import CIF';

/** MAPS **/
$LNG->MAP_EDITOR_INBOX = 'Inbox';
$LNG->MAP_EDITOR_LINK = 'Bearbeiten Bar';
$LNG->MAP_EDITOR_LINK_HINT = 'Klicken Sie zum Umschalten '.$LNG->MAP_EDITOR_LINK.' offen und geschlossen';
$LNG->MAP_EDITOR_SEARCH_NO_RESULTS = 'Keine passenden Ergebnisse gefunden';
$LNG->MAP_EDITOR_IN_MAP_HINT = 'Bereits in Map';
$LNG->MAP_EDITOR_DND_HINT = 'Drag and drop auf Leinwand Karte';
$LNG->MAP_EDITOR_NEW_NODE_HINT = 'Zum Vergrößern Add Form , per Drag & Drop die schnelle Erstellung mit nur Titel.';

$LNG->MAP_ALERT_LINK = 'Benachrichtigungs Bar';
$LNG->MAP_ALERT_LINK_HINT = 'Klicken Sie zum Umschalten '.$LNG->MAP_ALERT_LINK.' offen und geschlossen';
$LNG->MAP_ALERT_NO_RESULTS = 'Es sind keine Benachrichtigungen vor';
$LNG->MAP_ALERT_CLICK_HIGHLIGHT = 'Klicken Sie in der Karte markieren';
$LNG->MAP_ALERT_SHOW_ALL = 'zeige alles...';
$LNG->MAP_ALERT_SHOW_LESS = 'zeigen weniger...';

/** TESTING - EMBEDDED MAP SURVEY **/
$LNG->MAP_SURVEY_MESSAGE = 'Wie sinnvoll halten Sie diese Karte in diesem Stadium zu finden?';
$LNG->MAP_SURVEY_LINK = 'Ihr Feedback';
$LNG->MAP_SURVEY_FORM_USFULNESS = 'Nützlichkeit?';
$LNG->MAP_SURVEY_FORM_COMMENT = 'Kommentar:';
$LNG->MAP_SURVEY_FORM_SELECT = 'Wählen';
$LNG->MAP_SURVEY_FORM_SELECT_MESSAGE = '(1 = nicht sehr nützlich, 5 = sehr nützlich)';
$LNG->MAP_SURVEY_FORM_SELECT_ERROR = 'Bitte wählen Sie eine Bewertung Nützlichkeit.';
$LNG->MAP_SURVEY_FORM_SUBMIT = 'Einreichen';
$LNG->MAP_SURVEY_FORM_CANCEL = 'Stornieren';
$LNG->MAP_SURVEY_THANKS = 'Vielen Dank für dein Feedback';
$LNG->MAP_ALERT_SURVEY_QUESTION = 'Klicken Sie auf , wenn Sie die Alarmfunktion nützlich.';

$LNG->MAP_SELECT_ALL_LABEL = 'Alles auswählen';
$LNG->MAP_SELECT_ALL_HINT = 'Hier alle Objekte auswählen';
$LNG->MAP_DESELECT_ALL_HINT = 'Hier alle Objekte abwählen';
$LNG->MAP_CONNECT_TO_SELECTED_LABEL = 'Verbinde mit dem ausgewählten Punkt/den ausgewählten Punkten';
$LNG->MAP_CONNECT_TO_SELECTED_HINT = 'Verbinde diesen Punkt mit allen momentan ausgewählten Punkten, wenn die Beziehung erlaubt ist.';
$LNG->MAP_CONNECTION_ERROR = 'Eine oder mehrere Verbindungen konnten nicht hergestellt werden, da sie nicht erlaubt wurden.';
$LNG->MAP_CONNECTION_ERROR_SINGLE = 'Diese Verbindung ist nicht zulässig. Die Richtung Vielleicht umzukehren?';
$LNG->MAP_CONNECTION_TEST_ERROR = 'NICHT ERLAUBT';
$LNG->MAP_CHANGE_NODETYPE = 'wechseln';
$LNG->MAP_TITLE_ROLLOVER_CHOICE = 'Rollover -Titel';
$LNG->MAP_TITLE_ROLLOVER_CHOICE_HINT = 'Ein- und ausschalten , die die Post-Titel als Rollover- Hinweis angezeigt. Das ist gut für die Erkundung der Karte beim Verkleinern , aber vielleicht ärgerlich , wenn Sie eine '.$LNG->MAP_NAME.'.';
$LNG->MAP_LINK_TEXT_CHOICE_HINT = 'Ein- und Ausschalten mit den Link-Etiketten in dieser Karte';
$LNG->MAP_LINK_CURVE_CHOICE_HINT = 'Ein- und Ausschalten mit gebogenen Links in dieser Karte';

$LNG->FORM_MAP_ENTER_SUMMARY_ERROR = 'Bitte geben Sie einen '.$LNG->MAP_NAME.' titel ein, bevor Sie speichern anklicken';
$LNG->LOADING_MAPS = '(Wird geladen'.$LNG->MAPS_NAME.'...)';
$LNG->FORM_MAP_LABEL_SUMMARY = $LNG->MAP_NAME." Titel:";
$LNG->MAP_SUMMARY_FORM_HINT = "(Pflicht) Bitte wählen Sie hierfür einen Titel aus ".$LNG->MAP_NAME;
$LNG->MAP_DESC_FORM_HINT = "(Optional) Bitte fügen Sie eine kurze Beschreibung hierfür hinzu ".$LNG->MAP_NAME;
$LNG->MAP_PRIVATE_FORM_HINT = "Wenn die Karte öffentlich ist, kann sie von allen gesehen und bearbeitet werden. Wenn sie ausschließlich privat ist, kann sie nur der Besitzer sehen und verändern.";
$LNG->MAP_PRIVATE_FORM_HINT_GROUP = "Wenn die Karte öffentlich ist, kann sie von allen in der Gruppe gesehen und vervollständigt werden. Wenn sie privat ist, kann sie nur der Besitzer sehen und verändern.";
$LNG->FORM_MAP_TITLE_ADD = 'Füge eine neue '.$LNG->MAP_NAME.' hinzu';
$LNG->FORM_MAP_TITLE_EDIT = 'Verändere die '.$LNG->MAP_NAME;
$LNG->FORM_MAP_CREATE_ERROR_MESSAGE = 'Es gab ein Problem bei der Erstellung der '.$LNG->MAP_NAME.':';
$LNG->FORM_MAP_NOT_FOUND = 'Die benötigte '.$LNG->MAP_NAME.' konnte nicht gefunden werden';
$LNG->FORM_MAP_PRIVACY = 'Öffentlich:';
$LNG->MAP_REMOVE_NODE = 'Von '.$LNG->MAP_NAME.' entfernen';
$LNG->MAP_REMOVE_NODE_HINT = 'Lösche den Punkt von der '.$LNG->MAP_NAME;
$LNG->MAP_REMOVE_NODE_CHECK_PART1 = "Sind Sie sicher, dass Sie dies löschen möchten?:";
$LNG->MAP_REMOVE_NODE_CHECK_PART2 = "von der Karte?";
$LNG->MAP_BLOCK_STATS_LINK_HINT = "Klicken Sie hier um zum Dashboard zu gelangen".$LNG->MAP_NAME;
$LNG->MAP_LINKS_TITLE = 'URLs';
$LNG->MAP_VIEW = $LNG->MAP_NAME.' öffnen';
$LNG->MAP_LINK_DELETE = 'Link löschen';

$LNG->MAP_FORM_ADD_TO_GROUP = 'Zur '.$LNG->GROUP_NAME.' hinzufügen:';
$LNG->MAP_FORM_ADD_TO_GROUP_HINT = '(optional) - Fügen Sie diese '.$LNG->MAP_NAME.' um die ausgewählte '.$LNG->GROUP_NAME;

$LNG->FORM_MAP_TITLE_EDIT = 'Bearbeiten Sie die  '.$LNG->MAP_NAME.' weiter';
$LNG->FORM_MAP_TITLE_ADD = 'Fügen Sie eine Karte hinzu ';
$LNG->FORM_MAP_TITLE_ADD_HINT = 'Wählen Sie eine existierende Karte mit Verbindung zu diesem Schnittpunkt aus ';

$LNG->BLOCK_STATS_PEOPLE = 'Teilnehmer:';
$LNG->BLOCK_STATS_ISSUES = $LNG->SOLUTIONS_NAME.':';
$LNG->BLOCK_STATS_VOTES = $LNG->VOTES_NAME.':';
$LNG->BLOCK_STATS_LINK_HINT = "Klicken Sie hier, um zum Dashboard zu gehen ".$LNG->MAP_NAME.".";

$LNG->MAP_CREATE_LOGGED_OUT_OPEN = "um eine neue Karte zu erstellen ";
$LNG->MAP_CREATE_LOGGED_OUT_REQUEST = "um eine neue Karte zu erstellen ";
$LNG->MAP_CREATE_LOGGED_OUT_CLOSED = "um eine neue Karte zu erstellen ";

$LNG->MAP_CREATE_LOGGED_OUT_OPEN = "um eine neue Karte zu erstellen ";
$LNG->MAP_CREATE_LOGGED_OUT_REQUEST = "um eine neue Karte zu erstellen ";
$LNG->MAP_CREATE_LOGGED_OUT_CLOSED = "um eine neue Karte zu erstellen ";

$LNG->MAP_ADD_EXISTING_BUTTON = 'In den bestehenden '.$LNG->MAP_NAME;

/** GROUPS **/
$LNG->FORM_BUTTON_DELETE_GROUP = 'Löschen '.$LNG->GROUP_NAME;
$LNG->FORM_BUTTON_JOIN_GROUP = 'Mitmachen '.$LNG->GROUP_NAME;
$LNG->FORM_BUTTON_JOIN_GROUP_CLOSED = 'Anfrage an '.$LNG->GROUP_NAME.' beitreten';

$LNG->ERROR_GROUP_NOT_FOUND_MESSAGE = "Die Gruppe konnte nicht gefunden werden";
$LNG->ERROR_GROUP_USER_LAST_ADMIN = "Sie können diesen Benutzer nicht als Administrator löschen, da die Gruppe dann keine Administratoren mehr hat";
$LNG->ERROR_GROUP_EXISTS_MESSAGE = "Eine Gruppe mit diesem Namen existiert bereits";
$LNG->ERROR_GROUP_USER_NOT_MEMBER = "Der aktuelle Benutzer ist kein Mitglied der ".$LNG->GROUP_NAME;

$LNG->GROUP_CREATE_TITLE = 'Erstellen Sie eine neue '.$LNG->GROUP_NAME;
$LNG->GROUP_MANAGE_TITLE = 'Verwalten Sie die '.$LNG->GROUPS_NAME;
$LNG->GROUP_MANAGE_SINGLE_TITLE = 'Verwalten Sie die '.$LNG->GROUP_NAME;

$LNG->GROUP_CREATE_LOGGED_OUT_OPEN = "um eine neue Gruppe zu erstellen ";
$LNG->GROUP_CREATE_LOGGED_OUT_REQUEST = "um eine neue Gruppe zu erstellen ";
$LNG->GROUP_CREATE_LOGGED_OUT_CLOSED = "um eine neue Gruppe zu erstellen ";

$LNG->GROUP_MAP_CREATE_BUTTON = 'Erstelle eine neue '.$LNG->MAP_NAME;
$LNG->MAP_GROUP_JOIN_GROUP = "um zu der Karte beizutragen ";
$LNG->GROUP_JOIN_GROUP = " um eine neue Karte zu erstellen ";

$LNG->GROUP_PHOTO_FORM_HINT = "(optional) - Please add an image to represent this ".$LNG->GROUP_NAME;
$LNG->GROUP_NAME_FORM_HINT = "(compulsory) - The Name of this ".$LNG->GROUP_NAME;
$LNG->GROUP_DESC_FORM_HINT = "(optional) - A description of the purpose of this ".$LNG->GROUP_NAME;
$LNG->GROUP_WEBSITE_FORM_HINT = "(optional) - Add an associated website for this ".$LNG->GROUP_NAME;

$LNG->GROUP_FORM_NAME = "Name:";
$LNG->GROUP_FORM_DESC = "Beschreibung:";
$LNG->GROUP_FORM_WEBSITE = "Website:";
$LNG->GROUP_FORM_MEMBERS_CURRENT = "Aktuelle Mitglieder:";

$LNG->GROUP_FORM_SELECT = "Wählen Sie eine ".$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NO_MEMBERS = 'Diese '.$LNG->GROUP_NAME.' hat keine Mitglieder.';
$LNG->GROUP_FORM_NO_PENDING = 'Diese '.$LNG->GROUP_NAME.' hat keine Bearbeitung Mitglieder- Anfragen.';
$LNG->GROUP_FORM_MEMBERS_PENDING = "Mitglied Beitreten Anfragen:";
$LNG->GROUP_FORM_NAME_LABEL = "Name";
$LNG->GROUP_FORM_DESC_LABEL = "Beschreibung";
$LNG->GROUP_FORM_ISADMIN_LABEL = "Admin";
$LNG->GROUP_FORM_REMOVE_LABEL = "Entfernen";
$LNG->GROUP_FORM_APPROVE_LABEL = "Genehmigen";
$LNG->GROUP_FORM_REJECT_LABEL = "Ablehnen";
$LNG->GROUP_FORM_REMOVE_MESSAGE_PART1 = 'Sind Sie sicher, dass Sie';
$LNG->GROUP_FORM_REMOVE_MESSAGE_PART2 = 'als Mitglied dieser Gruppe '.$LNG->GROUP_NAME.' entfernen möchten?';
$LNG->GROUP_FORM_REJECT_MESSAGE_PART1 = 'Sind Sie sicher, dass Sie';
$LNG->GROUP_FORM_REJECT_MESSAGE_PART2 = 'als Mitglied dieser '.$LNG->GROUP_NAME.' zurückweisen möchten?';
$LNG->GROUP_FORM_APPROVE_MESSAGE_PART1 = 'Sind Sie sicher, dass Sie';
$LNG->GROUP_FORM_APPROVE_MESSAGE_PART2 = 'genehmigen möchte Mitglied dieser '.$LNG->GROUP_NAME.' sein?';
$LNG->GROUP_JOIN_REQUEST_MESSAGE = 'Ihre Anfrage zu dieser '.$LNG->GROUP_NAME.' mitmachen wurde protokolliert und wartet darauf, zu genehmigen. Sie empfangen und E-Mail , wenn Sie den Antrag bearbeitet wurde.<br><br>Vielen Dank für Ihr Interesse an dieser '.$LNG->GROUP_NAME;
$LNG->GROUP_JOIN_PENDING_MESSAGE = 'Mitgliedschaft Pending';
$LNG->GROUP_MY_ADMIN_GROUPS_TITLE = $LNG->GROUPS_NAME.' Ich verwalten:';
$LNG->GROUP_MY_MEMBER_GROUPS_TITLE = $LNG->GROUPS_NAME.' Ich bin Mitglied der:';
$LNG->GROUP_FORM_IS_JOINING_OPEN_LABEL = 'Wird '.$LNG->GROUP_NAME.' Beitritt offen?';
$LNG->GROUP_FORM_IS_JOINING_OPEN_HELP = 'Wählen Sie das Kontrollkästchen, wenn die Menschen sich entscheiden, die '.$LNG->GROUP_NAME.' selbst teilnehmen möchten.<br>Lassen Sie das Kontrollkästchen nicht ausgewählt, wenn Sie bis mittelschwerer '.$LNG->GROUP_NAME.' mitmachen Anfragen und damit steuern, wer der '.$LNG->GROUP_NAME.' beitreten können möchten.';

$LNG->GROUP_FORM_MEMBERS = "Füge Mitglieder hinzu:<br/>(Semikolon)";
$LNG->GROUP_FORM_MEMBERS_HELP = "Bitte geben Sie die E-Mailadressen aller Leute ein, die der Gruppe beitreten sollen. Ihnen wird eine E-Mail zugesandt, die sie über die Gruppenmitgliedschaft informiert.";
$LNG->GROUP_FORM_NAME_ERROR = 'Sie müssen einen Namen eingeben '.$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NOT_GROUP_ADMIN = 'Sie sind hierfür nicht der Administrator  '.$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NOT_GROUP_ADMIN_ANY = 'Sie sind kein Adminstrator '.$LNG->GROUPS_NAME;
$LNG->GROUP_FORM_LOCATION = 'Ort: (Stadt/city)';
$LNG->GROUP_FORM_PHOTO = 'Foto';
$LNG->GROUP_FORM_PHOTO_HELP = '(Minimalgröße 150px w x 100px h. Größere Bilder werden reduziert/ auf die Größe zugeschnitten )';

$LNG->GROUP_BLOCK_STATS_PEOPLE = 'Mitglieder:';
$LNG->GROUP_BLOCK_STATS_ISSUES = $LNG->ISSUES_NAME.':';
$LNG->GROUP_BLOCK_STATS_VOTES = $LNG->VOTES_NAME.':';

$LNG->GROUP_MEMBERS_LABEL = "Gruppenmitglieder";
$LNG->LOADING_GROUP_MEMBERS = "Lädt die Gruppenmitglieder";
$LNG->DEBATE_MEMBERS_LABEL = $LNG->ISSUE_NAME." Teilnehmer";
$LNG->LOADING_DEBATE_MEMBERS = "Lädt die Gruppenmitglieder";
$LNG->GROUP_NO_MEMBERS_MESSAGE = 'Diese '.$LNG->GROUP_NAME.' hat keine Mitglieder.';

/** END GROUP **/

$LNG->DEBATE_IDEA_ID_ERROR = 'Der Aspekt, der verändert wurde, konnte nicht gefunden werden.';

$LNG->FORM_ISSUE_LABEL_TITLE = $LNG->ISSUE_NAME." Titel...";
$LNG->FORM_ISSUE_LABEL_DESC = $LNG->ISSUE_NAME." Beschreibung...";
$LNG->FORM_ISSUE_NEW_TITLE = "Füge neue Fragestellung hinzu ";
$LNG->FORM_EVIDENCE_NEW_TITLE_PRO = "Füge neues ProArgument hinzu";
$LNG->FORM_EVIDENCE_NEW_TITLE_CON = "Füge neues Kontra Argument hinzu ";
$LNG->FORM_SOLUTION_NEW_TITLE = "Füge neuen Aspekt hinzu ";
$LNG->FORM_ADD_NEW = "Füge Neues hinzu";
$LNG->FORM_PRIVACY = 'Veröffentlichen:';
$LNG->FORM_PRIVACY_HINT = "Wenn dieser Punkt öffentlich ist, kann er von allen gesehen werden. Wenn er privat ist, kann ihn nur der Besitzer sehen, oder wenn sich der Punkt in einer Gruppe befindet, können ihn andere Mitglieder der Gruppe sehen .";

$LNG->FORM_IDEA_LABEL_TITLE = $LNG->SOLUTION_NAME." Titel...";
$LNG->FORM_IDEA_LABEL_DESC = $LNG->SOLUTION_NAME." Beschreibung...";

$LNG->FORM_BUTTON_SUBMIT = 'Absenden ';
$LNG->FORM_BUTTON_SAVE = 'Speichern ';

$LNG->NODE_TOGGLE_HINT = 'Hier klicken, um mehr Diskussionen anzuzeigen oder auszublenden.';
$LNG->NODE_ADDED_BY = 'Hinzugefügt von:';
$LNG->NODE_CHILDREN_EVIDENCE_PRO = 'Pro';
$LNG->NODE_CHILDREN_EVIDENCE_CON = 'Contra';

$LNG->MAP_IMAGE_LABEL = $LNG->MAP_NAME.' Bild:';
$LNG->MAP_BACKGROUND_LABEL = $LNG->MAP_NAME.' Hintergrundbild:';
$LNG->MAP_BACKGROUND_REPLACE_LABEL = 'Ersetzen Sie Hintergrundbild';
$LNG->MAP_BACKGROUND_HELP = 'Ein Hintergrundbild Wählen Sie optional zur Karte über. Die Größe des Bildes zu zeichnen, wie vorgesehen sein.';
$LNG->MAP_BACKGROUND_DELETE_LABEL = 'Bild löschen';
$LNG->BUILTFROM_DIALOG_TITLE=" erstellt von:";
$LNG->PAGE_BUTTON_DASHBOARD = 'Dashboard';
$LNG->PAGE_BUTTON_SHARE = 'Teilen';

$LNG->IDEA_COMMENTS_LINK = $LNG->CHATS_NAME;
$LNG->IDEA_COMMENTS_HINT = 'Anschauen und hinzufügen '.$LNG->CHATS_NAME.' zu diesem '.$LNG->SOLUTION_NAME;
$LNG->IDEA_COMMENTS_CHILDREN_TITLE = $LNG->CHATS_NAME;
$LNG->IDEA_COMMENT_ID_ERROR = $LNG->CHAT_NAME.' Das Objekt konnte nicht gefunden werden';

$LNG->NODE_EDIT_SOLUTION_ICON_HINT = 'Bearbeite dies '.$LNG->SOLUTION_NAME;


/** MERGE ISSUES **/
$LNG->FORM_IDEA_MERGE_TITLE = "Führe  ".$LNG->SOLUTIONS_NAME." zusammen ";
$LNG->FORM_IDEA_MERGE_LABEL_TITLE = "Zusammengeführte ".$LNG->SOLUTIONS_NAME." Titel...";
$LNG->FORM_IDEA_MERGE_LABEL_DESC = "Zusammengeführte ".$LNG->SOLUTIONS_NAME." Beschreibung...";
$LNG->FORM_IDEA_MERGE_HINT = "Erstellen Sie einen neuen Aspekt, der die ausgewählten Aspekte repräsentiert. Fügen Sie sämtliche Kommentare und Argumente der ausgewählten Aspekte zu dieser neuen Idee zusammen.";
$LNG->FORM_IDEA_MERGE_MUST_SELECT = 'Sie sollten zuerst mindestens zwei Aspekte, die sie zusammenschließen möchten, auswählen.';
$LNG->FORM_IDEA_MERGE_NO_TITLE = "Für den neuen Zusammenschluss müssen Sie einen Titel bestimmen ".$LNG->SOLUTION_NAME;


/** SPLIT ISSUE **/
$LNG->FORM_BUTTON_SPLIT = 'Teile';
$LNG->FORM_BUTTON_SPLIT_HINT = 'Teilen Sie den '.$LNG->SOLUTION_NAME.' in zwei oder mehrere '.$LNG->SOLUTIONS_NAME;
$LNG->FORM_REMOVE_MULTI = "Sind Sie sicher, dass Sie diesen Punkt entfernen möchten? Diese Aktion kann nicht rückgängig gemacht werden!";
$LNG->FORM_SPLIT_IDEA_ERROR = "Sie müssen einen Titel für die ersten beiden Aspekte eingeben";


/** LIST NAV **/
$LNG->LIST_NAV_PREVIOUS_HINT = 'Vorhergehend';
$LNG->LIST_NAV_NO_PREVIOUS_HINT = 'Nicht vorhergehend';
$LNG->LIST_NAV_NEXT_HINT = 'Nächstes';
$LNG->LIST_NAV_NO_NEXT_HINT = 'Nicht nächstes';
$LNG->LIST_NAV_NO_ITEMS = "Sie haben bisher noch nichts hinzugefügt.";
$LNG->LIST_NAV_TO = 'um';
$LNG->LIST_NAV_NO_CON = 'Es gibt keinen '.$LNG->CONS_NAME.' um anzuzeigen';
$LNG->LIST_NAV_NO_PRO = 'Es gibt keine '.$LNG->PROS_NAME.' um anzuzeigen';
$LNG->LIST_NAV_NO_EVIDENCE = 'Es gibt keine '.$LNG->ARGUMENT_NAME.' Punkte anzuzeigen';
$LNG->LIST_NAV_NO_ISSUE = 'Es gibt keine '.$LNG->ISSUES_NAME.' um anzuzeigen';
$LNG->LIST_NAV_NO_SOLUTION = 'Es gibt keine '.$LNG->SOLUTIONS_NAME.' um anzuzeigen';
$LNG->LIST_NAV_NO_ITEMS = 'Es gibt keine Punkte anzuzeigen';

/** ODD **/
$LNG->POPUPS_BLOCK = 'Sie scheinen Popup-Fenster blockiert zu haben.\n\n Bitte ändern Sie Ihre Browsereinstellungen, um LiteMap zu erlauben, Popup-Fenster zu öffnen.';
$LNG->RESET_INVALID_MESSAGE = 'Ungültiger Passwort Reset-Code';
$LNG->SIDEBAR_TITLE = "Zuletzt gesehen";
$LNG->INDEX_ALL_DATA = 'Alle Daten';
$LNG->ENTER_URL_FIRST = 'Sie müssen zuerst eine URL eingeben';


/** LOADING MESSAGES **/
$LNG->LOADING_ITEMS = 'Items werden geladen';
$LNG->LOADING_MESSAGE_PRINT_NODE = 'Dies kann, abhängig von der Liste, die Sie sich anschauen, circa eine Minute dauern';
$LNG->LOADING_CHALLENGES = '( '.$LNG->CHALLENGES_NAME.' wird geladen...)';
$LNG->LOADING_ISSUES = '( '.$LNG->ISSUES_NAME.' wird geladen...)';
$LNG->LOADING_SOLUTIONS = '( '.$LNG->SOLUTIONS_NAME.' wird geladen...)';
$LNG->LOADING_PROS = '( '.$LNG->PROS_NAME.' wird geladen...)';
$LNG->LOADING_CONS = '( '.$LNG->CONS_NAME.' wird geladen...)';
$LNG->LOADING_EVIDENCES = '( '.$LNG->ARGUMENTS_NAME.' wird geladen...)';
$LNG->LOADING_RESOURCES = '( '.$LNG->RESOURCES_NAME.' wird geladen...)';
$LNG->LOADING_DATA = '(Die Dateien werden geladen...)';
$LNG->LOADING_COMMENTS = '( '.$LNG->COMMENTS_NAME.' wird geladen...)';
$LNG->LOADING_CHATS = '( '.$LNG->CHATS_NAME.' wird geladen...)';
$LNG->LOADING_USERS = '( '.$LNG->USERS_NAME.' wird geladen...)';
$LNG->LOADING_GROUPS = '( '.$LNG->GROUPS_NAME.' wird geladen...)';
$LNG->LOADING_MAPS = '( '.$LNG->MAPS_NAME.' wird geladen...)';
$LNG->LOADING_MESSAGE = 'Laden...';

/** TABS **/
//main
$LNG->TAB_HOME = 'Startseite';
$LNG->TAB_MAP = $LNG->MAPS_NAME;
$LNG->TAB_GROUP = $LNG->GROUPS_NAME;
$LNG->TAB_PRO = $LNG->PROS_NAME;
$LNG->TAB_CON = $LNG->CONS_NAME;

//explore
$LNG->VIEWS_LINEAR_TITLE = "Wissensbäume";
$LNG->VIEWS_LINEAR_HINT = "Klicken um sämtliche Listenansichten zu diesem Punkt zu sehen";
$LNG->VIEWS_WIDGET_TITLE = "Alle Details";
$LNG->WIDGET = "Klicken Sie hier, um sämtliche Listenansichten zu diesem Thema zu sehen";
$LNG->VIEWS_EVIDENCE_MAP_TITLE="Argument Map";
$LNG->VIEWS_EVIDENCE_MAP_HINT="Klicken Sie hier, um die Argument Map für dieses Thema zu sehen";

/** ERROR MESSAGES */
$LNG->DATABASE_CONNECTION_ERROR = 'Konnte nicht mit Datenbank verbunden werden - bitte überprüfen Sie die Servereinstellung.';
$LNG->ITEM_NOT_FOUND_ERROR = 'Das Item wurde nicht gefunden';

/** BUTTONS AND LINK HINTS **/
$LNG->SIGN_IN_HINT = 'Loggen Sie sich ein, um einen Beirag zu LiteMap hinzuzufügen';
$LNG->SIGN_IN_FOLLOW_HINT = 'Loggen Sie sich ein, um diesem Eintrag zu folgen';

$LNG->ADD_BUTTON = 'Hinzufügen';
$LNG->FOLLOW_BUTTON_ALT = 'Folgen';
$LNG->FOLLOW_OFF_BUTTON_ALT = 'Folgen aus';

$LNG->EDIT_BUTTON_TEXT = 'Bearbeiten';
$LNG->EDIT_BUTTON_HINT_ITEM = 'Bearbeite dieses Thema';
$LNG->EDIT_BUTTON_HINT_CHALLENGE = 'Bearbeite '.$LNG->CHALLENGE_NAME;
$LNG->EDIT_BUTTON_HINT_ISSUE = 'Bearbeite '.$LNG->ISSUE_NAME;
$LNG->EDIT_BUTTON_HINT_SOLUTION = 'Bearbeite '.$LNG->SOLUTION_NAME;
$LNG->EDIT_BUTTON_HINT_EVIDENCE = 'Bearbeite '.$LNG->ARGUMENT_NAME;
$LNG->EDIT_BUTTON_HINT_COMMENT = 'Bearbeite '.$LNG->COMMENT_NAME;

$LNG->DELETE_BUTTON_ALT = 'Löschen';
$LNG->DELETE_BUTTON_HINT = 'Lösche dieses Item';
$LNG->NO_DELETE_BUTTON_ALT = 'Löschen nicht verfügbar';
$LNG->NO_DELETE_BUTTON_HINT = 'Sie können diesen Item nicht löschen. Jemand hat sich damit verbunden';


/** FILTERS AND SORTS **/
$LNG->FILTER_BY = 'Filtern von';
$LNG->FILTER_TYPES_ALL = 'Alle Typen';

$LNG->SORT = 'Sortieren';
$LNG->SORT_BY = 'Sortieren nach';
$LNG->SORT_ASC = 'Aufsteigend';
$LNG->SORT_DESC = 'Absteigend';
$LNG->SORT_CREATIONDATE = 'Erstellungsdatum';
$LNG->SORT_MODDATE = 'Veränderungsdatum';
$LNG->SORT_TITLE = 'Titel';
$LNG->SORT_URL = 'Website';
$LNG->SORT_NAME = 'Name';
$LNG->SORT_MEMBERS = 'Mitgliederzahl';
$LNG->SORT_CONNECTIONS = 'Verbindungen';
$LNG->SORT_VOTES = 'Votes';
$LNG->SORT_LAST_LOGIN = 'Letzter Log-In';
$LNG->SORT_DATE_JOINED = 'Beitrittsdatum';

$LNG->ALL_ITEMS_FILTER = "Alle Items";
$LNG->CONNECTED_ITEMS_FILTER = "Verbundene Items";
$LNG->UNCONNECTED_ITEMS_FILTER = "Nicht verbundene Items";

/** EXPLORE SECTION TITLES **/
$LNG->EXPLORE_challengeToFollower = $LNG->FOLLOWERS_NAME.' von diesem '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_issueToFollower = $LNG->FOLLOWERS_NAME.' von diesem '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_solutionToFollower = $LNG->FOLLOWERS_NAME.' von diesem '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_solutionToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_evidenceToFollower = $LNG->FOLLOWERS_NAME.' von diesem '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_evidenceToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_proToFollower = $LNG->FOLLOWERS_NAME.' von diesem '.$LNG->PRO_NAME;
$LNG->EXPLORE_proToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_conToFollower = $LNG->FOLLOWERS_NAME.' von diesem '.$LNG->CON_NAME;
$LNG->EXPLORE_conToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_commentToFollower = $LNG->FOLLOWERS_NAME.' von diesem '.$LNG->COMMENT_NAME;
$LNG->EXPLORE_commentToMap = $LNG->MAPS_NAME;

/** EXPLORE BUTTONS,LINKS AND HINTS **/
$LNG->EXPLORE_PRINT_BUTTON_ALT = "Drucke diesen Item";
$LNG->EXPLORE_PRINT_BUTTON_HINT = "Drucke diesen Item";

$LNG->EXPLORE_BACKTOTOP = 'Zurück zum Anfang';
$LNG->EXPLORE_BACKTOTOP_IMG_ALT = 'Hoch';

$LNG->EXPLORE_SUPPORTING_EVIDENCE = 'Unterstützend '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_COUNTER_EVIDENCE = 'Dagegen '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_ISSUES_ADDRESSED = $LNG->ISSUES_NAME.' angesprochen';
$LNG->EXPLORE_CHALLENGES_ADDRESSED = $LNG->CHALLENGES_NAME.' angesprochen';
$LNG->EXPLORE_SOLUTIONS_SPECIFIED = $LNG->SOLUTIONS_NAME.' spezifiziert';
$LNG->EXPLORE_EVIDENCE_SPECIFIED = $LNG->ARGUMENTS_NAME.' spezifiziert';

$LNG->HOME_ADDITIONAL_INFO_TOGGLE_HINT = 'Klicke zur Aussicht/verstecke zusätzliche Information';

$LNG->CONDITIONS_REGISTER_FORM_TITLE = 'Nutzungsbedingungen und Benutzungsregeln';
$LNG->CONDITIONS_REGISTER_FORM_MESSAGE = 'Indem Sie sich als Mitglied dieses Hub registrieren, erklären Sie sich mit den Nutzerbedingungen und den Benutzungsregeln dieses Hub einverstanden, wie sie in unseren <a href="'.$CFG->homeAddress.'ui/Seiten/Benutzerkonditionen.php">Nutzerbedingungen</a>.';
$LNG->CONDITIONS_AGREE_FORM_REGISTER_MESSAGE = 'Ich erkläre mich mit den Nutzungsbedingungen und Benutzungsregeln dieses Hubs einverstanden';
$LNG->CONDITIONS_AGREE_FAILED_MESSAGE = 'Sie müssen den Nutzungsbedingungen und Benutzungsregeln dieses Hubs zustimmen, bevor Sie sich registrieren können.';
$LNG->CONDITIONS_LOGIN_FORM_MESSAGE = 'Wenn Sie sich als Mitglied dieses Hub registrieren, erklären Sie sich mit den Nutzerbedingungen und den Benutzungsregeln dieses Hub einverstanden, wie sie in unseren <a href="'.$CFG->homeAddress.'ui/Seiten/Benutzerkonditionen.php">Nutzerbedingungen</a>.';

$LNG->FORM_HEADER_MESSAGE = 'Bitte seinen Sie sich bewusst, dass alle Daten, die Sie hier eingeben, von anderen Benutzern öffentlich auf dieser Seite gesehen werden können, sofern Sie nicht die \'Public\' Option deaktivieren .';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1 = '(Felder mit einem';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2 = 'sind verpflichtend';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART3 = ', obwohl sie sich in einem optionalen Unterabschnitt befinden, den Sie nicht vervollständigen)';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART4 = '.)';
$LNG->FORM_RESOURCE_ADD_ANOTHER = 'fügen Sie eine weitere '.$LNG->RESOURCE_NAME;
$LNG->FORM_ADD_ANOTHER = 'fügen eine weitere';
$LNG->RESOURCES_REMOTE_FORM_HINT = '(optional) - Aktiviere alles '.$LNG->RESOURCES_NAME.' befürworte diesen Punkt. Die URL dieser Seite, auf der du dich momentan befindest, wurde automatisch für dich aktiviert, genauso wie jede im Text ausgewählte url.';
$LNG->RESOURCES_FORM_HINT  = '(optional) - Bitte füge winw Beschreibung hinzu '.$LNG->RESOURCES_NAME.' Es wird für Leute, die sich diesen Punkt anschauen, nützlich sein.';
$LNG->RESOURCES_TITLE_FORM_HINT = '(obligatorisch) - Geben Sie einen Titel für das Web-Ressource. Wenn Sie den Titel nicht abschließen, wird die URL verwendet werden.<br><br>Szmtag Sie können die Pfeiltaste am Ende der URL-Feld verwenden, um zu versuchen und holen den Titel von der Website Seite automatisch ab, wenn Sie es wünschen.';
$LNG->RESOURCES_URL_FORM_HINT = '(obligatorisch) - Geben Sie die URL der Web-Ressource';

$LNG->FORM_REQUIRED_FIELDS = 'weist auf das benötigte Feld hin';
$LNG->FORM_LABEL_SUMMARY = 'Zusammenfassung:';
$LNG->FORM_LABEL_DESC = 'Beschreibung:';
$LNG->FORM_LABEL_TYPE = 'Typ:';
$LNG->FORM_LABEL_EVIDENCE_TYPE = $LNG->ARGUMENT_NAME.' Typ:';
$LNG->FORM_LABEL_EVIDENCE_RESOURCES = $LNG->ARGUMENT_NAME.' '.$LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_URL = 'Url:';
$LNG->FORM_LABEL_TITLE = 'Titel:';
$LNG->FORM_LABEL_NAME = 'Name:';
$LNG->FORM_LABEL_PROJECT_STARTED_DATE = 'Startete am:';
$LNG->FORM_LABEL_PROJECT_ENDED_DATE = 'Endetete am:';
$LNG->FORM_LABEL_LOCATION = 'Ort';
$LNG->FORM_LABEL_ADDRESS1 = 'Adresse 1:';
$LNG->FORM_LABEL_ADDRESS2 = 'Adresse 2:';
$LNG->FORM_LABEL_TOWN = 'Stadt:';
$LNG->FORM_LABEL_POSTAL_CODE = 'Postleitzahl:';
$LNG->FORM_LABEL_COUNTRY = 'Land:';
$LNG->FORM_LABEL_COUNTRY_CHOICE = 'Land...';
$LNG->FORM_LABEL_CHALLENGES_TOGGLE = 'Anzeigen/Verstecken '.$LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_CHALLENGES = $LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_RESOURCES = $LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_CLIP = 'Ausschneiden:';
$LNG->FORM_LABEL_CLIPS = 'Ausschnitte:';

$LNG->FORM_DESC_PLAIN_TEXT_LINK = 'Volltext';
$LNG->FORM_DESC_PLAIN_TEXT_HINT = 'Zum Volltext wechseln. Das Format bleibt dabei nicht erhalten.';
$LNG->FORM_DESC_HTML_TEXT_LINK = 'Formatieren';
$LNG->FORM_DESC_HTML_TEXT_HINT = 'Zeige die Formatierungstoolbar an.';
$LNG->FORM_DESC_HTML_SWITCH_WARNING = 'Sind Sie sicher, dass Sie zum Volltext wechseln möchten? Warnung: Die ganze Formatierung wird gelöscht werden.';

$LNG->FORM_AUTOCOMPLETE_TITLE_HINT = 'Holen Sie sich den Website-Titel von den Daten der Webseite';
$LNG->FORM_SELECT_RESOURCE_HINT = 'Wählen/Erstellen Sie einen '.$LNG->RESOURCE_NAME.' um dies zu unterstützen';

$LNG->FORM_BUTTON_REMOVE = 'Entfernen';
$LNG->FORM_BUTTON_REMOVE_CAP = 'Entfernen';
$LNG->FORM_BUTTON_SELECT_ANOTHER = 'Wählen Sie einen anderen aus';
$LNG->FORM_BUTTON_ADD_ANOTHER = 'Fügen Sie einen anderen hinzu';
$LNG->FORM_BUTTON_CHANGE = 'Wechseln';
$LNG->FORM_BUTTON_ADD = 'Hinzufügen';
$LNG->FORM_BUTTON_ADD_NEW = 'Füge Neues hinzu';
$LNG->FORM_BUTTON_PUBLISH = 'Veröffentlichen';
$LNG->FORM_BUTTON_CANCEL = 'Rückgängig machen';
$LNG->FORM_BUTTON_CLOSE = 'Schließen';
$LNG->FORM_BUTTON_CONTINUE = 'Fortfahren';
$LNG->FORM_BUTTON_NEXT = 'Nächstes   >';
$LNG->FORM_BUTTON_BACK = '<   Zurück';
$LNG->FORM_BUTTON_SKIP = 'Springen   >';
$LNG->FORM_BUTTON_PRINT_PAGE = 'Seite drucken';

$LNG->FORM_ERROR_NOT_ADMIN = 'Sie haben keine Erlaubnis, diese Seite zu sehen';
$LNG->FORM_ERROR_MESSAGE = 'Die folgenden Probleme wurden gefunden, bitte versuchen Sie es später noch einmal';
$LNG->FORM_ERROR_MESSAGE_LOGIN = 'Die folgenden Themen wurden bei ihrem Anmeldeversuch gefunden:';
$LNG->FORM_ERROR_MESSAGE_REGISTRATION = 'Die folgenden Probleme wurden bei ihrer Registrierung gefunden, bitte versuchen Sie es später noch einmal:';
$LNG->FORM_ERROR_NOT_ADMIN = "Tut uns leid, Sie müssen ein Administrator sein, um Zugang zu dieser Seite zu haben";
$LNG->FORM_ERROR_PASSWORD_MISMATCH = "Das Passwort und die Passwortbestätigung stimmen nicht überein. Bitte versuchen Sie es noch einmal.";
$LNG->FORM_ERROR_PASSWORD_MISSING = "Bitte geben Sie ein Passwort ein.";
$LNG->FORM_ERROR_NAME_MISSING = 'Bitte gebem Sie ihren vollständigen Namen ein.';
$LNG->FORM_ERROR_INTEREST_MISSING = "Bitte geben Sie ein, warum Sie gerne einen Account bei uns hätten.";
$LNG->FORM_ERROR_URL_INVALID = "Bitte geben Sie eine gültige URL (einschließlich 'http://') ein.";
$LNG->FORM_ERROR_EMAIL_INVALID = "Bitte geben Sie eine gültige E-Mailadresse ein.";
$LNG->FORM_ERROR_EMAIL_USED = "Diese E-Mailadresse wird bereits benutzt, bitte loggen Sie sich ein oder oder wählen Sie eine andere E-Mailadresse.";
$LNG->FORM_ERROR_CAPTCHA_INVALID = "Der reCAPTCHA wurde nicht korrekt eingegeben. Bitte versuchen Sie es später noch einmal.";

$LNG->FORM_TITLE_CURRENT_ITEM = 'Das aktuelle Item';

//Selector
$LNG->FORM_SELECTOR_TITLE_DEFAULT = 'Wähle ein Item aus';
$LNG->FORM_SELECTOR_TITLE_CHALLENGE = 'Wähle '.$LNG->CHALLENGE_NAME.' aus' ;
$LNG->FORM_SELECTOR_TITLE_RESOURCE = 'Wähle '.$LNG->RESOURCE_NAME.' aus';
$LNG->FORM_SELECTOR_TITLE_EVIDENCE = 'Wähle ein '.$LNG->ARGUMENT_NAME.' aus';
$LNG->FORM_SELECTOR_TITLE_ISSUE = 'Wähle einen '.$LNG->ISSUE_NAME.' aus';
$LNG->FORM_SELECTOR_TITLE_SOLUTION = 'Wähle einen '.$LNG->SOLUTION_NAME.' aus';
$LNG->FORM_SELECTOR_TITLE_COMMENT = 'Wähle einen '.$LNG->COMMENT_NAME;

$LNG->FORM_SELECTOR_SEARCH_ERROR = 'Beim Wiederfinden Ihrer Suche auf dem Server kam es zu einem Fehler ';
$LNG->FORM_SELECTOR_NOT_ITEMS = 'Sie haben keine Items des benötigten Typen erstellt';
$LNG->FORM_SELECTOR_SEARCH_LABEL = 'Suche';
$LNG->FORM_SELECTOR_SEARCH_MESSAGE = '( Leer lassen und ausführen, um alle aufzulisten )';
$LNG->FORM_SELECTOR_SEARCH_EMPTY_MESSAGE = 'Führen Sie eine Suche , um hier aufgeführten Ergebnisse sehen';
$LNG->FORM_SELECTOR_TAB_MINE = 'Meine';
$LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS = 'Suchergebnisse';

//Challenge
$LNG->FORM_TITLE_CHALLENGE_ADD = 'Fügen Sie eine '.$LNG->CHALLENGE_NAME.' hinzu';
$LNG->FORM_TITLE_CHALLENGE_CONNECT = 'Wähle Sie eine '.$LNG->CHALLENGES_NAME.' aus und fügen Sie hinzu';
$LNG->FORM_TITLE_CHALLENGE_EDIT = 'Bearbeiten Sie die '.$LNG->CHALLENGE_NAME;
$LNG->FORM_LABEL_CHALLENGE_SUMMARY = 'Zusammenfassung';
$LNG->FORM_MESSAGE_CHALLENGE = 'Fügen Sie eine  '.$LNG->CHALLENGE_NAME.' hinzu, von der Sie der Meinung sind, dass die Community sie diskutieren sollte.';
$LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR = 'Bitte geben Sie eine '.$LNG->CHALLENGE_NAME.' ein, bevor Sie versuchen zu veröffentlichen';
$LNG->FORM_CHALLENGE_NOT_FOUND = 'Die benötigte '.$LNG->CHALLENGE_NAME.' konnte nicht gefunden werden';

//Issue
$LNG->FORM_ISSUE_TITLE_SECTION = 'Erstellen/Wählen Sie einen '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_CONNECT = ' und verbinden Sie ihn mit '.$LNG->FORM_ISSUE_TITLE_SECTION;
$LNG->FORM_ISSUE_TITLE_ADD = 'Fügen Sie einen '.$LNG->ISSUE_NAME.' hinzu';
$LNG->FORM_ISSUE_TITLE_SECTION_QUICK = 'Schnell füge einen '.$LNG->ISSUE_NAME.' hinzu';
$LNG->FORM_ISSUE_TITLE_EDIT = 'Bearbeiten Sie den '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR = 'Bitte geben Sie eine Zusammenfassung ein, bevor Sie versuchen zu veröffentlichen';
$LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE = 'Es gab ein Problem beim Erstellen des '.$LNG->ISSUE_NAME.' s:';
$LNG->FORM_ISSUE_HEADING_MESSAGE = 'Füge eine '.$LNG->ISSUE_NAME.' hinzu, von der Sie finden, dass die Community sie diskutieren sollte.';
$LNG->FORM_ISSUE_LABEL_SUMMARY = $LNG->ISSUE_NAME.' Zusammenfassung:';
$LNG->FORM_ISSUE_NOT_FOUND = 'Die benötigte '.$LNG->ISSUE_NAME.' konnte nicht gefunden werden';
$LNG->FORM_ISSUE_SELECT_EXISTING = 'Wählen Sie eine existierende '.$LNG->ISSUE_NAME;

// Solution
$LNG->FORM_SOLUTION_TITLE_SECTION = 'Erstelle/Wähle einen '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_CONNECT = $LNG->FORM_SOLUTION_TITLE_SECTION.' und verbinde ihn mit ';
$LNG->FORM_SOLUTION_TITLE_ADD = 'Füge einen '.$LNG->SOLUTION_NAME.' hinzu';
$LNG->FORM_SOLUTION_TITLE_SECTION_QUICK = 'Schnell füge einen '.$LNG->SOLUTION_NAME.' hinzu';
$LNG->FORM_SOLUTION_TITLE_EDIT = 'Bearbeite das '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_LABEL_SUMMARY = $LNG->SOLUTION_NAME_SHORT.' Zusammenfassung:';
$LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR = 'Bitte gebe einen '.$LNG->SOLUTION_NAME.' ein, bevor du versuchst zu veröffentlichen';
$LNG->FORM_SOLUTION_CREATE_ERROR_MESSAGE = 'Es gab ein Problem beim Erstellen des '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_NOT_FOUND = 'Der benötigte '.$LNG->SOLUTION_NAME.' konnte nicht gefunden werden';
$LNG->FORM_SOLUTION_SELECT_EXISTING = 'Wähle existierend '.$LNG->SOLUTION_NAME_SHORT;
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE1 = 'Wenn Sie '.$LNG->RESOURCE_NAME.' hierzu etwas hinzufügen möchten '.$LNG->SOLUTION_NAME.' müssen Sie ein '.$LNG->ARGUMENT_NAME.' Item benutzen.';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE2 = 'Um einen '.$LNG->ARGUMENT_NAME.' hinzuzufügen, versuchen Sie die folgende Frage zu beantworten';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE3 = 'Warum unterstützt der'.$LNG->RESOURCE_NAME.' dies '.$LNG->SOLUTION_NAME.'? Wie lautet der '.$LNG->ARGUMENT_NAME.' in diesem '.$LNG->RESOURCE_NAME.' der dazu geführt hat, dass du dies hinzufügen möchtest '.$LNG->SOLUTION_NAME.'?';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE4 = 'Bitte füge dem "Unterstützen" anbei eine Erklärung hinzu '.$LNG->ARGUMENT_NAME.'" und "Beschreibung" Felder.';

// Evidence
$LNG->FORM_EVIDENCE_LABEL_SUMMARY = $LNG->ARGUMENT_NAME." Zusammenfassung:";
$LNG->FORM_EVIDENCE_TITLE_SECTION = 'Kreiere/Wähle ein item aus ';
$LNG->FORM_EVIDENCE_TITLE_SECTION_SUPPORTING = 'Unterstützen';
$LNG->FORM_EVIDENCE_TITLE_SECTION_COUNTER = 'In Frage stellen';
$LNG->FORM_EVIDENCE_TITLE_CONNECT = ' und verbinde es mit ';
$LNG->FORM_EVIDENCE_TITLE_ADD = $LNG->ARGUMENT_NAME.' hinzufügen ';
$LNG->FORM_EVIDENCE_PRO_TITLE_ADD = $LNG->PRO_NAME.' hinzufügen ';
$LNG->FORM_EVIDENCE_CON_TITLE_ADD = $LNG->CON_NAME.' hinzufügen ';
$LNG->FORM_EVIDENCE_TITLE_EDIT = $LNG->ARGUMENT_NAME.' bearbeiten ';
$LNG->FORM_EVIDENCE_PRO_TITLE_EDIT = $LNG->PRO_NAME.' bearbeiten ';
$LNG->FORM_EVIDENCE_CON_TITLE_EDIT = $LNG->CON_NAME.' bearbeiten ';
$LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR = 'Bitte geben Sie eine Zusammenfassung des '.$LNG->ARGUMENT_NAME.' ein, bevor Sie versuchen, zu veröffentlichen';
$LNG->FORM_EVIDENCE_SELECT_EXISTING = 'Wählen Sie den existierenden '.$LNG->ARGUMENT_NAME.' aus ';
$LNG->FORM_EVIDENCE_ALREADY_EXISTS = 'Sie haben bereits ein Item mit dieser Zusammenfassung und diesem Typ. Bitte ändern Sie eines der beiden.';
$LNG->FORM_EVIDENCE_NOT_FOUND = 'Das benötigte '.$LNG->ARGUMENT_NAME.' Thema konnte nicht gefunden werden';
$LNG->FORM_SUPPORTING_EVIDENCE_LABEL = 'Unterstützen '.$LNG->ARGUMENT_NAME;

// Pro
$LNG->FORM_PRO_TITLE_SECTION = 'Erstelle/Wähle ein '.$LNG->PRO_NAME;
$LNG->FORM_PRO_TITLE_ADD = 'Füge '.$LNG->PRO_NAME.' hinzu';
$LNG->FORM_PRO_TITLE_SECTION_QUICK = 'Schnell füge einen '.$LNG->PRO_NAME.' hinzu';

// Con
$LNG->FORM_CON_TITLE_SECTION = 'Kreiere/Wähle ein '.$LNG->CON_NAME;
$LNG->FORM_CON_TITLE_ADD = 'Füge '.$LNG->CON_NAME.' hinzu';
$LNG->FORM_CON_TITLE_SECTION_QUICK = 'Schnell füge einen '.$LNG->CON_NAME.' hinzu';

// Argument
$LNG->FORM_ARGUMENT_TITLE_SECTION = 'Kreiere/Wähle ein '.$LNG->ARGUMENT_NAME;
$LNG->FORM_ARGUMENT_TITLE_ADD = 'Füge '.$LNG->ARGUMENT_NAME.' hinzu';
$LNG->FORM_ARGUMENT_TITLE_SECTION_QUICK = 'Schnell füge einen '.$LNG->ARGUMENT_NAME;

// Idea
$LNG->FORM_COMMENT_TITLE_SECTION = 'Kreiere/Wähle ein '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_TITLE_ADD = 'Füge '.$LNG->COMMENT_NAME.' hinzu';
$LNG->FORM_COMMENT_TITLE_SECTION_QUICK = 'Schnell füge einen '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR = 'Bitte geben Sie einen '.$LNG->COMMENT_NAME.' zu schreiben, bevor Sie veröffentlichen';

// Map
$LNG->FORM_MAP_TITLE_SECTION = 'Kreiere/Wähle ein '.$LNG->MAP_NAME;
$LNG->FORM_MAP_TITLE_ADD = 'Füge '.$LNG->MAP_NAME.' hinzu';

$LNG->FORM_ADD_QUICK = 'Schnell Neue Hinzufügen:';

/** FORM ROLLOVER HINTS **/
//Challenge
$LNG->CHALLENGE_SUMMARY_FORM_HINT = '(Verpflichtend) - Geben Sie einen neuen  '.$LNG->CHALLENGE_NAME.' ein. Dies wird den angezeigten Titel in den Listen ändern.';
$LNG->CHALLENGE_DESC_FORM_HINT ='(optional) - Tragen Sie eine längere Beschreibung des '.$LNG->CHALLENGE_NAME.' ein';
$LNG->CHALLENGE_REASON_FORM_HINT = 'Beschreiben Sie, warum Sie denken, dass dies für '.$LNG->CHALLENGE_NAME.' relevant ist: ';
$LNG->CHALLENGES_FORM_HINT = 'Wählen Sie den '.$LNG->CHALLENGES_NAME.' aus, auf den Sie Bezug nehmen möchten: ';

// Issues
$LNG->ISSUE_SUMMARY_FORM_HINT = '(verpflichtend) - Geben Sie einen neuen '.$LNG->ISSUE_NAME.' ein. Dies wird den '.$LNG->ISSUE_NAME.' stellen. Der Titel ist in den Listen dargestellt.';
$LNG->ISSUE_DESC_FORM_HINT = '(optional) - Geben Sie eine längere Beschreibung des '.$LNG->ISSUE_NAME.' ein';
$LNG->ISSUE_CHALLENGES_FORM_HINT = '(optional) - Geben Sie einen oder mehrere '.$LNG->CHALLENGES_NAME.' ein, auf die der '.$LNG->ISSUE_NAME.' bezogen ist.';
$LNG->ISSUE_REASON_FORM_HINT = '(optional) - Beschreiben Sie, warum Sie denken, dass dies '.$LNG->ISSUE_NAME.' relevant ist: ';
$LNG->ISSUE_OTHERCHALLENGE_FORM_HINT = '(optional) - Suchen Sie einen anderen '.$LNG->CHALLENGES_NAME.' heraus, den Sie hierzu in Bezug setzen möchten '.$LNG->ISSUE_NAME;
$LNG->ISSUE_RESOURCE_FORM_HINT = '(optional) - Füge jegliche Veröffentlichungen, Website, oder Bilder, etc. hinzu, die Teil dessen sind oder dies unterstützen '.$LNG->ISSUE_NAME.'. Sie können mehr als eines eingeben.';

// Solutions
$LNG->SOLUTION_SUMMARY_FORM_HINT = '(verpflichtend) - Geben Sie einen neuen  '.$LNG->SOLUTION_NAME.' ein. Dies wird den Itemtitel darstellen.';
$LNG->SOLUTION_PRO_FORM_HINT = 'Gebe etwas ein, das dem oben gesagten als unterstützender Beweis dient '.$LNG->SOLUTION_NAME.'. Fügen Sie eine Zusammenfassung des Beweises hinzu, und dann, sofern gewünscht, eine detailliertere Beschreibung und/ oder eine URL für eine Website, die als Quelle/Unterstützung dient.';
$LNG->SOLUTION_CON_FORM_HINT = 'Gebe etwas ein, das dem oben gesagten als widersprechender Beweis dient '.$LNG->SOLUTION_NAME.'.  Fügen Sie eine Zusammenfassung des Beweises hinzu, und, sofern gewünscht, eine detailliertere Beschreibung und/ oder eine URL für eine Website, der als Quelle / Unterstützung dient.';
$LNG->SOLUTION_DESC_FORM_HINT = '(optional) - Gebe eine längere Beschreibung des ein '.$LNG->SOLUTION_NAME;
$LNG->SOLUTION_REASON_FORM_HINT = '(optional) - Beschreiben Sie, warum Sie dies '.$LNG->SOLUTION_NAME.' relevant finden: ';

// Evidence
$LNG->EVIDENCE_SUMMARY_FORM_HINT = '(verpflichtend) - Geben Sie eine Zusammenfassung der  '.$LNG->ARGUMENT_NAME.' ein. Dies wird der '.$LNG->ARGUMENT_NAME.' angezeigte Titel in den Listen sein.';
$LNG->EVIDENCE_DESC_FORM_HINT = '(optional) - Geben Sie eine längere Beschreibung der '.$LNG->ARGUMENT_NAME;
$LNG->EVIDENCE_WEBSITE_FORM_HINT = '(optional) - Füge jegliche Veröffentlichungen, Websiten, oder Bilder, etc. hinzu.. die Teil davon sind oder dies unterstützen '.$LNG->ARGUMENT_NAME.'. Sie können mehr als eine Quelle eingeben.';
$LNG->EVIDENCE_TYPE_FORM_HINT = '(verpflichtend) - Wählen Sie aus, welcher Art von '.$LNG->ARGUMENT_NAME.' Sie zustimmen möchten  - das Versäumnis ist '.$CFG->EVIDENCE_TYPES_DEFAULT.', aber wenn Sie spezifischer werden könnten, wäre dies hilfreich.';
$LNG->EVIDENCE_REASON_FORM_HINT = '(optional) - Beschreiben Sie, warum Sie finden, dass dies '.$LNG->ARGUMENT_NAME.' relevant ist: ';

//Comment
$LNG->COMMENT_SUMMARY_FORM_HINT = '(verpflichtend) - Geben Sie Ihren '.$LNG->COMMENT_NAME.' titel ein hier ein';
$LNG->COMMENT_DESC_FORM_HINT = '(optional) - Geben Sie eine längere Beschreibung des '.$LNG->COMMENT_NAME.' ein';
$LNG->COMMENT_IMAGE_HINT = 'Rechtsklicken Sie auf das Bild um es zu vergrößern.';

//Remote Forms
$LNG->REMOTE_EVIDENCE_SOLUTION_FORM_HINT = 'Geben Sie Ihre Unterstützung '.$LNG->ARGUMENT_NAME.' für den '.$LNG->SOLUTION_NAME.'ein. Fügen Sie eine Zusammenfassung des '.$LNG->ARGUMENT_NAME.' hinzu, und dann, sofern gewünscht, eine detailliertere Beschreibung.';
$LNG->REMOTE_EVIDENCE_DESC_FORM_HINT = 'Geben Sie eine längere Beschreibung des '.$LNG->ARGUMENT_NAME.' ein (optional)';
$LNG->REMOTE_EVIDENCE_TYPE_FORM_HINT = 'Wählen Sie aus, welcher Art von '.$LNG->ARGUMENT_NAME.' Sie zustimmen möchten - das Versäumnis ist '.$CFG->EVIDENCE_TYPES_DEFAULT.', aber wenn Sie es spezifischer sein könnten, wäre dies hilfreich.';


/*** NODE LISTINGS AND ITEMS ***/
$LNG->NODE_DETAIL_BUTTON_TEXT = 'Vollständige Details';
$LNG->NODE_DETAIL_MENU_TEXT = 'Vollständige Details';
$LNG->NODE_DETAIL_BUTTON_HINT = 'Gehen Sie zu vollständiger Information dieses Items.';

$LNG->NODE_TYPE_ICON_HINT = 'Betrachten Sie das orginale Bild';
$LNG->NODE_EXPLORE_BUTTON_TEXT = 'Entdecken Sie >>';
$LNG->NODE_EXPLORE_BUTTON_HINT = 'Klicken Sie, um anzuzeigen/ zu verstecken wo Sie hingehen können, und mehr Information und Aktivitäten zu diesem Item sehen können';
$LNG->NODE_DISCONNECT_MENU_TEXT = 'Verbindung trennen';
$LNG->NODE_DISCONNECT_MENU_HINT = 'Dieses von dem zentralen Item trennen';
$LNG->NODE_DISCONNECT_LINK_TEXT = 'Entfernen';
$LNG->NODE_DISCONNECT_LINK_HINT = 'Entfernen Sie dies von dem aktuellen zentralen Item';
$LNG->NODE_VIEW_CONNECTOR_MENU_TEXT = "Wer hat es hinzugefügt?";
$LNG->NODE_VIEW_CONNECTOR_MENU_HINT = "Gehen Sie zur Verbindungsseite: ";

//in widget list

$LNG->NODE_EDIT_ICON_ALT = 'Bearbeiten';
$LNG->NODE_EDIT_CHALLENGE_ICON_HINT = $LNG->CHALLENGE_NAME.' bearbeiten ';
$LNG->NODE_EDIT_ISSUE_ICON_HINT = $LNG->ISSUE_NAME.' bearbeiten ';
$LNG->NODE_EDIT_EVIDENCE_ICON_HINT = $LNG->ARGUMENT_NAME.' bearbeiten ';

$LNG->NODE_DELETE_ICON_ALT = 'Löschen';
$LNG->NODE_DELETE_ICON_HINT = 'Diesen Item löschen';
$LNG->NODE_NO_DELETE_ICON_ALT = 'Löschen nicht möglich';
$LNG->NODE_NO_DELETE_ICON_HINT = 'Sie können dieses Item nicht löschen. Jemand anderes hat sich damit verbunden';
$LNG->NODE_SUPPORTING_EVIDENCE_LINK = $LNG->ARGUMENT_NAME.'unterstützen ';
$LNG->NODE_ADD_SUPPORTING_EVIDENCE_HINT = $LNG->ARGUMENT_NAME.' hinzufügen ';
$LNG->NODE_COUNTER_EVIDENCE_LINK = 'Pro-Argument hinzufügen';
$LNG->NODE_ADD_COUNTER_EVIDENCE_HINT = 'Contra-Argument hinzufügen';

$LNG->NODE_VOTE_FOR_ICON_ALT = 'Dafür stimmen';
$LNG->NODE_VOTE_AGAINST_ICON_ALT = 'Dagegen stimmen';
$LNG->NODE_VOTE_REMOVE_HINT = 'Löschen...';
$LNG->NODE_VOTE_FOR_ADD_HINT = 'Dies voranbringen...';
$LNG->NODE_VOTE_FOR_SOLUTION_HINT = 'Sehr '.$LNG->SOLUTION_NAME.' dafür';
$LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT = 'Überzeugend '.$LNG->ARGUMENT_NAME.' dafür';
$LNG->NODE_VOTE_AGAINST_ADD_HINT = 'Dies zurückstufen...';
$LNG->NODE_VOTE_AGAINST_SOLUTION_HINT = 'Wenig '.$LNG->SOLUTION_NAME.' hierfür';
$LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT = 'Nicht überzeugend '.$LNG->ARGUMENT_NAME.' dafür';
$LNG->NODE_VOTE_FOR_LOGIN_HINT = 'Loggen Sie sich ein, um dies voranzubringen';
$LNG->NODE_VOTE_AGAINST_LOGIN_HINT = 'Loggen Sie sich ein, zu dies zurückzustufen';
$LNG->NODE_VOTE_MENU_TEXT = 'Stimme:';
$LNG->NODE_VOTE_OWN_HINT = 'Sie können nicht für Ihre eigenen Items stimmen';

$LNG->NODE_VOTE_FOR_TITLE = 'Votum für diesen Knoten in Bezug auf:';
$LNG->NODE_VOTE_AGAINST_TITLE = 'Votum gegen diesen Knoten in Bezug auf:';

$LNG->NODE_ADDED_ON = 'Hinzugefügt zu:';
$LNG->NODE_CONNECTED_ON = 'Verbunden mit';
$LNG->NODE_CONNECTED_BY = 'Verbunden durch';
$LNG->NODE_RESOURCE_LINK_HINT = 'Seite betrachten';
$LNG->NODE_URL_LINK_TEXT = 'Gehen Sie zur Website';
$LNG->NODE_URL_LINK_HINT = 'Die geforderte Website in einem neuen Tab öffnen';
$LNG->NODE_URL_HEADING = 'Url:';
$LNG->NODE_RESOURCE_CLIPS_HEADING = 'Clips:';
$LNG->NODE_RESOURCE_CLIP_HEADING = 'Clip:';
$LNG->NODE_DESC_HEADING = 'Beschreibung:';

$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART1 = 'Sind Sie sich sicher, dass Sie die Verbindung trennen wollen?';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART2 = 'von';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART3 = '?';
$LNG->NODE_DELETE_CHECK_MESSAGE = 'Sind Sie sicher, dass Sie dies löschen möchten?';
$LNG->NODE_DELETE_CHECK_MESSAGE_ITEM = 'Item';
$LNG->NODE_FOLLOW_ITEM_HINT = 'Diesem Item folgen...';
$LNG->NODE_UNFOLLOW_ITEM_HINT = 'Diesem Item nicht folgen...';


/** BUILDER TOOLBAR **/
$LNG->BUILDER_GOTO_HOME_SITE_HINT = "gehen zu ".$CFG->SITE_TITLE." Website";
$LNG->BUILDER_CLOSE_TOOLBAR_HINT = "dies schließen ".$CFG->SITE_TITLE;
$LNG->BUILDER_TITLE_LABEL = "Titel:";
$LNG->BUILDER_EXPLORE_LINK = "Herausfinden";
$LNG->BUILDER_COLLAPSE_TOOLBAR_HINT = "Zusammenbruch ".$CFG->SITE_TITLE." Helfer";
$LNG->BUILDER_ADD_EVIDENCE_PRO_HINT = "Einen neuen  ".$LNG->PRO_NAME." in den ".$CFG->SITE_TITLE." hinzufügen";
$LNG->BUILDER_ADD_EVIDENCE_CON_HINT = "Einen neuen ".$LNG->CON_NAME." in den ".$CFG->SITE_TITLE." hinzufügen";
$LNG->BUILDER_ADD_ISSUE_HINT = "Einen neuen ".$LNG->ISSUE_NAME." in den ".$CFG->SITE_TITLE." hinzufügen";
$LNG->BUILDER_ADD_SOLUTION_HINT = "Einen neuen ".$LNG->SOLUTION_NAME." in den ".$CFG->SITE_TITLE." hinzufügen";

/** BUILDER HELP PAGE **/
$LNG->HELP_BUILDER_TITLE = 'LiteMap Toolbar';
$LNG->HELP_BUILDER_PARA1 = 'Mit Hilfe der LiteMap Toolbar können Sie Daten in die LiteMap eintragen, während Sie im Netz browsen .';
$LNG->HELP_BUILDER_GET_TITLE = 'Wie man die toolbar erhält';
$LNG->HELP_BUILDER_GET_LINK = 'Fügen Sie diesen Link als Lesezeichen hinzu';
$LNG->HELP_BUILDER_USING_FIREFOX = 'Wenn Sie <b>Firefox</b>, <b>Chrome</b> oder <b>Safari</b> verwenden, können Sie den oberhalb angezeigten Link zu Ihrer Favoritenleiste hinzufügen.';
$LNG->HELP_BUILDER_USING_OPERA = 'Wenn Sie <b>Opera</b> verwenden, wählen Sie den oben angezeigten Link, \'Bookmark Link...\' mit einem Rechtsklick aus. Sie können dann \'Lesezeichen in toolbar anzeigen\'auswählen.';
$LNG->HELP_BUILDER_USING_IE = '<b>Nur für IE verwendbar 9+</b>: Ziehen Sie den oben angezeigten Link in Ihre Favoritenleiste. Sie werden eine Sicherheitswarnung erhalten, wählen Sie OK.';
$LNG->HELP_BUILDER_USING_IE_MORE_LINK = 'Mehr Information zu IE 9';
$LNG->HELP_BUILDER_USING_IE_HIDE_LINK = 'Verbergen';
$LNG->HELP_BUILDER_USING_IE_ERROR_TITLE = 'Störende popup Sicherheitsnachricht in IE 9';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART1 = 'Wenn Sie bei der Benutzung unserer Lesezeichenfunktion eine Warnung sehen, die der oberen ähnlich ist, bitte befolgen Sie die Anweisungen:';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 = '1. Im Internet Explorer, Tools auswählen &gt; Internetoptionen.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '2. Wählen Sie das Security Tab aus.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '3. Wählen Sie "Vertrauenswürdige Seiten" aus(der große grüne Haken).<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '4. Klicken Sie den "Stufe anpassen..." button.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '5. In dem "Sicherheitseinstellungen" Dialog, scrollen Sie bis zu dem "Miscellaneous" Bereich.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '6. Finden Sie diese Einstellung: "Websites in einem weniger privilegierten Inhaltsbereich können in diesen Berich navigieren " und wählen Sie "Nicht ermöglichen."<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '7. Klicken Sie OK, um den Dialog zu schließen, dann OK um die Internetoptionen zu schließen.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '8. Starten Sie den Internet Explorer neu.';

$LNG->HELP_BUILDER_GET_TITLE_BOOKMARKLET = 'Als Bookmarklet';
$LNG->HELP_BUILDER_GET_TITLE_EXTENSION = 'Als Browser-Erweiterung';
$LNG->HELP_BUILDER_EXTENSION_CHROME = "Google Chrome Erweiterung";
$LNG->HELP_BUILDER_EXTENSION_FIREFOX = "Firefox Erweiterung";
$LNG->HELP_BUILDER_EXTENSION_SAFARI = "Safari Erweiterung";
$LNG->HELP_BUILDER_EXTENSION_IE = "Internet Explorer Erweiterung";
$LNG->HELP_BUILDER_EXTENSION_MESSAGE = 'Nach der Installation der Erweiterung, die Sie in der Symbolleiste zu aktivieren, indem Sie auf das Symbol litemap die irgendwo in der Adressleiste (Standort variiert zwischen Browser; siehe Abbildungen oben) angezeigt werden sollen.<br>Hinweis: Wenn Ihr Browser nicht nach der Installation der Erweiterung starten Sie werden alle bereits geöffneten Tabs müssen ihren Inhalt erfrischend, bevor der Werkzeugleiste zeigen.';
$LNG->HELP_BUILDER_EXTENSION_MESSAGE2 = '(Weitere in der Entwicklung)';
$LNG->HELP_BUILDER_EXTENSION_SAFARI_MESSAGE = 'Aufgrund Safari Grenzen der Erweiterung Taste wird immer grau sein und nicht über einen Ein / Aus-Zustand als in anderen Browsern zu zeigen. Sie müssen die Rollover- Text zu lesen, um zu sehen, wenn die Symbolleiste ein oder aus. Auch, wenn Sie einen neuen Beitrag über die Popup- Formulare zu erstellen, sobald das Formular schließt die Seite wird nicht automatisch aktualisiert, so dass Sie brauchen, um die Seite manuell aktualisieren, um den neuen Eintrag auf der Website zu sehen.';
$LNG->HELP_BUILDER_EXTENSION_IE_MESSAGE = 'Das IE -Erweiterung muss eine DLL, die es um zu arbeiten installiert laufen. Auf einigen Systemen starken Virus Control Software können die DLL von der Installation zu blockieren. Auf einigen System wie Unternehmen Computer, starke Sicherheitseinstellung kann die DLL an der Ausführung zu blockieren.';

$LNG->HELP_BUILDER_WARNING = "HINWEIS: Aufgrund von Änderungen der Sicherheitseinstellungen von Browsern können nun Websites Bookmarklets, wie z.B. unser Bookmarklet, blockieren, die Inhalte von anderen Webseiten auf deren Seite laden.
							Facebook und Twitter sind zwei Beispiele davon, die diese Richtlinie umgesetzt haben.
							Auf diesen Seiten wird unser Bookmarklet nicht funktionieren. Das Bookmarklet wird dort geblockt und es kann daher der Eindruck enstehen, dass es nicht mehr funktioniert.
							Die meisten Webseiten nutzen diese neue Einstellung nicht und das Bookmarklet wird dort nach wie vor funktionieren.
							Ihr Browser kann auch das Bookmarklet blockieren, so dass Sie Ihren Browser außer Kraft zu setzen Einstellung Mai haben, um es zu arbeiten.
							Wir sind derzeit schriftlich Browser spezifische Erweiterungen, mit diesem Problem zu helfen (siehe unten).";

/** MAIN TAB SCREENS - TABBERLIB **/
$LNG->TAB_ADD_MAP_LINK = $LNG->MAP_NAME.' hinzufügen';
$LNG->TAB_ADD_GROUP_LINK = $LNG->GROUP_NAME.' hinzufügen';
$LNG->TAB_ADD_MAP_HINT = $LNG->MAP_NAME.' hinzufügen';
$LNG->TAB_ADD_GROUP_HINT = $LNG->GROUP_NAME.' hinzufügen';


/** RECENT ACTIVITY EMAIL DIGEST **/
$LNG->RECENT_EMAIL_DIGEST_LABEL = 'Newsletter:';
$LNG->RECENT_EMAIL_DIGEST_REGISTER_MESSAGE = "Klicken Sie, um monatlich einen Newsletter der aktuellen Aktivitäten zu erhalten.";
$LNG->RECENT_EMAIL_DIGEST_PROFILE_MESSAGE = "Entscheiden für/gegen den Erhalt eines monatlichen Newsletter über aktuelle Aktivitäten.";


/** EXPLORE PAGE WIDGETS **/
$LNG->WIDGET_RESIZE_ITEM_ALT = 'Größe des Items verändern';
$LNG->WIDGET_RESIZE_ITEM_HINT = 'Diesen Bereich verändern';
$LNG->WIDGET_EXPAND_HINT = 'Erweitern';
$LNG->WIDGET_ICON_ALT = 'Symbol';
$LNG->WIDGET_OPEN_CLOSE_ALT = 'Item öffnen/ schließen';
$LNG->WIDGET_OPEN_CLOSE_HINT = 'Diesen Bereich öffnen/ schließen';
$LNG->WIDGET_CONTRACT_HINT = 'Unterzeichnen';
$LNG->WIDGET_LOADING = 'Wird geladen';
$LNG->WIDGET_LOAD = 'Wird geladen';
$LNG->WIDGET_LOADING_EVIDENCE = 'wird geladen '.$LNG->ARGUMENTS_NAME.'...';
$LNG->WIDGET_LOADING_RESOURCE = 'Wird geladen in Bezug auf '.$LNG->RESOURCES_NAME.'...';
$LNG->WIDGET_LOADING_FOLLOWERS = 'Wird geladen '.$LNG->FOLLOWERS_NAME.'...';
$LNG->WIDGET_EVIDENCE_ADD_HINT = 'Wählen Sie/erstellen Sie einen Beitrag, um ihn als Beweis gegen den momentan ausgewählten Item hinzuzufügen ';
$LNG->WIDGET_ADD_LINK = 'Hinzufügen';
$LNG->WIDGET_SIGNIN_HINT = 'Loggen Sie sich ein, um eine LiteMap hinzuzufügen';
$LNG->WIDGET_FOLLOW_SIGNIN_HINT = 'Loggen Sie sich ein, um diesem Beitrag zu folgen';
$LNG->WIDGET_NONE_FOUND_PART1 = 'Nein';
$LNG->WIDGET_NONE_FOUND_PART2 = 'bereits hinzugefügt';
$LNG->WIDGET_NONE_FOUND_PART2b = 'aufgelistet';
$LNG->WIDGET_ADD_BUTTON = 'Hinzufügen';
$LNG->WIDGET_FOCUS_NODE_HINT = 'Klicken Sie, um mehr Information zu sehen';
$LNG->WIDGET_CLICK_EXPLORE_HINT = 'Klicken Sie, um alles anzuschauen';
$LNG->WIDGET_CLICK_EXPLORE_HINT2 = 'Zum Anschauen klicken';
$LNG->WIDGET_NO_RESULTS_FOUND = 'Es wurden keine Ergebnisse gefunden';
$LNG->WIDGET_NO_GROUPS_FOUND = 'Es wurden keine '.$LNG->GROUPS_NAME.' gefunden';
$LNG->WIDGET_NO_FOLLOWERS_FOUND = 'Kein '.$LNG->FOLLOWERS_NAME.' gefunden';
$LNG->WIDGET_NEWS_POSTED_ON = 'Gepostet';

/** SEARCH RESULTS PAGE **/
$LNG->SEARCH_TITLE_ERROR = 'Suche nach Ergebnissen';
$LNG->SEARCH_ERROR_EMPTY = 'Sie müssen etwas eingeben, wonach Sie suchen';
$LNG->SEARCH_TITLE = 'Ergebnisse für suchen: ';
$LNG->SEARCH_BACKTOTOP = 'Zurück zum Beginn';
$LNG->SEARCH_BACKTOTOP_IMG_ALT = 'Hoch';


/** INNER TAB PAGE SEARCH **/
$LNG->TAB_SEARCH_MAP_LABEL = 'Suche';
$LNG->TAB_SEARCH_GROUP_LABEL = 'Suche';
$LNG->TAB_SEARCH_CHALLENGE_LABEL = 'Suche';
$LNG->TAB_SEARCH_ISSUE_LABEL = 'Suche';
$LNG->TAB_SEARCH_SOLUTION_LABEL = 'Suche';
$LNG->TAB_SEARCH_CON_LABEL = 'Suche';
$LNG->TAB_SEARCH_PRO_LABEL = 'Suche ';
$LNG->TAB_SEARCH_EVIDENCE_LABEL = 'Suche';
$LNG->TAB_SEARCH_RESOURCE_LABEL = 'Suche';
$LNG->TAB_SEARCH_USER_LABEL = 'Suche';
$LNG->TAB_SEARCH_COMMENT_LABEL = 'Suche';
$LNG->TAB_SEARCH_CHAT_LABEL = 'Suche';
$LNG->TAB_SEARCH_GO_BUTTON = 'Suche starten';
$LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON = 'Suche ausblenden';


/** DEBATE/KNOWLEDGE TREE PAGE **/
$LNG->DEBATE_LOADING = '(Inhalt der Liste wird geladen...)';
$LNG->DEABTES_COUNT_MESSAGE_PART1 = 'Dieser Item ist in enthalten';

$LNG->MAP_NODE_DETAILS_HINT = 'Klicken Sie, um vollständige Details zu diesem Thema zu erhalten';

$LNG->NODE_DEBATE_TOGGLE = 'Die Liste anzeigen/ verbergen';
$LNG->NODE_DEBATE_ADD_TO_MENU_TEXT = 'Hinzufügen';
$LNG->NODE_DEBATE_ADD_TO_PRO_MENU_TEXT = 'Pro-Argument hinzufügen ';
$LNG->NODE_DEBATE_ADD_TO_CON_MENU_TEXT = 'Contra-Argument hinzufügen ';
$LNG->NODE_DEBATE_ADD_TO_SOLUTION_MENU_TEXT = $LNG->SOLUTION_NAME.'hinzufügen ';
$LNG->NODE_DEBATE_ADD_TO_ISSUE_MENU_TEXT = $LNG->ISSUE_NAME.'hinzufügen ';

$LNG->NODE_DEBATE_ADD_TO_MENU_HINT = 'Fügen Sie Ihr Wissen zu diesem Thema hinzu';
$LNG->NODE_DEBATE_TREE_COUNT_HINT = 'Die Themen, die kürzlich zu dieser Liste hinzugefügt wurden';

$LNG->NODE_GOTO_PARENT_HINT = '- Klicken Sie, um dies zu scrollen';


/** CHATS PAGE **/
$LNG->VIEWS_CHAT_TITLE = $LNG->CHATS_NAME;
$LNG->VIEWS_CHAT_HINT = 'Klicken Sie um alle '.$LNG->CHATS_NAME.' zu diesem Thema zu sehen';

$LNG->CHAT_TREE_COUNT_HINT = 'Die Anzahl an hinzugefügten Antworten '.$LNG->CHAT_NAME.' zu diesem Item';
$LNG->CHAT_REPLY_TO_MENU_TEXT = 'Antwort';
$LNG->CHAT_REPLY_TO_MENU_HINT = 'Fügen Sie bezüglich dieses Themas eine Antwort hinzu '.$LNG->CHAT_NAME.' ';
$LNG->CHAT_ADD_BUTTON_TEXT = 'Einen neuen '.$LNG->CHAT_NAME.' starten';
$LNG->CHAT_ADD_BUTTON_HINT = 'Einen neuen '.$LNG->CHAT_NAME.' über das aktuelle zentrale Item starten';
$LNG->CHAT_LOADING = "Lädt ".$LNG->CHATS_NAME."...";
$LNG->NODE_CHAT_BUTTON_TEXT = $LNG->CHATS_NAME;
$LNG->NODE_CHAT_BUTTON_HINT = 'Alle '.$LNG->CHATS_NAME.' zu diesem Item sehen';
$LNG->CHAT_TREE_TOGGLE = 'Antworten anzeigen/ verbergen';
$LNG->NODE_REPLY_ON = 'Hinzugefügt';

$LNG->CHAT_COMMENT_PARENT_TREE = 'Welcher in einem ist '.$LNG->CHAT_NAME.' über:';
$LNG->CHAT_COMMENT_PARENT_FOCUS = 'Dieser Item erscheint in '.$LNG->CHAT_NAME.' über:';
$LNG->NODE_COMMENT_PARENT = 'Verbunden mit:';

$LNG->CHAT_DELETE_CHECK_MESSAGE_PART1 = 'Sind Sie sicher, dass Sie diesen '.$LNG->CHAT_NAME.' Item löschen wollen?: ';
$LNG->CHAT_DELETE_CHECK_MESSAGE_PART2 = '?';

$LNG->CHAT_HIGHLIGHT_NEWEST_TEXT = 'Neueste Antwort';

/** SPAM REPORTING **/
$LNG->SPAM_CONFIRM_MESSAGE_PART1= 'Sind Sie sicher, dass Sie berichten wollen?';
$LNG->SPAM_CONFIRM_MESSAGE_PART2= 'als Spam / Unangemessen?';
$LNG->SPAM_SUCCESS_MESSAGE = 'wurde als Spam aufgefasst';
$LNG->SPAM_REPORTED_TEXT = 'Aufgefasst als Spam';
$LNG->SPAM_REPORTED_HINT = 'Dies wurde als Spam aufgefasst/ Unangemessener Inhalt';
$LNG->SPAM_REPORT_TEXT = 'Als Spam aufgefasst';
$LNG->SPAM_REPORT_HINT = 'Dies als Spam auffassen / Unangemessener Inhalt';
$LNG->SPAM_LOGIN_REPORT_TEXT = 'Loggen Sie sich ein, um dies als Spam zu berichten';
$LNG->SPAM_LOGIN_REPORT_HINT = 'Loggen Sie sich ein, um dies als Spam zu berichten / Unangemessener Inhalt';

/** PRINTING LISTS **/
$LNG->TAB_PRINT_ALT = 'Druck';
$LNG->FOOTER_REPORT_PRINTED_ON = 'Bericht gedruckt auf:';

$LNG->TAB_PRINT_HINT_ISSUE = 'Druck '.$LNG->ISSUES_NAME.' liste';
$LNG->TAB_PRINT_HINT_SOLUTION = 'Druck '.$LNG->SOLUTIONS_NAME.' liste';
$LNG->TAB_PRINT_HINT_PRO = 'Druck '.$LNG->PROS_NAME.' liste';
$LNG->TAB_PRINT_HINT_CON = 'Druck '.$LNG->CONS_NAME.' liste';
$LNG->TAB_PRINT_HINT_COMMENT = 'Druck '.$LNG->COMMENTS_NAME.' liste';
$LNG->TAB_PRINT_HINT_EVIDENCE = 'Druck '.$LNG->ARGUMENTS_NAME.' liste';
$LNG->TAB_PRINT_HINT_MAP = 'Druck '.$LNG->MAPS_NAME.' liste';
$LNG->TAB_PRINT_HINT_RESOURCE = 'Druck '.$LNG->RESOURCES_NAME.' liste';

$LNG->TAB_PRINT_TITLE_ISSUE = 'LiteMap: '.$LNG->ISSUES_NAME.' Liste';
$LNG->TAB_PRINT_TITLE_SOLUTION = 'LiteMap: '.$LNG->SOLUTIONS_NAME.' Liste';
$LNG->TAB_PRINT_TITLE_PRO = 'LiteMap: '.$LNG->PRO_NAME.' Liste';
$LNG->TAB_PRINT_TITLE_CON = 'LiteMap: '.$LNG->CON_NAME.' Liste';
$LNG->TAB_PRINT_TITLE_COMMENT = 'LiteMap: '.$LNG->COMMENTS_NAME.' Liste';
$LNG->TAB_PRINT_TITLE_EVIDENCE = 'LiteMap: '.$LNG->ARGUMENTS_NAME.' Liste';
$LNG->TAB_PRINT_TITLE_MAP = 'LiteMap: '.$LNG->MAPS_NAME.' Liste';
$LNG->TAB_PRINT_TITLE_RESOURCE = 'LiteMap: '.$LNG->RESOURCES_NAME.' Liste';

/** MEDIA MAPPING **/
$LNG->MAP_MEDIA_LABEL = "Medien Url";

$LNG->MAP_MEDIA_IMPORT_YOUTUBE_LABEL = "Oder YouTube-Film";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_BUTTON = "Von YouTube importieren";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_CLEAR = "Entfernen";

$LNG->MAP_MEDIA_IMPORT_VIMEO_LABEL = "Oder Vimeo Movie";
$LNG->MAP_MEDIA_IMPORT_VIMEO_BUTTON = "Von Vimeo importieren";
$LNG->MAP_MEDIA_IMPORT_VIMEO_CLEAR = "Entfernen";

$LNG->MAP_MOVIE_WIDTH_LABEL = "Filmbreite";
$LNG->MAP_MOVIE_HEIGHT_LABEL = "Filmhöhe";

$LNG->MAP_MEDIA_HELP = "Fügen Sie der Karte eine Film- oder Tondateur-URL hinzu. Sie können dann Knoten als Zeiger auf Zeitstempel in diesem Medium kommentieren";
$LNG->MAP_MOVIE_WIDTH_HELP = "Legen Sie die bevorzugte Breite fest, um den Film in der Karte anzuzeigen";
$LNG->MAP_MOVIE_HEIGHT_HELP = "Legen Sie die bevorzugte Höhe fest, um den Film in der Karte anzuzeigen";

$LNG->MAP_MEDIA_IMPORT_YOUTUBE_HELP = "Klicken Sie auf die Schaltfläche \'Von YouTube importieren\', um Ihren YouTube-Film einzuschaden. Die Breite, die Höhe und die Film-ID werden extrahiert und verwendet, um den Film in die Karte zu laden.";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_PROMPT = "Füge deinen YouTube-Film \'Embed\' Code ein:";
$LNG->MAP_MEDIA_IMPORT_VIMEO_HELP = "Klicken Sie auf die Schaltfläche \'Von Vimeo importieren\', um Ihren Vimeo-Film einzuschaden. Die Breite, die Höhe und die Film-ID werden extrahiert und verwendet, um den Film in die Karte zu laden.";
$LNG->MAP_MEDIA_IMPORT_VIMEO_PROMPT = "Füge deinen Vimeo-Film \'Embed\' Code ein:";

$LNG->MAP_MEDIA_NODE_JUMP_HINT = "Springe zur angegebenen Medienindexzeit";
$LNG->MAP_MEDIA_NODE_JUMP = "Springen";
$LNG->MAP_MEDIA_NODE_MEDIAINDEX = "Medienindex: ";
$LNG->MAP_MEDIA_NODE_ASSIGN_HINT = "Zugeordnete Medienindexzeit dem Knoten zuordnen";
$LNG->MAP_MEDIA_NODE_ASSIGN = "Index zuordnen: ";
$LNG->MAP_MEDIA_NODE_REMOVE_HINT = "Entfernen Sie die Medienindexzeit von diesem Knoten";
$LNG->MAP_MEDIA_NODE_REMOVE = "Index entfernen";
$LNG->MAP_MEDIA_MODE_HINT = "Toggle Map Media Replay-Modus: Wenn auf, werden die Knoten nur nach ihrer Medien-Index-Zeit erscheinen.";

// Map Replay
$LNG->MAP_REPLAY_SPEED_UNITS = "ms";
$LNG->MAP_REPLAY_SPEED_UNITS_HINT = "Bitte geben Sie die Wiedergabegeschwindigkeit in Millisekunden größer als Null an";
$LNG->MAP_REPLAY_PLAY_HINT = "Wiederholen Sie die Karte auf der Grundlage von Erstellungsdaten";
$LNG->MAP_REPLAY_PAUSE_HINT = "Pausieren Sie die Kartenwiedergabe";
$LNG->MAP_REPLAY_BACK_HINT = "Zurück in die Wiederholung";
$LNG->MAP_REPLAY_FORWARD_HINT = "Vorwärts bewegen in der Wiedergabe";
$LNG->MAP_REPLAY_SPEED_ERROR  = "Bitte stellen Sie sicher, dass der Geschwindigkeitswert eine gültige Anzahl von Millisekunden größer als Null ist";
$LNG->MAP_REPLAY_MODE_HINT = "Den Kartenwiedergabemodus umschalten: Wenn auf, werden die Knoten nach ihrem Erstellungsdatum sortiert und Sie erhalten Steuerelemente, um die Karte mit einer bestimmten Geschwindigkeit wiederzugeben.";
?>
