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
 * stats.php
 *
 * Michelle Bachler (KMi)
 */

$LNG->LOADING_CIDASHBOARD_VISUALISATION = 'Loading a Live Visualisation from <a/href="https://cidashbaord.net" target="_blank">CIDashboard</a>...';
$LNG->LOADING_CIDASHBOARD_ANALYTICS = 'Loading Live Visual Analytics from <a/href="https://cidashbaord.net" target="_blank">CIDashboard</a>...';

$LNG->STATS_GO_BACK = "Go back";

$LNG->STATS_AVAILABLE_FROM = "Available Date Range from";
$LNG->STATS_AVAILABLE_TO = "to";
$LNG->STATS_START_DATE = "Show data from";
$LNG->STATS_END_DATE = "Show data to";
$LNG->STATS_LOAD_BUTTON = "Load Data";
$LNG->STATS_ACTIVITY_WARNING = "If there is a lot of data to load, your connection may timout. If this happens, please reduce the date range you have selected.";
$LNG->STATS_START_END_DATE_ERROR = "The from date must be earlier than the to date";
$LNG->STATS_START_DATE_ERROR = "Please select a date to load data from";
$LNG->STATS_END_DATE_ERROR = "Please select a date to load data to";

/** STATE PAGE NAMES **/
$LNG->STATS_TAB_MAP = 'Map';
$LNG->STATS_TAB_VIS = 'Alternative Views';
$LNG->STATS_TAB_ANALYTICS = 'Visual Analytics';

$LNG->STATS_TAB_NETWORK = $LNG->DEBATE_NAME.' Network';
$LNG->STATS_TAB_SOCIAL = 'Social Network';
$LNG->STATS_TAB_SUNBURST = 'People & Map Ring';
$LNG->STATS_TAB_STACKEDAREA = 'Contribution River';
$LNG->STATS_TAB_STREAMGRAPH = 'Contribution Stream';
$LNG->STATS_TAB_CIRCLEPACKING = $LNG->DEBATE_NAME.' Nesting';
$LNG->STATS_TAB_TOPICSPACE = 'Activity Bias';
$LNG->STATS_TAB_BIASSPACE = 'Rating Bias';
$LNG->STATS_TAB_ACTIVITY_ANALYSIS = 'Activity Analysis';
$LNG->STATS_TAB_USER_ACTIVITY_ANALYSIS = 'User Activity Analysis';
$LNG->STATS_TAB_OVERVIEW = 'Quick Overview';
$LNG->STATS_TAB_VOTES = 'Voting';
$LNG->STATS_TAB_TREEMAP = 'Treemap - Leaves';
$LNG->STATS_TAB_TREEMAPTD = 'Treemap - Top Down';
$LNG->STATS_TAB_RING = 'People & '.$LNG->ISSUE_NAME.' Ring';
$LNG->STATS_TAB_SUNBURST2 = 'Sunburst';

/** VISUALISATION HELP TEXTS **/

/** DEBATE LEVEL **/
$LNG->STATS_DEBATE_HELP_NETWORK = 'This visualisation shows a network of the '.$LNG->DEBATE_NAME.' contributions. There are zoom and orientation controls available below and you can also use your mouse wheel to zoom in and out.';
$LNG->STATS_DEBATE_HELP_SOCIAL = 'This visualisation shows a network of users participating in the '.$LNG->DEBATE_NAME.'. There are zoom and orientation controls available below and you can also use your mouse wheel to zoom in and out. The connections between users can be either green (mostly supporting connections), red (mostly counter connections), and grey (no dominant connection type).';
$LNG->STATS_DEBATE_HELP_SUNBURST = 'This visualisation shows users and their connections to '.$LNG->MAPS_NAME.'. The connections between users and '.$LNG->MAPS_NAME.' can be either green (mostly '.$LNG->PROS_NAME.'), red (mostly '.$LNG->CONS_NAME.'), and grey (no dominant contribution type). Click on a segment of the visualisation see further information about that member or '.$LNG->MAP_NAME.' in the details area panel.';
$LNG->STATS_DEBATE_HELP_STACKEDAREA = 'This visualisation shows types of contributions over time. Rollover the visualisation to view individual statistics for each type for each date. Click on the visualisation to filter by type. Right click on the visualisation or press the "Remove Filter" to unfilter the visualisation.';

