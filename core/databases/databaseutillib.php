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
 * Database Utility library
 */

/**
 * Create the SQL ORDER BY clause for nodes
 *
 * @param string $o order by column
 * @param string $s sort order (ASC or DESC)
 * @return string
 */
function nodeOrderString($o,$s){
    global $CFG, $HUB_FLM,$HUB_SQL;

    //check order by param is valid
    switch ($o) {
        case "date":
            $orderby = "t.CreationDate";
            break;
        case "tagid":
        case "nodeid":
            $orderby = "t.NodeID";
            break;
        case "name":
            $orderby = "t.Name";
            break;
        case "desc":
            $orderby = "t.Description";
            break;
        case "moddate":
            $orderby = "t.ModificationDate";
            break;
        case "lastlogin":
            $orderby = "t.LastLogin";
            break;
        case "connectedness":
            $orderby = "connectedness";
            break;
        case "vote":
        	$orderby = "vote";
        	break;
        case "url":
        	$orderby = "r.url";
        	break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidOrderbyError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

    //check sort param is valid
    switch ($s) {
        case "ASC":
            $sort = $HUB_SQL->ASC;
            break;
        case "DESC":
            $sort = $HUB_SQL->DESC;
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidSortError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

	if ($o == 'vote') {
		$str = $HUB_SQL->ORDER_BY.$orderby." ".$sort.", weight ".$HUB_SQL->DESC.", CreationDate ".$HUB_SQL->DESC;
	} else {
		$str = $HUB_SQL->ORDER_BY.$orderby." ".$sort;
	}

    return $str;
}

/**
 * Create the SQL ORDER BY clause for users
 *
 * @param string $o order by column
 * @param string $s sort order (ASC or DESC)
 * @return string
 */
function userOrderString($o,$s){
    global $CFG, $HUB_FLM,$HUB_SQL;

    //check order by param is valid
    switch ($o) {
        case "date":
            $orderby = "t.CreationDate";
            break;
        case "moddate":
            $orderby = "t.ModificationDate";
            break;
        case "lastlogin":
            $orderby = "t.LastLogin";
            break;
        case "lastactive":
        	$orderby = "t.LastActive";
        	break;
        case "name":
        	$orderby = "t.Name";
        	break;
        case "connectedness":
            $orderby = "connectedness";
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidOrderbyError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

    //check sort param is valid
    switch ($s) {
        case "ASC":
            $sort = $HUB_SQL->ASC;
            break;
        case "DESC":
            $sort = $HUB_SQL->DESC;
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidSortError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

    $str = $HUB_SQL->ORDER_BY.$orderby." ".$sort;

    return $str;
}

/**
 * Create the SQL ORDER BY clause for groups
 *
 * @param string $o order by column
 * @param string $s sort order (ASC or DESC)
 * @return string
 */
function groupOrderString($o,$s){
    global $CFG, $HUB_FLM,$HUB_SQL;

    //check order by param is valid
    switch ($o) {
        case "date":
            $orderby = "t.CreationDate";
            break;
        case "moddate":
            $orderby = "t.ModificationDate";
            break;
        case "name":
        	$orderby = "t.Name";
        	break;
        case "members":
            $orderby = "members";
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidOrderbyError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

    //check sort param is valid
    switch ($s) {
        case "ASC":
            $sort = $HUB_SQL->ASC;
            break;
        case "DESC":
            $sort = $HUB_SQL->DESC;
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidSortError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

    $str = $HUB_SQL->ORDER_BY.$orderby." ".$sort;

    return $str;
}

/**
 * Create the SQL ORDER BY clause for urls
 *
 * @param string $o order by column
 * @param string $s sort order (ASC or DESC)
 * @return string
 */
function urlOrderString($o,$s){
    global $CFG, $HUB_FLM,$HUB_SQL;

    //check order by param is valid
    switch ($o) {
        case "date":
            $orderby = "t.CreationDate";
            break;
        case "moddate":
            $orderby = "t.ModificationDate";
            break;
        case "connectedness":
            $orderby = "connectedness";
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidOrderbyError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

    //check sort param is valid
    switch ($s) {
        case "ASC":
            $sort = $HUB_SQL->ASC;
            break;
        case "DESC":
            $sort = $HUB_SQL->DESC;
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidSortError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

   	$str = $HUB_SQL->ORDER_BY.$orderby ." " .$sort;

    return $str;
}

/**
 * Create the SQL ORDER and LIMIT BY clause for connections
 *
 * @param integer $start start row
 * @param integer $max max number of rows to return
 * @param string $o order by column
 * @param string $s sort order (ASC or DESC)
 * @return string
 */
function connectionOrderString($o,$s){
    global $CFG, $HUB_FLM,$HUB_SQL;

    //check order by param is valid
    switch ($o) {
        case "date":
            $orderby = "t.CreationDate";
            break;
        case "moddate":
            $orderby = "t.ModificationDate";
            break;
        case "vote":
        	$orderby = "vote";
        	break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidOrderbyError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

    //check sort param is valid
    switch ($s) {
        case "ASC":
            $sort = $HUB_SQL->ASC;
            break;
        case "DESC":
            $sort = $HUB_SQL->DESC;
            break;
        default:
            global $ERROR;
            $ERROR = new Hub_Error;
            $ERROR->createInvalidSortError();
            include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            die;
    }

	if ($o == 'vote') {
		$str = $HUB_SQL->ORDER_BY.$orderby." ".$sort.", weight ".$HUB_SQL->DESC.", CreationDate ".$HUB_SQL->DESC;
	} else {
		$str = $HUB_SQL->ORDER_BY.$orderby." ".$sort;
	}

    return $str;
}

/**
 * Get the connections for the given netowrk search paramters from the given node.
 *
 * @param string $scope (either 'all' or 'my', deafult 'all')
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param string $nodeid the id of the node to search outward from.
 * @param integer $depth (optional, 1-7, default 1);
 * @param string $linklabels Array of strings of link types. Array length must match depth specified. Each array level is mutually exclusive with linkgroups - there can only be one.
 * @param string $linkgroups Array of either Positive, Negative, or Neutral - default: empty string). Array length must match depth specified.Each array level is mutually exclusive with linklabels - there can only be one.
 * @param string $directions Array of 'outgoing', 'incmong', or 'both' - default: 'both'. Array length must match depth specified.
 * @param string $nodetypes Array of strings of node type names. Array length must match depth specified.
 * @param string $nodeids Array of strings of nodeids. Array length must match depth specified.
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByPathByDepthAND($logictype = 'or', $scope='all', $labelmatch='false', $nodeid, $depth=1, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath='true', $style='long', $status){
    global $DB,$USER,$CFG,$HUB_SQL;

	// GET TEXT FOR PASSED IDEA ID IF REQUIRED
	$text = "";
	if ($labelmatch == 'true') {
		$params = array();
		$params[0] = $nodeid;
		$sql = $HUB_SQL->UTILLIB_NODE_NAME_BY_NODEID;
		$resArray = $DB->select($sql, $params);
		$array = array();
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$text = $array['Name'];
			}
		} else {
			return database_error();
		}
	}

	$messages = '';

	$matchesFound = array();
	if (($labelmatch == 'true' && $text != "") || ($labelmatch == 'false' && $nodeid != "")) {
		$checkConnections = array();
		$matchedConnections = array();
		if ($labelmatch == 'true') {
			$nextNodes[0] = $text;
		} else {
			$nextNodes[0] = $nodeid;
		}
		$matchesFound = searchNetworkConnectionsByDepth($checkConnections, $matchedConnections, $nextNodes, $labelmatch, $depth, 0, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath, $scope, $status, $messages);
	}
	//return database_error($messages);

	//aggregate the connections that made it to last level
	$results = array();
	getDepthConnectionResults($results, $matchesFound);

	$cs = new ConnectionSet();
	return $cs->loadConnections($results, $style);

}

/**
 * Get the connections for the given netowrk search paramters from the given node.
 *
 * @param string $scope (either 'all' or 'my', deafult 'all')
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param string $nodeid the id of the node to search outward from.
 * @param integer $depth (optional, 1-7, default 1);
 * @param string $linklabels Array of strings of link types. Array length must match depth specified. Each array level is mutually exclusive with linkgroups - there can only be one.
 * @param string $linkgroups Array of either Positive, Negative, or Neutral - default: empty string). Array length must match depth specified.Each array level is mutually exclusive with linklabels - there can only be one.
 * @param string $directions Array of 'outgoing', 'incmong', or 'both' - default: 'both'. Array length must match depth specified.
 * @param string $nodetypes Array of strings of node type names. Array length must match depth specified.
 * @param string $nodeids Array of strings of nodeids. Array length must match depth specified.
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @return ConnectionSet or Error
 */
function getConnectionsByPathByDepthOR($scope='all', $labelmatch='false', $nodeid, $depth=1, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath='true', $style='long', $status){
    global $DB,$USER,$CFG,$HUB_SQL;

	// GET TEXT FOR PASSED IDEA ID IF REQUIRED
	$text = "";
	if ($labelmatch == 'true') {
		$params = array();
		$params[0] = $nodeid;
		$sql = $HUB_SQL->UTILLIB_NODE_NAME_BY_NODEID;
		$resArray = $DB->select($sql, $params);
		$array = array();
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$text = $array['Name'];
			}
		} else {
			return database_error();
		}
	}

	$messages = '';
	$matchesFound = array();

	if (($labelmatch == 'true' && $text != "") || ($labelmatch == 'false' && $nodeid != "")) {
		$checkConnections = array();
		$matchedConnections = array();
		if ($labelmatch == 'true') {
			$nextNodes[0] = $text;
		} else {
			$nextNodes[0] = $nodeid;
		}
		$matchesFound = searchNetworkConnectionsByDepthOR($checkConnections, $matchedConnections, $nextNodes, $labelmatch, $depth, 0, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath, $scope, $status, $messages);
	}
	//return database_error($messages);

	$cs = new ConnectionSet();
	return $cs->loadConnections($matchesFound, $style);
}

/**
 * Walk the network matching connection based on the passed criteria.
 * Starting from the given list of node labels/ids. (which always starts with 1, the focal node);
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 */
function searchNetworkConnections($checkConnections, $matches, $nextNodes, $linklabels='', $linkLabelsArray, $linkgroup='', $labelmatch='false', $depth=7, $currentdepth=0, $direction='both', $nodeTypeNames='', $nodeTypeNamesArray, $scope='all', $status=0) {
    global $DB,$USER,$CFG,$HUB_SQL;

	$message="";
	$message .= "currentdepth=".$currentdepth;

   	$currentdepth++;

   	// if depth is set to 7, then keep going as 7 = full depth.
	if (/*$depth < 7 &&*/ $currentdepth > $depth) {
		return $matches;
	}

	$params = array();
	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

    $tempNodes = array();
	$allConnections = array();

	$searchNodeArray = array();
	$searchNodes = "";
	$loopCount = 0;
	foreach ($nextNodes as $next) {
		$searchNodeArray[$loopCount] = $next;
		if ($loopCount == 0) {
		    $searchNodes .= "?";
		} else {
		    $searchNodes .= ",?";
		}
		$loopCount++;
	}

	$message .= ":searchNodes=".$searchNodes;
	$message .= ":linkgroup=".$linkgroup;
	$message .= ":linklabels=".$linklabels;
	$message .= ":nodeTypeNames=".$nodeTypeNames;

	if ($searchNodes != "") {
		$qry = $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_SELECT;

		// Add the node matching
		if ($labelmatch == 'true') {
			if ($direction == "outgoing") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART2.$HUB_SQL->AND;
			} else if ($direction == "incoming") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART2.$HUB_SQL->AND;
			} else if ($direction == "both") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->OPENING_BRACKET.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART2;
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART2.$HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
			}
		} else {
			if ($direction == "outgoing") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART2.$HUB_SQL->AND;
			} else if ($direction == "incoming") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART2.$HUB_SQL->AND;
			} else if ($direction == "both") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->OPENING_BRACKET.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART2;
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART2.$HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
			}
		}

		if ($nodeTypeNames != "") {
			$params = array_merge($params, $nodeTypeNamesArray);
			$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_FROM_PART1.$nodeTypeNames.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_FROM_PART2.$HUB_SQL->AND;

			$params = array_merge($params, $nodeTypeNamesArray);
			$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_TO_PART1.$nodeTypeNames.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_TO_PART2.$HUB_SQL->AND;
		}

		/** Add the link matching **/
		if ($linkgroup != "" && $linkgroup != "All") {
			$params[count($params)] = $linkgroup;
			$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKGROUP.$HUB_SQL->AND;
		} else if ($linklabels != "") {
			$params = array_merge($params, $linkLabelsArray);
			$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKLABEL_PART1.$linklabels.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKLABEL_PART2.$HUB_SQL->AND;
		}

		/** Add the privacy / user permissions **/
		if ($scope == "my") {
			$params[count($params)] = $currentuser;
			$qry .= $HUB_SQL->FILTER_USER.$USER->userid."'";
		} else {
		    $params[count($params)] = 'N';
			$params[count($params)] = $currentuser;
			$params[count($params)] = $currentuser;
			$params[count($params)] = 'N';
			$params[count($params)] = $currentuser;
			$params[count($params)] = $currentuser;

			$qry .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS_NODES;
		}

		// FILTER STATUS
		$params[count($params)] = $status;
		$qry .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;

		$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_ORDER_BY;

		//$message .= ":".$qry;
		//return $message;
		//echo $qry;

		$allConnections = $DB->select($qry, $params);

		//error_log(print_r($qry, true));

		if ($allConnections === false) {
			return database_error();
		}
	}

	$count = 0;
	if (is_countable($allConnections)) {
		$count = count($allConnections);
	}
	$innercount = 0;
	if (is_countable($nextNodes)) {
		$innercount = count($nextNodes);
	}
	$found = false;

    for ($i=0; $i < $count; $i++) {
        $nextarray = $allConnections[$i];

		$message .= ":".$nextarray['TripleID'];

		if (!isset($checkConnections[(string)$nextarray['TripleID']]) || $checkConnections[(string)$nextarray['TripleID']] == "") {
			$checkConnections[(string)$nextarray['TripleID']] = $nextarray;

			$found = false;

			if ($labelmatch == 'true') {
				for($j=0; $j < $innercount; $j++) {
					$label = $nextNodes[$j];
					if ($direction == "outgoing") {
						if ($label == $nextarray['FromLabel']) {
							$found = true;
							$tempNodes[count($tempNodes)] = $nextarray['ToLabel'];
							break;
						}
					} else if ($direction == "incoming") {
						if ($label == $nextarray['ToLabel']) {
							$found = true;
							$tempNodes[count($tempNodes)] = $nextarray['FromLabel'];
							break;
						}
					} else if ($direction == "both") {
						if ($label == $nextarray['FromLabel'] || $label == $nextarray['ToLabel']) {
							$found = true;
							if ($label == $nextarray['FromLabel']) {
								$tempNodes[count($tempNodes)] = $nextarray['ToLabel'];
							}
							if ($label == $nextarray['ToLabel']) {
								$tempNodes[count($tempNodes)] = $nextarray['FromLabel'];
							}
							break;
						}
					}
				}
			}
			else {
				for($j=0; $j < $innercount; $j++) {
					$next = $nextNodes[$j];
					if ($direction == "outgoing") {
						if ($next == $nextarray['FromID']) {
							$found = true;
							$tempNodes[count($tempNodes)] = $nextarray['ToID'];
							break;
						}
					} else if ($direction == "incoming") {
						if ($next == $nextarray['ToID']) {
							$found = true;
							$tempNodes[count($tempNodes)] = $nextarray['FromID'];
							break;
						}
					} else if ($direction == "both") {
						if ($next == $nextarray['FromID'] || $next == $nextarray['ToID']) {
							$found = true;
							if ($next == $nextarray['FromID']) {
								$tempNodes[count($tempNodes)] = $nextarray['ToID'];
							}
							if ($next == $nextarray['ToID']) {
								$tempNodes[count($tempNodes)] = $nextarray['FromID'];
							}
							break;
						}
					}
				}
			}

			if ($found == true) {
				$message .= ":found".$nextarray['TripleID'];
				$matchcount = 0;
				if(is_countable($matches)) {
					$matchcount = count($matches);
				}
				$matches[$matchcount] = $nextarray;
			}
		}
	}

    if (count($tempNodes) > 0) {
		$message .= ":".count($tempNodes);
        $matches = searchNetworkConnections($checkConnections, $matches, $tempNodes, $linklabels, $linkLabelsArray, $linkgroup, $labelmatch, $depth, $currentdepth, $direction, $nodeTypeNames, $nodeTypeNamesArray, $scope, $status);
    }

	//return $message;
    return $matches;
}

/**
 * Run the sql to get the nodes based on the given parameters.
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 */
function getNetworkConnectionNodesByDepth($currentdepth, $depthnodeid, $nextNodes, $labelmatch='false', $links, $linkgroup, $direction, $roles, $uniquepath='true', $scope, $status=0, &$message) {
	global $DB,$USER,$HUB_SQL;

	$allConnections = array();

	$params = array();
	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$depthnodelabel = "";

	if ($depthnodeid != "") {
		if ($labelmatch == 'true') {
			$tempparams = array();
			$tempparams[0] = $depthnodeid;
			$sql = $HUB_SQL->UTILLIB_NODE_NAME_BY_NODEID;
			$resArray = $DB->select($sql, $tempparams);
			$array = array();
			if ($resArray !== false) {
				$count = 0;
				if (is_countable($resArray)) {
					$count = count($resArray);
				}
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$depthnodelabel = $array['Name'];
				}
			} else {
				return database_error();
			}
		}
	}

	$searchLinkLabels = "";
	$searchLinkLabelsArray = array();
	if ($links != "" && $linkgroup == "") {
		$pieces = explode(",", $links);
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

	$searchNodes = "";
	$searchNodeArray = array();
	$loopCount = 0;
	foreach ($nextNodes as $next) {
		$searchNodeArray[$loopCount] = $next;
		if ($loopCount == 0) {
		    $searchNodes .= "?";
		} else {
		    $searchNodes .= ",?";
		}
		$loopCount++;
	}

    $searchRoles = "";
	$searchRolesArray = array();
    $pieces = explode(",", $roles);
    $loopCount = 0;
    foreach ($pieces as $value) {
		$searchRolesArray[$loopCount] = $value;
        if ($loopCount == 0) {
        	$searchRoles .= "?";
        } else {
        	$searchRoles .= ",?";
        }
        $loopCount++;
    }

	$message .= ":searchNodes=".$searchNodes;
	$message .= ":linkgroup=".$linkgroup;
	$message .= ":linklabels=".$links;
	$message .= ":roles=".$roles;
	$message .= ":direction=".$direction;

	if ($searchNodes != "") {
		$qry = $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_SELECT;

		// Add Node / Node Type Matching
		if ($depthnodeid !="") {
			if ($labelmatch == 'true') {
				if ($direction == "outgoing") {
					$param[count($param)] = $depthnodelabel;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_TO_LABEL.$HUB_SQL->AND;
				} else if ($direction == "incoming") {
					$param[count($param)] = $depthnodelabel;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_FROM_LABEL.$HUB_SQL->AND;
				} else if ($direction == "both") {
					$param[count($param)] = $depthnodelabel;
					$param[count($param)] = $depthnodelabel;
					$qry .= $HUB_SQL->OPENING_BRACKET;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_TO_LABEL;
					$qry .= $HUB_SQL->OR;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_FROM_LABEL;
					$sqy .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
				}
			} else {
				if ($direction == "outgoing") {
					$param[count($param)] = $depthnodeid;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_TO_ID.$HUB_SQL->AND;
				} else if ($direction == "incoming") {
					$param[count($param)] = $depthnodeid;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_FROM_ID.$HUB_SQL->AND;
				} else if ($direction == "both") {
					$param[count($param)] = $depthnodeid;
					$param[count($param)] = $depthnodeid;
					$qry .= $HUB_SQL->OPENING_BRACKET;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_TO_ID;
					$qry .= $HUB_SQL->OR;
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_FROM_ID;
					$sqy .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
				}
			}
		}
		// IF ROLES
		else if ($roles != "") {
			$nodetypes[$currentdepth-1] = $searchRoles;
			if ($searchRoles != "") {
				if ($direction == "outgoing") {
					$params = array_merge($params, $searchRolesArray);
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_TO_PART1.$searchRoles.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_TO_PART2.$HUB_SQL->AND;
				} else if ($direction == "incoming") {
					$params = array_merge($params, $searchRolesArray);
					$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_FROM_PART1.$searchRoles.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_FROM_PART2.$HUB_SQL->AND;
				} else if ($direction == "both") {
					if ($currentdepth == 1) {
						if ($labelmatch == 'true') {
							$focalnodelabel = $nextNodes[0];

							$nodesSet =  getNodesByName($focalnodelabel,0,-1);
							$nodes = $nodesSet->nodes;
							$rolenames = "";
							$rolenamesArray = array();
							$rolenamescheck = array();
							$loopCount = 0;
							foreach ($nodes as $node) {
								if (isset($node->role->name)) {
									if (!in_array($node->role->name, $rolenamescheck)) {
										$rolenamesArray[$loopCount] = $node->role->name;
										if ($loopCount == 0) {
											$rolenames .= "?";
										} else {
											$rolenames .= ",?";
										}
										$loopCount++;
										array_push($rolenamescheck,$node->role->name);
									}
								}
							}

							$message .= ":previousroles=".$rolenames;

							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART1;
							$params = array_merge($params, $searchRolesArray);
							$qry .= $searchRoles;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART2;
							$params = array_merge($params, $rolenamesArray);
							$qry .= $rolenames;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART3;
							$params = array_merge($params, $searchRolesArray);
							$qry .= $searchRoles;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART4;
							$params = array_merge($params, $rolenamesArray);
							$qry .= $rolenames;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART5.$HUB_SQL->AND;

						} else {
							$focalnodeid = $nextNodes[0];
							$node = getNode($focalnodeid);
							$rolename = $node->role->name;

							$message .= ":previousrole=".$rolename."";

							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_ONE_PART1;
							$params = array_merge($params, $searchRolesArray);
							$qry .= $searchRoles;
							$params[count($params)] = $rolename;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_ONE_PART2;
							$params = array_merge($params, $searchRolesArray);
							$qry .= $searchRoles;
							$params[count($params)] = $rolename;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_ONE_PART3.$HUB_SQL->AND;
						}
					} else if ($currentdepth > 1) {
						$previousnodetypes = $nodetypes[$currentdepth-2];

						$previousSearchRoles = "";
						$previousSearchRolesArray = array();
						$pieces = explode(",", $previousnodetypes);
						$loopCount = 0;
						foreach ($pieces as $value) {
							$previousSearchRolesArray[$loopCount] = $value;
							if ($loopCount == 0) {
								$previousSearchRoles .= "?";
							} else {
								$previousSearchRoles .= ",?";
							}
							$loopCount++;
						}

						$message .= ":previousnodetype=".$previousnodetypes;
						if ($previousnodetypes != "") {
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART1;
							$params = array_merge($params, $searchRolesArray);
							$qry .= $searchRoles;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART2;
							$params = array_merge($params, $previousSearchRolesArray);
							$qry .= $previousSearchRoles;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART3;
							$params = array_merge($params, $searchRolesArray);
							$qry .= $searchRoles;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART4;
							$params = array_merge($params, $previousSearchRolesArray);
							$qry .= $previousSearchRoles;
							$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART5.$HUB_SQL->AND;
						}
					}
				}
			}
		}

		// Add the node matching
		if ($labelmatch == 'true') {
			if ($direction == "outgoing") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART2.$HUB_SQL->AND;
			} else if ($direction == "incoming") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART2.$HUB_SQL->AND;
			} else if ($direction == "both") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->OPENING_BRACKET;
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART2;
				$qry .= $HUB_SQL->OR;
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART2;
				$qry .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
			}
		} else {
			if ($direction == "outgoing") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART2.$HUB_SQL->AND;
			} else if ($direction == "incoming") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART2.$HUB_SQL->AND;
			} else if ($direction == "both") {
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->OPENING_BRACKET;
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART2;
				$qry .= $HUB_SQL->OR;
				$params = array_merge($params, $searchNodeArray);
				$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART1.$searchNodes.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART2;
				$qry .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
			}
		}

		/** Add the link matching **/
		if ($linkgroup != "" && $linkgroup != "All") {
			$params[count($params)] = $linkgroup;
			$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKGROUP.$HUB_SQL->AND;
		} else if ($links != "") {
			$params = array_merge($params, $searchLinkLabelsArray);
			$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKLABEL_PART1.$searchLinkLabels.$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKLABEL_PART2.$HUB_SQL->AND;
		}

		/** Add the privacy / user permissions **/
		if ($scope == "my") {
			$params[count($params)] = $currentuser;
			$qry .= $HUB_SQL->FILTER_USER;
		} else {
		    $params[count($params)] = 'N';
			$params[count($params)] = $currentuser;
			$params[count($params)] = $currentuser;
			$params[count($params)] = 'N';
			$params[count($params)] = $currentuser;
			$params[count($params)] = $currentuser;

			$qry .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS_NODES;
		}

		// FILTER STATUS
		$params[count($params)] = $status;
		$qry .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_STATUS;


		$qry .= $HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ORDER_BY;

		/*if ($currentdepth == 2) {
			$myFile = $CFG->dirAddress."MICHELLE1.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = $qry;
			fwrite($fh, $stringData);
			fclose($fh);
		}*/

		$message .= ":".$qry;

		//error_log(print_r($params, true));
		//error_log(print_r($qry, true));

		$allConnections = $DB->select($qry, $params);
		if ($allConnections === false) {
			return database_error();
		}
	}
	return $allConnections;
}

