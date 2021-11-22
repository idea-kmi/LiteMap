<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2013 The Open University UK                                   *
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

$page = optional_param("page","overview",PARAM_TEXT);
?>
<div id="tabber" style="margin-left:10px;clear:both;float:left; width: 100%;">
	<ul id="tabs" class="tab">
		<li class="tab">
			<a class="tab <?php if ($page == "overview") { echo 'current'; } else { echo 'unselected'; } ?>" href="index.php?page=overview"><span class="tab"><?php echo $LNG->ADMIN_STATS_TAB_OVERVIEW; ?></span></a>
		</li>
		<li class="tab">
			<a class="tab <?php if ($page == "register") { echo 'current'; } else { echo 'unselected'; } ?>" href="userRegistration.php?page=register"><span class="tab"><?php echo $LNG->ADMIN_STATS_TAB_REGISTER; ?></span></a>
		</li>
		<li class="tab">
			<a class="tab <?php if ($page == "ideas") { echo 'current'; } else { echo 'unselected'; } ?>" href="newIdeas.php?page=ideas"><span class="tab"><?php echo $LNG->ADMIN_STATS_TAB_IDEAS; ?></span></a>
		</li>
		<li class="tab">
			<a class="tab <?php if ($page == "conns") { echo 'current'; } else { echo 'unselected'; } ?>" href="connections.php?page=conns"><span class="tab"><?php echo $LNG->ADMIN_STATS_TAB_CONNS; ?></span></a>
		</li>
	</ul>
</div>

