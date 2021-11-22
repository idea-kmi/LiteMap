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

	include_once("config.php");

	include_once($HUB_FLM->getCodeDirPath("ui/headerreport.php"));

?>

<div style="margin:20px;">

<h1>Testing the embeddable</h1>

<!-- p>This is an example of an iframe with a read only map embedded in a page:</p>
<iframe src="http://maptesting.kmi.open.ac.uk/ui/embed/map.php?lang=en&id=1722128760321750001424687160" width="900" height="900" scrolling="no" frameborder="1"></iframe -->

<p>This is an example of an iframe with an editable map embedded in a page:</p>
<iframe src="http://maptesting.kmi.open.ac.uk/ui/embed/editmap.php?lang=en&id=87139107230967326001403875621" width="900" height="700" scrolling="no" frameborder="1"></iframe>

<!-- p>This is an example of an iframe with an editable map embedded in a page:</p>
<iframe src="http://maptesting.kmi.open.ac.uk/ui/embed/editmap.php?lang=en&id=1722128760062067001429704524" width="900" height="700" scrolling="no" frameborder="1"></iframe -->

</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>