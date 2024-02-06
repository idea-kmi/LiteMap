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

var diameter = 760;
var svg;
var circlepackingcontainer;
var tipCirclePack;

function createCirclePackingD3Vis(container){
	circlepackingcontainer = d3.select(container);

 	svg = d3.select(container).append("svg")
    .attr("width", diameter)
    .attr("height", diameter)
    .append("g")
    .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");


    // Init tooltip
	tipCirclePack = d3.select(container)
  		.append("div")
    	.style("visibility", "hidden")
    	.style("position","absolute")
    	.style("border","1px solid lightgray")
    	.style("background-color","white")
    	.style("padding", "2px")
    	.style("top", "10px")
    	.style("left", "10px")
    	.text("");
}

function completeCirclePackingD3Vis(root) {
	if (!root) return console.error(root);

	var width=diameter;
	var data = root;
	var margin = 40;
	var color = d3.scale.linear()
		.domain([-1, 5])
		.range(["hsl(152,80%,80%)", "hsl(228,30%,40%)"])
		.interpolate(d3.interpolateHcl);

	var pack = d3.layout.pack()
		.padding(40)
		.size([diameter - (margin*2), diameter - (margin*2)])
		.value(function(d) { return d.size; });

	var focus = root;
	var view;

    addPlaceholders(root);
    var nodes = pack.nodes( root );

	nodes.forEach(function(d) {
		if (!d.color) {
			if (d.nodetype == "Pro") {
				d.color = proback;
			} else if (d.nodetype == "Con") {
				d.color = conback;
			} else if (d.nodetype == "Argument") {
				d.color = colorLuminance(argumentback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Solution") {
				d.color = colorLuminance(solutionback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Idea") {
				d.color = colorLuminance(ideaback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Issue") {
				d.color = issueback;
			} else if (d.nodetype == "Group") {
				d.color = "#F4F5F7"; // was 'transparent' now background colour - very light gray
			} else if (d.nodetype == "Challenge") {
				d.color = colorLuminance(challengeback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Map") {
				d.color =  colorLuminance(mapback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Idea") {
				d.color = colorLuminance(ideaback, -(7*d.depth-1)/100);
			} else {
				d.color = d.children ? color(d.depth) : null;
			}

			/*if (d.nodetype == "Pro") {
				d.color = colorLuminance(proback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Con") {
				d.color = colorLuminance(conback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Argument") {
				d.color = colorLuminance(argumentback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Solution") {
				d.color = colorLuminance(solutionback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Issue") {
				d.color = colorLuminance(issueback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Group") {
				d.color = "transparent";
			} else if (d.nodetype == "Challenge") {
				d.color = colorLuminance(challengeback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Map") {
				d.color =  colorLuminance(mapback, -(7*d.depth-1)/100);
			} else if (d.nodetype == "Idea") {
				d.color = colorLuminance(ideaback, -(7*d.depth-1)/100);
			} else {
				d.color = d.children ? color(d.depth) : null;
			}*/

			/*if (d.nodetype == "Pro") {
				d.color = "<?php echo $CFG->proback; ?>";
			} else if (d.nodetype == "Con") {
				d.color = "<?php echo $CFG->conback; ?>";
			} else if (d.nodetype == "Argument") {
				d.color = "<?php echo $CFG->argumentback; ?>";
			} else if (d.nodetype == "Solution") {
				d.color = "<?php echo $CFG->solutionback; ?>";
			} else if (d.nodetype == "Issue") {
				d.color = "<?php echo $CFG->issueback; ?>";
			} else if (d.nodetype == "Group") {
				d.color = "transparent";
			} else if (d.nodetype == "Challenge") {
				d.color = "<?php echo $CFG->challengeback; ?>";
			} else if (d.nodetype == "Map") {
				d.color = "<?php echo $CFG->mapback; ?>";
			} else if (d.nodetype == "Idea") {
				d.color = "<?php echo $CFG->ideaback; ?>";
			} else {
				d.color = d.children ? color(d.depth) : null;
			}
			*/
		}
	});

    removePlaceholders(nodes);
    centerNodes( nodes );
    makePositionsRelativeToZero( nodes );

	var circle = svg.selectAll("circle")
		.data(nodes)
		.enter().append("circle")
		.attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })
		.style("fill", function(d) {
			return d.color;
		})
		.on("click", function(d) {if (d.children) { if (focus !== d) zoom(d), d3.event.stopPropagation(); } })
		.on('mouseover', function (d,i) {
			var offset = [15,15];
	    	var label = getNodeTitleAntecedence(d.nodetype, true)+" "+d.name;
			tipCirclePack.style("top", (event.pageY)+(offset[1])+"px");
        	tipCirclePack.style("left",(event.pageX)+(offset[0])+"px");
			tipCirclePack.text(label);
			tipCirclePack.style("visibility", "visible");
		})
		.on('mousemove', function (d,i) {
			var offset = [15,15];
			tipCirclePack.style("top", (event.pageY)+(offset[1])+"px");
        	tipCirclePack.style("left",(event.pageX)+(offset[0])+"px");
		})
		.on('mouseout', function (d,i) {
			tipCirclePack.style("visibility", "hidden")
		});

	var text = svg.selectAll("text")
		.data(nodes)
		.enter().append("text")
		.attr("class", "label")
		.style("fill-opacity", function(d) { return d.parent === root ? 1 : 0; })
		.style("display", function(d) { return d.parent === root ? null : "none"; })
		.text(function(d) { return ''; });

	//text = d.name;

	var node = svg.selectAll("circle,text");

	d3.select("body").on("click", function() { zoom(root); });

	// Set the background colour.
	//circlepackingcontainer.style("background", "#E7E3E3");

	zoomTo([root.x, root.y, root.r * 2 + margin]);

	function zoom(d) {
		var focus0 = focus; focus = d;

		var transition = d3.transition()
			.duration(d3.event.altKey ? 7500 : 750)
			.tween("zoom", function(d) {
			  var i = d3.interpolateZoom(view, [focus.x, focus.y, focus.r * 2 + margin]);
			  return function(t) { zoomTo(i(t)); };
			});

		transition.selectAll("text")
		  .filter(function(d) { return d.parent === focus || this.style.display === "inline"; })
			.style("fill-opacity", function(d) { return d.parent === focus ? 1 : 0; })
			.each("start", function(d) { if (d.parent === focus) this.style.display = "inline"; })
			.each("end", function(d) { if (d.parent !== focus) this.style.display = "none"; });
	}

	function zoomTo(v) {
		var k = diameter / v[2]; view = v;
		node.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
		circle.attr("r", function(d) { return d.r * k; });
	}

	/** LEGEND **/

	var legend = d3LegendInactive();
	legend
		.width(width+10)
		.height(20)
        .margin({top: 0, right: 0, bottom: 0, left: 0});

	var legendData = flatten(data)
	var priorities = ['Group','Challenge','Idea','Issue','Solution','Pro','Con','Argument'];
	var nest = d3.nest().key(function(d) { return d.nodetype; })
		.sortKeys(function(a,b) {
			if (priorities.indexOf(a) < priorities.indexOf(b)) {
				return -1;
			} else if (priorities.indexOf(a) > priorities.indexOf(b)) {
				return 1;
			} else {
				return 0;
			}
			//return priorities.indexOf(a) - priorities.indexOf(b);
		});

    svg.append('g').attr('class', 'legendWrap');
	svg.select('.legendWrap')
          .datum(nest.entries(legendData))
          .attr('transform', 'translate(' + -((diameter)-100) + ',' + -((diameter/2)+5) +')')
          .call(legend);

	//d3.select(self.frameElement).style("height", diameter + "px");
}

function flatten(root) {
	var nodes = [], i = 0;

	function recurse(node) {
		if (node.children)
			node.children.forEach(recurse);
		if (!node.id) node.id = ++i;
			nodes.push(node);
	}

	recurse(root);
	return nodes;
}

/*** Code from http://stackoverflow.com/questions/22307486/d3-js-packed-circle-layout-how-to-adjust-child-radius ***/

function addPlaceholders( node ) {
    if(node.children) {
        for( var i = 0; i < node.children.length; i++ ) {
            var child = node.children[i];
            addPlaceholders( child );
        }

        if(node.children.length === 1) {
            node.children.push({ name:'placeholder', children: [ { name:'placeholder', children:[] }] });
        }
    }
};

function removePlaceholders( nodes ) {
    for( var i = nodes.length - 1; i >= 0; i-- ) {
        var node = nodes[i];
        if( node.name === 'placeholder' ) {
            nodes.splice(i,1);
        } else {
            if( node.children ) {
                removePlaceholders( node.children );
            }
        }
    }
};

function centerNodes( nodes ) {
    for( var i = 0; i < nodes.length; i ++ ) {
        var node = nodes[i];
        if( node.children ) {
            if( node.children.length === 1) {
                var offset = node.x - node.children[0].x;
                node.children[0].x += offset;
                reposition(node.children[0],offset);
            }
        }
    }

    function reposition( node, offset ) {
        if(node.children) {
            for( var i = 0; i < node.children.length; i++ ) {
                node.children[i].x += offset;
                reposition( node.children[i], offset );
            }
        }
    };
};

function makePositionsRelativeToZero( nodes ) {
    //use this to have vis centered at 0,0,0 (easier for positioning)
    var offsetX = nodes[0].x;
    var offsetY = nodes[0].y;

    for( var i = 0; i < nodes.length; i ++ ) {
        var node = nodes[i];
        node.x -= offsetX;
        node.y -= offsetY;
    }
};

/*** End Code import ***/

function displayCirclePackingD3Vis(json) {
	var root = json;
	completeCirclePackingD3Vis(root);
}

function displayCirclePackingD3VisTest() {

    //init data
    var json = {
		"name": "flare",
		"children": [
			{
				"name": "analytics",
				"children": [
					{
						"name": "cluster",
						"children": [
							{
								"name": "AgglomerativeCluster",
								"size": 3938
							},
							{
								"name": "CommunityStructure",
								"size": 3812
							},
							{
								"name": "HierarchicalCluster",
								"size": 6714
							},
							{
								"name": "MergeEdge",
								"size": 743
							}
						]
					},
					{
						"name": "graph",
						"children": [
							{
								"name": "BetweennessCentrality",
								"size": 3534
							},
							{
								"name": "LinkDistance",
								"size": 5731
							},
							{
								"name": "MaxFlowMinCut",
								"size": 7840
							},
							{
								"name": "ShortestPaths",
								"size": 5914
							},
							{
								"name": "SpanningTree",
								"size": 3416
							}
						]
					},
					{
						"name": "optimization",
						"children": [
							{
								"name": "AspectRatioBanker",
								"size": 7074
							}
						]
					}
				]
			},
			{
				"name": "animate",
				"children": [
					{
						"name": "Easing",
						"size": 17010
					},
					{
						"name": "FunctionSequence",
						"size": 5842
					},
					{
						"name": "interpolate",
						"children": [
							{
								"name": "ArrayInterpolator",
								"size": 1983
							},
							{
								"name": "ColorInterpolator",
								"size": 2047
							},
							{
								"name": "DateInterpolator",
								"size": 1375
							},
							{
								"name": "Interpolator",
								"size": 8746
							},
							{
								"name": "MatrixInterpolator",
								"size": 2202
							},
							{
								"name": "NumberInterpolator",
								"size": 1382
							},
							{
								"name": "ObjectInterpolator",
								"size": 1629
							},
							{
								"name": "PointInterpolator",
								"size": 1675
							},
							{
								"name": "RectangleInterpolator",
								"size": 2042
							}
						]
					},
					{
						"name": "ISchedulable",
						"size": 1041
					},
					{
						"name": "Parallel",
						"size": 5176
					},
					{
						"name": "Pause",
						"size": 449
					},
					{
						"name": "Scheduler",
						"size": 5593
					},
					{
						"name": "Sequence",
						"size": 5534
					},
					{
						"name": "Transition",
						"size": 9201
					},
					{
						"name": "Transitioner",
						"size": 19975
					},
					{
						"name": "TransitionEvent",
						"size": 1116
					},
					{
						"name": "Tween",
						"size": 6006
					}
				]
			},
			{
				"name": "data",
				"children": [
					{
						"name": "converters",
						"children": [
							{
								"name": "Converters",
								"size": 721
							},
							{
								"name": "DelimitedTextConverter",
								"size": 4294
							},
							{
								"name": "GraphMLConverter",
								"size": 9800
							},
							{
								"name": "IDataConverter",
								"size": 1314
							},
							{
								"name": "JSONConverter",
								"size": 2220
							}
						]
					},
					{
						"name": "DataField",
						"size": 1759
					},
					{
						"name": "DataSchema",
						"size": 2165
					},
					{
						"name": "DataSet",
						"size": 586
					},
					{
						"name": "DataSource",
						"size": 3331
					},
					{
						"name": "DataTable",
						"size": 772
					},
					{
						"name": "DataUtil",
						"size": 3322
					}
				]
			},
			{
				"name": "display",
				"children": [
					{
						"name": "DirtySprite",
						"size": 8833
					},
					{
						"name": "LineSprite",
						"size": 1732
					},
					{
						"name": "RectSprite",
						"size": 3623
					},
					{
						"name": "TextSprite",
						"size": 10066
					}
				]
			},
			{
				"name": "flex",
				"children": [
					{
						"name": "FlareVis",
						"size": 4116
					}
				]
			},
			{
				"name": "physics",
				"children": [
					{
						"name": "DragForce",
						"size": 1082
					},
					{
						"name": "GravityForce",
						"size": 1336
					},
					{
						"name": "IForce",
						"size": 319
					},
					{
						"name": "NBodyForce",
						"size": 10498
					},
					{
						"name": "Particle",
						"size": 2822
					},
					{
						"name": "Simulation",
						"size": 9983
					},
					{
						"name": "Spring",
						"size": 2213
					},
					{
						"name": "SpringForce",
						"size": 1681
					}
				]
			},
			{
				"name": "query",
				"children": [
					{
						"name": "AggregateExpression",
						"size": 1616
					},
					{
						"name": "And",
						"size": 1027
					},
					{
						"name": "Arithmetic",
						"size": 3891
					},
					{
						"name": "Average",
						"size": 891
					},
					{
						"name": "BinaryExpression",
						"size": 2893
					},
					{
						"name": "Comparison",
						"size": 5103
					},
					{
						"name": "CompositeExpression",
						"size": 3677
					},
					{
						"name": "Count",
						"size": 781
					},
					{
						"name": "DateUtil",
						"size": 4141
					},
					{
						"name": "Distinct",
						"size": 933
					},
					{
						"name": "Expression",
						"size": 5130
					},
					{
						"name": "ExpressionIterator",
						"size": 3617
					},
					{
						"name": "Fn",
						"size": 3240
					},
					{
						"name": "If",
						"size": 2732
					},
					{
						"name": "IsA",
						"size": 2039
					},
					{
						"name": "Literal",
						"size": 1214
					},
					{
						"name": "Match",
						"size": 3748
					},
					{
						"name": "Maximum",
						"size": 843
					},
					{
						"name": "methods",
						"children": [
							{
								"name": "add",
								"size": 593
							},
							{
								"name": "and",
								"size": 330
							},
							{
								"name": "average",
								"size": 287
							},
							{
								"name": "count",
								"size": 277
							},
							{
								"name": "distinct",
								"size": 292
							},
							{
								"name": "div",
								"size": 595
							},
							{
								"name": "eq",
								"size": 594
							},
							{
								"name": "fn",
								"size": 460
							},
							{
								"name": "gt",
								"size": 603
							},
							{
								"name": "gte",
								"size": 625
							},
							{
								"name": "iff",
								"size": 748
							},
							{
								"name": "isa",
								"size": 461
							},
							{
								"name": "lt",
								"size": 597
							},
							{
								"name": "lte",
								"size": 619
							},
							{
								"name": "max",
								"size": 283
							},
							{
								"name": "min",
								"size": 283
							},
							{
								"name": "mod",
								"size": 591
							},
							{
								"name": "mul",
								"size": 603
							},
							{
								"name": "neq",
								"size": 599
							},
							{
								"name": "not",
								"size": 386
							},
							{
								"name": "or",
								"size": 323
							},
							{
								"name": "orderby",
								"size": 307
							},
							{
								"name": "range",
								"size": 772
							},
							{
								"name": "select",
								"size": 296
							},
							{
								"name": "stddev",
								"size": 363
							},
							{
								"name": "sub",
								"size": 600
							},
							{
								"name": "sum",
								"size": 280
							},
							{
								"name": "update",
								"size": 307
							},
							{
								"name": "variance",
								"size": 335
							},
							{
								"name": "where",
								"size": 299
							},
							{
								"name": "xor",
								"size": 354
							},
							{
								"name": "_",
								"size": 264
							}
						]
					},
					{
						"name": "Minimum",
						"size": 843
					},
					{
						"name": "Not",
						"size": 1554
					},
					{
						"name": "Or",
						"size": 970
					},
					{
						"name": "Query",
						"size": 13896
					},
					{
						"name": "Range",
						"size": 1594
					},
					{
						"name": "StringUtil",
						"size": 4130
					},
					{
						"name": "Sum",
						"size": 791
					},
					{
						"name": "Variable",
						"size": 1124
					},
					{
						"name": "Variance",
						"size": 1876
					},
					{
						"name": "Xor",
						"size": 1101
					}
				]
			},
			{
				"name": "scale",
				"children": [
					{
						"name": "IScaleMap",
						"size": 2105
					},
					{
						"name": "LinearScale",
						"size": 1316
					},
					{
						"name": "LogScale",
						"size": 3151
					},
					{
						"name": "OrdinalScale",
						"size": 3770
					},
					{
						"name": "QuantileScale",
						"size": 2435
					},
					{
						"name": "QuantitativeScale",
						"size": 4839
					},
					{
						"name": "RootScale",
						"size": 1756
					},
					{
						"name": "Scale",
						"size": 4268
					},
					{
						"name": "ScaleType",
						"size": 1821
					},
					{
						"name": "TimeScale",
						"size": 5833
					}
				]
			},
			{
				"name": "util",
				"children": [
					{
						"name": "Arrays",
						"size": 8258
					},
					{
						"name": "Colors",
						"size": 10001
					},
					{
						"name": "Dates",
						"size": 8217
					},
					{
						"name": "Displays",
						"size": 12555
					},
					{
						"name": "Filter",
						"size": 2324
					},
					{
						"name": "Geometry",
						"size": 10993
					},
					{
						"name": "heap",
						"children": [
							{
								"name": "FibonacciHeap",
								"size": 9354
							},
							{
								"name": "HeapNode",
								"size": 1233
							}
						]
					},
					{
						"name": "IEvaluable",
						"size": 335
					},
					{
						"name": "IPredicate",
						"size": 383
					},
					{
						"name": "IValueProxy",
						"size": 874
					},
					{
						"name": "math",
						"children": [
							{
								"name": "DenseMatrix",
								"size": 3165
							},
							{
								"name": "IMatrix",
								"size": 2815
							},
							{
								"name": "SparseMatrix",
								"size": 3366
							}
						]
					},
					{
						"name": "Maths",
						"size": 17705
					},
					{
						"name": "Orientation",
						"size": 1486
					},
					{
						"name": "palette",
						"children": [
							{
								"name": "ColorPalette",
								"size": 6367
							},
							{
								"name": "Palette",
								"size": 1229
							},
							{
								"name": "ShapePalette",
								"size": 2059
							},
							{
								"name": "SizePalette",
								"size": 2291
							}
						]
					},
					{
						"name": "Property",
						"size": 5559
					},
					{
						"name": "Shapes",
						"size": 19118
					},
					{
						"name": "Sort",
						"size": 6887
					},
					{
						"name": "Stats",
						"size": 6557
					},
					{
						"name": "Strings",
						"size": 22026
					}
				]
			},
			{
				"name": "vis",
				"children": [
					{
						"name": "axis",
						"children": [
							{
								"name": "Axes",
								"size": 1302
							},
							{
								"name": "Axis",
								"size": 24593
							},
							{
								"name": "AxisGridLine",
								"size": 652
							},
							{
								"name": "AxisLabel",
								"size": 636
							},
							{
								"name": "CartesianAxes",
								"size": 6703
							}
						]
					},
					{
						"name": "controls",
						"children": [
							{
								"name": "Anchor Control Anchor Control",
								"size": 2138
							},
							{
								"name": "ClickControl",
								"size": 3824
							},
							{
								"name": "Control",
								"size": 1353
							},
							{
								"name": "ControlList",
								"size": 4665
							},
							{
								"name": "DragControl",
								"size": 2649
							},
							{
								"name": "ExpandControl",
								"size": 2832
							},
							{
								"name": "HoverControl",
								"size": 4896
							},
							{
								"name": "IControl",
								"size": 763
							},
							{
								"name": "PanZoomControl",
								"size": 5222
							},
							{
								"name": "SelectionControl",
								"size": 7862
							},
							{
								"name": "TooltipControl",
								"size": 8435
							}
						]
					},
					{
						"name": "data",
						"children": [
							{
								"name": "Data",
								"size": 20544
							},
							{
								"name": "DataList",
								"size": 19788
							},
							{
								"name": "DataSprite",
								"size": 10349
							},
							{
								"name": "EdgeSprite",
								"size": 3301
							},
							{
								"name": "NodeSprite",
								"size": 19382
							},
							{
								"name": "render",
								"children": [
									{
										"name": "ArrowType",
										"size": 698
									},
									{
										"name": "EdgeRenderer",
										"size": 5569
									},
									{
										"name": "IRenderer",
										"size": 353
									},
									{
										"name": "ShapeRenderer",
										"size": 2247
									}
								]
							},
							{
								"name": "ScaleBinding",
								"size": 11275
							},
							{
								"name": "Tree",
								"size": 7147
							},
							{
								"name": "TreeBuilder",
								"size": 9930
							}
						]
					},
					{
						"name": "events",
						"children": [
							{
								"name": "DataEvent",
								"size": 2313
							},
							{
								"name": "SelectionEvent",
								"size": 1880
							},
							{
								"name": "TooltipEvent",
								"size": 1701
							},
							{
								"name": "VisualizationEvent",
								"size": 1117
							}
						]
					},
					{
						"name": "legend",
						"children": [
							{
								"name": "Legend",
								"size": 20859
							},
							{
								"name": "LegendItem",
								"size": 4614
							},
							{
								"name": "LegendRange",
								"size": 10530
							}
						]
					},
					{
						"name": "operator",
						"children": [
							{
								"name": "distortion",
								"children": [
									{
										"name": "BifocalDistortion",
										"size": 4461
									},
									{
										"name": "Distortion",
										"size": 6314
									},
									{
										"name": "FisheyeDistortion",
										"size": 3444
									}
								]
							},
							{
								"name": "encoder",
								"children": [
									{
										"name": "ColorEncoder",
										"size": 3179
									},
									{
										"name": "Encoder",
										"size": 4060
									},
									{
										"name": "PropertyEncoder",
										"size": 4138
									},
									{
										"name": "ShapeEncoder",
										"size": 1690
									},
									{
										"name": "SizeEncoder",
										"size": 1830
									}
								]
							},
							{
								"name": "filter",
								"children": [
									{
										"name": "FisheyeTreeFilter",
										"size": 5219
									},
									{
										"name": "GraphDistanceFilter",
										"size": 3165
									},
									{
										"name": "VisibilityFilter",
										"size": 3509
									}
								]
							},
							{
								"name": "IOperator",
								"size": 1286
							},
							{
								"name": "label",
								"children": [
									{
										"name": "Labeler",
										"size": 9956
									},
									{
										"name": "RadialLabeler",
										"size": 3899
									},
									{
										"name": "StackedAreaLabeler",
										"size": 3202
									}
								]
							},
							{
								"name": "layout",
								"children": [
									{
										"name": "AxisLayout",
										"size": 6725
									},
									{
										"name": "BundledEdgeRouter",
										"size": 3727
									},
									{
										"name": "CircleLayout",
										"size": 9317
									},
									{
										"name": "CirclePackingLayout",
										"size": 12003
									},
									{
										"name": "DendrogramLayout",
										"size": 4853
									},
									{
										"name": "ForceDirectedLayout",
										"size": 8411
									},
									{
										"name": "IcicleTreeLayout",
										"size": 4864
									},
									{
										"name": "IndentedTreeLayout",
										"size": 3174
									},
									{
										"name": "Layout",
										"size": 7881
									},
									{
										"name": "NodeLinkTreeLayout",
										"size": 12870
									},
									{
										"name": "PieLayout",
										"size": 2728
									},
									{
										"name": "RadialTreeLayout",
										"size": 12348
									},
									{
										"name": "RandomLayout",
										"size": 870
									},
									{
										"name": "StackedAreaLayout",
										"size": 9121
									},
									{
										"name": "TreeMapLayout",
										"size": 9191
									}
								]
							},
							{
								"name": "Operator",
								"size": 2490
							},
							{
								"name": "OperatorList",
								"size": 5248
							},
							{
								"name": "OperatorSequence",
								"size": 4190
							},
							{
								"name": "OperatorSwitch",
								"size": 2581
							},
							{
								"name": "SortOperator",
								"size": 2023
							}
						]
					},
					{
						"name": "Visualization",
						"size": 16540
					}
				]
			}
		]
	};

	var root = json;
	completeCirclePackingD3Vis(root);
}
