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
 */
$LNG->LOADING_CIDASHBOARD_VISUALISATION = 'Carga de una visualización en vivo desde <a/href="https://cidashbaord.net" target="_blank">CIDashboard</a>...';
$LNG->LOADING_CIDASHBOARD_ANALYTICS = 'Cargando Visual Analytics en directo de <a/href="https://cidashbaord.net" target="_blank">CIDashboard</a>...';

$LNG->STATS_GO_BACK = "Regresa";

$LNG->STATS_AVAILABLE_FROM = "Rango de fechas disponibles desde";
$LNG->STATS_AVAILABLE_TO = "a";
$LNG->STATS_START_DATE = Mostrar datos de";
$LNG->STATS_END_DATE = "Mostrar datos a";
$LNG->STATS_LOAD_BUTTON = "Cargar datos";
$LNG->STATS_ACTIVITY_WARNING = "Si hay una gran cantidad de datos para cargar, su conexión puede agotarse. Si esto sucede, reduzca el rango de fechas que ha seleccionado.";
$LNG->STATS_START_END_DATE_ERROR = "La fecha de inicio debe ser anterior a la fecha de finalización";
$LNG->STATS_START_DATE_ERROR = "Seleccione una fecha para cargar datos a partir de";
$LNG->STATS_END_DATE_ERROR = "Seleccione una fecha para cargar datos hasta";

/** STATE PAGE NAMES **/
$LNG->STATS_TAB_MAP = 'Mapa';
$LNG->STATS_TAB_VIS = 'Alternative Vistas';
$LNG->STATS_TAB_ANALYTICS = 'Visual Analytics';

/** STATE PAGE NAMES **/
$LNG->STATS_TAB_NETWORK = $LNG->DEBATE_NAME.' Red';
$LNG->STATS_TAB_SOCIAL = 'Red social';
$LNG->STATS_TAB_SUNBURST = 'Gente & Mapa Ring';
$LNG->STATS_TAB_STACKEDAREA = 'Río de contribución';
$LNG->STATS_TAB_STREAMGRAPH = 'Corriente de contribución';
$LNG->STATS_TAB_CIRCLEPACKING = $LNG->DEBATE_NAME.' Jerarquización';
$LNG->STATS_TAB_TOPICSPACE = 'Actividad polarizada';
$LNG->STATS_TAB_BIASSPACE = 'Clasificación polarizada';
$LNG->STATS_TAB_ACTIVITY_ANALYSIS = 'Análisis de la actividad';
$LNG->STATS_TAB_USER_ACTIVITY_ANALYSIS = 'Análisis de la actividad del usuario';
$LNG->STATS_TAB_OVERVIEW = 'Descripción rápida';
$LNG->STATS_TAB_VOTES = 'Votación';
$LNG->STATS_TAB_TREEMAP = 'Treemap - Hojas';
$LNG->STATS_TAB_TREEMAPTD = 'Treemap - Top Down';
$LNG->STATS_TAB_RING = 'Gente & '.$LNG->ISSUE_NAME.' Ring';
$LNG->STATS_TAB_SUNBURST2 = 'Sunburst';

/** VISUALISATION HELP TEXTS **/

/** MAP LEVEL **/
$LNG->STATS_DEBATE_HELP_NETWORK = 'Esta visualización muestra la red de'.$LNG->DEBATE_NAME.' contribuciones. Hay controles de zoom y orientación disponibles y también se puede utilizar la rueda del ratón para acercar y alejar.';
$LNG->STATS_DEBATE_HELP_SOCIAL = 'Esta visualización muestra una red de usuarios que participan en el '.$LNG->DEBATE_NAME.'. Hay controles de zoom y orientación disponibles a continuación y también se puede utilizar la rueda del ratón para acercar y alejar. Las conexiones entre los usuarios pueden ser (sobre todo el apoyo a las conexiones), (en su mayoría conexiones contador) de color rojo, o gris (sin tipo de conexión dominante verde).';
$LNG->STATS_DEBATE_HELP_SUNBURST = 'Esta visualización muestra los usuarios y sus conexiones con '.$LNG->MAPS_NAME.'. las nonexiones entre los usuarios y '.$LNG->MAPS_NAME.' puede ser verde (en su mayoría '.$LNG->PROS_NAME.'), rojo (en su mayoría '.$LNG->CONS_NAME.'), ay gris (ningún tipo de contribución domienante). Haga clic en un segmento de la visualización ver más información sobre ese miembro o '.$LNG->MAP_NAME.' en el panel de detalles de zona.';
$LNG->STATS_DEBATE_HELP_STACKEDAREA = 'Esta visualización muestra los tipos de contribuciones a través del tiempo. Deslice el ratón en la visualización para ver las estadísticas individuales para cada tipo y para cada fecha. Haga clic en la visualización para filtrar por tipo. Haga clic derecho sobre la visualización o pulse el "Eliminar filtro" para eliminar el filtro de la visualización.';

$LNG->STATS_DEBATE_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">La siguiente visualización muestra las contribuciones a un '.$LNG->DEBATE_NAME.' dispuestos en un xy plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares basados en la actividad de los usuarios con ellos (visualización, edición, actualización de contribuciones, etc.).</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos de las contribuciones con cada uno que tiene un patrón de actividad distinta). El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice esta visualizaciones para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de la '.$LNG->DEBATE_NAME.' siendo sesgados respecto a las personas que muestran interés en interactuar con el '.$LNG->DEBATE_NAME.'. Si sólo hay un grupo o no hay ningún grupo, entonces esto es un indicador de que la '.$LNG->DEBATE_NAME.' es imparcial.</div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Pase el ratón sobre un punto de contribución para ver más información en la "Detalle de zona".</div></div>';
$LNG->STATS_DEBATE_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_DEBATE_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">La siguiente visualización muestra las contribuciones a un '.$LNG->DEBATE_NAME.' dispuestos sobre un xy-plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares basadas en la votación de los usuarios.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos de las contribuciones con cada uno que tiene un patrón de votación distinto). El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice esta visualizaciones para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de la '.$LNG->DEBATE_NAME.' parcialidad con respecto a la conducta de voto de la gente. Si sólo hay un grupo o no hay grupo, entonces esto es un indicador de que la '.$LNG->DEBATE_NAME.' es imparcial.</div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Pase el ratón sobre un punto contribución para ver más información en el "zona de detalle".</div></div>';
$LNG->STATS_DEBATE_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_DEBATE_HELP_CIRCLEPACKING = 'La siguiente visualización proporciona una visión general de todo el '.$LNG->DEBATE_NAME.' como círculos anidados de contribuciones. Haga clic en un círculo para hacer un zoom, haga clic fuera de un círculo para alejar. Pasar por encima de circulo para ver el título del artículo como una sugerencia.';
$LNG->STATS_DEBATE_HELP_ACTIVITY = 'La siguiente visualización muestra la actividad de una '.$LNG->DEBATE_NAME.' con el tiempo. Haga clic en la línea de tiempo para cubrir un período de tiempo (hacer clic y arrastrar). Las visualizaciones de abajo cambiarán y se mostrará la frecuencia de la actividad por día, el tipo de contribución ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' y '.$LNG->CON_NAME.'), el tipo de actividad (visualización, añadiendo, o la edición), y en la tabla de abajo se pueden ver los datos subyacentes a las visualizaciones. Allí también se puede restablecer la visualización a su estado original. Puede hacer clic en las barras de las visualizaciones para filtrar por un tipo específico. También puede seleccionar varios tipos haciendo clic en varios bars. Haga clic en, por ejemplo, en el '.$LNG->ISSUE_NAME.' y '.$LNG->SOLUTION_NAME.' bar y en la barra de visualización para filtrar por todas vistos '.$LNG->ISSUES_NAME.' y '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_DEBATE_HELP_USER_ACTIVITY = 'La visualización muestra las contribuciones de los usuarios a esta '.$LNG->DEBATE_NAME.'. Haga clic en "Usuarios" para filtrar por usuario. Haga clic en "Acciones del usuario" para filtrar la página por acción. Puede seleccionar más de uno. Puede restablecer la página haciendo clic en "Reiniciar todo".';
$LNG->STATS_DEBATE_HELP_STREAM_GRAPH = 'Esta visualización muestra los tipos de contribuciones a través del tiempo. Deslice el ratón en la visualización para ver las estadísticas individuales para cada tipo y para cada fecha. Elige entre una vista apilada, arroyo y vista ampliada para inspeccionar las contribuciones a través del tiempo.';
$LNG->STATS_DEBATE_HELP_OVERVIEW = 'Estas visualizaciones proporcionan una visión general de los aspectos importantes de un '.$LNG->DEBATE_NAME.'. contiene tres '.$LNG->DEBATE_NAME.' indicadores de salud (se ciernen sobre el signo de interrogación al lado de cada semáforo para más información) y varias visualizaciones descripción.';

