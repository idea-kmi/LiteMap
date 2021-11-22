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
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

include_once($HUB_FLM->getCodeDirPath("core/formats/json.php"));

include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

global $CFG;

$groupid = required_param("groupid",PARAM_ALPHANUMEXT);

$userHashtable = array();

$userCheck = array();
$usersToDebates = array();
$nodeCheck = array();
$totalnodes = 0;

$mapNodes = getNodesByGroup($groupid,0,-1,'date','DESC', '', 'Map', 'mini');
$nodes = $mapNodes->nodes;
$count = 0;
if (is_countable($nodes)) {
	$count = count($nodes);
}
for ($i=0; $i<$count; $i++) {
	$node = $nodes[$i];

	if (!array_key_exists($node->nodeid, $nodeCheck)) {
		$nodeCheck[$node->nodeid] = $node;
	}
	if (!array_key_exists($node->users[0]->userid, $userHashtable)) {
		$globaluser = clone $node->users[0];
		$globaluser->procount = 0;
		$globaluser->concount = 0;
		$globaluser->ideacount = 0;
		$globaluser->debatecount = 0;
		$globaluser->mapcount = 1;
		$userHashtable[$node->users[0]->userid] = $globaluser;
	} else {
		$globaluser = $userHashtable[$node->users[0]->userid];
		$globaluser->debatecount = $globaluser->debatecount+1;
		$userHashtable[$node->users[0]->userid] = $globaluser;
	}

	$view = getView($node->nodeid);
	$cons = $view->connections;
	$countcons = 0;
	if (is_countable($cons)) {
		$countcons = count($cons);
	}

	$localusers = array();

	$debateowner = clone $node->users[0];
	$debateowner->procount = 0;
	$debateowner->concount = 0;
	$debateowner->ideacount = 0;
	$debateowner->debatecount = 0;
	$debateowner->mapcount = 1;
	$localusers[$node->users[0]->userid] = $debateowner;

	if (!array_key_exists($node->users[0]->userid, $userCheck)) {
		$userCheck[$node->users[0]->userid] = $node->users[0];
	}

	for ($j=0; $j<$countcons; $j++) {
		$viewcon = $cons[$j];
		$con = $viewcon->connection;
		if (!$con instanceof Hub_Error) {
			$fromNode = $con->from;
			if (!$fromNode instanceof Hub_Error) {
				if (!array_key_exists($fromNode->nodeid, $nodeCheck)) {
					$nodeCheck[$fromNode->nodeid] = $fromNode;
				}

				//$toNode = $con->to;
				$thisuser = clone $fromNode->users[0];

				if (!array_key_exists($thisuser->userid, $userCheck)) {
					$userCheck[$thisuser->userid] = $thisuser;

				}

				if (!array_key_exists($thisuser->userid, $userHashtable)) {
					$globaluser = clone $fromNode->users[0];
					$globaluser->procount = 0;
					$globaluser->concount = 0;
					$globaluser->ideacount = 0;
					$globaluser->debatecount = 0;
					if ($fromNode->role->name == 'Pro') $globaluser->procount = 1;
					if ($fromNode->role->name == 'Con') $globaluser->concount = 1;
					if ($fromNode->role->name == 'Solution') $globaluser->ideacount = 1;
					if ($fromNode->role->name == 'Issue') $globaluser->debatecount = 1;
					$userHashtable[$thisuser->userid] = $globaluser;
				} else {
					$globaluser = $userHashtable[$thisuser->userid];
					if ($fromNode->role->name == 'Pro') $globaluser->procount = $globaluser->procount+1;
					if ($fromNode->role->name == 'Con') $globaluser->concount = $globaluser->concount+1;
					if ($fromNode->role->name == 'Solution') $globaluser->ideacount = $globaluser->ideacount+1;
					if ($fromNode->role->name == 'Issue') $globaluser->debatecount = $globaluser->debatecount+1;
					$userHashtable[$thisuser->userid] = $globaluser;
				}

				if (!array_key_exists($thisuser->userid, $localusers)) {
					$thisuser->procount = 0;
					$thisuser->concount = 0;
					$thisuser->ideacount = 0;
					$thisuser->debatecount = 0;
					if ($fromNode->role->name == 'Pro') $thisuser->procount = 1;
					if ($fromNode->role->name == 'Con') $thisuser->concount = 1;
					if ($fromNode->role->name == 'Solution') $thisuser->ideacount = 1;
					if ($fromNode->role->name == 'Issue') $thisuser->debatecount = 1;
					$localusers[$thisuser->userid] = $thisuser;
				} else {
					$thisuser = $localusers[$thisuser->userid];
					if ($fromNode->role->name == 'Pro') $thisuser->procount = $thisuser->procount+1;
					if ($fromNode->role->name == 'Con') $thisuser->concount = $thisuser->concount+1;
					if ($fromNode->role->name == 'Solution') $thisuser->ideacount = $thisuser->ideacount+1;
					if ($fromNode->role->name == 'Issue') $thisuser->debatecount = $thisuser->debatecount+1;

					$localusers[$thisuser->userid] = $thisuser;
				}
			}
		}
	}

	$usersToDebates[$node->nodeid] = $localusers;
}

