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
$LNG->HOMEPAGE_TITLE = 'Welcome To LiteMap';

$LNG->HOMEPAGE_FIRST_PARA = '<b>'.$CFG->SITE_TITLE.'</b> is an online collaborative tool to visually structure and make sense of complex problems. With '.$CFG->SITE_TITLE.' face-to-face and online debates can be mapped visually by building knowledge maps, such as concept, argument and issue maps. These are network maps which are characterised by different semantic data models, and can be used to address different collective sense making needs (such as brainstorming, collaborative discussion and building common understating).';
$LNG->HOMEPAGE_SECOND_PARA_PART2 = '<p>The use of '.$CFG->SITE_TITLE.' can improve face-to-face meetings with facilitated Dialogue Mapping and it can enable blended online-offline participation in collective deliberation processes.</p>';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<p>'.$CFG->SITE_TITLE.' was developed in the context of a recent FP7 Project CATALYST (<a href="http://catalyst-fp7.eu/">http://catalyst-fp7.eu/</a>) on <i>Collective Applied Intelligence and Analytics for Social Innovation</i>. Since its first launch in 2015 '.$CFG->SITE_TITLE.' has been used by over 1300 users, in 10 different countries, by 100 community groups, who built over 500 Maps to confirm an emerging public and education impact.</p>';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<p>'.$CFG->SITE_TITLE.' has so far been used in different domains such as: social innovation, social entrepreneurship, European research, science teaching, and secondary school education. '.$CFG->SITE_TITLE.' has also been the subject of a policy report published by the European Commission on Responsible Research and innovation.';

$LNG->HOMEPAGE_KEEP_READING = 'keep reading';
$LNG->HOMEPAGE_READ_LESS = 'read less';
$LNG->HOMEPAGE_TOOLS_TITLE = 'Tools:';
$LNG->HOMEPAGE_TOOLS_LINK = 'Get LiteMap Toolbar';
$LNG->HOMEPAGE_VIEW_ALL = "View All";
$LNG->HOMEPAGE_NEWS_TITLE = "Recent News";

$LNG->HOMEPAGE_MOST_POPULAR_GROUPS_TITLE = 'Most Popular '.$LNG->GROUPS_NAME;
$LNG->HOMEPAGE_MOST_RECENT_GROUPS_TITLE = 'Newest '.$LNG->GROUPS_NAME;
$LNG->HOMEPAGE_MOST_RECENT_MAPS_TITLE = 'Newest '.$LNG->MAPS_NAME;

$LNG->HOME_MY_GROUPS_TITLE = 'My '.$LNG->GROUPS_NAME;
$LNG->HOME_MY_GROUPS_AREA_LINK = 'View my '.$LNG->GROUPS_NAME.' area';
$LNG->HOME_MY_MAPS_TITLE = 'My '.$LNG->MAPS_NAME;
$LNG->HOME_MY_MAPS_AREA_LINK = 'View my '.$LNG->MAPS_NAME.' area';

/** HELP PAGES **/
$LNG->HELP_NETWORKMAP_TITLE = 'Map Help';
$LNG->HELP_NETWORKMAP_BODY = '<b>Background:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-top:0px;margin-bottom:0px;padding-bottom:0px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Left-click and drag canvas to pan.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Right-click to get a menu to add free-floating nodes to the map. Only available if logged in and you have permissions to edit the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';
$LNG->HELP_NETWORKMAP_BODY .= '<br><b>Links:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<span style="padding-left:10px;">Click on link to see the link menu. Here you can click to go to the author page or, if logged in and you have permissions to edit the map, you can remove the link from the map.</span><br><br>';
$LNG->HELP_NETWORKMAP_BODY .= '<b>Items:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-top:0px;margin-bottom:0px;padding-bottom:0px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">ctrl+left-click on one or more items to select them. Not available on read-only embedded maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">alt+left-click on an item to select a tree of nodes. Not available on read-only embedded maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Left-click</b> and hold mouse down then drag to move around current item and selected nodes</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Right-click a comment node with a picture to view an enlarge version of the picture.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Right-click and drag from one node and drop on another node to link them (assuming they are not already linked and linking rules allow). Only available if logged in and you have permissions to edit the map.<br><b>For Opera only</b> it is ctrl+right-click drag and drop to link nodes.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:0px;">Rollover type icon to see the type name.</li></ul>';

$LNG->HELP_NETWORKMAP_BODY .= '<br><h2>Map Toolbar</h2><img style="width:640px;border-bottom:1px solid gray" src="'.$HUB_FLM->getImagePath('help/maptoolbar.png').'" />';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-bottom:0px;padding-bottom:0px;margin-top:5px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('enlarge2.gif').'">Click to enlarge the mapping area. This removes header and footer areas and map title box and enlarges the mapping area to fill thier space. <img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('reduce.gif').'">Click again to reduce the map back down.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;">Edit Bar: You will only see this option is you have permissions to edit the map and are in an editable view. Click tp open and close the left-hand side edit bar. Here you will find a list of the entries you have created. A place to search all entries and buttons to create new entries. You simply drag and drop entries onto the map. To create a new entry either drag and drop the icons onto the map which will ask you just for the title, or click the icons to get the full \'Add New\' forms.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;">Alert Bar: If alerts have been activate on your site this button will open and close the right-hand side Alert bar area. Here alerts will displayed with recommendations based on the current state of the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-minus.png').'">Click to zoom the map out. You can also scroll the mouse wheel backwards.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-plus.png').'">Click to zoom the map in. You can also scroll the mouse wheel forwards.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-ratio1-1.png').'">Zoom the map to 100% sizing.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-fit.png').'">Zoom the map so all items fit in the visible area.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('printer.png').'">Print the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('info.png').'">Open this help window.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('selectall2.png').'" width="18" height="18">Click to select/deselect all items in the map. Not seen on read-only embeddable maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('search.png').'">Enter text to search on the search box and then press enter or click this icon to search. Any matches will be highlighted in the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('search-clear.png').'">This clears any search text in the search field and clears and item selections in the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('knowledge-tree.png').'">This button allows you to view a readonly linear represenation of the map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:21px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('embed.png').'">This opens a text box from which you can copy the iframe code to embed the current map as an read-only map in another site. Not seen on embeddable maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:32px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('embededit.png').'">This opens a text box from which you can copy the iframe code to embed the current map as an editable map in another site. Not seen on embeddable maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:24px;height:18px;" border="0" src="'.$HUB_FLM->getImagePath('json-ld-data-24.png').'">This opens a text box from which you can copy the url to get the jsonld data for this map. Not seen on embeddable maps.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';

$LNG->HELP_NETWORKMAP_BODY .= '<br><h2>Item Toolbar</h2><img src="'.$HUB_FLM->getImagePath('help/nodetoolbar.png').'" border="0" />';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-bottom:0px;padding-bottom:0px;margin-top:5px;"><li style="margin-bottom:5px;"><b>2:</b> If an item is in more than one map there will be a number as the first item in the toolbar which is a count of how many maps the item is in. In this example it is two, but it could be more. Rollover number to see list of all maps a given item appears in. Click map name to view map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('desc-gray.png').'">Rollover white square icon to see any extra title text and / or description text. Click to open full details window.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('thumb-up-empty.png').'">If you are logged in you can vote for an item by clicking on the thumbs up icon. The number to the right shows how many votes for the item has.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('thumb-down-empty.png').'">If you are logged in you can vote against an item by clicking on the thumbs down icon. The number to the right shows how many votes against the item has.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('edit.png').'">If you are logged in and you are the owner of an item you will see the edit icon. Click this to open the edit form and make changes. It the item appears in multiple map be aware your changes may affect the logic of those maps conversations.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('delete.png').'">If you are logged in you and have permissions to edit the map will see an x menu item. Click this to remove the item from the map. You will be asked if you are sure before the action is completed. Removing an item from the map does not delete it from any other maps or the system.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('link.png').'">Rollover this icon to view associated websites. A small popup will appear listing any urls that have been added to that item. Click those links to visit the sites.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:18px;height:18px;" border="0" src="'.$HUB_FLM->getImagePath('lock-32.png').'" width="18" height="18">If you see a padlock on the toolbar then that means this item is private. You will therefore only see it on your own items that you have made private or on private items in any '.$LNG->GROUP_NAME.' you are in.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:0px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('rightarrowlarge.gif').'">If logged in and have permissions to edit the map, you will see an arrow at the end of the toolbar. This opens the builder menu. Rollover arrow to view the menu. Here you will find options to create/add items to the map and link them.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';

/** IMPORT CIF **/
$LNG->IMPORT_CIF_TITLE = 'Import CIF';
$LNG->IMPORT_CIF_DATA_URL = 'CIF data url:';
$LNG->IMPORT_CIF_DATA_URL_PLACEHOLDER = 'http:// <Url to your CIF formatted data>';
$LNG->IMPORT_CIF_DATA_URL_ERROR = 'Please add your CIf data url';
$LNG->IMPORT_CIF_DATA_URL_INVALID = 'You have not entered a valid data url. Please try again';
$LNG->IMPORT_CIF_LOAD = 'Load and Preview';
$LNG->IMPORT_CIF_CLEAR_LOAD = 'Clear Last Load';
$LNG->IMPORT_CIF_NODES_ONLY = 'Import Nodes Only';
$LNG->IMPORT_CIF_IMPORT_MESSAGE = '<b>'.$LNG->IMPORT_CIF_NODES_ONLY.':</b> Below you can select the nodes you wish to import using the checkboxes in the nodes list. All nodes are selected by default. The nodes will be added to your \'My LiteMap\' data area and appear in your \'Inbox\' on the Map editor bar when editing maps.';
$LNG->IMPORT_CIF_IMPORT_MESSAGE2 = '<b>Import Nodes and Connections:</b> If you are importing nodes and connections, (\''.$LNG->IMPORT_CIF_NODES_ONLY.'\' is NOT selected) you can select the nodes to import on the nodes list or the linear view (first button on map toolbar). All connections between selected nodes will be imported. You will be asked to create a new map to import them into. You can re-arrange the map layout before import in the preview map below.';
$LNG->IMPORT_CIF_NODE_COUNT = 'Node Count:';
$LNG->IMPORT_CIF_CONNECTION_COUNT = 'Connection Count:';
$LNG->IMPORT_CIF_IMPORT = 'Import';
$LNG->IMPORT_CIF_IMPORT_INTO = 'Import Into:';
$LNG->IMPORT_CIF_IMPORT_INTO_HELP = 'Please create a Map to import the nodes and connections into.';
$LNG->IMPORT_CIF_FORMAT_LINK = 'Catalyt interchange Format';
$LNG->IMPORT_CIF_SELECT_ALL = 'Select All';
$LNG->IMPORT_CIF_DESELECT_ALL = 'Deselect All';
$LNG->IMPORT_CIF_PRIVACY_HINT = "If this is set to public all imported nodes will be seen by anyone. If it is set to private only the owner/importer can see them, or if they are imported into a ".$LNG->MAP_NAME." that is in a ".$LNG->GROUP_NAME.", other members of the ".$LNG->GROUP_NAME." can see them.";
$LNG->IMPORT_CIF_LOADING = 'Importing Data';
$LNG->IMPORT_CIF_LIMIT_MESSAGE = 'We currently have a '.$CFG->ImportLimit.' node import limit. You will need to deselect some of your nodes before importing.';
$LNG->IMPORT_CIF_LIMIT_MESSAGE_REACHED = 'You have more than '.$CFG->ImportLimit.' nodes selected. Please deselect some nodes before importing.';
$LNG->IMPORT_CIF_CONDITIONS_MESSAGE = 'We would like to remind you that as a member of this Hub you have agreed to our <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Terms of Use</a>.<br>Before you import this data we would like to draw your attention especially to <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php#section2">Section 2</a>.';

