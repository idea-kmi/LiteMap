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
 * Refresh widget maps sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreMaps(nodetofocusid) {
	refreshWidgetMaps(nodetofocusid);
}

/**
 * Refresh linear and widget Followers sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreFollowers() {
	refreshWidgetFollowers();
}

function getIsOpen(div, isopen, nodetofocusid) {

	if (nodetofocusid === undefined) {
		nodetofocusid = "";
	}

	if (isopen) {
		if (div && div.style.display == "none") {
			isopen = false;
		}
	} else {
		if (div && div.style.display == "block"
				|| nodetofocusid !="") {
			isopen = true;
		}
	}
	return isopen;
}

function buildWidgetExploreNodeHeader(node, container, label, color, type, icon, height, key) {

	var widgetHeader = new Element("div", { 'class':'widgetheadernode d-flex justify-content-between px-3 py-1 mx-0 '+color, 'id':'widgetnodeheader'});

	if ($('widgettable')) {
		var widgetHeaderControlButton = new Element('img',{ 'style':'cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});
		Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});
	}

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinnernode col', 'id':key+'headerinner', 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});

	var widgetHeaderLabel = new Element("label", {'class':'widgetnodeheaderlabel col-auto', 'id':'widgetheaderlabel'});
	widgetInnerHeader.insert(widgetHeaderLabel);

	if ($('widgettable')) {
		Event.observe(widgetInnerHeader,'click',function (){ toggleExpandWidget(widgetHeaderControlButton, key, height)});
	}

	if (icon) {
		var iconObj = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; height:24px;', 'alt':type+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		iconObj.align='left';
		widgetHeaderLabel.appendChild(iconObj);
	}

	widgetHeaderLabel.insert(label);
	widgetHeader.insert(widgetInnerHeader);

	if (node.private == "Y") {
		var padlockicon = new Element("img", {'style':'float:left;text-align: middle;width:22px; height:22px;padding-left:10px;'});
		padlockicon.align='left';
		padlockicon.src = '<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>';
		widgetHeaderLabel.insert(padlockicon);
	}

	var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol '+color});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton);

	widgetHeader.insert(widgetInnerHeaderControl);

	container.insert(widgetHeader);
}

/**
 * Build the widget header area
 * @param title the title to put in the header bar
 * @param height the height if this widget
 * @param isOpen true if the widget should be draw opne, false if closed.
 * @param color the class name od the class whihc states the backgroun color for the header bar.
 * @param key the unique text string that identifies this widget from the others on the page.
 * @param withAdjust add the open and big up buttons or not.
 */