/**
 * Walk the network matching connection based on the passed criteria.
 * Starting from the given list of node labels/ids. (which always starts with 1, the focal node);
 *
 * @param array $checkConnections the id of the connections looked at so far - you to check same connections not processde more than once.
 * @param array $matches the id of the connections mathed.
 * @param array $nextNodes the id of the nodes to search outward from on this loop.
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param integer $depth (optional, 1-7, default 1);
 * @param integer $currentdepth depth of current loop.
 * @param string $linklabels Array of strings of link types. Array length must match depth specified. Each array level is mutually exclusive with linkgroups - there can only be one.
 * @param string $linkgroups Array of either Positive, Negative, or Neutral - default: empty string). Array length must match depth specified.Each array level is mutually exclusive with linklabels - there can only be one.
 * @param string $directions Array of 'outgoing', 'incmong', or 'both - default: 'both'. Array length must match depth specified.
 * @param string $nodetypes Array of strings of node type names. Array length must match depth specified.
 * @param string $nodeids Array of strings of nodeids. Array length must match depth specified.
 * @param string $uniquepath "true"/"false" (default="true"). Should the paths followed consist of unique connections or can they repeat connections on a path if it follows the depth rules requested.
 * @param string $scope (either 'all' or 'my', deafult 'all')
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @param array &$messages passed in to store any return messages.
 */
