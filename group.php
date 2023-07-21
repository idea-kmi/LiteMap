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

array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/searchlib.js.php').'" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/grouplib.js.php').'" type="text/javascript"></script>');

include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

global $USER;
$groupid = required_param("groupid",PARAM_ALPHANUMEXT);
$group = getGroup($groupid);
if($group instanceof Error){
	// Check if Users table has OriginalID field and if so check if this groupid is an old ID and adjust.
	$params = array();
	$resArray = $DB->select($HUB_SQL->AUDIT_USER_CHECK_ORIGINALID_EXISTS, $params);
	if ($resArray !== false) {
		if (count($resArray) > 0) {
			$array = $resArray[0];
			if (isset($array['OriginalID'])) {
				$params = array();
				$params[0] = $groupid;
				$resArray2 = $DB->select($HUB_SQL->AUDIT_USER_SELECT_ORIGINALID, $params);
				if ($resArray2 !== false) {
					if (count($resArray2) > 0) {
						$array2 = $resArray2[0];
						$groupid = $array2['UserID'];
						header("Location: ".$CFG->homeAddress."group.php?groupid=".$groupid);
						die;
					}
				}
			}
		}
	}
 }

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
echo "var URL_ARGS = ".$argsStr.";";
echo "var SOLUTION_ARGS = ".$argsStr.";";
echo "var ISSUE_ARGS = ".$argsStr.";";
echo "var CON_ARGS = ".$argsStr.";";
echo "var PRO_ARGS = ".$argsStr.";";
echo "var CHAT_ARGS = ".$argsStr.";";
echo "var ARGUMENT_ARGS = ".$argsStr.";";
echo "var COMMENT_ARGS = ".$argsStr.";";
echo "var NEWS_ARGS = ".$argsStr.";";
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
			<div id="searchmap" style="clear:both;float:left;">
				<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?></label>
				<?php
					// if search term is present in URL then show in search box
					$q = stripslashes(optional_param("gq","",PARAM_TEXT));
				?>
				<div style="float: left;">
					<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('map-go-button').onclick();}" id="qmap" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
					<div style="clear: both;"></div>
				<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
				</div>
				<div style="float:left;">
					<img id="map-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: refreshGroupSearch();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
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
				</div>
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

