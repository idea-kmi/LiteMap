<?php

    /**
     *  PHP Class User Agent Parser
     */

    class UserAgentStringParser {

         /**
          *  Parse a user agent string.
          *
          *  @param  (String) $userAgentString - defaults to $_SERVER['USER_AGENT'] if empty
          *  @return Array(
          *                'browser_name'     => 'firefox',
          *                'browser_version'  => '3.6',
          *                'operating_system' => 'Linux'
          *               );
          *
          */
          public function parse($userAgentString = null) {

                 if(!$userAgentString) {
                     $userAgentString = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
                 }


                 //parse quickly with medium accuracy
                 $informations = $this->doParse($userAgentString);

                 foreach($this->getFilters() as $filter) {
                         $this->$filter($informations);
                 }

             return $informations;

          }

          /**
           *  Detect quickly informations from the user agent string.
           *
           *  @param  (String) $userAgentString => user agent string.
           *  @return (Array)  $information     => user agent informations directly in array.
           */
           public function doParse($userAgentString) {

                  $userAgent = array(
                                 'string'           => $this->cleanUserAgentString($userAgentString),
                                 'browser_name'     => null,
                                 'browser_version'  => null,
                                 'operating_system' => null,
                                 'engine'           => null
                               );

                  if(empty($userAgent['string'])) {
                       return $userAgent;
                  }


                  //Build regexp that matches phrases for known browsers
                  //e.g. "Firefox/2.0" or "MSIE 6.0" 2.0.0.6 is parsed as simply 2.0
                  $pattern = '#('. join("|", $this->getKnownBrowsers()) .')[/ ]+([0-9]+(?:\.[0-9]+)?)#';

                  //find all phrases (if return empty array if none found)
                  if(preg_match_all($pattern, $userAgent['string'], $matches)) {

                     $i = count($matches[1])-1;

                     if(isset($matches[1][$i])) {
                           $userAgent['browser_name'] = $matches[1][$i];
                     }

                     if(isset($matches[2][$i])) {
                           $userAgent['browser_version'] = $matches[2][$i];
                     }
                   }

                  //find operating system
                  $pattern = '#'. join("|", $this->getKnownOperatingSystems()) .'#';
                  if(preg_match($pattern, $userAgent['string'], $match)) {
                     if(isset($match[0])) {
                        $userAgent['operating_system'] = $match[0];
                     }
                  }


                  //find browser's engine
                  $pattern = '#'. join("|", $this->getKnownEngines()) .'#';
                  if(preg_match($pattern, $userAgent['string'], $match)) {
                     if(isset($match[0])) {
                        $userAgent['engine'] = $match[0];
                     }
                  }

               return $userAgent;
           }

          /**
           *  Make user agent string lowercase, and replace browser aliases.
           *
           *  @param String $userAgentString => the dirty user agent string.
           *  @param String $userAgentString => the clean user agent string.
           */

           public function cleanUserAgentString($userAgentString) {

              //clean up the string
              $userAgentString = trim(strtolower($userAgentString));

              //replace browser names with their aliases
              $userAgentString = strtr($userAgentString, $this->getKnownBrowserAliases());

              //replace operating system names with their aliases
              $userAgentString = strtr($userAgentString, $this->getKnownOperatingSystemAliases());


              //replace engine names with their aliases
              $userAgentString = strtr($userAgentString, $this->getKnownEngineAliases());

             return $userAgentString;
           }

           /**
             *  Get the list of filters that get called when parsing a user agent
             *
             *  @param void.
             *  @return array list of valid callables.
             */
             public function getFilters() {
                return array(
                             'filterGoogleChrome',
                             'filterSafariVersion',
                             'filterOperaVersion',
                             'filterYahoo',
                             'filterMsie'
                            );
             }

           /**
             *  Add a filter to be called when parsing  a user agent.
             *
             *  @param  $filter (String) name of the filter method.
             *  @return void.
             */
             public function addFilter($filter) {
                $this->filters += $filter;
             }


           /**
             *  Get known browsers
             *
             *  @param void.
             *  @return Array of browsers
             */
           protected function getKnownBrowsers() {

              return array(
                          'msie',
                          'firefox',
                          'safari',
                          'webkit',
                          'opera',
                          'netscape',
                          'konqueror',
                          'gecko',
                          'chrome',
                          'iphone',
                          'applewebkit'
                          /*'msnbot',
                          'mojeekbot',
                          'googlebot',*/
                          );
           }


           /**
             *  Get known browser aliases
             *
             *  @param void.
             *  @return array => the browser aliases
             */
           protected function getKnownBrowserAliases() {

              return array(
                          'shiretoko'       => 'firefox',
                          'namoroka'        => 'firefox',
                          'shredder'        => 'firefox',
                          'minefield'       => 'firefox',
                          'granparadiso'    => 'firefox'
                          );
           }


           /**
             *  Get known operating system.
             *
             *  @param void.
             *  @return array => the operating system.
             */
           protected function getKnownOperatingSystems() {

              return array('windows',
                           'macintosh',
                           'linux',
                           'freebsd',
                           'unix',
                           'iphone'
                           );
           }


           /**
             *  Get known operating system aliases.
             *
             *  @param void.
             *  @return array => the operating system aliases.
             */
           protected function getKnownOperatingSystemAliases() {

              return array();
           }


           /**
             *  Get known engines
             *
             *  @param void.
             *  @return array => the engines
             */
           protected function getKnownEngines() {

              return array('gecko',
                           'webkit',
                           'trident',
                           'presto'
                           );
           }


           /**
             *  Get known engines aliases
             *
             *  @param void.
             *  @return array => the engines aliases
             */
           protected function getKnownEngineAliases() {

              return array();
           }


           /**
            *  Filters
            */

            /**
              *  MSIE does not always declare its engine
              */
            protected function filterMsie(array &$userAgent) {
                      if(isset($userAgent['browse_name'])
                      		&& $userAgent['browse_name'] === 'msie' && empty($userAgent['engine'])) {
                         $userAgent['engine'] = 'trident';
                      }
            }


            /**
              *  Yahoo bot has a special user agent string
              */
            protected function filterYahoo(array &$userAgent) {
                     if( $userAgent['browser_name'] === null && strpos($userAgent['string'], 'yahoo! slurp')) {
                         $userAgent['browser_name'] = 'yahoobot';
                     }
            }

            /**
              *
              */
            protected function filterOperaVersion(array &$userAgent) {

                     if( $userAgent['browser_name'] === 'opera' && strpos($userAgent['string'], ' version/')) {
                         $pattern = '|.+\sversion/([0-9]+\.[0-9]+\s*.*)|';
                         $userAgent['browser_version'] = preg_replace($pattern, '$1', $userAgent['string']);
                     }
            }

            /**
              *  Google Chrome has a safari like signature
              */
            protected function filterGoogleChrome(array &$userAgent) {

                     if($userAgent['browser_name'] === 'safari' && strpos($userAgent['string'], 'chrome/')) {
                             $userAgent['browser_name'] = 'chrome';
                             $pattern = '|.+chrome/([0-9]+(?:\.[0-9]+)?).+|';
                             $userAgent['browser_version'] = preg_replace($pattern,'$1', $userAgent['string']);
                     }
            }

            /**
              *
              */
            protected function filterSafariVersion(array &$userAgent) {

                     if($userAgent['browser_name'] === 'safari' && strpos($userAgent['string'], 'version/')) {
                             $userAgent['browser_name'] = 'chrome';
                             $pattern = '|.+version/([0-9]+(?:\.[0-9]+)?).+|';
                             $userAgent['browser_version'] = preg_replace($pattern,'$1', $userAgent['string']);
                     }

            }


    }//end class

?>