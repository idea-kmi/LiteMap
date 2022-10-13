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

/** Get Connections By Path By Depth AND / OR **/

$HUB_SQL->UTILLIB_NODE_NAME_BY_NODEID = "SELECT Name from Node where NodeID=?";


/** Search Network Connections **/

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_SELECT = "SELECT t.* FROM Triple t
						INNER JOIN LinkType lt ON lt.LinkTypeID = t.LinkTypeID
						INNER JOIN LinkTypeGrouping ltgg ON ltgg.LinkTypeID = lt.LinkTypeID WHERE ";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_FROM_PART1 = "( t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_FROM_PART2 = ")))";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_TO_PART1 = "( t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TYPES_TO_PART2 = ")))";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART1 = "t.FromLabel IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROM_PART2 = ")";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART1 = "t.ToLabel IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TO_PART2 = ")";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART1 = "t.FromID IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_FROMID_PART2 = ")";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART1 = "t.ToID IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_NODE_TOID_PART2 = ")";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKGROUP = "ltg.Label=?";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKLABEL_PART1 = "lt.Label IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_LINKLABEL_PART2 = ")";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_ORDER_BY = " order by t.CreationDate ASC";


/** Search Network Connections By Depth AND **/

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_SELECT = "SELECT t.* FROM Triple t
						INNER JOIN LinkType lt ON lt.LinkTypeID = t.LinkTypeID
						INNER JOIN LinkTypeGrouping ltgg ON ltgg.LinkTypeID = lt.LinkTypeID
            			INNER JOIN LinkTypeGroup ltg ON ltgg.LinkTypeGroupID = ltg.LinkTypeGroupID WHERE ";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_TO_LABEL = "t.ToLabel = ?";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_FROM_LABEL = "t.FromLabel = ?";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_TO_ID = "t.ToID = ?";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_FROM_ID = "t.FromID = ?";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ORDER_BY = " order by t.CreationDate DESC";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_TO_PART1 = "t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_TO_PART2 = "))";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_FROM_PART1 = "t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_FROM_PART2 = "))";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART1 = "( ( (t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART2 = "))) AND (t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART3 = "))) ) OR ( (t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART4 = "))) AND (t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_LABELMATCH_PART5 = "))) ) )";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_ONE_PART1 = "( ( (t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_ONE_PART2 = "))) AND (t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name=?)) ) OR ( (t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_ONE_PART3 = "))) AND (t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name=?)) ))";

