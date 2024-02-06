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
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/widget.js.php').'" type="text/javascript"></script>');

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

    $nodeid = required_param("nodeid", PARAM_ALPHANUMEXT);
 ?>

<script type="text/javascript">
//<![CDATA[
	var nodeid = '<?php echo $nodeid; ?>';

	function getNode(){
		var reqUrl = SERVICE_ROOT + "&method=getnode&nodeid=" + nodeid;
		new Ajax.Request(reqUrl, { method:'get',
	  			onSuccess: function(transport){
	  				var json = transport.responseText.evalJSON();
	     			if(json.error){
	      				alert(json.error[0].message);
	      				return;
	      			}
	     			var node = json.cnode[0];
	     			node.role = node.role[0].role;
	     			node.users[0] = node.users[0].user;

	     			var type = "issue";
	     			var border = 'issueborder';
	     			var nodekey = "Node"+node.nodeid;
	     			var key = "Node"+node.nodeid;
	     			var color = "";
	     			var height = "400";

					var creationdate = node.creationdate;
					var positivevotes = node.positivevotes;
					var negativevotes = node.negativevotes;
					var userimage = node.users[0].thumb;
					var nodeid = node.nodeid;
					var name = node.name;
					if (type == 'web') {
						name = node.description;
					}

					var username = node.users[0].name;
					var userid = node.users[0].userid;
					var userfollow = node.userfollow;
					var nodetype = node.role.name;
					var title=getNodeTitleAntecedence(nodetype);

					var widgetDiv = new Element("div", {'class':'widgetdivnode', 'id':key+'div'});
					widgetDiv.style.height = "0px";
					var widgetBody = new Element("div", {'class':'widgetnodebody', 'id':key+'body'});
					widgetBody.style.height = "0px";

					var innerwidgetBody = new Element("div", {'id':key+'innerbody', 'class':'widgetbody', 'style':'padding-top:0px;'});
					innerwidgetBody.style.height = "0px";

					var userbar = new Element("div", {'style':'clear:both;'} );
					var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
					var userimageThumb = new Element('img',{'alt':username, 'title': username, 'style':'padding-right:5px;', 'border':'0','src': userimage});

					var imagelink = new Element('a', {'href':URL_ROOT+"user.php?userid="+userid, 'title':username});

					imagelink.insert(userimageThumb);
					iuDiv.update(imagelink);
					userbar.appendChild(iuDiv);

					var iuDiv = new Element("div", {'style':''});
					var cDate = new Date(creationdate*1000);
					iuDiv.insert("<b>Added on: </b>"+ cDate.format(DATE_FORMAT) + "<br/>");
					iuDiv.insert('<b>Added by: </b>'+username+'<br/>');
					userbar.insert(iuDiv);

					innerwidgetBody.appendChild(userbar);

					if (node.startdatetime && node.startdatetime != "" && node.role.name == 'Project') {
						var sDate = new Date(node.startdatetime*1000);
						innerwidgetBody.insert('<br /><b>Started on: </b>'+sDate.format(DATE_FORMAT_PROJECT)+'<br>');
						if (node.enddatetime && node.enddatetime != "") {
							var eDate = new Date(node.enddatetime*1000);
							innerwidgetBody.insert('<b>Ended on: </b>'+eDate.format(DATE_FORMAT_PROJECT)+'<br>');
						}
					}

					if (node.identifier && node.identifier != "" && node.role.name == 'Publication') {
						innerwidgetBody.insert('<b>DOI: </b><span>'+node.identifier+'</span><br>');
					}
					if (node.locationaddress1 && node.locationaddress1 != "") {
						innerwidgetBody.insert('<br /><span style="float:left;font-weight:bold;width:83px;">Address1: </span><span>'+node.locationaddress1+'</span>');
					}
					if (node.locationaddress2 && node.locationaddress2 != "") {
						innerwidgetBody.insert('<br /><span style="float:left;font-weight:bold;width:83px;">Address2: </span><span>'+node.locationaddress2+'</span>');
					}
					if (node.location && node.location != "") {
						innerwidgetBody.insert('<br /><span style="float:left;font-weight:bold;width:83px;">City: </span><span>'+node.location+'</span>');
					}
					if (node.locationpostcode && node.locationpostcode != "") {
						innerwidgetBody.insert('<br /><span style="float:left;font-weight:bold;width:83px;">Postal Code: </span><span>'+node.locationpostcode+'</span>');
					}
					if (node.country && node.country != "") {
						innerwidgetBody.insert('<br /><span style="float:left;font-weight:bold;width:83px;">Country: </span><span>'+node.country+'</span><br>');
					}

					// add url if a resource node
					if (type == 'web') {
						innerwidgetBody.insert('<br><span style="margin-right:5px;"><b>Url: </b></span>');
						var link = new Element("a", {'href':node.name,'target':'_blank','title':'View site'} );
						link.insert(node.name);
						innerwidgetBody.insert(link);

						if (node.urls && node.urls.length > 0) {
							var hasClips = false;
							var iUL = new Element("ul", {});
							for (var i=0 ; i< node.urls.length; i++){
								if (node.urls[i].clip && node.urls[i].clip != "") {
									var link = new Element("li");
									link.insert(node.urls[i].clip);
									iUL.insert(link);
									hasClips = true;
								}
							}

							if (hasClips) {
								innerwidgetBody.insert('<br><span style="margin-right:5px;"><b>Clips: </b></span><br>');
							}

							innerwidgetBody.insert(iUL);
						}
					}

					if (node.description != "" && type != 'web') {
						innerwidgetBody.insert('<br /><b>Description: </b><br><span>'+node.description+'</span>');
					}

					widgetBody.insert(innerwidgetBody);
					widgetDiv.insert(widgetBody);

                    $('nodedetails').update(nodediv);
	       		}
	      	});
   }

    /**
     *  set which tab to show and load first
     */
    Event.observe(window, 'load', function() {
	    $('dialogheader').insert('Description');
        getNode();

    });
//]]>
</script>
</div>
<div id="nodedetails" style="margin: 10px; display:block; height:400px;width:400px;"></div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>