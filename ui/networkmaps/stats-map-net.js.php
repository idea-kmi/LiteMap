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

var forcedirectedGraph = null;

function loadExploreMapNet(){

	$("network-map-div").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("network-map-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var graphDiv = new Element('div', {'id':'graphIssueDiv', 'style': 'clear:both;float:left'});
	var width = 4000;
	var height = 4000;

	var messagearea = new Element("div", {'id':'netissuemessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});

	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerDiv = new Element('div', {'id':'graphIssueDiv-outer', 'style': 'border:1px solid gray;clear:both;float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});

	outerDiv.insert(messagearea);
	outerDiv.insert(graphDiv);
	$("network-map-div").insert(outerDiv);

	forcedirectedGraph = createNewForceDirectedGraph('graphIssueDiv', "");

	// THE KEY
	var keybar = createNetworkGraphKey();
	// THE TOOLBAR
	var toolbar = createBasicGraphToolbar(forcedirectedGraph, "network-map-div");

	$("network-map-div").insert({top: toolbar});
	$("network-map-div").insert({top: keybar});

	//event to resize
	Event.observe(window,"resize",function() {
		resizeFDGraph(forcedirectedGraph, "network-map-div", false);
	});

 	var size = calulateInitialGraphViewport("network-map-div");
	outerDiv.style.width = size.width+"px";
	outerDiv.style.height = size.height+"px";

	loadIssueData(forcedirectedGraph, toolbar, messagearea);
}

function loadIssueData(forcedirectedGraph, toolbar, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->NETWORKMAPS_LOADING_MESSAGE; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getview&viewid=" + encodeURIComponent(NODE_ARGS['nodeid']);

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var json = null;
			try {
				json = transport.responseText.evalJSON();
			} catch(e) {
				alert(e);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var conns = json.view[0].connections;

			$('graphConnectionCount').innerHTML = "";
			$('graphConnectionCount').insert('<span style="font-size:10pt;color:black;float:left;margin-left:20px"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+conns.length+'</span>');

			console.log(conns.length);
			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var viewconnection = conns[i].viewconnection;
					var c = viewconnection.connection[0].connection;
					//var c = conns[i].connection;
					addConnectionToFDGraph(c, forcedirectedGraph.graph);
				}
			}

			// were any nodes actually added regardless of what came in?
			let netcount = 0;
			for(var i in forcedirectedGraph.graph.nodes) {
				netcount++;
			}

			if (netcount > 0) {
				var nodes = json.view[0].nodes;
				if (nodes.length > 0) {
					for(var i=0; i< nodes.length; i++){
						var viewnode = nodes[i].viewnode;
						var node = viewnode.node[0].cnode;
						var role = node.role[0].role;
						var rolename = role.name;
						if (rolename == "Challenge") {
							forcedirectedGraph.root = node.nodeid;
						} else if (nodes.length == 1) {
							forcedirectedGraph.root = node.nodeid;
						}
					}
				}

				if (!forcedirectedGraph.root || forcedirectedGraph.root == "") {
					computeMostConnectedNode(forcedirectedGraph);
				}

				layoutAndAnimateFD(forcedirectedGraph, messagearea);
				toolbar.style.display = 'block';
			} else {
				messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
				toolbar.style.display = 'none';
			}
		}
	});
}

loadExploreMapNet();