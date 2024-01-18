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
/** REQUIRES: d3.js, dc.js and nvd3.js **/

function createScatterPlotNVD3Vis(container, data, width) {

	var checkformulti = {};
	var biggestcount = 0;
	data.forEach(function(d, i) {
		var series = d.values;
		for (var i=0; i<series.length; i++) {
			var next = series[i];
			next.y = decimalAdjust(parseFloat(next.y), 2);
			next.x = decimalAdjust(parseFloat(next.x), 2);
			var key = next.x+":"+next.y;
			if (checkformulti[key]){
				var val = checkformulti[key];
				checkformulti[key] = val+1;
			} else {
				checkformulti[key] = 1;
			}
			if (checkformulti[key] > biggestcount) {
				biggestcount = checkformulti[key];
			}
		}
	});

	var range1 = 1;
	var range2 = 1;
	if (biggestcount >= 3) {
		range1 = parseInt(biggestcount/3);
		range2 = parseInt(biggestcount/3)*2
	} else if (biggestcount == 2) {
		range1 = 1;
		range2 = 2;
	}

	data.forEach(function(d, i) {
		var series = d.values;
		for (var i=0; i<series.length; i++) {
			var next = series[i];

			key = next.x+":"+next.y;
			var count = checkformulti[key];
			if (count <= range1) {
				next.radius = 3.5;
			} else if (count > range1 && count <= range2) {
				next.radius = 5;
			} else if (count > range2) {
				next.radius = 7;
			}
		}
	});

	/** BRUSHING **/
	var brushCell;
	var size = width;
	var padding = 20;

	var x = d3.scale.linear().range([padding / 2, size - padding / 2]);
	var y = d3.scale.linear().range([size - padding / 2, padding / 2]);

	var domainByTrait = {};

	//var traits = d3.keys(data[0]).filter(function(d) { return d == "x" || d == "y"; });
	//var n = traits.length;
	//traits.forEach(function(trait) {
	//});

	domainByTrait["x"] = d3.extent(data, function(d) { return d.x; });
	domainByTrait["y"] = d3.extent(data, function(d) { return d.y; });

	var brush = d3.svg.brush()
	  .x(x)
	  .y(y)
	  .on("brushstart", brushstart)
	  .on("brush", brushmove)
	  .on("brushend", brushend);

	// Clear the previously-active brush, if any.
	function brushstart(p) {
		if (brushCell !== this) {
		  d3.select(brushCell).call(brush.clear());
		  //x.domain(domainByTrait["x"]);
		  //y.domain(domainByTrait["y"]);
		  brushCell = this;
		}
	}

	// Highlight the selected circles.
	function brushmove(p) {
		var e = brush.extent();
		d3.selectAll("circle").classed("hidden", function(d) {
			//alert(d.x+":"+d.y);

			alert(e[0][0]+":"+e[1][0]+":"+d.x);
			alert(e[0][1]+":"+e[1][1]+":"+d.y);

			var x = d.x+75;
			var y = d.y+30;
			var result = e[0][0] > x || x > e[1][0]
			  || e[0][1] > y || y > e[1][1];

			//alert(result);
			return result
		});
	}

	// If the brush is empty, select all circles.
	function brushend() {
		if (brush.empty()) {
			$('nodelistbox').update('<div style="float:left;margin-top:15px;"><?php echo $LNG->STATS_SCATTERPLOT_DETAILS_CLICK; ?></div>');
			d3.selectAll(".hidden").classed("hidden", false);
		} else {
			$('nodelistbox').update("");
			$('nodelistboxstats').update("");
			var checkit = new Array();
			var num = 0;
			var e = brush.extent();
			d3.selectAll("circle:not(.hidden)").each(function(d) {
				alert(d.id+":"+d.name);
				if (checkit.indexOf(d.id) == -1) {
					checkit.push(d.id);
					if (d.id != d.name) {
						addScatterPlotDetailItem(d.id, d.name, d.nodetype, d.homepage);
						num++;
					}
				}
			});

			$('nodelistboxstats').insert('<span><b>x:</b>'+decimalAdjust(e[0][0], 2)+'-'+decimalAdjust(e[1][0], 2)+' <b>y:</b> '+decimalAdjust(e[0][1], 2)+'-'+decimalAdjust(e[1][1], 2)+'</span>');
			$('nodelistboxstats').insert('<span style="padding-left:30px;"><b><?php echo $LNG->STATS_SCATTERPLOT_DETAILS_COUNT; ?></b> '+num+'</span>');
		}
	}


	/***************/

	var chart = nv.models.scatterChart()
		.showDistX(false)
		.showDistY(false)
		.transitionDuration(350)
		.color(["#282DF8"])
		.xPadding(0.05)
		.yPadding(0.05)
		.showLegend(false)
		.showXAxis(true)
		.showYAxis(true)
		.showControls(false)
		.tooltips(true);

	chart.tooltipContent(function(key, x, y, e, graph) {
		$('nodelistbox').update("");
		$('nodelistboxstats').update("");

      	var d = e.series.values[e.pointIndex];
  		var checkit = new Array();
		var series = e.series.values;
		var num = 0;
		for (var i=0; i<series.length; i++) {
			var next = series[i];
			if (checkit.indexOf(next.id) == -1) {
				checkit.push(next.id);
				if (next.x == x && next.y == y ) {
					addScatterPlotDetailItem(next.id, next.name, next.nodetype, next.homepage);
					num++;
				}
			}
		}

		//$('nodelistboxstats').insert('<span><b>x:</b> '+x+' <b>y:</b> '+y+'</span>');
		//$('nodelistboxstats').insert('<span style="padding-left:30px;"><b><?php echo $LNG->STATS_SCATTERPLOT_DETAILS_COUNT; ?></b> '+num+'</span>');
		$('nodelistboxstats').insert('<span><b><?php echo $LNG->STATS_SCATTERPLOT_DETAILS_COUNT; ?></b> '+num+'</span>');

        return '<h3><?php echo $LNG->STATS_SCATTERPLOT_DETAILS_COUNT; ?> ' +num+ '</h3>';
	});

	chart.xAxis.tickFormat(d3.format('.02f'));
	chart.yAxis.tickFormat(d3.format('.02f'));
	chart.useVoronoi(false); // otherwise it messes up ultiple points in one place.
	chart.scatter.onlyCircles(true);

	var svg = d3.select(container).append("svg");
	//svg.call(brush);

	svg.datum(data).call(chart);

	// FORCE DOTS APART
	function tick(e) {
		var node = svg.selectAll("circle");

		node.each(moveTowardDataPosition(e.alpha));
		//if (checkbox.node().checked)
		node.each(collide(e.alpha));
		node.attr("cx", function(d) { return d.x; })
			.attr("cy", function(d) { return d.y; });
	}

	function moveTowardDataPosition(alpha) {
		return function(d) {
		  d.x += (x(d.x) - d.x) * 0.1 * alpha;
		  d.y += (y(d.y) - d.y) * 0.1 * alpha;
		};
	}

	function collide(alpha) {
		var radius = 6;
		var padding = 1;
		var quadtree = d3.geom.quadtree(data);
		return function(d) {
		  var r = d.radius + radius + padding,
			  nx1 = d.x - r,
			  nx2 = d.x + r,
			  ny1 = d.y - r,
			  ny2 = d.y + r;
		  quadtree.visit(function(quad, x1, y1, x2, y2) {
			if (quad.point && (quad.point !== d)) {
			  var x = d.x - quad.point.x,
				  y = d.y - quad.point.y,
				  l = Math.sqrt(x * x + y * y),
				  r = d.radius + quad.point.radius + (d.color !== quad.point.color) * padding;
			  if (l < r) {
				l = (l - r) / l * alpha;
				d.x -= x *= l;
				d.y -= y *= l;
				quad.point.x += x;
				quad.point.y += y;
			  }
			}
			return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
		  });
		};
	}

	var thiswidth = size - padding / 2;
 	var force = d3.layout.force()
    	.nodes(data)
    	.size([thiswidth, thiswidth])
    	.on("tick", tick)
    	.charge(-1)
    	.gravity(0)
    	.chargeDistance(20);
	//force.start();

	nv.utils.windowResize(chart.update);
	nv.addGraph(chart);
}