/** GROUP LEVEL **/
$LNG->STATS_GROUP_HELP_NETWORK = 'Esta visualización muestra una red de las contribuciones a la '.$LNG->DEBATES_NAME.' en esto '.$LNG->GROUP_NAME.'. Hay controles de zoom y orientación disponibles y también se puede utilizar la rueda del ratón para acercar y alejar.';
$LNG->STATS_GROUP_HELP_SOCIAL = 'Esta visualización muestra una red de usuarios que participan en la'.$LNG->DEBATES_NAME.' en esto '.$LNG->GROUP_NAME.'. Hay controles de zoom y orientación disponibles a continuación y también se puede utilizar la rueda del ratón para acercar y alejar. Las conexiones entre los usuarios pueden ser verde (sobre todo conexiones a favor), (en su mayoría conexiones en contra) de color rojo, y gris (sin tipo de conexión dominante).';
$LNG->STATS_GROUP_HELP_SUNBURST = 'Esta visualización muestra los usuarios y sus conexiones con '.$LNG->MAPS_NAME.'. Las conexiones entre los usuarios y '.$LNG->MAPS_NAME.' puede ser verde (en su mayoría '.$LNG->PROS_NAME.'), roja (en su mayoría '.$LNG->CONS_NAME.'), y gris (ninguna contribución dominante). Haga clic en un segmento de la visualización ver más información sobre ese miembro o '.$LNG->MAPS_NAME.' en el panel de detalles de la zona.';
$LNG->STATS_GROUP_HELP_STACKEDAREA = 'Esta visualización muestra los tipos de contribución a través del tiempo. Deslice el mouse en la visualización para ver las estadísticas individuales para cada tipo y para cada fecha. Haga clic en la visualización para filtrar por tipo. Haga clic derecho sobre la visualización o pulse el "Eliminar filtro" para eliminar el filtro de la visualización.';

$LNG->STATS_GROUP_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">La siguiente visualización muestra las contribuciones a la '.$LNG->DEBATES_NAME.' en este '.$LNG->GROUP_NAME.' dispuestos en un xy plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares basados en la actividad de los usuarios con ellos (visualización, edición, actualización de las contribuciones, etc.).</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos de las contribuciones y cada una tiene un patrón de actividad distinta).  El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice estas visualizaciones para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de '.$LNG->DEBATE_NAME.' siendo sesgados respecto a las personas que muestran interés y están interactuando con el '.$LNG->DEBATE_NAME.'. Si sólo hay un grupo o no hay ningún grupo, entonces esto es un indicador de que la '.$LNG->DEBATE_NAME.' es imparcial.</div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Pase el ratón sobre un punto contribución para ver más información en el "área de detalle".</div></div>';
$LNG->STATS_GROUP_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GROUP_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">La siguiente visualización muestra las contribuciones a la '.$LNG->DEBATES_NAME.' en este '.$LNG->GROUP_NAME.' dispuestos en un xy-plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares basadas en la votación de los usuarios.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos de las contribuciones con cada uno que tiene un patrón de votación distinto). El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice esta visualizaciones para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de la'.$LNG->DEBATE_NAME.' parcialidad con respecto a la conducta de voto de la gente. Si sólo hay un grupo o ningún grupo, entonces esto es un indicador de que la '.$LNG->DEBATE_NAME.' es imparcial.</div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Pase el ratón sobre un punto contribución para ver más información en la "zona Detalle".</div></div>';
$LNG->STATS_GROUP_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GROUP_HELP_CIRCLEPACKING = 'La siguiente visualización proporciona una visión general de todos los '.$LNG->DEBATES_NAME.' en este '.$LNG->GROUP_NAME.' como círculos anidados de contribuciones. Haga clic en un círculo para hacer un zoom, haga clic fuera de un círculo para alejar. Pasar por encima de circulo para ver el título del artículo como una sugerencia.';
$LNG->STATS_GROUP_HELP_ACTIVITY = 'La siguiente visualización muestra la actividad de la '.$LNG->DEBATES_NAME.' en este '.$LNG->GROUP_NAME.' con el tiempo. Haga clic en la línea de tiempo para cubrir un período de tiempo (hacer clic y arrastrar). Las visualizaciones de abajo cambiarán y se mostrará la frecuencia de la actividad por día, el tipo de contribución ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' y '.$LNG->CON_NAME.'), el tipo de actividad (visualización, añadiendo, o la edición), y en la tabla de abajo se pueden ver los datos subyacentes las visualizaciones. Allí también se puede restablecer la visualización a su estado original. Puede hacer clic en las barras de las visualizaciones para filtrar para un tipo específico. También puede seleccionar varios tipos haciendo clic en varios bares. Haga clic en, por ejemplo, en el '.$LNG->ISSUE_NAME.' y '.$LNG->SOLUTION_NAME.' bar y en la barra de visualización para filtrar por todas vistos '.$LNG->ISSUES_NAME.' y '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_GROUP_HELP_USER_ACTIVITY = 'La visualización muestra las contribuciones de los usuarios a la '.$LNG->DEBATES_NAME.' en este '.$LNG->GROUP_NAME.'. Haga clic en la tabla de "Usuarios" para filtrar por usuario. Haga clic en "Acciones del usuario" para filtrar la página por acción. En tanto, puede seleccionar más de uno. Puede restablecer la página haciendo clic en "Reiniciar todo".';
$LNG->STATS_GROUP_HELP_STREAM_GRAPH = 'Esta visualización muestra los tipos de cotización a través del tiempo. Deslice el ratón en la visualización para ver las estadísticas individuales para cada tipo y para cada fecha. Elige entre una vista apilada, arroyo y vista ampliada para inspeccionar las contribuciones a través del tiempo.';
$LNG->STATS_GROUP_HELP_OVERVIEW = 'Estas visualizaciones proporciona una visión general de los aspectos importantes de la'.$LNG->DEBATES_NAME.' en este '.$LNG->GROUP_NAME.'. contiene tres '.$LNG->DEBATE_NAME.' indicadores de salud (flotan sobre el signo de interrogación al lado de cada semáforo para más información) y la descripción de varias visualizaciones.';

