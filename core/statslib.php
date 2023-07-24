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
 * Statistics Utility library
 * Stats functions
 */

/*** STREAM GRAPH ***/
function getStreamGraphData($nodes) {
	global $LNG;
	$data = array();

	$nodeCheck = array();
	$totalnodes = 0;

	$count = 0;
	if (is_countable($nodes)) {
		$count = count($nodes);
	}

	// get types first
	$typeArray = array();
	for ($i=0; $i<$count; $i++) {
		$node = $nodes[$i];
		if (!$node instanceof Hub_Error 
				&& !in_array($node->role->name, $typeArray)) {
			array_push($typeArray, $node->role->name);
		}
	}

	$dateArray = array();
	for ($i=0; $i<$count; $i++) {
		$node = $nodes[$i];
		if (!$node instanceof Hub_Error) {
			$datekey = date('d/m/y', $node->creationdate);
			if (!array_key_exists($datekey, $dateArray)) {
				$typearray = array();
				foreach($typeArray as $type) {
					$typearray[$type] = 0;
				}
				$typearray[$node->role->name] = 1;
				$dateArray[$datekey] = $typearray;
			} else {
				$typearray = $dateArray[$datekey];
				if (!isset($typearray[$node->role->name])) {
					$typearray[$node->role->name] = 1;
				} else {
					$typearray[$node->role->name] = $typearray[$node->role->name]+1;
				}
				$dateArray[$datekey] = $typearray;
			}
		}
	}

	// sort by date
	function datesortstacked($datekeyA, $datekeyB) {
		$a = DateTime::createFromFormat("d/m/y", $datekeyA);
		$b = DateTime::createFromFormat("d/m/y", $datekeyB);
		if ($a == $b) $r = 0;
		else $r = ($a > $b) ? 1: -1;
		return $r;
	}
	uksort($dateArray, "datesortstacked");

	$finalArray = array();

	foreach ($typeArray as $next) {
		foreach ($dateArray as $key => $innerdata) {
			foreach ($innerdata as $type => $typecount) {
				if ($type == $next) {
					if (!array_key_exists($next, $finalArray)) {
						$nextarray = array();
						array_push($nextarray, array($key, $typecount));
						$finalArray[$next] = $nextarray;
					} else {
						$nextarray = $finalArray[$next];
						array_push($nextarray, array($key, $typecount));
						$finalArray[$next] = $nextarray;
					}
				}
			}
		}
	}

	foreach ($finalArray as $key => $values) {
		$next = new stdClass();
		$next->key = getNodeTypeText($key, false);
		$next->values = $values;
		array_push($data, $next);
	}

	return $data;
}

/*** STACKED AREA ***/
/**
 * Load the data for the Stacked Area visulaisation
 * @param nodes the array of nodes to process
 * @return a json string of the data loaded from the node array
 * and converted to the json required by the Stacked Area visualisation
 */
function getStackedAreaData($nodes) {
	global $CFG,$LNG;

	$json="";

	$count = 0;
	if (is_countable($nodes)) {
		$count = count($nodes);
	}

	$typeArray = array($LNG->MAP_NAME,$LNG->CHALLENGE_NAME,$LNG->ISSUE_NAME,$LNG->SOLUTION_NAME,$LNG->PRO_NAME,$LNG->CON_NAME,$LNG->ARGUMENT_NAME,$LNG->COMMENT_NAME);
	$coloursArray = array($CFG->mapbackpale,$CFG->challengebackpale,$CFG->issuebackpale, $CFG->solutionbackpale, $CFG->probackpale, $CFG->conbackpale, $CFG->argumentbackpale, $CFG->ideabackpale);
	$dateArray = array();

	for ($i=0; $i<$count; $i++) {
		$node = $nodes[$i];
		if (!$node instanceof Hub_Error) {
			$datekey = date('d / m / y', $node->creationdate);
			$nodetype = getNodeTypeText($node->role->name, false);
			if (in_array($nodetype, $typeArray)) {
				if (!array_key_exists($datekey, $dateArray)) {
					$typearray = array();
					$typearray[$LNG->MAP_NAME] = 0;
					$typearray[$LNG->CHALLENGE_NAME] = 0;
					$typearray[$LNG->ISSUE_NAME] = 0;
					$typearray[$LNG->SOLUTION_NAME] = 0;
					$typearray[$LNG->PRO_NAME] = 0;
					$typearray[$LNG->CON_NAME] = 0;
					$typearray[$LNG->ARGUMENT_NAME] = 0;
					$typearray[$LNG->COMMENT_NAME] = 0;
					$typearray[$nodetype] = 1;
					$dateArray[$datekey] = $typearray;
				} else {
					$typearray = $dateArray[$datekey];
					$typearray[$nodetype] = $typearray[$nodetype]+1;
					$dateArray[$datekey] = $typearray;
				}
			}
		}
	}

	// sort by date
	function datesortstacked($datekeyA, $datekeyB) {
		$a = DateTime::createFromFormat("d / m / y", $datekeyA);
		$b = DateTime::createFromFormat("d / m / y", $datekeyB);
		if ($a == $b) $r = 0;
		else $r = ($a > $b) ? 1: -1;
		return $r;
	}
	uksort($dateArray, "datesortstacked");

	// Turn data into json
	$count = 0;
	if (is_countable($dateArray)) {
		$count = count($dateArray);
	}
	if ($count > 0) {
		$json .=  "{";

		// Add category index list
		$json .=  "'label' : [";

		$countj = 0;
		if (is_countable($typeArray)) {
			$countj = count($typeArray);
		}
		for($j=0; $j<$countj; $j++) {
			$next = $typeArray[$j];
			$json .=  "'".$next."'";
			if ($j < $countj-1) {
				$json .=  ",";
			}
		}
		$json .=  "],";

		// add colours
		$json .=  "'color' : [";
		$countj = 0;
		if (is_countable($coloursArray)) {
			$countj = count($coloursArray);
		}
		for($j=0; $j<$countj; $j++) {
			$next = $coloursArray[$j];
			$json .=  "'".$next."'";
			if ($j < $countj-1) {
				$json .=  ",";
			}
		}
		$json .=  "],";

		// Add values
		$json .=  "'values': [";
		$i=0;
		foreach ($dateArray as $key => $innerdata) {
			$json .=  "{";
			$json .= "'label': '".$key."',";
			$json .= "'values': [";
			$k=0;
			$countk = 0;
			if (is_countable($innerdata)) {
				$countk = count($innerdata);
			}
			foreach ($innerdata as $type => $typecount) {
				$json .= $typecount;
				if ($k < $countk-1) {
					$json .= ",";
				}
				$k++;
			}
			$json .= "]";
			$json .=  "}";

			if ($i < $count-1) {
				$json .= ",";
			}
			$i++;
		}

		$json .= "]}";
	}

	return $json;
}

/*** CIRCLE PACKING VIS METHODS ***/
/**
 * Helper function for the Circle Packing function. Recurses the data tree
 */
