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

header('Content-Type: text/javascript;');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
?>

var CURRENT_ADD_AREA_NODEID = "";
var DEBATE_TREE_OPEN_ARRAY = new Array();
var DEBATE_TREE_SMALL = true;

var positionedMap = null;
var player = null;
var baseSize = '';

function loadExploreMapNet(){

	$("network-map-div").innerHTML = "";

	var topBitDiv = new Element("div", {'id':'topbit', 'style':'width:100%;height:100%'} );
	$("network-map-div").insert(topBitDiv);

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("network-map-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	/** USED BY VISULAISATION FOR MENU **/
	var mapdescDiv = new Element("div", {'class':'boxshadowsquare', 'id':'mapdescdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:300px;background:#FBFCB4;font-size:10pt'} );
	Event.observe(mapdescDiv,'mouseout',function (event){
		hideBox('mapdescdiv');
	});
	Event.observe(mapdescDiv,'mouseover',function (event){ showBox('mapdescdiv'); });
	$("network-map-div").insert(mapdescDiv);

	var maphintDiv = new Element("div", {'class':'boxshadowsquare', 'id':'maphintdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:200px;background:#FBFCB4;font-size:10pt'} );
	Event.observe(maphintDiv,'mouseout',function (event){
		hideBox('maphintdiv');
	});
	Event.observe(maphintDiv,'mouseover',function (event){ showBox('maphintdiv'); });
	$("network-map-div").insert(maphintDiv);

	/** USED BY THE VISUALISATION FOR THE WEB LINK MENU **/
	var weblinkdiv = new Element("div", {'class':'boxshadowsquare', 'id':'weblinkdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:300px;background:white'} );
	Event.observe(weblinkdiv,'mouseout',function (event){
		hideBox('weblinkdiv');
	});
	Event.observe(weblinkdiv,'mouseover',function (event){ showBox('weblinkdiv'); });
	$("network-map-div").insert(weblinkdiv);

	var maparrowDiv = new Element("div", {'class':'boxshadowsquare', 'id':'maparrowdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:200px;background:white'} );
	Event.observe(maparrowDiv,'mouseout',function (event){
		hideBox('maparrowdiv');
	});
	Event.observe(maparrowDiv,'mouseover',function (event){ showBox('maparrowdiv'); });
	$("network-map-div").insert(maparrowDiv);

	var mapdetailsdiv = new Element("div", {'class':'boxshadowsquaredark', 'id':'mapdetailsdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:380px;height:580px;'} );
	$("network-map-div").insert(mapdetailsdiv);

	// has to be added before it is used to put media player into
	var outerDiv = new Element('div', {'id':'graphMapDiv-outer', 'style': 'display:block;border-top:1px solid gray;clear:both;float:left;width:100%;height100%;'});
	$("network-map-div").insert(outerDiv);

	var mediacontrol = null;
	var mediaDiv = null

	if (NODE_ARGS['media'] != "" || NODE_ARGS['youtubeid'] != "" || NODE_ARGS['vimeoid'] != "") {
		if (NODE_ARGS['media'] && NODE_ARGS['media'] != "") {
			var media = NODE_ARGS['media'];
			var mimetype = NODE_ARGS['mimetype'];
			//alert("mimetype"+mimetype);
			var container = 'video';
			if (mimetype.substring(0,5) == "audio") {
				container = 'audio';
			}
			var supported = browserMediaSupport(mimetype, container);
			NODE_ARGS['mediasupported'] = supported;
			if (supported) {
				var mediaDiv = new Element('div', {'id':'mediaDiv', 'style': 'background-color:black;margin:0 auto;width:500px;clear:both;float:left;overflow:hidden;display:none'});
				if (container == 'video') {
					player = new Element('video', {'id':'player', 'controls': 'true', 'width':NODE_ARGS['moviewidth'], 'height': NODE_ARGS['movieheight']});
					var mediasource = new Element('source', {'src':media, 'type': mimetype});
					mediasource.insert('<?php echo $LNG->MAP_MOVIE_ERROR; ?>');
					player.insert(mediasource);
					mediaDiv.insert(player);
					NODE_ARGS['mediaplayer'] = player;
				} else {
					player = new Element('audio', {'style':'padding-top:10px;', 'id':'player', 'controls': 'true'});
					var mediasource = new Element('source', {'src':media, 'type': mimetype});
					mediasource.insert('<?php echo $LNG->MAP_AUDIO_ERROR; ?>');
					player.insert(mediasource);
					mediaDiv.insert(player);
					NODE_ARGS['mediaplayer'] = player;
				}

				mediacontrol = new Element('div', {'id':'mediacontrolbar', 'style':'float:left;clear:both;background-image:url(\'<?php echo $HUB_FLM->getImagePath("absurdidad.png"); ?>\');width:100%;height:10px;background-repeat:repeat;background-position:left;'});
				Event.observe(mediacontrol,"click", function(){
					toggleMediaBar(false);
				});

				var arrowimg = new Element('img', {'id':'mediacontrolimage', 'style':'margin-left: auto; margin-right: auto;height:8px;display:block;width:16px;', 'src':'<?php echo $HUB_FLM->getImagePath("downarrowbig.gif"); ?>'});
				mediacontrol.insert(arrowimg);
			}
		} else if (NODE_ARGS['youtubeid'] != undefined && NODE_ARGS['youtubeid'] != "") {
			var mediaDiv = new Element('div', {'id':'mediaDiv', 'style': 'width:500px;clear:both;float:left;overflow:hidden;display:none'});
			outerDiv.insert(mediaDiv);

			player = new YT.Player('mediaDiv', {
				width: parseInt(NODE_ARGS['moviewidth']),
				height: parseInt(NODE_ARGS['movieheight']),
				videoId: NODE_ARGS['youtubeid'],
				events: {
					onReady: assignPlayer,
				}
			});

			mediacontrol = new Element('div', {'id':'mediacontrolbar', 'style':'float:left;clear:both;background-image:url(\'<?php echo $HUB_FLM->getImagePath("absurdidad.png"); ?>\');width:100%;height:10px;background-repeat:repeat;background-position:left;'});
			Event.observe(mediacontrol,"click", function(){
				toggleMediaBar(false);
			});

			var arrowimg = new Element('img', {'id':'mediacontrolimage', 'style':'margin-left: auto; margin-right: auto;height:8px;display:block;width:16px;', 'src':'<?php echo $HUB_FLM->getImagePath("downarrowbig.gif"); ?>'});
			mediacontrol.insert(arrowimg);
		} else if (NODE_ARGS['vimeoid'] != undefined && NODE_ARGS['vimeoid'] != "") {
			var mediaDiv = new Element('div', {'id':'mediaDiv', 'style': 'background-color: black; margin:0 auto; width:500px;clear:both;float:left;overflow:hidden;display:none'});
			outerDiv.insert(mediaDiv);

			player = new Vimeo.Player('mediaDiv', {
				width: parseInt(NODE_ARGS['moviewidth']),
				height: parseInt(NODE_ARGS['movieheight']),
				id: NODE_ARGS['vimeoid']
			});

			player.on('loaded', function() {
				assignPlayer();
			});

			mediacontrol = new Element('div', {'id':'mediacontrolbar', 'style':'float:left;clear:both;background-image:url(\'<?php echo $HUB_FLM->getImagePath("absurdidad.png"); ?>\');width:100%;height:10px;background-repeat:repeat;background-position:left;'});
			Event.observe(mediacontrol,"click", function(){
				toggleMediaBar(false);
			});

			var arrowimg = new Element('img', {'id':'mediacontrolimage', 'style':'margin-left: auto; margin-right: auto;height:8px;display:block;width:16px;', 'src':'<?php echo $HUB_FLM->getImagePath("downarrowbig.gif"); ?>'});
			mediacontrol.insert(arrowimg);
		}
	}

	/** ADD GRAPH **/
	var graphDiv = new Element('div', {'id':'graphMapDiv', 'style': 'clear:both;float:left;overflow:hidden'});
	var width = 4000;
	var height = 4000;

	var messagearea = new Element("div", {'id':'netmapmessage','class':'toolbaritem','style':'float:left;clear:both;font-weight:bold'});

	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	outerDiv.insert(messagearea);
	if (mediaDiv && mediacontrol) {
		outerDiv.insert(mediaDiv);
		outerDiv.insert(mediacontrol);
	}
	outerDiv.insert(graphDiv);

	var treeDiv = new Element('div', {'id':'treedata', 'style': 'float:left;height:100%;overflow:auto;background:white;display:none;border-top:1px solid gray;clear:both;float:left;'});
	$("network-map-div").insert(treeDiv);

	var background = "";
	if (NODE_ARGS['backgroundImage']) {
		background = NODE_ARGS['backgroundImage'];
	}
	positionedMap = createNewEmbedMap('graphMapDiv', "", background);

	// THE TOOLBAR
	var toolbar = createEmbedMapGraphToolbar(positionedMap, "network-map-div");
	var toolbarDiv = new Element('div', {'id':'embedtoolbardiv','style': 'float:left;width:100%'});
	toolbarDiv.insert(toolbar);
	topBitDiv.insert({top: toolbarDiv});

	baseSize = calulateInitialGraphViewport("network-map-div");
 	if ($('mediaDiv')) {
 		$('mediaDiv').style.width = baseSize.width+"px";
 		$('mediacontrolbar').style.width = baseSize.width+"px";
 	}

	window.onresize = new function() {
		setMapTreeSize();
	};

	loadMapData(positionedMap, toolbar, messagearea);

	if (player) {
		toggleMediaBar(true);
		window.setInterval(refreshMapDrawing, 25);
	}
}

var lasttime = 0;
function refreshMapDrawing() {
	if (player) {
		var currenttime = mediaPlayerCurrentIndex();
		if (currenttime != lasttime) {
			lasttime = currenttime;
			positionedMap.refresh();
		}
	}
}

function assignPlayer() {
	NODE_ARGS['mediaplayer'] = player;
	mediaPlayerPlay();
    setTimeout(function () {
		mediaPlayerSeek(0);
    }, 1000);
}

function resizeMainArea(initial) {
 	var newwidth = baseSize.width-18;

	if (newwidth == (baseSize.width-18)) {
		newwidth = baseSize.width-14;
	}

	var width = newwidth;
	var height = baseSize.height-44;
	MAP_HEIGHT = height;

 	if ($('mediaDiv')) {
 		$('mediaDiv').style.width = width+"px";
 		$('mediacontrolbar').style.width = width+"px";
 	}

	$('graphMapDiv-outer').style.width = width+"px";
	$('graphMapDiv-outer').style.height = height+"px";

	$('treedata').style.width = width+"px";
	$('treedata').style.height = height+"px";

	// important or all mouse events are off by the amount of the sidebar width.
	if (positionedMap && !initial) {
		relayoutMap(positionedMap);
	}
}

function toggleMediaBar(openMe) {
	if (openMe || $('mediaDiv').style.display == 'none') {
		$('mediaDiv').style.display = 'block';
		$('mediacontrolimage').src = '<?php echo $HUB_FLM->getImagePath("uparrowbig.gif"); ?>';
		resizeMainArea(false);
	} else if ($('mediaDiv').style.display == 'block') {
		$('mediaDiv').style.display = 'none';
		$('mediacontrolimage').src = '<?php echo $HUB_FLM->getImagePath("downarrowbig.gif"); ?>';
		resizeMainArea(false);
	}
}

function setMapTreeSize() {
  	var myWidth = 0, myHeight = 0;
  	if( typeof( window.innerWidth ) == 'number' ) {
    	//Non-IE
    	myWidth = window.innerWidth;
    	myHeight = window.innerHeight;
 	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    	//IE 6+ in 'standards compliant mode'
    	myWidth = document.documentElement.clientWidth;
    	myHeight = document.documentElement.clientHeight;
  	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    	//IE 4 compatible
    	myWidth = document.body.clientWidth;
    	myHeight = document.body.clientHeight;
  	}
  	$('treedata').style.width=myWidth+"px";
  	var titleHeight = parseInt($('mainnodediv').offsetHeight);
  	var toolbarHeight = parseInt($('embedtoolbardiv').offsetHeight);
	$('treedata').style.height=(parseInt(myHeight)-titleHeight-toolbarHeight-5)+"px";
}

function toggleMapTree(button) {
	if ($('treedata').style.display == 'none') {
		document.location.hash = "map-linear";
		$('treedata').style.display = 'block';
		$('graphMapDiv-outer').style.display = 'none';
		button.src = "<?php echo $HUB_FLM->getImagePath('network-graph.png'); ?>";
		button.title = "<?php echo $LNG->NETWORKMAPS_VIEW_MAP; ?>";
		if ($('keydiv')) {
			$('keydiv').style.visibility = 'hidden';
		}
	} else {
		document.location.hash = "map-map";
		$('graphMapDiv-outer').style.display = 'block';
		$('treedata').style.display = 'none';
		button.src = "<?php echo $HUB_FLM->getImagePath('knowledge-tree.png'); ?>";
		button.title = "<?php echo $LNG->NETWORKMAPS_VIEW_LINEAR; ?>";
		if ($('keydiv')) {
			$('keydiv').style.visibility = 'visible';
		}
	}
}

function searchMap(query) {

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=map&format=text&q="+query;
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					NODE_ARGS['searchid'] = searchid;
				}
			}
		});
	}

	var reqUrl = SERVICE_ROOT + "&method=getnodesbyview&viewid="+encodeURIComponent(NODE_ARGS['nodeid'])+"&q="+encodeURIComponent(query);

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

			var nodes = json.nodeset[0].nodes;
			if (nodes.length > 0) {
				var graph = positionedMap.graph;
				for(var i=0; i<nodes.length; i++){
					var node = nodes[i].cnode;

					// UPDATE MAP
					var mapnode = graph.getNode(node.nodeid);
					if (mapnode) {
						mapnode.selected = true;
					}

					// UPDATE TREE
					selectKnowledgeTreeItem(node.nodeid);
				}
			}

			if (nodes.length > 0) {
				positionedMap.refresh();
			} else {
				alert("<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>");
			}
		}
	});
}