$LNG->USER_HOME_IMPORT_CIF_LINK = 'Import CIF';

/** MAPS **/

$LNG->MAP_EDITOR_INBOX = 'Inbox';
$LNG->MAP_EDITOR_LINK = 'Edit Bar';
$LNG->MAP_EDITOR_LINK_HINT = 'Click to toggle '.$LNG->MAP_EDITOR_LINK.' open and closed';
$LNG->MAP_EDITOR_SEARCH_NO_RESULTS = 'No matching results found';
$LNG->MAP_EDITOR_IN_MAP_HINT = 'Already in Map';
$LNG->MAP_EDITOR_DND_HINT = 'Drag and drop to map canvas';
$LNG->MAP_EDITOR_NEW_NODE_HINT = 'Click to use full add form, drag and drop for quick creation with title only.';

$LNG->MAP_ALERT_LINK = 'Alert Bar';
$LNG->MAP_ALERT_LINK_HINT = 'Click to toggle '.$LNG->MAP_ALERT_LINK.' open and closed';
$LNG->MAP_ALERT_NO_RESULTS = 'There are no Alerts at this time';
$LNG->MAP_ALERT_CLICK_HIGHLIGHT = 'Click to highlight in the Map';
$LNG->MAP_ALERT_SHOW_ALL = 'show all...';
$LNG->MAP_ALERT_SHOW_LESS = 'show less...';

/** TESTING - EMBEDDED MAP SURVEY **/
$LNG->MAP_SURVEY_MESSAGE = 'How useful do you find this map at this stage?';
$LNG->MAP_SURVEY_LINK = 'Give Feedback';
$LNG->MAP_SURVEY_FORM_USFULNESS = 'Usefulness?';
$LNG->MAP_SURVEY_FORM_COMMENT = 'Comment:';
$LNG->MAP_SURVEY_FORM_SELECT = 'Select';
$LNG->MAP_SURVEY_FORM_SELECT_MESSAGE = '(1 = not very useful; 5 = very useful)';
$LNG->MAP_SURVEY_FORM_SELECT_ERROR = 'Please select a usefulness rating.';
$LNG->MAP_SURVEY_FORM_SUBMIT = 'Submit';
$LNG->MAP_SURVEY_FORM_CANCEL = 'Cancel';
$LNG->MAP_SURVEY_THANKS = 'Thank you for your feedback';
$LNG->MAP_ALERT_SURVEY_QUESTION = 'Click if you found this alert useful.';

$LNG->MAP_SELECT_ALL_LABEL = 'Select All';
$LNG->MAP_SELECT_ALL_HINT = 'Select all items in this '.$LNG->MAP_NAME;
$LNG->MAP_DESELECT_ALL_HINT = 'deselect all items in this '.$LNG->MAP_NAME;
$LNG->MAP_CONNECT_TO_SELECTED_LABEL = 'Connect to Selected Item(s)';
$LNG->MAP_CONNECT_TO_SELECTED_HINT = 'Connect this item to all the currently selected item if the relationship is permitted';
$LNG->MAP_CONNECTION_ERROR = 'One or more connections could not be made as they are not allowed';
$LNG->MAP_CONNECTION_ERROR_SINGLE = 'This connection is not allowed. Perhaps reverse the direction?';
$LNG->MAP_CONNECTION_TEST_ERROR = 'NOT ALLOWED';
$LNG->MAP_CHANGE_NODETYPE = 'change';
$LNG->MAP_TITLE_ROLLOVER_CHOICE = 'Rollover Titles';
$LNG->MAP_TITLE_ROLLOVER_CHOICE_HINT = 'Turn on and off having the post titles appear as a rollover hint. This is good for exploring the map when zoomed out, but perhaps annoying when creating a map.';
$LNG->MAP_LINK_TEXT_CHOICE_HINT = 'Turn on and off having the link labels showing in this map';
$LNG->MAP_LINK_CURVE_CHOICE_HINT = 'Turn on and off using curved links in this map';

$LNG->FORM_MAP_ENTER_SUMMARY_ERROR = 'Please enter an '.$LNG->MAP_NAME.' title before trying to save';
$LNG->LOADING_MAPS = '(Loading '.$LNG->MAPS_NAME.'...)';
$LNG->FORM_MAP_LABEL_SUMMARY = $LNG->MAP_NAME." title:";
$LNG->MAP_SUMMARY_FORM_HINT = "(Compulsory) Please add a title for this ".$LNG->MAP_NAME;
$LNG->MAP_DESC_FORM_HINT = "(Optional) Please add a brief description for this ".$LNG->MAP_NAME;
$LNG->MAP_PRIVATE_FORM_HINT = "If the map is public it can be seen and contributed to by anyone. If it is private only the owner can see it an edit it.";
$LNG->MAP_PRIVATE_FORM_HINT_GROUP = "If the map is public it can be seen and contributed to by anyone in the ".$LNG->GROUP_NAME.". If it is private only the owner can see it an edit it.";
$LNG->FORM_MAP_CREATE_ERROR_MESSAGE = 'There was an problem creating the '.$LNG->MAP_NAME.':';
$LNG->FORM_MAP_NOT_FOUND = 'The required '.$LNG->MAP_NAME.' could not be found';
$LNG->FORM_MAP_PRIVACY = 'Public:';
$LNG->MAP_REMOVE_NODE = 'Remove from '.$LNG->MAP_NAME;
$LNG->MAP_REMOVE_NODE_HINT = 'Remove this item from the '.$LNG->MAP_NAME;
$LNG->MAP_REMOVE_NODE_CHECK_PART1 = "Are you sure you want to remove:";
$LNG->MAP_REMOVE_NODE_CHECK_PART2 = "from the '.$LNG->MAP_NAME.'?";
$LNG->MAP_BLOCK_STATS_LINK_HINT = "Click to go to a Dashboard of analytics and visualisations on this ".$LNG->MAP_NAME;
$LNG->MAP_LINKS_TITLE = 'URLs';
$LNG->MAP_VIEW = 'Go to '.$LNG->MAP_NAME;
$LNG->MAP_LINK_DELETE = 'Delete Link';

$LNG->MAP_FORM_ADD_TO_GROUP = 'Add to '.$LNG->GROUP_NAME.':';
$LNG->MAP_FORM_ADD_TO_GROUP_HINT = '(optional) - Add this '.$LNG->MAP_NAME.' to the selected '.$LNG->GROUP_NAME;

$LNG->FORM_MAP_TITLE_EDIT = 'Edit this '.$LNG->MAP_NAME;
$LNG->FORM_MAP_TITLE_ADD = 'Add a '.$LNG->MAP_NAME;
$LNG->FORM_MAP_TITLE_ADD_HINT = 'Select an existing '.$LNG->MAP_NAME.' to reference from this node';

$LNG->BLOCK_STATS_PEOPLE = 'Participants:';
$LNG->BLOCK_STATS_ISSUES = $LNG->SOLUTIONS_NAME.':';
$LNG->BLOCK_STATS_VOTES = $LNG->VOTES_NAME.':';
$LNG->BLOCK_STATS_LINK_HINT = "Click to go to a Dashboard of analytics and visualisations on this ".$LNG->MAP_NAME.".";

$LNG->MAP_CREATE_LOGGED_OUT_OPEN = "to Create a New ".$LNG->MAP_NAME;
$LNG->MAP_CREATE_LOGGED_OUT_REQUEST = "to Create a New ".$LNG->MAP_NAME;
$LNG->MAP_CREATE_LOGGED_OUT_CLOSED = "to Create a New ".$LNG->MAP_NAME;

$LNG->MAP_ADD_LOGGED_OUT_OPEN = "to contribute to this ".$LNG->MAP_NAME;
$LNG->MAP_ADD_LOGGED_OUT_REQUEST = "to contribute to this ".$LNG->MAP_NAME;
$LNG->MAP_ADD_LOGGED_OUT_CLOSED = "to contribute to this ".$LNG->MAP_NAME;

$LNG->MAP_ADD_EXISTING_BUTTON = 'Add to existing '.$LNG->MAP_NAME;

/** GROUPS **/
$LNG->FORM_BUTTON_DELETE_GROUP = 'Delete '.$LNG->GROUP_NAME;
$LNG->FORM_BUTTON_JOIN_GROUP = 'Join '.$LNG->GROUP_NAME;
$LNG->FORM_BUTTON_JOIN_GROUP_CLOSED = 'Request to join '.$LNG->GROUP_NAME;

$LNG->ERROR_GROUP_NOT_FOUND_MESSAGE = "The required Group could not be found";
$LNG->ERROR_GROUP_USER_LAST_ADMIN = "You cannot remove that user as an admin, as then the group will have no admins";
$LNG->ERROR_GROUP_EXISTS_MESSAGE = "A group with this name already exists";
$LNG->ERROR_GROUP_USER_NOT_MEMBER = "The current user is not a member of the required Group.";

$LNG->GROUP_CREATE_TITLE = 'Create New '.$LNG->GROUP_NAME;
$LNG->GROUP_MANAGE_TITLE = 'Manage '.$LNG->GROUPS_NAME;
$LNG->GROUP_MANAGE_SINGLE_TITLE = 'Manage '.$LNG->GROUP_NAME;

$LNG->GROUP_CREATE_LOGGED_OUT_OPEN = "to Create a New ".$LNG->GROUP_NAME;
$LNG->GROUP_CREATE_LOGGED_OUT_REQUEST = "to Create a New ".$LNG->GROUP_NAME;
$LNG->GROUP_CREATE_LOGGED_OUT_CLOSED = "to Create a New ".$LNG->GROUP_NAME;

$LNG->GROUP_MAP_CREATE_BUTTON = 'Create New '.$LNG->MAP_NAME;
$LNG->MAP_GROUP_JOIN_GROUP = " to contribute to this ".$LNG->MAP_NAME;
$LNG->GROUP_JOIN_GROUP = " to Create a New ".$LNG->MAP_NAME;

