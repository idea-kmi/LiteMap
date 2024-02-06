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
	if($group instanceof Hub_Error){
		// Check if Users table has OriginalID field and if so check if this groupid is an old ID and adjust.
		$params = array();
		$resArray = $DB->select($HUB_SQL->AUDIT_USER_CHECK_ORIGINALID_EXISTS, $params);
		if ($resArray !== false) {

			$rescount = 0;
			if (is_countable($resArray)) {
				$rescount = count($resArray);
			}

			if ($rescount > 0) {
				$array = $resArray[0];
				if (isset($array['OriginalID'])) {
					$params = array();
					$params[0] = $groupid;
					$resArray2 = $DB->select($HUB_SQL->AUDIT_USER_SELECT_ORIGINALID, $params);
					if ($resArray2 !== false) {
						$rescount2 = 0;
						if (is_countable($resArray2)) {
							$rescount2 = count($resArray2);
						}
						if ($rescount2 > 0) {
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

	if($group instanceof Hub_Error){
		include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
		echo "<h1>".$LNG->ERROR_GROUP_NOT_FOUND_MESSAGE." : ".$groupid."</h1>";
		include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
		die;
	} else {
		// reported groups are still visible - in case maliciously reported. Which would take out too much content
		// even admins can't see archived groups - have to look at the content through the reported groups admin screen
		if (($group->status != $CFG->USER_STATUS_ACTIVE && $group->status != $CFG->USER_STATUS_REPORTED) 
					&& (!isset($USER->userid) || $USER->getIsAdmin() == "N" || $group->status == $CFG->STATUS_ARCHIVED)) {
			include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));
			echo "<div class='errors'>".$LNG->ITEM_NOT_AVAILABLE_ERROR."</div>";
			include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
			die;
		} 

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

	$members = array();
	$userset = $group->members;
	if (!$userset instanceof Hub_Error && isset($userset)) {
		$members = $userset->users;
	}

	$memberscount = 0;
	if (is_countable($members)) {
		$memberscount = count($members);
	}

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

				$memberscount = 0;
				if (is_countable($members)) {
					$memberscount = count($members);
				}
				header ('Location: ' . $_SERVER['REQUEST_URI']);
				exit();
			} else if ($group->isopenjoining == 'N') {
				$reply = $group->joinrequest($USER->userid);
				if (!$reply instanceof error) {
					// loop through group members and send all admins and email about the join request.

					$count = 0;
					if (is_countable($members)) {
						$count = count($members);
					}

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
	$keycount = 0;
	if (is_countable($keys)) {
		$keycount = count($keys);
	}
	for($i=0;$i< $keycount; $i++){
		$argsStr .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
		if ($i != ($keycount-1)){
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
		$jsonnode = json_encode($group, JSON_INVALID_UTF8_IGNORE);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "";
	}

	echo "var groupObj = ";
	echo $jsonnode;
	echo ";";

	echo "</script>";
?>

<div class="container-fluid">
	<div class="row">
		<!-- LEFT COLUMN -->
		<div id="maingroupdiv" class="col-md-12 col-lg-9"></div>

		<!-- RIGHT COLUMN -->
		<div class="col-md-12 col-lg-3">
			<fieldset class="border border-2 mx-2 my-4 p-3">
				<legend><h3><?php echo $LNG->GROUP_MEMBERS_LABEL; ?></h3></legend>
				<div class="d-flex flex-row flex-wrap">
					<?php foreach($members as $u){ ?>						
						<a class="m-1" href='user.php?userid=<?php echo $u->userid; ?>' title='<?php echo $u->name; ?>'>
							<img src='<?php echo $u->thumb; ?>' alt='<?php echo $u->name; ?> profile picture' class="img-fluid" />
						</a>
					<?php } ?>
				</div>
				<?php if (isset($USER->userid) && isGroupPendingMember($groupid,$USER->userid)) { ?>
					<div>
						<span><?php echo $LNG->GROUP_JOIN_PENDING_MESSAGE; ?></span>
						<span class="link-active" onMouseOver="showGlobalHint('PendingMember', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
					</div>
				<?php } else if (isset($USER->userid) && !isGroupMember($groupid,$USER->userid)) {
					if ($group->isopenjoining == 'Y') { ?>
						<div>
							<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post" class="d-grid gap-2">
								<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>" />
								<input class="btn btn-primary mt-2" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP; ?>" id="joingroup" name="joingroup" />
							</form>
						</div>
					<?php } else if ($group->isopenjoining == 'N' && !isGroupRejectedMember($groupid,$USER->userid) && !isGroupReportedMember($groupid,$USER->userid)) {  ?>
						<div>
							<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post" class="d-grid gap-2">
								<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>" />
								<input class="btn btn-primary mt-2" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP_CLOSED; ?>" id="joingroup" name="joingroup" />
							</form>
						</div>
					<?php } ?>
				<?php } ?>
			</fieldset>

			<?php if (($CFG->GROUP_DASHBOARD_VIEW == 'public') || (isset($USER->userid) && ($CFG->GROUP_DASHBOARD_VIEW == 'private')) ) { ?>
				<div id="radiobuttonsum" class="d-grid gap-2 m-2">
					<a class="btn btn-secondary text-dark fw-bold" href="<?php echo $CFG->homeAddress; ?>ui/stats/groups/index.php?groupid=<?php echo $groupid; ?>"><?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?></a>
				</div>
			<?php } ?>

		</div>
	</div>
					
	<div class="row px-3" id="addnewmaparea">
		<div class="col">
			<?php if (isset($USER->userid) && isGroupMember($groupid,$USER->userid)) { ?>
				<span class="link-active" onclick="javascript:loadDialog('createmap','<?php print($CFG->homeAddress);?>ui/popups/mapadd.php?groupid=<?php echo $groupid; ?>', 780, 600);"><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="<?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?> button" class="me-2" /><?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?></span>
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
					<div>
						<span><?php echo $LNG->GROUP_JOIN_PENDING_MESSAGE; ?></span>
						<span class="link-active" onMouseOver="showGlobalHint('PendingMember', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</span>
					</div>
				<?php } else if ($group->isopenjoining == 'Y') {?>
					<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
						<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP; ?>" id="joingroup" name="joingroup">
					</form>
				<?php } else if ($group->isopenjoining == 'N' && !isGroupMember($groupid,$USER->userid) && !isGroupRejectedMember($groupid,$USER->userid) && !isGroupReportedMember($groupid,$USER->userid)) {  ?>
					<form id="joingroupform" name="joingroupform" action="" enctype="multipart/form-data" method="post">
						<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid; ?>">
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_JOIN_GROUP_CLOSED; ?>" id="joingroup" name="joingroup"><?php echo $LNG->GROUP_JOIN_GROUP; ?></input>
					</form>
				<?php }
			} ?>
		</div>
	</div>

	<div id="searchmap" class="col-12 toolbarIcons">
		<div class="row">
			<div class="col-lg-4 col-md-12">
				<?php
					// if search term is present in URL then show in search box
					$q = stripslashes(optional_param("q","",PARAM_TEXT));
				?>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('map-go-button').onclick();}" id="qmap" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
					<div id="q_choices" class="autocomplete"></div>
					<button class="btn btn-outline-dark bg-light text-dark" type="button" onclick="refreshGroupSearch();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
				</div>
			</div>
		</div>
	</div>
	
	<div id="tabber" class="tabber-group p-3" role="navigation">
		<ul class="nav nav-tabs" id="tabs" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="tab-map" href="<?php echo $CFG->homeAddress; ?>group.php#map" data-bs-toggle="tab">
					<span class="tab tabissue"><?php echo $LNG->TAB_MAP; ?></span>
				</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="tab-search" href="<?php echo $CFG->homeAddress; ?>group.php#search" data-bs-toggle="tab">
					<span class="tab tabissue"><?php echo $LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS; ?></span>
				</a>
			</li>
		</ul>

        <div id="tabs-content" class="tab-content p-3">
			
			<!-- Maps Tab -->
            <div id='tab-content-map-div' class='tab-pane fade show active'>
				<div id="tabs-content">
					<div id='tab-content-toolbar-map'>
						<div id='tab-content-map-list' class='mapGroups tabcontentinner'></div>
					</div>
				</div>
			</div>

			<!-- Search results tab -->
            <div id='tab-content-search-div' class='tab-pane fade show active'>
			<!-- <div id='tab-content-search-div' class='tabcontent' style="display:none;"> -->
				<div id="context">
					<div class="d-block">
						<div id="content-controls"></div>
					</div>

					<div id="q_results" name="q_results" class="d-flex gap-3">
						<div><a id="issue-result-menu" href="#issueresult"><?php echo $LNG->ISSUES_NAME; ?>: <span id="issue-list-count-main"></span></a></div>
						<span >|</span>
						<div><a id="solution-result-menu" href="#solutionresult"><?php echo $LNG->SOLUTIONS_NAME; ?>: <span id="solution-list-count-main"></span></a></div>
						<span >|</span>
						<div><a id="pro-result-menu" href="#proresult"><?php echo $LNG->PROS_NAME; ?>: <span id="pro-list-count-main"></span></a></div>
						<span >|</span>
						<div><a id="con-result-menu" href="#conresult"><?php echo $LNG->CONS_NAME; ?>: <span id="con-list-count-main"></span></a></div>
						<span >|</span>
						<div><a id="arg-result-menu" href="#argresult"><?php echo $LNG->ARGUMENTS_NAME; ?>: <span id="arg-list-count-main"></span></a></div>
						<span >|</span>
						<div><a id="map-result-menu" href="#mapresult"><?php echo $LNG->MAPS_NAME; ?>: <span id="map-list-count-main"></span></a></div>
						<span >|</span>
						<div><a id="chat-result-menu" href="#chatresult"><?php echo $LNG->CHATS_NAME; ?>: <span id="chat-list-count-main"></span></a></div>
						<span >|</span>
						<div><a id="idea-result-menu" href="#idearesult"><?php echo $LNG->COMMENTS_NAME; ?>: <span id="idea-list-count-main"></span></a></div>
					</div>

					<div id="content-issue-main" class="searchresultblock">
						<a name="issueresult"></a>
						<div class="strapline searchresulttitle"><span id="issue-list-count">0</span> <span id="issue-list-title"><?php echo $LNG->ISSUES_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-issue-list"></div>
					</div>
					<div id="content-solution-main" class="searchresultblock">
						<a name="solutionresult"></a>
						<div class="strapline searchresulttitle"><span id="solution-list-count">0</span> <span id="solution-list-title"><?php echo $LNG->SOLUTIONS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-solution-list"></div>
					</div>
					<div id="content-pro-main" class="searchresultblock">
						<a name="proresult"></a>
						<div class="strapline searchresulttitle"><span id="pro-list-count">0</span> <span id="pro-list-title"><?php echo $LNG->PROS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-pro-list"></div>
					</div>
					<div id="content-con-main" class="searchresultblock">
						<a name="conresult"></a>
						<div class="strapline searchresulttitle"><span id="con-list-count">0</span> <span id="con-list-title"><?php echo $LNG->CONS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-con-list"></div>
					</div>
					<div id="content-arg-main" class="searchresultblock">
						<a name="argresult"></a>
						<div class="strapline searchresulttitle"><span id="arg-list-count">0</span> <span id="arg-list-title"><?php echo $LNG->ARGUMENTS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-arg-list"></div>
					</div>
					<div id="content-map-main" class="searchresultblock">
						<a name="mapresult"></a>
						<div class="strapline searchresulttitle"><span id="map-list-count">0</span> <span id="map-list-title"><?php echo $LNG->MAPS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-map-list"></div>
					</div>
					<div id="content-chat-main" class="searchresultblock">
						<a name="chatresult"></a>
						<div class="strapline searchresulttitle"><span id="chat-list-count">0</span> <span id="chat-list-title"><?php echo $LNG->CHATS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-chat-list"></div>
					</div>
					<div id="content-idea-main" class="searchresultblock">
						<a name="idearesult"></a>
						<div class="strapline searchresulttitle"><span id="idea-list-count">0</span> <span id="idea-list-title"><?php echo $LNG->COMMENTS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
						<div class="searchresultcontent" id="content-idea-list"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
