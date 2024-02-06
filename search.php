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

	$searchid = optional_param("sid","",PARAM_ALPHANUMEXT);
	$query = stripslashes(parseToJSON(optional_param("q","",PARAM_TEXT)));
	// need to do parseToJSON to convert any '+' symbols as they are now used in searches.

	// default parameters
	$start = optional_param("start",0,PARAM_INT);
	$max = optional_param("max",20,PARAM_INT);
	$orderby = optional_param("orderby","",PARAM_ALPHA);
	$sort = optional_param("sort","DESC",PARAM_ALPHA);

	if ($searchid == "" && isset($USER->userid)) {
		$fromid = optional_param("fromid",'',PARAM_TEXT);
		$tagsonlyoption = 'N';
		$searchid = auditSearch($USER->userid, $query, $tagsonlyoption, 'main', $fromid);
		if ($searchid != "") {
			header("Location: ".$CFG->homeAddress."search.php?sid=".$searchid."&q=".$query);
			die;
		}
	}

	include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
	array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/searchlib.js.php').'" type="text/javascript"></script>');
	include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

	$args = array();

	$args["filternodetypes"] = '';

	$args["q"] = $query;
	$args["searchid"] = $searchid;

	$args["start"] = $start;
	$args["max"] = $max;

	if ($orderby == "") {
		$args["orderby"] = 'date';
	} else {
		$args["orderby"] = $orderby;
	}
	$args["sort"] = $sort;

	$CONTEXT = $CFG->GLOBAL_CONTEXT;

    // now trigger the js to load data
	$argsStr = "{";
	$keys = array_keys($args);

	$keycount = 0;
	if (is_countable($keys)) {
		$keycount = sizeof($keys);
	}
	for($i = 0; $i < $keycount; $i++){
		$argsStr .= '"'.$keys[$i].'":"'.addslashes($args[$keys[$i]]).'"';
		if ($i != ($keycount-1)){
			$argsStr .= ',';
		}
	}
	$argsStr .= "}";

	echo "<script type='text/javascript'>";
	echo "var CONTEXT = '".$CONTEXT."';";
	echo "var NODE_ARGS = ".$argsStr.";";
	echo "var URL_ARGS = ".$argsStr.";";
	echo "var USER_ARGS = ".$argsStr.";";
	echo "var GROUP_ARGS = ".$argsStr.";";
	echo "var SOLUTION_ARGS = ".$argsStr.";";
	echo "var ISSUE_ARGS = ".$argsStr.";";
	echo "var CON_ARGS = ".$argsStr.";";
	echo "var PRO_ARGS = ".$argsStr.";";
	echo "var CHAT_ARGS = ".$argsStr.";";
	echo "var ARGUMENT_ARGS = ".$argsStr.";";
	echo "var COMMENT_ARGS = ".$argsStr.";";
	echo "var NEWS_ARGS = ".$argsStr.";";
	echo "var MAP_ARGS = ".$argsStr.";";
	echo "</script>";
?>

