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
/**
 * config.php
 *
 * Michelle Bachler, KMi - the Open University
 *
 * Sorry about the upper and lower case mix of variable names. I know it is very annoying.
 * There was originally some rhyme and reason behind the difference but I think it got lost along the way.
 */

/**
 * Does this site require login for all access, including interface and API
 * true if it does, else false if it does not.
 */
$CFG->privateSite = false;

/**
 * This is the date you setup your Hub.
 * It is currently used by the site Analytics.
 * e.g. mktime(0, 0, 0, 7, 01, 2012) = 1st July 2012
 * Just edit the last three number month, date, year
 */
$CFG->START_DATE = 	mktime(0, 0, 0, 01, 01, 2013);

/**
 * Put your site title here.
 * This is used in the header title as well as being displayed to the user in various places.
 */
$CFG->SITE_TITLE = "LiteMap";

/**
 * You can get the following three ids from the adddefaultdata.php script output, or
 * from the Users and NodeTypeGroup tables in the database after the script has run
 */
// This person is the owner of the News nodes in the system, which allows any admin to then modify news entries.
$CFG->ADMIN_USERID = "";

// This person acts as a template for new users. Their node and link types are copied into new user accounts.
$CFG->defaultUserID = "";

// As found in the database NodeTypeGroup table.
$CFG->defaultRoleGroupID = "";


/** URL SETUP **/

// home address is the base url for the website and must end with trailing '/'
// e.g. http://litemapdev.kmi.open.ac.uk/
$CFG->homeAddress = "";

// The url of the analytics service being used.
// Sepcifically this is the one developed by Mark Klein on the Catalyst FP7 project (http://catalyst-fp7.eu/)
// https://papers.ssrn.com/sol3/papers.cfm?abstract_id=2962524
$CFG->analyticsServiceUrl = "";

/** DATABASE SETUP **/
/**
 * Currently we support MySQL databases.
 * So the value below must be 'mysql' at present
 */
$CFG->databasetype = "mysql";

// The database address, e.g. localhost or a url etc.
$CFG->databaseaddress = "localhost";

// The database username that LiteMap uses to login to the database
$CFG->databaseuser= "";

// The database password to go with the above username
$CFG->databasepass = "";

// The database name for the LiteMap is to use
$CFG->databasename = "";


/** LANGUAGE **/

// This string indicates what language the interface text should use.
// The name must correspnd to a folder in the 'language' folder where the translated texts should exist.
$CFG->language = 'en';

/** INTERFACE THEME **/

// This string indicates what theme the interface should use.
// The name must correspond to a folder in the 'theme' folder where the theme specific style sheets, images and pages should exist.
// The default theme is 'default'. Make sure this is never deleted as it is the fall back position.
$CFG->uitheme = 'default';

/** BITS AND PIECES **/

/**
 * Do you want maps to display Metric Alerts from the Metrics server against maps?
 * true for yes, false for no.
 */
$CFG->HAS_ALERTS = true;

// The path to a temp directory that the Evidence Hub can use
$CFG->workdir = "/tmp/";

// If true, you get RSS feed buttons at various places in the site,
// If false, you get no RSS feed buttons.
$CFG->hasRss = true;

// Does this site want to use the CIF import feature ('true' / 'false').
$CFG->hasCIFImport = false;

// This says how many nodes can be imported from CIF in a single transaction.
// Note data is posted and php.ini setting may need to be changes to allow large number of post or size of post data.
$CFG->ImportLimit = 2000;

// Does this site want to have the homepage field on the user registration/profile forms.
$CFG->hasUserHomePageOption = true;

// Does this site want to display a Conditions of use Agreement statement when user's sign up?
// The default text for this can be overriden in a language custom folder (see the setup notes for more details).
$CFG->hasConditionsOfUseAgreement = false;

/**
 * The following two values work together
 * For example if the debateCountOpen is 1 and the debateChildCount Open is 10,
 * then on the knowledge builder explore page, a knowledge tree will be opened automatically
 * when the page is loaded only if there is only 1 tree with less than 10 items on it, otherwise trees will be closed.
 */
// this value determines how many knowledge trees there should be
// to decide if they should be opened automoatcially.
$CFG->debateCountOpen = 1;

// This value determines how many items they should be less than in a knowledge tree to open it automatically.
$CFG->debateChildCountOpen = 2000;

/**
 * The following two values work together
 * For example if the chatCountOpen is 1 and the chatChildCount Open is 15,
 * then on the Chats explore page, a chat tree will be opened automatically
 * when the page is loaded only if there is only 1 tree with less than 10 items on it, otherwise trees will be closed.
 */
