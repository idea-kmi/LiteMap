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
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
include_once($HUB_FLM->getCodeDirPath("core/statslib.php"));

$me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
if ($HUB_FLM->hasCustomVersion($me)) {
	$path = $HUB_FLM->getCodeDirPath($me);
	include_once($path);
	die;
}

array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='screen' />");
array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='screen' />");

array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/users.js.php")."' type='text/javascript'></script>");

include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

$userid = optional_param("userid",$USER->userid,PARAM_ALPHANUMEXT);
$user = getUser($userid,'long');

$sort = optional_param("sort","vote",PARAM_ALPHANUM);
$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
$direction = optional_param("lastdir","DESC",PARAM_ALPHANUM);

if($user instanceof Error){
	echo "<h1>User not found</h1>";
	include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
	die;
}

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
<div id="context" class="peoplebackpale" style="float:left;width: 100%;">
	<div id="contextimage" style="float:left;"><img style="padding:5px;padding-bottom:0px;float:left;" <?php if (isset($imageheight) && $imageheight > 100) { echo 'height="100"'; } ?> src="<?php print $user->photo;?>"/></div>
	<div id="contextinfo" style="float:left;margin-left:5px;">
		<h1><?php echo $LNG->STATS_USER_TITLE." ".$user->name; ?></h1>
	</div>
</div>
<div style="clear:both;"></div>


<!-- DATABASE QRY AREA -->
<?php
global $CFG;

$totalvotes = getTotalVotesForUser($userid);
$allNodeVotes = getAllVotingForUser($userid, $direction, $sort, $oldsort);

/** NODE TYPES used on IDEAS **/
$nodeArray = getNodeTypesForUser($userid);
reset($nodeArray);
$popnodetype = key($nodeArray);

?>

<script type="text/javascript">
   	var conns = null;
   	var brokerConns = null;

   	function init() {}

	/**
	 * draw a connection
	 */
	function renderThisConnection(connection,uniQ, includemenu){

		if (includemenu === undefined) {
			includemenu = true;
		}

		if (connection.userid == null) {
			return;
		}

		uniQ = connection.connid + uniQ;

		var connDiv = new Element("div",{'class': 'connection'});

		var fromDiv = new Element("div",{'class': 'fromidea-horiz'});
		var fromNode = renderNodeFromLocalJSon(connection.from,'conn-from-idea'+uniQ, connection.fromrole, includemenu);
		fromDiv.insert(fromNode).insert('<div style="clear:both;"></div>');
		connDiv.insert(fromDiv);

		var linktypelabelfull = connection.linktype.label;
		var linktypelabel = linktypelabelfull;

		var linkDiv = new Element("div",{'class': 'connlink-horiz-slim','id': 'connlink'+connection.connid});
		linkDiv.setStyle('background-image: url("'+URL_ROOT +'images/conn-'+connection.linktype.grouplabel.toLowerCase()+'-slim3.png")');
		var ltDiv = new Element("div",{'class': 'conn-link-text'});

		linkDiv.insert(ltDiv);

		var ltWrap = new Element("div",{'class': 'link-type-wrapper'});
		ltDiv.insert(ltWrap);

		var ltText = new Element("div",{'class':'link-type-text'}).insert(linktypelabel);
		ltWrap.insert(ltText);
		// set colour of ltText
		if (connection.linktype.grouplabel.toLowerCase() == "positive"){
			ltText.setStyle({"color":"#00BD53"});
		} else if (connection.linktype.grouplabel.toLowerCase() == "negative"){
			ltText.setStyle({"color":"#C10031"});
		} else if (connection.linktype.grouplabel.toLowerCase() == "neutral"){
			ltText.setStyle({"color":"gray"});
		}

		ltText.style.width="140px";

		var iuDiv = new Element("div");
		iuDiv.style.marginLeft='100px';
		iuDiv.style.marginTop="3px";
		var imagelink = new Element('a', {
			'href':URL_ROOT+"user.php?userid="+connection.users[0].userid,
			'title':connection.users[0].name});
		imagelink.target = "_blank";
		var userimageThumb = new Element('img',{'title': connection.users[0].name, 'style':'padding-right:5px;','border':'0','src': connection.users[0].thumb});
		imagelink.insert(userimageThumb);
		iuDiv.insert(imagelink);
		linkDiv.insert(iuDiv);

		connDiv.insert(linkDiv);

		var toDiv = new Element("div",{'class': 'toidea-horiz'});
		var toNode = renderNodeFromLocalJSon(connection.to,'conn-to-idea'+uniQ, connection.torole, includemenu);

		toDiv.insert(toNode).insert('<div style="clear:both;"></div>');
		connDiv.insert(toDiv);

		return connDiv;
	}

   	window.onload = init;

</script>


<!-- DISPLAY AREA -->

