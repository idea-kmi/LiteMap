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
 * Javascript functions for drawing a list of users
 */
function displayUsers(objDiv,users,start){

	var lOL = new Element("ol", {'class':'user-list-ol'});
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'user-blob', 'style':'float:left;margin-bottom:10px;width:100%'});
			var blobUser = renderUser(users[i].user);
			blobDiv.insert(blobUser);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing a list of groups
 */
function displayGroups(objDiv,groups,start, width, height, mainheading, cropdesc){

	var lOL = new Element("div", {'start':start, 'style':'clear:both;float:left;padding:0px;'});
	for(var i=0; i< groups.length; i++){
		if(groups[i].group){
			var blobDiv = new Element("div", {'style':'float:left;padding:10px;'});
			var blobUser = renderGroup(groups[i].group, width, height, mainheading, cropdesc);
			blobDiv.insert(blobUser);
			lOL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing a list of my groups
 */
function displayMyGroups(objDiv,groups,start, width, height){

	var lOL = new Element("div", {'start':start, 'style':'clear:both;float:left;padding:0px;'});
	for(var i=0; i< groups.length; i++){
		if(groups[i].group){
			var blobDiv = new Element("div", {'style':'float:left;padding:10px;'});
			var blobUser = renderMyGroup(groups[i].group, width, height);
			blobDiv.insert(blobUser);
			lOL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing list of users in a widget
 */
function displayWidgetUsers(objDiv,users,start){

	var lOL = new Element("ol", {'class':'user-list-ol', 'style':'margin: 0px; padding: 0px;'});
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li', 'style':'border-bottom:none;'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'user-blob'});
			var blobUser = renderWidgetUser(users[i].user);
			blobDiv.insert(blobUser);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing a list of users in a report
 */
function displayReportUsers(objDiv,users,start){
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("span", {'id':users[i].user.userid, 'class':'idea-list-li', 'style':'padding-bottom: 5px;'});
			objDiv.insert(iUL);
			var blobDiv = new Element("div", {'style':'margin: 2px; width: 650px'});
			var blobUser = renderReportUser(users[i].user);
			blobDiv.insert(blobUser);
			iUL.insert(blobDiv);
		}
	}
}


/**
 * Makes ajax call for the current user to follow a person with the userid of the given obj.
 */
function followUser(obj) {
	var reqUrl = SERVICE_ROOT + "&method=addfollowing&itemid="+obj.userid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
				obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
				obj.setAttribute('title', '<?php echo $LNG->USERS_UNFOLLOW; ?>');
				Event.stopObserving(obj, 'click');
				Event.observe(obj,'click', function (){ unfollowUser(this) } );
   			}
   		}
  	});
}

/**
 * Makes ajax call for the current user to unfollow a person with the userid of the given obj.
 */
function unfollowUser(obj) {
	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+obj.userid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
				obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				obj.setAttribute('title', '<?php echo $LNG->USERS_FOLLOW; ?>');
				Event.stopObserving(obj, 'click');
				Event.observe(obj,'click', function (){ followUser(this) } );
   			}
   		}
  	});
}


/**
 *  Makes ajax call to follow the given userid. Called from user home page follow list.
 */
function followMyUser(userid) {
	var reqUrl = SERVICE_ROOT + "&method=addfollowing&itemid="+userid;
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
 * Makes ajax call to unfollow the given userid. Called from user home page follow list.
 */
function unfollowMyUser(userid) {
	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+userid;
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
 * Send a spam alert to the server.
 */
function reportUserSpamAlert(obj, user) {
	var ans = confirm("Are you sure you want to report \n\n"+obj.label+"\n\nas a Spammer / Inappropriate?\n\n");
	if (ans){
		var reqUrl = URL_ROOT + "spamalert.php?type=user&id="+obj.id;
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
			},
			onSuccess: function(transport){
				obj.setAttribute('alt', '<?php echo $LNG->SPAM_USER_REPORTED_ALT; ?>');
				obj.setAttribute('title', '<?php echo $LNG->SPAM_USER_REPORTED; ?>');
				obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam-reported.png"); ?>');
				obj.style.cursor = 'auto';
				$(obj).unbind("click");
				user.status = 1;
			}
		});
	}
}

