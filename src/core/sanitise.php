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
 * Sanitise library
 * Functions to santiased passed parameters
 */

/**
 * PARAM_INT - integers only, use when expecting only numbers.
 */
define('PARAM_INT',  1);

/**
 * PARAM_ALPHA - contains only english letters.
 */
define('PARAM_ALPHA', 2);

 /**
 * PARAM_TEXT - general plain text compatible with multilang filter, no other html tags.
 */
define('PARAM_TEXT', 3);

/**
 * PARAM_PATH - safe relative path name, all dangerous chars are stripped, protects against XSS, SQL injections and directory traversals
 * note: the leading slash is not removed, window drive letter is not allowed
 */
define('PARAM_PATH',  4);

/**
 * PARAM_URL - expected properly formatted URL. Please note that domain part is required, http://localhost/ is not acceppted but http://localhost.localdomain/ is ok.
 */
define('PARAM_URL', 5);

/**
 * PARAM_BOOL - converts input into 0 or 1, use for switches in forms and urls.
 */
define('PARAM_BOOL', 6);

/**
 * PARAM_HTML - keep the HTML as HTML
 * note: do not forget to addslashes() before storing into database!
 */
define('PARAM_HTML', 7);

/**
 * PARAM_ALPHANUM - expected numbers and letters only.
 */
define('PARAM_ALPHANUM', 8);

/**
 * PARAM_ALPHAEXT the same contents as PARAM_ALPHA plus the chars in quotes: "/-_" allowed,
 */
define('PARAM_ALPHAEXT', 9);

/**
 * PARAM_BOOL - checks input is an allowed boolean type (true,false,yes,no,on,off,0,1).
 */
define('PARAM_BOOLTEXT', 10);

/**
 * PARAM_NUMBER - returns float, use when expecting only numbers.
 */
define('PARAM_NUMBER',  12);

/**
 * PARAM_EMAIL- checks the string is an email address format.
 */
define('PARAM_EMAIL', 13);

/**
 * PARAM_XML - checks the string is an xml.
 */
define('PARAM_XML', 14);

/**
 * PARAM_ALPHANUMEXT the same contents as PARAM_ALPHANUM plus the chars: "-" and "_" are allowed.
 * Used for ids mostly
 */
define('PARAM_ALPHANUMEXT', 15);


/**
 * Returns a cleaned version of the given parameter value.
 *
 * @param string $param the value to clean
 * @param int $type expected type of the value
 * @return mixed
 */
function check_param($param, $type=PARAM_ALPHAEXT) {
    global $CFG, $HUB_FLM;

    if (!isset($param) || $param == "") {
         $ERROR = new error;
         $ERROR->createRequiredParameterError($parname);
         include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
         die;
    }

    return clean_param($param, $type);
}


/**
 * Returns a particular value for the named variable, taken from
 * POST or GET.  If the parameter does not exist then an error is
 * thrown because we require this variable.
 *
 * @param string $parname the name of the page parameter we want
 * @param int $type expected type of parameter
 * @return mixed
 */
function required_param($parname, $type=PARAM_ALPHAEXT) {
    global $CFG, $HUB_FLM;

    if (isset($_POST[$parname])) {
        $param = $_POST[$parname];
    } else if (isset($_GET[$parname])) {
        $param = $_GET[$parname];
    } else {
         global $ERROR;
         $ERROR = new error;
         $ERROR->createRequiredParameterError($parname);
         include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
         die;
    }

    return clean_param($param, $type);
}

/**
 * Returns a particular value for the named variable, taken from
 * POST or GET, otherwise returning a given default.
 *
 * @param string $parname the name of the page parameter we want
 * @param mixed  $default the default value to return if nothing is found
 * @param int $type expected type of parameter
 * @return mixed
 */
function optional_param($parname, $default=NULL, $type=PARAM_ALPHAEXT) {
    if (isset($_POST[$parname])) {
        $param = $_POST[$parname];
    } else if (isset($_GET[$parname])) {
        $param = $_GET[$parname];
    } else {
        return $default;
    }

    return clean_param($param, $type);
}

