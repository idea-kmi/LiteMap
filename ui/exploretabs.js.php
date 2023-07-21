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

//this list the tabs/visulaizations
var VIZ = {"chat":true, "linear":true,"widget":true,"net":true};
var ORGVIZ = {"chat":true, "widget":true, "net":true};

var DEFAULT_VIZ = 'widget';
var CURRENT_VIZ = DEFAULT_VIZ;
var COOKIE_NAME = 'evidencehubviz';

var DATA_LOADED = {"chat":false, "linear":false, "widget":false, "net":false};

/**
 *	set which tab to show and load first
 */
Event.observe(window, 'load', function() {

	if ($('tab-linear')) {
		var stpLinear = setTabPushed.bindAsEventListener($('tab-explore-linear-obj'),'linear');
		Event.observe('tab-linear','click', stpLinear);
	}
	if ($('tab-widget')) {
		var stpWidget = setTabPushed.bindAsEventListener($('tab-explore-widget-obj'),'widget');
		Event.observe('tab-widget','click', stpWidget);
	}
	if ($('tab-net')) {
		var stpNet = setTabPushed.bindAsEventListener($('tab-explore-net-obj'),'net');
		Event.observe('tab-net','click', stpNet);
	}
	if ($('tab-chat')) {
		var stpChat = setTabPushed.bindAsEventListener($('tab-explore-chat-obj'),'chat');
		Event.observe('tab-chat','click', stpChat);
	}

	// add heading;
	buildNodeTitle();

	var viz = DEFAULT_VIZ; // = getExploreViz("");

	setTabPushed($('tab-explore'+getAnchorVal(DEFAULT_VIZ)),getAnchorVal(viz));
});

/**
 *	switch between tabs
 */
function setTabPushed(e) {
	var data = $A(arguments);

	var viz = "";
	if (data.length>1) {
		 viz = data[1];
	}

	//viz = getExploreViz(viz);
	if (viz == "linear") {
		scrollAddArea();
	}

	for (var i in VIZ){
		if(viz == i){
			if ($("tab-"+i)) {
				$("tab-"+i).removeClassName("unselected");
				$("tab-"+i).addClassName("current");
			}
			if ($("tab-content-explore-"+i)) {
				$("tab-content-explore-"+i).show();
			}

		} else {
			if ($("tab-"+i)) {
				$("tab-"+i).removeClassName("current");
				$("tab-"+i).addClassName("unselected");
			}
			if ($("tab-content-explore-"+i)) {
				$("tab-content-explore-"+i).hide();
			}
		}
	}

	CURRENT_VIZ = viz;

	//if viz not equal to the default then load up
	switch(viz){
		case 'chat':
			if (!DATA_LOADED.chat) {
				if (NODE_ARGS['nodetype'] == 'Challenge') {
					var bObj = new JSONscriptRequest(URL_ROOT+"ui/explore/chat/challengechatstree.js.php");
					bObj.buildScriptTag();
					bObj.addScriptTag();
					DATA_LOADED.chat = true;
				} else if (NODE_ARGS['nodetype'] == 'Issue') {
					var bObj = new JSONscriptRequest(URL_ROOT+"ui/explore/chat/issuechatstree.js.php");
					bObj.buildScriptTag();
					bObj.addScriptTag();
					DATA_LOADED.chat = true;
				} else if (NODE_ARGS['nodetype'] == 'Solution') {
					var bObj = new JSONscriptRequest(URL_ROOT+"ui/explore/chat/solutionchatstree.js.php");
					bObj.buildScriptTag();
					bObj.addScriptTag();
					DATA_LOADED.chat = true;
				} else if (EVIDENCE_TYPES_STR.indexOf(EVIDENCE_ARGS['nodetype']) != -1) {
					var bObj = new JSONscriptRequest(URL_ROOT+"ui/explore/chat/evidencechatstree.js.php");
					bObj.buildScriptTag();
					bObj.addScriptTag();
					DATA_LOADED.chat = true;
				}
			}
			break;
		case 'linear':
			if (!DATA_LOADED.linear) {
				if (NODE_ARGS['nodetype'] == 'Challenge') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/linear/challengelineartree.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Issue') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/linear/issuelineartree.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Solution') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/linear/solutionlineartree.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (EVIDENCE_TYPES_STR.indexOf(EVIDENCE_ARGS['nodetype']) != -1) {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/linear/evidencelineartree.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				}
				DATA_LOADED.linear = true;
			}
			break;
		case 'widget':
			if (!DATA_LOADED.widget) {
				if (NODE_ARGS['nodetype'] == 'Challenge') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/challengenode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Issue') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/issuenode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Solution') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/solutionnode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Argument') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/evidencenode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Pro') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/pronode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Con') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/connode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Idea') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/commentnode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'News') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/newsnode.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				}
				DATA_LOADED.widget = true;
			}
			break;
		case 'net':
			//if (!DATA_LOADED.net) {
				if (NODE_ARGS['nodetype'] == 'Challenge') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-challenge-net.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Issue') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-issue-net.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (NODE_ARGS['nodetype'] == 'Solution') {
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-solution-net.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				} else if (EVIDENCE_TYPES_STR.indexOf(EVIDENCE_ARGS['nodetype']) != -1) { //EVIDENCE
					var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-evidence-net.js.php"); ?>');
					bObj.buildScriptTag();
					bObj.addScriptTag();
				}
				//DATA_LOADED.net = true;
			//}
			break;
	}
}