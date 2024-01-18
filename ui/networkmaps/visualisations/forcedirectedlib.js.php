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

/** REQUIRES: graphlib.js.php **/

$jit.ForceDirected.Plot.EdgeTypes.implement({

	'labelarrow': {
		'render': function(adj, canvas) {
			var orifrom = adj.nodeFrom.pos.getc(true);
			var orito = adj.nodeTo.pos.getc(true);

			//alert("fromNode = "+adj.nodeTo.pos.getc(true));
			//alert("toNode = "+adj.nodeFrom.pos.getc(true));

			// want the to and from to be where the line intercepcts the node boxes.
			var to = computeIntersectionWithRectangle(adj.nodeTo, orito, orifrom);
			var from = computeIntersectionWithRectangle(adj.nodeFrom, orifrom, orito);

			if (!to) {
				to = orito;
			}
			if (!from) {
				from = orifrom
			}

			var dim = adj.getData('dim');
			var direction = adj.data.$direction;
			var swap = (direction && direction.length>1 && direction[0] != adj.nodeFrom.id);

			var context = canvas.getCtx();
			// invert edge direction
			if (swap) {
				var tmp = from;
				from = to;
				to = tmp;
			}

			//var orifromrole = adj.nodeFrom.getData('orirole');
			//var oritorole = adj.nodeTo.getData('orirole');

			//alert("from="+orifromrole.name);
			//alert("to="+oritorole.name);

			var vect = new $jit.Complex(to.x - from.x, to.y - from.y);
			vect.$scale(dim / vect.norm());
			var posVect = vect;
			var intermediatePoint = new $jit.Complex(to.x - posVect.x, to.y - posVect.y);
			var normal = new $jit.Complex(-vect.y / 2, vect.x / 2);
			var endPoint = intermediatePoint.add(vect);
			var v1 = intermediatePoint.add(normal);
			var v2 = intermediatePoint.$add(normal.$scale(-1));

			if (adj.selected) {
				context.strokeStyle = '#FFFF40';
				context.lineWidth = 3;
			}
			//line
			context.beginPath();
			context.moveTo(from.x, from.y);
			context.lineTo(to.x, to.y);
			context.stroke();

			// Arrow head
			context.beginPath();
			context.moveTo(v1.x, v1.y);
			context.moveTo(v1.x, v1.y);
			context.lineTo(v2.x, v2.y);
			context.lineTo(endPoint.x, endPoint.y);
			context.closePath();
			context.fill();

			// Link Text
			var labeltext = adj.getData('label');
			context.font = "bold 12px Arial";
			context.textBaseline = 'top';

	  		var metrics = context.measureText(labeltext);
	  		var testWidth = metrics.width;

			// center label on line
			var posVectLabel = new $jit.Complex((to.x - from.x)/2, (to.y - from.y)/2);
			var intermediatePointLabel = new $jit.Complex(to.x - posVectLabel.x, to.y - posVectLabel.y);
			//var endPointLabel = intermediatePointLabel.add(vect);

			context.fillText(labeltext, (intermediatePointLabel.x-(testWidth/2)), intermediatePointLabel.y);
		},
		//optional
		'contains': function(adj, pos) {
			var posFrom = adj.nodeFrom.pos.getc(true);
			var posTo = adj.nodeTo.pos.getc(true);
			var epsilon = this.edge.epsilon;
            var min = Math.min,
                max = Math.max,
                minPosX = min(posFrom.x, posTo.x) - epsilon,
                maxPosX = max(posFrom.x, posTo.x) + epsilon,
                minPosY = min(posFrom.y, posTo.y) - epsilon,
                maxPosY = max(posFrom.y, posTo.y) + epsilon;

            if(pos.x >= minPosX && pos.x <= maxPosX
                && pos.y >= minPosY && pos.y <= maxPosY) {
                if(Math.abs(posTo.x - posFrom.x) <= epsilon) {
                    return true;
                }
                var dist = (posTo.y - posFrom.y) / (posTo.x - posFrom.x) * (pos.x - posFrom.x) + posFrom.y;
                return Math.abs(dist - pos.y) <= epsilon;
            }
            return false;
		}
	}
});

