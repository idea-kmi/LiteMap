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
///////////////////////////////////////
// User Class
///////////////////////////////////////

class user {

    private $phpsessid;
    private $authtype;
    private $isadmin;
    private $password;
    private $email;
    private $interest;
    private $testgroup = 0;

	// For spam icon on user lists
    public $status = 0;

    public $userid;
    public $name;
    public $photo;
    public $thumb;
    public $isgroup;

    public $lastlogin;
    public $lastactive;
    public $userfollow;

	public $newsletter = 'N';
    public $location;
    public $countrycode;

    public $style='long';

	//public $recentactivitiesemail = 'N';
    //public $followruninterval;
    //public $followsendemail;
    //public $description;
    //public $creationdate;
    //public $modificationdate;
    //public $privatedata;
    //public $website;
    //public $country;
    //public $locationlat;
    //public $locationlng;
    //public $tags;

    /**
     * Constructor
     *
     * @param string $userid (optional)
     * @return User (this)
     */
    function user($userid = "") {
        if ($userid != ""){
            $this->userid = $userid;
            return $this;
        }
    }

    /**
     * Loads the data for the user from the database
     * This will not return a "group" (even though groups are
     * stored in the Users table)
     *
     * @param String $style (optional - default 'long') may be 'short' or 'long'
     * @return User object (this) (or Error object)
     */
    function load($style='long'){
        global $DB,$USER, $CFG,$ERROR,$HUB_FLM,$HUB_SQL,$HUB_CACHE;

		$this->style = $style;
		if (isset($HUB_CACHE)) {
			$cachedused = $HUB_CACHE->getObjData($this->userid.$style);
			if ($cachedused !== FALSE) {
				return $cachedused;
			}
		}

		$params = array();
		$params[0] = $this->userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_SELECT, $params);

    	if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createUserNotFoundError($this->userid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];

					$this->name = stripslashes($array['Name']);
					$this->isgroup = $array['IsGroup'];
					$this->creationdate = $array['CreationDate'];
					$this->testgroup = $array['TestGroup'];

