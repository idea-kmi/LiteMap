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
/**
 * language.php
 *
 * Michelle Bachler (KMi)
 *
 * This file loads the language files for the site.
 * For each file, it first loads the base language file, then applies any overrides and additions by;
 * first loading any multi site global version of the file, then any domain specific version.
 * Any matching variable names will be replaced, and new ones added.
 *
 * This should eventually become part of the internationalization of the Evidence Hub
 */
unset($LNG);

$LNG = new stdClass();

function loadLanguageFile($file) {

	global $CFG, $HUB_FLM, $LNG;

	/** LOAD BASE FILE **/
	if (file_exists($CFG->dirAddress.'language/'.$CFG->language.'/'.$file)) {
		require_once($CFG->dirAddress.'language/'.$CFG->language.'/'.$file);
	} else {
		if ($CFG->language != "en") {
			if (file_exists($CFG->dirAddress.'language/en/'.$file)) {
				require_once($CFG->dirAddress.'language/en/'.$file);
			}
		}
	}

	/** LOAD multi-site global customizations **/
	if ($CFG->ismultidomain &&
			file_exists($CFG->dirAddress.'sites/multi/all/language/'.$CFG->language.'/'.$file)) {
		require_once($CFG->dirAddress.'sites/multi/all/language/'.$CFG->language.'/'.$file);
	}

	/** LOAD domain specific customizations **/
	if (file_exists($CFG->dirAddress.$CFG->domainfolder.'/language/'.$CFG->language.'/'.$file)) {
		require_once($CFG->dirAddress.$CFG->domainfolder.'/language/'.$CFG->language.'/'.$file);
	}
}

/** LOAD CORE TERMS **/
loadLanguageFile('languagecore.php');

/** LOAD INTERFACE TEXT (SOME HTML INCLUDED) **/
loadLanguageFile('languageui.php');
loadLanguageFile('loginandregistration.php');
loadLanguageFile('headerandfooter.php');
loadLanguageFile('users.php');
loadLanguageFile('admin.php');
loadLanguageFile('emails.php');
loadLanguageFile('stats.php');
loadLanguageFile('core.php');

/** LOAD COUNTRIES LIST **/
loadLanguageFile('countries.php');
if (!empty($LNG->COUNTRIES_LIST)) {
   uasort($LNG->COUNTRIES_LIST, 'strcoll');
}

/////// PAGES ///////

/** LOAD ABOUT (MUCH HTML INCLUDED) **/
loadLanguageFile('pages/about.php');

/** LOAD CONDITIONS OF USE (MUCH HTML INCLUDED) **/
loadLanguageFile('pages/conditionsofuse.php');

/** LOAD COOKIES (MUCH HTML INCLUDED) **/
loadLanguageFile('pages/cookies.php');

/** LOAD PRIVACY STATEMENT (MUCH HTML INCLUDED) **/
loadLanguageFile('pages/privacy.php');

/** LOAD HELP (MUCH HTML INCLUDED) **/
loadLanguageFile('pages/help.php');

/** LOAD Compendium Import (MUCH HTML INCLUDED) **/
loadLanguageFile('pages/compendiumimport.php');

/** LOAD Bibtext import (MUCH HTML INCLUDED) **/
loadLanguageFile('pages/bibteximport.php');
?>