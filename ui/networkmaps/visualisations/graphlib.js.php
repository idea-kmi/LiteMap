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
var FD_MOST_CONNECTED_NODE = "";
var FD_MOST_CONNECTED_COUNT = 0;

var checkNodes = new Array();

var labelType, useGradients, nativeTextSupport, animate;

// TAKEN FROM EXAMPLES IN THE jit-2.0.2 CODE BASE.
(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

/**
 * Returns the intersecting point of the line with the given from and
 * to point with the given node rectangle. To get the other intersecting point
 * the from and to points need to be reversed.
 *
 * @param node the node whose Rectangle to check.
 * @param from the origin point of the line to check.
 * @param to the destination point of the line to check.
 * @return Point the point the rectangle and line intersect, else null it they don't.
 */
function computeIntersectionWithRectangle(node, from, to) {

	//alert("to="+to.x);
	//alert("from="+from.x);

	var widthr = node.getData('width');
	var heightr = node.getData('height');

	var cpos = node.pos.getc(true);
	var r = { x: cpos.x - widthr / 2, y: cpos.y - heightr / 2, width: node.getData('width'), height: node.getData('height')};

	var pt = { x: 0, y: 0};

	if ((from.x == to.x)&& (from.y == to.y)) return null;

	//line to the right of rectangle
	if ((from.x>r.x+r.width) && (to.x>r.x+r.width)) return null;

	//line below rectangle
	if ((from.y>r.y+r.height) && (to.y>r.y+r.height)) return null;

	//line to left of rectangle
	if ((from.x<r.x) && (to.x<r.x)) return null;

	//line above rectangle
	if ((from.y<r.y) && (to.y<r.y)) return null;

	if (to.y != from.y) {
		if (r.y+r.height<=to.y) {
			pt.y=r.y+r.height;
			pt.x=from.x+(to.x-from.x)*(r.y+r.height-from.y)/(to.y-from.y);
		} else {
			pt.y=r.y;
			pt.x=from.x+(to.x-from.x)*(r.y-from.y)/(to.y-from.y);
		}
	}

	if (to.y==from.y || r.x>pt.x || pt.x>=r.x+r.width) {
		if (r.x+r.width<=to.x) {
			pt.y=from.y+(to.y-from.y)*(r.x+r.width-from.x)/(to.x-from.x);
			pt.x=r.x+r.width;
		}
		else {
			pt.y=from.y+(to.y-from.y)*(r.x-from.x)/(to.x-from.x);
			pt.x=r.x;
		}
	}

	return pt;
}

/**
 * Returns the side of the rectagle the line will be on
 *
 * @param node the node whose Rectangle to check.
 * @param from the origin point of the line to check.
 * @param to the destination point of the line to check.
 * @param pt the intersection point.
 * @return Point the point the rectangle and line intersect, else null it they don not.
 */
function computeSideOfRectangle(node, from, to, pt) {

	var edge = "";
	var widthr = node.getData('width');
	var heightr = node.getData('height');

	var cpos = node.pos.getc(true);
	var r = { x: cpos.x - widthr / 2, y: cpos.y - heightr / 2, width: node.getData('width'), height: node.getData('height')};

	// need to set to fixed decimals otherwise they differ very slightly
	// at the bottom end and then don not match an edge
	var bottomY = parseFloat(cpos.y + (heightr / 2)).toFixed(12);
	var topY = parseFloat(cpos.y - (heightr / 2)).toFixed(12);
	var leftX = parseFloat(cpos.x - (widthr/2)).toFixed(12);
	var rightX = parseFloat(cpos.x + (widthr/2)).toFixed(12);

	var x = parseFloat(pt.x).toFixed(12);
	var y = parseFloat(pt.y).toFixed(12);

	if (y == bottomY) {
		edge = "bottom";
	} else if (y == topY) {
		edge = "top";
	} else if (x == leftX) {
		edge = "left";
	} else if (x == rightX) {
		edge = "right";
	}

	/*
	if (edge =="") {
		console.log("bottomY :"+bottomY);
		console.log("topY: "+topY);
		console.log("leftX: "+leftX);
		console.log("rightX: "+rightX);

		console.log("pt.x: "+pt.x);
		console.log("pt.y: "+pt.y);
	}
	*/
	//console.log("edge: "+edge);

	return edge;
}

/*
function reduceLine(from, to, lineWidth) {

	var width = 0;
	if (to.x>from.x) {
		width = to.x-from.x;
	} else {
		width = from.x-to.x;
	}

	var height = 0;
	if (to.y>from.y) {
		height = to.y-from.y;
	} else {
		height = from.y-to.y;
	}

	//double lineLength = Math.sqrt((width*width)+(height*height));
	var positionAddition = lineWidth*2;
	//if (lineLength <= 20) {
	//	positionAddition = 2;
	//}

	var angleRads = Math.atan(height/width);
	var newHeight = Math.sin(angleRads)*positionAddition;
	var newWidth = Math.cos(angleRads)*positionAddition;

	p1 = {"x":0, "y":0};

	if (from.x < to.getX()) {
		if (from.getY() > to.getY()) {
			p1 = {"x":to.x-newWidth), "y":(to.y+newHeight)}; //Top-right quarter
		} else {
			p1 = {"x":(to.x-newWidth), "y":(to.y-newHeight)};   // Bottom-right quarter
		}
	} else {
		if (from.getY() > to.getY()) {
			p1 = {"x":(to.x+newWidth), "y":(to.y+newHeight)}; //Top-Left quarter
		} else {
			p1 = {"x":(to.x+newWidth), "y":(to.y-newHeight)}; // Bottom-Left quarter
		}
	}

	return p1;
}
*/


function drawArrow(context, a, b, width, orientation) {

	var unitx;
	var unity;

	var xpts = new Array(3);
	var ypts = new Array(3);

	xpts[0]=b.x;
	ypts[0]=b.y;

	if (orientation == "HORIZONTAL") {
		if ((b.x-a.x) > 0) {
			unitx = width;
		} else {
			unitx = -width;
		}

		unity = (width/2);

		xpts[1]=b.x-unitx;
		ypts[1]=b.y-unity;
		xpts[2]=b.x-unitx;
		ypts[2]=b.y+unity;

	} else if (orientation == "VERTICAL") {
		unitx = (width/2);

		if ((b.y-a.y) > 0)
			unity = width;
		else
			unity = -width;

		xpts[1]=b.x-unitx;
		ypts[1]=b.y-unity;
		xpts[2]=b.x+unitx;
		ypts[2]=b.y-unity;

	} else {
		var hypo = Math.sqrt((a.x-b.x)*(a.x-b.x)+(a.y-b.y)*(a.y-b.y));
		unitx = (width*(b.x-a.x)/hypo);
		unity = (width*(b.y-a.y)/hypo);

		xpts[1]=b.x-(unitx-unity/2);
		ypts[1]=b.y-(unity+unitx/2);
		xpts[2]=b.x-(unitx-unity/2+unity);
		ypts[2]=b.y-(unity+unitx/2-unitx);
	}

	//console.log(xpts);
	//console.log(ypts);

	context.beginPath();
	context.moveTo(xpts[0], ypts[0]);
	context.lineTo(xpts[1], ypts[1]);
	context.lineTo(xpts[2], ypts[2]);
	context.closePath();
	context.fill();
}

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

/**
 * For breaking long words
 */
function findSmallestString(word, maxWidth, context) {

	var n=0;
	var bits = "";
	for(n=0; n < word.length; n++) {
		bits = bits+word[n];
		var metrics = context.measureText(bits);
		var testWidth = metrics.width;
		if (testWidth > maxWidth) {
			n = n-1;
			break;
		}
	}

	return n;
}

/**
 * Wrap the given text over as many lines as required.
 */
function wrapText(context, text, x, y, maxWidth, lineHeight) {
	var words = text.split(' ');
	var line = '';
	var word = "";
	for(var n = 0; n < words.length; n++) {
	  word = words[n];

	  // breakword if required
	  var metrics = context.measureText(word);
	  var testWidth = metrics.width;
	  if (testWidth > maxWidth) {
	  	 var len = findSmallestString(word, maxWidth, context);
	     line = word.substring(0, len-1);
	  	 words[n] = word.substring(len)
	  	 n--;
	  	 context.fillText(line, x, y);
  		 line = "";
		 y += lineHeight;
	  } else {
		  var testLine = line + word + ' ';
		  var metrics = context.measureText(testLine);
		  var testWidth = metrics.width;
		  if (testWidth > maxWidth && n > 0) {
			context.fillText(line, x, y);
			line = words[n] + ' ';
			y += lineHeight;
		  }
		  else {
			line = testLine;
		  }
	  }
	}
	context.fillText(line, x, y);
}

/**
 * Return the currently selected node.
 */
function getSelectFDNode(graphview) {
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

function clipInitialCanvasInner(graphview, width, height) {

	var bounds = getBoundaries(graphview);
	var boundswidth = Math.round(bounds.width);
	var boundsheight = Math.round(bounds.height);
	//alert("bounds BEFORE2="+boundswidth+":"+boundsheight);

	// If the map bounds are smaller than the visible area, make it as big as the visible area
	var finalwidth = boundswidth;

	if (boundswidth < width) {
		boundswidth = width;
	}
	var finalheight = boundsheight;
	if (boundsheight < height) {
		boundsheight = height;
	}

	// if the canvas bounds are larger than the map bounds
	// resize to map bounds
	//var size = graphview.canvas.getSize();

	//if (boundswidth < size.width || boundsheight < size.height) {
		$(graphview.config.injectInto).style.width = boundswidth+"px";
		$(graphview.config.injectInto).style.height = boundsheight+"px";
		//graphview.canvas.resize(boundswidth, boundsheight);
	//} else{
	//	$(graphview.config.injectInto).style.width = boundswidth+"px";
	//	$(graphview.config.injectInto).style.height = boundsheight+"px";
		//graphview.canvas.resize(boundswidth, boundsheight);
	//}
}

/**
 * The inital canvas is huge.
 * If after drawing the map, the bounds of the map are smaller than the canvas space, but still bigger than the visible area.
 * Make the canvas the size of the map bounds
 */
function clipInitialCanvas(graphview, width, height) {
	if (graphview.config.background) {
		var backgroundimage = graphview.config.background.backgroundimage;
		if (backgroundimage.complete) {
			clipInitialCanvasInner(graphview, width, height);
		} else {
			backgroundimage.onload = function() {
				clipInitialCanvasInner(graphview, width, height);
			}
		}
	} else {
		clipInitialCanvasInner(graphview, width, height);
	}
}

/**
 * Make sure if the visible div is resized that the canvas is never smaller than the visible space.
 */
function resizeFDGraphCanvas(graphview, width, height) {
	var size = graphview.canvas.getSize();

	var resizeWidth = size.width;
	if (size.width < width) {
		resizeWidth = width;
	}
	var resizeHeight = size.height;
	if (size.height < height) {
		resizeHeight = height;
	}

	if (size.width < width || size.height < height) {
		$(graphview.config.injectInto).style.width = resizeWidth+"px";
		$(graphview.config.injectInto).style.height = resizeHeight+"px";
		graphview.canvas.resize(resizeWidth, resizeHeight);
	}
}

/**
 * Pan the view to the given node only in 1:1
 */
function panToNodeFD(graphview, nodeid) {

	//var rectangle = getBoundaries(graphview);

	var canvas = graphview.canvas;
	var graph = graphview.graph;
	var node = graph.getNode(nodeid);

	var pos = node.pos.getc(false);
	// Do not edit the actualy position object you idiot woman!!!!
	var nodePos = {x: pos.x, y:pos.y}
    //alert(nodePos.x+":"+nodePos.y);

	//alert("offsets="+canvas.translateOffsetX+":"+canvas.translateOffsetY);
	var	sx = canvas.scaleOffsetX;
	var	sy = canvas.scaleOffsetY;
	var	ox = canvas.translateOffsetX;
	var oy = canvas.translateOffsetY;
	nodePos.x *= sx;
	nodePos.y *= sy;
	nodePos.x += ox;
	nodePos.y += oy;

    //alert(nodePos.x+":"+nodePos.y);

	var viewwidth = $(graphview.config.injectInto+'-outer').offsetWidth;
	var viewheight = $(graphview.config.injectInto+'-outer').offsetHeight;
	var size = canvas.getSize();

	//alert("size="+size.width+":"+size.height);

	var topX = 0 - (size.width/2);
	var topY = 0 - (size.height/2);

	//alert("topcorner="+topX+":"+topY);

	var movementX = 0-( (nodePos.x - topX) - (viewwidth/2) );
	var movementY = 0-( (nodePos.y - topY) - (viewheight/2) );

	//alert("movement="+movementX+":"+movementY);
	//alert("movement="+movementX*1/canvas.scaleOffsetX+":"+movementY*1/canvas.scaleOffsetX);

    canvas.translate(movementX*1/canvas.scaleOffsetX, movementY*1/canvas.scaleOffsetX);
}


/**
 * Zoom the given graph view to the given level
 */
function zoomFD(graphview, delta) {
     if (graphview) {
          var val = graphview.controller.Navigation.zooming/1000;
          var ans = 1 - (delta * val);
          graphview.canvas.scale(ans, ans);
     }
}

/**
 * Restore the view to 1:1 zoom.
 */
function zoomFDFull(graphview) {
     if (graphview) {
		var canvas = graphview.canvas;
		var ans = 1/canvas.scaleOffsetX;
		canvas.scale(ans, ans);

		var rectangle = getBoundaries(graphview);
		moveToVisibleArea(graphview, rectangle);

		//var rootNodeID = graphview.root;
		//panToNodeFD(graphview, rootNodeID);
	}
}

/**
 * Zoom to fit whole map to screen.
 */
function zoomFDFit(graphview) {
     if (graphview) {
		var rectangle = getBoundaries(graphview);

		var mapWidth = rectangle.width;
		var mapHeight = rectangle.height;

		var outerWidth = $(graphview.config.injectInto+'-outer').offsetWidth;
		var outerHeight = $(graphview.config.injectInto+'-outer').offsetHeight;
		var canvas = graphview.canvas;

		// Only scale if less than one, otherwise it is already fitting to page so just move if required.
		var ans = Math.min((outerWidth)/mapWidth,(outerHeight)/mapHeight) / canvas.scaleOffsetX;
		if (ans < 1) {
			canvas.scale(ans, ans);
		}

		moveToVisibleArea(graphview, rectangle);
	}
}

/**
 * Relocate the graph into the viewable area.
 */
function moveToVisibleArea(graphview, rectangle) {
     if (graphview) {
		var canvas = graphview.canvas;
		var size = canvas.getSize();

		var nodePos = {x:rectangle.x, y:rectangle.y}
		var	sx = canvas.scaleOffsetX;
		var	sy = canvas.scaleOffsetY;
		var	ox = canvas.translateOffsetX;
		var oy = canvas.translateOffsetY;
		nodePos.x *= sx;
		nodePos.y *= sy;
		nodePos.x += ox;
		nodePos.y += oy;

		var topX = 0 - (size.width/2);
		var topY = 0 - (size.height/2);

		var movementX = 0-(nodePos.x - topX);
		var movementY = 0-(nodePos.y - topY);

		canvas.translate(movementX*1/canvas.scaleOffsetX, movementY*1/canvas.scaleOffsetY);
	}
}

/**
 * Work out the rectangle that is the extent of the current graph based on the location of the nodes.
 * If it has a background image, take this into account.
 * Return an array with x,y,width,height representing the rectangle of the graph.
 */
function getBoundaries(graphview) {

	var leftmost = 0;
	var rightmost = 0;
	var topmost = 0;
	var bottommost = 0;

	// Get the extent of the map size
	graphview.graph.eachNode(function(node) {
		var width = node.getData('width');
		var height = node.getData('height');
		var pos = node.pos.getc(true);
		var x = pos.x-(width/2);
		var y = pos.y-(height/2);
		if (x < leftmost) {
			leftmost = x;
		}
		if (x+width > rightmost) {
			rightmost = x+width;
		}
		if (y < topmost) {
			topmost = y;
		}

		if ((y)+(height) > bottommost) {
			bottommost = (y)+(height);
		}
	});

	var finalwidth = rightmost - leftmost;
	var finalheight = bottommost - topmost;

	// Get the background if it has one
	if (graphview.config.background) {
		var image = graphview.config.background.backgroundimage;
		if (image != "") {
			if (image.complete) {
				var width = image.width;
				var height = image.height;
				if (rightmost < width) {
					finalwidth = width;
					leftmost = 0;
				}
				if (bottommost < height) {
					finalheight = height;
					topmost = 0;
				}
			} else {
				image.onload = function() {
					var width = image.width;
					var height = image.height;
					if (rightmost < width) {
						finalwidth = width;
						leftmost = 0;
					}
					if (bottommost < height) {
						finalheight = height;
						topmost = 0;
					}
					//alert(width+":"+height);
				}
			}
		}
	}

	return {
    	'x' : leftmost,
    	'y' : topmost,
        'width' : finalwidth,
        'height' : finalheight,
    };
}

/**
 * Create a PNG of the given graph canvas and popup in a print window.
 */
function printCanvas(graphview)  {
	var canvas = graphview.canvas;
	var size = canvas.getSize();
	var newsize = size;

	size.width = size.width;
	size.height = size.height;

	var windowContent = '<!DOCTYPE html>';
	windowContent += '<html>'
	windowContent += '<head><title>Print Graph Canvas</title></head>';
	windowContent += '<body>';

	if (canvas.canvases.length > 1) {
		var rectangle = getBoundaries(graphview);

		var printCanvas=document.createElement('canvas');
		printCanvas.width=size.width;
		printCanvas.height=size.height;
		var printCtx=printCanvas.getContext('2d');

		printCtx.drawImage(document.getElementById(graphview.config.injectInto+'-canvas'),0,0,size.width,size.height);

		// Get data for png image of map
		var dataUrl = printCanvas.toDataURL();
		windowContent += '<img src="' + dataUrl + '">';
	} else {
		var rectangle = getBoundaries(graphview);

		var currentScale = canvas.scaleOffsetX;

		// if the map is bigger than the canvas size we need to print all of it, so adjust the canvas size.
		newsize.width = (rectangle.width * currentScale)+10;
		newsize.height = (rectangle.height * currentScale)+10;

		$(graphview.config.injectInto).style.width = newsize.width+"px";
		$(graphview.config.injectInto).style.height = newsize.height+"px";
		graphview.canvas.resize(newsize.width, newsize.height);
		graphview.canvas.scale(currentScale, currentScale);

		// Need to reposition the map to top corner so all map is printed
		var nodePos = {x:rectangle.x, y:rectangle.y}

		var	sx = canvas.scaleOffsetX;
		console.log(canvas.scaleOffsetX);
		var	sy = canvas.scaleOffsetY;
		var	ox = canvas.translateOffsetX;
		var oy = canvas.translateOffsetY;
		nodePos.x *= sx;
		nodePos.y *= sy;
		nodePos.x += ox;
		nodePos.y += oy;
		var topX = 0 - (size.width/2);
		var topY = 0 - (size.height/2);
		var movementX = 0-(nodePos.x - topX);
		var movementY = 0-(nodePos.y - topY);

		canvas.translate(movementX*1/canvas.scaleOffsetX, movementY*1/canvas.scaleOffsetY);

		// Get data for pn image of map
		var dataUrl = document.getElementById(graphview.config.injectInto+'-canvas').toDataURL("image/png"); //get png of canvas
		windowContent += '<img src="' + dataUrl + '">';

		// adjust the map size back.

		var correctedSize = newsize;
		if (newsize.height< size.height) {
			correctedSize.height - size.height;
		}
		if (newsize.width< size.width) {
			correctedSize.width - size.width;
		}

		$(graphview.config.injectInto).style.width = correctedSize.width+"px";
		$(graphview.config.injectInto).style.height = correctedSize.height+"px";
		graphview.canvas.resize(correctedSize.width, correctedSize.height);
		graphview.canvas.scale(currentScale, currentScale);

		canvas.translate(movementX*1/canvas.scaleOffsetX, movementY*1/canvas.scaleOffsetY);

		//var reverseX = movementX; // * currentScale; //0-(movementX/3); // * currentScale);
		//var reverseY = movementY; // * currentScale; //0-(movementY/3); // * currentScale);
		//canvas.translate(reverseX*1/canvas.scaleOffsetX, reverseY*1/canvas.scaleOffsetY);
		//console.log("reverseX: "+reverseX);
		//console.log("reverseY: "+reverseY);
	}

	windowContent += '</body>';
	windowContent += '</html>';
	var printWin = window.open('','','width='+newsize.width+',height='+newsize.height);
	printWin.document.open();
	printWin.document.write(windowContent);
	printWin.document.close();
}

function computeMostConnectedNode(graphview) {
	var connectedCount = 0;
	var connectedNode = "";

	for(var i in graphview.graph.nodes) {
		var n = graphview.graph.nodes[i];
		var connections = n.getData('connections');
		if (connections && connections.length > connectedCount) {
			connectedCount = connections.length;
			connectedNode = n;
		}
	}
	if (connectedNode && connectedNode != "") {
		FD_MOST_CONNECTED_NODE = connectedNode;
		if (!graphview.root) {
			graphview.root = connectedNode.id;
		}
	} else {
		//if all else fails, just pick the first node
		for(var i in graphview.graph.nodes) {
			var n = graphview.graph.nodes[i];
			FD_MOST_CONNECTED_NODE = n;
			graphview.root = n.id;
			break;
		}
	}
}

function d3Legend() {
  var margin = {top: 5, right: 0, bottom: 5, left: 10},
      width = 400,
      height = 20,
      color = d3.scale.category10().range(),
      dispatch = d3.dispatch('legendClick', 'legendMouseover', 'legendMouseout');

  function chart(selection) {

    selection.each(function(data) {
      /**
      *    Legend curently is setup to automaticaly expand vertically based on a max width.
      *    Should implement legend where EITHER a maxWidth or a maxHeight is defined, then
      *    the other dimension will automatically expand to fit, and anything that exceeds
      *    that will automatically be clipped.
      **/

      var wrap = d3.select(this).selectAll('g.legend').data([data]);
      var gEnter = wrap.enter().append('g').attr('class', 'legend').append('g');

      var g = wrap.select('g')
          .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

      var series = g.selectAll('.series')
          .data(function(d) { return d });


      var seriesEnter = series.enter().append('g').attr('class', 'series')
          .on('click', function(d, i) {
            dispatch.legendClick(d, i);
          })
          .on('mouseover', function(d, i) {
            dispatch.legendMouseover(d, i);
          })
          .on('mouseout', function(d, i) {
            dispatch.legendMouseout(d, i);
          });


      seriesEnter.append('circle')
          .style('fill', function(d, i){ if (d.values[0].color) {return d.values[0].color;} else {return color[i];} })
          .style('stroke', function(d, i){ if (d.values[0].color) {return d.values[0].color;} else {return color[i];} })
          .attr('r', 5);

      seriesEnter.append('text')
          .text(function(d) { return d.key })
          .attr('text-anchor', 'start')
          .attr('dy', '.32em')
          .attr('dx', '8');

      series.classed('disabled', function(d) { return d.disabled });
      series.exit().remove();

      var ypos = 5,
          newxpos = 5,
          maxwidth = 0,
          xpos;
      series
          .attr('transform', function(d, i) {
             var length = d3.select(this).select('text').node().getComputedTextLength() + 28;
             xpos = newxpos;

             //TODO: 1) Make sure dot + text of every series fits horizontally, or clip text to fix
             //      2) Consider making columns in line so dots line up
             //         --all labels same width? or just all in the same column?
             //         --optional, or forced always?
             if (width < margin.left + margin.right + xpos + length) {
               newxpos = xpos = 5;
               ypos += 20;
             }

             newxpos += length;
             if (newxpos > maxwidth) maxwidth = newxpos;

             return 'translate(' + xpos + ',' + ypos + ')';
          });

      //position legend as far right as possible within the total width
      g.attr('transform', 'translate(' + (width - margin.right - maxwidth) + ',' + margin.top + ')');

      height = margin.top + margin.bottom + ypos + 15;
    });

    return chart;
  }

  chart.dispatch = dispatch;

  chart.margin = function(_) {
    if (!arguments.length) return margin;
    margin = _;
    return chart;
  };

  chart.width = function(_) {
    if (!arguments.length) return width;
    width = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) return height;
    height = _;
    return chart;
  };

  chart.color = function(_) {
    if (!arguments.length) return color;
    color = _;
    return chart;
  };

  return chart;
}

function d3LegendInactive() {
  var margin = {top: 5, right: 0, bottom: 5, left: 10},
      width = 400,
      height = 20,
      color = d3.scale.category10().range(),
      label = 'Key';

  function chart(selection) {

    selection.each(function(data) {
      /**
      *    Legend curently is setup to automaticaly expand vertically based on a max width.
      *    Should implement legend where EITHER a maxWidth or a maxHeight is defined, then
      *    the other dimension will automatically expand to fit, and anything that exceeds
      *    that will automatically be clipped.
      **/

      var wrap = d3.select(this).selectAll('g.legend').data([data]);
      var gEnter = wrap.enter().append('g').attr('class', 'legend').append('g');

      var g = wrap.select('g')
          .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

      var series = g.selectAll('.series')
          .data(function(d) { return d });

      var seriesEnter = series.enter().append('g');

      seriesEnter.append('circle')
          .style('fill', function(d, i){ if (d.values[0].color) {return d.values[0].color;} else {return color[i];} })
          .style('stroke', function(d, i){ if (d.values[0].color) {return d.values[0].color;} else {return color[i];}  })
          .attr('r', 5);

      seriesEnter.append('text')
          .text(function(d) { return getNodeTitleAntecedence(d.key, false); })
          .attr('text-anchor', 'start')
          .attr('dy', '.32em')
          .attr('dx', '8');

      series.exit().remove();

      var ypos = 12,
          newxpos = 5,
          maxwidth = 0,
          xpos;
      series
          .attr('transform', function(d, i) {
             var length = d3.select(this).select('text').node().getComputedTextLength() + 28;
             xpos = newxpos;
             if (width < margin.left + margin.right + xpos + length) {
               newxpos = xpos = 5;
               ypos += 20;
             }
             newxpos += length;
             if (newxpos > maxwidth) maxwidth = newxpos;

             return 'translate(' + xpos + ',' + ypos + ')';
          });

      //position legend as far right as possible within the total width
      g.attr('transform', 'translate(' + (width - margin.right - maxwidth) + ',' + margin.top + ')');

      height = margin.top + margin.bottom + ypos + 15;
    });

    return chart;
  }

  chart.label = function(_) {
    if (!arguments.length) return label;
    label = _;
    return chart;
  };

  chart.margin = function(_) {
    if (!arguments.length) return margin;
    margin = _;
    return chart;
  };

  chart.width = function(_) {
    if (!arguments.length) return width;
    width = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) return height;
    height = _;
    return chart;
  };

  chart.color = function(_) {
    if (!arguments.length) return color;
    color = _;
    return chart;
  };

  return chart;
}

