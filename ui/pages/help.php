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
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
?>

<div class="mt-4 px-4 ">
	<h1><?php echo $LNG->PAGE_HELP_TITLE; ?></h1>
	<div class="row d-flex justify-content-between">
		<div>
			<p><?php echo $LNG->PAGE_HELP_PARA1_A; ?> <a href="<?php echo $CFG->homeAddress; ?>ui/pages/about.php"><?php echo $LNG->PAGE_HELP_PARA1_B; ?></a> <?php echo $LNG->PAGE_HELP_PARA1_C; ?></p>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_INTRO; ?> <span class="text-secondary fs-6">(5m 28s)</span></h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Overview.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Overview.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_NEW; ?> <span class="text-secondary fs-6">(4m 55s)</span></h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-NewGroupsAndMaps.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-NewGroupsAndMaps.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_MAPPING; ?> <span class="text-secondary fs-6">(20m 12s)</span></h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Mapping.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Mapping.mp4" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_TOOLBAR; ?> <span class="text-secondary fs-6">(12m 09s)</span></h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Toolbar.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Toolbar.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_SEARCHING; ?> <span class="text-secondary fs-6">(3m 41s)</h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Search.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Search.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_USERHOME; ?> <span class="text-secondary fs-6">(3m 55s)</h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Users.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Users.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_DASHBOARD; ?> <span class="text-secondary fs-6">(14m 57s)</h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Dashboard.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Dashboard.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="col text-center p-3">
			<h2><?php echo $LNG->PAGE_HELP_MOVIE_EMBEDDING; ?> <span class="text-secondary fs-6">(3m 23s)</h2>
			<video poster="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Embeddables.png" style="border:2px solid #E8E8E8" width="480px" height="350px" autobuffer="autobuffer" controls="controls">
			<source src="<?php echo $CFG->homeAddress; ?>ui/movies/LiteMap-Embeddables.mp4" type="video/mp4;" codecs="avc1.42E01E, mp4a.40.2">
			</video>
		</div>

		<div class="mt-5">
			<p><?php echo $LNG->PAGE_HELP_PARA2_A; ?> <a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>"><?php echo $LNG->PAGE_HELP_PARA2_B; ?></a>.</p>
		</div>
	</div>
</div>

<?php
  	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>