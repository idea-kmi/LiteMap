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
	checkDashboardAccess('GROUP');

	$groupid = required_param("groupid",PARAM_ALPHANUMEXT);

	include_once('visdata.php');
	include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));
?>

<div class="d-flex gap-2 flex-wrap justify-content-center">
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
			?>
				<a href="<?php echo $nextitem[4]; ?>page=<?php echo $nextitem[6]; ?>&groupid=<?php echo $groupid; ?>" class="dashboard-link-btn" style="width: 250px;">
				<div class="text-center">
					<h2 class="fw-bold" style="font-size:12pt"><?php echo $nextitem[0]; ?></h2>
					<div>
						<img src="<?php echo $nextitem[3]; ?>" width="<?php echo $nextitem[7]; ?>" />
					</div>
				</div>
			</a>

			<?php
			if ($inner == $rowcount || $i == $count) {
				echo '</tr>';
				$inner = 0;
			}
		}
	?>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
