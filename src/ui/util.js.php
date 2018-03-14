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
 /** Author: Michelle Bachler, KMi, The Open University **/

	header('Content-Type: text/javascript;');
	include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

	echo "var NODE_CONTEXT = '".$CFG->NODE_CONTEXT."';";
	echo "var USER_CONTEXT = '".$CFG->USER_CONTEXT."';";
	echo "var GLOBAL_CONTEXT = '".$CFG->GLOBAL_CONTEXT."';";

    $evidenceArrayStr = "";
    $evidenceStr = "";
    for($i=0;$i< sizeof($CFG->EVIDENCE_TYPES); $i++){
        $evidenceArrayStr .= '"'.$CFG->EVIDENCE_TYPES[$i].'"';
        $evidenceStr .= $CFG->EVIDENCE_TYPES[$i];
        if ($i != (sizeof($CFG->EVIDENCE_TYPES)-1)){
            $evidenceArrayStr .= ',';
            $evidenceStr .= ',';
        }
    }
    echo "var EVIDENCE_TYPES = new Array(".$evidenceArrayStr.");";
	echo "var EVIDENCE_TYPES_STR = '".$evidenceStr."';";

    $baseArray = "";
    $baseStr = "";
    for($j=0; $j<sizeof($CFG->BASE_TYPES); $j++){
        $baseArray .= '"'.$CFG->BASE_TYPES[$j].'"';
        $baseStr .= $CFG->BASE_TYPES[$j];
        if ($j != (sizeof($CFG->BASE_TYPES)-1)) {
            $baseArray .= ',';
            $baseStr .= ',';
        }
    }
    echo "var BASE_TYPES = new Array(".$baseArray.");";
    echo "var BASE_TYPES_STR = '".$baseStr."';";

	// Colours for the applet node backgrounds
	echo "var challengeback = '".$CFG->challengeback."';";
	echo "var issueback = '".$CFG->issueback."';";
	echo "var solutionback = '".$CFG->solutionback."';";
	echo "var claimback = '".$CFG->claimback."';";
	echo "var orgback = '".$CFG->orgbackpale."';";
	echo "var projectback = '".$CFG->projectback."';";
	echo "var peopleback = '".$CFG->peopleback."';";
	echo "var proback = '".$CFG->proback."';";
	echo "var conback = '".$CFG->conback."';";
	echo "var evidenceback = '".$CFG->evidenceback."';";
	echo "var resourceback = '".$CFG->resourceback."';";
	echo "var themeback = '".$CFG->themeback."';";
	echo "var plainback  = '".$CFG->plainback."';";
	echo "var argumentback  = '".$CFG->argumentback."';";
	echo "var ideaback  = '".$CFG->ideaback."';";
	echo "var commentback  = '".$CFG->commentback."';";
	echo "var mapback  = '".$CFG->mapback."';";

	echo "var challengebackpale = '".$CFG->challengebackpale."';";
	echo "var issuebackpale = '".$CFG->issuebackpale."';";
	echo "var solutionbackpale = '".$CFG->solutionbackpale."';";
	echo "var claimbackpale = '".$CFG->claimbackpale."';";
	echo "var orgbackpale = '".$CFG->orgbackpale."';";
	echo "var projectbackpale = '".$CFG->projectbackpale."';";
	echo "var peoplebackpale = '".$CFG->peoplebackpale."';";
	echo "var probackpale = '".$CFG->probackpale."';";
	echo "var conbackpale = '".$CFG->conbackpale."';";
	echo "var evidencebackpale = '".$CFG->evidencebackpale."';";
	echo "var resourcebackpale = '".$CFG->resourcebackpale."';";
	echo "var themebackpale = '".$CFG->themebackpale."';";
	echo "var plainbackpale  = '".$CFG->plainbackpale."';";
	echo "var argumentbackpale  = '".$CFG->argumentbackpale."';";
	echo "var ideabackpale  = '".$CFG->ideabackpale."';";
	echo "var commentbackpale  = '".$CFG->commentbackpale."';";
	echo "var mapbackpale  = '".$CFG->mapbackpale."';";
?>

/**
 * Variables
 */
var URL_ROOT = "<?php print $CFG->homeAddress;?>";
var SERVICE_ROOT = URL_ROOT + "api/service.php?format=json";
var USER = "<?php print $USER->userid; ?>";
var IS_USER_ADMIN = "<?php print $USER->getIsAdmin(); ?>";
var DATE_FORMAT = 'd/m/yy';
var DATE_FORMAT_PROJECT = 'd mmm yyyy';
var TIME_FORMAT = 'd/m/yy - H:MM';
var SELECTED_LINKTYES = "";
var SELECTED_NODETYPES = "";
var SELECTED_USERS = "";

var IE = 0;
var IE5 = 0;
var NS = 0;
var GECKO = 0;
var openpopups = new Array();