$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART1 = "( ( (t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART2 = "))) AND (t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART3 = "))) ) OR ( (t.ToContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART4 = "))) AND (t.FromContextTypeID IN (SELECT nt.NodeTypeID from NodeType nt WHERE nt.Name IN (";
$HUB_SQL->UTILLIB_NETWORK_CONNECTIONS_BY_DEPTH_ROLE_BOTH_PART5 = "))) ) )";

/** Get NodeType IDs from NodeType Names **/
$HUB_SQL->UTILLIB_NODETYPE_IDS_FROM_NAMES_PART1 = "SELECT NodeTypeID from NodeType WHERE Name IN (";
$HUB_SQL->UTILLIB_NODETYPE_IDS_FROM_NAMES_PART2 = ") ";

/** Get LinkType IDs from LinkType Names **/
$HUB_SQL->UTILLIB_LINKTYPE_IDS_FROM_NAMES_PART1 = "SELECT LinkTypeID from LinkType WHERE Label IN (";
$HUB_SQL->UTILLIB_LINKTYPE_IDS_FROM_NAMES_PART2 = ") ";

/** Get LinkType IDs from LinkType Group Name **/
$HUB_SQL->UTILLIB_LINKTYPE_IDS_FROM_GROUP = "SELECT LinkTypeID from LinkTypeGrouping WHERE LinkTypeGroupID IN (SELECT LinkTypeGroupID from LinkTypeGroup WHERE Label=?) ";


/** Get Tags For Cloud **/

$HUB_SQL->UTILLIB_TAGS_FOR_CLOUD = "SELECT alltags.Name, count(alltags.Name) as UseCount FROM (
									(SELECT t.Name as Name From Tag t RIGHT JOIN TagNode tn ON t.TagID = tn.TagID
									right join Node on tn.NodeID = Node.NodeID where Node.Private = 'N')
									) as alltags group by alltags.Name";

$HUB_SQL->UTILLIB_TAGS_FOR_CLOUD_ORDER_BY = "order by UseCount DESC";


/** Get User Tags For Cloud **/
$HUB_SQL->UTILLIB_USER_TAGS_FOR_CLOUD = "SELECT alltags.Name, count(alltags.Name) as UseCount FROM (
										SELECT t.Name as Name From Tag t RIGHT JOIN TagNode tn ON t.TagID = tn.TagID Where tn.UserID=?
										UNION ALL
										SELECT t.Name as Name From Tag t RIGHT JOIN TagTriple tt ON t.TagID = tt.TagID Where tt.UserID=?
										UNION ALL
										SELECT t.Name as Name From Tag t RIGHT JOIN TagUsers tu ON t.TagID = tu.TagID Where tu.UserID=?
										UNION ALL
										SELECT t.Name as Name From Tag t RIGHT JOIN TagURL tl ON t.TagID = tl.TagID Where tl.UserID=?
										) as alltags
										group by alltags.Name order by UseCount DESC";


/** Get Group Tags For Cloud **/
$HUB_SQL->UTILLIB_GROUP_TAGS_FOR_CLOUD = "SELECT alltags.Name, count(alltags.Name) as UseCount FROM (
										SELECT t.Name as Name From Tag t RIGHT JOIN TagNode tn ON t.TagID = tn.TagID
										RIGHT JOIN Node ON tn.NodeID = Node.NodeID
										WHERE tn.UserID IN (Select UserID from UserGroup where GroupID=?)
										AND Node.NodeID IN (Select NodeID FROM NodeGroup WHERE GroupID=?)
										UNION ALL
										SELECT t.Name as Name From Tag t RIGHT JOIN TagTriple tt ON t.TagID = tt.TagID
										RIGHT JOIN Triple ON tt.TripleID = Triple.TripleID
										WHERE tt.UserID IN (Select UserID from UserGroup where GroupID=?)
										AND Triple.TripleID IN (Select TripleID FROM TripleGroup WHERE GroupID=?)
										UNION ALL
										SELECT t.Name as Name From Tag t RIGHT JOIN TagUsers tu ON t.TagID = tu.TagID
										WHERE tu.UserID IN (Select UserID from UserGroup where GroupID=?)
										UNION ALL
										SELECT t.Name as Name From Tag t RIGHT JOIN TagURL tl ON t.TagID = tl.TagID
										RIGHT JOIN URL ON tl.URLID = URL.URLID
										WHERE tl.UserID IN (Select UserID from UserGroup where GroupID=?)
										AND URL.URLID IN (Select URLID FROM URLGroup WHERE GroupID=?)) as alltags
										group by alltags.Name order by UseCount DESC";

/** Get ALL Node Activity **/

$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART1 = "Select ItemID, UserID, Type, ModificationDate, ChangeType, XML from (";

$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART2_BRACKET = "(";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART2 = "SELECT DISTINCT a.NodeID as ItemID, a.UserID, 'Node' as Type, a.ModificationDate, a.ChangeType, a.NodeXML as XML
    									FROM AuditNode a WHERE a.NodeID=?";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MOD_DATE_FROM = " AND a.ModificationDate >= ?";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_MOD_DATE_TO = " AND a.ModificationDate < ?";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_CREATE_DATE_FOLLOWING_FROM = " AND a.CreationDate >= ?";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_CREATE_DATE_FOLLOWING_TO = " AND a.CreationDate < ?";

$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART3_UNION = ") UNION (";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART3 = "SELECT DISTINCT a.TripleID as ItemID, a.UserID, 'Connection' as Type, a.ModificationDate,
										a.ChangeType, a.TripleXML as XML
										FROM AuditTriple a
										LEFT JOIN Triple t ON t.TripleID = a.TripleID
										WHERE (a.FromID=? OR a.ToID=?) AND a.ChangeType <> 'edit'";

$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART4_UNION = ") UNION (";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART4 = "SELECT DISTINCT a.ItemID as ItemID, a.UserID, 'Vote' as Type, a.ModificationDate,
										a.ChangeType as ChangeType, a.VoteType as XML
										FROM AuditVoting a WHERE a.ItemID=?";

$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART5_UNION = ") UNION (";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART5 = "SELECT DISTINCT a.ItemID as ItemID, a.UserID, 'Follow' as Type, a.CreationDate as ModificationDate,
										'' as ChangeType, '' as XML
										FROM Following a WHERE a.ItemID=?";

$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART6_UNION = ") UNION (";
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART6 = "SELECT DISTINCT a.NodeID as ItemID, a.UserID, 'View' as Type, a.ModificationDate,
										ViewType as ChangeType, '' as XML
										FROM AuditNodeView a WHERE a.NodeID=?";

$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_PART7 = ")) as AllActivity order by AllActivity.ModificationDate DESC";

