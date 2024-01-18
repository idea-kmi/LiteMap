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
// ViewSet Class
///////////////////////////////////////

class ViewSet {
    public $count = 0;
    public $views;

    /**
     * Constructor
     *
     */
    function ViewSet() {
        $this->views = array();
    }

    /**
     * add a view to the set
     *
     * @param $view the View object to add
     */
    function add($view){
        array_push($this->views,$view);
    }

    /**
     * load in the view for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param string the style of each record in the collection (defaults to 'short' , can be 'long');
     * @return ViewSet (this)
     */
    function load($sql,$params,$style = 'short'){
        global $DB,$HUB_SQL;
        if (!isset($params)) {
			$params = array();
		}

		$resArray = $DB->select($sql, $params);

		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
        $this->count = $count;
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
            $view = new View($array["ViewID"]);
            $this->add($view->load($style));
        }
        return $this;
    }

    /**
     * load in the view for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @param string the style of each record in the collection (defaults to 'short' , can be 'long');
     * @return ViewSet (this)
     */
    function loadFromNodes($sql,$params,$style = 'short'){
        global $DB,$HUB_SQL;
        if (!isset($params)) {
			$params = array();
		}

		$resArray = $DB->select($sql, $params);

		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
        $this->count = $count;
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
            $view = new View($array["NodeID"]);
            $this->add($view->load($style));
        }
        return $this;
    }
}
?>