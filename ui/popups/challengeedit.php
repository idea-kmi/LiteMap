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

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headerdialog.php"));

 	$nodeid = required_param("nodeid",PARAM_ALPHANUMEXT);

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert brackets
	$handler = parseToJSON($handler);

	$challenge = optional_param("challenge","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

    if( isset($_POST["editchallenge"]) ) {

		if ($challenge == ""){
			array_push($errors,$LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR);
		} else {

			$r = getRoleByName("Challenge");
			$roleChallenge = $r->roleid;
			$challengenode = editNode($nodeid, $challenge,$desc, 'N', $roleChallenge);

			echo "<script type='text/javascript'>";
			if (isset($handler) && $handler != "") {
				echo "try { ";
				echo "window.opener.".$handler."('".$challengenode->nodeid."');";
				echo "}";
				echo "catch(err) {";
				echo "}";
			} else {
				echo "try { ";
				echo "if (window.opener && window.opener.loadSelecteditemNew) {";
				echo '	  window.opener.loadSelecteditemNew("'.$nodeid.'"); }';
				echo " else {";
				echo '	  window.opener.location.reload(true); }';
				echo "}";
				echo "catch(err) {";
				echo "}";
			}

			echo "window.close();";
			echo "</script>";
			include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
			die;
		}
    } else if ($nodeid != "") {
    	$node = new CNode($nodeid);
    	$node = $node->load();
		$challenge = $node->name;
		$desc = $node->description;
    } else {
		echo "<script type='text/javascript'>";
		echo "alert('".$LNG->FORM_CHALLENGE_NOT_FOUND."');";
		echo "window.close();";
		echo "</script>";
		die;
    }

	include($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    /**********************************************************************************/
?>
<?php
if(!empty($errors)){
    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>

<script type="text/javascript">

function init() {
	$('dialogheader').insert('<?php echo $LNG->FORM_TITLE_CHALLENGE_EDIT; ?>');
}

function checkForm() {
	var checkname = ($('challenge').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }

    $('challengeform').style.cursor = 'wait';

    return true;
}

window.onload = init;

</script>

<?php insertFormHeaderMessage(); ?>

<form id="challengeform" name="challengeform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
	<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />

    <div class="hgrformrow">
		<label  class="formlabelbig" for="url"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_CHALLENGE_SUMMARY; ?>:</span>
			<span class="active" onMouseOver="showFormHint('ChallengeSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="challenge" name="challenge" value="<?php echo( $challenge ); ?>" />
	</div>

 	<?php insertDescription('ChallengeDesc'); ?>

    <br>
    <div class="hgrformrow">
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="editchallenge" name="editchallenge">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>

</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>