// this value determines how many chat trees there should be
// to decide if they should be opened automoatcially.
$CFG->chatCountOpen = 1;

// This value determines how many items they should be less than in a chat tree to open it automatically.
$CFG->chatChildCountOpen = 15;


/**
 * SITE REGISTRATION
 *
 * Whether or not the site is open for registration.
 * There are three option you can change this parameter to.
 * $CFG->SIGNUP_OPEN, If you use this state for signup, then users can register themselves for using the Hub
 * $CFG->SIGNUP_REQUEST, If you use this state for signup below, then users can request an account
 * 		for using the Hub which is then validated by a Hub Admin user.
 * $CFG->SIGNUP_CLOSED, If you use this state for signup below, then users cannot register,
 * 		they must be sent login details. So by invitation only.
 * The deault is $CFG->SIGNUP_CLOSED;
 */
$CFG->signupstatus = $CFG->SIGNUP_CLOSED;

// The email address of the site user managing the registration requests if SIGNUP_REQUEST is used.
// They must be an admin user (IsAdmin set to 'Y' in Users table the database))
// defaults to $CFG->EMAIL_REPLY_TO
$CFG->signuprequestemail = '';

/**
 * These are the background colours used in the Network Applet
 * They have the same names as styles in the styles.css file,
 * but we found we needed slightly darker shades than their stylesheet equivalents.
 */
$CFG->challengebackpale = '#6FCBF5';
$CFG->issuebackpale = '#DFC7EB';
$CFG->solutionbackpale = '#B9C1DD';
$CFG->probackpale ='#C3D6BC';
$CFG->conbackpale ='#DE9898';
$CFG->claimbackpale = '#F0B288';
$CFG->orgbackpale = '#A4AED4';
$CFG->projectbackpale = '#DEE2F0';
$CFG->peoplebackpale = '#C6ECFE';
$CFG->evidencebackpale ='#DFC7EB';
$CFG->resourcebackpale = '#E1F1C9';
$CFG->themebackpale = '#FAB8DA';
$CFG->plainbackpale = '#D0D0D0';
$CFG->argumentbackpale = '#F0F1AD';
$CFG->ideabackpale = '#D0D0D0';
$CFG->commentbackpale = '#FAB8DA';
$CFG->mapbackpale = '#C83089';

/**
 * These are the background colours used in Analytics graphs
 * They need to be darker versions of the above colours, as the pale versions are too pale on a graph.
 */
$CFG->challengeback = '#83548B'; //'#067EB0';
$CFG->issueback = '#DFC7EB';
$CFG->solutionback = '#A4AED4';
$CFG->proback ='#A9C89E';
$CFG->conback ='#D46A6A';
$CFG->claimback = '#CD6119';
$CFG->orgback = '#5B70BD';
$CFG->projectback = '#94A5E4';
$CFG->peopleback = '#0000C0';
$CFG->evidenceback ='#BC84DC';
$CFG->resourceback = '#BCE482';
$CFG->themeback = '#F777B9';
$CFG->plainback = '#D0D0D0';
$CFG->argumentback = '#E1E353';
$CFG->ideaback = '#D0D0D0';
$CFG->commentback = '#F777B9';
$CFG->mapback = '#A6156C';

/** BROWSER BOOKMARKLET TOOL **/

// The name of the Webrowser Tool for this site.
// A shortening of the main site name or something like that.
$CFG->buildername = "Open Source LiteMap";

// This needs to be a unique single word key that is used before
// all function names in the tool to avoid clashing with any other scripts loaded in webpages.
$CFG->buildernamekey = "LiteMap";


/** EMAILING **/
// Whether or not to send emails. This should really always be true unless you have a development instance
// or something, otherwise account createion will not work.
// For example if your server can't do emailing - true/false, default 'true'
$CFG->send_mail = true;

// The email address to show system emails as being sent from
$CFG->EMAIL_FROM_ADDRESS = "";

// The email from name to show system emails as being sent by. Defaults to your site title plus 'Admin'
$CFG->EMAIL_FROM_NAME = $CFG->SITE_TITLE." Admin";

// The email address to show system emails should be replied to
$CFG->EMAIL_REPLY_TO = "";

// The email address to sent system error alerts to
$CFG->ERROR_ALERT_RECIPIENT = "";

/** NEWSLETTERS AND EMAIL DIGESTS **/
// Should recent activity email sending should be included in this hub? (true/false);
$CFG->RECENT_EMAIL_SENDING_ON = true;

// If recent activity email sending should be on or off by default for new user ('Y' == on / 'N' = off);
$CFG->RECENT_EMAIL_SENDING_SELECTED = 'Y';

