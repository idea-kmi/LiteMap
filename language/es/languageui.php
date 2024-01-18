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
 * languageui.php
 *
 * Michelle Bachler (KMi)
 *
 */

/** HOMEPAGE **/
$LNG->HOMEPAGE_TITLE = 'Bienvenido a LiteMap';
$LNG->HOMEPAGE_FIRST_PARA = '<b>LiteMap</b> da a las comunidades en línea un lugar para trazar visualmente un debate que puede estar ocurriendo en otros foros o sitio web. Es un lugar para recoger los principales temas, ideas, pros y contras que suceden en un debate en línea y para conectar los y visualizarlos en forma de gráficos de red.';
$LNG->HOMEPAGE_SECOND_PARA_PART2 = 'LiteMap tiene un marcador para recopilar el contenido de la Web, y lienzos 2-D (los mapas) en el que recopila contenido que se puede conectar para construir mapas de argumentos. Estos son representaciones de red de los temas, ideas y argumentos en torno a un tema de discusión específico. Litemap también se distingue en su uso de la analítica avanzada para mostrar las mejores ideas argumentadas y visualizaciones de su comunidad';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<p><b>Para los gestores de comunidad:</b><br>Litemap le ayuda a resumir el estado de un debate y que lo pueda presentar a la comunidad: para provocar una reflexión más profunda, promover la comprensión más profunda y mejorar el compromiso con el debate en línea. Litemap es también una herramienta para organizar las contribuciones a su comunidad, reduce la duplicación de ideas, y es compatible con el análisis de contenidos y resúmenes. El tablero de instrumentos de análisis en los mapas ayuda a detectar las conexiones entre las ideas, detectar lagunas en el conocimiento, descubrir nuevos patrones y producir resúmenes visuales de los debates de la comunidad.</p>';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<p><b>Para miembros de la comunidad:</b><br>Litemap es su manera de moverse por la participación y el debate a la moderación de la comunidad. Con Litemap usted puede construir una representación visual de su propio punto de vista y usted puede utilizar esta representación para comunicar sus ideas a los demás.</p>';
$LNG->HOMEPAGE_KEEP_READING = 'Sigue leyendo';
$LNG->HOMEPAGE_READ_LESS = 'leer menos';
$LNG->HOMEPAGE_TOOLS_TITLE = 'Herramientas:';
$LNG->HOMEPAGE_TOOLS_LINK = 'Obten barra de herramientas de LiteMap';
$LNG->HOMEPAGE_VIEW_ALL = "Ver todo";
$LNG->HOMEPAGE_NEWS_TITLE = "Noticias recientes";

$LNG->HOMEPAGE_MOST_POPULAR_GROUPS_TITLE = $LNG->GROUPS_NAME.' más populares';
$LNG->HOMEPAGE_MOST_RECENT_GROUPS_TITLE = 'lo más nuevo '.$LNG->GROUPS_NAME;
$LNG->HOMEPAGE_MOST_RECENT_MAPS_TITLE = 'lo más nuevo '.$LNG->MAPS_NAME;

$LNG->HOME_MY_GROUPS_TITLE = 'Mis '.$LNG->GROUPS_NAME;
$LNG->HOME_MY_GROUPS_AREA_LINK = 'Ver mis '.$LNG->GROUPS_NAME.' area';
$LNG->HOME_MY_MAPS_TITLE = 'Mis '.$LNG->MAPS_NAME;
$LNG->HOME_MY_MAPS_AREA_LINK = 'Ver mis '.$LNG->MAPS_NAME.' area';

/** HELP PAGES **/
$LNG->HELP_NETWORKMAP_TITLE = 'Ayuda de mapa';
$LNG->HELP_NETWORKMAP_BODY = '<b>Fondo:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-top:0px;margin-bottom:0px;padding-bottom:0px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">click botón izquierdo y arrastre el lienzo para desplazarse.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Click botón derecho para deplegar menú para agregar nodos flotantes en el mapa. Sólo está disponible si esta conectado y tiene permisos para editar el mapa.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';
$LNG->HELP_NETWORKMAP_BODY .= '<br><b>Links:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<span style="padding-left:10px;">Haga clic en el enlace para ver el menú de enlace. Aquí puede hacer clic para ir a la página del autor o, si esta conectado y tiene permisos para editar el mapa, puede eliminar el enlace del mapa.</span><br><br>';
$LNG->HELP_NETWORKMAP_BODY .= '<b>Items:</b>';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-top:0px;margin-bottom:0px;padding-bottom:0px;"><li style="margin-bottom:5px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">ctrl+izquierdo-click en uno o más elementos para seleccionarlos. No disponible en mapas incrustados de sólo lectura.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">alt+izquierdo-click sobre un elemento para seleccionar un árbol de nodos. No disponible en mapas incrustados de sólo lectura.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Izquierdo-click</b> Mantenga ratón y arrastre para mover el elemento actual y los nodos seleccionados</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Derecho-click y arrastre un nodo para soltar en otro nodo para vincularlos (suponiendo que no esten ya vinculados y las normas de vinculación lo permiten). Sólo está disponible si esta conectado y tienes permisos para editar el mapa.<br><b>Para Opera solamente</b> es ctrl+right-click arrastrar y soltar para enlace de nodos.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;">Haga clic derecho en un nodo de comentario con una imagen para ver una versión Ampliación de la imagen.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:0px;">Deslice el ratón al icono para ver el tipo de nombre.</li></ul>';

$LNG->HELP_NETWORKMAP_BODY .= '<br><h2>Barra de herramientas de mapa</h2><img style="width:640px;border-bottom:1px solid gray" src="'.$HUB_FLM->getImagePath('help/maptoolbar.png').'" />';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-bottom:0px;padding-bottom:0px;margin-top:5px;">';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('enlarge2.gif').'">Haga click para ampliar la zona de mapeo. Esto elimina áreas de encabezado y pie de página y el mapa cuadro de título y amplía el área de mapeo para llenar el espacio emabrgo. <img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('reduce.gif').'">Haga clic de nuevo para reducir el mapa hacia abajo.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;">Editar Bar: Sólo se ve esta opción es que tienes permisos para editar el mapa y se encuentra en una vista editable. Haga clic tp abrir y cerrar la barra lateral de edición de la izquierda. Aquí encontrará una lista de las entradas que ha creado. Un lugar para buscar todas las entradas y botones para crear nuevas entradas. Sólo tiene que arrastrar y soltar las entradas en el mapa. Para crear una nueva entrada de arrastrar y soltar los iconos en el mapa que le preguntarán a usted sólo por el título, o haga clic en los iconos para obtener la plena \'Agregar nuevo\' formas.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;">Bar Alerta: Si alertas han sido activan en su sitio en este botón se abrirá y cerrará el lado zona de bar Alerta derecha. Aquí alertas se muestran con recomendaciones basadas en el estado actual del mapa.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-minus.png').'">Haga clic para ampliar el mapa fuera. También puede desplazarse la rueda del ratón hacia atrás.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-plus.png').'">Haga clic para ampliar el mapa. También puede desplazarse hacia delante la rueda del ratón.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-ratio1-1.png').'">Ampliar el mapa al 100%.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('mag-glass-fit.png').'">Ampliar el mapa de modo que todos los elementos encajan en el área visible.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('printer.png').'">Imprima el mapa.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('info.png').'">Abra esta ventana de ayuda.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('selectall2.png').'" width="18" height="18">Haga clic para seleccionar/deseleccionar todos los elementos en el mapa. No se ve en "solo-lectura" de mapas incrustables.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5x;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('search.png').'">Introduzca el texto a buscar en el cuadro de búsqueda y presione ENTRAR o haga clic en este icono para buscar. Cualquier pareja se destaca en el mapa.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('search-clear.png').'">Esto borra cualquier texto en el campo de búsqueda y borra selecciones de elementos en el mapa.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('knowledge-tree.png').'">Este botón le permite ver un representación lineal del mapa de sólo lectura.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:21px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('embed.png').'">Esto abre un cuadro de texto desde la que se puede copiar el código iframe para incrustar el mapa actual como mapa de sólo lectura en otro sitio. No se ha visto en los mapas incrustados.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:32px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('embededit.png').'">Esto abre un cuadro de texto desde la que se puede copiar el código iframe para incrustar el mapa actual como un mapa editable en otro sitio. No se ha visto en los mapas incrustados.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:24px;height:18px;" border="0" src="'.$HUB_FLM->getImagePath('json-ld-data-24.png').'">Esto abre un cuadro de texto desde la que se puede copiar la url para obtener los datos jsonld para este mapa. No se ha visto en los mapas incrustados.</li>';
//$LNG->HELP_NETWORKMAP_BODY .= '<li style="padding-bottom:5px;"><b>Connections:</b> At the end of the first row you will see a count of how many connections are in the current map.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';

//$LNG->HELP_NETWORKMAP_BODY .= '<br><h2>Map Key</h2><img border="0" src="'.$HUB_FLM->getImagePath('help/mapkey.png').'" />';
//$LNG->HELP_NETWORKMAP_BODY .= '<p>Esta tecla muestra los elementos del mapa que son del mismo tipo basado en su color. En los mapas editables, todos los elementos clave a excepción \''.$LNG->CHALLENGE_NAME_SHORT.'\' convertido en botones (como se ve arriba), que puede hacer clic para añadir nuevos elementos flotantes en el mapa.</p>';

$LNG->HELP_NETWORKMAP_BODY .= '<br><h2>Item Toolbar</h2><img src="'.$HUB_FLM->getImagePath('help/nodetoolbar.png').'" border="0" />';
$LNG->HELP_NETWORKMAP_BODY .= '<ul style="margin-bottom:0px;padding-bottom:0px;margin-top:5px;"><li style="margin-bottom:5px;"><b>2:</b> Si un item está en más de un mapa habrá un número en el primer elemento de la barra de herramientas, que es una cuenta de en cuántos mapas esta el item. Este ejemplo es de dos, pero podrían ser mas. Pasa el ratón por el número para ver la lista de todos los mapas dónde aparece este item. Haga Click en el nombre del mapa para ver el mapa.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('desc-gray.png').'">Pasa el ratón por el icono del cuadrado blanco para ver texto extra del título / o la descripción del texto. Haga clic para abrir la ventana Detalles completos.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('thumb-up-empty.png').'">Si usted está registrado puede votar por un artículo haciendo clic en el icono con los pulgares hacia arriba . El número a la derecha muestra el número de votos a favor que tiene el item.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('thumb-down-empty.png').'">Si usted está registrado puede votar por un artículo haciendo clic en el icono con los pulgares hacia abajo. El número a la derecha muestra el número de votos en contra que tiene el item.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('edit.png').'">Si usted está en el sistema y usted es el dueño de un elemento verá el icono de edición. Haga clic aquí para abrir el formulario de edición y hacer cambios. Si el item aparece múltiples mapas debe tener en cuenta que los cambios pueden afectar a la lógica de esos mapas de conversaciones.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('delete.png').'">Si está conectado a usted y tener permisos para editar el mapa verán un elemento de menú x. Haga clic aquí para eliminar el elemento del mapa. Se le preguntará si está seguro antes de que se complete la acción. La extracción de un elemento del mapa no hace que se borre de los otros mapas o el sistema.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('link.png').'">Deslice el ratón en este icono para ver los sitios web asociados. En una pequeña ventana emergente aparecerá el listado de urls que se han agregado a este item. Haga clic en los links para visitar los sitios.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:5px;"><img style="vertical-align:middle;padding-right:5px;width:18px;height:18px;" border="0" src="'.$HUB_FLM->getImagePath('lock-32.png').'" width="18" height="18">Si usted ve un candado en la barra de herramientas entonces eso significa que este artículo es privado. Usted por lo tanto sólo lo verá en sus propios artículos,que usted los ha hecho privados, o en items particulares de cualquier otro grupo.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '<li style="margin-bottom:0px;"><img style="vertical-align:middle;padding-right:5px;width:16px;height:16px;" border="0" src="'.$HUB_FLM->getImagePath('rightarrowlarge.gif').'">Si ha iniciado sesión y tiene permisos para editar el mapa, verá una flecha al final de la barra de herramientas. Esto abré el menu de edición. Deslice el ratón por la flecha para ver el menú. Aquí encontrarás opciones para crear/añadir elementos al mapa y vincularlos.</li>';
$LNG->HELP_NETWORKMAP_BODY .= '</ul>';

