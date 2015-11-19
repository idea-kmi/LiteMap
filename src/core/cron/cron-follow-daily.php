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

$us = getFollowEmailUsers('daily');
$users = $us->users;
$count = count($users);

for ($i=0; $i<$count; $i++) {
	$user = $users[$i];
	$userid = $user->userid;
	$USER = $user;

	$nextMessage = ""; //'<div style="font-family:sans-serif,Arial,Helvettica; font-size: 10pt">';

	$followlastrun = $user->followlastrun;
	$now = time();
	if ($followlastrun == 0) {
		$timeback = 86400; //86400 = 24 hours or 1 Day
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
		$nextnode = getNode($nodeid);

		$as = getNodeActivity($nodeid, $followlastrun);
		$activities = $as->activities;

		if ($as->totalno > 0) {
			$nextMessage .= '<br /><br /><hr />'.$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR.' '.$nodetype.': <span style="font-weight:bold">'. ($nodename).'</span> <a href="'.$CFG->homeAddress.'ui/popups/activityviewer.php?nodeid='.$nodeid.'&fromtime='.$followlastrun.'">'.$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK.'</a>';
		}

		foreach($activities as $activity) {

			if ($activity->type == 'Follow') {
				$nextMessage .= '<br /><br /><span style="font-style:italic">'.$LNG->ADMIN_CRON_FOLLOW_ON_THE.' '.date("d M Y - H:i", $activity->modificationdate).' </span>';
				$nextMessage .= ' '.($activity->user->name).' ';
				$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_STARTED.'</span> '.$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM;
			} else if ($activity->type == 'Vote') {
				$nextMessage .= '<br /><br /><span style="font-style:italic">'.$LNG->ADMIN_CRON_FOLLOW_ON_THE.' '.date("d M Y - H:i", $activity->modificationdate).' </span>';
				$nextMessage .= ' '.($activity->user->name).' ';
				if ($activity->changetype == 'Y') {
					$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_PROMOTED.'</span> '.$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM;
				} else if ($activity->changetype == 'N') {
					$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_DEMOTED.'</span> '.$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM;
				}
			} else if ($activity->type == 'Node') {
				$node = getIdeaFromAuditXML($activity->xml);
				if ($node instanceof CNode &&
					($node->private == 'N' || $node->userid == $user->userid) &&
					(in_array($node->role->name, $CFG->BASE_TYPES) ||
					in_array($node->role->name, $CFG->EVIDENCE_TYPES))
				) {
					$nextMessage .= '<br /><br /><span style="font-style:italic">'.$LNG->ADMIN_CRON_FOLLOW_ON_THE.' '.date("d M Y - H:i", $activity->modificationdate).' </span>';
					$nextMessage .= ' '.($activity->user->name).' ';
					if ($activity->changetype == 'add') {
						$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_ADDED.'</span> '.$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM;
					} else if ($activity->changetype == 'edit') {
						$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_EDITED.'</span> '.$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM;
					}
				}
			} else if ($activity->type == 'Connection') {
				$con = getConnectionFromAuditXML($activity->xml);
				if ($con instanceof Connection &&
					($con->private == 'N' || $con->userid == $user->userid )) {
					if ((in_array($con->from->role->name, $CFG->BASE_TYPES) ||
						in_array($con->from->role->name, $CFG->EVIDENCE_TYPES))
						&&
						(in_array($con->to->role->name, $CFG->BASE_TYPES) ||
						in_array($con->to->role->name, $CFG->EVIDENCE_TYPES)) ) {

						$otherend;
						$othernode;
						$otherrole;

						if ($con->from->nodeid != $nodeid) {
							$otherend = 'from';
							$othernode = $con->from;
							$otherrole = $con->fromrole;
						} else if ($con->to->nodeid != $nodeid) {
							$otherend = 'to';
							$othernode = $con->to;
							$otherrole = $con->torole;
						}

						$drawRow = true;
						if (in_array($nextnode->role->name, $CFG->EVIDENCE_TYPES)
							&& ($othernode->role->name == "Solution")) {
							$drawRow = false;
						}

						if ($drawRow) {
							$nextMessage .= '<br /><br /><span style="font-style:italic">'.$LNG->ADMIN_CRON_FOLLOW_ON_THE.' '.date("d M Y - H:i", $activity->modificationdate).' </span>';
							$nextMessage .= ' '.($activity->user->name).' ';
							if ($activity->changetype == 'add') {
								if ($othernode->role->name == 'Comment') {
									$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_ADDED.' '.$othernode->role->name.'</span>: "'.($othernode->name).'"';
								} else if (in_array($othernode->role->name, $CFG->EVIDENCE_TYPES)) {
									if ($otherrole->name == 'Pro') {
										$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_ADDED_SUPPORTING_EVIDENCE.'</span>: "'.($othernode->name).'"';
									} else if ($otherrole->name == 'Con') {
										$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_ADDED_COUNTER_EVIDENCE.'</span>: "'.($othernode->name).'"';
									} else {
										$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_EVIDENCE.'</span>: '.($othernode->name).'"';
									}
								} else {
									$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_WITH.' '.$othernode->role->name.'</span>: "'.($othernode->name).'"';
								}
							} else if ($activity->changetype == 'delete') {
								if ($othernode->role->name == 'Comment') {
									$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_REMOVED.' '.$othernode->role->name.'</span>: "'.($othernode->name).'"';
								} else if (in_array($othernode->role->name, $CFG->EVIDENCE_TYPES)) {
									$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_REMOVED_EVIDENCE.'</span>: "'.($othernode->name).'"';
								} else {
									$nextMessage .= '<span style="font-weight:bold">'.$LNG->ADMIN_CRON_FOLLOW_REMOVED_ASSOCIATION.' '.$othernode->role->name.'</span>: "'.($othernode->name).'"';
								}
							}
						}
					}
				}
			}
		}
	}

	$user->updateFollowLastRun($now);

	if ($nextMessage != "") {
		$nextMessage = $LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART1." ".date("d M Y", $followlastrun)." ".$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART2." ".date("d M Y", $now)."<br />".$nextMessage;
		//email messages can't have more than 998 characters on one line or you get odd characters ! randomly through the email.
		$nextMessage = wordwrap($nextMessage,900, "\n");

		$nextMessage .= '<br><p style="font-size:8pt">'.$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART1.'<a href="'.$CFG->homeAddress.'user.php?userid='.$userid.'">'.$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART2.'</a></p><br>';

		$paramArray = array ($user->name, $LNG->ADMIN_CRON_FOLLOW_DAILY, $nextMessage);
		sendMail("activityreport",$LNG->ADMIN_CRON_FOLLOW_DAILY_TITLE,$user->getEmail(),$paramArray);
	} else {
		echo "\r\n".$LNG->ADMIN_CRON_FOLLOW_NO_DIGEST." ".$user->getEmail();
	}
}

$USER = $currentUser;

echo "\r\n".$LNG->ADMIN_CRON_FOLLOW_DAILY_DIGEST_RUN."\r\n";;
?>