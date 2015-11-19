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
include_once("config.php");

$me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
if ($HUB_FLM->hasCustomVersion($me)) {
	$path = $HUB_FLM->getCodeDirPath($me);
	include_once($path);
	die;
}

global $USER;

$ref = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

// default parameters
$start = optional_param("start",0,PARAM_INT);
$max = optional_param("max",20,PARAM_INT);
$orderby = optional_param("orderby","",PARAM_ALPHA);
$sort = optional_param("sort","DESC",PARAM_ALPHA);

$nodeid = required_param("id",PARAM_ALPHANUMEXT);
$focusid = optional_param("focusid","",PARAM_ALPHANUMEXT);
if ($focusid != "") {
	$selectednodeid = $focusid;
} else {
	$selectednodeid = $nodeid;
}

$searchid = optional_param("sid","",PARAM_ALPHANUMEXT);
if ($searchid != "" && isset($USER->userid)) {
	auditSearchResult($searchid, $USER->userid, $nodeid, 'N');
}

$node = getNode($nodeid);
if($node instanceof Error){
	include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
	echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
	die;
} else {
	$userid = "";
	if (isset($USER->userid)) {
		$userid = $USER->userid;
	}
	auditView($userid, $nodeid, 'explore');
}

$nodetype = $node->role->name;
if ($nodetype != "Issue") {
	//get the Issue for this node.
	if ($nodetype == "Solution") {
		$connSet = getConnectionsByNode($node->nodeid,0,1,'date','ASC', 'all','','Issue');
		$con = $connSet->connections[0];
		$node = $con->to;
		if($node instanceof Error){
			include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
			echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
			include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
			die;
		} else {
			$nodeid = $node->nodeid;
			$node = getNode($nodeid);
			if($node instanceof Error){
				include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
				echo "<h1>".$LNG->ISSUE_NAME." ".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
				include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
				die;
			}
		}
	} else if ($nodetype == "Pro" || $nodetype == "Con" || $nodetype == "Comment"){
		$conSetSol = getConnectionsByNode($node->nodeid,0,1,'date','ASC', 'all', '', 'Solution');
		$consol = $conSetSol->connections[0];
		$nodesol = $consol->to;
		$consSet = getConnectionsByNode($nodesol->nodeid,0,1,'date','ASC', 'all', '', 'Issue');
		$con = $consSet->connections[0];
		$node = $con->to;
		if($node instanceof Error){
			include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
			echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
			include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
			die;
		} else {
			$nodeid = $node->nodeid;
			$node = getNode($nodeid);
			if($node instanceof Error){
				include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
				echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
				include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
				die;
			}
		}
	}
}

$groupid = optional_param("groupid", "", PARAM_ALPHANUMEXT);
// try and get the groupid from the node
if ($groupid == "" && isset($node->groups)) {
	$groups = $node->groups;
	// there should only be one group per node.
	if (count($groups) > 0) {
		$groupid = $groups[0]->groupid;
	}
}

if (isset($groupid) && $groupid != "") {
	$group = getGroup($groupid);
	//getGroup does not return group properties apart from its members
	if($group instanceof Error){
		echo "<h1>Group not found</h1>";
		include_once("includes/footer.php");
		die;
	} else {
		$userset = $group->members;
		$members = $userset->users;
		$memberscount = sizeof($members);
	}
}

$errors = array();

if (isset($_POST["joingroup"])) {
	if (isset($USER->userid) && $USER->userid != "" && isset($group)) {
		if ($group->isopenjoining == 'Y') {
			$group->addmember($USER->userid);
			$userset = $group->members;
			$members = $userset->users;
			$memberscount = count($members);
		} else if ($group->isopenjoining == 'N') {
			$reply = $group->joinrequest($USER->userid);
			if (!$reply instanceof error) {
				// loop through group members and send all admins and email about the join request.
				$userset = $group->members;
				$members = $userset->users;
				$count = count($members);
				for($i=0; $i<$count; $i++) {
					$member = $members[$i];
					if ($group->isgroupadmin($member->userid)) {
						$paramArray = array ($group->name,$CFG->homeAddress,$USER->userid,$USER->name,$CFG->homeAddress,$groupid);
						sendMail("groupjoinrequest",$LNG->VALIDATE_GROUP_JOIN_SUBJECT,$member->getEmail(),$paramArray);
					}
				}
				//$userset = $group->members;
				//$memberscount = count($members);
			}
		}
	}
}

$canAdd = false;
if (isset($USER->userid) && isset($groupid) && isGroupMember($groupid,$USER->userid)) {
	$canAdd = true;
} else if (isset($USER->userid) && (!isset($groupid) || $groupid == "")) {
	$canAdd = true;
}

$args = array();

