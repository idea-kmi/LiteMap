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
 /** Author: Michelle Bachler, KMi, The Open University **/

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

global $serviceRootAnalytics;
//$serviceRootAnalytics = 'http://deliberatorium.mit.edu/getmetrics';
//$serviceRootAnalytics = 'http://franc2.mit.edu:5050/accept';
//$serviceRootAnalytics = 'http://ns239264.ip-192-99-37.net:5050/accept';
//$serviceRootAnalytics = 'http://discussions.bluenove.com:5050/accept';

$serviceRootAnalytics = 'https://discussions.bluenove.com/analytics/accept';

function getCannedResults($url) {
	$jsondata = loadJsonLDFromURL($url);
	return $jsondata;
}

/**
 * Get the metric results for the named metric(s) for the data from the given url
 * @param $url the url for the data to process
 * @param $metrics the name of the metrics to call (comma separated list)
 * @param $timeout the length of time the metrics server should cache the data for in seconds. Default to 60
 * @return false, if the call failed, else the response data from the call (will be a json string).
 */
function getMetrics($url, $metrics, $timeout=60) {
	$requests = createMetricRequestPostField($metrics);
	return callAnalyticsAPIWithURL('POST', $requests, $url, $timeout);
}

/**
 * Get alert metrics results for the named alert types(s) for the data from the given url
 * @param $url the url for the data to process
 * @param $alerttypes one or more alert types to get the metrics for (comma sparated list).
 * @param $timeout (optional) the length of time the metrics server should cache the data for in seconds. Default to 60
 * @param $userids (optional) one or more userid of the users to get alerts for (comma sparated list)
 * @param $root (optional) the post id of the map tree to process within the given data
 * @return false, if the call failed, else the response data from the call (will be a json string).
 */
function getAlertMetrics($url, $cipher, $alerttypes, $timeout=60,$userids="",$root="") {
	global $CFG;

	$requests = createAlertMetricRequestPostField($alerttypes,$cipher,$userids,$root);
	$results = callAnalyticsAPIWithURL('POST', $requests, $url, $timeout);
	if (!$results) {
		$message = "Metrics server unreachable for: ".$url;
		sendMailMessage("Alert Metrics down on ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $message);
	}
	return $results;
}

/**
 * Get the metric results for the named metric(s) for the data from the given url
 * The data will be fetched from the url and sent as a string.
 * @param $url the url for the data to process
 * @param $metrics the name of the metrics to call (comma separated list)
 * @param $timeout the length of time the metrics server should cache the data for in seconds. Default to 60
 * @return false, if the call failed, else the response data from the call (will be a json string).
 */
function getMetricsUsingJson($url, $metrics, $timeout=60) {
	$requests = createMetricRequestPostField($metrics);
	$jsondata = loadJsonLDFromURL($url);
	return callAnalyticsAPIWithJson('POST', $requests, $jsondata, $timeout);
}

/**
 * Get the metric results for the named metric(s) for the data from the given url
 * The data will be fetched from the url and zipped before being sent.
 * @param $url the url for the data to process
 * @param $requests the request for getting metrics (correctly formatted to send)
 * @param $timeout the length of time the metrics server should cache the data for in seconds. Default to 60
 * @return false, if the call failed, else the response data from the call (will be a json string).
 */
function getMetricsUsingZip($url, $requests, $timeout=60) {
	global $CFG;

	$str = file_get_contents($url);
	$time = time();
	$zipfilepath = $CFG->dirAddress."map_".$time.".zip";
	$zip = createZip($zipfilepath, $str);
	if ($zip) {
		return callAnalyticsAPIWithZip('POST', $requests, $zipfilepath, $timeout);
	} else {
		return "";
	}
}

function createZip($filepath, $content) {
	$zip = new ZipArchive;
	$res = $zip->open($filepath, ZipArchive::CREATE);
	if ($res === TRUE) {
		$zip->addFromString('map.json', $content);
		$zip->close();
		return true;
	} else {
		echo false;
	}
}


/**
 * Makes service calls using Curl for the parameters given
 * @param $method POST/PUT/GET/DELETE
 * @param $requests the request for getting metrics (correctly formatted to send)
 * @param $url, the url that returns the data to be processed.
 * @param $timeout the length of time the metrics server should cache the data for in seconds. Default to 60
 * @return false, if the call failed, else the response data from the call (will be a json string).
 */
function callAnalyticsAPIWithURL($method, $requests, $url, $timeout=60) {
	global $serviceRootAnalytics;

	$curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, true);
            break;
        case "GET":
            //curl_setopt($curl, CURLOPT_HTTPGET, true);
        	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            break;
        case "DELETE":
        	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            break;
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	$postfields = array();
	$postfields['mapurl'] = $url;
	$postfields['requests'] = $requests;
	$postfields['recency'] = $timeout;

	error_log(print_r($postfields, true));

    curl_setopt($curl, CURLOPT_URL, $serviceRootAnalytics);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/BuiltinObjectToken-EquifaxSecureCA.crt");

	$response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
	curl_close($curl);

	error_log(print_r("RESPONSE=".$response, true));
	error_log("code=".$httpCode);

	if($httpCode != 200 || $response === false) {
		return false;
    } else {
		return $response;
	}
}

