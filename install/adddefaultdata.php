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

require_once('../core/utillib.php');

echo "<center><h1>Load default data</h1></center>";

//The directory address of the webcode on the server and then the current sites uploads folder.
// It must end in a slash please.
// It is used to put/pull the user picture of the admin user in the relevant 'uploads folder'
// e.g. <server path to litemap webcode>/sites/default/uploads/
// NOTE: if you are running mutliple LiteMap instances this will be:
// e.g. <server path to litemap webcode>/sites/multi/<domain folder>/uploads/

$dirAddressUploads = '';

$databaseaddress = 'localhost'; // mostlty this will be 'localhost' depending where your database is.
$databaseuser = '';
$databasepass = '';
$databasename = '';

/// The following user emails will not be validated as they are system user accounts
/// So they can be made up or real.

// Default user
$email = '';
$password = ''; // 8 characters long please.
$fullname = 'Default';
$description = 'Default template user whose link and node types are copied to all new users';

// News user
$email2 = '';
$password2 = ''; // 8 characters long please.
$fullname2 = 'System Admin';
$description2 = 'This account manages the News and other system related items.';

$DB = new stdClass();
$DB->conn = mysql_connect($databaseaddress , $databaseuser, $databasepass );
if(!$DB->conn){
	 die("Failed to create connection to database: ".mysql_error());
}
//connect to specified database
mysql_select_db($databasename, $DB->conn) or die("Failed to connect to database named: ".mysql_error());

