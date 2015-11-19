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
 * emails.php
 *
 * See Also the mailtemplates subfolder for additional email texts to translate.
 *
 * Michelle Bachler (KMi)
 * translated by Alexandre Marino Costa
 */

$LNG->WELCOME_REGISTER_OPEN_SUBJECT = "Bem-vindo a  ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_OPEN_BODY = 'Agradecemos por registrar conosco.<br><br>Para obter mais informações sobre LiteMap, acesse <a href="'.$CFG->homeAddress.'ui/pages/about.php">about page</a>.<br>Para obter ajuda com seus primeiros passos visite nossa  <a href="'.$CFG->homeAddress.'ui/pages/help.php">help page</a>.<br>¿Por que não começar a utilizar o <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a> today.';

$LNG->VALIDATE_REGISTER_SUBJECT = "Complete seu registro em ".$CFG->SITE_TITLE;

$LNG->WELCOME_REGISTER_REQUEST_SUBJECT = "Solicitação de inscrição para o ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_REQUEST_BODY = 'Agradecemos seu interesse pela conta <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a>.<br>Saiba que recebemos sua solicitação.<br>Vamos tratar de processar sua solicitação nas próximas 24 horas, mas em horários de pico pode levar mais tempo.<br>Você receberá um e-mail com mais detalhes sobre seu início de seção, assim que sua solicitação for aceita.<br><br>Agradecemos novamente seu interesse.';
$LNG->WELCOME_REGISTER_REQUEST_BODY_ADMIN = "O usuário anterior já solicitou uma conta. Utilize a área de administração para aceitar ou rejeitar este novo usuário..";

$LNG->WELCOME_REGISTER_CLOSED_SUBJECT = "A inscrição em  ".$CFG->SITE_TITLE;

$LNG->VALIDATE_GROUP_JOIN_SUBJECT = "Solicitação para entrar no grupo de ".$CFG->SITE_TITLE;

/*** EMAIL DIGESTS ***/
$LNG->ADMIN_CRON_FOLLOW_USER_ACTIVITY_MESSAGE = 'Existe uma atividade para';
$LNG->ADMIN_CRON_FOLLOW_SEE_ACTIVITY_LINK = 'Ver atividade';
$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR = 'Atividade para';
$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK = 'Explorar';
$LNG->ADMIN_CRON_FOLLOW_ON_THE = 'Na';
$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM = 'este item';
$LNG->ADMIN_CRON_FOLLOW_STARTED = 'começando a seguir';
$LNG->ADMIN_CRON_FOLLOW_PROMOTED = 'promovido';
$LNG->ADMIN_CRON_FOLLOW_DEMOTED = 'rebaixado';
$LNG->ADMIN_CRON_FOLLOW_ADDED = 'adicionado';
$LNG->ADMIN_CRON_FOLLOW_EDITED = 'editado';
$LNG->ADMIN_CRON_FOLLOW_ADDED_RESOURCE = 'adicionado a'.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_SUPPORTING_EVIDENCE = 'adicionado suporte '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_COUNTER_EVIDENCE = 'adicionado contador '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_EVIDENCE = 'associado com este '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_ASSOCIATED_WITH = 'associado com este';
$LNG->ADMIN_CRON_FOLLOW_REMOVED = 'eliminar';
$LNG->ADMIN_CRON_FOLLOW_REMOVED_RESOURCE = 'elminado el '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_EVIDENCE = 'eliminado el '.$LNG->ARGUMENT_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_ASSOCIATION = 'eliminada associação com';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART1 = 'Desde';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART2 = 'A';
$LNG->ADMIN_CRON_FOLLOW_HOURLY = 'Cada hora';
$LNG->ADMIN_CRON_FOLLOW_HOURLY_TITLE = 'Boletim hora de atividades em '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_HOURLY_DIGEST_RUN = 'Boletim hora de atividades em '.$CFG->SITE_TITLE.' executar';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY = 'Semanal';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_TITLE = 'Informe semanal de atividades em '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_DIGEST_RUN = 'Boletim semanal de atividades em '.$CFG->SITE_TITLE.' executar';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY = 'Mensalmente';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_TITLE = 'Informe mensal de atividades em '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_DIGEST_RUN = 'Boletim mensual de atividades em '.$CFG->SITE_TITLE.' executar';
$LNG->ADMIN_CRON_FOLLOW_DAILY = 'Diário';
$LNG->ADMIN_CRON_FOLLOW_DAILY_TITLE = 'Informe diário de atividades em LiteMap';
$LNG->ADMIN_CRON_FOLLOW_DAILY_DIGEST_RUN = 'Boletim diário de atividades em '.$CFG->SITE_TITLE.' executar';
$LNG->ADMIN_CRON_FOLLOW_NO_DIGEST = 'Nenhum e-mail para ver:';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART1 = 'Para deixar de receber este boletim por correio eletrônico, por favor, entre em distribuidor de correio e desmarque \'Enviar alerta de correio eletrônico de nova atividade\' em sua';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART2 = $LNG->HEADER_MY_HUB_LINK.' página de início';

$LNG->ADMIN_CRON_RECENT_ACTIVITY_DIGEST_RUN = 'Compilação de atividade recente '.$CFG->SITE_TITLE.' executar';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_NO_DIGEST = 'Não há atividade recente:';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_TITLE = 'Recente informe de atividades de LiteMap';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_MESSAGE = 'Veja abaixo os 5 primeiros artigos e mais recentes introduzidos para cada categoria de LiteMap.';
?>
