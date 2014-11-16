<script type="text/javascript">
AmCharts.makeChart("chartdiv2", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if($call_detail[0] == 0 || $call_detail[0] == ''){ echo 'colors: ["#e6e6e6", "#e6e6e6"],'; }else{ echo 'colors: ["#1a9bef", "#1a9bef"],'; }?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
    dataProvider: [{
        title: "New Visitors",
        value: <?php if($call_detail[0] == 0 || $call_detail[0] == ''){ echo '100';}else{ echo $call_detail[0]; } ?>
    }]
}),AmCharts.makeChart("answeredchartdiv2", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if($call_detail[1] == 0 && $call_detail[2] == 0){ echo 'colors: ["#e6e6e6", "#e6e6e6"],'; }else{ echo 'colors: ["#60c481", "#e6e6e6"],'; }?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
	<?php 
	if($call_detail[1] == 0 && $call_detail[2] == 0){ 
		echo 'dataProvider: [{
        		title: "New Visitors",
        		value: 100 
    		}]'; 
	}else{ 
		echo 'dataProvider: [{
        		title: "New Visitors",
        		value: '.$call_detail[1].'
    		}, {
        		title: "Visits",
        	value: '.$call_detail[2].'
    		}]'; 
	}?>
}),AmCharts.makeChart("missedchartdiv2", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if($call_detail[2] == 0 && $call_detail[1] == 0){ echo 'colors: ["#e6e6e6", "#e6e6e6"],'; }else{ echo 'colors: ["#e95b5b", "#e6e6e6"],'; }?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
	<?php 
	if($call_detail[2] == 0 && $call_detail[1] == 0){ 
		echo 'dataProvider: [{
        		title: "New Visitors",
        		value: 100 
    		}]'; 
	}else{ 
		echo 'dataProvider: [{
        		title: "New Visitors",
        		value: '.$call_detail[2].'
    		}, {
        		title: "Visits",
        	value: '.$call_detail[1].'
    		}]'; 
	}?>
}),
AmCharts.makeChart("averagechartdiv2", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if(empty($avg_call[0])){ echo 'colors: ["#e6e6e6", "#e6e6e6"],'; }else{ echo 'colors: ["#f1c83f", "#1a9bef"],'; }?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
    dataProvider: [{
        title: "New Visitors",
        value: <?php if(empty($avg_call[0])){ echo '100';}else{ echo '100'; } ?>
    }]
});		
		
var chartData = generateChartData();
var chart = AmCharts.makeChart("linechartdiv3", {
    "type": "serial",
    "theme": "none",
    "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
    "dataProvider": chartData,
    "colors": ["#ff1b41", "#1a9bef", "#62c479"],
    "valueAxes": [{
        "axisAlpha": 0.2,
        "dashLength": 1,
        "position": "left"
    }],
    "mouseWheelZoomEnabled":true,
    "graphs": [{
        "id":"g1",
		"type": "smoothedLine",
        "balloonText": "<span style='font-size:10px;'>[[value]]</span>",
        "bullet": "round",
        "bulletBorderAlpha": 1,
		"bulletColor":"#ff1b41",
        "title": "Missed",
        "valueField": "Missed",
		"useLineColorForBulletBorder":true
    },
    {
        "id":"g2",
		"type": "smoothedLine",
        "balloonText": "<span style='font-size:10px;'>[[value]]</span>",
        "bullet": "square",
        "bulletBorderAlpha": 1,
		"bulletColor":"#1a9bef",
        "title": "Total",
        "valueField": "Total",
		"useLineColorForBulletBorder":true
    },
    {
        "id":"g3",
		"type": "smoothedLine",
        "balloonText": "<span style='font-size:10px;'>[[value]]</span>",
        "bullet": "diamond",
        "bulletBorderAlpha": 1,
		"bulletColor":"#62c479",
        "title": "Answered",
        "valueField": "Answered",
		"useLineColorForBulletBorder":true
    }],
    "chartScrollbar": {
        "autoGridCount": true,
        "graph": "g1",
        "scrollbarHeight": 30,
        "color": "#000000"
    },
    "chartScrollbarSettings": {
		"position": "bottom"
	}, 
    "chartCursor": {
        "cursorPosition": "mouse"
    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true,
        "axisColor": "#DADADA",
        "dashLength": 1,
        "minorGridEnabled": true,
        "position": "top"
    },
    "legend": {
        "align": "center",
        "marginLeft": 10,
        "markerSize": 14,
        "rollOverGraphAlpha": .35,
        "useGraphSettings": !0,
        "valueAlign": "left",
        "valueWidth": 44,
        "position": "bottom"
    },
	"exportConfig":{
	  menuRight: '20px',
      menuBottom: '30px',
      menuItems: [{
      icon: 'http://www.amcharts.com/lib/3/images/export.png',
      format: 'png'	  
      }]  
	}
});

chart.addListener("rendered", zoomChart);
zoomChart();

// this method is called when chart is first inited as we listen for "dataUpdated" event
function zoomChart() {
<?php 

if($type == "last_3_months"){
	//empty selector
}elseif($type == "last_6_months"){
	//empty selector
}elseif($type == "last_year"){
	//empty selector
}else{
	echo 'chart.zoomToIndexes(chartData.length - 12, chartData.length - 1);';	
} ?>
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    
}


// generate some random data, quite different range
function generateChartData() {
    var chartData = [];

 	<?php 
	
		$a = array();
		asort($date_a);
		if(empty($date_a[0]) || $date_a[0] == 0 || $date_a[0] == ''){
			$date = strtotime("yesterday");
			$date = date("Y-m-d", $date);
		
			$a[] = "{\"date\": '{$date}',\"Missed\":'0',\"Total\":'0',\"Answered\":'0'}";
		}else{
			foreach($date_a as $c => $d) {
				$str = str_replace("-", " ", $d);
				$a[] = "{\"date\": '{$d}',\"Missed\":'{$miss_call[$c]}',\"Total\":'{$total_call[$c]}',\"Answered\":'{$ans_call[$c]}'}";
			}
		} 		

		$final_data_provider = implode(",", $a); 
		
		//echo $final_data_provider; 
	?>	
    chartData.push(<?php echo $final_data_provider; ?>);

 	return chartData;
	}
</script>