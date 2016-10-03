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
 *
 * Evidence Hub API functions
 *
 * <p>This page describes the services currently available through the Evidence Hub API. The service base URL depends on your Hub subdomain, for example:
 * <pre>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php">http://edfutures.evidence-hub.net/api/service.php</a>
 * </pre>
 * where 'edfutures' should be replaced with your subdomain name. The service URL will always require a 'method' parameter.</p>
 *
 * <p>In all service calls, an optional parameter 'format' can be provided
 * to set how the output is displayed, the default is 'xml', but other options currently are 'gmap','json','list','rdf','rss', 'shortxml' and 'simile'.
 * Not all formats are available with all methods, as explained below:</p>
 * <ul>
 * <li>'xml', 'json' and 'rdf' formats are available to all methods</li>
 * <li>'rss' and 'shortxml' formats are only available to methods which return a NodeSet or ConnectionSet
 * <li>'gmap' and 'simile' formats are only available to methods which return a NodeSet.</li>
 * <li>'list' format is available to methods which return a NodeSet or a TagSet.</li>
 * </ul>
 *<span> If you specify 'json' as the output format, then you can (optionally) provide a parameter 'callback'.</span>
 *<br>
 *
 * <p>Although all the example services calls show the parameters passed as GET requests, parameters will be accepted as either GET or POST -
 * so the parameters can be provided in any order - not just the order in which they've been listed on this page.</p>
 *
 * <p>Some services require a valid user login to work (essentially any add, edit or delete method) and in these cases, when you call
 * the service, you must also provide a valid Evidence Hub session cookie, this can be obtained by calling the login service.
 * If you are calling the services via your web browser, you won't need to worry much about this, as your browser will automatically store and send
 * the cookie with each service call.</p>
 *
 * <p>If you are using a script to automate requests such as add or delete nodes, then rather than grabbing and resending the cookies,
 * you can obtain the sessionid from the userlogin request and then append this to each subsequent request by adding PHPSESSID={your-session-id} as an extra parameter.</p>
 *
 * <p>Example service calls (replace start of URL with your Evidence hub url):
 * <pre>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnode&amp;nodeid=131211811270778613001206700042870488149">http://edfutures.evidence-hub.net/api/service.php?method=getnode&amp;nodeid=131211811270778613001206700042870488149</a>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093">http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093</a>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=json">http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=json</a>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=rdf">http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=rdf</a>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=xml">http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=xml</a>
 * </pre>
 * </p>
 * <p>Example calls are given below for each service and it is noted which services require the user to be logged in</p>
 * <p>Note that if any required parameters are missing from a service call, then an error object will be returned detailing the missing parameter.</p>
 *
 * <p>For any datetime parameter the following formats will be accepted:</p>
 * <ul>
 * <li>14 May 2008</li>
 * <li>14-05-2008</li>
 * <li>14 May 2008 9:00</li>
 * <li>14 May 2008 9:00PM</li>
 * <li>14-05-2008 9:00PM</li>
 * <li>9:00</li>
 * <li>14 May</li>
 * <li>wed</li>
 * <li>wed 9:00</li>
 * </ul>
 * <p>and the following formats would not be accepted:</p>
 * <ul>
 * <li>14 05 2008</li>
 * <li>14/05/2008</li>
 * <li>14 05 2008 9:00</li>
 * <li>14/05/2008 9:00</li>
 * <li>14-05</li>
 * </ul>
 *
 * <p>Do not forget to encode all parameters sent on the api call. This link may be helpful for this: <a href="http://www.w3schools.com/tags/ref_urlencode.asp"/>http://www.w3schools.com/tags/ref_urlencode.asp</a></p>
 */

/**
 * @ignore
 */
require_once('accesslib.php');
/**
 * @ignore
 */
require_once('utillib.php');
/**
 * @ignore
 */
require_once('formatlib.php');
/**
 * @ignore
 */
require_once('datamodel/node.class.php');
/**
 * @ignore
 */
require_once('datamodel/nodeset.class.php');
/**
 * @ignore
 */
require_once('datamodel/url.class.php');
/**
 * @ignore
 */
require_once('datamodel/urlset.class.php');
/**
 * @ignore
 */
require_once('datamodel/user.class.php');
/**
 * @ignore
 */
require_once('datamodel/userset.class.php');
/**
 * @ignore
 */
require_once('datamodel/result.class.php');
/**
 * @ignore
 */
require_once('datamodel/connection.class.php');
/**
 * @ignore
 */
require_once('datamodel/connectionset.class.php');
/**
 * @ignore
 */
require_once('datamodel/role.class.php');
/**
 * @ignore
 */
require_once('datamodel/roleset.class.php');
/**
 * @ignore
 */
require_once('datamodel/linktype.class.php');
/**
 * @ignore
 */
require_once('datamodel/linktypeset.class.php');
/**
 * @ignore
 */
require_once('datamodel/tag.class.php');
/**
 * @ignore
 */
require_once('datamodel/tagset.class.php');
/**
 * @ignore
 */
require_once('datamodel/voting.class.php');
/**
 * @ignore
 */
require_once('datamodel/following.class.php');
/**
 * @ignore
 */
require_once('datamodel/activity.class.php');
/**
 * @ignore
 */
require_once('datamodel/activityset.class.php');
/**
 * @ignore
 */
require_once('datamodel/userauthentication.class.php');

/**
 * @ignore
 */
require_once('datamodel/group.class.php');
/**
 * @ignore
 */
require_once('datamodel/groupset.class.php');
/**
 * @ignore
 */
require_once('datamodel/view.class.php');
/**
 * @ignore
 */
require_once('datamodel/viewnode.class.php');
/**
 * @ignore
 */
require_once('datamodel/viewconnection.class.php');
/**
 * @ignore
 */
require_once('datamodel/viewset.class.php');


///////////////////////////////////////////////////////////////////
// functions for nodes
///////////////////////////////////////////////////////////////////

/**
 * Vote for the node with the given nodeid
 *
 * @param string $nodeid
 * @param string $vote to make ('Y' vote or 'N' vote);
 * @return Node or Error
 */
function nodeVote($nodeid,$vote){
    $n = new CNode($nodeid);
    return $n->vote($vote);
}

/**
 * Delete Vote for the node with the given nodeid
 *
 * @param string $nodeid
 * @param string $vote to delete ('Y' vote or 'N' vote);
 * @return Node or Error
 */
function deleteNodeVote($nodeid,$vote){
    $n = new CNode($nodeid);
    return $n->deleteVote($vote);
}

/**
 * Get all the Votes for the object with the given itemid
 *
 * @param string $itemid
 * @return Voting or Error
 */
function getVotes($itemid) {
    $n = new Voting($itemid);
    return $n->load();
}

/**
 * Get a node
 *
 * @param string $nodeid
 * @param string $style (optional - default 'long') may be 'short' or 'long'
 * @return Node or Error
 */
function getNode($nodeid,$style='long'){
    $n = new CNode($nodeid);
    return $n->load($style);
}

/**
 * Add a node. Requires login
 *
 * @param string $name
 * @param string $desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $nodetypeid optional, the id of the nodetype this node is, defaults to 'Idea' node type id.
 * @param string $imageurlid optional, the urlid of the url for the image that is being used as this node's icon
 * @param string $imagethumbnail optional, the local server path to the thumbnail of the image used for this node
 *
 * @return Node or Error
 */
function addNode($name,$desc,$private="",$nodetypeid="",$imageurlid="",$imagethumbnail=""){
    global $USER;
    if($private == ""){
        $private = $USER->privatedata;
    }

    $n = new CNode();
    $node = $n->add($name,$desc,$private,$nodetypeid,$imageurlid,$imagethumbnail);
    return $node;
}

/**
 * Add a node. Requires login
 *
 * @param string $name
 * @param string $desc
 * @param string $nodetypename, the name of the nodetype this node is.
 * @param string $focalnodeid, the id of the node to connect this new node to.
 * @param string $direction optional, whether the new node is a 'from' or 'to' in the connection. The focalnode then becomes the other end. Defaults to 'from';
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $groupid optional, the id of any group to add the new node and the new connection to.
 * @param string $imageurlid optional, the urlid of the url for the image that is being used as this node's icon
 * @param string $imagethumbnail optional, the local server path to the thumbnail of the image used for this node
 *
 * @return Node or Error
 */
function addNodeAndConnect($name,$desc,$nodetypename,$focalnodeid,$linktypename,$direction="from",$groupid="",$private="N",$imageurlid="",$imagethumbnail="", $resources=""){
    global $USER, $CFG;
    if($private == ""){
        $private = $USER->privatedata;
    }
	$conndesc = "";

	// if groupid given, check current user in group before going any further.
	if ($groupid != "") {
		$group = new Group($groupid);
		if (!$group instanceof Error) {
			if (!$group->ismember($USER->userid)) {
				$error = new Error();
				return $error->createNotInGroup($group->name);
			}
		} else {
			return $group;
		}
	}

	$r = getRoleByName($nodetypename);

	if (!$r instanceof Error) {
		$nodetypeid = $r->roleid;

		$n = new CNode();
		$node = $n->add($name,$desc,$private,$nodetypeid,$imageurlid,$imagethumbnail);

		if (!$node instanceof Error) {
			// Add to group
			if (isset($groupid) && $groupid != "") {
				addGroupToNode($node->nodeid,$groupid);
			}

			foreach($resources as $url) {
				$url = trim($url);
				if ($url != "") {

					$urlobj = new URL();
					$urlobj = $urlobj->add($url, $title, "", $private, "", "");
					if (!$urlobj instanceof Error) {
						$node->addURL($urlobj->urlid, "");
					} else {
						return $urlobj;
					}
				}
			}

			// Connect to focal node
			$focalnode = new CNode($focalnodeid);
			$focalnode = $focalnode->load();
			if (!$focalnode instanceof Error) {

				$focalrole = getRoleByName($focalnode->role->name);
				$focalroleid = $focalrole->roleid;

				$lt = getLinkTypeByLabel($linktypename);
				$linkType = $lt->linktypeid;

				if ($direction == 'from') {
					$connection = addConnection($node->nodeid, $nodetypeid, $linkType, $focalnodeid, $focalroleid, $private, $conndesc);
				} else {
					$connection = addConnection($focalnodeid, $focalroleid, $linkType, $node->nodeid, $nodetypeid, $private, $conndesc);
				}
				if (!$connection instanceof Error) {
					// add to group
					if (isset($groupid) && $groupid != "") {
						addGroupToConnection($connection->connid,$groupid);
					}
				}
				return $connection;
			} else {
				return $focalnode;
			}
		} else {
			return $node;
		}
	} else {
		return $r;
	}
}


/**
 * Edit a node. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string name
 * @param string desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $nodetypeid optional, the id of the nodetype this node is, defaults to current node type id.
 * @param string $imageurlid optional, the urlid of the url for the image that is being used as this node's icon
 * @param string $imagethumbnail optional, the local server path to the thumbnail of the image used for this node
 * @return Node or Error
 */
function editNode($nodeid,$name,$desc,$private="",$nodetypeid="",$imageurlid="",$imagethumbnail="",$resources=""){
    global $USER;
    if($private == ""){
        $private = $USER->privatedata;
    }

    $n = new CNode($nodeid);
    $n = $n->load();
    $node = $n->edit($name,$desc,$private,$nodetypeid,$imageurlid,$imagethumbnail);

    if (isset($resources) && $resources !== "" && count($resources) > 0) {

		// remove all the existing urls
		$node = $node->removeAllURLs();

		// add new ones
		foreach($resources as $url) {
			$url = trim($url);
			if ($url != "") {
				// TOO SLOW
				//$urlObj = autoCompleteURLDetails($url);
				//$title = $urlObj->title;
				//$desc = $urlObj->desc;
				//if ($title == "") {
				$title = $url;
				//}

				$urlobj = new URL();
				$urlobj = $urlobj->add($url, $title, "", $private, "", "");
				if (!$urlobj instanceof Error) {
					$node->addURL($urlobj->urlid, "");
				} else {
					return $urlobj;
				}
			}
		}
    }

    return $node;
}

/**
 * update a node start date. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string $startdatetime optional text representation of start date and/or time

 * @return Node or Error
 */
function updateNodeStartDate($nodeid,$startdatetime){
    global $USER;
    $n = new CNode($nodeid);
    $n = $n->load();
    $node = $n->updateStartDate($startdatetime);
    return $node;
}

/**
 * Update a node end date. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string $enddatetime optional text representation of start date and/or time
 * @return Node or Error
 */
function updateNodeEndDate($nodeid,$enddatetime){
    global $USER;
    $n = new CNode($nodeid);
    $n = $n->load();
    $node = $n->updateEndDate($enddatetime);
    return $node;
}

/**
 * Update a node role/type. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string $nodetypename the node type/role label to update this node to
 * @return Node or Error
 */
function updateNodeRole($nodeid,$nodetypename){
    global $USER;
    $n = new CNode($nodeid);
    $n = $n->load();
    $node = $n->updateRole($nodetypename);
    return $node;
}

/**
 * update a node location. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string $location the the or city (optional)
 * @param string $loccountry the country (optional)
 * @param string $address1 the first line of an addres e.g. house and stree (optional)
 * @param string $address2 the second line of an address, e.g. area (optional)
 * @param string $postcode the postal code of zip code (optional)
 * @return Node or Error
 */
function updateNodeLocation($nodeid,$location,$loccountry,$address1,$address2,$postcode){
    global $USER;
    $n = new CNode($nodeid);
    $n = $n->load();
    $node = $n->updateLocation($location,$loccountry,$address1,$address2,$postcode);
    return $node;
}


