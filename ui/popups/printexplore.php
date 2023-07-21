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
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/node.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/users.js.php")."' type='text/javascript'></script>");

    array_push($HEADER,"<script src='".$CFG->homeAddress."ui/lib/dateformat.js' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/headerreport.php"));

    $dataurl = required_param("url", PARAM_URL);
    $title = required_param("title", PARAM_TEXT);
    $nodeid = required_param("nodeid", PARAM_ALPHANUMEXT);
    $context = optional_param("context", "", PARAM_TEXT);
 ?>
<style type="text/css">
 @media print {
 input#btnPrint {
 display: none;
 }
 }
</style>
<script type="text/javascript">
//<![CDATA[
var dataurl = "<?php echo $dataurl; ?>";
var nodeid = "<?php echo $nodeid; ?>";

function getNode(){

	new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				$("printexplore").innerHTML = "";

				if(json.cnode[0]) {
					var node = json.cnode[0];
					var user = node.users[0].user;
					var role = node.role[0].role.name;
					var nodeid = node.nodeid;

					var creationdate = node.creationdate;
					var description = node.description;

					var username = user.name;
					var userid = user.userid;
					var userimage = user.thumb;

					var explorelink = new Element("a", {'class':'active', 'style':'text-decoration: none'});
					explorelink.href = "<?php echo $CFG->homeAddress; ?>explore.php?id="+nodeid;
					explorelink.insert("<?php echo $title; ?>");

					$("innertitle").insert(explorelink);

					var innerwidgetBody = new Element("div", {'id':'innerwidgetnodebody'});
					innerwidgetBody.style.marginBottom = "15px";
					innerwidgetBody.style.marginTop = "15px";

					var userbar = new Element("div", {'style':'clear:both;'} );
					var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
					var userimageThumb = new Element('img',{'alt':username, 'title': username, 'style':'padding-right:5px;', 'border':'0','src': userimage});
					var imagelink = new Element('a', {
						'href':URL_ROOT+"user.php?userid="+userid,
						'title':username});
					imagelink.insert(userimageThumb);
					iuDiv.update(imagelink);
					userbar.appendChild(iuDiv);

					var iuDiv = new Element("div", {'style':''});
					var cDate = new Date(creationdate*1000);
					iuDiv.insert("<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>");
					iuDiv.insert('<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>'+username+'<br/>');
					userbar.insert(iuDiv);

					innerwidgetBody.appendChild(userbar);

					if (description && description != "") {
						innerwidgetBody.insert('<div style="clear:both;float:left;margin-top:5px;"><b>Description: </b><br><div class="idea-desc">'+description+'</div></div>');
					}

					$('printexplore').update(innerwidgetBody);

					loadMapData(role);
				}
			}
		});
}

function loadMapData(role) {
	var reqUrl = SERVICE_ROOT + "&method=getmapsfornode&style=long";
	reqUrl += "&orderby=date&sort=DESC&start=0&max=-1&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var nodes = json.nodeset[0].nodes;
			if (nodes.length > 0) {
				$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;"><?php echo $LNG->MAPS_NAME; ?></h2>');
				displayReportNodes($('printexplore'),nodes,parseInt(0), true);
			}
			loadFollowers(role);
		}
	});

	return widgetDiv;
}

function loadFollowers(role) {
	var reqUrl = SERVICE_ROOT + "&method=getusersbyfollowing&itemid="+nodeid;
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var users = json.userset[0].users;

			if (users.length > 0) {
				$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;"><?php echo $LNG->FORM_PRINT_FOLLOWERS_HEADING; ?></h2>');
				displayReportUsers($('printexplore'),users,parseInt(0));
			}

			$("loadingdiv").innerHTML = "";
		}
	});
}

/**
*  set which tab to show and load first
*/
Event.observe(window, 'load', function() {
	getNode();
});
//]]>
</script>

<h1 id="innertitle" style="clear:both; margin:10px;text-align:center;"></h1>

<input style="margin-left: 10px;margin-bottom:10px;" type="button" id="btnPrint" value=" <?php echo $LNG->FORM_BUTTON_PRINT_PAGE; ?> " onclick="window.print();return false;" />

<div id="printexplore" style="margin: 10px;"></div>

<div id="loadingdiv" class="loading" style="clear:both; float:left"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_DATA; ?><br><center><?php echo $LNG->FORM_PRINT_LOADING_MESSAGE; ?></center></div>

</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>