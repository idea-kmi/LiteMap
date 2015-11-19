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
/**
 * sql-apilib.php
 *
 * Michelle Bachler (KMi)
 *
 */

/** General SQL items **/
$HUB_SQL->OR = " OR ";
$HUB_SQL->AND = " AND ";
$HUB_SQL->UNION = "UNION";
$HUB_SQL->OPENING_BRACKET = " ( ";
$HUB_SQL->CLOSING_BRACKET = " ) ";
$HUB_SQL->WHERE = " WHERE ";
$HUB_SQL->ORDER_BY = " ORDER BY ";
$HUB_SQL->ASC = "ASC";
$HUB_SQL->DESC = "DESC";

$HUB_SQL->SEARCH_LIKE = " LIKE ('%?%')";
$HUB_SQL->SEARCH_LIKE_FROM = " LIKE ('%?')";

$HUB_SQL->SEARCH_LIKE_START = " LIKE ('%";
$HUB_SQL->SEARCH_LIKE_END = "%')";
$HUB_SQL->SEARCH_LIKE_FROM_START = " LIKE ('%";
$HUB_SQL->SEARCH_LIKE_FROM_END = "')";

$HUB_SQL->ORDER_BY_NAME = " order by Name "; // User name
$HUB_SQL->ORDER_BY_USERCOUNT = " order by UseCount ";
$HUB_SQL->ORDER_BY_CREATIONDATE = " order by CreationDate ";
$HUB_SQL->ORDER_BY_LASTLOGIN = " order by LastLogin ";
$HUB_SQL->ORDER_BY_EMAIL = " order by Email ";
$HUB_SQL->ORDER_BY_WEBSITE = " order by Webiste ";
$HUB_SQL->ORDER_BY_LOCATION = " order by LocationText,LocationCountry ";

$HUB_SQL->FILTER_USERS = "t.UserID IN";
$HUB_SQL->FILTER_USER = "t.UserID=?";
?>