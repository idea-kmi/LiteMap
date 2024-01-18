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

//this list the tabs
var TABS = {"map":true, "vis":true, "analytics":true};

var DATAVIZ = {"network":true, "circles":true, "sunburst":true, "treemap":true, "treemaptd":true};
var DATAANALYTICS = {"overview":true, "social":true, "ring":true, "activity":true, "useractivity":true, "stream":true};

var DEFAULT_TAB = 'map';
var DEFAULT_VIZ = 'view';

var CURRENT_VIZ = DEFAULT_VIZ;
var CURRENT_TAB = DEFAULT_TAB;

var DATA_LOADED = {"map":false, "network":false, "cicrles":false, "sunburst":false, "treemap":false, "treemaptd":false, "overview":false, "social":false, "ring":false, "activity":false, "useractivity":false, "stream":false};

//define events for clicking on the tabs
var stpMap = setTabPushed.bindAsEventListener($('tab-map-list-obj'),'map');
var stpVis = setTabPushed.bindAsEventListener($('tab-vis-list-obj'),'vis');
var stpAnalytics = setTabPushed.bindAsEventListener($('tab-analytics-list-obj'),'analytics');

var stpNetwork = setTabPushed.bindAsEventListener($('tab-network-list-obj'),'vis-network');
var stpCircles = setTabPushed.bindAsEventListener($('tab-circles-list-obj'),'vis-circles');
var stpSunburst = setTabPushed.bindAsEventListener($('tab-sunburst-list-obj'),'vis-sunburst');
var stpTreemap = setTabPushed.bindAsEventListener($('tab-treemap-list-obj'),'vis-treemap');
var stpTreemapTD = setTabPushed.bindAsEventListener($('tab-treemaptd-list-obj'),'vis-treemaptd');

var stpOverview = setTabPushed.bindAsEventListener($('tab-overview-list-obj'),'analytics-overview');
var stpSocial = setTabPushed.bindAsEventListener($('tab-social-list-obj'),'analytics-social');
var stpRing = setTabPushed.bindAsEventListener($('tab-ring-list-obj'),'analytics-ring');
var stpActivity = setTabPushed.bindAsEventListener($('tab-activity-list-obj'),'analytics-activity');
var stpUserActivity = setTabPushed.bindAsEventListener($('tab-useractivity-list-obj'),'analytics-useractivity');
var stpStream = setTabPushed.bindAsEventListener($('tab-stream-list-obj'),'analytics-stream');

/**
 *	set which tab to show and load first
 */
