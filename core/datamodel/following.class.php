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
// Following Class
// Stores the following entry for a user
///////////////////////////////////////

class Following {

    public $itemid;
    public $userid;
    public $creationdate;

    function Following($itemid){
       $this->itemid = $itemid;
    }

    function load(){
        global $DB,$USER,$HUB_SQL;

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
		$params[1] = $this->itemid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_FOLLOW_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$this->userid = $array['UserID'];
				$this->creationdate = $array['CreationDate'];
        	}
		} else {
			return database_error();
		}

        return $this;
    }

    function add() {
        global $DB,$CFG,$USER,$HUB_SQL;

        //check user can edit the following on this node
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
		$params[0] = $this->itemid;
		$params[1] = $currentuser;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_FOLLOW_ADD_CHECK, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if( $count == 0 ) {
        		$dt = time();

				$params = array();
				$params[0] = $currentuser;
				$params[1] = $this->itemid;
				$params[2] = $dt;

				$res = $DB->insert($HUB_SQL->DATAMODEL_FOLLOW_ADD, $params);
                if (!$res) {
                     return database_error();
                }
            }
        } else {
        	return database_error();
        }

        $this->load();
        return $this;
     }

    function delete() {
        global $DB,$CFG,$USER,$HUB_SQL;

        try {
            $this->candelete();
        } catch (Exception $e){
            return access_denied_error();
        }

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $this->itemid;
		$params[1] = $currentuser;
		$res = $DB->delete($HUB_SQL->DATAMODEL_FOLLOW_DELETE, $params);
        if (!$res) {
             return database_error();
        }
        $this->load();
        return $this;
    }

    /**
     * Check whether the current user can view the current following item
     *
     * @throws Exception
     */
    function canview(){
        // needs to be logged
        api_check_login();
    }

    /**
     * Check whether the current user can add a following entry
     *
     * @throws Exception
     */
    function canadd(){
        // needs to be logged
        api_check_login();
    }

    /**
     * Check whether the current user can delete the current following entry
     *
     * @throws Exception
     */
    function candelete(){
        global $DB,$USER,$LNG;

        //can delete only if owner of the following entry
        api_check_login();

        if ($this->userid != $USER->userid) {
            throw new Exception($LNG->ERROR_ACCESS_DENIED_MESSAGE);
        }
    }
}
?>