/** GLOBAL LEVEL **/
$LNG->STATS_GLOBAL_HELP_NETWORK = 'Esta visualización muestra una red de las contribuciones a la '.$LNG->DEBATES_NAME.' en este sitio. Hay controles de zoom y orientación disponibles y también se puede utilizar la rueda del ratón para acercar y alejar.';
$LNG->STATS_GLOBAL_HELP_SOCIAL = 'Esta visualización muestra una red de usuarios que participan en la '.$LNG->DEBATES_NAME.' en este sitio. Hay controles de zoom y orientación disponibles y también se puede utilizar la rueda del ratón para acercar y alejar. Las conexiones entre los usuarios pueden ser verdes (sobre todo el apoyo a las conexiones), (en su mayoría conexiones contrarias) de color rojo, y gris (sin tipo de conexión dominante).';
$LNG->STATS_GLOBAL_HELP_SUNBURST = 'Esta visualización muestra los usuarios y sus conexiones con '.$LNG->MAPS_NAME.'. Las conexiones entre los usuarios y '.$LNG->MAPS_NAME.' puede ser verdes (en su mayoría '.$LNG->PROS_NAME.'), rojas (en su mayoría '.$LNG->CONS_NAME.'), y grises (ningún tipo contribución dominante). Haga clic en un segmento de la visualización ver más información sobre ese miembro o '.$LNG->MAPS_NAME.' en el panel de detalles zona.';
$LNG->STATS_GLOBAL_HELP_STACKEDAREA = 'Esta visualización muestra los tipos de cotización a través del tiempo. Deslice el ratón en la visualización para ver las estadísticas individuales para cada tipo y para cada fecha. Haga clic en la visualización para filtrar por tipo. Haga clic derecho sobre la visualización o pulse el "Eliminar filtro" para eliminar el filtro de la visualización.';

$LNG->STATS_GLOBAL_HELP_TOPICSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">La siguiente visualización muestra las contribuciones a la '.$LNG->DEBATES_NAME.' en este sitio dispuesta en un xy-plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares basados en la actividad de los usuarios con ellos (visualización, edición, actualización de las contribuciones, etc.).</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos de las contribuciones con cada uno que tiene un patrón de votación distinto).  El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice esta visualizaciones para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de la '.$LNG->DEBATE_NAME.' siendo sesgados respecto a las personas que muestran interés y están interactuando con el '.$LNG->DEBATE_NAME.'. Si sólo hay un grupo o no hay ningún grupo, entonces esto es un indicador de que la '.$LNG->DEBATE_NAME.' es imparcial.</div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;clear:both;margin-top:10px">Pase el ratón sobre un punto contribución para ver más información en el "área de detalle".</div></div>';
$LNG->STATS_GLOBAL_HELP_TOPICSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Dos grupos<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GLOBAL_HELP_BIASSPACE = '<div><div style="float:left;width:780px;"><div style="float:left;clear:both;">La siguiente visualización muestra las contribuciones a la '.$LNG->DEBATES_NAME.' en este sitio dispuesto en un xy plot. Utilice esta visualización para encontrar racimos/agrupaciones de contribuciones. Un grupo de contribuciones representa contribuciones similares basadas en la votación de los usuarios.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">El ejemplo de la parte superior derecha muestra dos grupos (dos grupos distintos de las contribuciones con cada uno que tiene un patrón de votación distinto).  El ejemplo en la parte inferior derecha muestra sólo un grupo. A menudo no hay grupos distintos.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Utilice esta visualizaciones para detectar grupos. Si la visualización muestra más de un grupo, entonces esto es un indicador de la '.$LNG->DEBATE_NAME.' parcialidad con respecto a la conducta de voto de la gente. Si sólo hay un grupo o ningún grupo, entonces esto es un indicador de que la '.$LNG->DEBATE_NAME.' es imparcial.</div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;clear:both;margin-top:10px">Pase el ratón sobre un punto contribución para ver más información en el "área de detalle".</div></div>';
$LNG->STATS_GLOBAL_HELP_BIASSPACE .= '<div style="float:left;width:130px;margin-left:10px;"><div style="float:left;">Two clusters<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_cluster.png" /></div><div style="clear:both;float:left;margin-top:20px;">One cluster<br><img width="100" src="'.$CFG->homeAddress.'ui/stats/images/cluster_mani_nocluster.png" /></div></div></div>';

$LNG->STATS_GLOBAL_HELP_CIRCLEPACKING = 'La siguiente visualización proporciona una visión general de todos los '.$LNG->DEBATES_NAME.' en este sitio como círculos anidados de contribuciones. Haga clic en un círculo para hacer un zoom, haga clic fuera de un círculo para alejar. Pasar por encima de círculo para ver el título del artículo como una sugerencia.';
$LNG->STATS_GLOBAL_HELP_ACTIVITY = 'La siguiente visualización muestra la actividad de la '.$LNG->DEBATES_NAME.' con el tiempo. Haga clic en la línea de tiempo para cubrir un período de tiempo (hacer clic y arrastrar). Las visualizaciones de abajo cambiarán y se mostrará la frecuencia de la actividad por día, el tipo de contribución ('.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.' and '.$LNG->CON_NAME.'), the type of activity (viewing, adding, or  editing), and in the table below you can see the data underlying the visualisations.  There you can also reset the visualisation to its original state. You can click on the bars of the visualisations to filter for a specific type. You can also select several types by clicking on several bars. Click for example on the '.$LNG->ISSUE_NAME.' and '.$LNG->SOLUTION_NAME.' bar and on the viewing bar to filter for all viewed '.$LNG->ISSUES_NAME.' and '.$LNG->SOLUTIONS_NAME.'.';
$LNG->STATS_GLOBAL_HELP_USER_ACTIVITY = 'La visualización muestra las contribuciones de los usuarios a la '.$LNG->DEBATES_NAME.' en este sitio. Haga clic en la tabla de "Usuarios" para filtrar por usuario. Haga clic en "Acciones del usuario" para filtrar la página por acción. En tanto, puede seleccionar más de uno. Puede restablecer la página haciendo clic en "Reiniciar todo".';
$LNG->STATS_GLOBAL_HELP_STREAM_GRAPH = 'Esta visualización muestra los tipos de cotización a través del tiempo. Deslice el ratón en la visualización para ver las estadísticas individuales para cada tipo y para cada fecha. Elige entre una vista apilada, arroyo y vista ampliada para inspeccionar las contribuciones a través del tiempo.';
$LNG->STATS_GLOBAL_HELP_OVERVIEW = 'Esta visualización proporciona una visión general de los aspectos importantes de la '.$LNG->DEBATES_NAME.' en este sitio. Contiene tres '.$LNG->DEBATE_NAME.' indicadores de salud (flotan sobre el signo de interrogación al lado de cada semáforo para más información) y varias visualizaciones descripción.';

