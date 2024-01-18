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
/**
 * filelocationmanager.php
 *
 * Michelle Bachler (KMi)
 *
 * Manages accessing styles, images and pages, through the theme or custom or default locations.
 */

///////////////////////////////////////
// FileLocationManager Class
///////////////////////////////////////

class FileLocationManager {

 	private $CUSTOMFOLDER = 'custom';
	private $DEFAULTTHEME = 'default';
	private $themefolder = '';

	/**
	 * Constructor
 	 *
	 * @return FileLocationManager (this)
	 */
	function FileLocationManager($theme = "") {
		$this->themefolder = $theme;
	}

	function setTheme($theme = "") {
		$this->themefolder = $theme;
	}

	/**
	 * Return the full path for the image file name passed.
	 * If the image is in a subfolder, the subfolder name should be included in the filename.
	 *
	 * $filename, the filename of the image to return the path for. (include any subfolder name, e.g. 'nodetypes/Default/challenge.png')
	 * returns a web path
	 */
	function getImagePath($filename) {
		global $CFG;
		$path = $filename;

		// strip 'images/' from the front if it is there
		if (substr($path, 0, 7) == "images/") {
			$path = substr($path, 7);
		}

		// DOMAIN SPECIFIC THEMES - MULTI AND DEFAULT
		if ($this->themefolder != "" &&
				file_exists($CFG->dirAddress.$CFG->domainfolder.'theme/'.$this->themefolder.'/images/'.$filename)) {
			$path = $CFG->homeAddress.$CFG->domainfolder.'theme/'.$this->themefolder.'/images/'.$filename;

		// MULTI SITE GLOBAL THEMES
		} else if ($CFG->ismultidomain && $this->themefolder != "" &&
				file_exists($CFG->dirAddress.'sites/multi/all/theme/'.$this->themefolder.'/images/'.$filename)) {
			$path = $CFG->homeAddress.'sites/multi/all/theme/'.$this->themefolder.'/images/'.$filename;

		// BASE DEFAULT THEME
		} else if (file_exists($CFG->dirAddress.'theme/'.$this->DEFAULTTHEME.'/images/'.$filename)) {
			$path = $CFG->homeAddress.'theme/'.$this->DEFAULTTHEME.'/images/'.$filename;

		// BASE IMAGES FOLDER
		} else if (file_exists($CFG->dirAddress.'images/'.$filename)) {
			$path = $CFG->homeAddress.'images/'.$filename;
		}

		return $path;
	}

	/**
	 * Return the path for the image file name passed relative to site main folder.
	 * If the image is in a subfolder, the subfolder name should be included in the filename.
	 *
	 * $filename, the filename of the image to return the relative path for. (include any subfolder name, e.g. 'nodetypes/Default/challenge.png')
	 * returns a web path
	 */
	function getRelativeImagePath($filename) {
		global $CFG;
		$path = $filename;

		// strip 'images/' from the front if it is there
		if (substr($path, 0, 7) == "images/") {
			$path = substr($path, 7);
		}

		// DOMAIN SPECIFIC THEMES - MULTI AND DEFAULT
		if ($this->themefolder != "" &&
				file_exists($CFG->dirAddress.$CFG->domainfolder.'theme/'.$this->themefolder.'/images/'.$path)) {
			$path = $CFG->domainfolder.'theme/'.$this->themefolder.'/images/'.$path;

		// MULTI SITE GLOBAL THEMES
		} else if ($CFG->ismultidomain && $this->themefolder != "" &&
				file_exists($CFG->dirAddress.'sites/multi/all/theme/'.$this->themefolder.'/images/'.$filename)) {
			$path = 'sites/multi/all/theme/'.$this->themefolder.'/images/'.$filename;

		// BASE DEFAULT THEME
		} else if (file_exists($CFG->dirAddress.'theme/'.$this->DEFAULTTHEME.'/images/'.$path)) {
			$path = 'theme/'.$this->DEFAULTTHEME.'/images/'.$path;

		// BASE IMAGES FOLDER
		} else if (file_exists($CFG->dirAddress.'images/'.$path)) {
			$path = 'images/'.$path;
		}

		return $path;
	}

