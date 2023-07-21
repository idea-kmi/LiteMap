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
 /** Author: Michelle Bachler, KMi, The Open University **/

$me = 'ui/stats/visdata.php';
if ($HUB_FLM->hasCustomVersion($me)) {
	$path = $HUB_FLM->getCodeDirPath($me);
	include_once($path);
	return; //must not die at this point
}

$sequence = array(11,2,3,4,7,8,9,10,12,13);

$dashboarddata = array();

//not actually used
$next = array();
$next[0] = $LNG->STATS_TAB_NETWORK;
$next[1] = 1;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/network-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/network.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_NETWORK;
$next[6] = "network";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_SOCIAL;
$next[1] = 2;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/socialnetwork-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/socialnetwork.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_SOCIAL;
$next[6] = "social";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_SUNBURST;
$next[1] = 3;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/sunburst-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/sunburst.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_SUNBURST;
$next[6] = "sunburst";
$next[7] = 150;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_STACKEDAREA;
$next[1] = 4;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/stackedarea-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/stackedarea.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_STACKEDAREA;
$next[6] = "stackedarea";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_TOPICSPACE;
$next[1] = 5;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/topicspace-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/topicspace.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_TOPICSPACE;
$next[6] = "topicspace";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_BIASSPACE;
$next[1] = 6;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/biasspace-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/biasspace.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_BIASSPACE;
$next[6] = "biasspace";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_CIRCLEPACKING;
$next[1] = 7;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/circlepacking-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/circlepacking.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_CIRCLEPACKING;
$next[6] = "circlepacking";
$next[7] = 140;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_ACTIVITY_ANALYSIS;
$next[1] = 8;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/activityanalysis-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/activityanalysis.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_ACTIVITY;
$next[6] = "activityfilter";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_USER_ACTIVITY_ANALYSIS;
$next[1] = 9;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/useractivityanalysis-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/useractivityanalysis.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_USER_ACTIVITY;
$next[6] = "useractivityfilter";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_STREAMGRAPH;
$next[1] = 10;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/streamgraph-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/streamgraph.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_STREAM_GRAPH;
$next[6] = "streamgraph";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_OVERVIEW;
$next[1] = 11;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/overview-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/overview.php?";
$next[5] = $LNG->STATS_GLOBAL_HELP_OVERVIEW;
$next[6] = "overview";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_GLOBAL_TAB_IDEAS;
$next[1] = 12;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/itemscreated-sm.png";
$next[4] = $CFG->homeAddress."ui/stats/newIdeas.php?";
$next[5] = '';
$next[6] = "ideas";
$next[7] = 170;
array_push($dashboarddata, $next);

$next = array();
$next[0] = $LNG->STATS_TAB_VOTES;
$next[1] = 13;
$next[2] = '';
$next[3] = $CFG->homeAddress."ui/stats/images/votes.png";
$next[4] = $CFG->homeAddress."ui/stats/votes.php?";
$next[5] = '';
$next[6] = "votes";
$next[7] = 170;
array_push($dashboarddata, $next);

?>
