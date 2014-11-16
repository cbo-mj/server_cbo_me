<script type="text/javascript">
    function zoomChart() {
        chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1)
    }
	AmCharts.makeChart("linechartdiv2",
        {
            "type": "serial",
            "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
            "categoryField": "date",
			//"dataDateFormat": "YYYY-MM",
			"colors": [ "#ec615e", "#ffc60d", "#eb77c8" ],
            "startDuration": 0,
			"theme": "light",
			"sequencedAnimation": false,
			"startEffect": "bounce",
            "categoryAxis": {
				"minPeriod": "DD",
                "gridPosition": "start",
				"parseDates": true,
				"position": "top"
            },
			"chartCursor": {
                "animationDuration": .1,
                "bulletSize": 15,
                "categoryBalloonDateFormat": "MMMM DD, YYYY"
            },
			"chartScrollbar": {
				"graph": "AmGraph-1",
				"scrollbarHeight": 30,
				"position": "bottom",
				"autoGridCount": true,
				"color": "#000000"
			},	
			"chartScrollbarSettings": {
				"graph": "AmGraph-2",
				"position": "bottom"
			}, 		
            "trendLines": [],
            "graphs": [
                {
                    "balloonText": "[[value]]",
                    "bullet": "round",
                    "id": "AmGraph-1",
                    "title": "Prospects",
                    "type": "smoothedLine",
                    "valueField": "Prospects"
                },
                {
                    "balloonText": "[[value]]",
                    "bullet": "square",
                    "id": "AmGraph-2",
                    "title": "Leads",
                    "type": "smoothedLine",
                    "valueField": "Leads"
                },
                {
                    "balloonText": "[[value]]",
                    "bullet": "diamond",
                    "id": "AmGraph-3",
                    "title": "Non Billable",
                    "type": "smoothedLine",
                    "valueField": "Non Billable"
                }				
            ],
            "guides": [],
		 	"valueAxesSettings": {
				"axisThickness": 2,
				"gridAlpha": 0,
				"axisAlpha": 1,
				"inside": false
			}, 
            "valueAxes": [
                {
                    "id": "ValueAxis-1",
                }
            ],
            "allLabels": [],
            "balloon": {},
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
			"periodSelector": {
				"position": "bottom",
				"periods": [{
					"period": "DD",
					"count": 10,
					"label": "10 days"
				}, {
					"period": "MM",
					"selected": true,
					"count": 1,
					"label": "1 month"
				}, {
					"period": "YYYY",
					"count": 1,
					"label": "1 year"
				}, {
					"period": "YTD",
					"label": "YTD"
				}, {
					"period": "MAX",
					"label": "MAX"
				}]
			}, 			
	<?php 
	
		$a = array();
		//asort($day_date);
		if(empty($date_line2[0]) || $date_line2 == 0 || $date_line2[0] == ''){
			$date = strtotime("yesterday");
			$date = date("Y-m-d", $date);
		
			$a[] = "{\"date\": '{$date}', \"Prospects\":'0', \"Leads\":'0',\"Non Billable\":'0'}";
		}else{
			foreach($date_line2 as $c => $d) {
				$a[] = "{\"date\": '{$d}',\"Prospects\":'{$prospect_line2[$c]}',\"Leads\":'{$leads_line2[$c]}',\"Non Billable\":'{$non_bilable_line2[$c]}'}";
			}
		} 		

		$final_data_provider = implode(",", $a); 
		
		//echo $final_data_provider; 
	?>			
            "dataProvider": [<?php echo $final_data_provider; ?>]
        }
    );
</script>
