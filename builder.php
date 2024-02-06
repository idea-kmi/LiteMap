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

	include_once("config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}
?>
var NON_TEXT_SELECTION<?php echo $CFG->buildernamekey; ?> = "[ MEDIA ]";

var EvidenceHubwidth<?php echo $CFG->buildernamekey; ?>='44';
var EvidenceHubexpandedWidth<?php echo $CFG->buildernamekey; ?>='44';
var EvidenceHubAddress="<?php echo $CFG->homeAddress; ?>";
var EvidenceHubScriptIDNode<?php echo $CFG->buildernamekey; ?> = 'callbackNode<?php echo $CFG->buildernamekey; ?>';
var EvidenceHubScriptIDConn<?php echo $CFG->buildernamekey; ?> = 'callbackConn<?php echo $CFG->buildernamekey; ?>';

var helper<?php echo $CFG->buildernamekey; ?> = null;
var message<?php echo $CFG->buildernamekey; ?> = null;
var bodyInnerHTML<?php echo $CFG->buildernamekey; ?> = "";
var clipCheck<?php echo $CFG->buildernamekey; ?> = new Array();

function codeToRun<?php echo $CFG->buildernamekey; ?>() {

	helper<?php echo $CFG->buildernamekey; ?> = document.getElementById('EvidenceHubHelper<?php echo $CFG->buildernamekey; ?>');
	if (helper<?php echo $CFG->buildernamekey; ?> == null) {
		bodyInnerHTML<?php echo $CFG->buildernamekey; ?> = document.body.innerHTML;
		buildToolbar<?php echo $CFG->buildernamekey; ?>();
		selectAllIdeasEvidenceHub<?php echo $CFG->buildernamekey; ?>();
	} else {
		helper<?php echo $CFG->buildernamekey; ?>.style.display = "block";
		helper<?php echo $CFG->buildernamekey; ?>.className = 'LITEMAP-EvidenceHubHelper';
		toggleHelper<?php echo $CFG->buildernamekey; ?>(true);
		clearPageIdeaLinks<?php echo $CFG->buildernamekey; ?>();
		selectAllIdeasEvidenceHub<?php echo $CFG->buildernamekey; ?>();
	}
}

function buildToolbar<?php echo $CFG->buildernamekey; ?>() {
	var script = document.createElement('link');
	script.type = 'text/css';
	script.rel = 'stylesheet';
	script.href = '<?php echo $HUB_FLM->getStylePath("builder.css"); ?>';
	document.getElementsByTagName('head')[0].appendChild(script);

	helper<?php echo $CFG->buildernamekey; ?> = document.createElement('div');
	var tmp = '<div id="EvidenceHubHelper<?php echo $CFG->buildernamekey; ?>" class="LITEMAP-EvidenceHubHelper" style="width:'+EvidenceHubexpandedWidth<?php echo $CFG->buildernamekey; ?>+'px;display:block;">';
	tmp += '<div style="clear:both;float:left;width:'+EvidenceHubwidth<?php echo $CFG->buildernamekey; ?>+'px;">';
	tmp += '<a style="float:left;" target="_blank" title="<?php echo $LNG->BUILDER_GOTO_HOME_SITE_HINT; ?>" href="<?php echo $CFG->homeAddress; ?>"><img style="margin-left:3px;margin-right:7px; margin-top:4px;" src="<?php echo $HUB_FLM->getImagePath('builder-logo.png'); ?>" border="0" /></a>';
	tmp += '<div style="float:left;" id="EvidenceHubButton<?php echo $CFG->buildernamekey; ?>"><img onclick="return toggleHelper<?php echo $CFG->buildernamekey; ?>()" style="margin-top:4px;" id="EvidenceHubButtonImg<?php echo $CFG->buildernamekey; ?>" title="<?php echo $LNG->BUILDER_COLLAPSE_TOOLBAR_HINT; ?>" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" border="0" /></div>';
	tmp += '</div>';
	tmp += '<div id="EvidenceHubHelperMain<?php echo $CFG->buildernamekey; ?>" class="LITEMAP-EvidenceHubHelperMain">';

	tmp += '<img class="LITEMAP-addbutton" title="<?php echo $LNG->BUILDER_ADD_COMMENT_HINT; ?>" onclick="prepareDialog<?php echo $CFG->buildernamekey; ?>(\'commentadd\', \''+EvidenceHubAddress+'ui/popups/commentadd.php?&isremote=true\', 750,600)" src="<?php echo $CFG->commenticon; ?>" />';
	tmp += '<img class="LITEMAP-addbutton" title="<?php echo $LNG->BUILDER_ADD_ISSUE_HINT; ?>" onclick="prepareDialog<?php echo $CFG->buildernamekey; ?>(\'issueadd\', \''+EvidenceHubAddress+'ui/popups/issueadd.php?&isremote=true\', 750,600)" src="<?php echo $CFG->issueicon; ?>" />';
	tmp += '<img class="LITEMAP-addbutton" title="<?php echo $LNG->BUILDER_ADD_SOLUTION_HINT; ?>" onclick="prepareDialog<?php echo $CFG->buildernamekey; ?>(\'solutionadd\', \''+EvidenceHubAddress+'ui/popups/solutionadd.php?&isremote=true\', 750,600)" src="<?php echo $CFG->solutionicon; ?>" />';
	tmp += '<img class="LITEMAP-addbutton" title="<?php echo $LNG->BUILDER_ADD_EVIDENCE_PRO_HINT; ?>" onclick="prepareDialog<?php echo $CFG->buildernamekey; ?>(\'evidenceadd\', \''+EvidenceHubAddress+'ui/popups/evidenceadd.php?nodetypename=Pro&isremote=true\', 750,600)" src="<?php echo $CFG->proicon; ?>" />';
	tmp += '<img class="LITEMAP-addbutton" title="<?php echo $LNG->BUILDER_ADD_EVIDENCE_CON_HINT; ?>" onclick="prepareDialog<?php echo $CFG->buildernamekey; ?>(\'evidenceadd\', \''+EvidenceHubAddress+'ui/popups/evidenceadd.php?nodetypename=Con&isremote=true\', 750,600)" src="<?php echo $CFG->conicon; ?>" />';

	tmp += '</div>';
	tmp += '<div class="LITEMAP-closebutton">';
	tmp += '<span style="cursor:pointer;" id="EvidenceHubCloseButton<?php echo $CFG->buildernamekey; ?>" onclick="return closeHelper<?php echo $CFG->buildernamekey; ?>();" title="<?php echo $LNG->BUILDER_CLOSE_TOOLBAR_HINT; ?>"><img src="<?php echo $HUB_FLM->getImagePath("close.png"); ?>" border="0" /></span>';
	tmp += '</div>';
	tmp += '</div>';

	helper<?php echo $CFG->buildernamekey; ?>.innerHTML = tmp;
	document.getElementsByTagName('body')[0].appendChild(helper<?php echo $CFG->buildernamekey; ?>);

	//Add messge popup div
	message<?php echo $CFG->buildernamekey; ?> = document.createElement('div');
	message<?php echo $CFG->buildernamekey; ?>.setAttribute("id", 'message<?php echo $CFG->buildernamekey; ?>');
	message<?php echo $CFG->buildernamekey; ?>.className = 'LITEMAP-message';
	document.getElementsByTagName('body')[0].appendChild(message<?php echo $CFG->buildernamekey; ?>);

	document.addEventListener('click', function(event) {
		var target = (event.currentTarget) ? event.currentTarget : event.srcElement;
		if (target != 'undefined' && target.id.indexOf('<?php echo $CFG->buildernamekey; ?>') == -1) {
			hideHint<?php echo $CFG->buildernamekey; ?>();
		}
	}, false);
}

function closeHelper<?php echo $CFG->buildernamekey; ?>() {
	var helper = document.getElementById('EvidenceHubHelper<?php echo $CFG->buildernamekey; ?>');
	helper.style.display = "none";
	helper.className = 'LITEMAP-EvidenceHubHelperOff';
}

function toggleHelper<?php echo $CFG->buildernamekey; ?>(open) {
	var inner = document.getElementById('EvidenceHubHelperMain<?php echo $CFG->buildernamekey; ?>');
	if (inner.style.display == 'none' || open) {
		var button = document.getElementById('EvidenceHubButtonImg<?php echo $CFG->buildernamekey; ?>');
		button.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
		button.title="collapse Evidence Hub Helper";
		inner.style.display='block';
	} else {
		var button = document.getElementById('EvidenceHubButtonImg<?php echo $CFG->buildernamekey; ?>');
		button.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
		button.title="expand Evidence Hub Helper";
		inner.style.display='none';
	}
}

function prepareDialog<?php echo $CFG->buildernamekey; ?>(windowName, url, width, height) {

	var selected = getSelectedTextEvidenceHub<?php echo $CFG->buildernamekey; ?>();

	// before we can get the path of the selected text, the html needs to be pure or the path will be wrong.

	if (selected != "") {
		clearPageIdeaLinks<?php echo $CFG->buildernamekey; ?>();
		selected = getSelectedTextEvidenceHub<?php echo $CFG->buildernamekey; ?>();
	}

	// var selectedHTML = getSelectedHTMLEvidenceHub<?php echo $CFG->buildernamekey; ?>();

	if (windowName == 'issueadd') {
		//url += '&issue='+encodeURIComponent(selected);
		url += '&desc='+encodeURIComponent(selected);
		url = addResourceDetails<?php echo $CFG->buildernamekey; ?>(selected, url);

	} else if (windowName == 'solutionadd') {
		//url += '&solution='+encodeURIComponent(selected);
		url += '&desc='+encodeURIComponent(selected);
		url = addResourceDetails<?php echo $CFG->buildernamekey; ?>(selected, url);

	} else if (windowName == 'evidenceadd') {
		//url += '&evidencename='+encodeURIComponent(selected);
		url += '&desc='+encodeURIComponent(selected);
		url = addResourceDetails<?php echo $CFG->buildernamekey; ?>(selected, url);

	} else if (windowName == 'commentadd') {
		url += '&desc='+encodeURIComponent(selected);
		url = addResourceDetails<?php echo $CFG->buildernamekey; ?>(selected, url);
	}

	loadDialog<?php echo $CFG->buildernamekey; ?>(windowName, url, width, height);
}

function addResourceDetails<?php echo $CFG->buildernamekey; ?>(selected, url) {
	// resource details

	if (selected != "") {
		url += '&resourcecliparray[]='+encodeURIComponent(selected);
		var clipPath = getSelectedPathEvidenceHub<?php echo $CFG->buildernamekey; ?>();
		url += '&resourceclippatharray[]='+encodeURIComponent(clipPath);
	}

	var doi = lookforDOI<?php echo $CFG->buildernamekey; ?>();
	if (doi != "") {
		url += '&resourcetypesarray[]=Publication';
		url += '&identifierarray[]='+encodeURIComponent(doi);
	}

	url += '&resourcetitlearray[]='+encodeURIComponent(document.title);
	url += '&resourceurlarray[]='+encodeURIComponent(document.location.href);

	return url;
}

var popupWindow<?php echo $CFG->buildernamekey; ?> = null;

/**
 * open page in the dialog window
 */
function loadDialog<?php echo $CFG->buildernamekey; ?>(windowName, url, width, height){

    if (width == null){
        width = 570;
    }
    if (height == null){
        height = 510;
    }

    var left = parseInt((screen.availWidth/2) - (width/2));
    var top  = parseInt((screen.availHeight/2) - (height/2));
    var props = "width="+width+",height="+height+",left="+left+",top="+top+",menubar=no,toolbar=no,scrollbars=yes,location=no,status=no,resizable=yes";

    try {
    	popupWindow<?php echo $CFG->buildernamekey; ?> = window.open(url, windowName, props);
    	if(popupWindow<?php echo $CFG->buildernamekey; ?> != null){
    		popupWindow<?php echo $CFG->buildernamekey; ?>.focus();
    		checkDialog<?php echo $CFG->buildernamekey; ?>();
    	}
    } catch(err) {
    	//IE error
    	alert(err.description);
    }
}

function checkDialog<?php echo $CFG->buildernamekey; ?>() {
	if (popupWindow<?php echo $CFG->buildernamekey; ?> == null || popupWindow<?php echo $CFG->buildernamekey; ?>.closed) {
   		selectAllIdeasEvidenceHub<?php echo $CFG->buildernamekey; ?>();
	} else {
		setTimeout("checkDialog<?php echo $CFG->buildernamekey; ?>()",10);
	}
}

/**
 * Process the results from the server call for nodes on page.
 */
function processNodesEvidenceHub<?php echo $CFG->buildernamekey; ?>(json) {

	var count = 0;
	var ns = json.nodeset[0];
	var currentURL = window.location.href;

	if(ns.nodes.length > 0) {
		var nodeArray = ns.nodes;

		var checkednodes = new Array();
		var checkednodesurl = new Array();
		var newNodeArray = new Array();

		var resourceNodes = new Array();

		for (var i = 0; i < nodeArray.length; i++) {
			var node = nodeArray[i].cnode;
			resourceNodes[node.nodeid] = nodeArray[i];
		}

		for (var i = 0; i < nodeArray.length; i++) {
			var node = nodeArray[i].cnode;
			var hasClips = checkForClips(node.urls);
			if (node.urls && node.urls.length > 0) {

				if (hasClips) {
					for(var j = 0; j<node.urls.length; j++ ) {
						var url = node.urls[j].url;
					}
				}
			}
		}

		for (var i = 0; i < nodeArray.length; i++) {
			if(resourceNodes.hasOwnProperty(nodeArray[i].cnode.nodeid)){
				nodeArray[i] = resourceNodes[nodeArray[i].cnode.nodeid];
		    }
		}

		highlightSearchTermsEvidenceHub<?php echo $CFG->buildernamekey; ?>(nodeArray, true);
	} else {
		//alert("No existing resources found for this web page.");
	}
}


function removeResourceClip(resourceNodes, urlid) {

	for (var key in resourceNodes) {
		var node = resourceNodes[key].cnode;
		for(var j = 0; j<node.urls.length; j++) {
			var url = node.urls[j].url;
			if (url.urlid == urlid) {
				resourceNodes[key].cnode.urls.splice(j,1);
				break;
			}
		}
	}
}


/**
 * Process the results from the server call for connections on page.
 */
function processConnectionsEvidenceHub<?php echo $CFG->buildernamekey; ?>(json) {

	var count = 0;
	var cs = json.connset[0];
	if(cs.nodes.length > 0) {
		highlightSearchTermsEvidenceHub<?php echo $CFG->buildernamekey; ?>(ns.nodes, true);
	} else {
		alert("No existing resources found for this web page.");
	}
}

/**
 * Select all the ideas.
 */
function selectAllIdeasEvidenceHub<?php echo $CFG->buildernamekey; ?>() {

	var newRequestBase = EvidenceHubAddress;
	var currentURL = window.location.href;
	var newRequestUrl = newRequestBase + "api/service.php?callback=processNodesEvidenceHub<?php echo $CFG->buildernamekey; ?>&format=json&method=getnodesbyurl&max=-1&style=long&url=" + encodeURIComponent(currentURL);

	//alert(newRequestUrl);

    var script = document.createElement('script');
    script.setAttribute('type', 'text/javascript');
    script.setAttribute('src', newRequestUrl);
    script.setAttribute('async', 'true');
    script.setAttribute('id', EvidenceHubScriptIDNode<?php echo $CFG->buildernamekey; ?>);

    var script_id = document.getElementById('EvidenceHubScriptIDNode<?php echo $CFG->buildernamekey; ?>');
    if(script_id){
		document.getElementsByTagName('head')[0].removeChild('EvidenceHubScriptIDNode<?php echo $CFG->buildernamekey; ?>');
    }

    document.getElementsByTagName('head')[0].appendChild(script);
}

/**
 * Select all the ideas.
 */
function selectAllConnectionsEvidenceHub<?php echo $CFG->buildernamekey; ?>() {

	var newRequestBase = EvidenceHubAddress;
	var currentURL = window.location.href;

	var newRequestUrl = newRequestBase + "api/service.php?callback=processConnectionsEvidenceHub<?php echo $CFG->buildernamekey; ?>&format=json&method=getconnectionsbyurl&max=-1&style=long&url=" + encodeURIComponent(currentURL);

	//alert(newRequestUrl);

    var script = document.createElement('script');
    script.setAttribute('type', 'text/javascript');
    script.setAttribute('src', newRequestUrl);
    script.setAttribute('async', 'true');
    script.setAttribute('id', EvidenceHubScriptIDConn<?php echo $CFG->buildernamekey; ?>);

    var script_id = document.getElementById('EvidenceHubScriptIDConn<?php echo $CFG->buildernamekey; ?>');
    if(script_id){
		document.getElementsByTagName('head')[0].removeChild('EvidenceHubScriptIDConn<?php echo $CFG->buildernamekey; ?>');
    }

    document.getElementsByTagName('head')[0].appendChild(script);
}

/**
 * This takes the nodeArray of json eveidnce hub nodes whose url clips to search for, and highlights them.
 */
function highlightSearchTermsEvidenceHub<?php echo $CFG->buildernamekey; ?>(nodeArray, keepSelected) {

	if (!document.body || typeof(document.body.innerHTML) == "undefined") {
    	alert("Sorry, for some reason the text of this page is unavailable. We cannot search it.");
	    return false;
	}

	var currentURL = window.location.href;

	var globalFoundCount = 0;

	for (var i = 0; i < nodeArray.length; i++) {
		var node = nodeArray[i].cnode;
    	var label = node.name;

    	//alert("drawing clip for:"+label);
		//var desc = node.description;

		if (node.urls && node.urls.length > 0) {
			var hasClips = checkForClips(node.urls);
			if (hasClips) {
		        for(var j = 0; j<node.urls.length; j++ ) {
					var url= node.urls[j].url;
					if (url.url == currentURL) {
						if (url.clippath && url.clippath !== "") {
							//alert("in here clippath="+url.clippath);
							var itemFoundCount = processPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(url, node);
							//alert("foundCount="+itemFoundCount);
							if (itemFoundCount == 0) {
								//alert("Checking text");
								var itemFoundCount = searchTextEvidenceHub<?php echo $CFG->buildernamekey; ?>(url, node);
							}
						} else {
							//alert("Clip="+url.clip);
							var itemFoundCount = searchTextEvidenceHub<?php echo $CFG->buildernamekey; ?>(url, node);
						}
						if (itemFoundCount > 0) {
							globalFoundCount++;
							//next.style.backgroundColor = next.cohereHighlight;
						} else {
							//next.style.backgroundColor = NOTFOUND_HIGHLIGHT_COLOR;
						}
					} else {
						// theses are potential jump off points!!!
					}
				}
			}
		}
	}

   	if (globalFoundCount > 0) {
		//document.body.innerHTML = bodyText;
		//var firstFound = document.getElementById('firstFound0');
		//firstFound.scrollIntoView(true);

		//var range = document.createRange();
		//var newNode = document.createElement("p");
		//range.selectNode(document.getElementsByTagName("div").item(0));
		//range.surroundContents(newNode);

		return true;
	}

	return false;
}

/**
 * Search for the text in data property of the passed object in the current webpage.
 * If found, select and scroll to
 */
function searchTextEvidenceHub<?php echo $CFG->buildernamekey; ?>(url, hubnode) {
	var searchTerm = url.clip;

	var itemFoundCount = 0
	var highlightColour = "#FFFF80";

	try {
		// don't bother trying to search for non-text based selection's label text.
		if (searchTerm.substr(0, NON_TEXT_SELECTION<?php echo $CFG->buildernamekey; ?>.length) == NON_TEXT_SELECTION<?php echo $CFG->buildernamekey; ?>) {
			return;
		}

		var itemID = url.urlid;
		var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT,
						null,
						true
						);

		var allText = "";

		var highlightNodes = new Array();

		searchTerm = searchTerm.replace(/\s+/g, " ");
		while (walker.nextNode()) {
	   		var node = walker.currentNode;
	   		if (node.nodeType == Node.TEXT_NODE) {
				//textNodes[textNodes.length] = node
		   		allText += node.nodeValue;
				allText = allText.replace(/\s+/g, " ");
		   		var ind = allText.indexOf(searchTerm);
		   		if (ind > -1) {
		   			highlightNodes[highlightNodes.length] = node;
		   			break;
		   		}
		   	}
		}

		if (highlightNodes.length > 0) {
			var reverseText = highlightNodes[0].nodeValue;
	   		reverseText = reverseText.replace(/\s+/g, " ");
			var ind = reverseText.indexOf(searchTerm);
		 	if (ind == -1) {
				while (walker.previousNode()) {
			   		var node = walker.currentNode;
	   				if (node.nodeType == Node.TEXT_NODE) {
						reverseText = node.nodeValue + reverseText;
		   				reverseText = reverseText.replace(/\s+/g, " ");
				   		var ind = reverseText.indexOf(searchTerm);
						highlightNodes[highlightNodes.length] = node;
				   		if (ind > -1) {
				   			break;
				   		}
				   	}
				}
			}

			highlightNodes.reverse();

			var count = highlightNodes.length;
			var splitText = searchTerm.split(' ');

			if (count > 0) {
				itemFoundCount ++;
			}

			var selection = "";
			if (window.getSelection) {
				selection = window.getSelection();
			} else if (document.getSelection) {
				selection = document.getSelection();
			} else if (document.selection) {
				selection = document.selection.createRange().text;
			}
			var range = document.createRange();

			if (count == 1) {
				var node = highlightNodes[0];
				var nodeText = node.nodeValue;
				var firstindex = findIndexOfTermEvidenceHub<?php echo $CFG->buildernamekey; ?>(nodeText, splitText, 0, true);
				if (firstindex != -1) {
					range.setStart(node, firstindex);
					range.setEnd(node, (firstindex+searchTerm.length));

					var button = document.createElement("img");
					button.setAttribute("src", EvidenceHubAddress+hubnode.role[0].role.image);
					button.setAttribute("width", "16");
					button.setAttribute("height", "16");
					button.setAttribute("name", "<?php echo $CFG->buildernamekey; ?>idealink");
					button.setAttribute("id", "<?php echo $CFG->buildernamekey; ?>"+url.urlid);
					button.setAttribute("class", "LITEMAP-imagebutton");
					button.border = "0";
					button.clipid = url.urlid;
					button.addEventListener('click', function(event) {
						var message = "<b><?php echo $LNG->BUILDER_TITLE_LABEL; ?> </b>"+hubnode.name+"<br>"; //Description: "+hubnode.description;
						message =message+'<br><a target="_blank" href="<?php echo $CFG->homeAddress; ?>explore.php?id='+hubnode.nodeid+'"><?php echo $LNG->BUILDER_EXPLORE_LINK; ?> &rsaquo;&rsaquo;</a>';

						var panel = document.getElementById('message<?php echo $CFG->buildernamekey; ?>');
						if (typeof panel.clipid != 'undefined' && panel.clipid == this.clipid && panel.style.visibility == "hidden") {
							showHint<?php echo $CFG->buildernamekey; ?>(event, message, url.urlid, 10, -10);
							//selection.removeAllRanges();
							//selection.addRange(range);
						} else {
							if (panel && (typeof panel.clipid == 'undefined' || panel.clipid != this.clipid)) {
								showHint<?php echo $CFG->buildernamekey; ?>(event, message, url.urlid, 10, -10);
								//selection.removeAllRanges();
								//selection.addRange(range);
							} else {
								hideHint<?php echo $CFG->buildernamekey; ?>();
							}
						}
					}, false);
					button.addEventListener('mouseover', function(event) {
						selection.removeAllRanges();
						selection.addRange(range);
						//showHint<?php echo $CFG->buildernamekey; ?>(event, hubnode.name+":<br>"+hubnode.description, 10, -10);
					}, false);
					button.addEventListener('mouseout', function() {
						selection.removeAllRanges();
						//hideHint<?php echo $CFG->buildernamekey; ?>();
					}, false);

					range.insertNode(button);
					range.setStartAfter(button);
				}
			} else {
				for (var i=0; i<count; i++) {
					var node = highlightNodes[i];
					var nodeText = node.nodeValue;
					if (i==0) {
						var firstindex = findIndexOfTermEvidenceHub<?php echo $CFG->buildernamekey; ?>(nodeText, splitText, 0, true);
						if (firstindex != -1) {
							range.setStart(node, firstindex);
						}

						var button = document.createElement("img");
						button.setAttribute("src", EvidenceHubAddress+hubnode.role[0].role.image);
						button.setAttribute("width", "16");
						button.setAttribute("height", "16");
						button.setAttribute("name", "<?php echo $CFG->buildernamekey; ?>idealink");
						button.setAttribute("id", "<?php echo $CFG->buildernamekey; ?>"+url.urlid);
						button.setAttribute("class", "LITEMAP-imagebutton");
						button.border = "0";
						button.clipid = url.urlid;
						button.addEventListener('click', function(event) {
							var message = "<b><?php echo $LNG->BUILDER_TITLE_LABEL; ?> </b>"+hubnode.name+"<br>"; //Description: "+hubnode.description;
							message =message+'<br><a target="_blank" href="<?php echo $CFG->homeAddress; ?>explore.php?id='+hubnode.nodeid+'"><?php echo $LNG->BUILDER_EXPLORE_LINK; ?> &rsaquo;&rsaquo;</a>';

							var panel = document.getElementById('message<?php echo $CFG->buildernamekey; ?>');
							if (typeof panel.clipid != 'undefined' && panel.clipid == this.clipid && panel.style.visibility == "hidden") {
								showHint<?php echo $CFG->buildernamekey; ?>(event, message, url.urlid, 10, -10);
								// in case they clicked on page and turned off selection
								//selection.removeAllRanges();
								//selection.addRange(range);
							} else {
								if (panel && (typeof panel.clipid == 'undefined' || panel.clipid != this.clipid)) {
									showHint<?php echo $CFG->buildernamekey; ?>(event, message, url.urlid, 10, -10);
									// in case they clicked on page and turned off selection
									//selection.removeAllRanges();
									//selection.addRange(range);
								} else {
									hideHint<?php echo $CFG->buildernamekey; ?>();
								}
							}
						}, false);
						button.addEventListener('mouseover', function(event) {
							selection.removeAllRanges();
							selection.addRange(range);
							//showHint<?php echo $CFG->buildernamekey; ?>(event, hubnode.name+":<br>"+hubnode.description, 10, -10);
						}, false);
						button.addEventListener('mouseout', function() {
							selection.removeAllRanges();
							//hideHint<?php echo $CFG->buildernamekey; ?>();
						}, false);

						range.insertNode(button);
						range.setStartAfter(button);
					} else if (i == count-1) {
						var lastindex = findIndexOfTermEvidenceHub<?php echo $CFG->buildernamekey; ?>(nodeText, splitText, splitText.length-1, false);
						if (lastindex != -1) {
							range.setEnd(node, lastindex);

						}
					} else {
						//set selection colour on node somehow?
					}
				}
			}

			if (range) {
				//alert(selection.anchorNode.nodeName);
				//selection.addRange(range);
				range.startContainer.parentNode.scrollIntoView(true);
			}
		}
	} catch(e) {

	}

	return itemFoundCount;
}

