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

	include_once("config.php");

	//use random_bytes library


    /*if (function_exists('com_create_guid') === true) {
        echo trim(com_create_guid(), '{}');
	} else if (function_exists(random_bytes)) {
		//https://paragonie.com/blog/2015/07/common-uses-for-csprngs-cryptographically-secure-pseudo-random-number-generators
		/**
		 * Note that version 4 follows the format:
		 *     xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx
		 * where y is one of: [8, 9, A, B]
		 *
		 * We use (random_bytes(1) & 0x0F) | 0x40 to force
		 * the first character of hex value to always be 4
		 * in the appropriate position.
		 *
		 * For 4: http://3v4l.org/q2JN9
		 * For Y: http://3v4l.org/EsGSU
		 * For the whole shebang: http://3v4l.org/BkjBc
		 *
		 * @link https://paragonie.com/b/JvICXzh_jhLyt4y3
		 *
		 */
		 echo implode('-', [
			bin2hex(random_bytes(4)),
			bin2hex(random_bytes(2)),
			bin2hex(chr((ord(random_bytes(1)) & 0x0F) | 0x40)) . bin2hex(random_bytes(1)),
			bin2hex(chr((ord(random_bytes(1)) & 0x3F) | 0x80)) . bin2hex(random_bytes(1)),
			bin2hex(random_bytes(6))
		]);


		//http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
		$data = random_bytes(16)
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
		echo vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	} else if (function_exists(openssl_random_pseudo_bytes)) {
		//http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
		$data = openssl_random_pseudo_bytes(16);
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
		echo vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	} else {
		//http://www.php.net/manual/en/function.uniqid.php#94959
		echo sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,
			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}*/


	//https://paragonie.com/blog/2015/07/how-safely-generate-random-strings-and-integers-in-php

	//$token = hash('sha256', rand() . microtime() . $_SERVER['REMOTE_ADDR'])

	include_once($HUB_FLM->getCodeDirPath("ui/headerreport.php"));

?>

<div style="margin:20px;">

<h1>Testing the embeddable</h1>

<!-- p>This is an example of an iframe with a read only map embedded in a page:</p>
<iframe src="http://maptesting.kmi.open.ac.uk/ui/embed/map.php?lang=en&id=1722128760321750001424687160" width="900" height="900" scrolling="no" frameborder="1"></iframe -->

<p>This is an example of an iframe with an editable map embedded in a page:</p>
<iframe src="http://maptesting.kmi.open.ac.uk/ui/embed/editmap.php?lang=en&id=87139107230967326001403875621" width="900" height="700" scrolling="no" frameborder="1"></iframe>

<!-- p>This is an example of an iframe with an editable map embedded in a page:</p>
<iframe src="http://maptesting.kmi.open.ac.uk/ui/embed/editmap.php?lang=en&id=1722128760062067001429704524" width="900" height="700" scrolling="no" frameborder="1"></iframe -->

</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>