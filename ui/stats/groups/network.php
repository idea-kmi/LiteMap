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
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

global $CFG;

$groupid = required_param("groupid",PARAM_ALPHANUMEXT);

$args = array();
$args["groupid"] = $groupid;

$argsStr = "{";
$keys = array_keys($args);
$count = 0;
if (is_countable($keys)) {
	$count = count($keys);
}
for($i=0;$i<$count; $i++){
 $argsStr .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
 if ($i != ($count-1)){
	 $argsStr .= ',';
 }
}
$argsStr .= "}";

echo "<script type='text/javascript'>";
echo "var NODE_ARGS = ".$argsStr.";";
echo "</script>";
?>
<script type='text/javascript'>
Event.observe(window, 'load', function() {
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-group-net.js.php"); ?>', 'group-stats-group-net-script');
});
</script>

<div id="visheader" style="float:left;width:100%;margin:5px;margin-right:10px;">
	<h1 class="vishelpheading"><?php echo $dashboarddata[$pageindex][0]; ?>
		<span><img class="vishelparrow" title="<?php echo $LNG->STATS_DASHBOARD_HELP_HINT; ?>" onclick="if($('vishelp').style.display == 'none') { this.src='<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>'; $('vishelp').style.display='block'; } else {this.src='<?php echo $HUB_FLM->getImagePath('rightarrowbig.gif'); ?>'; $('vishelp').style.display='none'; }" src="<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>"/></span>
	</h1>
	<div class="boxshadowsquare" id="vishelp" class="vishelpmessage"><?php echo $dashboarddata[$pageindex][5]; ?></div>
</div>

<div id="network-group-div" style="width:100%;height:100%;"></div>
<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>