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

var CURRENT_ADD_AREA_NODEID = "";
var DEBATE_TREE_OPEN_ARRAY = new Array();
var DEBATE_TREE_SMALL = true;
var ALERT_WIDTH = '240';
var EDIT_WIDTH = '240';
var MAP_HEIGHT_MINIMUM = 560;
var MAP_HEIGHT = 0;
var ALERT_COUNT = 2;

var positionedMap = null;
var baseSize = '';
var filternodetypes = 'Issue,Solution,Pro,Con,Map';

var player = null;

function loadExploreMapNet(){

	$("network-map-div").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("network-map-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/** USED BY VISULISATION FOR MENU **/
	var mapdescDiv = new Element("div", {'class':'boxshadowsquare', 'id':'mapdescdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:300px;background:#FBFCB4;font-size:10pt'} );
	Event.observe(mapdescDiv,'mouseout',function (event){
		hideBox('mapdescdiv');
	});
	Event.observe(mapdescDiv,'mouseover',function (event){ showBox('mapdescdiv'); });
	$("network-map-div").insert(mapdescDiv);

	/** USED BY VISUALISATION FOR THE HINTS **/
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

	/** USED BY THE VISUALISATION FOR THE CREATION MENU **/
	var maparrowDiv = new Element("div", {'class':'boxshadowsquare', 'id':'maparrowdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:200px;background:white'} );
	Event.observe(maparrowDiv,'mouseout',function (event){
		hideBox('maparrowdiv');
	});
	Event.observe(maparrowDiv,'mouseover',function (event){ showBox('maparrowdiv'); });
	$("network-map-div").insert(maparrowDiv);

	/** USED FOR THE VOTE CHOICE POPUP **/
	var mapvotediv = new Element("div", {'class':'boxshadowsquare', 'id':'mapvotediv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:260px;background:white'} );
	Event.observe(mapvotediv,'mouseout',function (event){
		hideBox('mapvotediv');
	});
	Event.observe(mapvotediv,'mouseover',function (event){ showBox('mapvotediv'); });
	$("network-map-div").insert(mapvotediv);

	/** USED BY THE VISUALISATION FOR THE NODE EXPLORE POPUP **/
	var mapdetailsdiv = new Element("div", {'class':'boxshadowsquaredark', 'id':'mapdetailsdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:390px;height:580px;'} );
	$("network-map-div").insert(mapdetailsdiv);

	/** FOR THE TOOLBAR AREA **/
	var topBitDiv = new Element("div", {'id':'topbit', 'class':'d-block'} );
	$("network-map-div").insert(topBitDiv);

	var messagearea = new Element("div", {'id':'netmapmessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});

	/** Yes, I know, table bad - TABLE IS EASIEST FOR COLLAPSING SIDE ALERT PANEL WHERE WIDTH IS UNKNOWN **/
	var mainTable = new Element('table', {'cellspacing':'0', 'id':'mainDiv','style': 'border:1px solid #C0C0C0;padding:0px;border:collapse:collpase;width:100%;height:100%'});
	$("network-map-div").insert(mainTable);

	var row = new Element('tr', {'style': 'height:100%'});
	mainTable.insert(row);

	// EDIT AREA
	if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
		var editcell = new Element('td', {'id':'editcell', 'width':EDIT_WIDTH, 'style':'font-size:10pt;width:'+EDIT_WIDTH+'px;max-width:'+EDIT_WIDTH+'px;height:100%;vertical-align:top;display:table-cell'});
		row.insert(editcell);

		// EDIT AREA - CONTROL BAR
		var editcontrol = new Element('td', {'id':'editcontrolbar', 'background':'<?php echo $HUB_FLM->getImagePath("absurdidad.png"); ?>', 'align':'center', 'valign':'middle', 'style':'width:8px;max-width:8px;background-repeat:repeat;background-position:left;'});
		row.insert(editcontrol);
		Event.observe(editcontrol,"click", function(){
			toggleEditBar(false);
		});
		var arrowimg = new Element('img', {'id':'editcontrolimage', 'style':'vertical-align:middle', 'src':'<?php echo $HUB_FLM->getImagePath("leftarrowbig.gif"); ?>', 'alt':''});
		editcontrol.insert(arrowimg);
	}

	// MAP GRAPH AND TREE AREA

	var centralcell = new Element('td', {'id':'mapcell', 'style':'overflow:hidden;vertical-align:top;'});
	row.insert(centralcell);

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
				var mediaDiv = new Element('div', {'id':'mediaDiv', 'style': 'background-color:black;margin:0 auto;width:500px;overflow:hidden;display:none'});
				centralcell.insert(mediaDiv);
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
				centralcell.insert(mediacontrol);
				Event.observe(mediacontrol,"click", function(){
					toggleMediaBar(false);
				});

				var arrowimg = new Element('img', {'id':'mediacontrolimage', 'style':'margin-left: auto; margin-right: auto;height:8px;display:block;width:16px;', 'src':'<?php echo $HUB_FLM->getImagePath("downarrowbig.gif"); ?>'});
				mediacontrol.insert(arrowimg);
			}
		} else if (NODE_ARGS['youtubeid'] != undefined && NODE_ARGS['youtubeid'] != "") {
			var mediaDiv = new Element('div', {'id':'mediaDiv', 'style': 'width:500px;overflow:hidden;display:none'});
			centralcell.insert(mediaDiv);

			player = new YT.Player('mediaDiv', {
				width: parseInt(NODE_ARGS['moviewidth']),
				height: parseInt(NODE_ARGS['movieheight']),
				videoId: NODE_ARGS['youtubeid'],
				events: {
					onReady: assignPlayer,
				}
			});

			mediacontrol = new Element('div', {'id':'mediacontrolbar', 'style':'float:left;clear:both;background-image:url(\'<?php echo $HUB_FLM->getImagePath("absurdidad.png"); ?>\');width:100%;height:10px;background-repeat:repeat;background-position:left;'});
			centralcell.insert(mediacontrol);
			Event.observe(mediacontrol,"click", function(){
				toggleMediaBar(false);
			});

			var arrowimg = new Element('img', {'id':'mediacontrolimage', 'style':'margin-left: auto; margin-right: auto;height:8px;display:block;width:16px;', 'src':'<?php echo $HUB_FLM->getImagePath("downarrowbig.gif"); ?>'});
			mediacontrol.insert(arrowimg);
		} else if (NODE_ARGS['vimeoid'] != undefined && NODE_ARGS['vimeoid'] != "") {
			var mediaDiv = new Element('div', {'id':'mediaDiv', 'style': 'background-color: black; margin: 0 auto; width:500px;overflow:hidden;display:none'});
			centralcell.insert(mediaDiv);

			player = new Vimeo.Player('mediaDiv', {
				width: parseInt(NODE_ARGS['moviewidth']),
				height: parseInt(NODE_ARGS['movieheight']),
				id: NODE_ARGS['vimeoid']
			});

			player.on('loaded', function() {
				assignPlayer();
			});

			mediacontrol = new Element('div', {'id':'mediacontrolbar', 'style':'float:left;clear:both;background-image:url(\'<?php echo $HUB_FLM->getImagePath("absurdidad.png"); ?>\');width:100%;height:10px;background-repeat:repeat;background-position:left;'});
			centralcell.insert(mediacontrol);
			Event.observe(mediacontrol,"click", function(){
				toggleMediaBar(false);
			});

			var arrowimg = new Element('img', {'id':'mediacontrolimage', 'style':'margin-left: auto; margin-right: auto;height:8px;display:block;width:16px;', 'src':'<?php echo $HUB_FLM->getImagePath("downarrowbig.gif"); ?>'});
			mediacontrol.insert(arrowimg);
		}
	}

	/** GRAPH AREA **/
	var graphDiv = new Element('div', {'id':'graphMapDiv', 'style': 'overflow:hidden;'});
	var width = 4000;
	var height = 4000;
	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerGraphDiv = new Element('div', {'id':'graphMapDiv-outer', 'style': 'margin-left:0px;margin-bottom:0px;overflow:hidden;'});
	outerGraphDiv.insert(messagearea);
	outerGraphDiv.insert(graphDiv);

	var leftDiv = new Element('div', {'id':'mainInnerDiv', 'style': 'width:100%;height:100%;overflow:hidden;'});
	leftDiv.insert(outerGraphDiv);

	// TREE AREA
	var treeDiv = new Element('div', {'id':'treedata', 'style': 'background:white;display:none;margin-left:0px;margin-bottom:5px;overflow:auto;'});
	leftDiv.insert(treeDiv);
	centralcell.insert(leftDiv);

	<?php if ($CFG->HAS_ALERTS) { ?>
		// ALERT AREA - CONTROL BAR

		var alertcontrol = new Element('td', {'id':'alertcontrolbar', 'background':'<?php echo $HUB_FLM->getImagePath("absurdidad.png"); ?>', 'align':'center', 'valign':'middle', 'style':'width:8px;max-width:8px;background-repeat:repeat;background-position:left;'});
		row.insert(alertcontrol);
		Event.observe(alertcontrol,"click", function(){
			toggleAlertBar(false);
		});

		var arrowimg = new Element('img', {'id':'controlimage', 'style':'vertical-align:middle', 'src':'<?php echo $HUB_FLM->getImagePath("rightarrowbig.gif"); ?>', 'alt':''});
		alertcontrol.insert(arrowimg);

		// ALERT AREA
		var alertcell = new Element('td',{'id':'alertcell', 'width':ALERT_WIDTH, 'style': 'width:'+ALERT_WIDTH+'px;min-width:'+ALERT_WIDTH+'px;height:100%;background:white;vertical-align:top;display:table-cell'});
		row.insert(alertcell);

		var alertDiv = new Element('div', {'id':'alertdiv', 'style': 'width:'+ALERT_WIDTH+'px;padding:5px;background:white;'});
		alertcell.insert(alertDiv);

		var alerttitle = new Element('h2', {'style': 'margin-bottom:0px;padding-bottom:5px;height:30px;'});
		alerttitle.insert('<?php echo $LNG->ALERTS_BOX_TITLE; ?>');
		alertDiv.insert(alerttitle);

		var alertmessagearea = new Element('div', {'id':'alerts-messagearea', 'style': 'width:100%;float:left;clear:both;padding:0px;margin:0px;'});
		alertDiv.insert(alertmessagearea);

		var alertdivinner = new Element('div', {'id':'alertsdivinner', 'style': 'float:left;width:'+ALERT_WIDTH+'px;height:'+(MAP_HEIGHT_MINIMUM-30)+'px;overflow:auto;'});
		alertdivinner.oriheight = (MAP_HEIGHT_MINIMUM-30);
		var useralertDiv = new Element('div', {'id':'useralertdiv', 'style': ''});
		var nodealertDiv = new Element('div', {'id':'nodealertdiv', 'style': ''});
		alertdivinner.insert(useralertDiv);
		alertdivinner.insert(nodealertDiv);
		alertDiv.insert(alertdivinner);
	<?php } ?>

	// LOAD DATA AND CONFIGURE
	// Add graph
	var background = "";
	if (NODE_ARGS['backgroundImage']) {
		background = NODE_ARGS['backgroundImage'];
	}
	positionedMap = createNewMap('graphMapDiv', "", background);

	// THE TOOLBAR
	var toolbar = createMapGraphToolbar(positionedMap, "network-map-div");
	var toolbarDiv = new Element('div', {'id':'toolbardiv','class': 'd-block'});
	toolbarDiv.insert(toolbar);
	topBitDiv.insert({top: toolbarDiv});

	// set size of left cell main content areas
	// IF you don't set the parent graph div size it will be 4000x4000 and push the table cell off screen.
	baseSize = calulateInitialGraphViewport("network-map-div");
	//alert(baseSize.toSource());
	if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
		createEditSidebar(editcell, positionedMap);
	}

	loadMapData(positionedMap, toolbar, messagearea);
	<?php if ($CFG->HAS_ALERTS) { ?>
		loadAlertsData(positionedMap, useralertDiv, useralertDiv, alertmessagearea);
	<?php } ?>

	//event to resize
	Event.observe(window,"resize",function() {
		resizeMainArea(false);
	});

	resizeMainArea(true);

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

