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
$countries = getCountryList();
?>

//this list the tabs
var TABS = {"home":true, "data":true, "group":true, "social":true};

var DATAVIZ = {"map":true, "issue":true, "solution":true, "pro":true, "con":true, "comment":true, "evidence":true /*"resource":true*/, "chat":true};

var DEFAULT_TAB = 'home';
var DEFAULT_VIZ = 'list';

var CURRENT_VIZ = DEFAULT_VIZ;
var CURRENT_TAB = DEFAULT_TAB;

var DATA_LOADED = {"home":false, "group":false, "social":false, "issue":false, "solution":false, "pro":false, "con":false, "resource":false, "comment":false, "evidence":false, "chat":false, "map":false};

//define events for clicking on the tabs
var stpHome = setTabPushed.bindAsEventListener($('tab-home-list-obj'),'home');
var stpData = setTabPushed.bindAsEventListener($('tab-data-list-obj'),'data');
var stpGroup = setTabPushed.bindAsEventListener($('tab-group-list-obj'),'group');
var stpSocial = setTabPushed.bindAsEventListener($('tab-social-list-obj'),'social');

var stpIssueList = setTabPushed.bindAsEventListener($('tab-issue-list-obj'),'data-issue');
var stpSolutionList = setTabPushed.bindAsEventListener($('tab-solution-list-obj'),'data-solution');
var stpProList = setTabPushed.bindAsEventListener($('tab-pro-list-obj'),'data-pro');
var stpConList = setTabPushed.bindAsEventListener($('tab-con-list-obj'),'data-con');
var stpResourceList = setTabPushed.bindAsEventListener($('tab-resource-list-obj'),'data-resource');
var stpCommentList = setTabPushed.bindAsEventListener($('tab-comment-list-obj'),'data-comment');
var stpEvidenceList = setTabPushed.bindAsEventListener($('tab-evidence-list-obj'),'data-evidence');
var stpChatList = setTabPushed.bindAsEventListener($('tab-chat-list-obj'),'data-chat');
var stpMapList = setTabPushed.bindAsEventListener($('tab-map-list-obj'),'data-map');

/**
 *	set which tab to show and load first
 */
Event.observe(window, 'load', function() {

	// add events for clicking on the main tabs
	Event.observe('tab-home','click', stpHome);
	Event.observe('tab-data','click', stpData);
	Event.observe('tab-group','click', stpGroup);
	Event.observe('tab-social','click', stpSocial);

	Event.observe('tab-data-map','click', stpMapList);
	Event.observe('tab-data-issue','click', stpIssueList);
	Event.observe('tab-data-solution','click', stpSolutionList);
	Event.observe('tab-data-pro','click', stpProList);
	Event.observe('tab-data-con','click', stpConList);
	Event.observe('tab-data-comment','click', stpCommentList);
	Event.observe('tab-data-evidence','click', stpEvidenceList);
	Event.observe('tab-data-chat','click', stpChatList);

	//Event.observe('tab-data-resource','click', stpResourceList);


	setTabPushed($('tab-'+getAnchorVal(DEFAULT_TAB + "-" + DEFAULT_VIZ)),getAnchorVal(DEFAULT_TAB + "-" + DEFAULT_VIZ));
});

/**
 *	switch between tabs
 */
