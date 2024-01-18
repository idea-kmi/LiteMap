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

    // check that user logged in
    if(!isset($USER->userid)){
        header('Location: '.$CFG->homeAddress.'index.php');
        return;
    }

   	$provider = required_param("provider",PARAM_ALPHA);
   	$providerDisplay = ucfirst($provider);

    $referrer = optional_param("referrer",$CFG->homeAddress."index.php",PARAM_URL);
    if ($referrer == "") {
    	$referrer = $CFG->homeAddress."index.php";
    }

	include_once($HUB_FLM->getCodeDirPath("ui/headerlogin.php"));

	echo '<div class="messagediv2">';
    echo '<h1>'.$LNG->LOGIN_EXTERNAL_WELCOME_TITLE.'</h1>';
	echo '<br>'.$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART1." <b>".$USER->getEmail()."</b>";
	echo $LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART2." <b>".$providerDisplay."</b>";
	echo ' '.$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART3;
	echo '<br><br>'.$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART4;

	echo '<br><br><br>';
	echo '<a class="likeabutton" href="'.$referrer.'">'.$LNG->LOGIN_EXTERNAL_ENTER_BUTTON.'</a>';
	echo '</div>';

	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>