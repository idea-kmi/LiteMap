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

	$sort = optional_param("sort","vote",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","DESC",PARAM_ALPHANUM);

	$totalsItems = getTotalItemVotes();
	$totalsConns = getTotalConnectionVotes();
	$totals = getTotalVotes();

	$topVotedNodes = getTotalTopVotes(10);
	$topVotedForNodes = getTopNodeForVotes(10);
	$topVotedAgainstNodes = getTopNodeAgainstVotes(10);

	$topVoters = getTopVoters(10);
	$topVotersFor = getTopForVoters(10);
	$topVotersAgainst = getTopAgainstVoters(10);

	$allNodeVotes = getAllVoting($direction, $sort, $oldsort);
?>

<h3 class="fw-bold"><?php echo $LNG->STATS_GLOBAL_VOTES_MENU_TITLE; ?></h3>
<div class="d-flex flex-row justify-content-between mb-4">
	<table class="table table-sm table-borderless">
		<tr><td colspan="2" width="100%" style="font-weight:bold;"><?php echo $LNG->STATS_GLOBAL_ITEM_VOTES_MENU_TITLE; ?></b></td></tr>
		<tr><td width="70%"><b style="color:green"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></b></td><td width="30%"><?php echo $totalsItems[0]['up']; ?></td></tr>
		<tr><td width="70%"><b style="color: #990000;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></b></td><td width="30%"><?php echo $totalsItems[0]['down']; ?></td></tr>
		<tr><td width="70%"><b><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></b></td><td width="30%"><?php echo $totalsItems[0]['vote']; ?></td></tr>
	</table>

	<table class="table table-sm table-borderless">
		<tr><td colspan="2" width="100%" style="font-weight:bold;"><?php echo $LNG->STATS_GLOBAL_CONNECTION_VOTES_MENU_TITLE; ?></b></td></tr>
		<tr><td width="70%"><b style="color:green"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></b></td><td width="30%"><?php echo $totalsConns[0]['up']; ?></td></tr>
		<tr><td width="70%"><b style="color: #990000;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></b></td><td width="30%"><?php echo $totalsConns[0]['down']; ?></td></tr>
		<tr><td width="70%"><b><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></b></td><td width="30%"><?php echo $totalsConns[0]['vote']; ?></td></tr>
	</table>

	<table class="table table-sm table-borderless">
		<tr><td colspan="2" width="100%" style="font-weight:bold;"><?php echo $LNG->STATS_GLOBAL_ALL_VOTES_MENU_TITLE; ?></b></td></tr>
		<tr><td width="70%"><b style="color:green"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></b></td><td width="30%"><?php echo $totals[0]['up']; ?></td></tr>
		<tr><td width="70%"><b style="color: #990000;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></b></td><td width="30%"><?php echo $totals[0]['down']; ?></td></tr>
		<tr><td width="70%"><b><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></b></td><td width="30%"><?php echo $totals[0]['vote']; ?></td></tr>
	</table>
</div>

<a name="top"></a>

<div class="d-flex flex-row justify-content-evenly">
	<a href="#voting"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES; ?></a>
	<a href="#votingfor"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES; ?></a>
	<a href="#votingagainst"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES; ?></a>
	<a href="#voters"><?php echo $LNG->STATS_GLOBAL_VOTES_VOTERS_MENU_TITLE; ?></a>
	<a href="#allvotes"><?php echo $LNG->STATS_GLOBAL_VOTES_ALL_VOTES_MENU_TITLE; ?></a>
</div>

<hr class="hrline" />

<a name="voting"></a>
<h3 class="h5 fw-bold">
	<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES; ?>
</h3>
<table cellpadding="5" class="table table-sm table-bordered mb-5">
	<tr class="challengeback" style="color:white">
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
	</tr>
	<?php
		$count = $topVotedNodes->count;
		for ($i=0; $i<$count; $i++) {
			$n = $topVotedNodes->nodes[$i];
			$nodetype = $n->role->name;
			$title = $n->name;
			?>
			<tr>
				<td><?php echo getNodeTypeText($nodetype, false); ?></td>
				<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
				<td><span style="color: green"><?php echo $n->up ?></span></td>
				<td><span style="color: #990000;"><?php echo $n->down ?></span></td>
				<td><span style="color: green"><?php echo $n->cup ?></span></td>
				<td><span style="color: #990000;"><?php echo $n->cdown ?></span></td>
				<td><b><?php echo $n->vote ?></b></td>
			</tr>
	<?php } ?>
</table>

<a name="votingfor"></a>
<div class="d-flex justify-content-between">
	<h3 class="h5 fw-bold" style="color: green">
		<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES; ?>
	</h3>
	<a href="#top"><?php echo $LNG->STATS_GLOBAL_VOTES_BACK_UP; ?></a>
</div>
<table cellpadding="5" class="table table-sm table-bordered mb-5">
	<tr class="challengeback" style="color:white">
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
	</tr>
	<?php
		$count = $topVotedForNodes->count;
		for ($i=0; $i<$count; $i++) {
			$n = $topVotedForNodes->nodes[$i];
			$nodetype = $n->role->name;
			$title = $n->name;
			?>
			<tr>
				<td><?php echo getNodeTypeText($nodetype, false); ?></td>
				<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
				<td><span style="color: green"><?php echo $n->up ?></span></td>
				<td><span style="color: green"><?php echo $n->cup ?></span></td>
				<td><b><?php echo $n->vote ?></b></td>
			</tr>
	<?php } ?>
</table>

<a name="votingagainst"></a>
<div class="d-flex justify-content-between">
	<h3 class="h5 fw-bold" style="color: #990000;">
		<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES; ?>
	</h3>
	<a href="#top"><?php echo $LNG->STATS_GLOBAL_VOTES_BACK_UP; ?></a>
</div>
<table cellpadding="5" class="table table-sm table-bordered mb-5">
	<tr class="challengeback" style="color:white">
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING; ?></td>
		<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
	</tr>
	<?php
		$count = $topVotedAgainstNodes->count;
		for ($i=0; $i<$count; $i++) {
			$n = $topVotedAgainstNodes->nodes[$i];
			$nodetype = $n->role->name;
			$title = $n->name;
			?>
			<tr>
				<td><?php echo getNodeTypeText($nodetype, false); ?></td>
				<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
				<td><span style="color: #990000;"><?php echo $n->down ?></span></td>
				<td><span style="color: #990000;"><?php echo $n->cdown ?></span></td>
				<td><b><?php echo $n->vote ?></b></td>
			</tr>
	<?php } ?>
</table>

<a name="voters"></a>
<div class="d-flex flex-row justify-content-between gap-3">
	<div class="w-100">
		<h3 class="h5 fw-bold">
			<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_VOTERS; ?>
		</h3>
		<table cellpadding="5" class="table table-sm table-bordered mb-5">
			<tr class="challengeback" style="color:white">
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></td>
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></td>
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
			</tr>
			<?php
				$count = 0;
				if (is_countable($topVoters)) {
					$count = count($topVoters);
				}
				for ($i=0; $i<$count; $i++) {
					$n = $topVoters[$i]; ?>
					<tr>
						<td><a href="<?php echo $CFG->homeAddress;?>user.php?id=<?php echo $n['UserID']; ?>" target="_blank"><?php echo $n['Name']; ?></a></td>
						<td><span style="color: green"><?php echo $n['up'] ?></span></td>
						<td><span style="color: #990000;"><?php echo $n['down'] ?></span></td>
						<td><b><?php echo $n['vote'] ?></b></td>
					</tr>
			<?php } ?>
		</table>
	</div>

	<div class="w-100">
		<h3 class="h5 fw-bold" style="color: green"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_FOR; ?></h3>
		<table cellpadding="5" class="table table-sm table-bordered mb-5">
			<tr class="challengeback" style="color:white">
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
			</tr>
			<?php
				$count = 0;
				if (is_countable($topVotersFor)) {
					$count = count($topVotersFor);
				}
				for ($i=0; $i<$count; $i++) {
					$n = $topVotersFor[$i];
					$title = $n['Name'];
					?>
					<tr>
						<td><a href="<?php echo $CFG->homeAddress;?>user.php?id=<?php echo $n['UserID']; ?>" target="_blank"><?php echo $title ?></a></td>
						<td><b style="color: green"><?php echo $n['vote'] ?></b></td>
					</tr>
			<?php } ?>
		</table>
	</div>

	<div class="w-100">
		<div class="d-flex justify-content-between">
			<h3 class="h5 fw-bold" style="color: #990000;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_AGAINST; ?></h3>
			<a href="#top"><?php echo $LNG->STATS_GLOBAL_VOTES_BACK_UP; ?></a>
		</div>
		<table cellpadding="5" class="table table-sm table-bordered mb-5">
			<tr class="challengeback" style="color:white">
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
				<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
			</tr>
			<?php
				$count = 0;
				if (is_countable($topVotersAgainst)) {
					$count = count($topVotersAgainst);
				}
				for ($i=0; $i<$count; $i++) {
					$n = $topVotersAgainst[$i];
					$title = $n['Name'];
					?>
					<tr>
						<td><a href="<?php echo $CFG->homeAddress;?>user.php?id=<?php echo $n['UserID']; ?>" target="_blank"><?php echo $title ?></a></td>
						<td><b style="color: #990000;"><?php echo $n['vote'] ?></b></td>
					</tr>
			<?php } ?>
		</table>
	</div>
</div>

<a name="allvotes"></a>
<div class="d-flex justify-content-between">
	<h3 class="h5 fw-bold">
		<?php echo $LNG->STATS_GLOBAL_VOTES_ALL_VOTING_TITLE; ?>
	</h3>
	<a href="#top"><?php echo $LNG->STATS_GLOBAL_VOTES_BACK_UP; ?></a>
</div>

<table cellpadding="5" class="table table-sm table-bordered mb-5">
	<tr style="background:#D8D8D8">
		<?php echo '<td class="adminTableHead"><a href="votes.php?&sort=NodeType&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING.'</b>';
		if ($sort === 'NodeType') {
			if ($direction === 'ASC') {
				echo '<img src="../../images/uparrow.gif" width="16" height="8" alt="asc" />';
			} else {
				echo '<img src="../../images/downarrow.gif" width="16" height="8" alt="desc" />';
			}
		}
		echo '</td>';
		echo '<td class="adminTableHead"><a href="votes.php?&sort=Name&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING.'</b>';
		if ($sort === 'Name') {
			if ($direction === 'ASC') {
				echo '<img src="../../images/uparrow.gif" width="16" height="8" alt="asc" />';
			} else {
				echo '<img src="../../images/downarrow.gif" width="16" height="8" alt="desc" />';
			}
		}
		echo '</td>';
		echo '<td class="adminTableHead"><a href="votes.php?&sort=up&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING.'</b>';
		if ($sort === 'up') {
			if ($direction === 'ASC') {
				echo '<img src="../../images/uparrow.gif" width="16" height="8" alt="asc" />';
			} else {
				echo '<img src="../../images/downarrow.gif" width="16" height="8" alt="desc" />';
			}
		}
		echo '</td>';
		echo '<td class="adminTableHead"><a href="votes.php?&sort=down&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING.'</b>';
		if ($sort === 'down') {
			if ($direction === 'ASC') {
				echo '<img src="../../images/uparrow.gif" width="16" height="8" alt="asc" />';
			} else {
				echo '<img src="../../images/downarrow.gif" width="16" height="8" alt="desc" />';
			}
		}
		echo '</td>';
		echo '<td class="adminTableHead"><a href="votes.php?&sort=cup&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING.'</b>';
		if ($sort === 'cup') {
			if ($direction === 'ASC') {
				echo '<img src="../../images/uparrow.gif" width="16" height="8" alt="asc" />';
			} else {
				echo '<img src="../../images/downarrow.gif" width="16" height="8" alt="desc" />';
			}
		}
		echo '</td>';
		echo '<td class="adminTableHead"><a href="votes.php?&sort=cdown&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING.'</b>';
		if ($sort === 'cdown') {
			if ($direction === 'ASC') {
				echo '<img src="../../images/uparrow.gif" width="16" height="8" alt="asc" />';
			} else {
				echo '<img src="../../images/downarrow.gif" width="16" height="8" alt="desc" />';
			}
		}
		echo '</td>';
		echo '<td class="adminTableHead"><a href="votes.php?&sort=vote&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING.'</b>';
		if ($sort === 'vote') {
			if ($direction === 'ASC') {
				echo '<img src="../../images/uparrow.gif" width="16" height="8" alt="asc" />';
			} else {
				echo '<img src="../../images/downarrow.gif" width="16" height="8" alt="desc" />';
			}
		}
		echo '</td>';
		?>
	</tr>
	<?php
		$count = $allNodeVotes->count;
		for ($i=0; $i<$count; $i++) {
			$n = $allNodeVotes->nodes[$i];
			if (!$n instanceof Hub_Error) {
				$nodetype = $n->role->name;
				$title = $n->name;
				?>
				<tr>
					<td><?php echo getNodeTypeText($nodetype, false); ?></td>
					<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
					<td><span style="color: green"><?php echo $n->up ?></span></td>
					<td><span style="color: #990000;"><?php echo $n->down ?></span></td>
					<td><span style="color: green"><?php echo $n->cup ?></span></td>
					<td><span style="color: #990000;"><?php echo $n->cdown ?></span></td>
					<td><b><?php echo $n->vote ?></b></td>
				</tr>
	<?php } } ?>
</table>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