/**
 * Draw a single user item in a list.
 */
function renderUser(user){

	var uDiv = new Element("div",{id:'context'});

	var nodetableDiv = new Element("div", {'style':'float:left;width:100%;'});
	uDiv.insert(nodetableDiv);

	var nodeTable = new Element( 'div', {'class':'nodetable boxborder boxbackground', 'style':'float:left;padding:0px;margin:0px;'} );

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'nodetablecelltop', 'style':'padding:5px;'} );
	imageCell.style.width="20%";
	row.insert(imageCell);

	var imageDiv = new Element("div");
	imageDiv.style.cssFloat = "left";
	imageDiv.style.clear = "both";

	var imageObj = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding:5px;padding-bottom:10px;max-width:150px;max-height:100px;', 'border':'0','src': user.photo});

	var imagelink = new Element('a');
	if (user.searchid && user.searchid != "") {
		imagelink.href = URL_ROOT+"user.php?userid="+user.userid+"&sid="+user.searchid;
	} else {
		imagelink.href = URL_ROOT+"user.php?userid="+user.userid;
	}

	imagelink.insert(imageObj);
	imageDiv.insert(imagelink);
	imageCell.insert(imageDiv);
	imageCell.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>';

	var textCell = new Element( 'div', {'class':'nodetablecelltop', 'style':'padding:5px;'} );
	textCell.style.width="80%";
	row.insert(textCell);

	var textDiv = new Element('div', {'style':'margin-left:10px;margin-right:10px;'});
	textCell.insert(textDiv);

	// Add spam icon
	var spamDiv = new Element("div");
	spamDiv.style.marginTop="5px";
	spamDiv.style.cssFloat = "left";
	spamDiv.style.clear = "both";
	var spamimg = document.createElement('img');
	spamimg.style.verticalAlign="bottom";
	spamimg.style.marginLeft="5px";
	if(USER != ""){
		if (user.status == <?php echo $CFG->USER_STATUS_REPORTED; ?>) {
			spamimg.setAttribute('alt', '<?php echo $LNG->SPAM_USER_REPORTED_ALT; ?>');
			spamimg.setAttribute('title', '<?php echo $LNG->SPAM_USER_REPORTED; ?>');
			spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam-reported.png"); ?>');
		} else if (user.status == <?php echo $CFG->USER_STATUS_ACTIVE; ?>) {
			spamimg.setAttribute('alt', '<?php echo $LNG->SPAM_USER_REPORT_ALT; ?>');
			spamimg.setAttribute('title', '<?php echo $LNG->SPAM_USER_REPORT; ?>');
			spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam.png"); ?>');
			spamimg.id = user.userid;
			spamimg.label = user.name;
			spamimg.style.cursor = 'pointer';
			Event.observe(spamimg,'click',function (){ reportUserSpamAlert(this, user) } );
		}
	} else {
		spamimg.setAttribute('alt', '<?php echo $LNG->SPAM_USER_LOGIN_REPORT_ALT; ?>');
		spamimg.setAttribute('title', '<?php echo $LNG->SPAM_USER_LOGIN_REPORT; ?>');
		spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam-disabled.png"); ?>');
	}
	spamDiv.insert(spamimg);
	imageCell.insert(spamDiv);

	var uiDiv = new Element("div",{id:'contextinfo'});
	if (user.searchid && user.searchid != "") {
		uiDiv.insert("<div style='margin-bottom:5px;'><b><a href='user.php?userid="+ user.userid +"&sid="+user.searchid+"'>" + user.name + "</a></b></div>");
	} else {
		uiDiv.insert("<div style='margin-bottom:5px;'><b><a href='user.php?userid="+ user.userid +"'>" + user.name + "</a></b></div>");
	}

	if(USER != ""){
		var followDiv = new Element("div");
		followDiv.style.marginBottom="5px";
		var followbutton = document.createElement('img');
		followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
		followbutton.setAttribute('alt', '<?php echo $LNG->USERS_FOLLOW_ICON_ALT; ?>');
		followbutton.setAttribute('id','follow'+user.userid);
		followbutton.userid = user.userid;
		followbutton.style.verticalAlign="bottom";
		followbutton.style.marginRight="3px";
		followbutton.style.cursor = 'pointer';
		followDiv.insert(followbutton);
		if (user.userfollow && user.userfollow == "Y") {
			Event.observe(followbutton,'click',function (){ unfollowUser(this) } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
			followbutton.setAttribute('title', '<?php echo $LNG->USERS_UNFOLLOW; ?>');
		} else {
			Event.observe(followbutton,'click',function (){ followUser(this) } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('title', '<?php echo $LNG->USERS_FOLLOW; ?>');
		}
		uiDiv.insert(followDiv);
	}

	var str = "<div style='margin-bottom:5px;'>";
	if (user.creationdate && user.creationdate > 0) {
		var cDate = new Date(user.creationdate*1000);
		str += "<span><b><?php echo $LNG->USERS_DATE_JOINED; ?> </b>"+cDate.format(DATE_FORMAT)+"</span>";
	} else {
		var cDate = new Date(user.creationdate*1000);
		str += "<span><b><?php echo $LNG->USERS_DATE_JOINED; ?> </b>"+cDate.format(DATE_FORMAT)+"</span>";
	}
	if (user.lastactive && user.lastactive > 0) {
		var cDate = new Date(user.lastactive*1000);
		str += "<span style='margin-left:20px;'><b><?php echo $LNG->USERS_LAST_ACTIVE; ?> </b>"+cDate.format(TIME_FORMAT)+"</span>";
	} else {
		var cDate = new Date(user.lastlogin*1000);
		str += "<span style='margin-left:20px;'><b><?php echo $LNG->USERS_LAST_LOGIN; ?> </b>"+cDate.format(TIME_FORMAT)+"</span>";
	}
	uiDiv.insert(str+"</div>");

	if(user.description != ""){
		uiDiv.insert("<div style='margin-bottom:5px;'>"+user.description+"</div>");
	}
	if(user.website != ""){
        uiDiv.insert("<div style='margin-bottom:5px;'><a href='"+user.website+"' target='_blank'>"+user.website+"</a></div>");
    }

	textCell.insert(uiDiv);

	return uDiv;

}

/**
 * Draw a single group item in a list.
 */
function renderGroup(group, width, height, mainheading, cropdesc){

	var iDiv = new Element("div", {'style':'float:left;'});
	if (width == "100%") {
		iDiv.style.width = width;
		iDiv.style.maxWidth = width;
	} else {
		iDiv.style.width = width+"px";
		iDiv.style.maxWidth = width+"px";
	}
	if (height != "") {
		iDiv.style.height = height+"px";
	}

	var nodetableDiv = new Element("div", {'style':'float:left;width:100%;'});

	//if Showing stats
	//nodetableDiv.style.height = (height-30)+"px";
	//nodetableDiv.style.maxHeight = (height-30)+"px";
	nodetableDiv.style.height = height+"px";

	if (height != "") {
		nodetableDiv.style.maxHeight = height+"px";
	}

	var nodeTable = new Element( 'div', {'class':'nodetable boxborder boxbackground', 'style':'float:left;padding:0px;margin:0px;'} );
	nodeTable.style.width = width+"px";
	nodeTable.style.maxWidth = width+"px";

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'nodetablecelltop'} );
	imageCell.style.width="20%";
	row.insert(imageCell);

	var imageObj = new Element('img',{'alt':group.name, 'title': group.name, 'style':'padding:5px;padding-bottom:10px;max-width:150px;max-height:100px;', 'border':'0','src': group.photo});
	var imagelink = new Element('a', {
		'href':URL_ROOT+"group.php?groupid="+group.groupid
	});

	imagelink.insert(imageObj);
	imageCell.insert(imagelink);
	imageCell.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>';

	var textCell = new Element( 'div', {'class':'nodetablecelltop'} );
	//textCell.style.width="80%";
	row.insert(textCell);

	var textDiv = new Element('div', {'style':'margin-left:10px;margin-right:10px;'});
	textCell.insert(textDiv);

	var title = group.name;
	var description = group.description;

	if (mainheading) {
		var exploreButton = new Element('h1');
		textDiv.insert(exploreButton);
		exploreButton.insert(title);
	} else {
		var exploreButton = new Element('a', {'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>', 'style':'font-weight:bold;font-size:12pt;float:left;margin-top:5px;'});
		if (group.searchid && group.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid+"&sid="+group.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid;
		}
		exploreButton.insert(title);
		textDiv.insert(exploreButton);
		textDiv.insert("<br>");
	}
	if (description != "") {
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

	if(group.website != ""){
		var webwidth = width-30-<?php echo $CFG->IMAGE_WIDTH; ?>;
        textDiv.insert("<div style='float:left;margin-bottom:5px;width:"+webwidth+"px;'><a href='"+group.website+"' target='_blank' style='word-wrap:break-word;overflow-wrap: break-word;'>"+group.website+"</a></div>");
    }

	var rowToolbar = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(rowToolbar);

	var toolbarCell = new Element( 'div', {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarCell);

	var userDiv = new Element("div", {'class':'nodetablecellbottom'} );
	toolbarCell.insert(userDiv);

	/*if (includeUser) {
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

		var userDateDiv = new Element("div", {'class':'nodetablecellbottom'} );
		toolbarCell.insert(userDateDiv);

		var cDate = new Date(node.creationdate*1000);
		var dateDiv = new Element('div',{'title':'<?php echo $LNG->NODE_ADDED_ON; ?>','style':'float:left;padding-left:5px;margin-bottom:5px;vertical-align:bottom;'});
		dateDiv.insert(cDate.format(DATE_FORMAT));
		userDateDiv.insert(dateDiv);
	}*/

	var toolbarDivOuter = new Element("div", {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarDivOuter);

	var toolbarDiv = new Element("div", {'style':'float:right;margin-bottom:5px;'} );
	toolbarDivOuter.insert(toolbarDiv);

	// IF OWNER MANAGE GROUPS
	if (mainheading) {
		if (NODE_ARGS['isgroupadmin'] == "true") {
			toolbarDiv.insert('<span class="active" style="margin-right:10px;" onclick="loadDialog(\'editgroup\',\'<?php echo $CFG->homeAddress?>ui/popups/groupedit.php?groupid='+group.groupid+'\', 750,800);"><?php echo $LNG->GROUP_MANAGE_SINGLE_TITLE; ?></span>');

			//	var edit = new Element('img',{'style':'float:left;cursor: pointer;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_ISSUE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
			//	Event.observe(edit,'click',function (){loadDialog('editgroup',URL_ROOT+"ui/popups/groupedit.php?groupid="+group.groupid, 770,550)});
			//	toolbarDiv.insert(edit);
		}
	}

	// IF OWNER ADD EDIT / DEL ACTIONS
	/*if (type == "active") {
		if (USER == user.userid) {
			if (role.name == 'Issue') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_ISSUE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editissue',URL_ROOT+"ui/popups/issueedit.php?nodeid="+node.nodeid, 770,550)});
				toolbarDiv.insert(edit);
			} if (role.name == 'Challenge') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_CHALLENGE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editchallenge',URL_ROOT+"ui/popups/challengeedit.php?nodeid="+node.nodeid, 770,550)});
				toolbarDiv.insert(edit);
			} else if (role.name == 'Solution') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_SOLUTION;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editsolution',URL_ROOT+"ui/popups/solutionedit.php?nodeid="+node.nodeid, 770,550)});
				toolbarDiv.insert(edit);
			} else if (role.name == 'evidence') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_EVIDENCE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editevidence',URL_ROOT+"ui/popups/evidenceedit.php?nodeid="+node.nodeid, 770,550)});
				toolbarDiv.insert(edit);
			}

			if (node.otheruserconnections == 0) {
				var deletename = node.name;
				var del = new Element('img',{'style':'float:left;cursor: pointer;padding-left:5px;margin-right: 10px','alt':'<?php echo $LNG->DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>'});
				Event.observe(del,'click',function (){
					deleteNode(node.nodeid, deletename, role.name);
				});
				toolbarDiv.insert(del);
			} else {
				var del = new Element('img',{'style':'float:left;padding-left:5px;float:left;', 'alt':'<?php echo $LNG->NO_DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->NO_DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete-off.png"); ?>', 'style':'margin-right: 10px'});
				toolbarDiv.insert(del);
			}
		}
	}*/

	/*if (type == "active") {
		if (USER != "") { // IF LOGGED IN
			// Add spam icon
			var spaming = new Element('img', {'style':'float:left;padding-top:0px;padding-right:10px;'});
			if(USER != ""){
				if (user.status == <?php echo $CFG->USER_STATUS_REPORTED; ?>) {
					spamimg.setAttribute('alt', '<?php echo $LNG->SPAM_USER_REPORTED_ALT; ?>');
					spamimg.setAttribute('title', '<?php echo $LNG->SPAM_USER_REPORTED; ?>');
					spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam-reported.png"); ?>');
				} else if (user.status == <?php echo $CFG->USER_STATUS_ACTIVE; ?>) {
					spamimg.setAttribute('alt', '<?php echo $LNG->SPAM_USER_REPORT_ALT; ?>');
					spamimg.setAttribute('title', '<?php echo $LNG->SPAM_USER_REPORT; ?>');
					spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam.png"); ?>');
					spamimg.id = user.userid;
					spamimg.label = user.name;
					spamimg.style.cursor = 'pointer';
					Event.observe(spamimg,'click',function (){ reportUserSpamAlert(this, user) } );
				}
			} else {
				spamimg.setAttribute('alt', '<?php echo $LNG->SPAM_USER_LOGIN_REPORT_ALT; ?>');
				spamimg.setAttribute('title', '<?php echo $LNG->SPAM_USER_LOGIN_REPORT; ?>');
				spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam-disabled.png"); ?>');
			}
			toolbarDiv.insert(spaming);
		} else {

		}
	}*/

	/**
	if(USER != ""){
		var followDiv = new Element("div");
		followDiv.style.marginBottom="5px";
		var followbutton = document.createElement('img');
		followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
		followbutton.setAttribute('alt', '<?php echo $LNG->USERS_FOLLOW_ICON_ALT; ?>');
		followbutton.setAttribute('id','follow'+user.userid);
		followbutton.userid = user.userid;
		followbutton.style.verticalAlign="bottom";
		followbutton.style.marginRight="3px";
		followbutton.style.cursor = 'pointer';
		followDiv.insert(followbutton);
		if (user.userfollow && user.userfollow == "Y") {
			Event.observe(followbutton,'click',function (){ unfollowUser(this) } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
			followbutton.setAttribute('title', '<?php echo $LNG->USERS_UNFOLLOW; ?>');
		} else {
			Event.observe(followbutton,'click',function (){ followUser(this) } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('title', '<?php echo $LNG->USERS_FOLLOW; ?>');
		}
		uiDiv.insert(followDiv);
	}
	*/

	if (mainheading) {
		var jsonldButton = new Element("div", {'style':'float:right;padding-right:5px;', 'title':'<?php echo $LNG->GRAPH_JSONLD_HINT_GROUP;?>'});
		var jsonldButtonicon = new Element("img", {'style':'vertical-align:middle','src':"<?php echo $HUB_FLM->getImagePath('json-ld-data-24.png'); ?>", 'border':'0'});
		jsonldButton.insert(jsonldButtonicon);
		var jsonldButtonhandler = function() {
			var code = URL_ROOT+'api/conversations/'+NODE_ARGS['groupid'];
			textAreaPrompt('<?php echo $LNG->GRAPH_JSONLD_MESSAGE_GROUP; ?>', code, "", "", "");
		};
		Event.observe(jsonldButton,"click", jsonldButtonhandler);
		toolbarDiv.insert(jsonldButton);
	}

	var statstableDiv = new Element("div", {'style':'clear:both;float:left;width:100%'});
	var statsTable = new Element( 'div', {'class':'nodetable', 'style':'float:left;clear:both;height:30px;'} );
	statstableDiv.insert(statsTable);

	var innerRowStats = new Element( 'div', {'class':'nodetablerow'} );
	statsTable.insert(innerRowStats);

	var innerStatsCellPeople = new Element( 'div', {'class':'nodetablecellmid'} );
	innerRowStats.insert(innerStatsCellPeople);

	innerStatsCellPeople.insert('<span style="font-size:10pt;font-weight:bold"><?php echo $LNG->GROUP_BLOCK_STATS_PEOPLE; ?></span>'+
	'<span style="padding-left:5px;">'+group.membercount+'</span>');

	var innerStatsCellDebates = new Element( 'div', {'class':'nodetablecellmid'} );
	innerRowStats.insert(innerStatsCellDebates);

	innerStatsCellDebates.insert('<span style="font-size:10pt;font-weight:bold"><?php echo $LNG->GROUP_BLOCK_STATS_ISSUES;?></span>'+
	'<span style="padding-left:5px;">'+group.debatecount+'</span>')

	var innerStatsCellVotes = new Element( 'div', {'class':'nodetablecellmid'} );
	innerRowStats.insert(innerStatsCellVotes);

	innerStatsCellVotes.insert('<span style="font-size:10pt;font-weight:bold"><?php echo $LNG->GROUP_BLOCK_STATS_VOTES;?></span>'+
	'<span style="padding-left:5px;padding-right:15px;">'+group.votes+'</span>');

	var voteposimg = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath("thumb-up-filled3.png"); ?>', 'style':'padding-left:10px;'});
	innerStatsCellVotes.insert(voteposimg);
	var voteposspan = new Element("span", {'id':'groupstatsvotespos'+group.groupid, 'style':'padding-left:5px;'});
	voteposspan.insert(group.positivevotes);
	innerStatsCellVotes.insert(voteposspan);

	var votenegimg = new Element("img", {'src':'<?php echo $HUB_FLM->getImagePath("thumb-down-filled3.png"); ?>', 'style':'padding-left:5px;'});
	innerStatsCellVotes.insert(votenegimg);
	var votenegspan = new Element("span", {'id':'groupstatsvotesneg'+group.groupid, 'style':'padding-left:5px;'});
	votenegspan.insert(group.negativevotes);
	innerStatsCellVotes.insert(votenegspan);

	iDiv.insert(nodetableDiv);
	//iDiv.insert(statstableDiv);

	return iDiv;
}


/**
 * Draw a single group item in a list.
 */
function renderMyGroup(group, width, height){

	var iDiv = new Element("div", {'style':'float:left;'});
	iDiv.style.width = width+"px";
	iDiv.style.height = height+"px";
	iDiv.style.maxWidth = width+"px";

	var nodetableDiv = new Element("div", {'style':'float:left;width:100%;'});
	//nodetableDiv.style.height = (height-30)+"px";
	//nodetableDiv.style.maxHeight = (height-30)+"px";

	nodetableDiv.style.height = height+"px";
	nodetableDiv.style.maxHeight = height+"px";

	var nodeTable = new Element( 'div', {'class':'nodetable boxborder boxbackground', 'style':'float:left;padding:0px;margin:0px;'} );
	nodeTable.style.width = width+"px";
	nodeTable.style.maxWidth = width+"px";

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'nodetablecelltop'} );
	imageCell.style.width="20%";
	row.insert(imageCell);

	var imageObj = new Element('img',{'alt':group.name, 'title': group.name, 'style':'padding:5px;padding-bottom:10px;max-width:150px;max-height:100px;', 'border':'0','src': group.photo});
	var imagelink = new Element('a', {
		'href':URL_ROOT+"group.php?groupid="+group.groupid
	});

	imagelink.insert(imageObj);
	imageCell.insert(imagelink);
	imageCell.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>';

	var textCell = new Element( 'div', {'class':'nodetablecelltop'} );
	row.insert(textCell);

	var textDiv = new Element('div', {'style':'margin-left:10px;margin-right:10px;'});
	textCell.insert(textDiv);

	var title = group.name;
	var description = group.description;

	var exploreButton = new Element('a', {'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>', 'style':'font-weight:bold;font-size:12pt;float:left;margin-top:5px;'});
	if (group.searchid && group.searchid != "") {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid+"&sid="+group.searchid;
	} else {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid;
	}
	exploreButton.insert(title);
	textDiv.insert(exploreButton);
	textDiv.insert("<br>");

	if (description != "") {
		var hint = removeHTMLTags(description);
		var cutoff = 180;
		if (width < 400) {
			cutoff = 100;
		}
		var croplength = cutoff-title.length;
		if (description.length > croplength) {
			var description = removeHTMLTags(description);
			var final = description.substr(0,croplength)+"...";
			textDiv.insert('<p class="wordwrap" title="'+hint+'">'+final+'</p>');
		} else {
			textDiv.insert('<p class="wordwrap">'+description+'</p>');
		}
	}

	if(group.website != ""){
		var webwidth = width-30-<?php echo $CFG->IMAGE_WIDTH; ?>;
        textDiv.insert("<div style='float:left;margin-bottom:5px;width:"+webwidth+"px;'><a href='"+group.website+"' target='_blank' style='word-wrap:break-word;overflow-wrap: break-word;'>"+group.website+"</a></div>");
    }

	var rowToolbar = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(rowToolbar);

	var toolbarCell = new Element( 'div', {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarCell);

	var userDiv = new Element("div", {'class':'nodetablecellbottom'} );
	toolbarCell.insert(userDiv);

	var toolbarDivOuter = new Element("div", {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarDivOuter);

	var toolbarDiv = new Element("div", {'style':'float:right;margin-bottom:5px;'} );
	toolbarDivOuter.insert(toolbarDiv);

	// IF OWNER MANAGE GROUPS
	if (USER != "" && group.members[0].userset.users) {
		var members = group.members[0].userset.users;
		for(var i=0; i<members.length; i++) {
			var member = members[i].user;
			if (member.userid == USER && member.isAdmin) {
				toolbarDiv.insert('<span class="active" style="margin-right:10px;" onclick="loadDialog(\'editgroup\',\'<?php echo $CFG->homeAddress?>ui/popups/groupedit.php?groupid='+group.groupid+'\', 750,800);"><?php echo $LNG->GROUP_MANAGE_SINGLE_TITLE; ?></span>');
				break;
			}
		}
	}

	var jsonldButton = new Element("div", {'style':'float:right;padding-right:5px;', 'title':'<?php echo $LNG->GRAPH_JSONLD_HINT_GROUP;?>'});
	var jsonldButtonicon = new Element("img", {'style':'vertical-align:middle','src':"<?php echo $HUB_FLM->getImagePath('json-ld-data-24.png'); ?>", 'border':'0'});
	jsonldButton.insert(jsonldButtonicon);
	var jsonldButtonhandler = function() {
		var code = URL_ROOT+'api/conversations/'+group.groupid;
		textAreaPrompt('<?php echo $LNG->GRAPH_JSONLD_MESSAGE_GROUP; ?>', code, "", "", "");
	};
	Event.observe(jsonldButton,"click", jsonldButtonhandler);
	toolbarDiv.insert(jsonldButton);

	/*var statstableDiv = new Element("div", {'style':'clear:both;float:left;width:100%'});
	var statsTable = new Element( 'div', {'class':'nodetable', 'style':'float:left;clear:both;height:30px;'} );
	statstableDiv.insert(statsTable);

	var innerRowStats = new Element( 'div', {'class':'nodetablerow'} );
	statsTable.insert(innerRowStats);

	var innerStatsCellPeople = new Element( 'div', {'class':'nodetablecellmid'} );
	innerRowStats.insert(innerStatsCellPeople);

	innerStatsCellPeople.insert('<span style="font-size:10pt;font-weight:bold"><?php echo $LNG->GROUP_BLOCK_STATS_PEOPLE; ?></span>'+
	'<span style="padding-left:5px;">'+group.membercount+'</span>');

	var innerStatsCellDebates = new Element( 'div', {'class':'nodetablecellmid'} );
	innerRowStats.insert(innerStatsCellDebates);

	innerStatsCellDebates.insert('<span style="font-size:10pt;font-weight:bold"><?php echo $LNG->GROUP_BLOCK_STATS_ISSUES;?></span>'+
	'<span style="padding-left:5px;">'+group.debatecount+'</span>');

	var innerStatsCellVotes = new Element( 'div', {'class':'nodetablecellmid'} );
	innerRowStats.insert(innerStatsCellVotes);

	innerStatsCellVotes.insert('<span style="font-size:10pt;font-weight:bold"><?php echo $LNG->GROUP_BLOCK_STATS_VOTES;?></span>'+
	'<span style="padding-left:5px;padding-right:15px;">'+group.votes+'</span>');
	*/

	iDiv.insert(nodetableDiv);
	//iDiv.insert(statstableDiv);

	return iDiv;
}

/**
 * Draw a single user entry in a widget list.
 */
function renderWidgetUser(user){

	var uDiv = new Element("div",{id:'context'});
	var imgDiv = new Element("div", {'style':'clear:both;float:left'});
	var cI = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
	if(user.isgroup == 'Y'){
		cI.insert("<a href='group.php?groupid="+ user.userid +"'><img border='0' src='"+user.thumb+"'/></a>");
	} else {
		cI.insert("<a href='user.php?userid="+ user.userid +"'><img border='0' src='"+user.thumb+"'/></a>")
	}

	imgDiv.insert(cI);

	var uiDiv = new Element("div", {'style':'float:left;'});
	if(user.isgroup == 'Y'){
		uiDiv.insert("<b><a href='group.php?groupid="+ user.userid +"'>" + user.name + "</a></b>");
	} else {
		uiDiv.insert("<b><a href='user.php?userid="+ user.userid +"'>" + user.name + "</a></b>");
	}
	if (user.followdate){
		var cDate = new Date(user.followdate*1000);
		uiDiv.insert("<br><b><?php echo $LNG->USERS_STARTED_FOLLOWING_ON; ?> </b>"+ cDate.format(DATE_FORMAT));
	}

	imgDiv.insert(uiDiv);
	uDiv.insert(imgDiv);

	uDiv.insert("<div style='clear:both'></div>");
	return uDiv;
}

/**
 * Draw a single user entry in a report list.
 */
function renderReportUser(user){

	var uDiv = new Element("div",{id:'context'});
	var imgDiv = new Element("div", {'style':'clear:both;float:left'});

	var uiDiv = new Element("div", {'style':'float:left;'});
	uiDiv.insert("<div style='float:left;width:600px;'>"+user.name+"</div>");

	imgDiv.insert(uiDiv);
	uDiv.insert(imgDiv);

	uDiv.insert("<div style='clear:both'></div>");
	return uDiv;
}
