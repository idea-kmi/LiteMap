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
 * REST service API
 *
 * All the methods listed are are available to users through REST-style URL calls
 * The methods should call the corresponding methods in the PHP API (core/apilib.php)
 *
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
global $USER,$CFG,$LNG;

//send the header info
set_restapi_header();

// If this system has been set to be a private Site that means all access requires login.
// Check they are logged in before proceeding.
if ($CFG->privateSite && (!isset($USER->userid) || $USER->userid == "")) {
    global $ERROR;
    $ERROR = new error;
    $ERROR->createAccessDeniedError();
	include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
    die;
}

$request = $_SERVER['REQUEST_URI'];
$responseParsed = parse_url($request);

// get any query parameters (id and or callback)
$cipher;
$unobfuscationid="";
$callback = "";

if (isset($responseParsed["query"])) {
	$query = $responseParsed["query"];
	//error_log($query);
	if (isset($query) && $query !="") {
		$queryBitsArray = explode('&', $query);
		$countq = count($queryBitsArray);
		for ($q=0; $q<$countq; $q++) {
			$nextbit = $queryBitsArray[$q];
			$nextArray = explode('=', $nextbit);
			if (count($nextArray) > 1 && $nextArray[0] == 'id') {
				$unobfuscationid = $nextArray[1];
			} else if (count($nextArray) > 1 && $nextArray[0] == 'callback') {
				$callback = $nextArray[1];
			}
		}
	}
}

