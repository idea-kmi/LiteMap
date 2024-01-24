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
 * admin.php
 *
 * Michelle Bachler (KMi)
 */

$LNG->ADMIN_CREATE_LINK_TYPES_TITLE = 'Crear un tipo de enlace';
$LNG->ADMIN_CREATE_NODE_TYPES_TITLE = 'Crear un tipo de nodo';

$LNG->ADMIN_TITLE = "Area de administración";
$LNG->ADMIN_BUTTON_HINT = "Se abrirá una nueva ventana";
$LNG->ADMIN_STATS_BUTTON_HINT = "Ir a las páginas de Analíticas";
$LNG->ADMIN_REGISTER_NEW_USER_LINK = 'Registrar nuevo usuario';
$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE = 'Lo sentimos se necesita ser administrador para acceder a esta página';
$LNG->ADMIN_MANAGE_USERS_DELETE_ERROR = 'Había un problema para borrar el usuario con la id:';

/** ADMIN USER REGISTRATION MANAGER **/
$LNG->REGSITRATION_ADMIN_MANAGER_LINK = "Solicitudes de inscripción";
$LNG->REGSITRATION_ADMIN_TITLE = 'User Registration Manager';

$LNG->REGSITRATION_ADMIN_UNREGISTERED_TITLE = "Solicitudes de inscripción";
$LNG->REGSITRATION_ADMIN_UNVALIDATED_TITLE = "Inscripción no válida";
$LNG->REGSITRATION_ADMIN_Revalidar_BUTTON = "Revalidar";
$LNG->REGSITRATION_ADMIN_REMOVE_BUTTON = "Suprimir";
$LNG->REGSITRATION_ADMIN_REMOVE_CHECK_MESSAGE = "¿Está seguro de que desea eliminar este usuario registrado?: ";
$LNG->REGSITRATION_ADMIN_REVALIDATE_CHECK_MESSAGE = "¿Seguro que desea enviar otro mensaje de validación a este usuario?: ";
$LNG->REGSITRATION_ADMIN_USER_REMOVED = 'su cuenta ha sido eliminada del sistema';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REVALIDATED = 'hemos reenviado por correo electrónico que su solicitud fue aceptada';

$LNG->REGSITRATION_ADMIN_REJECT_CHECK_MESSAGE = "¿Seguro que quiere rechazar la socilictud de registro de usuario?: ";
$LNG->REGSITRATION_ADMIN_ACCEPT_CHECK_MESSAGE = "¿Seguro que quiere aceptar la socilictud de registro de usuario?: ";
$LNG->REGSITRATION_ADMIN_NONE_MESSAGE = 'Actualmente no hay usuarios que soliciten inscripción';
$LNG->REGSITRATION_ADMIN_VALIDATION_NONE_MESSAGE = 'Actualmente no hay usuarios en espera de la validación';
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_NAME = "Nombre";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_DESC = "Descripción";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_INTEREST = "Interese";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_WEBSITE = "website";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION = "Acción";
$LNG->REGSITRATION_ADMIN_REJECT_BUTTON = 'Rechazar';
$LNG->REGSITRATION_ADMIN_ACCEPT_BUTTON = 'Aceptar';
$LNG->REGSITRATION_ADMIN_ID_ERROR = 'No se puede procesar la solicitud de usuario la ID de usuario no se encuentra';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_ACCEPTANCE = 'Hemos enviado por correo electrónico que su solicitud fue aceptada';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REJECTION = 'Hemos enviado por correo electrónico que su solicitud fue rechazada';
$LNG->REGSITRATION_ADMIN_EMAIL_REQUEST_SUBJECT = "Solicitud de inscripción para el ".$CFG->SITE_TITLE;

// %s will be replace with the name of the current Site. When translating please leave this in the sentence appropariately placed.
$LNG->REGSITRATION_ADMIN_EMAIL_REJECT_BODY = 'Gracias por solicitar la inscripción en el %s.<br>Desafortunadamente, en esta ocasión, su solicitud de una cuenta de usuario no ha sido exitosa.';