/** OVERVIEW PAGE **/
$LNG->STATS_OVERVIEW_MAIN_TITLE='Visión de conjunto';
$LNG->STATS_OVERVIEW_WORDS_MESSAGE = 'Estadísticas de recuento de Palabras:';
$LNG->STATS_OVERVIEW_CONTRIBUTION_MESSAGE = 'Contribuciones del usuario';
$LNG->STATS_OVERVIEW_VIEWING_MESSAGE = "La actividad visualización del usuario";
$LNG->STATS_OVERVIEW_HEALTH_TITLE = $LNG->DEBATE_NAME.' Indicadores de salud';
$LNG->STATS_OVERVIEW_HEALTH_PROBLEM = 'Hay un problema.';
$LNG->STATS_OVERVIEW_HEALTH_NO_PROBLEM = 'No parece haber ningún problema.';
$LNG->STATS_OVERVIEW_HEALTH_MAYBE_PROBLEM = 'Puede haber un problema.';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_TITLE = 'Indicador de la actividad de contribuciones';
$LNG->STATS_OVERVIEW_HEALTH_VIEWING_TITLE = 'Viendo el indicador de actividad';
$LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_TITLE = 'Indicador de participación';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTORS = 'participaron en este'.$LNG->DEBATE_NAME.".";
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS = 'conectado';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_PART2 = 'visto este '.$LNG->DEBATE_NAME;
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_RED = ' en los últimos 14 días';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_ORANGE = ' hace entre 6 y 14 días';
$LNG->STATS_OVERVIEW_HEALTH_VIEWERS_GREEN = ' en los últimos 5 días';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION = ' aportado';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_RED = ' en los últimos 14 días';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_ORANGE = ' hace entre 6 y 14 días';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_GREEN = ' en los últimos 5 días';
$LNG->STATS_OVERVIEW_LOADING_MESSAGE = '(Cargando Resumen de Estadísticas. Estos pueden tomar un rato para calcular en función del tamaño de los datos del discurso...)';
$LNG->STATS_OVERVIEW_TOP_THREE_VOTES_MESSAGE = 'Entradas mas votadas:';
$LNG->STATS_OVERVIEW_RECENT_NODES_MESSAGE = 'Recientemente añadido:';
$LNG->STATS_OVERVIEW_RECENT_VOTES_MESSAGE = 'Más recientemente votada:';
$LNG->STATS_OVERVIEW_DATE = 'Fecha:';
$LNG->STATS_OVERVIEW_VOTES = 'Votos:';
$LNG->STATS_OVERVIEW_TIME = 'tiempo';
$LNG->STATS_OVERVIEW_TIMES = 'número de veces';
$LNG->STATS_OVERVIEW_PERSON = 'persona';
$LNG->STATS_OVERVIEW_PEOPLE = 'gente';
$LNG->STATS_OVERVIEW_WORDS_AVERAGE = 'Contribución media:';
$LNG->STATS_OVERVIEW_WORDS = 'palabras';
$LNG->STATS_OVERVIEW_WORDS_MIN = 'minimo:';
$LNG->STATS_OVERVIEW_WORDS_MAX = 'máximo:';
$LNG->STATS_OVERVIEW_VIEWING_HIGHEST = 'Recuento de visualización alto';
$LNG->STATS_OVERVIEW_VIEWING_LOWEST = 'Recuento de visualización bajo';
$LNG->STATS_OVERVIEW_VIEWING_LAST = 'Recuento de visualización bajo';
$LNG->STATS_OVERVIEW_VIEWING_VIEWS = 'visitas';
$LNG->STATS_OVERVIEW_VIEWING_ON = 'on';
$LNG->STATS_OVERVIEW_HEALTH_PARTICIPATION_HINT = 'Si hay menos de 3 personas que han participado de esta '.$LNG->DEBATE_NAME.' entonces esto muestra un semáforo en rojo. Si entre 3 y 5 personas han participado en esta '.$LNG->DEBATE_NAME.' entonces esto va a mostrar un semáforo naranja. Si hay más de 5 personas han participado en esta '.$LNG->DEBATE_NAME.' entonces esto va a mostrar un semáforo en verde.';
$LNG->STATS_OVERVIEW_HEALTH_VIEWING_HINT = 'Si hay conectadass personas que han visto este '.$LNG->DEBATE_NAME.' durante más de 14 días, esto mostrará una luz roja del semáforo. Si hay conectados personas que han visto este '.$LNG->DEBATE_NAME.' hace entre 6 y 14 días se muestra un semáforo naranja. Si se han conectado personas  que han visto este '.$LNG->DEBATE_NAME.' en los últimos 5 días hace que se muestre un semáforo en verde.';
$LNG->STATS_OVERVIEW_HEALTH_CONTRIBUTION_HINT = 'Si la gente no ha añadido una nueva entrada a esta '.$LNG->DEBATE_NAME.' durante más de 14 días, este mostrará un semáforo en rojo. Si la gente ha añadido una nueva entrada a esta '.$LNG->DEBATE_NAME.' entre 6 y 14 días hace que se muestre en un semáforo naranja. Si la gente ha añadido una nueva entrada a esta '.$LNG->DEBATE_NAME.' en los últimos 5 días que se muestre en un semáforo en verde.';

/** ISSUE SIDE STATS **/
$LNG->STATS_DEBATE_HEALTH_TITLE = $LNG->DEBATE_NAME.' Indicadores de salud';
$LNG->STATS_DEBATE_HEALTH_MESSAGE = 'Haga clic en cada semáforo para más información';
$LNG->STATS_DEBATE_HEALTH_EXPLORE = 'Explorar más:';

$LNG->STATS_DEBATE_PARTICIPATION_TITLE = 'Participación';

$LNG->STATS_DEBATE_CONTRIBUTION_TITLE = 'Indicador de equilibrio';
$LNG->STATS_DEBATE_CONTRIBUTION_MESSAGE = 'La conversación se beneficiaría de más';
$LNG->STATS_DEBATE_AND = 'and';
$LNG->STATS_DEBATE_CONTRIBUTION_GREEN = 'Los tipos de contribuciones están equilibrados.';
$LNG->STATS_DEBATE_CONTRIBUTION_HELP = 'Este semáforo indica cómo están equilibrados los tipos de contribuciones en el debate. Si uno de los tipos ('.$LNG->SOLUTION_NAME.', '.$LNG->PRO_NAME.', '.$LNG->CON_NAME.', o '.$LNG->VOTES_NAME.') está representada la cebada (por debajo del 10%) se mostrará un semáforo en rojo. Si uno de los tipos es subrepresentadas (menos del 20%) entonces se muestra un semáforo amarillo. De lo contrario, los tipos están en equilibrio y se mostrará un semáforo en verde.';