/** Store some variables about the browser being used.*/
if (document.all) {     // Internet Explorer Detected
	OS = navigator.platform;
	VER = new String(navigator.appVersion);
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

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

/**
 * Check to see if the enter key was pressed then fire the onlcik of that item.
 */
function enterKeyPressed(evt) {
 	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var characterCode = document.all? window.event.keyCode:event.which;
	if(characterCode == 13) {
		thing.onclick();
	}
}


/**
 * Check to see if the enter key was pressed.
 */
function checkKeyPressed(evt) {
 	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var characterCode = document.all? window.event.keyCode:event.which;
	if(characterCode == 13) {
		return true;
	} else {
		return false;
	}
}

/**
 * get the anchor (#) value from the url
 */
function getAnchorVal(defVal){
    var url = document.location;
    var strippedUrl = url.toString().split("#");
    if(strippedUrl.length > 1 && strippedUrl[1] != ""){
        return strippedUrl[1];
    } else {
        return defVal;
    }
}

/**
 * Update the address parameters for a change in state.
 */
function updateAddressParameters(args) {
	if (typeof window.history.replaceState == 'function') {
		var newUrl = createNewURL(window.location.href, args);
		window.history.replaceState("string", "Title", newUrl);
	}
}

/**
 * create a new url based on the current one but with new arguments.
 */
function createNewURL(url, args, view){
	var newURL = "";

	// Strip empty parameters to declutter query string
	var newargs = {};
	for(var index in args) {
		var value = args[index];
		// check for an empty value or the title parameter - which does not need displaying in address
		if (value && value != "" && index != "title") {
			newargs[index] = value;
		}
	}

	// check for ? otherwise split on #
    var strippedUrl = url.toString().split("?");
    if (strippedUrl.length > 1) {
    	newURL = strippedUrl[0];
    } else {
    	newURL = (url.toString().split("#"))[0];
    }

	// if the view is not passed, reappend the original hash
	// we are just chaning the parameters
	if (view === undefined) {
		var bits = url.toString().split("#");
		if (bits.length > 1) {
			view = bits[1];
		}
	}

    newURL += "?"+Object.toQueryString(newargs);
    newURL += "#"+view;
    return newURL;
}

/**
 * Open a page in the dialog window
 */
function loadDialog(windowName, url, width, height){

    if (width == null){
        width = 570;
    }
    if (height == null){
        height = 510;
    }

    var left = parseInt((screen.availWidth/2) - (width/2));
    var top  = parseInt((screen.availHeight/2) - (height/2));
    var props = "width="+width+",height="+height+",left="+left+",top="+top+",menubar=no,toolbar=no,scrollbars=yes,location=no,status=no,resizable=yes";

    //var props = "width="+width+",height="+height+",left="+left+",top="+top+",menubar=no,toolbar=no,scrollbars=yes,location=no,status=yes,resizable=yes";

	var newWin = "";
    try {
    	newWin = window.open(url, windowName, props);
    	if(newWin == null){
    		alert("<?php echo $LNG->POPUPS_BLOCK; ?>");
    	} else {
    		newWin.focus();
    	}
    } catch(err) {
    	//IE error
    	alert(err.description);
    }

    return newWin;
}

/**
 * When closing a child window, reload the page or change the page as required.
 */
function closeDialog(gotopage){

	if(gotopage === undefined){
		gotopage="issue-list";
	}

	// try to refresh the parent page
	try {
		if (gotopage == "current") {
			window.opener.location.reload(true);
		} else if (gotopage == "conn-neighbour" || gotopage == "conn-net") {
			window.opener.location.reload(true);
		} else {
			var wohl = window.opener.location.href;
			if (wohl)
				var newurl = URL_ROOT + "user.php#" + gotopage;

			if(wohl == newurl){
				window.opener.location.reload(true);
			} else {
				window.opener.location.href = newurl;
			}
		}
	} catch(err) {
		//do nothing
	}

    window.close();
}

/**
 * Set display to 'block' for the item with the given pid
 */
function showPopup(pid){
    $(pid).setStyle({'display':'block'});
}

/**
 * Set display to 'none' for the item with the given pid
 */
function hidePopup(pid){
    $(pid).setStyle({'display':'none'});
}

/**
 * Toggle the given div between display 'block' and 'none'
 */
function toggleDiv(div) {
	var div = document.getElementById(div);
	if (div.style.display == "none") {
		div.style.display = "block";
	} else {
		div.style.display = "none";
	}
}

function toggleArrowDiv(div, arrow) {
	if ( $(div).style.display == "block") {
		$(div).style.display = "none";
		$(arrow).src='<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>';
	} else {
		$(div).style.display = "block";
		$(arrow).src='<?php echo $HUB_FLM->getImagePath("arrow-up-blue.png"); ?>';
	}
}

/**
 * Return the height of the current browser page.
 * Defaults to 500.
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
 * Return the width of the current browser page.
 * Defaults to 500.
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

function getPageOffsetX() {
	var x = 0;

    if (typeof(window.pageXOffset) == 'number') {
		x = window.pageXOffset;
	} else {
        if (document.body && document.body.scrollLeft) {
			x = document.body.scrollLeft;
        } else if (document.documentElement && document.documentElement.scrollLeft) {
			x = document.documentElement.scrollLeft;
		}
	}

	return x;
}

function getPageOffsetY() {
	var y = 0;

    if (typeof(window.pageYOffset) == 'number') {
		y = window.pageYOffset;
	} else {
        if (document.body && document.body.scrollTop) {
			y = document.body.scrollTop;
        } else if (document.documentElement && document.documentElement.scrollTop) {
			y = document.documentElement.scrollTop;
		}
	}

	return y;
}

/**
 * Return the position of the given element in an x/y array.
 */
function getPosition(element) {
	var xPosition = 0;
	var yPosition = 0;

	while(element && element != null) {

		xPosition += element.offsetLeft;
		xPosition -= element.scrollLeft;
		xPosition += element.clientLeft;

		yPosition += element.offsetTop;
		yPosition += element.clientTop;

		// Messes up menu positions in Chrome if this is included.
		// Works fine on all main browsers and Chrome if it is not.
		// yPosition -= element.scrollTop;

		//alert(element.id+" :"+"element.offsetTop: "+element.offsetTop+" element.scrollTop :"+element.scrollTop+" element.clientTop :"+element.clientTop);
		//alert(element.id+" :"+xPosition+":"+yPosition);

		// if the element is a table, get the parentElement as offsetParent is wrong
		if (element.nodeName == 'TABLE') {
			var prevelement = element;
			var nextelement = element.parentNode;
			//find a div with any scroll set.
			while(nextelement != prevelement.offsetParent) {
				yPosition -= nextelement.scrollTop;
				xPosition -= nextelement.scrollLeft;
				nextelement = nextelement.parentNode;
			}
		}

		element = element.offsetParent;
	}

	return { x: xPosition, y: yPosition };
}

/**
 * Display the index page hint for the given type.
 */
function showGlobalHint(type,evt,panelName) {

	$(panelName).style.width="400px";

 	var event = evt || window.event;

	$('globalMessage').innerHTML="";

	if (type == "MainSearch") {
		var text = '<?php echo addslashes($LNG->HEADER_SEARCH_INFO_HINT); ?>';
		$('globalMessage').insert(text);
	} else if (type == "StatsOverviewParticipation") {
		$("globalMessage").insert('<?php echo $LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_HINT; ?>');
	} else if (type == "StatsOverviewViewing") {
		$("globalMessage").insert('<?php echo $LNG->STATS_OVERVIEW_HEALTH_VIEWING_HINT; ?>');
	} else if (type == "StatsOverviewDebate") {
		$("globalMessage").insert('<?php echo $LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_HINT; ?>');
	} else if (type == "StatsDebateContribution") {
		$("globalMessage").insert('<?php echo $LNG->STATS_DEBATE_CONTRIBUTION_HELP; ?>');
	} else if (type == "StatsDebateViewing") {
		$("globalMessage").insert('<?php echo $LNG->STATS_DEBATE_VIEWING_HELP; ?>');
	} else if (type == 'PendingMember') {
		$("globalMessage").insert('<?php echo $LNG->GROUP_JOIN_REQUEST_MESSAGE; ?>');
	}

	showHint(event, panelName, 10, -10);
}

/**
 * Display the explore page hint for the given field type.
 */
function showExploreHint(type,evt,panelName) {

	$(panelName).style.width="400px";

 	var event = evt || window.event;

	$('globalMessage').innerHTML="";

	if (type == "Challenges") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		$('globalMessage').insert(text);
	} else if (type == "Issues") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		$('globalMessage').insert(text);
	} else if (type == "Solutions") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		$('globalMessage').insert(text);
	} else if (type == "Evidence") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		$('globalMessage').insert(text);
	}

	showHint(event, panelName, 10, -10);
}