/** SPAM MANAGEMENT **/
$LNG->SPAM_ADMIN_MANAGER_SPAM_LINK = "Items reportados";
$LNG->SPAM_ADMIN_TITLE = "Item Administrador de informes";
$LNG->SPAM_ADMIN_ID_ERROR = "No se puede procesar la solicitud, la ID del nodo no se encuentra";
$LNG->SPAM_ADMIN_TABLE_HEADING0 = "Informado por";
$LNG->SPAM_ADMIN_TABLE_HEADING1 = "Título";
$LNG->SPAM_ADMIN_TABLE_HEADING2 = "Acción";
$LNG->SPAM_ADMIN_DELETE_CHECK_MESSAGE = "¿Está seguro que quiere eliminar este ítem?: ";
$LNG->SPAM_ADMIN_RESTORE_CHECK_MESSAGE = "¿Seguro que lo quiere establecer como no Spam?: ";
$LNG->SPAM_ADMIN_RESTORE_BUTTON = "No Spam";
$LNG->SPAM_ADMIN_DELETE_BUTTON = "Borrar";
$LNG->SPAM_ADMIN_VIEW_BUTTON = "Ver detalles";
$LNG->SPAM_ADMIN_NONE_MESSAGE = 'Actualmente no hay elementos denunciados como spam / inapropiados';

$LNG->SPAM_USER_ADMIN_TABLE_HEADING0 = "Informado por";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING1 = "Nombre de usuario";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING2 = "Acción";
$LNG->SPAM_USER_ADMIN_VIEW_BUTTON = "Ver página de Inicio de usuario";
$LNG->SPAM_USER_ADMIN_VIEW_HINT = "Abre una nueva ventana que muestre la página de inicio del usuario";
$LNG->SPAM_USER_ADMIN_RESTORE_BUTTON = "Restaurar cuenta";
$LNG->SPAM_USER_ADMIN_RESTORE_HINT = "Restaurar esta cuenta de usuario que esta activa";
$LNG->SPAM_USER_ADMIN_DELETE_BUTTON = "Eliminar cuenta";
$LNG->SPAM_USER_ADMIN_DELETE_HINT = "Eliminar esta cuenta de usuario y todos sus datos";
$LNG->SPAM_USER_ADMIN_SUSPEND_BUTTON = "Suspender cuenta";
$LNG->SPAM_USER_ADMIN_SUSPEND_HINT = "Suspender esta cuenta de usuario y su firma en";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "¿Está seguro de que desea borrar el usuario?: ";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Tenga cuidado: todos sus datos se eliminarán de forma permanente si no lo ha hecho, usted debe comprobar sus contribuciones primero haciendo clic en '".$LNG->SPAM_USER_ADMIN_VIEW_BUTTON."'";;
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "Seguro que desea restaurar la cuenta de: ";
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "Este usuario se eliminará de esta lista";
$LNG->SPAM_USER_ADMIN_SUSPEND_CHECK_MESSAGE = "¿Está seguro que quiere suspender la cuenta de?: ";
$LNG->SPAM_USER_ADMIN_NONE_MESSAGE = 'Actualmente no hay usuarios informados como spammers / inapropiados';
$LNG->SPAM_USER_ADMIN_Título = "Administrador de informes del usuario";
$LNG->SPAM_USER_ADMIN_MANAGER_SPAM_LINK = "Informe Usuarios";
$LNG->SPAM_USER_ADMIN_ID_ERROR = "No se puede procesar la solicicitud porque el ID de usuario no se encuentra";
$LNG->SPAM_USER_ADMIN_NONE_SUSPENDED_MESSAGE = 'Actualmente no hay usuarios suspendidos';
$LNG->SPAM_USER_ADMIN_SPAM_Título = 'Usuario reportado';
$LNG->SPAM_USER_ADMIN_SUSPENDED_TITLE = 'Usuario suspendido';

