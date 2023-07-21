<?php
// --------------------------------------------------------
//
//		URL Validation Class
//
// --------------------------------------------------------
//
//	Author:	Kaloyan Kirilov Tzvetkov
//
//	Email:	kaloyan@kaloyan.info
//		mrasnika@hotmail.com
//		mrasnika@1double.com
//
//	Description:
//		This class validates HTTP and FTP URLs,
//		and parses its content to its basic parts:
//			- protocol
//			- user & password
//			- sub domain(s)
//			- domain
//			- TLD (top level domain)
//			- port
//			- path
//			- query
//
//		Composite parts:
//			- domain_name (domain + tld)
//			- host (sub_domain(s) + domain + tld)
//			- SUB_DOMAINS array
//			- PATH array
//



// CONSTANTS DECLARATION
// --------------------------------------------------------
define('MRSNK_URL_DO_NOT_PRINT_ERRORS', 'mrsnk_00001');
define('MRSNK_URL_DO_PRINT_ERRORS', 'mrsnk_00002');

define('MRSNK_URL_DO_NOT_CONNECT_2_URL', 'mrsnk_10001');
define('MRSNK_URL_DO_CONNECT_2_URL', 'mrsnk_10002');


//  var schemeRE = /^([-a-z0-9]|%[0-9a-f]{2})*$/i;
//  var authorityRE = /^([-a-z0-9.]|%[0-9a-f]{2})*$/i;
//  var pathRE = /^([-a-z0-9._~:@!$&'()*+,;=\//#]|%[0-9a-f]{2})*$/i;
//  var qfRE = /^([-a-z0-9._~:@!$&'()*+,;=?\/]|%[0-9a-f]{2})*$/i;
//  var qqRE = /^([-a-z0-9._~:@!$&'\[\]()*+,;=?\/]|%[0-9a-f]{2})*$/i;

// MB: I modified the query. It was 'query'=>'(\?[^? ]*)?'.
// It is now the same as client side. It was letting through <script>

// MB: I modified the tld as it had hardcoded list.
//		tld =>'(com|net|org|edu|gov|mil|int|arpa|aero|biz|coop|info|museum|name|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cf|cd|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|fi|fj|fk|fm|fo|fr|fx|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zr|zw)',

