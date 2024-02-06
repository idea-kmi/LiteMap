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

///////////////////////////////////////
// LinkType Class
///////////////////////////////////////
class LinkType {

    public $linktypeid;
    public $label;
    public $userid;
    public $groupid;
    public $grouplabel;

    /**
     * Constructor
     *
     * @param string $linktypeid (optional)
     * @return LinkType (this)
     */
    function LinkType($linktypeid = ""){
        if ($linktypeid != ""){
            $this->linktypeid= $linktypeid;
            return $this;
        }
    }

    /**
     * Loads the data for the link type from the database
     *
     * @return LinkType object (this)  (or Error object)
     */
    function load(){
        global $DB,$CFG,$ERROR,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$cachedused = $HUB_CACHE->getObjData($this->linktypeid);
			if ($cachedused !== FALSE) {
				return $cachedused;
			}
		}

		$params = array();
		$params[0] = $this->linktypeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_LINKTYPE_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createLinkTypeNotFoundError($this->linktypeid);
				return $ERROR;
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $this->label = $array['Label'];
                $this->groupid = $array['LinkTypeGroupID'];
                $this->grouplabel = stripslashes($array['GroupLabel']);
                $this->userid = $array['UserID'];
            }
        } else {
            return database_error();
        }

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->setObjData($this->linktypeid, $this, $CFG->CACHE_DEFAULT_TIMEOUT);
		}
        return $this;
    }

    /**
     * Loads the data for the link type from the database
     *
     * @param string label
     * @return LinkType object (this)  (or Error object)
     */
    function loadByLabel($label){
        global $DB,$CFG,$USER,$ERROR,$HUB_SQL;

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $label;
		$params[1] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_LINKTYPE_BY_LABEL_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createLinkTypeNotFoundError($this->linktypeid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->linktypeid = $array['LinkTypeID'];
				}
			}
        } else {
            return database_error();
        }

        return $this->load();
    }

    /**
     * add a link type to the database
     *
     * @param string $label
     * @param string $linktypegroup
     * @return LinkType object (this)  (or Error object)
     */
    function add($label,$linktypegroup){
        global $DB,$CFG,$USER,$LNG,$HUB_SQL;

        //check user can add
        try {
            $this->canadd();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        // check linktypegroup is valid
		$params = array();
		$params[0] = $linktypegroup;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_LINKTYPE_ADD_GROUP_CHECK, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if( $count != 1) {
				 return database_error($LNG->ERROR_LINKTYPE_GROUP_NAME);
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$linktypegroupid = $array['LinkTypeGroupID'];
				}

				$dt = time();

				$params = array();
				$params[0] = $label;
				$params[1] = $currentuser;
				$params[2] = $CFG->defaultUserID;
				$resArray2 = $DB->select($HUB_SQL->DATAMODEL_LINKTYPE_ADD_CHECK, $params);
				if ($resArray2) {
					$count2 = 0;
					if (is_countable($resArray2)) {
						$count2 = count($resArray2);
					}
					if( $count2 != 0) {
						for ($j=0; $j<$count2; $j++) {
							$array2 = $resArray2[$j];
							$this->linktypeid = $array2['LinkTypeID'];
						}

						return $this->load();
					}
				} else {
					return database_error();
				}

				//insert the link type
				$this->linktypeid = getUniqueID();

				$params = array();
				$params[0] = $this->linktypeid;
				$params[1] = $currentuser;
				$params[2] = $label;
				$params[3] = $dt;

				$res = $DB->insert($HUB_SQL->DATAMODEL_LINKTYPE_ADD, $params);
				if (!$res) {
					return database_error();
				}

				$params = array();
				$params[0] = $linktypegroupid;
				$params[1] = $this->linktypeid;
				$params[2] = $currentuser;
				$params[3] = $dt;

				$res = $DB->insert($HUB_SQL->DATAMODEL_LINKTYPE_ADD_GROUP, $params);
				if (!$res) {
					 return database_error();
				}
				return $this->load();
			}
		} else {
			 return database_error();
		}
        return $this;

    }

    /**
     * Edit a linktype
     *
     * @param string $$linktypelabel
     * @return LinkType object (this) (or Error object)
     */
    function edit($linktypelabel){
        global $DB,$USER,$HUB_SQL,$HUB_CACHE;
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->linktypeid);
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $linktypelabel;
		$params[1] = $this->linktypeid;
		$params[2] = $currentuser;
		$res = $DB->insert($HUB_SQL->DATAMODEL_LINKTYPE_EDIT, $params);
        if (!$res) {
            return database_error();
        }

        return $this->load();
    }

    /**
     * Delete this linktype and any of this users connections using it.
     *
     * @return Result object (or Error object)
     */
    function delete() {
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->linktypeid);
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->linktypeid;
		$params[1] = $currentuser;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_LINKTYPE_DELETE_CHECK, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $c = new Connection($array['TripleID']);
                $c = $c->load();
				if (!auditConnection($USER->userid, $array['TripleID'], $array['Label'], $array['FromID'], $array['ToID'], $array['LinkTypeID'], $array['FromContextTypeID'],  $array['ToContextTypeID'], $CFG->actionDelete, format_object('xml',$c))) {
		            return database_error();
				}
			}

			$res = $DB->delete($HUB_SQL->DATAMODEL_LINKTYPE_DELETE_TRIPLE, $params);
			if ($res) {
				$res1 = $DB->delete($HUB_SQL->DATAMODEL_LINKTYPE_DELETE, $params);
				if (!$res1) {
                   return database_error();
				}
			} else {
                return database_error();
			}
		} else {
            return database_error();
		}

        return new Result("deleted","true");
    }

    /**
     * Sets up the default link types for the given user
     *
     * @param string $userid
     * @return true if all went well or Error object
     */
    function setUpDefaultLinkTypes($userid){
        global $CFG,$DB,$LNG,$HUB_SQL;

  		//really need to change the way the unique identifier is created.
		//have increased to 14, but can't go any bigger or ID will exceed limit of 50 chars.

		$params = array();
		$params[0] = $userid;
		$params[1] = $userid;
		$params[2] = $CFG->defaultUserID;

		$res = $DB->insert($HUB_SQL->DATAMODEL_LINKTYPE_UPDATE_DEFAULT_LINKTYPES, $params);
        if (!$res){
             return database_error();
        } else {
            //add the default groupings for these

			$params = array();
			$params[0] = $CFG->defaultUserID;

			$res2 = $DB->insert($HUB_SQL->DATAMODEL_LINKTYPE_UPDATE_DEFAULT_LINKTYPES_GROUP, $params);
            if (!$res2){
                return database_error();
            }
        }
        return true;
    }

    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can add a node
     *
     * @throws Exception
     */
    function canadd(){
        global $LNG;
        // needs to be logged in that's all!
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can edit the current linktype
     *
     * @throws Exception
     */
    function canedit(){
        global $DB,$USER,$LNG,$HUB_SQL;
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can edit only if owner of the link type
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->linktypeid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_LINKTYPE_CAN_EDIT, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
	        if($count == 0){
	            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
	        }
        } else {
        	throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can delete the current linktype
     *
     * @throws Exception
     */
    function candelete(){
        global $DB,$USER,$LNG;
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
        //can edit only if owner of the node

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->linktypeid;

		$resArray = $DB->select($HUB_SQL->$HUB_SQL->DATAMODEL_LINKTYPE_CAN_DELETE, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
	        if($count == 0){
	            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
	        }
        } else {
        	throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }
}
?>