function findIndexOfTermEvidenceHub<?php echo $CFG->buildernamekey; ?>(textBlock, termArray, indexPoint, down) {

	var searchTerm = "";

	if (down) {
		for (var i=0; i<=indexPoint; i++) {
			if (searchTerm != "") {
				searchTerm += " "+termArray[i];
			} else {
				searchTerm += termArray[i];
			}
		}
	} else {
		for (var i=termArray.length-1; i>=indexPoint; i--) {
			if (searchTerm != "") {
				searchTerm = termArray[i]+" "+searchTerm;
			} else {
				var next = termArray[i];
				if (next != "") {
					searchTerm += next;
				} else {
					// if the last item in the array of words is a space move back one which hopefully will be a word!
					if (i==indexPoint) {
						indexPoint--;
					}
				}
			}
		}
	}

	if (searchTerm != "") {
		var ind1 = textBlock.indexOf(searchTerm);
		var ind2 = textBlock.lastIndexOf(searchTerm);
		if (ind1 != ind2) {
			return findIndexOfTermEvidenceHub<?php echo $CFG->buildernamekey; ?>(textBlock, termArray, indexPoint+1, down);
		} else {
			if (down) {
				return ind1;
			} else {
				return ind1+searchTerm.length;
			}
		}
	} else {
		return -1;
	}
}

