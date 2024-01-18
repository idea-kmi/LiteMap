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

/* FUNCTIONS TO ADD TO THE AUDIT TABLES */

/**
 * Add a new audit entry into the node/idea audit table.
 *
 * @param string $userid The unique userid for the person making the entry
 * @param string $nodeid The unique id for the node/idea begin audited
 * @param string $name The name of the node/idea. Its label
 * @param string $desc The description of the node/idea
 * @param string $changeType The type of the change to the record (delete, edit, add)
 * @return boolean
 */
function auditIdea($userid, $nodeid, $name, $desc, $changeType,$xml) {
    global $DB, $HUB_SQL;

    $wentOK = true;

    $modificationDate = time();

	$params = array();
	$params[0] = $userid;
	$params[1] = $nodeid;
	$params[2] = $name;
	$params[3] = $desc;
	$params[4] = $modificationDate;
	$params[5] = $changeType;
	$params[6] = $xml;

    $res = $DB->insert($HUB_SQL->AUDIT_NODE_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}


/**
 * Add a new audit entry into the url audit table.
 *
 * @param string $userid The unique userid for the person making the entry
 * @param string $urlid The unique id for the url begin audited
 * @param string $nodeid The unique id for the node involved in this association (if this is an asssociation entry)
 * @param string $url The url itself
 * @param string $title The title for the url page
 * @param string $desc The description for the url page
 * @param string $clip The selected text, if any, on the url page
 * @param string $clippath - only used by Firefox plugin
 * @param string $cliphtml - only used by Firefox plugin
 * @param string $comments The comments for the website association with a node (if this is an asssociation entry)
 * @param string $changeType The type of the change to the record (delete, edit, add)
 * @return booelan
 */
function auditURL($userid, $urlid, $nodeid, $url, $title, $desc, $clip, $clippath, $cliphtml, $comments, $changeType, $xml) {
    global $DB,$HUB_SQL;

    $wentOK = true;
    $modificationDate = time();

	$params = array();
	$params[0] = $userid;
	$params[1] = $urlid;
	$params[2] = $url;
	$params[3] = $title;
	$params[4] = $desc;
	$params[5] = $clip;
	$params[6] = $clippath;
	$params[7] = $cliphtml;
	$params[8] = $modificationDate;
	$params[9] = $changeType;
	$params[10] = $xml;

    $res = $DB->insert($HUB_SQL->AUDIT_URL_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}

/**
 * Add a new audit entry into the connection audit table.
 *
 * @param string $userid The unique userid for the person making the entry
 * @param string $connnectionid The unique id for the connection begin audited
 * @param string $label The label for this connection if LinkType label overridden
 * @param string $fromIdeaID The id of the idea the connection connects from
 * @param string $toIdeaID The id of the idea the connection connects to
 * @param string $linkTypeID The id of the LinkType of this connection
 * @param string $fromRoleID The id of the Role for the idea the connection connects from
 * @param string $toRoleID The id of the Role for the idea the connection connects to
 * @param string $changeType The type of the change to the record (delete, edit, add)
 * @return booelan
 */
function auditConnection($userid, $connnectionid, $label, $fromIdeaID, $toIdeaID, $linkTypeID, $fromRoleID, $toRoleID, $changeType, $xml) {
    global $DB,$HUB_SQL;

    $wentOK = true;
    $modificationDate = time();

	$params = array();
	$params[0] = $connnectionid;
	$params[1] = $userid;
	$params[2] = $linkTypeID;
	$params[3] = $fromIdeaID;
	$params[4] = $toIdeaID;
	$params[5] = $label;
	$params[6] = $fromRoleID;
	$params[7] = $toRoleID;
	$params[8] = $modificationDate;
	$params[9] = $changeType;
	$params[10] = $xml;

    $res = $DB->insert($HUB_SQL->AUDIT_TRIPLE_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}

/**
 * Add a new audit entry into the search audit table.
 *
 * @param string $userid The unique userid for the person making the entry
 * @param string $searchtext the text searched on.
 * @param string $tagsonly was tagsonly set on the search
 * @param string $type where has the search been run from (default 'main')
 * allowed challenge/issue/solution/evidence/resource/user/userchallenge/userissue/usersolution/userevidence/userresource/usercomment
 * @param string $typeitemid this can be a userid when the search was run from a user page, or a node id when the tags search started from a node.
 * @return boolean
 */
function auditSearch($userid, $searchtext, $tagsonly, $type='main', $typeitemid='') {
    global $DB,$HUB_SQL;

    $modificationDate = time();
    $searchid = getUniqueID();

	$params = array();
	$params[0] = $searchid;
	$params[1] = $userid;
	$params[2] = $searchtext;
	$params[3] = $modificationDate;
	$params[4] = $tagsonly;
	$params[5] = $type;
	$params[6] = $typeitemid;

    $res = $DB->insert($HUB_SQL->AUDIT_SEARCH_INSERT, $params);

    if (!$res) {
        return "";
    }
    return $searchid;
}

/**
 * Add a new audit entry into the search result audit table.
 *
 * @param string $searchid The unique searchid of the search that this was the selection from.
 * @param string $userid The unique userid for the person making the entry.
 * @param string $itemid The unique userid or nodeid of the search result item selected.
 * @param boolean $isuser true/false if the itemid is a userid.
 * @return boolean
 */
function auditSearchResult($searchid, $userid, $itemid, $isuser) {
    global $DB,$HUB_SQL;
    $wentOK = true;

    $modificationDate = time();

	$params = array();
	$params[0] = $searchid;
	$params[1] = $userid;
	$params[2] = $itemid;
	$params[3] = $modificationDate;
	$params[4] = $isuser;

    $res = $DB->insert($HUB_SQL->AUDIT_SEARCH_RESULT_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}

/**
 * Add a new audit entry into the spam report audit table.
 *
 * @param string $userid The unique userid of the person who is making the report.
 * @param string $itemid The unique nodeid or userid if the item/person being reported.
 * @param string $type whether it's a node (the node type 'Claim,'Solution' etc..) or 'user'.
 * @return boolean
 */
function auditSpamReport($userid, $itemid, $type) {
    global $DB,$HUB_SQL;
    $wentOK = true;

    $creationDate = time();

	$params = array();
	$params[0] = $userid;
	$params[1] = $itemid;
	$params[2] = $creationDate;
	$params[3] = $type;

    $res = $DB->insert($HUB_SQL->AUDIT_SPAM_REPORTS_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}

/**
 * Return the userid of the most recent report against this item id.
 * There will only ever be one report active at a time,
 * but historically there could be more than one report,
 * if the admin unsets it and someone reports it again
 * Returns the UserID of the spam reporter else false.
 */
function getSpamReporter($itemid) {
    global $DB,$HUB_SQL;

	$params = array();
	$params[0] = $itemid;

	$sql = $HUB_SQL->AUDIT_SPAM_REPORTS_SELECT;
	$sql = $DB->addLimitingResults($sql, 0, 1);

    $resArray = $DB->select($sql, $params);
    if ($resArray !== false) {
    	// only expect 1 row
        return $resArray[0]["ReporterID"];
    } else {
        return false;
    }
}

/**
 * Add a new audit entry into the url audit table.
 *
 * @param string $userid The unique userid for the person making the entry
 * @param string $itemid The unique id of the item associated with this vote action (What was voted on, or the vote removed from)
 * @param string $votetype 'Y' or 'N'
 * @param string $changeType The type of the change to the record (delete, add)
 * @return booelan
 */
function auditVote($userid, $itemid, $votetype, $changeType) {
    global $DB,$HUB_SQL;

    $wentOK = true;
    $modificationDate = time();

	$params = array();
	$params[0] = $userid;
	$params[1] = $itemid;
	$params[2] = $votetype;
	$params[3] = $modificationDate;
	$params[4] = $changeType;

    $res = $DB->insert($HUB_SQL->AUDIT_VOTE_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}

/**
 * Add a new audit entry into the AuditViewNode table.
 *
 * @param string $userid The unique userid for the person making the change
 * @param string $viewid The unique id of the view.
 * @param string $nodeid The unique id of the node being affected in the view.
 * @param string $xpos the x position of the node
 * @param string $ypos the y position of the node
 * @param string $mediaIndex the media index associated with this node in this view - optional, default -1
 * @param string $changeType The type of the change to the record (delete, edit, add)
 * @return booelan
 */
function auditViewNode($userid, $viewid, $nodeid, $xpos, $ypos, $changetype, $mediaindex=-1) {
    global $DB,$HUB_SQL;

    $wentOK = true;
    $modificationDate = time();

	$params = array();
	$params[0] = $userid;
	$params[1] = $viewid;
	$params[2] = $nodeid;
	$params[3] = $modificationDate;
	$params[4] = $xpos;
	$params[5] = $ypos;
	$params[6] = $changetype;
	$params[7] = $mediaindex;

    $res = $DB->insert($HUB_SQL->AUDIT_VIEW_NODE_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}

/**
 * Add a new audit entry into the AuditViewTriple table.
 *
 * @param string $userid The unique userid for the person making the entry or en empty string (if anonymous user)
 * @param string $viewid The unique id of the view.
 * @param string $tripleid The unique id of the triple/connection being affected in the view.
 * @param string $changeType The type of the change to the record (delete, add)
 * @return booelan
 */
function auditViewTriple($userid, $viewid, $tripleid, $changetype) {
    global $DB,$HUB_SQL;

    $wentOK = true;
    $modificationDate = time();

	$params = array();
	$params[0] = $userid;
	$params[1] = $viewid;
	$params[2] = $tripleid;
	$params[3] = $modificationDate;
	$params[4] = $changetype;

    $res = $DB->insert($HUB_SQL->AUDIT_VIEW_TRIPLE_INSERT, $params);

    if (!$res) {
        $wentOK = false;
    }
    return $wentOK;
}

/**
 * Try to determine if the current call causing the audit is from a real browser/person.
 * Requires core/lib/useragent-1.0/userAgent.class.php
 *
 * @return booelan TRUE if it thinks it is a real user else FALSE.
 */
function isProbablyRealWebUser() {
	global $CFG;

    require_once($CFG->dirAddress.'core/lib/useragent-1.0/userAgent.class.php');
    $userAgent = new UserAgent();
    $isNotRealWebUser = $userAgent->isUnknown();
	return !$isNotRealWebUser;
}

/**
 * Add a new audit entry into the auditNodeView table.
 *
 * @param string $userid The unique userid for the person making the entry or en empty string (if anonymous user)
 * @param string $nodeid The unique id of the node associated with this view.
 * @param string $viewtype The type of the view to the record
 * @return booelan
 */
function auditView($userid="", $nodeid, $viewtype) {
    global $DB,$HUB_SQL;

    $wentOK = true;
	if ($userid != "" || isProbablyRealWebUser()) {
		if (isset($nodeid) && $nodeid != "") {
			$sesion = session_id();
			$ip = $_SERVER['REMOTE_ADDR'];
			$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";

			$modificationDate = time();

			$params = array();
			$params[0] = $userid;
			$params[1] = $nodeid;
			$params[2] = $modificationDate;
			$params[3] = $viewtype;
			$params[4] = $sesion;
			$params[5] = $ip;
			$params[6] = $agent;

			$res = $DB->insert($HUB_SQL->AUDIT_NODE_VIEW_INSERT, $params);

			if (!$res) {
				$wentOK = false;
			}
		}
	}
    return $wentOK;
}

/**
 * Add a new audit entry into the auditNodeView table.
 *
 * @param string $userid The unique userid for the person making the entry or en empty string (if anonymous user)
 * @param string $nodeid The unique id of the node associated with this view.
 * @param string $viewtype The type of the view to the record
 * @return booelan
 */
function auditGroupView($userid="", $groupid, $viewtype) {
    global $DB,$HUB_SQL;

    $wentOK = true;
	if ($userid != "" || isProbablyRealWebUser()) {
		if (isset($groupid) && $groupid != "") {
			$sesion = session_id();
			$ip = $_SERVER['REMOTE_ADDR'];
			$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";

			$modificationDate = time();

			$params = array();
			$params[0] = $userid;
			$params[1] = $groupid;
			$params[2] = $modificationDate;
			$params[3] = $viewtype;
			$params[4] = $sesion;
			$params[5] = $ip;
			$params[6] = $agent;

			$res = $DB->insert($HUB_SQL->AUDIT_GROUP_VIEW_INSERT, $params);

			if (!$res) {
				$wentOK = false;
			}
		}
	}
    return $wentOK;
}

/**
 * Add a new audit entry into the auditHomepageView table.
 *
 * @param string $userid The unique userid for the person making the entry or en empty string (if anonymous user)
 * @param string $nodeid The unique id of the node associated with this view.
 * @param string $viewtype The type of the view to the record
 * @return booelan
 */
function auditHomepageView($userid="") {
    global $DB,$HUB_SQL;

    $wentOK = true;
	if ($userid != "" || isProbablyRealWebUser()) {
		$sesion = session_id();
		$ip = $_SERVER['REMOTE_ADDR'];
		$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";

		$modificationDate = time();

		$params = array();
		$params[0] = $userid;
		$params[1] = $modificationDate;
		$params[2] = $sesion;
		$params[3] = $ip;
		$params[4] = $agent;

		$res = $DB->insert($HUB_SQL->AUDIT_HOMEPAGE_VIEW_INSERT, $params);

		if (!$res) {
			$wentOK = false;
		}
	}
    return $wentOK;
}

/**
 * Add a new audit entry into the audit dashboard viewtable.
 *
 * @param string $userid The unique userid for the person making the entry or en empty string (if anonymous user)
 * @param string $itemid The unique id of the node, group or the word 'global'.
 * @param string $page the dashboard page viewed
 * @return booelan
 */
function auditDashboardView($userid="", $itemid, $page) {
	global $SERVER, $DB, $HUB_SQL;

    $wentOK = true;
	if ($userid != "" || isProbablyRealWebUser()) {
		if (isset($page) && $page != "") {
			$ip = $_SERVER['REMOTE_ADDR'];
			$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
			$sesion = session_id();
			$date = time();

			$params = array();
			$params[0] = $userid;
			$params[1] = $itemid;
			$params[2] = $sesion;
			$params[3] = $ip;
			$params[4] = $agent;
			$params[5] = $date;
			$params[6] = $page;

			$res = $DB->insert($HUB_SQL->AUDIT_DASHBOARD_VIEW_INSERT, $params);

			if ($res) {
				$wentOK = true;
			}
		}
	}
    return $wentOK;
}

/**
 * Add a new audit entry into the auditTesting table.
 *
 * @param string $trialname The unique name of this test trial
 * @param string $userid The unique userid for the person making the entry or en empty string (if anonymous user)
 * @param string $itemid The unique id of the node, group or the word 'global'.
 * @param string $testelementid the identifying name for the test element being audited
 * @param string $event the triggering event that casued the audit (maybe a url clicked etc. to distinguish actions if a test element has multiple audit triggers)
 * @param string $state any state information you want to save about the test element.
 * @return booelan
 */
function auditTesting($trialname, $userid="", $itemid, $testelementid, $event, $state) {
	global $SERVER, $DB, $HUB_SQL;

    $wentOK = true;
	if ($userid != "" || isProbablyRealWebUser()) {
		if (isset($testelementid) && $testelementid != "") {
			$ip = $_SERVER['REMOTE_ADDR'];
			$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
			$sesion = session_id();
			$date = time();

			$params = array();
			$params[0] = $trialname;
			$params[1] = $userid;
			$params[2] = $itemid;
			$params[3] = $sesion;
			$params[4] = $ip;
			$params[5] = $agent;
			$params[6] = $date;
			$params[7] = $testelementid;
			$params[8] = $event;
			$params[9] = $state;

			$res = $DB->insert($HUB_SQL->AUDIT_TESTING_INSERT, $params);

			if ($res) {
				$wentOK = true;
			}
		}
	}
    return $wentOK;
}

/*** PROCESSING AUDIT RECORDS ***/

/**
 * Turn the passed string of XML from an audit record into it's datamodel object for a Connection
 * @param $xml the string of xml to convert
 * @return Connection class or an array of error messages
 */
function getConnectionFromAuditXML($xml) {
	global $LNG;
	$errors = array();

	$xmlDom = new DOMDocument();

	if (@$xmlDom->loadXML($xml) === FALSE){
        array_push($errors, $LNG->CORE_AUDIT_NOT_XML_ERROR);
	} else {
 		$connectionNodeList = $xmlDom->getElementsByTagName('connection');

		if ($connectionNodeList->length > 0) {
			$connectionNode = $connectionNodeList->item(0);

			$con = loadConnectionFromDomNode($connectionNode, $errors);
			if (empty($errors)) {
				return $con;
			}
		} else {
        	array_push($errors,$LNG->CORE_AUDIT_CONNECTION_NOT_FOUND_ERROR);
		}
	}

    return $errors;
}

/**
 * Turn the passed string of XML from an audit record into it's datamodel object for an Idea
 * @param $xml the string of xml to convert
 * @return Connection class or An array of error messages
 */
function getIdeaFromAuditXML($xml) {
	global $LNG;
	$errors = array();

	$xmlDom = new DOMDocument();
	if (!@$xmlDom->loadXML($xml)){
        array_push($errors,$LNG->CORE_AUDIT_NOT_XML_ERROR);
	} else {
		$nodeNodeList = $xmlDom->getElementsByTagName('cnode');
		if ($nodeNodeList->length > 0) {
			$nodeNode = $nodeNodeList->item(0);
			$node = loadIdeaFromDomNode($nodeNode, $errors);
			if (empty($errors)) {
				return $node;
			}
		} else {
        	array_push($errors,$LNG->CORE_AUDIT_NODE_NOT_FOUND_ERROR);
		}
	}

    return $errors;
}

/**
 * Turn the passed string of XML from an audit record into it's datamodel object for a URL
 * @param $xml the string of xml to convert
 * @return Connection class or An array of error messages
 */
function getURLFromAuditXML($xml) {
	global $LNG;
	$errors = array();

	$xmlDom = new DOMDocument();
	if (!@$xmlDom->loadXML($xml)){
        array_push($errors,$LNG->CORE_AUDIT_NOT_XML_ERROR);
	} else {
		$urlNodeList = $xmlDom->getElementsByTagName('url');
		if ($urlNodeList->length > 0) {
			$urlNode = $urlNodeList->item(0);
			$url = loadURLFromDomNode($urlNode, $errors);
			if (empty($errors)) {
				return $url;
			}
		} else {
        	array_push($errors,$LNG->CORE_AUDIT_URL_NOT_FOUND_ERROR);
		}
	}

    return $errors;
}

/**
 * Load the data for a Connection object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the Connection data
 * @param $errors the error array to pass error information back.
 * @return Connection class or NULL
 */
function loadConnectionFromDomNode($node, &$errors) {
	global $LNG;
	//array_push($errors,"HERE2");

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$connectionData = array();

		//array_push($errors,"in while");

		while ($child) {

        	//array_push($errors,$child->nodeName);

			$tag = $child->nodeName;

			if ($tag == 'connid'
				|| $tag == 'description'
				|| $tag == 'private'
				|| $tag == 'fromcontexttypeid'
				|| $tag == 'tocontexttypeid'
				|| $tag == 'creationdate'
				|| $tag == 'modificationdate'
				|| $tag == 'userid'
				|| $tag == 'positivevotes'
				|| $tag == 'negativevotes'
				|| $tag == 'uservote'
				|| $tag == 'linktypeid') {

				$connectionData[$tag] = $child->textContent;
			}

			if ($child->firstChild) {
				if ($tag == 'from' || $tag == 'to') {
					$node = loadIdeaFromDomNode($child->firstChild, $errors);
					if (empty($errors)) {
						$connectionData[$tag] = $node;
					}
				}
				if ($tag == 'fromrole' || $tag == 'torole') {
					$nodetype = loadNodeTypeFromDomNode($child->firstChild, $errors);
					if (empty($errors)) {
						$connectionData[$tag] = $nodetype;
					}
				}
				if ($tag == 'linktype') {
					$linktype = loadLinkTypeFromDomNode($child->firstChild, $errors);
					if (empty($errors)) {
						$connectionData[$tag] = $linktype;
					}
				}
				if ($tag == 'users') {
					$user = loadUserFromDomNode($child->firstChild, $errors);
					if (empty($errors)) {
						$connectionData[$tag] = $user;
					}
				}
				if ($tag == 'tags') {
					$tagsArray = array();
					$child2 = $child->firstChild;
					while ($child2) {
						$taginner = loadTagFromDomNode($child2, $errors);
						array_push($tagsArray, $taginner);
						$child2 = $child2->nextSibling;
					}

					if (empty($errors)) {
						$connectionData[$tag] = $tagsArray;
					}
				}
				if ($tag == 'groups') {
					$groupsArray = array();
					$child3 = $child->firstChild;
					while ($child3) {
						$url = loadGroupFromDomNode($child3, $errors);
						array_push($groupsArray, $url);
						$child3 = $child3->nextSibling;
					}

					if (empty($errors)) {
						$connectionData[$tag] = $groupsArray;
					}
				}
			}

			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($connectionData['connid'])) {
				$con = new Connection($connectionData['connid']);

				if (isset($connectionData['from'])) {
					$con->from = $connectionData['from'];
				}
				if (isset($connectionData['to'])) {
					$con->to = $connectionData['to'];
				}
				if (isset($connectionData['userid'])) {
					$con->userid = $connectionData['userid'];
				}
				if (isset($connectionData['users'])) {
					$con->users = array($connectionData['users']);
				}
				if (isset($connectionData['creationdate'])) {
					$con->creationdate = $connectionData['creationdate'];
				}
				if (isset($connectionData['private'])) {
					$con->private = $connectionData['private'];
				}
				if (isset($connectionData['modificationdate'])) {
					$con->modificationdate = $connectionData['modificationdate'];
				}
				if (isset($connectionData['linktype'])) {
					$con->linktype = $connectionData['linktype'];
				}
				if (isset($connectionData['fromrole'])) {
					$con->fromrole = $connectionData['fromrole'];
				}
				if (isset($connectionData['torole'])) {
					$con->torole = $connectionData['torole'];
				}
				if (isset($connectionData['description'])) {
					$con->description = $connectionData['description'];
				}
				if (isset($connectionData['fromcontexttypeid'])) {
					$con->fromcontexttypeid = $connectionData['fromcontexttypeid'];
				}
				if (isset($connectionData['tocontexttypeid'])) {
					$con->tocontexttypeid = $connectionData['tocontexttypeid'];
				}
				if (isset($connectionData['linktypeid'])) {
					$con->linktypeid = $connectionData['linktypeid'];
				}
				if (isset($connectionData['positivevotes'])) {
					$con->positivevotes = $connectionData['positivevotes'];
				}
				if (isset($connectionData['negativevotes'])) {
					$con->negativevotes = $connectionData['negativevotes'];
				}
				if (isset($connectionData['uservote'])) {
					$con->uservote = $connectionData['uservote'];
				}
				if (isset($connectionData['groups'])) {
					$con->groups = $connectionData['groups'];
				}
				if (isset($connectionData['tags'])) {
					$con->tags = $connectionData['tags'];
				}

				return $con;
			} else {
				array_push($errors,$LNG->CORE_AUDIT_CONNECTION_ID_MISSING_ERROR);
			}
		}
	 } else {
	 	array_push($errors,$LNG->CORE_AUDIT_CONNECTION_DATA_MISSING_ERROR);
	 }

	return NULL;
}

/**
 * Load the data for a Node object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the Node data
 * @param $errors the error array to pass error information back.
 * @return CNode class or NULL
 */
function loadIdeaFromDomNode($node, &$errors) {
	global $LNG;

    //array_push($errors,"IDEA:".$node->hasChildNodes());

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$nodeData = array();
		while ($child) {
			$tag = $child->nodeName;

			if ($tag == 'nodeid'
				|| $tag == 'name'
				|| $tag == 'creationdate'
				|| $tag == 'modificationdate'
				|| $tag == 'private'
				|| $tag == 'otheruserconnections'
				|| $tag == 'status'
				|| $tag == 'description'
				|| $tag == 'connectedness'
				|| $tag == 'startdatetime'
				|| $tag == 'enddatetime'
				|| $tag == 'location'
				|| $tag == 'country'
				|| $tag == 'locationlat'
				|| $tag == 'locationlng'
				|| $tag == 'imageurlid'
				|| $tag == 'imagethumbnail'
				|| $tag == 'positivevotes'
				|| $tag == 'negativevotes'
				|| $tag == 'uservote'
				|| $tag == 'userfollow'
				) {
				$nodeData[$tag] = $child->textContent;
			}

			if ($child->firstChild) {
				if ($tag == 'users') {
					$user = loadUserFromDomNode($child->firstChild, $errors);
					if (empty($errors)) {
						$nodeData[$tag] = $user;
					}
				}
				if ($tag == 'role') {
					$nodetype = loadNodeTypeFromDomNode($child->firstChild, $errors);
					if (empty($errors)) {
						$nodeData[$tag] = $nodetype;
					}
				}
				if ($tag == 'urls') {
					$urlsArray = array();
					$child2 = $child->firstChild;
					while ($child2) {
						$url = loadURLFromDomNode($child2, $errors);
						array_push($urlsArray, $url);
						$child2 = $child2->nextSibling;
					}

					if (empty($errors)) {
						$nodeData[$tag] = $urlsArray;
					}
				}
				if ($tag == 'tags') {
					$tagsArray = array();
					$child2 = $child->firstChild;
					while ($child2) {
						$tag = loadTagFromDomNode($child2, $errors);
						array_push($tagsArray, $tag);
						$child2 = $child2->nextSibling;
					}

					if (empty($errors)) {
						$nodeData['tags'] = $tagsArray;
					}
				}
				if ($tag == 'groups') {
					$groupsArray = array();
					$child3 = $child->firstChild;
					while ($child3) {
						$url = loadGroupFromDomNode($child3, $errors);
						array_push($groupsArray, $url);
						$child3 = $child3->nextSibling;
					}

					if (empty($errors)) {
						$nodeData[$tag] = $groupsArray;
					}
				}
			}


			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($nodeData['nodeid'])) {
				$nodeObj = new CNode($nodeData['nodeid']);

				if (isset($nodeData['name'])) {
					$nodeObj->name = $nodeData['name'];
				}
				if (isset($nodeData['private'])) {
					$nodeObj->private = $nodeData['private'];
				}
				if (isset($nodeData['otheruserconnections'])) {
					$nodeObj->otheruserconnections = $nodeData['otheruserconnections'];
				}
				if (isset($nodeData['status'])) {
					$nodeObj->status = $nodeData['status'];
				}
				if (isset($nodeData['connectedness'])) {
					$nodeObj->connectedness = $nodeData['connectedness'];
				}
				if (isset($nodeData['creationdate'])) {
					$nodeObj->creationdate = $nodeData['creationdate'];
				}
				if (isset($nodeData['modificationdate'])) {
					$nodeObj->modificationdate = $nodeData['modificationdate'];
				}
				if (isset($nodeData['description'])) {
					$nodeObj->description = $nodeData['description'];
				}
				if (isset($nodeData['users'])) {
					$nodeObj->users = array($nodeData['users']);
				}
				if (isset($nodeData['role'])) {
					$nodeObj->role = $nodeData['role'];
				}
				if (isset($nodeData['urls'])) {
					$nodeObj->urls = $nodeData['urls'];
				}
				if (isset($nodeData['tags'])) {
					$nodeObj->tags = $nodeData['tags'];
				}
				if (isset($nodeData['groups'])) {
					$nodeObj->groups = $nodeData['groups'];
				}
				if (isset($nodeData['startdatetime'])) {
					$nodeObj->startdatetime = $nodeData['startdatetime'];
				}
				if (isset($nodeData['enddatetime'])) {
					$nodeObj->enddatetime = $nodeData['enddatetime'];
				}
				if (isset($nodeData['location'])) {
					$nodeObj->location = $nodeData['location'];
				}
				if (isset($nodeData['country'])) {
					$nodeObj->country = $nodeData['country'];
				}
				if (isset($nodeData['locationlat'])) {
					$nodeObj->locationlat = $nodeData['locationlat'];
				}
				if (isset($nodeData['locationlng'])) {
					$nodeObj->locationlng = $nodeData['locationlng'];
				}
				if (isset($nodeData['imageurlid'])) {
					$nodeObj->imageurlid = $nodeData['imageurlid'];
				}
				if (isset($nodeData['imagethumbnail'])) {
					$nodeObj->imagethumbnail = $nodeData['imagethumbnail'];
				}
				if (isset($nodeData['positivevotes'])) {
					$nodeObj->positivevotes = $nodeData['positivevotes'];
				}
				if (isset($nodeData['negativevotes'])) {
					$nodeObj->negativevotes = $nodeData['negativevotes'];
				}
				if (isset($nodeData['uservote'])) {
					$nodeObj->uservote = $nodeData['uservote'];
				}
				if (isset($nodeData['userfollow'])) {
					$nodeObj->userfollow = $nodeData['userfollow'];
				}

				return $nodeObj;
			} else {
        		array_push($errors,$LNG->CORE_AUDIT_NODE_ID_MISSING_ERROR);
			}
		}
	} else {
        array_push($errors,$LNG->CORE_AUDIT_NODE_DATA_MISSING_ERROR);
	}

	return NULL;
}

/**
 * Load the data for a URL object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the URL data
 * @param $errors the error array to pass error information back.
 * @return URL class or NULL
 */
function loadURLFromDomNode($node, &$errors) {
	global $LNG;

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$nodeData = array();
		while ($child) {
			$tag = $child->nodeName;
			if ($tag == 'urlid'
				|| $tag == 'url'
				|| $tag == 'creationdate'
				|| $tag == 'modificationdate'
				|| $tag == 'description'
				|| $tag == 'title'
				|| $tag == 'userid'
				|| $tag == 'clip'
				|| $tag == 'ideacount'
				|| $tag == 'status'
				|| $tag == 'clippath'
				|| $tag == 'cliphtml'
				|| $tag == 'private') {
				$nodeData[$tag] = $child->textContent;
			}

			if ($child->firstChild) {
				if ($tag == 'user') {
					$user = loadUserFromDomNode($child->firstChild, $errors);
					if (empty($errors)) {
						$nodeData[$tag] = $user;
					}
				}
				if ($tag == 'tags') {
					$tagsArray = array();
					$child2 = $child->firstChild;
					while ($child2) {
						$tag = loadTagFromDomNode($child2, $errors);
						array_push($tagsArray, $tag);
						$child2 = $child2->nextSibling;
					}

					if (empty($errors)) {
						$nodeData[$tag] = $tagsArray;
					}
				}
				if ($tag == 'groups') {
					$groupsArray = array();
					$child3 = $child->firstChild;
					while ($child3) {
						$url = loadGroupFromDomNode($child3, $errors);
						array_push($groupsArray, $url);
						$child3 = $child3->nextSibling;
					}

					if (empty($errors)) {
						$nodeData[$tag] = $groupsArray;
					}
				}
			}

			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($nodeData['urlid'])) {
				$urlObj = new URL($nodeData['urlid']);

				if (isset($nodeData['url'])) {
					$urlObj->url = $nodeData['url'];
				}
				if (isset($nodeData['private'])) {
					$urlObj->private = $nodeData['private'];
				}
				if (isset($nodeData['ideacount'])) {
					$urlObj->ideacount = $nodeData['ideacount'];
				}
				if (isset($nodeData['status'])) {
					$urlObj->status = $nodeData['status'];
				}
				if (isset($nodeData['clip'])) {
					$urlObj->clip = $nodeData['clip'];
				}
				if (isset($nodeData['clippath'])) {
					$urlObj->clippath = $nodeData['clippath'];
				}
				if (isset($nodeData['cliphtml'])) {
					$urlObj->cliphtml = $nodeData['cliphtml'];
				}
				if (isset($nodeData['creationdate'])) {
					$urlObj->creationdate = $nodeData['creationdate'];
				}
				if (isset($nodeData['modificationdate'])) {
					$urlObj->modificationdate = $nodeData['modificationdate'];
				}
				if (isset($nodeData['description'])) {
					$urlObj->description = $nodeData['description'];
				}
				if (isset($nodeData['title'])) {
					$urlObj->title = $nodeData['title'];
				}
				if (isset($nodeData['userid'])) {
					$urlObj->userid = $nodeData['userid'];
				}
				if (isset($nodeData['user'])) {
					$urlObj->user = array($nodeData['user']);
				}
				if (isset($nodeData['tags'])) {
					$urlObj->tags = $nodeData['tags'];
				}
				if (isset($nodeData['groups'])) {
					$urlObj->groups = $nodeData['groups'];
				}

				return $urlObj;
			} else {
        		array_push($errors,$LNG->CORE_AUDIT_URL_ID_MISSING_ERROR);
			}
		}
	} else {
        array_push($errors,$LNG->CORE_AUDIT_URL_DATA_MISSING_ERROR);
	}

	return NULL;
}

/**
 * Load the data for a Tag object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the Tag data
 * @param $errors the error array to pass error information back.
 * @return Tag class or NULL
 */
function loadTagFromDomNode($node, &$errors) {
	global $LNG;

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$nodeData = array();
		while ($child) {
			$tag = $child->nodeName;
			if ($tag == 'tagid'
				|| $tag == 'name'
				|| $tag == 'userid'
				|| $tag == 'groupid'
				) {
				$nodeData[$tag] = $child->textContent;
			}

			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($nodeData['tagid'])) {
				$tagObj = new Tag($nodeData['tagid']);

				if (isset($nodeData['name'])) {
					$tagObj->name = $nodeData['name'];
				}
				if (isset($nodeData['userid'])) {
					$tagObj->userid = $nodeData['userid'];
				}
				if (isset($nodeData['groupid'])) {
					$tagObj->groupid = $nodeData['groupid'];
				}

				return $tagObj;
			} else {
        		array_push($errors,$LNG->CORE_AUDIT_TAG_ID_MISSING_ERROR);
			}
		}
	} else {
        array_push($errors,$LNG->CORE_AUDIT_TAG_DATA_MISSING_ERROR);
	}

	return NULL;
}

