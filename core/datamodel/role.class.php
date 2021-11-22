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
// Role Class
///////////////////////////////////////

class Role {
    public $roleid;
    public $name;
    public $userid;
    public $groupid;
    public $image;

    /**
     * Constructor
     *
     * @param string $roleid (optional)
     * @return Role (this)
     */
    function Role($roleid = ""){
        if ($roleid != ""){
            $this->roleid= $roleid;
            return $this;
        }
    }

    /**
     * Loads the data for the role from the database
     *
     * @return Role object (this)
     */
    function load() {
        global $DB,$CFG,$ERROR,$HUB_FLM,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$cachedrole = $HUB_CACHE->getObjData($this->roleid);
			if ($cachedrole !== FALSE) {
				return $cachedrole;
			}
		}

		$params = array();
		$params[0] = $this->roleid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_ROLE_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
	 			$ERROR = new Hub_Error;
	    		$ERROR->createRoleNotFoundError($this->roleid);
	            return $ERROR;
            } else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->name = stripslashes($array['Name']);
					$this->userid = $array['UserID'];
					$this->groupid = $array['NodeTypeGroupID'];
					$this->image = $HUB_FLM->getRelativeImagePath($array['Image']);
				}
			}
        } else {
            return database_error();
        }

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->setObjData($this->roleid, $this, $CFG->CACHE_DEFAULT_TIMEOUT);
		}

        return $this;
    }

    /**
     * Loads the data for the role from the database based on role name
     *
     * @return Role object (this)
     */
    function loadByName($rolename){
        global $DB,$CFG,$USER,$HUB_SQL;

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $rolename;
		$params[1] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_ROLE_BY_NAME_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
	 			$ERROR = new Hub_Error;
	    		$ERROR->createRoleNotFoundError($rolename);
	            return $ERROR;
	        } else {
        		for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
             	   	$this->roleid = $array['NodeTypeID'];
             	}
            }
        } else {
            return database_error();
        }

        return $this->load();
    }

    /**
     * Add new role to the database
     * If the role already exists, then this will be returned instead
     *
     * @param string $rolename
     * @param string $image, optional parameter local path to an image file (uploaded onto server).
     * @return Role object (this) (or Error object)
     */
    function add($rolename, $image=null){
        global $DB,$CFG,$USER,$HUB_SQL;

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
		$params[0] = $currentuser;
		$params[1] = $rolename;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_ROLE_ADD_CHECK, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
        		for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
                    $this->roleid = $array['NodeTypeID'];
                }
                return $this->load();
            } else {
                $this->roleid = getUniqueID();
                $dt = time();
				$params = array();
				$params[0] = $this->roleid;
				$params[1] = $currentuser;
				$params[2] = $dt;
				$params[3] = $rolename;
				$params[4] = $image;
				$res = $DB->insert($HUB_SQL->DATAMODEL_ROLE_ADD, $params);
                /*if ($res) {
                    // add to group
					$params = array();
					$params[0] = $CFG->defaultRoleGroupID;
					$params[1] = $this->roleid;
					$params[2] = $currentuser;
					$params[3] = $dt;
					$res2 = $DB->insert($HUB_SQL->DATAMODEL_ROLE_GROUP_ADD, $params);
                    if (!$res2) {
                        return database_error();
                    }
                } else {
                    return database_error();
                }*/
            }
        } else {
            return database_error();
        }

        return $this->load();
    }

    /**
     * Edit a role
     *
     * @param string $rolename
     * @param string $image, optional parameter local path to an image file (uploaded onto server).
     * @return Role object (this) (or Error object)
     */
    function edit($rolename, $image=null){
        global $DB,$USER,$HUB_FLM,$HUB_SQL,$HUB_CACHE;
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->roleid);
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $rolename;
		$params[1] = $image;
		$params[2] = $this->roleid;
		$params[3] = $currentuser;
		$params[4] = $image;
		$res = $DB->insert($HUB_SQL->DATAMODEL_ROLE_EDIT, $params);
        if (!$res) {
            return database_error();
        } else {
        	//remove old image if new image added
        	if ($image != $this->image &&
        			$this->image != null && $this->image !="" && substr($this->image,0,7) == 'uploads') {
        		unlink($HUB_FLM->createUploadsDirPath($this->image));
        	}
        }

        return $this->load();
    }

    /**
     * Delete this role
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
			$HUB_CACHE->deleteData($this->roleid);
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->roleid;
		$params[1] = $this->roleid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_ROLE_DELETE_CHECK, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}

			// Get the default role for this user
			$defRoleID = getDefaultRoleID();

       		for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $fromContextType = $array['FromContextTypeID'];
                $toContextType = $array['ToContextTypeID'];
                if ($fromContextType == $this->roleid) {
                    $fromContextType = $defRoleID;
                }
                if ($toContextType == $this->roleid) {
                    $toContextType = $defRoleID;
                }

                $c = new Connection($array['TripleID']);
                $c = $c->load();
                if (!auditConnection($USER->userid, $array['TripleID'], $array['Label'], $array['FromID'], $array['ToID'], $array['LinkTypeID'], $fromContextType,  $toContextType, $CFG->actionEdit, format_object('xml',$c))) {
                    return database_error();
                }
            }

			$params = array();
			$params[0] = $defRoleID;
			$params[1] = $this->roleid;
			$params[2] = $currentuser;
			$res1 = $DB->insert($HUB_SQL->DATAMODEL_ROLE_DELETE_UPDATE_TRIPLE_FROM, $params);

			$params = array();
			$params[0] = $defRoleID;
			$params[1] = $this->roleid;
			$params[2] = $currentuser;
			$res2 = $DB->insert($HUB_SQL->DATAMODEL_ROLE_DELETE_UPDATE_TRIPLE_TO, $params);

            if ($res1 && $res2) {
				$params = array();
				$params[0] = $currentuser;
				$params[1] = $this->roleid;
				$res = $DB->delete($HUB_SQL->DATAMODEL_ROLE_DELETE, $params);
                if (!$res) {
                    return database_error();
                } else {
                	//delete any associated user assigned icon
                	if ($this->image != null && $this->image !="" && substr($this->image,0,7) == 'uploads') {
                		unlink($CFG->dirAddress.$this->image);
                	}
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
     * Sets up the default roles for the given user
     *
     * @param string $userid
     * @return Result object (or Error object)
     */
    function setUpDefaultRoles($userid){
        global $CFG,$DB,$HUB_SQL;

  		//really need to change the way the unique identifier is created.
		//have increased to 14, but can't go any bigger or ID will exceed limit of 50 chars.

		$params = array();
		$params[0] = $userid;
		$params[1] = $userid;
		$params[2] = $CFG->defaultUserID;
		$res = $DB->insert($HUB_SQL->DATAMODEL_ROLE_DEFAULT_ROLES, $params);
        if (!$res){
             return database_error();
        } else {
            //add the default groupings for these
			$params = array();
			$params[0] = $CFG->defaultRoleGroupID;
			$params[1] = $userid;
			$res2 = $DB->insert($HUB_SQL->DATAMODEL_ROLE_DEFAULT_ROLES_GROUPS, $params);
            if (!$res2){
                return database_error();
            }
        }
        return new Result("created default roles","true");
    }

    /**
     * Gets the default RoleID for the current user
     *
     * @return String of default role id or Error
     */
    function getDefaultRoleID(){
        global $CFG,$USER,$DB,$HUB_SQL;

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $CFG->DEFAULT_NODE_TYPE;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_ROLE_DEFAULT_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					return $array['NodeTypeID'];
				}
			} else {
				// if there is no default role then add one
				$nr = new Role();
				$nr->add($CFG->DEFAULT_NODE_TYPE);
				return $nr->roleid;
			}
        } else {
        	return database_error();
        }
    }

    /////////////////////////////////////////////////////
    // security functions
    // No canview() function as any user can view any role (is this right?!)
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can add a role
     *
     * @throws Exception
     */
    function canadd(){
    	global $LNG;

        // needs to be logged in - that's all!
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can edit the current role
     *
     * @throws Exception
     */
    function canedit(){
        global $DB,$USER,$HUB_SQL,$LNG;

        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can edit only if owner of the node
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->roleid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_ROLE_CAN_EDIT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
	            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
	        }
        } else {
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can delete the current role
     *
     * @throws Exception
     */
    function candelete(){
        global $DB,$USER,$HUB_SQL,$LNG;

        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can edit only if owner of the node
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->roleid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_ROLE_CAN_DELETE, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
	            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
	        }
        } else {
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }
}
?>