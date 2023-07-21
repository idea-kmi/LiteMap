<?php
/**
 * RSS-PHP
 * 
 * PHP DOM based XML (RSS) Parser Thing
 * Fri Feb 08 21:00:31 GMT 2008
 *
 * @package RSSPHP
 * @author <black@rssphp.net>
 * @version 3
 */

#INSTALLATION BASED PREFERENCES

//	should rss-php attempt to perform auto encoding detection and conversion to UTF-8 (requires iconv)
	define('RSS_PHP_ENCODING_CONVERSION', TRUE);
//	should rss-php die if it finds an encoding unsupported by the machine
	define('RSS_PHP_ICONV_UNSUPPORTED_LANG_DIE', TRUE);
//	should rss-php use HTTP_TRANSPORT
	define('RSS_PHP_HTTP_TRANSPORT', TRUE);


/*
DO NOT MODIFY ANYTHING BELOW
#######################################################*/

#INTERNAL PATH DEFINITIONS
	define('RSS_PHP_BUILD_FILENAME', basename(__FILE__));
	define('RSS_PHP_BASE', substr(__FILE__, 0, strlen(__FILE__)-strlen(RSS_PHP_BUILD_FILENAME)));
	define('RSS_PHP_DIRECTORY_SEPARATOR', substr(RSS_PHP_BASE,-1));

#RSS_ENCODING CONDITIONAL INCLUSION
	if(RSS_PHP_ENCODING_CONVERSION && function_exists('iconv')) {
		if(file_exists(RSS_PHP_BASE.'encoding/xml.php') && file_exists(RSS_PHP_BASE.'encoding/iconv.php')) {
			require_once RSS_PHP_BASE.'encoding/iconv.php';
			require_once RSS_PHP_BASE.'encoding/xml.php';
			if(class_exists('encoding_xml') && class_exists('encoding_iconv')) {
				define('RSS_PHP_USE_RSS_ENCODING', TRUE);
			}
		}
	}
	if(!defined('RSS_PHP_USE_RSS_ENCODING')) {
		define('RSS_PHP_USE_RSS_ENCODING', FALSE);
	}

#HTTP_TRANSPORT CONDITIONAL INCLUSION
	if(RSS_PHP_HTTP_TRANSPORT && function_exists('stream_socket_client')) {
		if(file_exists(RSS_PHP_BASE.'http/request.php') && file_exists(RSS_PHP_BASE.'http/handler.php')) {
			require_once RSS_PHP_BASE.'http/request.php';
			require_once RSS_PHP_BASE.'http/handler.php';
			if(class_exists('http_request') && class_exists('http_handler')) {
				define('RSS_PHP_USE_HTTP_HANDLER', TRUE);
			}
		}
	}
	if(!defined('RSS_PHP_USE_HTTP_HANDLER')) {
		define('RSS_PHP_USE_HTTP_HANDLER', FALSE);
	}


#INCLUDE RSS_PHP
	if(file_exists(RSS_PHP_BASE.'rss.php')) {
		require_once RSS_PHP_BASE.'rss.php';
	} else {
		if(!class_exists('rss_php')) {
			die('ERROR: RSS_PHP CAN NOT BE FOUND [path: '.RSS_PHP_BASE.'rss.php'.']');
		}
	}

class rss_php {

/**
 * Array to hold all DOMProcessingInstructions found in an input XML Document
 *
 * @var Array
 */
	public $DOMProcessingInstructions;
/**
 * Array holding all XMLNS (XML Namespaces) found in an input XML Document.
 *
 * @var Array
 */
	public $DOMNamespaces;
/**
 * Nested Array of Objects (DOMElements)
 *
 * @var Array
 */
	public $document;
/**
 * Internal storage of the DOMDocument
 *
 * @var DOMDocument
 */
	public $DOMDocument;
/**
 * Preloaded Internal DOMXPath Object for use with ->query function
 *
 * @var DOMXpath
 */
	public $DOMXPath;
/**
 * configuration variable : use rss_encoding_xml && rss_encoding_iconv libraries
 * provides automatic language detection and converion to UTF-8
 *
 * @var bool
 */
	public $useXMLEncoding=false;
/**
 * configuration variable : use core transport_http_handler library
 * setting this variable to FALSE changes the object to use file_get_contents
 *
 * @var bool
 */
	public $useHTTPTransport=false;

