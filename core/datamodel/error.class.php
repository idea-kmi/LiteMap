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

///////////////////////////////////////
// Hub_Error Class
///////////////////////////////////////

class Hub_Error {

	private $REQUIRED_PARAMETER_MISSING = "1000";
	private $INVALID_METHOD_SPECIFIED = "1001";
	private $INVALID_ORDERBY = "1002";
	private $INVALID_SORT = "1003";
	private $BLANK_NODEID = "1004";

	private $LOGIN_FAILED = "2000";
	private $LOGIN_FAILED_UNAUTHORISED = "2001";
	private $LOGIN_FAILED_SUSPENDED = "2002";
	private $LOGIN_FAILED_UNVALIDATED = "2003";
	private $LOGIN_FAILED_EXTERNAL = "2004";

	private $ACCESS_DENIED = "2010";
	private $VALIDATE_SESSION = "2011";
	private $INVALID_METHOD_FOR_TYPE = "3000";
	private $DUPLICATION = "3001";
	private $INVALID_EMAIL_FORMAT = "4000";

	private $INVALID_JSONLD_FORMAT = "5000";

	private $DATABASE = "7000";
	private $USER_NOT_FOUND = '7002';
	private $URL_NOT_FOUND = '7003';
	private $TAG_NOT_FOUND = '7004';
	private $ROLE_NOT_FOUND = '7005';
	private $LINKTYPE_NOT_FOUND = '7006';
	private $NODE_NOT_FOUND = '7007';
	private $CONNECTION_NOT_FOUND = '7008';
	private $GROUP_NOT_FOUND = "7009";
	private $GROUP_EXISTS = "7010";
	private $GROUP_LAST_ADMIN = "7011";
	private $GROUP_USER_NOT_MEMBER = "7012";

	private $INVALID_CONNECTION = "8000";
	private $INVALID_PARAMETER_TYPE = "10001";

    public $message;
    public $code;

    function createLoginFailedError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_LOGIN_FAILED_MESSAGE;
        $this->code = $this->LOGIN_FAILED;
    }

    function createLoginFailedUnauthorizedError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_LOGIN_FAILED_UNAUTHORISED_MESSAGE;
        $this->code = $this->LOGIN_FAILED_UNAUTHORISED;
    }

    function createLoginFailedSuspendedError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE;
        $this->code = $this->LOGIN_FAILED_SUSPENDED;
    }

    function createLoginFailedUnvalidatedError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE;
        $this->code = $this->LOGIN_FAILED_UNVALIDATED;
    }

    function createLoginFailedExternalError($type) {
    	global $LNG;
    	$this->message = $LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE." ".$type;
        $this->code = $this->LOGIN_FAILED_EXTERNAL;
    }

    function createInvalidMethodError() {
    	global $LNG;
        $this->message = $LNG->ERROR_INVALID_METHOD_SPECIFIED_MESSAGE;
        $this->code = $this->INVALID_METHOD_SPECIFIED;
    }

    function createRequiredParameterError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_REQUIRED_PARAMETER_MISSING_MESSAGE." : ".$parname;
        $this->code = $this->REQUIRED_PARAMETER_MISSING;
    }

    function createInvalidOrderbyError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_INVALID_ORDERBY_MESSAGE;
        $this->code = $this->INVALID_ORDERBY;
    }

    function createInvalidSortError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_INVALID_SORT_MESSAGE;
        $this->code = $this->INVALID_SORT;
    }

    function createBlankNodeidError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_BLANK_NODEID_MESSAGE;
        $this->code = $this->BLANK_NODEID;
    }

    function createDuplicationError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_DUPLICATION_MESSAGE;
        $this->code = $this->DUPLICATION;
    }

    function createAccessDeniedError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_ACCESS_DENIED_MESSAGE;
        $this->code = $this->ACCESS_DENIED;
    }

    function createValidateSessionError($message) {
    	global $LNG;
    	$this->message = $message;
        $this->code = $this->VALIDATE_SESSION;
    }

    function createInvalidMethodForTypeError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_INVALID_METHOD_FOR_TYPE_MESSAGE;
        $this->code = $this->INVALID_METHOD_FOR_TYPE;
    }

    function createInvalidEmailError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_INVALID_EMAIL_FORMAT_MESSAGE;
        $this->code = $this->INVALID_EMAIL_FORMAT;
    }

    function createInvalidConnectionError($parname="") {
    	global $LNG;
    	$this->message = $LNG->ERROR_INVALID_CONNECTION_MESSAGE;
    	if ($parname != "") {
    		$this->message .= " : ".$parname;
    	}
        $this->code = $this->INVALID_CONNECTION;
    }

    function createInvalidParameterError($type) {
    	global $LNG;
    	$this->message = $LNG->ERROR_INVALID_PARAMETER_TYPE_MESSAGE." : ".$type;
        $this->code = $this->INVALID_PARAMETER_TYPE;
    }

    function createDatabaseError() {
    	global $LNG;
    	$this->message = $LNG->ERROR_DATABASE_MESSAGE;
        $this->code = $this->DATABASE;
    }

    function createUserNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_USER_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->USER_NOT_FOUND;
    }

    function createUrlNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_URL_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->URL_NOT_FOUND;
    }

    function createTagNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_TAG_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->TAG_NOT_FOUND;
    }

    function createRoleNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_ROLE_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->ROLE_NOT_FOUND;
    }

    function createLinkTypeNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_LINKTYPE_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->LINKTYPE_NOT_FOUND;
    }

    function createNodeNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_NODE_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->NODE_NOT_FOUND;
    }

    function createConnectionNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_CONNECTION_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->CONNECTION_NOT_FOUND;
    }

    function createGroupNotFoundError($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_GROUP_NOT_FOUND_MESSAGE." : ".$parname;
        $this->code = $this->GROUP_NOT_FOUND;
    }

    function createGroupExists($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_GROUP_EXISTS_MESSAGE." : ".$parname;
        $this->code = $this->GROUP_EXISTS;
    }

    function createGroupLastAdmin($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_GROUP_USER_LAST_ADMIN." : ".$parname;
        $this->code = $this->GROUP_LAST_ADMIN;
    }


    function createNotInGroup($parname) {
    	global $LNG;
    	$this->message = $LNG->ERROR_GROUP_USER_NOT_MEMBER." : ".$parname;
        $this->code = $this->GROUP_USER_NOT_MEMBER;
    }

	function createInvalidJSONLDError($json_last_error) {
    	global $LNG;

		switch ($json_last_error) {
			case JSON_ERROR_NONE:
		    	$this->message = $LNG->ERROR_INVALID_JSON_ERROR_NONE;
			break;
			case JSON_ERROR_DEPTH:
		    	$this->message = $LNG->ERROR_INVALID_JSON_ERROR_DEPTH;
			break;
			case JSON_ERROR_STATE_MISMATCH:
		    	$this->message = $LNG->ERROR_INVALID_JSON_ERROR_STATE_MISMATCH;
			break;
			case JSON_ERROR_CTRL_CHAR:
		    	$this->message = $LNG->ERROR_INVALID_JSON_ERROR_CTRL_CHAR;
			break;
			case JSON_ERROR_SYNTAX:
		    	$this->message = $LNG->ERROR_INVALID_JSON_ERROR_SYNTAX;
			break;
			case JSON_ERROR_UTF8:
		    	$this->message = $LNG->ERROR_INVALID_JSON_ERROR_UTF8;
			break;
			default:
		    	$this->message = $LNG->ERROR_INVALID_JSON_ERROR_DEFAULT;
			break;
		}

        $this->code = $this->INVALID_JSONLD_FORMAT;
	}
}
?>