/**
 * Delete a node. Requires login and user must be owner of the node.
 *
 * @param string $nodeid
 * @return Result or Error
 */
function deleteNode($nodeid){
    $n = new CNode($nodeid);
    $result = $n->delete();
    return $result;
}

/**
 * Get the nodes the current user has permission to see.
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @param string $connectionfilter filter by connections. Defaults to empty string which means disregard connection count. Possible values; '','connected','unconnected'.
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $style='long',$q='', $scope='all',$tagsonly=false, $connectionfilter='',$status=0) {
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$sql = $HUB_SQL->APILIB_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// SEARCH
	if (isset($q) && $q != "") {
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
        	$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
 		       	$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	if ($connectionfilter == 'unconnected') {
		$sql .= $HUB_SQL->APILIB_HAVING_UNCONNECTED;
	} else if ($connectionfilter == 'connected') {
		$sql .= $HUB_SQL->APILIB_HAVING_CONNECTED;
	}

	//error_log("Search=".$sql);

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given user
 *
 * @param string $userid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20), -1 means all
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $connectionfilter filter by connections. Defaults to empty string which means disregard connection count. Possible values; '','connected','unconnected'.
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByUser($userid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $style='long', $q="", $connectionfilter='',$status=0){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER BY USER
	$params[count($params)] = $userid;
    $sql .= $HUB_SQL->FILTER_USER;

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
    $sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	// SEARCH
    if (isset($q) && $q != "") {
    	$querySQL = getSearchQueryString($params,$q, true, true);
    	$sql .= $HUB_SQL->AND.$querySQL;
 	}

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	if ($connectionfilter == 'unconnected') {
		$sql .= $HUB_SQL->APILIB_HAVING_UNCONNECTED;
	} else if ($connectionfilter == 'connected') {
		$sql .= $HUB_SQL->APILIB_HAVING_CONNECTED;
	}

	//echo $sql;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given date
 *
 * @param integer $date
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByDate($date,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $style='long',$status=0){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $date;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;

    $sql = $HUB_SQL->APILIB_NODES_BY_DATE;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given name
 *
 * @param string $name
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByName($name,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $style='long',$status=0){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $name;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;

    $sql = $HUB_SQL->APILIB_NODES_BY_NAME;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Searches nodes by node name based on the first chartacters
 *
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'all' or 'my' - default: 'my')
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByFirstCharacters($q,$scope,$start = 0,$max = 20 ,$orderby = 'name',$sort ='ASC', $filternodetypes="", $style='long',$status=0){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$q = trim($q);
	$q = $DB->cleanString($q);

	$sql = $HUB_SQL->APILIB_NODES_BY_FIRST_CHARACTERS_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
		}
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
        $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;

        $sql .= $HUB_SQL->APILIB_NODE_NAME_STARTING_SEARCH;
        $sql .= $q;
        $sql .= $HUB_SQL->SEARCH_LIKE_FROM_END;
    } else {
        $sql .= $HUB_SQL->APILIB_NODE_NAME_STARTING_SEARCH;
        $sql .= $q;
        $sql .= $HUB_SQL->SEARCH_LIKE_FROM_END;
    }

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	// PERMISSIONS
    if ($scope == 'my') {
    	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	$sql .= $HUB_SQL->APILIB_NODES_BY_FIRST_CHARACTERS_PART4;

	//echo $sql;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given tagid
 *
 * @param string $tagid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByTag($tagid, $start = 0,$max = 20 ,$orderby = 'date', $sort ='ASC', $style='long', $status=0){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $tagid;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;

    $sql = $HUB_SQL->APILIB_NODES_BY_TAG;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style,$style);
}

/**
 * Get the nodes for given url
 * (note that this uses the actual URL rather than the urlid)
 *
 * @param string $url
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByURL($url,$start = 0,$max = 20 ,$orderby = 'date', $sort ='ASC', $filternodetypes="", $style='long',$status=0){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_NODES_BY_URL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
		}
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
        $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	$params[count($params)] = $url;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_NODES_BY_URL_PERMISSIONS;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	//echo $sql;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style,$style);
}

/**
 * Get the nodes for given part of a url
 * (note that this uses the actual URL rather than the urlid)
 *
 * @param string $q part of the url part to search by (usually for domain matching)
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByURLSearch($q, $start = 0,$max = 20 ,$orderby = 'date', $sort ='ASC', $filternodetypes="", $style='long',$status=0){
    global $USER,$CFG,$HUB_SQL,$DB;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_NODES_BY_URL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
		}
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
        $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// SEARCH
	$pieces = explode(" ", $q);
	$loopCount = 0;
	$search = "";
	foreach ($pieces as $value) {
		$value = trim($value);
		$value = $DB->cleanString($value);

		if ($value != "") {
			if ($loopCount > 0) {
				$search .= $HUB_SQL->OR;
			}
			$search .= $HUB_SQL->OPENING_BRACKET;
			$search .= $HUB_SQL->UTILLIB_SEARCH_URL_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;
			$search .= $HUB_SQL->CLOSING_BRACKET;
			$loopCount++;
		}
	}
	$sql .= "( ".$search." )";

	$sql .= $HUB_SQL->AND;

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_NODES_BY_URL_SEARCH_PERMISSIONS;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	//error_log("FRED".print_r($sql, true));

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style,$style);
}

/**
 * Get all nodes from the given list of node ids.
 *
 * @param String $nodeids a comma separated list of the node ids to get.
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: -1 = all)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return NodeSet or Error
 */
