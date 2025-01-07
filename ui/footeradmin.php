<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2015 - 2024 The Open University UK                            *
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

		<div id="footer" class="footerback footer bg-light border-top collapse multi-collapse show">
			<div class="container-fluid">
				<div class="d-flex d-column p-4 justify-content-between">
					<div class="d-block px-4">
						<span><?php echo $LNG->FOOTER_DEVELOPED_BY; ?> </span>
						<a href="http://idea.kmi.open.ac.uk/">
							<img alt="Idea logo" class="footer-logo" src="<?php echo $HUB_FLM->getImagePath('IDea-logo-URL-hi-res.png'); ?>" />
						</a>
					</div>
					<div class="d-block px-4 mb-2 text-end">
						<a href="<?php print($CFG->homeAddress);?>ui/pages/conditionsofuse.php"><?php echo $LNG->FOOTER_TERMS_LINK; ?></a> |
						<a href="<?php print($CFG->homeAddress);?>ui/pages/accessibility.php"><?php echo $LNG->FOOTER_ACCESSIBILITY; ?></a> |
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

			// Function to check if the user has given consent
			function hasCookieConsent() {
				const consent = localStorage.getItem('cookieConsent');
				return consent !== null;
			}

			// Function to set consent
			function setCookieConsent(consent) {
				localStorage.setItem('cookieConsent', consent);
				document.getElementById('cookieConsent').style.display = 'none';
				if (consent === 'true') {
					location.reload(true); // Reload the page to load Google Analytics
				}
			}

			// Event listeners for the buttons
			document.getElementById('acceptAnlyticsCookies').addEventListener('click', function() {
				setCookieConsent('true');
			});

			document.getElementById('declineAnlyticsCookies').addEventListener('click', function() {
				setCookieConsent('false');
			});			

			if (!hasCookieConsent()) {
				document.getElementById('cookieConsent').style.display = 'block';
				document.getElementById('acceptAnlyticsCookies').focus(); // Focus on the "Yes" button
			}			
		});		
	</script>
</html>