// Check if Users table empty. Good indication that they have not run this script yet.
$query = "SELECT * FROM Users";
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) {
	echo "ERROR: Your database does not appear to be empty. <br>
	The default data should only be loaded once into an empty database.<br>
	<br>Please make sure all your database tables are empty and try again.";
} else {
	/** CREATE DEFAULT USER **/

	$userid = getUniqueID();
	$photo = 'profile.png';
	$dt = time();

	$qry = "INSERT INTO Users (
			UserID,
			CreationDate,
			ModificationDate,
			Email,
			Name,
			Password,
			Website,
			Private,
			LastLogin,
			IsAdministrator,
			IsGroup,
			Description,
			AuthType,
			Photo )
		VALUES (
			'".$userid."',
			".$dt.",
			".$dt.",
			'".mysql_real_escape_string($email, $DB->conn)."',
			'".mysql_real_escape_string($fullname, $DB->conn)."',
			'".mysql_real_escape_string(crypt($password), $DB->conn)."',
			'',
			'N',
			". $dt .",
			'Y',
			'N',
			'".mysql_real_escape_string($description, $DB->conn)."',
			'litemap',
			'".mysql_real_escape_string($photo, $DB->conn)."')";

	$res = mysql_query( $qry, $DB->conn );
	if( !$res ) {
		echo "error adding default user.<br/>";
	} else {
		/*** LOAD DEFAULT DATA  ***/
		// (this will go under the default template user's account. Node and link types will be copied to each new user created.

		$mysqli = new mysqli($databaseaddress, $databaseuser, $databasepass, $databasename);

		/* check connection */
		if (mysqli_connect_errno()) {
			echo "Failed to create multi-connection to: ".mysqli_connect_error()."<br/>";
			exit();
		}

		/*
		Table data for LinkType
		*/

		$isrelatedtoid = getUniqueID();
		$ispartorfid = getUniqueID();
		$raisedbyid = getUniqueID();
		$seealsoid = getUniqueID();
		$builtfromid = getUniqueID();
		$supportsid = getUniqueID();
		$challengesid = getUniqueID();
		$respondstoid = getUniqueID();

		$qry = "INSERT INTO `LinkType` VALUES ('".$isrelatedtoid."','".$userid."','#000000',NULL,NULL,'is related to',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$ispartorfid."','".$userid."','#000000',NULL,NULL,'is part of',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$raisedbyid."','".$userid."','#000000',NULL,NULL,'raised by',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$seealsoid."','".$userid."','#000000',NULL,NULL,'see also',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$builtfromid."','".$userid."','#000000',NULL,NULL,'built from',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$supportsid."','".$userid."','#000000',NULL,NULL,'supports',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$respondstoid."','".$userid."','#000000',NULL,NULL,'responds to',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$challengesid."','".$userid."','#000000',NULL,NULL,'challenges',0);";

		if (!$mysqli->multi_query($qry)) {
			if ($mysqli->errno) {
				echo "Error adding link types: ".$mysqli->error."<br/>";
			}
		} else {
			while ($mysqli->next_result()) {;}

			/*
			Table data for LinkTypeGroup
			*/

			$positiveid = getUniqueID();
			$negativeid = getUniqueID();
			$neutralid = getUniqueID();

			$qry = "INSERT INTO `LinkTypeGroup` VALUES ('".$positiveid."','".$userid."','Positive',0);";
			$qry .= "INSERT INTO `LinkTypeGroup` VALUES ('".$negativeid."','".$userid."','Negative',0);";
			$qry .= "INSERT INTO `LinkTypeGroup` VALUES ('".$neutralid."','".$userid."','Neutral',0);";
			if (!$mysqli->multi_query($qry)) {
				if ($mysqli->errno) {
					echo "Error adding link groups: ".$mysqli->error."<br/>";
				}
			} else {
				while ($mysqli->next_result()) {;}

				/*
				Table data for LinkTypeGrouping
				*/
				$qry = "INSERT INTO `LinkTypeGrouping` VALUES ('".$positiveid."','".$supportsid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$negativeid."','".$challengesid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$isrelatedtoid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$ispartorfid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$raisedbyid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$seealsoid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$builtfromid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$respondstoid."','".$userid."',0);";
				if (!$mysqli->multi_query($qry)) {
					if ($mysqli->errno) {
						echo "Error adding linktypes into groups: ".$mysqli->error."<br/>";
					}
				} else {
					while ($mysqli->next_result()) {;}

					/**
					 * Table data for NodeType
					 */
					$newsid = getUniqueID();
					$challengeid = getUniqueID();
					$commentid = getUniqueID();
					$solutionid = getUniqueID();
					$issueid = getUniqueID();
					$proid = getUniqueID();
					$conid = getUniqueID();
					$argumentid = getUniqueID();
					$mapid = getUniqueID();
					$ideaid = getUniqueID();

					/* These are core datamodel types and are required by the system */
					$qry = "INSERT INTO `NodeType` VALUES ('".$newsid."','".$userid."','News',0,'nodetypes/Default/news.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$challengeid."','".$userid."','Challenge',0,'nodetypes/Default/challenge.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$commentid."','".$userid."','Comment',0,'nodetypes/Default/comment.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$solutionid."','".$userid."','Solution',0,'nodetypes/Default/solution.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$issueid."','".$userid."','Issue',0,'nodetypes/Default/issue.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$proid."','".$userid."','Pro',0,'nodetypes/Default/plus-32x32.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$conid."','".$userid."','Con',0,'nodetypes/Default/minus-32x32.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$argumentid."','".$userid."','Argument',0,'nodetypes/Default/argument.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$mapid."','".$userid."','Map',0,'nodetypes/Default/map.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$ideaid."','".$userid."','Idea',0,'nodetypes/Default/idea.png');";
					if (!$mysqli->multi_query($qry)) {
						if ($mysqli->errno) {
							echo "Error adding base nodetypes: ".$mysqli->error."<br/>";
						}
					} else {
						while ($mysqli->next_result()) {;}

						/*
						Table data for NodeTypeGroup
						*/
						$defaultrolegroup = getUniqueID();
						$systemtrolegroup = getUniqueID();

						$qry = "INSERT INTO `NodeTypeGroup` VALUES ('".$defaultrolegroup."','".$userid."','Default Roles',0);";
						$qry .= "INSERT INTO `NodeTypeGroup` VALUES ('".$systemtrolegroup."','".$userid."','System',0);";

						if (!$mysqli->multi_query($qry)) {
							if ($mysqli->errno) {
								echo "Error adding nodetype groups: ".$mysqli->error."<br/>";
							}
						} else {
							while ($mysqli->next_result()) {;}

							/**
							 * Table data for NodeTypeGrouping
							 */

							/** Datamodel Types into the Default Roles group */
							$qry = "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$challengeid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$commentid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$solutionid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$issueid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$mapid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$ideaid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$proid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$conid."','".$userid."',0);";
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$argumentid."','".$userid."',0);";

							/** News into the System Role Group */
							$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$systemtrolegroup."','".$newsid."','".$userid."',0);";

							if (!$mysqli->multi_query($qry)) {
								if ($mysqli->errno) {
									echo "Error adding nodetypes into nodetype groups: ".$mysqli->error."<br>";
								}
							} else {
								while ($mysqli->next_result()) {;}
								$mysqli->close();

								// add News/System Admin user
								$userid2 = getUniqueID();
								$photo2 = 'systemadmin.png';

								$qry = "INSERT INTO Users (
										UserID,
										CreationDate,
										ModificationDate,
										Email,
										Name,
										Password,
										Website,
										Private,
										LastLogin,
										IsAdministrator,
										IsGroup,
										Description,
										AuthType,
										Photo )
									VALUES (
										'".$userid2."',
										".$dt.",
										".$dt.",
										'".mysql_real_escape_string($email2, $DB->conn)."',
										'".mysql_real_escape_string($fullname2, $DB->conn)."',
										'".mysql_real_escape_string(crypt($password2), $DB->conn)."',
										'',
										'N',
										". $dt .",
										'Y',
										'N',
										'".mysql_real_escape_string($description2, $DB->conn)."',
										'litemap',
										'".mysql_real_escape_string($photo2, $DB->conn)."')";



								$res = mysql_query( $qry, $DB->conn );
								if( !$res ) {
									echo "error adding system admin user.<br>";
								} else {
									// add the default roles for System Admin user
									$sql = "INSERT INTO NodeType (NodeTypeID,UserID,Name,CreationDate,Image) ";
									$sql .= "SELECT concat(left(nt.Name,15),'".$userid2."'), '".$userid2."', nt.Name, UNIX_TIMESTAMP(), nt.Image FROM NodeType nt ";
									$sql .= "WHERE nt.UserID='".$userid."'";

									$res = mysql_query( $sql, $DB->conn);

									if (!$res){
										 echo "error adding default node type data to System Admin user.<br>";
									} else {
										//add the default groupings for these
										$sql = "INSERT INTO NodeTypeGrouping (NodeTypeGroupID, NodeTypeID, UserID, CreationDate)
												SELECT ngrp.NodeTypeGroupID, nt.NodeTypeID, nt.UserID, UNIX_TIMESTAMP() FROM NodeType nt
												INNER JOIN (SELECT ntg.NodeTypeGroupID, nt2.Name FROM NodeTypeGrouping ntg INNER JOIN NodeType nt2 ON ntg.NodeTypeID = nt2.NodeTypeID WHERE nt2.UserID='".$userid."') ngrp ON ngrp.Name = nt.Name
												WHERE nt.NodeTypeID NOT IN (SELECT NodeTypeID FROM NodeTypeGrouping)";

										$res = mysql_query( $sql, $DB->conn);
										if (!$res){
											echo "error adding default node type grouping data to System Admin user.<br>";
										}
									}

									// add default link types to System Admin user
									$sql = "INSERT INTO LinkType (LinkTypeID,UserID,Label,CreationDate)
											SELECT concat(left(replace(lt.Label,' ',''),15),'".$userid2."'), '".$userid2."', lt.Label, UNIX_TIMESTAMP() FROM LinkType lt
											WHERE lt.UserID='".$userid."'";


									$res = mysql_query( $sql, $DB->conn);
									if (!$res){
											echo "error adding default link type data to System Admin user.<br>";
									} else {
										//add the default groupings for these
										$sql = "INSERT INTO LinkTypeGrouping (LinkTypeGroupID, LinkTypeID, UserID, CreationDate)
												SELECT lgrp.LinkTypeGroupID, lt.LinkTypeID, lt.UserID, UNIX_TIMESTAMP() FROM LinkType lt
												INNER JOIN (SELECT ltg.LinkTypeGroupID, lt2.Label FROM LinkTypeGrouping ltg INNER JOIN LinkType lt2 ON ltg.LinkTypeID = lt2.LinkTypeID WHERE lt2.UserID='".$userid."') lgrp ON lgrp.Label = lt.Label
												WHERE lt.LinkTypeID NOT IN (SELECT LinkTypeID FROM LinkTypeGrouping)";

										$res2 = mysql_query( $sql, $DB->conn);
										if (!$res2){
											echo "error adding default link grouping type data to System Admin user.<br>";
										}
									}

									// add user image;
									$target_path = $dirAddressUploads.$userid2."/";
									if(!file_exists($target_path)){
										mkdir($target_path, 0777, true);
									}
									$source_file = $dirAddressUploads.$photo2;
									$target_file = $target_path.$photo2;
									if(copy($source_file, $target_file)) {
										if(resize_image($target_path,$target_path, 60)){
											$image_thumb = $target_path.str_replace('.','_thumb.',$photo2);
											resize_image($target_file, $image_thumb, 30);
										}
									}

									echo "Copy to the config the Admin User ID: ".$userid2."<br>";
									echo "Copy to the config the Default User ID: ".$userid."<br>";
									echo "Copy to the config the Default Role Group ID: ".$defaultrolegroup."<br>";
								}
							}
						}
					}
				}
			}
		}
	}
}
?>