function setTabPushed(e) {

	var data = $A(arguments);
	var tabID = data[1];

	// get tab and the visualisation from the #
	var parts = tabID.split("-");
	var tab = parts[0];
	var viz="";
	if (parts.length > 1) {
		viz = parts[1];
	}
	var page=1;
	if (parts.length > 2) {
		page = parseInt(parts[2]);
	}

	// Check tab is know else default to default
	if (!TABS.hasOwnProperty(tab)) {
		tab = DEFAULT_TAB;
		viz = DEFAULT_VIZ;
	}

	var i="";
	for (i in TABS){
		if ($("tab-"+i)) {
			if(tab == i){
				if($("tab-"+i)) {
					$("tab-"+i).removeClassName("unselected");
					$("tab-"+i).addClassName("current");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").show();
					}
				}
			} else {
				if($("tab-"+i)) {
					$("tab-"+i).removeClassName("current");
					$("tab-"+i).addClassName("unselected");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").hide();
					}
				}
			}
		}
	}

	if (tab =="data") {
		if (viz == "") {
			viz = "map";
		}

		for (i in DATAVIZ){
			if(viz == i){
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("unselected");
					$("tab-"+tab+"-"+i).addClassName("current");
					$("tab-content-"+tab+"-"+i+"-div").show();
					$("tab-content-"+tab+"-"+i).show();
				}
			} else {
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("current");
					$("tab-"+tab+"-"+i).addClassName("unselected");
					$("tab-content-"+tab+"-"+i+"-div").hide();
					$("tab-content-"+tab+"-"+i).hide();
				}
			}
		}
	}

	CURRENT_TAB = tab;
	CURRENT_VIZ = viz;

	//LOAD DATA IF REQUIRED
	if (tab == "social") {
		if (!DATA_LOADED.social) {
			loadUserHomeNet();
		}
	} else if (tab == "group") {
		$('tab-group').setAttribute("href",'#group');
		Event.stopObserving('tab-group','click');
		Event.observe('tab-group','click', stpGroup);
		if(!DATA_LOADED.group) {
			GROUP_ARGS['start'] = (page-1) * GROUP_ARGS['max'];
			loadmygroups(CONTEXT,GROUP_ARGS);
		}
	} else if (tab == "data") {
		switch(viz){
			case 'issue':
				$('tab-data').setAttribute("href",'#data-issue');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpIssueList);
				if(!DATA_LOADED.issue){
					ISSUE_ARGS['start'] = (page-1) * ISSUE_ARGS['max'];
					loadissues(CONTEXT,ISSUE_ARGS);
				} else {
					updateAddressParameters(ISSUE_ARGS);
				}
				break;
			case 'solution':
				$('tab-data').setAttribute("href",'#data-solution');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpSolutionList);
				if(!DATA_LOADED.solution){
					SOLUTION_ARGS['start'] = (page-1) * SOLUTION_ARGS['max'];
					loadsolutions(CONTEXT,SOLUTION_ARGS);
				} else {
					updateAddressParameters(SOLUTION_ARGS);
				}
				break;
			case 'pro':
				$('tab-data').setAttribute("href",'#data-pro');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpProList);
				if(!DATA_LOADED.pro){
					PRO_ARGS['start'] = (page-1) * PRO_ARGS['max'];
					loadpros(CONTEXT,PRO_ARGS);
				} else {
					updateAddressParameters(PRO_ARGS);
				}
				break;
			case 'con':
				$('tab-data').setAttribute("href",'#data-con');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpConList);
				if(!DATA_LOADED.con){
					CON_ARGS['start'] = (page-1) * CON_ARGS['max'];
					loadcons(CONTEXT,CON_ARGS);
				} else {
					updateAddressParameters(CON_ARGS);
				}
				break;
			case 'evidence':
				$('tab-data').setAttribute("href",'#data-evidence');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpEvidenceList);
				if(!DATA_LOADED.evidence){
					EVIDENCE_ARGS['start'] = (page-1) * EVIDENCE_ARGS['max'];
					loadevidence(CONTEXT,EVIDENCE_ARGS);
				} else {
					updateAddressParameters(EVIDENCE_ARGS);
				}
				break;
			case 'comment':
				$('tab-data').setAttribute("href",'#data-comment');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpCommentList);
				if(!DATA_LOADED.comment){
					COMMENT_ARGS['start'] = (page-1) * COMMENT_ARGS['max'];
					loadcomments(CONTEXT,COMMENT_ARGS);
				} else {
					updateAddressParameters(COMMENT_ARGS);
				}
				break;
			case 'chat':
				$('tab-data').setAttribute("href",'#data-chat');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpChatList);
				if(!DATA_LOADED.chat){
					CHAT_ARGS['start'] = (page-1) * CHAT_ARGS['max'];
					loadchats(CONTEXT,CHAT_ARGS);
				} else {
					updateAddressParameters(CHAT_ARGS);
				}
				break;
			case 'map':
				$('tab-data').setAttribute("href",'#data-map');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpMapList);
				if(!DATA_LOADED.map){
					MAP_ARGS['start'] = (page-1) * MAP_ARGS['max'];
					loadmaps(CONTEXT,MAP_ARGS);
				} else {
					updateAddressParameters(MAP_ARGS);
				}
				break;
		}
	}
}

function StopObservingDataTab() {
	Event.stopObserving('tab-data','click');
}

function refreshGroups() {
	loadmygroups(CONTEXT,GROUP_ARGS);
}

function refreshMaps() {
	loadmaps(CONTEXT,MAP_ARGS);
}

function refreshChallenges() {
	loadchallenges(CONTEXT,CHALLENGE_ARGS);
}

function refreshIssues() {
	loadissues(CONTEXT,ISSUE_ARGS);
}

function refreshSolutions() {
	loadsolutions(CONTEXT,SOLUTIONS_ARGS);
}

function refreshPros() {
	loadpros(CONTEXT,PRO_ARGS);
}

function refreshCons() {
	loadcons(CONTEXT,CON_ARGS);
}

function refreshEvidence() {
	loadcons(CONTEXT,EVIDENCE_ARGS);
}

function refreshComments() {
	loadcomments(CONTEXT,COMMENT_ARGS);
}

function refreshChats() {
	loadchats(CONTEXT,CHAT_ARGS);
}

