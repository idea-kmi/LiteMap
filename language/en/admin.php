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
 */

$LNG->ADMIN_CREATE_LINK_TYPES_TITLE = 'Create Link Types';
$LNG->ADMIN_CREATE_NODE_TYPES_TITLE = 'Create Node Types';

$LNG->ADMIN_TITLE = "Administration Area";
$LNG->ADMIN_BUTTON_HINT = "This launches in a new window";
$LNG->ADMIN_STATS_BUTTON_HINT = "Go to the Site Analytics pages";
$LNG->ADMIN_REGISTER_NEW_USER_LINK = 'Register a New User';
$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE = 'Sorry you need to be an administrator to access this page';
$LNG->ADMIN_MANAGE_USERS_DELETE_ERROR = 'There was an issue deleting the user with the id:';
$LNG->ADMIN_TREEVIEW_LOADING = 'Loading tree data. Please wait....';
$LNG->ADMIN_TREEVIEW_LOADING_FAILED = 'Loading tree data failed.';

/** ADMIN USER REGISTRATION MANAGER **/
$LNG->REGSITRATION_ADMIN_MANAGER_LINK = "Registration Requests";
$LNG->REGSITRATION_ADMIN_TITLE = 'User Registration Manager';

$LNG->REGSITRATION_ADMIN_UNREGISTERED_TITLE = "Registration Requests";
$LNG->REGSITRATION_ADMIN_UNVALIDATED_TITLE = "Unvalidated Registrations";
$LNG->REGSITRATION_ADMIN_REVALIDATE_BUTTON = "Revalidate";
$LNG->REGSITRATION_ADMIN_REMOVE_BUTTON = "Remove";
$LNG->REGSITRATION_ADMIN_REMOVE_CHECK_MESSAGE = "Are you sure you want to REMOVE this user registration?: ";
$LNG->REGSITRATION_ADMIN_REVALIDATE_CHECK_MESSAGE = "Are you sure you want to send another validation email to this user?: ";
$LNG->REGSITRATION_ADMIN_USER_REMOVED = 'has had their acount removed from the system';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REVALIDATED = 'has been re-emailed that their registration request was accepted';

$LNG->REGSITRATION_ADMIN_REJECT_CHECK_MESSAGE = "Are you sure you want to REJECT this user registration request?: ";
$LNG->REGSITRATION_ADMIN_ACCEPT_CHECK_MESSAGE = "Are you sure you want to ACCEPT this user registration request?: ";
$LNG->REGSITRATION_ADMIN_NONE_MESSAGE = 'There are currently no users requesting registration';
$LNG->REGSITRATION_ADMIN_VALIDATION_NONE_MESSAGE = 'There are currently no users awaiting validation';
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_DATE = "Date Created";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_NAME = "Name";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_EMAIL = "Email";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_DESC = "Description";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_INTEREST = "Interest";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_WEBSITE = "Website";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION = "Action";
$LNG->REGSITRATION_ADMIN_REJECT_BUTTON = 'Reject';
$LNG->REGSITRATION_ADMIN_ACCEPT_BUTTON = 'Accept';
$LNG->REGSITRATION_ADMIN_ID_ERROR = "Can not process user request as userid is missing";
$LNG->REGSITRATION_ADMIN_USER_EMAILED_ACCEPTANCE = 'has been emailed that their registration request was accepted';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REJECTION = 'has been emailed that their registration request was rejected';
$LNG->REGSITRATION_ADMIN_EMAIL_REQUEST_SUBJECT = "Registration request for the ".$CFG->SITE_TITLE;

// %s will be replace with the name of the current Site. When translating please leave this in the sentence appropariately placed.
$LNG->REGSITRATION_ADMIN_EMAIL_REJECT_BODY = 'Thank you for requesting registration on the %s.<br>Unfortunately, on this occasion, your request for a user account has not been successful.';

