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

var CURRENT_ADD_AREA = null;
var CURRENT_ADD_AREA_NODEID = null;
var CURRENT_ADD_AREA_NODE = null;
var CURRENT_ADD_AREA_HAS_UP = null

var CHAT_LOADED_ARRAY = {};
var CHAT_TIMER = null;

var DEBATE_TREE_SMALL = true;
var DEBATE_LOADED_ARRAY = {};
var DEBATE_TIMER = null;

function getExploreViz(viz) {
	if (viz == "" ||
		(viz != "linear" && viz != "widget" && viz != "net")) {

		viz = DEFAULT_VIZ;

		var allcookies = document.cookie;
		if (allcookies != null) {
			var cookiearray  = allcookies.split(';');

			for(var i=0; i<cookiearray.length; i++){
				var param = cookiearray[i].split('=');
				var name = param[0];
			    var value = param[1];
				if (name.trim() == COOKIE_NAME) {
					viz = value;
				}
			}
		}

		if (viz == "") {
			viz = DEFAULT_VIZ;
		}
	} else {
		if (viz != "net") {
			var date = new Date();
			date.setTime(date.getTime()+(365*24*60*60*1000)); // 365 days
			document.cookie = COOKIE_NAME + "=" + viz + "; expires=" + date.toGMTString();
			//document.cookie = COOKIE_NAME + "=" + viz;
		}
	}
	return viz;
}

function buildNodeTitle(from) {

	var nodeid = nodeObj.nodeid;
	var nodetype = nodeObj.role.name;
	var name = nodeObj.name;

	var title=getNodeTitleAntecedence(nodetype, true);
	var icon = nodeObj.role.image;
	var widgetHeaderLabel = $('exploreheaderlabel');
	if (widgetHeaderLabel) {
		if (icon) {
			icon = URL_ROOT+icon;
			var iconObj = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; height:24px;', 'title':title, 'alt':title+' Icon', 'border':'0','src':icon});
			iconObj.align='left';
			widgetHeaderLabel.appendChild(iconObj);
		}

		widgetHeaderLabel.insert("<span style='font-size:90%;font-style:italic'>"+title+"</span> "+name);
	}

	var nodetype = nodeObj.role.name;

	var title=getNodeTitleAntecedence(nodetype);
	var type = '';
	if (nodetype == 'Challenge') {
		type = 'challenge';
	} else if (nodetype == 'Issue') {
		type = 'issue';
	} else if (nodetype == 'Solution') {
		type = 'solution';
	} else if (EVIDENCE_TYPES_STR.indexOf(type) != -1) {
		type = 'evidence';
	} else if (nodetype == "News") {
		type = 'news';
	} else if (nodetype == "Idea") {
		type = 'idea';
	}

	if (type != 'news') {
		buildExploreToolbar($('headertoolbar'), title+name, type, nodeObj, from);
	}
}

