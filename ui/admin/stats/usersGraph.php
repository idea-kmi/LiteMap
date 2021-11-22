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

require_once('graphlib.php');
include_once($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once($HUB_FLM->getCodeDirPath("core/statslib.php"));

global $CFG;

if($USER->getIsAdmin() != "Y") {
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
	die;
}

$time = required_param("time",PARAM_ALPHANUM);
if ($time == null) {
	$time = 'weeks';
}

$startdate = $CFG->START_DATE;
$startdate = strtotime( 'first day of ' , $startdate);

// CREATE MAIN GRAPH OBJECT - SPECIFY SIZE

$graph = new graph(1000,600);

// SET TITLE OF GRAPH AND ITS PROPERTIES

$graph->parameter['title_size'] = 12;
$graph->parameter['title_colour'] = 'black';

// SET THE GRAPH LABELS AND PROPERTIES
if ($time === 'weeks') {
	$graph->parameter['x_label'] = $LNG->ADMIN_STATS_REGISTER_GRAPH_WEEK_Y_LABEL.' '.strftime( '%d %B %Y' ,$startdate).')';  			// if this is set then this text is printed on bottom axis of graph.
	$graph->parameter['title'] = $LNG->ADMIN_STATS_REGISTER_GRAPH_WEEK_TITLE;
} else {
	$graph->parameter['x_label'] = $LNG->ADMIN_STATS_REGISTER_GRAPH_MONTH_Y_LABEL.' '.strftime( '%d %B %Y' ,$startdate).')';			// if this is set then this text is printed on bottom axis of graph.
	$graph->parameter['title'] = $LNG->ADMIN_STATS_REGISTER_GRAPH_MONTH_TITLE;
}

$graph->parameter['y_label_left'] = $LNG->ADMIN_STATS_REGISTER_GRAPH_X_LABEL;  	// if this is set then this text is printed on bottom axis of graph.
$graph->parameter['y_label_right'] = $LNG->ADMIN_STATS_REGISTER_GRAPH_X_LABEL;  	// if this is set then this text is printed on right axis of graph.

$graph->parameter['label_size'] = 10;           	// 8 - label text point size
$graph->parameter['label_colour'] = 'black';     	// label text colour
$graph->parameter['y_label_angle'] = 90;          	// rotation of y axis label
$graph->parameter['x_label_angle'] = 0;          	// rotation of x axis label


// LEGENDS
//$graph->parameter['legend']          = 'outside-top';      // default. no legend.
													// otherwise: 'top-left', 'top-right', 'bottom-left', 'bottom-right',
													//   'outside-top', 'outside-bottom', 'outside-left', or 'outside-right'.
$graph->parameter['legend_offset']   = 10;    		// offset in pixels from graph or outside border.
$graph->parameter['legend_padding']  = 5;      		// padding around legend text.
$graph->parameter['legend_size']   = 8;           	// legend text point size.
$graph->parameter['legend_colour'] = 'black';       // legend text colour.
$graph->parameter['legend_border'] ='none';        	// legend border colour, or 'none'.

// PADDING AND BORDERS AND BACKGROUND COLOURS
$graph->parameter['outer_padding'] = 20;            // 5 - padding around outer text. i.e. title, y label, and x label.
$graph->parameter['inner_padding'] = 0;             // 0 - padding beteen axis text and graph.
$graph->parameter['x_inner_padding'] = 10;          // 5 - padding beteen axis text and graph.
$graph->parameter['y_inner_padding'] = 10;          // 6 - padding beteen axis text and graph.
$graph->parameter['outer_border'] = 'none';          // 'none' - colour of border aound image, or 'none'.
$graph->parameter['inner_border'] = 'black';        // colour of border around actual graph, or 'none'.
$graph->parameter['inner_border_type'] = 'axis';    // box -  'box' for all four sides, 'axis' for x/y axis only,
$graph->parameter['outer_background'] = 'none';     // none -  background colour of entire image.
$graph->parameter['inner_background'] = 'none';     // none - background colour of plot area.

//	VALUE RANGES AND SETTING
$graph->parameter['y_min_left']  = 0;            	// 0 - this will be reset to minimum value if there is a value lower than this.
$graph->parameter['y_min_right'] = 0;            	// 0 - this will be reset to minimum value if there is a value lower than this.
$graph->parameter['y_max_left']  = 10;           	// 0 - this will be reset to maximum value if there is a value higher than this.
$graph->parameter['y_max_right'] = 10;           	// 0 - this will be reset to maximum value if there is a value higher than this.
$graph->parameter['x_min']       = 0;            	// 0 - only used if x axis is numeric.

$graph->parameter['y_resolution_left'] = 1;         // scaling for rounding of y axis max value.
													// if max y value is 8645 then
													// if y_resolution is 0, then y_max becomes 9000.
													// if y_resolution is 1, then y_max becomes 8700.
													// if y_resolution is 2, then y_max becomes 8650.
													// if y_resolution is 3, then y_max becomes 8645.
													// get it?

$graph->parameter['y_decimal_left']  	= 0;        // number of decimal places for y_axis text.
$graph->parameter['y_resolution_right'] = 2;        // ... same for right hand side
$graph->parameter['y_decimal_right']    = 0;        // ... same for right hand side
$graph->parameter['x_resolution']       = 2;        // only used if x axis is numeric.
$graph->parameter['x_decimal']          = 0;        // only used if x axis is numeric.

$graph->parameter['decimal_point']      = '.';      // symbol for decimal separation  '.' or ',' *european support.
$graph->parameter['thousand_sep']       = ',';      // symbol for thousand separation ',' or ''

// DRAWING THE DATA

// FORMATTING POINTS
//$graph->parameter['point_size'] = 4;          // default point size. use even number for diamond or triangle to get nice look.

// FORMATTING LINES
//$graph->parameter['brush_size'] = 4;          // default brush size for brush line.
//$graph->parameter['brush_type'] = 'circle';   // type of brush to use to draw line. choose from the following
												//   'circle', 'square', 'horizontal', 'vertical', 'slash', 'backslash'

// FORMATTING BARS
$graph->parameter['bar_size']   = 1;          // 0.8 - size of bar to draw. < 1 bars won't touch
												//   1 is full width - i.e. bars will touch.
												//   >1 means bars will overlap.
$graph->parameter['bar_spacing']   = 5;        // 10 - space in pixels between group of bars for each x value.
$graph->parameter['shadow_offset'] = 0;         // 3 - draw shadow at this offset, unless overidden by data parameter.
$graph->parameter['shadow']        = 'grayCC';  // 'none' or colour of shadow.
$graph->parameter['shadow_below_axis'] = true;  // whether to draw shadows of bars and areas below the x/zero axis.

//
$graph->parameter['x_axis_gridlines'] = 'auto';        // if set to a number then x axis is treated as numeric.
$graph->parameter['y_axis_gridlines'] = 10;            // 6 - number of gridlines on y axis.
$graph->parameter['zero_axis']        = 'none';        // colour to draw zero-axis, or 'none'.

//	FORMATTING THE TEXT OF THE X AND Y AXIS VALUES
//$graph->parameter['axis_font']          = 'default.ttf'; // axis text font. don't forget to set 'path_to_fonts' above.
//$graph->parameter['axis_size']          =  8;            // axis text font size in points
//$graph->parameter['axis_colour']        = 'gray33';      // colour of axis text.
//$graph->parameter['y_axis_angle']       =  0;            // rotation of axis text.
$graph->parameter['x_axis_angle']       =  90;            // rotation of axis text.

//	FORMATTING TICKS (AXIS DELIMINATORS INDICATORS) AND GRIDLINES
//$graph->parameter['y_axis_text_left']   =  1;            // whether to print left hand y axis text. if 0 no text, if 1 all ticks have text,
//$graph->parameter['x_axis_text']        =  1;            //   if 4 then print every 4th tick and text, etc...
//$graph->parameter['y_axis_text_right']  =  0;            // behaviour same as above for right hand y axis.
//$graph->parameter['x_offset']           =  0.5;          // x axis tick offset from y axis as fraction of tick spacing.
//$graph->parameter['y_ticks_colour']     = 'black';       // colour to draw y ticks, or 'none'
//$graph->parameter['x_ticks_colour']     = 'black';       // colour to draw x ticks, or 'none'

//$graph->parameter['y_grid']             = 'line';        // grid lines. set to 'line' or 'dash'...
//$graph->parameter['x_grid']             = 'line';        //   or if set to 'none' print nothing.
//$graph->parameter['grid_colour']        = 'grayEE';      // default grid colour.
//$graph->parameter['tick_length']        =  4;            // length of ticks in pixels. can be negative. i.e. outside data drawing area.

$graph->offset_relation = null;

$day   = 24*60*60; // 24 hours * 60 minutes * 60 seconds
$week  = $day * 7;
$month = $day * 30.5;

// WE ONLY WANT THE LAST YEAR - OR PART THERE OF
if ($time === 'weeks') {
	$count = ceil((mktime()-$startdate) / $week);
	//if ($count > 52) {
	//	$startdate =  $startdate+($WEEK*($count - 52));
	//	$count = 52;
	//}
} else {
	$dates = new DateTime();
	$dates->setTimestamp($startdate);
	$interval = date_create('now')->diff( $dates );

	$count = $interval->m;
	$years = $interval->y;
	if (isset($years) && $years > 0) {
		$count += ($interval->y * 12);
	}
	$count = $count+1; //(to get it to this month too);

	//if ($count > 12) {
	//	$startdate = strtotime( '+'.($count - 12).' month', $startdate);
	//	$startdate = strtotime( 'first day of ' , $startdate);
	//	$count = 12;
	//}
}

for ($i=0; $i<$count; $i++) {
	if ($i < 1) {
		$mintime= $startdate;
	} else {
		$mintime= $maxtime;
	}
	if ($time === 'weeks') {
		//$maxtime=$startdate + ($week*($i+1));
		$maxtime = strtotime( '+1 week', $mintime);
	} else {
		$maxtime = strtotime( '+1 month', $mintime);
	}

	$num = getRegisteredUserCount($mintime, $maxtime);
	$graph->y_data['bar1'][$i] = $num;

	if ($time === 'weeks') {
		$thisweek = $startdate+($week*$i+1);
		//$graph->x_data[$i] = date("m / y", $thisweek);//." (".$i+1.")";
		$graph->x_data[$i] = $thisweek;
	} else {
		$graph->x_data[$i] = date("m / y", $mintime);
	}
}

$graph->parameter['x_max']  = $count;            	// 0 - only used if x axis is numeric.

$graph->y_order = array('bar1');
$graph->y_format['bar1'] = array('colour' => 'blue', 'bar' => 'fill'); //or bar=open

$graph->draw_stack();
?>
