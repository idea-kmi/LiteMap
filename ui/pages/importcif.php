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

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

$me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
if ($HUB_FLM->hasCustomVersion($me)) {
	$path = $HUB_FLM->getCodeDirPath($me);
	include_once($path);
	die;
}

// check that user logged in
if(!isset($USER->userid)){
	header('Location: index.php');
	exit();
}

array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/jit.js').'" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/networkmaps/visualisations/graphlib.js.php').'" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/networkmaps/visualisations/importforcedirectedlib.js.php').'" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/networkmaps/networklib.js.php').'" type="text/javascript"></script>');

array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/widget.js.php').'" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/tabbermap.js.php').'" type="text/javascript"></script>');

array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath('widget.css').'" type="text/css" media="screen" />');
array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath('vis.css').'" type="text/css" media="screen" />');
array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/base.css').'" type="text/css" />');
array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/ForceDirected.css').'" type="text/css" />');

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
?>

<script type='text/javascript'>
var EDIT_WIDTH = '240';
var MAP_HEIGHT_MINIMUM = 500;
var IMPORT_LIMIT = <?php echo $CFG->ImportLimit; ?>;
var forcedirectedGraph = null;
var baseSize = '';
var nodesonly = false;
var isTreeShowing = false;
var allnodes = null;

Event.observe(window, 'load', function() {
	initialiseMap();
	toggleConnections($('nodesonly'));
});


