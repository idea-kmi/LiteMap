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

$HUB_SQL->DATAMODEL_VIEWCONNECTION_SELECT = "SELECT t.* FROM ViewTriple t WHERE t.ViewID=? AND t.TripleID=? AND t.UserID=? ";

$HUB_SQL->DATAMODEL_VIEWCONNECTION_ADD = "INSERT into ViewTriple (ViewID, TripleID, UserID, CreationDate, ModificationDate)
								VALUES (?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_VIEWCONNECTION_DELETE = "DELETE FROM ViewTriple WHERE ViewID=? AND UserID=? AND TripleID=?";

$HUB_SQL->DATAMODEL_VIEWCONNECTION_DELETE_NODE = "DELETE FROM Triple WHERE TripleID IN (Select TripleID from ViewTriple where
										ViewID=? AND UserID=? AND TripleID IN (
										SELECT res.TripleID from ((SELECT t.TripleID from Triple t WHERE t.FromID=?)
										UNION ALL (SELECT s.TripleID from Triple s WHERE s.ToID=?)) as res ))";

/** You are allowed to delete the record if you own it **/
$HUB_SQL->DATAMODEL_VIEWCONNECTION_CAN_DELETE = "SELECT * FROM ViewTriple v WHERE v.ViewID=? AND v.TripleID=? AND v.UserID=?";
?>