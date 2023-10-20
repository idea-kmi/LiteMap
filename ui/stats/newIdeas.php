<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2015-2023 The Open University UK                              *
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
	include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	checkDashboardAccess('GLOBAL');
	include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

	global $CFG,$LNG;

	$sort = optional_param("sort","name",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","ASC",PARAM_ALPHANUM);

	$sort1 = optional_param("sort1","name",PARAM_ALPHANUM);
	$oldsort1 = optional_param("lastsort1","",PARAM_ALPHANUM);
	$direction1 = optional_param("lastdir1","ASC",PARAM_ALPHANUM);

	$startdate = $CFG->START_DATE;
	$startdate = strtotime( 'first day of ' , $startdate);

	$nodetypes = "Issue,Solution,Pro,Con,Argument,Idea";
	$count = 0;
	if (is_countable($CFG->BASE_TYPES)) {
		$count = count($CFG->BASE_TYPES);
	}

	/***** MONTHLY BY CATEOGRY GRAPH *****/

	$time = "months";
?>
	<div class="text-center py-4"><img src="newIdeasGraph.php?time=months" alt="Graph to show monthly item creation for the last year" /></div>

<?php
	/***** MONTHLY BY CATEOGRY TABLE ******/

	$nodetypes = "Issue,Solution,Pro,Con,Argument,Idea";

	$day   = 24*60*60; // 24 hours * 60 minutes * 60 seconds
	$week  = $day * 7;
	$month = $day * 30.5;

	// WE ONLY WANT THE LAST YEAR - OR PART THERE OF
	if ($time === 'weeks') {
		$count = ceil((mktime()-$startdate) / $week);
		if ($count > 52) {
			$startdate =  $startdate+($WEEK*($count - 52));
			$count = 52;
		}
	} else {
		$dates = new DateTime();
		$dates->setTimestamp($startdate);
		$interval = date_create('now')->diff( $dates );

		$count = $interval->m;
		$years = $interval->y;
		if (isset($years) && $years > 0) {
			$count = $count + ($interval->y * 12);
		}
		$count = $count+1; //(to get it to this month too);

		if ($count > 12) {
			$startdate = strtotime( '+'.($count - 12).' months', $startdate);
			//echo date("m / y", $startdate);
			$startdate = strtotime( 'first day of ' , $startdate);
			//echo date("m / y", $startdate);
			$count = 12;
		}
	}
?>

<div class="my-5">
	<table class="table table-sm">
		<tr>
			<?php if ($time === 'weeks') { ?>
				<th class="fw-bold w-25">Week</th>
			<?php } else { ?>
				<th class="fw-bold w-25">Month</th>
			<?php } ?>

			<th class="fw-bold"><?php echo $LNG->ISSUES_NAME ?></th>
			<th class="fw-bold"><?php echo $LNG->SOLUTIONS_NAME ?></th>
			<th class="fw-bold"><?php echo $LNG->PROS_NAME ?></th>
			<th class="fw-bold"><?php echo $LNG->CONS_NAME ?></th>
			<th class="fw-bold"><?php echo $LNG->ARGUMENTS_NAME ?></th>
			<th class="fw-bold"><?php echo $LNG->COMMENTS_NAME ?></th>
			<th class="fw-bold"><?php echo $LNG->STATS_GLOBAL_IDEAS_MONTHLY_TOTAL_LABEL ?></th>

		</tr>
		<?php
			$totalsArray = array();

			for ($i=0; $i<$count; $i++) {
				echo '<tr>';

				$monthlytotal = 0;

				if ($i < 1) {
					$mintime= $startdate;
				} else {
					$mintime= $maxtime;
				}
				if ($time === 'weeks') {
					//$maxtime=$startdate + ($week*($i+1));
					$maxtime = strtotime( '+1 week', $mintime);
					echo '<td>'.date("m / y", $mintime).'</td>';
				} else {
					$maxtime = strtotime( '+1 month', $mintime);
					echo '<td>'.date("m / y", $mintime).'</td>';
				}

				$num2 = getNodeCreationCount('Issue',$mintime, $maxtime);
				echo '<td>'.$num2.'</td>';
				if (isset($totalsArray[$LNG->ISSUES_NAME])) {
					$totalsArray[$LNG->ISSUES_NAME] += $num2;
				} else {
					$totalsArray[$LNG->ISSUES_NAME] = $num2;
				}
				$monthlytotal += $num2;

				$num3 = getNodeCreationCount('Solution',$mintime, $maxtime);
				echo '<td>'.$num3.'</td>';
				if (isset($totalsArray[$LNG->SOLUTIONS_NAME])) {
					$totalsArray[$LNG->SOLUTIONS_NAME] += $num3;
				} else {
					$totalsArray[$LNG->SOLUTIONS_NAME] = $num3;
				}
				$monthlytotal += $num3;

				$num5 = getNodeCreationCount('Pro',$mintime, $maxtime);
				echo '<td>'.$num5.'</td>';
				if (isset($totalsArray[$LNG->PROS_NAME])) {
					$totalsArray[$LNG->PROS_NAME] += $num5;
				} else {
					$totalsArray[$LNG->PROS_NAME] = $num5;
				}
				$monthlytotal += $num5;

				$num51 = getNodeCreationCount('Con',$mintime, $maxtime);
				echo '<td>'.$num51.'</td>';
				if (isset($totalsArray[$LNG->CONS_NAME])) {
					$totalsArray[$LNG->CONS_NAME] += $num51;
				} else {
					$totalsArray[$LNG->CONS_NAME] = $num51;
				}
				$monthlytotal += $num51;

				$num6 = getNodeCreationCount('Argument',$mintime, $maxtime);
				echo '<td>'.$num6.'</td>';
				if (isset($totalsArray[$LNG->ARGUMENTS_NAME])) {
					$totalsArray[$LNG->ARGUMENTS_NAME] += $num6;
				} else {
					$totalsArray[$LNG->ARGUMENTS_NAME] = $num6;
				}
				$monthlytotal += $num6;

				$num9 = getNodeCreationCount('Idea',$mintime, $maxtime);
				echo '<td>'.$num9.'</td>';
				if (isset($totalsArray[$LNG->COMMENTS_NAME_SHORT])) {
					$totalsArray[$LNG->COMMENTS_NAME_SHORT] += $num9;
				} else {
					$totalsArray[$LNG->COMMENTS_NAME_SHORT] = $num9;
				}
				$monthlytotal += $num9;

				echo '<td style="font-weight:bold;">'.$monthlytotal.'</td>';
				echo '</tr>';
			}

			echo '<tr>';

			$grandtotal = 0;
		?>

			<td>Total</td>

			<td class="fw-bold"><?php echo $totalsArray[$LNG->ISSUES_NAME] ?> </td>

			<?php $grandtotal += $totalsArray[$LNG->ISSUES_NAME]; ?>

			<td class="fw-bold"><?php echo $totalsArray[$LNG->SOLUTIONS_NAME] ?> </td>

			<?php $grandtotal += $totalsArray[$LNG->SOLUTIONS_NAME]; ?>

			<td class="fw-bold"><?php echo $totalsArray[$LNG->PROS_NAME] ?> </td>

			<?php $grandtotal += $totalsArray[$LNG->PROS_NAME]; ?>

			<td class="fw-bold"><?php echo $totalsArray[$LNG->CONS_NAME] ?> </td>

			<?php $grandtotal += $totalsArray[$LNG->CONS_NAME]; ?>

			<td class="fw-bold"><?php echo $totalsArray[$LNG->ARGUMENTS_NAME] ?> </td>

			<?php $grandtotal += $totalsArray[$LNG->ARGUMENTS_NAME]; ?>

			<td class="fw-bold"><?php echo $totalsArray[$LNG->COMMENTS_NAME_SHORT] ?> </td>

			<?php $grandtotal += $totalsArray[$LNG->COMMENTS_NAME_SHORT]; ?>

			<td class="fw-bold"><?php echo $grandtotal ?></td>
		</tr>
	</table>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
