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
				"position": "bottom"
            },
			"chartCursor": {
                "animationDuration": .1,
                "bulletSize": 15,
                "categoryBalloonDateFormat": "MMMM DD, YYYY"
            },
			"chartScrollbar": {
				"graph": "AmGraph-1",
				"scrollbarHeight": 30
			},
			"chartScrollbarSettings": {
				"graph": "AmGraph-1",
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
				"valueWidth": 44
			},
	<?php 
	
		$a = array();
		//asort($day_date);
		foreach($date_line as $c => $d) {
			$a[] = "{\"date\": '{$d}',\"Prospects\":'{$prospect_line[$c]}',\"Leads\":'{$leads_line[$c]}',\"Non Billable\":'{$non_bilable_line[$c]}'}";
		}
		$final_data_provider = implode(",", $a); 
		
		//echo $final_data_provider; 
	?>			
            "dataProvider": [<?php echo $final_data_provider; ?>]
        }
    );
</script>
