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

	/**
	 * Log into the site
	 *
	 * @uses $CFG
	 * @param string $email
	 * @param string $password
	 * @return User object if successful else Error object
	 */
	function userLogin($email,$password){
		global $CFG,$ERROR;

		clearSession();

		/** Just in case **/
		if($password == "" || $email == ""){
			$ERROR = new Hub_Error();
			$ERROR->createLoginFailedError();
			return $ERROR;
		}

		$user = new User();
		$user->setEmail($email);
		$user = $user->getByEmail();

		if ($user instanceof User) {
			// make sure this user is an active user
			$status = $user->getStatus();

			if ($status == $CFG->USER_STATUS_ACTIVE || $status == $CFG->USER_STATUS_REPORTED) {

				if (strcmp($user->getAuthType(),$CFG->AUTH_TYPE_EVHUB) == 0) {
					$passwordCheck = $user->validPassword($password);
					if($passwordCheck){
						createSession($user);
						$user->resetInvitationCode(); // hang over from Cohere groups code
						$user->load();
						return $user;
					} else {
						$ERROR = new Hub_Error();
						$ERROR->createLoginFailedError();
						return $ERROR;
					}
				} else {
					$ERROR = new Hub_Error();
					$provider = ucfirst($user->getAuthType());
					$ERROR->createLoginFailedExternalError($provider);
					return $ERROR;
				}
			} else {
				$ERROR = new Hub_Error();
				if ($status == $CFG->USER_STATUS_UNAUTHORIZED) {
					$ERROR->createLoginFailedUnauthorizedError();
				} else if ($status == $CFG->USER_STATUS_SUSPENDED) {
					$ERROR->createLoginFailedSuspendedError();
				} else if ($status == $CFG->USER_STATUS_UNVALIDATED) {
					$ERROR->createLoginFailedUnvalidatedError();
				} else {
					$ERROR->createAccessDeniedError();
				}
				return $ERROR;
			}
		} else {
			$ERROR = new Hub_Error();
			$ERROR->createLoginFailedError();
			return $ERROR;
		}
	}

	// NOTE: THIS IS NOW DONE IN /ui/pages/loginexternal.php
	function loginExternal($provider, &$errors) {
		global $CFG, $LNG;

		clearSession();

		$hybridauth_config = $CFG->dirAddress.'core/lib/hybridauth/config.php';
		require_once( $CFG->dirAddress.'core/lib/hybridauth/autoload.php' );

		try{
			// create an instance for Hybridauth with the configuration file path as parameter
			$hybridauth = new Hybridauth\Hybridauth( $hybridauth_config );

			// try to authenticate the selected $provider
			$adapter = $hybridauth->authenticate( $provider );

			//echo print_r($adapter);

			// grab the user profile
			$user_profile = $adapter->getUserProfile();

			//echo print_r($user_profile);

			$adapter->disconnect();

			return $user_profile;
		}
		catch( Exception $e ){
			// Display the recived error
			switch( $e->getCode() ){
				case 0 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_0; break;
				case 1 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_1; break;
				case 2 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_2; break;
				case 3 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_3; break;
				case 4 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_4; break;
				case 5 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_5; break;
				case 6 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_6;
						$adapter->logout();
						break;
				case 7 : $error = $LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_7;
						$adapter->logout();
						break;
			}

			array_push($errors, $error);

			// well, basically you should not display this to the end user, just give him a hint and move on..
			//$error .= "<br /><br /><b>Original error message:</b> " . $e->getMessage();
			//$error .= "<hr /><pre>Trace:<br />" . $e->getTraceAsString() . "</pre>";

			return false;
		}
	}

	function logoutExternal() {
		global $CFG;

		$hybridauth_config = $CFG->dirAddress.'core/lib/hybridauth/config.php';
		require_once( $CFG->dirAddress.'core/lib/hybridauth/autoload.php' );

		try{
			$hybridauth = new Hybridauth\Hybridauth( $hybridauth_config );

			//logout All Providers;
			$idps = $hybridauth->getConnectedProviders();
			foreach ($idps as $idp) {
				$adapter = Hybrid_Auth::getAdapter($idp);
				$adapter->logout();
			}
		}
		catch( Exception $e ){
			error_log($e->getMessage());
			//echo "<br /><br /><b>Oh well, we got an error :</b> " . $e->getMessage();
			//echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";
		}
	}

	/**
	 * Start a session
	 *
	 * @return string | false
	 */
	function startSession($time = 99999999, $ses = 'litemap') {
		ini_set('session.cache_expire', $time);
		ini_set('session.gc_maxlifetime', '7200'); // two hours

		session_set_cookie_params($time);

		if(session_id() == '') {
			//session_name($ses); // messes up hybridauth - firefox sidebar needs to look for PHPSESSID
			session_start();
		}

		// Reset the expiration time upon page load
		if (isset($_COOKIE[$ses])){
			setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
		}
	}

	/**
	* Clear all session variables
	*
	*/
	function clearSession() {
		$_SESSION["session_userid"] = "";
		setcookie("litemapuser","",time()-3600, "/");
	}

	/**
	 * Create the user session details.
	* (also updates the last login date/time)
	*/
	function createSession($user) {
		$_SESSION["session_userid"] = $user->userid;
		setcookie("litemapuser",$user->userid,time()+99999999,"/");
		$user->updateLastLogin();
	}

	/**
	 * Check that the session is active and valid for the user passed.
	 */
	function validateSession($userid) {
		global $LNG;

		try {
			if (isset($_SESSION["session_userid"]) && $_SESSION["session_userid"] == $userid) {
				return $LNG->CORE_SESSION_OK;
			} else {
				return $LNG->CORE_SESSION_INVALID;
			}
		} catch(Exception $e) {
			return $LNG->CORE_SESSION_INVALID;
		}
	}

	/**
	 * Checks if current user is logged in
	 * if not, they get redirected to homepage
	 *
	 */
	function checkLogin(){
		global $USER,$CFG;
		$url = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		if(!isset($USER->userid) || $USER->userid == ""){
			header('Location: '.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($url));
			exit();
		}
	}

	function checkDashboardAccess($page){
		global $USER,$CFG;
		
		$setting = $page.'_DASHBOARD_VIEW';
		$configuration = $CFG->$setting;
		$isPublic = ($configuration === 'public');
		$isPrivateAndLoggedIn = isset($USER->userid) && $configuration === 'private';

		if (!($isPublic || $isPrivateAndLoggedIn)) {
			header("Location: ".$CFG->homeAddress); 
			exit;
		}				
	}
?>