// CLASS DECLARATION
// --------------------------------------------------------
 class mrsnk_URL_validation {

	// Set of regular expression rules for parsing
	// URL and exracting its parts
	var $PATTERNS = array(
		'protocol' => '((http|https|ftp|mailto)://)',
		'access' => '(([a-z0-9_]+):([a-z0-9-_]*)@)?',
		'sub_domain' => '(([a-z0-9_-]+\.)*)',
		'domain' => '(([a-z0-9-]{2,})\.)',
		'tld' =>'([a-z0-9_]+)',
		'port'=>'(:(\d+))?',
		'path'=>'((/[a-z0-9-_.%~]*)*)?',
		'query'=>"(([-a-z0-9._~:@!$&'\[\]()*+,;=?\/]|%[0-9a-f]{2})*)"
		);

	// Set of reporting options for this class.
	// They are triggered, when validation error
	// occurs.
	var $REPORT = array(
		// Defines whether errors will be printed out or
		// not.
		'print_errors' =>MRSNK_URL_DO_NOT_PRINT_ERRORS,

		// If URL validation and parsing is ok, the class
		// will attempt to connect to this URL, and check
		// whether it exists or not.
		//
		//	NB: This feature is not yet implemented
		//
		'connect_to_url' => MRSNK_URL_DO_NOT_CONNECT_2_URL,

		);

	// Errors repository
	var $ERRORS;

	// URL, that will be validated
	var $url;

 // constructor mrsnk_URL_validation()
 // parameters:
 //	URL, which is about to check
 //
 //	OPTION_PRINT_ERROR defines whether errors
 //	will be printed out or not.
 //
 //	OPTION_CONNECT_2_URL, which defines
 //	whether the class will attempt to connect
 //	to the validate URL, and check if it exists
 //	or not.
 //
 function mrsnk_URL_validation(
 		$_url,
 		$_option_print_error = MRSNK_URL_DO_NOT_PRINT_ERRORS,
 		$_option_connect = MRSNK_URL_DO_NOT_CONNECT_2_URL) {

	//check the options
	if (!in_array($_option_print_error, array(
		MRSNK_URL_DO_NOT_PRINT_ERRORS,
		MRSNK_URL_DO_PRINT_ERRORS
		))) {
		$this->error(sprintf("Invalid PRINT_ERROR option [%s]",
			$_option_print_error), __FILE__, __LINE__);
		return;
		} else {
		$this->REPORTS['print_errors'] = $_option_print_error;
		}
	if (!in_array($_option_connect, array(
		MRSNK_URL_DO_NOT_CONNECT_2_URL,
		MRSNK_URL_DO_CONNECT_2_URL
		))) {
		$this->error(sprintf("Invalid CONNECT_2_URL option [%s]",
			$_option_connect), __FILE__, __LINE__);
		return;
		} else {
		$this->REPORTS['connect_to_url'] = $_option_connect;
		}

	//check the url
	if (!$_url) {
		$this->error(sprintf("No URL provided"), __FILE__, __LINE__);
		return;
		} else {
		$this->url = $_url;
		}
	}





//function error()
//	saves the last error in this->ERRORS,
//	and generatres user_error
//
function error($error, $file, $line) {
	$this->ERRORS[] = $error;
	if ($this->REPORTS['print_errors'] == MRSNK_URL_DO_PRINT_ERRORS) {
		printf("<b>%s Error:</b> %s in <b>%s:%d</b><br>",
			strToUpper(get_class($this)),
			htmlSpecialChars($error),
			$file,
			$line);
		}
	}





//function isValid()
//	validates the URL and returns teh result
//
function isValid($_private = NULL) {

	$pattern = "`^"
		.$this->PATTERNS['protocol']
		.$this->PATTERNS['access']
		.$this->PATTERNS['sub_domain']
		.$this->PATTERNS['domain']
		.$this->PATTERNS['tld']
		.$this->PATTERNS['port']
		.$this->PATTERNS['path']
		.$this->PATTERNS['query']
		."$`iU";

	$valid = preg_match($pattern, $this->url, $COMPONENTS);

	//parse for URL components
	if ($_private) {
		return ($valid)?$COMPONENTS:NULL;
	}

	return $valid;
	}





//function parse()
//	validates and parses the URL depending
//	on the provided options
//
function parse() {
  static $_url;
  static $COMPONENTS;

	//flush static
	if($_url != $this->url) {
		$_url = $this->url;
		$_CMPNNTS = $this->isValid(1);
		$COMPONENTS = array(
			protocol => $_CMPNNTS[2],
			user => $_CMPNNTS[4],
			password => $_CMPNNTS[5],
			sub_domain => ereg_replace('\.$', '', $_CMPNNTS[6]),
			SUB_DOMAINS => ($_CMPNNTS[6])
				?explode('.', ereg_replace('\.$', '', $_CMPNNTS[6])):NULL,
			domain => $_CMPNNTS[9],
			tld => $_CMPNNTS[10],
			domain_name => ($_CMPNNTS[9] && $_CMPNNTS[10])?
				$_CMPNNTS[9] . "." . $_CMPNNTS[10]:NULL,
			port => $_CMPNNTS[12],
			host => ($_CMPNNTS[6]
				&& $_CMPNNTS[9]
				&& $_CMPNNTS[10])?$_CMPNNTS[6]
					.$_CMPNNTS[9] . "."
					.$_CMPNNTS[10]:NULL,
			path => $_CMPNNTS[13],
			PATH =>($_CMPNNTS[13])?
				explode('/', ereg_replace('^/(.*)/$', '\\1', $_CMPNNTS[13])):NULL,
			query => $_CMPNNTS[15]
			);
		}
	return $COMPONENTS;
	}
 }
?>