function searchNetworkConnectionsByDepth($checkConnections, $matches, $nextNodes, $labelmatch='false', $depth, $currentdepth=0, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath='true', $scope, $status=0, &$message) {
    global $DB,$USER,$CFG,$HUB_SQL;

	$message .= "currentdepth=".$currentdepth;

	if ($currentdepth == $depth) {
		return $matches;
		//return $message;
	}

	$links = $linklabels[$currentdepth];
	$direction = $directions[$currentdepth];
	$linkgroup = $linkgroups[$currentdepth];
	$roles = $nodetypes[$currentdepth];
	$depthnodeid = "";
	if (isset($nodeids[$currentdepth])) {
		$depthnodeid = $nodeids[$currentdepth];
	}

 	$allConnections = getNetworkConnectionNodesByDepth($currentdepth,$depthnodeid, $nextNodes, $labelmatch, $links, $linkgroup, $direction, $roles, $uniquepath, $scope, $status, $messages);

   	$currentdepth++;

	if (!$allConnections instanceof Hub_Error) {
		$tempNodes = array();
		$foundArray = array();

		//$unsetArray = array();

		$count = 0;
		if (is_countable($allConnections)) {
			$count = count($allConnections);
		}
		$innercount = 0;
		if (is_countable($nextNodes)) {
			$innercount = count($nextNodes);
		}
		$found = false;

		$message .= ":".$count;

		//echo "\nsearch results found = ".$count;

		for ($i=0; $i < $count; $i++) {
			$nextarray = $allConnections[$i];

		   //echo "\n\nTripleID ".$nextarray['TripleID'];
		   //echo "\nfrom ".$nextarray['FromID']." to ".$nextarray['ToID'].":";

			$message .= ":".$nextarray['TripleID'];

			if ($uniquepath == 'false' ||
				($uniquepath == 'true' && (!isset($checkConnections[(string)$nextarray['TripleID']]) || $checkConnections[(string)$nextarray['TripleID']] == "")) ) {

				$checkConnections[$nextarray['TripleID']] = $nextarray;

				//echo ":passed check for TripleID ".$nextarray['TripleID'];

				$found = false;

				if ($labelmatch == 'true') {
					for($j=0; $j < $innercount; $j++) {
						$label = $nextNodes[$j];
						$innerfound = false;
						if ($direction == "outgoing") {
							if ($label == $nextarray['FromLabel']) {
								$found = true;
								$innerfound = true;
								if (array_key_exists($label,$matches)) {
									$temparray = $matches[$label];
									if (array_key_exists($nextarray['ToLabel'],$matches)) {
										$temparray2 = $matches[$nextarray['ToLabel']];
										$temparray2[count($temparray2)]= $nextarray;
										foreach ( $temparray as $val ){
											$temparray2[count($temparray2)] = $val;
										}
										$matches[$nextarray['ToLabel']] = $temparray2;
									} else {
										$temparray[count($temparray)]= $nextarray;
										$matches[$nextarray['ToLabel']] = $temparray;
										//$unsetArray[$next];
									}
								} else {
									$temparray = array();
									$temparray[count($temparray)] = $nextarray;
									$matches[$nextarray['ToLabel']] = $temparray;
								}
								if (!in_array($nextarray['ToLabel'], $tempNodes)) {
									$tempNodes[count($tempNodes)] = $nextarray['ToLabel'];
								}
								break;
							}
						} else if ($direction == "incoming") {
							if ($label == $nextarray['ToLabel']) {
								$found = true;
								$innerfound = true;
								if (array_key_exists($label,$matches)) {
									$temparray = $matches[$label];
									if (array_key_exists($nextarray['FromLabel'],$matches)) {
										$temparray2 = $matches[$nextarray['FromLabel']];
										$temparray2[count($temparray2)]= $nextarray;
										foreach ( $temparray as $val ){
											$temparray2[count($temparray2)] = $val;
										}
										$matches[$nextarray['FromLabel']] = $temparray2;
									} else {
										$temparray[count($temparray)]= $nextarray;
										$matches[$nextarray['FromLabel']] = $temparray;
										//$unsetArray[$next];
									}
								} else {
									$temparray = array();
									$temparray[count($temparray)] = $nextarray;
									$matches[$nextarray['FromLabel']] = $temparray;
								}
								if (!in_array($nextarray['FromLabel'], $tempNodes)) {
									$tempNodes[count($tempNodes)] = $nextarray['FromLabel'];
								}
								break;
							}
						} else if ($direction == "both") {
							if ($label == $nextarray['FromLabel'] || $label == $nextarray['ToLabel']) {
								$found = true;
								$innerfound = true;
								if ($label == $nextarray['FromLabel']) {
									if (array_key_exists($label,$matches)) {
										$temparray = $matches[$label];
										if (array_key_exists($nextarray['ToLabel'],$matches)) {
											$temparray2 = $matches[$nextarray['ToLabel']];
											$temparray2[count($temparray2)]= $nextarray;
											foreach ( $temparray as $val ){
												$temparray2[count($temparray2)] = $val;
											}
											$matches[$nextarray['ToLabel']] = $temparray2;
										} else {
											$temparray[count($temparray)]= $nextarray;
											$matches[$nextarray['ToLabel']] = $temparray;
											//$unsetArray[$next];
										}
									} else {
										$temparray = array();
										$temparray[count($temparray)] = $nextarray;
										$matches[$nextarray['ToLabel']] = $temparray;
									}
									if (!in_array($nextarray['ToLabel'], $tempNodes)) {
										$tempNodes[count($tempNodes)] = $nextarray['ToLabel'];
									}
								}
								if ($label == $nextarray['ToLabel']) {
									if (array_key_exists($label,$matches)) {
										$temparray = $matches[$label];
										if (array_key_exists($nextarray['FromLabel'],$matches)) {
											$temparray2 = $matches[$nextarray['FromLabel']];
											foreach ( $temparray as $val ){
												$temparray2[count($temparray2)] = $val;
											}
											$temparray2[count($temparray2)]= $nextarray;
											$matches[$nextarray['FromLabel']] = $temparray2;
										} else {
											$temparray[count($temparray)]= $nextarray;
											$matches[$nextarray['FromLabel']] = $temparray;
											//$unsetArray[$next];
										}
									} else {
										$temparray = array();
										$temparray[0] = $nextarray;
										$matches[$nextarray['FromLabel']] = $temparray;
									}
									if (!in_array($nextarray['FromLabel'], $tempNodes)) {
										$tempNodes[count($tempNodes)] = $nextarray['FromLabel'];
									}
								}
								break;
							}
						}

						if ($innerfound == true) {
							$foundArray[count($foundArray)] = $label;
						}
					}
				}
				else {
					for($j=0; $j < $innercount; $j++) {
						$next = $nextNodes[$j];

						//echo "\n\nprocessing:".$next.":";
						$innerfound = false;

						if ($direction == "outgoing") {
							if ($next == $nextarray['FromID']) {
								$found = true;
								$innerfound = true;

								if (!in_array($next, $foundArray)) {
									$foundArray[count($foundArray)] = $next;
								}

								//echo "\n\noutcoming - from:".$next." to ".$nextarray['ToID'];

								if (array_key_exists($next,$matches)) {
									//echo "\nIN IF";
									$temparray = $matches[$next];
									if (array_key_exists($nextarray['ToID'],$matches)) {
										//echo "\nIN IF IF";
										$temparray2 = $matches[$nextarray['ToID']];
										$temparray2[count($temparray2)] = $nextarray;
										foreach ( $temparray as $val ){
											$temparray2[count($temparray2)] = $val;
										}
										$matches[$nextarray['ToID']] = $temparray2;
									} else {
										//echo "\nIN IF ELSE";
										$temparray[count($temparray)] = $nextarray;
										$matches[$nextarray['ToID']] = $temparray;
										//$unsetArray[$next];
									}
								} else {
									//echo "\nIN ELSE";
									$temparray = array();
									$temparray[0] = $nextarray;
									$matches[$nextarray['ToID']] = $temparray;
								}

								/*echo "\nmatches length".count($matches);
								foreach ( $matches as $key=>$val ){
									echo "\n".substr($key, 12, 9).":";
									foreach ( $val as $key2=>$val2 ){
										echo "\n".$key2.":";
										foreach ( $val2 as $key3=>$val3 ) {
											if ($key3 == 'FromID') {
												echo "from: ".substr($val3, 12, 9);
											} else if ($key3 == 'ToID') {
												echo " to: ".substr($val3, 12, 9);
											}
										}
									}
								}*/

								if (!in_array($nextarray['ToID'], $tempNodes)) {
									$tempNodes[count($tempNodes)] = $nextarray['ToID'];
								}
								break;
							}
						} else if ($direction == "incoming") {
							if ($next == $nextarray['ToID']) {
								$found = true;
								$innerfound = true;

								if (!in_array($next, $foundArray)) {
									$foundArray[count($foundArray)] = $next;
								}

								//echo "\n\nincoming - from:".$next." to ".$nextarray['FromID'];
								if (array_key_exists($next,$matches)) {
									//echo "\nIN IF";
									$temparray = $matches[$next];
									if (array_key_exists($nextarray['FromID'],$matches)) {
										//echo "\nIN IF IF";
										$temparray2 = $matches[$nextarray['FromID']];
										$temparray2[count($temparray2)] = $nextarray;
										foreach ( $temparray as $val ){
											$temparray2[count($temparray2)] = $val;
										}
										$matches[$nextarray['FromID']] = $temparray2;
									} else {
										//echo "\nIN IF ELSE";
										$temparray[count($temparray)] = $nextarray;
										$matches[$nextarray['FromID']] = $temparray;
										//$unsetArray[$next];
									}
								} else {
									//echo "\nIN ELSE";
									$temparray = array();
									$temparray[0] = $nextarray;
									$matches[$nextarray['FromID']] = $temparray;
								}

								//print_r($matches);
								//echo "\n\nin_array=".in_array($nextarray['FromID'], $tempNodes);

								if (!in_array($nextarray['FromID'], $tempNodes)) {
									//echo "\nadding to $tempNodes:".$nextarray['FromID']."\n\n";
									$tempNodes[count($tempNodes)] = $nextarray['FromID'];
								}

								break;
							}
						} else if ($direction == "both") {
							if ($next == $nextarray['FromID'] || $next == $nextarray['ToID']) {
								$found = true;
								$innerfound = true;

								if (!in_array($next, $foundArray)) {
									$foundArray[count($foundArray)] = $next;
								}

								if ($next == $nextarray['FromID']) {
									if (array_key_exists($next,$matches)) {
										$temparray = $matches[$next];
										if (array_key_exists($nextarray['ToID'],$matches)) {
											$temparray2 = $matches[$nextarray['FromID']];
											$temparray2[count($temparray2)] = $nextarray;
											foreach ( $temparray as $val ){
												$temparray2[count($temparray2)] = $val;
											}
											$matches[$nextarray['ToID']] = $temparray2;
										} else {
											$temparray[count($temparray)] = $nextarray;
											$matches[$nextarray['ToID']] = $temparray;
											//$unsetArray[$next];
										}
									} else {
										$temparray = array();
										$temparray[count($temparray)] = $nextarray;

										$matches[$nextarray['ToID']] = $temparray;
									}
									if (!in_array($nextarray['ToID'], $tempNodes)) {
										$tempNodes[count($tempNodes)] = $nextarray['ToID'];
									}
								}
								if ($next == $nextarray['ToID']) {
									if (array_key_exists($next,$matches)) {
										$temparray = $matches[$next];
										if (array_key_exists($nextarray['FromID'],$matches)) {
											$temparray2 = $matches[$nextarray['ToID']];
											$temparray2[count($temparray2)] = $nextarray;
											foreach ( $temparray as $val ){
												$temparray2[count($temparray2)] = $val;
											}
											$matches[$nextarray['FromID']] = $temparray2;
										} else {
											$temparray[count($temparray)]= $nextarray;
											$matches[$nextarray['FromID']] = $temparray;
											//$unsetArray[$next];
										}
									} else {
										$temparray = array();
										$temparray[count($temparray)] = $nextarray;
										$matches[$nextarray['FromID']] = $temparray;
									}
									if (!in_array($nextarray['FromID'], $tempNodes)) {
										$tempNodes[count($tempNodes)] = $nextarray['FromID'];
									}
								}
								break;
							}
						}


						/*if ($innerfound == true) {
							$message .= ":innerfound= true for: ".$next;
						} else {
							$message .= ":innerfound= false for: ".$next;
						}*/

						if ($innerfound == true) {
							//$foundArray[count($foundArray)] = $next;

							/*if (!in_array($foundArray, $next)) {
								$foundArray[count($foundArray)] = $next;
							}*/

							/*echo "\nfoundArray length:".count($foundArray);
							foreach ( $foundArray as $key ){
								echo "\n".$key.":";
							}*/
						}
					}
				}

				/*if ($found == true) {
					$message .= ":found".$nextarray['TripleID'];
					$matches[count($matches)] = $nextarray;
				}*/
			}
		}

		$countk = count($foundArray);

		$message .= ": foundArray count=".$countk.":";
		$message .= ": tempNodes count=".count($tempNodes).":";

		//echo ": \n A matches=".count($matches);

		if ($labelmatch == 'true') {
			for($j=0; $j < $innercount; $j++) {
				$label = $nextNodes[$j];
				$havefound = false;
				for($k=0; $k < $countk; $k++) {
					$labelf = $foundArray[$k];
					if ($labelf == $label) {
						$havefound = true;
					}
				}
				if ($havefound == false) {
					unset($matches[$label]);
				}
			}
		} else {
			//echo ": nextNodes count=".$innercount.":";
			for($j=0; $j < $innercount; $j++) {
				$next = $nextNodes[$j];
				//echo ": next=".$next.":";
				// remove old connection threads
				$havefound = false;

				for($k=0; $k < $countk; $k++) {
					$nextf = $foundArray[$k];
					//echo  ": nextf=".$nextf.":";
					if ($nextf == $next) {
						$havefound = true;
					}
				}
				if (!$havefound) {
					unset($matches[$next]);
					//echo ": UNSETTING:".$next;
				}
			}

			/*$countj = count($matches);
			echo "\n B matches count=".$countj.":";
			foreach ( $matches as $key=>$val ){
				echo "\n".$key.":";
				foreach ( $val as $key2=>$val2 ){
					echo  "\n".$key2.":";
					foreach ( $val2 as $key3=>$val3 ) {
						if ($key3 == 'FromID') {
							echo "from: ".$val3;
						} else if ($key3 == 'ToID') {
							echo " to: ".$val3;
						}
					}
				}
			}*/
		}

		// Now remove all matches arrays whose count < currentdepth-1 as they are not full paths and are no longer needed.
		// Can not remove these until now when all continuing paths have had a chance to copy them into thier new array if needed.
		foreach ( $matches as $key=>$val ){
			$count = 0;
			if (is_countable($val)) {
				$count = count($val);
			}
			if ($count < $currentdepth-1) {
				unset($matches[$key]);
			}
		}

		// The above does this without the need for the array - I think!
		// UNSET BUCKETS CLONED
		/*
		$countj = count($unsetArray);
		for($j=0; $j < $countj; $j++) {
			$next = $unsetArray[$j];
			unset($matches[$next]);
		}*/

		$message .= ":matches before final unset=".count($matches);
		$message .= ":tempNodes=".count($tempNodes);
		$message .= ":matches=".count($matches);

		if (count($tempNodes) > 0) {
			$matches = searchNetworkConnectionsByDepth($checkConnections, $matches, $tempNodes, $labelmatch, $depth, $currentdepth, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath, $scope, $message);
		}
	} else {
		//error_log(print_r($allConnections, true));
	}

    return $matches;
}