$LNG->STATS_DEBATE_VIEWING_TITLE = 'pensamiento del grupo';
$LNG->STATS_DEBATE_VIEWING_HELP = 'Este indicador representa el porcentaje de miembros de este grupo que vieron este asunto. Si el 50% o más miembros de este grupo vieron este tema a continuación se mostrará un semáforo en verde. Si el 20% y el 49% considera que a continuación se mostrará un semáforo amarillo. Si menos del 20% considera este tema se mostrará un semáforo en rojo.';
$LNG->STATS_DEBATE_VIEWING_MESSAGE_PART1 = 'de este grupo de';
$LNG->STATS_DEBATE_VIEWING_MESSAGE_PART2 = 'visto este'.$LNG->DEBATE_NAME.'.';

$LNG->STATS_DASHBOARD_HELP_HINT = "Haga clic para mostrar/ocultar la descripción de visualización.";

/** GROUP STATS **/
$LNG->STATS_GROUP_TITLE = 'Analiticas de grupo para: ';

$LNG->STATS_ACTIVITY_COLUMN_DATE = 'Fecha';
$LNG->STATS_ACTIVITY_COLUMN_TITLE = 'Título';
$LNG->STATS_ACTIVITY_COLUMN_ITEM_TYPE = 'Tipo de contribución';
$LNG->STATS_ACTIVITY_COLUMN_TYPE = 'Tipo de actividad';
$LNG->STATS_ACTIVITY_COLUMN_ACTION = 'Acción del usuario';
$LNG->STATS_ACTIVITY_FILTER_DATE_TITLE = 'Fecha';
$LNG->STATS_ACTIVITY_FILTER_MONTH_TITLE = 'Mes';
$LNG->STATS_ACTIVITY_FILTER_DAYS_TITLE = 'Día de la semana';
$LNG->STATS_ACTIVITY_FILTER_ITEM_TYPES_TITLE = 'Tipos de cntribución';
$LNG->STATS_ACTIVITY_FILTER_TYPES_TITLE = 'Tipos de actividades';
$LNG->STATS_ACTIVITY_FILTER_USERS_TITLE = 'Usuarios';
$LNG->STATS_ACTIVITY_FILTER_ACTION_TITLE = 'Acciones del usuario';
$LNG->STATS_ACTIVITY_USER_ANONYMOUS = "u";
$LNG->STATS_ACTIVITY_USER_ANONYMOUS_NAME = "Usuario Desconocido";

$LNG->STATS_ACTIVITY_CREATE = 'Crear';
$LNG->STATS_ACTIVITY_UPDATE = 'Actualización';
$LNG->STATS_ACTIVITY_DELETE = 'borrar';
$LNG->STATS_ACTIVITY_VIEW = 'Ver';
$LNG->STATS_ACTIVITY_VOTE = 'Votar';
$LNG->STATS_ACTIVITY_VOTED_FOR = 'Votos a favor';
$LNG->STATS_ACTIVITY_VOTED_AGAINST = 'Votos en contra';

$LNG->STATS_ACTIVITY_SUNDAY = 'Domingo';
$LNG->STATS_ACTIVITY_MONDAY = 'lunes';
$LNG->STATS_ACTIVITY_TUESDAY = 'Martes';
$LNG->STATS_ACTIVITY_WEDNESDAY = 'Miércoles';
$LNG->STATS_ACTIVITY_THURSDAY = 'Jueves';
$LNG->STATS_ACTIVITY_FRIDAY = 'Viernes';
$LNG->STATS_ACTIVITY_SATURDAY = 'Sábado';

$LNG->STATS_ACTIVITY_JAN = 'Enero';
$LNG->STATS_ACTIVITY_FEB = 'Febrero';
$LNG->STATS_ACTIVITY_MAR = 'Marzo';
$LNG->STATS_ACTIVITY_APR = 'Abril';
$LNG->STATS_ACTIVITY_MAY = 'Mayo';
$LNG->STATS_ACTIVITY_JUN = 'Junio';
$LNG->STATS_ACTIVITY_JUL = 'Julio';
$LNG->STATS_ACTIVITY_AUG = 'Agosto';
$LNG->STATS_ACTIVITY_SEP = 'Septiembre';
$LNG->STATS_ACTIVITY_OCT = 'Octubre';
$LNG->STATS_ACTIVITY_NOV = 'Noviembre';
$LNG->STATS_ACTIVITY_DEC = 'Diciembre';

$LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART1 = 'seleccionado de';
$LNG->STATS_ACTIVITY_SELECTED_COUNT_MESSAGE_PART2 = 'archivos';
$LNG->STATS_ACTIVITY_RESET_ALL_BUTTON = 'Reiniciar todo';

$LNG->STATS_SCATTERPLOT_DETAILS_COUNT = "Entradas:";
$LNG->STATS_SCATTERPLOT_DETAILS = "Área de detalles";
$LNG->STATS_SCATTERPLOT_DETAILS_CLICK = "Pase el ratón sobre la contribución para ver los detalles.";

$LNG->STATS_GROUP_STACKEDAREA_TITLE = 'Clave';
$LNG->STATS_GROUP_STACKEDAREA_HELP = 'Pase el ratón sobre un área de color en un momento dado para mostrar un recuento de las contribuciones para ese tipo de elemento y para esa fecha.<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_HELP .= 'Haga clic en el botón izquierdo en un área coloreada para filtrar diagrama en ese tipo de elemento.<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_HELP .= 'Haga clic en el botón derecho para eliminar el filtro (o haga clic en el botón de abajo).<br /><br />';
$LNG->STATS_GROUP_STACKEDAREA_RESTORE_BUTTON = 'Quitar filtro';
$LNG->STATS_GROUP_STACKEDAREA_ERROR = 'No hay datos suficientes disponibles para dibujar esta visualización en la actualidad.';

$LNG->STATS_GROUP_SUNBURST_PERSON = 'Miembro';
$LNG->STATS_GROUP_SUNBURST_DEBATE = $LNG->MAP_NAME;
$LNG->STATS_GROUP_SUNBURST_CONNECTED_DEBATE = 'fue contribuida por:';
$LNG->STATS_GROUP_SUNBURST_CONNECTED_USER = 'y está conectado a:';
$LNG->STATS_GROUP_SUNBURST_WITH = 'con:';
$LNG->STATS_GROUP_SUNBURST_CREATED = 'creado:';
$LNG->STATS_GROUP_SUNBURST_DETAILS = "Detalles de la zona";
$LNG->STATS_GROUP_SUNBURST_DETAILS_CLICK = "Haga clic en la sección para ver más detalles";
$LNG->STATS_GROUP_SUNBURST_DEBATE_CREATED = $LNG->ISSUES_NAME.":";
$LNG->STATS_GROUP_SUNBURST_DEBATE_OWNED = $LNG->ISSUES_NAME." propietario";
$LNG->STATS_GROUP_OVERVIEW_USED_LINKS_LABEL = 'Mas común '.$LNG->ISSUES_NAME.' actividad';
$LNG->STATS_GROUP_OVERVIEW_USED_IDEAS_LABEL = 'El tipo de contribuciones mas comunes';