function initialiseMap() {
	$("preview-cif-div").innerHTML = "";
	$("preview-toolbar-div").innerHTML = "";


	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("preview-cif-div").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var graphDiv = new Element('div', {'id':'graphPreviewCIFDiv', 'style': 'clear:both;float:left'});
	var width = 4000;
	var height = 4000;
	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerDiv = new Element('div', {'id':'graphPreviewCIFDiv-outer', 'style': 'clear:both;float:left;margin:0px;padding:0px;overflow:hidden;'});
	var messagearea = new Element("div", {'id':'mapmessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});
	outerDiv.insert(messagearea);
	outerDiv.insert(graphDiv);
	$("preview-cif-div").insert(outerDiv);

	forcedirectedGraph = createImportForceDirectedGraph('graphPreviewCIFDiv', '');

	var toolbar = createImportGraphToolbar(forcedirectedGraph, "preview-cif-div");
	$("preview-toolbar-div").insert({top: toolbar});

	//event to resize
	Event.observe(window,"resize",function() {
		resizeMainArea(false);
	});

	baseSize = calulateInitialGraphViewport("mainouterdiv");
	resizeMainArea(true);
}

function toggleConnections(obj) {
	if (obj.checked) {
		$('preview-toolbar-div').style.display = 'none';
		$('treedata').style.display = 'none';
		$('connectioncountdiv').style.display = 'none';
		$('preview-cif-div').style.display = 'none';
		$('treedata').style.display = 'none';
		$('importnodesonly').style.display = 'block';
		$('importmapdiv').style.display = 'none';
		$('privacydiv').style.display = 'block';
	} else {
		if ($('dataurlrun').value != "") {
			$('preview-toolbar-div').style.display = 'block';
		}
		if (isTreeShowing == true) {
			$('treedata').style.display = 'block';
		} else {
			$('preview-cif-div').style.display = 'block';
		}
		$('connectioncountdiv').style.display = 'block';
		$('importnodesonly').style.display = 'none';
		$('importmapdiv').style.display = 'block';
		$('privacydiv').style.display = 'none';
	}
}

function resizeMainArea(initial) {

	var newwidth = baseSize.width-247;
	var width = newwidth;

	var height = baseSize.height;
	if (height < MAP_HEIGHT_MINIMUM) {
		height = MAP_HEIGHT_MINIMUM;
	}
	//alert(width);
	//alert(height);

	$('graphPreviewCIFDiv-outer').style.width = width+"px";
	$('graphPreviewCIFDiv-outer').style.height = height-140+"px";

	$('treedata').style.width = width+"px";
	$('treedata').style.height = height-140+"px";

	$('preview-cif-ideas-div').style.height = height-100+"px";
	$('ideacell').style.height = height-100+"px";

	// important or all mouse events are off by the amount of the sidebar width.
	if (!$('nodesonly').checked && forcedirectedGraph && !initial) {
		relayoutMap(forcedirectedGraph);
	}
}

function toggleMapTree(button) {
	if ($('treedata').style.display == 'none') {
		isTreeShowing = true;
		$('treedata').style.display = 'block';
		$('preview-cif-div').style.display = 'none';
		button.src = "<?php echo $HUB_FLM->getImagePath('network-graph.png'); ?>";
		button.title = "<?php echo $LNG->NETWORKMAPS_VIEW_MAP; ?>";
		if ($('keydiv')) {
			$('keydiv').style.visibility = 'hidden';
		}
	} else {
		isTreeShowing = false;
		$('preview-cif-div').style.display = 'block';
		$('treedata').style.display = 'none';
		button.src = "<?php echo $HUB_FLM->getImagePath('knowledge-tree.png'); ?>";
		button.title = "<?php echo $LNG->NETWORKMAPS_VIEW_LINEAR; ?>";
		if ($('keydiv')) {
			$('keydiv').style.visibility = 'visible';
		}
	}
}

function clearRun() {
	$('cifdataurl').value = "";
	initialiseMap();
	$('nodecount').update(0);
	$('connectioncount').update(0);
	$('mapmessage').innerHTML="";
	$('preview-toolbar-div').style.display = 'none';
	$('selectallimportbutton').style.display = 'none';
	$('deselectallimportbutton').style.display = 'none';
	$('importareadiv').style.display = 'none';
	$('preview-cif-ideas-div').innerHTML = "";
	$('treedata').innerHTML = "";
	$('treedata').style.display = 'none';
	$('mapid').value = "";
	$('newmapname').innerHTML = "";
	clearloadbutton.style.display = 'none';
	loadbutton.style.display = 'block';
}

function loadCIFData() {

	var cifdataurl = ($('cifdataurl').value).trim();
	if (cifdataurl == "") {
		var cifdataurl = prompt("<?php echo $LNG->IMPORT_CIF_DATA_URL_ERROR; ?>", "<?php echo $LNG->IMPORT_CIF_DATA_URL_PLACEHOLDER; ?>");
		if (cifdataurl == null) {
			return false;
		} else {
			$('cifdataurl').value = cifdataurl;
		}
	} else {
		if (!isValidURI(cifdataurl)) {
			alert("<?php echo $LNG->IMPORT_CIF_DATA_URL_INVALID; ?>");
			$('cifdataurl').focus();
			return false;
		}
	}

	loadbutton.style.display = 'none';
	var nodesonly = $('nodesonly').checked;
	$('ideasmessage').update(getLoading("<?php echo $LNG->LOADING_MESSAGE; ?>"));
	$('importlimit').style.display = 'none';
	if (!nodesonly) {
		$('mapmessage').update(getLoading("<?php echo $LNG->LOADING_MESSAGE; ?>"));
	}

	var allConnections = new Array();

	var reqUrl = SERVICE_ROOT+"&method=getdatafromjsonld&url="+encodeURIComponent(cifdataurl)+"&timeout=1800";
	//alert(reqUrl);

	new Ajax.Request(reqUrl, {
		method:'post',
		onSuccess: function(transport){
			//alert(transport.responseText);
			var json = null;
			try {
				json = transport.responseText.evalJSON();
			} catch(e) {
				alert(e);
				return;
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			$('dataurlrun').value = cifdataurl;
			$('importareadiv').style.display = 'block';

			//alert(json.cifdata[0].connections[0].connectionset.connections);
			//alert(json.cifdata[0].nodes[0].nodeset.nodes.toSource());

			var nodes = json.cifdata[0].nodes[0].nodeset.nodes;
			//alert(nodes.length);
			allnodes = nodes;
			if (nodes.length > 0) {
				if (nodes.length > IMPORT_LIMIT) {
					$('importlimit').style.display = 'block';
				} else {
					$('importlimit').style.display = 'none';
				}
				$('nodecount').update(nodes.length);
				displayIdeaBarNodes($('preview-cif-ideas-div'), nodes, 0);
				$('ideasmessage').innerHTML="";
				$('selectallimportbutton').style.display = 'block';
				$('deselectallimportbutton').style.display = 'block';
			} else {
				$('ideasmessage').innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
			}

			var conns = json.cifdata[0].connections[0].connectionset.connections;
			//alert("conns: "+conns.length);
			if (conns.length > 0 && !nodesonly) {
				var iterations = 200;
				if (conns.length > IMPORT_LIMIT) {
					iterations = 500;
					forcedirectedGraph.levelDistance = 300;
				}
				$('connectioncount').update(conns.length);
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					allConnections.push(c);
					addConnectionToFDGraph(c, forcedirectedGraph.graph);
				}

				computeMostConnectedNode(forcedirectedGraph);
				layoutAndAnimateFD(forcedirectedGraph, $('mapmessage'), iterations);
				drawTree(allConnections);

				$('mapmessage').innerHTML="";
				$('preview-toolbar-div').style.display = 'block';
				clearloadbutton.style.display = 'block';
			} else if (conns.length == 0) {
				$('mapmessage').innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
			}

			$('importmapdiv').scrollIntoView(false);
			selectAllImportNodes();
		}
	});
}

/**
 * Render a list of nodes
 */
function displayIdeaBarNodes(objDiv,nodes,start){
	objDiv.insert('<div style="clear:both; margin: 0px; padding: 0px;"></div>');
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol', 'style':'background:white;margin:0px;padding:0px;overflow-y: auto; overflow-x: hidden; height:100%'});
	for(var i=0; i< nodes.length; i++){
		//alert(nodes[i].toSource());
		var percentage = (nodes.length/100) * (i+1);
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'style':'width:220px'});
			var blobNode = renderImportPickerNode(nodes[i].cnode, nodes[i].cnode.role[0].role, i);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render the given node for drawing on the import Picker list.
 * @param node the node object to render
 * @param role the role object for this node
 */
function renderImportPickerNode(node, role, i){
	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";
	//nodeTable.border="1";

	var row = nodeTable.insertRow(-1);
	row.id = "row"+node.nodeid;

	var inChk = new Element("input",{'type':'checkbox', 'name':'nodecheck', 'id':'nodecheck'+node.nodeid});
	inChk.nodeid = node.nodeid;
	var checkCell = row.insertCell(-1);
	checkCell.vAlign="top";
	checkCell.align="left";
	checkCell.insert(inChk);
	checkCell.width="20";
	Event.observe(inChk,"change", function(){
		if (this.checked) {
			selectImportNode(this.nodeid);
		} else {
			deselectImportNode(this.nodeid);
		}
	});

	var leftCell = row.insertCell(-1);
	leftCell.vAlign="top";
	leftCell.align="left";
	leftCell.width="22";
	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:20px;height:20px;','align':'left','border':'0','src': URL_ROOT + role.image});
		leftCell.insert(nodeicon);
	} else {
		leftCell.insert(alttext+": ");
	}

	var rightCell = row.insertCell(-1);
	rightCell.vAlign="top";
	rightCell.align="left";
	rightCell.insert('<span style="padding-left:5px;">'+node.name+'</span>');

	ihDiv.insert(nodeTable);

	iDiv.insert(ihDiv);
	iDiv.insert('<div style="clear:both;"></div>');

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	iwDiv.insert('<div style="clear:both;"></div>');
	iDiv.insert(iwDiv);

	return iDiv;
}

function drawTree(allConnections) {
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
				toNode.cnode.children = new Array();
				checkNodes[toNode.cnode.nodeid] = toNode.cnode.nodeid;
			}

			var fromNode = c.from[0];
			if (fromNode.cnode.name != "") {
				if (checkNodes.indexOf(fromNode.cnode.nodeid) == -1) {
					fromNode.cnode['connection'] = c;
					fromNode.cnode['handler'] = "";

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextTreeDepth(fromNode, checkNodes, toNodeConnections)
				}
			}
		}

		toNode.cnode.children.sort(alphanodesort);
		treeTopNodes.push(toNode);
	}

	treeTopNodes.sort(alphanodesort);

	if (treeTopNodes.length > 0){
		displayImportConnectionNodes($('treedata'), treeTopNodes, parseInt(0), "mapnarrow");
	}
}