/**
 * Check the given list of urls and return true
 * if there is at least one clip on a url
 */
function checkForClips(urls) {
	var hasClips = false;

  	if(urls && urls.length > 0) {
  		for(var i = 0; i<urls.length; i++ ){
  			var url = urls[i].url;
  			if (urls[i].url.clip != "") {
  			//if (urls[i].url.desc != "") {
  				hasClips = true;
  				break;
  			}
    	}
	}
	return hasClips;
}

/**
 * Return a path for the given node.
 * @param node the node to get a path for.
 * @returns a text string representing the path in the Dom to the given node;
 */
function getPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(node) {
    var result = "";

	if (!node) {
		return result;
	}

    var parent;
    var children;
    var tagName;
    var i;
    var count;
    var child;

    while (node.parentNode) {
		parent = node.parentNode;
		children = parent.childNodes;
		count = 0;

		for (i = 0; i < children.length; i++) {
			child = children.item(i);
	    	tagName = getNodeName<?php echo $CFG->buildernamekey; ?>(child);
	    	if (tagName) {
			    if (child == node) {
				    if (node.hasAttribute &&
				    		node.hasAttribute("id") &&
				    		node.getAttribute("id") !== "") {
				    	return result = 'id("' + node.getAttribute("id") + '")'+result;
					} else {
		            	result = "/" + tagName.toLowerCase() + "[" + count + "]" + result;
					}
		    		break;
			    }
		  	    if (child.nodeName === node.nodeName) {
		             count++;
		        }
	    	}
		}

		node = parent;
    }

    return result;
}