function addNextCirclePackingDepth($json, $node, $depth,$treeArray, $checkArray) {

	$json .=  '{';
	$json .=  '"name": "'.parseToJSON($node->name).'",';
	$json .=  '"nodetype": "'.parseToJSON($node->role->name).'",';
	$json .=  '"nodetypename": "'.getNodeTypeText(parseToJSON($node->role->name), false).'"';

	$treeitem = $treeArray[$node->nodeid];
	$count = 0;
	if (isset($treeitem["children"]) && is_countable($treeitem["children"])) {
		$count = count($treeitem["children"]);
	}
	if (isset($treeitem["children"]) && $count > 0 && !array_key_exists($node->nodeid, $checkArray)) {

		// make sure you don't recurse the same set of children more than once.
		$checkArray[$node->nodeid] = $node->nodeid;

		$children = $treeitem["children"];
		$countkids = 0;
		if (is_countable($children)) {
			$countkids = count($children);
		}
		$json .=  ',"children": [';
		for ($i=0; $i<$countkids; $i++) {
			$child = $children[$i];
			$json = addNextCirclePackingDepth($json, $child, $depth+1,$treeArray, $checkArray);
			if ($i<$countkids-1) {
				$json .=  ',';
			}
		}
		$json .=  "]";
	} else {
		$json .=  ',"size": '.(2000-(20*$depth));
	}

	$json .=  "}";
	return $json;
}

/**
 * Load the data for the Circle Packing visulaisation
 * @param cons the array of connections to process
 * @param groupname the name of the top level cluster group
 * @return a json string of the data loaded from the array of connections
 * and converted to the json required by the Circle packing visualisation
 */
function getCirclePackingData($nodes, $cons, $groupname='Group') {

	$countcons = 0;
	if (is_countable($cons)) {
		$countcons = count($cons);
	}
	$countnodes = 0;
	if (is_countable($nodes)) {
		$countnodes = count($nodes);
	}

	$checkArray = array();
	$treeArray = array();

	for ($i=0; $i<$countnodes; $i++) {
		$node = $nodes[$i];		
		if (!$node instanceof Hub_Error 
				&& !array_key_exists($node->nodeid, $treeArray)) {
			$nodem = array();
			$nodem["to"] = 0;
			$nodem["from"] = 0;
			$nodem["node"] = $node;
			$treeArray[$node->nodeid] = $nodem;
		}
	}

	for ($i=0; $i<$countcons; $i++) {
		$con = $cons[$i];

		if (!$con instanceof Hub_Error) {

			if ($con->to->role->name == 'Map') {
				$from = $con->to;
				$to = $con->from;
			} else {
				$from = $con->from;
				$to = $con->to;
			}

			if (array_key_exists($from->nodeid, $treeArray)) {
				$nodem = $treeArray[$from->nodeid];
				$nodem["from"] = $nodem["from"]+1;
				$treeArray[$from->nodeid] = $nodem;
			} else {
				$nodem = array();
				$nodem["to"] = 0;
				$nodem["from"] = 1;
				$nodem["node"] = $from;
				$treeArray[$from->nodeid] = $nodem;
			}

			if (array_key_exists($to->nodeid, $treeArray)) {
				$nodem = $treeArray[$to->nodeid];
				$nodem["to"] = $nodem["to"]+1;
				if (isset($nodem["children"])) {
					$children = $nodem["children"];
					array_push($children, $from);
					$nodem["children"] = $children;
				} else {
					$children = array();
					array_push($children, $from);
					$nodem["children"] = $children;
				}
				$treeArray[$to->nodeid] = $nodem;
			} else {
				$nodem = array();
				$nodem["to"] = 1;
				$nodem["from"] = 0;
				$nodem["node"] = $to;
				$children = array();
				array_push($children, $from);
				$nodem["children"] = $children;
				$treeArray[$to->nodeid] = $nodem;
			}
		}
	}

	$topNodes = array();
	$counttop = 0;
	if (is_countable($treeArray)) {
		$counttop = count($treeArray);
	}
	foreach ($treeArray as $key => $value) {
		if ($value["from"] == 0) {
			array_push($topNodes, $value["node"]);
		}
	}

	$json =  '{';
	$json .=  '"name": "'.$groupname.'",';
	$json .=  '"nodetype": "Group",';
	$json .=  '"nodetypename": "Group"';
	$count = 0;
	if (is_countable($topNodes)) {
		$count = count($topNodes);
	}
	if ($count > 0) {
		$json .=  ',"children": [';
		for ($i=0; $i<$count; $i++) {
			$node = $topNodes[$i];
			if (!$node instanceof Hub_Error) {
				$json = addNextCirclePackingDepth($json, $node, 1, $treeArray, $checkArray);
				if ($i<$count-1) {
					$json .=  ',';
				}
			}
		}
		$json .=  "]";
	} else {
		$json .=  ',"size": "2000"';
	}

	$json .=  "}";

	return $json;
}

/** ACTIVITY VIS **/

/**
 * Load the data for the Activity Analysis visulaisation
 * @param nodes the array of nodes to process
 * @return an array of arrays of the data loaded from the nodes
 * converted to the structure required by the Activity Analysis visualisation.
 */
function getActivityAnalysisData($nodes) {
	global $LNG;

	$data = array();

	$count = 0;
	if (is_countable($nodes)) {
		$count = count($nodes);
	}
	for ($i=0; $i<$count; $i++) {
		$node = $nodes[$i];
		if (!$node instanceof Hub_Error 
					&& isset($node->activity)) {

			$activityset = $node->activity;
			$activities = $activityset->activities;

			foreach($activities as $activity) {
				if (isset($activity)) {
					$date = $activity->modificationdate;
					$type = $activity->type;
					$changetype = $activity->changetype;
					if ($type == "Node" || $type == "View") {
						$activitytype = $type;
						if ($type == "Node") {
							$activitytype = $changetype;
						}
						if (!isset($activity->userid) || $activity->userid == "") {
							continue;
						}

						$role = $node->role->name;

						$nexttopic = array(
							"date" => $date,
							"type" => $activitytype,
							"nodeid" => $node->nodeid,
							"title" => $node->name,
							"nodetype" => $role,
						);
						array_push($data, (object)$nexttopic);
					}
				}
			}
		}
	}
	return $data;
}

/**
 * Load the data for the User Activity Analysis visulaisation
 * @param nodes the array of nodes to process
 * @return an array of arrays of the data loaded from the nodes
 * converted to the structure required by the User Activity Analysis visualisation.
 */
function getUserActivityAnalysisData($nodes) {
	global $LNG;

	$data = array();

	$count = 0;
	if (is_countable($nodes)) {
		$count = count($nodes);
	}

	$usersCheck = array();
	$users = array();

	$countUsers = 1;

	//error_log("Node Count");
	//error_log($count);

	for ($i=0; $i<$count; $i++) {
		$node = $nodes[$i];

		if (!$node instanceof Hub_Error && isset($node->activity)) {
			$activityset = $node->activity;
			$activities = $activityset->activities;

			foreach($activities as $activity) {
				if (isset($activity)) {
					$date = $activity->modificationdate;
					$type = $activity->type;
					$changetype = $activity->changetype;
					if (($type == "Node" && $changetype == 'add') || $type == "Vote") {
						$role = $node->role->name;
						if ($type == "Vote") {
							$role = $LNG->STATS_ACTIVITY_VOTE;
							//if ($changetype == "Y") {
							//	$role = $LNG->STATS_ACTIVITY_VOTED_FOR;
							//} else {
							//	$role = $LNG->STATS_ACTIVITY_VOTED_AGAINST;
							//}
						}

						$userid = $node->users[0]->userid;
						if (!in_array($userid, $usersCheck)) {
							$users[$userid] = $LNG->STATS_ACTIVITY_USER_ANONYMOUS.$countUsers;
							array_push($usersCheck, $userid);

							$userid = $users[$userid];
							$countUsers++;
						} else {
							$userid = $users[$userid];
						}

						$nexttopic = array(
							"date" => $date,
							"userid" => $userid,
							"nodeid" => $node->nodeid,
							"title" => $node->name,
							"nodetype" => $role,
						);
						array_push($data, (object)$nexttopic);
					}
				}
			}
		}
	}
	return $data;
}


