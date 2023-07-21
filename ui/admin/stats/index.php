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

$err = "";

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

echo '<div class="my-3">';
echo '<p>'.$LNG->USERS_NAME.' = '.$grandtotal.'</p>';
echo '</div>';

$allGroups = getGroupsByGlobal(0,-1,'date','ASC');
echo '<div class="my-3">';

$countgroups = 0;
if (is_countable($allGroups->groups)) {
	$countgroups = count($allGroups->groups);
}

echo '<p>'.$LNG->GROUPS_NAME.' = '.$countgroups.'</p>';
echo '</div>';

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

echo '<div class="mt-3">';
echo '<h4 class="fw-bold">'.$LNG->ADMIN_STATS_TAB_IDEAS.'</h4>';
echo '<table cellpadding="3" class="table table-sm table-borderless">';

foreach( $categoryArray as $key => $value) {
	echo '<tr><td><span>'.$key.'</span></td><td class="text-end"><span>'.$value.'</span</td></tr>';
}

echo '<tr><td colspan="2"><hr class="hrline" /></td></tr>';
echo '<tr><td><span class="hometext">'.$LNG->ADMIN_STATS_IDEAS_TOTAL_LABEL.'</span></td><td class="text-end"><span class="hometext">'.$grandtotal1.'</span</td></tr>';
echo '</table></div>';

?>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
