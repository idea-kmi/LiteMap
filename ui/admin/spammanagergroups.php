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

    if($USER == null || $USER->getIsAdmin() == "N"){
        echo "<div class='errors'>.".$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE."</div>";
        include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
        die;
	}

    $errors = array();

    if(isset($_POST["deletegroup"])){
		//$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);
    	//if ($groupid != "") {
			//$group = getGroup($groupid);
			// delete group and any upload folder
			//if (!adminDeleteUser($groupid)) {
			//	echo $LNG->ADMIN_MANAGE_USERS_DELETE_ERROR." ".$groupid;
			//}
    	//} else {
        //    array_push($errors,$LNG->SPAM_GROUP_ADMIN_ID_ERROR);
    	//}
    } else if(isset($_POST["archivegroup"])){
		$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);
   	if ($groupid != "") {
			archiveGroupAndChildren($groupid);
     	} else {
            array_push($errors,$LNG->SPAM_GROUP_ADMIN_ID_ERROR);
    	}
    } 
	else if(isset($_POST["restoregroup"])){
		$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);
    	if ($groupid != "") {
			$group = getGroup($groupid);
	   		$group->updateStatus($CFG->USER_STATUS_ACTIVE);
    	} else {
            array_push($errors,$LNG->SPAM_GROUP_ADMIN_ID_ERROR);
    	}
    }
	else if(isset($_POST["restorearchivedgroup"])){
		$groupid = optional_param("groupid","",PARAM_ALPHANUMEXT);
    	if ($groupid != "") {
			restoreArchivedGroupAndChildren($groupid);
    	} else {
            array_push($errors,$LNG->SPAM_GROUP_ADMIN_ID_ERROR);
    	}
    }

	$allGroups = array();

	$gs = getGroupsByStatus($CFG->USER_STATUS_REPORTED, 0, -1, 'name', 'ASC','long');
    $groups = $gs->groups;
 
	$count = (is_countable($groups)) ? count($groups) : 0;
    for ($i=0; $i<$count;$i++) {
    	$group = $groups[$i];
		$group->children = loadGroupChildDebates($group->groupid, $CFG->STATUS_ACTIVE);
		$reporterid = getSpamReporter($group->groupid);
		if ($reporterid != false) {
    		$reporter = new User($reporterid);
    		$reporter = $reporter->load();
    		$group->reporter = $reporter;
			$group->istop = true;	// only top if it was the reported item
    	}
		$allGroups[$group->groupid] = $group;
    }

	// groups are really user record entries
	$gs2 = getGroupsByStatus($CFG->USER_STATUS_ARCHIVED, 0, -1, 'name', 'ASC','long');
    $groupssarchivedinitial = $gs2->groups;
	$archivedgroups  = [];

	$count2 = (is_countable($groupssarchivedinitial)) ? count($groupssarchivedinitial) : 0;
    for ($i=0; $i<$count2;$i++) {
    	$group = $groupssarchivedinitial[$i];
    	$reporterid = getSpamReporter($group->groupid);
    	if ($reporterid != false) {
    		$reporter = new User($reporterid);
    		$reporter = $reporter->load();
    		$group->reporter = $reporter;
			$group->children = loadGroupChildDebates($group->groupid, $CFG->STATUS_ARCHIVED);
			$group->istop = true; // only top if it was the reported item
			array_push($archivedgroups, $group);
   		}
		$allGroups[$group->groupid] = $group;
    }
?>