/** DEBATE STATS **/
$LNG->STATS_DEBATE_TITLE = $LNG->MAP_NAME.' Analytics para: ';
$LNG->STATS_DEBATE_OVERVIEW_TOP_NODETYPE_USAGE = 'Item tipo de uso';

/** GLOBAL STATS **/
$LNG->HOMEPAGE_STATS_LINK = "Analytics";

/// Connections page
$LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE = 'lo mas conectado '.$LNG->ISSUES_NAME;
$LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE = 'lo mas conectado'.$LNG->SOLUTIONS_NAME;
$LNG->OVERVIEW_RESOURCE_MOSTCONNECTED_TITLE = 'lo mas conectado '.$LNG->RESOURCES_NAME;
$LNG->OVERVIEW_PRO_MOSTCONNECTED_TITLE = 'lo mas conectado'.$LNG->PROS_NAME;
$LNG->OVERVIEW_CON_MOSTCONNECTED_TITLE = 'lo mas conectado '.$LNG->CONS_NAME;

$LNG->STATS_GLOBAL_TITLE = 'Global Analytics';
$LNG->STATS_GLOBAL_TAB_IDEAS = 'Items Creados';

$LNG->STATS_GLOBAL_VOTES_TOP_NODES = 'Top 10 Voted ON Items';
$LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES = "Top 10 Votaciones Items A FAVOR";
$LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES = "Top 10 Votaciones Items EN CONTRA";
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING = 'Nombre';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING = 'Total';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING = 'A favor';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING = 'En contra';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING = "CAtegoría";
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS = 'Top 10 Votaciones';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_FOR = 'Top 10 Votaciones a FAVOR';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_AGAINST = 'Top 10 votaciones en CONTRA';
$LNG->STATS_GLOBAL_VOTES_VOTING_MENU_TITLE = 'Vista superior de votación de artículos';
$LNG->STATS_GLOBAL_VOTES_VOTERS_MENU_TITLE = 'Ver Top Votantes artículo';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTES_MENU_TITLE = 'Ver todas las votaciones de artículo';
$LNG->STATS_GLOBAL_VOTES_BACK_UP = 'Volver a menú de opciones';
$LNG->STATS_GLOBAL_VOTES_MENU_TITLE = 'Estadísticas de voto';
$LNG->STATS_GLOBAL_ITEM_VOTES_MENU_TITLE = 'Estadísticas de artículos votados';
$LNG->STATS_GLOBAL_CONNECTION_VOTES_MENU_TITLE = 'Estadísticas de conexiones de voto';
$LNG->STATS_GLOBAL_ALL_VOTES_MENU_TITLE = 'Todas las estadísticas de los votos';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTING_TITLE = 'Todos los items votados';
$LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING = 'Item a favor';
$LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING = 'Item en contra';
$LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING = 'Conexión a favor';
$LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING = 'Conexión en contra';

$LNG->STATS_GLOBAL_OVERVIEW_HEADER_TYPE = 'Tipo';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_NAME = 'Nombre';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_COUNT = 'Count';
$LNG->STATS_GLOBAL_OVERVIEW_USED_LINKS_LABEL = 'La mayor actividad común';
$LNG->STATS_GLOBAL_OVERVIEW_USED_IDEAS_LABEL = 'La contribución mas común';
$LNG->STATS_GLOBAL_OVERVIEW_CONNECTED_IDEA_LABEL = 'Tema mas conectado';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS = 'Top constructores de conexión';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_IDEA_CREATORS = 'Top creadores de Item';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS_LINKS = 'Top constructores de conexión - su uso LinkType';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART1 = 'Para ver su análisis personales vaya a su';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART2 = 'página de inicio';

$LNG->STATS_GLOBAL_REGISTER_TOTAL_LABEL = 'REcuento total de usuarios';
$LNG->STATS_GLOBAL_REGISTER_HEADER_NAME = 'Nombre';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DATE = 'Fecha';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DESC = 'Descripción';
$LNG->STATS_GLOBAL_REGISTER_HEADER_WEBSITE = 'Website';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LOCATION = 'Ubicación';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LAST_LOGIN = 'Última sesión';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_TITLE = 'Registro de usuarios por meses';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_TITLE = 'REgistro de usuarios por semana';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_X_LABEL = 'Número de inscripciones';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_Y_LABEL = 'Meses (de';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_Y_LABEL = 'Semanas (de';

$LNG->STATS_GLOBAL_IDEAS_TOTAL_LABEL = 'Cuenta total';
$LNG->STATS_GLOBAL_IDEAS_MONTHLY_TOTAL_LABEL = 'Total mensual';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_TITLE  ='Creación artículo semanal en el último año';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_TITLE  ='Creación artículo mensual para el último año';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_Y_LABEL = 'Meses (de';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_Y_LABEL = 'Semanas (de';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_X_LABEL = 'Número de ideas';

$LNG->STATS_GLOBAL_CONNS_TOTAL_LABEL = 'Recuento total de conexiones';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_TITLE  ='Creación de conexión semanales en el último año';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_TITLE  ='Creación de conexión mensual en el último año';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_Y_LABEL = 'Meses (de';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_Y_LABEL = 'Semanas (de';
$LNG->STATS_GLOBAL_CONNS_GRAPH_X_LABEL = 'Número de conexiones';

/** USER STATS **/
$LNG->STATS_USER_TITLE = 'Estadísticas de';
$LNG->STATS_USER_NAME_HEADING = 'Nombre';
$LNG->STATS_USER_ITEM_HEADING = 'Item';
$LNG->STATS_USER_COUNT_HEADING = 'Contador';
$LNG->STATS_USER_ACTION_HEADING = 'Acción';
$LNG->STATS_USER_POPULAR_LINK_HEADING = 'Tipos de link mas usados';
$LNG->STATS_USER_VIEW_ALL = 'VEr todo';
$LNG->STATS_USER_POPULAR_NODE_HEADING = 'Los tipos denosos mas usados';
$LNG->STATS_USER_POPULAR_TAG_HEADING = 'Las etiquetas mas usadas';
$LNG->STATS_USER_TOP_TEN = 'top 10';
$LNG->STATS_USER_COUNT_HEADING = 'Contar';
$LNG->STATS_USER_LINK_TYPES_HEADING = 'Tipo de lynk';
$LNG->STATS_USER_NODE_TYPES_HEADING = 'Tipo de nodos';
$LNG->STATS_USER_COMPARED_THINKING = 'Pensamiento en comparación';
$LNG->STATS_USER_INFORMATION_THINKING = 'Información Broker';
$LNG->STATS_USER_SUMMARY_TITLE = 'RESUMEN';
$LNG->STATS_USER_VOTE_TITLE = 'Votar Item';

