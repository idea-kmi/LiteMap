<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

/**
 * This code was Modified by M Bachler to connect to our website Config to pull settings
 */
//chdir( dirname ( realpath ( __FILE__ ) ) );

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
global $CFG;

$settings  = array(
		"base_url" => $CFG->homeAddress.'core/lib/hybridauth/',
		"providers" => array(
			"Twitter" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_TWITTER_ON,
				"keys"    => array ( "key" => $CFG->SOCIAL_SIGNON_TWITTER_ID, "secret" => $CFG->SOCIAL_SIGNON_TWITTER_SECRET ),
				"includeEmail" => true
			),
			"Yahoo" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_YAHOO_ON,
				"keys"    => array ( "id" => $CFG->SOCIAL_SIGNON_YAHOO_ID, "secret" => $CFG->SOCIAL_SIGNON_YAHOO_SECRET ),
				"scope"   => array ('sdps-r')
			),
			"LinkedIn" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_LINKEDIN_ON,
				"keys"    => array ( "id" => $CFG->SOCIAL_SIGNON_LINKEDIN_ID, "secret" => $CFG->SOCIAL_SIGNON_LINKEDIN_SECRET ),
            	"fields" => array(),
			),
			"Google" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_GOOGLE_ON,
				"keys"    => array ( "id" => $CFG->SOCIAL_SIGNON_GOOGLE_ID, "secret" => $CFG->SOCIAL_SIGNON_GOOGLE_SECRET )
			),
			"Facebook" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_FACEBOOK_ON,
				"keys"    => array ( "id" => $CFG->SOCIAL_SIGNON_FACEBOOK_ID, "secret" => $CFG->SOCIAL_SIGNON_FACEBOOK_SECRET ),
				"trustForwarded" => false
			),
			// windows live
			"Live" => array(
				"enabled" => false,
				"keys" => array("id" => "", "secret" => ""),
			),
			"Foursquare" => array(
				"enabled" => false,
				"keys" => array("id" => "", "secret" => ""),
			),
			"OpenID" => array(
				"enabled" => false,
			),
			"AOL" => array(
				"enabled" => false,
			),
		),
		// If you want to enable logging, set 'debug_mode' to true.
		// You can also set it to
		// - "error" To log only error messages. Useful in production
		// - "info" To log info and error messages (ignore debug messages)
		"debug_mode" => false,
		// Path to file writable by the web server. Required if 'debug_mode' is not false
		"debug_file" => ""
);

if ($CFG->PROXY_HOST != "") {
	$settings["curl_options"] = array ("CURLOPT_PROXY" => $CFG->PROXY_HOST.":".$CFG->PROXY_PORT);
}

return $settings;