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
/**
 * Formatting library
 * Formats the output of the PHP object(s) when called by REST API services
 */


class format_base {
    //default to XML
    function get_header(){
        return "Content-Type: text/xml";
    }

    function allowed_methods(){
        return null;
    }

    function format($object){
    	global $LNG;
        return $LNG->CORE_FORMAT_NOT_IMPLEMENTED_MESSAGE;
    }
}

global $FORMAT;

/**
 * Set the output header
 * Depends on optional URL parameter 'format'
 *
 */
function set_service_header(){
    global $CFG,$FORMAT,$LNG, $HUB_FLM;
    $format = optional_param('format','xml',PARAM_ALPHA);

    $classfile = $HUB_FLM->getCodeDirPath("core/formats/".$format.".php");
    // load the relevant class
    if(file_exists($classfile)){
        include_once($classfile);
    } else {
        echo $LNG->CORE_FORMAT_INVALID_SELECTION_ERROR;
        die;
    }

    $classname = 'format_'.$format;
    $FORMAT = new $classname;
    header($FORMAT->get_header());

    header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );  // disable IE caching
    header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
    header( "Cache-Control: no-cache, must-revalidate" );
    header( "Pragma: no-cache" );
}

/**
 * Format the output
 * - depends on optional URL parameter 'format'
 *
 * @param Object $object - the data to format
 * @return string
 */
function format_output($object){
    global $FORMAT,$CFG,$ERROR,$LNG,$HUB_FLM;
    $method = optional_param("method","",PARAM_ALPHA);

    if($FORMAT && $FORMAT->allowed_methods() != null && !$object instanceof Hub_Error){
        if(!in_array($method,$FORMAT->allowed_methods())){
            $ERROR = new Hub_Error;
            $ERROR->createInvalidMethodForTypeError();
            include($HUB_FLM->getCodeDirPath("api/formaterror.php"));
            die;
        }
    }

    if ($FORMAT) {
    	return $FORMAT->format($object);
    } else {
    	// Fix for when this is called from a ui window without a format setup first.
        $format = optional_param('format','xml',PARAM_ALPHA);
        $classfile = $HUB_FLM->getCodeDirPath("core/formats/".$format.".php");
        if(file_exists($classfile)){
            include_once($classfile);
        } else {
            echo $LNG->CORE_FORMAT_INVALID_SELECTION_ERROR;
            die;
        }
        $classname = 'format_'.$format;
        $FORMAT = new $classname;

    	return $FORMAT->format($object);
    }
}

/**
 * Set the output header
 * Depends on optional URL parameter 'format'
 *
 */
function set_restapi_header(){
    global $CFG,$FORMAT,$LNG, $HUB_FLM;
    $format = 'jsonld';

    $classfile = $HUB_FLM->getCodeDirPath("core/formats/".$format.".php");
    // load the relevant class
    if(file_exists($classfile)){
        include_once($classfile);
    } else {
        echo $LNG->CORE_FORMAT_INVALID_SELECTION_ERROR;
        die;
    }

    $classname = 'format_'.$format;
    $FORMAT = new $classname;
    header($FORMAT->get_header());

    header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );  // disable IE caching
    header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
    header( "Cache-Control: no-cache, must-revalidate" );
    header( "Pragma: no-cache" );
}

/**
 * Format the output
 * - depends on optional URL parameter 'format'
 *
 * @param Object $object - the data to format
 * @return string
 */
function format_output_rest($object){
    global $FORMAT,$CFG,$ERROR,$LNG,$HUB_FLM;

    if ($FORMAT) {
    	return $FORMAT->format($object);
    } else {
        echo $LNG->CORE_FORMAT_INVALID_SELECTION_ERROR;
        die;
    }
}

/**
 * Format the output
 * - depends on optional URL parameter 'format'
 *
 * @param Object $object - the data to format
 * @return string
 */
function format_object($format,$object){
    global $FORMAT,$CFG,$ERROR,$HUB_FLM;
     $classfile = $HUB_FLM->getCodeDirPath("core/formats/".$format.".php");
    // load the relevant class
    if(file_exists($classfile)){
        include_once($classfile);
    } else {
        return "";
    }

    $classname = 'format_'.$format;
    $f = new $classname;
    return $f->format($object);
}


?>