/*** VOTING STATS ***/

function getTotalItemVotes() {
	global $DB,$CFG,$HUB_SQL;

	$params = array();

	$totals = array();

	$sql = $HUB_SQL->STATSLIB_TOTAL_ITEM_VOTES_SELECT;
	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($totals, $array);
		}
	}

	return $totals;
}

function getTotalConnectionVotes() {
	global $DB,$CFG,$HUB_SQL;

	$params = array();

	$totals = array();
	$sql = $HUB_SQL->STATSLIB_TOTAL_CONNECTION_VOTES_SELECT ;
	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($totals, $array);
		}
	}

	return $totals;
}

function getTotalVotes() {
	global $DB,$CFG,$HUB_SQL;

	$params = array();

	$totals = array();
	$sql = $HUB_SQL->STATSLIB_TOTAL_VOTES_SELECT;
	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($totals, $array);
		}
	}

	return $totals;
}

/**
 * Get the Top Voted on Items.
 * @return a 'NodeSet' with variable where each node has an additional properties:
 * 'vote' = total votes, 'up'=for node votes, 'down'=against node votes,
 * 'cup' = for connection votes, 'cdown' = against connection votes
 */
function getTotalTopVotes($count) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $count;

	$topVotedNodes = array();

	$sql = $HUB_SQL->STATSLIB_TOTAL_TOP_VOTES;

	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	/*$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotedNodes, $array);
		}
	}
	return $topVotedNodes;
	*/

	$ns = new NodeSet();
	return $ns->loadNodesWithExtras($sql,$params,'short');
}

/**
 * Get the Top Voted FOR Items.
 * @return a 'NodeSet' with variable where each node has an additional properties.
 * 'vote' = total votes, 'up'=for node votes, 'cup' = for connection votes.
 */
function getTopNodeForVotes($count) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $count;

	$topVotedForNodes = array();

	$sql = $HUB_SQL->STATSLIB_TOP_NODE_FOR_VOTES;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	/*
	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotedForNodes, $array);
		}
	}
	return $topVotedForNodes;
	*/

	$ns = new NodeSet();
	return $ns->loadNodesWithExtras($sql,$params,'short');
}

/**
 * Get the Top Voted AGAINST Items.
 * @return a 'NodeSet' with variable where each node has an additional properties.
 * 'vote' = total votes, 'down'=against node votes, 'cdown' = against connection votes.
 */
function getTopNodeAgainstVotes($count) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $count;

	$topVotedAgainstNodes = array();

	$sql = $HUB_SQL->STATSLIB_TOP_NODE_AGAINST_VOTES;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	/*
	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotedAgainstNodes, $array);
		}
	}
	return $topVotedAgainstNodes;
	*/

	$ns = new NodeSet();
	return $ns->loadNodesWithExtras($sql,$params,'short');
}

function getTopVoters($count) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $count;

	$topVoters = array();

	$sql = $HUB_SQL->STATSLIB_TOP_VOTERS;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVoters, $array);
		}
	}

	return $topVoters;
}

function getTopForVoters($count) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $count;

	$topVotersFor = array();

	$sql = $HUB_SQL->STATSLIB_TOP_FOR_VOTERS;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotersFor, $array);
		}
	}

	return $topVotersFor;
}

function getTopAgainstVoters($count) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $count;

	$topVotersAgainst = array();

	$sql = $HUB_SQL->STATSLIB_TOP_FOR_VOTERS;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotersAgainst, $array);
		}
	}

	return $topVotersAgainst;
}

function getAllVoting(&$direction, $sort, $oldsort) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	if ($direction) {
		if ($oldsort === $sort) {
			if ($direction === 'ASC') {
				$direction = "DESC";
			} else {
				$direction = "ASC";
			}
		} else {
			$direction = "DESC";
		}
	} else {
		$direction = "DESC";
	}

	$allNodeVotes = array();
	$sql = $HUB_SQL->STATSLIB_ALL_VOTING;

	if ($sort != 'Name' && $sort != "NodeType") {
		$sql .= $HUB_SQL->STATSLIB_ALL_VOTING_ORDER_BY.$sort." ".$direction;
	}

	/*$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($allNodeVotes, $array);
		}
	}

	return $allNodeVotes;
	*/

	$ns = new NodeSet();
	$ns->loadNodesWithExtras($sql,$params,'short');

	// These properties had to be taken out of the original sql call
	// as Virtuoso complained about a long data type error
	// Do now data called as separate Nodes and these sorts are done afterwards.
	if ($sort === "Name") {
		if ($direction === "ASC") {
			usort($ns->nodes, 'nameSortASC');
		} else {
			usort($ns->nodes, 'nameSortDESC');
		}
	} else if ($sort === "NodeType") {
		if ($direction === "ASC") {
			usort($ns->nodes, 'roleTextSortASC');
		} else {
			usort($ns->nodes, 'roleTextSortDESC');
		}
	}

	return $ns;
}


/*** VOTING STATS BY GROUP ***/

function getTotalItemVotesByGroup($groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;

	$totals = array();

	$sql = $HUB_SQL->STATSLIB_GROUP_TOTAL_ITEM_VOTES_SELECT;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($totals, $array);
		}
	}

	return $totals;
}

function getTotalConnectionVotesByGroup($groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;

	$totals = array();
	$sql = $HUB_SQL->STATSLIB_GROUP_TOTAL_CONNECTION_VOTES_SELECT ;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($totals, $array);
		}
	}

	return $totals;
}

function getTotalVotesByGroup($groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;

	$totals = array();
	$sql = $HUB_SQL->STATSLIB_GROUP_TOTAL_VOTES_SELECT;
	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($totals, $array);
		}
	}

	return $totals;
}

/**
 * Get the Top Voted on Items.
 * @return a 'NodeSet' with variable where each node has an additional properties:
 * 'vote' = total votes, 'up'=for node votes, 'down'=against node votes,
 * 'cup' = for connection votes, 'cdown' = against connection votes
 */
function getTotalTopVotesByGroup($count, $groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;
	$params[2] = $count;

	$topVotedNodes = array();

	$sql = $HUB_SQL->STATSLIB_GROUP_TOTAL_TOP_VOTES;

	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$ns = new NodeSet();
	return $ns->loadNodesWithExtras($sql,$params,'short');
}

/**
 * Get the Top Voted FOR Items.
 * @return a 'NodeSet' with variable where each node has an additional properties.
 * 'vote' = total votes, 'up'=for node votes, 'cup' = for connection votes.
 */