$LNG->STATS_DEBATE_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">The following visualisation shows contributions to a '.$LNG->DEBATE_NAME.' arranged on a xy-plot. Use this visualisation to find clusters/groupings of contributions. A cluster of contributions represents similar contributions based on the activity of users with them (viewing, editing, updating of contributions, etc.).</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">The example on the top-right shows two clusters (two distinct groups of contributions with each having a distinct activity pattern).  The example on the bottom-right shows only one cluster. Often there are no distinct clusters.</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Use this visualisations to spot clusters. If the visualisation shows more than one cluster, then this is an indicator of the '.$LNG->DEBATE_NAME.' being biased regarding the interest people show by interacting with the '.$LNG->DEBATE_NAME.'. If there is only one cluster or no cluster, then this is an indicator that the '.$LNG->DEBATE_NAME.' is unbiased.</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Hover over a contribution point to see more information in the "Detail area".</div></div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_DEBATE_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">The following visualisation shows contributions to a '.$LNG->DEBATE_NAME.' arranged on a xy-plot. Use this visualisation to find clusters/groupings of contributions. A cluster of contributions represents similar contributions based on the voting by users.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">The example on the top-right shows two clusters (two distinct groups of contributions with each having a distinct voting pattern).  The example on the bottom-right shows only one cluster. Often there are no distinct clusters.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Use this visualisations to spot clusters. If the visualisation shows more than one cluster, then this is an indicator of the '.$LNG->DEBATE_NAME.' being biased regarding the voting behaviour of people. If there is only one cluster or no cluster, then this is an indicator that the '.$LNG->DEBATE_NAME.' is unbiased.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Hover over a contribution point to see more information in the "Detail area".</div></div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_DEBATE_HELP_CIRCLEPACKING = 'The following visualisation provides an overview of the entire '.$LNG->DEBATE_NAME.' as nested circles of contributions. Click on a circle to zoom in, click outside a circle to zoom out. Rollover a cirlce to view the item title as a tooltip.';
$LNG->STATS_DEBATE_HELP_ACTIVITY = 'The following visualisation shows activity of a '.$LNG->DEBATE_NAME.' over time. Click on the timeline to cover a period of time (click and drag). The visualisations below will change and will show the frequency of activity per day, the type of contribution ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' and '.$LNG->CON_NAME.'), the type of activity (viewing, adding, or  editing), and in the table below you can see the data underlying the visualisations.  There you can also reset the visualisation to its original state. You can click on the bars of the visualisations to filter for a specific type. You can also select several types by clicking on several bars. Click for example on the '.$LNG->ISSUE_NAME.' and '.$LNG->SOLUTION_NAME.' bar and on the viewing bar to filter for all viewed '.$LNG->ISSUES_NAME.' and '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_DEBATE_HELP_USER_ACTIVITY = 'The visualisation shows contributions of users to this '.$LNG->DEBATE_NAME.'. Click on the "Users" chart to filter by user. Click the "User Actions" chart to filter the page by Action. In both, you can select more than one. You can reset the page by clicking on "Reset All".';
$LNG->STATS_DEBATE_HELP_STREAM_GRAPH = 'This visualisation shows types of contributions over time. Rollover the visualisation to view individual statistics for each type for each date. Choose between a stacked, stream, and expanded view to inspect contributions over time.';
$LNG->STATS_DEBATE_HELP_OVERVIEW = 'This visualisations provides an overview of important aspects of a '.$LNG->DEBATE_NAME.'. It contains three '.$LNG->DEBATE_NAME.' health indicators (hover over the question mark next to each traffic light for more information) and several overview visualisations.';

/** DEBATE LEVEL **/
$LNG->STATS_GROUP_HELP_NETWORK = 'This visualisation shows a network of the contributions to the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.'. There are zoom and orientation controls available below and you can also use your mouse wheel to zoom in and out.';
$LNG->STATS_GROUP_HELP_SOCIAL = 'This visualisation shows a network of users participating in the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.'. There are zoom and orientation controls available below and you can also use your mouse wheel to zoom in and out. The connections between users can be either green (mostly supporting connections), red (mostly counter connections), and grey (no dominant connection type).';
$LNG->STATS_GROUP_HELP_SUNBURST = 'This visualisation shows users and their connections to '.$LNG->MAPS_NAME.'. The connections between users and '.$LNG->MAPS_NAME.' can be either green (mostly '.$LNG->PROS_NAME.'), red (mostly '.$LNG->CONS_NAME.'), and grey (no dominant contribution type). Click on a segment of the visualisation see further information about that member or '.$LNG->MAPS_NAME.' in the details area panel.';
$LNG->STATS_GROUP_HELP_STACKEDAREA = 'This visualisation shows types of contributions over time. Rollover the visualisation to view individual statistics for each type for each date. Click on the visualisation to filter by type. Right click on the visualisation or press the "Remove Filter" to unfilter the visualisation.';

$LNG->STATS_GROUP_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">The following visualisation shows contributions to the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.' arranged on a xy-plot. Use this visualisation to find clusters/groupings of contributions. A cluster of contributions represents similar contributions based on the activity of users with them (viewing, editing, updating of contributions, etc.).</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">The example on the top-right shows two clusters (two distinct groups of contributions with each having a distinct activity pattern).  The example on the bottom-right shows only one cluster. Often there are no distinct clusters.</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Use this visualisations to spot clusters. If the visualisation shows more than one cluster, then this is an indicator of the '.$LNG->DEBATE_NAME.' being biased regarding the interest people show by interacting with the '.$LNG->DEBATE_NAME.'. If there is only one cluster or no cluster, then this is an indicator that the '.$LNG->DEBATE_NAME.' is unbiased.</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Hover over a contribution point to see more information in the "Detail area".</div></div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GROUP_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">The following visualisation shows contributions to the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.' arranged on a xy-plot. Use this visualisation to find clusters/groupings of contributions. A cluster of contributions represents similar contributions based on the voting by users.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">The example on the top-right shows two clusters (two distinct groups of contributions with each having a distinct voting pattern).  The example on the bottom-right shows only one cluster. Often there are no distinct clusters.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Use this visualisations to spot clusters. If the visualisation shows more than one cluster, then this is an indicator of the '.$LNG->DEBATE_NAME.' being biased regarding the voting behaviour of people. If there is only one cluster or no cluster, then this is an indicator that the '.$LNG->DEBATE_NAME.' is unbiased.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Hover over a contribution point to see more information in the "Detail area".</div></div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GROUP_HELP_CIRCLEPACKING = 'The following visualisation provides an overview of all the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.' as nested circles of contributions. Click on a circle to zoom in, click outside a circle to zoom out. Rollover a cirlce to view the item title as a tooltip.';
$LNG->STATS_GROUP_HELP_ACTIVITY = 'The following visualisation shows the activity of the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.' over time. Click on the timeline to cover a period of time (click and drag). The visualisations below will change and will show the frequency of activity per day, the type of contribution ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' and '.$LNG->CON_NAME.'), the type of activity (viewing, adding, or  editing), and in the table below you can see the data underlying the visualisations.  There you can also reset the visualisation to its original state. You can click on the bars of the visualisations to filter for a specific type. You can also select several types by clicking on several bars. Click for example on the '.$LNG->ISSUE_NAME.' and '.$LNG->SOLUTION_NAME.' bar and on the viewing bar to filter for all viewed '.$LNG->ISSUES_NAME.' and '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_GROUP_HELP_USER_ACTIVITY = 'The visualisation shows contributions of users to the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.'. Click on the "Users" chart to filter by user. Click the "User Actions" chart to filter the page by Action. In both, you can select more than one. You can reset the page by clicking on "Reset All".';
$LNG->STATS_GROUP_HELP_STREAM_GRAPH = 'This visualisation shows types of contributions over time. Rollover the visualisation to view individual statistics for each type for each date. Choose between a stacked, stream, and expanded view to inspect contributions over time.';
$LNG->STATS_GROUP_HELP_OVERVIEW = 'This visualisations provides an overview of important aspects of the '.$LNG->DEBATES_NAME.' in this '.$LNG->GROUP_NAME.'. It contains three '.$LNG->DEBATE_NAME.' health indicators (hover over the question mark next to each traffic light for more information) and several overview visualisations.';