function showHintText(evt, text) {
 	var event = evt || window.event;
	$('globalMessage').innerHTML="";
	$('globalMessage').insert(text);
	$('hgrhint').style.width="220px";
	showHint(event, 'hgrhint', 10, -10);
}

function positionPopup(evt, popupName, extraX, extraY) {
 	var event = evt || window.event;

	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var panel = document.getElementById(popupName);

	if (panel) {
		if (GECKO) {
			//adjust for it going off the screen.
			var x = event.clientX;
			var y = event.clientY;
			if ( (x+panel.offsetWidth+30) > viewportWidth) {
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
		}
		else if (NS) {
			//adjust for it going off the screen right or bottom.
			var x = event.pageX;
			var y = event.pageY;
			if ( (x+panel.offsetWidth+30) > viewportWidth) {
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
		}
		else if (IE || IE5) {
			//adjust for it going off the screen right or bottom.
			var x = event.x;
			var y = event.clientY;
			if ( (x+panel.offsetWidth+30) > viewportWidth) {
				x = x-(panel.offsetWidth+30);
			} else {
				x = x+10;
			}
			if ( (y+panel.offsetHeight) > viewportHeight) {
				y = y-50;
			} else {
				y = y-5;
			}

			document.all[popupName].style.left = x+extraX+ document.documentElement.scrollLeft+"px";
			document.all[popupName].style.top = y+extraY+ document.documentElement.scrollTop+"px";
		}
	}
	return false;
}

/**
 * Show a rollover hint popup div (when multiple lines needed).
 */
function showHint(evt, popupName, extraX, extraY) {
	hideHints();

 	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var panel = document.getElementById(popupName);

	if (GECKO) {

		//adjust for it going off the screen right or bottom.
		var x = event.clientX;
		var y = event.clientY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+10;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}

		if (panel) {
			panel.style.left = x+extraX+window.pageXOffset+"px";
			panel.style.top = y+extraY+window.pageYOffset+"px";
			panel.style.background = "#FFFED9";
			panel.style.visibility = "visible";
			openpopups.push(popupName);
		}
	}
	else if (NS) {
		//adjust for it going off the screen right or bottom.
		var x = event.pageX;
		var y = event.pageY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
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
		document.layers[popupName].visibility = "show";
		openpopups.push(popupName);
	}
	else if (IE || IE5) {
		//adjust for it going off the screen right or bottom.
		var x = event.x;
		var y = event.clientY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
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
		document.all[popupName].style.visibility = "visible";
		openpopups[openpopups.length] = popupName;
	}
	return false;
}

function hideHints() {
	var popupname;
	for (var i = 0; i < openpopups.length; i++) {
		popupname = new String (openpopups[i]);
		if (popupname) {
			var popup = document.getElementById(popupname);
			if (popup) {
				popup.style.visibility = "hidden";
			}
		}
	}
	openpopups = new Array();
	return;
}

var popupTimerHandleArray = new Array();
var popupArray = new Array();

function showBox(div) {
	hideBoxes();

    if (popupTimerHandleArray[div] != null) {
        clearTimeout(popupTimerHandleArray[div]);
        popupTimerHandleArray[div] = null;
    }

    var divObj = document.getElementById(div);
    divObj.style.display = 'block';
    popupArray.push(div);
}

function hideBox(div) {
    var popupTimerHandle = setTimeout("reallyHideBox('" + div + "');", 250);
    popupTimerHandleArray[div] = popupTimerHandle;
}

function reallyHideBox(div) {
    var divObj = document.getElementById(div);
    divObj.style.display = 'none';
}

function hideBoxes() {
	var popupname;
	for (var i = 0; i < popupArray.length; i++) {
		popupname = new String (popupArray[i]);
		var popup = document.getElementById(popupname);
		if (popup) {
			popup.style.display = "none";
		}
	}
	popupArray = new Array();
	return;
}

function textAreaCancel() {
	$('prompttext').style.display = "none";
	$('prompttext').update("");
}

function textAreaPrompt(messageStr, text, connid, handler, refresher, width, height) {

	$('prompttext').innerHTML="";
	if (width == undefined) {
		width = 400;
	}
	if (height == undefined) {
		height = 250;
	}
	$('prompttext').style.width = width+"px";
	$('prompttext').style.height = height+"px";

	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var x = (viewportWidth-width)/2;
	var y = (viewportHeight-height)/2;
	$('prompttext').style.left = x+getPageOffsetX()+"px";
	$('prompttext').style.top = y+getPageOffsetY()+"px";

	var textarea1 = new Element('textarea', {'id':'messagetextarea','rows':'7','style':'color: black; width:390px; border: 1px solid gray; padding: 3px; overflow:hidden'});
	textarea1.value=text;

	if (connid != "") {
		var buttonOK = new Element('input', { 'style':'clear: both;margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>'});
		Event.observe(buttonOK,'click', function() {
			eval( refresher + '("'+connid+'","'+textarea1.value+'","'+handler+'")' );
			textAreaCancel();
		});
	}

    var buttonCancel = new Element('input', { 'style':'margin-left: 5px; margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_CANCEL; ?>'});
	Event.observe(buttonCancel,'click', textAreaCancel);

	$('prompttext').insert('<h2>'+messageStr+'</h2>');
	$('prompttext').insert(textarea1);
	if (connid != "") {
		$('prompttext').insert(buttonOK);
	}
	$('prompttext').insert(buttonCancel);
	$('prompttext').style.display = "block";
}

function fadeMessage(messageStr) {
	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var x = (viewportWidth-300)/2;
	var y = (viewportHeight-100)/2;
	$('message').style.left = x+getPageOffsetX()+"px";
	$('message').style.top = y+getPageOffsetY()+"px";
	$('message').update("");
	$('message').update(messageStr);
	$('message').style.display = "block";
	fadein();
    var fade=setTimeout("fadeout()",2500);
}

function fadein(){
    new Effect.Opacity("message", {duration:1.0, from:0.0, to:1.0});
}

function fadeout(){
    new Effect.Opacity("message", {duration:1.5, from:1.0, to:0.0});
}

function getLoading(infoText){
    var loadDiv = new Element("div",{'class':'loading'});
    loadDiv.insert("<img src='<?php echo $HUB_FLM->getImagePath('ajax-loader.gif'); ?>'/>");
    loadDiv.insert("<br/>"+infoText);
    return loadDiv;
}

function getLoadingLine(infoText){
    var loadDiv = new Element("div",{'class':'loading'});
    loadDiv.insert("<img src='<?php echo $HUB_FLM->getImagePath('ajax-loader.gif'); ?>' />");
    loadDiv.insert("&nbsp;"+infoText);
    return loadDiv;
}

function nl2br (dataStr) {
	return dataStr.replace(/(\r\n|\r|\n)/g, "<br />");
}

/**
 * http://www.456bereastreet.com/archive/201105/validate_url_syntax_with_javascript/
 * MB: I modified the original as I could not get it to work as it was.
 */
function isValidURI(uri) {
    if (!uri) uri = "";

	//SERVER SIDE URL VALIDATION
	//at some point the two should match!
	//'protocol' => '((http|https|ftp|mailto)://)',
	//'access' => '(([a-z0-9_]+):([a-z0-9-_]*)@)?',
	//'sub_domain' => '(([a-z0-9_-]+\.)*)',
	//'domain' => '(([a-z0-9-]{2,})\.)',
	//'tld' =>'([a-z0-9_]+)',
	//'port'=>'(:(\d+))?',
	//'path'=>'((/[a-z0-9-_.%~]*)*)?',
	//'query'=>'(\?[^? ]*)?'

   	var schemeRE = /^([-a-z0-9]|%[0-9a-f]{2})*$/i;

   	var authorityRE = /^([-a-z0-9.]|%[0-9a-f]{2})*$/i;

   	var pathRE = /^([-a-z0-9._~:@!$&'()*+,;=\//#]|%[0-9a-f]{2})*$/i;

    var qqRE = /^([-a-z0-9._~:@!$&'\[\]()*+,;=?\/]|%[0-9a-f]{2})*$/i;
    var qfRE = /^([-a-z0-9._~:@!$&#'\[\]()*+,;=?\/]|%[0-9a-f]{2})*$/i;

    var parser = /^(?:([^:\/?]+):)?(?:\/\/([^\/?]*))?([^?]*)(?:\?([^\#]*))?(?:(.*))?/;

    var result = uri.match(parser);

    var scheme    = result[1] || null;
    var authority = result[2] || null;
    var path      = result[3] || null;
    var query     = result[4] || null;
    var fragment  = result[5] || null;

    //alert("scheme="+scheme);
    //alert("authority="+authority);
    //alert("path="+path);
    //alert("query="+query);
    //alert("fragment="+fragment);

    if (!scheme || !scheme.match(schemeRE)) {
    	//alert('scheme failed');
        return false;
    }

    if (!authority || !authority.match(authorityRE)) {
    	//alert('authority failed');
        return false;
    }
    if (path != null && !path.match(pathRE)) {
    	//alert('path failed');
        return false;
    }
    if (query && !query.match(qqRE)) {
    	//alert('query failed');
        return false;
    }
    if (fragment && !fragment.match(qfRE)) {
    	//alert('fragment failed');
        return false;
    }

    return true;
}

/**
 * http://www.wohill.com/javascript-regular-expression-for-url-check/
 */
function urlCheck(str) {
	var v = new RegExp();
	v.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
	if (!v.test(str)) {
		return false;
	}
	return true;
}

/**
 * Add the given connection object to the given map.
 * @param c the connection to add (json of connection returned from server).
 * @param map the name of the map applet to add the data to
 */
function addConnectionToNetworkMap(c, map) {

	var fN = c.from[0].cnode;
	var tN = c.to[0].cnode;

	var fnRole = c.fromrole[0].role;
	var fNNodeImage = "";
	if (fN.imagethumbnail != null && fN.imagethumbnail != "") {
		fNNodeImage = URL_ROOT + fN.imagethumbnail;
	} else if (fN.role[0].role.image != null && fN.role[0].role.image != "") {
		fNNodeImage = URL_ROOT + fN.role[0].role.image;
	}

	var tnRole = c.torole[0].role;
	var tNNodeImage = "";
	if (tN.imagethumbnail != null && tN.imagethumbnail != "") {
		tNNodeImage = URL_ROOT + tN.imagethumbnail;
	} else if (tN.role[0].role.image != null && tN.role[0].role.image != "") {
		tNNodeImage = URL_ROOT + tN.role[0].role.image;
	}
	var fromRole = fN.role[0].role.name;
	var toRole = tN.role[0].role.name;

	var fromDesc = "";
	if (fN.description) {
		fromDesc = fN.description;
	}
	var toDesc = "";
	if (tN.description) {
		toDesc = tN.description;
	}
	var fromName = fN.name;
	var toName = tN.name;

	// Get HEX for From Role
	var fromHEX = "";
	if (fromRole == 'Challenge') {
		fromHEX = challengebackpale;
	} else if (fromRole == 'Issue') {
		fromHEX = issuebackpale;
	} else if (fromRole == 'Solution') {
		fromHEX = solutionbackpale;
	} else if (fromRole == 'Pro') {
		fromHEX = probackpale;
	} else if (fromRole == 'Con') {
		fromHEX = conbackpale;
	} else if (fromRole == 'Argument') {
		fromHEX = evidencebackpale;

	} else {
		fromHEX = plainbackpale;
	}

	// Get HEX for To Role
	var toHEX = "";
	if (toRole == 'Challenge') {
		toHEX = challengebackpale;
	} else if (toRole == 'Issue') {
		toHEX = issuebackpale;
	} else if (toRole == 'Solution') {
		toHEX = solutionbackpale;
	} else if (toRole == 'Pro') {
		toHEX = probackpale;
	} else if (toRole == 'Con') {
		toHEX = conbackpale;
	} else if (toRole == 'Argument') {
		toHEX = evidencebackpale;
	} else {
		toHEX = plainbackpale;
	}

	fromRole = getNodeTitleAntecedence(fromRole, false);
	toRole = getNodeTitleAntecedence(toRole, false);

	//create from & to nodes
	$(map).addNode(fN.nodeid, fromRole+": "+fromName, fromDesc, fN.users[0].user.userid, fN.creationdate, fN.otheruserconnections, fNNodeImage, fN.users[0].user.thumb, fN.users[0].user.name, fromRole, fromHEX);
	$(map).addNode(tN.nodeid, toRole+": "+toName, toDesc, tN.users[0].user.userid, tN.creationdate, tN.otheruserconnections, tNNodeImage, tN.users[0].user.thumb, tN.users[0].user.name, toRole, toHEX);

	// add edge/conn
	var fromRoleName = fromRole;
	if (c.fromrole[0].role) {
		fromRoleName = c.fromrole[0].role.name;
	}

	var toRoleName = toRole;
	if (c.torole[0].role) {
		toRoleName = c.torole[0].role.name;
	}

	var linklabelname = c.linktype[0].linktype.label;
	linklabelname = getLinkLabelName(fN.role[0].role.name, tN.role[0].role.name, linklabelname);

	$(map).addEdge(c.connid, fN.nodeid, tN.nodeid, c.linktype[0].linktype.grouplabel, linklabelname, c.creationdate, c.userid, c.users[0].user.name, fromRoleName, toRoleName);
}

/**
 * Get the language version of the link label that should be displayed to the users.
 * Allows for local varients and internationalization.
 */
function getLinkLabelName(fromNodeTypeName, toNodeTypeName, linkName) {

	/* this function was using from and to node types to confirm links,
	but the model was extended in such a way that this is no longer possible,
	so it is now a straight mapping.
	*/

	if (linkName == '<?php echo $CFG->LINK_ISSUE_CHALLENGE; ?>') {
		return '<?php echo $LNG->LINK_ISSUE_CHALLENGE; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>') {
		return '<?php echo $LNG->LINK_SOLUTION_ISSUE; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_ISSUE_SOLUTION; ?>') {
		return '<?php echo $LNG->LINK_ISSUE_SOLUTION; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_COMMENT_NODE; ?>') {
		return '<?php echo $LNG->LINK_COMMENT_NODE; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_PRO_SOLUTION; ?>') {
		return '<?php echo $LNG->LINK_PRO_SOLUTION; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_CON_SOLUTION; ?>') {
		return '<?php echo $LNG->LINK_CON_SOLUTION; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_ISSUE_ISSUE; ?>') {
		return '<?php echo $LNG->LINK_ISSUE_ISSUE; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_SOLUTION_SOLUTION; ?>') {
		return '<?php echo $LNG->LINK_SOLUTION_SOLUTION; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_IDEA_NODE; ?>') {
		return '<?php echo $LNG->LINK_IDEA_NODE; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>') {
		return '<?php echo $LNG->LINK_NODE_SEE_ALSO; ?>';
	} else if (linkName == '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>') {
		return '<?php echo $LNG->LINK_COMMENT_BUILT_FROM; ?>';
	}

	return linkName;
}

/**
 * Return the node type text to be placed before the node title
 * @param nodetype the node type for node to return the text for
 * @param withColon true if you want a colon adding after the node type name, else false.
 */
function getNodeTitleAntecedence(nodetype, withColon) {
	if (withColon == undefined) {
		withColon = true;
	}

	var title=nodetype;

	if (nodetype == 'Challenge') {
		title = "<?php echo $LNG->CHALLENGE_NAME; ?>";
	} else if (nodetype == 'Issue') {
		title = "<?php echo $LNG->ISSUE_NAME; ?>";
	} else if (nodetype == 'Solution') {
		title = "<?php echo $LNG->SOLUTION_NAME; ?>";
	} else if (nodetype == 'Comment') {
		title = "<?php echo $LNG->CHAT_NAME; ?>";
	} else if (nodetype == 'Idea') {
		title = "<?php echo $LNG->COMMENT_NAME; ?>";
	} else if (nodetype == 'Pro') {
		title = "<?php echo $LNG->PRO_NAME; ?>";
	} else if (nodetype == 'Con') {
		title = "<?php echo $LNG->CON_NAME; ?>";
	} else if (nodetype == 'News') {
		title = "<?php echo $LNG->NEWS_NAME; ?>";
	} else if (nodetype == 'Map') {
		title = "<?php echo $LNG->MAP_NAME; ?>";
	} else if (nodetype == 'Argument') {
		title = "<?php echo $LNG->ARGUMENT_NAME; ?>";
	}

	if (withColon) {
		title += ": ";
	}

	return title;
}

function gotoHomeList(type) {
	var reqUrl = '<?php print($CFG->homeAddress);?>index.php';
	window.location.href = reqUrl;
	if (CONTEXT == 'global') {
		window.location.reload(true);
	}
}

function alphanodesort(a, b) {
	var nameA=a.cnode.name.toLowerCase();
	var nameB=b.cnode.name.toLowerCase();
	if (nameA < nameB) {
		return -1;
	}
	if (nameA > nameB) {
		return 1;
	}
	return 0 ;
}

function creationdatenodesortasc(a, b) {
	var nameA=a.cnode.creationdate;
	var nameB=b.cnode.creationdate;
	if (nameA < nameB) {
		return -1;
	}
	if (nameA > nameB) {
		return 1;
	}
	return 0 ;
}

function creationdatenodesortdesc(a, b) {
	var nameA=a.cnode.creationdate;
	var nameB=b.cnode.creationdate;
	if (nameA > nameB) {
		return -1;
	}
	if (nameA < nameB) {
		return 1;
	}
	return 0 ;
}

function modedatenodesortasc(a, b) {
	var nameA=a.cnode.modificationdate;
	var nameB=b.cnode.modificationdate;
	if (nameA < nameB) {
		return -1;
	}
	if (nameA > nameB) {
		return 1;
	}
	return 0 ;
}

function modedatenodesortdesc(a, b) {
	var nameA=a.cnode.modificationdate;
	var nameB=b.cnode.modificationdate;
	if (nameA > nameB) {
		return -1;
	}
	if (nameA < nameB) {
		return 1;
	}
	return 0 ;
}

/**
 * Sort by node type in reverse alphabetical order by connections node type.
 */
function connectiontypenodesort(a, b) {
	var typeA = a.cnode.role[0].role.name.toLowerCase();
	var connA = a.cnode.connection;
	if (connA) {
		if (a.cnode.nodeid == connA.from[0].cnode.nodeid) {
			typeA = connA.fromrole[0].role.name.toLowerCase();
		} else {
			typeA = connA.torole[0].role.name.toLowerCase();
		}
	}
	var typeB = b.cnode.role[0].role.name.toLowerCase();
	var connB = b.cnode.connection;
	if (connB) {
		if (b.cnode.nodeid == connB.from[0].cnode.nodeid) {
			typeB = connB.fromrole[0].role.name.toLowerCase();
		} else {
			typeB = connB.torole[0].role.name.toLowerCase();
		}
	}
	if (typeA > typeB) {
		return -1;
	}
	if (typeA < typeB) {
		return 1;
	}
	return 0;
}

/**
 * Sort by node name after a sort by connection node type has been done.
 * @see connectiontypenodesort
 */
function connectiontypealphanodesort(a, b) {
	var nameA=a.cnode.name.toLowerCase();
	var nameB=b.cnode.name.toLowerCase();

	var typeA = a.cnode.role[0].role.name.toLowerCase();
	var connA = a.cnode.connection;
	if (connA) {
		if (a.cnode.nodeid == connA.from[0].cnode.nodeid) {
			typeA = connA.fromrole[0].role.name.toLowerCase();
		} else {
			typeA = connA.torole[0].role.name.toLowerCase();
		}
	}
	var typeB = b.cnode.role[0].role.name.toLowerCase();
	var connB = b.cnode.connection;
	if (connB) {
		if (b.cnode.nodeid == connB.from[0].cnode.nodeid) {
			typeB = connB.fromrole[0].role.name.toLowerCase();
		} else {
			typeB = connB.torole[0].role.name.toLowerCase();
		}
	}

	if (typeA == typeB) {
		if (nameA < nameB) {
			return -1;
		} else if (nameA > nameB) {
			return 1;
		}
	}
	return 0;
}

function removeHTMLTags(htmlString) {
	var cleanString = "";
	if(htmlString){
		var mydiv = document.createElement("div");
		mydiv.innerHTML = htmlString;
		if (document.all) {
			cleanString = mydiv.innerText;
		} else {
			cleanString = mydiv.textContent;
		}
  	}

  	return cleanString.trim();
}

/**
 * Used to switch a textarea between plain text and full HTML editor box.
 */
function switchCKEditorMode(link, divname, editorname) {
	if ($(divname).style.clear == 'none') {
		CKEDITOR.replace(editorname, {
			on : { instanceReady : function( ev ) { this.focus(); } }
		} );

		$(divname).style.clear = 'both';
		link.innerHTML = '<?php echo $LNG->FORM_DESC_PLAIN_TEXT_LINK; ?>'
		link.title = '<?php echo $LNG->FORM_DESC_PLAIN_TEXT_HINT; ?>';
	} else {
		var ans = confirm("<?php echo $LNG->FORM_DESC_HTML_SWITCH_WARNING; ?>");
		if (ans == true) {
			if (CKEDITOR.instances[editorname]) {
				CKEDITOR.instances[editorname].destroy();
			}
			$(divname).style.clear = 'none';
			link.innerHTML = '<?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?>';
			link.title = '<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>';
			$(editorname).value = removeHTMLTags($(editorname).value);
		}
	}
}

function htmlspecialchars_decode (string, quote_style) {
  // http://kevin.vanzonneveld.net
  // +   original by: Mirek Slugen
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Mateusz "loonquawl" Zalega
  // +      input by: ReverseSyntax
  // +      input by: Slawomir Kaniecki
  // +      input by: Scott Cariss
  // +      input by: Francois
  // +   bugfixed by: Onno Marsman
  // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Ratheous
  // +      input by: Mailfaker (http://www.weedem.fr/)
  // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
  // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: htmlspecialchars_decode("<p>this -&gt; &quot;</p>", 'ENT_NOQUOTES');
  // *     returns 1: '<p>this -> &quot;</p>'
  // *     example 2: htmlspecialchars_decode("&amp;quot;");
  // *     returns 2: '&quot;'
  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined') {
    quote_style = 2;
  }
  string = string.toString().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      } else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/&#0*39;/g, "'"); // PHP does not currently escape if more than one 0, but it should
    // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
  }
  if (!noquotes) {
    string = string.replace(/&quot;/g, '"');
  }
  // Put this in last place to avoid escape being double-decoded
  string = string.replace(/&amp;/g, '&');

  return string;
}

/**
 * Replace reserved chars with their XML entity equivalents
 *
 * @param string xmlStr
 * @return string
 */
function parseToXML(xmlStr) {

    xmlStr = xmlStr.replace(/&/g,'&amp;');
    xmlStr = xmlStr.replace(/</g,'&lt;');
    xmlStr = xmlStr.replace(/>/g,'&gt;');
    xmlStr = xmlStr.replace(/"/g,'&quot;');
    xmlStr = xmlStr.replace(/'/g,'&#39;');
    return xmlStr;
}

/**
 * Audit a testing action
 * @param itemid the id of any associated item being tested
 * @param testelementid the id of the test element being audited
 * @param testevent the event that triggered the audit
 * @param state and meta data wishing to be stored as part of the audit,
 * @param handler a function object to run once the auditing has returned (optional).
 * such as the state of the audited element.
 */
function auditTesting(itemid, testelementid, testevent, state, handler) {
	var args = {};
	args["trialname"] = '<?php echo $CFG->TEST_TRIAL_NAME; ?>';
    args['itemid'] = itemid;
    args['testelementid'] = testelementid;
    args['event'] = testevent;
    args['state'] = parseToXML(state);

	var reqUrl = SERVICE_ROOT + "&method=audittesting&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			} else {
				if (handler) {
					handler();
				}
				//alert("OK");
			}
		}
	});

	return;
}

/**
 * Audit a node was viewed
 * @param nodeid the id of the node that was viewed
 * @param viewtype the label denoting where it was viewed
 */
function auditNodeView(nodeid, viewtype) {
	var args = {};
	args["nodeid"] = nodeid;
    args['viewtype'] = viewtype;

	var reqUrl = SERVICE_ROOT + "&method=auditnodeview&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			} else {
				//alert("OK");
			}
		}
	});

	return;
}

function auditAlertClicked(nodeid, alerttype) {
	var state = NODE_ARGS['nodeid']; // mapid
	auditTesting(nodeid, alerttype, 'alertclicked', state);
}

var scriptLoaded = null;
var exploreutils = null;

function unloadDetailsScripts() {
	if (scriptLoaded != null) {
		scriptLoaded.removeScriptTag();
	}
	if (exploreutils != null) {
		exploreutils.removeScriptTag();
	}
}

function closeNodeDetailsDiv() {
	if ($('mapdetailsdiv')) {
		$('mapdetailsdiv').style.display='none';
		unloadDetailsScripts();
	}
}

function onNodeDetailsDivMouseDown(e) {
	if ($('mapdetailsdiv')) {
		$('mapdetailsdiv').startdrag = true;
		$('mapdetailsdiv').oldx = e.clientX;
		$('mapdetailsdiv').oldy = e.clientY;
	}
}

function onNodeDetailsDivMouseMove(e) {
	if ($('mapdetailsdiv')) {
		if ($('mapdetailsdiv').startdrag) {
			var movey = e.clientY-mapdetailsdiv.oldy;
			var movex = e.clientX-mapdetailsdiv.oldx;
			$('mapdetailsdiv').style.top = ($('mapdetailsdiv').offsetTop + movey)+"px";
			$('mapdetailsdiv').style.left = ($('mapdetailsdiv').offsetLeft + movex)+"px";
			$('mapdetailsdiv').oldx = e.clientX;
			$('mapdetailsdiv').oldy = e.clientY;
		}
	}
}

function onNodeDetailsDivMouseUp(e) {
	if ($('mapdetailsdiv')) {
		$('mapdetailsdiv').startdrag = false;
	}
}

/**
 * Display explore page in a popup (called by maps).
 */
function viewNodeDetailsDiv(nodeid, nodetype, orinode, evt, x, y) {
	if (nodetype == "Map") {
		loadDialog('map', URL_ROOT+"map.php?id="+nodeid, width,height);
	} else {
		var panel = $('mapdetailsdiv');
		if (panel) {
			var reqUrl = SERVICE_ROOT + "&method=getnode&style=long&nodeid=" + encodeURIComponent(nodeid);
			//alert(reqUrl);
			new Ajax.Request(reqUrl, { method:'post',
				onSuccess: function(transport){
					var json = null;
					try {
						json = transport.responseText.evalJSON();
						//alert(transport.responseText);
					} catch(e) {
						alert(e);
					}
					if(json.error){
						alert(json.error[0].message);
						return;
					}

					var node = json.cnode[0];
					loadSlimExplorePanel(nodeid, nodetype, node, evt, x, y);
				}
			});
		} else {
			var width = getWindowWidth();
			var height = getWindowHeight()-20;
			viewNodeDetails(nodeid, nodetype, width, height);
		}
	}
}

/**
 * Display the in-map slim explore page.
 */
function loadSlimExplorePanel(nodeid, nodetype, node, evt, x, y) {
	nodeObj = node;
	var panel = $('mapdetailsdiv');

	auditNodeView(nodeid, 'exploreslim');

	exploreutils = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/exploreutils.js.php"); ?>');
	exploreutils.buildScriptTag();
	exploreutils.addScriptTag();

	var reqUrl = URL_ROOT + "explore-slim.php?nodetype="+nodetype+"&nodeid="+nodeid;
	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var data =  transport.responseText;
			//console.log(data);
			panel.innerHTML = data;

			// only use as initial position. After that stay where is it as can be dragged.
			if (x && y && panel.style.left == "-1px" && panel.style.top == "-1px") {
				panel.style.left = x+"px";
				panel.style.top = y+"px";
			}
			$('mapdetailsdiv').style.display='block';

			if (nodetype == 'Challenge') {
				scriptLoaded = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/slim/challengenode.js.php"); ?>');
				scriptLoaded.buildScriptTag();
				scriptLoaded.addScriptTag();
			} else if (nodetype == 'Issue') {
				scriptLoaded = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/slim/issuenode.js.php"); ?>');
				scriptLoaded.buildScriptTag();
				scriptLoaded.addScriptTag();
			} else if (nodetype == 'Solution') {
				scriptLoaded = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/slim/solutionnode.js.php"); ?>');
				scriptLoaded.buildScriptTag();
				scriptLoaded.addScriptTag();
			} else if (nodetype == 'Pro') {
				scriptLoaded = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/slim/pronode.js.php"); ?>');
				scriptLoaded.buildScriptTag();
				scriptLoaded.addScriptTag();
			} else if (nodetype == 'Con') {
				scriptLoaded = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/slim/connode.js.php"); ?>');
				scriptLoaded.buildScriptTag();
				scriptLoaded.addScriptTag();
			} else if (nodetype == 'Argument') {
				scriptLoaded = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/slim/evidencenode.js.php"); ?>');
				scriptLoaded.buildScriptTag();
				scriptLoaded.addScriptTag();
			} else if (nodetype == 'Idea') {
				scriptLoaded = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/slim/commentnode.js.php"); ?>');
				scriptLoaded.buildScriptTag();
				scriptLoaded.addScriptTag();
			}
		}
	});
}

