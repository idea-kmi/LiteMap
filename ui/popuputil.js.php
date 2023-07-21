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
 * Display the form hint for the given field type.
 * Returns true if the hint was found and displayed else false.
 */
function showFormHint(type, evt, panelName, extra) {

 	var event = evt || window.event;

	$("resourceMessage").innerHTML="";

	//Challenge
	if (type == "ChallengeSummary") {
		$("resourceMessage").insert('<?php echo $LNG->CHALLENGE_SUMMARY_FORM_HINT; ?>');
	} else if (type == "ChallengeDesc") {
		$("resourceMessage").insert('<?php echo $LNG->CHALLENGE_DESC_FORM_HINT; ?>');
 	} else if (type == "ChallengeReason") {
		$("resourceMessage").insert('<?php echo $LNG->CHALLENGE_REASON_FORM_HINT; ?>'+extra);
	} else if (type == "Challenges") {
		$("resourceMessage").insert('<?php echo $LNG->CHALLENGES_FORM_HINT; ?>'+extra);

	// Issues
	} else if (type == "IssueSummary") {
		$("resourceMessage").insert('<?php echo $LNG->ISSUE_SUMMARY_FORM_HINT; ?>');
	} else if (type == "IssueDesc") {
		$("resourceMessage").insert('<?php echo $LNG->ISSUE_DESC_FORM_HINT; ?>');
	} else if (type == "IssueChallenges") {
		$("resourceMessage").insert('<?php echo $LNG->ISSUE_CHALLENGES_FORM_HINT; ?>');
	} else if (type == "IssueReason") {
		$("resourceMessage").insert('<?php echo $LNG->ISSUE_REASON_FORM_HINT; ?>'+extra);
	} else if (type == "IssueOtherChallenge") {
		$("resourceMessage").insert('<?php echo $LNG->ISSUE_OTHERCHALLENGE_FORM_HINT; ?>');
	} else if (type == "IssueResource") {
		$("resourceMessage").insert('<?php echo $LNG->ISSUE_RESOURCE_FORM_HINT; ?>');

	// Solutions
	} else if (type == "SolutionSummary") {
		$("resourceMessage").insert('<?php echo $LNG->SOLUTION_SUMMARY_FORM_HINT; ?>');
	} else if (type == "SolutionPro") {
		$("resourceMessage").insert('<?php echo $LNG->SOLUTION_PRO_FORM_HINT; ?>');
	} else if (type == "SolutionCon") {
		$("resourceMessage").insert('<?php echo $LNG->SOLUTION_CON_FORM_HINT; ?>');
	} else if (type == "SolutionDesc") {
		$("resourceMessage").insert('<?php echo $LNG->SOLUTION_DESC_FORM_HINT; ?>');
 	} else if (type == "SolutionReason") {
		$("resourceMessage").insert('<?php echo $LNG->SOLUTION_REASON_FORM_HINT; ?>'+extra);

	// Evidence
	} else if (type == "EvidenceSummary") {
		$("resourceMessage").insert('<?php echo $LNG->EVIDENCE_SUMMARY_FORM_HINT; ?>');
	} else if (type == "EvidenceDesc") {
		$("resourceMessage").insert('<?php echo $LNG->EVIDENCE_DESC_FORM_HINT; ?>');
	} else if (type == "EvidenceWebsites") {
		$("resourceMessage").insert('<?php echo $LNG->EVIDENCE_WEBSITE_FORM_HINT; ?>');
	} else if (type == "EvidenceType") {
		$("resourceMessage").insert('<?php echo $LNG->EVIDENCE_TYPE_FORM_HINT; ?>');
	} else if (type == "EvidenceReason") {
		$("resourceMessage").insert('<?php echo $LNG->EVIDENCE_REASON_FORM_HINT; ?>'+extra);

	// Group
 	} else if (type == "GroupSummary") {
		$("resourceMessage").insert('<?php echo $LNG->GROUP_NAME_FORM_HINT; ?>');
 	} else if (type == "GroupDesc") {
		$("resourceMessage").insert('<?php echo $LNG->GROUP_DESC_FORM_HINT; ?>');
 	} else if (type == "GroupWebsite") {
		$("resourceMessage").insert('<?php echo $LNG->GROUP_WEBSITE_FORM_HINT; ?>');
 	} else if (type == "GroupPhoto") {
		$("resourceMessage").insert('<?php echo $LNG->GROUP_PHOTO_FORM_HINT; ?>');

	// Comments
	} else if (type == "CommentSummary") {
		$("resourceMessage").insert('<?php echo $LNG->COMMENT_SUMMARY_FORM_HINT; ?>');
	} else if (type == "CommentDesc") {
		$("resourceMessage").insert('<?php echo $LNG->COMMENT_DESC_FORM_HINT; ?>');

	// URLs
	} else if (type == "URLs") {
		$("resourceMessage").insert('<?php echo $LNG->RESOURCES_FORM_HINT; ?>');
	} else if (type == "RemoteURLs") {
		$("resourceMessage").insert('<?php echo $LNG->RESOURCES_REMOTE_FORM_HINT; ?>');
	} else if (type == "ResourceTitle") {
		$("resourceMessage").insert('<?php echo $LNG->RESOURCES_TITLE_FORM_HINT; ?>');
	} else if (type == "ResourceURL") {
		$("resourceMessage").insert('<?php echo $LNG->RESOURCES_URL_FORM_HINT; ?>');

	// Maps
 	} else if (type == "MapSummary") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_SUMMARY_FORM_HINT; ?>');
 	} else if (type == "MapDesc") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_DESC_FORM_HINT; ?>');
 	} else if (type == "MapPrivate") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_PRIVATE_FORM_HINT; ?>');
 	} else if (type == "MapPrivateGroup") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_PRIVATE_FORM_HINT_GROUP; ?>');
 	} else if (type == "MapGroup") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_FORM_ADD_TO_GROUP_HINT; ?>');

	// Movie Maps
 	} else if (type == "MapMedia") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_MEDIA_HELP; ?>');
 	} else if (type == "MapMovieWidth") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_MOVIE_WIDTH_HELP; ?>');
 	} else if (type == "MapMovieHeight") {
		$("resourceMessage").insert('<?php echo $LNG->MAP_MOVIE_HEIGHT_HELP; ?>');
 	} else if (type == "MapImportYouTubeMedia") {
 		$("resourceMessage").insert('<?php echo $LNG->MAP_MEDIA_IMPORT_YOUTUBE_HELP; ?>');
 	} else if (type == "MapImportVimeoMedia") {
 		$("resourceMessage").insert('<?php echo $LNG->MAP_MEDIA_IMPORT_VIMEO_HELP; ?>');

	// REMOTE FORMS
 	} else if (type == "RemoteEvidenceSolution") {
		$("resourceMessage").insert('<?php echo $LNG->REMOTE_EVIDENCE_SOLUTION_FORM_HINT; ?>');
	} else if (type == "RemoteEvidenceDesc") {
		$("resourceMessage").insert('<?php echo $LNG->REMOTE_EVIDENCE_DESC_FORM_HINT; ?>');
	} else if (type == "RemoteEvidenceType") {
		$("resourceMessage").insert('<?php echo $LNG->REMOTE_EVIDENCE_TYPE_FORM_HINT; ?>');

	} else if (type == "Private") {
		$("resourceMessage").insert('<?php echo $LNG->FORM_PRIVACY_HINT; ?>');
	} else {
		return false;
	}

	showHint(event, panelName, 10, -10);

	return true;
}

