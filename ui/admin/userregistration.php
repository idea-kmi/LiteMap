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

	$sort = optional_param("sort","date",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","DESC",PARAM_ALPHANUM);

	$registeredUsers = getRegisteredUsers($direction, $sort, $oldsort);
	$countUsers = 0;
	if (is_countable($registeredUsers)) {
		$countUsers = count($registeredUsers);
	}
?>

<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/DataTables/datatables.min.css"); ?>" type="text/css" />
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/DataTables/datatables.js" type="text/javascript"></script>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">

			<h1 class="mb-3 d-flex align-items-center gap-3">
				<?php echo $LNG->ADMIN_NEWS_USERS; ?>
				<span class="badge rounded-pill" style="background-color: #4E725F; font-size: 0.7em;"><?=$countUsers?></span>
			</h1>

			<div class="adminTableDiv">						
				<table class="table table-sm table-striped table-hover compact dataTable" id="adminTableDiv">
					<thead class="table-light">
						<tr class="align-middle">
							<th></th>
							<th>Name</th>
							<th style="max-width: 600px;">Description</th>
							<th>Website</th>
							<th>Location</th>
							<th>Creation Date</th>
							<th>Last Sign in</th>
							<th class="text-end">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$countUsers = 0;
							if (is_countable($registeredUsers)) {
								$countUsers = count($registeredUsers);
							}
							if ($countUsers > 0) {
								for ($i=0; $i < $countUsers; $i++) {
									$array = $registeredUsers[$i];
									$name = $array['Name'];
									$userid = $array['UserID'];
									$date = $array['CreationDate'];
									$desc = $array['Description'];
									$website = $array['Website'];
									$lastlogin = $array['LastLogin'];
									$photo = '';
									$thumb = '';
									$status = $array['CurrentStatus'];
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

									$location = "";
									$country="";
									if(isset($array['LocationText'])){
										$location = $array['LocationText'];
									}
									if(isset($array['LocationCountry'])){
										$cs = getCountryList();
										if (isset($cs[$array['LocationCountry']])) {
											$country = $cs[$array['LocationCountry']];
										}
									}
								?>
									<tr>
										<td valign="top">
											<a title="<?= $LNG->SPAM_USER_ADMIN_VIEW_BUTTON ?>" href="<?= $CFG->homeAddress ?>user.php?userid=<?= $userid ?>">
												<img style="padding:5px;padding-bottom:10px;max-width:150px;max-height:100px;" src="<?= $thumb ?>" alt="profile picture of <?= $name ?>" />
											</a>
										</td>
										<td valign="top">
											<a href="<?= $CFG->homeAddress ?>user.php?userid=<?= $userid ?>" target="_blank"><?= $name ?></a>
										</td>
										<td valign="top">
											<?= $desc ?>
										</td>
										<td valign="top">
											<?php if ($website != null && $website != "") { ?>
												<a href="<?= $website ?>">Homepage</a>
											<?php } ?>
										</td>
										<td valign="top">
											<?php if ($location != "" || $country != "") {
												echo '<span>' . implode(', ', array_filter([$location, $country])) . '</span>';
											} ?>
										</td>
										<?php $prettydate = date( 'd/m/Y', $date); ?>
										<td class="text-end" valign="top" data-search="<?= $prettydate ?>" data-order="<?= $date ?>">
											<?= $prettydate ?>
										</td>
										<?php $prettydate2 = date( 'd/m/Y', $lastlogin); ?>
										<td class="text-end" valign="top" data-search="<?= $prettydate2 ?>" data-order="<?= $lastlogin ?>">
											<?= $prettydate2 ?>
										</td>
										<td class="text-center" valign="top">
											<?php if ($status == $CFG->USER_STATUS_REPORTED) { ?>
												<div class="d-block">
													<img class="active" src="<?= $HUB_FLM->getImagePath('flag-grey.png') ?>" title="<?= $LNG->SPAM_USER_REPORTED ?>" alt="<?= $LNG->SPAM_USER_REPORTED_ALT ?>"/>
												</div>
											<?php } else if ($status == $CFG->USER_STATUS_ACTIVE)  { ?>
												<div class="d-block">
													<img class="active" id="<?= $userid ?>" data-label="<?= $name ?>" src="<?= $HUB_FLM->getImagePath('flag.png') ?>" onclick="reportUserSpamAlert(this, '<?= $userid ?>')" title="<?= $LNG->SPAM_USER_REPORT ?>" alt="<?= $LNG->SPAM_USER_REPORT_ALT ?>"/>
												</div>
											<?php } else { ?>
												<div class="d-block">
													<img class="active" src="<?= $HUB_FLM->getImagePath('flag-grey.png') ?>" title="<?= $LNG->SPAM_USER_LOGIN_REPORT ?>" alt="<?= $LNG->SPAM_USER_LOGIN_REPORT_ALT ?>"/>
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
		$('#adminTableDiv').DataTable({
			"autoWidth": true,
			"responsive": true,
			"pageLength": 25,
        	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"columnDefs": [
				{ "orderable": false, "targets": 0 }
			],
			"order": [[5, "desc"]]
		});
	});
</script>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>
