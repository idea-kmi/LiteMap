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
 * stats.php
 *
 * Michelle Bachler (KMi)
 * translated by Alexandre Marino Costa
 */

$LNG->LOADING_CIDASHBOARD_VISUALISATION = 'Carregamento de uma exibição ao vivo de <a/href="https://cidashbaord.net" target="_blank">CIDashboard</a>...';
$LNG->LOADING_CIDASHBOARD_ANALYTICS = 'Carregando Visual Analytics direto de <a/href="https://cidashbaord.net" target="_blank">CIDashboard</a>...';

/** STATE PAGE NAMES **/
$LNG->STATS_TAB_MAP = 'Mapa';
$LNG->STATS_TAB_VIS = 'Número de visitas';
$LNG->STATS_TAB_ANALYTICS = 'Visual Analytics';

/** STATE PAGE NAMES **/
$LNG->STATS_TAB_NETWORK = $LNG->DEBATE_NAME.' Red';
$LNG->STATS_TAB_SOCIAL = 'Red social';
$LNG->STATS_TAB_SUNBURST = 'Gente & Mapa Ring';
$LNG->STATS_TAB_STACKEDAREA = 'Contribuições';
$LNG->STATS_TAB_STREAMGRAPH = 'Contribuição Atual';
$LNG->STATS_TAB_CIRCLEPACKING = $LNG->DEBATE_NAME.' Hirerarquia';
$LNG->STATS_TAB_TOPICSPACE = 'Atividade polarizada';
$LNG->STATS_TAB_BIASSPACE = 'Clasificação polarizada';
$LNG->STATS_TAB_ACTIVITY_ANALYSIS = 'Análises de atividade';
$LNG->STATS_TAB_USER_ACTIVITY_ANALYSIS = 'Análises de atividade do usuário';
$LNG->STATS_TAB_OVERVIEW = 'Descrição rápida';
$LNG->STATS_TAB_VOTES = 'Votação';
$LNG->STATS_TAB_TREEMAP = 'Treemap - folhas';
$LNG->STATS_TAB_TREEMAPTD = 'Treemap - Top Down';
$LNG->STATS_TAB_RING = 'Gente & '.$LNG->ISSUE_NAME.' Ring';
$LNG->STATS_TAB_SUNBURST2 = 'Sunburst';

/** VISUALISATION HELP TEXTS **/

/** MAP LEVEL **/
$LNG->STATS_DEBATE_HELP_NETWORK = 'Esta exibição mostra a rede de'.$LNG->DEBATE_NAME.' contribuições. Controles de zoom e orientações disponíveis e também se pode utilizar o mouse para aumentar e diminuir.';
$LNG->STATS_DEBATE_HELP_SOCIAL = 'Esta exibição mostra uma rede de usuários que participam no '.$LNG->DEBATE_NAME.'. Controle de zoom e orientações disponíveis a continuação e também se pode utilizar o mouse para aumentar e diminuir. As conexões entre os usuários podem ser (sobre todo o apoio para as conexões), (em sua maioría conexões contador) de cor vermelha, ou cinza (sem tipo de conexão dominante verde).';
$LNG->STATS_DEBATE_HELP_SUNBURST = 'Esta visualización muestra los usuarios y sus conexiones con '.$LNG->MAPS_NAME.'. las nonexiones entre los usuarios y '.$LNG->MAPS_NAME.' puede ser verde (en su mayoría '.$LNG->PROS_NAME.'), rojo (en su mayoría '.$LNG->CONS_NAME.'), ay gris (ningún tipo de contribución domienante). Faça clic em um segmento da visualização para ver mais informações sobre esse membro ou '.$LNG->MAP_NAME.' no painel de detalhes da zona.';
$LNG->STATS_DEBATE_HELP_STACKEDAREA = 'Esta visualização mostra os tipos de contribuições através do tempo. Deslize o mouse para visualizar as estatísticas individuales para cada tipo e data. Faça clic na visualização para filtrar por tipo. Faça clic direito sobre a visualização ou pulse em "Eliminar filtro" para eliminar o filtro da visualização.';

$LNG->STATS_DEBATE_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">A seguinte visualização mostra as contribuições a um '.$LNG->DEBATE_NAME.' dispostos em um xy plot. Utilize esta visualização para encontrar aglomerados/agrupações de contribuições. Um grupo de contribuições representa contribuções similares baseados na atividade dos usuários com eles (visualização, edição, atualização de contribuciones, etc.).</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Por exemplo da parte superior direita mostra dos grupos (dos grupos distintos de las contribuciones con cada uno que tiene un patrón de actividad distinta). Por exemplo na parte inferior direita mostra somente um grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilzce esta visualização para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de la '.$LNG->DEBATE_NAME.' sendo tendenciosa sobre as pessoas que mostram interese em interagit com o '.$LNG->DEBATE_NAME.'. Se só há um grupo ou não há ninguém no grupo, então este é um indicador de que a '.$LNG->DEBATE_NAME.' é imparcial.</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Passe o mouse sobre uma contribuição para ver mais informações na "Detalhe de zona".</div></div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_DEBATE_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">A seguinte visualização mostra as contribuições a um '.$LNG->DEBATE_NAME.' dispostos sobre um xy-plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuições similares baseadas na votação dos usuários.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos das contribuições com cada um que tem um padrão de votação distinto). Por exemplo na parte inferior direita muestra sólo un grupo. Frequentemente não há grupos distintos.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice esta visualizaciones para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de la '.$LNG->DEBATE_NAME.' parcialidade com respeito para a conducta de voto da gente. Se somente há um grupo ou não há grupo, então isto é um indicador de que a '.$LNG->DEBATE_NAME.' é imparcial.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Pase el ratón sobre un punto contribución para ver más información en el "zona de detalle".</div></div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_DEBATE_HELP_CIRCLEPACKING = 'A seguinte visualização proporciona uma visão geral de todo o '.$LNG->DEBATE_NAME.' como círculos de contribuições. Faça clic em um círculo para fazer un zoom, faça clic fora de um círculo para remover. Passar por cima do circulo para ver el título del artículo como una sugerencia.';
$LNG->STATS_DEBATE_HELP_ACTIVITY = 'A seguinte visualização mostra a atividade de uma '.$LNG->DEBATE_NAME.' con el tiempo. Faça clic na linha de tempo para cubrir un período de tiempo (hacer clic y arrastrar). As visualizações debaixo mudam e se mostrará a frequência da atividade por día, o tipo de contribuição ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' y '.$LNG->CON_NAME.'), o tipo de atividade (visualizar, adicionar, ou editar), e na tabela debaixo se pode ver os dados subjacentes para as visualizações. Alí também se pode restablecer a visualização a seu estado original. Pode fazer clic en las barras de las visualizaciones para filtrar por un tipo específico. También puede seleccionar varios tipos haciendo clic en varios bars. Haga clic en, por ejemplo, en el '.$LNG->ISSUE_NAME.' y '.$LNG->SOLUTION_NAME.' bar y en la barra de visualización para filtrar por todas vistos '.$LNG->ISSUES_NAME.' y '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_DEBATE_HELP_USER_ACTIVITY = 'A visualização mostra as contribuciones dos usuarios a esta '.$LNG->DEBATE_NAME.'. Faça clic em "Usuários" para filtrar por usuario. Faça clic em "Ações do usuario" para filtrar la página por ação. Pode selecionar mais de um. Pode restablecer a página fazendo clic em "Reiniciar tudo".';
$LNG->STATS_DEBATE_HELP_STREAM_GRAPH = 'Esta visualización mostra os tipos de contribuções através do tempo. Deslize o mouse na visualização para ver as estatísticas individuales para cada tipo e para cada data. Elige entre una vista apilada, arroyo y vista ampliada para inspeccionar las contribuciones a través do tempo.';
$LNG->STATS_DEBATE_HELP_OVERVIEW = 'Estas visualizações proporcionan uma visão geral dos aspectos importantes de um '.$LNG->DEBATE_NAME.'. contem três '.$LNG->DEBATE_NAME.' indicadores de salud (se circulam sobre o sinal de interrogação ao lado de cada sinal para mais informações) e varias visualizações descrição.';

