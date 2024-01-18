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
 * emails.php
 *
 * See Also the mailtemplates subfolder for additional email texts to translate.
 *
 * Michelle Bachler (KMi)
 */

$LNG->WELCOME_REGISTER_OPEN_SUBJECT = "Bienvenido a  ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_OPEN_BODY = 'Gracias por registrarte con nosotros.<br><br>Para obtener más información acerca de LiteMap, porque no lees nuestra <a href="'.$CFG->homeAddress.'ui/pages/about.php">about page</a>.<br>Para obtener ayuda con tus primeros pasos porque no visitas nuestra  <a href="'.$CFG->homeAddress.'ui/pages/help.php">help page</a>.<br>¿Por qué no empezar a utilizar el <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a> today.';

$LNG->VALIDATE_REGISTER_SUBJECT = "Completar tu registro en ".$CFG->SITE_TITLE;

$LNG->WELCOME_REGISTER_REQUEST_SUBJECT = "Solicitud de inscripción para el ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_REQUEST_BODY = 'Gracias por su interés en una cuenta en <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a>.<br>Se trata de conocer que hemos recibido su solicitud.<br>Vamos a tratar de procesar su solicitud en las próximas 24 horas, pero en las horas punta nos puede llevar más tiempo.<br>Usted recibirá un correo electrónico con más detalles sobre su inicio de sesión, si su solicitud es aceptada.<br><br>Gracias de nuevo por su interés.';
$LNG->WELCOME_REGISTER_REQUEST_BODY_ADMIN = "Un nuevo usuario ha solicitado una cuenta. Utilice el área de administración para aceptar o rechazar este nuevo usuario.";

$LNG->WELCOME_REGISTER_CLOSED_SUBJECT = "La inscripción en  ".$CFG->SITE_TITLE;

$LNG->VALIDATE_GROUP_JOIN_SUBJECT = "Solicitud para unirse al grupo de ".$CFG->SITE_TITLE;

/*** EMAIL DIGESTS ***/
$LNG->ADMIN_CRON_FOLLOW_USER_ACTIVITY_MESSAGE = 'Ha habido una actividad para';
$LNG->ADMIN_CRON_FOLLOW_SEE_ACTIVITY_LINK = 'Ver actividad';
$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR = 'Actividad para';
$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK = 'Explorar';
$LNG->ADMIN_CRON_FOLLOW_ON_THE = 'En la';
$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM = 'este item';
$LNG->ADMIN_CRON_FOLLOW_STARTED = 'comenzaste a seguir';
$LNG->ADMIN_CRON_FOLLOW_PROMOTED = 'promovido';
$LNG->ADMIN_CRON_FOLLOW_DEMOTED = 'relagado';
$LNG->ADMIN_CRON_FOLLOW_ADDED = 'añadido';
$LNG->ADMIN_CRON_FOLLOW_EDITED = 'editado';
$LNG->ADMIN_CRON_FOLLOW_ADDED_RESOURCE = 'añadido el '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_SUPPORTING_EVIDENCE = 'añadido apoyo '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_COUNTER_EVIDENCE = 'añadido contador '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_EVIDENCE = 'asociado esto con la '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_WITH = 'asociado esto con la';
$LNG->ADMIN_CRON_FOLLOW_REMOVED = 'eliminar';
$LNG->ADMIN_CRON_FOLLOW_REMOVED_RESOURCE = 'elminado el '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_EVIDENCE = 'eliminado el '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_ASSOCIATION = 'eliminada asociación con';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART1 = 'Desde';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART2 = 'A';
$LNG->ADMIN_CRON_FOLLOW_HOURLY = 'Cada hora';
$LNG->ADMIN_CRON_FOLLOW_HOURLY_TITLE = 'Boletính hora de actividades en '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_HOURLY_DIGEST_RUN = 'Boletính hora de actividades en '.$CFG->SITE_TITLE.' ejecutar';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY = 'Semanal';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_TITLE = 'Informe semanal de actividades en '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_DIGEST_RUN = 'Boletín semanal de actividades en '.$CFG->SITE_TITLE.' ejecutar';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY = 'Mensualmente';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_TITLE = 'Informe mensual de actividades en '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_DIGEST_RUN = 'Boletín mensual de actividades en '.$CFG->SITE_TITLE.' ejecutar';
$LNG->ADMIN_CRON_FOLLOW_DAILY = 'Diario';
$LNG->ADMIN_CRON_FOLLOW_DAILY_TITLE = 'Informe diario de actividades en LiteMap';
$LNG->ADMIN_CRON_FOLLOW_DAILY_DIGEST_RUN = 'Boletín diario de actividades en '.$CFG->SITE_TITLE.' ejecutar';
$LNG->ADMIN_CRON_FOLLOW_NO_DIGEST = 'Ningún email para ver:';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART1 = 'Para dejar de recibir este boletín por correo electrónico por favor entra en el distribuidor de correo y desmarque \'Enviar alerta de correo electrónico de nueva actividad\' en su';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART2 = $LNG->HEADER_MY_HUB_LINK.' página de inicio';

$LNG->ADMIN_CRON_RECENT_ACTIVITY_DIGEST_RUN = 'Recopilación de actividad reciente '.$CFG->SITE_TITLE.' ejecutar';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_NO_DIGEST = 'No hay actividad reciente:';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_TITLE = 'REciente informe de actividades de LiteMap';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_MESSAGE = 'Véase más abajo los 5 primeros artículos y más recientes introducidos para cada categoría de LiteMap.';
?>