<div style="float:left;">
	<h3><?php echo $LNG->STATS_USER_SUMMARY_TITLE; ?></h3>

	<table cellspacing="2" cellpadding="3" style="border-collapse:collapse;" width="500">
		<tr class="challengeback" style="color:white">
			<td width="30%"><b><?php echo $LNG->STATS_USER_NAME_HEADING; ?></b></td>
			<td width="30%"><b><?php echo $LNG->STATS_USER_ITEM_HEADING; ?></b></td>
			<td align="right" width="10%"><b><?php echo $LNG->STATS_USER_COUNT_HEADING; ?></b></td>
			<td align="right" width="10%"><b><?php echo $LNG->STATS_USER_ACTION_HEADING; ?></b></td>
		</tr>
		<tr>
			<td colspan="4" valign="top" style="border-top: 1px solid #666666 "></td>
		</tr>
		<tr>
			<td valign="top" style="color: #666666 "><?php echo $LNG->STATS_USER_POPULAR_NODE_HEADING; ?></td>
			<td valign="top"><?php echo getNodeTypeText($popnodetype, false); ?></td>
			<td valign="top" align="right"><?php echo $nodeArray[$popnodetype]; ?></td>
			<td valign="top" align="right"><a href="#nodetypes"><?php echo $LNG->STATS_USER_VIEW_ALL; ?></a></td>
		</tr>


		<tr>
			<td valign="top" style="color: #666666 "><?php echo $LNG->STATS_USER_VOTE_TITLE; ?></td>
			<td valign="top">
				<b style="color:green"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></b>: <?php echo $totalvotes[0]['up']; ?>
				<b style="color:red;margin-left:20px;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></b>: <?php echo $totalvotes[0]['down']; ?>
			</td>
			<td valign="top" align="right"><?php echo $totalvotes[0]['vote']; ?></td>
			<td valign="top" align="right"><a href="#allvotes"><?php echo $LNG->STATS_USER_VIEW_ALL; ?></a></td>
		</tr>
	</table>
<br>
	<!-- NODE TYPES used on Ideas -->
	<a name="nodetypes"></a>
	<h3><?php echo $LNG->STATS_USER_NODE_TYPES_HEADING; ?></h3>
	<table cellspacing="2" cellpadding="3" style="border-collapse:collapse;" width="300">
		<tr class="challengeback" style="color:white">
			<td width="40%"><b><?php echo $LNG->STATS_USER_NAME_HEADING; ?></b></td>
			<td align="right" width="20%"><b><?php echo $LNG->STATS_USER_COUNT_HEADING; ?></b></td>
		</tr>
		<tr>
			<td colspan="2" valign="top" style="border-top: 1px solid #666666 "></td>
		</tr>

		<?php foreach($nodeArray as $n=>$c) { ?>
			<tr>
				<td style="color: #666666 "><?php echo getNodeTypeText($n, false) ?></td>
				<td align="right"><?php echo $c ?></td>
			</tr>
		<?php } ?>
	</table>
<br>
	<!-- ALL VOTES -->
	<a name="allvotes"></a>
	<table cellpadding="5" style="border-collapse:collapse;width:100%" width="100%">
		<tr>
			<td valign="top" align="left">
				<h3>
				<a style="margin-right:10px;" href="#top"><img title="<?php echo $LNG->STATS_GLOBAL_VOTES_BACK_UP; ?>" border="0" src="<?php echo $HUB_FLM->getImagePath('arrow-up2.png'); ?>" /></a>
				<?php echo $LNG->STATS_GLOBAL_VOTES_ALL_VOTING_TITLE; ?></h3>
				<table border="1" cellpadding="5" style="float:left; border-collapse:collapse;width:100%" width="100%">
					<tr style="background:#D8D8D8">
						<?php echo '<td align="left" valign="bottom" width="15%" class="adminTableHead"><a href="votes.php?&sort=NodeType&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING.'</b>';
						if ($sort === 'NodeType') {
							if ($direction === 'ASC') {
								echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
							} else {
								echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
							}
						}
						echo '</td>';
						echo '<td align="left" valign="bottom" width="55%" class="adminTableHead"><a href="votes.php?&sort=Name&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING.'</b>';
						if ($sort === 'Name') {
							if ($direction === 'ASC') {
								echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
							} else {
								echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
							}
						}
						echo '</td>';
						echo '<td align="left" valign="bottom" width="10%" class="adminTableHead"><a href="votes.php?&sort=up&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING.'</b>';
						if ($sort === 'up') {
							if ($direction === 'ASC') {
								echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
							} else {
								echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
							}
						}
						echo '</td>';
						echo '<td align="left" valign="bottom" width="10%" class="adminTableHead"><a href="votes.php?&sort=down&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING.'</b>';
						if ($sort === 'down') {
							if ($direction === 'ASC') {
								echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
							} else {
								echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
							}
						}
						echo '</td>';
						echo '<td align="left" valign="bottom" width="10%" class="adminTableHead"><a href="votes.php?&sort=vote&lastsort='.$sort.'&lastdir='.$direction.'#allvotes">'.$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING.'</b>';
						if ($sort === 'vote') {
							if ($direction === 'ASC') {
								echo '<img border="0" src="../../images/uparrow.gif" width="16" height="8" />';
							} else {
								echo '<img border="0" src="../../images/downarrow.gif" width="16" height="8" />';
							}
						}
						echo '</td>';
						?>
					</tr>
					<?php
						//error_log(print_r($allNodeVotes, true));
						$allvotenodes = $allNodeVotes->nodes;
						$count = count($allvotenodes);
						for ($i=0; $i<$count; $i++) {
							$n = $allvotenodes[$i];
							$nodetype = $n->role->name;
							$title = $n->name;
							?>
							<tr>
								<td align="left"><?php echo getNodeTypeText($nodetype, false); ?></td>
								<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
								<td align="right"><span style="color: green"><?php echo $n->up ?></span></td>
								<td align="right"><span style="color: red"><?php echo $n->down ?></span></td>
								<td align="right"><b><?php echo $n->vote ?></b></td>
							</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>
	</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>