function getMultiNodes($nodeids, $start = 0,$max = -1 ,$orderby = 'date',$sort ='ASC', $style='long') {
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// Loop through list of connection ids and add to array
	$pieces = explode(",", $nodeids);
	$loopCount = 0;
	$ids = "";
	foreach ($pieces as $value) {
		$value = trim($value);
		$params[count($params)] = $value;

		if ($loopCount == 0) {
			$ids .= "?";
		} else {
			$ids .= ",?";
		}
		$loopCount++;
	}

	$sql = $HUB_SQL->APILIB_NODES_BY_MULTI_SELECT_PART1;
	$sql .= $ids;
	$sql .= $HUB_SQL->APILIB_NODES_BY_MULTI_SELECT_PART2;

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
    $sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes with connections of the specified type for the given parameters
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param string $q the query term(s)
 * @param boolean $includeunconnected (optional - default false) may be true or false
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getConnectedNodesByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $q="", $includeunconnected=false, $status=0){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$sql = $HUB_SQL->APILIB_CONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
	if ($filternodetypes != "") {
		$innersql = getSQLForNodeTypeIDsForLabels($params,$filternodetypes);
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART1;
		$sql .= $innersql;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART2;
	}

	// SEARCH
	if ($q != "") {
		$querySQL = getSearchQueryString($params,$q, true, true);
		$sql .= $querySQL;
		if ($querySQL != "") {
			$sql .= $HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;


	$sql.= $HUB_SQL->AND.$HUB_SQL->OPENING_BRACKET;

	// INCLUDE UNCONNECTED
	if ($includeunconnected) {
		$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	}

	// FILTER LINK TYPE
	$innersqlfilter = "";
	$linklist = array();
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersqlfilter = getSQLForLinkTypeIDsForGroup($linklist,$filtergroup);
	} else {
		$innersqlfilter = getSQLForLinkTypeIDsForLabels($linklist,$filterlist);
	}
	if ($innersqlfilter != "") {
		if ($includeunconnected) {
			$sql .= " ".$HUB_SQL->OR." ";
		}
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART1;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART2;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART3;
	}

	$sql .= $HUB_SQL->CLOSING_BRACKET;

	//echo $sql;

    $cs = new NodeSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes with connections of the specified type for the given parameters (or no connections if requested)
 *
 * @param string $userid, the id of the user to get the nodes for.
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $style (optional - default 'long') may be 'short' or 'long'
 * @param string $q the query term(s)
 * @param boolean $includeunconnected (optional - default false) may be true or false
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getConnectedNodesByUser($userid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $q="", $includeunconnected=false, $status=0){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$sql = $HUB_SQL->APILIB_CONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER BY USER
	$params[0] = $userid;
	$sql .= $HUB_SQL->FILTER_USER.$HUB_SQL->AND;

	// FILTER NODE TYPES
	if ($filternodetypes != "") {
		$innersql = getSQLForNodeTypeIDsForLabels($params,$filternodetypes);
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART1;
		$sql .= $innersql;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART2;
	}

	// SEARCH
	if ($q != "") {
		$querySQL = getSearchQueryString($params,$q, true, true);
		$sql .= $querySQL;
		if ($querySQL != "") {
			$sql .= $HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;


	$sql.= $HUB_SQL->AND.$HUB_SQL->OPENING_BRACKET;

	// INCLUDE UNCONNECTED
	if ($includeunconnected) {
		$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	}

	// FILTER LINK TYPE
	$innersqlfilter = "";
	$linklist = array();
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersqlfilter = getSQLForLinkTypeIDsForGroup($linklist,$filtergroup);
	} else {
		$innersqlfilter = getSQLForLinkTypeIDsForLabels($linklist,$filterlist);
	}
	if ($innersqlfilter != "") {
		if ($includeunconnected) {
			$sql .= $HUB_SQL->OR;
		}
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART1;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART2;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART3;
	}

	$sql .= $HUB_SQL->CLOSING_BRACKET;

	//echo $sql;

    $cs = new NodeSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes not connected to anything the current user has permission to see.
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getUnconnectedNodesByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $style='long',$q='', $scope='all',$tagsonly=false, $status=0) {
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_UNCONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER ON NO CONNECTIONS
	$sql .= $HUB_SQL->APILIB_NODES_NO_CONNECTIONS;
	$sql .= $HUB_SQL->AND;
	$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	$sql .= $HUB_SQL->AND;

	// SEARCH
	if (isset($q) && $q != "") {
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
        	$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
 		       	$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	// ORDER BY VOTE
	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	//echo $sql;

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes not connected to anything for the given user, that current user has permission to see.
 *
 * @param string $userid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getUnconnectedNodesByUser($userid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $style='long',$q='', $scope='all',$tagsonly=false, $status=0) {
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_UNCONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER ON USER ID
    $params[count($params)] = $userid;
	$sql .= $HUB_SQL->FILTER_USER;
	$sql .= $HUB_SQL->AND;

	// FILTER ON NO CONNECTIONS
	$sql .= $HUB_SQL->APILIB_NODES_NO_CONNECTIONS;
	$sql .= $HUB_SQL->AND;
	$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	$sql .= $HUB_SQL->AND;

	// SEARCH
	if (isset($q) && $q != "") {
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
        	$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
 		       	$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	// ORDER BY VOTE
	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	//echo $sql;

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get nodes which are most connected to other nodes
 *
 * @param string $scope (optional, either 'all' or 'my' - default 'all' )
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getMostConnectedNodes($scope='all', $start = 0,$max = 20, $style='long',$status=0){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_MOST_CONNECTED_NODES_SELECT;
	$sql .= $HUB_SQL->WHERE;

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,'connectedness','DESC',$style);
}

function mergeSelectedNodes($issuenodeid,$groupid,$ids,$title,$desc) {
	global $CFG;

	$mainConnections = getConnectionsByNode($issuenodeid,0,-1,'date','ASC', 'all', '', 'Solution');
	$mainconns = $mainConnections->connections;

	$r = getRoleByName("Solution");
	$rolesolution = $r->roleid;

	// CREATE THE solution NODE
	$solutionnode = addNode($title,$desc, 'N', $rolesolution);
	if (!$solutionnode instanceof Error) {

		// Add to group
		if (isset($groupid) && $groupid != "") {
			addGroupToNode($solutionnode->nodeid,$groupid);
		}

		// CONNECT NODE TO FOCAL
		$node = getNode($issuenodeid);
		$r = getRoleByName($node->role->name);
		$focalroleid = $r->roleid;
		$lt = getLinkTypeByLabel($CFG->LINK_SOLUTION_ISSUE);
		$linkType = $lt->linktypeid;
		$conndesc = "";

		$connection = addConnection($solutionnode->nodeid, $rolesolution, $linkType, $issuenodeid, $focalroleid, "N", $conndesc);

		if (!$connection instanceof Error) {

			// add to group
			if (isset($groupid) && $groupid != "") {
				addGroupToConnection($connection->connid,$groupid);
			}

			// CONNECT NEW NODE TO SELECT NODES
			$lt2 = getLinkTypeByLabel($CFG->LINK_COMMENT_BUILT_FROM);
			$linkTypeBuiltFrom = $lt2->linktypeid;

			//error_log(print_r($linkTypeBuiltFrom, true));

			$nodesArr = split(",",$ids);
			foreach ($nodesArr as $nodeid2){
				$n = new CNode($nodeid2);
				$n = $n->load();
				$r = getRoleByName($n->role->name);
				$roleid = $r->roleid;

				$connection2 = addConnection($solutionnode->nodeid, $rolesolution, $linkTypeBuiltFrom, $nodeid2, $roleid, "N", $conndesc);

				//error_log(print_r($connection2, true));

				if (!$connection2 instanceof Error) {

					// add to group
					if (isset($groupid) && $groupid != "") {
						addGroupToConnection($connection2->connid,$groupid);
					}

					// Link kids to new parent
					$conSetKids = getConnectionsByNode($nodeid2,0,-1,'date','ASC', 'all', '', 'Pro,Con,Comment');
					$conns = $conSetKids->connections;
					foreach ($conns as $con) {
						$from = $con->from;

						$lt3 = getLinkTypeByLabel($CFG->LINK_COMMENT_NODE);
						$linkType3 = $lt3->linktypeid;

						if ($from->role->name == "Pro") {
							$lt3 = getLinkTypeByLabel($CFG->LINK_PRO_SOLUTION);
							$linkType3 = $lt3->linktypeid;
						} else if ($from->role->name == "Con") {
							$lt3 = getLinkTypeByLabel($CFG->LINK_CON_SOLUTION);
							$linkType3 = $lt3->linktypeid;
						}

						// Connect the children of each node being merged to the new node
						$connection3 = addConnection($from->nodeid, $from->role->roleid, $linkType3, $solutionnode->nodeid, $rolesolution, "N", $conndesc);
						if (!$connection3 instanceof Error) {
							// add to group
							if (isset($groupid) && $groupid != "") {
								addGroupToConnection($connection3->connid,$groupid);
							}
						} else {
							return $connection3;
						}

						// retire old connection
						$con->updateStatus($CFG->STATUS_RETIRED);
					}

					// retire connection to parent
					foreach ($mainconns as $con) {
						$from = $con->from;
						if ($from->nodeid == $nodeid2) {
							$con->updateStatus($CFG->STATUS_RETIRED);
						}
					}

					// retire node
					$n->updateStatus($CFG->STATUS_RETIRED);
				} else {
					return $connection2;
				}
			}
		} else {
			return $connection;
		}
	}

	return $solutionnode;
}


///////////////////////////////////////////////////////////////////
// functions for URLs
///////////////////////////////////////////////////////////////////


/**
 * Add a Web Resource. Requires login - combines creating a node and a URL and joining them
 *
 * @param string $url
 * @param string $title
 * @param string $desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $clip (optional);
 * @param string $clippath (optional)
 * @return Node or Error
 */
function addWebResource($url, $title, $desc, $private='Y', $clip="", $clippath="") {
	$r = getRoleByName('Web Resource');
	if (!$r instanceof Error) {
		$refrole = $r->roleid;
		$refnode = addNode($url, $title, $private, $refrole);
		if (!$refnode instanceof Error) {
    		$urlobj = new URL();
    		$urlobj = $urlobj->add($url, $title, $desc, $private, $clip, $clippath, "", "", "");
	    	if (!$urlobj instanceof Error) {
	    		$refnode->addURL($urlobj->urlid, "");
	    	}
		}
    }

    return $refnode;
}

/**
 * Go and try and automatically retrieve the title and descritpion for the given url.
 *
 * @param string $url
 * @return URL or Error
 */
function autoCompleteURLDetails($url){
    global $CFG;

	$http = array('method'  => 'GET',
            'request_fulluri' => true,
            'timeout' => '2');
	if($CFG->PROXY_HOST != ""){
		$http['proxy'] = $CFG->PROXY_HOST . ":".$CFG->PROXY_PORT;
	}
	$opts = array();
	$opts['http'] = $http;

	$context  = stream_context_create($opts);
	$content = file_get_contents($url, false, $context);

	// get title
    $start = '<title>';
    $end = '<\/title>';
    preg_match( "/$start(.*)$end/si", $content, $match );
    $title = strip_tags($match[ 1 ]);
    $title = trim($title);

    try {
    	if ($metatagarray = get_meta_tags( $url )) {
    		//$keywords = $metatagarray[ "keywords" ];
    		$description = $metatagarray[ "description" ];
    		$description = trim($description);
    	} else {
    		$description = "";

    	}
    } catch (Exception $ex) {
    	$description = $ex->getMessage();
    }

    $urlObj = new URL();
    $urlObj->title = $title;
    $urlObj->description = trim($description);

    return $urlObj;
}

/**
 * Add a URL. Requires login
 *
 * @param string $url
 * @param string $title
 * @param string $desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $clip (optional);
 * @param string $clippath (optional) - only used by Firefox plugin
 * @param string $cliphtml (optional) - only used by Firefox plugin
 * @param string $createdfrom (optional) - only used for Utopia, rss, compendium
 * @param string $identifier (optional) an additional identifier used for storing a DOI at present
 * @return URL or Error
 */
function addURL($url, $title, $desc, $private='Y', $clip="", $clippath="", $cliphtml="", $createdfrom="", $identifier=""){
    $urlobj = new URL();
    return $urlobj->add($url, $title, $desc, $private, $clip, $clippath, $cliphtml, $createdfrom, $identifier);
}

/**
 * Delete a URL. Requires login and user must be owner of the URL
 *
 * @param string $urlid
 * @return URL or Error
 */
function deleteURL($urlid){
    $urlObj = new URL($urlid);
    $result = $urlObj->delete();
    return $result;
}

///////////////////////////////////////////////////////////////////
// functions for node <-> URL relationships
///////////////////////////////////////////////////////////////////
/**
 * Add a URL to a Node. Requires login, user must be owner of both the node and URL
 *
 * @param string $urlid
 * @param string $nodeid
 * @param string $comments (optional)
 * @return Node or Error
 */
function addURLToNode($urlid, $nodeid, $comments=""){
    $node = new CNode($nodeid);
    $node = $node->load();
    return $node->addURL($urlid,$comments);
}

///////////////////////////////////////////////////////////////////
// functions for connections
///////////////////////////////////////////////////////////////////

/**
 * Vote for the connection with the given connid
 *
 * @param string $connid
 * @param string $vote to make ('Y' vote or 'N' vote);
 * @return Connection or Error
 */
function connectionVote($connid,$vote){
    $c = new Connection($connid);
    return $c->vote($vote);
}

/**
 * Delete Vote for the connection with the given connid
 *
 * @param string $connid
 * @param string $vote to delete ('Y' vote or 'N' vote);
 * @return Connection or Error
 */
function deleteConnectionVote($connid,$vote){
    $c = new Connection($connid);
    return $c->deleteVote($vote);
}


/**
 * Get a Connection
 *
 * @param string $connid
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return Connection or Error
 */
function getConnection($connid, $style='long'){
    $c = new Connection($connid);
    $conn = $c->load($style);
    return $conn;
}

/**
 * Add a Connection. Requires login.<br>
 * @param string $fromnodeid
 * @param string $fromroleid
 * @param string $linktypeid
 * @param string $tonodeid
 * @param string $toroleid
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $description
 * @return Connection or Error
 */
function addConnection($fromnodeid,$fromroleid,$linktypeid,$tonodeid,$toroleid,$private="",$description=""){
    global $USER, $HUB_DATAMODEL, $ERROR;

    //echo "linktypeid=".$linktypeid;
	//echo("<br>".$fromnodeid);
	//echo("<br>".$fromroleid);

	//echo("<br>".$tonodeid);
	//echo("<br>".$toroleid);

    if($private == ""){
        $private = $USER->privatedata;
    }

    // Check connection adheres to datamodel rules
    $fromNode = getNode($fromnodeid, 'short');
    $toNode = getNode($tonodeid, 'short');

	$linkType = new LinkType($linktypeid);
	$linkType = $linkType->load();

    $fromRole = new Role($fromroleid);
    $fromRole = $fromRole->load();
    $toRole = new Role($toroleid);
    $toRole = $toRole->load();

	$allowed = false;

	//error_log($fromNode->role->name);
	//error_log($fromRole->name);

	//error_log($toNode->role->name);
	//error_log($toRole->name);

	//error_log($linkType->label);

	if ($fromNode instanceof Error) {
		$ERROR = new Error();
		return $ERROR->createInvalidConnectionError("fromnodeid:".$fromnodeid);
	}
	if ($toNode instanceof Error) {
		$ERROR = new Error();
		return $ERROR->createInvalidConnectionError("tonodeid:".$tonodeid);
	}

	if (!$linkType instanceof Error) {
		if ($fromNode->role->name == $fromRole->name && $toNode->role->name == $toRole->name) {
			//error_log("HERE1");
			//error_log($fromRole->name);
			//error_log($linkType->label);
			//error_log($toRole->name);

			$allowed = $HUB_DATAMODEL->matchesModel($fromRole->name, $linkType->label, $toRole->name);
		} else if ($fromRole->name == 'Pro') {
			//error_log("HERE2");
			$allowed = $HUB_DATAMODEL->matchesModelPro($fromNode->role->name, $linkType->label, $toNode->role->name);
		} else if ($fromRole->name == 'Con') {
			//error_log("HERE3");
			$allowed = $HUB_DATAMODEL->matchesModelCon($fromNode->role->name, $linkType->label, $toNode->role->name);
		}

		if (!$allowed) {
			//error_log("NOT ALLOWED");
			$ERROR = new Error();
			return $ERROR->createInvalidConnectionError();
		} else {
			//error_log("ALLOWED");
	    	$cobj = new Connection();
	    	return $cobj->add($fromnodeid,$fromroleid,$linktypeid,$tonodeid,$toroleid,$private,$description);
	    }
	} else {
		//error_log("NOT ALLOWED - LINK ERROR");
		$ERROR = new Error();
		return $ERROR->createInvalidConnectionError("linktypeid".$linktypeid);
	}
}

/**
 * Edit a connection's description. Requires login and user must be owner of the connection
 *
 * @param string $connid
 * @param string $description
 * @return Connection or Error
 */
function editConnectionDescription($connid, $description=""){
    global $USER;
    $cobj = new Connection($connid);
    return $cobj->editDescription($description);
}

/**
 * Delete a connection. Requires login and user must be owner of the connection
 *
 * @param string $connid
 * @return Result or Error
 */
function deleteConnection($connid){
    $cobj = new Connection($connid);
    $result = $cobj->delete();
    return $result;
}

/**
 * Get the connections for the given parameters
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $q='', $scope='all',$tagsonly=false,$status=0){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// SEARCH
	if (isset($q) && $q != "") {
    	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_SEARCH;
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
			$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
				$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL;
			if ($querySQL != "") {
				$sql .= $HUB_SQL->AND;
			}
		}
		// PERMISSIONS
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	    //echo $sql;

		// Get the nodeid for the nodes that match the search
		// Then used to filter connections.
		$resArray = $DB->select($sql, $params);

		// important to empty it out to use again.
		$params = array();
		$list = "";

		if ($resArray !== false) {
			$nodes = array();
			$loopCount = 0;
			$count = count($resArray);
			for ($i=0; $i < $count; $i++) {
				$array = $resArray[$i];
				$NodeID = $array['NodeID'];
				if (!isset($nodes[$NodeID])) {
					$list .= ",'".$NodeID."'";
					$nodes[$NodeID] = $NodeID;
				}
			}
			// remove first comma.
			$list = substr($list, 1);
		}

	    if($list == ""){
	        return new ConnectionSet();
	    }

		$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT.$HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_PART1;
		$sql .= $list;
    	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_PART2;
		$sql .= $list;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_PART3;
    } else {
	    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
	}

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
		$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	} else {
		if ($filterlist != "") {
			$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	//echo $sql;

	//print_r($params);

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the connections for given user
 *
 * @param string $userid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByUser($userid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $q="",$status=0){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// SEARCH
	if (isset($q) && $q != "") {
    	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_SEARCH;

		$querySQL = getSearchQueryString($params, $q, true, true);
     	$sql .= $querySQL;
     	if ($querySQL != "") {
    		$sql .= $HUB_SQL->AND;
     	}

		// FILTER BY USER
		$params[count($params)] = $userid;
        $sql .= $HUB_SQL->FILTER_USER;

		// PERMISSIONS
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	    //echo $sql;

		// Get the nodeid for the nodes that match the search
		// Then used to filter connections.
		$resArray = $DB->select($sql, $params);

		// important to empty it out to use again.
		$params = array();
		$list = "";

		if ($resArray !== false) {
			$nodes = array();
			$loopCount = 0;
			$count = count($resArray);
			for ($i=0; $i < $count; $i++) {
				$array = $resArray[$i];
				$NodeID = $array['NodeID'];
				if (!isset($nodes[$NodeID])) {
					$list .= ",'".$NodeID."'";
					$nodes[$NodeID] = $NodeID;
				}
			}
			// remove first comma.
			$list = substr($list, 1);
		}

	    if($list == ""){
	        return new ConnectionSet();
	    }

		$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_USER_SELECT_PART1;
		$sql .= $list;
    	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_USER_SELECT_PART2;
		$sql .= $list;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_USER_SELECT_PART3;
    } else {
	    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
	}

	// FILTER BY USER
	$params[count($params)] = $userid;
	$sql .= $HUB_SQL->FILTER_USER.$HUB_SQL->AND;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
		$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	} else {
		if ($filterlist != "") {
			$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the connections for the node with the given nodeid
 *
 * @param string $nodeid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'vote', 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByNode($nodeid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $status=0){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $list = getAggregatedNodeIDs($nodeid);
	if ($list != "") {
		$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_SELECT_PART1;
		$sql .= $list;
    	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_SELECT_PART2;
		$sql .= $list;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_SELECT_PART3;

		// FILTER BY NODE TYPES - OR
		if ($filternodetypes != "") {
			$nodetypeArray = array();
			$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

			$params = array_merge($params, $nodetypeArray);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_NODETYPE_FILTER_PART1;
			$sql .= $innersql;

			$params = array_merge($params, $nodetypeArray);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_NODETYPE_FILTER_PART2;
			$sql .= $innersql;

			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_NODETYPE_FILTER_PART3;
		}

		// FILTER BY LINK TYPES
		if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
			$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			if ($filterlist != "") {
				$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
				$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
				$sql .= $HUB_SQL->OPENING_BRACKET;
				$sql .= $innersql;
				$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
			}
		}

		// PERMISSIONS
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

		// FILTER STATUS
		$params[count($params)] = $status;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

		// ORDER BY VOTE
		if ($orderby == 'vote') {
			$sql = $HUB_SQL->APILIB_CONNECTION_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_CONNECTION_ORDERBY_VOTE_PART2;
		}

		//error_log(print_r($sql, true));

	    $cs = new ConnectionSet();
	    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
	} else {
		return new ConnectionSet();
	}
}

/**
 * Get the connections for given url
 *
 * @param string $url
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByURL($url,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $status=0){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
    	$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	} else {
		if ($filterlist != "") {
			$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	// for connection
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;

	// for from url
	$params[count($params)] = $url;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	// for from node
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;

	// for to url
	$params[count($params)] = $url;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	// for to node
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;

	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_URL_PERMISSIONS;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get all the connections for the given node types and link types
 *
 * @param string $scope (either 'all' or 'my')
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $linklabels (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $userid the id of the user to filter by (this will check the ownership of the nodes in the connection, not the connection itself).
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsBySocial($scope,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $linklabels = '', $filternodetypes='', $userid='', $style='long', $status=0){
    global $DB, $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_SOCIAL;
    $sql .= $HUB_SQL->AND;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
    	$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($linklabels != "") {
		$innersql = getSQLForLinkTypeIDsForLabels($params,$linklabels);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	}

	// FILTER BY USER
    if ($userid != "") {
		$params[count($params)] = $userid;
		$params[count($params)] = $userid;
    	$sql .= $HUB_SQL->APILIB_FILTER_USER_SOCIAL.$HUB_SQL->AND;
    }

	// PERMISSIONS
    if($scope == "my"){
		$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->FILTER_USER.$HUB_SQL->AND;
    }

    $params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

    $cs = new ConnectionSet();

	//echo $sql;

    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get all connections from the given list of connection ids.
 *
 * @param String $connectionids a comma separated list of the connection ids to get.
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: -1 = all)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getMultiConnections($connectionids, $start = 0,$max = -1 ,$orderby = 'date',$sort ='ASC', $style='long') {
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// Loop through list of connection ids and add to array
	$pieces = explode(",", $connectionids);
	$loopCount = 0;
	$connids = "";
	foreach ($pieces as $value) {
		$value = trim($value);
		$params[count($params)] = $value;

		if ($loopCount == 0) {
			$connids .= "?";
		} else {
			$connids .= ",?";
		}
		$loopCount++;
	}

	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_MULTI_SELECT_PART1;
	$sql .= $connids;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_MULTI_SELECT_PART2;

    $params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;

	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the connections for the given network search parameters from the given node.
 *
 * @param string $nodeid the id of the node to search outward from.
 * @param string $linklabels the string of link types.
 * @param string $userid optional for searching only a specified user's data. (only used if scope is 'all') - NOT USED AT PRESENT
 * @param string $scope (either 'all' or 'my', default 'all')
 * @param string $linkgroup (optional, either Positive, Negative, or Neutral - default: empty string);
 * @param integer $depth (optional, 1-7, or 7 for full depth;
 * @param string $direction (optional, 'outgoing', 'incoming', or 'both - default: 'both',
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param string $nodetypes a comman separated list of the node type names to include in the search.
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByPath($nodeid, $linklabels, $userid, $scope='all', $linkgroup='', $depth=7, $direction="both", $labelmatch='false', $nodetypes='', $style='long', $status=0){
    global $DB,$USER,$CFG;

	$searchLinkLabels = "";
	$searchLinkLabelsArray = array();
	//$searchLinkLabels = getSQLForLinkTypeIDsForLabels(&$searchLinkLabelsArray, $linklabels)

	if ($linklabels != "" && $linkgroup == "") {
		$pieces = explode(",", $linklabels);
		$loopCount = 0;
		foreach ($pieces as $value) {
			$searchLinkLabelsArray[$loopCount] = $value;
			if ($loopCount == 0) {
				$searchLinkLabels .= "?";
			} else {
				$searchLinkLabels .= ",?";
			}
			$loopCount++;
		}
	}

	$nodeTypeNames = "";
	$nodeTypeNamesArray = array();
	//$nodeTypeNames = getSQLForNodeTypeIDsForLabels($nodeTypeNamesArray,$nodetypes);

	if ($nodetypes != "") {
	    $nodeTypeNames = "";
	    $pieces = explode(",", $nodetypes);
	    $loopCount = 0;
	    foreach ($pieces as $value) {
			$nodeTypeNamesArray[$loopCount] = $value;
	        if ($loopCount == 0) {
	        	$nodeTypeNames .= "?";
	        } else {
	        	$nodeTypeNames .= ",?";
	        }
	        $loopCount++;
	    }
	}

	// GET TEXT FOR PASSED IDEA ID IF REQUIRED
	$text = "";
	if ($labelmatch == 'true') {
		$params = array();
		$params[0] = $nodeid;
		$qry = $HUB_SQL->APILIB_NODE_NAME_BY_ID_SELECT;
		$resArray = $DB->select($sql, $params);
		if ($resArray !== false && count($resArray) > 0) {
			$text = $resArray[0]['Name'];
		} else {
			return database_error();
		}
	}

	$matchesFound = array();
	if (($labelmatch == 'true' && $text != "") || ($labelmatch == 'false' && $nodeid != "")) {
		$checkConnections = array();
		$matchedConnections = null;
		if ($labelmatch == 'true') {
			$nextNodes[0] = $text;
		} else {
			$nextNodes[0] = $nodeid;
		}
		$matchesFound = searchNetworkConnections($checkConnections, $matchedConnections, $nextNodes, $searchLinkLabels, $searchLinkLabelsArray, $linkgroup, $labelmatch, $depth, 0, $direction, $nodeTypeNames, $nodeTypeNamesArray, $scope, $status);
	}
	//return database_error($matchesFound);

	//print_r($matchesFound);

	$cs = new ConnectionSet($matchesFound);
	return $cs->loadConnections($matchesFound, $style);
}

/**
 * Get the connections for the given netowrk search paramters from the given node.
 *
 * @param string $logictype (either 'and' or 'or', deafult 'or').
 * @param string $scope (either 'all' or 'my', deafult 'all')
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param string $nodeid the id of the node to search outward from.
 * @param integer $depth (optional, 1-7, default 1);
 * @param string $linklabels Array of strings of link types. Array length must match depth specified. Each array level is mutually exclusive with linkgroups - there can only be one.
 * @param string $linkgroups Array of either Positive, Negative, or Neutral - default: empty string). Array length must match depth specified.Each array level is mutually exclusive with linklabels - there can only be one.
 * @param string $directions Array of 'outgoing', 'incmong', or 'both - default: 'both'. Array length must match depth specified.
 * @param string $nodetypes Array of strings of node type names. Array length must match depth specified.
 * @param string $nodeids Array of strings of nodeids. Array length must match depth specified.
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByPathByDepth($logictype = 'or', $scope='all', $labelmatch='false', $nodeid, $depth=1, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath='true', $style='long', $status=0){
	if ($logictype == "and") {
		return getConnectionsByPathByDepthAND($scope,$labelmatch,$nodeid,$depth,$linklabels,$linkgroups,$directions,$nodetypes,$nodeids, $uniquepath, $style, $status);
	} else {
		return getConnectionsByPathByDepthOR($scope,$labelmatch,$nodeid,$depth,$linklabels,$linkgroups,$directions,$nodetypes,$nodeids, $uniquepath, $style, $status);
	}
}

///////////////////////////////////////////////////////////////////
// functions for roles
///////////////////////////////////////////////////////////////////

/**
 * Get a role (by name)
 *
 * @param string $rolename
 * @return Role or Error
 */
function getRoleByName($rolename){
    $r = new Role();
    return $r->loadByName($rolename);
}

///////////////////////////////////////////////////////////////////
// functions for link types
///////////////////////////////////////////////////////////////////

/**
 * Get a linktype by label
 *
 * @param string $label
 * @return LinkType or Error
 */
function getLinkTypeByLabel($label){
    $lt = new LinkType();
    return $lt->loadByLabel($label);
}

///////////////////////////////////////////////////////////////////
//functions for tags
///////////////////////////////////////////////////////////////////
/**
* Get a tag (by id)
*
* @param string $tagid
* @return Tag or Error
*/
function getTag($tagid){
	$t = new Tag($tagid);
	return $t->load();
}

/**
* Get the current user's tag list for tags used on Nodes (not on their User Profile). Login required.
*
* @return TagSet or Error
*/
function getUserTags(){
	global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $currentuser;

	$sql = $HUB_SQL->APILIB_TAGS_BY_USER_SELECT;

    $ts = new TagSet();
	return $ts->load($sql, $params);
}

/**
 * Searches tags by node name based on the first chartacters
 *
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'all' or 'my' - default: 'my')
 * @return TagSet or Error
 */
function getTagsByFirstCharacters($q, $scope){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// Don't want speech marks added in MySQL version
	$next = new stdClass();
	$params[0] = $next->value = $q;

    $sql = $HUB_SQL->APILIB_TAGS_BY_FIRST_CHARACTER_SELECT_PART1;
    if ($scope == 'my') {
		$params[1] = $currentuser;
    	$sql .= $HUB_SQL->AND;
        $sql .= $HUB_SQL->FILTER_USER;
    }
    $sql = $HUB_SQL->APILIB_TAGS_BY_FIRST_CHARACTER_SELECT_PART2;

    $ts = new TagSet();
    return $ts->load($sql, $params);
}

/**
* Add new tag - if the tag already exists then this
* existing tag object will be returned. Login required.
*
* @param string $tagname
* @return Role or Error
*/
function addTag($tagname){
	$tagobj = new Tag();
	return $tagobj->add($tagname);
}

/**
* Edit a tag. If that tag name already exists for this user, return an error.
* Requires login and user must be owner of the tag
*
* @param string $tagid
* @param string $tagname
* @return Tag or Error
*/
function editTag($tagid,$tagname){
	$tagobj = new Tag($tagid);
	return $tagobj->edit($tagname);
}

/**
* Delete a tag. Requires login and user must be owner of the tag.
*
* @param string $tagid
* @return Result or Error
*/
function deleteTag($tagid){
	$tagobj = new Tag($tagid);
	return $tagobj->delete();
}

///////////////////////////////////////////////////////////////////
// functions for users
///////////////////////////////////////////////////////////////////

/**
 * Get the users with the most connections (excludes groups)
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a users details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getActiveConnectionUsers($start = 0,$max = 20,$style='long') {
    global $CFG,$DB,$HUB_SQL;

	$params = array();

	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_ACTIVE_USERS_SELECT;

    // ADD LIMITING
    $sql = $DB->addLimitingResults($sql, $start, $max);
	$resArray = $DB->select($sql, $params);

    $us = new UserSet();
	$count = count($resArray);
	$us->totalno = $count;
	$us->start = $start;
	$us->count = $count;
	for ($i=0; $i<$count; $i++) {
		$array = $resArray[$i];
		$u = new User($array["UserID"]);
		$us->add($u->load($style));
		$u->connectioncount = $array["num"];
	}

    return $us;
}

/**
 * Get the users with the most ideas (excludes groups)
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a users details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getActiveIdeaUsers($start = 0,$max = 20,$style='long') {
    global $CFG,$DB,$HUB_SQL;

	$params = array();

	$sql = $HUB_SQL->APILIB_NODES_BY_ACTIVE_USERS_SELECT;

    // ADD LIMITING
    $sql = $DB->addLimitingResults($sql, $start, $max);

	$resArray = $DB->select($sql, $params);

    $us = new UserSet();
	$count = count($resArray);
	$us->totalno = $count;
	$us->start = $start;
	$us->count = $count;
	for ($i=0; $i<$count; $i++) {
		$array = $resArray[$i];
		$u = new User($array["UserID"]);
		$us->add($u->load($style));
		$u->ideacount = $array["num"];
	}

    return $us;
}

/**
 * Get a user
 *
 * @param string $userid
 * @param string $format (optional - default 'long') may be 'short' or 'long'
 * @return User or Error
 */
function getUser($userid,$format='long'){
    $u = new User($userid);
    return $u->load($format);
}

/**
 * Get the users following the given item
 *
 * @param string $itemid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getUsersByFollowing($itemid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC',$style='long'){
	global $HUB_SQL;

	$params = array();
	$params[0] = $itemid;

    $sql = $HUB_SQL->APILIB_USERS_BY_FOLLOWING_SELECT;

    $us = new UserSet();
    return $us->loadFollowers($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the users being most followed
 *
 * @param integer $limit (optional - default: 5)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getUsersByMostFollowed($limit=5,$style='long'){
	global $DB, $HUB_SQL;

	$params = array();

    $sql = $HUB_SQL->APILIB_USERS_BY_MOST_FOLLOWING_SELECT;

    // ADD LIMITING
    if ($limit > 0) {
	    $sql = $DB->addLimitingResults($sql, 0, $limit);
	}
    $us = new UserSet();
	return $us->loadFollowed($sql, $params, $style);
}

/**
 * Return the most Active users
 * @param integer $limit (optional - default: 5)
 * @param number $from the time from which to get thier activity expressed in milliseconds
 * @return ActivitySet or Error
 */
function getUsersMostActive($limit=5, $from, $style='long') {
    global $DB, $CFG, $USER,$HUB_SQL;

	$params = array();

    $as = new ActivitySet();

	$sql = $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT;
	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_SELECT;
    $sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_NODE;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_CONN;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MODE_DATE_WHERE;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE_VOTE;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_FOLLOW;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE;
	}

 	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_END;
    $sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_ORDER;

    // ADD LIMITING
    if ($limit > 0) {
	    $sql = $DB->addLimitingResults($sql, 0, $limit);
	}

    $us = new UserSet();
	return $us->loadActive($sql, $style);
}

/**
 * Get all the users the current user has permissions to see
 *
 * @param boolean $includegroups (optional - default: false)
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @param string $q the query term(s)
 * @return UserSet or Error
 */
function getUsersByGlobal($includegroups = false, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC',$style='long',$q=''){
	global $CFG,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->defaultUserID;

	$sql = $HUB_SQL->APILIB_USERS_BY_GLOBAL_SELECT;

	if ($includegroups == false) {
		$sql .= $HUB_SQL->APILIB_USERS_BY_GLOBAL_FILTER_GROUPS;
	}

	if ($q != "") {
		$querySQL = getSearchQueryString($params, $q, true, false);
     	if ($querySQL != "") {
    		$sql .= $HUB_SQL->AND;
	     	$sql .= $querySQL;
     	}
	}

    $us = new UserSet();
    return $us->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Check that the session is active and valid for the user passed.
 * @param string $userid
 * @return User or Error
 */
function validateUserSession($userid){
    global $USER, $LNG;

	$validateSession = validateSession($userid);

	if(strcmp($validateSession,$LNG->CORE_SESSION_OK) != 0) {
		$ERROR = new error();
		$ERROR->createValidateSessionError($validateSession);
		return $ERROR;
    }

    $user = $USER;

    return $user;
}

/**
 * Logs a user in.
 *
 * @param string $username
 * @param string $password
 * @return User or Error
 */
function login($username,$password){
	global $CFG;

    if($password == "" || $username == ""){
       $ERROR = new Error();
       $ERROR->createLoginFailedError();
       return $ERROR;
    }

    $user = userLogin($username,$password);
    if($user instanceof Error){
       	return $user;
    } else if ($user instanceof User) {
    	$user->setPHPSessID(session_id());
    	return $user;
	} else {
        $ERROR = new Error();
        return $ERROR->createLoginFailedError();
	}
}

///////////////////////////////////////////////////////////////////
// Follow functions
///////////////////////////////////////////////////////////////////

/**
 * Add a new following entry for the current user against the given itemid
 * @param string $itemid the id of the node or user to follow
 * @return Following or Error
 */
function addFollowing($itemid) {
    $f = new Following($itemid);
    return $f->add();
}

/**
 * Delete a following entry for the current user against the given itemid
 * @param string $itemid the id of the node or user to stop following
 * @return Following or Error
 */
function deleteFollowing($itemid) {
    $f = new Following($itemid);
    $f->load();
    return $f->delete();
}

/**
 * Connect the node with the given nodeid to the given comment
 * @param nodeid the id of the node to connect.
 * @nodetypename the node type name of the node type to make the comment
 * @param comment the comment to connecto to.
 * @param parentconnid the connection id of the top chat tree item this new comment belongs to.
 * (It has it's description updated to store the new child node id, and this will clock the modification date too,
 * so it sorts to the top in the chat tree).
 * @param parentid the node id of the item that this comment was made against - i.e. the focal item for the chat tree)
 * (it is stored in the description field of this new connection. It is used to be able to link to the parent item this comment belongs to).
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return Connection or Error
 */
function connectNodeToComment($nodeid, $nodetypename, $comment, $parentconnid='', $parentid='', $style='long') {
	global $DB,$CFG,$HUB_SQL;

	$node = new CNode($nodeid);
	$node = $node->load();

	$nr = getRoleByName($node->role->name);
	$noderole = $nr->roleid;

	$r = getRoleByName($nodetypename);
	$commentrole = $r->roleid;

	$lt = getLinkTypeByLabel($CFG->LINK_COMMENT_NODE);
	$linkid = $lt->linktypeid;

	$commentnode = new CNode();
	$commentnode = $commentnode->addComment($comment, "", 'N', $commentrole);

	$r = getRoleByName('Comment');
	$commentrole = $r->roleid;

	$connection = addConnection($commentnode->nodeid, $commentrole, $linkid, $node->nodeid, $noderole, "N", $parentid);

	// if we know the parent connection,
	// update it's description with this new child node id
	// The parent connection modification date will be updated too
	// so it sorts to the top and it will know the id of the new child.
	if ($parentconnid != "") {
		// need to update this date even if the owner of the chat thread is someone else thatn the current user.
		// so overriding usual checks here.

		$conn = new Connection($parentconnid);
		$conn = $conn->load();
		if (!$conn instanceof Error) {
			$description = $conn->description;
			$description = $commentnode->nodeid.":".$description;
			$dt = time();

			$params = array();
			$params[0] = $dt;
			$params[1] = $description;
			$params[2] = $parentconnid;

	        $sql = $HUB_SQL->APILIB_NODE_TO_COMMENT;
			$res = $DB->insert($sql, $params);
	        if (!$res) {
	            return database_error();
	        }
		}
	}

	return $connection;
}

/**
 * Delete the Comment node with the given nodeid
 * and update the parent chat tree connection by removing the
 * @param nodeid the id of the node to delete.
 * @param parentconnid the connection id of the top chat tree item this comment belonged to.
 * (It has it's description updated to remove the child node id, without clocking the mod date.
 * @return Connection or Error
 */
function deleteComment($nodeid, $parentconnid='') {
	global $DB,$CFG,$HUB_SQL;

	$reply = deleteNode($nodeid);

	// if we know the parent connection,
	// update it's description with this new child node id
	// The parent connection modification date will be updated too
	// so it sorts to the top and it will know the id of the new child.
	if ($parentconnid != "") {
		// need to update this date even if the owner of the chat thread is someone else thatn the current user.
		// so overriding usual checks here.

		$conn = new Connection($parentconnid);
		$conn = $conn->load();
		if (!$conn instanceof Error) {
			$description = $conn->description;
			$pos = strpos($description, $nodeid);
			if ($pos === false) {
			    // should never happen if all goes well
			} else {
				$description = str_replace($nodeid.":", "", $description);

				$params = array();
				$params[0] = $description;
				$params[1] = $parentconnid;

				$sql = $HUB_SQL->APILIB_COMMENT_DELETE;
				$res = $DB->insert($sql, $params);
				if (!$res) {
					return database_error();
				}
			}
		}
	}

	return $reply;
}


/**
 * Get the AuditNode coun t+ the Audit Triple count + the Voting count total
 * for entries between the given dates.
 * return a TreeData object with one field called 'count' holding the total count.
 */
function getTreeData($fromdate="", $todate="") {
	global $DB,$HUB_SQL;

	$params = array();

	$fdate = "";
	$tdate = "";
	try {
		if(is_numeric($fromdate)){
			$fdate = $fromdate;
		} else if ($fromdate != "") {
			$fdate = strtotime($fromdate);
		}

		if(is_numeric($todate)){
			$tdate = $todate;
		} else if ($todate != "") {
			$tdate = strtotime($todate);
		}
	} catch (Exception $e) {
		//failed
	}

	$sql .= $HUB_SQL->APILIB_TREE_DATA_VOTING;
	if ($fdate != "" && $tdate != "") {
		$params[count($params)] = $fdate;
		$params[count($params)] = $tdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM_TO;
	} else if ($fdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM;
	} else if ($tdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_TO;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_TREE_DATA_AUDIT_NODE;
	if ($fdate != "" && $tdate != "") {
		$params[count($params)] = $fdate;
		$params[count($params)] = $tdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM_TO;
	} else if ($fdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM;
	} else if ($tdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_TO;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_TREE_DATA_AUDIT_TRIPLE;
	if ($fdate != "" && $tdate != "") {
		$params[count($params)] = $fdate;
		$params[count($params)] = $tdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM_TO;
	} else if ($fdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM;
	} else if ($tdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_TO;
	}

	$sql .= $HUB_SQL->APILIB_TREE_DATA_AUDIT_END;

	$answer = 0;
	$resArray = $DB->select($sql, $params);
    if ($resArray !== false) {
    	$count = count($resArray);
    	for ($i=0; $i<$count; $i++) {
        	$array = $resArray[$i];
        	$answer = $array['count'];
        }
    }

	class TreeData {
		public $count = "";
	}
	$treedata = new TreeData();
	$treedata->count = $answer;

	return $treedata;
}


///////////////////////////////////////////////////////////////////
// functions for groups
///////////////////////////////////////////////////////////////////

/**
 * Get the nodes for given group
 *
 * @param string $groupid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filterusers (optional, a list of user ids to filter by)
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 * @param string $connectionfilter filter by connections. Defaults to empty string which means disregard connection count. Possible values; '','connected','unconnected'.
 */
function getNodesByGroup($groupid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filterusers='', $filternodetypes='', $style='long', $q="", $connectionfilter='',$status=0){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_NODES_BY_GROUP_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {

		// This comes first in HUB_SQL->APILIB_NODES_BY_GROUP_NODETYPE
		// Before node type list.
		$params[count($params)] = $groupid;

        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
		}

        $sql .= $HUB_SQL->APILIB_NODES_BY_GROUP_NODETYPE.$HUB_SQL->OPENING_BRACKET;
        $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    } else {
		$params[count($params)] = $groupid;
		$HUB_SQL->APILIB_NODES_BY_GROUP_NODETYPE_NONE.$HUB_SQL->AND;
    }

    if ($filterusers != "") {
        $pieces = explode(",", $filterusers);
        $loopCount = 0;
        $searchUsers = "";
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
            if ($loopCount == 0) {
            	$searchUsers .= "?";
            } else {
            	$searchUsers .= ",?";
            }
            $loopCount++;
        }

        $sql .=  $HUB_SQL->FILTER_USERS.$HUB_SQL->OPENING_BRACKET;
        $sql .= $searchUsers;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }

	// SEARCH
	if ($q != "") {
		$querySQL = getSearchQueryString($params,$q, true, true);
		$sql .= $querySQL;
		if ($querySQL != "") {
			$sql .= $HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	// ORDER BY VOTE
	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	if ($connectionfilter == 'unconnected') {
		$sql .= $HUB_SQL->APILIB_HAVING_UNCONNECTED;
	} else if ($connectionfilter == 'connected') {
		$sql .= $HUB_SQL->APILIB_HAVING_CONNECTED;
	}

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort, $style);
}

/**
 * Get a group
 *
 * @param string $groupid
 * @return Group or Error
 */
function getGroup($groupid){

    $g = new Group($groupid);
	$g->load();
    $g->loadmembers();
    return $g;
}

/**
 * Add a group to a node. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeid
 * @param string $groupid
 * @return Node or Error
 */
function addGroupToNode($nodeid,$groupid){
    $n = new CNode($nodeid);
    $n = $n->load();
    return $n->addGroup($groupid);
}

/**
 * Add a group to a set of nodes. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeids
 * @param string $groupid
 * @return Result or Error
 */
function addGroupToNodes($nodeids,$groupid){
    $nodesArr = split(",",$nodeids);
    foreach ($nodesArr as $nodeid){
        $n = new CNode($nodeid);
        $n = $n->load();
        $n->addGroup($groupid);
    }
    return new Result("added","true");
}

/**
 * Remove a group from a node. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeid
 * @param string $groupid
 * @return Node or Error
 */
function removeGroupFromNode($nodeid,$groupid){
    $n = new CNode($nodeid);
    $n = $n->load();
    return $n->removeGroup($groupid);
}

/**
 * Remove a group from a set of nodes. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeids
 * @param string $groupid
 * @return Result or Error
 */
function removeGroupFromNodes($nodeids,$groupid){
    $nodesArr = split(",",$nodeids);
    foreach ($nodesArr as $nodeid){
        $n = new CNode($nodeid);
        $n = $n->load();
        $n->removeGroup($groupid);
    }
    return new Result("added","true");
}

/**
 * Remove all groups from a node. Requires login, user must be the node owner.
 *
 * @param string $nodeid
 * @return Node or Error
 */
function removeAllGroupsFromNode($nodeid){
    $n = new CNode($nodeid);
    $n = $n->load();
    return $n->removeAllGroups();
}

/**
 * Make all the users nodes and connections in a group private or public.
 * Requires login, user must be member of the group, and this will only update the nodes/connections
 * that the user is the owner of.
 *
 * @param string $groupid
 * @param string $private (must be either 'Y' or 'N')
 * @return Result or Error
 */
function setGroupPrivacy($groupid,$private){
    global $DB,$CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $groupid;
	$params[1] = $currentuser;

    // set the nodes
    $sql = $HUB_SQL->APILIB_NODE_GROUP_PRIVACY_SELECT;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = count($resArray);
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$n = new CNode($array['NodeID']);
			$n = $n->load();
			$n->setPrivacy($private);
		}
	}

    // set the connections
    $sql = APILIB_CONNECTION_GROUP_PRIVACY_SELECT;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = count($resArray);
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$c = new Connection($array['TripleID']);
			$c = $c->load();
			$c->setPrivacy($private);
		}
	}

    return new Result("privacy updated","true");
}

/**
 * Add a group to a Connection. Requires login, user must be the connection owner and member of the group.
 *
 * @param string $connid
 * @param string $groupid
 * @return Connection or Error
 */
function addGroupToConnection($connid,$groupid){
    $c = new Connection($connid);
    $c->load();
    return $c->addGroup($groupid);
}

/**
 * Add a group to a set of connections. Requires login, user must be the connection owner and member of the group.
 *
 * @param string $connids
 * @param string $groupid
 * @return Result or Error
 */
function addGroupToConnections($connids,$groupid){
    $connsArr = split(",",$connids);
    foreach ($connsArr as $connid){
        $c = new Connection($connid);
        $c = $c->load();
        $c->addGroup($groupid);
    }
    return new Result("added","true");
}
/**
 * Remove a group from a Connection. Requires login, user must be the connection owner and member of the group.
 *
 * @param string $connid
 * @param string $groupid
 * @return Result or Error
 */
function removeGroupFromConnection($connid,$groupid){
    $c = new Connection($connid);
    $c = $c->load();
    return $c->removeGroup($groupid);
}

/**
 * Remove a group from a set of Connections. Requires login, user must be the connections owner and member of the group.
 *
 * @param string $connids
 * @param string $groupid
 * @return Result or Error
 */
function removeGroupFromConnections($connids,$groupid){
    $connsArr = split(",",$connids);
    foreach ($connsArr as $connid){
        $c = new Connection($connid);
   		$c = $c->load();
        $c->removeGroup($groupid);
    }
    return new Result("removed","true");
}

/**
 * Remove all groups from a Connection. Requires login, user must be the connection owner.
 *
 * @param string $connid
 * @return Result or Error
 */
function removeAllGroupsFromConnection($connid){
    $c = new Connection($connid);
    $c = $c->load();
    return $c->removeAllGroups();
}

/**
 * Get all groups. Requires login.
 *
 * @return GroupSet or Error
 */
function getAllGroups($limit){
    global $USER,$HUB_SQL,$DB;

 	$params = array();

    $sql = $HUB_SQL->APILIB_GET_ALL_GROUPS_SELECT;
    $sql = $DB->addLimitingResults($sql, 0, $limit);

    $gs = new GroupSet();
    return $gs->load($sql,$params);
}


/**
 * Get all groups for current user. Requires login.
 *
 * @param userid optional, defaults to current logged in user.
 * @return GroupSet or Error
 */
function getMyGroups($userid = ''){
    global $USER,$HUB_SQL;

	$currentuser = '';
	if (isset($userid) && $userid != '') {
		$currentuser = $userid;
	} else if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $currentuser;

    $sql = $HUB_SQL->APILIB_GET_MY_GROUPS_SELECT." ".$HUB_SQL->APILIB_GET_MY_ADMIN_GROUPS_SORT;

    $gs = new GroupSet();
    return $gs->load($sql,$params);
}

/**
 * Get groups that current user is an admin for. Requires login.
 *
 * @param userid optional, defaults to current logged in user.
 * @return GroupSet or Error
 */
function getMyAdminGroups($userid = ''){
    global $USER,$HUB_SQL;

	$currentuser = '';
	if (isset($userid) && $userid != '') {
		$currentuser = $userid;
	} else if (isset($USER->userid) && $USER->userid != '') {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $currentuser;

    $sql = $HUB_SQL->APILIB_GET_MY_ADMIN_GROUPS_SELECT." ".$HUB_SQL->APILIB_GET_MY_ADMIN_GROUPS_SORT;

    $gs = new GroupSet();
    return $gs->load($sql,$params);
}

/**
 * Add a new group. Requires login.
 *
 * @param string $groupname
 * @return Group or Error
 */
function addGroup($groupname){
    $g = new Group();
    $group = $g->add($groupname);
    return $group;
}

/**
 * Delete a group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @return Result or Error
 */
function deleteGroup($groupid){
    $g = new Group($groupid);
    $result = $g->delete();
    return $result;
}

/**
 * Add a user to a group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function addGroupMember($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->addmember($userid);
    return $group;
}

/**
 * Remove a user from a group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function removeGroupMember($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->removemember($userid);
    return $group;
}

/**
 * Make a user an admin of the group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function makeGroupAdmin($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->makeadmin($userid);
    return $group;
}


/**
 * Remove a user as admin of the group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function removeGroupAdmin($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->removeadmin($userid);
    return $group;
}

/**
 * Remove a user from a group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function approveGroupMemberJoin($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->approvependingmember($userid);
    return $group;
}

/**
 * Reject the user with the given userid user from joining the group with the given groupid.
 * Requires login and current user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function rejectGroupMemberJoin($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->rejectpendingmember($userid);
    return $group;
}

/**
 * Is the given user a pending member in the given group.
 *
 * @param string $groupid
 * @param string $userid
 * @return true if member else false
 */
function isGroupPendingMember($groupid,$userid) {
    $g = new Group($groupid);
    $g->load();

    return $g->ispendingmember($userid);
}

/**
 * Did the given user have thier membership request rejected?.
 *
 * @param string $groupid
 * @param string $userid
 * @return true if member else false
 */
function isGroupRejectedMember($groupid,$userid) {
    $g = new Group($groupid);
    $g->load();

    return $g->isrejectedmember($userid);
}

/**
 * Did the given user get removed from the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return true if member else false
 */
function isGroupReportedMember($groupid,$userid) {
    $g = new Group($groupid);
    $g->load();

    return $g->isreportedmember($userid);
}

/**
 * Is the given user in the given group.
 *
 * @param string $groupid
 * @param string $userid
 * @return true if member else false
 */
function isGroupMember($groupid,$userid) {
    $g = new Group($groupid);
    $g->load();

    return $g->ismember($userid);
}

/**
 * Get all the groups the current user has permissions to see
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @param string $q the query term(s)
 * @return GroupSet or Error
 */
function getGroupsByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC',$style='long',$q=''){
	global $CFG,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->USER_STATUS_ACTIVE;
	$params[1] = $CFG->USER_STATUS_REPORTED;
	$params[2] = $CFG->defaultUserID;

	$sql = $HUB_SQL->APILIB_GROUPS_BY_GLOBAL_PART1;

	if ($q != "") {
    	$querySQL = getSearchQueryString($params,$q, true, false);
		$sql .= $HUB_SQL->AND.$querySQL;
	}

    $gs = new GroupSet();
    return $gs->loadFromUsers($sql,$params,$start,$max,$orderby,$sort,$style);
}

/** NEW FOR DEBATE HUB **/

/**
 * Get all the connections for the given node types and link types
 *
 * @param string $groupid the id of the group to get social connections for
 * @param string $scope (either 'all' or 'my')
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $linklabels (optional, comma separated strings of the connection labels to filter the results by)
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsByGroup($groupid, $scope,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $linklabels = '', $filternodetypes='', $style='long'){
    global $DB, $USER,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GROUP_SELECT;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GROUP_FILTER;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
		$sql .= $HUB_SQL->AND;

		$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->CLOSING_BRACKET;
    }

	// FILTER BY LINK TYPES
	if ($linklabels != "") {
		$innersql = getSQLForLinkTypeIDsForLabels($params,$linklabels);
		$sql .= $HUB_SQL->AND;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET;
	}

	// PERMISSIONS
    if($scope == "my"){
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->AND;
        $sql .= $HUB_SQL->FILTER_USER;
    }

	$sql .= $HUB_SQL->AND;
    $params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

    $cs = new ConnectionSet();

	//error_log(print_r($sql, true));

    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/////////////////////////
///////// VIEWS /////////
/////////////////////////

/**
 * Get the nodes the current user has permission to see.
 *
 * @param integer $viewid the id of the view to get nodes for
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @param string $connectionfilter filter by connections. Defaults to empty string which means disregard connection count. Possible values; '','connected','unconnected'.
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return NodeSet or Error
 */
function getNodesByView($viewid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $style='long',$q='', $scope='all',$tagsonly=false, $connectionfilter='',$status=0) {
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$sql = $HUB_SQL->APILIB_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// SEARCH
	if (isset($q) && $q != "") {
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
        	$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
 		       	$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL.$HUB_SQL->AND;
		}
	}

	// FILTER ON VIEW
    $params[count($params)] = $viewid;
    $sql .= $HUB_SQL->APLILIB_NODES_BY_VIEW.$HUB_SQL->AND;


	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER STATUS
	$params[count($params)] = $status;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	if ($connectionfilter == 'unconnected') {
		$sql .= $HUB_SQL->APILIB_HAVING_UNCONNECTED;
	} else if ($connectionfilter == 'connected') {
		$sql .= $HUB_SQL->APILIB_HAVING_CONNECTED;
	}

	//error_log("Search=".$sql);

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

function getView($viewid, $style="long") {
	$view = new View($viewid);
	$view = $view->load($style);
    //error_log(print_r($view, true));

	return $view;
}

function getViewNodes($viewid, $style="long") {
	global $HUB_SQL,$DB;

	$ns = new NodeSet();

	$params = array();
	$params[0] = $viewid;
	$sql = $HUB_SQL->DATAMODEL_VIEW_SELECT_NODES;
	$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEW_SELECT_NODES, $params);

	if ($resArray !== false) {
		$count = count($resArray);
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$next = new CNode($array['NodeID']);
			$next = $next->load($style);
			if (!$next instanceof Error) {
				$ns->add($next);
			}
		}
	} else {
		return database_error();
	}

	return $ns;
}

function getViewNodesByGroup($groupid, $style="long") {
	global $HUB_SQL,$DB,$USER;

	$ns = new NodeSet();
	$checkNodes = array();

	$params = array();

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$sql = $HUB_SQL->DATAMODEL_VIEW_SELECT_BY_GROUP;

	$params[count($params)] = $groupid;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	$resArray = $DB->select($sql, $params);

	if ($resArray !== false) {
		$count = count($resArray);
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$nodeset = getViewNodes($array['ViewID'], $style);
			if (!$nodeset instanceof Error) {
				$countj = count($nodeset->nodes);
				for ($j=0; $j < $countj; $j++) {
					$nextnode = $nodeset->nodes[$j];
					if (!$nextnode instanceof Error) {
						// filter duplicates.
						if (in_array($nextnode->nodeid, $checkNodes) === FALSE) {
							array_push($checkNodes, $nextnode->nodeid);
							$ns->add($nextnode);
						}
					}
				}
			} else {
				return $nodeset;
			}
		}
	} else {
		return database_error();
	}

	$ns->count = count($ns->nodes);
	$ns->totalno = $ns->count;

	return $ns;
}

