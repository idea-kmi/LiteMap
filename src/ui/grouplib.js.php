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
var TABS = {"map":true, "search":true };
var DATA_LOADED = {"map":false, "search":false};
var DEFAULT_TAB = 'map';
var CURRENT_TAB = DEFAULT_TAB;

//define events for clicking on the tabs
var stpMapList = setTabPushed.bindAsEventListener($('tab-map-list-obj'),'map-list');
var stpSearchList = setTabPushed.bindAsEventListener($('tab-search-list-obj'),'search-list');

/**
 *	set which tab to show and load first
 */
Event.observe(window, 'load', function() {
	addControls($("content-controls"));

	var itemobj = renderGroup(groupObj, "100%", "", true, false);
	$('maingroupdiv').insert(itemobj);

	Event.observe('tab-map','click', stpMapList);
	Event.observe('tab-search','click', stpSearchList);

	setTabPushed($('tab-'+getAnchorVal(DEFAULT_TAB)),getAnchorVal(DEFAULT_TAB));
});

/**
 *	switch between tabs
 */
function setTabPushed(e) {

	var data = $A(arguments);
	var tabID = data[1];

	var parts = tabID.split("-");
	var tab = parts[0];
	var page=1;
	if (parts.length > 1) {
		page = parseInt(parts[1]);
	}

	// Check tab is know else default to default
	if (!TABS.hasOwnProperty(tab)) {
		tab = DEFAULT_TAB;
	}

	var i="";
	for (i in TABS){
		if(tab == i){
			if($("tab-"+i)) {
				$("tab-"+i).removeClassName("unselected");
				$("tab-"+i).addClassName("current");
			}
		} else {
			if($("tab-"+i)) {
				$("tab-"+i).removeClassName("current");
				$("tab-"+i).addClassName("unselected");
			}
		}
		if(tab == i){
			if ($("tab-content-"+i+"-div")) {
				$("tab-content-"+i+"-div").show();
			}
		} else {
			if ($("tab-content-"+i+"-div")) {
				$("tab-content-"+i+"-div").hide();
			}
		}
	}

	CURRENT_TAB = tab;

	switch(tab) {
		case 'map':
			$('tab-map').setAttribute("href",'#map-list');
			Event.stopObserving('tab-map','click');
			Event.observe('tab-map','click', stpMapList);
			if(!DATA_LOADED.map){
				MAP_ARGS['start'] = (page-1) * MAP_ARGS['max'];
				refreshGroupMaps();
			} else {
				updateAddressParameters(MAP_ARGS);
			}
			break;
		case 'search':
			$('tab-search').setAttribute("href",'#search-list');
			Event.stopObserving('tab-search','click');
			Event.observe('tab-search','click', stpSearchList);
			if(!DATA_LOADED.search) {
				loadsearch();
			}
			break;
	}
}

/**
 *	Called by forms to refresh the maps view
 */
function refreshGroupMaps() {
	loadgroupmaps(CONTEXT,MAP_ARGS);
}

function refreshGroupSearch() {
	DATA_LOADED.search = false;

	ISSUE_ARGS['q'] = $('qmap').value;
	SOLUTION_ARGS['q'] = $('qmap').value;
	PRO_ARGS['q'] = $('qmap'.value);
	CON_ARGS['q'] = $('qmap').value;
	ARGUMENT_ARGS['q'] = $('qmap').value;
	MAP_ARGS['q'] = $('qmap').value;
	CHAT_ARGS['q'] = $('qmap').value;
	COMMENT_ARGS['q'] = $('qmap').value;
	//URL_ARGS['q'] = $('qmap').value;

	MAP_ARGS['gq'] = $('qmap').value;
	updateAddressParameters(MAP_ARGS);

	setTabPushed($('tab-search'),'search');
}