/**
 * Get the name for the path for the given node
 */
function getNodeName<?php echo $CFG->buildernamekey; ?>(node) {
    var nodeName ;
    nodeName = node.nodeName.toLowerCase();
    switch (nodeName) {
      case "#text":
        return "text()";
      case "#comment":
        return "comment()";
      case "#cdata-section":
        return "cdata-section()";
      default:
      	if (nodeName == null) {
      		nodeName = child.tagName.toLowerCase();
      	}
        return nodeName;
    }
}

/**
 * For old paths not in xpointer syntax.
 */
function convertNodeName<?php echo $CFG->buildernamekey; ?>(num) {
	if(!isNaN(num)) {
		if (num == 3) {
			return "text()";
		} else if (num == 4) {
			return "cdata-section()";
		}
	}
	return num;
}

/**
 * Process the given urls clip path to produce a selection Range object
 * path structure = startPath+":"+startOffset+"-"+endPath+":"+endOffset;
 * @param path the path to process
 */
function processPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(url, hubnode) {
	var path = url.clippath;

	var itemFoundCount = 0;

	// if there a dash in the id name, deal with it so you can still split the path
	var fullpathArray = new Array();
	var path1 = "";
	var path2 = "";

	var ind = path.indexOf("(");
	var ind2 = path.indexOf("-");
	var ind3 = path.indexOf(")");
	if (ind != -1 && ind2 != -1 && ind3 != -1 && ind2 > ind && ind2 < ind3) {
		var partstr = path.substr(ind3);
		fullpathArray = partstr.split("-");
		path1 = path.substring(0,ind3)+fullpathArray[0];

		//are there ids with '-' at both sides of the path?
		if (fullpathArray.length>2) {
			path2 = fullpathArray[1]+"-"+fullpathArray[2];
		} else {
			path2 = fullpathArray[1];
		}
	} else {
		fullpathArray = path.split("-");
		path1 = fullpathArray[0];
		path2 = fullpathArray[1];
	}

	//alert("path1="+path1);
	//alert("path2="+path2);

	// if there is a colon in the id name, deal with it so you can still split path1
	var path1Array = new Array();
	var startPath = "";
	var startOffset = "";

	var ind = path1.indexOf("(");
	var ind2 = path1.indexOf(":");
	var ind3 = path1.indexOf(")");
	if (ind != -1 && ind2 != -1 && ind3 != -1 && ind2 > ind && ind2 < ind3) {
		var partstr = path1.substr(ind3);
		path1Array = partstr.split(":");
		startPath = path1.substring(0,ind3)+path1Array[0];
		startOffset = path1Array[1];
	} else {
		path1Array = path1.split(":");
		startPath = path1Array[0];
		startOffset = path1Array[1];
	}

	//alert("startPath="+startPath);
	//alert("startOffset="+startOffset);

	// if there is a colon in the id name, deal with it so you can still split path2
	var path2Array = new Array();
	var endPath = "";
	var endOffset = "";

	var ind = path2.indexOf("(");
	var ind2 = path2.indexOf(":");
	var ind3 = path2.indexOf(")");
	if (ind != -1 && ind2 != -1 && ind3 != -1 && ind2 > ind && ind2 < ind3) {
		var partstr = path2.substr(ind3);
		path2Array = partstr.split(":");
		endPath = path2.substring(0,ind3)+path2Array[0];
		endOffset = path2Array[1];
	} else {
		path2Array = path2.split(":");
		endPath = path2Array[0];
		endOffset = path2Array[1];
	}

	//alert("endPath="+endPath);
	//alert("endOffset="+endOffset);

	//alert("About to process startContainer path");
	var startContainer = getNodeFromPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(startPath);

	//alert("startContainer="+startContainer);

	var endContainer;

	if (startPath == endPath) {
		endContainer = startContainer;
	} else {
		endContainer = getNodeFromPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(endPath);
	}

	//alert("endContainer="+endContainer);

	if (startContainer && endContainer) {
		//alert("range found in path search - clipid="+url.urlid);

		var range = document.createRange();

		try {
			range.setStart(startContainer, startOffset);
		} catch(err) {
			//alert("errorStart="+err);
			return itemFoundCount;
		}

		try {
			//if (endContainer.nodeType == endContainer.TEXT_NODE) {
			//	range.setEnd(endContainer.parentNode, endOffset);
			//} else {
				range.setEnd(endContainer, endOffset);
			//}
		} catch(err) {
			//alert("errorEnd="+err);
			return itemFoundCount;
		}

		var selection = "";
		if (window.getSelection) {
			selection = window.getSelection();
		} else if (document.getSelection) {
			selection = document.getSelection();
		} else if (document.selection) {
			selection = document.selection.createRange().text;
		}

		if (hubnode) {
			var button = document.createElement("img");
			button.setAttribute("src", EvidenceHubAddress+hubnode.role[0].role.image);
			button.setAttribute("width", "16");
			button.setAttribute("height", "16");
			button.setAttribute("name", "<?php echo $CFG->buildernamekey; ?>idealink");
			button.setAttribute("class", "LITEMAP-imagebutton");
			button.setAttribute("id", "<?php echo $CFG->buildernamekey; ?>"+url.urlid);
			button.border = "0";
			button.clipid = url.urlid;
			button.addEventListener('click', function(event) {
				var message = "<b><?php echo $LNG->BUILDER_TITLE_LABEL; ?> </b>"+hubnode.name+"<br>"; //Description: "+hubnode.description;
				message =message+'<br><a target="_blank" href="<?php echo $CFG->homeAddress; ?>explore.php?id='+hubnode.nodeid+'"><?php echo $LNG->BUILDER_EXPLORE_LINK; ?> &rsaquo;&rsaquo;</a>';

				var panel = document.getElementById('message<?php echo $CFG->buildernamekey; ?>');
				if (typeof panel.clipid != 'undefined' && panel.clipid == this.clipid && panel.style.visibility == "hidden") {
					showHint<?php echo $CFG->buildernamekey; ?>(event, message, url.urlid, 0,-10);
					// in case they clicked on page and turned off selection
					//selection.removeAllRanges();
					//selection.addRange(range);
				} else {
					if (panel && (typeof panel.clipid == 'undefined' || panel.clipid != this.clipid)) {
						showHint<?php echo $CFG->buildernamekey; ?>(event, message, url.urlid, 0, -10);
						// in case they clicked on page and turned off selection
						//selection.removeAllRanges();
						//selection.addRange(range);
					} else {
						hideHint<?php echo $CFG->buildernamekey; ?>();
					}
				}
			}, false);

			button.addEventListener('mouseover', function(event) {
				selection.removeAllRanges();
				selection.addRange(range);
				//showHint<?php echo $CFG->buildernamekey; ?>(event, hubnode.name+":<br>"+hubnode.description, 10, -10);
			}, false);
			button.addEventListener('mouseout', function() {
				selection.removeAllRanges();
				//hideHint<?php echo $CFG->buildernamekey; ?>();
			}, false);

			try {
				//if (startContainer.parentNode) {
					//button.parentHTML = startContainer.parentNode.innerHTML;
				//}
				range.insertNode(button);
				range.setStartAfter(button);

				//startContainer.paertNode.normalize();

				//startContainer.insertBefore(button, node);
			} catch(err) {
				//alert("error="+err);
				return itemFoundCount;
			}
		}

		if (range) {
			itemFoundCount = 1;
			//selection.addRange(range);
			range.startContainer.parentNode.scrollIntoView(true);
		}
	}

	return itemFoundCount;
}

