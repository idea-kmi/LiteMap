<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015 - 2024 The Open University UK                            *
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

$HUB_SQL->DATAMODEL_CONNECTION_SELECT = "SELECT * FROM Triple WHERE TripleID=?";
$HUB_SQL->DATAMODEL_CONNECTION_SELECT_GROUP = "SELECT GroupID FROM TripleGroup tg WHERE tg.TripleID=?";
$HUB_SQL->DATAMODEL_CONNECTION_SELECT_TAGS = "SELECT u.TagID FROM TagTriple ut INNER JOIN Tag u ON u.TagID = ut.TagID WHERE ut.TripleID=? ORDER BY Name ASC";

$HUB_SQL->DATAMODEL_CONNECTION_STATUS_UPDATE = "UPDATE Triple SET CurrentStatus=?, ModificationDate=? WHERE TripleID=?";

$HUB_SQL->DATAMODEL_CONNECTION_SELECT_VOTES_POS = "SELECT count(VoteType) as Positive from Voting where ItemID=? AND VoteType='Y'";
$HUB_SQL->DATAMODEL_CONNECTION_SELECT_VOTES_NEG = "SELECT count(VoteType) as Negative from Voting where ItemID=? AND VoteType='N'";
$HUB_SQL->DATAMODEL_CONNECTION_SELECT_VOTETYPE = "SELECT VoteType FROM Voting WHERE UserID=? AND ItemID=?";
$HUB_SQL->DATAMODEL_CONNECTION_SELECT_CHECK = "SELECT TripleID, CreationDate from Triple where UserID=? and LinkTypeID=? and FromID=? and ToID=? and FromContextTypeID=? and ToContextTypeID=?";
$HUB_SQL->DATAMODEL_CONNECTION_INSERT = "INSERT into Triple (TripleID, UserID, CreationDate, ModificationDate, LinkTypeID, FromID, ToID, FromContextTypeID, ToContextTypeID, FromLabel, ToLabel, Private, Description)
                        				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_CONNECTION_UPDATE_ALL = "UPDATE Triple set
											ModificationDate=?,
											ToLabel=?,
											FromLabel=?,
											LinkTypeID=?,
											FromID=?,
											ToID=?,
											FromContextTypeID=?,
											ToContextTypeID=?,
											Private =?,
											Description=?
											where TripleID=? and UserID=?";

$HUB_SQL->DATAMODEL_CONNECTION_UPDATE_DESC = "UPDATE Triple set
											ModificationDate=?,
											Description=?
											where TripleID=? and UserID=?";


$HUB_SQL->DATAMODEL_CONNECTION_UPDATE_FROM_ROLES = 'Update Triple t set t.FromContextTypeID=(Select nt.NodeTypeID from NodeType nt Where nt.UserID=t.UserID AND nt.Name=?) Where FromID=?';
$HUB_SQL->DATAMODEL_CONNECTION_UPDATE_TO_ROLES = 'Update Triple t set t.ToContextTypeID=(Select nt.NodeTypeID from NodeType nt Where nt.UserID=t.UserID AND nt.Name=?) Where ToID=?';

$HUB_SQL->DATAMODEL_CONNECTION_DELETE = "DELETE FROM Triple WHERE TripleID=?";

$HUB_SQL->DATAMODEL_CONNECTION_VOTE_SELECT = "SELECT VoteID FROM Voting WHERE UserID=? AND ItemID=?";
$HUB_SQL->DATAMODEL_CONNECTION_VOTE_INSERT = "INSERT INTO Voting (UserID, ItemID, VoteType, CreationDate, ModificationDate)
											VALUES (?, ?, ?, ?, ?)";
$HUB_SQL->DATAMODEL_CONNECTION_VOTE_UPDATE = "UPDATE Voting SET ModificationDate=?, VoteType=? WHERE UserID=? AND ItemID=?";
$HUB_SQL->DATAMODEL_CONNECTION_VOTE_DELETE = "DELETE FROM Voting WHERE UserID=? AND ItemID=? AND VoteType=?";

$HUB_SQL->DATAMODEL_CONNECTION_GROUP_ADD_CHECK = "SELECT GroupID FROM TripleGroup tg WHERE tg.TripleID=? AND tg.GroupID=?";
$HUB_SQL->DATAMODEL_CONNECTION_GROUP_ADD = "INSERT INTO TripleGroup (TripleID,GroupID,CreationDate)
											VALUES (?, ?, ?)";
$HUB_SQL->DATAMODEL_CONNECTION_GROUP_DELETE = "DELETE FROM TripleGroup WHERE TripleID=? AND GroupID=?";
$HUB_SQL->DATAMODEL_CONNECTION_GROUP_DELETE_ALL = "DELETE FROM TripleGroup WHERE TripleID=?";

$HUB_SQL->DATAMODEL_CONNECTION_TAG_ADD_CHECK = "SELECT TagID from TagTriple where TripleID=? and TagID=? and UserID=?";
$HUB_SQL->DATAMODEL_CONNECTION_TAG_ADD = "INSERT into TagTriple (UserID, TagID, TripleID)
											VALUES (?, ?, ?)";
$HUB_SQL->DATAMODEL_CONNECTION_TAG_DELETE = "DELETE FROM TagTriple WHERE TripleID=? and TagID=? and UserID=?";

$HUB_SQL->DATAMODEL_CONNECTION_PRIVACY_UPDATE = "UPDATE Triple SET Private=?, ModificationDate=? WHERE TripleID=?";

$HUB_SQL->DATAMODEL_CONNECTION_CAN_VIEW = "SELECT t.TripleID FROM Triple t
											WHERE t.TripleID = ? AND
											((t.Private = 'N') OR (t.UserID = ?) OR
											   (t.TripleID IN (SELECT tg.TripleID FROM TripleGroup tg
															 INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
															  WHERE ug.UserID = ?)))
											AND FromID IN (SELECT t.NodeID FROM Node t
															WHERE ((t.Private = 'N') OR (t.UserID = ?) OR
															   (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
																		   INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
																			WHERE ug.UserID = ?)))
															)
											AND ToID IN (SELECT t.NodeID FROM Node t
															WHERE ((t.Private = 'N') OR (t.UserID = ?) OR
															   (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
																		   INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
																			WHERE ug.UserID = ?))))";

$HUB_SQL->DATAMODEL_CONNECTION_CAN_EDIT = "SELECT t.TripleID FROM Triple t WHERE t.UserID = ? AND t.TripleID=?";
$HUB_SQL->DATAMODEL_CONNECTION_CAN_DELETE = "SELECT t.TripleID FROM Triple t WHERE t.UserID = ? AND t.TripleID=?";
?>