/** SPAM MANAGEMENT **/
$LNG->SPAM_ADMIN_MANAGER_SPAM_LINK = "Reported Items";
$LNG->SPAM_ADMIN_SPAM_TITLE = "Reported Items";
$LNG->SPAM_ADMIN_ARCHIVE_TITLE = "Archived Items";
$LNG->SPAM_ADMIN_TITLE = "Item Report Manager";
$LNG->SPAM_ADMIN_ID_ERROR = "Can not process request as nodeid is missing";
$LNG->SPAM_ADMIN_TABLE_HEADING0 = "Reported By";
$LNG->SPAM_ADMIN_TABLE_HEADING1 = "Title";
$LNG->SPAM_ADMIN_TABLE_HEADING2 = "Action";
$LNG->SPAM_ADMIN_TABLE_HEADING3 = "Node Type";
$LNG->SPAM_ADMIN_DELETE_CHECK_MESSAGE = "Are you sure you want to delete the item?: ";
$LNG->SPAM_ADMIN_RESTORE_CHECK_MESSAGE = "Are you sure you want to set as NOT SPAM?: ";
$LNG->SPAM_ADMIN_ARCHIVE_CHECK_MESSAGE = "Are you sure you want to archive this item?: ";
$LNG->SPAM_ADMIN_RESTORE_BUTTON = "Restore";
$LNG->SPAM_ADMIN_ARCHIVE_BUTTON = "Archive";
$LNG->SPAM_ADMIN_DELETE_BUTTON = "Delete";
$LNG->SPAM_ADMIN_VIEW_BUTTON = "View Details";
$LNG->SPAM_ADMIN_NONE_MESSAGE = 'There are currently no items reported as Spam / Inappropriate';

$LNG->SPAM_USER_ADMIN_TABLE_HEADING0 = "Reported By";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING1 = "User Name";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING2 = "Action";
$LNG->SPAM_USER_ADMIN_VIEW_BUTTON = "View User Home";
$LNG->SPAM_USER_ADMIN_VIEW_HINT = "Open a new Window showing this user's home page";
$LNG->SPAM_USER_ADMIN_RESTORE_BUTTON = "Restore Account";
$LNG->SPAM_USER_ADMIN_RESTORE_HINT = "Restore this user account to active";
$LNG->SPAM_USER_ADMIN_DELETE_BUTTON = "Delete Account";
$LNG->SPAM_USER_ADMIN_DELETE_HINT = "Delete this user account and all their data";
$LNG->SPAM_USER_ADMIN_SUSPEND_BUTTON = "Suspend Account";
$LNG->SPAM_USER_ADMIN_SUSPEND_HINT = "Suspend this user account and prevent them signing in";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "Are you sure you want to delete the user: ";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Be warned: all their data will be permanently deleted. If you have not done so, you should check their contributions first by clicking '".$LNG->SPAM_USER_ADMIN_VIEW_BUTTON."'";;
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "Are you sure you want to restore the account of: ";
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "This will remove this user from this list";
$LNG->SPAM_USER_ADMIN_SUSPEND_CHECK_MESSAGE = "Are you sure you want to suspend the account of: ";
$LNG->SPAM_USER_ADMIN_NONE_MESSAGE = 'There are currently no users reported as Spammers / Inappropriate';
$LNG->SPAM_USER_ADMIN_TITLE = "User Report Manager";
$LNG->SPAM_USER_ADMIN_MANAGER_SPAM_LINK = "Reported Users";
$LNG->SPAM_USER_ADMIN_ID_ERROR = "Can not process request as userid is missing";
$LNG->SPAM_USER_ADMIN_NONE_SUSPENDED_MESSAGE = 'There are currently no users suspended';
$LNG->SPAM_USER_ADMIN_SPAM_TITLE = 'Users Reported';
$LNG->SPAM_USER_ADMIN_SUSPENDED_TITLE = 'Users Suspended';