/** GROUP LEVEL **/
$LNG->STATS_GROUP_HELP_NETWORK = 'Esta visualização mostra uma rede das contribuções para a '.$LNG->DEBATES_NAME.' en esto '.$LNG->GROUP_NAME.'. Hay controles de zoom y orientación disponibles e também se pode utilizar o mouse para sinalizar e remover.';
$LNG->STATS_GROUP_HELP_SOCIAL = 'Esta visualização mostra uma rede de usuários que participam na'.$LNG->DEBATES_NAME.' neste '.$LNG->GROUP_NAME.'. Hay controles de zoom y orientación disponibles a continuación e também se pode utilizar o mouse para acrescentar sinalizar e remover. As conexões entre os usuários podem ser verde (sobre todo conexiones a favor), (em sua maioría conexões em contra) de color vermelho, y cinza (sem tipo de conexão dominante).';
$LNG->STATS_GROUP_HELP_SUNBURST = 'Esta visualização mostra os usuarios e suas conexões com '.$LNG->MAPS_NAME.'. As conexões entre os usuários e '.$LNG->MAPS_NAME.' puede ser verde (en su mayoría '.$LNG->PROS_NAME.'), roja (en su mayoría '.$LNG->CONS_NAME.'), y gris (ninguna contribución dominante). Faça clic em um segmento da visualização ver mais informações sobre este membro o '.$LNG->MAPS_NAME.' no painel de detalhes da zona.';
$LNG->STATS_GROUP_HELP_STACKEDAREA = 'Esta visualização mostra os tipos de contribuções através do tempo. Deslize o mouse na visualização para ver as estatísticas individuales para cada tipo e para cada data. Faça clic em visualização para filtrar por tipo. Faça clic direto sobre a visualização ou passe em "Eliminar filtro" para eliminar o filtro da visualização.';

$LNG->STATS_GROUP_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">A seguinte visualização mostra as contribuções para a '.$LNG->DEBATES_NAME.' neste '.$LNG->GROUP_NAME.' dispostos em um xy plot. Utilize esta visualização para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares baseados na atividade dos usuários com eles (visualização, edição, atualização das contribuições, etc.).</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Por exemplo da parte superior direita mostra os grupos (dos grupos distintos de las contribuições e cada uma tem um padrão de atividade distinta).  Por exemplo na parte inferior direita mostra somente um grupo. Frequentemente não há grupos distintos.</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilize esta visualização para detectar grupos. Se a visualização mostra mais de un grupo, então isto é um indicador de '.$LNG->DEBATE_NAME.' siendo sesgados respecto para as pessoas que mostram interese e estam interagindo com o '.$LNG->DEBATE_NAME.'. Se somente há um grupo ou não há ninguém no grupo, então este é um indicador de que a '.$LNG->DEBATE_NAME.' é imparcial.</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Passe o mouse sobre um ponto de contribuição para ver mais informação na "área de detalle".</div></div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GROUP_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">A seguiente visualização mostra as contribuições para a '.$LNG->DEBATES_NAME.' en este '.$LNG->GROUP_NAME.' dispuestos en un xy-plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares baseadas na votação dos usuários.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Por exemplo da parte superior direita mostra os grupos (dos grupos distintos de las contribuciones con cada uno que tiene un patrón de votación distinto). El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilize esta visualização para detectar grupos. Se a visualização mostra mais de un grupo, entonces esto es un indicador de la'.$LNG->DEBATE_NAME.' parcialidad con respecto a la conducta de voto de la gente. Si sólo hay un grupo o ningún grupo, entonces esto es un indicador de que la '.$LNG->DEBATE_NAME.' é imparcial.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Passe o mouse sobre um ponto de contribução para ver mais informações na "zona Detalle".</div></div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GROUP_HELP_CIRCLEPACKING = 'A seguinte visualização proporciona uma visão geral de todos os '.$LNG->DEBATES_NAME.' neste '.$LNG->GROUP_NAME.' como círculos anidados de contribuciones. Haga clic en un círculo para hacer un zoom, haga clic fuera de un círculo para alejar. Pasar por encima de circulo para ver el título del artículo como una sugerencia.';

$LNG->STATS_GROUP_HELP_ACTIVITY = 'A seguinte visualização mostra a atividade da '.$LNG->DEBATES_NAME.' neste '.$LNG->GROUP_NAME.'com o tempo. Faça clic na linha de tempo para escolher um período de tempo (fazer clic e arrastrar). As visualizaciones de abaixo mudarão e será mostrada a frequência da atividade por día, e o tipo de contribução ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' y '.$LNG->CON_NAME.'), e tipo de atividade (visualização, adicionado, ou a edição), e na tabela abaixo será possível ver os dados subjacentes das visualizações. Alí também será possível restabelecer a visualização para seu estado original. Pode fazer clic nas barras de visualizações para filtrar para um tipo específico. Também pode selecionar varios tipos fazendo clic em varios bares. Faça clic em, por exemplo, no '.$LNG->ISSUE_NAME.' y '.$LNG->SOLUTION_NAME.' bar e na barra de visualização para filtrar por todos os vistos '.$LNG->ISSUES_NAME.' y '.$LNG->SOLUTIONS_NAME.'.';

