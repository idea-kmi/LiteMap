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

/**
 * Javascript functions for drawing a list of users
 */
function displayUsers(objDiv,users,start){

	var lOL = new Element("ol", {'class':'user-list-ol user-list-tab-view'});
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'user-blob'});
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
function displayGroups(objDiv,groups,start, mainheading, cropdesc){

	var lOL = new Element("div", {'start':start, 'class':'groups-div'});
	for(var i=0; i< groups.length; i++){
		if(groups[i].group){
			var blobDiv = new Element("div", {'class':'d-inline-block m-2'});
			var blobUser = renderGroup(groups[i].group, mainheading, cropdesc);
			blobDiv.insert(blobUser);
			lOL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing a list of groups
 */
function displayHomeGroups(objDiv,groups,start, width, height){
	var lOL = new Element("div", {'start':start, 'class':'home-groups'});
	for(var i=0; i< groups.length; i++){
		if(groups[i].group){
			var blobDiv = new Element("div", {'class':'d-inline-flex m-2'});
			var blobUser = renderHomeGroup(groups[i].group, width, height);
			blobDiv.insert(blobUser);
			lOL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing a list of my groups
 */
function displayMyGroups(objDiv,groups,start){
	var lOL = new Element("div", {'start':start, 'class':'groups-div'});
	for(var i=0; i< groups.length; i++){
		if(groups[i].group){
			var blobDiv = new Element("div", {'class':'d-inline-block m-2'});
			var blobUser = renderMyGroup(groups[i].group);
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
	var lOL = new Element("ol", {'class':'user-list-ol user-dashboard-view'});
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
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
			var iUL = new Element("span", {'id':users[i].user.userid, 'class':'idea-list-li'});
			objDiv.insert(iUL);
			var blobDiv = new Element("div", {'class':' '});
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

	var uDiv = new Element("div",{id:'context', "class": "row"});

	var nodetableDiv = new Element("div", {'class':' '});
	uDiv.insert(nodetableDiv);

	var nodeTable = new Element( 'div', {'class':'nodetable boxborder boxbackground'} );

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'nodetablecelltop'} );
	row.insert(imageCell);

	var imageDiv = new Element("div");

	var imageObj = new Element('img',{'alt':user.name, 'title': user.name, 'src': user.photo});

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

	var textCell = new Element( 'div', {'class':'nodetablecelltop'} );
	row.insert(textCell);

	var textDiv = new Element('div', {'class':''});
	textCell.insert(textDiv);

	// Add spam icon
	var spamDiv = new Element("div");
	var spamimg = document.createElement('img');
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

	var uiDiv = new Element("div",{id:'contextinfo', "class":"col contextinfo"});
	
	if (user.searchid && user.searchid != "") {
		uiDiv.insert("<b><a href='user.php?userid="+ user.userid +"&sid="+user.searchid+"'>" + user.name + "</a></b>");
	} else {
		uiDiv.insert("<b><a href='user.php?userid="+ user.userid +"'>" + user.name + "</a></b>");
	}

	if(USER != ""){
		var followDiv = new Element("div");
		var followbutton = document.createElement('img');
		followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
		followbutton.setAttribute('alt', '<?php echo $LNG->USERS_FOLLOW_ICON_ALT; ?>');
		followbutton.setAttribute('id','follow'+user.userid);
		followbutton.userid = user.userid;
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

	var str = "<div>";
	if (user.creationdate && user.creationdate > 0) {
		var cDate = new Date(user.creationdate*1000);
		str += "<span class=\"user-date-joined\"><b><?php echo $LNG->USERS_DATE_JOINED; ?> </b>"+cDate.format(DATE_FORMAT)+"</span>";
	} else {
		var cDate = new Date(user.creationdate*1000);
		str += "<span class=\"user-date-joined\"><b><?php echo $LNG->USERS_DATE_JOINED; ?> </b>"+cDate.format(DATE_FORMAT)+"</span>";
	}
	if (user.lastactive && user.lastactive > 0) {
		var cDate = new Date(user.lastactive*1000);
		str += "<span class=\"user-last-active\"><b><?php echo $LNG->USERS_LAST_ACTIVE; ?> </b>"+cDate.format(TIME_FORMAT)+"</span>";
	} else {
		var cDate = new Date(user.lastlogin*1000);
		str += "<span class=\"user-last-login\"><b><?php echo $LNG->USERS_LAST_LOGIN; ?> </b>"+cDate.format(TIME_FORMAT)+"</span>";
	}
	uiDiv.insert(str+"</div>");

	if(user.description != ""){
		uiDiv.insert("<div>"+user.description+"</div>");
	}
	if(user.website != ""){
        uiDiv.insert("<div><a href='"+user.website+"' target='_blank'>"+user.website+"</a></div>");
    }

	textCell.insert(uiDiv);
	return uDiv;

}

/**
 * Draw a single group item in a list.
 */
function renderGroup(group, width, height, mainheading, cropdesc){

	var iDiv = new Element("div", {'class':'card border-0 my-2'});

	var nodetableDiv = new Element("div", {'class':'card-body pb-1'});
	var nodeTable = new Element( 'div', {'class':'nodetableGroup border border-2'} );

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'d-flex flex-row'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'p-2'} );
	row.insert(imageCell);
	
	var imageObj = new Element('img',{'alt':group.name, 'title': group.name, 'src': group.photo});
	var imagelink = new Element('a', {'href':URL_ROOT+"group.php?groupid="+group.groupid });

	imagelink.insert(imageObj);
	imageCell.insert(imagelink);

	var textCell = new Element( 'div', {'class':'p-2'} );
	row.insert(textCell);

	var title = group.name;
	var description = group.description;

	if (mainheading) {
		var exploreButton = new Element('h1');
		textCell.insert(exploreButton);
		exploreButton.insert(title);
	} else {
		var exploreButton = new Element('a', {'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>', 'class':''});
		if (group.searchid && group.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid+"&sid="+group.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid;
		}
		exploreButton.insert(title);
		textCell.insert(exploreButton);
	}

	if (description != "") {
		if (mainheading) {
			var textDivinner = new Element('div', {'class':' '});
			textDivinner.insert(description);
			textCell.insert(textDivinner);
		} else {
			if (description != "" && title.length <=80) {
				var plaindesc = removeHTMLTags(description);
				var hint = plaindesc;
				var croplength = 110-title.length;
				if (plaindesc && plaindesc.length > croplength) {
					hint = plaindesc;
					var plaincrop = plaindesc.substr(0,croplength)+"...";
					textCell.insert('<p title="'+hint+'">'+plaincrop+'</p>');
				} else {
					textCell.insert('<p>'+plaindesc+'</p>');
				}
			}
		}			
	}

	if(mainheading && group.website != ""){
		textCell.insert("<div style='float:left;margin-bottom:5px;'><a href='"+group.website+"' target='_blank' style='word-wrap:break-word;overflow-wrap: break-word;'>"+group.website+"</a></div>");
    }

	var rowToolbar = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(rowToolbar);

	var toolbarCell = new Element( 'div', {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarCell);

	var userDiv = new Element("div", {'class':'nodetablecellbottom'} );
	toolbarCell.insert(userDiv);

	var toolbarDivOuter = new Element("div", {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarDivOuter);

	var toolbarDiv = new Element("div", {'class':'d-flex justify-content-end'} );
	toolbarDivOuter.insert(toolbarDiv);

	// IF OWNER MANAGE GROUPS
	if (mainheading) {
		if (NODE_ARGS['isgroupadmin'] == "true") {
			toolbarDiv.insert('<span class="active p-2 editgroup-link" onclick="loadDialog(\'editgroup\',\'<?php echo $CFG->homeAddress?>ui/popups/groupedit.php?groupid='+group.groupid+'\', 750,800);"><?php echo $LNG->GROUP_MANAGE_SINGLE_TITLE; ?></span>');
		}
	}

	if (mainheading) {
		var jsonldButton = new Element("div", {'class':'p-2', 'title':'<?php echo $LNG->GRAPH_JSONLD_HINT_GROUP;?>'});
		var jsonldButtonicon = new Element("img", {'src':"<?php echo $HUB_FLM->getImagePath('json-ld-data-24.png'); ?>", 'alt':'API call'});
		jsonldButton.insert(jsonldButtonicon);
		var jsonldButtonhandler = function() {
			var code = URL_ROOT+'api/conversations/'+NODE_ARGS['groupid'];
			textAreaPrompt('<?php echo $LNG->GRAPH_JSONLD_MESSAGE_GROUP; ?>', code, "", "", "");
		};
		Event.observe(jsonldButton,"click", jsonldButtonhandler);
		toolbarDiv.insert(jsonldButton);
	}

	var statstableDiv = new Element("div", {'class':'card-footer border-0 bg-white py-0 text-center'});
	var statsTable = new Element( 'div', {'class':'nodetable'} );
	statstableDiv.insert(statsTable);

	var innerRowStats = new Element( 'div', {'class':'row'} );
	statsTable.insert(innerRowStats);

	var innerStatsCellPeople = new Element( 'div', {'class':'col-auto'} );
	innerRowStats.insert(innerStatsCellPeople);

	innerStatsCellPeople.insert('<p><strong><?php echo $LNG->GROUP_BLOCK_STATS_PEOPLE; ?></strong>'+'<span> '+group.membercount+'</span></p>');

	var innerStatsCellDebates = new Element( 'div', {'class':'col-auto'} );
	innerRowStats.insert(innerStatsCellDebates);

	innerStatsCellDebates.insert('<p><strong><?php echo $LNG->GROUP_BLOCK_STATS_ISSUES;?></strong>'+'<span> '+group.debatecount+'</span></p>')

	var innerStatsCellVotes = new Element( 'div', {'class':'col-auto'} );
	innerRowStats.insert(innerStatsCellVotes);

	innerStatsCellVotes.insert('<p><strong><?php echo $LNG->GROUP_BLOCK_STATS_VOTES;?></strong>'+'<span> '+group.votes+'</span></p>');

	iDiv.insert(nodetableDiv);
	iDiv.insert(statstableDiv);

	return iDiv;
}

/**
 * Draw a single group item in a list.
 */
function renderHomeGroup(group, width, height){
	var iDiv = new Element("div", {'class':'card border-0 my-2 group-card'});

	var nodetableDiv = new Element("div", {'class':'card-body p-1'});
	var nodeTable = new Element( 'div', {'class':'nodetableGroup border border-2'} );

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'d-flex flex-row'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'p-2'} );
	row.insert(imageCell);

	var imageObj = new Element('img',{'alt':group.name, 'title': group.name, 'src': group.photo});
	var imagelink = new Element('a', {'href':URL_ROOT+"group.php?groupid="+group.groupid });

	imagelink.insert(imageObj);
	imageCell.insert(imagelink);

	var textCell = new Element( 'div', {'class':'p-2'} );
	row.insert(textCell);

	var textDiv = new Element('div', {'class':' '});
	textCell.insert(textDiv);

	var title = group.name;
	var description = group.description;

	var exploreButton = new Element('a', {'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>' });
	if (group.searchid && group.searchid != "") {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid+"&sid="+group.searchid;
	} else {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid;
	}
	exploreButton.insert(title);
	textDiv.insert(exploreButton);

	var statstableDiv = new Element("div", {'class':'card-footer border-0 bg-white py-0 text-center'});
	var statsTable = new Element( 'div', {'class':'nodetable'} );
	statstableDiv.insert(statsTable);

	var innerRowStats = new Element( 'div', {'class':'row'} );
	statsTable.insert(innerRowStats);

	var innerStatsCellPeople = new Element( 'div', {'class':'col-auto'} );
	innerRowStats.insert(innerStatsCellPeople);

	innerStatsCellPeople.insert('<p class="mb-0"><strong><?php echo $LNG->GROUP_BLOCK_STATS_PEOPLE; ?></strong>'+
	'<span> '+group.membercount+'</span></p>');

	var innerStatsCellDebates = new Element( 'div', {'class':'col-auto'} );
	innerRowStats.insert(innerStatsCellDebates);

	innerStatsCellDebates.insert('<p class="mb-0"><strong><?php echo $LNG->GROUP_BLOCK_STATS_ISSUES;?></strong>'+
	'<span> '+group.debatecount+'</span></p>')

	var innerStatsCellVotes = new Element( 'div', {'class':'col-auto'} );
	innerRowStats.insert(innerStatsCellVotes);

	innerStatsCellVotes.insert('<p class="mb-0"><strong><?php echo $LNG->GROUP_BLOCK_STATS_VOTES;?></strong>'+
	'<span> '+group.votes+'</span></p>');

	iDiv.insert(nodetableDiv);
	iDiv.insert(statstableDiv);

	return iDiv;
}

/**
 * Draw a single group item in a list.
 */
function renderMyGroup(group){

	var iDiv = new Element("div", {'class':'card border-0 my-2'});

	var nodetableDiv = new Element("div", {'class':'card-body pb-1'});
	var nodeTable = new Element( 'div', {'class':'nodetableGroup border border-2'} );

	nodetableDiv.insert(nodeTable);

	var row = new Element( 'div', {'class':'d-flex flex-row'} );
	nodeTable.insert(row);

	var imageCell = new Element( 'div', {'class':'p-2'} );
	row.insert(imageCell);

	var imageObj = new Element('img',{'alt':group.name, 'title': group.name,'src': group.photo});
	var imagelink = new Element('a', {
		'href':URL_ROOT+"group.php?groupid="+group.groupid
	});

	imagelink.insert(imageObj);
	imageCell.insert(imagelink);
	imageCell.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>';

	var textCell = new Element( 'div', {'class':'nodetablecelltop'} );
	row.insert(textCell);

	var textDiv = new Element('div', {'class':'m-1'});
	textCell.insert(textDiv);

	var title = group.name;
	var description = group.description;

	var exploreButton = new Element('a', {'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>', 'class':'active'});
	if (group.searchid && group.searchid != "") {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid+"&sid="+group.searchid;
	} else {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>group.php?groupid="+group.groupid;
	}
	exploreButton.insert(title);
	textDiv.insert(exploreButton);
	textDiv.insert("<br />");

	if (description != "") {
		var plaindesc = removeHTMLTags(description);
		var hint = description;
		if (plaindesc.length > 90) {
			hint = plaindesc;
			plaindesc = plaindesc.substr(0,90)+"...";
			textDiv.insert('<p title="'+hint+'">'+plaindesc+'</p>');
		} else {
			textDiv.insert('<p>'+plaindesc+'</p>');
		}
	}

	var rowToolbar = new Element( 'div', {'class':'nodetablerow'} );
	nodeTable.insert(rowToolbar);

	var toolbarCell = new Element( 'div', {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarCell);

	var userDiv = new Element("div", {'class':'nodetablecellbottom'} );
	toolbarCell.insert(userDiv);

	var toolbarDivOuter = new Element("div", {'class':'nodetablecellbottom'} );
	rowToolbar.insert(toolbarDivOuter);

	var toolbarDiv = new Element("div", {'class':'text-end m-2'} );
	toolbarDivOuter.insert(toolbarDiv);

	// IF OWNER MANAGE GROUPS
	if (USER != "" && group.members[0].userset.users) {
		var members = group.members[0].userset.users;
		for(var i=0; i<members.length; i++) {
			var member = members[i].user;
			if (member.userid == USER && member.isAdmin) {
				toolbarDiv.insert('<span class="active p-2 editgroup-link" onclick="loadDialog(\'editgroup\',\'<?php echo $CFG->homeAddress?>ui/popups/groupedit.php?groupid='+group.groupid+'\', 900,800);"><?php echo $LNG->GROUP_MANAGE_SINGLE_TITLE; ?></span>');
				break;
			}
		}
	}

	var jsonldButton = new Element("div", {'style':'float:right;padding-right:5px;', 'title':'<?php echo $LNG->GRAPH_JSONLD_HINT_GROUP;?>'});
	var jsonldButtonicon = new Element("img", {'style':'vertical-align:middle','src':"<?php echo $HUB_FLM->getImagePath('json-ld-data-24.png'); ?>", 'alt':'json LD Data'});
	jsonldButton.insert(jsonldButtonicon);
	var jsonldButtonhandler = function() {
		var code = URL_ROOT+'api/conversations/'+group.groupid;
		textAreaPrompt('<?php echo $LNG->GRAPH_JSONLD_MESSAGE_GROUP; ?>', code, "", "", "");
	};
	Event.observe(jsonldButton,"click", jsonldButtonhandler);
	toolbarDiv.insert(jsonldButton);

	iDiv.insert(nodetableDiv);

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
