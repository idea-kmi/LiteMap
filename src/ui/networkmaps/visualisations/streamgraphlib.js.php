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

function displayStreamGraphNVD3Vis(container, data, width) {

	var color = d3.scale.linear()
		.domain([-1, 5])
		.range(["hsl(152,80%,80%)", "hsl(228,30%,40%)"])
		.interpolate(d3.interpolateHcl);

	var formatDate = d3.time.format('%d/%m/%y');

	data.forEach(function(d, i) {
		if (!d.color) {
			if (d.key == getNodeTitleAntecedence("Pro", false)) {
				d.color = "#A9C89E";
			} else if (d.key == getNodeTitleAntecedence("Con", false)) {
				d.color = "#D46A6A";
			} else if (d.key == getNodeTitleAntecedence("Solution", false)) {
				d.color = "#A4AED4";
			} else if (d.key == "Idea") {
				d.color = "#A4AED4";
			} else if (d.key == getNodeTitleAntecedence("Issue", false)) {
				d.color = "#DFC7EB";
			} else if (d.key == "<?php echo $LNG->ARGUMENT_NAME; ?>") {
				d.color = "#E1E353";
			} else if (d.key == getNodeTitleAntecedence("Challenge", false)) {
				d.color = "<?php echo $CFG->challengebackpale; ?>";
			} else if (d.key == getNodeTitleAntecedence("Map", false)) {
				d.color = "<?php echo $CFG->claimbackpale; ?>";
			} else {
				d.color = d.children ? color(d.depth) : null;
			}
		}
		var series = d.values;
		for (var i=0; i<series.length; i++) {
			var next = series[i];
			var date = next[0];
			date = formatDate.parse(date).getTime();
			next[0] = date;
		}
	});

	var chart = nv.models.stackedAreaChart()
		  .margin({right: 100})
		  .x(function(d) { return d[0] })   //We can modify the data accessor functions...
		  .y(function(d) { return d[1] })   //...in case your data is formatted differently.
		  .useInteractiveGuideline(true)    //Tooltips which show all data points. Very nice!
		  .rightAlignYAxis(true)      //Lets move the y-axis to the right side.
		  .transitionDuration(500)
		  .showControls(true)       //Allow user to choose 'Stacked', 'Stream', 'Expanded' mode.
		  .clipEdge(true);

  	chart.xAxis
        .tickFormat(function(d) {
          return d3.time.format('%d/%m/%y')(new Date(d))
    });

	chart.yAxis
		.tickFormat(d3.format('d'));

	d3.select(container).append("svg")
	  .datum(data)
	  .call(chart);

	nv.utils.windowResize(chart.update);
	nv.addGraph(chart);
}