/**
 * Remove the given multiple for the given type at the given index
 */
function removeMultiple(key, i) {
	var answer = confirm("<?php echo $LNG->FORM_REMOVE_MULTI; ?>");
    if(answer){
		if ($(key+'form') && $(key+'field'+i)) {
		    if(	$(key+'form').childElements()[0].nodeName.toUpperCase() != "HR"){
			    $(key+'field'+i).remove();
			    try {
			        $(key+'hr'+ i).remove();
			    } catch (err) {
			        // do nowt
			    }
			    if($(key+'form').childElements()[0] && $(key+'form').childElements()[0].nodeName.toUpperCase() == "HR"){
			        $(key+'form').childElements()[0].remove();
			    }
		    }
		}
    }
    return;
}

/**
 * Add another resource block
 */
function addIdea(noIdeas) {

	var newitem = '<div id="ideafield'+noIdeas+'" class="formrow">';

	newitem += '<div class="formrowsm">';
	newitem += '<input placeholder="<?php echo $LNG->FORM_IDEA_LABEL_TITLE; ?>" class="forminput hgrwide" id="ideaname-'+noIdeas+'" name="ideanamearray[]" value="">';
	newitem += '</div>';

	newitem += '<div class="formrowsm">';
	newitem += '<textarea rows="3" placeholder="<?php echo $LNG->FORM_IDEA_LABEL_DESC; ?>" class="forminput hgrwide" id="ideadesc-'+noIdeas+'" name="ideadescarray[]"></textarea>';
	newitem += '</div>';

	newitem += '<a id="idearemovebutton-'+noIdeas+'" href="javascript:void(0)" onclick="javascript:removeMultiple(\'idea\', \''+noIdeas+'\')" class="form" style="clear:both;float:right"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a><br>';
	newitem += '</div>';

	$('ideaformdiv').insert(newitem);

	noIdeas++;
	return noIdeas;
}

