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
	global $user, $LNG;
?>

<div id='tab-content-home-overview' class="user-tabs2 border border-top-0 p-3 pt-1">
	<div class="d-flex justify-content-between my-2">
		<h2><?php echo $LNG->USER_HOME_PROFILE_HEADING; ?></h2>
		<?php
			$user = $CONTEXTUSER; //$args['user'];
			$userid = $args['userid'];
			// Toolbar area.
			if(isset($USER->userid) && $USER->userid == $userid) { ?>
				<div>		
					<a class="active" title="<?php echo $LNG->HEADER_EDIT_PROFILE_LINK_HINT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/profile.php">
						<?php echo $LNG->HEADER_EDIT_PROFILE_LINK_TEXT; ?>
					</a>
					<?php if ($CFG->hasCIFImport) { ?>
						<a style="margin-left: 30px;" href="<?php echo $CFG->homeAddress; ?>ui/pages/importcif.php"><?php echo $LNG->USER_HOME_IMPORT_CIF_LINK; ?></a>
					<?php } ?>
				</div>
			<?php } 
		?>
	</div>

	<dl class="row">
		<?php if($user->description != ""){ ?>
			<dt class="col-md-2 col-sm-12"><?php echo $LNG->PROFILE_DESC_LABEL; ?></dt>
			<dd class="col-md-10 col-sm-12"><?php echo $user->description; ?></dd>
		<?php } ?>
	</dl>

	<p class="text-end"><a class="active" title="<?php echo $LNG->USER_HOME_ANALYTICS_LINK_HINT; ?>" onclick="javascript:loadDialog('viewuseranalytics','<?php echo $CFG->homeAddress; ?>ui/stats/userContextStats.php?userid=<?php echo $user->userid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ANALYTICS_LINK_TEXT; ?></a></p>

	<hr class="hrline" />

	<?php $nodeArray = getUserNodeTypeCreationCounts($user->userid); ?>

	<h2><?php echo $LNG->USER_HOME_VIEW_CONTENT_HEADING; ?></h2>
	<table class="table table-sm">
		<tr class="challengeback text-white">
			<td><strong><?php echo $LNG->USER_HOME_TABLE_ITEM_TYPE; ?></strong></td>
			<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_CREATION_COUNT; ?></strong></td>
			<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></strong></td>
		</tr>

		<?php
			$i=0;
			foreach($nodeArray as $n=>$c) {
				if ($n == 'Issue' 
				|| $n == 'Solution' 
				|| $n == 'Idea' 
				|| $n == 'Map' 
				|| $n == 'Pro' 
				|| $n == 'Con' 
				|| $n == 'Argument' 
				|| $n == 'Comment') {
				$i++;
			?>
			<tr>
				<td style="color: #666666">
					<?php
						if ($n == 'Issue') {
							echo $LNG->ISSUE_NAME;
						} else if ($n == 'Solution') {
							echo $LNG->SOLUTION_NAME;
						} else if ($n == 'Comment') {
							echo $LNG->CHAT_NAME;
						} else if ($n == 'Idea') {
							echo $LNG->COMMENT_NAME;
						} else if ($n == 'Map') {
							echo $LNG->MAP_NAME;
						} else if ($n == 'Pro') {
							echo $LNG->PRO_NAME;
						} else if ($n == 'Con') {
							echo $LNG->CON_NAME;
						} else if ($n == 'Argument') {
							echo $LNG->ARGUMENT_NAME;
						}
					?>
				</td>
				<td class="text-end"><?php echo $c ?></td>
				<td class="text-end">
					<?php
						if ($n == 'Issue') {
							echo '<a href="#data-issue" class="active" onclick="setTabPushed($(\'tab-issue-list-obj\'),\'data-issue\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						} else if ($n == 'Solution') {
							echo '<a href="#data-solution" class="active" onclick="setTabPushed($(\'tab-solution-list-obj\'),\'data-solution\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						} else if ($n == 'Comment') {
							echo '<a href="#data-chat" class="active" onclick="setTabPushed($(\'tab-chat-list-obj\'),\'data-chat\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						} else if ($n == 'Idea') {
							echo '<a href="#data-comment" class="active" onclick="setTabPushed($(\'tab-comment-list-obj\'),\'data-comment\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						} else if ($n == 'Map') {
							echo '<a href="#data-map" class="active" onclick="setTabPushed($(\'tab-map-list-obj\'),\'data-map\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						} else if ($n == 'Pro') {
							echo '<a href="#data-pro" class="active" onclick="setTabPushed($(\'tab-pro-list-obj\'),\'data-pro\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						} else if ($n == 'Con') {
							echo '<a href="#data-con" class="active" onclick="setTabPushed($(\'tab-con-list-obj\'),\'data-con\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						} else if ($n == 'Argument') {
							echo '<a href="#data-evidence" class="active" onclick="setTabPushed($(\'tab-evidence-list-obj\'),\'data-evidence\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
						}
					?>
				</td>
			</tr>
		<?php }
		}

		if ($i == 0) { ?>
			<tr>
				<td colspan='3'><p>You have done no activities yet.</p></td>
			</tr>
		<?php } ?>
	</table>

	<p class="text-end"><a class="active" title="<?php echo $LNG->USER_HOME_VIEW_ACTIVITIES_HINT; ?>" onclick="javascript:loadDialog('viewuseractivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewerusers.php?fromtime=0&userid=<?php echo $userid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_VIEW_ACTIVITIES_LINK; ?></a></p>
	
	<hr class="hrline" />

	<div class="row">
		<div class="col">
			<h2><?php echo $LNG->USER_HOME_FOLLOWING_HEADING; ?></h2>
			<div class="mb-2">
				<form id="followupdate" action="" enctype="multipart/form-data" method="post">
					<?php if(isset($USER->userid) && $USER->userid == $userid && $CFG->send_mail) { ?>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" value="Y" id="followsendemail" name="followsendemail" onclick="updateUserFollow()" <?php if (isset($USER->followsendemail) && $USER->followsendemail == 'Y') { ?> checked <?php } ?> />
							<label class="form-check-label" for="followsendemail">
								<?php echo $LNG->USER_HOME_ACTIVITY_ALERT; ?>
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="followruninterval" id="followruninterval-hourly" value="hourly" onclick="updateUserFollow()" <?php if ($USER->followruninterval == 'hourly'){ ?> checked <?php } ?> />
							<label class="form-check-label" for="followruninterval-hourly">
								<?php echo $LNG->USER_HOME_EMAIL_HOURLY; ?>
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="followruninterval" id="followruninterval-daily" value="daily" onclick="updateUserFollow()" <?php if ($USER->followruninterval == 'daily'){ ?> checked <?php } ?> />
							<label class="form-check-label" for="followruninterval-daily">
								<?php echo $LNG->USER_HOME_EMAIL_DAILY; ?>
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="followruninterval" id="followruninterval-weekly" value="weekly" onclick="updateUserFollow()" <?php if ($USER->followruninterval == 'weekly'){ ?> checked <?php } ?> />
							<label class="form-check-label" for="followruninterval-weekly">
								<?php echo $LNG->USER_HOME_EMAIL_WEEKLY; ?>
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="followruninterval" id="followruninterval-monthly" value="monthly" onclick="updateUserFollow()" <?php if ($USER->followruninterval == 'monthly'){ ?> checked <?php } ?> />
							<label class="form-check-label" for="followruninterval-monthly">
								<?php echo $LNG->USER_HOME_EMAIL_MONTHLY; ?>
							</label>
						</div>
					<?php }	?>
				</form>
			</div>

			<table class="table table-sm">
				<tr class="challengeback text-white">
					<td><strong><?php echo $LNG->USER_HOME_TABLE_TYPE; ?></strong></td>
					<td><strong><?php echo $LNG->USER_HOME_TABLE_NAME; ?></strong></td>
					<?php if ($USER->userid == $userid) {?>
						<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></strong></td>
					<?php } ?>
					<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></strong></td>
					<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></strong></td>
				</tr>
				<?php
					$followingCount = 0;
					$userArray = getUsersBeingFollowedByMe($user->userid);
					$i=0;
					$count = 0;
					if (is_countable($userArray)) {
						$count = count($userArray);
					}
					for ($j=0; $j<$count; $j++) {
						$next = $userArray[$j];
						$i++;
						$name = $next['Name'];
						$nextuserid = $next['UserID'];
					?>
					<tr>
						<td style="color: #666666 "><?php echo $LNG->USER_HOME_PERSON_LABEL; ?></td>
						<td><?php echo $name ?></td>
						<?php if ($USER->userid == $userid) {?>
							<td class="text-end">
								<a class="active" href="javascript:unfollowMyUser('<?php echo $nextuserid; ?>');"><?php echo $LNG->USER_HOME_UNFOLLOW_LINK; ?></a>
							</td>
						<?php } ?>
						<td class="text-end">
							<a class="active" href="<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $nextuserid; ?>"><?php echo $LNG->USER_HOME_EXPLORE_LINK; ?></a>
						</td>
						<td class="text-end">
							<span class="active" onclick="loadDialog('viewuseractivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewerusers.php?userid=<?php echo $nextuserid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ACTIVITY_LINK; ?></span>
						</td>
					</tr>
				<?php }
					if ($i > 0) {
						$followingCount = $i;
					}
					$itemArray = getItemsBeingFollowedByMe($userid);
					$i=0;
					$nodeType = "";
					$count2 = 0;
					if (is_countable($itemArray)) {
						$count2 = count($itemArray);
					}
					if ($count > 0) {
						echo '<tr><td colspan="5"><hr class="hrline" style="height:1px; width: 100%" /></td></td>';
					}
					for ($j = 0; $j<$count2; $j++) {
						$nextitem = $itemArray[$j];
						$n = $nextitem['NodeType'];

						if ( ($nodeType != "" && $n != $nodeType && $i > 0) ) {
							echo '<tr><td colspan="5"><hr class="hrline" style="height:1px; width: 100%" /></td></td>';
						}

						$nodeType = $n;

						$name = $nextitem['Name'];
						$nodeid = $nextitem['NodeID'];
						if (in_array($n, $CFG->EVIDENCE_TYPES) || in_array($n, $CFG->BASE_TYPES)) {
							$i++;
							?>
							<tr>
								<td style="color: #666666 ">
									<?php
										if ($n == 'Pro') {
											echo $LNG->PRO_NAME;
										} else if ($n == 'Con') {
											echo $LNG->CON_NAME;
										} else if ($n == 'Argument') {
											echo $LNG->ARGUMENT_NAME;
										} else if ($n == 'Idea') {
											echo $LNG->COMMENT_NAME;
										} else if ($n == 'Issue') {
											echo $LNG->ISSUE_NAME;
										} else if ($n == 'Solution') {
											echo $LNG->SOLUTION_NAME;
										} else if ($n == 'Comment') {
											echo $LNG->COMMENT_NAME;
										}
									?>
								</td>
								<td><?php echo $name ?></td>
								<?php if ($USER->userid == $userid) {?>
									<td class="text-end">
										<a class="active" href="javascript:unfollowMyNode('<?php echo $nodeid; ?>');">Unfollow</a>
									</td>
								<?php } ?>
									<td class="text-end">
										<a class="active" href="<?php echo $CFG->homeAddress; ?>explore.php?id=<?php echo $nodeid; ?>">Explore</a>
									</td>
									<td class="text-end">
										<a class="active" href="javascript:loadDialog('viewactivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewer.php?nodeid=<?php echo $nodeid; ?>', 800, 600);">Activity</a>
									</td>
								</tr>
							<?php }
						}
						if ($i > 0) {
							$followingCount .= $i;
						}

						if ($followingCount == 0) { ?>
							<tr>
								<td colspan='5'><p><?php echo $LNG->USER_HOME_NOT_FOLLOWING_MESSAGE; ?></p></td>
							</tr>
						<?php } ?>
			</table>
		</div>
		<div class="col">
			<h2 style="margin-bottom: 44px;"><?php echo $LNG->USER_HOME_FOLLOWERS_HEADING; ?></h2>
			<table class="table table-sm">
				<tr class="challengeback text-white">
					<td><strong><?php echo $LNG->USER_HOME_TABLE_PICTURE; ?></strong></td>
					<td><strong><?php echo $LNG->USER_HOME_TABLE_NAME; ?></strong></td>
					<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></strong></td>
				</tr>
				<?php
					$i=0;
					$userSet = getUsersByFollowing($userid, 0, -1,'date','DESC');
					if ($userSet->count > 0) {
						for ($j=0; $j < $userSet->count; $j++) {
							$nextuser = $userSet->users[$j];
							if ($nextuser instanceof Hub_Error) {
								$i++; // just skip it
							} else {
								$i++;
							?>
							<tr>
								<td style="color: #666666 ">
									<a class="active" href="<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $nextuser->userid; ?>">
										<img src="<?php echo $nextuser->thumb;?>" />
									</a>
								</td>
								<td><?php echo $nextuser->name ?></td>
								<td class="text-end">
									<a class="active" href="<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $nextuser->userid; ?>">Explore</a>
								</td>
							</tr>
						<?php }
						}
					}
					if ($i == 0) { ?>
						<tr><td colspan='3'><p><?php echo $LNG->USER_HOME_NO_FOLLOWERS_MESSAGE; ?></p></td></tr>
					<?php } ?>
			</table>
		</div>
	</div>
</div>
