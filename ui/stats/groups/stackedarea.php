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

$groupid = required_param("groupid",PARAM_ALPHANUMEXT);

$nodeset = getNodesByGroup($groupid,0,-1,'date','DESC', '', 'Map', 'mini');
$mapnodes = $nodeset->nodes;
$count = 0;
if (is_countable($mapnodes)) {
	$count = count($mapnodes);
}
$nodesCheck = array();
$nodes = array();
for ($i=0; $i<$count; $i++) {
	$next = $mapnodes[$i];
	$nextnodeset = getViewNodes($next->nodeid,'short');
	$nextnodes = $nextnodeset->nodes;
	$countk = 0;
	if (is_countable($nextnodes)) {
		$countk = count($nextnodes);
	}
	for ($k=0; $k<$countk; $k++) {
		$node = $nextnodes[$k];
		if (!$node instanceof Hub_Error) {
			if (in_array($node->nodeid,$nodesCheck) === FALSE) {
				array_push($nodesCheck, $node->nodeid);
				array_push($nodes, $node);
			}
		}
	}
}

$json = getStackedAreaData($nodes);

?>
<script type='text/javascript'>
var NODE_ARGS = new Array();

Event.observe(window, 'load', function() {
	NODE_ARGS['jsondata'] = <?php echo $json; ?>;
	NODE_ARGS['groupid'] = '<?php echo $groupid; ?>';

	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-stackedarea.js.php"); ?>', 'group-stats-stackedarea-script');
});
</script>

<div class="vishelpdiv">
	<h1 class="vishelpheading"><?php echo $dashboarddata[$pageindex][0]; ?>
		<span><img class="vishelparrow" title="<?php echo $LNG->STATS_DASHBOARD_HELP_HINT; ?>" onclick="if($('vishelp').style.display == 'none') { this.src='<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>'; $('vishelp').style.display='block'; } else {this.src='<?php echo $HUB_FLM->getImagePath('rightarrowbig.gif'); ?>'; $('vishelp').style.display='none'; }" src="<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>"/></span>
	</h1>
	<div class="boxshadowsquare" id="vishelp" class="vishelpmessage"><?php echo $dashboarddata[$pageindex][5]; ?></div>

	<div id="stackedarea-div" class="vismaindiv"></div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>