$jit.ForceDirected.Plot.NodeTypes.implement({
    'cohere': {
		'render': function(node, canvas){

			var context = canvas.getCtx()

			var width = node.getData('width');
			var height = node.getData('height');

			var finalpos = node.pos.getc(true);
			var pos = { x: finalpos.x - width / 2, y: finalpos.y - height / 2};

			/*
			context.fillStyle = node.color;
			context.strokeStyle = node.color;
			var rad = 10;
			var xx = finalpos.x - width / 2;
			var yy = finalpos.y - height / 2;
			context.beginPath();
			context.moveTo(xx+rad, yy);
			context.arcTo(xx+width, yy,    xx+width, yy+height, rad);
			context.arcTo(xx+width, yy+height, xx,    yy+height, rad);
			context.arcTo(xx,    yy+height, xx,    yy,    rad);
			context.arcTo(xx,    yy,    xx+width, yy,    rad);
			*/

			context['fill' + 'Rect'](finalpos.x - width / 2, finalpos.y - height / 2,
				width, height);


			if (typeof NODE_ARGS !== 'undefined' && node.id == NODE_ARGS['nodeid']) {
				context.strokeStyle = '#606060';
				context.lineWidth = 3;
				context['stroke' + 'Rect'](finalpos.x - width / 2, finalpos.y - height / 2,
					width, height);
			}

			if (node.selected) {
				context.strokeStyle = '#FFFF40';
				context.lineWidth = 3;
				context['stroke' + 'Rect'](finalpos.x - width / 2, finalpos.y - height / 2,
					width, height);
			}

			var orinode = node.getData('orinode');
			var orirole = node.getData('orirole');

			var roleimage = "";
			if (node.getData('icon')) {
				roleimage = node.getData('icon');
			} else {
				roleimage = URL_ROOT + orirole.image;
			}
			var roleicon = forcedirectedGraph.graph.getImage(roleimage);
			if (!roleicon) {
				roleicon = new Image();
		    	roleicon.src = roleimage;
				forcedirectedGraph.graph.addImage(roleicon);
		    }
			if (roleicon.complete) {
				context.drawImage(roleicon, pos.x+5, pos.y+5, 32, 32);
				var iconRect = new mapRectangle(pos.x+5, pos.y+5, 32, 32);
				node.setData('iconrec', iconRect);
			} else {
				roleicon.onload = function () {
					context.drawImage(roleicon, pos.x+5, pos.y+5, 32, 32);
					var iconRect = new mapRectangle(pos.x+5, pos.y+5, 32, 32);
					node.setData('iconrec', iconRect);
				};
			}

			var user = node.getData('oriuser');
			var userimage = '<?php echo $HUB_FLM->getImagePath($CFG->DEFAULT_USER_PHOTO); ?>';
			if (user.photo) {
				userimage = user.photo;
			}

			var usericon = forcedirectedGraph.graph.getImage(userimage);
			if (!usericon) {
				usericon = new Image();
				usericon.src = userimage;
				forcedirectedGraph.graph.addImage(usericon);
			}
			if (usericon.complete) {
				var imgheight = usericon.height;
				var imgwidth = usericon.width;
				if(imgheight > 40) {
					imgheight = 40;
					imgwidth = usericon.width * (40/usericon.height);
					context.drawImage(usericon, pos.x+(width-(5+imgwidth)), pos.y+5, imgwidth, imgheight);
					var userRect = new mapRectangle(pos.x+(width-(5+imgwidth)), pos.y+5, imgwidth, imgheight);
					node.setData('userrec', userRect);
				} else {
					context.drawImage(usericon, pos.x+(width-(5+imgwidth)), pos.y+5, imgwidth, imgheight);
					var userRect = new mapRectangle(pos.x+(width-(5+imgwidth)), pos.y+5, imgwidth, imgheight);
					node.setData('userrec', userRect);
				}
			} else {
				usericon.onload = function () {
					var imgheight = usericon.height;
					var imgwidth = usericon.width;
					if(imgheight > 40) {
						imgheight = 40;
						imgwidth = usericon.width * (40/usericon.height);
						context.drawImage(usericon, pos.x+(width-(5+imgwidth)), pos.y+5, imgwidth, imgheight);
						var userRect = new mapRectangle(pos.x+(width-(5+imgwidth)), pos.y+5, imgwidth, imgheight);
						node.setData('userrec', userRect);
					} else {
						context.drawImage(usericon, pos.x+(width-(5+imgwidth)), pos.y+5);
						var userRect = new mapRectangle(pos.x+(width-(5+imgwidth)), pos.y+5, imgwidth, imgheight);
						node.setData('userrec', userRect);
					}
				};
			}

			var labeltext = node.name;
			if (labeltext.length > 60) {
				labeltext = labeltext.substr(0,60)+"...";
			}

			context.fillStyle = context.strokeStyle = '#000000';
			context.font = "12px Arial";
			context.textBaseline = 'top';

			var maxWidth = 165;
			var lineHeight = 15;

			wrapText(context, labeltext, pos.x + 45, pos.y + 5, maxWidth, lineHeight, 10);
		},

		'contains': function(node, pos, width, height){

			var width = node.getData('width');
			var height = node.getData('height');

			var cpos = node.pos.getc(true);
			var npos = { x: cpos.x - width / 2, y: cpos.y - height / 2};
			var finalnpos = {x:npos.x+width/2, y:npos.y+height/2}

			return Math.abs(pos.x - finalnpos.x) <= width / 2
				&& Math.abs(pos.y - finalnpos.y) <= height / 2;
		}
	}
});

