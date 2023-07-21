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

	var sunburst;
	var rootnode = "";

  	function createNewSunburstGraph(containername, detailpanelname) {

  		sunburst = new $jit.Sunburst({

			//id container for the visualization
			injectInto: containername,

			//Change node and edge styles such as
			//color, width, lineWidth and edge types
			Node: {
				overridable: true,
				type: useGradients? 'gradient-multipie' : 'multipie',
				isuser: 'N',
				oriobj: null,
				realname: '',
				procount: 0,
				concount: 0,
				ideacount: 0,
				debatecount: 0,
				realname: '',
				details:'',
			},
			Edge: {
				overridable: true,
				type: 'hyperline',
				lineWidth: 2,
				color: '#777',
				procount: 0,
				concount: 0,
				ideacount: 0,
				debatecount: 0,
			},

			//Draw canvas text. Can also be
		  	//'HTML' or 'SVG' to draw DOM labels
		  	Label: {
				type: nativeTextSupport? 'Native' : 'SVG',
		  	},
		  	//Add animations when hovering and clicking nodes
		  	NodeStyles: {
				enable: true,
				type: 'Native',
				stylesClick: {
				  'color': '#C0C000'
				},
				stylesHover: {
				  'color': '#C0C000'
				},
				duration: 700
		  	},
		  	Events: {
				enable: true,
				type: 'Native',

				onClick: function(node, eventInfo, e){
					if (!node) {
						return;
					}

					//alert("Clicked");

					//var isLink = node.nodeFrom ? true : false;
					//if (isLink) {
					//	$(detailpanelname).innerHTML = "I am a link";
					//} else {
			            //rotate
			            sunburst.rotate(node, animate? 'animate' : 'replot', {
			              	duration: 500,
			              	transition: $jit.Trans.Quart.easeInOut
			            });

						if (node.getData('details') && node.getData('details') != "") {
							//alert("cached details used");
							$(detailpanelname).innerHTML = node.getData('details');
						} else {
							var html = "<h4>" +node.name+ ": "+ node.getData('realname') + "</h4>";
							var ans = [];

							var html = "";
							if (node.getData('isuser') == 'Y') {
								html += '<h4>'+node.name+': <a href="<?php echo $CFG->homeAddress; ?>user.php?userid='+node.id+'">'+node.getData('realname')+'</a></h4>';

								var str = "";
								html += '<h4><?php echo $LNG->STATS_GROUP_SUNBURST_CREATED; ?></h4>';
								var userprocount = parseInt(node.getData('procount'));
								var userconcount = parseInt(node.getData('concount'));
								var userideacount = parseInt(node.getData('ideacount'));
								var userdebatecount = parseInt(node.getData('debatecount'));
								if (userdebatecount && userdebatecount > 0) {
									if (str != "") str += "<br>";
									str += '<span style="color:purple;font-size:9pt;font-weight:bold"><span>'+userdebatecount+' ';
									if (userdebatecount == 1) {
										str += '<?php echo $LNG->ISSUE_NAME; ?>';
									} else {
										str += '<?php echo $LNG->ISSUES_NAME; ?>';
									}
									str += '</span>';
								}
								if (userprocount && userprocount > 0) {
									if (str != "") str += "<br>";
									str += '<span style="color:green;font-size:9pt;font-weight:bold">'+userprocount+' ';
									if (userprocount == 1) {
										str += '<?php echo $LNG->PRO_NAME; ?>';
									} else {
										str += '<?php echo $LNG->PROS_NAME; ?>';
									}
									str += '</span>';
								}
								if (userconcount && userconcount > 0) {
									if (str != "") str += "<br>";
									str += '<span style="color:red;font-size:9pt;font-weight:bold">'+userconcount+' ';
									if (userconcount == 1) {
										str += '<?php echo $LNG->CON_NAME; ?>';
									} else {
										str += '<?php echo $LNG->CONS_NAME; ?>';
									}
									str += '</span>';
								}
								if (userideacount && userideacount > 0) {
									if (str != "") str += "<br>";
									str += '<span style="color:black;font-size:9pt;font-weight:bold"><span>'+userideacount+' ';
									if (userideacount == 1) {
										str += '<?php echo $LNG->SOLUTION_NAME; ?>';
									} else {
										str += '<?php echo $LNG->SOLUTIONS_NAME; ?>';
									}
									str += '</span>';
								}
								html += str;
								html += '<h4><?php echo$LNG->STATS_GROUP_SUNBURST_CONNECTED_USER; ?></h4>';
							} else {
								html += '<h4>'+node.name+': <a href="<?php echo $CFG->homeAddress; ?>explore.php?id='+node.id+'">'+node.getData('realname')+'</a></h4>';
								html += '<h4><?php echo$LNG->STATS_GROUP_SUNBURST_CONNECTED_DEBATE; ?></h4>';
							}

							html += '<ul><li style="padding-bottom:10px;">';

							node.eachAdjacency(function(adj){
								// if on the same level i.e siblings
								if (adj.nodeTo._depth == node._depth) {
									var toNode = adj.nodeTo;
									var realname = toNode.getData('realname');
									var id = toNode.id;
									var str = '';

									var procount = parseInt(adj.getData('procount'));
									var concount = parseInt(adj.getData('concount'));
									var ideacount = parseInt(adj.getData('ideacount'));
									var debatecount = parseInt(adj.getData('debatecount'));
									if (debatecount && debatecount > 0) {
										str += '<br>';
										str += '<span style="color:purple;font-size:9pt;font-weight:bold">'+debatecount+' ';
										if (debatecount == 1) {
											str += '<?php echo $LNG->ISSUE_NAME; ?>';
										} else {
											str += '<?php echo $LNG->ISSUES_NAME; ?>';
										}
										str += '</span>';
									}
									if (procount && procount > 0) {
										str += '<br>';
										str += '<span style="color:green;font-size:9pt;font-weight:bold">'+procount+' ';
										if (procount == 1) {
											str += '<?php echo $LNG->PRO_NAME; ?>';
										} else {
											str += '<?php echo $LNG->PROS_NAME; ?>';
										}
										str += '</span>';
									}
									if (concount && concount > 0) {
										str += '<br>';
										str += '<span style="color:red;font-size:9pt;font-weight:bold">'+concount+' ';
										if (concount == 1) {
											str += '<?php echo $LNG->CON_NAME; ?>';
										} else {
											str += '<?php echo $LNG->CONS_NAME; ?>';
										}
										str += '</span>';
									}
									if (ideacount && ideacount > 0) {
										str += '<br>';
										str += '<span style="color:black;font-size:9pt;font-weight:bold">'+ideacount+' ';
										if (ideacount == 1) {
											str += '<?php echo $LNG->SOLUTION_NAME; ?>';
										} else {
											str += '<?php echo $LNG->SOLUTIONS_NAME; ?>';
										}
										str += '</span>';
									}

									var link = "";
									if (toNode.getData('isuser') == 'Y') {
										link = '<b>'+toNode.name+':</b> <a href="<?php echo $CFG->homeAddress; ?>user.php?userid='+id+'">'+realname+'</a>';
									} else {
										link = '<b>'+toNode.name+':</b> <a href="<?php echo $CFG->homeAddress; ?>explore.php?id='+id+'">'+realname+'</a>';
									}

									if (str != "") {
										str = link+'<br><b><?php echo $LNG->STATS_GROUP_SUNBURST_WITH; ?></b>'+str;
									} else {
										str = link;
									}

									ans.push(str);
								}
							});

							html += ans.join("</li><li style='padding-bottom:10px;'>") + "</li></ul>";
							node.setData('details', html);

							$(detailpanelname).innerHTML = html;
						}
					//}
				}
		  	},

      		levelDistance: 190,

			// Only used when Label type is 'HTML' or 'SVG'
			// Add text to the labels.
			// This method is only triggered on label creation
			onCreateLabel: function(domElement, node){
				var labels = sunburst.config.Label.type;
				if (labels === 'HTML') {
					domElement.innerHTML = node.name;
				} else if (labels === 'SVG') {
					domElement.firstChild.appendChild(document.createTextNode(node.name));
				}
			},
			// Only used when Label type is 'HTML' or 'SVG'
			// Change node styles when labels are placed
			// or moved.
			onPlaceLabel: function(domElement, node){
				var labels = sunburst.config.Label.type;
				if (labels === 'SVG') {
					var fch = domElement.firstChild;
			  		var style = fch.style;
			  		style.display = '';
			  		style.cursor = 'pointer';
			  		style.fontSize = "1.0em";
			  		fch.setAttribute('fill', "#000");
				} else if (labels === 'HTML') {
			  		var style = domElement.style;
			  		style.display = '';
			  		style.cursor = 'pointer';
			  		if (node._depth <= 1) {
						style.fontSize = "1.0em";
						style.color = "#000";
			  		}
			  		var left = parseInt(style.left);
			  		var w = domElement.offsetWidth;
			  		style.left = (left - w / 2) + 'px';
				}
			}
		});

		// add root node
		rootnode = {
			"data": {
				"$type": 'none',
			},
			"id": 'root',
			"name": '',
		};
		var rootNode = sunburst.graph.addNode(rootnode)
		sunburst.root = 'root';

		return sunburst;
	}