function refreshData() {
	switch(CURRENT_VIZ){
		case 'challenge':
			loadchallenges(CONTEXT,CHALLENGE_ARGS);
			break;
		case 'issue':
			loadissues(CONTEXT,ISSUE_ARGS);
			break;
		case 'solution':
			loadsolutions(CONTEXT,ISSUE_ARGS);
			break;
		case 'pro':
			loadpros(CONTEXT,CON_ARGS);
			break;
		case 'con':
			loadcons(CONTEXT,PRO_ARGS);
			break;
		case 'evidence':
			loadevidence(CONTEXT,EVIDENCE_ARGS);
			break;
		case 'comment':
			loadcomments(CONTEXT,COMMENT_ARGS);
			break;
		case 'chat':
			loadchats(CONTEXT,CHAT_ARGS);
			break;
		case 'map':
			loadmaps(CONTEXT,MAP_ARGS);
			break;
		default:
	}
}

// LOAD GROUPS //
/**
 *	load my groups, both groups I am in and groups I manage.
 */
function loadmygroups(context,args){

	//updateAddressParameters(args);

	$("tab-content-group-list").update(getLoading("<?php echo $LNG->LOADING_GROUPS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getmygroups&userid="+args['userid'];

	new Ajax.Request(reqUrl, { method:'get',
		onError: function(error) {
			alert(error);
		},
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			$("tab-content-group-list").innerHTML = "";
			$("tab-content-group").style.display = 'none';
			$("tab-content-group-admin-list").innerHTML = "";
			$("tab-content-group-admin").style.display = 'none';

			var total = json.groupset[0].groups.length;
			if(total > 0){
				var groups = json.groupset[0].groups;
				var count = groups.length;
				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					for (var i=0; i<count; i++) {
						var group = groups[i].group;
						group.searchid = args['searchid'];
					}
				}

				var innerreqUrl = SERVICE_ROOT + "&method=getmyadmingroups&userid="+args['userid'];
				new Ajax.Request(innerreqUrl, { method:'get',
					onError: function(error) {
						alert(error);
					},
					onSuccess: function(innertransport){
						var innerjson = innertransport.responseText.evalJSON();
						if(innerjson.error){
							alert(innerjson.error[0].message);
							return;
						}
						var innertotal = innerjson.groupset[0].groups.length;
						if(innertotal > 0) {
							var admingroups = innerjson.groupset[0].groups;
							for (var i=0; i<innertotal; i++) {
								var group = admingroups[i].group;
								group.searchid = args['searchid'];
							}

							var finalgroups = new Array();
							for (var k=0; k<count; k++) {
								var group = groups[k].group;
								var found = false;
								for (var j=0; j<innertotal; j++) {
									var innergroup = admingroups[j].group;
									if (innergroup.groupid == group.groupid) {
										found = true;
										break;
									}
								}
								if (!found) {
									finalgroups.push(groups[k]);
								}
							}
							$("tab-content-group-admin").style.display = 'block';
							$("tab-content-group").style.display = 'block';
							displayMyGroups($("tab-content-group-admin-list"),admingroups, 1, 466,180);
							displayMyGroups($("tab-content-group-list"),finalgroups, 1, 466,180);
						} else {
							$("tab-content-group").style.display = 'block';
							displayGroups($("tab-content-group-list"),groups,1, 466,180, false, true);
						}
					}
				});
			} else {
				$("tab-content-group").style.display = 'block';
				$("tab-content-group").insert('<?php echo $LNG->WIDGET_NO_GROUPS_FOUND; ?>');
			}
		}
	});
  	DATA_LOADED.group = true;
}

// LOAD LISTS//

/**
 *	load next/previous set of con nodes
 */
function loadcons(context,args){

	var types = "Con";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}
	updateAddressParameters(args);

	$("tab-content-data-con").update(getLoading("<?php echo $LNG->LOADING_CONS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				var navbar = createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"cons")

				$("tab-content-data-con").update(navbar);

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'con',reorderCons));
					tb3.insert(createConnectedFilter(context, args, 'con'));

					$("tab-content-data-con").insert(tb3);
					displayUsersNodes($("tab-content-data-con"),json.nodeset[0].nodes,parseInt(args['start'])+1);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createConnectedFilter(context, args, 'con'));
					$("tab-content-data-con").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-con").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"cons"));
				}
    		}
  		});
  	DATA_LOADED.con = true;
}

/**
 *	load next/previous set of pro nodes
 */
function loadpros(context,args){

	var types = "Pro";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}
	updateAddressParameters(args);

	$("tab-content-data-pro").update(getLoading("<?php echo $LNG->LOADING_PROS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				var navbar = createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"pros")

				$("tab-content-data-pro").update(navbar);

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'pro',reorderPros));
					tb3.insert(createConnectedFilter(context, args, 'pro'));

					$("tab-content-data-pro").insert(tb3);
					displayUsersNodes($("tab-content-data-pro"),json.nodeset[0].nodes,parseInt(args['start'])+1);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createConnectedFilter(context, args, 'pro'));
					$("tab-content-data-pro").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-pro").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"pros"));
				}
    		}
  		});
  	DATA_LOADED.pro = true;
}

/**
 *	load next/previous set of evidence/argument nodes
 */