/**
 * Add another resource block
 */
function addResource(noResources) {
	if($('resourceform').childElements().length != 0){
	    $('resourceform').insert('<hr id="resourcehr'+noResources+'" class="urldivider"/>');
	}

	var newitem = '<div id="resourcefield'+noResources+'" class="subformrow">';

    newitem += '<input type="hidden" id="resourcenodeidsarray-'+noResources+'" name="resourcenodeidsarray[]" value="" />';

	newitem += '<div class="hgrsubformrow" id="resourceurldiv-'+noResources+'">';
	newitem += '<label  class="hgrsubformlabel" for="resourceurl-'+noResources+'"><?php echo $LNG->FORM_LABEL_URL; ?>';
	newitem += '<a href="javascript:void(0)" onMouseOver="showFormHint(\'ResourceURL\', event, \'hgrhint\'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>';
	newitem += '<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>';
	newitem += '</label>';
	newitem += '<input class="subforminput forminputmust" style="width: 320px;" id="resourceurl-'+noResources+'" name="resourceurlarray[]" value="http://">';
	newitem += '<img class="active" style="vertical-align: middle; padding-bottom: 2px; margin-left:4px;" title="<?php echo $LNG->FORM_AUTOCOMPLETE_TITLE_HINT; ?>" src="<?php echo $HUB_FLM->getImagePath('autofill.png'); ?>" onClick="autoCompleteWebsiteDetailsMulti(\''+noResources+'\')" onkeypress="enterKeyPressed(event)" />';
	newitem += '</div>';

	newitem += '<div class="hgrsubformrow">';
	newitem += '<label  class="hgrsubformlabel" for="resourcetitle-'+noResources+'"><?php echo $LNG->FORM_LABEL_TITLE; ?>';
	newitem += '<a href="javascript:void(0)" onMouseOver="showFormHint(\'ResourceTitle\', event, \'hgrhint\'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>';
	newitem += '<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>';
	newitem += '</label>';
	newitem += '<input class="subforminput forminputmust" style="width: 350px;" id="resourcetitle-'+noResources+'" name="resourcetitlearray[]" value="">';
	newitem += '</div>';

	newitem += '<div class="hgrsubformrow" id="resourcedescdiv-'+noResources+'">';
	newitem += '<input type="hidden" id="resourcecliparray-'+noResources+'" name="resourcecliparray[]" value="" />';
	newitem += '<a id="resourceremovebutton-'+noResources+'" href="javascript:void(0)" onclick="javascript:removeMultiple(\'resource\', \''+noResources+'\')" class="form" style="clear:both;float:right"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a><br>';
	newitem += '</div>';

	newitem += '</div>';

	$('resourceform').insert(newitem);

	noResources++;

	return noResources;
}

function addResourceEvents(targetname) {
	for (var i=0; i<noResources; i++) {
		if ($('resourceremovebutton-'+i)) {
			Event.observe($('resourceremovebutton-'+i),"click", function(){
				validateResourceNext(targetname);
			});
			Event.stopObserving('resourceremovebutton-'+i,'keyup');
			Event.observe($('resourceremovebutton-'+i),"keyup", function(){
				validateResourceNext(targetname);
			});
		}

		if ($('resourceurl-'+i)) {
			Event.stopObserving('resourceurl-'+i,'input');
			Event.stopObserving('resourceurl-'+i,'change');
			Event.stopObserving('resourceurl-'+i,'keyup');
			Event.observe($('resourceurl-'+i),"input", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourceurl-'+i),"change", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourceurl-'+i),"keyup", function(){
				validateResourceNext(targetname);
			});
		}

		if ($('resourcetitle-'+i)) {
			Event.stopObserving('resourcetitle-'+i,'input');
			Event.stopObserving('resourcetitle-'+i,'change');
			Event.stopObserving('resourcetitle-'+i,'keyup');
			Event.observe($('resourcetitle-'+i),"input", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourcetitle-'+i),"change", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourcetitle-'+i),"keyup", function(){
				validateResourceNext(targetname);
			});
		}
	}
}