$LNG->GROUP_PHOTO_FORM_HINT = "(optional) - Please add an image to represent this ".$LNG->GROUP_NAME;
$LNG->GROUP_NAME_FORM_HINT = "(compulsory) - The Name of this ".$LNG->GROUP_NAME;
$LNG->GROUP_DESC_FORM_HINT = "(optional) - A description of the purpose of this ".$LNG->GROUP_NAME;
$LNG->GROUP_WEBSITE_FORM_HINT = "(optional) - Add an associated website for this ".$LNG->GROUP_NAME;

$LNG->GROUP_FORM_NAME = "Name:";
$LNG->GROUP_FORM_DESC = "Description:";
$LNG->GROUP_FORM_WEBSITE = "Website:";
$LNG->GROUP_FORM_MEMBERS_CURRENT = "Current Members:";

$LNG->GROUP_FORM_SELECT = "Select a ".$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NO_MEMBERS = 'This '.$LNG->GROUP_NAME.' has no members.';
$LNG->GROUP_FORM_NO_PENDING = 'This '.$LNG->GROUP_NAME.' has no pending member requests.';
$LNG->GROUP_FORM_MEMBERS_PENDING = "Member Join Requests:";
$LNG->GROUP_FORM_NAME_LABEL = "Name";
$LNG->GROUP_FORM_DESC_LABEL = "Description";
$LNG->GROUP_FORM_ISADMIN_LABEL = "Admin";
$LNG->GROUP_FORM_REMOVE_LABEL = "Remove";
$LNG->GROUP_FORM_APPROVE_LABEL = "Approve";
$LNG->GROUP_FORM_REJECT_LABEL = "Reject";
$LNG->GROUP_FORM_REMOVE_MESSAGE_PART1 = 'Are you sure you want to remove';
$LNG->GROUP_FORM_REMOVE_MESSAGE_PART2 = 'from this '.$LNG->GROUP_NAME.'?';
$LNG->GROUP_FORM_REJECT_MESSAGE_PART1 = 'Are you sure you want to reject';
$LNG->GROUP_FORM_REJECT_MESSAGE_PART2 = 'as a member of this '.$LNG->GROUP_NAME.'?';
$LNG->GROUP_FORM_APPROVE_MESSAGE_PART1 = 'Are you sure you want to approve';
$LNG->GROUP_FORM_APPROVE_MESSAGE_PART2 = 'to be a member of this '.$LNG->GROUP_NAME.'?';
$LNG->GROUP_JOIN_REQUEST_MESSAGE = 'Your request to join this '.$LNG->GROUP_NAME.' has been logged and is waiting to be approved. You will recieve and email when you request has been processed.<br><br>Thank you for your interest in this '.$LNG->GROUP_NAME;
$LNG->GROUP_JOIN_PENDING_MESSAGE = 'Membership Pending';
$LNG->GROUP_MY_ADMIN_GROUPS_TITLE = $LNG->GROUPS_NAME.' I manage:';
$LNG->GROUP_MY_MEMBER_GROUPS_TITLE = $LNG->GROUPS_NAME.' I am a member of:';
$LNG->GROUP_FORM_IS_JOINING_OPEN_LABEL = 'Is '.$LNG->GROUP_NAME.' joining open?';
$LNG->GROUP_FORM_IS_JOINING_OPEN_HELP = 'Select the checkbox if you want people to decide to join the '.$LNG->GROUP_NAME.' themselves.<br>Leave the checkbox unselected if you wish to moderate '.$LNG->GROUP_NAME.' join requests and therefore control who can join the '.$LNG->GROUP_NAME;

$LNG->GROUP_FORM_MEMBERS = "Add Members:<br/>(comma separated)";
$LNG->GROUP_FORM_MEMBERS_HELP = "Please enter the email address of all those people you would like to join this '.$LNG->GROUP_NAME.', all of these people will be sent an email notifying them of the '.$LNG->GROUP_NAME.' membership and any users who don't already have accounts will be invited to join.";
$LNG->GROUP_FORM_NAME_ERROR = 'You must enter a name for the '.$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NOT_GROUP_ADMIN = 'You are not an administrator for this '.$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NOT_GROUP_ADMIN_ANY = 'You are not an administrator for any '.$LNG->GROUPS_NAME;
$LNG->GROUP_FORM_LOCATION = 'Location: (town/city)';
$LNG->GROUP_FORM_PHOTO = 'Photo';
$LNG->GROUP_FORM_PHOTO_HELP = '(minimum size 150px w x 100px h. Larger images will be scaled/cropped to this size)';

$LNG->GROUP_BLOCK_STATS_PEOPLE = 'Members:';
$LNG->GROUP_BLOCK_STATS_ISSUES = $LNG->ISSUES_NAME.':';
$LNG->GROUP_BLOCK_STATS_VOTES = $LNG->VOTES_NAME.':';

$LNG->GROUP_MEMBERS_LABEL = $LNG->GROUP_NAME." Members";
$LNG->LOADING_GROUP_MEMBERS = "Loading ".$LNG->GROUP_NAME." Members";
$LNG->DEBATE_MEMBERS_LABEL = $LNG->ISSUE_NAME." Participants";
$LNG->LOADING_DEBATE_MEMBERS = "Calulating ".$LNG->ISSUE_NAME." Members";
$LNG->GROUP_NO_MEMBERS_MESSAGE = 'This '.$LNG->GROUP_NAME.' has no members.';

/** END GROUP **/

$LNG->DEBATE_IDEA_ID_ERROR = 'The '.$LNG->SOLUTION_NAME.' being edited could not be found.';

$LNG->FORM_ISSUE_LABEL_TITLE = $LNG->ISSUE_NAME." Title...";
$LNG->FORM_ISSUE_LABEL_DESC = $LNG->ISSUE_NAME." Description...";
$LNG->FORM_ISSUE_NEW_TITLE = "Add New ".$LNG->ISSUE_NAME;
$LNG->FORM_EVIDENCE_NEW_TITLE_PRO = "Add New ".$LNG->PRO_NAME_SHORT;
$LNG->FORM_EVIDENCE_NEW_TITLE_CON = "Add New ".$LNG->CON_NAME_SHORT;
$LNG->FORM_SOLUTION_NEW_TITLE = "Add New ".$LNG->SOLUTION_NAME;
$LNG->FORM_ADD_NEW = "Add New";
$LNG->FORM_PRIVACY = 'Public:';
$LNG->FORM_PRIVACY_HINT = "If this item is public it can be seen by anyone. If it is private only the owner can see it, or if the item is in a ".$LNG->GROUP_NAME.", other members of the ".$LNG->GROUP_NAME;

$LNG->FORM_IDEA_LABEL_TITLE = $LNG->SOLUTION_NAME." Title...";
$LNG->FORM_IDEA_LABEL_DESC = $LNG->SOLUTION_NAME." Description...";

$LNG->FORM_BUTTON_SUBMIT = 'Submit';
$LNG->FORM_BUTTON_SAVE = 'Save';

$LNG->NODE_TOGGLE_HINT = 'Click to view/hide futher details';
$LNG->NODE_ADDED_BY = 'Added by:';
$LNG->NODE_CHILDREN_EVIDENCE_PRO = 'For';
$LNG->NODE_CHILDREN_EVIDENCE_CON = 'Against';

$LNG->MAP_IMAGE_LABEL = $LNG->MAP_NAME.' Image:';
$LNG->MAP_BACKGROUND_LABEL = $LNG->MAP_NAME.' Background Image:';
$LNG->MAP_BACKGROUND_REPLACE_LABEL = 'Replace Background Image:';
$LNG->MAP_BACKGROUND_HELP = 'Optionally select a background image to map over. The size of the image will be draw as provided.';
$LNG->MAP_BACKGROUND_DELETE_LABEL = 'Delete Image';
$LNG->BUILTFROM_DIALOG_TITLE=" was Built From:";
$LNG->PAGE_BUTTON_DASHBOARD = 'Dashboard';
$LNG->PAGE_BUTTON_SHARE = 'Share';

$LNG->IDEA_COMMENTS_LINK = $LNG->CHATS_NAME;
$LNG->IDEA_COMMENTS_HINT = 'View and add '.$LNG->CHATS_NAME.' on this '.$LNG->SOLUTION_NAME;
$LNG->IDEA_COMMENTS_CHILDREN_TITLE = $LNG->CHATS_NAME;
$LNG->IDEA_COMMENT_ID_ERROR = $LNG->CHAT_NAME.' object cannot be found to edit';

$LNG->NODE_EDIT_SOLUTION_ICON_HINT = 'Edit this '.$LNG->SOLUTION_NAME;


/** MERGE ISSUES **/
$LNG->FORM_IDEA_MERGE_TITLE = "Merge ".$LNG->SOLUTIONS_NAME;
$LNG->FORM_IDEA_MERGE_LABEL_TITLE = "Merged ".$LNG->SOLUTIONS_NAME." Title...";
$LNG->FORM_IDEA_MERGE_LABEL_DESC = "Merged ".$LNG->SOLUTIONS_NAME." Description...";
$LNG->FORM_IDEA_MERGE_HINT = "Create a new Idea representing the Selected ideas. Connect any Comments and Arguments on the Selected Ideas to this new Idea. Then retire the Selected Ideas.";
$LNG->FORM_IDEA_MERGE_MUST_SELECT = 'You must first select at least 2 ideas to merge.';
$LNG->FORM_IDEA_MERGE_NO_TITLE = "You must enter a title for the new merged ".$LNG->SOLUTION_NAME;


/** SPLIT ISSUE **/
$LNG->FORM_BUTTON_SPLIT = 'Split';
$LNG->FORM_BUTTON_SPLIT_HINT = 'Split this '.$LNG->SOLUTION_NAME.' into two or more '.$LNG->SOLUTIONS_NAME;
$LNG->FORM_REMOVE_MULTI = "Are you sure you want to remove this item? This action cannot be undone!";
$LNG->FORM_SPLIT_IDEA_ERROR = "You must enter a title for the first two ideas";


/** LIST NAV **/
$LNG->LIST_NAV_PREVIOUS_HINT = 'Previous';
$LNG->LIST_NAV_NO_PREVIOUS_HINT = 'No Previous';
$LNG->LIST_NAV_NEXT_HINT = 'Next';
$LNG->LIST_NAV_NO_NEXT_HINT = 'No Next';
$LNG->LIST_NAV_NO_ITEMS = "You haven't added any yet.";
$LNG->LIST_NAV_TO = 'to';
$LNG->LIST_NAV_NO_CON = 'There are no '.$LNG->CONS_NAME.' to display';
$LNG->LIST_NAV_NO_PRO = 'There are no '.$LNG->PROS_NAME.' to display';
$LNG->LIST_NAV_NO_EVIDENCE = 'There are no '.$LNG->ARGUMENT_NAME.' items to display';
$LNG->LIST_NAV_NO_ISSUE = 'There are no '.$LNG->ISSUES_NAME.' to display';
$LNG->LIST_NAV_NO_SOLUTION = 'There are no '.$LNG->SOLUTIONS_NAME.' to display';
$LNG->LIST_NAV_NO_ITEMS = 'There are no items to display';