/**
 * Clean the passed parameter
 *
 * @param mixed $param the variable we are cleaning
 * @param int $type expected format of param after cleaning.
 * @return mixed
 */
function clean_param($param, $type) {

    global $CFG,$ERROR, $HUB_FLM;

    if (is_array($param)) {
        $newparam = array();
        foreach ($param as $key => $value) {
            $newparam[$key] = clean_param($value, $type);
        }
        return $newparam;
    }

    switch ($type) {

        case PARAM_TEXT:    // leave only tags needed for multilang
            if (is_numeric($param)) {
                return $param;
            }

            $param = stripslashes($param);
            $param = clean_text($param);
			$param = strip_tags($param, '<lang><span>');

			$param = str_replace('+', '&#43;', $param);
			$param = str_replace('(', '&#40;', $param);
			$param = str_replace(')', '&#41;', $param);
			$param = str_replace('=', '&#61;', $param);
			$param = str_replace('"', '&quot;', $param);
			$param = str_replace('\'', '&#039;', $param);

            return   $param;

        case PARAM_HTML:    // keep as HTML, no processing
            $param = stripslashes($param);
            $param = clean_text($param);
            return trim($param);

        case PARAM_INT:
            return (int)$param;

        case PARAM_NUMBER:
            return (float)$param;

        case PARAM_ALPHA:        // Remove everything not a-z
            return preg_replace('/([^a-zA-Z])/i', '', $param);

        case PARAM_ALPHANUM:     // Remove everything not a-zA-Z0-9
            return preg_replace('/([^A-Za-z0-9])/i', '', $param);

        case PARAM_ALPHAEXT:     // Remove everything not a-zA-Z/_-
            return preg_replace('/([^a-zA-Z\/_-])/i', '', $param);

        case PARAM_ALPHANUMEXT:     // Remove everything not a-zA-Z0-9_-
            return preg_replace('/([^a-zA-Z0-9_-])/i', '', $param);

        case PARAM_BOOL:         // Convert to 1 or 0
            $tempstr = strtolower($param);
            if ($tempstr == 'on' or $tempstr == 'yes' or $tempstr == 'true') {
                $param = 1;
            } else if ($tempstr == 'off' or $tempstr == 'no' or $tempstr == 'false') {
                $param = 0;
            } else {
                $param = empty($param) ? 0 : 1;
            }
            return $param;

        case PARAM_BOOLTEXT:         // check is an allowed text type boolean
            $tempstr = strtolower($param);
            if ($tempstr == 'on' or $tempstr == 'yes' or $tempstr == 'true' or
            	 $tempstr == 'off' or $tempstr == 'no' or $tempstr == 'false' or $tempstr == '0' or $tempstr == '1') {
            	$param = $param;
            } else {
                $param = "";
            }
            return $param;

        case PARAM_PATH:         // Strip all suspicious characters from file path
            $param = str_replace('\\\'', '\'', $param);
            $param = str_replace('\\"', '"', $param);
            $param = str_replace('\\', '/', $param);
            $param = ereg_replace('[[:cntrl:]]|[<>"`\|\':]', '', $param);
            $param = ereg_replace('\.\.+', '', $param);
            $param = ereg_replace('//+', '/', $param);
            return ereg_replace('/(\./)+', '/', $param);

        case PARAM_URL:

			if (!filter_var($param, FILTER_VALIDATE_URL) === false) {
				// all is ok, param is respected
			} else {
				$param =''; // not really ok
			}

            /*
            include_once($CFG->dirAddress .'core/lib/url-validation.class.php');

            $URLValidator = new mrsnk_URL_validation($param, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
           	if (!empty($param) && $URLValidator->isValid()) {
               // all is ok, param is respected
            } else {
                $param =''; // not really ok
			}
			*/

            return $param;

 		case PARAM_EMAIL:
		    if(validEmail($param)) {
		        return $param;
		    } else {
				 $ERROR = new error;
				 $ERROR->createInvalidEmailError();
            	 include_once($HUB_FLM->getCodeDirPath("core/formaterror.php"));
				 die;
		    }

 		case PARAM_XML:
 			$param = parseFromXML($param);
 			return $param;

        default:
            include_once($HUB_FLM->getCodeDirPath("core/formaterror.php"));
            $ERROR = new error;
            $ERROR->createInvalidParameterError($type);
            die;
    }
}