/** GLOBAL LEVEL **/
$LNG->STATS_GLOBAL_HELP_NETWORK = 'This visualisation shows a network of the contributions to the '.$LNG->DEBATES_NAME.' on this site. There are zoom and orientation controls available below and you can also use your mouse wheel to zoom in and out.';
$LNG->STATS_GLOBAL_HELP_SOCIAL = 'This visualisation shows a network of users participating in the '.$LNG->DEBATES_NAME.' on this site. There are zoom and orientation controls available below and you can also use your mouse wheel to zoom in and out. The connections between users can be either green (mostly supporting connections), red (mostly counter connections), and grey (no dominant connection type).';
$LNG->STATS_GLOBAL_HELP_SUNBURST = 'This visualisation shows users and their connections to '.$LNG->MAPS_NAME.'. The connections between users and '.$LNG->MAPS_NAME.' can be either green (mostly '.$LNG->PROS_NAME.'), red (mostly '.$LNG->CONS_NAME.'), and grey (no dominant contribution type). Click on a segment of the visualisation see further information about that member or '.$LNG->MAPS_NAME.' in the details area panel.';
$LNG->STATS_GLOBAL_HELP_STACKEDAREA = 'This visualisation shows types of contributions over time. Rollover the visualisation to view individual statistics for each type for each date. Click on the visualisation to filter by type. Right click on the visualisation or press the "Remove Filter" to unfilter the visualisation.';

$LNG->STATS_GLOBAL_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">The following visualisation shows contributions to the '.$LNG->DEBATES_NAME.' on this site arranged on a xy-plot. Use this visualisation to find clusters/groupings of contributions. A cluster of contributions represents similar contributions based on the activity of users with them (viewing, editing, updating of contributions, etc.).</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">The example on the top-right shows two clusters (two distinct groups of contributions with each having a distinct activity pattern).  The example on the bottom-right shows only one cluster. Often there are no distinct clusters.</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Use this visualisations to spot clusters. If the visualisation shows more than one cluster, then this is an indicator of the '.$LNG->DEBATE_NAME.' being biased regarding the interest people show by interacting with the '.$LNG->DEBATE_NAME.'. If there is only one cluster or no cluster, then this is an indicator that the '.$LNG->DEBATE_NAME.' is unbiased.</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Hover over a contribution point to see more information in the "Detail area".</div></div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GLOBAL_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">The following visualisation shows contributions to the '.$LNG->DEBATES_NAME.' on this site arranged on a xy-plot. Use this visualisation to find clusters/groupings of contributions. A cluster of contributions represents similar contributions based on the voting by users.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">The example on the top-right shows two clusters (two distinct groups of contributions with each having a distinct voting pattern).  The example on the bottom-right shows only one cluster. Often there are no distinct clusters.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Use this visualisations to spot clusters. If the visualisation shows more than one cluster, then this is an indicator of the '.$LNG->DEBATE_NAME.' being biased regarding the voting behaviour of people. If there is only one cluster or no cluster, then this is an indicator that the '.$LNG->DEBATE_NAME.' is unbiased.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Hover over a contribution point to see more information in the "Detail area".</div></div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GLOBAL_HELP_CIRCLEPACKING = 'The following visualisation provides an overview of all the '.$LNG->DEBATES_NAME.' on this site as nested circles of contributions. Click on a circle to zoom in, click outside a circle to zoom out. Rollover a cirlce to view the item title as a tooltip.';
$LNG->STATS_GLOBAL_HELP_ACTIVITY = 'The following visualisation shows the activity of the '.$LNG->DEBATES_NAME.' on this over time. Click on the timeline to cover a period of time (click and drag). The visualisations below will change and will show the frequency of activity per day, the type of contribution ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' and '.$LNG->CON_NAME.'), the type of activity (viewing, adding, or  editing), and in the table below you can see the data underlying the visualisations.  There you can also reset the visualisation to its original state. You can click on the bars of the visualisations to filter for a specific type. You can also select several types by clicking on several bars. Click for example on the '.$LNG->ISSUE_NAME.' and '.$LNG->SOLUTION_NAME.' bar and on the viewing bar to filter for all viewed '.$LNG->ISSUES_NAME.' and '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_GLOBAL_HELP_USER_ACTIVITY = 'The visualisation shows contributions of users to the '.$LNG->DEBATES_NAME.' on this site. Click on the "Users" chart to filter by user. Click the "User Actions" chart to filter the page by Action. In both, you can select more than one. You can reset the page by clicking on "Reset All".';
$LNG->STATS_GLOBAL_HELP_STREAM_GRAPH = 'This visualisation shows types of contributions over time. Rollover the visualisation to view individual statistics for each type for each date. Choose between a stacked, stream, and expanded view to inspect contributions over time.';
$LNG->STATS_GLOBAL_HELP_OVERVIEW = 'This visualisations provides an overview of important aspects of the '.$LNG->DEBATES_NAME.' on this site. It contains three '.$LNG->DEBATE_NAME.' health indicators (hover over the question mark next to each traffic light for more information) and several overview visualisations.';