function loadevidence(context,args){

	var types = "Argument";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}
	updateAddressParameters(args);

	$("tab-content-data-evidence").update(getLoading("<?php echo $LNG->LOADING_EVIDENCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}

				var navbar = createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence")

				$("tab-content-data-evidence").update(navbar);

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'evidence',reorderEvidence));
					tb3.insert(createConnectedFilter(context, args, 'evidence'));

					$("tab-content-data-evidence").insert(tb3);
					displayUsersNodes($("tab-content-data-evidence"),json.nodeset[0].nodes,parseInt(args['start'])+1);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createConnectedFilter(context, args, 'evidence'));
					$("tab-content-data-evidence").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-evidence").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence"));
				}
    		}
  		});
  	DATA_LOADED.evidence = true;
}

/**
 *	load next/previous set of nodes
 */
function loadmaps(context,args){
	args['filternodetypes'] = "Map";
	updateAddressParameters(args);

	$("tab-content-data-map").update(getLoading("<?php echo $LNG->LOADING_MAPS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-map").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"maps"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'map',reorderMaps));

					$("tab-content-data-map").insert(tb3);

					displayMapNodes(466, 190, $("tab-content-data-map"),json.nodeset[0].nodes,parseInt(args['start'])+1, true, "maps", 'active', false, true, true);
					//displayUsersNodes($("tab-content-data-map"),json.nodeset[0].nodes,parseInt(args['start'])+1);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-map").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"maps"));
				}
    		}
  		});
  	DATA_LOADED.map = true;
}

/**
 *	load next/previous set of nodes
 */
function loadchallenges(context,args){
	args['filternodetypes'] = "Challenge";
	updateAddressParameters(args);

	$("tab-content-data-issue").update(getLoading("<?php echo $LNG->LOADING_CHALLENGES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-challenge").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'challenge',reorderIssues));
					tb3.insert(createConnectedFilter(context, args, 'challenges'));

					$("tab-content-data-challenge").insert(tb3);

					displayUsersNodes($("tab-content-data-challenge"),json.nodeset[0].nodes,parseInt(args['start'])+1);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createConnectedFilter(context, args, 'challenges'));
					$("tab-content-data-challenge").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-challenge").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));
				}
    		}
  		});
  	DATA_LOADED.challenge = true;
}

/**
 *	load next/previous set of nodes
 */
function loadissues(context,args){
	args['filternodetypes'] = "Issue";
	updateAddressParameters(args);

	$("tab-content-data-issue").update(getLoading("<?php echo $LNG->LOADING_ISSUES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-issue").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'issue',reorderIssues));
					tb3.insert(createConnectedFilter(context, args, 'issues'));

					$("tab-content-data-issue").insert(tb3);

					displayUsersNodes($("tab-content-data-issue"),json.nodeset[0].nodes,parseInt(args['start'])+1);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createConnectedFilter(context, args, 'issues'));
					$("tab-content-data-issue").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-issue").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));
				}
    		}
  		});
  	DATA_LOADED.issue = true;
}

/**
 *	load next/previous set of nodes
 */
function loadsolutions(context,args){
	args['filternodetypes'] = "Solution";
	updateAddressParameters(args);

	$("tab-content-data-solution").update(getLoading("<?php echo $LNG->LOADING_SOLUTIONS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-solution").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));

				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'solution',reorderSolutions));
					tb3.insert(createConnectedFilter(context, args, 'solutions'));

					$("tab-content-data-solution").insert(tb3);
					displayUsersNodes($("tab-content-data-solution"),json.nodeset[0].nodes,parseInt(args['start'])+1);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createConnectedFilter(context, args, 'solutions'));
					$("tab-content-data-solution").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-solution").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));
				}
    		}
  		});
  	DATA_LOADED.solution = true;
}

/**
 *	load next/previous set of chat comment nodes
 */
function loadchats(context,args) {

	args['filternodetypes'] = 'Comment';
	args['filterlist'] = '<?php echo $CFG->LINK_COMMENT_NODE; ?>';
	updateAddressParameters(args);

	$("tab-content-data-chat").update(getLoading("<?php echo $LNG->LOADING_CHATS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getconnectednodesby" + context + "&filtergroup=selected&filterlist=<?php echo $CFG->LINK_COMMENT_NODE; ?>&" + Object.toQueryString(args);
	$('chat-list-count').innerHTML = "";

	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){

			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var count = 0;
			if (json.nodeset[0].totalno) {
				count = json.nodeset[0].totalno;
			}

			var nodes = json.nodeset[0].nodes;

			//display nav
			var total = json.nodeset[0].totalno;
			if (CURRENT_TAB == 'data') {
				var currentPage = (json.nodeset[0].start/args["max"]) + 1;
				window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
			}
			$("tab-content-data-chat").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));

			//alert(nodes.length);

			if(nodes.length > 0){
				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				var tb3 = new Element("div", {'class':'toolbarrow'});

				var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
				tb3.insert(displaySortForm(sortOpts,args,'chat',reorderChats));

				$("tab-content-data-chat").insert(tb3);
				displayUsersChatNodes($("tab-content-data-chat"),json.nodeset[0].nodes,parseInt(args['start'])+1);
			}

			//display nav
			if (total > parseInt( args["max"] )) {
				$("tab-content-data-chat").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));
			}
		}
	});

  	DATA_LOADED.chat = true;
}