/** IMPORT CIF **/
$LNG->IMPORT_CIF_TITLE = 'CIF de importación';
$LNG->IMPORT_CIF_DATA_URL = 'Url datos CIF:';
$LNG->IMPORT_CIF_DATA_URL_PLACEHOLDER = 'http:// <Url a sus datos con formato CIF>';
$LNG->IMPORT_CIF_DATA_URL_ERROR = 'Por favor, añada su url datos CSi';
$LNG->IMPORT_CIF_DATA_URL_INVALID = 'No ha entrado en una url de datos válido . Por favor, inténtalo de nuevo';
$LNG->IMPORT_CIF_LOAD = 'Cargar y Vista previa';
$LNG->IMPORT_CIF_CLEAR_LOAD = 'Claro Última Carga';
$LNG->IMPORT_CIF_NODES_ONLY = 'Sólo Importación Nodos';
$LNG->IMPORT_CIF_IMPORT_MESSAGE = '<b>'.$LNG->IMPORT_CIF_NODES_ONLY.':</b> A continuación puede seleccionar los nodos que desea importar utilizando las casillas de verificación en la lista de nodos. Todos los nodos se seleccionan de forma predeterminada. Los nodos se añadirán a su área de datos \'Mi LiteMap\' y aparecen en su \'Bandeja de entrada\' en el Mapa bar editor durante la edición de mapas.';
$LNG->IMPORT_CIF_IMPORT_MESSAGE2 = '<b>Importar nodos y conexiones:</b> Si está importando nodos y conexiones, (\''.$LNG->IMPORT_CIF_NODES_ONLY.'\' No está seleccionada) puede seleccionar los nodos para importar en la lista de nodos o de la visión lineal (primer botón de la barra de herramientas en el mapa). Se importarán todas las conexiones entre los nodos seleccionados. Se le pedirá que cree un nuevo mapa para importarlos a. Puede volver a organizar el diseño del mapa antes de la importación en el mapa de vista previa a continuación.';
$LNG->IMPORT_CIF_NODE_COUNT = 'Conde nodo:';
$LNG->IMPORT_CIF_CONNECTION_COUNT = 'Conde de conexión:';
$LNG->IMPORT_CIF_IMPORT = 'Importación';
$LNG->IMPORT_CIF_IMPORT_INTO = 'Importación en:';
$LNG->IMPORT_CIF_IMPORT_INTO_HELP = 'Por favor craete un '.$LNG->MAP_NAME.' para importar los nodos y conexiones en.';
$LNG->IMPORT_CIF_FORMAT_LINK = 'Catalyt interchange Format';
$LNG->IMPORT_CIF_SELECT_ALL = 'Seleccionar Todo';
$LNG->IMPORT_CIF_DESELECT_ALL = 'Deseleccionar todos';
$LNG->IMPORT_CIF_PRIVACY_HINT = "Si se ajusta a los nodos públicos todos importados será visto por nadie. Si se establece en privado sólo el propietario / importador puede verlos, o si se importan en un ".$LNG->MAP_NAME." que está en un ".$LNG->GROUP_NAME.", otros miembros del ".$LNG->GROUP_NAME." puede verlos.";
$LNG->IMPORT_CIF_LOADING = 'Importación de datos';
$LNG->IMPORT_CIF_LIMIT_MESSAGE = 'Actualmente tenemos un límite de importación nodo '.$CFG->ImportLimit.'. Usted tendrá que anular la selección de algunos de sus nodos antes de importar.';
$LNG->IMPORT_CIF_LIMIT_MESSAGE_REACHED = 'Has más de '.$CFG->ImportLimit.' nodos seleccionados. Por favor, anule la selección de algunos nodos antes de importar.';
$LNG->IMPORT_CIF_CONDITIONS_MESSAGE = 'Nos gustaría recordarle que, como miembro de este Hub usted ha aceptado nuestros <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Términos de Usuario</a>.<br>Antes de importar estos datos nos gustaría llamar su atención sobre todo a la <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php#section2">Sección 2</a>.';
$LNG->USER_HOME_IMPORT_CIF_LINK = 'CIF de importación';

/** MAPS **/

$LNG->MAP_EDITOR_INBOX = 'bandeja de entrada';
$LNG->MAP_EDITOR_LINK = 'Editar Barra';
$LNG->MAP_EDITOR_LINK_HINT = 'Haga clic para activar '.$LNG->MAP_EDITOR_LINK.' abierto y cerrado';
$LNG->MAP_EDITOR_SEARCH_NO_RESULTS = 'No se han encontrado resultados';
$LNG->MAP_EDITOR_IN_MAP_HINT = 'Ya en el '.$LNG->MAP_NAME;
$LNG->MAP_EDITOR_DND_HINT = 'arrastrar y soltar a '.$LNG->MAP_NAME.' el lienzo';
$LNG->MAP_EDITOR_NEW_NODE_HINT = 'Haga clic para utilizar plena add forma , arrastrar y soltar para la creación rápida con sólo el título.';

$LNG->MAP_ALERT_LINK = 'Barra de alerta';
$LNG->MAP_ALERT_LINK_HINT = 'Haga clic para activar '.$LNG->MAP_ALERT_LINK.' abierto y cerrado';
$LNG->MAP_ALERT_NO_RESULTS = 'No hay alertas en este momento';
$LNG->MAP_ALERT_CLICK_HIGHLIGHT = 'Haga clic para resaltar en el '.$LNG->MAP_NAME;
$LNG->MAP_ALERT_SHOW_ALL = 'mostrar todo...';
$LNG->MAP_ALERT_SHOW_LESS = 'muestra menos...';

/** TESTING - EMBEDDED MAP SURVEY **/
$LNG->MAP_SURVEY_MESSAGE = '¿Qué tan útil que encuentres este '.$LNG->MAP_NAME.' en esta etapa?';
$LNG->MAP_SURVEY_LINK = 'Dar Opinion';
$LNG->MAP_SURVEY_FORM_USFULNESS = 'Utilidad?';
$LNG->MAP_SURVEY_FORM_COMMENT = 'Comentario:';
$LNG->MAP_SURVEY_FORM_SELECT = 'Seleccionar';
$LNG->MAP_SURVEY_FORM_SELECT_MESSAGE = '(1 = no muy útil ; 5 = muy útil)';
$LNG->MAP_SURVEY_FORM_SELECT_ERROR = 'Por favor seleccione una calificación de utilidad.';
$LNG->MAP_SURVEY_FORM_SUBMIT = 'Enviar';
$LNG->MAP_SURVEY_FORM_CANCEL = 'Cancelar';
$LNG->MAP_SURVEY_THANKS = 'Gracias por su retroalimentación';
$LNG->MAP_ALERT_SURVEY_QUESTION = 'Haga clic si has encontrado esta alerta útil.';

$LNG->MAP_SELECT_ALL_LABEL = 'Seleccionar todo';
$LNG->MAP_SELECT_ALL_HINT = 'Seleccionar todos los items de este '.$LNG->MAP_NAME;
$LNG->MAP_DESELECT_ALL_HINT = 'Deseleccionar todos los items de este '.$LNG->MAP_NAME;
$LNG->MAP_CONNECT_TO_SELECTED_LABEL = 'Conecte con los puntos seleccionados';
$LNG->MAP_CONNECT_TO_SELECTED_HINT = 'Conecte este item a todo los elementos seleccionados si se permite la relación';
$LNG->MAP_CONNECTION_ERROR = 'Una o más conexiones no se pueden hacer, ya que no se les permite';
$LNG->MAP_CONNECTION_ERROR_SINGLE = 'No se permite esta conexión. Tal vez, ¿invertiendo la dirección?';
$LNG->MAP_CONNECTION_TEST_ERROR = 'NO PERMITIDO';
$LNG->MAP_CHANGE_NODETYPE = 'modificación';
$LNG->MAP_TITLE_ROLLOVER_CHOICE = 'Rollover Títulos';
$LNG->MAP_TITLE_ROLLOVER_CHOICE_HINT = 'Activar y desactivar con los títulos de las entradas aparecen como una pista de vuelco . Esto es bueno para explorar el mapa cuando el zoom , pero tal vez molesto cuando la creación de un '.$LNG->MAP_NAME.'.';
$LNG->MAP_LINK_TEXT_CHOICE_HINT = 'Activar y desactivar las etiquetas de enlace que aparecen en este mapa';
$LNG->MAP_LINK_CURVE_CHOICE_HINT = 'Activar y desactivar utilizando enlaces curvos en este mapa';

$LNG->FORM_MAP_ENTER_SUMMARY_ERROR = 'Por favor introduzca un '.$LNG->MAP_NAME.' título antes de guardar';
$LNG->LOADING_MAPS = '(Cargando '.$LNG->MAPS_NAME.'...)';
$LNG->FORM_MAP_LABEL_SUMMARY = $LNG->MAP_NAME." título:";
$LNG->MAP_SUMMARY_FORM_HINT = "(Obligatorio) Por favor añadir un título para esta ".$LNG->MAP_NAME;
$LNG->MAP_DESC_FORM_HINT = "(Opcional) Por favor añadir un título para este ".$LNG->MAP_NAME;
$LNG->MAP_PRIVATE_FORM_HINT = "Si el mapa es público cualquier persona lo puede ver y contribuir. Si es privado sólo el propietario puede ver y editar.";
$LNG->MAP_PRIVATE_FORM_HINT_GROUP = "Si el mapa es público cualquier persona del grupo lo puede ver y contribuir al mismo. Si es privado sólo el propietario puede ver y editar.";
$LNG->FORM_MAP_CREATE_ERROR_MESSAGE = 'Hubo un problema al crear el '.$LNG->MAP_NAME.':';
$LNG->FORM_MAP_NOT_FOUND = 'El item requerido '.$LNG->MAP_NAME.' no se ha encontrado';
$LNG->FORM_MAP_PRIVACY = 'Público:';
$LNG->MAP_REMOVE_NODE = 'Eliminar de'.$LNG->MAP_NAME;
$LNG->MAP_REMOVE_NODE_HINT = 'Eliminar este item de '.$LNG->MAP_NAME;
$LNG->MAP_REMOVE_NODE_CHECK_PART1 = "Estás seguro de que desea eliminar:";
$LNG->MAP_REMOVE_NODE_CHECK_PART2 = "de la '.$LNG->MAP_NAME.'?";
$LNG->MAP_BLOCK_STATS_LINK_HINT = "Haga click para ir al Dashboard (cuadro de mandos) de los analíticos y visualizaciones en este ".$LNG->MAP_NAME;
$LNG->MAP_LINKS_TITLE = 'URLs';
$LNG->MAP_VIEW = 'Ir '.$LNG->MAP_NAME;
$LNG->MAP_LINK_DELETE = 'Eliminar vínculo';

$LNG->MAP_FORM_ADD_TO_GROUP = 'Añadir al '.$LNG->GROUP_NAME.':';
$LNG->MAP_FORM_ADD_TO_GROUP_HINT = '(opcional) - Añade este '.$LNG->MAP_NAME.' al '.$LNG->GROUP_NAME.' seleccionado';

$LNG->FORM_MAP_TITLE_EDIT = 'Editar este '.$LNG->MAP_NAME;
$LNG->FORM_MAP_TITLE_ADD = 'Agraga un '.$LNG->MAP_NAME;
$LNG->FORM_MAP_TITLE_ADD_HINT = 'Seleecione uno ya existente '.$LNG->MAP_NAME.' para hacer referencia de este nodo';

$LNG->BLOCK_STATS_PEOPLE = 'PParticipantes:';
$LNG->BLOCK_STATS_ISSUES = $LNG->SOLUTIONS_NAME.':';
$LNG->BLOCK_STATS_VOTES = $LNG->VOTES_NAME.':';
$LNG->BLOCK_STATS_LINK_HINT = "Haga click para ir al Dashboard (cuadro de mandos) de los analíticos y visualizaciones en este ".$LNG->MAP_NAME.".";

$LNG->MAP_CREATE_LOGGED_OUT_OPEN = "crear un nuevo ".$LNG->MAP_NAME;
$LNG->MAP_CREATE_LOGGED_OUT_REQUEST = "crear un nuevo ".$LNG->MAP_NAME;
$LNG->MAP_CREATE_LOGGED_OUT_CLOSED = "crear un nuevo ".$LNG->MAP_NAME;

$LNG->MAP_ADD_LOGGED_OUT_OPEN = "para contribuir a este ".$LNG->MAP_NAME;
$LNG->MAP_ADD_LOGGED_OUT_REQUEST = "para contribuir a este ".$LNG->MAP_NAME;
$LNG->MAP_ADD_LOGGED_OUT_CLOSED = "para contribuir a este ".$LNG->MAP_NAME;

