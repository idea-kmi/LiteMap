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
// UserSet Class
///////////////////////////////////////

class UserSet {

    public $totalno = 0;
    public $start = 0;
    public $count = 0;
    public $users;

    /**
     * Constructor
     *
     */
    function UserSet() {
        $this->users = array();
    }

    /**
     * add a User to the set
     *
     * @param User $user
     */
    function add($user){
        array_push($this->users,$user);
    }

    /**
     * load in the users for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param int $start starting from record item
     * @param int $max for a record limit of this given count
     * @param string $orderby the name of the field to sort by
     * @param string $sort 'ASC' or 'DESC' (ascending or descending ordering)
     * @param string the style of each record in the collection (defaults to 'long' , can be 'short');
     * @return UserSet (this)
     */
    function load($sql,$params,$start,$max,$orderby,$sort,$style='long'){
        global $DB, $HUB_SQL;
        if (!isset($params)) {
			$params = array();
		}

		// get the total count of the connection records.
		$csql = $HUB_SQL->DATAMODEL_USER_LOAD_PART1;
		$csql .= $sql;
		$csql .= $HUB_SQL->DATAMODEL_USER_LOAD_PART2;
		$carray = $DB->select($csql, $params);

        $totalusers = $carray[0]["totalusers"];

        // ADD SORTING - name done after as Virtuoso can't sort on long fields
       	if ($orderby != 'name') {
	        $sql = $DB->userOrderString($sql, $orderby, $sort);
		}

        // ADD LIMITING
        $sql = $DB->addLimitingResults($sql, $start, $max);

		$resArray = $DB->select($sql, $params);

		$count = count($resArray);
        $this->totalno = $totalusers;
        $this->start = $start;
        $this->count = $count;
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
            $u = new User($array["UserID"]);
            $this->add($u->load($style));
        }

        if ($orderby == 'name') {
			usort($this->users, 'nameSort');
        }

        return $this;
    }

    /**
     * load in the users for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param int $start starting from record item
     * @param int $max for a record limit of this given count
     * @param string $orderby the name of the field to sort by
     * @param string $sort 'ASC' or 'DESC' (ascending or descending ordering)
     * @param string the style of each record in the collection (defaults to 'long' , can be 'short');
     * @return UserSet (this)
     */
    function loadFollowers($sql,$params,$start,$max,$orderby,$sort,$style='long'){
        global $DB, $HUB_SQL;
        if (!isset($params)) {
 			$params = array();
 		}

 		// get the total count of the connection records.
 		$csql = $HUB_SQL->DATAMODEL_USER_LOAD_PART1;
 		$csql .= $sql;
 		$csql .= $HUB_SQL->DATAMODEL_USER_LOAD_PART2;
 		$carray = $DB->select($csql, $params);
        $totalusers = $carray[0]["totalusers"];

        // ADD SORTING
        $sql = $DB->userOrderString($sql, $orderby, $sort);

        // ADD LIMITING
        $sql = $DB->addLimitingResults($sql, $start, $max);

 		$resArray = $DB->select($sql, $params);

 		$count = count($resArray);
        $this->totalno = $totalusers;
        $this->start = $start;
        $this->count = $count;
 		for ($i=0; $i<$count; $i++) {
 			$array = $resArray[$i];
            $u = new User($array["UserID"]);
            $u->followdate = $array["CreationDate"];
            $this->add($u->load($style));
        }
        return $this;
    }

    /**
     * load in the users for the given SQL statement - recording how many followers they have.
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param string the style of each record in the collection (defaults to 'long' , can be 'short');
     * @return UserSet (this)
     */
    function loadFollowed($sql,$params,$style='long'){
        global $DB, $HUB_SQL;
        if (!isset($params)) {
 			$params = array();
 		}

 		// get the total count of the connection records.
 		$csql = $HUB_SQL->DATAMODEL_USER_LOAD_PART1;
 		$csql .= $sql;
 		$csql .= $HUB_SQL->DATAMODEL_USER_LOAD_PART2;
 		$carray = $DB->select($csql, $params);
        $totalusers = $carray[0]["totalusers"];

 		$resArray = $DB->select($sql, $params);

 		$count = count($resArray);
        $this->totalno = $totalusers;
        $this->count = $count;
 		for ($i=0; $i<$count; $i++) {
 			$array = $resArray[$i];
            $u = new User($array["UserID"]);
            $u->followcount = $array["UseCount"];
            $this->add($u->load($style));
        }
        return $this;
    }

    /**
     * load in the users for the given SQL statement - recording how active they have.
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param string the style of each record in the collection (defaults to 'long' , can be 'short');
     * @return UserSet (this)
     */
    function loadActive($sql,$params,$style='long'){
        global $DB, $HUB_SQL;
        if (!isset($params)) {
 			$params = array();
 		}

 		// get the total count of the connection records.
 		$csql = $HUB_SQL->DATAMODEL_USER_LOAD_PART1;
 		$csql .= $sql;
 		$csql .= $HUB_SQL->DATAMODEL_USER_LOAD_PART2;
 		$carray = $DB->select($csql, $params);
        $totalusers = $carray[0]["totalusers"];

 		$resArray = $DB->select($sql, $params);

 		$count = count($resArray);
        $this->totalno = $totalusers;
        $this->count = $count;
 		for ($i=0; $i<$count; $i++) {
 			$array = $resArray[$i];
            $u = new User($array["UserID"]);
            $u->activecount = $array["UseCount"];
            $this->add($u->load($style));
        }
        return $this;
    }
}
?>