function getTopNodeForVotesByGroup($count, $groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;
	$params[2] = $count;

	$topVotedForNodes = array();

	$sql = $HUB_SQL->STATSLIB_GROUP_TOP_NODE_FOR_VOTES;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	/*
	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotedForNodes, $array);
		}
	}
	return $topVotedForNodes;
	*/

	$ns = new NodeSet();
	return $ns->loadNodesWithExtras($sql,$params,'short');
}

/**
 * Get the Top Voted AGAINST Items.
 * @return a 'NodeSet' with variable where each node has an additional properties.
 * 'vote' = total votes, 'down'=against node votes, 'cdown' = against connection votes.
 */
function getTopNodeAgainstVotesByGroup($count, $groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;
	$params[2] = $count;

	$topVotedAgainstNodes = array();

	$sql = $HUB_SQL->STATSLIB_GROUP_TOP_NODE_AGAINST_VOTES;

	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$ns = new NodeSet();
	return $ns->loadNodesWithExtras($sql,$params,'short');
}

function getTopVotersByGroup($count, $groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;
	$params[2] = $groupid;
	$params[3] = $count;

	$topVoters = array();

	$sql = $HUB_SQL->STATSLIB_GROUP_TOP_VOTERS;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVoters, $array);
		}
	}

	return $topVoters;
}

function getTopForVotersByGroup($count, $groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;
	$params[2] = $groupid;
	$params[3] = $count;

	$topVotersFor = array();

	$sql = $HUB_SQL->STATSLIB_GROUP_TOP_FOR_VOTERS;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotersFor, $array);
		}
	}

	return $topVotersFor;
}

function getTopAgainstVotersByGroup($count, $groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;
	$params[2] = $groupid;
	$params[3] = $count;

	$topVotersAgainst = array();

	$sql = $HUB_SQL->STATSLIB_GROUP_TOP_FOR_VOTERS;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($topVotersAgainst, $array);
		}
	}

	return $topVotersAgainst;
}

function getAllVotingByGroup(&$direction, $sort, $oldsort, $groupid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;
	$params[1] = $groupid;

	if ($direction) {
		if ($oldsort === $sort) {
			if ($direction === 'ASC') {
				$direction = "DESC";
			} else {
				$direction = "ASC";
			}
		} else {
			$direction = "DESC";
		}
	} else {
		$direction = "DESC";
	}

	$allNodeVotes = array();
	$sql = $HUB_SQL->STATSLIB_GROUP_ALL_VOTING;

	if ($sort != 'Name' && $sort != "NodeType") {
		$sql .= $HUB_SQL->STATSLIB_ALL_VOTING_ORDER_BY.$sort." ".$direction;
	}

	$ns = new NodeSet();
	$ns->loadNodesWithExtras($sql,$params,'short');

	// These properties had to be taken out of the original sql call
	// as Virtuoso complained about a long data type error
	// Do now data called as separate Nodes and these sorts are done afterwards.
	if ($sort === "Name") {
		if ($direction === "ASC") {
			usort($ns->nodes, 'nameSortASC');
		} else {
			usort($ns->nodes, 'nameSortDESC');
		}
	} else if ($sort === "NodeType") {
		if ($direction === "ASC") {
			usort($ns->nodes, 'roleTextSortASC');
		} else {
			usort($ns->nodes, 'roleTextSortDESC');
		}
	}

	return $ns;
}



/*** USER CONTEXT STATS ***/

function getTotalVotesForUser($userid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $userid;
	$totals = array();

	$sql = $HUB_SQL->STATSLIB_USER_TOTAL_VOTES;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($totals, $array);
		}
	}

	return $totals;
}

function getAllVotingForUser($userid, $direction, $sort, $oldsort) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $userid;

	$allNodeVotes = array();

	if ($direction) {
		if ($oldsort === $sort) {
			if ($direction === 'ASC') {
				$direction = "DESC";
			} else {
				$direction = "ASC";
			}
		} else {
			$direction = "DESC";
		}
	} else {
		$direction = "DESC";
	}

	$allNodeVotes = array();
	$sql = $HUB_SQL->STATSLIB_USER_ALL_VOTING;

	if ($sort != 'Name' && $sort != "NodeType") {
		$sql .= $HUB_SQL->STATSLIB_ALL_VOTING_ORDER_BY.$sort." ".$direction;
	}

	$ns = new NodeSet();
	$ns->loadNodesWithExtras($sql,$params,'short');

	// These properties had to be taken out of the original sql call
	// as Virtuoso complained about a long data type error
	// Do now data called as separate Nodes and these sorts are done afterwards.
	if ($sort === "Name") {
		if ($direction === "ASC") {
			usort($ns->nodes, 'nameSortASC');
		} else {
			usort($ns->nodes, 'nameSortDESC');
		}
	} else if ($sort === "NodeType") {
		if ($direction === "ASC") {
			usort($ns->nodes, 'roleTextSortASC');
		} else {
			usort($ns->nodes, 'roleTextSortDESC');
		}
	}

	return $ns;
}

function getTopTagForUser($userid, $count) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $userid;
	$params[1] = $userid;
	$params[2] = $userid;
	$params[3] = $userid;

	$tags = array();

	$sql = $HUB_SQL->STATSLIB_USER_TOP_TAG;
	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, $count);

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$name = $array['Name'];
			$tags[$name] = $array['UseCount'];
		}
	}

	return $tags;
}

function getLinkTypesForUser($userid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $userid;

	$linkArray = array();

	$sql = $HUB_SQL->STATSLIB_USER_LINK_TYPES;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$name = $array['Label'];
			$count = $array['num'];
			$linkArray[$name] = $count;
		}
	}

	return $linkArray;
}

function getNodeTypesForUser($userid) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $userid;

	$nodeArray = array();

	$sql = $HUB_SQL->STATSLIB_USER_NODE_TYPES;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$name = $array['Name'];
			$nodeArray[$name] = $array['num'];
		}
	}

	return $nodeArray;
}

function getComparedThinkingForUser($userid) {
	global $DB,$CFG, $USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $userid;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;
	$params[4] = 'N';
	$params[5] = $currentuser;
	$params[6] = $currentuser;
	$params[7] = 'N';
	$params[8] = $currentuser;
	$params[9] = $currentuser;
	$params[10] = $userid;
	$params[11] = 'N';
	$params[12] = $currentuser;
	$params[13] = $currentuser;
	$params[14] = 'N';
	$params[15] = $currentuser;
	$params[16] = $currentuser;
	$params[17] = 'N';
	$params[18] = $currentuser;
	$params[19] = $currentuser;
	$params[20] = $userid;
	$params[21] = $userid;
	$params[22] = $userid;
	$params[23] = $userid;

	$connectionSet = new ConnectionSet();

	$sql = $HUB_SQL->STATSLIB_USER_COMPARED_THINKING;

	$resArray = $DB->select($sql, $params);
	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$id = $array['TripleID'];
			$con = new Connection();
			$con->connid = $id;
			$con = $con->load();
			if (!$con instanceof Hub_Error) {
				$countcompare = 0;
				if (is_countable($comparedArray)) {
					$countcompare = count($comparedArray);
				}
				$comparedArray[$countcompare] = $con;
			}
		}

		$connectionSet->totalno = 0;
		if (is_countable($connectionSet->connections)) {
			$connectionSet->totalno = count($connectionSet->connections);
		}
		$connectionSet->start = 0;
		$connectionSet->count = $connectionSet->totalno;
	}

	return $connectionSet;
}

