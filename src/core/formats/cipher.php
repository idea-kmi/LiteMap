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
/* @Author Michelle Bachler Kmi, the Open University */
/*
Modified from the example given on the php manual page
(http://php.net/manual/en/function.mcrypt-encrypt.php),
by 'dylan at wedefy dot com'
*/

class Cipher {

    private $securekey;
    private $iv;

    function __construct($textkey = "", $iv = "") {
    	if ($textkey != "") {
        	$this->securekey = hash('sha256',$textkey,TRUE);
        }

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
    	$this->iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    }

    function encrypt($input) {
    	$reply = "";
    	if (isset($this->securekey)) {
    		$reply = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $input, MCRYPT_MODE_CFB, $this->iv));
    	}
        return $reply;
    }

    function decrypt($input) {
    	$reply = "";
    	if (isset($this->securekey)) {
	    	$reply = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->securekey, base64_decode($input), MCRYPT_MODE_CFB, $this->iv);
	    }
        return trim($reply);
    }

    function getKey() {
    	return $this->securekey;
    }

    function setKey($securekey) {
    	$this->securekey = $securekey;
    }

    function getIV() {
    	return $this->iv;
    }

    function setIV($iv) {
    	$this->iv = $iv;
    }
}