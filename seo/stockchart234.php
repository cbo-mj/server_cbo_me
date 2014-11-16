<script type="text/javascript">
    var chart = AmCharts.makeChart("StockChart", {
        type: "stock",
        theme: "none",
        pathToImages: "charts/images/",
        categoryAxesSettings: {
            minPeriod: "mm"
        },
        dataSets: [{
            fieldMappings: [{
                fromField: "value",
                toField: "value"
            }, {
                fromField: "volume",
                toField: "volume"
            }],
            <?php asort($day_date);$b = array();
			
			if(empty($day_date[0])){
				$date = strtotime("yesterday");
				$date = date("Y-m-d", $date);
			
				$b[] = "{\"date\": '{$date}', \"value\":'0', \"volume\":'0'}";
			}else{
				foreach($day_date as $c => $d) {
					$b[] = "{\"date\": '{$d}', \"value\":'{$day_session[$c]}', \"volume\":'{$day_pageview[$c]}'}";
				}
			} 
			
            $g = implode(",", $b); ?> dataProvider: [ <?php echo $g; ?> ],
            categoryField: "date"
        }],
        panels: [{
            showCategoryAxis: !1,
            title: "Visits",
            percentHeight: 70,
            stockGraphs: [{
                id: "g1",
                valueField: "value",
                type: "smoothedLine",
                lineThickness: 2,
                bullet: "round",
                lineColor: "#60c481",
                useDataSetColors: !1
            }],
            stockLegend: {
                valueTextRegular: " ",
                markerType: "none"
            }
        }, {
            title: "Pageviews",
            percentHeight: 30,
            stockGraphs: [{
                valueField: "volume",
                type: "column",
                cornerRadiusTop: 2,
                fillAlphas: 1,
                lineColor: "#2c84e2",
                useDataSetColors: !1
            }],
            stockLegend: {
                valueTextRegular: " ",
                markerType: "none"
            }
        }],
        chartScrollbarSettings: {
            graph: "g1",
            usePeriod: "10mm",
            position: "bottom"
        },
        chartCursorSettings: {
            valueBalloonsEnabled: !0
        },
        panelsSettings: {
            usePrefixes: !0
        }
    });
</script>