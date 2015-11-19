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

/** REQUIRES: graphlib.js.php **/

function drawLineToPointer(fd, fromNode, e, pos, toNode, isCon) {

	var orifrom = fromNode.pos.getc(true);
	var from = computeIntersectionWithRectangle(fromNode, orifrom, pos);
	var to = pos;

	var dim = 14; //adj.getData('dim');
	var vect = new $jit.Complex(to.x - from.x, to.y - from.y);
	vect.$scale(dim / vect.norm());
	var posVect = vect;
	var intermediatePoint = new $jit.Complex(to.x - posVect.x, to.y - posVect.y);
	var normal = new $jit.Complex(-vect.y / 2, vect.x / 2);
	var endPoint = intermediatePoint.add(vect);
	var v1 = intermediatePoint.add(normal);
	var v2 = intermediatePoint.$add(normal.$scale(-1));

	var context = fd.canvas.getCtx();

	if (toNode && (toNode.id != fromNode.id) && !checkLinkNodes(fromNode, toNode)) {
		context.strokeStyle = '#FE8D32';
		context.fillStyle = '#FE8D32';

		// Link Text
		var labeltext = "<?php echo $LNG->MAP_CONNECTION_TEST_ERROR; ?>";
		context.font = "bold 12px Arial";
		context.textBaseline = 'top';
		var metrics = context.measureText(labeltext);
		var testWidth = metrics.width;
		var posVectLabel = new $jit.Complex((to.x - from.x)/2, (to.y - from.y)/2);
		var intermediatePointLabel = new $jit.Complex(to.x - posVectLabel.x, to.y - posVectLabel.y);
		context.fillText(labeltext, (intermediatePointLabel.x-(testWidth/2)), intermediatePointLabel.y);
	} else if (fromNode.getData('orirole').name == 'Pro') {
		context.strokeStyle = '#00BD53';
		context.fillStyle = '#00BD53';
	} else if (fromNode.getData('orirole').name == 'Con') {
		context.strokeStyle = '#C10031';
		context.fillStyle = '#C10031';
	} else if (fromNode.getData('orirole').name == 'Argument') {
		if (isCon) {
			context.strokeStyle = '#C10031';
			context.fillStyle = '#C10031';
		} else {
			context.strokeStyle = '#00BD53';
			context.fillStyle = '#00BD53';
		}
	} else {
		context.strokeStyle = '#C0C0C0';
		context.fillStyle = '#C0C0C0';
	}

	context.lineWidth = 1;

	context.beginPath();
	context.moveTo(from.x, from.y);
	context.lineTo(pos.x, pos.y);
	context.stroke();

	// Arrow head
	context.beginPath();
	context.moveTo(v1.x, v1.y);
	context.moveTo(v1.x, v1.y);
	context.lineTo(v2.x, v2.y);
	context.lineTo(endPoint.x, endPoint.y);
	context.closePath();
	context.fill();
}

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

			var currentFill = context.fillStyle;

			if (adj.getData('selected')) {
				context.strokeStyle = '#FFFF40';
				context.fillStyle = '#FFFF40';
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
			var context = canvas.getCtx();

			var width = node.getData('width');
			var height = node.getData('height')+10;
			var finalpos = node.pos.getc(true);
			var pos = { x: finalpos.x - width / 2, y: finalpos.y - height / 2};

			var nodeFillStyle = context.fillStyle;

			//context.fillStyle = '#cccccc';
			//context.strokeStyle = '#cccccc';
			// border around box

			context.fillStyle = '#ffffff';
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
				context['stroke' + 'Rect']( (finalpos.x - width /  2)+6, (finalpos.y - height / 2)+2,
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
				context['stroke' + 'Rect']( (finalpos.x - width / 2)+6, (finalpos.y - height / 2)+2,
					width-12, height);
			}


			context.fillStyle = context.strokeStyle = '#000000';
			context.font = "12px Arial";
			context.textBaseline = 'top';

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
				} else if (orirole.name == 'Argument') {
					roleicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('nodetypes/Default/argument64.png'); ?>');
				} else if (orirole.name == 'Idea') {
					roleicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('nodetypes/Default/idea64.png'); ?>');
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

			//if (orinode.private == 'Y') {
			//	alert(USER+":"+user.userid+":"+orinode.connectedness);
			//}

			// Challenge node network graph view
			if (orirole.name == 'Challenge') {
				var	networkicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('network-graph.png'); ?>');
				context.drawImage(networkicon, nodeboxX+12, nodeboxY+40,20,20);
				var networkRect = new mapRectangle(nodeboxX+12, nodeboxY+40, 20, 20);
				node.setData('networkrec', networkRect);
			} else if (orirole.name != 'Map' && orinode.connectedness == 0) {
				if (USER && USER != "" && NODE_ARGS['caneditmap'] == 'true' && USER == user.userid) {
					//var labeltext = '<?php echo $LNG->MAP_CHANGE_NODETYPE; ?>';
					//context['fill' + 'Rect'](nodeboxX+5, pos.y+45, 50, 20);
					//wrapText(context, labeltext, nodeboxX+5, nodeboxY+35, 50, 15, 10);
					//var typeRec = new mapRectangle(nodeboxX+5, nodeboxY+35, 50, 20);
					//node.setData('rolechangerec', typeRec);

					var	editicon2 = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('edit2.png'); ?>');
					context.drawImage(editicon2, nodeboxX+2, nodeboxY+38,22,22);

					var typeRec = new mapRectangle(nodeboxX+2, nodeboxY+38, 22, 22);
					node.setData('rolechangerec', typeRec);
				}
			}

			// PRIVATE PADLOCK
			var private = orinode.private;
			if (private == "Y") {
				var	padlockicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>");
				context.drawImage(padlockicon, nodeboxX+22, pos.y+42,18,18);
			}

			// TOOLBAR
			var oldfill = context.fillStyle;
			context.fillStyle = nodeFillStyle; //'#E8E8E8';
			context['fill' + 'Rect'](nodeboxX, pos.y+height-18, nodeboxWidth, 18);
			context.fillStyle = oldfill;

			var currentX = nodeboxX+3;

			// TRANSCLUSION NUMBER
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

			var descicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('desc-gray.png'); ?>");
			context.drawImage(descicon, currentX, pos.y+height-16, 15, 15);
			var descRect = new mapRectangle(currentX, pos.y+height-16, 15, 15);
			node.setData('descrec', descRect);
			currentX = currentX+20;

			// LINKS
			if (orinode.urls && orinode.urls.length > 0) {
				var	linkicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('link.png'); ?>');
				context.drawImage(linkicon, currentX, pos.y+height-16,16,16);
				var linkRect = new mapRectangle(currentX, pos.y+height-16, 16, 16);
				node.setData('linkrec', linkRect);
				currentX = currentX+20;
			}

			var	urlicon = positionedMap.graph.getImage("<?php echo $HUB_FLM->getImagePath('link2.png'); ?>");
			context.drawImage(urlicon, currentX, pos.y+height-17,16,16);
			var urlRect = new mapRectangle(currentX, pos.y+height-17, 16, 16);
			node.setData('urlrec', urlRect);
			currentX = currentX+22;

			// VOTING
			if (orirole.name == 'Issue'
				|| orirole.name == 'Solution'
				|| orirole.name == 'Argument'
				|| orirole.name == 'Pro'
				|| orirole.name == 'Con') {

				orinode.positivevotes = 0;
				orinode.negativevotes = 0;
				orinode.uservotefor = "";
				orinode.uservoteagainst = "";

				var i=0;

			   	node.eachAdjacency(function(adj) {
					var conn = adj.getData('oriconn');
					var fN = conn.from[0].cnode;
					var tN = conn.to[0].cnode;
					if(tN.role[0].role.name != 'Map') {
						if (fN.nodeid == node.id) {
							i++;
							//var connuser = adj.getData('oriuser');
							orinode.positivevotes += parseInt(conn.positivevotes);
							orinode.negativevotes += parseInt(conn.negativevotes);
							if (conn.uservote == 'Y') {
								orinode.uservotefor = 'Y';
							} else if  (conn.uservote == 'N') {
								orinode.uservoteagainst = 'Y';
							}
						}
					}
				});

				if (i > 0) {
					if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
						if (orinode.uservotefor && orinode.uservotefor == 'Y') {
							var	votehand = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('thumb-up-filled-32.png'); ?>');
							context.drawImage(votehand, currentX, pos.y+height-17,16,16);
						} else if (!orinode.uservotefor || orinode.uservotefor != 'Y') {
							var	votehand = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('thumb-up-empty-32.png'); ?>');
							context.drawImage(votehand, currentX, pos.y+height-17,16,16);
						}
						var voteRect = new mapRectangle(currentX, pos.y+height-17, 16, 16);
						node.setData('voteforrec', voteRect);
					} else {
						var	votehand = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('thumb-up-grey-32.png'); ?>');
						context.drawImage(votehand, currentX, pos.y+height-17,16,16);
					}

					currentX = currentX+17;

					// FOR NUMBER
					if (!orinode.positivevotes) {
						orinode.positivevotes = 0;
					}
					if(navigator.userAgent.indexOf("Firefox") != -1 ) {
						context.fillText(orinode.positivevotes, currentX, pos.y+height-12);
					} else {
						context.fillText(orinode.positivevotes, currentX, pos.y+height-14);
					}
					currentX = currentX+13;

					// vote against
					if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
						if (orinode.uservoteagainst && orinode.uservoteagainst == 'Y') {
							var	votehand = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('thumb-down-filled-32.png'); ?>');
							context.drawImage(votehand, currentX, pos.y+height-17,16,16);
						} else if (!orinode.uservoteagainst || orinode.uservoteagainst != 'Y') {
							var	votehand = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('thumb-down-empty-32.png'); ?>');
							context.drawImage(votehand, currentX, pos.y+height-17,16,16);
						}
						var voteRect = new mapRectangle(currentX, pos.y+height-17, 16, 16);
						node.setData('voteagainstrec', voteRect);
					} else {
						var	votehand = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('thumb-down-grey-32.png'); ?>');
						context.drawImage(votehand, currentX, pos.y+height-17,16,16);
					}

					currentX = currentX+17;

					// AGAINST NUMBER
					if (!orinode.negativevotes) {
						orinode.negativevotes = 0;
					}
					if(navigator.userAgent.indexOf("Firefox") != -1 ) {
						context.fillText(orinode.negativevotes, currentX, pos.y+height-12);
					} else {
						context.fillText(orinode.negativevotes, currentX, pos.y+height-14);
					}

					currentX = currentX+15;
				}
			}

			// EDIT / REMOVE ICON - php determins if you can edit the map.
			if (USER && USER != "" && NODE_ARGS['caneditmap'] == 'true' && USER == user.userid) {
				var	editicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('edit-32.png'); ?>');
				context.drawImage(editicon, currentX, pos.y+height-16,16,16);
				var editRect = new mapRectangle(currentX, pos.y+height-16, 16, 16);
				node.setData('editrec', editRect);
				currentX = currentX+18;
			}

			if (USER && USER != "" && NODE_ARGS['caneditmap'] == 'true' && orirole.name != "Challenge") {
				var	deleteicon = positionedMap.graph.getImage('<?php echo $HUB_FLM->getImagePath('delete-32.png'); ?>');
				context.drawImage(deleteicon, currentX, pos.y+height-16,16,16);
				var deleteRect = new mapRectangle(currentX, pos.y+height-16, 16, 16);
				node.setData('deleterec', deleteRect);
				currentX = currentX+20;
			}

			// MENU ARROW
			//var oldfill = context.fillStyle;
			//context.fillStyle = '#E8E8E8';
			//context['fill' + 'Rect'](nodeboxX+nodeboxWidth-20, pos.y+height-18, 20, 18);
			//context.fillStyle = oldfill;

			if (USER && USER != "" && NODE_ARGS['caneditmap'] == 'true') {
				var downarrowRect = new mapRectangle(nodeboxX+nodeboxWidth-20, pos.y+height-18, 20, 18);
				node.setData('downrec', downarrowRect);
				var downarrow = '<?php echo $HUB_FLM->getImagePath('rightarrowlarge.gif'); ?>';
				var downarrowicon = positionedMap.graph.getImage(downarrow);
				if (downarrowicon.complete) {
					context.drawImage(downarrowicon, nodeboxX+nodeboxWidth-17, pos.y+height-17, 16, 17);
				} else {
					downarrowicon.onload = function () {
						context.drawImage(downarrowicon, nodeboxX+nodeboxWidth-17, pos.y+height-17, 16, 17);
					};
				}

				/*
				var rightarrow = '<?php echo $HUB_FLM->getImagePath('rightarrow.gif'); ?>';
				var rightarrowicon = positionedMap.graph.getImage(rightarrow);
				context.drawImage(rightarrowicon, pos.x+(width-8), pos.y+((height/2)-8), 8, 16);
				var rightarrowRect = new mapRectangle(pos.x+(width-8), pos.y+((height/2)-8), 8, 16);
				node.setData('rightrec', rightarrowRect);

				var leftarrow = '<?php echo $HUB_FLM->getImagePath('leftarrow.gif'); ?>';
				var leftarrowicon = positionedMap.graph.getImage(leftarrow);
				context.drawImage(leftarrowicon, pos.x, pos.y+((height/2)-8), 8, 16);
				var leftarrowRect = new mapRectangle(pos.x, pos.y+((height/2)-8), 8, 16);
				node.setData('leftrec', leftarrowRect);

				var uparrow = '<?php echo $HUB_FLM->getImagePath('uparrow.gif'); ?>';
				var uparrowicon = positionedMap.graph.getImage(uparrow);
				context.drawImage(uparrowicon, pos.x+((width/2)-8), pos.y, 16, 8);
				var uparrowRect = new mapRectangle(pos.x+((width/2)-8), pos.y, 16, 8);
				node.setData('uprec', uparrowRect);
				*/
			}

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
			node.setData('userrec', userRect);
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
			*/

			var maxWidth = 155;

			// Does the node have its own image?
			if (orinode.image && orirole.name == 'Idea') {
				var roleicon = positionedMap.graph.getImage(orinode.image);
				if (roleicon.complete) {
					var imgheight = roleicon.height;
					var imgwidth = roleicon.width;
					var imghid = nodeboxHeight-18;
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

function createNewMap(containername, rootNodeID, backgroundImagePath) {
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
			panning: 'avoid nodes', //false to stop canvas dragging
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
			height: 75,
			width: 216,
			nodetype: "",
			orinode: null,
			orirole: null,
			oriuser:null,
			userid:null,
			icon: "",
			desc: "",
			iscon: "",
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
			voteforrec:null,
			voteagainstrec:null,
			editrec:null,
			deleterec:null,
			linkrec:null,
			urlrec:null,
			networkrec:null,
			rolechangerec:null,
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
				if (!node) {
					return;
				}

				var isLink = node.nodeFrom ? true : false;
				if (!isLink) {
					var pos = eventInfo.getPos();

					//var leftarrowRec = node.getData('leftrec');
					//var rightarrowRec = node.getData('rightrec');
					//var uparrowRec = node.getData('uprec');

					var downarrowRec = node.getData('downrec');
					var mainRec = node.getData('mainrec');
					var userRec = node.getData('userrec');
					var iconRec = node.getData('iconrec');
					var textRec = node.getData('textrec');
					var descRec = node.getData('descrec');
					var viewRec = node.getData('viewrec');
					var voteForRec = node.getData('voteforrec');
					var voteAgainstRec = node.getData('voteagainstrec');
					var editRec = node.getData('editrec');
					var deleteRec = node.getData('deleterec');
					var linkRec = node.getData('linkrec');
					var networkRec = node.getData('networkrec');
					var rolechangeRec = node.getData('rolechangerec');
					var urlRec = node.getData('urlrec');

					//hideBox('maparrowdiv');

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
							//var desc = node.getData('desc');
							var text = '<?php echo $LNG->MAP_NODE_DETAILS_HINT; ?>';
							//if (desc != "") {
							//	text = desc+"<br><br>"+'<?php echo $LNG->MAP_NODE_DETAILS_HINT; ?>';
							//}
							showMapHint('mapdescdiv', node, text, e);
						}
					} else if (viewRec && viewRec.contains(pos.x, pos.y)) {
						showViewMenu(node, e, fd);
 					} else if (linkRec && linkRec.contains(pos.x, pos.y)) {
						showURLMenu(node, e);
					} else if (downarrowRec && downarrowRec.contains(pos.x, pos.y)) {
						fd.canvas.getElement().style.cursor = 'pointer';
						showMapMenu(fd,"down", node, e);
 					} else if (networkRec && networkRec.contains(pos.x, pos.y)) {
						var text = '<?php echo $LNG->VIEWS_EVIDENCE_MAP_HINT; ?>';
						showMapHint('maphintdiv', node, text, e);
					} else if ( (editRec && editRec.contains(pos.x, pos.y)) ||
							(voteForRec && voteForRec.contains(pos.x, pos.y)) ||
							(voteAgainstRec && voteAgainstRec.contains(pos.x, pos.y))) {
						if(USER != "") {
							fd.canvas.getElement().style.cursor = 'pointer';
						} else {
							fd.canvas.getElement().style.cursor = 'default';
						}
					} else if (deleteRec && deleteRec.contains(pos.x, pos.y)) {
						if(USER != "") {
							fd.canvas.getElement().style.cursor = 'pointer';
							//var text = '<?php echo $LNG->MAP_REMOVE_NODE_HINT; ?>';
							//showMapHint('maphintdiv', node, text, e);
						}
					} else if (rolechangeRec && rolechangeRec.contains(pos.x, pos.y)) {
						showRoleMenu(node, e, fd);
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
					} else {
						fd.canvas.getElement().style.cursor = 'default';
					}
				}
			},

			onMouseLeave: function(node, eventInfo, e) {
				fd.canvas.getElement().style.cursor = '';
				if (!node) return;

				hideBox('maparrowdiv');
				hideBox('maphintdiv');
				hideBox('mapdescdiv');
			},

			onDragStart: function(node, eventInfo, e) {
				//console.log("onDragStart:"+node.id);
				if (!node) {
					return;
				}
				// Do not want right-click to activate a node drag
				//alert(e.which+":"+e.button);
				//added last check as two drag starts (one right and one left click)
				//being sent on a right-click so this stops it overriding a right-click drag that has started.
				if (e.which == 3 || e.button == 2 || fd.config.drag === false) {
					fd.config.drag = false;
					//console.log("RIGHT CLICK");
				} else {
					fd.config.drag = true;
					//console.log("LEFT CLICK");
				}
			},

			onDragCancel: function(node, eventInfo, e) {
				//alert("onDragCancel");
				if (fd.config.drag === false) { //right-click drag
					fd.config.drag = true;
					fd.refresh();
				}
				//if (!node) {
					return;
				//}
			},

			onDragMove: function(node, eventInfo, e) {
				//alert("onDragMove");
				if (!node) {
					return;
				}
				var isLink = node.nodeFrom ? true : false;

				if (fd.config.drag === false) {
					//console.log("Drag False");
					// CHROME IS BEING SILLY AND ENDS UP HERE FOR CLICKS SO TRY AND COMPENSATE
					var edge = eventInfo.getEdge();
					if (!isLink || !edge) {
						if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
							fd.refresh(); //clear any previous line
							var pos = eventInfo.getPos();
							var toNode = eventInfo.getNode();
							var isCon = "";
							var orirole = node.getData('orirole');
							if (orirole.name == 'Argument') {
								var mainRec = node.getData('mainrec');
								var pos = eventInfo.getPos();
								var lefthalf = new mapRectangle(mainRec.x, mainRec.y, mainRec.width/2, mainRec.height);
								var righthalf = new mapRectangle(mainRec.x+(mainRec.width/2), mainRec.y, mainRec.width/2, mainRec.height);
								if (righthalf.contains(pos.x, pos.y)) {
									isCon = true;
									node.setData('iscon', isCon);
								} else if (lefthalf.contains(pos.x, pos.y)) {
									isCon = false;
									node.setData('iscon', isCon);
								} else {
									isCon = node.getData('iscon');
								}
							}
							drawLineToPointer(fd, node, e, pos, toNode,isCon);
						}
					}
					return;
				} else {
					//console.log("Drag true");
					if (!isLink) {
						var pos = eventInfo.getPos();

						var voteForRec = node.getData('voteforrec');
						var voteAgainstRec = node.getData('voteagainstrec');
						var editRec = node.getData('editrec');
						var deleteRec = node.getData('deleterec');
						var descRec = node.getData('descrec');
						var networkRec = node.getData('networkrec');

						if (descRec && descRec.contains(pos.x, pos.y)) {
							return;
						} else if (editRec && editRec.contains(pos.x, pos.y)) {
							return;
						} else if (deleteRec && deleteRec.contains(pos.x, pos.y)) {
							return;
						} else if (networkRec && networkRec.contains(pos.x, pos.y)) {
							return;
						} else if (voteForRec && voteForRec.contains(pos.x, pos.y)) {
							return;
						} else if (voteAgainstRec && voteAgainstRec.contains(pos.x, pos.y)) {
							return;
						}  else {
							//alert("DRAGGING");
							var actualpos = node.pos.getc(true);
							var diffx = actualpos.x - pos.x;
							var diffy = actualpos.y - pos.y;
							node.pos.setc(pos.x, pos.y);

							// MOVE ANY SELECTED NODES AS WELL
							var nodes = getSelectMapNodes(fd);
							var count = nodes.length;
							for (var i=0; i<count; i++) {
								var next = nodes[i];
								if (node.id != next.id) {
									var nextpos = next.pos.getc(true);
									next.pos.setc(nextpos.x-diffx, nextpos.y-diffy);
								}
							}
							fd.plot();
						}
					}
				}
			},

			onDragEnd: function(node, eventInfo, e) {
				//alert("onDragEnd");
				if (!node) {
					return;
				}

				if (fd.config.drag === false) { //right-click drag
					var isLink = node.nodeFrom ? true : false;

					// CHROME IS BEING SILLY AND ENDS UP HERE FOR CLICKS SO TRY AND COMPENSATE
					var edge = eventInfo.getEdge();
					if (!isLink || !edge) {
						if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
							// link two nodes.
							var fromNodeID = node.id;
							var toNodeID = eventInfo.getNode().id;
							if (toNodeID) {
								var isCon = node.getData('iscon');
								linkNodes(fromNodeID, toNodeID, isCon);
								$jit.util.event.stop(e);
							} else {
								fd.refresh(); //clear part drawn link
							}
						}
					} else {
						//JUST FOR CHROME
						clearSelectedMapLinks(fd);
						node.setData('selected', true);
						fd.refresh();
						showLinkMenu(node, e, fd);
					}
				} else {
					var isLink = node.nodeFrom ? true : false;
					var edge = eventInfo.getEdge();
					if (!isLink || !edge) {
						// CHROME IS BEING SILLY SO TRY AND COMPENSATE
						var pos = eventInfo.getPos();

						var voteForRec = node.getData('voteforrec');
						var voteAgainstRec = node.getData('voteagainstrec');
						var editRec = node.getData('editrec');
						var deleteRec = node.getData('deleterec');
						var descRec = node.getData('descrec');
						var networkRec = node.getData('networkrec');

						if (descRec && descRec.contains(pos.x, pos.y)) {
							return;
						} else if (editRec && editRec.contains(pos.x, pos.y)) {
							return;
						} else if (deleteRec && deleteRec.contains(pos.x, pos.y)) {
							return;
						} else if (networkRec && networkRec.contains(pos.x, pos.y)) {
							return;
						} else if (voteForRec && voteForRec.contains(pos.x, pos.y)) {
							return;
						} else if (voteAgainstRec && voteAgainstRec.contains(pos.x, pos.y)) {
							return;
						}  else {
							//alert("IN HERE WHY??? pos="+pos.x+":"+pos.y);

							if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
								var actualpos = node.pos.getc(true);
								var userid = node.getData('userid');
								updateNodePosition(NODE_ARGS['nodeid'], node.id, userid, actualpos.x, actualpos.y);

								// DO IT FOR ANY SELECTED NODES
								var nodes = getSelectMapNodes(fd);
								var count = nodes.length;
								for (var i=0; i<count; i++) {
									var next = nodes[i];
									if (node.id != next.id) {
										var nextpos = next.pos.getc(true);
										var nextuserid = next.getData('userid');
										updateNodePosition(NODE_ARGS['nodeid'], next.id, nextuserid, nextpos.x, nextpos.y);
									}
								}
							}
						}
					} else {
						//JUST FOR CHROME
						clearSelectedMapLinks(fd);
						node.setData('selected', true);
						fd.refresh();
						showLinkMenu(node, e, fd);
					}
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
				e.preventDefault();

				//alert("fred");
				//return false;

				if (!node) {
					var pos = eventInfo.getPos();
					showCanvasMenu(e, fd, pos);
					return false;
				} else {
					var isLink = node.nodeFrom ? true : false;
					if (isLink) {
						clearSelectedMapLinks(fd);
						node.setData('selected', true);
						fd.refresh();
						showLinkMenu(node, e, fd);
					} else {
						var pos = eventInfo.getPos();
						var textrect = node.getData('textrec');
						if (textrect && textrect.contains(pos.x, pos.y)) {
							var orinode = node.getData('orinode');
							if (orinode.image) {
								loadDialog('bigimage',orinode.image, 800,600);
							}
						}
					}
					return false;
				}
			},

			onClick: function(node, eventInfo, e) {
				if (!node) {
					clearSelectedMapLinks(fd);
					clearSelectedMapNodes(fd);
					hideBox('maparrowdiv');
					fd.refresh();
					return;
				}

				// link
				var isLink = node.nodeFrom ? true : false;
				if (isLink) {
					clearSelectedMapLinks(fd);
					node.setData('selected', true);
					fd.refresh();
					showLinkMenu(node, e, fd);

				    /*if(e.ctrlKey) {
						node.setData('selected', true);
						fd.refresh();
					} else {
						clearSelectedMapLinks(fd);
						node.setData('selected', true);
						fd.refresh();
					}
					*/

					//trigger animation to final styles
					//fd.fx.animate({
					//	modes: ['edge-property:lineWidth:color'],
					//	duration: 1
					//});

				// node
				} else {
					var pos = eventInfo.getPos();
					var voteForRec = node.getData('voteforrec');
					var voteAgainstRec = node.getData('voteagainstrec');
					var editRec = node.getData('editrec');
					var deleteRec = node.getData('deleterec');
					var descRec = node.getData('descrec');
					var textrect = node.getData('textrec');
					var networkRec = node.getData('networkrec');
					var rolechangeRec = node.getData('rolchangerec');
					var urlRec = node.getData('urlrec');
					var iconRec = node.getData('iconrec');

					var orinode = node.getData('orinode');

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
							//viewNodeDetailsDiv(nodeid, orirole.name, orinode, e, position.x+30, position.y+30);
							viewNodeDetailsDiv(nodeid, orirole.name, orinode, e, 5, position.y);
						}
					} else if (voteForRec && voteForRec.contains(pos.x, pos.y)) {
						if(USER != ""){
							processVoteClick(node, 'Y', e, fd);
						}
					} else if (voteAgainstRec && voteAgainstRec.contains(pos.x, pos.y)) {
						if(USER != ""){
							processVoteClick(node, 'N', e, fd);
						}
					} else if (editRec && editRec.contains(pos.x, pos.y)) {
						if(USER != ""){
							mapEditNode(node);
						}
					} else if (deleteRec && deleteRec.contains(pos.x, pos.y)) {
						if(USER != ""){
							//hideBox('maphintdiv');
							deleteNodeFromMap(node);
						}
					} else if (networkRec && networkRec.contains(pos.x, pos.y)) {
						var width = getWindowWidth();
						var height = getWindowHeight()-40;
						loadDialog('network',URL_ROOT+"networkgraph.php?id="+node.id, width,height);
					} else if (urlRec && urlRec.contains(pos.x, pos.y)) {
						var code = URL_ROOT+'map.php?id='+NODE_ARGS['nodeid']+'&focusid='+node.id;
						textAreaPrompt('<?php echo $LNG->GRAPH_LINK_MESSAGE; ?>', code, "", "", "");
					} else {
						if(e.ctrlKey) {
							node.selected = true;
							fd.refresh();
						} else if (e.altKey) {
							var checkNodes = new Array();
							selectNodeTree(checkNodes, fd, node.id);
							fd.refresh();
						} else {
							clearSelectedMapNodes(fd);
							node.selected = true;
							hideBox('maparrowdiv');

							/*var nodeid = node.id;
							var orirole = node.getData('orirole');
							if (orirole.name == "Map") {
								var width = getWindowWidth()-50;
								var height = getWindowHeight()-50;
								loadDialog('map', URL_ROOT+"map.php?id="+nodeid, width,height);
							} else {
								var orinode = node.getData('orinode');
								var orirole = node.getData('orirole');
								var position = getPosition($(fd.config.injectInto+'-outer'));
								viewNodeDetailsDiv(nodeid, orirole.name, orinode, e, position.x+30, position.y+30);
							}
							*/
							fd.refresh();
						}

						//trigger animation to final styles
						//fd.fx.animate({
						//	modes: ['edge-property:lineWidth:color'],
						//	duration: 1
						//});
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
			onShow: function(tip, node) {
				/*var connections = node.getData('connections');
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
				*/
			}
		}
	});

	fd.rolloverTitles = true;
	fd.linkLabelTextOn = true;

	fd.graph = new $jit.Graph(fd.graphOptions, fd.config.Node, fd.config.Edge, fd.config.Label);

	//var rightarrow = '<?php echo $HUB_FLM->getImagePath('rightarrow.gif'); ?>';
	//var rightarrowicon = new Image();
	//rightarrowicon.src = rightarrow;
	//fd.graph.addImage(rightarrowicon);

	//var leftarrow = '<?php echo $HUB_FLM->getImagePath('leftarrow.gif'); ?>';
	//var leftarrowicon = new Image();
	//leftarrowicon.src = leftarrow;
	//fd.graph.addImage(leftarrowicon);

	//var uparrow = '<?php echo $HUB_FLM->getImagePath('uparrow.gif'); ?>';
	//var uparrowicon = new Image();
	//uparrowicon.src = uparrow;
	//fd.graph.addImage(uparrowicon);

	//var downarrow = '<?php echo $HUB_FLM->getImagePath('downarrowbig.gif'); ?>';
	//var downarrowicon = new Image();
	//downarrowicon.src = downarrow;
	//fd.graph.addImage(downarrowicon);

	// PRELOAD TOOLBAR ICONS
	var rightarrow = '<?php echo $HUB_FLM->getImagePath('rightarrowlarge.gif'); ?>';
	var rightarrowicon = new Image();
	rightarrowicon.src = rightarrow;
	fd.graph.addImage(rightarrowicon);

	var descicon = '<?php echo $HUB_FLM->getImagePath('desc-gray.png'); ?>';
	var descimage = new Image();
	descimage.src = descicon;
	fd.graph.addImage(descimage);

	var	padlockicon = new Image();
	padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
	fd.graph.addImage(padlockicon);

	var	voteupgrey = new Image();
	voteupgrey.src = '<?php echo $HUB_FLM->getImagePath('thumb-up-grey-32.png'); ?>';
	fd.graph.addImage(voteupgrey);

	var	votedowngrey = new Image();
	votedowngrey.src = '<?php echo $HUB_FLM->getImagePath('thumb-down-grey-32.png'); ?>';
	fd.graph.addImage(votedowngrey);

	var	voteupfill = new Image();
	voteupfill.src = '<?php echo $HUB_FLM->getImagePath('thumb-up-filled-32.png'); ?>';
	fd.graph.addImage(voteupfill);

	var	votedownfill = new Image();
	votedownfill.src = '<?php echo $HUB_FLM->getImagePath('thumb-down-filled-32.png'); ?>';
	fd.graph.addImage(votedownfill);

	var	voteupempty = new Image();
	voteupempty.src = '<?php echo $HUB_FLM->getImagePath('thumb-up-empty-32.png'); ?>';
	fd.graph.addImage(voteupempty);

	var	votedownempty = new Image();
	votedownempty.src = '<?php echo $HUB_FLM->getImagePath('thumb-down-empty-32.png'); ?>';
	fd.graph.addImage(votedownempty);

	var	editicon = new Image();
	editicon.src = '<?php echo $HUB_FLM->getImagePath('edit-32.png'); ?>';
	fd.graph.addImage(editicon);

	var	editicon2 = new Image();
	editicon2.src = '<?php echo $HUB_FLM->getImagePath('edit2.png'); ?>';
	fd.graph.addImage(editicon2);

	var	deleteicon = new Image();
	deleteicon.src = '<?php echo $HUB_FLM->getImagePath('delete-32.png'); ?>';
	fd.graph.addImage(deleteicon);

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

	var	argumenticon = new Image();
	argumenticon.src = '<?php echo $HUB_FLM->getImagePath('nodetypes/Default/argument64.png'); ?>';
	fd.graph.addImage(argumenticon);

	var	ideaicon = new Image();
	ideaicon.src = '<?php echo $HUB_FLM->getImagePath('nodetypes/Default/idea64.png'); ?>';
	fd.graph.addImage(ideaicon);

	if (rootNodeID != "") {
		fd.root = rootNodeID;
	} else {
		fd.root = "";
	}

	// add drop event listener to canvas;
    var htmlCanvas = fd.canvas.getElement();

	Event.observe(htmlCanvas,"dragover", function(e){
		//alert("dragover");
		if (e.dataTransfer) {
			e.dataTransfer.dropEffect = 'copy';
		}
		e.preventDefault();
		e.stopPropagation();
		return true;
	});

	Event.observe(htmlCanvas,"dragenter", function(e){
		//alert("Drag Enter");
		if (e.dataTransfer) {
			e.dataTransfer.dropEffect = 'copy';
		}

		// Firefox was not passing the dataTransfer object so this is the work around.
		var source = e.target || e.srcElement;
		source.dataTransfer = e.dataTransfer.getData('text');

		e.preventDefault();
		e.stopPropagation();
		return true;
	});

	Event.observe(htmlCanvas,"dragleave", function(e){
		e.preventDefault();
		e.stopPropagation();
		return true;
	});

	Event.observe(htmlCanvas,"drop", function(e){
		var nodeid="";
		// Firefox was not passing the dataTransfer object so this is the work around.
		if (e.dataTransfer) {
			nodeid = e.dataTransfer.getData('text');
		} else {
			var source = e.target || e.srcElement;
			var nodeid = source.dataTransfer;
			source.dataTransfer = "";
		}

		e.preventDefault();
		e.stopPropagation();

		//alert(nodeid);

		if (nodeid == 'Pro' || nodeid == 'Con' || nodeid == 'Issue' || nodeid == 'Solution' || nodeid == 'Argument' || nodeid == 'Idea') {
			var pos = getMousePosition(fd, e);
			addBlankNodeToMapFloating(nodeid, pos.x+':'+pos.y);
		} else if (nodeid != "" && !isValidURI(nodeid)) { // block images being dragged.
			var pos = getMousePosition(fd, e);
			addSelectedNodeToMapFloating(nodeid, '', pos.x+':'+pos.y, '');
		}
		return true;
	});

	return fd;
}