/** OVERVIEW PAGE **/
$LNG->STATS_OVERVIEW_MAIN_TITLE='Overview';
$LNG->STATS_OVERVIEW_WORDS_MESSAGE = 'Word count statistics:';
$LNG->STATS_OVERVIEW_CONTRIBUTION_MESSAGE = 'User contributions';
$LNG->STATS_OVERVIEW_VIEWING_MESSAGE = "User viewing activity";
$LNG->STATS_OVERVIEW_HEALTH_TITLE = $LNG->DEBATE_NAME.' Health Indicators';
$LNG->STATS_OVERVIEW_HEALTH_PROBLEM = 'There is a problem.';
$LNG->STATS_OVERVIEW_HEALTH_NO_PROBLEM = 'There seems to be no problem.';
$LNG->STATS_OVERVIEW_HEALTH_MAYBE_PROBLEM = 'There might be a problem.';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_TITLE = 'Contribution Activity Indicator';
$LNG->STATS_OVERVIEW_HEALTH_VIEWING_TITLE = 'Viewing Activity Indicator';
$LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_TITLE = 'Participation Indicator';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTORS = 'participated in this '.$LNG->DEBATE_NAME.".";
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS = 'logged in';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_PART2 = 'viewed this '.$LNG->DEBATE_NAME;
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_RED = ' in the last last 14 days';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_ORANGE = ' between 6 and 14 days ago';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_GREEN = ' in the last 5 days';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION = ' contributed';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_RED = ' in the last last 14 days';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_ORANGE = ' between 6 and 14 days ago';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_GREEN = ' in the last 5 days';
$LNG->STATS_OVERVIEW_LOADING_MESSAGE = '(Loading Overview Statistics. These may take a a short while to calculate depending on the size of the discourse data...)';
$LNG->STATS_OVERVIEW_TOP_THREE_VOTES_MESSAGE = 'Most voted on entries:';
$LNG->STATS_OVERVIEW_RECENT_NODES_MESSAGE = 'Most recently added:';
$LNG->STATS_OVERVIEW_RECENT_VOTES_MESSAGE = 'Most recently voted on:';
$LNG->STATS_OVERVIEW_DATE = 'Date:';
$LNG->STATS_OVERVIEW_VOTES = 'Votes:';
$LNG->STATS_OVERVIEW_TIME = 'time';
$LNG->STATS_OVERVIEW_TIMES = 'times';
$LNG->STATS_OVERVIEW_PERSON = 'person';
$LNG->STATS_OVERVIEW_PEOPLE = 'people';
$LNG->STATS_OVERVIEW_WORDS_AVERAGE = 'Average contribution:';
$LNG->STATS_OVERVIEW_WORDS = 'words';
$LNG->STATS_OVERVIEW_WORDS_MIN = 'minimum:';
$LNG->STATS_OVERVIEW_WORDS_MAX = 'maximum:';
$LNG->STATS_OVERVIEW_VIEWING_HIGHEST = 'Highest viewing count was';
$LNG->STATS_OVERVIEW_VIEWING_LOWEST = 'Lowest viewing count was';
$LNG->STATS_OVERVIEW_VIEWING_LAST = 'Last viewing count was';
$LNG->STATS_OVERVIEW_VIEWING_VIEWS = 'views';
$LNG->STATS_OVERVIEW_VIEWING_ON = 'on';
$LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_HINT = 'If less than 3 people have participated in this '.$LNG->DEBATE_NAME.' then this will show a red traffic light. If between 3 and 5 people have participated in this '.$LNG->DEBATE_NAME.' then this will show an orange traffic light. If more than 5 people have participated in this '.$LNG->DEBATE_NAME.' then this will show a green traffic light.';
$LNG->STATS_OVERVIEW_HEALTH_VIEWING_HINT = 'If no logged in people have viewied this '.$LNG->DEBATE_NAME.' for more than 14 days, this will show a red traffic light. If logged in people have viewed this '.$LNG->DEBATE_NAME.' between 6 and 14 days ago this will show an orange traffic light. If logged in people have viewed this '.$LNG->DEBATE_NAME.' in the last 5 days this will show a green traffic light.';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_HINT = 'If people have not added a new entry to this '.$LNG->DEBATE_NAME.' for more than 14 days, this will show a red traffic light. If people have added a new entry to this '.$LNG->DEBATE_NAME.' between 6 and 14 days ago this will show an orange traffic light. If people have added a new entry to this '.$LNG->DEBATE_NAME.' in the last 5 days this will show a green traffic light.';

/** ISSUE SIDE STATS **/
$LNG->STATS_DEBATE_HEALTH_TITLE = $LNG->DEBATE_NAME.' Health Indicators';
$LNG->STATS_DEBATE_HEALTH_MESSAGE = 'Click on each traffic light for more information';
$LNG->STATS_DEBATE_HEALTH_EXPLORE = 'Explore further:';

$LNG->STATS_DEBATE_PARTICIPATION_TITLE = 'Participation';

$LNG->STATS_DEBATE_CONTRIBUTION_TITLE = 'Balance Indicator';
$LNG->STATS_DEBATE_CONTRIBUTION_MESSAGE = 'The conversation would benefit from more';
$LNG->STATS_DEBATE_AND = 'and';
$LNG->STATS_DEBATE_CONTRIBUTION_GREEN = 'The conversation types are balanced.';
$LNG->STATS_DEBATE_CONTRIBUTION_HELP = 'This traffic light indicates how balanced the types of contributions are to the debate. If one of the types ('.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.', '.$LNG->CON_NAME.', or '.$LNG->VOTES_NAME.') is barley represented (under 10%) it will show a red traffic light. If one of the types is under-represented (under 20%) then it shows a yellow traffic light. Otherwise, the types are balanced and it will show a green traffic light.';

$LNG->STATS_DEBATE_VIEWING_TITLE = 'Group Awareness';
$LNG->STATS_DEBATE_VIEWING_HELP = 'This indicator represents the percentage of members of this group who viewed this issue. If 50% or more members of this group viewed this issue then it will show a green traffic light. If 20% to 49% viewed it then it will show a yellow traffic light. If less than 20% viewed this issue it will show a red traffic light.';
$LNG->STATS_DEBATE_VIEWING_MESSAGE_PART1 = 'of this group out of';
$LNG->STATS_DEBATE_VIEWING_MESSAGE_PART2 = 'viewed this '.$LNG->DEBATE_NAME.'.';

$LNG->STATS_DASHBOARD_HELP_HINT = "Click to show/hide visualisation description.";