$LNG->MAP_ADD_EXISTING_BUTTON = 'Añadir a la existente '.$LNG->MAP_NAME;

/** GROUPS **/
$LNG->FORM_BUTTON_DELETE_GROUP = 'Eliminar '.$LNG->GROUP_NAME;
$LNG->FORM_BUTTON_JOIN_GROUP = 'Unirse '.$LNG->GROUP_NAME;
$LNG->FORM_BUTTON_JOIN_GROUP_CLOSED = 'Solicitar a unirse a '.$LNG->GROUP_NAME;

$LNG->ERROR_GROUP_NOT_FOUND_MESSAGE = "El grupo requerido no se ha encontrado";
$LNG->ERROR_GROUP_USER_LAST_ADMIN = "No se puede quitar ese usuario como administrador, ya que entonces el grupo no tendrá administradores";
$LNG->ERROR_GROUP_EXISTS_MESSAGE = "Un grupo con este nombre ya existe";
$LNG->ERROR_GROUP_USER_NOT_MEMBER = "El usuario actual no es miembro del grupo requerido.";

$LNG->GROUP_CREATE_TITLE = 'Crear nuevo '.$LNG->GROUP_NAME;
$LNG->GROUP_MANAGE_TITLE = 'Gestionar '.$LNG->GROUPS_NAME;
$LNG->GROUP_MANAGE_SINGLE_TITLE = 'Gestionar '.$LNG->GROUP_NAME;

$LNG->GROUP_CREATE_LOGGED_OUT_OPEN = "crear un nuevo ".$LNG->GROUP_NAME;
$LNG->GROUP_CREATE_LOGGED_OUT_REQUEST = "crear un nuevo".$LNG->GROUP_NAME;
$LNG->GROUP_CREATE_LOGGED_OUT_CLOSED = "crear un nuevo ".$LNG->GROUP_NAME;

$LNG->GROUP_MAP_CREATE_BUTTON = 'Crear nuevo '.$LNG->MAP_NAME;
$LNG->MAP_GROUP_JOIN_GROUP = " para contribuir a este ".$LNG->MAP_NAME;
$LNG->GROUP_JOIN_GROUP = " crear una nueva ".$LNG->MAP_NAME;

$LNG->GROUP_PHOTO_FORM_HINT = "(opcional) - Por favor, añada una imagen que represente este ".$LNG->GROUP_NAME;
$LNG->GROUP_NAME_FORM_HINT = "(obligatorio) - El nombre de este ".$LNG->GROUP_NAME;
$LNG->GROUP_DESC_FORM_HINT = "(opcional) - Una descripción del propósito de este ".$LNG->GROUP_NAME;
$LNG->GROUP_WEBSITE_FORM_HINT = "(opcional) - Añadir un sitio web asociado a este ".$LNG->GROUP_NAME;

$LNG->GROUP_FORM_NAME = "Nombre:";
$LNG->GROUP_FORM_DESC = "Descripción:";
$LNG->GROUP_FORM_WEBSITE = "Website:";
$LNG->GROUP_FORM_MEMBERS_CURRENT = "Miembros actuales:";

$LNG->GROUP_FORM_SELECT = "Seleccione un ".$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NO_MEMBERS = 'Este '.$LNG->GROUP_NAME.' no tiene miembros.';
$LNG->GROUP_FORM_NO_PENDING = 'Este '.$LNG->GROUP_NAME.' no tiene solicitudes de miembros pendientes.';
$LNG->GROUP_FORM_MEMBERS_PENDING = "Solicitudes de ingreso:";
$LNG->GROUP_FORM_NAME_LABEL = "Nombre";
$LNG->GROUP_FORM_DESC_LABEL = "Descripción";
$LNG->GROUP_FORM_ISADMIN_LABEL = "Admin";
$LNG->GROUP_FORM_REMOVE_LABEL = "Quitar";
$LNG->GROUP_FORM_APPROVE_LABEL = "Aprobar";
$LNG->GROUP_FORM_REJECT_LABEL = "Rechazar";
$LNG->GROUP_FORM_REMOVE_MESSAGE_PART1 = '¿Seguro que desea eliminar';
$LNG->GROUP_FORM_REMOVE_MESSAGE_PART2 = 'de este '.$LNG->GROUP_NAME.'?';
$LNG->GROUP_FORM_REJECT_MESSAGE_PART1 = '¿Seguro que deseas rechazar';
$LNG->GROUP_FORM_REJECT_MESSAGE_PART2 = 'como miembro de este '.$LNG->GROUP_NAME.'?';
$LNG->GROUP_FORM_APPROVE_MESSAGE_PART1 = '¿Seguro que desea aprobar';
$LNG->GROUP_FORM_APPROVE_MESSAGE_PART2 = 'para ser un miembro de este '.$LNG->GROUP_NAME.'?';
$LNG->GROUP_JOIN_REQUEST_MESSAGE = 'Su solicitud para unirse a este '.$LNG->GROUP_NAME.' se ha registrado y está pendiente de ser aprobada. Recibirás y el correo electrónico cuando se solicita ha sido procesado.<br><br>Gracias por su interés en este '.$LNG->GROUP_NAME;
$LNG->GROUP_JOIN_PENDING_MESSAGE = 'Solicitud de ingreso pendiente';
$LNG->GROUP_MY_ADMIN_GROUPS_TITLE = $LNG->GROUPS_NAME.' que administro:';
$LNG->GROUP_MY_MEMBER_GROUPS_TITLE = $LNG->GROUPS_NAME.' Soy un miembro del:';
$LNG->GROUP_FORM_IS_JOINING_OPEN_LABEL = 'Está '.$LNG->GROUP_NAME.' abierto el formulario para unirse al grupo?';
$LNG->GROUP_FORM_IS_JOINING_OPEN_HELP = 'Seleccione la casilla si quieres que la gente decida unirse al '.$LNG->GROUP_NAME.' por sí mismos.<br>Deje la casilla de verificación sin seleccionar, si tu prefieres '.$LNG->GROUP_NAME.' moderar las peticiones y por lo tanto controlar quién puede formar parte del '.$LNG->GROUP_NAME;

$LNG->GROUP_FORM_MEMBERS = "Añadir miembros:<br/>(separados por comas)";
$LNG->GROUP_FORM_MEMBERS_HELP = "Por favor, introduzca la dirección de correo electrónico de todas aquellas personas que le gustaría unirse a este grupo, todas esas personas recibirán un correo electrónico notificándoles la pertenencia a un grupo y los usuarios que aún no tienen cuentas Hub serán invitados a unirse.";
$LNG->GROUP_FORM_NAME_ERROR = 'Debe ingresar un nombre para el '.$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NOT_GROUP_ADMIN = 'Usted no es un administrador de este '.$LNG->GROUP_NAME;
$LNG->GROUP_FORM_NOT_GROUP_ADMIN_ANY = 'Usted no es un administrador de cualquier '.$LNG->GROUPS_NAME;
$LNG->GROUP_FORM_LOCATION = 'Localización: (pueblo/ciudad)';
$LNG->GROUP_FORM_PHOTO = 'Foto';
$LNG->GROUP_FORM_PHOTO_HELP = '(tamaño mínimo 150px w x 100px h. Las imágenes más grandes se modificarán para este tamaño)';

$LNG->GROUP_BLOCK_STATS_PEOPLE = 'Miembros:';
$LNG->GROUP_BLOCK_STATS_ISSUES = $LNG->ISSUES_NAME.':';
$LNG->GROUP_BLOCK_STATS_VOTES = $LNG->VOTES_NAME.':';

$LNG->GROUP_MEMBERS_LABEL = "Miembros del grupo";
$LNG->LOADING_GROUP_MEMBERS = "Cargando usuarios de grupo";
$LNG->DEBATE_MEMBERS_LABEL = $LNG->ISSUE_NAME." Participantes";
$LNG->LOADING_DEBATE_MEMBERS = "Calculando ".$LNG->ISSUE_NAME." Miembros";
$LNG->GROUP_NO_MEMBERS_MESSAGE = 'Este '.$LNG->GROUP_NAME.' no tiene miembros.';

/** END GROUP **/

$LNG->DEBATE_IDEA_ID_ERROR = 'El '.$LNG->SOLUTION_NAME.'  que se está editando no se pudo encontrar.';

$LNG->FORM_ISSUE_LABEL_TITLE = $LNG->ISSUE_NAME." Título...";
$LNG->FORM_ISSUE_LABEL_DESC = $LNG->ISSUE_NAME." Descripción...";
$LNG->FORM_ISSUE_NEW_TITLE = "Añadir nuevo ".$LNG->ISSUE_NAME;
$LNG->FORM_EVIDENCE_NEW_TITLE_PRO = "Añadir nuevo ".$LNG->PRO_NAME_SHORT;
$LNG->FORM_EVIDENCE_NEW_TITLE_CON = "Añadir nuevo ".$LNG->CON_NAME_SHORT;
$LNG->FORM_SOLUTION_NEW_TITLE = "Añadir nuevo ".$LNG->SOLUTION_NAME;
$LNG->FORM_ADD_NEW = "Añadir nuevo";
$LNG->FORM_PRIVACY = 'Público:';
$LNG->FORM_PRIVACY_HINT = "Si este artículo es público puede ser visto por cualquiera. Si es privado sólo el propietario lo puede ver, o si el item está en un grupo, por otros miembros del grupo.";

$LNG->FORM_IDEA_LABEL_TITLE = $LNG->SOLUTION_NAME." Título...";
$LNG->FORM_IDEA_LABEL_DESC = $LNG->SOLUTION_NAME." Descripción...";

$LNG->FORM_BUTTON_SUBMIT = 'Presentar';
$LNG->FORM_BUTTON_SAVE = 'Guardar';

$LNG->NODE_TOGGLE_HINT = 'Pulsa aquí para ver/ocultar más detalles';
$LNG->NODE_ADDED_BY = 'Añadido por:';
$LNG->NODE_CHILDREN_EVIDENCE_PRO = 'A favor';
$LNG->NODE_CHILDREN_EVIDENCE_CON = 'En contra';

$LNG->MAP_IMAGE_LABEL = $LNG->MAP_NAME.' Imagen:';
$LNG->MAP_BACKGROUND_LABEL = $LNG->MAP_NAME.' Imagen de fondo:';
$LNG->MAP_BACKGROUND_REPLACE_LABEL = 'Reemplazar imagen de fondo:';
$LNG->MAP_BACKGROUND_HELP = 'Opcionalmente seleccionar una imagen de fondo terminar de mapear. El tamaño de la imagen se dibuja como siempre.';
$LNG->MAP_BACKGROUND_DELETE_LABEL = 'Eliminar imagen';
$LNG->BUILTFROM_DIALOG_TITLE=" fue construido desde:";
$LNG->PAGE_BUTTON_DASHBOARD = 'Dashboard (tablero de mandos)';
$LNG->PAGE_BUTTON_SHARE = 'Compartir';

$LNG->IDEA_COMMENTS_LINK = $LNG->CHATS_NAME;
$LNG->IDEA_COMMENTS_HINT = 'Ver y añadir'.$LNG->CHATS_NAME.' en este '.$LNG->SOLUTION_NAME;
$LNG->IDEA_COMMENTS_CHILDREN_TITLE = $LNG->CHATS_NAME;
$LNG->IDEA_COMMENT_ID_ERROR = $LNG->CHAT_NAME.' el objeto no se puede encontrar para editar';

$LNG->NODE_EDIT_SOLUTION_ICON_HINT = 'Editar este '.$LNG->SOLUTION_NAME;


/** MERGE ISSUES **/
$LNG->FORM_IDEA_MERGE_TITLE = "Fundirse ".$LNG->SOLUTIONS_NAME;
$LNG->FORM_IDEA_MERGE_LABEL_TITLE = "Unirse ".$LNG->SOLUTIONS_NAME." Título...";
$LNG->FORM_IDEA_MERGE_LABEL_DESC = "Unirse ".$LNG->SOLUTIONS_NAME." Descripción...";
$LNG->FORM_IDEA_MERGE_HINT = "Crear una nueva idea que representa las ideas seleccionadas. Conecte los comentarios y argumentos sobre las ideas seleccionadas para esta nueva Idea. Luego retira las ideas seleccionadas.";
$LNG->FORM_IDEA_MERGE_MUST_SELECT = 'Primero debe seleccionar al menos 2 ideas para fusionar.';
$LNG->FORM_IDEA_MERGE_NO_TITLE = "Debe seleccionar un título para la nueva fusión ".$LNG->SOLUTION_NAME;


