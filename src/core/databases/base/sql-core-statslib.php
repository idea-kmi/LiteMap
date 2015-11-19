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
 * Statistics Utility library
 * Stats functions
 */

/*** VOTING STATS ***/

$HUB_SQL->STATSLIB_VOTES_SELECT_START = "SELECT
						case 'ItemID' when null then 0 else Count(ot.ItemID) end vote,
						Sum(case when ot.VoteType='Y' then 1 else 0 end) as up,
						Sum(case when ot.VoteType='N' then 1 else 0 end) as down ";

/** Get Total Item Votes  **/

$HUB_SQL->STATSLIB_TOTAL_ITEM_VOTES_SELECT = $HUB_SQL->STATSLIB_VOTES_SELECT_START.
						"FROM (select ItemID, VoteType from Voting Where ItemID in
						(Select NodeID from Node) ) ot ";

/**  Get Total Connection Votes **/

$HUB_SQL->STATSLIB_TOTAL_CONNECTION_VOTES_SELECT = $HUB_SQL->STATSLIB_VOTES_SELECT_START.
						"FROM (select ItemID, VoteType from Voting Where ItemID
						in (Select TripleID from Triple) ) ot ";


/** Get Total Votes **/

$HUB_SQL->STATSLIB_TOTAL_VOTES_SELECT = $HUB_SQL->STATSLIB_VOTES_SELECT_START.
						"FROM (select ItemID, VoteType from Voting Where ItemID
						in (Select TripleID from Triple) or ItemID in
						(Select NodeID from Node)) ot ";

/** Get Total Top Votes **/

$HUB_SQL->STATSLIB_TOTAL_TOP_VOTES = "SELECT ot.NodeID,
						case 'ItemID' when null then 0 else Count(ot.ItemID) end vote,
						Sum(case when VoteA='Y' then 1 else 0 end) as up,
						Sum(case when VoteA='N' then 1 else 0 end) as down,
						Sum(case when VoteB='Y' then 1 else 0 end) as cup,
						Sum(case when VoteB='N' then 1 else 0 end) as cdown
						FROM (select n.NodeID,
						v.ItemID as ItemID, v.VoteType as VoteA, '' as VoteB from Voting v left join Node n
						on v.ItemID = n.NodeID left join NodeType t on n.NodeTypeID=t.NodeTypeID where n.NodeID <> ''
						UNION ALL select n.NodeID,
						v.ItemID as ItemID, '' as VoteA, v.VoteType as VoteB from Voting v left join Triple tr
						on v.ItemID = tr.TripleID left join Node n on tr.FromID = n.NodeID left join NodeType t
						on n.NodeTypeID=t.NodeTypeID where n.NodeID <> '') as ot
						group by ot.NodeID having vote > 0
						order by vote DESC";


/** Get Top Node For Votes **/

$HUB_SQL->STATSLIB_TOP_NODE_FOR_VOTES = "SELECT ot.NodeID,
						case 'ItemID' when null then 0 else Count(ot.ItemID) end vote,
						Sum(case when VoteA='Y' then 1 else 0 end) as up,
						Sum(case when VoteB='Y' then 1 else 0 end) as cup
						From (select n.NodeID,
						v.ItemID as ItemID, v.VoteType as VoteA, '' as VoteB from Voting v left join Node n
						on v.ItemID = n.NodeID left join NodeType t on n.NodeTypeID=t.NodeTypeID where n.NodeID <> '' and v.VoteType='Y'
						UNION ALL select n.NodeID,
						v.ItemID as ItemID, '' as VoteA, v.VoteType as VoteB from Voting v left join Triple tr
						on v.ItemID = tr.TripleID left join Node n on tr.FromID = n.NodeID left join NodeType t
						on n.NodeTypeID=t.NodeTypeID where n.NodeID <> '' and v.VoteType='Y') as ot
						group by ot.NodeID having vote > 0
						order by vote DESC";



/** Get Top NodeAgainst Votes **/