/**
 * Check whether a string looks like a valid email address
 *
 * @param string $email
 * @return boolean
 */
function validEmail($email){
    if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email)) {
        return true;
    } else {
        return false;
    }
}

/**
 * fixMSWord
 *
 * Replace ascii chars with utf8. Note there are ascii characters that don't
 * correctly map and will be replaced by spaces.
 *
 * @author      Robin Cafolla
 * @date        2013-03-22
 * @Copyright   (c) 2013 Robin Cafolla
 * @licence     MIT (x11) http://opensource.org/licenses/MIT
 */
function fixMSWord($string) {
    $map = Array(
        '33' => '!', '34' => '"', '35' => '#', '36' => '$', '37' => '%', '38' => '&', '39' => "'", '40' => '(', '41' => ')', '42' => '*',
        '43' => '+', '44' => ',', '45' => '-', '46' => '.', '47' => '/', '48' => '0', '49' => '1', '50' => '2', '51' => '3', '52' => '4',
        '53' => '5', '54' => '6', '55' => '7', '56' => '8', '57' => '9', '58' => ':', '59' => ';', '60' => '<', '61' => '=', '62' => '>',
        '63' => '?', '64' => '@', '65' => 'A', '66' => 'B', '67' => 'C', '68' => 'D', '69' => 'E', '70' => 'F', '71' => 'G', '72' => 'H',
        '73' => 'I', '74' => 'J', '75' => 'K', '76' => 'L', '77' => 'M', '78' => 'N', '79' => 'O', '80' => 'P', '81' => 'Q', '82' => 'R',
        '83' => 'S', '84' => 'T', '85' => 'U', '86' => 'V', '87' => 'W', '88' => 'X', '89' => 'Y', '90' => 'Z', '91' => '[', '92' => '\\',
        '93' => ']', '94' => '^', '95' => '_', '96' => '`', '97' => 'a', '98' => 'b', '99' => 'c', '100'=> 'd', '101'=> 'e', '102'=> 'f',
        '103'=> 'g', '104'=> 'h', '105'=> 'i', '106'=> 'j', '107'=> 'k', '108'=> 'l', '109'=> 'm', '110'=> 'n', '111'=> 'o', '112'=> 'p',
        '113'=> 'q', '114'=> 'r', '115'=> 's', '116'=> 't', '117'=> 'u', '118'=> 'v', '119'=> 'w', '120'=> 'x', '121'=> 'y', '122'=> 'z',
        '123'=> '{', '124'=> '|', '125'=> '}', '126'=> '~', '127'=> ' ', '128'=> '&#8364;', '129'=> ' ', '130'=> ',', '131'=> ' ', '132'=> '"',
        '133'=> '.', '134'=> ' ', '135'=> ' ', '136'=> '^', '137'=> ' ', '138'=> ' ', '139'=> '<', '140'=> ' ', '141'=> ' ', '142'=> ' ',
        '143'=> ' ', '144'=> ' ', '145'=> "'", '146'=> "'", '147'=> '"', '148'=> '"', '149'=> '.', '150'=> '-', '151'=> '-', '152'=> '~',
        '153'=> ' ', '154'=> ' ', '155'=> '>', '156'=> ' ', '157'=> ' ', '158'=> ' ', '159'=> ' ', '160'=> ' ', '161'=> '¡', '162'=> '¢',
        '163'=> '£', '164'=> '¤', '165'=> '¥', '166'=> '¦', '167'=> '§', '168'=> '¨', '169'=> '©', '170'=> 'ª', '171'=> '«', '172'=> '¬',
        '173'=> '­', '174'=> '®', '175'=> '¯', '176'=> '°', '177'=> '±', '178'=> '²', '179'=> '³', '180'=> '´', '181'=> 'µ', '182'=> '¶',
        '183'=> '·', '184'=> '¸', '185'=> '¹', '186'=> 'º', '187'=> '»', '188'=> '¼', '189'=> '½', '190'=> '¾', '191'=> '¿', '192'=> 'À',
        '193'=> 'Á', '194'=> 'Â', '195'=> 'Ã', '196'=> 'Ä', '197'=> 'Å', '198'=> 'Æ', '199'=> 'Ç', '200'=> 'È', '201'=> 'É', '202'=> 'Ê',
        '203'=> 'Ë', '204'=> 'Ì', '205'=> 'Í', '206'=> 'Î', '207'=> 'Ï', '208'=> 'Ð', '209'=> 'Ñ', '210'=> 'Ò', '211'=> 'Ó', '212'=> 'Ô',
        '213'=> 'Õ', '214'=> 'Ö', '215'=> '×', '216'=> 'Ø', '217'=> 'Ù', '218'=> 'Ú', '219'=> 'Û', '220'=> 'Ü', '221'=> 'Ý', '222'=> 'Þ',
        '223'=> 'ß', '224'=> 'à', '225'=> 'á', '226'=> 'â', '227'=> 'ã', '228'=> 'ä', '229'=> 'å', '230'=> 'æ', '231'=> 'ç', '232'=> 'è',
        '233'=> 'é', '234'=> 'ê', '235'=> 'ë', '236'=> 'ì', '237'=> 'í', '238'=> 'î', '239'=> 'ï', '240'=> 'ð', '241'=> 'ñ', '242'=> 'ò',
        '243'=> 'ó', '244'=> 'ô', '245'=> 'õ', '246'=> 'ö', '247'=> '÷', '248'=> 'ø', '249'=> 'ù', '250'=> 'ú', '251'=> 'û', '252'=> 'ü',
        '253'=> 'ý', '254'=> 'þ', '255'=> 'ÿ'
    );

    $search = Array();
    $replace = Array();

    foreach ($map as $s => $r) {
        $search[] = chr((int)$s);
        $replace[] = $r;
    }

    return str_replace($search, $replace, $string);
}

