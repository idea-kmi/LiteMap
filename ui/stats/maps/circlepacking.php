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

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);
$view = getView($nodeid);

$cons = array();
$nodes = array();

$conns = $view->connections;
$countj = count($conns);
for ($j=0; $j<$countj; $j++) {
	$viewconnection = $conns[$j];
	$connection = $viewconnection->connection;
	if (!$connection instanceof Error) {
		array_push($cons, $connection);
	}
}

$allnodes = $view->nodes;
$countk = count($allnodes);
for ($k=0; $k<$countk; $k++) {
	$viewnode = $allnodes[$k];
	$node = $viewnode->node;
	if (!$node instanceof Error) {
		array_push($nodes, $node);
	}
}

$json = getCirclePackingData($nodes, $cons);

//error_log(print_r($json,true));
?>
<script type='text/javascript'>
var NODE_ARGS = new Array();

Event.observe(window, 'load', function() {
	NODE_ARGS['jsondata'] = <?php echo $json; ?>;

	var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-circlepacking.js.php"); ?>');
    bObj.buildScriptTag();
    bObj.addScriptTag();
});
</script>

<div class="vishelpdiv">
	<h1 class="vishelpheading"><?php echo $dashboarddata[$pageindex][0]; ?>
		<span><img class="vishelparrow" title="<?php echo $LNG->STATS_DASHBOARD_HELP_HINT; ?>" onclick="if($('vishelp').style.display == 'none') { this.src='<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>'; $('vishelp').style.display='block'; } else {this.src='<?php echo $HUB_FLM->getImagePath('rightarrowbig.gif'); ?>'; $('vishelp').style.display='none'; }" src="<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>"/></span>
	</h1>
	<div class="boxshadowsquare vishelp" id="vishelpmessage"><?php echo $dashboarddata[$pageindex][5]; ?></div>

	<div id="circlepacking-div" class="vismaindiv"></div>
</div>

<?php
include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>