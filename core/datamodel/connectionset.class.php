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
// ConnectionSet Class
///////////////////////////////////////

class ConnectionSet {

    public $totalno = 0;
    public $start = 0;
    public $count = 0;
    public $connections;

    /**
     * Constructor
     *
     */
    function ConnectionSet() {
        $this->connections = array();
    }

    /**
     * add a connection to the set
     *
     * @param Connection $conn
     */
    function add($conn){
        array_push($this->connections,$conn);
    }

    /**
     * load in the connections for the given SQL statement
     *
     * @param string $sql the sql to run to fetch a collection of connection records.
     * @param array $params the parameters that go into the sql statement
     * @param int $start starting from record item
     * @param int $max for a record limit of this given count
     * @param string $orderby the name of the field to sort by
     * @param string $sort 'ASC' or 'DESC' (ascending or descending ordering)
     * @param string the style of each record in the collection (defaults to 'long' , can be 'short');
     * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired, 3 - discarded, 4 - suspended, 5 - archived)
     * @return ConnectionSet (this)
     */
    function load($sql, $params, $start, $max, $orderby, $sort, $style='long', $status=0){
        global $DB,$HUB_SQL;

        if (!isset($params)) {
			$params = array();
		}

		// get the total count of the connection records.
		$csql = $HUB_SQL->DATAMODEL_CONNECTION_LOAD_PART1;
		$csql .= $sql;
		$csql .= $HUB_SQL->DATAMODEL_CONNECTION_LOAD_PART2;
		$carray = $DB->select($csql, $params);
        $totalconns = $carray[0]["totalconns"];

        // ADD SORTING
        $sql = $DB->connectionOrderString($sql, $orderby, $sort);

        // ADD LIMITING
        $sql = $DB->addLimitingResults($sql, $start, $max);

		$resArray = $DB->select($sql, $params);

        //create new nodeset and loop to add each node to the set
		$count = (is_countable($resArray)) ? count($resArray) : 0;

        $this->totalno = $totalconns;
        $this->start = $start;
        $this->count = $count;
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
            $c = new Connection($array["TripleID"]);
            $conn = $c->load($style);

			// if there are other array properties add them to the connections.
			if ($orderby == 'ideavote') {
				foreach($array as $key => $value) {
					if ($key != "TripleID") {
						if ( preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $key) ){
							$conn->$key = $value;
						}
					}
				}
			}

            // Reported nodes are not the same status as the nodes at the other end of their connections
            // so can't check status
            $this->add($conn);
        }

        return $this;
    }

    /**
     * load in the connections given in the passed array
     *
     * @param array $conns the array to load.
     * @param integer $status, defaults to 0. (0 - active, 1 - reported, 2 - retired, 3 - discarded, 4 - suspended, 5 - archived)
     * @return ConnectionSet (this)
     */
    function loadConnections($conns, $style='long', $status=0) {
        $this->start = 0;

        $checkArray = array();

		$counti = (is_countable($conns)) ? count($conns) : 0;
        for ($i=0; $i < $counti; $i++) {
			$array = $conns[$i];
			if (!array_key_exists($array['TripleID'],$checkArray)) {
				$c = new Connection($array["TripleID"]);
				$conn = $c->load($style);

                // Reported nodes are not the same status as the nodes at the other end of their connections
                // so can't check status
                $this->add($conn);
    		    $checkArray[$array["TripleID"]] = $array["TripleID"];
			}
        }

		$this->totalno = (is_countable($this->connections))  ? count($this->connections) : 0;
        $this->count =  $this->totalno;

        return $this;
    }
}
?>
