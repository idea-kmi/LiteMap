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

$HUB_SQL->DATAMODEL_LINKTYPE_SELECT = "SELECT lt.LinkTypeID, lt.Label, lt.UserID, ltg.LinkTypeGroupID, ltg.Label AS GroupLabel FROM LinkType lt ".
									   " INNER JOIN LinkTypeGrouping ltgg ON lt.LinkTypeID = ltgg.LinkTypeID ".
									   " INNER JOIN LinkTypeGroup ltg ON ltgg.LinkTypeGroupID = ltg.LinkTypeGroupID ".
									   " WHERE lt.LinkTypeID=?";

$HUB_SQL->DATAMODEL_LINKTYPE_BY_LABEL_SELECT = "SELECT lt.LinkTypeID FROM LinkType lt ".
										   " INNER JOIN LinkTypeGrouping ltgg ON lt.LinkTypeID = ltgg.LinkTypeID ".
										   " INNER JOIN LinkTypeGroup ltg ON ltgg.LinkTypeGroupID = ltg.LinkTypeGroupID ".
										   " WHERE lt.Label=? AND lt.UserID=?";

$HUB_SQL->DATAMODEL_LINKTYPE_ADD_GROUP_CHECK = "SELECT LinkTypeGroupID FROM LinkTypeGroup WHERE Label=?";

$HUB_SQL->DATAMODEL_LINKTYPE_ADD_CHECK = "SELECT LinkTypeID FROM LinkType WHERE Label=? AND (UserID=? OR UserID=?)";

$HUB_SQL->DATAMODEL_LINKTYPE_ADD = "INSERT INTO LinkType (LinkTypeID,UserID,Label,CreationDate)
                					VALUES(?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_LINKTYPE_ADD_GROUP = "INSERT INTO LinkTypeGrouping (LinkTypeGroupID,LinkTypeID,UserID,CreationDate)
                					VALUES(?, ?, ?, ?)";

$HUB_SQL->DATAMODEL_LINKTYPE_EDIT = "UPDATE LinkType set Label=? where LinkTypeID=? and UserID=?";

$HUB_SQL->DATAMODEL_LINKTYPE_DELETE_CHECK = "SELECT * from Triple where LinkTypeID=? and UserID=?";
$HUB_SQL->DATAMODEL_LINKTYPE_DELETE_TRIPLE = "DELETE from Triple where LinkTypeID=? and UserID=?";
$HUB_SQL->DATAMODEL_LINKTYPE_DELETE = "DELETE from LinkType where LinkTypeID=? and UserID=?";

$HUB_SQL->DATAMODEL_LINKTYPE_UPDATE_DEFAULT_LINKTYPES = "INSERT INTO LinkType (LinkTypeID,UserID,Label,CreationDate)
                					SELECT concat(left(replace(lt.Label,' ',''),14),?), ?, lt.Label, UNIX_TIMESTAMP() FROM LinkType lt
               						WHERE lt.UserID=?";

$HUB_SQL->DATAMODEL_LINKTYPE_UPDATE_DEFAULT_LINKTYPES_GROUP = "INSERT INTO LinkTypeGrouping (LinkTypeGroupID, LinkTypeID, UserID, CreationDate)
                    			SELECT lgrp.LinkTypeGroupID, lt.LinkTypeID, lt.UserID, UNIX_TIMESTAMP() FROM LinkType lt
                    			INNER JOIN (SELECT ltg.LinkTypeGroupID, lt2.Label FROM LinkTypeGrouping ltg
                    			INNER JOIN LinkType lt2 ON ltg.LinkTypeID = lt2.LinkTypeID WHERE lt2.UserID=?) lgrp ON lgrp.Label = lt.Label
                    			WHERE lt.LinkTypeID NOT IN (SELECT LinkTypeID FROM LinkTypeGrouping)";


$HUB_SQL->DATAMODEL_LINKTYPE_CAN_EDIT = "SELECT t.LinkTypeID FROM LinkType t WHERE t.UserID=? AND t.LinkTypeID=?";

$HUB_SQL->DATAMODEL_LINKTYPE_CAN_DELETE = "SELECT t.LinkTypeID FROM LinkType t WHERE t.UserID=? AND t.LinkTypeID=?";
?>