function getViews($style="long") {
    global $USER, $HUB_SQL, $DB;

	$params = array();

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$sql = $HUB_SQL->DATAMODEL_VIEW_SELECT_ALL;

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	//error_log($sql);

	$vs = new ViewSet();
	return $vs->loadFromNodes($sql,$params,$style);
}

function getViewsByGroup($groupid, $style="long") {
    global $USER, $HUB_SQL, $DB;

	$params = array();

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$sql = $HUB_SQL->DATAMODEL_VIEW_SELECT_BY_GROUP;

	$params[count($params)] = $groupid;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	//error_log($sql);

	$vs = new ViewSet();
	return $vs->load($sql,$params,$style);
}

function getViewsByNode($nodeid, $style="long") {
    global $USER, $HUB_SQL, $DB;

	if (!isset($nodeid) || $nodeid =="") {
		return database_error();
	}
	$params = array();

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params[0] = $nodeid;
	$sql = $HUB_SQL->APILIB_MAPS_FOR_NODE_SELECT;

	// PERMISSIONS
	//if($scope == 'my'){
	//	$params[count($params)] = currentuser;
	//	$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
	//} else {

		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	//}

	//error_log("Search=".$sql);

	$vs = new ViewSet();
	return $vs->loadFromNodes($sql,$params,$style);
}