/**
 * Walk the network matching connection based on the passed criteria.
 * Starting from the given list of node labels/ids. (which always starts with 1, the focal node);
 *
 * @param array $checkConnections the id of the connections looked at so far - you to check same connections not processde more than once.
 * @param array $matches the id of the connections mathed.
 * @param array $nextNodes the id of the nodes to search outward from on this loop.
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param integer $depth (optional, 1-7, default 1);
 * @param integer $currentdepth depth of current loop.
 * @param string $linklabels Array of strings of link types. Array length must match depth specified. Each array level is mutually exclusive with linkgroups - there can only be one.
 * @param string $linkgroups Array of either Positive, Negative, or Neutral - default: empty string). Array length must match depth specified.Each array level is mutually exclusive with linklabels - there can only be one.
 * @param string $directions Array of 'outgoing', 'incmong', or 'both - default: 'both'. Array length must match depth specified.
 * @param string $nodetypes Array of strings of node type names. Array length must match depth specified.
 * @param string $nodeids Array of strings of nodeids. Array length must match depth specified.
 * @param string $uniquepath "true"/"false" (default="true"). Should the paths followed consist of unique connections or can they repeat connections on a pth if it follows the depth rules requested.
 * @param string $scope (either 'all' or 'my', deafult 'all')
 * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired)
 * @param array &$messages passed in to store any return messages.
 */
