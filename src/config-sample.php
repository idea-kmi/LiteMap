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
/** Author: Michelle Bachler, KMi, The Open University **/
/**
 * config.php
 *
 * This is the master config file, that will establish the domain
 * and redirect to the required main site specific config file.
 */

unset($CFG);

$CFG = new stdClass();

// Some static items used in local configs so need to be here before those are called.
$CFG->BUILD_FROM_COMMENTS_USER = "user";
$CFG->BUILD_FROM_COMMENTS_ADMIN = "admin";
$CFG->BUILD_FROM_COMMENTS_ALL = "all";
$CFG->SIGNUP_OPEN = "open";
$CFG->SIGNUP_REQUEST = "request";
$CFG->SIGNUP_CLOSED = "closed";

$CFG->basedomain = "";

// could get this automatically somehow dirname/realpath/getcwd ?;
$CFG->dirAddress = "";

$currentdomain = "";

// $domain passed in from cron jobs
if (!isset($domain) || $domain == "") {
	if (isset($_SERVER['HTTP_HOST'])) {
		$currentdomain = $_SERVER['HTTP_HOST'];
	} else if(isset($_SERVER['SERVER_NAME'])) {
		$currentdomain = $_SERVER['SERVER_NAME'];
	}
} else {
	$currentdomain = $domain;
}

// remove port number
$currentdomain = preg_replace('/:\d+$/', '', $currentdomain);

$CFG->domainfolder = "";
$CFG->ismultidomain = false;
if ($currentdomain == "" || $currentdomain == $CFG->basedomain) {
	$CFG->domainfolder = "sites/default/";
} else {
	$CFG->domainfolder = "sites/multi/".$currentdomain."/";
	$CFG->ismultidomain = true;
	if (!is_dir($CFG->dirAddress."sites/multi/".$currentdomain)) {
		echo "This domain has not been setup yet.";
		die;
	}
}

//load the domain specific config settings
require_once($CFG->domainfolder."config.php");

// setup the hub
require_once("setup.php");
?>