function getViewNode($viewid, $nodeid, $userid, $style="long") {
	$viewnode = new ViewNode($viewid, $nodeid, $userid);
	$viewnode = $viewnode->load($style);

    //error_log(print_r($viewnode, true));

	return $viewnode;
}

/**
 * Add a new View. Requires login
 *
 * @param string $name the name of the view
 * @param string $desc the description of the view
 * @param string $private optional, can be Y or N, defaults to users preferred setting.
 * @param string $nodetypeid optional, the id of the nodetype this node is, defaults to 'Idea' node type id.
 * @param string $groupid optional, the is of the group, if any, this view is in.
 * @param string $xpos optional, the x position to place the challenge node at (defaults to 0).
 * @param string $ypos optional, the y position to place the challenge node at (defaults to 0).
 *
 * @return Node or Error
 */
function addView($name,$desc,$private="",$nodetypeid="",$groupid="", $xpos=0, $ypos=0){
    global $USER;
    if($private == ""){
        $private = $USER->privatedata;
    }

    $v = new View();
    $view = $v->add($name,$desc,$private,$nodetypeid,$groupid,$xpos, $ypos);
    return $view;
}

function editViewNode($viewid,$nodeid,$userid,$xpos,$ypos) {
    global $USER;

	$viewnode = new ViewNode($viewid,$nodeid,$userid);
	if (isset($viewnode) && !$viewnode instanceof Error) {
		$viewnode = $viewnode->edit($xpos,$ypos);
	}
	return $viewnode;
}