$LNG->STATS_GROUP_HELP_USER_ACTIVITY = 'A visualização mostra as contribuições dos usuários para a '.$LNG->DEBATES_NAME.' neste '.$LNG->GROUP_NAME.'. Faça clic en la tabla de "Usuarios" para filtrar por usuario. Haga clic en "Acciones del usuario" para filtrar la página por acción. En tanto, puede seleccionar más de uno. Puede restablecer la página haciendo clic en "Reiniciar todo".';
$LNG->STATS_GROUP_HELP_STREAM_GRAPH = 'Esta visualização mostra os tipos de citação através do tempo. Deslize o mouse na visualização para ver as estatísticas individuales para cada tipo y para cada fecha. Elige entre una vista apilada, arroyo y vista ampliada para inspeccionar las contribuciones a través del tiempo.';
$LNG->STATS_GROUP_HELP_OVERVIEW = 'Esta visualização proporciona uma visão geral dos aspectos importantes da'.$LNG->DEBATES_NAME.' neste '.$LNG->GROUP_NAME.'. contém tres '.$LNG->DEBATE_NAME.' indicadores de salud (flotan sobre el signo de interrogación al lado de cada semáforo para más información) y la descripción de varias visualizaciones.';

/** GLOBAL LEVEL **/
$LNG->STATS_GLOBAL_HELP_NETWORK = 'Esta visualização mostra uma rede das contribuições para a '.$LNG->DEBATES_NAME.' neste site. Hay controles de zoom y orientación disponibles y también se puede utilizar la rueda del ratón para acercar y alejar.';
$LNG->STATS_GLOBAL_HELP_SOCIAL = 'Esta visualização mostra uma rede de usuários que participam na '.$LNG->DEBATES_NAME.' neste site. Hay controles de zoom y orientación disponibles y también se puede utilizar la rueda del ratón para acercar y alejar. Las conexiones entre los usuarios pueden ser verdes (sobre todo el apoyo a las conexiones), (en su mayoría conexiones contrarias) de color rojo, y gris (sin tipo de conexión dominante).';
$LNG->STATS_GLOBAL_HELP_SUNBURST = 'Esta visualização mostra os usuários e suas conexões com '.$LNG->MAPS_NAME.'. Las conexiones entre los usuarios y '.$LNG->MAPS_NAME.' puede ser verdes (en su mayoría '.$LNG->PROS_NAME.'), rojas (en su mayoría '.$LNG->CONS_NAME.'), y grises (ningún tipo contribución dominante). Haga clic en un segmento da visualização ver mais informação sobre este membro ou '.$LNG->MAPS_NAME.' no painel de detalhes zona.';
$LNG->STATS_GLOBAL_HELP_STACKEDAREA = 'Esta visualização mostra os tipos de citação através do tempo. Deslize o mouse na visualização para ver as estatísticas individuales para cada tipo y para cada fecha. Haga clic en la visualización para filtrar por tipo. Haga clic derecho sobre la visualización o pulse el "Eliminar filtro" para eliminar el filtro de la visualización.';

$LNG->STATS_GLOBAL_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">A seguinte visualização mostra as contribuições para a '.$LNG->DEBATES_NAME.' neste site disposta em um xy-plot. Utilize esta visualização para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares baseados na atividade dos usuários com eles (visualizacão, edição, atualização das contribuições, etc.).</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">POr exemplo da parte superior direita mostra os grupos (dos grupos distintos das contribuições com cada um que teme um padrão de votación distinto).  El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilize esta visualização para detectar grupos. Se a visualização mostra mais de un grupo, então este é um indicador da '.$LNG->DEBATE_NAME.' siendo sesgados respecto a las personas que muestran interés y están interactuando con el '.$LNG->DEBATE_NAME.'. Se somente há um grupo ou não há ninguem no grupo, então este é um indicador de que a '.$LNG->DEBATE_NAME.' é imparcial.</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Passe o mouse sobre uma contribuição para ver mai informações na "área de detalle".</div></div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GLOBAL_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">A seguinte visualização mostra as contribuções para a '.$LNG->DEBATES_NAME.' neste site disponível em um xy plot. Utilize esta visualização para encontrar racimos/agrupaciones de contribuições. Um grupo de contribuciones representa contribuciones similares baseadas na votação dos usuários.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos das contribuições com cada um que tem um padrão de votación distinto).  El ejemplo en la parte inferior derecha muestra sólo un grupo. Frequentemente não há grupos distintos.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice esta visualizaciones para detectar grupos. Se a visualização mostra mais de um grupo, então este é um indicador da '.$LNG->DEBATE_NAME.' parcialidad con respecto a la conducta de voto de la gente. Se somente há um grupo ou ninguém no grupo, então este é um indicador de que a '.$LNG->DEBATE_NAME.' é imparcial.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Passe o mouse sobre uma contribuição para ver mais informações na "área de detalle".</div></div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GLOBAL_HELP_CIRCLEPACKING = 'A seguinte visualização proporciona uma visão geral de todos os '.$LNG->DEBATES_NAME.' neste site como círculos anidados de contribuciones. Faça clic em um círculo para fazer um zoom, faça clic fora de um círculo para remover. Passar por cima de círculo para ver el título del artículo como una sugerencia.';
$LNG->STATS_GLOBAL_HELP_ACTIVITY = 'A seguinte visualização mostra a atividade da '.$LNG->DEBATES_NAME.' com o tempo. Faça clic na linha de tempo para cubrir un período de tiempo (hacer clic y arrastrar). As visualizações debaixo mudam e se mostrará a frequencia de atividade por día, o tipo de contribuição ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' and '.$LNG->CON_NAME.'), the type of activity (viewing, adding, or  editing), and in the table below you can see the data underlying the visualisations.  There you can also reset the visualisation to its original state. You can click on the bars of the visualisations to filter for a specific type. You can also select several types by clicking on several bars. Click for example on the '.$LNG->ISSUE_NAME.' and '.$LNG->SOLUTION_NAME.' bar and on the viewing bar to filter for all viewed '.$LNG->ISSUES_NAME.' and '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_GLOBAL_HELP_USER_ACTIVITY = 'A visualização mostra as contribuições dos usuários para a '.$LNG->DEBATES_NAME.' neste site. Faça clic na tabela de "Usuários" para filtrar por usuario. Faça clic em "Ações do usuário" para filtrar a página por ação. Entretanto, pode selecionar mais de um. Pode restablecer a página fazendo clic em "Reiniciar todo".';
$LNG->STATS_GLOBAL_HELP_STREAM_GRAPH = 'Esta visualização mostra os tipos de citações através do tempo. Deslize o mouse na visualização para ver as estatísticas individuales para cada tipo e para cada data. Deslize entre uma vista apilada, arroyo y vista ampliada para inspecionar as contribuições através do tempo.';
$LNG->STATS_GLOBAL_HELP_OVERVIEW = 'Esta visualização proporciona uma visão geral dos aspectos importantes da '.$LNG->DEBATES_NAME.' neste site. Contém três '.$LNG->DEBATE_NAME.' indicadores de saudação (apresenta-se sobre o sinal de interrogação ao lado de cada sinal para mais informações) e varias visualizações descritas.';

