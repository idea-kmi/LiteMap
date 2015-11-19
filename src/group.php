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

array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/grouplib.js.php').'" type="text/javascript"></script>');

include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

global $USER;
$groupid = required_param("groupid",PARAM_ALPHANUMEXT);
$group = getGroup($groupid);

if($group instanceof Error){
	include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
	echo "<h1>".$LNG->ERROR_GROUP_NOT_FOUND_MESSAGE." : ".$groupid."</h1>";
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
	die;
} else {
	$userid = "";
	if (isset($USER->userid)) {
		$userid = $USER->userid;
	}
	auditGroupView($userid, $groupid, 'group');
}

$ref = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

// default parameters
$start = optional_param("start",0,PARAM_INT);
$max = optional_param("max",20,PARAM_INT);
$orderby = optional_param("orderby","",PARAM_ALPHA);
$sort = optional_param("sort","DESC",PARAM_ALPHA);

$userset = $group->members;
$members = $userset->users;
$memberscount = count($members);

$isCurrentUserGroupAdmin = false;
if (isset($USER->userid) && $USER->userid != "") {
	$isCurrentUserGroupAdmin = $group->isgroupadmin($USER->userid);
}

$context = $CFG->GROUP_CONTEXT;

if (isset($_POST["joingroup"]) && isset($_SERVER['REQUEST_URI'])) {
	if (isset($USER->userid) && $USER->userid != "" && isset($group)) {
		if ($group->isopenjoining == 'Y') {
			$group = $group->addmember($USER->userid);
			$userset = $group->members;
			$members = $userset->users;
			$memberscount = count($members);
			header ('Location: ' . $_SERVER['REQUEST_URI']);
			exit();
		} else if ($group->isopenjoining == 'N') {
			$reply = $group->joinrequest($USER->userid);
			if (!$reply instanceof error) {
				// loop through group members and send all admins and email about the join request.
				$count = count($members);
				for($i=0; $i<$count; $i++) {
					$member = $members[$i];
					if ($group->isgroupadmin($member->userid)) {
						$paramArray = array ($group->name,$CFG->homeAddress,$USER->userid,$USER->name,$CFG->homeAddress,$groupid);
						sendMail("groupjoinrequest",$LNG->VALIDATE_GROUP_JOIN_SUBJECT,$member->getEmail(),$paramArray);
					}
				}
			}
		}
	}
}

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

$args = array();
$args["groupid"] = $groupid;
$args["isgroupadmin"] = ($isCurrentUserGroupAdmin ? 'true' : 'false');
$args["start"] = $start;
$args["max"] = $max;
$wasEmpty = false;
if ($orderby == "") {
	$args["orderby"] = 'date';
	$wasEmpty = true;
} else {
	$args["orderby"] = $orderby;
}
$args["sort"] = $sort;
$args["title"] = $group->name;

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

echo "<script type='text/javascript'>";

echo "var CONTEXT = '".$context."';";
echo "var NODE_ARGS = ".$argsStr.";";
echo "var MAP_ARGS = ".$argsStr.";";

try {
	$jsonnode = json_encode($group);
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "<br>";
}

echo "var groupObj = ";
echo $jsonnode;
echo ";";

echo "</script>";
?>

<div style="clear:both;border-top:2px solid #E8E8E8;"></div>