function buildWidgetHeader(title, height, isOpen, color, key, icon, withAdjust) {

	if (withAdjust === undefined) {
		withAdjust = true;
	}

	var widgetHeader = new Element("div", {'class':'row m-0 p-0 widgetheader '+color, 'id':key+"header"});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinner col', 'id':key+"headerinner", 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});
	var widgetHeaderLabel = new Element("label", {'class':'widgetheaderlabel widgettextcolor ', 'id':key+"headerlabel"});

	if (icon) {
		var icon = new Element('img',{'class':'widgetTitleIcon', 'alt':title+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		icon.align='left';
		widgetInnerHeader.appendChild(icon);
	}

	widgetHeaderLabel.insert(title+"<span class='widgetcountlabel'>(0)</span>");

	widgetInnerHeader.insert(widgetHeaderLabel);
	widgetHeader.insert(widgetInnerHeader);

	if (withAdjust) {		
		var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol col-auto'});
		if ($('widgettable')){
			var widgetHeaderControlButton = new Element('img',{ 'style':'cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});
			Event.observe(widgetHeaderLabel,'mouseover',function (){widgetHeaderLabel.style.cursor = 'pointer'});
			Event.observe(widgetHeaderLabel,'mouseout',function (){widgetHeaderLabel.style.cursor = 'normal'});

			Event.observe(widgetInnerHeader,'mouseover',function (){widgetInnerHeader.style.cursor = 'pointer'});
			Event.observe(widgetInnerHeader,'mouseout',function (){widgetInnerHeader.style.cursor = 'normal'});
			Event.observe(widgetInnerHeader,'click',function (){toggleExpandWidget(widgetHeaderControlButton, key, height)});
			Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});	
			widgetInnerHeaderControl.insert(widgetHeaderControlButton);
		}

		var widgetHeaderControlButton2 = new Element('img',{ 'style':'cursor: pointer;display: inline', 'alt':'<?php echo $LNG->WIDGET_OPEN_CLOSE_ALT; ?>', 'id':key+'buttonarrow', 'title': '<?php echo $LNG->WIDGET_OPEN_CLOSE_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>'});
		Event.observe(widgetHeaderControlButton2,'click',function (){toggleWidget(this, key, height)});
		widgetInnerHeaderControl.insert(widgetHeaderControlButton2);

		widgetHeader.insert(widgetInnerHeaderControl);

		if (isOpen) {
			widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
		} else {
			widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
		}
	}

	return widgetHeader;
}

function adjustForExpand(button, key, mainheight) {
	if (button) {
		button.src = '<?php echo $HUB_FLM->getImagePath("reduce.gif"); ?>';
	}

	if ($(key+"headerinner")) {
		$(key+"headerinner").title = '<?php echo $LNG->WIDGET_CONTRACT_HINT; ?>';
	} else if ($(key+"toolbar")) {
		$(key+"toolbar").title = '<?php echo $LNG->WIDGET_CONTRACT_HINT; ?>';
	}

	if ($(key+"buttonarrow") != null) {
		if ($(key+"body").style.display == 'none') {
			$(key+"buttonarrow").isClosed = 'true';
		} else {
			$(key+"buttonarrow").isClosed = 'false';
		}
		$(key+"buttonarrow").style.display = 'none';
	}

	var height = mainheight;

	if (key == nodekey) {
		height = 700;
	} else {
		if ($('widgetcolleft') && $('widgetcolright')) {
			var lheight = $('widgetcolleft').offsetHeight;
			var rheight = $('widgetcolright').offsetHeight;
			var height = lheight;
			if (lheight < rheight) {
				height = rheight;
			}
		} else if ($('widgetcolleft')) {
			var height = $('widgetcolleft').offsetHeight;
		} else if ($('widgetcolright')) {
			var height = $('widgetcolright').offsetHeight;
		}
	}

	$(key+"body").style.display = "block";
	$(key+"body").style.height = (height-$(key+"header").offsetHeight-15)+"px";
	if ($(key+"innerbody")) {
		$(key+"innerbody").style.height = (height-$(key+"header").offsetHeight-15)+"px";
	}
	$(key+"div").style.height = height+"px";
}

function adjustForContract(button, key, mainheight) {
	button.src = '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>';

	if ($(key+"headerinner")) {
		$(key+"headerinner").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	} else if ($(key+"toolbar")) {
		$(key+"toolbar").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	}

	if ($(key+"buttonarrow")) {
		$(key+"buttonarrow").style.display = 'inline';
	}

	$(key+"body").style.height = (mainheight-$(key+"header").offsetHeight-10)+"px";
	if ($(key+"innerbody")) {
		$(key+"innerbody").style.height = (mainheight-$(key+"header").offsetHeight-10)+"px";
	}
	$(key+"div").style.height = mainheight+"px";

	// ADJUST IF WIDGET WAS CLOSED BEFORE EXPANDING
	if ($(key+"buttonarrow") && $(key+"buttonarrow").isClosed == 'true') {
		$(key+"body").style.display = "none";
		$(key+"buttonarrow").src = '<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
		var header = $(key+"header").offsetHeight;
		var headerinner = $(key+"headerinner").offsetHeight;
		if (header > headerinner) {
			$(key+"div").style.height = header+"px";
		} else {
			$(key+"div").style.height = headerinner+"px";
		}
	} else {
		$(key+"body").style.display = "block";
	}
}

function adjustForContractNode(button, key, mainheight) {
	button.src = '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>';

	if ($(key+"headerinner")) {
		$(key+"headerinner").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	} else if ($(key+"toolbar")) {
		$(key+"toolbar").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	}

	$(key+"body").style.display = "block";

	var headerheight = $(key+'header').offsetHeight;
	$(key+'div').style.height = mainheight-6 +"px";
	$(key+'innerbody').style.height = mainheight-headerheight-27 +"px"; //54
	$(key+'body').style.height = mainheight-headerheight-46 +"px";
}

/**
 * Expand/contract widgets
 */
function toggleExpandWidget(button, key, mainheight) {
	if (key == nodekey) {
		if ($('widgettable').style.display == 'flex') {
			$('widgetareadiv').insert($('nodearea'));
			adjustForExpand(button, key, mainheight);
			$('widgettable').style.display='none';
			if ($('widgetextrastable')) {
				$('widgetextrastable').style.display='none';
			}
		} else {
			$('widgettable').style.display='flex';
			if ($('widgetextrastable')) {
				$('widgetextrastable').style.display='flex';
			}
			$('widgetcolnode').insert({'top':$('nodearea')});
			adjustForContractNode(button, key, mainheight);
			resizeNodeWidget(key, mainheight);
		}
	} else {
		var currentArray = "";
		if (typeof leftColumn !== 'undefined' && leftColumn.hasOwnProperty(key)) {
			currentArray = leftColumn;
		} else if (typeof rightColumn !== 'undefined' && rightColumn.hasOwnProperty(key)) {
			currentArray = rightColumn;
		} else if (typeof extraColumn !== 'undefined' && extraColumn.hasOwnProperty(key)) {
			currentArray = extraColumn;
		} else if (typeof recommendColumn !== 'undefined' && recommendColumn.hasOwnProperty(key)) {
			currentArray = recommendColumn;
		} else if (typeof relatedColumn !== 'undefined' && relatedColumn.hasOwnProperty(key)) {
			currentArray = relatedColumn;
		}

		if (currentArray != "") {
			if ($(key+"buttonarrow").style.display == 'inline') {
				for (var nextkey in currentArray) {
					if (nextkey == key) {
						$(currentArray[nextkey]).className = 'tabletop';
						$(currentArray[nextkey]).style.display = 'flex';
					} else {
						$(currentArray[nextkey]).style.display = 'none';
					}
				}
				adjustForExpand(button, key, mainheight);
			} else {
				var i = 0;
				for (var nextkey in currentArray) {
					if (i == 0) {
						$(currentArray[nextkey]).className = 'tabletop';
					} else {
						$(currentArray[nextkey]).className = 'tablelower';
					}
					$(currentArray[nextkey]).style.display = 'flex';
					i++;
				}
				adjustForContract(button, key, mainheight);
			}
		}
	}
}

function resizeNodeWidget(key, height) {
	var headerheight = $(key+'header').offsetHeight;
	$(key+'div').style.height = height-6 +"px";
	$(key+'innerbody').style.height = height-headerheight-27 +"px"; //54
	$(key+'body').style.height = height-headerheight-46 +"px";
}

function resizeKeyWidget(key) {
	var header = 0;
	if ($(key+"header")) {
		header = $(key+"header").offsetHeight;
	}

	var headerinner = 0;
	if ($(key+"headerinner")) {
		headerinner = $(key+"headerinner").offsetHeight;
	}

	var headerlabel = 0;
	if ($(key+"headerlabel")) {
		headerlabel = $(key+"headerlabel").offsetHeight;
	}

	if (headerinner > header) {
		$(key+"header").style.height = headerinner+"px";
	}
	if (headerlabel > headerinner) {
		$(key+"header").style.height = headerlabel+"px";
	}
	if ($(key+"body") && $(key+"body").style.display == "none") {
		if (header > headerinner) {
			$(key+"div").style.height = header+"px";
		} else if (headerlabel > header) {
			$(key+"div").style.height = headerlabel+"px";
		} else {
			$(key+"div").style.height = headerinner+"px";
		}
	} else {
		if ($(key+"div")) {
			var divheight = $(key+"div").offsetHeight;
			if (header > headerinner) {
				$(key+"body").style.height = (divheight-header-12)+"px";
			} else {
				$(key+"body").style.height = (divheight-headerinner-14)+"px";
			}
		}
	}
}

function toggleWidget(button, key, mainheight) {
	if ( $(key+"body").style.display == "flex") {
		$(key+"body").style.display = "none";
		button.isClosed = 'true';
		button.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
		var header = $(key+"header").offsetHeight;
		var headerinner = $(key+"headerinner").offsetHeight;
		if (header > headerinner) {
			$(key+"div").style.height = header+"px";
		} else {
			$(key+"div").style.height = headerinner+"px";
		}
	} else {
		$(key+"body").style.display = "flex";
		button.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
		button.isClosed = 'false';
		$(key+"div").style.height = mainheight+"px";

		var header = $(key+"header").offsetHeight;
		var headerinner = $(key+"headerinner").offsetHeight;
		if (header > headerinner) {
			$(key+"body").style.height = (mainheight-header-12)+"px";
		} else {
			$(key+"body").style.height = (mainheight-headerinner-12)+"px";
		}
	}
}

function buildNodeWidgetNew(node, height, type, key, color) {

	// JSON structure different if json_encode used.
	var user = null;
	if (node.users[0] && node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}
	var role = null;

	if (node.role.roleid) {
		role = node.role;
	} else {
		role = node.role[0].role;
	}

	var nodeid = node.nodeid;
	var name = node.name;
	var creationdate = node.creationdate;
	var positivevotes = node.positivevotes;
	var negativevotes = node.negativevotes;
	var otheruserconnections = node.otheruserconnections;
	var userfollow = node.userfollow;
	var nodetype = role.name;
	var title=getNodeTitleAntecedence(nodetype);
	var userimage = user.thumb;
	var username = user.name;
	var userid = user.userid;

	var icon = URL_ROOT+role.image;

	var widgetDiv = new Element("div", {'class':'widgetdivnode', 'id':key+'div'});
	widgetDiv.style.height = "0px";
	var widgetBody = new Element("div", {'class':'widgetnodebody', 'id':key+'body'});
	widgetBody.style.height = "0px";
	var widgetHeader = new Element("div", {'id':key+'header', 'class':'widgetheadernode'});
	widgetDiv.insert(widgetHeader);

	buildWidgetExploreNodeHeader(node, widgetHeader, title+name, color, type, icon, height, key);

	var toolbar = new Element("div", {'class':'nodewidgettoolbar d-flex gap-4 align-items-center px-1 py-2'});
	buildExploreToolbar(toolbar, title+name, type, node, 'explore');

	widgetHeader.insert(toolbar);

	var spacer = new Element("hr", {'class':'widgetnodespacer'});
	widgetBody.appendChild(spacer);

	var innerwidgetBody = new Element("div", {'id':key+'innerbody', 'class':'widgetnodeinnerbody'});
	innerwidgetBody.style.height = "0px";

	var userbar = new Element("div", {'style':'clear:both;margin-bottom:5px;'} );
	var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
	var userimageThumb = new Element('img',{'alt':username, 'title': username, 'style':'padding-right:5px;', 'src': userimage});

	var imagelink = new Element('a', {'href':URL_ROOT+"user.php?userid="+userid, 'title':username});

	imagelink.insert(userimageThumb);
	iuDiv.update(imagelink);
	userbar.appendChild(iuDiv);

	var iuDiv = new Element("div", {'style':''});
	var cDate = new Date(creationdate*1000);
	iuDiv.insert("<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>");
	iuDiv.insert('<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>'+username+'<br/>');
	userbar.insert(iuDiv);

	innerwidgetBody.appendChild(userbar);

	if (node.image) {
		var imagearea = new Element("img", {'style':'clear:both;padding-top:5px;padding-bottom:5px;', 'border':'0'});
		imagearea.src = node.image;
		Event.observe(imagearea,'click',function () {
			loadDialog('bigimage',node.image, 800,600);
		});

		innerwidgetBody.insert(imagearea);
	}

 	// add url
	if (node.urls && node.urls.length > 0) {
		var hasClips = false;
		var iUL = new Element("ul", {'style':'clear:both;margin-top:0px;'});

		for (var i=0 ; i< node.urls.length; i++){
			var url = node.urls[i];
			// JSON structure different if json_encode used.
			if (!url.urlid) {
				url = url.url;
			}
			innerwidgetBody.insert('<br /><span style="margin-right:5px;"><b><?php echo $LNG->NODE_URL_HEADING; ?> </b></span>');
			var link = new Element("a", {'href':url.url, 'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
			link.insert(url.title);
			link.insert('<br />');
			innerwidgetBody.insert(link);
			if (url.clip && url.clip != "") {
				var link = new Element("li");
				link.insert(url.clip);
				iUL.insert(link);
				hasClips = true;
			}
		}

		if (hasClips) {
			innerwidgetBody.insert('<span style="margin-right:5px;"><b><?php echo $LNG->NODE_RESOURCE_CLIP_HEADING; ?> </b></span><br>');
		}

		innerwidgetBody.insert(iUL);
	}

	if (node.description && node.description != "" && type != 'web') {
		var dStr = '<div style="clear:both;margin:0px;padding:0px;" class="idea-desc"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
		dStr += node.description;
		dStr += '</div>';
		innerwidgetBody.insert(dStr);
	}

	widgetBody.insert(innerwidgetBody);
	widgetDiv.insert(widgetBody);

	return widgetDiv;
}

function buildNodeWidgetForNews(node, height, type, key, color) {
	var creationdate = node.creationdate;
	var userimage = node.users[0].thumb;
	var nodeid = node.nodeid;
	var name = node.name;
	var nodetype = node.role.name;
	var title=getNodeTitleAntecedence(nodetype);

	var username = node.users[0].name;
	var userid = node.users[0].userid;
	var userfollow = node.userfollow;
	var otheruserconnections = node.otheruserconnections;
	var icon = URL_ROOT+node.role.image;

	var widgetDiv = new Element("div", {'class':'widgetdivnode', 'id':key+'div'});
	widgetDiv.style.height = "0px";
	var widgetBody = new Element("div", {'class':'widgetnodebody', 'id':key+'body'});
	widgetBody.style.height = "0px";
	var widgetHeader = new Element("div", {'id':key+'header', 'class':'widgetheadernode'});
	widgetDiv.insert(widgetHeader);

	buildWidgetExploreNodeHeader(node, widgetHeader, title+name, color, type, icon, height, key);

	var innerwidgetBody = new Element("div", {'id':key+'innerbody', 'class':'widgetnodeinnerbody'});
	innerwidgetBody.style.height = "0px";

	var userbar = new Element("div", {'style':'clear:both;margin-bottom:5px;'} );
	var iuDiv = new Element("div", {'style':''});
	var cDate = new Date(creationdate*1000);
	iuDiv.insert("<b><?php echo $LNG->WIDGET_NEWS_POSTED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>");
	userbar.insert(iuDiv);

	innerwidgetBody.appendChild(userbar);

	if (node.description && node.description != "" && type != 'web') {
		var dStr = '<div style="margin:0px;padding:0px;" class="idea-desc">';
		dStr += node.description;
		dStr += '</div>';
		innerwidgetBody.insert(dStr);
	}

	widgetBody.insert(innerwidgetBody);
	widgetDiv.insert(widgetBody);

	return widgetDiv;
}

function addFocalNodeToMap(mapnode, focalnodeid) {
	var mapid = mapnode.nodeid;
	if (mapid && mapid != "") {
		var reqUrl = SERVICE_ROOT+"&method=addnodetoview";
		reqUrl += "&viewid="+mapid+"&nodeid="+NODE_ARGS['nodeid']+"&xpos=0&ypos=0";
		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){
				try {
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}

					refreshWidgetMaps(mapid);

					//go to map and select current node
					window.location.href = URL_ROOT+"map.php?id="+mapid+"&focusid="+focalnodeid;

				} catch(err) {
					console.log(err);
				}
			}
		});
	}
}

