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

///////////////////////////////////////
// Tag Class
///////////////////////////////////////

class Tag {
    public $tagid;
    public $name;
    public $userid;

    //public $groupid;

    /**
     * Constructor
     *
     * @param string $tageid (optional)
     * @return Tag (this)
     */
    function Tag($tagid = ""){
        if ($tagid != ""){
            $this->tagid= $tagid;
            return $this;
        }
    }

    /**
     * Loads the data for the tag from the database
     *
     * @return Tag object (this)
     */
    function load(){
        global $DB,$CFG,$ERROR,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$cachedused = $HUB_CACHE->getObjData($this->tagid);
			if ($cachedused !== FALSE) {
				return $cachedused;
			}
		}

		$params = array();
		$params[0] = $this->tagid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_TAG_SELECT, $params);
		if ($resArray !== false) {
			$count = count($resArray);
			if ($count == 0) {
	 			$ERROR = new error;
	    		$ERROR->createTagNotFoundError($this->tagid);
	            return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->name = stripslashes($array['Name']);
					$this->userid = $array['UserID'];
				}
			}
        } else {
            return database_error();
        }

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->setObjData($this->tagid, $this, $CFG->CACHE_DEFAULT_TIMEOUT);
		}

        return $this;
    }

    /**
     * Loads the data for the tag from the database based on tag name
     *
     * @return Tag object (this)
     */
    function loadByName($tagname){
        global $DB,$CFG,$USER,$ERROR,$HUB_SQL;

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $tagname;
		$params[1] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_TAG_BY_NAME_SELECT, $params);
		if ($resArray !== false) {
			$count = count($resArray);
			if ($count == 0) {
	 			$ERROR = new error;
	    		$ERROR->createTagNotFoundError($this->tagid);
	            return $ERROR;
	        } else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
	                $this->tagid = $array['TagID'];
	            }
            }
        } else {
            return database_error();
        }

        return $this->load();
    }

    /**
     * Add new tag to the database
     * If the tag already exists, then this will be returned instead
     *
     * @param string $tagname
     * @returnTag object (this) (or Error object)
     */
    function add($tagname){
        global $DB,$CFG,$USER,$HUB_SQL;

        $tagname = trim($tagname);
        if ($tagname == "") {
        	return;
        }

        try {
            $this->canadd();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $tagname;
		$params[1] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_TAG_ADD_CHECK, $params);
		if ($resArray !== false) {
			$count = count($resArray);
			if ($count > 0) {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
                    $this->tagid = $array['TagID'];
                }
                return $this->load();
            } else {
                $this->tagid = getUniqueID();
                $dt = time();

				$params = array();
				$params[0] = $this->tagid;
				$params[1] = $currentuser;
				$params[2] = $dt;
				$params[3] = $tagname;

				$res = $DB->insert($HUB_SQL->DATAMODEL_TAG_ADD, $params);
                if (!$res) {
                    return database_error();
                }
            }
        } else {
            return database_error();
        }

        return $this->load();
    }

    /**
     * Edit a tag
     *
     * @param string $tagname
     * @return Tag object (this) (or Error object)
     */
    function edit($tagname){
        global $DB,$USER,$HUB_SQL,$HUB_CACHE;
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->tagid);
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $tagname;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_TAG_EDIT_CHECK, $params);
		if ($resArray !== false) {
			$count = count($resArray);
			if ($count > 0) {
            	return database_error("Tag already exists","7012");
            } else {
				$params = array();
				$params[0] = $tagname;
				$params[1] = $this->tagid;
				$params[2] = $currentuser;

				$res = $DB->insert($HUB_SQL->DATAMODEL_TAG_EDIT, $params);
		        if (!$res) {
		            return database_error();
		        }
            }
        }

        return $this->load();
    }

    /**
     * Delete this tag
     *
     * @return Result object (or Error object)
     */
    function delete(){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->tagid);
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->tagid;

		$res = $DB->delete($HUB_SQL->DATAMODEL_TAG_DELETE, $params);
        if (!$res) {
            return database_error();
        }

        return new Result("deleted","true");
    }

    /////////////////////////////////////////////////////
    // security functions
    // No canview() function as any user can view any tag (is this right?!)
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can add a tag
     *
     * @throws Exception
     */
    function canadd(){
    	global $LNG;
        // needs to be logged in - that's all!
        if(api_check_login() instanceof Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can edit the current tag
     *
     * @throws Exception
     */
    function canedit(){
        global $DB,$USER,$HUB_SQL,$LNG;
        if(api_check_login() instanceof Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->tagid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_TAG_CAN_EDIT, $params);
		if ($resArray !== false) {
			$count = count($resArray);
			if ($count == 0) {
            	throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
            }
        } else {
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can delete the current tag
     *
     * @throws Exception
     */
    function candelete(){
        global $DB,$USER,$HUB_SQL,$LNG;
        if(api_check_login() instanceof Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can edit only if owner of the tag
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->tagid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_TAG_CAN_DELETE, $params);
		if ($resArray !== false) {
			$count = count($resArray);
			if ($count == 0) {
            	throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
            }
        } else {
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }
}
?>