	public function __construct() {
		if(RSS_PHP_ENCODING_CONVERSION && RSS_PHP_USE_RSS_ENCODING) {
			$this->useXMLEncoding = true;
		}
		if(RSS_PHP_HTTP_TRANSPORT && RSS_PHP_USE_HTTP_HANDLER) {
			$this->useHTTPTransport = true;
		}
	}
/**
 * load a local or remote xml document into rss_php
 *
 * @param string $url the location of the url, local or remote
 * @param string $user if specified will be used as the http auth username
 * @param string $pass if specified will be used as the http auth password
 * @return boolean success
 */
		public function load($url=false, $user=false, $pass=false) {
			$returnValue = false;
			if($url) {
				$urlparts = parse_url($url);
				if($urlparts) {
					if((count($urlparts) == 1 && isset($urlparts['path'])) || (count($urlparts) == 2 && isset($urlparts['path'])&& isset($urlparts['scheme']))) {
						#local file
						if(file_exists($urlparts['path'])) {
							$returnValue = $this->loadParser(file_get_contents($url));
						} else {
							die('RSS_PHP ERROR : can not find the specified file ['.$url.']');
						}
					} else {
						#remote file
						if($this->useHTTPTransport) {
							$http_handler = new http_handler;
							$http_handler->setRequest(true, $url);
							if($user && $pass) {
								$http_handler->setHeaderValue('Authorization', 'Basic '.base64_encode(trim($user).':'.trim($pass)));
							}
							if($http_handler->executeRequest()) {
								$returnValue = $this->loadParser($http_handler->getSingleResponse($url));
							} else {
								die($http_handler->HTTPErrorMsg);
							}
						} else {
							$returnValue = $this->loadParser(file_get_contents($url));
						}
					}
				} else {
					die('RSS_PHP ERROR : PHP cannot parse the given path / url ['.$url.']');
				}
			} else {
				die('RSS_PHP ERROR : Parameter 1 [path/url] cannot be null');
			}
			return $returnValue;
		}

/**
 * load raw xml into rss_php
 *
 * @param string $rawxml raw xml in a string
 * @return boolean success
 */
		public function loadXML($rawxml=false) {
			if($rawxml) {
				return $this->loadParser($rawxml);
			} else {
				die('RSS_PHP ERROR : Parameter 1 [rawxml] cannot be null');
			}
		}
/**
 * load raw rss into rss_php
 *
 * @deprecated this is included for backwards compatibility only, please use method loadXML()
 * @param string $rawxml raw xml in a string
 * @return boolean success
 */		
		public function loadRSS($rawxml) {
			return $this->loadXML($rawxml);
		}
/**
 * load an array into rss_php
 *
 * @param array $array to be converted
 * @param string $rootNodeName if specified a root object of rootNodeName will be created and all array data appened
 * @return boolean success
 */
		public function loadArray($array, $rootNodeName=false) {
			$this->DOMDocument = new DOMDocument('1.0', 'UTF-8');
			$this->DOMDocument->strictErrorChecking = false;
			$this->DOMDocument->formatOutput = true;
			$this->DOMDocument->preserveWhiteSpace = false;
			if($rootNodeName) {
				$array = array($rootNodeName => $array);
			}
			$this->convertArray($array);
			return $this->gdoc();
		}

/**
 * return a referenced array to document
 *
 * @param boolean $includeAttributes include all info, default FALSE neat output of node values only
 * @return array multidimensional associative array of all nodes and reference values
 */
	public function &getValues($includeAttributes=false) {
		if($includeAttributes) {
			return $this->document;
		}
		return $this->valueReturner();
	}

/**
 * return return full rss array
 *
 * @deprecated for backwards compatibility only, please use getValues()
 * @param unknown_type $includeAttributes
 * @return unknown
 */
	public function &getRSS($includeAttributes=false) {
		return $this->getValues($includeAttributes);
	}