function searchNetworkConnectionsByDepthOR($checkConnections, $matches, $nextNodes, $labelmatch='false', $depth, $currentdepth=0, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath='true', $scope, $status=0, &$message) {
    global $DB,$USER,$CFG,$HUB_SQL;

	$message .= "currentdepth=".$currentdepth;

	if ($currentdepth == $depth) {
		return $matches;
	}

	$links = $linklabels[$currentdepth];
	$direction = $directions[$currentdepth];
	$linkgroup = $linkgroups[$currentdepth];
	$roles = $nodetypes[$currentdepth];
	$depthnodeid = "";
	if (isset($nodeids[$currentdepth])) {
		$depthnodeid = $nodeids[$currentdepth];
	}

 	$allConnections = getNetworkConnectionNodesByDepth($currentdepth,$depthnodeid, $nextNodes, $labelmatch, $links, $linkgroup, $direction, $roles, $uniquepath, $scope, $status, $messages);

   	$currentdepth++;

	if (!$allConnections instanceof Hub_Error) {

		$tempNodes = array();
		$count = 0;
		if (is_countable($allConnections)) {
			$count = count($allConnections);
		}
		$innercount = 0;
		if (is_countable($nextNodes)) {
			$innercount = count($nextNodes);
		}
		$found = false;

		$message .= ":".$count;

		$foundArray = array();

		for ($i=0; $i < $count; $i++) {
			$nextarray = $allConnections[$i];

			$message .= ":".$nextarray['TripleID'];
			if ($uniquepath == 'false' ||
				($uniquepath == 'true' && (!isset($checkConnections[(string)$nextarray['TripleID']]) || $checkConnections[(string)$nextarray['TripleID']] == "")) ) {

				$checkConnections[(string)$nextarray['TripleID']] = $nextarray;

				$found = false;

				if ($labelmatch == 'true') {
					for($j=0; $j < $innercount; $j++) {
						$label = $nextNodes[$j];
						if ($direction == "outgoing") {
							if ($label == $nextarray['FromLabel']) {
								$found = true;
								$tempNodes[count($tempNodes)] = $nextarray['ToLabel'];
								break;
							}
						} else if ($direction == "incoming") {
							if ($label == $nextarray['ToLabel']) {
								$found = true;
								$tempNodes[count($tempNodes)] = $nextarray['FromLabel'];
								break;
							}
						} else if ($direction == "both") {
							if ($label == $nextarray['FromLabel'] || $label == $nextarray['ToLabel']) {
								$found = true;
								if ($label == $nextarray['FromLabel']) {
									$tempNodes[count($tempNodes)] = $nextarray['ToLabel'];
								}
								if ($label == $nextarray['ToLabel']) {
									$tempNodes[count($tempNodes)] = $nextarray['FromLabel'];
								}
								break;
							}
						}
					}
				}
				else {
					for($j=0; $j < $innercount; $j++) {
						$next = $nextNodes[$j];
						if ($direction == "outgoing") {
							if ($next == $nextarray['FromID']) {
								$found = true;
								$tempNodes[count($tempNodes)] = $nextarray['ToID'];
								break;
							}
						} else if ($direction == "incoming") {
							if ($next == $nextarray['ToID']) {
								$found = true;
								$tempNodes[count($tempNodes)] = $nextarray['FromID'];
								break;
							}
						} else if ($direction == "both") {
							if ($next == $nextarray['FromID'] || $next == $nextarray['ToID']) {
								$found = true;
								if ($next == $nextarray['FromID']) {
									$tempNodes[count($tempNodes)] = $nextarray['ToID'];
								}
								if ($next == $nextarray['ToID']) {
									$tempNodes[count($tempNodes)] = $nextarray['FromID'];
								}
								break;
							}
						}
					}
				}

				if ($found == true) {
					$message .= ":found".$nextarray['TripleID'];
					$matches[count($matches)] = $nextarray;
				}
			}
		}

		$message .= ":".count($tempNodes);

		if (count($tempNodes) > 0) {
			$matches = searchNetworkConnectionsByDepthOR($checkConnections, $matches, $tempNodes, $labelmatch, $depth, $currentdepth, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath, $scope, $status, $message);
		}
	} else {
		//error_log(print_r($allConnections, true));
	}

    return $matches;
}

/**
 * WE DON'T WANT LABEL MATCHING IN THE EVIDENCE HUB, SO JUST RETURN THE ORGINAL NODEID
 * (old- Get the nodeid for nodes with the same node label of the given nodeid)
 *
 * @param string $nodeid
 * @return comma separated string of node ids or an empty string.
 */
function getAggregatedNodeIDs($nodeid){
    global $DB, $USER,$CFG,$HUB_SQL;

	return "'".$nodeid."'";

    /*
    $sql = "SELECT t.NodeID from Node t WHERE t.Name IN (SELECT t2.Name from Node t2 WHERE t2.NodeID='".$nodeid."') ";
    $sql .=  " AND (
                (t.Private = 'N')
                 OR
                (t.UserID = '".$USER->userid."') ". // the current user
                " OR
                (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
                             INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
                             WHERE ug.UserID = '".$USER->userid."')". // the current user
                "))";

    $list = "";
    $nodes = array();
    $res = mysql_query( $sql, $DB->conn);
    if ($res) {
        while ($array = mysql_fetch_array($res, MYSQL_ASSOC)) {
            $nodeid = $array['NodeID'];
            if (!isset($nodes[$nodeid])) {
                $list .= ",'".$nodeid."'";
                $nodes[$nodeid] = $nodeid;
            }
        }
        // remove first comma.
        $list = substr($list, 1);
    }

    return $list;
    */
}

/**
 * Get the SQL select statement to get all the LinkTypeIDs for the given link type group label
 *
 * @param string $grouplabel
 * @return comma separated string of link type ids or an empty string.
 */
function getSQLForLinkTypeIDsForGroup(&$params, $grouplabel){
	global $HUB_SQL;

   	$params[count($params)] = $grouplabel;
    $sql = $HUB_SQL->UTILLIB_LINKTYPE_IDS_FROM_GROUP;
    return $sql;
}

/**
 * Get all the LinkTypeIDs for the given link type label list (comma separated)
 *
 * @param string $linklabels
 * @return comma separated string of link type ids or an empty string.
 */
function getSQLForLinkTypeIDsForLabels(&$params, $linklabels) {
    global $DB, $USER,$CFG,$HUB_SQL;

    $searchLabel = "";
    $pieces = explode(",", $linklabels);
    $loopCount = 0;
    foreach ($pieces as $value) {
    	$params[count($params)] = $value;
        if ($loopCount == 0) {
            $searchLabel .= "?";
        } else {
            $searchLabel .= ",?";
        }
        $loopCount++;
    }

    $sql = $HUB_SQL->UTILLIB_LINKTYPE_IDS_FROM_NAMES_PART1;
    $sql .= $searchLabel;
    $sql .= $HUB_SQL->UTILLIB_LINKTYPE_IDS_FROM_NAMES_PART2;

    return $sql;
}

/**
 * Get the sql segment to get all the NodeTypeIDs for the given node type names list (comma separated)
 *
 * @param string $nodetypenames
 * @return a string with the inner sql select statement to get the NodeTypeIDs for the given node type names.
 */
function getSQLForNodeTypeIDsForLabels(&$params, $nodetypenames) {
    global $DB, $USER,$CFG,$HUB_SQL;

    $searchNames = "";
    $pieces = explode(",", $nodetypenames);
    $loopCount = 0;
    foreach ($pieces as $value) {
    	$params[count($params)] = $value;
        if ($loopCount == 0) {
        	$searchNames .= "?";
        } else {
        	$searchNames .= ",?";
        }
        $loopCount++;
    }

    $sql = $HUB_SQL->UTILLIB_NODETYPE_IDS_FROM_NAMES_PART1;
    $sql .= $searchNames;
    $sql .= $HUB_SQL->UTILLIB_NODETYPE_IDS_FROM_NAMES_PART2;

    return $sql;
}


/**
* Get the tag names and their use counts for tag cloud.
* @param limit the number of results to return
* @param nameorder true if you wanted sorted by name ASC, false means it is sorted count DESC)
*
* @return array of arrays of 'Name' and 'UseCount' fields.
*/
function getTagsForCloud($limit, $nameorder=true){
	global $DB,$HUB_SQL;

	$params = array();

	$sql = $HUB_SQL->UTILLIB_TAGS_FOR_CLOUD;

    if ($limit > 0) {
		// ADD LIMITING
		$sql = $DB->addLimitingResults($sql, 0, $limit);
	}

    $sql = $HUB_SQL->OPENING_BRACKET.$sql.$HUB_SQL->CLOSING_BRACKET;

    if ($nameorder) {
    	$sql .= $HUB_SQL->ORDER_BY_NAME;
    } else {
   	 	$sql .= $HUB_SQL->UTILLIB_TAGS_FOR_CLOUD_ORDER_BY;
    }

	$resArray = $DB->select($sql, $params);
	$array = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$next = $resArray[$i];
    		array_push($array, $next);
    	}
    }
	return $array;
}

/**
* Get the tag names and their use counts for the user tag cloud.
* @param limit the number of results to return (ordered by use count DESC)
*
* @return array of arrays of 'Name' and 'UseCount' fields.
*/
function getUserTagsForCloud($limit){
	global $DB, $USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $currentuser;
	$params[1] = $currentuser;
	$params[2] = $currentuser;
	$params[3] = $currentuser;

	$sql = $HUB_SQL->UTILLIB_USER_TAGS_FOR_CLOUD;

    if ($limit > 0) {
		// ADD LIMITING
		$sql = $DB->addLimitingResults($sql, 0, $limit);
	}

    $sql = $HUB_SQL->OPENING_BRACKET.$sql.$HUB_SQL->CLOSING_BRACKET;
    $sql .= $HUB_SQL->ORDER_BY_NAME;

	$resArray = $DB->select($sql, $params);
	$array = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$next = $resArray[$i];
    		array_push($array, $next);
    	}
    }
	return $array;
}