/**
 * Remove a node from the view. Requires login
 *
 * @param string $viewid
 * @param string $nodeid
 *
 * @return View or Error
 */
function removeNodeFromView($viewid,$nodeid,$userid) {
    global $USER, $HUB_SQL, $DB;
	$view = new View($viewid);
    if (!$view instanceof Error) {
		$viewnode = $view->removeNode($nodeid, $userid);
		cleanNodeGroups($nodeid);
	}

	return $viewnode;
}

/**
 * For the given node, check that all the groups it is in are still relevant
 * by comparing against the groups of all the maps that the node is in.
 */
function cleanNodeGroups($nodeid) {

	$n = new CNode($nodeid);
	$node = $n->load('long');
	$nodegroups = $node->groups;
	$nodeset = getMapsForNode($nodeid);

	$allGroups = array();

	// get a list of all groups that the maps that the node is in, are in.
	$allmaps = $nodeset->nodes;
	$count = count($allmaps);
	for ($i=0; $i<$count; $i++) {
		$next = $allmaps[$i];
		$nextgroups = $next->groups;
		$countj = count();
		for ($j=0; $j<$countj; $j++) {
			$nextgroup = $nextgroups[$j];
			if (!in_array($nextgroup->groupid, $allGroups)) {
				$allGroups.push($nextgroup->groupid);
			}
		}
	}

	$count = count($nodegroups);
	for ($i=0; $i<$count; $i++) {
		$nextgroup = $nodegroups[$i];
		if (!in_array($nextgroup->groupid, $allGroups)) {
			$node->removeGroup($nextgroup->groupid);
		}
	}
}


