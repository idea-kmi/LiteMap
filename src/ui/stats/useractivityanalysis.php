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

require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

$nodeSet = getNodesByGlobal(0,-1,'date','ASC', 'Map,Challenge,Issue,Solution,Pro,Con', 'shortactivity');
$nodes = $nodeSet->nodes;
$data = getUserActivityAnalysisData($nodes);
?>

<script type='text/javascript'>
var NODE_ARGS = new Array();

Event.observe(window, 'load', function() {
	NODE_ARGS['data'] = <?php echo json_encode($data); ?>;

	$('messagearea').update(getLoadingLine("<?php echo $LNG->LOADING_DATA; ?>"));
	var data = NODE_ARGS['data'];
 	if (data != "") {
		displayUserActivityCrossFilterD3Vis(data, 980);
	} else {
		$('messagearea').innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
	}
});
</script>
<div class="vishelpdiv">
	<h1 class="vishelpheading"><?php echo $dashboarddata[$pageindex][0]; ?>
		<span><img class="vishelparrow" title="<?php echo $LNG->STATS_DASHBOARD_HELP_HINT; ?>" onclick="if($('vishelp').style.display == 'none') { this.src='<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>'; $('vishelp').style.display='block'; } else {this.src='<?php echo $HUB_FLM->getImagePath('rightarrowbig.gif'); ?>'; $('vishelp').style.display='none'; }" src="<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>"/></span>
	</h1>
	<div class="boxshadowsquare" id="vishelp" class="vishelpmessage"><?php echo $dashboarddata[$pageindex][5]; ?></div>
</div>

<div style="clear:both;float:left;padding:5px;margin-left:10px;height:100%;width:100%;">
	<div id="messagearea"></div>

	<div id="keyarea" style="width:100%;height:30px;"></div>

	<div>
  	  	<div style="float:left;clear:both;">
	  	  	<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_USERS_TITLE; ?></div>
		  	<div style="clear:both;height:330px;width:940px;" id="user-chart"></div>
		</div>
	  	<div style="float:left;clear:both;">
			<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_ACTION_TITLE; ?></div>
			<div style="clear:both;height:220px;width:350px;" id="nodetype-chart"></div>
		</div>
	</div>

	<div style="clear:both;float:left;margin-top:20px;">
		<div id="data-count">
			<span class="filter-count"></span> <?php echo $LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART1; ?> <span class="total-count"></span> <?php echo $LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART2; ?> | <a
				href="javascript:dc.filterAll(); dc.renderAll();"><?php echo $LNG->STATS_ACTIVITY_RESET_ALL_BUTTON; ?></a>
		</div>
		<table id="data-table" class="table table-hover dc-data-table" style="float:left;clear:both;width:940px">
			<thead>
			<tr class="header">
				<th width="20%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_DATE; ?></th>
				<th width="15%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_ACTION; ?></th>
				<th width="50%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_TITLE; ?></th>
			</tr>
			</thead>
		</table>
	</div>
</div>


<!-- div style="clear:both;float:left;">
  <div style="clear:both;float:left;height:350px;width:650px;" id="user-chart">
    <div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_USERS_TITLE; ?></div>
  </div>
  <div style="float:left;height:300px;margin-left:20px;width:250px;" id="nodetype-chart">
  	<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_ACTION_TITLE; ?></div>
  </div>
</div>

<div style="clar:both;float:left;margin-top:20px;">
	<div id="data-count">
		<span class="filter-count"></span> <?php echo $LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART1; ?> <span class="total-count"></span> <?php echo $LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART2; ?> | <a
			href="javascript:dc.filterAll(); dc.renderAll();"><?php echo $LNG->STATS_ACTIVITY_RESET_ALL_BUTTON; ?></a>
	</div>
	<table id="data-table" class="table table-hover dc-data-table" style="float:left;width:980px">
		<thead>
		<tr class="header">
			<th width="20%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_DATE; ?></th>
			<th width="15%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_ACTION; ?></th>
			<th width="50%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_TITLE; ?></th>
		</tr>
		</thead>
	</table>
</div -->

<?php
include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>