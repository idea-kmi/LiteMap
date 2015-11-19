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

/** SETUP THE FILE LOCATION MANAGER **/
	unset($HUB_FLM);
	require_once("core/filelocationmanager.class.php");
	// instantiate the file location manager
	if (isset($CFG->uitheme)) {
		$HUB_FLM = new FileLocationManager($CFG->uitheme);
	} else {
		$HUB_FLM = new FileLocationManager();
	}
	global $HUB_FLM;


/** SETUP STATIC CONFIG VARIABLES **/

	$CFG->VERSION = '1.0';

	/** NODE TYPES **/
	$CFG->BASE_TYPES = array("Challenge","Issue","Solution","Idea","Comment","Map");
	$CFG->EVIDENCE_TYPES = array("Argument","Pro","Con");
	$CFG->EVIDENCE_TYPES_DEFAULT = "Argument";

	/** LINK TYPES **/
	$CFG->LINK_SOLUTION_ISSUE = 'responds to';
	$CFG->LINK_PRO_SOLUTION = 'supports';
	$CFG->LINK_CON_SOLUTION = 'challenges';
	$CFG->LINK_COMMENT_NODE = 'is related to';
	$CFG->LINK_COMMENT_BUILT_FROM = 'built from'; //not used but needed if merge nodes added.
	$CFG->LINK_ISSUE_CHALLENGE = 'is related to';
	$CFG->LINK_NODE_SEE_ALSO = 'see also';
	$CFG->LINK_ISSUE_ISSUE = 'raised by';
	$CFG->LINK_ISSUE_SOLUTION = 'raised by';
	$CFG->LINK_SOLUTION_SOLUTION = 'is part of';
	$CFG->LINK_IDEA_NODE = 'is related to';

	$CFG->actionAdd = "add";
	$CFG->actionEdit = "edit";
	$CFG->actionDelete = "delete";

	/**
	 * This is a legacy item. This is still required by the delete role code!
	 * MB:look at removing
	 */
	$CFG->DEFAULT_NODE_TYPE = "Idea"; // This is still required by delete role!

	$CFG->AUTH_TYPE_EVHUB = "litemap";

	// FOR Nodes, Connections, URLs
	$CFG->STATUS_ACTIVE = 0;
	$CFG->STATUS_SPAM = 1; // Nodes only - not used in Debate Hub yet.
	$CFG->STATUS_RETIRED = 2;

	// For Users
	$CFG->USER_STATUS_ACTIVE = 0;
	$CFG->USER_STATUS_REPORTED = 1;
	$CFG->USER_STATUS_UNVALIDATED = 2;
	$CFG->USER_STATUS_UNAUTHORIZED = 3;
	$CFG->USER_STATUS_SUSPENDED = 4;

	// In the UserGroupJoin table these statuses mean:
	/*
	ACTIVE = Join Group Request Approved
	UNAUTHORIZED = Pending approval
	SUSPENDED = Join Group Request Rejected
	REPORTED = User was approved but then later Removed from the Group.
	*/

	$CFG->GLOBAL_CONTEXT = "global";
	$CFG->USER_CONTEXT = "user";
	$CFG->NODE_CONTEXT = "node";
	$CFG->GROUP_CONTEXT = "group";

	$CFG->IMAGE_MAX_FILESIZE = 2000000;
	$CFG->IMAGE_MAX_HEIGHT = 150;

	$CFG->IMAGE_WIDTH = 150;
	$CFG->IMAGE_HEIGHT = 100;
	$CFG->IMAGE_THUMB_WIDTH = 32;
	$CFG->ICON_WIDTH = 32;
	$CFG->DEFAULT_USER_PHOTO= 'profile.png';
	$CFG->DEFAULT_GROUP_PHOTO= 'groupprofile.png';
	$CFG->DEFAULT_ISSUE_PHOTO = 'mapdefault.png';

	/**
	 * The file paths for the node type icons used.
	 */
	$CFG->challengeicon = $HUB_FLM->getImagePath("nodetypes/Default/challenge.png");
	$CFG->issueicon = $HUB_FLM->getImagePath("nodetypes/Default/issue.png");
	$CFG->solutionicon = $HUB_FLM->getImagePath("nodetypes/Default/solution.png");
	$CFG->proicon = $HUB_FLM->getImagePath("nodetypes/Default/plus-32x32.png");
	$CFG->conicon = $HUB_FLM->getImagePath("nodetypes/Default/minus-32x32.png");
	$CFG->commenticon = $HUB_FLM->getImagePath("nodetypes/Default/idea.png");
	$CFG->argumenticon = $HUB_FLM->getImagePath("nodetypes/Default/argument.png");
	$CFG->mapicon = $HUB_FLM->getImagePath("nodetypes/Default/map.png");

	$CFG->MINI_PAGE_ALERTS = 'minialerts';

	$CFG->ALERT_UNSEEN_BY_ME = "unseen_by_me";
	$CFG->ALERT_RESPONSE_TO_ME = "response_to_me";
	$CFG->ALERT_UNRATED_BY_ME = "unrated_by_me";
	$CFG->ALERT_LURKING_USER = 'lurking_user';
	$CFG->ALERT_IGNORED_POST = 'ignored_post';
	$CFG->ALERT_MATURE_ISSUE = 'mature_issue';
	$CFG->ALERT_INACTIVE_USER = 'inactive_user';
	$CFG->ALERT_INTERESTING_TO_ME = "interesting_to_me";
	$CFG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME = "interesting_to_people_like_me";
	$CFG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME = "supported_by_people_like_me";
	$CFG->ALERT_HOT_POST = "hot_post";
	$CFG->ALERT_ORPHANED_IDEA = "orphaned_idea";
	$CFG->ALERT_EMERGING_WINNER = "winning_idea";
	$CFG->ALERT_CONTENTIOUS_ISSUE = "contentious_issue";
	$CFG->ALERT_CONTROVERSIAL_IDEA = "controversial_idea";
	$CFG->ALERT_INCONSISTENT_SUPPORT = "inconsistent_support";
	$CFG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "person_with_interests_like_mine";
	$CFG->ALERT_PEOPLE_WHO_AGREE_WITH_ME = "person_who_agree_with_me";
	$CFG->ALERT_USER_GONE_INACTIVE = "user_gone_inactive";
	$CFG->ALERT_IMMATURE_ISSUE = "immature_issue";
	$CFG->ALERT_WELL_EVALUATED_IDEA = "well_evaluated_idea";
	$CFG->ALERT_POORLY_EVALUATED_IDEA = "poorly_evaluated_idea";
	$CFG->ALERT_RATING_IGNORED_ARGUMENT = "rating_ignored_argument";
	$CFG->ALERT_UNSEEN_RESPONSE = "unseen_response";
	$CFG->ALERT_UNSEEN_COMPETITOR = "unseen_competitor";
	$CFG->ALERT_USER_IGNORED_COMPETITORS = "user_ignored_competitors";
	$CFG->ALERT_USER_IGNORED_ARGUMENTS = "user_ignored_arguments";
	$CFG->ALERT_USER_IGNORED_RESPONSES = "user_ignored_responses";

	$CFG->langoverride = $CFG->homeAddress.'/language/coreterms.json';