/**
 * Load the data for a User object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the User data
 * @param $errors the error array to pass error information back.
 * @return User class or NULL
 */
function loadUserFromDomNode($node, &$errors) {
	global $LNG, $CFG, $DB, $HUB_SQL, $HUB_FLM;

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$nodeData = array();
		while ($child) {
			$tag = $child->nodeName;
			if ($tag == 'userid'
				|| $tag == 'name'
				|| $tag == 'photo'
				|| $tag == 'thumb'
				|| $tag == 'lastlogin'
				|| $tag == 'status'
				|| $tag == 'isgroup'
				|| $tag == 'description'
				|| $tag == 'creationdate'
				|| $tag == 'modificationdate'
				|| $tag == 'privatedata'
				|| $tag == 'website'
				|| $tag == 'location'
				|| $tag == 'countrycode'
				|| $tag == 'country'
				|| $tag == 'locationlat'
				|| $tag == 'locationlng'
				) {
				$nodeData[$tag] = $child->textContent;
			}

			if ($child->firstChild) {
				if ($tag == 'tags') {
					$tagsArray = array();
					$child2 = $child->firstChild;
					while ($child2) {
						$taginner = loadTagFromDomNode($child2, $errors);
						array_push($tagsArray, $taginner);
						$child2 = $child2->nextSibling;
					}

					if (empty($errors)) {
						$nodeData[$tag] = $tagsArray;
					}
				}
			}

			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($nodeData['userid'])) {
				$userObj = new User($nodeData['userid']);

				// Check if Users table has OriginalID field and if so check if this userid is an old ID and adjust.
				$params = array();
				$resArray = $DB->select($HUB_SQL->AUDIT_USER_CHECK_ORIGINALID_EXISTS, $params);
				if ($resArray !== false) {

					$count = 0;
					if(is_countable($resArray)) {
						$count = count($resArray);
					}
					if ($count > 0) {
						$array = $resArray[0];
						if (isset($array['OriginalID'])) {
							$params = array();
							$params[0] = $nodeData['userid'];
							$resArray2 = $DB->select($HUB_SQL->AUDIT_USER_SELECT_ORIGINALID, $params);
							if ($resArray2 !== false) {
								$count2 = 0;
								if(is_countable($resArray2)) {
									$count2 = count($resArray2);
								}
								if ($count2 > 0) {
									$array2 = $resArray2[0];
									$userObj->olduserid = $nodeData['userid'];
									$userObj->userid = $array2['UserID'];
								}
							}
						}
					}
				}

				if (isset($nodeData['name'])) {
					$userObj->name = $nodeData['name'];
				}
				if (isset($nodeData['photo'])) {
					//rebuild stored path in case of http to https changes, or upload folder location changes.
					$url = $nodeData['photo'];
					$parts = pathinfo($url);
					$filename = $parts['basename'];
					$finalimg = "";
					if ($filename == 'profile.png') {
						$finalimg = $HUB_FLM->getUploadsWebPath($filename);
					} else {
						$finalimg = $HUB_FLM->getUploadsWebPath($userObj->userid."/".$filename);
					}
					$userObj->photo = $finalimg;
				}
				if (isset($nodeData['thumb'])) {
					//rebuild stored path in case of http to https changes, or upload folder location changes.
					$url = $nodeData['thumb'];
					$parts = pathinfo($url);
					$filename = $parts['basename'];
					$finalimg = "";
					if ($filename == 'profile_thumb.png') {
						$finalimg = $HUB_FLM->getUploadsWebPath($filename);
					} else {
						$finalimg = $HUB_FLM->getUploadsWebPath($userObj->userid."/".$filename);
					}
					$userObj->thumb = $finalimg;
				}
				if (isset($nodeData['lastlogin'])) {
					$userObj->lastlogin = $nodeData['lastlogin'];
				}
				if (isset($nodeData['website'])) {
					$userObj->website = $nodeData['website'];
				}
				if (isset($nodeData['status'])) {
					$userObj->setStatus($nodeData['status']);
				}
				if (isset($nodeData['isgroup'])) {
					$userObj->isgroup = $nodeData['isgroup'];
				}
				if (isset($nodeData['description'])) {
					$userObj->description = $nodeData['description'];
				}
				if (isset($nodeData['creationdate'])) {
					$userObj->creationdate = $nodeData['creationdate'];
				}
				if (isset($nodeData['modificationdate'])) {
					$userObj->modificationdate = $nodeData['modificationdate'];
				}
				if (isset($nodeData['privatedata'])) {
					$userObj->privatedata = $nodeData['privatedata'];
				}
				if (isset($nodeData['location'])) {
					$userObj->location = $nodeData['location'];
				}
				if (isset($nodeData['countrycode'])) {
					$userObj->countrycode = $nodeData['countrycode'];
				}
				if (isset($nodeData['country'])) {
					$userObj->country = $nodeData['country'];
				}
				if (isset($nodeData['locationlat'])) {
					$userObj->locationlat = $nodeData['locationlat'];
				}
				if (isset($nodeData['locationlng'])) {
					$userObj->locationlng = $nodeData['locationlng'];
				}
				if (isset($nodeData['tags'])) {
					$userObj->tags = $nodeData['tags'];
				}

				return $userObj;
			} else {
        		array_push($errors,$LNG->CORE_AUDIT_USER_ID_MISSING_ERROR);
			}
		}
	} else {
        array_push($errors,$LNG->CORE_AUDIT_USER_DATA_MISSING_ERROR);
	}

	return NULL;
}