/** ODD **/
$LNG->POPUPS_BLOCK = 'You appear to have blocked popup windows.\n\n Please alter your browser settings to allow LiteMap to open popup windows.';
$LNG->RESET_INVALID_MESSAGE = 'Invalid password reset code';
$LNG->SIDEBAR_TITLE = "Recently Viewed";
$LNG->INDEX_ALL_DATA = 'All Data';
$LNG->ENTER_URL_FIRST = 'You must enter a url first';


/** LOADING MESSAGES **/
$LNG->LOADING_ITEMS = 'Loading items';
$LNG->LOADING_MESSAGE_PRINT_NODE = 'This may take a minute or so depending on the length of the list you are viewing';
$LNG->LOADING_CHALLENGES = '(Loading '.$LNG->CHALLENGES_NAME.'...)';
$LNG->LOADING_ISSUES = '(Loading '.$LNG->ISSUES_NAME.'...)';
$LNG->LOADING_SOLUTIONS = '(Loading '.$LNG->SOLUTIONS_NAME.'...)';
$LNG->LOADING_PROS = '(Loading '.$LNG->PROS_NAME.'...)';
$LNG->LOADING_CONS = '(Loading '.$LNG->CONS_NAME.'...)';
$LNG->LOADING_EVIDENCES = '(Loading '.$LNG->ARGUMENTS_NAME.'...)';
$LNG->LOADING_RESOURCES = '(Loading '.$LNG->RESOURCES_NAME.'...)';
$LNG->LOADING_DATA = '(Loading data...)';
$LNG->LOADING_COMMENTS = '(Loading '.$LNG->COMMENTS_NAME.'...)';
$LNG->LOADING_CHATS = '(Loading '.$LNG->CHATS_NAME.'...)';
$LNG->LOADING_USERS = '(Loading '.$LNG->USERS_NAME.'...)';
$LNG->LOADING_GROUPS = '(Loading '.$LNG->GROUPS_NAME.'...)';
$LNG->LOADING_MAPS = '(Loading '.$LNG->MAPS_NAME.'...)';
$LNG->LOADING_MAPS = '(Loading '.$LNG->MAPS_NAME.'...)';
$LNG->LOADING_MESSAGE = 'Loading...';

/** TABS **/
//main
$LNG->TAB_HOME = 'Home';
$LNG->TAB_MAP = $LNG->MAPS_NAME;
$LNG->TAB_GROUP = $LNG->GROUPS_NAME;
$LNG->TAB_PRO = $LNG->PROS_NAME;
$LNG->TAB_CON = $LNG->CONS_NAME;

//explore
$LNG->VIEWS_LINEAR_TITLE = "Knowledge Trees";
$LNG->VIEWS_LINEAR_HINT = "Click to view any Knowledge Trees for this item";
$LNG->VIEWS_WIDGET_TITLE = "Full Details";
$LNG->WIDGET = "Click to view any Knowledge Trees for this item";
$LNG->VIEWS_EVIDENCE_MAP_TITLE="Network Graph";
$LNG->VIEWS_EVIDENCE_MAP_HINT="Click to view the Network Graph for this item";

/** ERROR MESSAGES */
$LNG->DATABASE_CONNECTION_ERROR = 'Could not connect to database - please check the server configuration.';
$LNG->ITEM_NOT_FOUND_ERROR = 'Item not found';

/** BUTTONS AND LINK HINTS **/
$LNG->SIGN_IN_HINT = 'Sign In to add to LiteMap';
$LNG->SIGN_IN_FOLLOW_HINT = 'Sign In to follow this entry';

$LNG->ADD_BUTTON = 'Add';
$LNG->FOLLOW_BUTTON_ALT = 'Follow';
$LNG->FOLLOW_OFF_BUTTON_ALT = 'Follow off';

$LNG->EDIT_BUTTON_TEXT = 'Edit';
$LNG->EDIT_BUTTON_HINT_ITEM = 'Edit this item';
$LNG->EDIT_BUTTON_HINT_CHALLENGE = 'Edit this '.$LNG->CHALLENGE_NAME;
$LNG->EDIT_BUTTON_HINT_ISSUE = 'Edit this '.$LNG->ISSUE_NAME;
$LNG->EDIT_BUTTON_HINT_SOLUTION = 'Edit this '.$LNG->SOLUTION_NAME;
$LNG->EDIT_BUTTON_HINT_EVIDENCE = 'Edit this '.$LNG->ARGUMENT_NAME;
$LNG->EDIT_BUTTON_HINT_COMMENT = 'Edit this '.$LNG->COMMENT_NAME;

$LNG->DELETE_BUTTON_ALT = 'Delete';
$LNG->DELETE_BUTTON_HINT = 'Delete this item';
$LNG->NO_DELETE_BUTTON_ALT = 'Delete unavailable';
$LNG->NO_DELETE_BUTTON_HINT = 'You cannot delete this item. Someone else has connected to it';


/** FILTERS AND SORTS **/
$LNG->FILTER_BY = 'Filter by';
$LNG->FILTER_TYPES_ALL = 'All Types';

$LNG->SORT = 'Sort';
$LNG->SORT_BY = 'Sort by';
$LNG->SORT_ASC = 'Ascending';
$LNG->SORT_DESC = 'Descending';
$LNG->SORT_CREATIONDATE = 'Creation Date';
$LNG->SORT_MODDATE = 'Modification Date';
$LNG->SORT_TITLE = 'Title';
$LNG->SORT_URL = 'Website';
$LNG->SORT_NAME = 'Name';
$LNG->SORT_MEMBERS = 'Member Count';
$LNG->SORT_CONNECTIONS = 'Connections';
$LNG->SORT_VOTES = 'Votes';
$LNG->SORT_LAST_LOGIN = 'Last Sign In';
$LNG->SORT_DATE_JOINED = 'Date Joined';

$LNG->ALL_ITEMS_FILTER = "All Items";
$LNG->CONNECTED_ITEMS_FILTER = "Connected Items";
$LNG->UNCONNECTED_ITEMS_FILTER = "Unconnected Items";

/** EXPLORE SECTION TITLES **/
$LNG->EXPLORE_challengeToFollower = $LNG->FOLLOWERS_NAME.' of this '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_issueToFollower = $LNG->FOLLOWERS_NAME.' of this '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_solutionToFollower = $LNG->FOLLOWERS_NAME.' of this '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_solutionToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_evidenceToFollower = $LNG->FOLLOWERS_NAME.' of this '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_evidenceToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_proToFollower = $LNG->FOLLOWERS_NAME.' of this '.$LNG->PRO_NAME;
$LNG->EXPLORE_proToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_conToFollower = $LNG->FOLLOWERS_NAME.' of this '.$LNG->CON_NAME;
$LNG->EXPLORE_conToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_commentToFollower = $LNG->FOLLOWERS_NAME.' of this '.$LNG->COMMENT_NAME;
$LNG->EXPLORE_commentToMap = $LNG->MAPS_NAME;


/** EXPLORE BUTTONS,LINKS AND HINTS **/
$LNG->EXPLORE_PRINT_BUTTON_ALT = "Print this item";
$LNG->EXPLORE_PRINT_BUTTON_HINT = "Print this item";

$LNG->EXPLORE_BACKTOTOP = 'back to top';
$LNG->EXPLORE_BACKTOTOP_IMG_ALT = 'Up';

$LNG->EXPLORE_SUPPORTING_EVIDENCE = 'Supporting '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_COUNTER_EVIDENCE = 'Counter '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_ISSUES_ADDRESSED = $LNG->ISSUES_NAME.' addressed';
$LNG->EXPLORE_CHALLENGES_ADDRESSED = $LNG->CHALLENGES_NAME.' addressed';
$LNG->EXPLORE_SOLUTIONS_SPECIFIED = $LNG->SOLUTIONS_NAME.' specified';
$LNG->EXPLORE_EVIDENCE_SPECIFIED = $LNG->ARGUMENTS_NAME.' specified';

$LNG->HOME_ADDITIONAL_INFO_TOGGLE_HINT = 'Click to view/hide additional information';

$LNG->CONDITIONS_REGISTER_FORM_TITLE = 'Terms and Conditions of use';
$LNG->CONDITIONS_REGISTER_FORM_MESSAGE = 'By registering to be a member of this Hub you agree to the Terms and Conditions of this Hub as written in our <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Terms of Use</a>.';
$LNG->CONDITIONS_AGREE_FORM_REGISTER_MESSAGE = 'I agree to the terms and conditions of use of this Hub';
$LNG->CONDITIONS_AGREE_FAILED_MESSAGE = 'You must agree to the terms and conditions of use of this Hub before you can register.';
$LNG->CONDITIONS_LOGIN_FORM_MESSAGE = 'If registering to be a member of this Hub you agree to the Terms and Conditions of this Hub as written in our <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Terms of Use</a>.';

$LNG->FORM_HEADER_MESSAGE = "Please be aware that all data you enter here will be publically viewable on this site by other users, unless you uncheck the \'Public\' option.";
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1 = '(fields with a';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2 = 'are compulsory';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART3 = ', unless they are in an optional subsection which you are not completing)';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART4 = '.)';
$LNG->FORM_RESOURCE_ADD_ANOTHER = 'add another '.$LNG->RESOURCE_NAME;
$LNG->FORM_ADD_ANOTHER = 'add another';
$LNG->RESOURCES_TITLE_FORM_HINT = '(compulsory) - Enter a title for the web resource. If you do not complete the title, the url will be used.<br><br>You can use the arrow button at the end of the URL field to try and fetch the title from the website page automatically if you wish.';
$LNG->RESOURCES_URL_FORM_HINT = '(compulsory) - Enter the url of the web resource';
$LNG->RESOURCES_REMOTE_FORM_HINT = '(optional) - Enter any '.$LNG->RESOURCES_NAME.' supporting this item. The url of the site you are currently on should have been automatically entered for you, as well as any selected text.';
$LNG->RESOURCES_FORM_HINT  = '(optional) - Please add any supporting '.$LNG->RESOURCES_NAME.' you feel will be useful to people viewing this item.';

$LNG->FORM_REQUIRED_FIELDS = 'indicates required field';
$LNG->FORM_LABEL_SUMMARY = 'Summary:';
$LNG->FORM_LABEL_DESC = 'Description:';
$LNG->FORM_LABEL_TYPE = 'Type:';
$LNG->FORM_LABEL_EVIDENCE_TYPE = $LNG->ARGUMENT_NAME.' Type:';
$LNG->FORM_LABEL_EVIDENCE_RESOURCES = $LNG->ARGUMENT_NAME.' '.$LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_URL = 'Url:';
$LNG->FORM_LABEL_TITLE = 'Title:';
$LNG->FORM_LABEL_NAME = 'Name:';
$LNG->FORM_LABEL_PROJECT_STARTED_DATE = 'Started on:';
$LNG->FORM_LABEL_PROJECT_ENDED_DATE = 'Ended on:';
$LNG->FORM_LABEL_LOCATION = 'Location';
$LNG->FORM_LABEL_ADDRESS1 = 'Address 1:';
$LNG->FORM_LABEL_ADDRESS2 = 'Address 2:';
$LNG->FORM_LABEL_TOWN = 'Town/City:';
$LNG->FORM_LABEL_POSTAL_CODE = 'Postal Code:';
$LNG->FORM_LABEL_COUNTRY = 'Country:';
$LNG->FORM_LABEL_COUNTRY_CHOICE = 'Country...';
$LNG->FORM_LABEL_CHALLENGES_TOGGLE = 'Show/Hide '.$LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_CHALLENGES = $LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_RESOURCES = $LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_CLIP = 'Clip:';
$LNG->FORM_LABEL_CLIPS = 'Clips:';

