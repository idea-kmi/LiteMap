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

$HUB_SQL->DATAMODEL_VIEWNODE_SELECT = "SELECT t.* FROM ViewNode t WHERE t.ViewID=? AND t.NodeID=? AND t.UserID=?";

$HUB_SQL->DATAMODEL_VIEWNODE_ADD = "INSERT into ViewNode (ViewID, NodeID, UserID, XPos, YPos, CreationDate, ModificationDate)
									VALUES (?, ?, ?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_VIEWNODE_EDIT = "UPDATE ViewNode set ModificationDate=?, XPos=?, YPos=? WHERE ViewID=? AND NodeID=? AND UserID=?";

$HUB_SQL->DATAMODEL_VIEWNODE_DELETE = "DELETE FROM ViewNode WHERE ViewID=? AND NodeID=? AND UserID=?";

/** CHANGED: If you can edit the map you can edit the node position in the map **/
/** You are allowed to edit the record if you own it **/
$HUB_SQL->DATAMODEL_VIEWNODE_CAN_EDIT = "SELECT * FROM ViewNode v WHERE v.ViewID=? AND v.NodeID=? AND v.UserID=?";

/** You are allowed to delete the record if you own it **/
$HUB_SQL->DATAMODEL_VIEWNODE_CAN_DELETE = $HUB_SQL->DATAMODEL_NODE_CAN_EDIT;
?>