	# return rss items
	public function &getItems($includeAttributes=false,$limit=false,$offset=false) {
		if($includeAttributes) {
			$items = $this->getElementsByTagName('item');
		} else {
			$items = $this->getValuesByTagName('item');
		}
		if($limit !== false || $offset !== false) {
			$items = array_splice($items, $offset, $limit);
		}
		return $items;
	}
/**
 * return the document as an xml document
 *
 * @return string XML
 */
	public function getXML() {
		$this->rebuildDOM($this->document);
		return $this->DOMDocument->saveXML();
	}
/**
 * return an assocate array of all DOMElements matching $tagName
 * including all attributes
 *
 * @param string $tagName (tag/node)name to search for
 * @return array formatted dom node list
 */
	public function &getElementsByTagName($tagName) {
		return $this->extractDOM($this->DOMDocument->getElementsByTagName($tagName));
	}
/**
 * retrieve all namespaces defined in the current document
 *
 * @return array
 */
	public function getNamespaces() {
		return $this->DOMNamespaces;
	}
/**
 * retrieve all processing instructions related to the current document
 *
 * @return array
 */
	public function getProcessingInstructions() {
		return $this->DOMProcessingInstructions;
	}
/**
 * return a referenced associative array of all values whos (tag/node)name matches $tagName
 *
 * @param string $tagName (tag/node)name to search for
 * @return array referenced array of nodename/value pairs (and any child elements)
 */
	public function getValuesByTagName($tagName) {
		return $this->transformNodeList($this->DOMDocument->getElementsByTagName($tagName));
	}
/**
 * provides XPath query functionality to rss_php
 *
 * @param string $XPathQuery must be valid XPath syntax
 * @return array referenced array of nodename/value pairs (and any child elements)
 */
	public function query($XPathQuery, $includeAttributes=false) {
		$result = $this->DOMXPath->query($XPathQuery);
		if($includeAttributes) {
			return $this->extractDOM($result);
		}
		return $this->transformNodeList($result);
	}
/**
 * @internal parse XML and turn into an accessible dom document
 *
 * @param string $xml raw xml
 * @return boolean success
 */
	private function loadParser($xml=false) {
		if($xml) {
			$this->document = array();
			if($this->useXMLEncoding) {
				$xml_encoding = new encoding_xml;
				$xml = $xml_encoding->precode($xml);
			}
			$this->DOMDocument = new DOMDocument;
			$this->DOMDocument->strictErrorChecking = false;
			$this->DOMDocument->formatOutput = true;
			$this->DOMDocument->preserveWhiteSpace = false;
			@$this->DOMDocument->loadXML($xml);

			return $this->gdoc();
		}
		return false;
	}
/**
 * @internal set up initial DOMDocument, DOMXPath and extract namespaces
 *
 * @return boolean success
 */
	private function gdoc() {
		$this->DOMXPath = new DOMXPath($this->DOMDocument);
		$this->extractNamespaces();
		if(!$this->document = $this->extractDOM($this->DOMDocument->childNodes)) {
			die('RSS_PHP ERROR : The file specified appears not to be a valid xml file');
		}
		return true;
	}
/**
 * @internal negotiate internal DOMDocument and return an array
 *
 * @param DOMNode $valueBlock one of any element which extends a DOMNode
 * @return array all name/values pairs as multidimensional associative array
 */
	private function &valueReturner($valueBlock=false) {
		if(!$valueBlock) {
			$valueBlock = $this->document;
		}

		foreach($valueBlock as $valueName => $values) {
				if(is_array($values->children)) {
					$valueBlock[$valueName] = $this->valueReturner($values->children);
				} else {
					$valueBlock[$valueName] = &$values->valueData;
				}
		}
		return $valueBlock;
	}
/**
 * @internal parses DOMNodeList objects into an associative array for return from public functions
 *
 * @param DOMNodeList/DOMNode $nodeList 
 * @param array $valueBlock current array level
 * @return array final name/value pairs for return from methods
 */
	private function transformNodeList($nodeList, $valueBlock=array()) {
		$itemCounter = 0;
		$levelNames = array();
		foreach($nodeList as $node) {
			if(!isset($levelNames[$node->nodeName])) {
				$levelNames[$node->nodeName] = 0;
			} else {
				$levelNames[$node->nodeName]++;
			}
		}
		foreach($nodeList as $values) {
			if($levelNames[$values->nodeName]) {
				$nodeName = $values->nodeName.':'.$itemCounter;
				$itemCounter++;
			} else {
				$nodeName = $values->nodeName;
			}
			if(is_array($values->children)) {
				$valueBlock[$nodeName] = $this->valueReturner($values->children, $valueBlock);
			} else {
				$valueBlock[$nodeName] = &$values->valueData;
			}
		}
		return $valueBlock;
	}
/**
 * @internal update values internally for export
 *
 * @param DOMDocument/DOMNodeList $nodes
 */
	private function rebuildDOM($nodes=false) {
		if(!$nodes) {
			$nodes = $this->document;
		}
		foreach($nodes as $node) {
			if(isset($node->attributeNodes)) {
				foreach($node->attributeNodes as $aName => $aVal) {
					$node->setAttributeNode(new DOMAttr($aName, $aVal));
				}
			}
			if(is_array($node->children)) {
				$this->rebuildDOM($node->children);
			} else {
				if(is_object($node)) {
					if(isset($node->valueDataType)) {
						if($node->valueDataType == 3) {
							$newTextNode = $this->DOMDocument->createTextNode($node->valueData);
							$node->replaceChild($newTextNode, $node->childNodes->item(0));
						} elseif($node->valueDataType == 4) {
							$newCDATANode = $this->DOMDocument->createCDATASection($node->valueData);
							$node->replaceChild($newCDATANode, $node->childNodes->item(0));
						}
					}
				}
			}
		}
	}
/**
 * @internal extract registered XMLNS namespaces using XPath
 *
 */
	private function extractNamespaces() {
		$namespaces = $this->DOMXPath->query('namespace::*');
		foreach ($namespaces AS $namespace) {
			if($namespace->localName !== 'xml') {
				$this->DOMNamespaces[$namespace->localName] = $this->DOMDocument->lookupNamespaceURI($namespace->localName);
			}
		}
	}
/**
 * @internal turn a standard DOMDocument into a more accessible format
 *
 * @param DOMDocument $nodeList
 * @return DOMElement internal return only to create document
 */
	private function &extractDOM($nodeList) {
		$itemCounter = 0;
		$levelNames = array();
		foreach($nodeList as $node) {
			if(!isset($levelNames[$node->nodeName])) {
				$levelNames[$node->nodeName] = 0;
			} else {
				$levelNames[$node->nodeName]++;
			}
		}
		foreach($nodeList as $values) {
			if($values->nodeType == XML_ELEMENT_NODE) {
				if($levelNames[$values->nodeName]) {
					$nodeName = $values->nodeName.':'.$itemCounter;
					$itemCounter++;
				} else {
					$nodeName = $values->nodeName;
				}
				$tempNode[$nodeName] = array();
				$values->nameString = $values->nodeName;
				if($values->attributes) {
					for($i=0;$values->attributes->item($i);$i++) {
						$values->attributeNodes[$values->attributes->item($i)->nodeName] = &$values->attributes->item($i)->nodeValue;
					}
				}
				$values->children = $this->extractDOM($values->childNodes);
				$tempNode[$nodeName] = $values;
			} elseif(in_array($values->nodeType, array(XML_TEXT_NODE, XML_CDATA_SECTION_NODE))) {
				$values->parentNode->valueDataType = &$values->nodeType;
				$values->parentNode->valueData = &$values->data;
			} elseif($values->nodeType === XML_PI_NODE) {
				$this->DOMProcessingInstructions[] = array('target' => $values->target, 'data' => $values->data);
			}
			# other wise we ignore as all that's left is DOMComment
			# note DOMComment Will only output in XML format they are not saved!

		}
		return $tempNode;
	}

/**
 * @internal internal array parser, turns any array into a DOMDocument
 *
 * @param unknown_type $node
 * @param unknown_type $parentNode
 */
	private function convertArray($node=false,$parentNode=false) {
		$toRemove = array();
		foreach($node as $nodeName => $nodeValue) {
			if($parentNode) {
				if(is_numeric($nodeName) && (intval($nodeName) == $nodeName)) {
					$parentNode->parentNode->appendChild($newElement = $this->DOMDocument->createElement($parentNode->nodeName));
					$toRemove[] = $parentNode;
				} else {
					$parentNode->appendChild($newElement = $this->DOMDocument->createElement($nodeName));
				}
			} else {
				$this->DOMDocument->appendChild($newElement = $this->DOMDocument->createElement($nodeName));
			}
			if(is_array($nodeValue)) {
				$this->convertArray($nodeValue,$newElement);
			} else {
				if($nodeValue == strip_tags($nodeValue)) {
					$newTextNode = $this->DOMDocument->createTextNode($nodeValue);
					$newElement->appendChild($newTextNode);
				} else {
					$newCDATANode = $this->DOMDocument->createCDATASection($nodeValue);
					$newElement->appendChild($newCDATANode);
				}
			}
		}
		foreach($toRemove as $remove) {
			if(is_object($remove->parentNode)) {
				$remove->parentNode->removeChild($remove);
			}
		}
	}
}
?>