function demicrosoftize($str) {

    return strtr($str,
		array(
			"\x82" => "'",
			"\x83" => "f",
			"\x84" => "\"",
			"\x85" => "...",
			"\x86" => "+",
			"\x87" => "#",
			"\x89" => "^",
			"\x8a" => "\xa6",
			"\x8b" => "<",
			"\x8c" => "\xbc",
			"\x8e" => "\xb4",
			"\x91" => "'",
			"\x92" => "'",
			"\x93" => "\"",
			"\x94" => "\"",
			"\x95" => "*",
			"\x96" => "-",
			"\x97" => "--",
			"\x98" => "~",
			"\x99" => "(TM)",
			"\x9a" => "\xa8",
			"\x9b" => ">",
			"\x9c" => "\xbd",
			"\x9e" => "\xb8",
			"\x9f" => "\xbe"));
}

/**
 * Clean up the given text
 *
 * @param string $text The text to be cleaned
 * @return string The clean text
 */
function clean_text($text) {

	global $CFG;

    if (empty($text) or is_numeric($text)) {
       return (string)$text;
    }

	/// Fix non standard entity notations
	$text = preg_replace('/(&#[0-9]+)(;?)/i', "\\1;", $text);
	$text = preg_replace('/(&#x[0-9a-fA-F]+)(;?)/i', "\\1;", $text);

	$text = demicrosoftize($text);

	//$text = swapMicrosoftChars($text);

	require_once($CFG->dirAddress .'core/lib/htmlpurifier-4.5.0/library/HTMLPurifier.auto.php');

    $config = HTMLPurifier_Config::createDefault();

    $config->set('Core.Encoding', 'utf-8'); // replace with your encoding
    $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');

	$config->set('HTML.SafeIframe', true);
	$config->set('HTML.SafeEmbed', true);
    $config->set('HTML.SafeObject', true);
    $config->set('Output.FlashCompat', true);
    $config->set('HTML.FlashAllowFullScreen', true);
    //$config->set('HTML.Allowed', 'object[id|codebase|align|classid|width|height|data],param[name|value],embed[src|quality|bgcolor|name|align|pluginspage|type|allowscriptaccess|width|height|wmode|flashvars]');

	$safeurls = '%^(http:|https:)?//(';

	if (isset($CFG->safeurls)) {
		$count = sizeof($CFG->safeurls);
		for ($i=0; $i<$count;$i++) {
			if ($i == 0) {
				$safeurls .= $CFG->safeurls[$i];
			} else {
				$safeurls .= "|".$CFG->safeurls[$i];
			}
		}
	} else {
		$safeurls .= 'www.youtube.com/embed/';
		$safeurls .= '|player.vimeo.com/video/';
		$safeurls .= '|cohere.open.ac.uk/';
		$safeurls .= '|www.ustream.tv/';
		$safeurls .= '|www.schooltube.com/';
		$safeurls .= '|archive.org/';
		$safeurls .= '|www.blogtv.com/';
		$safeurls .= '|uk.video.yahoo.com/';
		$safeurls .= '|www.teachertube.com/';
		$safeurls .= '|sciencestage.com/';
		$safeurls .= '|www.flickr.com/';
	}

	$safeurls .= ')%';

	$config->set('URI.SafeIframeRegexp', $safeurls);

	$def = $config->getHTMLDefinition(true);
	$def->addAttribute('object', 'flashvars', 'CDATA');
	$def->addAttribute('object', 'classid', 'CDATA');
	$def->addAttribute('object', 'codebase', 'CDATA');
	$def->addAttribute('object', 'id', 'CDATA');
	$def->addAttribute('object', 'align', 'CDATA');

	// already handled.
	//$def->addAttribute('embed', 'src', 'URI#embedded');

	$def->addAttribute('embed', 'quality', 'CDATA');
	$def->addAttribute('embed', 'name', 'CDATA');
	$def->addAttribute('embed', 'pluginspage', 'CDATA');
	$def->addAttribute('embed', 'align', 'CDATA');
	$def->addAttribute('embed', 'bgcolor', 'CDATA');

	$embedFilter = new HTMLPurifier_URIFilter_SafeEmbed();
	$embedFilter->setRegularExpression($safeurls);

	$objectFilter = new HTMLPurifier_URIFilter_SafeObject();
	$objectFilter->setRegularExpression($safeurls);

	$uri = $config->getDefinition('URI');
	$uri->addFilter($embedFilter, $config);
	$uri->addFilter($objectFilter, $config);

    $purifier = new HTMLPurifier($config);

    $text=$purifier->purify($text);
	return $text;
}

