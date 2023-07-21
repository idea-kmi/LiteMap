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
 *
 */

$LNG->CORE_UNKNOWN_USER_ERROR = 'User unknown';
$LNG->CORE_NOT_IMAGE_ERROR = 'Sorry you can only upload images.';
$LNG->CORE_NOT_IMAGE_TOO_LARGE_ERROR = 'Sorry the image file is too large.';
$LNG->CORE_NOT_IMAGE_UPLOAD_ERROR = 'An error occured uploading the image';
$LNG->CORE_NOT_IMAGE_RESIZE_ERROR = 'Error resizing image';
$LNG->CORE_NOT_IMAGE_SCALE_ERROR = 'Error scaling image.';

$LNG->CORE_SESSION_OK = 'OK';
$LNG->CORE_SESSION_INVALID = 'Session Invalid';

$LNG->CORE_AUDIT_NOT_XML_ERROR = 'Not a valid XML file';
$LNG->CORE_AUDIT_CONNECTION_NOT_FOUND_ERROR = 'Connection not found';
$LNG->CORE_AUDIT_NODE_NOT_FOUND_ERROR = 'Node not found';
$LNG->CORE_AUDIT_URL_NOT_FOUND_ERROR = 'URL not found';
$LNG->CORE_AUDIT_CONNECTION_ID_MISSING_ERROR = 'Connection id data missing - data could not be loaded';
$LNG->CORE_AUDIT_CONNECTION_DATA_MISSING_ERROR = 'Connection data missing';
$LNG->CORE_AUDIT_NODE_ID_MISSING_ERROR = 'Node id data missing - node could not be loaded';
$LNG->CORE_AUDIT_NODE_DATA_MISSING_ERROR = 'Node data missing';
$LNG->CORE_AUDIT_URL_ID_MISSING_ERROR = 'Url id data missing - url could not be loaded';
$LNG->CORE_AUDIT_URL_DATA_MISSING_ERROR = 'Url data missing';
$LNG->CORE_AUDIT_TAG_ID_MISSING_ERROR = 'Tag id data missing - Tag could not be loaded';
$LNG->CORE_AUDIT_TAG_DATA_MISSING_ERROR = 'Tag data missing';
$LNG->CORE_AUDIT_USER_ID_MISSING_ERROR = 'User id data missing - user could not be loaded';
$LNG->CORE_AUDIT_USER_DATA_MISSING_ERROR = 'User data missing';
$LNG->CORE_AUDIT_GROUP_ID_MISSING_ERROR = 'Group id data missing - Group could not be loaded';
$LNG->CORE_AUDIT_GROUP_DATA_MISSING_ERROR = 'Group data missing';
$LNG->CORE_AUDIT_ROLE_ID_MISSING_ERROR = 'Node Type id data missing - Node Type could not be loaded';
$LNG->CORE_AUDIT_ROLE_DATA_MISSING_ERROR = 'Node Type data missing';
$LNG->CORE_AUDIT_LINK_ID_MISSING_ERROR = 'Linktype id data missing - Link Type could not be loaded';
$LNG->CORE_AUDIT_LINK_DATA_MISSING_ERROR = 'Link Type data missing';

$LNG->CORE_FORMAT_NOT_IMPLEMENTED_MESSAGE = 'Not yet implemented';
$LNG->CORE_FORMAT_INVALID_SELECTION_ERROR = 'Invalid format selection';

$LNG->CORE_HELP_ERRORCODES_TITLE = 'Help - API Error codes';
$LNG->CORE_HELP_ERRORCODES_CODE_HEADING = 'Code';
$LNG->CORE_HELP_ERRORCODES_MEANING_HEADING = 'Meaning';

$LNG->CORE_DATAMODEL_GROUP_CANNOT_REMOVE_MEMBER = 'Cannot remove user as admin as group will have no admins';

/**
 * THESE ARE ERROR MESSAGE SENT FROM THE API CORE CODE
 * YOU MAY CHOOSE NOT TO TRANSLATE THESE
 */
$LNG->ERROR_REQUIRED_PARAMETER_MISSING_MESSAGE = "Required parameter missing";
$LNG->ERROR_INVALID_METHOD_SPECIFIED_MESSAGE = "Invalid or no method specified";
$LNG->ERROR_INVALID_ORDERBY_MESSAGE = "Invalid order by selection";
$LNG->ERROR_INVALID_SORT_MESSAGE = "Invalid sort selection";
$LNG->ERROR_BLANK_NODEID_MESSAGE = "The item id cannot be blank.";
$LNG->ERROR_ACCESS_DENIED_MESSAGE = "Access denied";
$LNG->ERROR_LOGIN_FAILED_MESSAGE = "Sign In failed: Your email or password are wrong. Please try again.";
$LNG->ERROR_LOGIN_FAILED_UNAUTHORIZED_MESSAGE = "Sign In failed: This account has not yet been authorized";
$LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE = "Sign In failed: This account has been suspended";
$LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE = "Sign In failed: This account has not completed the registration process by having its Email address validated.";
$LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE = "The account with the given email address was created with an external service and does not have a local password.<br>You must sign in to this account using:";

$LNG->ERROR_INVALID_JSON_ERROR_NONE = "No JSON errors";
$LNG->ERROR_INVALID_JSON_ERROR_DEPTH = "Maximum stack depth exceeded in the JSON";
$LNG->ERROR_INVALID_JSON_ERROR_STATE_MISMATCH = "Underflow or the modes mismatch";
$LNG->ERROR_INVALID_JSON_ERROR_CTRL_CHAR = "Unexpected control character found in the JSON";
$LNG->ERROR_INVALID_JSON_ERROR_SYNTAX = "Syntax error, malformed JSON";
$LNG->ERROR_INVALID_JSON_ERROR_UTF8 = "Malformed UTF-8 characters, possibly incorrectly encoded";
$LNG->ERROR_INVALID_JSON_ERROR_DEFAULT = "An unknown error has occurred decoding the JSON";

$LNG->ERROR_INVALID_METHOD_FOR_TYPE_MESSAGE = "Method not allowed for this format type";
$LNG->ERROR_DUPLICATION_MESSAGE = "Duplication Error";
$LNG->ERROR_INVALID_EMAIL_FORMAT_MESSAGE = "Invalid email format";
$LNG->ERROR_DATABASE_MESSAGE = "Database error";
$LNG->ERROR_USER_NOT_FOUND_MESSAGE = 'User not found in database';
$LNG->ERROR_URL_NOT_FOUND_MESSAGE = 'Url not found in database';
$LNG->ERROR_TAG_NOT_FOUND_MESSAGE = 'Tag not found in database';
$LNG->ERROR_ROLE_NOT_FOUND_MESSAGE = 'Node Type (Role) not found in database';
$LNG->ERROR_LINKTYPE_NOT_FOUND_MESSAGE = 'Link Type not found in database';
$LNG->ERROR_NODE_NOT_FOUND_MESSAGE = 'Node not found in database';
$LNG->ERROR_CONNECTION_NOT_FOUND_MESSAGE = 'Connection not found in database';
$LNG->ERROR_INVALID_CONNECTION_MESSAGE = "Invalid connection combination. Does not match the datamodel.";
$LNG->ERROR_INVALID_PARAMETER_TYPE_MESSAGE = "Invalid parameter type";
?>