/**
 * Return a dom node element from parsing the given path or null.
 * @param path the path to parse.
 * @returns a node element or null;
 */
function getNodeFromPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(path) {
	if (!path || path.length == 0 || path == "") {
		return null;
	}

	var next = document;
    var children;
    var result = "";
    var i;
    var j;
    var check = "";
    var type = "";
    var num;
    var child;
    var tagName = "";
    var numcheck;

    var elements = path.split("/");

    for (j=0; j<elements.length; j++) {
    	type="";
    	check = elements[j];

    	// if this path element is identified by an id - find it from its id
        if (check && check.length > 1 && check.substr(0,2) == "id") {
        	var ids = check.split('\'');
        	var id = ids[1];
         	if (id == undefined) {
       			ids = check.split('\"');
        		id = ids[1];
         	}
        	next = document.getElementById(id);
        	if (next == null) {
        		return null;
        	}
        	continue;
        }

    	if (check != null && check != "") {
	    	//alert("check: "+check+":");
			//alert("next: "+toString.apply(next));

    		var nums = check.split("[");
			check = nums[0];
			num = nums[1].split("]")[0];

			// if only number then it equals a nodetype of TEXT_NODE or CDATA
			// convert old number to nodeName
			numcheck = parseInt(check);
			if(!isNaN(numcheck)) {
				check = convertNodeName<?php echo $CFG->buildernamekey; ?>(numcheck);
				//alert(numcheck+":CONVERTED TO:"+check);
			}
	    	if (next.hasChildNodes()) {
				children = next.childNodes;
				var count = 0;
				for (i = 0; i < children.length; i++) {
					child = children.item(i);
					//alert(child);
					//alert("count="+count+":"+num);
					var tagName = getNodeName<?php echo $CFG->buildernamekey; ?>(child);
					//alert(tagName+":"+check+":"+count+":"+num);
					if (tagName == check && count == num) {
						 // alert("matched"+child);
			             next = child;
			             break;
			        } else if (tagName == check && count < num) {
			        	count++;
			        }
				}
    		} else {
    			return next;
    		}
    	}
	}

    if (next == document) {
    	return null;
    }

    return next;
}