/** OVERVIEW PAGE **/
$LNG->STATS_OVERVIEW_MAIN_TITLE='Visão do conjunto';
$LNG->STATS_OVERVIEW_WORDS_MESSAGE = 'Estatísticas de contagem de Palavras:';
$LNG->STATS_OVERVIEW_CONTRIBUTION_MESSAGE = 'Contribuições do usuário';
$LNG->STATS_OVERVIEW_VIEWING_MESSAGE = "Atividade de visualização do usuário";
$LNG->STATS_OVERVIEW_HEALTH_TITLE = $LNG->DEBATE_NAME.' Indicadores de saudação';
$LNG->STATS_OVERVIEW_HEALTH_PROBLEM = 'Existe um problema.';
$LNG->STATS_OVERVIEW_HEALTH_NO_PROBLEM = 'Não parece haver nenhum problema.';
$LNG->STATS_OVERVIEW_HEALTH_MAYBE_PROBLEM = 'Pode haver um problema.';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_TITLE = 'Indicador da atividade de contribuições';
$LNG->STATS_OVERVIEW_HEALTH_VIEWING_TITLE = 'Vendo o indicador de atividade';
$LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_TITLE = 'Indicador de participação';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTORS = 'participaram neste'.$LNG->DEBATE_NAME.".";
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS = 'conectado';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_PART2 = 'visto este '.$LNG->DEBATE_NAME;
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_RED = ' nos últimos 14 días';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_ORANGE = ' feito entre 6 e 14 días';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_GREEN = ' nos últimos 5 días';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION = ' contribuições';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_RED = ' nos últimos 14 días';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_ORANGE = ' feito entre 6 e 14 días';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_GREEN = ' nos últimos 5 días';
$LNG->STATS_OVERVIEW_LOADING_MESSAGE = '(Carregando Resumo de Estatísticas. Isto pode levar algum tempo para calcular em função do tamanho dos dados do discurso...)';
$LNG->STATS_OVERVIEW_TOP_THREE_VOTES_MESSAGE = 'Entradas mais votadas:';
$LNG->STATS_OVERVIEW_RECENT_NODES_MESSAGE = 'Recentemente adicionado:';
$LNG->STATS_OVERVIEW_RECENT_VOTES_MESSAGE = 'Mais recentemente votada:';
$LNG->STATS_OVERVIEW_DATE = 'Data:';
$LNG->STATS_OVERVIEW_VOTES = 'Votos:';
$LNG->STATS_OVERVIEW_TIME = 'tempo';
$LNG->STATS_OVERVIEW_TIMES = 'número de vezes';
$LNG->STATS_OVERVIEW_PERSON = 'pessoa';
$LNG->STATS_OVERVIEW_PEOPLE = 'gente';
$LNG->STATS_OVERVIEW_WORDS_AVERAGE = 'Contribução média:';
$LNG->STATS_OVERVIEW_WORDS = 'palavras';
$LNG->STATS_OVERVIEW_WORDS_MIN = 'minimo:';
$LNG->STATS_OVERVIEW_WORDS_MAX = 'máximo:';
$LNG->STATS_OVERVIEW_VIEWING_HIGHEST = 'Contagem de visualização alto';
$LNG->STATS_OVERVIEW_VIEWING_LOWEST = 'Contagem de visualização baixo';
$LNG->STATS_OVERVIEW_VIEWING_LAST = 'Contagem de visualização baixo';
$LNG->STATS_OVERVIEW_VIEWING_VIEWS = 'visitas';
$LNG->STATS_OVERVIEW_VIEWING_ON = 'on';
$LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_HINT = 'Se há menos de 3 pessoas que tenham participado deste '.$LNG->DEBATE_NAME.' então será mostrado um sinal em vermelho. Se entre 3 e 5 pessoas tenham participado nesta '.$LNG->DEBATE_NAME.' então será mostrado um sinal laranja. Se mais de 5 pessoas tenham participado neste '.$LNG->DEBATE_NAME.' então será mostrado um sinal em verde.';
$LNG->STATS_OVERVIEW_HEALTH_VIEWING_HINT = 'Se existem conectadas pessoas que tenham visto este '.$LNG->DEBATE_NAME.' durante mais de 14 días, será mostrado um sinal vermelho. Se foram conectados pessoas que tenham visto este '.$LNG->DEBATE_NAME.' feito entre 6 e 14 días será mostrado um sinal laranja. Se foram conectadas pessoas que tenham visto este '.$LNG->DEBATE_NAME.' nos últimos 5 días será mostrado um sinal em verde.';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_HINT = 'Si la gente no ha añadido una nueva entrada a esta '.$LNG->DEBATE_NAME.' durante más de 14 días, este mostrará un semáforo en rojo. Si la gente ha añadido una nueva entrada a esta '.$LNG->DEBATE_NAME.' entre 6 y 14 días hace que se muestre en un semáforo naranja. Si la gente ha añadido una nueva entrada a esta '.$LNG->DEBATE_NAME.' en los últimos 5 días que se muestre en un semáforo en verde.';

/** ISSUE SIDE STATS **/
$LNG->STATS_DEBATE_HEALTH_TITLE = $LNG->DEBATE_NAME.' Indicadores de saudações';
$LNG->STATS_DEBATE_HEALTH_MESSAGE = 'Faça clic em cada sinal para mais informações';
$LNG->STATS_DEBATE_HEALTH_EXPLORE = 'Explorar mais:';

$LNG->STATS_DEBATE_PARTICIPATION_TITLE = 'Participação';

$LNG->STATS_DEBATE_CONTRIBUTION_TITLE = 'Indicador de equilibrio';
$LNG->STATS_DEBATE_CONTRIBUTION_MESSAGE = 'A conversa é benéfica';
$LNG->STATS_DEBATE_AND = 'e';
$LNG->STATS_DEBATE_CONTRIBUTION_GREEN = 'os tipos de contribuições estão equilibradas.';
$LNG->STATS_DEBATE_CONTRIBUTION_HELP = 'Este sinal indica como estam equilibrados os tipos de contribuições no debate. Se um dos tipos ('.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.', '.$LNG->CON_NAME.', o '.$LNG->VOTES_NAME.') está representada (por menos de 10%) será mostrado um sinal em vermelho. Se um dos tipos é subrepresentado (menos de 20%) então será mostrado um sinal amarelo. Caso contrário, os tipos estão em equilíbrio e será mostrado um sinal sinal em verde.';

$LNG->STATS_DEBATE_VIEWING_TITLE = 'pensamento do grupo';
$LNG->STATS_DEBATE_VIEWING_HELP = 'Este indicador representa a porcentagem de membros deste grupo que viram este assunto. Se 50% ou mais membros deste grupo viram este tema a continuação se mostrará um sinal em verde. Se entre 20% e 49% consideram que a continuação é importante será mostrado um sinal amarelo. Se menos de 20% apresentarem considerações este tema será mostrado um sinal em vermelho.';
$LNG->STATS_DEBATE_VIEWING_MESSAGE_PART1 = 'de este grupo de';
$LNG->STATS_DEBATE_VIEWING_MESSAGE_PART2 = 'visto este'.$LNG->DEBATE_NAME.'.';