/** GROUP STATS **/
$LNG->STATS_GROUP_TITLE = 'Group Analytics for: ';

$LNG->STATS_ACTIVITY_COLUMN_DATE = 'Date';
$LNG->STATS_ACTIVITY_COLUMN_TITLE = 'Title';
$LNG->STATS_ACTIVITY_COLUMN_ITEM_TYPE = 'Contribution Type';
$LNG->STATS_ACTIVITY_COLUMN_TYPE = 'Activity Type';
$LNG->STATS_ACTIVITY_COLUMN_ACTION = 'User Action';
$LNG->STATS_ACTIVITY_FILTER_DATE_TITLE = 'Date';
$LNG->STATS_ACTIVITY_FILTER_MONTH_TITLE = 'Month';
$LNG->STATS_ACTIVITY_FILTER_DAYS_TITLE = 'Days of Week';
$LNG->STATS_ACTIVITY_FILTER_ITEM_TYPES_TITLE = 'Contribution Types';
$LNG->STATS_ACTIVITY_FILTER_TYPES_TITLE = 'Activity Types';
$LNG->STATS_ACTIVITY_FILTER_USERS_TITLE = 'Users';
$LNG->STATS_ACTIVITY_FILTER_ACTION_TITLE = 'User Actions';
$LNG->STATS_ACTIVITY_USER_ANONYMOUS = "u";
$LNG->STATS_ACTIVITY_USER_ANONYMOUS_NAME = "Unknown User";

$LNG->STATS_ACTIVITY_CREATE = 'Create';
$LNG->STATS_ACTIVITY_UPDATE = 'Update';
$LNG->STATS_ACTIVITY_DELETE = 'Delete';
$LNG->STATS_ACTIVITY_VIEW = 'View';
$LNG->STATS_ACTIVITY_VOTE = 'Vote';
$LNG->STATS_ACTIVITY_VOTED_FOR = 'Voted For';
$LNG->STATS_ACTIVITY_VOTED_AGAINST = 'Voted Against';

$LNG->STATS_ACTIVITY_SUNDAY = 'Sun';
$LNG->STATS_ACTIVITY_MONDAY = 'Mon';
$LNG->STATS_ACTIVITY_TUESDAY = 'Tue';
$LNG->STATS_ACTIVITY_WEDNESDAY = 'Wed';
$LNG->STATS_ACTIVITY_THURSDAY = 'Thu';
$LNG->STATS_ACTIVITY_FRIDAY = 'Fri';
$LNG->STATS_ACTIVITY_SATURDAY = 'Sat';

$LNG->STATS_ACTIVITY_JAN = 'January';
$LNG->STATS_ACTIVITY_FEB = 'February';
$LNG->STATS_ACTIVITY_MAR = 'March';
$LNG->STATS_ACTIVITY_APR = 'April';
$LNG->STATS_ACTIVITY_MAY = 'May';
$LNG->STATS_ACTIVITY_JUN = 'June';
$LNG->STATS_ACTIVITY_JUL = 'July';
$LNG->STATS_ACTIVITY_AUG = 'August';
$LNG->STATS_ACTIVITY_SEP = 'September';
$LNG->STATS_ACTIVITY_OCT = 'October';
$LNG->STATS_ACTIVITY_NOV = 'Nov';
$LNG->STATS_ACTIVITY_DEC = 'Dec';

$LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART1 = 'selected out of';
$LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART2 = 'records';
$LNG->STATS_ACTIVITY_RESET_ALL_BUTTON = 'Reset All';

$LNG->STATS_SCATTERPLOT_DETAILS_COUNT = "Entries:";
$LNG->STATS_SCATTERPLOT_DETAILS = "Details Area";
$LNG->STATS_SCATTERPLOT_DETAILS_CLICK = "Hover over contribution point to view details.";

$LNG->STATS_GROUP_STACKEDAREA_TITLE = 'Key';
$LNG->STATS_GROUP_STACKEDAREA_HELP = 'Hover over a coloured area at a given time to display a contribution count for that item type for that date.<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_HELP .= 'Left-click a coloured area to filter diagram on that item type.<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_HELP .= 'Right-click to remove the filter (or click the button below).<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_RESTORE_BUTTON = 'Remove Filter';
$LNG->STATS_GROUP_STACKEDAREA_ERROR = 'There is insufficient data available to draw this visualisation at present.';

$LNG->STATS_GROUP_SUNBURST_PERSON = 'Member';
$LNG->STATS_GROUP_SUNBURST_DEBATE = $LNG->MAP_NAME;
$LNG->STATS_GROUP_SUNBURST_CONNECTED_DEBATE = 'was contributed to by:';
$LNG->STATS_GROUP_SUNBURST_CONNECTED_USER = 'and is connected to:';
$LNG->STATS_GROUP_SUNBURST_WITH = 'with:';
$LNG->STATS_GROUP_SUNBURST_CREATED = 'created:';
$LNG->STATS_GROUP_SUNBURST_DETAILS = "Details Area";
$LNG->STATS_GROUP_SUNBURST_DETAILS_CLICK = "Click section to view more details";
$LNG->STATS_GROUP_SUNBURST_DEBATE_CREATED = $LNG->ISSUES_NAME.":";
$LNG->STATS_GROUP_SUNBURST_DEBATE_OWNED = $LNG->ISSUES_NAME." owner";
$LNG->STATS_GROUP_OVERVIEW_USED_LINKS_LABEL = 'Most common '.$LNG->ISSUES_NAME.' activity';
$LNG->STATS_GROUP_OVERVIEW_USED_IDEAS_LABEL = 'Most common contribution type';

/** DEBATE STATS **/
$LNG->STATS_DEBATE_TITLE = $LNG->MAP_NAME.' Analytics for: ';
$LNG->STATS_DEBATE_OVERVIEW_TOP_NODETYPE_USAGE = 'Item Type Usage';

/** GLOBAL STATS **/
$LNG->HOMEPAGE_STATS_LINK = "Analytics";

