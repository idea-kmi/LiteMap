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
 *  are disitemed. In no event shall the copyright owner or contributors be    *
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

	checkLogin();
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/lib/scriptaculous/scriptaculous.js")."' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

	$filternodetypes = required_param("filternodetypes",PARAM_TEXT);
	$handler = optional_param("handler","addSelectedNode",PARAM_TEXT);
	$focalnodeid = optional_param("focalnodeid","",PARAM_ALPHANUMEXT);
	$num = optional_param("num", -1, PARAM_INT);
?>

<script type="text/javascript">

	var sratedLoading = false;
	var filternodetypes = '<?php echo $filternodetypes; ?>';

   	function init(){
   		var title = '<?php echo $LNG->FORM_SELECTOR_TITLE_DEFAULT; ?>';
		if (filternodetypes == EVIDENCE_TYPES_STR) {
  			title = '<?php echo $LNG->FORM_SELECTOR_TITLE_EVIDENCE; ?>';
   		} else if (filternodetypes == 'Issue') {
  			title = '<?php echo $LNG->FORM_SELECTOR_TITLE_ISSUE; ?>';
   		} else if (filternodetypes == 'Challenge') {
  			title = '<?php echo $LNG->FORM_SELECTOR_TITLE_CHALLENGE; ?> ';
   		} else if (filternodetypes == 'Solution') {
  			title = '<?php echo $LNG->FORM_SELECTOR_TITLE_SOLUTION; ?>';
   		} else if (filternodetypes == 'Idea') {
  			title = '<?php echo $LNG->FORM_SELECTOR_TITLE_COMMENT; ?>';
   		}

   		// need to run through converter so the types get converted.

    	$('dialogheader').insert(title);

		loadPickerNodes('<?php echo($USER->userid); ?>', 0, 10);
	}

	/**
	* Process the selection from the list.
	*/
	function loadSelecteditem(node) {
        if (window.opener.<?php echo $handler;?>) {
        	<?php if ($num > -1) { ?>
    			window.opener.<?php echo $handler; ?>(node, '<?php echo $num; ?>');
        	<?php } else if ($focalnodeid != "") { ?>
    			window.opener.<?php echo $handler; ?>(node, '<?php echo $focalnodeid; ?>');
    		<?php } else { ?>
    			window.opener.<?php echo $handler; ?>(node);
    		<?php } ?>
        }
        window.close();
	}

	/**
	 * Check to see if the enter key was pressed.
	 */
	function pickerSearchKeyPressed(evt) {
		var event = evt || window.event;
		var thing = event.target || event.srcElement;

		var characterCode = document.all? window.event.keyCode:event.which;
		if(characterCode == 13) {
			runPickerSearch('0', '10')
		}
	}

   	function runPickerSearch(start, max) {

		$("item-search-list").innerHTML = "";
		var search = $('itemsearch').value;
	   	var reqUrl = SERVICE_ROOT + "&method=getnodesbyglobal&q="+search+"&scope=all&start="+start+"&max="+max+"&filternodetypes="+filternodetypes;

       	new Ajax.Request(reqUrl, { method:'get',
    	   		onError:  function(error) {
    	   			alert("<?php echo $LNG->FORM_SELECTOR_SEARCH_ERROR; ?>");
       			},
    	   		onSuccess: function(transport){
                   var json = transport.responseText.evalJSON();
                   if(json.error){
                       alert(json.error[0].message);
                       return;
                   }

                   $('search-item-list-count').innerHTML = "";
                   $('search-item-list-count').insert(json.nodeset[0].totalno);

	   				if(json.nodeset[0].nodes.length > 0){
	   					var total = json.nodeset[0].totalno;
	   					$("item-search-list").insert(createNav(total, json.nodeset[0].count, start, max, "search"));
	   					displayPickerNodes($("item-search-list"),json.nodeset[0].nodes,1, true);
	   				} else {
                  		$("item-search-list").innerHTML = "<div style='margin-top:5px;'>No matching results found</div>";
	   				}

	   				viewSearch();
               }
        });
   }

   /**
    *	load user nodes
    */
   function loadPickerNodes(userid, start, max){
	    $("item-idea-list").innerHTML = "";

   		var reqUrl = SERVICE_ROOT + "&method=getnodesbyuser&filternodetypes="+filternodetypes+"&userid="+userid+"&start="+start+"&max="+max;
   		new Ajax.Request(reqUrl, { method:'get',
     			onSuccess: function(transport){

     				try {
     					var json = transport.responseText.evalJSON();
     				} catch(err) {
     					console.log(err);
     				}

         			if(json.error){
         				alert(json.error[0].message);
         				return;
         			}

          			$('node-item-list-count').innerHTML = "";
          			$('node-item-list-count').insert(json.nodeset[0].totalno);

	   				if(json.nodeset[0].nodes.length > 0){
	   					var total = json.nodeset[0].totalno;

	   					$("item-idea-list").insert(createNav(total, json.nodeset[0].count, start, max, "node"));

	   					displayPickerNodes($("item-idea-list"),json.nodeset[0].nodes,1, false);
	   				} else {
	   					$("item-idea-list").insert("<?php echo $LNG->FORM_SELECTOR_NOT_ITEMS; ?>");
	   				}
       		}
   		});
   	}

    /**
	 * Render a list of nodes
	 */
	function displayPickerNodes(objDiv,nodes,start, includeUser){
		objDiv.insert('<div style="clear:both; margin: 0px; padding: 0px;"></div>');
		var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol', 'style':'overflow-y: auto; overflow-x: hidden; height: 410px;'});
		for(var i=0; i< nodes.length; i++){
			if(nodes[i].cnode){
				var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'padding-bottom: 5px;'});
				lOL.insert(iUL);
				var blobDiv = new Element("div", {'style':'margin: 2px; width: 335px'});

				var blobNode = renderPickerNode(nodes[i].cnode, nodes[i].cnode.role[0].role,includeUser);
				blobDiv.insert(blobNode);
				iUL.insert(blobDiv);
			}
		}
		objDiv.insert(lOL);
	}

	/**
	 * display Nav
	 */
	function createNav(total, count, start, max, type){

   	   var nav = new Element ("div",{'id':'page-nav', 'class':'toolbarrow', 'style':'padding-top: 3px;'});

   	   var header = createNavCounter(total, start, count);
   	   nav.insert(header);

   	   var clearnav = new Element ("div",{'style':'clear: both; margin: 3px; height: 3px;'});
   	   nav.insert(clearnav);

   	   if (total > parseInt( max )) {
   	   		//previous
   	   	    var prevSpan = new Element("span", {'id':"nav-previous"});
   	   	    if(start > 0){
   	   			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' alt='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-left2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        prevSpan.addClassName("active");
   	   	        Event.observe(prevSpan,"click", function(){
   	   		    	var newArr = {"max":max, "start":start};
   	   	            newArr["start"] = parseInt(start) - newArr["max"];
   	   	            if (type=="node") {
   	   	            	loadPickerNodes('<?php echo($USER->userid); ?>', newArr["start"], newArr["max"])
   	   	            } else if (type=="search") {
   	   	            	runPickerSearch(newArr["start"], newArr["max"]);
   	   	            }
   	   	        });
   	   	    } else {
   	   			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' alt='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' disabled src='<?php echo $HUB_FLM->getImagePath("arrow-left2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        prevSpan.addClassName("inactive");
   	   	    }

   	   	    //pages
   	   	    var pageSpan = new Element("span", {'id':"nav-pages"});
   	   	    var totalPages = Math.ceil(total/max);
   	   	    var currentPage = (start/max) + 1;
   	   	    for (var i = 1; i<totalPages+1; i++){
   	   	    	var page = new Element("span", {'class':"nav-page"}).insert(i);
   	   	    	if(i != currentPage){
   	   		    	page.addClassName("active");
   	   		    	var newArr = {"max":max, "start":start};
   	   		    	newArr["start"] = newArr["max"] * (i-1) ;
   	   		    	Event.observe(page,"click", Pages.next.bindAsEventListener(Pages,type,newArr));
   	   	    	} else {
   	   	    		page.addClassName("currentpage");
   	   	    	}
   	   	    	pageSpan.insert(page);
   	   	    }

   	   	    //next
   	   	    var nextSpan = new Element("span", {'id':"nav-next"});
   	   	    if(parseInt(start)+parseInt(count) < parseInt(total)){
   	   		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' alt='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-right2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        nextSpan.addClassName("active");
   	   	        Event.observe(nextSpan,"click", function(){
   	   		    	var newArr = {"max":max, "start":start};
   	   	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
   	   	            if (type=="node") {
   	   	            	loadPickerNodes('<?php echo($USER->userid); ?>', newArr["start"], newArr["max"])
   	   	            } else if (type=="search") {
   	   	            	runPickerSearch(newArr["start"], newArr["max"]);
   	   	            }
   	   	        });
   	   	    } else {
   	   		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' alt='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-right2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        nextSpan.addClassName("inactive");
   	   	    }

   	   	    if( start>0 || (parseInt(start)+parseInt(count) < parseInt(total))){
   	   	    	nav.insert(prevSpan).insert(pageSpan).insert(nextSpan);
   	   	    }
   	   	}

   	   	return nav;
       }

       var Pages = {
   			next: function(e){
   				var data = $A(arguments);
   				var type = data[1];
   				var arrayData = data[2];
      	            if (type=="node") {
      	            	loadPickerNodes('<?php echo($USER->userid); ?>', arrayData['start'], arrayData['max']);
      	            } else if (type=="search") {
      	            	runPickerSearch(arrayData['start'], arrayData['max']);
      	            }
   			}
   	};

	/**
	* display nav header
	*/
	function createNavCounter(total, start, count, type){
		if(count != 0){
			var objH = new Element("span",{'class':'nav'});
			var s1 = parseInt(start)+1;
			var s2 = parseInt(start)+parseInt(count);
			objH.insert("<b>" + s1 + " to " + s2 + " (" + total + ")</b>");
		} else {
			var objH = new Element("span");
			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_ITEMS; ?></b></p>");
		}
		return objH;
	}

	function viewNodes() {
   	   	$("tab-item-node").removeClassName("unselected");
   	   	$("tab-item-node").addClassName("current");
   	   	$("item-idea-list").style.display = 'block';

 	   	$("tab-item-search").removeClassName("current");
 	   	$("tab-item-search").addClassName("unselected");
 	   	$("item-search-list").style.display = 'none';
	}

 	function viewSearch() {
   	   	$("tab-item-node").removeClassName("current");
   	   	$("tab-item-node").addClassName("unselected");
   	   	$("item-idea-list").style.display = 'none';

   	   	$("tab-item-search").removeClassName("unselected");
   	   	$("tab-item-search").addClassName("current");
   	   	$("item-search-list").style.display = 'block';
  	}

   	window.onload = init;


</script>

<div id="nodepicker" style="clear: both;float: left; width: 400px; margin-left: 10px; display: block;">
	<div style="float:left;width:100%">
		<label for="itemsearch" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->FORM_SELECTOR_SEARCH_LABEL; ?></label>
		<div style="float: left;">
			<input type="text" onkeyup="if (checkKeyPressed(event)) { $('selector-go-button').onclick();}" style=" margin-right:3px; width:280px" id="itemsearch" name="itemsearch" value="" onkeypress="pickerSearchKeyPressed(event)" />
			<div id="item_choices" class="autocomplete" style="border-color: white;"></div>
		</div>
		<div style="float:left;">
			<img src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: runPickerSearch('0', '10');" title="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>" alt="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_ALT; ?>" />
		</div>
	</div>


	<label style="clear:both; float: left; margin-bottom:15px;width:100%"><?php echo $LNG->FORM_SELECTOR_SEARCH_MESSAGE; ?></label>

	<div id="tabber" style="clear:both;float:left;width:380px;">
		<div style="float:left;">
			<ul id="tabs" class="tab2">
				<li class="tab"><a class="tab current" id="tab-item-node" href="javascript:void(0)" onclick="javascript: viewNodes();"><span class="tab"><?php echo $LNG->FORM_SELECTOR_TAB_MINE; ?> <span id="catheading"></span> (<span id="node-item-list-count">0</span>)</span></a></li>
				<li class="tab"><a class="tab unselected" id="tab-item-search" href="javascript:void(0)" onclick="javascript: viewSearch();"><span class="tab"><?php echo $LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS; ?> (<span id="search-item-list-count">0</span>)</span></a></li>
			</ul>
		</div>
		<div id="tabs-content" style="clear:both; float:left;height:540px;">
			<div id='item-idea-list' class='tabcontent' style="width: 360px; height: 520px;"></div>
			<div id='item-search-list' class='tabcontent' style="width: 360px; height: 520px; display: none;">
				 <?php echo $LNG->FORM_SELECTOR_SEARCH_EMPTY_MESSAGE; ?>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>