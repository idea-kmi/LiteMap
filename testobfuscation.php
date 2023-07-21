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
	include_once($HUB_FLM->getCodeDirPath("core/formats/cipher.php"));

	$cipher;
	$salt = openssl_random_pseudo_bytes(32);
	$cipher = new Cipher($salt);
	$obfuscationkey = $cipher->getKey();
	$obfuscationiv = $cipher->getIV();

	//CSCP
	$request = $CFG->homeAddress."api/conversations/1371081761300912288001398442436";

	$reply = createObfuscationEntry($obfuscationkey, $obfuscationiv, $request);
?>

<div style="clear:both;"></div>
<div>
<h1>Testing Obfuscation</h1>
<p>Data URL=<?php echo $request."/?id=".$reply['dataid']; ?></p>
<p>User URL=<?php echo $CFG->homeAddress."api/unobfuscatedusers/?id=".$reply['obfuscationid']; ?></p>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>