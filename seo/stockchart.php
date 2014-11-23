<script type="text/javascript">
    var chart = AmCharts.makeChart("StockChart", {
        type: "stock",
        theme: "none",
        pathToImages: "charts/images/",
        categoryAxesSettings: {
            minPeriod: "DD",
			maxSeries: 0
        },
        dataSets: [{
            fieldMappings: [{
                fromField: "value",
                toField: "value"
            }, {
                fromField: "volume",
                toField: "volume"
            }],
            <?php if($type!='' and isset($type)) {asort($day_date);$b = array();
			
			if(empty($day_date[0])){
				$date = strtotime("yesterday");
				$date = date("Y-m-d", $date);
			
				$b[] = "{\"date\": '{$date}', \"value\":'0', \"volume\":'0'}";
			}else{
				foreach($day_date as $c => $d) {
					$b[] = "{\"date\": '{$d}', \"value\":'{$day_session[$c]}', \"volume\":'{$day_pageview[$c]}'}";
				}
			} } else {
				
				asort($day_date2);$b = array();
			
			if(empty($day_date2[0])){
				$date = strtotime("yesterday");
				$date = date("Y-m-d", $date);
			
				$b[] = "{\"date\": '{$date}', \"value\":'0', \"volume\":'0'}";
			}else{
				foreach($day_date2 as $c => $d) {
					$b[] = "{\"date\": '{$d}', \"value\":'{$day_session2[$c]}', \"volume\":'{$day_pageview2[$c]}'}";
				}
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
            position: "bottom",
			color: "#000000"
        },
        chartCursorSettings: {
            valueBalloonsEnabled: !0
        },
<?php 

if($type == "last_3_months"){
	//empty selector
}elseif($type == "last_6_months"){
	//empty selector
}elseif($type == "last_year"){
	//empty selector
}else{
echo 'periodSelector: {
		position: "bottom",
		periods: [{
			period: "DD",
			count: 10,
			label: "10 days"
		}, {
			period: "MM",
			selected: true,
			count: 1,
			label: "1 month"
		}, {
			period: "YYYY",
			count: 1,
			label: "1 year"
		}, {
			period: "YTD",
			label: "YTD"
		}, {
			period: "MAX",
			label: "MAX"
		}]
	},';	
} ?>	
        panelsSettings: {
            usePrefixes: !0
        }
    });
</script>