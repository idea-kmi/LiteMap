<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2015-2023 The Open University UK                              *
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
	 /** Author: Michelle Bachler, KMi, The Open University **/

	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

	include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));
?>

<script type='text/javascript'>
	function countWords(s){
		s = s.replace(/(^\s*)|(\s*$)/gi,"");//exclude  start and end white-space
		s = s.replace(/[ ]{2,}/gi," ");//2 or more space to 1
		s = s.replace(/\n /,"\n"); // exclude newline with a start spacing
		return s.split(' ').length;
	}

	function sparklinedatesortasc(a, b) {
		var nameA=a.x;
		var nameB=b.x;
		if (nameA < nameB) {
			return -1;
		}
		if (nameA > nameB) {
			return 1;
		}
		return 0;
	}

	function votedatesortdesc(a, b) {
		var nameA=a.cnode.votedate;
		var nameB=b.cnode.votedate;
		if (nameA > nameB) {
			return -1;
		}
		if (nameA < nameB) {
			return 1;
		}
		return 0;
	}

	function activitydatesortdesc(a, b) {
		var nameA=a.date;
		var nameB=b.date;
		if (nameA > nameB) {
			return -1;
		}
		if (nameA < nameB) {
			return 1;
		}
		return 0;
	}

	function votesortdesc(a, b) {
		var nameA=parseInt(a.cnode.totalvotes);
		var nameB=parseInt(b.cnode.totalvotes);
		if (nameA > nameB) {
			return -1;
		}
		if (nameA < nameB) {
			return 1;
		}
		return 0;
	}

	function negvotesortdesc(a, b) {
		var nameA=parseInt(a.cnode.negativevotes);
		var nameB=parseInt(b.cnode.negativevotes);
		if (nameA > nameB) {
			return -1;
		}
		if (nameA < nameB) {
			return 1;
		}
		return 0;
	}

	function addOverviewItem(divarea, node, metadata) {

		var nodeid = node.nodeid;
		var nodename = node.name+metadata;
		var nodetype = node.role[0].role.name
		var homepage = node.homepage;

		if (nodeid != nodename) {
			next = new Element("span", {
				'style':'float:left;clear:both;margin-top:5px;margin-bottom:5px;'});

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
		$(divarea).insert(next);
	}

	function loadOverviewData() {

		$('messagearea').update(getLoading("<?php echo $LNG->STATS_OVERVIEW_LOADING_MESSAGE; ?>"));

		var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.
		args["style"] = 'shortactivity';
		args["start"] = '0';
		args["max"] = '-1';
		args['filternodetypes'] = "Issue,Solution,Pro,Con";
		var reqUrl = SERVICE_ROOT + "&method=getnodesbyglobal&" + Object.toQueryString(args);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				//alert(transport.responseText);

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

				var nodes = json.nodeset[0].nodes;
				//alert("node count = "+nodes.length);
				if (nodes.length > 0) {
					var now = new Date();
					var timeTwoWeeksAgo = now.setDate(now.getDate() - 14);
					now = new Date();
					var timeFiveDaysAgo = now.setDate(now.getDate() - 5);

					var wordsByUser = {};
					var viewsByUser = {};
					var minWordCount = 0;
					var maxWordCount = 0;
					var totalWordCount = 0;
					var contributorCount = 0;
					var viewCount = 0;
					var allActivity = new Array();
					var allViews = new Array();
					var allVotesCount = 0;
					var contributionsArray = new Array();
					var contributionsObj = {key:"types", values:contributionsArray};
					var contributionTypes = {};

					for(var i=0; i< nodes.length; i++){
						var node = nodes[i].cnode;
						//alert(i);
						//alert(node.toSource())
						var nameCount = countWords(node.name);
						var descCount = 0;
						if (node.description) {
							descCount = countWords(node.description);
						}

						var userid = node.users[0].user.userid;
						var nextWordCount = descCount+nameCount;
						if (nextWordCount>maxWordCount) {
							maxWordCount = nextWordCount
						}
						if (minWordCount == 0 || nextWordCount < minWordCount) {
							minWordCount = nextWordCount;
						}
						totalWordCount = totalWordCount+nextWordCount;

						node.votedate = 0;
						node.totalvotes = 0;

						var rolename = node.role[0].role.name;
						if (contributionTypes[rolename]) {
							contributionTypes[rolename] = contributionTypes[rolename]+1;
						} else {
							contributionTypes[rolename] = 1;
						}

						if (node.activity) {
							var activity = node.activity;
							var activities = activity[0].activityset.activities;
							for (var j=0; j<activities.length; j++) {
								var next = activities[j].activity;
								if (next.type == "View") {
									if (next.userid && next.userid != "") {
										allViews.push(next);
									}
								}
							}
						}

						if (node.votes) {
							var votes = node.votes[0].voting;
							var totalvotes = 0;
							var votesArray = new Array();

							for (var j=0; j<votes.positivevoteslist.length; j++) {
								var vote = votes.positivevoteslist[j].vote;
								totalvotes++;
								allVotesCount++;
								votesArray.push(vote);
							}
							for (var j=0; j<votes.negativevoteslist.length; j++) {
								var vote = votes.negativevoteslist[j].vote;
								totalvotes++;
								allVotesCount++;
								votesArray.push(vote);
							}
							for (var j=0; j<votes.positiveconnvoteslist.length; j++) {
								var vote = votes.positiveconnvoteslist[j].vote;
								totalvotes++;
								allVotesCount++;
								votesArray.push(vote);
							}
							for (var j=0; j<votes.negativeconnvoteslist.length; j++) {
								var vote = votes.negativeconnvoteslist[j].vote;
								totalvotes++;
								allVotesCount++;
								votesArray.push(vote);
							}

							node.totalvotes = totalvotes;
							votesArray.sort(activitydatesortdesc);
							if (votesArray[0]) {
								node.votedate = votesArray[0].date;
							}
						}

						if (wordsByUser.hasOwnProperty(userid)) {
							var count = wordsByUser[userid];
							count = count+descCount+nameCount;
							wordsByUser[userid] = count;
						} else {
							contributorCount++;
							var count = descCount+nameCount;
							wordsByUser[userid] = count;
						}
					}

					// MOST VOTES ON
					var totaladded = 0;
					nodes.sort(votesortdesc);
					var count = nodes.length;
					if (count > 3) {
						count = 3;
					}
					for (var i=0; i<count; i++) {
						var nextnode = nodes[i];
						if (parseInt(nextnode.cnode.totalvotes) > 0) {
							var votes = '<span style="padding-left:10px;color:dimgray"><?php echo $LNG->STATS_OVERVIEW_VOTES;?>'+parseInt(nextnode.cnode.totalvotes)+'</span>';
							addOverviewItem($("topvotedlist"), nextnode.cnode, votes);
							totaladded++
						}
					}
					if (totaladded == 0) {
						$('topvoteddiv').style.display = 'none';
					}

					// MOST RENCETNLY VOTED ON
					totaladded = 0;
					nodes.sort(votedatesortdesc);
					count = nodes.length;
					if (count > 3) {
						count = 3;
					}
					for (var i=0; i<count; i++) {
						var nextnode = nodes[i];
						if (nextnode.cnode.votedate) {
							var creationDate = new Date(nextnode.cnode.votedate*1000);
							var fomatedDate = "";
							if (creationDate) {
								fomatedDate = creationDate.format(DATE_FORMAT_PROJECT);
							}
							var date = '<span style="padding-left:10px;color:dimgray"><?php echo $LNG->STATS_OVERVIEW_DATE;?>'+fomatedDate+'</span>';
							addOverviewItem($("recentvotedlist"), nextnode.cnode, date);
							totaladded++
						}
					}
					if (totaladded == 0) {
						$('recentvoteddiv').style.display = 'none';
					}

					// RECENTLY ADDED NODES
					totaladded = 0;
					nodes.sort(creationdatenodesortdesc);
					count = nodes.length;
					if (count > 3) {
						count = 3;
					}
					for (var i=0; i<count; i++) {
						var nextnode = nodes[i];
						var creationDate = new Date(nextnode.cnode.creationdate*1000);
						var fomatedDate = "";
						if (creationDate) {
							fomatedDate = creationDate.format(DATE_FORMAT_PROJECT);
						}
						var date = '<span style="padding-left:10px;color:dimgray"><?php echo $LNG->STATS_OVERVIEW_DATE;?>'+fomatedDate+'</span>';
						addOverviewItem($("latestnodeslist"), nextnode.cnode, date);
						totaladded++
					}
					if (totaladded == 0) {
						$('latestnodesdiv').style.display = 'none';
					}

					// WORD STATS
					var userNodeCount = contributorCount;
					var averageWordCount = 0;
					if (userNodeCount != 0) {
						averageWordCount = parseInt(parseInt(totalWordCount)/parseInt(userNodeCount));
					}

					$('average-words-count').update(averageWordCount);
					$('min-words-count').update(minWordCount);
					$('max-words-count').update(maxWordCount);


					// HEALTH PARTICIPATION

					$('health-participation-count').update(userNodeCount);
					var person = userNodeCount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_PERSON; ?>' :'<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>';
					$('health-participation-message').update(person+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTORS; ?>');
					if (userNodeCount < 3) {
						$('health-participation-red').className = "trafficlightredon";
						$('health-participation-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_PROBLEM; ?>');
					} else if (userNodeCount >= 3 && userNodeCount <= 5) {
						$('health-participation-orange').className = "trafficlightorangeon";
						$('health-participation-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_MAYBE_PROBLEM; ?>');
					} else if (userNodeCount > 5) {
						$('health-participation-green').className = "trafficlightgreenon";
						$('health-participation-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_NO_PROBLEM; ?>');
					}

					// HEALTH VIEWING
					var peoplegreencount = 0;
					var peopleorangecount = 0;
					var peopleGreenCheck = new Array();
					var peopleOrangeCheck = new Array();
					var orangecount = 0;
					var greencount = 0;
					var peoplecount = 0;

					for (var i=0; i<allViews.length; i++) {
						var nextview = allViews[i];
						if (nextview) {
							if (nextview.modificationdate) {
								var nextdate = parseInt(nextview.modificationdate)*1000;
								if (nextdate >= timeTwoWeeksAgo) {
									if (nextdate < timeFiveDaysAgo) {
										if (peopleOrangeCheck.indexOf(nextview.userid) == -1) {
											peopleorangecount++;
											peopleOrangeCheck.push(nextview.userid);
										}
										orangecount++;
									} else if (nextdate >= timeFiveDaysAgo) {
										if (peopleGreenCheck.indexOf(nextview.userid) == -1) {
											peoplegreencount++;
											peopleGreenCheck.push(nextview.userid);
										}
										greencount++;
									}
								}
							}
						}
					}

					peoplecount = peoplegreencount+peopleorangecount;

					if (peoplecount == 0) {
						$('health-viewing-messageorange').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS; ?>'+' '+'<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>'+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_PART2; ?>');
						$('health-viewing-messageorange-part2').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_RED; ?>');
						$('health-viewing-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_PROBLEM; ?>');
						$('health-viewingpeople-orange-count').update(0);
						$('health-viewingitem-orange-count').update(0);
						$('health-viewing-red').className = "trafficlightredon";
						$('health-viewingorange-div').style.display = "block";
					} else if (orangecount > 0 && greencount == 0) {
						var orangeamount = orangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_TIME; ?>' : '<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>';
						var orangeperson = peopleorangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_PERSON; ?>' :'<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>';
						$('health-viewing-messageorange').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS; ?>'+' '+orangeperson+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_PART2; ?>');
						$('health-viewing-messageorange-part2').update(orangeamount+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_ORANGE; ?>');
						$('health-viewing-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_MAYBE_PROBLEM; ?>');
						$('health-viewingpeople-orange-count').update(peopleorangecount);
						$('health-viewingitem-orange-count').update(orangecount);
						$('health-viewing-orange').className = "trafficlightorangeon";
						$('health-viewingorange-div').style.display = "block";
					} else if (greencount > 0) {
						var greenamount = greencount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_TIME; ?>' : '<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>';
						var greenperson = peoplegreencount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_PERSON; ?>' :'<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>';
						$('health-viewing-messagegreen').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS; ?>'+' '+greenperson+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_PART2; ?>');
						$('health-viewing-messagegreen-part2').update(greenamount+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_GREEN; ?>');
						$('health-viewing-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_NO_PROBLEM; ?>');
						$('health-viewingpeople-green-count').update(peoplegreencount);
						$('health-viewingitem-green-count').update(greencount);
						$('health-viewing-green').className = "trafficlightgreenon";

						if (orangecount > 0) {
							var orangeamount = orangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_TIME; ?>' : '<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>';
							var orangeperson = peopleorangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_PERSON; ?>' :'<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>';
							$('health-viewing-messageorange').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS; ?>'+' '+orangeperson+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_PART2; ?>');
							$('health-viewing-messageorange-part2').update(orangeamount+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS_ORANGE; ?>');
							$('health-viewingpeople-orange-count').update(peopleorangecount);
							$('health-viewingitem-orange-count').update(orangecount);
							$('health-viewingorange-div').style.display = "block";
							$('health-viewing-spacer').style.display = 'block';
						}

						$('health-viewinggreen-div').style.display = "block";
					}

					// HEALTH CONTRIBUTION
					peoplegreencount = 0;
					peopleorangecount = 0;
					peopleGreenCheck = new Array();
					peopleOrangeCheck = new Array();
					orangecount = 0;
					greencount = 0;
					peoplecount = 0

					for (var i=0; i<nodes.length; i++) {
						var node = nodes[i];
						if (node) {
							if (node.cnode.creationdate) {
								var nextdate = parseInt(node.cnode.creationdate)*1000;
								if (nextdate >= timeTwoWeeksAgo) {
									if (nextdate < timeFiveDaysAgo) {
										if (peopleOrangeCheck.indexOf(node.cnode.userid) == -1) {
											peopleorangecount++;
											peopleOrangeCheck.push(node.cnode.userid);
										}
										orangecount++;
									} else if (nextdate >= timeFiveDaysAgo) {
										if (peopleGreenCheck.indexOf(node.cnode.userid) == -1) {
											peoplegreencount++;
											peopleGreenCheck.push(node.cnode.userid);
										}
										greencount++;
									}
								}
							}
						}
					}

					peoplecount = peoplegreencount+peopleorangecount;

					//$('health-debate-count').update(peoplecount);
					if (peoplecount == 0) {
						$('health-debate-messageorange').update('<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>'+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION; ?>');
						$('health-debate-messageorange-part2').update('<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>'+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_RED; ?>');
						$('health-debate-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_PROBLEM; ?>');
						$('health-debatepeople-orange-count').update(0);
						$('health-debateitem-orange-count').update(0);
						$('health-debate-red').className = "trafficlightredon";
						$('health-debateorange-div').style.display = "block";
					} else if (orangecount > 0 && greencount == 0) {
						var orangeamount = orangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_TIME; ?>' : '<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>';
						var orangeperson = peopleorangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_PERSON; ?>' :'<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>';
						$('health-debate-messageorange').update(orangeperson+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION; ?>');
						$('health-debate-messageorange-part2').update(orangeamount+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_ORANGE; ?>');
						$('health-debate-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_MAYBE_PROBLEM; ?>');
						$('health-debatepeople-orange-count').update(peopleorangecount);
						$('health-debateitem-orange-count').update(orangecount);
						$('health-debate-orange').className = "trafficlightorangeon";
						$('health-debateorange-div').style.display = "block";
					} else if (greencount > 0) {
						var greenamount = greencount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_TIME; ?>' : '<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>';
						var greenperson = peoplegreencount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_PERSON; ?>' :'<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>';
						$('health-debate-messagegreen').update(greenperson+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION; ?>');
						$('health-debate-messagegreen-part2').update(greenamount+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_GREEN; ?>');
						$('health-debate-recomendation').update('<?php echo $LNG->STATS_OVERVIEW_HEALTH_NO_PROBLEM; ?>');
						$('health-debatepeople-green-count').update(peoplegreencount);
						$('health-debateitem-green-count').update(greencount);
						$('health-debate-green').className = "trafficlightgreenon";
						$('health-debategreen-div').style.display = "block";

						if (orangecount > 0) {
							var orangeamount = orangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_TIME; ?>' : '<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>';
							var orangeperson = peopleorangecount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_PERSON; ?>' : '<?php echo $LNG->STATS_OVERVIEW_PEOPLE; ?>';
							$('health-debate-messageorange').update(orangeperson+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION; ?>');
							$('health-debate-messageorange-part2').update(orangeamount+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_ORANGE; ?>');
							$('health-debate-spacer').style.display = 'block';
							$('health-debatepeople-orange-count').update(peopleorangecount);
							$('health-debateitem-orange-count').update(orangecount);
							$('health-debateorange-div').style.display = "block";
						}
					}

					// CONTRIBUTION BAR CHART
					var message = userNodeCount+' '+person+' '+'<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION; ?>';
					var innermessage = "";
					var contributionCount = 0;
					for (var property in contributionTypes) {
						if (contributionTypes.hasOwnProperty(property)) {
							var nextcount = contributionTypes[property];
							contributionCount += nextcount;
							var next = {"label":getNodeTitleAntecedence(property, false), "value":nextcount};
							contributionsArray.push(next);
							innermessage += next.label+": "+next.value+"; ";
						}
					}
					// add votes
					contributionsArray.push({"label":'<?php echo $LNG->STATS_OVERVIEW_VOTES;?>', "value":allVotesCount});
					simpleBarChartTypes($('contribution-chart'), new Array(contributionsObj), 300,100);

					innermessage += '<?php echo $LNG->STATS_OVERVIEW_VOTES;?>'+' '+allVotesCount;
					var itemname = contributionCount == 1 ? '<?php echo $LNG->STATS_OVERVIEW_TIME; ?>' : '<?php echo $LNG->STATS_OVERVIEW_TIMES; ?>';
					message += ' '+(contributionCount+allVotesCount)+' '+itemname+':<br><br>';
					$('contribution-chart-message').update(message+innermessage);

					// VIEWING SPARKLINE
					// Sort by day
					var viewDateArray = new Array();
					for (var i=0; i<allViews.length; i++) {
						var nextview = allViews[i];
						if (nextview) {
							if (nextview.modificationdate) {
								var date = new Date(nextview.modificationdate*1000);
								var newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
								var time = newDate.getTime();
								if (viewDateArray[time]) {
									viewDateArray[time] = viewDateArray[time] +1;
								} else {
									viewDateArray[time] = 1;
								}
							}
						}
					}
					var sparklineData = new Array();
					var hightesviews = 0;
					var hightesviewsdate = 0;
					var lowestviews = 0;
					var lowestviewsdate = 0;
					for (var property in viewDateArray) {
						if (viewDateArray.hasOwnProperty(property)) {
							var countdate = parseInt(property);
							var viewcount = viewDateArray[property];
							if (viewcount > hightesviews) {
								hightesviews = viewcount;
								hightesviewsdate = countdate;
							} else if (lowestviews == 0 || viewcount < lowestviews) {
								lowestviews = viewcount;
								lowestviewsdate = countdate;
							}
							sparklineData.push({"x":countdate, "y":viewcount});
						}
					}
					sparklineData = sparklineData.sort(sparklinedatesortasc);
					var lastcount = sparklineData[sparklineData.length-1];

					if (sparklineData.length > 0) {
						sparklineDateNVD3($('viewing-chart'), sparklineData, 500, 100);

						var formatDate = d3.time.format("%e %b %y");

						var viewingmessage = '<?php echo $LNG->STATS_OVERVIEW_VIEWING_HIGHEST; ?>';
						viewingmessage += " "+hightesviews+" ";
						viewingmessage += '<?php echo $LNG->STATS_OVERVIEW_VIEWING_VIEWS; ?>';
						viewingmessage += " "+formatDate(new Date(hightesviewsdate))+"<br>";

						viewingmessage += '<?php echo $LNG->STATS_OVERVIEW_VIEWING_LOWEST; ?>';
						viewingmessage += " "+lowestviews+" ";
						viewingmessage += '<?php echo $LNG->STATS_OVERVIEW_VIEWING_VIEWS; ?>';
						viewingmessage += " "+formatDate(new Date(lowestviewsdate))+"<br>";

						if (lastcount) {
							viewingmessage += '<?php echo $LNG->STATS_OVERVIEW_VIEWING_LAST; ?>';
							viewingmessage += " "+lastcount.y+" ";
							viewingmessage += '<?php echo $LNG->STATS_OVERVIEW_VIEWING_VIEWS; ?>';
							viewingmessage += " "+formatDate(new Date(lastcount.x));
						}

						$('viewing-chart-message').update(viewingmessage);
					} else {
						$('viewing-chart').innerHTML="<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>";
					}

					$('messagearea').update("");
					$("overview-group-div").style.display = "block";

				} else {
					$('messagearea').innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
					toolbar.style.display = 'none';
				}
			}
		});
	}

	Event.observe(window, 'load', function() {
		loadOverviewData();
	});
</script>

<div id="messagearea"></div>

<div id="overview-group-div" style="display:none">
	<div id="health-indicators">
		<h1><?php echo $LNG->STATS_OVERVIEW_HEALTH_TITLE; ?></h1>
		<div class="d-flex flex-row gap-2">

			<div class="boxshadowsquare col-4 align-self-stretch" id='health-participation'>
				<div class="mb-3">
					<b><?php echo $LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_TITLE; ?></b>
					<span class="active" onMouseOver="showGlobalHint('StatsOverviewParticipation', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" alt="click for more info" style="margin-top: 2px; margin-left: 5px;" /></span>
				</div>
				<div class="d-flex flex-row gap-2">
					<div class="d-flex flex-column">
						<div id='health-participation-trafficlight' class="trafficlight me-2">
							<span id='health-participation-red' class="trafficlightred"></span>
							<span id='health-participation-orange' class="trafficlightorange"></span>
							<span id='health-participation-green' class="trafficlightgreen"></span>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div>
							<p><b><span id="health-participation-count"></span></b> <span id='health-participation-message'></span></p>
							<p><span id='health-participation-recomendation'></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="boxshadowsquare col-4 align-self-stretch" id='health-viewing'>
				<div class="mb-3">
					<b><?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWING_TITLE; ?></b>
					<span class="active" onMouseOver="showGlobalHint('StatsOverviewViewing', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" alt="click for more info" style="margin-top: 2px; margin-left: 5px;" /></span>
				</div>
				<div class="d-flex flex-row gap-2">
					<div class="d-flex flex-column">
						<div id='health-viewing-trafficlight' class="trafficlight me-2">
							<span id='health-viewing-red' class="trafficlightred"></span>
							<span id='health-viewing-orange' class="trafficlightorange"></span>
							<span id='health-viewing-green' class="trafficlightgreen"></span>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div id="health-viewingorange-div" style="display:none">
							<p><b><span id="health-viewingpeople-orange-count"></span></b> <span id='health-viewing-messageorange'></span></p>
							<p><b><span id="health-viewingitem-orange-count"></span></b> <span id='health-viewing-messageorange-part2'></span></p>
						</div>
						<p><span id="health-viewing-spacer" style="height:10px;display:none"></span></p>
						<div id="health-viewinggreen-div" style="display:none">
							<p><b><span id="health-viewingpeople-green-count"></span></b> <span id='health-viewing-messagegreen'><?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWERS; ?></span></p>
							<p><b><span id="health-viewingitem-green-count"></span></b> <span id='health-viewing-messagegreen-part2'></span></p>
						</div>
						<p><span id='health-viewing-recomendation'></span></p>
					</div>
				</div>
			</div>

			<div class="boxshadowsquare col-4 align-self-stretch" id='health-debate'>
				<div class="mb-3">
					<b><?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_TITLE; ?></b>
					<span class="active" onMouseOver="showGlobalHint('StatsOverviewDebate', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" alt="click for more info" style="margin-top: 2px; margin-left: 5px;" /></span>
				</div>
				<div class="d-flex flex-row gap-2">
					<div class="d-flex flex-column">
						<div class="trafficlight me-2">
							<span id='health-debate-red' class="trafficlightred"></span>
							<span id='health-debate-orange' class="trafficlightorange"></span>
							<span id='health-debate-green' class="trafficlightgreen"></span>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div id="health-debateorange-div" style="display:none">
							<p><b><span id="health-debatepeople-orange-count"></span></b> <span id='health-debate-messageorange'></span></p>
							<p><b><span id="health-debateitem-orange-count"></span></b> <span id='health-debate-messageorange-part2'></span></p>
						</div>
						<p><span id="health-debate-spacer" style="height:10px;display:none"></span></p>
						<div id="health-debategreen-div" style="display:none">
							<p><b><span id="health-debatepeople-green-count"></span></b> <span id='health-debate-messagegreen'></span></p>
							<p><b><span id="health-debateitem-green-count"></span></b> <span id='health-debate-messagegreen-part2'></span></p>
						</div>
						<p><span id='health-debate-recomendation'></span></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="overviewarea" class="d-flex flex-column">
		<h1><?php echo $LNG->STATS_OVERVIEW_MAIN_TITLE; ?></h1>

		<div class="boxshadowsquare d-flex flex-row justify-content-between gap-4">
			<div class="col-3"><?php echo $LNG->STATS_OVERVIEW_CONTRIBUTION_MESSAGE; ?></div>
			<div id="contribution-chart"></div>
			<div id="contribution-chart-message"></div>
		</div>

		<div class="boxshadowsquare d-flex flex-row justify-content-between gap-4">
			<div class="col-3"><?php echo $LNG->STATS_OVERVIEW_VIEWING_MESSAGE; ?></div>
			<div id="viewing-chart" class="statsgraph"></div>
			<div id="viewing-chart-message"></div>
		</div>

		<div class="boxshadowsquare d-flex flex-row gap-4" id="topvoteddiv">
			<div class="col-3"><?php echo $LNG->STATS_OVERVIEW_TOP_THREE_VOTES_MESSAGE; ?></div>
			<div id="topvotedlist"></div>
		</div>

		<div class="boxshadowsquare d-flex flex-row gap-4" id="recentvoteddiv">
			<div class="col-3"><?php echo $LNG->STATS_OVERVIEW_RECENT_VOTES_MESSAGE; ?></div>
			<div id="recentvotedlist"></div>
		</div>

		<div class="boxshadowsquare d-flex flex-row gap-4" id="latestnodesdiv">
			<div class="col-3"><?php echo $LNG->STATS_OVERVIEW_RECENT_NODES_MESSAGE; ?></div>
			<div id="latestnodeslist"></div>
		</div>

		<div class="boxshadowsquare d-flex flex-row gap-4" id="average-words">
			<div class="col-3"><?php echo $LNG->STATS_OVERVIEW_WORDS_MESSAGE; ?></div>
			<div class="d-flex flex-row gap-4">
				<span><?php echo $LNG->STATS_OVERVIEW_WORDS_AVERAGE; ?> <b><span id="average-words-count">0</span></b> <?php echo $LNG->STATS_OVERVIEW_WORDS; ?></span>
				<span style="padding-left:20px;"><?php echo $LNG->STATS_OVERVIEW_WORDS_MIN; ?> <b><span id="min-words-count">0</span></b> <?php echo $LNG->STATS_OVERVIEW_WORDS; ?></span>
				<span style="padding-left:20px;"><?php echo $LNG->STATS_OVERVIEW_WORDS_MAX; ?> <b><span id="max-words-count">0</span></b> <?php echo $LNG->STATS_OVERVIEW_WORDS; ?></span>
			</div>
		</div>
	</div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
