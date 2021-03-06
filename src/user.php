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
    include_once("config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

	array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/tabberuser.js.php').'" type="text/javascript"></script>');

	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/lib/jit-2.0.2/Jit/jit.js" type="text/javascript"></script>');
	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/visualisations/graphlib.js.php" type="text/javascript"></script>');
	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/visualisations/socialforcedirectedlib.js.php" type="text/javascript"></script>');
	array_push($HEADER,'<script src="'.$CFG->homeAddress.'ui/networkmaps/networklib.js.php" type="text/javascript"></script>');
	array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath('vis.css').'" type="text/css" media="screen" />');
	array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/base.css').'" type="text/css" />');
	array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getCodeWebPath('ui/lib/jit-2.0.2/Jit/css/ForceDirected.css').'" type="text/css" />');

	$CONTEXT = $CFG->USER_CONTEXT;
	$userid = optional_param("userid",$USER->userid,PARAM_ALPHANUMEXT);
	$user = getUser($userid,'long');
	if($user instanceof Error){
   		// Check if Users table has OriginalID field and if so check if this userid is an old ID and adjust.
		$params = array();
		$resArray = $DB->select($HUB_SQL->AUDIT_USER_CHECK_ORIGINALID_EXISTS, $params);
		if ($resArray !== false) {
			if (count($resArray) > 0) {
				$array = $resArray[0];
				if (isset($array['OriginalID'])) {
					$params = array();
					$params[0] = $userid;
					$resArray2 = $DB->select($HUB_SQL->AUDIT_USER_SELECT_ORIGINALID, $params);
					if ($resArray2 !== false) {
						if (count($resArray2) > 0) {
							$array2 = $resArray2[0];
							$userid = $array2['UserID'];
							header("Location: ".$CFG->homeAddress."user.php?userid=".$userid);
							die;
						}
					}
				}
			}
		}
    }
	if($user instanceof Error){
		echo "<h1>".$LNG->ERROR_USER_NOT_FOUND_MESSAGE." : ".$userid."</h1>";
		include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
		die;
	}

	$searchid = optional_param("sid","",PARAM_ALPHANUMEXT);
	if ($searchid != "" && isset($USER->userid)) {
		auditSearchResult($searchid, $USER->userid, $userid, 'Y');
	}

	include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/tabberuserlib.php"));

	// default parameters
	$start = optional_param("start",0,PARAM_INT);
	$max = optional_param("max",20,PARAM_INT);
	$orderby = optional_param("orderby","",PARAM_ALPHA);
	$sort = optional_param("sort","DESC",PARAM_ALPHA);

	// if coming from a search
	$query = stripslashes(optional_param("q","",PARAM_TEXT));

	if(isset($USER->userid) && $USER->userid == $userid){
		if( isset($_POST["followruninterval"]) ) {
			$followsendemail = optional_param("followsendemail","",PARAM_TEXT);
			$followruninterval = optional_param("followruninterval","",PARAM_TEXT);

			if ($followsendemail != "") {
				$USER->updateFollowSendEmail('Y');
			} else {
				$USER->updateFollowSendEmail('N');
			}

			if ($followruninterval != "") {
				$USER->updateFollowRunInterval($followruninterval);
			}
		}
	}

	global $CONTEXTUSER;
	$CONTEXTUSER = $user;

	$in = $user->photo;
	$imagetype = exif_imagetype($in);
	if ($imagetype == IMAGETYPE_JPEG) {
		$image = @imagecreatefromjpeg($in);
	} else if ($imagetype == IMAGETYPE_GIF) {
       $image = @imagecreatefromgif($in);
    } else if ($imagetype == IMAGETYPE_PNG) {
       $image = @imagecreatefrompng($in);
    } else if ($imagetype == IMAGETYPE_BMP) {
       $image = @imagecreatefrombmp($in);
	}

	if (isset($image)) {
	    $imagewidth = imagesx($image);
    	$imageheight = imagesy($image);
	}
?>
<script type="text/javascript">

function getUserFeeds() {
	args = new Object();
	args['userid'] = '<?php echo $user->userid;?>';

	var filter = "Issue,Solution,Pro,Con,Argument,Idea";
	args['filternodetypes'] = filter;
	getNodesFeed(args);
}

</script>

<?php
	if(isset($USER->userid) && $USER->userid == $userid){
		echo '<div class="myhubtitlediv"><h1 class="myhubtitle">'.$LNG->HEADER_MY_HUB_LINK.'</h1></div>';
}?>

