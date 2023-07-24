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
// ViewConnection Class
///////////////////////////////////////

class ViewConnection {

    public $viewid;
    public $userid;
    public $connid;
    public $connection;
    public $creationdate;
    public $modificationdate;

    /**
     * Constructor
     *
     * @param string $viewid the id of the view this ViewTriple instance refers to
     * @param string $userid the id of the user this ViewTriple instance refers to
     * @param string $connid the id of the connection/triple this ViewTriple instance refers to
     * @return ViewNode (this)
     */
    function ViewConnection($viewid="", $connid="", $userid=""){
		$this->viewid = $viewid;
        $this->connid = $connid;
        $this->userid = $userid;
    }

    /**
     * Loads the data for this ViewNode record from the database
     * @return ViewConnection object (this)
     */
    function load($style='long') {
        global $DB,$CFG, $USER,$ERROR,$HUB_FLM,$HUB_SQL;

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
		$params[0] = $this->viewid;
		$params[1] = $this->connid;
		$params[2] = $this->userid;

 		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEWCONNECTION_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createNodeNotFoundError($this->connid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->creationdate = $array['CreationDate'];
					$this->modificationdate = $array['ModificationDate'];
					$this->connection = new Connection($this->connid);
					$this->connection = $this->connection->load($style);
				}
			}
        } else {
        	return database_error();
        }

        return $this;
    }

    /**
     * Add new ViewConnection record to the database
     *
     * @param string $viewid the id of the view this ViewConnection instance refers to
     * @param string $connid the id of the connection this ViewConnection instance refers to
     * @return ViewConnection object (this) (or Error object)
     */
    function add($viewid, $connid){
        global $DB,$CFG,$USER,$HUB_SQL;

        try {
            $this->canadd($viewid, $connid);
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		// No transclusion in the debate hub
		$params = array();
		$params[0] = $viewid;
		$params[1] = $connid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEWCONNECTION_SELECT, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if($count > 0 ){
				$this->viewid = $resArray[0]["ViewID"];
				$this->connid = $resArray[0]["TripleID"];
				$this->userid = $resArray[0]["UserID"];
			} else {
				$dt = time();

				$params = array();
				$params[0] = $viewid;
				$params[1] = $connid;
				$params[2] = $currentuser;
				$params[3] = $dt;
				$params[4] = $dt;

				$res = $DB->insert($HUB_SQL->DATAMODEL_VIEWCONNECTION_ADD, $params);
				if (!$res) {
					return database_error();
				} else {
					$this->viewid = $viewid;
					$this->connid = $connid;
					$this->userid = $currentuser;
					$this->load();

					auditViewTriple($USER->userid, $this->viewid, $this->connid, $CFG->actionAdd);
				}
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

        $this->load();

        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();

		$params = array();
		$params[0] = $this->viewid;
		$params[1] = $this->userid;
		$params[2] = $this->connid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_VIEWCONNECTION_DELETE, $params);

        if ($res) {
			// Need to bypass check.
			// If you can delete the viewconnection you can delete it's underlying connection which needs to be deleted.
			$xml = format_object('xml',$this->connection);
			$params = array();
			$params[0] = $this->connection->connid;
			$res2 = $DB->delete($HUB_SQL->DATAMODEL_CONNECTION_DELETE, $params);
			if ($res2) {
				auditConnection($USER->userid, $this->connection->connid, "", $this->connection->from->nodeid, $this->connection->to->nodeid, $this->connection->linktype->linktypeid, $this->connection->fromrole->roleid, $this->connection->torole->roleid, $CFG->actionDelete,$xml);
			}

        	auditViewTriple($USER->userid, $this->viewid, $this->connid, $CFG->actionDelete);
        } else {
            return database_error();
        }

        return new Result("deleted","true");
    }

    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can view the current ViewConnection record
     *
     * @throws Exception
     */
    function canview(){
        global $DB,$CFG,$USER,$HUB_SQL,$LNG;

		//check if you can view the map node and you can view this node in the map
        try {
			$view = new CNode($this->viewid);
			$view->canview();

			$con = new Connection($this->connid);
			$con->canview();
        } catch (Exception $e){
            return access_denied_error();
        }
    }

    /**
     * Check whether the current user can add a connection to the map
     *
     * @throws Exception
     */
    function canadd($viewid, $connid){
        global $DB,$USER,$HUB_SQL,$LNG;

        // needs to be logged in
        api_check_login();

		//You need to be able to view the node you are adding to the map
		//and you need permission to edit the map
        try {
        	// Triples only created in map so will always be added by owner
			$connection = new Connection($connid);
			$connection->canedit();

			$view = new View($viewid);
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

		/** CHANGED: If you can edit the map you can remove a connection from the map **/
        try {
			$view = new View($this->viewid);
			$view->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		/*
		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		if ($currentuser !== $this->userid) {
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
		}

        //can delete only if owner of this record
		$params = array();
		$params[0] = $this->viewid;
		$params[1] = $this->connid;
		$params[2] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEWCONNECTION_CAN_DELETE, $params);
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
        */
    }
}
?>