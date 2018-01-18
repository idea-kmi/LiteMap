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

include_once("cipher.php");

class format_jsonld extends format_base {

	public $historytypes = array (
		'add' => 'Create',
		'edit' => 'Update',
		'delete' => 'Delete',
		'view' => 'ReadStatusChange',
	);

	public $nodetypes = array (
		'Challenge' => 'Issue',
		'Issue' => 'Issue',
		'Solution' => 'Position',
		'Pro' => 'Argument',
		'Con' => 'Argument',
		'Argument' => 'Argument',
		'Idea' => 'GenericIdeaNode',
		'Web Resource' => 'Reference',
		'Publication' => 'Reference',
		'Decision' => 'Decision',
		'Map' => 'Map',
	);

	public $linktypes = array (
		'IssueChallenge' => 'InclusionRelation',
		'SolutionIssue' => 'PositionRespondsToIssue',
		'ProSolution' => 'ArgumentSupportsIdea',
		'ProPro' => 'ArgumentSupportsIdea',
		'ProCon' => 'ArgumentSupportsIdea',
		'ConSolution' => 'ArgumentOpposesIdea',
		'ConPro' => 'ArgumentOpposesIdea',
		'ConCon' => 'ArgumentOpposesIdea',
		'IssueIssue' => 'InclusionRelation',
		'SolutionSolution' => 'DirectedIdeaRelation',
		'IssueSolution' => 'IssueAppliesTo',
		'IdeaIdea' => 'DirectedIdeaRelation',
	);

	public $linkends = array (
		'IssueQuestions' => array(
			'from' => 'applicable_issue',
			'to' => 'target_idea'
		),
		'PositionRespondsToIssue' => array(
			'from' => 'response_position',
			'to' => 'response_issue'
		),
		'ArgumentOpposesIdea' => array(
			'from' => 'argument_arguing',
			'to' => 'target_idea'
		),
		'ArgumentSupportsIdea' => array(
			'from' => 'argument_arguing',
			'to' =>'target_idea'
		),
		'DirectedIdeaRelation' => array(
			'from' => 'source_idea',
			'to' => 'target_idea'
		),
		'InclusionRelation' => array(
			'from' => 'source_idea',
			'to' => 'target_idea'
		),
		'IssueAppliesTo' => array(
			'from' => 'applicable_issue',
			'to' => 'target_idea'
		),
	);

	public $mainStr = "";
	public $conversationBlockStr = "";
	public $outerGraphStr = "";
	public $dataGraphStr = "";
	public $historyGraphStr = "";
	public $annotationGraphListStr = "";
	public $namespaces = "";

	public $subtype = "";
	public $site = "main_site";
	public $serviceurl = "";
 	public $currentlang = "";

	private $cipher = "";

	private $checkUsers = array();
	private $checkNodes = array();
	private $checkConns = array();

    //default to plain text
    function get_header(){
        return "Content-Type: application/ld+json; charset=utf-8";
    }

    /**
     * Format the output to JSON-LD Specifically formatted to the CATALYST INTERCHANGE FORMAT
     *
     * @param Object $object - the data to format
     * @return string
     */
    function format($object) {
        global $CFG,$HUB_FLM;

		if (isset($CFG->language) && $CFG->language != "") {
			$currentlang = $CFG->language;
		} else {
			$currentlang = 'en';
		}

		$this->serviceurl = $CFG->homeAddress.'api/';
        $api_class = get_class($object);

		// If the passed object has a cipher use it, else create a new one.
        if (isset($object->cipher)) {
			$this->cipher = $object->cipher;
		} else {
			$salt = openssl_random_pseudo_bytes(32);
			$this->cipher = new Cipher($salt);
		}

        $this->mainStr = '{';
        $this->mainStr .= '"@context":[';
        $this->mainStr .= '"http://purl.org/catalyst/jsonld",';

 		$this->namespaces .= '{';
      	$this->namespaces .= '"'.$this->site.'": "'.$this->serviceurl.'",';

		$this->outerGraphStr .= '"@graph": [';

        switch ($api_class) {
            case "UnobfuscatedUserSet":
                $users = $object->users;
                if (isset($object->cipher)) {
					foreach ($users as $user){
						if (in_array($user->userid,$this->checkUsers) === FALSE) {
							$this->addFullUserProfile($user);
							array_push($this->checkUsers, $user->userid);
						}
					}
				}
                break;
        	case "GroupSet": // a set of conversations ?
        		$this->addGroups($object);
                break;

        	case "Group": // a conversation
        		$this->addGroup($object);
                break;

        	case "View": // one issue tree
                $this->addView($object);
                break;

        	case "ViewSet": // one issue tree
                $this->addViews($object);
                break;

            case "ConnectionSet":
                $this->addConnections($object);
                break;

        	case "NodeSet":
				$this->conversationBlockStr .= '{';
				$this->conversationBlockStr .= '"@type":["catalyst:Conversation","Graph"],';
				$this->conversationBlockStr .= '"@id": "'.$this->site.':nodes"';
				$this->conversationBlockStr .= '},';
                $this->addNodes($object);
                break;

            case "CNode":
				$this->conversationBlockStr .= '{';
				$this->conversationBlockStr .= '"@type": "catalyst:Conversation",';
				$this->conversationBlockStr .= '"@id": "'.$this->site.':nodes/'.$id.'",';
				$this->conversationBlockStr .= '"data_graph": "'.$this->site.':nodes"';
				$this->conversationBlockStr .= '},';
                $this->addNode($object);
                break;

           /*
           case "URL":
				$this->conversationBlockStr .= '"data_graph": "'.$this->site.':urls",';
                $this->addURL($object);
                $this->addURL($object);
                break;

           case "URLSet":
				$this->conversationBlockStr .= '"data_graph": "'.$this->site.':urls",';
                $nodeUrls = $object->urls;
                $this->addURLs($nodeUrls);
                break;
           */
            /*

            case "Connection":
                $this->addConnection($object);
                break;

            case "User":
            	//$this->conversationBlockStr .= '"pseudonyms_graph": "'.$this->site.':pseudonyms",';
                $this->addUser($object);
                break;

            case "UserSet":
            	//$this->conversationBlockStr .= '"pseudonyms_graph": "'.$this->site.':pseudonyms",';
                $users = $object->users;
                foreach ($users as $user){
                	if (in_array($user->userid,$this->checkUsers) === FALSE) {
                	    $this->addUser($user);
                	    array_push($this->checkUsers, $user->userid);
                	}
                }
                break;
           */

           case "error":
                $doc .= "<error><message>".$object->message."</message><code>".$object->code."</code></error>";
                return $doc;
                break;

           default:
                //error as method not defined.
				global $ERROR;
				$ERROR = new error;
				$ERROR->createInvalidMethodError();
				include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
                die;
        }

		$this->namespaces = $this->trimFinalComma($this->namespaces);
 		$this->namespaces .= '}';
		$this->mainStr .= $this->namespaces;
		$this->mainStr .= '],';

		if ($this->conversationBlockStr != "") {
			$this->outerGraphStr .= $this->conversationBlockStr;
		}

		// ADD ANNOTAION OUTER GRAPHS
		if ($this->annotationGraphListStr != "") {
			$this->outerGraphStr .= $this->annotationGraphListStr;
		}

		// ADD DATA GRAPH
		if ($this->dataGraphStr != "") {
			$this->outerGraphStr .= $this->dataGraphStr;
		}

		// ADD HISTORY GRAPH
		if ($this->historyGraphStr != "") {
			$this->outerGraphStr .= $this->historyGraphStr;
		}

		$this->outerGraphStr = $this->trimFinalComma($this->outerGraphStr);

		$this->outerGraphStr .= ']';
		$this->mainStr .= $this->outerGraphStr;
        $this->mainStr .= '}';

		if (isset($object->unobfuscationid) && $object->unobfuscationid != ""
					&& $api_class != "UnobfuscatedUserSet") {
			$count = count($this->checkUsers);
			$users = "";
			for ($i=0; $i<$count;$i++) {
				$userid = $this->checkUsers[$i];
				if ($userid != "") {
					$users .= $userid.",";
				}
			}
			$users = trimFinalComma($users);
			setObfuscationUsers($object->unobfuscationid, $users);
		}

        return $this->mainStr;
    }

