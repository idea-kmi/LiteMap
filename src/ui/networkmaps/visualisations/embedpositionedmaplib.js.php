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


var nodeObj = null;

/** REQUIRES: graphlib.js.php **/

$jit.PositionedMapping.Plot.EdgeTypes.implement({

	'labelarrow': {
		'render': function(adj, canvas) {
			var orifrom = adj.nodeFrom.pos.getc(true);
			var orito = adj.nodeTo.pos.getc(true);

			var player = NODE_ARGS['mediaplayer'];
			if (player) {
				var fromoffset = parseFloat(adj.nodeFrom.getData('mediaindex'));
				var tooffset = parseFloat(adj.nodeTo.getData('mediaindex'));

				var currenttime = mediaPlayerCurrentIndex();
				if (positionedMap.mediaReplayMode) {
					if ((fromoffset >=0 && currenttime < fromoffset) || (tooffset >=0 && currenttime < tooffset)) {
						return;
					}
				}
			} else {
				if (positionedMap.mapReplayMode) {
					var fromIndex = parseInt(adj.nodeFrom.getData('index'));
					var toIndex = parseInt(adj.nodeTo.getData('index'));
					if ((fromIndex > positionedMap.mapReplayCurrentIndex) || (toIndex > positionedMap.mapReplayCurrentIndex)) {
						return;
					}
				}
			}

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

			var toEdge = computeSideOfRectangle(adj.nodeTo, orito, orifrom, to);
			var fromEdge = computeSideOfRectangle(adj.nodeFrom, orifrom, orito, from);

			var direction = adj.data.$direction;
			var swap = (direction && direction.length>1 && direction[0] != adj.nodeFrom.id);

			var context = canvas.getCtx();
			context.globalCompositeOperation='destination-over';

			// invert edge direction
			if (swap) {
				var tmp = from;
				var tmp2 = fromEdge;
				fromEdge = toEdge;
				from = to;
				to = tmp;
				toEdge = tmp2;
			}

			var currentFill = context.fillStyle;

			if (adj.getData('selected')) {
				context.strokeStyle = '#FFFF40';
				context.fillStyle = '#FFFF40';
				context.lineWidth = 3;
			}

			//draw line
			var isReallyNonLinear = false;
			if (positionedMap.linkCurveOn) {
				isReallyNonLinear = true;
			}

			var deltaX = to.x - from.x;
			var deltaY = to.y - from.y;
			if ((Math.abs(deltaX) < 20) || (Math.abs(deltaY) < 20)) {
				isReallyNonLinear = false; //under 10 pixels, ‘linear’ mode is always used
			}

			if (isReallyNonLinear) {

				// Middle point
				var middle = {"x":(from.x + to.x)/2, "y":(from.y + to.y)/2};
				var arrowOrientation = "";

				var x1 = 0, y1 = 0, x2 = 0, y2 = 0, x3 = 0, y3 = 0, x4 = 0, y4 = 0;

				if (toEdge == "bottom" || toEdge == "top") {
					arrowOrientation = "VERTICAL";
					x1 = from.x; y1 = from.y;
					x2 = from.x; y2 = middle.y;
					x3 = to.x; 	y3 = middle.y;
					x4 = to.x;
					x5 = to.x;
					y5 = to.y;
					// Adjust for arrow
					if (toEdge == "bottom") {
						y4 = to.y+15;
					} else {
						y4 = to.y-15;
					}
				} else { //if (toEdge == "left" || toEdge == "right") { // edge does not come back empty anymore
					arrowOrientation = "HORIZONTAL";
					x1 = from.x; y1 = from.y;
					x2 = middle.x; y2 = from.y;
					x3 = middle.x; 	y3 = to.y;
					x5 = to.x;
					y5 = to.y
					//adjust for arrow
					if (toEdge == "left") {
						x4 = to.x-15;
					} else if (toEdge == "right") {
						x4 = to.x+15;
					} else {
						x4 = to.x;
					}
					y4 = to.y;
				}

				//console.log("to edge:"+toEdge+" toNode="+adj.nodeTo.name+" y="+y4);
				//console.log("from edge:"+fromEdge+" fromNode="+adj.nodeFrom.name+" y="+y1);

				var newTo = {"x":x4, "y":y4};
				var newToArrow = {"x":x5, "y":y5};
				var newFrom = {"x":x1,"y":y1};

				context.beginPath();
				context.moveTo(x1, y1);
				context.bezierCurveTo(x2, y2, x3, y3, x4, y4);
				context.stroke();

				// Arrow head
				drawArrow(context, newFrom, newToArrow, 15, arrowOrientation);

			} else {
				context.beginPath();
				context.moveTo(from.x, from.y);
				context.lineTo(to.x, to.y);
				context.stroke();

				// Arrow head
				drawArrow(context, from, to, 15, "FREE");
			}

			// Link Text
			if (positionedMap.linkLabelTextOn) {
				context.fillStyle = currentFill;

				var labeltext = adj.getData('label');
				context.font = "bold 12px Arial";
				context.textBaseline = 'top';

				var metrics = context.measureText(labeltext);
				var testWidth = metrics.width;

				// center label on line
				var posVectLabel = new $jit.Complex((to.x - from.x)/2, (to.y - from.y)/2);
				var intermediatePointLabel = new $jit.Complex(to.x - posVectLabel.x, to.y - posVectLabel.y);
				context.fillText(labeltext, (intermediatePointLabel.x-(testWidth/2)), intermediatePointLabel.y);
			}
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

$jit.PositionedMapping.Plot.NodeTypes.implement({
    'cohere': {
		'render': function(node, canvas){

			var player = NODE_ARGS['mediaplayer'];
			var offset = parseFloat(node.getData('mediaindex'));
			var currenttime = mediaPlayerCurrentIndex();
			if (player) {
				if (positionedMap.mediaReplayMode) {
					if (offset >= 0 && currenttime < offset ) {
						return;
					}
				}
			} else {
				if (positionedMap.mapReplayMode) {
					var index = parseInt(node.getData('index'));
					if (index > positionedMap.mapReplayCurrentIndex) {
						return;
					}
				}
			}

			var context = canvas.getCtx();
			context.globalCompositeOperation='source-over';

			var width = node.getData('width');
			var height = node.getData('height')+10;
			var finalpos = node.pos.getc(true);
			var pos = { x: finalpos.x - width / 2, y: finalpos.y - height / 2};

			var nodeFillStyle = context.fillStyle;

			context.fillStyle = '#ffffff';
			var nodeboxX = (finalpos.x - width / 2);
			var nodeboxY = (finalpos.y - height / 2);

			var nodeboxWidth = width;
			var nodeboxHeight = height;

			context['fill' + 'Rect'](nodeboxX, nodeboxY, nodeboxWidth, nodeboxHeight);
			var mainRect = new mapRectangle(nodeboxX, nodeboxY, nodeboxWidth, nodeboxHeight);
			node.setData('mainrec', mainRect);

			var orinode = node.getData('orinode');

			// clear rectangles that might change
			node.setData('rolechangerec', null);
			node.setData('voteforrec', null);
			node.setData('voteagainstrec', null);
			node.setData('viewrec', null);
			node.setData('editrec', null);
			node.setData('deleterec', null);
			node.setData('linkrec', null);
			node.setData('urlrec', null);
			node.setData('rolechangerec', null);
			//leftrec:null,
			//rightrec:null,
			//uprec:null,
			//downrec:null,
			//mainrec:null,
			//userrec:null,
			//iconrec:null,
			//textrec:null,
			//descrec:null,

			var orirole = node.getData('orirole');
			var user = node.getData('oriuser');

			// ROLE ICON

			// Does the node have its own image?
			/*
			if (orinode.image && orirole.name == 'Map') {
				var roleicon = positionedMap.graph.getImage(orinode.image);
				if (roleicon.complete) {
					var imgheight = roleicon.height;
					var imgwidth = roleicon.width;
					var imgwid = <?php echo $CFG->IMAGE_THUMB_WIDTH; ?>;
					var imghid = imgheight * (imgwid/imgwidth);
					context.drawImage(roleicon, nodeboxX+5, nodeboxY+5, imgwid, imghid);
					var iconRect = new mapRectangle(nodeboxX+5, nodeboxY+5, imgwid, imghid);
					node.setData('iconrec', iconRect);
				} else {
					var roleimage = orinode.image;
					var	roleicon = new Image();
					roleicon.src = roleimage;
					positionedMap.graph.addImage(roleicon);
					roleicon.onload = function () {
						var imgheight = roleicon.height;
						var imgwidth = roleicon.width;
						var imgwid = <?php echo $CFG->IMAGE_THUMB_WIDTH; ?>;
						var imghid = imgheight * (imgwid/imgwidth);
						context.drawImage(roleicon, nodeboxX+5, nodeboxY+5, imgwid, imghid);
						var iconRect = new mapRectangle(nodeboxX+5, nodeboxY+5, imgwid, imghid);
						node.setData('iconrec', iconRect);
					};
				}
			} else {*/
				var roleicon = "";
				if (orirole.name == 'Issue' ) {
					roleicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue64px.png'); ?>');
				} else if (orirole.name == 'Solution') {
					roleicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution64px.png'); ?>');
				} else if (orirole.name == 'Map') {
					roleicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('nodetypes/Default/map-64.png'); ?>');
				} else if (orirole.name == 'Pro') {
					roleicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-64.png'); ?>');
				} else if (orirole.name == 'Con') {
					roleicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-64.png'); ?>');
				} else {
					var roleimage = URL_ROOT + orirole.image;
					var	roleicon = new Image();
					roleicon.src = roleimage;
					//positionedMap.graph.addImage(roleicon);
				}
				if (roleicon.complete) {
					context.drawImage(roleicon, nodeboxX+5, nodeboxY+5, 32, 32);
					var iconRect = new mapRectangle(nodeboxX+5, nodeboxY+5, 32, 32);
					node.setData('iconrec', iconRect);
				} else {
					roleicon.onload = function () {
						context.drawImage(roleicon, nodeboxX+5, nodeboxY+5, 32, 32);
						var iconRect = new mapRectangle(nodeboxX+5, nodeboxY+5, 32, 32);
						node.setData('iconrec', iconRect);
					};
				}
			//}

			// Challenge node network graph view
			if (orirole.name == 'Challenge') {
				var	networkicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('network-graph.png'); ?>');
				context.drawImage(networkicon, nodeboxX+12, nodeboxY+40,20,20);
				var networkRect = new mapRectangle(nodeboxX+12, nodeboxY+40, 20, 20);
				node.setData('networkrec', networkRect);
			}

			// PRIVATE PADLOCK - uneditable embedded map won't draw private nodes?
			//var private = orinode.private;
			//if (private == "Y") {
			//	var	padlockicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>");
			//	context.drawImage(padlockicon, nodeboxX+22, pos.y+42,18,18);
			//}

			// TOOLBAR

			var oldfill = context.fillStyle;
			context.fillStyle = nodeFillStyle; //'#E8E8E8';
			context['fill' + 'Rect'](nodeboxX, pos.y+height-20, nodeboxWidth, 20);
			context.fillStyle = oldfill;

			var currentX = nodeboxX+3;

			// TRANSCLUSION NUMBER
			var mapcount = orinode.mapcount;
			if (mapcount > 1) {
				var currentFont = context.font;
				context.font = "bold 10pt Arial";
				if(navigator.userAgent.indexOf("Firefox") != -1 ) {
					context.fillText(mapcount, currentX, pos.y+height-15);
					var viewRect = new mapRectangle(currentX, pos.y+height-15, 10, 12);
				} else {
					context.fillText(mapcount, currentX, pos.y+height-17);
					var viewRect = new mapRectangle(currentX, pos.y+height-17, 10, 12);
				}
				node.setData('viewrec', viewRect);
				currentX = currentX+16;
				context.font = currentFont;
			}

			// EXPLORE.
			var descicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('desc-gray.png'); ?>");
			context.drawImage(descicon, currentX, pos.y+height-18, 15, 15);
			var descRect = new mapRectangle(currentX, pos.y+height-18, 16, 16);
			node.setData('descrec', descRect);
			currentX = currentX+20;

			// LINKS
			if (orinode.urls && orinode.urls.length > 0) {
				var	linkicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('link.png'); ?>');
				context.drawImage(linkicon, currentX, pos.y+height-18,16,16);
				var linkRect = new mapRectangle(currentX, pos.y+height-18, 16, 16);
				node.setData('linkrec', linkRect);
				currentX = currentX+20;
			}

			// NODE IN MAP URL
			var	urlicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('link2.png'); ?>");
			context.drawImage(urlicon, currentX, pos.y+height-19,16,16);
			var urlRect = new mapRectangle(currentX, pos.y+height-19, 16, 16);
			node.setData('urlrec', urlRect);
			currentX = currentX+22;

			// MENU ARROW
			var player = NODE_ARGS['mediaplayer'];
			if (player && offset != -1) {
				var downarrowRect = new mapRectangle(nodeboxX+nodeboxWidth-20, pos.y+height-18, 20, 18);
				node.setData('downrec', downarrowRect);
				var downarrow = '<?php echo $HUB_FLM->getImagePath('rightarrowlarge.gif'); ?>';
				var downarrowicon = positionedMap.graph.getImage(downarrow);
				if (downarrowicon.complete) {
					context.drawImage(downarrowicon, nodeboxX+nodeboxWidth-17, pos.y+height-19, 16, 17);
				} else {
					downarrowicon.onload = function () {
						context.drawImage(downarrowicon, nodeboxX+nodeboxWidth-17, pos.y+height-19, 16, 17);
					};
				}
			}

			// End menu bar

			// Draw Borders when required
			if (node.id == NODE_ARGS['nodeid']) {
				context.strokeStyle = '#606060';
				context.lineWidth = 3;
				context['stroke' + 'Rect']( (finalpos.x - width /  2), (finalpos.y - height / 2),
					width2, height);
			} else {
				context.lineWidth="1";
				context.strokeStyle='#E8E8E8'//nodeFillStyle;
				context.fillStyle = '#E8E8E8'//nodeFillStyle;
				context['stroke' + 'Rect']( (finalpos.x - width / 2), (finalpos.y - height / 2),
					width, height);
			}

			if (node.selected) {
				context.strokeStyle = '#FFFF40';
				context.lineWidth = 3;
				context['stroke' + 'Rect']( (finalpos.x - width / 2), (finalpos.y - height / 2),
					width, height);
			}

			if ( (player && offset >=0 && currenttime >= offset && currenttime < (offset + 3.0))
					|| (positionedMap.mapReplayMode && parseInt(node.getData('index')) == positionedMap.mapReplayCurrentIndex) ) {
				context.strokeStyle = '#8080FF';
				context.lineWidth = 3;
				context['stroke' + 'Rect']( (finalpos.x - width / 2), (finalpos.y - height / 2),
					width, height);
			}

			context.fillStyle = context.strokeStyle = '#000000';
			context.font = "12px Arial";
			context.textBaseline = 'top';

			// add user image using nodebox position/size
			/*var user = node.getData('oriuser');
			var userimage = '<?php echo $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_USER_PHOTO); ?>';
			if (user.thumb) {
				userimage = user.thumb;
			}
			var usericon = positionedMap.graph.getImage(userimage);
			if (!usericon) {
				var usericon = new Image();
				usericon.src = userimage;
				positionedMap.graph.addImage(usericon);
			}
			var userRect = new mapRectangle(nodeboxX+(nodeboxWidth-(5+imgwidth)), nodeboxY+5, imgwidth, imgheight);
			if (usericon.complete) {
				var imgheight = usericon.height;
				var imgwidth = usericon.width;
				if(imgheight > 40) {
					imgheight = 40;
					imgwidth = usericon.width * (40/usericon.height);
					context.drawImage(usericon, nodeboxX+(nodeboxWidth-(5+imgwidth)), nodeboxY+5, imgwidth, imgheight);
				} else {
					context.drawImage(usericon, nodeboxX+(nodeboxWidth-(5+imgwidth)), nodeboxY+5);
					userRect = new mapRectangle(nodeboxX+(nodeboxWidth-(5+imgwidth)), nodeboxY+5, usericon.width, usericon.height);
				}
			} else {
				usericon.onload = function () {
					var imgheight = usericon.height;
					var imgwidth = usericon.width;
					if(imgheight > 40) {
						imgheight = 40;
						imgwidth = usericon.width * (40/usericon.height);
						context.drawImage(usericon, nodeboxX+(nodeboxWidth-(5+imgwidth)), nodeboxY+5, imgwidth, imgheight);
					} else {
						context.drawImage(usericon, nodeboxX+(nodeboxWidth-(5+imgwidth)), nodeboxY+5);
						userRect = new mapRectangle(nodeboxX+(nodeboxWidth-(5+imgwidth)), nodeboxY+5, usericon.width, usericon.height);
					}
				};
			}

			node.setData('userrec', userRect);
			*/

			var maxWidth = 155;

			// Does the node have its own image?
			if (orinode.image) {
				var roleicon = positionedMap.graph.getImage(orinode.image);
				if (roleicon.complete) {
					var imgheight = roleicon.height;
					var imgwidth = roleicon.width;
					var imghid = nodeboxHeight-30;
					var imgwid = maxWidth;
					var size = calculateAspectRatioFit(imgwidth,imgheight, imgwid, imghid);
					context.drawImage(roleicon, nodeboxX+45, nodeboxY+5, size.width, size.height);
				} else {
					var roleimage = orinode.image;
					var	roleicon = new Image();
					roleicon.src = roleimage;
					positionedMap.graph.addImage(roleicon);
					roleicon.onload = function () {
						var imgheight = roleicon.height;
						var imgwidth = roleicon.width;
						var imghid = nodeboxHeight-30;
						var imgwid = maxWidth;
						var size = calculateAspectRatioFit(imgwidth,imgheight, imgwid, imghid);
						context.drawImage(roleicon, nodeboxX+45, nodeboxY+5, size.width, size.height);
					};
				}
			} else {
				var labeltext = node.name;
				if (labeltext.length > 80) {
					labeltext = labeltext.substr(0,80)+"...";
				}
				var lineHeight = 15;
				wrapText(context, labeltext, nodeboxX + 45, nodeboxY + 5, maxWidth, lineHeight, 10);
			}

			var textRect = new mapRectangle(nodeboxX + 45, nodeboxY + 5, maxWidth, nodeboxHeight-18);
			node.setData('textrec', textRect);
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

function createNewEmbedMap(containername, rootNodeID, backgroundImagePath) {

	var backgroundObject = false;

	if (backgroundImagePath != "") {
		var backgroundimageObj = new Image();
		backgroundimageObj.src = backgroundImagePath;
		backgroundObject = {
			type: 'Image',
			src: backgroundImagePath,
			backgroundimage: backgroundimageObj
		};
	}

	var fd = new $jit.PositionedMapping({
		//id of the visualization container
		injectInto: containername,

		background: backgroundObject,

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
			height: 86,
			width: 216,
			nodetype: "",
			orinode: null,
			orirole: null,
			oriuser:null,
			userid:null,
			icon: "",
			desc: "",
			connections:{},
			xpos: 0,
			ypos: 0,
			mediaindex:-1,
			index: -1,
			leftrec:null,
			rightrec:null,
			uprec:null,
			downrec:null,
			mainrec:null,
			userrec:null,
			iconrec:null,
			textrec:null,
			descrec:null,
			viewrec:null,
			linkrec:null,
			urlrec:null,
			networkrec:null,
			viewlist:"",
		},

		Edge: {
		  	overridable: true,
		  	color: '#808080',
		  	lineWidth: 1.5,
		  	type: "labelarrow",
		  	label: "",
		  	connid: "",
			oriconn: null,
		  	oriuser:null,
		},

		// Add events
		Events: {
			enable: true,
		  	enableForEdges: true,

			type: 'Native',

		  	onMouseUp: function(node, eventInfo, e) {
		  		return;
		  	},
		  	onMouseDown: function(node, eventInfo, e) {
		  		return;
		  	},

			//Change cursor style when hovering a node
			onMouseEnter: function(node, eventInfo, e) {
		  		return;
			},
			onMouseMove: function(node, eventInfo, e) {
				if (!node || fd.mapReplayMode) {
					return;
				}

				var isLink = node.nodeFrom ? true : false;
				if (!isLink) {
					var pos = eventInfo.getPos();

					var mainRec = node.getData('mainrec');
					var userRec = node.getData('userrec');
					var iconRec = node.getData('iconrec');
					var textRec = node.getData('textrec');
					var descRec = node.getData('descrec');
					var viewRec = node.getData('viewrec');
					var linkRec = node.getData('linkrec');
					var urlRec = node.getData('urlrec');

					var player = NODE_ARGS['mediaplayer'];
					var mediaindex = node.getData('mediaindex');

					if (player && mediaindex != -1) {
						var downarrowRec = node.getData('downrec');
						if (downarrowRec && downarrowRec.contains(pos.x, pos.y)) {
							fd.canvas.getElement().style.cursor = 'pointer';
							showMapMenu("down", node, e);
							return;
						}
					}

					if (iconRec.contains(pos.x, pos.y)) {
						var text = node.getData('nodetype');
						showMapHint('maphintdiv', node, text, e);
					} else if (urlRec && urlRec.contains(pos.x, pos.y)) {
						var text = '<?php echo $LNG->GRAPH_LINK_HINT; ?>';
						showMapHint('maphintdiv', node, text, e);
					} else if (descRec && descRec.contains(pos.x, pos.y)) {
						var orirole = node.getData('orirole');
						if (orirole.name == "Map") {
							var text = '<?php echo $LNG->MAP_VIEW; ?>';
							showMapHint('mapdescdiv', node, text, e);
						} else {
							var desc = node.getData('desc');
							var text = '<?php echo $LNG->MAP_NODE_DETAILS_HINT; ?>';
							if (desc != "") {
								text = desc+"<br><br>"+'<?php echo $LNG->MAP_NODE_DETAILS_HINT; ?>';
							}
							showMapHint('mapdescdiv', node, text, e);
						}
 					} else if (viewRec && viewRec.contains(pos.x, pos.y)) {
						var desc = node.getData('desc');
						showViewMenu(node, e, fd);
 					} else if (linkRec && linkRec.contains(pos.x, pos.y)) {
						showURLMenu(node, e);
					} else if (textRec && textRec.contains(pos.x, pos.y)) {
						if (fd.rolloverTitles) {
							var title = node.name;
							var orinode = node.getData('orinode');
							var orirole = node.getData('orirole');
							if (orinode.image) {
								title += ' - (<?php echo $LNG->COMMENT_IMAGE_HINT;?>)';
							}
							showMapHint('mapdescdiv', node, title, e);
						}
					} else if (mainRec.contains(pos.x, pos.y)) {
						hideBox('maphintdiv');
						hideBox('mapdescdiv');
					}
				}
			},

			onMouseLeave: function(node, eventInfo, e) {
				fd.canvas.getElement().style.cursor = '';
				if (!node || fd.mapReplayMode) return;

				hideBox('maparrowdiv');
				hideBox('maphintdiv');
				hideBox('mapdescdiv');
			},

			//Update node positions when dragged
			onDragMove: function(node, eventInfo, e) {
				if (!node || fd.mapReplayMode) {
					return;
				}
			},

			onDragEnd: function(node, eventInfo, e) {
				if (!node || fd.mapReplayMode) {
					return;
				}
		  	},

			//Implement the same handler for touchscreens
			onTouchMove: function(node, eventInfo, e) {
				$jit.util.event.stop(e); //stop default touchmove event
				this.onDragMove(node, eventInfo, e);
			},
			onTouchEnd: function(node, eventInfo, e) {
				$jit.util.event.stop(e); //stop default touchend event
				this.onDragEnd(node, eventInfo, e);
		  	},

			onRightClick: function(node, eventInfo, e) {
				if (!node || fd.mapReplayMode) return;

				var isLink = node.nodeFrom ? true : false;
				if (!isLink) {
					var pos = eventInfo.getPos();
					var textrect = node.getData('textrec');
					if (textrect && textrect.contains(pos.x, pos.y)) {
						var orinode = node.getData('orinode');
						if (orinode.image) {
							loadDialog('bigimage',orinode.image, 800,600);
						}
					}
				}
			},

			onClick: function(node, eventInfo, e) {
				if (!node || fd.mapReplayMode) {
					return;
				}
				var isLink = node.nodeFrom ? true : false;
				if (!isLink) {
					var pos = eventInfo.getPos();
					var networkRec = node.getData('networkrec');
					var descRec = node.getData('descrec');
					var urlRec = node.getData('urlrec');
					if (descRec && descRec.contains(pos.x, pos.y)) {
						hideBox('maparrowdiv');
						var nodeid = node.id;
						var orirole = node.getData('orirole');
						if (orirole.name == "Map") {
							var width = getWindowWidth()-50;
							var height = getWindowHeight()-50;
							loadDialog('map', URL_ROOT+"map.php?id="+nodeid, width,height);
						} else {
							var orinode = node.getData('orinode');
							var position = getPosition($(fd.config.injectInto+'-outer'));
							viewNodeDetailsDiv(nodeid, orirole.name, orinode, e, position.x+30, position.y+30);
						}
					} else if (networkRec && networkRec.contains(pos.x, pos.y)) {
						var width = getWindowWidth();
						var height = getWindowHeight()-40;
						loadDialog('network',URL_ROOT+"networkgraph.php?id="+node.id, width,height);
					} else if (urlRec && urlRec.contains(pos.x, pos.y)) {
						var code = URL_ROOT+'map.php?id='+NODE_ARGS['nodeid']+'&focusid='+node.id;
						textAreaPrompt('<?php echo $LNG->GRAPH_LINK_MESSAGE; ?>', code, "", "", "");
					} else if (e.shiftKey) {
						if (toggleMediaBar) {
							toggleMediaBar(true);
						}
						var mediaindex = node.getData('mediaindex');
						if (mediaindex > -1) {
							mediaPlayerSeek(mediaindex);
						}
					} else {
						hideBox('maparrowdiv');
						var nodeid = node.id;
						var orirole = node.getData('orirole');
						if (orirole.name == "Map") {
							var width = getWindowWidth()-40;
							var height = getWindowHeight()-40;
							loadDialog('map', URL_ROOT+"map.php?id="+nodeid, width,height);
						} else {
							var orinode = node.getData('orinode');
							var orirole = node.getData('orirole');
							var position = getPosition($(fd.config.injectInto+'-outer'));
							viewNodeDetailsDiv(nodeid, orirole.name, orinode, e, position.x+30, position.y+30);
						}
						fd.refresh();
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
			enable: false,
			type: 'Native',
			offsetX: 10,
  			offsetY: 10,
			onShow: function(tip, node) {}
		}
	});

	fd.rolloverTitles = true;
	fd.linkLabelTextOn = true;
	fd.linkCurveOn = false;

	fd.mediaReplayMode = false;

	fd.mapReplayMode = false;
	fd.mapReplayCurrentIndex = -1;
	fd.mapReplayInterval = getReplaySpeed(); // milliseconds;
	fd.mapReplayMaxIndex = 0;

	fd.graph = new $jit.Graph(fd.graphOptions, fd.config.Node, fd.config.Edge, fd.config.Label);

	// PRELOAD TOOLBAR ICONS
	var rightarrow = '<?php echo $HUB_FLM->getImagePath('rightarrowlarge.gif'); ?>';
	var rightarrowicon = new Image();
	rightarrowicon.src = rightarrow;
	fd.graph.addImage(rightarrowicon);

	var descicon = '<?php echo $HUB_FLM->getImagePath('desc-gray.png'); ?>';
	var descimage = new Image();
	descimage.src = descicon;
	fd.graph.addImage(descimage);

	var	globeicon = new Image();
	globeicon.src = '<?php echo $HUB_FLM->getImagePath('link.png'); ?>';
	fd.graph.addImage(globeicon);

	var	linkicon = new Image();
	linkicon.src = '<?php echo $HUB_FLM->getImagePath('link2.png'); ?>';
	fd.graph.addImage(linkicon);

	var	networkicon = new Image();
	networkicon.src = '<?php echo $HUB_FLM->getImagePath('network-graph.png'); ?>';
	fd.graph.addImage(networkicon);

	// PRELOAD NODE TYPES
	var	issueicon = new Image();
	issueicon.src = '<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue64px.png'); ?>';
	fd.graph.addImage(issueicon);

	var	solutionicon = new Image();
	solutionicon.src = '<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution64px.png'); ?>';
	fd.graph.addImage(solutionicon);

	var	mapicon = new Image();
	mapicon.src = '<?php echo $HUB_FLM->getImagePath('nodetypes/Default/map-64.png'); ?>';
	fd.graph.addImage(mapicon);

	var	plusicon = new Image();
	plusicon.src = '<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-64.png'); ?>';
	fd.graph.addImage(plusicon);

	var	minusicon = new Image();
	minusicon.src = '<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-64.png'); ?>';
	fd.graph.addImage(minusicon);

	if (rootNodeID != "") {
		fd.root = rootNodeID;
	} else {
		fd.root = "";
	}

	return fd;
}

function showMapHint(panelname, node, text, evt) {
	var panel = $(panelname);
	panel.innerHTML = "";
	panel.insert(text);

	var extraX = 5;
	var extraY = 5;
 	var event = evt || window.event;
	var thing = event.target || event.srcElement;
	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	if (GECKO) {
		//adjust for it going off the screen right or bottom.
		var x = event.clientX;
		var y = event.clientY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+extraX;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}

		if (panel) {
			panel.style.left = x+extraX+window.pageXOffset+"px";
			panel.style.top = y+extraY+window.pageYOffset+"px";
		}
	}
	else if (NS) {
		//adjust for it going off the screen right or bottom.
		var x = event.pageX;
		var y = event.pageY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+extraX;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}
		panel.moveTo(x+extraX+window.pageXOffset+"px", y+extraY+window.pageYOffset+"px");
	}
	else if (IE || IE5) {
		//adjust for it going off the screen right or bottom.
		var x = event.x;
		var y = event.clientY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+extraX;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}

		window.event.cancelBubble = true;
		panel.style.left = x+extraX+ document.documentElement.scrollLeft+"px";
		panel.style.top = y+extraY+ document.documentElement.scrollTop+"px";
	}

	showBox(panelname);
}

