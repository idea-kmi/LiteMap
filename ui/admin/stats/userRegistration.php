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

	include_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));

	global $CFG;

	if($USER->getIsAdmin() != "Y") {
		echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
		include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
		die;
	}

	$sort = optional_param("sort","date",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","DESC",PARAM_ALPHANUM);

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
	$tabledata = "";

	for ($i=0; $i<$count; $i++) {
		if ($i < 1) {
			$mintime= $startdate;
		} else {
			$mintime= $maxtime;
		}
		$maxtime = strtotime( '+1 month', $mintime);
		$monthlytotal = getRegisteredUserCount($mintime, $maxtime);
		$grandtotal += $monthlytotal;
		$tabledata .= '<tr>';
		$tabledata .= '<td class="ps-4">'.date("m / y", $mintime).'</td>';
		$tabledata .= '<td class="pe-4" align="right">'.$monthlytotal.'</td>';
		$tabledata .= '</tr>';
	}

?>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col-12">		

			<?php
				if (file_exists("menu.php") ) {
					include("menu.php");
				}
			?>

			<h1 class="my-4 d-flex align-items-center gap-3">
				<?php echo $LNG->ADMIN_STATS_REGISTER_TOTAL_LABEL; ?>
				<span class="badge rounded-pill" style="background-color: #4E725F; font-size: 0.7em;"><?=$grandtotal?></span>
			</h1>		
			<div class="text-center"><img class="img-fluid" src="usersGraph.php?time=months" alt="user registration graph" /></div>
		</div>
		<div class="col-lg-4 col-sm-6 col-xs-12 m-auto mt-4">

			<!-- MONTHLY TOTALS -->
			
			<div class="mb-5">
				<table class="table table-sm table-hover table-striped">
					<thead>
						<tr>
							<th class="ps-4 w-50"><strong>Month</strong></th>
							<th class="pe-4 w-50 text-end" style="max-width: 30px;"><strong>Monthly Total</strong></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $tabledata; ?>
						<tr class="table-secondary">
							<td class="text-end"><strong>Total</strong></td>
							<td class="text-end pe-4"><strong><?= $grandtotal ?></strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
			
<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