function getMousePosition(fd, e) {
	// get mouse position
	win = window;
	e = e || win.event;
	var doc = win.document;
	doc = doc.documentElement || doc.body;
	if(e.touches && e.touches.length) {
	  e = e.touches[0];
	}
	var pos = {
	  x: e.pageX || (e.clientX + doc.scrollLeft),
	  y: e.pageY || (e.clientY + doc.scrollTop)
	};

	// calculate relative to canvas
	var canvas = fd.canvas,
		s = canvas.getSize(),
		p = canvas.getPos(),
		ox = canvas.translateOffsetX,
		oy = canvas.translateOffsetY,
		sx = canvas.scaleOffsetX,
		sy = canvas.scaleOffsetY;
	var page = {
	  x: (pos.x - p.x - s.width/2 - ox) * 1/sx,
	  y: (pos.y - p.y - s.height/2 - oy) * 1/sy
	};
	return page;
}

function updateEditListItem(inMap, nodeid) {
	var items = document.getElementsByName('dndnodeitem'+nodeid);
	if (items.length > 0) {
		if (inMap) {
			var next = null;
			for (var i=0; i<items.length; i++) {
				next = items[i];
				next.style.color = '#C0C0C0';
				next.style.fontStyle = 'italic';
			}
			var items2 = document.getElementsByName('dndnodeitemdiv'+nodeid);
			for (var i=0; i<items2.length; i++) {
				next = items2[i];
				next.removeAttribute('style');
				next.removeAttribute('draggable');
				Event.stopObserving(next,'dragstart');
			}
		} else {
			var next = null;
			for (var i=0; i<items.length; i++) {
				next = items[i];
				next.style.color = '';
				next.style.fontStyle = 'normal';
			}
			var items2 = document.getElementsByName('dndnodeitemdiv'+nodeid);
			for (var i=0; i<items2.length; i++) {
				next = items2[i];
				next.setAttribute('draggable', 'true');
				next.setAttribute('style', '-webkit-user-drag:element'); // For Safari
				Event.observe(next,"dragstart", function(e){
					e.dataTransfer.effectAllowed = "copy";
					e.dataTransfer.setData('text', nodeid);
				});
			}
		}
	}
}

