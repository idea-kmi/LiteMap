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
// Activity Class
///////////////////////////////////////

class Activity {

    public $itemid;
    public $userid;
    public $type;
    public $modificationdate;
    public $changetype;
    public $xml;
    public $node;
    public $con;
    public $tombstone = false;
    public $user;

    private $currentnode;
    private	$currentcon;
	//public $follownode;
	//public $followuser;
	//public $votenode;
	//public $voteconnection;	
	//public $viewnode;


    /**
     * Constructor
     *
     * @return Activity (this)
     */
    function Activity() {} // empty constructor

	/**
	 * Load the activity object.
     * @param String $itemid the id of the item whose activity was auditied.
     * @param String $userid the id of the user who caused the audit to happen. Who performed the activity.
     * @param String $type the type of audited item ('Vote', 'Node', 'Connection', 'Follow', 'View')
     * @param int $modificationdate the time of the audit in seconds from epoch
     * @param String $changetype the type of activity (view, edit, add, delete etc or for voting Y,N,L)
     * @param String $xml the xml for the audited history object
     * @param String $style (optional - default 'long') may be 'short' or 'long' or 'cif'
	 */
	function load($itemid, $userid, $type, $modificationdate, $changetype, $xml, $style='long') {
		$this->itemid = $itemid;
		$this->userid = $userid;
		$this->type = $type;
		$this->modificationdate = $modificationdate;
		$this->changetype = $changetype;
		$this->xml = $xml;
		$this->user = new User($userid);

		if ($style != 'cif') {
			$this->user = $this->user->load($style);
		}

		switch($this->type) {
			case "Node":
				if ($style == 'long') {
					$this->node = getIdeaFromAuditXML($this->xml);
				}
				$this->currentnode = getNode($this->itemid, $style);
				if ($this->currentnode instanceof Hub_Error) {
					if ($this->currentnode->code == 7007) { // NODE NOT FOUND
						$this->tombstone = true;
					}
				}
				break;
			case "Connection":
				if ($style == 'long') {
					$this->con = getConnectionFromAuditXML($this->xml);
				}
				$this->currentcon = getConnection($this->itemid, $style);
				if ($this->currentcon instanceof Hub_Error) {
					if ($this->currentcon->code == 7008) { // CONNECTION NODE FOUND
						$this->tombstone = true;
					}
				}
				break;
		}

		try {
			$this->canview($style);
		} catch (Exception $e){
			$this->itemid = "";
			$this->userid = "";
			$this->type = "";
			$this->modificationdate = "";
			$this->changetype = "";
			$this->xml = "";
			$this->user = "";
			$this->node = "";
			$this->con = "";
			$this->currentnode = "";
			$this->currentcon = "";
			
			//$this->follownode = "";
			//$this->followuser = "";
			//$this->$votenode = "";
			//$this->$voteconnection = "";	
			//$this->$viewnode = "";
			return access_denied_error();
		}
	}

    /**
     * Check whether the current user can view the current activity
     *
     * @throws Exception
     */
    function canview($style = 'long') {
        global $USER, $CFG;

		// if the logged in person is the owner, it's fine.
		// NB: 21/12/2023 - not if you are connection to someone else's stuff - it all needs checking
        //if (isset($USER->userid) && $USER->userid != ""
        //		&& $USER->userid == $this->userid) {
		//		if (!$this->currentnode instanceof Hub_Error) {
		//		
		//		}
        //	return true;
        //}

		switch($this->type) {
			case "Node":
				if ($this->tombstone) {
					// not a current node, must be a deleted node
					// so check it based on the XML stored permissions only
					// NB: 21/12/2023 - if the activity is on a now deleted node, do we know if it was archived at some point?
					if ($this->node instanceof Hub_Error) {
						throw new Exception("access denied");
					}
					if ($this->node->private == 'Y' && $this->node->users[0]->userid != $USER->userid) {
						throw new Exception("access denied");
					} else if ($this->node->status == $CFG->STATUS_SUSPENDED 
							|| $this->node->status == $CFG->STATUS_ARCHIVED) {
						throw new Exception("access denied");		
					}						
				} else {
					// if it is a current node, check status and access
					if (!isset($this->currentnode)) {
						throw new Exception("access denied");
					} else if ($this->currentnode instanceof Hub_Error) {
						throw new Exception("access denied");
					} else if ($this->currentnode->private == 'Y' && $this->currentnode->users[0]->userid != $USER->userid) {
						throw new Exception("access denied");	
					} else if ($this->currentnode->status == $CFG->STATUS_SUSPENDED 
							|| $this->currentnode->status == $CFG->STATUS_ARCHIVED) {
						throw new Exception("access denied");							
					}
				}

				break;
			case "Connection":
				if ($this->tombstone) {
					// not a current connection, must be a deleted one
					// so check XML stored permissions
					// NB: 21/12/2023 - if the activity is on a now deleted connection, do we know if it was archived at some point?

					if (!isset($this->con)) {
						throw new Exception("access denied");
					} else if (!isset($this->con->from) || !isset($this->con->to)) {
						throw new Exception("access denied");
					}

					if ($this->con instanceof Connection) {
						if ($this->con->private == 'N' || $this->con->users[0]->userid == $USER->userid) {
							$fromnode = $this->con->from;
							$tonode = $this->con->to;
							if (($fromnode->private == 'N' || $fromnode->users[0]->userid == $USER->userid) 
									||	($tonode->private == 'N' || $tonode->users[0]->userid == $USER->userid)) {								
								// even if you are allowed to view it - check the status
								if ($con->status == $CFG->STATUS_SUSPENDED 
										|| $con->status == $CFG->STATUS_ARCHIVED) {
									throw new Exception("access denied");							
								} else if ($fromnode->status == $CFG->STATUS_SUSPENDED 
										|| $fromnode->status == $CFG->STATUS_ARCHIVED
										|| $tonode->status == $CFG->STATUS_SUSPENDED 
										|| $tonode->status == $CFG->STATUS_ARCHIVED) {
									throw new Exception("access denied");							
								}
								return true;
							}
						} else {
							throw new Exception("access denied");
						}
					} else {
						throw new Exception("access denied");
					}
				} else {
					// if it is a current node, check status and access					
					if (!isset($this->currentcon)) {
						throw new Exception("access denied");
					} else if (!isset($this->currentcon->from) || !isset($this->currentcon->to)) {
						throw new Exception("access denied");
					} else if ($this->currentcon instanceof Hub_Error) {
						throw new Exception("access denied");
					} else if ($this->currentcon->status == $CFG->STATUS_SUSPENDED 
							|| $this->currentcon->status == $CFG->STATUS_ARCHIVED) {
						throw new Exception("access denied");							
					} else if ($this->currentcon->from->status == $CFG->STATUS_SUSPENDED 
							|| $this->currentcon->from->status == $CFG->STATUS_ARCHIVED
							|| $this->currentcon->to->status == $CFG->STATUS_SUSPENDED 
							|| $this->currentcon->to->status == $CFG->STATUS_ARCHIVED) {
						throw new Exception("access denied");							
					}															
				}

				break;

			case "Vote": // can't rely on node and connection class canview at the moment
				// status checked later when item retrieved. We are just sending an id number at this point

				return true;
				break;

			case "View": // can't rely on node class canview at the moment
				// status checked later when item retrieved. We are just sending an id number at this point

				return true;
				break;

			case "Follow": // can't rely on node class canview at the moment
				// status checked later when item retrieved. We are just sending an id number at this point

				return true;
				break;
			}
        //if(api_check_login() instanceof Hub_Error){
        //    throw new Exception("access denied");
        //}
	}
}
?>