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
 * emails.php
 *
 * See Also the mailtemplates subfolder for additional email texts to translate.
 *
 * Michelle Bachler (KMi)
 */

$LNG->WELCOME_REGISTER_OPEN_SUBJECT = "Welcome to the ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_OPEN_BODY = 'Thank you for registering with us.<br><br>For more information about what LiteMap is, why not read our <a href="'.$CFG->homeAddress.'ui/pages/about.php">about page</a>.<br>For help in getting started using the hub why not visit our <a href="'.$CFG->homeAddress.'ui/pages/help.php">help page</a>.<br>Why not start using the <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a> today.';

$LNG->VALIDATE_REGISTER_SUBJECT = "Completing your registration on ".$CFG->SITE_TITLE;

$LNG->WELCOME_REGISTER_REQUEST_SUBJECT = "Registration request for the ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_REQUEST_BODY = 'Thank you for requesting an account on the <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a>.<br>This is to acknowledge that we have received your request.<br>We will attempt to process your request within 24 hours, but at busy times it may take longer.<br>You will receive a further email with your Sign In details, if your request is successful.<br><br>Thanks again for your interest.';
$LNG->WELCOME_REGISTER_REQUEST_BODY_ADMIN = "A new User has requested an account. Please use the Admin area to accept or reject this new User.";

$LNG->WELCOME_REGISTER_CLOSED_SUBJECT = "Registration on the ".$CFG->SITE_TITLE;

$LNG->VALIDATE_GROUP_JOIN_SUBJECT = "Group Join Request from ".$CFG->SITE_TITLE;

/*** EMAIL DIGESTS ***/
$LNG->ADMIN_CRON_FOLLOW_USER_ACTIVITY_MESSAGE = 'There has been activity for';
$LNG->ADMIN_CRON_FOLLOW_SEE_ACTIVITY_LINK = 'See activity';
$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR = 'Activity for';
$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK = 'Explore';
$LNG->ADMIN_CRON_FOLLOW_ON_THE = 'On the';
$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM = 'this item';
$LNG->ADMIN_CRON_FOLLOW_STARTED = 'started following';
$LNG->ADMIN_CRON_FOLLOW_PROMOTED = 'promoted';
$LNG->ADMIN_CRON_FOLLOW_DEMOTED = 'demoted';
$LNG->ADMIN_CRON_FOLLOW_ADDED = 'added';
$LNG->ADMIN_CRON_FOLLOW_EDITED = 'edited';
$LNG->ADMIN_CRON_FOLLOW_ADDED_RESOURCE = 'added the '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_SUPPORTING_EVIDENCE = 'added Supporting '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_COUNTER_EVIDENCE = 'added Counter '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_EVIDENCE = 'associated this with the '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_WITH = 'associated this with the';
$LNG->ADMIN_CRON_FOLLOW_REMOVED = 'removed';
$LNG->ADMIN_CRON_FOLLOW_REMOVED_RESOURCE = 'removed the '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_EVIDENCE = 'removed the '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_ASSOCIATION = 'removed association with';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART1 = 'From';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART2 = 'To';
$LNG->ADMIN_CRON_FOLLOW_HOURLY = 'Hourly';
$LNG->ADMIN_CRON_FOLLOW_HOURLY_TITLE = 'Hourly Activity Report for '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_HOURLY_DIGEST_RUN = 'Hourly Digest for Activites on '.$CFG->SITE_TITLE.' has been Run';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY = 'Weekly';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_TITLE = 'Weekly LiteMap Activity Report';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_DIGEST_RUN = 'Weekly Digest for Activites on '.$CFG->SITE_TITLE.' has been Run';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY = 'Monthly';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_TITLE = 'Monthly LiteMap Activity Report';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_DIGEST_RUN = 'Monthly Digest for Activites on '.$CFG->SITE_TITLE.' has been Run';
$LNG->ADMIN_CRON_FOLLOW_DAILY = 'Daily';
$LNG->ADMIN_CRON_FOLLOW_DAILY_TITLE = 'Daily LiteMap Activity Report';
$LNG->ADMIN_CRON_FOLLOW_DAILY_DIGEST_RUN = 'Daily Digest for Activites on '.$CFG->SITE_TITLE.' has been Run';
$LNG->ADMIN_CRON_FOLLOW_NO_DIGEST = 'No email digest for:';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART1 = 'To stop receiving this email digest please login to the hub and uncheck \'Send email Alert of New Activity\' on your';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART2 = $LNG->HEADER_MY_HUB_LINK.' home page';

$LNG->ADMIN_CRON_RECENT_ACTIVITY_DIGEST_RUN = 'Recent Activite Digest on '.$CFG->SITE_TITLE.' Run';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_NO_DIGEST = 'No recent activity digest for:';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_TITLE = 'LiteMap Recent Activity Report';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_MESSAGE = 'See below for the top 5 most recent items entered for each LiteMap Category.';
?>