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
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/users.js.php').'" type="text/javascript"></script>');

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

    $nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);
    $fromtime = optional_param("fromtime","0",PARAM_TEXT);
    $node = getNode($nodeid);

    $as = getNodeActivity($nodeid, $fromtime, 0, -1);
    $activities = $as->activities;
?>
<script type="text/javascript">
	var activityitems = new Object();
	var useritems = new Object();
</script>

<div id="activitydiv">
    <div class="formrow">
        <div id="formsdiv" class="forminput">

        <?php
            echo "<table class='table' cellspacing='0' cellpadding='3' border='0'>";

            echo "<tr>";
            echo "<th width='100'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_DATE."</th>";
            echo "<th width='100'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_DONEBY."</th>";
            echo "<th width='150'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_ACTION."</th>";
            echo "<th width='400'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_ITEM."</th>";
            echo "</tr>";

			$i=0;
            foreach($activities as $activity) {

				$userObj = json_encode($activity->user);
                echo "<script type='text/javascript'>";
				echo "var user = ";
				echo $userObj;
				echo ";";
				echo "</script>";

				if ($activity->type == 'Follow') {
					echo "<tr>";
					echo "<td>";
					echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
					echo "</td>";

					echo "<td id='user".$i."'>";
					echo "<script type='text/javascript'>";
					echo "useritems['user".$i."'] = renderWidgetUser(user);";
					echo "</script></td>";

					echo "<td>";
					echo "<span class='labelinput' style='font-size: 100%;'>";
					echo $LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING_ITEM;
					echo "</span>";
					echo "</td>";

					echo "<td id='item".$i."'>&nbsp;";
					//echo "<script type='text/javascript'>";
					//echo " activityitems['item".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("follow.png")."\" />';";
					//echo "</script></td>";
					echo "</tr>";

				} else if ($activity->type == 'Vote') {
					echo "<tr>";
					echo "<td>";
					echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
					echo "</td>";

					echo "<td id='user".$i."'>";
					echo "<script type='text/javascript'>";
					echo "useritems['user".$i."'] = renderWidgetUser(user);";
					echo "</script></td>";

					echo "<td>";
					echo "<span class='labelinput' style='font-size: 100%;'>";
					if ($activity->changetype == 'Y') {
						echo $LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED_ITEM;
					} else if ($activity->changetype == 'N') {
						echo $LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED_ITEM;
					}
					echo "</span>";
					echo "</td>";

					echo "<td id='item".$i."'>";
					echo "<script type='text/javascript'>&nbsp;";
					/*if ($activity->changetype == 'Y') {
						echo " activityitems['item".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-up-filled3.png")."\" />';";
					} else if ($activity->changetype == 'N') {
						echo " activityitems['item".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-down-filled3.png")."\" />';";
					}*/
					echo "</script></td>";
					echo "</tr>";

				} else if ($activity->type == 'Node') {
					$innernode = $activity->node;
					if (!$innernode instanceof CNode) {
						if(!empty($innernode)){
							echo "<tr><td colspan='4'><div class='errors'>".$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE."<ul>";
							foreach ($innernode as $error){
								echo "<li>".$error."</li>";
							}
							echo "</ul></div></td></tr>";
						}
					} else if (
						in_array($innernode->role->name, $CFG->BASE_TYPES) ||
						in_array($innernode->role->name, $CFG->EVIDENCE_TYPES)
						) {

						try {
							$jsonnode = json_encode($innernode);
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "<br>";
						}

						echo "<script type='text/javascript'>";
						echo "var nodeObj = ";
						echo $jsonnode;
						echo ";";
						echo "</script>";

						echo "<tr>";
						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
						echo "</td>";

						echo "<td id='user".$i."'>";
						echo "<script type='text/javascript'>";
						echo "useritems['user".$i."'] = renderWidgetUser(user);";
						echo "</script></td>";

						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>";
						if ($activity->changetype == 'add') {
							echo $LNG->FORM_ACTIVITY_ACTION_ADDED_ITEM;
						} else if ($activity->changetype == 'edit') {
							echo $LNG->FORM_ACTIVITY_ACTION_EDITED_ITEM;
						}
						echo "</span>";
						echo "</td>";

						echo "<td id='item".$i."'>";
						echo "<script type='text/javascript'>";
						echo " if (nodeObj) { if (nodeObj.nodeid == '".$nodeid."') { activityitems['item".$i."'] = renderNodeFromLocalJSon(nodeObj, 'activity', nodeObj.role, true); }}";
						echo "</script></td>";
						echo "</tr>";
					}
				} else if ($activity->type == 'Connection') {
					$con = $activity->con;
					if (!$con instanceof Connection) {
						if(!empty($con)){
							echo "<tr><td colspan='4'><div class='errors'>".$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE."<ul>";
							foreach ($con as $error){
								echo "<li>".$error."</li>";
							}
							echo "</ul></div></td></tr>";
						}
					} else if ((in_array($con->from->role->name, $CFG->BASE_TYPES) ||
							in_array($con->from->role->name, $CFG->EVIDENCE_TYPES))
						&&
							(in_array($con->to->role->name, $CFG->BASE_TYPES) ||
							in_array($con->to->role->name, $CFG->EVIDENCE_TYPES))
						) {

						try {
							$jsoncon = json_encode($con);
						} catch (Exception $e) {
							echo 'Caught exception:'.$e->getMessage()."<br>";
						}

						echo "<script type='text/javascript'>";
						echo "var connection = ";
						echo $jsoncon;
						echo ";";
						echo "</script>";

						$otherend;
						$othernode;
						$otherrole;
						if ($con->from->nodeid != $nodeid) {
							$otherend = 'from';
							$othernode = $con->from;
							$otherrole = $con->fromrole;
						} else if ($con->to->nodeid != $nodeid) {
							$otherend = 'to';
							$othernode = $con->to;
							$otherrole = $con->torole;
						}

						$drawRow = true;
						if (in_array($node->role->name, $CFG->EVIDENCE_TYPES)
							&& ($othernode->role->name == "Solution")) {
							$drawRow = false;
						}

						if ($drawRow) {
							echo "<tr>";
							echo "<td>";
							echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
							echo "</td>";

							echo "<td id='user".$i."'>";
							echo "<script type='text/javascript'>";
							echo "useritems['user".$i."'] = renderWidgetUser(user);";
							echo "</script></td>";

							echo "<td>";
							echo "<span class='labelinput' style='font-size: 100%;'>";
							if ($activity->changetype == 'add') {
								if ($othernode->role->name == 'Comment') {
									echo $LNG->FORM_ACTIVITY_ACTION_ADDED." ".getNodeTypeText($othernode->role->name, false);
								} else if (in_array($othernode->role->name, $CFG->EVIDENCE_TYPES)) {
									if ($otherrole->name == 'Pro') {
										echo $LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_PRO;
									} else if ($otherrole->name == 'Con') {
										echo $LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_CON;
									} else {
										echo $LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE;
									}
								} else {
									echo $LNG->FORM_ACTIVITY_ACTION_ASSOCIATED_WITH." ".getNodeTypeText($othernode->role->name, false);
								}
							} else if ($activity->changetype == 'delete') {
								if ($othernode->role->name == 'Comment') {
									echo $LNG->FORM_ACTIVITY_ACTION_REMOVED." ".getNodeTypeText($othernode->role->name, false);
								} else if (in_array($othernode->role->name, $CFG->EVIDENCE_TYPES)) {
									echo $LNG->FORM_ACTIVITY_ACTION_REMOVED_EVIDENCE;
								} else {
									echo $LNG->FORM_ACTIVITY_ACTION_REMOVED_ASSOCIATION." ".getNodeTypeText($othernode->role->name, false);
								}
							}
							echo "</span>";
							echo "</td>";

							echo "<td id='item".$i."'>";
							echo "<script type='text/javascript'>";
							echo " if (connection) { if (connection.from.nodeid != '".$nodeid."') { activityitems['item".$i."'] = renderNodeFromLocalJSon(connection.from, 'activity', connection.from.role, true); }";
							echo "else if (connection.to.nodeid != '".$nodeid."') { activityitems['item".$i."'] = renderNodeFromLocalJSon(connection.to, 'activity', connection.to.role, true); } }";
							echo "</script></td>";
							echo "</tr>";
						}
					}
				}
                $i++;
            }

            echo "</table>";
        ?>
        </div>
    </div>

    <div class="formrow">
   		<input type="button" value="<?php echo $LNG->FORM_BUTTON_CLOSE; ?>" onclick="window.close();"/>
    </div>

</div>

<script type="text/javascript">
	function init(){
		$('dialogheader').insert("<?php echo $LNG->FORM_ACTIVITY_HEADING; ?> <?php echo htmlspecialchars($node->role->name);?>:<span style='font-size: 11pt'> <?php echo htmlspecialchars($node->name); ?></span>");

		$H(activityitems).each(function(pair){
			$(pair.key).insert(pair.value);
		});

		$H(useritems).each(function(pair){
			$(pair.key).insert(pair.value);
		});

	}

   	window.onload = init;
</script>


<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>