/**
* Get the tag names and their use counts for the given groups tag cloud.
* @param GroupID the id of the group to get the tag cloud for.
* @param limit the number of results to return (ordered by use count DESC)
*
* @return array of arrays of 'Name' and 'UseCount' fields.
*/
function getGroupTagsForCloud($GroupID, $limit, $orderby="Name", $dir="ASC"){
	global $DB, $USER,$HUB_SQL;

	$params = array();
	$params[0] = $GroupID;
	$params[1] = $GroupID;
	$params[2] = $GroupID;
	$params[3] = $GroupID;
	$params[4] = $GroupID;
	$params[5] = $GroupID;
	$params[6] = $GroupID;

	$sql = $HUB_SQL->UTILLIB_GROUP_TAGS_FOR_CLOUD;

    if ($limit > 0) {
		// ADD LIMITING
		$sql = $DB->addLimitingResults($sql, 0, $limit);
	}

    $sql = $HUB_SQL->OPENING_BRACKET.$sql.$HUB_SQL->CLOSING_BRACKET;
    $sql .= $HUB_SQL->ORDER_BY.$orderby." ".$dir;

	$resArray = $DB->select($sql, $params);
	$array = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$next = $resArray[$i];
    		array_push($array, $next);
    	}
    }

	return $array;
}


/**
 * Return the Activity objects that represent the activity on the given nodeid
 * @param string $nodeid the id of the node to get Activity for
 * @param integer $from (optional - default: 0)
 * @return ActivitySet or Error
 */
function getAllNodeActivity($nodeid, $from = 0) {
    global $DB, $CFG, $USER,$HUB_SQL;

	$params = array();

    $as = new ActivitySet();

   	//"month"  => 2419200,  // seconds in a month  (4 weeks)
   	// "week"   => 604800,  // seconds in a week   (7 days)
   	//"day"    => 86400,    // seconds in a day    (24 hours)
	/*if ($NoDays > 0) {
		$timeback = $NoDays * 86400; //86400 = 24 hours or 1 Day
		$now = time();
		$startime = $now - $timeback;
	}*/
	/*
	$sql = $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART1;

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART2_BRACKET;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART2;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $nodeid;
	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART3_UNION;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART3;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART4_UNION;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART4;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART5_UNION;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART5;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE_FOLLOWING;
	}

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART6_UNION;
	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART6;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}

	$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART7;

	$as->load($sql, $params);
	*/

	// make as separate calls to reduce database load

	// load AuditNode records
	$params = array();
	$params[count($params)] = $nodeid;
	$sql = $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART2;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}
	//$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_ORDERBY_MODDATE;
	$as->load($sql, $params);

	// load AuditTriple records
	$params = array();
	$params[count($params)] = $nodeid;
	$params[count($params)] = $nodeid;
	$sql = $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART3;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}
	//$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_ORDERBY_MODDATE;
	$as->load($sql, $params);

	// load AuditVoting records
	$params = array();
	$params[count($params)] = $nodeid;
	$sql = $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART4;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}
	//$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_ORDERBY_MODDATE;
	$as->load($sql, $params);

	// load Following records
	$params = array();
	$params[count($params)] = $nodeid;
	$sql = $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART5;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE_FOLLOWING;
	}
	//$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_ORDERBY_MODDATE;
	$as->load($sql, $params);

	// load AuditNodeView records
	$params = array();
	$params[count($params)] = $nodeid;
	$sql = $HUB_SQL->UTILLIB_USER_ACTIVITY_PART6;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MODE_DATE;
	}
	//$sql .= $HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_ORDERBY_MODDATE;
	$as->load($sql, $params);

    return $as;
}

/**
 * Return the Activity objects that represent the activity on the given nodeid
 * @param string $nodeid the id of the node to get Activity for
 * @param integer $from a given modification date, (optional - default: 0)
 * @param integer $start (optional - default: 0) // not used
 * @param integer $max (optional - default: 20), -1 means all // not used
 * @return ActivitySet or Error
 */
function getNodeActivity($nodeid, $from = 0, $start = 0, $max = 20) {
    global $DB, $CFG, $USER,$HUB_SQL;

	$params = array();

    $as = new ActivitySet();

   	//"month"  => 2419200,  // seconds in a month  (4 weeks)
   	// "week"   => 604800,  // seconds in a week   (7 days)
   	//"day"    => 86400,    // seconds in a day    (24 hours)
	/*if ($NoDays > 0) {
		$timeback = $NoDays * 86400; //86400 = 24 hours or 1 Day
		$now = time();
		$startime = $now - $timeback;
	}*/

	$sql = $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART1;

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART2_BRACKET;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART2;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $nodeid;
	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART3_UNION;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART3;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART4_UNION;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART4;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART5_UNION;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART5;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_MODE_DATE_FOLLOWING;
	}

	$params[count($params)] = $nodeid;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART6_UNION;
	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART6;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_MODE_DATE;
	}

	$sql .= $HUB_SQL->UTILLIB_NODE_ACTIVITY_PART7;

    if ($max > -1) {
		// ADD LIMITING
		$sql = $DB->addLimitingResults($sql, $start, $max);
	}

	$as->load($sql, $params);

    return $as;
}

/**
 * Return the Activity objects that represent the activity on the given userid
 * @param string $userid the id of the user to get Activity for
 * @param number $from the time from which to get their activity, expressed in milliseconds.
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20), -1 means all
 * @return ActivitySet or Error
 */
function getUserActivity($userid, $from, $start = 0, $max = 20) {
    global $DB, $CFG, $USER,$HUB_SQL;

	$params = array();

    $as = new ActivitySet();

   	//"month"  => 2419200,  // seconds in a month  (4 weeks)
   	// "week"   => 604800,  // seconds in a week   (7 days)
   	//"day"    => 86400,    // seconds in a day    (24 hours)
	/*if ($NoDays > 0) {
		$timeback = $NoDays * 86400; //86400 = 24 hours or 1 Day
		$now = time();
		$startime = $now - $timeback;
	}*/

	// Full call with UINIONs
	$sql = $HUB_SQL->UTILLIB_USER_ACTIVITY_PART1;
	$params[count($params)] = $userid;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART2_BRACKET;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART2;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $userid;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART3_UNION;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART3;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $userid;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART4_UNION;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART4;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}

	$params[count($params)] = $userid;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART5_UNION;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART5;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE_FOLLOWING;
	}

	$params[count($params)] = $userid;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART6_UNION;
	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART6;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}

	$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_PART7;

	// how do we do this when it is seprate calls?
    if ($max > -1) {
		// ADD LIMITING
		$sql = $DB->addLimitingResults($sql, $start, $max);
	}

	$as->load($sql, $params);


	// make seprate calls to reduce database load and then join up
	/*
	$params = array();
	$params[count($params)] = $userid;
	if ($from > 0) {
		$params[count($params)] = $from;
	}

	// load AuditNode records
	$sql = $HUB_SQL->UTILLIB_USER_ACTIVITY_PART2;
	if ($from > 0) {
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}
	$as->load($sql, $params);

	// load AuditTriple records
	$sql = $HUB_SQL->UTILLIB_USER_ACTIVITY_PART3;
	if ($from > 0) {
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}
	$as->load($sql, $params);

	// load AuditVoting records
	$sql = $HUB_SQL->UTILLIB_USER_ACTIVITY_PART4;
	if ($from > 0) {
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}
	$as->load($sql, $params);

	// load Following records
	$sql = $HUB_SQL->UTILLIB_USER_ACTIVITY_PART5;
	if ($from > 0) {
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE_FOLLOWING;
	}
	$as->load($sql, $params);

	// load AuditNodeView records
	$sql = $HUB_SQL->UTILLIB_USER_ACTIVITY_PART6;
	if ($from > 0) {
		$sql .= $HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE;
	}
	$as->load($sql, $params);
	*/

    return $as;
}

/**
 * Get the country names and their counts for the node type with the name passed as type.
 * @param limit the number of results to return (ordered by use count DESC)
 *
 * @return array of arrays of 'Country' and 'UseCount' fields.
 */
function getCountriesForCloudByType($filternodetypes, $limit=20) {
	global $CFG, $DB, $USER,$HUB_SQL;

	$params = array();

	$sql = $HUB_SQL->UTILLIB_COUNTRIES_BY_TYPE_PART1;
	$innersql = getSQLForNodeTypeIDsForLabels($params,$filternodetypes);
	$sql .= $innersql;
	$sql .= $HUB_SQL->UTILLIB_COUNTRIES_BY_TYPE_PART2;
    if ($limit > 0) {
		// ADD LIMITING
		$sql = $DB->addLimitingResults($sql, 0, $limit);
	}

	$finalsql = $HUB_SQL->OPENING_BRACKET.$sql.$HUB_SQL->CLOSING_BRACKET;
	$finalsql .= $HUB_SQL->UTILLIB_COUNTRIES_BY_TYPE_PART3;

	$resArray = $DB->select($finalsql, $params);
	$array = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$next = $resArray[$i];
    		array_push($array, $next);
    	}
    }

	return $array;
}

/**
 * Get the country names and their counts for the users.
 * @param limit the number of results to return (ordered by use count DESC)
 *
 * @return array of arrays of 'Country' and 'UseCount' fields.
 */
function getCountriesForCloudByUsers($limit=20) {
	global $CFG, $DB, $USER,$HUB_SQL;

	$params = array();

	$sql = $HUB_SQL->UTILLIB_COUNTRIES_BY_USER_PART1;
    if ($limit > 0) {
		// ADD LIMITING
		$sql = $DB->addLimitingResults($sql, 0, $limit);
	}

	$finalsql = $HUB_SQL->OPENING_BRACKET.$sql.$HUB_SQL->CLOSING_BRACKET;
	$finalsql .= $HUB_SQL->UTILLIB_COUNTRIES_BY_USER_PART2;

	$resArray = $DB->select($finalsql, $params);
	$array = array();

	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$next = $resArray[$i];
    		array_push($array, $next);
    	}
    }

	return $array;
}

/** MOVED FROM API **/

