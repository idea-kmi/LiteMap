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
// GroupSet Class
///////////////////////////////////////

class GroupSet {

    public $totalno = 0;
    public $start = 0;
    public $count = 0;
    public $groups;

    /**
     * Constructor
     *
     */
    function GroupSet() {
        $this->groups = array();
    }

    /**
     * add a Group to the set
     *
     * @param Group $group
     */
    function add($group){
        array_push($this->groups,$group);
    }

    /**
     * load in the groups for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @return GroupSet (this)
     */
    function load($sql, $params){
        global $DB,$HUB_SQL;

        if (!isset($params)) {
			$params = array();
		}
		$resArray = $DB->select($sql, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$g = new Group($array["GroupID"]);
				$this->add($g->load());
			}
		}
        return $this;
    }

    /**
     * load in the groups for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param int $start starting from record item
     * @param int $max for a record limit of this given count
     * @param string $orderby the name of the field to sort by
     * @param string $sort 'ASC' or 'DESC' (ascending or descending ordering)
     * @param string the style of each record in the collection (defaults to 'long' , can be 'short');
     * @return GroupSet (this)
     */
    function loadFromUsers($sql,$params,$start,$max,$orderby,$sort,$style='long'){
        global $DB,$HUB_SQL;
        if (!isset($params)) {
			$params = array();
		}

		// get the total count of the connection records.
		$csql = $HUB_SQL->DATAMODEL_GROUP_LOAD_PART1;
		$csql .= $sql;
		$csql .= $HUB_SQL->DATAMODEL_GROUP_LOAD_PART2;

		$carray = $DB->select($csql, $params);
        $totalconns = $carray[0]["totalusers"];

        // get the connection records for the given parameters, start, max etc.
        // ADD SORTING
        $sql = $DB->groupOrderString($sql, $orderby, $sort);

        // ADD LIMITING
        $sql = $DB->addLimitingResults($sql, $start, $max);

		$resArray = $DB->select($sql, $params);

		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
        $this->totalno = $totalconns;
        $this->start = $start;
        $this->count = $count;
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$g = new Group($array["UserID"]);
            $this->add($g->load());
         }
        return $this;
    }
}
?>