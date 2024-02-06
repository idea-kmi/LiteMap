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

class format_rss extends format_base {

    //default to plain text
    function get_header(){
        return "Content-Type: text/xml";
    }

    function allowed_methods(){
       return array('getnodesbydate',
                    'getnodesbyfirstcharacters',
                    'getnodesbygroup',
                    'getnodesbyname',
                    'getnodesbynode',
                    'getnodesbyurl',
                    'getnodesbyuser',
                    'getconnectionsbyuser',
                    'getconnectionsbygroup',
                    'getconnectionsbynode',
                    'getconnectionsbypath',
                    'getconnectionsbyurl',
                    'getconnectednodesbyglobal',
                    'getconnectednodesbyuser',
                    'getnodesbyglobal');
    }

    /**
     * Format the nodeset output to an <ul> list
     * This is just for the scriptaculous autocompleter field
     *
     * @param Object $object - the data to format
     * @return string
     */
    function format($object){
        global $CFG;
        $doc = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $doc .= "<rss version=\"2.0\"
                    xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
                    xmlns:dc=\"http://purl.org/dc/elements/1.1/\">";
        $doc .= "<channel>";

        $doc .= "<title>".$CFG->SITE_TITLE."</title>";
        $doc .= "<link>".$CFG->homeAddress."</link>";
        $doc .= "<description></description>";
        $doc .= "<pubDate>".date('r')."</pubDate>";
        $doc .= "<language>en</language>";

        if($object instanceof NodeSet){
            $nodes = $object->nodes;
            foreach ($nodes as $node){
            	$role = $node->role;
   		      	$url = $CFG->homeAddress."explore.php?nodeid=".$node->nodeid;
                $doc .="<item>";
               	$doc .="<title>".parseToXML($node->name)."</title>";
                $doc .="<link>".$url."</link>";
                $doc .= "<pubDate>".date('r',$node->creationdate)."</pubDate>";
                $user = $node->users[0];
                $doc .= "<dc:creator>".$user->name."</dc:creator>";
                $doc .= "<description><![CDATA[".$node->description."]]></description>";
                $doc .= "<content:encoded><![CDATA[".$node->description."]]></content:encoded>";
                $doc .= "<guid isPermaLink='true'>".$url."</guid>";
                $doc .="</item>";
            }
        } else if ($object instanceof ConnectionSet){
            $conns = $object->connections;

            foreach ($conns as $conn){
                $doc .="<item>";
                $doc .="<title>".parseToXML($conn->from->name)." -> ".parseToXML($conn->to->name)."</title>";
                $doc .="<link>".$CFG->homeAddress."node.php?nodeid=".$conn->from->nodeid."#conn-neighbour</link>";
                $doc .= "<pubDate>".date('r',$conn->creationdate)."</pubDate>";
                $user = $conn->from->users[0];
                $doc .= "<dc:creator>".$user->name."</dc:creator>";
                $fNode = $conn->from;
                $tNode = $conn->to;

                $desc = "<a href='".$CFG->homeAddress."node.php?nodeid=".$conn->from->nodeid."#conn-neighbour'>".$fNode->name."</a>";

                $desc .= " -[".$conn->linktype->label."]-> ";

                $desc .= "<a href='".$CFG->homeAddress."node.php?nodeid=".$conn->to->nodeid."#conn-neighbour'>".$tNode->name."</a>";

                $doc .= "<description><![CDATA[".$desc."]]></description>";
                $doc .= "<content:encoded><![CDATA[".$desc."]]></content:encoded>";
                $doc .= "<guid isPermaLink='true'>".$CFG->homeAddress."node.php?nodeid=".$conn->from->nodeid."#conn-neighbour</guid>";
                $doc .="</item>";
            }
        }

        $doc .= "</channel></rss>";
        return $doc;
    }



}
?>
