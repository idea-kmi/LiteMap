displayConnectionNodes<?php
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
 /** Author: Michelle Bachler, KMi,The Open University **/

header('Content-Type: text/javascript;');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
?>

/**
 * Javascript functions for nodes
 */

/**
 * Render a list of Map nodes
 * @param width the width of each node box
 * @param height the height of each node box
 * @param node the nodes the array of node objects to render
 * @param uniqueid is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node. Defaults to the node role.
 * @param includeUser whether to include the user image and link. Defaults to true.
 * @param isActive defaults to 'active', but can be 'inactive' so toolbar buttons not included.
 * @param includeconnectedness should the connectedness count be included - defaults to false.
 * @param includevoting should the voting buttons be included - defaults to true.
 */
function displayMapNodes(width, height, objDiv,nodes,start,includeUser,uniqueid, isActive, includeconnectedness, includevoting, cropdesc){
	if (includeUser == undefined) {
		includeUser = true;
	}
	if (uniqueid == undefined) {
		uniqueid = 'idea-list';
	}
	if (isActive == undefined) {
		isActive = 'active';
	}
	if (includeconnectedness === undefined) {
		includeconnectedness = false;
	}
	if (includevoting === undefined) {
		includevoting = true;
	}

	var lOL = new Element("div", {'start':start, 'class':'idea-list-ol', 'style':'clear:both;float:left;width:100%;margin:0px;padding:0px;'});
	for(var i=0; i< nodes.length; i++){
		if(nodes[i].cnode){
			var blobDiv = new Element("div", {'style':'float:left;margin:10px;'});
			var blobNode = renderMapNode(width, height, nodes[i].cnode, uniqueid+i+start,nodes[i].cnode.role[0].role,includeUser,isActive, includeconnectedness, includevoting, cropdesc, false, false);
			blobDiv.insert(blobNode);
			lOL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of nodes in the user home data area
 */
function displayUsersNodes(objDiv,nodes,start,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'widget-list';
	}
	var lOL = new Element("ul", {'style':'float:left;clear:both;'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'style':'clear:both;float:left;padding:0px;margin:0px;vertical-align:center;border:1px solid transparent'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'style':'float:left;clear:both;padding:0px;margin:0px;'});
			var blobNode = renderListNode(nodes[i].cnode, uniqueid+i+start, nodes[i].cnode.role[0].role, false);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}


/**
 * Render a list of nodes in the user home data area
 */
function displayUsersChatNodes(objDiv,nodes,start,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'widget-list';
	}
	var lOL = new Element("ul", {'style':'float:left;clear:both;'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'style':'clear:both;float:left;padding:0px;margin:0px;vertical-align:center;border:1px solid transparent'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'style':'float:left;clear:both;padding:0px;margin:0px;'});
			var blobNode = renderUsersChatListNode(nodes[i].cnode, uniqueid+i+start, nodes[i].cnode.role[0].role, false);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of nodes
 */
function displaySearchNodes(objDiv,nodes,start,includeUser,uniqueid){

	if (uniqueid == undefined) {
		uniqueid = 'search-list';
	}

	var lOL = new Element("ul", {'start':start,  'style':'list-style-type: none;padding:0px'});
	for(var i=0; i< nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'style':'clear:both;float:left;padding:0px;margin:0px;'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list', 'style':'clear:both;float:left;margin-bottom:10px;width:100%;'});
			var blobNode = renderListNode(nodes[i].cnode, uniqueid+i+start,nodes[i].cnode.role[0].role, includeUser);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of nodes
 */
function displayWidgetNodes(objDiv,nodes,start,includeUser,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'widget-list';
	}
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol', 'style':'margin: 0px; padding: 0px;'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list', 'style':'clear:both;float:left;margin:0px;padding:0px;margin-bottom:5px;width:100%'});
			var blobNode = renderWidgetListNode(nodes[i].cnode, uniqueid+i+start, nodes[i].cnode.role[0].role,includeUser);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of nodes in the Chat tree
 */
function displayChatNodes(objDiv,nodes,start,includeUser,uniqueid, childCountSpan){
	if (uniqueid == undefined) {
		uniqueid = 'widget-list';
	}
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol', 'style':'margin: 0px; padding: 0px;'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'margin: 0px; padding: 0px;'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list', 'style':'clear:both;float:left;margin: 0px; padding: 0px;'});
			var blobNode = renderChatNode(nodes[i].cnode, uniqueid+i+start, nodes[i].cnode.role[0].role,includeUser,'active', childCountSpan);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of connection nodes
 */
function displayConnectionNodes(objDiv, nodes,start,includeUser,uniqueid, childCountSpan, parentrefreshhandler){
	if (uniqueid == undefined) {
		uniqueid = 'idea-list';
	}

	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol', 'style':'float:left;margin-top:0px;padding-top: 0px;padding-bottom:0px;'});
	for(var i=0; i< nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'margin: 0px; padding: 0px;'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list', 'style':'clear:both;float:left;margin: 0px; padding: 0px;'});
			var blobNode = renderConnectionNode(nodes[i].cnode, uniqueid,nodes[i].cnode.role[0].role,includeUser, childCountSpan, parentrefreshhandler);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}

	objDiv.insert(lOL);
}

/**
 * Render a list of nodes
 */
function displayReportNodes(objDiv,nodes,start){

	objDiv.insert('<div style="clear:both; margin: 0px; padding: 0px;"></div>');

	for(var i=0; i< nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("span", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'padding-bottom: 5px;'});
			objDiv.insert(iUL);
			var blobDiv = new Element("div", {'style':'margin: 2px; width: 650px'});
			var blobNode = renderReportNode(nodes[i].cnode,'idea-list'+i+start, nodes[i].cnode.role[0].role);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
}

/**
 * Render the given node.
 * Used for Activities, Multi connection Viewer, Stats pages etc. where the node is drawn as a Cohere style box.
 *
 * @param node the node object to render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includemenu whether to include the drop-down menu
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderNodeFromLocalJSon(node, uniQ, role, includemenu, type) {

	if (type === undefined) {
		type = "active";
	}
	if (includemenu === undefined) {
		includemenu = true;
	}
	if(role === undefined){
		role = node.role[0];
	}
	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	// used mostly for getting data from Audit history. So nodes repeated a lot.
	// creation date will be the same, but modification date will be different for each duplicated node in the Audit
	uniQ = node.modificationdate+node.nodeid + uniQ;

	var iDiv = new Element("div", {'class':'idea-container'});
	var ihDiv = new Element("div", {'class':'idea-header'});
	var itDiv = new Element("div", {'class':'idea-title'});

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";
	if (type == "connselect") {
		nodeTable.style.cursor = 'pointer';
		Event.observe(nodeTable,'click',function (){
			loadConnectionNode(node, role);
		});
	}

	var row = nodeTable.insertRow(-1);
	var leftCell = row.insertCell(-1);
	leftCell.vAlign="top";
	leftCell.align="left";
	var rightCell = row.insertCell(-1);
	rightCell.vAlign="top";
	rightCell.align="right";

	//get url for any saved image.

	//add left side with icon image and node text.
	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i< node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'target': '_blank' });
 		var nodeicon = new Element('img',{'alt':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'style':'padding-right:5px;','align':'left', 'border':'0','src': URL_ROOT + node.imagethumbnail});
 		iconlink.insert(nodeicon);
 		itDiv.insert(iconlink);
 		itDiv.insert(alttext+": ");
	} else if (role.image != null && role.image != "") {
 		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'padding-right:5px;','align':'left', 'border':'0','src': URL_ROOT + role.image});
		itDiv.insert(nodeicon);
	} else {
 		itDiv.insert(alttext+": ");
	}

	itDiv.insert("<span>"+node.name+"</span>");

	leftCell.insert(itDiv);

	// Add right side with user image and date below
	var iuDiv = new Element("div", {'class':'idea-user'});

	var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-right:5px;','align':'right', 'border':'0','src': user.thumb});

	if (type == "active") {
		var imagelink = new Element('a', {
			'target':'_blank',
			'href':URL_ROOT+"user.php?userid="+user.userid,
			'title':user.name});
		if (breakout != "") {
			imagelink.target = "_blank";
		}
		imagelink.insert(userimageThumb);
		iuDiv.update(imagelink);
	} else {
		iuDiv.insert(userimageThumb)
	}

	var modDate = new Date(node.creationdate*1000);
	if (modDate) {
		var fomatedDate = modDate.format(DATE_FORMAT);
		iuDiv.insert("<div style='clear: both;'>"+fomatedDate+"</span>");
	}

	rightCell.insert(iuDiv);
	ihDiv.insert(nodeTable);

	if (role.name != 'Comment') {
		var iwDiv = new Element("div", {'class':'idea-wrapper'});
		var imDiv = new Element("div", {'class':'idea-main'});
		var idDiv = new Element("div", {'class':'idea-detail'});
		var headerDiv = new Element("div", {'class':'idea-menus', 'style':'width: 100%'});
		idDiv.insert(headerDiv);

		if (type == 'active') {
			var exploreButton = new Element("a", {'title':'<?php echo $LNG->NODE_EXPLORE_BUTTON_HINT; ?>'} );
			exploreButton.insert("<?php echo $LNG->NODE_EXPLORE_BUTTON_TEXT;?>");
			exploreButton.href= URL_ROOT+"explore.php?id="+node.nodeid;
			exploreButton.target = 'coheremain';

			headerDiv.insert(exploreButton);
		}

		imDiv.insert(idDiv);
		iwDiv.insert(imDiv);
		iwDiv.insert('<div style="clear:both;"></div>');
	}

	iDiv.insert(ihDiv);
	iDiv.insert('<div style="clear:both;"></div>');
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node for drawing on the item Picker list.
 * @param node the node object to render
 * @param role the role object for this node
 * @param includemenu whether to include the drop-down menu (and bookmark and spam buttons)
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderPickerNode(node, role,includeUser){
	if(role === undefined){
		role = node.role[0].role;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title'});

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";

	var row = nodeTable.insertRow(-1);
	var leftCell = row.insertCell(-1);
	leftCell.vAlign="top";
	leftCell.align="left";

	var rightCell = row.insertCell(-1);
	rightCell.vAlign="top";
	rightCell.align="right";

	var textspan = new Element('span');
	itDiv.insert(textspan);

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'padding-right:5px;','align':'left','border':'0','src': URL_ROOT + role.image});
		textspan.insert(nodeicon);
	} else {
		textspan.insert(alttext+": ");
	}

	if (!node.inmap) {
		textspan.insert("<span class='itemtext' style='float:left;line-height:1.8em' title='<?php echo $LNG->MAP_EDITOR_DND_HINT; ?>'>"+node.name+"</span>");
		itDiv.style.cursor = 'pointer';
		Event.observe(itDiv,'click',function (){
			loadSelecteditem(node);
		});
	} else {
		textspan.insert("<span style='#C0C0C0;font-style:italic;float:left;line-height:1.8em' title='<?php echo $LNG->MAP_EDITOR_IN_MAP_HINT; ?>'>"+node.name+"</span>");
	}

	if (node.private == "Y") {
		var padlockicon = new Element("img", {'style':'float:left;width:18px; height:18px;padding-top:1px;padding-left:5px;'});
		padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
		itDiv.insert(padlockicon);
	}

	leftCell.insert(itDiv);

	// add url if a resource node
	if (node.urls && node.urls.length > 0) {
		var hasClips = false;
		var iUL = new Element("ul", {});
		for (var i=0 ; i< node.urls.length; i++){
			if (node.urls[i].url.clip && node.urls[i].url.clip != "") {
				var link = new Element("a", {'href':node.urls[i].url.url, 'target':'_blank','class':'wordwrap','style':'clear:both;float:left;'});
				link.insert(node.urls[i].url.url);
				iUL.insert(link);
				hasClips = true;
			}
		}

		leftCell.insert(iUL);
	}

	if (includeUser) {
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:right;'});
		var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-right:5px;','align':'right', 'border':'0','src': user.thumb});
		iuDiv.insert(userimageThumb)
		rightCell.insert(iuDiv);
	}

	ihDiv.insert(nodeTable);

	iDiv.insert(ihDiv);
	iDiv.insert('<div style="clear:both;"></div>');

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	iwDiv.insert('<div style="clear:both;"></div>');
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node for drawing on the map item Picker list.
 * @param node the node object to render
 * @param role the role object for this node
 * @param includeUser whether to include the user image
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderMapPickerNode(node, role,includeUser){

	if(role === undefined){
		role = node.role[0].role;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;width:100%'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title', 'name':'dndnodeitemdiv'+node.nodeid});

	var nodeTable = new Element('table',{'style':'width:100%;'} );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";

	var row = nodeTable.insertRow(-1);

	var iconCell = row.insertCell(-1);
	iconCell.vAlign="top";
	iconCell.align="left";
	iconCell.width="10%";

	var leftCell = row.insertCell(-1);
	leftCell.vAlign="top";
	leftCell.align="left";
	leftCell.width="80%";

	var rightCell = row.insertCell(-1);
	rightCell.vAlign="top";
	rightCell.align="right";
	rightCell.width="10%";

	var textspan = new Element('span');
	itDiv.insert(textspan);

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'padding-right:5px;padding-top:4px;width:20px;height:20px;','align':'left','border':'0','src': URL_ROOT + role.image});
		iconCell.insert(nodeicon);
	} else {
		iconCell.insert(alttext+": ");
	}

	if (!node.inmap) {
		textspan.insert("<span name='dndnodeitem"+node.nodeid+"' class='itemtext' style='float:left;' title='<?php echo $LNG->MAP_EDITOR_DND_HINT; ?>'>"+node.name+"</span>");
		itDiv.style.cursor = 'pointer';
	} else {
		textspan.insert("<span name='dndnodeitem"+node.nodeid+"' style='color:#C0C0C0;font-style:italic;float:left;' title='<?php echo $LNG->MAP_EDITOR_IN_MAP_HINT; ?>'>"+node.name+"</span>");
	}

	if (node.private == "Y") {
		var padlockicon = new Element("img", {'style':'float:left;width:18px; height:18px;padding-top:1px;padding-left:5px;'});
		padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
		itDiv.insert(padlockicon);
	}

	if (!node.inmap) {
		itDiv.setAttribute('draggable', 'true');
		itDiv.setAttribute('style', '-webkit-user-drag:element'); // For Safari
		Event.observe(itDiv,"dragstart", function(e){
			e.dataTransfer.effectAllowed = "copy";
			e.dataTransfer.setData('text', node.nodeid);
		});
	}

	leftCell.insert(itDiv);

	// add url if a resource node
	if (node.urls && node.urls.length > 0) {
		var hasClips = false;
		var iUL = new Element("ul", {'style':'margin:0px;padding:0px;'});
		for (var i=0 ; i< node.urls.length; i++){
			if (node.urls[i].url.clip && node.urls[i].url.clip != "") {
				var link = new Element("a", {'href':node.urls[i].url.url, 'target':'_blank','class':'wordwrap', 'style':'margin-left:10px;clear:both;float:left;'});
				link.insert(node.urls[i].url.url);
				iUL.insert(link);
				hasClips = true;
			}
		}

		leftCell.insert(iUL);
	}

	if (includeUser) {
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:right;'});
		var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-right:5px;','align':'right', 'border':'0','src': user.thumb});
		iuDiv.insert(userimageThumb)
		rightCell.insert(iuDiv);
	}

	ihDiv.insert(nodeTable);

	iDiv.insert(ihDiv);
	iDiv.insert('<div style="clear:both;"></div>');

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	iwDiv.insert('<div style="clear:both;"></div>');
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given map node.
 * @param width the width of the node box (e.g. 200px or 20%)
 * @param height the height of the node box (e.g. 200px or 20%)
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node. Defaults to the node role.
 * @param includeUser whether to include the user image and link. Defaults to true.
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable.
 * 			or a specialized type for some of the popups
 * @param includeconnectedness should the connectedness count be included - defaults to false.
 * @param includevoting should the voting buttons be included - defaults to true.
 * @param cropdesc whether to crop the description text.
 * @param mainheading whether or not the title is a main heading instead of a link.
 * @param includestats whether or not to include the stats list below this Debate.
 */
function renderMapNode(width, height, node, uniQ, role, includeUser, type, includeconnectedness, includevoting, cropdesc, mainheading, includestats){

	if (mainheading) {
		return renderMapNodeHeading(width, height, node, uniQ, role, includeUser, type, includeconnectedness, includevoting, cropdesc, includestats);
	}

	if(role === undefined){
		role = node.role[0].role;
	}
	if(includeUser === undefined){
		includeUser = true;
	}
	if (type === undefined) {
		type = "active";
	}
	if (includeconnectedness === undefined) {
		includeconnectedness = false;
	}
	if (includevoting === undefined) {
		includevoting = true;
	}
	if (mainheading === undefined) {
		mainheading = false;
	}
	if (includestats === undefined){
		includestats = true;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	uniQ = node.nodeid + uniQ;

	var groupid = "";
	if (node.groupid) {
		groupid = node.groupid;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var iDiv = new Element("div", {'style':'float:left;width:100%;'});
	if (width == "100%") {
		iDiv.style.width = width;
	} else {
		iDiv.style.width = width+"px";
		iDiv.style.maxWidth = width+"px";
	}
	iDiv.style.height = height+"px";
	iDiv.style.minHeight = height+"px";
	iDiv.style.maxHeight = height+"px";

	var nodetableDiv = new Element("div", {'style':'float:left;width:100%;'});
	var nodeTable = new Element( 'div', {'class':'nodetable boxborder boxbackground', 'style':'float:left;padding:0px;margin:0px;'} );

	//if (includestats) {
	//	nodetableDiv.style.height = (height-30)+"px";
	//	nodetableDiv.style.maxHeight = (height-30)+"px";
	//	nodetableDiv.style.minHeight = (height-30)+"px";
	//} else {
		nodetableDiv.style.height = height+"px";
		nodetableDiv.style.maxHeight = height+"px";
		nodetableDiv.style.minHeight = height+"px";
	//}

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'nodetablecelltop'} );
	imageCell.style.width="20%";
	row.insert(imageCell);

	var imageObj = new Element('img',{'alt':node.name, 'title': node.name, 'style':'padding:5px;padding-bottom:10px;', 'border':'0','src': node.image});
	var imagelink = new Element('a', {
		'href':URL_ROOT+"explore.php?id="+node.nodeid,
	});

	imagelink.insert(imageObj);
	imageCell.insert(imagelink);
	imageCell.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>';

	var textCell = new Element( 'div', {'class':'nodetablecelltop'} );
	textCell.style.width="80%";
	row.insert(textCell);

	var textDiv = new Element('div', {'style':'margin-left:10px;margin-right:10px;'});
	textCell.insert(textDiv);

	var title = node.name;
	var description = node.description;

	if (mainheading) {
		var exploreButton = new Element('h1');
		textDiv.insert(exploreButton);
		exploreButton.insert(title);
	} else {
		var exploreButton = new Element('a', {'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>', 'style':'font-weight:bold;font-size:12pt;float:left;margin-top:5px;'});
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else if (node.groupid && node.groupid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?groupid="+node.groupid+"&id="+node.nodeid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}

		var croppedtitle = title;
		if (cropdesc && title.length > 100) {
			croppedtitle = title.substr(0,100)+"...";
		}

		exploreButton.insert(croppedtitle);
		textDiv.insert(exploreButton);
		textDiv.insert("<br>");
	}
	if (node.description != "" && title.length <=80) {
		var hint = removeHTMLTags(description);
		var cutoff = 180;
		if (width < 400) {
			cutoff = 100;
		}
		var croplength = cutoff-title.length;
		if (cropdesc && description.length > croplength) {
			var description = removeHTMLTags(description);
			var final = description.substr(0,croplength)+"...";
			textDiv.insert('<p class="wordwrap" title="'+hint+'">'+final+'</p>');
		} else {
			textDiv.insert('<p class="wordwrap">'+description+'</p>');
		}
	}


	var rowToolbar = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(rowToolbar);

	var toolbarCell = new Element( 'div', {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarCell);

	var userDiv = new Element("div", {'class':'nodetablecellbottom'} );
	toolbarCell.insert(userDiv);

	if (includeUser) {
		var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'float:left;padding-left:5px;padding-right:5px;margin-bottom:5px;', 'border':'0','src': user.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+user.userid,
				'title':user.name});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			userDiv.insert(imagelink);
		} else {
			userDiv.insert(userimageThumb)
		}

		var userDateDiv = new Element("div", {'class':'nodetablecellbottom', 'style':'font-size:9pt;'} );
		toolbarCell.insert(userDateDiv);

		//var dateLabelDiv = new Element('div',{'style':'float:left;padding-left:5px;vertical-align:bottom;'});
		//dateLabelDiv.insert('Question by');

		//var nameLabelDiv = new Element('div',{'style':'clear:both;float:left;font-weight:bold;padding-left:5px;vertical-align:bottom;'});
		//nameLabelDiv.insert(user.name);

		var cDate = new Date(node.creationdate*1000);
		var dateDiv = new Element('div',{'title':'<?php echo $LNG->NODE_ADDED_ON; ?>','style':'float:left;clear:both;padding-left:5px;margin-bottom:5px;vertical-align:bottom;'});
		dateDiv.insert(cDate.format(DATE_FORMAT));


		//userDateDiv.insert(dateLabelDiv);
		//userDateDiv.insert(nameLabelDiv);
		userDateDiv.insert(dateDiv);
	}

	var toolbarDivOuter = new Element("div", {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarDivOuter);

	var toolbarDiv = new Element("div", {'style':'float:right;margin-bottom:5px;'} );
	toolbarDivOuter.insert(toolbarDiv);

	if (mainheading) { // means it is on the explore page not the home page or group page.
		var dashboardLink = new Element("a", {'style':'float:left;padding-right:20px;', 'title':'<?php echo $LNG->BLOCK_STATS_LINK_HINT; ?>'} );
		dashboardLink.href = "<?php echo $CFG->homeAddress; ?>ui/stats/debates/index.php?nodeid="+node.nodeid;

		var dashboardimg = new Element("img", {'border':'0', 'src':'<?php echo $HUB_FLM->getImagePath("charts.png"); ?>', 'style':'vertical-align:bottom;padding-right:3px;'} );
		dashboardLink.insert(dashboardimg);
		dashboardLink.insert('<?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?>');

		toolbarDiv.insert(dashboardLink);
	}

	if (node.private == "Y") {
		var padlockicon = new Element("img", {'style':'float:left;width:18px; height:18px;padding-left:5px;margin-right: 10px;'});
		padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
		toolbarDiv.insert(padlockicon);
	}

	// IF OWNER ADD EDIT / DEL ACTIONS
	if (type == "active") {
		if (USER == user.userid) {

			var edit = new Element('img',{'style':'float:left;cursor: pointer;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_ISSUE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
			Event.observe(edit,'click',function (){loadDialog('editmap',URL_ROOT+"ui/popups/mapedit.php?nodeid="+node.nodeid+"&groupid="+NODE_ARGS['groupid'], 770,550)});
			toolbarDiv.insert(edit);

			if (node.otheruserconnections == 0) {
				var deletename = node.name;
				var del = new Element('img',{'id':'deletebutton'+uniQ,'style':'float:left;cursor: pointer;padding-left:5px;margin-right: 10px','alt':'<?php echo $LNG->DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>'});
				Event.observe(del,'click',function (){
					deleteNode(node.nodeid, deletename, role.name);
				});
				toolbarDiv.insert(del);
			} else {
				var del = new Element('img',{'id':'deletebutton'+uniQ,'style':'float:left;padding-left:5px;margin-right: 10px', 'alt':'<?php echo $LNG->NO_DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->NO_DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete-off.png"); ?>'});
				toolbarDiv.insert(del);
			}
		}
	}

	/*if (type == "active") {
		if (USER != "") { // IF LOGGED IN
			// Add spam icon
			var spaming = new Element('img', {'style':'float:left;padding-top:0px;padding-right:10px;'});
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
			toolbarDiv.insert(spaming);
		} else {

		}
	}*/

	if (type == "active") {
		if (USER != "") {
			var followbutton = new Element('img', {'style':'float:left;padding-top:0px;margin-right:10px;'});
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('alt', 'Follow');
			followbutton.setAttribute('id','follow'+node.nodeid);
			followbutton.nodeid = node.nodeid;
			followbutton.style.marginRight="3px";
			followbutton.style.cursor = 'pointer';

			toolbarDiv.insert(followbutton);

			if (node.userfollow && node.userfollow == "Y") {
				Event.observe(followbutton,'click',function (){ unfollowNode(node, this, "") } );
				followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
				followbutton.setAttribute('title', '<?php echo $LNG->NODE_UNFOLLOW_ITEM_HINT; ?>');
			} else {
				Event.observe(followbutton,'click',function (){ followNode(node, this, "") } );
				followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				followbutton.setAttribute('title', '<?php echo $LNG->NODE_FOLLOW_ITEM_HINT; ?>');
			}
		} else {
			toolbarDiv.insert("<img style='float:left;margin-right:10px;padding-top:0px;cursor:pointer' onclick='$(\"loginsubmit\").click(); return true;' title='<?php echo $LNG->WIDGET_FOLLOW_SIGNIN_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("followgrey.png"); ?>' border='0' />");
		}
	}

	if (includevoting == true) {
		if (role.name == 'Issue'
			|| role.name == 'Solution'
			|| role.name == 'Pro'
			|| role.name == 'Con') {

			// vote for
			var voteforimg = new Element('img');
			voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-grey3.png"); ?>');
			voteforimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_FOR_ICON_ALT; ?>');
			voteforimg.setAttribute('id','nodefor'+node.nodeid);
			voteforimg.nodeid = node.nodeid;
			voteforimg.vote='Y';
			//voteforimg.style.verticalAlign="bottom";
			voteforimg.style.marginRight="2px";
			//voteforimg.style.marginTop="15px";
			voteforimg.style.cssFloat="left";
			toolbarDiv.insert(voteforimg);
			if (!node.positivevotes) {
				node.positivevotes = 0;
			}

			if(USER != ""){
				voteforimg.style.cursor = 'pointer';
				if (node.uservote && node.uservote == 'Y') {
					Event.observe(voteforimg,'click',function (){ deleteNodeVote(this) } );
					voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled3.png"); ?>');
					voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
				} else if (!node.uservote || node.uservote != 'Y') {
					Event.observe(voteforimg,'click',function (){ nodeVote(this) } );
					voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
					voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
				}
				toolbarDiv.insert('<b><span style="float:left;font-size: 10pt;margin-right: 5px;" id="nodevotefor'+node.nodeid+'">'+node.positivevotes+'</span></b>');
			} else {
				voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_LOGIN_HINT; ?>');
				toolbarDiv.insert('<b><span style="float:left;font-size: 10pt;margin-right: 5px;" id="nodevotefor'+node.nodeid+'">'+node.positivevotes+'</span></b>');
			}

			// vote against
			var voteagainstimg = new Element('img');
			voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-grey3.png"); ?>');
			voteagainstimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_AGAINST_ICON_ALT; ?>');
			voteagainstimg.setAttribute('id', 'nodeagainst'+node.nodeid);
			voteagainstimg.nodeid = node.nodeid;
			voteagainstimg.vote='N';
			voteagainstimg.style.cssFloat="left";
			//voteagainstimg.style.verticalAlign="bottom";
			voteagainstimg.style.marginRight="2px";
			//voteagainstimg.style.marginTop="15px";
			toolbarDiv.insert(voteagainstimg);
			if (!node.negativevotes) {
				node.negativevotes = 0;
			}
			if(USER != ""){
				voteagainstimg.style.cursor = 'pointer';
				if (node.uservote && node.uservote == 'N') {
					Event.observe(voteagainstimg,'click',function (){ deleteNodeVote(this) } );
					voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled3.png"); ?>');
					voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
				} else if (!node.uservote || node.uservote != 'N') {
					Event.observe(voteagainstimg,'click',function (){ nodeVote(this) } );
					voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
					voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
				}
				toolbarDiv.insert('<b><span style="float:left;font-size: 10pt;margin-right: 10px;" id="nodevoteagainst'+node.nodeid+'">'+node.negativevotes+'</span></b>');
			} else {
				voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_LOGIN_HINT; ?>');
				toolbarDiv.insert('<b><span style="float:left;font-size: 10pt;margin-right: 10px;" id="nodevoteagainst'+node.nodeid+'">'+node.negativevotes+'</span></b>');
			}
		}
	}

	/*if (includeconnectedness && node.connectedness) {
		var countCell = row.insertCell(-1);
		countCell.vAlign="middle";
		countCell.align="left";
		countCell.insert("("+node.connectedness+")");
	}*/

	/*
	if (includestats) {
		var statstableDiv = new Element("div", {'style':'clear:both;float:left;width:100%'});
		var statsTable = new Element( 'div', {'class':'nodetable', 'style':'float:left;clear:both;height:30px;'} );
		statstableDiv.insert(statsTable);

		var innerRowStats = new Element( 'div', {'class':'nodetablerow'} );
		statsTable.insert(innerRowStats);

		var innerStatsCellPeople = new Element( 'div', {'class':'nodetablecellmid'} );
		innerRowStats.insert(innerStatsCellPeople);

		var peoplelabelspan = new Element("span", {'style':'font-size:10pt;font-weight:bold'});
		peoplelabelspan.insert('<?php echo $LNG->BLOCK_STATS_PEOPLE; ?>');
		innerStatsCellPeople.insert(peoplelabelspan);

		var peoplenumspan = new Element("span", {'id':'debatestatspeople'+node.nodeid, 'style':'padding-left:5px;'});
		peoplenumspan.insert('0');
		innerStatsCellPeople.insert(peoplenumspan);

		var innerStatsCellDebates = new Element( 'div', {'class':'nodetablecellmid'} );
		innerRowStats.insert(innerStatsCellDebates);

		var idealabelspan = new Element("span", {'style':'font-size:10pt;font-weight:bold'});
		idealabelspan.insert('<?php echo $LNG->BLOCK_STATS_ISSUES; ?>');
		innerStatsCellDebates.insert(idealabelspan);

		var ideanumspan = new Element("span", {'id':'debatestatsdebates'+node.nodeid, 'style':'padding-left:5px;'});
		ideanumspan.insert('0');
		innerStatsCellDebates.insert(ideanumspan);

		var innerStatsCellVotes = new Element( 'div', {'class':'nodetablecellmid'} );
		innerRowStats.insert(innerStatsCellVotes);

		var votelabelspan = new Element("span", {'style':'font-size:10pt;font-weight:bold'});
		votelabelspan.insert('<?php echo $LNG->BLOCK_STATS_VOTES; ?>');
		innerStatsCellVotes.insert(votelabelspan);

		var votenumspan = new Element("span", {'id':'votestatsdebates'+node.nodeid, 'style':'padding-left:5px;'});
		votenumspan.insert('0');
		innerStatsCellVotes.insert(votenumspan);

		var voteposimg = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath("thumb-up-filled3.png"); ?>', 'style':'padding-left:10px;'});
		innerStatsCellVotes.insert(voteposimg);
		var voteposspan = new Element("span", {'id':'statsvotespos'+node.nodeid, 'style':'padding-left:5px;'});
		voteposspan.insert('0');
		innerStatsCellVotes.insert(voteposspan);

		var votenegimg = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath("thumb-down-filled3.png"); ?>', 'style':'padding-left:5px;'});
		innerStatsCellVotes.insert(votenegimg);
		var votenegspan = new Element("span", {'id':'statsvotesneg'+node.nodeid, 'style':'padding-left:5px;'});
		votenegspan.insert('0');
		innerStatsCellVotes.insert(votenegspan);

		var innerStatsCellTopics = new Element( 'div', {'class':'nodetablecellmid'} );
		innerRowStats.insert(innerStatsCellTopics);

		// used to calulate
		loadStats(node, user, role, uniQ, peoplenumspan, ideanumspan, votenumspan, voteposspan, votenegspan);
		iDiv.insert(statstableDiv);
	} else {
		//loadMembers(node, user, role, uniQ);
	}*/

	iDiv.insert(nodetableDiv);

	return iDiv;
}

/**
 * Render the given map node.
 * @param width the width of the node box (e.g. 200px or 20%)
 * @param height the height of the node box (e.g. 200px or 20%)
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node. Defaults to the node role.
 * @param includeUser whether to include the user image and link. Defaults to true.
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable.
 * 			or a specialized type for some of the popups
 * @param includeconnectedness should the connectedness count be included - defaults to false.
 * @param includevoting should the voting buttons be included - defaults to true.
 * @param cropdesc whether to crop the description text.
 * @param includestats whether or not to include the stats list below this Debate.
 */
function renderMapNodeHeading(width, height, node, uniQ, role, includeUser, type, includeconnectedness, includevoting, cropdesc, includestats){

	if(role === undefined){
		role = node.role[0].role;
	}
	if(includeUser === undefined){
		includeUser = true;
	}
	if (type === undefined) {
		type = "active";
	}
	if (includeconnectedness === undefined) {
		includeconnectedness = false;
	}
	if (includevoting === undefined) {
		includevoting = true;
	}
	if (includestats === undefined){
		includestats = true;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	uniQ = node.nodeid + uniQ;

	var groupid = "";
	if (node.groupid) {
		groupid = node.groupid;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var iDiv = new Element("div", {'style':'float:left;width:100%;'});
	iDiv.style.width = width+"px";
	iDiv.style.height = height+"px";
	iDiv.style.minHeight = height+"px";

	var nodetableDiv = new Element("div", {'style':'float:left;width:100%;'});
	var nodeTable = new Element( 'div', {'class':'nodetable boxborder boxbackground', 'style':'float:left;padding:0px;margin:0px;'} );
	nodetableDiv.style.height = (height-30)+"px";
	nodetableDiv.style.maxHeight = (height-30)+"px";
	nodetableDiv.style.minHeight = (height-30)+"px";
	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'nodetablecelltop'} );
	imageCell.style.width="150px";
	row.insert(imageCell);

	var imageObj = new Element('img',{'alt':node.name, 'title': node.name, 'style':'padding:5px;padding-bottom:10px;', 'border':'0','src': node.image});
	var imagelink = new Element('a', {
		'href':URL_ROOT+"explore.php?id="+node.nodeid,
	});

	imagelink.insert(imageObj);
	imageCell.insert(imagelink);
	imageCell.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>';

	var textCell = new Element( 'div', {'class':'nodetablecelltop'} );
	row.insert(textCell);

	var textDiv = new Element('div', {'style':'margin-left:10px;margin-right:10px;'});
	textCell.insert(textDiv);

	var title = node.name;
	var description = node.description;

	var exploreButton = new Element('h1');
	textDiv.insert(exploreButton);
	exploreButton.insert('<span style="float:left;">'+title+'</span>');

	if (node.private == "Y") {
		var padlockicon = new Element("img", {'style':'float:left;text-align: middle;width:24px; height:24px;padding-left:10px;'});
		padlockicon.align='left';
		padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
		exploreButton.insert(padlockicon);
	}

	if (node.description != "" && title.length <=80) {
		var hint = description;
		var croplength = 80-title.length;
		if (cropdesc && description.length > croplength) {
			hint = description;
			description = description.substr(0,croplength)+"...";
			textDiv.insert('<p style="clear:both;float:left;" title="'+hint+'">'+description+'</p>');
		} else {
			textDiv.insert('<p style="clear:both;float:left;">'+description+'</p>');
		}
	}

	var sideCell = new Element( 'div', {'class':'nodetablecellbottom'} );
	sideCell.style.width="120px";
	row.insert(sideCell);

	var nodeTableInner = new Element( 'div', {'class':'nodetable', 'style':'float:left;padding:0px;margin:0px;width:100%;'} );
	sideCell.insert(nodeTableInner);

	var rowUser = new Element( 'div', {'class':'nodetablerow'} );
	rowUser.style.width="100%";
	nodeTableInner.insert(rowUser);

	var userDiv = new Element("div", {'style':'max-width:40px;padding-top:5px;padding-left:0px;'} );
	rowUser.insert(userDiv);

	if (includeUser) {
		var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'float:left;padding-right:5px;margin-bottom:5px;', 'border':'0','src': user.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+user.userid,
				'title':user.name});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			userDiv.insert(imagelink);
		} else {
			userDiv.insert(userimageThumb)
		}

		var userDateDiv = new Element("div", {'style':'float:left;font-size:9pt;'} );
		rowUser.insert(userDateDiv);

		var cDate = new Date(node.creationdate*1000);
		var dateDiv = new Element('div',{'title':'<?php echo $LNG->NODE_ADDED_ON; ?>','style':'float:left;clear:both;padding-left:5px;'});
		dateDiv.insert(cDate.format(DATE_FORMAT));
		userDateDiv.insert(dateDiv);
	}


	var nextRow = new Element( 'div', {'class':'nodetablerow'} );
	nextRow.style.width="100%";
	nodeTableInner.insert(nextRow);
	var nextCell = new Element("div", {'class':'nodetablecelltop'} );
	nextRow.insert(nextCell);

	var dashboardLink = new Element("a", {'style':'clear:both;float:left;width:100%;', 'title':'<?php echo $LNG->MAP_BLOCK_STATS_LINK_HINT; ?>'} );
	dashboardLink.href = "<?php echo $CFG->homeAddress; ?>ui/stats/maps/index.php?nodeid="+node.nodeid;

	var dashboardimg = new Element("img", {'style':'margin-right:5px;vertical-align:bottom','border':'0', 'src':'<?php echo $HUB_FLM->getImagePath("charts.png"); ?>'} );
	dashboardLink.insert(dashboardimg);
	dashboardLink.insert('<?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?>');

	nextCell.insert(dashboardLink);

	if (type == "active") {
		var nextRow = new Element( 'div', {'class':'nodetablerow'} );
		nextRow.style.width="100%";
		nodeTableInner.insert(nextRow);
		var nextCell = new Element("div", {'class':'nodetablecelltop', 'style':'padding-top:5px;padding-bottom:5px;'} );
		nextRow.insert(nextCell);

		// IF OWNER ADD EDIT / DEL ACTIONS
		if (USER == user.userid) {

			var edit = new Element('img',{'style':'float:left;cursor: pointer;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_ISSUE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
			Event.observe(edit,'click',function (){loadDialog('editmap',URL_ROOT+"ui/popups/mapedit.php?nodeid="+node.nodeid+"&groupid="+NODE_ARGS['groupid'], 770,550)});
			nextCell.insert(edit);

			if (node.otheruserconnections == 0) {
				var deletename = node.name;
				var del = new Element('img',{'id':'deletebutton'+uniQ,'style':'float:left;cursor: pointer;padding-left:5px;margin-right: 10px','alt':'<?php echo $LNG->DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>'});
				Event.observe(del,'click',function (){
					deleteNode(node.nodeid, deletename, role.name);
				});
				nextCell.insert(del);
			} else {
				var del = new Element('img',{'id':'deletebutton'+uniQ,'style':'float:left;padding-left:5px;margin-right: 10px', 'alt':'<?php echo $LNG->NO_DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->NO_DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete-off.png"); ?>'});
				nextCell.insert(del);
			}
		}

		/*
		if (USER != "") { // IF LOGGED IN
			// Add spam icon
			var spaming = new Element('img', {'style':'float:left;padding-top:0px;padding-right:10px;'});
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
			toolbarDiv.insert(spaming);
		}
		*/

		if (USER != "") {
			var followbutton = new Element('img', {'style':'float:left;'});
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('alt', 'Follow');
			followbutton.setAttribute('id','follow'+node.nodeid);
			followbutton.nodeid = node.nodeid;
			followbutton.style.marginRight="3px";
			followbutton.style.cursor = 'pointer';

			nextCell.insert(followbutton);

			if (node.userfollow && node.userfollow == "Y") {
				Event.observe(followbutton,'click',function (){ unfollowNode(node, this, "") } );
				followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				followbutton.setAttribute('title', '<?php echo $LNG->NODE_UNFOLLOW_ITEM_HINT; ?>');
			} else {
				Event.observe(followbutton,'click',function (){ followNode(node, this, "") } );
				followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				followbutton.setAttribute('title', '<?php echo $LNG->NODE_FOLLOW_ITEM_HINT; ?>');
			}
		} else {
			nextCell.insert("<img style='float:left;padding-top:0px;cursor:pointer' onclick='$(\"loginsubmit\").click(); return true;' title='<?php echo $LNG->WIDGET_FOLLOW_SIGNIN_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("followgrey.png"); ?>' border='0' />");
		}
	}

	iDiv.insert(nodetableDiv);

	return iDiv;
}

/**
 * Render the given map node whne in the header of an embeded map.
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node. Defaults to the node role.
 * @param includeUser whether to include the user image and link. Defaults to true.
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable.
 * 			or a specialized type for some of the popups
 * @param includeconnectedness should the connectedness count be included - defaults to false.
 * @param includevoting should the voting buttons be included - defaults to true.
 * @param cropdesc whether to crop the description text.
 * @param mainheading whether or not the title is a main heading instead of a link.
 * @param includestats whether or not to include the stats list below this Debate.
 */
function renderEmbedMapNode(node, uniQ, role, includeUser, type, includeconnectedness, includevoting, cropdesc, mainheading, includestats){

	if(role === undefined){
		role = node.role[0].role;
	}
	if(includeUser === undefined){
		includeUser = true;
	}
	if (type === undefined) {
		type = "active";
	}
	if (includeconnectedness === undefined) {
		includeconnectedness = false;
	}
	if (includevoting === undefined) {
		includevoting = true;
	}
	if (mainheading === undefined) {
		mainheading = false;
	}
	if (includestats === undefined){
		includestats = true;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	uniQ = node.nodeid + uniQ;

	var groupid = "";
	if (node.groupid) {
		groupid = node.groupid;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var iDiv = new Element("div", {'style':'float:left;width:100%;'});
	var textDiv = new Element('div', {'style':'margin-left:10px;margin-right:10px;'});
	iDiv.insert(textDiv);

	var title = node.name;
	var description = node.description;

	var exploreButton = new Element('h1');
	textDiv.insert(exploreButton);
	if (node.description != "" ) {
		exploreButton.title = description;
	}

	var toolbar = new Element( 'div', {'style':'clear:both;float:left;'} );
	iDiv.insert(toolbar);

	var userDiv = new Element("div", {'class':'grouptablecellstats', 'style':'padding-top:5px;padding-left:0px;width:100%'} );
	//exploreButton.insert(userDiv);

	if (includeUser) {
		var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'float:left;padding-right:5px;margin-bottom:5px;', 'border':'0','src': user.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+user.userid,
				'title':user.name});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			userDiv.insert(imagelink);
		} else {
			userDiv.insert(userimageThumb)
		}

		var userDateDiv = new Element("div", {'style':'float:left;font-size:9pt;'} );
		userDiv.insert(userDateDiv);

		//var cDate = new Date(node.creationdate*1000);
		//var dateDiv = new Element('div',{'title':'<?php echo $LNG->NODE_ADDED_ON; ?>','style':'float:left;padding-left:5px;'});
		//dateDiv.insert(cDate.format(DATE_FORMAT));
		//userDateDiv.insert(dateDiv);
	}

	exploreButton.insert(title);

	var dashboardLink = new Element("a", {'style':'float:left;margin-left:10px;', 'title':'<?php echo $LNG->MAP_BLOCK_STATS_LINK_HINT; ?>'} );
	dashboardLink.href = "<?php echo $CFG->homeAddress; ?>ui/stats/maps/index.php?nodeid="+node.nodeid;

	var dashboardimg = new Element("img", {'style':'margin-right:5px;vertical-align:bottom','border':'0', 'src':'<?php echo $HUB_FLM->getImagePath("charts.png"); ?>'} );
	dashboardLink.insert(dashboardimg);
	dashboardLink.insert('<?php echo $LNG->PAGE_BUTTON_DASHBOARD; ?>');

	return iDiv;
}

/**
 * Render the given node from an associated connection in the knowledge tree.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param childCountSpan The element into which to put the running total of children in this conneciotn tree..
 * @param parentrefreshhandler a statment to eval after actions have occurred to refresh this list.
 */
function renderConnectionNode(node, uniQ, role, includeUser, childCountSpan, parentrefreshhandler){

	if (childCountSpan === undefined) {
		childCountSpan = null;
	}

	var originaluniQ = uniQ;

	if(role === undefined){
		role = node.role[0].role;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}
	var connection = node.connection;
	var user = null;
	if (connection && connection.users) {
		user = connection.users[0].user;
	}

	//needs to check if embedded as a snippet
	var breakout = "";
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalnodeid = "";
	if (node.focalnodeid) {
		focalnodeid = node.focalnodeid;
	}
	var focalrole = "";
	var connrole = role;
	var otherend = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			connrole = connection.fromrole[0].role;
			focalrole = tN.role[0].role;
			otherend = tN;
		} else {
			connrole = connection.torole[0].role;
			focalrole = fN.role[0].role;
			otherend = fN;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title','style':'padding:0px;'});

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";
	//nodeTable.border = "1";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);

	// ADD THE ARROW IF REQUIRED
	if (node.istop) {
		var expandArrow = null;
		if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 || role.name == "Challenge"
			|| role.name == "Issue" || role.name == "Solution") {

			var arrowCell = row.insertCell(-1);
			arrowCell.vAlign="middle";
			arrowCell.align="left";

			if (DEBATE_TREE_OPEN_ARRAY["desc"+uniQ] && DEBATE_TREE_OPEN_ARRAY["desc"+uniQ] == true) {
				expandArrow = new Element('img',{'id':'explorearrow'+uniQ, 'name':'explorearrow', 'alt':'>', 'title':'<?php echo $LNG->NODE_DEBATE_TOGGLE; ?>', 'style':'float:left;visibility:visible;margin-top:3px;','align':'left','border':'0','src': '<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>'});
				expandArrow.uniqueid = uniQ;
			} else {
				expandArrow = new Element('img',{'id':'explorearrow'+uniQ, 'name':'explorearrow', 'alt':'>', 'title':'<?php echo $LNG->NODE_DEBATE_TOGGLE; ?>', 'style':'float:left;visibility:visible;margin-top:3px;','align':'left','border':'0','src': '<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>'});
				expandArrow.uniqueid = uniQ;
			}
			Event.observe(expandArrow,'click',function (){ toggleDebate("treedesc"+uniQ,uniQ);});
			arrowCell.insert(expandArrow);
		}
	} else {
		var lineCell = row.insertCell(-1);
		//lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
		lineCell.width="15px;"
		lineCell.vAlign="middle";
		var lineDiv = new Element('div',{'class':'graylinewide', 'style':'float:left;width:100%;'});
		lineCell.insert(lineDiv);
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	var textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell', 'class':'whiteborder', 'style':'float:left;padding:3px;'});
	textCellDiv.nodeid = node.nodeid;
	textCellDiv.focalnodeid = node.focalnodeid;
	textCellDiv.nodetype = role.name;
	textCellDiv.parentuniQ = originaluniQ;
	if (connection) {
		textCellDiv.connection = connection;
	}

	if (typeof CURRENT_ADD_AREA_NODEID != 'undefined' && node.nodeid == CURRENT_ADD_AREA_NODEID) {
		var bordercolor = 'plainborder';
		var backcolor = 'focusedback';
		var nodetype = role.name;
		if (nodetype == 'Challenge') {
			bordercolor = 'challengeborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'challengeback';
			}
		} else if (nodetype == 'Issue') {
			bordercolor = 'issueborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'issueback';
			}
		} else if (nodetype == 'Idea') {
			bordercolor = 'ideaborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'ideaback';
			}
		} else if (nodetype == 'Solution') {
			bordercolor = 'solutionborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'solutionback';
			}
		} else if (nodetype == 'Pro') {
			bordercolor = 'proborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'proback';
			}
		} else if (nodetype == 'Con') {
			bordercolor = 'conborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'conback';
			}
		} else if (nodetype == 'Argument') {
			bordercolor = 'evidenceborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'evidenceback';
			}
		} else if (nodetype == 'Map') {
			bordercolor = 'plainborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'plainback';
			}
		}

		//if (node.nodeid == node.focalnodeid) {
		//	bordercolor = 'selectedborder';
		//}

		textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell', 'class':backcolor+' '+bordercolor, 'style':'float:left;padding:3px'});
		textCellDiv.nodeid = node.nodeid;
		textCellDiv.nodetype = role.name;
		textCellDiv.focalnodeid = node.focalnodeid;
		textCellDiv.parentuniQ = originaluniQ;
		if (connection) {
			textCellDiv.connection = connection;
		}
	} else if (node.nodeid == node.focalnodeid) {
		var bordercolor = 'plainborder';
		var backcolor = 'whiteback';
		var nodetype = role.name;
		if (nodetype == 'Challenge') {
			bordercolor = 'challengeborder';
			backcolor = 'challengeback';
		} else if (nodetype == 'Issue') {
			bordercolor = 'issueborder';
			backcolor = 'issueback';
		} else if (nodetype == 'Idea') {
			bordercolor = 'ideaborder';
			backcolor = 'ideaback';
		} else if (nodetype == 'Solution') {
			bordercolor = 'solutionborder';
			backcolor = 'solutionback';
		} else if (nodetype == 'Pro') {
			bordercolor = 'proborder';
			backcolor = 'proback';
		} else if (nodetype == 'Con') {
			bordercolor = 'conborder';
			backcolor = 'conback';
		} else if (nodetype == 'Argument') {
			bordercolor = 'evidenceborder';
			backcolor = 'evidenceback';
		} else if (nodetype == 'Map') {
			bordercolor = 'plainborder';
			backcolor = 'plainback';
		}

		textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell','class':bordercolor+' '+backcolor, 'style':'float:left;padding:3px;'});
		textCellDiv.nodeid = node.nodeid;
		textCellDiv.nodetype = role.name;
		textCellDiv.focalnodeid = node.focalnodeid;
		textCellDiv.parentuniQ = originaluniQ;
		if (connection) {
			textCellDiv.connection = connection;
		}
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";
	toolbarCell.width="80";

	textCell.insert(textCellDiv);

	var dStr = "";
	if (user != null) {
		var cDate = new Date(connection.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_TOGGLE_HINT;?>'
	}

	// ADD THE NODE ICON
	var nodeArea = new Element("a", {'class':'itemtext', 'name':'nodeArea', 'style':'float:left;padding-top:2px;','title':dStr} );
	nodeArea.nodeid = node.nodeid;
	if (typeof node.focalnodeid != 'undefined') {
		nodeArea.focalnodeid = node.focalnodeid;
	}

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i< node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'target': '_blank' });
		var nodeicon = new Element('img',{'alt':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'style':'width:20px;height:20px;padding-right:5px;','align':'left', 'border':'0','src': URL_ROOT + node.imagethumbnail});
		iconlink.insert(nodeicon);
		nodeArea.insert(iconlink);
		nodeArea.insert(alttext+": ");
	} else if (node.image != null && node.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'height:24px;padding-right:5px;','align':'left','border':'0','src': node.image});
		nodeArea.insert(nodeicon);
	} else if (connrole.image != null && connrole.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'height:24px;padding-right:5px;','align':'left','border':'0','src': URL_ROOT + connrole.image});
		nodeArea.insert(nodeicon);
	} else {
		nodeArea.insert(alttext+": ");
	}

	// ADD THE NODE LABEL
	textCellDiv.insert(nodeArea);
	if (role.name != 'Comment') {
		if (typeof CURRENT_ADD_AREA_NODEID != 'undefined' && node.nodeid == CURRENT_ADD_AREA_NODEID) {
			if (node.nodeid == node.focalnodeid) {
				nodeArea.className = "itemtextwhite";
			} else {
				nodeArea.className = "itemtext selectedlabel";
			}
		} else {
			if (node.nodeid == node.focalnodeid) {
				nodeArea.className = "itemtextwhite";
			} else {
				nodeArea.className = "itemtext unselectedlabel";
			}
		}

		var nodeextra = getNodeTitleAntecedence(role.name, true);
		nodeArea.insert("<span style='font-style:italic'>"+nodeextra+"</span>"+node.name);

		nodeArea.href= "#";
		Event.observe(nodeArea,'click',function (){
			ideatoggle3("desc"+uniQ, uniQ, node.nodeid,"desc",role.name);
		});
	}
	if (node.istop) {
		var expandArrow = null;
		if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 || role.name == "Challenge"
			|| role.name == "Issue" || role.name == "Solution" || role.name == "Idea"
			|| role.name == "Pro"  || role.name == "Con" || role.name == "Argument") {

			var childCount = new Element('div',{'style':'float:left; margin-left:5px;margin-right:5px;margin-top:2px;', 'title':'<?php echo $LNG->NODE_DEBATE_TREE_COUNT_HINT; ?>'});
			childCount.insert("(");
			childCountSpan = new Element('span',{'name':'toptreecount'});
			childCountSpan.id = 'toptreecount'+uniQ;
			childCountSpan.insert(1);
			childCountSpan.uniqueid = uniQ;
			childCount.insert(childCountSpan);
			childCount.insert(")");
			toolbarCell.insert(childCount);
		}
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'treedesc'+uniQ,'class':'ideadata', 'style':'padding:0px;margin-left:0px;color:Gray;'} );
	if (node.istop) {
		if (DEBATE_TREE_OPEN_ARRAY["treedesc"+uniQ] && DEBATE_TREE_OPEN_ARRAY["treedesc"+uniQ] == true) {
			expandDiv.style.display = 'block';
		} else {
			expandDiv.style.display = 'none';
		}
	} else {
		expandDiv.style.display = 'block';
	}
	var hint = alttext+": "+node.name;
	hint += " <?php echo $LNG->NODE_GOTO_PARENT_HINT; ?>"

	/**
	 * This is for the rollover hint around the vertical line - background image 21px wide 1px line in middle
	 * This was the only way to get it to work in all four main browsers!!!!!
   	 **/
	var expandTable = new Element( 'table', {'style':'empty-cells:show;border-collapse:collapse;'} );
	expandTable.height="100%";
	//expandTable.border="1";
	var expandrow = expandTable.insertRow(-1);
	expandrow.style.height="100%";
	if (node.istop) {
		expandTable.style.marginLeft = "5px";
	} else {
		expandTable.style.marginLeft = "20px";
	}

	var lineCell = expandrow.insertCell(-1);
	lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
	lineCell.width="5px;";
	lineCell.style.marginLeft="3px";

	lineCell.title=hint;
	lineCell.className="grayline";
	Event.observe(lineCell,'click',function (){
		var pos = getPosition(textCellDiv);
		window.scroll(0,pos.y-3);
	});

	var childCell = expandrow.insertCell(-1);
	childCell.vAlign="top";
	childCell.align="left";
	childCell.style.padding="0px";
	childCell.style.margin="0px";

	expandDiv.insert(expandTable);

	if (node.istop) {
		expandDiv.style.marginLeft = "22px";
	} else {
		expandDiv.style.marginLeft = "4px";
	}

	/** EXPAND DIV **/
	var innerexpandDiv = new Element("div", {'id':'desc'+uniQ,'class':'ideadata', 'style':'padding-left:20px;color:Gray;display:none;'} );

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";

	innerexpandDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var nextCell = row.insertCell(-1);
	nextCell.vAlign="middle";
	nextCell.align="left";

	// USER ICON NAME AND CREATIONS DATES
	var userbar = new Element("div", {'style':'clear:both;float:left;margin-bottom:5px;'} );
	if (includeUser == true) {
		// Add right side with user image and date below
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
		var userimageThumb = new Element('img',{'alt':nodeuser.name, 'title': nodeuser.name, 'style':'padding-right:5px;', 'border':'0','src': nodeuser.thumb});
		iuDiv.insert(userimageThumb)
		userbar.insert(iuDiv);
	}

	var iuDiv = new Element("div", {'style':'float:left;'});

	var dStr = "";
	var cDate = new Date(node.creationdate*1000);
	dStr += "<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>";
	dStr += "<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>"+ nodeuser.name + "";
	iuDiv.insert(dStr);

	userbar.insert(iuDiv);

	nextCell.insert(userbar);

	// META DATA - DESCRIPTION, URLS ETC

 	// add urls
	innerexpandDiv.insert('<span style="margin-right:5px;"><b><?php echo $LNG->NODE_URL_HEADING; ?></b></span>');
	var link = new Element("a", {'href':node.name,'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
	link.insert(node.name);
	innerexpandDiv.insert(link);

	if (node.urls && node.urls.length > 0) {
		var hasClips = false;
		var iUL = new Element("ul", {});
		for (var i=0 ; i< node.urls.length; i++){
			if (node.urls[i].url && node.urls[i].url.clip && node.urls[i].url.clip != "") {
				var link = new Element("li");
				link.insert(node.urls[i].url.clip);
				iUL.insert(link);
				hasClips = true;
			}
		}

		if (hasClips) {
			innerexpandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->NODE_RESOURCE_CLIPS_HEADING; ?> </b></span><br>');
		}

		innerexpandDiv.insert(iUL);
	}

	var dStr = "";

	if(node.description || node.hasdesc){
		dStr += '<div style="margin:0px;padding:0px;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
		if (node.description && node.description != "") {
			innerexpandDiv.description = true;
			dStr += node.description;
		}
		dStr += '</div>';
		innerexpandDiv.insert(dStr);
	}

	var exploreButton = new Element("span", {'class':'active', 'style':'margin-top:5px;margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>'} );
	Event.observe(exploreButton,'click',function (e) {
		viewNodeDetailsDiv(node.nodeid, role.name, node, e, 0, 0);
	});
	//Event.observe(exploreButton,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
	exploreButton.insert("<?php echo $LNG->NODE_DETAIL_MENU_TEXT; ?>");
	//exploreButton.href= "#";
	innerexpandDiv.insert(exploreButton);

	// CHILD LISTS
	if (node.children && DEBATE_TREE_SMALL) {
		var nodes = node.children
		if (nodes.length > 0) {

			childCell.insert('<div style="clear:both;"></div>');
			var childrenDiv = new Element("div", {'id':'children'+uniQ, 'style':'clear:both;float:left;margin-left:0px;padding-left:0px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(childrenDiv);
			childCell.insert('<div style="clear:both;"></div>');
			if (expandArrow) {
				expandArrow.style.visibility = 'visible';
			}
			var parentrefreshhanlder = "";
			//"refreshchildren(\'children"+uniQ+"\', \'"+nodeid+"\', \'"+title+"\', \'"+linktype+"\', \'"+role.name+"\')";

			if (node.istop) {
				childCountSpan.update(nodes.length+1);
			} else {
				if (childCountSpan != null) {
					var countnow = parseInt(childCountSpan.innerHTML);
					var finalcount = countnow+nodes.length;
					childCountSpan.innerHTML = finalcount;
				}
			}
			displayConnectionNodes(childrenDiv, nodes, parseInt(0), true, uniQ, childCountSpan, parentrefreshhanlder);
		}
	} else if (DEBATE_TREE_SMALL == false) {
		if (role.name == 'Challenge') {
			childCell.insert('<div style="clear:both;"></div>');
			var issueDiv = new Element("div", {'id':'issue'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(issueDiv);
			childload(issueDiv, node.nodeid, "Issues", "is related to", "Issue", focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
		} else if (role.name == 'Issue') {
			childCell.insert('<div style="clear:both;"></div>');
			var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(solutionDiv);
			childload(solutionDiv ,node.nodeid,"Solutions", "addresses", "Solution", focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
		} else if (role.name == 'Solution') {
			childCell.insert('<div style="clear:both;"></div>');
			var supportDiv = new Element("div", {'id':'support'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(supportDiv);
			childload(supportDiv, node.nodeid,"Supporting Evidence", "supports", "Pro", focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
			var opposingDiv = new Element("div", {'id':'oppose'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(opposingDiv);
			childload(opposingDiv, node.nodeid, "Counter Evidence", "challenges", "Con", node.focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
		} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {
			childCell.insert('<div style="clear:both;"></div>');
			childCell.insert('<div style="clear:both;"></div>');
		}
	} else {
		lineCell.className=""; // = "1px solid white"; // hide the dot
	}

	idDiv.insert(innerexpandDiv);
	idDiv.insert(expandDiv);
	imDiv.insert(idDiv);
	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node from an associated connection in the debate tree.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 * @param childCountSpan The element into which to put the running total of children in this conneciotn tree..
 */
function renderChatNode(node, uniQ, role, includeUser, type, childCountSpan){

	if (type === undefined) {
		type = "active";
	}

	if (childCountSpan === undefined) {
		childCountSpan = null;
	}

	var originaluniQ = uniQ;

	if(role === undefined){
		role = node.role[0].role;
	}
	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}
	var connection = node.connection;
	if (connection) {
		user = connection.users[0].user;
	}
	//needs to check if embedded as a snippet
	var breakout = "";
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalnodeid = "";
	if (node.focalnodeid) {
		focalnodeid = node.focalnodeid;
	}
	var focalrole = "";
	var connrole = role;
	var otherend = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			connrole = connection.fromrole[0].role;
			focalrole = tN.role[0].role;
			otherend = tN;
		} else {
			connrole = connection.torole[0].role;
			focalrole = fN.role[0].role;
			otherend = fN;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title','style':'padding:0px;'});

	var nodeTable = new Element( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";
	//nodeTable.border = "1";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);

	// ADD THE ARROW IF REQUIRED
	if (node.istop) {
		var expandArrow = null;
		var arrowCell = row.insertCell(-1);
		arrowCell.vAlign="middle";
		arrowCell.align="left";

		if (CHAT_TREE_OPEN_ARRAY["chat"+uniQ] && CHAT_TREE_OPEN_ARRAY["chat"+uniQ] == true) {
			expandArrow = new Element('img',{'id':'explorechatarrow'+uniQ, 'name':'explorechatarrow', 'alt':'>', 'title':'<?php echo $LNG->CHAT_TREE_TOGGLE; ?>', 'style':'display:none;float:left;visibility:visible;margin-top:3px;','align':'left','border':'0','src': '<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>'});
			expandArrow.uniqueid = uniQ;
		} else {
			expandArrow = new Element('img',{'id':'explorechatarrow'+uniQ, 'name':'explorechatarrow', 'alt':'>', 'title':'<?php echo $LNG->CHAT_TREE_TOGGLE; ?>', 'style':'display:none;float:left;visibility:visible;margin-top:3px;','align':'left','border':'0','src': '<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>'});
			expandArrow.uniqueid = uniQ;
		}
		Event.observe(expandArrow,'click',function (){ toggleChat("chat"+uniQ,uniQ);});
		arrowCell.insert(expandArrow);
	} else {
		var lineCell = row.insertCell(-1);
		lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
		lineCell.width="15px;"
		lineCell.vAlign="middle";
		var lineDiv = new Element('div',{'class':'graylinewide', 'style':'float:left;width:100%;'});
		lineCell.insert(lineDiv);
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	var textCellDiv = new Element("div", { 'id':'textChatDivCell'+uniQ, 'name':'textChatDivCell', 'class':'whiteborder', 'style':'float:left;padding-top:1px;padding-bottom:3px;'});
	textCellDiv.nodeid = node.nodeid;
	textCellDiv.focalnodeid = node.focalnodeid;
	textCellDiv.nodetype = role.name;
	textCellDiv.parentuniQ = originaluniQ;
	if (connection) {
		textCellDiv.connection = connection;
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";
	toolbarCell.width="100";

	textCell.insert(textCellDiv);

	var cDate = new Date(connection.creationdate*1000);
	var dStr = "<?php echo $LNG->NODE_REPLY_ON; ?> "+cDate.format(TIME_FORMAT);

	// ADD THE NODE ICON - User IMAGE
	var nodeArea = new Element("span", {'name':'nodeArea', 'style':'float:left;padding-top:2px;' ,'title':dStr} );
	nodeArea.nodeid = node.nodeid;
	nodeArea.focalnodeid = node.focalnodeid;
	var alttext = getNodeTitleAntecedence(role.name, false);

	var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-left:5px;padding-right:5px;vertical-align:middle', 'border':'0','src': user.thumb});
	if (type == "active") {
		var imagelink = new Element('a', {
			'href':URL_ROOT+"user.php?userid="+user.userid,
			'title':user.name});
		if (breakout != "") {
			imagelink.target = "_blank";
		}
		imagelink.insert(userimageThumb);
		nodeArea.update(imagelink);
	} else {
		nodeArea.insert(userimageThumb)
	}

	nodeArea.insert(node.name);
	textCellDiv.insert(nodeArea);

	// if this node is the latest node added to the tree - highlight it
	// parentnode in the case of the chat topic connection, is the newest node added, rather than the parent connection.
	if (node.chattopic.parentnode &&
		node.chattopic.parentnode[0].cnode.nodeid == node.nodeid) {
		textCellDiv.className = 'plainborder';
		textCellDiv.style.borderStyle = "dotted";
	}
	if (CHATNODEID != "" && CHATNODEID == node.nodeid) {
		textCellDiv.className = textCellDiv.className + ' selectedback';
	}

	// ADD THE MENU ICON IF REQUIRED
	var menuButton = null;
	var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:130px;border:1px solid gray;background:white'} );

	Event.observe(toolbarDiv,'mouseout',function (event){
		hideBox('toolbardiv'+uniQ);
	});
	Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });

	if (node.istop) {
		var expandArrow = null;
		var childCount = new Element('div',{'style':'float:left; margin-left:5px;margin-right:5px;', 'title':'<?php echo $LNG->CHAT_TREE_COUNT_HINT; ?>'});
		childCount.insert("(");
		childCountSpan = new Element('span',{'name':'topchattreecount'});
		childCountSpan.id = 'topchattreecount'+uniQ;
		childCountSpan.insert(0);
		childCountSpan.uniqueid = uniQ;
		childCount.insert(childCountSpan);
		childCount.insert(")");
		toolbarCell.insert(childCount);
	}

	var delButton = null;

	// ADD ACTION MENU
	if (type == 'active') {
		menuButton = new Element('img',{'alt':'>', 'style':'float:left;padding-right:5px;width:20px;height:20px;','width':'20','height':'20','align':'left','border':'0','src': '<?php echo $HUB_FLM->getImagePath("menuicon.png"); ?>'});
		toolbarCell.insert(menuButton);
		Event.observe(menuButton,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(menuButton,'mouseover',function (event) {
			//var position = getPosition(this);
			//$('toolbardiv'+uniQ).style.left = (position.x+30)+"px";
			//$('toolbardiv'+uniQ).style.top = (position.y)+"px";

			var position = getPosition(this);
			var panel = $('toolbardiv'+uniQ);
			var panelWidth = 150;

			var viewportHeight = getWindowHeight();
			var viewportWidth = getWindowWidth();

			var x = position.x;
			var y = position.y;

			if ( (x+panelWidth+30) > viewportWidth) {
				x = x-(panelWidth+30);
			} else {
				x = x+10;
			}

			x = x+30+getPageOffsetX();

			panel.style.left = x+"px";
			panel.style.top = y+"px";

			showBox('toolbardiv'+uniQ);
		});

		var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:150px;border:1px solid gray;background:white'} );
		Event.observe(toolbarDiv,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
		toolbarCell.insert(toolbarDiv);

		if (USER != "") {
			var addButton = new Element("a", {'style':'margin-bottom:3px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->CHAT_REPLY_TO_MENU_HINT; ?>'} );
			Event.observe(addButton,'click',function () {
				hideBox('toolbardiv'+uniQ);

				$('prompttext').innerHTML="";
				$('prompttext').style.width = "300px";
				$('prompttext').style.height = "130px";

				var viewportHeight = getWindowHeight();
				var viewportWidth = getWindowWidth();
				var x = (viewportWidth-400)/2;
				var y = (viewportHeight-200)/2;
				if (GECKO || NS) {
					$('prompttext').style.left = x+window.pageXOffset+"px";
					$('prompttext').style.top = y+window.pageYOffset+"px";
				}
				else if (IE || IE5) {
					$('prompttext').style.left = x+ document.documentElement.scrollLeft+"px";
					$('prompttext').style.top = y+ document.documentElement.scrollTop+"px";
				}

				var textarea1 = new Element('textarea', {'id':'messagetextarea','rows':'5','style':'color: black; width:290px; border: 1px solid gray; padding: 3px; overflow:hidden'});
				var buttonOK = new Element('input', { 'style':'clear: both;margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_SAVE; ?>'});
				Event.observe(buttonOK,'click', function() {
					var comment = textarea1.value;
					if (comment != "") {
						var type = "Comment";

						var parentconnid = node.chattopic.connid;

						var reqUrl = SERVICE_ROOT + "&method=connectnodetocomment&nodetypename="+type+"&nodeid="+node.nodeid+"&parentconnid="+parentconnid+"&parentid="+nodeObj.nodeid+"&comment="+encodeURIComponent(comment);
						new Ajax.Request(reqUrl, { method:'get',
								onSuccess: function(transport){
									var json = transport.responseText.evalJSON();
									if(json.error){
										alert(json.error[0].message);
									} else {
										var from = json.connection[0].from[0].cnode;
										CHATNODEID = from.nodeid;
										refreshExploreChats();
									}
								},
						});
					}
					$('prompttext').style.display = "none";
					$('prompttext').update("");
				});

				var buttonCancel = new Element('input', { 'style':'margin-left: 5px; margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_CANCEL; ?>'});
				Event.observe(buttonCancel,'click', function() {
					$('prompttext').style.display = "none";
					$('prompttext').update("");
				});

				$('prompttext').insert(textarea1);
				$('prompttext').insert(buttonOK);
				$('prompttext').insert(buttonCancel);
				$('prompttext').style.display = "block";

				textarea1.focus();
			});
			Event.observe(addButton,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
			addButton.insert("<?php echo $LNG->CHAT_REPLY_TO_MENU_TEXT; ?>");
			addButton.href= "#";
			toolbarDiv.insert(addButton);

			if (connection && USER == connection.users[0].user.userid
				&&  node.nodeid == connection.from[0].cnode.nodeid) {

				var parentname = otherend.name;
				if (parentname.length > 50) {
					parentname = parentname.substr(0, 50)+"...";
				}
				parentname = " "+parentname;

				delButton = new Element('span',{'id':'chatremove'+uniQ, 'class':'active', 'style':'display:none;margin-bottom:5px;clear:both;float:left;','title':"<?php echo $LNG->DELETE_BUTTON_HINT; ?> "});
				delButton.insert("<?php echo $LNG->DELETE_BUTTON_ALT; ?>");
				delButton.connid = connection.connid;

				var parentconnid = node.chattopic.connid
				Event.observe(delButton,'click',function (){deleteChatNode(node.nodeid, node.name, node.handler, parentconnid)});
				toolbarDiv.insert(delButton);
			}

			<?php if ($CFG->SPAM_ALERT_ON) { ?>
				toolbarDiv.insert(createSpamMenuOption(node, role));
			<?php } ?>
		} else {
			var button = new Element("span");
			button.style.color="dimgray";
			button.style.cursor="pointer";
			button.title="<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
			button.insert("<?php echo $LNG->CHAT_REPLY_TO_MENU_TEXT; ?>");
			Event.observe(button,"click", function(){
				$('loginsubmit').click();
				return true;
			});
			toolbarDiv.insert(button);
		}
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'chat'+uniQ,'class':'ideadata', 'style':'padding:0px;margin-left:0px;color:Gray;'} );
	if (node.istop) {
		if (CHAT_TREE_OPEN_ARRAY["chat"+uniQ] && CHAT_TREE_OPEN_ARRAY["chat"+uniQ] == true) {
			expandDiv.style.display = 'block';
		} else {
			expandDiv.style.display = 'none';
		}
	} else {
		expandDiv.style.display = 'block';
	}
	var hint = node.name+" <?php echo $LNG->NODE_GOTO_PARENT_HINT; ?>"

	/**
	 * This is for the rollover hint around the vertical line - background image 21px wide 1px line in middle
	 * This was the only way to get it to work in all four main browsers!!!!!

   	 **/
	var expandTable = new Element( 'table', {'style':'empty-cells:show;border-collapse:collapse;'} );
	expandTable.height="100%";
	var expandrow = expandTable.insertRow(-1);
	expandrow.style.height="100%";
	if (node.istop) {
		expandTable.style.marginLeft = "9px";
	} else {
		expandTable.style.marginLeft = "26px";
	}

	var lineCell = expandrow.insertCell(-1);
	lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
	lineCell.width="5px;";
	lineCell.style.marginLeft="3px";
	lineCell.title=hint;
	lineCell.className="grayline";
	Event.observe(lineCell,'click',function (){
		var pos = getPosition(textCellDiv);
		window.scroll(0,pos.y-3);
	});

	var childCell = expandrow.insertCell(-1);
	childCell.vAlign="top";
	childCell.align="left";
	childCell.style.padding="0px";
	childCell.style.margin="0px";

	expandDiv.insert(expandTable);

	if (node.istop) {
		expandDiv.style.marginLeft = "22px";
	} else {
		expandDiv.style.marginLeft = "4px";
	}

	// CHECK FOR / LOAD CHILD LISTS
	if (node.children) {
		var nodes = node.children;
		nodes.sort(creationdatenodesortasc);
		if (nodes.length > 0){
			// process the child list adding properties.
			for (var i=0; i<nodes.length; i++) {
				var nextchild = nodes[i];
				nextchild.cnode['parentid'] = node.nodeid;
				nextchild.cnode['chattopic'] = node.chattopic;
			}

			childCell.insert('<div style="clear:both;"></div>');
			var childrenDiv = new Element("div", {'id':'children'+uniQ, 'style':'clear:both;float:left;margin-left:0px;padding-left:0px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(childrenDiv);
			childCell.insert('<div style="clear:both;"></div>');

			var parentrefreshhanlder = "";
			if (node.istop) {
				childCountSpan.update(nodes.length);
				if ($('explorechatarrow'+uniQ)) {
					$('explorechatarrow'+uniQ).style.visibility = 'visible';
				}
			} else {
				if (childCountSpan != null) {
					var countnow = parseInt(childCountSpan.innerHTML);
					var finalcount = countnow+nodes.length;
					childCountSpan.innerHTML = finalcount;
				}
			}
			displayChatNodes(childrenDiv, nodes, parseInt(0), true, uniQ, childCountSpan);
		} else {
			if (delButton) {
				delButton.style.display = "block";
			}
		}
	} else {
		if (delButton) {
			delButton.style.display = "block";
		}
	}

	/* else {
		childCell.insert('<div style="clear:both;"></div>');
		var childDiv = new Element("div", {'id':'comments'+uniQ, 'style':'clear:both;float:left;margin-bottom:5px;color:Gray;display:block;'} );
		childCell.insert(childDiv);
		childchatload(childDiv, node.nodeid, "Comments", "is related to", "Comment", node.chattopic, focalnodeid, uniQ, childCountSpan);
		childCell.insert('<div style="clear:both;"></div>');
	}*/

	idDiv.insert(expandDiv);
	imDiv.insert(idDiv);
	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}


/**
 * Render the given node from an associated connection.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderWidgetListNode(node, uniQ, role, includeUser, type){

	if (type === undefined) {
		type = "active";
	}

	if(role === undefined){
		role = node.role[0].role;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}
	var user = null;
	var connection = node.connection;
	if (connection) {
		user = connection.users[0].user;
	} else {
		user = nodeuser;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalrole = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			focalrole = tN.role[0].role;
		} else {
			focalrole = fN.role[0].role;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var nodeTable = document.createElement('table', {'style':'width:100%'});
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";
	//nodeTable.border = "1";
	var row = nodeTable.insertRow(-1);

	// VOTING
	if (type == 'active') {
		// Add voting icons
		if (connection && connection.linktype[0].linktype.label != '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>') {
			if ( (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && (connection.torole[0].role.name == "Solution"))
				|| (role.name == 'Solution' && (connection.torole[0].role.name == "Issue" || connection.torole[0].role.name == "Challenge"))
				)  {

				var voteCell = row.insertCell(-1);
				voteCell.vAlign="top";
				voteCell.align="left";
				voteCell.width="40";

				var voteDiv = new Element("div", {'style':'clear:both;float:left;margin-top:5px;'});
				//voteDiv.insert('<span style="margin-right:5px;"><?php echo $LNG->NODE_VOTE_MENU_TEXT; ?></span>');
				voteCell.insert(voteDiv);

				var toRoleName = getNodeTitleAntecedence(connection.torole[0].role.name, false);

				// vote for
				var voteforimg = document.createElement('img');
				voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-grey.png"); ?>');
				voteforimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_FOR_ICON_ALT; ?>');
				voteforimg.setAttribute('id', connection.connid+'for');
				voteforimg.nodeid = node.nodeid;
				voteforimg.connid = connection.connid;
				voteforimg.vote='Y';
				voteforimg.style.verticalAlign="bottom";
				voteforimg.style.marginRight="3px";
				voteDiv.insert(voteforimg);
				if (!connection.positivevotes) {
					connection.positivevotes = 0;
				}
				if(USER != ""){
					voteforimg.style.cursor = 'pointer';
					if (role.name == 'Solution') {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_SOLUTION_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
					} else {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>';
					}
					if (connection.uservote && connection.uservote == 'Y') {
						Event.observe(voteforimg,'click',function (){ deleteConnectionVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled.png"); ?>');
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!connection.uservote || connection.uservote != 'Y') {
						Event.observe(voteforimg,'click',function (){ connectionVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
						voteforimg.setAttribute('title', voteforimg.oldtitle);
					}
					voteDiv.insert('<b><span style="font-size: 10pt; margin-right: 5px;" id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
				} else {
					voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_LOGIN_HINT; ?>');
					voteDiv.insert('<b><span style="font-size: 10pt; margin-right: 5px;" id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
				}

				// vote against
				var voteagainstimg = document.createElement('img');
				voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-grey.png"); ?>');
				voteagainstimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_AGAINST_ICON_ALT; ?>');
				voteagainstimg.setAttribute('id', connection.connid+'against');
				voteagainstimg.nodeid = node.nodeid;
				voteagainstimg.connid = connection.connid;
				voteagainstimg.vote='N';
				voteagainstimg.style.verticalAlign="bottom";
				voteagainstimg.style.marginTop="5px";
				voteagainstimg.style.marginRight="3px";
				voteDiv.insert(voteagainstimg);
				if (!connection.negativevotes) {
					connection.negativevotes = 0;
				}
				if(USER != ""){
					voteagainstimg.style.cursor = 'pointer';
					if (role.name == 'Solution') {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_SOLUTION_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
					} else {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>';
					}
					if (connection.uservote && connection.uservote == 'N') {
						Event.observe(voteagainstimg,'click',function (){ deleteConnectionVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled.png"); ?>');
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!connection.uservote || connection.uservote != 'N') {
						Event.observe(voteagainstimg,'click',function (){ connectionVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
						voteagainstimg.setAttribute('title', voteagainstimg.oldtitle);
					}
					voteDiv.insert('<b><span style="font-size: 10pt; margin-right: 10px;" id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
				} else {
					voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_LOGIN_HINT; ?>');
					voteDiv.insert('<b><span style="font-size: 10pt; margin-right: 10px;" id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
				}
			}
		}
	}

	/*if (includeUser == true) {
		var userCell = row.insertCell(-1);
		userCell.vAlign="middle";
		userCell.align="right";
		userCell.width="40px;";
		if (connection) {
			var cDate = new Date(connection.creationdate*1000);
			var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)
			userCell.title = dStr;
		}


		// Add right side with user image and date below
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'float:left;'});

		var userimageThumb = new Element('img',{'alt':nodeuser.name, 'style':'padding-left:5px;', 'border':'0','src': nodeuser.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+nodeuser.userid
				});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}

		userCell.appendChild(iuDiv);
	}*/

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	textCell.width="90%";

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i< node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'target': '_blank' });
 		var nodeicon = new Element('img',{'alt':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'style':'width:20px;height:20px;padding-right:5px;','align':'left', 'border':'0','src': URL_ROOT + node.imagethumbnail});
 		iconlink.insert(nodeicon);
 		textCell.insert(iconlink);
 		textCell.insert(alttext+": ");
	} else if (role.image != null && role.image != "") {
 		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:20px;height:20px;margin-top:3px;padding-right:5px;','align':'left','border':'0','src': URL_ROOT + role.image});
		textCell.insert(nodeicon);
	} else {
 		textCell.insert(alttext+": ");
	}

	var title = node.name;
	//textCell.insert("<a class='itemtext' style='line-height:1.8em;font-weight:normal' id='desctoggle"+uniQ+"' href='<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"'>"+title+"</a>");

	var exploreButton = new Element('a', {'class':'itemtext', 'id':'desctoggle'+uniQ, 'style':'line-height:1.8em;font-weight:normal'});
	if (role.name == "Map") {
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>map.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>map.php?id="+node.nodeid;
		}
	} else {
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
	}
	exploreButton.insert(title);
	textCell.insert(exploreButton);

	if (connection) {
		var cDate = new Date(connection.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_DETAIL_BUTTON_HINT;?>';
		textCell.title = dStr;
	} else {
		var cDate = new Date(node.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_ADDED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_TOGGLE_HINT;?>';
		textCell.title = dStr;
	}

	if (connection && USER == connection.users[0].user.userid) {

		var delCell = row.insertCell(-1);
		delCell.vAlign="middle";
		delCell.align="right";
		delCell.width="20";

		var del = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NODE_DISCONNECT_LINK_HINT; ?>'} );
		del.insert('<img border="0" src="<?php echo $HUB_FLM->getImagePath("delete.png"); ?>" />');
		//del.insert("<?php echo $LNG->NODE_DISCONNECT_LINK_TEXT; ?>");
		del.connid = connection.connid;

		var parentname = "";
		if (node.nodeid == connection.from[0].cnode.nodeid) {
			parentname = connection.to[0].cnode.name;
		} else {
			parentname = connection.from[0].cnode.name;
		}

		var fromName = node.name;
		var toName = parentname;

		Event.observe(del,'click',function (){ deleteNodeConnection(this.connid, fromName, toName, node.handler)});
		delCell.insert(del);
	}

	return nodeTable;
}

/**
 * Render the given node.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 */
function renderListNode(node, uniQ, role, includeUser){

	var type = "active";

	if(role === undefined){
		role = node.role[0].role;
	}

	if(includeUser === undefined){
		includeUser = false;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	uniQ = node.nodeid + uniQ;

	var nodeTable = new Element('table', {'style':'width:100%'});
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";

	var row = nodeTable.insertRow(-1);

	if (includeUser) {
		var userCell = row.insertCell(-1);
		userCell.vAlign="top";
		userCell.align="left";
		userCell.width="40px;";

		var cDate = new Date(node.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_ADDED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)
		userCell.title = dStr;

		// Add right side with user image and date below
		var iuDiv = new Element("div", {
			'id':'editformuserdivcomment'+uniQ,
			'class':'idea-user2',
			'style':'float:left;display:block'
		});

		var userimageThumb = new Element('img',{'alt':user.name, 'style':'padding-left:5px;', 'border':'0','src': user.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+user.userid
				});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}

		userCell.insert(iuDiv);
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="top";
	textCell.align="left";

	var textDiv = new Element("div", {
		'id':'textdivcomment'+uniQ,
		'style':'clear:both;float:left;width:100%;display:block;'
	});
	textCell.insert(textDiv);

	var title = node.name;

	var textspan = new Element("a", {
		'style':'float:left;font-weight:normal;font-size:12pt;line-height:1em'
	});
	textspan.insert(title);
	textspan.href = '<?php echo $CFG->homeAddress; ?>explore.php?id='+node.nodeid;
	textDiv.insert(textspan);

	if (node.private == "Y") {
		var padlockicon = new Element("img", {'style':'float:left;width:18px; height:18px;padding-left:5px;'});
		padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
		textDiv.insert(padlockicon);
	}

	if(node.description || node.hasdesc){
		var dStr = '<div style="clear:both;margin:0px;padding:0px;margin-top:3px;font-size:10pt;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;">';
		if (node.description && node.description != "") {
			dStr += node.description;
		}
		dStr += '</div>';
		textDiv.insert(dStr);
	}

	return nodeTable;
}

/**
 * Render the given node.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 */
function renderUsersChatListNode(node, uniQ, role, includeUser){
	var type = "active";

	if(role === undefined){
		role = node.role[0].role;
	}

	if(includeUser === undefined){
		includeUser = false;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	uniQ = node.nodeid + uniQ;

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});

	var nodeTable = new Element('table', {'style':'width:100%'});
	nodeTable.className = "toConnectionsTable";
	nodeTable.width="100%";
	iDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);

	if (includeUser) {
		var userCell = row.insertCell(-1);
		userCell.vAlign="top";
		userCell.align="left";
		userCell.width="40px;";

		var cDate = new Date(node.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_ADDED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)
		userCell.title = dStr;

		// Add right side with user image and date below
		var iuDiv = new Element("div", {
			'id':'editformuserdivcomment'+uniQ,
			'class':'idea-user2',
			'style':'float:left;display:block'
		});

		var userimageThumb = new Element('img',{'alt':user.name, 'style':'padding-left:5px;', 'border':'0','src': user.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+user.userid
				});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}

		userCell.insert(iuDiv);
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="top";
	textCell.align="left";

	var textDiv = new Element("div", {
		'id':'textdivcomment'+uniQ,
		'style':'clear:both;float:left;width:100%;display:block;'
	});
	textCell.insert(textDiv);

	var title = node.name;

	textDiv.insert("<span class='active' style='float:left;font-weight:normal;font-size:12pt;line-height:1em' id='desctoggle"+uniQ+"' title='<?php echo $LNG->NODE_TOGGLE_HINT; ?>' onClick='ideatoggle2(\"desc"+uniQ+"\",\""+uniQ+"\", \""+node.nodeid+"\",\"desc\",\""+role.name+"\")'>"+title+"</span>");


	/*var textspan = new Element("span", { 'class':'active','id':'desctoggle'+uniQ,
		'style':'float:left;font-weight:normal;font-size:12pt;line-height:1em', 'title':'<?php echo $LNG->NODE_TOGGLE_HINT; ?>'});
	Event.observe(textspan,'click',function (){
		ideatoggle2("desc"+uniQ,uniQ,node.nodeid,"desc",role.name);
	});
	textspan.insert(title);
	//textspan.href = '<?php echo $CFG->homeAddress; ?>explore.php?id='+node.nodeid;
	textDiv.insert(textspan);
	*/

	if (node.private == "Y") {
		var padlockicon = new Element("img", {'style':'float:left;width:18px; height:18px;padding-left:5px;'});
		padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
		textDiv.insert(padlockicon);
	}

	if(node.description || node.hasdesc){
		var dStr = '<div style="clear:both;margin:0px;padding:0px;margin-top:3px;font-size:10pt;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;">';
		if (node.description && node.description != "") {
			dStr += node.description;
		}
		dStr += '</div>';
		textDiv.insert(dStr);
	}

	var expandDiv = new Element("div", {'id':'desc'+uniQ, 'class':'ideadata', 'style':'padding-left:20px;color:Gray;display:none;'} );
	var commentdiv = new Element("div", { 'id':'commentdiv'+uniQ, 'name':'commentdiv', 'style':'float:left;padding:3px;margin-bottom:5px;display:block'});
	expandDiv.insert(commentdiv);

	var searchid="";
	if (node.searchid) {
		searchid = node.searchid;
	}

	childchatusageload(commentdiv, node.nodeid, "<?php echo $CFG->LINK_COMMENT_NODE; ?>", EVIDENCE_TYPES_STR+","+BASE_TYPES_STR+",Comment", uniQ, searchid);

	iDiv.insert(expandDiv);

	return iDiv;
}


/**
 * Render the given node for a report.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 */
function renderReportNode(node, uniQ, role){

	if(role === undefined){
		role = node.role[0].role;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}
	uniQ = node.nodeid + uniQ;
	var iDiv = new Element("div", {'style':'clear:both;float:left; margin-bottom:10px'});
	var itDiv = new Element("div", {'style':'float:left;'});

	//get url for any saved image.
	//add left side with icon image and node text.
	var alttext = getNodeTitleAntecedence(role.name, false);
	if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {
		if (node.imagethumbnail != null && node.imagethumbnail != "") {
			var originalurl = "";
			if(node.urls && node.urls.length > 0){
				for (var i=0 ; i< node.urls.length; i++){
					var urlid = node.urls[i].url.urlid;
					if (urlid == node.imageurlid) {
						originalurl = node.urls[i].url.url;
						break;
					}
				}
			}
			if (originalurl == "") {
				originalurl = node.imagethumbnail;
			}
			var iconlink = new Element('a', {
				'href':originalurl,
				'title':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'target': '_blank' });
			var nodeicon = new Element('img',{'alt':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'style':'width:16px;height:16px;margin-right:5px;','width':'16','height':'16','align':'left', 'border':'0','src': URL_ROOT + node.imagethumbnail});
			iconlink.insert(nodeicon);
			itDiv.insert(iconlink);
			itDiv.insert(alttext+": ");
		} else if (role.image != null && role.image != "") {
			var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:16px;height:16px;margin-right:5px;','width':'16','height':'16','align':'left', 'border':'0','src': URL_ROOT + role.image});
			itDiv.insert(nodeicon);
		} else {
			itDiv.insert(alttext+": ");
		}
	}

	if (node.name != "") {
		iDiv.insert(itDiv);
		var str = "<div style='float:left;width:600px;'>"+node.name;
		str += "</div>";
		iDiv.insert(str);
	}

	return iDiv;
}


/*** HELPER FUNCTIONS ***/

var DEBATE_TREE_OPEN_ARRAY = {};

/**
 * Open and close the knowledge tree
 */
function toggleDebate(section, uniQ) {
    $(section).toggle();

    if($(section).visible()){
    	DEBATE_TREE_OPEN_ARRAY[section] = true;
    	$('explorearrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>';
	} else {
    	DEBATE_TREE_OPEN_ARRAY[section] = false;
		$('explorearrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>';
	}
}

var CHAT_TREE_OPEN_ARRAY = {};

/**
 * Open and close the chat tree
 */
function toggleChat(section, uniQ) {
    $(section).toggle();

    if($(section).visible()){
    	CHAT_TREE_OPEN_ARRAY[section] = true;
    	$('explorechatarrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>';
	} else {
    	CHAT_TREE_OPEN_ARRAY[section] = false;
		$('explorechatarrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>';
	}
}

function ideaArgumentToggle(section, uniQ, id, sect, rolename, focalnodeid, groupid) {
   $(section).toggle();
   if($('arrow'+section)){
        if($(section).visible()){
            $('arrow'+section).src = "<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>";
        } else {
            $('arrow'+section).src = "<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>";
        }
	}
}

function ideatoggle(section, uniQ, id, sect, rolename, focalnodeid, groupid) {

   if ($(section).style.display == 'block') {
   		$(section).style.display = 'none';
   } else if ($(section).style.display == 'none') {
   		$(section).style.display = 'block';
   }

	if ($('idearowitem'+uniQ) ) {
		if($('comments'+uniQ).style.display == 'none' && $('arguments'+uniQ).style.display == 'none'){
			$('idearowitem'+uniQ).style.background = "transparent";
		} else {
			$('idearowitem'+uniQ).style.background = "#E8E8E8";
   		}
   	}
}

/**
 * Open and close the meta data sections - get additional stuff if required.
 */
function ideatoggle2(section, uniQ, id, sect, rolename) {
    $(section).toggle();

    if(sect == "desc" && $(section).visible() && !$(section).description){
		var reqUrl = SERVICE_ROOT + "&method=getnode&nodeid=" + encodeURIComponent(id);
		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				Element.insert($(section+'div'), {'bottom':json.cnode[0].description});
				$(section).description = 'true';
			}
		});
	}
}

/**
 * Open and close the meta data sections - get additional stuff if required.
 */
function ideatoggle3(section, uniQ, id, sect, rolename) {
    $(section).toggle();
    if($('open'+section)){
        if($(section).visible()){
            $('open'+section).update("&laquo; ");
        } else {
            $('open'+section).update("&raquo;");
        }
	}

    if(sect == "desc" && $(section).visible() && !$(section).description){
		var reqUrl = SERVICE_ROOT + "&method=getnode&nodeid=" + encodeURIComponent(id);
		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				Element.insert($(section+'div'), {'bottom':json.cnode[0].description});
				$(section).description = 'true';
			}
		});
	}
}

function loadStats(node, user, role, uniQ, peoplearea, ideaarea, totalvotearea, positivevotearea, negativevotearea, topicarea) {

	var nodeid = node.nodeid;

	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.
	args["nodeid"] = nodeid;
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";

    args['style'] = "long";
    args['depth'] = 2;

    args['labelmatch'] = 'false';
    args['uniquepath'] = 'true';
    args['logictype'] = 'or';

	var extra = "&nodeids[]=";
	extra += "&nodeids[]=";
	//extra += "&nodeids[]=";

	extra += "&nodetypes[]="+encodeURIComponent('Solution');
	extra += "&nodetypes[]="+encodeURIComponent('Pro,Con,Comment');

	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";

	extra += "&linklabels[]=";
	extra += "&linklabels[]="+encodeURIComponent('supports,challenges');
	//extra += "&linklabels[]="; //+encodeURIComponent('is related to');

	extra += "&linkgroups[]=All";
	extra += "&linkgroups[]=";
	//extra += "&linkgroups[]=All";

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth"+extra+"&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var conns = json.connectionset[0].connections;
			//alert("conns: "+conns.length);

			var totalvotes = parseInt(0);
			var positivevotes = parseInt(0);
			var negativevotes = parseInt(0);
			var ideacount = parseInt(0);
			var peoplecount = parseInt(1);

			if ($('debatemembersarea')) {
				var nextperson = new Element("div", {'style':'float:left;margin:0px;padding:0px;margin-bottom:10px;margin-right:10px;'});
				nextperson.insert("<a href='user.php?userid="+user.userid+"'><img src='"+user.thumb+"'/></a>");
				$('debatemembersarea').update(nextperson);
			}

			var topiccount = parseInt(0);

			var peoplecheck = new Array();
			peoplecheck[user.userid] = user.userid;

			var nodecheck = new Array();
			var connectioncheck = new Array();

			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					if (!connectioncheck[c.connid]) {
						connectioncheck[c.connid] = c.connid;
						positivevotes += parseInt(c.positivevotes);
						negativevotes += parseInt(c.negativevotes);
						totalvotes += parseInt(c.positivevotes);
						totalvotes += parseInt(c.negativevotes);

						//add check to not count comment votes (there should not be any really)

						var fN = c.from[0].cnode;
						if (!nodecheck[fN.nodeid]) {
							nodecheck[fN.nodeid] = fN.nodeid;
							positivevotes += parseInt(fN.positivevotes);
							negativevotes += parseInt(fN.negativevotes);
							totalvotes += parseInt(fN.positivevotes);
							totalvotes += parseInt(fN.negativevotes);

							if (fN.role[0].role.name == "Solution") {
								ideacount++;
							}
						}

						var tN = c.to[0].cnode;
						if (!nodecheck[tN.nodeid]) {
							nodecheck[tN.nodeid] = tN.nodeid;
							positivevotes += parseInt(tN.positivevotes);
							negativevotes += parseInt(tN.negativevotes);
							totalvotes += parseInt(tN.positivevotes);
							totalvotes += parseInt(tN.negativevotes);
							if (tN.role[0].role.name == "Solution") {
								ideacount++;
							}
						}

						var fUser = fN.users[0].user;
						if (!peoplecheck[fUser.userid]) {
							peoplecheck[fUser.userid] = fUser.userid;
							peoplecount++;

							if ($('debatemembersarea')) {
								var nextperson = new Element("div", {'style':'float:left;margin:0px;padding:0px;margin-bottom:10px;margin-right:10px;'});
								nextperson.insert("<a href='user.php?userid="+fUser.userid+"'><img src='"+fUser.thumb+"'/></a>");
								$('debatemembersarea').insert(nextperson);
							}
						}
						var tUser = fN.users[0].user;
						if (!peoplecheck[tUser.userid]) {
							peoplecheck[tUser.userid] = tUser.userid;
							peoplecount++;

							if ($('debatemembersarea')) {
								var nextperson = new Element("div", {'style':'float:left;margin:0px;padding:0px;margin-bottom:10px;margin-right:10px;'});
								nextperson.insert("<a href='user.php?userid="+tUser.userid+"'><img src='"+tUser.thumb+"'/></a>");
								$('debatemembersarea').insert(nextperson);
							}
						}
					}
				}
			}

			if (peoplecount == 1 && $('deletebutton'+uniQ)) {
				var deletename = node.name;

				$('deletebutton'+uniQ).src = '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>';
				$('deletebutton'+uniQ).alt = '<?php echo $LNG->DELETE_BUTTON_ALT;?>';
				$('deletebutton'+uniQ).title = '<?php echo $LNG->DELETE_BUTTON_HINT;?>';
				Event.observe($('deletebutton'+uniQ),'click',function (){
					deleteNode(node.nodeid, deletename, role.name);
				});
			}

			if (peoplearea) {
				peoplearea.update(peoplecount);
			}
			if (ideaarea) {
				ideaarea.update(ideacount);
			}
			if (topicarea) {
				topicarea.update(topiccount);
			}
			if (totalvotearea) {
				totalvotearea.update(totalvotes);
			}
			if (positivevotearea) {
				positivevotearea.update(positivevotes);
			}
			if (negativevotearea) {
				negativevotearea.update(negativevotes);
			}
		}
	});
}
function loadMembers(node, user, role, uniQ) {

	var nodeid = node.nodeid;

	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.
	args["nodeid"] = nodeid;
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";

    args['style'] = "long";
    args['depth'] = 2;

    args['labelmatch'] = 'false';
    args['uniquepath'] = 'true';
    args['logictype'] = 'or';

	var extra = "&nodeids[]=";
	extra += "&nodeids[]=";

	extra += "&nodetypes[]="+encodeURIComponent('Solution');
	extra += "&nodetypes[]="+encodeURIComponent('Pro,Con,Comment');

	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";

	extra += "&linklabels[]=";
	extra += "&linklabels[]="+encodeURIComponent('supports,challenges');

	extra += "&linkgroups[]=All";
	extra += "&linkgroups[]=";

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth"+extra+"&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var conns = json.connectionset[0].connections;
			//alert("conns: "+conns.length);

			if ($('debatemembersarea')) {
				var nextperson = new Element("div", {'style':'float:left;margin:0px;padding:0px;margin-bottom:10px;margin-right:10px;'});
				nextperson.insert("<a href='user.php?userid="+user.userid+"'><img src='"+user.thumb+"'/></a>");
				$('debatemembersarea').update(nextperson);
			}
			var peoplecount = parseInt(1);
			var peoplecheck = new Array();
			peoplecheck[user.userid] = user.userid;

			var connectioncheck = new Array();

			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					if (!connectioncheck[c.connid]) {
						connectioncheck[c.connid] = c.connid;

						var fN = c.from[0].cnode;
						var fUser = fN.users[0].user;
						if (!peoplecheck[fUser.userid]) {
							peoplecheck[fUser.userid] = fUser.userid;
							peoplecount++;
							if ($('debatemembersarea')) {
								var nextperson = new Element("div", {'style':'float:left;margin:0px;padding:0px;margin-bottom:10px;margin-right:10px;'});
								nextperson.insert("<a href='user.php?userid="+fUser.userid+"'><img src='"+fUser.thumb+"'/></a>");
								$('debatemembersarea').insert(nextperson);
							}
						}
						var tN = c.to[0].cnode;
						var tUser = fN.users[0].user;
						if (!peoplecheck[tUser.userid]) {
							peoplecheck[fUser.userid] = fUser.userid;
							peoplecount++;
							if ($('debatemembersarea')) {
								var nextperson = new Element("div", {'style':'float:left;margin:0px;padding:0px;margin-bottom:10px;margin-right:10px;'});
								nextperson.insert("<a href='user.php?userid="+tUser.userid+"'><img src='"+tUser.thumb+"'/></a>");
								$('debatemembersarea').insert(nextperson);
							}
						}
					}
				}
			}

			if (peoplecount == 1 && $('deletebutton'+uniQ)) {
				var deletename = node.name;

				$('deletebutton'+uniQ).src = '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>';
				$('deletebutton'+uniQ).alt = '<?php echo $LNG->DELETE_BUTTON_ALT;?>';
				$('deletebutton'+uniQ).title = '<?php echo $LNG->DELETE_BUTTON_HINT;?>';
				Event.observe($('deletebutton'+uniQ),'click',function (){
					deleteNode(node.nodeid, deletename, role.name);
				});
				Event.observe($('deletebutton'+uniQ),'click',function (){
					deleteNode(node.nodeid, deletename, role.name);
				});
			}
		}
	});
}

/**
 * Open and close the meta data sections
 */
function justideatoggle(section){
    $(section).toggle();
    if($('open'+section)){
        if($(section).visible()){
            $('open'+section).update("-");
        } else {
            $('open'+section).update("+");
        }
    }
}

/**
 * Open and close the evidence - get data if required.
 */
function childtoggle(section, nodeid, title, linktype, nodetype){
    $(section).toggle();

    if($('open'+section)){
        if($(section).visible()){
            $('open'+section).update("-");
        } else {
            $('open'+section).update("+");
        }
    }

    childload(section, nodeid, title, linktype, nodetype);
 }

/**
 * load data if required as per parameters.
 */
function childloadcount(section, nodeid, linktype, nodetype){
	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
	reqUrl += "&filterlist="+linktype+"&filternodetypes="+nodetype+"&scope=all&start=0&max=0&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var count = json.connectionset[0].totalno;

			if (count > 0) {
				$("toggle"+section).style.display = 'block';
				$("count"+section).update(count);
			} else {
				$("toggle"+section).style.display = 'none';
			}
		}
	});
}

