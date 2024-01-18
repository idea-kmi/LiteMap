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
///////////////////////////////////////
// UserAuthentication Class
///////////////////////////////////////

class UserAuthentication {

    public $authid;
    public $creationdate;
    private $userid;
    private $provider;
    private $provideruid;
    private $email;

    /**
     * Constructor
     *
     * @param string $userid (optional)
     * @return User (this)
     */
    function userauthentication($authid = "") {
        if ($authid != ""){
            $this->authid = $authid;
            return $this;
        }
    }

    /**
     * Loads the data for a userauthentication item from the database
     *
     * @return User object (this) (or Error object)
     */
    function load(){
        global $DB,$USER,$CFG,$ERROR,$HUB_SQL;

		$params = array();
		$params[0] = $this->authid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_AUTH_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createUserNotFoundError($this->authid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->userid = stripslashes($array['UserID']);
					$this->creationdate = $array['CreationDate'];
					$this->provider = $array['Provider'];
					$this->provideruid = $array['ProviderUID'];
					$this->creationdate = $array['CreationDate'];
					$this->email = $array['Email'];
				}
			}
		} else {
			return database_error();
		}

        return $this;
    }

	/**
	 * Try and load a UserAuthentication account from the gicen provider and provder user id.
	 * @param $provider the provider
	 * @param $userproviderid the user provider id
	 * returns an UserAuthentication instance else return Error;
	 */
	function loadByProvider($provider, $userproviderid) {
		global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $provider;
		$params[1] = $userproviderid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_AUTH_LOAD_BY_PROVIDER, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createUserNotFoundError($this->authid);
				return $ERROR;
			} else {
				//Should only every be one
				$authentication = new UserAuthentication($resArray[0]['AuthID']);
				$authentication->load();
				return $authentication;
			}
		} else {
			return database_error();
		}
	}

    /**
     * Add new user authentication entry to database
     *
     * @param string $userid
     * @param string $provider
     * @param string $provideruid
     * @param string $email (optional, when awaiting validation for Facebook LinkedIn where no email given)
	 * @param $registrationKey (optional, when awaiting validation for Facebook LinkedIn where no email given)
     * @return UserAuthentication object (this) (or Error object)
     */
    function add($userid, $provider, $provideruid, $email="", $registrationKey=""){
        global $DB,$CFG,$HUB_SQL;

        $dt = time();
        $this->authid = getUniqueID();

		$params = array();
		$params[0] = $this->authid;
		$params[1] = $userid;
		$params[2] = $dt;
		$params[3] = $provider;
		$params[4] = $provideruid;
		$params[5] = $email;
		$params[6] = $registrationKey;

		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_AUTH_ADD, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->load();
            return $this;
        }
    }

	function getProvider() {
		return $this->provider;
	}

	function getProviderUID() {
		return $this->provideruid;
	}

	function getUserID() {
		return $this->userid;
	}

    /**
     * Get users registration key
     */
    function getRegistrationKey(){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $this->authid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_AUTH_REGISTRATION_KEY_SELECT, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
        		return $resArray[0]['RegistrationKey'];
			}
        } else {
        	return database_error();
        }
        return "";
    }

    /**
     * Validate users registration key belongs to this user authentication
     * @param string $key
     * @return true if it is else false
     */
    function validateRegistrationKey($key){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $key;
		$params[1] = $this->authid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_AUTH_REGISTRATION_KEY_VALIDATE, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if($count == 0){
            	return false;
            } else {
            	return true;
            }
		} else {
			return false;
		}
    }

    /**
     * Complete registration by setting the validationKey to match the RegistrationKey
     * @param string $key
     * @return true if successful else false;
     */
	function completeVerification($key) {
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $key;
		$params[1] = $key;
		$params[2] = $this->authid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_AUTH_COMPLETE_VERIFICATION, $params);
        if( !$res ) {
            return false;
        } else {
            return true;
        }
	}

	/**
	 * Check if this user authentication account has had their email address verified.
	 */
	function isEmailVerified() {
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = $this->authid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_AUTH_IS_EMAIL_VERIFIRED, $params);
    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$registrationKey = $array['RegistrationKey'];
				$validationKey = $array['ValidationKey'];

				if ($registrationKey != "" && $validationKey != ""
						&& strcmp($registrationKey,$validationKey) == 0){
					return true;
				}
			}
        }
		return false;
	}
}

?>