/**
 * Display explore page in a popup (called by maps).
 */
function viewNodeDetails(nodeid, nodetype, width, height) {
	if (nodetype == "Map") {
		loadDialog('map', URL_ROOT+"map.php?id="+nodeid, width,height);
	} else {
		loadDialog('details', URL_ROOT+"explore.php?id="+nodeid, width,height);
	}
}

/**** ALERT HELPER FUNCTIONS ****/

function getAlertName(alerttype) {
	var alertName = "";
	switch(alerttype) {
		case '<?php echo $CFG->ALERT_UNSEEN_BY_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_UNSEEN_BY_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_RESPONSE_TO_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_RESPONSE_TO_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_UNRATED_BY_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_UNRATED_BY_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_LURKING_USER; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_LURKING_USER); ?>';
			break;
		case '<?php echo $CFG->ALERT_INACTIVE_USER; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_INACTIVE_USER); ?>';
			break;
		case '<?php echo $CFG->ALERT_MATURE_ISSUE; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_MATURE_ISSUE); ?>';
			break;
		case '<?php echo $CFG->ALERT_IMMATURE_ISSUE; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_IMMATURE_ISSUE); ?>';
			break;
		case '<?php echo $CFG->ALERT_IGNORED_POST; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_IGNORED_POST); ?>';
			break;
		case '<?php echo $CFG->ALERT_INTERESTING_TO_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_INTERESTING_TO_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_HOT_POST; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_HOT_POST); ?>';
			break;
		case '<?php echo $CFG->ALERT_ORPHANED_IDEA; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_ORPHANED_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_EMERGING_WINNER; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_EMERGING_WINNER); ?>';
			break;
		case '<?php echo $CFG->ALERT_CONTENTIOUS_ISSUE; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_CONTENTIOUS_ISSUE); ?>';
			break;
		case '<?php echo $CFG->ALERT_INCONSISTENT_SUPPORT; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_INCONSISTENT_SUPPORT); ?>';
			break;
		case '<?php echo $CFG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE); ?>';
			break;
		case '<?php echo $CFG->ALERT_PEOPLE_WHO_AGREE_WITH_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_PEOPLE_WHO_AGREE_WITH_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_INTERESTING_TO_ME; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_INTERESTING_TO_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_CONTROVERSIAL_IDEA; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_CONTROVERSIAL_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_GONE_INACTIVE; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_USER_GONE_INACTIVE); ?>';
			break;
		case '<?php echo $CFG->ALERT_WELL_EVALUATED_IDEA; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_WELL_EVALUATED_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_POORLY_EVALUATED_IDEA; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_POORLY_EVALUATED_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_RATING_IGNORED_ARGUMENT; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_RATING_IGNORED_ARGUMENT); ?>';
			break;
		case '<?php echo $CFG->ALERT_UNSEEN_RESPONSE; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_UNSEEN_RESPONSE); ?>';
			break;
		case '<?php echo $CFG->ALERT_UNSEEN_COMPETITOR; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_UNSEEN_COMPETITOR); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_IGNORED_COMPETITORS; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_USER_IGNORED_COMPETITORS); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_IGNORED_ARGUMENTS; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_USER_IGNORED_ARGUMENTS); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_IGNORED_RESPONSES; ?>':
			alertName = '<?php echo addslashes($LNG->ALERT_USER_IGNORED_RESPONSES); ?>';
			break;
	}
	return alertName;
}