// for if called as individual statements
$HUB_SQL->UTILLIB_ALL_NODE_ACTIVITY_ORDERBY_MODDATE = " order by ModificationDate DESC";

/** Get Node Activity **/

$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART1 = "Select DISTINCT ItemID, UserID, Type, ModificationDate, ChangeType, XML from (";

$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART2_BRACKET = "(";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART2 = "SELECT a.NodeID as ItemID, a.UserID, 'Node' as Type, a.ModificationDate, a.ChangeType, a.NodeXML as XML
    									FROM AuditNode a WHERE a.NodeID=? AND a.ChangeType <> 'delete'";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_MODE_DATE = " AND a.ModificationDate >= ?";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_MODE_DATE_FOLLOWING = " AND a.CreationDate >= ?";

$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART3_UNION = ") UNION (";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART3 = "SELECT a.TripleID as ItemID, a.UserID, 'Connection' as Type, a.ModificationDate,
										a.ChangeType, a.TripleXML as XML
										FROM AuditTriple a
										LEFT JOIN Triple t ON t.TripleID = a.TripleID
										WHERE (a.FromID=? OR a.ToID=?) AND a.ChangeType <> 'edit'";

$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART4_UNION = ") UNION (";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART4 = "SELECT a.ItemID as ItemID, a.UserID, 'Vote' as Type, a.ModificationDate,
										a.ChangeType as ChangeType, a.VoteType as XML
										FROM AuditVoting a WHERE a.ItemID=?";

$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART5_UNION = ") UNION (";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART5 = "SELECT a.ItemID as ItemID, a.UserID, 'Follow' as Type, a.CreationDate as ModificationDate,
										'' as ChangeType, '' as XML
										FROM Following a WHERE a.ItemID=?";

$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART6_UNION = ") UNION (";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART6 = "SELECT a.NodeID as ItemID, a.UserID, 'View' as Type, a.ModificationDate,
										ViewType as ChangeType, '' as XML
										FROM AuditNodeView a WHERE a.NodeID=?";

$HUB_SQL->UTILLIB_NODE_ACTIVITY_PART7 = ")) as AllActivity order by AllActivity.ModificationDate DESC";

// for if called as individual statements
$HUB_SQL->UTILLIB_NODE_ACTIVITY_ORDERBY_MODDATE = " order by ModificationDate DESC";

/** Get User Activity **/
$HUB_SQL->UTILLIB_USER_ACTIVITY_PART1 = "Select DISTINCT ItemID, UserID, Type, ModificationDate, ChangeType, XML from (";
$HUB_SQL->UTILLIB_USER_ACTIVITY_PART2_BRACKET = "(";
$HUB_SQL->UTILLIB_USER_ACTIVITY_PART2 = "SELECT a.NodeID as ItemID, a.UserID, 'Node' as Type, a.ModificationDate,
											a.ChangeType, a.NodeXML as XML FROM AuditNode a WHERE a.UserID=? AND a.ChangeType <> 'delete'";

$HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE = " AND a.ModificationDate >= ?";
$HUB_SQL->UTILLIB_USER_ACTIVITY_MODE_DATE_FOLLOWING = " AND a.CreationDate >= ?";

$HUB_SQL->UTILLIB_USER_ACTIVITY_PART3_UNION = ") UNION (";
$HUB_SQL->UTILLIB_USER_ACTIVITY_PART3 = "SELECT a.TripleID as ItemID, a.UserID, 'Connection' as Type,
												a.ModificationDate, a.ChangeType, a.TripleXML as XML
												FROM AuditTriple a
												LEFT JOIN Triple t ON t.TripleID = a.TripleID
												WHERE a.UserID=? AND a.ChangeType <> 'edit'";

$HUB_SQL->UTILLIB_USER_ACTIVITY_PART4_UNION = ") UNION (";
$HUB_SQL->UTILLIB_USER_ACTIVITY_PART4 = "SELECT a.ItemID as ItemID, a.UserID, 'Vote' as Type, a.ModificationDate,
												a.ChangeType as ChangeType, a.VoteType as XML
												FROM AuditVoting a WHERE a.UserID=?";

$HUB_SQL->UTILLIB_USER_ACTIVITY_PART5_UNION = ") UNION (";
$HUB_SQL->UTILLIB_USER_ACTIVITY_PART5 = "SELECT a.ItemID as ItemID, a.UserID, 'Follow' as Type,
												a.CreationDate as ModificationDate, '' as ChangeType, '' as XML
												FROM Following a WHERE a.UserID=?";

