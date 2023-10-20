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
?>

<script type='text/javascript'>
	var NODE_ARGS = new Array();

	Event.observe(window, 'load', function() {
		NODE_ARGS['nodeid'] = '<?php echo $nodeid; ?>';

		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/stats-map-net.js.php"); ?>', 'map-stats-map-net-script');
	});
</script>

<div class="d-flex flex-column">
	<h1><?php echo $dashboarddata[$pageindex][0]; ?></h1>
	<p><?php echo $dashboarddata[$pageindex][5]; ?></p>
</div>

<div id="network-map-div" class="d-flex flex-column"></div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