$LNG->SPAM_GROUP_REPORTED = 'El grupo ha sido reportado como Spammer/Inapropiado';
$LNG->SPAM_GROUP_REPORT = 'Reportar este grupo como spam/inapropiado';
$LNG->SPAM_GROUP_LOGIN_REPORT = 'Inicie sesión para reportar este grupo como spam/inapropiado';
$LNG->SPAM_GROUP_REPORTED_ALT = 'Reportada';
$LNG->SPAM_GROUP_REPORT_ALT = 'Informe';
$LNG->SPAM_GROUP_LOGIN_REPORT_ALT = 'Inicie sesión para informar';
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING0 = "Reportado por";
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING1 = "Nombre del grupo";
$LNG->SPAM_GROUP_ADMIN_TABLE_HEADING2 = "Acción";
$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON = "Ver grupo";
$LNG->SPAM_GROUP_ADMIN_VIEW_HINT = "Abrir una nueva ventana que muestra la página de inicio de este grupo.";
$LNG->SPAM_GROUP_ADMIN_RESTORE_BUTTON = "Restaurar grupo";
$LNG->SPAM_GROUP_ADMIN_RESTORE_HINT = "Restaurar este grupo a activo";
$LNG->SPAM_GROUP_ADMIN_DELETE_BUTTON = "Eliminar grupo";
$LNG->SPAM_GROUP_ADMIN_DELETE_HINT = "Eliminar este grupo";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_BUTTON = "Archivar este grupo";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_HINT = "Archivar este grupo y todos los mapas que contiene.";
$LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "¿Estás seguro de que deseas eliminar el grupo: ";
$LNG->SPAM_GROUP_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Tenga cuidado: los miembros del grupo serán eliminados del grupo y los nodos y triples asociados con el grupo perderán esa asociación. Si no lo ha hecho, primero debe verificar los miembros y el contenido del grupo haciendo clic en '".$LNG->SPAM_GROUP_ADMIN_VIEW_BUTTON."'";;
$LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "¿Estás segura de que quieres restaurar el grupo: ";
$LNG->SPAM_GROUP_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "Esto eliminará este grupo de esta lista.";
$LNG->SPAM_GROUP_ADMIN_ARCHIVE_CHECK_MESSAGE = "¿Estás segura de que quieres archivar el grupo: ";
$LNG->SPAM_GROUP_ADMIN_NONE_MESSAGE = 'Actualmente no hay grupos reportados como spammers/inapropiados';
$LNG->SPAM_GROUP_ADMIN_TITLE = "Administrador de informes grupales";
$LNG->SPAM_GROUP_ADMIN_MANAGER_SPAM_LINK = "Grupos reportados";
$LNG->SPAM_GROUP_ADMIN_ID_ERROR = "No se puede procesar la solicitud porque falta groupid";
$LNG->SPAM_GROUP_ADMIN_NONE_ARCHIVED_MESSAGE = 'Actualmente no hay grupos archivados';
$LNG->SPAM_GROUP_ADMIN_SPAM_TITLE = 'Groups Reported';
$LNG->SPAM_GROUP_ADMIN_ARCHIVED_TITLE = 'Grupos reportados';

/** NEWS ADMINSTRATION **/
$LNG->ADMIN_MANAGE_NEWS_LINK = "Gestionar ".$LNG->NEWSS_NAME;
$LNG->ADMIN_MANAGE_NEWS_DELETE_ERROR = 'Había un problema para eliminar '.$LNG->NEWS_NAME.' con el id:';
$LNG->ADMIN_NEWS_MISSING_NAME_ERROR = 'Debe introducir un '.$LNG->NEWS_NAME.' título.';
$LNG->ADMIN_NEWS_ID_ERROR  = 'Pasando error '.$LNG->NEWS_NAME.' id.';
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART1 = 'Estas seguro de que quieres eliminar '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART2 = '?';
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART1 = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART2 = 'ahora ha sido borrada.';
$LNG->ADMIN_NEWS_TITLE = "Gestionar ".$LNG->NEWSS_NAME;
$LNG->ADMIN_NEWS_ADD_NEW_LINK = 'Añadir '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_NAME_LABEL = 'Título:';
$LNG->ADMIN_NEWS_DESC_LABEL = 'Descripción:';
$LNG->ADMIN_NEWS_TITLE_HEADING = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_ACTION_HEADING = 'Acción';
$LNG->ADMIN_NEWS_EDIT_LINK = 'editar';
$LNG->ADMIN_NEWS_DELETE_LINK = 'borrar';

/** USER STATS **/
$LNG->ADMIN_NEWS_USERS = 'Lista de usuarios';
$LNG->ADMIN_NEWS_GROUPS = 'Lista de grupos';
?>