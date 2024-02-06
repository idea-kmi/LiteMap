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
 * users.php
 *
 * Michelle Bachler (KMi)
 */

/** SPAM REPORTING OF USERS **/
$LNG->SPAM_USER_REPORTED = 'El usuario ha sido reportado como un Spammer / inadecuado';
$LNG->SPAM_USER_REPORT = 'Reportar este Usuario como un Spammer / inadecuado';
$LNG->SPAM_USER_LOGIN_REPORT = 'Inicia sesión para informar de este usuario o grupo como Spam / inapropiado';
$LNG->SPAM_USER_REPORTED_ALT = 'Reportado';
$LNG->SPAM_USER_REPORT_ALT = 'Informe';
$LNG->SPAM_USER_LOGIN_REPORT_ALT = 'Inicie sesión para reportar';

/** USER AREA **/
$LNG->TAB_USER_DATA = 'Mis datos';
$LNG->TAB_USER_GROUP = 'Mis '.$LNG->GROUPS_NAME;
$LNG->TAB_USER_SOCIAL = 'Mi Red Social';
$LNG->TAB_USER_HOME = 'Mi página de inicio';
$LNG->TAB_USER_MAP = 'Mi '.$LNG->MAPS_NAME_SHORT;
$LNG->TAB_USER_CHALLENGE = 'Mi '.$LNG->CHALLENGES_NAME_SHORT;
$LNG->TAB_USER_ISSUE = 'Mi '.$LNG->ISSUES_NAME_SHORT;
$LNG->TAB_USER_SOLUTION = 'Mi '.$LNG->SOLUTIONS_NAME_SHORT;
$LNG->TAB_USER_PRO = 'Mi '.$LNG->PROS_NAME_SHORT;
$LNG->TAB_USER_CON = 'Mi '.$LNG->CONS_NAME;
$LNG->TAB_USER_EVIDENCE = 'Mi '.$LNG->ARGUMENTS_NAME_SHORT;
$LNG->TAB_USER_RESOURCE = 'Mi '.$LNG->RESOURCES_NAME_SHORT;
$LNG->TAB_USER_CHAT = 'Mi '.$LNG->CHATS_NAME;
$LNG->TAB_USER_COMMENT = 'Mi '.$LNG->COMMENTS_NAME;
$LNG->TAB_USER_USED_COMMENT = 'Mi Used'.$LNG->COMMENTS_NAME;

$LNG->LIST_NAV_USER_NO_CON = "No ".$LNG->CONS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_PRO = "No ".$LNG->PROS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_ISSUE = "No ".$LNG->ISSUES_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_SOLUTION = "No ".$LNG->SOLUTIONS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_EVIDENCE = "No ".$LNG->ARGUMENTS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_RESOURCE = "No ".$LNG->RESOURCES_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_COMMENT = "No ".$LNG->COMMENTS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_MAP = "No ".$LNG->MAPS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_CHALLENGE = "No ".$LNG->CHALLENGES_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_CHAT = "No ".$LNG->CHATS_NAME.' encontrado';

