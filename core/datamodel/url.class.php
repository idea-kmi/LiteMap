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
// URL Class
///////////////////////////////////////

class URL {

    public $urlid;
    public $url;
    public $creationdate;
    public $title;
    public $description;
    public $modificationdate;
    public $userid;
    public $user;
    public $clip;
    public $ideacount;
    public $status = 0;
    public $clippath = "";
    public $cliphtml = "";
    public $private;

    public $createdfrom = "";
    public $identifier = "";

    public $tags;
    public $groups;

    public $style = 'long';

    /**
     * Constructor
     *
     * @param string $urlid (optional)
     * @return URL (this)
     */
    function URL($urlid = ""){
        if ($urlid != ""){
            $this->urlid = $urlid;
            return $this;
        }
    }

    /**
     * Loads the data for the node from the database
     *
     * @return URL object (this)
     */
    function load($style='long') {
        global $DB,$ERROR,$HUB_FLM,$HUB_SQL,$HUB_CACHE,$CFG;

        try {
            $this->canview();
        } catch (Exception $e){
            return access_denied_error();
        }

		$this->style = $style;
		if (isset($HUB_CACHE)) {
			$cachedused = $HUB_CACHE->getObjData($this->urlid.$this->style);
			if ($cachedused !== FALSE) {
				return $cachedused;
			}
		}

		$params = array();
		$params[0] = $this->urlid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_SELECT, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createUrlNotFoundError($this->urlid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];

					$this->url = stripslashes($array['URL']);
					$this->description = stripslashes($array['Description']);
					$this->userid = $array['UserID'];
					$this->title = stripslashes($array['Title']);
					$this->creationdate = $array['CreationDate'];
					$this->modificationdate = $array['ModificationDate'];
					$this->clip = $array['Clip'];
					$this->private = $array['Private'];
					if (isset($array['ClipPath'])) {
						$this->clippath = $array['ClipPath'];
					}
					if (isset($array['ClipHTML'])) {
						$this->cliphtml = $array['ClipHTML'];
					}
					$this->user = new user($this->userid);
					if (isset($array['CurrentStatus'])) {
						$this->status = $array['CurrentStatus'];
					}
					if (isset($array['AdditionalIdentifier'])) {
						$this->identifier = $array['AdditionalIdentifier'];
					}
					if (isset($array['CreatedFrom'])) {
						$this->createdfrom = $array['CreatedFrom'];
					}
				}
			}
       	} else {
       		return database_error();
       	}

		// Virtuoso required this part to be in a separate statement.
		// Was originally part of the select.
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_IDEA_COUNT, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createUrlNotFoundError($this->urlid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->ideacount = $array['ideacount'];
				}
			}
       	} else {
       		return database_error();
       	}

       	if($style=='long') {
	        //now add in any tags
			$params = array();
			$params[0] = $this->urlid;
			$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_TAGS_SELECT, $params);
			if ($resArray !== false) {
				$count = 0;
				if (is_countable($resArray)) {
					$count = count($resArray);
				}
				if ($count > 0) {
					$this->tags = array();
					for ($i=0; $i<$count; $i++) {
						$array = $resArray[$i];
						$tag = new Tag(trim($array['TagID']));
						array_push($this->tags,$tag->load());
					}
				}
	        } else {
       			return database_error();
       		}

	        // add in the groups
			$params = array();
			$params[0] = $this->urlid;
			$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_GROUPS_SELECT, $params);
			if ($resArray !== false) {
				$count = 0;
				if (is_countable($resArray)) {
					$count = count($resArray);
				}
				if ($count > 0) {
					$this->groups = array();
					for ($i=0; $i<$count; $i++) {
						$array = $resArray[$i];
						$group = new Group(trim($array['GroupID']));
						array_push($this->groups,$group->load());
					}
				}
	        } else {
       			return database_error();
       		}
		}

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->setObjData($this->urlid.$this->style, $this, $CFG->CACHE_DEFAULT_TIMEOUT);
		}

        return $this;
    }

    /**
     * Add new URL to the database
     *
     * @param string $url
     * @param string $title
     * @param string $desc
     * @param string $private optional, can be Y or N, defaults to users preferred setting
     * @param string $clip (optional)
     * @param string $clippath (optional) - only used by Firefox plugin
     * @param string $cliphtml (optional) - only used by Firefox plugin
	 * @param string $createdfrom (optional) - only used for Utopia, rss, compendium
	 * @param string $indentifier (optional) an additional identifier, json with mutiple identitifer - only really used for Utopia
     * @return URL object (this) (or Error object)
     */
    function add($url, $title, $desc, $private='Y', $clip="", $clippath="", $cliphtml = "", $createdfrom="", $identifier=""){
        global $DB,$CFG,$USER,$HUB_SQL;
        try {
            $this->canadd();
        } catch (Exception $e){
            return access_denied_error();
        }
        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $url;

        $qry1 = "";
        if ($clippath != "") {
        	$params[2] = $clippath;
        	$qry1 = $HUB_SQL->DATAMODEL_URL_ADD_CHECK_CLIPPATH;
        } else {
        	$params[2] = $clip;
        	$qry1 = $HUB_SQL->DATAMODEL_URL_ADD_CHECK_CLIP;
        }

		$resArray = $DB->select($qry1, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
                    $this->urlid = $array['URLID'];
                }
            } else {
                $this->urlid = getUniqueID();
				$params = array();
				$params[0] = $this->urlid;
				$params[1] = $currentuser;
				$params[2] = $dt;
				$params[3] = $dt;
				$params[4] = $url;
				$params[5] = $title;
				$params[6] = $desc;
				$params[7] = $clip;
				$params[8] = $clippath;
				$params[9] = $cliphtml;
				$params[10] = $private;
				$params[11] = $createdfrom;
				$params[12] = $identifier;

				$res = $DB->insert($HUB_SQL->DATAMODEL_URL_ADD, $params);
                if( !$res ) {
                    return database_error();
                }
            }
        } else {
        	return database_error();
        }

        $this->load();
        if (!auditURL($USER->userid, $this->urlid, "", $url, $title, $desc, $clip, $clippath, $cliphtml, "", $CFG->actionAdd,format_object('xml',$this))) {
            return database_error();
        }
        return $this;
    }

    /**
     * Edit a URL
     *
     * @param string $url
     * @param string $title
     * @param string $desc
     * @param string $private optional, can be Y or N, defaults to users preferred setting
     * @param string $clip (optional)
     * @param string $clippath (optional) - only used by Firefox plugin
     * @param string $cliphtml (optional) - only used by Firefox plugin
     * @param string $createdfrom (optional)
     * @param string $identifier (optional)
     * @return URL object (this) (or Error object)
     */
    function edit($url, $title, $desc, $private='Y', $clip="", $clippath="", $cliphtml = "", $createdfrom="", $identifier=""){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}
        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $url;

        //added check to make sure the edit does not duplicate an existing item
        $qry1 = "";
        if ($clippath != "") {
        	$params[2] = $clippath;
        	$qry1 = $HUB_SQL->DATAMODEL_URL_EDIT_CHECK_CLIPPATH;
        } else {
        	$params[2] = $clip;
        	$qry1 = $HUB_SQL->DATAMODEL_URL_EDIT_CHECK_CLIP;
        }

		$resArray = $DB->select($qry1, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
        	$runUpdate = false;
			if ($count > 0) {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
                	if ($this->urlid != $array['URLID']) {
		                return database_error($LNG->CORE_URL_EXISTS_ALREADY);
                	} else {
                		$runUpdate = true;
                	}
                	break;
                }
            } else {
            	// so you can edit the url when the parent Resource node has the url changed
            	$runUpdate = true;
            }

            if ($runUpdate) {

				$params = array();
				$params[0] = $dt;
				$params[1] = $url;
				$params[2] = $clip;
				$params[3] = $desc;
				$params[4] = $title;
				$params[5] = $private;
				$params[6] = $clippath;
				$params[7] = $cliphtml;
				$params[8] = $createdfrom;
				$params[9] = $identifier;
				$params[10] = $this->urlid;

				$res = $DB->insert($HUB_SQL->DATAMODEL_URL_EDIT, $params);
				if( !$res ) {
					return database_error();
				} else {
					if (!auditURL($USER->userid, $this->urlid, "", $url, $title, $desc, $clip, $clippath, $cliphtml, "", $CFG->actionEdit, format_object('xml',$this))) {
						return database_error("URL Audit entry failed");
					}
				}
            }
         } else {
        	 return database_error();
         }

         return $this->load();
    }

    /**
     * Delete a URL
     */
    function delete(){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}
        $dt = time();

		$this->load();
		$xml = format_object('xml',$this);

        //remove any node associations.

		$params = array();
		$params[0] = $this->urlid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_DELETE_CHECK, $params);
		if (!$resArray) {
            return database_error();
        } else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
                $this->nodeid = $array['NodeID'];

				$currentuser = '';
				if (isset($USER->userid)) {
					$currentuser = $USER->userid;
				}
				$params = array();
				$params[0] = $this->nodeid;
				$params[1] = $this->urlid;
				$params[2] = $currentuser;

				$res = $DB->delete($HUB_SQL->DATAMODEL_URL_URLNODE_DELETE, $params);
	            if ($res) {
	                if (!auditURL($USER->userid, $this->urlid, $this->nodeid, "","","", "", "", "", "", $CFG->actionDelete, $xml)) {
	                    return database_error();
	                }
	            } else {
	                return database_error();
	            }
            }
        }

        //delete
		$params = array();
		$params[0] = $this->urlid;
		$res1 = $DB->delete($HUB_SQL->DATAMODEL_URL_DELETE, $params);
        if ($res1) {
			if (!auditURL($USER->userid, $this->urlid, "", $this->url, $this->title, $this->description, $this->clip, $this->clippath, $this->cliphtml, "", $CFG->actionDelete, $xml)) {
				return database_error();
			}
		}

        return new Result("deleted","true");
    }


    /**
     * Set the privacy setting of this node
     *
     * @return URL object (this) (or Error object)
     */
    function updateAdditionalIdentifier($identifier){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

        //check user owns the url
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        $dt = time();

		$params = array();
		$params[0] = $identifier;
		$params[1] = $dt;
		$params[2] = $this->urlid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_URL_ADDITIONAL_IDENTIFIER_UPDATE, $params);
		if (!res) {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Set the privacy setting of this url
     *
     * @return URL object (this) (or Error object)
     */
    function setPrivacy($private){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

        //check user owns the url
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        $dt = time();

		$params = array();
		$params[0] = $private;
		$params[1] = $dt;
		$params[2] = $this->urlid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_URL_PRIVACY_UPDATE, $params);
		if (!res) {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Add group to this url
     *
     * @param string $groupid
     * @return URL object (this) (or Error object)
     */
    function addGroup($groupid){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        //check user member of group
        $group = new Group($groupid);
        $group->load();
        if(!$group->ismember($USER->userid)){
           return access_denied_error();
        }

        // check group not already in url

		$params = array();
		$params[0] = $this->urlid;
		$params[1] = $groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_GROUP_ADD_CHECK, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$dt = time();
				$params = array();
				$params[0] = $this->urlid;
				$params[1] = $groupid;
				$params[2] = $dt;
				$res = $DB->insert($HUB_SQL->DATAMODEL_URL_GROUP_ADD, $params);
				if (!res) {
					return database_error();
				}
			}
        } else {
        	return database_error();
        }

        return $this->load();
    }

    /**
     * Remove group from this node
     *
     * @param string $groupid
     * @return Node object (this) (or Error object)
     */
    function removeGroup($groupid){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        //check user member of group
        $group = new Group($groupid);
        $group->load();
        if(!$group->ismember($USER->userid)){
           return access_denied_error();
        }

        // check group not already in node
		$params = array();
		$params[0] = $this->urlid;
		$params[1] = $groupid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_URL_GROUP_DELETE, $params);
		if (!res) {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Remove all groups from this Node
     *
     * @return Node object (this) (or Error object)
     */
    function removeAllGroups(){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

		$params = array();
		$params[0] = $this->urlid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_URL_GROUP_DELETE_ALL, $params);
		if (!res) {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Add a Tag to this url
     *
     * @param string $tagid
     * @return URL object (this) (or Error object)
     */
    function addTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

        //check user can edit the url
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag = $tag->load();
        try {
        	$tag->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->urlid;
		$params[1] = $tagid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_TAG_ADD_CHECK, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$params = array();
				$params[0] = $currentuser;
				$params[1] = $tagid;
				$params[2] = $this->urlid;
				$res = $DB->insert($HUB_SQL->DATAMODEL_URL_TAG_ADD, $params);
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
     * Remove a Tag from this url
     *
     * @param string $urlid
     * @return URL object (this) (or Error object)
     */
    function removeTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

        //check user can edit the url
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag = $tag->load();
        try {
        	$tag->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->urlid;
		$params[1] = $tagid;
		$params[2] = $currentuser;
		$res = $DB->delete($HUB_SQL->DATAMODEL_URL_TAG_DELETE, $params);
		if (!res) {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Add a Node to this URL
     *
     * @param string $nodeid
     * @param string $comments
     * @return URL object (this) (or Error object)
     */
    function addIdea($nodeid,$comments){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        //check user can edit the URL
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
        //check user can edit the Node
        $node = new CNode($nodeid);
        $node = $node->load();
        try {
        	$node->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->urlid;
		$params[1] = $nodeid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_IDEA_ADD_CHECK, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$params = array();
				$params[0] = $currentuser;
				$params[1] = $this->urlid;
				$params[2] = $nodeid;
				$params[3] = $dt;
				$params[4] = $dt;
				$params[5] = $comments;
				$res = $DB->insert($HUB_SQL->DATAMODEL_URL_IDEA_ADD, $params);
                if ($res) {
                    if (!auditURL($USER->userid, $this->urlid, $nodeid, $this->urlid, "", "", "", "", "", "", $comments, $CFG->actionAdd,format_object('xml',$node))) {
                        return database_error();
                    }
                } else {
                     return database_error();
                }
            }
        } else {
        	return database_error();
        }

        return $this->load();
    }

    /**
     * Remove a URL from this node
     *
     * @param string $nodeid
     * @return URL object (this) (or Error object)
     */
    function removeIdea($nodeid){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;
        //check user can edit the URL
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
        //check user can edit the Node
        $node = new CNode($nodeid);
        $node = $node->load();
        try {
        	$node->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $nodeid;
		$params[1] = $this->urlid;
		$params[2] = $currentuser;
		$res = $DB->delete($HUB_SQL->DATAMODEL_URL_IDEA_DELETE, $params);
		if (res) {
            if (!auditURL($USER->userid, $this->urlid, $nodeid, "", "", "", "", "", "", "", $CFG->actionDelete, format_object('xml',$node))) {
                return database_error();
            }
		} else {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Update the status for this url
     *
     * @return URL object (this) (or Error object)
     */
    function updateStatus($status){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

		// Should this not be checking if can edit?
		// Maybe used by admin code? in which case should check if admin
		// What about reporting spam which can be anyone?
		// only used in Cohere really.

        //check user can edit the URL or is an admin
        /*try {
            $this->canedit();
        } catch (Exception $e) {
        	if ($USER->getIsAdmin() != "Y") {
        	    return access_denied_error();
        	}
        }*/

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->urlid.$this->style);
		}

        $dt = time();

		$params = array();
		$params[0] = $status;
		$params[1] = $dt;
		$params[2] = $this->urlid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_URL_STATUS_UPDATE, $params);
		if (!$res) {
			return database_error();
		}

        return $this->load();
    }


    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can view the current URL
     *
     * @throws Exception
     */
    function canview(){
        global $DB,$CFG,$USER,$HUB_SQL,$LNG;

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->urlid;
		$params[1] = 'N';
		$params[2] = $currentuser;
		$params[3] = $this->urlid;
		$params[4] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_CAN_VIEW, $params);
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
     * Check whether the current user can add a URL
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
     * Check whether the current user can edit the current URL
     *
     * @throws Exception
     */
    function canedit(){
        global $DB,$USER,$HUB_SQL,$LNG;
        if(api_check_login() instanceof Hub_Error){
            throw new Exception("access denied");
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can edit only if owner of the node
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->urlid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_CAN_EDIT, $params);
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
     * Check whether the current user can delete the current URL
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

        //can delete only if owner of the node
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->urlid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_CAN_DELETE, $params);
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

    /////////////////////////////////////////////////////
    // helper functions
    /////////////////////////////////////////////////////
    /**
     * How many times this website has been connected to an idea
     *
     * @return integer
     */
    function getWebsiteAssociationUsage() {
        global $DB,$CFG,$HUB_SQL;
        $usage = 0;

		$params = array();
		$params[0] = $this->urlid;
		$params[1] = $this->userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_URL_WESITE_USAGE, $params);
		if ($resArray !== false) {
            $usage = $resArray[0]['urlcount'];
        }
        return $usage;
    }
}
?>