<?php

/**
 * Implements safety checks for safe objects.
 *
 * @warning This filter is *critical* for ensuring that %HTML.SafeObject
 * works safely.
 */
class HTMLPurifier_URIFilter_SafeObject extends HTMLPurifier_URIFilter
{
    public $name = 'SafeObject';
    public $always_load = true;
    protected $regexp = NULL;

	public function setRegularExpression($safeObjectRegexp) {
		$this->regexp = $safeObjectRegexp;
	}

    // XXX: The not so good bit about how this is all setup now is we
    // can't check HTML.SafeObject in the 'prepare' step: we have to
    // defer till the actual filtering.
    public function prepare($config) {
        //$this->regexp = $config->get('URI.SafeIframeRegexp');
        return true;
    }

    public function filter(&$uri, $config, $context) {

        // check if filter not applicable
        if (!$config->get('HTML.SafeObject'))
        	return true;

        // check if the filter should actually trigger
        if (!$context->get('EmbeddedURI', true))
        	return true;

        $token = $context->get('CurrentToken', true);

        if (!($token && $token->name == 'object' || $token->name == 'param'))
        	return true;

        // check if we actually have some whitelists enabled
        if ($this->regexp === null)
        	return false;

       	// actually check the whitelists
		$result = preg_match($this->regexp, $uri->toString());

        return $result;
    }
}