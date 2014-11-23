<script type="text/javascript">
var chartData = generateChartData();
var chart = AmCharts.makeChart("linechartdiv2", {
    "type": "serial",
    "theme": "none",
    "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
    "dataProvider": chartData,
    "colors": [ "#ec615e", "#ffc60d", "#eb77c8" ],
    "valueAxes": [{
        "axisAlpha": 0.2,
        "dashLength": 1,
        "position": "left"
    }],
    "mouseWheelZoomEnabled":true,
    "graphs": [{
        "id":"g1",
		"type":"smoothedLine",
        "balloonText": "<span style='font-size:10px;'>[[value]]</span>",
        "bullet": "round",
        "bulletBorderAlpha": 1,
		"bulletColor":"#FFFFFF",
        "title": "Prospects",
        "valueField": "Prospects",
		"useLineColorForBulletBorder":true
    },
    {
        "id":"g2",
		"type":"smoothedLine",
        "balloonText": "<span style='font-size:10px;'>[[value]]</span>",
        "bullet": "square",
        "bulletBorderAlpha": 1,
		"bulletColor":"#FFFFFF",
        "title": "Leads",
        "valueField": "Leads",
		"useLineColorForBulletBorder":true
    },
    {
        "id":"g3",
		"type":"smoothedLine",
        "balloonText": "<span style='font-size:10px;'>[[value]]</span>",
        "bullet": "diamond",
        "bulletBorderAlpha": 1,
		"bulletColor":"#FFFFFF",
        "title": "Non Billable",
        "valueField": "Non Billable",
		"useLineColorForBulletBorder":true
    }],
    "chartScrollbar": {
        "autoGridCount": true,
        "graph": "g1",
        "scrollbarHeight": 40,
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
	"categoryAxesSettings": {
            "minPeriod": "DD",
			"maxSeries": 0
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
echo 'chart.zoomToIndexes(chartData.length - 30, chartData.length - 1);';	
} ?>
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    
}


// generate some random data, quite different range
function generateChartData() {
    var chartData = [];
 
 	<?php 
	
		$a = array();
		//asort($day_date);
		if(empty($date_line[0]) || $date_line == 0 || $date_line[0] == ''){
			$date = strtotime("yesterday");
			$date = date("Y-m-d", $date);
		
			$a[] = "{\"date\": '{$date}', \"Prospects\":'0', \"Leads\":'0',\"Non Billable\":'0'}";
		}else{
			foreach($date_line as $c => $d) {
				$a[] = "{\"date\": '{$d}',\"Prospects\":'{$prospect_line[$c]}',\"Leads\":'{$leads_line[$c]}',\"Non Billable\":'{$non_bilable_line[$c]}'}";
			}
		} 		

		$final_data_provider = implode(",", $a); 
		
		//echo $final_data_provider; 
	?>	
    chartData.push(<?php echo $final_data_provider; ?>);

 	return chartData;
	}
</script>
