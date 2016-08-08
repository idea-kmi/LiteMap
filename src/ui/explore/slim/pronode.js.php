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
var isSlim = true;

var currentime = new Date().getTime();
var nodeid = nodeObj.nodeid;

var nodekey = "Node"+nodeid;
var followkey = currentime+"Follow"+nodeid;
var mapkey = currentime+"Map"+nodeid;

var followisopen = false;
var mapisopen = true;

var nodeheight = 400;
var mapheight = 200;
var followheight = 300;

function loadEvidenceWidgetPage() {
	refreshWidgetMaps();
	//refreshWidgetFollowers();
	refreshNodeEvidence();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {
	resizeKeyWidget(mapkey);
	//resizeKeyWidget(followkey);
	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeEvidence() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "evidence", nodekey, 'proback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('probackpale');

	$(nodekey+'div').addClassName('probackpale');
	$(nodekey+'div').addClassName('proborder');

	$(nodekey+'headerinner').addClassName('proback');
	resizeNodeWidget(nodekey, nodeheight);
}

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(nodeid,'<?php echo $LNG->EXPLORE_evidenceToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('mapsarea') && $('mapsarea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

function refreshWidgetMaps(nodetofocusid) {
	var isopen = getIsOpen($(mapkey+"body"), mapisopen);
	$('mapsarea').update(buildMapWidget(nodeid, '<?php echo $LNG->EXPLORE_evidenceToMap; ?>', mapheight, isopen, 'challengewidgetback', mapkey, nodetofocusid));
	resizeKeyWidget(mapkey);

	// for refreshing after an add/delete when expaned
	if ($('followersarea') && $('followersarea').style.display == 'none') {
		adjustForExpand($(mapkey+"buttonresize"), mapkey, mapheight);
	}
}

loadEvidenceWidgetPage();