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
// View Class
///////////////////////////////////////

class View {

    public $nodeid;
    public $viewnode;
	public $connections;
	public $nodes;

    /**
     * Constructor
     *
     * @param string $nodeid (optional)
     * @return View (this)
     */
    function View($nodeid = ""){
        if ($nodeid != ""){
            $this->nodeid = $nodeid;
        }
   		$this->nodes = array();
   		$this->connections = array();
        return $this;
    }

    /**
     * Loads the data for the group from the database
     *
     * @return View object (this)
     */
    function load($style = 'long'){
        global $DB,$CFG,$HUB_FLM,$HUB_SQL,$LNG;

   		$this->nodes = array();
   		$this->connections = array();

        try {
			$this->canview();
        } catch (Exception $e){
            return access_denied_error();
        }

		$this->viewnode = new CNode($this->nodeid);
		$this->viewnode = $this->viewnode->load($style);

		// load nodes
		$params = array();
		$params[0] = $this->nodeid;

		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEW_SELECT_NODES, $params);

    	if ($resArray !== false) {
			$count = (is_countable($resArray)) ? count($resArray) : 0;
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$next = new ViewNode($array['ViewID'], $array['NodeID'], $array['UserID']);
				$next = $next->load($style);
				if (!$next instanceof Hub_Error) {
					array_push($this->nodes, $next);
				} else {
					//return $next;
				}
            }
        } else {
            return database_error();
        }

		// load connections
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEW_SELECT_CONNECTIONS, $params);
    	if ($resArray !== false) {
			$count = (is_countable($resArray)) ? count($resArray) : 0;
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$next = new ViewConnection($array['ViewID'], $array['TripleID'], $array['UserID']);
				$next = $next->load($style);
				if (!$next instanceof Hub_Error) {
					array_push($this->connections, $next);
				} else {
					//return $next;
				}
            }
        } else {
            return database_error();
        }

        return $this;
    }

    /**
     * Adds a new view
	 * @param string $name the name of the view
	 * @param string $desc the description of the view
	 * @param string $private optional, can be Y or N, defaults to users preferred setting.
	 * @param string $nodetypeid optional, the id of the nodetype this node is, defaults to 'Idea' node type id.
	 * @param string $groupid optional, the is of the group, if any, this view is in.
	 * @param string $xpos optional, the x position to place the challenge node at (defaults to 0).
	 * @param string $ypos optional, the y position to place the challenge node at (defaults to 0).
     *
     * @param string $groupname
     * @return Group object (this)
     */
    function add($name, $desc, $private, $nodetypeid, $groupid="", $xpos=0, $ypos=0){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can add a view
        try {
            $this->canadd();
        } catch (Exception $e){
            return access_denied_error();
        }

		$node = new CNode();
		$this->viewnode = $node->add($name, $desc, $private, $nodetypeid);

   		$this->nodes = array();

		if (!$this->viewnode instanceof Hub_Error) {
			$this->nodeid = $this->viewnode->nodeid;

			if (isset($groupid) && $groupid != "") {
				$this->viewnode->addGroup($groupid);
			}

			// Create a new Challenge node and place in center of map.
			//$r = getRoleByName("Challenge");
			//$roleChallenge = $r->roleid;
			//$challengenode = new CNode();
			//$challengenode = $challengenode->add($name, $desc, $private, $roleChallenge);
			//if (isset($groupid) && $groupid != "") {
			//	$challengenode->addGroup($groupid);
			//}
			//$this->addNode($challengenode->nodeid, $xpos, $ypos);

			//$this->load();
		} else {
			return $this->viewnode;
		}

		return $this;
    }

    /**
     * Deletes a view
     *
     * @return Result object
     */
    function delete(){
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can delete a view
        if(!$this->candelete()){
            return access_denied_error();
        }

		$this->load();

		// delete any connections before you delete the map node
		// and it cascades and we don't know which connections where in the map.
		$count = 0;
		if (is_countable($this->connections)) {
			$count = count($this->connections);
		}
		for ($i=0; $i<$count; $i++) {
			$viewconnection = $this->connections[$i];
			$viewconnection->delete();
		}

		$reply = $this->viewnode->delete();

		if (!$reply instanceof Hub_Error) {

			// delete all ViewNode entries (and ViewConnection is for some reason this didn't work above)
			$params = array();
			$params[0] = $this->nodeid;

			// This should happen automatically on cascade delete, but just in case.
			$res = $DB->delete($HUB_SQL->DATAMODEL_VIEW_DELETE_NODES, $params);
			if ($res) {
				//auditIdea($USER->userid, $this->nodeid, $this->name, $this->description, $CFG->actionDelete, $xml);
			} else {
				return database_error();
			}

			// This should have happened already above.
			$res = $DB->delete($HUB_SQL->DATAMODEL_VIEW_DELETE_CONNECTIONS, $params);
			if ($res) {
				//auditIdea($USER->userid, $this->nodeid, $this->name, $this->description, $CFG->actionDelete, $xml);
			} else {
				return database_error();
			}

			return new Result("deleted","true");
		} else {
			return database_error();
		}
    }

    /**
     * Adds a node to this view
     *
     * @param string $nodeid the id of the node to add to this view
     * @return ViewNode object (this)
     */
    function addNode($nodeid, $xpos, $ypos, $mediaindex = -1){
        global $DB,$CFG,$USER,$HUB_SQL;

        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$viewnode = new ViewNode();
		$viewnode = $viewnode->add($this->nodeid, $nodeid, $xpos, $ypos, $mediaindex);
		$viewnode = $viewnode->load();
		if (!$viewnode instanceof Hub_Error) {
			array_push($this->nodes, $viewnode);
		}

		return $viewnode;
    }

    /**
     * Adds a connection to this view
     *
     * @param string $connid the id of the connection to add to this view
     * @return ViewConnection object (this)
     */
    function addConnection($connid){
        global $DB,$CFG,$USER,$HUB_SQL;

        try {
            $this->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

		$viewconn = new ViewConnection();
		$viewconn = $viewconn->add($this->nodeid, $connid);
		if (!$viewconn instanceof Hub_Error) {
			$viewconn = $viewconn->load();
			if (!$viewconn instanceof Hub_Error) {
				array_push($this->connections, $viewconn);
			}
		}

		return $viewconn;
    }

	/**
	 *	 Remove the viewnode item and also any related viewconnection items and their connections
	 * return the ViewNode removed or Error;
	 */
	function removeNode($nodeid, $userid) {

	    $vn = new ViewNode($this->nodeid, $nodeid, $userid);
	    $vn = $vn->delete();

		if (!$vn instanceof Hub_Error) {
			// delete any associated connections.

			if (!isset($this->connections)) {
				// load connections
				$params = array();
				$params[0] = $this->nodeid;
				$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEW_SELECT_CONNECTIONS, $params);
				if ($resArray !== false) {
					$count = 0;
					if (is_countable($resArray)) {
						$count = count($resArray);
					}
					for ($i=0; $i<$count; $i++) {
						$array = $resArray[$i];
						$next = new ViewConnection($array['ViewID'], $array['TripleID'], $array['UserID']);
						$next = $next->load($style);
						if (!$next instanceof Hub_Error) {
							array_push($this->connections, $next);
						}
					}
				} else {
					return database_error();
				}
			}

			$count = 0;
			if (is_countable($this->connections)) {
				$count = count($this->connections);
			}
			for ($i=0; $i<$count; $i++) {
				$viewconnection = $this->connections[$i];
				$connection = $viewconnection->connection;
				$from = $connection->from;
				$to = $connection->to;
				if (!$from instanceof Hub_Error && !$to instanceof Hub_Error) {
					if ($to->nodeid == $nodeid || $from->nodeid == $nodeid) {
						$viewconnection->delete();
					}
				}
			}
		}

		return $vn;
	}

	/**
	 *	 Remove the viewconnection item
	 */
	function removeConnection($connid, $userid) {
	    $vn = new ViewConnection($this->nodeid, $connid, $userid);
	    $vn = $vn->delete();
		return $vn;
	}


    /////////////////////////////////////////////////////
    // security functions
    /////////////////////////////////////////////////////

    /**
     * Check whether the current user can view this map
     *
     * @throws Exception
     */
    function canview(){
        global $DB,$USER,$HUB_SQL,$LNG;

        // need to be allowed to view the associated view node.
        //Or if it is private, you need to be logged in and in the group

        try {
			$node = new CNode($this->nodeid);
			$node->canview();
        } catch (Exception $e){
            return access_denied_error();
        }

		/*$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}*/



		/** To add the the map, either
		it needs to be public and not in a group,
		or you are the owner of the map,
		or you are in the group the map is in **/

		/*$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $currentuser;
		$params[2] = $this->nodeid;
		$params[3] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEW_CAN_EDIT, $params);
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



    /**
     * Check whether the current user can add an item to the map
     *
     * @throws Exception
     */
    function canedit(){
        global $DB,$USER,$HUB_SQL,$LNG;

        // needs to be logged in and in group and check privacy etc.
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		/** To add the the map, either
		it needs to be public and not in a group,
		or you are the owner of the map,
		or you are in the group the map is in **/

		$params = array();
		$params[0] = $this->nodeid;
		$params[1] = $currentuser;
		$params[2] = $this->nodeid;
		$params[3] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VIEW_CAN_EDIT, $params);
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
     * Check whether the current user can add a new map
     *
     * @throws Exception
     */
    function canadd(){
    	global $LNG, $USER;

        // needs to be logged in that's all!
        if(api_check_login() instanceof Hub_Error){
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }

    /**
     * Check whether the current user can delete the map
     *
     * @throws Exception
     */
    function candelete(){
        global $USER, $USER;

        // need to be allowed to delete the associated view node.
        try {
			$node = new CNode($this->nodeid);
			$node->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }
    }
}
?>