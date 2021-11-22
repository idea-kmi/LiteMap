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
 * @author Michelle Bachler
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
include_once($HUB_FLM->getCodeDirPath("ui/headerembed.php"));

$nodeid = required_param("id",PARAM_ALPHANUMEXT);
$node = getNode($nodeid);
if($node instanceof Hub_Error){
	echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
	include_once($HUB_FLM->getCodeDirPath("ui/footerembed.php"));
	die;
} else {
	$userid = "";
	if (isset($USER->userid)) {
		$userid = $USER->userid;
	}
	auditView($userid, $nodeid, 'embed');
}

$nodetype = $node->role->name;
if ($nodetype != "Issue") {
	//get the Issue for this node.
	if ($nodetype == "Solution") {
		$connSet = getConnectionsByNode($node->nodeid,0,1,'date','ASC', 'all','','Issue');
		$con = $connSet->connections[0];
		$node = $con->to;
		if($node instanceof Hub_Error){
			echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
			include_once($HUB_FLM->getCodeDirPath("ui/footerembed.php"));
			die;
		} else {
			$nodeid = $node->nodeid;
			$node = getNode($nodeid);
			if($node instanceof Hub_Error){
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
		if($node instanceof Hub_Error){
			echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
			include_once($HUB_FLM->getCodeDirPath("ui/footerembed.php"));
			die;
		} else {
			$nodeid = $node->nodeid;
			$node = getNode($nodeid);
			if($node instanceof Hub_Error){
				echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
				include_once($HUB_FLM->getCodeDirPath("ui/footerembed.php"));
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
	$countgroups = 0;
	if (is_countable($groups)) {
		$countgroups = count($groups);
	}
	if ($countgroups > 0) {
		$groupid = $groups[0]->groupid;
	}
}

$canAdd = false;
if (isset($USER->userid) && isset($groupid) && isGroupMember($groupid,$USER->userid)) {
	$canAdd = true;
} else if (isset($USER->userid) && (!isset($groupid) || $groupid == "")) {
	$canAdd = true;
}

if (isset($groupid) && $groupid != "") {
	$group = getGroup($groupid);
	//getGroup does not return group properties apart from its members
	if($group instanceof Hub_Error){
		echo "<h1>Group not found</h1>";
		include_once("includes/footerembed.php");
		die;
	} else {
		$userset = $group->members;
		$members = $userset->users;
		$memberscount = 0;
		if (is_countable($members)) {
			$memberscount = count($members);
		}
	}
}

$errors = array();

$args = array();

$args["nodeid"] = $nodeid;
$args["selectednodeid"] = '';
$args["groupid"] = $groupid;
$args["nodetype"] = $nodetype;
$args["title"] = $node->name;
$args["backgroundImage"] = $node->getNodeProperty('background');


$media = $node->getNodeProperty('media');
if (isset($media) && $media != "") {
	$args["media"] = $media;
	$mimetype = $node->getNodeProperty('mediatype');
	if (isset($mimetype)) {
		$args["mimetype"] = $mimetype;
	}
} else {
	$youtubeid = $node->getNodeProperty('youtubeid');
	if (isset($youtubeid) && $youtubeid != "") {
		$args["youtubeid"] = $youtubeid;
	} else {
		$vimeoid = $node->getNodeProperty('vimeoid');
		if (isset($vimeoid) && $vimeoid != "") {
			$args["vimeoid"] = $vimeoid;
		}
	}
}

$moviesize = $node->getNodeProperty('moviesize');
if (isset($moviesize)) {
	$size = explode(':', $moviesize);
	$args["moviewidth"] = (int)$size[0];
	$args["movieheight"] = (int)$size[1];
}

$args["start"] = 0;
$args["max"] = -1;
$args["mode"] = '';
$args["orderby"] = 'date';
$args["sort"] = 'DESC';
$args["caneditmap"] = 'false';
if ($canAdd) {
	$args["caneditmap"] = 'true';
}

$CONTEXT = $CFG->NODE_CONTEXT;

$argsStr = "{";
$keys = array_keys($args);
$countkeys = 0;
if (is_countable($keys)) {
	$countkeys = count($keys);
}
for($i=0;$i< $countkeys; $i++){
	$argsStr .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
	if ($i != ($countkeys-1)){
		$argsStr .= ',';
	}
}
$argsStr .= "}";

include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

try {
	$jsonnode = json_encode($node, JSON_INVALID_UTF8_IGNORE);
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "<br>";
}

echo "<script type='text/javascript'>";
echo "var CONTEXT = '".$CONTEXT."';";
echo "var NODE_ARGS = ".$argsStr.";";
echo "var nodeObj = ";
echo $jsonnode;
echo ";";
echo "</script>";
?>

<script type='text/javascript'>

/**
 *	Intial data and mode
 */
Event.observe(window, 'load', function() {

	var	role = nodeObj.role;
	var title = nodeObj.name;
	var description = nodeObj.description;
	$('embedheader').insert(title);
	if (description != "" ) {
		$('embedheader').title = description;
	}

	//var itemobj = renderEmbedMapNode(nodeObj, 'mainnode', nodeObj.role, true, 'active', false, false, false, true, false);
	//$('mainnodediv').insert(itemobj);

	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/embed-map-net.js.php"); ?>', 'embed-map-net-script');
});

</script>

<div id="network-map-div-outer" style="clear:both;float:left;width: 100%;height:100%;font-weight:normal;font-size:11pt;">
	<div id="mainnodediv" style="clear:both;float:left;margin:0px;padding:0px;margin-bottom:0px;margin-top:0px;width:100%"></div>
	<div id="network-map-div" style="min-height:100%;float:left;width:100%"></div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerembed.php"));
?>