/**
 * Return a path for the current selection.
 * @returns a text string representing the path.
 */
function getSelectedPathEvidenceHub<?php echo $CFG->buildernamekey; ?>() {
	var fullpath = "";

	var selection = "";
	var range = null;
    if (window.getSelection) {
    	selection = window.getSelection();
 		range = selection.getRangeAt(0);
   	} else if (document.getSelection) {
    	selection = document.getSelection();
        range = document.selection.createRange();
    } else if (document.selection) {
        selection = document.selection.createRange().text;
        range = document.selection.createRange();
    }

	//alert(range);

	//if people select more than one selection - take the first only
	//each should be a separate clip

	var startContainer = range.startContainer;
	var endContainer = range.endContainer;
	var startOffset = range.startOffset;
	var endOffset = range.endOffset;

	//alert("startContainer:"+startContainer);
	//alert("startOffset:"+startOffset);
	//alert("endContainer:"+endContainer);
	///alert("endOffset:"+endOffset);

	var startPath = getPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(startContainer);
	//alert(startPath);
	if (startPath == "") {
		return fullpath;
	}

	//var foundNode = getNodeFromPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(startPath);
	//alert("foundNode == node:"+(foundNode == range.startContainer));

	var endPath = "";
	if (startContainer == endContainer) {
		endPath = startPath;
	} else {
		endPath = getPathEvidenceHub<?php echo $CFG->buildernamekey; ?>(endContainer);
	}
	//alert(endPath);

	fullpath = startPath+":"+startOffset+"-"+endPath+":"+endOffset;
	//alert(fullpath);

	return fullpath;
}