/**
 *	load next/previous set of comment nodes
 */
function loadcomments(context,args) {
	args['filternodetypes'] = 'Idea';
	updateAddressParameters(args);

	$("tab-content-data-comment").update(getLoading("<?php echo $LNG->LOADING_COMMENTS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getconnectednodesby" + context + "&" + Object.toQueryString(args);

	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var count = 0;
			if (json.nodeset[0].totalno) {
				count = json.nodeset[0].totalno;
			}

			var nodes = json.nodeset[0].nodes;

			//display nav
			var total = json.nodeset[0].totalno;
			if (CURRENT_TAB == 'data') {
				var currentPage = (json.nodeset[0].start/args["max"]) + 1;
				window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
			}
			$("tab-content-data-comment").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));

			if(nodes.length > 0){
				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				var tb3 = new Element("div", {'class':'toolbarrow'});

				var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
				tb3.insert(displaySortForm(sortOpts,args,'comment',reorderComments));
				tb3.insert(createConnectedFilter(context, args, 'comment'));

				$("tab-content-data-comment").insert(tb3);
				displayUsersNodes($("tab-content-data-comment"),json.nodeset[0].nodes,parseInt(args['start'])+1);
			} else {
				var tb3 = new Element("div", {'class':'toolbarrow'});
				tb3.insert(createConnectedFilter(context, args, 'comment'));
				$("tab-content-data-comment").insert(tb3);
			}

			//display nav
			if (total > parseInt( args["max"] )) {
				$("tab-content-data-comment").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));
			}
		}
	});

  	DATA_LOADED.comment = true;
}

/**
 *	Reorder the pro tab
 */
function reorderPros(){
 	// change the sort and orderby ARG values
 	PRO_ARGS['start'] = 0;
 	PRO_ARGS['sort'] = $('select-sort-pro').options[$('select-sort-pro').selectedIndex].value;
 	PRO_ARGS['orderby'] = $('select-orderby-pro').options[$('select-orderby-pro').selectedIndex].value;

 	loadpros(CONTEXT,PRO_ARGS);
}

/**
 *	Reorder the con tab
 */
function reorderCons(){
	// change the sort and orderby ARG values
	CON_ARGS['start'] = 0;
	CON_ARGS['sort'] = $('select-sort-con').options[$('select-sort-con').selectedIndex].value;
	CON_ARGS['orderby'] = $('select-orderby-con').options[$('select-orderby-con').selectedIndex].value;

	loadcons(CONTEXT,CON_ARGS);
}

/**
*	Reorder the map tab
*/
function reorderMaps(){
 	// change the sort and orderby ARG values
 	MAP_ARGS['start'] = 0;
 	MAP_ARGS['sort'] = $('select-sort-map').options[$('select-sort-map').selectedIndex].value;
 	MAP_ARGS['orderby'] = $('select-orderby-map').options[$('select-orderby-map').selectedIndex].value;

 	loadmaps(CONTEXT,MAP_ARGS);
}

/**
*	Reorder the challenge tab
*/
function reorderChallenges(){
 	// change the sort and orderby ARG values
 	CHALLENGE_ARGS['start'] = 0;
 	CHALLENGE_ARGS['sort'] = $('select-sort-challenge').options[$('select-sort-challenge').selectedIndex].value;
 	CHALLENGE_ARGS['orderby'] = $('select-orderby-challenge').options[$('select-orderby-challenge').selectedIndex].value;

 	loadchallenges(CONTEXT,CHALLENGE_ARGS);
}

/**
*	Reorder the issue tab
*/
function reorderIssues(){
 	// change the sort and orderby ARG values
 	ISSUE_ARGS['start'] = 0;
 	ISSUE_ARGS['sort'] = $('select-sort-issue').options[$('select-sort-issue').selectedIndex].value;
 	ISSUE_ARGS['orderby'] = $('select-orderby-issue').options[$('select-orderby-issue').selectedIndex].value;

 	loadissues(CONTEXT,ISSUE_ARGS);
}


/**
 *	Reorder the solutions tab
 */
function reorderSolutions(){
	// change the sort and orderby ARG values
	SOLUTION_ARGS['start'] = 0;
	SOLUTION_ARGS['sort'] = $('select-sort-solution').options[$('select-sort-solution').selectedIndex].value;
	SOLUTION_ARGS['orderby'] = $('select-orderby-solution').options[$('select-orderby-solution').selectedIndex].value;

	loadsolutions(CONTEXT,SOLUTION_ARGS);
}

/**
 *	Reorder the evidence tab
 */