function loadsearch() {
	loadissues(CONTEXT,ISSUE_ARGS);
	loadsolutions(CONTEXT,SOLUTION_ARGS);
	loadpros(CONTEXT,PRO_ARGS);
	loadcons(CONTEXT,CON_ARGS);
	loadarguments(CONTEXT,ARGUMENT_ARGS);
	loadmaps(CONTEXT,MAP_ARGS);
	loadchat(CONTEXT,CHAT_ARGS);
	loadcomments(CONTEXT,COMMENT_ARGS);
	//loadurls(CONTEXT,URL_ARGS);

	DATA_LOADED.search = true;
}

function changeGroupMode(obj, mode) {
	var wasPressed = false
	if (obj.className == "radiobuttonpressed") {
		wasPressed = true;
	}
	$('radiobuttonsum').className = "radiobutton";
	$('radiobuttonshare').className = "radiobutton";
	if (!wasPressed) {
		obj.className = "radiobuttonpressed";
	}

	if (mode == 'Summarize') {
	}
}

/**
 *	Called by forms to refresh the issues view
 */
function refreshGroupMaps() {
	loadgroupmaps(CONTEXT,MAP_ARGS);
}

/**
 *	load next/previous set of nodes
 */
function loadgroupmaps(context,args){
	args['filternodetypes'] = "MAP";

	updateAddressParameters(args);

	$("tab-content-map-list").update(getLoading("<?php echo $LNG->LOADING_MAPS; ?>"));

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
				var currentPage = (json.nodeset[0].start/args["max"]) + 1;
				window.location.hash = "-"+currentPage;

				$("tab-content-map-list").update(createGroupNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"groupmaps"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){

					//preprosses nodes to add searchid and groupid
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					var positivevotes = 0;
					var negativevotes=0;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						if (args['searchid'] && args['searchid'] != "") {
							node.cnode.searchid = args['searchid'];
						}
						node.cnode.groupid = args['groupid'];
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displayGroupSortForm(sortOpts,args,'map',reorderGroupMaps));

					$("tab-content-map-list").insert(tb3);

					displayMapNodes(383, 210, $("tab-content-map-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true, "groupmaps", 'active', false, true, true);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-map-list").insert(createGroupNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"groupmaps"));
				}

				DATA_LOADED.map = true;
    		}
  		});
}

/**
*	Reorder the issue tab
*/
function reorderGroupMaps(){
 	// change the sort and orderby ARG values
 	MAP_ARGS['start'] = 0;
 	MAP_ARGS['sort'] = $('select-sort-map').options[$('select-sort-map').selectedIndex].value;
 	MAP_ARGS['orderby'] = $('select-orderby-map').options[$('select-orderby-map').selectedIndex].value;

 	loadgroupmaps(CONTEXT,MAP_ARGS);
}

/**
 * show the sort form
 */
function displayGroupSortForm(sortOpts,args,tab,handler){

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
 * display Nav
 */
function createGroupNav(total, start, count, argArray, context, type){

	var nav = new Element ("div",{'id':'page-nav', 'class':'toolbarrow', 'style':'padding-top: 8px; padding-bottom: 8px;'});

	var header = createGroupNavCounter(total, start, count, type);
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
		    	Event.observe(page,"click", GroupPages.next.bindAsEventListener(GroupPages,type,context,newArr));
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
function createGroupNavCounter(total, start, count, type){

    if(count != 0){
    	var objH = new Element("span",{'class':'nav'});
    	var s1 = parseInt(start)+1;
    	var s2 = parseInt(start)+parseInt(count);
        objH.insert("<b>" + s1 + " <?php echo $LNG->LIST_NAV_TO; ?> " + s2 + " (" + total + ")</b>");
    } else {
    	var objH = new Element("span");
        objH.insert("<b><?php echo $LNG->LIST_NAV_NO_ITEMS; ?></b>");
    }
    return objH;
}

var GroupPages = {
	next: function(e){
		var data = $A(arguments);
		eval("load"+data[1]+"(data[2],data[3])");
	}
};
