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
	 /** Author: Michelle Bachler, KMi, The Open University **/

	include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	checkDashboardAccess('GROUP');
	include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

	$groupid = required_param("groupid",PARAM_ALPHANUMEXT);
	$group = getGroup($groupid);

	$viewset = getViewsByGroup($groupid);
	$views = $viewset->views;
	$count = 0;
	if (is_countable($views)) {
		$count = count($views);
	}
	$cons = array();
	$nodes = array();
	for ($i=0; $i<$count; $i++) {
		$view = $views[$i];

		$conns = $view->connections;
		$countj = 0;
		if (is_countable($conns)) {
			$countj = count($conns);
		}
		for ($j=0; $j<$countj; $j++) {
			$viewconnection = $conns[$j];
			$connection = $viewconnection->connection;
			if (!$connection instanceof Hub_Error) {
				array_push($cons, $connection);
			}
		}

		$allnodes = $view->nodes;
		$countk = 0;
		if (is_countable($allnodes)) {
			$countk = count($allnodes);
		}
		for ($k=0; $k<$countk; $k++) {
			$viewnode = $allnodes[$k];
			$node = $viewnode->node;
			if (!$node instanceof Hub_Error) {
				//error_log($node->role->name);
				array_push($nodes, $node);
			}
		}
	}

	$json = getCirclePackingData($nodes, $cons, $group->name);

	//error_log(print_r($json,true));
?>

<script type='text/javascript'>
	var NODE_ARGS = new Array();

	Event.observe(window, 'load', function() {
		NODE_ARGS['jsondata'] = <?php echo $json; ?>;

		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-circlepacking.js.php"); ?>', 'group-stats-circlepacking-script');
	});
</script>

<div class="d-flex flex-column">
	<h1><?php echo $dashboarddata[$pageindex][0]; ?></h1>
	<p><?php echo $dashboarddata[$pageindex][5]; ?></p>

	<div id="circlepacking-div" class="circlepacking-div d-flex justify-content-center"></div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
