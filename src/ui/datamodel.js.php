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

   global $CFG, $LNG;
?>

<script>
/**
  * For validating connections against the Data model. It should mirror the DataModel class in Core.
  * NOT CURRENTLY USED - BUT AT SOME POINT MAPS SHOULD USE THIS
  */
function DataModel() {

	this.hubmodel = new Array();

	this.NODE_SET_SEE_ALSO = ["Challenge","Issue","Solution","Pro","Con","Argument"];
	this.NODE_SET_IDEA = ["Challenge","Issue","Solution","Pro","Con","Argument"];
	this.NODE_SET_BUILT_FROM = ["Issue","Solution","Pro","Con","Argument"];
	this.NODE_SET_COMMENT = ["Challenge","Issue","Solution","Pro","Con","Argument","Map"];

	this.hubmodel[0] = new DataModelConnection(["Issue"], '<?php echo $CFG->LINK_ISSUE_CHALLENGE; ?>', ["Challenge"]);
	this.hubmodel[1] = new DataModelConnection(["Solution"], '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>', ["Issue"]);
	this.hubmodel[2] = new DataModelConnection(["Pro"], '<?php echo $CFG->LINK_PRO_SOLUTION; ?>', ["Solution"]);
	this.hubmodel[3] = new DataModelConnection(["Con"], '<?php echo $CFG->LINK_CON_SOLUTION; ?>', ["Solution"]);
	this.hubmodel[4] = new DataModelConnection(this.NODE_SET_BUILT_FROM, '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>', ["Comment","Idea"]);
	this.hubmodel[5] = new DataModelConnection(["Comment"], '<?php echo $CFG->LINK_COMMENT_NODE; ?>', this.NODE_SET_COMMENT);
	this.hubmodel[6] = new DataModelConnection(["Comment"], '<?php echo $CFG->LINK_COMMENT_NODE; ?>', ["Comment"]);
	this.hubmodel[7] = new DataModelConnection(this.NODE_SET_SEE_ALSO, '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>', ["Map"]);
	this.hubmodel[8] = new DataModelConnection(["Idea"], '<?php echo $CFG->LINK_COMMENT_NODE; ?>', this.NODE_SET_IDEA);
	this.hubmodel[9] = new DataModelConnection(["Pro"], '<?php echo $CFG->LINK_PRO_SOLUTION; ?>', ["Pro"]);
	this.hubmodel[10] = new DataModelConnection(["Pro"], '<?php echo $CFG->LINK_PRO_SOLUTION; ?>', ["Con"]);
	this.hubmodel[11] = new DataModelConnection(["Con"], '<?php echo $CFG->LINK_CON_SOLUTION; ?>', ["Pro"]);
	this.hubmodel[12] = new DataModelConnection(["Con"], '<?php echo $CFG->LINK_CON_SOLUTION; ?>', ["Con"]);
	this.hubmodel[13] = new DataModelConnection(["Issue"], '<?php echo $CFG->LINK_ISSUE_ISSUE; ?>', ["Issue"]);
	this.hubmodel[14] = new DataModelConnection(["Solution"], '<?php echo $CFG->LINK_SOLUTION_SOLUTION; ?>', ["Solution"]);
	this.hubmodel[15] = new DataModelConnection(["Issue"], '<?php echo $CFG->LINK_ISSUE_SOLUTION; ?>', ["Solution"]);

	this.matchesModel = function(fromnode, link, tonode) {
		var matches = false;

		var i=0;
		var count = this.hubmodel.length;
		for (i=0; i<count; i++) {
			var next = this.hubmodel[i];
			//alert(i);
			if (next.matches(fromnode, link, tonode)) {
				//alert("MATCH FOUND");
				matches = true;
				break;
			}
		}

		//alert(matches);
		return matches;
	}
}

/**
 * This class is a instance of a possible Connection
 * Has a method to validate if the passed combination of from node, link and to node is valid for this connection.
 */
function DataModelConnection(fromnodetypeArray, linktype, tonodetypeArray) {

	this.fromnodetypeArray = fromnodetypeArray;
	this.tonodetypeArray = tonodetypeArray;
	this.linktype = linktype;

	/**
	 * do the passed items match this Connection definition
	 */
	this.matches = function(fromnode, link, tonode) {
		var matches  = false;

		if (this.fromnodetypeArray.indexOf(fromnode) != -1
			&& this.linktype === link
				&& this.tonodetypeArray.indexOf(tonode) != -1) {
			matches = true;
			//alert("MATCHES");
		}

		return matches;
	}
}

</script>