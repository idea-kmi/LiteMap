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
 * translated by Alexandre Marino Costa
 */

/** SPAM REPORTING OF USERS **/
$LNG->SPAM_USER_REPORTED = 'O Usuário foi relatado como um Spam/inadequado';
$LNG->SPAM_USER_REPORT = 'Denunciar este Usuário como um Spam/inadequado';
$LNG->SPAM_USER_LOGIN_REPORT = 'Iniciar seção para informar que este Usuário do grupo foi identificado como Spam/inadequado';
$LNG->SPAM_USER_REPORTED_ALT = 'Denunciado';
$LNG->SPAM_USER_REPORT_ALT = 'Informe';
$LNG->SPAM_USER_LOGIN_REPORT_ALT = 'Inicie seção para denunciar';

/** USER AREA **/
$LNG->TAB_USER_DATA = 'Meus datos';
$LNG->TAB_USER_GROUP = 'Meu '.$LNG->GROUPS_NAME;
$LNG->TAB_USER_SOCIAL = 'Minha Red Social';
$LNG->TAB_USER_HOME = 'Minha página de inicio';
$LNG->TAB_USER_MAP = 'Meu '.$LNG->MAPS_NAME_SHORT;
$LNG->TAB_USER_CHALLENGE = 'Meu '.$LNG->CHALLENGES_NAME_SHORT;
$LNG->TAB_USER_ISSUE = 'Meu '.$LNG->ISSUES_NAME_SHORT;
$LNG->TAB_USER_SOLUTION = 'Meu '.$LNG->SOLUTIONS_NAME_SHORT;
$LNG->TAB_USER_PRO = 'Meu '.$LNG->PROS_NAME_SHORT;
$LNG->TAB_USER_CON = 'Meu '.$LNG->CONS_NAME;
$LNG->TAB_USER_EVIDENCE = 'Meu '.$LNG->ARGUMENTS_NAME_SHORT;
$LNG->TAB_USER_RESOURCE = 'Meu '.$LNG->RESOURCES_NAME_SHORT;
$LNG->TAB_USER_CHAT = 'Meu '.$LNG->CHATS_NAME;
$LNG->TAB_USER_COMMENT = 'Meu '.$LNG->COMMENTS_NAME;
$LNG->TAB_USER_USED_COMMENT = 'Meu Usuário'.$LNG->COMMENTS_NAME;

$LNG->LIST_NAV_USER_NO_CON = "Não ".$LNG->CONS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_PRO = "Não ".$LNG->PROS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_ISSUE = "Não ".$LNG->ISSUES_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_SOLUTION = "Não ".$LNG->SOLUTIONS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_EVIDENCE = "Não ".$LNG->ARGUMENTS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_RESOURCE = "Não ".$LNG->RESOURCES_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_COMMENT = "Não ".$LNG->COMMENTS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_MAP = "Não ".$LNG->MAPS_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_CHALLENGE = "Não ".$LNG->CHALLENGES_NAME.' encontrado';
$LNG->LIST_NAV_USER_NO_CHAT = "Não ".$LNG->CHATS_NAME.' encontrado';