$LNG->FORM_DESC_PLAIN_TEXT_LINK = 'Plain text';
$LNG->FORM_DESC_PLAIN_TEXT_HINT = 'Switch to a plain text. Formatting will be lost.';
$LNG->FORM_DESC_HTML_TEXT_LINK = 'Formatting';
$LNG->FORM_DESC_HTML_TEXT_HINT = 'Show formatting toolbar.';
$LNG->FORM_DESC_HTML_SWITCH_WARNING = 'Are you sure you want to switch to plain text? Warning: All Formatting will be lost.';

$LNG->FORM_AUTOCOMPLETE_TITLE_HINT = 'Try and fetch the website title from the website page data';
$LNG->FORM_SELECT_RESOURCE_HINT = 'Select/create a '.$LNG->RESOURCE_NAME.' to support this';

$LNG->FORM_BUTTON_REMOVE = 'remove';
$LNG->FORM_BUTTON_REMOVE_CAP = 'Remove';
$LNG->FORM_BUTTON_SELECT_ANOTHER = 'Select Another';
$LNG->FORM_BUTTON_ADD_ANOTHER = 'add another';
$LNG->FORM_BUTTON_CHANGE = 'change';
$LNG->FORM_BUTTON_ADD = 'Add';
$LNG->FORM_BUTTON_ADD_NEW = 'Add New';
$LNG->FORM_BUTTON_PUBLISH = 'Publish';
$LNG->FORM_BUTTON_CANCEL = 'Cancel';
$LNG->FORM_BUTTON_CLOSE = 'Close';
$LNG->FORM_BUTTON_CONTINUE = 'Continue';
$LNG->FORM_BUTTON_NEXT = 'Next   >';
$LNG->FORM_BUTTON_BACK = '<   Back';
$LNG->FORM_BUTTON_SKIP = 'Skip   >';
$LNG->FORM_BUTTON_PRINT_PAGE = 'Print Page';

$LNG->FORM_ERROR_NOT_ADMIN = 'You do not have permissions to view this page';
$LNG->FORM_ERROR_MESSAGE = 'The following problems were found, please try again';
$LNG->FORM_ERROR_MESSAGE_LOGIN = 'The following issues were found with your sign in attempt:';
$LNG->FORM_ERROR_MESSAGE_REGISTRATION = 'The following problems were found with your registration, please try again:';
$LNG->FORM_ERROR_NOT_ADMIN = "Sorry you need to be an administrator to access this page";
$LNG->FORM_ERROR_PASSWORD_MISMATCH = "The password and password confirmation don't match. Please try again.";
$LNG->FORM_ERROR_PASSWORD_MISSING = "Please enter a password.";
$LNG->FORM_ERROR_NAME_MISSING = 'Please enter your full name.';
$LNG->FORM_ERROR_INTEREST_MISSING = "Please enter your interest in having an account with us.";
$LNG->FORM_ERROR_URL_INVALID = "Please enter a valid URL (including 'http://').";
$LNG->FORM_ERROR_EMAIL_INVALID = "Please enter a valid email address.";
$LNG->FORM_ERROR_EMAIL_USED = "This email address is already in use, please either Sign In or select a different email address.";
$LNG->FORM_ERROR_CAPTCHA_INVALID = "The reCAPTCHA wasn't entered correctly. Please try it again.";

$LNG->FORM_TITLE_CURRENT_ITEM = 'The current Item';

//Selector
$LNG->FORM_SELECTOR_TITLE_DEFAULT = 'Select an item';
$LNG->FORM_SELECTOR_TITLE_CHALLENGE = 'Select a '.$LNG->CHALLENGE_NAME;
$LNG->FORM_SELECTOR_TITLE_RESOURCE = 'Select a '.$LNG->RESOURCE_NAME;
$LNG->FORM_SELECTOR_TITLE_EVIDENCE = 'Select a piece of '.$LNG->ARGUMENT_NAME;
$LNG->FORM_SELECTOR_TITLE_ISSUE = 'Select an '.$LNG->ISSUE_NAME;
$LNG->FORM_SELECTOR_TITLE_SOLUTION = 'Select a '.$LNG->SOLUTION_NAME;
$LNG->FORM_SELECTOR_TITLE_COMMENT = 'Select a '.$LNG->COMMENT_NAME;

$LNG->FORM_SELECTOR_SEARCH_ERROR = 'There was an error retreiving your search from the server';
$LNG->FORM_SELECTOR_NOT_ITEMS = 'You have not created any items of the required type';
$LNG->FORM_SELECTOR_SEARCH_LABEL = 'Search';
$LNG->FORM_SELECTOR_SEARCH_MESSAGE = '( Leave empty and run to list all )';
$LNG->FORM_SELECTOR_SEARCH_EMPTY_MESSAGE = 'Run a search to see results listed here.';
$LNG->FORM_SELECTOR_TAB_MINE = 'Mine';
$LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS = 'Search Results';

//Challenge
$LNG->FORM_TITLE_CHALLENGE_ADD = 'Add a '.$LNG->CHALLENGE_NAME;
$LNG->FORM_TITLE_CHALLENGE_CONNECT = 'Select '.$LNG->CHALLENGES_NAME.' and connect them to';
$LNG->FORM_TITLE_CHALLENGE_EDIT = 'Edit this '.$LNG->CHALLENGE_NAME;
$LNG->FORM_LABEL_CHALLENGE_SUMMARY = 'Summary';
$LNG->FORM_MESSAGE_CHALLENGE = 'Add a '.$LNG->CHALLENGE_NAME.' you think the community has to tackle.';
$LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR = 'Please enter a '.$LNG->CHALLENGE_NAME.' before trying to publish';
$LNG->FORM_CHALLENGE_NOT_FOUND = 'The required '.$LNG->CHALLENGE_NAME.' could not be found';

//Issue
$LNG->FORM_ISSUE_TITLE_SECTION = 'Create/Select an '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_CONNECT = $LNG->FORM_ISSUE_TITLE_SECTION.' and connect it to ';
$LNG->FORM_ISSUE_TITLE_ADD = 'Add an '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_SECTION_QUICK = 'Quick create an '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_EDIT = 'Edit this '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR = 'Please enter an '.$LNG->ISSUE_NAME.' summary before trying to publish';
$LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE = 'There was an problem creating the '.$LNG->ISSUE_NAME.':';
$LNG->FORM_ISSUE_HEADING_MESSAGE = 'Add a question you are investigating or a '.$LNG->ISSUE_NAME.' you think the community has to tackle.';
$LNG->FORM_ISSUE_LABEL_SUMMARY = $LNG->ISSUE_NAME.' Summary:';
$LNG->FORM_ISSUE_NOT_FOUND = 'The required '.$LNG->ISSUE_NAME.' could not be found';
$LNG->FORM_ISSUE_SELECT_EXISTING = 'Select Existing '.$LNG->ISSUE_NAME;

// Solution
$LNG->FORM_SOLUTION_TITLE_SECTION = 'Create/Select an '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_CONNECT = $LNG->FORM_SOLUTION_TITLE_SECTION.' and connect it to ';
$LNG->FORM_SOLUTION_TITLE_ADD = 'Add an '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_SECTION_QUICK = 'Quick create a '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_EDIT = 'Edit this '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_LABEL_SUMMARY = $LNG->SOLUTION_NAME_SHORT.' Summary:';
$LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR = 'Please enter a '.$LNG->SOLUTION_NAME.' before trying to publish';
$LNG->FORM_SOLUTION_CREATE_ERROR_MESSAGE = 'There was an problem creating the '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_NOT_FOUND = 'The required '.$LNG->SOLUTION_NAME.' could not be found';
$LNG->FORM_SOLUTION_SELECT_EXISTING = 'Select Existing '.$LNG->SOLUTION_NAME_SHORT;
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE1 = 'If you wish to add a '.$LNG->RESOURCE_NAME.' to this '.$LNG->SOLUTION_NAME.' is must be using an '.$LNG->ARGUMENT_NAME.' item.';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE2 = 'To add an '.$LNG->ARGUMENT_NAME.' try to answer the following question';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE3 = 'Why does this '.$LNG->RESOURCE_NAME.' supports this '.$LNG->SOLUTION_NAME.'? What is the '.$LNG->ARGUMENT_NAME.' in this '.$LNG->RESOURCE_NAME.' that made you want to add this '.$LNG->SOLUTION_NAME.'?';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE4 = 'Please add an explanation below in the "Supporting '.$LNG->ARGUMENT_NAME.'" and "Description" fields.';

// Evidence
$LNG->FORM_EVIDENCE_LABEL_SUMMARY = $LNG->ARGUMENT_NAME." Summary:";
$LNG->FORM_EVIDENCE_TITLE_SECTION = 'Create/Select a piece of ';
$LNG->FORM_EVIDENCE_TITLE_SECTION_SUPPORTING = 'Supporting';
$LNG->FORM_EVIDENCE_TITLE_SECTION_COUNTER = 'Counter';
$LNG->FORM_EVIDENCE_TITLE_CONNECT = ' and connect it to ';
$LNG->FORM_EVIDENCE_TITLE_ADD = 'Add '.$LNG->ARGUMENT_NAME;
$LNG->FORM_EVIDENCE_PRO_TITLE_ADD = 'Add '.$LNG->PRO_NAME;
$LNG->FORM_EVIDENCE_CON_TITLE_ADD = 'Add '.$LNG->CON_NAME;
$LNG->FORM_EVIDENCE_TITLE_EDIT = 'Edit '.$LNG->ARGUMENT_NAME;
$LNG->FORM_EVIDENCE_PRO_TITLE_EDIT = 'Edit '.$LNG->PRO_NAME;
$LNG->FORM_EVIDENCE_CON_TITLE_EDIT = 'Edit '.$LNG->CON_NAME;
$LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR = 'Please enter a summary of the '.$LNG->ARGUMENT_NAME.' before trying to publish';
$LNG->FORM_EVIDENCE_SELECT_EXISTING = 'Select Existing '.$LNG->ARGUMENT_NAME;
$LNG->FORM_EVIDENCE_ALREADY_EXISTS = 'You already have a item with that summary and type. Please change one or the other.';
$LNG->FORM_EVIDENCE_NOT_FOUND = 'The required '.$LNG->ARGUMENT_NAME.' item could not be found';
$LNG->FORM_SUPPORTING_EVIDENCE_LABEL = 'Supporting '.$LNG->ARGUMENT_NAME;