/** SPLIT ISSUE **/
$LNG->FORM_BUTTON_SPLIT = 'División';
$LNG->FORM_BUTTON_SPLIT_HINT = 'Divide esto '.$LNG->SOLUTION_NAME.' en dos o mas '.$LNG->SOLUTIONS_NAME;
$LNG->FORM_REMOVE_MULTI = "¿Seguro que quieres eliminar este artículo? Esta acción no se puede deshacer!";
$LNG->FORM_SPLIT_IDEA_ERROR = "Debe introducir un título para las dos primeras ideas";


/** LIST NAV **/
$LNG->LIST_NAV_PREVIOUS_HINT = 'Anterior';
$LNG->LIST_NAV_NO_PREVIOUS_HINT = 'No hay anterior';
$LNG->LIST_NAV_NEXT_HINT = 'Siguiente';
$LNG->LIST_NAV_NO_NEXT_HINT = 'No hay siguiente';
$LNG->LIST_NAV_NO_ITEMS = "Usted no ha añadido ninguno tadavía.";
$LNG->LIST_NAV_TO = 'para';
$LNG->LIST_NAV_NO_CON = 'No existen'.$LNG->CONS_NAME.' para mostrar';
$LNG->LIST_NAV_NO_PRO = 'No existen'.$LNG->PROS_NAME.' para mostrar';
$LNG->LIST_NAV_NO_EVIDENCE = 'No existen '.$LNG->ARGUMENT_NAME.' items para mostrar';
$LNG->LIST_NAV_NO_ISSUE = 'No existen '.$LNG->ISSUES_NAME.' para mostrar';
$LNG->LIST_NAV_NO_SOLUTION = 'No existen '.$LNG->SOLUTIONS_NAME.' para mostrar';
$LNG->LIST_NAV_NO_ITEMS = 'No existen items para mostrar';

/** ODD **/
$LNG->POPUPS_BLOCK = 'Usted parece tener las ventanas emergentes bloqueadas.\n\n Por favor, cambiar la configuración del navegador para permitir LiteMap abrir ventanas emergentes.';
$LNG->RESET_INVALID_MESSAGE = 'El código para restablecer contraseña no es válido';
$LNG->SIDEBAR_TITLE = "Vistos recientemente";
$LNG->INDEX_ALL_DATA = 'Todos los datos';
$LNG->ENTER_URL_FIRST = 'Deberías introducir la URL primero';


/** LOADING MESSAGES **/
$LNG->LOADING_ITEMS = 'Cargando items';
$LNG->LOADING_MESSAGE_PRINT_NODE = 'This may take a minute or so depending on the length of the list you are viewing';
$LNG->LOADING_CHALLENGES = '(Cargando '.$LNG->CHALLENGES_NAME.'...)';
$LNG->LOADING_ISSUES = '(Cargando '.$LNG->ISSUES_NAME.'...)';
$LNG->LOADING_SOLUTIONS = '(Cargando '.$LNG->SOLUTIONS_NAME.'...)';
$LNG->LOADING_PROS = '(Cargando '.$LNG->PROS_NAME.'...)';
$LNG->LOADING_CONS = '(Cargando '.$LNG->CONS_NAME.'...)';
$LNG->LOADING_EVIDENCES = '(Cargando '.$LNG->ARGUMENTS_NAME.'...)';
$LNG->LOADING_RESOURCES = '(Cargando '.$LNG->RESOURCES_NAME.'...)';
$LNG->LOADING_DATA = '(Cargando datos...)';
$LNG->LOADING_COMMENTS = '(Cargando '.$LNG->COMMENTS_NAME.'...)';
$LNG->LOADING_CHATS = '(Cargando '.$LNG->CHATS_NAME.'...)';
$LNG->LOADING_USERS = '(Cargando '.$LNG->USERS_NAME.'...)';
$LNG->LOADING_GROUPS = '(Cargando '.$LNG->GROUPS_NAME.'...)';
$LNG->LOADING_MAPS = '(Cargando '.$LNG->MAPS_NAME.'...)';
$LNG->LOADING_MESSAGE = 'Cargando...';

/** TABS **/
//main
$LNG->TAB_HOME = 'Home';
$LNG->TAB_MAP = $LNG->MAPS_NAME;
$LNG->TAB_GROUP = $LNG->GROUPS_NAME;
$LNG->TAB_PRO = $LNG->PROS_NAME;
$LNG->TAB_CON = $LNG->CONS_NAME;

//explore
$LNG->VIEWS_LINEAR_TITLE = "Árboles de conocimiento";
$LNG->VIEWS_LINEAR_HINT = "Click para ver áboles de conocimiento de este item";
$LNG->VIEWS_WIDGET_TITLE = "Todos los detalles";
$LNG->WIDGET = "Click para ver áboles de conocimiento de este item";
$LNG->VIEWS_EVIDENCE_MAP_TITLE="gráfico de redes de trabajo (Network)";
$LNG->VIEWS_EVIDENCE_MAP_HINT="Click para ver el gráfico de las redes de trabajo de este item";

/** ERROR MESSAGES */
$LNG->DATABASE_CONNECTION_ERROR = 'No se pudo conectar a la base de datos - por favor compruebe la configuración del servidor.';
$LNG->ITEM_NOT_FOUND_ERROR = 'Item no encontrado';

/** BUTTONS AND LINK HINTS **/
$LNG->SIGN_IN_HINT = 'Entra para añadir a LiteMap';
$LNG->SIGN_IN_FOLLOW_HINT = 'Estra para seguir a este entrada';

$LNG->ADD_BUTTON = 'Añadir';
$LNG->FOLLOW_BUTTON_ALT = 'Seguir';
$LNG->FOLLOW_OFF_BUTTON_ALT = 'Seguir apagado';

$LNG->EDIT_BUTTON_TEXT = 'Editar';
$LNG->EDIT_BUTTON_HINT_ITEM = 'Editar este item';
$LNG->EDIT_BUTTON_HINT_CHALLENGE = 'Editar este '.$LNG->CHALLENGE_NAME;
$LNG->EDIT_BUTTON_HINT_ISSUE = 'Editar este '.$LNG->ISSUE_NAME;
$LNG->EDIT_BUTTON_HINT_SOLUTION = 'Editar este '.$LNG->SOLUTION_NAME;
$LNG->EDIT_BUTTON_HINT_EVIDENCE = 'Editar este '.$LNG->ARGUMENT_NAME;
$LNG->EDIT_BUTTON_HINT_COMMENT = 'Editar este '.$LNG->COMMENT_NAME;

$LNG->DELETE_BUTTON_ALT = 'Eliminar';
$LNG->DELETE_BUTTON_HINT = 'Eliminar este item';
$LNG->NO_DELETE_BUTTON_ALT = 'Eliminar no disponible';
$LNG->NO_DELETE_BUTTON_HINT = 'Usted no puede eliminar este item. Alguien más está conectado a el';


/** FILTERS AND SORTS **/
$LNG->FILTER_BY = 'Filtrado por';
$LNG->FILTER_TYPES_ALL = 'Todos los tipos';

$LNG->SORT = 'Ordenar';
$LNG->SORT_BY = 'Ordenar por';
$LNG->SORT_ASC = 'Ascendente';
$LNG->SORT_DESC = 'descendente';
$LNG->SORT_CREATIONDATE = 'Fecha de creación';
$LNG->SORT_MODDATE = 'FEcha de modificación';
$LNG->SORT_TITLE = 'Título';
$LNG->SORT_URL = 'Website';
$LNG->SORT_NAME = 'Nombre';
$LNG->SORT_MEMBERS = 'Cuenta de Miembro';
$LNG->SORT_CONNECTIONS = 'Conexiones';
$LNG->SORT_VOTES = 'Votos';
$LNG->SORT_LAST_LOGIN = 'Última sesión';
$LNG->SORT_DATE_JOINED = 'FEcha de registro';

$LNG->ALL_ITEMS_FILTER = "todos los Items";
$LNG->CONNECTED_ITEMS_FILTER = "Items conectados";
$LNG->UNCONNECTED_ITEMS_FILTER = "Items desconectados";

/** EXPLORE SECTION TITLES **/
$LNG->EXPLORE_challengeToFollower = $LNG->FOLLOWERS_NAME.' de este'.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_issueToFollower = $LNG->FOLLOWERS_NAME.' de este '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_solutionToFollower = $LNG->FOLLOWERS_NAME.' de este '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_solutionToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_evidenceToFollower = $LNG->FOLLOWERS_NAME.' de este '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_evidenceToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_proToFollower = $LNG->FOLLOWERS_NAME.' de este '.$LNG->PRO_NAME;
$LNG->EXPLORE_proToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_conToFollower = $LNG->FOLLOWERS_NAME.' de este '.$LNG->CON_NAME;
$LNG->EXPLORE_conToMap = $LNG->MAPS_NAME;
$LNG->EXPLORE_commentToFollower = $LNG->FOLLOWERS_NAME.' de este '.$LNG->COMMENT_NAME;
$LNG->EXPLORE_commentToMap = $LNG->MAPS_NAME;

/** EXPLORE BUTTONS,LINKS AND HINTS **/
$LNG->EXPLORE_PRINT_BUTTON_ALT = "Imprimir este item";
$LNG->EXPLORE_PRINT_BUTTON_HINT = "Imprimir este item";

$LNG->EXPLORE_BACKTOTOP = 'Volver arriba';
$LNG->EXPLORE_BACKTOTOP_IMG_ALT = 'arriba';

$LNG->EXPLORE_SUPPORTING_EVIDENCE = 'Apoyo'.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_COUNTER_EVIDENCE = 'Contador '.$LNG->ARGUMENT_NAME;
$LNG->EXPLORE_ISSUES_ADDRESSED = $LNG->ISSUES_NAME.' dirigido';
$LNG->EXPLORE_CHALLENGES_ADDRESSED = $LNG->CHALLENGES_NAME.' dirigido';
$LNG->EXPLORE_SOLUTIONS_SPECIFIED = $LNG->SOLUTIONS_NAME.' especificado';
$LNG->EXPLORE_EVIDENCE_SPECIFIED = $LNG->ARGUMENTS_NAME.' especificado';

$LNG->HOME_ADDITIONAL_INFO_TOGGLE_HINT = 'Pulsa aquí para ver / ocultar información adicional';

$LNG->CONDITIONS_REGISTER_FORM_TITLE = 'Términos y condiciones de uso';
$LNG->CONDITIONS_REGISTER_FORM_MESSAGE = 'Al registrarse para ser miembro de este Hub usted está de acuerdo con los Términos y Condiciones de uso como está escrito en nuestra <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Téminos de uso</a>.';
$LNG->CONDITIONS_AGREE_FORM_REGISTER_MESSAGE = 'Acepto los términos y condiciones de uso de este Hub';
$LNG->CONDITIONS_AGREE_FAILED_MESSAGE = 'Usted debe aceptar los términos y condiciones de uso de este Hub antes de poder registrarse.';
$LNG->CONDITIONS_LOGIN_FORM_MESSAGE = 'Si registrarse para ser miembro de este Hub usted está de acuerdo con los Términos y Condiciones de uso como está escrito en nuestra <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Téminos de uso</a>.';

$LNG->FORM_HEADER_MESSAGE = "Tenga en cuenta que todos los datos que introduzca aquí serán visibles públicamente por otros usuarios de este sitio, a menos que desactive la opción 'Public'.";
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1 = '(los campos con un';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2 = 'son obligatorios';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART3 = ', a menos que estén en un apartado opcional que no está completando)';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART4 = '.)';
$LNG->FORM_RESOURCE_ADD_ANOTHER = 'añadir otra '.$LNG->RESOURCE_NAME;
$LNG->FORM_ADD_ANOTHER = 'agrega otro';
$LNG->RESOURCES_REMOTE_FORM_HINT = '(opcional) - ingrese '.$LNG->RESOURCES_NAME.' el apoyo para este ítem. La url del sitio debería haber entrado automáticamente para usted, así como cualquier texto seleccionado.';
$LNG->RESOURCES_FORM_HINT  = '(opcional) - Por favor anñade algún soporte '.$LNG->RESOURCES_NAME.' será útil para las personas que visiten este item.';
$LNG->RESOURCES_TITLE_FORM_HINT = '(obligatorio) - Introduzca un título para el recurso Web. Si usted no completa el título, se utilizará la URL.<br><br>Usted puede utilizar el botón de flecha en el extremo del campo URL para tratar de buscar el título de la página web de forma automática si lo desea.';
$LNG->RESOURCES_URL_FORM_HINT = '(obligatorio) - Introduzca el url de la web de recursos';