function recurseNextTreeDepth(toNode, checkNodes, toNodeConnections) {

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

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextTreeDepth(fromNode, checkNodes, toNodeConnections)
				}
			}
		}
	}
}


/**
 * Render a list of connection nodes
 */
function displayImportConnectionNodes(objDiv, nodes,start,uniqueid, childCountSpan, parentrefreshhandler){
	if (uniqueid == undefined) {
		uniqueid = 'idea-list';
	}

	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol', 'style':'float:left;margin-top:0px;padding-top: 0px;padding-bottom:0px;'});
	for(var i=0; i< nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'margin: 0px; padding: 0px;'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list', 'style':'clear:both;float:left;margin: 0px; padding: 0px;'});
			var blobNode = renderImportConnectionNode(nodes[i].cnode, uniqueid,nodes[i].cnode.role[0].role,'inactive', childCountSpan, parentrefreshhandler);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}

	objDiv.insert(lOL);
}

/**
 * Render the given node from an associated connection in the knowledge tree.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 * @param childCountSpan The element into which to put the running total of children in this conneciotn tree..
 * @param parentrefreshhandler a statment to eval after actions have occurred to refresh this list.
 */
function renderImportConnectionNode(node, uniQ, role, type, childCountSpan, parentrefreshhandler){

	if (type === undefined) {
		type = "active";
	}

	if (childCountSpan === undefined) {
		childCountSpan = null;
	}

	var originaluniQ = uniQ;

	if(role === undefined){
		role = node.role[0].role;
	}

	var connection = node.connection;
	var user = null;
	if (connection && connection.users) {
		user = connection.users[0].user;
	}

	//needs to check if embedded as a snippet
	var breakout = "";
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalnodeid = "";
	if (node.focalnodeid) {
		focalnodeid = node.focalnodeid;
	}
	var focalrole = "";
	var connrole = role;
	var otherend = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			connrole = connection.fromrole[0].role;
			focalrole = tN.role[0].role;
			otherend = tN;
		} else {
			connrole = connection.torole[0].role;
			focalrole = fN.role[0].role;
			otherend = fN;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title','style':'padding:0px;'});

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";
	//nodeTable.border = "1";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	//row.id = "treerow"+uniQ;

	var lineCell = row.insertCell(-1);
	lineCell.width="15px;"
	lineCell.vAlign="middle";
	var lineDiv = new Element('div',{'class':'graylinewide', 'style':'float:left;width:100%;'});
	lineCell.insert(lineDiv);

	var inChk = new Element("input",{'type':'checkbox','name':'treenodecheck'});
	inChk.nodeid = node.nodeid;
	Event.observe(inChk,"change", function(){
		if (this.checked) {
			selectImportNode(this.nodeid);
		} else {
			deselectImportNode(this.nodeid);
		}
	});
	var checkCell = row.insertCell(-1);
	checkCell.vAlign="middle";
	checkCell.align="left";
	checkCell.insert(inChk);

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	var textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell', 'class':'whiteborder', 'style':'float:left;padding:3px;'});
	textCellDiv.nodeid = node.nodeid;
	textCellDiv.focalnodeid = node.focalnodeid;
	textCellDiv.nodetype = role.name;
	textCellDiv.parentuniQ = originaluniQ;
	if (connection) {
		textCellDiv.connection = connection;
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";
	toolbarCell.width="80";

	textCell.insert(textCellDiv);

	var dStr = "";
	if (user != null) {
		var cDate = new Date(connection.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_TOGGLE_HINT;?>'
	}

	// ADD THE NODE ICON
	var nodeArea = new Element("a", {'class':'itemtext', 'name':'nodeArea', 'style':'float:left;padding-top:2px;','title':dStr} );
	nodeArea.nodeid = node.nodeid;
	if (typeof node.focalnodeid != 'undefined') {
		nodeArea.focalnodeid = node.focalnodeid;
	}

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i< node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'target': '_blank' });
		var nodeicon = new Element('img',{'alt':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'style':'width:20px;height:20px;padding-right:5px;','align':'left', 'border':'0','src': URL_ROOT + node.imagethumbnail});
		iconlink.insert(nodeicon);
		nodeArea.insert(iconlink);
		nodeArea.insert(alttext+": ");
	} else if (node.image != null && node.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:24px;height:24px;padding-right:5px;','align':'left','border':'0','src': URL_ROOT + node.image});
		nodeArea.insert(nodeicon);
	} else if (connrole.image != null && connrole.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:24px;height:24px;padding-right:5px;','align':'left','border':'0','src': URL_ROOT + connrole.image});
		nodeArea.insert(nodeicon);
	} else {
		nodeArea.insert(alttext+": ");
	}

	// ADD THE NODE LABEL
	textCellDiv.insert(nodeArea);
	if (node.nodeid == node.focalnodeid) {
		nodeArea.className = "itemtextwhite";
	} else {
		nodeArea.className = "itemtext unselectedlabel";
	}
	var nodeextra = getNodeTitleAntecedence(role.name, true);
	nodeArea.insert(node.name);

	nodeArea.href= "#";
	Event.observe(nodeArea,'click',function (){
		$("desc"+uniQ).toggle();
	});

	if (node.istop) {
		var expandArrow = null;
		if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 || role.name == "Challenge"
			|| role.name == "Issue" || role.name == "Solution" || role.name == "Idea"
			|| role.name == "Pro"  || role.name == "Con" || role.name == "Argument") {

			var childCount = new Element('div',{'style':'float:left; margin-left:5px;margin-right:5px;margin-top:2px;', 'title':'<?php echo $LNG->NODE_DEBATE_TREE_COUNT_HINT; ?>'});
			childCount.insert("(");
			childCountSpan = new Element('span',{'name':'toptreecount'});
			childCountSpan.id = 'toptreecount'+uniQ;
			childCountSpan.insert(1);
			childCountSpan.uniqueid = uniQ;
			childCount.insert(childCountSpan);
			childCount.insert(")");
			toolbarCell.insert(childCount);
		}
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'treedesc'+uniQ,'class':'ideadata', 'style':'padding:0px;margin-left:0px;color:Gray;'} );
	if (node.istop) {
		if (DEBATE_TREE_OPEN_ARRAY["treedesc"+uniQ] && DEBATE_TREE_OPEN_ARRAY["treedesc"+uniQ] == true) {
			expandDiv.style.display = 'block';
		} else {
			expandDiv.style.display = 'none';
		}
	} else {
		expandDiv.style.display = 'block';
	}
	var hint = alttext+": "+node.name;

	/**
	 * This is for the rollover hint around the vertical line - background image 21px wide 1px line in middle
	 * This was the only way to get it to work in all four main browsers!!!!!
   	 **/
	var expandTable = new Element( 'table', {'style':'empty-cells:show;border-collapse:collapse;'} );
	expandTable.height="100%";
	var expandrow = expandTable.insertRow(-1);
	expandrow.style.height="100%";
	if (node.istop) {
		expandTable.style.marginLeft = "5px";
	} else {
		expandTable.style.marginLeft = "20px";
	}

	var lineCell = expandrow.insertCell(-1);
	lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
	lineCell.width="5px;";
	lineCell.style.marginLeft="3px";

	lineCell.title=hint;
	lineCell.className="grayline";
	Event.observe(lineCell,'click',function (){
		var pos = getPosition(textCellDiv);
		window.scroll(0,pos.y-3);
	});

	var childCell = expandrow.insertCell(-1);
	childCell.vAlign="top";
	childCell.align="left";
	childCell.style.padding="0px";
	childCell.style.margin="0px";

	expandDiv.insert(expandTable);

	if (node.istop) {
		expandDiv.style.marginLeft = "22px";
	} else {
		expandDiv.style.marginLeft = "4px";
	}

	/** EXPAND DIV **/
	var innerexpandDiv = new Element("div", {'id':'desc'+uniQ,'class':'ideadata', 'style':'padding-left:20px;color:Gray;display:none;'} );

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";

	innerexpandDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var nextCell = row.insertCell(-1);
	nextCell.vAlign="middle";
	nextCell.align="left";

	// META DATA - DESCRIPTION, URLS, ETC

	var dStr = "";
	if(node.description){
		dStr += '<div style="margin:0px;padding:0px;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
		if (node.description && node.description != "") {
			innerexpandDiv.description = true;
			dStr += node.description;
		}
		dStr += '</div>';
		innerexpandDiv.insert(dStr);
	}

	// CHILD LISTS
	if (node.children) {
		var nodes = node.children
		if (nodes.length > 0) {
			childCell.insert('<div style="clear:both;"></div>');
			var childrenDiv = new Element("div", {'id':'children'+uniQ, 'style':'clear:both;float:left;margin-left:0px;padding-left:0px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(childrenDiv);
			childCell.insert('<div style="clear:both;"></div>');
			if (expandArrow) {
				expandArrow.style.visibility = 'visible';
			}
			var parentrefreshhanlder = "";

			if (node.istop) {
				childCountSpan.update(nodes.length+1);
			} else {
				if (childCountSpan != null) {
					var countnow = parseInt(childCountSpan.innerHTML);
					var finalcount = countnow+nodes.length;
					childCountSpan.innerHTML = finalcount;
				}
			}
			displayImportConnectionNodes(childrenDiv, nodes, parseInt(0), uniQ, childCountSpan, parentrefreshhanlder);
		}
	} else {
		lineCell.className=""; // = "1px solid white"; // hide the dot
	}

	idDiv.insert(innerexpandDiv);
	idDiv.insert(expandDiv);
	imDiv.insert(idDiv);
	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}

function selectAllImportNodes() {
	selectAllKnowledgeTreeItems();
	selectAllMapNodes(forcedirectedGraph);
	forcedirectedGraph.refresh();
	for(var i=0; i< allnodes.length; i++) {
		if(allnodes[i].cnode) {
			var nodeid = allnodes[i].cnode.nodeid;
			//$('row'+nodeid).style.background = 'yellow';
			$('nodecheck'+nodeid).checked = true;
		}
	}
}

function deselectAllImportNodes() {
	clearKnowledgeTreeSelections();
	clearSelectedMapNodes(forcedirectedGraph);
	forcedirectedGraph.refresh();
	for(var i=0; i< allnodes.length; i++){
		if(allnodes[i].cnode){
			var nodeid = allnodes[i].cnode.nodeid;
			//$('row'+nodeid).style.background = 'white';
			$('nodecheck'+nodeid).checked = false;
		}
	}
}

function selectImportNode(nodeid) {
	//$('row'+nodeid).style.background = 'yellow';
	$('nodecheck'+nodeid).checked = true;
	selectImportKnowledgeTreeItem(nodeid);
	setSelectedMapNode(forcedirectedGraph, nodeid);
	forcedirectedGraph.refresh();
}

function deselectImportNode(nodeid) {
	//$('row'+nodeid).style.background = 'white';
	$('nodecheck'+nodeid).checked = false;
	clearSelectImportKnowledgeTreeItem(nodeid);
	clearSelectedMapNode(forcedirectedGraph, nodeid);
	forcedirectedGraph.refresh();
}

/**
 * Select all knowledge tree items.
 */
function selectAllKnowledgeTreeItems() {
	cellsArray = document.getElementsByName('treenodecheck');
	count = cellsArray.length;
	next = null;
	for (var i=0; i<count; i++) {
		next = cellsArray[i];
		next.checked = true;
	}
}

/**
 * Deselect all knowledge tree items.
 */
function clearKnowledgeTreeSelections() {
	cellsArray = document.getElementsByName('treenodecheck');
	count = cellsArray.length;
	next = null;
	for (var i=0; i<count; i++) {
		next = cellsArray[i];
		next.checked = false;
	}
}

/**
 * Find the given node in the tree and highlight if found.
 */
function selectImportKnowledgeTreeItem(nodeid) {
	cellsArray = document.getElementsByName('treenodecheck');
	count = cellsArray.length;
	next = null;
	for (var i=0; i<count; i++) {
		next = cellsArray[i];
		if (next.nodeid == nodeid) {
			next.checked = true;
			/*if ($('treedata')) {
				var pos = getPosition(next);
				var y = pos.y - 150;
				if (y < 0) {
					y = 0;
				}
				$('treedata').scrollTop = y;
			}*/
			break;
		}
	}
}

/**
 * Find the given node in the tree and unhighlight if found.
 */
function clearSelectImportKnowledgeTreeItem(nodeid) {
	cellsArray = document.getElementsByName('treenodecheck');
	count = cellsArray.length;
	next = null;
	for (var i=0; i<count; i++) {
		next = cellsArray[i];
		if (next.nodeid == nodeid) {
			next.checked = false;
			break;
		}
	}
}

function importAssignMap(mapid, mapname, private) {
	$('mapid').value = mapid;
	if (private == 'Y') {
		$('public').checked = false;
	} else {
		$('public').checked = true;
	}
	$('newmapname').insert(mapname);
	$('newmapname').style.display = 'block';
	$('createnewmapbutton').style.display = 'none';
	$('importnodesandcons').style.display = 'block';
}

function showMapAddForm() {
	loadDialog('addbox',URL_ROOT+'ui/popups/mapadd.php?handler=importAssignMap', 750,540);
}

function importNodesOnly() {

	var cifdataurl = $('dataurlrun').value;
	var private = 'Y';
	if ($('public').checked == true) {
		private = 'N';
	}

	$('importareadiv').style.display = 'none';
	$('importingmessage').update(getLoading("<?php echo $LNG->IMPORT_CIF_LOADING; ?>"));

	var selectedids = [];
	var nodechecks = document.getElementsByName('nodecheck');
	var count = nodechecks.length;
	var allSelected = true;

	var selectedids = "";
	var num;
	for(var i=0; i<count; i++) {
		if (nodechecks[i].checked == true) {
			selectedids += "&selectedids[]="+nodechecks[i].nodeid;
			num++;
		} else {
			allSelected = false;
		}
	}

	if (num > IMPORT_LIMIT) {
		$('importingmessage').innerHTML = "";
		$('importareadiv').style.display = 'block';
		alert('<?php echo $LNG->IMPORT_CIF_LIMIT_MESSAGE_REACHED; ?>');
		return;
	}

	if (allSelected) {
		selectedids = "";
	}
	//alert(selectedids.toSource());

	var params = "format=json&private="+private+"&method=addnodesfromjsonld&url="+encodeURIComponent(cifdataurl)+selectedids;
	var reqUrl = URL_ROOT+"api/service.php";
	//alert(reqUrl);

	new Ajax.Request(reqUrl, {
		method:'post',
		parameters: params,
		onSuccess: function(transport){
			//alert(transport.responseText);
			var json = null;
			try {
				json = transport.responseText.evalJSON();
			} catch(e) {
				alert(e);
				return;
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			$('importingmessage').innerHTML = "";
			window.location.href = URL_ROOT+"user.php?userid="+USER;
		}
	});
}

function importNodesAndConnections() {
	var cifdataurl = $('dataurlrun').value;
	var mapid = $('mapid').value;
	if (mapid == 0) {
		alert('<?php echo $LNG->IMPORT_CIF_IMPORT_INTO_HELP; ?>');
		$('mapselector').focus();
	}

	var private = 'Y';
	if ($('public').checked == true) {
		private = 'N';
	}

	$('importareadiv').style.display = 'none';
	$('importingmessage').update(getLoading("<?php echo $LNG->IMPORT_CIF_LOADING; ?>"));

	var selectedids = [];
	var nodechecks = document.getElementsByName('nodecheck');
	var count = nodechecks.length;
	var allSelected = true;

	var selectedids = "";
	var poses = "";
	var num = 0;
	for(var i=0; i<count; i++) {
		if (nodechecks[i].checked == true) {
			num++;
			selectedids += "&selectedids[]="+nodechecks[i].nodeid;
			var node = forcedirectedGraph.graph.getNode(nodechecks[i].nodeid);
			if (node) {
				var actualpos = node.pos.getc(true);
				poses += "&poses[]="+actualpos.x+":"+actualpos.y;
			} else {
				poses += "&poses[]=";
			}
		} else {
			allSelected = false;
		}
	}

	if (num > IMPORT_LIMIT) {
		$('importingmessage').innerHTML = "";
		$('importareadiv').style.display = 'block';
		alert('<?php echo $LNG->IMPORT_CIF_LIMIT_MESSAGE_REACHED; ?>');
		return;
	}

	//alert("poses="+poses);
	//console.log(poses);

	var params = "format=json&private="+private+"&method=addnodesandconnectionsfromjsonld&mapid="+mapid+"&url="+encodeURIComponent(cifdataurl)+selectedids+poses;
	var reqUrl = URL_ROOT+"api/service.php";

	//alert(reqUrl);

	new Ajax.Request(reqUrl, {
		method:'post',
		parameters: params,
		onSuccess: function(transport){
			//alert(transport.responseText);
			var json = null;
			try {
				json = transport.responseText.evalJSON();
			} catch(e) {
				alert(e);
				return;
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			$('importingmessage').innerHTML = "";
			window.location.href = URL_ROOT+"map.php?id="+mapid;
		}
	});
}

</script>

<input id="dataurlrun" type="hidden" value="" />

<div class="challengebackpale" style="clear:both;float:left;width:100%;">
	<h1 style="padding-left:10px;"><?php echo $LNG->IMPORT_CIF_TITLE; ?> <span style="margin-left: 10px;font-size:60%; font-weight:normal">(<a target="_blank" href="http://purl.org/catalyst/jsonld"><?php echo $LNG->IMPORT_CIF_FORMAT_LINK; ?></a>)</span></h1>
    <div class="formrow">
		<label for="cifdataurl" style="float:left;padding-right:5px;font-size:11pt;font-weight:bold"><?php echo 'CIF data url:'; ?></label>
		<input id="cifdataurl" style="float:left;width:450px;" placeholder="<?php echo $LNG->IMPORT_CIF_DATA_URL_PLACEHOLDER; ?>" />
		<input type="checkbox" onchange="toggleConnections(this)" id="nodesonly" style="float:left;padding-top:3px;padding-right:5px;"></input>
		<label style="float:left;padding-top:2px;padding-right:5px;font-weight:bold;"><?php echo $LNG->IMPORT_CIF_NODES_ONLY; ?></label>
        <input id="loadbutton" type="button" style="float:left;margin-left:20px;display:block" onclick="loadCIFData()" value="<?php echo $LNG->IMPORT_CIF_LOAD; ?>"></input>
        <input id="clearloadbutton" type="button" style="float:left;margin-left:20px;display:none" onclick="clearRun()" value="<?php echo $LNG->IMPORT_CIF_CLEAR_LOAD; ?>"></input>
    </div>
    <div style="float:left;clear:both;margin-top:10px;margin-bottom:5px;">
		<div id="importlimit" style="clear:both;float:left;padding:5px; margin-left:5px;margin-bottom:5px;font-weight:bold;display:none;border:2px solid yellow;background:#FFF8BD"><?php echo $LNG->IMPORT_CIF_LIMIT_MESSAGE; ?></div>
		<div style="clear:both;float:left;padding:5px; margin-left:5px;"><?php echo $LNG->IMPORT_CIF_IMPORT_MESSAGE; ?><br><?php echo $LNG->IMPORT_CIF_IMPORT_MESSAGE2; ?></div>
        <input id="selectallimportbutton" type="button" style="float:left;display:none;margin-left:10px;" onclick="selectAllImportNodes()" value="<?php echo $LNG->IMPORT_CIF_SELECT_ALL; ?>"></input>
        <input id="deselectallimportbutton" type="button" style="float:left;display:none;margin-left:10px;margin-right:10px;" onclick="deselectAllImportNodes()" value="<?php echo $LNG->IMPORT_CIF_DESELECT_ALL; ?>"></input>
		<div id="nodecountdiv" style="float:left;font-weight:bold;margin-left:10px;margin-top:3px;"><?php echo $LNG->IMPORT_CIF_NODE_COUNT; ?> <span id="nodecount">0</span></div>
		<div id="connectioncountdiv" style="float:left;font-weight:bold;display:block;margin-left:20px;margin-top:3px;"><?php echo $LNG->IMPORT_CIF_CONNECTION_COUNT; ?> <span id="connectioncount">0</span></div>
	</div>
</div>

<div id="mainouterdiv" style="clear:both;float:left;width:100%;">
	<!-- Yes, I know, table bad -->
	<table cellspacing="0" style="border:1px solid #C0C0C0;padding:0px;border:collapse:collpase;clear:both;float:left;width:100%;height:100%">
		<tr>
			<td id="ideacell" width="240" align="left" style="font-size:10pt;width:240px;height:100%;vertical-align:top;display:table-cell;border-right:1px solid #C0C0C0;">
				<div id="ideasmessage" class="toolbitem" style="float:left;clear:both;font-weight:bold"></div>
				<div id="preview-cif-ideas-div" style="clear:both;float:left;width:240px;height:500px;overflow-y:auto"></div>
			</td>
			<td id="mapcell" align="left" valign="top" style="overflow:hidden;vertical-align:top;">
				<div id="preview-toolbar-div" style="clear:both;float:left;width:100%;display:none;border-bottom:1px solid #C0C0C0;"></div>
				<div id="preview-cif-div" style="clear:both;float:left;width:100%;height:100%;overflow:hidden;display:block"></div>
				<div id="treedata" style="clear:both;float:left;background:white;display:none;width:100%;height:100%;overflow-y:auto;"></div>
			</td>
		</tr>
	</table>
</div>

<div id="importareadiv" class="challengebackpale" style="clear:both;float:left;width:100%;padding-bottom:5px;display:none;">
   <div class="formrow">
		<div id="privacydiv" style="float:left;margin-right:20px;display:none">
			<label  style="float:left;margin-left: 5px; margin-right: 2px;font-weight:bold" for="private"><?php echo $LNG->FORM_PRIVACY; ?>
				<span class="active" title="<?php echo $LNG->IMPORT_CIF_PRIVACY_HINT; ?>"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></span>
			</label>
			<input style="float:left;" type="checkbox" onchange="if (this.checked) {$('privacylockimg').src='<?php echo $HUB_FLM->getImagePath('unlock-32.png'); ?>' } else {$('privacylockimg').src='<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>'}" class="forminput" id="public" name="public" value="N" checked="true" />
			<img id="privacylockimg" onclick="$('private').click()" style="float:left;width:20px;height:20px;" src="<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>" />
		</div>

        <input id="importnodesonly" type="button" style="float:left;display:none" onclick="importNodesOnly()" value="<?php echo $LNG->IMPORT_CIF_IMPORT; ?>"></input>

		<div id="importmapdiv" style="float:left;display:block;">
			<div style="clear:both;float:left;margin-bottom:10px;"><?php echo $LNG->IMPORT_CIF_CONDITIONS_MESSAGE; ?></div>
			<label style="clear:both;float:left;font-weight:bold;font-size:11pt;margin-top:2px;" id="importmap"><?php echo $LNG->IMPORT_CIF_IMPORT_INTO; ?></label>
			<label id="newmapname" style="float:left;font-size:11pt;"></label>
			<input id="mapid" name="private" type="hidden" value="" />
			<span id="createnewmapbutton" style="float:left;margin-left:10px;margin-top:4px;" class="active" onclick="showMapAddForm()">  <?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?> </span>
			<input style="float:left;margin-left:10px;display:none" id="importnodesandcons" type="button" onclick="importNodesAndConnections()" value="<?php echo $LNG->IMPORT_CIF_IMPORT; ?>"></input>
        </div>
    </div>
</div>

<div id="importingmessage" style="float:left;clear:both;"></div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
