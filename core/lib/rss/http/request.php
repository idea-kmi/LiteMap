<?php
/**
 * HTTP TRANSPORT REQUEST GENERATOR
 * 
 * For use in RSS-PHP - Creates valid http requests for use with HTTP_HANDLER
 * Fri Feb 08 21:00:31 GMT 2008
 *
 * @package RSS-PHP
 * @subpackage HTTP
 * @author <black@rssphp.net>
 * @version 3
 */

define('HTTP_REQUEST_DEFAULT_METHOD','GET');

class http_request {
	public $HTTPRequestArray;
	protected $currentRequest;
	protected $validTransports;
	protected $HTTP_Method = array(
								'OPTIONS','GET','HEAD','POST','PUT','DELETE','TRACE','CONNECT'
								);

	public function __construct() {
		$this->validTransports = stream_get_transports();
	}

	public function setRequest($closeConnection, $requestURI, $httpMethod=HTTP_REQUEST_DEFAULT_METHOD) {
		$httpMethod = strtoupper($httpMethod);
		if($this->verifyHTTPMethod($httpMethod)) {
			$URIComponents = $this->extractURIComponents($requestURI);
			if(!$URIComponents[4]) {
				$URIComponents[4] = '/';
			}
			$this->currentRequest = &$this->HTTPRequestArray[$URIComponents[2]][$URIComponents[4]];
			$this->currentRequest['HTTPRequestMethod'] = $httpMethod;
			$this->currentRequest['transportMethod'] = $URIComponents[1];
			$this->currentRequest['HTTPRequestServer'] = $URIComponents[2];
			$this->currentRequest['HTTPPort'] = $URIComponents[3];
			$this->currentRequest['HTTPRequestURI'] = $URIComponents[4];
			$this->createHeaders();
			$this->setDefaults();
			if($closeConnection) {
				$this->setHeaderValue('connection', 'close');
			}
			$this->setHeaderValue('host', trim($URIComponents[2]));
		} else {
			die('The value <strong>'.strtoupper($httpMethod).'</strong> is not supported by this version of http_request');
		}
	}

	public function setTransport() {
		$transport = strtolower(trim($this->currentRequest['transportMethod']));
		if($transport == 'http') {
			$transport = '';
			$port = '80';
		} elseif($transport == 'https') {
			$transport = 'ssl';
			$port = '443';
		}
		if($transport) {
			if(in_array($transport, $this->validTransports, true)) {
				$this->currentRequest['HTTPTransport'] = $transport.'://';
			} else {
				die('This machine does not support the <strong>'.$transport.'</strong> transport method');
			}
		} else {
			$this->currentRequest['HTTPTransport'] = $transport;
		}
		if($this->currentRequest['HTTPPort']) {
			$this->currentRequest['HTTPPort'] = trim($this->currentRequest['HTTPPort'], ':');
		} else {
			$this->currentRequest['HTTPPort'] = $port;
		}
	}

	public function setEntity($entity) {
		if(in_array($this->currentRequest['HTTPRequestMethod'], array('POST','PUT'))) {
			$entity = trim($entity);
			$this->currentRequest['HTTPEntity'] = $entity;
			$this->setHeaderValue('content-length', strlen($entity));
		} else {
			die('The selected Request Method <strong>'.$this->HTTPRequestMethod.'</strong> does not support entities');
		}
	}

	protected function formatHTTPHeaders() {
		foreach($this->HTTPRequestArray as $HTTPRequestServer => $HTTPRequestURIArray) {
			foreach($HTTPRequestURIArray as $HTTPRequestURI => $HTTPRequestURIValues) {
				if(isset($this->HTTPRequestArray[$HTTPRequestServer][$HTTPRequestURI])) {
					$this->currentRequest = &$this->HTTPRequestArray[$HTTPRequestServer][$HTTPRequestURI];
					if(!isset($this->currentRequest['rawHTTPRequest'])) {
						$this->setTransport();
						$this->currentRequest['rawHTTPRequest'] = '';
						if(($this->currentRequest['HTTPRequestMethod']) && ($this->currentRequest['HTTPRequestServer']) && ($this->currentRequest['HTTPRequestURI'])) {
							$tempRawHTTPRequest = $this->currentRequest['HTTPRequestMethod'].' '.$this->currentRequest['HTTPRequestURI'].' HTTP/1.1'."\r\n";
							foreach($this->currentRequest['HTTPRequestHeaders'] as $headerField => $fieldArray) {
								if(isset($fieldArray['value']) && trim($fieldArray['value'])) {
									$tempRawHTTPRequest .= $headerField.': '.$fieldArray['value']."\r\n";
								}
							}
							$tempRawHTTPRequest .= "\r\n";
							if(isset($this->currentRequest['HTTPEntity'])) {
								$tempRawHTTPRequest .= $this->currentRequest['HTTPEntity']."\r\n\r\n";
							}
							$this->currentRequest['rawHTTPRequest'] .= $tempRawHTTPRequest;
						}
					}
					unset($this->currentRequest['HTTPRequestHeaders']);
				}
			}
		}
	}

	public function verifyHTTPMethod($in) {
		return in_array($in, $this->HTTP_Method, true);
	}
/*
=====================================================
	Initial VALID Object Data Construction
	=====================================================
*/

