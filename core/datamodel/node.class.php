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
// Node Class
///////////////////////////////////////

class CNode {

    public $nodeid;
    public $name;
    public $creationdate;
    public $modificationdate;
    public $private;
    public $users;
    public $status = 0;
    public $positivevotes = 0;
    public $negativevotes = 0;
    public $viewcount = 0;
	public $properties;
	public $mapcount = 0;
	public $style = 'long';
	public $imagedir = "";

	public $procount = 0;
	public $concount = 0;
	public $othercount = 0;

	/** SHORT **/
    public $otheruserconnections;
    private $locationaddress1;
    private $locationaddress2;
    private $locationpostcode;

    /*
     * The following is commented out to prevent empty properties appearing as
     * it just uses up more space when getting the node/connection
     *
    public $identifier;
    public $description;
    public $startdatetime;
    public $enddatetime;
    public $location;
    public $countrycode;
    public $country;
    public $locationlat;
    public $locationlng;
    public $urls;
    public $groups;
    public $tags;
    public $image;
    public $thumb;
    public $role;
    public $uservote;
    public $userfollow;
    public $connectedness;
    public $resourcescount;
    public $activity;
    public $votes;
    */

    /**
     * Constructor
     *
     * @param string $nodeid (optional)
     * @return Node (this)
     */
    function CNode($nodeid = ""){
        if ($nodeid != ""){
            $this->nodeid = $nodeid;
            return $this;
        }
    }

