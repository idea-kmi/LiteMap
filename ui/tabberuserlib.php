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

	<div id="tabber" class="tabber-user mt-4" role="navigation">
        <ul id="tabs" class="nav nav-tabs collapse multi-collapse show">
			<li class="nav-item">
				<a class="nav-link active" id="tab-home" href="#home" data-bs-toggle="tab">
					<?php echo $LNG->TAB_USER_HOME; ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-data" href="#data" data-bs-toggle="tab">
					<?php echo $LNG->TAB_USER_DATA; ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-group" href="#group" data-bs-toggle="tab">
					<?php echo $LNG->TAB_USER_GROUP; ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-social" href="#social" data-bs-toggle="tab">
					<?php echo $LNG->TAB_USER_SOCIAL; ?>
				</a>
			</li>
        </ul>

        <div id="tabs-content" class="tab-content p-0">

			<!-- HOME TAB PAGES -->
            <div id='tab-content-home-div' class='tab-pane fade show active'>
	  			<div class="peopleback plainborder-bottom" style="min-height:3px;">
	  				<div class="peopleback tabtitlebar" style="min-height:3px;"></div>
	  			</div>
	            <div id='tab-content-home'>
	            	<?php include($HUB_FLM->getCodeDirPath("ui/homepageuser.php")); ?>
	            </div>
			</div>

			<!-- DATA TAB PAGE -->
			<div id='tab-content-data-div' class='tabcontent' style="display:none;">
	  			<div class="peopleback plainborder-bottom" style="min-height:3px;"></div>

            	<div id='tab-content-toolbar-data' class="border border-top-0 p-3 pt-1">
					<div id="tabber" role="navigation">

						<div id="datatabs">
							<ul id="tabs" class="nav nav-tabs p-2 pb-3 myData-tabs">
								<li class="nav-item">
									<a class="nav-link" id="tab-data-map" href="#data-map"><span class="tab tabchallenge"><?php echo $LNG->TAB_USER_MAP; ?> <span id="map-list-count"></span></span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-data-issue" href="#data-issue"><span class="tab tabissue"><?php echo $LNG->TAB_USER_ISSUE; ?> <span id="issue-list-count"></span></span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-data-solution" href="#data-solution"><span class="tab tabsolution"><?php echo $LNG->TAB_USER_SOLUTION ?> <span id="solution-list-count"></span></span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-data-pro" href="#data-pro"><span class="tab tabpro"><?php echo $LNG->TAB_USER_PRO; ?> <span id="pro-list-count"></span></span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-data-con" href="#data-con"><span class="tab tabcon"><?php echo $LNG->TAB_USER_CON; ?> <span id="con-list-count"></span></span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-data-evidence" href="#data-evidence"><span class="tab tabevidence"><?php echo $LNG->TAB_USER_EVIDENCE; ?> <span id="evidence-list-count"></span></span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-data-comment" href="#data-comment"><span class="tab"><?php echo $LNG->TAB_USER_COMMENT; ?> <span id="comment-list-count"></span></span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-data-chat" href="#data-chat"><span class="tab"><?php echo $LNG->TAB_USER_CHAT; ?> <span id="chat-list-count"></span></span></a>
								</li>
							</ul>
						</div>

						<div id="tab-content-data" class="tab-content">

							<!-- Maps -->
           					<div id="tab-content-data-map-div" class="tabcontentuser">								
								<div id='tab-content-map-search' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchmap" class="toolbarIcons">
										<div class="d-flex gap-3">
											<div class="col-lg-4 col-md-12">
												<?php
													// if search term is present in URL then show in search box
													$q = stripslashes(optional_param("q","",PARAM_TEXT));
												?>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_MAP_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_MAP_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('map-go-button').onclick();}" id="qmap" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
													<div id="q_choices" class="autocomplete"></div>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchIssues();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="MAP_ARGS['q'] = ''; MAP_ARGS['scope'] = 'all'; $('qmap').value='';if ($('scopemapeall'))  $('scopemapeall').checked=true; refreshIssues();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
												</div>
											</div>
											<div class="col-lg-4 col-md-12">
												<div id="mapbuttons" class="rss-print-btn">
													<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_ISSUE; ?>" onclick="printNodes(ISSUE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ISSUE; ?>');">
														<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
           						<div id="tab-content-data-map" class="mapGroups tabcontentinner p-4"></div>
           					</div>

							<!-- Issues -->
           					<div id="tab-content-data-issue-div" class="tabcontentuser">
								<div id='tab-content-issue-search' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchissue" class="toolbarIcons">
										<div class="d-flex gap-3">
											<div class="col-lg-4 col-md-12">
												<?php
													// if search term is present in URL then show in search box
													$q = stripslashes(optional_param("q","",PARAM_TEXT));
												?>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('issue-go-button').onclick();}" id="qissue" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
													<div id="q_choices" class="autocomplete"></div>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchIssues();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="ISSUE_ARGS['q'] = ''; ISSUE_ARGS['scope'] = 'all'; $('qissue').value='';if ($('scopechallangeall'))  $('scopechallangeall').checked=true; refreshIssues();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
												</div>
											</div>
											<div class="col-lg-4 col-md-12">
												<div id="issuebuttons" class="rss-print-btn">
													<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_ISSUE; ?>" onclick="printNodes(ISSUE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ISSUE; ?>');">
														<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
           						<div id="tab-content-data-issue" class="tabcontentinner p-4"></div>
           					</div>

							<!-- Ideas -->
							<div id='tab-content-data-solution-div' class="tabcontentuser">
								<div id='tab-content-solution-search' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchsolution" class="toolbarIcons">
										<div class="d-flex gap-3">
											<div class="col-lg-4 col-md-12">
												<?php
													// if search term is present in URL then show in search box
													$q = stripslashes(optional_param("q","",PARAM_TEXT));
												?>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_SOLUTION_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_SOLUTION_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('solution-go-button').onclick();}" id="qsolution" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
													<div id="q_choices" class="autocomplete"></div>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchSolutions();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="SOLUTION_ARGS['q'] = ''; SOLUTION_ARGS['scope'] = 'all'; $('qsolution').value='';if ($('scopesolutionall'))  $('scopesolutionall').checked=true; refreshSolutions();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
												</div>
											</div>
											<div class="col-lg-4 col-md-12">
												<div id="solutionbuttons" class="rss-print-btn">
													<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_SOLUTION; ?>" onclick="printNodes(SOLUTION_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_SOLUTION; ?>');">
														<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
													</a>
												</div>
											</div>
										</div>				
									</div>
								</div>
								<div id="tab-content-data-solution" class="tabcontentinner p-4"></div>
							</div>

							<!-- Supporting Arguments -->
							<div id='tab-content-data-pro-div' class="tabcontentuser">
								<div id='tab-content-pro-search' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchpro" class="toolbarIcons">
										<div class="d-flex gap-3">
											<div class="col-lg-4 col-md-12">
												<?php
													// if search term is present in URL then show in search box
													$q = stripslashes(optional_param("q","",PARAM_TEXT));
												?>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_PRO_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_PRO_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('pro-go-button').onclick();}" id="qpro" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
													<div id="q_choices" class="autocomplete"></div>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchPros();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="PRO_ARGS['q'] = ''; PRO_ARGS['scope'] = 'all'; $('qpro').value='';if ($('scopeproall'))  $('scopeproall').checked=true; refreshPros();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
												</div>
											</div>
											<div class="col-lg-4 col-md-12">
												<div id="probuttons" class="rss-print-btn">
													<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_PRO; ?>" onclick="printNodes(PRO_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_PRO; ?>');">
														<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id='tab-content-data-pro' class="tabcontentinner p-4"></div>
							</div>

							<!-- Counter Arguments -->
           					<div id='tab-content-data-con-div' class="tabcontentuser">
								<div id='tab-content-con-search' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchcon" class="toolbarIcons">										
										<div class="d-flex gap-3">
												<div class="col-lg-4 col-md-12">
													<?php
														// if search term is present in URL then show in search box
														$q = stripslashes(optional_param("q","",PARAM_TEXT));
													?>
													<div class="input-group">
														<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_CON_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_CON_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('con-go-button').onclick();}" id="qcon" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
														<div id="q_choices" class="autocomplete"></div>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchCons();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="CON_ARGS['q'] = ''; CON_ARGS['scope'] = 'all'; $('qcon').value='';if ($('scopeconall'))  $('scopeconall').checked=true; refreshCons();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div id="conbuttons" class="rss-print-btn">
														<a class="active" title="<?php echo $LNG->TAB_PRINT_TITLE_CON; ?>" onclick="printNodes(CON_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CON; ?>');">
															<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
															<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
           						<div id='tab-content-data-con' class="tabcontentinner p-4"></div>
           					</div>

							<!-- Arguments -->
							<div id='tab-content-data-evidence-div' class="tabcontentuser">
								<div id='tab-content-evidence-search' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchevidence" class="toolbarIcons">									
										<div class="d-flex gap-3">
											<div class="col-lg-4 col-md-12">
												<?php
													// if search term is present in URL then show in search box
													$q = stripslashes(optional_param("q","",PARAM_TEXT));
												?>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_EVIDENCE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_EVIDENCE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('evidence-go-button').onclick();}" id="qevidence" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
													<div id="q_choices" class="autocomplete"></div>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchEvidence();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="EVIDENCE_ARGS['q'] = ''; EVIDENCE_ARGS['scope'] = 'all'; $('qevidence').value='';if ($('scopeevidenceall'))  $('scopeevidenceall').checked=true; refreshEvidence();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
												</div>
											</div>
											<div class="col-lg-4 col-md-12">
												<div id="evidencebuttons" class="rss-print-btn">
													<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_EVIDENCE; ?>" onclick="printNodes(EVIDENCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_EVIDENCE; ?>');">
														<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
           						<div id='tab-content-data-evidence' class="tabcontentinner p-4"></div>
           					</div>

							<!-- Notes -->
           					<div id='tab-content-data-comment-div' class="tabcontentuser">
								<div id='tab-content-search-comment' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchcomment" class="toolbarIcons">									
										<div class="d-flex gap-3">
											<div class="col-lg-4 col-md-12">
												<?php
													// if search term is present in URL then show in search box
													$q = stripslashes(optional_param("q","",PARAM_TEXT));
												?>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('comment-go-button').onclick();}" id="qcomment" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
													<div id="q_choices" class="autocomplete"></div>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchComments();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="COMMENT_ARGS['q'] = ''; COMMENT_ARGS['searchid'] = ''; COMMENT_ARGS['scope'] = 'all'; $('qcomment').value='';if ($('scopeproall'))  $('scopeproall').checked=true; refreshComments();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
												</div>
											</div>
											<div class="col-lg-4 col-md-12">
												<div id="orgbuttons" class="rss-print-btn">
													<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_COMMENT; ?>" onclick="printNodes(COMMENT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_COMMENT; ?>');">
														<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
           						<div id='tab-content-data-comment' class="tabcontentinner p-4"></div>
							</div>

							<!-- Chats -->
           					<div id='tab-content-data-chat-div' class="tabcontentuser">
								<div id='tab-content-search-chat' class="tabcontentsearchuser p-2 peoplebackpale">
									<div id="searchchat" class="toolbarIcons">									
										<div class="d-flex gap-3">
											<div class="col-lg-4 col-md-12">
												<?php
													// if search term is present in URL then show in search box
													$q = stripslashes(optional_param("q","",PARAM_TEXT));
												?>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_CHAT_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_CHAT_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('chat-go-button').onclick();}" id="qchat" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
													<div id="q_choices" class="autocomplete"></div>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchChats();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
													<button class="btn btn-outline-dark bg-light" type="button" onclick="CHAT_ARGS['q'] = ''; CHAT_ARGS['searchid'] = ''; CHAT_ARGS['scope'] = 'all'; $('qchat').value='';if ($('scopeproall'))  $('scopeproall').checked=true; refreshPros();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
												</div>
											</div>
										</div>
									 </div>
								</div>
           						<div id='tab-content-data-chat' class="tabcontentinner p-4"></div>
           					</div>
						</div>
					</div>
            	</div>
			</div>

			<!-- GROUP TAB PAGE -->
            <div id='tab-content-group-div' class='tabcontent' style="display:none;">
	  			<div id="tab-content-group-title" class="peopleback plainborder-bottom" style="min-height:3px;"></div>
				<div class="border border-top-0 p-3 pt-1">

					<div id='tab-content-group-search'>
						<?php if(isset($USER->userid) && $userid == $USER->userid){ ?>
							<span class="toolbar d-flex flex-row px-3">
								<span class="active my-2 me-4 font-size-09 d-flex align-items-center gap-2" onclick="javascript:loadDialog('creategroup','<?php echo $CFG->homeAddress;?>ui/popups/groupadd.php', 750, 800);">
									<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->GROUP_CREATE_TITLE; ?>
								</span>
								<span class="active my-2 me-4 font-size-09 d-flex align-items-center" onclick="javascript:loadDialog('editgroup','<?php echo $CFG->homeAddress;?>ui/popups/groupedit.php', 750,800);">
									<?php echo $LNG->GROUP_MANAGE_TITLE; ?>
								</span>
							</span>
						<?php } ?>
					</div>

					<div id='tab-content-toolbar-group' class="tabcontentouter p-3">
						<div id="tab-content-group-admin" style="display:none">
							<h2><?php echo $LNG->GROUP_MY_ADMIN_GROUPS_TITLE;?></h2>
							<div id='tab-content-group-admin-list' class='tabcontentinner discussionGroups'></div>
						</div>
						<div id="tab-content-group" class="mt-5" style="display:none">
							<h2><?php echo $LNG->GROUP_MY_MEMBER_GROUPS_TITLE;?></h2>
							<div id='tab-content-group-list' class='tabcontentinner discussionGroups'></div>
						</div>
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