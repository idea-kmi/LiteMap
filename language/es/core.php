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
 * core.php
 *
 * Michelle Bachler (KMi)
 *
 */

$LNG->CORE_UNKNOWN_USER_ERROR = 'Usuario desconocido';
$LNG->CORE_NOT_IMAGE_ERROR = 'Lo siento solo puede subir imágenes.';
$LNG->CORE_NOT_IMAGE_TOO_LARGE_ERROR = 'Lo siento el archivo de imagen es demasiado grande.';
$LNG->CORE_NOT_IMAGE_UPLOAD_ERROR = 'Ha ocurrido un error al cargar la imagen';
$LNG->CORE_NOT_IMAGE_RESIZE_ERROR = 'Error de cambio en el tamaño de imagen';
$LNG->CORE_NOT_IMAGE_SCALE_ERROR = 'Error de escala en la imagen.';

$LNG->CORE_SESSION_OK = 'OK';
$LNG->CORE_SESSION_INVALID = 'Sesión no válida';

$LNG->CORE_AUDIT_NOT_XML_ERROR = 'No es un archivo XML válido';
$LNG->CORE_AUDIT_CONNECTION_NOT_FOUND_ERROR = 'Conexión no encontrada';
$LNG->CORE_AUDIT_NODE_NOT_FOUND_ERROR = 'Nodo no encontrado';
$LNG->CORE_AUDIT_URL_NOT_FOUND_ERROR = 'URL no encontrado';
$LNG->CORE_AUDIT_CONNECTION_ID_MISSING_ERROR = 'Faltan los datos de conexión id - los datos no se pudieron cargar';
$LNG->CORE_AUDIT_CONNECTION_DATA_MISSING_ERROR = 'Faltan datos de conexión';
$LNG->CORE_AUDIT_NODE_ID_MISSING_ERROR = 'Falta datos id del nodo - el nodo no se pudo cargar';
$LNG->CORE_AUDIT_NODE_DATA_MISSING_ERROR = 'Faltan datos del nodo';
$LNG->CORE_AUDIT_URL_ID_MISSING_ERROR = 'Faltan datos id de la URL - la url no se pudo cargar';
$LNG->CORE_AUDIT_URL_DATA_MISSING_ERROR = 'Faltan datos de URL';
$LNG->CORE_AUDIT_TAG_ID_MISSING_ERROR = 'FAltan datos id de la etiqueta - la etiqueta no se pudo cargar';
$LNG->CORE_AUDIT_TAG_DATA_MISSING_ERROR = 'Faltan datos de la etiqueta';
$LNG->CORE_AUDIT_USER_ID_MISSING_ERROR = 'Faltan datos id del usuario - el usuario no se pudo cargar';
$LNG->CORE_AUDIT_USER_DATA_MISSING_ERROR = 'Faltan datos de usuario';
$LNG->CORE_AUDIT_GROUP_ID_MISSING_ERROR = 'Faltan datos id del grupo - el grupo no se pudo cargar';
$LNG->CORE_AUDIT_GROUP_DATA_MISSING_ERROR = 'Faltan datos id del grupo';
$LNG->CORE_AUDIT_ROLE_ID_MISSING_ERROR = 'Faltan los datos id del tipo de nodo - el tipo de nodo no se pudo cargar';
$LNG->CORE_AUDIT_ROLE_DATA_MISSING_ERROR = 'Faltan datos del tipo de nodo';
$LNG->CORE_AUDIT_LINK_ID_MISSING_ERROR = 'Faltan los datos id del tipo de link - el tipo de link no se pudo cargar';
$LNG->CORE_AUDIT_LINK_DATA_MISSING_ERROR = 'Faltan datos del tipo de link';

$LNG->CORE_FORMAT_NOT_IMPLEMENTED_MESSAGE = 'Todavía no implementado';
$LNG->CORE_FORMAT_INVALID_SELECTION_ERROR = 'Selección de formato no válido';

$LNG->CORE_HELP_ERRORCODES_TITLE = 'Ayuda - códigos de error del API';
$LNG->CORE_HELP_ERRORCODES_CODE_HEADING = 'Código';
$LNG->CORE_HELP_ERRORCODES_MEANING_HEADING = 'Significado';

