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

    $nodeid = required_param("id",PARAM_ALPHANUMEXT);
    $searchid = optional_param("sid","",PARAM_ALPHANUMEXT);
	if ($searchid != "" && isset($USER->userid)) {
		auditSearchResult($searchid, $USER->userid, $nodeid, 'N');
	}

    $node = getNode($nodeid);
    if($node instanceof Hub_Error){
        echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
        include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
        die;
    } else {
		// reported items are not visible.
		// even admins can't see archived items - have to look at the content through the archived items admin screen
		if ($node->status != $CFG->STATUS_ACTIVE 
				&& (!isset($USER->userid) || $USER->getIsAdmin() == "N" || $node->status == $CFG->STATUS_ARCHIVED)) {
			include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
			echo "<div class='errors'>".$LNG->ITEM_NOT_AVAILABLE_ERROR."</div>";
			include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
			die;
		} 	

		if ($node->role->name == "Map") {
			if (isset($searchid) && $searchid != "") {
				header('Location: '.$CFG->homeAddress.'map.php?id='.$nodeid.'&sid='.$searchid);
			} else {
				header('Location: '.$CFG->homeAddress.'map.php?id='.$nodeid);
			}
			exit();
		}

		$userid = "";
		if (isset($USER->userid)) {
			$userid = $USER->userid;
		}
		auditView($userid, $nodeid, 'explore');
    }

    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/exploreutils.js.php').'" type="text/javascript"></script>');
	array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/widget.js.php').'" type="text/javascript"></script>');
	array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath("widget.css").'" type="text/css" media="screen" />');

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

    $nodetype = $node->role->name;

    $args = array();

    $args["nodeid"] = $nodeid;
    $args["nodetype"] = $nodetype;
    $args["title"] = $node->name;

	$CONTEXT = $CFG->NODE_CONTEXT;

   // now trigger the js to load data
    $argsStr = "{";
    $keys = array_keys($args);
	$keycount = 0;
	if (is_countable($keys)) {
		$keycount = count($keys);
	}
    for($i=0;$i< $keycount; $i++){
        $argsStr .= '"'.$keys[$i].'":"'.addslashes($args[$keys[$i]]).'"';
        if ($i != ($keycount-1)){
            $argsStr .= ',';
        }
    }
    $argsStr .= "}";

    echo "<script type='text/javascript'>";
    echo "var CONTEXT = '".$CONTEXT."';";
    echo "var NODE_ARGS = ".$argsStr.";";
	echo "var USER_ARGS = ".$argsStr.";";
	echo "var CHALLENGE_ARGS = ".$argsStr.";";
	echo "var ISSUE_ARGS = ".$argsStr.";";
	echo "var SOLUTION_ARGS = ".$argsStr.";";
	echo "var EVIDENCE_ARGS = ".$argsStr.";";
	echo "var COMMENT_ARGS = ".$argsStr.";";
	echo "</script>";

	try {
		$jsonnode = json_encode($node, JSON_INVALID_UTF8_IGNORE);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "<br>";
	}

	echo "<script type='text/javascript'>";
	echo "var nodeObj = ";
	echo $jsonnode;
	echo ";";
	echo "</script>";
?>

