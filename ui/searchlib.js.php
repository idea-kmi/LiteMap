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
/**
 * Functions for the search results page 'search.php'.
 */

/**
 *	Add the filter and sort controls for the page.
 */
function addControls(container) {
	var tb3 = new Element("div", {'class':'toolbarrowsearch'});
	var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
	tb3.insert(displaySortForm(sortOpts));
	container.insert(tb3);
}

function buildSearchToolbar(container) {
	addControls(container);
}

/**
 *	load next/previous set of nodes
 */
function loadissues(context,args){
	args['filternodetypes'] = "Issue";

	$("content-issue-list").update(getLoading("<?php echo $LNG->LOADING_ISSUES; ?>"));

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

				//set the count in header
				$('issue-list-count').innerHTML = "";
				$('issue-list-count-main').innerHTML = "";
				$('content-issue-list').innerHTML = "";
				$('issue-list-title').innerHTML = "";

				$('content-issue-main').style.display = "block";
				$('issue-result-menu').href = "#issueresult";
				$('issue-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-issue-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));
				}

				$('issue-list-count').insert(json.nodeset[0].totalno);
				$('issue-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("issue-list-title").insert("<?php echo $LNG->ISSUES_NAME; ?>");
				} else {
					$("issue-list-title").insert("<?php echo $LNG->ISSUE_NAME; ?>");
				}

				displaySearchNodes($("content-issue-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-issue-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));
				}
			} else {
				$('content-issue-main').style.display = "none";
				$('content-issue-list').innerHTML = "";
				$('issue-result-menu').href = "javascript:return false";
				$('issue-result-menu').className = 'inactive';
				$('issue-list-count-main').innerHTML = "";
				$('issue-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of nodes
 */
function loadsolutions(context,args){
	args['filternodetypes'] = "Solution";

	$("content-solution-list").update(getLoading("<?php echo $LNG->LOADING_SOLUTIONS; ?>"));

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

				//set the count in header
				$('solution-list-count').innerHTML = "";
				$('solution-list-count-main').innerHTML = "";
				$('content-solution-list').innerHTML = "";
				$('solution-list-title').innerHTML = "";

				$('content-solution-main').style.display = "block";
				$('solution-result-menu').href = "#solutionresult";
				$('solution-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-solution-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));
				}

				$('solution-list-count').insert(json.nodeset[0].totalno);
				$('solution-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("solution-list-title").insert("<?php echo $LNG->SOLUTIONS_NAME; ?>");
				} else {
					$("solution-list-title").insert("<?php echo $LNG->SOLUTION_NAME; ?>");
				}
				displaySearchNodes($("content-solution-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-solution-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));
				}
			} else {
				$('content-solution-main').style.display = "none";
				$('content-solution-list').innerHTML = "";
				$('solution-result-menu').href = "javascript:return false";
				$('solution-result-menu').className = 'inactive';
				$('solution-list-count-main').innerHTML = "";
				$('solution-list-count-main').insert('0');
			}
		}
	});
}


/**
 *	load next/previous set of pro nodes
 */
