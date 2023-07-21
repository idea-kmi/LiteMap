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
 * languagecore.php
 *
 * Michelle Bachler (KMi)
 *
 * This file holds the default text for the main datamodel node types and link types for the LiteMap.
 * These item are referenced throughout the other Language files to expediate the ability to change central
 * terms quickly.
 */

/** Singular **/
$LNG->ISSUE_NAME = "Issue";
$LNG->ISSUE_NAME_SHORT = "Issue";
$LNG->SOLUTION_NAME = "Idea";
$LNG->SOLUTION_NAME_SHORT = "Idea";
$LNG->ARGUMENT_NAME = "Argument";
$LNG->ARGUMENT_NAME_SHORT = "Argument";
$LNG->PRO_NAME = "Supporting Argument";
$LNG->PRO_NAME_SHORT = "Supporting Argument";
$LNG->CON_NAME = "Counter Argument";
$LNG->CON_NAME_SHORT = "Counter Argument";
$LNG->CHAT_NAME = "Chat";
$LNG->USER_NAME = "User";
$LNG->GROUP_NAME = "Group";
$LNG->NEWS_NAME = "News article";
$LNG->RESOURCE_NAME = "Url";
$LNG->RESOURCE_NAME_SHORT = "Url";
$LNG->MAP_NAME = "Map";
$LNG->MAP_NAME_SHORT = "Map";
$LNG->CHALLENGE_NAME = "Map Topic";
$LNG->CHALLENGE_NAME_SHORT = "Topic";
$LNG->FOLLOWER_NAME = "Follower";
$LNG->VOTE_NAME = "Vote";
$LNG->COMMENT_NAME = "Note";
$LNG->COMMENT_NAME_SHORT = "Note";
$LNG->DEBATE_NAME = "Conversation";

/** Plural **/
$LNG->ISSUES_NAME = "Issues";
$LNG->ISSUES_NAME_SHORT = "Issues";
$LNG->SOLUTIONS_NAME = "Ideas";
$LNG->SOLUTIONS_NAME_SHORT = "Ideas";
$LNG->ARGUMENTS_NAME = "Arguments";
$LNG->ARGUMENTS_NAME_SHORT = "Arguments";
$LNG->CHATS_NAME = "Chats";
$LNG->PROS_NAME = "Supporting Arguments";
$LNG->PROS_NAME_SHORT = "Supporting Arguments";
$LNG->CONS_NAME = "Counter Arguments";
$LNG->CONS_NAME_SHORT = "Counter Arguments";
$LNG->USERS_NAME = "Users";
$LNG->GROUPS_NAME = "Groups";
$LNG->NEWSS_NAME = "News";
$LNG->RESOURCES_NAME = "Urls";
$LNG->RESOURCES_NAME_SHORT = "Urls";
$LNG->MAPS_NAME = "Maps";
$LNG->MAPS_NAME_SHORT = "Maps";
$LNG->CHALLENGES_NAME = "Map Topics";
$LNG->CHALLENGES_NAME_SHORT = "Topics";
$LNG->FOLLOWERS_NAME = "Followers";
$LNG->VOTES_NAME = "Votes";
$LNG->COMMENTS_NAME = "Notes";
$LNG->COMMENTS_NAME_SHORT = "Notes";
$LNG->DEBATES_NAME = "Conversations";

/** Link Type Name **/
$LNG->LINK_ISSUE_CHALLENGE = 'is related to';
$LNG->LINK_SOLUTION_ISSUE = 'responds to';
$LNG->LINK_ISSUE_SOLUTION = 'raised by';
$LNG->LINK_COMMENT_NODE = 'is related to';
$LNG->LINK_PRO_SOLUTION = 'supports';
$LNG->LINK_CON_SOLUTION = 'challenges';
$LNG->LINK_ISSUE_ISSUE = 'raised by';
$LNG->LINK_SOLUTION_SOLUTION = 'is part of';
$LNG->LINK_NODE_SEE_ALSO = 'see also';
$LNG->LINK_IDEA_NODE = 'is related to';
$LNG->LINK_COMMENT_BUILT_FROM = 'built from';
?>