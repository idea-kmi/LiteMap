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


class Cipher {

    private $securekey;
    private $iv;
    private $cipher_type = 'AES-256-CBC';

    function __construct($textkey = "", $iv = "") {
    	if ($textkey != "") {
        	$this->securekey = hash('sha256',$textkey,TRUE);
        }

        $len = openssl_cipher_iv_length($this->cipher_type);
        if (!$len) {
            $len = 32;
        }
        $this->iv = openssl_random_pseudo_bytes($len);
    }

    function encrypt($input) {
    	$reply = "";
    	if (isset($this->securekey)) {
		        $encryptedMessage = openssl_encrypt($input, $this->cipher_type, $this->securekey, OPENSSL_RAW_DATA, $this->iv);
		        $reply = base64_encode($encryptedMessage);
    	}
        return $reply;
    }

    function decrypt($input) {
    	$reply = "";
    	if (isset($this->securekey)) {
    		$reply = openssl_decrypt(base64_decode($input), $this->cipher_type, $this->securekey, OPENSSL_RAW_DATA, $this->iv);
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