function changeNodeType(node, rolename, graphview) {

	var reqUrl = SERVICE_ROOT + "&method=updatenoderole&nodetypename="+rolename+"&nodeid="+node.id;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				var newnode = json.cnode[0];
				var role = newnode.role[0].role;

				// Update the local map node data for the role change
				var nodeHEX = getHexForRole(rolename);

				var nodeImage = "";
				if (newnode.imagethumbnail != null && newnode.imagethumbnail != "") {
					nodeImage = URL_ROOT + newnode.imagethumbnail;
				} else if (role) {
					if (role.image != null && role.image != "") {
						nodeImage = URL_ROOT + role.image;
					}
				}

				node.setData('orinode', newnode, 'end');
				node.setData('orinode', newnode, 'start');
				node.setData('orinode', newnode);

				node.setData('orirole', role, 'end');
				node.setData('orirole', role, 'start');
				node.setData('orirole', role);

				node.setData('nodetype', rolename, 'end');
				node.setData('nodetype', rolename, 'start');
				node.setData('nodetype', rolename);

				node.setData('color', nodeHEX, 'end');
				node.setData('color', nodeHEX, 'start');
				node.setData('color', nodeHEX);

				node.setData('icon', nodeImage, 'end');
				node.setData('icon', nodeImage, 'start');
				node.setData('icon', nodeImage);

				// UPDATE VISES IF THERE
				if (typeof setMapTabDataReload == 'function') {
					setMapTabDataReload();
				}

				positionedMap.refresh();
			}
		}
	});
}

