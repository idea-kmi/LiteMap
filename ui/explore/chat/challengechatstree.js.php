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

var chatnodeid = CHALLENGE_ARGS['nodeid'];
var chatnodekey = 'challengeissue';

function loadChallengeChatPage() {

	buildChatHeader();
	getAllChatConnections("");
};

function getAllChatConnections() {

 	$('chatloading').update(getLoading("<?php echo $LNG->CHAT_LOADING; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypath&style=short";
	reqUrl += "&depth=7";
	reqUrl += "&labelmatch=false";
	reqUrl += "&nodeid="+chatnodeid;
	reqUrl += "&direction=incoming";
	reqUrl += "&nodetypes="+encodeURIComponent("Comment,Challenge");
	reqUrl += "&linklabels="+encodeURIComponent('<?php echo $CFG->LINK_COMMENT_NODE; ?>');

	new Ajax.Request(reqUrl, { method:'post',
  			onSuccess: function(transport){

  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

     			$('chatarea').update("");

				var conns = json.connectionset[0].connections;
				if (conns.length == 0) {
					$('chatloading').update("");
					$('chatarea').update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> Chats <?php echo $LNG->WIDGET_NONE_FOUND_PART2b; ?>");
				} else {
					var topnodes = new Array();
					var nodes = new Array();
					var topcheck = new Array();
					var check = new Array();

					// get the top level nodes
					for(var i=0; i< conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if (fnRole.name == 'Comment' && tN.nodeid == chatnodeid) {
							if (fN.name != "") {
								if (!topcheck[fN.nodeid]) {
									var next = c.from[0];
									next.cnode['connection'] = c;
									next.cnode['handler'] = 'refreshExploreChats';
									next.cnode['istop'] = true;
									next.cnode['chattopic'] = c;
									next.cnode['children'] = new Array();
									topnodes.push(next);
									topcheck[fN.nodeid] = next;
								}
							}
						} else if (fnRole.name == 'Comment' && tN.nodeid != chatnodeid) {
							if (fN.name != "") {
								if (!check[fN.nodeid]) {
									var next = c.from[0];
									next.cnode['connection'] = c;
									next.cnode['handler'] = 'refreshExploreChats';
									next.cnode['children'] = new Array();
									nodes.push(next);
									check[fN.nodeid] = next;
								}
							}
						}
					}

					// process again and add children to parents;
					for (var j=0; j < nodes.length; j++) {
						var nextnode = nodes[j];
						var c = nextnode.cnode['connection'];
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;
						var parent = null;
						if (topcheck[tN.nodeid]) {
							var innerparent = topcheck[tN.nodeid];
							var ind = topnodes.indexOf(innerparent);
							if (ind > -1) {
								parent = topnodes[ind];
							}
						} else if (check[tN.nodeid]) {
							var innerparent = check[tN.nodeid];
							var ind = nodes.indexOf(innerparent);
							if (ind > -1) {
								parent = nodes[ind];
							}
						}
						if (parent != null) {
							parent.cnode['children'].push(nextnode);
						}
					}

					topnodes.sort(modedatenodesortdesc);

					if (topnodes.length > 0){
						displayChatNodes($('chatarea'),topnodes,parseInt(0), true, chatnodekey);

						$('chatloading').update("");
						checkChatHasNode();

						//$(key+"headerlabel").update(title+"<span style='margin-left:5px'>("+topnodes.length+")</span>");
					} else {
						$('chatloading').update("");
						$('chatarea').update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> Chats <?php echo $LNG->WIDGET_NONE_FOUND_PART2b; ?>");
					}
				}
			}
	});
}

function getChatConnections(nodetofocusid) {

	$('chatloading').update(getLoading("<?php echo $LNG->CHAT_LOADING; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=moddate&sort=DESC&filterlist=<?php echo $CFG->LINK_COMMENT_NODE; ?>&filternodetypes=Comment&scope=all&start=0&max=-1&nodeid="+chatnodeid;

	new Ajax.Request(reqUrl, { method:'post',
  			onSuccess: function(transport){

  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

     			$('chatarea').update("");

				var conns = json.connectionset[0].connections;
				if (conns.length == 0) {
					$('chatloading').update("");
					$('chatarea').update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> Chats <?php echo $LNG->WIDGET_NONE_FOUND_PART2b; ?>");
				} else {
					var nodes = new Array();
					var check = new Array();

					for(var i=0; i< conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if (fnRole.name == 'Comment') {
							if (fN.name != "") {
								if (!check[fN.nodeid]) {
									var next = c.from[0];
									next.cnode['connection'] = c;
									next.cnode['handler'] = 'refreshExploreChats';
									next.cnode['istop'] = true;
									next.cnode['chattopic'] = c;
									nodes.push(next);
									check[fN.nodeid] = fN.nodeid;
								}
							}
						} else if (tnRole.name == 'Comment') {
							if (tN.name != "") {
								if (!check[tN.nodeid]) {
									var next = c.to[0];
									next.cnode['connection'] = c;
									next.cnode['handler'] = 'refreshExploreChats';
									next.cnode['istop'] = true;
									next.cnode['chattopic'] = c;
									nodes.push(next);
									check[tN.nodeid] = tN.nodeid;
								}
							}
						}
					}

					if (nodes.length > 0){
					  	CHAT_TIMER = setTimeout("checkChatStillLoading('"+nodetofocusid+"')", 350);
						displayChatNodes($('chatarea'),nodes,parseInt(0), true, chatnodekey);
						//$(key+"headerlabel").update(title+"<span style='margin-left:5px'>("+nodes.length+")</span>");
					} else {
						$('chatloading').update("");
						$('chatarea').update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> Chats <?php echo $LNG->WIDGET_NONE_FOUND_PART2b; ?>");
					}
				}
			}
	});
}

loadChallengeChatPage();
