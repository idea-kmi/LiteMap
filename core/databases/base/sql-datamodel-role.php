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

$HUB_SQL->DATAMODEL_ROLE_SELECT = "SELECT cnt.UserID, cnt.Name, cnt.Image, ctng.NodeTypeGroupID FROM NodeTypeGrouping ctng
                					INNER JOIN NodeType cnt ON cnt.NodeTypeID = ctng.NodeTypeID
                					WHERE cnt.NodeTypeID=?";

$HUB_SQL->DATAMODEL_ROLE_BY_NAME_SELECT = "SELECT NodeTypeID FROM NodeType WHERE (Name=? AND UserID=?)";

$HUB_SQL->DATAMODEL_ROLE_ADD_CHECK = "SELECT NodeTypeID from NodeType where (UserID=? and Name=?) ";
$HUB_SQL->DATAMODEL_ROLE_ADD = "INSERT into NodeType (NodeTypeID, UserID, CreationDate, Name, Image)
									VALUES (?, ?, ?, ?, ?)";
$HUB_SQL->DATAMODEL_ROLE_GROUP_ADD = "INSERT into NodeTypeGrouping (NodeTypeGroupID, NodeTypeID, UserID, CreationDate)
									VALUES (?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_ROLE_EDIT = "UPDATE NodeType set Name=?, Image=? where NodeTypeID=? and UserID=?";

$HUB_SQL->DATAMODEL_ROLE_DELETE_CHECK = "SELECT * from Triple where (FromContextTypeID=? or ToContextTypeID=?) and UserID=?";
$HUB_SQL->DATAMODEL_ROLE_DELETE_UPDATE_TRIPLE_FROM = "update Triple set FromContextTypeID=? where FromContextTypeID=? and UserID=?";
$HUB_SQL->DATAMODEL_ROLE_DELETE_UPDATE_TRIPLE_TO = "update Triple set ToContextTypeID=? where ToContextTypeID=? and UserID=?";
$HUB_SQL->DATAMODEL_ROLE_DELETE = "delete from NodeType where UserID=? and NodeTypeID=?";

$HUB_SQL->DATAMODEL_ROLE_DEFAULT_ROLES = "INSERT INTO NodeType (NodeTypeID,UserID,Name,CreationDate,Image)
                				SELECT concat(left(replace(nt.Name,' ',''),14),?), ?, nt.Name, UNIX_TIMESTAMP(), nt.Image FROM NodeType nt
               					WHERE nt.UserID=?" ;

$HUB_SQL->DATAMODEL_ROLE_DEFAULT_ROLES_GROUPS = "INSERT INTO  NodeTypeGrouping (NodeTypeGroupID, NodeTypeID,UserID,CreationDate)
                   				SELECT ?, NodeTypeID, UserID, UNIX_TIMESTAMP() FROM NodeType
                    			WHERE NodeType.UserID=?";

$HUB_SQL->DATAMODEL_ROLE_DEFAULT_SELECT = "SELECT NodeTypeID FROM NodeType WHERE UserID=? AND Name=?";

$HUB_SQL->DATAMODEL_ROLE_CAN_EDIT = "SELECT t.NodeTypeID FROM NodeType t WHERE t.UserID=? AND t.NodeTypeID=?";
$HUB_SQL->DATAMODEL_ROLE_CAN_DELETE = $HUB_SQL->DATAMODEL_ROLE_CAN_EDIT;
?>