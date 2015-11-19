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

$HUB_SQL->DATAMODEL_USER_AUTH_SELECT = "SELECT * FROM UsersAuthentication WHERE AuthID=?";
$HUB_SQL->DATAMODEL_USER_AUTH_LOAD_BY_PROVIDER = "Select * from  UsersAuthentication where Provider=? AND ProviderUID=?";
$HUB_SQL->DATAMODEL_USER_AUTH_ADD = "INSERT INTO UsersAuthentication (AuthID,UserID,CreationDate,Provider,ProviderUID,Email,RegistrationKey)
										VALUES (?, ?, ?, ?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_USER_AUTH_REGISTRATION_KEY_SELECT = "SELECT RegistrationKey FROM UsersAuthentication WHERE AuthID=?";
$HUB_SQL->DATAMODEL_USER_AUTH_REGISTRATION_KEY_VALIDATE = "SELECT UserID FROM UsersAuthentication WHERE RegistrationKey=? AND AuthID=?";
$HUB_SQL->DATAMODEL_USER_AUTH_COMPLETE_VERIFICATION = "UPDATE UsersAuthentication set ValidationKey=? WHERE RegistrationKey=? AND AuthID=?";
$HUB_SQL->DATAMODEL_USER_AUTH_IS_EMAIL_VERIFIRED = "SELECT RegistrationKey, ValidationKey from UsersAuthentication where AuthID=?";
?>