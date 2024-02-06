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
/** Author: Michelle Bachler, Kmi, The Open University, UK. **/

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

$mapid = required_param("nodeid",PARAM_ALPHANUMEXT);

$visService = 'https://cidashboard.net/ui/visualisations/activityanalysis.php?';
$visurl = $visService;

$visurl .= 'width=1000';
$visurl .= '&height=1000';
$visurl .= '&withposts=false';
$visurl .= '&lang='.$CFG->language;
$visurl .= '&timeout=60';
$visurl .= '&withtitle=false';

$visurl .= '&langurl='.urlencode($CFG->langoverride);


$dataurl = $CFG->homeAddress.'api/views/'.$mapid;
$visurl .= "&url=".$dataurl;
?>

$("tab-content-analytics-activity").src="<?php echo $visurl; ?>";