	/**
	 * Return the full path for the stylesheet file name passed.
	 *
	 * $filename the filename of the stylesheet to return the path for.
	 * returns a web path
	 */
	function getStylePath($filename) {

		global $CFG;
		$path = $filename;

		//For backward compatibilty with version 1.0 check old file location first.
		if (file_exists($CFG->dirAddress.'ui/styles/'.$filename)) {
			$path = $CFG->homeAddress.'ui/styles/'.$filename;

		// DOMAIN SPECIFIC THEMES - MULTI AND DEFAULT
		} else if ($this->themefolder != "" &&
			file_exists($CFG->dirAddress.$CFG->domainfolder.'theme/'.$this->themefolder.'/styles/'.$filename)) {
			$path = $CFG->homeAddress.$CFG->domainfolder.'theme/'.$this->themefolder.'/styles/'.$filename;

		// MULTI SITE GLOBAL THEMES
		} else if ($CFG->ismultidomain && $this->themefolder != "" &&
			file_exists($CFG->dirAddress.'sites/multi/all/theme/'.$this->themefolder.'/styles/'.$filename)) {
			$path = $CFG->homeAddress.'sites/multi/all/theme/'.$this->themefolder.'/styles/'.$filename;

		// BASE DEFAULT THEME
		} else {
			$path = $CFG->homeAddress.'theme/'.$this->DEFAULTTHEME.'/styles/'.$filename;
		}

		return $path;
	}

	/**
	 * Return the full web address path for the code file name passed.
	 * Check is there is a local customization for the given file.
	 * If so return the path to the local file instead or the default file.
	 *
	 * $file, the default file path of the code file to return the path for.
	 * This is the full path and filename as would be used in a script statement.
	 * returns a path to the Custom file if found else returns the passed path.
	 */
	function getCodeWebPath($file) {
		global $CFG;

		$path = $file;

		// DOMAIN SPECIFIC FILE - MULTI AND DEFAULT
		if (file_exists($CFG->dirAddress.$CFG->domainfolder.'custom/'.$file)) {
			$path = $CFG->homeAddress.$CFG->domainfolder.'custom/'.$file;

		// MULTI SITE GLOBAL FILE
		} else if ($CFG->ismultidomain &&
				file_exists($CFG->dirAddress.'sites/multi/all/custom/'.$file)) {
			$path = $CFG->homeAddress.'sites/multi/all/custom/'.$file;

		// BASE FILE
		} else {
			$path = $CFG->homeAddress.$file;
		}

		return $path;
	}

	/**
	 * Return the full directory path for the code file name passed.
	 * Check is there is a local customization for the given file.
	 * If so return the path to the local file instead or the default file.
	 *
	 * $file, the default file path of the code file to return the path for.
	 * This is the full path and filename as would be used in an include statement.
	 * returns a path to the Custom file if found else returns the passed path.
	 */
	function getCodeDirPath($file) {
		global $CFG;

		$path = $file;

		// DOMAIN SPECIFIC FILE - MULTI AND DEFAULT
		if (file_exists($CFG->dirAddress.$CFG->domainfolder.'custom/'.$file)) {
			$path = $CFG->dirAddress.$CFG->domainfolder.'custom/'.$file;

		// MULTI SITE GLOBAL FILE
		} else if ($CFG->ismultidomain &&
				file_exists($CFG->dirAddress.'sites/multi/all/custom/'.$file)) {
			$path = $CFG->dirAddress.'sites/multi/all/custom/'.$file;

		// BASE FILE
		} else {
			$path = $CFG->dirAddress.$file;
		}

		return $path;
	}

	/**
	 * Check is there is a local customization for the given file.
	 * If so return true, else false.
	 *
	 * $file, the default file path of the code file to check.
	 * This is the full path and filename as would be used in a script statement.
	 * returns true if there is a Custom file, else false.
	 */
	function hasCustomVersion($file) {
		global $CFG;

		// DOMAIN SPECIFIC FILE - MULTI AND DEFAULT
		if (file_exists($CFG->dirAddress.$CFG->domainfolder.'custom/'.$file)) {
			return true;

		// MULTI SITE GLOBAL FILE
		} else if ($CFG->ismultidomain &&
				file_exists($CFG->dirAddress.'sites/multi/all/custom/'.$file)) {
			return true;
		}
		return false;
	}