function loadMapData(positionedMap, toolbar, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->NETWORKMAPS_LOADING_MESSAGE; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getview&style=map&viewid=" + encodeURIComponent(NODE_ARGS['nodeid']);

	//alert(reqUrl);

	var challengenodeid = "";
	var allConnections = new Array();

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
			var nodes = json.view[0].nodes;

			//alert("nodes: "+nodes.length);
			//alert("conns: "+conns.length);

			if (nodes.length > 0) {
				for(var i=0; i< nodes.length; i++){
					var viewnode = nodes[i].viewnode;

					var node = viewnode.node[0].cnode;
					if (node) {
						var role = node.role[0].role;
						var rolename = role.name;
						addNodeToMap(viewnode, positionedMap);

						if (rolename == "Challenge") {
							positionedMap.root = node.nodeid;
							//challengenodeid = node.nodeid;
						} else if (nodes.length == 1) {
							positionedMap.root = node.nodeid;
						}
					}
				}
			}

			var concount = 0;
			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var viewconnection = conns[i].viewconnection;
					var c = viewconnection.connection[0].connection;
					if (c) {
						allConnections.push(c);
						if (addConnectionToMap(viewconnection, positionedMap)) {
							concount++;
						}
					}
				}
			}

			//$('graphConnectionCount').innerHTML = "";
			//$('graphConnectionCount').insert('<span style="font-size:10pt;color:black;float:left;"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+concount+'</span>');

			if (conns.length > 0 || nodes.length > 0) {

				// Graph needs a root node to be declared or nothing will draw
				if (!positionedMap.root || positionedMap.root == "") {
					computeMostConnectedNode(positionedMap);
				}

				layoutMap(positionedMap, messagearea);
				toolbar.style.display = 'block';

				if (document.location.hash == "#map-linear") {
					toggleMapTree($('toggle-map-view'));
				}

				//if (challengenodeid != "" && allConnections.length > 0) {
					drawTree(allConnections, challengenodeid);
				//}
				setMapTreeSize();
			} else {
				messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
				toolbar.style.display = 'none';
			}
		}
	});
}

