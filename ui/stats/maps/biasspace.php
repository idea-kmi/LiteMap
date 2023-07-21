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
require_once($HUB_FLM->getCodeDirPath("core/io/catalyst/analyticservices.php"));
require_once($HUB_FLM->getCodeDirPath("core/io/catalyst/catalyst_jsonld_reader.class.php"));

$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);
$url = $CFG->homeAddress.'api/views/'.$nodeid;
$data = array();
$jitterArray = array(-0.01, -0.02, -0.03, 0, 0.03, 0.02, 0.01);

// GET METRICS
$metric = 'support_space_post_coordinates';
$reply = getMetrics($url, $metric);

$replyObj = json_decode($reply);
if (!isset($replyObj[0]->error)) {

	$groups = array();
	$biasspacedata = $replyObj[0]->data;
	foreach($biasspacedata as $nodearray) {
		$nodeString = $nodearray[0];
		$nodeid = $nodearray[0];
		if (strpos($nodeString, '/') !== FALSE) {
			$bits = explode('/', $nodeString);
			$countbits = 0;
			if (is_countable($bits)) {
				$countbits = count($bits);
			}
			$nodeid = $bits[$countbits-1];
			$node = getNode($nodeid);
			if (!$node instanceof Hub_Error) {
				$nodeString = $node->name;
				$role = $node->role->name;
				$homepage = "";
				if (isset($node->homepage) && $node->homepage != "") {
					$homepage = $node->homepage;
				}

				$next = array(
					"x" => jitterme($nodearray[1]),
					"y" => jitterme($nodearray[2]),
					"size" => 10,
					"shape" => "circle",
					"id" => $nodeid,
					"name" => $nodeString,
					"nodetype" => $role,
					"homepage" => $homepage
				);

				if (!array_key_exists($role, $groups)) {
					$groups[$role] = array();
				}

				array_push($groups[$role], (object)$next);
			}
		}
	}

	foreach($groups as $key => $values) {
		$next = array(
			"key" => $key,
			"values" => $values
		);
		array_push($data, (object)$next);
	}
}

function jitterme($num) {
	global $jitterArray;
	$rand = rand(1, 7);
	$finalnum = $num+$jitterArray[$rand-1];
	return $finalnum;
}

include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));
?>
<script type='text/javascript'>
	var NODE_ARGS = new Array();

	Event.observe(window, 'load', function() {

		NODE_ARGS['data'] = <?php echo json_encode($data, JSON_INVALID_UTF8_IGNORE); ?>;

		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-scatterplot.js.php"); ?>', 'map-stats-scatterplot-script');
	});
</script>

<div class="d-flex flex-column">
	<h1><?php echo $dashboarddata[$pageindex][0]; ?></h1>
	<p><?php echo $dashboarddata[$pageindex][5]; ?></p>
</div>

<div id="scatterplot-div" class="d-flex flex-column"></div>

<?php
include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