<div id="context" class="peoplebackpale" style="float:left;width: 100%;">

	<div id="contextimage" style="padding-top: 5px;"><img style="padding:5px;padding-bottom:0px;float:left;" <?php if (isset($imageheight) && $imageheight > 100) { echo 'height="100"'; } ?> src="<?php print $user->photo;?>"/></div>
	<div id="contextinfo" style="float:left;margin-left:5px;padding-top:10px;">
		<h1><?php print $user->name; ?></h1>

		<div id='followarea'>
		<?php if (isset($USER->userid) && $USER->userid != "" && $USER->userid != $user->userid) {

			/** GETTING USER FROM CACHE MESSES THIS UP WHEN REFRESH AFTER FOLLOW CLICKED, SO GET INFO DIRECTLY **/
			$userfollow = "N";
			$params = array();
			$params[0] = $USER->userid;
			$params[1] = $user->userid;
			$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_FOLLOW, $params);
			if ($resArray !== false) {
				$count = count($resArray);
				if ($count > 0) {
					$userfollow = "Y";
				}
			}

			if ($userfollow == "Y") { ?>
				<div style="float: left; margin-top:5px; margin-bottom:10px;">
					<img style="cursor: pointer" onclick="javascript:unfollowMyUser('<?php echo $user->userid;?>')" border="0" id="follow<?php echo $user->userid; ?>" src="<?php echo $HUB_FLM->getImagePath('following.png'); ?>" alt="<?php echo $LNG->USER_UNFOLLOW_BUTTON; ?>" title="<?php echo $LNG->USER_UNFOLLOW_HINT; ?>"></img>
				</div>
			<?php } else {?>
				<div style="float: left;margin-top:5px; margin-bottom:10px;">
					<img style="cursor: pointer" onclick="javascript:followMyUser('<?php echo $user->userid;?>')" border="0" id="follow<?php echo $user->userid; ?>" src="<?php echo $HUB_FLM->getImagePath('follow.png'); ?>" alt="<?php echo $LNG->USER_FOLLOW_BUTTON; ?>" title="<?php echo $LNG->USER_FOLLOW_HINT; ?>"></img>
				</div>
			<?php }
		}?>
		</div>

		<?php if ($CFG->hasRss && (($USER->userid != "" && $USER->userid != $user->userid) || $USER->userid == "")) { ?>
			<div style="float: left;margin-top:3px; margin-bottom:10px; margin-left:10px;">
				<img class="active" src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" onclick="getUserFeeds()" title="<?php echo $LNG->USER_RSS_HINT; ?> <?php echo $user->name; ?>" alt="<?php echo $LNG->USER_RSS_BUTTON; ?>"/>
			</div>
		<?php } ?>

		<?php if (isset($USER->userid) && $USER->userid != "" && $USER->userid != $user->userid) {
			if ($user->getStatus() == $CFG->USER_STATUS_REPORTED) { ?>
			<div style="float:left;margin-left:10px;margin-top:5px;">
				<img class="active" id="<?php echo $user->userid; ?>" label="<?php echo $user->name; ?>" src="<?php echo $HUB_FLM->getImagePath('spam-reported.png'); ?>" title="<?php echo $LNG->SPAM_USER_REPORTED; ?>" alt="<?php echo $LNG->SPAM_USER_REPORTED_ALT; ?>"/>
			</div>
			<?php } else if ($user->getStatus() == $CFG->USER_STATUS_ACTIVE)  { ?>
			<div style="float:left;margin-left:10px;margin-top:5px;">
				<img class="active" id="<?php echo $user->userid; ?>" label="<?php echo $user->name; ?>" src="<?php echo $HUB_FLM->getImagePath('spam.png'); ?>" onclick="reportUserSpamAlert(this, '<?php echo $user->userid; ?>')" title="<?php echo $LNG->SPAM_USER_REPORT; ?>" alt="<?php echo $LNG->SPAM_USER_REPORT_ALT; ?>"/>
			</div>
			<?php } else { ?>
			<div style="float:left;margin-left:10px;margin-top:5px;">
				<img class="active" src="<?php echo $HUB_FLM->getImagePath('spam-disabled.png'); ?>" title="<?php echo $LNG->SPAM_USER_LOGIN_REPORT; ?>" alt="<?php echo $LNG->SPAM_USER_LOGIN_REPORT_ALT; ?>"/>
			</div>
		<?php } } ?>
	</div>
</div>

<?php
	$args = array();

	$args["userid"] = $user->userid;
	$args["start"] = $start;
	$args["max"] = $max;

	$wasEmpty = false;
	if ($orderby == "") {
		$args["orderby"] = 'date';
		$wasEmpty = true;
	} else {
		$args["orderby"] = $orderby;
	}
	$args["sort"] = $sort;
	$args["q"] = $query;
	$args["title"] = $user->name;

	echo '<div style="float:left;width: 100%; height: 100%;">';
	echo '<div style="clear:both;"></div>';

	displayUserTabs($CFG->USER_CONTEXT,$args, $wasEmpty);

	echo "</div>";

	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>