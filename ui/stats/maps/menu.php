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

$page = optional_param("page","home",PARAM_ALPHANUMEXT);
$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);
$node = getNode($nodeid);
$pageindex = 0;

$userid = "";
if (isset($USER->userid)) {
	$userid = $USER->userid;
}
auditDashboardView($userid, $nodeid, $page);

include_once('visdata.php');
?>
<center>
	<h1 style="padding-top:0px;margin-top:0px;"><?php echo $LNG->STATS_DEBATE_TITLE.$node->name; ?><a href="<?php echo $CFG->homeAddress.'explore.php?id='.$nodeid; ?>"><img src="<?php echo $HUB_FLM->getImagePath('arrow-up2.png'); ?>" style="padding-left:3px;vertical-align:middle" border="0" /></a></h1>
</center>

<div id="tabber" style="margin-left:10px;clear:both;float:left; width: 100%;">
	<ul id="tabs" class="tab">
		<li class="tab">
			<a class="tab <?php if ($page == "home") { echo 'current'; } else { echo 'unselected'; } ?>" href="index.php?page=home&nodeid=<?php echo $nodeid; ?>"><span class="tab"><?php echo $LNG->TAB_HOME; ?></span></a>
		</li>

<?php
$count = 0;
if (is_countable($sequence)) {
	$count = count($sequence);
}
for ($i=0; $i<$count; $i++) {
	$next = $sequence[$i];
	$nextitem = $dashboarddata[$next-1];
	$nextpage = $nextitem[6];

	echo '<li class="tab">';
	echo '<a class="tab';
	if ($page === $nextpage) {
		$pageindex = $next-1;
		echo ' current';
	} else {
		echo ' unselected';
	}
	echo '" href="'.$nextitem[4].'page='.$nextpage.'&nodeid='.$nodeid.'"><span class="tab">'.$nextitem[0].'</span></a>';
	echo '</li>';
} ?>
	</ul>
</div>