function mapDeleteConnectionVote(node, connection, vote, fd) {
	var reqUrl = SERVICE_ROOT + "&method=deleteconnectionvote&vote="+vote+"&connid="+connection.connid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
 				if (vote == 'Y' && connection.uservote == 'Y') {
					connection.positivevotes = parseInt(connection.positivevotes)-1;
				} else if (vote == 'N' && connection.uservote == 'N') {
					connection.negativevotes = parseInt(connection.negativevotes)-1;
				}
				if (connection.positivevotes < 0) {
					connection.positivevotes = 0;
				}
				if (connection.negativevotes < 0) {
					connection.negativevotes = 0;
				}
   				connection.uservote = "";

				// UPDATE VISES IF THERE
				if (typeof setMapTabVoteDataReload == 'function') {
					setMapTabVoteDataReload();
				}
				positionedMap.refresh();
			}
		}
	});
}

function mapConnectionVote(node, connection, vote, fd) {
	var reqUrl = SERVICE_ROOT + "&method=connectionvote&vote="+vote+"&connid="+connection.connid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
				if (connection.uservote == 'Y' && vote == 'N') {
					connection.negativevotes = parseInt(connection.negativevotes)+1;
					connection.positivevotes = parseInt(connection.positivevotes)-1;
				} else if (connection.uservote == 'N' && vote == 'Y') {
					connection.negativevotes = parseInt(connection.negativevotes)-1;
					connection.positivevotes = parseInt(connection.positivevotes)+1;
				} else if (connection.uservote == '0' || !connection.uservote || connection.uservote == "") {
					if (vote == 'Y') {
						connection.positivevotes = parseInt(connection.positivevotes)+1;
					} else if (vote == 'N') {
						connection.negativevotes = parseInt(connection.negativevotes)+1;
					}
				}
				if (connection.positivevotes < 0) {
					connection.positivevotes = 0;
				}
				if (connection.negativevotes < 0) {
					connection.negativevotes = 0;
				}
   			   	connection.uservote = vote;

				// UPDATE VISES IF THERE
				if (typeof setMapTabVoteDataReload == 'function') {
					setMapTabVoteDataReload();
				}
				positionedMap.refresh();
			}
		}
	});
}

function mapEditNode(node) {
	var orirole = node.getData('orirole');
	var user = node.getData('oriuser');
	var rolename = orirole.name;
	if (USER && USER != "" && NODE_ARGS['caneditmap'] == 'true' && USER == user.userid) {
		if (rolename == "Challenge") {
			loadDialog('challengeedit',URL_ROOT+"ui/popups/challengeedit.php?handler=mapedithandler&nodeid="+node.id, 750,500);
		} else if (rolename == "Issue") {
			loadDialog('issueedit',URL_ROOT+"ui/popups/issueedit.php?handler=mapedithandler&nodeid="+node.id, 750,500);
		} else if (rolename == "Solution") {
			loadDialog('solutionedit',URL_ROOT+"ui/popups/solutionedit.php?handler=mapedithandler&nodeid="+node.id, 750,500);
		} else if (rolename == "Pro" || rolename == "Con") {
			loadDialog('evidenceedit',URL_ROOT+"ui/popups/evidenceedit.php?handler=mapedithandler&nodeid="+node.id, 750,500);
		} else if (rolename == "Idea") {
			loadDialog('ideaedit',URL_ROOT+"ui/popups/commentedit.php?handler=mapedithandler&nodeid="+node.id, 750,500);
		} else if (rolename == "Map") {
			loadDialog('mapedit',URL_ROOT+"ui/popups/mapedit.php?handler=mapedithandler&nodeid="+node.id, 750,500);
		}
	}
}

function deleteNodeFromMap(node) {
	var ans = confirm("<?php echo $LNG->MAP_REMOVE_NODE_CHECK_PART1; ?> "+node.name+" <?php echo $LNG->MAP_REMOVE_NODE_CHECK_PART2; ?>");
	if(ans){
		var mapid = NODE_ARGS['nodeid'];
		var nodeid = node.id;
		var userid = node.getData('userid');
		var reqUrl = SERVICE_ROOT + "&method=removenodefromview";
		reqUrl += "&viewid="+ encodeURIComponent(mapid);
		reqUrl += "&nodeid="+ encodeURIComponent(nodeid);
		reqUrl += "&userid="+ encodeURIComponent(userid);

		//alert(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){

				var json = transport.responseText.evalJSON();
				//alert(transport.responseText);

				if(json.error){
					alert(json.error[0].message);
					return;
				}

				// viewnode returned that was deleted

				updateEditListItem(false, node.id);

				// UPDATE MAP
				positionedMap.graph.removeNode(node.id);
				delete checkNodes[node.id];

				if ($('graphConnectionCount')) {
					var concount = 0;
			        for(var id in positionedMap.graph.edges) {
						concount++;
					}
					$('graphConnectionCount').innerHTML = "";
					$('graphConnectionCount').insert('<span style="font-size:10pt;color:black;float:left;margin-left:20px"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+concount+'</span>');
				}

				// UPDATE VISES IF THERE
				if (typeof setMapTabDataReload == 'function') {
					setMapTabDataReload();
				}

				if (positionedMap.root == nodeid) {
					positionedMap.root = "";
					computeMostConnectedNode(positionedMap);
				}

				positionedMap.refresh();

				/** Needs this later to redraw the connection tree **/
				var allConnections = new Array();
				var checkConnections = new Array();

				for(var i in positionedMap.graph.edges) {
					 var edgeslist = positionedMap.graph.edges[i];
					 for(var j in edgeslist) {
						var adj = edgeslist[j];
						var conn = adj.getData('oriconn');
						if (checkConnections.indexOf(conn.connid) == -1) {
							allConnections.push(conn);
							checkConnections.push(conn.connid);
						}
					}
				}

				if (allConnections.length > 0) {
					drawTree(allConnections, challengenodeid, "");
				}

			},
			onFailure: function(transport) {
				alert("FAILED");
			}
		});
	}
}

function deleteConnectionFromMap(link) {

	var orifrom = link.nodeFrom;
	var orito = link.nodeTo;

	var connid = link.getData('connid');
	var oriuser = link.getData('oriuser');
	var mapid = NODE_ARGS['nodeid'];

	var reqUrl = SERVICE_ROOT + "&method=removeconnectionfromview";
	reqUrl += "&viewid="+ encodeURIComponent(mapid);
	reqUrl += "&connid="+ encodeURIComponent(connid);
	reqUrl += "&userid="+ encodeURIComponent(oriuser.userid);

	//alert(reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){

			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			//var conn = json.viewconnection[0];

			// UPDATE MAP
			var fromnode = positionedMap.graph.getNode(orifrom.id);
			fromnode.getData('orinode').connectedness--;
			var tonode = positionedMap.graph.getNode(orito.id);
			tonode.getData('orinode').connectedness--;

			positionedMap.graph.removeAdjacence(orifrom.id, orito.id);

			if ($('graphConnectionCount')) {
				var concount = 0;
				for(var id in positionedMap.graph.edges) {
					concount++;
				}
				$('graphConnectionCount').innerHTML = "";
				$('graphConnectionCount').insert('<span style="font-size:10pt;color:black;float:left;margin-left:20px"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+concount+'</span>');
			}

			// UPDATE VISES IF THERE
			if (typeof setMapTabDataReload == 'function') {
				setMapTabDataReload();
			}

			positionedMap.refresh();

			/** Needs this later to redraw the connection tree **/
			var allConnections = new Array();
			var checkConnections = new Array();

			for(var i in positionedMap.graph.edges) {
				 var edgeslist = positionedMap.graph.edges[i];
				 for(var j in edgeslist) {
					var adj = edgeslist[j];
					var conn = adj.getData('oriconn');
					if (checkConnections.indexOf(conn.connid) == -1) {
						allConnections.push(conn);
						checkConnections.push(conn.connid);
					}
				}
			}

			if (allConnections.length > 0) {
				drawTree(allConnections, challengenodeid, "");
			}
		},
		onFailure: function(transport) {
			alert("FAILED");
		}
	});
}