/**
 * Load the data for a Group object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the group data
 * @param $errors the error array to pass error information back.
 * @return Group class or NULL
 */
function loadGroupFromDomNode($node, &$errors) {
	global $LNG, $DB, $HUB_SQL, $HUB_FLM;

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$nodeData = array();
		while ($child) {
			$tag = $child->nodeName;
			if ($tag == 'groupid'
				|| $tag == 'name'
				|| $tag == 'description'
				|| $tag == 'website'
				|| $tag == 'thumb'
				|| $tag == 'photo'
				|| $tag == 'location'
				|| $tag == 'countrycode'
				|| $tag == 'country'
				|| $tag == 'locationlat'
				|| $tag == 'locationlng'
				) {
				$nodeData[$tag] = $child->textContent;
			}

			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($nodeData['groupid'])) {
				$groupObj = new Group($nodeData['groupid']);

				// Check if Users table has OriginalID field and if so check if this userid is an old ID and adjust.
				$params = array();
				$resArray = $DB->select($HUB_SQL->AUDIT_USER_CHECK_ORIGINALID_EXISTS, $params);
				if ($resArray !== false) {
					$count = 0;
					if(is_countable($resArray)) {
						$count = count($resArray);
					}
					if ($count > 0) {
						$array = $resArray[0];
						if (isset($array['OriginalID'])) {
							$params = array();
							$params[0] = $nodeData['groupid'];
							$resArray2 = $DB->select($HUB_SQL->AUDIT_USER_SELECT_ORIGINALID, $params);
							if ($resArray2 !== false) {
								$count2 = 0;
								if(is_countable($resArray2)) {
									$count2 = count($resArray2);
								}
								if ($count2 > 0) {
									$array2 = $resArray2[0];
									$groupObj->oldid = $nodeData['groupid'];
									$groupObj->groupid = $array2['UserID'];
								}
							}
						}
					}
				}

				if (isset($nodeData['name'])) {
					$groupObj->name = $nodeData['name'];
				}
				if (isset($nodeData['description'])) {
					$groupObj->description = $nodeData['description'];
				}
				if (isset($nodeData['website'])) {
					$groupObj->website = $nodeData['website'];
				}
				if (isset($nodeData['photo'])) {
					//rebuild stored path in case of http to https changes, or upload folder location changes.
					$url = $nodeData['photo'];
					$parts = pathinfo($url);
					$filename = $parts['basename'];
					$finalimg = "";
					if ($filename == 'groupprofile.png') {
						$finalimg = $HUB_FLM->getUploadsWebPath($filename);
					} else {
						$finalimg = $HUB_FLM->getUploadsWebPath($groupObj->groupid."/".$filename);
					}
					$groupObj->photo = 	$finalimg;
				}
				if (isset($nodeData['thumb'])) {
					//rebuild stored path in case of http to https changes, or upload folder location changes.
					$url = $nodeData['thumb'];
					$parts = pathinfo($url);
					$filename = $parts['basename'];
					$finalimg = "";
					if ($filename == 'groupprofile_thumb.png') {
						$finalimg = $HUB_FLM->getUploadsWebPath($filename);
					} else {
						$finalimg = $HUB_FLM->getUploadsWebPath($groupObj->groupid."/".$filename);
					}
					$groupObj->thumb = $finalimg;
				}
				if (isset($nodeData['location'])) {
					$groupObj->location = $nodeData['location'];
				}
				if (isset($nodeData['countrycode'])) {
					$groupObj->countrycode = $nodeData['countrycode'];
				}
				if (isset($nodeData['country'])) {
					$groupObj->country = $nodeData['country'];
				}
				if (isset($nodeData['locationlat'])) {
					$groupObj->locationlat = $nodeData['locationlat'];
				}
				if (isset($nodeData['locationlng'])) {
					$groupObj->locationlng = $nodeData['locationlng'];
				}

				return $groupObj;
			} else {
        		array_push($errors,$LNG->CORE_AUDIT_GROUP_ID_MISSING_ERROR);
			}
		}
	} else {
        array_push($errors, $LNG->CORE_AUDIT_GROUP_DATA_MISSING_ERROR);
	}

	return NULL;
}

