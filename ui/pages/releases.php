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
include_once("../../config.php");

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
?>

<div style="float:left;padding:10px;padding-top:0px;padding-botton:0px;">
<center><h1><?php echo $CFG->SITE_TITLE; ?> Releases</h1></center>

<h2>0.01 Alpha - <span style="font-size:10pt;">October 2013 - 10th February 2015</span></h2>
<p>Initial development:
<ol>
<li>Groups for user and data clustering.</li>
<li>HTML5 Canvas based mapping of IBIS discussions.</li>
<li>New list design based on panels for each item with images on Groups and Maps.</li>
<li>Dashboard of visualisation at System, Groups and Map levels.</li>
<li>New restful API returning CIF formatted jsonld.</li>
<li>Embeddable options on all maps to get iframe snippets for read only maps.</li>
<li>Testing system for automatic A/B grouping and test specific logging.</li>
</ol>
</p>

<h2>0.1 Alpha - <span style="font-size:10pt;">11th February 2015</span></h2>
<p>
<ol>
<li>Implement memcache for Restful API.</li>
<li>Browser extensions to suplement the bookmarklet toolbar.</li>
<li>Toolbars on all nodes for easy action access including: edit, remove, vote, view urls,
view parent maps (for transcluded nodes), view details and a rollover menu to add nodes to
map and link back to current node.</li>
</ol>
</p>

<h2>0.2 Alpha - <span style="font-size:10pt;">2nd March 2015</span></h2>
<p>Mapping interface redesign, including:
<ol>
<li>Mapping over images.</li>
<li>New draggable div-based node explore view.</li>
<li>Right-click drag and drop node linking.</li>
<li>Right-click node creation menu as well as node creation toolbar.</li>
<li>Map specific search.</li>
<li>Linear view option.</li>
<li>Embeddable options on all maps to get iframe snippets for editable maps.</li>
</ol>
</p>

<h2>0.3 Alpha - <span style="font-size:10pt;">8th April 2015</span></h2>
<p>
<ol>
<li>User obfuscation: Separation of private user data from main data on Restful API calls including a security key system.</li>
<li>New group joining management system</li>
<li>'My Groups' tab in user area to show groups I manage and groups I am in.</li>
</ol>
</p>

<h2>0.4 Alpha - <span style="font-size:10pt;">6th May 2015</span></h2>
<p>
<ol>
<li>New homepage design showing you your Groups and Issues when logged in.</li>
<li>New scrolling lists on homepage.</li>
<li>New Edit Bar on maps to drag and drop nodes onto map easily.</li>
</ol>
</p>

<h2>0.5 Alpha - <span style="font-size:10pt;">22nd May 2015</span></h2>
<p>
<ol>
<li>Moved the website from a fixed width to a full width design, mainly to increase mapping area.</li>
</ol>
</p>

<h2>0.6 Alpha - <span style="font-size:10pt;">30th June 2015</span></h2>
<p>The map page has a new tabs system to integrated visualisations and analytics more directly.
<ol>
<li>The actual Mapping area as was.</li>
<li>Alternative Views: uses 5 CIDashboard visualisations:<ul>
	<li>Sunburst</li><li>Conversation Nesting</li><li>Treemap - Leaves</li><li>Treemap - Top Down</li><li>Conversation Network.</li>
	</ul>
</li>
<li>Visual Analytics: uses 6 CIDashboard visualisations:<ul>
	<li>Quick Overview</li><li>Social Network</li><li>People and Issue Ring</li><li>Activity Analytics</li><li>User Activity Analytics; 6. Contribution Stream.</li>
	</ul>
</li>
</ol>
</p>

<h2>0.7 Alpha - <span style="font-size:10pt;">7th July 2015</span></h2>
<p>We extended the datamodel to allow Open Comments to be used in maps and we also added a new Argument node type. This will allow multiple connection from an Argument as both supporting and counter an Idea. It also in preparation for the CIF import currently under development.</p>

<h2>0.8 Alpha - <span style="font-size:10pt;">22nd July 2015</span></h2>
<p>
<ol>
<li>New CIF Import feature. Available from the user home page. There is a preview interface in which you can select which nodes to import and also, if importing connections into a new map, adjust the map layout before importation.</li>
<li>Fixed Map Edit bar paging system to deal with large page numbers. It now scrolls the page number list. In the future this should be cleverer.</li>
</ol>
</p>

<h2>0.9 Alpha - <span style="font-size:10pt;">19th October 2015</span></h2>
<p>
<ol>
<li>CIDashboard embedded visualisations now pulled in the correct language to match the chosen language in LiteMap.</li>
<li>Various small bug fixes.</li>
</ol>
</p>

<h2>1.0 - <span style="font-size:10pt;">19th November 2015</span></h2>
<p>
<ol>
<li>Images can be added to Comment nodes that display in the main node. You can right-click to view a large version of the image.</li>
<li>Button to turm link labels on and off has been added to maps.</li>
<li>Link label on/off and node label rolloverhint on/off user choices have been persisted with cookies.</li>
<li>User map lists show as Map boxes, not text list.</li>
<li>User list added to the Admin area.</li>
<li>Bug fixes.</li>
</ol>
</p>

</p>
</div>

<?php
include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>