$HUB_SQL->STATSLIB_TOP_NODE_AGAINST_VOTES = "SELECT ot.NodeID,
						case 'ItemID' when null then 0 else Count(ot.ItemID) end vote,
						Sum(case when VoteA='N' then 1 else 0 end) as down,
						Sum(case when VoteB='N' then 1 else 0 end) as cdown
						From (select n.NodeID,
						v.ItemID as ItemID, v.VoteType as VoteA, '' as VoteB from Voting v left join Node n
						on v.ItemID = n.NodeID left join NodeType t on n.NodeTypeID=t.NodeTypeID where n.NodeID <> '' and v.VoteType='N'
						UNION ALL select n.NodeID,
						v.ItemID as ItemID, '' as VoteA, v.VoteType as VoteB from Voting v left join Triple tr
						on v.ItemID = tr.TripleID left join Node n on tr.FromID = n.NodeID left join NodeType t
						on n.NodeTypeID=t.NodeTypeID where n.NodeID <> '' and v.VoteType='N') as ot
						group by ot.NodeID having vote > 0
						order by vote DESC";


/** Get Top Voters **/

$HUB_SQL->STATSLIB_TOP_VOTERS = "SELECT ot.UserID, ot.Name,
						case 'ItemID' when null then 0 else Count(ot.ItemID) end vote,
						Sum(case when ot.VoteType='Y' then 1 else 0 end) as up,
						Sum(case when ot.VoteType='N' then 1 else 0 end) as down
						From (select n.Name, n.UserID, v.ItemID, v.VoteType from Voting v
						left join Users n on n.UserID=v.UserID) ot
						group by UserID having vote > 0 order by vote DESC";


/** Top For Voters **/

$HUB_SQL->STATSLIB_TOP_FOR_VOTERS = "SELECT ot.UserID, ot.Name,
						Sum(case when ot.VoteType='Y' then 1 else 0 end) as vote
						From (select n.Name, n.UserID, v.ItemID, v.VoteType from Voting v
						left join Users n on n.UserID=v.UserID) ot
						group by UserID having vote > 0 order by vote DESC";



/** Top Against Voters **/

$HUB_SQL->STATSLIB_TOP_FOR_VOTERS = "SELECT ot.UserID, ot.Name,
						Sum(case when ot.VoteType='N' then 1 else 0 end) as vote
						From (select n.Name, n.UserID, v.ItemID, v.VoteType from Voting v
						left join Users n on n.UserID=v.UserID) ot
						group by UserID having vote > 0 order by vote DESC";

/** Get All Voting **/

$HUB_SQL->STATSLIB_ALL_VOTING = "SELECT NodeID,
						case 'ItemID' when null then 0 else Count(ItemID) end as vote,
						Sum(case when VoteA='Y' then 1 else 0 end) as up,
						Sum(case when VoteA='N' then 1 else 0 end) as down,
						Sum(case when VoteB='Y' then 1 else 0 end) as cup,
						Sum(case when VoteB='N' then 1 else 0 end) as cdown
						FROM (select n.NodeID, v.ItemID as ItemID,
						v.VoteType as VoteA, '' as VoteB from Voting v left join Node n on v.ItemID = n.NodeID left join NodeType t
						on n.NodeTypeID=t.NodeTypeID where n.NodeID <> ''
						UNION ALL select n.NodeID,
						v.ItemID as ItemID, '' as VoteA, v.VoteType as VoteB from Voting v left join Triple tr
						on v.ItemID = tr.TripleID left join Node n on tr.FromID = n.NodeID left join NodeType t
						on n.NodeTypeID=t.NodeTypeID where n.NodeID <> '') as ot
						group by ot.NodeID having vote > 0";

$HUB_SQL->STATSLIB_ALL_VOTING_ORDER_BY = " order by ";



/*** USER CONTEXT STATS ***/

/** Get Total Votes For User **/

$HUB_SQL->STATSLIB_USER_TOTAL_VOTES = "SELECT
						case 'ItemID' when null then 0 else Count(ot.ItemID) end vote,
						Sum(case when ot.VoteType='Y' then 1 else 0 end) as up,
						Sum(case when ot.VoteType='N' then 1 else 0 end) as down
						From (select ItemID, VoteType from Voting Where ItemID in
						(Select NodeID from Node) AND UserID=?) ot ";



/** Get All Voting For User **/

