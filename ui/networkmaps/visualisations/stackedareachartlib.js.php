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
header('Content-Type: text/javascript;');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
?>
/** REQUIRES: graphlib.js.php **/

var stackedareachart;

function createStackedAreaChart(containername){

	stackedareachart = new $jit.AreaChart({

		injectInto: containername,
		animate: true,
		Margin: {
			top: 5,
			left: 10,
			right: 10,
			bottom: 35
		},

		labelOffset: 10,

		//whether to display sums
		showAggregates: true,

		//whether to display labels at all
		showLabels: true,

		//could also be 'stacked'
		type: useGradients? 'stacked:gradient' : 'stacked',

		 //label styling
		Label: {
			type: labelType, //can be 'Native' or 'HTML'
			size: 11,
			family: 'Arial',
			color: 'black'
		},

		//enable tips
		Tips: {
			enable: true,
			onShow: function(tip, elem) {
				tip.innerHTML = "<b>" + elem.name + "</b>: " + elem.value;
			}
		},

		//add left and right click handlers
		filterOnClick: true,
		restoreOnRightClick:true
	});
	return stackedareachart;
}

function displayStackedAreaChart(json) {
 	stackedareachart.loadJSON(json);
}

function loadStackedAreaData() {
    //init data
    var json = {
        'label': ['label A', 'label B', 'label C', 'label D'],
        'values': [
        {
          'label': 'date A',
          'values': [20, 40, 15, 5]
        },
        {
          'label': 'date B',
          'values': [30, 10, 45, 10]
        },
        {
          'label': 'date E',
          'values': [38, 20, 35, 17]
        },
        {
          'label': 'date F',
          'values': [58, 10, 35, 32]
        },
        {
          'label': 'date D',
          'values': [55, 60, 34, 38]
        },
        {
          'label': 'date C',
          'values': [26, 40, 25, 40]
        }]

    };

 	stackedareachart.loadJSON(json);
}