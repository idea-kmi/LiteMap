<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2013 The Open University UK                                   *
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

include_once("../../config.php");
include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

global $CFG;

if ($USER->getIsAdmin() != "Y") {
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
	die;
}

$sort = optional_param("sort","date",PARAM_ALPHANUM);
$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
$direction = optional_param("lastdir","DESC",PARAM_ALPHANUM);

$registeredUsers = getRegisteredUsers($direction, $sort, $oldsort);
$countUsers = count($registeredUsers);

echo '<h1>'.$LNG->ADMIN_NEWS_USERS.'</h1>';

echo '<h3 style="float: left">'.$LNG->STATS_GLOBAL_REGISTER_TOTAL_LABEL.' = '.$countUsers.'</h3>';
?>
	<div style="clear: both; float: left; margin-top: 10px;" align="center"><img src="usersgraph.php?time=months" /></div>
	<div style="clear: both; float: left; margin-top: 20px;" class="adminTableDiv" align="center">
	<table width="1000" cellpadding="2" border="1" style="border-collapse: collapse">
	<?php
		if ($sort) {
			if ($direction) {
				if ($oldsort === $sort) {
					if ($direction === 'ASC') {
						$direction = "DESC";
					} else {
						$direction = "ASC";
					}
				} else {
					$direction = "ASC";
				}
			} else {
				$direction = "ASC";
			}
		} else {
			$sort='date';
			$direction='DESC';
		}

		echo '<tr><td></td><td align="left" valign="bottom" width="25%" class="adminTableHead"><a href="userRegistration.php?&sort=name&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_NAME.'</b>';
		if ($sort === 'name') {
			if ($direction === 'ASC') {
				echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
			} else {
				echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
			}
		}
		echo '</td>';
		echo '<td align="left" valign="bottom" width="10%" class="adminTableHead"><a href="userRegistration.php?&sort=date&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_DATE.'</b>';
		if ($sort === 'date') {
			if ($direction === 'ASC') {
				echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
			} else {
				echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
			}
		}
		echo '</td>';
		echo '<td align="left" valign="bottom" width="25%" class="adminTableHead"><a href="userRegistration.php?&sort=desc&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_DESC.'</b>';
		if ($sort === 'desc') {
			if ($direction === 'ASC') {
				echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
			} else {
				echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
			}
		}
		echo '</td>';
		echo '<td align="left" valign="bottom" width="10%" class="adminTableHead"><a href="userRegistration.php?&sort=website&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_WEBSITE.'</b>';
		if ($sort === 'website') {
			if ($direction === 'ASC') {
				echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
			} else {
				echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
			}
		}
		echo '</td>';

		echo '<td align="left" valign="bottom" width="10%" class="adminTableHead"><a href="userRegistration.php?&sort=location&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_LOCATION.'</b>';
		if ($sort === 'location') {
			if ($direction === 'ASC') {
				echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
			} else {
				echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
			}
		}
		echo '</td>';

		echo '<td align="left" valign="bottom" width="20%" class="adminTableHead"><a href="userRegistration.php?&sort=login&lastsort='.$sort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_LAST_LOGIN.'</b>';
		if ($sort === 'login') {
			if ($direction === 'ASC') {
				echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
			} else {
				echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
			}
		}
		echo '</td></tr>';

		$countUsers = count($registeredUsers);
		if ($countUsers > 0) {
			for ($i=0; $i<$countUsers; $i++) {
				$array = $registeredUsers[$i];
				$name = $array['Name'];
				$userid = $array['UserID'];
				$date = $array['CreationDate'];
				$desc = $array['Description'];
				$website = $array['Website'];
				$lastlogin = $array['LastLogin'];
				$photo = '';
				$thumb = '';
				if($array['Photo']){
					$originalphotopath = $HUB_FLM->createUploadsDirPath($userid."/".stripslashes($array['Photo']));
					if (file_exists($originalphotopath)) {
						$photo =  $HUB_FLM->getUploadsWebPath($userid."/".stripslashes($array['Photo']));
						$thumb =  $HUB_FLM->getUploadsWebPath($userid."/".str_replace('.','_thumb.', stripslashes($array['Photo'])));
						if (!file_exists($thumb)) {
							create_image_thumb($array['Photo'], $CFG->IMAGE_THUMB_WIDTH, $userid);
						}
					} else {
						$photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_USER_PHOTO);
						$thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_USER_PHOTO)));
					}
				} else {
					$photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_USER_PHOTO);
					$thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_USER_PHOTO)));
				}

				$location = "";
				$country="";
				if(isset($array['LocationText'])){
					$location = $array['LocationText'];
				}
				if(isset($array['LocationCountry'])){
					$cs = getCountryList();
					if (isset($cs[$array['LocationCountry']])) {
						$country = $cs[$array['LocationCountry']];
					}
				}

				echo '<tr>';
					echo '<td valign="top">';
						echo '<a title="'.$LNG->SPAM_USER_ADMIN_VIEW_BUTTON.'" href="'.$CFG->homeAddress.'user.php?userid='.$userid.'"><img style="padding:5px;padding-bottom:10px;max-width:150px;max-height:100px;" border="0" src="'.$thumb.'" /></a>';
					echo '</td>';
					echo '<td valign="top">';
						echo $name;
					echo '</td>';
					echo '<td valign="top">';
						echo strftime( '%d/%m/%Y' ,$date);
					echo '</td>';
					echo '<td valign="top">';
						echo $desc;
					echo '</td>';
					echo '<td valign="top">';
						if ($website != null && $website != "") {
							echo '<a href="'.$website.'">Homepage</a>';
						} else {
							echo '&nbsp;';
						}
					echo '</td>';
					echo '<td valign="top">';
						if ($location != "" || $country != "") {
							echo '<span>'.$location;
							if ($location != "" && $country !="") {
								echo ",";
							}
							echo $country.'</span>';
						} else {
							echo '&nbsp;';
						}
					echo '</td>';
					echo '<td valign="top">';
						echo strftime( '%d/%m/%Y' ,$lastlogin);
					echo '</td>';
				echo '</tr>';
			}
		}
	?>
	</table>
	</div>
<?php
include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>