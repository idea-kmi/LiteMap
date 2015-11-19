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
// ViewNode Class
///////////////////////////////////////

class ViewNode {

    public $viewid;
    public $nodeid;
    public $userid;
    public $node;
    public $xpos = 0;
    public $ypos = 0;
    public $creationdate;
    public $modificationdate;

    /**
     * Constructor
     *
     * @param string $viewid the id of the view this ViewNode instance refers to
     * @param string $nodeid the id of the node this ViewNode instance refers to
     * @param string $userid the id of the user this ViewNode instance refers to
     * @return ViewNode (this)
     */
    function ViewNode($viewid="", $nodeid="", $userid=""){
		$this->viewid = $viewid;
        $this->nodeid = $nodeid;
        $this->userid = $userid;
    }

    /**
     * Loads the data for this ViewNode record from the database
     * @return ViewNode object (this)
     */
    function load($style='long') {
        global $DB,$CFG, $USER,$ERROR,$HUB_FLM,$HUB_SQL;

        try {
            $this->canview();
        } catch (Exception $e){
            return access_denied_error();
        }

		$params = array();
		$params[0] = $this->viewid;
		$params[1] = $this->nodeid;
		$params[2] = $this->userid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEWNODE_SELECT, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			if ($count == 0) {
				$ERROR = new error;
				$ERROR->createNodeNotFoundError($this->nodeid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->xpos = stripslashes(trim($array['XPos']));
					$this->ypos = $array['YPos'];
					$this->creationdate = $array['CreationDate'];
					$this->modificationdate = $array['ModificationDate'];
					$this->node = new CNode($this->nodeid);
					$this->node = $this->node->load($style);
				}
			}
        } else {
        	return database_error();
        }

        return $this;
    }

    /**
     * Add new viewnode record to the database
     *
     * @param string $viewid the id of the view this ViewNode instance refers to
     * @param string $nodeid the id of the node this ViewNode instance refers to
     * @param string $xpos the x position of the node in this view (optional defaults to 0)
     * @param string $ypos the y position of the node in this view (optional defaults to 0).
     * @return ViewNode object (this) (or Error object)
     */
    function add($viewid, $nodeid, $xpos, $ypos){
        global $DB,$CFG,$USER,$HUB_SQL;

        try {
            $this->canadd($viewid, $nodeid);
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $viewid;
		$params[1] = $nodeid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEWNODE_SELECT, $params);
		if ($resArray !== false) {
			if(count($resArray) > 0 ){
		    	$this->viewid = $resArray[0]["ViewID"];
		    	$this->nodeid = $resArray[0]["NodeID"];
		    	$this->userid = $resArray[0]["UserID"];
		    	$this->xpos = $resArray[0]["XPos"];
		    	$this->ypos = $resArray[0]["YPos"];
			} else {
				$dt = time();

				$params = array();
				$params[0] = $viewid;
				$params[1] = $nodeid;
				$params[2] = $currentuser;
				$params[3] = $xpos;
				$params[4] = $ypos;
				$params[5] = $dt;
				$params[6] = $dt;

				$res = $DB->insert($HUB_SQL->DATAMODEL_VIEWNODE_ADD, $params);
				if (!$res) {
					return database_error();
				} else {
					$this->viewid = $viewid;
					$this->nodeid = $nodeid;
					$this->userid = $currentuser;
					$this->load();

					auditViewNode($USER->userid, $this->viewid, $this->nodeid, $xpos, $ypos, $CFG->actionAdd);
				}
			}
		} else {
			return database_error();
		}

        return $this;
    }

    /**
     * Edit a viewnode record
     *
     * @param string $xpos the x position of the node in this view (optional defaults to 0)
     * @param string $ypos the y position of the node in this view (optional defaults to 0).
     *
     * @return Node object (this) (or Error object)
     */
    function edit($xpos=0, $ypos=0){
        global $CFG,$DB,$USER,$HUB_SQL;

        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$dt = time();

		$params = array();
		$params[0] = $dt;
		$params[1] = $xpos;
		$params[2] = $ypos;
		$params[3] = $this->viewid;
		$params[4] = $this->nodeid;
		$params[5] = $this->userid;

		$res = $DB->insert($HUB_SQL->DATAMODEL_VIEWNODE_EDIT, $params);
		if (!$res) {
			return database_error();
		} else {
        	auditViewNode($USER->userid, $this->viewid, $this->nodeid, $xpos, $ypos, $CFG->actionEdit);
		}

		$this->load();

        return $this;
    }

    /**
     * Delete node
     *
     * @return ViewNode object that was deleted (or Error object)
     */
    function delete(){
        global $DB,$CFG,$USER,$HUB_FLM,$HUB_SQL;

        $this->load();

        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }

		$params = array();
		$params[0] = $this->viewid;
		$params[1] = $this->nodeid;
		$params[2] = $this->userid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_VIEWNODE_DELETE, $params);
        if ($res) {
            auditViewNode($USER->userid, $this->viewid, $this->nodeid, $this->xpos, $this->ypos, $CFG->actionDelete);
        } else {
            return database_error();
        }

        return $this;
    }

    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can view the current ViewNode record
     *
     * @throws Exception
     */
    function canview(){
        global $DB,$CFG,$USER,$HUB_SQL,$LNG;

		//check if you can view the map node and you can view this node in the map
        try {
			$view = new CNode($this->viewid);
			$view->canview();

			$node = new CNode($this->nodeid);
			$node->canview();
        } catch (Exception $e){
            return access_denied_error();
        }
    }

    /**
     * Check whether the current user can add a node
     *
     * @throws Exception
     */
    function canadd($viewid, $nodeid){
        global $DB,$USER,$HUB_SQL,$LNG;

        // needs to be logged in
        api_check_login();

		//You need to be able to view the node you are adding to the map
		//and you need permission to edit the map
        try {
			$node = new CNode($nodeid);
			$node->canview();

			$view = new View($viewid);
			$view->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
    }

    /**
     * Check whether the current user can edit the current node ViewNode record
     * You need to be logged in and the owner of the viewnode record you want to edit.
     *
     * @throws Exception
     */
    function canedit(){
        global $DB,$USER,$HUB_SQL,$LNG;
        api_check_login();

		/** CHANGED: If you can edit the map you can edit the node position in the map **/
        try {
			$view = new View($this->viewid);
			$view->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }
    }

    /**
     * Check whether the current user can delete the current ViewNode record
     *
     * @throws Exception
     */
    function candelete(){
        global $DB,$USER,$HUB_SQL,$LNG;
        api_check_login();

		/** CHANGED: If you can edit the map you can remove a node from the map **/
        try {
			$view = new View($this->viewid);
			$view->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		/*$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		if ($currentuser !== $this->userid) {
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
		}

        //can delete only if owner of this ViewNode record
		$params = array();
		$params[0] = $this->viewid;
		$params[1] = $this->nodeid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEWNODE_CAN_EDIT, $params);
		if($resArray !== false){
			if (count($resArray) == 0) {
	            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
	        }
        } else {
	        throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
        */
    }
}
?>