$HUB_SQL->STATSLIB_USER_ALL_VOTING = "SELECT ot.NodeID,
						case 'ItemID' when null then 0 else Count(ot.ItemID) end vote,
						Sum(case when ot.VoteType='Y' then 1 else 0 end) as up,
						Sum(case when ot.VoteType='N' then 1 else 0 end) as down
						From (select n.Name, n.Description, t.Name as NodeType, n.NodeID, v.ItemID, v.VoteType
						FROM Node n
						left join Voting v on n.NodeID=v.ItemID
						left join NodeType t on n.NodeTypeID=t.NodeTypeID
						Where v.UserID=?) ot
						group by ot.NodeID having vote > 0 ";



/** Get Top Tag For User **/

$HUB_SQL->STATSLIB_USER_TOP_TAG = "SELECT alltags.Name, count(alltags.Name) as UseCount FROM (
						SELECT t.Name as Name From Tag t RIGHT JOIN TagNode tn ON t.TagID = tn.TagID Where tn.UserID=?
						UNION ALL
						SELECT t.Name as Name From Tag t RIGHT JOIN TagTriple tt ON t.TagID = tt.TagID Where tt.UserID=?
						UNION ALL
						SELECT t.Name as Name From Tag t RIGHT JOIN TagUsers tu ON t.TagID = tu.TagID Where tu.UserID=?
						UNION ALL
						SELECT t.Name as Name From Tag t RIGHT JOIN TagURL tl ON t.TagID = tl.TagID Where tl.UserID=?) as alltags
						group by alltags.Name order by UseCount DESC";


/** Get Link Types For User **/

$HUB_SQL->STATSLIB_USER_LINK_TYPES = "SELECT LinkType.Label, Count(TripleID) AS num
						FROM Triple LEFT JOIN LinkType ON Triple.LinkTypeID = LinkType.LinkTypeID
						WHERE  Triple.UserID=?
						GROUP BY Label
						ORDER BY num DESC";


/** Get NodeTypes For User **/

$HUB_SQL->STATSLIB_USER_NODE_TYPES = "SELECT NodeType.Name, count(NodeID) AS num
						FROM Node LEFT JOIN NodeType on Node.NodeTypeID = NodeType.NodeTypeID
						WHERE Node.UserID=?
						GROUP BY NodeType.Name
						ORDER BY num DESC";


/** Get Compared Thinking For User **/

$HUB_SQL->STATSLIB_USER_CONNECTIONS = "SELECT * FROM
						(SELECT Triple.*, Node.UserID as FromUserID
						FROM Triple
						RIGHT JOIN Node ON Triple.FromID = Node.NodeID
						WHERE Triple.UserID=?
						AND ((Triple.Private='N') OR
					   		(TripleID IN (SELECT tg.TripleID FROM TripleGroup tg
						 	INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
						  	WHERE ug.UserID=?)))
						AND FromID IN (SELECT t.NodeID FROM Node t
							WHERE ((t.Private='N') OR (t.UserID=?) OR
								(t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
								INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
								WHERE ug.UserID=?)))
							)
						AND ToID IN (SELECT t.NodeID FROM Node t
							WHERE ((t.Private='N') OR (t.UserID=?) OR
							   (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
								INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
								WHERE ug.UserID=?)))
						)) AS FRED
						LEFT JOIN
						(SELECT Triple.TripleID as TripleID2, Node.UserID AS ToUserID
						FROM Triple
						RIGHT JOIN Node ON Triple.ToID = Node.NodeID
						WHERE  Triple.UserID=? AND ((Triple.Private='N') OR
					   (TripleID IN (SELECT tg.TripleID FROM TripleGroup tg
									 INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
									  WHERE ug.UserID=?)))
						AND FromID IN (SELECT t.NodeID FROM Node t
							WHERE ((t.Private='N') OR (t.UserID=?) OR
							   (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
								INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
								WHERE ug.UserID=?)))
							)
						AND ToID IN (SELECT t.NodeID FROM Node t
							WHERE ((t.Private='N') OR (t.UserID=?) OR
							   (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
								INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
								WHERE ug.UserID=?)))
						)) AS FRED2
						on FRED.TripleID = FRED2.TripleID2 ";

