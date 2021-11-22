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

global $HUB_FLM;

$ref = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

?>

<script type='text/javascript'>

var rightTimers = {};
var leftTimers = {};
var timerStep = 3;
var timerDuration = 16;

function scrollDivLeft(divname, leftbuttonname, rightbuttonname, barname) {
	timerLeft = setInterval(function() {
	  	if ($(divname).scrollLeft == 0) {
	  		$(leftbuttonname).src = "<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>";
			stopScrollLeft(divname);
	  	} else {
			$(divname).scrollLeft -= timerStep;
			if ($(divname).scrollLeft < ($(barname).offsetWidth-$(divname).offsetWidth)) {
				$(rightbuttonname).src = "<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>";
			}
		}
	},
	timerDuration);
	leftTimers[divname] = timerLeft;
}

function scrollDivRight(divname, leftbuttonname, rightbuttonname, barname) {
	timerRight = setInterval(function() {
		if ($(divname).scrollLeft >= ($(barname).offsetWidth-$(divname).offsetWidth)) {
			$(rightbuttonname).src = "<?php echo $HUB_FLM->getImagePath('forward-arrow-grey.png'); ?>";
			stopScrollRight(divname);
		} else {
			$(divname).scrollLeft += timerStep;
			if ($(divname).scrollLeft > 0) {
				$(leftbuttonname).src = "<?php echo $HUB_FLM->getImagePath('back-arrow.png'); ?>";
			}
		}
	}, timerDuration);
	rightTimers[divname] = timerRight;
}

function stopScrollLeft(divname) {
	var timerLeft = leftTimers[divname];
	if (timerLeft) {
		clearInterval(timerLeft);
	}
}

function stopScrollRight(divname) {
	var timerRight = rightTimers[divname];
	if (timerRight) {
		clearInterval(timerRight);
	}
}

Event.observe(window, 'load', function() {
	if (USER && USER != "") {
		loadmygroups();
		loadmymaps();
	} else {
		loadrecentgroups();
		loadrecentmaps();
	}
});

/**
 *	load my groups
 */
function loadmygroups(){

	var container = $('mygroupsBar');
	container.update(getLoading("<?php echo $LNG->LOADING_GROUPS; ?>"));
	var reqUrl = SERVICE_ROOT + "&method=getmygroups&start=0&max=-1&orderby=date&sort=DESC";

	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
				loadrecentgroups();
				return;
			}
			if(json.error){
				console.log(json.error[0].message);
				loadrecentgroups();
				return;
			}

			container.update("");
			if(json.groupset[0].groups.length > 0){
				var mainwidth = getWindowWidth();
				$("mygroupsBarDiv").style.width = (mainwidth-155)+"px";
				$("mygroupsBarDiv").style.maxWidth = (mainwidth-155)+"px";
				container.style.width = (json.groupset[0].groups.length*450)+'px';
				displayGroups(container,json.groupset[0].groups,0, 428,200, false, true);
				$('tab-content-home-recent-mygroup-div').style.display = 'block';
			} else {
				loadrecentgroups();
			}
		}
	});
}

/**
 *	load my maps
 */
function loadmymaps(){
	var container = $('mymapsBar');
	container.update(getLoading("<?php echo $LNG->LOADING_MAPS; ?>"));
	var reqUrl = SERVICE_ROOT + "&method=getnodesbyuser&start=0&max=-1&orderby=date&sort=DESC&filternodetypes=Map&userid="+USER;

	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
				loadrecentmaps();
				return;
			}
			if(json.error){
				console.log(json.error[0].message);
				loadrecentmaps();
				return;
			}

			//display nodes
			container.update("");
			if(json.nodeset[0].nodes.length > 0){
				var mainwidth = getWindowWidth();
				$("mymapsBarDiv").style.width = (mainwidth-155)+"px";
				$("mymapsBarDiv").style.maxWidth = (mainwidth-155)+"px";
				container.style.width = (json.nodeset[0].nodes.length*450)+'px';
				displayMapNodes(428, 200, container,json.nodeset[0].nodes,0, false,'recentmaps','inactive', false, false, true);
				$('tab-content-home-recent-mydebate-div').style.display = 'block';
			} else {
				loadrecentmaps();
			}
		}
	});
}

