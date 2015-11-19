<?php
/**
 * ENCODING-ICONV
 * 
 * XML Encoding Detection and Converion to UTF-8
 * Fri Feb 08 21:00:31 GMT 2008
 *
 * @package RSS-PHP
 * @subpackage ENCODING-XML
 * @author <black@rssphp.net>
 * @version 3
 */

/**
 * Check if required constant(s) have been defined
 */
	if(!defined('XML_PHP_ICONV_UNSUPPORTED_LANG_DIE')) {
		define('XML_PHP_ICONV_UNSUPPORTED_LANG_DIE', TRUE);
	}

class encoding_xml {
	public $OriginalXMLEncoding;
	public $xmlEncoding;
	public $xmlStandalone;
	public $xmlVersion;
	private $dieOnUnsupportedLang;

	public function precode($xml=false, $dieOnUnsupportedLang=XML_PHP_ICONV_UNSUPPORTED_LANG_DIE) {
		if($xml) {
			$xml = ltrim($xml,"\xEF\xBB\xBF");
			$this->dieOnUnsupportedLang = $dieOnUnsupportedLang;
			$this->XMLEncoding = 'UTF-8';
		/*	check for XML Declaration */
			$DocumentParts = explode("?>", $xml, 2);
			if(trim($DocumentParts[0]) && substr(trim($DocumentParts[0]),0,2) == '<?') {
			/*	XML Declaration Found: extract xml declaration */
				$XMLDeclaration = $DocumentParts[0];
				$EncodingDocument = $XMLDeclaration."?>\n".'<testEncoding>Test</testEncoding>';
				$DOMDocument = new DOMDocument;
				$DOMDocument->strictErrorChecking = false;
				@$DOMDocument->loadXML($EncodingDocument);
				$this->OriginalXMLEncoding = strtoupper(trim($DOMDocument->xmlEncoding));
				if(!$this->OriginalXMLEncoding) {
				/*	DOM API did not detect an encoding, let's regex to see if one was provided */
					if(preg_match('/encoding="([^"]+)"/',$XMLDeclaration, $preg_encoding)) {
						$this->OriginalXMLEncoding = $preg_encoding[1];
					} else {
					/*	REGEX did not detect an encoding, let's just assume it's UTF-8 and let fix encoding do the work */
						$this->OriginalXMLEncoding = 'UTF-8';
					}
				}
				$this->xmlStandalone = $DOMDocument->xmlStandalone ? 'yes' : 'no';
				$this->xmlVersion = $DOMDocument->xmlVersion;
				$xml = trim($DocumentParts[1]);
			} else {
			/*	XML Declaration NOT Found: generate default declaration */
				$this->OriginalXMLEncoding = 'UTF-8';
				$this->xmlStandalone = 'yes';
				$this->xmlVersion = '1.0';
			}

		/*	do auto conversion of Encoding to UTF-8 */
			$xml = $this->fixEncoding($xml);
		/*	rebuild XML and return with Declaration */
			return '<?xml version="'.$this->xmlVersion.'" encoding="'.$this->XMLEncoding.'" standalone="'.$this->xmlStandalone.'"?>'."\n".$xml;
		}
		return false;
	}

	protected function fixEncoding($in) {
		$iconv_encoding = new encoding_iconv;
		if($iconv_encoding->supported($this->OriginalXMLEncoding)) {
			if($in !== @iconv($this->OriginalXMLEncoding, $this->OriginalXMLEncoding, $in)) {
		/*	the encoding has been set wrong! */
				if($in === @iconv('UTF-8', 'UTF-8', $in)) {
			/*	thankfully it'll pass as UTF-8 */
					return $in;
				} else  {
			/*	we better detect what it is in a trial and error kind of way */
					$encoding = $iconv_encoding->detectEncoding($in);
					if($encoding) {
						return @iconv($encoding, 'UTF-8', $in);
					}
				}
			} else {
			/*	the encoding has been set correctly, let's encode in UTF-8 and return */
				return @iconv($this->OriginalXMLEncoding, 'UTF-8', $in);
			}
		}
	/*	we've still not returned must mean an unsuported type of encoding */
		if($this->dieOnUnsupportedLang) {
		/*	settings specify we should die */
			die('gdo_encoding_xml : The machine you are working on does not support Iconv translation of this documents encoding ['.$this->OriginalXMLEncoding.']. To force vo_encoding_xml to attempt to parse the file without conversion change XML_PHP_ICONV_UNSUPPORTED_LANG_DIE to false.');
		} else {
		/*	we'll attempt to continue anyways! */
			return $in;
		}
	}
}

?>