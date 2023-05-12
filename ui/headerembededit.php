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

$ref = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

if( isset($_POST["logoutsubmit"]) ) {
	logoutExternal();
    clearSession();
    $USER = new User();
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

<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo $CFG->SITE_TITLE; ?></title>

<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("style.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("stylecustom.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("node.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("tabber.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("widget.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("vis.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/base.css"); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/ForceDirected.css"); ?>" type="text/css" />

<link rel="icon" href="<?php echo $HUB_FLM->getImagePath("favicon.ico"); ?>" type="images/x-icon" />

<script src="https://www.youtube.com/iframe_api" type="text/javascript"></script>
<script src="https://player.vimeo.com/api/player.js"></script>

<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>
<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/users.js.php'); ?>" type="text/javascript"></script>
<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/widget.js.php'); ?>" type="text/javascript"></script>

<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>

<script src="<?php echo $CFG->homeAddress; ?>ui/lib/jit-2.0.2/Jit/jit.js" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/graphlib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/forcedirectedlib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/socialforcedirectedlib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/positionedmaplib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/networklib.js.php" type="text/javascript"></script>

<?php
$custom = $HUB_FLM->getCodeDirPath("ui/headerCustom.php");
if (file_exists($custom)) {
    include_once($custom);
}
?>

<script type="text/javascript">

window.name="coheremain";

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

<div id="maincenter" style="margin:0 auto;width:100%;">

<div style="float:left;padding:5px;width:99%">
	<table style="border-collapse: collapse;padding:0px;margin:0px;width:100%">
		<tr>
		   <td valign="top">
				<h1 style="text-align:left; margin: 0px; padding: 0px;margin-right:20px;" id="embedheader"></h1>
		   </td>
			<td width="250px;" valign="top">
				<div style="float:right;">
					<a id="dialoglogo" title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" target="_blank" href="<?php print($CFG->homeAddress);?>">
					<img border="0" alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('logo-header-embed.png'); ?>" />
					</a>
				</div>
				<div style="float:right;margin-top:4px;margin-right:5px;">
					<?php
						global $USER;
						if(isset($USER->userid)){
							echo "<form style='margin:0px; padding:0px;padding-right:3px; float:left;' id='logoutform' action='' method='post'><input style='margin:0px; padding:0px;margin-bottom:3px; border:0px solid transparent; background:transparent;font-family: Arial, Helvetica, sans-serif; font-size: 10pt;' id='logoutsubmit' name='logoutsubmit' type='submit' value='".$LNG->HEADER_SIGN_OUT_LINK_TEXT."' class='active' title='".$LNG->HEADER_SIGN_OUT_LINK_HINT."'></input></form>";
						} else {
							echo "<a title='".$LNG->HEADER_SIGN_IN_LINK_HINT."' target='_blank' href='".$CFG->homeAddress."ui/pages/login.php?fromembed=true' style='margin:0px; padding:0px;padding-right:3px; float:left;'>".$LNG->HEADER_SIGN_IN_LINK_TEXT."</a>";
							if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
								echo " | <a title='".$LNG->HEADER_SIGNUP_OPEN_LINK_HINT."' target='_blank' href='".$CFG->homeAddress."ui/pages/registeropen.php'>".$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT."</a> ";
							} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
								echo " | <a title='".$LNG->HEADER_SIGNUP_REQUEST_LINK_HINT."' target='_blank' href='".$CFG->homeAddress."ui/pages/registerrequest.php'>".$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT."</a> ";
							}
						}
					?>
				</div>
		   </td>
	   </tr>
   </table>
</div>
<!-- div>
    <div style="float:left;padding:5px;">
		<a id="dialoglogo" title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" target="_blank" href="<?php print($CFG->homeAddress);?>">
		<img border="0" alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('logo-header-embed.png'); ?>" />
		</a>
    </div>
    <div style="float: right;">
		<div style="float:right;">
			<div id="menuembed">
				<div style="float:left;">
				<?php
					global $USER;
					if(isset($USER->userid)){
						if($USER->name == ""){
							$name = $USER->getEmail();
						} else {
							$name = $USER->name;
						}
						echo "<div style='float:left;'>".$name." | </div><form style='margin:0px; padding:0px;padding-right:3px; float:left;' id='logoutform' action='' method='post'><input style='margin:0px; padding:0px;margin-bottom:3px; border:0px solid transparent; background:transparent;font-family: Arial, Helvetica, sans-serif; font-size: 10pt;' id='logoutsubmit' name='logoutsubmit' type='submit' value='".$LNG->HEADER_SIGN_OUT_LINK_TEXT."' class='active' title='".$LNG->HEADER_SIGN_OUT_LINK_HINT."'></input></form>";
					} else {
						echo "<form style='margin:0px; padding:0px;padding-right:3px; float:left;' id='loginform' action='' method='post'><input style='margin:0px; padding:0px;margin-bottom:3px; border:0px solid transparent; background:transparent;font-family: Arial, Helvetica, sans-serif; font-size: 10pt;' id='loginsubmit' name='loginsubmit' type='submit' value='".$LNG->HEADER_SIGN_IN_LINK_TEXT."' class='active' title='".$LNG->HEADER_SIGN_IN_LINK_HINT."'></input></form>";
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
							echo " | <a title='".$LNG->HEADER_SIGNUP_OPEN_LINK_HINT."' target='_blank' href='".$CFG->homeAddress."ui/pages/registeropen.php'>".$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT."</a> ";
						} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
							echo " | <a title='".$LNG->HEADER_SIGNUP_REQUEST_LINK_HINT."' target='_blank' href='".$CFG->homeAddress."ui/pages/registerrequest.php'>".$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT."</a> ";
						}
					}
				?>
				</div>
			</div>
		</div>
     </div>
</div -->

<div id="message" class="messagediv"></div>
<div id="prompttext" class="promptbox"></div>
<div id="hgrhint" class="hintRollover" style="position: absolute; visibility:hidden; border: 1px solid gray;overflow:hidden">
	<table width="400" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFED9">
		<tr width="350">
			<td width="350" align="left">
				<span id="globalMessage"></span>
			</td>
		</tr>
	</table>
</div>
<div id="mainembed">
