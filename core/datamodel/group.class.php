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
// Group Class
///////////////////////////////////////

class Group {

    public $groupid;
    public $name;
    public $description;
    public $website;
    public $photo;
    public $thumb;
    public $debatecount = 0;
    public $membercount = 0;
    public $positivevotes = 0;
    public $negativevotes = 0;
    public $votes = 0;
    public $isopenjoining = 'N';
    
    public $status = 0;

    //public $location;
    //public $countrycode;
    //public $country;
    //public $locationlat;
    //public $locationlng;
    //public $members;
    //public $pendingmembers;
    //public $owner;

    /**
     * Constructor
     *
     * @param string $groupid (optional)
     * @return Group (this)
     */
    function Group($groupid = ""){
        if ($groupid != ""){
            $this->groupid = $groupid;
            return $this;
        }
    }

    /**
     * Loads the data for the group from the database
     *
     * @return Group object (this)
     */
    function load(){
        global $DB,$CFG,$HUB_FLM,$HUB_SQL,$LNG;

		$params = array();
		$params[0] = $this->groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if($count==0){
				global $ERROR;
				$ERROR = new Hub_Error();
				$ERROR->createGroupNotFoundError($this->groupid);
				return $ERROR;
            }
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $this->name = stripslashes($array['Name']);
                $this->description = stripslashes($array['Description']);
                $this->website = stripslashes($array['Website']);
                $this->isopenjoining = $array['IsOpenJoining'];

                if (isset($array['CurrentStatus'])) {
                    $this->status = (int) $array['CurrentStatus'];
                }                 

				if($array['Photo']){
					//set user photo and thumb the thumb creation is done during registration
					$originalphotopath = $HUB_FLM->createUploadsDirPath($this->groupid."/".stripslashes($array['Photo']));
					if (file_exists($originalphotopath)) {
						$this->photo =  $HUB_FLM->getUploadsWebPath($this->groupid."/".stripslashes($array['Photo']));
						$this->thumb =  $HUB_FLM->getUploadsWebPath($this->groupid."/".str_replace('.','_thumb.', stripslashes($array['Photo'])));
						if (!file_exists($this->thumb)) {
							create_image_thumb($array['Photo'], $CFG->IMAGE_THUMB_WIDTH, $this->groupid);
						}
					} else {
						//if the file does not exists how to get it from a upper level? change it to
						//if file doesnot exists directly using default photo
						$this->photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_GROUP_PHOTO);
						$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_GROUP_PHOTO)));
					}
				} else {
					$this->photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_GROUP_PHOTO);
					$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_GROUP_PHOTO)));
				}

                if(isset($array['LocationText'])){
                    $this->location = $array['LocationText'];
                } else {
                	$this->location = "";
                }

                if(isset($array['LocationCountry'])){
                    $cs = getCountryList();
                    $this->countrycode = $array['LocationCountry'];
                    if (isset($cs[$array['LocationCountry']])) {
	                    $this->country = $cs[$array['LocationCountry']];
	                }
                } else {
                	$this->countrycode = "";
                	$this->country = "";
                }

                if(isset($array['LocationLat'])){
                    $this->locationlat = $array['LocationLat'];
                }
                if(isset($array['LocationLng'])){
                    $this->locationlng = $array['LocationLng'];
                }               
            }
        } else {
            return database_error();
        }

        $this->loadmembers();
        $this->loadpendingmembers();
		$this->getDebateCount();
		$this->getVoteCount();

        return $this;
    }

    /**
     * Loads the members of the group from the database
     *
     * @return Group object (this)
     */
    function loadmembers(){
        global $DB,$CFG,$HUB_SQL;

		$this->members = null;

		$params = array();
		$params[0] = $this->groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_MEMBERS, $params);
    	if (!$resArray) {
    		return database_error();
    	} else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            $us = new UserSet();
            $us->totalno = $count;
            $this->membercount = $us->totalno;
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $u = new User($array['UserID']);
                $u = $u->load();
                if ($array['IsAdmin'] == 'Y') {
                	$u->isAdmin = true;
                } else {
                	$u->isAdmin = false;
                }
                $us->add($u);
             }
             $this->members = $us;
        }
        return $this;
    }

    /**
     * Get the number of debates in this group
     *
     * @return count or Error;
     */
    function getDebateCount(){
        global $DB,$CFG,$HUB_SQL;

		$params = array();
		$params[0] = $this->groupid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_DEBATECOUNT, $params);
    	if (!$resArray) {
    		return database_error();
    	} else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $this->debatecount = $array['debateCount'];
            }
        }

        return $this->debatecount;
    }

    /**
     * Get the number of debates in this group
     *
     * @return count or Error;
     */
	function getVoteCount() {
        global $DB,$CFG,$HUB_SQL;

		$params = array();
		$params[0] = $this->groupid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_VOTECOUNT_NODE, $params);
    	if (!$resArray) {
    		return database_error();
    	} else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$next = $array['VoteType'];
				$this->votes += 1;
				if ($next == 'Y') {
					$this->positivevotes += 1;
				} else if ($next == 'N') {
					$this->negativevotes += 1;
				}
            }
        }

		$params = array();
		$params[0] = $this->groupid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_VOTECOUNT_CONN, $params);
    	if (!$resArray) {
    		return database_error();
    	} else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$next = $array['VoteType'];
				$this->votes += 1;
				if ($next == 'Y') {
					$this->positivevotes += 1;
				} else if ($next == 'N') {
					$this->negativevotes += 1;
				}
            }
        }
	}

    /**
     *  Update if group joining is open or moderated (default is moderated)
     *
     * @param string $isopen 'Y'/'N';
     * @return User object (this) (or Error object)
     */
    function updateIsOpenJoining($isopen){
        global $DB,$HUB_SQL,$USER;

        //check user can add to the group
        if(!$this->isgroupadmin($USER->userid)){
            return access_denied_error();
        }

		$params = array();
		$params[0] = $isopen;
		$params[1] = $this->groupid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_IS_OPEN_JOINING, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->isopenjoining = $isopen;
            return $this;
        }
    }


    /**
     * Checks whether the given user is a member of this group
     *
     * @param string $userid
     * @return boolean
     */
    function ismember($userid){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $this->groupid;
		$params[1] = $userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_IS_MEMBER, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
                return true;
            } else {
            	return false;
            }
        } else {
            return false;
        }
    }

    function groupNameExists($groupname,$groupid = ""){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $groupname;
		$sql = $HUB_SQL->DATAMODEL_GROUP_NAME_EXISTS;
        if ($groupid != ""){
			$params[1] = $groupid;
            $sql .= $HUB_SQL->DATAMODEL_GROUP_NAME_EXISTS_EXTRA;
        }

		$resArray = $DB->select($sql, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count != 0){
				global $ERROR;
				$ERROR = new Hub_Error;
				return $ERROR->createGroupExists($groupname);
			} else {
				return false;
			}
		} else {
			return false;
		}
    }


    /**
     * Adds a new group
     *
     * @param string $groupname
     * @return Group object (this)
     */
    function add($groupname){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can add a group
        try {
            $this->canadd();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check group name doesn't already exist
        $ge = $this->groupNameExists($groupname);
        if($ge instanceof Hub_Error){
            return $ge;
        }

        // add the 'user' (group)
        $user = new User();
        $password = password_hash(getUniqueID()); //dummy (non-blank) password
        $isGroup = 'Y';

        $user = $user->add("",$groupname,$password,"",$isGroup, $CFG->AUTH_TYPE_EVHUB,"",$CFG->USER_STATUS_ACTIVE,$CFG->DEFAULT_GROUP_PHOTO);
		if (!$user instanceof Hub_Error) {
	        $dt = time();
	        //now add the user who created the group as an admin
			$params = array();
			$params[0] = $user->userid;
			$params[1] = $USER->userid;
			$params[2] = $dt;
			$params[3] = 'Y';
			$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_ADD, $params);

			if (!$res) {
	            return database_error();
	        } else {
	            $this->groupid = $user->userid;
	            $this->load();
	            $this->loadmembers();
	            return $this;
	        }
		} else {
			return $user;
		}
    }

    /**
     * Deletes a group
     *
     * @return Result object
     */
    function delete(){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user can delete a group
        if(!$this->candelete()){
            return access_denied_error();
        }

		$params = array();
		$params[0] =  $this->groupid;

        // delete the NodeGroup records
		$res = $DB->delete($HUB_SQL->DATAMODEL_GROUP_NODE_DELETE, $params);
        if (!$res) {
            return database_error();
        }

        // delete the TripleGroup records
		$res = $DB->delete($HUB_SQL->DATAMODEL_GROUP_TRIPLE_DELETE, $params);
        if(!$res){
            return database_error();
        }

        // delete the UserGroup records
		$res = $DB->delete($HUB_SQL->DATAMODEL_GROUP_USER_DELETE, $params);
        if(!$res){
            return database_error();
        }

        // delete the User record
		$res = $DB->delete($HUB_SQL->DATAMODEL_GROUP_DELETE, $params);
        if(!$res){
            return database_error();
        }

        return new Result("deleted","true");
    }

	/**
	 * Update the status for this group
	 *
	 * @return Group object (this) (or Error object)
	 */
	function updateStatus($status){
	    global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->groupid.$this->style);
		}

	    $dt = time();

		$params = array();
		$params[0] = $status;
		$params[1] = $dt;
		$params[2] = $this->groupid;

        // users are groups so we can use the same SQL as users
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_STATUS_UPDATE, $params);
		if (!$res) {
			return database_error();
		} else {
			$this->status = $status;
		    return $this;
		}
	}

    /**
     * Adds a member to the group
     *
     * @param string $userid
     * @return Group object (this)
     */
    function addmember($userid){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can add to the group
        if(($this->isopenjoining == 'N' && !$this->isgroupadmin($USER->userid))){
            return access_denied_error();
        }

        // check user exists
        $user = new User($userid);
        if($user->load() instanceof Hub_Error){
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
        }

        // check user isn't already in group
		$params = array();
		$params[0] = $userid;
		$params[1] = $this->groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_MEMBER_ADD_CHECK, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count == 0) {

				$dt = time();
				$params = array();
				$params[0] = $this->groupid;
				$params[1] = $userid;
				$params[2] = $dt;
				$params[3] = 'N';

				$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_MEMBER_ADD, $params);
				if( !$res ) {
					return database_error();
				}
			}
		} else {
			return database_error();
		}

        // send notification email
        // first check that their account is validated (ie there isn't an outstanding validation code)

        /*
        if($user->getInvitationCode() == ""){
            //send group member email
            if ($this->photo != ""){
                $temp_image = "<img src='".$this->photo."' alt='logo for ".$this->name."'/><br/>";
            } else {
                $temp_image = "";
            }
            if ($this->description != ""){
                $temp_desc = "<p>".$this->description."</p>";
            } else {
                $temp_desc = "";
            }
            $paramArray = array ($user->name,
                                    $USER->name,
                                    $temp_image,
                                    $CFG->homeAddress."group.php?groupid=".$this->groupid,
                                    $this->name,
                                    $temp_desc,
                                    $USER->getEmail(),
                                    $USER->name,
                                    $CFG->homeAddress."contact.php");
            sendMail("groupmember","New Cohere group: ".$this->name,$user->getEmail(),$paramArray);
        } else {
            //send invite
            $user->sendGroupInvitation($this->groupid);
        }
        */

        $this->load();
        $this->loadmembers();
        return $this;
    }

    /**
     * Makes a member an admin of the group
     *
     * @param string $userid
     * @return Group object (this)
     */
    function makeadmin($userid){
        global $DB,$CFG,$USER,$HUB_SQL,$LNG;
        //check user can add to the group
        if(!$this->isgroupadmin($USER->userid)){
            return access_denied_error();
        }

        // check user exists
        $user = new User($userid);
        if($user->load() instanceof Hub_Error) {
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
        }

        // now add the user
		$params = array();
		$params[0] = 'Y';
		$params[1] = $this->groupid;
		$params[2] = $userid;

		$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_MAKE_ADMIN, $params);
        if( !$res ) {
            return database_error();
        }

        $this->load();
        $this->loadmembers();
        return $this;
    }

    /**
     * Remove a member as admin of the group
     * (they will remain a group member though)
     *
     * @param string $userid
     * @return Group object (this)
     */
    function removeadmin($userid){
        global $DB,$CFG,$USER,$HUB_SQL,$LNG;
        //check user can add to the group
        if(!$this->isgroupadmin($USER->userid)){
            return access_denied_error();
        }

        // check user exists
        $user = new User($userid);
        if($user->load() instanceof Hub_Error){
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
        }

        // can only remove if there is at least one other admin left
		$params = array();
		$params[0] = 'Y';
		$params[1] = $this->groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_REMOVE_ADMIN_CHECK, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count < 2) {
            	return database_error($LNG->CORE_DATAMODEL_GROUP_CANNOT_REMOVE_MEMBER,"7002");
            }
        } else {
        	return database_error();
        }

        // now add the user
		$params = array();
		$params[0] = 'N';
		$params[1] = $this->groupid;
		$params[2] = $userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_REMOVE_ADMIN_UPDATE, $params);
        if( !$res ) {
            return database_error();
        }

        $this->load();
        $this->loadmembers();
        return $this;
    }

    /**
     * Remove a member of the group
     *
     * @param string $userid
     * @return Group object (this)
     */
    function removemember($userid){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user can add to the group
        if(!$this->isgroupadmin($USER->userid)){
            return access_denied_error();
        }

        // check user exists
        $user = new User($userid);
        if($user->load() instanceof Hub_Error){
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
        }

        // remove them as admin (if they are already)
        if(($this->isgroupadmin($userid)) && ($this->removeadmin($userid) instanceof Hub_Error)){
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createGroupLastAdmin($userid);
        }

        // remove the user from the group
		$params = array();
		$params[0] = $this->groupid;
		$params[1] = $userid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_GROUP_MEMBER_DELETE, $params);
        if( !$res ) {
            return database_error();
        } else {
        	$this->reportpendingmember($userid);
        }

        $this->load();
        $this->loadmembers();
        return $this;
    }

    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can add a group
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
     * Check whether the given user is an admin for this group
     *
     * @return true if given use is a group admin else false or error if there is a database error
     */
    function isgroupadmin($userid){
        global $DB,$HUB_SQL;
        if(api_check_login() instanceof Hub_Error){
            return false;
        }

        //can edit only if admin for the group
		$params = array();
		$params[0] = $this->groupid;
		$params[1] = $userid;
		$params[2] = 'Y';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_IS_ADMIN, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count == 0) {
        		return false;
        	} else {
        		return true;
        	}
        } else {
        	return database_error();
        }
    }

    /**
     * Check whether the current user can delete the group
     *
     * @throws Exception
     */
    function candelete(){
        global $USER;
        // needs to be an admin
        return $this->isgroupadmin($USER->userid);
    }


    /////////////////////////////////////////////////////
    // Group Joining Moderation
    /////////////////////////////////////////////////////

	/**
	 * Add the given user to this Group's joining request list.
	 * @param $userid the id of the user who wishes to join the group.
	 * @return true if it all went well, else Error.
	 */
	 function joinrequest($userid) {
		global $CFG, $DB, $USER, $HUB_SQL;

        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		// check user exists
		$user = new User($userid);
		if($user->load() instanceof Hub_Error) {
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
		}

		$dt = time();
		$params = array();
		$params[0] = $this->groupid;
		$params[1] = $userid;
		$params[2] = $userid;
		$params[3] = $dt;

		$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_JOIN_ADD, $params);
		if ($res) {
			return true;
		} else {
			return database_error($DB->conn);
		}
	}

    /**
     * Checks whether the given user is a pending member of this group
     *
     * @param string $userid
     * @return boolean
     */
    function ispendingmember($userid){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $this->groupid;
		$params[1] = $userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_IS_PENDING_MEMBER, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
                return true;
            } else {
            	return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Checks whether the given user is a rejected member of this group
     *
     * @param string $userid
     * @return boolean
     */
    function isrejectedmember($userid){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $this->groupid;
		$params[1] = $userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_IS_REJECTED_MEMBER, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
                return true;
            } else {
            	return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Checks whether the given user is a reported member of this group
     *
     * @param string $userid
     * @return boolean
     */
    function isreportedmember($userid){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $this->groupid;
		$params[1] = $userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_IS_REPORTED_MEMBER, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
                return true;
            } else {
            	return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Loads the pending members of the group from the database.
     * Only group admins can run this function.
     *
     * @return Group object (this)
     */
    function loadpendingmembers(){
        global $DB,$CFG,$HUB_SQL, $USER;

		//check user can edit the group
		if(!$this->isgroupadmin($USER->userid)){
			return access_denied_error();
		}

		$this->pendingmembers = null;

		$params = array();
		$params[0] = $this->groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_GROUP_JOIN_SELECT_PENDING, $params);
    	if (!$resArray) {
    		return database_error();
    	} else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            $us = new UserSet();
            $us->totalno = $count;
            //$this->membercount = $us->totalno;
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $u = new User($array['UserID']);
                $us->add($u->load());
             }
             $this->pendingmembers = $us;
        }
        return $this;
    }

	/**
	 * Reject the join request of the given user to join this group
     * Only group admins can run this function.
	 *
	 * @param string $userid of the user to reject
	 * @return Group object (this)
	 */
	function rejectpendingmember($userid){
		global $DB,$CFG,$USER,$HUB_SQL,$LNG;

		//check user can edit the group
		if(!$this->isgroupadmin($USER->userid)){
			return access_denied_error();
		}

		// check user exists
		$user = new User($userid);
		if($user->load() instanceof Hub_Error) {
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
		}

		// now add the user
		$params = array();
		$params[0] = $USER->userid;
		$params[1] = time();
		$params[2] = $this->groupid;
		$params[3] = $userid;

		$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_JOIN_REJECT, $params);
		if( !$res ) {
			return database_error();
		} else {
			$newmember = new User($userid);
			$newmember = $newmember->load();
			$paramArray = array ($newmember->name,$CFG->homeAddress,$this->groupid,$this->name,$CFG->SITE_TITLE);
			sendMail("groupjoinrejected",$LNG->VALIDATE_GROUP_JOIN_SUBJECT,$newmember->getEmail(),$paramArray);
		}

		$this->load();
		$this->loadpendingmembers();
		return $this;
	}

	/**
	 * Approve the join request of the given user to join this group
     * Only group admins can run this function.
	 *
	 * @param string $userid of the user to reject
	 * @return Group object (this)
	 */
	function approvependingmember($userid){
		global $DB,$CFG,$USER,$HUB_SQL,$LNG;

		//check user can edit the group
		if(!$this->isgroupadmin($USER->userid)){
			return access_denied_error();
		}

		// check user exists
		$user = new User($userid);
		if($user->load() instanceof Hub_Error) {
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
		}

		// now add the user
		$params = array();
		$params[0] = $USER->userid;
		$params[1] = time();
		$params[2] = $this->groupid;
		$params[3] = $userid;

		$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_JOIN_ACTIVE, $params);
		if( !$res ) {
			return database_error();
		} else {
			$reply = $this->addmember($userid);
			if (!$reply instanceof Hub_Error) {
				$reply->loadpendingmembers();

				$newmember = new User($userid);
				$newmember = $newmember->load();
				$paramArray = array ($newmember->name,$CFG->homeAddress,$this->groupid,$this->name,$CFG->SITE_TITLE);
				sendMail("groupjoinapproved",$LNG->VALIDATE_GROUP_JOIN_SUBJECT,$newmember->getEmail(),$paramArray);
			}
			return $reply;
		}
	}

	/**
	 * Mark that this user was removed from the group by marking thier requested record as reported
     * Only group admins can run this function.
	 *
	 * @param string $userid of the user to mark as reported
	 * @return Group object (this)
	 */
	function reportpendingmember($userid){
		global $DB,$CFG,$USER,$HUB_SQL,$LNG;

		//check user can edit the group
		if(!$this->isgroupadmin($USER->userid)){
			return access_denied_error();
		}

		// check user exists
		$user = new User($userid);
		if($user->load() instanceof Hub_Error) {
			global $ERROR;
			$ERROR = new Hub_Error;
			return $ERROR->createUserNotFoundError($userid);
		}

		// now add the user
		$params = array();
		$params[0] = $USER->userid;
		$params[1] = time();
		$params[2] = $this->groupid;
		$params[3] = $userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_GROUP_JOIN_REPORT, $params);
		if( !$res ) {
			return database_error();
		}
		return $this;
	}
}
?>