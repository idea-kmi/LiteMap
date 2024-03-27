<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2013-2023 The Open University UK                              *
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
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));
	include_once($HUB_FLM->getCodeDirPath("core/formats/json.php"));

    if($USER == null || $USER->getIsAdmin() == "N"){
         echo "<div class='errors'>.".$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE."</div>";
        include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
        die;
	}

    $errors = array();

	function encodeURIComponent($str) {
		$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
		return strtr(rawurlencode($str), $revert);
	}

    if(isset($_POST["deletenode"])){
		$nodeid = optional_param("nodeid","",PARAM_ALPHANUMEXT);
    	if ($nodeid != "") {
    		$node = new CNode($nodeid);
	   		$node = $node->delete();
    	} else {
            array_push($errors,$LNG->SPAM_ADMIN_ID_ERROR);
    	}
	} else if(isset($_POST["archivenode"])){
		$nodeid = optional_param("nodeid","",PARAM_ALPHANUMEXT);
		//echo "ARCHIVING: ".$nodeid;
		archivedNodeAndConnections($nodeid);
 
    } else if(isset($_POST["restorenode"])){
		$nodeid = optional_param("nodeid","",PARAM_ALPHANUMEXT);
    	if ($nodeid != "") {
    		$node = new CNode($nodeid);
	   		$node = $node->updateStatus($CFG->STATUS_ACTIVE);
    	} else {
            array_push($errors,$LNG->SPAM_ADMIN_ID_ERROR);
    	}   
	} else if(isset($_POST["restorenodearchive"])){
		$nodeid = optional_param("nodeid","",PARAM_ALPHANUMEXT);
		//echo "RESTORING: ".$nodeid;
		restoreNodeAndConnections($nodeid);
	}

	$allNodes = array();
	$format_json = new format_json();

	$ns = getNodesByStatus($CFG->STATUS_REPORTED, 0,-1,'name','ASC','long');
    $nodes = $ns->nodes;

	$count = (is_countable($nodes)) ? count($nodes) : 0;
    for ($i=0; $i<$count;$i++) {
    	$node = $nodes[$i];
		$nodetype = $node->role->name;
		//if ($nodetype == 'Map') {
		//	$node->children = loadMapData($node, $CFG->STATUS_ACTIVE);
		//} 		
	   	$reporterid = getSpamReporter($node->nodeid);
    	if ($reporterid != false) {
    		$reporter = new User($reporterid);
    		$reporter = $reporter->load();
    		$node->reporter = $reporter;
    	}
		$jsonnodestr = $format_json->format($node);
		$stripped_of_invalid_utf8_chars_string = iconv('UTF-8', 'UTF-8//IGNORE', $jsonnodestr); // in case older data has some
		$allNodes[$node->nodeid] = json_decode($stripped_of_invalid_utf8_chars_string);
    }


	$ns2 = getNodesByStatus($CFG->STATUS_ARCHIVED, 0,-1,'name','ASC','long');
    $nodesarchivedinitial = $ns2->nodes;

	$nodesarchived = [];
	$count2 = (is_countable($nodesarchivedinitial)) ? count($nodesarchivedinitial) : 0;
    for ($i=0; $i<$count2;$i++) {
    	$node = $nodesarchivedinitial[$i];
		$nodetype = $node->role->name;
		//if ($nodetype == 'Map') {
		//	loadMapData($node, $CFG->STATUS_ARCHIVED);
		//} 		
		$reporterid = getSpamReporter($node->nodeid);
   		if ($reporterid != false) {
    		$reporter = new User($reporterid);
    		$reporter = $reporter->load();
    		$node->reporter = $reporter;
			//$node->istop = true; 
			array_push($nodesarchived, $node);
		}
		$jsonnodestr = $format_json->format($node);
		$stripped_of_invalid_utf8_chars_string = iconv('UTF-8', 'UTF-8//IGNORE', $jsonnodestr); // in case older data has some
		$allNodes[$node->nodeid] = json_decode($stripped_of_invalid_utf8_chars_string);
    }

	// only hold top level archived nodes that have a reporter 
	// and are not children of another item also archived
	// will this cover everything?
	//for ($i=0; $i<$count2;$i++) {
    //	$node = $nodesarchivedinitial[$i];
	//	if (isset($node->reporter)) {
	//		$node->istop = true; 
	//		array_push($nodesarchived, $node);
    //	}
    //}	
