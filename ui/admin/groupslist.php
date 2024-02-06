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
	include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));

	global $CFG;

	if ($USER->getIsAdmin() != "Y") {
		echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
		include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
		die;
	}

    //array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath("ui/lib/DataTables/datatables.min.css").'">type="text/css" />');
    //array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/lib/DataTables/datatables.js').'" type="text/javascript"></script>');

	$sort = optional_param("sort","date",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","DESC",PARAM_ALPHANUM);

	$registeredGroups = getRegisteredGroups($direction, $sort, $oldsort);
	$countGroups = (is_countable($registeredGroups)) ? count($registeredGroups) : 0;
?>

<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/DataTables/datatables.min.css"); ?>" type="text/css" />
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/DataTables/datatables.js" type="text/javascript"></script>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">

			<h1 class="mb-3 d-flex align-items-center gap-3">
				<?php echo $LNG->ADMIN_NEWS_GROUPS; ?>
				<span class="badge rounded-pill" style="background-color: #4E725F; font-size: 0.7em;"><?= $countGroups ?></span>
			</h1>
			
			<div class="adminTableDiv">	
				<table class="table table-sm table-striped table-hover compact dataTable" id="adminGroupsTableDiv">
					<thead class="table-light">
						<tr class="align-middle">
							<th width="10%"></th>
							<th width="20%">Name</th>
							<th width="40%" style="max-width: 600px;">Description</th>
							<th width="10%">Members</th>
							<th width="10%">Date</th>
							<th width="10%">Action</th>
						</tr>
					</thead>

					<tbody>
					<?php
						$countGroups = 0;
						if (is_countable($registeredGroups)) {
							$countGroups = count($registeredGroups);
						}
						if ($countGroups > 0) {
							for ($i=0; $i<$countGroups; $i++) {
								$array = $registeredGroups[$i];
								$name = $array['Name'];
								$userid = $array['UserID'];
								$date = $array['CreationDate'];
								$desc = $array['Description'];
								$members = $array['MembersCount'];
								$photo = '';
								$thumb = '';
								if($array['Photo']){
									$originalphotopath = $HUB_FLM->createUploadsDirPath($userid."/".stripslashes($array['Photo']));
									if (file_exists($originalphotopath)) {
										$photo =  $HUB_FLM->getUploadsWebPath($userid."/".stripslashes($array['Photo']));
										$thumb =  $HUB_FLM->getUploadsWebPath($userid."/".str_replace('.','_thumb.', stripslashes($array['Photo'])));
										if (!file_exists($thumb)) {
											create_image_thumb($array['Photo'], $CFG->IMAGE_THUMB_WIDTH, $userid);
										}
									} else {
										$photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_USER_PHOTO);
										$thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_USER_PHOTO)));
									}
								} else {
									$photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_USER_PHOTO);
									$thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_USER_PHOTO)));
								}

								echo '<tr>';
									echo '<td valign="top">';
										echo '<a title="'.$LNG->SPAM_USER_ADMIN_VIEW_BUTTON.'" href="'.$CFG->homeAddress.'user.php?userid='.$userid.'"><img style="padding:5px;padding-bottom:10px;max-width:150px;max-height:100px;" src="'.$thumb.'" alt="profile picture of '.$name.'" /></a>';
									echo '</td>';
									echo '<td valign="top">';
										echo '<a href="../../group.php?groupid='.$array['UserID'].'">'.$name.'</a>';
									echo '</td>';
									echo '<td valign="top">';
										echo $desc;
									echo '</td>';
									echo '<td valign="top">';
										echo $members;
									echo '</td>';			
									
									$prettydate = strftime( '%d/%m/%Y', $date);
									echo '<td valign="top" data-search="'.$prettydate.'" data-order="'.$date.'">';
										echo $prettydate;
									echo '</td>';
									?>

									<td valign="top">
									<?php if ($status == $CFG->USER_STATUS_REPORTED) { ?>
										<div class="d-block">
											<img class="active" src="<?= $HUB_FLM->getImagePath('flag-grey.png') ?>" title="<?= $LNG->SPAM_GROUP_REPORTED ?>" alt="<?= $LNG->SPAM_GROUP_REPORTED_ALT ?>"/>
										</div>
									<?php } else if ($status == $CFG->USER_STATUS_ACTIVE)  { ?>
										<div class="d-block">
											<img id="<?= $userid ?>" data-label="<?= $name ?>" class="active" src="<?= $HUB_FLM->getImagePath('flag.png') ?>" onclick="reportGroupSpamAlert(this)" title="<?= $LNG->SPAM_GROUP_REPORT ?>" alt="<?= $LNG->SPAM_GROUP_REPORT_ALT ?>"/>
										</div>
									<?php } else { ?>
										<div class="d-block">
											<img class="active" src="<?= $HUB_FLM->getImagePath('flag-grey.png') ?>" title="<?= $LNG->SPAM_GROUP_LOGIN_REPORT ?>" alt="<?= $LNG->SPAM_GROUP_LOGIN_REPORT_ALT ?>"/>
										</div>
									<?php } ?>																		
								</td>
								
								</tr>
								<?php								
							}
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery.noConflict();
	jQuery(document).ready(function($) {
		$('#adminGroupsTableDiv').DataTable({
			"autoWidth": true,
			"responsive": true,
			"pageLength": 25,
        	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"columnDefs": [
				{ "orderable": false, "targets": 0 }
			],
			"order": [[4, "desc"]]
		});
	});
</script>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>
