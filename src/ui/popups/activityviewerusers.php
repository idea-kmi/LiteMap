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

    $userid = required_param("userid",PARAM_ALPHANUMEXT);
    $fromtime = optional_param("fromtime","0",PARAM_TEXT);
    $user = getUser($userid);

    $as = getUserActivity($userid, $fromtime, 0, -1);
    $activities = $as->activities;

	$userObj = json_encode($user);
	echo "<script type='text/javascript'>";
	echo "var user = ";
	echo $userObj;
	echo ";";
	echo "</script>";
?>
<script type="text/javascript">
	var activityitems = new Object();
	var useritems = new Object();
	useritems['usermain'] = renderWidgetUser(user);
</script>

<div id="activitydiv">
    <div class="formrow">
        <div id="formsdiv" class="forminput">

		<h1 id='usermain'></h1>

        <?php
            echo "<table class='table' cellspacing='0' cellpadding='3' border='0'>";

            echo "<tr>";
            echo "<th width='100'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_DATE."</th>";
            echo "<th width='100'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_TYPE."</th>";
            echo "<th width='150'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_ACTION."</th>";
            echo "<th width='500'>".$LNG->FORM_ACTIVITY_TABLE_HEADING_ITEM."</th>";
            echo "</tr>";

			$i=0;

			//echo "<tr><td>".count($activities)."</td></tr>";

            foreach($activities as $activity) {

				//echo "<tr><td>".$i.":".$activity->type."</td></tr>";

				if ($activity->type == 'Follow') {

					$follownode = getNode($activity->itemid);

					if (!$follownode instanceof CNode) {
						$followuser = getUser($activity->itemid);

						if ($followuser instanceof User) {

							$userObj = json_encode($followuser);
							echo "<script type='text/javascript'>";
							echo "var user = ";
							echo $userObj;
							echo ";";
							echo "</script>";


							echo "<tr>";
							echo "<td>";
							echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
							echo "</td>";

							echo "<td id='item".$i."'>";
							echo "<script type='text/javascript'>";
							echo " activityitems['item".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("follow.png")."\" />';";
							echo "</script></td>";

							echo "<td>";
							echo "<span class='labelinput' style='font-size: 100%;'>";
							echo $LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING;
							echo "</span>";
							echo "</td>";

							echo "<td id='user".$i."'>";
							echo "<script type='text/javascript'>";
							echo "useritems['user".$i."'] = renderWidgetUser(user);";
							echo "</script></td>";
						}
					} else if ($follownode instanceof CNode) {
						try {
							$jsonfollownode = json_encode($follownode);
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "<br>";
						}

						echo "<script type='text/javascript'>";
						echo "var nodeFollowObj = ";
						echo $jsonfollownode;
						echo ";";
						echo "</script>";

						echo "<tr>";
						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
						echo "</td>";

						echo "<td id='icon".$i."'>";
						echo "<script type='text/javascript'>";
						echo " activityitems['icon".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("follow.png")."\" />';";
						echo "</script></td>";

						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>";
						echo $LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING;
						echo "</span>";
						echo "</td>";

						echo "<td id='followitem".$i."'>";
						echo "<script type='text/javascript'>";
						echo " if (nodeFollowObj) { activityitems['followitem".$i."'] = renderNodeFromLocalJSon(nodeFollowObj, 'activity', nodeFollowObj.role, true); }";
						echo "</script></td>";
						echo "</tr>";
					}
				} else if ($activity->type == 'Vote') {
					$votenode = getNode($activity->itemid);
					if ($votenode instanceof CNode) {

						try {
							$jsonvotenode = json_encode($votenode);
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "<br>";
						}

						echo "<script type='text/javascript'>";
						echo "var nodeVoteObj = ";
						echo $jsonvotenode;
						echo ";";
						echo "</script>";

						echo "<tr>";
						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
						echo "</td>";

						echo "<td id='icon".$i."'>";
						echo "<script type='text/javascript'>";
						if ($activity->changetype == 'Y') {
							echo " activityitems['icon".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-up-filled3.png")."\" />';";
						} else if ($activity->changetype == 'N') {
							echo " activityitems['icon".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-down-filled3.png")."\" />';";
						}
						echo "</script></td>";

						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>";
						if ($activity->changetype == 'Y') {
							echo $LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED;
						} else if ($activity->changetype == 'N') {
							echo $LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED;
						}
						echo "</span>";
						echo "</td>";

						echo "<td id='voteitem".$i."'>";
						echo "<script type='text/javascript'>";
						echo " if (nodeVoteObj) { activityitems['voteitem".$i."'] = renderNodeFromLocalJSon(nodeVoteObj, 'activity', nodeVoteObj.role, true); }";
						echo "</script></td>";
						echo "</tr>";

						echo "</tr>";
					} else {
						echo "<tr>";
						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
						echo "</td>";

						if ($votenode instanceof Connection) {
							$con = $votenode;
							if ( $con->private == 'N' || $con->userid == $USER->userid ) {
								if ((in_array($con->from->role->name, $CFG->BASE_TYPES) ||
									in_array($con->from->role->name, $CFG->EVIDENCE_TYPES)
									&&
									(in_array($con->to->role->name, $CFG->BASE_TYPES) ||
									in_array($con->to->role->name, $CFG->EVIDENCE_TYPES)))) {

									try {
										$jsonconn = json_encode($con);
									} catch (Exception $e) {
										echo 'Caught exception: ',  $e->getMessage(), "<br>";
									}
									echo "<script type='text/javascript'>";
									echo "var connObj = ";
									echo $jsonconn;
									echo "; alert(connObj);";
									echo "</script>";

									echo "<td id='icon".$i."'>";
									echo "<script type='text/javascript'>";
									if ($activity->changetype == 'Y') {
										echo " activityitems['icon".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-up-filled.png")."\" />';";
									} else if ($activity->changetype == 'N') {
										echo " activityitems['icon".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-down-filled.png")."\" />';";
									}
									echo "</script></td>";

									echo "<td>";
									echo "<span class='labelinput' style='font-size: 100%;'>";
									echo $LNG->FORM_ACTIVITY_ACTION_INDICATED_THAT." ";
									echo "</span>";
									echo "</td>";

									echo "<td>";
										echo '<div style="clear:both; float:left;" id="fromitem'.$i.'"></div>';

										echo '<div style="clear:both; float:left;margin-top:10px;margin-bottom:10px;">';
										if ($activity->changetype == 'Y') {
											if ($votecon->fromrole->name == 'Solution') {
												echo $LNG->FORM_ACTIVITY_ACTION_STRONG_SOLUTION;
											} else if (in_array($votecon->fromrole->name, $CFG->EVIDENCE_TYPES) && $votecon->torole->name == "Solution") {
												echo $LNG->FORM_ACTIVITY_ACTION_CONVINCING_EVIDENCE;
											} else {
												echo $LNG->FORM_ACTIVITY_ACTION_PROMOTED;
											}
										} else if ($activity->changetype == 'N') {
											if ($votecon->fromrole->name == 'Solution') {
												echo $LNG->FORM_ACTIVITY_ACTION_WEAK_SOLUTION;
											} else if (in_array($votecon->fromrole->name, $CFG->EVIDENCE_TYPES) && $votecon->torole->name == "Solution") {
												echo $LNG->FORM_ACTIVITY_ACTION_UNCONVINCING_EVIDENCE;
											} else {
												echo $LNG->FORM_ACTIVITY_ACTION_DEMOTED;
											}
										}
										echo '</div>';

										echo '<div style="clear:both; float:left;" id="toitem'.$i.'"></div>';

										echo "<script type='text/javascript'>";
										echo " if (connObj) { activityitems['fromitem".$i."'] = renderNodeFromLocalJSon(connObj.from, 'activityvote', connObj.from.role, true); }";
										echo " if (connObj) { activityitems['toitem".$i."'] = renderNodeFromLocalJSon(connObj.to, 'activityvote', connObj.to.role, true); }";
										echo "</script>";

									echo "</td>";
									echo "</tr>";
								}
							}
						} else {
							echo "<td id='icon".$i."'>";
							echo "<script type='text/javascript'>";
							if ($activity->changetype == 'Y') {
								echo " activityitems['icon".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-up-filled.png")."\" />';";
							} else if ($activity->changetype == 'N') {
								echo " activityitems['icon".$i."'] = '<img src=\"".$HUB_FLM->getImagePath("thumb-down-filled.png")."\" />';";
							}
							echo "</script></td>";

							echo "<td>";
							echo "voted on</td>";

							echo "<td id='voteitem".$i."'>";
							echo "Unknown Connection (possibly now removed)</td>";
						}
					}

				} else if ($activity->type == 'Node') {
					$node = $activity->node;
					if (!$node instanceof CNode) {
						if(!empty($node)){
							echo "<tr><td colspan='4'><div class='errors'>".$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE."<ul>";
							foreach ($node as $error){
								echo "<li>".$error."</li>";
							}
							echo "</ul></div></td></tr>";
						}
					} else if (
						in_array($node->role->name, $CFG->BASE_TYPES) ||
						in_array($node->role->name, $CFG->EVIDENCE_TYPES)
						) {

						try {
							$jsonnode = json_encode($node);
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

						echo "<td>&nbsp;";
						echo "</td>";

						echo "<td>";
						echo "<span class='labelinput' style='font-size: 100%;'>";
						if ($activity->changetype == 'add') {
							echo $LNG->FORM_ACTIVITY_ACTION_ADDED;
						} else if ($activity->changetype == 'edit') {
							echo $LNG->FORM_ACTIVITY_ACTION_EDITED;
						}
						echo "</span>";
						echo "</td>";

						echo "<td id='itemNode".$i."'>";
						echo "<script type='text/javascript'>";
						echo " if (nodeObj) { activityitems['itemNode".$i."'] = renderNodeFromLocalJSon(nodeObj, 'activity', nodeObj.role, true); }";
						echo "</script></td>";
						echo "</tr>";
					}
				} else if ($activity->type == 'Connection') {
					$con = $activity->con;
					if (!$con instanceof Connection) {
						if(!empty($con)){
							/*echo "<tr><td colspan='4'><div class='errors'>".$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE."<ul>";
							foreach ($con as $error){
								echo "<li>".$error."</li>";
							}
							echo "</ul></div></td></tr>";*/
						}
					} else if ((in_array($con->from->role->name, $CFG->BASE_TYPES) ||
						in_array($con->from->role->name, $CFG->EVIDENCE_TYPES)
						&&
						(in_array($con->to->role->name, $CFG->BASE_TYPES) ||
						in_array($con->to->role->name, $CFG->EVIDENCE_TYPES)))) {

						try {
							$jsoncon = json_encode($con);
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "<br>";
						}

						echo "<script type='text/javascript'>";
						echo "var connection = ";
						echo $jsoncon;
						echo ";";
						echo "</script>";

						$otherend;
						$fromnode =$con->from;
						$tonode = $con->to;
						$fromrole = $con->fromrole;
						$torole = $con->torole;

						$drawRow = true;
						if (
							in_array($fromrole->name, $CFG->EVIDENCE_TYPES)
							&& isset($torole) && isset($torole->name)
							&& $torole->name == "Solution"
						) {
							$drawRow = false;
						}

						if ($drawRow) {
							echo "<tr>";

							echo "<td>";
							echo "<span class='labelinput' style='font-size: 100%;'>".date('d M Y', $activity->modificationdate)."</span>";
							echo "</td>";

							echo "<td>&nbsp;";
							echo "</td>";

							echo "<td>";
							if ($activity->changetype == 'add') {
								echo $LNG->FORM_ACTIVITY_ACTION_ASSOCIATED;
							} else if ($activity->changetype == 'delete') {
								echo $LNG->FORM_ACTIVITY_ACTION_DESOCIATED;
							}
							echo "</td>";

							echo "<td>";
								echo '<div style="clear:both; float:left;" id="fromitem'.$i.'"></div>';

								echo '<div style="clear:both; float:left;margin-top:10px;margin-bottom:10px;">';

								if ($activity->changetype == 'add') {
									echo $LNG->FORM_ACTIVITY_LABEL_WITH;
								} else if ($activity->changetype == 'delete') {
									echo $LNG->FORM_ACTIVITY_LABEL_FROM;
								}
								echo '</div>';

								echo '<div style="clear:both; float:left;" id="toitem'.$i.'"></div>';

								echo "<script type='text/javascript'>";
								echo " if (connection) { activityitems['fromitem".$i."'] = renderNodeFromLocalJSon(connection.from, 'activityconnection', connection.from.role, true); }";
								echo " if (connection) { activityitems['toitem".$i."'] = renderNodeFromLocalJSon(connection.to, 'activityconnection', connection.to.role, true); }";
								echo "</script>";
							echo "</td>";
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
		$('dialogheader').insert("<?php echo $LNG->FORM_ACTIVITY_HEADING; ?>");

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