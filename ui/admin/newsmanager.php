<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015-2023 The Open University UK                              *
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

    checkLogin();
    array_push($HEADER,"<script src='".$CFG->homeAddress."ui/lib/scriptaculous/scriptaculous.js' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

    if($USER == null || $USER->getIsAdmin() == "N"){
        echo "<div class='errors'>.".$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE."</div>";
        include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
        die;
	}

    $errors = array();

	$nodeid = optional_param("nodeid","",PARAM_ALPHANUMEXT);
	$name = optional_param("name","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

    if(isset($_POST["savenews"])){
    	if ($nodeid != "") {
 	    	if ($name != "") {
				//become the news admin user
				$currentuser = $USER;
				$admin = new User($CFG->ADMIN_USERID);
				$admin = $admin->load();
				$USER = $admin;

	    		$r = getRoleByName('News');
				$roleType = $r->roleid;
           		$node = editNode($nodeid,$name,$desc,'N',$roleType);

           		$USER = $currentuser;
	    	} else {
	            array_push($errors,$LNG->ADMIN_NEWS_MISSING_NAME_ERROR);
	        }
    	} else {
            array_push($errors,$LNG->ADMIN_NEWS_ID_ERROR);
    	}
    } else if(isset($_POST["addnews"])){
    	if ($name != "") {
			//become the news admin user
			$currentuser = $USER;
			$admin = new User($CFG->ADMIN_USERID);
			$admin = $admin->load();
			$USER = $admin;

    		$r = getRoleByName('News');
    		$roleType = $r->roleid;
	       	$node = addNode($name, $desc, 'N',$roleType);

       		$USER = $currentuser;
    	} else {
            array_push($errors,$LNG->ADMIN_NEWS_MISSING_NAME_ERROR);
        }
    } else if(isset($_POST["deletenews"])){
    	if ($nodeid != "") {
			if (!adminDeleteNews($nodeid)) {
				array_push($errors,$LNG->ADMIN_MANAGE_NEWS_DELETE_ERROR.' '.$nodeid);
			}
		} else {
			array_push($errors,$LNG->ADMIN_NEWS_ID_ERROR);
		}
	}

	$ns = getNodesByGlobal(0,-1,'name','ASC', 'News', 'long');
    $nodes = $ns->nodes;
?>

<script type="text/javascript">

	function init() {
		$('dialogheader').insert('<?php echo $LNG->ADMIN_NEWS_TITLE; ?>');
	}

    function editNews(objno){
    	cancelAddNews();
   		cancelAllEdits();

        $('editnewsform'+objno).show();
        $('savelink'+objno).show();

        $('newslabeldiv'+objno).hide();
        $('editnewslink'+objno).hide();
        $('editlink'+objno).hide();
    }

    function cancelEditNews(objno){
    	if ($('editnewsform'+objno)) {
         	$('editnewsform'+objno).hide();
    	}
    	if ($('savelink'+objno)) {
    		$('savelink'+objno).hide();
    	}

		if ($('newslabeldiv'+objno)) {
    		$('newslabeldiv'+objno).show();
    	}
    	if ($('editnewslink'+objno)) {
    		$('editnewslink'+objno).show();
    	}
    	if ($('editlink'+objno)) {
    		$('editlink'+objno).show();
    	}
    }

    function cancelAllEdits() {
		var array = document.getElementsByTagName('div');
		for(var i=0;i<array.length;i++) {
			if (array[i].id.startsWith('editnewsform')) {
				var objno = array[i].id.substring(13);
				cancelEditNews(objno);
			}
		}
    }

   	function addNews(){
   		cancelAllEdits();
    	$('newnewsform').show();
        $('addnewnewslink').hide();
	}

	function cancelAddNews(){
        $('newnewsform').hide();
        $('addnewnewslink').show();
   	}

	window.onload = init;

	function checkFormDelete(name) {
        var ans = confirm("<?php echo $LNG->ADMIN_NEWS_DELETE_QUESTION_PART1; ?> '"+name+"' <?php echo $LNG->ADMIN_NEWS_DELETE_QUESTION_PART2; ?>");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

</script>

<?php
if(!empty($errors)){
    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>


<div id="newsdiv" style="margin-left:10px;">

    <div class="formrow">
        <a id="addnewnewslink" href="javascript:addNews()" class="form"><?php echo $LNG->ADMIN_NEWS_ADD_NEW_LINK; ?></a>
    </div>

   <div id="newnewsform" class="formrow" style="display:none; clear:both;">
   		<form id="addnews" name="addnews" action="newsmanager.php" method="post" enctype="multipart/form-data">
        <div class="subform" style="width: 620px;">
            <div class='subformrow'><label class='formlabel' style='width: 75px' for='name'><?php echo $LNG->ADMIN_NEWS_NAME_LABEL; ?></label><input type='text' class='forminput' style='width: 300px' id='name' name='name' value=''/></div>
            <div class='subformrow'>

				<label  class="formlabelbig" for="desc">
				<span style="vertical-align:top"><?php echo $LNG->ADMIN_NEWS_DESC_LABEL; ?>
				<a id="editortogglebuttonadd" href="javascript:void(0)" style="vertical-align:top" onclick="switchCKEditorMode(this, 'textareadivadd', 'descadd')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>
				</span>
				</label>

				<div id="textareadivadd" style="clear:none;float:left;margin-top:5px;">
					<textarea rows="4" class="forminput hgrinput hgrwide" id="descadd" name="desc"></textarea>
				</div>
			</div>

            <div class="subformrow">
            	<input class="subformbutton" style="margin-left:30px; margin-top:5px;" type="submit" value="<?php echo $LNG->FORM_BUTTON_ADD; ?>" id="addnews" name="addnews">
                <input class="subformbutton" style="margin-left:7px;" type="button" name="cancelbutton" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="cancelAddNews();">
            </div>
        </div>
        </form>
    </div>

    <div class="formrow">
        <div id="nodes" class="forminput">

        <?php
            echo "<table class='table' cellspacing='0' cellpadding='3' border='0' style='margin: 0px;'>";
            echo "<tr>";
            echo "<th width='450'>".$LNG->ADMIN_NEWS_TITLE_HEADING."</th>";
            echo "<th width='30'>".$LNG->ADMIN_NEWS_ACTION_HEADING."</th>";
            echo "<th width='75'>".$LNG->ADMIN_NEWS_ACTION_HEADING."</th>";

            echo "</tr>";
            foreach($nodes as $node){
                echo "<tr id='node-".$node->nodeid."'>";

                echo "<td id='second-".$node->nodeid."'>";

		        echo "<div class='subform' id='editnewsform".$node->nodeid."' style='width: 590px; display:none; clear:both;'>";
		   		echo '<form name="managenews"'.$node->nodeid.' action="newsmanager.php" method="post" enctype="multipart/form-data">';
		   		echo "<input name='nodeid' type='hidden' value='".$node->nodeid."' />";
		        echo "<div class='subformrow'>";
		        echo "<label class='formlabel' style='width: 75px' for='name'>".$LNG->FORM_LABEL_NAME."</label><input type='text' class='forminput' style='width:300px' id='name' name='name' value=\"".$node->name."\"/></div>";


                echo "<div class='subformrow'>";
				echo '<label  class="formlabelbig" for="desc">';
				echo '<span style="vertical-align:top">'.$LNG->FORM_LABEL_DESC;
				echo '<a id="editortogglebutton" href="javascript:void(0)" style="vertical-align:top" onclick="switchCKEditorMode(this, \'textareadiv'.$node->nodeid.'\', \'desc'.$node->nodeid.'\')" title="'.$LNG->FORM_DESC_HTML_TEXT_HINT.'">'.$LNG->FORM_DESC_HTML_TEXT_LINK.'</a>';
				echo '</span>';
				echo '</label>';

				if (isProbablyHTML($node->description)) {
					 echo '<div id="textareadiv'.$node->nodeid.'" style="clear:both;float:left;margin-top:5px;">';
					 echo '	<textarea rows="4" class="ckeditor forminput hgrinput hgrwide" id="desc'.$node->nodeid.'" name="desc">'.$node->description.'</textarea>';
					 echo '</div>';
				} else {
					 echo '<div id="textareadiv'.$node->nodeid.'" style="clear:none;float:left;margin-top:5px;">';
					 echo '<textarea rows="4" class="forminput hgrinput hgrwide" id="desc'.$node->nodeid.'" name="desc">'.$node->description.'</textarea>';
					 echo '</div>';
				}

                echo "</div>";
 		        echo "<div class='subformrow' id='savelink".$node->nodeid."' style='display:none; clear:both;'>";
                echo '<input class="subformbutton" style="margin-left:30px;margin-top:5px;" type="submit" value="'.$LNG->FORM_BUTTON_SAVE.'" id="savenews" name="savenews" />';
                echo '<input class="subformbutton" style="margin-left:7px;" type="button" value="'.$LNG->FORM_BUTTON_CANCEL.'" onclick="javascript:cancelEditNews(\''.$node->nodeid.'\');" />';
                echo '</div>';
                echo "</form>";
                echo "</div>";

                echo "<div id='newslabeldiv".$node->nodeid."'>";
		        echo "<span class='labelinput' style='width: 90%' id='nodelabel".$node->nodeid."'>".$node->name."</span>";
                echo "<input type='hidden' id='newslabelval".$node->nodeid."' value=\"".$node->name."\"/>";
		        echo "</div>";

                echo "</td>";

                echo "<td id='third-".$node->nodeid."'>";
                echo "<div id='editlink".$node->nodeid."'>";
  				echo "<a id='editnewslink".$node->nodeid."' href='javascript:editNews(\"".$node->nodeid."\")' class='form'>".$LNG->ADMIN_NEWS_EDIT_LINK."</a>";
                echo "</td>";

                echo "<td id='fourth-".$node->nodeid."'>";
				echo '<form id="delete-'.$node->nodeid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormDelete(\''.htmlspecialchars($node->name).'\');">';
				echo '<input type="hidden" id="nodeid" name="nodeid" value="'.$node->nodeid.'" />';
				echo '<input type="hidden" id="deletenews" name="deletenews" value="" />';
				echo '<span class="active" onclick="if (checkFormDelete(\''.htmlspecialchars($node->name).'\')) { $(\'delete-'.$node->nodeid.'\').submit(); }" id="deletenews" name="deletenews">'.$LNG->ADMIN_NEWS_DELETE_LINK.'</a>';
				echo '</form>';
                echo "</td>";

   				echo "</div>";
                echo "</td>";

                echo "</tr>";
            }
            echo "</table>";
        ?>
        </div>
   </div>

    <div class="formrow">
    <input type="button" value="<?php echo $LNG->FORM_BUTTON_CLOSE; ?>" onclick="window.close();"/>

    </div>

</div>


<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>