/**
 * Refresh child list
 */
function refreshchildren(section, nodeid, title, linktype, nodetype) {
	$(section).loaded = 'false';
	childload(section, nodeid, title, linktype, nodetype);
}

/**
 * load child list, if required as per parameters.
 */
function childload(section, nodeid, title, linktype, nodetype, focalnodeid, uniQ, childCountSpan){

	if (typeof section === "string") {
		section = $(section);
	}

    if(section.visible() && (!section.loaded || section.loaded == 'false')){
		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
		reqUrl += "&filterlist="+linktype+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;

		//alert(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
				var conns = json.connectionset[0].connections;
				section.update("");

				//alert(conns.length);

				if (conns.length > 0) {
					//$("toggle"+section).style.display = 'block';
					//section.style.display = 'block';
					if ($("count-"+section)) {
						$("count-"+section).update(conns.length);
					}
				} else {
					//$("toggle"+section).style.display = 'none';
					//section.style.display = 'none';
				}

				if (conns.length == 0) {
					//section.update("<span style='margin-left:10px;'>No "+title+" listed</span>");
					section.style.display = 'none';
				} else {
					var nodes = new Array();
					for(var i=0; i< conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if ((fnRole.name == nodetype || nodetype.indexOf(fnRole.name) != -1) && fN.nodeid != nodeid) {
							if (fN.name != "") {
								var next = c.from[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								if (focalnodeid) {
									next.cnode['focalnodeid'] = focalnodeid;
								}
								nodes.push(next);
							}
						} else if ((tnRole.name == nodetype || nodetype.indexOf(tnRole.name) != -1) && tN.nodeid != nodeid) {
							if (tN.name != "") {
								var next = c.to[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								if (focalnodeid) {
									next.cnode['focalnodeid'] = focalnodeid;
								}
								nodes.push(next);
							}
						}
					}

					if (nodes.length > 0){
						if ($('explorearrow'+uniQ)) {
							$('explorearrow'+uniQ).style.visibility = 'visible';
						}

						if (childCountSpan != null) {
							var countnow = parseInt(childCountSpan.innerHTML);
							var finalcount = countnow+nodes.length;
							childCountSpan.innerHTML = finalcount;
						}

						var parentrefreshhanlder = "";
						displayConnectionNodes(section, nodes, parseInt(0), true, uniQ, childCountSpan, parentrefreshhanlder);
					} else {
						//section.update("<span style='margin-left:10px;'>No "+title+" listed</span>");
					}

					section.loaded = 'true';
				}
			}
		});
	} else {
		childloadcount(section, nodeid, linktype, nodetype);
	}
}

