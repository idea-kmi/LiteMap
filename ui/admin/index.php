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
        //reject user
        echo $LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE;
        include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
        die;
    }
?>
<?php
	/***** TOTAL USERS ****/
	$time = 'months';
	$startdate = $CFG->START_DATE;
	$startdate = strtotime( 'first day of ' , $startdate);

	$dates = new DateTime();
	$dates->setTimestamp($startdate);
	$interval = date_create('now')->diff( $dates );

	$count = $interval->m;
	$years = $interval->y;
	if (isset($years) && $years > 0) {
		$count += ($interval->y * 12);
	}
	$count = $count+1; //(to get it to this month too);
	$grandtotal = 0;
	for ($i=0; $i<$count; $i++) {

		if ($i < 1) {
			$mintime= $startdate;
		} else {
			$mintime= $maxtime;
		}

		$maxtime = strtotime( '+1 month', $mintime);

		$monthlytotal = getRegisteredUserCount($mintime, $maxtime);
		$grandtotal += $monthlytotal;
	}

	$allGroups = getGroupsByGlobal(0,-1,'date','ASC');

	$countgroups = 0;
	if (is_countable($allGroups->groups)) {
		$countgroups = count($allGroups->groups);
	}

	$grandtotal1 = 0;
	$categoryArray = array();

	$icount = getNodeCreationCount("Issue",$startdate);
	$next = array();
	$next[0] = $LNG->ISSUES_NAME;
	$next[1] = $icount;
	$next[2] = $HUB_FLM->getImagePath('nodetypes/Default/issue.png');
	array_push($categoryArray, $next);
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Solution',$startdate);
	$next = array();
	$next[0] = $LNG->SOLUTIONS_NAME;
	$next[1] = $icount;
	$next[2] = $HUB_FLM->getImagePath('nodetypes/Default/solution.png');
	array_push($categoryArray, $next);
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Pro',$startdate);
	$next = array();
	$next[0] = $LNG->PROS_NAME;
	$next[1] = $icount;
	$next[2] = $HUB_FLM->getImagePath('nodetypes/Default/plus-32x32.png');
	array_push($categoryArray, $next);
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Con',$startdate);
	$next = array();
	$next[0] = $LNG->CONS_NAME;
	$next[1] = $icount;
	$next[2] = $HUB_FLM->getImagePath('nodetypes/Default/minus-32x32.png');
	array_push($categoryArray, $next);
	$grandtotal1 += $icount;	
?>

<div class="container-fluid admin-index">
	<div class="row p-4 pt-0">
		<div class="col">

			<h1 class="mb-3"><?php echo $LNG->ADMIN_TITLE; ?></h1>

			<div class="d-flex">
				<div class="w-100 p-4 ps-0">

					<div class="row mb-3">
						<!-- Card -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-0 border-start border-primary shadow h-100 py-2">
								<div class="card-body">
									<a href="<?= $CFG->homeAddress ?>ui/admin/userregistration.php">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs fw-bold text-primary text-uppercase mb-1"><?= $LNG->USERS_NAME ?></div>
												<div class="h5 mb-0 fw-bold text-gray-800"><?= $grandtotal ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-user fa-2x text-gray-300"></i>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>

						<!-- Card -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-0 border-start border-info shadow h-100 py-2">
								<div class="card-body">
									<a href="<?= $CFG->homeAddress ?>ui/admin/groupslist.php">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs fw-bold text-info text-uppercase mb-1"><?= $LNG->GROUPS_NAME ?></div>
												<div class="h5 mb-0 fw-bold text-gray-800"><?= $countgroups ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-users fa-2x text-gray-300"></i>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<h3 class="mb-3 d-flex align-items-center gap-3">
							<?php echo $LNG->ADMIN_STATS_TAB_IDEAS; ?>
							<span class="badge rounded-pill" style="background-color: #4E725F; font-size: 0.7em;"><?=$grandtotal1?></span>
						</h3>

						<?php 
							foreach( $categoryArray as $next) { ?>
							<!-- Card -->
							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-0 border-start border-success shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs fw-bold text-success text-uppercase mb-1"><?= $next[0] ?></div>
												<div class="h5 mb-0 fw-bold text-gray-800"><?=  $next[1] ?></div>
											</div>
											<div class="col-auto">
												<img border="0" src="<?= $next[2] ?>" />
											</div>
										</div>
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
	include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>