// If follow activity email sending should be on or off by default for new user ('Y' == on / 'N' = off);
$CFG->ACTIVITY_EMAIL_SENDING_ON = 'Y';

// When to send email alerts by default for new users ('daily'/'weekly'/'monthly');
$CFG->ACTIVITY_EMAIL_SENDING_INTERVAL = 'weekly';

/**
 * PROXY SETTINGS
 *
 * If the server needs to use a proxy to access internet, set it here
 */
$CFG->PROXY_HOST = "";
$CFG->PROXY_PORT = "";


/** CAPTCHA **/
// If you want to use Capthca set this to 'true. ('true' or 'false')
// If this is set to 'true' you must also complete CAPTCHA_PUBLIC and CAPTCHA_PRIVATE below.
// We strongly recommend that you use Captch on your registration forms to stop automated registrations.
$CFG->CAPTCHA_ON = true;

// captcha public/private keys.
// You can get these from the Captcha website (http://www.captcha.net/)
$CFG->CAPTCHA_PUBLIC = "";
$CFG->CAPTCHA_PRIVATE = "";

/** GOOGLE **/
// Do you want to use Google analytics. ('true' or 'false')
// If this is set to 'true' you must also complete the GOOGLE_ANALYTICS_KEY below.
$CFG->GOOGLE_ANALYTICS_ON = false;

// Google analytics key
// You must get this from the Google Analytics website.
// If you set the GOOGLE_ANALYTICS_ON to 'true' you must add a key and your website domain for it to work.
$CFG->GOOGLE_ANALYTICS_KEY = "";
$CFG->GOOGLE_ANALYTICS_DOMAIN = "";


/**
 * urls that are allowed in IFrame and Object embeds in formatted descriptions
 * To add a new one repeat the pattern but increase the number, e.g.
 * $CFG->safeurls[11] = 'xyz.zom/';
 */
$CFG->safeurls[0] = 'www.youtube.com/embed/';
$CFG->safeurls[1] = 'player.vimeo.com/video/';
$CFG->safeurls[2] = 'www.ustream.tv/';
$CFG->safeurls[3] = 'www.schooltube.com/';
$CFG->safeurls[4] = 'archive.org/';
$CFG->safeurls[5] = 'www.blogtv.com/';
$CFG->safeurls[6] = 'uk.video.yahoo.com/';
$CFG->safeurls[7] = 'www.teachertube.com/';
$CFG->safeurls[8] = 'sciencestage.com/';
$CFG->safeurls[9] = 'www.flickr.com/';
$CFG->safeurls[10] = 'cohere.open.ac.uk/';

/** SPAM ALERT **/
// Do you want to use Spam reporting on this site? (true/false)
// If this is set to 'true' you must also complete the SPAM_ALERT_RECIPIENT below.
$CFG->SPAM_ALERT_ON = false;
$CFG->SPAM_ALERT_RECIPIENT = "email address of person to receive spam reports";


/** USE EXTERNAL SIGN ON **/
/* If you set this to true you also need to setup at least one social signon provider below */
$CFG->SOCIAL_SIGNON_ON = false;

/**
 * Please note that the individual instructions for each provider may have changed,
 * as providers change the way you register and what you need to set.
 * So consider these instructions a rough guide only. Check the help for each provider for more details
 * and also the core/lib/hybridauth-<version> which will ultimately use these settings.
 */

/**
 * 1. Go to https://developer.apps.yahoo.com/dashboard/createKey.html and create a project.
 * 2. Fill out any required fields such as the Application name and description.
 * 3. Set the 'Applcation Type' to be 'Web-based'.
 * 4. Set the 'Home Page URL' to be you hub url
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 5. Int 'Access Scope' select 'This app requires access to private user data'.
 * 	  A section will expand out. Enter the Application Domain as in 4. above.
 * 6. In 'Select APIs for private user data access:', select 'Social Directory' and leave it as 'Read Public'.
 * 7. Once you have created the project, copy and paste the 'Consumer Key' as the $CFG-SOCIAL_SIGNON_YAHOO_ID
 *    and the 'Consumer Secret' as the $CFG->SOCIAL_SIGNON_YAHOO_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_YAHOO_ON = true.
 */
$CFG->SOCIAL_SIGNON_YAHOO_ON = false;
$CFG->SOCIAL_SIGNON_YAHOO_ID = "";
$CFG->SOCIAL_SIGNON_YAHOO_SECRET = "";