$args["nodeid"] = $nodeid;
$args["selectednodeid"] = $selectednodeid;
$args["groupid"] = $groupid;
$args["nodetype"] = $nodetype;
$args["title"] = $node->name;
$args["backgroundImage"] = $node->getNodeProperty('background');
$args["start"] = $start;
$args["max"] = $max;
$args["mode"] = '';
$wasEmpty = false;
if ($orderby == "") {
	$args["orderby"] = 'date';
	$wasEmpty = true;
} else {
	$args["orderby"] = $orderby;
}
$args["sort"] = $sort;
$args["caneditmap"] = 'false';
if ($canAdd) {
	$args["caneditmap"] = 'true';
}

$CONTEXT = $CFG->NODE_CONTEXT;

// now trigger the js to load data
$argsStr = "{";
$keys = array_keys($args);
for($i=0;$i< sizeof($keys); $i++){
	$argsStr .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
	if ($i != (sizeof($keys)-1)){
		$argsStr .= ',';
	}
}
$argsStr .= "}";

array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/lib/jit-2.0.2/Jit/jit.js" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/visualisations/graphlib.js.php" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/visualisations/positionedmaplib.js.php" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/networklib.js.php" type="text/javascript"></script>');

array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/widget.js.php').'" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/tabbermap.js.php').'" type="text/javascript"></script>');

array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath('widget.css').'" type="text/css" media="screen" />');
array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath('vis.css').'" type="text/css" media="screen" />');
array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/base.css').'" type="text/css" />');
array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/ForceDirected.css').'" type="text/css" />');

//checkLogin();

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

try {
	$jsonnode = json_encode($node);
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "<br>";
}

echo "<script type='text/javascript'>";
echo "var CONTEXT = '".$CONTEXT."';";
echo "var NODE_ARGS = ".$argsStr.";";
echo "var mapObj = ";
echo $jsonnode;
echo ";";
echo "</script>";
?>

<script type='text/javascript'>

/**
 *	Intial data and mode
 */
Event.observe(window, 'load', function() {
	var itemobj = renderMapNode("100%","", mapObj, 'mainnode', mapObj.role, true, 'active', false, false, false, true, false);
	$('mainnodediv').insert(itemobj);
	//$('debatemembersarea').update(getLoading("<?php echo $LNG->LOADING_DEBATE_MEMBERS; ?>"));
});

</script>

<div style="clear:both;border-top:2px solid #E8E8E8;width:100%"></div>

