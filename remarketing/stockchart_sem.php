<script type="text/javascript">

AmCharts.makeChart("StockChart", {
    type: "stock",
    pathToImages: "charts/images/",

    dataSets: [{
        fieldMappings: [{
            fromField: "v1",
            toField: "v1"
        }, {
            fromField: "v2",
            toField: "v2"
        }//, {
//            fromField: "v3",
//            toField: "v3"
//        }
],
		
		<?php 
			$array_date = array();
			if(isset($_POST["submit"])) {
			foreach($date as $key => $date_value)
			{
				//Looks like value = sessions and volume = pageviews (edited)
				$array_date[] = "{\"date\": '{$date_value}', \"v1\":'{$impressions[$key]}', \"v2\":'{$adClicks[$key]}'}";
				//BACKUP
				//$array_date[] = "{\"date\": '{$date_value}', \"v1\":'{$impressions[$key]}', \"v2\":'{$adClicks[$key]}', \"v3\":'{$TotalEvent[$key]}'}";
				
				//{date: newDate,v1: a1,v2: a2,v3: a3}
			}
			$f_array_date = implode(",",$array_date);
			
			if(empty($f_array_date)){
				//2014-08-08
				$date = date("Y m d");
					$f_array_date = "{\"date\": '$date', \"v1\":'0', \"v2\":'0'}";	
					//$f_array_date = "{\"date\": '$date', \"v1\":'0', \"v2\":'0', \"v3\":'0'}";	
			} }else { foreach($date2 as $key => $date_value)
			{
				//Looks like value = sessions and volume = pageviews (edited)
				$array_date[] = "{\"date\": '{$date_value}', \"v1\":'{$impressions2[$key]}', \"v2\":'{$adClicks2[$key]}'}";
				//$array_date[] = "{\"date\": '{$date_value}', \"v1\":'{$impressions2[$key]}', \"v2\":'{$adClicks2[$key]}', \"v3\":'{$TotalEvent2[$key]}'}";
				
				//{date: newDate,v1: a1,v2: a2,v3: a3}
			}
			$f_array_date = implode(",",$array_date);
			
			if(empty($f_array_date)){
				//2014-08-08
				$date = date("Y m d");
					$f_array_date = "{\"date\": '$date', \"v1\":'0', \"v2\":'0'}";	
					//$f_array_date = "{\"date\": '$date', \"v1\":'0', \"v2\":'0', \"v3\":'0'}";	
			}
			
			
			} 
			//{"date": '2014-08-01',"value":'25'}
			//date: newDate, value: a,volume: b
			
			
		?>	
		
        dataProvider: [<?php echo $f_array_date; ?>],
        categoryField: "date"
    }],

    panels: [{
        stockGraphs: [{
            id: "g1",
            title: "Impressions",
            valueField: "v1",
            valueAxis: "a1",
            type: "smoothedLine",
            lineColor: "#61c482",
            useDataSetColors: false
        }, {
            id: "g2",
            title: "Clicks",
            valueField: "v2",
            valueAxis: "a2",
            type: "smoothedLine",
            lineColor: "#e95b5b",
            useDataSetColors: false,
        }//, {
//            id: "g3",
//            title: "Events",
//            valueField: "v3",
//            lineAlpha: 0,
//            lineColor: "#3485da",
//            useDataSetColors: false,
//            includeInMinMax: false,
//            showBalloon: false
//        }
],
        valueAxes: [{
            id: "a1",
            axisColor: "#61c482",
            position: "left",
            offset: 0
        }, {
            id: "a2",
            axisColor: "#e95b5b",
            position: "right",
            offset: 0
        }],

        stockLegend: {
            position: "bottom",
            align: "right",
            markerType: "circle",       
                      }
        }//, 
//             
//        {
//        title: "Events",
//        percentHeight: 25,
//        stockGraphs: [{
//            lineColor: "#3485da",
//            valueField: "v3",
//            useDataSetColors: false,
//            type: "column",
//            cornerRadiusTop: 2,
//            fillAlphas: 1
//        }],
//        stockLegend: {
//            valueTextRegular: " ",
//            markerType: "none"
//        }
//       }
    ],

    panelsSettings: {
        marginLeft: 100, // inside: false requires that to gain some space
        marginRight: 100
    },
    valueAxesSettings: {
        axisThickness: 2,
        gridAlpha: 0,
        axisAlpha: 1,
        inside: false
    },

	chartScrollbarSettings: {
			graph: "g3",
			position: "bottom",
			color: "#000000"
	},
    chartCursorSettings: {
    valueBalloonsEnabled: true
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
	}';	
} ?>
});

</script>