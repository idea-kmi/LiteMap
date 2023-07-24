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
// NodeSet Class
///////////////////////////////////////

class NodeSet {

    public $totalno = 0;
    public $start = 0;
    public $count = 0;
    public $nodes;

    /**
     * Constructor
     *
     */
    function NodeSet() {
        $this->nodes = array();
    }

    /**
     * add a node to the set
     *
     * @param Node $node
     */
    function add($node){
        array_push($this->nodes,$node);
    }

    /**
     * load in the nodes for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param int $start starting from record item
     * @param int $max for a record limit of this given count
     * @param string $orderby the name of the field to sort by
     * @param string $sort 'ASC' or 'DESC' (ascending or descending ordering)
     * @param string the style of each record in the collection (defaults to 'short' , can be 'long');
     * @return NodeSet (this)
     */
    function load($sql,$params,$start,$max,$orderby,$sort,$style = 'short'){
        global $DB,$HUB_SQL;
        if (!isset($params)) {
			$params = array();
		}

		// GET TOTAL RECORD COUTN BEFORE LIMITING
		$csql = $HUB_SQL->DATAMODEL_NODE_LOAD_PART1;
		$csql .= $sql;
		$csql .= $HUB_SQL->DATAMODEL_NODE_LOAD_PART2;
		$carray = $DB->select($csql, $params);
        $totalconns = $carray[0]["totalnodes"];

        // ADD SORTING
       	$sql = $DB->nodeOrderString($sql, $orderby, $sort);

        // ADD LIMITING
        $sql = $DB->addLimitingResults($sql, $start, $max);

		//error_log("Search1=".$sql);

		$resArray = $DB->select($sql, $params);

        //create new nodeset and loop to add each node to the set
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
        $this->totalno = $totalconns;
        $this->start = $start;
        $this->count = $count;
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
            $node = new CNode($array["NodeID"]);
            $this->add($node->load($style));
        }

        return $this;
    }

    /**
     * load in the nodes for the given SQL statement without altering it for sort etc..
     * adding a context dependednt 'usecount' variable to each node based on 'UseCount' field in sql results.
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param string the style of each record in the collection (defaults to 'short' , can be 'long');
     * @return NodeSet (this)
     */
    function loadUseCount($sql,$params,$style = 'short'){
        global $DB;
        if (!isset($params)) {
			$params = array();
		}

		$resArray = $DB->select($sql, $params);
        if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			$this->count = $count;
			$this->totalno = $count;
			$this->start = 0;
			for ($i=0; $i < $count; $i++) {
				$array = $resArray[$i];
				$node = new CNode($array["NodeID"]);
				$node = $node->load($style);
				$node->usecount = $array["UseCount"];
				$this->add($node);
			}
		}
        return $this;
    }

    /**
     * load in the nodes for the given SQL statement without altering it for sort etc..
     * adding a context dependent extra variable to each node based on extra fields in sql results.
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param string the style of each record in the collection (defaults to 'short' , can be 'long');
     * @return NodeSet (this)
     */
    function loadNodesWithExtras($sql,$params,$style = 'short'){
        global $DB;
        if (!isset($params)) {
			$params = array();
		}

		$resArray = $DB->select($sql, $params);
        if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			$this->count = $count;
			$this->totalno = $count;
			$this->start = 0;
			for ($i=0; $i < $count; $i++) {
				$array = $resArray[$i];
				$node = new CNode($array["NodeID"]);
				$node = $node->load($style);
				foreach($array as $key => $value) {
					if ($key != "NodeID") {
						if ( preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $key) ){
							$node->$key = $value;
						}
					}
				}
				$this->add($node);
			}
		}
        return $this;
    }

}
?>