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

function loadExploreSearchNet() {

	$("tab-content-search-net").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("tab-content-search-net").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var graphDiv = new Element('div', {'id':'graphSearchDiv', 'style': 'clear:both;float:left'});
	var width = 2000;
	var height = 2000;

	var messagearea = new Element("div", {'id':'netsearchmessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});

	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerDiv = new Element('div', {'id':'graphSearchDiv-outer', 'style': 'border:1px solid gray;clear:both;float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});
	outerDiv.insert(messagearea);
	outerDiv.insert(graphDiv);
	$("tab-content-search-net").insert(outerDiv);

	forcedirectedGraph = createNewForceDirectedGraph('graphSearchDiv', "");

	// THE KEY
	var keybar = createNetworkGraphKey();
	// THE TOOLBAR
	var toolbar = createGraphToolbar(forcedirectedGraph, "tab-content-search-net");

	$("tab-content-search-net").insert({top: toolbar});
	$("tab-content-search-net").insert({top: keybar});

	//event to resize
	Event.observe(window,"resize",function() {
		resizeFDGraph(forcedirectedGraph, "tab-content-search-net", false);
	});

 	var size = calulateInitialGraphViewport("tab-content-search-net");
	outerDiv.style.width = size.width+"px";
	outerDiv.style.height = size.height+"px";

	loadSearchData(forcedirectedGraph, toolbar, messagearea);
}

function loadSearchData(forcedirectedGraph, toolbar, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->NETWORKMAPS_LOADING_MESSAGE; ?>"));

	// GET CONNECTIONS WITH CURRENT SEARCH
	var args = {};
	args["start"] = 0;
    args['max'] = "-1";

    var baseStr = '';
    for (var i=0; i<BASE_TYPES.length; i++) {
    	if (BASE_TYPES[i] != "Idea") {
    		if (baseStr == '') {
    			baseStr = BASE_TYPES[i]
    		} else {
    			baseStr += ','+BASE_TYPES[i];
    		}
    	}
    }

    args['filternodetypes'] = baseStr+","+EVIDENCE_TYPES_STR;
    args['style'] = "mini";
    args['orderby'] = 'date';
	args['q'] = NODE_ARGS['q'];
	args['filterlist'] = 'is related to,supports,challenges,addresses,responds to';
	args['filtergroup'] = ''; // else list ignored.

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbyglobal&" + Object.toQueryString(args);

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

			var conns = json.connectionset[0].connections;

			$('graphConnectionCount').innerHTML = "";
			$('graphConnectionCount').insert('<span style="font-size:10pt;color:black;float:left;margin-left:20px"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+conns.length+'</span>');

			if (conns.length > 0) {
				var mostConnected = "";
				//alert("cons="+conns.length);
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					if (c.from[0].cnode.connectedness > mostConnected) {
						mostConnected = c.from[0].cnode.nodeid;
					}
					if (c.to[0].cnode.connectedness > mostConnected) {
						mostConnected = c.to[0].cnode.nodeid;
					}
				}
				//alert("most connected = "+mostConnected);
				if (mostConnected != "") {
					NODE_ARGS['nodeid'] = mostConnected;
					forcedirectedGraph.root = mostConnected;
				}

				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					addConnectionToFDGraph(c, forcedirectedGraph.graph);

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

loadExploreSearchNet();