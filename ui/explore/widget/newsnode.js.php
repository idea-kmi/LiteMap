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
var IS_SLIM = false;

var currentime = new Date().getTime();
var nodeid = NODE_ARGS['nodeid'];
var nodekey = "Node"+nodeid;
var nodeheight = 500;

function loadNewsWidgetPage() {
	refreshNodeNews();
	//Event.observe(window,"resize",resizeWidgets);
	//resizeWidgets();
};

function resizeWidgets() {
	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeNews() {
	var nodediv = buildNodeWidgetForNews(nodeObj, nodeheight, "news", nodekey, 'themeback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('themebackpale');

	$(nodekey+'div').addClassName('themebackpale');
	$(nodekey+'div').addClassName('themeborder');

	resizeNodeWidget(nodekey, nodeheight);
	//toggleExpandWidget($(nodekey+'buttonresize'), nodekey, nodeheight);
}

loadNewsWidgetPage();