function showViewMenu(node, evt, graphview) {
	var panel = $('maparrowdiv');
	panel.innerHTML = "";
	var fromnodeid = node.id;

	var innerpanel = new Element("div", {'style':'float:left;width:100%;height:100%;'} );
	innerpanel.insert("loading...");

	if (node.getData('viewlist') != "") {
		innerpanel = node.getData('viewlist');
	} else {
		// get maps for node
		var reqUrl = SERVICE_ROOT + "&method=getmapsfornode&style=long";
		reqUrl += "&orderby=name&sort=ASC&start=0&max=-1&nodeid="+node.id;

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				innerpanel.update("");

				var nodes = json.nodeset[0].nodes;
				//alert(nodes.length);
				if (nodes.length > 0) {
					for(var i=0; i< nodes.length; i++){
						var nextnode = nodes[i];

						if (nextnode.cnode.nodeid == NODE_ARGS['nodeid']) {
							var next = new Element("span", {'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
							next.insert(nextnode.cnode.name);
							innerpanel.insert(next);
						} else {
							var next = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
							next.insert(nextnode.cnode.name);
							Event.observe(next,'click',function (){
								hideBox('maparrowdiv');
								// link to map
								viewMapDetailsAndSelect(this.nodeid, fromnodeid);
							});
							innerpanel.insert(next);
						}
					}
				} else {
					return;
				}
				node.setData('viewlist', innerpanel);
			}
		});
	}

	panel.update(innerpanel);
	adjustMenuPosition(panel, evt);
	showBox('maparrowdiv');
}