function reorderEvidence(){
	// change the sort and orderby ARG values
	EVIDENCE_ARGS['start'] = 0;
	EVIDENCE_ARGS['sort'] = $('select-sort-evidence').options[$('select-sort-evidence').selectedIndex].value;
	EVIDENCE_ARGS['orderby'] = $('select-orderby-evidence').options[$('select-orderby-evidence').selectedIndex].value;

	loadevidence(CONTEXT,EVIDENCE_ARGS);
}

/**
 *	Reorder the users tab
 */
function reorderUsers(){
	// change the sort and orderby ARG values
	USER_ARGS['start'] = 0;
	USER_ARGS['sort'] = $('select-sort-user').options[$('select-sort-user').selectedIndex].value;
	USER_ARGS['orderby'] = $('select-orderby-user').options[$('select-orderby-user').selectedIndex].value;

	loadusers(CONTEXT,USER_ARGS);
}

/**
 *	Reorder the chats tab
 */
function reorderChats(){
	// change the sort and orderby ARG values
	CHAT_ARGS['start'] = 0;
	CHAT_ARGS['sort'] = $('select-sort-chat').options[$('select-sort-chat').selectedIndex].value;
	CHAT_ARGS['orderby'] = $('select-orderby-chat').options[$('select-orderby-chat').selectedIndex].value;

	loadchats(CONTEXT,CHAT_ARGS);
}

/**
 *	Reorder the comments tab
 */
function reorderComments(){
	// change the sort and orderby ARG values
	COMMENT_ARGS['start'] = 0;
	COMMENT_ARGS['sort'] = $('select-sort-comment').options[$('select-sort-comment').selectedIndex].value;
	COMMENT_ARGS['orderby'] = $('select-orderby-comment').options[$('select-orderby-comment').selectedIndex].value;

	loadcomments(CONTEXT,COMMENT_ARGS);
}

/**
 *	Filter the pro by search criteria
 */
 function filterSearchPros() {
 	PRO_ARGS['q'] = $('qpro').value;
 	var scope = 'all';
 	PRO_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+PRO_ARGS['userid']+"&type=userpro&format=text&q="+PRO_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					PRO_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.pro = false;
				setTabPushed($('tab-pro-list-obj'),'data-pro');
			}
		});
	} else {
		DATA_LOADED.pro = false;
		setTabPushed($('tab-pro-list-obj'),'data-pro');
	}
 }

/**
 *	Filter the cons by search criteria
 */
function filterSearchCons() {
	CON_ARGS['q'] = $('qcon').value;
	var scope = 'all';
	CON_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+CON_ARGS['userid']+"&type=usercon&format=text&q="+CON_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					CON_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.con = false;
				setTabPushed($('tab-con-list-obj'),'data-con');
			}
		});
	} else {
		DATA_LOADED.con = false;
		setTabPushed($('tab-con-list-obj'),'data-con');
	}
}

/**
 *	Filter the maps by search criteria
 */
function filterSearchMaps() {
	MAP_ARGS['q'] = $('qmap').value;
	var scope = 'all';
	MAP_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+MAP_ARGS['userid']+"&type=usermap&format=text&q="+MAP_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					MAP_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.challenge = false;
				setTabPushed($('tab-map-list-obj'),'data-map');
			}
		});
	} else {
		DATA_LOADED.challenge = false;
		setTabPushed($('tab-map-list-obj'),'data-map');
	}
}

/**
 *	Filter the challenges by search criteria
 */
function filterSearchChallenges() {
	CHALLENGE_ARGS['q'] = $('qchallenge').value;
	var scope = 'all';
	CHALLENGE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+CHALLENGE_ARGS['userid']+"&type=userchallenge&format=text&q="+CHALLENGE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					CHALLENGE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.challenge = false;
				setTabPushed($('tab-challenge-list-obj'),'data-challenge');
			}
		});
	} else {
		DATA_LOADED.challenge = false;
		setTabPushed($('tab-challenge-list-obj'),'data-challenge');
	}
}

/**
 *	Filter the issues by search criteria
 */
function filterSearchIssues() {
	ISSUE_ARGS['q'] = $('qissue').value;
	var scope = 'all';
	ISSUE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+ISSUE_ARGS['userid']+"&type=userissue&format=text&q="+ISSUE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					ISSUE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.issue = false;
				setTabPushed($('tab-issue-list-obj'),'data-issue');
			}
		});
	} else {
		DATA_LOADED.issue = false;
		setTabPushed($('tab-issue-list-obj'),'data-issue');
	}
}

/**
 *	Filter the solutions by search criteria
 */
function filterSearchSolutions() {
	SOLUTION_ARGS['q'] = $('qsolution').value;
	var scope = 'all';
	SOLUTION_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+SOLUTION_ARGS['userid']+"&type=usersolution&format=text&q="+SOLUTION_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					SOLUTION_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.solution = false;
				setTabPushed($('tab-solution-list-obj'),'data-solution');
			}
		});
	} else {
		DATA_LOADED.solution = false;
		setTabPushed($('tab-solution-list-obj'),'data-solution');
	}
}