/**
 * load child list, if required as per parameters.
 */
function childchatusageload(section, nodeid, linktype, nodetype, uniQ, searchid){

	if (typeof section === "string") {
		section = $(section);
	}

    if(!section.loaded || section.loaded == 'false'){
		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
		reqUrl += "&filterlist="+linktype+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;
		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
				var conns = json.connectionset[0].connections;

				if (conns.length > 0) {
					var nodes = new Array();
					for(var i=0; i< conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						// only want to get the To end
						if ((tnRole.name == nodetype || nodetype.indexOf(tnRole.name) != -1) && tN.nodeid != nodeid) {
							if (tN.name != "") {
								var next = c.to[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								nodes.push(next);
							}
						}
					}

					if (nodes.length > 0) {
						var	title="<?php echo $LNG->CHAT_COMMENT_PARENT_TREE; ?>";
						section.insert('<span style="float:left; font-weight:bold">'+title+'</span>');

						var count = nodes.length;
						for (var i=0; i<count; i++) {
							var node = nodes[i];
							node = node.cnode;

							var role = node.role[0].role;
							var name = node.name

							if (role.name == "Comment") {
								if (node.connection.parentnode) {
									var icon = getNodeIconElement(node.connection.parentnode[0].cnode);
									var innertitle = node.connection.parentnode[0].cnode.name;
									var parentid = node.connection.parentnode[0].cnode.nodeid;
									var exploreButton = new Element("a", {'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
									if (icon != null) {
										exploreButton.insert(icon);
										exploreButton.insert('<span style="float:left;margin-top:5px;">'+innertitle+'</span>');
									} else {
										exploreButton.insert(innertitle);
									}
									if (searchid != "") {
										exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+parentid+"&sid="+searchid;
									} else {
										exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+parentid;
									}

									section.insert(exploreButton);
								}
								var nextStr = "<span style='clear:both;margin-left:25px;font-weight:bold;float:left;'>";
								nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
								nextStr += "<span style='font-weight:normal'>"+name+"</span>";
								nextStr += "</span>";
								section.insert(nextStr);
							} else {
								var icon = getNodeIconElement(node);
								var exploreButton = new Element("a", {'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
								if (icon != null) {
									exploreButton.insert(icon);
									exploreButton.insert('<span style="float:left;margin-top:5px;">'+name+'</span>');
								} else {
									exploreButton.insert(name);
								}

								if (searchid != "") {
									exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+node.nodeid+"&sid="+searchid;
								} else {
									exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+node.nodeid;
								}

								section.insert(exploreButton);

								var nextStr = "<span style='clear:both;margin-left:25px;font-weight:bold;float:left;'>";
								nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
								nextStr += "<span style='font-weight:normal'>"+name+"</span>";
								nextStr += "</span>";
								section.insert(nextStr);
							}
						}
					}

					section.loaded = 'true';
				}
			}
		});
	}
}


/**
 * load child list on chat page, if required as per parameters.
 */
function childchatload(section, nodeid, title, linktype, nodetype, chattopic, focalnodeid, uniQ, childCountSpan){

	CHAT_LOADED_ARRAY['nodeid'+uniQ] = false;

	if (typeof section === "string") {
		section = $(section);
	}

    if($(section).visible() && (!$(section).loaded || $(section).loaded == 'false')){

		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long&sort=ASC&orderby=date";
		reqUrl += "&filterlist=<?php echo $CFG->LINK_COMMENT_NODE; ?>&filternodetypes=Comment&scope=all&start=0&max=-1&nodeid="+nodeid;

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				CHAT_LOADED_ARRAY['nodeid'+uniQ] = true;

				var conns = json.connectionset[0].connections;
				section.update("");

				if (conns.length == 0) {
					//section.style.display = 'none';
					if ($('chat'+uniQ)) {
						$('chat'+uniQ).style.display = 'none';
					}
				} else {
					var nodes = new Array();
					for(var i=0; i< conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						var fnRole = c.from[0].cnode.role[0].role; // c.fromrole[0].role;
						var tnRole = c.to[0].cnode.role[0].role; //c.torole[0].role;

						if (fN.nodeid != nodeid && fnRole.name == 'Comment') {
							if (fN.name != "") {
								var next = c.from[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['chattopic'] = chattopic;
								next.cnode['connection'] = c;
								next.cnode['handler'] = 'refreshExploreChats';
								nodes.push(next);
							}
						}
					}

					if (nodes.length > 0){
						if ($('explorechatarrow'+uniQ)) {
							$('explorechatarrow'+uniQ).style.visibility = 'visible';
						}

						if ($('chatremove'+uniQ)) {
							$('chatremove'+uniQ).style.display = "none";
						}
						if (childCountSpan != null) {
							var countnow = parseInt(childCountSpan.innerHTML);
							var finalcount = countnow+nodes.length;
							childCountSpan.innerHTML = finalcount;
						}
						displayChatNodes(section, nodes, parseInt(0), true, uniQ, childCountSpan);
					} else {
						if ($('chat'+uniQ)) {
							$('chat'+uniQ).style.display = 'none';
						}
						section.style.display = 'none';
					}

					section.loaded = 'true';
				}
			}
		});
	} else {
		//childloadcount(section, nodeid, linktype, nodetype);
	}
}