$LNG->FORM_REQUIRED_FIELDS = 'indica campo requerido';
$LNG->FORM_LABEL_SUMMARY = 'Resumen:';
$LNG->FORM_LABEL_DESC = 'Descripción:';
$LNG->FORM_LABEL_TYPE = 'Tipo:';
$LNG->FORM_LABEL_EVIDENCE_TYPE = $LNG->ARGUMENT_NAME.' Tipo:';
$LNG->FORM_LABEL_EVIDENCE_RESOURCES = $LNG->ARGUMENT_NAME.' '.$LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_URL = 'Url:';
$LNG->FORM_LABEL_TITLE = 'Título:';
$LNG->FORM_LABEL_NAME = 'Nombre:';
$LNG->FORM_LABEL_PROJECT_STARTED_DATE = 'Empezar on:';
$LNG->FORM_LABEL_PROJECT_ENDED_DATE = 'Finalizar on:';
$LNG->FORM_LABEL_LOCATION = 'Ubicación';
$LNG->FORM_LABEL_ADDRESS1 = 'Dirección 1:';
$LNG->FORM_LABEL_ADDRESS2 = 'Dirección 2:';
$LNG->FORM_LABEL_TOWN = 'Pueblo/ciudad:';
$LNG->FORM_LABEL_POSTAL_CODE = 'Código postal:';
$LNG->FORM_LABEL_COUNTRY = 'País:';
$LNG->FORM_LABEL_COUNTRY_CHOICE = 'País...';
$LNG->FORM_LABEL_CHALLENGES_TOGGLE = 'Mostrar/Ocultar '.$LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_CHALLENGES = $LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_RESOURCES = $LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_CLIP = 'Clip:';
$LNG->FORM_LABEL_CLIPS = 'Clips:';

$LNG->FORM_DESC_PLAIN_TEXT_LINK = 'Texto sin formato';
$LNG->FORM_DESC_PLAIN_TEXT_HINT = 'Cambiar a un texto plano. El formateo se perderá.';
$LNG->FORM_DESC_HTML_TEXT_LINK = 'Formateo';
$LNG->FORM_DESC_HTML_TEXT_HINT = 'Mostrar barra de herramientas de formato.';
$LNG->FORM_DESC_HTML_SWITCH_WARNING = '¿Seguro que quieres cambiar a texto plano? Advertencia: Todo el formato se perderá.';

$LNG->FORM_AUTOCOMPLETE_TITLE_HINT = 'Pruebe a buscar el título de la página web desde datos de la página web';
$LNG->FORM_SELECT_RESOURCE_HINT = 'Seleccionar/crear un '.$LNG->RESOURCE_NAME.' para apoyar esta';

$LNG->FORM_BUTTON_REMOVE = 'Quitar';
$LNG->FORM_BUTTON_REMOVE_CAP = 'Quitar';
$LNG->FORM_BUTTON_SELECT_ANOTHER = 'Seleccione otro';
$LNG->FORM_BUTTON_ADD_ANOTHER = 'Añadir otro';
$LNG->FORM_BUTTON_CHANGE = 'modificar';
$LNG->FORM_BUTTON_ADD = 'Añadir';
$LNG->FORM_BUTTON_ADD_NEW = 'Añadir nueva';
$LNG->FORM_BUTTON_PUBLISH = 'Publicar';
$LNG->FORM_BUTTON_CANCEL = 'Cancelar';
$LNG->FORM_BUTTON_CLOSE = 'Cerrar';
$LNG->FORM_BUTTON_CONTINUE = 'Continuar';
$LNG->FORM_BUTTON_NEXT = 'Siguiente   >';
$LNG->FORM_BUTTON_BACK = '<   atrás';
$LNG->FORM_BUTTON_SKIP = 'Omitir  >';
$LNG->FORM_BUTTON_PRINT_PAGE = 'Imprimir página';

$LNG->FORM_ERROR_NOT_ADMIN = 'Usted no tiene permisos para ver esta página';
$LNG->FORM_ERROR_MESSAGE = 'Los siguientes problemas fueron encontrados, por favor intentelo de nuevo';
$LNG->FORM_ERROR_MESSAGE_LOGIN = 'Los siguientes temas fueron encontrados con tu perfil en el intento:';
$LNG->FORM_ERROR_MESSAGE_REGISTRATION = 'Se encontraron los siguientes problemas con su registro, por favor intentelo de nuevo:';
$LNG->FORM_ERROR_NOT_ADMIN = "Lo sentimos necesita ser administrador para acceder a esta página";
$LNG->FORM_ERROR_PASSWORD_MISMATCH = "La confirmación de la contraseña y la contraseña no coinciden. Por favor, inténtalo de nuevo.";
$LNG->FORM_ERROR_PASSWORD_MISSING = "Por favor, introduce una contraseña.";
$LNG->FORM_ERROR_NAME_MISSING = 'Por favor, introduce tu nombre completo.';
$LNG->FORM_ERROR_INTEREST_MISSING = "Introduzca su interés en tener una cuenta con nosotros.";
$LNG->FORM_ERROR_URL_INVALID = "Por favor introduzca una URL válida (incluido 'http://').";
$LNG->FORM_ERROR_EMAIL_INVALID = "Por favor introduce una dirección de email válida.";
$LNG->FORM_ERROR_EMAIL_USED = "Esta dirección de correo electrónico ya está en uso, por favor, ingresa o seleccione una dirección de correo electrónico diferente.";
$LNG->FORM_ERROR_CAPTCHA_INVALID = "Las letras encriptadas no se ha introducido correctamente. Por favor, intentelo de nuevo.";

$LNG->FORM_TITLE_CURRENT_ITEM = 'El item actual';

//Selector
$LNG->FORM_SELECTOR_TITLE_DEFAULT = 'Seleccionar el item';
$LNG->FORM_SELECTOR_TITLE_CHALLENGE = 'Seleccionar un '.$LNG->CHALLENGE_NAME;
$LNG->FORM_SELECTOR_TITLE_RESOURCE = 'Seleccionar un '.$LNG->RESOURCE_NAME;
$LNG->FORM_SELECTOR_TITLE_EVIDENCE = 'Select una parte de '.$LNG->ARGUMENT_NAME;
$LNG->FORM_SELECTOR_TITLE_ISSUE = 'Seleccionar un '.$LNG->ISSUE_NAME;
$LNG->FORM_SELECTOR_TITLE_SOLUTION = 'Seleccionar un '.$LNG->SOLUTION_NAME;
$LNG->FORM_SELECTOR_TITLE_COMMENT = 'Seleccionar un '.$LNG->COMMENT_NAME;

$LNG->FORM_SELECTOR_SEARCH_ERROR = 'Se produjo un error al recuperar su búsqueda desde el servidor';
$LNG->FORM_SELECTOR_NOT_ITEMS = 'Usted no se ha creado ningún artículo del tipo requerido';
$LNG->FORM_SELECTOR_SEARCH_LABEL = 'Buscar';
$LNG->FORM_SELECTOR_SEARCH_MESSAGE = '( Se trata de una búsqueda de la palabra o frase clave. Dejar en blanco para enumerar todos )';
$LNG->FORM_SELECTOR_SEARCH_EMPTY_MESSAGE = 'Escriba una palabra o frase clave en el cuadro Buscar anterior';
$LNG->FORM_SELECTOR_TAB_MINE = 'Mis Datos';
$LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS = 'Buscar resultados';

//Challenge
$LNG->FORM_TITLE_CHALLENGE_ADD = 'Añadir a '.$LNG->CHALLENGE_NAME;
$LNG->FORM_TITLE_CHALLENGE_CONNECT = 'Selccionar '.$LNG->CHALLENGES_NAME.' y conectarlos a';
$LNG->FORM_TITLE_CHALLENGE_EDIT = 'Editar este '.$LNG->CHALLENGE_NAME;
$LNG->FORM_LABEL_CHALLENGE_SUMMARY = 'Resumen';
$LNG->FORM_MESSAGE_CHALLENGE = 'Añadir a '.$LNG->CHALLENGE_NAME.' puedes pensar que tiene la comunidad para hacer frente a.';
$LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR = 'Por favor, introduzca un '.$LNG->CHALLENGE_NAME.' antes de publicar';
$LNG->FORM_CHALLENGE_NOT_FOUND = 'El campo requerido '.$LNG->CHALLENGE_NAME.' antes de publicar';

//Issue
$LNG->FORM_ISSUE_TITLE_SECTION = 'Crear/Seleccionar un '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_CONNECT = $LNG->FORM_ISSUE_TITLE_SECTION.' y conéctelo al ';
$LNG->FORM_ISSUE_TITLE_ADD = 'Añadir un '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_ADD_QUICK = 'Añadir rápidamente un '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_EDIT = 'Editar este '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR = 'Por favor introduzca un '.$LNG->ISSUE_NAME.' resumen antes de publicar';
$LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE = 'Hubo un problema al crear el '.$LNG->ISSUE_NAME.':';
$LNG->FORM_ISSUE_HEADING_MESSAGE = 'Añadir una pregunta que se está investigando o una '.$LNG->ISSUE_NAME.' puedes pensar que tiene que hacer la comunidad para hacer frente a.';
$LNG->FORM_ISSUE_LABEL_SUMMARY = $LNG->ISSUE_NAME.' Resumen:';
$LNG->FORM_ISSUE_NOT_FOUND = 'El campo requerido '.$LNG->ISSUE_NAME.' no se pudo encontrar';
$LNG->FORM_ISSUE_SELECT_EXISTING = 'Seleccione existente '.$LNG->ISSUE_NAME;

// Solution
$LNG->FORM_SOLUTION_TITLE_SECTION = 'Crear/seleccionar un '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_CONNECT = $LNG->FORM_SOLUTION_TITLE_SECTION.' y conéctelo al ';
$LNG->FORM_SOLUTION_TITLE_ADD = 'Añadir un '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_ADD_QUICK = 'Añadir rápidamente un '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_EDIT = 'Editar este '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_LABEL_SUMMARY = $LNG->SOLUTION_NAME_SHORT.' Resumen:';
$LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR = 'Por favor introduzca '.$LNG->SOLUTION_NAME.' antes de publicar';
$LNG->FORM_SOLUTION_CREATE_ERROR_MESSAGE = 'Hubo un problema al crear el '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_NOT_FOUND = 'El campo requerido '.$LNG->SOLUTION_NAME.' no se pudo encontrar';
$LNG->FORM_SOLUTION_SELECT_EXISTING = 'Seleccione existente '.$LNG->SOLUTION_NAME_SHORT;
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE1 = 'Si desea agregar un '.$LNG->RESOURCE_NAME.' para esto '.$LNG->SOLUTION_NAME.' debería usar este '.$LNG->ARGUMENT_NAME.' item.';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE2 = 'Para añadir un '.$LNG->ARGUMENT_NAME.' trata de responder a la siguiente pregunta';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE3 = '¿Por qué este '.$LNG->RESOURCE_NAME.' apoya esta '.$LNG->SOLUTION_NAME.'? ?Cuál es el '.$LNG->ARGUMENT_NAME.' en este '.$LNG->RESOURCE_NAME.' que hizo que quiere agregar este '.$LNG->SOLUTION_NAME.'?';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE4 = 'Por favor, añada una explicación más adelante en el "Apoyo '.$LNG->ARGUMENT_NAME.'" en el campo "Descripción".';