/**
 *	Filter the evidence by search criteria
 */
function filterSearchEvidence() {
	EVIDENCE_ARGS['q'] = $('qevidence').value;
	var scope = 'all';
	EVIDENCE_ARGS['scope'] = scope;
	if (SELECTED_NODETYPES != "") {
		NODE_ARGS['filternodetypes'] = SELECTED_NODETYPES;
	}

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+EVIDENCE_ARGS['userid']+"&type=userevidence&format=text&q="+EVIDENCE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					EVIDENCE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.evidence = false;
				setTabPushed($('tab-evidence-list-obj'),'data-evidence');
			}
		});
	} else {
		DATA_LOADED.evidence = false;
		setTabPushed($('tab-evidence-list-obj'),'data-evidence');
	}
}

/**
 *	Filter the websites by search criteria
 */
function filterSearchResources() {
	RESOURCE_ARGS['q'] = $('qweb').value;
	var scope = 'all';
	RESOURCE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+RESOURCE_ARGS['userid']+"&type=userresource&format=text&q="+CLAIM_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					RESOURCE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.resource = false;
				setTabPushed($('tab-resource-list-obj'),'data-resource');
			}
		});
	} else {
		DATA_LOADED.resource = false;
		setTabPushed($('tab-resource-list-obj'),'data-resource');
	}
}

/**
 *	Filter the users by search criteria
 */
function filterSearchComments() {
	COMMENT_ARGS['q'] = $('qcomment').value;
	var scope = 'all';
	COMMENT_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+NODE_ARGS['userid']+"&type=usercomment&format=text&q="+NODE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					COMMENT_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.comment = false;
				setTabPushed($('tab-comment-list-obj'),'data-comment');
			}
		});
	} else {
		DATA_LOADED.comment = false;
		setTabPushed($('tab-comment-list-obj'),'data-comment');
	}
}

/**
 *	Filter the users by search criteria
 */
function filterSearchChats() {
	CHAT_ARGS['q'] = $('qchat').value;
	var scope = 'all';
	CHAT_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+NODE_ARGS['userid']+"&type=userchat&format=text&q="+NODE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					CHAT_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.chat = false;
				setTabPushed($('tab-chat-list-obj'),'data-chat');
			}
		});
	} else {
		DATA_LOADED.chat = false;
		setTabPushed($('tab-chat-list-obj'),'data-chat');
	}
}

/**
 * show the sort form
 */
function displaySortForm(sortOpts,args,tab,handler){

	var sbTool = new Element("span", {'class':'sortback toolbar2'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?> ");

    var selOrd = new Element("select");
 	Event.observe(selOrd,'change',handler);
    selOrd.id = "select-orderby-"+tab;
    selOrd.className = "toolbar";
    selOrd.name = "orderby";
    sbTool.insert(selOrd);
    for(var key in sortOpts){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortOpts[key].valueOf());
        selOrd.insert(opt);
        if(args.orderby == key){
        	opt.selected = true;
        }
    }
    var sortBys = {ASC: '<?php echo $LNG->SORT_ASC; ?>', DESC: '<?php echo $LNG->SORT_DESC; ?>'};
    var sortBy = new Element("select");
 	Event.observe(sortBy,'change',handler);
    sortBy.id = "select-sort-"+tab;
    sortBy.className = "toolbar";
    sortBy.name = "sort";
    sbTool.insert(sortBy);
    for(var key in sortBys){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortBys[key]);
        sortBy.insert(opt);
        if(args.sort == key){
        	opt.selected = true;
        }
    }

    return sbTool;
}

/**
 * Called by the node type popup after node types have been selected.
 */
function setSelectedNodeTypes(types) {
	SELECTED_NODETYPES = types;

	if ($('select-filter-conn')) {
		$('select-filter-conn').options[0].selected = true;
	} else if ($('select-filter-neighbourhood')) {
		$('select-filter-neighbourhood').options[0].selected = true;
	} else if ($('nodetypegroups')) {
		($('nodetypegroups')).options[0].selected = true;
	}
}

/**
 * Called by the link type popup after link types have been selected.
 */
function setSelectedLinkTypes(types) {
	SELECTED_LINKTYES = types;

	if ($('select-filter-conn')) {
		$('select-filter-conn').options[0].selected = true;
	} else if ($('select-filter-neighbourhood')) {
		$('select-filter-neighbourhood').options[0].selected = true;
	} else if ($('linktypegroups')) {
		($('linktypegroups')).options[0].selected = true;
	}
}

/**
 * Called by the users popup after users have been selected.
 */
function setSelectedUsers(types) {
	SELECTED_USERS = types;
}