function buildMapWidget(nodeid, title, height, isOpen, color, key, nodetofocusid) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	var widgetHeader = buildWidgetHeader(title, height, isOpen, color, key);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.height = height+"px";
	widgetBody.style.background = "white";
	widgetBody.update(getLoading("<?php echo $LNG->LOADING_MAPS; ?>"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'block';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	if (USER != "") {
		var hint = '<?php echo $LNG->GROUP_MAP_CREATE_BUTTON; ?>';
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});

		var addButton = new Element("span", {'title':hint, 'class':'active span-link'} );
		addButton.insert('<?php echo $LNG->MAP_ADD_EXISTING_BUTTON; ?>');
		Event.observe(addButton,'click',function () {
			loadDialog('selector', URL_ROOT+"ui/popups/selector.php?filternodetypes=Map&handler=addFocalNodeToMap&focalnodeid="+nodeid, 420, 730);
		});
		toolbar.insert(addButton);

		widgetHeader.insert(toolbar);
	} else {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		toolbar.insert('<span style="cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" border="0" width="18" height="18" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></span>');
		widgetHeader.insert(toolbar);
	}


	/* LOAD DATA */

	var reqUrl = SERVICE_ROOT + "&method=getmapsfornode&style=long";
	reqUrl += "&orderby=date&sort=DESC&start=0&max=-1&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var nodes = json.nodeset[0].nodes;
			widgetBody.update("");

			if (nodes.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> "+title+" <?php echo $LNG->WIDGET_NONE_FOUND_PART2; ?>");
			} else {
				var finalArray = new Array();
				for(var i=0; i< nodes.length; i++){
					var next = nodes[i];
					next.cnode['parentid'] = nodeid;
					next.cnode['nodetofocusid'] = nodetofocusid;
					next.cnode['handler'] = 'refreshWidgetMap(\''+nodetofocusid+'\')';
					finalArray.push(next);
				}

				if (finalArray.length > 0){
					displayWidgetNodes(widgetBody,finalArray,parseInt(0), true, key);
					$(key+"headerlabel").update(title+"<span style='margin-left:5px'>("+finalArray.length+")</span>");
				} else {
					widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> "+title+" <?php echo $LNG->WIDGET_NONE_FOUND_PART2; ?>");
				}
			}
		}
	});

	return widgetDiv;
}

