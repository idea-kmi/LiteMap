<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2013 The Open University UK                                   *
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
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("node.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='screen' />");

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='print' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("node.css")."' type='text/css' media='print' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='print' />");

    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/node.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/users.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/util.js.php")."' type='text/javascript'></script>");

    array_push($HEADER,"<script src='".$CFG->homeAddress."ui/lib/dateformat.js' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/headerreport.php"));

    $title = required_param("title", PARAM_TEXT);
    $nodeid = required_param("nodeid", PARAM_TEXT);
 ?>
<style type="text/css">
 @media print {
 	input#btnPrint {
 		display: none;
 	}
 }
</style>
<script type="text/javascript">
//<![CDATA[
var nodeid = "<?php echo $nodeid; ?>";
var nodetitle = "<?php echo $title; ?>";
var CURRENT_ADD_AREA_NODEID = "<?php echo $nodeid; ?>";

function loadMapData() {

	var reqUrl = SERVICE_ROOT + "&method=getview&viewid=" + encodeURIComponent(nodeid);
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
			//alert(conns.length);

			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var viewconnection = conns[i].viewconnection;
					var c = viewconnection.connection[0].connection;
					if (c) {
						allConnections.push(c);
					}
				}
			}

			if (conns.length > 0) {
				drawTree(allConnections, challengenodeid);
			}
		}
	});
}

function drawTree(allConnections, challengenodeid) {
	$('printknowledgetree').update("");

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
		displayReportConnectionNodes($('printknowledgetree'), treeTopNodes, parseInt(0), true, "mapnarrow");
		$('loadingdiv').innerHTML = "";
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
	}
}

/**
*  set which tab to show and load first
*/
Event.observe(window, 'load', function() {
    $('dialogheader').insert('<?php echo $title; ?>');
	document.title = nodetitle;
	document.body.style.backgroundColor = "white"
	loadMapData();
});
//]]>
</script>

<h1 id="innertitle" style="clear:both; margin:10px;text-align:center;"></h1>

<input style="margin-left: 10px;margin-bottom:10px;" type="button" id="btnPrint" value=" <?php echo $LNG->FORM_BUTTON_PRINT_PAGE; ?> " onclick="window.print();return false;" />

<div id="printknowledgetree" style="margin: 10px;background-color:white;"></div>

<div id="loadingdiv" class="loading" style="clear:both; float:left"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_DATA; ?><br><center><?php echo $LNG->FORM_PRINT_LOADING_MESSAGE; ?></center></div>

</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>