$LNG->SPAM_GROUP_REPORTED = 'Group has been reported as a Spammer / Inappropriate';
$LNG->SPAM_GROUP_REPORT = 'Report this Group as Spam / Inappropriate';
$LNG->SPAM_GROUP_LOGIN_REPORT = 'Login to report this Group as Spam / Inappropriate';
$LNG->SPAM_GROUP_REPORTED_ALT = 'Reported';
$LNG->SPAM_GROUP_REPORT_ALT = 'Report';
$LNG->SPAM_GROUP_LOGIN_REPORT_ALT = 'Login to Report';
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING0 = "Reported By";
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING1 = "Group Name";
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 = "Action";
$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON = "View Group";
$LNG->SPAM_GROUP_ADMIN_VIEW_HINT = "Open a new Window showing this group's home page";
$LNG->SPAM_GROUP_ADMIN_RESTORE_BUTTON = "Restore Group";
$LNG->SPAM_GROUP_ADMIN_RESTORE_HINT = "Restore this group to active";
$LNG->SPAM_GROUP_ADMIN_DELETE_BUTTON = "Delete Group";
$LNG->SPAM_GROUP_ADMIN_DELETE_HINT = "Delete this group";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_BUTTON = "Archive Group";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_HINT = "Archive this group and all debates it contains";
$LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "Are you sure you want to delete the group: ";
$LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Be warned: group members will be removed from the group and node and triple's associated with the group will lose that association. If you have not done so, you should check the group members and contents first by clicking '".$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON."'";;
$LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "Are you sure you want to restore the group: ";
$LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "This will remove this group from this list";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_CHECK_MESSAGE = "Are you sure you want to Archive the group: ";
$LNG->SPAM_GROUP_ADMIN_NONE_MESSAGE = 'There are currently no groups reported as Spammers / Inappropriate';
$LNG->SPAM_GROUP_ADMIN_TITLE = "Group Report Manager";
$LNG->SPAM_GROUP_ADMIN_MANAGER_SPAM_LINK = "Reported Groups";
$LNG->SPAM_GROUP_ADMIN_ID_ERROR = "Can not process request as groupid is missing";
$LNG->SPAM_GROUP_ADMIN_NONE_ARCHIVED_MESSAGE = 'There are currently no groups archived';
$LNG->SPAM_GROUP_ADMIN_SPAM_TITLE = 'Groups Reported';
$LNG->SPAM_GROUP_ADMIN_ARCHIVED_TITLE = 'Groups Archived';

/** NEWS ADMINSTRATION **/
$LNG->ADMIN_MANAGE_NEWS_LINK = "Manage ".$LNG->NEWSS_NAME;
$LNG->ADMIN_MANAGE_NEWS_DELETE_ERROR = 'There was an issue deleting the '.$LNG->NEWS_NAME.' with the id:';
$LNG->ADMIN_NEWS_MISSING_NAME_ERROR = 'You must enter a '.$LNG->NEWS_NAME.' title.';
$LNG->ADMIN_NEWS_ID_ERROR  = 'Error passing '.$LNG->NEWS_NAME.' id.';
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART1 = 'Are you sure you want to delete the '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART2 = '?';
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART1 = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART2 = 'has now been deleted.';
$LNG->ADMIN_NEWS_TITLE = "Manage ".$LNG->NEWSS_NAME;
$LNG->ADMIN_NEWS_ADD_NEW_LINK = 'Add '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_NAME_LABEL = 'Title:';
$LNG->ADMIN_NEWS_DESC_LABEL = 'Description:';
$LNG->ADMIN_NEWS_TITLE_HEADING = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_ACTION_HEADING = 'Action';
$LNG->ADMIN_NEWS_EDIT_LINK = 'edit';
$LNG->ADMIN_NEWS_DELETE_LINK = 'delete';