/**
 * Return the html for the current selection.
 * @returns a string of the html.
 */
function getSelectedHTMLEvidenceHub<?php echo $CFG->buildernamekey; ?>() {
    var txt = '';

    if (window.getSelection) {
    	txt = window.getSelection();
    } else if (document.getSelection) {
    	txt = document.getSelection();
    } else if (document.selection) {
        txt = document.selection.createRange().text;
    }

	var range = txt.getRangeAt(0);

	var searchStrHTML = "";
	if (range && range != null) {
		var spanNode = document.createElement("layer");
		var docfrag = range.cloneContents();
		spanNode.appendChild(docfrag);
		searchStrHTML = spanNode.innerHTML;

		//alert("HTML:<pre>"+searchStrHTML+"</pre>");
	}
	return searchStrHTML;
}

/**
 * Return the text for the current selection.
 * @returns a string of the text selected.
 */
function getSelectedTextEvidenceHub<?php echo $CFG->buildernamekey; ?>() {
    var txt = '';

    if (window.getSelection) {
    	txt = window.getSelection();
    } else if (document.getSelection) {
    	txt = document.getSelection();
    } else if (document.selection) {
        txt = document.selection.createRange().text;
    }

    return txt;
}

/**
 * Search the current webpage and try and identify if it contains a DOI number.
 * @returns DOI string if found, else an empty string.
 */