function showMapMenu(type, node, evt) {

	var orinode = node.getData('orinode');
	var orirole = node.getData('orirole');
	var user = node.getData('oriuser');
	var rolename = orirole.name;
	var userid = node.getData('userid');

	var panel = $('maparrowdiv');

	panel.innerHTML = "";

	var mediaindex = node.getData('mediaindex');

	var player = NODE_ARGS['mediaplayer'];
	var currentindex = -1;
	if (player) {
		mediaPlayerPause()
		currentindex = mediaPlayerCurrentIndex();
	}

	if (mediaindex >-1 && player && currentindex != mediaindex) {
		var newnode = new Element("span", {'style':'cursor: pointer; margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->MAP_MEDIA_NODE_JUMP_HINT; ?>'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('mediaicon.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->MAP_MEDIA_NODE_MEDIAINDEX; ?>"+formatMovieTime(mediaindex));
		newnode.insert('<span class="active" style="padding-left:5px;"><?php echo $LNG->MAP_MEDIA_NODE_JUMP; ?></span>');
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			if (toggleMediaBar) {
				toggleMediaBar(true);
			}
			mediaPlayerSeek(mediaindex);
		});

		panel.insert(newnode);
	} else if (mediaindex > -1 && player) {
		var newnode = new Element("span", {'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('mediaicon.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->MAP_MEDIA_NODE_MEDIAINDEX; ?>"+formatMovieTime(mediaindex));
		panel.insert(newnode);
	}

	/*
	var viewdetails = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NETWORKMAPS_EXPLORE_ITEM_HINT; ?>'} );
	viewdetails.insert("<?php echo $LNG->NETWORKMAPS_EXPLORE_ITEM_LINK; ?>");
	Event.observe(viewdetails,'click',function (evt){
		hideBox('maparrowdiv');
		var nodeid = node.id;
		viewNodeDetailsDiv(nodeid, rolename, orinode, evt);
	});
	panel.insert(viewdetails);

	var viewuser = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NETWORKMAPS_EXPLORE_AUTHOR_HINT; ?>'} );
	viewuser.insert("<?php echo $LNG->NETWORKMAPS_EXPLORE_AUTHOR_LINK; ?>");
	Event.observe(viewuser,'click',function (){
		hideBox('maparrowdiv');
		var userid = node.getData('oriuser').userid;
		viewUserHome(userid);
	});
	panel.insert(viewuser);
	*/

	/*var orinode = node.getData('orinode');
	if (orinode.urls && orinode.urls.length > 0) {
		panel.insert(createMenuSpacerSoft());
		var count = orinode.urls.length;

		panel.insert('<span style="clear:both;float:left;font-size:10pt;font-weight:bold"><?php echo $LNG->MAP_LINKS_TITLE; ?></span>');

		for (var i=0; i<count; i++) {
			var urlobj = orinode.urls[i].url;
			var url = urlobj.url;
			var urltitle = urlobj.title;
			var urlnode = new Element("a", {
				'class':'active',
				'target':'_blank',
				'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt',
				'title':'<?php echo $LNG->NODE_URL_LINK_TEXT; ?>: '+urltitle,
			});
			if (urltitle && urltitle.length > 20) {
				urltitle = urltitle.substr(0,20)+"...";
			}
			urlnode.insert(urltitle);
			urlnode.href = url;
			panel.insert(urlnode);

		}
	}*/

	adjustMenuPosition(panel, evt);
	showBox('maparrowdiv');
}

function showURLMenu(node, evt) {
	var panel = $('weblinkdiv');
	panel.innerHTML = "";

	var innerpanel = new Element("div", {'style':'float:left;width:100%;height:100%;'} );

	var orinode = node.getData('orinode');
	if (orinode.urls && orinode.urls.length > 0) {
		var count = orinode.urls.length;

		innerpanel.insert('<span style="clear:both;float:left;font-size:10pt;font-weight:bold"><?php echo $LNG->MAP_LINKS_TITLE; ?></span>');

		for (var i=0; i<count; i++) {
			var urlobj = orinode.urls[i].url;
			var url = urlobj.url;
			var urltitle = urlobj.title;
			var urlnode = new Element("a", {
				'class':'active',
				'target':'_blank',
				'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt',
				'title':'<?php echo $LNG->NODE_URL_LINK_TEXT; ?>: '+urltitle,
			});
			if (urltitle && urltitle.length > 40) {
				urltitle = urltitle.substr(0,40)+"...";
			}
			urlnode.insert(urltitle);
			urlnode.href = url;
			innerpanel.insert(urlnode);

		}
	}

	panel.update(innerpanel);
	adjustMenuPosition(panel, evt);
	showBox('weblinkdiv');
}

function adjustMenuPosition(panel, event) {
	var page = $jit.util.event.getPos(event, window);
	panel.style.left = page.x+"px";
	panel.style.top = page.y+"px";
}

/**
 * Add the given connection to the given graph
 */
function addConnectionToMap(viewconnection, positionedMap) {

	var graph = positionedMap.graph;

	var c = viewconnection.connection[0].connection;
	if (c) {
		var fN = c.from[0].cnode;
		var tN = c.to[0].cnode;

		if (graph.hasNode(fN.nodeid) && graph.hasNode(tN.nodeid)) {

			var fromNode = graph.getNode(fN.nodeid);
			var toNode = graph.getNode(tN.nodeid);

			var linklabelname = c.linktype[0].linktype.label;
			linklabelname = getLinkLabelName(fN.role[0].role.name, tN.role[0].role.name, linklabelname);

			var linkcolour = "#808080";
			if (linklabelname == "<?php echo $CFG->LINK_PRO_SOLUTION; ?>") {
				linkcolour = "#00BD53";
			} else if (linklabelname == "<?php echo $CFG->LINK_CON_SOLUTION; ?>") {
				linkcolour = "#C10031";
			}

			var user = null;
			if (c.users[0].userid) {
				user = c.users[0];
			} else {
				user = c.users[0].user;
			}

			var data = {
				"$color": linkcolour,
				"$label": linklabelname,
				"$direction": [fN.nodeid,tN.nodeid],
				"$connid": c.connid,
				"$oriuser": user,
			};

			graph.addAdjacence(fromNode, toNode, data);
		} else {
			return false;
		}
	}

	return true;
}

/**
 * Add the given node to the given graph
 */
function addNodeToMap(viewnode, positionedMap) {

	var graph = positionedMap.graph;
	var node = viewnode.node[0].cnode;
	if (node) {
		if (!checkNodes[node.nodeid]) {
			var thisnode = createMapNode(viewnode, node);
			var next = graph.addNode(thisnode);
			next.pos.setc(parseInt(viewnode.xpos), parseInt(viewnode.ypos));
			checkNodes[node.nodeid] = node.nodeid;
			return next;
		}
	}

	return false;
}

/**
 * Create the json object of the node that is added to a map
 * @param node the json node object of the node to add.
 */
function createMapNode(viewnode, node) {
	var name = node.name;
	var role = node.role[0].role;
	var rolename = role.name;

	var nodeImage = "";
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		nodeImage = URL_ROOT + node.imagethumbnail;
	} else if (role) {
		if (role.image != null && role.image != "") {
			nodeImage = URL_ROOT + role.image;
		}
	}

	var nodeDesc = "";
	if (node.description) {
		nodeDesc = node.description;
	}

	// Get HEX for node Role
	var nodeHEX = getHexForRole(rolename);

	// Get language name for role
	rolename = getNodeTitleAntecedence(rolename, false);

	var user = null;
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var text = "";
	if (name.length > 90) {
		text = name;
	}
	if (name.length > 90 && (nodeDesc && nodeDesc != "")) {
		text = text + "<br><br>";
	}
	if (nodeDesc && nodeDesc != "") {
		text = text + nodeDesc;
	}
	nodeDesc = text;

	var thisnode = null;
	var connections = new Array();
	var thisnode = {
		"data": {
			"$color": nodeHEX,
			"$nodetype": rolename,
			"$orinode": node,
			"$orirole": role,
			"$oriuser": user,
			"$userid":viewnode.userid,
			"$icon": nodeImage,
			"$desc": nodeDesc,
			"$connections":connections,
			"$xpos":viewnode.xpos,
			"$ypos":viewnode.ypos,
			"$mediaindex":viewnode.mediaindex,
			"$index":-1,
			"$leftrec":new mapRectangle(0,0,0,0),
			"$rightrec":new mapRectangle(0,0,0,0),
			"$uprec":new mapRectangle(0,0,0,0),
			"$downrec":new mapRectangle(0,0,0,0),
			"$mainrec":new mapRectangle(0,0,0,0),
			"$userrec":new mapRectangle(0,0,0,0),
			"$iconrec":new mapRectangle(0,0,0,0),
			"$textrec":new mapRectangle(0,0,0,0),
			"$descrec":new mapRectangle(0,0,0,0),
			"$viewrec":new mapRectangle(0,0,0,0),
			"$linkrec":new mapRectangle(0,0,0,0),
			"$networkrec":new mapRectangle(0,0,0,0),
			"$urlrec":new mapRectangle(0,0,0,0),
		},
		"id": node.nodeid,
		"name": name,
	};

	return thisnode;
}

/**
 * Compute positions incrementally and animate.
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
function layoutMap(graphview, messagearea) {

	var width = $(graphview.config.injectInto+'-outer').offsetWidth;
	var height = $(graphview.config.injectInto+'-outer').offsetHeight;
	clipInitialCanvas(graphview, width, height);

	var size = graphview.canvas.getSize();
	//alert("layoutMap:"+size.width+":"+size.height);
	if (size.width > width || size.height > height) {
		zoomFDFit(graphview);
	} else {
		//var rootNodeID = graphview.root;
		//panToNodeFD(graphview, rootNodeID);
	}

	if (messagearea) {
		messagearea.innerHTML="";
		messagearea.style.display = "none";
	}

	graphview.canvas.getPos(true);
}

function clearSelectedMapNodes(graphview) {
    for(var i in graphview.graph.nodes) {
    	var n = graphview.graph.nodes[i];
		delete n.selected;
    }
}


/**
 * Return the currently selected node.
 */
function getSelectMapNode(graphview) {
	var selectedNode = "";

    for(var i in graphview.graph.nodes) {
    	var n = graphview.graph.nodes[i];
		if(n.selected) {
			selectedNode = n;
			break;
        }
    }

	return selectedNode;
}

/**
 * Clear all link selection.
 */
function clearSelectedMapLinks(graphview) {
    for(var i in graphview.graph.edges) {
         var edgeslist = graphview.graph.edges[i];
	     for(var j in edgeslist) {
			var adj = edgeslist[j];
			adj.setData('selected', false);
		}
    }
}

/**
 * Return the currently selected link.
 */
function getSelectLink(graphview) {
	var selectedLink = "";

    for(var i in graphview.graph.edges) {
         var edgeslist = graphview.graph.edges[i];
	     for(var j in edgeslist) {
			var adj = edgeslist[j];
			if(adj.getData('selected')) {
				return adj;
			}
		}
    }

	return selectedLink;
}

/** MAP PLAYER FUNCTION **/

function mapcreationdatenodesortasc(a, b) {
	var nodeA = a.getData('orinode');
	var nodeB = b.getData('orinode');
	var nameA = nodeA.creationdate;
	var nameB = nodeB.creationdate;
	if (nameA < nameB) {
		return -1;
	}
	if (nameA > nameB) {
		return 1;
	}
	return 0 ;
}

/**
 * sort map nodes by creationdate and assign indexes ready for replay
 */
function addMapNodeReplayIndexes(graphview) {
	var sortArray = new Array();
    for(var i in graphview.graph.nodes) {
    	sortArray.push(graphview.graph.nodes[i]);
    }

	sortArray.sort(mapcreationdatenodesortasc);
	var count = sortArray.length;
	graphview.mapReplayMaxIndex = count;
    for(var i=0; i<count; i++) {
    	var n = sortArray[i];
    	n.setData('index', i+1);
    }
}

/**
 * clear map nodes replay indexes
 */
function clearMapNodeReplayIndexes(graphview) {
	graphview.mapReplayMaxIndex = 0;
    for(var i in graphview.graph.nodes) {
    	var n = graphview.graph.nodes[i];
    	n.index = -1;
    }
}


/** MEDIA PLAYER FUNCTION **/

function mediaPlayerPlay() {
	var player = NODE_ARGS['mediaplayer'];
	if (player) {
		if (player.playVideo()) {
			player.playVideo();
		} else if (NODE_ARGS['vimeoid'] && NODE_ARGS['vimeoid'] != "") {
			player.play();
		} else {
			player.play();
		}
	}
}

function mediaPlayerSeek(mediaindex) {
	var player = NODE_ARGS['mediaplayer'];
	if (player) {
		if (player.seekTo) {
			player.seekTo(mediaindex);
			player.playVideo();
		} else if (NODE_ARGS['vimeoid'] && NODE_ARGS['vimeoid'] != "") {
			player.setCurrentTime(mediaindex).then(function(seconds) {
				player.play();
			});
		} else {
			player.currentTime = mediaindex;
			player.play();
		}
	}
}

/*async function resolvePausePlayer() {
	await player.pause();
}*/

function mediaPlayerPause() {
	var player = NODE_ARGS['mediaplayer'];
	if (player) {
		if (player.pauseVideo) {
			player.pauseVideo();
		} else if (NODE_ARGS['vimeoid'] && NODE_ARGS['vimeoid'] != "") {
			player.pause()
			//resolvePausePlayer();
		} else {
			player.pause();
		}
	}
}

/*
var lastIndexFetched = 0.0;
async function resolveCurrentIndex() {
	lastIndexFetched = 0.0;
	var player = NODE_ARGS['mediaplayer'];
	try {
		lastIndexFetched = await player.getCurrentTime();
	}
	catch (rejectedValue) {
		console.log("rejectedValue: "+rejectedValue);
	}
}
*/

var currentindex = -1;

function mediaPlayerCurrentIndex() {
	var player = NODE_ARGS['mediaplayer'];
	if (player) {
		if (NODE_ARGS['vimeoid'] && NODE_ARGS['vimeoid'] != "") {
			//resolveCurrentIndex();
			player.getCurrentTime().then(function(seconds) {
			    currentindex = seconds;
			}).catch(function(error) {
			    currentindex = 0.0;
			});
			if (currentindex == -1) {
				// I don't like this!
				setTimeout(mediaPlayerCurrentIndex, 20);
			}
		} else if (player.getCurrentTime) {
			currentindex = player.getCurrentTime();
		} else {
			currentindex = player.currentTime;
		}
	}
	return currentindex;
}