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
 * core.php
 *
 * Michelle Bachler (KMi)
 * translated by Alexandre Marino Costa
 *
 */

$LNG->CORE_UNKNOWN_USER_ERROR = 'Usuário desconhecido';
$LNG->CORE_NOT_IMAGE_ERROR = 'Desculpe, você pode fazer upload de imagens. ';
$LNG->CORE_NOT_IMAGE_TOO_LARGE_ERROR = 'Desculpe o arquivo de imagem é demasiado grande.';
$LNG->CORE_NOT_IMAGE_UPLOAD_ERROR = 'Ocorreu um erro ao carregar a imagem';
$LNG->CORE_NOT_IMAGE_RESIZE_ERROR = 'Erro em alterar o tamanho da imagem';
$LNG->CORE_NOT_IMAGE_SCALE_ERROR = 'Erro de escala na imagem.';

$LNG->CORE_SESSION_OK = 'OK';
$LNG->CORE_SESSION_INVALID = 'Seção não válida';

$LNG->CORE_AUDIT_NOT_XML_ERROR = 'Não é um arquivo XML válido';
$LNG->CORE_AUDIT_CONNECTION_NOT_FOUND_ERROR = 'Conexão não encontrada';
$LNG->CORE_AUDIT_NODE_NOT_FOUND_ERROR = 'Node não encontrado';
$LNG->CORE_AUDIT_URL_NOT_FOUND_ERROR = 'URL não encontrado';
$LNG->CORE_AUDIT_CONNECTION_ID_MISSING_ERROR = 'Faltam os dados de conexão id - os dados não puderam ser carregados';
$LNG->CORE_AUDIT_CONNECTION_DATA_MISSING_ERROR = 'Faltam dados de conexão';
$LNG->CORE_AUDIT_NODE_ID_MISSING_ERROR = 'Faltam dados id do node - o node não pode ser carregado';
$LNG->CORE_AUDIT_NODE_DATA_MISSING_ERROR = 'Faltam dados do node';
$LNG->CORE_AUDIT_URL_ID_MISSING_ERROR = 'Faltam dados id da URL - a url não pode ser carregado';
$LNG->CORE_AUDIT_URL_DATA_MISSING_ERROR = 'Faltam dados de URL';
$LNG->CORE_AUDIT_TAG_ID_MISSING_ERROR = 'Faltam dados id da etiqueta - a etiqueta não pode ser carregada';
$LNG->CORE_AUDIT_TAG_DATA_MISSING_ERROR = 'Faltam dados da etiqueta';
$LNG->CORE_AUDIT_USER_ID_MISSING_ERROR = 'Faltam dados id do usuário - o usuário não pode ser carregado';
$LNG->CORE_AUDIT_USER_DATA_MISSING_ERROR = 'Faltam dados de usuário';
$LNG->CORE_AUDIT_GROUP_ID_MISSING_ERROR = 'Faltam dados id do grupo - o grupo não pode ser carregado';
$LNG->CORE_AUDIT_GROUP_DATA_MISSING_ERROR = 'Faltam dados id do grupo';
$LNG->CORE_AUDIT_ROLE_ID_MISSING_ERROR = 'Faltam os dados id do tipo de node - o tipo de node não pode ser carregado';
$LNG->CORE_AUDIT_ROLE_DATA_MISSING_ERROR = 'Faltam dados do tipo de node';
$LNG->CORE_AUDIT_LINK_ID_MISSING_ERROR = 'Faltam os dados id do tipo de link - o tipo de link não pode ser carregado';
$LNG->CORE_AUDIT_LINK_DATA_MISSING_ERROR = 'Faltam dados do tipo de link';

$LNG->CORE_FORMAT_NOT_IMPLEMENTED_MESSAGE = 'Ainda não implementado';
$LNG->CORE_FORMAT_INVALID_SELECTION_ERROR = 'Seleção de formato não válido';

$LNG->CORE_HELP_ERRORCODES_TITLE = 'Ajuda - códigos de erro do API';
$LNG->CORE_HELP_ERRORCODES_CODE_HEADING = 'Código';
$LNG->CORE_HELP_ERRORCODES_MEANING_HEADING = 'Significado';

$LNG->CORE_DATAMODEL_GROUP_CANNOT_REMOVE_MEMBER = 'Não se pode eliminar o usuário como administrador pois o  grupo não terá administradores';

/**
 * THESE ARE ERROR MESSAGE SENT FROM THE API CORE CODE
 */
$LNG->ERROR_REQUIRED_PARAMETER_MISSING_MESSAGE = "Required parameter missing";
$LNG->ERROR_INVALID_METHOD_SPECIFIED_MESSAGE = "Invalid or no method specified";
$LNG->ERROR_INVALID_ORDERBY_MESSAGE = "Invalid order by selection";
$LNG->ERROR_INVALID_SORT_MESSAGE = "Invalid sort selection";

$LNG->ERROR_BLANK_NODEID_MESSAGE = "A ID de item não pode ser em branco.";
$LNG->ERROR_ACCESS_DENIED_MESSAGE = "Acesso negado";

$LNG->ERROR_LOGIN_FAILED_MESSAGE = "Entrar falhou: Seu e-mail ou senha estão errados. Por favor, tente novamente.";
$LNG->ERROR_LOGIN_FAILED_UNAUTHORIZED_MESSAGE = "Entrar falhou: Esta conta ainda não foi autorizada.";
$LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE = "Entrar falhou: Esta conta foi suspensa.";
$LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE = "Entrar falhou: Esta conta não completou o processo de registro por ter o seu endereço de e-mail validado.";
$LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE = "A conta com o endereço de e-mail fornecido foi criado com um serviço externo e não tem uma senha local.<br>Você deve entrar para esta conta usando:";

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