$conSet = new ConnectionSet();
$count = 0;
if (is_countable($usersToDebates)) {
	$count = count($usersToDebates);
}
foreach ($usersToDebates as $nodeid => $users) {
	foreach ($users as $userid => $user) {
		$to = $user;
		$connection = new Connection();

		$procount = $user->procount;
		$concount = $user->concount;
		$ideacount = $user->ideacount;
		$debatecount = $user->debatecount;

		$totalnodes = $totalnodes+($ideacount+$debatecount+$procount+$concount);

		$connection->procount = $procount;
		$connection->concount = $concount;
		$connection->ideacount = $ideacount;
		$connection->debatecount = $debatecount;
		$connection->toid = $userid;
		$connection->fromid = $nodeid;

		$graycount = $ideacount+$debatecount;

		if ($procount > $concount && $procount > $graycount) {
			$connection->linklabelname = $CFG->LINK_PRO_SOLUTION;
		} else if ($concount > $procount && $concount > $graycount) {
			$connection->linklabelname = $CFG->LINK_CON_SOLUTION;
 		} else if ($procount == $graycount && $procount > $concount) {
			$connection->linklabelname = $CFG->LINK_PRO_SOLUTION;
		} else if ($concount == $graycount && $concount > $procount) {
			$connection->linklabelname = $CFG->LINK_CON_SOLUTION;
		} else {
			$connection->linklabelname = $CFG->LINK_SOLUTION_ISSUE;
		}

		$conSet->add($connection);
	}
}

$format_json = new format_json();

$userset = new UserSet();
foreach ($userHashtable as $userid => $user) {
	$userset->add($user);
}

$conSet->totalnodes = $totalnodes;

$jsonnodes = $format_json->format($mapNodes);
$jsonusers = $format_json->format($userset);
$jsoncons = $format_json->format($conSet);
?>
<script type='text/javascript'>
var NODE_ARGS = new Array();

Event.observe(window, 'load', function() {

	NODE_ARGS['groupid'] = '<?php echo $groupid; ?>';
	NODE_ARGS['jsonnodes'] = JSON.parse('<?php echo addslashes($jsonnodes); ?>');
	NODE_ARGS['jsonusers'] = JSON.parse('<?php echo addslashes($jsonusers); ?>');
	NODE_ARGS['jsoncons'] = JSON.parse('<?php echo addslashes($jsoncons); ?>');

	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-sunburst.js.php"); ?>', 'group-stats-sunburst-script');
});
</script>

<div class="vishelpdiv">
	<h1 class="vishelpheading"><?php echo $dashboarddata[$pageindex][0]; ?>
		<span><img class="vishelparrow" title="<?php echo $LNG->STATS_DASHBOARD_HELP_HINT; ?>" onclick="if($('vishelp').style.display == 'none') { this.src='<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>'; $('vishelp').style.display='block'; } else {this.src='<?php echo $HUB_FLM->getImagePath('rightarrowbig.gif'); ?>'; $('vishelp').style.display='none'; }" src="<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>"/></span>
	</h1>
	<div class="boxshadowsquare" id="vishelp" class="vishelpmessage"><?php echo $dashboarddata[$pageindex][5]; ?></div>

	<div id="sunburst-div" class="vismaindiv"></div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>