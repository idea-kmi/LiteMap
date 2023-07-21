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

var SELECTED_GRAPH_NODE = "";

var MAP_ROLLOVER_COOKIE_NAME = 'litemaprollovertext';
var MAP_LINKTEXT_COOKIE_NAME = 'litemaplinktext';
var MAP_CURVED_LINKS_NAME = 'litemapcurvedlinks';
var MAP_REPLAY_SPEED_NAME = 'litemapreplayspeedtext';

var mapPlayer = undefined;

/**
 * Set in cookie map replay speed
 */
function setReplaySpeed(newspeed) {
	var speed = 1000;
	if (parseInt(newspeed)) {
		speed = parseInt(newspeed);
	}
	var date = new Date();
	date.setTime(date.getTime()+(365*24*60*60*1000)); // 365 days
	document.cookie = MAP_REPLAY_SPEED_NAME + "=" + speed + "; expires=" + date.toGMTString();
}

/**
 * if set in cookie return map replay speed
 */
function getReplaySpeed() {

	var speed = 1000;

	var allcookies = document.cookie;
	if (allcookies != null) {
		var cookiearray  = allcookies.split(';');

		for(var i=0; i<cookiearray.length; i++){
			var param = cookiearray[i].split('=')
			var name = param[0];
			var value = param[1];
			if (name.trim() == MAP_REPLAY_SPEED_NAME) {
				speed = parseInt(value);
			}
		}
	}

	return speed;
}

/**
 * if set in cookie return
 */
function setNodeRollover(rolloveron) {
	var rollover = 'true';
	if (!rolloveron) {
		rollover = 'false';
	}
	var date = new Date();
	date.setTime(date.getTime()+(365*24*60*60*1000)); // 365 days
	document.cookie = MAP_ROLLOVER_COOKIE_NAME + "=" + rollover + "; expires=" + date.toGMTString();
}

/**
 * if set in cookie return rollover
 */
function getNodeRollover() {

	var rollover = 'true';

	var allcookies = document.cookie;
	if (allcookies != null) {
		var cookiearray  = allcookies.split(';');

		for(var i=0; i<cookiearray.length; i++){
			var param = cookiearray[i].split('=')
			var name = param[0];
			var value = param[1];
			if (name.trim() == MAP_ROLLOVER_COOKIE_NAME) {
				rollover = value;
			}
		}
	}

	return rollover;
}



/**
 * if set in cookie return
 */
function setLinkText(linktextron) {
	var linktext = 'true';
	if (linktextron == false) {
		linktext = 'false'
	}
	var date = new Date();
	date.setTime(date.getTime()+(365*24*60*60*1000)); // 365 days
	document.cookie = (MAP_LINKTEXT_COOKIE_NAME+NODE_ARGS['nodeid'])+ "=" + linktext + "; expires=" + date.toGMTString();
}

/**
 * if set in cookie return rollover
 */
function getLinkText() {

	var linktext = 'true';

	var allcookies = document.cookie;
	if (allcookies != null) {
		var cookiearray  = allcookies.split(';');

		for(var i=0; i<cookiearray.length; i++){
			var param = cookiearray[i].split('=')
			var name = param[0];
			var value = param[1];
			if (name.trim() == (MAP_LINKTEXT_COOKIE_NAME+NODE_ARGS['nodeid'])) {
				linktext = value;
			}
		}
	}

	return linktext;
}

/**
 * if set in cookie return
 */
function setLinkCurve(linkcurveon) {
	var linkcurve = 'false';
	if (linkcurveon == true) {
		linkcurve = 'true'
	}
	var date = new Date();
	date.setTime(date.getTime()+(365*24*60*60*1000)); // 365 days
	document.cookie = (MAP_CURVED_LINKS_NAME+NODE_ARGS['nodeid']) + "=" + linkcurve + "; expires=" + date.toGMTString();
}

/**
 * if set in cookie return rollover
 */
function getLinkCurve() {

	var linkcurve = 'false';

	var allcookies = document.cookie;
	if (allcookies != null) {
		var cookiearray  = allcookies.split(';');

		for(var i=0; i<cookiearray.length; i++){
			var param = cookiearray[i].split('=')
			var name = param[0];
			var value = param[1];
			if (name.trim() == (MAP_CURVED_LINKS_NAME+NODE_ARGS['nodeid'])) {
				linkcurve = value;
			}
		}
	}

	return linkcurve;
}

function createSocialNetworkGraphKey() {
	var tb1 = new Element("div", {'id':'graphkeydivtoolbar','class':'toolbarrow mb-3 mt-3'});

	var key = new Element("div", {'id':'key', 'class':'key d-flex flex-row gap-3'});
	var text = "";
	text += '<div><span class="networkmaps-key key-social-most"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_MOST; ?></span></div>';
	text += '<div><span class="networkmaps-key key-social-high"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_HIGHLY; ?></span></div>';
	text += '<div><span class="networkmaps-key key-social-moderate"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_MODERATELY; ?></span></div>';
	text += '<div><span class="networkmaps-key key-social-slight"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_SLIGHTLY; ?></span></div>';
	text += '<div><span class="networkmaps-key key-social-selected"><?php echo $LNG->NETWORKMAPS_KEY_SELECTED_ITEM; ?></span></div>';

	key.insert(text);
	tb1.insert(key);
	return tb1;
}


/**
 * Create the key for the graph node types etc...
 * @return a div holding the graph key.
 */
function createGroupNetworkGraphKey() {
	var tb1 = new Element("div", {'id':'graphkeydivtoolbar','class':'toolbarrow mb-3'});

	var key = new Element("div", {'id':'key', 'class':'key d-flex flex-row gap-3'});
	var text = "";
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+challengebackpale+';"><?php echo $LNG->CHALLENGE_NAME_SHORT; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+issuebackpale+';"><?php echo $LNG->ISSUE_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+solutionbackpale+';"><?php echo $LNG->SOLUTION_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+probackpale+';"><?php echo $LNG->PRO_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+conbackpale+';"><?php echo $LNG->CON_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+evidencebackpale+';"><?php echo $LNG->ARGUMENT_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+argumentbackpale+';"><?php echo $LNG->COMMENT_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-social-selected"><?php echo $LNG->NETWORKMAPS_KEY_SELECTED_ITEM; ?></span></div>';

	key.insert(text);
	tb1.insert(key);

	var count = new Element("div", {'id':'graphConnectionCount', 'class':'connections-count'});
	key.insert(count);

	return tb1;
}

/**
 * Create the key for the graph node types etc...
 * @return a div holding the graph key.
 */
function createNetworkGraphKey() {
	var tb1 = new Element("div", {'id':'graphkeydivtoolbar','class':'toolbarrow mb-3'});

	var key = new Element("div", {'id':'key', 'class':'key d-flex flex-row gap-3'});
	var text = "";
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+challengebackpale+';"><?php echo $LNG->CHALLENGE_NAME_SHORT; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+issuebackpale+';"><?php echo $LNG->ISSUE_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+solutionbackpale+';"><?php echo $LNG->SOLUTION_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+probackpale+';"><?php echo $LNG->PRO_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+conbackpale+';"><?php echo $LNG->CON_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+evidencebackpale+';"><?php echo $LNG->ARGUMENT_NAME; ?></span></div>';
	text += '<div><span class="networkmaps-key key-network-type" style="background: '+argumentbackpale+';"><?php echo $LNG->COMMENT_NAME; ?></span></div>';

	key.insert(text);
	tb1.insert(key);

	var count = new Element("div", {'id':'graphConnectionCount', 'class':'connections-count'});
	key.insert(count);

	return tb1;
}

/**
 * Create the basic graph toolbar for all network graphs
 */
function createBasicGraphToolbar(forcedirectedGraph, contentarea) {

	var tb2 = new Element("div", {'id':'graphmaintoolbar','class':'graphmaintoolbar toolbarrow col-12'});

	// var tb2 = new Element("div", {'id':'graphmaintoolbar','class':'graphmaintoolbar toolbarrow d-flex flex-row justify-content-between gap-2', });

	
	var graphmaintoolbarButtons = new Element("div", {'id':'graphmaintoolbarButtons','class':'graphmaintoolbarButtons d-flex flex-wrap justify-content-start gap-2 align-items-start' });

	var link = new Element("a", {
		'data-bs-toggle':'collapse',
		'data-bs-target':'.multi-collapse',
		'aria-expanded':'true',
		'aria-controls':'mainnav header footer tabs context',		
		'id':'expandlink', 
		'title':'<?php echo $LNG->NETWORKMAPS_RESIZE_MAP_HINT; ?>', 
		'class':'map-btn'
	});

	link.insert('<span id="linkbuttonsvn"><i class="fas fa-expand-alt fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?></span>');

	var handler = function() {
		if (expandlink.getAttribute("aria-expanded") == "true") {
			$('linkbuttonsvn').update('<i class="fas fa-expand-alt fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?>');
			resizeFDGraph(forcedirectedGraph, contentarea, true);
		} else {
			$('linkbuttonsvn').update('<i class="fas fa-compress-alt fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_REDUCE_MAP_LINK; ?>');
			resizeFDGraph(forcedirectedGraph, contentarea, true);
		}
	};
	Event.observe(link,"click", handler);
	graphmaintoolbarButtons.insert(link);

	var zoomOut = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_OUT_HINT;?>'});
	zoomOut.insert('<span><i class="fas fa-search-minus fa-lg" aria-hidden="true"></i> <?php echo $LNG->GRAPH_ZOOM_OUT_HINT; ?></span>');
	var zoomOuthandler = function() {
		zoomFD(forcedirectedGraph, 5.0);
	};
	Event.observe(zoomOut,"click", zoomOuthandler);
	graphmaintoolbarButtons.insert(zoomOut);

	var zoomIn = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_IN_HINT;?>'});
	zoomIn.insert('<span><i class="fas fa-search-plus fa-lg" aria-hidden="true"></i> <?php echo $LNG->GRAPH_ZOOM_IN_HINT; ?></span>');
	var zoomInhandler = function() {
		zoomFD(forcedirectedGraph, -5.0);
	};
	Event.observe(zoomIn,"click", zoomInhandler);
	graphmaintoolbarButtons.insert(zoomIn);

	var zoom1to1 = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT;?>'});
	zoom1to1.insert('<span><i class="fas fa-search fa-lg" aria-hidden="true"></i> 1:1 focus</span>');
	var zoom1to1handler = function() {
		zoomFDFull(forcedirectedGraph);
	};
	Event.observe(zoom1to1,"click", zoom1to1handler);
	graphmaintoolbarButtons.insert(zoom1to1);

	var zoomFit = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_FIT_HINT;?>'});
	zoomFit.insert('<span><i class="fas fa-expand fa-lg" aria-hidden="true"></i> Fit all</span>');
	var zoomFithandler = function() {
		zoomFDFit(forcedirectedGraph);
	};
	Event.observe(zoomFit,"click", zoomFithandler);
	graphmaintoolbarButtons.insert(zoomFit);

	var printButton = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_PRINT_HINT;?>'});
	printButton.insert('<span><i class="fas fa-print fa-lg" aria-hidden="true"></i> <?php echo $LNG->GRAPH_PRINT_HINT; ?></span>');
	var printButtonhandler = function() {
		printCanvas(forcedirectedGraph);
	};
	Event.observe(printButton,"click", printButtonhandler);
	graphmaintoolbarButtons.insert(printButton);
	tb2.insert(graphmaintoolbarButtons);

	return tb2;
}

/**
 * Create the graph toolbar for Social network graphs
 */
function createSocialGraphToolbar(forcedirectedGraph,contentarea) {

	var tb2 = createBasicGraphToolbar(forcedirectedGraph,contentarea);

	var button3 = new Element("button", {'id':'viewdetailbutton','class':'d-none','title':'<?php echo $LNG->NETWORKMAPS_SOCIAL_ITEM_HINT; ?>'});
	tb2.insert(button3);

	var view3 = new Element("a", {'id':'viewdetaillink', "class":"map-btn", 'title':"<?php echo $LNG->NETWORKMAPS_SOCIAL_ITEM_HINT; ?>"});
	view3.insert('<span id="viewbuttons"><i class="fas fa-user fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_SOCIAL_ITEM_LINK; ?></span>');

	var handler3 = function() {
		var node = getSelectFDNode(forcedirectedGraph);
		if (node != null && node != "") {
			var userid = node.getData('oriuser').userid;
			if (userid != "") {
				viewUserHome(userid);
			} else {
				alert("<?php echo $LNG->NETWORKMAPS_SELECTED_NODEID_ERROR; ?>");
			}
		}
	};
	Event.observe(button3,"click", handler3);
	Event.observe(view3,"click", handler3);
	tb2.insert(view3);

	var button2 = new Element("button", {'id':'viewdetailbutton','class':'d-none', 'title':'<?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT; ?>'});
	tb2.insert(button2);

	var view = new Element("a", {'id':'viewdetaillink', 'class':'map-btn', 'title':"<?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT; ?>"});
	view.insert('<span id="viewbuttons"><i class=\"fas fa-link fa-lg\" aria-hidden=\"true\"></i> <?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_LINK; ?></span>');
	var handler2 = function() {
		var adj = getSelectFDLink(forcedirectedGraph);
		var connectionids = adj.getData('connections');
		if (connectionids != "") {
			showMultiConnections(connectionids);
		} else {
			alert("<?php echo $LNG->NETWORKMAPS_SELECTED_NODEID_ERROR; ?>");
		}
	};
	Event.observe(button2,"click", handler2);
	Event.observe(view,"click", handler2);
	tb2.insert(view);

	return tb2;
}