<div class="container-fluid">
	<div class="row">
		<div class="col mt-3">
			<script type='text/javascript'>
				Event.observe(window, 'load', function() {
					if (NODE_ARGS['nodetype'] == 'Challenge') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/challengenode.js.php"); ?>', 'explorechallenge');
					} else if (NODE_ARGS['nodetype'] == 'Issue') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/issuenode.js.php"); ?>', 'exploreissue');
					} else if (NODE_ARGS['nodetype'] == 'Solution') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/solutionnode.js.php"); ?>', 'exploresolution');
					} else if (NODE_ARGS['nodetype'] == 'Pro') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/pronode.js.php"); ?>', 'explorepro');
					} else if (NODE_ARGS['nodetype'] == 'Con') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/connode.js.php"); ?>', 'explorecon');
					} else if (NODE_ARGS['nodetype'] == 'News') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/newsnode.js.php"); ?>', 'explorenews');
					} else if (NODE_ARGS['nodetype'] == 'Idea') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/commentnode.js.php"); ?>', 'explorecomment');
					} else if (NODE_ARGS['nodetype'] == 'Argument') {
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/evidencenode.js.php"); ?>', 'exploreevidence');
					}
				});

				/**
				 * Refresh widget Challenges sections after update.
				 * @param nodetofocusid the id of a node in the results list to focus on.
				 */
				function refreshExploreChallenges(nodetofocusid) {
					refreshWidgetChallenges(nodetofocusid);
				}

				/**
				 * Refresh widget Issues sections after update.
				 * @param nodetofocusid the id of a node in the results list to focus on.
				 */
				function refreshExploreIssues(nodetofocusid) {
					refreshWidgetIssues(nodetofocusid);
				}

				/**
				 * Refresh widget Solutions sections after update.
				 * @param nodetofocusid the id of a node in the results list to focus on.
				 */
				function refreshExploreSolutions(nodetofocusid) {
					refreshWidgetSolutions(nodetofocusid);
				}

				/**
				 * Refresh widget Evidence sections after update.
				 * @param nodetofocusid the id of a node in the results list to focus on.
				 */
				function refreshExploreEvidence(nodetofocusid, type) {
					refreshWidgetEvidence(nodetofocusid, type);
				}

				/**
				 * Refresh widget Comments sections after update.
				 * @param nodetofocusid the id of a node in the results list to focus on.
				 */
				function refreshExploreComments() {
					refreshWidgetComments();
				}

				/**
				 * Refresh linear and widget Followers sections after update.
				 * @param nodetofocusid the id of a node in the results list to focus on.
				 */
				function refreshExploreFollowers() {
					refreshWidgetFollowers();
				}
			</script>
		
			<div id="toolbardiv" style="left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:140px;border:1px solid gray;background:white'"></div>

			<div id="tabber" role="navigation">
				<div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
				
					<!-- WIDGET PAGES -->
					<div id='tab-content-explore-widget' class='explorepagesection'>

						<?php if ($nodetype == 'Challenge') { ?>
							<div id="widgetareadiv" class="p-3 challengebackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 challengebackpale">
									<div id="widgetcolnode" class="col-lg-8 col-md-12">
										<div id="nodearea" class="tabletop"></div>
									</div>
									<div id="widgetcolright" class="col-lg col-md-12">
										<div id="mapsarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<div id="followersarea" class="tablelower mb-2"></div>
									</div>
								</div>
							</div>
						<?php } else if ($nodetype == 'Issue') { ?>
							<div id="widgetareadiv" class="p-3 issuebackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 issuebackpale">
									<div id="widgetcolnode" class="col-lg-8 col-md-12">
										<div id="nodearea" class="tabletop"></div>
									</div>
									<div id="widgetcolright" class="col-lg col-md-12">
										<div id="mapsarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<div id="followersarea" class="tablelower mb-2"></div>
									</div>
								</div>
							</div>
						<?php } else if ($nodetype == 'Solution') { ?>
							<div id="widgetareadiv" class="p-3 solutionbackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 solutionbackpale">
									<div id="widgetcolnode" class="col-lg-8 col-md-12">
										<div id="nodearea" class="tabletop"></div>
									</div>
									<div id="widgetcolright" class="col-lg col-md-12">
										<div id="mapsarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<div id="followersarea" class="tablelower mb-2"></div>
									</div>
								</div>
							</div>
						<?php } else if ($nodetype == 'Idea') { ?>
							<div id="widgetareadiv" class="p-3 plainbackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 plainbackpale">
									<div id="widgetcolnode" class="col-lg-8 col-md-12">
										<div id="nodearea" class="tabletop"></div>
									</div>
									<div id="widgetcolright" class="col-lg col-md-12">
										<div id="mapsarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<div id="followersarea" class="tablelower mb-2"></div>
									</div>
								</div>
							</div>
						<?php } else if ($nodetype == "Pro") { ?>
							<div id="widgetareadiv" class="p-3 probackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 probackpale">
									<div id="widgetcolnode" class="col-lg-8 col-md-12">
										<div id="nodearea" class="tabletop"></div>
									</div>
									<div id="widgetcolright" class="col-lg col-md-12">
										<div id="mapsarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<div id="followersarea" class="tablelower mb-2"></div>
									</div>
								</div>
							</div>
						<?php } else if ($nodetype == "Con") { ?>
							<div id="widgetareadiv" class="p-3 conbackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 conbackpale">
									<div id="widgetcolnode" class="col-lg-8 col-md-12">
										<div id="nodearea" class="tabletop"></div>
									</div>
									<div id="widgetcolright" class="col-lg col-md-12">
										<div id="mapsarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<div id="followersarea" class="tablelower mb-2"></div>
									</div>
								</div>
							</div>
						<?php } else if ($nodetype == "Argument") { ?>
							<div id="widgetareadiv" class="p-3 evidencebackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 evidencebackpale">
									<div id="widgetcolnode" class="col-lg-8 col-md-12">
										<div id="nodearea" class="tabletop"></div>
									</div>
									<div id="widgetcolright" class="col-lg col-md-12">
										<div id="mapsarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<div id="followersarea" class="tablelower mb-2"></div>
									</div>
								</div>
							</div>
						<?php } else if ($nodetype == 'News') { ?>
							<div id="widgetareadiv" class="p-3 themebackpale">
								<div id="widgettable" class="widgettable d-flex gap-4 themebackpale">
									<div id="widgetcolnode" valign='top'>
										<div id="nodearea" class="tabletop" style="width:100%;display: block;"></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