$jsonld = FALSE;
if (isset($HUB_CACHE)) {
	$jsonld = $HUB_CACHE->getStringData($request);
}
if ($jsonld === FALSE) {
	//error_log("JSONLD not FOUND: resapi for ".$request);

	$path = $responseParsed["path"];

	//error_log("STARTING API CALL:".$path);
	//error_log("PATH:".print_r($path, true));
	//error_log("PARSED:".print_r($responseParsed, true));
	//error_log("REQUEST:".$request);

	//strip any leading and trailing '/'
	if ($path[0] == '/') {
		$path = substr($path, 1);
	}
	if (substr($path, -1, 1) == '/') {
		$path = substr($path, 0, strlen($path)-1);
	}

	$parts = explode('/', $path);
	//error_log("PARTS:".print_r($parts, true));

	$area = $parts[0];
	if ($area != 'api') {
		global $ERROR;
		$ERROR = new error;
		$ERROR->createAccessDeniedError();
		include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
		die;
	}

	$type = check_param($parts[1], PARAM_ALPHA);
	$len = count($parts);
	$cipher = "";

	// Do we have a data unobfuscation id to get the cipher key?
	if ($unobfuscationid != "" && $type != "unobfuscatedusers") {
		$keyArray = getObfuscationKeyByDataID($unobfuscationid, $request);
		if (!$keyArray instanceof Error) {
			$key = $keyArray['ObfuscationKey'];
			$iv = $keyArray['ObfuscationIV'];
			//error_log("key for data=".$key);
			//error_log("iv for data=".$iv);
			if (isset($key) && isset($iv)) {
				$cipher = new Cipher();
				$cipher->setKey($key);
				$cipher->setIV($iv);
			}
		} else {
			return $keyArray;
		}
	}

	if ($cipher == "" && $type != "unobfuscatedusers") {
		error_log("Creating new Cipher");
		$salt = openssl_random_pseudo_bytes(32);
		$cipher = new Cipher($salt);
	}

	//error_log(print_r($type, true));
	//error_log(print_r($len, true));
	//error_log("Help3:".print_r(memory_get_usage(), true));

	$response = "";

	switch($type) {

		/*
		case "users":
			if ($len == 2) {
				$response = getUsersByGlobal(false,0, -1,'name','ASC');
				break;
			} else if ($len == 3) {
				$id = check_param($parts[2], PARAM_TEXT);
				$response = getUser($id);
			}
			break;
		*/

		case "unobfuscatedusers":
			if ($len == 2) {
				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$keyArray = getObfuscationKey($unobfuscationid, $request);
					if (!$keyArray instanceof Error) {
						$key = $keyArray['ObfuscationKey'];
						$iv = $keyArray['ObfuscationIV'];
						//error_log("key for users=".$key);
						//error_log("iv for users=".$iv);
						if (isset($key) && isset($iv)) {
							$cipher = new Cipher();
							$cipher->setKey($key);
							$cipher->setIV($iv);
						}
					}

					if ($cipher == "") {
						error_log("unobfuscation key invalid or expired");
						global $ERROR;
						$ERROR = new error;
						$ERROR->createAccessDeniedError();
						include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
						die;
					} else {
						$userset = new UnobfuscatedUserSet();
						$userset->cipher = $cipher;

						// add users
						$users = getObfuscationUsers($unobfuscationid);
						//error_log("Users=".print_r($users, true));

						$userArray = explode(',', $users);

						$count = count($userArray);
						for($i=0; $i<$count; $i++) {
							$userid = $userArray[$i];
							if ($userid == 'anonymous') {
								$user = new User($userid);
								$user->name = $LNG->STATS_ACTIVITY_USER_ANONYMOUS_NAME;
							} else {
								$user = getUser($userid);
							}
							//error_log($userid);
							//error_log(print_r($user, true));
							$userset->add($user);
						}
						$response = $userset;
					}
				} else {
					global $ERROR;
					$ERROR = new error;
					$ERROR->createAccessDeniedError();
					include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
					die;
				}
			}
			break;

		case "connections":
			if ($len == 2) {
				$connset = getConnectionsByGlobal(0,-1,'date','ASC');
				$connset->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$connset->unobfuscationid = $unobfuscationid;
				}

				$response = $connset;
				break;
			} else if ($len == 3) {
				//$id = check_param($parts[2], PARAM_TEXT);
				//$response = getConnection($id);
			}
			break;

		case "urls":
			if ($len == 2) {
				$urlset = getURLsByGlobal(0,-1,'date','ASC');
				$urlset->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$urlset->unobfuscationid = $unobfuscationid;
				}

				$response = $userset;
				break;
			} else if ($len == 3) {
				$id = check_param($parts[2], PARAM_TEXT);
				$url =  getURL($id);
				$url->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$users = $url->userid;
					setObfuscationUsers($unobfuscationid, $users);
				}

				$response = $url;
			}
			break;

		case "nodes":
			if ($len == 2) {
				$nodeset = getNodesByGlobal(0,-1,'date','ASC');
				$nodeset->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$nodeset->unobfuscationid = $unobfuscationid;
				}

				$response = $nodeset;
				break;
			} else if ($len == 3) {
				$id = check_param($parts[2], PARAM_TEXT);
				$node = getNode($id);
				$node->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$node->unobfuscationid = $unobfuscationid;
				}

				$response = $node;
			}
			break;

		case "views":
			if ($len == 2) {
				$viewSet = getViews();
				$viewSet->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$viewSet->unobfuscationid = $unobfuscationid;
				}

				$response = $viewset;
				break;
			} else if ($len > 2){
				$id = check_param($parts[2], PARAM_TEXT);
				$view = getView($id, 'cif');
				if (isset($view) && !$view instanceof Error) {
					$view->cipher = $cipher;
					if (isset($unobfuscationid) && $unobfuscationid != "") {
						$view->unobfuscationid = $unobfuscationid;
					}

					if ($len == 4) {
						$subtype = check_param($parts[3], PARAM_ALPHA);
						$view->filter = $subtype;
					}
				}
				$response = $view;
			} else {
				global $ERROR;
				$ERROR = new error;
				$ERROR->createAccessDeniedError();
				include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
				die;
			}

			break;
		case "conversations":
			if ($len == 2) {
				$groupset = getConversationSetData($parts);
				$groupset->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$groupset->unobfuscationid = $unobfuscationid;
				}

				$response = $groupset;
			} else if ($len > 2){
				$id = check_param($parts[2], PARAM_TEXT);

				global $HUB_SQL, $DB;

				$group = getGroup($id);
				if($group instanceof Error){
					// Check if Users table has OriginalID field and if so check if this groupid is an old ID and adjust.
					$params = array();
					$resArray = $DB->select($HUB_SQL->AUDIT_USER_CHECK_ORIGINALID_EXISTS, $params);
					if ($resArray !== false) {
						if (count($resArray) > 0) {
							$array = $resArray[0];
							if (isset($array['OriginalID'])) {
								$params = array();
								$params[0] = $id;
								$resArray2 = $DB->select($HUB_SQL->AUDIT_USER_SELECT_ORIGINALID, $params);
								if ($resArray2 !== false) {
									if (count($resArray2) > 0) {
										$array2 = $resArray2[0];
										$groupid = $array2['UserID'];
										header("Location: ".$CFG->homeAddress."api/conversations/".$groupid);
										die;
									}
								}
							}
						}
					}
				}

				$group = getConversationData($id);
				$group->cipher = $cipher;

				if (isset($unobfuscationid) && $unobfuscationid != "") {
					$group->unobfuscationid = $unobfuscationid;
				}

				if ($len == 4) {
					$subtype = check_param($parts[3], PARAM_ALPHA);
					$group->filter = $subtype;
				}

				$response = $group;
			} else {
				global $ERROR;
				$ERROR = new error;
				$ERROR->createAccessDeniedError();
				include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
				die;
			}

			break;
		default:
			//error as method not defined.
			global $ERROR;
			$ERROR = new error;
			$ERROR->createInvalidMethodError();
			include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
			die;
	}

	//error_log("ENDING Initial data gathering");

	// finally format the output
	$jsonld = format_output_rest($response);
	if (isset($HUB_CACHE)) {
		$HUB_CACHE->setStringData($request, $jsonld, $CFG->CACHE_DEFAULT_TIMEOUT);
	}
} else {
	// write to file;
	//$file = 'cachedjsonld.txt';
	//$current .= $jsonld;
	//file_put_contents($file, $current);

	//error_log("JSONLD FOUND: resapi for ".$request);
}

