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

$HUB_SQL->DATAMODEL_NODE_SELECT = "SELECT t.*,
                (SELECT COUNT(FromID) FROM Triple WHERE FromID=t.NodeID)+
                (SELECT COUNT(ToID) FROM Triple WHERE ToID=t.NodeID) AS connectedness
                FROM Node t WHERE t.NodeID=?";

$HUB_SQL->DATAMODEL_NODE_EXTERNAL_CONNECTIONS = "SELECT COUNT(TripleID) AS connectedness  FROM Triple
				WHERE (FromID=? OR ToID=?) AND UserID <> ?";

$HUB_SQL->DATAMODEL_NODE_USER_FOLLOW = "SELECT * FROM Following WHERE UserID=? AND ItemID=?";

$HUB_SQL->DATAMODEL_NODE_VOTES = "SELECT count(VoteType) as VoteCount from Voting where ItemID=? AND VoteType=?";
$HUB_SQL->DATAMODEL_NODE_VOTES_USER = "SELECT VoteType FROM Voting WHERE UserID=? AND ItemID=?";
$HUB_SQL->DATAMODEL_NODE_URLS = "SELECT u.URLID FROM URLNode ut INNER JOIN URL u ON u.URLID = ut.URLID WHERE ut.NodeID=? Order By u.CreationDate ASC";
$HUB_SQL->DATAMODEL_NODE_TAGS = "SELECT u.TagID FROM TagNode ut INNER JOIN Tag u ON u.TagID = ut.TagID WHERE ut.NodeID=? ORDER BY Name ASC";
$HUB_SQL->DATAMODEL_NODE_GROUPS = "SELECT GroupID FROM NodeGroup tg WHERE tg.NodeID=?";

$HUB_SQL->DATAMODEL_NODE_ADD_CHECK = "SELECT NodeID, CreationDate from Node where UserID=? and Name=? and NodeTypeID=?";
$HUB_SQL->DATAMODEL_NODE_ADD = "INSERT into Node (NodeID, UserID, CreationDate, ModificationDate, Name, Description, Private, NodeTypeID, Image, ImageThumbnail)
								VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_NODE_ADD_COMMENT = "INSERT into Node (NodeID, UserID, CreationDate, ModificationDate, Name, Description, Private, NodeTypeID, Image, ImageThumbnail)
								VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_NODE_EDIT_CHECK = "SELECT NodeID, CreationDate from Node where UserID=? and Name=? and NodeTypeID=? AND NodeID <> ?";

$HUB_SQL->DATAMODEL_NODE_EDIT = "update Node set ModificationDate=?, Name=?, Description=?, Private=?, NodeTypeID=?, Image=?, ImageThumbnail=? where NodeID=? and UserID=?";

$HUB_SQL->DATAMODEL_NODE_EDIT_UPDATE_TRIPLE_TO = "UPDATE Triple set ToLabel=? where ToID=?";
$HUB_SQL->DATAMODEL_NODE_EDIT_UPDATE_TRIPLE_FROM = "UPDATE Triple set FromLabel=? where FromID=?";

$HUB_SQL->DATAMODEL_NODE_DELETE = "DELETE FROM Node WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_DELETE_TRIPLE = "SELECT TripleID from Triple where (FromID=? or ToID=?)";
$HUB_SQL->DATAMODEL_NODE_DELETE_URLNODE = "DELETE FROM URLNode WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_DELETE_URLS_CLEAN = "SELECT URLID from URL where URLID Not IN (Select Distinct URLID from URLNode)";

$HUB_SQL->DATAMODEL_NODE_VOTE_CHECK = "SELECT VoteID FROM Voting WHERE UserID=? AND ItemID=?";
$HUB_SQL->DATAMODEL_NODE_VOTE_ADD = "INSERT INTO Voting (UserID, ItemID, VoteType, CreationDate, ModificationDate)
									VALUES (?, ?, ?, ?, ?)";
$HUB_SQL->DATAMODEL_NODE_VOTE_EDIT = "UPDATE Voting SET ModificationDate=?, VoteType=? WHERE UserID=? AND ItemID=?";
$HUB_SQL->DATAMODEL_NODE_VOTE_DELETE = "DELETE FROM Voting WHERE UserID=? AND ItemID=? AND VoteType=?";

$HUB_SQL->DATAMODEL_NODE_URL_ADD_CHECK =  "SELECT URLID, Comments, CreationDate from URLNode where NodeID=? and URLID=? and UserID=?";
$HUB_SQL->DATAMODEL_NODE_URL_ADD = "INSERT into URLNode (UserID, URLID, NodeID, CreationDate, ModificationDate, Comments)
									VALUES (?, ?, ?, ?, ?, ?)";
$HUB_SQL->DATAMODEL_NODE_URL_DELETE = "DELETE FROM URLNode WHERE NodeID=? and URLID=? and UserID=?";

$HUB_SQL->DATAMODEL_NODE_URL_DELETE_ALL = "DELETE FROM URLNode WHERE NodeID=?";