$HUB_SQL->UTILLIB_USER_ACTIVITY_PART6_UNION = ") UNION (";
$HUB_SQL->UTILLIB_USER_ACTIVITY_PART6 = "SELECT a.NodeID as ItemID, a.UserID, 'View' as Type, a.ModificationDate,
												ViewType as ChangeType, '' as XML
												FROM AuditNodeView a WHERE a.UserID=?";

$HUB_SQL->UTILLIB_USER_ACTIVITY_PART7 = ")) as AllActivity order by AllActivity.ModificationDate DESC";

// for if called as individual statements
$HUB_SQL->UTILLIB_USER_ACTIVITY_ORDERBY_MODDATE = " order by ModificationDate DESC";


/** Get Activity date ranges **/
$HUB_SQL->UTILLIB_NODE_ACTIVITY_MINMAX_AUDIT_NODEVIEW = "SELECT MAX(`ModificationDate`) as max, MIN(`ModificationDate`) as min FROM AuditNodeView";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_MINMAX_AUDIT_VOTING = "SELECT MAX(`ModificationDate`)as max, MIN(`ModificationDate`) as min FROM AuditVoting";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_MINMAX_AUDIT_TRIPLE = "SELECT MAX(`ModificationDate`) as max, MIN(`ModificationDate`) as min FROM AuditTriple";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_MINMAX_AUDIT_NODE = "SELECT MAX(`ModificationDate`) as max, MIN(`ModificationDate`) as min FROM AuditNode";
$HUB_SQL->UTILLIB_NODE_ACTIVITY_MINMAX_AUDIT_FOLLOWING = "SELECT MAX(`CreationDate`) as max, MIN(`CreationDate`) as min FROM Following";


/** Get Countries For Cloud By Type **/