function sparklineDateNVD3(container, data, width, height) {

	var margin = {top: 15, right: 50, bottom: 10, left: 60};
	var width = width - (margin.left+margin.right);

	var formatDate = d3.time.format("%e %b %y");

	var chart = nv.models.sparklinePlus()
	  .margin(margin)
	  .x(function(d) { return d.x })
	  .y(function(d) { return d.y })
	  .width(width)
	  .height(height)
	  ;

  	chart.xTickFormat(function(d) {
          return formatDate(new Date(d));
    });

	var svg = d3.select(container).append("svg");
	svg.datum(data)
		.transition().duration(500)
		.call(chart);

	nv.utils.windowResize(chart.update);
	nv.addGraph(chart);
}

function simpleBarChartTypes(container, data, width, height) {

	data.forEach(function(d, i) {
		var series = d.values;
		for (var i=0; i<series.length; i++) {
			var next = series[i];
			if (!next.color) {
				if (next.label == getNodeTitleAntecedence("Pro", false)) {
					next.color = "#A9C89E";
				} else if (next.label == getNodeTitleAntecedence("Con", false)) {
					next.color = "#D46A6A";
				} else if (next.label == getNodeTitleAntecedence("Solution", false)) {
					next.color = "#A4AED4";
				} else if (next.label == "Idea") {
					next.color = "#A4AED4";
				} else if (next.label == getNodeTitleAntecedence("Issue", false)) {
					next.color = "#DFC7EB";
				} else if (next.label == "<?php echo $LNG->ARGUMENT_NAME; ?>") {
					next.color = "#E1E353";
				} else if (next.label == "<?php echo $LNG->STATS_OVERVIEW_VOTES;?>") {
					next.color = "#F9B257";
				} else {
					next.color = next.children ? color(next.depth) : null;
				}
			}
		}
	});

	var chart = nv.models.discreteBarChart()
	      .width(width)
	      .height(height)
		  .margin({top: 15, right: 10, bottom: 30, left: 30})
		  .x(function(d) { return d.label })
		  .y(function(d) { return d.value })
		  .staggerLabels(false)    //Too many bars and not enough room? Try staggering labels.
		  .tooltips(true)        //Do not show tooltips
		  .showValues(false)       //...instead, show the bar value right on top of each bar.
		  .transitionDuration(350)
		  .showXAxis(false)
		  ;

	chart.yAxis.tickFormat(d3.format(',f'));

	var svg = d3.select(container).append("svg");
	svg.datum(data).call(chart);

	nv.utils.windowResize(chart.update);
	nv.addGraph(chart);
}

