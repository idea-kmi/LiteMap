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
	if ($CFG->privateSite) {
		checklogin();
	}

	$query = stripslashes(parseToJSON(optional_param("q","",PARAM_TEXT)));
	// need to do parseToJSON to convert any '+' symbols as they are now used in searches.

	if( isset($_POST["loginsubmit"]) ) {
		$url = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		header('Location: '.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($url));
	}

	global $HUB_FLM;
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


		<script src="https://www.youtube-nocookie.com/iframe_api" type="text/javascript"></script>
		<!-- script src="https://player.vimeo.com/api/player.js"></script -->

		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/users.js.php'); ?>" type="text/javascript"></script>

		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>

		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/lib/bootstrap/bootstrap.bundle.min.js'); ?>" type="text/javascript"></script>

		<?php
			$custom = $HUB_FLM->getCodeDirPath("ui/headerCustom.php");
			if (file_exists($custom)) {
				include_once($custom);
			}
		?>

		<script type="text/javascript">
			window.name="litemapmain";
			function init(){
				document.getElementById('cookie-policy-link').focus(); 

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
		?>
	</head>
	<body <?php echo $BODY_ATT; ?> id="cohere-body">

		<div class="alert alert-warning text-center" role="alert" style="margin-top: 20px;">
			<h4 class="alert-heading" style="font-size: 1.3em">⚠️ Important Notice: Site Retirement</h4>
			<p>
				It is with a heavy heart that we announce the retirement of this research site after more than a decade of service.
				The underlying code has become outdated and increasingly difficult to maintain securely, and we are no longer able to keep the site online.
			</p>
			<p>
				We are incredibly proud of the role this tool has played in supporting research and collaboration over the years. 
				Thank you to everyone who has used and contributed to it.
			</p>
			<p>
				The site will be taken offline on <strong>10th October 2025</strong>.
			</p>
			<p>
				If you wish to preserve any of your work, please
				<strong>export your data to JSON using the export button on Maps
				<img src="/images/json-ld-data-24.png" alt="Export JSON icon" style="height: 20px; vertical-align: middle;">
				, take screenshots, or print your content before this date</strong>.
			</p>
			<hr>
			<p class="mb-0">Thank you for being part of this journey.</p>
		</div>

		<div class="alert alert-dark alert-dismissible fade show m-0 fixed-bottom" role="alert" id="cookieConsent" style="display: none;">
			<div style="display: flex; align-items: center; flex-direction: column;">
				We use essential cookies to handle sessions and logins, and Google Analytics cookies to gather data on how you use this site.<br/>
				<div>This data is extremely valuable for our research and helps us improve our analysis.</div>				
				<a id="cookie-policy-link" style="margin-top:5px;" href="<?php echo $CFG->homeAddress; ?>ui/pages/cookies.php">Read our cookie policy</a>
				<div>
					Are you happy to help with our research by allowing Google Analytics cookies? 
					<button type="button" class="cookieConsentButton" data-bs-dismiss="alert" aria-label="Yes" id="acceptAnlyticsCookies">Yes</button>
					<button type="button" class="cookieConsentButton" data-bs-dismiss="alert" aria-label="No" id="declineAnlyticsCookies">No</button>
				</div>
				<br/>
			</div>
		</div>

		<nav id="mainnav" class="py-2 bg-light border-bottom collapse multi-collapse show">
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

		<header id="header" class="py-3 mb-0 border-bottom collapse multi-collapse show">
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
							<button class="btn btn-outline-secondary" type="button" onclick="javascript: document.forms['search'].submit();" ><?php echo $LNG->HEADER_SEARCH_BOX_LABEL; ?></button>
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