function drawTree(allConnections, nodetofocusid) {

	$('treedata').innerHTML="";

// GROUP CONNECTIONS INTO THE NODE TYPES pointed TO - Maps connections reversed

	var treePaths = {};

	var fromNodeCheck = new Array();
	var toNodeCheck = new Array();

	var toNodeConnections = {};

	for(var i=0; i< allConnections.length; i++) {
		var c = allConnections[i];
		if (c) {
			var fN = c.from[0].cnode;
			var tN = c.to[0].cnode;
			var fnRole = c.fromrole[0].role;
			var tnRole = c.to[0].cnode.role[0].role;

			//reverse direction to nest map under from node in linear view
			if (tnRole.name == "Map") {
				var hold = tN;
				c.to[0].cnode = fN;
				c.from[0].cnode = hold;
				var holdrole = tnRole;
				c.fromrole[0].role = holdrole;
				c.torole[0].role = fnRole;

				fN = c.from[0].cnode;
				tN = c.to[0].cnode;
			}

			if (fromNodeCheck.indexOf(fN.nodeid) == -1) {
				fromNodeCheck.push(fN.nodeid);
			}
			if (toNodeCheck.indexOf(tN.nodeid) == -1) {
				toNodeCheck.push(tN.nodeid);
			}

			if (toNodeConnections[tN.nodeid]) {
				toNodeConnections[tN.nodeid].push(c);
			} else {
				toNodeConnections[tN.nodeid] = new Array();
				toNodeConnections[tN.nodeid].push(c);
			}
		}
	}

	var treetops = [];

	toNodeCheck.forEach(function(key) {
		if (-1 === fromNodeCheck.indexOf(key)) {
			treetops.push(key);
		}
	}, this);

	var checkNodes = new Array();
	var treeTopNodes = new Array();

	for(var i=0; i< treetops.length; i++) {
		var tonodeid = treetops[i];

		var myToConnections = toNodeConnections[tonodeid];

		var toNode = "";

		for(var j=0; j<myToConnections.length; j++) {
			var c = myToConnections[j];

			// node to main array once.
			if (j == 0) {
				toNode = c.to[0];
				toNode.cnode['connection'] = c;
				toNode.cnode['handler'] = "";
				toNode.cnode['focalnodeid'] = nodetofocusid;
				toNode.cnode.children = new Array();
				checkNodes[toNode.cnode.nodeid] = toNode.cnode.nodeid;
			}

			var fromNode = c.from[0];
			if (fromNode.cnode.name != "") {
				if (checkNodes.indexOf(fromNode.cnode.nodeid) == -1) {
					fromNode.cnode['connection'] = c;
					fromNode.cnode['handler'] = "";
					fromNode.cnode['focalnodeid'] = nodetofocusid;

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextTreeDepth(fromNode, checkNodes, toNodeConnections, nodetofocusid)
				}
			}
		}

		toNode.cnode.children.sort(alphanodesort);
		treeTopNodes.push(toNode);
	}

	treeTopNodes.sort(alphanodesort);
	if (treeTopNodes.length > 0){
		displayConnectionNodes($('treedata'), treeTopNodes, parseInt(0), true, "mapnarrow");
	}
}

function recurseNextTreeDepth(toNode, checkNodes, toNodeConnections, nodetofocusid) {

	if (toNodeConnections[toNode.cnode.nodeid]) {
		var myToConnections = toNodeConnections[toNode.cnode.nodeid];
		toNode.cnode.children = new Array();

		for(var i=0; i<myToConnections.length; i++) {
			var c = myToConnections[i];
			var fromNode = c.from[0];

			if (fromNode.cnode.nodeid == toNode.cnode.nodeid) {
				continue;
			}

			if (checkNodes.indexOf(fromNode.cnode.nodeid) == -1) {
				if (fromNode.cnode.name != "") {
					fromNode.cnode['connection'] = c;
					fromNode.cnode['handler'] = "";
					fromNode.cnode['focalnodeid'] = nodetofocusid;

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextTreeDepth(fromNode, checkNodes, toNodeConnections, nodetofocusid)
				}
			}
		}

		if (toNode.cnode.children && toNode.cnode.children.length > 1) {
			toNode.cnode.children.sort(alphanodesort);
		}
	}
}

loadExploreMapNet();