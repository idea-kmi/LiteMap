<?php
/**
 * HTTP TRANSPORT HANDLER
 * 
 * For use in RSS-PHP - Immitates a real browser and quickly retrieves/decodes remote resources
 * Fri Feb 08 21:00:31 GMT 2008
 *
 * @package RSS-PHP
 * @subpackage HTTP
 * @author <black@rssphp.net>
 * @version 3
 */

class http_handler extends http_request {
	public $HTTPErrorMsg;
	private $rawHTTPResponse;
	private $activeRequest;
	private $requestExecutionArray;

	public function executeRequest() {
		$this->requestExecutionArray = &$this->HTTPRequestArray;
		foreach($this->requestExecutionArray as $HTTPRequestServer => $HTTPRequestURIArray) {
			foreach($HTTPRequestURIArray as $HTTPRequestURI => $HTTPRequestURIValues) {
				$this->formatHTTPHeaders();
				$this->activeRequest = &$this->HTTPRequestArray[$HTTPRequestServer][$HTTPRequestURI];
				$fp = @stream_socket_client($this->activeRequest['HTTPTransport'].$this->activeRequest['HTTPRequestServer'].':'.$this->activeRequest['HTTPPort'], $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $this->randomContext());
				if (!$fp) {
					if($errno == 0) {
						$this->HTTPErrorMsg = "http_handler could not connect to $this->activeRequest['HTTPRequestServer']:$this->activeRequest['HTTPPort']";
					} else {
						$this->HTTPErrorMsg = "http_handler could not connect to ".$this->activeRequest['HTTPRequestServer'].":".$this->activeRequest['HTTPPort']." (PHP Error Number: $errno, Message: $errstr)";
					}
					return false;
				} else {
					$this->activeRequest['rawHTTPResponse'] = '';
					fwrite($fp, $this->activeRequest['rawHTTPRequest']);
					while (!feof($fp)) {
						$this->activeRequest['rawHTTPResponse'] .= fgets($fp, 2);
					}
					fclose($fp);
					$this->parseResponse();
				}
			}
		}
		unset($this->activeRequest);
		unset($this->requestExecutionArray);
		unset($this->currentRequest);
		unset($this->validTransports);
		return true;
	}

	private function parseResponse() {
		$tempRawResponse = $this->activeRequest['rawHTTPResponse'];
		do {
			$responseArray = explode(chr(13).chr(10).chr(13).chr(10), $tempRawResponse, 2);
			$singleResponseHeaders = $this->HTTPMessageDecoder($responseArray[0]);
			if(isset($singleResponseHeaders['Transfer-Encoding']) && (strstr($singleResponseHeaders['Transfer-Encoding'], 'chunked'))) {
				$tempParsedResponse['headers'] = $singleResponseHeaders;
				$remainderArray = explode(chr(13).chr(10).chr(13).chr(10).'0'.chr(13).chr(10).chr(13).chr(10), $responseArray[1], 2);
				$tempParsedResponse['entity'] = $this->HTTPChunkDecoder($remainderArray[0]);
				if(isset($remainderArray[1])) {
					$tempRawResponse = $remainderArray[1];
				} else {
					$tempRawResponse = '';
				}
				$this->activeRequest['HTTPResponse'] = $tempParsedResponse;
			} elseif(isset($singleResponseHeaders['Content-Length'])) {
				$tempParsedResponse['headers'] = $singleResponseHeaders;
				$tempParsedResponse['entity'] = substr($responseArray[1], 0, $singleResponseHeaders['Content-Length']);
				$tempRawResponse = substr($responseArray[1], $singleResponseHeaders['Content-Length']);
				$this->activeRequest['HTTPResponse'] = $tempParsedResponse;
			} else {
			/*	best cater for the http 1.0! */
				$tempParsedResponse['headers'] = $singleResponseHeaders;
				$tempParsedResponse['entity'] = $responseArray[1];
				$tempRawResponse = '';
				$this->activeRequest['HTTPResponse'] = $tempParsedResponse;
			}
		} while (strlen($tempRawResponse) > 0);
	}

	private function processResponse() {
	/*	3xx redirect */
		if(preg_match('/^3([\d]{2,2})+$/', $this->activeRequest['HTTPResponse']['headers']['status'][1])) {
			if(isset($this->activeRequest['HTTPResponse']['headers']['Location'])) {
				$this->setRequest(true, $this->activeRequest['HTTPResponse']['headers']['Location']);
			}
		}
	}

	public function getSingleResponse($uri) {
		$URIComponents = $this->extractURIComponents($uri);
		return $this->HTTPRequestArray[$URIComponents[2]][$URIComponents[4]]['HTTPResponse']['entity'];
	}

	public function getHeadersFromResponse($uri) {
		$URIComponents = $this->extractURIComponents($uri);
		return $this->HTTPRequestArray[$URIComponents[2]][$URIComponents[4]]['HTTPResponse']['headers'];
	}

	private function HTTPMessageDecoder($headerString) {
		$headerArray = explode("\r\n", $headerString, 2);
		$headerArrayOut['status'] = explode(' ', $headerArray[0], 3);
		$headerArray = explode("\r\n", $headerArray[1]);
		foreach($headerArray as $lineNum => $lineString) {
			$tempHeader = explode(':', $lineString, 2);
			$headerArrayOut[$this->headerNameFormat($tempHeader[0])] = trim($tempHeader[1]);
		}
		return $headerArrayOut;
	}

	private function HTTPChunkDecoder($chunkedData) {
		$decodedData = '';
		do {
			$tempChunk = explode(chr(13).chr(10), $chunkedData, 2);
			$chunkSize = hexdec($tempChunk[0]);
			$decodedData .= substr($tempChunk[1], 0, $chunkSize);
			$chunkedData = substr($tempChunk[1], $chunkSize+2);
		} while (strlen($chunkedData) > 0);
		return $decodedData;
	}

	public function getRawResponse() {
		if($this->rawHTTPResponse) {
			return $this->rawHTTPResponse;
		} else {
			return false;
		}
	}

	private function randomContext() {
		$headerstrings = array();
		$headerstrings['User-Agent'] = 'Mozilla/5.0 (Windows; U; Windows NT 5.'.rand(0,2).'; en-US; rv:1.'.rand(2,9).'.'.rand(0,4).'.'.rand(1,9).') Gecko/2007'.rand(10,12).rand(10,30).' Firefox/2.0.'.rand(0,1).'.'.rand(1,9);
		$headerstrings['Accept-Charset'] = rand(0,1) ? 'en-gb,en;q=0.'.rand(3,8) : 'en-us,en;q=0.'.rand(3,8);
		$headerstrings['Accept-Language'] = 'en-us,en;q=0.'.rand(4,6);
		$setHeaders = 	'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'."\r\n".
						'Accept-Charset: '.$headerstrings['Accept-Charset']."\r\n".
						'Accept-Language: '.$headerstrings['Accept-Language']."\r\n".
						'User-Agent: '.$headerstrings['User-Agent']."\r\n";
		$contextOptions = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>$setHeaders
			)
		);
		return stream_context_create($contextOptions);
	}
}
?>