function validateResourceNext(targetname) {
	var allBlank = true;
	for (var i=0; i<noResources; i++) {
		if ($('resourceurl-'+i)) {
			if ( $('resourceurl-'+i).value.trim() != ''
				&& $('resourceurl-'+i).value.trim() != 'http://'
				&& $('resourcetitle-'+i).value.trim() != '') {
				allBlank = false;
			}
		}
	}

	if ($(targetname)) {
		if (!allBlank) {
			$(targetname).removeAttribute('disabled');
		} else {
			$(targetname).setAttribute('disabled', 'true');
		}
	}
}

function validateSimpleNext(obj, targetname) {
	if (obj.value.trim() != '') {
		$(targetname).removeAttribute('disabled');
	} else {
		$(targetname).setAttribute('disabled', 'true');
	}
}

function openRelatedItemSelector(num) {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?num="+num+"&handler=addSelectedRelatedItem&filternodetypes="+BASE_TYPES_STR+","+EVIDENCE_TYPES_STR, 420, 730);
}

//add another url field
function addURL(noURLs){
	if($('urlform').childElements().length != 0){
        $('urlform').insert('<hr id="urlhr'+noURLs+'" class="urldivider"/>');
    }

	var newitem = '<div id="urlfield'+noURLs+'" class="subformrow">';
	newitem += '<input type="hidden" id="resourceids-'+noURLs+'" name="resourceids[]" value="" />';
	newitem += '<input type="hidden" id="resourcedescs-'+noURLs+'" name="resourcedescs[]" value="" />';
 	newitem += '<input type="button" id="resourceadd-'+noURLs+'" title="<?php echo $LNG->FORM_SELECT_RESOURCE_HINT; ?>" onclick="javascript: openPicker(\''+noURLs+'\');" value="<?php echo $LNG->FORM_BUTTON_ADD; ?>" />';
	newitem += '<input readonly class="subforminput hgrinput" style="background: white;border:none;width:332px;" id="resourcenames-'+noURLs+'" name="$resourcenames[]" value="" />';
	newitem += '<input type="button" id="resourceremove-'+noURLs+'" style="visibility:hidden;margin-left:3px;" onclick="javascript:removeMultiple(\'url\', '+noURLs+')" class="form" value="<?php echo $LNG->FORM_BUTTON_REMOVE; ?>" />';
	newitem += '</div>';

    $('urlform').insert(newitem);

    noURLs++;

    return noURLs;
}

function toggleChallenges() {
	if ( $("groupsdiv").style.display == "block") {
		$("groupsdiv").style.display = "none";
		$("groupsimg").src='<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>';
	} else {
		$("groupsdiv").style.display = "block";
		$("groupsimg").src='<?php echo $HUB_FLM->getImagePath("arrow-up-blue.png"); ?>';
	}
}

function typeChangedResource(num) {
	var type = $('resource'+num+'menu').value;
	if (type == "Publication") {
		$('identifierdiv-'+num).style.display = "block";
	} else {
		$('identifierdiv-'+num).style.display = "none";
	}
}

/**
 * Fetch the website title and description from the website page for the url passed.
 */
function autoCompleteWebsiteDetails() {
	var urlvalue = $('url').value;
	if (urlvalue == "" || urlvalue == "http://") {
		alert("<?php echo $LNG->ENTER_URL_FIRST; ?>");
		return;
	}

	var reqUrl = SERVICE_ROOT + "&method=autocompleteurldetails&url="+encodeURIComponent(urlvalue);
    new Ajax.Request(reqUrl, { method:'get',
        onSuccess: function(transport){
            var json = transport.responseText.evalJSON();
            if(json.error){
                //alert(json.error[0].message);
                return;
            }
			$('title').value = json.url[0].title;
   		}
    });
}

/**
 * Fetch the website title and description from the website page for the url passed.
 */
function autoCompleteWebsiteDetailsMulti(num) {
	var urlvalue = $('resourceurl-'+num).value;
	if (urlvalue == "" || urlvalue == "http://") {
		alert("<?php echo $LNG->ENTER_URL_FIRST; ?>");
		return;
	}

	var reqUrl = SERVICE_ROOT + "&method=autocompleteurldetails&url="+encodeURIComponent(urlvalue);
    new Ajax.Request(reqUrl, { method:'get',
        onSuccess: function(transport){
            var json = transport.responseText.evalJSON();
            if(json.error){
                //alert(json.error[0].message);
                return;
            }
			$('resourcetitle-'+num).value = json.url[0].title;
   		}
    });
}