function loadpros(context,args){

	var types = "Pro";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$('content-pro-main').style.display = "block";
	$("content-pro-list").update(getLoading("<?php echo $LNG->LOADING_PROS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	console.log(reqUrl);

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

				//set the count in tab header
				$('pro-list-count').innerHTML = "";
				$('pro-list-count-main').innerHTML = "";
				$('content-pro-list').innerHTML = "";
				$('pro-list-title').innerHTML = "";

				if (total > parseInt( args["max"] )) {
					$("content-pro-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"pro"));
				}

				$('content-pro-main').style.display = "block";
				$('pro-result-menu').href = "#proresult";
				$('pro-result-menu').className = '';

				$('pro-list-count').insert(json.nodeset[0].totalno);
				$('pro-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("pro-list-title").insert("<?php echo $LNG->PROS_NAME; ?>");
				} else {
					$("pro-list-title").insert("<?php echo $LNG->PRO_NAME; ?>");
				}
				displaySearchNodes($("content-pro-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-pro-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"pro"));
				}
			} else {
				$('content-pro-main').style.display = "none";
				$('content-pro-list').innerHTML = "";
				$('pro-result-menu').href = "javascript:return false";
				$('pro-result-menu').className = 'inactive';
				$('pro-list-count-main').innerHTML = "";
				$('pro-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of evidence nodes
 */
function loadcons(context,args) {

	var types = "Con";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$('content-con-main').style.display = "block";
	$("content-con-list").update(getLoading("<?php echo $LNG->LOADING_CONS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	console.log(reqUrl);

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

				//set the count in header
				$('con-list-count').innerHTML = "";
				$('con-list-count-main').innerHTML = "";
				$('content-con-list').innerHTML = "";
				$('con-list-title').innerHTML = "";

				$('content-con-main').style.display = "block";
				$('con-result-menu').href = "#conresult";
				$('con-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-con-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"con"));
				}

				$('con-list-count').insert(json.nodeset[0].totalno);
				$('con-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("con-list-title").insert("<?php echo $LNG->CONS_NAME; ?>");
				} else {
					$("con-list-title").insert("<?php echo $LNG->CON_NAME; ?>");
				}

				displaySearchNodes($("content-con-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-evidence-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"con"));
				}
			} else {
				$('content-con-main').style.display = "none";
				$('content-con-list').innerHTML = "";
				$('con-result-menu').href = "javascript:return false";
				$('con-result-menu').className = 'inactive';
				$('con-list-count-main').innerHTML = "";
				$('con-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of argument nodes
 */
function loadarguments(context,args){

	var types = "Argument";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$('content-arg-main').style.display = "block";
	$("content-arg-list").update(getLoading("<?php echo $LNG->LOADING_EVIDENCES; ?>"));

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

				//set the count in tab header
				$('arg-list-count').innerHTML = "";
				$('arg-list-count-main').innerHTML = "";
				$('content-arg-list').innerHTML = "";
				$('arg-list-title').innerHTML = "";

				if (total > parseInt( args["max"] )) {
					$("content-arg-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"arg"));
				}

				$('content-arg-main').style.display = "block";
				$('arg-result-menu').href = "#argresult";
				$('arg-result-menu').className = '';

				$('arg-list-count').insert(json.nodeset[0].totalno);
				$('arg-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("arg-list-title").insert("<?php echo $LNG->ARGUMENTS_NAME; ?>");
				} else {
					$("arg-list-title").insert("<?php echo $LNG->ARGUMENT_NAME; ?>");
				}
				displaySearchNodes($("content-arg-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-arg-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"pro"));
				}
			} else {
				$('content-arg-main').style.display = "none";
				$('content-arg-list').innerHTML = "";
				$('arg-result-menu').href = "javascript:return false";
				$('arg-result-menu').className = 'inactive';
				$('arg-list-count-main').innerHTML = "";
				$('arg-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of nodes
 */
function loadmaps(context,args){
	args['filternodetypes'] = "Map";

	$("content-issue-list").update(getLoading("<?php echo $LNG->LOADING_MAPS; ?>"));

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

				//set the count in header
				$('map-list-count').innerHTML = "";
				$('map-list-count-main').innerHTML = "";
				$('content-map-list').innerHTML = "";
				$('map-list-title').innerHTML = "";

				$('content-map-main').style.display = "block";
				$('map-result-menu').href = "#mapresult";
				$('map-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-map-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"maps"));
				}

				$('map-list-count').insert(json.nodeset[0].totalno);
				$('map-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("map-list-title").insert("<?php echo $LNG->MAPS_NAME; ?>");
				} else {
					$("map-list-title").insert("<?php echo $LNG->MAP_NAME; ?>");
				}

				displaySearchNodes($("content-map-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-map-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"maps"));
				}
			} else {
				$('content-map-main').style.display = "none";
				$('content-map-list').innerHTML = "";
				$('map-result-menu').href = "javascript:return false";
				$('map-result-menu').className = 'inactive';
				$('map-list-count-main').innerHTML = "";
				$('map-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of users
 */
function loadusers(context,args){

	$("content-user-list").update(getLoading("<?php echo $LNG->LOADING_USERS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getusersby" + context + "&includegroups=false&" + Object.toQueryString(args);

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

			var total = json.userset[0].totalno;

			if(json.userset[0].count > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var users = json.userset[0].users;
					var count = users.length;
					for (var i=0; i<count; i++) {
						var user = users[i].user;
						user.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('user-list-count').innerHTML = "";
				$('user-list-count-main').innerHTML = "";
				$('content-user-list').innerHTML = "";
				$('user-list-title').innerHTML = "";

				$('user-result-menu').href = "#userresult";
				$('user-result-menu').className = '';

				$('content-user-main').style.display = "block";

				if (total > parseInt( args["max"] )) {
					$("content-user-list").update(createNav(total,json.userset[0].start,json.userset[0].count,args,context,"users"));
				}

				$('user-list-count').insert(json.userset[0].totalno);
				$('user-list-count-main').insert(json.userset[0].totalno);

				if (json.userset[0].users.length > 1) {
					$("user-list-title").insert("<?php echo $LNG->USERS_NAME; ?>");
				} else {
					$("user-list-title").insert("<?php echo $LNG->USER_NAME; ?>");
				}

				if (json.userset[0].users.length > 1) {
					var tb2 = new Element("div", {'class':'toolbarrow'});
					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_NAME; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>'};
					tb2.insert(displaySortForm(sortOpts,args,'user',reorderUsers));
					$("content-user-list").insert(tb2);
					$("content-user-list").insert("<br><br>");
				}

				displayUsers($("content-user-list"),json.userset[0].users,parseInt(args['start'])+1);

				if (total > parseInt( args["max"] )) {
					$("content-user-list").insert(createNav(total,json.userset[0].start,json.userset[0].count,args,context,"users"));
				}
			} else {
				$('content-user-main').style.display = "none";
				$('content-user-list').innerHTML = "";
				$('user-result-menu').href = "javascript:return false";
				$('user-result-menu').className = 'inactive';
				$('user-list-count-main').innerHTML = "";
				$('user-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of groups
 */
function loadgroups(context,args){

	$("content-group-list").update(getLoading("<?php echo $LNG->LOADING_GROUPS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getgroupsby" + context + "&" + Object.toQueryString(args);

	//alert(reqUrl);

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

			var total = json.groupset[0].totalno;

			//alert(json.groupset[0].totalno);
			//alert(json.groupset[0].count);

			if(json.groupset[0].count > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var groups = json.groupset[0].groups;
					var count = groups.length;
					for (var i=0; i<count; i++) {
						var group = groups[i];
						if (group) {
							group.searchid = args['searchid'];
						}
					}
				}

				//set the count in header
				$('group-list-count').innerHTML = "";
				$('group-list-count-main').innerHTML = "";
				$('content-group-list').innerHTML = "";
				$('group-list-title').innerHTML = "";

				$('group-result-menu').href = "#groupresult";
				$('group-result-menu').className = '';

				$('content-group-main').style.display = "block";

				if (total > parseInt( args["max"] )) {
					$("content-group-list").update(createNav(total,json.groupset[0].start,json.userset[0].count,args,context,"groups"));
				}

				$('group-list-count').insert(json.groupset[0].totalno);
				$('group-list-count-main').insert(json.groupset[0].totalno);

				if (json.groupset[0].groups.length > 1) {
					$("group-list-title").insert("<?php echo $LNG->GROUPS_NAME; ?>");
				} else {
					$("group-list-title").insert("<?php echo $LNG->GROUP_NAME; ?>");
				}

				if (json.groupset[0].groups.length > 1) {
					var tb2 = new Element("div", {'class':'toolbarrow'});
					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_NAME; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>'};
					tb2.insert(displaySortForm(sortOpts,args,'group',reorderGroups));
					$("content-group-list").insert(tb2);
					$("content-group-list").insert("<br><br>");
				}

				displayGroups($("content-group-list"),json.groupset[0].groups,parseInt(args['start'])+1, "400px","200px", false, true);

				if (total > parseInt( args["max"] )) {
					$("content-group-list").insert(createNav(total,json.groupset[0].start,json.userset[0].count,args,context,"groups"));
				}
			} else {
				$('content-group-main').style.display = "none";
				$('content-group-list').innerHTML = "";
				$('group-result-menu').href = "javascript:return false";
				$('group-result-menu').className = 'inactive';
				$('group-list-count-main').innerHTML = "";
				$('group-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load chat nodes for search
 */
function loadchat(context,args) {

	var types = 'Comment';

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-chat-list").update(getLoading("<?php echo $LNG->LOADING_RESOURCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var total = json.nodeset[0].totalno;

			if(total > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('chat-list-count').innerHTML = "";
				$('chat-list-count-main').innerHTML = "";
				$('content-chat-list').innerHTML = "";
				$('chat-list-title').innerHTML = "";

				$('content-chat-main').style.display = "block";
				$('chat-result-menu').href = "#chatresult";
				$('chat-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-chat-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));
				}

				$('chat-list-count').insert(json.nodeset[0].totalno);
				$('chat-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("chat-list-title").insert("<?php echo $LNG->CHATS_NAME; ?>");
				} else {
					$("chat-list-title").insert("<?php echo $LNG->CHAT_NAME; ?>");
				}
				displaySearchNodes($("content-chat-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-chat-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));
				}
			} else {
				$('content-chat-main').style.display = "none";
				$('content-chat-list').innerHTML = "";
				$('chat-result-menu').href = "javascript:return false";
				$('chat-result-menu').className = 'inactive';
				$('chat-list-count-main').innerHTML = "";
				$('chat-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load comment nodes for search
 */
function loadcomments(context,args) {

	var types = 'Idea';

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-idea-list").update(getLoading("<?php echo $LNG->LOADING_COMMENTS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var total = json.nodeset[0].totalno;

			if(total > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('idea-list-count').innerHTML = "";
				$('idea-list-count-main').innerHTML = "";
				$('content-idea-list').innerHTML = "";
				$('idea-list-title').innerHTML = "";

				$('content-idea-main').style.display = "block";
				$('idea-result-menu').href = "#idearesult";
				$('idea-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-idea-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));
				}

				$('idea-list-count').insert(json.nodeset[0].totalno);
				$('idea-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("idea-list-title").insert("<?php echo $LNG->COMMENTS_NAME; ?>");
				} else {
					$("idea-list-title").insert("<?php echo $LNG->COMMENT_NAME; ?>");
				}
				displaySearchNodes($("content-idea-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-idea-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));
				}
			} else {
				$('content-idea-main').style.display = "none";
				$('content-idea-list').innerHTML = "";
				$('idea-result-menu').href = "javascript:return false";
				$('idea-result-menu').className = 'inactive';
				$('idea-list-count-main').innerHTML = "";
				$('idea-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load news nodes for search
 */
function loadnews(context,args) {

	var types = 'News';

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-news-list").update(getLoading("<?php echo $LNG->LOADING_ITEMS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var total = json.nodeset[0].totalno;

			if(total > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('news-list-count').innerHTML = "";
				$('news-list-count-main').innerHTML = "";
				$('content-news-list').innerHTML = "";
				$('news-list-title').innerHTML = "";

				$('content-news-main').style.display = "block";
				$('news-result-menu').href = "#newsresult";
				$('news-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-news-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"news"));
				}

				$('news-list-count').insert(json.nodeset[0].totalno);
				$('news-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("news-list-title").insert("<?php echo $LNG->NEWSS_NAME; ?>");
				} else {
					$("news-list-title").insert("<?php echo $LNG->NEWS_NAME; ?>");
				}
				displaySearchNodes($("content-news-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-news-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"news"));
				}
			} else {
				$('content-news-main').style.display = "none";
				$('news-result-menu').href = "javascript:return false";
				$('news-result-menu').className = 'inactive';
				$('news-list-count-main').innerHTML = "";
				$('news-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	Reorder the groups tab
 */
function reorderGroups(){
	// change the sort and orderby ARG values
	GROUP_ARGS['start'] = 0;
	GROUP_ARGS['sort'] = $('select-sort-group').options[$('select-sort-group').selectedIndex].value;
	GROUP_ARGS['orderby'] = $('select-orderby-group').options[$('select-orderby-group').selectedIndex].value;

	loadgroups(CONTEXT,GROUP_ARGS);
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
 * show the sort form
 */
function displayUserSortForm(sortOpts,args,tab,handler){

	var sbTool = new Element("span", {'class':'sortback toolbar2'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?>: ");

    var selOrd = new Element("select");
    selOrd.id = "select-orderby-"+tab;
    selOrd.className = "toolbar";
    selOrd.name = "orderby";
 	Event.observe(selOrd,'change',handler);
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
    sortBy.id = "select-sort-"+tab;
    sortBy.className = "toolbar";
    sortBy.name = "sort";
 	Event.observe(sortBy,'change',handler);
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
 * Handle when the sort menus are changed
 */
function handleSort() {
	// used as global holding space
	NODE_ARGS['start'] = 0;
	NODE_ARGS['sort'] = $('select-sort-node').options[$('select-sort-node').selectedIndex].value;
	NODE_ARGS['orderby'] = $('select-orderby-node').options[$('select-orderby-node').selectedIndex].value;

	ISSUE_ARGS['start'] = 0;
	ISSUE_ARGS['sort'] = NODE_ARGS['sort'];
	ISSUE_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadissues(CONTEXT,ISSUE_ARGS);

	SOLUTION_ARGS['start'] = 0;
	SOLUTION_ARGS['sort'] = NODE_ARGS['sort'];
	SOLUTION_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadsolutions(CONTEXT,SOLUTION_ARGS);

	PRO_ARGS['start'] = 0;
	PRO_ARGS['sort'] = NODE_ARGS['sort'];
	PRO_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadchallenges(CONTEXT,PRO_ARGS);

	CON_ARGS['start'] = 0;
	CON_ARGS['sort'] = NODE_ARGS['sort'];
	CON_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadclaims(CONTEXT,CON_ARGS);

	CHAT_ARGS['start'] = 0;
	CHAT_ARGS['sort'] = NODE_ARGS['sort'];
	CHAT_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadchats(CONTEXT,CHAT_ARGS);

	COMMENT_ARGS['start'] = 0;
	COMMENT_ARGS['sort'] = NODE_ARGS['sort'];
	COMMENT_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadcomments(CONTEXT,COMMENT_ARGS);

	NEWS_ARGS['start'] = 0;
	NEWS_ARGS['sort'] = NODE_ARGS['sort'];
	NEWS_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadnews(CONTEXT,NEWS_ARGS);
}

/**
 * show the sort form
 */
function displaySortForm(sortOpts){

	var sbTool = new Element("span", {'class':'sortback toolbar2'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?>: ");

    var selOrd = new Element("select");
    selOrd.id = "select-orderby-node";
    selOrd.className = "toolbar";
    selOrd.name = "orderby";
    sbTool.insert(selOrd);
 	Event.observe(selOrd,'change',handleSort);
    for(var key in sortOpts){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortOpts[key].valueOf());
        selOrd.insert(opt);
        if(NODE_ARGS.orderby == key){
        	opt.selected = true;
        }
    }
    var sortBys = {ASC: '<?php echo $LNG->SORT_ASC; ?>', DESC: '<?php echo $LNG->SORT_DESC; ?>'};
    var sortBy = new Element("select");
    sortBy.id = "select-sort-node";
    sortBy.className = "toolbar";
    sortBy.name = "sort";
    sbTool.insert(sortBy);
 	Event.observe(sortBy,'change',handleSort);
    for(var key in sortBys){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortBys[key]);
        sortBy.insert(opt);
        if(NODE_ARGS.sort == key){
        	opt.selected = true;
        }
    }

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
			prevSpan.update("<img alt='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' title='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-left2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
	        prevSpan.addClassName("active");
	        Event.observe(prevSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) - newArr["max"];
	            eval("load"+type+"(context,newArr)");
	        });
	    } else {
			prevSpan.update("<img alt='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' title='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' disabled src='<?php echo $HUB_FLM->getImagePath("arrow-left2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
	        prevSpan.addClassName("inactive");
	    }

	    //pages
	    var pageSpan = new Element("span", {'id':"nav-pages"});
	    var totalPages = Math.ceil(total/argArray["max"]);
	    var currentPage = (start/argArray["max"]) + 1;
	    for (var i = 1; i<totalPages+1; i++){
	    	var page = new Element("span", {'class':"nav-page"}).insert(i);
	    	if(i != currentPage){
		    	page.addClassName("active");
		    	var newArr = Object.clone(argArray);
		    	newArr["start"] = newArr["max"] * (i-1) ;
		    	Event.observe(page,"click", Pages.next.bindAsEventListener(Pages,type,context,newArr));
	    	} else {
	    		page.addClassName("currentpage");
	    	}
	    	pageSpan.insert(page);
	    }

	    //next
	    var nextSpan = new Element("span", {'id':"nav-next"});
	    if(parseInt(start)+parseInt(count) < parseInt(total)){
		    nextSpan.update("<img alt='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' title='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
	        nextSpan.addClassName("active");
	        Event.observe(nextSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
	            eval("load"+type+"(context, newArr)");
	        });
	    } else {
		    nextSpan.update("<img alt='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' title='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2-disabled.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
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
        objH.insert("<b>" + s1 + " to " + s2 + " (" + total + ")</b>");
    }
    return objH;
}

var Pages = {
	next: function(e){
		var data = $A(arguments);
		eval("load"+data[1]+"(data[2],data[3])");
	}
};