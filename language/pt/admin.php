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
 * admin.php
 *
 * Michelle Bachler (KMi)
 * translated by Alexandre Marino Costa
 */

$LNG->ADMIN_CREATE_LINK_TYPES_TITLE = 'Criar um tipo de link';
$LNG->ADMIN_CREATE_NODE_TYPES_TITLE = 'Criar um tipo de nó';

$LNG->ADMIN_TITLE = "Área da administração";
$LNG->ADMIN_BUTTON_HINT = "Se abrirá uma nova janela";
$LNG->ADMIN_STATS_BUTTON_HINT = "Ir para as páginas Analíticas";
$LNG->ADMIN_REGISTER_NEW_USER_LINK = 'Registrar novo usuário';
$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE = 'É necessário ser administrador para acessar a esta página';
$LNG->ADMIN_MANAGE_USERS_DELETE_ERROR = 'Ocorreu um problema para apagar o usuário com id:';

/** ADMIN USER REGISTRATION MANAGER **/
$LNG->REGSITRATION_ADMIN_MANAGER_LINK = "Solicitações de inscrição";
$LNG->REGSITRATION_ADMIN_TITLE = 'User Registration Manager';

$LNG->REGSITRATION_ADMIN_UNREGISTERED_TITLE = "Solicitação de inscrição";
$LNG->REGSITRATION_ADMIN_UNVALIDATED_TITLE = "Inscrição não válida";
$LNG->REGSITRATION_ADMIN_Revalidar_BUTTON = "Revalidar";
$LNG->REGSITRATION_ADMIN_REMOVE_BUTTON = "Suprimir";
$LNG->REGSITRATION_ADMIN_REMOVE_CHECK_MESSAGE = "¿Está seguro de que deseja eliminar este usuário registrado?: ";
$LNG->REGSITRATION_ADMIN_REVALIDATE_CHECK_MESSAGE = "¿Está seguro que deseja enviar outra mensagem de validação a este usuário?: ";
$LNG->REGSITRATION_ADMIN_USER_REMOVED = 'Sua conta já foi eliminada do sistema';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REVALIDATED = 'Foi reenviado por correio eletrônico a sua solicitação de aceite';

$LNG->REGSITRATION_ADMIN_REJECT_CHECK_MESSAGE = "¿Seguro que queres rejeitar a solicitação de registro de usuário?: ";
$LNG->REGSITRATION_ADMIN_ACCEPT_CHECK_MESSAGE = "¿Seguro que queres aceitar a solicitação de registro de usuário?: ";
$LNG->REGSITRATION_ADMIN_NONE_MESSAGE = 'Atualmente não há usuários que solicitam inscrição';
$LNG->REGSITRATION_ADMIN_VALIDATION_NONE_MESSAGE = 'Atualmente não há usuários que aguardam validação';
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_NAME = "Nome";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_DESC = "Descrição";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_INTEREST = "Interesse";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_WEBSITE = "website";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION = "Ação";
$LNG->REGSITRATION_ADMIN_REJECT_BUTTON = 'Rejeitar';
$LNG->REGSITRATION_ADMIN_ACCEPT_BUTTON = 'Aceitar';
$LNG->REGSITRATION_ADMIN_ID_ERROR = 'Não se pode processar a solicitação de usuário para ID de usuário não se encontra';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_ACCEPTANCE = 'Foi enviado por correio eletrônico que sua solicitação foi aceita';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REJECTION = 'Foi enviado por correio eletrônico que sua solicitação foi rejeitada';
$LNG->REGSITRATION_ADMIN_EMAIL_REQUEST_SUBJECT = "Solicitação de inscrição para".$CFG->SITE_TITLE;

// %s will be replace with the name of the current Site. When translating please leave this in the sentence appropariately placed.
$LNG->REGSITRATION_ADMIN_EMAIL_REJECT_BODY = 'Agradecemos por solicitar a inscrição no %s.<br>Infelizmente, nesta ocasião, sua solicitação de uma conta de usuário não havia sido exitosa.';