/**
 * Remove a connection from the view. Requires login
 *
 * @param string $viewid
 * @param string $connid
 * @param string $userid
 *
 * @return View or Error
 */
function removeConnectionFromView($viewid,$connid,$userid) {
    global $USER, $HUB_SQL, $DB;

	$view = new View($viewid);
	$vn = $view->removeConnection($connid, $userid);

	return $vn;
}

/**
 * Add a node to a view. Requires login
 *
 * @param string $viewid
 * @param string $nodeid
 * @param string $xpos.
 * @param string $ypos.
 * @param string $groupid (optional) the id of the group to add the node to.
 *
 * @return ViewNode or Error
 */
function addNodeToView($viewid,$nodeid,$xpos, $ypos, $groupid=""){
    global $USER;

    $v = new View($viewid);
    $viewnode = $v->addNode($nodeid, $xpos, $ypos);
	if (!$viewnode instanceof Error) {
		if (isset($groupid) && $groupid != "") {
			$group = new Group($groupid);
			if (!$group instanceof Error) {
				if ($group->ismember($USER->userid)) {
					$node = new CNode($nodeid);
					$node->addGroup($groupid);
				}
			}
		} else {
			// if not given get groups for map node and add it to those. Should only be one at present.
			$mapnode = new CNode($viewid);
			$mapnode = $mapnode->load();
			if (isset($mapnode->groups)) {
				$groups = $mapnode->groups;
				$count = count($groups);
				for ($i=0; $i<$count;$i++) {
					$nextgroup = $groups[$i];
					if (isset($nextgroup)) {
						if ($nextgroup->ismember($USER->userid)) {
							$node = new CNode($nodeid);
							$node->addGroup($nextgroup->groupid);
						}
					}
				}
			}
		}
	}
    return $viewnode;
}

/**
 * Add a new node to a view. Requires login
 *
 * @param string $viewid
 * @param string $title
 * @param string $rolename
 * @param string $private
 * @param int $xpos.
 * @param int $ypos.
 * @param string $groupid (optional) the id of the group to add the node to.
 *
 * @return ViewNode or Error
 */
function addNewNodeToView($viewid,$title,$rolename,$private,$xpos, $ypos, $groupid=""){
    global $USER;

	$r = getRoleByName($rolename);
	$roleid = $r->roleid;
	$node = addNode($title,"",$private,$roleid);

	if (!$node instanceof Error) {
	    $v = new View($viewid);
		$viewnode = $v->addNode($node->nodeid, $xpos, $ypos);
		if (!$viewnode instanceof Error) {
			if (isset($groupid) && $groupid != "") {
				$group = new Group($groupid);
				if (!$group instanceof Error) {
					if ($group->ismember($USER->userid)) {
						$node->addGroup($groupid);
					}
				}
			} else {
				// if not given get groups for map node and add it to those. Should only be one at present.
				$mapnode = new CNode($viewid);
				$mapnode = $mapnode->load();
				if (isset($mapnode->groups)) {
					$groups = $mapnode->groups;
					$count = count($groups);
					for ($i=0; $i<$count;$i++) {
						$nextgroup = $groups[$i];
						if (isset($nextgroup)) {
							if ($nextgroup->ismember($USER->userid)) {
								$node->addGroup($nextgroup->groupid);
							}
						}
					}
				}
			}
		}
		return $viewnode;
	} else {
    	return $node;
    }
}

/**
 * Add a node to a view. Requires login
 *
 * @param string $viewid
 * @param string $nodeid
 * @param string $xpos.
 * @param string $ypos.
 * @param string $groupid (optional) the id of the group to add the node to.
 *
 * @return View with new node and connection in or Error
 */
function addNodeToViewAndConnect($viewid,$focalnodeid,$nodeid,$xpos, $ypos,$linktypename,$direction, $groupid=""){
    global $USER;

	// make sure current user in group, if group set.
	if (isset($groupid) && $groupid != "") {
		$group = new Group($groupid);
		if (!$group instanceof Error) {
			if (!$group->ismember($USER->userid)) {
				$error = new Error();
				return $error->createNotInGroup($group->name);
			}
		}
	}

	$node = new CNode($nodeid);
	$node = $node->load();
	if (!$node instanceof Error) {
		if (isset($groupid) && $groupid != "") {
			$node->addGroup($groupid);
		}

		$view = new View($viewid);
		$viewnode = $view->addNode($nodeid, $xpos, $ypos);
		if (!$viewnode instanceof Error) {

			// Connect to focal node
			$focalnode = new CNode($focalnodeid);
			$focalnode = $focalnode->load();
			if (!$focalnode instanceof Error) {
				$focalrole = getRoleByName($focalnode->role->name);
				$focalroleid = $focalrole->roleid;
				$role = getRoleByName($node->role->name);
				if ($role instanceof Error) {
					$role = addRole($node->role->name);
				}
				$roleid = $role->roleid;

				$lt = getLinkTypeByLabel($linktypename);
				$linkType = $lt->linktypeid;

				// connection always public, so drawing determined by node privacy.
				if ($direction == 'from') {
					$connection = addConnection($node->nodeid, $roleid, $linkType, $focalnodeid, $focalroleid, 'N', "");
				} else {
					$connection = addConnection($focalnodeid, $focalroleid, $linkType, $node->nodeid, $roleid, 'N', "");
				}
				if (!$connection instanceof Error) {
					// add to group
					if (isset($groupid) && $groupid != "") {
						$connection->addGroup($groupid);
					}

					$viewcon = $view->addConnection($connection->connid);
					return $view;
				} else {
					return $connection;
				}
			} else {
				return $focalnode;
			}
		} else {
			return $viewnode;
		}
	} else {
		return $node;
	}
}

/**
 * Get all the maps that the node with the given nodeid is in
 * @param nodeid the id of the node to get the maps for.
 * @return NodeSet a set of the map nodes that the given node is part of.
 */
