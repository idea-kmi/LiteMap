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
		</div>

		<div id="footer" class="footerback footer bg-light border-top">
			<div class="container-fluid">
				<div class="d-flex d-column p-4 justify-content-between">
					<div class="d-block px-4">
						<span><?php echo $LNG->FOOTER_DEVELOPED_BY; ?> </span>
						<a href="http://idea.kmi.open.ac.uk/" title="<?php echo $LNG->FOOTER_HINT; ?>">
							<img alt="Idea logo" class="footer-logo" src="<?php echo $HUB_FLM->getImagePath('IDea-logo-URL-hi-res.png'); ?>" />
						</a>
					</div>
					<div class="d-block px-4 mb-2 text-end">
						<a href="<?php print($CFG->homeAddress);?>ui/pages/conditionsofuse.php"><?php echo $LNG->FOOTER_TERMS_LINK; ?></a> |
						<a href="http://kmi.open.ac.uk/accessibility/"><?php echo $LNG->FOOTER_ACCESSIBILITY; ?></a> |
						<a href="<?php print($CFG->homeAddress);?>ui/pages/privacy.php"><?php echo $LNG->FOOTER_PRIVACY_LINK; ?></a> |
						<a href="<?php print($CFG->homeAddress);?>ui/pages/cookies.php"><?php echo $LNG->FOOTER_COOKIES_LINK; ?></a> |
						<a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>?subject=<?php echo $CFG->SITE_TITLE; ?>"><?php echo $LNG->FOOTER_CONTACT_LINK; ?></a>
					</div>
				</div>
				<div class="d-block text-center"><small><a href="<?php echo $HUB_FLM->getCodeWebPath('ui/pages/releases.php'); ?>" target="blank">version: <?php echo $CFG->VERSION; ?></a></small></div>
			</div>
		</div>
	</body>


	<script>
		// COOKIES
		document.addEventListener('DOMContentLoaded', function() {
			if (!getCookie('cookieConsent')) {
				document.getElementById('cookieConsent').style.display = 'block';
			}
		});

		document.getElementById('closeCookieConsent').addEventListener('click', function() {
			setCookie('cookieConsent', true, 30);
			document.getElementById('cookieConsent').style.display = 'none';
		});

		function setCookie(name, value, days) {
			var expires = '';
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // 30 days
				expires = '; expires=' + date.toUTCString();
			}
			document.cookie = name + '=' + (value || '') + expires + '; path=/';
		}

		function getCookie(name) {
			var nameEQ = name + '=';
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}		
	</script>
</html>