function updateNodePosition(mapid, nodeid, userid, xpos, ypos) {

	// If no one is logged in, or they do not have permissions do not bother sending position move.
	// it will just be rejected.
	if (!USER || USER == "" || !NODE_ARGS['caneditmap'] == 'true') {
		return;
	}

	var reqUrl = SERVICE_ROOT + "&method=editviewnode";
	reqUrl += "&viewid="+ encodeURIComponent(mapid);
	reqUrl += "&nodeid="+ encodeURIComponent(nodeid);
	reqUrl += "&userid="+ encodeURIComponent(userid);
	reqUrl += "&xpos="+ encodeURIComponent(xpos);
	reqUrl += "&ypos="+ encodeURIComponent(ypos);

	//alert(reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){

			var json = transport.responseText.evalJSON();
			//alert(transport.responseText);

			if(json.error){
				//alert(json.error[0].message);
				return;
			}

			//var conns = json.viewnode;
			//alert("SAVED");

		},
		onFailure: function(transport) {
			alert("FAILED");
		}
	});
}


function addExistingNodeToMap(mapid, fromnodeid, tonodeid, linktypename, xpos, ypos) {

	var reqUrl = SERVICE_ROOT + "&method=addnodetoviewandconnect";
	reqUrl += "&viewid="+ encodeURIComponent(mapid);
	reqUrl += "&nodeid="+ encodeURIComponent(fromnodeid);
	reqUrl += "&xpos="+ encodeURIComponent(xpos);
	reqUrl += "&ypos="+ encodeURIComponent(ypos);
	reqUrl += "&linktypename="+encodeURIComponent(linktypename);

	if (linktypename == '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>') {
		reqUrl += "&direction=to";
	} else {
		reqUrl += "&direction=from";
	}

	if (tonodeid && tonodeid != "") {
		reqUrl += "&focalnodeid="+encodeURIComponent(tonodeid);
	} else {
		alert("Parent node id node found");
		return;
	}
	if (NODE_ARGS['groupid'] && NODE_ARGS['groupid'] != "") {
		reqUrl += "&groupid="+NODE_ARGS['groupid'];
	}

	/** Needs this later to redraw the cnnection tree **/
	var allConnections = new Array();
	var checkConnections = new Array();

	for(var i in positionedMap.graph.edges) {
		 var edgeslist = positionedMap.graph.edges[i];
		 for(var j in edgeslist) {
			var adj = edgeslist[j];
			var conn = adj.getData('oriconn');
			if (checkConnections.indexOf(conn.connid) == -1) {
				allConnections.push(conn);
				checkConnections.push(conn.connid);
			}
		}
	}

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){

			//alert(transport.responseText);

			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				positionedMap.refresh();
				return;
			}

			var viewconnection = json.viewconnection[0];

			addConnectionToMap(viewconnection, positionedMap);
			var c = viewconnection.connection[0].connection;
			allConnections.push(c);

			//update tree
			if ($('treedata') && allConnections.length > 0) {
				drawTree(allConnections, '');
			}

			var fromnode = positionedMap.graph.getNode(fromnodeid);
			fromnode.getData('orinode').connectedness++;
			var tonode = positionedMap.graph.getNode(tonodeid);
			tonode.getData('orinode').connectedness++;

			updateEditListItem(true, fromnodeid);

			// UPDATE VISES IF THERE
			if (typeof setMapTabDataReload == 'function') {
				setMapTabDataReload();
			}

			positionedMap.refresh();
   		},
   		onFailure: function(transport) {
   			alert("FAILED");
   		}
 	});
}

function addBlankNodeToMapFloating(nodetype, position) {
	var posx = 0;
	var posy = 0;
	if(position && position != "") {
		var poses = position.split(':');
		posx = poses[0];
		posy = poses[1];
	}

	var typename = getNodeTitleAntecedence(nodetype, false);
	var title = prompt(typename+" <?php echo $LNG->SORT_TITLE; ?>", "");
	if (title != null) {
		var reqUrl = SERVICE_ROOT + "&method=addnewnodetoview";
		reqUrl += "&viewid="+ encodeURIComponent(NODE_ARGS['nodeid']);
		reqUrl += "&title="+ encodeURIComponent(title);
		reqUrl += "&rolename="+encodeURIComponent(nodetype);
		reqUrl += "&private=N"; // get default from Map privacy setting.
		reqUrl += "&xpos="+posx;
		reqUrl += "&ypos="+posy;

		if (NODE_ARGS['groupid'] && NODE_ARGS['groupid'] != "") {
			reqUrl += "&groupid="+NODE_ARGS['groupid'];
		}

		//alert(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){

				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return false;
				}

				clearSelectedMapNodes(positionedMap);

				var viewnode = json.viewnode[0];
				var node = viewnode.node[0].cnode;
				if (node) {
					var mapnode = addNodeToMap(viewnode, positionedMap);
					if (mapnode) {
						mapnode.selected = true;
					}
				}

				updateEditListItem(true, node.nodeid);

				// UPDATE VISES IF THERE
				if (typeof setMapTabDataReload == 'function') {
					setMapTabDataReload();
				}

				positionedMap.refresh();
				return true;
			},
			onFailure: function(transport) {
				alert("FAILED TO ADD ITEM TO MAP!");
			}
		});
	}
	return false;
}

function addSelectedNodeToMapFloating(newnodeid, nodeid, position, type) {
	var posx = 0;
	var posy = 0;
	if(position && position != "") {
		var poses = position.split(':');
		posx = poses[0];
		posy = poses[1];
	}

	if (newnodeid != "") {
		var reqUrl = SERVICE_ROOT + "&method=addnodetoview";
		reqUrl += "&viewid="+ encodeURIComponent(NODE_ARGS['nodeid']);
		reqUrl += "&nodeid="+ encodeURIComponent(newnodeid);
		reqUrl += "&xpos="+posx;
		reqUrl += "&ypos="+posy;

		if (NODE_ARGS['groupid'] && NODE_ARGS['groupid'] != "") {
			reqUrl += "&groupid="+NODE_ARGS['groupid'];
		}

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){

				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return false;
				}

				clearSelectedMapNodes(positionedMap);

				var viewnode = json.viewnode[0];
				var node = viewnode.node[0].cnode;
				if (node) {
					var mapnode = addNodeToMap(viewnode, positionedMap);
					if (mapnode) {
						mapnode.selected = true;
					}
				}

				updateEditListItem(true, newnodeid);

				// UPDATE VISES IF THERE
				if (typeof setMapTabDataReload == 'function') {
					setMapTabDataReload();
				}

				positionedMap.refresh();

				return true;
			},
			onFailure: function(transport) {
				alert("FAILED TO ADD ITEM TO MAP!");
			}
		});
	}
	return false;
}

function addSelectedNodeToMap(newnodeid, nodeid, position, type) {

	if (positionedMap && newnodeid != nodeid) {
		oldnode = positionedMap.graph.getNode(nodeid);
		if (oldnode) {
			oldpos = oldnode.pos.getc(true);
			//var otherNodes = new Array();
			var i=0;
            oldnode.eachAdjacency(function(adj) {
                //var nodeFrom = positionedMap.graph.getNode(adj.nodeFrom.id);
                //var nodeTo = positionedMap.graph.getNode(adj.nodeTo.id);

                //if(nodeFrom.id == nodeid) {
                //	otherNodes[i] = nodeTo;
                //}
                i++;
            });

			var newx=oldpos.x;
			var newy=oldpos.y+150+ (i*20);
			var width = oldnode.getData('width');
			var height = oldnode.getData('height');


			/*if (position == "left") {
				newx=oldpos.x-150-width;
				newy=oldpos.y;
			} else if (position == "right") {
				newx=oldpos.x+150+width;
				newy=oldpos.y;
			} else if (position == "up") {
				newx=oldpos.x;
				newy=oldpos.y-height-150;
			} else if (position == "down") {
				newx=oldpos.x;
				newy=oldpos.y+150;
			}*/

			//alert("new node position="+newx+":"+newy);

			var linktypename = "";

			var orirole = oldnode.getData('orirole')

			if (type == "Issue" && orirole.name == 'Challenge') {
				linktypename = '<?php echo $CFG->LINK_ISSUE_CHALLENGE; ?>';
			} else if (type == "Solution" &&  orirole.name == 'Issue') {
				linktypename = '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>';
			} else if (type == "Solution" &&  orirole.name == 'Solution') {
				linktypename = '<?php echo $CFG->LINK_SOLUTION_SOLUTION; ?>';
			} else if (type == "Issue" &&  orirole.name == 'Issue') {
				linktypename = '<?php echo $CFG->LINK_ISSUE_ISSUE; ?>';
			} else if (type == "Issue" &&  orirole.name == 'Solution') {
				linktypename = '<?php echo $CFG->LINK_ISSUE_SOLUTION; ?>';
			} else if (type == "Pro") {
				linktypename = '<?php echo $CFG->LINK_PRO_SOLUTION; ?>';
 			} else if (type == "Con") {
				linktypename = '<?php echo $CFG->LINK_CON_SOLUTION; ?>';
			} else if (type == "Map") {
				linktypename = '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>';
			} else if (type == "Idea") {
				linktypename = '<?php echo $CFG->LINK_COMMENT_NODE; ?>';
			}

			addExistingNodeToMap(NODE_ARGS['nodeid'], newnodeid, nodeid, linktypename, newx, newy);
		}
	}
}

function checkLinkNodes(fromNode, toNode) {
	var allowedConnection = false;

	if (fromNode && toNode && (fromNode.id != toNode.id)) {
		var oriroleFrom = fromNode.getData('orirole');
		var rolenameFrom = oriroleFrom.name;
		var oriroleTo = toNode.getData('orirole');
		var rolenameTo = oriroleTo.name;

		if ( (rolenameFrom == "Pro" || rolenameFrom == "Con" || rolenameFrom == "Argument") && rolenameTo == "Solution") {
			allowedConnection = true;
		} else if ((rolenameFrom == "Pro" || rolenameFrom == "Con" || rolenameFrom == "Argument")
				&& (rolenameTo == "Pro" || rolenameTo == "Con" || rolenameTo == "Argument")) {
			allowedConnection = true;
		} else if (rolenameFrom == "Solution" && rolenameTo == "Solution") {
			allowedConnection = true;
		} else if (rolenameFrom == "Issue" && rolenameTo == "Issue") {
			allowedConnection = true;
		} else if (rolenameFrom == "Issue" && rolenameTo == "Challenge") {
			allowedConnection = true;
		} else if (rolenameFrom == "Solution" && rolenameTo == "Issue") {
			allowedConnection = true;
		} else if (rolenameFrom == "Issue" && rolenameTo == "Solution") {
			allowedConnection = true;
		} else if (rolenameFrom == "Idea" && rolenameTo != "Map") {
			allowedConnection = true;
		} else if (rolenameFrom != "Map" && rolenameTo == "Map") {
			allowedConnection = true;
		} else if (rolenameFrom == "Map" && rolenameTo != "Map") {
			allowedConnection = true;
		}
	}

	return allowedConnection;
}

