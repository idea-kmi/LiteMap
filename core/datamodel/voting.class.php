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
// Voting Class
// Stores the votes for objects
///////////////////////////////////////

class Voting {

    public $id;
    public $positivevoteslist;
    public $negativevoteslist;

    public $positivevotes;
    public $negativevotes;

    public $positiveconnvoteslist;
    public $negativeconnvoteslist;

    public $positiveconnvotes;
    public $negativeconnvotes;

    function Voting($id){
       $this->id = $id;
       $this->votes = array();
       $this->connectionvotes = array();
    }

    function load(){
        global $DB,$USER,$HUB_SQL;

        //$loggedin = api_check_login();
        //if($loggedin instanceof Error){
        //    return $loggedin;
        //}

		$this->loadPositiveVotes();
		$this->loadNegativeVotes();

        //load positive votes
		$this->positivevotes = 0;

		$params = array();
		$params[0] = $this->id;
		$params[1] = 'Y';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_SELECT, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
        		$this->positivevotes = $array['VoteCount'];
       		}
		}

        //load negative votes
		$this->negativevotes = 0;

		$params = array();
		$params[0] = $this->id;
		$params[1] = 'N';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_SELECT, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
        		$this->negativevotes = $array['VoteCount'];
        	}
		} else {
			return database_error();
		}

        //load connection voting
        $this->loadConnectionVotes();

        return $this;
    }

    function loadPositiveVotes(){
        global $DB,$USER,$HUB_SQL;

        //$loggedin = api_check_login();
        //if($loggedin instanceof Error){
        //    return $loggedin;
        //}

        $this->positivevoteslist = array();

		$params = array();
		$params[0] = $this->id;
		$params[1] = 'Y';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_USER_LOAD, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$vi = new Vote();
				$vi->id = $array['ItemID'];
				$vi->type = $array['VoteType'];
				$vi->date = $array['CreationDate'];
				$vi->userid = $array['UserID'];
				$vi->username = $array['Name'];
				array_push($this->positivevoteslist,$vi);
            }
        } else {
        	return database_error();
        }

        return $this;
    }

    function loadNegativeVotes(){
        global $DB,$USER,$HUB_SQL;

        //$loggedin = api_check_login();
        //if($loggedin instanceof Error){
        //    return $loggedin;
        //}

        $this->negativevoteslist = array();

		$params = array();
		$params[0] = $this->id;
		$params[1] = 'N';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_USER_LOAD, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$vi = new Vote();
				$vi->id = $array['ItemID'];
				$vi->type = $array['VoteType'];
				$vi->date = $array['CreationDate'];
				$vi->userid = $array['UserID'];
				$vi->username = $array['Name'];
				array_push($this->negativevoteslist,$vi);
			}
        } else {
        	return database_error();
        }

        return $this;
    }

    function loadConnectionVotes() {
        global $DB,$USER,$HUB_SQL;

        //$loggedin = api_check_login();
        //if($loggedin instanceof Error){
        //    return $loggedin;
        //}

		$this->loadPositiveConnectionVotes();
		$this->loadNegativeConnectionVotes();

        //load positive connection votes
		$this->positiveconnvotes = 0;

		$params = array();
		$params[0] = $this->id;
		$params[1] = $this->id;
		$params[2] = 'Y';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_CONN_LOAD, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
       			$this->positiveconnvotes = $array['VoteCount'];
       		}
		} else {
			return database_error();
		}

        //load negative connection votes
		$this->negativeconnvotes = 0;

		$params = array();
		$params[0] = $this->id;
		$params[1] = $this->id;
		$params[2] = 'N';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_CONN_LOAD, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$this->negativeconnvotes = $array['VoteCount'];
			}
 		} else {
        	return database_error();
        }
    }

    function loadPositiveConnectionVotes(){
        global $DB,$USER,$HUB_SQL;

        //$loggedin = api_check_login();
        //if($loggedin instanceof Error){
        //    return $loggedin;
        //}

        $this->positiveconnvoteslist = array();

		$params = array();
		$params[0] = $this->id;
		$params[1] = $this->id;
		$params[2] = 'Y';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_USER_CONN, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$vi = new Vote();
				$vi->id = $array['ItemID'];
				$vi->type = $array['VoteType'];
				$vi->date = $array['CreationDate'];
				$vi->userid = $array['UserID'];
				$vi->username = $array['Name'];
				array_push($this->positiveconnvoteslist,$vi);
            }
        } else {
        	return database_error();
        }

        return $this;
    }

    function loadNegativeConnectionVotes(){
        global $DB,$USER,$HUB_SQL;

        //$loggedin = api_check_login();
        //if($loggedin instanceof Error){
        //    return $loggedin;
        //}

        $this->negativeconnvoteslist = array();

		$params = array();
		$params[0] = $this->id;
		$params[1] = $this->id;
		$params[2] = 'N';
		$resArray = $DB->select($HUB_SQL->DATAMODEL_VOTING_USER_CONN, $params);
    	if ($resArray !== false) {
			$count = count($resArray);
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$vi = new Vote();
				$vi->id = $array['ItemID'];
				$vi->type = $array['VoteType'];
				$vi->date = $array['CreationDate'];
				$vi->userid = $array['UserID'];
				$vi->username = $array['Name'];
				array_push($this->negativeconnvoteslist,$vi);
            }
        } else {
        	return database_error();
        }

        return $this;
    }
}

class Vote {
    public $id;
    public $type;
    public $date;
    public $userid;
    public $username;
}
?>