function createConnectedFilter(context, args, type) {

	var sbTool = new Element("span", {'class':'orgbackpale toolbar2'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar'});

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->ALL_ITEMS_FILTER; ?>');
	filterMenu.insert(option);

	var option = new Element("option", {'value':'connected'});
	if (args['filterbyconnection'] && args['filterbyconnection'] == "connected") {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->CONNECTED_ITEMS_FILTER; ?>");
	filterMenu.insert(option);

	var option2 = new Element("option", {'value':'unconnected'});
	if (args['filterbyconnection'] && args['filterbyconnection'] == "unconnected") {
		option2.selected = true;
	}
	option2.insert("<?php echo $LNG->UNCONNECTED_ITEMS_FILTER; ?>");
	filterMenu.insert(option2);

	Event.observe(filterMenu,"change", function(){
		var selection = this.value;
		args['filterbyconnection'] = selection;

		if( type == 'orgs') {
			refreshOrganizations();
		} else if (type == 'pro') {
			refreshPros();
		} else if (type == 'con') {
			refreshCons();
		} else if (type == 'evidence') {
			refreshEvidence();
		} else if (type == 'issues') {
			refreshIssues();
		} else if (type == 'solutions') {
			refreshSolutions();
		} else if (type == 'web') {
			refreshResources();
		} else if (type == 'challenges') {
			refreshChallenges();
		} else if (type == 'comment') {
			refreshComments();
		} else if (type == 'maps') {
			refreshMaps();
		}
	});

	sbTool.insert(filterMenu);
	return sbTool;

}

/**
 * display Nav
 */
function createNav(total, start, count, argArray, context, type){

	var nav = new Element ("div",{'id':'page-nav', 'class':'toolbarrow', 'style':'padding-top: 8px; padding-bottom: 8px;'});

	var header = createNavCounter(total, start, count, type);
	nav.insert(header);

	if (total > parseInt( argArray["max"] )) {
		//previous
	    var prevSpan = new Element("span", {'id':"nav-previous"});
	    if(start > 0){
			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-left2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
	        prevSpan.addClassName("active");
	        Event.observe(prevSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) - newArr["max"];
	            eval("load"+type+"(context,newArr)");
	        });
	    } else {
			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' disabled src='<?php echo $HUB_FLM->getImagePath("arrow-left2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
	        prevSpan.addClassName("inactive");
	    }

	    var pageSpan = new Element("span", {'id':"nav-pages"});
	    var totalPages = Math.ceil(total/argArray["max"]);
	    var currentPage = (start/argArray["max"]) + 1;
	    for (var i = 1; i<totalPages+1; i++){
	    	var page = new Element("span", {'class':"nav-page"}).insert(i);
	    	if(i != currentPage){
		    	page.addClassName("active");
		    	var newArr = Object.clone(argArray);
		    	newArr["start"] = newArr["max"] * (i-1);
		    	page.newArr = newArr;
		        Event.observe(page,"click", function(){
		            var newArr = this.newArr;
		            eval("load"+type+"(context,newArr)");
		        });
	    	} else {
	    		page.addClassName("currentpage");
	    	}
	    	pageSpan.insert(page);
	    }

	    //next
	    var nextSpan = new Element("span", {'id':"nav-next"});
	    if(parseInt(start)+parseInt(count) < parseInt(total)){
		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
	        nextSpan.addClassName("active");
	        Event.observe(nextSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
	            eval("load"+type+"(context, newArr)");
	        });
	    } else {
		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2-disabled.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
	        nextSpan.addClassName("inactive");
	    }

	    if( start>0 || (parseInt(start)+parseInt(count) < parseInt(total))){
	    	nav.insert(prevSpan).insert(pageSpan).insert(nextSpan);
	    }
	}

	return nav;
}

/**
 * display nav header
 */
function createNavCounter(total, start, count, type){

    if(count != 0){
    	var objH = new Element("span",{'class':'nav'});
    	var s1 = parseInt(start)+1;
    	var s2 = parseInt(start)+parseInt(count);
        objH.insert("<b>" + s1 + " <?php echo $LNG->LIST_NAV_TO; ?> " + s2 + " (" + total + ")</b>");
    } else {
    	var objH = new Element("span");
		switch(type){
			case 'con':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_CON; ?></b></p>");
				break;
			case 'pro':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_PRO; ?></b></p>");
				break;
			case 'issues':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_ISSUE; ?></b></p>");
				break;
			case 'solutions':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_SOLUTION; ?></b></p>");
				break;
			case 'evidence':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_EVIDENCE; ?></b></p>");
				break;
			case 'maps':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_MAP; ?></b></p>");
				break;
			case 'challenges':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_CHALLENGE; ?></b></p>");
				break;
			case 'urls':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_RESOURCE; ?></b></p>");
				break;
			case 'comments':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_COMMENT; ?></b></p>");
				break;
			case 'chats':
				objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_CHAT; ?></b></p>");
				break;
		}
    }
    return objH;
}

/**
 * load JS file for creating the connection network (applet) for a user's social network
 */
function loadUserHomeNet(){
	var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/social-user-net.js.php"); ?>');
    bObj.buildScriptTag();
    bObj.addScriptTag();
}