function getAlertHint(alerttype) {
	var alertHint = "";
	switch(alerttype) {
		case '<?php echo $CFG->ALERT_UNSEEN_BY_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_UNSEEN_BY_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_RESPONSE_TO_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_RESPONSE_TO_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_UNRATED_BY_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_UNRATED_BY_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_LURKING_USER; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_LURKING_USER); ?>';
			break;
		case '<?php echo $CFG->ALERT_INACTIVE_USER; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_INACTIVE_USER); ?>';
			break;
		case '<?php echo $CFG->ALERT_MATURE_ISSUE; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_MATURE_ISSUE); ?>';
			break;
		case '<?php echo $CFG->ALERT_IMMATURE_ISSUE; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_IMMATURE_ISSUE); ?>';
			break;
		case '<?php echo $CFG->ALERT_IGNORED_POST; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_IGNORED_POST); ?>';
			break;
		case '<?php echo $CFG->ALERT_INTERESTING_TO_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_INTERESTING_TO_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_INTERESTING_TO_PEOPLE_LIKE_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_SUPPORTED_BY_PEOPLE_LIKE_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_HOT_POST; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_HOT_POST); ?>';
			break;
		case '<?php echo $CFG->ALERT_ORPHANED_IDEA; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_ORPHANED_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_EMERGING_WINNER; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_EMERGING_WINNER); ?>';
			break;
		case '<?php echo $CFG->ALERT_CONTENTIOUS_ISSUE; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_CONTENTIOUS_ISSUE); ?>';
			break;
		case '<?php echo $CFG->ALERT_INCONSISTENT_SUPPORT; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_INCONSISTENT_SUPPORT); ?>';
			break;
		case '<?php echo $CFG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_PEOPLE_WITH_INTERESTS_LIKE_MINE); ?>';
			break;
		case '<?php echo $CFG->ALERT_PEOPLE_WHO_AGREE_WITH_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_PEOPLE_WHO_AGREE_WITH_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_INTERESTING_TO_ME; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_INTERESTING_TO_ME); ?>';
			break;
		case '<?php echo $CFG->ALERT_CONTROVERSIAL_IDEA; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_CONTROVERSIAL_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_GONE_INACTIVE; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_USER_GONE_INACTIVE); ?>';
			break;
		case '<?php echo $CFG->ALERT_WELL_EVALUATED_IDEA; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_WELL_EVALUATED_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_POORLY_EVALUATED_IDEA; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_POORLY_EVALUATED_IDEA); ?>';
			break;
		case '<?php echo $CFG->ALERT_RATING_IGNORED_ARGUMENT; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_RATING_IGNORED_ARGUMENT); ?>';
			break;
		case '<?php echo $CFG->ALERT_UNSEEN_RESPONSE; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_UNSEEN_RESPONSE); ?>';
			break;
		case '<?php echo $CFG->ALERT_UNSEEN_COMPETITOR; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_UNSEEN_COMPETITOR); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_IGNORED_COMPETITORS; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_USER_IGNORED_COMPETITORS); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_IGNORED_ARGUMENTS; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_USER_IGNORED_ARGUMENTS); ?>';
			break;
		case '<?php echo $CFG->ALERT_USER_IGNORED_RESPONSES; ?>':
			alertHint = '<?php echo addslashes($LNG->ALERT_HINT_USER_IGNORED_RESPONSES); ?>';
			break;
	}
	return alertHint;
}