function getInformationBrokeringForUser($userid) {
	global $DB,$CFG, $USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $userid;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;
	$params[4] = 'N';
	$params[5] = $currentuser;
	$params[6] = $currentuser;
	$params[7] = 'N';
	$params[8] = $currentuser;
	$params[9] = $currentuser;
	$params[10] = $userid;
	$params[11] = 'N';
	$params[12] = $currentuser;
	$params[13] = $currentuser;
	$params[14] = 'N';
	$params[15] = $currentuser;
	$params[16] = $currentuser;
	$params[17] = 'N';
	$params[18] = $currentuser;
	$params[19] = $currentuser;
	$params[20] = $userid;
	$params[21] = $userid;

	$brokerConnectionSet = new ConnectionSet();

	$sql = $HUB_SQL->STATSLIB_USER_INFORMATION_BROKERING;
	$resArray = $DB->select($sql, $params);

	$nodeArray = array();
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$id = $array['TripleID'];
			$con = new Connection();
			$con->connid = $id;
			$con = $con->load();
			if (!$con instanceof Hub_Error) {
				$brokerConnectionSet->add($con);
			}
		}

		$brokerConnectionSet->totalno  = 0;
		if (is_countable($brokerConnectionSet->connections)) {
			$brokerConnectionSet->totalno  = count($brokerConnectionSet->connections);
		}
		$brokerConnectionSet->start = 0;
		$brokerConnectionSet->count = $brokerConnectionSet->totalno;
	}

	return $brokerConnectionSet;
}

/*** GLOBAL STATS ***/

/**
 * Get the most used Link Type
 * return an array with two items; 0=count, 1=Link Type name
 */
function getMostUsedLinkType() {
	global $DB,$HUB_SQL,$CFG;

	$linkCount = 0;
	$linkName = "";

	$params = array();

	// MOST USED LinkType
	$sql = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_SELECT;

	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		// Get Node Types
		$nodetypesArray = array();
		$nodetypes = "";

		$count = 0;
		if (is_countable($CFG->BASE_TYPES)) {
			$count = count($CFG->BASE_TYPES);
		}
		for($i=0; $i<$count; $i++){
			$nodetypesArray[count($nodetypesArray)] = $CFG->BASE_TYPES[$i];
			if ($i == 0) {
				$nodetypes .= "?";
			} else {
				$nodetypes .= ",?";
			}
		}
		$count = 0;
		if (is_countable($CFG->EVIDENCE_TYPES)) {
			$count = count($CFG->EVIDENCE_TYPES);
		}
		for ($i=0; $i<$count; $i++) {
			$nodetypesArray[count($nodetypesArray)] = $CFG->EVIDENCE_TYPES[$i];
			$nodetypes .= ",?";
		}
		$nodetypesArray[count($nodetypesArray)] = 'Pro';
		$nodetypes .= ",?";
		$nodetypesArray[count($nodetypesArray)] = 'Con';
		$nodetypes .= ",?";

		$count = 0;
		if(is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$name = $array['Label'];

			$params = array();

			$qry4 = $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART1;
			$params = array_merge($params, $nodetypesArray);
			$qry4 .= $nodetypes;
			$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART2;

			$params = array_merge($params, $nodetypesArray);
			$qry4 .= $nodetypes;

			$params[count($params)] = $name;
			$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART3;

			$resArray2 = $DB->select($qry4, $params);
			if ($resArray2 !== false) {
				$countk = 0;
				if (is_countable($resArray2)) {
					$countk = count($resArray2);
				}
				for ($k=0; $k<$countk; $k++) {
					$array = $resArray2[$k];
					$counts = $array['num'];
					if ($counts > $linkCount) {
						$linkCount = $counts;
						$linkName = $name;
					}
				}
			}
		}
	}

	return array($linkCount, $linkName);
}

/**
 * Get the most used Node Type
 * return an array with two items; 0=count, 1=Node Type name
 */
function getMostUsedNodeType() {
	global $DB,$HUB_SQL,$CFG;

	$params = array();

	//$nodetypes = getAllNodeTypeNames();
	//$innersql = getSQLForNodeTypeIDsForLabels($params,$nodetypes);

	// Get Node Types
	$nodetypesArray = array();
	$nodetypes = "";
	$count = 0;
	if (is_countable($CFG->BASE_TYPES)) {
		$count = count($CFG->BASE_TYPES);
	}
	for($i=0; $i<$count; $i++){
		$nodetypesArray[count($nodetypesArray)] = $CFG->BASE_TYPES[$i];
		if ($i == 0) {
			$nodetypes .= "?";
		} else {
			$nodetypes .= ",?";
		}
	}
	$count = 0;
	if (is_countable($CFG->EVIDENCE_TYPES)) {
		$count = count($CFG->EVIDENCE_TYPES);
	}
	for ($i=0; $i<$count; $i++) {
		$nodetypesArray[count($nodetypesArray)] = $CFG->EVIDENCE_TYPES[$i];
		$nodetypes .= ",?";
	}
	$nodetypesArray[count($nodetypesArray)] = 'Pro';
	$nodetypes .= ",?";
	$nodetypesArray[count($nodetypesArray)] = 'Con';
	$nodetypes .= ",?";

	$sql = $HUB_SQL->STATSLIB_GLOBAL_NODETYPE_SELECT_PART1;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_NODETYPE_SELECT_PART2;

	$roleCount = 0;
	$role->name = "";

	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		$roleIDs = "";
		$previousName = "";
		for ($i=0; $i<$count; $i++) {

			$array = $resArray[$i];
			$name = $array['Name'];
			$roleid = $array['NodeTypeID'];

			$params = array();

			if ($previousName == "") {
				$previousName = $name;
			}

			if ($previousName != $name) {

				$qry4 = $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART1;
				$params = array_merge($params, $nodetypesArray);
				$qry4 .= $nodetypes;
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART2;
				$params = array_merge($params, $nodetypesArray);
				$qry4 .= $nodetypes;
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART3 = "))) AND (FromContextTypeID IN (";
				$qry4 .= $roleIDs; // Do not need escaping so can go stright in
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART4 = ") or ToContextTypeID IN (";
				$qry4 .= $roleIDs; // Do not need escaping so can go stright in
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART5 = "))";

				$resArray2 = $DB->select($qry4, $params);
				if ($resArray2 !== false) {
					$countk = 0;
					if (is_countable($resArray2)) {
						$countk = count($resArray2);
					}
					for ($k=0; $k<$countk; $k++) {
						$array2 = $resArray2[$k];
						$counts = $array2['num'];
						if ($counts > $roleCount) {
							$roleCount = $counts;
							$role->name = $previousName;
						}
					}
				}

				$roleIDs = "";
			}

			$previousName = $name;

			if ($roleIDs == "") {
				$roleIDs .= "'".$roleid."'";
			} else {
				$roleIDs .= ", '".$roleid."'";
			}
		}
	}

	return array($roleCount, $role->name);
}

/**
 * Get the most Connected Node
 * @param $nodetypes the Node Type Names to get the information for
 * return an array with three items; 1=Name, 2=Node Type 3=count.
 */