$LNG->STATS_DASHBOARD_HELP_HINT = "Faça clic para mostrar/ocultar a descrição de visualização.";

/** GROUP STATS **/
$LNG->STATS_GROUP_TITLE = 'Analiticas de grupo para: ';

$LNG->STATS_ACTIVITY_COLUMN_DATE = 'Data';
$LNG->STATS_ACTIVITY_COLUMN_TITLE = 'Título';
$LNG->STATS_ACTIVITY_COLUMN_ITEM_TYPE = 'Tipo de contribuição';
$LNG->STATS_ACTIVITY_COLUMN_TYPE = 'Tipo de atividade';
$LNG->STATS_ACTIVITY_COLUMN_ACTION = 'Ação do usuário';
$LNG->STATS_ACTIVITY_FILTER_DATE_TITLE = 'Data';
$LNG->STATS_ACTIVITY_FILTER_MONTH_TITLE = 'Mês';
$LNG->STATS_ACTIVITY_FILTER_DAYS_TITLE = 'Dia da semana';
$LNG->STATS_ACTIVITY_FILTER_ITEM_TYPES_TITLE = 'Tipos de contribuições';
$LNG->STATS_ACTIVITY_FILTER_TYPES_TITLE = 'Tipos de atividades';
$LNG->STATS_ACTIVITY_FILTER_USERS_TITLE = 'Usuários';
$LNG->STATS_ACTIVITY_FILTER_ACTION_TITLE = 'Ações do usuário';
$LNG->STATS_ACTIVITY_USER_ANONYMOUS = "u";
$LNG->STATS_ACTIVITY_USER_ANONYMOUS_NAME = "Usuário Desconhecido";

$LNG->STATS_ACTIVITY_CREATE = 'Criar';
$LNG->STATS_ACTIVITY_UPDATE = 'Atualização';
$LNG->STATS_ACTIVITY_DELETE = 'Apagar';
$LNG->STATS_ACTIVITY_VIEW = 'Ver';
$LNG->STATS_ACTIVITY_VOTE = 'Votar';
$LNG->STATS_ACTIVITY_VOTED_FOR = 'Votos a favor';
$LNG->STATS_ACTIVITY_VOTED_AGAINST = 'Votos contra';

$LNG->STATS_ACTIVITY_SUNDAY = 'Domingo';
$LNG->STATS_ACTIVITY_MONDAY = 'Segunda-feira';
$LNG->STATS_ACTIVITY_TUESDAY = 'Terça-feira';
$LNG->STATS_ACTIVITY_WEDNESDAY = 'Quarta-feira';
$LNG->STATS_ACTIVITY_THURSDAY = 'Quinta-feira';
$LNG->STATS_ACTIVITY_FRIDAY = 'Sexta-feira';
$LNG->STATS_ACTIVITY_SATURDAY = 'Sábado';

$LNG->STATS_ACTIVITY_JAN = 'Janeiro';
$LNG->STATS_ACTIVITY_FEB = 'Fevereiro';
$LNG->STATS_ACTIVITY_MAR = 'Março';
$LNG->STATS_ACTIVITY_APR = 'Abril';
$LNG->STATS_ACTIVITY_MAY = 'Maio';
$LNG->STATS_ACTIVITY_JUN = 'Junho';
$LNG->STATS_ACTIVITY_JUL = 'Julho';
$LNG->STATS_ACTIVITY_AUG = 'Agosto';
$LNG->STATS_ACTIVITY_SEP = 'Setembro';
$LNG->STATS_ACTIVITY_OCT = 'Outubro';
$LNG->STATS_ACTIVITY_NOV = 'Novembro';
$LNG->STATS_ACTIVITY_DEC = 'Dezembro';

$LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART1 = 'selecionado de';
$LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART2 = 'arquivos';
$LNG->STATS_ACTIVITY_RESET_ALL_BUTTON = 'Reniciar tudo';

$LNG->STATS_SCATTERPLOT_DETAILS_COUNT = "Entradas:";
$LNG->STATS_SCATTERPLOT_DETAILS = "Área de detalhes";
$LNG->STATS_SCATTERPLOT_DETAILS_CLICK = "Passe o mouse sobre a contribuição para ver os detalhes.";

$LNG->STATS_GROUP_STACKEDAREA_TITLE = 'Chave';
$LNG->STATS_GROUP_STACKEDAREA_HELP = 'Passe o mouse sobre um área de cor em um momento dado para mostrar a contagem das contribuciones para ese tipo de elemento e para esta data.<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_HELP .= 'Faça clic no botão esquerdo em um área colorida para filtrar diagrama nese tipo de elemento.<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_HELP .= 'Faça clic no botão direito para eliminar o filtro (ou faça clic no botão de baixo).<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_RESTORE_BUTTON = 'Remover filtro';
$LNG->STATS_GROUP_STACKEDAREA_ERROR = 'Não há dados suficientes disponíveis para desenhar atualmente esta visualização.';

$LNG->STATS_GROUP_SUNBURST_PERSON = 'Membro';
$LNG->STATS_GROUP_SUNBURST_DEBATE = $LNG->MAP_NAME;
$LNG->STATS_GROUP_SUNBURST_CONNECTED_DEBATE = 'foi contribuida por:';
$LNG->STATS_GROUP_SUNBURST_CONNECTED_USER = 'e está conectado a:';
$LNG->STATS_GROUP_SUNBURST_WITH = 'com:';
$LNG->STATS_GROUP_SUNBURST_CREATED = 'criado:';
$LNG->STATS_GROUP_SUNBURST_DETAILS = "Detalhes da zona";
$LNG->STATS_GROUP_SUNBURST_DETAILS_CLICK = "Faça clic na seção para ver mais detalhes";
$LNG->STATS_GROUP_SUNBURST_DEBATE_CREATED = $LNG->ISSUES_NAME.":";
$LNG->STATS_GROUP_SUNBURST_DEBATE_OWNED = $LNG->ISSUES_NAME." proprietário";
$LNG->STATS_GROUP_OVERVIEW_USED_LINKS_LABEL = 'Mais comum '.$LNG->ISSUES_NAME.' atividade';
$LNG->STATS_GROUP_OVERVIEW_USED_IDEAS_LABEL = 'O tipo de contribuições mais comuns';

/** DEBATE STATS **/
$LNG->STATS_DEBATE_TITLE = $LNG->MAP_NAME.' Analytics para: ';
$LNG->STATS_DEBATE_OVERVIEW_TOP_NODETYPE_USAGE = 'Item tipo de uso';

/** GLOBAL STATS **/
$LNG->HOMEPAGE_STATS_LINK = "Analytics";

