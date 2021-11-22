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

/**
 * DESCRIBES THE DATAMODEL OF CONNECTIONS.
 * For the evidence hub server side code to use.
 **/

/**
 * The object that holds all the information about a given connection definition
 */
class DataModelConnection {

	private $fromnodetypeArray;
	private $tonodetypeArray;
	private $linktype;

	function load($fromnodetypes, $linktype, $tonodetypes) {
		$this->fromnodetypeArray = $fromnodetypes;
		$this->linktype = $linktype;
		$this->tonodetypeArray = $tonodetypes;
	}

	/**
	 * do the passed items match this Connection definition
	 */
	function matches($fromnode, $link, $tonode) {
		$matches  = false;

		/*
		error_log(print_r("in array from=".$fromnode,true));
		error_log(print_r("in array to=".$tonode, true));
		error_log(print_r("link=".$link, true));
		error_log(print_r($this->fromnodetypeArray, true));
		error_log(print_r($this->linktype, true));
		error_log(print_r($this->tonodetypeArray, true));
		*/

		if (in_array($fromnode, $this->fromnodetypeArray)
			&& $this->linktype === $link
				&& in_array($tonode, $this->tonodetypeArray)) {
			$matches = true;
			//echo "MATCHES";
		}

		return $matches;
	}
}


/**
 * The object that holds all the connection definitions and functions to check data against them.
 */
class DataModel {

	private $hubmodel = array();

	function load() {
		global $CFG;

		$NODE_SET_COMMENT = array("Challenge","Issue","Solution","Pro","Con","Argument","Idea","Map");
		$NODE_SET_SEE_ALSO = array("Challenge","Issue","Solution","Pro","Con","Argument","Idea");
		$NODE_SET_BUILT_FROM = array("Issue","Solution","Pro","Con","Argument");
		$NODE_SET_IDEA = array("Issue","Solution","Pro","Con","Argument");

		$this->hubmodel[0] = new DataModelConnection();
		$this->hubmodel[0]->load( array("Issue"), $CFG->LINK_ISSUE_CHALLENGE, array("Challenge"));

		$this->hubmodel[1] = new DataModelConnection();
		$this->hubmodel[1]->load( array("Solution"), $CFG->LINK_SOLUTION_ISSUE, array("Issue"));

		$this->hubmodel[2] = new DataModelConnection();
		$this->hubmodel[2]->load( array("Pro","Argument"), $CFG->LINK_PRO_SOLUTION, array("Solution"));

		$this->hubmodel[3] = new DataModelConnection();
		$this->hubmodel[3]->load( array("Con","Argument"), $CFG->LINK_CON_SOLUTION, array("Solution"));

		$this->hubmodel[4] = new DataModelConnection();
		$this->hubmodel[4]->load($NODE_SET_BUILT_FROM, $CFG->LINK_COMMENT_BUILT_FROM, array("Comment","Idea"));

		$this->hubmodel[5] = new DataModelConnection();
		$this->hubmodel[5]->load( array("Comment"), $CFG->LINK_COMMENT_NODE, $NODE_SET_COMMENT);

		$this->hubmodel[6] = new DataModelConnection();
		$this->hubmodel[6]->load(array("Comment"), $CFG->LINK_COMMENT_NODE, array("Comment"));

		$this->hubmodel[7] = new DataModelConnection();
		$this->hubmodel[7]->load($NODE_SET_SEE_ALSO, $CFG->LINK_NODE_SEE_ALSO, array("Map"));

		$this->hubmodel[8] = new DataModelConnection();
		$this->hubmodel[8]->load( array("Idea"), $CFG->LINK_IDEA_NODE, $NODE_SET_IDEA);

		$this->hubmodel[9] = new DataModelConnection();
		$this->hubmodel[9]->load( array("Idea"), $CFG->LINK_IDEA_NODE, array("Idea"));

		$this->hubmodel[10] = new DataModelConnection();
		$this->hubmodel[10]->load( array("Pro"), $CFG->LINK_PRO_SOLUTION, array("Pro"));

		$this->hubmodel[11] = new DataModelConnection();
		$this->hubmodel[11]->load( array("Pro"), $CFG->LINK_PRO_SOLUTION, array("Con"));

		$this->hubmodel[12] = new DataModelConnection();
		$this->hubmodel[12]->load( array("Con"), $CFG->LINK_CON_SOLUTION, array("Pro"));

		$this->hubmodel[13] = new DataModelConnection();
		$this->hubmodel[13]->load( array("Con"), $CFG->LINK_CON_SOLUTION, array("Con"));

		$this->hubmodel[14] = new DataModelConnection();
		$this->hubmodel[14]->load( array("Issue"), $CFG->LINK_ISSUE_ISSUE, array("Issue"));

		$this->hubmodel[15] = new DataModelConnection();
		$this->hubmodel[15]->load( array("Solution"), $CFG->LINK_SOLUTION_SOLUTION, array("Solution"));

		$this->hubmodel[16] = new DataModelConnection();
		$this->hubmodel[16]->load( array("Issue"), $CFG->LINK_ISSUE_SOLUTION, array("Solution"));

		$this->hubmodel[17] = new DataModelConnection();
		$this->hubmodel[17]->load( array("Argument"), $CFG->LINK_PRO_SOLUTION, array("Argument","Pro","Con"));

		$this->hubmodel[18] = new DataModelConnection();
		$this->hubmodel[18]->load( array("Argument"), $CFG->LINK_CON_SOLUTION, array("Argument","Pro","Con"));
	}

	function matchesModel($fromnode, $link, $tonode) {
		$matches = false;

		$i=0;
		$count = 0;
		if (is_countable($this->hubmodel)) {
			$count = count($this->hubmodel);
		}
		for ($i=0; $i<$count; $i++) {
			$next = $this->hubmodel[$i];
			//echo $i." ";
			if ($next->matches($fromnode, $link, $tonode)) {
				//error_log("MATCH FOUND");
				$matches = true;
				break;
			}
		}

		//error_log($matches);

		return $matches;
	}

 	function matchesModelPro($fromnode, $link, $tonode) {
 		global $CFG;

		$matches = false;
		if ($fromnode == "Pro"
			&& $link === $CFG->LINK_PRO_SOLUTION
				&& $tonode == "Solution") {

			$matches = true;
		}

		return $matches;
	}

	function matchesModelCon($fromnode, $link, $tonode) {
		global $CFG;

		$matches  = false;

		if ($fromnode == "Con"
			&& $link === $CFG->LINK_CON_SOLUTION
				&& $tonode == "Solution") {

			$matches = true;
		}

		return $matches;
	}
}
?>