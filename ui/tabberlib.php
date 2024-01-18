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

	/**
	 * Tabber library
	 * Formats the output tab view in the main section of the site
	 */

	/**
	 * Displays the tabber
	 *
	 * @param string $context the context to display
	 * @param string $args the url arguments
	 */
	
	function display_tabber($context,$args, $wasEmpty){
		global $CFG, $LNG, $USER, $CONTEXTUSER, $HUB_FLM;

		// now trigger the js to load data
		$argsStr = "{";
		$keys = array_keys($args);
		$count = 0;
		if ( is_countable($keys) ){
			$count = sizeof($keys);
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
			$count = sizeof($keys);
		}
		for($i=0;$i< $count; $i++){
			$argsStr2 .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
			if ($i != ($count-1)){
				$argsStr2 .= ',';
			}
		}
		$argsStr2 .= "}";

		if (!isset($q)) {
			$q = "";
		}

		echo "<script type='text/javascript'>";

		echo "var CONTEXT = '".$context."';";
		echo "var NODE_ARGS = ".$argsStr.";";
		echo "var GROUP_ARGS = ".$argsStr2.";";
		echo "var MAP_ARGS = ".$argsStr2.";";
		echo "var COMMENT_ARGS = ".$argsStr2.";";

		echo "COMMENT_ARGS['filterlist'] = '".$CFG->LINK_COMMENT_BUILT_FROM."';";
		echo "COMMENT_ARGS['includeunconnected'] = 'true';";

		echo "</script>";
    ?>

	<div id="tabber" role="navigation">
		<ul class="nav nav-tabs p-3 main-nav" id="tabs" role="tablist">
			<li class="nav-item" role="presentation"><a class="tab h5" id="tab-home" href="<?php echo $CFG->homeAddress; ?>index.php#home-list"><span class="tab tabissue"><?php echo $LNG->TAB_HOME; ?></span></a></li>
			<li class="nav-item" role="presentation"><a class="tab h5" id="tab-group" href="<?php echo $CFG->homeAddress; ?>index.php#group-list"><span class="tab tabissue"><?php echo $LNG->TAB_GROUP; ?></span></a></li>
			<li class="nav-item" role="presentation"><a class="tab h5" id="tab-map" href="<?php echo $CFG->homeAddress; ?>index.php#map-list"><span class="tab tabissue"><?php echo $LNG->TAB_MAP; ?></span></a></li>
        </ul>

        <div id="tabs-content">

			<!-- HOME TAB PAGES -->
            <div id="tab-content-home-div" class="tabcontent">
	            <div id="tab-content-home">
					<?php include($HUB_FLM->getCodeDirPath("ui/homepage.php")); ?>
	            </div>
			</div>

			<!-- GROUP TAB PAGE -->
			<div class="container-fluid">
				<div class="row">
					<div id='tab-content-group-div' class='tabcontent' style="display:none;padding:0px;">
	  					<div id="tab-content-group-title" class="tab-content-title"></div>
            			<div id='tab-content-group-search'>
							<?php if(isset($USER->userid)){ ?>
								<div class="toolbar col-12 addButton">
									<a class="active" onclick="loadDialog('creategroup','<?php echo $CFG->homeAddress; ?>ui/popups/groupadd.php', 720,700);" title='<?php echo $LNG->TAB_ADD_GROUP_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_GROUP_LINK; ?></a>
							</div>
							<?php } ?>
							<div id="searchgroup" class="col-12 toolbarIcons">
								<div class="row">
									<div class="col-lg-4 col-md-12">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_GROUP_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_GROUP_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('group-go-button').onclick();}" id="qgroup" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
											<div id="q_choices" class="autocomplete"></div>
											<button class="btn btn-outline-dark bg-light text-dark" type="button" onclick="filterSearchGroups();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
											<button class="btn btn-outline-dark bg-light text-dark" type="button" onclick="USER_ARGS['q'] = ''; USER_ARGS['scope'] = 'all'; $('quser').value=''; refreshUsers();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
										</div>
										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>
									</div>
								</div>
							</div>
						</div>
						<div id='tab-content-toolbar-group' class="col-12">
							<div id="tab-content-group" class="tabcontentouter p-4">
								<div id='tab-content-group-list' class='tabcontentinner  discussionGroups'></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- MAPS TAB PAGE -->			
			<div class="container-fluid">
				<div class="row">
					<div id='tab-content-map-div' class='tabcontent' style="display:none;padding:0px;">
						<div id="tab-content-issue-title" class="tab-content-title"></div>
						<div id='tab-content-issue-search'>
							<?php if(isset($USER->userid)){ ?>
								<div class="toolbar col-12 addButton">
									<a class="active" onclick="loadDialog('createmap','<?php echo $CFG->homeAddress; ?>ui/popups/mapadd.php', 720,500);" title='<?php echo $LNG->TAB_ADD_MAP_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_MAP_LINK; ?></a>
								</div>
							<?php } ?>
							<div id="searchmap" class="col-12 toolbarIcons">
								<div class="row">
									<div class="col-lg-4 col-md-12">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('map-go-button').onclick();}" id="qmap" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
											<div id="q_choices" class="autocomplete"></div>
											<button class="btn btn-outline-dark bg-light text-dark" type="button" onclick="filterSearchMaps();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
											<button class="btn btn-outline-dark bg-light text-dark" type="button" onclick="MAP_ARGS['q'] = ''; MAP_ARGS['scope'] = 'all'; $('qmap').value=''; if ($('scopemapeall'))  $('scopemapall').checked=true; refreshMaps();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
										</div>
										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
										?>
									</div>
								</div>
							</div>
						</div>
						<div id="tab-content-toolbar-map" class="col-12">
							<div id="tab-content-map" class="tabcontentouter p-4">
								<div id="tab-content-map-list" class="tabcontentinner mapGroups"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php } ?>