function getMostConnectedNode() {
	global $DB,$USER,$HUB_SQL,$CFG;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// Get Node Types
	$nodetypesArray = array();
	$nodetypes = "";
	$count = 0;
	if (is_countable($CFG->BASE_TYPES)) {
		$count = count($CFG->BASE_TYPES);
	}
	for($i=0; $i<$count; $i++){
		$nodetypesArray[count($nodetypesArray)] = $CFG->BASE_TYPES[$i];
		if ($i == 0) {
			$nodetypes .= "?";
		} else {
			$nodetypes .= ",?";
		}
	}
	$count = 0;
	if (is_countable($CFG->EVIDENCE_TYPES)) {
		$count = count($CFG->EVIDENCE_TYPES);
	}
	for ($i=0; $i<$count; $i++) {
		$nodetypesArray[count($nodetypesArray)] = $CFG->EVIDENCE_TYPES[$i];
		$nodetypes .= ",?";
	}
	$nodetypesArray[count($nodetypesArray)] = 'Pro';
	$nodetypes .= ",?";
	$nodetypesArray[count($nodetypesArray)] = 'Con';
	$nodetypes .= ",?";

	$mostconidea = "";
	$mostcontype = "";
	$mostconideaCount = 0;

	$sql = $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1b;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART2;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART3;

	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4b;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART5;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART6;

	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, 1);

	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$id = $array['ID'];
			$node = new CNode();
			$node->nodeid = $id;
			$node = $node->load();
			if (!$node instanceof Hub_Error) {
				$countr = $array['num'];
				$mostconidea = $node->name;
				$mostcontype = $node->role->name;
				$mostconideaCount = $countr;
			}
		}
	}
	return array($mostconidea, $mostcontype, $mostconideaCount);
}

/**
 * Get the link tpye usage for each user
 * return an array with two items; 1=Array of arrays of link type use counts, 2=An array of users for thos counts.
 * Both return arrays are associative mapped to the userids.
 */
function getLinkTypeUsage() {
	global $DB,$HUB_SQL;

	$params = array();

	$qryStart = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART1;
	$qryNames = "";
	$qryMiddle = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART2;
	$qryIDs = "";
	$qryEnd = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART3;
	$qry = "";

	$userSet = getActiveConnectionUsers(0, 10);
	if ($userSet->count > 0) {
		for ($i = 0; $i < $userSet->count; $i++) {
			$user = $userSet->users[$i];
			if ($user->userid && $user->userid != "") {
				$name = "_".$user->userid; // because can't use a number to start an alias name

				if ($i==0) {
					$qryNames .= $name;
					$qryIDs .= "'".$user->userid."'";
				} else {
					$qryNames .= ",".$name;
					$qryIDs .= ",'".$user->userid."'";
				}

				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART4.$name;

				$params[count($params)] = $user->userid;
				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART5.$user->userid;
				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART6.$user->userid;
				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART7;
			}
		}
	}

	if ($qryNames != "" && $qryIDs != "") {
		$qryFinal = $qryStart;
		$qryFinal .= $qryNames;
		$qryFinal .= $qryMiddle;
		$qryFinal .= $qryIDs;
		$qryFinal .= $qryEnd;
		$qryFinal .= $qry;
		$qryFinal .= $HUB_SQL->CLOSING_BRACKET;

		$linktypeUse = array();
		$resArray = $DB->select($qryFinal, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$linktypeUse[count($linktypeUse)] = $array;
			}
		}

		$qry = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_SELECT;
		$qry .= $qryIDs;
		$qry .= $HUB_SQL->CLOSING_BRACKET;

		$linktypeName = array();
		$resArray = $DB->select($qry, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$linktypeName[$array['UserID']] = $array['Name'];
			}
		}
	}

	return array($linktypeUse, $linktypeName);
}

/**
 * Return the total count of all users (not groups) excluding the default user.
 */
function getTotalUsersCount() {
	global $DB, $CFG,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->defaultUserID;

	$sql = $HUB_SQL->STATSLIB_GLOBAL_REGISTERED_USERS_COUNT;

	$count = 0;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$counti = 0;
		if (is_countable($resArray)) {
			$counti = count($resArray);
		}
		for ($i=0; $i<$counti; $i++) {
			$array = $resArray[$i];
			$count = $array['num'];
		}
	}

	return $count;
}

function getRegisteredUsers($direction, $sort, $oldsort) {
	global $DB,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->defaultUserID;

	$sql = $HUB_SQL->STATSLIB_GLOBAL_REGISTERED_USERS;

	if ($sort) {
		if ($direction) {
			if ($oldsort === $sort) {
				if ($direction === 'ASC') {
					$direction = "DESC";
				} else {
					$direction = "ASC";
				}
			} else {
				$direction = "ASC";
			}
		} else {
			$direction = "ASC";
		}

		if ($sort == 'name') {
			$sql .= $HUB_SQL->ORDER_BY_NAME.$direction;
		} else if ($sort == 'date') {
			$sql .= $HUB_SQL->ORDER_BY_CREATIONDATE.$direction;
		} else if ($sort == 'login') {
			$sql .= $HUB_SQL->ORDER_BY_LASTLOGIN.$direction;
		} else if ($sort == 'email') {
			$sql .= $HUB_SQL->ORDER_BY_EMAIL.$direction;
		} else if ($sort == 'web') {
			$sql .= $HUB_SQL->ORDER_BY_WEBSITE.$direction;
		} else if ($sort == 'location') {
			$sql .= $HUB_SQL->ORDER_BY_LOCATION.$direction;
		}
	} else {
		$sql .= ' order by CreationDate DESC';
	}

	$registeredUsers = array();
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			array_push($registeredUsers,$array);
		}
	}

	// VIRTUOSO cannot order by long fields
	if ($sort == 'desc') {
		if ($direction == 'ASC') {
			usort($registeredUsers, 'descArraySortASC');
		} else {
			usort($registeredUsers, 'descArraySortDESC');
		}
	}

	return $registeredUsers;
}

/**
 * Calculate the count of user registrations between the given dates/times
 * @param $mintime the start time to count user registration from (timestamp).
 * @param $maxtime the end time to count user registrations to (timestamp).
 * return an inter count of the user registrations between the given times/dates
 */
function getRegisteredUserCount($mintime, $maxtime) {
	global $DB, $CFG,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->defaultUserID;
	$params[1] = $mintime;
	$params[2] = $maxtime;

	$sql = $HUB_SQL->STATSLIB_GLOBAL_REGISTERED_USER_COUNT_DATE;

	$num = 0;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$num = $array['num'];
		}
	}
	return $num;
}

/**
 * Calculate the count of nodecreations between the given dates/times for the given node type name
 * @param $nodetypenames the names of the node type (comma separated list).
 * @param $mintime the start time to count node creations from (timestamp).
 * @param $maxtime the end time to count node creations to (timestamp). Optional. If not set then it is until now.
 * return an inter count of the node creations between the given times/dates for the given node type name
 */