/**
 * Get the nodes for given DOI
 * This checks connections from Nodes to URL objects with the AdditionalIdentifier equal to the the given DOI
 *
 * @param string $doi (the doi number you want to get documents for)
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByDOI($doi,$start = 0,$max = 20 ,$orderby = 'date', $sort ='ASC', $filternodetypes="", $style='long'){
    global $USER,$CFG,$HUB_SQL;

	$params = array();

    $sql = $HUB_SQL->UTILLIB_NODES_BY_DOI_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $searchNodeTypes = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$searchNodeTypes .= "?";
        	} else {
        		$searchNodeTypes .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $searchNodeTypes;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER BY DOI
   	$params[count($params)] = $doi;
    $sql .= $HUB_SQL->UTILLIB_NODES_BY_DOI_FILTER;


    // PERMISSIONS
	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_URLS_PERMISSIONS_ALL;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given AdditionalIdentifier
 * This get nodes whose AdditionalIdeantifier = the given text.
 *
 * @param string $additionalidentifier (the additionalidentifier you want to get nodes for)
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByAdditionalIdentifier($additionalidentifier,$start = 0,$max = 20 ,$orderby = 'date', $sort ='ASC', $filternodetypes="", $style='long'){
    global $USER,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $status;
    $sql = $HUB_SQL->APILIB_NODES_SELECT_START;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $searchNodeTypes = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$searchNodeTypes .= "?";
        	} else {
        		$searchNodeTypes .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $searchNodeTypes;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER BY ADDITIONAL IDENTIFIER
   	$params[count($params)] = $additionalidentifier;
    $sql .= $HUB_SQL->UTILLIB_NODES_BY_ADDITIONAL_IDENTIFIER;

    // PERMISSIONS
	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes with the given status.
 *
 * @param integer $status (0 = non-spam or 1 = spam)
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByStatus($status=0, $start = 0, $max = 20 ,$orderby = 'date',$sort ='DESC', $style='long') {
    global $CFG,$USER,$HUB_SQL;

	$params = array();
	$params[0] = $status;
	$sql = $HUB_SQL->UTILLIB_NODES_BY_STATUS;
    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the users with the given status. For admin area.
 *
 * @param integer $status
 * <br>$CFG->USER_STATUS_ACTIVE = live and active account
 * <br>$CFG->USER_STATUS_REPORTED = user has been reported as spammer (not used at present)
 * <br>$CFG->USER_STATUS_UNVALIDATED = new user account that has not had the email address verified yet.
 * <br>$CFG->USER_STATUS_UNAUTHORIZED = new user account that has not been authorized yet.
 * <br>$CFG->USER_STATUS_SUSPENDED = user account that has been suspended.
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getUsersByStatus($status=0, $start = 0, $max = 20 ,$orderby = 'date',$sort ='DESC', $style='long') {
    global $CFG,$USER,$HUB_SQL;

	if ($USER->getIsAdmin() == "Y") {
		$params = array();
		$params[0] = $status;
		$sql = $HUB_SQL->UTILLIB_USERS_BY_STATUS;
	    $us = new UserSet();
	    return $us->load($sql,$params,$start,$max,$orderby,$sort,$style);
	 } else {
        $ERROR = new Hub_Error();
        return $ERROR->createAccessDeniedError();
	 }
}


/**
 * Build the SQL query string for a search
 * (NODE = t.Name and t.Description, URL = r.Clip., TAG = u.Name)
 *
 * @param &$params the array to place the parameters for the sql into.
 * @param $q the search query to process
 * @param $includeTag whether to include Tag texts in the search.
 * @param $includeClip whether to include Clip texts in the search.
 */
function getSearchQueryString(&$params, $q="", $includeTag=false, $includeClip=false) {
	global $DB,$HUB_SQL;

	$sql="";
	if ($q == "") return $sql;

	// Determine if PHRASE search should be run or and WORD search
	$q = trim($q);

	//decode double speech marks in search query;
	$q = htmlspecialchars_decode($q, ENT_QUOTES);
	$len = strlen($q);
	$startChar = mb_substr($q, 0, 1);
	$lastChar = mb_substr($q, $len-1, $len);

	//$searchObj = new stdClass();
	//$searchObj->value = $DB->cleanString($q);

	// PROCESS AS PHRASE SEARCH
	if ($startChar == "\"" && $lastChar == "\"") {
		// remove speech marks before search
		$q = mb_substr($q, 1, $len-2);
		$sql .= $HUB_SQL->OPENING_BRACKET;

		//$params[count($params)] = $searchObj;
		$sql .= $HUB_SQL->UTILLIB_SEARCH_NAME_LIKE.$DB->cleanString($q).$HUB_SQL->SEARCH_LIKE_END;

		//$params[count($params)] = $searchObj;
		$sql .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_SEARCH_DESC_LIKE.$DB->cleanString($q).$HUB_SQL->SEARCH_LIKE_END;

		if ($includeTag) {
			//$params[count($params)] = $searchObj;
			$sql .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_SEARCH_TAG_LIKE.$DB->cleanString($q).$HUB_SQL->SEARCH_LIKE_END;
		}
		if ($includeClip) {
			//$params[count($params)] = $searchObj;
			$sql .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_SEARCH_CLIP_LIKE.$DB->cleanString($q).$HUB_SQL->SEARCH_LIKE_END;
		}
		$sql .= $HUB_SQL->CLOSING_BRACKET;
	} else {
		// PROCESS AS WORD SEARCH OR or AND

		//need to convert the + from &#43 (as they will be from text cleaning)
		$q = str_replace('&#43;', '+', $q);

		//Is it an AND or an OR Search? Look for the + symbol.
		$pos = strpos($q, "+");

		if ($pos === false) {
			// If no + then it is an OR search, so break up search query on spaces
			$pieces = explode(" ", $q);
			$loopCount = 0;
			$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
				$value = $DB->cleanString($value);

				if ($value != "") {

					//$searchObj = new stdClass();
					//$searchObj->value = $value;

					if ($loopCount > 0) {
						$search .= $HUB_SQL->OR;
					}
					$search .= $HUB_SQL->OPENING_BRACKET;

					//$params[count($params)] = $searchObj;
					$search .= $HUB_SQL->UTILLIB_SEARCH_NAME_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;

					//$params[count($params)] = $searchObj;
					$search .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_SEARCH_DESC_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;

					if ($includeTag) {
						//$params[count($params)] = $searchObj;
						$search .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_SEARCH_TAG_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;
					}
					if ($includeClip) {
						//$params[count($params)] = $searchObj;
						$search .= $HUB_SQL->OR.$HUB_SQL->UTILLIB_SEARCH_CLIP_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;
					}

					$search .= $HUB_SQL->CLOSING_BRACKET;
					$loopCount++;
				}
			}
			$sql .= "( ".$search." )";
		} else {
			// With + it is an AND search so break up search query on +
			$pieces = explode("+", $q);
			$loopCount = 0;

			$searchNodeName = "";
			$searchNodeDesc = "";
			$searchTag = "";
			$searchClip = "";
			foreach ($pieces as $value) {
				$value = trim($value);
				$value = $DB->cleanString($value);

				if ($value != "") {

					//$searchObj = new stdClass();
					//$searchObj->value = $value;

					if ($loopCount > 0) {
						$searchTag .= $HUB_SQL->AND;
						$searchNodeName .= $HUB_SQL->AND;
						$searchNodeDesc .= $HUB_SQL->AND;
						$searchClip .= $HUB_SQL->AND;
					}

					//$params[count($params)] = $searchObj;
					$searchNodeName .= " ".$HUB_SQL->UTILLIB_SEARCH_NAME_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;

					//$params[count($params)] = $searchObj;
					$searchNodeDesc .= " ".$HUB_SQL->UTILLIB_SEARCH_DESC_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;
					if ($includeTag) {
						//$params[count($params)] = $searchObj;
						$searchTag .= " ".$HUB_SQL->UTILLIB_SEARCH_TAG_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;
					}
					if ($includeClip) {
						//$params[count($params)] = $searchObj;
						$searchClip .=	" ".$HUB_SQL->UTILLIB_SEARCH_CLIP_LIKE.$value.$HUB_SQL->SEARCH_LIKE_END;
					}

					$loopCount++;
				}
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $HUB_SQL->OPENING_BRACKET.$searchNodeName.$HUB_SQL->CLOSING_BRACKET.$HUB_SQL->OR;
			$sql .= $HUB_SQL->OPENING_BRACKET.$searchNodeDesc.$HUB_SQL->CLOSING_BRACKET.$HUB_SQL->OR;
			if ($includeTag && $includeClip) {
				$sql .= $HUB_SQL->OPENING_BRACKET.$searchTag.$HUB_SQL->CLOSING_BRACKET.$HUB_SQL->OR;
				$sql .= $HUB_SQL->OPENING_BRACKET.$searchClip.$HUB_SQL->CLOSING_BRACKET;
			} else if ($includeTag) {
				$sql .= $HUB_SQL->OPENING_BRACKET.$searchTag.$HUB_SQL->CLOSING_BRACKET;
			} else if ($includeClip) {
				$sql .= $HUB_SQL->OPENING_BRACKET.$searchClip.$HUB_SQL->CLOSING_BRACKET;
			}
			$sql .= $HUB_SQL->CLOSING_BRACKET;
		}
	}

	//error_log($sql);

	return $sql;
}

/**
 * For the given userid calculate their node creation counts by nodetype.
 * @return an associative array with the key as the NodeType name and the value as the count.
 */
function getUserNodeTypeCreationCounts($userid){
	global $CFG, $DB,$HUB_SQL;

	$nodeArray = array();

	$params = array();
	$params[0] = $userid;

	$sql = $HUB_SQL->UTILLIB_USER_NODETYPE_CREATION_COUNTS;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$countloop = 0;
		if (is_countable($resArray)) {
			$countloop = count($resArray);
		}
		for ($i=0; $i<$countloop; $i++) {
			$array = $resArray[$i];
			$name = $array['Name'];
			$count = $array['num'];
			$nodeArray[$name] = $count;
		}
		reset($nodeArray);
		array_multisort($nodeArray, SORT_DESC);
	}

	return $nodeArray;
}

/**
 * Get a list of the users the given user is following.
 * @param $userid, the id of the user to get the following users for.
 * @return and array of associative arrays holding keys 'UserID' and 'Name'.
 */
function getUsersBeingFollowedByMe($userid) {
	global $CFG, $DB,$HUB_SQL;

	$params = array();
	$params[0] = $userid;

	$sql = $HUB_SQL->UTILLIB_USERS_FOLLOWED_BY_USER;

	$resArray = $DB->select($sql, $params);
	$userArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($userArray, $array);
		}
	}

	return $userArray;
}

/**
 * Get a list of the items the given user is following.
 * @param $userid, the id of the user to get the following items for.
 * @return and array of associative arrays holding keys 'NodeType' and 'Name' and 'NodeID'.
 */
function getItemsBeingFollowedByMe($userid) {
	global $CFG, $DB,$HUB_SQL;

	$params = array();
	$params[0] = $userid;

	$sql = $HUB_SQL->UTILLIB_ITEMS_FOLLOWED_BY_USER;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($nodeArray, $array);
		}
	}
	return $nodeArray;
}

/**
 * Return a list of users who have requested Follow Emails for the given time interval.
 * @param $runinterval, either 'daily', 'weekly' or 'monthly'. (defaults to 'monthly')
 * @return a UserSet of users found.
 */
function getFollowEmailUsers($runinterval='monthly') {
	global $CFG, $DB,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->defaultUserID;
	$params[1] = $runinterval;
	$sql = $HUB_SQL->UTILLIB_FOLLOW_EMAIL_USERS;

	$us = new UserSet();
	$us->load($sql,$params,0,-1,'date','DESC','long');

	return $us;
}

/**
 * Return a list of users who have requested the email digest of Recent Activity.
 * @return a UserSet of users found.
 */