function removeAlertBar(){
	if ($('alertcell')) {
		$('alertcell').style.display = 'none';
		$('alertcontrolbar').style.display = 'none';
		if ($('alertbarmenulink')) {
			$('alertbarmenulink').style.display = 'none';
		}
		resizeMainArea(false);
	}
}

function hideEditBar(){
	if ($('editcell')) {
		$('editcell').style.display = 'none';
		$('editcontrolbar').style.display = 'none';
		if ($('editbarmenulink')) {
			$('editbarmenulink').style.display = 'none';
		}
		resizeMainArea(false);
	}
}
function showEditBar(){
	if ($('editcell')) {
		//$('editcell').style.display = 'table-cell';
		$('editcontrolbar').style.display = 'table-cell';
		if ($('editbarmenulink')) {
			$('editbarmenulink').style.display = 'block';
		}
		resizeMainArea(false);
	}
}

function toggleAlertBar(closeMe) {
	if (!closeMe && $('alertcell').style.display == 'none') {
		$('alertcell').style.display = 'table-cell';
		$('controlimage').src = '<?php echo $HUB_FLM->getImagePath("rightarrowbig.gif"); ?>';
		//if ($('editcell')) {
		//	toggleEditBar(true);
		//} else {
			resizeMainArea(false);
		//}
	} else if (closeMe || $('alertcell').style.display == 'table-cell') {
		$('alertcell').style.display = 'none';
		$('controlimage').src = '<?php echo $HUB_FLM->getImagePath("leftarrowbig.gif"); ?>';
		resizeMainArea(false);
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

function toggleEditBar(closeMe) {
	if (!closeMe && $('editcell').style.display == 'none') {
		$('editcell').style.display = 'table-cell';
		$('editcontrolimage').src = '<?php echo $HUB_FLM->getImagePath("leftarrowbig.gif"); ?>';
		//if ($('alertcell')) {
		//	toggleAlertBar(true);
		//} else {
			resizeMainArea(false);
		//}
	} else if (closeMe || $('editcell').style.display == 'table-cell') {
		$('editcell').style.display = 'none';
		$('editcontrolimage').src = '<?php echo $HUB_FLM->getImagePath("rightarrowbig.gif"); ?>';
		resizeMainArea(false);
	}
}

function resizeMainArea(initial) {
	//alert("resize");
 	var newwidth = baseSize.width-14;

	if ($('alertcell') && $('alertcell').style.display == 'table-cell') {
		//alert('here2');
		newwidth = newwidth - $('alertcell').offsetWidth; //ALERT_WIDTH - 10;
	}

	if ($('editcell') && $('editcell').style.display == 'table-cell') {
		//alert('here3');
		newwidth = newwidth - $('editcell').offsetWidth; //EDIT_WIDTH - 10;
	}

	if (($('editcell') && $('editcell').style.display == 'none') &&
			($('alertcell') && $('alertcell').style.display == 'none')) {
		newwidth = baseSize.width-24;
	}

	//if (($('editcell') && $('editcell').style.display == 'table-cell') &&
	//		($('alertcell') && $('alertcell').style.display == 'table-cell')) {
	//	newwidth = newwidth-10;
	//}

	var width = newwidth;
	var height = baseSize.height;
	if ($('mainnodediv').style.display == "block") {
		height -= 220; //top area - varies if in a group
	}
	if (height < MAP_HEIGHT_MINIMUM) {
		height = MAP_HEIGHT_MINIMUM;
	}

	//alert(height);

	MAP_HEIGHT = height;

 	if ($('mediaDiv')) {
 		$('mediaDiv').style.width = width+"px";
 		$('mediacontrolbar').style.width = width+"px";
 	}

	$('graphMapDiv-outer').style.width = width+"px";
	//$('graphMapDiv-outer').style.maxWidth = width+"px";
	$('graphMapDiv-outer').style.height = height+"px";

	$('treedata').style.width = width+"px";
	$('treedata').style.height = height+"px";

	// important or all mouse events are off by the amount of the sidebar width.
	if (positionedMap && !initial) {
		relayoutMap(positionedMap);
	}
}

function toggleMapTree(button) {
	if ($('treedata').style.display == 'none') {
		document.location.hash = "map-linear";

		$('treedata').style.display = 'block';
		$('graphMapDiv-outer').style.display = 'none';
		button.src = "<?php echo $HUB_FLM->getImagePath('network-graph.png'); ?>";
		button.title = "<?php echo $LNG->NETWORKMAPS_VIEW_MAP; ?>";

		hideEditBar();
		//if ($('keydiv')) {
		//	$('keydiv').style.visibility = 'hidden';
		//}
	} else {
		document.location.hash = "map-map";

		$('graphMapDiv-outer').style.display = 'block';
		$('treedata').style.display = 'none';
		button.src = "<?php echo $HUB_FLM->getImagePath('knowledge-tree.png'); ?>";
		button.title = "<?php echo $LNG->NETWORKMAPS_VIEW_LINEAR; ?>";

		showEditBar();
		//if ($('keydiv')) {
		//	$('keydiv').style.visibility = 'visible';
		//}
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

			var blockednodeids = new Array();

			if (nodes.length > 0) {
				for(var i=0; i< nodes.length; i++){
					var viewnode = nodes[i].viewnode;
					var node = viewnode.node[0].cnode;
					if (node) {
						blockednodeids.push(node.nodeid);
						var role = node.role[0].role;
						var rolename = role.name;

						//alert("ADDING TO MAP:"+viewnode.toSource());
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

			NODE_ARGS['blockednodeids'] = blockednodeids;
			if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
				loadEditBarNodes('<?php echo($USER->userid); ?>', 0, 10, 'date', 'DESC');
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

				if (NODE_ARGS['selectednodeid'] != "") {
					setSelectedMapNode(positionedMap, NODE_ARGS['selectednodeid']);
				}
				layoutMap(positionedMap, messagearea);

				if (NODE_ARGS['selectednodeid'] != "") {
					zoomFDFull(positionedMap);
					panToNodeFD(positionedMap, NODE_ARGS['selectednodeid']);
				}
				toolbar.style.display = 'block';
				if (document.location.hash == "#map-linear") {
					toggleMapTree($('toggle-map-view'));
				}

				//if (challengenodeid != "" && allConnections.length > 0) {
					drawTree(allConnections, challengenodeid);
				//}
				setMapTreeSize();
			} else {
				layoutMap(positionedMap, messagearea);
				toolbar.style.display = 'block';
			}
		}
	});
}

function drawTree(allConnections, challengenodeid) {
	$('treedata').update("");

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
				toNode.cnode['focalnodeid'] = challengenodeid;
				toNode.cnode.children = new Array();
				checkNodes[toNode.cnode.nodeid] = toNode.cnode.nodeid;
			}

			var fromNode = c.from[0];
			if (fromNode.cnode.name != "") {
				if (checkNodes.indexOf(fromNode.cnode.nodeid) == -1) {
					fromNode.cnode['connection'] = c;
					fromNode.cnode['handler'] = "";
					fromNode.cnode['focalnodeid'] = challengenodeid;

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextTreeDepth(fromNode, checkNodes, toNodeConnections, challengenodeid)
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

function recurseNextTreeDepth(toNode, checkNodes, toNodeConnections, challengenodeid) {

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
					fromNode.cnode['focalnodeid'] = challengenodeid;

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextTreeDepth(fromNode, checkNodes, toNodeConnections, challengenodeid)
				}
			}
		}

		if (toNode.cnode.children && toNode.cnode.children.length > 1) {
			toNode.cnode.children.sort(alphanodesort);
		}
	}
}

