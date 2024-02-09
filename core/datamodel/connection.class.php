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
// Connection Class
///////////////////////////////////////

class Connection {

    public $connid;
    public $from;
    public $to;
    public $userid;
    public $creationdate;
    public $modificationdate;
    public $description;
    public $private;
    public $fromcontexttypeid;
    public $tocontexttypeid;
    public $linktypeid;
    public $status = 0;

    public $linktype;
    public $fromrole;
    public $torole;
    public $users;

    public $style = 'long';

    //public $groups;
    //public $tags;
    //public $positivevotes;
    //public $negativevotes;
    //public $uservote;
    //public $parentnode; - LiteMap specific

    /**
     * Constructor
     *
     * @param string $connid (optional)
     * @param String $style (optional - default 'long') may be 'short' or 'long'
     * @return Connection (this)
     */
    function Connection($connid = "", $style='long'){
        if ($connid != ""){
            $this->connid= $connid;
            return $this;
        }
    }

    /**
     * Loads the data for the connection from the database
     *
     * @param String $style (optional - default 'long') may be 'short' or 'long' of 'cif'
     * @return Connection object (this) or Error
     */
    function load($style = 'long'){
        global $DB,$CFG,$HUB_SQL;

        try {
            $this->canview();
        } catch (Exception $e){
            return access_denied_error();
        }

		$this->style = $style;

		$params = array();
		$params[0] = $this->connid;
    	$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT, $params);
		$count = (is_countable($resArray)) ? count($resArray) : 0;
        if($count == 0){
	 		$ERROR = new Hub_Error;
	    	$ERROR->createConnectionNotFoundError($this->connid);
	        return $ERROR;
        }

        $fromid = 0;
        $toid = 0;
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
            $fromid = trim($array['FromID']);
            $toid = trim($array['ToID']);
            $this->fromcontexttypeid = trim($array['FromContextTypeID']);
            $this->tocontexttypeid = trim($array['ToContextTypeID']);
            $this->creationdate = trim($array['CreationDate']);
            $this->modificationdate = trim($array['ModificationDate']);
            $this->userid = trim($array['UserID']);
            $this->users = array();
            $this->users[0] = getUser($this->userid, $style);
            $this->linktypeid = trim($array['LinkTypeID']);
            $this->private = $array['Private'];
           	$this->description = $array['Description'];

