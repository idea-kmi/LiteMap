<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2013-2023 The Open University UK                              *
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
	include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));

	global $DB,$CFG;

	if($USER->getIsAdmin() != "Y") {
		echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
		include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
		die;
	}
	
	$sort = optional_param("sort","date",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","date",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","ASC",PARAM_ALPHANUM);
?>

<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/DataTables/datatables.min.css"); ?>" type="text/css" />
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/DataTables/datatables.js" type="text/javascript"></script>

<script type="text/javascript">
	var context = '<?php echo $CFG->GLOBAL_CONTEXT; ?>';

	function init() {
		$("tab-connections-overview").innerHTML = "";

		var nextrow = new Element("div", {'class':'d-flex flex-row mt-4 gap-2 align-items-stretch'});
		$("tab-connections-overview").insert( nextrow );

		// ISSUES
		var connectedissues = new Element("div", {'class':'col'});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE; ?>', "Issue", 'connectedness', 'DESC', '5', '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'issue', '<?php echo $LNG->ISSUES_NAME; ?>', 'mostconnected');
		connectedissues.insert(set);
		nextrow.insert(connectedissues);

		// SOLUTIONS
		var connectedsolutions = new Element("div", {'class':'col'});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE; ?>', "Solution", 'connectedness', 'DESC', '5', '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'solution', '<?php echo $LNG->SOLUTIONS_NAME; ?>', 'mostconnected');
		connectedsolutions.insert(set);
		nextrow.insert(connectedsolutions);

		var nextrow = new Element("div", {'class':'d-flex flex-row mt-4 gap-2 align-items-stretch'});
		$("tab-connections-overview").insert( nextrow );

		// PROS
		var connectedevidence = new Element("div", {'class':'col'});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_PRO_MOSTCONNECTED_TITLE; ?>', "Pro", 'connectedness', 'DESC', '5', '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'pro', '<?php echo $LNG->PROS_NAME; ?>', 'mostconnected');
		connectedevidence.insert(set);
		nextrow.insert(connectedevidence);

		// CONS
		var connectedresource = new Element("div", {'class':'col'});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_CON_MOSTCONNECTED_TITLE; ?>', "Con", 'connectedness', 'DESC', '5', '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'con', '<?php echo $LNG->CONS_NAME; ?>', 'mostconnected');
		connectedresource.insert(set);
		nextrow.insert(connectedresource);

		var nextrow = new Element("div", {'class':'d-flex flex-row mt-4 gap-2 align-items-stretch'});
		$("tab-connections-overview").insert( nextrow );

		// ARGUMENTS
		var connectedprojects = new Element("div", {'class':'col'});
		var set2 = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_ARGUMENT_MOSTCONNECTED_TITLE; ?>', "Argument", 'connectedness', 'DESC', '5', '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'argument', '<?php echo $LNG->AGUMENTS_NAME; ?>', 'mostconnected');
		connectedprojects.insert(set2);
		nextrow.insert(connectedprojects);

		// COMMENTS
		var connectedorgs = new Element("div", {'class':'col'});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_COMMENT_MOSTCONNECTED_TITLE; ?>', "Idea", 'connectedness', 'DESC', '5', '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'idea', '<?php echo $LNG->COMMENTS_NAME; ?>', 'mostconnected');
		connectedorgs.insert(set);
		nextrow.insert(connectedorgs);

		var nextrow = new Element("div", {'class':'d-flex flex-row mt-4 gap-2 align-items-stretch'});
		$("tab-connections-overview").insert( nextrow );

		// CHATS
		var connectedorgs = new Element("div", {'class':'col'});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_CHAT_MOSTCONNECTED_TITLE; ?>', "Comment", 'connectedness', 'DESC', '5', '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'comment', '<?php echo $LNG->CHATS_NAME; ?>', 'mostconnected');
		connectedorgs.insert(set);
		nextrow.insert(connectedorgs);

	}

	function overviewNodeWidget(context, title, filternodetypes, orderby, sort, count, buttontitle, key, hinttype, uniqueid, filtertype) {

		if (uniqueid == undefined) {
			uniqueid = 'something';
		}

		var set = new Element("fieldset", {'class':'overviewfieldset'});
		var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});
		legend.insert(title);
		set.insert(legend);
		var main = new Element("div", {'style':'height: 300px; overflow-y: auto; overflow-x: hidden; padding-right: 5px;'});
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
			var allbutton = new Element("a", {'href':'#'+key+'-list', 'class':'active', 'title':'<?php echo $LNG->WIDGET_CLICK_EXPLORE_HINT; ?> '+hinttype, 'style':''});
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

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">
			<?php
				if (file_exists("menu.php") ) {
					include("menu.php");
				}
			?>

			<div id="tab-connections-overview" class="tabcontentinner mb-3"></div>

			<?php
				$con = $DB->conn;

				$err = "";
				if( ! $con ) {
					$err = mysql_error();
				} else {

					$qry = "SELECT
						(SELECT Node.Name FROM Node WHERE NodeID = Triple.ToID) AS ToName,
						(SELECT NodeType.Name FROM NodeType WHERE NodeTypeID = Triple.ToContextTypeID) AS ToType,
						(SELECT Users.Name FROM Node LEFT JOIN Users ON Node.UserID = Users.UserID WHERE NodeID = Triple.ToID ) AS ToAuthor,
						(SELECT Node.Name FROM Node WHERE NodeID = Triple.FromID) AS FromName,
						(SELECT NodeType.Name FROM NodeType WHERE NodeTypeID = Triple.FromContextTypeID) AS FromType,
						(SELECT Users.Name FROM Node LEFT JOIN Users ON Node.UserID = Users.UserID WHERE NodeID = Triple.FromID ) AS FromAuthor,
						LinkType.Label AS LinkLabel,
						Triple.CreationDate,
						Users.Name AS ConnectionAuthor FROM Triple
						LEFT JOIN Users ON Triple.UserID = Users.UserID
						LEFT JOIN LinkType ON Triple.LinkTypeID = LinkType.LinkTypeID";

						$qry .= ' ORDER BY Triple.CreationDate DESC';
						$sort='date';
						$direction='DESC';
				}
			?>

			<div class="adminTableDiv my-5">			
				<table class="table table-sm table-striped table-hover compact dataTable" id="adminTableDiv">
					<thead class="table-light">
						<tr class="align-middle">
							<th style="min-width: 200px;">Connection Author</th>
							<th style="min-width: 100px;">Date</th>
							<th style="max-width: 500px;">From Idea</th>
							<th>From Type</th>
							<th style="min-width: 200px;">From Idea Author</th>
							<th>Link Type</th>
							<th style="max-width: 500px;">To Idea</th>
							<th>To Type</th>
							<th style="min-width: 200px;">To Idea Author</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$err = "";
							if( ! $con ) {
								$err = mysql_error();
							} else {
								$resArray = $DB->SELECT($qry, []);
								if ($resArray !== false) {
									$count = (is_countable($resArray)) ? count($resArray) : 0;
									for ($i=0; $i < $count; $i++) {
										$array = $resArray[$i];
										$date = $array['CreationDate'];
										$prettydate = date( 'd M Y', $date); 
									?>

										<tr>
											<td valign="top">
												<?php echo $array['ConnectionAuthor']; ?>
											</td>
											<td valign="top" data-search="<?= $prettydate ?>" data-order="<?= $date ?>">
												<?= $prettydate ?>
											</td>
											<td valign="top">
												<?php echo $array['FromName']; ?>
											</td>
											<td valign="top">
												<?php echo getNodeTypeText($array['FromType'], false); ?>
											</td>
											<td valign="top">
												<?php echo $array['FromAuthor']; ?>
											</td>
											<td valign="top">
												<?php echo $array['LinkLabel']; ?>
											</td>
											<td valign="top">
												<?php echo $array['ToName']; ?>
											</td>
											<td valign="top">
												<?php echo getNodeTypeText($array['ToType'], false); ?>
											</td>
											<td valign="top">
												<?php echo $array['ToAuthor']; ?>
											</td>
										</tr>

									<?php }
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery.noConflict();
	jQuery(document).ready(function($) {
		$('#adminTableDiv').DataTable({
			"autoWidth": true,
			"responsive": true,
			"pageLength": 25,
        	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"columnDefs": [
				{ "orderable": false, "targets": 0 }
			],
			"order": [[5, "desc"]]
		});
	});
</script>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>