function loadAlertsData(positionedMap, nodealertDiv, useralertDiv, alertmessagearea) {

	alertmessagearea.update(getLoading("<?php echo $LNG->LOADING_MESSAGE; ?>"));

	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.
	args["mapid"] = NODE_ARGS['nodeid'];
	args["url"] = '<?php echo $CFG->homeAddress; ?>api/views/'+NODE_ARGS['nodeid'];
	args["timeout"] = 60;

	var alerts = "";
	alerts += '<?php echo $CFG->ALERT_IGNORED_POST; ?>';
	alerts += ',<?php echo $CFG->ALERT_MATURE_ISSUE; ?>';
	alerts += ',<?php echo $CFG->ALERT_IMMATURE_ISSUE; ?>';
	alerts += ',<?php echo $CFG->ALERT_HOT_POST; ?>';
	alerts += ',<?php echo $CFG->ALERT_ORPHANED_IDEA; ?>';
	alerts += ',<?php echo $CFG->ALERT_EMERGING_WINNER; ?>';
	alerts += ',<?php echo $CFG->ALERT_CONTROVERSIAL_IDEA; ?>';
	alerts += ',<?php echo 	$CFG->ALERT_RATING_IGNORED_ARGUMENT; ?>';
	alerts += ',<?php echo 	$CFG->ALERT_USER_IGNORED_COMPETITORS; ?>';
	alerts += ',<?php echo 	$CFG->ALERT_USER_IGNORED_ARGUMENTS; ?>';
	alerts += ',<?php echo 	$CFG->ALERT_USER_IGNORED_RESPONSES; ?>';

	if (USER && USER != "") {
		args["userids"] = USER;
		alerts += ',<?php echo $CFG->ALERT_UNSEEN_BY_ME; ?>';
		alerts += ',<?php echo $CFG->ALERT_RESPONSE_TO_ME; ?>';
		alerts += ',<?php echo $CFG->ALERT_INTERESTING_TO_ME; ?>';
		alerts += ',<?php echo $CFG->ALERT_UNSEEN_RESPONSE; ?>';
		alerts += ',<?php echo $CFG->ALERT_UNSEEN_COMPETITOR; ?>';
	}
	args["alerts"] = alerts;

	/*
	$CFG->ALERT_UNSEEN_BY_ME = "unseen_by_me";
	$CFG->ALERT_RESPONSE_TO_ME = "response_to_me";
	$CFG->ALERT_UNRATED_BY_ME = "unrated_by_me";
	$CFG->ALERT_LURKING_USER = 'lurking_user';
	$CFG->ALERT_IGNORED_POST = 'ignored_post';
	$CFG->ALERT_MATURE_ISSUE = 'mature_issue';
	$CFG->ALERT_IMMATURE_ISSUE = 'immature_issue';
	$CFG->ALERT_INACTIVE_USER = 'inactive_user';
	$CFG->ALERT_INTERESTING_TO_ME = "interesting_to_me";
	$CFG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME = "interesting_to_people_like_me";
	$CFG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME = "supported_by_people_like_me";
	$CFG->ALERT_HOT_POST = "hot_post";
	$CFG->ALERT_ORPHANED_IDEA = "orphaned_idea";
	$CFG->ALERT_EMERGING_WINNER = "emerging_winner";
	$CFG->ALERT_CONTENTIOUS_ISSUE = "contentious_issue";
	$CFG->ALERT_CONTROVERSIAL_IDEA = "controversial_idea";
	$CFG->ALERT_INCONSISTENT_SUPPORT = "inconsistent_support";
	$CFG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "people_with_interests_like_mine";
	$CFG->ALERT_PEOPLE_WHO_AGREE_WITH_ME = "people_who_agree_with_me";
	$CFG->ALERT_USER_GONE_INACTIVE = "user_gone_inactive";
	$CFG->ALERT_WELL_EVALUATED_IDEA = "well_evaluated_idea";
	$CFG->ALERT_POORLY_EVALUATED_IDEA = "poorly_evaluated_idea";
	$CFG->ALERT_RATING_IGNORED_ARGUMENT = "rating_ignored_argument";
	$CFG->ALERT_UNSEEN_RESPONSE = "unseen_response";
	$CFG->ALERT_UNSEEN_COMPETITOR = "unseen_competitor";
	$CFG->ALERT_USER_IGNORED_COMPETITORS = "user_ignored_competitors";
	$CFG->ALERT_USER_IGNORED_ARGUMENTS = "user_ignored_arguments";
	$CFG->ALERT_USER_IGNORED_RESPONSES = "user_ignored_responses";
	*/

	var reqUrl = SERVICE_ROOT + "&method=getmapalerts&" + Object.toQueryString(args);
	//alert(reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			//alert(transport.responseText);

			var json = null;
			try {
				json = transport.responseText.evalJSON();
			} catch(e) {
				alertmessagearea.innerHTML="";
				removeAlertBar();
				return;
				//alert(e);
			}
			if(json.error){
				alertmessagearea.innerHTML="";
				removeAlertBar();
				return;
				//alert(json.error[0].message);
			}

			var data = json.alertdata[0];
			//alert(data.toSource());
			if (data && (data.alertarray.length > 0 || data.userarray.length > 0)) {
				var alertarray = data.alertarray[0];
				var userarray = data.userarray[0];
				//alert(alertarray.toSource());

				// Process Users
				var usersDataArray = new Array();
				if (data.users) {
					var userObj = data.users[0];
					var userSet = userObj.userset;
					var users = userSet.users;
					for (user in users) {
						if (users[user].user) {
							var cuser = users[user].user;
							if (cuser.profileid) {
								usersDataArray[cuser.profileid] = cuser;
							} else {
								usersDataArray[cuser.userid] = cuser;
							}
						}
					}
				}

				// Process Nodes
				var nodesArray = new Array();
				if (data.nodes) {
					var nodesObj = data.nodes[0];
					var nodeSet = nodesObj.nodeset;
					var nodes = nodeSet.nodes;
					for (node in nodes) {
						if (nodes[node].cnode) {
							var cnode = nodes[node].cnode;
							nodesArray[cnode.nodeid] = cnode;
						}
					}
				}


				// process user specific alerts
				for (userid in userarray) {
					if (userarray.hasOwnProperty(userid)) {
						if (USER && USER === userid) {
							var user = usersDataArray[userid];
							/*if (user.homepage && user.homepage != "") {
								useralertDiv.insert('<br><h2 style="font-size:10pt"><a href="'+user.homepage+'" target="_blank">'+user.name+'</a></h2>');
							} else {
								useralertDiv.insert('<br><h2 style="font-size:10pt">'+user.name+'</h2>');
							}*/

							var alertTypes = userarray[userid][0];
							var i=0;
							for (alerttype in alertTypes) {
								if (alertTypes.hasOwnProperty(alerttype)) {
									//alert(alertype);
									var alertName = getAlertName(alerttype);
									var	title = new Element('div', {'title':getAlertHint(alerttype), 'style':'font-weight:bold;border-top:1px solid #E8E8E8;font-size:12pt'});
									title.insert(alertName);
									var countspan = new Element('span', {'id':'titlecount'+i, 'style':'font-size:10pt; font-weight:normal; padding-left:5px;'});
									title.insert(countspan);
									if (i > 0) {
										title.style.marginTop = '10px';
									} else {
										title.style.marginTop = '0px';
									}
									useralertDiv.insert(title);
									i++;
									var posts = alertTypes[alerttype][0];
									var k=0;
									for (post in posts) {
										if (posts.hasOwnProperty(post)) {
											k++;
											var display = 'block';
											if (k>ALERT_COUNT) {
												display = 'none';
											}
											var postid = posts[post];
											if (nodesArray[postid]) {
												var node = nodesArray[postid];
												createAlertNodeLink(alerttype, postid, node, useralertDiv, display);
											} else if (usersDataArray[postid]) {
												var inneruser = usersDataArray[postid];
												createAlertUserLink(alerttype, postid, inneruser, useralertDiv, display);
											}
										}
									}
									countspan.insert("("+k+")");
									if (k>ALERT_COUNT) {
										var morebutton = new Element('span', {'class':'active','style':'color:#A6156C;margin-bottom:10px;'});
										morebutton.insert('<?php echo $LNG->MAP_ALERT_SHOW_ALL; ?>');
										morebutton.alerttype = alerttype;
										Event.observe(morebutton,"click", function(){
											toggleAlertPosts(this, this.alerttype);
										});
										useralertDiv.insert(morebutton);
									}
								}
							}
						}
					}
				}

				// process map specific alerts
				var i=0;
				for (alerttype in alertarray) {
					if (alertarray.hasOwnProperty(alerttype)) {
						i++;
						var alertName = getAlertName(alerttype);
						var	title = new Element('div', {'title':getAlertHint(alerttype), 'style':'font-weight:bold;border-top:1px solid #E8E8E8;font-size:12pt'});
						title.insert(alertName);
						var countspan = new Element('span', {'id':'titlecount'+i, 'style':'font-size:10pt; font-weight:normal; padding-left:5px;'});
						title.insert(countspan);
						if (i > 0) {
							title.style.marginTop = '10px';
						} else {
							title.style.marginTop = '0px';
						}
						nodealertDiv.insert(title);
						var posts = alertarray[alerttype][0];
						var k=0;
						for (post in posts) {
							if (posts.hasOwnProperty(post)) {
								k++;
								var display = 'block';
								if (k>ALERT_COUNT) {
									display = 'none';
								}
								var postid = posts[post];
								if (nodesArray[postid]) {
									var node = nodesArray[postid];
									createAlertNodeLink(alerttype, postid, node, nodealertDiv, display);
								} else if (usersDataArray[postid]) {
									var inneruser = usersDataArray[postid];
									createAlertUserLink(alerttype, postid, inneruser, nodealertDiv, display);
								}
							}
						}
						countspan.insert("("+k+")");
						if (k>ALERT_COUNT) {
							var morebutton = new Element('div', {'class':'active','style':'color:#A6156C;margin-top:5px;margin-bottom:10px;'});
							morebutton.insert('<?php echo $LNG->MAP_ALERT_SHOW_ALL; ?>');
							morebutton.alerttype = alerttype;
							Event.observe(morebutton,"click", function(){
								toggleAlertPosts(this, this.alerttype);
							});
							nodealertDiv.insert(morebutton);
						}
					}
				}
				alertmessagearea.innerHTML="";
			} else {
				alertmessagearea.innerHTML="<?php echo $LNG->MAP_ALERT_NO_RESULTS; ?>";
			}
		}
	});
}

loadExploreMapNet();