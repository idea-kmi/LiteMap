<?php
/**
 * ENCODING-ICONV
 * 
 * functional encoding detection - more of a "detect what will not break iconv"
 * also provides access to a list of all the host machines php supported encodings
 * Fri Feb 08 21:00:31 GMT 2008
 *
 * @package RSS-PHP
 * @subpackage ENCODING-ICONV
 * @author <black@rssphp.net>
 * @version 3
 */

class encoding_iconv {

/**
 * register of all available encodings supported by iconv on host machine
 * 
 * @staticvar array
 */
	private static $encodings;
/**
 * Holds whether host machine has alternative naming for ISO-8859-1 Encoding
 *
 * @staticvar boolean
 */
	private static $iso88591Rename;

/**
 * register object as static and populate values on construct
 *
 */
	public function __construct() {
		if (!is_array(self::$encodings)) {
			$this->iso88591Rename = false;
			$this->registerEncodings();
		}
	}
/**
 * register all encodings supported by iconv
 *
 */
	public function registerEncodings() {

		self::$encodings = array();
		/**
		 *  European Languages
		 */
			self::$encodings['ASCII'] = false;
			self::$encodings['ISO-8859-1'] = false;
			self::$encodings['ISO-8859-2'] = false;
			self::$encodings['ISO-8859-3'] = false;
			self::$encodings['ISO-8859-4'] = false;
			self::$encodings['ISO-8859-5'] = false;
			self::$encodings['ISO-8859-7'] = false;
			self::$encodings['ISO-8859-9'] = false;
			self::$encodings['ISO-8859-10'] = false;
			self::$encodings['ISO-8859-13'] = false;
			self::$encodings['ISO-8859-14'] = false;
			self::$encodings['ISO-8859-15'] = false;
			self::$encodings['ISO-8859-16'] = false;

			self::$encodings['KOI8-R'] = false;
			self::$encodings['KOI8-U'] = false;
			self::$encodings['KOI8-RU'] = false;

			self::$encodings['CP1250'] = false;
			self::$encodings['CP1251'] = false;
			self::$encodings['CP1252'] = false;
			self::$encodings['CP1253'] = false;
			self::$encodings['CP1254'] = false;
			self::$encodings['CP1257'] = false;

			self::$encodings['CP850'] = false;
			self::$encodings['CP866'] = false;

			self::$encodings['CP1250'] = false;
			self::$encodings['CP1250'] = false;
			self::$encodings['CP1250'] = false;

			self::$encodings['MacRoman'] = false;
			self::$encodings['MacCentralEurope'] = false;
			self::$encodings['MacIceland'] = false;
			self::$encodings['MacCroatian'] = false;
			self::$encodings['MacRomania'] = false;
			self::$encodings['MacCyrillic'] = false;
			self::$encodings['MacUkraine'] = false;
			self::$encodings['MacGreek'] = false;
			self::$encodings['MacTurkish'] = false;
			self::$encodings['Macintosh'] = false;
		/**
		 *  Semitic Languages
		 */
			self::$encodings['ISO-8859-6'] = false;
			self::$encodings['ISO-8859-8'] = false;
			self::$encodings['CP1255'] = false;
			self::$encodings['CP1256'] = false;
			self::$encodings['CP862'] = false;
			self::$encodings['MacHebrew'] = false;
			self::$encodings['MacArabic'] = false;
		/**
		 *	Japanese Languages
		 */
			self::$encodings['EUC-JP'] = false;
			self::$encodings['SHIFT_JIS'] = false;
			self::$encodings['CP932'] = false;
			self::$encodings['ISO-2022-JP'] = false;
			self::$encodings['ISO-2022-JP-2'] = false;
			self::$encodings['ISO-2022-JP-1'] = false;
		/**
		 *	Chinese Languages
		 */
			self::$encodings['EUC-CN'] = false;
			self::$encodings['HZ'] = false;
			self::$encodings['GBK'] = false;
			self::$encodings['CP936'] = false;
			self::$encodings['GB18030'] = false;
			self::$encodings['EUC-TW'] = false;
			self::$encodings['BIG5'] = false;
			self::$encodings['CP950'] = false;
			self::$encodings['BIG5-HKSCS'] = false;
			self::$encodings['BIG5-HKSCS:2001'] = false;
			self::$encodings['BIG5-HKSCS:1999'] = false;
			self::$encodings['ISO-2022-CN'] = false;
			self::$encodings['ISO-2022-CN-EXT'] = false;
		/**
		 *	Korean Languages
		 */
			self::$encodings['EUC-KR'] = false;
			self::$encodings['CP949'] = false;
			self::$encodings['ISO-2022-KR'] = false;
			self::$encodings['JOHAB'] = false;
		/**
		 *	Armenian
		 */
			self::$encodings['ARMSCII-8'] = false;
		/**
		 *	Georgian
		 */
			self::$encodings['Georgian-Academy'] = false;
			self::$encodings['Georgian-PS'] = false;
		/**
		 *	Tajik
		 */
			self::$encodings['KOI8-T'] = false;
		/**
		 *	Kazakh
		 */
			self::$encodings['PT154'] = false;
			self::$encodings['RK1048'] = false;
		/**
		 *	Thai
		 */
			self::$encodings['ISO-8859-11'] = false;
			self::$encodings['TIS-620'] = false;
			self::$encodings['CP874'] = false;
			self::$encodings['MacThai'] = false;
		/**
		 *	Laotian
		 */
			self::$encodings['MuleLao-1'] = false;
			self::$encodings['CP1133'] = false;
		/**
		 *	Vietnamese
		 */
			self::$encodings['VISCII'] = false;
			self::$encodings['TCVN'] = false;
			self::$encodings['CP1258'] = false;
		/**
		 *	Platform specifics
		 */
			self::$encodings['HP-ROMAN8'] = false;
			self::$encodings['NEXTSTEP'] = false;
		/**
		 *	Full Unicode
		 */
			self::$encodings['UTF-8'] = false;
			self::$encodings['UCS-2'] = false;
			self::$encodings['UCS-2BE'] = false;
			self::$encodings['UCS-2LE'] = false;
			self::$encodings['UCS-4'] = false;
			self::$encodings['UCS-4BE'] = false;
			self::$encodings['UCS-4LE'] = false;
			self::$encodings['UTF-16'] = false;
			self::$encodings['UTF-16BE'] = false;
			self::$encodings['UTF-16LE'] = false;
			self::$encodings['UTF-32'] = false;
			self::$encodings['UTF-32BE'] = false;
			self::$encodings['UTF-32LE'] = false;
			self::$encodings['UTF-7'] = false;
			self::$encodings['C99'] = false;
			self::$encodings['JAVA'] = false;
		/**
		 *	Full Unicode, in terms of uint16_t or uint32_t (with machine dependent endianness and alignment)
		 */
			self::$encodings['UCS-2-INTERNAL'] = false;
			self::$encodings['UCS-4-INTERNAL'] = false;
		/**
		 *	IMB AIX and Similar ISO-8859-1 rename support
		 */	
			self::$encodings['ISO8859-1'] = false;
	/**
	 *	Save Supported Encodings
	 */
		foreach(self::$encodings as $iconv_encoding => $supported) {
			if(@iconv("UTF-8", $iconv_encoding, " ")){
				self::$encodings[$iconv_encoding] = true;
			}
		}
		if(!self::$encodings['ISO-8859-1'] && self::$encodings['ISO8859-1']) {
			self::$iso88591Rename = true;
		}
	}
/**
 * public method to detect whether an encoding is supported by the host machine
 *
 * @param unknown_type $iconv_encoding
 * @return unknown
 */
	public function supported($iconv_encoding) {
		$iconv_encoding = strtoupper(trim($iconv_encoding));
		/* support alternative naming of ISO-8859-1 */
		if(self::$iso88591Rename && $iconv_encoding == 'ISO-8859-1') {
			$iconv_encoding == 'ISO8859-1';
		}
		/* check if encoding is supported */
		if(isset(self::$encodings[$iconv_encoding]) && self::$encodings[$iconv_encoding]) {
			return 1;
		} else {
			return 0;
		}
	}
/**
 * functional encoding detection - more of a "detect what will not break iconv"
 * 
 * note: this function will stop at the first encoding it does not error on!
 * meaning iconv won't error when it converts the encoding
 *
 * @param string $in
 * @return string Detected Encoding
 */
	public function detectEncoding($in) {
		$encoding = false;
		foreach(self::$encodings as $iconv_encoding => $supported) {
			if($supported) {
				if($in === @iconv($iconv_encoding, $iconv_encoding, $in)) {
					$encoding = $iconv_encoding;
					break;
				}
			}
		}
		return $encoding;
	}
}

?>