/**
 * load child list on solutionas for built froms.
 */
function loadBuiltFromsCount(section, nodeid){

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long&sort=DESC&orderby=date&status=<?php echo $CFG->STATUS_ACTIVE; ?>";
	reqUrl += "&filterlist=<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>&filternodetypes=Solution&scope=all&start=0&max=0&nodeid="+nodeid;
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();

			if(json.error){
				//alert(json.error[0].message);
				return;
			}

			var count = json.connectionset[0].totalno;
			if (count > 0) {
				section.style.display = "block";
			}
		}
	});
}


/**
 * Delete the selected node
 */
function deleteNode(nodeid, name, type, handler, handlerparams){
	var typename = getNodeTitleAntecedence(type, false);
	if (type == "") {
		typename = '<?php echo $LNG->NODE_DELETE_CHECK_MESSAGE_ITEM; ?>';
	}

	var ans = confirm("<?php echo $LNG->NODE_DELETE_CHECK_MESSAGE; ?> "+typename+": '"+htmlspecialchars_decode(name)+"'?");
	if(ans){
		var reqUrl = SERVICE_ROOT + "&method=deletenode&nodeid=" + encodeURIComponent(nodeid);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				//now refresh the page
				if (handler && (typeof handler === "string" || typeof handler === "function")) {
					if (typeof handler === "string") {
						var pos = handler.indexOf(")");
						if (pos != -1) {
							eval ( handler );
						} else {
							if (handlerparams) {

								eval( handler + "('"+handlerparams+"')" );
							} else {
								eval( handler + "()" );
							}
						}
					} else if (typeof handler === "function") {
						handler();
					}
				} else {
					try {
						// If you are deleting the currently viewed item
						if (nodeid == NODE_ARGS['nodeid']) {
							if (NODE_ARGS['groupid'] != "") {
								window.location.href = "<?php echo $CFG->homeAddress;?>group.php?groupid="+NODE_ARGS['groupid'];
							} else {
								window.location.href = "<?php echo $CFG->homeAddress;?>";
							}
						} else {
							window.location.reload(true);
						}
					} catch(err) {
						//do nothing
					}
				}
    		}
  		});

	}
}

function nodeVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=nodevote&vote="+obj.vote+"&nodeid="+obj.nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

   					$$("#nodefor"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){deleteNodeVote(this);});
   					});

  					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

  					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});
				} else if (obj.vote == 'N') {
					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

   					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){deleteNodeVote(this) } );
   					});

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

  					$$("#nodefor"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});
				}
   			}
   		}
  	});
}

function deleteNodeVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=deletenodevote&vote="+obj.vote+"&nodeid="+obj.nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

   					$$("#nodefor"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){nodeVote(this);});
   					});

  					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

  					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});

					$(obj.nodeid+obj.uniqueid+'nodeagainst').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
					$(obj.nodeid+obj.uniqueid+'nodeagainst').setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
					Event.stopObserving($(obj.nodeid+obj.uniqueid+'nodeagainst'), 'click');
					Event.observe($(obj.nodeid+obj.uniqueid+'nodeagainst'),'click', function (){ connectionVote(this) } );

				} if (obj.vote == 'N') {
					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

   					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){nodeVote(this) } );
   					});

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

  					$$("#nodefor"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});
				}
   			}
   		}
  	});
}

function followNode(node, obj, handler) {
	var reqUrl = SERVICE_ROOT + "&method=addfollowing&itemid="+node.nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				node.userfollow = "Y";

				if (handler) {
					var pos = handler.indexOf(")");
					if (pos != -1) {
						eval ( handler );
					} else {
						eval( handler + "()" );
					}
				}

				obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
				obj.setAttribute('title', '<?php echo $LNG->NODE_UNFOLLOW_ITEM_HINT; ?>');
				Event.stopObserving(obj, 'click');
				Event.observe(obj,'click', function (){ unfollowNode(node, this, handler) } );
   			}
   		}
  	});
}

