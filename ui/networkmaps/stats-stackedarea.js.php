<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015 - 2024 The Open University UK                            *
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
header('Content-Type: text/javascript;');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
?>

var stackedAreaChart = null;

function loadExploreGroupStackedArea(){

	$("stackedarea-div").innerHTML = "";

	if (!isCanvasSupported()) {
		$("stackedarea-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	var stackedareadiv = new Element('div', {'id':'stackedareadiv', 'style': 'clear:both;float:left;'});
	var width = 770;
	var height = 600;
	stackedareadiv.style.width = width+"px";
	stackedareadiv.style.height = height+"px";

	var messagearea = new Element("div", {'id':'stackedareamessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});
	var outerDiv = new Element('div', {'id':'stackedareadiv-outer', 'style': 'float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});

	outerDiv.insert(messagearea);
	outerDiv.insert(stackedareadiv);

	var stackedareaInfoOuter = new Element('div', {'class':'boxshadowsquare', 'id':'stackedareaInfoOuterdiv', 'style': 'padding:5px;float:left;width:170px;height:600px;margin-right:5px;'});
	var stackedareaTitleDiv = new Element('div', {'id':'stackedareaTitleDiv', 'style': 'float:left;width:99%;height:20px;padding:5px;'});
	stackedareaTitleDiv.insert('<h2><?php echo $LNG->STATS_GROUP_STACKEDAREA_TITLE; ?></h2>');

	var stackedareaInfoDiv = new Element('div', {'id':'stackedareaInfoDiv', 'style': 'clear:both;float:left;width:165px;padding:2px;padding-top:0px;'});

	stackedareaInfoOuter.insert(stackedareaTitleDiv);
	stackedareaInfoOuter.insert(stackedareaInfoDiv);
	$("stackedarea-div").insert(stackedareaInfoOuter);

	$("stackedarea-div").insert(outerDiv);

	stackedAreaChart = createStackedAreaChart('stackedareadiv');
	loadData(stackedAreaChart, messagearea);

	var listobj = new Element('ul', {'id':'id-list','style':'margin:0px;'});
	stackedareaInfoDiv.insert(listobj);

	//dynamically add legend to list
	var legend = stackedAreaChart.getLegend();
	var listItems = [];
	for(var name in legend) {
	  	listItems.push('<div class=\'query-color\' style=\'width:15px;background-color:'
		  + legend[name] +'\'>&nbsp;</div>' + name);
	}
	listobj.innerHTML = '<li>' + listItems.join('</li><li>') + '</li>';

	stackedareaInfoDiv.insert('<div style="clear:both;padding-top:20px;"><?php echo $LNG->STATS_GROUP_STACKEDAREA_HELP; ?></div>');

	var restoreButton = new Element('div', {'id':'restore','class':'theme button white','style':'clear:both'});
	restoreButton.insert('<?php echo $LNG->STATS_GROUP_STACKEDAREA_RESTORE_BUTTON; ?>');
	Event.observe(restoreButton,'click',function (){
 		stackedAreaChart.restore();
	});
	stackedareaInfoDiv.insert(restoreButton);
}

function loadData(stackedAreaChart, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->LOADING_DATA; ?>"));

	var jsondata = NODE_ARGS['jsondata'];
 	if (jsondata != "") {
		messagearea.innerHTML="";
		displayStackedAreaChart(jsondata);
	} else {
		messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
	}
}

loadExploreGroupStackedArea();