function linkNodes(fromNodeID, toNodeID, isCon) {
	if ( (fromNodeID && fromNodeID != "")
			&& (toNodeID && toNodeID !="")
				&& (toNodeID != fromNodeID)) {

		var nodeFrom = positionedMap.graph.getNode(fromNodeID);
		var nodeTo = positionedMap.graph.getNode(toNodeID);
		if (nodeFrom && nodeTo) {

			var allowedConnection = false;
			var newx = 0;
			var newy = 0;
			var linktypename = "";

			var oriroleFrom = nodeFrom.getData('orirole');
			var rolenameFrom = oriroleFrom.name;

			var oriroleTo = nodeTo.getData('orirole');
			var rolenameTo = oriroleTo.name;

			if ( (rolenameFrom == "Pro" || rolenameFrom == "Con" || rolenameFrom == "Argument")
						&& rolenameTo == "Solution") {
				allowedConnection = true;
				if (rolenameFrom == "Pro" || (rolenameFrom == "Argument" && !isCon)) {
					linktypename = '<?php echo $CFG->LINK_PRO_SOLUTION; ?>';
				} else if (rolenameFrom == "Con" || (rolenameFrom == "Argument" && isCon)) {
					linktypename = '<?php echo $CFG->LINK_CON_SOLUTION; ?>';
				}
			} else if ((rolenameFrom == "Pro" || rolenameFrom == "Con" || rolenameFrom == "Argument")
						&& (rolenameTo == "Pro" || rolenameTo == "Con" || rolenameTo == "Argument")) {
				allowedConnection = true;
				if (rolenameFrom == "Pro" || isCon == false) {
					linktypename = '<?php echo $CFG->LINK_PRO_SOLUTION; ?>';
				} else if (rolenameFrom == "Con" || isCon == true) {
					linktypename = '<?php echo $CFG->LINK_CON_SOLUTION; ?>';
				}
			} else if (rolenameFrom == "Solution" && rolenameTo == "Solution") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_SOLUTION_SOLUTION; ?>';
			} else if (rolenameFrom == "Issue" && rolenameTo == "Issue") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_ISSUE_ISSUE; ?>';
			} else if (rolenameFrom == "Issue" && rolenameTo == "Challenge") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_ISSUE_CHALLENGE; ?>';
			} else if (rolenameFrom == "Solution" && rolenameTo == "Issue") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>';
			} else if (rolenameFrom == "Issue" && rolenameTo == "Solution") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_ISSUE_SOLUTION; ?>';
			} else if (rolenameFrom == "Idea" && rolenameTo != "Map") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_IDEA_NODE; ?>';
			} else if (rolenameFrom == "Map" && rolenameTo != "Map") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>';
			} else if (rolenameFrom != "Map" && rolenameTo == "Map") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>';
				var tempNodeID = fromNodeID;
				fromNodeID = toNodeID;
				toNodeID = tempNodeID;
			}
			if (allowedConnection) {
				addExistingNodeToMap(NODE_ARGS['nodeid'], fromNodeID, toNodeID, linktypename, newx, newy);
			} else {
				positionedMap.refresh();
				var message = "<?php echo $LNG->MAP_CONNECTION_ERROR_SINGLE; ?>";
				alert(message);
			}
		}
	}
}

/**
 * Connect the selected nodes in the map to the given node, if connection allowed
 */
function connectSelectedNodesToMe(graphview, node) {

	var message = "";

    for(var i in graphview.graph.nodes) {
    	var selectedNode = graphview.graph.nodes[i];
		if (selectedNode.selected) {
			var orirole = node.getData('orirole');
			var rolename = orirole.name;

			var selectedrole = selectedNode.getData('orirole');
			var selectedrolename = selectedrole.name;

			var linktypename = "";
			var fromnodeid = selectedNode.id;
			var tonodeid = node.id;
			if (fromnodeid == tonodeid) {
				continue;
			}

			var allowedConnection = false;
			var newx = 0;
			var newy = 0;

			//alert(selectedrolename);
			//alert(rolename);

			if ( (selectedrolename == "Pro" || selectedrolename == "Con" || rolenameFrom == "Argument")
					&& rolename == "Solution") {
				allowedConnection = true;
				if (selectedrolename == "Pro") {
					linktypename = '<?php echo $CFG->LINK_PRO_SOLUTION; ?>';
				} else if (selectedrolename == "Con") {
					linktypename = '<?php echo $CFG->LINK_CON_SOLUTION; ?>';
				}
			} else if ((selectedrolename == "Pro" || selectedrolename == "Con" || rolenameFrom == "Argument")
						&& (rolename == "Pro" || rolename == "Con" || rolename == "Argument")) {
				allowedConnection = true;
				if (selectedrolename == "Pro") {
					linktypename = '<?php echo $CFG->LINK_PRO_SOLUTION; ?>';
				} else if (selectedrolename == "Con") {
					linktypename = '<?php echo $CFG->LINK_CON_SOLUTION; ?>';
				}
			} else if (rolename == "Solution" && selectedrolename == "Solution") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_SOLUTION_SOLUTION; ?>';
			} else if (rolename == "Issue" && selectedrolename == "Issue") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_ISSUE_ISSUE; ?>';
			} else if (selectedrolename == "Issue" && rolename == "Challenge") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_ISSUE_CHALLENGE; ?>';
			} else if (selectedrolename == "Solution" && rolename == "Issue") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>';
			} else if (selectedrolename == "Issue" && rolename == "Solution") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_ISSUE_SOLUTION; ?>';
			} else if (rolenameFrom == "Idea" && rolenameTo != "Map") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_IDEA_NODE; ?>';
			} else if (selectedrolename == "Map" && rolename != "Map") {
				allowedConnection = true;
				linktypename = '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>';
			}
			if (allowedConnection) {
				addExistingNodeToMap(NODE_ARGS['nodeid'], fromnodeid, tonodeid, linktypename, newx, newy);
			} else {
				message = "<?php echo $LNG->MAP_CONNECTION_ERROR; ?>";
			}
		}
	}

	if (message != "") {
		alert(message);
	}
}

/**
 * Refresh the map after an edit has been done.
 * Just the title needs refreshing.
 */
function mapedithandler(nodeid) {

	//window.location.reload(true);

    var mapnode = positionedMap.graph.getNode(nodeid);
    if (mapnode) {
		var orirole = mapnode.getData('orirole');
		var user = mapnode.getData('oriuser');
		var rolename = orirole.name;
		var userid = mapnode.getData('userid');

		if (USER && USER != "" && USER == user.userid) {
			//go and get node
			var reqUrl = SERVICE_ROOT + "&method=getviewnode";
			reqUrl += "&nodeid="+ encodeURIComponent(nodeid);
			reqUrl += "&viewid="+ encodeURIComponent(NODE_ARGS['nodeid']);
			reqUrl += "&userid="+ encodeURIComponent(userid);

			//alert(reqUrl);
			new Ajax.Request(reqUrl, { method:'post',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					if(json.error){
						//alert(json.error[0].message);
						return;
					}

					var viewnode = json.viewnode[0];
					var graph = positionedMap.graph;

					var node = graph.getNode(nodeid);
					var newnode = viewnode.node[0].cnode;

					var role = newnode.role[0].role;

					// Update the local map node data for the role change
					var nodeHEX = getHexForRole(role.name);

					var nodeImage = "";
					if (newnode.imagethumbnail != null && newnode.imagethumbnail != "") {
						nodeImage = URL_ROOT + newnode.imagethumbnail;
					} else if (role) {
						if (role.image != null && role.image != "") {
							nodeImage = URL_ROOT + role.image;
						}
					}

					node.name = newnode.name;

					node.setData('desc', newnode.description, 'end');
					node.setData('desc', newnode.description, 'start');
					node.setData('desc', newnode.description);

					node.setData('orinode', newnode, 'end');
					node.setData('orinode', newnode, 'start');
					node.setData('orinode', newnode);

					node.setData('orirole', role, 'end');
					node.setData('orirole', role, 'start');
					node.setData('orirole', role);

					node.setData('nodetype', rolename, 'end');
					node.setData('nodetype', rolename, 'start');
					node.setData('nodetype', rolename);

					node.setData('color', nodeHEX, 'end');
					node.setData('color', nodeHEX, 'start');
					node.setData('color', nodeHEX);

					node.setData('icon', nodeImage, 'end');
					node.setData('icon', nodeImage, 'start');
					node.setData('icon', nodeImage);

					// UPDATE VISES IF THERE
					if (typeof setMapTabDataReload == 'function') {
						setMapTabDataReload();
					}

					positionedMap.refresh();
				},
				onFailure: function(transport) {
					alert("FAILED");
				}
			});
		}
	}
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