/** SPAM MANAGEMENT **/
$LNG->SPAM_ADMIN_MANAGER_SPAM_LINK = "Itens relatados";
$LNG->SPAM_ADMIN_TITLE = "Item Administrador de informes";
$LNG->SPAM_ADMIN_ID_ERROR = "Não se pode processar a solicitação, o ID do node não se encontra";
$LNG->SPAM_ADMIN_TABLE_HEADING0 = "Informado por";
$LNG->SPAM_ADMIN_TABLE_HEADING1 = "Título";
$LNG->SPAM_ADMIN_TABLE_HEADING2 = "Ação";
$LNG->SPAM_ADMIN_DELETE_CHECK_MESSAGE = "¿Está seguro que queres eliminar este item?: ";
$LNG->SPAM_ADMIN_RESTORE_CHECK_MESSAGE = "¿Está seguro que queres estabelecer como não Spam?: ";
$LNG->SPAM_ADMIN_RESTORE_BUTTON = "Não Spam";
$LNG->SPAM_ADMIN_DELETE_BUTTON = "Apagar";
$LNG->SPAM_ADMIN_VIEW_BUTTON = "Ver detalhes";
$LNG->SPAM_ADMIN_NONE_MESSAGE = 'Atualmente não há elementos denunciados como spam / inapropriados';

$LNG->SPAM_USER_ADMIN_TABLE_HEADING0 = "Informado por";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING1 = "Nome de usuario";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING2 = "Ação";
$LNG->SPAM_USER_ADMIN_VIEW_BUTTON = "Ver página de Inicio de usuário";
$LNG->SPAM_USER_ADMIN_VIEW_HINT = "Abre una nova janela que mostre a página de inicio de usuário";
$LNG->SPAM_USER_ADMIN_RESTORE_BUTTON = "Restaurar conta";
$LNG->SPAM_USER_ADMIN_RESTORE_HINT = "Restaurar esta conta de usuário que esta ativa";
$LNG->SPAM_USER_ADMIN_DELETE_BUTTON = "Eliminar conta";
$LNG->SPAM_USER_ADMIN_DELETE_HINT = "Eliminar esta conta de usuário e todos seus dados";
$LNG->SPAM_USER_ADMIN_SUSPEND_BUTTON = "Suspender conta";
$LNG->SPAM_USER_ADMIN_SUSPEND_HINT = "Suspender esta conta de usuário e sua companhia em";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "¿Está seguro de que deseja excluir o usuário?: ";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Tenha cuidado: todos seus dados serão eliminados de forma permanente se não for feito corretamente, você deve verificar as suas contribuições primeiro clicando em '".$LNG->SPAM_USER_ADMIN_VIEW_BUTTON."'";;
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "Seguro que deseja restaurar a conta de: ";
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "Este usuário será eliminado desta lista";
$LNG->SPAM_USER_ADMIN_SUSPEND_CHECK_MESSAGE = "¿Está seguro que quer suspender a conta de?: ";
$LNG->SPAM_USER_ADMIN_NONE_MESSAGE = 'Atualmente não há usuários informados como spammers / inapropriados';
$LNG->SPAM_USER_ADMIN_Título = "Administrador de informes do usuário";
$LNG->SPAM_USER_ADMIN_MANAGER_SPAM_LINK = "Informe Usuários";
$LNG->SPAM_USER_ADMIN_ID_ERROR = "Não se pode processar a solicitação porque o ID de usuário não se encontra";
$LNG->SPAM_USER_ADMIN_NONE_SUSPENDED_MESSAGE = 'Atualmente não há usuários suspendidos';
$LNG->SPAM_USER_ADMIN_SPAM_Título = 'Usuário relatado';
$LNG->SPAM_USER_ADMIN_SUSPENDED_TITLE = 'Usuário suspenso';

/** NEWS ADMINSTRATION **/
$LNG->ADMIN_MANAGE_NEWS_LINK = "Gerir ".$LNG->NEWSS_NAME;
$LNG->ADMIN_MANAGE_NEWS_DELETE_ERROR = 'Havia um problema para eliminar '.$LNG->NEWS_NAME.' com o id:';
$LNG->ADMIN_NEWS_MISSING_NAME_ERROR = 'Deve introduzir um '.$LNG->NEWS_NAME.' título.';
$LNG->ADMIN_NEWS_ID_ERROR  = 'Passando erro '.$LNG->NEWS_NAME.' id.';
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART1 = 'Estas seguro de que queres eliminar '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART2 = '?';
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART1 = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART2 = 'Agora ele foi excluido.';
$LNG->ADMIN_NEWS_TITLE = "Gerir ".$LNG->NEWSS_NAME;
$LNG->ADMIN_NEWS_ADD_NEW_LINK = 'Adicionar '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_NAME_LABEL = 'Título:';
$LNG->ADMIN_NEWS_DESC_LABEL = 'Descrição:';
$LNG->ADMIN_NEWS_TITLE_HEADING = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_ACTION_HEADING = 'Ação';
$LNG->ADMIN_NEWS_EDIT_LINK = 'editar';
$LNG->ADMIN_NEWS_DELETE_LINK = 'excluir';

/** USER STATS **/
$LNG->ADMIN_NEWS_USERS = 'Lista de usuários';
?>
