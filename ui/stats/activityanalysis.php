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

$sdt = trim(optional_param("startdate","",PARAM_TEXT));
$edt = trim(optional_param("enddate","",PARAM_TEXT));

$data = [];
$nodes = array();

if ($sdt != "" && $edt != "") {

	$start = strtotime($sdt);
	$end = strtotime($edt);

	$style = 'shortactivity:'.$start.":".$end;

	$nodeset = getNodesByGlobal(0,-1,'date','ASC', 'Map,Challenge,Issue,Solution,Pro,Con,Argument,Idea', $style);
	$nodes = $nodeset->nodes;

	$data = getActivityAnalysisData($nodes);
}

// global is always the full date range, so does not need restricting by node list.
$dateRange = getActivityDateRange();
?>
<script type='text/javascript'>
var NODE_ARGS = new Array();

Event.observe(window, 'load', function() {
	NODE_ARGS['data'] = <?php echo json_encode($data, JSON_INVALID_UTF8_IGNORE); ?>;

	if (NODE_ARGS['data'].length > 0) {
		document.getElementById("allStatsArea").style.visibility = "visible";
		$('messagearea').update(getLoadingLine("<?php echo $LNG->LOADING_DATA; ?>"));
		displayActivityCrossFilterD3Vis(NODE_ARGS['data'], 980);
	} else {
		document.getElementById("allStatsArea").style.visibility = "hidden";
		<?php if ($sdt != "" && $edt != "") {?>
			$('messagearea').innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
		<?php } ?>
	}
});

function checkForm() {
	//check dates
	var startdate = ($('startdate').value).trim();
	var enddate = ($('enddate').value).trim();

	if (startdate == "") {
		alert("<?php echo $LNG->STATS_START_DATE_ERROR; ?>");
		return false;
	}
	if (enddate == "") {
		alert("<?php echo $LNG->STATS_END_DATE_ERROR; ?>");
		return false;
	}

	if (startdate != "" && enddate != "") {
		var sdate = Date.parse(startdate);
		var edate = Date.parse(enddate);

		if (sdate >= edate) {
			alert("<?php echo $LNG->STATS_START_END_DATE_ERROR; ?>");
			return false;
		}
	}

	$('messagearea').update(getLoadingLine("<?php echo $LNG->LOADING_DATA; ?>"));

	return true;
}
</script>

<form id="dateform" name="dateform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<div id="datediv" class="formrow" style="display: block;padding-top:5px;">
		<label class="formlabelbig" for="startdate"><?php echo $LNG->STATS_START_DATE; ?></label>
		<input class="dateinput" id="startdate" name="startdate" value="<?php if ($sdt != "") { echo date('d M Y H:i',$start); } ?>">
		<img src="<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/cal.gif" onclick="javascript:NewCssCal('<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/','startdate','DDMMMYYYY','dropdown',true,'24')" style="cursor:pointer"/>

		<label style="padding-left:10px;" for="enddate"><b> <?php echo $LNG->STATS_END_DATE; ?> </b></label>
		<input class="dateinput" id="enddate" name="enddate" value="<?php if ($edt != "") { echo date('d M Y H:i',$end); } ?>">
		<img src="<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/cal.gif" onclick="javascript:NewCssCal('<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/','enddate','DDMMMYYYY','dropdown',true,'24')" style="cursor:pointer;"/>

		<span>&nbsp;&nbsp;</span><input type="submit" class="submit" value="<?php echo $LNG->STATS_LOAD_BUTTON; ?>" />
	</div>
	<p><?php echo $LNG->STATS_AVAILABLE_FROM; ?> <b><?php echo date('d M Y H:i',$dateRange->min); ?></b> <?php echo $LNG->STATS_AVAILABLE_TO; ?> <b><?php echo date('d M Y H:i',$dateRange->max); ?></b></p>
	<span><?php echo $LNG->STATS_ACTIVITY_WARNING; ?></span>
</form>

<div id="messagearea" style="padding-top:20px;"></div>

<div id="allStatsArea" style="visibility:hidden;">
	<div class="vishelpdiv">
		<h1 class="vishelpheading"><?php echo $dashboarddata[$pageindex][0]; ?>
			<span><img class="vishelparrow" title="<?php echo $LNG->STATS_DASHBOARD_HELP_HINT; ?>" onclick="if($('vishelp').style.display == 'none') { this.src='<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>'; $('vishelp').style.display='block'; } else {this.src='<?php echo $HUB_FLM->getImagePath('rightarrowbig.gif'); ?>'; $('vishelp').style.display='none'; }" src="<?php echo $HUB_FLM->getImagePath('uparrowbig.gif'); ?>"/></span>
		</h1>
		<div class="boxshadowsquare" id="vishelp" class="vishelpmessage"><?php echo $dashboarddata[$pageindex][5]; ?></div>
	</div>

	<div style="clear:both;float:left;padding:5px;">
		<div style="clear:both;float:left;">
			<div style="clear:both;float:left;height:250px;" id="date-chart">
				<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_DATE_TITLE; ?></div>
			</div>
			<!-- div style="clear:both;float:left;width:100%;height:60px;" id="date-selector-chart"></div -->

			<div style="clear:both;float:left;margin-top:20px;width:100%;">
				<!-- div style="clear:both;float:left;height:200px;" id="month-chart">
					<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_MONTH_TITLE; ?></div>
				</div -->
				<div style="float:left;height:200px;width:200px;" id="days-of-week-chart">
					<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_DAYS_TITLE; ?></div>
				</div>
				<div style="float:left;height:200px;width:200px;margin-left:20px;" id="nodetype-chart">
					<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_ITEM_TYPES_TITLE; ?></div>
				</div>
				<div style="float:left;height:200px;width:200px;margin-left:20px;" id="type-chart">
					<div class="title"><?php echo $LNG->STATS_ACTIVITY_FILTER_TYPES_TITLE; ?></div>
				</div>
				<!-- div style="float:left;height:200px;margin-left:20px;" id="nodetype-nut-chart">
					<div class="title">Item Types (doughnut)</div>
				</div -->
				<!--div style="clear:both;float:left;height:200px;margin-left:20px;margin-top:20px;" id="nodetype-pie-chart">
					<div class="title">Item Types (pie)</div>
				</div -->
			</div>
		</div>

		<div style="clear:both;float:left;margin-top:30px;">
			<div id="data-count">
				<span class="filter-count"></span> <?php echo $LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART1; ?> <span class="total-count"></span> <?php echo $LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART2; ?> | <a
					href="javascript:dc.filterAll(); dc.renderAll();"><?php echo $LNG->STATS_ACTIVITY_RESET_ALL_BUTTON; ?></a>
			</div>
			<table id="data-table" class="table table-hover dc-data-table" style="clear:both;float:left;width:980px">
				<thead>
				<tr class="header">
					<th width="20%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_DATE; ?></th>
					<th width="50%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_TITLE; ?></th>
					<th width="15%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_ITEM_TYPE; ?></th>
					<th width="15%"><?php echo $LNG->STATS_ACTIVITY_COLUMN_TYPE; ?></th>
				</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<?php
include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