/**
 * Makes service calls using Curl for the parameters given
 * @param $method POST/PUT/GET/DELETE
 * @param $requests the request for getting metrics (correctly formatted to send)
 * @param $jsondata, the data to send to the url to be processed
 * @param $timeout the length of time the metrics server should cache the data for in seconds. Default to 60
 * @return false, if the call failed, else the response data from the call (will be a json string).
 */
function callAnalyticsAPIWithJson($method, $requests, $jsondata, $timeout=60) {
	global $serviceRootAnalytics;

	$curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, true);
            break;
        case "GET":
            //curl_setopt($curl, CURLOPT_HTTPGET, true);
        	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            break;
        case "DELETE":
        	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            break;
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	$postfields = array();
	$postfields['map'] = $jsondata;
	$postfields['requests'] = $requests;
	$postfields['recency'] = $timeout;

    curl_setopt($curl, CURLOPT_URL, $serviceRootAnalytics);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/BuiltinObjectToken-EquifaxSecureCA.crt");

	$response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
	curl_close($curl);

	error_log(print_r($response, true));

	if($httpCode != 200 || $response === false) {
		return false;
    } else {
		return $response;
	}
}

/**
 * Makes service calls using Curl for the parameters given
 * @param $method POST/PUT/GET/DELETE
 * @param $requests the request for getting metrics (correctly formatted to send)
 * @param $zipfilepath, the file path of the zip of the data for the metric
 * @param $timeout the length of time the metrics server should cache the data for in seconds. Default to 60
 * @return false, if the call failed, else the response data from the call (will be a json string).
 */
function callAnalyticsAPIWithZip($method, $metrics, $zipfilepath, $timeout=60) {
	global $serviceRootAnalytics;

	$curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, true);
            break;
        case "GET":
            //curl_setopt($curl, CURLOPT_HTTPGET, true);
        	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            break;
        case "DELETE":
        	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            break;
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	$postfields = array();
	$postfields['map'] = '@'.$zipfilepath;
	$postfields['requests'] = $requests;
	$postfields['recency'] = $timeout;

    curl_setopt($curl, CURLOPT_URL, $serviceRootAnalytics);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/BuiltinObjectToken-EquifaxSecureCA.crt");

	$response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
	curl_close($curl);

	//error_log(print_r($response, true));

	unlink($zipfilepath);

	if($httpCode != 200 || $response === false) {
		return false;
    } else {
		return $response;
	}
}

/**
 * Create a string to represent the request for one or more metrics given in the $metrics parameter.
 * @param $metrics the name of the metrics to call (comma sparated list)
 * @return a string containing the metric request to send to the metrics server
 */
function createMetricRequestPostField($metrics) {
	$requests = '[';
	$metricspieces = explode(",",$metrics);
	if(sizeof($metricspieces) != 0){
		$count = sizeof($metricspieces);
		for($i=0; $i<$count; $i++){
			$metric = $metricspieces[$i];
			if (isset($metric) && $metric != "") {
				$requests .= '{"metric":"'.$metric.'"}';
			}
			if ($i<$count-1) {
				$requests .= ',';
			}
		}
	}
	$requests .= ']';

	//error_log("REQUEST:".$requests);

	return $requests;
}

/**
 * Create a string to represent the request for one or more metrics given in the $metrics parameter.
 * @param $alerttypes one or more alert types to get the metrics for (comma sparated list).
 * @param $cipher to create user ids.
 * @return a string containing the metric request to send to the metrics server
 */
function createAlertMetricRequestPostField($alerttypes, $cipher, $userids="", $root="") {

	$users = "";
	if ($userids != "") {
		$users .= '[';
		$users .= '"main_site:agents/'.urlencode($cipher->encrypt($userids)).'"';
		$users .= ']';
	}
	$alerts = "";
	if ($alerttypes != "") {
		$alerts .= '[';
		$alerttypespieces = explode(",",$alerttypes);
		if(sizeof($alerttypespieces) != 0){
			$count = sizeof($alerttypespieces);
			for($i=0; $i<$count; $i++){
				$alert = $alerttypespieces[$i];
				if (isset($alert) && $alert != "") {
					$alerts .= '"'.$alert.'"';
				}
				if ($i<$count-1) {
					$alerts .= ',';
				}
			}
		}
		//$alerts .= $alerttypes;
		$alerts .= ']';
	}

	$requests = '[{';
	$requests .= '"metric":"alerts",';
	if ($root != "") {
		$requests .= '"root":"'.$root.'",';
	}
	if ($users != "") {
		$requests .= '"users":'.$users.',';
	}
	$requests .= '"types":'.$alerts;
	$requests .= '}]';

	//error_log("REQUEST:".$requests);

	return $requests;
}