function getNodeCreationCount($nodetypenames,$mintime, $maxtime="") {
	global $DB, $CFG,$HUB_SQL;

	$params = array();

	$nodetypes = "";
	$nodetypesArray = array();
    $types = explode("," , $nodetypenames);
	$count = 0;
	if(is_countable($types)) {
		$count = count($types);
	}
	for($k=0; $k<$count; $k++){
		$nodetypesArray[count($nodetypesArray)] = $types[$k];
		if ($k == 0) {
			$nodetypes .= "?";
		} else {
			$nodetypes .= ",?";
		}
	}

	$params[0] = $mintime;
	$qry = $HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT;
	if (isset($maxtime) && $maxtime != "") {
		$params[count($params)] = $maxtime;
		$qry .= $HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT_DATE;
	}

	$params = array_merge($params, $nodetypesArray);
	$qry .= $HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT_NODE_TYPE_PART1;
	$qry .= $nodetypes;
	$qry .= $HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT_NODE_TYPE_PART2;


	$num = 0;
	$resArray = $DB->select($qry, $params);
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$num = $array['num'];
		}
	}
	return $num;
}

/*** BY GROUP ***/

/**
 * Get the most used Link Type
 * @param $nodetypes the Node Type Names to get the information for
 * @param $groupid the id of the group to filter on
 * return an array with two items; 0=count, 1=Link Type name
 */
function getMostUsedLinkTypeByGroup($nodetypes, $groupid) {
	global $DB,$HUB_SQL,$CFG;

	$linkCount = 0;
	$linkName = "";

	$params = array();

	// MOST USED LinkType
	$sql = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_SELECT;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {

		// Get Node Types
		$nodetypesArray = array();
		$nodetypes = "";
		$count = 0;
		if (is_countable($CFG->BASE_TYPES)) {
			$count = count($CFG->BASE_TYPES);
		}
		for($k=0; $k<$count; $k++){
			$nodetypesArray[count($nodetypesArray)] = $CFG->BASE_TYPES[$k];
			if ($k == 0) {
				$nodetypes .= "?";
			} else {
				$nodetypes .= ",?";
			}
		}
		$count = 0;
		if (is_countable($CFG->EVIDENCE_TYPES)) {
			$count = count($CFG->EVIDENCE_TYPES);
		}
		for ($k=0; $k<$count; $k++) {
			$nodetypesArray[count($nodetypesArray)] = $CFG->EVIDENCE_TYPES[$k];
			$nodetypes .= ",?";
		}
		$nodetypesArray[count($nodetypesArray)] = 'Pro';
		$nodetypes .= ",?";
		$nodetypesArray[count($nodetypesArray)] = 'Con';
		$nodetypes .= ",?";

		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$name = $array['Label'];

			$params = array();

			$qry4 = $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART1_GROUP;
			$params = array_merge($params, $nodetypesArray);
			$qry4 .= $nodetypes;
			$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART2;

			$params = array_merge($params, $nodetypesArray);
			$qry4 .= $nodetypes;

			$params[count($params)] = $name;
			$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART3;

			$params[count($params)] = $groupid;
			$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_GROUP_FILTER;

			$resArray2 = $DB->select($qry4, $params);
			if ($resArray2 !== false) {
				$countk = 0;
				if (is_countable($resArray2)) {
					$countk = count($resArray2);
				}
				for ($k=0; $k<$countk; $k++) {
					$array = $resArray2[$k];
					$countk = $array['num'];
					if ($countk > $linkCount) {
						$linkCount = $countk;
						$linkName = $name;
					}
				}
			}
		}
	}

	return array($linkCount, $linkName);
}

/**
 * Get the most used Node Type
 * @param $nodetypes the Node Type Names to get the information for
 * @param $groupid the id of the group to filter on
 * return an array with two items; 0=count, 1=Node Type name
 */
function getMostUsedNodeTypeByGroup($nodetypes, $groupid) {
	global $DB,$HUB_SQL,$CFG;

	$params = array();

	//$nodetypes = getAllNodeTypeNames();
	//$innersql = getSQLForNodeTypeIDsForLabels($params,$nodetypes);

	// Get Node Types
	$nodetypesArray = array();
	$nodetypes = "";

	$count = 0;
	if (is_countable($CFG->BASE_TYPES)) {
		$count = count($CFG->BASE_TYPES);
	}
	for($i=0; $i<$count; $i++){
		$nodetypesArray[count($nodetypesArray)] = $CFG->BASE_TYPES[$i];
		if ($i == 0) {
			$nodetypes .= "?";
		} else {
			$nodetypes .= ",?";
		}
	}

	$count = 0;
	if (is_countable($CFG->EVIDENCE_TYPES)) {
		$count = count($CFG->EVIDENCE_TYPES);
	}
	for ($i=0; $i<$count; $i++) {
		$nodetypesArray[count($nodetypesArray)] = $CFG->EVIDENCE_TYPES[$i];
		$nodetypes .= ",?";
	}
	$nodetypesArray[count($nodetypesArray)] = 'Pro';
	$nodetypes .= ",?";
	$nodetypesArray[count($nodetypesArray)] = 'Con';
	$nodetypes .= ",?";

	$sql = $HUB_SQL->STATSLIB_GLOBAL_NODETYPE_SELECT_PART1;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_NODETYPE_SELECT_PART2;

	$roleCount = 0;
	$role->name = "";

	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {

		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		$roleIDs = "";
		$previousName = "";
		for ($i=0; $i<$count; $i++) {

			$array = $resArray[$i];
			$name = $array['Name'];
			$roleid = $array['NodeTypeID'];

			$params = array();

			if ($previousName == "") {
				$previousName = $name;
			}

			if ($previousName != $name) {

				$qry4 = $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART1_GROUP;
				$params = array_merge($params, $nodetypesArray);
				$qry4 .= $nodetypes;
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART2;
				$params = array_merge($params, $nodetypesArray);
				$qry4 .= $nodetypes;
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART3;
				$qry4 .= $roleIDs; // Do not need escaping so can go stright in
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART4;
				$qry4 .= $roleIDs; // Do not need escaping so can go stright in
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART5;

				$params[count($params)] = $groupid;
				$qry4 .= $HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_GROUP_FILTER;

				$resArray2 = $DB->select($qry4, $params);
				if ($resArray2 !== false) {
					$countk = 0;
					if (is_countable($resArray2)) {
						$countk = count($resArray2);
					}
					for ($k=0; $k<$countk; $k++) {
						$array2 = $resArray2[$k];
						$counts = $array2['num'];
						if ($counts > $roleCount) {
							$roleCount = $counts;
							$role->name = $previousName;
						}
					}
				}

				$roleIDs = "";
			}

			$previousName = $name;

			if ($roleIDs == "") {
				$roleIDs .= "'".$roleid."'";
			} else {
				$roleIDs .= ", '".$roleid."'";
			}
		}
	}
	return array($roleCount, $role->name);
}

/**
 * Get the link type usage for each user
 * return an array with two items; 1=Array of arrays of link type use counts, 2=An array of users for thos counts.
 * Both return arrays are associative mapped to the userids.
 * @param $groupid the id of the group to filter on
 */
