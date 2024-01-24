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

	global $CFG,$LNG;

	if($USER->getIsAdmin() != "Y") {
		echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
		include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
		die;
	}

	$sort = optional_param("sort","name",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","ASC",PARAM_ALPHANUM);

	$sort1 = optional_param("sort1","name",PARAM_ALPHANUM);
	$oldsort1 = optional_param("lastsort1","",PARAM_ALPHANUM);
	$direction1 = optional_param("lastdir1","ASC",PARAM_ALPHANUM);

	$startdate = $CFG->START_DATE;
	$startdate = strtotime( 'first day of ' , $startdate);

	/***** BY CATEGORY COUNTS *****/

	$grandtotal1 = 0;
	$categoryArray = array();

	$icount = getNodeCreationCount('Map',$startdate);
	$categoryArray[$LNG->MAPS_NAME] = $icount;
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount("Issue",$startdate);
	$categoryArray[$LNG->ISSUES_NAME] = $icount;
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Solution',$startdate);
	$categoryArray[$LNG->SOLUTIONS_NAME] = $icount;
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Pro',$startdate);
	$categoryArray[$LNG->PROS_NAME] = $icount;
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Con',$startdate);
	$categoryArray[$LNG->CONS_NAME] = $icount;
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Argument',$startdate);
	$categoryArray[$LNG->ARGUMENTS_NAME] = $icount;
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Idea',$startdate);
	$categoryArray[$LNG->COMMENT_NAME] = $icount;
	$grandtotal1 += $icount;

	$icount = getNodeCreationCount('Comment',$startdate);
	$categoryArray[$LNG->CHAT_NAME] = $icount;
	$grandtotal1 += $icount;

?>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col-12">

			<?php
				if (file_exists("menu.php") ) {
					include("menu.php");
				}
			?>

			<div class="d-flex flex-wrap gap-3 my-4">
				<?php foreach( $categoryArray as $key => $value) { ?>
					<!-- Card -->
					<div class="col-2 mb-2" style="min-width: 275px">
						<div class="card border-0 border-start border-secondary shadow h-100 py-1">
							<div class="card-body p-2">
								<div class="no-gutters align-items-center">
									<div class="d-flex gap-3 justify-content-between" style="font-size: 1em;">
										<div class="text-xs fw-bold text-secondary text-uppercase"><?= $key ?></div>
										<div class="mb-0 fw-bold text-gray-800"><?=  $value ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				<!-- Card -->
				<div class="col-2 mb-2" style="min-width: 275px">
					<div class="card border-0 border-start border-dark shadow h-100 py-1">
						<div class="card-body p-2">
							<div class="no-gutters align-items-center">
								<div class="d-flex gap-3 justify-content-between" style="font-size: 1em;">
									<div class="text-xs fw-bold text-dark text-uppercase"><?= $LNG->ADMIN_STATS_IDEAS_TOTAL_LABEL ?></div>
									<div class="mb-0 fw-bold text-gray-800"><?= $grandtotal1 ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
				/***** MONTHLY BY CATEOGRY GRAPH *****/
				$time = "months";
			?>

			<div class="text-center"><img src="newIdeasGraph.php?time=months" alt="graph of items created" /></div>
		</div>

		<div class="col-md-8 col-sm-12 m-auto mt-4">

		<?php
			/***** MONTHLY BY CATEOGRY TABLE ******/
			$day   = 24*60*60; // 24 hours * 60 minutes * 60 seconds
			$week  = $day * 7;
			$month = $day * 30.5;

			// WE ONLY WANT THE LAST YEAR - OR PART THERE OF
			if ($time === 'weeks') {
				$count = ceil((mktime()-$startdate) / $week);
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
			}
		?>

	echo '<div class="my-3">';
	echo '<table class="table table-sm">';
	echo '<tr>';
	if ($time === 'weeks') {
		echo '<th valign="top" style="font-weight:bold;">Week</th>';
	} else {
		echo '<th valign="top" style="font-weight:bold;">Month</th>';
	}

	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->MAPS_NAME.'</th>';
	echo '<td valign="top" style="font-weight:bold;" class="text-center">'.$LNG->ISSUES_NAME.'</th>';
	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->SOLUTIONS_NAME.'</th>';
	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->PROS_NAME.'</th>';
	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->CONS_NAME.'</th>';
	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->ARGUMENTS_NAME.'</th>';
	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->COMMENTS_NAME.'</th>';
	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->CHATS_NAME.'</th>';

	echo '<th valign="top" style="font-weight:bold;" class="text-center">'.$LNG->ADMIN_STATS_IDEAS_MONTHLY_TOTAL_LABEL.'</th>';

	echo '</tr>';

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

		$num7 = getNodeCreationCount("Map",$mintime, $maxtime);
		echo '<td>'.$num7.'</td>';
		if (isset($totalsArray[$LNG->MAPS_NAME])) {
			$totalsArray[$LNG->MAPS_NAME] += $num7;
		} else {
			$totalsArray[$LNG->MAPS_NAME] = $num7;
		}
		$monthlytotal += $num7;

		$num2 = getNodeCreationCount("Issue",$mintime, $maxtime);
		echo '<td class="text-end">'.$num2.'</td>';
		if (isset($totalsArray[$LNG->ISSUES_NAME])) {
			$totalsArray[$LNG->ISSUES_NAME] += $num2;
		} else {
			$totalsArray[$LNG->ISSUES_NAME] = $num2;
		}
		$monthlytotal += $num2;

		$num3 = getNodeCreationCount("Solution",$mintime, $maxtime);
		echo '<td class="text-end">'.$num3.'</td>';
		if (isset($totalsArray[$LNG->SOLUTIONS_NAME])) {
			$totalsArray[$LNG->SOLUTIONS_NAME] += $num3;
		} else {
			$totalsArray[$LNG->SOLUTIONS_NAME] = $num3;
		}
		$monthlytotal += $num3;

		$num4 = getNodeCreationCount("Pro",$mintime, $maxtime);
		echo '<td class="text-end">'.$num4.'</td>';
		if (isset($totalsArray[$LNG->PROS_NAME])) {
			$totalsArray[$LNG->PROS_NAME] += $num4;
		} else {
			$totalsArray[$LNG->PROS_NAME] = $num4;
		}
		$monthlytotal += $num4;

		$num5 = getNodeCreationCount("Con",$mintime, $maxtime);
		echo '<td class="text-end">'.$num5.'</td>';
		if (isset($totalsArray[$LNG->CONS_NAME])) {
			$totalsArray[$LNG->CONS_NAME] += $num5;
		} else {
			$totalsArray[$LNG->CONS_NAME] = $num5;
		}
		$monthlytotal += $num5;

		$num6 = getNodeCreationCount("Argument",$mintime, $maxtime);
		echo '<td class="text-end">'.$num6.'</td>';
		if (isset($totalsArray[$LNG->ARGUMENTS_NAME])) {
			$totalsArray[$LNG->ARGUMENTS_NAME] += $num6;
		} else {
			$totalsArray[$LNG->ARGUMENTS_NAME] = $num6;
		}
		$monthlytotal += $num6;

		$num8 = getNodeCreationCount("Idea",$mintime, $maxtime);
		echo '<td class="text-end">'.$num8.'</td>';
		if (isset($totalsArray[$LNG->COMMENTS_NAME])) {
			$totalsArray[$LNG->COMMENTS_NAME] += $num8;
		} else {
			$totalsArray[$LNG->COMMENTS_NAME] = $num8;
		}
		$monthlytotal += $num8;

		$num9 = getNodeCreationCount("Comment",$mintime, $maxtime);
		echo '<td class="text-end">'.$num9.'</td>';
		if (isset($totalsArray[$LNG->CHATS_NAME])) {
			$totalsArray[$LNG->CHATS_NAME] += $num9;
		} else {
			$totalsArray[$LNG->CHATS_NAME] = $num9;
		}
		$monthlytotal += $num9;

		echo '<td style="font-weight:bold;" class="text-end">'.$monthlytotal.'</td>';
		echo '</tr>';
	}

	echo '<tr>';

	$grandtotal = 0;

	echo '<td valign="top" style="font-weight:bold;">Total</td>';

	echo '<td valign="top" style="font-weight:bold;">'.$totalsArray[$LNG->MAPS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->MAPS_NAME];

	echo '<td valign="top" style="font-weight:bold;">'.$totalsArray[$LNG->ISSUES_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->ISSUES_NAME];

	echo '<td valign="top" style="font-weight:bold;;">'.$totalsArray[$LNG->SOLUTIONS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->SOLUTIONS_NAME];

	echo '<td valign="top" style="font-weight:bold;">'.$totalsArray[$LNG->PROS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->PROS_NAME];

	echo '<td valign="top" style="font-weight:bold;">'.$totalsArray[$LNG->CONS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->CONS_NAME];

	echo '<td valign="top" style="font-weight:bold;">'.$totalsArray[$LNG->ARGUMENTS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->ARGUMENTS_NAME];

	echo '<td valign="top" style="font-weight:bold;">'.$totalsArray[$LNG->COMMENTS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->COMMENTS_NAME];

	echo '<td valign="top" style="font-weight:bold;">'.$totalsArray[$LNG->CHATS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->CHATS_NAME];

	echo '<td valign="top" style="font-weight:bold;">'.$grandtotal.'</td>';

	echo '</tr>';
	echo '</table>';
	echo '</div>';

	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));

?>
