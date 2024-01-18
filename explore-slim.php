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
    $nodetype = required_param("nodetype",PARAM_TEXT);
?>
<div style="clear:both;width:380px;float:left;">
	<div id='grabmapdetailsdiv' onmouseenter="this.style.cursor='move'" onmouseout="this.style.cursor='default'" onmousedown="onNodeDetailsDivMouseDown(event)" onmousemove="onNodeDetailsDivMouseMove(event)" onmouseup="onNodeDetailsDivMouseUp(event)" style="float:left;width:340px;height:20px;"></div>
	<button onclick="closeNodeDetailsDiv()" class="plainborder" style="font-weight:bold;font-size:8pt;float:right;margin-bottom:5px;width:30px">X</button>
</div>
<div id='tab-content-explore-widget' class='explorepagesection plainborder' style="display:block;overflow-y:scroll;width:378px;float:left;height:547px;padding-top:5px;">
	<?php if ($nodetype == 'Challenge') { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="mapsarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="followersarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
		</div>
	<?php } else if ($nodetype == 'Issue') { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="mapsarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="followersarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
		</div>
	<?php } else if ($nodetype == 'Solution') { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="display: block;clear:both;float:left;width:350px;"></div>
			<div id="mapsarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="followersarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
		</div>
	<?php } else if ($nodetype == 'Idea') { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="display: block;"></div>
			<div id="mapsarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="followersarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<!-- div id="relatedresourcesarea" class="tablelower" style="display:block"></div -->
		</div>
	<?php } else if ($nodetype == "Pro") { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="display: block;clear:both;float:left;width:350px;"></div>
			<div id="mapsarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="followersarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
		</div>
	<?php } else if ($nodetype == "Con") { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="display: block;clear:both;float:left;width:350px;"></div>
			<div id="mapsarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="followersarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
		</div>
	<?php } else if ($nodetype == "Argument") { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="display: block;clear:both;float:left;width:350px;"></div>
			<div id="mapsarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
			<div id="followersarea" class="tablelower" style="display:block;clear:both;float:left;width:350px;"></div>
		</div>
	<?php } else if ($nodetype == 'News') { ?>
		<div id="widgetareadiv" style="clear:both; float:left;width:350px;margin-left:4px;">
			<div id="nodearea" class="tabletop" style="width:100%;display: block;;clear:both;float:left;width:350px;"></div>
		</div>
	<?php } ?>
</div>