/** GRAPH BUTTONS ETC.. **/
$LNG->GRAPH_PRINT_HINT = "Imprimir este gráfico de la red";
$LNG->GRAPH_ZOOM_FIT_HINT = "Ajustar a la página: Ampliar gráfica hacia abajo si es necesario y pasar a hacer que todo entre en el área visible";
$LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT = "Reducir este gráfico de la red al 100%";
$LNG->GRAPH_ZOOM_IN_HINT = "Ampliar el zoom";
$LNG->GRAPH_ZOOM_OUT_HINT = "Disminuir el zoom";
$LNG->GRAPH_CONNECTION_COUNT_LABEL = 'Conexiones:';
$LNG->GRAPH_NOT_SUPPORTED = 'Tu navegador actual no admite HTML5 Canvas.<br><br>Por favor, actualice a una nueva versión si desea ver esta visualización: IE 9.0+; Firefox 23.0+; Chrome 29.0+; Opera 17.0+; Safari 5.1+';

/** NETWORK MAPS **/
$LNG->NETWORKMAPS_RESIZE_MAP_HINT = 'Reducir Mapa';
$LNG->NETWORKMAPS_ENLARGE_MAP_LINK = 'Ampliar Mapa';
$LNG->NETWORKMAPS_REDUCE_MAP_LINK = 'Reducir Mapa';
$LNG->NETWORKMAPS_EXPLORE_ITEM_LINK = 'Explorar Item';
$LNG->NETWORKMAPS_EXPLORE_ITEM_HINT = 'Abra la página completa detalles para el elemento actual';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_LINK = 'Explorar Autor';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_HINT = 'Ir a la página principal para el item autor';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_CONNECTION_HINT = 'Ir a la página principal para la conexión autor';
$LNG->NETWORKMAPS_SELECTED_NODEID_ERROR = 'Por favor, asegúrese de que ha hecho una selección en el mapa.';
$LNG->NETWORKMAPS_MAC_PAINT_ISSUE_WARNING = '(Esta visualización requiere Java 7 en MacOS X 10.7 en adelante (Lion) para que funcione correctamente)';
$LNG->NETWORKMAPS_APPLET_NOT_RECOGNISED_ERROR = '(Su navegador reconoce el elemento APPLET pero no se ejecuta el applet.)';
$LNG->NETWORKMAPS_LOADING_MESSAGE = '(Cargando mapa...)';
$LNG->NETWORKMAPS_APPLET_REF_BROKEN_ERROR = 'Mapa Applet de referencia roto. Por favor, reinicie su navegador.';
$LNG->NETWORKMAPS_NO_RESULTS_MESSAGE = 'No se encontraron resultados. Por favor, seleccione de nuevo.';
$LNG->NETWORKMAPS_OPTIONAL_TYPE = 'y, opcionalmente, un tipo';
$LNG->NETWORKMAPS_KEY_SELECTED_ITEM = 'Item seleccionado';
$LNG->NETWORKMAPS_KEY_FOCAL_ITEM = 'Item focal';
$LNG->NETWORKMAPS_KEY_NEIGHBOUR_ITEM = 'Item vecino';
$LNG->NETWORKMAPS_KEY_SOCIAL_MODERATELY = 'Moderadamente conectados';
$LNG->NETWORKMAPS_KEY_SOCIAL_HIGHLY = 'Altamente conectados';
$LNG->NETWORKMAPS_KEY_SOCIAL_SLIGHTLY = 'Ligeramente conectado';
$LNG->NETWORKMAPS_KEY_SOCIAL_MOST = 'Los más conectados';
$LNG->NETWORKMAPS_PERCENTAGE_MESSAGE = '% de diseño computarizada...';
$LNG->NETWORKMAPS_SCALING_MESSAGE = 'Escalar para encajar la página...';

$LNG->NETWORKMAPS_SOCIAL_ITEM_HINT = "Abra la página principal de la persona seleccionada";
$LNG->NETWORKMAPS_SOCIAL_ITEM_LINK = 'Explorar persona seleccionada';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT = 'Mostrar todas las conexiones para el enlace seleccionado';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_LINK = 'Explorar enlace seleccionado';
$LNG->NETWORKMAPS_SOCIAL_LOADING_MESSAGE = '(Cargando vista de Red Social. Esto puede tardar algunos minutos para calcular en función del tamaño de los datos...)';
$LNG->NETWORKMAPS_SOCIAL_NO_RESULTS_MESSAGE = 'No hay datos para calcular la Red Social de.';
$LNG->NETWORKMAPS_SOCIAL_CONNECTIONS = 'Conexiones';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION = 'Conexión';

/** LITEMAP SPECIFIC **/
$LNG->GRAPH_EMBEDEDIT_HINT = "Copiar el código iframe para incrustar esta como un mapa editable en otro sitio";
$LNG->GRAPH_EMBEDEDIT_MESSAGE = "Por favor, copie el siguiente código para integrar este ".$LNG->MAP_NAME." en otro sitio web. Para los ".$LNG->MAPS_NAME." en un ".$LNG->GROUP_NAME.", hacer ".$LNG->GROUP_NAME." unirse abierta y la gente se añadirán automáticamente al ".$LNG->GROUP_NAME." al iniciar la sesión:";
$LNG->GRAPH_EMBED_HINT = "Copiar el código iframe para incrustar esta como un único mapa leído en otro sitio";
$LNG->GRAPH_EMBED_MESSAGE = "Por favor, copie el siguiente código para incrustar este mapa en otra página web:";
$LNG->GRAPH_HELP_HINT = "Ayuda de mapa";
$LNG->NETWORKMAPS_VIEW_LINEAR = 'Ver lineal';
$LNG->NETWORKMAPS_VIEW_MAP = 'Ver mapa';

$LNG->GRAPH_JSONLD_HINT = "Obtén la llamada API de descanso para traer la representación jsonld de este mapa.";
$LNG->GRAPH_JSONLD_MESSAGE = "Copia este enlace en su navegador para buscar la representación jsonld de este mapa.";
$LNG->GRAPH_JSONLD_HINT_GROUP = "Obtén la llamada API de descanso para traer la representación jsonld de los mapas en este grupo.";
$LNG->GRAPH_JSONLD_MESSAGE_GROUP = "Copia este enlace en su navegador para buscar la representación jsonld de los mapas en este grupo.";

$LNG->GRAPH_LINK_MESSAGE = 'Copie el siguiente enlace para obtener el url que representa este nodo en este '.$LNG->MAP_NAME;
$LNG->GRAPH_LINK_HINT = 'Haga clic para obtener una url a este nodo en este '.$LNG->MAP_NAME;


// ALERT MESSAGES

$LNG->ALERTS_BOX_TITLE = 'Alertas';

//RETURNS POSTS / PEOPLE BASED
$LNG->ALERT_UNSEEN_BY_ME = "Invisible para mí";
$LNG->ALERT_HINT_UNSEEN_BY_ME = "No he visto este post todavía.";

$LNG->ALERT_RESPONSE_TO_ME = "Respuesta a mi mensaje";
$LNG->ALERT_HINT_RESPONSE_TO_ME = "Este mensaje es una respuesta a un post de mi autoría.";

$LNG->ALERT_UNRATED_BY_ME = "No votar por mí";
$LNG->ALERT_HINT_UNRATED_BY_ME = "Todavía no he votado en este post.";