/**
 * Pass in a file extension and return the audio/video type required for a html object setting.
 * string @filetype mjust the file extension of the mvoie or audio wanting to be played.
 * Currently done serverside - so this is not used.
 */
function getMediaMimeType(filetype){
	var mimetype = '';
	switch(filetype) {
		case 'mp4':
		case 'm4v':
			mimetype = 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"';
			break;
		case 'ogg':
		case 'ogv':
			mimetype = 'video/ogg; codecs="theora, vorbis"';
			break;
		case 'webm':
			mimetype = 'video/webm; codecs="vp8, vorbis"';
			break;
		case 'mp3':
			mimetype = 'audio/mpeg';
			break;
	}
	return mimetype;
}

/**
 * string @mimetype the mimetype of the audio or video e.g. audio/mpeg
 * string @container, video/audio
 */
function browserMediaSupport(mimetype, container) {
	var elem = document.createElement(container);
	if(typeof elem.canPlayType == 'function'){
		var playable = elem.canPlayType(mimetype);
		if((playable.toLowerCase() == 'maybe') ||(playable.toLowerCase() == 'probably')){
			return true;
		}
	}
	return false;
}

/**
 * Take a time in seconds and output 'minutes : seconds'
 */
function formatMovieTime(seconds) {
	minutes = Math.floor(seconds / 60);
	minutes = (minutes >= 10) ? minutes : "0" + minutes;
	seconds = Math.floor(seconds % 60);
	seconds = (seconds >= 10) ? seconds : "0" + seconds;
	return minutes + ":" + seconds;
}
