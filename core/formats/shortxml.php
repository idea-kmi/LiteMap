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

class format_shortxml extends format_base {

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
                    'getconnectionsbynode',
                    'getconnectionsbypath',
                    'getconnectionsbyurl',
                    'getmostconnectednodes');
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


        if($object instanceof NodeSet){
            $doc .="<nodeset>";
            $doc .="<totalno>".$object->totalno."</totalno>";
            $doc .="<start>".$object->start."</start>";
            $doc .="<count>".$object->count."</count>";
            $doc .="<nodes>";
            $nodes = $object->nodes;
            foreach ($nodes as $node){
                $doc .="<cnode>";
                $doc .= "<nodeid>".$node->nodeid."</nodeid>";
                $doc .="</cnode>";
            }
            $doc .="</nodes></nodeset>";
        } else if ($object instanceof ConnectionSet){
            $conns = $object->connections;

            $doc .="<connectionset>";
            $doc .="<totalno>".$object->totalno."</totalno>";
            $doc .="<start>".$object->start."</start>";
            $doc .="<count>".$object->count."</count>";
            $doc .="<connections>";
            $conns = $object->connections;
            foreach ($conns as $conn){
                $doc .="<connection>";
                $doc .= "<connid>".$conn->connid."</connid>";
                $doc .="</connection>";
            }
            $doc .="</connections></connectionset>";
        }

        return $doc;
    }



}
?>
