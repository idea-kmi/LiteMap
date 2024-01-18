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

$HUB_SQL->DATAMODEL_GROUP_SELECT = "SELECT * FROM Users WHERE Userid =?";

$HUB_SQL->DATAMODEL_GROUP_MEMBERS = "SELECT u.UserID, ug.IsAdmin FROM Users u
									INNER JOIN UserGroup ug ON ug.UserID = u.UserID
									WHERE ug.GroupID=?";

$HUB_SQL->DATAMODEL_GROUP_DEBATECOUNT = "SELECT count(Node.NodeID) as debateCount from Node
									left Join NodeGroup on Node.NodeID = NodeGroup.NodeID
                					WHERE Node.NodeTypeID IN (Select NodeTypeID
                						from NodeType Where Name='Issue') AND NodeGroup.GroupID=?";

$HUB_SQL->DATAMODEL_GROUP_VOTECOUNT_NODE = "SELECT Voting.VoteType from Voting left join Node on Voting.ItemID = Node.NodeID
        							left Join NodeGroup on Voting.ItemID = NodeGroup.NodeID
                					WHERE NodeGroup.GroupID=?";

$HUB_SQL->DATAMODEL_GROUP_VOTECOUNT_CONN = "SELECT VoteType from Voting left Join Triple on Triple.TripleID = Voting.ItemID
									left Join TripleGroup on Voting.ItemID = TripleGroup.TripleID
									WHERE TripleGroup.GroupID=?";

$HUB_SQL->DATAMODEL_GROUP_IS_OPEN_JOINING = "UPDATE Users SET IsOpenJoining=? WHERE UserID=?";

$HUB_SQL->DATAMODEL_GROUP_IS_MEMBER = "SELECT ug.UserID FROM UserGroup ug
                					WHERE ug.GroupID=? AND ug.UserID=?";

$HUB_SQL->DATAMODEL_GROUP_NAME_EXISTS = "SELECT u.UserID FROM Users u
                					INNER JOIN UserGroup ug ON ug.GroupID = u.UserID
                					WHERE u.Name=?";
$HUB_SQL->DATAMODEL_GROUP_NAME_EXISTS_EXTRA = " AND u.UserID <> ?";

$HUB_SQL->DATAMODEL_GROUP_ADD = "INSERT INTO UserGroup (GroupID,UserID,CreationDate,IsAdmin)
									VALUES (?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_GROUP_NODE_DELETE = "DELETE FROM NodeGroup WHERE GroupID=?";
$HUB_SQL->DATAMODEL_GROUP_TRIPLE_DELETE = "DELETE FROM TripleGroup WHERE GroupID=?";
$HUB_SQL->DATAMODEL_GROUP_USER_DELETE = "DELETE FROM UserGroup WHERE GroupID=?";
$HUB_SQL->DATAMODEL_GROUP_DELETE = "DELETE FROM Users WHERE UserID=?";

$HUB_SQL->DATAMODEL_GROUP_MEMBER_ADD_CHECK = "SELECT * FROM UserGroup WHERE UserID=? AND GroupID=?";
$HUB_SQL->DATAMODEL_GROUP_MEMBER_ADD = "INSERT INTO UserGroup (GroupID,UserID,CreationDate,IsAdmin)
									VALUES (?, ?, ?, ?)";
$HUB_SQL->DATAMODEL_GROUP_MEMBER_DELETE = "DELETE FROM UserGroup WHERE GroupID=? AND UserID=?";

$HUB_SQL->DATAMODEL_GROUP_MAKE_ADMIN = "UPDATE UserGroup SET IsAdmin=? WHERE GroupID=? AND UserID=?";
$HUB_SQL->DATAMODEL_GROUP_REMOVE_ADMIN_CHECK = "SELECT GroupID FROM UserGroup WHERE IsAdmin=? AND GroupID=?";
$HUB_SQL->DATAMODEL_GROUP_REMOVE_ADMIN_UPDATE = "UPDATE UserGroup SET IsAdmin=? WHERE GroupID=? AND UserID=?";

$HUB_SQL->DATAMODEL_GROUP_IS_ADMIN = "SELECT t.GroupID FROM UserGroup t WHERE t.GroupID=? AND t.UserID=? AND t.IsAdmin=?";

/*** USER GROUP JOINING TABLE ***/
$HUB_SQL->DATAMODEL_GROUP_JOIN_ADD = "INSERT INTO UserGroupJoin (GroupID,UserID,AdminID,CreationDate,CurrentStatus)
											VALUES (?, ?, ?, ?, ".$CFG->USER_STATUS_UNAUTHORIZED.")";

$HUB_SQL->DATAMODEL_GROUP_JOIN_SELECT_PENDING = "SELECT u.UserID FROM Users u
											INNER JOIN UserGroupJoin ug ON ug.UserID = u.UserID
											WHERE ug.GroupID=? AND ug.CurrentStatus=".$CFG->USER_STATUS_UNAUTHORIZED;

$HUB_SQL->DATAMODEL_GROUP_JOIN_REJECT = "UPDATE UserGroupJoin SET CurrentStatus=".$CFG->USER_STATUS_SUSPENDED.", AdminID=?, ModificationDate=? WHERE GroupID=? AND UserID=?";
$HUB_SQL->DATAMODEL_GROUP_JOIN_ACTIVE = "UPDATE UserGroupJoin SET CurrentStatus=".$CFG->USER_STATUS_ACTIVE.", AdminID=?, ModificationDate=? WHERE GroupID=? AND UserID=?";
$HUB_SQL->DATAMODEL_GROUP_JOIN_REPORT = "UPDATE UserGroupJoin SET CurrentStatus=".$CFG->USER_STATUS_REPORTED.", AdminID=?, ModificationDate=? WHERE GroupID=? AND UserID=?";

$HUB_SQL->DATAMODEL_GROUP_IS_PENDING_MEMBER = "SELECT ugj.UserID FROM UserGroupJoin ugj WHERE ugj.GroupID=? AND ugj.UserID=? AND CurrentStatus=".$CFG->USER_STATUS_UNAUTHORIZED;
$HUB_SQL->DATAMODEL_GROUP_IS_REJECTED_MEMBER = "SELECT ugj.UserID FROM UserGroupJoin ugj WHERE ugj.GroupID=? AND ugj.UserID=? AND CurrentStatus=".$CFG->USER_STATUS_SUSPENDED;
$HUB_SQL->DATAMODEL_GROUP_IS_REPORTED_MEMBER = "SELECT ugj.UserID FROM UserGroupJoin ugj WHERE ugj.GroupID=? AND ugj.UserID=? AND CurrentStatus=".$CFG->USER_STATUS_REPORTED;
?>