// Evidence
$LNG->FORM_EVIDENCE_LABEL_SUMMARY = $LNG->ARGUMENT_NAME." Resumen:";
$LNG->FORM_EVIDENCE_TITLE_SECTION = 'Crear/Seleccionar un trozo de ';
$LNG->FORM_EVIDENCE_TITLE_SECTION_SUPPORTING = 'Apoyando';
$LNG->FORM_EVIDENCE_TITLE_SECTION_COUNTER = 'Contador';
$LNG->FORM_EVIDENCE_TITLE_CONNECT = ' y conéctelo al ';
$LNG->FORM_EVIDENCE_TITLE_ADD = 'Añadir '.$LNG->ARGUMENT_NAME;
$LNG->FORM_EVIDENCE_PRO_TITLE_ADD = 'Añadir '.$LNG->PRO_NAME;
$LNG->FORM_EVIDENCE_CON_TITLE_ADD = 'Añadir '.$LNG->CON_NAME;
$LNG->FORM_EVIDENCE_TITLE_EDIT = 'Editar '.$LNG->ARGUMENT_NAME;
$LNG->FORM_EVIDENCE_PRO_TITLE_EDIT = 'Editar '.$LNG->PRO_NAME;
$LNG->FORM_EVIDENCE_CON_TITLE_EDIT = 'Editar '.$LNG->CON_NAME;
$LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR = 'Por favor introduzca un resumen '.$LNG->ARGUMENT_NAME.' antes de publicar';
$LNG->FORM_EVIDENCE_SELECT_EXISTING = 'Selecciones existente '.$LNG->ARGUMENT_NAME;
$LNG->FORM_EVIDENCE_ALREADY_EXISTS = 'Ya tiene un artículo con ese resumen tipo. Por favor cambia cualquiera de los dos.';
$LNG->FORM_EVIDENCE_NOT_FOUND = 'El campo requerido '.$LNG->ARGUMENT_NAME.' item no se pudo encontrar';
$LNG->FORM_SUPPORTING_EVIDENCE_LABEL = 'Apoyando '.$LNG->ARGUMENT_NAME;

// Pro
$LNG->FORM_PRO_TITLE_SECTION = 'Crear/seleccionar un '.$LNG->PRO_NAME;
$LNG->FORM_PRO_TITLE_ADD = 'Añadir un '.$LNG->PRO_NAME;
$LNG->FORM_PRO_TITLE_ADD_QUICK = 'Añadir rápidamente un '.$LNG->PRO_NAME;

// Con
$LNG->FORM_CON_TITLE_SECTION = 'Crear/seleccionar un '.$LNG->CON_NAME;
$LNG->FORM_CON_TITLE_ADD = 'Añadir un '.$LNG->CON_NAME;
$LNG->FORM_CON_TITLE_SECTION_QUICK = 'Añadir rápidamente un '.$LNG->CON_NAME;

// Argument
$LNG->FORM_ARGUMENT_TITLE_SECTION = 'Crear/seleccionar un '.$LNG->ARGUMENT_NAME;
$LNG->FORM_ARGUMENT_TITLE_ADD = 'Añadir un '.$LNG->ARGUMENT_NAME;
$LNG->FORM_ARGUMENT_TITLE_SECTION_QUICK = 'Añadir rápidamente un '.$LNG->ARGUMENT_NAME;

// Idea
$LNG->FORM_COMMENT_TITLE_SECTION = 'Crear/seleccionar un '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_TITLE_ADD = 'Añadir un '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_TITLE_SECTION_QUICK = 'Añadir rápidamente un '.$LNG->COMMENT_NAME;
$LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR = 'Por favor, introduzca un '.$LNG->COMMENT_NAME.' antes de intentar publicar';

// Map
$LNG->FORM_MAP_TITLE_SECTION = 'Crear/seleccionar un '.$LNG->MAP_NAME;
$LNG->FORM_MAP_TITLE_ADD = 'Añadir un '.$LNG->MAP_NAME;

$LNG->FORM_ADD_QUICK = 'Rápida Añadir Nuevo:';

/** FORM ROLLOVER HINTS **/
//Challenge
$LNG->CHALLENGE_SUMMARY_FORM_HINT = '(Obligatorio) - introduzca un nuevo '.$LNG->CHALLENGE_NAME.' resumen. Este será el '.$LNG->CHALLENGE_NAME.' título que parecerá en las listas.';
$LNG->CHALLENGE_DESC_FORM_HINT ='(opcional) - Introduzca una descripción más larga de la '.$LNG->CHALLENGE_NAME;
$LNG->CHALLENGE_REASON_FORM_HINT = 'Describa por qué cree que esta '.$LNG->CHALLENGE_NAME.' es relevante para: ';
$LNG->CHALLENGES_FORM_HINT = 'Selecciones el '.$LNG->CHALLENGES_NAME.' que desea relacionar con: ';

// Issues
$LNG->ISSUE_SUMMARY_FORM_HINT = '(Obligatorio) - introduzca un nuevo '.$LNG->ISSUE_NAME.' resumen. Este será el '.$LNG->ISSUE_NAME.' título que parecerá en las listas.';
$LNG->ISSUE_DESC_FORM_HINT = '(opcional) - Introduzca una descripción más larga de la '.$LNG->ISSUE_NAME;
$LNG->ISSUE_CHALLENGES_FORM_HINT = '(opcional) - Seleccione una o mas '.$LNG->CHALLENGES_NAME.' que este '.$LNG->ISSUE_NAME.' relacionado con.';
$LNG->ISSUE_REASON_FORM_HINT = '(opcional) - Describa por qué cree que esta '.$LNG->ISSUE_NAME.' es relevante para: ';
$LNG->ISSUE_OTHERCHALLENGE_FORM_HINT = '(opcional) - Seleccione cualquier otra '.$LNG->CHALLENGES_NAME.' que desee relacionarse con este '.$LNG->ISSUE_NAME;
$LNG->ISSUE_RESOURCE_FORM_HINT = '(opcional) - Añadir alguna publicación, página web, o imáge, etc .. que forme parte o apoyen este '.$LNG->ISSUE_NAME.'. Puede introducir más de uno.';

// Solutions
$LNG->SOLUTION_SUMMARY_FORM_HINT = '(Obligatorio) - introduzca un nuevo '.$LNG->SOLUTION_NAME.' resumen. Este será la item título.';
$LNG->SOLUTION_PRO_FORM_HINT = 'Escriba una pieza de evidencia de apoyo para las anteriores '.$LNG->SOLUTION_NAME.'. Añadir un resumen de la evidencia, y luego, si se desea una descripción más completa y / o una URL para un sitio web que contribuye a / es la evidencia.';
$LNG->SOLUTION_CON_FORM_HINT = 'Introduzca una pieza de evidencia para oponerse a lo anterior '.$LNG->SOLUTION_NAME.'.  Añadir un resumen de la evidencia, y luego, si se desea una descripción más completa y / o una URL para un sitio web que contribuye a / es la evidencia.';
$LNG->SOLUTION_DESC_FORM_HINT = '(opcional) - Introduzca una descripción más larga '.$LNG->SOLUTION_NAME;
$LNG->SOLUTION_REASON_FORM_HINT = '(opcional) - Describa por qué cree que esta '.$LNG->SOLUTION_NAME.' es relevante para: ';

// Evidence
$LNG->EVIDENCE_SUMMARY_FORM_HINT = '(obligatorio) - Introduzca un resumen de '.$LNG->ARGUMENT_NAME.'. Este será el '.$LNG->ARGUMENT_NAME.' título que parecerá en las listas.';
$LNG->EVIDENCE_DESC_FORM_HINT = '(opcional) - Introduzca una descripción más larga de la '.$LNG->ARGUMENT_NAME;
$LNG->EVIDENCE_WEBSITE_FORM_HINT = '(opcional) - Añadir alguna publicación, página web, o imáge, etc .. que forme parte o apoyen este '.$LNG->ARGUMENT_NAME.'. Puede introducir más de uno.';
$LNG->EVIDENCE_TYPE_FORM_HINT = '(obligatorio) - Seleccione que tipo de '.$LNG->ARGUMENT_NAME.' desea presentar - por defecto es '.$CFG->EVIDENCE_TYPES_DEFAULT.', pero si puede ser más específico será mas útil.';
$LNG->EVIDENCE_REASON_FORM_HINT = '(opcional) - Describa por qué cree que esta '.$LNG->ARGUMENT_NAME.' es relevante para: ';

//Comment
$LNG->COMMENT_SUMMARY_FORM_HINT = '(obligatorio) - Introduzca un resumen de la '.$LNG->COMMENT_NAME;
$LNG->COMMENT_DESC_FORM_HINT = '(opcional) - Introduzca una descripción más larga de la '.$LNG->COMMENT_NAME;
$LNG->COMMENT_IMAGE_HINT = 'Haga clic derecho en la imagen para ampliar.';

//Remote Forms
$LNG->REMOTE_EVIDENCE_SOLUTION_FORM_HINT = 'Ingrese su apoyo '.$LNG->ARGUMENT_NAME.' para el '.$LNG->SOLUTION_NAME.'.  Añadir un resumen de la '.$LNG->ARGUMENT_NAME.', y luego, si lo desea una descripción más completa.';
$LNG->REMOTE_EVIDENCE_DESC_FORM_HINT = 'Introduzca una descripción más larga de la '.$LNG->ARGUMENT_NAME.' (opcional)';
$LNG->REMOTE_EVIDENCE_TYPE_FORM_HINT = 'Selecciona qué tipo de '.$LNG->ARGUMENT_NAME.' desea presentar - por defecto es '.$CFG->EVIDENCE_TYPES_DEFAULT.', pero si puede ser más específico puede ser útil.';


/*** NODE LISTINGS AND ITEMS ***/
$LNG->NODE_DETAIL_BUTTON_TEXT = 'todos los detalles';
$LNG->NODE_DETAIL_MENU_TEXT = 'Todos los detalles';
$LNG->NODE_DETAIL_BUTTON_HINT = 'Ir a la información completa sobre este tema.';

$LNG->NODE_TYPE_ICON_HINT = 'Ver imagen original';
$LNG->NODE_EXPLORE_BUTTON_TEXT = 'Explorar >>';
$LNG->NODE_EXPLORE_BUTTON_HINT = 'Haga clic para mostrar/ocultar donde se puede ver más información y actividades en torno a este tema';
$LNG->NODE_DISCONNECT_MENU_TEXT = 'Desconectar';
$LNG->NODE_DISCONNECT_MENU_HINT = 'Desconecte esto desde el punto focal actual';
$LNG->NODE_DISCONNECT_LINK_TEXT = 'Quitar';
$LNG->NODE_DISCONNECT_LINK_HINT = 'Desconecte esto desde el punto focal actual';
$LNG->NODE_VIEW_CONNECTOR_MENU_TEXT = "¿Quién lo conectó?";
$LNG->NODE_VIEW_CONNECTOR_MENU_HINT = "Ir a la página inicial de los conectores: ";

//in widget list

$LNG->NODE_EDIT_ICON_ALT = 'Editar';
$LNG->NODE_EDIT_CHALLENGE_ICON_HINT = 'Editar este '.$LNG->CHALLENGE_NAME;
$LNG->NODE_EDIT_ISSUE_ICON_HINT = 'Editar este '.$LNG->ISSUE_NAME;
$LNG->NODE_EDIT_EVIDENCE_ICON_HINT = 'Editar este '.$LNG->ARGUMENT_NAME;

$LNG->NODE_DELETE_ICON_ALT = 'Eliminar';
$LNG->NODE_DELETE_ICON_HINT = 'Eliminar este item';
$LNG->NODE_NO_DELETE_ICON_ALT = 'Eliminar no disponible';
$LNG->NODE_NO_DELETE_ICON_HINT = 'No se puede eliminar este elemento. Alguien más se ha conectado a el';
$LNG->NODE_SUPPORTING_EVIDENCE_LINK = 'Apoyo '.$LNG->ARGUMENT_NAME;
$LNG->NODE_ADD_SUPPORTING_EVIDENCE_HINT = 'Añadir apoyo '.$LNG->ARGUMENT_NAME;
$LNG->NODE_COUNTER_EVIDENCE_LINK = 'Contador '.$LNG->ARGUMENT_NAME;
$LNG->NODE_ADD_COUNTER_EVIDENCE_HINT = 'Añadir contador '.$LNG->ARGUMENT_NAME;

$LNG->NODE_VOTE_FOR_ICON_ALT = 'Voto a favor';
$LNG->NODE_VOTE_AGAINST_ICON_ALT = 'Voto en contra';
$LNG->NODE_VOTE_REMOVE_HINT = 'No definido...';
$LNG->NODE_VOTE_FOR_ADD_HINT = 'Promociona este...';
$LNG->NODE_VOTE_FOR_SOLUTION_HINT = 'Fuerte '.$LNG->SOLUTION_NAME.' para este';
$LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT = 'Convincente '.$LNG->ARGUMENT_NAME.' para este';
$LNG->NODE_VOTE_AGAINST_ADD_HINT = 'Degradar este...';
$LNG->NODE_VOTE_AGAINST_SOLUTION_HINT = 'Débil'.$LNG->SOLUTION_NAME.' para este';
$LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT = 'Poco convincente '.$LNG->ARGUMENT_NAME.' para este';
$LNG->NODE_VOTE_FOR_LOGIN_HINT = 'Entra para promover este';
$LNG->NODE_VOTE_AGAINST_LOGIN_HINT = 'Entra para argumentar en contra de este';
$LNG->NODE_VOTE_MENU_TEXT = 'Voto:';
$LNG->NODE_VOTE_OWN_HINT = 'No puede votar en sus propios artículos';