function decimalAdjust(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function addScatterPlotDetailItem(nodeid, nodename, nodetype, homepage) {
	if (nodeid != nodename) {
		next = new Element("span", {
			'style':'float:left;clear:both;margin-top:10px;'});

		if (nodetype) {
			var img = new Element("img", {'style':'vertical-align:middle;padding-right:5px'});
			if (nodetype == 'Challenge') {
				img.src = '<?php echo $CFG->challengeicon; ?>';
			} else if (nodetype == 'Argument') {
				img.src = '<?php echo $CFG->argumenticon; ?>';
			} else if (nodetype == 'Issue') {
				img.src = '<?php echo $CFG->issueicon; ?>';
			} else if (nodetype == 'Solution') {
				img.src = '<?php echo $CFG->solutionicon; ?>';
			} else if (nodetype == 'Pro') {
				img.src = '<?php echo $CFG->proicon; ?>';
			} else if (nodetype == 'Con') {
				img.src = '<?php echo $CFG->conicon; ?>';
			} else if (nodetype == 'Idea') {
				img.src = '<?php echo $CFG->commenticon; ?>';
			} else {
				img.src = '<?php echo $CFG->solutionicon; ?>';
			}
			next.insert(img);
		}

		next.insert(nodename);
		if (homepage && homepage != "") {
			next.className = "active";
			Event.observe(next,'click',function (){
				loadDialog('details', homepage, 1024,768);
			});
		}
	} else {
		next = new Element("span", {
			'style':'float:left;clear:both;margin-top:10px;'});
		next.insert(nodename);
	}
	$('nodelistbox').insert(next);
}

function createScatterPlotMatrixD3Vis(container, data, width) {

	var size = 150;
	var padding = 19.5;

	var x = d3.scale.linear().range([padding / 2, size - padding / 2]);
	var y = d3.scale.linear().range([size - padding / 2, padding / 2]);

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")
		.ticks(5);

	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		.ticks(5);

	var color = d3.scale.category10();

	var domainByTrait = {};
	var traits = d3.keys(data[0]).filter(function(d) { return d !== "name" && d !== "id" && d !== "nodetype"; });
	var n = traits.length;

	traits.forEach(function(trait) {
		domainByTrait[trait] = d3.extent(data, function(d) { return d[trait]; });
	});

	xAxis.tickSize(size * n);
	yAxis.tickSize(-size * n);

	var svg = d3.select(container).append("svg")
	  .attr("width", size * n + padding)
	  .attr("height", size * n + padding)
	  .append("g")
	  .attr("transform", "translate(" + padding + "," + padding / 2 + ")");

	var brush = d3.svg.brush()
	  .x(x)
	  .y(y)
	  .on("brushstart", brushstart)
	  .on("brush", brushmove)
	  .on("brushend", brushend);

	svg.selectAll(".x.axis")
	  .data(traits)
	  .enter().append("g")
	  .attr("class", "x axis")
	  .attr("transform", function(d, i) { return "translate(" + (n - i - 1) * size + ",0)"; })
	  .each(function(d) { x.domain(domainByTrait[d]); d3.select(this).call(xAxis); });

	svg.selectAll(".y.axis")
	  .data(traits)
	  .enter().append("g")
	  .attr("class", "y axis")
	  .attr("transform", function(d, i) { return "translate(0," + i * size + ")"; })
	  .each(function(d) { y.domain(domainByTrait[d]); d3.select(this).call(yAxis); });

	var cell = svg.selectAll(".cell")
	  .data(cross(traits, traits))
	  .enter().append("g")
	  .attr("class", "cell")
	  .attr("transform", function(d) { return "translate(" + (n - d.i - 1) * size + "," + d.j * size + ")"; })
	  .each(plot);

	cell.call(brush);

	// Titles for the diagonal.
	cell.filter(function(d) { return d.i === d.j; }).append("text")
	  .attr("x", padding)
	  .attr("y", padding)
	  .attr("dy", ".71em")
	  .text(function(d) { return d.x; });

	function plot(p) {
		var cell = d3.select(this);

		x.domain(domainByTrait[p.x]);
		y.domain(domainByTrait[p.y]);

		cell.append("rect")
			.attr("class", "frame")
			.attr("x", padding / 2)
			.attr("y", padding / 2)
			.attr("width", size - padding)
			.attr("height", size - padding);

		cell.selectAll("circle")
			.data(data)
		    .enter().append("circle")
			.attr("cx", function(d) { return x(d[p.x]); })
			.attr("cy", function(d) { return y(d[p.y]); })
			.attr("r", 3)
			.style("fill", function(d) { return color(d.name); });
	}

	var brushCell;

	// Clear the previously-active brush, if any.
	function brushstart(p) {
		if (brushCell !== this) {
		  svg.select(brushCell).call(brush.clear());
		  x.domain(domainByTrait[p.x]);
		  y.domain(domainByTrait[p.y]);
		  brushCell = this;
		}
	}

	// Highlight the selected circles.
	function brushmove(p) {
		var e = brush.extent();
		keepitArray = new Array();
		checkit = new Array();

		svg.selectAll("circle").classed("hidden", function(d) {
			return e[0][0] > d[p.x] || d[p.x] > e[1][0]
			  || e[0][1] > d[p.y] || d[p.y] > e[1][1];
		});
	}

	// If the brush is empty, select all circles.
	function brushend() {
		if (brush.empty()) {
			$('nodelistbox').update('<div style="float:left;margin-top:15px;"><?php echo $LNG->STATS_SCATTERPLOT_DETAILS_CLICK; ?></div>');
			svg.selectAll(".hidden").classed("hidden", false);
		} else {
			$('nodelistbox').update("");
			var checkit = new Array();
			svg.selectAll("circle:not(.hidden)").each(function(d) {
				var next;
				if (checkit.indexOf(d.id) == -1) {
					checkit.push(d.id);
					if (d.id != d.name) {
						next = new Element("span", {
							'style':'float:left;clear:both;margin-top:10px;',
							'class':'active'});

						if (d.nodetype) {
							var img = new Element("img", {'style':'vertical-align:middle;padding-right:5px'});
							if (d.nodetype == 'Challenge') {
								img.src = '<?php echo $CFG->challengeicon; ?>';
							} else if (d.nodetype == 'Issue') {
								img.src = '<?php echo $CFG->issueicon; ?>';
							} else if (d.nodetype == 'Solution') {
								img.src = '<?php echo $CFG->solutionicon; ?>';
							} else if (d.nodetype == 'Argument') {
								img.src = '<?php echo $CFG->argumenticon; ?>';
							} else if (d.nodetype == 'Pro') {
								img.src = '<?php echo $CFG->proicon; ?>';
							} else if (d.nodetype == 'Con') {
								img.src = '<?php echo $CFG->conicon; ?>';
							} else if (d.nodetype == 'Idea') {
								img.src = '<?php echo $CFG->commenticon; ?>';
							} else {
								img.src = '<?php echo $CFG->solutionicon; ?>';
							}
							next.insert(img);
						}

						next.insert(d.name);
						Event.observe(next,'click',function (){
							loadDialog('details', URL_ROOT+"explore.php?id="+d.id, 1024,768);
						});
					} else {
						next = new Element("span", {
							'style':'float:left;clear:both;margin-top:10px;'});
						next.insert(d.name);
					}
					$('nodelistbox').insert(next);
				}
			});
		}
	}

	function cross(a, b) {
		var c = [], n = a.length, m = b.length, i, j;
		for (i = -1; ++i < n;)
			for (j = -1; ++j < m;)
				c.push({x: a[i], i: i, y: b[j], j: j});
		return c;
	}
}

function createScatterPlotNVD3Test(groups, points) { //# groups,# points per group
  var data = [],
	  shapes = ['circle', 'cross', 'triangle-up', 'triangle-down', 'diamond', 'square'],
	  random = d3.random.normal();

  for (i = 0; i < groups; i++) {
	data.push({
	  key: 'Group ' + i,
	  values: []
	});

	for (j = 0; j < points; j++) {
	  data[i].values.push({
		x: random()
	  , y: random()
	  , size: Math.random()   //Configure the size of each scatter point
	  , shape: (Math.random() > 0.95) ? shapes[j % 6] : "circle"  //Configure the shape of each scatter point.
	  });
	}
  }

  return data;
}

function displayScatterPlotMatrixD3VisTest(container, width) {

	//init data
	var data = [
		{
		 "sepal length":"5.1",
		 "sepal width":"3.5",
		 "petal length":"1.4",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.9",
		 "sepal width":"3.0",
		 "petal length":"1.4",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.7",
		 "sepal width":"3.2",
		 "petal length":"1.3",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.6",
		 "sepal width":"3.1",
		 "petal length":"1.5",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"5.0",
		 "sepal width":"3.6",
		 "petal length":"1.4",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"5.4",
		 "sepal width":"3.9",
		 "petal length":"1.7",
		 "petal width":"0.4",
		 "name":"setosa"
		},
		{
		 "sepal length":"5.4",
		 "sepal width":"3.9",
		 "petal length":"1.7",
		 "petal width":"0.4",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.6",
		 "sepal width":"3.4",
		 "petal length":"1.4",
		 "petal width":"0.3",
		 "name":"setosa"
		},
		{
		 "sepal length":"5.0",
		 "sepal width":"3.4",
		 "petal length":"1.5",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.4",
		 "sepal width":"2.9",
		 "petal length":"1.4",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.9",
		 "sepal width":"3.1",
		 "petal length":"1.3",
		 "petal width":"0.1",
		 "name":"setosa"
		},
		{
		 "sepal length":"5.4",
		 "sepal width":"3.7",
		 "petal length":"1.5",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.8",
		 "sepal width":"3.4",
		 "petal length":"1.6",
		 "petal width":"0.2",
		 "name":"setosa"
		},
		{
		 "sepal length":"4.8",
		 "sepal width":"3.0",
		 "petal length":"1.4",
		 "petal width":"0.1",
		 "name":"setosa"
		}
	];

	createScatterPlotD3Vis(container, data, width);
}