/// Connections page
$LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE = 'o mais conectado '.$LNG->ISSUES_NAME;
$LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE = 'o mais conectado'.$LNG->SOLUTIONS_NAME;
$LNG->OVERVIEW_RESOURCE_MOSTCONNECTED_TITLE = 'o mais conectado '.$LNG->RESOURCES_NAME;
$LNG->OVERVIEW_PRO_MOSTCONNECTED_TITLE = 'o mais conectado'.$LNG->PROS_NAME;
$LNG->OVERVIEW_CON_MOSTCONNECTED_TITLE = 'o mais conectado '.$LNG->CONS_NAME;

$LNG->STATS_GLOBAL_TITLE = 'Global Analytics';
$LNG->STATS_GLOBAL_TAB_IDEAS = 'Items Criados';

$LNG->STATS_GLOBAL_VOTES_TOP_NODES = 'Top 10 Votados ON Items';
$LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES = "Top 10 Votações Items A FAVOR";
$LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES = "Top 10 Votações Items CONTRA";
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING = 'Nome';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING = 'Total';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING = 'A favor';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING = 'contra';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING = "Categoría";
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS = 'Top 10 Votações';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_FOR = 'Top 10 Votações a FAVOR';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_AGAINST = 'Top 10 votações CONTRA';
$LNG->STATS_GLOBAL_VOTES_VOTING_MENU_TITLE = 'Vista superior de votação de artigos';
$LNG->STATS_GLOBAL_VOTES_VOTERS_MENU_TITLE = 'Ver Top Votantes artigos';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTES_MENU_TITLE = 'Ver todas as votações de artículo';
$LNG->STATS_GLOBAL_VOTES_BACK_UP = 'Voltar ao menú de opções';
$LNG->STATS_GLOBAL_VOTES_MENU_TITLE = 'Estatísticas de voto';
$LNG->STATS_GLOBAL_ITEM_VOTES_MENU_TITLE = 'Estatísticas de artigos votados';
$LNG->STATS_GLOBAL_CONNECTION_VOTES_MENU_TITLE = 'Estatísticas de conexões de voto';
$LNG->STATS_GLOBAL_ALL_VOTES_MENU_TITLE = 'Todas as estatísticas dos votos';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTING_TITLE = 'Todos os items votados';
$LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING = 'Item a favor';
$LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING = 'Item contra';
$LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING = 'Conexão a favor';
$LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING = 'Conexão contra';

$LNG->STATS_GLOBAL_OVERVIEW_HEADER_TYPE = 'Tipo';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_NAME = 'Nome';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_COUNT = 'Contagem';
$LNG->STATS_GLOBAL_OVERVIEW_USED_LINKS_LABEL = 'A maior atividade comum';
$LNG->STATS_GLOBAL_OVERVIEW_USED_IDEAS_LABEL = 'A contribuição mais comum';
$LNG->STATS_GLOBAL_OVERVIEW_CONNECTED_IDEA_LABEL = 'Tema mais conectado';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS = 'Top construtores de conexão';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_IDEA_CREATORS = 'Top criadores de Item';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS_LINKS = 'Top construtores de conexão - seu uso LinkType';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART1 = 'Para ver seu análise pessoal ir para sua';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART2 = 'página de inicio';

$LNG->STATS_GLOBAL_REGISTER_TOTAL_LABEL = 'Contagem total de usuários';
$LNG->STATS_GLOBAL_REGISTER_HEADER_NAME = 'Nome';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DATE = 'Data';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DESC = 'Descrição';
$LNG->STATS_GLOBAL_REGISTER_HEADER_WEBSITE = 'Website';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LOCATION = 'Localização';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LAST_LOGIN = 'Última sessão';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_TITLE = 'Registro de usuários por meses';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_TITLE = 'REgistro de usuários por semana';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_X_LABEL = 'Número de inscrições';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_Y_LABEL = 'Meses (de';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_Y_LABEL = 'Semanas (de';

$LNG->STATS_GLOBAL_IDEAS_TOTAL_LABEL = 'Conta total';
$LNG->STATS_GLOBAL_IDEAS_MONTHLY_TOTAL_LABEL = 'Total mensal';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_TITLE  ='Criação de artigo semanal no último ano';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_TITLE  ='Criação de atigo mensal no último ano';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_Y_LABEL = 'Meses (de';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_Y_LABEL = 'Semanas (de';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_X_LABEL = 'Número de ideias';

$LNG->STATS_GLOBAL_CONNS_TOTAL_LABEL = 'Contagem total de conexões';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_TITLE  ='Criação de conexão semanal no último ano';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_TITLE  ='Criação de conexão mensual no último ano';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_Y_LABEL = 'Meses (de';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_Y_LABEL = 'Semanas (de';
$LNG->STATS_GLOBAL_CONNS_GRAPH_X_LABEL = 'Número de conexões';

/** USER STATS **/
$LNG->STATS_USER_TITLE = 'Estatísticas de';
$LNG->STATS_USER_NAME_HEADING = 'Nome';
$LNG->STATS_USER_ITEM_HEADING = 'Item';
$LNG->STATS_USER_COUNT_HEADING = 'Contador';
$LNG->STATS_USER_ACTION_HEADING = 'Ação';
$LNG->STATS_USER_POPULAR_LINK_HEADING = 'Tipos de link mais usados';
$LNG->STATS_USER_VIEW_ALL = 'Ver tudo';
$LNG->STATS_USER_POPULAR_NODE_HEADING = 'Os tipos denosos mais usados';
$LNG->STATS_USER_POPULAR_TAG_HEADING = 'As etiquetas mais usadas';
$LNG->STATS_USER_TOP_TEN = 'top 10';
$LNG->STATS_USER_COUNT_HEADING = 'Contar';
$LNG->STATS_USER_LINK_TYPES_HEADING = 'Tipo de link';
$LNG->STATS_USER_NODE_TYPES_HEADING = 'Tipo de nós';
$LNG->STATS_USER_COMPARED_THINKING = 'Pensamento em comparação';
$LNG->STATS_USER_INFORMATION_THINKING = 'Informação Broker';
$LNG->STATS_USER_SUMMARY_TITLE = 'RESUMO';
$LNG->STATS_USER_VOTE_TITLE = 'Votar Item';

/** GRAPH BUTTONS ETC.. **/
$LNG->GRAPH_PRINT_HINT = "Imprimir este gráfico da rede";
$LNG->GRAPH_ZOOM_FIT_HINT = "Ajustar a página: Ampliar gráfico para abaixo se for necessário e passe a faze-lo em área visível";
$LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT = "Reduzir este gráfico da rede em 100%";
$LNG->GRAPH_ZOOM_IN_HINT = "Ampliar o zoom";
$LNG->GRAPH_ZOOM_OUT_HINT = "Diminuir o zoom";
$LNG->GRAPH_CONNECTION_COUNT_LABEL = 'Conexões:';
$LNG->GRAPH_NOT_SUPPORTED = 'Seu navegador atual não admite HTML5 Canvas.<br><br>Por favor, atualice para uma nova versão se si deseja ver esta visualização: IE 9.0+; Firefox 23.0+; Chrome 29.0+; Opera 17.0+; Safari 5.1+';