$LNG->NODE_VOTE_FOR_TITLE = 'Para votar este nodo en relación con:';
$LNG->NODE_VOTE_AGAINST_TITLE = 'Votar en contra de este nodo en relación con:';

$LNG->NODE_ADDED_ON = 'Añadido el:';
$LNG->NODE_CONNECTED_ON = 'Conectado en';
$LNG->NODE_CONNECTED_BY = 'Conectados por';
$LNG->NODE_RESOURCE_LINK_HINT = 'Ver sitios';
$LNG->NODE_URL_LINK_TEXT = 'Ir a la página web';
$LNG->NODE_URL_LINK_HINT = 'Abrir la página web asociada en una nueva pestaña';
$LNG->NODE_URL_HEADING = 'Url:';
$LNG->NODE_RESOURCE_CLIPS_HEADING = 'Clips:';
$LNG->NODE_RESOURCE_CLIP_HEADING = 'Clip:';
$LNG->NODE_DESC_HEADING = 'Descripción:';

$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART1 = '¿Seguro que desea desconectar';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART2 = 'de';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART3 = '?';
$LNG->NODE_DELETE_CHECK_MESSAGE = '¿Seguro que quieres eliminar el';
$LNG->NODE_DELETE_CHECK_MESSAGE_ITEM = 'item';
$LNG->NODE_FOLLOW_ITEM_HINT = 'Seguir este item...';
$LNG->NODE_UNFOLLOW_ITEM_HINT = 'DEjar de seguir este item...';


/** BUILDER TOOLBAR **/
$LNG->BUILDER_GOTO_HOME_SITE_HINT = "ir a ".$CFG->SITE_TITLE." Website (sitio web)";
$LNG->BUILDER_CLOSE_TOOLBAR_HINT = "Cerrar este".$CFG->SITE_TITLE." Ayudante";
$LNG->BUILDER_TITLE_LABEL = "Título:";
$LNG->BUILDER_EXPLORE_LINK = "Explorar";
$LNG->BUILDER_COLLAPSE_TOOLBAR_HINT = "collapso ".$CFG->SITE_TITLE." Ayudante";
$LNG->BUILDER_ADD_EVIDENCE_PRO_HINT = "Añadir nuevo ".$LNG->PRO_NAME." en ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_EVIDENCE_CON_HINT = "Añadir nuevo ".$LNG->CON_NAME." en ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_ISSUE_HINT = "Añadir nuevo ".$LNG->ISSUE_NAME." en ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_SOLUTION_HINT = "Añadir nuevo ".$LNG->SOLUTION_NAME." en ".$CFG->SITE_TITLE;
$LNG->BUILDER_ADD_COMMENT_HINT = "Añadir nuevo ".$LNG->COMMENT_NAME." en ".$CFG->SITE_TITLE;

/** BUILDER HELP PAGE **/
$LNG->HELP_BUILDER_TITLE = 'Barra de herramientas de LiteMap';
$LNG->HELP_BUILDER_PARA1 = 'La barra de herramientas LiteMap permite introducir datos en LiteMap mientras navega por la web.';
$LNG->HELP_BUILDER_GET_TITLE = '¿Cómo sconseguir la barra de herramientas?:';
$LNG->HELP_BUILDER_GET_LINK = 'Marcar este enlace';
$LNG->HELP_BUILDER_USING_FIREFOX = 'Si usa <b>Firefox</b>, <b>Chrome</b> or <b>Safari</b> puede arrastrar el enlace anterior ala barra de favotitos de su navegador.';
$LNG->HELP_BUILDER_USING_OPERA = 'Si estas usando <b>Opera</b>, haga clic en el enlace de arriba, selecciona \'Barra de marcadores Link...\'. A continuación, puede optar por \'Mostrar en la barra de marcadores\'.';
$LNG->HELP_BUILDER_USING_IE = '<b>Only available for IE 9+</b>: drag the above link to your browser Favourites toolbar but you will get a security warning message. Just select OK.';
$LNG->HELP_BUILDER_USING_IE_MORE_LINK = 'mas información IE 9';
$LNG->HELP_BUILDER_USING_IE_HIDE_LINK = 'ocultad';
$LNG->HELP_BUILDER_USING_IE_ERROR_TITLE = 'Mensaje de seguridad emergente molesto IE 9';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART1 = 'Si ve una advertencia similar a la anterior al usar nuestra barra de marcadores por favor, siga estas instrucciones:';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 = '1. En Internet Explorer, selecciona herramientas &gt; Opciones de internet.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '2. Selecciona en la ficha de seguridad.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '3. Selecciona "Sitios de confianza" (the big green tick).<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '4. Click el botón "Nivel personalizado...".<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '5. En los "Ajustes de Seguridad", desplácese hacia abajo a la sección "Miscelánea".<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '6. Encuentra este ajuste: "Websites in less privileged content zone can navigate into this zone" y selecciona "Permitir."<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '7. Click OK para cerrar el dialogo, luego pulsa OK para cerrar las opciones de Internet.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '8. REstablece Internet Explorer.';

$LNG->HELP_BUILDER_GET_TITLE_BOOKMARKLET = 'Como barra de marcadores';
$LNG->HELP_BUILDER_GET_TITLE_EXTENSION = 'Como una extensión para el navegador';
$LNG->HELP_BUILDER_EXTENSION_CHROME = "Google Chrome Extensión";
$LNG->HELP_BUILDER_EXTENSION_FIREFOX = "Firefox Extensión";
$LNG->HELP_BUILDER_EXTENSION_SAFARI = "Safari Extensión";
$LNG->HELP_BUILDER_EXTENSION_IE = "Internet Explorer Extensión";
$LNG->HELP_BUILDER_EXTENSION_MESSAGE = 'Después de instalar la extensión de activar la barra de herramientas y haciendo clic en el icono de litemap que debería aparecer en algún lugar de la barra de direcciones (la ubicación varía entre navegadores, vea las ilustraciones arriba).<br>Nota: Si tu navegador no se reinicia después de instalar la extensión, entonces tendrá que refrescar el contenido de cualquier èstaña que tenga abierta antes de que se muestre la barra de herramientas.';
$LNG->HELP_BUILDER_EXTENSION_MESSAGE2 = '(mas en fase de desarrollo)';
$LNG->HELP_BUILDER_EXTENSION_SAFARI_MESSAGE = 'Debido a las limitaciones de Safari en el botón de la extensión será siempre de color gris y no se mostrará un estado encendido/apagado como en otros navegadores. Usted tendrá que leer el texto desplazando el ratón para ver si la barra de herramientas está encendida o apagada. Además, cuando se crea una nueva entrada a traves de las formas emergentes, una vez que el formulario se cierra la página no se actualiza automáticamente, por lo que tendrá que actualizar manualmente la página para ver la nueva entrada en la página web.';
$LNG->HELP_BUILDER_EXTENSION_IE_MESSAGE = 'Esta extensión IE tiene que ejecutar un archivo DLL que se instala con el fin de trabajar. En algunos sistemas con fuertes software de control de virus puede bloquear la dll de la instalación. En algunos sistemas, como los ordenadores de empresa, tienen un fuerte ajuste de seguridad y pueden bloquear la dll y su ejecución.';

$LNG->HELP_BUILDER_WARNING = "NOTA: Debido a los cambios en las políticas de seguridad en los navegadores, ahora es posible para algunos sitios web bloquear las 'barra de marcadores' como el nuestro en el que el contenido de la carga es de otro sitio web y quiere trabajar en sus páginas web.
					Facebook y Twitter son dos ejemplos de sitios con esta política.
					En estos sitios, clica el acceso directo a bookmarklet actualmente no hará nada, por lo que puede parecer roto, pero es sólo el bloque.
					Este bookmarklet seguirá funcionando en la mayoría de sitios web, ya que no han puesto en práctica esta nueva política de seguridad.
					Por lo tanto, su navegador puede bloquear el bookmarklet, lo que puede tener para anular la configuración para conseguir que funcione.
					Actualmente estamos escribiendo extensiones específicas del navegador para ayudar con este tema (véase más adelante).";

/** MAIN TAB SCREENS - TABBERLIB **/
$LNG->TAB_ADD_MAP_LINK = 'añadir '.$LNG->MAP_NAME;
$LNG->TAB_ADD_GROUP_LINK = 'añadir '.$LNG->GROUP_NAME;
$LNG->TAB_ADD_MAP_HINT = 'añadir '.$LNG->MAP_NAME;
$LNG->TAB_ADD_GROUP_HINT = 'añadir '.$LNG->GROUP_NAME;


/** RECENT ACTIVITY EMAIL DIGEST **/
$LNG->RECENT_EMAIL_DIGEST_LABEL = 'Email resumen:';
$LNG->RECENT_EMAIL_DIGEST_REGISTER_MESSAGE = "Marque para recibir un correo electrónico mensual resumido con la actividad reciente.";
$LNG->RECENT_EMAIL_DIGEST_PROFILE_MESSAGE = "Opta por in/out para recibir en mail mensual con la actividad reciente.";


/** EXPLORE PAGE WIDGETS **/
$LNG->WIDGET_RESIZE_ITEM_ALT = 'cambiar el tamaño del item';
$LNG->WIDGET_RESIZE_ITEM_HINT = 'Cambiar el tamaño de este area';
$LNG->WIDGET_EXPAND_HINT = 'Expandir';
$LNG->WIDGET_ICON_ALT = 'Icono';
$LNG->WIDGET_OPEN_CLOSE_ALT = 'Abrir/cerrar item';
$LNG->WIDGET_OPEN_CLOSE_HINT = 'Abrir/cerrar este area';
$LNG->WIDGET_CONTRACT_HINT = 'Declaración';
$LNG->WIDGET_LOADING = 'Cargando';
$LNG->WIDGET_LOAD = 'Cargar';
$LNG->WIDGET_LOADING_EVIDENCE = 'Cargando '.$LNG->ARGUMENTS_NAME.'...';
$LNG->WIDGET_LOADING_RESOURCE = 'Cargando seleccionados '.$LNG->RESOURCES_NAME.'...';
$LNG->WIDGET_LOADING_FOLLOWERS = 'Cargando '.$LNG->FOLLOWERS_NAME.'...';
$LNG->WIDGET_EVIDENCE_ADD_HINT = 'Seleccionar/crear una contribución para agregarlo como argumento contra el elemento seleccionado actual';
$LNG->WIDGET_ADD_LINK = 'Aádir';
$LNG->WIDGET_SIGNIN_HINT = 'Entra para añadir en LiteMap';
$LNG->WIDGET_FOLLOW_SIGNIN_HINT = 'Entra para seguir esta entrada';
$LNG->WIDGET_NONE_FOUND_PART1 = 'No';
$LNG->WIDGET_NONE_FOUND_PART2 = 'Ya ñadido';
$LNG->WIDGET_NONE_FOUND_PART2b = 'Enumerado';
$LNG->WIDGET_ADD_BUTTON = 'Añadir';
$LNG->WIDGET_FOCUS_NODE_HINT = 'Click para ver más información';
$LNG->WIDGET_CLICK_EXPLORE_HINT = 'click para explorar todo';
$LNG->WIDGET_CLICK_EXPLORE_HINT2 = 'Click para explorar';
$LNG->WIDGET_NO_RESULTS_FOUND = 'Sin resultados';
$LNG->WIDGET_NO_GROUPS_FOUND = 'Allí donde no encontraron '.$LNG->GROUPS_NAME;
$LNG->WIDGET_NO_FOLLOWERS_FOUND = 'No '.$LNG->FOLLOWERS_NAME.' encontrado';
$LNG->WIDGET_NEWS_POSTED_ON = 'Publicado el';

/** SEARCH RESULTS PAGE **/
$LNG->SEARCH_TITLE_ERROR = 'Buscar resultados';
$LNG->SEARCH_ERROR_EMPTY = 'Debes ingresar algo para buscar.';
$LNG->SEARCH_TITLE = 'Buscar resultados para: ';
$LNG->SEARCH_BACKTOTOP = 'Volver arriba';
$LNG->SEARCH_BACKTOTOP_IMG_ALT = 'Arriba';


