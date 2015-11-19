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
	$filternodetypes = required_param("filternodetypes", PARAM_TEXT);

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
	var dataurl = '<?php echo $dataurl; ?>'+'&filternodetypes='+encodeURIComponent('<?php echo $filternodetypes; ?>');

	function getNodes(){
		new Ajax.Request(dataurl, { method:'post',
	  			onSuccess: function(transport){
	  				var json = transport.responseText.evalJSON();
	     			if(json.error){
	      				alert(json.error[0].message);
	      				return;
	      			}

					$("printnodes").innerHTML = "";

					if(json.nodeset[0].nodes.length > 0) {
						var lOL = displayReportNodes($("printnodes"), json.nodeset[0].nodes, 1);
					}
	       		}
	      	});
   }

    /**
     *  set which tab to show and load first
     */
    Event.observe(window, 'load', function() {
	    $('dialogheader').insert('<?php echo $title; ?>');
        getNodes();
    });
//]]>
</script>
<br>
<input style="margin-left: 10px;" type="button" id="btnPrint" value=" <?php echo $LNG->FORM_BUTTON_PRINT_PAGE; ?> " onclick="window.print();return false;" />

<div id="printnodes" style="margin: 10px; padding-bottom: 10px;">
<div class="loading"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/>(<?php echo $LNG->LOADING_ITEMS; ?>...)</div><br><center><?php echo $LNG->LOADING_MESSAGE_PRINT_NODE; ?></center></div>
</div>

</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>