// Pro
$LNG->FORM_PRO_TITLE_SECTION = 'Create/Select a '.$LNG->PRO_NAME;
$LNG->FORM_PRO_TITLE_SECTION_QUICK = 'Quick create a '.$LNG->PRO_NAME;
$LNG->FORM_PRO_TITLE_ADD = 'Add '.$LNG->PRO_NAME;

// Con
$LNG->FORM_CON_TITLE_SECTION = 'Create/Select a '.$LNG->CON_NAME;
$LNG->FORM_CON_TITLE_ADD = 'Add '.$LNG->CON_NAME;
$LNG->FORM_CON_TITLE_SECTION_QUICK = 'Quick create a '.$LNG->CON_NAME;

// Argument
$LNG->FORM_ARGUMENT_TITLE_SECTION = 'Create/Select a '.$LNG->ARGUMENT_NAME;
$LNG->FORM_ARGUMENT_TITLE_ADD = 'Add '.$LNG->ARGUMENT_NAME;
$LNG->FORM_ARGUMENT_TITLE_SECTION_QUICK = 'Quick create an '.$LNG->ARGUMENT_NAME;

// Idea
$LNG->FORM_COMMENT_TITLE_SECTION = 'Create/Select an '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_TITLE_ADD = 'Add '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_TITLE_SECTION_QUICK = 'Quick create an '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR = 'Please enter a '.$LNG->COMMENT_NAME_SHORT.' before trying to publish';

// Map
$LNG->FORM_MAP_TITLE_SECTION = 'Create/Select a '.$LNG->MAP_NAME;
$LNG->FORM_MAP_TITLE_ADD = 'Add a '.$LNG->MAP_NAME;

$LNG->FORM_ADD_QUICK = 'Quick Add New:';

/** FORM ROLLOVER HINTS **/
//Challenge
$LNG->CHALLENGE_SUMMARY_FORM_HINT = '(compulsory) - Enter a new '.$LNG->CHALLENGE_NAME.' summary. This will form the '.$LNG->CHALLENGE_NAME.' title displayed in lists.';
$LNG->CHALLENGE_DESC_FORM_HINT ='(optional) - Enter a longer description of the '.$LNG->CHALLENGE_NAME;
$LNG->CHALLENGE_REASON_FORM_HINT = 'Describe why you think this '.$LNG->CHALLENGE_NAME.' is relevant to: ';
$LNG->CHALLENGES_FORM_HINT = 'Select the '.$LNG->CHALLENGES_NAME.' that you wish to relate to: ';

// Issues
$LNG->ISSUE_SUMMARY_FORM_HINT = '(compulsory) - Enter a new '.$LNG->ISSUE_NAME.' summary. This will form the '.$LNG->ISSUE_NAME.' title displayed in lists.';
$LNG->ISSUE_DESC_FORM_HINT = '(optional) - Enter a longer description of the '.$LNG->ISSUE_NAME;
$LNG->ISSUE_CHALLENGES_FORM_HINT = '(optional) - Select one or more '.$LNG->CHALLENGES_NAME.' that this '.$LNG->ISSUE_NAME.' relates to.';
$LNG->ISSUE_REASON_FORM_HINT = '(optional) - Describe why you think this '.$LNG->ISSUE_NAME.' is relevant to: ';
$LNG->ISSUE_OTHERCHALLENGE_FORM_HINT = '(optional) - Select any other '.$LNG->CHALLENGES_NAME.' that you want to relate to this '.$LNG->ISSUE_NAME;
$LNG->ISSUE_RESOURCE_FORM_HINT = '(optional) - Add any Publications, website, or images etc.. that form part of or support this '.$LNG->ISSUE_NAME.'. You can enter more than one.';

// Solutions
$LNG->SOLUTION_SUMMARY_FORM_HINT = '(compulsory) - Enter a new '.$LNG->SOLUTION_NAME.' summary. This will form the item title.';
$LNG->SOLUTION_PRO_FORM_HINT = 'Enter a piece of supporting evidence for the above '.$LNG->SOLUTION_NAME.'. Add a summary of the evidence, and then if desired a fuller description and/or a url for a website that contributes to/is the evidence.';
$LNG->SOLUTION_CON_FORM_HINT = 'Enter a piece of opposing evidence for the above '.$LNG->SOLUTION_NAME.'.  Add a summary of the evidence, and then if desired a fuller description and/or a url for a website that contributes to/is the evidence.';
$LNG->SOLUTION_DESC_FORM_HINT = '(optional) - Enter a longer description of the '.$LNG->SOLUTION_NAME;
$LNG->SOLUTION_REASON_FORM_HINT = '(optional) - Describe why you think this '.$LNG->SOLUTION_NAME.' is relevant to: ';

// Evidence
$LNG->EVIDENCE_SUMMARY_FORM_HINT = '(compulsory) - Enter a summary of the '.$LNG->ARGUMENT_NAME.'. This will be the '.$LNG->ARGUMENT_NAME.' title displayed in lists.';
$LNG->EVIDENCE_DESC_FORM_HINT = '(optional) - Enter a longer description of the '.$LNG->ARGUMENT_NAME;
$LNG->EVIDENCE_WEBSITE_FORM_HINT = '(optional) - Add any Publications, website, or images etc.. that form part of or support this '.$LNG->ARGUMENT_NAME.'. You can enter more than one.';
$LNG->EVIDENCE_TYPE_FORM_HINT = '(compulsory) - Select what sort of '.$LNG->ARGUMENT_NAME.' you wish to submit - the default is '.$CFG->EVIDENCE_TYPES_DEFAULT.', but if you can be more specific that would be helpful.';
$LNG->EVIDENCE_REASON_FORM_HINT = '(optional) - Describe why you think this '.$LNG->ARGUMENT_NAME.' is relevant to: ';

//Comment
$LNG->COMMENT_SUMMARY_FORM_HINT = '(compulsory) - Enter the '.$LNG->COMMENT_NAME.' title.';
$LNG->COMMENT_DESC_FORM_HINT = '(optional) - Enter a longer description of the '.$LNG->COMMENT_NAME;
$LNG->COMMENT_IMAGE_HINT = 'Right click image to enlarge.';

//Remote Forms
$LNG->REMOTE_EVIDENCE_SOLUTION_FORM_HINT = 'Enter your supporting '.$LNG->ARGUMENT_NAME.' for the '.$LNG->SOLUTION_NAME.'.  Add a summary of the '.$LNG->ARGUMENT_NAME.', and then if desired a fuller description.';
$LNG->REMOTE_EVIDENCE_DESC_FORM_HINT = 'Enter a longer description of the '.$LNG->ARGUMENT_NAME.' (optional)';
$LNG->REMOTE_EVIDENCE_TYPE_FORM_HINT = 'Select what sort of '.$LNG->ARGUMENT_NAME.' you wish to submit - the default is '.$CFG->EVIDENCE_TYPES_DEFAULT.', but if you can be more specific that would be helpful.';


/*** NODE LISTINGS AND ITEMS ***/
$LNG->NODE_DETAIL_BUTTON_TEXT = 'Full Details';
$LNG->NODE_DETAIL_BUTTON_HINT = 'Go to full information on this item.';
$LNG->NODE_DETAIL_MENU_TEXT = 'Full Details';

$LNG->NODE_TYPE_ICON_HINT = 'View original image';
$LNG->NODE_EXPLORE_BUTTON_TEXT = 'Explore >>';
$LNG->NODE_EXPLORE_BUTTON_HINT = 'Click to show/hide where you can go and see more information and activities around this item';
$LNG->NODE_DISCONNECT_MENU_TEXT = 'Disconnect';
$LNG->NODE_DISCONNECT_MENU_HINT = 'Disconnect this from the current focal item';
$LNG->NODE_DISCONNECT_LINK_TEXT = 'Remove';
$LNG->NODE_DISCONNECT_LINK_HINT = 'Disconnect this from the current focal item';
$LNG->NODE_VIEW_CONNECTOR_MENU_TEXT = "Who connected it?";
$LNG->NODE_VIEW_CONNECTOR_MENU_HINT = "Go to the connectors Home Page: ";

//in widget list

$LNG->NODE_EDIT_ICON_ALT = 'Edit';
$LNG->NODE_EDIT_CHALLENGE_ICON_HINT = 'Edit this '.$LNG->CHALLENGE_NAME;
$LNG->NODE_EDIT_ISSUE_ICON_HINT = 'Edit this '.$LNG->ISSUE_NAME;
$LNG->NODE_EDIT_EVIDENCE_ICON_HINT = 'Edit this '.$LNG->ARGUMENT_NAME;

$LNG->NODE_DELETE_ICON_ALT = 'Delete';
$LNG->NODE_DELETE_ICON_HINT = 'Delete this item';
$LNG->NODE_NO_DELETE_ICON_ALT = 'Delete unavailable';
$LNG->NODE_NO_DELETE_ICON_HINT = 'You cannot delete this item. Someone else has connected to it';
$LNG->NODE_SUPPORTING_EVIDENCE_LINK = 'Supporting '.$LNG->ARGUMENT_NAME;
$LNG->NODE_ADD_SUPPORTING_EVIDENCE_HINT = 'Add Supporting '.$LNG->ARGUMENT_NAME;
$LNG->NODE_COUNTER_EVIDENCE_LINK = 'Counter '.$LNG->ARGUMENT_NAME;
$LNG->NODE_ADD_COUNTER_EVIDENCE_HINT = 'Add Counter '.$LNG->ARGUMENT_NAME;

$LNG->NODE_VOTE_FOR_ICON_ALT = 'Voting For';
$LNG->NODE_VOTE_AGAINST_ICON_ALT = 'Voting Against';
$LNG->NODE_VOTE_REMOVE_HINT = 'Unset...';
$LNG->NODE_VOTE_FOR_ADD_HINT = 'Promote this...';
$LNG->NODE_VOTE_FOR_SOLUTION_HINT = 'Strong '.$LNG->SOLUTION_NAME.' for this';
$LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT = 'Convincing '.$LNG->ARGUMENT_NAME.' for this';
$LNG->NODE_VOTE_AGAINST_ADD_HINT = 'Demote this...';
$LNG->NODE_VOTE_AGAINST_SOLUTION_HINT = 'Weak '.$LNG->SOLUTION_NAME.' for this';
$LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT = 'Unconvincing '.$LNG->ARGUMENT_NAME.' for this';
$LNG->NODE_VOTE_FOR_LOGIN_HINT = 'Sign In to Promote this';
$LNG->NODE_VOTE_AGAINST_LOGIN_HINT = 'Sign In to Demote this';
$LNG->NODE_VOTE_MENU_TEXT = 'Vote:';
$LNG->NODE_VOTE_OWN_HINT = 'You cannot vote on your own items';