?>

<script type="text/javascript">

	const allnodes = <?php echo json_encode($allNodes, JSON_INVALID_UTF8_IGNORE); ?>;

	function getParentWindowHeight(){
		var viewportHeight = 900;
		if (window.opener.innerHeight) {
			viewportHeight = window.opener.innerHeight;
		} else if (window.opener.document.documentElement && document.documentElement.clientHeight) {
			viewportHeight = window.opener.document.documentElement.clientHeight;
		} else if (window.opener.document.body)  {
			viewportHeight = window.opener.document.body.clientHeight;
		}
		return viewportHeight;
	}

	function getParentWindowWidth(){
		var viewportWidth = 700;
		if (window.opener.innerHeight) {
			viewportWidth = window.opener.innerWidth;
		} else if (window.opener.document.documentElement && document.documentElement.clientHeight) {
			viewportWidth = window.opener.document.documentElement.clientWidth;
		} else if (window.opener.document.body)  {
			viewportWidth = window.opener.document.body.clientWidth;
		}
		return viewportWidth;
	}

	function viewSpamUserDetails(userid) {
		var width = getParentWindowWidth()-20;
		var height = getParentWindowHeight()-20;

		loadDialog('user', URL_ROOT+"user.php?userid="+userid, width, height);
	}

	function viewSpamItemDetails(nodeid, nodetype) {
		var width = window.screen.width - 400;
		var height = window.screen.height - 400;

		loadDialog('details', URL_ROOT+"explore.php?id="+nodeid, width, height);
	}

	function checkFormRestore(name) {
		var ans = confirm("<?php echo $LNG->SPAM_ADMIN_RESTORE_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormArchive(name) {
		var ans = confirm("<?php echo $LNG->SPAM_ADMIN_ARCHIVE_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormDelete(name) {
		var ans = confirm("<?php echo $LNG->SPAM_ADMIN_DELETE_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function viewItemTree(nodeid, nodetype, containerid, rootname, toggleRow, status) {

		// close any opened row
		const divsArray = document.getElementsByName(rootname);
		for (let i=0; i < divsArray.length; i++) {
			if (divsArray[i].id !== toggleRow) {
				divsArray[i].style.display = 'none';
			}
		}

		// Toggle row
		const row = document.getElementById(toggleRow);
		if (row.style.display == "none") {
			row.style.display = "";
		} else {
			row.style.display = "none";
		}

		// only draw the tree once, then after that just show it
		const containerObj = document.getElementById(containerid);	
		if (containerObj.innerHTML == "&nbsp;") {
			
			var node = allnodes[nodeid];
			if (node.cnode && node.cnode.length > 0) {	node.cnode = node.cnode[0]; }

			if (nodetype == 'Map') {			
				containerObj.innerHTML = '<span style="font-size: 0.9em;font-style:italic"><?php echo $LNG->ADMIN_TREEVIEW_LOADING; ?></span>';
				var reqUrl = SERVICE_ROOT + "&method=adminloadmapchildnodes&nodeid="+nodeid+"&status="+status;

				document.body.style.cursor = "wait"; 

				new Ajax.Request(reqUrl, { method:'get',
					onSuccess: function(transport) {
						var json = null;
						try {
							json = transport.responseText.evalJSON();
						} catch(e) {
							alert(e);
						}
						if(json.error){
							alert(json.error[0].message);
							return;
						}

						//console.log(json);

						mapnode = node;
						mapnode.cnode.connections = json.cnode[0].connections;
						mapnode.cnode.nodes = json.cnode[0].nodes;

						console.log(mapnode);

						const allConnections = mapnode.cnode.connections[0].connectionset.connections;

						// sort the connections into trees
						if (allConnections && Array.isArray(allConnections)) {
							mapnode.cnode.children = getTreeMap(allConnections);
						}

						const lonenodes = mapnode.cnode.nodes[0].nodeset.nodes;
						if (lonenodes &&  Array.isArray(lonenodes)) {
							// add in any lone nodes - not part of a connection in the map
							for (let j=0; j<lonenodes.length; j++) {
								mapnode.cnode.children.push(lonenodes[j]);
							}
						}

						//console.log(mapnode.cnode.children.length);
						if (mapnode.cnode.children.length > 0) {
							mapnode.cnode.istop = true;
						}
					 
						document.body.style.cursor = "pointer"; 
						containerObj.innerHTML = "";

						displayConnectionNodes(containerObj, [mapnode], parseInt(0), true, nodeid+"tree");
					},
					onFailure: function(transport) {
						document.body.style.cursor = "pointer"; 
						containerObj.innerHTML = "<?php echo $LNG->ADMIN_TREEVIEW_LOADING_FAILED; ?>";
					}
				});
			} else {
				displayConnectionNodes(containerObj, [node], parseInt(0), true, nodeid+"tree");
			}
		}
	}
</script>

<?php
	if(!empty($errors)){
		echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
		foreach ($errors as $error){
			echo "<li>".$error."</li>";
		}
		echo "</ul></div>";
	}
?>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">
			<h1 class="mb-3"><?php echo $LNG->SPAM_ADMIN_TITLE; ?></h1>
			<div id="spamdiv"class="spamdiv">
				<div class="mb-5">
					<h3><?php echo $LNG->SPAM_ADMIN_SPAM_TITLE; ?></h3>
					<div class="mb-3">
						<div id="nodes" class="forminput">
							<?php
								$count = (is_countable($nodes)) ? count($nodes) : 0;
								if ($count == 0) { ?>
									<p><?= $LNG->SPAM_ADMIN_NONE_MESSAGE ?></p>
								<?php } else { ?>
									<table class="table table-sm table-striped table-hover compact">
										<tr>
											<th width='40%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING1 ?></th>
											<th width='10%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING3 ?></th>
											<th width='10%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING2 ?></th>
											<th width='20%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING0 ?></th>
										</tr>
										
										<?php foreach($nodes as $node){ ?>
											<tr>
												<td><?= $node->name ?></td>
												<td>
													<?php 
														$nodetypename = '';
														if ($node->role->name == 'Issue') {
															$nodetypename = $LNG->DEBATE_NAME; //default for type is Issue - I want to show debate
														} else {
															$nodetypename = getNodeTypeText($node->role->name, false);
														}
													?>
													<?= $nodetypename ?>
												</td>
												<td>
													<?php 
														echo '<span class="active" onclick="viewItemTree(\''.$node->nodeid.'\', \''.$node->role->name.'\', \''.$node->nodeid.'treediv\', \'treediv\', \''.$node->nodeid.'treeRow\', \''.$CFG->STATUS_ACTIVE.'\');">'.$LNG->SPAM_ADMIN_VIEW_BUTTON.'</span>'; 
														//echo '<span class="active" onclick="viewSpamItemDetails(\''.$node->nodeid.'\', \''.$node->role->name.'\');">'.$LNG->SPAM_ADMIN_VIEW_BUTTON.'</span>'; 
													?>
												</td>
												<td>
													<?php echo '<form id="second-'.$node->nodeid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRestore(\''.htmlspecialchars($node->name).'\');">'; ?>
														<input type="hidden" id="nodeid" name="nodeid" value="<?= $node->nodeid ?>" />
														<input type="hidden" id="restorenode" name="restorenode" value="" />
														<?php echo '<span class="active" onclick="if (checkFormRestore(\''.htmlspecialchars($node->name).'\')){ $(\'second-'.$node->nodeid.'\').submit(); }" id="restorenode" name="restorenode">'.$LNG->SPAM_ADMIN_RESTORE_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td>
													<?php echo '<form id="third-'.$node->nodeid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormArchive(\''.htmlspecialchars($node->name).'\');">'; ?>
														<input type="hidden" id="nodeid" name="nodeid" value="<?= $node->nodeid ?>" />
														<input type="hidden" id="archivenode" name="archivenode" value="" />
														<?php echo '<span class="active" onclick="if (checkFormArchive(\''.htmlspecialchars($node->name).'\')) { $(\'third-'.$node->nodeid.'\').submit(); }" id="archivenode" name="archivenode">'.$LNG->SPAM_ADMIN_ARCHIVE_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td>
													<?php 
														if (isset($node->reporter)) {
															echo '<a href="'. $CFG->homeAddress .'user.php?userid='. $node->reporter->userid .'" class="active" target="_blank">'.$node->reporter->name.'</a>';
														} else {
															echo $LNG->CORE_UNKNOWN_USER_ERROR;
														}
													?>
												</td>
											</tr>

											<!-- add the tree display area row -->
											<tr id="<?= $node->nodeid ?>treeRow" name="treediv" style="display:none">
												<td colspan="6">
													<div id="<?= $node->nodeid ?>treediv">&nbsp;</div>
												</td>
											</tr>											
										<?php } ?>
									</table>
								<?php }
        					?>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<h3><?php echo $LNG->SPAM_ADMIN_ARCHIVE_TITLE; ?></h3>
					<div class="mb-3">
						<div id="nodesarchived" class="forminput">
							<?php
								$count = 0;
								if (is_countable($nodesarchived)) {
									$count = count($nodesarchived);
								}
								if ($count == 0) { ?>
									<p><?= $LNG->SPAM_ADMIN_NONE_ARCHIVED_MESSAGE ?></p>
								<?php } else { ?>
									<table class="table table-sm table-striped table-hover compact">
										<tr>
											<th width='40%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING1 ?></th>
											<th width='10%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING3 ?></th>
											<th width='10%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%' class="d-none"><?= $LNG->SPAM_ADMIN_TABLE_HEADING2 ?></th>
											<th width='20%'><?= $LNG->SPAM_ADMIN_TABLE_HEADING0 ?></th>
										</tr>

										<?php foreach($nodesarchived as $node) { ?>
											<tr>											
												<td><?= $node->name ?></td>
												<td>
													<?php 
														$nodetypename = '';
														if ($node->role->name == 'Issue') {
															$nodetypename = $LNG->DEBATE_NAME; //default for type is Issue - I want to show debate
														} else {
															$nodetypename = getNodeTypeText($node->role->name, false);
														}
													?>
													<?= $nodetypename ?>
												</td>
												<td>
													<?php 
														echo '<span class="active" onclick="viewItemTree(\''.$node->nodeid.'\', \''.$node->role->name.'\', \''.$node->nodeid.'treediv2\', \'treediv2\', \''.$node->nodeid.'treeRow2\', \''.$CFG->STATUS_ARCHIVED.'\');">'.$LNG->SPAM_ADMIN_VIEW_BUTTON.'</span>'; 
													?>
												</td>
												<td>
													<?php echo '<form id="second-'.$node->nodeid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRestore(\''.htmlspecialchars($node->name).'\');">'; ?>
														<input type="hidden" id="nodeid" name="nodeid" value="<?= $node->nodeid ?>" />
														<input type="hidden" id="restorenodearchive" name="restorenodearchive" value="" />
														<?php echo '<span class="active" onclick="if (checkFormRestore(\''.htmlspecialchars($node->name).'\')){ $(\'second-'.$node->nodeid.'\').submit(); }" id="restorenode" name="restorenode">'.$LNG->SPAM_ADMIN_RESTORE_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td class="d-none">
													<?= $LNG->SPAM_ADMIN_DELETE_BUTTON ?>
												</td>
												<td>
													<?php 
														if (isset($node->reporter)) {
															echo '<a href="'. $CFG->homeAddress .'user.php?userid='. $node->reporter->userid .'" class="active" target="_blank">'.$node->reporter->name.'</a>';
														} else {
															echo $LNG->CORE_UNKNOWN_USER_ERROR;
														}
													?>
												</td>
											</tr>
										
											<!-- add the tree display area row -->
											<tr id="<?= $node->nodeid ?>treeRow2" name="treediv2" style="display:none">
												<td colspan="6">
													<div id="<?= $node->nodeid ?>treediv2">&nbsp;</div>
												</td>
											</tr>

										<?php } ?>
									</table>
								<?php }
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>