	private function setDefaults() {
		if($this->currentRequest['HTTPRequestMethod'] == 'POST') {
			$this->setHeaderValue('Content-Type','application/x-www-form-urlencoded');
		}
		if(isset($this->currentRequest['HTTPRequestHeaders']['Cache-Control']) && isset($this->currentRequest['HTTPRequestHeaders']['value'])) {
			if($this->currentRequest['HTTPRequestHeaders']['Cache-Control']['value'] == 'no-cache') {
				$this->setHeaderValue('Pragma','no-cache');
			}
		}
	}


/*
=====================================================
	Data Transformation Functions
	=====================================================
*/
	/*	Return the current gmt Date and Time formatted as per the RFC-822 specification */
	public function rfc822Date() {
		return gmdate('D, d M Y H:i:s T');
	}
	/*	Format the inputted header name to be consistent with the RFC 2616 Guidlines */
	public function headerNameFormat($in) {
		return str_replace(' ','-',ucwords(strtolower(str_replace('-',' ', trim($in)))));
	}
	/*	extract the transport method, domain/host and request uri from an url */
	protected function extractURIComponents($stringURI) {
		preg_match('/^([a-z]{3,5}):\/\/([a-zA-Z0-9-.]*)(:[\d]+)?([\/]?.*)$/', $stringURI, $out);
		return $out;
	}

/*
=====================================================
	Request Header Field Load and Value Set Functions
	=====================================================
*/
	/*	Set the value of the specified header */
	public function setHeaderValue($headerName, $value) {
		$headerName = $this->headerNameFormat($headerName);
		if(isset($this->currentRequest['HTTPRequestHeaders']	[$headerName])) {
			$this->currentRequest['HTTPRequestHeaders'][$headerName]['value'] = $value;
		} else {
			die('The specified header <strong>'.$headerName.'</strong> is not available in this version of HTTP_REQUEST');
		}
	}
	/*	make a header available for use in the current request */
	private function setHeaderItem($fieldName, $fieldValues) {
		foreach($fieldValues as $sub => $val) {
			$this->currentRequest['HTTPRequestHeaders'][$fieldName][$sub] = $val;
		}
	}

/*
=====================================================
	Available HTTP Request Header Field Definition
	=====================================================
*/
	/*	set the array structure that forms the basis for the current request
		define and load all the relevant HTTP Request fields based on the Request Method */
	private function createHeaders() {
	/* General-Header */
		$this->setHeaderItem('Cache-Control',	array(
										'required' 	=> false,
										'headType'	=> 'General-Header')
							);
		$this->setHeaderItem('Connection',	array(
										'required' 	=> false,
										'headType'	=> 'General-Header')
							);
		if(in_array($this->currentRequest['HTTPRequestMethod'], array('PUT','POST'))) {
			$this->setHeaderItem('Date',	array(
										'required' 	=> false,
										'headType'	=> 'General-Header')
							);
		}
		$this->setHeaderItem('Pragma',	array(
										'required' 	=> false,
										'headType'	=> 'General-Header')
							);
		if(in_array($this->currentRequest['HTTPRequestMethod'], array('PUT','POST'))) {
			$this->setHeaderItem('Transfer-Encoding',	array(
										'required' 	=> false,
										'headType'	=> 'General-Header')
							);
		}
		$this->setHeaderItem('Upgrade',	array(
										'required' 	=> false,
										'headType'	=> 'General-Header')
							);
		$this->setHeaderItem('Via',	array(
										'required' 	=> false,
										'headType'	=> 'General-Header')
							);
	/* Request-Header */
		$this->setHeaderItem('Accept',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('Accept-Charset',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('Accept-Encoding',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('Accept-Language',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('Authorization',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('Expect',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('From',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('Host',	array(
										'required' 	=> true,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('If-Match',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('If-Modified-Since',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('If-None-Match',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('If-Range',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('If-Unmodified-Since',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		if(in_array($this->currentRequest['HTTPRequestMethod'], array('TRACE','OPTIONS'))) {
			$this->setHeaderItem('Max-Forwards',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		}
		if($this->currentRequest['HTTPRequestMethod'] == 'GET') {
			$this->setHeaderItem('Range',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		}
		$this->setHeaderItem('Referer',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('TE',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('User-Agent',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
		$this->setHeaderItem('Cookie',	array(
										'required' 	=> false,
										'headType'	=> 'Request-Header')
							);
	/* Entity-Header */
		if(in_array($this->currentRequest['HTTPRequestMethod'], array('PUT','DELETE'))) {
			$this->setHeaderItem('Allow',	array(
										'required' 	=> false,
										'headType'	=> 'Entity-Header')
							);
		}
		if(in_array($this->currentRequest['HTTPRequestMethod'], array('PUT','POST'))) {
			$this->setHeaderItem('Content-Encoding',	array(
										'required' 	=> false,
										'headType'	=> 'Entity-Header')
							);
			$this->setHeaderItem('Content-Language',	array(
										'required' 	=> false,
										'headType'	=> 'Entity-Header')
							);
			$this->setHeaderItem('Content-Length',	array(
										'required' 	=> true,
										'headType'	=> 'Entity-Header')
							);
			$this->setHeaderItem('Content-MD5',	array(
										'required' 	=> false,
										'headType'	=> 'Entity-Header')
							);
			$this->setHeaderItem('Content-Range',	array(
										'required' 	=> false,
										'headType'	=> 'Entity-Header')
							);
			$this->setHeaderItem('Content-Type',	array(
										'required' 	=> true,
										'headType'	=> 'Entity-Header')
							);
		}
	}
}
?>