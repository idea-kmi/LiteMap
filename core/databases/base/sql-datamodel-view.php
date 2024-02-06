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

$HUB_SQL->DATAMODEL_VIEW_SELECT_NODES = "SELECT * FROM ViewNode WHERE ViewID=?";
$HUB_SQL->DATAMODEL_VIEW_SELECT_CONNECTIONS = "SELECT * FROM ViewTriple WHERE ViewID=?";

$HUB_SQL->DATAMODEL_VIEW_DELETE_NODES = "DELETE FROM ViewNode WHERE ViewID=?";
$HUB_SQL->DATAMODEL_VIEW_DELETE_CONNECTIONS = "DELETE FROM ViewTriple WHERE ViewID=?";

$HUB_SQL->DATAMODEL_VIEW_SELECT_ALL = "SELECT t.NodeID from Node t WHERE
									t.NodeTypeID IN (Select NodeTypeID from NodeType where Name='Map')";

$HUB_SQL->DATAMODEL_VIEW_SELECT_BY_GROUP = "SELECT t.NodeID as ViewID from Node t LEFT JOIN NodeGroup ng on t.NodeID= ng.NodeID
									WHERE ng.GroupID = ? AND
									t.NodeTypeID IN (Select NodeTypeID from NodeType where Name='Map')";


/**
 *	To add the the map, either
 *	you are the owner of the map,
 *	or you are in the group the map is in
 *	or it needs to be public and not in a group,
 **/
$HUB_SQL->DATAMODEL_VIEW_CAN_EDIT = "SELECT * FROM Node t WHERE t.NodeID=?
									AND (t.UserID=?
									OR (t.NodeID IN (SELECT tg.NodeID FROM NodeGroup tg
									INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
									WHERE tg.NodeID=? AND ug.UserID=?))
									OR (t.Private='N' AND t.NodeID NOT IN (Select NodeID from NodeGroup)))";

?>