<div id="tabber" style="clear:both;float:left; width: 100%;">
	<div style="height:1px;clear:both;float:left;width:100%;margin:0px;background:#E8E8E8"></div>
	<ul id="tabs" class="tab">
		<li class="tab"><a class="tab" id="tab-map" href="<?php echo $CFG->homeAddress; ?>group.php#map"><span class="tab tabissue"><?php echo $LNG->TAB_MAP; ?></span></a></li>
		<li class="tab"><a class="tab" id="tab-search" href="<?php echo $CFG->homeAddress; ?>group.php#search"><span class="tab tabissue"><?php echo $LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS; ?></span></a></li>
	</ul>

    <div id="tabs-content" style="float: left; width: 100%;">
		<div id='tab-content-map-div' class='tabcontent' style="display:none;">
			<div id="tabs-content" style="float: left; width: 100%;">
				<div style="clear:both;float: left; width:100%;">
					<div style="float:left;width: 100%;font-weight:normal;margin-top:0px;font-size:11pt;">
						<div id='tab-content-toolbar-map' style='clear:both; float:left; width: 100%;'>
							<div id='tab-content-map-list' class='tabcontentinner'></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id='tab-content-search-div' class='tabcontent' style="display:none;">
			<div id="context" style="float:left;width: 100%;">
				<div style="float:left; margin-bottom: 15px;">
					<div id="content-controls"></div>
				</div>
				<div id="q_results" name="q_results" style="clear:both;float left;margin-bottom: 15px;">
					<div style="float:left;margin-right: 5px;"><a id="issue-result-menu" href="#issueresult"><?php echo $LNG->ISSUES_NAME; ?>: <span id="issue-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
					<div style="float:left;margin-right: 5px;"><a id="solution-result-menu" href="#solutionresult"><?php echo $LNG->SOLUTIONS_NAME; ?>: <span id="solution-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
					<div style="float:left;margin-right: 5px;"><a id="pro-result-menu" href="#proresult"><?php echo $LNG->PROS_NAME; ?>: <span id="pro-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
					<div style="float:left;margin-right: 5px;"><a id="con-result-menu" href="#conresult"><?php echo $LNG->CONS_NAME; ?>: <span id="con-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
					<div style="float:left;margin-right: 5px;"><a id="arg-result-menu" href="#argresult"><?php echo $LNG->ARGUMENTS_NAME; ?>: <span id="arg-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
					<div style="float:left;margin-right: 5px;"><a id="map-result-menu" href="#mapresult"><?php echo $LNG->MAPS_NAME; ?>: <span id="map-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
					<!-- div style="float:left;margin-right: 5px;margin-bottom: 15px;"><a id="web-result-menu" href="#webresult"><?php echo $LNG->RESOURCES_NAME; ?>: <span id="web-list-count-main"></span></a><span style="margin-left:5px;">|</span></div -->
					<div style="float:left;margin-right: 5px;margin-bottom: 5px;"><a id="chat-result-menu" href="#chatresult"><?php echo $LNG->CHATS_NAME; ?>: <span id="chat-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
					<div style="float:left;margin-right: 5px;margin-bottom: 5px;"><a id="idea-result-menu" href="#idearesult"><?php echo $LNG->COMMENTS_NAME; ?>: <span id="idea-list-count-main"></span></a><span style="margin-left:5px;">|</span></div>
				</div>
				<div id="content-issue-main" class="searchresultblock">
					<a name="issueresult"></a>
					<div class="strapline searchresulttitle"><span id="issue-list-count">0</span> <span id="issue-list-title"><?php echo $LNG->ISSUES_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-issue-list"></div>
				</div>
				<div id="content-solution-main" class="searchresultblock">
					<a name="solutionresult"></a>
					<div class="strapline searchresulttitle"><span id="solution-list-count">0</span> <span id="solution-list-title"><?php echo $LNG->SOLUTIONS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-solution-list"></div>
				</div>
				<div id="content-pro-main" class="searchresultblock">
					<a name="proresult"></a>
					<div class="strapline searchresulttitle"><span id="pro-list-count">0</span> <span id="pro-list-title"><?php echo $LNG->PROS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-pro-list"></div>
				</div>
				<div id="content-con-main" class="searchresultblock">
					<a name="conresult"></a>
					<div class="strapline searchresulttitle"><span id="con-list-count">0</span> <span id="con-list-title"><?php echo $LNG->CONS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-con-list"></div>
				</div>
				<div id="content-arg-main" class="searchresultblock">
					<a name="argresult"></a>
					<div class="strapline searchresulttitle"><span id="arg-list-count">0</span> <span id="arg-list-title"><?php echo $LNG->ARGUMENTS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-arg-list"></div>
				</div>
				<div id="content-map-main" class="searchresultblock">
					<a name="mapresult"></a>
					<div class="strapline searchresulttitle"><span id="map-list-count">0</span> <span id="map-list-title"><?php echo $LNG->MAPS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-map-list"></div>
				</div>
				<!-- div id="content-web-main" class="searchresultblock">
					<a name="webresult"></a>
					<div class="strapline searchresulttitle"><span id="web-list-count">0</span> <span id="web-list-title"><?php echo $LNG->RESOURCES_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-web-list"></div>
				</div -->
				<div id="content-chat-main" class="searchresultblock">
					<a name="chatresult"></a>
					<div class="strapline searchresulttitle"><span id="chat-list-count">0</span> <span id="chat-list-title"><?php echo $LNG->CHATS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-chat-list"></div>
				</div>

				<div id="content-idea-main" class="searchresultblock">
					<a name="idearesult"></a>
					<div class="strapline searchresulttitle"><span id="idea-list-count">0</span> <span id="idea-list-title"><?php echo $LNG->COMMENTS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-idea-list"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