/** USER HOME PAGE **/
$LNG->USER_HOME_LOCATION_LABEL = 'ubicación:';
$LNG->USER_HOME_TABLE_ITEM_TYPE = 'Tipos de Item';
$LNG->USER_HOME_TABLE_CREATION_COUNT = 'Contador de creación';
$LNG->USER_HOME_TABLE_VIEW = 'Vista';
$LNG->USER_HOME_TABLE_TYPE = 'Tipo';
$LNG->USER_HOME_TABLE_NAME = 'Nombre';
$LNG->USER_HOME_TABLE_ACTION = 'Acción';
$LNG->USER_HOME_TABLE_PICTURE = 'Imgen';
$LNG->USER_HOME_PROFILE_HEADING = 'Perfil';
$LNG->USER_HOME_VIEW_CONTENT_HEADING = 'Contenido Resumen de creación';
$LNG->USER_HOME_VIEW_ACTIVITIES_LINK = "( Ver toda la actividad de esta persona )";
$LNG->USER_HOME_VIEW_ACTIVITIES_HINT =  "Se abrirá una nueva ventana y puede tardará algún tiempo para cargar en función del volumen de la actividad de esa persona";
$LNG->USER_HOME_FOLLOWING_HEADING = 'Siguiendo';
$LNG->USER_HOME_ACTIVITY_ALERT = 'Enviar Alerta por correo electrónico de Nueva actividad';
$LNG->USER_HOME_EMAIL_HOURLY = 'Cada hora';
$LNG->USER_HOME_EMAIL_DAILY = 'Diario';
$LNG->USER_HOME_EMAIL_WEEKLY = 'Semanal';
$LNG->USER_HOME_EMAIL_MONTHLY = 'Mensual';
$LNG->USER_HOME_PERSON_LABEL = 'Persona';
$LNG->USER_HOME_UNFOLLOW_LINK = 'Dejar de seguir';
$LNG->USER_HOME_EXPLORE_LINK = 'Explorar';
$LNG->USER_HOME_ACTIVITY_LINK = 'Actividad';
$LNG->USER_HOME_NOT_FOLLOWING_MESSAGE = 'No seguir cualquier persona o artículos todavía.';
$LNG->USER_HOME_FOLLOWERS_HEADING = 'Seguidores';
$LNG->USER_HOME_NO_FOLLOWERS_MESSAGE = 'No hay seguidores todavía.';
$LNG->USER_HOME_ANALYTICS_LINK_TEXT = '( Ver Analíticas para esta persona )';
$LNG->USER_HOME_ANALYTICS_LINK_HINT =  "Se abrirá una nueva ventana y puede tomar algún tiempo para cargar en función del volumen de la actividad de esa persona";

/** USERS **/
$LNG->USERS_UNFOLLOW = 'DEjar de seguir a esta persona...';
$LNG->USERS_FOLLOW = 'Seguir a esta persona...';
$LNG->USERS_FOLLOW_ICON_ALT = 'Seguir';
$LNG->USERS_STARTED_FOLLOWING_ON = 'Comenzó a seguir en:';
$LNG->USERS_LAST_LOGIN = 'Última sesión:';
$LNG->USERS_LAST_ACTIVE = 'Última actividad:';
$LNG->USERS_DATE_JOINED = 'Fecha de registro:';

/** USER PAGE **/
$LNG->USER_FOLLOW_HINT = 'Siga a esta persona...';
$LNG->USER_FOLLOW_BUTTON = 'Seguir';
$LNG->USER_UNFOLLOW_HINT = 'Dejar de seguir a esta persona...';
$LNG->USER_UNFOLLOW_BUTTON = 'Dejar de seguir';
$LNG->USER_RSS_HINT = 'Obtén un canal de RSS de ';
$LNG->USER_RSS_BUTTON = 'Canal RSS';

/** PROFILE PAGE **/
$LNG->PROFILE_TITLE = 'EEditar perfil';
$LNG->PROFILE_CHANGE_PASSWORD_LINK = '(Cambiar contraseña)';
$LNG->PROFILE_INVALID_EMAIL_ERROR = "Por favor, introduce una dirección de correo electrónico válida.";
$LNG->PROFILE_EMAIL_IN_USE_ERROR = "Esa dirección de correo electrónico ya está en uso, por favor seleccione otro.";
$LNG->PROFILE_FULL_NAME_ERROR = "Por favor escriba su nombre completo.";
$LNG->PROFILE_HOMEPAGE_URL_ERROR = "Por favor introduzca una URL válida completa (incluyendo 'http://') para tu página de inicio.";
$LNG->PROFILE_SUCCESSFULLY_UPDATED_MESSAGE = 'Perfil actualizado correctamente';
$LNG->PROFILE_UPDATE_BUTTON = 'Actualización';
$LNG->PROFILE_DESC_LABEL = 'Descripción:';
$LNG->PROFILE_PHOTO_CURRENT_LABEL = 'Foto actual:';
$LNG->PROFILE_PHOTO_REPLACE_LABEL = 'reemplazar la foto con la:';
$LNG->PROFILE_PHOTO_LABEL = 'Foto:';
$LNG->PROFILE_LOCATION = 'Localización: (pueblo/ciudad)';
$LNG->PROFILE_COUNTRY = 'País...';
$LNG->PROFILE_HOMEPAGE = 'Página principal:';
$LNG->PROFILE_EMAIL_VALIDATE_TEXT = 'Validar correo electrónico';
$LNG->PROFILE_EMAIL_VALIDATE_HINT = 'Su dirección de correo electrónico no se ha validado. Si desea empezar una sesión Social tendrá que validar que es el propietario de esta dirección de correo electrónico.';
$LNG->PROFILE_EMAIL_VALIDATE_MESSAGE = 'Se le ha enviado un correo electrónico para validar que es el propietario de la dirección de correo electrónico en esta cuenta de usuario.';
$LNG->PROFILE_EMAIL_VALIDATE_COMPLETE = 'Esta dirección de correo electrónico ha sido validada.';
$LNG->PROFILE_EMAIL_CHANGE_CONFIRM = 'Ha cambiado su dirección de correo electrónico.\nNecesitará esta nueva dirección de correo electrónico para ser verificado.\n\nSu cuenta de usuario ahora esta bloqueada, se registrará y se le enviará un nuevo correo electrónico de validación de cuenta.\nPor favor, haz clic en el enlace del correo para completar el cambio de dirección de correo electrónico.\n\n¿Seguro que desea continuar?';
$LNG->PROFILE_PRIVACY_MESSAGE = 'Por defecto guardar mis datos:';
$LNG->PROFILE_PRIVACY_YES = '>Privado';
$LNG->PROFILE_PRIVACY_NO = '>Público';

