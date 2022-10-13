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
<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo $CFG->SITE_TITLE; ?></title>

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

<?php
	if ($CFG->GOOGLE_ANALYTICS_ON) {
		include_once($HUB_FLM->getCodeDirPath("ui/analyticstracking.php"));
	}
?>
</head>

<body>
<div id="maincenter" style="margin:0 auto;width:1024px; max-width:1024px;">

<div id="header" class="headerback" style="margin-bottom:0px;padding-bottom:0px">
    <div id="logo" style="padding-top:0px;">
    	<a title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" href="<?php print($CFG->homeAddress);?>" style="font-size: 10pt; margin-bottom:3px;">
        <img border="0" alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-header.png'); ?>" />
        </a>
    </div>
    <!-- div style="float: left; padding-top:16px;margin-left:5px;">
		<div style="padding-left:23px;">
			<a href="<?php print($CFG->homeAddress);?>" title="<?php echo $LNG->HEADER_HOME_ICON_HINT; ?>" style="font-size: 10pt; margin-bottom:3px;">
			<img border="0" width="20" height="20" alt="<?php echo $LNG->HEADER_HOME_ICON_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('home.png'); ?>" />
			</a>
		</div>
	</div -->
    <div style="float: right;">
		<div style="float:right;">
			<div id="menu">
				<div style="float:left;">
				<?php
					global $USER;
					if(isset($USER->userid)){
						$name = $LNG->HEADER_MY_HUB_LINK;
						echo "<a title='".$LNG->HEADER_USER_HOME_LINK_HINT."' href='".$CFG->homeAddress."user.php?userid=".$USER->userid."#home-list'>". $name ."</a> | <a title='".$LNG->HEADER_EDIT_PROFILE_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/profile.php'>".$LNG->HEADER_EDIT_PROFILE_LINK_TEXT."</a> | <a title='".$LNG->HEADER_SIGN_OUT_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/logout.php'>".$LNG->HEADER_SIGN_OUT_LINK_TEXT."</a> ";
					} else {
						echo "<form style='margin:0px; padding:0px;padding-right:3px; float:left;' id='loginform' action='' method='post'><input style='margin:0px; padding:0px;margin-bottom:3px; border:0px solid transparent; background:transparent;font-family: Arial, Helvetica, sans-serif; font-size: 10pt;' id='loginsubmit' name='loginsubmit' type='submit' value='".$LNG->HEADER_SIGN_IN_LINK_TEXT."' class='active' title='".$LNG->HEADER_SIGN_IN_LINK_HINT."'></input></form>";
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
							echo " | <a title='".$LNG->HEADER_SIGNUP_OPEN_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/registeropen.php'>".$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT."</a> ";
						} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
							echo " | <a title='".$LNG->HEADER_SIGNUP_REQUEST_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/registerrequest.php'>".$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT."</a> ";
						}
					}
				?>
				| <a title="<?php echo $LNG->HEADER_ABOUT_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>ui/pages/about.php'><?php echo $LNG->HEADER_ABOUT_PAGE_LINK_TEXT; ?></a>
				| <a title="<?php echo $LNG->HEADER_HELP_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>ui/pages/help.php'><?php echo $LNG->HEADER_HELP_PAGE_LINK_TEXT; ?></a>

				| <a href='<?php echo $CFG->homeAddress; ?>ui/stats/'><?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?></a>

				<?php
				if($USER->getIsAdmin() == "Y"){
					echo "| <a title='".$LNG->HEADER_ADMIN_PAGE_LINK_HINT."' href='".$CFG->homeAddress."ui/admin/index.php'>".$LNG->HEADER_ADMIN_PAGE_LINK_TEXT." </a>";
				}
				?>

				</div>
				<div style="float:right;padding-left:10px;padding-top:0px;" id="rssbuttonfred"></div>
			</div>

			<div id="search">
				<form name="search" action="<?php print($CFG->homeAddress);?>search.php" method="get" id="searchform">
					<div style="float:right;"><img src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: document.forms['search'].submit();" title="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>" alt="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_ALT; ?>" /></div>
					<div style="float: right;">
						<input type="text" style=" margin-right:3px; width:250px" id="q" name="q" value="<?php print( htmlspecialchars($query) ); ?>"/>
					</div>
					<label for="q" style="float: right; margin-right: 3px; margin-top: 3px;font-weight:bold"><a href="javascript:void(0)" onMouseOver="showGlobalHint('MainSearch', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /></a>
				 </form>
			 </div>
		</div>
     </div>
</div>

<div id="hgrhint" class="hintRollover" style="position: absolute; visibility:hidden; border: 1px solid gray;overflow:hidden">
	<table width="400" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFED9">
		<tr width="350">
			<td width="350" align="left">
				<span id="globalMessage"></span>
			</td>
		</tr>
	</table>
</div>
<div id="main" style="margin-top:10px;">
<div style="float: left; width: 98%;padding:0px;">
<div style="float:left;width:100%;">
    <?php
    	if (file_exists("menu.php") ) {
        	include("menu.php");
        }
    ?>
</div>
<div style="width:100%;clear:both;float:left;padding:10px;padding-left:10px;">