/**
 * Create the graph toolbar for Node network graphs
 */
function createGraphToolbar(forcedirectedGraph,contentarea) {

	var tb2 = createBasicGraphToolbar(forcedirectedGraph,contentarea);

	var key = new Element("div", {'id':'keydiv', 'class':'key d-flex flex-wrap gap-2 align-items-center my-2'});
	var text = "";
	text += '<div class="networkmaps-key key-network-type" style="background: '+challengebackpale+';"><?php echo $LNG->CHALLENGE_NAME_SHORT; ?></div>';
	text += '<div class="networkmaps-key key-network-type" style="background: '+issuebackpale+';"><?php echo $LNG->ISSUE_NAME; ?></div>';
	text += '<div class="networkmaps-key key-network-type" style="background: '+solutionbackpale+';"><?php echo $LNG->SOLUTION_NAME; ?></div>';
	text += '<div class="networkmaps-key key-network-type" style="background: '+probackpale+';"><?php echo $LNG->PRO_NAME; ?></div>';
	text += '<div class="networkmaps-key key-network-type" style="background: '+conbackpale+';"><?php echo $LNG->CON_NAME; ?></div>';
	text += '<div class="networkmaps-key key-network-type" style="background: '+evidencebackpale+';"><?php echo $LNG->ARGUMENT_NAME; ?></div>';
	text += '<div class="networkmaps-key key-network-type" style="background: '+argumentbackpale+';"><?php echo $LNG->COMMENT_NAME; ?></div>';

	key.insert(text);
	tb2.insert(key);

	var count = new Element("div", {'id':'graphConnectionCount','class':'graphConnectionCount'});
	key.insert(count);

	return tb2;
}

/**
 * Create the graph toolbar for Node network graphs
 */