<div class="container-fluid">
	<div class="row p-3">		
		<div class="col">
			<?php
				if ($query == ""){
					echo "<h1>".$LNG->SEARCH_TITLE_ERROR."</h1><br/>";
					echo $LNG->SEARCH_ERROR_EMPTY;
					include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
					return;
				}
			?>

			<script type="text/javascript">
				Event.observe(window, 'load', function() {

					buildSearchToolbar($("content-controls"));

					loadissues(CONTEXT,ISSUE_ARGS);

					loadsolutions(CONTEXT,SOLUTION_ARGS);
					loadpros(CONTEXT,PRO_ARGS);
					loadcons(CONTEXT,CON_ARGS);
					loadarguments(CONTEXT,ARGUMENT_ARGS);
					loadmaps(CONTEXT,MAP_ARGS);

					loadchat(CONTEXT,CHAT_ARGS);
					loadcomments(CONTEXT,COMMENT_ARGS);

					//loadnews(CONTEXT,NEWS_ARGS);
					//loadurls(CONTEXT,URL_ARGS);

					loadusers(CONTEXT,USER_ARGS);
					loadgroups(CONTEXT,GROUP_ARGS);
				});
			</script>

			<a name="top"></a>
			<div id="CONTEXT">
				<h1><?php echo $LNG->SEARCH_TITLE; ?> <?php print( htmlspecialchars($query) ); ?></h1>
			</div>

			<div id="context">
				<div class="row">
					<div id="content-controls"></div>
				</div>
				
				<div id="q_results" name="q_results" class="row searchResultsMenu">
					<div class="col-auto"><a id="issue-result-menu" href="#issueresult"><?php echo $LNG->ISSUES_NAME; ?>: <span id="issue-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="solution-result-menu" href="#solutionresult"><?php echo $LNG->SOLUTIONS_NAME; ?>: <span id="solution-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="pro-result-menu" href="#proresult"><?php echo $LNG->PROS_NAME; ?>: <span id="pro-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="con-result-menu" href="#conresult"><?php echo $LNG->CONS_NAME; ?>: <span id="con-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="arg-result-menu" href="#argresult"><?php echo $LNG->ARGUMENTS_NAME; ?>: <span id="arg-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="map-result-menu" href="#mapresult"><?php echo $LNG->MAPS_NAME; ?>: <span id="map-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="chat-result-menu" href="#chatresult"><?php echo $LNG->CHATS_NAME; ?>: <span id="chat-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="idea-result-menu" href="#idearesult"><?php echo $LNG->COMMENTS_NAME; ?>: <span id="idea-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="user-result-menu" href="#userresult"><?php echo $LNG->USERS_NAME; ?>: <span id="user-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="group-result-menu" href="#groupresult"><?php echo $LNG->GROUPS_NAME; ?>: <span id="group-list-count-main"></span></a></div>
				</div>

				<div id="content-issue-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="issue-list-count">0</span>
						<span id="issue-list-title"><?php echo $LNG->ISSUES_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top" class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="issueresult"></a>
					</div>
					<div class="searchresultcontent" id="content-issue-list"></div>
				</div>

				<div id="content-solution-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="solution-list-count">0</span> 
						<span id="solution-list-title"><?php echo $LNG->SOLUTIONS_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="solutionresult"></a>
					</div>
					<div class="searchresultcontent" id="content-solution-list"></div>
				</div>

				<div id="content-pro-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="pro-list-count">0</span> 
						<span id="pro-list-title"><?php echo $LNG->PROS_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="proresult"></a>
					</div>
					<div class="searchresultcontent" id="content-pro-list"></div>
				</div>

				<div id="content-con-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="con-list-count">0</span> 
						<span id="con-list-title"><?php echo $LNG->CONS_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="conresult"></a>
					</div>
					<div class="searchresultcontent" id="content-con-list"></div>
				</div>

				<div id="content-arg-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="arg-list-count">0</span> 
						<span id="arg-list-title"><?php echo $LNG->ARGUMENTS_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="argresult"></a>
					</div>
					<div class="searchresultcontent" id="content-arg-list"></div>
				</div>

				<div id="content-map-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="map-list-count">0</span> 
						<span id="map-list-title"><?php echo $LNG->MAPS_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="mapresult"></a>
					</div>
					<div class="searchresultcontent" id="content-map-list"></div>
				</div>

				<div id="content-chat-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="chat-list-count">0</span> 
						<span id="chat-list-title"><?php echo $LNG->CHATS_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="chatresult"></a>
					</div>
					<div class="searchresultcontent" id="content-chat-list"></div>
				</div>

				<div id="content-idea-main" class="searchresultblock">
					<div class="strapline searchresulttitle">
						<span id="idea-list-count">0</span> 
						<span id="idea-list-title"><?php echo $LNG->COMMENTS_NAME; ?></span>
						<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
						<a name="idearesult"></a>
					</div>
					<div class="searchresultcontent" id="content-idea-list"></div>
				</div>

				<div id="content-user-main" class="searchresultblock">
					<fieldset class="overviewfieldset">
						<legend class="overviewlegend widgettextcolor">
							<span id="user-list-count">0</span> 
							<span id="user-list-title"><?php echo $LNG->USERS_NAME; ?></span>
							<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
							<a name="userresult"></a>
						</legend>
						<div id="content-user-list"></div>
					</fieldset>
				</div>

				<div id="content-group-main" class="searchresultblock">
					<fieldset class="overviewfieldset">
						<legend class="overviewlegend widgettextcolor">
							<span id="group-list-count">0</span>
							<span id="group-list-title"><?php echo $LNG->GROUPS_NAME; ?></span>
							<a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"class="ms-2 search-backtotop">[<?php echo $LNG->SEARCH_BACKTOTOP; ?>]</a>
							<a name="groupresult"></a>
						</legend>
						<div id="content-group-list"></div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