if ($callback != '') {
	$reply = $callback."(".$jsonld.");";
	echo $reply;
} else {
	echo $jsonld;
}

/** HELP FUNCTIONS / CLASSES **/

class UnobfuscatedUserSet {
    public $cipher;
    public $users;
    public $count = 0;

    function UnobfuscatedUserSet() {
        $this->users = array();
    }

    /**
     * add a User to the set
     *
     * @param User $user
     */
    function add($user){
        array_push($this->users,$user);
        $this->count = count($this->users);
    }
}

/**
 * Return a ConversationSet for all challenges in the database;
 */
function getConversationSetData($parts) {

	$groupSet = new GroupSet();

	$allGroups = getGroupsByGlobal(0,-1,'date','ASC');
	if (!$allGroups instanceof Error) {
		$count = count($allGroups->groups);

		for ($i=0; $i<$count; $i++) {
			$group = $allGroups->groups[$i];
			if (!$group instanceof Error) {
				$groupdata = getConversationData($group->groupid);
				if (count($parts) > 3) {
					$subtype = check_param($parts[3], PARAM_ALPHA);
					$group->filter = $subtype;
				}

				if ($groupdata instanceof Group) {
					$groupSet->add($groupdata);
				}
			}
		}
	}

	return $groupSet;
}

/**
 * Return a Group for the given groupid;
 */
function getConversationData($groupid) {
	$mapNodes = getNodesByGroup($groupid,0,-1,'date','DESC', '', 'Map', 'cif');

   	$checkNodes = array();
   	$checkConns = array();

	$group = new Group($groupid);

	$view = new View($groupid);

	if (!$mapNodes instanceof Error) {
		$nodes = $mapNodes->nodes;
		$count = count($nodes);
		for ($i=0; $i<$count; $i++) {
			if (isset($nodes[$i])) {
				$node = $nodes[$i];

				/* // ADD MAP NODES ?
				if (array_key_exists($node->nodeid, $checkNodes) === FALSE) {
						$checkNodes[$node->nodeid] = $node->nodeid;
						array_push($view->nodes,$node);
					}
				}
				*/

				$nextmap = getView($node->nodeid, 'cif');

				$innernodes = $nextmap->nodes;
				$countk = count($innernodes);
				for ($k=0; $k<$countk;$k++) {
					$viewnode = $innernodes[$k];
					$innernode = $viewnode->node;
					if (!$innernode instanceof Error) {
						if (array_key_exists($innernode->nodeid, $checkNodes) === FALSE) {
							$checkNodes[$innernode->nodeid] = $innernode->nodeid;
							array_push($view->nodes,$viewnode);
						}
					}
				}

				$connections = $nextmap->connections;
				$countj = count($connections);
				for ($j=0; $j<$countj;$j++) {
					$viewcon = $connections[$j];
					$con = $viewcon->connection;
					if (!$con instanceof Error &&
							array_key_exists($con->connid, $checkConns) === FALSE) {
						$checkConns[$con->connid] = $con->connid;
						array_push($view->connections,$viewcon);
					}
				}
			}
		}
	}

	$group->view = $view;
	return $group;
}
?>