/**
 * http://www.sitepoint.com/javascript-generate-lighter-darker-color/
 * @Author: Craig Buckler
 */
function colorLuminance(hex, lum) {

	// validate hex string
	hex = String(hex).replace(/[^0-9a-f]/gi, '');
	if (hex.length < 6) {
		hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
	}
	lum = lum || 0;

	// convert to decimal and change luminosity
	var rgb = "#", c, i;
	for (i = 0; i < 3; i++) {
		c = parseInt(hex.substr(i*2,2), 16);
		c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
		rgb += ("00"+c).substr(c.length);
	}

	return rgb;
}

/**
 * mapRectangle code was taken/adapted from:
 * http://code.google.com/p/libsjs/source/browse/trunk/geom/rectangle.class.js?r=2
 * License is MIT License (http://opensource.org/licenses/mit-license.php);
 */
var mapRectangle = function (x, y, width, height) {
	if (isNaN(height) || isNaN(width) || isNaN(x) || isNaN(y)  || typeof height !== 'number' || typeof width !== 'number' || typeof x !== 'number' || typeof y !== 'number') {
			return false;
	}
	else {
		this.height = height;
		this.width = width;
		this.x = x;
		this.y = y;
	}
};

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
	} else if (rolename == 'Map') {
		nodeHEX = mapbackpale;
	} else {
		nodeHEX = plainbackpale;
	}

	return nodeHEX;
}