Event.observe(window, 'load', function() {
	// add events for clicking on the main tabs
	Event.observe('tab-map','click', stpMap);
	Event.observe('tab-vis','click', stpVis);
	Event.observe('tab-analytics','click', stpAnalytics);

	Event.observe('tab-vis-network','click', stpNetwork);
	Event.observe('tab-vis-circles','click', stpCircles);
	Event.observe('tab-vis-sunburst','click', stpSunburst);
	Event.observe('tab-vis-treemap','click', stpTreemap);
	Event.observe('tab-vis-treemaptd','click', stpTreemapTD);

	Event.observe('tab-analytics-overview','click', stpOverview);
	Event.observe('tab-analytics-social','click', stpSocial);
	Event.observe('tab-analytics-ring','click', stpRing);
	Event.observe('tab-analytics-activity','click', stpActivity);
	Event.observe('tab-analytics-useractivity','click', stpUserActivity);
	Event.observe('tab-analytics-stream','click', stpStream);

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
					// $("tab-"+i).removeClassName("unselected");
					$("tab-"+i).addClassName("active");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").show();
					}
				}
			} else {
				if($("tab-"+i)) {
					$("tab-"+i).removeClassName("active");
					// $("tab-"+i).addClassName("unselected");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").hide();
					}
				}
			}
		}
	}

	// Set default Vis if not stated
	if (tab == "vis") {
		if (viz == "") {
			viz = "sunburst";
		}
		for (i in DATAVIZ){
			if(viz == i){
				if ($("tab-"+tab+"-"+i)) {
					// $("tab-"+tab+"-"+i).removeClassName("unselected");
					$("tab-"+tab+"-"+i).addClassName("active");
					$("tab-content-"+tab+"-"+i+"-div").show();
				}
			} else {
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("active");
					// $("tab-"+tab+"-"+i).addClassName("unselected");
					$("tab-content-"+tab+"-"+i+"-div").hide();
				}
			}
		}
	}

	// Set default analytics if not stated
	if (tab == "analytics") {
		if (viz == "") {
			viz = "overview";
		}
		for (i in DATAANALYTICS){
			if(viz == i){
				if ($("tab-"+tab+"-"+i)) {
					// $("tab-"+tab+"-"+i).removeClassName("unselected");
					$("tab-"+tab+"-"+i).addClassName("active");
					$("tab-content-"+tab+"-"+i+"-div").show();
				}
			} else {
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("active");
					// $("tab-"+tab+"-"+i).addClassName("unselected");
					$("tab-content-"+tab+"-"+i+"-div").hide();
				}
			}
		}
	}

	CURRENT_TAB = tab;
	CURRENT_VIZ = viz;

	//LOAD DATA IF REQUIRED
	if (tab == "map") {
		if(!DATA_LOADED.map){
			loadMapTab();
			DATA_LOADED.map = true;
		}
	}
	if (tab == "vis") {
		switch(viz){
			case 'network':
				$('tab-vis').setAttribute("href",'#vis-network');
				Event.stopObserving('tab-vis','click');
				Event.observe('tab-vis','click', stpNetwork);
				if(!DATA_LOADED.network){
					iframeLoadingMessage('tab-content-vis-network', 'vis');
					loadNetworkVis();
					DATA_LOADED.network = true;
				}
				break;
			case 'circles':
				$('tab-vis').setAttribute("href",'#vis-circles');
				Event.stopObserving('tab-vis','click');
				Event.observe('tab-vis','click', stpCircles);
				if(!DATA_LOADED.circles){
					iframeLoadingMessage('tab-content-vis-circles', 'vis');
					loadCirclesVis();
					DATA_LOADED.circles = true;
				}
				break;
			case 'sunburst':
				$('tab-vis').setAttribute("href",'#vis-sunburst');
				Event.stopObserving('tab-vis','click');
				Event.observe('tab-vis','click', stpSunburst);
				if(!DATA_LOADED.sunburst){
					iframeLoadingMessage('tab-content-vis-sunburst', 'vis');
					loadSunburstVis();
					DATA_LOADED.sunburst = true;
				}
				break;
			case 'treemap':
				$('tab-vis').setAttribute("href",'#vis-treemap');
				Event.stopObserving('tab-vis','click');
				Event.observe('tab-vis','click', stpTreemap);
				if(!DATA_LOADED.treemap){
					iframeLoadingMessage('tab-content-vis-treemap', 'vis');
					loadTreemapVis();
					DATA_LOADED.treemap = true;
				}
				break;
			case 'treemaptd':
				$('tab-vis').setAttribute("href",'#vis-treemaptd');
				Event.stopObserving('tab-vis','click');
				Event.observe('tab-vis','click', stpTreemapTD);
				if(!DATA_LOADED.treemaptd){
					iframeLoadingMessage('tab-content-vis-treemaptd', 'vis');
					loadTreemapTDVis();
					DATA_LOADED.treemaptd = true;
				}
				break;
		}
	} else if (tab == "analytics") {
		switch(viz){
			case 'overview':
				$('tab-analytics').setAttribute("href",'#analytics-overview');
				Event.stopObserving('tab-analytics','click');
				Event.observe('tab-analytics','click', stpOverview);
				if(!DATA_LOADED.overview){
					iframeLoadingMessage('tab-content-analytics-overview', 'analytics');
					loadOverviewAnalytics();
					DATA_LOADED.overview = true;
				}
				break;
			case 'social':
				$('tab-analytics').setAttribute("href",'#analytics-social');
				Event.stopObserving('tab-analytics','click');
				Event.observe('tab-analytics','click', stpSocial);
				if(!DATA_LOADED.social){
					iframeLoadingMessage('tab-content-analytics-social', 'analytics');
					loadSocialAnalytics();
					DATA_LOADED.social = true;
				}
				break;
			case 'ring':
				$('tab-analytics').setAttribute("href",'#analytics-ring');
				Event.stopObserving('tab-analytics','click');
				Event.observe('tab-analytics','click', stpRing);
				if(!DATA_LOADED.ring){
					iframeLoadingMessage('tab-content-analytics-ring', 'analytics');
					loadRingAnalytics();
					DATA_LOADED.ring = true;
				}
				break;
			case 'activity':
				$('tab-analytics').setAttribute("href",'#analytics-activity');
				Event.stopObserving('tab-analytics','click');
				Event.observe('tab-analytics','click', stpActivity);
				if(!DATA_LOADED.activity){
					iframeLoadingMessage('tab-content-analytics-activity', 'analytics');
					loadActivityAnalytics();
					DATA_LOADED.activity = true;
				}
				break;
			case 'useractivity':
				$('tab-analytics').setAttribute("href",'#analytics-useractivity');
				Event.stopObserving('tab-analytics','click');
				Event.observe('tab-analytics','click', stpUserActivity);
				if(!DATA_LOADED.useractivity){
					iframeLoadingMessage('tab-content-analytics-useractivity', 'analytics');
					loadUserActivityAnalytics();
					DATA_LOADED.useractivity = true;
				}
				break;
			case 'stream':
				$('tab-analytics').setAttribute("href",'#analytics-stream');
				Event.stopObserving('tab-analytics','click');
				Event.observe('tab-analytics','click', stpStream);
				if(!DATA_LOADED.stream){
					iframeLoadingMessage('tab-content-analytics-stream', 'analytics');
					loadStreamAnalytics();
					DATA_LOADED.stream = true;
				}
				break;
		}
	}
}