            if (isset($array['CurrentStatus'])) {
                $this->status = $array['CurrentStatus'];
            }
        }

        //now add in from/to nodes. Try from the cache first?
      	$from = new CNode($fromid);
       	$this->from = $from->load($style);

        $to = new CNode($toid);
	    $this->to = $to->load($style);

        $r = new Role($this->fromcontexttypeid);
        $this->fromrole = $r->load();

        $r = new Role($this->tocontexttypeid);
        $this->torole = $r->load();

        // LiteMap specific
        //If both ends of the connection are Comments, it's part of a chat tree.
        //and if the description holds a nodeid, load it as the parent item the chat is against
        if ((isset($this->fromrole->name) && $this->fromrole->name == "Comment")
        	|| (isset($this->torole->name) && $this->torole->name == "Comment")) {
        	if (isset($this->description) && $this->description != "") {
	        	// the description could hold a list of id'd id1:id2:id3 etc
	        	// if it does, the first item is the one to use.
				//echo $this->description;

	        	$reply = explode(":", $this->description);
	        	$id = $reply[0];
	        	if ($reply[0] == "") {
	        		$id = $reply[1];
	        	}
				$parentnode = new CNode($id);
				$parentnode = $parentnode->load();
				if (!$parentnode instanceof Hub_Error) {
					$this->parentnode = $parentnode;
				}
        	}
        }
        /// End LiteMap specific

        $l = new LinkType($this->linktypeid);
        $this->linktype = $l->load();

        if ($style == 'long'){
	        // add in the groups
			$resArray2 = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT_GROUP, $params);
			$count2 = (is_countable($resArray2)) ? count($resArray2) : 0;
	        if($count2 > 0){
	            $this->groups = array();
				for ($i=0; $i<$count2; $i++) {
					$array = $resArray2[$i];
	                $group = new Group(trim($array['GroupID']));
	                array_push($this->groups,$group->load());
	            }
	        }

	        //now add in any tags
			$resArray3 = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT_TAGS, $params);
			$count3 = (is_countable($resArray3)) ? count($resArray3) : 0;
	        if($count3 > 0){
	            $this->tags = array();
				for ($i=0; $i<$count3; $i++) {
					$array = $resArray3[$i];
	                $tag = new Tag(trim($array['TagID']));
	                array_push($this->tags,$tag->load());
	            }
	        }
		}

		if ($style != 'cif') {
	        $this->loadVotes();
	    }

        return $this;
    }

	/**
	 * Load Associated vote counts
	 */
	function loadVotes() {
        global $DB,$CFG,$USER,$HUB_SQL;

		$params = array();
		$params[0] = $this->connid;

        //load positive votes
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT_VOTES_POS, $params);
		$count = (is_countable($resArray)) ? count($resArray) : 0;
		if($count > 0){
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
        		$this->positivevotes = $array['Positive'];
        	}
		} else {
			$this->positivevotes = 0;
		}

        //load negative votes
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT_VOTES_NEG, $params);
		$count = (is_countable($resArray)) ? count($resArray) : 0;
		if($count > 0){
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
        		$this->negativevotes = $array['Negative'];
        	}
		} else {
        	$this->negativevotes = 0;
		}


        //load the current user's vote for this node if any
        $this->uservote = '0';

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->connid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT_VOTETYPE, $params);
		$count = (is_countable($resArray)) ? count($resArray) : 0;
		if($count > 0){
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
            	$this->uservote = $array['VoteType'];
            }
       	}
	}

    /**
     * Add new connection to the database
     *
     * @param string $fromnodeid
     * @param string $fromroleid
     * @param string $linktypeid
     * @param string $tonodeid
     * @param string $toroleid
     * @param string $private
     * @param string $description
     * @return Connection object (this) (or Error object)
     */
    function add($fromnodeid,$fromroleid,$linktypeid,$tonodeid,$toroleid,$private,$description=""){
        global $DB,$CFG,$USER,$HUB_SQL;
        $dt = time();

        //check user can add connection
        try {
            $this->canadd();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check user owns and can edit the 2 nodes sent.
        try {
            $fromnode = new CNode($fromnodeid);
            $fromnode = $fromnode->load();
            //$fromnode->canedit();
        } catch (Exception $e){
            //return access_denied_error();
        }

        try {
            $tonode = new CNode($tonodeid);
            $tonode = $tonode->load();
            //$tonode->canedit();
        } catch (Exception $e){
            //return access_denied_error();
        }

        //ensure roles and linktype exist for the current user
        // roles can belong to other users (? Why should they here)
        /*
        try {
            $fr = new Role($fromroleid);
            $fr = $fr->load();
            $fr->canedit();
        } catch (Exception $e){
            $fr->add($fr->name);
            $fromroleid = $tr->roleid;
        }
        try {
            $tr = new Role($toroleid);
            $tr = $tr->load();
            $tr->canedit();
        } catch (Exception $e){
            $tr->add($tr->name);
            $toroleid = $tr->roleid;
        }
        */

        try {
            $lt = new LinkType($linktypeid);
            $lt = $lt->load();
            $lt->canedit();
        } catch (Exception $e){
            $lt->add($lt->label, $lt->grouplabel);
            $linktypeid = $lt->linktypeid;
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $linktypeid;
		$params[2] = $fromnodeid;
		$params[3] = $tonodeid;
		$params[4] = $fromroleid;
		$params[5] = $toroleid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT_CHECK, $params);
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
        if ($resArray !== false) {
			if($count > 0){
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
                    $this->connid = $array['TripleID'];
                    return $this->load();
                }
            } else {
                $this->connid = getUniqueID();
				$params = array();
				$params[0] =  $this->connid;
				$params[1] = $currentuser;
				$params[2] = $dt;
				$params[3] = $dt;
				$params[4] = $linktypeid;
				$params[5] = $fromnodeid;
				$params[6] = $tonodeid;
				$params[7] = $fromroleid;
				$params[8] = $toroleid;
				$params[9] = $fromnode->name;
				$params[10] = $tonode->name;
				$params[11] = $private;
				$params[12] = $description;

				$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_INSERT, $params);
                if (!$res) {
                    return database_error();
                }
            }
        } else {
            return database_error();
        }

        //now clear the users cache
        //clearUserCache();

        $temp = $this->load();
        if (!auditConnection($USER->userid, $temp->connid, "", $fromnodeid, $tonodeid, $linktypeid, $fromroleid, $toroleid, $CFG->actionAdd,format_object('xml',$temp))) {
            return database_error();
        }
        return $temp;
    }

    /**
     * Edit a connection
     * after the update need to update the nodes so they're in the same groups as the connection
     * @param string $fromnodeid
     * @param string $fromroleid
     * @param string $linktypeid
     * @param string $tonodeid
     * @param string $toroleid
     * @param string $private
     * @param string $description
     * @return Connection object (this) (or Error object)
     */
    function edit($fromnodeid,$fromroleid,$linktypeid,$tonodeid,$toroleid,$private,$description=""){
        global $DB,$CFG,$USER,$HUB_SQL;

        $dt = time();

        //check user can edit connection
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        try {
            $fromnode = new CNode($fromnodeid);
            $fromnode = $fromnode->load();
            //$fromnode->canedit();
        } catch (Exception $e){
            //return access_denied_error();
        }

        try {
            $tonode = new CNode($tonodeid);
            $tonode = $tonode->load();
            //$tonode->canedit();
        } catch (Exception $e){
            //return access_denied_error();
        }

		$params = array();
		$params[0] = $dt;
		$params[1] = $fromnode->name;
		$params[2] = $tonode->name;
		$params[3] = $linktypeid;
		$params[4] = $fromnodeid;
		$params[5] = $tonodeid;
		$params[6] = $fromroleid;
		$params[7] = $toroleid;
		$params[8] = $private;
		$params[9] = $description;
		$params[10] =  $this->connid;
		$params[11] = $currentuser;

		$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_UPDATE_ALL, $params);
        if (!$res) {
            return database_error();
        }

        // now also add groups to the from and to nodes
		$params = array();
		$params[0] = $this->connid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_SELECT_GROUP, $params);
        if (!$resArray) {
            return database_error();
        } else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$groupid = $array['GroupID'];
				$fromnode = new CNode($fromnodeid);
				$fromnode->addGroup($groupid);
				$tonode = new CNode($tonodeid);
				$tonode->addGroup($groupid);
			}
        }

		$temp = $this->load();
        if (!auditConnection($USER->userid, $temp->connid, "", $fromnodeid, $tonodeid, $linktypeid, $fromroleid, $toroleid, $CFG->actionEdit,format_object('xml',$temp))) {
             return database_error();
        }
        return $temp;
    }

    /**
     * Edit a connection's description
     * after the update need to update the nodes so they're in the same groups as the connection
     * @param string $description
     * @return Connection object (this) (or Error object)
     */
    function editDescription($description="") {
        global $DB,$CFG,$USER,$HUB_SQL;

        $dt = time();

        //check user can edit connection
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $dt;
		$params[1] = $description;
		$params[2] = $this->connid;
		$params[3] = $currentuser;

		$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_UPDATE_DESC, $params);
        if (!$res) {
            return database_error();
        }

        $temp = $this->load();
        if (!auditConnection($USER->userid, $temp->connid, "", $temp->from->nodeid, $temp->to->nodeid, $temp->linktypeid, $temp->from->role->roleid, $temp->to->role->roleid, $CFG->actionEdit,format_object('xml',$temp))) {
             return database_error();
        }
        return $temp;
    }

    /**
     * Delete connection
     *
     * @return Result object (or Error object)
     */
    function delete(){
        global $DB,$CFG,$USER,$HUB_SQL;
        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();

		$this->load();
		$xml = format_object('xml',$this);

		$params = array();
		$params[0] = $this->connid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_CONNECTION_DELETE, $params);
        if (!$res) {
            return database_error();
        }
        if (!auditConnection($USER->userid, $this->connid, "", $this->from->nodeid, $this->to->nodeid, $this->linktype->linktypeid, $this->fromrole->roleid, $this->torole->roleid, $CFG->actionDelete,$xml)) {
            return database_error();
        }
        return new Result("deleted","true","1");
    }

   /**
     * Update the status for this connection
     *
     * @return Node object (this) (or Error object)
     */
    function updateStatus($status){
        global $DB,$CFG,$USER,$HUB_SQL;

        $dt = time();

		$params = array();
		$params[0] = $status;
		$params[1] = $dt;
		$params[2] = $this->connid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_STATUS_UPDATE, $params);
		if (!$res) {
			return database_error();
		}

        return  $this->load();
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
		$params[1] = $this->connid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_VOTE_SELECT, $params);
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		if ($count == 0) {
	        $dt = time();
			$params = array();
			$params[0] = $currentuser;
			$params[1] = $this->connid;
			$params[2] = $vote;
			$params[3] = $dt;
			$params[4] = $dt;
			$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_VOTE_INSERT, $params);
	        if(!$res){
	            return database_error();
	        } else {
	        	auditVote($currentuser, $this->connid, $vote, $CFG->actionAdd);
	        }
        } else {
	        $dt = time();
			$params = array();
			$params[0] = $dt;
			$params[1] = $vote;
			$params[2] = $currentuser;
			$params[3] = $this->connid;
			$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_VOTE_UPDATE, $params);
	        if(!$res){
	            return database_error();
	        } else {
	           	auditVote($currentuser, $this->connid, $vote, $CFG->actionEdit);
	        }
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
		$params[1] = $this->connid;
		$params[2] = $vote;
		$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_VOTE_DELETE, $params);
        if(!$res){
            return database_error();
        } else {
           	auditVote($currentuser, $this->connid, $vote, $CFG->actionDelete);
        }

        return $this->load();
    }

    /**
     * Add group to this Connection
     * Also adds this group to the corresponding connected nodes as
     * the nodes also need to be in the group for them to be visible
     *
     * @param string $groupid
     * @return Connection object (this) (or Error object)
     */
    function addGroup($groupid){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the connection
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

		$params = array();
		$params[0] = $this->connid;
		$params[1] = $groupid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_GROUP_ADD_CHECK, $params);
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		if ($count == 0) {
            $dt = time();

			$params = array();
			$params[0] = $this->connid;
			$params[1] = $groupid;
			$params[2] = $dt;
			$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_GROUP_ADD, $params);
            if($res){
	            $fromnode = $this->from;
	            $fromnode->addGroup($groupid);
	            $tonode = $this->to;
	            $tonode->addGroup($groupid);
	        }
        }

        return $this->load();
    }

    /**
     * Remove group from this Connection
     *
     * @param string $groupid
     * @return Connection object (this) (or Error object)
     */
    function removeGroup($groupid){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user owns the connection
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

		$params = array();
		$params[0] = $this->connid;
		$params[1] = $groupid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_CONNECTION_GROUP_DELETE, $params);
        if(!$res){
        	return database_error();
        }

        return $this->load();
    }

    /**
     * Remove all groups from this Connection
     *
     * @return Connection object (this) (or Error object)
     */
    function removeAllGroups(){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the connection
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$params = array();
		$params[0] = $this->connid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_CONNECTION_GROUP_DELETE_ALL, $params);
        if(!$res){
        	return database_error();
        }

        return $this->load();
    }


    /**
     * Add a Tag to this connection
     *
     * @param string $tagid
     * @return Connection object (this) (or Error object)
     */
    function addTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can edit the connection
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag = $tag->load();
        $tag->canedit();

        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->connid;
		$params[1] = $tagid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_TAG_ADD_CHECK, $params);
        if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if($count == 0 ) {
				$params = array();
				$params[0] = $currentuser;
				$params[1] = $tagid;
				$params[2] = $this->connid;
				$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_TAG_ADD, $params);
                if (!$res) {
                     return database_error();
                }
            }
        }

        return  $this->load();
    }

    /**
     * Remove a Tag from this connection
     *
     * @param string $urlid
     * @return Connection object (this) (or Error object)
     */
    function removeTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can edit the connection
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag = $tag->load();
        $tag->canedit();

        $dt = time();

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->connid;
		$params[1] = $tagid;
		$params[2] = $currentuser;
		$res = $DB->delete($HUB_SQL->DATAMODEL_CONNECTION_TAG_DELETE, $params);
        if (!$res) {
            return database_error();
        }

        return $this->load();
    }

    /**
     * Set the privacy setting of this Connection
     *
     * @return Connection object (this) (or Error object)
     */
    function setPrivacy($private){
        global $DB,$CFG,$USER,$HUB_SQL;
        //check user owns the Connection
        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();
		$params = array();
		$params[0] = $private;
		$params[1] = $dt;
		$params[2] = $this->connid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_CONNECTION_PRIVACY_UPDATE, $params);
        if (!$res) {
            return database_error();
        }

        return $this->load();
    }
    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can view the current connection
     *
     * @throws Exception
     */
    function canview(){
        global $DB,$USER,$CFG,$LNG,$HUB_SQL;

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->connid;
		$params[1] = $currentuser;
		$params[2] = $currentuser;
		$params[3] = $currentuser;
		$params[4] = $currentuser;
		$params[5] = $currentuser;
		$params[6] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_CAN_VIEW, $params);

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
     * Check whether the current user can add a connection
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
     * Check whether the current user can copy a connection
     *
     * @throws Exception
     */
    function cancopy(){
        global $LNG;
        // needs to be logged in that's all!
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can edit the current connection
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

        //can edit only if owner of the connection
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->connid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_CAN_EDIT, $params);
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
     * Check whether the current user can delete the current connection
     *
     * @throws Exception
     */
    function candelete(){
        global $DB,$USER,$LNG,$HUB_SQL;
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

        //can delete only if owner of the connection
		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->connid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_CONNECTION_CAN_DELETE, $params);
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