function createNewForceDirectedGraph(containername, rootNodeID) {

	var fd = new $jit.ForceDirected({
		//id of the visualization container
		injectInto: containername,

		Navigation: {
			enable: true,
			type: 'Native',

			//Enable panning events only if were dragging the empty
			//canvas (and not a node).
			panning: 'avoid nodes',
			zooming: 10 //zoom speed. higher is more sensible
		},

		// Change node and edge styles such as
		// color and width.
		// These properties are also set per node
		// with dollar prefixed data-properties in the
		// JSON structure.
		Node: {
			overridable: true,
			type: "cohere",
			height: 50,
			width: 250,
			nodetype: "",
			orinode: null,
			orirole: null,
			oriuser:null,
			icon: "",
			desc: "",
			connections:{},
		},

		Edge: {
		  	overridable: true,
		  	color: '#808080',
		  	lineWidth: 1.5,
		  	type: "labelarrow",
		  	label: "",
		},

		// Add node events
		Events: {
			enable: true,

			type: 'Native',
			//Change cursor style when hovering a node
			onMouseEnter: function() {
				fd.canvas.getElement().style.cursor = 'move';
			},
			onMouseLeave: function() {
				fd.canvas.getElement().style.cursor = '';
			},
			//Update node positions when dragged
			onDragMove: function(node, eventInfo, e) {
				var pos = eventInfo.getPos();
				node.pos.setc(pos.x, pos.y);
				fd.plot();
			},
			//Implement the same handler for touchscreens
			onTouchMove: function(node, eventInfo, e) {
				$jit.util.event.stop(e); //stop default touchmove event
				this.onDragMove(node, eventInfo, e);
			},

			onRightClick: function(node, eventInfo, e) {
				if (!node) return;
			},

			onClick: function(node, eventInfo, e) {
				if (!node) return;

				//if(node.nodeFrom){
				//   console.log("target is an edge");
				//} else {
				//     console.log("target is a node");
				//}

				if (node != false) {
					var isLink = node.nodeFrom ? true : false;
					if (!isLink) {
						var nodeid = node.id;
						var nodetype = node.getData('nodetype');
						if (nodetype == "Map") {
							var width = getWindowWidth()-50;
							var height = getWindowHeight()-50;
							loadDialog('map', URL_ROOT+"map.php?id="+nodeid, width,height);
						} else {
							var orinode = node.getData('orinode');
							var orirole = node.getData('orirole');
							var position = getPosition($(fd.config.injectInto+'-outer'));
							viewNodeDetailsDiv(nodeid, orirole.name, orinode, e, position.x+30, position.y+30);
						}
					}
				}
			}
		},

		//Number of iterations for the FD algorithm
		iterations: 100,

		//Edge length
		levelDistance: 280,

		//Add Tips
		Tips: {
			enable: true,
			type: 'Native',
			offsetX: 10,
  			offsetY: 10,
			onShow: function(tip, node) {
				var connections = node.getData('connections');
				var count = -1;
				if (connections) {
					count = connections.length;
				}
				if (count > -1) {
					tip.innerHTML = "<div class=\"tip-title\">" + node.name + "</div>"
					  + "<div class=\"tip-text\"><b>connections:</b> " + count; + "</div>";
				} else {
					tip.innerHTML = node.name;
				}
			}
		}
	});

	fd.graph = new $jit.Graph(fd.graphOptions, fd.config.Node, fd.config.Edge, fd.config.Label);

	var userimage = '<?php echo $HUB_FLM->getImagePath($CFG->DEFAULT_USER_PHOTO); ?>';
	usericon = new Image();
	usericon.src = userimage;
	fd.graph.addImage(usericon);

	if (rootNodeID != "") {
		fd.root = rootNodeID;
	}

	return fd;
}