$HUB_SQL->UTILLIB_COUNTRIES_BY_TYPE_PART1 = "SELECT count(Node.NodeID) as UseCount, Node.LocationCountry as Country from Node
											WHERE Node.LocationCountry <> '' AND NodeTypeID IN (";
$HUB_SQL->UTILLIB_COUNTRIES_BY_TYPE_PART2 = ") AND Node.Private='N' group by Node.LocationCountry";
$HUB_SQL->UTILLIB_COUNTRIES_BY_TYPE_PART3 = "order by Country";


/** Get Countries For Cloud By Users **/


$HUB_SQL->UTILLIB_COUNTRIES_BY_USER_PART1 = "SELECT count(Users.UserID) as UseCount, Users.LocationCountry as Country from Users
										WHERE Users.LocationCountry <> ''
    									group by Users.LocationCountry ";
$HUB_SQL->UTILLIB_COUNTRIES_BY_USER_PART2 = "order by Country";


/** MOVED FROM API **/

/** Get Nodes By DOI **/

$HUB_SQL->UTILLIB_NODES_BY_DOI_SELECT = $HUB_SQL->APILIB_NODES_SELECT_START.
											"INNER JOIN URLNode ut ON t.NodeID = ut.NodeID
								            INNER JOIN URL u ON u.URLID = ut.URLID ";


$HUB_SQL->UTILLIB_NODES_BY_DOI_FILTER = "u.AdditionalIdentifier=?";


/** Get Nodes By Additional Identifier **/

$HUB_SQL->UTILLIB_NODES_BY_ADDITIONAL_IDENTIFIER = "t.AdditionalIdentifier=?";


/** Get Nodes By Status **/

$HUB_SQL->UTILLIB_NODES_BY_STATUS = $HUB_SQL->APILIB_NODES_SELECT_START."WHERE t.CurrentStatus=?";


/** Get Users By Status **/

$HUB_SQL->UTILLIB_USERS_BY_STATUS = "SELECT DISTINCT t.UserID FROM Users t WHERE t.CurrentStatus=?";


/** Get Search Query String **/

$HUB_SQL->UTILLIB_SEARCH_URL_LIKE = "u.URL".$HUB_SQL->SEARCH_LIKE_START;
$HUB_SQL->UTILLIB_SEARCH_NAME_LIKE = "t.Name".$HUB_SQL->SEARCH_LIKE_START;
$HUB_SQL->UTILLIB_SEARCH_DESC_LIKE = "t.Description".$HUB_SQL->SEARCH_LIKE_START;
$HUB_SQL->UTILLIB_SEARCH_CLIP_LIKE = "r.Clip".$HUB_SQL->SEARCH_LIKE_START;
$HUB_SQL->UTILLIB_SEARCH_TAG_LIKE = "u.Name".$HUB_SQL->SEARCH_LIKE_START;


/** Get User Node Type Creation Counts **/

$HUB_SQL->UTILLIB_USER_NODETYPE_CREATION_COUNTS = "SELECT NodeType.Name, count(NodeID) AS num
								FROM Node LEFT JOIN NodeType on Node.NodeTypeID = NodeType.NodeTypeID
								WHERE Node.UserID=?
								GROUP BY NodeType.Name ORDER BY num DESC";


/** Gt Users Being Followed By Me **/

$HUB_SQL->UTILLIB_USERS_FOLLOWED_BY_USER = "SELECT Users.UserID, Users.Name
								FROM Users LEFT JOIN Following on Users.UserID = Following.ItemID
								WHERE Following.UserID=? AND Users.IsGroup = 'N'
								ORDER BY Users.Name";


/** Get Items Being Followed By Me **/

$HUB_SQL->UTILLIB_ITEMS_FOLLOWED_BY_USER = "SELECT NodeType.Name as NodeType, Node.Name as Name, Node.NodeID, Node.UserID
								FROM Node LEFT JOIN NodeType on Node.NodeTypeID = NodeType.NodeTypeID
								LEFT JOIN Following on Node.NodeID = Following.ItemID
								WHERE Following.UserID=?
								ORDER BY NodeType, Name";


/** Get Follow Email Users **/

$HUB_SQL->UTILLIB_FOLLOW_EMAIL_USERS = "SELECT DISTINCT t.UserID FROM Users t
										WHERE t.CurrentStatus = 0 AND t.UserID <> ?
										AND t.IsGroup='N' AND FollowSendEmail='Y'
										AND FollowRunInterval=?";


/** Get recent activity email users **/

$HUB_SQL->UTILLIB_RECENT_ACTIVITY_EMAIL_USERS = "SELECT DISTINCT t.UserID FROM Users t
								 					WHERE t.CurrentStatus = 0 AND t.UserID <> ?
								 					AND t.IsGroup='N' AND RecentActivitiesEmail='Y'";


/** Admin delete user **/

$HUB_SQL->UTILLIB_DELETE_USER = "DELETE FROM Users WHERE UserID=?";


/** Admin Create LinkType */

$HUB_SQL->UTILLIB_INSERT_LINKTYPE = "INSERT INTO LinkType (LinkTypeID,UserID,Label,CreationDate)
								VALUES (?,?,?,?)";
$HUB_SQL->UTILLIB_INSERT_LINKTYPE_GROUPING = "INSERT INTO LinkTypeGrouping (LinkTypeGroupID, LinkTypeID, UserID, CreationDate)
								VALUES (?,?,?,?)";


/** Admin Create NodeType **/

$HUB_SQL->UTILLIB_INSERT_NODETYPE = "INSERT INTO NodeType (NodeTypeID,UserID,Name,CreationDate,Image)
									VALUES (?,?,?,?,?)";
$HUB_SQL->UTILLIB_INSERT_NODETYPE_GROUPING = "INSERT INTO NodeTypeGrouping (NodeTypeGroupID, NodeTypeID, UserID, CreationDate)
									VALUES (?,?,?,?)";

/** Create user node **/

$HUB_SQL->UTILLIB_USER_NODE = "INSERT INTO Node (NodeID,UserID,CreationDate,ModificationDate,Name,Private,NodeTypeID,CurrentStatus,CreatedFrom,AdditionalIdentifier) VALUES (?,?,?,?,?,?,?,?,?)";

/** User Obfuscation **/

$HUB_SQL->DATAMODEL_UTIL_ADD_OBFUSCATION = "INSERT INTO UsersObfuscation(ObfuscationID,ObfuscationKey,ObfuscationIV,DataURL,DataID,CreationDate) VALUES (?,?,?,?,?,?)";
$HUB_SQL->DATAMODEL_UTIL_ADD_OBFUSCATION_USERS = "Update UsersObfuscation set Users=?,SessionID=?,IPAddress=?,Agent=?,ModificationDate=? where DataID=?";
$HUB_SQL->DATAMODEL_UTIL_GET_OBFUSCATION_KEY_DATAID = "Select ObfuscationKey,ObfuscationIV from UsersObfuscation where DataID=? AND CurrentStatus=0";
$HUB_SQL->DATAMODEL_UTIL_GET_OBFUSCATION_KEY = "Select ObfuscationKey,ObfuscationIV from UsersObfuscation where ObfuscationID=? AND CurrentStatus=0";
$HUB_SQL->DATAMODEL_UTIL_GET_OBFUSCATION_USERS = "Select Users from UsersObfuscation where ObfuscationID=? AND CurrentStatus=0";
$HUB_SQL->DATAMODEL_UTIL_SET_OBFUSCATION_STATUS = "Update UsersObfuscation set CurrentStatus=? where ObfuscationID=?";

?>
