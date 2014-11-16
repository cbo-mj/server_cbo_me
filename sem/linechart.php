<script type="text/javascript">
	AmCharts.makeChart("dailylinechartdiv", {
        "type": "serial",
        "theme": "none",
        "pathToImages": "http://www.amcharts.com/lib/3/images/",
        "dataDateFormat": "YYYY-MM-DD",
        "valueAxes": [{
            "id":"v1",
            "axisAlpha": 0,
            "position": "left"
        }],
        "colors": [
		"#287cce"
	   ],
        "graphs": [{
			"id": "g1",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletSize": 5,
            "type": "smoothedLine",
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "title": "red line",
            "useLineColorForBulletBorder": true,
            "valueField": "value"
        }],
        "chartScrollbar": {
			"graph": "g1",
			"scrollbarHeight": 30
		},
        "chartCursor": {
            "cursorPosition": "mouse",
            "pan": true,
             "valueLineEnabled":true,
             "valueLineAxis":"v1"
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "dashLength": 1,
            "minorGridEnabled": true,
            "position": "top"
        },
        exportConfig:{
          menuRight: '20px',
          menuBottom: '50px',
          menuItems: [{
          icon: 'http://www.amcharts.com/lib/3/images/export.png',
          format: 'png'	  
          }]  
        },
        <?php 
		$array_data_provider = array();
        asort($day_date);
		
		foreach($day_date as $key => $value){
			$array_data_provider[] = "{\"date\": '{$value}',\"value\":'{$day_session[$key]}'}";
		}
		
		$final_data_provider = implode(",",$array_data_provider); //Convert array to string
	
	?>            
          
	"dataProvider": [<?php echo $final_data_provider; ?>]  
    }
);

chart.addListener("rendered", zoomChart);

zoomChart();
function zoomChart(){
    chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
};	

</script>