/** USER STATS **/
$LNG->ADMIN_NEWS_USERS = 'Users';
$LNG->ADMIN_NEWS_GROUPS = 'Groups';
$LNG->ADMIN_DASHBOARD = 'Admin Dashboard';

/** GLOBAL STATS **/
$LNG->HOMEPAGE_STATS_LINK = "Analytics";

$LNG->ADMIN_STATS_TITLE = 'Global Analytics';
$LNG->ADMIN_STATS_TAB_OVERVIEW = 'Overview';
$LNG->ADMIN_STATS_TAB_REGISTER = 'User Registration';
$LNG->ADMIN_STATS_TAB_IDEAS = 'Items Created';
$LNG->ADMIN_STATS_TAB_CONNS = 'Connections Created';

$LNG->ADMIN_STATS_REGISTER_TOTAL_LABEL = 'Total user count';
$LNG->ADMIN_STATS_REGISTER_HEADER_NAME = 'Name';
$LNG->ADMIN_STATS_REGISTER_HEADER_DATE = 'Date';
$LNG->ADMIN_STATS_REGISTER_HEADER_DESC = 'Description';
$LNG->ADMIN_STATS_REGISTER_HEADER_WEBSITE = 'Website';
$LNG->ADMIN_STATS_REGISTER_HEADER_LOCATION = 'Location';
$LNG->ADMIN_STATS_REGISTER_HEADER_INTEREST = 'Interest';
$LNG->ADMIN_STATS_REGISTER_HEADER_LAST_LOGIN = 'Last Sign In';
$LNG->ADMIN_STATS_REGISTER_GRAPH_MONTH_TITLE = 'User Registration By Month';
$LNG->ADMIN_STATS_REGISTER_GRAPH_WEEK_TITLE = 'User Registration By Week';
$LNG->ADMIN_STATS_REGISTER_GRAPH_X_LABEL = 'Number of Registrations';
$LNG->ADMIN_STATS_REGISTER_GRAPH_MONTH_Y_LABEL = 'Months (from';
$LNG->ADMIN_STATS_REGISTER_GRAPH_WEEK_Y_LABEL = 'Weeks (from';

$LNG->ADMIN_STATS_IDEAS_TOTAL_LABEL = 'Total count';
$LNG->ADMIN_STATS_IDEAS_GRAPH_WEEK_TITLE  ='Weekly Item Creation';
$LNG->ADMIN_STATS_IDEAS_GRAPH_MONTH_TITLE  ='Monthly Item Creation';
$LNG->ADMIN_STATS_IDEAS_GRAPH_MONTH_Y_LABEL = 'Months (from';
$LNG->ADMIN_STATS_IDEAS_GRAPH_WEEK_Y_LABEL = 'Weeks (from';
$LNG->ADMIN_STATS_IDEAS_GRAPH_X_LABEL = 'Number of Ideas';

$LNG->ADMIN_STATS_CONNS_TOTAL_LABEL = 'Total connection count';
$LNG->ADMIN_STATS_IDEAS_MONTHLY_TOTAL_LABEL = 'Monthly Total';
$LNG->ADMIN_STATS_CONNS_GRAPH_WEEK_TITLE  ='Weekly Connection Creation for the last Year';
$LNG->ADMIN_STATS_CONNS_GRAPH_MONTH_TITLE  ='Monthly Connection Creation for the last Year';
$LNG->ADMIN_STATS_CONNS_GRAPH_MONTH_Y_LABEL = 'Months (from';
$LNG->ADMIN_STATS_CONNS_GRAPH_WEEK_Y_LABEL = 'Weeks (from';
$LNG->ADMIN_STATS_CONNS_GRAPH_X_LABEL = 'Number of Connections';

$LNG->OVERVIEW_ARGUMENT_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->ARGUMENTS_NAME;
$LNG->OVERVIEW_COMMENT_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->COMMENTS_NAME;
$LNG->OVERVIEW_CHAT_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->CHATS_NAME;
?>