<?php

/**
 * Implements safety checks for safe embeds.
 *
 * @warning This filter is *critical* for ensuring that %HTML.SafeEmbed
 * works safely.
 */
class HTMLPurifier_URIFilter_SafeEmbed extends HTMLPurifier_URIFilter
{
    public $name = 'SafeEmbed';
    public $always_load = true;

	protected $regexp = NULL;

    public function setRegularExpression($safeEmbedRegexp) {
		$this->regexp = $safeEmbedRegexp;
	}

    // XXX: The not so good bit about how this is all setup now is we
    // can't check HTML.SafeEmbed in the 'prepare' step: we have to
    // defer till the actual filtering.
    public function prepare($config) {
        //$this->regexp = $config->get('URI.SafeIframeRegexp');
        return true;
    }

    public function filter(&$uri, $config, $context) {

		//echo "<br><br>";
		//print_r($uri);
		//echo "<br><br>";
		//echo($uri->toString());

        // check if filter not applicable
        if (!$config->get('HTML.SafeEmbed'))
        	return true;

        // check if the filter should actually trigger
        if (!$context->get('EmbeddedURI', true))
        	return true;

        $token = $context->get('CurrentToken', true);
		//echo "<br>".$token->name." : ";

        if (!($token && $token->name == 'embed'))
        	return true;


        // check if we actually have some whitelists enabled
        if ($this->regexp === null)
        	return false;

       	// actually check the whitelists
       	//echo "<br>here ".$uri->toString();

		$result = preg_match($this->regexp, $uri->toString());

		/*if ($result) {
			echo "true";
		}else {
			echo "false";
		}*/

        return $result;
    }
}