function lookforDOI<?php echo $CFG->buildernamekey; ?>(){
	var doi = "";
	var body = document.body.innerHTML;
	var text = body.replace(/<[^>]*>/g, ' ');

	var doiRegExp = /(?:DOI|doi|[Dd]igital\s+[Oo]bject\s+[Ii][Dd](?:entifier))\s*:?\s*(100?\.\d+\/[^%"#\x20\t\r\n]+)/g;
	var matches = doiRegExp.exec(text);
	if (matches != null && matches.length >= 1) {
		var doiRegExp2 = /(100?\.\d+\/[^%"#\x20\t\r\n]+)/g;
		var matches2 = doiRegExp2.exec(matches[0]);
		doi = matches2[0];
	}

	return doi;
}

var IE = 0;
var IE5 = 0;
var NS = 0;
var GECKO = 0;
if (document.all) {     // Internet Explorer Detected
	OS = navigator.platform;
	var VER = new String(navigator.appVersion);
	VER = VER.substr(VER.indexOf("MSIE")+5, VER.indexOf(" "));
	if ((VER <= 5) && (OS == "Win32")) {
		IE5 = true;
	} else {
		IE = true;
	}
}
else if (document.layers) {   // Netscape Navigator Detected
	NS = true;
}
else if (document.getElementById) { // Netscape 6 Detected
	GECKO = true;
}

/**
 * Get the height of the visible screen
 */
function getWindowHeight(){
  	var viewportHeight = 500;
	if (self.innerHeight) {
		// all except Explorer
		viewportHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) {
	 	// Explorer 6 Strict Mode
		viewportHeight = document.documentElement.clientHeight;
	} else if (document.body)  {
		// other Explorers
		viewportHeight = document.body.clientHeight;
	}
	return viewportHeight;
}

/**
 * Get the width of the visible screen
 */
function getWindowWidth(){
  	var viewportWidth = 500;
	if (self.innerHeight) {
		// all except Explorer
		viewportWidth = self.innerWidth;
	} else if (document.documentElement && document.documentElement.clientHeight) {
	 	// Explorer 6 Strict Mode
		viewportWidth = document.documentElement.clientWidth;
	} else if (document.body)  {
		// other Explorers
		viewportWidth = document.body.clientWidth;
	}
	return viewportWidth;
}

/**
 * Show a hint popup div (when multiple lines needed).
 */
function showHint<?php echo $CFG->buildernamekey; ?>(evt, text, clipid, extraX, extraY) {

	var panel = document.getElementById('message<?php echo $CFG->buildernamekey; ?>');

	panel.clipid = clipid;
	panel.innerHTML=text;

	var popupName = 'message<?php echo $CFG->buildernamekey; ?>';
 	var event = evt || window.event;

	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();

	hideHint<?php echo $CFG->buildernamekey; ?>();

	if (GECKO) {
		//alert("IN GEKO");

		//adjust for it going off the screen right or bottom.
		var x = event.clientX;
		var y = event.clientY;
		if ( (x+panel.offsetWidth) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+10;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}

		panel.style.left = x+extraX+window.pageXOffset+"px";
		panel.style.top = y+extraY+window.pageYOffset+"px";
		panel.style.background = "#FFFED9";
		//panel.style.visibility = "visible";
	}

	else if (NS) {
		//alert("IN NS");

		//adjust for it going off the screen right or bottom.
		var x = event.pageX;
		var y = event.pageY;
		if ( (x+panel.offsetWidth) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+10;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}
		document.layers[popupName].moveTo(x+extraX+window.pageXOffset+"px", y+extraY+window.pageYOffset+"px");
		document.layers[popupName].bgColor = "#FFFED9";
		//document.layers[popupName].visibility = "show";
	}
	else if (IE || IE5) {
		//alert("IN IE");

		//adjust for it going off the screen right or bottom.
		var x = event.x;
		var y = event.clientY;
		if ( (x+panel.offsetWidth) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+10;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}

		window.event.cancelBubble = true;
		document.all[popupName].style.left = x+extraX+ document.documentElement.scrollLeft+"px";
		document.all[popupName].style.top = y+extraY+ document.documentElement.scrollTop+"px";
		//document.all[popupName].style.visibility = "visible";
	}

	panel.style.visibility = "visible";

	return false;
}

/**
 * Close an open hint popup div.
 */
function hideHint<?php echo $CFG->buildernamekey; ?>() {
	var popupName = 'message<?php echo $CFG->buildernamekey; ?>';

	if ( IE || GECKO) {
		document.getElementById(popupName).style.visibility = "hidden";
	}
	else if (NS) {
		document.layers[popupName].visibility = "hide";
	}
	else if (IE5) {
		document.all[popupName].style.visibility = "hidden";
	}

}

/**
 * Remove any idea icons added to the page by previous selects.
 */
function clearPageIdeaLinks<?php echo $CFG->buildernamekey; ?>() {
	var nodeList = document.getElementsByName('<?php echo $CFG->buildernamekey; ?>idealink');
	if (nodeList != null) {
		for (var i=0; i<nodeList.length; i++) {
		    var item = nodeList[i];
		    if (item) {
				if (item.parentHTML) {
					item.parentNode.innerHTML = item.parentHTML;
					i--;
				} else {
					var parentNode = item.parentNode;
					if (parentNode) {
						parentNode.removeChild(item);
						i--;
					}
				}
			}
		}
	}

	document.body.normalize(); // very important to correct the structure
}

codeToRun<?php echo $CFG->buildernamekey; ?>();