/**
 * Convert the given string to the given encoding
 *
 * Taken from http://php.net/manual/en/function.mb-convert-encoding.php
 * by  aaron at aarongough dot com
 */
function character_convert_to( $source, $target_encoding ) {
    // detect the character encoding of the incoming file
    $encoding = mb_detect_encoding( $source, "auto" );

    // escape all of the question marks so we can remove artifacts from
    // the unicode conversion process
    $target = str_replace( "?", "[question_mark]", $source );

    // convert the string to the target encoding
    $target = mb_convert_encoding( $target, $target_encoding, $encoding);

    // remove any question marks that have been introduced because of illegal characters
    $target = str_replace( "?", "", $target );

    // replace the token string "[question_mark]" with the symbol "?"
    $target = str_replace( "[question_mark]", "?", $target );

    return $target;
}

/**
 * Replace reserved chars with their XML entity equivalents
 *
 * @param string $xmlStr
 * @return string
 */
function parseToXML($xmlStr) {
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    $xmlStr=str_replace('<','&lt;',$xmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    return $xmlStr;
}

/**
 * Replace XML entities with their character equivalents
 *
 * @param string $text
 * @return string
 */
function parseFromXML($text) {
    $text = str_replace("&amp;", "&", $text);
    $text = str_replace("&lt;", "<", $text);
    $text = str_replace("&gt;", ">", $text);
    $text = str_replace("&quot;", '"', $text);
    $text = str_replace("&#039;", "'", $text);
    return $text;
}
?>