    /**
     * Loads the data for the node from the database
     *
     * @param String $style (optional - default 'long') may be 'short' or 'long' or 'mini' or 'full' or 'shortactivity' or 'cif' (mini used for graphs)
     * 'mini' include the base information like name, description, role, user, private, creation and modifications dates, connectedness, image, thumb.
	 * 'short' includes 'mini' plus address information, start and end date, otherconnections, userfollow.
	 * 'map' includes 'mini' plus voting, websites.
     * 'long' includes 'short' and associated website objects, tag objects, group onjects, votes, view counts and extra properties.
     * 'full' includes 'long' and all activity and voting data. This is likely to be very heavy. Use wisely.
     * 'shortactivity' includes 'short' plus the activity and voting data.
     * 'cif' just what is needed for cif.
     * @return Node object (this)
     */
    function load($style = 'long') {
        global $DB,$CFG, $USER,$ERROR,$HUB_FLM,$HUB_SQL;

        try {
            $this->canview();
        } catch (Exception $e){
            return access_denied_error();
        }
		$this->style = $style;

		$params = array();
		$params[0] = $this->nodeid;

  		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createNodeNotFoundError($this->nodeid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];

					$this->name = stripslashes(trim($array['Name']));
					$this->creationdate = $array['CreationDate'];
					$this->modificationdate = $array['ModificationDate'];
					if(isset($array['NodeTypeID'])){
						$this->role = new Role($array['NodeTypeID']);
						$this->role = $this->role->load();
					}
					if (trim($array['Description']) != "") {
						$this->hasdesc = true;
					}

					if ($style == 'long' || $style == 'cif'){
						$this->description = stripslashes(trim($array['Description']));
					}

					$this->users = array();
					if ($style == 'cif') {
						//CIF does not need the whole user info at present
						// or just userid at this level?
						$this->users[0] = new User($array['UserID']);
					} else {
						$maps = getMapsForNode($this->nodeid,0,0);
						$this->mapcount = $maps->totalno;

						$this->connectedness = $array['connectedness'];
						$this->private = $array['Private'];
						$this->users[0] = getUser($array['UserID'],$style);

						if($array['Image']){
							$this->filename = $array['Image'];
							$this->imagedir = $HUB_FLM->getUploadsNodeDir($this->nodeid, $array['UserID']);
							$originalphotopath = $HUB_FLM->createUploadsDirPath($this->imagedir."/".stripslashes($array['Image']));
							if (file_exists($originalphotopath)) {
								$this->image =  $HUB_FLM->getUploadsWebPath($this->imagedir."/".stripslashes($array['Image']));
								$this->thumb =  $HUB_FLM->getUploadsWebPath($this->imagedir."/".str_replace('.','_thumb.', stripslashes($array['Image'])));
								if (!file_exists($this->thumb)) {
									create_image_thumb($array['Image'], $CFG->IMAGE_THUMB_WIDTH, $this->imagedir);
								}
							} else {
								if ($this->role->name == 'Map') {
									$this->image =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_ISSUE_PHOTO);
									$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_ISSUE_PHOTO)));
								}
							}
						} else {
							if ($this->role->name == 'Map') {
								$this->image =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_ISSUE_PHOTO);
								$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_ISSUE_PHOTO)));
							} else {
								$this->image = "";
								$this->thumb = "";
							}
						}

						//if(isset($array['Image'])){
						//    $this->imageurlid = $array['Image'];
						//}
						//if(isset($array['ImageThumbnail'])){
						//    $this->thum = $array['ImageThumbnail'];
						//}

						if ($style != 'mini' && $style != 'map') {
							if(isset($array['StartDate']) && $array['StartDate'] != 0){
								$this->startdatetime = $array['StartDate'];
							}
							if(isset($array['EndDate']) && $array['EndDate'] != 0){
								$this->enddatetime = $array['EndDate'];
							}
							if(isset($array['LocationText'])){
								$this->location = $array['LocationText'];
							} else {
								$this->location = '';
							}
							if(isset($array['LocationCountry'])){
								$cs = getCountryList();
								$this->countrycode = $array['LocationCountry'];
								if (isset($cs[$array['LocationCountry']])) {
									$this->country = $cs[$array['LocationCountry']];
								}
							}
							if(isset($array['LocationLat'])){
								$this->locationlat = $array['LocationLat'];
							}
							if(isset($array['LocationLng'])){
								$this->locationlng = $array['LocationLng'];
							}
							if(isset($array['LocationAddress1'])){
								$this->locationaddress1 = $array['LocationAddress1'];
							}
							if(isset($array['LocationAddress2'])){
								$this->locationaddress2 = $array['LocationAddress2'];
							}
							if(isset($array['LocationPostCode'])){
								$this->locationpostcode = $array['LocationPostCode'];
							}
							if (isset($array['AdditionalIdentifier'])) {
								$this->identifier = $array['AdditionalIdentifier'];
							}
							if (isset($array['CurrentStatus'])) {
								$this->status = $array['CurrentStatus'];
							}
						}
					}
				}
			}
        } else {
        	return database_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		if ($style != 'mini' && $style != 'cif' && $style != 'map') {
			$params = array();
			$params[0] = $this->nodeid;
			$params[1] = $this->nodeid;
			$params[2] = $currentuser;
			$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_EXTERNAL_CONNECTIONS, $params);
			if ($resArray !== false) {
				$count = 0;
				if (is_countable($resArray)) {
					$count = count($resArray);
				}
				if($count > 0 ){
					$this->otheruserconnections = $resArray[0]['connectedness'];
				} else {
					$this->otheruserconnections = 0;
				}
			}

			$this->userfollow = "N";
			//load the current user's following status for this node if any
			$params = array();
			$params[0] = $currentuser;
			$params[1] = $this->nodeid;
			$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_USER_FOLLOW, $params);
			if ($resArray !== false) {
				$count = 0;
				if (is_countable($resArray)) {
					$count = count($resArray);
				}
				if($count > 0 ){
					$this->userfollow = "Y";
				}
			}
		}

        if ($style == 'map' || $style == 'long' || $style == 'full' || $style == 'cif'){
	       	$this->loadWebsites($style);
		}

        if ($style == 'long' || $style == 'full'){
	        $this->loadTags();
	        $this->loadGroups();
        	$this->loadProperties();
			$this->loadViewCount();
        }

        if ($style == 'map' || $style == 'long' || $style == 'full'){
	        $this->loadVotes();
        }

		if ($style == 'full' || $style == 'shortactivity') {
			$this->activity = getAllNodeActivity($this->nodeid, 0, 0, -1);
			$this->votes = getVotes($this->nodeid);
		}

		//load comments, pro count and con count if Solution.
		/*if ($this->role->name == "Solution") {
			$this->haschildren = 'N';
			$conSetKids = getConnectionsByNode($this->nodeid,0,0,'date','ASC', 'all', '', 'Pro,Con,Comment');
			if (!$conSetKids instanceof Hub_Error) {
				if ($conSetKids->totalno > 0) {
					$this->haschildren = 'Y';
				}
			} else {
				return database_error();
			}
		}*/

        return $this;
    }

	function loadViewCount() {
        global $DB,$CFG,$USER,$HUB_SQL;

		$params = array();
		$params[0] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_VIEW_COUNT, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
				$array = $resArray[0];
				$this->viewcount = $array['ViewCount'];
			}
        } else {
        	return database_error();
        }
	}

	function loadProperties() {
        global $DB,$CFG,$USER,$HUB_SQL;

		$this->properties = array();

		$params = array();
		$params[0] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_PROPERTY_LOAD, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->properties[$array['Property']] = $array['Value'];
				}
			}
        } else {
        	return database_error();
        }
	}

	/**
	 * Load Associated vote counts
	 */
	function loadVotes() {
        global $DB,$CFG,$USER,$HUB_SQL;

        //load positive votes

		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = 'Y';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_VOTES, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
        		$this->positivevotes = $resArray[0]['VoteCount'];
        	}
		} else {
			$this->positivevotes = 0;
		}

        //load negative votes
		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = 'N';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_VOTES, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
        		$this->negativevotes = $resArray[0]['VoteCount'];
        	}
		} else {
        	$this->negativevotes = 0;
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //load the current user's vote for this node if any
        $this->uservote = '0';
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_VOTES_USER, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
            	$this->uservote = $resArray[0]['VoteType'];
            }
       	}
	}

	/**
	 * Load Associated websites
     * @param String $style (optional - default 'long') may be 'short' or 'long'
	 */
	function loadWebsites($style = 'long') {
        global $DB,$CFG,$USER,$HUB_SQL;

		$params = array();
		$params[0] = $this->nodeid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_URLS, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
				$this->urls = array();
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];

					// make sure url associated with this node can actually be seen by the current user.
					// if they can see the node they should really be able to see the url
					// but not necessarily
					try {
						$url = new URL(trim($array['URLID']));
						array_push($this->urls,$url->load($style));
					} catch (Exception $e){
						//return access_denied_error();
					}
				}

				//usort($this->urls, 'titleSort');
			}
        } else {
        	return database_error();
        }
	}

	/**
	 * Load associated tags
	 */
	function loadTags() {
        global $DB,$CFG,$USER,$HUB_SQL;

		$params = array();
		$params[0] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_TAGS, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
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
	}

	/**
	 * Load groups
	 */
	function loadGroups() {
        global $DB,$CFG,$USER,$HUB_SQL;

		$params = array();
		$params[0] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_GROUPS, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
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

    /**
     * Add new node to the database
     *
     * @param string $name
     * @param string $desc optional, defaults to empty string.
     * @param string $private optional, can be Y or N, defaults to user's private data option.
     * @param string $nodetypeid optional, the id of the nodetype this node is. Defaults to $CFG->DEFAULT_NODE_TYPE.
     * @param string $image optional, the local server path to the image of the image used for this node. Defaults to empty string.
     * @param string $thumb optional, the local server path to the thumbnail of the image used for this node. Defaults to empty string.
     * @return Node object (this) (or Error object)
     */
    function add($name,$desc="",$private="",$nodetypeid="",$image="",$thumb=""){
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

		if($private == ""){
			$private = $USER->privatedata;
		}

		if ($nodetypeid === "") {
			$role = new Role();
			$nodetypeid = $role->getDefaultRoleID();
		}

		// No transclusion in the debate hub
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $name;
		$params[2] = $nodetypeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_ADD_CHECK, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
		    	 $this->nodeid = $resArray[0]["NodeID"];
			} else {
				$dt = time();
				$this->nodeid = getUniqueID();

				$params = array();
				$params[0] = $this->nodeid;
				$params[1] = $currentuser;
				$params[2] = $dt;
				$params[3] = $dt;
				$params[4] = $name;
				$params[5] = $desc;
				$params[6] = $private;
				$params[7] = $nodetypeid;
				$params[8] = $image;
				$params[9] = $thumb;

				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_ADD, $params);
				if (!$res) {
					return database_error();
				} else {
					$temp = $this->load();
					auditIdea($currentuser, $temp->nodeid, $name, $desc, $CFG->actionAdd,format_object('xml',$temp));
					return $temp;
				}
			}
		} else {
			return database_error();
		}

        return $this;
    }

    /**
     * Add new Comment node to the database - does not check for duplication
     *
     * @param string $name
     * @param string $desc optional, default to empty string.
     * @param string $private optional, can be Y or N, defaults to user's private data option
     * @param string $nodetypeid optional, the id of the nodetype this node is. Defaults to 'Comment' node type.
     * @param string $image optional, optional, the local server path to the image used for this node. Defaults to empty string.
     * @param string $thumb optional, the local server path to the thumbnail of the image used for this node. Defaults to empty string
     * @return Node object (this) (or Error object)
     */
    function addComment($name,$desc="",$private="",$nodetypeid="",$image="",$thumb=""){
        global $DB,$CFG,$USER,$HUB_SQL;

        try {
            $this->canadd();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();
        $this->nodeid = getUniqueID();

		if($private == ""){
			$private = $USER->privatedata;
		}

		if ($nodetypeid === "") {
			$role = getRoleByName('Comment');
			$nodetypeid = $role->roleid;
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $currentuser;
		$params[2] = $dt;
		$params[3] = $dt;
		$params[4] = $name;
		$params[5] = $desc;
		$params[6] = $private;
		$params[7] = $nodetypeid;
		$params[8] = $image;
		$params[9] = $thumb;

		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_ADD_COMMENT, $params);
        if (!$res) {
            return database_error();
        } else {
			$temp = $this->load();
			auditIdea($USER->userid, $temp->nodeid, $name, $desc, $CFG->actionAdd,format_object('xml',$temp));
			return $temp;
        }
    }

    /**
     * Edit a node
     *
     * @param string $name
     * @param string $desc optional, defaults to empty string.
     * @param string $private optional, can be Y or N, defaults to user private data option.
     * @param string $nodetypeid optional, the node type id of the nodetype of this node, defaults to current nodetype.
     * @param string $image optional, the urlid of the url for the image that is being used as this node's icon, defaults to empty string.
     * @param string $thumb optional, the local server path to the thumbnail of the image used for this node, defaults to empty string.
     *
     * @return Node object (this) (or Error object)
     */
    function edit($name,$desc="",$private="",$nodetypeid="",$image="",$thumb=""){
        global $CFG,$DB,$USER,$HUB_SQL,$HUB_FLM;
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		if($private == ""){
			$private = $USER->privatedata;
		}

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}
		if ($nodetypeid === "") {
			if (!isset($this->role)) {
				$this->load();
			}
			$nodetypeid = $this->role->roleid;
		}

		// no translusions
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $name;
		$params[2] = $nodetypeid;
		$params[3] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_EDIT_CHECK, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
	            return duplication_error("A node with this label and type already exists.");
			} else {
	        	$dt = time();

				$params = array();
				$params[0] = $dt;
				$params[1] = $name;
				$params[2] = $desc;
				$params[3] = $private;
				$params[4] = $nodetypeid;
				$params[5] = $image;
				$params[6] = $thumb;
				$params[7] = $this->nodeid;
				$params[8] = $currentuser;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_EDIT, $params);

				//remove old images
				try {
					if (isset($this->filename) && $this->filename !="" && $this->filename != $image
							&& $this->filename != $CFG->DEFAULT_ISSUE_PHOTO && $this->filename != $CFG->DEFAULT_GROUP_PHOTO) {

						$originalphotopath = $HUB_FLM->createUploadsDirPath($this->imagedir."/".stripslashes($this->filename));
						$originalphotopaththumb = $HUB_FLM->createUploadsDirPath($this->imagedir."/".str_replace('.','_thumb.', stripslashes($this->filename)));
						unlink('\''.$originalphotopath.'\'');
						unlink('\''.$originalphotopaththumb.'\'');
					}
				} catch (Exception $e){
            		return access_denied_error();
        		}

				if ($res) {
					//update labels in Triple Table
					$params = array();
					$params[0] = $name;
					$params[1] = $this->nodeid;
					$params[2] = $currentuser;
					$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_EDIT_UPDATE_TRIPLE_TO, $params);
					$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_EDIT_UPDATE_TRIPLE_FROM, $params);
				} else {
					return database_error();
				}

				$temp = $this->load();
				auditIdea($USER->userid, $temp->nodeid, $name, $desc, $CFG->actionEdit,format_object('xml',$temp));
				return $temp;
			}
		} else {
			return database_error();
		}

        return $this;
    }

    /**
     * Delete node
     *
     * @return Result object (or Error object)
     */
    function delete(){
        global $DB,$CFG,$USER,$HUB_FLM,$HUB_SQL;

        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }

        $this->load();
		$xml = format_object('xml',$this);

        $dt = time();

		//delete the associated topic, if this is a map node being deleted.
        $role = $this->role;
        $challengenode = "";
        $deleteconnections = array();
		if ($role->name == "Map") {
			$view = getView($this->nodeid);

			// find the challenge node in the map to delete afterwards.
			$viewnodes = $view->nodes;
			$count = 0;
			if (is_countable($viewnodes)) {
				$count = count($viewnodes);
			}
			for ($i = 0; $i < $count; $i++) {
				$next = $viewnodes[$i];
				$nextnode = $next->node;
				if ($nextnode->role->name == "Challenge") {
					$challengenode = $nextnode;
				}
			}

			// get the Connections in the Map to delete afterwards
			$viewconns = $view->connections;
			$count = 0;
			if (is_countable($viewconns)) {
				$count = count($viewconns);
			}
			for ($i = 0; $i < $count; $i++) {
				$next = $viewconns[$i];
				$nextcon = $next->connection;
				array_push($deleteconnections, $nextcon);
			}
		}

		$params = array();
		$params[0] = $this->nodeid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_NODE_DELETE, $params);
        if ($res) {
            auditIdea($USER->userid, $this->nodeid, $this->name, $this->description, $CFG->actionDelete, $xml);

            // NOT SURE THIS IS REQUIRED NOW AS IT SHOULD HAPPEN ON CASCADE DELETE IN THE DATABASE
            // update the related connections (triples)
			$params = array();
			$params[0] = $this->nodeid;
			$params[1] = $this->nodeid;
			$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_DELETE_TRIPLE, $params);
            if($resArray !== false){
				$count = 0;
				if (is_countable($resArray)) {
					$count = count($resArray);
				}
            	for ($i=0; $i<$count; $i++) {
            		$array = $resArray[$i];
                    $conn = new Connection($array['TripleID']);
                    $conn = $conn->delete();
                }
            } else {
                 return database_error();
            }

            //update the related URLs
			$params = array();
			$params[0] = $this->nodeid;
			$res3 = $DB->delete($HUB_SQL->DATAMODEL_NODE_DELETE_URLNODE, $params);
            if (!$res3) {
                return database_error();
            }

            // Take this opportunity to delete any URLs if they are no longer connected to a node
            // Probably should do this in a more organized way!
			$params = array();
			$res4Array = $DB->select($HUB_SQL->DATAMODEL_NODE_DELETE_URLS_CLEAN, $params);
            if ($res4Array !== false ) {
				$count = 0;
				if (is_countable($res4Array)) {
					$count = count($res4Array);
				}
            	for ($i=0; $i<$count; $i++) {
            		$array = $res4Array[$i];
                    $url = new URL($array['URLID']);
                    $url = $url->delete();
                }
            }

            // Delete any associated challenge node if this node is a Map
            // and any associated map Connections
			if ($role->name == "Map" && $challengenode != "") {
				$challengenode->delete();

				$count = 0;
				if (is_countable($deleteconnections)) {
					$count = count($deleteconnections);
				}
				for ($i = 0; $i < $count; $i++) {
					$nextcon = $deleteconnections[$i];

					// Need to bypass check.
					// If you own the map you can delete it and its connections need to be deleted.
					$conxml = format_object('xml',$nextcon);
					$innerparams = array();
					$innerparams[0] = $nextcon->connid;
					$res5 = $DB->delete($HUB_SQL->DATAMODEL_CONNECTION_DELETE, $innerparams);
					if ($res5) {
						auditConnection($USER->userid, $nextcon->connid, "", $nextcon->from->nodeid, $nextcon->to->nodeid, $nextcon->linktype->linktypeid, $nextcon->fromrole->roleid, $nextcon->torole->roleid, $CFG->actionDelete,$conxml);
					}
				}
			}
        } else {
            return database_error();
        }

        //remove old thumbnail
        if ($this->thumb != null && $this->thumb !="" && substr($this->thumb,0,7) == 'uploads') {
            unlink($HUB_FLM->createUploadsDirPath($this->thumb));
        }

        return new Result("deleted","true");
    }

    function vote($vote){
        global $DB,$USER,$HUB_SQL,$CFG;
        try {
            $this->canview();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_VOTE_CHECK, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$dt = time();
				$params = array();
				$params[0] = $currentuser;
				$params[1] = $this->nodeid;
				$params[2] = $vote;
				$params[3] = $dt;
				$params[4] = $dt;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_VOTE_ADD, $params);
				if(!$res){
					return database_error();
				}else {
	        		auditVote($currentuser, $this->nodeid, $vote, $CFG->actionAdd);
	        	}
			} else {
				$dt = time();
				$params = array();
				$params[0] = $dt;
				$params[1] = $vote;
				$params[2] = $currentuser;
				$params[3] = $this->nodeid;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_VOTE_EDIT, $params);
				if(!$res){
					return database_error();
				} else {
	           		auditVote($currentuser, $this->nodeid, $vote, $CFG->actionEdit);
	        	}
			}
		} else {
			return database_error();
		}

        return $this->load();
    }

    function deleteVote($vote){
        global $DB,$USER,$HUB_SQL,$CFG;
        try {
            $this->canview();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->nodeid;
		$params[2] = trim($vote);
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_VOTE_DELETE, $params);
	    if(!$res){
            return database_error();
        } else {
           	auditVote($currentuser, $this->nodeid, trim($vote), $CFG->actionDelete);
        }

        return $this->load();
    }

    /**
     * Add a URL to this node
     *
     * @param string $urlid
     * @param string $comments
     * @return Node object (this) (or Error object)
     */
    function addURL($urlid,$comments){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can edit the Node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
        //check user can edit the URL
        $url = new URL($urlid);
        $url = $url->load();
        try {
            $url->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $urlid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_URL_ADD_CHECK, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
		        $dt = time();
				$params = array();
				$params[0] = $currentuser;
				$params[1] = $urlid;
				$params[2] = $this->nodeid;
				$params[3] = $dt;
				$params[4] = $dt;
				$params[5] = $comments;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_URL_ADD, $params);
                if ($res) {
                    if (!auditURL($USER->userid, $urlid, $this->nodeid, $urlid, "", "", "", "", "", "", $comments, $CFG->actionAdd,format_object('xml',$this))) {
                        return database_error();
                    }
                } else {
                     return database_error();
                }
            }
        }

        return $this->load();
    }

    /**
     * Remove a URL from this node
     *
     * @param string $urlid
     * @return Node object (this) (or Error object)
     */
    function removeURL($urlid){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user can edit the Node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
        //check user can edit the URL
        $url = new URL($urlid);
        try {
            $url->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $urlid;
		$params[2] = $currentuser;
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_URL_DELETE, $params);
        if ($res) {
            if (!auditURL($USER->userid, $urlid, $this->nodeid, "", "", "", "", "", "", "", $CFG->actionDelete, format_object('xml',$this))) {
                return database_error();
            }
        } else {
            return database_error();
        }

        // if the url has no other connections to nodes delete the url object.
        $url = new URL($urlid);
        $url = $url->load('short');
        if ($url->ideacount == 0) {
        	$url->delete();
        }

        return $this->load();
    }

     /**
     * Remove all urls from this Node
     *
     * @return Node object (this) (or Error object)
     */
    function removeAllURLs(){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$params = array();
		$params[0] = $this->nodeid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_URL_DELETE_ALL, $params);
        if (!$res) {
            return database_error();
        }

		// empty it out in case.
		$this->urls = array();

        return $this->load();
    }

    /**
     * Add group to this node
     *
     * @param string $groupid
     * @return Node object (this) (or Error object)
     */
    function addGroup($groupid){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the node

        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check user member of group
        $group = new Group($groupid);
        $group = $group->load();
        if(!$group->ismember($USER->userid)){
           return access_denied_error();
        }

        // check node not already in group
		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_GROUP_ADD_CHECK, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
	            $dt = time();
				$params = array();
				$params[0] = $this->nodeid;
				$params[1] = $groupid;
				$params[2] = $dt;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_GROUP_ADD, $params);
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
     * Remove group from this node
     *
     * @param string $groupid
     * @return Node object (this) (or Error object)
     */
    function removeGroup($groupid){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check user member of group
        $group = new Group($groupid);
        $group->load();
        if(!$group->ismember($USER->userid)){
           return access_denied_error();
        }

        // check group not already in node
		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $groupid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_NODE_GROUP_DELETE, $params);
	    if(!$res){
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
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$params = array();
		$params[0] = $this->nodeid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_NODE_GROUP_DELETE_ALL, $params);
	    if(!$res){
            return database_error();
        }

        return $this->load();
    }

    /**
     * Add a Tag to this node
     *
     * @param string $tagid
     * @return Node object (this) (or Error object)
     */
    function addTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can edit the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag = $tag->load();
        try {
        	$tag->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $tagid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_TAG_ADD_CHECK, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$params = array();
				$params[0] = $currentuser;
				$params[1] = $tagid;
				$params[2] = $this->nodeid;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_TAG_ADD, $params);
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
     * Remove a Tag from this node
     *
     * @param string $urlid
     * @return Node object (this) (or Error object)
     */
    function removeTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can edit the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag - $tag->load();
        try {
        	$tag->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $tagid;
		$params[2] = $currentuser;
		$res = $DB->delete($HUB_SQL->DATAMODEL_NODE_TAG_DELETE, $params);
        if (!$res) {
             return database_error();
        }

        return $this->load();
    }

    /**
     * Set the privacy setting of this node
     *
     * @return Node object (this) (or Error object)
     */
    function setPrivacy($private){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();
		$params = array();
		$params[0] = $private;
		$params[1] = $dt;
		$params[2] = $this->nodeid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_PRIVACY_UPDATE, $params);
        if (!$res) {
             return database_error();
        }

        return $this->load();
    }

    /**
     * Set the privacy setting of this node
     *
     * @return Node object (this) (or Error object)
     */
    function updateAdditionalIdentifier($identifier){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();
		$params = array();
		$params[0] = $identifier;
		$params[1] = $dt;
		$params[2] = $this->nodeid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_ADDITIONAL_IDENTIFIER_UPDATE, $params);
        if (!$res) {
             return database_error();
        }

        return $this->load();
    }

    /**
     * Update the nodetype/role for this node
     *
     * @return Node object (this) (or Error object)
     */
    function updateRole($rolename){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }


		// Can only change type if it has no connections.
		// re-get connectedness as this may be a cached node and out of date.

		$count = $this->connectedness;

		$params = array();
		$params[0] = $this->nodeid;
  		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_SELECT, $params);
    	if ($resArray !== false) {
			$loop = 0;
			if (is_countable($resArray)) {
				$loop = count($resArray);
			}
			for ($i=0; $i<$loop; $i++) {
				$array = $resArray[$i];
				$this->connectedness = $array['connectedness'];
				$count = $this->connectedness;
			}
		}

		if ($count > 0) {
			return access_denied_error();
		}

		$r = new Role();
		$r = $r->loadByName($rolename);

		$dt = time();
		$params = array();
		$params[0] = $r->roleid;
		$params[1] = $dt;
		$params[2] = $this->nodeid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_ROLE_UPDATE, $params);
		if (!$res) {
			 return database_error();
		} else {
			$temp = $this->load();
			auditIdea($USER->userid, $temp->nodeid, $temp->name, $temp->description, $CFG->actionEdit,format_object('xml',$temp));
			return $temp;
		}
    }

    /**
     * Update the start date for this node
     *
     * @return Node object (this) (or Error object)
     */
    function updateStartDate($startdate){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        try {
            if(is_numeric($startdate)){
                $mydate = $startdate;
            } else {
                $mydate = strtotime($startdate);
            }
            $dt = time();
			$params = array();
			$params[0] = $mydate;
			$params[1] = $dt;
			$params[2] = $this->nodeid;
			$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_STARTDATE_UPDATE, $params);
			if (!$res) {
				 return database_error();
			}
        } catch (Exception $e) {
            //failed
        }

        return $this->load();
    }

    /**
     * Update the end date for this node
     *
     * @return Node object (this) (or Error object)
     */
    function updateEndDate($enddate){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        try {
            if(is_numeric($enddate)){
                $mydate = $enddate;
            } else {
                $mydate = strtotime($enddate);
            }
            $dt = time();
			$params = array();
			$params[0] = $mydate;
			$params[1] = $dt;
			$params[2] = $this->nodeid;
			$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_ENDDATE_UPDATE, $params);
			if (!$res) {
				 return database_error();
			}
        } catch (Exception $e) {
            //failed
        }

        return $this->load();
    }


    /**
     * Update the location for this node
     *
     * @return Node object (this) (or Error object)
     */
    function updateLocation($location,$loccountry,$address1,$address2,$postcode){
        global $DB,$CFG,$USER,$HUB_SQL;

 		//check user owns the node
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();

		$params = array();
		$params[0] = $address1;
		$params[1] = $address2;
		$params[2] = $postcode;
		$params[3] = $location;
		$params[4] = $loccountry;
		$params[5] = $dt;
		$params[6] = $this->nodeid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_LOCATION_UPDATE, $params);
		if ($res) {
			//try to geocode
			if ($location != "" && $loccountry != "" &&
				($location != $this->location || $loccountry != $this->countrycode || $address1 != $this->locationaddress1 || $address2 != $this->locationaddress2 || $postcode != $this->locationpostcode)){

				$coords = geoCodeAddress($address1, $address2, $postcode, $location, $loccountry);
				if($coords["lat"] != "" && $coords["lng"] != ""){
					$params = array();
					$params[0] = $coords["lat"];
					$params[1] = $coords["lng"];
					$params[2] = $this->nodeid;
					$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_LATLONG_UPDATE, $params);
				} else {
					$params = array();
					$params[0] = null;
					$params[1] = null;
					$params[2] = $this->nodeid;
					$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_LATLONG_UPDATE, $params);
				}
			}
		} else {
			return database_error();
		}

        return $this->load();
    }

   /**
     * Update the status for this node
     *
     * @return Node object (this) (or Error object)
     */
    function updateStatus($status){
        global $DB,$CFG,$USER,$HUB_SQL;

        $dt = time();

		$params = array();
		$params[0] = $status;
		$params[1] = $dt;
		$params[2] = $this->nodeid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_STATUS_UPDATE, $params);
		if (!$res) {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Add a node for the given userid
     *
     * @return Node object (this) (or Error object)
     */
	function setUpDefaultUserNode($userid) {
        global $DB,$CFG,$HUB_SQL;

		// get the role;
		$params = array();
		$params[0] = $userid;
		$params[1] = 'Person';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_DEFAULT_USER_NODE_ROLE, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				return database_error();
            }
            $roleid = stripslashes($resArray[0]['NodeTypeID']);

			if ($roleid != "") {
				$id = $userid.'user';
				$dt = time();

				$params = array();
				$params[0] = $id;
				$params[1] = $userid;
				$params[2] = $dt;
				$params[3] = $dt;
				$params[4] = 'Person';
				$params[5] = 'N';
				$params[6] = $roleid;
				$params[7] = 0;
				$params[8] = $CFG->AUTH_TYPE_EVHUB;
				$params[9] = $userid;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_DEFAULT_USER_NODE_ADD, $params);
				if (!$res){
					 echo database_error();
				} else {
					//echo ": added ".$userid;
				}
			} else {
				return database_error();
            }
		}
	}

    /**
     *  Update a node image
     *
     * @param string $image
     * @return Node object (this) (or Error object)
     */
    function updateImage($image){
        global $DB,$HUB_SQL,$CFG,$HUB_FLM,$USER;

        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$dt = time();
 		$params = array();
 		$params[0] = $image;
 		$params[1] = $dt;
 		$params[2] = $this->nodeid;
 		$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_IMAGE_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
			//remove old images
			try {
				if (isset($this->filename) && $this->filename !="" && $this->filename != $image
						&& $this->filename != $CFG->DEFAULT_ISSUE_PHOTO && $this->filename != $CFG->DEFAULT_GROUP_PHOTO) {

					$originalphotopath = $HUB_FLM->createUploadsDirPath($this->imagedir."/".stripslashes($this->filename));
					$originalphotopaththumb = $HUB_FLM->createUploadsDirPath($this->imagedir."/".str_replace('.','_thumb.', stripslashes($this->filename)));
					unlink('\''.$originalphotopath.'\'');
					unlink('\''.$originalphotopaththumb.'\'');
				}
			} catch (Exception $e){
				//return access_denied_error();
			}

            return $this->load();
        }
    }

	////////////// PROPERTY FUNCTION ////////////////////

	/**
	 *	Return the requested property or an empty string if it is not found.
	 */
	function getNodeProperty($propertyname) {
		if (isset($this->properties[$propertyname])) {
			return $this->properties[$propertyname];
		} else {
			return "";
		}
	}

	function updateNodeProperty($property, $value) {
        global $DB,$HUB_SQL,$CFG,$USER;
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$dt = time();
 		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $property;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_PROPERTY_ADD_CHECK, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ) {
				$params[0] = $value;
				$params[1] = $dt;
				$params[2] = $this->nodeid;
				$params[3] = $property;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_PROPERTY_EDIT, $params);
				if( !$res ) {
					return database_error();
				} else {
					$oldvalue = "";
					if (isset($this->properties[$property])) {
						$oldvalue = $this->properties[$property];
					}

					$temp = $this->load();
					if ($value != $oldvalue) {
						auditIdea($USER->userid, $temp->nodeid, $temp->name, $temp->description, $CFG->actionEdit,format_object('xml',$temp));
					}
					return $temp;
				}
			} else {
				$params[0] = $this->nodeid;
				$params[1] = $property;
				$params[2] = $value;
				$params[3] = $dt;
				$params[4] = $dt;
				$res = $DB->insert($HUB_SQL->DATAMODEL_NODE_PROPERTY_ADD, $params);
				if( !$res ) {
					return database_error();
				} else {
					$temp = $this->load();
					auditIdea($USER->userid, $temp->nodeid, $temp->name, $temp->description, $CFG->actionEdit,format_object('xml',$temp));
					return $temp;
				}
			}
		}
	}

	function deleteNodeProperty($property) {
        global $DB,$HUB_SQL,$CFG;

        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }

		$dt = time();
 		$params = array();
  		$params[0] = $this->nodeid;
		$params[1] = $property;
 		$res = $DB->delete($HUB_SQL->DATAMODEL_NODE_PROPERTY_DELETE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $temp = $this->load();
			auditIdea($USER->userid, $temp->nodeid, $temp->name, $temp->description, $CFG->actionEdit,format_object('xml',$temp));
            return $temp;
        }
	}

    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can view the current node
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
		$params[0] = $this->nodeid;
		$params[1] = 'N';
		$params[2] = $currentuser;
		$params[3] = $this->nodeid;
		$params[4] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_CAN_VIEW, $params);
		if($resArray !== false){
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
     * Check whether the current user can add a node
     *
     * @throws Exception
     */
    function canadd(){
        // needs to be logged in that's all!
        api_check_login();
    }

    /**
     * Check whether the current user can edit the current node
     *
     * @throws Exception
     */
    function canedit(){
        global $DB,$USER,$HUB_SQL,$LNG;
        api_check_login();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can edit only if owner of the node
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_CAN_EDIT, $params);
		if($resArray !== false){
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
     * Check whether the current user can delete the current node
     *
     * @throws Exception
     */
    function candelete(){
        global $DB,$USER,$HUB_SQL,$LNG;
        api_check_login();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can delete only if owner of the node
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->nodeid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_CAN_EDIT, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count  == 0) {
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
     * How many times this node has been used in making a connection
     *
     * @return integer
     */
    function getConnectionUsage() {
        global $DB,$CFG,$HUB_SQL;
        $usage = 0;

        //one side of connection
		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $this->userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_CONNECTION_USAGE_FROM, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
	            $usage = $resArray[0]['nodecount'];
	        }
        }

        //other side of connection
		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $this->userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_CONNECTION_USAGE_TO, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
	            $usage = $usage+$resArray[0]['nodecount'];
	        }
        }

        return $usage;
    }

    /**
     * How many users have entered this idea
     *
     * @return integer
     */
    function getNodeEntryUsage() {
        global $DB,$CFG,$HUB_SQL;
        $usage = 0;

		$params = array();
		$params[0] = $this->name;
		$params[1] = $this->userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_NODE_ENTRY_USAGE, $params);
		if($resArray !== false){
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}

			if ($count > 0) {
   	        	$usage = $resArray[0]['nodecount'];
   	        }
        }

        return $usage;
    }
}
?>