/**
 * Load the data for a NodeType object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the nodetype data
 * @param $errors the error array to pass error information back.
 * @return Role class or NULL
 */
function loadNodeTypeFromDomNode($node, &$errors) {
	global $LNG;

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$nodeData = array();
		while ($child) {
			$tag = $child->nodeName;
			if ($tag == 'roleid') {
				// for correcting old ids which had spaces which have now been removed
				$nodetypeid = $child->textContent;
				$nodetypeid = str_replace(' ', '_',  $nodetypeid);
				$nodeData[$tag] = $nodetypeid;
			} else if ($tag == 'name'
				|| $tag == 'userid'
				|| $tag == 'groupid'
				|| $tag == 'image') {
				$nodeData[$tag] = $child->textContent;
			}

			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($nodeData['roleid'])) {
				$roleObj = new Role($nodeData['roleid']);

				if (isset($nodeData['name'])) {
					$roleObj->name = $nodeData['name'];
				}
				if (isset($nodeData['userid'])) {
					$roleObj->userid = $nodeData['userid'];
				}
				if (isset($nodeData['groupid'])) {
					$roleObj->groupid = $nodeData['groupid'];
				}
				if (isset($nodeData['image'])) {
					$roleObj->image = $nodeData['image'];
				}

				return $roleObj;
			} else {
        		array_push($errors,$LNG->CORE_AUDIT_ROLE_ID_MISSING_ERROR);
			}
		}
	} else {
        array_push($errors,$LNG->CORE_AUDIT_ROLE_DATA_MISSING_ERROR);
	}

	return NULL;
}