/**
 *	load latest groups
 */
function loadrecentgroups(){

	var container = $('groupsBar');
	container.update(getLoading("<?php echo $LNG->LOADING_GROUPS; ?>"));
	var reqUrl = SERVICE_ROOT + "&method=getgroupsbyglobal&start=0&max=4&orderby=members&sort=DESC";
	$('tab-content-home-recent-group-div').style.display = 'block';

	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			container.update("");
			if(json.groupset[0].groups.length > 0){
				var mainwidth = getWindowWidth();
				$("groupsBarDiv").style.width = (mainwidth-155)+"px";
				$("groupsBarDiv").style.maxWidth = (mainwidth-155)+"px";
				container.style.width = (json.groupset[0].groups.length*450)+'px';
				displayHomeGroups(container,json.groupset[0].groups,0, 428,140);
			}
		}
	});
}


/**
 *	load latest maps
 */
function loadrecentmaps(){

	/*
	var container = $('mapsBar');
	container.update(getLoading("<?php echo $LNG->LOADING_MAPS; ?>"));
	var reqUrl = SERVICE_ROOT + "&method=getnodesbyglobal&start=0&max=4&orderby=date&sort=DESC&filternodetypes=Map";
	$('tab-content-home-recent-debate-div').style.display = 'block';

	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			//display nodes
			container.update("");
			if(json.nodeset[0].nodes.length > 0){
				var mainwidth = getWindowWidth();
				$("mapsBarDiv").style.width = (mainwidth-155)+"px";
				$("mapsBarDiv").style.maxWidth = (mainwidth-155)+"px";
				container.style.width = (json.nodeset[0].nodes.length*450)+'px';
				displayMapNodes(428, 200, container,json.nodeset[0].nodes,0, false,'recentmaps','inactive', false, false, true);
			}
		}
	});
	*/
}
</script>