/// Connections page
$LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->ISSUES_NAME;
$LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->SOLUTIONS_NAME;
$LNG->OVERVIEW_RESOURCE_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->RESOURCES_NAME;
$LNG->OVERVIEW_PRO_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->PROS_NAME;
$LNG->OVERVIEW_CON_MOSTCONNECTED_TITLE = 'Most Connected '.$LNG->CONS_NAME;

$LNG->STATS_GLOBAL_TITLE = 'Global Analytics';
$LNG->STATS_GLOBAL_TAB_IDEAS = 'Items Created';

$LNG->STATS_GLOBAL_VOTES_TOP_NODES = 'Top 10 Voted ON Items';
$LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES = "Top 10 Voted FOR Items";
$LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES = "Top 10 Voted AGAINST Items";
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING = 'Name';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING = 'Total';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING = 'For';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING = 'Against';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING = "Category";
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS = 'Top 10 Voters';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_FOR = 'Top 10 Voters FOR';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_AGAINST = 'Top 10 Voters AGAINST';
$LNG->STATS_GLOBAL_VOTES_VOTING_MENU_TITLE = 'View Top Item Voting';
$LNG->STATS_GLOBAL_VOTES_VOTERS_MENU_TITLE = 'View Top Item Voters';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTES_MENU_TITLE = 'View All Item Voting';
$LNG->STATS_GLOBAL_VOTES_BACK_UP = 'Go back to options menu';
$LNG->STATS_GLOBAL_VOTES_MENU_TITLE = 'Voting Stats';
$LNG->STATS_GLOBAL_ITEM_VOTES_MENU_TITLE = 'Items Voting Stats';
$LNG->STATS_GLOBAL_CONNECTION_VOTES_MENU_TITLE = 'Connection Voting Stats';
$LNG->STATS_GLOBAL_ALL_VOTES_MENU_TITLE = 'All Voting Stats';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTING_TITLE = 'All Item Voting';
$LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING = 'Item For';
$LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING = 'Item Against';
$LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING = 'Connection For';
$LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING = 'Connection Against';

$LNG->STATS_GLOBAL_OVERVIEW_HEADER_TYPE = 'Type';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_NAME = 'Name';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_COUNT = 'Count';
$LNG->STATS_GLOBAL_OVERVIEW_USED_LINKS_LABEL = 'Most common activity';
$LNG->STATS_GLOBAL_OVERVIEW_USED_IDEAS_LABEL = 'Most common contribution type';
$LNG->STATS_GLOBAL_OVERVIEW_CONNECTED_IDEA_LABEL = 'Most connected Item';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS = 'Top Connection Builders';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_IDEA_CREATORS = 'Top Item Creators';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS_LINKS = 'Top Connection Builders - Their LinkType Usage';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART1 = 'To view your personal analytics go to your';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART2 = 'home page';

$LNG->STATS_GLOBAL_REGISTER_TOTAL_LABEL = 'Total user count';
$LNG->STATS_GLOBAL_REGISTER_HEADER_NAME = 'Name';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DATE = 'Date';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DESC = 'Description';
$LNG->STATS_GLOBAL_REGISTER_HEADER_WEBSITE = 'Website';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LOCATION = 'Location';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LAST_LOGIN = 'Last Sign In';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_TITLE = 'User Registration By Month';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_TITLE = 'User Registration By Week';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_X_LABEL = 'Number of Registrations';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_Y_LABEL = 'Months (from';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_Y_LABEL = 'Weeks (from';

$LNG->STATS_GLOBAL_IDEAS_TOTAL_LABEL = 'Total count';
$LNG->STATS_GLOBAL_IDEAS_MONTHLY_TOTAL_LABEL = 'Monthly Total';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_TITLE  ='Weekly Item Creation for the last Year';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_TITLE  ='Monthly Item Creation for the last Year';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_Y_LABEL = 'Months (from';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_Y_LABEL = 'Weeks (from';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_X_LABEL = 'Number of Ideas';

$LNG->STATS_GLOBAL_CONNS_TOTAL_LABEL = 'Total connection count';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_TITLE  ='Weekly Connection Creation for the last Year';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_TITLE  ='Monthly Connection Creation for the last Year';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_Y_LABEL = 'Months (from';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_Y_LABEL = 'Weeks (from';
$LNG->STATS_GLOBAL_CONNS_GRAPH_X_LABEL = 'Number of Connections';

/** USER STATS **/
$LNG->STATS_USER_TITLE = 'Stats for';
$LNG->STATS_USER_NAME_HEADING = 'Name';
$LNG->STATS_USER_ITEM_HEADING = 'Item';
$LNG->STATS_USER_COUNT_HEADING = 'Count';
$LNG->STATS_USER_ACTION_HEADING = 'Action';
$LNG->STATS_USER_POPULAR_LINK_HEADING = 'Most Used Link Type';
$LNG->STATS_USER_VIEW_ALL = 'view all';
$LNG->STATS_USER_POPULAR_NODE_HEADING = 'Most Used Node Type';
$LNG->STATS_USER_TOP_TEN = 'top 10';
$LNG->STATS_USER_COUNT_HEADING = 'Count';
$LNG->STATS_USER_LINK_TYPES_HEADING = 'Link Types';
$LNG->STATS_USER_NODE_TYPES_HEADING = 'Node Types';
$LNG->STATS_USER_COMPARED_THINKING = 'Compared Thinking';
$LNG->STATS_USER_INFORMATION_THINKING = 'Information Broker';
$LNG->STATS_USER_SUMMARY_TITLE = 'SUMMARY';
$LNG->STATS_USER_VOTE_TITLE = 'Item Voting';

/** GRAPH BUTTONS ETC.. **/
$LNG->GRAPH_PRINT_HINT = "Print this network graph";
$LNG->GRAPH_ZOOM_FIT_HINT = "Scale graph down if required and move to make it all fit in the visible area";
$LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT = "Zoom this network graph to 100%";
$LNG->GRAPH_ZOOM_IN_HINT = "Zoom in";
$LNG->GRAPH_ZOOM_OUT_HINT = "Zoom out";
$LNG->GRAPH_CONNECTION_COUNT_LABEL = 'Connections:';
$LNG->GRAPH_NOT_SUPPORTED = 'Your current browser does not support HTML5 Canvas.<br><br>Please upgrade to a newer version if you wish to view this visualisation: IE 9.0+; Firefox 23.0+; Chrome 29.0+; Opera 17.0+; Safari 5.1+';