function unfollowNode(node, obj, handler) {
	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+node.nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				node.userfollow = "N";
				if (handler) {
					var pos = handler.indexOf(")");
					if (pos != -1) {
						eval ( handler );
					} else {
						eval( handler + "()" );
					}
				}
				obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				obj.setAttribute('title', '<?php echo $LNG->NODE_FOLLOW_ITEM_HINT; ?>');
				Event.stopObserving(obj, 'click');
				Event.observe(obj,'click', function (){ followNode(node, this, handler) } );
   			}
   		}
  	});
}

/**
 * Called from user home page follow list.
 */
function unfollowMyNode(nodeid) {
	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
				try {
					window.location.reload(true);
				} catch(err) {
					//do nothing
				}
   			}
   		}
  	});
}

/**
 *	show an RSS feed of the nodes for the given arguments
 */
function getNodesFeed(nodeargs) {
	var url = SERVICE_ROOT.replace('format=json','format=rss');
	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["style"] = 'long';
	var reqUrl = url+"&method=getnodesby"+CONTEXT+"&"+Object.toQueryString(args);
	window.location.href = reqUrl;
}

/**
 *	show an RSS feed of the nodes for the given arguments
 */
function getCommentNodesFeed(nodeargs) {
	var url = SERVICE_ROOT.replace('format=json','format=rss');
	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["style"] = 'long';
	var reqUrl = url+"&method=getconnectednodesby"+CONTEXT+"&"+Object.toQueryString(args);
	window.location.href = reqUrl;
}