/**
 * Add the given connection to the given graph
 */
function addConnectionToFDGraph(c, graph) {

	if (c && c.from && c.to) {

		var fN = c.from[0].cnode;
		var tN = c.to[0].cnode;

		var fnRole = c.fromrole[0].role;
		var fNNodeImage = "";
		if (fN.imagethumbnail != null && fN.imagethumbnail != "") {
			fNNodeImage = URL_ROOT + fN.imagethumbnail;
		} else if (fN.role[0].role.image != null && fN.role[0].role.image != "") {
			fNNodeImage = URL_ROOT + fN.role[0].role.image;
		}

		var tnRole = c.torole[0].role;
		var tNNodeImage = "";
		if (tN.imagethumbnail != null && tN.imagethumbnail != "") {
			tNNodeImage = URL_ROOT + tN.imagethumbnail;
		} else if (tN.role[0].role.image != null && tN.role[0].role.image != "") {
			tNNodeImage = URL_ROOT + tN.role[0].role.image;
		}
		var fromRole = fN.role[0].role.name;
		var toRole = tN.role[0].role.name;

		var fromDesc = "";
		if (fN.description) {
			fromDesc = fN.description;
		}
		var toDesc = "";
		if (tN.description) {
			toDesc = tN.description;
		}
		var fromName = fN.name;
		var toName = tN.name;

		// Get HEX for From Role
		var fromHEX = "";
		if (fromRole == 'Challenge') {
			fromHEX = challengebackpale;
		} else if (fromRole == 'Issue') {
			fromHEX = issuebackpale;
		} else if (fromRole == 'Solution') {
			fromHEX = solutionbackpale;
		} else if (fromRole == "Argument") {
			fromHEX = evidencebackpale;
		} else if (fromRole == "Pro") {
			fromHEX = probackpale;
		} else if (fromRole == "Con") {
			fromHEX = conbackpale;
		} else if (fromRole == "Idea") {
			fromHEX = plainbackpale;
		} else {
			fromHEX = plainbackpale;
		}

		// Get HEX for To Role
		var toHEX = "";
		if (toRole == 'Challenge') {
			toHEX = challengebackpale;
		} else if (toRole == 'Issue') {
			toHEX = issuebackpale;
		} else if (toRole == 'Solution') {
			toHEX = solutionbackpale;
		} else if (toRole == 'Argument') {
			toHEX = evidencebackpale;
		} else if (toRole == 'Pro') {
			toHEX = probackpale;
		} else if (toRole == 'Con') {
			toHEX = conbackpale;
		} else if (toRole == 'Idea') {
			toHEX = plainbackpale;
		} else {
			toHEX = plainbackpale;
		}

		fromRole = getNodeTitleAntecedence(fromRole, false);
		toRole = getNodeTitleAntecedence(toRole, false);

		//create from & to nodes

		var fromuser = null;
		if (fN.users[0].userid) {
			fromuser = fN.users[0];
		} else {
			fromuser = fN.users[0].user;
		}
		var touser = null;
		if (tN.users[0].userid) {
			touser = tN.users[0];
		} else {
			touser = tN.users[0].user;
		}

		var fromNode = null;
		if (!checkNodes[fN.nodeid]) {
			var connections = new Array();
			connections.push(c);

			fromNode = {
					"data": {
						"$color": fromHEX,
						"$nodetype": fromRole,
						"$orinode": fN,
						"$orirole": fnRole,
						"$oriuser": fromuser,
						"$icon": fNNodeImage,
						"$desc": fromDesc,
						"$connections":connections,
					},
					"id": fN.nodeid,
					"name": fromRole+": "+fromName,
			   };

			graph.addNode(fromNode);
			checkNodes[fN.nodeid] = fN.nodeid;
		} else {
			fromNode = graph.getNode(fN.nodeid);
			var connections = fromNode.getData('connections');
			connections.push(c);
			fromNode.setData('connections', connections);
		}

		var toNode = null;
		if (!checkNodes[tN.nodeid]) {

			var connections = new Array();
			connections.push(c);
			toNode = {
					"data": {
						"$color": toHEX,
						"$nodetype": toRole,
						"$orinode": tN,
						"$orirole": tnRole,
						"$oriuser": touser,
						"$icon": tNNodeImage,
						"$desc": toDesc,
						"$connections": connections,
					},
					"id": tN.nodeid,
					"name": toRole+": "+toName,
			 };

			graph.addNode(toNode);
			checkNodes[tN.nodeid] = tN.nodeid;
		} else {
			toNode = graph.getNode(tN.nodeid);
			var connections = toNode.getData('connections');
			connections.push(c);
			toNode.setData('connections', connections);
		}

		// add edge/conn
		var fromRoleName = fromRole;
		if (c.fromrole[0].role) {
			fromRoleName = c.fromrole[0].role.name;
		}

		var toRoleName = toRole;
		if (c.torole[0].role) {
			toRoleName = c.torole[0].role.name;
		}

		var linklabelname = "";
		if (c.linklabelname) {
			linklabelname = c.linklabelname;
		} else {
			linklabelname = c.linktype[0].linktype.label;
		}

		linklabelname = getLinkLabelName(fN.role[0].role.name, tN.role[0].role.name, linklabelname);

		var linkcolour = "#808080";
		if (linklabelname == "<?php echo $CFG->LINK_PRO_SOLUTION; ?>") {
			linkcolour = "#00BD53";
		} else if (linklabelname == "<?php echo $CFG->LINK_CON_SOLUTION; ?>") {
			linkcolour = "#C10031";
		}

		var data = {
			"$color": linkcolour,
			"$label": linklabelname,
			"$direction": [fN.nodeid,tN.nodeid],
		};

		graph.addAdjacence(fromNode, toNode, data);
	}
}

