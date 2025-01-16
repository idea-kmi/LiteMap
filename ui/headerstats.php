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

include_once($HUB_FLM->getCodeDirPath("core/statslib.php"));

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

		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title><?php echo $CFG->SITE_TITLE; ?></title>

		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("bootstrap.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("all.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("style.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("stylecustom.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("tabber.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("node.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("widget.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("vis.css"); ?>" type="text/css" media="screen" />

		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/base.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/ForceDirected.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/Sunburst.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/AreaChart.css"); ?>" type="text/css" />

		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/d3-3.5.17/css/d3styles.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/dc.js-2.1.10/dc.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/nvd3-1.8.6/build/nv.d3.css"); ?>" type="text/css" />

		<link rel="icon" href="<?php echo $HUB_FLM->getImagePath("favicon.ico"); ?>" type="images/x-icon" />

		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>

		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/datetimepicker_css.js" type="text/javascript"></script>

		<!-- JIT VISUALISATIONS CODE -->
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/jit-2.0.2/Jit/jit.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/graphlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/forcedirectedlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/socialforcedirectedlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/sunburstuserdebatelib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/stackedareachartlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/networklib.js.php" type="text/javascript"></script>

		<!-- D3 VISUALISATIONS CODE -->
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/d3-3.5.17/d3.min.js"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/crossfilter-1.3.14/crossfilter.min.js"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dc.js-2.1.10/dc.min.js"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/nvd3-1.8.6/build/nv.d3.min.js"></script>

		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/circlepackinglib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/scatterplotlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/streamgraphlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/crossfilterlib.js.php" type="text/javascript"></script>

		<script type="text/javascript">
			function init(){
				document.getElementById('cookie-policy-link').focus();
			}
			window.onload = init;
		</script>

		<?php
		$custom = $HUB_FLM->getCodeDirPath("ui/headerstatsCustom.php");
		if (file_exists($custom)) {
			include_once($custom);
		}
		?>

		<?php
			global $HEADER,$BODY_ATT, $CFG;
			if(is_array($HEADER)){
				foreach($HEADER as $header){
					echo $header;
				}
			}
		?>
	</head>

	<body>
		<div class="alert alert-dark alert-dismissible fade show m-0 fixed-bottom" role="alert" id="cookieConsent" style="display: none;">
			<div style="display: flex; align-items: center; flex-direction: column;">
				We use essential cookies to handle sessions and logins, and Google Analytics cookies to gather data on how you use this site.<br/>
				<div>This data is extremely valuable for our research and helps us improve our analysis.</div>				
				<a href="<?php echo $CFG->homeAddress; ?>ui/pages/cookies.php">Read our cookie policy</a>
				<div>
					Are you happy to help with our research by allowing Google Analytics cookies? 
					<button type="button" class="cookieConsentButton" data-bs-dismiss="alert" aria-label="Yes" id="acceptAnlyticsCookies">Yes</button>
					<button type="button" class="cookieConsentButton" data-bs-dismiss="alert" aria-label="No" id="declineAnlyticsCookies">No</button>
				</div>
				<br/>
			</div>
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
							<button class="btn btn-outline-secondary" type="button" onclick="javascript: document.forms['search'].submit();" ><?php echo $LNG->HEADER_SEARCH_BOX_LABEL; ?></button>
						</div>
					</form>
				</div>
			</div>
		</header>

		<div id="hgrhint" class="hintRollover">
				<span id="globalMessage"></span>
			</div>
			<div id="main" class="container pt-4">
				<?php
					if (file_exists("menu.php") ) {
						include("menu.php");
					}
				?>
				<div id="tabs-content" class="tab-content p-0">