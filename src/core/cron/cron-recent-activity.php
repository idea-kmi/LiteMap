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
 * cron-recent-activity.php
 *
 * Michelle Bachler
 */
//RUN WEEKLY FOLLOWING ACTIVITY REPORTS
chdir( dirname ( realpath ( __FILE__ ) ) );

// I do not want this script run from a browser
if (!empty($_SERVER['REMOTE_ADDR'])) {
	return;
}

$domain = $argv[1];
include_once("../../config.php");

global $CFG,$USER,$LNG,$HUB_FLM;

include_once($HUB_FLM->getCodeDirPath("core/apilib.php"));
include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

// Check if emails should be sent out from this installation first.
if (!$CFG->send_mail) {
	return;
}

// Check if recent activity email feature turned on.
if (!$CFG->RECENT_EMAIL_SENDING_ON) {
	return;
}

header("Content-Type: text/plain");

$currentUser = $USER;

$us = getRecentActivityEmailUsers('daily');
$users = $us->users;
$count = count($users);

//echo "Users=".$count."\n";

foreach($users as $user) {
	$USER = $user;

//echo $user->userid.":Starting"."\n";

	$nextMessage = '';

	// maps
	$nodeSet = getNodesByGlobal(0, 5 , 'date','DESC', "Map");
	$nodes = $nodeSet->nodes;
	$nextSet = "";
	$nextSet .= '<br><b><img width="20" border="0" src="'.$CFG->mapicon.'" />&nbsp;'.$LNG->MAPS_NAME.'</b><br>';
	foreach($nodes as $node) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'explore.php?id='.$node->nodeid.'">'.($node->name).'</a><br />';
	}
	if (count($nodes) > 0) {
		$nextMessage .= $nextSet;
	}

	// issues
	$nodeSet = getNodesByGlobal(0, 5 , 'date','DESC', "Issue");
	$nodes = $nodeSet->nodes;
	$nextSet = "";
	$nextSet .= '<br><b><img width="20" border="0" src="'.$CFG->issueicon.'" />&nbsp;'.$LNG->ISSUES_NAME.'</b><br>';
	foreach($nodes as $node) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'explore.php?id='.$node->nodeid.'">'.($node->name).'</a><br />';
	}
	if (count($nodes) > 0) {
		$nextMessage .= $nextSet;
	}

	$nodeSet = getNodesByGlobal(0, 5 , 'date','DESC', "Solution");
	$nodes = $nodeSet->nodes;
	$nextSet = "";
	$nextSet .= '<br><b><img width="20" border="0" src="'.$CFG->solutionicon.'" />&nbsp;'.$LNG->SOLUTIONS_NAME.'</b><br>';
	foreach($nodes as $node) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'explore.php?id='.$node->nodeid.'">'.($node->name).'</a><br />';
	}
	if (count($nodes) > 0) {
		$nextMessage .= $nextSet;
	}

	// pro
	$nodeSet = getNodesByGlobal(0, 5 , 'date','DESC', 'Pro');
	$nodes = $nodeSet->nodes;
	$nextSet = "";
	$nextSet .= '<br><b><img width="20" border="0" src="'.$CFG->proicon.'" />&nbsp;'.$LNG->PROS_NAME.'</b><br>';
	foreach($nodes as $node) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'explore.php?id='.$node->nodeid.'">'.($node->name).'</a><br />';
	}
	if (count($nodes) > 0) {
		$nextMessage .= $nextSet;
	}

	// con
	$nodeSet = getNodesByGlobal(0, 5 , 'date','DESC', 'Con');
	$nodes = $nodeSet->nodes;
	$nextSet = "";
	$nextSet .= '<br><b><img width="20" border="0" src="'.$CFG->conicon.'" />&nbsp;'.$LNG->CONS_NAME.'</b><br>';
	foreach($nodes as $node) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'explore.php?id='.$node->nodeid.'">'.($node->name).'</a><br />';
	}
	if (count($nodes) > 0) {
		$nextMessage .= $nextSet;
	}

	// argument
	$nodeSet = getNodesByGlobal(0, 5 , 'date','DESC', 'Con');
	$nodes = $nodeSet->nodes;
	$nextSet = "";
	$nextSet .= '<br><b><img width="20" border="0" src="'.$CFG->argumenticon.'" />&nbsp;'.$LNG->ARGUMENTS_NAME.'</b><br>';
	foreach($nodes as $node) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'explore.php?id='.$node->nodeid.'">'.($node->name).'</a><br />';
	}
	if (count($nodes) > 0) {
		$nextMessage .= $nextSet;
	}

	// comments
	$nodeSet = getNodesByGlobal(0, 5 , 'date','DESC', "Idea");
	$nodes = $nodeSet->nodes;
	$nextSet = "";
	$nextSet .= '<br><b><img width="20" border="0" src="'.$CFG->commenticon.'" />&nbsp;'.$LNG->COMMENTS_NAME.'</b><br>';
	foreach($nodes as $node) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'index.php?q='.urlencode($node->name).'">'.($node->name).'</a><br />';
	}
	if (count($nodes) > 0) {
		$nextMessage .= $nextSet;
	}

	// user
	$userSet = getUsersByGlobal(false,0,5);
	$innerusers = $userSet->users;
	$nextSet = "";
	$nextSet .= '<br><b>'.$LNG->USERS_NAME.'</b><br>';
	foreach($innerusers as $inneruser) {
		$nextSet .= '<a style="font-size:8pt;" href="'.$CFG->homeAddress.'user.php?userid='.urlencode($inneruser->userid).'"><img width="20" border="0" src="'.$inneruser->thumb.'">&nbsp;'.($inneruser->name).'</a><br />';
	}

	// Don't send if there are only users
	if (count($innerusers) > 0 && $nextMessage != "") {
		$nextMessage .= $nextSet;
	}

//echo $user->userid.":BEFORE SEND message=".$nextMessage."\n";

	if ($nextMessage != "") {
		// email messages can't have more than 998 characters on one line or you get odd characters ! randomly through the email.
		$nextMessage = wordwrap($nextMessage,900, "\n");
		$unsubscribe = $CFG->homeAddress."ui/pages/profile.php";
		$paramArray = array ($user->name, $LNG->ADMIN_CRON_RECENT_ACTIVITY_MESSAGE, $nextMessage, $unsubscribe);

//echo $user->userid.":Emailing:".$user->getEmail()."\n";

		sendMail("recentactivity",$LNG->ADMIN_CRON_RECENT_ACTIVITY_TITLE, $user->getEmail(),$paramArray);
	} else {
		echo "\r\n".$LNG->$LNG->ADMIN_CRON_RECENT_ACTIVITY_NO_DIGEST." ".$user->getEmail();
	}
}

$USER = $currentUser;

echo "\r\n".$LNG->ADMIN_CRON_RECENT_ACTIVITY_DIGEST_RUN."\r\n";
?>