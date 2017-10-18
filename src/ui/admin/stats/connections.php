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
include_once($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

if($USER->getIsAdmin() != "Y") {
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
	die;
}
?>

<script type="text/javascript">

var context = '<?php echo $CFG->GLOBAL_CONTEXT; ?>';

function init() {
	$("tab-connections-overview").innerHTML = "";

	var nextrow = new Element("div", {'style':'float:left;width:100%'});

	// ISSUES
	var connectedissues = new Element("div", {'style':'float:left; margin-left:10px; margin-top:10px;'});
	var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE; ?>', "Issue", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'issue', '<?php echo $LNG->ISSUES_NAME; ?>', 'mostconnected');
	connectedissues.insert(set);
	nextrow.insert(connectedissues);

	// SOLUTIONS
	var connectedsolutions = new Element("div", {'style':'float:left; margin-left: 10px; margin-top:10px;'});
	var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE; ?>', "Solution", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'solution', '<?php echo $LNG->SOLUTIONS_NAME; ?>', 'mostconnected');
	connectedsolutions.insert(set);
	nextrow.insert(connectedsolutions);

	// PROS
	var connectedevidence = new Element("div", {'style':'float:left; margin-left: 10px; margin-top:10px;'});
	var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_PRO_MOSTCONNECTED_TITLE; ?>', "Pro", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'pro', '<?php echo $LNG->PROS_NAME; ?>', 'mostconnected');
	connectedevidence.insert(set);
	nextrow.insert(connectedevidence);

	// CONS
	var connectedresource = new Element("div", {'style':'float:left; margin-left: 10px; margin-top:10px;'});
	var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_CON_MOSTCONNECTED_TITLE; ?>', "Con", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'con', '<?php echo $LNG->CONS_NAME; ?>', 'mostconnected');
	connectedresource.insert(set);
	nextrow.insert(connectedresource);

	// ARGUMENTS
	var connectedprojects = new Element("div", {'style':'float:left; margin-left: 10px; margin-top:10px;'});
	var set2 = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_ARGUMENT_MOSTCONNECTED_TITLE; ?>', "Argument", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'argument', '<?php echo $LNG->AGUMENTS_NAME; ?>', 'mostconnected');
	connectedprojects.insert(set2);
	nextrow.insert(connectedprojects);

	// COMMENTS
	var connectedorgs = new Element("div", {'style':'float:left; margin-left: 10px; margin-top:10px;'});
	var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_COMMENT_MOSTCONNECTED_TITLE; ?>', "Idea", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'idea', '<?php echo $LNG->COMMENTS_NAME; ?>', 'mostconnected');
	connectedorgs.insert(set);
	nextrow.insert(connectedorgs);

	// CHATS
	var connectedorgs = new Element("div", {'style':'float:left; margin-left: 10px; margin-top:10px;'});
	var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_CHAT_MOSTCONNECTED_TITLE; ?>', "Comment", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'comment', '<?php echo $LNG->CHATS_NAME; ?>', 'mostconnected');
	connectedorgs.insert(set);
	nextrow.insert(connectedorgs);

	$("tab-connections-overview").insert( nextrow );
}

function overviewNodeWidget(context, title, filternodetypes, orderby, sort, count, width, height, buttontitle, key, hinttype, uniqueid, filtertype) {

	if (uniqueid == undefined) {
		uniqueid = 'something';
	}

	var set = new Element("fieldset", {'class':'overviewfieldset', 'style':'width: '+width+'px;'});
	var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});
	legend.insert(title);
	set.insert(legend);
	var main = new Element("div", {'style':'height: '+height+'px; overflow-y: auto; overflow-x: hidden;padding-right:5px;'});
	main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	set.insert(main);

	var args = new Object();
	args['filternodetypes'] = filternodetypes;
	args["start"] = 0;
	args["max"] = count;
	args["orderby"] = orderby;
	args["sort"] = sort;

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  		onSuccess: function(transport){
			try {
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
			} catch(err) {
				console.log(err);
			}

			if(json.nodeset[0].count != 0){
				var nodes = json.nodeset[0].nodes;

				main.innerHTML="";
				displayConnectionStatNodes(main,nodes,parseInt(args['start'])+1, true, uniqueid);
			} else {
				main.innerHTML="";
				main.insert("<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>");
			}
    	}
  	});

	if (buttontitle && buttontitle != "") {
		var allbutton = new Element("a", {'href':'#'+key+'-list', 'class':'active', 'title':'<?php echo $LNG->WIDGET_CLICK_EXPLORE_HINT; ?> '+hinttype, 'style':'clear: both; float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
		allbutton.insert(buttontitle);
		Event.observe(allbutton,'click',function() {

			window.location.href = "<?php echo $CFG->homeAddress; ?>"+"#"+key;
		});
		set.insert(allbutton);
	}

	return set;
}

window.onload = init;

</script>

<div id="tab-connections-overview" class="tabcontentinner"></div>

<div style="clear: both; float: left; margin-top: 20px;" align="center">
<table width="650" cellpadding="2" border="1" style="border-collapse: collapse">

<div style="clear: both; float: left; margin-top: 20px;" align="center">
<table width="650" cellpadding="2" border="1" style="border-collapse: collapse">
<?php

global $DB,$CFG;
$con = $DB->conn;

$sort = optional_param("sort","date",PARAM_ALPHANUM);
$oldsort = optional_param("lastsort","date",PARAM_ALPHANUM);
$direction = optional_param("lastdir","ASC",PARAM_ALPHANUM);

$err = "";
if( ! $con ) {
	$err = mysql_error();
} else {

	$qry = " SELECT
		(Select Node.Name from Node where NodeID = Triple.ToID) as ToName,
		(Select NodeType.Name from NodeType where NodeTypeID = Triple.ToContextTypeID) as ToType,
		(Select Users.Name from Node left Join Users on Node.UserID = Users.UserID where NodeID = Triple.ToID ) as ToAuthor,
		(Select Node.Name from Node where NodeID = Triple.FromID) as FromName,
		(Select NodeType.Name from NodeType where NodeTypeID = Triple.FromContextTypeID) as FromType,
		(Select Users.Name from Node left Join Users on Node.UserID = Users.UserID where NodeID = Triple.FromID ) as FromAuthor,
		LinkType.Label as LinkLabel,
		Triple.CreationDate,
		Users.Name as ConnectionAuthor from Triple
		left join Users on Triple.UserID = Users.UserID
		left join LinkType on Triple.LinkTypeID = LinkType.LinkTypeID
		where LinkType.Label <> '".$CFG->LINK_NODE_THEME."'";

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

		if ($sort == 'from') {
			$qry .= ' ORDER BY FromName '.$direction;
		} else if ($sort == 'date') {
			$qry .= ' ORDER BY Triple.CreationDate '.$direction;
		} else if ($sort == 'to') {
			$qry .= ' ORDER BY ToName '.$direction;
		} else if ($sort == 'totype') {
			$qry .= ' ORDER BY ToType '.$direction;
		} else if ($sort == 'fromtype') {
			$qry .= ' ORDER BY FromType '.$direction;
		} else if ($sort == 'link') {
			$qry .= ' ORDER BY LinkLabel '.$direction;
		} else if ($sort == 'user') {
			$qry .= ' ORDER BY ConnectionAuthor '.$direction;
		} else if ($sort == 'fromuser') {
			$qry .= ' ORDER BY FromAuthor '.$direction;
		} else if ($sort == 'touser') {
			$qry .= ' ORDER BY ToAuthor '.$direction;
		}
	} else {
		$qry .= ' order by Triple.CreationDate DESC';
		$sort='date';
		$direction='DESC';
	}

	echo '<td align="left" valign="bottom" width="10%" class="adminTableHead"><a href="connections.php?&sort=user&lastsort='.$sort.'&lastdir='.$direction.'">Connection Author';
	if ($sort === 'user') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="5%" class="adminTableHead"><a href="connections.php?&sort=date&lastsort='.$sort.'&lastdir='.$direction.'">Date';
	if ($sort === 'date') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="20%" class="adminTableHead"><a href="connections.php?&sort=from&lastsort='.$sort.'&lastdir='.$direction.'">From Idea';
	if ($sort === 'from') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="20%" class="adminTableHead"><a href="connections.php?&sort=fromtype&lastsort='.$sort.'&lastdir='.$direction.'">From Type';
	if ($sort === 'fromtype') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="15%" class="adminTableHead"><a href="connections.php?&sort=fromuser&lastsort='.$sort.'&lastdir='.$direction.'">From Idea Author';
	if ($sort === 'fromuser') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="15%" class="adminTableHead"><a href="connections.php?&sort=link&lastsort='.$sort.'&lastdir='.$direction.'">Link Type';
	if ($sort === 'link') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="20%" class="adminTableHead"><a href="connections.php?&sort=to&lastsort='.$sort.'&lastdir='.$direction.'">To Idea';
	if ($sort === 'to') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="20%" class="adminTableHead"><a href="connections.php?&sort=totype&lastsort='.$sort.'&lastdir='.$direction.'">To Type';
	if ($sort === 'totype') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';
	echo '<td align="left" valign="bottom" width="15%" class="adminTableHead"><a href="connections.php?&sort=touser&lastsort='.$sort.'&lastdir='.$direction.'">To Idea Author';
	if ($sort === 'touser') {
		if ($direction === 'ASC') {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("uparrow.gif").'" width="16" height="8" />';
		} else {
			echo '<img border="0" src="'.$HUB_FLM->getImagePath("downarrow.gif").'" width="16" height="8" />';
		}
	}
	echo '</td>';

	$res = mysql_query( $qry, $con);
	if ($res) {
		while ($array = mysql_fetch_array($res, MYSQL_ASSOC)) {

			$date = $array['CreationDate'];

			echo '<tr>';
				echo '<td valign="top">';
					echo $array['ConnectionAuthor'];
				echo '</td>';

				echo '<td valign="top">';
					echo strftime( '%d %B %Y' ,$date);
				echo '</td>';

				echo '<td valign="top">';
					echo $array['FromName'];
				echo '</td>';

				echo '<td valign="top">';
					echo getNodeTypeText($array['FromType'], false);
				echo '</td>';

				echo '<td valign="top">';
					echo $array['FromAuthor'];
				echo '</td>';

				echo '<td valign="top">';
					echo $array['LinkLabel'];
				echo '</td>';

				echo '<td valign="top">';
					echo $array['ToName'];
				echo '</td>';

				echo '<td valign="top">';
					echo getNodeTypeText($array['ToType'], false);
				echo '</td>';

				echo '<td valign="top">';
					echo $array['ToAuthor'];
				echo '</td>';
			echo '</tr>';
		}
	}
}

?>
</table>
</div>

<?php
include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>