function createStreamGraphD3Vis(container, data, width) {

	//alert(data.toSource());

	var datearray = [];
	var colorrange = ["<?php echo $CFG->claimbackpale; ?>",
					"<?php echo $CFG->challengebackpale; ?>",
					"#DFC7EB",
					"#A4AED4",
					"#A9C89E",
					"#D46A6A"
					];

	strokecolor = colorrange[0];

	var format = d3.time.format("%d/%m/%y");

	var margin = {top: 40, right: 50, bottom: 80, left: 30};
	var width = width - margin.left - margin.right - 50;
	var height = 400 - margin.top - margin.bottom;

	/*
	var tooltip = d3.select(container)
		.append("div")
		.attr("class", "remove")
		.style("position", "relative")
		.style("z-index", "20")
		.style("display", "none")
		.style("top", "30px")
		.style("left", "55px");
	*/

	var x = d3.time.scale().range([0, width]);
	var y = d3.scale.linear().range([height-10, 0]);
	var z = d3.scale.ordinal().range(colorrange);

	/*var x = d3.time.scale()
	    .domain([new Date(data[0].date), d3.time.day.offset(new Date(data[data.length - 1].date), 1)])
	    .rangeRound([0, width - margin.left - margin.right]);*/

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")
		.ticks(d3.time.week)
		.tickFormat(d3.time.format('%d / %m / %y'));


	var yAxis = d3.svg.axis().scale(y);

	var yAxisr = d3.svg.axis().scale(y);

	var stack = d3.layout.stack()
		.offset("silhouette ")
		.values(function(d) { return d.values; })
		.x(function(d) { return d.date; })
		.y(function(d) { return d.value; });

	var nest = d3.nest().key(function(d) { return d.key; });

	var area = d3.svg.area()
		.interpolate("cardinal")
		.x(function(d) { return x(d.date); })
		.y0(function(d) { return y(d.y0); })
		.y1(function(d) { return y(d.y0 + d.y); });

	var svg = d3.select(container).append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
	  	.append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    /*var tooltip = d3.tip()
		.attr('class', 'd3-tip')
		.offset([0, 0])
		.html(function(d) {
			var hint = '<div class="selectedback" style="padding:2px;border:1px solid dimgray">';
			hint += d.key+": "+d.value;
			hint += '</div>';
			return hint;
		});
    svg.call(tooltip);
    */

	data.forEach(function(d) {
		d.date = format.parse(d.date);
		d.value = +d.value;
	});

	var layers = stack(nest.entries(data));

	x.domain(d3.extent(data, function(d) { return d.date; }));
	y.domain([0, d3.max(data, function(d) { return d.y0 + d.y; })]);

	svg.selectAll(".layer")
	  	.data(layers)
		.enter().append("path")
	  	.attr("class", "layer")
	  	.attr("d", function(d) { return area(d.values); })
	  	.style("fill", function(d, i) { return z(i); });

	// Draw the axis lines
	svg.append("g")
	  	.attr("class", "x streamaxis")
	  	.attr("transform", "translate(0," + height + ")")
	  	.call(xAxis)
	  	.selectAll("text")
		            .style("text-anchor", "end")
		            .attr("dx", "-1.8em")
		            .attr("dy", ".15em")
		            .attr("transform", function(d) {
		                return "rotate(-90)"
                });

	/*svg.append("g")
	  	.attr("class", "y streamaxis")
	  	.attr("transform", "translate(" + width + ", 0)")
	  	.call(yAxis.orient("right"));

	svg.append("g")
	  	.attr("class", "y streamaxis")
	  	.call(yAxis.orient("left"));
	  	*/

	svg.selectAll(".layer")
		.attr("opacity", 1)
		.on("mouseover", function(d, i) {
	  		svg.selectAll(".layer").transition()
				.duration(250)
				.attr("opacity", function(d, j) {
					return j != i ? 0.6 : 1;
				})
		})
		.on("mousemove", function(d, i) {
		  mousex = d3.mouse(this);
		  mousex = mousex[0];
		  var invertedx = x.invert(mousex);
		  invertedx = invertedx.getMonth() + invertedx.getDate();
		  var selected = (d.values);
		  for (var k = 0; k < selected.length; k++) {
			datearray[k] = selected[k].date
			datearray[k] = datearray[k].getMonth() + datearray[k].getDate();
		  }

		  var mousedate = datearray.indexOf(invertedx);
		  if (d.values[mousedate]) {
			  //var pro = d.values[mousedate].value;

			 //var temp = {"key":d.key, "value":pro};

  			  //tooltip.show(temp);

			  //d3.select(this)
			  //.classed("hover", true)
			  //.attr("stroke", strokecolor)
			  //.attr("stroke-width", "0.5px"),
			  //tooltip.html( "<p>" + d.key + ": " + pro + "</p>" ).style("display", "block");
		   }
		})
		.on("mouseout", function(d, i) {
			svg.selectAll(".layer")
			.transition()
			.duration(250)
			.attr("opacity", "1");

			//tooltip.hide(d);
		});


	var vertical = d3.select(".chart")
		.append("div")
		.attr("class", "remove")
		.style("position", "absolute")
		.style("z-index", "19")
		.style("width", "1px")
		.style("height", "380px")
		.style("top", "10px")
		.style("bottom", "30px")
		.style("left", "0px")
		.style("background", "#fff");


	d3.select(".chart")
	  .on("mousemove", function(){
		 mousex = d3.mouse(this);
		 mousex = mousex[0] + 5;
		 vertical.style("left", mousex + "px" )})
	  .on("mouseover", function(){
		 mousex = d3.mouse(this);
		 mousex = mousex[0] + 5;
		 vertical.style("left", mousex + "px")});


	/** LEGEND **/
	var legend = d3Legend();
	legend
		.color(colorrange)
		.width(width)
		.height(30);

	legend.dispatch.on('legendClick', function(d, i) {
		//d.disabled = !d.disabled;

		//if (!data.filter(function(d) { return !d.disabled }).length) {
	  	//	data.forEach(function(d) {
		//		d.disabled = false;
	  	//	});
		//}

		//selection.transition().call(chart)
	});

	legend.dispatch.on('legendMouseover', function(d, i) {
		//d.hover = true;
		//selection.transition().call(chart)
	});

	legend.dispatch.on('legendMouseout', function(d, i) {
		//d.hover = false;
		//selection.transition().call(chart)
	});

	var legendData = flatten(data)
	var priorities = ['Map', 'Challenge', 'Issue', 'Solution', 'Pro', 'Con'];
	var nest = d3.nest().key(function(d) { alert(d.toSource()); return d.value; })
		.sortKeys(function(a,b) { return priorities.indexOf(a) - priorities.indexOf(b); })

    svg.append('g').attr('class', 'legendWrap');
	svg.select('.legendWrap')
          .datum(nest.entries(legendData))
          .attr('transform', 'translate(' + -((diameter/2)-150) + ',' + -((diameter/2)+5) +')')
          .call(legend);
}

