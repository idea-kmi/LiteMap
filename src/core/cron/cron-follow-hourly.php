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
/**
 * cron-follow-daily.php
 * Created on 1st September 2011
 *
 * Michelle Bachler
 */
//RUN DAILY FOLLOWING ACTIVITY REPORTS
chdir( dirname ( realpath ( __FILE__ ) ) );

// I do not want this script run from a browser
if (!empty($_SERVER['REMOTE_ADDR'])) {
	return;
}

$domain = $argv[1];
include_once("../../config.php");

global $CFG,$USER,$LNG;

include_once($HUB_FLM->getCodeDirPath("core/apilib.php"));
include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

// Check if emails should be sent out from this instalaltion first.
if (!$CFG->send_mail) {
	return;
}

header("Content-Type: text/plain");

$currentUser = $USER;

$us = getFollowEmailUsers('hourly');
$users = $us->users;
$count = count($users);

for ($i=0; $i<$count; $i++) {
	$user = $users[$i];
	$userid = $user->userid;

	//if ($userid != '137108251921190199260') { // '1722128760393014001402920636'
	//	continue;
	//}

	$USER = $user;

	$nextMessage = ""; //'<div style="font-family:sans-serif,Arial,Helvettica; font-size: 10pt">';

	$followlastrun = $user->followlastrun;
	$now = time();
	if ($followlastrun == 0) {
		$timeback = 3600; //3600 = 1 hour
		$followlastrun = $now - $timeback;
	}

	// GET PEOPLE THEY FOLLOW
	$followingusers = getUsersBeingFollowedByMe($userid);
	$countj = count($followingusers);
	for ($j=0; $j<$countj;$j++) {
		$next = $followingusers[$j];
		$name = $next['Name'];
		$nextuserid = $next['UserID'];

		$as = getUserActivity($nextuserid, $followlastrun);
		if ($as->totalno > 0) {
			$nextMessage .= '<br />'.$LNG->ADMIN_CRON_FOLLOW_USER_ACTIVITY_MESSAGE.' <span style="font-weight:bold">'.($name).'</span>: <a href="'.$CFG->homeAddress.'ui/popups/activityviewerusers.php?userid='.$nextuserid.'&fromtime='.$followlastrun.'">'.$LNG->ADMIN_CRON_FOLLOW_SEE_ACTIVITY_LINK.'</a>';
		}
	}


	// GET ITEMS THEY FOLLOW
	$itemArray = getItemsBeingFollowedByMe($userid);
	$k=0;
	$countk = count($itemArray);
	for ($k = 0; $k<$countk; $k++) {
		$array = $itemArray[$k];

		$nodeid = $array['NodeID'];
		$nodename = $array['Name'];
		$nodetype = $array['NodeType'];

		$as = getNodeActivity($nodeid, $followlastrun, false);
		$activities = $as->activities;

		if (count($activities) > 0) {
			$nextMessage .= '<br /><br /><hr />'.$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR.' '.getNodeTypeText($nodetype, false).': <span style="font-weight:bold">'. ($nodename).'</span> <a href="'.$CFG->homeAddress.'ui/popups/activityviewer.php?nodeid='.$nodeid.'&fromtime='.$followlastrun.'">'.$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK.'</a>';
			$nextMessage .= processActivityList($activities, $array, $user);
		}

		/** IF THE NODE IS AN DEBATE ISSUE GET THE ACTIVITY ALSO FOR ALL THE ITEMS BELOW IN THE TREE **/
		if ($nodetype == "Issue") {
			$conSet = getDebate($nodeid);
			$conns = $conSet->connections;
			$countl = count($conns);
			for ($l=0; $l < $countl; $l++) {
				$con = $conns[$l];
				$from = $con->from;
				$to = $con->to;

				$node = array();
				$node['NodeID'] = $from->nodeid;
				$node['Name'] = $from->name;
				$node['NodeType'] = $from->role->name;
				$node['UserID'] = $from->users[0]->userid;

				$as = getNodeActivity($from->nodeid, $followlastrun, false);
				$activities = $as->activities;

				if (count($activities) > 0) {
					$nextMessage .= '<br /><br /><br />'.$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR.' '.getNodeTypeText($node['NodeType'], false).': <span style="font-weight:bold">'. ($from->name).'</span> <a href="'.$CFG->homeAddress.'ui/popups/activityviewer.php?nodeid='.$from->nodeid.'&fromtime='.$followlastrun.'">'.$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK.'</a>';
					$nextMessage .= processActivityList($activities, $node, $user);
				}
			}
		}
	}

	$user->updateFollowLastRun($now);

	if ($nextMessage != "") {
		$nextMessage = $LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART1." ".date("d M Y", $followlastrun)." ".$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART2." ".date("d M Y", $now)."<br />".$nextMessage;

		//email messages can't have more than 998 characters on one line or you get odd characters ! randomly through the email.
		$nextMessage = wordwrap($nextMessage,900, "\n");

		$nextMessage .= '<br><br><p style="font-size:8pt">'.$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART1.' <a href="'.$CFG->homeAddress.'user.php?userid='.$userid.'"> '.$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART2.'</a></p><br>';

		//$myFile = $user->userid."C.html";
		//$fh = fopen($myFile, 'w') or die("can't open file");
		//fwrite($fh, $nextMessage);
		//fclose($fh);

		$paramArray = array ($user->name, $LNG->ADMIN_CRON_FOLLOW_HOURLY, $nextMessage);
		sendMail("activityreport",$LNG->ADMIN_CRON_FOLLOW_HOURLY_TITLE,$user->getEmail(),$paramArray);
	} else {
		echo "\r\n".$LNG->ADMIN_CRON_FOLLOW_NO_DIGEST." ".$user->getEmail();
	}
}

$USER = $currentUser;

echo "\r\n".$LNG->ADMIN_CRON_FOLLOW_HOURLY_DIGEST_RUN."\r\n";;
?>