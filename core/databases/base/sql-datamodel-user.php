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

$HUB_SQL->DATAMODEL_USER_SELECT = "SELECT * FROM Users WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_TAGS = "SELECT u.TagID FROM TagUsers ut INNER JOIN Tag u ON u.TagID = ut.TagID WHERE ut.UserID=? ORDER BY Name ASC";
$HUB_SQL->DATAMODEL_USER_FOLLOW = "SELECT * FROM Following WHERE UserID=? AND ItemID=?";
$HUB_SQL->DATAMODEL_USER_BY_EMAIL_SELECT = "SELECT UserID FROM Users WHERE Email=?";

$HUB_SQL->DATAMODEL_USER_ADD = "INSERT INTO Users (
								UserID, CreationDate, ModificationDate, Email, Name,Password,
								Website, Private, LastLogin, IsAdministrator, IsGroup, AuthType,
								Description, Photo, RegistrationKey, CurrentStatus, TestGroup)
									VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_USER_LAST_TEST_GROUP = "SELECT TestGroup from Users Where IsGroup = 'N' order by CreationDate DESC LIMIT 1";

$HUB_SQL->DATAMODEL_USER_NAME_UPDATE = "UPDATE Users SET Name=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_DESC_UPDATE = "UPDATE Users SET Description=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_INTEREST_UPDATE = "UPDATE Users SET Interest=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_WEBSITE_UPDATE = "UPDATE Users SET Website=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_PRIVACY_UPDATE = "UPDATE Users SET Private=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_PHOTO_UPDATE = "UPDATE Users SET Photo=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_EMAIL_UPDATE_CHECK = "SELECT UserID FROM Users WHERE Email=? AND UserID <> ?";
$HUB_SQL->DATAMODEL_USER_EMAIL_UPDATE = "UPDATE Users SET Email=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_PASSWORD_UPDATE = "UPDATE Users SET Password=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_LAST_LOGIN_UPDATE = "UPDATE Users SET LastLogin=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_LAST_ACTIVE_UPDATE = "UPDATE Users SET LastActive=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_LOCATION_UPDATE = "UPDATE Users SET LocationText=?, LocationCountry=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_LATLONG_UPDATE = "UPDATE Users SET LocationLat=?, LocationLng=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_FOLLOW_EMAIL_UPDATE = "UPDATE Users SET FollowSendEmail=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_FOLLOW_EMAIL_INTERVAL_UPDATE = "UPDATE Users SET FollowRunInterval=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_FOLLOW_EMAIL_LAST_RUN_UPDATE = "UPDATE Users SET FollowLastRun=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_NEWLETTER_EMAIL_UPDATE = "UPDATE Users SET Newsletter=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_RECENT_ACTIVITIES_EMAIL_UPDATE = "UPDATE Users SET RecentActivitiesEmail=? WHERE UserID=?";

$HUB_SQL->DATAMODEL_USER_INVITATION_CODE_SELECT = "SELECT InvitationCode FROM Users WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_INVITATION_CODE_UPDATE = "UPDATE Users SET InvitationCode=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_INVITATION_CODE_RESET = "UPDATE Users SET InvitationCode='' WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_INVITATION_CODE_VALIDATE = "SELECT UserID FROM Users WHERE InvitationCode=? AND UserID=?";
$HUB_SQL->DATAMODEL_USER_REGISTRATION_KEY_RESET = "UPDATE Users set RegistrationKey=?, ValidationKey=?, CurrentStatus=? WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_REGISTRATION_KEY_SELECT = "SELECT RegistrationKey FROM Users WHERE UserID=?";
$HUB_SQL->DATAMODEL_USER_REGISTRATION_KEY_VALIDATE = "SELECT UserID FROM Users WHERE RegistrationKey=? AND UserID=?";
$HUB_SQL->DATAMODEL_USER_REGISTRATION_COMPLETE = "UPDATE Users set ValidationKey=?, CurrentStatus=? WHERE RegistrationKey=? AND UserID=?";
$HUB_SQL->DATAMODEL_USER_IS_EMAIL_VALIDATED = "SELECT RegistrationKey, ValidationKey from Users where UserID=?";

$HUB_SQL->DATAMODEL_USER_ADD_TAG_CHECK = "SELECT TagID FROM TagUsers WHERE TagID=? and UserID=?";
$HUB_SQL->DATAMODEL_USER_ADD_TAG = "INSERT into TagUsers (UserID, TagID) VALUES (?, ?)";
$HUB_SQL->DATAMODEL_USER_DELETE = "DELETE FROM TagUsers WHERE UserID=? AND TagID=?";

$HUB_SQL->DATAMODEL_USER_STATUS_UPDATE = "UPDATE Users SET CurrentStatus=?, ModificationDate=? WHERE UserID=?";
?>