/** NETWORK MAPS **/
$LNG->NETWORKMAPS_RESIZE_MAP_HINT = 'Reduzir Mapa';
$LNG->NETWORKMAPS_ENLARGE_MAP_LINK = 'Ampliar Mapa';
$LNG->NETWORKMAPS_REDUCE_MAP_LINK = 'Reduzir Mapa';
$LNG->NETWORKMAPS_EXPLORE_ITEM_LINK = 'Explorar Item';
$LNG->NETWORKMAPS_EXPLORE_ITEM_HINT = 'Abra a página completa detalhes para o elemento atual';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_LINK = 'Explorar Autor';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_HINT = 'Ir para a página principal para o item autor';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_CONNECTION_HINT = 'Ir para a página principal para a conexão autor';
$LNG->NETWORKMAPS_SELECTED_NODEID_ERROR = 'Por favor, assegure de que foi feita uma seleção no mapa.';
$LNG->NETWORKMAPS_MAC_PAINT_ISSUE_WARNING = '(Esta visualização requer Java 7 em MacOS X 10.7 para a frente (Lion) para que funcione corretamente)';
$LNG->NETWORKMAPS_APPLET_NOT_RECOGNISED_ERROR = '(Seu navegador reconhece o elemento APPLET mas não se executa o applet.)';
$LNG->NETWORKMAPS_LOADING_MESSAGE = '(Carregando mapa...)';
$LNG->NETWORKMAPS_APPLET_REF_BROKEN_ERROR = 'Mapa Applet de referência roto. Por favor, reinicie seu navegador.';
$LNG->NETWORKMAPS_NO_RESULTS_MESSAGE = 'Não se encontraram resultados. Por favor, selecione novamente.';
$LNG->NETWORKMAPS_OPTIONAL_TYPE = 'e, opcionalmente, um tipo';
$LNG->NETWORKMAPS_KEY_SELECTED_ITEM = 'Item selecionado';
$LNG->NETWORKMAPS_KEY_FOCAL_ITEM = 'Item focal';
$LNG->NETWORKMAPS_KEY_NEIGHBOUR_ITEM = 'Item vizinho';
$LNG->NETWORKMAPS_KEY_SOCIAL_MODERATELY = 'Moderadamente conectados';
$LNG->NETWORKMAPS_KEY_SOCIAL_HIGHLY = 'Altamente conectados';
$LNG->NETWORKMAPS_KEY_SOCIAL_SLIGHTLY = 'Ligeramente conectado';
$LNG->NETWORKMAPS_KEY_SOCIAL_MOST = 'O mais conectado';
$LNG->NETWORKMAPS_PERCENTAGE_MESSAGE = '% do desenho computado...';
$LNG->NETWORKMAPS_SCALING_MESSAGE = 'Redimensionada para caber na página...';

$LNG->NETWORKMAPS_SOCIAL_ITEM_HINT = "Abra a página principal da pessoa seleccionada";
$LNG->NETWORKMAPS_SOCIAL_ITEM_LINK = 'Explorar pessoa selecionada';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT = 'Mostrar todas as conexões para o link selecionado';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_LINK = 'Explorar link seleccionado';
$LNG->NETWORKMAPS_SOCIAL_LOADING_MESSAGE = '(Carregando vista de Rede Social. Isto pode levar alguns minutos para calcular em função do tamanho do Hub...)';
$LNG->NETWORKMAPS_SOCIAL_NO_RESULTS_MESSAGE = 'Não há dados para calcular a Rede Social de.';
$LNG->NETWORKMAPS_SOCIAL_CONNECTIONS = 'Conexões';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION = 'Conexão';

/** LITEMAP SPECIFIC **/
$LNG->GRAPH_EMBEDEDIT_HINT = "Copiar o código iframe para inserir este como um mapa editado em outro site";
$LNG->GRAPH_EMBEDEDIT_MESSAGE = "Por favor, copie o seguinte código para integrar este ".$LNG->MAP_NAME." en otro sitio web. Para os ".$LNG->MAPS_NAME." em um ".$LNG->GROUP_NAME.", fazer ".$LNG->GROUP_NAME." deixe em aberto e serão adicionadas outras pessoas automaticamente ao ".$LNG->GROUP_NAME." quando iniciar a secão:";
$LNG->GRAPH_EMBED_HINT = "Copiar o código iframe para inserir este como um único mapa lido em outro site";
$LNG->GRAPH_EMBED_MESSAGE = "Por favor, copie o seguinte código para inserir este mapa em outra página web:";
$LNG->GRAPH_HELP_HINT = "Ajuda de mapa";
$LNG->NETWORKMAPS_VIEW_LINEAR = 'Ver linear';
$LNG->NETWORKMAPS_VIEW_MAP = 'Ver mapa';

$LNG->GRAPH_JSONLD_HINT = "Obtenha a chamada API de descanso para trazer a representação jsonld deste mapa.";
$LNG->GRAPH_JSONLD_MESSAGE = "Copia este link em seu navegador para buscar a representação jsonld deste mapa.";
$LNG->GRAPH_JSONLD_HINT_GROUP = "Obtenha a chamada API de descanso para trazer a representação jsonld dos mapas neste grupo.";
$LNG->GRAPH_JSONLD_MESSAGE_GROUP = "Copia este link em seu navegador para buscar a representação jsonld dos mapas neste grupo.";

$LNG->GRAPH_LINK_MESSAGE = 'Copie o seguinte link para obter a url que representa este nó neste '.$LNG->MAP_NAME;
$LNG->GRAPH_LINK_HINT = 'Faça clic para obter uma url a este nó neste '.$LNG->MAP_NAME;


// ALERT MESSAGES

$LNG->ALERTS_BOX_TITLE = 'Alertas';

//RETURNS POSTS / PEOPLE BASED
$LNG->ALERT_UNSEEN_BY_ME = "Invisível para min";
$LNG->ALERT_HINT_UNSEEN_BY_ME = "Eu não vi esta postagem ainda.";

$LNG->ALERT_RESPONSE_TO_ME = "Resposta a minha mensagem";
$LNG->ALERT_HINT_RESPONSE_TO_ME = "Esta mensagem é uma resposta a uma postagem de minha autoría.";

$LNG->ALERT_UNRATED_BY_ME = "Não votar por mim";
$LNG->ALERT_HINT_UNRATED_BY_ME = "Eu ainda não votei nesta postagem.";