$LNG->NODE_VOTE_FOR_TITLE = 'Vote For this node in relation to:';
$LNG->NODE_VOTE_AGAINST_TITLE = 'Vote Against this node in relation to:';

$LNG->NODE_ADDED_ON = 'Added on:';
$LNG->NODE_CONNECTED_ON = 'Connected on';
$LNG->NODE_CONNECTED_BY = 'Connected by';
$LNG->NODE_RESOURCE_LINK_HINT = 'View site';
$LNG->NODE_URL_LINK_TEXT = 'Go to web page';
$LNG->NODE_URL_LINK_HINT = 'Open the associated web page in a new tab';
$LNG->NODE_URL_HEADING = 'Url:';
$LNG->NODE_RESOURCE_CLIPS_HEADING = 'Clips:';
$LNG->NODE_RESOURCE_CLIP_HEADING = 'Clip:';
$LNG->NODE_DESC_HEADING = 'Description:';

$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART1 = 'Are you sure you want to disconnect';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART2 = 'from';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART3 = '?';
$LNG->NODE_DELETE_CHECK_MESSAGE = 'Are you sure you want to delete the';
$LNG->NODE_DELETE_CHECK_MESSAGE_ITEM = 'item';
$LNG->NODE_FOLLOW_ITEM_HINT = 'Follow this item...';
$LNG->NODE_UNFOLLOW_ITEM_HINT = 'Unfollow this item...';


/** BUILDER TOOLBAR **/
$LNG->BUILDER_GOTO_HOME_SITE_HINT = "go to ".$CFG->SITE_TITLE." Website";
$LNG->BUILDER_CLOSE_TOOLBAR_HINT = "close this ".$CFG->SITE_TITLE." Helper";
$LNG->BUILDER_TITLE_LABEL = "Title:";
$LNG->BUILDER_EXPLORE_LINK = "Explore";
$LNG->BUILDER_COLLAPSE_TOOLBAR_HINT = "collapse ".$CFG->SITE_TITLE." Helper";
$LNG->BUILDER_ADD_EVIDENCE_PRO_HINT = "Add a new ".$LNG->PRO_NAME." into ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_EVIDENCE_CON_HINT = "Add a new ".$LNG->CON_NAME." into ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_ISSUE_HINT = "Add a new ".$LNG->ISSUE_NAME." into ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_SOLUTION_HINT = "Add a new ".$LNG->SOLUTION_NAME." into ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_COMMENT_HINT = "Add a new ".$LNG->COMMENT_NAME." into ".$CFG->SITE_TITLE;

/** BUILDER HELP PAGE **/
$LNG->HELP_BUILDER_TITLE = 'LiteMap Toolbar';
$LNG->HELP_BUILDER_PARA1 = 'The LiteMap toolbar lets you enter data into LiteMap while browsing the web.';
$LNG->HELP_BUILDER_GET_TITLE = 'How to get the toolbar:';
$LNG->HELP_BUILDER_GET_LINK = 'Bookmark this link';
$LNG->HELP_BUILDER_USING_FIREFOX = 'If you are using <b>Firefox</b>, <b>Chrome</b> or <b>Safari</b> you can drag the above link to your browser Favourites toolbar.';
$LNG->HELP_BUILDER_USING_OPERA = 'If you are using <b>Opera</b>, right-click on the link above, select \'Bookmark Link...\'. You can then choose to \'Show on bookmarks bar\'.';
$LNG->HELP_BUILDER_USING_IE = '<b>Only available for IE 9+</b>: drag the above link to your browser Favourites toolbar but you will get a security warning message. Just select OK.';
$LNG->HELP_BUILDER_USING_IE_MORE_LINK = 'more info for IE 9';
$LNG->HELP_BUILDER_USING_IE_HIDE_LINK = 'hide';
$LNG->HELP_BUILDER_USING_IE_ERROR_TITLE = 'Annoying popup security message in IE 9';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART1 = 'If you see a warning similar to the one above when using our bookmarklet please follow these instructions:';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 = '1. In Internet Explorer, select Tools &gt; Internet Options.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '2. Select the Security tab.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '3. Select "Trusted Sites" (the big green tick).<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '4. Click the "Custom level..." button.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '5. In the "Security Settings" dialog, scroll down to the "Miscellaneous" section.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '6. Find this setting: "Websites in less privileged content zone can navigate into this zone" and select "Enable."<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '7. Click OK to close the dialog, then OK to close Internet Options.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '8. Restart Internet Explorer.';

$LNG->HELP_BUILDER_GET_TITLE_BOOKMARKLET = 'As a Bookmarklet';
$LNG->HELP_BUILDER_GET_TITLE_EXTENSION = 'As a browser extension';
$LNG->HELP_BUILDER_EXTENSION_CHROME = "Google Chrome Extension";
$LNG->HELP_BUILDER_EXTENSION_FIREFOX = "Firefox Extension";
$LNG->HELP_BUILDER_EXTENSION_SAFARI = "Safari Extension";
$LNG->HELP_BUILDER_EXTENSION_IE = "Internet Explorer Extension";
$LNG->HELP_BUILDER_EXTENSION_MESSAGE = 'After installing the extension you activate the toolbar by clicking on the litemap icon which should appear somewhere in the address bar (location varies between Browsers; see illustrations above).<br>Note: If your browser did not restart after installing the extension then any already open tabs will need their content refreshing before the toolbar will show.';
$LNG->HELP_BUILDER_EXTENSION_MESSAGE2 = '(more under development)';
$LNG->HELP_BUILDER_EXTENSION_SAFARI_MESSAGE = 'Due to Safari limitations the extension button will always be gray and will  not show an on/off state as in other browsers. You will need to read the rollover text to see if the toolbar is on or off. Also, when you create a new post through the popup forms, once the form closes the page will not automatically refresh, so you will need to manually refresh the page to see the new entry in the website page.';
$LNG->HELP_BUILDER_EXTENSION_IE_MESSAGE = 'This IE extension needs to run a dll that it installs in order to work. On some systems strong virus control software may block the dll from installing. On some system, like company computers, strong security setting may block the dll from being run.';

$LNG->HELP_BUILDER_WARNING = "NOTE: Due to changes in security policies on browsers it is now possible for websites to block bookmarklets like ours that load content from a another website from working on their web pages.
					Facebook and Twitter are two examples of sites that have implemented this policy.
					On these sites, clicking our bookmarklet shortcut will currently do nothing, so it may appear broken, but it is just blocked.
					This bookmarklet will still work on the majority of websites as they have not implemented this new security policy.
					Your browser may also block the bookmarklet, so you may have to override your browser setting to get it to work.
					We are currently writing new browser specific extentions to help with this issue (see below).";

/** MAIN TAB SCREENS - TABBERLIB **/
$LNG->TAB_ADD_MAP_LINK = 'Add '.$LNG->MAP_NAME;
$LNG->TAB_ADD_GROUP_LINK = 'Add '.$LNG->GROUP_NAME;
$LNG->TAB_ADD_MAP_HINT = 'Add '.$LNG->MAP_NAME;
$LNG->TAB_ADD_GROUP_HINT = 'Add '.$LNG->GROUP_NAME;


/** RECENT ACTIVITY EMAIL DIGEST **/
$LNG->RECENT_EMAIL_DIGEST_LABEL = 'Email Digest:';
$LNG->RECENT_EMAIL_DIGEST_REGISTER_MESSAGE = "Tick to receive a monthly email digest of recent activity.";
$LNG->RECENT_EMAIL_DIGEST_PROFILE_MESSAGE = "Opt in/out of receiving a monthly email digest of recent activity.";


/** EXPLORE PAGE WIDGETS **/
$LNG->WIDGET_RESIZE_ITEM_ALT = 'Resize item';
$LNG->WIDGET_RESIZE_ITEM_HINT = 'Resize this area';
$LNG->WIDGET_EXPAND_HINT = 'Expand';
$LNG->WIDGET_ICON_ALT = 'Icon';
$LNG->WIDGET_OPEN_CLOSE_ALT = 'Open/Close item';
$LNG->WIDGET_OPEN_CLOSE_HINT = 'Open/Close this area';
$LNG->WIDGET_CONTRACT_HINT = 'Contract';
$LNG->WIDGET_LOADING = 'Loading';
$LNG->WIDGET_LOAD = 'load';
$LNG->WIDGET_LOADING_EVIDENCE = 'Loading '.$LNG->ARGUMENTS_NAME.'...';
$LNG->WIDGET_LOADING_RESOURCE = 'Loading related '.$LNG->RESOURCES_NAME.'...';
$LNG->WIDGET_LOADING_FOLLOWERS = 'Loading '.$LNG->FOLLOWERS_NAME.'...';
$LNG->WIDGET_EVIDENCE_ADD_HINT = 'Select/create a contribution to add it as evidence against the current selected item';
$LNG->WIDGET_ADD_LINK = 'Add';
$LNG->WIDGET_SIGNIN_HINT = 'Sign In to add to LiteMap';
$LNG->WIDGET_FOLLOW_SIGNIN_HINT = 'Sign In to follow this entry';
$LNG->WIDGET_NONE_FOUND_PART1 = 'No';
$LNG->WIDGET_NONE_FOUND_PART2 = 'added yet';
$LNG->WIDGET_NONE_FOUND_PART2b = 'listed';
$LNG->WIDGET_ADD_BUTTON = 'Add';
$LNG->WIDGET_FOCUS_NODE_HINT = 'Click to View More Info';
$LNG->WIDGET_CLICK_EXPLORE_HINT = 'click to explore all';
$LNG->WIDGET_CLICK_EXPLORE_HINT2 = 'Click to explore';
$LNG->WIDGET_NO_RESULTS_FOUND = 'No results found';
$LNG->WIDGET_NO_GROUPS_FOUND = 'No '.$LNG->GROUPS_NAME.' found';
$LNG->WIDGET_NO_FOLLOWERS_FOUND = 'No '.$LNG->FOLLOWERS_NAME.' found';
$LNG->WIDGET_NEWS_POSTED_ON = 'Posted on';

/** SEARCH RESULTS PAGE **/
$LNG->SEARCH_TITLE_ERROR = 'Search Results';
$LNG->SEARCH_ERROR_EMPTY = 'You must enter something to search for.';
$LNG->SEARCH_TITLE = 'Search results for: ';
$LNG->SEARCH_BACKTOTOP = 'back to top';
$LNG->SEARCH_BACKTOTOP_IMG_ALT = 'Up';