function showMapMenu(graphview, type, node, evt) {

	var orirole = node.getData('orirole');
	var user = node.getData('oriuser');
	var rolename = orirole.name;
	var userid = node.getData('userid');

	var panel = $('maparrowdiv');

	panel.innerHTML = "";

	// To modify a map you need to be logged in and if the map is in a group, you need to be in the group
	if (USER && USER != "" && NODE_ARGS['caneditmap'] == 'true') { 		// && rolename != "Pro" && rolename != "Con") {

		if (NODE_ARGS) {
			NODE_ARGS['blockednodeids'] = getMapNodeString(positionedMap);
		}

		if (rolename == "Challenge") {
			var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ISSUE_TITLE_SECTION; ?>'} );
			var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_ISSUE_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Issue", 410, 730);
			});
			panel.insert(newnode);
		} else if (rolename == "Issue") {
			var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_SOLUTION_TITLE_SECTION; ?>'} );
			var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_SOLUTION_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Solution", 410, 730);
			});
			panel.insert(newnode);

			newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ISSUE_TITLE_SECTION; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_ISSUE_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Issue", 410, 730);
			});
			panel.insert(newnode);
		} else if (rolename == "Solution") {
			var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_PRO_TITLE_SECTION; ?>'} );
			var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_PRO_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Pro", 410, 730);
			});
			panel.insert(newnode);

			newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_CON_TITLE_SECTION; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_CON_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Con", 410, 730);
			});
			panel.insert(newnode);

			newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_CON_TITLE_SECTION; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/argument.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_ARGUMENT_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Con", 410, 730);
			});

			newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_SOLUTION_TITLE_SECTION; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_SOLUTION_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Solution", 410, 730);
			});
			panel.insert(newnode);

			newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ISSUE_TITLE_SECTION; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_ISSUE_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Issue", 410, 730);
			});
			panel.insert(newnode);
		} else if (rolename == "Pro" || rolename == "Con" || rolename == "Argument") {
			var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_PRO_TITLE_SECTION; ?>'} );
			var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_PRO_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Pro", 410, 730);
			});
			panel.insert(newnode);

			newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ARGUMENT_TITLE_SECTION; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_CON_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Argument", 410, 730);
			});
			panel.insert(newnode);
		}

		if (rolename != "Map"){
			var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_MAP_TITLE_ADD_HINT; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/idea.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_COMMENT_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Idea&excludenodeid="+NODE_ARGS['nodeid'], 410, 730);
			});
			panel.insert(newnode);

			var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_MAP_TITLE_ADD_HINT; ?>'} );
			nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/map.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
			newnode.insert(nodeicon);
			newnode.insert("<?php echo $LNG->FORM_MAP_TITLE_ADD; ?>");
			Event.observe(newnode,'click',function (){
				hideBox('maparrowdiv');
				loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMap&position="+type+"&nodeid="+node.id+"&filternodetypes=Map&excludenodeid="+NODE_ARGS['nodeid'], 410, 730);
			});
			panel.insert(newnode);
		}

		panel.insert(createMenuSpacerSoftCompact());

		var connecttoselected = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->MAP_CONNECT_TO_SELECTED_HINT; ?>'} );
		connecttoselected.insert("<?php echo $LNG->MAP_CONNECT_TO_SELECTED_LABEL; ?>");
		Event.observe(connecttoselected,'click',function (){
			hideBox('maparrowdiv');
			connectSelectedNodesToMe(graphview, node);
		});
		panel.insert(connecttoselected);

	}

	adjustMenuPosition(panel, evt);
	showBox('maparrowdiv');
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

						if (nextnode.cnode.nodeid === NODE_ARGS['nodeid']) {
							var next = new Element("span", {'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
							next.insert(nextnode.cnode.name);
							innerpanel.insert(next);
						} else {
							var next = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
							next.insert(nextnode.cnode.name);
							next.nodeid = nextnode.cnode.nodeid;
							Event.observe(next,'click',function (){
								hideBox('maparrowdiv');
								// link to map
								viewMapDetails(this.nodeid);
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

function showCanvasMenu(evt, graphview, pos) {
	var panel = $('maparrowdiv');
	panel.innerHTML = "";

	// To modify a map you need to be logged in and if the map is in a group, you need to be in the group
	if (USER && USER != "" && NODE_ARGS['caneditmap'] == 'true') {

		if (NODE_ARGS) {
			NODE_ARGS['blockednodeids'] = getMapNodeString(positionedMap);
		}

		panel.insert('<div style="float:left;margin-bottom:5px;font-size:10pt"><?php echo $LNG->FORM_ADD_QUICK; ?></div>');

		var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ISSUE_TITLE_SECTION_QUICK; ?>'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue.png'); ?>','style':'padding-right:5px;width:28px;height:28px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			var pos = getMousePosition(graphview, evt);
			addBlankNodeToMapFloating('Issue', pos.x+':'+pos.y);
		});
		panel.insert(newnode);

		var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_SOLUTION_TITLE_SECTION_QUICK; ?>'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution.png'); ?>','style':'padding-right:5px;width:28px;height:28px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			var pos = getMousePosition(graphview, evt);
			addBlankNodeToMapFloating('Solution', pos.x+':'+pos.y);
		});
		panel.insert(newnode);

		var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_PRO_TITLE_SECTION_QUICK; ?>'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-32x32.png'); ?>','style':'padding-right:5px;width:28px;height:28px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			var pos = getMousePosition(graphview, evt);
			addBlankNodeToMapFloating('Pro', pos.x+':'+pos.y);
		});
		panel.insert(newnode);

		newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_CON_TITLE_SECTION_QUICK; ?>'} );
		nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-32x32.png'); ?>','style':'padding-right:5px;width:28px;height:28px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			var pos = getMousePosition(graphview, evt);
			addBlankNodeToMapFloating('Con', pos.x+':'+pos.y);
		});
		panel.insert(newnode);

		newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ARGUMENT_TITLE_SECTION_QUICK; ?>'} );
		nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/argument.png'); ?>','style':'padding-right:5px;width:28px;height:28px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			var pos = getMousePosition(graphview, evt);
			addBlankNodeToMapFloating('Argument', pos.x+':'+pos.y);
		});
		panel.insert(newnode);

		newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_COMMENT_TITLE_SECTION_QUICK; ?>'} );
		nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/idea.png'); ?>','style':'padding-right:5px;width:28px;height:28px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			var pos = getMousePosition(graphview, evt);
			addBlankNodeToMapFloating('Idea', pos.x+':'+pos.y);
		});
		panel.insert(newnode);

		panel.insert(createMenuSpacerSoft());

		var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ISSUE_TITLE_SECTION; ?>'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->FORM_ISSUE_TITLE_ADD; ?>");
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMapFloating&position="+pos.x+":"+pos.y+"&filternodetypes=Issue", 410, 730);
		});
		panel.insert(newnode);

		var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_SOLUTION_TITLE_SECTION; ?>'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->FORM_SOLUTION_TITLE_ADD; ?>");
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMapFloating&position="+pos.x+":"+pos.y+"&filternodetypes=Solution", 410, 730);
		});
		panel.insert(newnode);

		var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_PRO_TITLE_SECTION; ?>'} );
		var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->FORM_PRO_TITLE_ADD; ?>");
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMapFloating&position="+pos.x+":"+pos.y+"&filternodetypes=Pro", 410, 730);
		});
		panel.insert(newnode);

		newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_CON_TITLE_SECTION; ?>'} );
		nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->FORM_CON_TITLE_ADD; ?>");
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMapFloating&position="+pos.x+":"+pos.y+"&filternodetypes=Con", 410, 730);
		});
		panel.insert(newnode);

		newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_ARGUMENT_TITLE_SECTION; ?>'} );
		nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/argument.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->FORM_ARGUMENT_TITLE_ADD; ?>");
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMapFloating&position="+pos.x+":"+pos.y+"&filternodetypes=Argument", 410, 730);
		});
		panel.insert(newnode);

		newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_COMMENT_TITLE_SECTION; ?>'} );
		nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/idea.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->FORM_COMMENT_TITLE_ADD; ?>");
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMapFloating&position="+pos.x+":"+pos.y+"&filternodetypes=Idea", 410, 730);
		});
		panel.insert(newnode);

		var newnode = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->FORM_MAP_TITLE_ADD_HINT; ?>'} );
		nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/map.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
		newnode.insert(nodeicon);
		newnode.insert("<?php echo $LNG->FORM_MAP_TITLE_ADD; ?>");
		Event.observe(newnode,'click',function (){
			hideBox('maparrowdiv');
			loadDialog('nodeadder', URL_ROOT+"ui/popups/nodeadder.php?handler=addSelectedNodeToMapFloating&position="+pos.x+":"+pos.y+"&filternodetypes=Map&excludenodeid="+NODE_ARGS['nodeid'], 410, 730);
		});
		panel.insert(newnode);

		panel.insert(createMenuSpacerSoft());
	}

	/*var selectall = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->MAP_SELECT_ALL_HINT; ?>'} );
	selectall.insert("<?php echo $LNG->MAP_SELECT_ALL_LABEL; ?>");
	Event.observe(selectall,'click',function (){
		hideBox('maparrowdiv');
		// select all nodes.
		selectAllMapNodes(graphview);
	});
	panel.insert(selectall);
	*/

	positionPopup(evt, 'maparrowdiv', 1, 1);
	panel.style.display = 'block';

	return;
}

