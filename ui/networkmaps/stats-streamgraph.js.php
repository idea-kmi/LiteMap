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

function loadStreamGraph(){

	$("streamgraph-div").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("streamgraph-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE VIS ****/
	var streamgraphdiv = new Element('div', {'id':'streamgraphdiv', 'style': 'clear:both;float:left;'});
	var width = 980;
	var height = 500;

	streamgraphdiv.style.width = width+"px";
	streamgraphdiv.style.height = height+"px";

	var messagearea = new Element("div", {'id':'streamgraphmessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});
	var outerDiv = new Element('div', {'id':'streamgraphdiv-outer', 'style': 'float:left;overflow:hidden'});

	outerDiv.insert(messagearea);
	outerDiv.insert(streamgraphdiv);

	$("streamgraph-div").insert(outerDiv);

	loadStreamGraphData(messagearea, streamgraphdiv, width);
}

function loadStreamGraphData(messagearea, streamgraphdiv, width) {

	//displayStreamGraphD3VisTest(streamgraphdiv, width);

	messagearea.update(getLoadingLine("<?php echo $LNG->LOADING_DATA; ?>"));

	var data = NODE_ARGS['data'];
 	if (data != "") {
		messagearea.innerHTML="";
		displayStreamGraphNVD3Vis(streamgraphdiv, data, width);
	} else {
		messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
	}
}

loadStreamGraph();