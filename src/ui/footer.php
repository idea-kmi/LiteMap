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
?>
</div> <!-- end innertube -->
</div> <!-- end content -->
</div> <!-- end contentwrapper -->
</div> <!-- end main -->

<div id="footer" style="height:60px;" class="footerback">
	<div style="height:25px; margin-left: 15px; margin-right: 10px; margin-top: 20px;">
		<div style="float:right;border:margin-right:5px;">
			<div style="clear:both;float:right; line-height:14px; margin-top:10px;">
				<a href="<?php print($CFG->homeAddress);?>ui/pages/conditionsofuse.php"><?php echo $LNG->FOOTER_TERMS_LINK; ?></a> |
				<a href="<?php print($CFG->homeAddress);?>ui/pages/privacy.php"><?php echo $LNG->FOOTER_PRIVACY_LINK; ?></a> |
				<a href="<?php print($CFG->homeAddress);?>ui/pages/cookies.php"><?php echo $LNG->FOOTER_COOKIES_LINK; ?></a> |
				<a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>"><?php echo $LNG->FOOTER_CONTACT_LINK; ?></a>
			</div>
		</div>
	</div>
	<div style="margin:0 auto; margin-top:5px;margin-bottom:5px;width:95px;clear:both;float;left;font-style:italic;font-weight:bold"><a href="<?php echo $HUB_FLM->getCodeWebPath('ui/pages/releases.php'); ?>" target="blank">(v <?php echo $CFG->VERSION; ?>)</a></div>
</div>

<!-- /div -->
</body>
</html>