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

			if (adj.getData('selected')) {
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
			if (positionedMap.linkLabelTextOn) {
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

			var context = canvas.getCtx();
			var width = node.getData('width');
			var height = node.getData('height');
			var finalpos = node.pos.getc(true);
			var pos = { x: finalpos.x - width / 2, y: finalpos.y - height / 2};

			var nodeFillStyle = context.fillStyle;

			context.fillStyle = '#ffffff';
			//context.fillStyle = '#cccccc';
			//context.strokeStyle = '#cccccc';

			var nodeboxX = (finalpos.x - width / 2)+8;
			var nodeboxY = (finalpos.y - height / 2)+4;

			var nodeboxWidth = width-16;
			var nodeboxHeight = height-12;

			context['fill' + 'Rect'](nodeboxX, nodeboxY, nodeboxWidth, nodeboxHeight);
			var mainRect = new mapRectangle(nodeboxX, nodeboxY, nodeboxWidth, nodeboxHeight);
			node.setData('mainrec', mainRect);

			if (node.id == NODE_ARGS['nodeid']) {
				context.strokeStyle = '#606060';
				context.lineWidth = 3;
				context['stroke' + 'Rect']((finalpos.x - width / 6)+6, (finalpos.y - height / 4)+2,
					width-12, height);
			} else {
				context.lineWidth="1";
				context.strokeStyle='#E8E8E8'//nodeFillStyle;
				context.fillStyle = '#E8E8E8'//nodeFillStyle;
				context['stroke' + 'Rect']( (finalpos.x - width / 2)+8, (finalpos.y - height / 2)+4,
					width-16, height-4);
			}

			if (node.selected) {
				context.strokeStyle = '#FFFF40';
				context.lineWidth = 3;
				context['stroke' + 'Rect']((finalpos.x - width / 2)+6, (finalpos.y - height / 2)+2,
					width-12, height);
			}

			context.fillStyle = context.strokeStyle = '#000000';
			context.font = "12px Arial";
			context.textBaseline = 'top';


			var orinode = node.getData('orinode');
			var orirole = node.getData('orirole');
			var user = node.getData('oriuser');

			// ROLE ICON

			// Does the node have its own image?
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
			} else {
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
			}

			// Challenge node network graph view
			if (orirole.name == 'Challenge') {
				var	networkicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('network-graph.png'); ?>');
				context.drawImage(networkicon, nodeboxX+12, nodeboxY+40,20,20);
				var networkRect = new mapRectangle(nodeboxX+12, nodeboxY+40, 20, 20);
				node.setData('networkrec', networkRect);
			}

			// TOOLBAR
			var oldfill = context.fillStyle;
			context.fillStyle = nodeFillStyle; //'#E8E8E8';
			context['fill' + 'Rect'](nodeboxX, pos.y+height-18, nodeboxWidth, 18);
			context.fillStyle = oldfill;

			var currentX = nodeboxX+2;

			var mapcount = orinode.mapcount;
			if (mapcount > 1) {
				var currentFont = context.font;
				context.font = "bold 10pt Arial";
				if(navigator.userAgent.indexOf("Firefox") != -1 ) {
					context.fillText(mapcount, currentX, pos.y+height-13);
					var viewRect = new mapRectangle(currentX, pos.y+height-13, 10, 12);
				} else {
					context.fillText(mapcount, currentX, pos.y+height-15);
					var viewRect = new mapRectangle(currentX, pos.y+height-15, 10, 12);
				}
				node.setData('viewrec', viewRect);
				currentX = currentX+16;
				context.font = currentFont;
			}

			// EXPLORE.
			var descicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('desc-gray.png'); ?>");
			context.drawImage(descicon, currentX, pos.y+height-16, 16, 16);
			var descRect = new mapRectangle(currentX, pos.y+height-16, 16, 16);
			node.setData('descrec', descRect);
			currentX = currentX+22;

			// LINKS
			if (orinode.urls && orinode.urls.length > 0) {
				var	linkicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('link.png'); ?>');
				context.drawImage(linkicon, currentX, pos.y+height-16,16,16);
				var linkRect = new mapRectangle(currentX, pos.y+height-16, 16, 16);
				node.setData('linkrec', linkRect);
				currentX = currentX+20;
			}

			// NODE IN MAP URL
			var	urlicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('link2.png'); ?>");
			context.drawImage(urlicon, currentX, pos.y+height-17,16,16);
			var urlRect = new mapRectangle(currentX, pos.y+height-17, 16, 16);
			node.setData('urlrec', urlRect);
			currentX = currentX+22;

			// MENU ARROW
			//var oldfill = context.fillStyle;
			//context.fillStyle = '#E8E8E8';
			//context['fill' + 'Rect'](nodeboxX+nodeboxWidth-20, pos.y+height-18, 20, 18);
			//context.fillStyle = oldfill;

			/*var downarrowRect = new mapRectangle(nodeboxX+nodeboxWidth-20, pos.y+height-18, 20, 18);
			node.setData('downrec', downarrowRect);

			$('maparrowdiv').innerHTML = "";
			var downarrow = '<?php echo $HUB_FLM->getImagePath('rightarrowlarge.gif'); ?>';
			var downarrowicon = positionedMap.graph.getImage(downarrow);
			if (downarrowicon.complete) {
				context.drawImage(downarrowicon, nodeboxX+nodeboxWidth-17, pos.y+height-17, 16, 17);
			} else {
				downarrowicon.onload = function () {
					context.drawImage(downarrowicon, nodeboxX+nodeboxWidth-17, pos.y+height-17, 16, 17);
				};
			}
			*/

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
			if (orinode.thumb && orirole.name == 'Idea') {
				var roleicon = positionedMap.graph.getImage(orinode.thumb);
				if (roleicon.complete) {
					var imgheight = roleicon.height;
					var imgwidth = roleicon.width;
					var imghid = nodeboxHeight-18;
					var imgwid = maxWidth;
					var size = calculateAspectRatioFit(imgwidth,imgheight, imgwid, imghid);
					context.drawImage(roleicon, nodeboxX+45, nodeboxY+5, size.width, size.height);
				} else {
					var roleimage = orinode.thumb;
					var	roleicon = new Image();
					roleicon.src = roleimage;
					positionedMap.graph.addImage(roleicon);
					roleicon.onload = function () {
						var imgheight = roleicon.height;
						var imgwidth = roleicon.width;
						var imghid = nodeboxHeight-18;
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

 /**
  * Taken from: http://stackoverflow.com/questions/3971841/how-to-resize-images-proportionally-keeping-the-aspect-ratio
  * Conserve aspect ratio of the orignal region. Useful when shrinking/enlarging
  * images to fit into a certain area.
  *
  * @param {Number} srcWidth Source area width
  * @param {Number} srcHeight Source area height
  * @param {Number} maxWidth Fittable area maximum available width
  * @param {Number} maxHeight Fittable area maximum available height
  * @return {Object} { width, heigth }
  */
function calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {
    var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);
    return { width: srcWidth*ratio, height: srcHeight*ratio };
}

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
		  	oriuser:null,
		},

		// Add events
		Events: {
			enable: true,
		  	enableForEdges: true,

			type: 'Native',

		  	onMouseUp: function(node, eventInfo, e) {
				if (!node) {
					//alert("drag moved");
					//$jit.util.event.stop(e); //stop default event
					return;
				}
		  	},
		  	onMouseDown: function(node, eventInfo, e) {
				if (!node) {
					//alert("drag moved");
					//$jit.util.event.stop(e); //stop default event
					return;
				}
		  	},

			//Change cursor style when hovering a node
			onMouseEnter: function(node, eventInfo, e) {
				if (!node) return;
			},
			onMouseMove: function(node, eventInfo, e) {
				if (!node) {
					return;
				}

				var isLink = node.nodeFrom ? true : false;
				if (!isLink) {
					var pos = eventInfo.getPos();

					//var downarrowRec = node.getData('downrec');
					var mainRec = node.getData('mainrec');
					var userRec = node.getData('userrec');
					var iconRec = node.getData('iconrec');
					var textRec = node.getData('textrec');
					var descRec = node.getData('descrec');
					var viewRec = node.getData('viewrec');
					var linkRec = node.getData('linkrec');
					var urlRec = node.getData('urlrec');

					/*if (downarrowRec.contains(pos.x, pos.y)) {
						fd.canvas.getElement().style.cursor = 'pointer';
						showMapMenu("down", node, e);
					} else*/ if (iconRec.contains(pos.x, pos.y)) {
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
							if (orinode.image && orirole.name == 'Idea') {
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
				if (!node) return;

				//var isLink = node.nodeFrom ? true : false;
				//if (isLink) {
				//	hideHints();
				//} else {
					hideBox('maparrowdiv');
					hideBox('maphintdiv');
					hideBox('mapdescdiv');
				//}
			},

			//Update node positions when dragged
			onDragMove: function(node, eventInfo, e) {
				if (!node) {
					return;
				}
			},

			onDragEnd: function(node, eventInfo, e) {
				if (!node) {
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
				if (!node) return;

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
				if (!node) {
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

	fd.graph = new $jit.Graph(fd.graphOptions, fd.config.Node, fd.config.Edge, fd.config.Label);

	var downarrow = '<?php echo $HUB_FLM->getImagePath('downarrowbig.gif'); ?>';
	var downarrowicon = new Image();
	downarrowicon.src = downarrow;
	fd.graph.addImage(downarrowicon);

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
								viewMapDetails(nextnode.cnode.nodeid);
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
	var panel = $('maparrowdiv');
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
			if (urltitle && urltitle.length > 20) {
				urltitle = urltitle.substr(0,20)+"...";
			}
			urlnode.insert(urltitle);
			urlnode.href = url;
			innerpanel.insert(urlnode);

		}
	}

	panel.update(innerpanel);
	adjustMenuPosition(panel, evt);
	showBox('maparrowdiv');
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