/**
 * Load the data for a LinkType object from a DomNode and create and return the object
 *
 * @param node the DomNode object holding the linktype data
 * @param $errors the error array to pass error information back.
 * @return LinkType class or NULL
 */
function loadLinkTypeFromDomNode($node, &$errors) {
	global $LNG;

	if ($node->hasChildNodes()) {
		$child = $node->firstChild;

		$nodeData = array();
		while ($child) {
			$tag = $child->nodeName;
			if ($tag == 'linktypeid'
				|| $tag == 'label'
				|| $tag == 'userid'
				|| $tag == 'groupid'
				|| $tag == 'grouplabel') {
				$nodeData[$tag] = $child->textContent;
			}

			$child = $child->nextSibling;
		}

		if (empty($errors)) {
			if (isset($nodeData['linktypeid'])) {
				$linktypeObj = new LinkType($nodeData['linktypeid']);

				if (isset($nodeData['label'])) {
					$linktypeObj->label = $nodeData['label'];
				}
				if (isset($nodeData['userid'])) {
					$linktypeObj->userid = $nodeData['userid'];
				}
				if (isset($nodeData['groupid'])) {
					$linktypeObj->groupid = $nodeData['groupid'];
				}
				if (isset($nodeData['grouplabel'])) {
					$linktypeObj->grouplabel = $nodeData['grouplabel'];
				}

				return $linktypeObj;
			} else {
        		array_push($errors,$LNG->CORE_AUDIT_LINK_ID_MISSING_ERROR);
			}
		}
	} else {
        array_push($errors,$LNG->CORE_AUDIT_LINK_DATA_MISSING_ERROR);
	}

	return NULL;
}
?>