	function getMailTemplatePath($file) {
		global $CFG;

		$path = $file;

		// DOMAIN SPECIFIC FILE - MULTI AND DEFAULT
		if (file_exists($CFG->dirAddress.$CFG->domainfolder.'language/'.$CFG->language.'mailtemplates/'.$file)) {
			$path = $CFG->dirAddress.$CFG->domainfolder.'language/'.$CFG->language.'/mailtemplates/'.$file;

		// MULTI SITE GLOBAL FILE
		} else if (file_exists($CFG->dirAddress.'sites/multi/all/language/'.$CFG->language.'mailtemplates/'.$file)) {
			$path = $CFG->dirAddress.'sites/multi/all/language/'.$CFG->language.'/mailtemplates/'.$file;

		// BASE FILE
		} else {
			$path = $CFG->dirAddress.'language/'.$CFG->language.'/mailtemplates/'.$file;
		}

		return $path;
	}

	/**
	 * Return the full path for the uploads folder for the filename passed to use.
	 * If the file is in a subfolder, the subfolder name should be included in the filename.
	 *
	 * $filename, the filename of the uploaded file to return the path for. (include any subfolder name, e.g. '<userid>/picture1.png')
	 * returns a web path
	 */
	function getUploadsWebPath($filename) {
		global $CFG;
		$path = $filename;

		// strip uploads/ from the front if it is there
		if (substr($path, 0, 8) == "uploads/") {
			$path = substr($path, 8);
		}

		// DOMAIN SPECIFIC UPLOADS FOLDER PATH - MULTI AND DEFAULT
		if (file_exists($CFG->dirAddress.$CFG->domainfolder.'uploads/'.$path)) {
			$path = $CFG->homeAddress.$CFG->domainfolder.'uploads/'.$path;

		// BASE UPLOADS FOLDER PATH - should really never get to here
		} else if (file_exists($CFG->dirAddress.'uploads/'.$path)) {
			$path = $CFG->homeAddress.'uploads/'.$path;
		}

		return $path;
	}

	/**
	 * return the directory structure for storing node images for the given nodeid
	 * from indide the uploads folder level only.
	 * call getUploadsWebPath to build full actualy path for displaying image.
	 */
	function getUploadsNodeDir($nodeid, $userid="") {
		global $USER;

		if ($userid == "") {
			$userid = $USER->userid;
		}

		if (isset($userid)) {
			return $userid."/nodes/".$nodeid;
		} else {
			// should never happen
			return "nodes/".$nodeid;
		}
	}

	/**
	 * Return the full path for the uploads folder for the filename passed.
	 * If the file is in a subfolder, the subfolder name should be included in the filename.
	 *
	 * $filename, the filename of the uploaded file to return the path for. (include any subfolder name, e.g. 'nodetypes/Default/challenge.png')
	 * returns a web path
	 */
	function createUploadsDirPath($filename) {
		global $CFG;
		$path = $filename;

		// strip uploads/ from the front if it is there
		if (substr($path, 0, 8) == "uploads/") {
			$path = substr($path, 8);
		}

		// DOMAIN SPECIFIC UPLOADS FOLDER PATH - MULTI AND DEFAULT
		if ($CFG->domainfolder != "") {
			$path = $CFG->dirAddress.$CFG->domainfolder.'uploads/'.$path;

		// BASE UPLOADS FOLDER PATH - should really never get to here
		} else {
			$path = $CFG->dirAddress.'uploads/'.$path;
		}

		return $path;
	}

	/**
	 * Return the full path for the users uploads folder for the filename passed to use.
	 *
	 * $filename, the filename of the uploaded file to return the path for.
	 * returns a directory path
	 */
	function getUploadsUserDirPath($filename, $userid) {
		global $CFG;
		$path = $filename;

		// DOMAIN SPECIFIC UPLOADS FOLDER PATH - MULTI AND DEFAULT
		if (file_exists($CFG->dirAddress.$CFG->domainfolder.'uploads/'.$userid.'/'.$path)) {
			$path = $CFG->dirAddress.$CFG->domainfolder.'uploads/'.$userid.'/'.$path;

		// BASE UPLOADS FOLDER PATH - should really never get to here
		} else if (file_exists($CFG->dirAddress.'uploads/'.$userid.'/'.$path)) {
			$path = $CFG->dirAddress.'uploads/'.$userid.'/'.$path;
		}

		return $path;
	}
}