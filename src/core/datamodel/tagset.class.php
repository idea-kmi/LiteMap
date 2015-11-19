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
// TagSet Class
///////////////////////////////////////

class TagSet {

    public $tags;

    /**
     * Constructor
     *
     */
    function TagSet() {
        $this->tags = array();
    }

    /**
     * Add a Tag to the set
     *
     * @param Tag $tag
     */
    function add($tag){
        array_push($this->tags,$tag);
    }

    /**
     * Load in the tags for the given SQL statement
     *
     * @param string $sql
     * @param array $params the parameters that go into the sql statement
     * @return TagSet (this)
     */
    function load($sql,$params){
        global $DB;
        if (!isset($params)) {
			$params = array();
		}

		$resArray = $DB->select($sql, $params);
		$count = count($resArray);
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
           	$r = new Tag($array["TagID"]);
           	$this->add($r->load());
        }
        return $this;
    }
}
?>