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
	include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

	global $CFG;

	if($USER->getIsAdmin() != "Y") {
		echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
		include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
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
		$tabledata .= '<td>'.date("m / y", $mintime).'</td>';
		$tabledata .= '<td align="right" style="font-weight:bold;">'.$monthlytotal.'</td>';
		$tabledata .= '</tr>';
	}

	echo '<div class="my-3"><p>'.$LNG->ADMIN_STATS_REGISTER_TOTAL_LABEL.' = '.$grandtotal.'</p><div>';
?>

<div class="text-center"><img src="usersGraph.php?time=months" alt="user registration graph" /></div>

<!-- MONTHLY TOTALS -->
<?php
	echo '<div class="mb-5">';
	echo '<table class="table table-sm table-hover">';
	echo '<tr>';
	echo '<th valign="top" style="font-weight:bold;">Month</th>';
	echo '<th valign="top" style="font-weight:bold;">Monthly Total</th>';
	echo '</tr>';

	echo $tabledata;

	echo '<tr>';
	echo '<td valign="top" style="font-weight:bold;">Total</td>';
	echo '<td align="right" valign="top" style="font-weight:bold;">'.$grandtotal.'</td>';
	echo '</tr>';

	echo '</table>';
	echo '</div>';
?>

<!-- ALL USERS -->

<div class="adminTableDiv">
	<table class="table table-sm table-hover">
		<?php
			$registeredUsers = getRegisteredUsers($direction, $sort, $oldsort);

			if ($sort) {
				if ($direction) {
					if ($oldsort === $sort) {
						if ($direction === 'ASC') {
							$direction = "DESC";
						} else {
							$direction = "ASC";
						}
					} else {
						$direction = "ASC";
					}
				} else {
					$direction = "ASC";
				}
			} else {
				$sort='date';
				$direction='DESC';
			}

			echo '<tr><td class="adminTableHead"><a href="userRegistration.php?&sort=name&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->ADMIN_STATS_REGISTER_HEADER_NAME.'</b>';
			if ($sort === 'name') {
				if ($direction === 'ASC') {
					echo '<img border="0" src="/images/uparrow.gif" width="16" height="8" alt="asc" />';
				} else {
					echo '<img border="0" src="/images/downarrow.gif" width="16" height="8" alt="desc" />';
				}
			}
			echo '</td>';
			echo '<td class="adminTableHead"><a href="userRegistration.php?&sort=date&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->ADMIN_STATS_REGISTER_HEADER_DATE.'</b>';
			if ($sort === 'date') {
				if ($direction === 'ASC') {
					echo '<img border="0" src="/images/uparrow.gif" width="16" height="8" alt="asc" />';
				} else {
					echo '<img border="0" src="/images/downarrow.gif" width="16" height="8" alt="desc" />';
				}
			}
			echo '</td>';
			echo '<td class="adminTableHead"><a href="userRegistration.php?&sort=desc&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->ADMIN_STATS_REGISTER_HEADER_DESC.'</b>';
			if ($sort === 'desc') {
				if ($direction === 'ASC') {
					echo '<img border="0" src="/images/uparrow.gif" width="16" height="8" alt="asc" />';
				} else {
					echo '<img border="0" src="/images/downarrow.gif" width="16" height="8" alt="desc" />';
				}
			}
			echo '</td>';

			echo '<td class="adminTableHead"><a href="userRegistration.php?&sort=interest&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->ADMIN_STATS_REGISTER_HEADER_INTEREST.'</b>';
			if ($sort === 'interest') {
				if ($direction === 'ASC') {
					echo '<img border="0" src="/images/uparrow.gif" width="16" height="8" alt="asc" />';
				} else {
					echo '<img border="0" src="/images/downarrow.gif" width="16" height="8" alt="desc" />';
				}
			}
			echo '</td>';

			echo '<td class="adminTableHead"><a href="userRegistration.php?&sort=website&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->ADMIN_STATS_REGISTER_HEADER_WEBSITE.'</b>';
			if ($sort === 'website') {
				if ($direction === 'ASC') {
					echo '<img border="0" src="/images/uparrow.gif" width="16" height="8" alt="asc" />';
				} else {
					echo '<img border="0" src="/images/downarrow.gif" width="16" height="8" alt="desc" />';
				}
			}
			echo '</td>';

			echo '<td class="adminTableHead"><a href="userRegistration.php?&sort=location&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->ADMIN_STATS_REGISTER_HEADER_LOCATION.'</b>';
			if ($sort === 'location') {
				if ($direction === 'ASC') {
					echo '<img border="0" src="/images/uparrow.gif" width="16" height="8" alt="asc" />';
				} else {
					echo '<img border="0" src="/images/downarrow.gif" width="16" height="8" alt="desc" />';
				}
			}
			echo '</td>';

			echo '<td class="adminTableHead"><a href="userRegistration.php?&sort=login&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->ADMIN_STATS_REGISTER_HEADER_LAST_LOGIN.'</b>';
			if ($sort === 'login') {
				if ($direction === 'ASC') {
					echo '<img border="0" src="/images/uparrow.gif" width="16" height="8" alt="asc" />';
				} else {
					echo '<img border="0" src="/images/downarrow.gif" width="16" height="8" alt="desc" />';
				}
			}
			echo '</td></tr>';

			$countUsers = 0;
			if (is_countable($registeredUsers)) {
				$countUsers = count($registeredUsers);
			}
			if ($countUsers > 0) {
				for ($i=0; $i<$countUsers; $i++) {
					$array = $registeredUsers[$i];
					$name = $array['Name'];
					$date = $array['CreationDate'];
					$desc = $array['Description'];
					$interest = $array['Interest'];
					$website = $array['Website'];
					$lastlogin = $array['LastLogin'];

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

					echo '<tr>';
						echo '<td valign="top">';
							echo $name;
						echo '</td>';
						echo '<td valign="top">';
							echo strftime( '%d/%m/%Y' ,$date);
						echo '</td>';
						echo '<td valign="top">';
							echo $desc;
						echo '</td>';
						echo '<td valign="top">';
							echo $interest;
						echo '</td>';
						echo '<td valign="top">';
							if ($website != null && $website != "") {
								echo '<a href="'.$website.'">Homepage</a>';
							} else {
								echo '&nbsp;';
							}
						echo '</td>';
						echo '<td valign="top">';
							if ($location != "" || $country != "") {
								echo '<span>'.$location;
								if ($location != "" && $country !="") {
									echo ",";
								}
								echo $country.'</span>';
							} else {
								echo '&nbsp;';
							}
						echo '</td>';
						echo '<td valign="top">';
							echo strftime( '%d/%m/%Y' ,$lastlogin);
						echo '</td>';
					echo '</tr>';
				}
			}
		?>
	</table>
</div>
<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