/** INNER TAB PAGE SEARCH **/
$LNG->TAB_SEARCH_MAP_LABEL = 'Search';
$LNG->TAB_SEARCH_GROUP_LABEL = 'Search';
$LNG->TAB_SEARCH_CHALLENGE_LABEL = 'Search';
$LNG->TAB_SEARCH_ISSUE_LABEL = 'Search';
$LNG->TAB_SEARCH_SOLUTION_LABEL = 'Search';
$LNG->TAB_SEARCH_CON_LABEL = 'Search';
$LNG->TAB_SEARCH_PRO_LABEL = 'Search ';
$LNG->TAB_SEARCH_EVIDENCE_LABEL = 'Search';
$LNG->TAB_SEARCH_RESOURCE_LABEL = 'Search';
$LNG->TAB_SEARCH_USER_LABEL = 'Search';
$LNG->TAB_SEARCH_COMMENT_LABEL = 'Search';
$LNG->TAB_SEARCH_CHAT_LABEL = 'Search';
$LNG->TAB_SEARCH_GO_BUTTON = 'Go';
$LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON = 'Clear Current Search';


/** DEBATE/KNOWLEDGE TREE PAGE **/
$LNG->DEBATE_LOADING = '(Loading knowledge trees content...)';
$LNG->DEABTES_COUNT_MESSAGE_PART1 = 'This item is contained in';

$LNG->MAP_NODE_DETAILS_HINT = 'Click to explore Full Details on this item';

$LNG->NODE_DEBATE_TOGGLE = 'Show/hide the knowledge tree';
$LNG->NODE_DEBATE_ADD_TO_MENU_TEXT = 'Add';
$LNG->NODE_DEBATE_ADD_TO_PRO_MENU_TEXT = 'Add Supporting '.$LNG->ARGUMENT_NAME;
$LNG->NODE_DEBATE_ADD_TO_CON_MENU_TEXT = 'Add Counter '.$LNG->ARGUMENT_NAME;
$LNG->NODE_DEBATE_ADD_TO_SOLUTION_MENU_TEXT = 'Add '.$LNG->SOLUTION_NAME;
$LNG->NODE_DEBATE_ADD_TO_ISSUE_MENU_TEXT = 'Add '.$LNG->ISSUE_NAME;

$LNG->NODE_DEBATE_ADD_TO_MENU_HINT = 'Add your knowledge around this item';
$LNG->NODE_DEBATE_TREE_COUNT_HINT = 'The number of entries currently added to this knowledge tree';

$LNG->NODE_GOTO_PARENT_HINT = '- Click to scroll to this';


/** CHATS PAGE **/
$LNG->VIEWS_CHAT_TITLE = $LNG->CHATS_NAME;
$LNG->VIEWS_CHAT_HINT = 'Click to view any '.$LNG->CHATS_NAME.' on this item';

$LNG->CHAT_TREE_COUNT_HINT = 'The number of replies currently added to this '.$LNG->CHAT_NAME.' topic';
$LNG->CHAT_REPLY_TO_MENU_TEXT = 'Reply';
$LNG->CHAT_REPLY_TO_MENU_HINT = 'Post a reply to this '.$LNG->CHAT_NAME.' item';
$LNG->CHAT_ADD_BUTTON_TEXT = 'Start a New '.$LNG->CHAT_NAME;
$LNG->CHAT_ADD_BUTTON_HINT = 'Start a new '.$LNG->CHAT_NAME.' about the current focal item';
$LNG->CHAT_LOADING = "Loading ".$LNG->CHATS_NAME."...";
$LNG->NODE_CHAT_BUTTON_TEXT = $LNG->CHATS_NAME;
$LNG->NODE_CHAT_BUTTON_HINT = 'View all the '.$LNG->CHATS_NAME.' about this item';
$LNG->CHAT_TREE_TOGGLE = 'Show/hide the replies';
$LNG->NODE_REPLY_ON = 'Added on';

$LNG->CHAT_COMMENT_PARENT_TREE = 'Which is in a '.$LNG->CHAT_NAME.' about:';
$LNG->CHAT_COMMENT_PARENT_FOCUS = 'This item appears in a '.$LNG->CHAT_NAME.' about:';
$LNG->NODE_COMMENT_PARENT = 'Connected To:';

$LNG->CHAT_DELETE_CHECK_MESSAGE_PART1 = 'Are you sure you want to delete the '.$LNG->CHAT_NAME.' item: ';
$LNG->CHAT_DELETE_CHECK_MESSAGE_PART2 = '?';

$LNG->CHAT_HIGHLIGHT_NEWEST_TEXT = 'Most Recent Reply';


/** SPAM REPORTING **/
$LNG->SPAM_CONFIRM_MESSAGE_PART1= 'Are you sure you want to report';
$LNG->SPAM_CONFIRM_MESSAGE_PART2= 'as Spam / Inappropriate?';
$LNG->SPAM_SUCCESS_MESSAGE = 'has been reported as spam';
$LNG->SPAM_REPORTED_TEXT = 'Reported as Spam';
$LNG->SPAM_REPORTED_HINT = 'This has been reported as Spam / Inappropriate content';
$LNG->SPAM_REPORT_TEXT = 'Report as Spam';
$LNG->SPAM_REPORT_HINT = 'Report this as Spam / Inappropriate content';
$LNG->SPAM_LOGIN_REPORT_TEXT = 'Sign In to Report as Spam';
$LNG->SPAM_LOGIN_REPORT_HINT = 'Sign In to Report this as Spam / Inappropriate content';

/** PRINTING LISTS **/

$LNG->TAB_PRINT_ALT = 'Print';
$LNG->FOOTER_REPORT_PRINTED_ON = 'Report printed on:';

$LNG->TAB_PRINT_HINT_ISSUE = 'Print '.$LNG->ISSUES_NAME.' list';
$LNG->TAB_PRINT_HINT_SOLUTION = 'Print '.$LNG->SOLUTIONS_NAME.' list';
$LNG->TAB_PRINT_HINT_PRO = 'Print '.$LNG->PROS_NAME.' list';
$LNG->TAB_PRINT_HINT_CON = 'Print '.$LNG->CONS_NAME.' list';
$LNG->TAB_PRINT_HINT_COMMENT = 'Print '.$LNG->COMMENTS_NAME.' list';
$LNG->TAB_PRINT_HINT_EVIDENCE = 'Print '.$LNG->ARGUMENTS_NAME.' list';
$LNG->TAB_PRINT_HINT_MAP = 'Print '.$LNG->MAPS_NAME.' list';
$LNG->TAB_PRINT_HINT_RESOURCE = 'Print '.$LNG->RESOURCES_NAME.' list';

$LNG->TAB_PRINT_TITLE_ISSUE = 'LiteMap: '.$LNG->ISSUES_NAME.' Listing';
$LNG->TAB_PRINT_TITLE_SOLUTION = 'LiteMap: '.$LNG->SOLUTIONS_NAME.' Listing';
$LNG->TAB_PRINT_TITLE_PRO = 'LiteMap: '.$LNG->PRO_NAME.' Listing';
$LNG->TAB_PRINT_TITLE_CON = 'LiteMap: '.$LNG->CON_NAME.' Listing';
$LNG->TAB_PRINT_TITLE_COMMENT = 'LiteMap: '.$LNG->COMMENTS_NAME.' Listing';
$LNG->TAB_PRINT_TITLE_EVIDENCE = 'LiteMap: '.$LNG->ARGUMENTS_NAME.' Listing';
$LNG->TAB_PRINT_TITLE_MAP = 'LiteMap: '.$LNG->MAPS_NAME.' Listing';
$LNG->TAB_PRINT_TITLE_RESOURCE = 'LiteMap: '.$LNG->RESOURCES_NAME.' Listing';

/** MEDIA MAPPING **/
$LNG->MAP_MEDIA_LABEL = "Media Url";

$LNG->MAP_MEDIA_IMPORT_YOUTUBE_LABEL = "or YouTube Movie";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_BUTTON = "Import from YouTube";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_CLEAR = "Clear YouTube Movie";

$LNG->MAP_MEDIA_IMPORT_VIMEO_LABEL = "or Vimeo Movie";
$LNG->MAP_MEDIA_IMPORT_VIMEO_BUTTON = "Import from Vimeo";
$LNG->MAP_MEDIA_IMPORT_VIMEO_CLEAR = "Clear Vimeo Movie";

$LNG->MAP_MOVIE_WIDTH_LABEL = "Movie Width";
$LNG->MAP_MOVIE_HEIGHT_LABEL = "Movie Height";

$LNG->MAP_MEDIA_HELP = "Add a movie or sound file url to the map. You can then annotate nodes as pointers to timestamps in that media";
$LNG->MAP_MOVIE_WIDTH_HELP = "Set the preferred width to show the movie in the map";
$LNG->MAP_MOVIE_HEIGHT_HELP = "Set the preferred height to show the movie in the map";

$LNG->MAP_MEDIA_IMPORT_YOUTUBE_HELP = "Click the \'Import from YouTube\' button to add your YouTube movie \'Embed\' code. The width, height and movie id will be extracted and used to load the movie in the map.";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_PROMPT = "Paste your YouTube movie \'Embed\' code here:";
$LNG->MAP_MEDIA_IMPORT_VIMEO_HELP = "Click the \'Import from Vimeo\' button to add your Vimeo movie \'Embed\' code. The width, height and movie id will be extracted and used to load the movie in the map.";
$LNG->MAP_MEDIA_IMPORT_VIMEO_PROMPT = "Paste your Vimeo movie \'Embed\' code here:";

$LNG->MAP_MEDIA_NODE_JUMP_HINT = "Jump To given media index time";
$LNG->MAP_MEDIA_NODE_JUMP = "Jump";
$LNG->MAP_MEDIA_NODE_MEDIAINDEX = "Media Index: ";
$LNG->MAP_MEDIA_NODE_ASSIGN_HINT = "Assign given media index time to node";
$LNG->MAP_MEDIA_NODE_ASSIGN = "Assign index: ";
$LNG->MAP_MEDIA_NODE_REMOVE_HINT = "Remove media index time from this node";
$LNG->MAP_MEDIA_NODE_REMOVE = "Remove index";
$LNG->MAP_MEDIA_MODE_HINT = "Toggle Map media replay mode: when on, nodes will only appear after their media index time.";

 // not sure what these should be
$LNG->MAP_MOVIE_ERROR = "Error loading movie";
$LNG->MAP_AUDIO_ERROR = "Error loading audio";

// Map Replay
$LNG->MAP_REPLAY_SPEED_UNITS = "ms";
$LNG->MAP_REPLAY_SPEED_UNITS_HINT = "Please specify the replay speed in milliseconds greater than zero";
$LNG->MAP_REPLAY_PLAY_HINT = "Replay the map based on creationdates";
$LNG->MAP_REPLAY_PAUSE_HINT = "Pause the map replay";
$LNG->MAP_REPLAY_BACK_HINT = "Move back in the replay";
$LNG->MAP_REPLAY_FORWARD_HINT = "Move forward in the replay";
$LNG->MAP_REPLAY_SPEED_ERROR  = "Please make sure the speed value is a valid number of milliseconds greater than zero";
$LNG->MAP_REPLAY_MODE_HINT = "Toggle Map replay mode: when on, nodes will be sorted by their creation date and you will get controls to replay the map at a specified speed.";
?>