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
 /** Author: Michelle Bachler, KMi, The Open University **/

    include_once("config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/exploreutils.js.php').'" type="text/javascript"></script>');

	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/lib/jit-2.0.2/Jit/jit.js" type="text/javascript"></script>');
	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/visualisations/graphlib.js.php" type="text/javascript"></script>');
	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/visualisations/forcedirectedlib.js.php" type="text/javascript"></script>');
	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/networklib.js.php" type="text/javascript"></script>');
	array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath('vis.css').'" type="text/css" media="screen" />');
	array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/base.css').'" type="text/css" />');
	array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/ForceDirected.css').'" type="text/css" />');

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
	echo "var USER_ARGS = ".$argsStr.";";
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
					var mapdetailsdiv = new Element("div", {'class':'boxshadowsquaredark', 'id':'mapdetailsdiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:380px;height:580px;'} );
					$("tab-content-explore-net").insert(mapdetailsdiv);
					buildNodeTitle('network');
					addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-map-net.js.php"); ?>', 'networkgraphmapdetails');
				});
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
			<?php } else if ($nodetype == 'Idea') { ?>
				<div id="nodearealineartitle" class="plainback plainborder nodearealineartitle">
					<div class="plainback tabtitlebar">
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
			<?php } ?>

			<div class="p-1 border-bottom d-block">
				<div id="headertoolbar" class="d-flex gap-4 headertoolbar align-items-center px-1 py-2"></div>
			</div>

			<div id="tabber">
				<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
					<div id='tab-content-explore-net' class='explorepagesection' style="display:block">
						<div id="tab-content-map-net">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
