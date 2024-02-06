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
/**
 * Send an email to alert of user reported spam on site.
 */

include_once('../../config.php');

global $USER,$CFG;

/** If the person is not logged in, this should not be called **/
checkLogin();

//send the header info
header("Content-Type: text/plain");
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );  // disable IE caching
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

$type = required_param('type',PARAM_ALPHANUM);
$id = required_param('id',PARAM_ALPHANUMEXT);

//add to database
if ($CFG->SPAM_ALERT_ON) {
	if ($type == "user") {
		$user = new User($id);
		$user = $user->load();
		$user->updateStatus($CFG->USER_STATUS_REPORTED);
	} else {
		$node = new CNode($id);
		$node = $node->load();
		$node->updateStatus($CFG->STATUS_REPORTED);
		$type = $node->role->name;
	}

	auditSpamReport($USER->userid, $id, $type);

	//send email
	if($CFG->send_mail){
		$headpath = $HUB_FLM->getMailTemplatePath("emailhead.txt");
		$headtemp = loadFileToString($headpath);
		$head = vsprintf($headtemp,array($HUB_FLM->getImagePath('evidence-hub-logo-email.png')));
		$footpath = $HUB_FLM->getMailTemplatePath("emailfoot.txt");
		$foottemp = loadFileToString($footpath);
		$foot = vsprintf($foottemp,array());

		$message = "SERVER: ".$CFG->homeAddress."<br>";
		$message .= "TYPE: ".$type."<br>";
		$message .= "ID: ".$id;
		if ($USER->userid) {
			$message .= "<br>Reported By: ".$USER->name." (".$USER->userid.")";
		}

		$message = $head."<br><br>".$message."<br><br>".$foot;

		$recipient = $CFG->SPAM_ALERT_RECIPIENT;
		$subject = "Spam Report";
		$headers = "Content-type: text/html; charset=utf-8\r\n";
		ini_set("sendmail_from", $CFG->EMAIL_FROM_ADDRESS );
		$headers .= "From: ".$CFG->EMAIL_FROM_NAME ." <".$CFG->EMAIL_FROM_ADDRESS .">\r\n";
		$headers .= "Reply-To: ".$CFG->EMAIL_REPLY_TO."\r\n";

		mail($recipient,$subject,$message,$headers);
	}
}
?>
