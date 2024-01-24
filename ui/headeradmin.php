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
	/** Author: Michelle Bachler, KMi, The Open University **/

	if ($CFG->privateSite) {
		checklogin();
	}

	$query = stripslashes(parseToJSON(optional_param("q","",PARAM_TEXT)));
	// need to do parseToJSON to convert any '+' symbols as they are now used in searches.

	if( isset($_POST["loginsubmit"]) ) {
		$url = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		header('Location: '.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($url));
	}

	// global $HUB_FLM;
	
	include_once($HUB_FLM->getCodeDirPath("core/statslib.php"));
	
	$page = optional_param("page","home",PARAM_ALPHANUM);
	$itemid = optional_param("nodeid","",PARAM_ALPHANUMEXT);
	if ($itemid == "") {
		$itemid = optional_param("groupid","",PARAM_ALPHANUMEXT);
		if ($itemid == "") {
			$itemid = 'system';
		}
	}
?>

<!DOCTYPE html>
<html lang="<?php echo $CFG->language; ?>">
	<head>
		<?php
			if ($CFG->GOOGLE_ANALYTICS_ON) {
				include_once($HUB_FLM->getCodeDirPath("ui/analyticstracking.php"));
			}
		?>
		<meta http-equiv="Content-Type" content="text/html" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $CFG->SITE_TITLE; ?></title>

		<link rel="icon" href="<?php echo $HUB_FLM->getImagePath("favicon.ico"); ?>" type="images/x-icon" />

		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("bootstrap.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("all.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("style.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("stylecustom.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("node.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("tabber.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("vis.css"); ?>" type="text/css" media="screen" />	

		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/popuputil.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/users.js.php'); ?>" type="text/javascript"></script>

		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/datetimepicker_css.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/bootstrap/bootstrap.bundle.min.js" type="text/javascript"></script>

		<?php
			$custom = $HUB_FLM->getCodeDirPath("ui/dialogheaderCustom.php");
			if (file_exists($custom)) {
				include_once($custom);
			}
		?>

		<?php
			$nowtime = time();
			if (isset($USER) && isset($USER->userid)
				&& $nowtime >= $CFG->TEST_TRIAL_START && $nowtime < $CFG->TEST_TRIAL_END) { ?>

			<script type="text/javascript">
				window.addEventListener("unload", function (e) {
					var itemid='<?php echo $itemid; ?>';
					var testelementid='<?php echo $page; ?>';
					var testevent='leftpage';
					var state=window.location.href;
					auditTesting(itemid,testelementid,testevent,state);
				});
			</script>
		<?php } ?>

		<script type="text/javascript">
			window.name="coheremain";
			function init(){
				var args = new Object();
				args['filternodetypes'] = "Issue,Solution,Idea,"+EVIDENCE_TYPES;

				<?php if ($CFG->hasRss) { ?>
				var feed = new Element("img",
					{'src': '<?php echo $HUB_FLM->getImagePath("feed-icon-20x20.png"); ?>',
					'title': '<?php echo $LNG->HEADER_RSS_FEED_ICON_HINT; ?>',
					'alt': '<?php echo $LNG->HEADER_RSS_FEED_ICON_ALT; ?>',
					'class': 'active',
					'style': 'padding-top:0px;'});
				Event.observe(feed,'click',function(){
					getNodesFeed(args);
				});
				$('rssbuttonfred').insert(feed);
				<?php } ?>
			}
			window.onload = init;
		</script>

		<?php
			global $HEADER,$BODY_ATT;
			if(is_array($HEADER)){
				foreach($HEADER as $header){
					echo $header;
				}
			}

			$pg = $_SERVER['PHP_SELF'];
			
		?>
		<?php 
			/* Counts */
			$registrationRequests = getRegistrationRequestCount();
			$reportedItemsCount = getReportedItemsCount();
			$reportedGroupsCount = getReportedGroupsCount();
			$reportedUsersCount = getReportedUsersCount();
		?>
	</head>
	<body <?php echo $BODY_ATT; ?>>
		<div class="alert alert-dark alert-dismissible fade show m-0 fixed-bottom" role="alert" id="cookieConsent" style="display: none;">
			This website uses cookies to ensure you get the best experience on our website. <a href="ui/pages/cookies.php">Learn more</a>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="closeCookieConsent"></button>
		</div>
		<nav class="py-2 bg-light border-bottom">
			<div class="container-fluid d-flex flex-wrap justify-content-end">
				<ul class="nav" id="menu">
					<li class="nav-item"><a title="<?php echo $LNG->HEADER_HOME_PAGE_LINK_HINT; ?>" href='<?php print($CFG->homeAddress);?>' class="nav-link px-2"><?php echo $LNG->HEADER_HOME_PAGE_LINK_TEXT; ?></a></li>
					<?php
						global $USER;
						if(isset($USER->userid)){
							$name = $LNG->HEADER_MY_HUB_LINK; ?>
							<li class="nav-item"><a title='<?php echo $LNG->HEADER_USER_HOME_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $USER->userid; ?>#home-list' class="nav-link px-2"><?php echo $name ?></a>
							</li><li class="nav-item"><a title='<?php echo $LNG->HEADER_EDIT_PROFILE_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/profile.php' class="nav-link px-2"><?php echo $LNG->HEADER_EDIT_PROFILE_LINK_TEXT; ?></a>
							</li><li class="nav-item"><a title='<?php echo $LNG->HEADER_SIGN_OUT_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/logout.php' class="nav-link px-2"><?php echo $LNG->HEADER_SIGN_OUT_LINK_TEXT; ?></a></li>
						<?php } else { ?>
							<li class="nav-item">
								<form id='loginform' action='' method='post'>
									<input class="nav-link px-2" id='loginsubmit' name='loginsubmit' type='submit' value='<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>' class='active' title='<?php echo $LNG->HEADER_SIGN_IN_LINK_HINT; ?>'></input>
								</form>
							</li>
							<?php if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
								<li class="nav-item"><a title='<?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/registeropen.php' class="nav-link px-2"><?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?></a></li>
							<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
								<li class="nav-item"><a title='<?php echo $LNG->HEADER_SIGNUP_REQUEST_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/registerrequest.php' class="nav-link px-2"><?php echo $LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT; ?></a></li>
							<?php }
						}
					?>

					<li class="nav-item"><a title="<?php echo $LNG->HEADER_ABOUT_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>ui/pages/about.php' class="nav-link px-2"><?php echo $LNG->HEADER_ABOUT_PAGE_LINK_TEXT; ?></a></li>
					<li class="nav-item"><a title="<?php echo $LNG->HEADER_HELP_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>ui/pages/help.php' class="nav-link px-2"><?php echo $LNG->HEADER_HELP_PAGE_LINK_TEXT; ?></a></li>
					<?php if (($CFG->GLOBAL_DASHBOARD_VIEW == 'public') || (isset($USER->userid) && ($CFG->GLOBAL_DASHBOARD_VIEW == 'private')) ) { ?>
						<li class="nav-item"><a title="<?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?>" href='<?php echo $CFG->homeAddress; ?>ui/stats/' class="nav-link px-2"><?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?></a></li>
					<?php } ?>
					<?php
						if($USER->getIsAdmin() == "Y"){ ?>
							<li class="nav-item"><a title='<?php echo $LNG->HEADER_ADMIN_PAGE_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/admin/index.php' class="nav-link px-2"><?php echo $LNG->HEADER_ADMIN_PAGE_LINK_TEXT; ?> </a></li>
						<?php }
					?>
					<?php if ($CFG->hasRss) { ?>
						<div style="float:right;padding-left:10px;padding-top:0px;" id="rssbuttonfred"></div>
					<?php } ?>
				</ul>
			</div>
		</nav>

		<header class="py-3 mb-0 border-bottom" id="header">
			<div class="container-fluid d-flex flex-wrap justify-content-center">
				<div id="logo" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
					<a href="<?php print($CFG->homeAddress);?>" title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" class="text-decoration-none">
						<img alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-header.png'); ?>" />
					</a>
				</div>
				<div class="col-12 col-lg-auto mb-3 mb-lg-0" id="search">
					<form name="search" action="<?php print($CFG->homeAddress);?>search.php" method="get" id="searchform" class="col-12 col-lg-auto mb-3 mb-lg-0">
						<div class="input-group mb-3">
							<a href="javascript:void(0)" onMouseOver="showGlobalHint('MainSearch', event, 'hgrhint'); return false;" onfocus="showGlobalHint('MainSearch', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)" class="m-2 help-hint" aria-label="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>">
								<i class="fas fa-info-circle fa-lg" title="Search Info"></i>
							</a>
							<label class="d-none" for="q"><?php echo $LNG->HEADER_SEARCH_BOX_LABEL; ?></label>
							<input type="text" class="form-control" aria-label="Search" placeholder="<?php echo htmlspecialchars($LNG->DEFAULT_SEARCH_TEXT); ?>" id="q" name="q" value="<?php print( htmlspecialchars($query) ); ?>" />
  							<button class="btn btn-outline-secondary" type="button" onclick="javascript: document.forms['search'].submit();" >Search</button>
						</div>
					</form>
				</div>
			</div>
		</header>

		<div id="message" class="messagediv"></div>
		<div id="prompttext" class="prompttext"></div>
		<div id="hgrhint" class="hintRollover">
			<span id="globalMessage"></span>
		</div>
		<div id="main" class="main">
			<div id="contentwrapper" class="contentwrapper">
				<div id="content" class="content">
					<div class="c_innertube">
						<div class="container-fluid">
							<div class="row p-4">		
								<div class="col">
									<div class="d-flex flex-wrap w-100 gap-2 border-bottom pb-4">
										<a href="<?= $CFG->homeAddress ?>ui/admin/index.php" class="btn btn-admin <?=($pg=="/ui/admin/index.php" ? 'active' : '')?> ">Admin Dashboard</a>
										<a href="<?= $CFG->homeAddress ?>ui/admin/stats" class="btn btn-admin <?=($pg=="/ui/admin/stats/" ? 'active' : '')?> ">Analytics</a>
										<a href="<?= $CFG->homeAddress ?>ui/admin/userregistration.php" class="btn btn-admin <?=($pg=="/ui/admin/userregistration.php" ? 'active' : '')?> ">Users</a>
										<a href="<?= $CFG->homeAddress ?>ui/admin/groupslist.php" class="btn btn-admin <?=($pg=="/ui/admin/groupslist.php" ? 'active' : '')?> ">Groups</a>
										<a href="<?= $CFG->homeAddress ?>ui/admin/registrationmanager.php" class="btn btn-admin <?=($pg=="/ui/admin/registrationmanager.php" ? 'active' : '')?> ">Registration requests <?=($registrationRequests > 0 ? '<span class="badge rounded-pill" style="background-color: #fff; border: 1px solid #a91a70; color: #a91a70; margin-left: 5px;">'. $registrationRequests .'</span>' : '')?></a>
										<a href="<?= $CFG->homeAddress ?>ui/admin/spammanager.php" class="btn btn-admin <?=($pg=="/ui/admin/spammanager.php" ? 'active' : '')?> ">Reported items <?=($reportedItemsCount > 0 ? '<span class="badge rounded-pill" style="background-color: #fff; border: 1px solid #a91a70; color: #a91a70; margin-left: 5px;">'. $reportedItemsCount .'</span>' : '')?></a>
										<a href="<?= $CFG->homeAddress ?>ui/admin/spammanagergroups.php" class="btn btn-admin <?=($pg=="/ui/admin/spammanagergroups.php" ? 'active' : '')?> ">Reported groups <?=($reportedGroupsCount > 0 ? '<span class="badge rounded-pill" style="background-color: #fff; border: 1px solid #a91a70; color: #a91a70; margin-left: 5px;">'. $reportedGroupsCount .'</span>' : '')?></a>
										<a href="<?= $CFG->homeAddress ?>ui/admin/spammanagerusers.php" class="btn btn-admin <?=($pg=="/ui/admin/spammanagerusers.php" ? 'active' : '')?> ">Reported users <?=($reportedUsersCount > 0 ? '<span class="badge rounded-pill" style="background-color: #fff; border: 1px solid #a91a70; color: #a91a70; margin-left: 5px;">'. $reportedUsersCount .'</span>' : '')?></a>
										<?php 
											if (isset($CFG->adminUserID)) {
												$admin = new User($CFG->adminUserID);
												$admin = $admin->load();
												if (!$admin instanceof Hub_Error) { ?>
													<a href="<?= $CFG->homeAddress ?>ui/admin/newsmanager.php" class="btn btn-admin <?=($pg=="/ui/admin/newsmanager.php" ? 'active' : '')?> ">Manage news</a>
											<?php }
										} ?>
									</div>
								</div>
							</div>
						</div>