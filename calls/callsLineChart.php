<script type="text/javascript">
    function zoomChart() {
        chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1)
    }
	AmCharts.makeChart("newlinechartdiv",
        {
            "type": "serial",
            "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
            "categoryField": "date",
			//"dataDateFormat": "YYYY-MM",
			colors: ["#ff1b41", "#1a9bef", "#62c479"],
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
                    "title": "Missed",
                    "type": "smoothedLine",
                    "valueField": "Missed"
                },
                {
                    "balloonText": "[[value]]",
                    "bullet": "square",
                    "id": "AmGraph-2",
                    "title": "Total",
                    "type": "smoothedLine",
                    "valueField": "Total"
                },
                {
                    "balloonText": "[[value]]",
                    "bullet": "diamond",
                    "id": "AmGraph-3",
                    "title": "Answered",
                    "type": "smoothedLine",
                    "valueField": "Answered"
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
		
            "dataProvider": [<?php echo $final_data_provider; ?>]
        }
    );
</script>
