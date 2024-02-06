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
/**
 * sqlstatements.php
 *
 * Michelle Bachler (KMi)
 *
 * This file loads the sql statements for the database type set in the config.
 */
unset($HUB_SQL);

$HUB_SQL = new stdClass();

function loadDatabasesFile($file) {
	global $CFG, $HUB_SQL;

	/** LOAD BASE FILE **/
	if (file_exists($CFG->dirAddress.'/core/databases/base/'.$file)) {
		require_once($CFG->dirAddress.'/core/databases/base/'.$file);
	}

	/** LOAD DATABASE SPECIFIC OVERRIDES IF THEY EXIST**/
	if (file_exists($CFG->dirAddress.'/core/databases/'.$CFG->databasetype.'/'.$file)) {
		require_once($CFG->dirAddress.'/core/databases/'.$CFG->databasetype.'/'.$file);
	}
}

/** CORE **/
loadDatabasesFile('sql-base.php');
loadDatabasesFile('sql-core-audit.php');
loadDatabasesFile('sql-core-apilib.php');
loadDatabasesFile('sql-core-statslib.php');
loadDatabasesFile('sql-core-databaseutillib.php');

/** DATAMODEL **/
loadDatabasesFile('sql-datamodel-activity.php');
loadDatabasesFile('sql-datamodel-activityset.php');
loadDatabasesFile('sql-datamodel-connection.php');
loadDatabasesFile('sql-datamodel-connectionset.php');
loadDatabasesFile('sql-datamodel-following.php');
loadDatabasesFile('sql-datamodel-group.php');
loadDatabasesFile('sql-datamodel-groupset.php');
loadDatabasesFile('sql-datamodel-linktype.php');
loadDatabasesFile('sql-datamodel-linktypeset.php');
loadDatabasesFile('sql-datamodel-node.php');
loadDatabasesFile('sql-datamodel-nodeset.php');
loadDatabasesFile('sql-datamodel-result.php');
loadDatabasesFile('sql-datamodel-role.php');
loadDatabasesFile('sql-datamodel-roleset.php');
loadDatabasesFile('sql-datamodel-tag.php');
loadDatabasesFile('sql-datamodel-tagset.php');
loadDatabasesFile('sql-datamodel-url.php');
loadDatabasesFile('sql-datamodel-urlset.php');
loadDatabasesFile('sql-datamodel-user.php');
loadDatabasesFile('sql-datamodel-userauthentication.php');
loadDatabasesFile('sql-datamodel-userscache.php');
loadDatabasesFile('sql-datamodel-userset.php');
loadDatabasesFile('sql-datamodel-version.php');
loadDatabasesFile('sql-datamodel-voting.php');
loadDatabasesFile('sql-datamodel-view.php');
loadDatabasesFile('sql-datamodel-viewnode.php');
loadDatabasesFile('sql-datamodel-viewconnection.php');
?>