<script type="text/javascript">

	const allgroups = <?php echo json_encode($allGroups); ?>;

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

	function viewSpamUserDetails(groupid) {
		var width = getParentWindowWidth()-20;
		var height = getParentWindowHeight()-20;

		loadDialog('user', URL_ROOT+"user.php?groupid="+groupid, width, height);
	}

	function viewSpamGroupDetails(groupid) {
		var width = window.screen.width - 400;
		var height = window.screen.height - 400;

		loadDialog('group', URL_ROOT+"group.php?groupid="+groupid, width, height);
	}

	function checkFormRestore(name) {
		var ans = confirm("<?php echo $LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART1; ?>\n\n"+name+"?\n\n<?php echo $LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART2; ?>\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormDelete(name) {
		var ans = confirm("<?php echo $LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART1; ?>\n\n"+name+"?\n\n<?php echo $LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART2; ?>\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function checkFormSuspend(name) {
		var ans = confirm("<?php echo $LNG->SPAM_GROUP_ADMIN_ARCHIVE_CHECK_MESSAGE; ?>\n\n"+name+"?\n\n");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

	function viewGroupTree(groupid, containerid, rootname, toggleRow) {

		// close any opened divs
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

		var group = allgroups[groupid];

		const containerObj = document.getElementById(containerid);	
		if (containerObj.innerHTML == "&nbsp;") {
			containerObj.innerHTML = "";
			if (group && group.children.length > 0) {			
				displayConnectionNodes(containerObj, group.children, parseInt(0), true, groupid+"tree");
			}					
		}
	}
	window.onload = init;
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
			<h1 class="mb-3"><?php echo $LNG->SPAM_GROUP_ADMIN_TITLE; ?></h1>
			<div id="spamdiv"class="spamdiv">
				<div class="mb-5">
					<h3><?php echo $LNG->SPAM_GROUP_ADMIN_SPAM_TITLE; ?></h3>
					<div class="mb-3">
						<div id="groups" class="forminput">
							<?php
								$count = (is_countable($groups)) ? count($groups) : 0;
								if ($count == 0) { ?>
									<p><?= $LNG->SPAM_GROUP_ADMIN_NONE_MESSAGE ?></p>
								<?php } else { ?>		
									<table class='table table-sm'>
										<tr>
											<th width='50%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING1 ?></th>
											<th width='10%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 ?></th>
											<th width='20%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING0 ?></th>
										</tr>
										
										<?php foreach($groups as $group){ ?>
											<tr>
												<td><?= $group->name ?></td>
												<td>
													<?php echo '<span class="active" onclick="viewSpamGroupDetails(\''.$group->groupid.'\');">'.$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON.'</span>'; ?>
												</td>
												<td>
													<?php echo '<form id="second-'.$group->groupid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRestore(\''.htmlspecialchars($group->name).'\');">'; ?>
														<input type="hidden" id="groupid" name="groupid" value="<?= $group->groupid ?>" />
														<input type="hidden" id="restoregroup" name="restoregroup" value="" />
														<?php echo '<span class="active" onclick="if (checkFormRestore(\''.htmlspecialchars($group->name).'\')){ $(\'second-'.$group->groupid.'\').submit(); }" id="restorenode" name="restorenode">'.$LNG->SPAM_GROUP_ADMIN_RESTORE_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td>
													<?php echo '<form id="fourth-'.$group->groupid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormSuspend(\''.htmlspecialchars($group->name).'\');">'; ?>
														<input type="hidden" id="groupid" name="groupid" value="<?= $group->groupid ?>" />
														<input type="hidden" id="archivegroup" name="archivegroup" value="" />
														<?php echo '<span class="active" onclick="if (checkFormSuspend(\''.htmlspecialchars($group->name).'\')){ $(\'fourth-'.$group->groupid.'\').submit(); }" id="archivegroup" name="archivegroup">'.$LNG->SPAM_GROUP_ADMIN_ARCHIVE_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td>
													<?php 
														if (isset($group->reporter)) {
															echo '<a href="'. $CFG->homeAddress .'group.php?groupid='. $group->reporter->userid .'" class="active" target="_blank">'.$group->reporter->name.'</a>';
														} else {
															echo $LNG->CORE_UNKNOWN_USER_ERROR;
														}
													?>
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
					<h3><?php echo $LNG->SPAM_GROUP_ADMIN_ARCHIVED_TITLE; ?></h3>
					<div class="mb-3">
						<div id="archivedgroups" class="forminput">
							<?php
								$countu = 0;
								if (is_countable($archivedgroups)) {
									$countu = count($archivedgroups);
								}
								if ($countu == 0) { ?>
									<p><?= $LNG->SPAM_GROUP_ADMIN_NONE_ARCHIVED_MESSAGE ?></p>
								<?php } else { ?>
									<table class='table table-sm'>
										<tr>
											<th width='50%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING1 ?></th>
											<th width='10%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 ?></th>
											<th width='10%' class="d-none"><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 ?></th>
											<th width='20%'><?= $LNG->SPAM_GROUP_ADMIN_TABLE_HEADING0 ?></th>
										</tr>

										<?php foreach($archivedgroups as $group) { ?>
											<tr>											
												<td><?= $group->name ?></td>
												<td>
													<?php 
														echo '<span class="active" onclick="viewGroupTree(
															\''.$group->groupid.'\', 
															\''.$group->groupid.'treediv\', 
															\'treediv\', 
															\''.$group->groupid.'treeRow\');">'.$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON.'</span>'; 
													?>
												</td>
												<td>
													<?php echo '<form id="second-'.$group->groupid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRestore(\''.htmlspecialchars($group->name).'\');">'; ?>
														<input type="hidden" id="groupid" name="groupid" value="<?= $group->groupid ?>" />
														<input type="hidden" id="restorearchivedgroup" name="restorearchivedgroup" value="" />
														<?php echo '<span class="active" onclick="if (checkFormRestore(\''.htmlspecialchars($group->name).'\')){ $(\'second-'.$group->groupid.'\').submit(); }" id="restorearchivedgroup" name="restorearchivedgroup">'.$LNG->SPAM_GROUP_ADMIN_RESTORE_BUTTON.'</span>'; ?>
													</form>
												</td>
												<td class="d-none">
													<?= $LNG->SPAM_ADMIN_DELETE_BUTTON ?>
												</td>
												<td>
													<?php 
														if (isset($group->reporter)) {
															echo '<a href="'. $CFG->homeAddress .'user.php?userid='. $group->reporter->userid .'" class="active" target="_blank">'.$group->reporter->name.'</a>';
														} else {
															echo $LNG->CORE_UNKNOWN_USER_ERROR;
														}
													?>
												</td>
											</tr>
										
											<!-- add the tree display area row -->
											<tr id="<?= $group->groupid ?>treeRow" name="treediv" style="display:none">
												<td colspan="6">
													<div id="<?= $group->groupid ?>treediv">&nbsp;</div>
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

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>