/**
 * Prototype of BB.Geom.Rectangle
 */
mapRectangle.prototype = {
	/**
	 * Get the height of the rectangle
	 * @returns The height of the rectangle
	 */
	getHeight: function () {
		return this.height;
	},
	/**
	 * Get the width of the rectangle
	 * @returns The width of the rectangle.
	 */
	getWidth: function () {
		return this.width;
	},
	/**
	 * Get the x coordinant of the rectangle
	 * @returns The x coordinant of the rectangle
	 */
	getX: function () {
		return this.x;
	},
	/**
	 * Get the y coordinant of the rectangle
	 * @returns The y coordinant of the rectangle
	 */
	getY: function () {
		return this.y;
	},
	/**
	 * Get the hight and width of the rectangle
	 * @returns Object literal containing the height and width of the rectangle
	 */
	getSize: function () {
		return {
			height: this.height,
			width: this.width
		};
	},
	/**
	 * Get the X Y coordinants of the rectangle
	 * @returns Object literal containing the X and Y coordinants of the rectangle
	 */
	getLocation: function () {
		return {
				x: this.x,
				y: this.y
		};
	},
	/**
	 * Set the height of the rectangle
	 * @param {Number} height Number value to set as the height of the rectangle
	 * @returns True when the height is set false when an error is encountered
	 */
	setHeight: function (height) {
		if (!isNaN(height) && typeof height === 'number' && height >= 0 && height !== Infinity) {
				this.height = height;
				return true;
		}
		else {
				return false;
		}
	},
	/**
	 * Set the width of the rectangle
	 * @param {Number} width Number value to set as the width of the rectangle
	 * @returns True when the width is set false when an error is encountered
	 */
	setWidth: function (width) {
		if (!isNaN(width) && typeof width === 'number' && width >= 0 && width !== Infinity) {
				this.width = width;
				return true;
		}
		else {
				return false;
		}
	},
	/**
	 * Set the x cooridnant of the rectangle
	 * @param {Number} x Number value to set as the x cooridnant of the rectangle
	 * @returns True when the x coordinant is set false when an error is encountered
	 */
	setX: function (x) {
		if (!isNaN(x) && typeof x === 'number' && x >= 0 && x !== Infinity) {
				this.x = x;
				return true;
		}
		else {
				return false;
		}
	},
	/**
	 * Set the y cooridnant of the rectangle
	 * @param {Number} y Number value to set as the y cooridnant of the rectangle
	 * @returns True when the y coordinant is set false when an error is encountered
	 */
	setY: function (y) {
		if (!isNaN(y) && typeof y === 'number' && y >= 0 && y !== Infinity) {
				this.y = y;
				return true;
		}
		else {
				return false;
		}
	},
	/**
	 * Set the height and width of the rectangle
	 * @param {Number} height Height to set for the rectangle
	 * @param {Number} width Width to set for the rectangle
	 * @returns True if the size has been set for the rectangle and false if an error condition was met
	 */
	setSize: function (height, width) {
		if (!isNaN(width) && typeof width === 'number' && width >= 0 && width !== Infinity && !isNaN(height) && typeof height === 'number' && height >= 0 && height !== Infinity) {
				this.width = width;
				this.height = height;
				return true;
		}
		else {
				return false;
		}
	},
	/**
	 * Set the X and Y coordinants of the rectangle
	 * @param {Number} x X coordinant to set for the rectangle
	 * @param {Number} y Y coordinant to set for the rectangle
	 * @returns True if the location has been set for the rectangle and false if an error condition was met
	 */
	setLocation: function (x, y) {
		if (!isNaN(x) && typeof x === 'number' && x >= 0 && x !== Infinity && !isNaN(y) && typeof y === 'number'  && y >= 0 && y !== Infinity) {
				this.y = y;
				this.x = x;
				return true;
		}
		else {
				return false;
		}
	},
	/**
	 * Get the center point of the rectangle
	 * @returns Object literal with x & y properties containing the coordinants of the center point of the rectangle
	 */
	getCenter: function () {
		return {
				x: this.x + (this.width / 2),
				y: this.y + (this.height / 2)
		};
	},
	/**
	 * Determine if a given set of coordinants fall withing the rectangle
	 * @param {Number} x X coordinant
	 * @param {Object} x Object literal with x and y
	 * @param {Number} y Y coordinant
	 * @returns True if coordinants fall within rectangle and false if they fall outside of the rectangle
	 */
	contains: function (x, y) {
		if (x.x && x.y) {
				y = x.y;
				x = x.x;
		}

		if (x <= this.x || y <= this.y || y >= this.y + this.height || x >= this.x + this.width) {
				return false;
		}
		else {
				return true;
		}
	},
	/**
	 * Determine if a given X coordinant falls within the rectangle
	 * @param {Number} x X coordinant
	 * @returns True if coordinants fall within rectangle and false if they fall outside of the rectangle
	 */
	containsX: function (x) {
		if (x < this.x || x > this.x + this.width) {
				return false;
		}
		else {
				return true;
		}
	},
	/**
	 * Determine if a given Y coordinant falls within the rectangle
	 * @param {Number} y Y coordinant
	 * @returns True if coordinants fall within rectangle and false if they fall outside of the rectangle
	 */
	containsY: function (y) {
		if (y < this.y || y > this.y + this.height) {
				return false;
		}
		else {
				return true;
		}
	},
	/**
	 * Returns a string representing the rectangle
	 * @returns {String} representing the rectangle
	 */
	toString: function () {
		return "{height: " + this.height + ", width: " + this.width + ", x: " + this.x + ", y: " + this.y + "}";
	}
};