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

function loadScatterPlot(){

	$("scatterplot-div").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("scatterplot-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE VIS ****/
	var scatterplotdiv = new Element('div', {'id':'scatterplotdiv', 'style': 'clear:both;float:left;'});
	var width = 650;
	var height = 650;

	scatterplotdiv.style.width = width+"px";
	scatterplotdiv.style.height = height+"px";

	var messagearea = new Element("div", {'id':'scatterplotmessage','class':'toolbitem','style':'width:580px;float:left;clear:both;font-weight:bold'});
	var outerDiv = new Element('div', {'id':'scatterplotdiv-outer', 'style': 'float:left;overflow:hidden'});

	var detailsarea = new Element("div", {'id':'scatterplotdetails','class':'boxshadowsquare','style':'padding:5px;float:left;width:250px;height:590px;margin-left:30px;margin-top:25px;'});

	var detailsareatitlearea = new Element("div", {'id':'nodelistboxtitle','style':'float:left;width:99%;height:20px;padding:5px;'});
	var detailsareatitle = new Element("h2");
	detailsareatitle.insert('<?php echo $LNG->STATS_SCATTERPLOT_DETAILS; ?>');
	detailsareatitlearea.insert(detailsareatitle);
	detailsarea.insert(detailsareatitlearea);

	var detailsareastats = new Element("div", {'id':'nodelistboxstats','style':'float:left;width:99%;padding:5px;'});
	detailsarea.insert(detailsareastats);

	var boxarea = new Element("div", {'style':'clear:both;float:left;width:100%;height:540px;overflow-y:auto;overflow-x:none'});
	var boxarealist = new Element("div", {'id':'nodelistbox','style':'clear:both;float:left;padding:5px;padding-top:0px;'});
	boxarea.insert(boxarealist);
	detailsarea.insert(boxarea);

	var defaulttext = new Element("div", {'style':'float:left;margin-top:15px;'});
	defaulttext.insert('<?php echo $LNG->STATS_SCATTERPLOT_DETAILS_CLICK; ?>');
	boxarealist.insert(defaulttext);

	outerDiv.insert(messagearea);
	outerDiv.insert(scatterplotdiv);
	outerDiv.insert(detailsarea);

	$("scatterplot-div").insert(outerDiv);

	loadScatterPlotData(messagearea, scatterplotdiv, width);
}

function loadScatterPlotData(messagearea, scatterplotdiv, width) {

	//displayScatterPlotD3VisTest(scatterplotdiv, width)

	messagearea.update(getLoadingLine("<?php echo $LNG->LOADING_DATA; ?>"));

	var data = NODE_ARGS['data'];
 	if (data != "") {
		messagearea.innerHTML="";
		createScatterPlotNVD3Vis(scatterplotdiv, data, width);
		//createScatterPlotMatrixD3Vis(scatterplotdiv, data, width);
	} else {
		if (NODE_ARGS['error']) {
			messagearea.innerHTML=NODE_ARGS['error'];
		} else {
			messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
		}
	}
}

loadScatterPlot();