$LNG->CORE_DATAMODEL_GROUP_CANNOT_REMOVE_MEMBER = 'No se puede eliminar el usuario como administrador como el grupo no tendrá administradores';

/**
 * THESE ARE ERROR MESSAGE SENT FROM THE API CORE CODE
 */
$LNG->ERROR_REQUIRED_PARAMETER_MISSING_MESSAGE = "Required parameter missing";
$LNG->ERROR_INVALID_METHOD_SPECIFIED_MESSAGE = "Invalid or no method specified";
$LNG->ERROR_INVALID_ORDERBY_MESSAGE = "Invalid order by selection";
$LNG->ERROR_INVALID_SORT_MESSAGE = "Invalid sort selection";

$LNG->ERROR_BLANK_NODEID_MESSAGE = "La Identificación del artículo no puede estar en blanco.";
$LNG->ERROR_ACCESS_DENIED_MESSAGE = "Acceso denegado";

$LNG->ERROR_LOGIN_FAILED_MESSAGE = "Ingresa falló: Su correo electrónico o la contraseña son incorrectos. Por favor, inténtalo de nuevo.";
$LNG->ERROR_LOGIN_FAILED_UNAUTHORIZED_MESSAGE = "Ingresa falló: Esta cuenta no ha sido autorizada.";
$LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE = "Ingresa falló: Esta cuenta ha sido suspendida.";
$LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE = "Ingresa falló: Esta cuenta no ha completado el proceso de registro que tiene su dirección de correo electrónico valida.";
$LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE = "La cuenta con la dirección de correo electrónico dada fue creada con un servicio externo y no tiene una contraseña local.<br>Tienes que entrar con esta cuenta mediante:";

$LNG->ERROR_INVALID_JSON_ERROR_NONE = "No JSON errors";
$LNG->ERROR_INVALID_JSON_ERROR_DEPTH = "Maximum stack depth exceeded in the JSON";
$LNG->ERROR_INVALID_JSON_ERROR_STATE_MISMATCH = "Underflow or the modes mismatch";
$LNG->ERROR_INVALID_JSON_ERROR_CTRL_CHAR = "Unexpected control character found in the JSON";
$LNG->ERROR_INVALID_JSON_ERROR_SYNTAX = "Syntax error, malformed JSON";
$LNG->ERROR_INVALID_JSON_ERROR_UTF8 = "Malformed UTF-8 characters, possibly incorrectly encoded";
$LNG->ERROR_INVALID_JSON_ERROR_DEFAULT = "An unknown error has occurred decoding the JSON";

$LNG->ERROR_INVALID_METHOD_FOR_TYPE_MESSAGE = "Method not allowed for this format type";
$LNG->ERROR_DUPLICATION_MESSAGE = "Duplication Error";
$LNG->ERROR_INVALID_EMAIL_FORMAT_MESSAGE = "Invalid email format";
$LNG->ERROR_DATABASE_MESSAGE = "Database error";
$LNG->ERROR_USER_NOT_FOUND_MESSAGE = 'User not found in database';
$LNG->ERROR_URL_NOT_FOUND_MESSAGE = 'Url not found in database';
$LNG->ERROR_TAG_NOT_FOUND_MESSAGE = 'Tag not found in database';
$LNG->ERROR_ROLE_NOT_FOUND_MESSAGE = 'Node Type (Role) not found in database';
$LNG->ERROR_LINKTYPE_NOT_FOUND_MESSAGE = 'Link Type not found in database';
$LNG->ERROR_NODE_NOT_FOUND_MESSAGE = 'Node not found in database';
$LNG->ERROR_CONNECTION_NOT_FOUND_MESSAGE = 'Connection not found in database';
$LNG->ERROR_INVALID_CONNECTION_MESSAGE = "Invalid connection combination. Does not match the datamodel.";
$LNG->ERROR_INVALID_PARAMETER_TYPE_MESSAGE = "Invalid parameter type";
?>