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

/**
 * Displays the user tabs and pages
 *
 * @param string $context the context to display
 * @param string $args the url arguments
 */
function displayUserTabs($context,$args, $wasEmpty){
    global $CFG, $LNG, $USER, $CONTEXTUSER, $HUB_FLM;

	// now trigger the js to load data
	$argsStr = "{";
	$keys = array_keys($args);
	$count = 0;
	if ( is_countable($keys) ){
		$count = count($keys);
	}
	for($i=0;$i< $count; $i++){
		$argsStr .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
		if ($i != ($count-1)){
			$argsStr .= ',';
		}
	}
	$argsStr .= "}";

 	if ($wasEmpty) {
     	$args["orderby"] = 'date';
    }
 	$argsStr2 = "{";
 	$keys = array_keys($args);
	$count = 0;
	if ( is_countable($keys) ){
		$count = count($keys);
	}
 	for($i=0;$i< $count; $i++){
 		$argsStr2 .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
 		if ($i != ($count-1)){
 			$argsStr2 .= ',';
 		}
 	}
 	$argsStr2 .= "}";

	echo "<script type='text/javascript'>";

	echo "var CONTEXT = '".$context."';";
	echo "var NODE_ARGS = ".$argsStr.";";
	echo "var CONN_ARGS = ".$argsStr.";";
	echo "var NEIGHBOURHOOD_ARGS = ".$argsStr.";";
	echo "var NET_ARGS = ".$argsStr.";";

	echo "var USER_ARGS = ".$argsStr.";";
	echo "var CHALLENGE_ARGS = ".$argsStr2.";";
	echo "var ISSUE_ARGS = ".$argsStr2.";";
	echo "var SOLUTION_ARGS = ".$argsStr2.";";
	echo "var CON_ARGS = ".$argsStr.";";
	echo "var PRO_ARGS = ".$argsStr.";";
	echo "var EVIDENCE_ARGS = ".$argsStr2.";";
	echo "var RESOURCE_ARGS = ".$argsStr2.";";
	echo "var CHAT_ARGS = ".$argsStr2.";";
	echo "var COMMENT_ARGS = ".$argsStr2.";";
	echo "var MAP_ARGS = ".$argsStr2.";";
	echo "var GROUP_ARGS = ".$argsStr2.";";

	echo "CHAT_ARGS['filterlist'] = '".$CFG->LINK_COMMENT_NODE."';";
	echo "COMMENT_ARGS['includeunconnected'] = 'false';";
	echo "COMMENT_ARGS['filterlist'] = '".$CFG->LINK_COMMENT_BUILT_FROM."';";
	echo "COMMENT_ARGS['includeunconnected'] = 'true';";

	echo "</script>";
    ?>

    <div id="tabber" style="clear:both;float:left; width: 100%;">
        <ul id="tabs" class="tab">
			<li class="tab"><a class="tab" id="tab-home" href="#home"><span class="tab tabuser"><?php echo $LNG->TAB_USER_HOME; ?></span></a></li>
			<li class="tab"><a class="tab" id="tab-data" href="#data"><span class="tab tabuser"><?php echo $LNG->TAB_USER_DATA; ?></span></a></li>
			<li class="tab"><a class="tab" id="tab-group" href="#group"><span class="tab tabuser"><?php echo $LNG->TAB_USER_GROUP; ?></span></a></li>
			<li class="tab"><a class="tab" id="tab-social" href="#social"><span class="tab tabuser"><?php echo $LNG->TAB_USER_SOCIAL; ?></span></a></li>
        </ul>
        <div id="tabs-content" style="float: left; width: 100%;">

			<!-- HOME TAB PAGES -->
            <div id='tab-content-home-div' class='tabcontentouter' style='width: 100%;background: white;padding:0px;'>
	  			<div class="peopleback plainborder-bottom" style="clear:both;float:left;width:100%;margin:0px;">
	  				<div class="peopleback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"></div>
	  			</div>
	            <div id='tab-content-home'>
	            <?php include($HUB_FLM->getCodeDirPath("ui/homepageuser.php")); ?>
	            </div>
			</div>

			<!-- DATA TAB PAGE -->
			<div id='tab-content-data-div' class='tabcontent' style="display:none;">
	  			<div class="peopleback plainborder-bottom" style="height:10px;clear:both;float:left;width:100%;margin:0px;"></div>

            	<div id='tab-content-toolbar-data' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">

						<div id="datatabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab" id="tab-data-map" href="#data-map"><span class="tab tabchallenge"><?php echo $LNG->TAB_USER_MAP; ?> <span id="map-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-issue" href="#data-issue"><span class="tab tabissue"><?php echo $LNG->TAB_USER_ISSUE; ?> <span id="issue-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-solution" href="#data-solution"><span class="tab tabsolution"><?php echo $LNG->TAB_USER_SOLUTION ?> <span id="solution-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-pro" href="#data-pro"><span class="tab tabpro"><?php echo $LNG->TAB_USER_PRO; ?> <span id="pro-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-con" href="#data-con"><span class="tab tabcon"><?php echo $LNG->TAB_USER_CON; ?> <span id="con-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-evidence" href="#data-evidence"><span class="tab tabevidence"><?php echo $LNG->TAB_USER_EVIDENCE; ?> <span id="evidence-list-count"></span></span></a></li>
								<!-- li class="tab"><a class="tab" id="tab-data-resource" href="#data-resource"><span class="tab tabresource"><?php echo $LNG->TAB_USER_RESOURCE; ?> <span id="resource-list-count"></span></span></a></li -->
								<li class="tab"><a class="tab" id="tab-data-comment" href="#data-comment"><span class="tab"><?php echo $LNG->TAB_USER_COMMENT; ?> <span id="comment-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-chat" href="#data-chat"><span class="tab"><?php echo $LNG->TAB_USER_CHAT; ?> <span id="chat-list-count"></span></span></a></li>
							</ul>
						</div>

						<div id="tab-content-data" class="tabcontentinner" style="width:100%">

           					<div id="tab-content-data-map-div" class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-map-search' class="tabcontentsearchuser">
									<div id="searchmap" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_MAP_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('map-go-button').onclick();}" id="qmap" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										 </div>
										<div style="float:left;">
											<img id="map-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchIssues();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: MAP_ARGS['q'] = ''; MAP_ARGS['scope'] = 'all'; $('qmap').value='';if ($('scopemapeall'))  $('scopemapall').checked=true; refreshMaps();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="mapbuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_MAP; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(MAP_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_MAP; ?>');" />
										</div>
									 </div>
								</div>
           						<div id="tab-content-data-map"  class="tabcontentinner"></div>
           					</div>

           					<div id="tab-content-data-issue-div" class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-issue-search' class="tabcontentsearchuser">
									<div id="searchissue" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('issue-go-button').onclick();}" id="qissue" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										 </div>
										<div style="float:left;">
											<img id="issue-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchIssues();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: ISSUE_ARGS['q'] = ''; ISSUE_ARGS['scope'] = 'all'; $('qissue').value='';if ($('scopechallangeall'))  $('scopechallangeall').checked=true; refreshIssues();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="issuebuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_ISSUE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(ISSUE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ISSUE; ?>');" />
										</div>
									 </div>
								</div>
           						<div id="tab-content-data-issue"  class="tabcontentinner"></div>
           					</div>

							<div id='tab-content-data-solution-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-solution-search' class='tabcontentsearchuser'>
									<div id="searchsolution" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_SOLUTION_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('solution-go-button').onclick();}" id="qsolution" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="solution-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchSolutions();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: SOLUTION_ARGS['q'] = ''; SOLUTION_ARGS['scope'] = 'all';$('qsolution').value='';if ($('scopesolutionall'))  $('scopesolutionall').checked=true;  refreshSolutions();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="solutionbuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_SOLUTION; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(SOLUTION_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_SOLUTION; ?>');" />
										</div>
									</div>
								</div>
								<div id="tab-content-data-solution" class="tabcontentinner"></div>
							</div>

							<div id='tab-content-data-pro-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-pro-search' class="tabcontentsearchuser">
									<div id="searchpro" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_PRO_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('pro-go-button').onclick();}" id="qpro" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="pro-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="filterSearchPros();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: PRO_ARGS['q'] = ''; PRO_ARGS['scope'] = 'all';$('qpro').value='';if ($('scopeproall'))  $('scopeproall').checked=true;  refreshPros();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="probuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_PRO; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(PRO_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_PRO; ?>');" />
										</div>
									</div>
								</div>

								<div id='tab-content-data-pro' class="tabcontentinner"></div>
							</div>

           					<div id='tab-content-data-con-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-con-search' class="tabcontentsearchuser">
									<div id="searchcon" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_CON_LABEL; ?></label>
										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>
										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('con-go-button').onclick();}" id="qcon" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="con-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchCons();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: CON_ARGS['q'] = ''; CON_ARGS['scope'] = 'all'; $('qcon').value='';if ($('scopeconall'))  $('scopeconall').checked=true; refreshCons();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="conbuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_CON; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(CON_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CON; ?>');" />
										</div>
									</div>
								</div>

           						<div id='tab-content-data-con' class="tabcontentinner"></div>
           					</div>

							<div id='tab-content-data-evidence-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-evidence-search' class="tabcontentsearchuser">
									<div id="searchevidence" style="float:left;margin-left:10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_EVIDENCE_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('evidence-go-button').onclick();}" id="qevidence" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="evidence-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchEvidence();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: EVIDENCE_ARGS['q'] = ''; EVIDENCE_ARGS['scope'] = 'all';$('qevidence').value='';if ($('scopeevidenceall'))  $('scopeevidenceall').checked=true;  refreshEvidence();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="evidencebuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_EVIDENCE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(EVIDENCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_EVIDENCE; ?>');" />
										</div>
									</div>
								</div>

           						<div id='tab-content-data-evidence' class="tabcontentinner"></div>
           					</div>

           					<!-- div id='tab-content-data-resource-div' class="tabcontentuser resourcebackpale" style="display:none">
								<div id='tab-content-resource-search' class="tabcontentsearchuser">
									<div id="searchweb" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_RESOURCE_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style=" margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('web-go-button').onclick();}" id="qweb" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="web-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchResources();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: RESOURCE_ARGS['q'] = ''; RESOURCE_ARGS['searchid'] = ''; RESOURCE_ARGS['scope'] = 'all'; $('qweb').value=''; refreshResources();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="webbuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_RESOURCE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(RESOURCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_RESOURCE; ?>');" />
										</div>
									</div>
								</div>
           						<div id='tab-content-data-resource' class="tabcontentinner"></div>
           					</div -->

           					<div id='tab-content-data-comment-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-search-comment' class="tabcontentsearchuser">
									<div id="searchcomment" style="float:left;margin-left:10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('comment-go-button').onclick();}" id="qcomment" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;">
											</div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										 </div>
										<div style="float:left;">
											<img id="comment-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchComments();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: COMMENT_ARGS['q'] = ''; COMMENT_ARGS['searchid'] = ''; COMMENT_ARGS['scope'] = 'all';$('qcomment').value=''; refreshComments();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
									 </div>
									<div style="float:left;margin-left: 10px;" id="orgbuttons">
										<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_COMMENT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printCommentNodes(COMMENT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_COMMENT; ?>');" />
									</div>
								</div>

           						<div id='tab-content-data-comment' class="tabcontentinner"></div>
           					</div -->

           					<div id='tab-content-data-chat-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id='tab-content-search-chat' class="tabcontentsearchuser">
									<div id="searchchat" style="float:left;margin-left:10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_CHAT_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('chat-go-button').onclick();}" id="qchat" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;">
											</div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										 </div>
										<div style="float:left;">
											<img id="chat-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchChats();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: CHAT_ARGS['q'] = ''; CHAT_ARGS['searchid'] = ''; CHAT_ARGS['scope'] = 'all';$('qchat').value=''; refreshChats();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
									 </div>
								</div>

           						<div id='tab-content-data-chat' class="tabcontentinner"></div>
           					</div>

						</div>
					</div>
            	</div>
			</div>

			<!-- GROUP TAB PAGE -->
            <div id='tab-content-group-div' class='tabcontent peoplebackpale' style="display:none;">

	  			<div id="tab-content-group-title" class="peopleback" style="height:10px;clear:both;float:left;width:100%;margin:0px;"></div>

            	<div id='tab-content-group-search' style='margin:5px;padding-top: 1px;clear:both; float:left; width: 100%;'>
					<?php if(isset($USER->userid) && $userid == $USER->userid){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<span class="active" onclick="javascript:loadDialog('creategroup','<?php echo $CFG->homeAddress;?>ui/popups/groupadd.php', 750, 800);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->GROUP_CREATE_TITLE; ?></span>
						<span class="active" style="margin-left:30px;" onclick="javascript:loadDialog('editgroup','<?php echo $CFG->homeAddress;?>ui/popups/groupedit.php', 750,800);"><?php echo $LNG->GROUP_MANAGE_TITLE; ?></span>
					</span>
					<?php } ?>
            	</div>

            	<div id='tab-content-toolbar-group' class="tabcontentouter">
					<div id="tab-content-group-admin" style="display:none">
						<h2><?php echo $LNG->GROUP_MY_ADMIN_GROUPS_TITLE;?></h2>
           				<div id='tab-content-group-admin-list' class='tabcontentinner'></div>
					</div>
					<div id="tab-content-group" style="display:none">
						<h2><?php echo $LNG->GROUP_MY_MEMBER_GROUPS_TITLE;?></h2>
           				<div id='tab-content-group-list' class='tabcontentinner'></div>
					</div>
				</div>
            </div>

			<!-- SOCIAL NETWORK TAB PAGE -->
            <div id='tab-content-social-div' class='tabcontent' style='width: 100%;background: white;'>
	  			<div id="tab-content-user-bar" class="peopleback plainborder-bottom" style="clear:both;float:left;width:100%;margin:0px;">
	  				<div class="peopleback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"></div>
	  			</div>
	            <div id="tab-content-social" style="clear:both;float:left;width:100%;padding:5px;"></div>
			</div>
		</div>
	</div>
<?php } ?>

<script type='text/javascript'>
	function updateUserFollow() {
		$('followupdate').submit()
	}
</script>