/**
 * Print current node list in new popup window
 */
function printNodes(nodeargs, title) {
	var url = SERVICE_ROOT;

	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["max"] = -1;
	args["style"] = 'long';

	var reqUrl = url+"&method=getnodesby"+CONTEXT+"&"+Object.toQueryString(args);
	var urlcall =  URL_ROOT+"ui/popups/printnodes.php?context="+CONTEXT+"&title="+title+"&filternodetypes="+args['filternodetypes']+"&url="+encodeURIComponent(reqUrl);

	loadDialog('printnodes', urlcall, 800, 700);
}


/**
 * Print current node list in new popup window
 */
function printCommentNodes(nodeargs, title) {
	var url = SERVICE_ROOT;

	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["max"] = -1;
	args["style"] = 'long';

	var reqUrl = url+"&method=getconnectednodesby"+CONTEXT+"&"+Object.toQueryString(args);
	var urlcall =  URL_ROOT+"ui/popups/printnodes.php?context="+CONTEXT+"&title="+title+"&filternodetypes="+args['filternodetypes']+"&url="+encodeURIComponent(reqUrl);

	loadDialog('printnodes', urlcall, 800, 700);
}

/**
 * Print current explore page in new popup window
 */
function printNodeExplore(nodeargs, title, nodeid){
	var url = SERVICE_ROOT;

	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["max"] = -1;
	args["style"] = 'long';

	var reqUrl = url+"&method=getnode&"+Object.toQueryString(args);
	var urlcall =  URL_ROOT+"ui/popups/printexplore.php?context="+CONTEXT+"&title="+encodeURIComponent(title)+"&nodeid="+nodeid+"&url="+encodeURIComponent(reqUrl);

	loadDialog('printexplore', urlcall, 800, 700);
}