function getRecentActivityEmailUsers() {
	global $CFG, $DB,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->defaultUserID;
	$sql = $HUB_SQL->UTILLIB_RECENT_ACTIVITY_EMAIL_USERS;

	$us = new UserSet();
	$us->load($sql,$params,0,-1,'date','DESC','long');

	return $us;
}

/**
 * Delete the given user from the system, if your an admin only.
 * @param $userid the id of the user to delete.
 * @return true if it all went well, else false.
 */
 function adminDeleteUser($userid) {
	global $CFG, $DB, $USER,$HUB_SQL;

	if (isset($USER) && $USER != "" && $USER->getIsAdmin() == "Y") {
		$params = array();
		$params[0] = $userid;
		$sql = $HUB_SQL->UTILLIB_DELETE_USER;
		$res = $DB->delete($sql, $params);
		if ($res) {
			//remove user images folder if exists
			$dir = $CFG->dirAddress.$CFG->domainfolder."uploads/".$userid."/";
			deleteDirectory($dir);
			return true;
		}
	}
	return false;
}

/**
 * Delete the news node from the system, if your an admin only.
 * @param $nodeid the id of the theme node to delete.
 * @return true if it all went well, else false.
 */
function adminDeleteNews($nodeid) {
	global $CFG, $DB, $USER,$HUB_SQL;

	if (isset($USER) && $USER != "" && $USER->getIsAdmin() == "Y") {
		$n = new CNode($nodeid);
		if (!$n instanceof Hub_Error) {
			$n = $n->load();
			if ($n->role->name == "News") {
				$xml = format_object('xml',$n);

				$params = array();
				$params[0] = $nodeid;
				$sql = $HUB_SQL->DATAMODEL_NODE_DELETE;
				$res = $DB->delete($sql, $params);
				if ($res) {
					auditIdea($USER->userid, $n->nodeid, $n->name, $n->description, $CFG->actionDelete, $xml);
				}
				return true;
			}
		}
	}

	return false;
}

/**
 * Create a new link type with the given $id and add it to the given $linkgroup.
 * @param $userid the id of the user to add the new link type for.
 * @param $id the id of the new link type.
 * @param $linkgroup the linkgroup to add the the new link type to.
 * @param $linkname the name of the the new link type.
 * @return true if it all went well, else false.
 */
function adminCreateLinkType($userid, $id, $linkgroup, $linkname) {
	global $CFG, $DB, $USER,$HUB_SQL;

	if (isset($USER) && $USER != "" && $USER->getIsAdmin() == "Y") {
		$params = array();
		$params[0] = $id;
		$params[1] = $userid;
		$params[2] = $linkname;
		$params[3] = time();

		$sql = $HUB_SQL->UTILLIB_INSERT_LINKTYPE;
		$res = $DB->insert($sql, $params);
		if (!$res){
			 echo database_error();
		} else {
			$params = array();
			$params[0] = $linkgroup;
			$params[1] = $id;
			$params[2] = $userid;
			$params[3] = time();

			//add the default groupings for these
			$sql2 = $HUB_SQL->UTILLIB_INSERT_LINKTYPE_GROUPING;
			$res2 = $DB->insert($sql2, $params);
			if (!$res2){
				echo database_error();
			} else {
				echo $id." added for ".$user->userid;
			}
			return true;
		}
	}
	return false;
}

/**
 * Create a new node type with the given $id and add it to the node type group with the given $nodegroupid.
 * @param $userid the id of the user to add the new node type for.
 * @param $id the id of the new node type.
 * @param $nodegroupid the node type group id to add the the new node type to.
 * @param $nodename the name of the the new node type.
 * @param $image the image path of the node type icon.
 * @return true if it all went well, else false.
 */
function adminCreateNodeType($userid, $id, $nodegroupid, $nodename, $image) {
	global $CFG, $DB, $USER, $HUB_SQL;

	if (isset($USER) && $USER != "" && $USER->getIsAdmin() == "Y") {

		$params = array();
		$params[0] = $id;
		$params[1] = $userid;
		$params[2] = $nodename;
		$params[3] = time();
		$params[4] = $image;

		$sql = $HUB_SQL->UTILLIB_INSERT_NODETYPE;

		$res = $DB->insert($sql, $params);
		if (!$res){
			 echo database_error();
		} else {
			$params = array();
			$params[0] = $nodegroupid;
			$params[1] = $id;
			$params[2] = $userid;
			$params[3] = time();

			//add the default groupings for these
			$sql2 = $HUB_SQL->UTILLIB_INSERT_NODETYPE_GROUPING;
			$res2 = $DB->insert($sql2, $params);
			if (!$res2){
				echo database_error();
			} else {
				echo $id." added for ".$userid;
			}
		}
	}
	return false;
}

/**
 * Create a new node entry to represent the given user.
 * @param $userid the id of the user to add the new node type for.
 * @param $id the id of the new node type.
 * @param $nodegroupid the node type group id to add the the new node type to.
 * @param $nodename the name of the the new node type.
 * @param $image the image path of the node type icon.
 * @return true if it all went well, else false.
 */
function adminCreateUserNode($userid, $id, $roleid) {
	global $CFG,$DB,$USER,$HUB_SQL;

	if (isset($USER) && $USER != "" && $USER->getIsAdmin() == "Y") {
		$params = array();
		$params[0] = $id;
		$params[1] = $userid;
		$params[2] = time();
		$params[3] = time();
		$params[4] = 'Person';
		$params[5] = 'N';
		$params[6] = $roleid;
		$params[7] = 0;
		$params[8] = 'cohere';
		$params[9] = $userid;

		$sql = $HUB_SQL->UTILLIB_USER_NODE;

		$res = $DB->insert($sql, $params);
		if (!$res) {
			echo database_error();
		} else {
			echo ": added ".$userid;
			return true;
		}
	}

	return false;
}

/** USER OBFUSCATION RELATED FUNCTIONS **/

/**
 * Create an obfuscation record in the database for the given key and request url.
 *
 * @param $obfuscationkey the obfuscation key used in the cipher when creating the CIF data.
 * @param $obfuscationiv the obfuscation iv used in the cipher when creating the CIF data.
 * @param $request the url of the data api call that will use this record.
 * @return an associative array with 'dataid' for the data api call and 'obfuscationid' for the user api call if successful or Error object if record creation failed.
 */
function createObfuscationEntry($obfuscationkey, $obfuscationiv, $request) {
	global $DB, $HUB_SQL;

	$dt = time();
	$id = getUniqueID();
	$dataid = getUniqueID();

	$params = array();
	$params[0] = $id;
	$params[1] = utf8_encode($obfuscationkey); // Needed otherwise does not store
	$params[2] = utf8_encode($obfuscationiv); // Needed otherwise does not store
	$params[3] = $request;
	$params[4] = $dataid;
	$params[5] = $dt;

	$res = $DB->insert($HUB_SQL->DATAMODEL_UTIL_ADD_OBFUSCATION, $params);
	if (!$res) {
		return database_error();
	} else {
		$array = array();
		$array['obfuscationid'] = $id;
		$array['dataid'] = $dataid;
		return $array;
	}
}

/// USER ON DATA API CALLS ///

/**
 * Return the obfuscation key stored for the given obfuscation data id.
 *
 * @param $dataid the obfuscation data id for the key required.
 * @return String an array with the properties 'ObfuscationKey' and 'ObfuscationIV' for the given obfuscation data id, or Error object.
 */
function getObfuscationKeyByDataID($dataid) {
	global $DB, $HUB_SQL;

	//$session = session_id();

	$params = array();
	$params[0] = $dataid;
	//$params[1] = $session;

	//error_log("session=".$session);

	$resArray = $DB->select($HUB_SQL->DATAMODEL_UTIL_GET_OBFUSCATION_KEY_DATAID, $params);
	$array = array();
	if ($resArray !== false) {
		//error_log(print_r($resArray, true));
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}

		// should only be one results ever;
		if ($count > 0 && $resArray[0]) {
			$resArray[0]['ObfuscationKey'] = utf8_decode($resArray[0]['ObfuscationKey']);
			$resArray[0]['ObfuscationIV'] = utf8_decode($resArray[0]['ObfuscationIV']);
			return $resArray[0];
		} else {
			return database_error();
		}
	} else {
		return database_error();
	}
}

/**
 * Set the userlist and session information for the given obfuscation data id.
 *
 * @param $obfuscadataid the obfuscation data id given.
 * @return $obfuscationid if successful or Error object if record creation failed.
 */
function setObfuscationUsers($dataid, $users) {
	global $DB, $HUB_SQL, $_SERVER;

	$dt = time();

	$ip = $_SERVER['REMOTE_ADDR'];
	$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
	$session = session_id();

	$params = array();
	$params[0] = $users;
	$params[1] = $session;
	$params[2] = $ip;
	$params[3] = $agent;
	$params[4] = $dt;
	$params[5] = $dataid;

	$res = $DB->insert($HUB_SQL->DATAMODEL_UTIL_ADD_OBFUSCATION_USERS, $params);
	if (!$res) {
		return database_error();
	} else {
		return $dataid;
	}
}

/// USER ON USER API CALL ///

/**
 * Return the obfuscation key stored for the given obfuscation id.
 *
 * @param $obfuscationid the obfuscation record id for the key required.
 * @return String an array with the properties 'ObfuscationKey' and 'ObfuscationIV' for the given obfuscation data id, or Error object.
 */
function getObfuscationKey($obfuscationid) {
	global $DB, $HUB_SQL;

	//$session = session_id();

	$params = array();
	$params[0] = $obfuscationid;
	//$params[1] = $session;

	// check if key expired somehow

	$resArray = $DB->select($HUB_SQL->DATAMODEL_UTIL_GET_OBFUSCATION_KEY, $params);
	$array = array();
	if ($resArray !== false) {
		// should only be one results ever;
		if ($resArray[0]) {
			$resArray[0]['ObfuscationKey'] = utf8_decode($resArray[0]['ObfuscationKey']);
			$resArray[0]['ObfuscationIV'] = utf8_decode($resArray[0]['ObfuscationIV']);
			return $resArray[0];
		} else {
			return database_error();
		}
	} else {
		return database_error();
	}
}

/**
 * Return the list of userids stored for the given obfuscation id
 *
 * @param $obfuscationid the obfuscation record id for the user list required.
 * @return String of comma separated userids stored for the given obfuscation id, or Error object.
 */
function getObfuscationUsers($obfuscationid) {
	global $DB, $HUB_SQL;

	$params = array();
	$params[0] = $obfuscationid;

	$resArray = $DB->select($HUB_SQL->DATAMODEL_UTIL_GET_OBFUSCATION_USERS, $params);
	$array = array();
	if ($resArray !== false) {
		// should only be one results ever;
		if ($resArray[0]) {
			return $resArray[0]['Users'];
		} else {
			return database_error();
		}
	} else {
		return database_error();
	}
}

?>