					if($array['Photo']){
						//set user photo and thumb the thumb creation is done during registration
						$originalphotopath = $HUB_FLM->createUploadsDirPath($this->userid."/".stripslashes($array['Photo']));
						if (file_exists($originalphotopath)) {
							$this->photo =  $HUB_FLM->getUploadsWebPath($this->userid."/".stripslashes($array['Photo']));
							$this->thumb =  $HUB_FLM->getUploadsWebPath($this->userid."/".str_replace('.','_thumb.', stripslashes($array['Photo'])));
							if (!file_exists($this->thumb)) {
								create_image_thumb($array['Photo'], $CFG->IMAGE_THUMB_WIDTH, $this->userid);
							}
						} else {
							//if the file does not exists how to get it from a upper level? change it to
							//if file doesnot exists directly using default photo
							if ($this->isgroup == "Y") {
								$this->photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_GROUP_PHOTO);
								$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_GROUP_PHOTO)));
							} else {
								$this->photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_USER_PHOTO);
								$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_USER_PHOTO)));
							}
						}
					} else {
						if ($this->isgroup == "Y") {
							$this->photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_GROUP_PHOTO);
							$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_GROUP_PHOTO)));
						} else {
							$this->photo =  $HUB_FLM->getUploadsWebPath($CFG->DEFAULT_USER_PHOTO);
							$this->thumb =  $HUB_FLM->getUploadsWebPath(str_replace('.','_thumb.', stripslashes($CFG->DEFAULT_USER_PHOTO)));
						}
					}
					$this->lastlogin = $array['LastLogin'];

					$this->followsendemail = $array['FollowSendEmail'];
					$this->followruninterval = $array['FollowRunInterval'];
					$this->followlastrun = $array['FollowLastRun'];

					if (isset($array['Newsletter'])) {
						$this->newsletter = $array['Newsletter'];
					}

					if (isset($array['RecentActivitiesEmail'])) {
						$this->recentactivitiesemail = $array['RecentActivitiesEmail'];

					}

					if (isset($array['CurrentStatus'])) {
						$this->status = $array['CurrentStatus'];
					}

					if($style=='long'){
						$this->description = stripslashes($array['Description']);
						$this->modificationdate = $array['ModificationDate'];
						$this->privatedata = $array['Private'];
						$this->isadmin = $array['IsAdministrator'];
						$this->authtype = $array['AuthType'];
						$this->password = $array['Password'];
						$this->website = $array['Website'];
						$this->email = $array['Email'];

						if (isset($array['Interest'])) {
							$this->interest = $array['Interest'];
						}

						if(isset($array['LocationText'])){
							$this->location = $array['LocationText'];
						} else {
							$this->location = "";
						}
						if(isset($array['LocationCountry'])){
							$cs = getCountryList();
							$this->countrycode = $array['LocationCountry'];
							if (isset($cs[$array['LocationCountry']])) {
								$this->country = $cs[$array['LocationCountry']];
							}
						} else {
							$this->countrycode = "";
						}

						if(isset($array['LocationLat'])){
							$this->locationlat = $array['LocationLat'];
						}
						if(isset($array['LocationLng'])){
							$this->locationlng = $array['LocationLng'];
						}

						// REPAIR MISSING COODINATES
						if (isset($this->location) && isset($this->countrycode) && $this->location != "" && $this->countrycode != ""
								&& ( (!isset($array['LocationLng']) || $array['LocationLng'] == "") && (!isset($array['LocationLat']) || $array['LocationLat'] == "")) ) {

							$coords = geoCode($this->location,$this->countrycode);
							if(isset($coords["lat"]) && $coords["lat"] != ""
										&& isset($coords["lng"]) && $coords["lng"] != ""){
								$params = array();
								$params[0] = $coords["lat"];
								$params[1] = $coords["lng"];
								$params[2] = $this->userid;
								$res = $DB->insert($HUB_SQL->DATAMODEL_USER_LATLONG_UPDATE, $params);
								$this->locationlat = $coords["lat"];
								$this->locationlng = $coords["lng"];
							}
						}
					}
				}
            }
        } else {
        	return database_error();
        }

		//now add in any tags
		if($style=='long'){
			$params = array();
			$params[0] = $this->userid;
			$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_TAGS, $params);
			if ($resArray !== false) {
				$count = 0;
				if (is_countable($resArray)) {
					$count = count($resArray);
				}
				if ($count > 0) {
					$this->tags = array();
					for ($i=0; $i<$count; $i++) {
						$array = $resArray[$i];
						$tag = new Tag(trim($array['TagID']));
						array_push($this->tags,$tag->load());
					}
				}
			} else {
				return database_error();
			}
		}

        //load the current user's following for this user if any
        $this->userfollow = "N";

		$currentuser = '';
		if (isset($USER->userid)) {
			$currentuser = $USER->userid;
		}

		$params = array();
		$params[0] = $currentuser;
		$params[1] = $this->userid;
		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_FOLLOW, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
        		$this->userfollow = "Y";
        	}
        } else {
        	return database_error();
        }

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->setObjData($this->userid.$style, $this, $CFG->CACHE_DEFAULT_TIMEOUT);
		}
        return $this;
    }

    /**
     * Check whether supplied password matches that in database
     *
     * @param string $password
     * @return boolean
     */
    function validPassword($password){
        global $CFG;

        // can only validate password against cohere auth type users
        if ($this->authtype == $CFG->AUTH_TYPE_EVHUB){
            if(password_verify( $password, $this->password )){
               return true;
            } else {
               return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Load user based on their email address
     *
     * @return User object (this) (or Error object)
     */
    function getByEmail(){
        global $DB,$CFG,$ERROR,$HUB_SQL;

 		$params = array();
 		$params[0] = $this->email;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_BY_EMAIL_SELECT, $params);
 		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
 			if ($count == 0) {
				$ERROR = new Hub_Error;
				$ERROR->createUserNotFoundError($this->userid);
				return $ERROR;
			} else {
				for ($i=0; $i<$count; $i++) {
					$array = $resArray[$i];
					$this->userid =  trim($array['UserID']);
				}
			}
		} else {
			return database_error();
		}

        return $this->load();
    }

    /**
     * Add new users to database
     *
     * @param string $email
     * @param string $name
     * @param string $password
     * @param string $website
     * @param string $isgroup 'Y'/'N'
     * @param string $authtype
     * @param string $description
     * @param string $status
     * @param string $photo
     * @return User object (this) (or Error object)
     */
    function add($email,$name,$password,$website,$isgroup="N",$authtype="",$description="",$status="",$photo=""){

        global $DB,$CFG,$HUB_SQL;

		$params = array();

		if ($isgroup == 'N') {
			$lasttestgroup = $DB->select($HUB_SQL->DATAMODEL_USER_LAST_TEST_GROUP, $params);
		}

        if($isgroup == 'Y' || ($lasttestgroup !== false && isset($lasttestgroup[0]['TestGroup']))) {
			$dt = time();

			// If no authtype passed, set to default value
			if ($authtype == "") {
				$authtype=$CFG->AUTH_TYPE_EVHUB;
			}

			// if no status passed then set to default status
			// must be === otherwise status of 0=active will match
			if ($status === "") {
				$status = $CFG->USER_STATUS_UNVALIDATED;
			}

			// If no photo passed then set to the default one
			if ($photo == "") {
				if ($isgroup == 'Y') {
					$photo = $CFG->DEFAULT_GROUP_PHOTO;
				} else {
					$photo = $CFG->DEFAULT_USER_PHOTO;
				}
			}

			$this->userid = getUniqueID();
			$registrationKey = createRegistrationKey();

			$passwordcrypt = "";
			if ($authtype == $CFG->AUTH_TYPE_EVHUB && $password != "") {
				$passwordcrypt = password_hash($password, PASSWORD_BCRYPT);
			}

			$testGroup = 0;
			if ($isgroup == 'N') {
				$testGroup = 1;
				if ($lasttestgroup[0]['TestGroup'] == 1) {
 					$testGroup = 2;
 				}
			}

			$params[0] = $this->userid;
			$params[1] = $dt;
			$params[2] = $dt;
			$params[3] = $email;
			$params[4] = $name;
			$params[5] = $passwordcrypt;
			$params[6] = $website;
			$params[7] = 'N';
			$params[8] = $dt;
			$params[9] = 'N';
			$params[10] = $isgroup;
			$params[11] = $authtype;
			$params[12] = $description;
			$params[13] = $photo;
			$params[14] = $registrationKey;
			$params[15] = $status;
			$params[16] = $testGroup;

			$res = $DB->insert($HUB_SQL->DATAMODEL_USER_ADD, $params);
			if( !$res ) {
				return database_error();
			} else {
				$this->load();

				// add the default roles for user
				$r = new Role();
				$r->setUpDefaultRoles($this->userid);

				// add default links for user.
				$lt = new LinkType();
				$lt->setUpDefaultLinkTypes($this->userid);

				// add default node for user
				//$n = new CNode();
				//$n->setUpDefaultUserNode($this->userid);

				return $this;
			}
		} else {
		    return database_error();
		}
    }

    /**
     * Update a users name
     *
     * @param string $name
     * @return User object (this) (or Error object)
     */
    function updateName($name){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $name;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_NAME_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->name = $name;
            return $this;
        }
    }

    /**
     *  Update a users desctiption
     *
     * @param string $description
     * @return User object (this) (or Error object)
     */
    function updateDescription($desc){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $desc;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_DESC_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->description = $desc;
            return $this;
        }
    }

    /**
     *  Set a users interest in our site
     *
     * @param string $interest the test they wrote about thier interest.
     * @return User object (this) (or Error object)
     */
    function setInterest($interest){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $interest;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_INTEREST_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->interest = $interest;
            return $this;
        }
    }

    /**
     *  Update a users website
     *
     * @param string $website
     * @return User object (this) (or Error object)
     */
    function updateWebsite($website){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $website;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_WEBSITE_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->website = $website;
            return $this;
        }
    }

    /**
     *  Update a users public/private setting
     *
     * @param string $private
     * @return User object (this) (or Error object)
     */
    function updatePrivate($private){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $private;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_PRIVACY_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->privatedata = $private;
            return $this;
        }
    }

    /**
     *  Update a users photo
     *
     * @param string $photo
     * @return User object (this) (or Error object)
     */
    function updatePhoto($photo){
        global $DB,$HUB_SQL,$HUB_FLM,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$oldphoto = $this->photo;
		$oldthumb = $this->thumb;

		$params = array();
		$params[0] = $photo;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_PHOTO_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
        	// delete any old photos if there are any
            if (isset($oldphoto) && $oldphoto != "") {
            	$basename = basename($oldphoto);
        		$oldirphoto = $HUB_FLM->getUploadsUserDirPath($basename, $this->userid);
        		if ($oldirphoto !== $basename && $basename != $photo) {
	            	unlink($oldirphoto);

					if (isset($oldthumb) && $oldthumb != "") {
						$basename = basename($oldthumb);
						$oldirthumb = $HUB_FLM->getUploadsUserDirPath($basename, $this->userid);
						if ($oldirthumb !== $basename) {
							unlink($oldirthumb);
						}
					}
	            }
            }

        	// need to reload as this parameter is more complex and needs pre-processing
            return $this->load();
        }
    }
    /**
     * Update a users email
     *
     * @param string $email
     * @return boolean true if successful else false.
     */
    function updateEmail($email){
        global $DB,$CFG,$HUB_SQL;

        //can only update email address if it's not already in use
 		$params = array();
 		$params[0] = $email;
 		$params[1] = $this->userid;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_EMAIL_UPDATE_CHECK, $params);
 		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
 			if ($count != 0) {
				return false;
			}
		} else {
			return false;
		}

		$params = array();
		$params[0] = $email;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_EMAIL_UPDATE, $params);
        if( !$res ) {
            return false;
        } else {
			if (!isset($this->authtype)) {
				$this->email = $email;
			}

			// This should not be called for Social Sign on accounts.
			// But just incase....
			if ($this->authtype == $CFG->AUTH_TYPE_EVHUB) {
				// a Change of email address means that it needs revalidating if it is a local account.
				$this->resetRegistrationKey();
			}

			return true;
        }
    }

    /**
     * Update a users password
     *
     * @param string $password
     * @return boolean
     */
    function updatePassword($password){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = password_hash($password, PASSWORD_BCRYPT);
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_PASSWORD_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->password = $password;
            return $this;
        }
    }

    /**
     * Update a users last login date/time
     *
     */
    function updateLastLogin(){
        global $DB,$HUB_SQL,$HUB_CACHE;
        $dt = time();

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $dt;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_LAST_LOGIN_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->lastlogin = $dt;
            $this->updateLastActive($dt);
            return $this;
        }
    }

   /**
     * Update the time the user last did something to now (was active)
     *
     */
    function updateLastActive($time){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $time;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_LAST_ACTIVE_UPDATE, $params);
        if( !$res ) {
            return database_error();
        } else {
            $this->lastactive = $time;
            return $this;
        }
    }


    /**
     * Update the location for this user
     *
     * @return User object (this) (or Error object)
     */
    function updateLocation($location=null,$loccountry=null){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $location;
		$params[1] = $loccountry;
		$params[2] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_LOCATION_UPDATE, $params);
		if ($res) {
			//try to geocode
			if ($location != "" && $loccountry != "" && ($location != $this->location || $loccountry != $this->countrycode)){
				$coords = geoCode($location,$loccountry);
				if($coords["lat"] != "" && $coords["lng"] != ""){
					$params = array();
					$params[0] = $coords["lat"];
					$params[1] = $coords["lng"];
					$params[2] = $this->userid;
					$res = $DB->insert($HUB_SQL->DATAMODEL_USER_LATLONG_UPDATE, $params);
				} else {
					$params = array();
					$params[0] = null;
					$params[1] = null;
					$params[2] = $this->userid;
					$res = $DB->insert($HUB_SQL->DATAMODEL_USER_LATLONG_UPDATE, $params);
				}
			}

	        return $this->load();
		} else {
		 	return database_error();
		}
    }

    /**
     * Set users desire to get email alerts for followed items
     *
     */
    function updateFollowSendEmail($send){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $send;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_FOLLOW_EMAIL_UPDATE, $params);
        if( !$res ) {
            return "";
        } else {
        	$this->followsendemail=$send;
            return $send;
        }
    }

    /**
     * Set run interval for follow email alerts
     *
     */
    function updateFollowRunInterval($interval){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $interval;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_FOLLOW_EMAIL_INTERVAL_UPDATE, $params);
        if( !$res ) {
            return "";
        } else {
        	$this->followruninterval=$interval;
            return $interval;
        }
    }

    /**
     * Set last time email alert run and sent
     *
     */
    function updateFollowLastRun($lastrun){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $lastrun;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_FOLLOW_EMAIL_LAST_RUN_UPDATE, $params);
        if( !$res ) {
            return "";
        } else {
        	$this->followlastrun=$lastrun;
            return $lastrun;
        }
    }

    /**
     * Update if the user is subscribing to the Newsletter
     *
     */
    function updateNewsletter($option){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $option;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_NEWLETTER_EMAIL_UPDATE, $params);
        if( !$res ) {
            return "";
        } else {
        	$this->newsletter=$option;
            return $option;
        }
    }

    /**
     * Update if the user is subscribing to the Newsletter
     *
     */
    function updateRecentActivitiesEmail($option){
        global $DB,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

		$params = array();
		$params[0] = $option;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_RECENT_ACTIVITIES_EMAIL_UPDATE, $params);
        if( !$res ) {
            return "";
        } else {
        	$this->recentactivitiesemail=$option;
            return $option;
        }
    }



    /**
     * get users invitation code
     *
     */
    function getInvitationCode(){
        global $DB,$HUB_SQL;

 		$params = array();
 		$params[0] = $this->userid;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_INVITATION_CODE_SELECT, $params);
 		if ($resArray !== false) {
            return $resArray[0]['InvitationCode'];
        }
        return "";
    }

    /**
     * Set users invitation code
     *
     */
    function setInvitationCode(){
        global $DB,$HUB_SQL;
        $code = getUniqueID();

		$params = array();
		$params[0] = $code;
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_INVITATION_CODE_UPDATE, $params);
        if( !$res ) {
            return "";
        } else {
            return $code;
        }
    }

    /**
     * Reset users invitation code (so once it;s been used it can't be reused)
     * @return true if successful else false.
     */
    function resetInvitationCode(){
        global $DB,$HUB_SQL;

		$params = array();
		$params[0] = '';
		$params[1] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_INVITATION_CODE_RESET, $params);
        if( !$res ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validate users invitation code
     * @return true if successful else false.
     */
    function validateInvitationCode($code){
        global $DB,$HUB_SQL;

 		$params = array();
 		$params[0] = $code;
 		$params[1] = $this->userid;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_INVITATION_CODE_VALIDATE, $params);
 		if (!$resArray) {
            return false;
        } else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if($count == 0){
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Set a registration key for this User
     * @return true if successful else false.
     */
    function resetRegistrationKey(){
        global $DB,$CFG,$HUB_SQL;

		$registrationKey = createRegistrationKey();

		$params = array();
		$params[0] = $registrationKey;
		$params[1] = '0';
		$params[2] = $CFG->USER_STATUS_UNVALIDATED;
		$params[3] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_REGISTRATION_KEY_RESET, $params);
        if( !$res ) {
            return false;
        } else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if($count == 0){
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * Get users registration key
     * @return the registration key or else an empty string.
     */
    function getRegistrationKey(){
        global $DB,$HUB_SQL;

 		$params = array();
 		$params[0] = $this->userid;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_REGISTRATION_KEY_SELECT, $params);
		if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
			if ($count > 0) {
        	    return $resArray[0]['RegistrationKey'];
        	}
		}

        return "";
    }

    /**
     * Validate users registration key belongs to this user
     */
    function validateRegistrationKey($key){
        global $DB,$HUB_SQL;

 		$params = array();
 		$params[0] = $key;
 		$params[1] = $this->userid;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_REGISTRATION_KEY_VALIDATE, $params);
        if(!$resArray) {
            return false;
        } else {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if($count == 0){
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Complete registration by setting the validationKey to match the RegistrationKey
     */
	function completeRegistration($key) {
        global $DB,$CFG,$HUB_SQL;

		$params = array();
		$params[0] = $key;
		$params[1] = $CFG->USER_STATUS_ACTIVE;
		$params[2] = $key;
		$params[3] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_REGISTRATION_COMPLETE, $params);
        if(!$res) {
            return false;
        } else {
        	$this->status = $CFG->USER_STATUS_ACTIVE;
            return true;
        }
	}

	/**
	 * Check if this user account has had thier email address verified.
	 */
	function isEmailValidated() {
        global $DB,$HUB_SQL;

 		$params = array();
 		$params[0] = $this->userid;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_IS_EMAIL_VALIDATED, $params);
        if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
        	if ($count > 0) {
				$registrationKey = $resArray[0]['RegistrationKey'];
				$validationKey = $resArray[0]['ValidationKey'];

				if ($registrationKey != "" && $validationKey != ""
						&& strcmp($registrationKey,$validationKey) == 0){
					return true;
				}
			}
        }
		return false;
	}

    /////////////////////////////////////////////////////
    // getter/setter functions
    // the reason for having these is that the variables are private
    // as we don't want these vars to appear in the REST API output
    // but do need way of setting/getting these variables in other parts
    // of the code
    /////////////////////////////////////////////////////

    /**
     * get PHPSessionID
     *
     * @return string
     */
    function getPHPSessID(){
        return $this->phpsessid;
    }

    /**
     * set PHPSessionID
     *
     * @param string
     */
    function setPHPSessID($phpsessid){
        $this->phpsessid = $phpsessid;
    }

    /**
     * Set email address
     *
     * @param string $email
     */
    function setEmail($email){
        $this->email = $email;
    }

    /**
     * get email address
     *
     * @return string
     */
    function getEmail(){
        return $this->email;
    }

    /**
     * Set AuthType
     *
     * @param string $authtype
     */
    function setAuthType($authtype){
        $this->authtype = $authtype;
    }

    /**
     * get AuthType
     *
     * @return string
     */
    function getAuthType(){
        return $this->authtype;
    }

    /**
     * Set isAdmin
     *
     * @param string $isadmin
     */
    function setIsAdmin($isadmin){
        $this->isadmin = $isadmin;
    }

    /**
     * get isAdmin
     *
     * @return string
     */
    function getIsAdmin(){
        return $this->isadmin;
    }

    /**
     * get TestGroup
     *
     * @return int
     */
    function getTestGroup(){
        return $this->testgroup;
    }

    /**
     * Add a Tag to this url
     *
     * @param string $tagid
     * @return URL object (this) (or Error object)
     */
    function addTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag = $tag->load();
        try {
        	$tag->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();

 		$params = array();
 		$params[0] = $tagid;
 		$params[1] = $this->userid;
 		$resArray = $DB->select($HUB_SQL->DATAMODEL_USER_ADD_TAG_CHECK, $params);
        if ($resArray !== false) {
			$count = 0;
			if (is_countable($resArray)) {
				$count = count($resArray);
			}
            if( $count == 0 ) {
				$params = array();
				$params[0] = $this->userid;
				$params[1] = $tagid;
				$res = $DB->insert($HUB_SQL->DATAMODEL_USER_ADD_TAG, $params);
                if (!$res) {
                	return database_error();
                }
	 	       	return $this->load();
            }
	        return $this;
        } else {
        	return database_error();
        }
    }

    /**
     * Remove a Tag from this user
     *
     * @param string $urlid
     * @return User object (this) (or Error object)
     */
    function removeTag($tagid){
        global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

        //check user can edit the Tag
        $tag = new Tag($tagid);
        $tag = $tag->load();
        try {
        	$tag->canedit();
        } catch (Exception $e){
            return access_denied_error();
        }

        $dt = time();

		$params = array();
		$params[0] = $this->userid;
		$params[1] = $tagid;
		$res = $DB->delete($HUB_SQL->DATAMODEL_USER_DELETE, $params);
        if (!$res) {
            return database_error();
        }

        return $this->load();
    }

	/**
	 * Update the status for this user
	 *
	 * @return User object (this) (or Error object)
	 */
	function updateStatus($status){
	    global $DB,$CFG,$USER,$HUB_SQL,$HUB_CACHE;

		if (isset($HUB_CACHE)) {
			$HUB_CACHE->deleteData($this->userid.$this->style);
		}

	    $dt = time();

		$params = array();
		$params[0] = $status;
		$params[1] = $dt;
		$params[2] = $this->userid;
		$res = $DB->insert($HUB_SQL->DATAMODEL_USER_STATUS_UPDATE, $params);
		if (!$res) {
			return database_error();
		} else {
			$this->status = $status;
		    return $this;
		}
	}

	/**
	 * Return the status for this user
	 *
	 * @return user status
	 */
	function getStatus(){
		return $this->status;
	}

	/**
	 * Set the status for this user in this local object only.
	 */
	function setStatus($status){
		$this->status = $status;
	}

	/**
	 * Return the interest this user originally stated for wanting to join.
	 *
	 * @return user interest
	 */
	function getInterest(){
		return $this->interest;
	}
}

?>