<div style="float:left;height:100%; width:100%;">
	<div style="float:left;width: 99%;font-weight:normal;margin-top:0px;font-size:11pt;">
		<div style="float:left;">
			<div style="float:left;">
				<!-- h1><?php echo $LNG->HOMEPAGE_TITLE; ?></h1 -->
				<p><?php echo $LNG->HOMEPAGE_FIRST_PARA; ?><br>
				<span id="homeintrobutton" class="active" style="font-weight:normal;text-decoration:underline" onclick="if ($('homeintromore').style.display == 'none') { $('homeintromore').style.display = 'block'; $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_READ_LESS; ?>'; } else { $('homeintromore').style.display = 'none';  $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_KEEP_READING; ?>';}"><?php echo $LNG->HOMEPAGE_KEEP_READING; ?></span>
				</p>

				<div id="homeintromore" style="float:left;clear:both;width:100%;display:none;margin:0px;padding:0px">
					<?php echo $LNG->HOMEPAGE_SECOND_PARA_PART2; ?>
				</div>
			</div>
		</div>

		<div style="width:100%;clear:both;float:left;margin-bottom:5px;">
			<!-- div id="radiobuttonsum" class="groupbutton modeback3 modeborder3" style="float:left;">
				<div class="groupbuttoninner"><a style="color:white" href="<?php echo $CFG->homeAddress; ?>ui/stats/"><?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?></a></div>
			</div -->
			<div id="languagechoice" style="float:left;margin-top:0px;margin-right:20px;">
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=en" style="float:left;"><img style="padding-left:3px; padding-right:3px;" <?php if ($CFG->language == 'en') { echo 'border="1"'; } else { echo 'border="0"'; } ?> src="<?php echo $HUB_FLM->getImagePath('flags/UnitedKingdom.png'); ?>" /></a>
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=de" style="float:left;"><img style="padding-left:3px; padding-right:3px;" <?php if ($CFG->language == 'de') { echo 'border="1"'; } else { echo 'border="0"'; } ?> src="<?php echo $HUB_FLM->getImagePath('flags/Germany.png'); ?>" /></a>
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=es" style="float:left;"><img style="padding-left:3px; padding-right:3px;" <?php if ($CFG->language == 'es') { echo 'border="1"'; } else { echo 'border="0"'; } ?> src="<?php echo $HUB_FLM->getImagePath('flags/Spain.png'); ?>" /></a>
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=pt" style="font-size:2px;padding:0px;margin:0xpx;float:left;<?php if ($CFG->language == 'pt') { echo 'border:1px solid #7FAE0E'; } else { echo 'border:1px solid transparent'; } ?> ">
					<img style="padding-left:3px; padding-right:0px;" src="<?php echo $HUB_FLM->getImagePath('flags/Portugal.png'); ?>" />
					<img style="padding-left:0px; padding-right:3px;" src="<?php echo $HUB_FLM->getImagePath('flags/Brazil.png'); ?>" />
				</a>
			</div>
			<div style="float:left;margin-top:5px;margin-bottom: 0px;margin-left:5px;">
				<span style="font-size:12pt;"><?php echo $LNG->HOMEPAGE_TOOLS_TITLE; ?><a style="padding-left:5px;" class="active" href="<?php echo $CFG->homeAddress; ?>ui/pages/builderhelp.php" target="_blank"><?php echo $LNG->HOMEPAGE_TOOLS_LINK; ?></a></span>
			</div>
		</div>


		<!-- LOAD MY STUFF ID LOGGED IN -->

		<!-- MY GROUPS BAR AREA -->
		<div id="tab-content-home-recent-mygroup-div" style="clear:both;float:left;width:100%;padding-bottom:10px;display:none;">
			<h2 style="font-size:14pt;padding:5px;padding-right:0px;background: linear-gradient(to bottom, #FFFFFF, #E8E8E8) repeat scroll 0 0 rgba(0, 0, 0, 0);width:100%;height:25px"><?php echo $LNG->HOME_MY_GROUPS_TITLE; ?>
				<a style="margin-left:10px;font-size:10pt" href="user.php?userid=<?php echo $USER->userid; ?>#group"><?php echo $LNG->HOME_MY_GROUPS_AREA_LINK; ?></a>
				<span style="margin-left:20px;font-size:10pt">(
					<?php if (isset($USER->userid)) { ?>
						<span class="active" onclick="javascript:loadDialog('creategroup','<?php print($CFG->homeAddress);?>ui/popups/groupadd.php', 720, 700);"><?php echo $LNG->GROUP_CREATE_TITLE; ?></span>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
							echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registeropen.php">'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'</a> '.$LNG->GROUP_CREATE_LOGGED_OUT_OPEN;
						} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
							echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">'.$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT.'</a> '.$LNG->GROUP_CREATE_LOGGED_OUT_REQUEST;
						} else {
							echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> '.$LNG->GROUP_CREATE_LOGGED_OUT_CLOSED;
						}
					} ?>
				)</span>
			</h2>

			<table id="mygroupsbarcontent" style="padding:0px; margin:0px;float:left;clear:both;margin-top:3px;width:100%;">
				<tr>
					<td align="right" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-right:5px;" id="mygroupsBarLeftButton" src="<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>" onmouseover="scrollDivLeft('mygroupsBarDiv', 'mygroupsBarLeftButton', 'mygroupsBarRightButton', 'mygroupsBar')" onmouseout="stopScrollLeft('mygroupsBarDiv')" />
					</td>

					<td valign="middle">
						<div id="mygroupsBarDiv" class="plainborder bodyback" style="float:left;overflow-x:hidden;overflow-y:hidden;width:600px;">
							<div id="mygroupsBar" style="float:left"></div>
						</div>
					</td>

					<td align="left" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-left:5px;" id="mygroupsBarRightButton" src="<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>" onmouseover="scrollDivRight('mygroupsBarDiv', 'mygroupsBarLeftButton', 'mygroupsBarRightButton', 'mygroupsBar')" onmouseout="stopScrollRight('mygroupsBarDiv')" />
					</td>
				</tr>
			</table>
		</div>

		<!-- MY MAPS BAR AREA -->
		<div id="tab-content-home-recent-mydebate-div" style="clear:both;float:left;width:100%;padding:5px;padding-bottom:10px;margin-top:20px;display:none;">
			<h2 style="font-size:14pt;width:100%;padding:5px;padding-right:0px;background: linear-gradient(to bottom, #FFFFFF, #E8E8E8) repeat scroll 0 0 rgba(0, 0, 0, 0);width:100%;height:25px"><?php echo $LNG->HOME_MY_MAPS_TITLE; ?>
				<a style="margin-left:10px;font-size:10pt" href="user.php?userid=<?php echo $USER->userid; ?>#data-map"><?php echo $LNG->HOME_MY_MAPS_AREA_LINK; ?></a>
				<span style="margin-left:20px;font-size:10pt">(
					<?php if (isset($USER->userid)) { ?>
						<span class="active" onclick="javascript:loadDialog('createmap','<?php print($CFG->homeAddress);?>ui/popups/mapadd.php', 780, 600);"><?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?></span>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
							echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registeropen.php">'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_OPEN;
						} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
							echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">'.$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_REQUEST;
						} else {
							echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_CLOSED;
						}
					} ?>
				)</span>
			</h2>

			<table id="mymapsbarcontent" style="padding:0px; margin:0px;float:left;clear:both;margin-top:3px;width:100%;">
				<tr>
					<td align="right" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-right:5px;" id="mymapsBarLeftButton" src="<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>" onmouseover="scrollDivLeft('mymapsBarDiv', 'mymapsBarLeftButton', 'mymapsBarRightButton', 'mymapsBar')" onmouseout="stopScrollLeft('mymapsBarDiv')" />
					</td>

					<td valign="middle">
						<div id="mymapsBarDiv" class="plainborder bodyback" style="float:left;overflow-x:hidden;overflow-y:hidden;width:600px;">
							<div id="mymapsBar" style="float:left"></div>
						</div>
					</td>

					<td align="left" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-left:5px;" id="mymapsBarRightButton" src="<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>" onmouseover="scrollDivRight('mymapsBarDiv', 'mymapsBarLeftButton', 'mymapsBarRightButton', 'mymapsBar')" onmouseout="stopScrollRight('mymapsBarDiv')" />
					</td>
				</tr>
			</table>
		</div>

		<!-- LOAD PAGE IF NOT LOGGED IN -->

		<!-- HELP MOVIES -->
		<div id="tab-content-home-movies-div" style="clear:both;float:left;width:100%;margin-top:10px;display:block">
			<div style="float:left;">
				<h2><?php echo $LNG->PAGE_ABOUT_TITLE; ?></h2>
				<div style="clear:both;float:left">
					<iframe width="560" height="315" src="//www.youtube.com/embed/3Sv5c6MRiZo" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>

			<div style="float:left;margin-left:50px;">
				<h2><?php echo $LNG->PAGE_HELP_MOVIE_INTRO; ?> <span style="font-size:9pt;padding-left:5px;color:gray">(5m 28s)</span></h2>
				<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Overview.png" style="border:2px solid #E8E8E8" width="420px" height="315px" autobuffer="autobuffer" controls="controls">
				<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Overview.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
				</video>
			</div>
		</div>

		<!-- RECENT GROUPS AREA -->
		<div id="tab-content-home-recent-group-div" style="clear:both;float:left;width:100%;margin-top:10px;display:none;">
			<h2 style="font-size:14pt;padding:5px;padding-right:0px;width:100%;height:25px"><?php echo $LNG->HOMEPAGE_MOST_POPULAR_GROUPS_TITLE; ?>
			<a style="margin-left:10px;font-size:10pt" href="index.php#group-list"><?php echo $LNG->HOMEPAGE_VIEW_ALL; ?></a>
			<span style="margin-left:20px;font-size:10pt">(
				<?php if (isset($USER->userid)) { ?>
					<span class="active" onclick="javascript:loadDialog('creategroup','<?php print($CFG->homeAddress);?>ui/popups/groupadd.php', 720, 700);"><?php echo $LNG->GROUP_CREATE_TITLE; ?></span>
				<?php } else {
					if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registeropen.php">'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'</a> '.$LNG->GROUP_CREATE_LOGGED_OUT_OPEN;
					} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">'.$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT.'</a> '.$LNG->GROUP_CREATE_LOGGED_OUT_REQUEST;
					} else {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> '.$LNG->GROUP_CREATE_LOGGED_OUT_CLOSED;
					}
				} ?>
			)</span>
			</h2>

			<!-- GROUPS BAR AREA -->
			<table id="groupsbarcontent" style="padding:0px; margin:0px;float:left;clear:both;margin-top:3px;width:100%;">
				<tr>
					<td align="right" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-right:5px;" id="groupsBarLeftButton" src="<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>" onmouseover="scrollDivLeft('groupsBarDiv', 'groupsBarLeftButton', 'groupsBarRightButton', 'groupsBar')" onmouseout="stopScrollLeft('groupsBarDiv')" />
					</td>

					<td valign="middle">
						<div id="groupsBarDiv" class="plainborder bodyback" style="float:left;overflow-x:hidden;overflow-y:hidden;width:600px;">
							<div id="groupsBar" style="float:left"></div>
						</div>
					</td>

					<td align="left" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-left:5px;" id="groupsBarRightButton" src="<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>" onmouseover="scrollDivRight('groupsBarDiv', 'groupsBarLeftButton', 'groupsBarRightButton', 'groupsBar')" onmouseout="stopScrollRight('groupsBarDiv')" />
					</td>
				</tr>
			</table>
		</div>

		<!-- RECENT MAPS AREA -->
		<!--div id="tab-content-home-recent-debate-div" style="float:left;width:100%;margin-top:20px;display:none;">
			<h2 style="font-size:14pt;padding:5px;padding-right:0px;width:100%;width:100%;height:25px"><?php echo $LNG->HOMEPAGE_MOST_RECENT_MAPS_TITLE ?>
			<a style="margin-left:10px;font-size:10pt" href="index.php#map-list"><?php echo $LNG->HOMEPAGE_VIEW_ALL; ?></a>
			<span style="margin-left:20px;font-size:10pt">(
				<?php if (isset($USER->userid)) { ?>
					<span class="active" onclick="javascript:loadDialog('createmap','<?php print($CFG->homeAddress);?>ui/popups/mapadd.php', 780, 600);"><?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?></span>
				<?php } else {
					if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registeropen.php">'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_OPEN;
					} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">'.$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_REQUEST;
					} else {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> '.$LNG->MAP_CREATE_LOGGED_OUT_CLOSED;
					}
				} ?>
			)</span>
			</h2 -->

			<!-- MAPS BAR AREA -->
			<!--table id="mapsbarcontent" style="padding:0px; margin:0px;float:left;clear:both;margin-top:3px;width:100%;">
				<tr>
					<td align="right" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-right:5px;" id="mapsBarLeftButton" src="<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>" onmouseover="scrollDivLeft('mapsBarDiv', 'mapsBarLeftButton', 'mapsBarRightButton', 'mapsBar')" onmouseout="stopScrollLeft('mapsBarDiv')" />
					</td>

					<td valign="middle">
						<div id="mapsBarDiv" class="plainborder bodyback" style="float:left;overflow-x:hidden;overflow-y:hidden;width:600px;">
							<div id="mapsBar" style="float:left"></div>
						</div>
					</td>

					<td align="left" valign="middle" style="width:40px; min-width:40px;">
						<img style="padding-left:5px;" id="mapsBarRightButton" src="<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>" onmouseover="scrollDivRight('mapsBarDiv', 'mapsBarLeftButton', 'mapsBarRightButton', 'mapsBar')" onmouseout="stopScrollRight('mapsBarDiv')" />
					</td>
				</tr>
			</table>
		</div-->

		<div style="float:left;width:100%;margin-top:30px;margin-left:5px;"></div>

	</div>
</div>