function getLinkTypeUsageByGroup($groupid) {
	global $DB,$HUB_SQL;

	$params = array();

	$qryStart = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART1;
	$qryNames = "";
	$qryMiddle = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART2;
	$qryIDs = "";
	$qryEnd = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART3;
	$qry = "";

	$userSet = getActiveConnectionUsers(0, 10);
	if ($userSet->count > 0) {
		for ($i = 0; $i < $userSet->count; $i++) {
			$user = $userSet->users[$i];
			if ($user->userid && $user->userid != "") {
				$name = "_".$user->userid; // because can't use a number to start an alias name

				if ($i==0) {
					$qryNames .= $name;
					$qryIDs .= "'".$user->userid."'";
				} else {
					$qryNames .= ",".$name;
					$qryIDs .= ",'".$user->userid."'";
				}

				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART4.$name;

				$params[count($params)] = $groupid;
				$params[count($params)] = $user->userid;
				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART5_GROUPS.$user->userid;
				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART6.$user->userid;
				$qry .= $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART7;
			}
		}
	}

	if ($qryNames != "" && $qryIDs != "") {
		$qryFinal = $qryStart;
		$qryFinal .= $qryNames;
		$qryFinal .= $qryMiddle;
		$qryFinal .= $qryIDs;
		$qryFinal .= $qryEnd;
		$qryFinal .= $qry;
		$qryFinal .= $HUB_SQL->CLOSING_BRACKET;

		$linktypeUse = array();

		//error_log($qryFinal);

		$resArray = $DB->select($qryFinal, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$linktypeUse[count($linktypeUse)] = $array;
			}
		}

		$qry = $HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_SELECT;
		$qry .= $qryIDs;
		$qry .= $HUB_SQL->CLOSING_BRACKET;

		$linktypeName = array();
		$resArray = $DB->select($qry, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$linktypeName[$array['UserID']] = $array['Name'];
			}
		}

	}

	return array($linktypeUse, $linktypeName);
}

/**
 * Get the most Connected Node
 * @param $nodetypes the Node Type Names to get the information for
 * @param $groupid the id of the group to filter on
 * return an array with three items; 1=Name, 2=Node Type 3=count.
 */
function getMostConnectedNodeByGroup($nodetypes, $groupid) {
	global $DB,$USER,$HUB_SQL,$CFG;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// Get Node Types
	$nodetypesArray = array();
	$nodetypes = "";
	$count = 0;
	if (is_countable($CFG->BASE_TYPES)) {
		$count = count($CFG->BASE_TYPES);
	}
	for($i=0; $i<$count; $i++){
		$nodetypesArray[count($nodetypesArray)] = $CFG->BASE_TYPES[$i];
		if ($i == 0) {
			$nodetypes .= "?";
		} else {
			$nodetypes .= ",?";
		}
	}
	$count = 0;
	if (is_countable($CFG->EVIDENCE_TYPES)) {
		$count = count($CFG->EVIDENCE_TYPES);
	}
	for ($i=0; $i<$count; $i++) {
		$nodetypesArray[count($nodetypesArray)] = $CFG->EVIDENCE_TYPES[$i];
		$nodetypes .= ",?";
	}
	$nodetypesArray[count($nodetypesArray)] = 'Pro';
	$nodetypes .= ",?";
	$nodetypesArray[count($nodetypesArray)] = 'Con';
	$nodetypes .= ",?";

	$mostconidea = "";
	$mostcontype = "";
	$mostconideaCount = 0;

	$sql = $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1_GROUP;
	$params[count($params)] = $groupid;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1b_GROUP;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART2;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART3;

	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4_GROUP;

	$params[count($params)] = $groupid;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4b_GROUP;

	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART5;
	$params = array_merge($params, $nodetypesArray);
	$sql .= $nodetypes;

	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART6;

	// ADD LIMITING
	$sql = $DB->addLimitingResults($sql, 0, 1);

	//error_log(print_r($sql, true));

	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$id = $array['ID'];
			$node = new CNode();
			$node->nodeid = $id;
			$node = $node->load();
			if (!$node instanceof Hub_Error) {
				$countr = $array['num'];
				$mostconidea = $node->name;
				$mostcontype = $node->role->name;
				$mostconideaCount = $countr;
			}
		}
	}
	return array($mostconidea, $mostcontype, $mostconideaCount);
}

function getAllConnections($sort, $lastsort, $direction) {

	global $CFG,$DB,$HUB_FLM,$HUB_SQL;

	$params = array();
	$params[0] = '';

	$qry = $HUB_SQL->STATSLIB_ALL_CONNECTIONS;

	if ($sort) {
		if ($direction) {
			if ($oldsort === $sort) {
				if ($direction === 'ASC') {
					$direction = "DESC";
				} else {
					$direction = "ASC";
				}
			} else {
				$direction = "ASC";
			}
		} else {
			$direction = "ASC";
		}

		if ($sort == 'from') {
			$qry .= ' ORDER BY FromName '.$direction;
		} else if ($sort == 'date') {
			$qry .= ' ORDER BY Triple.CreationDate '.$direction;
		} else if ($sort == 'totype') {
			$qry .= ' ORDER BY ToType '.$direction;
		} else if ($sort == 'fromtype') {
			$qry .= ' ORDER BY FromType '.$direction;
		} else if ($sort == 'link') {
			$qry .= ' ORDER BY LinkLabel '.$direction;
		} else if ($sort == 'user') {
			$qry .= ' ORDER BY ConnectionAuthor '.$direction;
		} else if ($sort == 'fromuser') {
			$qry .= ' ORDER BY FromAuthor '.$direction;
		} else if ($sort == 'touser') {
			$qry .= ' ORDER BY ToAuthor '.$direction;
		}
	} else {
		$qry .= ' ORDER BY Triple.CreationDate DESC';
	}

	$resArray = $DB->select($qry, $params);

	if ($sort === "from") {
		if ($direction === "ASC") {
			usort($resArray, 'fromNameArraySortASC');
		} else {
			usort($resArray, 'fromNameArraySortDESC');
		}
	} else if ($sort === "to") {
		if ($direction === "ASC") {
			usort($resArray, 'toNameArraySortASC');
		} else {
			usort($resArray, 'toNameArraySortDESC');
		}
	}

	return $resArray;
}

/**
 * Sort objects by connection from name value ASC
 */
function fromNameArraySortASC($a,$b) {
	return strcmp($a['FromName'], $b['FromName']);
}

/**
 * Sort objects by connection from name value DESC
 */
function fromNameArraySortDESC($a,$b) {
	$result = strcmp($a['FromName'], $b['FromName']);
	if ($results < 0) {
		return 1;
	} else if ($results > 0) {
		return -1;
	} else {
		return 0;
	}
}

/**
 * Sort objects by connection to name value ASC
 */
function toNameArraySortASC($a,$b) {
	return strcmp($a['ToName'], $b['ToName']);
}

/**
 * Sort objects by connection to name value DESC
 */
function toNameArraySortDESC($a,$b) {
	$result = strcmp($a['ToName'], $b['ToName']);
	if ($results < 0) {
		return 1;
	} else if ($results > 0) {
		return -1;
	} else {
		return 0;
	}
}

/*** BY DEBATE ***/
function getConnectionsForDebate($nodeid) {

	$linklabels = array("","supports,challenges");
	$linkgroups = array("All", "");
	$directions = array("incoming","incoming");
	$nodetypes = array("Solution","Pro,Con,Comment");
	$nodeids = array("","");

	$conSet = getConnectionsByPathByDepth('or', 'all', 'false', $nodeid, 2, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, 'true', 'long', 0);
	return $conSet;
}
?>