/**
 * This resets all the loaded parameters to false after a change in the map,
 * so the views and analytics are reloaded next time the user clicks the tabs.
 */
function setMapTabDataReload() {
	DATA_LOADED.network = false;
	DATA_LOADED.cicrles = false;
	DATA_LOADED.sunburst = false;
	DATA_LOADED.treemap = false;
	DATA_LOADED.treemaptd = false;
	DATA_LOADED.overview = false;
	DATA_LOADED.social = false;
	DATA_LOADED.ring = false;
	DATA_LOADED.activity = false;
	DATA_LOADED.useractivity = false;
	DATA_LOADED.stream = false;
}

/**
 * This resets the loaded parameter to false for vote depended views after a vote change in the map,
 * so the appropriate views and analytics are reloaded next time the user clicks the tabs.
 */
function setMapTabVoteDataReload() {
	DATA_LOADED.overview = false;
	DATA_LOADED.activity = false;
}

function iframeLoadingMessage(iframename, type) {
	if(type == 'vis') {
		$("tab-content-"+type+"-message").update(getLoadingLine('<?php echo $LNG->LOADING_CIDASHBOARD_VISUALISATION; ?>'));
	} else {
		$("tab-content-"+type+"-message").update(getLoadingLine('<?php echo $LNG-> LOADING_CIDASHBOARD_ANALYTICS; ?>'));
	}
	if (IE) {
		$(iframename).onreadystatechange = function() {
			if( $(iframename).readyState == 'complete'){
				$("tab-content-"+type+"-message").update("");
			}
		};
	} else {
	    $(iframename).onload = function () {
			$("tab-content-"+type+"-message").update("");
	    };
	}
}

/**
 * load JS file for creating the map network
 */
function loadMapTab() {
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/create-map-net.js.php"); ?>', 'create-map-net-script');
}

/**
 * load JS file for creating the map network
 */
function loadNetworkVis(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/vis-network.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-network-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the circle packing network
 */
function loadCirclesVis(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/vis-circles.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-circles-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the sunburst packing network
 */
function loadSunburstVis(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/vis-sunburst.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-sunburst-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the treemap packing network
 */
function loadTreemapVis(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/vis-treemap.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-treemap-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the treemaptd packing network
 */
function loadTreemapTDVis(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/vis-treemaptd.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-treemaptd-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the overview analytics
 */
function loadOverviewAnalytics(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/analytics-overview.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-analytics-overview-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the social network analytics
 */
function loadSocialAnalytics(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/analytics-social.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-analytics-social-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the people and map ring analytics
 */
function loadRingAnalytics(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/analytics-ring.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-analytics-ring-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the activity analytics
 */
function loadActivityAnalytics(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/analytics-activity.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-analytics-activity-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the user user activity analytics
 */
function loadUserActivityAnalytics(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/analytics-useractivity.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-analytics-useractivity-script'+NODE_ARGS['nodeid']);
}

/**
 * load JS file for creating the user contribution stream analytics
 */
function loadStreamAnalytics(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/analytics-stream.js.php?nodeid='+NODE_ARGS['nodeid']+'"); ?>', 'vis-analytics-stream-script'+NODE_ARGS['nodeid']);
}