var checkNodes = new Array();

/**
 * Add the given connection to the given graph
 */
function addRootConnectionToSunburst(fromid, toid, sunburstGraph) {
	var graph = sunburstGraph.graph;
	if (graph.hasNode(fromid) && graph.hasNode(toid)) {
		var fromNode = graph.getNode(fromid);
		var toNode = graph.getNode(toid);
		var data = {
			"$type":"none"
		};
		graph.addAdjacence(fromNode, toNode, data);
	}
}

/**
 * Add the given connection to the given graph
 */
function addConnectionToSunburst(biggestcontribution, con, sunburstGraph) {
	var graph = sunburstGraph.graph;
	if (con) {
		var	procount = parseInt(con.procount);
		var concount = parseInt(con.concount);
		var ideacount = parseInt(con.ideacount);
		var debatecount = parseInt(con.debatecount);
		var linklabelname = con.linklabelname;

		var	toid = con.toid;
		var fromid = con.fromid;

		//alert(fromid+":"+toid);

		if (graph.hasNode(fromid) && graph.hasNode(toid)) {

			//alert("from and to found");

			var fromNode = graph.getNode(fromid); //node
			var toNode = graph.getNode(toid); //user

			var lineWidth = 2;
			var totalCreationsCount = procount+concount+ideacount+debatecount;

			//alert(totalCreationsCount);
			//alert(biggestcontribution);

			var percentageslice = parseFloat((totalCreationsCount / biggestcontribution) * 100);

			//alert(percentageslice);

			percentageslice = percentageslice.toFixed(2);

			if (biggestcontribution <= 5) {
				lineWidth = totalCreationsCount;
			} else {
				if (percentageslice <= 20) {
					lineWidth = 1;
				} else if (percentageslice > 20 && percentageslice <= 40) {
					lineWidth = 2;
				} else if (percentageslice > 40 && percentageslice <= 60) {
					lineWidth = 3;
				} else if (percentageslice > 60 && percentageslice <= 80) {
					lineWidth = 4;
				} else if (percentageslice > 80 && percentageslice <= 100) {
					lineWidth = 5;
				}
			}

			var linkcolour = "#808080";
			if (linklabelname == "<?php echo $CFG->LINK_PRO_SOLUTION; ?>") {
				linkcolour = "#00BD53";
			} else if (linklabelname == "<?php echo $CFG->LINK_CON_SOLUTION; ?>") {
				linkcolour = "#C10031";
			} /*else if (linklabelname == "owner") {
				linkcolour = "#800080";
			} */

			var data = {
				"$color": linkcolour,
				"$lineWidth": lineWidth,
				"$procount": procount,
				"$concount": concount,
				"$ideacount": ideacount,
				"$debatecount": debatecount,
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
function addNodeToSunburst(node, sunburstGraph, width, i) {

	var graph = sunburstGraph.graph;
	if (node) {
		if (!checkNodes[node.nodeid]) {
			var name = node.name;

			var nodeHEX = issuebackpale;
			var height = 75;
			if (i % 2) {
				height = 70;
				//nodeHEX = orgbackpale;
			}

			var thisnode = {
				"data": {
					"$angularWidth": width,
					"$color": nodeHEX,
					"$height": height,
					"$isuser": 'N',
					"$oriobj": node,
					"$realname": node.name,
					"$details": '',
				},
				"id": node.nodeid,
				"name": '<?php echo $LNG->STATS_GROUP_SUNBURST_DEBATE; ?>'+" "+i,
			};
			var next = graph.addNode(thisnode);
			checkNodes[node.nodeid] = node.nodeid;

			// connect to root node
			addRootConnectionToSunburst(sunburstGraph.root, node.nodeid, sunburstGraph);

			return next;
		}
	}

	return false;
}

/**
 * Add the given user to the given graph
 */
function addUserToSunburst(user, sunburstGraph, width, i) {

	var graph = sunburstGraph.graph;
	if (user) {
		if (!checkNodes[user.userid]) {
			var name = user.name;
			var	nodeHEX = peoplebackpale;
			var height = 85;
			if (i % 2) {
				height = 80;
				//nodeHEX = challengebackpale;
			}

			var procount = user.procount;
			var concount = user.concount;
			var ideacount = user.ideacount;
			var debatecount = user.debatecount;

			var thisnode = {
				"data": {
					"$angularWidth": width,
					"$color": nodeHEX,
					"$height": height,
					"$isuser": 'Y',
					"$oriobj": user,
					"$realname": name,
					"$procount": procount,
					"$concount": concount,
					"$ideacount": ideacount,
					"$debatecount": debatecount,
					"$details": '',
				},
				"id": user.userid,
				"name": '<?php echo $LNG->STATS_GROUP_SUNBURST_PERSON; ?>'+" "+i,
			};

			var next = graph.addNode(thisnode);
			checkNodes[user.userid] = user.userid;

			// connect to root node
			addRootConnectionToSunburst(sunburstGraph.root, user.userid, sunburstGraph);

			return next;
		}
	}

	return false;
}

function displaySunburst() {
	// compute positions and plot.
	sunburst.refresh();
	//sunburst.rotateAngle(55, 'replot', {} );
}

	function addSunburstData() {
		var json = [
			//"root" node is invisible
			{
			  "id": "node0",
			  "name": "",
			  "data": {
				"$type": "none"
			  },
			  "adjacencies": [
				  {
					"nodeTo": "node1",
					"data": {
					  '$type': 'none'
					}
				  }, {
					"nodeTo": "node2",
					"data": {
					  '$type': 'none'
					}
				  }, {
					"nodeTo": "node3",
					"data": {
					  '$type': 'none'
					}
				  }, {
					"nodeTo": "node4",
					"data": {
					  "$type": "none"
					}
				  }, {
					"nodeTo": "node5",
					"data": {
					  "$type": "none"
					}
				  }, {
					"nodeTo": "node6",
					"data": {
					  "$type": "none"
					}
				  }, {
					"nodeTo": "node7",
					"data": {
					  "$type": "none"
					}
				  }, {
					"nodeTo": "node8",
					"data": {
					  "$type": "none"
					}
				  }, {
					"nodeTo": "node9",
					"data": {
					  "$type": "none"
					}
				  }, {
					"nodeTo": "node10",
					"data": {
					  "$type": "none"
					}
				  }
			  ]
			}, {
			  "id": "node1",
			  "name": "node 1",
			  "data": {
				"$angularWidth": 13.00,
				"$color": "#33a",
				"$height": 70
			  },
			  "adjacencies": [
				  {
					"nodeTo": "node3",
					"data": {
					  "$color": "#ddaacc",
					  "$lineWidth": 4
					}
				  }, {
					"nodeTo": "node5",
					"data": {
					  "$color": "#ccffdd",
					  "$lineWidth": 4
					}
				  }, {
					"nodeTo": "node7",
					"data": {
					  "$color": "#dd99dd",
					  "$lineWidth": 4
					}
				  }, {
					"nodeTo": "node8",
					"data": {
					  "$color": "#dd99dd",
					  "$lineWidth": 4
					}
				  }, {
					"nodeTo": "node10",
					"data": {
					  "$color": "#ddaacc",
					  "$lineWidth": 4
					}
				  }
			  ]
			}, {
			  "id": "node2",
			  "name": "node 2",
			  "data": {
				"$angularWidth": 24.90,
				"$color": "#55b",
				"$height": 73
			  },
			  "adjacencies": [
				  "node8", "node9", "node10"
			  ]
			}, {
			  "id": "node3",
			  "name": "node 3",
			  "data": {
				"$angularWidth": 10.50,
				"$color": "#77c",
				"$height": 75
			  },
			  "adjacencies": [
				  "node8", "node9", "node10"
			  ]
			}, {
			  "id": "node4",
			  "name": "node 4",
			  "data": {
				"$angularWidth": 5.40,
				"$color": "#99d",
				"$height": 75
			  },
			  "adjacencies": [
				  "node8", "node9", "node10"
			  ]
			}, {
			  "id": "node5",
			  "name": "node 5",
			  "data": {
				"$angularWidth": 32.26,
				"$color": "#aae",
				"$height": 80
			  },
			  "adjacencies": [
				  "node8", "node9", "node10"
			  ]
			}, {
			  "id": "node6",
			  "name": "node 6",
			  "data": {
				"$angularWidth": 24.90,
				"$color": "#bf0",
				"$height": 85
			  },
			  "adjacencies": [
				  "node8", "node9", "node10"
			  ]
			}, {
			  "id": "node7",
			  "name": "node 7",
			  "data": {
				"$angularWidth": 14.90,
				"$color": "#cf5",
				"$height": 85
			  },
			  "adjacencies": [
				  "node8", "node9", "node10"
			  ]
			}, {
			  "id": "node8",
			  "name": "node 8",
			  "data": {
				"$angularWidth": 34.90,
				"$color": "#dfa",
				"$height": 80
			  },
			  "adjacencies": [
				  "node9", "node10"
			  ]
			}, {
			  "id": "node9",
			  "name": "node 9",
			  "data": {
				"$angularWidth": 42.90,
				"$color": "#CCC",
				"$height": 75
			  },
			  "adjacencies": [
				"node10"
			  ]
			}, {
			  "id": "node10",
			  "name": "node 10",
			  "data": {
				"$angularWidth": 100.90,
				"$color": "#C37",
				"$height": 70
			  },
			  "adjacencies": []
			}
		];

		// load JSON data.
		sunburst.loadJSON(json);

		// compute positions and plot.
		sunburst.refresh();
	}