/** USER HOME PAGE **/
$LNG->USER_HOME_LOCATION_LABEL = 'localização:';
$LNG->USER_HOME_TABLE_ITEM_TYPE = 'Tipos de Item';
$LNG->USER_HOME_TABLE_CREATION_COUNT = 'Contador de criação';
$LNG->USER_HOME_TABLE_VIEW = 'Vista';
$LNG->USER_HOME_TABLE_TYPE = 'Tipo';
$LNG->USER_HOME_TABLE_NAME = 'Nome';
$LNG->USER_HOME_TABLE_ACTION = 'Ação';
$LNG->USER_HOME_TABLE_PICTURE = 'Imgem';
$LNG->USER_HOME_PROFILE_HEADING = 'Perfil';
$LNG->USER_HOME_VIEW_CONTENT_HEADING = 'Conteúdo resumo de criação';
$LNG->USER_HOME_VIEW_ACTIVITIES_LINK = "( Ver toda a atividade desta pessoa )";
$LNG->USER_HOME_VIEW_ACTIVITIES_HINT =  "Se abrirá uma nova janela e pode levar algum tempo para carregar em função do volume de atividades dessa pessoa";
$LNG->USER_HOME_FOLLOWING_HEADING = 'Seguinte';
$LNG->USER_HOME_ACTIVITY_ALERT = 'Enviar Alerta por e-mail de nova atividade';
$LNG->USER_HOME_EMAIL_HOURLY = 'de hora em hora';
$LNG->USER_HOME_EMAIL_DAILY = 'Diário';
$LNG->USER_HOME_EMAIL_WEEKLY = 'Semanal';
$LNG->USER_HOME_EMAIL_MONTHLY = 'Mensual';
$LNG->USER_HOME_PERSON_LABEL = 'Pessoal';
$LNG->USER_HOME_UNFOLLOW_LINK = 'Deixar de seguir';
$LNG->USER_HOME_EXPLORE_LINK = 'Explorar';
$LNG->USER_HOME_ACTIVITY_LINK = 'Actividade';
$LNG->USER_HOME_NOT_FOLLOWING_MESSAGE = 'Não seguir qualquer pessoa ou artigos ainda.';
$LNG->USER_HOME_FOLLOWERS_HEADING = 'Seguidores';
$LNG->USER_HOME_NO_FOLLOWERS_MESSAGE = 'Não há seguidores ainda.';
$LNG->USER_HOME_ANALYTICS_LINK_TEXT = '( Ver Estatísitcas para esta pessoa )';
$LNG->USER_HOME_ANALYTICS_LINK_HINT =  "Se abrirá uma nova janela e poderá levar algum tempo para carregar em função do volume da atividade dessa pessoa";

/** USERS **/
$LNG->USERS_UNFOLLOW = 'Deixar de seguir esta pessoa...';
$LNG->USERS_FOLLOW = 'Seguir esta pessoa...';
$LNG->USERS_FOLLOW_ICON_ALT = 'Seguir';
$LNG->USERS_STARTED_FOLLOWING_ON = 'Comecei a seguir em:';
$LNG->USERS_LAST_LOGIN = 'Última seção:';
$LNG->USERS_LAST_ACTIVE = 'Última atividade:';
$LNG->USERS_DATE_JOINED = 'Data de registro:';

/** USER PAGE **/
$LNG->USER_FOLLOW_HINT = 'Siga esta pessoa...';
$LNG->USER_FOLLOW_BUTTON = 'Seguir';
$LNG->USER_UNFOLLOW_HINT = 'Deixar de seguir esta pessoa...';
$LNG->USER_UNFOLLOW_BUTTON = 'Deixar de seguir';
$LNG->USER_RSS_HINT = 'Obter um canal de RSS de ';
$LNG->USER_RSS_BUTTON = 'Canal RSS';

/** PROFILE PAGE **/
$LNG->PROFILE_TITLE = 'Editar perfil';
$LNG->PROFILE_CHANGE_PASSWORD_LINK = '(Trocar senha)';
$LNG->PROFILE_INVALID_EMAIL_ERROR = "Por favor, insira um endereço de e-mail válido.";
$LNG->PROFILE_EMAIL_IN_USE_ERROR = "O endereço de e-mail já está em uso, por favor, selecione outro.";
$LNG->PROFILE_FULL_NAME_ERROR = "Por favor, digite seu nome completo.";
$LNG->PROFILE_HOMEPAGE_URL_ERROR = "Por favor, insira uma URL válida completa (incluindo 'http://') para sua página de inicio.";
$LNG->PROFILE_SUCCESSFULLY_UPDATED_MESSAGE = 'Perfil atualizado corretamente';
$LNG->PROFILE_UPDATE_BUTTON = 'Atualização';
$LNG->PROFILE_DESC_LABEL = 'Descrição:';
$LNG->PROFILE_PHOTO_CURRENT_LABEL = 'Foto atual:';
$LNG->PROFILE_PHOTO_REPLACE_LABEL = 'Substituir a foto com:';
$LNG->PROFILE_PHOTO_LABEL = 'Foto:';
$LNG->PROFILE_LOCATION = 'Localização: (pueblo/ciudad)';
$LNG->PROFILE_COUNTRY = 'País...';
$LNG->PROFILE_HOMEPAGE = 'Página principal:';
$LNG->PROFILE_EMAIL_VALIDATE_TEXT = 'Validar e-mail';
$LNG->PROFILE_EMAIL_VALIDATE_HINT = 'Seu endereço de e-mail não foi validado. Se deseja começar uma seção Social terá que validar a propriedade do endereço de e-mail.';
$LNG->PROFILE_EMAIL_VALIDATE_MESSAGE = 'Foi enviado um e-mail para validar a propriedade do endereço de e-mail nesta conta de Usuário.';
$LNG->PROFILE_EMAIL_VALIDATE_COMPLETE = 'Este endereço de e-mail já foi validado.';
$LNG->PROFILE_EMAIL_CHANGE_CONFIRM = 'Foi mudado seu endereço de e-mail.\ nSerá necessário que este novo endereço de e-mail seja verificado.\n\nSua conta de usuário agora está bloqueada, para registro será enviado um novo e-mail de validação de conta.\nPor favor, faça um clic no link do e-mail para completar a troca de endereço de e-mail.\n\n¿Seguro que deseja continuar?';
$LNG->PROFILE_PRIVACY_MESSAGE = 'Salva meus dados:';
$LNG->PROFILE_PRIVACY_YES = '>Privado';
$LNG->PROFILE_PRIVACY_NO = '>Público';