// NODE CONNECTION FUNCTIONS

function connectionVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=connectionvote&vote="+obj.vote+"&connid="+obj.connid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {
					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled.png"); ?>');
					obj.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ deleteConnectionVote(this) } );

					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					$(obj.connid+'against').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
					$(obj.connid+'against').setAttribute('title', $(obj.connid+'against').oldtitle);
					Event.stopObserving($(obj.connid+'against'), 'click');
					Event.observe($(obj.connid+'against'),'click', function (){ connectionVote(this) } );
				} else if (obj.vote == 'N') {
					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled.png"); ?>');
					obj.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ deleteConnectionVote(this) } );

					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					$(obj.connid+'for').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
					$(obj.connid+'for').setAttribute('title', $(obj.connid+'for').oldtitle);
					Event.stopObserving($(obj.connid+'for'), 'click');
					Event.observe($(obj.connid+'for'),'click', function (){ connectionVote(this) } );
				}
   			}
   		}
  	});

  	if (obj.handler != undefined) {
  		obj.handler();
  	}
}

function deleteConnectionVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=deleteconnectionvote&vote="+obj.vote+"&connid="+obj.connid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {
					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
					obj.setAttribute('title', obj.oldtitle);
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ connectionVote(this) } );

					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					$(obj.connid+'against').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
					$(obj.connid+'against').setAttribute('title', $(obj.connid+'against').oldtitle);
					Event.stopObserving($(obj.connid+'against'), 'click');
					Event.observe($(obj.connid+'against'),'click', function (){ connectionVote(this) } );
				} if (obj.vote == 'N') {
					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
					obj.setAttribute('title', obj.oldtitle);
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ connectionVote(this) } );

					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					$(obj.connid+'for').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
					$(obj.connid+'for').setAttribute('title', $(obj.connid+'for').oldtitle);
					Event.stopObserving($(obj.connid+'for'), 'click');
					Event.observe($(obj.connid+'for'),'click', function (){ connectionVote(this) } );
				}
   			}
   		}
  	});

  	if (obj.handlerdelete != undefined) {
  		obj.handlerdelete();
  	}
}

/**
 * Delete the connection for the given connection id.
 */
function deleteNodeConnection(connid, childname, parentname, handler) {
	var ans = confirm("<?php echo $LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART1; ?> \n\r\n\r'"+htmlspecialchars_decode(childname)+"'\n\r\n\r <?php echo $LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART2; ?> \n\r\n\r'"+htmlspecialchars_decode(parentname)+"' <?php echo $LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART3; ?>");
	if(ans){
		var reqUrl = SERVICE_ROOT + "&method=deleteconnection&connid=" + encodeURIComponent(connid);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				if (handler) {
					if (handler instanceof Function) {
						handler();
					} else {
						var pos = handler.indexOf(")");
						if (pos != -1) {
							eval ( handler );
						} else {
							eval( handler + "()" );
						}
					}
				} else {
					try {
						window.location.reload(true);
					} catch(err) {
						//do nothing
					}
				}
    		}
  		});
	}
}

/**
 * Delete the connection for the given connection id for a chat item.
 */
function deleteChatNode(nodeid, name, handler, parentconnid) {
	var ans = confirm("<?php echo $LNG->CHAT_DELETE_CHECK_MESSAGE_PART1; ?> '"+htmlspecialchars_decode(name)+"'<?php echo $LNG->CHAT_DELETE_CHECK_MESSAGE_PART2; ?>");
	if(ans){
		var reqUrl = SERVICE_ROOT + "&method=deletecomment&nodeid=" +encodeURIComponent(nodeid)+"&parentconnid="+encodeURIComponent(parentconnid);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				if (handler) {
					var pos = handler.indexOf(")");
					if (pos != -1) {
						eval ( handler );
					} else {
						eval( handler + "()" );
					}
				} else {
					try {
						window.location.reload(true);
					} catch(err) {
						//do nothing
					}
				}
    		}
  		});
	}
}

/**
 * Find the given node in the tree and highlight if found.
 */
function selectKnowledgeTreeItem(nodetofocusid) {

	var cellsArray = document.getElementsByName('textDivCell');
	var count = cellsArray.length;
	var next = null;

	for (var i=0; i<count; i++) {
		next = cellsArray[i];
		if (next.nodeid == nodetofocusid) {
			var classes = next.className.split(" ");
			if (classes.length > 1) {
				next.oldclass = classes[1];
			} else {
				next.oldclass = next.className;
			}
			bordercolor = 'selectedborder';
			next.className = next.oldclass+" "+bordercolor;

			if ($('treedata')) {
				var pos = getPosition(next);
				var y = pos.y - 150;
				if (y < 0) {
					y = 0;
				}
				$('treedata').scrollTop = y;
			}

			return;
		}
	}
}

/**
 * Highlight all knowledge tree items.
 */
function selectAllKnowledgeTreeItems() {

	var cellsArray = document.getElementsByName('textDivCell');
	var count = cellsArray.length;
	var next = null;

	for (var i=0; i<count; i++) {
		next = cellsArray[i];
		if (next.className.indexOf('selectedborder') == -1) {
			var classes = next.className.split(" ");
			if (classes.length > 1) {
				next.oldclass = classes[1];
			} else {
				next.oldclass = next.className;
			}
			bordercolor = 'selectedborder';
			next.className = next.oldclass+" "+bordercolor;
		}
	}
}

/**
 * Set all node borders back to white
 */
function clearKnowledgeTreeSelections() {
	var cellsArray = document.getElementsByName('textDivCell');
	var count = cellsArray.length;
	var next = null;

	for (var i=0; i<count; i++) {
		next = cellsArray[i];
		if (next.className.indexOf('selectedborder') != -1) {
			next.className = 'whiteborder'+" "+next.oldclass;
		}
	}
}

/**
 * does the chat tree contain anything?
 * If not, hide the arrows.
 */
function checkChatHasNode(nodetofocusid) {

	if (CHATNODEID != "") {

		// Are all the chats closed?
		// If so we want to open the one the chat node is in.
		var uniQArray = new Array();
		var uniQArrayToOpen = new Array();

		var allClosed = true;
		var arrowsArray = document.getElementsByName('explorechatarrow');
		var nextarrow = null;
		var countarrow = arrowsArray.length;
		for (var i=0; i<countarrow; i++) {
			nextarrow = arrowsArray[i];
			var uniQ = nextarrow.uniqueid;
			uniQArray.push(uniQ);
			if ($("chat"+uniQ) && $("chat"+uniQ).style.display == 'block') {
				allClosed = false;
			}
			var countnow = parseInt($('topchattreecount'+uniQ).innerHTML);
			if (countnow == 0) {
				nextarrow.style.display = "none";
			} else {
				nextarrow.style.display = "block";
			}
		}

		//alert(allClosed);

		var cellsArray = document.getElementsByName('textChatDivCell');
		var count = cellsArray.length;
		var next = null;

		var found = false;
		var foundCell = null;

		for (var i=0; i<count; i++) {
			next = cellsArray[i];

			if (next.nodeid == CHATNODEID) {
				if (allClosed) {
					for (var j=0; j<uniQArray.length; j++) {
						var nextuniq = uniQArray[j];
						if (next.id.indexOf(nextuniq) != -1) {
							uniQArrayToOpen.push(nextuniq);
							found = true;
							foundCell = next;
							break;
						}
					}
				}
			}
		}

		//open the required chat
		if (allClosed) {
			for (var i=0; i<uniQArrayToOpen.length; i++) {
				var nextuniq = uniQArrayToOpen[i];
				if ($("chat"+nextuniq)) {
					toggleChat("chat"+nextuniq, nextuniq);
				}
			}
		}

		var pos = getPosition(foundCell);
		window.scroll(0,pos.y-100);
	} else {
		var arrowsArray = document.getElementsByName('explorechatarrow');
		var nextarrow = null;
		var countarrow = arrowsArray.length;
		for (var i=0; i<countarrow; i++) {
			nextarrow = arrowsArray[i];
			var uniQ = nextarrow.uniqueid;
			var countnow = parseInt($('topchattreecount'+uniQ).innerHTML);
			if (countnow == 0) {
				nextarrow.style.display = "none";
			} else {
				nextarrow.style.display = "block";
			}

			if (i == 0) {
				if (countarrow <= <?php echo $CFG->chatCountOpen; ?>) {
					if (countnow > 0 && countnow < <?php echo $CFG->chatChildCountOpen; ?>) {
						toggleChat("chat"+uniQ, uniQ);
					}
				}
			}
		}
	}
}

function highlightDebateAddArea() {
	//$('debateadddiv').style.border = '2px solid yellow';
	$('debateadddiv').style.background = '#F9FABC';
    var fade=setTimeout("new function(){/*$('debateadddiv').style.border = '2px solid #D3D3D3';*/$('debateadddiv').style.background = 'white';}",1500);
}

/**
 * Send a spam alert to the server.
 */
function reportNodeSpamAlert(obj, nodetype, node) {

	var name = node.name;
	var ans = confirm("<?php echo $LNG->SPAM_CONFIRM_MESSAGE_PART1; ?>\n\n"+name+"\n\n<?php echo $LNG->SPAM_CONFIRM_MESSAGE_PART2; ?>\n\n");
	if (ans){
		var reqUrl = URL_ROOT + "spamalert.php?type=idea&id="+node.nodeid;
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
		   		alert(error);
			},
			onSuccess: function(transport){
				node.status = 1;
				obj.title = '<?php echo $LNG->SPAM_REPORTED_HINT; ?>';
				if (obj.alt) {
					obj.alt = '<?php echo $LNG->SPAM_REPORTED_TEXT; ?>';
					obj.src= '<?php echo $HUB_FLM->getImagePath('spam-reported.png'); ?>';
					obj.style.cursor = 'auto';
					Event.stopObserving(obj, 'click');
				} else {
					obj.innerHTML = '<?php echo $LNG->SPAM_REPORTED_TEXT; ?>';
				}
				obj.className = "";
				fadeMessage(name+"<br><br><?php echo $LNG->SPAM_SUCCESS_MESSAGE; ?>");
			}
		});
	}
}

/**
 * Create a span menu option to report spam / show spam reported / or say login to report.
 *
 * @param node the node to report
 */
function createSpamMenuOption(node, nodetype) {

	var spaming = new Element("span", {'class':'active','style':'margin-bottom:5px;clear:both;float:left;font-size:10pt'} );

	if (node.status == <?php echo $CFG->STATUS_SPAM; ?>) {
		spaming.insert("<?php echo $LNG->SPAM_REPORTED_TEXT; ?>");
		spaming.title = '<?php echo $LNG->SPAM_REPORTED_HINT; ?>';
		spaming.className = "";
	} else if (node.status == <?php echo $CFG->STATUS_ACTIVE; ?>) {
		if (USER != "") {
			spaming.insert("<?php echo $LNG->SPAM_REPORT_TEXT; ?>");
			spaming.title = '<?php echo $LNG->SPAM_REPORT_HINT; ?>';
			Event.observe(spaming,'click',function (){ reportNodeSpamAlert(this, nodetype, node); } );
		} else {
			spaming.insert("<?php echo $LNG->SPAM_LOGIN_REPORT_TEXT; ?>");
			spaming.title = '<?php echo $LNG->SPAM_LOGIN_REPORT_TEXT; ?>';
			Event.observe(spaming,'click',function (){ $('loginsubmit').click(); return true; } );
		}
	}

	return spaming;
}

function getNodeIconElement(node) {
	var role = node.role[0].role;
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i< node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'target': '_blank' });
		var nodeicon = new Element('img',{'alt':'<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>', 'style':'width:20px;height:20px;padding-right:5px;','align':'left', 'border':'0','src': URL_ROOT + node.imagethumbnail});
		iconlink.insert(nodeicon);

		return iconlink;
	} else if (role.image != null && role.image != "") {
		var alttext = getNodeTitleAntecedence(role.name, false);
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:20px;height:20px;margin-top:3px;padding-right:5px;','align':'left','border':'0','src': URL_ROOT + role.image});
		return nodeicon;
	}
	return null;
}

/**
 * Create a menu spacer line
 */
function createMenuSpacer() {
	var spacer = new Element("hr", {'class':'hrline-slim', 'style':'margin-bottom:10px;clear:both;float:left;width:100%'} );
	return spacer;
}

/**
 * Create a menu spacer line
 */
function createMenuSpacerSoft() {
	var spacer = new Element("hr", {'class':'hrline-soft', 'style':'margin-bottom:10px;clear:both;float:left;width:100%'} );
	return spacer;
}

/**
 * Create a menu spacer line compact
 */
function createMenuSpacerSoftCompact() {
	var spacer = new Element("hr", {'class':'hrline-soft', 'style':'margin-bottom:5px;margin-top:5px;clear:both;float:left;width:100%'} );
	return spacer;
}

/**
 * If the idea trees contain the argument or comment with the given id, open comment, or argument area.
 * The id of the argument of comment to focus on.
 */
function openSelectedItem(parentid, type) {

	if (parentid === undefined) {
		parentid = "";
	}

	if (parentid != "") {
		var cellsArray = document.getElementsByName('idearowitem');
		var count = cellsArray.length;
		var next = null;

		for (var i=0; i<count; i++) {
			next = cellsArray[i];
			var nodeid = next.getAttribute('nodeid');
			var uniQ = next.getAttribute('uniQ');
			if (nodeid == parentid) {
				if (type == 'arguments') {
					$('arguments'+uniQ).style.display = "block";
					var pos = getPosition($('arguments'+uniQ));
					window.scroll(0,pos.y-100);
				} else if (type == 'comments') {
					$('comments'+uniQ).style.display = "block";
					var pos = getPosition($('comments'+uniQ));
					window.scroll(0,pos.y-100);
				}
			}
		}
	}
}

/**
 *	get all the selected node ids
 */
function getSelectedNodeIDs(){
	var retArr = new Array();
	var nodes = $("tab-content-idea-list").select('[class="nodecheck"]');
	nodes.each(function(name, index) {
		if(nodes[index].checked){
			retArr.push(nodes[index].id.replace(/nodecheck/,''));
			//retArr.push(nodes[index].nodeid);
		}
	});
	return retArr;
}