$LNG->ALERT_INTERESTING_TO_PEOPLE_LIKE_ME = "Visto por personas similares a mí";
$LNG->ALERT_HINT_INTERESTING_TO_PEOPLE_LIKE_ME = "Este post ha sido visto por la gente con intereses similares a mí ( basado en el análisis de los patrones de actividad SVD ).";

$LNG->ALERT_SUPPORTED_BY_PEOPLE_LIKE_ME = "Votado por personas similares a mí";
$LNG->ALERT_HINT_SUPPORTED_BY_PEOPLE_LIKE_ME = "Este post fue votado altamente por la gente cuyas opiniones son similares a la mía (basado en el análisis de los patrones de calificación SVD ).";

$LNG->ALERT_INTERESTING_TO_ME = 'Interesante para mí';
$LNG->ALERT_HINT_INTERESTING_TO_ME = 'Ver los mensajes que deben interesar al usuario, teniendo en cuenta sus intereses anteriores. Esta alerta calcula los intereses del usuario en cada puesto en base a la cantidad de atención que él / ella dio o sus vecinos más cercanos en el pasado. A continuación, identifica los mensajes cuyos puntajes de "interés" se encuentran en la parte superior del 50%';

$LNG->ALERT_UNSEEN_COMPETITOR = 'Competidor que no se ve';
$LNG->ALERT_HINT_UNSEEN_COMPETITOR = 'Identifica las ideas de otra persona que compite con una idea de mi autoría.';

$LNG->ALERT_UNSEEN_RESPONSE = 'Respuesta que no se ve';
$LNG->ALERT_HINT_UNSEEN_RESPONSE = 'Identifica invisible (por mí) respuestas escritos por otra persona para un puesto de mi autoría.';


//RETURNS PEOPLE / PEOPLE BASED
$LNG->ALERT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "La gente como yo - por intereses";
$LNG->ALERT_HINT_PEOPLE_WITH_INTERESTS_LIKE_MINE = "Las personas que tienen intereses similares a mí , con base en los patrones de actividad.";

$LNG->ALERT_PEOPLE_WHO_AGREE_WITH_ME = "La gente como yo - por votos";
$LNG->ALERT_HINT_PEOPLE_WHO_AGREE_WITH_ME = "Las personas que tienen opiniones similares a las mías , con base en los patrones de calificación.";

$LNG->ALERT_LURKING_USER = 'Usuario mirón';
$LNG->ALERT_HINT_LURKING_USER = 'El usuario no ha editado o creado ninguna mensajes';

$LNG->ALERT_INACTIVE_USER = 'Usuario Inactivo';
$LNG->ALERT_HINT_INACTIVE_USER = 'Encuentra usuarios que no hayan hecho nada de nada';

$LNG->ALERT_USER_IGNORED_COMPETITORS = 'Competidores usuario ignorado';
$LNG->ALERT_HINT_USER_IGNORED_COMPETITORS = 'Identifica los usuarios que ignoraron los competidores a sus ideas. Para cada usuario , que muestra los problemas que el usuario ideas para ofrecía , seguidas por las ideas de la competencia que el usuario ignora (es decir, no ver o responder a).';

$LNG->ALERT_USER_IGNORED_ARGUMENTS = 'Argumentos usuario ignorado';
$LNG->ALERT_HINT_USER_IGNORED_ARGUMENTS = 'Identifica los usuarios que ignoraron subyacentes argumentos al calificar los puestos. Para cada usuario, enumera los puestos calificados seguidos de los argumentos a favor de cada uno de esos mensajes que el usuario ignora (es decir, no ver o responder a).';

$LNG->ALERT_USER_IGNORED_RESPONSES = 'Las respuestas de los usuarios ignorados';
$LNG->ALERT_HINT_USER_IGNORED_RESPONSES = 'Identifica los usuarios que ignoraron las respuestas de otras personas a sus puestos. Para cada usuario , que enumera los mensajes -autor de los usuarios siguieron las respuestas a cada uno de esos mensajes que el usuario ignora (es decir, no ver o responder a).';


//RETURNS POSTS / MAP BASED
$LNG->ALERT_HOT_POST = "Post caliente";
$LNG->ALERT_HINT_HOT_POST = "Este post ha recibido una gran cantidad de interés en general.";

$LNG->ALERT_ORPHANED_IDEA = "Idea huérfana";
$LNG->ALERT_HINT_ORPHANED_IDEA = "Este post idea está recibiendo mucha menos atención que post similares.";

$LNG->ALERT_EMERGING_WINNER = "Idea dominante";
$LNG->ALERT_HINT_EMERGING_WINNER = "Una idea tiene predominio de apoyo de la comunidad (por un tema determinado ).";

$LNG->ALERT_CONTENTIOUS_ISSUE = "Tema polémico";
$LNG->ALERT_HINT_CONTENTIOUS_ISSUE = "Un problema con las ideas la comunidad está fuertemente dividida sobre : la balcanización , la polarización.";

$LNG->ALERT_INCONSISTENT_SUPPORT = "Idea apoyada inconscientemente";
$LNG->ALERT_HINT_INCONSISTENT_SUPPORT = "Una idea de apoyo a esa idea y sus argumentos que subyacentes son incompatibles.";

$LNG->ALERT_MATURE_ISSUE = 'Tema maduro';
$LNG->ALERT_HINT_MATURE_ISSUE = 'Esta cuestión tiene > = 3 ideas con al menos un argumento de cada.';

$LNG->ALERT_IGNORED_POST = 'Post ignorado';
$LNG->ALERT_HINT_IGNORED_POST = 'El artículo no ha sido visto por nadie más que autor original';

$LNG->ALERT_USER_GONE_INACTIVE = 'Usuarios inactivo desaparecido';
$LNG->ALERT_HINT_USER_GONE_INACTIVE = 'Los usuarios que se encontraban inicialmente activo, pero dejaron de.';

$LNG->ALERT_CONTROVERSIAL_IDEA = 'Idea polémica';
$LNG->ALERT_HINT_CONTROVERSIAL_IDEA = 'La comunidad tiene opiniones muy divergentes ( como se refleja por su voto ) de si una idea es buena o no.';

$LNG->ALERT_IMMATURE_ISSUE = "Tema Inmaduro";
$LNG->ALERT_HINT_IMMATURE_ISSUE = 'Esta cuestión tiene &lt; 3 ideas con argumentos';

$LNG->ALERT_WELL_EVALUATED_IDEA = "Idea Bien evaluada";
$LNG->ALERT_HINT_WELL_EVALUATED_IDEA = "Idea tiene varias ventajas y desventajas , incluyendo algunas refutaciones";

$LNG->ALERT_POORLY_EVALUATED_IDEA = "Idea mal evaluada";
$LNG->ALERT_HINT_POORLY_EVALUATED_IDEA = "Idea tiene algunos pros y contras, y no hay refutaciones";

$LNG->ALERT_RATING_IGNORED_ARGUMENT = 'Argumento ignorado Clasificación';
$LNG->ALERT_HINT_RATING_IGNORED_ARGUMENT = 'Identifica los argumentos pertinentes que el usuario no consideraba antes calificar un post.';
?>