<div style="clear:both;float: left; width:100%;">
	<!-- LEFT COLUMN -->
	<div style="width 100%;margin-right: 210px;">
		<div style="float:left;width: 100%;font-weight:normal;margin-top:0px;font-size:11pt;">
			<div id="maingroupdiv" style="clear:both;width:100%;float:left;padding:0px;padding-bottom:20px;padding-top:10px;"></div>
			<div id="addnewmaparea" style="clear:both; float:left;margin-bottom:10px;">
				<div style="float:left;width:100%;margin-top:15px;margin-bottom:5px;font-size:12pt">

					<?php if (isset($USER->userid) && isGroupMember($groupid,$USER->userid)) { ?>
						<span class="active" onclick="loadDialog('createmap','<?php print($CFG->homeAddress);?>ui/popups/mapadd.php?groupid=<?php echo $groupid; ?>', 750, 500);"><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="vertical-align:bottom;padding-right:3px;" /><?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?></span><br>
					<?php } else {
					 if (!isset($USER->userid)) {
							if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
								echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registeropen.php">'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_OPEN;
							} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
								echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">'.$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_REQUEST;
							} else {
								echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_CLOSED;
							}
						} else if (isset($USER->userid) && isGroupPendingMember($groupid,$USER->userid)) { ?>
							<span><?php echo $LNG->GROUP_JOIN_PENDING_MESSAGE; ?><img style="margin-left:7px;" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" onmouseover="showGlobalHint('PendingMember', event, 'hgrhint')" onmouseout="hideHints()" border="0" /></span>
						<?php } else if ($group->isopenjoining == 'Y') {?>
							<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
								<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
								<input class="submitleft" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP; ?>" id="joingroup" name="joingroup">
							</form>
						<?php } else if ($group->isopenjoining == 'N' && !isGroupMember($groupid,$USER->userid) && !isGroupRejectedMember($groupid,$USER->userid) && !isGroupReportedMember($groupid,$USER->userid)) {  ?>
							<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
								<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
								<input class="mainfont active submitleft" style="white-space: normal;font-size:12pt; border: none; background: transparent" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP_CLOSED; ?>" id="joingroup" name="joingroup"><?php echo $LNG->GROUP_JOIN_GROUP; ?></input>
							</form>
						<?php }
					} ?>
				</div>
			</div>
		</div>
	</div>
	<!-- RIGHT COLUMN -->
	<div style="float: right; height:100%;width:195px; margin-left: -210px; padding: 5px;">
		<div style="float:left;height:100%;">
			<fieldset class="plainborder" style="clear:both;margin-bottom:35px;margin-top:5px;">
			<legend><h2><?php echo $LNG->GROUP_MEMBERS_LABEL; ?></h2></legend>
				<div style="clear:both;float:left;width:100%;margin:0px;padding:0px;height:100px;overflow-y:auto">
				<?php
					foreach($members as $u){
						echo "<a href='user.php?userid=".$u->userid."' title='".$u->name."'><img style='padding:5px;' border='0' src='".$u->thumb."'/></a>";
					}
				?>
				<div>
			<div style="float:left;width:100%;margin:0px;padding:px;margin-top:5px;margin-bottom:10px;">
				<?php if (isset($USER->userid) && isGroupPendingMember($groupid,$USER->userid)) { ?>
					<span><?php echo $LNG->GROUP_JOIN_PENDING_MESSAGE; ?><img style="margin-left:7px;" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" onmouseover="showGlobalHint('PendingMember', event, 'hgrhint')" onmouseout="hideHints()" border="0" /></span>
				<?php } else if (isset($USER->userid) && !isGroupMember($groupid,$USER->userid)) {
					if ($group->isopenjoining == 'Y') { ?>
						<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
							<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
							<input class="submitleft" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP; ?>" id="joingroup" name="joingroup">
						</form>
					<?php } else if ($group->isopenjoining == 'N' && !isGroupRejectedMember($groupid,$USER->userid) && !isGroupReportedMember($groupid,$USER->userid)) {  ?>
						<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
							<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
							<input class="submitleft" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP_CLOSED; ?>" id="joingroup" name="joingroup">
						</form>
					<?php } ?>
				<?php } ?>
			</div>
			</fieldset>

			<fieldset class="plainborder">
				<div id="radiobuttonsum" class="groupbutton modeback3 modeborder3">
					<div class="groupbuttoninner"><a style="color:white" href="<?php echo $CFG->homeAddress; ?>ui/stats/groups/index.php?groupid=<?php echo $groupid; ?>"><?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?></a></div>
				</div>
				<!-- div id="radiobuttonshare" class="groupbutton modeback2 modeborder2" onclick="alert('This button will eventually allow you to share content off site.');">
					<div class="groupbuttoninner"><?php echo $LNG->PAGE_BUTTON_SHARE; ?></div>
				</div -->
			</fieldset>
		</div>
	</div>
</div>
<div style="clear:both;float: left; width:100%;">
	<div style="float:left;width: 100%;font-weight:normal;margin-top:0px;font-size:11pt;">
		<div id='tab-content-toolbar-map' style='clear:both; float:left; width: 100%;'>
			<div id='tab-content-map-list' class='tabcontentinner'></div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