function createImportGraphToolbar(forcedirectedGraph) {

	var tb2 = new Element("div", {'id':'graphmaintoolbar','class':'toolbarrow', 'style':'padding-top:5px;display:block;'});

	// VIEWS
	var toggleview = new Element("div", {'style':'float:left;margin-top:3px;'});
	var toggleviewicon = new Element("img", {
					'id':'toggle-map-view',
					'class':'active',
					'style':'width:20px; height: 20px;',
					'src':"<?php echo $HUB_FLM->getImagePath('knowledge-tree.png'); ?>",
					'border':'0',
					'title':'<?php echo $LNG->NETWORKMAPS_VIEW_LINEAR; ?>'
				});
	toggleview.insert(toggleviewicon);
	var toggleviewhandler = function() {
		toggleMapTree(toggleviewicon);
	};
	Event.observe(toggleview,"click", toggleviewhandler);
	tb2.insert(toggleview);

	var zoomOut = new Element("div", {'class':'active', 'style':'float:left;padding:3px;margin-left: 20px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_IN_HINT;?>'});
	var zoomOuticon = new Element("img", {'style':'width:20px;height:20px;', 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-minus.png'); ?>", 'alt': 'zoom out'});
	zoomOut.insert(zoomOuticon);
	var zoomOuthandler = function() {
		zoomFD(forcedirectedGraph, 5.0);
	};
	Event.observe(zoomOut,"click", zoomOuthandler);
	tb2.insert(zoomOut);

	var zoomIn = new Element("div", {'class':'active', 'style':'float:left;padding:3px;margin-left: 10px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_OUT_HINT;?>'});
	var zoomInicon = new Element("img", {'style':'width:20px;height:20px;', 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-plus.png'); ?>", 'alt': 'zoom in'});
	zoomIn.insert(zoomInicon);
	var zoomInhandler = function() {
		zoomFD(forcedirectedGraph, -5.0);
	};
	Event.observe(zoomIn,"click", zoomInhandler);
	tb2.insert(zoomIn);

	var zoom1to1 = new Element("div", {'class':'active', 'style':'float:left;margin-left: 10px;padding:3px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT;?>'});
	var zoom1to1icon = new Element("img", {'style':'width:20px;height:20px;', 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-ratio1-1.png'); ?>", 'alt': '1:1 zoom'});
	zoom1to1.insert(zoom1to1icon);
	var zoom1to1handler = function() {
		zoomFDFull(forcedirectedGraph);
	};
	Event.observe(zoom1to1,"click", zoom1to1handler);
	tb2.insert(zoom1to1);

	var zoomFit = new Element("div", {'class':'active', 'style':'float:left;margin-left: 10px;padding:3px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_FIT_HINT;?>'});
	var zoomFiticon = new Element("img", {'style':'width:20px;height:20px;', 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-fit.png'); ?>", 'alt': 'zoom to fit'});
	zoomFit.insert(zoomFiticon);
	var zoomFithandler = function() {
		zoomFDFit(forcedirectedGraph);
	};
	Event.observe(zoomFit,"click", zoomFithandler);
	tb2.insert(zoomFit);

	var key = new Element("div", {'id':'keydiv', 'style':'vertical-align:middle;float:left;margin-top:7px;margin-left:25px;'});
	var text = "";
	text += '<div style="float:left;margin-right:5px;"><span style="padding:3px;background: '+challengebackpale+'; color: black; font-weight:bold"><?php echo $LNG->CHALLENGE_NAME_SHORT; ?></span></div>';
	text += '<div style="float:left;margin-right:5px;"><span style="padding:3px;background: '+issuebackpale+'; color: black; font-weight:bold"><?php echo $LNG->ISSUE_NAME_SHORT; ?></span></div>';
	text += '<div style="float:left;margin-right:5px;"><span style="padding:3px;background: '+solutionbackpale+'; color: black; font-weight:bold"><?php echo $LNG->SOLUTION_NAME_SHORT; ?></span></div>';
	text += '<div style="float:left;margin-right:5px;"><span style="padding:3px;background: '+ideabackpale+'; color: black; font-weight:bold"><?php echo $LNG->COMMENT_NAME; ?></span></div>';
	text += '<div style="float:left;margin-right:5px;"><span style="padding:3px;background: '+argumentbackpale+'; color: black; font-weight:bold"><?php echo $LNG->ARGUMENT_NAME; ?></span></div>';
	text += '<div style="float:left;margin-right:5px;"><span style="padding:3px;background: '+probackpale+'; color: black; font-weight:bold"><?php echo $LNG->PRO_NAME; ?></span></div>';
	text += '<div style="float:left;margin-right:5px;"><span style="padding:3px;background: '+conbackpale+'; color: black; font-weight:bold"><?php echo $LNG->CON_NAME; ?></span></div>';

	key.insert(text);
	tb2.insert(key);

	return tb2;
}

/**
 * Create the graph toolbar for all embedded network graphs
 */
function createEmbedBasicGraphToolbar(forcedirectedGraph, contentarea) {

	var tb2 = new Element("div", {'id':'graphmaintoolbar','class':'toolbarrow', 'style':'padding-top:5px;display:block;'});

	var zoomOut = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;padding:3px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_IN_HINT;?>'});
	var zoomOuticon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-minus.png'); ?>", 'alt': 'zoom out'});
	zoomOut.insert(zoomOuticon);
	var zoomOuthandler = function() {
		zoomFD(forcedirectedGraph, 5.0);
	};
	Event.observe(zoomOut,"click", zoomOuthandler);
	tb2.insert(zoomOut);

	var zoomIn = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;padding:3px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_OUT_HINT;?>'});
	var zoomInicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-plus.png'); ?>", 'alt': 'zoom in'});
	zoomIn.insert(zoomInicon);
	var zoomInhandler = function() {
		zoomFD(forcedirectedGraph, -5.0);
	};
	Event.observe(zoomIn,"click", zoomInhandler);
	tb2.insert(zoomIn);

	var zoom1to1 = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;padding:3px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT;?>'});
	var zoom1to1icon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-ratio1-1.png'); ?>", 'alt': 'zoom 1:1'});
	zoom1to1.insert(zoom1to1icon);
	var zoom1to1handler = function() {
		zoomFDFull(forcedirectedGraph);
	};
	Event.observe(zoom1to1,"click", zoom1to1handler);
	tb2.insert(zoom1to1);

	var zoomFit = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;padding:3px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_FIT_HINT;?>'});
	var zoomFiticon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-fit.png'); ?>", 'alt': 'zoom to fit'});
	zoomFit.insert(zoomFiticon);
	var zoomFithandler = function() {
		zoomFDFit(forcedirectedGraph);
	};
	Event.observe(zoomFit,"click", zoomFithandler);
	tb2.insert(zoomFit);

	var printButton = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;padding:3px;', 'title':'<?php echo $LNG->GRAPH_PRINT_HINT;?>'});
	var printButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('printer.png'); ?>", 'alt': 'print'});
	printButton.insert(printButtonicon);
	var printButtonhandler = function() {
		printCanvas(forcedirectedGraph);
	};
	Event.observe(printButton,"click", printButtonhandler);
	tb2.insert(printButton);

	var count = new Element("div", {'id':'graphConnectionCount','style':'float:left;margin-left-25px;margin-top:7px;'});
	tb2.insert(count);

	return tb2;
}

var lastconnections = "";
function getLastConnections() {
	return lastconnections;
}

/**
 * Create the graph toolbar for Social network graphs
 */
function createEmbedSocialGraphToolbar(forcedirectedGraph,contentarea) {

	var tb2 = createEmbedBasicGraphToolbar(forcedirectedGraph,contentarea);

	var button2 = new Element("button", {'id':'viewdetailbutton','style':'margin-left: 30px;padding:3px;','title':'<?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT; ?>'});
	var icon2 = new Element("img", {'id':'viewdetailicon', 'src':"<?php echo $HUB_FLM->getImagePath('connection.png'); ?>"});
	button2.insert(icon2);
	tb2.insert(button2);

	var view = new Element("a", {'id':'viewdetaillink', 'title':"<?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT; ?>", 'style':'margin-left:5px;cursor:pointer;'});
	view.insert('<span id="viewbuttons"><?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_LINK; ?></span>');
	var handler2 = function() {
		var adj = getSelectFDLink(forcedirectedGraph);
		var connections = adj.getData('connections');
		lastconnections = "";
		if (connections && connections.length > 0) {
			lastconnections = connections;
			windowRef = loadDialog("multiconnections", URL_ROOT+"ui/popups/showmulticonns.php", 790, 450);
		} else {
			alert("<?php echo $LNG->NETWORKMAPS_SELECTED_NODEID_ERROR; ?>");
		}
	};
	Event.observe(button2,"click", handler2);
	Event.observe(view,"click", handler2);
	tb2.insert(view);

	return tb2;
}

/**
 * Calulate the width and height of the visible graph area
 * depending if it is reduced or enlarged at present.
 */
function resizeFDGraph(graphview, contentarea, withInner){
	if ($('header')&& $('header').style.display == "none") {
		var width = $(contentarea).offsetWidth - 35;
		var height = getWindowHeight();
		//alert(height);

		if ($('graphkeydivtoolbar')) {
			height -= $('graphkeydivtoolbar').offsetHeight;
		}
		if ($('graphmaintoolbar')) {
			height -= $('graphmaintoolbar').offsetHeight;
		}
		height -= 20;

		$(graphview.config.injectInto+'-outer').style.width = width+"px";
		$(graphview.config.injectInto+'-outer').style.height = height+"px";

		resizeFDGraphCanvas(graphview, width, height);
		if (typeof resizeMainArea !== 'undefined') {
			baseSize = calulateInitialGraphViewport(contentarea);
			resizeMainArea(false);
		}
	} else {
		var size = calulateInitialGraphViewport(contentarea);
		var width = size.width-35;
		var height = size.height;
		$(graphview.config.injectInto+'-outer').style.width = width+"px";
		$(graphview.config.injectInto+'-outer').style.height = height+"px";

		resizeFDGraphCanvas(graphview, width, height);
		if (typeof resizeMainArea !== 'undefined') {
			baseSize = size;
			resizeMainArea(false);
		}
	}

	// GRAB FOCUS
	graphview.canvas.getPos(true);
}


function calulateInitialGraphViewport(areaname) {
	var w = $(areaname).offsetWidth;
	var h = getWindowHeight();
	//alert(h);

	if ($('header')) {
		h -= $('header').offsetHeight;
	}
	if ($('footer')) {
		h -= $('footer').offsetHeight;
	}

	//Map page
	if ($('mainnodediv')) {
		h -= $('mainnodediv').offsetHeight;
	}
	if ($('parentbar')) {
		h -= $('parentbar').offsetHeight;
	}
	if ($('pageseparatorbar')) {
		h -= $('pageseparatorbar').offsetHeight;
	}

	// The explore views toolbar
	if ($('nodearealineartitle')) {
		h -= $('nodearealineartitle').offsetHeight;
	}
	if ($('headertoolbar')) {
		h -= $('headertoolbar').offsetHeight;
		h -= 30;
	}

	if ($('graphkeydivtoolbar')) {
		h -= $('graphkeydivtoolbar').offsetHeight;
	}
	if ($('graphmaintoolbar')) {
		h -= $('graphmaintoolbar').offsetHeight;
	}

	// Main social Network
	if ($('tabs')) { // Also on Map page
		h -= $('tabs').offsetHeight;
	}
	if ($('tab-content-user-title')) {
		h -= $('tab-content-user-title').offsetHeight;
		h -= 35;
	}
	if ($('tab-content-user-search')) {
		h -= $('tab-content-user-search').offsetHeight;
	}
	if ($('usertabs')) {
		h -= $('usertabs').offsetHeight;
	}

	// User social network
	if ($('context')) {
		h -= $('context').offsetHeight;
	}
	if ($('tab-content-user-bar')) {
		h -= $('tab-content-user-bar').offsetHeight;
		h -= 20;
	}

	//alert(h);
	return {width:w, height:h};
}

/**
 * Called to set the screen to standard view
 */
function reduceMap(contentarea, forcedirectedGraph) {

	// Bootstrap collapse used for component showing and hiding

	baseSize = calulateInitialGraphViewport(contentarea);

	if ($('nodeeditbar') && $('nodeeditbar').style) {
		$('nodeeditbar').style.height = $('nodeeditbar').oriheight+"px";
	}
	if ($('parenttabber') && $('parenttabber').style) {
		$('parenttabber').style.height = $('parenttabber').oriheight+"px";
	}
	if ($('editbarlist') && $('editbarlist').style) {
		$('editbarlist').style.height = $('editbarlist').oriheight+"px";
	}
	if($('alertsdivinner') && $('alertsdivinner').style) {
		$('alertsdivinner').style.height = $('alertsdivinner').oriheight;
	}

	if (typeof resizeMainArea !== 'undefined') {
		resizeMainArea(false);
	}
}

/**
 * Called to remove some screen realestate to increase map area.
 */
function enlargeMap(contentarea, forcedirectedGraph) {

	// Bootstrap collapse used for component showing and hiding

	var w = $(contentarea).offsetWidth;
	var h = getWindowHeight();

	h = h-60;
	baseSize = {width:w, height:h};
	if ($('nodeeditbar') && $('nodeeditbar').style) {
		$('nodeeditbar').style.height = baseSize.height+"px";
	}
	if ($('parenttabber') && $('parenttabber').style) {
		$('parenttabber').style.height = (baseSize.height-91)+"px";
	}
	if($('alertsdivinner') && $('alertsdivinner').style) {
		$('alertsdivinner').style.height = (baseSize.height-45)+"px";
	}
	if ($('tabberinnerdiv') && $('tabberinnerdiv').offsetHeight) {
		var height = baseSize.height-91-$('tabberinnerdiv').offsetHeight-44;
		if ($('editbarlist') && $('editbarlist').style) {
			$('editbarlist').style.height = height+"px";
		}
	}

	if (typeof resizeMainArea !== 'undefined') {
		resizeMainArea(false);
	}
}

/**
 * Called by the Applet to open the applet help
 */
function showHelp() {
    loadDialog('help', URL_ROOT+'ui/pages/networkmap.php', 750, 768);
}

/**
 * Called by the map to go to the home page of the given userid
 */
function viewUserHome(userid) {
	var width = getWindowWidth()-20;
	var height = getWindowHeight()-20;
	loadDialog('userdetails', URL_ROOT+"user.php?userid="+userid, width,height);
}

/**
 * Called by the map to go to the multi connection expanded view for the given connection
 */
function showMultiConnections(connectionids) {
	loadDialog("multiconnections", URL_ROOT+"ui/popups/showmulticonns.php?connectionids="+connectionids, 790, 450);
}

/**
 * Check if the current brwoser supports HTML5 Canvas.
 * Return true if it does, else false.
 */
function isCanvasSupported(){
  	var elem = document.createElement('canvas');
  	return !!(elem.getContext && elem.getContext('2d'));
}

/** LITEMAP SPECIFIC **/

/**
 * Create the editable map graph toolbar for all network graphs
 */
function createMapGraphToolbar(forcedirectedGraph, contentarea) {
	return createBasicMapGraphToolbar(forcedirectedGraph, contentarea, false);
}

/**
 * Create the embedded editable map graph toolbar for all network graphs
 */
function createEmbedEditMapGraphToolbar(forcedirectedGraph, contentarea) {
	return createBasicMapGraphToolbar(forcedirectedGraph, contentarea, true);
}

/**
 * Create the basic graph toolbar for all network graphs
 */
function createBasicMapGraphToolbar(forcedirectedGraph, contentarea, fromEmbed) {

	var tb1 = new Element("div", {'id':'graphmaintoolbar','class':'toolbarrow', 'style':'padding:0px;display:block;'});

	var tb2 = new Element("div", {'id':'graphmaintoolbar','class':'toolbarrow d-flex gap-4 p-2 align-items-center'});

	if (!fromEmbed) {
		var button = new Element("button", {
				'data-bs-toggle':'collapse',
				'data-bs-target':'.multi-collapse',
				'aria-expanded':'true',
				'aria-controls':'mainnav header footer parentbar mainnodediv pageseparatorbar tabs',
				'class':'btn btn-secondary',
				'id':'expandbutton',
				'title':'<?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?>'
		});
		var icon = new Element("img", {'id':'expandicon', 'src':"<?php echo $HUB_FLM->getImagePath('enlarge2.gif'); ?>", 'alt':'<?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?>'});
		button.insert(icon);
		tb2.insert(button);

		var link = new Element("a", {'id':'expandlink', 'title':'<?php echo $LNG->NETWORKMAPS_RESIZE_MAP_HINT; ?>'});
		link.insert('<span id="linkbuttonsvn"><?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?></span>');

		var handler = function() {
			const expandbutton = document.getElementById("expandbutton");
			console.log(expandbutton.getAttribute("aria-expanded"));
			if (expandbutton.getAttribute("aria-expanded") == "true") {
				$('expandbutton').title = '<?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?>';
				$('expandicon').src="<?php echo $HUB_FLM->getImagePath('enlarge2.gif'); ?>";
				reduceMap(contentarea, forcedirectedGraph);
			} else {
				$('expandbutton').title = '<?php echo $LNG->NETWORKMAPS_REDUCE_MAP_LINK; ?>';
				$('expandicon').src="<?php echo $HUB_FLM->getImagePath('reduce.gif'); ?>";
				enlargeMap(contentarea, forcedirectedGraph);
			}
		};
		Event.observe(button,"click", handler);
	}

	if(toggleEditBar && USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
		var embedButton = new Element("button", {'id':'editbarmenulink', 'aria-pressed':'true', 'data-toggle':'button', 'class':'btn btn-secondary', 'title':'<?php echo $LNG->MAP_EDITOR_LINK_HINT; ?>'});
		embedButton.insert('<?php echo $LNG->MAP_EDITOR_LINK; ?>');
		var embedButtonhandler = function() {
			toggleEditBar(false);
		};
		Event.observe(embedButton,"click", embedButtonhandler);
		tb2.insert(embedButton);
	}

	<?php if ($CFG->HAS_ALERTS) {?>
	if (toggleAlertBar) {
		let alertButton = new Element("button", {'id':'alertbarmenulink', 'aria-pressed':'true', 'data-toggle':'button', 'class':'btn btn-secondary', 'title':'<?php echo $LNG->MAP_ALERT_LINK_HINT; ?>'});
		alertButton.insert('<?php echo $LNG->MAP_ALERT_LINK; ?>');
		let alertButtonhandler = function() {
			toggleAlertBar(false);
		};
		Event.observe(alertButton,"click", alertButtonhandler);
		tb2.insert(alertButton);
	}
	<?php } ?>

	var zoomOut = new Element("div", {'class':'active', 'title':'<?php echo $LNG->GRAPH_ZOOM_IN_HINT;?>'});
	var zoomOuticon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-minus.png'); ?>", 'alt': 'zoom out'});
	zoomOut.insert(zoomOuticon);
	var zoomOuthandler = function() {
		zoomFD(forcedirectedGraph, 5.0);
	};
	Event.observe(zoomOut,"click", zoomOuthandler);
	tb2.insert(zoomOut);

	var zoomIn = new Element("div", {'class':'active', 'title':'<?php echo $LNG->GRAPH_ZOOM_OUT_HINT;?>'});
	var zoomInicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-plus.png'); ?>", 'alt': 'zoom in'});
	zoomIn.insert(zoomInicon);
	var zoomInhandler = function() {
		zoomFD(forcedirectedGraph, -5.0);
	};
	Event.observe(zoomIn,"click", zoomInhandler);
	tb2.insert(zoomIn);

	var zoom1to1 = new Element("div", {'class':'active', 'title':'<?php echo $LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT;?>'});
	var zoom1to1icon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-ratio1-1.png'); ?>", 'alt': 'zoom 1:1'});
	zoom1to1.insert(zoom1to1icon);
	var zoom1to1handler = function() {
		zoomFDFull(forcedirectedGraph);
	};
	Event.observe(zoom1to1,"click", zoom1to1handler);
	tb2.insert(zoom1to1);

	var zoomFit = new Element("div", {'class':'active', 'title':'<?php echo $LNG->GRAPH_ZOOM_FIT_HINT;?>'});
	var zoomFiticon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-fit.png'); ?>", 'alt': 'zoom to fit'});
	zoomFit.insert(zoomFiticon);
	var zoomFithandler = function() {
		zoomFDFit(forcedirectedGraph);
	};
	Event.observe(zoomFit,"click", zoomFithandler);
	tb2.insert(zoomFit);

	var noderollover = getNodeRollover();
	var rolloverTitlesChoiceDiv = new Element("div", {'chosen':'true', 'id':'rolloverTitlesChoiceDiv', 'class':'active iconSelected', 'title':'<?php echo $LNG->MAP_TITLE_ROLLOVER_CHOICE_HINT;?>'});
	var rolloverTitlesChoiceIcon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-rollover.png'); ?>", 'alt': 'enable/disable rollover hints'});
	rolloverTitlesChoiceDiv.insert(rolloverTitlesChoiceIcon);
	rolloverTitlesChoiceIcon.chosen = true;
	if (noderollover == 'false') {
		rolloverTitlesChoiceDiv.className = "active iconUnselected";
		rolloverTitlesChoiceDiv.chosen = false;
		forcedirectedGraph.rolloverTitles = false;
	}
	Event.observe(rolloverTitlesChoiceDiv,"click", function(event) {
		if (this.chosen) {
			forcedirectedGraph.rolloverTitles = false;
			this.chosen = false;
			setNodeRollover(false);
			this.className = "active iconUnselected";
		} else {
			forcedirectedGraph.rolloverTitles = true;
			this.chosen = true;
			setNodeRollover(true);
			this.className = "active iconSelected";
		}
	});
	rolloverTitlesChoiceDiv.insert(rolloverTitlesChoiceIcon);
	tb2.insert(rolloverTitlesChoiceDiv);

	var linktext = getLinkText();
	var linktextChoiceDiv = new Element("div", {'chosen':'true','id':'linktextChoiceDiv', 'class':'active iconSelected', 'title':'<?php echo $LNG->MAP_LINK_TEXT_CHOICE_HINT;?>'});
	var linktextChoiceIcon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('linktext.png'); ?>", 'alt': 'enable/disable links'});
	linktextChoiceIcon.chosen = true;
	if (linktext == 'false') {
		linktextChoiceDiv.className = "active iconUnselected";
		linktextChoiceDiv.chosen = false;
		forcedirectedGraph.linkLabelTextOn = false;
	}
	linktextChoiceDiv.insert(linktextChoiceIcon);
	Event.observe(linktextChoiceDiv,"click", function(event) {
		if (this.chosen) {
			forcedirectedGraph.linkLabelTextOn = false;
			this.chosen = false;
			setLinkText(false);
			this.className = "active iconUnselected";
			forcedirectedGraph.refresh();
		} else {
			forcedirectedGraph.linkLabelTextOn = true;
			this.chosen = true;
			setLinkText(true);
			this.className = "active iconSelected";
			forcedirectedGraph.refresh();
		}
	});
	linktextChoiceDiv.insert(linktextChoiceIcon);
	tb2.insert(linktextChoiceDiv);

	var linkcurveChoiceDiv = new Element("div", {'id':'linkcurveChoiceDiv', 'class':'active iconUnselected', 'title':'<?php echo $LNG->MAP_LINK_CURVE_CHOICE_HINT;?>'});
	var linkcurveChoiceIcon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('curvelink24.png'); ?>", 'alt': 'enable/disable curved links'});
	linkcurveChoiceIcon.chosen = false;
	var linkcurve = getLinkCurve();
	if (linkcurve == 'true') {
		forcedirectedGraph.linkCurveOn = true;
		linkcurveChoiceDiv.chosen = false;
		linkcurveChoiceDiv.className = "active iconSelected";
		forcedirectedGraph.refresh();
	}

	linkcurveChoiceDiv.insert(linkcurveChoiceIcon);
	Event.observe(linkcurveChoiceDiv,"click", function(event) {
		if (this.chosen) {
			forcedirectedGraph.linkCurveOn = false;
			this.chosen = false;
			setLinkCurve(false);
			this.className = "active iconUnselected";
			forcedirectedGraph.refresh();
		} else {
			forcedirectedGraph.linkCurveOn = true;
			this.chosen = true;
			setLinkCurve(true);
			this.className = "active iconSelected";
			forcedirectedGraph.refresh();
		}
	});
	linkcurveChoiceDiv.insert(linkcurveChoiceIcon);
	tb2.insert(linkcurveChoiceDiv);

	var printButton = new Element("div", {'class':'active', 'title':'<?php echo $LNG->GRAPH_PRINT_HINT;?>'});
	var printButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('printer.png'); ?>", 'alt': 'print'});
	printButton.insert(printButtonicon);
	var printButtonhandler = function() {
		if ($('treedata').style.display == 'block') {
			printMapKnowledgeTree(NODE_ARGS['nodeid'], NODE_ARGS['title']);
		} else {
			printCanvas(forcedirectedGraph);
		}
	};
	Event.observe(printButton,"click", printButtonhandler);
	tb2.insert(printButton);

	var helpButton = new Element("div", {'class':'active', 'title':'<?php echo $LNG->GRAPH_HELP_HINT;?>'});
	var helpButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('info.png'); ?>", 'alt': 'help'});
	helpButton.insert(helpButtonicon);
	var printButtonhandler = function() {
		showHelp();
	};
	Event.observe(helpButton,"click", printButtonhandler);
	tb2.insert(helpButton);

	var selectAllButton = new Element("div", {'class':'active', 'title':'<?php echo $LNG->MAP_SELECT_ALL_HINT;?>'});
	var selectAllButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('selectall2.png'); ?>", 'alt': 'select all'});
	selectAllButton.insert(selectAllButtonicon);
	var selectAllButtonhandler = function() {
		if (selectAllButton.title == '<?php echo $LNG->MAP_SELECT_ALL_HINT;?>') {
			selectAllButton.title = '<?php echo $LNG->MAP_DESELECT_ALL_HINT;?>';
			selectAllKnowledgeTreeItems();
			selectAllMapNodes(forcedirectedGraph);
		} else {
			selectAllButton.title = '<?php echo $LNG->MAP_SELECT_ALL_HINT;?>';
			clearKnowledgeTreeSelections();
			clearSelectedMapNodes(forcedirectedGraph);
			forcedirectedGraph.refresh();
		}
	};
	Event.observe(selectAllButton,"click", selectAllButtonhandler);
	tb2.insert(selectAllButton);

	/** SEARCH BOX **/
	var searchdiv = new Element("div", {'id':'searchmap', 'class':'d-flex gap-2 align-items-center'});

	var searchfield = new Element("input", {'type':'text', 'class':'form-control', 'id':'qmap', 'name':'qmap', 'value':'', 'aria-label':'search'});
	searchdiv.insert(searchfield);
	Event.observe(searchfield,"keyup", function(event) {
		if(checkKeyPressed(event)) {
			handleMapSearch();
		}
	});

	var buttondiv = new Element('div', {'class':'d-inline-flex'});

	var searchbutton = new Element('img', {'width':'20', 'height':'20', 'class':'active', 'title':'<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>', 'alt':'<?php echo $LNG->HEADER_SEARCH_RUN_ICON_ALT; ?>'});
	searchbutton.src = "<?php echo $HUB_FLM->getImagePath('search.png'); ?>";
	Event.observe(searchbutton,"click", function(event){
		var query = $('qmap').value;
		searchMap(query);
	});
	buttondiv.insert(searchbutton);

	var clearbutton = new Element("img", {
					'class':'active mx-2',
					'width':'20',
					'height':'20',
					'id':'map-clear-button',
					'src':'<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>',
					'title':'<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>',
					'alt':'<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>',
				});
	var clearhandler = function(event) {
		$('qmap').value='';
		// Map
		clearSelectedMapNodes(forcedirectedGraph);
		forcedirectedGraph.refresh();

		//Tree
		clearKnowledgeTreeSelections();
	};
	Event.observe(clearbutton,"click", clearhandler);
	buttondiv.insert(clearbutton);

	searchdiv.insert(buttondiv);

	tb2.insert(searchdiv);

	// VIEWS
	var toggleview = new Element("div", {});
	var toggleviewicon = new Element("img", {
					'id':'toggle-map-view',
					'class':'active',
					'style':'width:20px; height: 20px;',
					'src':"<?php echo $HUB_FLM->getImagePath('knowledge-tree.png'); ?>",
					'border':'0',
					'title':'<?php echo $LNG->NETWORKMAPS_VIEW_LINEAR; ?>'
				});
	toggleview.insert(toggleviewicon);
	var toggleviewhandler = function() {
		toggleMapTree(toggleviewicon);
	};
	Event.observe(toggleview,"click", toggleviewhandler);
	tb2.insert(toggleview);

	var movieModeIcon = new Element("img", {
			'chosen':'false',
			'id':'mediamodebuttondiv',
			'class':'active iconUnselected',
			'data-bs-target': '#moviemaptoolbar',
			'data-bs-toggle':'collapse',
			'aria-expanded':'false',
			'aria-controls':'moviemaptoolbar',
			'src':"<?php echo $HUB_FLM->getImagePath('mediaiconmode.png'); ?>",
			'alt':'toggle replay'
	});
	if (NODE_ARGS['media'] || NODE_ARGS['youtubeid'] || NODE_ARGS['vimeoid']) {
		movieModeIcon.title = '<?php echo $LNG->MAP_MEDIA_MODE_HINT;?>';
	} else {
		movieModeIcon.title = '<?php echo $LNG->MAP_REPLAY_MODE_HINT;?>';
	}

	var movieModeButtonhandler = function(event) {
		if (this.chosen) {
			this.className  = "active iconUnSelected";
		} else {
			this.className = "active iconSelected";
		}

		if (NODE_ARGS['media'] || NODE_ARGS['youtubeid'] || NODE_ARGS['vimeoid']) {
			if (this.chosen) {
				this.chosen = false;
				forcedirectedGraph.mediaReplayMode = false;
				forcedirectedGraph.refresh();
			} else {
				this.chosen = true;
				forcedirectedGraph.mediaReplayMode = true;
				forcedirectedGraph.refresh();
			}
		} else {
			if (this.chosen) {
				if (mapPlayer) {
					clearInterval(mapPlayer);
				}
				clearMapNodeReplayIndexes(forcedirectedGraph);
				this.chosen = false;
				forcedirectedGraph.mapReplayMode = false;
				forcedirectedGraph.mapReplayCurrentIndex = -1;
				$('mapreplayslider').value = 0;
				$('mapreplayslider').max = 0;
				forcedirectedGraph.refresh();
			} else {
				addMapNodeReplayIndexes(forcedirectedGraph);
				this.chosen = true;
				forcedirectedGraph.mapReplayMode = true;
				forcedirectedGraph.mapReplayCurrentIndex = 0;
				$('mapreplayslider').value = 0;
				$('mapreplayslider').max = forcedirectedGraph.mapReplayMaxIndex;
				forcedirectedGraph.refresh();
			}
		}
	};
	Event.observe(movieModeIcon,"click", movieModeButtonhandler);
	tb2.insert(movieModeIcon);

	tb2.insert(createMapMovieBar(forcedirectedGraph));

	// EMBED BUTTONS
	if (!fromEmbed) {
		addEmbedButtons($('tabs'));
	}

	tb1.insert(tb2);

	<?php
		$nowtime = time();
		if ($CFG->TEST_TRIAL_NAME != "" && $nowtime >= $CFG->TEST_TRIAL_START && $nowtime < $CFG->TEST_TRIAL_END) { ?>
			if (fromEmbed) {
				createMapSurvey(tb1);
			}
	<?php } ?>

	return tb1;
}

/**
 * Add the buttons to get the Embed code and JSONLD output
 */
function addEmbedButtons(contentarea) {

	var jsonldButton = new Element("div", {'class':'m-2 ms-auto', 'style':'cursor: pointer', 'title':'<?php echo $LNG->GRAPH_JSONLD_HINT;?>'});
	var jsonldButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('json-ld-data-24.png'); ?>", 'alt':'json LD Data'});
	jsonldButton.insert(jsonldButtonicon);
	var jsonldButtonhandler = function() {
		var code = URL_ROOT+'api/views/'+NODE_ARGS['nodeid'];
		textAreaPrompt('<?php echo $LNG->GRAPH_JSONLD_MESSAGE; ?>', code, "", "", "");
	};
	Event.observe(jsonldButton,"click", jsonldButtonhandler);
	contentarea.insert(jsonldButton);

	var embedButton = new Element("div", {'class':'active m-2', 'style':'cursor: pointer', 'title':'<?php echo $LNG->GRAPH_EMBEDEDIT_HINT;?>'});
	var embedButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('embededit.png'); ?>", 'alt':'embed edit'});
	embedButton.insert(embedButtonicon);
	var embedButtonhandler = function() {
		var code = '<iframe src="<?php echo $CFG->homeAddress; ?>ui/embed/editmap.php?lang=<?php echo $CFG->language; ?>&id='+NODE_ARGS['nodeid']+'" width="900" height="700" scrolling="no" frameborder="1"></iframe>';
		textAreaPrompt('<?php echo $LNG->GRAPH_EMBEDEDIT_MESSAGE; ?>', code, "", "", "", 400, 300);
	};
	Event.observe(embedButton,"click", embedButtonhandler);
	contentarea.insert(embedButton);

	var embedButton = new Element("div", {'class':'active m-2', 'style':'cursor: pointer', 'title':'<?php echo $LNG->GRAPH_EMBED_HINT;?>'});
	var embedButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('embed.png'); ?>", 'alt':'embed'});
	embedButton.insert(embedButtonicon);
	var embedButtonhandler = function() {
		var code = '<iframe src="<?php echo $CFG->homeAddress; ?>ui/embed/map.php?lang=<?php echo $CFG->language; ?>&id='+NODE_ARGS['nodeid']+'" width="900" height="700" scrolling="no" frameborder="1"></iframe>';
		textAreaPrompt('<?php echo $LNG->GRAPH_EMBED_MESSAGE; ?>', code, "", "", "");
	};
	Event.observe(embedButton,"click", embedButtonhandler);
	contentarea.insert(embedButton);
}

/**
 * Create the graph toolbar for all embedded network graphs
 */
function createEmbedMapGraphToolbar(forcedirectedGraph, contentarea) {

	var tb2 = new Element("div", {'id':'graphmaintoolbar','class':'toolbarrow', 'style':'padding-top:5px;display:block;'});

	var zoomOut = new Element("div", {'class':'active','style':'float:left;', 'title':'<?php echo $LNG->GRAPH_ZOOM_IN_HINT;?>'});
	var zoomOuticon = new Element("img", { 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-minus.png'); ?>", 'alt': 'zoom out'});
	zoomOut.insert(zoomOuticon);
	var zoomOuthandler = function() {
		zoomFD(forcedirectedGraph, 5.0);
	};
	Event.observe(zoomOut,"click", zoomOuthandler);
	tb2.insert(zoomOut);

	var zoomIn = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_OUT_HINT;?>'});
	var zoomInicon = new Element("img", { 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-plus.png'); ?>", 'alt': 'zoom in'});
	zoomIn.insert(zoomInicon);
	var zoomInhandler = function() {
		zoomFD(forcedirectedGraph, -5.0);
	};
	Event.observe(zoomIn,"click", zoomInhandler);
	tb2.insert(zoomIn);

	var zoom1to1 = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT;?>'});
	var zoom1to1icon = new Element("img", { 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-ratio1-1.png'); ?>", 'alt': 'zoom 1:1'});
	zoom1to1.insert(zoom1to1icon);
	var zoom1to1handler = function() {
		zoomFDFull(forcedirectedGraph);
	};
	Event.observe(zoom1to1,"click", zoom1to1handler);
	tb2.insert(zoom1to1);

	var zoomFit = new Element("div", {'class':'active','style':'float:left;margin-left: 10px;', 'title':'<?php echo $LNG->GRAPH_ZOOM_FIT_HINT;?>'});
	var zoomFiticon = new Element("img", { 'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-fit.png'); ?>", 'alt': 'zoom to fit'});
	zoomFit.insert(zoomFiticon);
	var zoomFithandler = function() {
		zoomFDFit(forcedirectedGraph);
	};
	Event.observe(zoomFit,"click", zoomFithandler);
	tb2.insert(zoomFit);

	var noderollover = getNodeRollover();
	var rolloverTitlesChoiceDiv = new Element("div", {'chosen':'true', 'id':'rolloverTitlesChoiceDiv', 'class':'active iconSelected',  'title':'<?php echo $LNG->MAP_TITLE_ROLLOVER_CHOICE_HINT;?>'});
	var rolloverTitlesChoiceIcon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-rollover.png'); ?>", 'alt': 'enable/disable rollover hints'});
	rolloverTitlesChoiceDiv.insert(rolloverTitlesChoiceIcon);
	rolloverTitlesChoiceIcon.chosen = true;
	if (noderollover == 'false') {
		rolloverTitlesChoiceDiv.className = "active iconUnselected";
		rolloverTitlesChoiceDiv.chosen = false;
		forcedirectedGraph.rolloverTitles = false;
	}
	Event.observe(rolloverTitlesChoiceDiv,"click", function(event) {
		if (this.chosen) {
			forcedirectedGraph.rolloverTitles = false;
			this.chosen = false;
			setNodeRollover(false);
			this.className = "active iconUnselected";
		} else {
			forcedirectedGraph.rolloverTitles = true;
			this.chosen = true;
			setNodeRollover(true);
			this.className = "active iconSelected";
		}
	});
	rolloverTitlesChoiceDiv.insert(rolloverTitlesChoiceIcon);
	tb2.insert(rolloverTitlesChoiceDiv);

	var noderollover = getNodeRollover();
	var rolloverTitlesChoiceDiv = new Element("div", {'chosen':'true', 'id':'rolloverTitlesChoiceDiv', 'class':'active iconSelected', 'style':'float:left;margin-left:20px;margin-top:-2px', 'title':'<?php echo $LNG->MAP_TITLE_ROLLOVER_CHOICE_HINT;?>'});
	var rolloverTitlesChoiceIcon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('mag-glass-rollover.png'); ?>", 'alt': 'enable/disable rollover hints'});
	rolloverTitlesChoiceDiv.insert(rolloverTitlesChoiceIcon);
	rolloverTitlesChoiceIcon.chosen = true;
	if (noderollover == 'false') {
		rolloverTitlesChoiceDiv.className = "active iconUnselected";
		rolloverTitlesChoiceDiv.chosen = false;
		forcedirectedGraph.rolloverTitles = false;
	}
	Event.observe(rolloverTitlesChoiceDiv,"click", function(event) {
		if (this.chosen) {
			forcedirectedGraph.rolloverTitles = false;
			this.chosen = false;
			setNodeRollover(false);
			this.className = "active iconUnselected";
		} else {
			forcedirectedGraph.rolloverTitles = true;
			this.chosen = true;
			setNodeRollover(true);
			this.className = "active iconSelected";
		}
	});
	rolloverTitlesChoiceDiv.insert(rolloverTitlesChoiceIcon);
	tb2.insert(rolloverTitlesChoiceDiv);

	var linktext = getLinkText();
	var linktextChoiceDiv = new Element("div", {'chosen':'true','id':'linktextChoiceDiv', 'class':'active iconSelected', 'style':'float:left;margin-left:10px;margin-top:-2px', 'title':'<?php echo $LNG->MAP_LINK_TEXT_CHOICE_HINT;?>'});
	var linktextChoiceIcon = new Element("img", {'style':'width:25px;height:20px;vertical-align:middle;','src':"<?php echo $HUB_FLM->getImagePath('linktext.png'); ?>", 'alt': 'enable/disable links'});
	linktextChoiceIcon.chosen = true;
	if (linktext == 'false') {
		linktextChoiceDiv.className = "active iconUnselected";
		linktextChoiceDiv.chosen = false;
		forcedirectedGraph.linkLabelTextOn = false;
	}
	linktextChoiceDiv.insert(linktextChoiceIcon);
	Event.observe(linktextChoiceDiv,"click", function(event) {
		if (this.chosen) {
			forcedirectedGraph.linkLabelTextOn = false;
			this.chosen = false;
			setLinkText(false);
			this.className = "active iconUnselected";
			forcedirectedGraph.refresh();
		} else {
			forcedirectedGraph.linkLabelTextOn = true;
			this.chosen = true;
			setLinkText(true);
			this.className = "active iconSelected";
			forcedirectedGraph.refresh();
		}
	});
	linktextChoiceDiv.insert(linktextChoiceIcon);
	tb2.insert(linktextChoiceDiv);

	var linkcurveChoiceDiv = new Element("div", {'id':'linkcurveChoiceDiv', 'class':'active iconUnselected', 'style':'float:left;margin-left:10px;margin-top:-2px', 'title':'<?php echo $LNG->MAP_LINK_CURVE_CHOICE_HINT;?>'});
	var linkcurveChoiceIcon = new Element("img", {'style':'vertical-align:middle;height:20px','src':"<?php echo $HUB_FLM->getImagePath('curvelink24.png'); ?>", 'alt': 'enable/disable curved links'});
	linkcurveChoiceIcon.chosen = false;
	var linkcurve = getLinkCurve();
	if (linkcurve == 'true') {
		forcedirectedGraph.linkCurveOn = true;
		linkcurveChoiceDiv.chosen = false;
		linkcurveChoiceDiv.className = "active iconSelected";
		forcedirectedGraph.refresh();
	}

	linkcurveChoiceDiv.insert(linkcurveChoiceIcon);
	Event.observe(linkcurveChoiceDiv,"click", function(event) {
		if (this.chosen) {
			forcedirectedGraph.linkCurveOn = false;
			this.chosen = false;
			setLinkCurve(false);
			this.className = "active iconUnselected";
			forcedirectedGraph.refresh();
		} else {
			forcedirectedGraph.linkCurveOn = true;
			this.chosen = true;
			setLinkCurve(true);
			this.className = "active iconSelected";
			forcedirectedGraph.refresh();
		}
	});
	linkcurveChoiceDiv.insert(linkcurveChoiceIcon);
	tb2.insert(linkcurveChoiceDiv);

	var printButton = new Element("div", {'class':'active','style':'float:left;margin-left: 20px;', 'title':'<?php echo $LNG->GRAPH_PRINT_HINT;?>'});
	var printButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('printer.png'); ?>", 'alt': 'print'});
	printButton.insert(printButtonicon);
	var printButtonhandler = function() {
		printCanvas(forcedirectedGraph);
	};
	Event.observe(printButton,"click", printButtonhandler);
	tb2.insert(printButton);

	var helpButton = new Element("div", {'class':'active', 'title':'<?php echo $LNG->GRAPH_HELP_HINT;?>'});
	var helpButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('info.png'); ?>", 'alt': 'help'});
	helpButton.insert(helpButtonicon);
	var printButtonhandler = function() {
		showHelp();
	};
	Event.observe(helpButton,"click", printButtonhandler);
	tb2.insert(helpButton);


	/** SEARCH BOX **/
	var searchdiv = new Element("div", {'id':'searchmap', 'style':'float:left;margin-left: 25px;'});

	var searchfield = new Element("input", {'type':'text', 'class':'searchborder', 'style':'width:160px;height:18px;', 'id':'qmap', 'name':'qmap', 'value':'', 'aria-label':'search'});
	searchdiv.insert(searchfield);
	Event.observe(searchfield,"keyup", function(event) {
		if(checkKeyPressed(event)) {
			handleMapSearch();
		}
	});

	var buttondiv = new Element('div', {'class': 'd-inline-flex'});

	var searchbutton = new Element('img', {'width':'20', 'height':'20', 'class':'active', 'style': 'float:left;padding-left:3px; padding-right:10px;', 'title':'<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>', 'alt':'<?php echo $LNG->HEADER_SEARCH_RUN_ICON_ALT; ?>'});
	searchbutton.src = "<?php echo $HUB_FLM->getImagePath('search.png'); ?>";
	Event.observe(searchbutton,"click", function(event){
		var query = $('qmap').value;
		searchMap(query);
	});
	buttondiv.insert(searchbutton);

	var clearbutton = new Element("img", {
					'class':'active mx-2',
					'width':'20',
					'height':'20',
					'style': 'float:left;padding-left:3px; padding-right:10px;',
					'id':'map-clear-button',
					'src':'<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>',
					'title':'<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>',
					'alt':'<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>',
				});
	var clearhandler = function(event) {
		$('qmap').value='';
		// Map
		clearSelectedMapNodes(forcedirectedGraph);
		forcedirectedGraph.refresh();

		//Tree
		clearKnowledgeTreeSelections();
	};
	Event.observe(clearbutton,"click", clearhandler);
	buttondiv.insert(clearbutton);

	searchdiv.insert(buttondiv);

	tb2.insert(searchdiv);

	// VIEWS
	var toggleview = new Element("div", {'style':'float:left;margin-left: 20px;height:19px'});
	var toggleviewicon = new Element("img", {
					'id':'toggle-map-view',
					'class':'active',
					'style':'width:20px; height: 20px;',
					'src':"<?php echo $HUB_FLM->getImagePath('knowledge-tree.png'); ?>",
					'border':'0',
					'title':'<?php echo $LNG->NETWORKMAPS_VIEW_LINEAR; ?>'
				});
	toggleview.insert(toggleviewicon);
	var toggleviewhandler = function() {
		toggleMapTree(toggleviewicon);
	};
	Event.observe(toggleview,"click", toggleviewhandler);
	tb2.insert(toggleview);

	var movieModeIcon = new Element("img", {
			'chosen':'false',
			'id':'mediamodebuttondiv',
			'class':'active iconUnselected',
			'data-bs-target': '#moviemaptoolbar',
			'data-bs-toggle':'collapse',
			'aria-expanded':'false',
			'aria-controls':'moviemaptoolbar',
			'src':"<?php echo $HUB_FLM->getImagePath('mediaiconmode.png'); ?>",
			'alt':'toggle replay'
	});
	if (NODE_ARGS['media'] || NODE_ARGS['youtubeid'] || NODE_ARGS['vimeoid']) {
		movieModeIcon.title = '<?php echo $LNG->MAP_MEDIA_MODE_HINT;?>';
	} else {
		movieModeIcon.title = '<?php echo $LNG->MAP_REPLAY_MODE_HINT;?>';
	}

	var movieModeButtonhandler = function(event) {
		if (this.chosen) {
			this.className  = "active iconUnSelected";
		} else {
			this.className = "active iconSelected";
		}

		if (NODE_ARGS['media'] || NODE_ARGS['youtubeid'] || NODE_ARGS['vimeoid']) {
			if (this.chosen) {
				this.chosen = false;
				forcedirectedGraph.mediaReplayMode = false;
				forcedirectedGraph.refresh();
			} else {
				this.chosen = true;
				forcedirectedGraph.mediaReplayMode = true;
				forcedirectedGraph.refresh();
			}
		} else {
			if (this.chosen) {
				if (mapPlayer) {
					clearInterval(mapPlayer);
				}
				//forcedirectedGraph.Events.enable = true;
				//forcedirectedGraph.Events.enableForEdges = true;
				clearMapNodeReplayIndexes(forcedirectedGraph);
				this.chosen = false;
				forcedirectedGraph.mapReplayMode = false;
				forcedirectedGraph.mapReplayCurrentIndex = -1;
				$('mapreplayslider').value = 0;
				$('mapreplayslider').max = 0;
				forcedirectedGraph.refresh();
			} else {
				//forcedirectedGraph.Events.enable = false;
				//forcedirectedGraph.Events.enableForEdges = false;
				addMapNodeReplayIndexes(forcedirectedGraph);
				this.chosen = true;
				forcedirectedGraph.mapReplayMode = true;
				forcedirectedGraph.mapReplayCurrentIndex = 0;
				$('mapreplayslider').value = 0;
				$('mapreplayslider').max = forcedirectedGraph.mapReplayMaxIndex;
				forcedirectedGraph.refresh();
			}
		}
	};
	Event.observe(movieModeIcon,"click", movieModeButtonhandler);
	tb2.insert(movieModeIcon);

	tb2.insert(createMapMovieBar(forcedirectedGraph));

	return tb2;
}

function playMap(forcedirectedGraph) {
	var currentIndex = parseInt(forcedirectedGraph.mapReplayCurrentIndex);
	if (currentIndex >= forcedirectedGraph.mapReplayMaxIndex) {
		$('mapplaybutton').src = "<?php echo $HUB_FLM->getImagePath('video-play-white.png'); ?>";
		$('mapplaybutton').title = "Replay the map based on creationdates";
		$('mapplaybutton').mode = "pause";
		clearInterval(mapPlayer);
	} else {
		$('mapreplayslider').value = currentIndex+1;
		forcedirectedGraph.mapReplayCurrentIndex = $('mapreplayslider').value;
		forcedirectedGraph.refresh();
	}
}

function createMapMovieBar(forcedirectedGraph) {

	var tb = new Element("div", {'id':'moviemaptoolbar', 'class':'collapse'});
	var tb2= new Element("div", {'id':'moviemapflex', 'class':'d-inline-flex align-items-center flex-wrap'});
	tb.insert(tb2);

	var tbspeed = new Element("div", {'style':'padding:0px;padding-top:2px;'});
	var tbinner = new Element("div", {'class':'curvedBorder', 'style':'background-color: #E8E8E8;border:none;padding:2px 2px 0px 2px;'});
	tb2.insert(tbspeed);
	tb2.insert(tbinner);

	var mapReplayInterval = new Element("input", {'id':'mapreplayspeed', 'type':'text', 'value':'', 'style':'width:40px;','title':'<?php echo $LNG->MAP_REPLAY_SPEED_UNITS_HINT; ?>'});
	mapReplayInterval.value = forcedirectedGraph.mapReplayInterval;
	tbspeed.insert(mapReplayInterval);
	var mapReplayIntervalHandler = function(event) {
		try {
			var replayInterval = parseInt(this.value);
			setReplaySpeed(replayInterval);
			forcedirectedGraph.mapReplayInterval = replayInterval;
		} catch(e) {
			alert("<?php echo $LNG->MAP_REPLAY_SPEED_ERROR; ?>");
		}
	};
	Event.observe(mapReplayInterval,"change", mapReplayIntervalHandler);

	var mapReplayIntervalType = new Element("label", {'style':'font-size:9pt;padding-left:5px;padding-right:10px;','title':'<?php echo $LNG->MAP_REPLAY_SPEED_UNITS_HINT; ?>'});
	mapReplayIntervalType.innerHTML = "<?php echo $LNG->MAP_REPLAY_SPEED_UNITS; ?>";
	tbspeed.insert(mapReplayIntervalType);

	var mapPlayIcon = new Element("img", {'id':'mapplaybutton', 'mode':'play', 'title':'<?php echo $LNG->MAP_REPLAY_PLAY_HINT; ?>', 'style':'vertical-align:inherit;height:18px;box-sizing: content-box;padding-left:4px;', 'src':"<?php echo $HUB_FLM->getImagePath('video-play-white.png'); ?>"});
	var mapPlayButtonhandler = function(event) {
		// is it play or pause mode
		if (this.mode == "play") {
			// pause
			this.src = "<?php echo $HUB_FLM->getImagePath('video-play-white.png'); ?>";
			this.title = "<?php echo $LNG->MAP_REPLAY_PLAY_HINT; ?>";
			this.mode = "pause";
			clearInterval(mapPlayer);
		} else {
			// play
			if (forcedirectedGraph.mapReplayCurrentIndex == forcedirectedGraph.mapReplayMaxIndex) {
				$('mapreplayslider').value = 0;
				forcedirectedGraph.mapReplayCurrentIndex = 0;
				forcedirectedGraph.refresh();
			}
			this.src = "<?php echo $HUB_FLM->getImagePath('video-pause-white.png'); ?>";
			this.title = "<?php echo $LNG->MAP_REPLAY_PAUSE_HINT; ?>";
			this.mode = "play";
			if (mapPlayer) {
				clearInterval(mapPlayer);
			}
			mapPlayer = setInterval(function(){ playMap(forcedirectedGraph) }, (forcedirectedGraph.mapReplayInterval));
		}
	};
	Event.observe(mapPlayIcon,"click", mapPlayButtonhandler);
	tbinner.insert(mapPlayIcon);

	var mapBackIcon = new Element("img", {'mode':'play', 'title':'<?php echo $LNG->MAP_REPLAY_BACK_HINT; ?>', 'style':'vertical-align:inherit;height:18px;padding:3px 5px 0px 4px;box-sizing: content-box;', 'src':"<?php echo $HUB_FLM->getImagePath('video-back-white.png'); ?>"});
	var mapBackButtonhandler = function(event) {
		var currentIndex = parseInt($('mapreplayslider').value);
		if (currentIndex > 0) {
			$('mapreplayslider').value = currentIndex-1;
			forcedirectedGraph.mapReplayCurrentIndex = $('mapreplayslider').value;
			forcedirectedGraph.refresh();
		}
	};
	Event.observe(mapBackIcon,"click", mapBackButtonhandler);
	tbinner.insert(mapBackIcon);

	var mapslider = new Element("input", {'id':'mapreplayslider', 'type':'range', 'min':'0', 'max':0, 'value':'0', 'steps':'1', 'style':'width:160px;height:18px;margin-top:2px;box-sizing: content-box;', 'aria-label':'slider'});
	var mapSliderHandler = function(event) {
			forcedirectedGraph.mapReplayCurrentIndex = parseInt(this.value);
			forcedirectedGraph.refresh();
	};
	Event.observe(mapslider,"change", mapSliderHandler);
	tbinner.insert(mapslider);

	var mapForwardIcon = new Element("img", {'mode':'play', 'title':'<?php echo $LNG->MAP_REPLAY_FORWARD_HINT; ?>', 'style':'vertical-align:inherit;height:18px;padding-left:5px;margin-right:4px;box-sizing: content-box;', 'src':"<?php echo $HUB_FLM->getImagePath('video-forward-white.png'); ?>"});
	var mapForwardButtonhandler = function(event) {
		var currentIndex = parseInt($('mapreplayslider').value);
		if (currentIndex < forcedirectedGraph.mapReplayMaxIndex) {
			$('mapreplayslider').value = currentIndex+1;
			forcedirectedGraph.mapReplayCurrentIndex = $('mapreplayslider').value;
			forcedirectedGraph.refresh();
		}
	};
	Event.observe(mapForwardIcon,"click", mapForwardButtonhandler);
	tbinner.insert(mapForwardIcon);


	return tb;
}

/**
 * Called by the map to go to the given map
 */
function viewMapDetailsAndSelect(mapid, selectnodeid) {
	var width = getWindowWidth();
	var height = getWindowHeight()-20;
	loadDialog('mapdetails', URL_ROOT+"map.php?id="+mapid+"&focusid="+selectnodeid, width,height);
}

/**
 * Called by the map to go to the given map
 */
function viewMapDetails(mapid) {
	var width = getWindowWidth();
	var height = getWindowHeight()-20;
	loadDialog('mapdetails', URL_ROOT+"map.php?id="+mapid, width,height);
}

/*** MAP EDIT SIDEBAR AND ITS FUNCTIONS ***/

function pauseMediaPlayer() {
	if (mediaPlayerPause) {
		mediaPlayerPause();
	}
}

var editforcedirectedGraph = "";
function createEditSidebar(container, forcedirectedGraph) {

	container.innerHTML = "";

	editforcedirectedGraph = forcedirectedGraph;

	var mainwidth = 240;
	if (EDIT_WIDTH) {
		mainwidth = EDIT_WIDTH;
	}
	var mapheight = 560;
	if (MAP_HEIGHT) {
		mapheight = MAP_HEIGHT;
	}

	var nodeEditBar = new Element('div', {'id':'nodeeditbar'});
	nodeEditBar.oriheight = mapheight;

	var editbartopdiv = new Element('div', {'id':'editbartopdiv'});
	nodeEditBar.insert(editbartopdiv);

	//editbartopdiv.insert('<h1 style="margin-top:0px;Margin-bottom:0px;margin-left: 5px;margin-bottom:5px;"><?php echo $LNG->MAP_EDITOR_INBOX; ?></h1>');

	//ADD BUTTONS
	var addbuttonsdiv = new Element('div', {'id':'addbuttonsdiv','class':'pb-1', 'style':'border-bottom:1px solid #E8E8E8;'});
	editbartopdiv.insert(addbuttonsdiv);
	addbuttonsdiv.insert('<div style="clear:both;float:left;width: 100%;margin-bottom:3px;"><?php echo $LNG->FORM_BUTTON_ADD_NEW; ?>:</div>');

	var issueaddbutton = new Element('img', {'style':'margin-right:10px;width:28px;height:28px;-webkit-user-drag:element', 'class':'active', 'title':'<?php echo $LNG->ISSUE_NAME.": ".$LNG->MAP_EDITOR_NEW_NODE_HINT; ?>'});
	issueaddbutton.setAttribute('draggable', 'true');
	Event.observe(issueaddbutton,"dragstart", function(e){
		pauseMediaPlayer();
		e.dataTransfer.effectAllowed = "copy";
		e.dataTransfer.setData('text', 'Issue');
	});
	issueaddbutton.src="<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue.png'); ?>";
	Event.observe(issueaddbutton,"click", function(event){
		loadDialog('addbox',URL_ROOT+'ui/popups/issueadd.php?handler=reloadEditBarItems', 750,540);
	});
	addbuttonsdiv.insert(issueaddbutton);

	var solutionaddbutton = new Element('img', {'style':'margin-right:10px;width:28px;height:28px;-webkit-user-drag:element', 'class':'active', 'title':'<?php echo $LNG->SOLUTION_NAME.": ".$LNG->MAP_EDITOR_NEW_NODE_HINT; ?>'});
	solutionaddbutton.setAttribute('draggable', 'true');
	Event.observe(solutionaddbutton,"dragstart", function(e){
		pauseMediaPlayer();
		e.dataTransfer.effectAllowed = "copy";
		e.dataTransfer.setData('text', 'Solution');
	});
	solutionaddbutton.src="<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution.png'); ?>";
	Event.observe(solutionaddbutton,"click", function(event){
		loadDialog('addbox',URL_ROOT+'ui/popups/solutionadd.php?handler=reloadEditBarItems', 750,540);
	});
	addbuttonsdiv.insert(solutionaddbutton);

	var proaddbutton = new Element('img', {'style':'margin-right:10px;width:28px;height:28px;-webkit-user-drag:element', 'class':'active', 'title':'<?php echo $LNG->PRO_NAME.": ".$LNG->MAP_EDITOR_NEW_NODE_HINT; ?>'});
	proaddbutton.setAttribute('draggable', 'true');
	Event.observe(proaddbutton,"dragstart", function(e){
		pauseMediaPlayer();
		e.dataTransfer.effectAllowed = "copy";
		e.dataTransfer.setData('text', 'Pro');
	});
	proaddbutton.src="<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-32x32.png'); ?>";
	Event.observe(proaddbutton,"click", function(event){
		loadDialog('addbox',URL_ROOT+'ui/popups/evidenceadd.php?handler=reloadEditBarItems&nodetypename=Pro', 750,540);
	});
	addbuttonsdiv.insert(proaddbutton);

	var conaddbutton = new Element('img', {'style':'margin-right:10px;width:28px;height:28px;-webkit-user-drag:element', 'class':'active', 'title':'<?php echo $LNG->CON_NAME.": ".$LNG->MAP_EDITOR_NEW_NODE_HINT; ?>'});
	conaddbutton.setAttribute('draggable', 'true');
	Event.observe(conaddbutton,"dragstart", function(e){
		pauseMediaPlayer();
		e.dataTransfer.effectAllowed = "copy";
		e.dataTransfer.setData('text', 'Con');
	});
	conaddbutton.src="<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-32x32.png'); ?>";
	Event.observe(conaddbutton,"click", function(event){
		loadDialog('addbox',URL_ROOT+'ui/popups/evidenceadd.php?handler=reloadEditBarItems&nodetypename=Con', 750,540);
	});
	addbuttonsdiv.insert(conaddbutton);

	var argumentaddbutton = new Element('img', {'style':'margin-right:10px;width:28px;height:28px;-webkit-user-drag:element', 'class':'active', 'title':'<?php echo $LNG->ARGUMENT_NAME.": ".$LNG->MAP_EDITOR_NEW_NODE_HINT; ?>'});
	argumentaddbutton.setAttribute('draggable', 'true');
	Event.observe(argumentaddbutton,"dragstart", function(e){
		pauseMediaPlayer();
		e.dataTransfer.effectAllowed = "copy";
		e.dataTransfer.setData('text', 'Argument');
	});
	argumentaddbutton.src="<?php echo $HUB_FLM->getImagePath('nodetypes/Default/argument.png'); ?>";
	Event.observe(argumentaddbutton,"click", function(event){
		loadDialog('addbox',URL_ROOT+'ui/popups/evidenceadd.php?handler=reloadEditBarItems&nodetypename=Argument', 750,540);
	});
	addbuttonsdiv.insert(argumentaddbutton);

	var commentaddbutton = new Element('img', {'style':'margin-right:10px;width:28px;height:28px;-webkit-user-drag:element', 'class':'active', 'title':'<?php echo $LNG->COMMENT_NAME.": ".$LNG->MAP_EDITOR_NEW_NODE_HINT; ?>'});
	commentaddbutton.setAttribute('draggable', 'true');
	Event.observe(commentaddbutton,"dragstart", function(e){
		pauseMediaPlayer();
		e.dataTransfer.effectAllowed = "copy";
		e.dataTransfer.setData('text', 'Idea');
	});
	commentaddbutton.src="<?php echo $HUB_FLM->getImagePath('nodetypes/Default/idea.png'); ?>";
	Event.observe(commentaddbutton,"click", function(event){
		loadDialog('addbox',URL_ROOT+'ui/popups/commentadd.php?handler=reloadEditBarItems', 750,540);
	});
	addbuttonsdiv.insert(commentaddbutton);

	// SEARCH AREA
	var searcharea = new Element('div', {'id':'editbar-searcharea', 'class':'container-fluid px-0 py-1 mx-0 my-0'});
	editbartopdiv.insert(searcharea);

	var searchinnerdiv = new Element('span', {'class': 'col- d-inline-flex px-1'});
	searcharea.insert(searchinnerdiv);

	var searchfield = new Element('input', {'id':'editbar-itemsearch', 'class':'form-control', 'name':'editbar-itemsearch', 'type':'text', 'value':'', 'aria-label':'search'});
	Event.observe(searchfield,"keypress", function(event){
		editBarSearchKeyPressed(event);
	});
	searchinnerdiv.insert(searchfield);

	var searchchoices = new Element('div', {'id':'editbar-item_choices', 'class':'autocomplete', 'style': 'border-color: white;'});
	searchinnerdiv.insert(searchchoices);

	var searchbutton = new Element('img', {'width':'20', 'height':'20', 'class':'col- gap-1', 'title':'<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>', 'alt':'<?php echo $LNG->HEADER_SEARCH_RUN_ICON_ALT; ?>'});
	searchbutton.src = "<?php echo $HUB_FLM->getImagePath('search.png'); ?>";
	Event.observe(searchbutton,"click", function(event){
		runEditBarSearch('0', '10', 'date', 'DESC');
	});
	searcharea.insert(searchbutton);

	var clearbutton = new Element("img", { 'class':'col- mx-2', 'width':'20', 'height':'20', 'id':'edit-map-clear-button', 'src':'<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>',
					'title':'<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>',
					'alt':'<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>',
				});
	var clearhandler = function(event) {
		$('editbar-itemsearch').value='';
		$('search-editbar-item-list-count').innerHTML = "0";
		$("item-editbar-search-list").innerHTML = "";
	};
	Event.observe(clearbutton,"click", clearhandler);
	searcharea.insert(clearbutton);

	// TABS AREA
	var tabberparentdiv = new Element('div', {'id':'parenttabber', 'class': 'pt-1'});
	tabberparentdiv.oriheight = mapheight-90;
	nodeEditBar.insert(tabberparentdiv);

	var tabberdiv = new Element('div', {'id':'tabber', 'role':'navigation'});
	tabberparentdiv.insert(tabberdiv);

	var tabberinnerdiv = new Element('div', {'id':'tabberinnerdiv'});
	tabberdiv.insert(tabberinnerdiv);

	var tabberlist = new Element('ul', {'id':'editsearchtabs', 'class': 'nav nav-tabs', 'role':'tablist'});
	tabberinnerdiv.insert(tabberlist);

	var tabbernodelistitem = new Element('li', {'class': 'nav-item', 'style':'font-size:9pt'});
	tabberlist.insert(tabbernodelistitem);
	var tabbernodelink = new Element('a', {'id':'tab-editbar-item-node', 'class': 'nav-link p-1 px-2 active', 'href':'#map'});
	Event.observe(tabbernodelink,"click", function(event){
		viewEditBarNodes();
	});
	tabbernodelistitem.insert(tabbernodelink);
	var tabbernodelinkspan = new Element('span', {'class': 'tab'});
	tabbernodelinkspan.insert('<?php echo $LNG->FORM_SELECTOR_TAB_MINE; ?>');
	tabbernodelinkspan.insert(' (');
	var tabbernodelinkspaninner = new Element('span', {'id': 'node-editbar-item-list-count'});
	tabbernodelinkspaninner.insert('0')
	tabbernodelinkspan.insert(tabbernodelinkspaninner);
	tabbernodelinkspan.insert(') ');
	tabbernodelink.insert(tabbernodelinkspan);

	var tabbersearchlistitem = new Element('li', {'class': 'nav-item', 'style':'font-size:9pt'});
	tabberlist.insert(tabbersearchlistitem);
	var tabbersearchlink = new Element('a', {'id':'tab-editbar-item-search', 'class': 'nav-link p-1 px-2', 'href':'#map'});
	Event.observe(tabbersearchlink,"click", function(event){
		viewEditBarSearch();
	});
	tabbersearchlistitem.insert(tabbersearchlink);
	var tabbersearchlinkspan = new Element('span', {'class': 'tab'});
	tabbersearchlinkspan.insert('<?php echo $LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS; ?>');
	tabbersearchlinkspan.insert(' (');
	var tabbersearchlinkspaninner = new Element('span', {'id': 'search-editbar-item-list-count'});
	tabbersearchlinkspaninner.insert('0')
	tabbersearchlinkspan.insert(tabbersearchlinkspaninner);
	tabbersearchlinkspan.insert(') ');
	tabbersearchlink.insert(tabbersearchlinkspan);

	//add the contents areas for the two tabs.
	var tabbercontentdiv = new Element('div', {'id':'tabbercontentdiv','style': 'clear:both;float:left;height:100%;width:'+(mainwidth)+'px;'});
	tabberdiv.insert(tabbercontentdiv);

	var tabbercontentideas = new Element('div', {'id':'item-editbar-idea-list'});
	tabbercontentdiv.insert(tabbercontentideas);

	var tabbercontentsearch = new Element('div', {'id':'item-editbar-search-list', 'style':'margin: 0;overflow:hidden;height:100%; display: none;'});
	tabbercontentsearch.insert('<?php echo $LNG->FORM_SELECTOR_SEARCH_EMPTY_MESSAGE; ?>');
	tabbercontentdiv.insert(tabbercontentsearch);

	container.insert(nodeEditBar);
}

/**
 * Check to see if the enter key was pressed.
 */
function editBarSearchKeyPressed(evt) {
	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var characterCode = document.all? window.event.keyCode:event.which;
	if(characterCode == 13) {
		runEditBarSearch('0', '10', 'date', 'DESC')
	}
}

function runEditBarSearch(start, max, orderby, sort) {
	var filternodetypes = 'Issue,Solution,Pro,Con,Argument,Idea,Map';

	$("item-editbar-search-list").innerHTML = "";
	var search = $('editbar-itemsearch').value;
	var reqUrl = SERVICE_ROOT + "&orderby="+orderby+"&sort="+sort+"&method=getnodesbyglobal&q="+search+"&scope=all&start="+start+"&max="+max+"&filternodetypes="+filternodetypes;

	new Ajax.Request(reqUrl, { method:'get',
			onError:  function(error) {
				alert("<?php echo $LNG->FORM_SELECTOR_SEARCH_ERROR; ?>");
			},
			onSuccess: function(transport){
			   var json = transport.responseText.evalJSON();
			   if(json.error){
				   alert(json.error[0].message);
				   return;
			   }

			   $('search-editbar-item-list-count').innerHTML = "";
			   $('search-editbar-item-list-count').insert(json.nodeset[0].totalno);

				if(json.nodeset[0].nodes.length > 0){
					var nodes = json.nodeset[0].nodes;

					if (editforcedirectedGraph != "") {
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i].cnode;
							var mapnode = editforcedirectedGraph.graph.getNode(node.nodeid);
							if (mapnode) {
								node.inmap = true;
							}
						}
					}

					var total = json.nodeset[0].totalno;
					var navbar = createEditBarNav(total, json.nodeset[0].count, start, max, "search", orderby, sort);
					$("item-editbar-search-list").insert(navbar);

					//var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', url: '<?php echo $LNG->SORT_URL; ?>'};
					//var sortArea = displayEditBarSortForm(sortOpts, handleEditBarSearchSort, 'search', orderby, sort);
					//$("item-editbar-search-list").insert(sortArea);

					displayEditBarNodes($("item-editbar-search-list"),nodes,1, true, total, "search");
				} else {
					$("item-editbar-search-list").innerHTML = "<div style='margin-top:5px;'><?php echo $LNG->MAP_EDITOR_SEARCH_NO_RESULTS; ?></div>";
				}

				if (editforcedirectedGraph != "" && NODE_ARGS) {
					NODE_ARGS['blockednodeids'] = getMapNodeString(editforcedirectedGraph);
				}

				viewEditBarSearch();
		   }
	});
}

function reloadEditBarItems() {
	viewEditBarNodes();
	loadEditBarNodes('<?php echo($USER->userid); ?>', 0, 10, 'date', 'DESC');
}


/**
*	load user nodes
*/
function loadEditBarNodes(userid, start, max, orderby, sort){
	$("item-editbar-idea-list").innerHTML = "";
	var filternodetypes = 'Issue,Solution,Pro,Con,Idea,Argument,Map';

	var reqUrl = SERVICE_ROOT + "&orderby="+orderby+"&sort="+sort+"&method=getnodesbyuser&filternodetypes="+filternodetypes+"&userid="+userid+"&start="+start+"&max="+max;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){

			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			$('node-editbar-item-list-count').innerHTML = "";
			$('node-editbar-item-list-count').insert(json.nodeset[0].totalno);

			if(json.nodeset[0].nodes.length > 0){
				var nodes = json.nodeset[0].nodes;

				if (editforcedirectedGraph != "") {
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i].cnode;
						var mapnode = editforcedirectedGraph.graph.getNode(node.nodeid);
						if (mapnode) {
							node.inmap = true;
						}
					}
				}

				var total = json.nodeset[0].totalno;
				var navbar = createEditBarNav(total, json.nodeset[0].count, start, max, "node", orderby, sort);
				$("item-editbar-idea-list").insert(navbar);

				displayEditBarNodes($("item-editbar-idea-list"),nodes,1, false, total, "node");
			} else {
				$("item-editbar-idea-list").insert("<?php echo $LNG->FORM_SELECTOR_NOT_ITEMS; ?>");
			}

			if (editforcedirectedGraph != "" && NODE_ARGS) {
				NODE_ARGS['blockednodeids'] = getMapNodeString(editforcedirectedGraph);
			}
		}
	});
}

/**
 * Render a list of nodes
 */
function displayEditBarNodes(objDiv,nodes,start, includeUser, total, type){
	var mainwidth = 240;
	if (EDIT_WIDTH) {
		mainwidth = EDIT_WIDTH;
	}
	var mainheight = 560;
	if (MAP_HEIGHT) {
		mainheight = MAP_HEIGHT;
	}

	//pageeditbarnav not quite right
	//alert($('page-editbar-nav'+type).offsetHeight); // sometimes coming back as zero

	var height = mainheight-90-$('tabberinnerdiv').offsetHeight;
	var extras = 45;
	if (total > 120) {
		extras = 65;
	}
	height = height-extras;

	objDiv.insert('<div style="clear:both; margin: 0px; padding: 0px;"></div>');
	var lOL = new Element("ol", {'id':'editbarlist','start':start, 'class':'idea-list-ol', 'style':'margin:0px;padding:10px;overflow-y: auto; overflow-x: hidden; height: '+height+'px;'});
	lOL.oriheight = height;
	for(var i=0; i< nodes.length; i++){
		if(nodes[i].cnode && nodes[i].cnode.nodeid != NODE_ARGS['nodeid']){
			var iUL = new Element("li", {'id':'editbar-'+nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'padding-bottom: 5px;'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'style':'width:'+(mainwidth-5)+'px'});
			var blobNode = renderMapPickerNode(nodes[i].cnode, nodes[i].cnode.role[0].role,includeUser);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * display Nav
 */
function createEditBarNav(total, count, start, max, type, orderby, sort) {

	var mainnav = new Element ("div",{'style':'background:white;'});

	var header = createEditBarNavCounter(total, start, count);
	mainnav.insert(header);

	var outernav = new Element ("div",{'class':'border-bottom', 'style':'overflow-x:auto;overflow-y:hidden;width: 240px; max-width:240px'});
	var nav = new Element ("div",{'id':'page-editbar-nav'+type, 'class':'toolbarrow pb-1', 'style':'white-space: nowrap;' });
	outernav.insert(nav);
    mainnav.insert(outernav);

	var pageNav = new Element ("nav",{'aria-label':'Page navigation' });
	var pageUL = new Element ("ul",{'id':'page-editbar-nav'+type, 'class':'pagination mb-0' });

 	if (total > max) {
		var prevSpan = new Element("li", {'id':"nav-previous", "class": "page-link", "style":"padding: 0.2rem 0.5rem;"});

		if(start > 0){
			prevSpan.update("<i class=\"fas fa-chevron-left fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?></span>");
	        prevSpan.addClassName("active");
			Event.observe(prevSpan,"click", function(){
				let newArr = new Object();
				newArr.max = max;
				newArr.start = parseInt(start) - newArr["max"];
				if (type=="node") {
					loadEditBarNodes('<?php echo($USER->userid); ?>', newArr["start"], newArr["max"], orderby, sort)
				} else if (type=="search") {
					runEditBarSearch(newArr["start"], newArr["max"], orderby, sort);
				}
				this.scrollIntoView();
			});
		} else {
			prevSpan.update("<i disabled class=\"fas fa-chevron-left fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?></span>");
	        prevSpan.addClassName("inactive");
		}

		pageUL.insert(prevSpan)

		//pages
		var totalPages = Math.ceil(total/max);
		var currentPage = (start/max) + 1;
		for (let i = 1; i < totalPages+1; i++) {
			var page = new Element("span", {'class':'page-link', "style":"padding: 0.2rem 0.5rem;" } ).insert(i);
			if ( i != currentPage ) {
				page.addClassName( "active" );
				let newArr = new Object();
				newArr.max = max;
				newArr.start = newArr[ "max" ] * (i-1) ;
				Event.observe(page,"click", Pages.next.bindAsEventListener(Pages,type,newArr,orderby,sort));
			} else {
				page.addClassName("currentpage");
				page.scrollIntoView(true);
			}

			pageUL.insert(page);
		}

	    //next
	    var nextSpan = new Element("li", {'id':"nav-next", "class": "page-link", "style":"padding: 0.2rem 0.5rem;"});
	    if(parseInt(start)+parseInt(count) < parseInt(total)) {
			nextSpan.update("<i class=\"fas fa-chevron-right fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NEXT_HINT; ?></span>");
	        nextSpan.addClassName("active");
	        Event.observe(nextSpan,"click", function() {
				let newArr = new Object();
				newArr.max = max;
	            newArr.start = parseInt(start) + parseInt(newArr["max"]);
				if (type=="node") {
					loadEditBarNodes('<?php echo($USER->userid); ?>', newArr["start"], newArr["max"], orderby, sort)
				} else if (type=="search") {
					runEditBarSearch(newArr["start"], newArr["max"], orderby, sort);
				}
	        });
	    } else {
			nextSpan.update("<i class=\"fas fa-chevron-right fa-lg\" aria-hidden=\"true\" disabled></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?></span>");
	        nextSpan.addClassName("inactive");
	    }

		pageUL.insert(nextSpan);

		if ( start>0 || (parseInt(start)+parseInt(count) < parseInt(total))) {
			pageNav.insert(pageUL);
			nav.insert(pageNav);
	    }
	}

	return mainnav;
}

var Pages = {
	next: function(e){
		var data = $A(arguments);
		var type = data[1];
		var arrayData = data[2];
		var orderby = data[3];
		var sort = data[4];
		if (type=="node") {
			loadEditBarNodes('<?php echo($USER->userid); ?>', arrayData['start'], arrayData['max'], orderby, sort);
		} else if (type=="search") {
			runEditBarSearch(arrayData['start'], arrayData['max'], orderby, sort);
		}
	}
};

/**
* display nav header
*/
function createEditBarNavCounter(total, start, count, type){
	if(count != 0){
		var objH = new Element("span",{'class':'nav', 'style':'padding:5px 10px;'});
		var s1 = parseInt(start)+1;
		var s2 = parseInt(start)+parseInt(count);
		objH.insert("<b>" + s1 + " to " + s2 + "</b>");
	} else {
		var objH = new Element("span");
		objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_ITEMS; ?></b></p>");
	}
	return objH;
}

function viewEditBarNodes() {
	$("tab-editbar-item-search").removeClassName("active");
	$("item-editbar-search-list").style.display = 'none';

	$("tab-editbar-item-node").addClassName("active");
	$("item-editbar-idea-list").style.display = 'block';
}

function viewEditBarSearch() {
	$("tab-editbar-item-node").removeClassName("active");
	$("item-editbar-idea-list").style.display = 'none';

	$("tab-editbar-item-search").addClassName("active");
	$("item-editbar-search-list").style.display = 'block';
}

function createMapSurvey(container) {

	var survey = new Element("div", {'id':'mapsurvey', 'style':'margin-top:5px;float:left;width:100%;font-size:10pt;padding:5px;padding-top:0px;'});
	var surveydiv = new Element("div", {'id':'mapsurveydiv', 'class':'messagediv', 'style':'padding:10px;display:none'});

	var label = new Element("label", {'style':'font-face: Arial;padding-right:5px;'});
	label.insert("<?php echo $LNG->MAP_SURVEY_MESSAGE; ?>");
	survey.insert(label);

	var button = new Element("span", {'id':'feedbackbutton', 'class':'active','style':'font-face: Arial;margin-left:5px;font-size:11pt'});
	button.insert("<?php echo $LNG->MAP_SURVEY_LINK; ?>");
	survey.insert(button);

	Event.observe(button,'click', function(event) {
		if ($('mapsurveydiv').style.display == 'none') {
			if ($('mapsurveydiv').style.left == 0) {
				var width = 250;
				var height = 250;
				var pos = getPosition($('feedbackbutton'));
				var viewportWidth = getWindowWidth();
				var x = (viewportWidth-width)/2;
				var y = pos.y-20;
				$('mapsurveydiv').style.width = width+"px";
				$('mapsurveydiv').style.height = height+"px";
				$('mapsurveydiv').style.left = x+getPageOffsetX()+"px";
				$('mapsurveydiv').style.top = y+getPageOffsetY()+"px";
			}
			$('mapsurveydiv').style.display = 'block';
		} else {
			$('mapsurveydiv').style.display = 'none';
		}
	});

	surveydiv.insert("<h1><?php echo $LNG->MAP_SURVEY_MESSAGE; ?></h1>");

	var label2 = new Element("label", {'style':'float:left;font-face: Arial;padding-right:5px;margin-top:4px;'});
	label2.insert("<?php echo $LNG->MAP_SURVEY_FORM_USFULNESS; ?>");
	surveydiv.insert(label2);

	var menu = new Element("select", {'style':'float:left;font-size:9pt;'});
	menu.id = "mapsurveymenu";
	menu.className = "toolbar";
	var opt = new Element("option");
	opt.value=0;
	opt.insert("<?php echo $LNG->MAP_SURVEY_FORM_SELECT; ?>");
	menu.insert(opt);
	opt = new Element("option");
	opt.value=1;
	opt.insert("1");
	menu.insert(opt);
	opt = new Element("option");
	opt.value=2;
	opt.insert("2");
	menu.insert(opt);
	opt = new Element("option");
	opt.value=3;
	opt.insert("3");
	menu.insert(opt);
	opt = new Element("option");
	opt.value=4;
	opt.insert("4");
	menu.insert(opt);
	opt = new Element("option");
	opt.value=5;
	opt.insert("5");
	menu.insert(opt);
	surveydiv.insert(menu);

	var label3 = new Element("label", {'style':'float:left;clear:both;font-face: Arial;font-weight:normal'});
	label3.insert("<?php echo $LNG->MAP_SURVEY_FORM_SELECT_MESSAGE; ?>");
	surveydiv.insert(label3);

	var label4 = new Element("label", {'style':'float:left;clear:both;font-face: Arial;padding-right:5px;margin-top:10px;'});
	label4.insert("<?php echo $LNG->MAP_SURVEY_FORM_COMMENT; ?>");
	surveydiv.insert(label4);

	var textarea = new Element('textarea', {'id':'mapsurveytext', 'style':'height:60px;float:left;margin-top:5px;width:230px'});
	surveydiv.insert(textarea);

	var button = new Element("button", {'class':'active','style':'clear:both;float:left;font-face: Arial;margin-top:5px;'});
	button.insert("<?php echo $LNG->MAP_SURVEY_FORM_SUBMIT; ?>");
	Event.observe(button,'click', function(event) {
		var selection = $('mapsurveymenu').value;
		var text = $('mapsurveytext').value;
		if (selection > 0) {
			var state = "<state><rating>"+selection+"</rating><comment>"+text+"</comment></state>";
			auditTesting(NODE_ARGS['nodeid'], 'mapusefulness', 'feedback', state);
			$('mapsurveymenu').selectedIndex = 0;
			$('mapsurveytext').value = "";
			$('mapsurveydiv').style.display = 'none';

			// fade in thanks message
			var pos = getPosition($('feedbackbutton'));
			var viewportWidth = getWindowWidth();
			var x = (viewportWidth-300)/2;
			var y = pos.y-60;
			$('message').style.left = x+getPageOffsetX()+"px";
			$('message').style.top = y+getPageOffsetY()+"px";
			$('message').update('<?php echo $LNG->MAP_SURVEY_THANKS; ?>');
			$('message').style.display = "block";
			fadein();
			setTimeout(function(){
				fadeout();
				setTimeout(function() {
					$('message').style.display = "none";
				}, 1500);
			},2500);
		} else {
			alert("<?php echo $LNG->MAP_SURVEY_FORM_SELECT_ERROR; ?>");
		}
	});
	surveydiv.insert(button);

	var cancelbutton = new Element("button", {'class':'active','style':'float:left;font-face: Arial;margin-top:5px;margin-left:10px;'});
	cancelbutton.insert("<?php echo $LNG->MAP_SURVEY_FORM_CANCEL; ?>");
	Event.observe(cancelbutton,'click', function(event) {
		$('mapsurveymenu').selectedIndex = 0;
		$('mapsurveytext').value = "";
		$('mapsurveydiv').style.display = 'none';
	});
	surveydiv.insert(cancelbutton);

	container.insert(survey);
	document.body.insert(surveydiv);
}

function createAlertNodeLink(alerttype, postid, node, container, display) {
	var name = node.name;
	var type = alerttype.replace(/ /g,'');
	var id = 'post';
	if (display == 'none') {
		id = type;
	}
	var nodespan = new Element('div', {'name':id, 'class':'active', 'style':'display:'+display+';padding-top:10px;'});

<?php
	$nowtime = time();
	if ($CFG->TEST_TRIAL_NAME != "" && $nowtime >= $CFG->TEST_TRIAL_START && $nowtime < $CFG->TEST_TRIAL_END) { ?>

		var vote = new Element('img', {'title':'<?php echo $LNG->MAP_ALERT_SURVEY_QUESTION; ?>','style':'padding-top:4px;padding-right:7px'});
		vote.src = '<?php echo $HUB_FLM->getImagePath('thumb-up-filled.png'); ?>';
		vote.postid = postid;
		vote.alerttype = alerttype;
		Event.observe(vote,"click", function(event){
			registerAlertSurveyReponse(this, this.postid, this.alerttype, event);
		});
		nodespan.insert(vote);
<?php } ?>

	var role = node.role[0].role;
	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:16px;height:16px;padding-top:6px;padding-right:5px;','border':'0','src': URL_ROOT + role.image});
		nodespan.insert(nodeicon);
	}

	var desc = "<?php echo $LNG->MAP_ALERT_CLICK_HIGHLIGHT; ?>";
	var nodespantext = new Element('span', {'title':desc, 'style':'display:inline'});
	nodespantext.postid = postid;
	nodespantext.alerttype = alerttype;
	nodespantext.insert(name);
	Event.observe(nodespantext,"click", function(){
		//console.log("clicked:"+this.postid);
		auditAlertClicked(this.postid, this.alerttype);
		clearKnowledgeTreeSelections();
		selectKnowledgeTreeItem(this.postid);
		clearSelectedMapNodes(forcedirectedGraph)
		setSelectedMapNode(forcedirectedGraph, this.postid);
		panToNodeFD(forcedirectedGraph, this.postid);
		forcedirectedGraph.refresh();
	});
	nodespan.insert(nodespantext);
	container.insert(nodespan);
}

function createAlertUserLink(alerttype, postid, inneruser, container, display) {
	var type = alerttype.replace(/ /g,'');
	var id = 'post';
	if (display == 'none') {
		id = type;
	}
	var nodespan = new Element('div', {'name':id, 'class':'active', 'style':'display:'+display+';padding-top:10px;'});

<?php
	$nowtime = time();
	if ($CFG->TEST_TRIAL_NAME != "" && $nowtime >= $CFG->TEST_TRIAL_START && $nowtime < $CFG->TEST_TRIAL_END) { ?>

		var vote = new Element('img', {'title':'<?php echo $LNG->MAP_ALERT_SURVEY_QUESTION; ?>','style':'padding-top:4px;padding-right:5px'});
		vote.src = '<?php echo $HUB_FLM->getImagePath('thumb-up-filled.png'); ?>';
		vote.userid = inneruser.userid;
		vote.alerttype = alerttype;
		Event.observe(vote,"click", function(event){
			registerAlertSurveyReponse(this, this.userid, this.alerttype, event);
		});
		nodespan.insert(vote);
<?php } ?>

	var nodespantext = new Element('span', {'title':'<?php echo $LNG->NETWORKMAPS_EXPLORE_AUTHOR_HINT; ?>: '+inneruser.name, });
	nodespantext.userid = inneruser.userid;
	nodespantext.alerttype = alerttype;
	nodespantext.insert('<span>'+inneruser.name+'</span>');
	Event.observe(nodespantext,"click", function(){
		auditAlertClicked(this.userid, this.alerttype);
		viewUserHome(this.userid)
	});
	nodespan.insert(nodespantext);
	container.insert(nodespan);
}

function toggleAlertPosts(obj, alerttype) {
	var type = alerttype.replace(/ /g,'');
	var items = document.getElementsByName(type);
	for (var i=0; i<items.length; i++) {
		var item = items[i];
		if (item.style.display == 'none') {
			item.style.display = 'block';
			obj.update('<?php echo $LNG->MAP_ALERT_SHOW_LESS; ?>');
		} else {
			item.style.display = 'none';
			obj.update('<?php echo $LNG->MAP_ALERT_SHOW_ALL; ?>');
		}
	}
}

function registerAlertSurveyReponse(item, postid, alerttype, event) {
 	var event = event || window.event;
	var x = event.clientX;
	var y = event.clientY;

	var state = "<state><alerttype>"+alerttype+"</alerttype><mapid>"+NODE_ARGS['nodeid']+"</mapid></state>";
	auditTesting(postid, 'alerthelpfulness', 'feedback', state);

	$('message').style.left = (x-10)+getPageOffsetX()+"px";
	$('message').style.top = (y-10)+getPageOffsetY()+"px";
	$('message').update('<?php echo $LNG->MAP_SURVEY_THANKS; ?>');
	$('message').style.display = "block";
	fadein();
	setTimeout(function(){
		fadeout();
		setTimeout(function() {
			$('message').style.display = "none";
		}, 1500);
	},2500);
}