function followUsersWidget(focalnodeid, title, height, isOpen, color, key) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	// WIDGET HEADER
	var widgetHeader = new Element("div", {'class':'widgetheader row m-0 p-0 '+color, 'id':key+"header"});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinner col', 'id':key+"headerinner", 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});
	var widgetHeaderLabel = new Element("label", {'class':'widgetheaderlabel widgettextcolor ', 'id':key+"headerlabel"});

	if (icon) {
		var icon = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; height:24px;', 'alt':title+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		icon.align='left';
		widgetInnerHeader.appendChild(icon);
	}

	var followbutton = new Element('img', {'style':'margin-right:5px;vertical-align:bottom'});
	followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow_bit.png"); ?>');
	widgetInnerHeader.insert(followbutton);

	widgetHeaderLabel.insert(title+"<span style='margin-left:5px'>(0)</span>");

	widgetInnerHeader.insert(widgetHeaderLabel);
	widgetHeader.insert(widgetInnerHeader);

	var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol '});
	if ($('widgettable')){
		var widgetHeaderControlButton = new Element('img',{ 'style':'cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});

		Event.observe(widgetHeaderLabel,'mouseover',function (){widgetHeaderLabel.style.cursor = 'pointer'});
		Event.observe(widgetHeaderLabel,'mouseout',function (){widgetHeaderLabel.style.cursor = 'normal'});

		Event.observe(widgetInnerHeader,'mouseover',function (){widgetInnerHeader.style.cursor = 'pointer'});
		Event.observe(widgetInnerHeader,'mouseout',function (){widgetInnerHeader.style.cursor = 'normal'});
		Event.observe(widgetInnerHeader,'click',function (){toggleExpandWidget(widgetHeaderControlButton, key, height)});
		Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});
		widgetInnerHeaderControl.insert(widgetHeaderControlButton);
	}

	var widgetHeaderControlButton2 = new Element('img',{ 'style':'cursor: pointer;visibility:visible', 'alt':'<?php echo $LNG->WIDGET_OPEN_CLOSE_ALT; ?>', 'id':key+'buttonarrow', 'title': '<?php echo $LNG->WIDGET_OPEN_CLOSE_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>'});
	Event.observe(widgetHeaderControlButton2,'click',function (){toggleWidget(this, key, height)});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton2);

	widgetHeader.insert(widgetInnerHeaderControl);

	if (isOpen) {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	} else {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	}

	//var widgetHeader = buildWidgetHeader(title, height, isOpen, color, key);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = height+"px";
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING_FOLLOWERS; ?>)"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'block';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.offsetHeight;
	}

	loadfollowUsersWidget(focalnodeid, title, key, widgetBody);

	return widgetDiv;
}

function loadfollowUsersWidget(focalnodeid, title, key, widgetBody) {

	if (!widgetBody) {
		widgetBody = $(key+'body')
	}

	/* LOAD DATA */
	var reqUrl = SERVICE_ROOT + "&method=getusersbyfollowing&itemid="+focalnodeid;
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var users = json.userset[0].users;
			widgetBody.update("");

			if (users.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NO_FOLLOWERS_FOUND; ?>");
			} else {
				displayWidgetUsers(widgetBody,users,parseInt(0));
			}
			$(key+"headerlabel").update(title+"<span style='margin-left:5px'>("+users.length+")</span>");
		}
	});
}