/** ACTIVITY POPUP PAGES **/
$LNG->FORM_ACTIVITY_HEADING = 'Actividad reciente para';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DATE = 'Fecha';
$LNG->FORM_ACTIVITY_TABLE_HEADING_TYPE = 'Tipo';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DONEBY = 'Realizado por';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ACTION = 'Acción';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ITEM = 'Item';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING = 'comenzar a seguir';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING_ITEM = 'comenzar a seguir este item';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED = 'promovido';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED = 'degradado';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED_ITEM = 'promocionar este item';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED_ITEM = 'degradar este item';
$LNG->FORM_ACTIVITY_ACTION_ADDED = 'añadir';
$LNG->FORM_ACTIVITY_ACTION_EDITED = 'editar';
$LNG->FORM_ACTIVITY_ACTION_ADDED_ITEM = 'añadir este item';
$LNG->FORM_ACTIVITY_ACTION_EDITED_ITEM = 'editar este item';
$LNG->FORM_ACTIVITY_ACTION_ASSOCIATED = 'asociado';
$LNG->FORM_ACTIVITY_ACTION_DESOCIATED = 'eliminar asociación';
$LNG->FORM_ACTIVITY_ACTION_ADDED_RESOURCE = "añadir el ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_PRO = "añadir apoyo ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_CON = "añadir contador ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE = "asociado esto con el ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ASSOCIATED_WITH = "asociado esto con el";
$LNG->FORM_ACTIVITY_ACTION_REMOVED = "eliminado";
$LNG->FORM_ACTIVITY_ACTION_REMOVED_RESOURCE = "eliminado el ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_EVIDENCE = "eliminado el ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_ASSOCIATION = "eliminar esta asociación con";
$LNG->FORM_ACTIVITY_ACTION_INDICATED_THAT = 'señaló que';
$LNG->FORM_ACTIVITY_ACTION_STRONG_SOLUTION = 'era un fuerte '.$LNG->SOLUTION_NAME_SHORT.' para';
$LNG->FORM_ACTIVITY_ACTION_CONVINCING_EVIDENCE = 'fue convenciendo '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_SOUND_EVIDENCE = 'era solido '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_PROMOTED = 'debe promoverse contra';
$LNG->FORM_ACTIVITY_ACTION_WEAK_SOLUTION = 'era una débil'.$LNG->SOLUTION_NAME_SHORT.' para';
$LNG->FORM_ACTIVITY_ACTION_UNCONVINCING_EVIDENCE = 'era poco convincente '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_UNSOUND_EVIDENCE = 'era poco sólido '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_DEMOTED = 'debe ser degradado en contra';
$LNG->FORM_ACTIVITY_LABEL_WITH = 'con';
$LNG->FORM_ACTIVITY_LABEL_FROM = 'desde';
$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE = 'Se encontraron los siguientes problemas para recuperar los datos de actividades: ';
?>