$LNG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME = "Visto por pessoas similares a mim";
$LNG->ALERT_HINT_INTERESTING_TO_PEOPLE_LIKE_ME = "Esta postagem foi vista por pessoas com interesses similares aos meus ( baseado em análises dos padrões de atividade SVD ).";

$LNG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME = "Votado por pessoas similares a mim";
$LNG->ALERT_HINT_SUPPORTED_BY_PEOPLE_LIKE_ME = "Esta postagem foi altamente votada por pessoas cujas opiniões são similares as minhas (baseado na análise dos padrões de qualificação SVD ).";

$LNG->ALERT_INTERESTING_TO_ME = 'Interessante para mim';
$LNG->ALERT_HINT_INTERESTING_TO_ME = 'Ver as mensagens que devem interessar ao usuario, levando em conta seus interesses anteriores. Este alerta calcula os intereses do usuário em cada postagem com base na quantidade de atenção que se deu por seus vizinhos mais próximos no pasado. A continuação, identifica as mensagens cujos pontuações de "interesse" se encontran na parte superior de 50%';

$LNG->ALERT_UNSEEN_COMPETITOR = 'Competidor não visto';
$LNG->ALERT_HINT_UNSEEN_COMPETITOR = 'Identifica idéias de outra pessoa que concorre com uma idéia que eu autoria.';

$LNG->ALERT_UNSEEN_RESPONSE = 'Resposta não visto';
$LNG->ALERT_HINT_UNSEEN_RESPONSE = 'Identifica invisível (por mim) as respostas de autoria de alguém para um post que eu autoria.';


//RETURNS PEOPLE / PEOPLE BASED
$LNG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "Pessoas como eu - mesmos interesses";
$LNG->ALERT_HINT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "As pessoas que tem interesses similares ao meu, com base nos padrões de atividade.";

$LNG->ALERT_PEOPLE_WHO_AGREE_WITH_ME = "Pessoas como eu - por votos";
$LNG->ALERT_HINT_PEOPLE_WHO_AGREE_WITH_ME = "As pessoas que tem opiniões similares ã minhas, com base nos padrões de qualificação.";

$LNG->ALERT_LURKING_USER = 'Usuario não frequente';
$LNG->ALERT_HINT_LURKING_USER = 'O usuário não editou ou criou nenhuma mensagem';

$LNG->ALERT_INACTIVE_USER = 'Usuario Inativo';
$LNG->ALERT_HINT_INACTIVE_USER = 'Encontrado usuários que não haviam feito nada de nada';

$LNG->ALERT_USER_IGNORED_COMPETITORS = 'Concorrentes ignorado Usuário';
$LNG->ALERT_HINT_USER_IGNORED_COMPETITORS = 'Identifica os usuários que ignoraram concorrentes às suas idéias. Para cada usuário, ele lista os problemas que o usuário oferecidos ideias para , seguidos pelas idéias concorrentes que o usuário ignorado (ou seja, não ver ou responder a ).';

$LNG->ALERT_USER_IGNORED_ARGUMENTS = 'Argumentos ignorados Usuário';
$LNG->ALERT_HINT_USER_IGNORED_ARGUMENTS = 'Identifica os usuários que ignorou os argumentos subjacentes quando rating mensagens. Para cada usuário, ele lista os postos de classificação seguidos pelos argumentos para cada uma dessas mensagens que o usuário ignorado (ou seja, não ver ou responder a).';

$LNG->ALERT_USER_IGNORED_RESPONSES = 'Respostas ignoradas Usuário';
$LNG->ALERT_HINT_USER_IGNORED_RESPONSES = 'Identifica os usuários que ignoraram as respostas de outras pessoas a seus postos . Para cada usuário, ele lista os postos de autoria do usuário seguido respostas a cada uma dessas mensagens que o usuário ignorado (ou seja, não ver ou responder a).';


//RETURNS POSTS / MAP BASED
$LNG->ALERT_HOT_POST = "Postagem quente";
$LNG->ALERT_HINT_HOT_POST = "Esta postagem tem recibido uma grande quantidade de participações de interesse geral.";

$LNG->ALERT_ORPHANED_IDEA = "Ideia única";
$LNG->ALERT_HINT_ORPHANED_IDEA = "Esta ideia postada tem recebido muito menos atenção que postagens similares.";

$LNG->ALERT_EMERGING_WINNER = "Ideia dominante";
$LNG->ALERT_HINT_EMERGING_WINNER = "Uma ideia tem predominio de apoio da comunidade (por um tema determinado ).";

$LNG->ALERT_CONTENTIOUS_ISSUE = "Tema polémico";
$LNG->ALERT_HINT_CONTENTIOUS_ISSUE = "Um problema com as ideias, a comunidade está fortemente dividida sobre : balcanização , polarização.";

$LNG->ALERT_INCONSISTENT_SUPPORT = "Ideia apoiada inconscientemente";
$LNG->ALERT_HINT_INCONSISTENT_SUPPORT = "Uma ideia de apoio a esta ideia e seus argumentos que subjacente são incompatíveis.";

$LNG->ALERT_MATURE_ISSUE = 'Tema maduro';
$LNG->ALERT_HINT_MATURE_ISSUE = 'Esta questão tem > = 3 ideias com ao menos un argumento de cada.';

$LNG->ALERT_IGNORED_POST = 'Postagem ignorada';
$LNG->ALERT_HINT_IGNORED_POST = 'O artígo não havia sido visto por ninguem mais que o autor original';

$LNG->ALERT_USER_GONE_INACTIVE = 'Usuarios inativo desaparecido';
$LNG->ALERT_HINT_USER_GONE_INACTIVE = 'Os usuários que se encontraban inicialmente ativos, mas não estão atualmente frequentando este programa.';

$LNG->ALERT_CONTROVERSIAL_IDEA = 'Ideia polêmica';
$LNG->ALERT_HINT_CONTROVERSIAL_IDEA = 'A comunidade tem opiniões muito divergentes ( como refletivo por seu voto ) se é uma ideia boa ou não.';

$LNG->ALERT_IMMATURE_ISSUE = "Tema Imaturo";
$LNG->ALERT_HINT_IMMATURE_ISSUE = 'Esta questão tem &lt; 3 ideias com argumentos';

$LNG->ALERT_WELL_EVALUATED_IDEA = "Ideia Bem avaliada";
$LNG->ALERT_HINT_WELL_EVALUATED_IDEA = "Ideia tem várias vantagens e desvantagens, incluindo algumas refutações";

$LNG->ALERT_POORLY_EVALUATED_IDEA = "Ideia mal avaliada";
$LNG->ALERT_HINT_POORLY_EVALUATED_IDEA = "Ideia tem alguuns prós e contras, e não há refutações";

$LNG->ALERT_RATING_IGNORED_ARGUMENT = 'Classificação argumento ignorado';
$LNG->ALERT_HINT_RATING_IGNORED_ARGUMENT = 'Identifica argumentos relevantes que o usuário não ver antes de avaliar um post.';
?>