/** START SESSION **/
	//MB: consequences of calling accesslib before language files loaded?

    require_once('core/accesslib.php');
    startSession();

/** LOAD LANGUAGE FILES **/

	require_once('core/sanitise.php');

	if (isset($_GET['lang'])) {
		$CFG->language = optional_param('lang','en',PARAM_ALPHAEXT);
		if (!file_exists($CFG->dirAddress.'/language/'.$CFG->language."/")){
			$CFG->language = 'en';
		}
		$_SESSION['lang'] = $CFG->language;
		setcookie('lang', $CFG->language, time() + (3600 * 24 * 30));
	} else if(isset($_SESSION['lang'])) {
		$CFG->language = $_SESSION['lang'];
		if (!file_exists($CFG->dirAddress.'/language/'.$CFG->language."/")) {
			$CFG->language = 'en';
		}
	} else if(isset($_COOKIE['lang'])) {
		$temp = $_COOKIE['lang'];
		if (!file_exists($CFG->dirAddress.'/language/'.$temp."/")) {
			$CFG->language = 'en';
		} else {
			$CFG->language = $temp;
		}
	}

 	require_once("language/language.php");

/** CREATE ALL OTHER GLOBAL VARIABLES AND INITIALIZE THEM AND LOAD LIBRARIES **/

 	require_once("core/databases/sqlstatements.php");
	require_once("core/datamodel/datamodel.class.php");

    unset($USER);
	unset($HUB_DATAMODEL);

    global $CFG;
    global $LNG;
    global $USER;
    global $HEADER;
    global $BODY_ATT;
    global $CONTEXT;
    global $HUB_DATAMODEL;
    global $HUB_SQL;

    $HEADER = array();

/**CREATE THE DATAMODEL CLASS INSTANCE */
	$HUB_DATAMODEL = new DataModel();
	$HUB_DATAMODEL->load();

/** SETUP THE DATABASE MANAGER **/
	unset($DB);
	require_once("core/databases/databasemanager.class.php");
	// instantiate the database
	if (isset($CFG->databasetype) && $CFG->databasetype != "") {
		$DB = new DatabaseManager($CFG->databasetype);
	} else {
		$DB = new DatabaseManager();
	}
    global $DB;

/** SETUP THE CACHE MANAGER **/
	$CFG->CACHE_DEFAULT_TIMEOUT = 60;//seconds

	unset($HUB_CACHE);
	require_once("core/memcachemanager.class.php");
	if(class_exists('Memcache')){
		$HUB_CACHE = new MemcacheManager();
	}
    global $HUB_CACHE;

    //include common libaries auditlib.php and apilib.php etc...
    require_once('core/datamodel/error.class.php');
    require_once('core/apilib.php');
    require_once('core/auditlib.php');

    if (isset($_SESSION["session_userid"]) && $_SESSION["session_userid"] != "") {
    	$USER = new User($_SESSION["session_userid"]);
    	$USER = $USER->load();
    } else {
    	$USER = new User();
    }
?>