$HUB_SQL->DATAMODEL_NODE_GROUP_ADD_CHECK = "SELECT GroupID FROM NodeGroup tg WHERE tg.NodeID=? AND tg.GroupID=?";
$HUB_SQL->DATAMODEL_NODE_GROUP_ADD = "INSERT INTO NodeGroup (NodeID,GroupID,CreationDate) VALUES (?, ?, ?)";
$HUB_SQL->DATAMODEL_NODE_GROUP_DELETE = "DELETE FROM NodeGroup WHERE NodeID=? AND GroupID=?";
$HUB_SQL->DATAMODEL_NODE_GROUP_DELETE_ALL = "DELETE FROM NodeGroup WHERE NodeID=?";

$HUB_SQL->DATAMODEL_NODE_TAG_ADD_CHECK = "SELECT TagID from TagNode where NodeID=? and TagID=? and UserID=?";
$HUB_SQL->DATAMODEL_NODE_TAG_ADD = "INSERT into TagNode (UserID, TagID, NodeID) values (?, ?, ?)";
$HUB_SQL->DATAMODEL_NODE_TAG_DELETE = "DELETE FROM TagNode WHERE NodeID=? and TagID=? and UserID=?";

$HUB_SQL->DATAMODEL_NODE_PRIVACY_UPDATE = "UPDATE Node SET Private=?, ModificationDate=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_ADDITIONAL_IDENTIFIER_UPDATE = "UPDATE Node SET AdditionalIdentifier=?, ModificationDate=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_STARTDATE_UPDATE = "UPDATE Node SET StartDate=?, ModificationDate=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_ENDDATE_UPDATE = "UPDATE Node SET EndDate=?, ModificationDate=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_LOCATION_UPDATE = "UPDATE Node SET LocationAddress1=?, LocationAddress2=?, LocationPostCode=?, LocationText=?, LocationCountry=?, ModificationDate=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_LATLONG_UPDATE = "UPDATE Node SET LocationLat=?, LocationLng=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_STATUS_UPDATE = "UPDATE Node SET CurrentStatus=?, ModificationDate=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_DEFAULT_USER_NODE_ROLE = "SELECT NodeTypeID FROM NodeType WHERE UserID=? and Name=?";
$HUB_SQL->DATAMODEL_NODE_DEFAULT_USER_NODE_ADD = "INSERT INTO Node (NodeID,UserID,CreationDate,ModificationDate,Name,Private,NodeTypeID,CurrentStatus,CreatedFrom,AdditionalIdentifier)
												VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?)";
$HUB_SQL->DATAMODEL_NODE_IMAGE_UPDATE = "UPDATE Node SET Image=?, ModificationDate=? WHERE NodeID=?";
$HUB_SQL->DATAMODEL_NODE_ROLE_UPDATE = "UPDATE Node SET NodeTypeID=?, ModificationDate=? WHERE NodeID=?";

/** NODE PROPERTIES **/
$HUB_SQL->DATAMODEL_NODE_PROPERTY_LOAD = "SELECT * from NodeProperties Where NodeID=?";
$HUB_SQL->DATAMODEL_NODE_PROPERTY_ADD_CHECK = "SELECT * from NodeProperties where NodeID=? AND Property=?";
$HUB_SQL->DATAMODEL_NODE_PROPERTY_EDIT = "UPDATE NodeProperties set Value=?, ModificationDate=? where NodeID=? AND Property=?";
$HUB_SQL->DATAMODEL_NODE_PROPERTY_ADD = "INSERT into NodeProperties (NodeID,Property,Value,CreationDate, ModificationDate) VALUES (?,?,?,?,?)";
$HUB_SQL->DATAMODEL_NODE_PROPERTY_DELETE = "DELETE from NodeProperties where NodeID=? AND Property=?";

$HUB_SQL->DATAMODEL_NODE_VIEW_COUNT = "SELECT count(NodeID) as ViewCount from AuditNodeView where NodeID=?";

/** NODE PERMISSIONS **/
$HUB_SQL->DATAMODEL_NODE_CAN_VIEW = "SELECT t.NodeID FROM Node t
										WHERE t.NodeID=? AND (
										  (t.Private=?) OR (t.UserID=?) OR
										  (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
												INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
												WHERE tg.NodeID=? AND ug.UserID=?) ))";

$HUB_SQL->DATAMODEL_NODE_CAN_EDIT = "SELECT t.NodeID FROM Node t WHERE t.UserID=? AND t.NodeID=?";
$HUB_SQL->DATAMODEL_NODE_CAN_DELETE = $HUB_SQL->DATAMODEL_NODE_CAN_EDIT;

$HUB_SQL->DATAMODEL_NODE_CONNECTION_USAGE_FROM = "SELECT count(FromID) as nodecount from Triple where FromID=? and UserID=?";
$HUB_SQL->DATAMODEL_NODE_CONNECTION_USAGE_TO = "SELECT count(ToID) as nodecount from Triple where ToID=? and UserID=?";

$HUB_SQL->DATAMODEL_NODE_ENTRY_USAGE = "SELECT count(Name) as nodecount from Node where Name=? and UserID=?";
?>