	function addGroups($groupset) {
		$groups = $groupset->groups;
		$count = count($groups);
		for ($i=0; $i<$count; $i++) {
			$this->addGroup($groups[$i]);
		}
	}

	function addGroup($group) {
		global $CFG;

		//error_log(print_r($group, true));

		$id = $group->groupid;
   		$groupid = $this->site.':conversations/'.$id;
		$groupname = 'conversation_'.$id;

		if (isset($group->filter) && $group->filter != "") {
			$groupid .= $group->filter.'/';
		}

      	$this->namespaces .= '"'.$groupname.'": "'.$this->serviceurl.'conversations/'.$id.'/",';

		$this->siteBlockStr .= '"space_of": "'.$groupid.'",';

		$this->conversationBlockStr .= '{';
		$this->conversationBlockStr .= '"@type": "catalyst:Conversation",';
		$this->conversationBlockStr .= '"@id": "'.$groupid.'",';
   		$this->conversationBlockStr .= '"data_graph": "'.$groupid.'"';
		$this->conversationBlockStr .= '},';

		$this->dataGraphStr .= "{";
		$this->dataGraphStr .= '"@graph": [';

		$this->checkUsers = array();

		$view = $group->view;

		if (isset($view->filter)) {
			$this->subtype = $view->filter;
			switch($this->subtype) {
 			   	case "nodes":
					//add just nodes
					$nodes = $view->nodes;
					$count = count($nodes);
					for ($i=0; $i<$count; $i++) {
						$viewnode = $nodes[$i];
						$node = $viewnode->node;
						$this->addNode($node);
					}
					break;

 			   	case "users":
					//add nodes
					$nodes = $view->nodes;
					$count = count($nodes);
					for ($i=0; $i<$count; $i++) {
						$viewnode = $nodes[$i];
						$node = $viewnode->node;
						$user = $node->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE ) {
							$this->addUser($user);
	                	    array_push($this->checkUsers, $user->userid);
						}
					}

					//add connection users
					$conns = $view->connections;
					$count = count($conns);
					for ($i=0; $i<$count; $i++) {
						$viewconnection = $conns[$i];
						$connection = $viewconnection->connection;
						$user = $connection->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE) {
							$this->addUser($user);
	                	    array_push($this->checkUsers, $user->userid);
						}
					}
					break;

 			   	case "comments": //"messages"
 			   		//$view = getView($id);
					break;

 			   	case "votes":
 			   		//$view = getView($id);
					break;

 			   	case "history":
 			   		//$view = getView($id);
					//add node activities
					$nodes = $view->nodes;
					$justnodes = array();
					$count = count($nodes);
					for ($i=0; $i<$count; $i++) {
						$viewnode = $nodes[$i];
						$node = $viewnode->node;
						array_push($justnodes, $node);
						$this->addNode($node);
						$user = $node->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE ) {
							$this->addUser($user);
	                	    array_push($this->checkUsers, $user->userid);
						}
					}
					$this->addNodeHistory($justnodes, $groupid, $groupname);
					break;
				}
		} else {
			// Add everything
			//add nodes
			$nodes = $view->nodes;
			if ($nodes) {
				$justnodes = array();
				$count = count($nodes);
				for ($i=0; $i<$count; $i++) {
					$viewnode = $nodes[$i];
					$node = $viewnode->node;
					if (!$node instanceof Error) {
						array_push($justnodes, $node);
						$this->addNode($node);

						$user = $node->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE) {
							$this->addUser($user);
							array_push($this->checkUsers, $user->userid);
						}
					}
				}

				$this->addNodeHistory($justnodes, $groupid, $groupname);

				//add connections
				$conns = $view->connections;
				$count = count($conns);
				for ($i=0; $i<$count; $i++) {
					$viewconnection = $conns[$i];
					$connection = $viewconnection->connection;
					if (!$connection instanceof Error) {
						$this->addConnection($connection);
						$user = $connection->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE) {
							$this->addUser($user);
							array_push($this->checkUsers, $user->userid);
						}
					}
				}
			}
		}

		// trim last comma
		$this->dataGraphStr = $this->trimFinalComma($this->dataGraphStr);
		$this->dataGraphStr .= '],';

		$this->dataGraphStr .= '"@id": "'.$groupid.'"';
		$this->dataGraphStr .= "},";
	}

	function addViews($viewset) {
		$views = $viewset->views;
		$count = count($views);
		for ($i=0; $i<$count; $i++) {
			$this->addView($views[$i]);
		}
	}

	function addView($view) {
		global $CFG;

		//error_log(print_r($viewset));

		$id = $view->nodeid;
   		$viewid = $this->site.':views/'.$id;
		$viewname = 'view_'.$id;

		if (isset($view->filter) && $view->filter != "") {
			$viewid .= $view->filter.'/';
		}

      	$this->namespaces .= '"'.$viewname.'": "'.$this->serviceurl.'views/'.$id.'/",';

		$this->siteBlockStr .= '"space_of": "'.$viewid.'",';

		$this->conversationBlockStr .= '{';
		$this->conversationBlockStr .= '"@type": "catalyst:Conversation",';
		$this->conversationBlockStr .= '"@id": "'.$viewid.'",';
   		$this->conversationBlockStr .= '"data_graph": "'.$viewid.'"';
		$this->conversationBlockStr .= '},';

		/*
                {
                    "@id": "local:IdeaGraphView/2",
                    "@type": "Map",
                    "created": "2013-12-26T18:49:26",
                    "has_container": "local:Discussion/1",
                    "in_conversation": "local:Discussion/1"
                },
		*/

		$viewnode = $view->viewnode;
		if (!isset($viewnode) || $viewnode instanceof Error) {
			return "";
		}

		$this->dataGraphStr .= "{";
		$this->dataGraphStr .= '"@graph": [';

		$this->checkUsers = array();

		if (isset($view->filter)) {
			$this->subtype = $view->filter;
			switch($this->subtype) {
 			   	case "nodes":
					//add just nodes
					$nodes = $view->nodes;
					$count = count($nodes);
					for ($i=0; $i<$count; $i++) {
						$viewnode = $nodes[$i];
						$node = $viewnode->node;
						$this->addNode($node);
					}
					break;

 			   	case "users":
					//add nodes
					$nodes = $view->nodes;
					$count = count($nodes);
					for ($i=0; $i<$count; $i++) {
						$viewnode = $nodes[$i];
						$node = $viewnode->node;
						$user = $node->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE ) {
							$this->addUser($user);
	                	    array_push($this->checkUsers, $user->userid);
						}
					}

					//add connection users
					$conns = $view->connections;
					$count = count($conns);
					for ($i=0; $i<$count; $i++) {
						$viewconnection = $conns[$i];
						$connection = $viewconnection->connection;
						$user = $connection->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE) {
							$this->addUser($user);
	                	    array_push($this->checkUsers, $user->userid);
						}
					}
					break;

 			   	case "comments": //"messages"
 			   		//$view = getView($id);
					break;

 			   	case "votes":
 			   		//$view = getView($id);
					break;

 			   	case "history":
 			   		//$view = getView($id);
					//add node activities
					$nodes = $view->nodes;
					$justnodes = array();
					$count = count($nodes);
					for ($i=0; $i<$count; $i++) {
						$viewnode = $nodes[$i];
						$node = $viewnode->node;
						array_push($justnodes, $node);
						$this->addNode($node);
						$user = $node->users[0];
						if (in_array($user->userid, $this->checkUsers) === FALSE ) {
							$this->addUser($user);
	                	    array_push($this->checkUsers, $user->userid);
						}
					}
					$this->addNodeHistory($justnodes, $viewid, $viewname);
					break;
				}
		} else {
			// Add everything
			$justnodes = array();

			// Add Map node
			$viewnode = $view->viewnode;
			if (!isset($viewnode) || $viewnode instanceof Error) {
				$viewnode = new CNode($view->nodeid);
			}
			if (!$viewnode instanceof Error) {
				array_push($justnodes, $viewnode);
				$this->addNode($viewnode);
				$user = $viewnode->users[0];
				if (in_array($user->userid, $this->checkUsers) === FALSE) {
					$this->addUser($user);
					array_push($this->checkUsers, $user->userid);
				}
			}

			//add nodes
			$nodes = $view->nodes;
			$count = count($nodes);
			for ($i=0; $i<$count; $i++) {
				$viewnode = $nodes[$i];
				$node = $viewnode->node;
				array_push($justnodes, $node);
				$this->addNode($node);

				$user = $node->users[0];
				if (in_array($user->userid, $this->checkUsers) === FALSE) {
					$this->addUser($user);
               	    array_push($this->checkUsers, $user->userid);
				}
			}

			$this->addNodeHistory($justnodes, $viewid, $viewname);

			//add connections
			$conns = $view->connections;
			$count = count($conns);
			for ($i=0; $i<$count; $i++) {
				$viewconnection = $conns[$i];
				$connection = $viewconnection->connection;
				$this->addConnection($connection);
				$user = $connection->users[0];
				if (in_array($user->userid, $this->checkUsers) === FALSE) {
					$this->addUser($user);
               	    array_push($this->checkUsers, $user->userid);
				}
			}
		}

		// trim last comma
		$this->dataGraphStr = $this->trimFinalComma($this->dataGraphStr);
		$this->dataGraphStr .= '],';

		$this->dataGraphStr .= '"@id": "'.$viewid.'"';
		$this->dataGraphStr .= "},";
	}

	function addNodes($nodeset) {
		$nodes = $nodeset->nodes;
		$viewid = $nodeset->viewid;
		foreach($nodes as $node){
			$this->addNode($node);
		}
	}

	function addNode($node) {
		global $CFG;

		if (!isset($node) || $node instanceof Error) {
			return "";
		}

		if (in_array($node->nodeid,$this->checkNodes) === FALSE) {
			array_push($this->checkNodes, $node->nodeid);

			//$title = demicrosoftize($node->name);
			$title = character_convert_to($node->name, 'UTF-8');
			$desc = "";
			if (isset($node->description)) {
				//$desc = demicrosoftize($node->description);
				$desc = character_convert_to($node->description, 'UTF-8');
			}
			$moddate = $this->timestampToISO($node->modificationdate);
			$createdate = $this->timestampToISO($node->creationdate);
			$nodetype = $node->role->name;

			$type = "";
			if (isset($this->nodetypes[$nodetype])) {
				$type = $this->nodetypes[$nodetype];
			} else {
				return "";
			}

			$pseudo_id = $this->getPseudonym($node->users[0]->userid);
			if (in_array($node->users[0]->userid, $this->checkUsers) === FALSE) {
				$this->addUser($node->users[0]);
				array_push($this->checkUsers, $node->users[0]->userid);
			}

			$this->dataGraphStr .= '{';

			$this->dataGraphStr .= '"@type": "'.$type.'",';
			$this->dataGraphStr .= '"@id": "'.$this->site.':nodes/'.$node->nodeid.'",';
			$this->dataGraphStr .= '"created": "'.$createdate.'",';
			$this->dataGraphStr .= '"modified": "'.$moddate.'",';
			if ($nodetype == 'Map') {
				$this->dataGraphStr .= '"homepage": "'.$CFG->homeAddress.'map.php?id='.$node->nodeid.'",';
			} else {
				$this->dataGraphStr .= '"homepage": "'.$CFG->homeAddress.'explore.php?id='.$node->nodeid.'",';
			}
			$this->dataGraphStr .= '"has_creator": "'.$this->site.':users/'.$pseudo_id.'",';
			$this->dataGraphStr .= '"title": {';
			$this->dataGraphStr .= '	"@language": "eng",';
			$this->dataGraphStr .= '	"@value": "'.parseToJSON($title).'"';
			$this->dataGraphStr .= '},';

			if (isset($desc) && $desc != "") {
				$this->dataGraphStr .= '"description": {';
				$this->dataGraphStr .= '	"@language": "eng",';
				$this->dataGraphStr .= '	"@value": "'.parseToJSON($desc).'"';
				$this->dataGraphStr .= '},';
			}

			$this->dataGraphStr = $this->trimFinalComma($this->dataGraphStr);

			$this->dataGraphStr .= '},';

			// add any URLS
			if ( isset($node->urls) && count($node->urls) > 0) {
				$this->addURLs($node->urls, $node->nodeid);
			}

			// Add any votes
			$this->addNodeVotes($node->nodeid);

			// Add any comment trees
			$this->addComments($node);
		}
	}

	function addComments($node) {
		$connset = getAllChatConnections($node->nodeid, $node->role->name);
		$conns = $connset->connections;
		$count = count($conns);
		for ($i=0; $i<$count; $i++) {
			$conn = $conns[$i];
			$this->addComment($conn);
		}
	}

	function addComment($conn) {
		$fromNodeObj = $conn->from;
		$toNodeObj = $conn->to;

		$fromTypeObj = $conn->fromrole;
		$toTypeObj = $conn->torole;
		if (!$fromTypeObj instanceof Error && !$toTypeObj instanceof Error) {
			$fromType = $fromTypeObj->name;
			$toType = $toTypeObj->name;

			$createdate = $this->timestampToISO($fromNodeObj->creationdate);
			$title = character_convert_to($fromNodeObj->name, 'UTF-8');
			$desc = "";
			if (isset($fromNodeObj->description)) {
				$desc = character_convert_to($fromNodeObj->description, 'UTF-8');
			}

			$pseudo_id = $this->getPseudonym($fromNodeObj->users[0]->userid);
			if (in_array( $fromNodeObj->users[0]->userid, $this->checkUsers) === FALSE) {
				$this->addUser($fromNodeObj->users[0]);
				array_push($this->checkUsers, $fromNodeObj->users[0]->userid);
			}

			$this->dataGraphStr .= '{';
			$this->dataGraphStr .= '"@type": "SPost",';
			if ($fromType == 'Comment' && $toType != 'Comment') {
				$this->dataGraphStr .= '"postLinkedToIdea":"'.$this->site.':nodes/'.$toNodeObj->nodeid.'",';
			} else {
				$this->dataGraphStr .= '"reply_of":"'.$this->site.':nodes/'.$toNodeObj->nodeid.'",';
			}
			$this->dataGraphStr .= '"@id": "'.$this->site.':nodes/'.$fromNodeObj->nodeid.'",';
			$this->dataGraphStr .= '"created": "'.$createdate.'",';
			$this->dataGraphStr .= '"has_creator": "'.$this->site.':users/'.$pseudo_id.'",';
			$this->dataGraphStr .= '"title": {';
			$this->dataGraphStr .= '	"@language": "eng",';
			$this->dataGraphStr .= '	"@value": "'.parseToJSON($title).'"';
			$this->dataGraphStr .= '},';

			if (isset($desc) && $desc != "") {
				$this->dataGraphStr .= '"content": {';
				$this->dataGraphStr .= '	"@language": "eng",';
				$this->dataGraphStr .= '	"@value": "'.parseToJSON($desc).'"';
				$this->dataGraphStr .= '},';
			}

			$this->dataGraphStr = $this->trimFinalComma($this->dataGraphStr);
			$this->dataGraphStr .= '},';
		}
	}

	function addNodeHistory($nodes, $viewid, $viewname) {
		global $CFG;

		$this->dataGraphStr .= '{';
		$this->dataGraphStr .= '"history_graph": "'.$viewname.':history",';
        $this->dataGraphStr .= '"@id": "'.$viewid.'"';
        $this->dataGraphStr .= '},';

		$this->historyGraphStr  .= "{";
		$this->historyGraphStr  .= '"@graph": [';

		$count = count($nodes);
		for ($i=0; $i<$count; $i++) {
			$node = $nodes[$i];
			if (!$node instanceof Error) {
				$as = getAllNodeActivity($node->nodeid, 0, 0, -1, 'cif');
				$activities = $as->activities;
				foreach($activities as $activity) {
					$this->addNodeHistoryItem($activity);
				}
			}
		}

		// trim last comma
		$this->historyGraphStr = $this->trimFinalComma($this->historyGraphStr);
		$this->historyGraphStr  .= '],';
		$this->historyGraphStr .= '"@id": "'.$viewname.':history"';
		$this->historyGraphStr .= "},";
	}

	function addNodeHistoryItem($activity) {
		global $USER, $CFG;

		$type = $activity->type; // == 'Vote', 'Node', 'Connection', 'Follow', 'View'
		$modificationDate = $activity->modificationdate;
		$moddate = $this->timestampToISO($modificationDate);
		$changetype = $activity->changetype; // == 'add','delete','edit'
		$userObj = $activity->user;

		switch($type) {
			case "Node":
				//$node = $activity->node;
				//if ($node instanceof CNode) {

					$pseudo_id = $this->getPseudonym($userObj->userid);
					if (in_array($userObj->userid, $this->checkUsers) === FALSE) {
						$this->addUser($userObj);
						array_push($this->checkUsers, $userObj->userid);
					}

					$this->historyGraphStr .= '{';
					$this->historyGraphStr .= '"who": "'.$this->site.':users/'.$pseudo_id.'",';
					$this->historyGraphStr .= '"what": "'.$this->site.':nodes/'.$activity->itemid.'",';
					$this->historyGraphStr .= '"when": "'.$moddate.'",';
					$this->historyGraphStr .= '"@type": "'.$this->historytypes[$changetype].'"';
					$this->historyGraphStr .= '},';
				//}
				break;
			case "Connection":
				//$con = getConnectionFromAuditXML($activity->xml);
				break;

			case "Vote":
				//$activity->xml == 'Y'/'N'
				/*
				$pseudo_id = $this->getPseudonym($userObj->userid);
				if (in_array($userObj->userid, $this->checkUsers) === FALSE) {
					$this->addUser($userObj);
					array_push($this->checkUsers, $userObj->userid);
				}

				$this->historyGraphStr .= '{';
				$this->historyGraphStr .= '"who": "'.$this->site.':users/'.$pseudo_id.'",';
				$this->historyGraphStr .= '"what": "'.$this->site.':votes/'.$id.'_'.$pseudo_id.'",';
				$this->historyGraphStr .= '"when": "'.$moddate.'",';
				$this->historyGraphStr .= '"@type": "'.$this->historytypes[$changetype].'"';
				if ($changetype == 'add' || $changetype == 'edit') {
					$this->historyGraphStr .= '"snapshot": {';
					if ($activity->xml == "Y") {
						$this->historyGraphStr .= '"content ": "true"';;
					} else {
						$this->historyGraphStr .= '"content ": "false"';;
					}
					$this->historyGraphStr .= '}';
				}
				$this->historyGraphStr .= '},';
				*/

				break;

			case "View":
				//$node = getNode($activity->itemid);
				//if ($node instanceof CNode) {
					$pseudo_id = "anonymous";
					if (!$userObj instanceof Error && $userObj->userid != NULL) {
						if (in_array($userObj->userid, $this->checkUsers) === FALSE) {
							$this->addUser($userObj);
							array_push($this->checkUsers, $userObj->userid);
						}
						$pseudo_id = $this->getPseudonym($userObj->userid);
					} else {
						if (in_array($pseudo_id, $this->checkUsers) === FALSE) {
							$this->addUser(new User($pseudo_id));
							array_push($this->checkUsers, $pseudo_id);
						}
					}

					$this->historyGraphStr .= '{';
					$this->historyGraphStr .= '"who": "'.$this->site.':users/'.$pseudo_id.'",';
					$this->historyGraphStr .= '"what": "'.$this->site.':nodes/'.$activity->itemid.'",';
					$this->historyGraphStr .= '"when": "'.$moddate.'",';
					$this->historyGraphStr .= '"@type": "'.$this->historytypes['view'].'"';
					$this->historyGraphStr .= '},';
				//}
				break;
		}

		/*
		$str .= '{';

		$pseudo_id = $this->getPseudonym($node->users[0]->userid);

		$str .= '"who": "'.$this->site.':users/'.$pseudo_id.'",';
		$str .= '"what": "'.$CFG->homeAddress.'api/",';
		$str .= '"when": "'.$moddate.'",';
		$str .= '"@type": "'..'",';

		//$str .= '"@id": "",'; - if each aaudit entry had it's own id
		//$str .= '"revision": "'???'",';

		//$str .= '"snapshot": {';
		//$str .= '	"created": "'.$createdate.'",';
		//$str .= '	"title": {';
		//$str .= '		"@language": "eng",';
		//$str .= '		"@value": "'.parseToJSON($title).'"';
		//$str .= '	}';
		//$str .= '	"has_creator": "'.$CFG->homeAddress.'api/users/'.$pseudo_id.'",';
		//$str .= '	"has_container": "???",';
		//$str .= '	"version": "???",';
		//$str .= '}';

		$str .= '},';
		*/

		/*eg_d1:event1
			a version:Create;
			version:what eg_d1:message_1;
			version:who eg_d1:pseudo_262d2e2ecb6696c0bfdc482ac6273b5b88c56ed2;
			version:revision "0"^^xsd:integer;
			version:when "2013-11-01T09:00:04"^^xsd:dateTimeStamp;
			version:snapshot [
				a sioc:Post, version:ObjectSnapshot ;
				dcterms:created "2013-11-01T09:00:04"^^xsd:dateTimeStamp;
				dcterms:title "Climate change is a problem"@eng;
				sioc:content """Let's do something draft placeholder"""@eng;
				sioc:has_creator eg_d1:pseudo_262d2e2ecb6696c0bfdc482ac6273b5b88c56ed2;
				sioc:has_container eg_d1:forum;
				version:snapshot_of eg_d1:message_1
			].
		*/
	}

	function addConnections($conset) {
		$str = "";

		if (!isset($conset) || $conset instanceof Error) {
			return "";
		}

   		$conversationid = $this->site.':connections/';
		$conversationname = 'connections_all';

      	$this->namespaces .= '"'.$conversationname.'": "'.$this->serviceurl.'connections/",';

		$this->siteBlockStr .= '"space_of": "'.$conversationid.'",';

		$this->conversationBlockStr .= '{';
		$this->conversationBlockStr .= '"@type": "catalyst:Conversation",';
		$this->conversationBlockStr .= '"@id": "'.$conversationid.'",';
   		$this->conversationBlockStr .= '"data_graph": "'.$conversationid.'"';
		$this->conversationBlockStr .= '},';

		$this->dataGraphStr .= "{";
		$this->dataGraphStr .= '"@graph": [';

		$justnodes = array();

		$connections = $conset->connections;
		foreach ($connections as $conn) {
			$fromNodeObj = $conn->from;
			$toNodeObj = $conn->to;

			if (in_array($fromNodeObj->nodeid,$this->checkNodes) === FALSE) {
				array_push($justnodes, $fromNodeObj);
			}
			if (in_array($toNodeObj->nodeid,$this->checkNodes) === FALSE) {
				array_push($justnodes, $toNodeObj);
			}
			$fromNode = $this->addNode($fromNodeObj);
			$toNode = $this->addNode($toNodeObj);

			$this->addConnection($conn, $fromNode, $toNode);
		}

		$this->addNodeHistory($justnodes, $conversationid, $conversationname);

		// trim last comma
		$this->dataGraphStr = $this->trimFinalComma($this->dataGraphStr);
		$this->dataGraphStr .= '],';

		$this->dataGraphStr .= '"@id": "'.$conversationid.'"';
		$this->dataGraphStr .= "},";
	}

	function addConnection($conn) {
		global $CFG;

		if (!isset($conn) || $conn instanceof Error) {
			return "";
		}

		if (in_array($conn->connid,$this->checkConns) === FALSE) {
			array_push($this->checkConns, $conn->connid);

			$fromTypeObj = $conn->fromrole;
			$toTypeObj = $conn->torole;
			if (!$fromTypeObj instanceof Error && !$toTypeObj instanceof Error) {
				$fromType = $fromTypeObj->name;
				$toType = $toTypeObj->name;

				if ($fromType == 'Comment') {
					$this->addComment($conn);
				} else {
					$moddate = $this->timestampToISO($conn->modificationdate);
					$createdate = $this->timestampToISO($conn->creationdate);
					$fromNodeObj = $conn->from;
					$toNodeObj = $conn->to;
					$type = "";
					if ($fromType == 'Argument') {
						$linktypename = $conn->linktype->label;
						//error_log($linktypename);
						if ($linktypename == 'supports') {
							$type = 'ArgumentSupportsIdea';
						} else {
							$type = 'ArgumentOpposesIdea';
						}
					} else if ($fromType == 'Idea') {
						$type = $this->linktypes['IdeaIdea'];
					} else if (array_key_exists($fromType.$toType, $this->linktypes)) {
						$type = $this->linktypes[$fromType.$toType];
					} else {
						error_log("RETURNING NO TYPE for:".$fromType.$toType);
						return "";
					}

					$fromend = "";
					$toend = "";

					if (array_key_exists($type, $this->linkends)) {
						$linkend = $this->linkends[$type];
						$fromend = $linkend['from'];
						$toend = $linkend['to'];
					} else {
						error_log("RETURNING NO LINK for: ".$type);
						return "";
					}

					$pseudo_id = $this->getPseudonym($conn->userid);
					if (in_array($conn->userid, $this->checkUsers) === FALSE) {
						$userObj = getUser($conn->userid);
						$this->addUser($userObj);
						array_push($this->checkUsers, $conn->userid);
					}


					$this->dataGraphStr .= '{';

					$this->dataGraphStr .= '"@type": "'.$type.'",';
					$this->dataGraphStr .= '"@id": "'.$this->site.':connections/'.$conn->connid.'",';
					$this->dataGraphStr .= '"created": "'.$createdate.'",';
					$this->dataGraphStr .= '"modified": "'.$moddate.'",';
					$this->dataGraphStr .= '"has_creator": "'.$this->site.':users/'.$pseudo_id.'",';
					$this->dataGraphStr .= '"'.$fromend.'": "'.$this->site.':nodes/'.$fromNodeObj->nodeid.'",';
					$this->dataGraphStr .= '"'.$toend.'": "'.$this->site.':nodes/'.$toNodeObj->nodeid.'",';
					$this->dataGraphStr .= '"reply_to": "'.$this->site.':nodes/'.$toNodeObj->nodeid.'"';

					$this->dataGraphStr .= '},';

					// Add any votes
					$this->addConnectionVotes($conn);
				}
			}
		}
	}

	function addURLs($urls, $nodeid) {
		$count = count($urls);
		for ($i=0; $i<$count;$i++) {
			$url = $urls[$i];
			$this->addURL($url, $nodeid);
		}
	}

	function addURL($url, $nodeid) {
		global $CFG, $USER;

		// Final check to see if this data is allowed to leave the site
		if ($url->private == 'Y' && $USER->userid != $url->userid) {
			return;
		}

		//separate graph
		$this->annotationGraphListStr .= '{';
		$this->annotationGraphListStr .= '"@graph": [';
		$this->annotationGraphListStr .= '{';
		$this->annotationGraphListStr .= '"expressesIdea": "'.$this->site.':nodes/'.$nodeid.'",'; // id of node
		if (isset($url->clip) && $url->clip != "") {
			$this->annotationGraphListStr .= '"@id": "'.$this->site.':urls/'.$url->urlid.'/resource'.'"';
		} else {
			$this->annotationGraphListStr .= '"@id": "'.parseToJSON($url->url).'"';
		}
		$this->annotationGraphListStr .= '}';
		$this->annotationGraphListStr .= '],';
		$this->annotationGraphListStr .= '"@id": "'.$this->site.':urls/'.$url->urlid.'/body"'; // **
		$this->annotationGraphListStr .= '},';

		// in the data graph

		// indicates there is a separate annotation graph?
		$this->dataGraphStr .= '{';
		$this->dataGraphStr .= '"@type": "Graph",';
		$this->dataGraphStr .= '"@id": "'.$this->site.':urls/'.$url->urlid.'/body'.'"'; // **
		$this->dataGraphStr .= '},';

		// ANNOTATION
		$this->dataGraphStr .= '{';
		$this->dataGraphStr .= '"@type": "Annotation",';
		$this->dataGraphStr .= '"@id": "'.$this->site.':urls/'.$url->urlid.'",';
		if (isset($url->clip) && $url->clip != "") {
			$this->dataGraphStr .= '"hasTarget": "'.$this->site.':urls/'.$url->urlid.'/resource",'; // *** if clip else actually url
		} else {
			$this->dataGraphStr .= '"hasTarget": "'.parseToJSON($url->url).'",'; //
		}
		$this->dataGraphStr .= '"hasBody": "'.$this->site.':urls/'.$url->urlid.'/body"'; // **
		$this->dataGraphStr .= '},';

		if (isset($url->clip) && $url->clip != "") {
			// CLIP RESOURCE, so only added if a clip text has been taken
			$this->dataGraphStr .= '{';
			$this->dataGraphStr .= '"@type": "SpecificResource",';
			$this->dataGraphStr .= '"@id": "'.$this->site.':urls/'.$url->urlid.'/resource",'; // ***
			$this->dataGraphStr .= '"hasSelector": "'.$this->site.':urls/'.$url->urlid.'/clip",'; // *
			$this->dataGraphStr .= '"hasSource": "'.parseToJSON($url->url).'"';
			$this->dataGraphStr .= '},';


			/*
			if (isset($url->clippath) && $url->clippath != "") {

				// CLIP DATA, so only added if a clip path has been taken
				$this->dataGraphStr .= '{';
				$this->dataGraphStr .= '"@type": "FragmentSelector",';
				$this->dataGraphStr .= '"@id": "'.$this->site.':urls/'.$url->urlid.'/clip",';
				$clip = character_convert_to($url->clip, 'UTF-8');
				$this->dataGraphStr .= '"exact": "'.parseToJSON(demicrosoftize($clip)).'",';

				$path = urldecode($url->clippath);
				$pathbits = explode("-",$path);
				$pathstart = $pathbits[0];
				$pathend = $pathbits[1];

				$xpointerpath = "#xpointer";

				$startbits = explode("/",$pathstart);
				$starttext = 'start-point(';
				$startlast = end($startbits);

				if ( startsWith($startlast, '3') ) {
					$bits = explode(":",$startlast);
					$textnum = $bits[1];
					$localpath = "";
					$count = count($startbits);
					for($i=0; $i<$count-1; $i++) {
						$localpath .= $startbits[$i];
						$localpath .= "/";
					}
					$bits2 = explode("[",$bits[0]);
					$starttext .= "string-range(".$localpath."text()[".$bits2[1].", '', ".$textnum."))";
				} else {
					$bits = explode(":",$startlast);
					if (count($bits) > 1) {
						$localpath = "";
						$count = count($startbits);
						for($i=0; $i<$count-1; $i++) {
							$localpath .= $startbits[$i];
							$localpath .= "/";
						}
						$textnum = $bits[1];
						$bits2 = explode("[",$bits[0]);
						if (count($bits2) > 1) {
							$starttext .= "string-range(".$localpath."text()[".$bits2[1]." '', ".$textnum."))";
						} else {
							$starttext .= "string-range(".$localpath."text(), '', ".$textnum."))";
						}
					} else {
						$starttext .= $pathstart.')';
					}
				}

				$endbits = explode("/",$pathend);
				$endtext = 'range-to(';
				$endlast = end($endbits);
				if ( startsWith($endlast, '3') ) {
					$bits = explode(":",$endlast);
					$textnum = $bits[1];
					$localpath = "";
					$count = count($endbits);
					for($i=0; $i<$count-1; $i++) {
						$localpath .= $endbits[$i];
						$localpath .= "/";
					}
					$bits2 = explode("[",$bits[0]);
					$endtext .= "string-range(".$localpath."text()[".$bits2[1].", '', ".$textnum."))";
				} else {
					$bits = explode(":",$endlast);
					if (count($bits) > 1) {
						$localpath = "";
						$count = count($endbits);
						for($i=0; $i<$count-1; $i++) {
							$localpath .= $endbits[$i];
							$localpath .= "/";
						}
						$textnum = $bits[1];
						$bits2 = explode("[",$bits[0]);
						if (count($bits2) > 1) {
							$endtext .= "string-range(".$localpath."text()[".$bits2[1]." '', ".$textnum."))";
						} else {
							$endtext .= "string-range(".$localpath."text(), '', ".$textnum."))";
						}
					} else {
						$endtext .= $pathend.')';
					}
				}

				$xpointerpath = "#xpointer(".$starttext."/".$endtext.")";
				$this->dataGraphStr .= '"rdf:value": "'.$xpointerpath.'",';

				//$this->dataGraphStr .= '"rdf:value": "#xpointer(start-point(string-range(//BODY/DIV[1]/DIV[1]/DIV[2]/DIV[2]/DIV[2]/DIV[3]/text()[11],'',26))/range-to(string-range(//BODY/DIV[1]/DIV[1]/DIV[2]/DIV[2]/DIV[2]/DIV[3]/text()[11],'',41)))",

				$this->dataGraphStr .= '"conformsTo": {';
				$this->dataGraphStr .= '"@id": "http://tools.ietf.org/rfc/rfc3236"';
				$this->dataGraphStr .= '}';
				$this->dataGraphStr .= '},';
			} else {
			*/
				// CLIP DATA, so only added if a clip path has been taken
				$this->dataGraphStr .= '{';
				$this->dataGraphStr .= '"@type": "TextQuoteSelector",';
				$this->dataGraphStr .= '"@id": "'.$this->site.':urls/'.$url->urlid.'/clip",'; // *

				$clip = character_convert_to($url->clip, 'UTF-8');
				$this->dataGraphStr .= '"exact": "'.parseToJSON($clip).'"';
				$this->dataGraphStr .= '},';
			//}
		}
	}

	function addNodeVotes($nodeid) {
		$votesObj = getVotes($nodeid);
		if (!$votesObj instanceof Error) {
			$posvotes = $votesObj->positivevoteslist;
			$negvotes = $votesObj->negativevoteslist;

			$count = count($posvotes);
			for ($i=0; $i<$count; $i++) {
				$vote = $posvotes[$i];
				$id = $vote->id;
				$type = $vote->type;
				$date = $vote->date;
				$moddate = $this->timestampToISO($date);

				$userid = $vote->userid;
				$pseudo_id = $this->getPseudonym($userid);
				if (in_array($userid, $this->checkUsers) === FALSE) {
					$user = getUser($userid);
					$this->addUser($user);
					array_push($this->checkUsers, $userid);
				}

				$this->dataGraphStr .= '{';
				$this->dataGraphStr .= '"@type": "BinaryVote",';
				$this->dataGraphStr .= '"@id": "'.$this->site.':votes/'.$id.'_'.$pseudo_id.'",';
				$this->dataGraphStr .= '"voter": "'.$this->site.':users/'.$pseudo_id.'",'; //pseudo
				$this->dataGraphStr .= '"created": "'.$moddate.'",';
				$this->dataGraphStr .= '"positive": "true",';
				$this->dataGraphStr .= '"vote_subject_node": "'.$this->site.':nodes/'.$id.'"';
				$this->dataGraphStr .= '},';
			}

			$count = count($negvotes);
			for ($i=0; $i<$count; $i++) {
				$vote = $negvotes[$i];
				$id = $vote->id;
				$type = $vote->type;
				$date = $vote->date;
				$userid = $vote->userid;
				$moddate = $this->timestampToISO($date);

				$userid = $vote->userid;
				$pseudo_id = $this->getPseudonym($userid);
				if (in_array($userid, $this->checkUsers) === FALSE) {
					$user = getUser($userid);
					$this->addUser($user);
					array_push($this->checkUsers, $userid);
				}

				$this->dataGraphStr .= '{';
				$this->dataGraphStr .= '"@type": "BinaryVote",';
				$this->dataGraphStr .= '"@id": "'.$this->site.':votes/'.$id.'_'.$pseudo_id.'",';
				$this->dataGraphStr .= '"voter": "'.$this->site.':users/'.$pseudo_id.'",'; //pseudo
				$this->dataGraphStr .= '"created": "'.$moddate.'",';
				$this->dataGraphStr .= '"positive": "false",';
				$this->dataGraphStr .= '"vote_subject_node": "'.$this->site.':nodes/'.$id.'"';
				$this->dataGraphStr .= '},';
			}
		}
	}

	function addConnectionVotes($con) {
		$votesObj = getVotes($con->connid);
		if (!$votesObj instanceof Error) {
			$posvotes = $votesObj->positivevoteslist;
			$negvotes = $votesObj->negativevoteslist;

			//$posvotes = $votesObj->positiveconnvoteslist;
			//$negvotes = $votesObj->negativeconnvoteslist;

			$count = count($posvotes);
			for ($i=0; $i<$count; $i++) {
				$vote = $posvotes[$i];
				$id = $vote->id;
				$type = $vote->type;
				$date = $vote->date;
				$moddate = $this->timestampToISO($date);

				$userid = $vote->userid;
				$pseudo_id = $this->getPseudonym($userid);
				if (in_array($userid, $this->checkUsers) === FALSE ) {
					$user = getUser($userid);
					$this->addUser($user);
					array_push($this->checkUsers, $userid);
				}

				$this->dataGraphStr .= '{';
				$this->dataGraphStr .= '"@type": "BinaryVote",';
				$this->dataGraphStr .= '"@id": "'.$this->site.':votes/'.$id.'_'.$pseudo_id.'",';
				$this->dataGraphStr .= '"voter": "'.$this->site.':users/'.$pseudo_id.'",'; //pseudo
				$this->dataGraphStr .= '"created": "'.$moddate.'",';
				$this->dataGraphStr .= '"positive": "true",';
				$this->dataGraphStr .= '"vote_subject_link": "'.$this->site.':connections/'.$id.'"';
				$this->dataGraphStr .= '},';
			}

			$count = count($negvotes);
			for ($i=0; $i<$count; $i++) {
				$vote = $negvotes[$i];
				$id = $vote->id;
				$type = $vote->type;
				$date = $vote->date;
				$userid = $vote->userid;
				$moddate = $this->timestampToISO($date);

				$userid = $vote->userid;
				$pseudo_id = $this->getPseudonym($userid);
				if (in_array($userid, $this->checkUsers) === FALSE ) {
					$user = getUser($userid);
					$this->addUser($user);
					array_push($this->checkUsers, $userid);
				}

				$this->dataGraphStr .= '{';
				$this->dataGraphStr .= '"@type": "BinaryVote",';
				$this->dataGraphStr .= '"@id": "'.$this->site.':votes/'.$id.'_'.$pseudo_id.'",';
				$this->dataGraphStr .= '"voter": "'.$this->site.':users/'.$pseudo_id.'",'; //pseudo
				$this->dataGraphStr .= '"created": "'.$moddate.'",';
				$this->dataGraphStr .= '"positive": "false",';
				$this->dataGraphStr .= '"vote_subject_link": "'.$this->site.':connections/'.$id.'"';
				$this->dataGraphStr .= '},';
			}
		}
	}

	function addUser($user) {
		if ($user)
		$pseudo_id = $this->getPseudonym($user->userid);

		$this->dataGraphStr .= '{';
		$this->dataGraphStr .= '"@type": "UserAccount",';
		$this->dataGraphStr .= '"@id": "'.$this->site.':users/'.$pseudo_id.'",';
		$this->dataGraphStr .= '"account_of": "'.$this->site.':agents/'.$pseudo_id.'"';
		$this->dataGraphStr .= '},';

		$this->addUserProfile($user);
	}

	function addUserProfile($user) {
		$pseudo_id = $this->getPseudonym($user->userid);

		$this->dataGraphStr .= '{';
		$this->dataGraphStr .= '"@type": "Agent",';
		$this->dataGraphStr .= '"@id": "'.$this->site.':agents/'.$pseudo_id.'"';
		$this->dataGraphStr .= '},';
	}

	function addFullUserProfile($user) {
		global $CFG;

		$pseudo_id = $this->getPseudonym($user->userid);

		$this->dataGraphStr .= '{';
		$this->dataGraphStr .= '"@type": "Agent",';
		$this->dataGraphStr .= '"@id": "'.$this->site.':agents/'.$pseudo_id.'",';

		if (isset($user->description) && $user->description != "") {
			$desc = character_convert_to($user->description, 'UTF-8');
			$this->dataGraphStr .= '"description": "'.parseToJSON($desc).'",';
		}
		if (isset($user->photo) && $user->photo != "") {
			$this->dataGraphStr .= '"img": "'.$user->photo.'",';
		}

		if (isset($user->userid) && $user->userid != 'anonymous') {
			$this->dataGraphStr .= '"homepage": "'.$CFG->homeAddress.'user.php?userid='.$user->userid.'",';
		}

		$name = character_convert_to($user->name, 'UTF-8');
		$this->dataGraphStr .= '"fname": "'.parseToJSON($name).'"';
		$this->dataGraphStr .= '},';
	}

	/*** HELPER FUNCTIONS ***/

	/**
	 * Take a timestamp and return a string formatted as required for this jsonld.
	 */
	function timestampToISO($timestamp) {
	    return date("c", $timestamp);
	}

	function trimFinalComma($str) {
		if (substr($str, strlen($str)-1, strlen($str)) == ",") {
			$str = substr($str, 0, strlen($str)-1);
		}
		return $str;
	}

	/**
	 * Take the given userid and encrypt it.
	 * return the encrypted userid or "anonymous", if userid not passed, empty or null.
	 */
	function getPseudonym($userid) {
		$pseudo_id = "anonymous";

		if (isset($userid) && $userid != "" && $userid != "anonymous") {
			$pseudo_id = $this->cipher->encrypt($userid);
		}

		// Why am I encoding it. It is coming back encoded from Mark and forcing me to unencode for alerts.
		return urlencode($pseudo_id);
		//return $pseudo_id;
	}
}
?>