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
/* @author Michelle Bachler, KMi, The Open University */

    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
?>

<div style="float:left;width:95%">
	<div style="float:left;clear:both;margin-right:20px;">
		<h1><?php echo $LNG->HELP_BUILDER_TITLE; ?></h1>
		<p><strong><?php echo $LNG->HELP_BUILDER_PARA1; ?></strong></p>

		<h2><?php echo $LNG->HELP_BUILDER_GET_TITLE; ?></h2>
	</div>
</div>
<div style="float:left;width:5%">&nbsp;</div>



<div style="clear:both;float:left;width:95%">
	<div style="float:left;clear:both;margin-right:20px;">
		<div class="boxshadow" style="padding:5px;background:white;width:100%">
			<H2><?php echo $LNG->HELP_BUILDER_GET_TITLE_BOOKMARKLET; ?></h2>

			<p><?php echo $LNG->HELP_BUILDER_GET_LINK; ?> <a href="javascript:(function(){var%20Script=document.createElement('script');Script.type='text/javascript';Script.src='<?php echo $CFG->homeAddress; ?>builder.php';document.getElementsByTagName('head')[0].appendChild(Script);})();" ><?php echo $CFG->buildername; ?></a></p>

			<div style="margin-top: 10px;">
				<p>
				<?php echo $LNG->HELP_BUILDER_USING_FIREFOX; ?><br>	<br>
				<?php echo $LNG->HELP_BUILDER_USING_OPERA; ?><br><br>
				<?php echo $LNG->HELP_BUILDER_USING_IE; ?><br><br>
				<span id="builderintrobutton" class="active" style="font-weight:normal;text-decoration:underline" onclick="if ($('builderintromore').style.display == 'none') { $('builderintromore').style.display = 'block'; $('builderintrobutton').innerHTML = '<?php echo $LNG->HELP_BUILDER_USING_IE_HIDE_LINK; ?>'; } else { $('builderintromore').style.display = 'none';  $('builderintrobutton').innerHTML = '<?php echo $LNG->HELP_BUILDER_USING_IE_MORE_LINK; ?>';}"><?php echo $LNG->HELP_BUILDER_USING_IE_MORE_LINK; ?></span>
				</p>

				<div id="builderintromore" style="float:left;clear:both;width:100%;display:none;margin:0px;padding:0px;margin-bottom:10px;">
					<h2><?php echo $LNG->HELP_BUILDER_USING_IE_ERROR_TITLE; ?></h2>
					<p>
					<img src="<?php echo $HUB_FLM->getImagePath('help/ie-security.png'); ?>" border="0" />
					</p>
					<?php echo $LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART1; ?>
					<br><br>
					<?php echo $LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2; ?>
					<br>
				</div>
			</div>

			<div style="float:left;clear:both;background:#E8E8E8;font-weight:bold;padding:5px;margin-bottom:10px;border:1px solid lightgray;font-size:9pt"><?php echo $LNG->HELP_BUILDER_WARNING; ?></div>
		</div>
	</div>
</div>
<div style="float:left;width:5%"><img src="<?php echo $HUB_FLM->getImagePath('help/toolbar1.png'); ?>" border="0" /></div>


<div style="clear:both;float:left;width:95%;margin-top:20px;">
	<div style="float:left;clear:both;margin-right:20px;">
		<div class="boxshadow" style="padding:5px;background:white;width:100%">
			<h2><?php echo $LNG->HELP_BUILDER_GET_TITLE_EXTENSION; ?></h2>

			<div>Due to circumstances beyond our crontrol our Browser specific plugins no longer work. We will be looking to replace these in the future.</div>
		</div>
	</div>
</div>
<div style="float:left;width:5%;margin-top:20px;"><img src="<?php echo $HUB_FLM->getImagePath('help/toolbar1-extension.png'); ?>" border="0" /></div -->

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerdialog.php"));
?>