function showLinkMenu(link, evt, graphview) {

	var user = link.getData('oriuser');

	var panel = $('maparrowdiv');
	panel.innerHTML = "";

	var viewuser = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NETWORKMAPS_EXPLORE_AUTHOR_CONNECTION_HINT; ?>: '+user.name} );
	viewuser.insert("<?php echo $LNG->NETWORKMAPS_EXPLORE_AUTHOR_LINK; ?>");
	Event.observe(viewuser,'click',function (){
		hideBox('maparrowdiv');
		var userid = user.userid;
		viewUserHome(userid);
	});
	panel.insert(viewuser);

	if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true'){
		var deletelink = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
		deletelink.insert("<?php echo $LNG->MAP_LINK_DELETE; ?>");
		Event.observe(deletelink,'click',function (){
			hideBox('maparrowdiv');
			deleteConnectionFromMap(link);
			//deleteNodeConnection(connid, orifrom.name, orito.name, handlePostDelete);
		});
		panel.insert(deletelink);
	}

	positionPopup(evt, 'maparrowdiv', 1, 1);
	panel.style.display = 'block';

	return;
}

 function showRoleMenu(node, evt, graphview) {

	var orinode = node.getData('orinode');
	var orirole = node.getData('orirole');
	var nodetypelabel = orirole.name;

	var panel = $('maparrowdiv');
	panel.innerHTML = "";

	// ISSUE
	var checkdiv = new Element("div", {'class':'active','style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
	var checklink = new Element("input", {'type':'radio', 'name':'changetype', 'id':'changetypeissue', 'style':'vertical-align:bottom'} );
	checkdiv.insert(checklink);
	var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/issue.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
	checkdiv.insert(nodeicon);
	panel.insert(checkdiv);
	var checklabel = new Element("span", {'style':'font-size:10pt'} );
	checklabel.insert('<?php echo $LNG->ISSUE_NAME;?>');
	checkdiv.insert(checklabel);
	if (nodetypelabel == 'Issue') {
		checklink.checked = true;
	}
	Event.observe(checklink,'mouseover',function () {
		showBox('maparrowdiv');
	});
	Event.observe(checklink,'click',function () {
		hideBox('maparrowdiv');
		changeNodeType(node, 'Issue', graphview);
	});

	// IDEA/COMMENT
	var checkdiv = new Element("div", {'class':'active','style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
	var checklink = new Element("input", {'type':'radio', 'name':'changetype', 'id':'changetypesolution', 'style':'vertical-align:bottom'} );
	checkdiv.insert(checklink);
	var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/solution.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
	checkdiv.insert(nodeicon);
	panel.insert(checkdiv);
	var checklabel = new Element("span", {'style':'font-size:10pt'} );
	checklabel.insert('<?php echo $LNG->SOLUTION_NAME;?>');
	checkdiv.insert(checklabel);
	if (nodetypelabel == 'Solution') {
		checklink.checked = true;
	}
	Event.observe(checklink,'mouseover',function () {
		showBox('maparrowdiv');
	});
	Event.observe(checklink,'click',function () {
		hideBox('maparrowdiv');
		changeNodeType(node, 'Solution', graphview);
	});


	// PRO
	var checkdiv = new Element("div", {'class':'active','style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
	var checklink = new Element("input", {'type':'radio', 'name':'changetype', 'id':'changetypepro', 'style':'vertical-align:bottom'} );
	checkdiv.insert(checklink);
	var nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/plus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
	checkdiv.insert(nodeicon);
	panel.insert(checkdiv);
	var checklabel = new Element("span", {'style':'font-size:10pt'} );
	checklabel.insert('<?php echo $LNG->PRO_NAME;?>');
	checkdiv.insert(checklabel);
	if (nodetypelabel == 'Pro') {
		checklink.checked = true;
	}
	Event.observe(checklink,'mouseover',function () {
		showBox('maparrowdiv');
	});
	Event.observe(checklink,'click',function () {
		hideBox('maparrowdiv');
		changeNodeType(node, 'Pro', graphview);
	});


	// CON
	var checkdiv = new Element("div", {'class':'active','style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
	var checklink = new Element("input", {'type':'radio', 'name':'changetype', 'id':'changetypecon', 'style':'vertical-align:bottom'} );
	checkdiv.insert(checklink);
	nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/minus-32x32.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
	checkdiv.insert(nodeicon);
	var checklabel = new Element("span", {'style':'font-size:10pt'} );
	checklabel.insert('<?php echo $LNG->CON_NAME;?>');
	checkdiv.insert(checklabel);
	if (nodetypelabel == 'Con') {
		checklink.checked = true;
	}
	Event.observe(checklink,'mouseover',function () {
		showBox('maparrowdiv');
	});
	Event.observe(checklink,'click',function () {
		hideBox('maparrowdiv');
		changeNodeType(node, 'Con', graphview);
	});
	panel.insert(checkdiv);

	// ARGUMENT
	var checkdiv = new Element("div", {'class':'active','style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
	var checklink = new Element("input", {'type':'radio', 'name':'changetype', 'id':'changetypeargument', 'style':'vertical-align:bottom'} );
	checkdiv.insert(checklink);
	nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/argument.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
	checkdiv.insert(nodeicon);
	var checklabel = new Element("span", {'style':'font-size:10pt'} );
	checklabel.insert('<?php echo $LNG->ARGUMENT_NAME;?>');
	checkdiv.insert(checklabel);
	if (nodetypelabel == 'Argument') {
		checklink.checked = true;
	}
	Event.observe(checklink,'mouseover',function () {
		showBox('maparrowdiv');
	});
	Event.observe(checklink,'click',function () {
		hideBox('maparrowdiv');
		changeNodeType(node, 'Argument', graphview);
	});
	panel.insert(checkdiv);

	// IDEA/COMMENT (Open Comment)
	var checkdiv = new Element("div", {'class':'active','style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
	var checklink = new Element("input", {'type':'radio', 'name':'changetype', 'id':'changetypeidea', 'style':'vertical-align:bottom'} );
	checkdiv.insert(checklink);
	nodeicon = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath('nodetypes/Default/idea.png'); ?>','style':'padding-right:5px;width:16px;height:16px;vertical-align:bottom'} );
	checkdiv.insert(nodeicon);
	var checklabel = new Element("span", {'style':'font-size:10pt'} );
	checklabel.insert('<?php echo $LNG->COMMENT_NAME;?>');
	checkdiv.insert(checklabel);
	if (nodetypelabel == 'Idea') {
		checklink.checked = true;
	}
	Event.observe(checklink,'mouseover',function () {
		showBox('maparrowdiv');
	});
	Event.observe(checklink,'click',function () {
		hideBox('maparrowdiv');
		changeNodeType(node, 'Idea', graphview);
	});
	panel.insert(checkdiv);

	adjustMenuPosition(panel, evt);
	showBox('maparrowdiv');
}

function processVoteClick(node, vote, evt, graphview) {

	var i=0;
	var connection = "";
	node.eachAdjacency(function(adj) {
		var conn = adj.getData('oriconn');
		var fN = conn.from[0].cnode;
		var tN = conn.to[0].cnode;
		if(tN.role[0].role.name != 'Map') {
			if (fN.nodeid == node.id) {
				connection = conn;
				i++;
			}
		}
	});

	if (i == 1) {
		if (vote == 'Y') {
			if(USER != ""){
				if (connection.uservote && connection.uservote == 'Y') {
					mapDeleteConnectionVote(node, connection, vote, graphview);
				} else if (!connection.uservote || connection.uservote != 'Y') {
					mapConnectionVote(node, connection, vote, graphview);
				}
			}
		} else if (vote == 'N') {
			if(USER != ""){
				if (connection.uservote && connection.uservote == 'N') {
					mapDeleteConnectionVote(node, connection, vote, graphview);
				} else if (!connection.uservote || connection.uservote != 'N') {
					mapConnectionVote(node, connection, vote, graphview);
				}
			}
		}
	} else {
		var panel = $('mapvotediv');
		panel.innerHTML = "";

		if (vote == 'Y') {
			panel.insert('<div style="float:left;font-size:10pt;font-weight:bold"><img style="vertical-align:top;padding-right:5px;" src="<?php echo $HUB_FLM->getImagePath('thumb-up-filled.png'); ?>" border="0" /><?php echo $LNG->NODE_VOTE_FOR_TITLE; ?></div>');
		} else if (vote == 'N') {
			panel.insert('<div style="float:left;font-size:10pt;font-weight:bold"><img style="vertical-align:top;padding-right:5px;" src="<?php echo $HUB_FLM->getImagePath('thumb-down-filled.png'); ?>" border="0" /><?php echo $LNG->NODE_VOTE_AGAINST_TITLE; ?></div>');
		}

		node.eachAdjacency(function(adj) {
			var connection = adj.getData('oriconn');

			var fN = connection.from[0].cnode;
			var tN = connection.to[0].cnode;

			var nodeFrom = graphview.graph.getNode(fN.nodeid);
			var nodeTo = graphview.graph.getNode(tN.nodeid);
			var orirole = nodeTo.getData('orirole');

			if(orirole.name != 'Map') {
				if (nodeFrom.id == node.id) {
					var checkdiv = new Element("div", {'class':'active','style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt'} );
					var checklink = new Element("input", {'type':'checkbox'} );
					checkdiv.insert(checklink);
					panel.insert(checkdiv);
					var checklabel = new Element("span", {'style':'font-size:10pt'} );
					checklabel.insert(tN.name);
					checkdiv.insert(checklabel);
					if (vote == 'Y') { // Clicked vote for
						if (connection.uservote && connection.uservote == 'Y') {
							checklink.checked = true;
							Event.observe(checklink,'click',function () {
								mapDeleteConnectionVote(node, connection, vote, graphview);
							});
						} else if (!connection.uservote || connection.uservote != 'Y') {
							checklink.checked = false;
							Event.observe(checklink,'click',function () {
								mapConnectionVote(node, connection, vote, graphview);
							});
						}
					} else if (vote == 'N') { // clicked vote against
						if (connection.uservote && connection.uservote == 'N') {
							checklink.checked = true;
							Event.observe(checklink,'click',function () {
								mapDeleteConnectionVote(node, connection, vote, graphview);
							});
						} else if (!connection.uservote || connection.uservote != 'N') {
							checklink.checked = false;
							Event.observe(checklink,'click',function () {
								mapConnectionVote(node, connection, vote, graphview);
							});
						}
					}
				}
			}
		});

		//var closebutton = new Element("button", {'style':'margin-top:15px;clear:both;float:left;font-size:8pt'} );
		//closebutton.insert('<?php echo $LNG->FORM_BUTTON_CLOSE; ?>');
		//Event.observe(closebutton,'click',function () {
		//	hideBox('mapvotediv');
		//	hideBox('mapvotediv');
		//});
		//panel.insert(closebutton);

		adjustMenuPosition(panel, evt);
		showBox('mapvotediv');
	}
}


function adjustMenuPosition(panel, event) {

	var page = $jit.util.event.getPos(event, window);
	panel.style.left = page.x+"px";
	panel.style.top = page.y+"px";
}

/**
 * Add the given connection to the given graph
 * @return true if the connection was added else false;
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
				"$oriconn": c,
				"$oriuser": user,
			};

			var adj = graph.addAdjacence(fromNode, toNode, data);
			return adj;
		}
	}

	return false;
}

/**
 * Add the given node to the given graph
 */
function addNodeToMap(viewnode, positionedMap) {

	var graph = positionedMap.graph;
	if (viewnode.node) {
		var node = viewnode.node[0].cnode;
		if (node) {
			if (!checkNodes[node.nodeid]) {
				var thisnode = createMapNode(viewnode, node);
				var next = graph.addNode(thisnode);
				next.pos.setc(parseInt(viewnode.xpos), parseInt(viewnode.ypos));
				checkNodes[node.nodeid] = node.nodeid;

				//alert("positionedMap.root:"+positionedMap.root);
				if (!positionedMap.root || positionedMap.root == "") {
					FD_MOST_CONNECTED_NODE = node.nodeid;
					positionedMap.root = node.nodeid;
				}

				return next;
			}
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
			"$voreforrec":new mapRectangle(0,0,0,0),
			"$voteagainstrec":new mapRectangle(0,0,0,0),
			"$editrec":new mapRectangle(0,0,0,0),
			"$deleterec":new mapRectangle(0,0,0,0),
			"$linkrec":new mapRectangle(0,0,0,0),
			"$urlrec":new mapRectangle(0,0,0,0),
			"$networkrec":new mapRectangle(0,0,0,0),
			"$rolechangerec":new mapRectangle(0,0,0,0),
		},
		"id": node.nodeid,
		"name": name,
	};

	return thisnode;
}

function getHexForRole(rolename) {

	var nodeHEX = "";

	if (rolename == 'Challenge') {
		nodeHEX = challengebackpale;
	} else if (rolename == 'Issue') {
		nodeHEX = issuebackpale;
	} else if (rolename == 'Solution') {
		nodeHEX = solutionbackpale;
	} else if (rolename == "Pro") {
		nodeHEX = probackpale;
	} else if (rolename == "Con") {
		nodeHEX = conbackpale;
	} else if (rolename == 'Argument') {
		nodeHEX = argumentbackpale;
	} else if (rolename == 'Idea') {
		nodeHEX = ideabackpale;
	} else {
		nodeHEX = plainbackpale;
	}

	return nodeHEX;
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

	//console.log(width+":"+height);
	//console.log(size.width+":"+size.height);
	if (size.width > width || size.height > height) {
		//console.log("zooming");
		zoomFDFit(graphview);
	} else {
		var rectangle = getBoundaries(graphview);
		moveToVisibleArea(graphview, rectangle);
		//var rootNodeID = graphview.root;
		//panToNodeFD(graphview, rootNodeID);
	}

	if (messagearea) {
		messagearea.innerHTML="";
		messagearea.style.display = "none";
	}

	graphview.canvas.getPos(true);
}


/**
 * Return a string of all nodeid in the map.
 */
function getMapNodeString(graphview) {
	var ids = "";
    for(var i in graphview.graph.nodes) {
    	var n = graphview.graph.nodes[i];
		ids += n.id+",";
    }
    return ids;
}


function selectNodeTree(checkNodes, graphview, topnode) {
	var node = graphview.graph.getNode(topnode);
	node.selected = true;
	var edges = node.adjacencies;
	checkNodes.push(topnode);
	for (var key in edges) {
		if (checkNodes.indexOf(key) == -1) {
			if (edges.hasOwnProperty(key)) {
				var toNode = graphview.graph.getNode(key);
				toNode.selected = true;
				checkNodes.push(key);
				checkNodes = selectNodeTree(checkNodes, graphview, key)
			}
		} else {
			break;
		}
	}

	return checkNodes;
}

function clearSelectedMapNodes(graphview) {
    for(var i in graphview.graph.nodes) {
    	var n = graphview.graph.nodes[i];
		delete n.selected;
    }
}

function selectAllMapNodes(graphview) {
    for(var i in graphview.graph.nodes) {
    	var node = graphview.graph.nodes[i];
	   	node.selected = true;
    }

    graphview.refresh();
}

function setSelectedMapNode(graphview, nodeid) {
	var node = graphview.graph.getNode(nodeid);
	if (node) {
		node.selected = true;
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
 * Return the currently selected nodes.
 */
function getSelectMapNodes(graphview) {
	var selectedNodes = new Array();

    for(var i in graphview.graph.nodes) {
    	var n = graphview.graph.nodes[i];
		if(n.selected) {
			selectedNodes.push(n);
        }
    }

	return selectedNodes;
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

/**
 * Check to see if the delete key was pressed and handle.
 */
function mapKeyPressed(evt) {
 	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var characterCode = document.all? window.event.keyCode:event.which;

	if(USER && USER != "" && NODE_ARGS['caneditmap'] == 'true' && characterCode == 46) { //deletekey
		var node = getSelectMapNode(positionedMap);
		if (!node) {
			var link = getSelectLink(positionedMap);
			var orifrom = link.nodeFrom;
			var orito = link.nodeTo;
			var connid = link.getData('connid');
			var handlePostDelete = function() {
				positionedMap.removeAdjacence(orifrom.id, orito.id);
				//check if there is a node with node edges (but not just the central node, then delete it.
			};

			deleteNodeConnection(connid, orifrom.name, orito.name, handlePostDelete);
		} else {
			var orirole = node.getData('orirole');
			var rolename = orirole.name;
			if (rolename != "Challenge") {
				deleteNodeFromMap(node);
			}
		}
	}
}