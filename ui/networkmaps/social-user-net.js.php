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

function loadSocialNet() {

	$("tab-content-social").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("tab-content-social").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var graphDiv = new Element('div', {'id':'graphUserDiv', 'style': 'clear:both;float:left'});
	var width = 4000;
	var height = 4000;

	var messagearea = new Element("div", {'id':'netusermessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});

	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerDiv = new Element('div', {'id':'graphUserDiv-outer', 'style': 'border:1px solid gray;clear:both;float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});
	outerDiv.insert(messagearea);
	outerDiv.insert(graphDiv);
	$("tab-content-social").insert(outerDiv);

	forcedirectedGraph = createNewForceDirectedGraphSocial('graphUserDiv', USER_ARGS['userid']);

	// THE KEY
	var keybar = createSocialNetworkGraphKey();
	// THE TOOLBAR
	var toolbar = createSocialGraphToolbar(forcedirectedGraph, "tab-content-social");

	$("tab-content-social").insert({top: toolbar});
	$("tab-content-social").insert({top: keybar});

	//event to resize
	Event.observe(window,"resize",function() {
		resizeFDGraph(forcedirectedGraph, "tab-content-social", false);
	});

 	var size = calulateInitialGraphViewport("tab-content-social");
	outerDiv.style.width = size.width-35+"px";
	outerDiv.style.height = size.height+"px";

	loadSocialData(forcedirectedGraph, toolbar, messagearea);
}

function loadSocialData(forcedirectedGraph, toolbar, messagearea) {

	messagearea.update(getLoading("<?php echo $LNG->NETWORKMAPS_SOCIAL_LOADING_MESSAGE; ?>"));

	var nodetypes = "";

	var count = BASE_TYPES.length;
	for(var i=0; i<count; i++){
		if (i == 0) {
			nodetypes += BASE_TYPES[i];
		} else {
			nodetypes += ","+BASE_TYPES[i];
		}
	}
	count = EVIDENCE_TYPES.length;
	for (var i=0; i < count; i++) {
		nodetypes += ","+EVIDENCE_TYPES[i];
	}

	var args = Object.clone(NODE_ARGS);

	args["scope"] = 'all';
	args["start"] = 0;
    args['max'] = "-1";
    args['orderby'] = 'date'; // so you do not get vote - irrelevant anyway for applet
    args['sort'] = 'DESC';
    args['filternodetypes'] = nodetypes;
    args['linklabels'] = "";
    args['style'] = "short";

	//request to get the current connections
	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbysocial&"+Object.toQueryString(args);

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
				//$('graphConnectionCount').innerHTML = "";
				//$('graphConnectionCount').insert('<span style="font-size:10pt;color:black;float:left;margin-left:20px"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+conns.length+'</span>');

      			//alert("connection count = "+conns.length);
      			if (conns.length > 0) {
      				var connectionadded = false;
	      			for(var i=0; i< conns.length; i++){
	      				var c = conns[i].connection;
						if (addConnectionToFDGraphSocial(c, forcedirectedGraph)) {
							connectionadded = true;
						}
	      			}

					if (connectionadded) {
						computeMostConnectedNode(forcedirectedGraph);
						layoutAndAnimateSocial(forcedirectedGraph, messagearea);
						toolbar.style.display = 'block';
					} else {
						messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
						toolbar.style.display = 'none';
					}
				} else {
					messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
					toolbar.style.display = 'none';
				}
      		}
      	});
}

loadSocialNet();