function buildExploreToolbar(container, name, type, node, from) {
	if (typeof IS_SLIM == 'undefined') {
		var IS_SLIM = false;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var nodeid = node.nodeid;

	var print = new Element("img",
		{'src': '<?php echo $HUB_FLM->getImagePath("printer.png"); ?>',
		'alt': '<?php echo $LNG->EXPLORE_PRINT_BUTTON_ALT;?>',
		'title': '<?php echo $LNG->EXPLORE_PRINT_BUTTON_HINT;?>',
		'class': 'active',
		'style': 'float:left;padding-top:0px;padding-right:10px;margin-top:10px;'});
	container.insert(print);
	Event.observe(print,'click',function(){
		 printNodeExplore(NODE_ARGS, name, nodeid);
	});

	// Add spam icon
	/*var spaming = new Element('img', {'style':'float:left;padding-top:0px;padding-right:10px;margin-top:10px;'});
	if (node.status == <?php echo $CFG->STATUS_SPAM; ?>) {
		spaming.setAttribute('alt', '<?php echo $LNG->SPAM_REPORTED_TEXT; ?>');
		spaming.setAttribute('title', '<?php echo $LNG->SPAM_REPORTED_HINT; ?>');
		spaming.setAttribute('src', '<?php echo $HUB_FLM->getImagePath('spam-reported.png'); ?>');
	} else if (node.status == <?php echo $CFG->STATUS_ACTIVE; ?>) {
		if(USER != ""){
			spaming.setAttribute('alt', '<?php echo $LNG->SPAM_REPORT_TEXT; ?>');
			spaming.setAttribute('title', '<?php echo $LNG->SPAM_REPORT_HINT; ?>');
			spaming.setAttribute('src', '<?php echo $HUB_FLM->getImagePath('spam.png'); ?>');
			spaming.style.cursor = 'pointer';
			Event.observe(spaming,'click',function (){ reportNodeSpamAlert(this, type, node); } );
		} else {
			spaming.setAttribute('alt', '<?php echo $LNG->SPAM_LOGIN_REPORT_TEXT; ?>');
			spaming.setAttribute('title', '<?php echo $LNG->SPAM_LOGIN_REPORT_HINT; ?>');
			spaming.setAttribute('src', '<?php echo $HUB_FLM->getImagePath('spam-disabled.png'); ?>');
			spaming.style.cursor = 'pointer';
			Event.observe(spaming,'click',function (){ $('loginsubmit').click(); return true; } );
		}
	}
	container.insert(spaming);
	*/

	if (USER != "") {
		var userid = node.users[0].userid;
		if (userid == USER) {
			var otheruserconnections = node.otheruserconnections;

			if (type == 'issue') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_ISSUE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editissue',URL_ROOT+"ui/popups/issueedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} if (type == 'challenge') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_CHALLENGE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editchallenge',URL_ROOT+"ui/popups/challengeedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} else if (type == 'solution') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_SOLUTION;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editsolution',URL_ROOT+"ui/popups/solutionedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} else if (type == 'evidence') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_EVIDENCE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editevidence',URL_ROOT+"ui/popups/evidenceedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			}  else if (type == 'idea') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_COMMENT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editcomment',URL_ROOT+"ui/popups/commentedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			}

			if (type != 'challenge') {
				if (otheruserconnections == 0) {
					var del = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;padding-left:5px;','alt':'<?php echo $LNG->DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>'});
					Event.observe(del,'click',function (){
						deleteNode(node.nodeid, node.name, node.role.name, 'gotoHomeList', type);
					});
					container.appendChild(del);
				} else {
					var del = new Element('img',{'alt':'<?php echo $LNG->NO_DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->NO_DELETE_BUTTON_HINT;?>', 'style':'padding-left:5px;float:left;margin-top:10px;', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete-off.png"); ?>'});
					container.appendChild(del);
				}
			}
		}
	}

	/*if (type != "idea") {
		if (USER != "") {
			var followbutton = new Element('img', {'style':'float:left;padding-top:0px;margin-left: 10px;margin-top:10px;'});
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('alt', 'Follow');
			followbutton.setAttribute('id','follow'+nodeid);
			followbutton.nodeid = nodeid;
			followbutton.style.marginRight="3px";
			followbutton.style.cursor = 'pointer';

			container.insert(followbutton);

			if (node.userfollow && node.userfollow == "Y") {
				Event.observe(followbutton,'click',function (){ unfollowNode(node, this, "refreshWidgetFollowers()") } );
				followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				followbutton.setAttribute('title', '<?php echo $LNG->NODE_UNFOLLOW_ITEM_HINT; ?>');
			} else {
				Event.observe(followbutton,'click',function (){ followNode(node, this, "refreshWidgetFollowers()") } );
				followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				followbutton.setAttribute('title', '<?php echo $LNG->NODE_FOLLOW_ITEM_HINT; ?>');
			}
		} else {
			container.insert("<img style='float:left;padding-top:0px;margin-top:10px;cursor:pointer' onclick='$(\"loginsubmit\").click(); return true;' title='<?php echo $LNG->WIDGET_FOLLOW_SIGNIN_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("followgrey.png"); ?>' border='0' />");
		}
	}*/

	if (from != 'explore') {
		var explore = new Element('a',{'style':'float:left;margin-left:20px;margin-right:5px;margin-bottom:5px;'});
		explore.href="<?php echo $CFG->homeAddress; ?>explore.php?id="+nodeid;
		if (IS_SLIM) {
			explore.target="_blank";
		}

		var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("explore.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
		explore.insert(image);
		explore.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT;?>';
		container.appendChild(explore);
		//if (from == 'explore') {
		//	image.style.border = "1px dashed blue";
		//}
	}

	var chat = new Element('a',{'style':'float:left;margin-right:5px;margin-bottom:5px;'});
	if (from == 'explore') {
		chat.style.marginLeft ='20px';
	}
	chat.href="<?php echo $CFG->homeAddress; ?>chats.php?id="+nodeid;
	if (IS_SLIM) {
		chat.target="_blank";
	}
	var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("chat.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
	chat.insert(image);
	chat.title = '<?php echo $LNG->VIEWS_CHAT_HINT;?>';
	container.appendChild(chat);
	if (from == 'chat') {
		image.style.border = "1px dashed blue";
	}

	var tree = new Element('a',{'style':'float:left;margin-right:5px;margin-bottom:5px;'});
	tree.href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+nodeid;
	if (IS_SLIM) {
		tree.target="_blank";
	}
	var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("knowledge-tree.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
	tree.insert(image);
	tree.title = '<?php echo $LNG->VIEWS_LINEAR_HINT;?>';
	container.appendChild(tree);
	if (from == 'trees') {
		image.style.border = "1px dashed blue";
	}

	var net = new Element('a',{'style':'float:left;margin-right:0px;margin-bottom:5px;'});
	net.href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id="+nodeid;
	if (IS_SLIM) {
		net.target="_blank";
	}
	var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("network-graph.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
	net.insert(image);
	net.title = '<?php echo $LNG->VIEWS_EVIDENCE_MAP_HINT;?>';
	container.appendChild(net);
	if (from == 'network') {
		image.style.border = "1px dashed blue";
	}
}

function buildChatHeader() {

	var keyDiv = new Element("div", {'style':'float:left;margin-left:40px;padding:2px;'});
	keyDiv.className = 'plainborder';
	keyDiv.style.borderWidth = "1px";
	keyDiv.style.borderStyle = "dotted";
	keyDiv.insert('<?php echo $LNG->CHAT_HIGHLIGHT_NEWEST_TEXT; ?>');

	if (USER != "") {
		var toolbar = new Element("div", {'id':'commenttoolbar', 'class':'widgetheaderinner ', 'style':'padding-top:10px;padding-left:10px;'});
		var link = new Element("a", {'title':'<?php echo $LNG->CHAT_ADD_BUTTON_HINT; ?>', 'style':'float:left;cursor:pointer'});
		link.insert('<span id="linkbutton"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="20" height="20" style="margin:0px;padding:0px" /> <?php echo $LNG->CHAT_ADD_BUTTON_TEXT; ?></span>');
		Event.observe(link,"click", function(){
			$('commenthidden').style.display = 'block';
			$('commenthidden').style.height = "95px";
			$('comment').style.height = "60px";
			$('commenttoolbar').style.display = 'none';
			$('comment').focus();
		});
		toolbar.insert(link);

		toolbar.insert(keyDiv);

		$('chattoolbar').update(toolbar);

		var hidden = new Element("div", {'class':'widgetheaderinner', 'id':'commenthidden','class':'commentdiv', 'style':'background:#E8E8E8 ;display:none;width:100%'});
		$('chattoolbar').insert(hidden);

		var box = new Element("textarea", {'value':'', 'id':'comment', 'rows':'1'});
		box.style.width = "98%";
		hidden.insert(box);

		var button = new Element("input", {'value':'<?php echo $LNG->WIDGET_ADD_BUTTON; ?>', 'type':'button', 'style':'vertical-align: bottom'});
		Event.observe(button,"click", function(){
			var comment = $('comment').value;
			$('comment').value = "";
			$("chatarea").style.display = 'block';
			$('commenthidden').style.display = 'none';
			$('commenttoolbar').style.display = 'block';
			if (comment != "") {
				var type = "Comment";
				var reqUrl = SERVICE_ROOT + "&method=connectnodetocomment&nodetypename="+type+"&nodeid="+chatnodeid+"&comment="+encodeURIComponent(comment);
				new Ajax.Request(reqUrl, { method:'get',
						onSuccess: function(transport){
							var json = transport.responseText.evalJSON();
							if(json.error){
								alert(json.error[0].message);
							} else {
								refreshExploreChats();
							}
						}
				});
			}
		});

		hidden.insert(button);

		var button = new Element("input", {'value':'<?php echo $LNG->FORM_BUTTON_CLOSE; ?>', 'type':'button', 'style':'vertical-align: bottom'});
		Event.observe(button,"click", function(){
			$('comment').value = "";
			$('chatarea').style.display = 'block';
			$('commenthidden').style.display = 'none';
			$('commenttoolbar').style.display = 'block';
		});

		hidden.insert(button);
	} else {
		var toolbar = new Element("div", {'id':'commenttoolbar', 'class':'widgetheaderinner ', 'style':'float:left;padding-top:10px;padding-left:10px;'});
		toolbar.insert('<span style="float:left;cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->CHAT_ADD_BUTTON_TEXT; ?></span>');
		toolbar.insert(keyDiv);
		$('chattoolbar').insert(toolbar);
	}
}

function checkChatStillLoading(nodetofocusid) {
	var stillLoading = false;
	for(var ind in CHAT_LOADED_ARRAY){
		var next = CHAT_LOADED_ARRAY[ind];
		if (next == false) {
			stillLoading = true;
			break;
		}
	}
	if (!stillLoading) {
		clearTimeout(CHAT_TIMER);
		$('chatloading').update("");
		checkChatHasNode();
	} else {
		CHAT_TIMER = setTimeout("checkChatStillLoading('"+nodetofocusid+"')", 350);
	}
}


function loadKnowledgeTree(focalnodeid,nodetofocusid) {
	if (DEBATE_TREE_SMALL) {
		$('content-list').update(getLoading("<?php echo $LNG->DEBATE_LOADING; ?>"));
	}

	var reqUrl = SERVICE_ROOT + "&method=getviewsbynode&nodeid="+focalnodeid;
	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
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
			$('content-list').update("");

			var views = json.viewset[0].views;
			//alert(views.length);
			if (views.length > 0) {
				for (var i=0; i<views.length; i++) {
					var view = views[i].view;
					var conns = view.connections;
					if (conns.length > 0) {
						var allConnections = new Array();
						for(var j=0; j< conns.length; j++){
							var viewconnection = conns[j].viewconnection;
							var c = viewconnection.connection[0].connection;
							allConnections.push(c);
						}
						//alert(allConnections.length);
						if (allConnections.length > 0) {
							drawKnowledgeTree(allConnections, focalnodeid);
						}
					}
				}

				// Count the number of debates and display
				var debateCount = parseInt($('debatecount').innerHTML);
				if (views && views.length > 0) {
					debateCount += views.length;
				}
				$('debatecount').update(debateCount);
				if (debateCount == 1) {
					$('maps-name').update('<?php echo $LNG->MAP_NAME; ?>');
				} else {
					$('maps-name').update('<?php echo $LNG->MAPS_NAME; ?>');
				}

			} else {
				$('content-list').update("");
				CURRENT_ADD_AREA_NODEID = ISSUE_ARGS['nodeid'];
				CURRENT_ADD_AREA_NODE = nodeObj;
			}
		}
	});
}

function drawKnowledgeTree(allConnections, focalnodeid) {
	var treeTopNodes = new Array();

	var fromNodeCheck = new Array();
	var toNodeCheck = new Array();
	var toNodeConnections = {};

	for(var i=0; i< allConnections.length; i++) {
		var c = allConnections[i];
		if (c) {
			var fN = c.from[0].cnode;
			var tN = c.to[0].cnode;
			var fnRole = c.fromrole[0].role;
			var tnRole = c.to[0].cnode.role[0].role;

			//reverse direction to nest map under from node in linear view
			if (tnRole.name == "Map") {
				var hold = tN;
				c.to[0].cnode = fN;
				c.from[0].cnode = hold;
				var holdrole = tnRole;
				c.fromrole[0].role = holdrole;
				c.torole[0].role = fnRole;

				fN = c.from[0].cnode;
				tN = c.to[0].cnode;
			}

			if (fromNodeCheck.indexOf(fN.nodeid) == -1) {
				fromNodeCheck.push(fN.nodeid);
			}
			if (toNodeCheck.indexOf(tN.nodeid) == -1) {
				toNodeCheck.push(tN.nodeid);
			}

			if (toNodeConnections[tN.nodeid]) {
				toNodeConnections[tN.nodeid].push(c);
			} else {
				toNodeConnections[tN.nodeid] = new Array();
				toNodeConnections[tN.nodeid].push(c);
			}
		}
	}

	var treetops = [];

	toNodeCheck.forEach(function(key) {
		if (-1 === fromNodeCheck.indexOf(key)) {
			treetops.push(key);
		}
	}, this);

	var checkNodes = new Array();

	for(var i=0; i< treetops.length; i++) {
		var tonodeid = treetops[i];

		var myToConnections = toNodeConnections[tonodeid];

		var toNode = "";

		for(var j=0; j<myToConnections.length; j++) {
			var c = myToConnections[j];

			// node to main array once.
			if (j == 0) {
				toNode = c.to[0];
				toNode.cnode['connection'] = c;
				toNode.cnode['handler'] = "";
				toNode.cnode['focalnodeid'] = focalnodeid;
				toNode.cnode.children = new Array();
				checkNodes[toNode.cnode.nodeid] = toNode.cnode.nodeid;
			}

			var fromNode = c.from[0];
			if (fromNode.cnode.name != "") {
				if (checkNodes.indexOf(fromNode.cnode.nodeid) == -1) {
					fromNode.cnode['connection'] = c;
					fromNode.cnode['handler'] = "";
					fromNode.cnode['focalnodeid'] = focalnodeid;

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextKnowledgeTreeDepth(fromNode, checkNodes, toNodeConnections, focalnodeid)
				}
			}
		}

		toNode.cnode.children.sort(alphanodesort);
		treeTopNodes.push(toNode);
	}

	treeTopNodes.sort(alphanodesort);

	if (treeTopNodes.length > 0){
		displayConnectionNodes($('content-list'), treeTopNodes, parseInt(0), true, "mapnarrow");
	}

	return;
}

function recurseNextKnowledgeTreeDepth(toNode, checkNodes, toNodeConnections, focalnodeid) {

	if (toNodeConnections[toNode.cnode.nodeid]) {
		var myToConnections = toNodeConnections[toNode.cnode.nodeid];
		toNode.cnode.children = new Array();

		for(var i=0; i<myToConnections.length; i++) {
			var c = myToConnections[i];
			var fromNode = c.from[0];

			if (fromNode.cnode.nodeid == toNode.cnode.nodeid) {
				continue;
			}

			if (checkNodes.indexOf(fromNode.cnode.nodeid) == -1) {
				if (fromNode.cnode.name != "") {
					fromNode.cnode['connection'] = c;
					fromNode.cnode['handler'] = "";
					fromNode.cnode['focalnodeid'] = focalnodeid;

					toNode.cnode.children.push(fromNode);
					checkNodes[fromNode.cnode.nodeid] = fromNode.cnode.nodeid;

					recurseNextKnowledgeTreeDepth(fromNode, checkNodes, toNodeConnections, focalnodeid)
				}
			}
		}
	}
}