function getMapsForNode($nodeid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $style='long') {
    global $USER, $HUB_SQL, $DB;

	if (!isset($nodeid) || $nodeid =="") {
		return database_error();
	}
	$params = array();

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params[0] = $nodeid;
	$sql = $HUB_SQL->APILIB_MAPS_FOR_NODE_SELECT;

	// PERMISSIONS
	//if($scope == 'my'){
	//	$params[count($params)] = currentuser;
	//	$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
	//} else {

		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	//}

	//error_log("Search=".$sql);

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

function getAllChatConnections($focalnode, $nodetype) {
	global $CFG;

	$nodetypes = 'Comment,'.$nodetype;
	$linklabels = $CFG->LINK_COMMENT_NODE;

	return getConnectionsByPath($focalnode, $linklabels, "", 'all', '', 7, 'incoming', 'false', $nodetypes, 'long');
}

/**
 * Load the data for the Map alerts
 * @param mapid the id of the map to get alerts for
 * @param url the url for the CIF data to load
 * @param alerttypes a comma separated list of the alerttypes to get data for
 * @param timeout how long (in seconds) to cache the visualisation data
 * before it is considered out of date and should be refetched and recalculated.
 * Defaults to 60 seconds.
 * @param userids (optional) a comma separated list of userids to get alert data for
 * @param root (optional) a nodeid for the root node of a data tree to process.
 * @return class alertdata with properties 'alertarray', 'userarray', 'nodearray'.
 *
 */
function getMapAlertsData($mapid,$url,$alerttypes,$timeout=60,$userids="",$root="") {
	global $CFG, $HUB_CACHE;

	$withhistory=true;
	$withvotes=true;
	$withposts = true;

	class alertdata {}

	$data = array();

	$view = getView($mapid);
	if (!$view instanceof Error) {
		$nodes = $view->nodes;
		$count = count($nodes);
		$nodeArray = array();
		$userArray = array();
		for ($i=0; $i<$count; $i++) {
			$viewnode = $nodes[$i];
			$node = $viewnode->node;
			$user = $node->users[0];
			$userArray[$user->userid] = $user;
			$nodeArray[$node->nodeid] = $node;
		}

		// Add any users on connections but not on nodes (brokers).
		$conns = $view->connections;
		$countj = count($conns);
		for ($j=0; $j<$countj; $j++) {
			$viewcon = $conns[$j];
			$con = $viewcon->connection;
			$user = $con->users[0];
			$userArray[$user->userid] = $user;
		}

		// CREATE OBFUSCATION CIPHER AND STORE
		$cipher;
		$salt = openssl_random_pseudo_bytes(32);
		$cipher = new Cipher($salt);
		$obfuscationkey = $cipher->getKey();
		$obfuscationiv = $cipher->getIV();
		$reply = createObfuscationEntry($obfuscationkey, $obfuscationiv, $url);
		$url = $url."/?id=".$reply['dataid'];

		// GET METRICS
		$reply = getAlertMetrics($url, $cipher, $alerttypes, $timeout, $userids, $root);
		//error_log(print_r($reply, true));

   		// { warnings : [ string,* ], results : [ result,* ] }
		$replyObj = json_decode($reply);
		$results = $replyObj->responses;

		if (!isset($results[0]->error) && isset($results[0]->data)) {
			$replydata = $results[0]->data;

			$alertArray = array(); //post by alert type
			$userArray = array(); // post by user by alert type
			$finalNodeArray = new NodeSet();
			$finalUserArray = new UserSet();
			$finalUserCheckArray = array();

			$count = count($replydata);
			for ($i=0; $i<$count; $i++) {
				$next = $replydata[$i];
				$userid = $next->userID;

				if ($userid != '*') {
					$bits = explode('/', $userid);
					$userid = $bits[count($bits)-1];
					//I encode psuedo user ids on the way out.
					//Not sure why. Possibly something to do with the cipher encoding.
					$userid = urldecode($userid);
					$userid = $cipher->decrypt($userid);
					if (isset($userArray[$userid])) {
						$user = $userArray[$userid];
					} else {
						$user = getUser($userid);
					}
					if (!$user instanceof Error ) {
						if (!isset($finalUserCheckArray[$userid])) {
							$finalUserArray->add($user);
							$finalUserCheckArray[$userid] = $userid;
						}
					} else {
						continue;
						error_log("USER NOT FOUND: ".$nextpost);
					}
				}

				$suggestionsArray = $next->suggestions;

				$countj = count($suggestionsArray);
				for ($j=0; $j<$countj; $j++) {
					$suggestion = $suggestionsArray[$j];
					$alertype = $suggestion->{'@type'};

					//error_log($alertype);

					$nextpost = $suggestion->targetID;

					//if (isset($suggestion->arguments)) {
					//	$argumentsArray = $suggestion->arguments;
					//}

					//strip the id off the end of the post id (userid will need decrypting)
					$bits = explode('/', $nextpost);
					$nextpost = $bits[count($bits)-1];
					$targetType = $suggestion->targetType;

					//I encode psuedo user ids on the way out.
					//Not sure why. Possibly something to do with the cipher encoding.
					$nextpost = urldecode($nextpost);

					if ($targetType == 'user' && isset($cipher) && $nextpost != 'anonymous') {
						$nextpost = $cipher->decrypt($nextpost);
					}

					if ($targetType == 'post' && isset($nodeArray[$nextpost])) {
						$nextObj = $nodeArray[$nextpost];
						$finalNodeArray->add($nextObj);
					} else if ($targetType == 'user' && $nextpost != 'anonymous') {
						if (!isset($finalUserCheckArray[$nextpost])) {
							if (isset($userArray[$nextpost])){
								$nextObj = $userArray[$nextpost];
								$finalUserArray->add($nextObj);
								$finalUserCheckArray[$nextpost] = $nextpost;
							} else {
								//error_log("USER not found for:".$nextpost);
								$user = getUser($nextpost);
								if (!$user instanceof Error ) {
									$finalUserArray->add($user);
									$finalUserCheckArray[$nextpost] = $nextpost;
								} else {
									continue;
									error_log("USER NOT FOUND: ".$nextpost);
								}
							}
						}
					} else {
						continue;
						error_log("NOT FOUND: ".$nextpost);
					}

					switch ($alertype) {
						// MAP ALERTS
						case $CFG->ALERT_LURKING_USER;
						case $CFG->ALERT_INACTIVE_USER;
						case $CFG->ALERT_IGNORED_POST:
						case $CFG->ALERT_MATURE_ISSUE:
						case $CFG->ALERT_IMMATURE_ISSUE:
						case $CFG->ALERT_ORPHANED_IDEA:
						case $CFG->ALERT_EMERGING_WINNER:
						case $CFG->ALERT_CONTENTIOUS_ISSUE:
						case $CFG->ALERT_INCONSISTENT_SUPPORT:
						case $CFG->ALERT_HOT_POST:
						case $CFG->ALERT_CONTROVERSIAL_IDEA:
						case $CFG->ALERT_USER_GONE_INACTIVE:
						case $CFG->ALERT_WELL_EVALUATED_IDEA:
						case $CFG->ALERT_POORLY_EVALUATED_IDEA:
						case $CFG->ALERT_RATING_IGNORED_ARGUMENT:
						case $CFG->ALERT_USER_IGNORED_COMPETITORS:
						case $CFG->ALERT_USER_IGNORED_ARGUMENTS:
						case $CFG->ALERT_USER_IGNORED_RESPONSES:
							// Store data just by alert type
							if (array_key_exists($alertype,$alertArray)) {
								$array = $alertArray[$alertype];
								array_push($array, $nextpost);
								$alertArray[$alertype] = $array;
							} else {
								$array = array();
								array_push($array, $nextpost);
								$alertArray[$alertype] = $array;
							}
							break;

						// USER SPECIFIC ALERTS
						case $CFG->ALERT_UNSEEN_BY_ME:
						case $CFG->ALERT_RESPONSE_TO_ME:
						case $CFG->ALERT_UNRATED_BY_ME:
						case $CFG->ALERT_INTERESTING_TO_ME:
						case $CFG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME:
						case $CFG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME:
						case $CFG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE:
						case $CFG->ALERT_PEOPLE_WHO_AGREE_WITH_ME:
						case $CFG->ALERT_UNSEEN_RESPONSE:
						case $CFG->ALERT_UNSEEN_COMPETITOR:
							if ($userid != null && $userid != "") {
								if (array_key_exists($userid, $userArray)) {
									$typesarray = $userArray[$userid];
									if (array_key_exists($alertype,$typesarray)) {
										$postArray = $typesarray[$alertype];
										array_push($postArray, $nextpost);
										$typesarray[$alertype] = $postArray;
										$userArray[$userid] = $typesarray;
									} else {
										$postArray = array();
										array_push($postArray, $nextpost);
										$typesarray[$alertype] = $postArray;
										$userArray[$userid] = $typesarray;
									}
								} else {
									$typesarray = array();
									$postArray = array();
									array_push($postArray, $nextpost);
									$typesarray[$alertype] = $postArray;
									$userArray[$userid] = $typesarray;
								}
							}
							break;
						default:
							// Do nothing
					}
				}
			}

			$data = new alertdata();
			$data->alertarray = $alertArray; //nodes by alert type
			$data->userarray = $userArray; // nodes by user by alert type
			$data->nodes = $finalNodeArray;
			$data->users = $finalUserArray;
			//$data->users = $reader->userSet; //users

			//error_log(count($finalNodeArray->nodes));
			//error_log(print_r($data, true));
		}
	} else {
		//error_log("DATA FOUND: getUserAlertData");
	}

	return $data;
}

function getDataFromJsonld($url) {
	global $HUB_FLM;
	require_once($HUB_FLM->getCodeDirPath("core/io/catalyst/catalyst_jsonld_reader.class.php"));
	$withhistory = false;
	$withvotes = false;
	$reader = new catalyst_jsonld_reader();
	$reader = $reader->load($url, $withhistory, $withvotes);
	class cifdata {}
	$data = new cifdata();
	$data->connections = $reader->connectionSet;
	$data->nodes = $reader->nodeSet;
	return $data;
}

/**
 * Import nodes and connections from the given CIF url for the selected nodeids.
 * If selectedids is an empty string, import all nodes in the CIF data.
 * The node import limit is set by '$CFG->ImportLimit'.
 * @param url the url for the CIF data to load
 * @param private true if the data should be created as private, else false.
 * @param selectedids an array of the CIF node ides to import
 * @return NodeSet or Error.
 *
 */
function addNodesFromJsonld($url, $private, $selectedids="") {
	global $USER, $HUB_FLM, $CFG;
	require_once($HUB_FLM->getCodeDirPath("core/io/catalyst/catalyst_jsonld_reader.class.php"));
    require_once($HUB_FLM->getCodeDirPath("core/lib/url-validation.class.php"));

	if (count($selectedids) > $CFG->ImportLimit) {
		$ERROR = new error();
		$ERROR->createAccessDeniedError();
		return $ERROR;
	}

	$withhistory = false;
	$withvotes = false;
	$reader = new catalyst_jsonld_reader();
	$reader = $reader->load($url, $withhistory, $withvotes);

	if (!$reader instanceof Error) {
		$nodeset = $reader->nodeSet;
		$nodes = $nodeset->nodes;
		$count = count($nodes);
		if ($count > $CFG->ImportLimit) {
			$ERROR = new error();
			$ERROR->createAccessDeniedError();
			return $ERROR;
		}

		$newnodeSet = new NodeSet();

		if ($selectedids != "") {
			for ($i=0; $i<$count; $i++) {
				$node = $nodes[$i];
				if (in_array($node->nodeid, $selectedids)) {
					$role = getRoleByName($node->rolename);
					$newnode = addNode($node->name,$node->description,$private,$role->roleid);
					if (!$newnode instanceof Error) {
						if (isset($node->homepage) && $node->homepage != "") {
							$URLValidator = new mrsnk_URL_validation($node->homepage, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
							if($URLValidator->isValid()){
								$urlObj = addURL($node->homepage, $node->homepage, "", $private, "", "", "", "cohere", "");
								$newnode->addURL($urlObj->urlid, "");
								// Add url to group? - not done on forms at present
							} else {
								error_log('Invalid node homepage: '.$node->homepage. ': for '.$node->nodeid);
							}
						}

						if (isset($node->users[0])) {
							$user = $node->users[0];
							if (isset($user->homepage) && $user->homepage !="") {
								$URLValidator = new mrsnk_URL_validation($user->homepage, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
								if($URLValidator->isValid()){
									$urlObj = addURL($user->homepage, $user->homepage, "", $private, "", "", "", "cohere", "");
									$newnode->addURL($urlObj->urlid, "");
									// Add url to group? - not done on forms at present
								} else {
									error_log('Invalid user homepage: '.$user->homepage. ': for '.$user->userid);
								}
							}
						}

						//if ($groupid != "") {
						//	$newnode->addGroup($groupid);
						//}
						$newnodeSet->add($newnode);
					} else {
						error_log(print_r($newnode, true));
					}
				}
			}
		} else { // load all nodes.
			for ($i=0; $i<$count; $i++) {
				$node = $nodes[$i];
				$role = getRoleByName($node->rolename);
				$newnode = addNode($node->name,$node->description,$private,$role->roleid);
				if (!$newnode instanceof Error) {
					if (isset($node->homepage) && $node->homepage != "") {
						$URLValidator = new mrsnk_URL_validation($node->homepage, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
						if($URLValidator->isValid()){
							$urlObj = addURL($node->homepage, $node->homepage, "", $private, "", "", "", "cohere", "");
							$newnode->addURL($urlObj->urlid, "");
							// Add url to group? - not done on forms at present
						} else {
							error_log('Invalid node homepage: '.$node->homepage. ': for '.$node->nodeid);
						}
					}
					if (isset($node->users[0])) {
						$user = $node->users[0];
						if (isset($user->homepage) && $user->homepage !="") {
							$URLValidator = new mrsnk_URL_validation($user->homepage, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
							if($URLValidator->isValid()){
								$urlObj = addURL($user->homepage, $user->homepage, "", $private, "", "", "", "cohere", "");
								$newnode->addURL($urlObj->urlid, "");
								// Add url to group? - not done on forms at present
							} else {
								error_log('Invalid user homepage: '.$user->homepage. ': for '.$user->userid);
							}
						}
					}
				} else {
					error_log(print_r($newnode, true));
				}
				//if ($groupid != "") {
				//	$newnode->addGroup($groupid);
				//}

				$newnodeSet->add($newnode);
			}
		}
		return $newnodeSet;
	} else {
		return $reader;
	}
}

/**
 * Import nodes and connections from the given CIF url for the selected nodeids into the given map.
 * The node import limit is set by '$CFG->ImportLimit'.
 * @param url the url for the CIF data to load
 * @param mapid the id of the map to get alerts for
 * @param selectedids an array of the CIF node ides to import
 * @param poses an array of the positions of the nodes in the map each array item is in
 * the format 'x:y' and the position in the array should correspond ot the position of
 * its node in the selectednodeids array.
 * before it is considered out of date and should be refetched and recalculated.
 * Defaults to 60 seconds.
 * @param private true if the data should be created as private, else false.
 * @return View object of the map or Error.
 *
 */
function addNodesAndConnectionsFromJsonld($url, $mapid, $selectedids, $poses, $private) {
	global $USER, $HUB_FLM, $CFG, $ERROR;
	require_once($HUB_FLM->getCodeDirPath("core/io/catalyst/catalyst_jsonld_reader.class.php"));
    require_once($HUB_FLM->getCodeDirPath("core/lib/url-validation.class.php"));

	//error_log(print_r($selectedids, true));
	if (count($selectedids) > $CFG->ImportLimit) {
		$ERROR = new error();
		$ERROR->createAccessDeniedError();
		return $ERROR;
	}

	//error_log(print_r($poses, true));

	// Check if the map is in a group and if so get the group id.
	$groupid = "";
    $v = new View($mapid);
    $view = $v->load();
	if (!$view instanceof Error) {
		if (isset($view->viewnode->groups)) {
			$groups = $view->viewnode->groups;
			if (count($groups) > 0) {
				$groupid = $groups[0]->groupid;
			}
		}
	} else {
		return $view;
	}

	// make sure current user in group, if group set.
	if ($groupid != "") {
		$group = new Group($groupid);
		if (!$group instanceof Error) {
			if (!$group->ismember($USER->userid)) {
				$error = new Error();
				return $error->createNotInGroup($group->name);
			}
		}
	}

	$withhistory = false;
	$withvotes = false;
	$reader = new catalyst_jsonld_reader();
	$reader = $reader->load($url, $withhistory, $withvotes);

	if (!$reader instanceof Error) {
		$nodeset = $reader->nodeSet;
		$nodes = $nodeset->nodes;
		$count = count($nodes);
		$newnodeSet = new NodeSet();
		$newNodeCheck = array();

		for ($i=0; $i<$count; $i++) {
			$node = $nodes[$i];
			$position = array_search($node->nodeid, $selectedids);
			//error_log("position:".$position);
			if ($position !== FALSE) {
				$position = intval($position);
				$positem = $poses[$position];
				$positemArray = explode(":", $positem);
				$xpos = "";
				$ypos = "";
				if (count($positemArray) == 2) {
					$xpos = $positemArray[0];
					$ypos = $positemArray[1];
				}
				//error_log("xpos:".$xpos.":ypos:".$ypos);

				$role = getRoleByName($node->rolename);

				$description = "";
				if (isset($node->description)) {
					$description = $node->description;
				}

				$newnode = addNode($node->name,$description,$private,$role->roleid);
				//error_log(print_r($newnode, true));
				if (!$newnode instanceof Error) {
					$newNodeCheck[$node->nodeid] = $newnode;
					//error_log($node->nodeid);

					// if we have positioning information add the node to the map.
					if ($xpos != "" && $ypos != "") {
				    	$viewnode = $view->addNode($newnode->nodeid, $xpos, $ypos);
						//if (!$viewnode instanceof Error) {
					}

					if (isset($node->homepage) && $node->homepage != "") {
						$URLValidator = new mrsnk_URL_validation($node->homepage, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
						if($URLValidator->isValid()){
							$urlObj = addURL($node->homepage, $node->homepage, "", $private, "", "", "", "cohere", "");
							$newnode->addURL($urlObj->urlid, "");
							// Add url to group? - not done on forms at present
						} else {
							error_log('Invalid node homepage: '.$node->homepage. ': for '.$node->nodeid);
						}
					}

					if (isset($node->users[0])) {
						$user = $node->users[0];
						if (isset($user->homepage) && $user->homepage !="") {
							$URLValidator = new mrsnk_URL_validation($user->homepage, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
							if($URLValidator->isValid()){
								$urlObj = addURL($user->homepage, $user->homepage, "", $private, "", "", "", "cohere", "");
								$newnode->addURL($urlObj->urlid, "");
								// Add url to group? - not done on forms at present
							} else {
								error_log('Invalid user homepage: '.$user->homepage. ': for '.$user->userid);
							}
						}
					}

					//if ($groupid != "") {
					//	$newnode->addGroup($groupid);
					//}
					$newnodeSet->add($newnode);
				} else {
					error_log(print_r($newnode, true));
				}
			}
		}

		$connectionset = $reader->connectionSet;
		$connections = $connectionset->connections;
		$count = count($connections);
		for ($i=0; $i<$count; $i++) {
			$conn = $connections[$i];
			$from = $conn->from;
			$to = $conn->to;
			$fromrole = $conn->fromrole;
			$torole = $conn->torole;

			if (isset($newNodeCheck[$from->nodeid]) && isset($newNodeCheck[$to->nodeid])) {

				$newFromNode = $newNodeCheck[$from->nodeid];
				$newToNode = $newNodeCheck[$to->nodeid];

				// Might not need this as it might be done already
				//if ($newFromNode->role->name != $fromrole->name) {
				//	updateNodeRole($newFromNode->nodeid,$fromrole->name);
				//}

				$linklabelname = $conn->linklabelname;
				//error_log($linklabelname);
				$lt = getLinkTypeByLabel($linklabelname);
				if (!$lt instanceof Error) {
					$linkType = $lt->linktypeid;

					//$frole = getRoleByName($fromrole->name);
					//$trole = getRoleByName($torole->name);

					$connection = addConnection($newFromNode->nodeid, $newFromNode->role->roleid, $linkType, $newToNode->nodeid, $newToNode->role->roleid, 'N', "");
					//error_log(print_r($connection, true));
					if (!$connection instanceof Error) {
						// add to group
						if (isset($groupid) && $groupid != "") {
							$connection->addGroup($groupid);
						}

						$viewcon = $view->addConnection($connection->connid);
						//error_log(print_r($viewcon,true));
					} else {
						error_log(print_r($connection, true));
					}
				} else {
					error_log("for label:".$linklabelname.":".print_r($lt, true));
				}
			}
		}
	} else {
		return $reader;
	}
	return $view;
}

// ensure there are no spaces or blank lines after this closing tag
?>