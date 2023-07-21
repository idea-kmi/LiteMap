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
<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/d3-3.4.11/css/d3styles.css"); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/dc.js-1.7.0/dc.css"); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/nvd3-1.1.15-beta/nv.d3.css"); ?>" type="text/css" />

<link rel="icon" href="<?php echo $HUB_FLM->getImagePath("favicon.ico"); ?>" type="images/x-icon" />

<script src="https://www.youtube.com/iframe_api" type="text/javascript"></script>
<script src="https://player.vimeo.com/api/player.js"></script>

<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>
<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/users.js.php'); ?>" type="text/javascript"></script>
<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/widget.js.php'); ?>" type="text/javascript"></script>

<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/jsr_class.js" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>

<!-- JIT VISUALISATIONS CODE -->
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/jit-2.0.2/Jit/jit.js" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/graphlib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/embedpositionedmaplib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/stackedareachartlib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/networklib.js.php" type="text/javascript"></script>

<!-- D3 VISUALISATIONS CODE -->
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/d3-3.4.11/d3.js"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/crossfilter-1.3.9/crossfilter.min.js"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dc.js-1.7.0/dc.min.js"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/nvd3-1.1.15-beta/nv.d3.js"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/d3-tip-0.6.6/index.js"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/circlepackinglib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/scatterplotlib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/streamgraphlib.js.php" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/visualisations/crossfilterlib.js.php" type="text/javascript"></script>

<?php
$custom = $HUB_FLM->getCodeDirPath("ui/headerembedCustom.php");
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

<div style="float:left;padding:5px;width:99%">
	<table style="border-collapse: collapse;padding:0px;margin:0px;width:100%">
		<tr>
		   <td width="90%">
				<h1 style="text-align:left; margin: 0px; padding: 0px;margin-right:20px;" id="embedheader"></h1>
		   </td>
			<td width="10%">
				<a id="dialoglogo" title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" target="_blank" href="<?php print($CFG->homeAddress);?>">
				<img border="0" alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('logo-header-embed.png'); ?>" />
				</a>
		   </td>
	   </tr>
   </table>
</div>

<div id="prompttext" class="promptbox"></div>
<div id="hgrhint" class="hintRollover" style="position: absolute; visibility:hidden; border: 1px solid gray;overflow:hidden">
	<table width="400" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFED9">
		<tr width="350">
			<td width="350" align="left">
				<span id="globalMessage"></span>
			</td>
		</tr>
	</table>
</div>
<div id="mainembed">