$HUB_SQL->STATSLIB_USER_COMPARED_THINKING = $HUB_SQL->STATSLIB_USER_CONNECTIONS.
											"WHERE (FromUserID=? AND ToUserID <> ?) OR (FromUserID <> ? AND ToUserID=?)";

/** Get Information Brokering For User **/

$HUB_SQL->STATSLIB_USER_INFORMATION_BROKERING = $HUB_SQL->STATSLIB_USER_CONNECTIONS.
												"WHERE (FromUserID <> ? AND ToUserID <> ?)";



/*** GLOBAL STATS ***/

/** Get Most Used Link Type **/
$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_SELECT = "SELECT Distinct Label FROM LinkType Order By Label";

$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART1 = "SELECT Count(TripleID) as num FROM Triple where (FromContextTypeID IN
													(Select NodeTypeID from NodeType where Name in(";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART2 = ")) AND ToContextTypeID IN (Select NodeTypeID from NodeType where Name in(";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART3 = "))) AND LinkTypeID IN (Select LinkTypeID from LinkType where Label=?)";

/** EXTRA JUST FOR GROUPS FILTERING **/
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_PART1_GROUP = "SELECT Count(Triple.TripleID) as num FROM Triple left join TripleGroup on Triple.TripleID = TripleGroup.TripleID where (FromContextTypeID IN
													(Select NodeTypeID from NodeType where Name in(";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_LINKTYPE_SELECT_GROUP_FILTER = " AND TripleGroup.GroupID=?";

/** Get Most Used Node Type **/

$HUB_SQL->STATSLIB_GLOBAL_NODETYPE_SELECT_PART1 = "SELECT NodeTypeID, Name FROM NodeType WHERE Name IN (";
$HUB_SQL->STATSLIB_GLOBAL_NODETYPE_SELECT_PART2 = ") Order By Name";

$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART1 = "SELECT Count(TripleID) as num FROM Triple WHERE (FromContextTypeID IN (Select NodeTypeID from NodeType where Name in(";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART2 = ")) AND ToContextTypeID IN (Select NodeTypeID from NodeType where Name in(";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART3 = "))) AND (FromContextTypeID IN (";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART4 = ") or ToContextTypeID IN (";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART5 = "))";

/** EXTRA JUST FOR GROUPS FILTERING **/
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_PART1_GROUP = "SELECT Count(Triple.TripleID) as num FROM Triple left join TripleGroup on Triple.TripleID=TripleGroup.TripleID WHERE (FromContextTypeID IN (Select NodeTypeID from NodeType where Name in(";
$HUB_SQL->STATSLIB_GLOBAL_MOST_USED_NODETYPE_SELECT_GROUP_FILTER = " AND TripleGroup.GroupID=?";


/** Get Most Connected Node **/
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1 = "SELECT allnodes.ID, Count(node) AS num FROM (SELECT Node.NodeID AS ID, t.FromID AS node FROM Triple t right join Node on t.FromID = Node.NodeID ";
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1b = "WHERE (t.FromContextTypeID IN (Select NodeTypeID from NodeType where Name in(";

/** CHANGE FOR GROUPS FILTERING **/
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1_GROUP = "SELECT allnodes.ID, Count(node) AS num FROM (SELECT Node.NodeID AS ID, t.FromID AS node FROM Triple t right join Node on t.FromID = Node.NodeID left join TripleGroup on t.TripleID=TripleGroup.TripleID ";
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART1b_GROUP = "WHERE TripleGroup.GroupID=? AND (t.FromContextTypeID IN (Select NodeTypeID from NodeType where Name in(";

$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART2 = ")) AND t.ToContextTypeID IN (Select NodeTypeID from NodeType where Name in (";
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART3 = "))) AND ".$HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4 = " UNION ALL SELECT  Node.NodeID AS ID, t.ToID AS node FROM Triple t right join Node on t.ToID = Node.NodeID ";
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4b = "WHERE (t.FromContextTypeID IN (Select NodeTypeID from NodeType where Name in(";

/** CHANGE FOR GROUPS FILTERING **/
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4_GROUP = " UNION ALL SELECT  Node.NodeID AS ID, t.ToID AS node FROM Triple t right join Node on t.ToID = Node.NodeID left join TripleGroup on t.TripleID=TripleGroup.TripleID ";
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART4b_GROUP = "WHERE TripleGroup.GroupID=? AND (t.FromContextTypeID IN (Select NodeTypeID from NodeType where Name in(";

$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART5 = ")) AND t.ToContextTypeID IN (Select NodeTypeID from NodeType where Name in (";
$HUB_SQL->STATSLIB_GLOBAL_MOST_CONNECTED_NODE_PART6 = "))) AND ".$HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS.") AS allnodes Group by allnodes.ID order by num DESC";


/** Get Link Type Usage **/

$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART1 = "SELECT allLinks.Label, ";
$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART2 = " FROM ((SELECT DISTINCT LinkType.Label as Label from LinkType WHERE LinkType.UserID IN ( ";
$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART3 = ") AND LinkType.Label <> '' order by LinkType.Label ASC ) AS allLinks";
$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART4 = " LEFT JOIN (SELECT LinkType.Label as Label, Count(Triple.TripleID) AS ";
$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART5 = " FROM LinkType LEFT JOIN Triple ON Triple.LinkTypeID = LinkType.LinkTypeID WHERE Triple.UserID=? GROUP BY Label) as table";

$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART6 = " on allLinks.Label = table";
$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART7 = ".Label";

/*** CHANGE FOR GROUPS FILTERING **/
$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_PART5_GROUPS = " FROM LinkType LEFT JOIN Triple ON Triple.LinkTypeID=LinkType.LinkTypeID  LEFT JOIN TripleGroup on Triple.TripleID=TripleGroup.TripleID WHERE TripleGroup.GroupID=? AND Triple.UserID=? GROUP BY Label) as table";


$HUB_SQL->STATSLIB_GLOBAL_LINKTYPE_USAGE_SELECT = "Select UserID, Name from Users where UserID IN (";


/** Get Total Users Count **/

$HUB_SQL->STATSLIB_GLOBAL_REGISTERED_USERS_COUNT = "SELECT count(UserID) as num from Users WHERE IsGroup='N' AND UserID <> ?";


/** Get Registered Users **/

$HUB_SQL->STATSLIB_GLOBAL_REGISTERED_USERS = "SELECT * from Users where IsGroup='N' AND UserID <> ?";


/** Get Registered User Count **/

$HUB_SQL->STATSLIB_GLOBAL_REGISTERED_USER_COUNT_DATE = $HUB_SQL->STATSLIB_GLOBAL_REGISTERED_USERS_COUNT." AND CreationDate >= ? AND CreationDate < ?";



/** Get Node Creation Count **/

$HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT = "SELECT count(NodeID) as num FROM Node WHERE CreationDate >= ?";
$HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT_DATE = " AND CreationDate < ?";
$HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT_NODE_TYPE_PART1 = " AND NodeTypeID IN (Select NodeTypeID from NodeType where Name IN (";
$HUB_SQL->STATSLIB_GLOBAL_NODE_CREATION_COUNT_NODE_TYPE_PART2 = "))";


$HUB_SQL->STATSLIB_ALL_CONNECTIONS = "SELECT
					(Select Node.Name from Node where NodeID = Triple.ToID) as ToName,
					(Select NodeType.Name from NodeType where NodeTypeID = Triple.ToContextTypeID) as ToType,
					(Select Users.Name from Node left Join Users on Node.UserID = Users.UserID where NodeID = Triple.ToID ) as ToAuthor,
					(Select Node.Name from Node where NodeID = Triple.FromID) as FromName,
					(Select NodeType.Name from NodeType where NodeTypeID = Triple.FromContextTypeID) as FromType,
					(Select Users.Name from Node left Join Users on Node.UserID = Users.UserID where NodeID = Triple.FromID ) as FromAuthor,
					LinkType.Label as LinkLabel,
					Triple.CreationDate,
					Users.Name as ConnectionAuthor from Triple
					left join Users on Triple.UserID = Users.UserID
					left join LinkType on Triple.LinkTypeID = LinkType.LinkTypeID
					where LinkType.Label <> ?";

?>