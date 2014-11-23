<script type="text/javascript">
var chart = AmCharts.makeChart("StockChart", {
	type: "stock",
    "theme": "none",
    pathToImages: "http://www.amcharts.com/lib/3/images/",
	dataSets: [{
		color: "#b0de09",
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
					$str = $d;
                    list($year, $month, $day) = explode("-", $str);
					$month = $month - 1;
					//'Year: '.$year.' Month: '.$month.' Day: '.$day.'<br/>';
					//"date": new Date(2014, 09, 16),
					$b[] = "{\"date\": new Date({$year}, {$month}, {$day}), \"value\":'{$day_session[$c]}', \"volume\":'{$day_pageview[$c]}'}";
				}
			} } else {
				
				asort($day_date2);$b = array();
			
			if(empty($day_date2[0])){
				$date = strtotime("yesterday");
				$date = date("Y-m-d", $date);
			
				$b[] = "{\"date\": '{$date}', \"value\":'0', \"volume\":'0'}";
			}else{
				foreach($day_date2 as $c => $d) {
					$str = $d;
                    list($year, $month, $day) = explode("-", $str);
					$month = $month - 1;
					
					$b[] = "{\"date\": new Date({$year}, {$month}, {$day}), \"value\":'{$day_session2[$c]}', \"volume\":'{$day_pageview2[$c]}'}";
				}
			}
				
		}
			
        $g = implode(",", $b); ?> 
        dataProvider: [ <?php echo $g; ?> ],
		categoryField: "date",
		
		<?php 
		//echo "Event Date : Icon Name : Event Type : Description"."</br>";
		$h = array();
		foreach($icon_date as $k => $icon_date_value) {
			$str = $icon_date_value;
			list($year, $month, $day) = explode("-", $str);
			$month = $month - 1;
			$fl = $icon_description[$k];
			
			//echo "new Date({$year}, {$month}, {$day}) : ".$icon_name[$k]." : ".$icon_event_type[$k]." : ".$fl[0]."</br>";
			$h[] = "{date: new Date({$year}, {$month}, {$day}), type:\"{$icon_event_type[$k]}\", backgroundColor: \"#e0e0e0\", graph: \"g1\", text: \"{$fl[0]}\", description: \"{$fl}\"}";
		}	
		
		$output = implode(",", $h);
		//echo $output;
		?>	
		stockEvents: [<?php echo $output; ?>]	
		//stockEvents: [{
//			date: new Date(2014, 10, 13),
//			type: "sign",
//			backgroundColor: "#999999",
//			graph: "g1",
//			text: "S",
//			description: "Spring Carnival 3 Day Sale"
//		},{
//			date: new Date(2014, 07, 21),
//			type: "sign",
//			backgroundColor: "#999999",
//			graph: "g1",
//			text: "R",
//			description: "3 Day Sale"
//		},{
//			date: new Date(2014, 08, 25),
//			type: "sign",
//			backgroundColor: "#999999",
//			graph: "g1",
//			text: "P",
//			description: "3 Day Sale"
//		},{
//			date: new Date(2014, 09, 08),
//			type: "sign",
//			backgroundColor: "#999999",
//			graph: "g1",
//			text: "Q",
//			description: "4 Day Sale"
//		},{
//			date: new Date(2014, 09, 16),
//			type: "sign",
//			backgroundColor: "#999999",
//			graph: "g1",
//			text: "V",
//			description: "4 Day Sale Extended"
//		}]
	}],


	panels: [{
		title: "Visits",
		percentHeight: 70,

		stockGraphs: [{
			id: "g1",
            lineColor: "#60c481",
			valueField: "value",
            type: "smoothedLine",
            lineThickness: 2,
            bullet: "round",            
            useDataSetColors: !1,
			valueField: "value"
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
		color: "#000000"
	},
	categoryAxesSettings: {
            minPeriod: "DD",
			maxSeries: 0
	},
	chartCursorSettings: {
		valueBalloonsEnabled: true,
		graphBulletSize: 1,
        valueLineBalloonEnabled:true,
        valueLineEnabled:true,
        valueLineAlpha:0.5
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
            usePrefixes: true
        }
    });
</script>