function displayStreamGraphD3Vis(container, data, width) {
	createStreamGraphD3Vis(container, data, width);
}

function displayStreamGraphD3VisTest(container, width) {

	//init data
	var data = [
		{
		 "key":"AR",
		 "value":"0.1",
		 "date":"01/08/13",
		},
		{
		 "key":"AR",
		 "value":"0.15",
		 "date":"01/09/13",
		},
		{
		 "key":"AR",
		 "value":"0.35",
		 "date":"01/10/13",
		},
		{
		 "key":"AR",
		 "value":"0.38",
		 "date":"01/11/13",
		},
		{
		 "key":"AR",
		 "value":"0.22",
		 "date":"01/12/13",
		},
		{
		 "key":"AR",
		 "value":"0.16",
		 "date":"01/13/13",
		},
		{
		 "key":"AR",
		 "value":"0.7",
		 "date":"01/14/13",
		},
		{
		 "key":"DJ",
		 "value":"0.35",
		 "date":"01/08/13",
		},
		{
		 "key":"DJ",
		 "value":"0.36",
		 "date":"01/09/13",
		},
		{
		 "key":"DJ",
		 "value":"0.37",
		 "date":"01/10/13",
		},
		{
		 "key":"DJ",
		 "value":"0.22",
		 "date":"01/11/13",
		},
		{
		 "key":"DJ",
		 "value":"0.24",
		 "date":"01/12/13",
		},
		{
		 "key":"DJ",
		 "value":"0.26",
		 "date":"01/13/13",
		},
		{
		 "key":"DJ",
		 "value":"0.34",
		 "date":"01/14/13",
		},
		{
		 "key":"MS",
		 "value":"0.21",
		 "date":"01/08/13",
		},
		{
		 "key":"MS",
		 "value":"0.25",
		 "date":"01/09/13",
		},
		{
		 "key":"MS",
		 "value":"0.27",
		 "date":"01/10/13",
		},
		{
		 "key":"MS",
		 "value":"0.23",
		 "date":"01/11/13",
		},
		{
		 "key":"MS",
		 "value":"0.24",
		 "date":"01/12/13",
		},
		{
		 "key":"MS",
		 "value":"0.21",
		 "date":"01/13/13",
		},
		{
		 "key":"MS",
		 "value":"0.35",
		 "date":"01/14/13",
		},
	];

	createStreamGraphD3Vis(container, data, width);
}