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

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/exploreutils.js.php').'" type="text/javascript"></script>');

    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

    $nodeid = required_param("id",PARAM_ALPHANUMEXT);
    $searchid = optional_param("sid","",PARAM_ALPHANUMEXT);
	if ($searchid != "" && isset($USER->userid)) {
		auditSearchResult($searchid, $USER->userid, $nodeid, 'N');
	}

    $chatnodeid = optional_param("chatnodeid","",PARAM_ALPHANUMEXT);

    $node = getNode($nodeid);

    if($node instanceof Hub_Error){
        echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
        include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
        die;
    }

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
	echo "var CHATNODEID = '".$chatnodeid."';";
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
	<div class="row p-3">		
		<div class="col">
			<script type='text/javascript'>
				Event.observe(window, 'load', function() {
					buildNodeTitle('chat');

					if (NODE_ARGS['nodetype'] == 'Challenge') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/challengechatstree.js.php", 'chatchallenge');
					} else if (NODE_ARGS['nodetype'] == 'Issue') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/issuechatstree.js.php", 'chatissue');
					} else if (NODE_ARGS['nodetype'] == 'Solution') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/solutionchatstree.js.php", 'chatsolution');
					} else if (NODE_ARGS['nodetype'] == 'Pro') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/prochatstree.js.php", 'chatpro');
					} else if (NODE_ARGS['nodetype'] == 'Con') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/conchatstree.js.php", 'chatcon');
					} else if (NODE_ARGS['nodetype'] == 'Argument') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/argumentchatstree.js.php", 'chatargument');
					} else if (NODE_ARGS['nodetype'] == 'Idea') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/commentchatstree.js.php", 'chatcomment');
					}
				});

				/**
				 * Refresh Chats sections after update.
				 */
				function refreshExploreChats() {
					getAllChatConnections();
				}
			</script>

			<?php if ($nodetype == 'Challenge') { ?>
				<div id="nodearealineartitle" class="challengeback challengeborder nodearealineartitle">
					<div class="challengeback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="nodearealineartitle" class="issueback issueborder nodearealineartitle">
					<div class="issueback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="nodearealineartitle" class="solutionback solutionborder nodearealineartitle">
					<div class="solutionback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Argument') { ?>
				<div id="nodearealineartitle" class="evidenceback evidenceborder nodearealineartitle">
					<div class="evidenceback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Pro') { ?>
				<div id="nodearealineartitle" class="proback proborder nodearealineartitle">
					<div class="proback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Con') { ?>
				<div id="nodearealineartitle" class="conback conborder nodearealineartitle">
					<div class="conback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Idea') { ?>
				<div id="nodearealineartitle" class="plainback plainborder nodearealineartitle">
					<div class="plainback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } ?>

			<div class="p-1 border-bottom d-block">
				<div id="headertoolbar" class="d-flex gap-4 headertoolbar align-items-center px-1 py-2"></div>
			</div>

			<div id="tabber" role="navigation">
				<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
					<div id='tab-content-explore-chat' class='explorepagesection'>
						<h2 class="mt-3"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> <?php echo $LNG->VIEWS_CHAT_TITLE; ?></h2>
						<span id="chattoolbar" class="d-block"></span>
						<div id="chatloading" class="d-block"></div>
						<div id="chatarea" class="d-block"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
