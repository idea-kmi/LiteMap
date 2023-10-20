<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2015-2023 The Open University UK                              *
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
	checkDashboardAccess('MAP');
	include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

	$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);

	$view = getView($nodeid);
	$node = $view->viewnode;
	$viewnodes = $view->nodes;
	$nodes = array();
	array_push($nodes, $node);

	$checkNodes = array();
	$countj = 0;
	if (is_countable($viewnodes)) {
		$countj = count($viewnodes);
	}
	for ($j=0; $j<$countj;$j++) {
		$viewnode = $viewnodes[$j];
		array_push($nodes, $viewnode->node);
	}

	$json = getStackedAreaData($nodes);
?>

<script type='text/javascript'>
	var NODE_ARGS = new Array();

	Event.observe(window, 'load', function() {
		NODE_ARGS['jsondata'] = <?php echo $json; ?>;

		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-stackedarea.js.php"); ?>', 'map-stats-stackedarea-script');
	});
</script>

<div class="d-flex flex-column">
	<h1><?php echo $dashboarddata[$pageindex][0]; ?></h1>
	<p><?php echo $dashboarddata[$pageindex][5]; ?></p>

	<div id="stackedarea-div" class="d-flex justify-content-left gap-2 statsgraph" style="font-size:10pt"></div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
