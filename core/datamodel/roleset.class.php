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
// RoleSet Class
///////////////////////////////////////

class RoleSet {

    public $roles;

    /**
     * Constructor
     *
     */
    function RoleSet() {
        $this->roles = array();
    }

    /**
     * add a Role to the set
     *
     * @param Role $role
     */
    function add($role){
        array_push($this->roles,$role);
    }

    /**
     * load in the roles for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @return RoleSet (this)
     */
    function load($sql,$params){
        global $DB;
        if (!isset($params)) {
			$params = array();
		}
		$resArray = $DB->select($sql, $params);
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
      		$r = new Role($array["NodeTypeID"]);
           	$this->add($r->load());
        }
        return $this;
    }

    /**
     * load in the roles for the given SQL statement, but only the names and images for using on a filter list
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @return RoleSet (this)
     */
    function loadFilterRoles($sql,$params){
        global $DB;
        if (!isset($params)) {
			$params = array();
		}
		$resArray = $DB->select($sql, $params);
		$count = 0;
		if (is_countable($resArray)) {
			$count = count($resArray);
		}
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$r = new Role();
			$r->name = $array["Name"];
			$r->image = $array["Image"];
			$this->add($r);
        }
        return $this;
    }

}
?>