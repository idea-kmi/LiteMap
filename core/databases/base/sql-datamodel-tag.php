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

$HUB_SQL->DATAMODEL_TAG_SELECT = "SELECT Tag.UserID, Tag.Name FROM Tag WHERE Tag.TagID=?";
$HUB_SQL->DATAMODEL_TAG_BY_NAME_SELECT = "SELECT TagID FROM Tag WHERE (Name=? AND UserID=?)";

$HUB_SQL->DATAMODEL_TAG_ADD_CHECK = $HUB_SQL->DATAMODEL_TAG_BY_NAME_SELECT;

$HUB_SQL->DATAMODEL_TAG_ADD = "INSERT into Tag (TagID, UserID, CreationDate, Name, ModificationDate)
								VALUES (?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_TAG_EDIT_CHECK = $HUB_SQL->DATAMODEL_TAG_BY_NAME_SELECT;
$HUB_SQL->DATAMODEL_TAG_EDIT = "UPDATE Tag set Name=? where TagID=? and UserID=? and ModificationDate=?";

$HUB_SQL->DATAMODEL_TAG_DELETE = "DELETE from Tag where UserID=? and TagID=?";

$HUB_SQL->DATAMODEL_TAG_CAN_EDIT = "SELECT t.TagID FROM Tag t WHERE t.UserID=? AND t.TagID=?";
$HUB_SQL->DATAMODEL_TAG_CAN_DELETE = $HUB_SQL->DATAMODEL_TAG_CAN_EDIT;
?>