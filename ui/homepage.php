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
					container.style.width = (json.groupset[0].groups.length*450)+'px';
					displayGroups(container,json.groupset[0].groups,0, false, true);
					$("tab-content-home-recent-mygroup-div").style.display = 'block';
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
					container.style.width = (json.nodeset[0].nodes.length*550)+'px';
					displayMapNodes(428, 160, container,json.nodeset[0].nodes,0, false,'recentmaps','inactive', false, false, true);
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

	}
</script>

<div class="container-fluid">
	<div class="row p-3">	
		<div class="col">
			<p>
				<?php echo $LNG->HOMEPAGE_FIRST_PARA; ?><br />
				<span id="homeintrobutton" class="active" onclick="if ($('homeintromore').style.display == 'none') { $('homeintromore').style.display = 'block'; $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_READ_LESS; ?>'; } else { $('homeintromore').style.display = 'none';  $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_KEEP_READING; ?>';}"><?php echo $LNG->HOMEPAGE_KEEP_READING; ?></span>
			</p>
			<div id="homeintromore" style="display:none;">					
				<p><?php echo $LNG->HOMEPAGE_SECOND_PARA_PART2; ?></p>
			</div>
		</div>

		<!-- FLAGS -->
		<div class="d-flex flex-row gap-3">
			<div id="languagechoice" class="d-flex flex-row justify-content-between">
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=en"><img class="p-1" <?php if ($CFG->language == 'en') { echo 'border="1"'; } else { echo 'border="0"'; } ?> src="<?php echo $HUB_FLM->getImagePath('flags/UnitedKingdom.png'); ?>" alt="English" /></a>
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=de"><img class="p-1" <?php if ($CFG->language == 'de') { echo 'border="1"'; } else { echo 'border="0"'; } ?> src="<?php echo $HUB_FLM->getImagePath('flags/Germany.png'); ?>" alt="German" /></a>
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=es"><img class="p-1" <?php if ($CFG->language == 'es') { echo 'border="1"'; } else { echo 'border="0"'; } ?> src="<?php echo $HUB_FLM->getImagePath('flags/Spain.png'); ?>" alt="Spanish" /></a>
				<a href="<?php echo $CFG->homeAddress; ?>index.php?lang=pt" style="<?php if ($CFG->language == 'pt') { echo 'border:1px solid #7FAE0E'; } else { echo 'border:1px solid transparent'; } ?> ">
					<img class="p-1" src="<?php echo $HUB_FLM->getImagePath('flags/Portugal.png'); ?>" alt="Portuguese" />
					<img class="p-1" src="<?php echo $HUB_FLM->getImagePath('flags/Brazil.png'); ?>" alt="Portuguese (Brazil)" />
				</a>
			</div>
			<div style="float:left;margin-top:5px;margin-bottom: 0px;margin-left:5px;">
				<span style="font-size:12pt;"><?php echo $LNG->HOMEPAGE_TOOLS_TITLE; ?><a style="padding-left:5px;" class="active" href="<?php echo $CFG->homeAddress; ?>ui/pages/builderhelp.php" target="_blank"><?php echo $LNG->HOMEPAGE_TOOLS_LINK; ?></a></span>
			</div>
		</div>


		<!-- LOAD MY STUFF ID LOGGED IN -->

		<!-- MY GROUPS BAR AREA -->
		<div id="tab-content-home-recent-mygroup-div" style="display:none" class="row p-3">		
			<h2><?php echo $LNG->HOME_MY_GROUPS_TITLE; ?>
				<span class="fs-6"><a href="user.php?userid=<?php echo $USER->userid; ?>#group"><?php echo $LNG->HOME_MY_GROUPS_AREA_LINK; ?></a></span>
				<span class="fs-6">(
					<?php if (isset($USER->userid)) { ?>
						<span class="active span-link" onclick="javascript:loadDialog('creategroup','<?php print($CFG->homeAddress);?>ui/popups/groupadd.php', 720, 700);"><?php echo $LNG->GROUP_CREATE_TITLE; ?></span>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<a title="<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php echo urlencode($ref); ?>"><?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> 
							| <a title="<?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/registeropen.php"><?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?></a> <?php echo $LNG->GROUP_CREATE_LOGGED_OUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<a title="<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php echo urlencode($ref); ?>"><?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> 
							| <a title="<?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/registerrequest.php"><?php echo $LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT; ?></a> <?php echo $LNG->GROUP_CREATE_LOGGED_OUT_REQUEST; ?>
						<?php } else { ?>
							<a title="<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php echo urlencode($ref); ?>"><?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> <?php echo $LNG->GROUP_CREATE_LOGGED_OUT_CLOSED; ?>
						<?php }
					} ?>
				)</span>
			</h2>

			<div id="mygroupsbarcontent" class="d-flex flex-row justify-content-between align-content-center home-groupsbar">
				<div class="align-self-center me-4">
					<img alt="scroll left" id="mygroupsBarLeftButton" src="<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>" onmouseover="scrollDivLeft('mygroupsBarDiv', 'mygroupsBarLeftButton', 'mygroupsBarRightButton', 'mygroupsBar')" onmouseout="stopScrollLeft('mygroupsBarDiv')" />
				</div>
				<div id="mygroupsBarDiv" class="plainborder w-100" style="overflow-x:hidden;overflow-y:hidden;">
					<div id="mygroupsBar"></div>
				</div>
				<div class="align-self-center ms-4">
					<img alt="scroll right" id="mygroupsBarRightButton" src="<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>" onmouseover="scrollDivRight('mygroupsBarDiv', 'mygroupsBarLeftButton', 'mygroupsBarRightButton', 'mygroupsBar')" onmouseout="stopScrollRight('mygroupsBarDiv')" />
				</div>
			</div>
		</div>

		<!-- MY MAPS BAR AREA -->
		<div id="tab-content-home-recent-mydebate-div" style="display:none" class="row p-3">
			<h2><?php echo $LNG->HOME_MY_MAPS_TITLE; ?>
				<span class="fs-6"><a href="user.php?userid=<?php echo $USER->userid; ?>#data-map"><?php echo $LNG->HOME_MY_MAPS_AREA_LINK; ?></a></span>
				<span class="fs-6">(
					<?php if (isset($USER->userid)) { ?>
						<span class="active span-link" onclick="javascript:loadDialog('createmap','<?php print($CFG->homeAddress);?>ui/popups/mapadd.php', 780, 600);"><?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?></span>
					<?php } else { ?>
						<?php if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<a title="<?php $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php urlencode($ref); ?>"><?php $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> | <a title="<?php $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?>" href="<?php $CFG->homeAddress; ?>ui/pages/registeropen.php"><?php $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?></a> <?php $LNG->MAP_CREATE_LOGGED_OUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<a title="<?php $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php urlencode($ref); ?>"><?php $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> | <a title="<?php $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?>" href="<?php $CFG->homeAddress; ?>ui/pages/registerrequest.php"><?php $LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT; ?></a> <?php $LNG->MAP_CREATE_LOGGED_OUT_REQUEST; ?>
						<?php } else { ?>
							<a title="<?php $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php urlencode($ref); ?>"><?php $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> <?php $LNG->MAP_CREATE_LOGGED_OUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
				)</span>
			</h2>

			<div id="mymapsbarcontent" class="d-flex flex-row justify-content-between align-content-center home-mapsbar">
				<div class="align-self-center me-4">
					<img alt="scroll left" id="mymapsBarLeftButton" src="<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>" onmouseover="scrollDivLeft('mymapsBarDiv', 'mymapsBarLeftButton', 'mymapsBarRightButton', 'mymapsBar')" onmouseout="stopScrollLeft('mymapsBarDiv')" />
				</div>
				<div id="mymapsBarDiv" class="plainborder w-100" style="overflow-x:hidden;overflow-y:hidden;">
					<div id="mymapsBar"></div>
				</div>
				<div class="align-self-center ms-4">
					<img alt="scroll right" id="mymapsBarRightButton" src="<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>" onmouseover="scrollDivRight('mymapsBarDiv', 'mymapsBarLeftButton', 'mymapsBarRightButton', 'mymapsBar')" onmouseout="stopScrollRight('mymapsBarDiv')" />
				</div>
			</div>
		</div>

		<!-- LOAD PAGE IF NOT LOGGED IN -->

		<!-- HELP MOVIES -->
		<div id="tab-content-home-movies-div" class="row p-3 gap-2">
			<hr class="my-4" />
			<div class="col">
				<h2 class="mb-4"><?php echo $LNG->PAGE_ABOUT_TITLE; ?></h2>
				<iframe src="//www.youtube.com/embed/3Sv5c6MRiZo" width="480" height="270" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
			</div>
			<div class="col">
				<h2 class="mb-4"><?php echo $LNG->PAGE_HELP_MOVIE_INTRO;?> <span class="text-secondary fs-6">(5m 28s)</span></h2>
				<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Overview.png" width="480px" height="270px" autobuffer="autobuffer" controls="controls">
					<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Overview.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
				</video>
			</div>
			<hr class="mt-4" />
		</div>

		<!-- RECENT GROUPS AREA -->
		<div id="tab-content-home-recent-group-div" style="display:none" class="row p-3">
			<h2><?php echo $LNG->HOMEPAGE_MOST_POPULAR_GROUPS_TITLE ?>
				<span class="fs-6"><a href="index.php#group-list"><?php echo $LNG->HOMEPAGE_VIEW_ALL; ?></a></span>
				<span class="fs-6">(
					<?php if (isset($USER->userid)) { ?>
						<span class="active" onclick="javascript:loadDialog('creategroup','<?php print($CFG->homeAddress);?>ui/popups/groupadd.php', 720, 700);"><?php echo $LNG->GROUP_CREATE_TITLE; ?></span>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<a title="<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php echo urlencode($ref); ?>"><?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> | <a title="<?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/registeropen.php"><?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?></a> <?php echo $LNG->GROUP_CREATE_LOGGED_OUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<a title="<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php echo urlencode($ref); ?>"><?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> | <a title="<?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/registerrequest.php"><?php echo $LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT; ?></a> <?php echo $LNG->GROUP_CREATE_LOGGED_OUT_REQUEST; ?>
						<?php } else { ?>
							<a title="<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/login.php?ref=<?php echo urlencode($ref); ?>"><?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?></a> <?php echo $LNG->GROUP_CREATE_LOGGED_OUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
				)</span>
			</h2>

			<!-- GROUPS BAR AREA -->
			<div id="groupsbarcontent" class="d-flex flex-row justify-content-between align-content-center">
				<div class="align-self-center me-4">
					<img alt="scroll left" id="groupsBarLeftButton" src="<?php echo $HUB_FLM->getImagePath('back-arrow-grey.png'); ?>" onmouseover="scrollDivLeft('groupsBarDiv', 'groupsBarLeftButton', 'groupsBarRightButton', 'groupsBar')" onmouseout="stopScrollLeft('groupsBarDiv')" />
				</div>
				<div id="groupsBarDiv" class="plainborder w-100" style="overflow-x:hidden;overflow-y:hidden;">
					<div id="groupsBar"></div>
				</div>
				<div class="align-self-center ms-4">
					<img alt="scroll right" id="groupsBarRightButton" src="<?php echo $HUB_FLM->getImagePath('forward-arrow.png'); ?>" onmouseover="scrollDivRight('groupsBarDiv', 'groupsBarLeftButton', 'groupsBarRightButton', 'groupsBar')" onmouseout="stopScrollRight('groupsBarDiv')" />
				</div>
			</div>			
		</div>
	</div>
</div>