/** NETWORK MAPS **/
$LNG->NETWORKMAPS_RESIZE_MAP_HINT = 'Resize the Map';
$LNG->NETWORKMAPS_ENLARGE_MAP_LINK = 'Enlarge Map';
$LNG->NETWORKMAPS_REDUCE_MAP_LINK = 'Reduce Map';
$LNG->NETWORKMAPS_EXPLORE_ITEM_LINK = 'Explore Item';
$LNG->NETWORKMAPS_EXPLORE_ITEM_HINT = 'Open the full details page for the current item';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_LINK = 'Explore Author';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_HINT = 'Go to home page for item author';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_CONNECTION_HINT = 'Go to home page for connection author';
$LNG->NETWORKMAPS_SELECTED_NODEID_ERROR = 'Please make sure you have made a selection in the map.';
$LNG->NETWORKMAPS_MAC_PAINT_ISSUE_WARNING = '(This visualization requires Java 7 on MacOS X 10.7 onwards (Lion) to work correctly)';
$LNG->NETWORKMAPS_APPLET_NOT_RECOGNISED_ERROR = '(Your browser recognizes the APPLET element but does not run the applet.)';
$LNG->NETWORKMAPS_LOADING_MESSAGE = '(Loading map...)';
$LNG->NETWORKMAPS_APPLET_REF_BROKEN_ERROR = 'Map Applet reference broken. Please restart your browser.';
$LNG->NETWORKMAPS_NO_RESULTS_MESSAGE = 'No results found. Please select again.';
$LNG->NETWORKMAPS_OPTIONAL_TYPE = 'and optionally a type';
$LNG->NETWORKMAPS_KEY_SELECTED_ITEM = 'Selected item';
$LNG->NETWORKMAPS_KEY_FOCAL_ITEM = 'Focal item';
$LNG->NETWORKMAPS_KEY_NEIGHBOUR_ITEM = 'Neighbour item';
$LNG->NETWORKMAPS_KEY_SOCIAL_MODERATELY = 'Moderately connected';
$LNG->NETWORKMAPS_KEY_SOCIAL_HIGHLY = 'Highly connected';
$LNG->NETWORKMAPS_KEY_SOCIAL_SLIGHTLY = 'Slightly connected';
$LNG->NETWORKMAPS_KEY_SOCIAL_MOST = 'The most connected';
$LNG->NETWORKMAPS_PERCENTAGE_MESSAGE = '% of layout computed...';
$LNG->NETWORKMAPS_SCALING_MESSAGE = 'Scaling to fit page...';

$LNG->NETWORKMAPS_SOCIAL_ITEM_HINT = "Open the home page of the currently selected person";
$LNG->NETWORKMAPS_SOCIAL_ITEM_LINK = 'Explore Selected Person';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT = 'Show all connections for the selected link';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_LINK = 'Explore Selected Link';
$LNG->NETWORKMAPS_SOCIAL_LOADING_MESSAGE = '(Loading Social Network View. This may take a few minutes to calculate depending on the size of the Hub...)';
$LNG->NETWORKMAPS_SOCIAL_NO_RESULTS_MESSAGE = 'No data to calculate the Social Network from.';
$LNG->NETWORKMAPS_SOCIAL_CONNECTIONS = 'Connections';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION = 'Connection';

/** LITEMAP SPECIFIC **/
$LNG->GRAPH_EMBEDEDIT_HINT = "Get the iframe code to embed this as an editable ".$LNG->MAP_NAME." in another site";
$LNG->GRAPH_EMBEDEDIT_MESSAGE = "Please copy the code below to embed this ".$LNG->MAP_NAME." into another website. For maps in a group, make group joining open and people will be automatically added to the group when they login:";
$LNG->GRAPH_EMBED_HINT = "Get the iframe code to embed this as a read only ".$LNG->MAP_NAME." in another site";
$LNG->GRAPH_EMBED_MESSAGE = "Please copy the code below to embed this ".$LNG->MAP_NAME." into another website:";
$LNG->GRAPH_HELP_HINT = "Map Help";
$LNG->NETWORKMAPS_VIEW_LINEAR = 'Linear View';
$LNG->NETWORKMAPS_VIEW_MAP = 'Map View';

$LNG->GRAPH_JSONLD_HINT = "Get the restful api call to fetch the jsonld representation of this ".$LNG->MAP_NAME;
$LNG->GRAPH_JSONLD_MESSAGE = "Copy this link into your browser to fetch the jsonld representation of this ".$LNG->MAP_NAME;
$LNG->GRAPH_JSONLD_HINT_GROUP = "Get the restful api call to fetch the jsonld representation of the ".$LNG->MAPS_NAME." in this group.";
$LNG->GRAPH_JSONLD_MESSAGE_GROUP = "Copy this link into your browser to fetch the jsonld representation of the ".$LNG->MAPS_NAME." in this group.";

$LNG->GRAPH_LINK_MESSAGE = 'Copy the link below to get the url representing this node in this '.$LNG->MAP_NAME;
$LNG->GRAPH_LINK_HINT = 'Click to get a url to this node in this '.$LNG->MAP_NAME;


// ALERT MESSAGES

$LNG->ALERTS_BOX_TITLE = 'Alerts';

//RETURNS POSTS / PEOPLE BASED
$LNG->ALERT_UNSEEN_BY_ME = "Unseen by me";
$LNG->ALERT_HINT_UNSEEN_BY_ME = "I have not seen this post yet.";

$LNG->ALERT_RESPONSE_TO_ME = "Reponse to my post";
$LNG->ALERT_HINT_RESPONSE_TO_ME = "This post is a response to a post I authored.";

