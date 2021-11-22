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
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

include_once('visdata.php');
include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));
?>

<table cellspacing="10" style="margin: 0 auto;border-spacing:5px;width: 700px;">
<?php
$inner = 0;
$rowcount = 5;
$count = 0;
if (is_countable($sequence)) {
	$count = count($sequence);
}
for ($i=0; $i<$count; $i++) {
	$next = $sequence[$i];
	$nextitem = $dashboarddata[$next-1];
	$nextpage = $nextitem[1];

	if ($inner == 0) {
		echo '<tr>';
	}

	$inner++;
	echo '<td width="50%">';
	echo '<a class="tab current" href="'.$nextitem[4].'page='.$nextitem[6].'">';
	echo '<div style="width:177px;height:180px;padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1">';
	echo '<div style="padding:0px;"><center><h2 style="font-size:12pt">'.$nextitem[0].'</h2></center></div>';
	echo '<div style="margin: 0 auto; width:'.$nextitem[7].'px;margin-bottom:5px;">';
	echo '<img src="'.$nextitem[3].'" border="0" width="'.$nextitem[7].'" />';
	echo '</div>';
	echo '</div>';
	echo '</a>';
	echo '</td>';

	if ($inner == $rowcount || $i == $count) {
		echo '</tr>';
		$inner = 0;
	}
} ?>
</table>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>