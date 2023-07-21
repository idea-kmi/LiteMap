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

$HUB_SQL->DATAMODEL_URL_SELECT = "SELECT * FROM URL WHERE URLID=?";

$HUB_SQL->DATAMODEL_URL_IDEA_COUNT = "SELECT COUNT(ut.URLID) AS ideacount FROM URL u
									LEFT OUTER JOIN (SELECT URLID FROM URLNode) ut
									ON u.URLID = ut.URLID
									WHERE u.URLID=? GROUP BY u.URLID";

$HUB_SQL->DATAMODEL_URL_TAGS_SELECT = "SELECT u.TagID FROM TagURL ut INNER JOIN Tag u ON u.TagID = ut.TagID WHERE ut.URLID=? ORDER BY Name ASC";
$HUB_SQL->DATAMODEL_URL_GROUPS_SELECT = "SELECT GroupID FROM URLGroup tg WHERE tg.URLID=?";

$HUB_SQL->DATAMODEL_URL_ADD_CHECK_CLIPPATH = "SELECT * FROM URL WHERE UserID=? and URL=? and ClipPath=?";
$HUB_SQL->DATAMODEL_URL_ADD_CHECK_CLIP = "SELECT * FROM URL WHERE UserID=? and URL=? and Clip=?";
$HUB_SQL->DATAMODEL_URL_ADD = "INSERT INTO URL (URLID, UserID, CreationDate, ModificationDate, URL, Title, Description, Clip, ClipPath, ClipHTML, Private, CreatedFrom, AdditionalIdentifier)
 									VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_URL_EDIT_CHECK_CLIPPATH = $HUB_SQL->DATAMODEL_URL_ADD_CHECK_CLIPPATH;
$HUB_SQL->DATAMODEL_URL_EDIT_CHECK_CLIP = $HUB_SQL->DATAMODEL_URL_ADD_CHECK_CLIP;
$HUB_SQL->DATAMODEL_URL_EDIT = "UPDATE URL SET
		                ModificationDate=?, URL=?, Clip=?, Description=?, Title=?,
		                Private=?, ClipPath=?, ClipHTML=?, CreatedFrom=?,
		                AdditionalIdentifier=? WHERE URLID=?";

$HUB_SQL->DATAMODEL_URL_DELETE_CHECK = "SELECT NodeID from URLNode where URLID=?";
$HUB_SQL->DATAMODEL_URL_URLNODE_DELETE = "DELETE FROM URLNode WHERE NodeID=? and URLID=? and UserID=?";
$HUB_SQL->DATAMODEL_URL_DELETE = "DELETE FROM URL WHERE URLID=?";

$HUB_SQL->DATAMODEL_URL_ADDITIONAL_IDENTIFIER_UPDATE = "UPDATE URL SET AdditionalIdentifier=?, ModificationDate=? WHERE URLID=?";
$HUB_SQL->DATAMODEL_URL_PRIVACY_UPDATE = "UPDATE URL SET Private=?, ModificationDate=? WHERE URLID=?";

$HUB_SQL->DATAMODEL_URL_GROUP_ADD_CHECK  = "SELECT GroupID FROM URLGroup tg WHERE tg.URLID=? AND tg.GroupID=?";
$HUB_SQL->DATAMODEL_URL_GROUP_ADD = "INSERT INTO URLGroup (URLID,GroupID,CreationDate) VALUES (?, ?, ?)";
$HUB_SQL->DATAMODEL_URL_GROUP_DELETE = "DELETE FROM URLGroup WHERE URLID=? AND GroupID=?";
$HUB_SQL->DATAMODEL_URL_GROUP_DELETE_ALL = "DELETE FROM URLGroup WHERE NodeID=?";

$HUB_SQL->DATAMODEL_URL_TAG_ADD_CHECK = "SELECT TagID from TagURL where URLID=? and TagID=? and UserID=?";
$HUB_SQL->DATAMODEL_URL_TAG_ADD = "INSERT into TagURL (UserID, TagID, URLID) VALUES (?, ?, ?)";
$HUB_SQL->DATAMODEL_URL_TAG_DELETE = "DELETE FROM TagURL WHERE URLID=? and TagID=? and UserID=?";

$HUB_SQL->DATAMODEL_URL_IDEA_ADD_CHECK = "select NodeID, Comments, CreationDate from URLNode where URLID=? and NodeID=? and UserID=?";
$HUB_SQL->DATAMODEL_URL_IDEA_ADD = "INSERT into URLNode (UserID, URLID, NodeID, CreationDate, ModificationDate, Comments)
									VALUES (?, ?, ?, ?, ?, ?)";
$HUB_SQL->DATAMODEL_URL_IDEA_DELETE = "DELETE FROM URLNode WHERE NodeID=? and URLID=? and UserID=?";

$HUB_SQL->DATAMODEL_URL_STATUS_UPDATE = "UPDATE URL SET CurrentStatus=?, ModificationDate=? WHERE URLID=?";

$HUB_SQL->DATAMODEL_URL_CAN_VIEW = "SELECT t.URLID FROM URL t
                WHERE t.URLID=? AND ((t.Private=?) OR (t.UserID = ?) OR
                  (t.URLID IN (SELECT tg.URLID FROM URLGroup tg
                                INNER JOIN UserGroup ug ON ug.GroupID=tg.GroupID
                                WHERE tg.URLID = ? AND ug.UserID = ?)))";


$HUB_SQL->DATAMODEL_URL_CAN_EDIT = "SELECT u.URLID FROM URL u WHERE u.UserID=? AND u.URLID=?";
$HUB_SQL->DATAMODEL_URL_CAN_DELETE = $HUB_SQL->DATAMODEL_URL_CAN_EDIT;

$HUB_SQL->DATAMODEL_URL_WESITE_USAGE = "SELECT count(URLID) as urlcount FROM URLNode where URLID=? AND UserID=?";
?>