/** INNER TAB PAGE SEARCH **/
$LNG->TAB_SEARCH_MAP_LABEL = 'Buscar';
$LNG->TAB_SEARCH_GROUP_LABEL = 'Buscar';
$LNG->TAB_SEARCH_CHALLENGE_LABEL = 'Buscar';
$LNG->TAB_SEARCH_ISSUE_LABEL = 'Buscar';
$LNG->TAB_SEARCH_SOLUTION_LABEL = 'Buscar';
$LNG->TAB_SEARCH_CON_LABEL = 'Buscar';
$LNG->TAB_SEARCH_PRO_LABEL = 'Buscar ';
$LNG->TAB_SEARCH_EVIDENCE_LABEL = 'Buscar';
$LNG->TAB_SEARCH_RESOURCE_LABEL = 'Buscar';
$LNG->TAB_SEARCH_USER_LABEL = 'Buscar';
$LNG->TAB_SEARCH_COMMENT_LABEL = 'Buscar';
$LNG->TAB_SEARCH_CHAT_LABEL = 'Buscar';
$LNG->TAB_SEARCH_GO_BUTTON = 'Ir';
$LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON = 'Borrar búsqueda actual';


/** DEBATE/KNOWLEDGE TREE PAGE **/
$LNG->DEBATE_LOADING = '(Cargando contenido de los árboles de conocimiento...)';
$LNG->DEABTES_COUNT_MESSAGE_PART1 = 'Este item figura en el';

$LNG->MAP_NODE_DETAILS_HINT = 'Haga clic para explorar todos los detalles sobre este item';

$LNG->NODE_DEBATE_TOGGLE = 'Mostrar/ocultar el árbol del conocimiento';
$LNG->NODE_DEBATE_ADD_TO_MENU_TEXT = 'Añadir';
$LNG->NODE_DEBATE_ADD_TO_PRO_MENU_TEXT = 'Añadir apoyo '.$LNG->ARGUMENT_NAME;
$LNG->NODE_DEBATE_ADD_TO_CON_MENU_TEXT = 'Añadir contrario '.$LNG->ARGUMENT_NAME;
$LNG->NODE_DEBATE_ADD_TO_SOLUTION_MENU_TEXT = 'Añadir '.$LNG->SOLUTION_NAME;
$LNG->NODE_DEBATE_ADD_TO_ISSUE_MENU_TEXT = 'Añadir '.$LNG->ISSUE_NAME;

$LNG->NODE_DEBATE_ADD_TO_MENU_HINT = 'Agregue su conocimiento en torno a este tema';
$LNG->NODE_DEBATE_TREE_COUNT_HINT = 'El número de entradas añadió actualmente a este árbol de conocimiento';

$LNG->NODE_GOTO_PARENT_HINT = '- Haga click para desplazarse a esta';


/** CHATS PAGE **/
$LNG->VIEWS_CHAT_TITLE = $LNG->CHATS_NAME;
$LNG->VIEWS_CHAT_HINT = 'Haga click para ver cualquier '.$LNG->CHATS_NAME.' sobre este tema';

$LNG->CHAT_TREE_COUNT_HINT = 'El número de respuestas añadidas actualmente a este'.$LNG->CHAT_NAME.' tema';
$LNG->CHAT_REPLY_TO_MENU_TEXT = 'Responder';
$LNG->CHAT_REPLY_TO_MENU_HINT = 'Publicar una respuesta a este '.$LNG->CHAT_NAME.' item';
$LNG->CHAT_ADD_BUTTON_TEXT = 'Iniciar un nuevo '.$LNG->CHAT_NAME;
$LNG->CHAT_ADD_BUTTON_HINT = 'Iniciar una nueva '.$LNG->CHAT_NAME.' sobre el item central actual';
$LNG->CHAT_LOADING = "Cargando ".$LNG->CHATS_NAME."...";
$LNG->NODE_CHAT_BUTTON_TEXT = $LNG->CHATS_NAME;
$LNG->NODE_CHAT_BUTTON_HINT = 'Ver toda la información '.$LNG->CHATS_NAME.' sobre este item';
$LNG->CHAT_TREE_TOGGLE = 'Mostrar/ocultar las respuestas';
$LNG->NODE_REPLY_ON = 'Añadido el';

$LNG->CHAT_COMMENT_PARENT_TREE = 'Que esta en '.$LNG->CHAT_NAME.' acerca de:';
$LNG->CHAT_COMMENT_PARENT_FOCUS = 'Esta elemento aparece en una '.$LNG->CHAT_NAME.' sobre:';
$LNG->NODE_COMMENT_PARENT = 'Conectado a:';

$LNG->CHAT_DELETE_CHECK_MESSAGE_PART1 = '¿Seguro que quieres eliminar el'.$LNG->CHAT_NAME.' item: ';
$LNG->CHAT_DELETE_CHECK_MESSAGE_PART2 = '?';

$LNG->CHAT_HIGHLIGHT_NEWEST_TEXT = 'REspuestas mas recientes';

/** SPAM REPORTING **/
$LNG->SPAM_CONFIRM_MESSAGE_PART1= '¿Seguro que deseas reportar esto';
$LNG->SPAM_CONFIRM_MESSAGE_PART2= 'como spam / Inapropiado?';
$LNG->SPAM_SUCCESS_MESSAGE = 'Ha sido marcado como spam';
$LNG->SPAM_REPORTED_TEXT = 'Marcado como spam';
$LNG->SPAM_REPORTED_HINT = 'Esto ha sido marcado como spam / contenido inapropiado';
$LNG->SPAM_REPORT_TEXT = 'Marca como spam';
$LNG->SPAM_REPORT_HINT = 'Marca esto como spam / contenido inapropiado';
$LNG->SPAM_LOGIN_REPORT_TEXT = 'Entra para marcar esto como spam';
$LNG->SPAM_LOGIN_REPORT_HINT = 'Entra para marcar esto como Spam / Contenido inapropiado';

/** PRINTING LISTS **/
$LNG->TAB_PRINT_ALT = 'Imprimir';
$LNG->FOOTER_REPORT_PRINTED_ON = 'Informe impreso en:';

$LNG->TAB_PRINT_HINT_ISSUE = 'Imprimir '.$LNG->ISSUES_NAME;
$LNG->TAB_PRINT_HINT_SOLUTION = 'Imprimir '.$LNG->SOLUTIONS_NAME;
$LNG->TAB_PRINT_HINT_PRO = 'Imprimir '.$LNG->PROS_NAME;
$LNG->TAB_PRINT_HINT_CON = 'Imprimir '.$LNG->CONS_NAME;
$LNG->TAB_PRINT_HINT_COMMENT = 'Imprimir '.$LNG->COMMENTS_NAME;
$LNG->TAB_PRINT_HINT_EVIDENCE = 'Imprimir '.$LNG->ARGUMENTS_NAME;
$LNG->TAB_PRINT_HINT_MAP = 'Imprimir '.$LNG->MAPS_NAME;
$LNG->TAB_PRINT_HINT_RESOURCE = 'Imprimir '.$LNG->RESOURCES_NAME;

$LNG->TAB_PRINT_TITLE_ISSUE = 'LiteMap: '.$LNG->ISSUES_NAME;
$LNG->TAB_PRINT_TITLE_SOLUTION = 'LiteMap: '.$LNG->SOLUTIONS_NAME;
$LNG->TAB_PRINT_TITLE_PRO = 'LiteMap: '.$LNG->PRO_NAME;
$LNG->TAB_PRINT_TITLE_CON = 'LiteMap: '.$LNG->CON_NAME;
$LNG->TAB_PRINT_TITLE_COMMENT = 'LiteMap: '.$LNG->COMMENTS_NAME;
$LNG->TAB_PRINT_TITLE_EVIDENCE = 'LiteMap: '.$LNG->ARGUMENTS_NAME;
$LNG->TAB_PRINT_TITLE_MAP = 'LiteMap: '.$LNG->MAPS_NAME;
$LNG->TAB_PRINT_TITLE_RESOURCE = 'LiteMap: '.$LNG->RESOURCES_NAME;

/** MEDIA MAPPING **/
$LNG->MAP_MEDIA_LABEL = "URL de medios";

$LNG->MAP_MEDIA_IMPORT_YOUTUBE_LABEL = "O la película de YouTube";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_BUTTON = "Importar desde YouTube";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_CLEAR = "Borrar película de YouTube";

$LNG->MAP_MEDIA_IMPORT_VIMEO_LABEL = "O la película de Vimeo";
$LNG->MAP_MEDIA_IMPORT_VIMEO_BUTTON = "Importar desde Vimeo";
$LNG->MAP_MEDIA_IMPORT_VIMEO_CLEAR = "Borrar película de Vimeo";

$LNG->MAP_MOVIE_WIDTH_LABEL = "Ancho de la película";
$LNG->MAP_MOVIE_HEIGHT_LABEL = "Altura de la película";

$LNG->MAP_MEDIA_HELP = "Agregue una URL de archivo de película o sonido al mapa. A continuación, puede anotar nodos como punteros a marcas de tiempo en ese medio";
$LNG->MAP_MOVIE_WIDTH_HELP = "Establecer el ancho preferido para mostrar la película en el mapa";
$LNG->MAP_MOVIE_HEIGHT_HELP = "Establezca la altura preferida para mostrar la película en el mapa";

$LNG->MAP_MEDIA_IMPORT_YOUTTUBE_HELP = "Haga clic en el botón \'Importar desde YouTube\' para agregar el código de la película de YouTube \'Incrustar\'. El ancho, el alto y el id de película se extraerán y se utilizarán para cargar la película en el mapa.";
$LNG->MAP_MEDIA_IMPORT_YOUTUBE_PROMPT = "Pega tu código de la película de YouTube \'Embed\' aquí:";
$LNG->MAP_MEDIA_IMPORT_VIMEO_HELP = "Haga clic en el botón \'Importar desde Vimeo\' para agregar el código de la película de Vimeo \'Incrustar\'. El ancho, el alto y el id de película se extraerán y se utilizarán para cargar la película en el mapa.";
$LNG->MAP_MEDIA_IMPORT_VIMEO_PROMPT = "Pega tu código de la película de Vimeo \'Embed\' aquí:";
$LNG->MAP_MOVIE_SIZE_MESSAGE = "No se puede determinar la información de alto y ancho para su película de YouTube";

$LNG->MAP_MEDIA_NODE_JUMP_HINT = "Ir a un tiempo de índice de medios dado";
$LNG->MAP_MEDIA_NODE_JUMP = "Saltar";
$LNG->MAP_MEDIA_NODE_MEDIAINDEX = "Índice de medios: ";
$LNG->MAP_MEDIA_NODE_ASSIGN_HINT = "Asignar tiempo de índice de medios dado al nodo";
$LNG->MAP_MEDIA_NODE_ASSIGN = "Asignar índice: ";
$LNG->MAP_MEDIA_NODE_REMOVE_HINT = "Quitar tiempo de índice de medios de este nodo";
$LNG->MAP_MEDIA_NODE_REMOVE = "Eliminar el índice";
$LNG->MAP_MEDIA_MODE_HINT = "Alternar modo de reproducción de medios de mapa: cuando está activado, los nodos sólo aparecen después de su tiempo de índice de medios.";

// Map Replay
$LNG->MAP_REPLAY_SPEED_UNITS = "ms";
$LNG->MAP_REPLAY_SPEED_UNITS_HINT = "Especifique la velocidad de repetición en milisegundos mayor que cero";
$LNG->MAP_REPLAY_PLAY_HINT = "Reproducir el mapa en función de las fechas de creación";
$LNG->MAP_REPLAY_PAUSE_HINT = "Detener la reproducción del mapa";
$LNG->MAP_REPLAY_BACK_HINT = "Retroceder en la repetición";
$LNG->MAP_REPLAY_FORWARD_HINT = "Avanzar en la repetición";
$LNG->MAP_REPLAY_SPEED_ERROR  = "Asegúrese de que el valor de velocidad sea un número válido de milisegundos mayor que cero";
$LNG->MAP_REPLAY_MODE_HINT = "Alternar modo de reproducción de mapas: cuando está activado, los nodos se ordenarán por su fecha de creación y obtendrá controles para reproducir el mapa a una velocidad especificada.";
?>
