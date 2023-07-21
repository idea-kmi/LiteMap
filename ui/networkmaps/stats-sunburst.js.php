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
header('Content-Type: text/javascript;');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
?>

var sunburstGraph = null;

function loadExploreGroupSunburst(){

	$("sunburst-div").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("sunburst-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var sunburstdiv = new Element('div', {'id':'sunburstdiv', 'style': 'clear:both;float:left;'});
	var width = 600;
	var height = 600;
	sunburstdiv.style.width = width+"px";
	sunburstdiv.style.height = height+"px";

	var messagearea = new Element("div", {'id':'sunburstmessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});
	var outerDiv = new Element('div', {'id':'sunburstdiv-outer', 'style': 'clear:both;float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});

	outerDiv.insert(messagearea);
	outerDiv.insert(sunburstdiv);
	$("sunburst-div").insert(outerDiv);

	var sunburstInfoOuter = new Element('div', {'class':'boxshadowsquare', 'id':'sunburstinfoouterdiv', 'style': 'float:left;width:320px;height:600px;margin-left:20px;'});
	var sunburstTitleDiv = new Element('div', {'id':'sunbursttitlediv', 'style': 'float:left;width:99%;height:20px;padding:5px;'});
	sunburstTitleDiv.insert('<h2><?php echo $LNG->STATS_GROUP_SUNBURST_DETAILS; ?></h2>');

	var sunburstInfoScrollDiv = new Element('div', {'id':'sunburstinfoscrolldiv', 'style': 'clear:both;float:left;width:100%;height:570px;overflow-y:auto;overflow-x:none'});

	var sunburstInfoDiv = new Element('div', {'id':'sunburstinfodiv', 'style': 'clear:both;float:left;padding:5px;padding-top:0px;'});
	sunburstInfoDiv.insert('<?php echo $LNG->STATS_GROUP_SUNBURST_DETAILS_CLICK; ?>');
	sunburstInfoScrollDiv.insert(sunburstInfoDiv);

	sunburstInfoOuter.insert(sunburstTitleDiv);
	sunburstInfoOuter.insert(sunburstInfoScrollDiv);
	$("sunburst-div").insert(sunburstInfoOuter);

	sunburstGraph = createNewSunburstGraph('sunburstdiv', 'sunburstinfodiv');

	//addSunburstData();

	// THE KEY
	//var keybar = createNetworkGraphKey();
	// THE TOOLBAR
	//var toolbar = createBasicGraphToolbar(sunburstGraph, "sunburst-div");

	//$("sunburst-div").insert({top: toolbar});
	//$("sunburst-div").insert({top: keybar});

	//event to resize
	//Event.observe(window,"resize",function() {
	//	resizeFDGraph(sunburstGraph, "sunburst-div", false);
	//});

 	//var size = calulateInitialGraphViewport("sunburst-div");
 	//alert(size.width+":"+size.height);
	//outerDiv.style.width = size.width+"px";
	//outerDiv.style.height = size.height+"px";

	loadData(sunburstGraph, messagearea);
}

function loadData(sunburstGraph, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->LOADING_DATA; ?>"));

	var jsonnodes = NODE_ARGS['jsonnodes'];
	var jsonusers = NODE_ARGS['jsonusers'];
	var jsoncons = NODE_ARGS['jsoncons'];

	if(jsonnodes.error){
		alert(jsonnodes.error[0].message);
		return;
	}

	var nodes = jsonnodes.nodeset[0].nodes;
	var users = jsonusers.userset[0].users;
	var cons = jsoncons.connectionset[0].connections;

	if (nodes.length > 0) {
		var width = parseFloat(180/nodes.length);
		for(var i=0; i< nodes.length; i++){
			var node = nodes[i].cnode;
			addNodeToSunburst(node, sunburstGraph, width, i+1);
		}
	}

	var allnodes = jsoncons.connectionset[0].totalnodes;
	if (users.length > 0) {

		for(var i=0; i< users.length; i++){
			var user = users[i].user;
			var	procount = parseInt(user.procount);
			var concount = parseInt(user.concount);
			var ideacount = parseInt(user.ideacount);
			var debatecount = parseInt(user.debatecount);

			var total = procount+concount+ideacount+debatecount;
			var width = 0;
			if (total == 1 && allnodes == 1 ) {
				width = 180;
			} else if (total > 0 && allnodes > 0) {
				var percentage = parseFloat((total/allnodes)*100);
				width = parseFloat((180/100)*percentage);
			} else {
				width = parseFloat(180/users.length);
			}

			addUserToSunburst(user, sunburstGraph, width, i+1);
		}
	}

	var biggestcontribution = 0;
	if (cons.length > 0) {
		for(var i=0; i< cons.length; i++){
			var con = cons[i].connection;
			var	procount = parseInt(con.procount);
			var concount = parseInt(con.concount);
			var ideacount = parseInt(con.ideacount);
			var debatecount = parseInt(con.debatecount);
			var total = procount+concount+ideacount+debatecount;
			if (total > biggestcontribution) {
				biggestcontribution = total;
			}
		}
		for(var i=0; i< cons.length; i++){
			var con = cons[i].connection;
			addConnectionToSunburst(biggestcontribution, con, sunburstGraph);
		}
	}

	if (cons.length > 0) {
		messagearea.innerHTML="";
		displaySunburst();
		//toolbar.style.display = 'block';
	} else {
		messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
		//toolbar.style.display = 'none';
	}
}

loadExploreGroupSunburst();