/**
 * 1. Go to https://code.google.com/apis/console/ and create a new project, if you don't have one.
 * 2. Fill out any required fields such as the name and description.
 * 3. Click on "Create client ID..."/"Create another client ID...". This open a popup
 * 4. Make sure 'Application Type' has 'Web Application' selected.
 * 5. In the section 'Your site or hostname' fill in your hub url
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 6. Then select '(more options)'.
 * 7. In the section 'Authorized Redirect URIs' you need to add a callback URL for your application:
 *	  The URL should start with the URL you have entered into $CFG->homeAddress
 *    followed by 'core/lib/hybridauth-2.6.0/hybridauth/?hauth.done=Google'
 * 	  e.g. https://test.evidence-hub.net/core/lib/hybridauth-2.6.0/hybridauth/?hauth.done=Google
 * 	  Then press 'Create Client ID'
 * 8. Once you have done this, copy and paste the 'Client ID' as the $CFG-SOCIAL_SIGNON_GOOGLE_ID
 *    and the 'Client Secret' as the $CFG->SOCIAL_SIGNON_GOOGLE_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_GOOGLE_ON = true.
*/
$CFG->SOCIAL_SIGNON_GOOGLE_ON = false;
$CFG->SOCIAL_SIGNON_GOOGLE_ID = "";
$CFG->SOCIAL_SIGNON_GOOGLE_SECRET = "";

/**
 * 1. Go to https://www.facebook.com/developers/ and create a new application.
 * 2. Fill out any required fields such as the application name and description.
 * 3. Make sure you have 'Sandbox Mode' set to Disabled once your site is live, or only your developer Facebook user will be able to use the Social Sign On.
 * 4. Select 'Website with Facebook Login' and add your hub url into the 'Site URL' field.
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 5. Once you have registered, copy and paste the 'App ID' as the $CFG->SOCIAL_SIGNON_FACEBOOK_ID
 *    and the 'App Secret' as the $CFG->SOCIAL_SIGNON_FACEBOOK_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_FACEBOOK_ON = true.
 */
$CFG->SOCIAL_SIGNON_FACEBOOK_ON = false;
$CFG->SOCIAL_SIGNON_FACEBOOK_ID = "";
$CFG->SOCIAL_SIGNON_FACEBOOK_SECRET = "";

/**
 * 1. Go to https://code.google.com/apis/console/ and create a new application
 * 2. Fill out any required fields such as the application name and description.
 * 3. Put your website domain in the Application Website and Application Callback URL fields.
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 4. Set the Default Access Type to Read, Write, & Direct Messages.
 * 5. Tick the checkbox beside 'Allow this application to be used to Sign in with Twitter'
 * 6. Once you have registered, copy and paste the 'Consumer key' as the $CFG->SOCIAL_SIGNON_TWITTER_ID
 *    and the 'Consumer secret' as the $CFG->SOCIAL_SIGNON_TWITTER_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_YAHOO_ON = true.
 */
$CFG->SOCIAL_SIGNON_TWITTER_ON = false;
$CFG->SOCIAL_SIGNON_TWITTER_ID = "";
$CFG->SOCIAL_SIGNON_TWITTER_SECRET = "";

/**
 * 1. Go to https://www.linkedin.com/secure/developer and create a new application.
 * 2. Fill out any required fields such as the application name and description.
 * 3. Put your website domain in the Website URL field.
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 4. Set 'Live Status' to Live (if you are live).
 * 5. In the OAuth User Agreement section, select  'r_fullprofile' and 'r_emailaddress'
 * 6. Once you have registered, copy and paste the 'API Key' as the $CFG->SOCIAL_SIGNON_LINKEDIN_ID
 *    and the 'Secret Key' as the $CFG->SOCIAL_SIGNON_LINKEDIN_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_LINKEDIN_ON = true.
 */
$CFG->SOCIAL_SIGNON_LINKEDIN_ON = false;
$CFG->SOCIAL_SIGNON_LINKEDIN_ID = "";
$CFG->SOCIAL_SIGNON_LINKEDIN_SECRET = "";



/** TESTING TRIALS **/

/* This is something we used when testing LiteMap with various user bases.
 * It ties to an AuditTesting table in the database and various code that can be
 * used to write to this table when running tests.
 * Search for $CFG->TEST_TRIAL_START in the code base to find this.
 * Mostly you can ignore this.
 */
$CFG->TEST_TRIAL_NAME = '';
$CFG->TEST_TRIAL_START = date_timestamp_get(DateTime::createFromFormat('d-m-Y', '0-0-0'));
$CFG->TEST_TRIAL_END = date_timestamp_get(DateTime::createFromFormat('d-m-Y', '0-0-0'));

?>