/** ACTIVITY POPUP PAGES **/
$LNG->FORM_ACTIVITY_HEADING = 'Atividade recente para';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DATE = 'Data';
$LNG->FORM_ACTIVITY_TABLE_HEADING_TYPE = 'Tipo';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DONEBY = 'Realizado por';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ACTION = 'Ação';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ITEM = 'Item';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING = 'Começar a seguir';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING_ITEM = 'começar a seguir este item';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED = 'promovido';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED = 'rebaixado';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED_ITEM = 'promover este item';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED_ITEM = 'rebaixar este item';
$LNG->FORM_ACTIVITY_ACTION_ADDED = 'adicionar';
$LNG->FORM_ACTIVITY_ACTION_EDITED = 'editar';
$LNG->FORM_ACTIVITY_ACTION_ADDED_ITEM = 'adicionar este item';
$LNG->FORM_ACTIVITY_ACTION_EDITED_ITEM = 'editar este item';
$LNG->FORM_ACTIVITY_ACTION_ASSOCIATED = 'asosciado';
$LNG->FORM_ACTIVITY_ACTION_DESOCIATED = 'eliminar associação';
$LNG->FORM_ACTIVITY_ACTION_ADDED_RESOURCE = "adicionar o ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_PRO = "adicionar apoio ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_CON = "adicionar contador ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE = "associado esta com ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_ASSOCIATED_WITH = "associado esta com";
$LNG->FORM_ACTIVITY_ACTION_REMOVED = "eliminado";
$LNG->FORM_ACTIVITY_ACTION_REMOVED_RESOURCE = "eliminado o ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_EVIDENCE = "eliminado o ".$LNG->ARGUMENT_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_ASSOCIATION = "eliminar esta associação com";
$LNG->FORM_ACTIVITY_ACTION_INDICATED_THAT = 'ele observou que ';
$LNG->FORM_ACTIVITY_ACTION_STRONG_SOLUTION = 'era um forter '.$LNG->SOLUTION_NAME_SHORT.' para';
$LNG->FORM_ACTIVITY_ACTION_CONVINCING_EVIDENCE = 'foi convencido '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_SOUND_EVIDENCE = 'era sólido '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_PROMOTED = 'deve ser promovido com';
$LNG->FORM_ACTIVITY_ACTION_WEAK_SOLUTION = 'era fraco'.$LNG->SOLUTION_NAME_SHORT.' para';
$LNG->FORM_ACTIVITY_ACTION_UNCONVINCING_EVIDENCE = 'era pouco convincente '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_UNSOUND_EVIDENCE = 'era pouco sólido '.$LNG->ARGUMENT_NAME.' para';
$LNG->FORM_ACTIVITY_ACTION_DEMOTED = 'deve ser rebaixado com';
$LNG->FORM_ACTIVITY_LABEL_WITH = 'com';
$LNG->FORM_ACTIVITY_LABEL_FROM = 'desde';
$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE = 'Foram encontrados os seguintes problemas para recuperar os dados de atividades: ';
?>