<div style="clear:both;float: left; width:100%;height:100%;">
	<div style="float:left;width: 100%;font-weight:normal;margin-top:0px;font-size:11pt;">
		<div id="parentbar" style="float:left; padding-top:5px; width:100%">
			<?php if (isset($groupid) && $groupid != "") { ?>
				<div style="loat:left;">
				<a href="<?php echo $CFG->homeAddress.'group.php?groupid='.$group->groupid;?>" style="float:left;font-weight:bold;font-size:12pt;"><?php echo $group->name; ?></a>
				</div>
			<?php } ?>
			<div style='float:right;'>
			<?php if (!isset($USER->userid)) {
				if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
					echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registeropen.php">'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'</a> '.$LNG->MAP_ADD_LOGGED_OUT_OPEN;
				} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
					echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">'.$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT.'</a> '.$LNG->MAP_ADD_LOGGED_OUT_REQUEST;
				} else {
					echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> '.$LNG->MAP_ADD_LOGGED_OUT_CLOSED;
				}
			} else if (isGroupPendingMember($groupid,$USER->userid)) { ?>
				<span><?php echo $LNG->GROUP_JOIN_PENDING_MESSAGE; ?><img style="margin-left:7px;" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" onmouseover="showGlobalHint('PendingMember', event, 'hgrhint')" onmouseout="hideHints()" border="0" /></span>
			<?php } else if (isset($USER->userid) && $groupid != "" && !isGroupMember($groupid,$USER->userid)) { ?>
				<div style="float:right;">
					<?php if ($group->isopenjoining == 'Y') {?>
						<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
							<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
							<input class="mainfont active submitleft" style="font-size:11pt; border: none; background: transparent;padding-right:5px;" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP; ?>" id="joingroup" name="joingroup"></input><?php echo $LNG->MAP_GROUP_JOIN_GROUP; ?>
						</form>
					<?php } else if ($group->isopenjoining == 'N' && !isGroupRejectedMember($groupid,$USER->userid) && !isGroupReportedMember($groupid,$USER->userid)) {  ?>
						<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
							<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
							<input class="mainfont active submitleft" style="font-size:11pt; border: none; background: transparent;padding-right:5px;" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP_CLOSED; ?>" id="joingroup" name="joingroup"></input><?php echo $LNG->MAP_GROUP_JOIN_GROUP; ?>
						</form>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>

		<div id="mainnodediv" style="clear:both;float:left;margin:0px;padding:0px;margin-bottom:0px;margin-top:10px;width:100%"></div>

		<div id="pageseparatorbar" class="modeback3 claimborder" style="clear:both;float:left;height:3px; width:100%"></div>


		<div id="tabber" style="clear:both;float:left; width: 100%;">
			<ul id="tabs" class="tab">
				<li class="tab"><a class="tab" id="tab-map" href="#map"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_MAP; ?></span></a></li>
				<li class="tab"><a class="tab" id="tab-vis" href="#vis"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_VIS; ?></span></a></li>
				<li class="tab"><a class="tab" id="tab-analytics" href="#analytics"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_ANALYTICS; ?></span></a></li>
			</ul>
			<div id="tabs-content" style="float: left; width: 100%;">

				<!-- MAP TAB PAGES -->
				<div id='tab-content-map-div' class='tabcontent' style='width: 100%;padding:0px;'>
					<div class="modeback1 plainborder-bottom" style="height:5px;clear:both;float:left;width:100%;margin:0px;"></div>
					<div id='tab-content-map'>
						<div id='tab-content-toolbar-idea' style='clear:both; float:left; width: 100%;'>
							<div id="network-map-div" style="width:100%;height:100%;"></div>
						</div>
					</div>
				</div>

				<!-- VISUALISATION TAB PAGE -->
				<div id='tab-content-vis-div' class='tabcontent' style="padding:0px;display:none;">
					<div class="modeback1 plainborder-bottom" style="height:5px;clear:both;float:left;width:100%;margin:0px;"></div>
					<div id='tab-content-toolbar-vis' style='clear:both; float:left; width: 100%; height: 100%'>
						<div id="tabber" style="width:100%">

							<div id="vistabs">
								<ul id="tabs" class="tab2">
									<li class="tab"><a class="tab" id="tab-vis-sunburst" href="#vis-sunburst"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_SUNBURST2; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-vis-circles" href="#vis-circles"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_CIRCLEPACKING; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-vis-treemap" href="#vis-treemap"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_TREEMAP; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-vis-treemaptd" href="#vis-treemaptd"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_TREEMAPTD; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-vis-network" href="#vis-network"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_NETWORK; ?></span></span></a></li>
								</ul>
							</div>

							<div id="tab-content-vis" class="tabcontentinner" style="width:100%">
								<div id="tab-content-vis-message" style="width:1000px;"></div>
								<div id="tab-content-vis-network-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-vis-network" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
								</div>
           						<div id="tab-content-vis-circles-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-vis-circles" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
								</div>
           						<div id="tab-content-vis-sunburst-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-vis-sunburst" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
           						</div>
           						<div id="tab-content-vis-treemap-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-vis-treemap" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
           						</div>
           						<div id="tab-content-vis-treemaptd-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-vis-treemaptd" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
           						</div>
							</div>
						</div>
					</div>
				</div>

				<!-- ANALYTICS TAB PAGE -->
				<div id='tab-content-analytics-div' class='tabcontent' style="padding:0px;display:none;">
					<div class="modeback1 plainborder-bottom" style="height:5px;clear:both;float:left;width:100%;margin:0px;"></div>
					<div id='tab-content-toolbar-analytics' style='clear:both; float:left; width: 100%; height: 100%'>
						<div id="tabber" style="width:100%">

							<div id="analyticstabs">
								<ul id="tabs" class="tab2">
									<li class="tab"><a class="tab" id="tab-analytics-overview" href="#analytics-overview"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_OVERVIEW; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-analytics-social" href="#analytics-social"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_SOCIAL; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-analytics-ring" href="#analytics-ring"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_RING; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-analytics-activity" href="#analytics-activity"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_ACTIVITY_ANALYSIS; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-analytics-useractivity" href="#analytics-useractivity"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_USER_ACTIVITY_ANALYSIS; ?></span></span></a></li>
									<li class="tab"><a class="tab" id="tab-analytics-stream" href="#analytics-stream"><span class="tab tabuser"><?php echo $LNG->STATS_TAB_STREAMGRAPH; ?></span></span></a></li>
								</ul>
							</div>

							<div id="tab-content-analytics" class="tabcontentinner" style="width:100%">
								<div id="tab-content-analytics-message" style="width:1000px;"></div>
								<div id="tab-content-analytics-overview-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-analytics-overview" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
								</div>
           						<div id="tab-content-analytics-social-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-analytics-social" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
								</div>
           						<div id="tab-content-analytics-ring-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-analytics-ring" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
           						</div>
           						<div id="tab-content-analytics-activity-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-analytics-activity" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
           						</div>
           						<div id="tab-content-analytics-useractivity-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-analytics-useractivity" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
           						</div>
           						<div id="tab-content-analytics-stream-div" class="tabcontentuser" style="display:none">
									<iframe id="tab-content-analytics-stream" width="1000px;" height="1000px;" src="" style="overflow-y:auto;overflow-x:hidden" scrolling="no" frameborder="0"></iframe>
           						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
