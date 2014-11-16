<script type="text/javascript">
    AmCharts.makeChart("ColumnChart", {
    "type": "serial",
    "theme": "none",
   <?php 
	$array_column_data_provider = array();
	
	foreach($year_month as $key => $value){
		$array_column_data_provider[] = "{\"monthly\": '{$value[0]}',\"sessions\":'{$total_session[$key]}'}";
	}
	
	$f_data_provider = implode(",",$array_column_data_provider); //Convert array to string

	?>
   "dataProvider": [<?php echo $f_data_provider; ?>]  
   ,
    "valueAxes": [{
        "gridColor":"#FFFFFF",
		"gridAlpha": 0.2,
		"dashLength": 0
    }],
	"colors": [
		"#3485da"
	],
    "gridAboveGraphs": true,
    "startDuration": 1,
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "fillAlphas": 0.8,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "sessions"		
    }],
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "monthly",
    "categoryAxis": {
        "gridPosition": "start",
        "gridAlpha": 0,
         "tickPosition":"start",
         "tickLength":20
    },
	"exportConfig":{
	  "menuTop": 0,
	  "menuItems": [{
      "icon": '/lib/3/images/export.png',
      "format": 'png'	  
      }]  
	}
});
    
</script>