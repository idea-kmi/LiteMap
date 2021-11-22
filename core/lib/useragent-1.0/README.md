PHP User Agent
--------------

Browser detection in PHP5. Uses a simple and fast algorithm to recognize major browsers.

How to use
==========

    require_once('userAgent.class.php');

    //create an object $userAgent
    $userAgent = new UserAgent();

    //interrogate userAgent
    echo$userAgent->getBrowserName(). ' | '; 
    echo$userAgent->getBrowserVersion(). ' | ';
    echo$userAgent->getOperatingSystem(). ' | ';
    echo$userAgent->getEngine();

    /* output:
       firefox | 3.6 | Windows | gecko  
     */ 

Advanced
========

##Custom user agent string

When you create a UserAgent object, the current user agent string is used, namely $_SERVER['HTTP_USER_AGENT']. You can specify another user agent string:

       $userAgent = new UserAgent("MojeekBot/0.2 (archi; http://www.mojeek.com/bot.html)");
       $userAgent->getBrowserName();//mojeekbot
       $userAgent->getBrowserVersion();//0.2

       //use current user agent string
       $userAgent = new UserAgent($_SERVER['HTTP_USER_AGENT']);
       //this is equivalent to:
       $userAgent = new UserAgent();

##Custom parser class

By default, UserAgentStringParser is used to analyse the user agent string. You can replace the parser instance and customize it to match your needs:

      //create a custom user agent string parser
      class myCustomUserAgentStringParser extends UserAgentStringParser {
           //overrides methods
      }

      //end inject the custom parser when creating user agent
      $userAgent = new UserAgent(null, myCustomUserAgentParser);


Why you should use it
---------------------

PHP provides a native function to detect user browser: get_browser() requires the "browscap.ini" which is 300KB+. Loading and processing this file impact script performance. And sometimes, the production server just doesn't provide broscap.ini.
Although get_browser() surely provides excellent detection results, in most cases a much simpler can be just as effective. This class
has the advantage of being compact and easy to extend. It is performant as well, since it doesn't do any iteration or recurion.
