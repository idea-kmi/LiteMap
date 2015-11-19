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
 * This code was Modified by M Bachler to connect to our Evidence Hub Config to pull settings
 */

/**
LINKED IN
OAuth User Token:
76039dbc-3d78-4d29-9cdf-7454ea9d8a70

OAuth User Secret:
1952229d-e22d-408d-8bbd-8782ad2e95af
*/

chdir( dirname ( realpath ( __FILE__ ) ) );
include_once("../../../../config.php");
global $CFG;

$settings  =
	array(
		"base_url" => $CFG->homeAddress."core/lib/hybridauth-2.4.1/hybridauth/",

		"providers" => array (

			"Twitter" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_TWITTER_ON,
				"keys"    => array ( "key" => $CFG->SOCIAL_SIGNON_TWITTER_ID, "secret" => $CFG->SOCIAL_SIGNON_TWITTER_SECRET )
			),

			"Yahoo" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_YAHOO_ON,
				"keys"    => array ( "key" => $CFG->SOCIAL_SIGNON_YAHOO_ID, "secret" => $CFG->SOCIAL_SIGNON_YAHOO_SECRET )
			),

			"MySpace" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"LinkedIn" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_LINKEDIN_ON,
				"keys"    => array ( "key" => $CFG->SOCIAL_SIGNON_LINKEDIN_ID, "secret" => $CFG->SOCIAL_SIGNON_LINKEDIN_SECRET )
			),

			"Google" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_GOOGLE_ON,
				"keys"    => array ( "id" => $CFG->SOCIAL_SIGNON_GOOGLE_ID, "secret" => $CFG->SOCIAL_SIGNON_GOOGLE_SECRET ),
				"redirect_uri" => $CFG->homeAddress."core/lib/hybridauth-2.4.1/hybridauth/?hauth.done=Google"
			),

			"Facebook" => array (
				"enabled" => $CFG->SOCIAL_SIGNON_FACEBOOK_ON,
				"keys"    => array ( "id" => $CFG->SOCIAL_SIGNON_FACEBOOK_ID, "secret" => $CFG->SOCIAL_SIGNON_FACEBOOK_SECRET )
			),

			// windows live
			"Live" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"AOL"  => array (
				"enabled" => false
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,
		"debug_file" => "",
	);


if ($CFG->PROXY_HOST != "") {
	$settings["proxy"] = $CFG->PROXY_HOST.":".$CFG->PROXY_PORT;
}

return $settings;