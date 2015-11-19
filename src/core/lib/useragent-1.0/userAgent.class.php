<?php
/**
 * Simple PHP User Agent => $_SERVER['HTTP_USER_AGENT'];
 */
require_once(dirname(__FILE__) . '/userAgentParser.class.php');

class UserAgent {

      protected $userAgentString;
      protected $browserName;
      protected $browserVersion;
      protected $operatingSystem;
      protected $engine;

         public function __construct($userAgentString=null, UserAgentStringParser $userAgentStringParser=null) {

                $this->configureFromUserAgentString($userAgentString, $userAgentStringParser);
         }

         /**
          *  Get Browser name
          *  @param void.
          *  @return String - the browser name    
          */
         public function getBrowserName() {
             return $this->browserName;
         }

         /**
          *  Set Browser name
          *  @param String - the browser name; 
          *  @return none.
          */
         public function setBrowserName($name) {
              $this->browserName = $name;   
         }


         /**
          *  Get Browser version
          *  @param void.
          *  @return String - the browser version
          */

         public function getBrowserVersion() {
              return $this->browserVersion; 
          }

         /**
          *  Set Browser name
          *  @param String - the browser name; 
          *  @return none.
          */

         public function setBrowserVersion($version) {
             $this->browserVersion = $version;
         }


         /**
          *  Get the operating system name
          *  @param void.
          *  @return String - the operating system name
          */
         public function getOperatingSystem() {
             return $this->operatingSystem; 
         }

         /**
          *  Set Operating System name
          *  @param String - the operating system name.
          *  @return none.
          */
         public function setOperatingSystem($os) {
             $this->operatingSystem = $os;
         }
 

         /**
          *  Get the Engine Name
          *  @param void.
          *  @return String the engine name
          */
         public function getEngine() {
             return $this->engine;
         }

         /**
          *  Set Engine name
          *  @param String - the engine name
          *  @return none.
          */
         public function setEngine($engine) {
             $this->engine = $engine;
         }


         /**
          *  Get the User Agent String
          *  @param void.
          *  @return String the User Agent string
          */
         public function getUserAgentString() {
             return $this->userAgentString;
         }

         /**
          *  Set Engine name
          *  @param String - the engine name
          *  @return none.
          */
         public function setUserAgentString($userAgentString) {
             $this->userAgentString = $userAgentString;
         }


         public function __toString() {

             return $this->getFullName();    
         }

         /**
          *  Returns a string combined browser name plus version
          *  @param void.
          *  @return browser name plus version
          */

         public function getFullName() {
             return $this->getBrowserName() . ' ' . 
                    $this->getBrowserVersion() . ' '. 
                    $this->getEngine() . ' '. 
                    $this->getOperatingSystem();
         }

         /**
          *  Convert the http user agent to an array.
          *  @param void.
          */
         public function toArray() {
             return array(
                         'browser_name' => $this->getBrowserName(),
                         'browser_version' => $this->getBrowserVersion(),
                         'operating_system' => $this->getOperatingSystem(),
                         'engine' => $this->getEngine()
                         ); 
         }

         /**
          *  Configure the user agent from an input array.
          *  @param Array $data input data array
          */
         public function fromArray(array $data) {

                $this->setBrowserName($data['browser_name']); 
                $this->setBrowserVersion($data['browser_version']);
                $this->setOperatingSystem($data['operating_system']);
                $this->setEngine($data['engine']);
         }

         /**
          *  This method tells whether this User Agent is unknown or not.
          *  @param none.
          *  @return TRUE is the User Agent is unknown, FALSE otherwise.
          */
         public function isUnknown() {
                return empty($this->browserName); 
         }
        
         /**
          *  Configure the User Agent from a user agent string.
          *  @param  String                 $userAgentString        => the user agent string.
          *  @parem  UserAgentStringParser  $userAgentStringParser  => the parser used to parse the string.   
          */
         public function configureFromUserAgentString($userAgentString, UserAgentStringParser $userAgentStringParser=null) {

                if($userAgentStringParser == null) {
                   $userAgentStringParser = new UserAgentStringParser();
                }
                $this->setUserAgentString($userAgentString);
                $this->fromArray($userAgentStringParser->parse($userAgentString));
         }
}

?>