/**
 * Re-Compute positions incrementally and animate.
 */
function relayoutMap(graphview) {
	var width = $(graphview.config.injectInto+'-outer').offsetWidth;
	var height = $(graphview.config.injectInto+'-outer').offsetHeight;
	clipInitialCanvas(graphview, width, height);
	graphview.canvas.getPos(true);
}

/**
 * Compute positions incrementally and animate.
 */
function layoutAndAnimateFD(graphview, messagearea) {

	try {
		//graphview.computeIncremental({
		graphview.computePrefuse({
			iter:200,
			property: 'end',
			onComplete: function(){
				graphview.animate({
					modes: ['linear'],
					transition: $jit.Trans.Elastic.easeOut,
					duration: 500,
					onComplete: function() {
						var width = $(graphview.config.injectInto+'-outer').offsetWidth;
						var height = $(graphview.config.injectInto+'-outer').offsetHeight;
						clipInitialCanvas(graphview, width, height);

						var size = graphview.canvas.getSize();
						if (size.width > width || size.height > height) {
							zoomFDFit(graphview);
						} else {
							var rootNodeID = graphview.root;
							panToNodeFD(graphview, rootNodeID);
						}

						if (messagearea) {
							messagearea.innerHTML="";
							messagearea.style.display = "none";
						}

						graphview.canvas.getPos(true);
					}
				});
			}
		});
	} catch(e) {
		console.log(e);
	}
}

