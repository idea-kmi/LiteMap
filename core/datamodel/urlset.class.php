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
// URLSet Class
///////////////////////////////////////

class URLSet {

    public $totalno = 0;
    public $start = 0;
    public $count = 0;
    public $urls;

    /**
     * Constructor
     *
     */
    function URLSet() {
        $this->urls = array();
    }

    /**
     * add a URL to the set
     *
     * @param URL $url
     */
    function add($url){
        array_push($this->urls,$url);
    }

    /**
     * load in the urls for the given SQL statement
     *
     * @param string $sql
     * @param array $params
     * @param integer $start (optional - default: 0)
     * @param integer $max (optional - default: 20)
     * @param string $orderby (optional, either 'date', 'nodeid', 'name' or 'moddate' - default: 'date')
     * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
     * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a urls details to load (long includes: tags and groups).
     * @return URLSet (this)
     */
    function load($sql,$params,$start=0,$max=20,$orderby='date',$sort='ASC',$style='long'){
        global $DB,$HUB_SQL;
        if (!isset($params)) {
			$params = array();
		}


		// get the total count of the connection records.
		$csql = $HUB_SQL->DATAMODEL_URL_LOAD_PART1;
		$csql .= $sql;
		$csql .= $HUB_SQL->DATAMODEL_URL_LOAD_PART2;
		$carray = $DB->select($csql, $params);
        $totalconns = $carray[0]["totalurls"];

        // ADD SORTING - name done after as Virtuoso can't sort on long fields
       	if ($orderby != 'name') {
	        $sql = $DB->urlOrderString($sql, $orderby, $sort);
		}

        // ADD LIMITING
        $sql = $DB->addLimitingResults($sql, $start, $max);

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
            $url = new URL($array['URLID']);
            $this->add($url->load($style));
        }

        if ($orderby == 'name') {
			usort($this->urls, 'descSort');
        }

        return $this;
    }
}
?>