$LNG->ALERT_UNRATED_BY_ME = "Not voted on by me";
$LNG->ALERT_HINT_UNRATED_BY_ME = "I have not yet voted on this post.";

$LNG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME = "Viewed by similar people to me";
$LNG->ALERT_HINT_INTERESTING_TO_PEOPLE_LIKE_ME = "This post was viewed by people with similar interests to me (based on SVD analysis of activity patterns).";

$LNG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME = "Voted on by similar people to me";
$LNG->ALERT_HINT_SUPPORTED_BY_PEOPLE_LIKE_ME = "This post was voted highly by people whose opinions are similar to mine (based on SVD analysis of rating patterns).";

$LNG->ALERT_INTERESTING_TO_ME = 'Interesting to me';
$LNG->ALERT_HINT_INTERESTING_TO_ME = 'Find posts that should interest a user, given their previous interests. This alert estimates the user\'s interests in each post based on how much attention he/she gave it or it\'s nearest neighbors in the past. It then identifies the posts whose "interest" scores are in the top 50%.';

$LNG->ALERT_UNSEEN_COMPETITOR = 'Unseen competitor';
$LNG->ALERT_HINT_UNSEEN_COMPETITOR = 'Identifies ideas from someone else that competes with an idea I authored.';

$LNG->ALERT_UNSEEN_RESPONSE = 'Unseen response';
$LNG->ALERT_HINT_UNSEEN_RESPONSE = 'Identifies unseen (by me) responses authored by someone else to a post I authored.';


//RETURNS PEOPLE / PEOPLE BASED
$LNG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "People like me - by interests";
$LNG->ALERT_HINT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "People who have similar interests to me, based on activity patterns.";

$LNG->ALERT_PEOPLE_WHO_AGREE_WITH_ME = "People like me - by voting";
$LNG->ALERT_HINT_PEOPLE_WHO_AGREE_WITH_ME = "People who have similar opinions to mine, based on rating patterns.";

$LNG->ALERT_LURKING_USER = 'Lurking user';
$LNG->ALERT_HINT_LURKING_USER = 'User has not edited or created any posts';

$LNG->ALERT_INACTIVE_USER = 'Inactive user';
$LNG->ALERT_HINT_INACTIVE_USER = 'Finds users who have done zilch';

$LNG->ALERT_USER_IGNORED_COMPETITORS = 'User ignored competitors';
$LNG->ALERT_HINT_USER_IGNORED_COMPETITORS = 'Identifies users who ignored competitors to their ideas. For each user, it lists the issues the user offered ideas for, followed by the competing ideas that the user ignored (i.e. did not view or respond to).';

$LNG->ALERT_USER_IGNORED_ARGUMENTS = 'User ignored arguments';
$LNG->ALERT_HINT_USER_IGNORED_ARGUMENTS = 'Identifies users who ignored underlying arguments when rating posts. For each user, it lists the rated posts followed by the arguments for each of those posts that the user ignored (i.e. did not view or respond to).';

$LNG->ALERT_USER_IGNORED_RESPONSES = 'User ignored responses';
$LNG->ALERT_HINT_USER_IGNORED_RESPONSES = 'Identifies users who ignored responses by other people to their posts. For each user, it lists the user-authored posts followed responses to each of those posts that the user ignored (i.e. did not view or respond to).';


//RETURNS POSTS / MAP BASED
$LNG->ALERT_HOT_POST = "Hot post";
$LNG->ALERT_HINT_HOT_POST = "This post has received a lot of interest in general.";

$LNG->ALERT_ORPHANED_IDEA = "Orphaned idea";
$LNG->ALERT_HINT_ORPHANED_IDEA = "This idea post is receiving much less attention than its siblings.";

$LNG->ALERT_EMERGING_WINNER = "Dominant idea";
$LNG->ALERT_HINT_EMERGING_WINNER = "One idea has predominance of community support (for a given issue).";

$LNG->ALERT_CONTENTIOUS_ISSUE = "Contentious issue";
$LNG->ALERT_HINT_CONTENTIOUS_ISSUE = "An issue with ideas that the community is strongly divided over: balkanization, polarization.";

$LNG->ALERT_INCONSISTENT_SUPPORT = "Inconsistently supported idea";
$LNG->ALERT_HINT_INCONSISTENT_SUPPORT = "An idea where my support for the idea and it's underlying arguments are inconsistent.";

$LNG->ALERT_MATURE_ISSUE = 'Mature issue';
$LNG->ALERT_HINT_MATURE_ISSUE = 'Issue has  >= 3 ideas with at least one argument each';

$LNG->ALERT_IGNORED_POST = 'Ignored post';
$LNG->ALERT_HINT_IGNORED_POST = 'Post has not been seen by anyone but original author';

$LNG->ALERT_USER_GONE_INACTIVE = 'Users one inactive';
$LNG->ALERT_HINT_USER_GONE_INACTIVE = 'Users who were initially active, but stopped';

$LNG->ALERT_CONTROVERSIAL_IDEA = 'Controversial idea';
$LNG->ALERT_HINT_CONTROVERSIAL_IDEA = 'The community has widely divergent opinions (as reflected by their voting) of whether an idea is a good one or not.';

$LNG->ALERT_IMMATURE_ISSUE = "Immature issue";
$LNG->ALERT_HINT_IMMATURE_ISSUE = 'Issue has &lt; 3 ideas with no arguments';

$LNG->ALERT_WELL_EVALUATED_IDEA = "Well evaluated idea";
$LNG->ALERT_HINT_WELL_EVALUATED_IDEA = "Idea has several pros and cons, including some rebuttals";

$LNG->ALERT_POORLY_EVALUATED_IDEA = "Poorly evaluated idea";
$LNG->ALERT_HINT_POORLY_EVALUATED_IDEA = "Idea has few pros and cons, and no rebuttals";

$LNG->ALERT_RATING_IGNORED_ARGUMENT = 'Rating ignored argument';
$LNG->ALERT_HINT_RATING_IGNORED_ARGUMENT = 'Identifies relevant arguments that the user did not view before rating a post.';
?>
