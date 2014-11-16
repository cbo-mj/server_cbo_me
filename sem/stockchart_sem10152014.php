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
        }, {
            fromField: "v3",
            toField: "v3"
        }],
		
		<?php 
			$array_date = array();
			
			foreach($date as $key => $date_value)
			{
				//Looks like value = sessions and volume = pageviews (edited)
				$array_date[] = "{\"date\": '{$date_value}', \"v1\":'{$impressions[$key]}', \"v2\":'{$adClicks[$key]}', \"v3\":'{$TotalEvent[$key]}'}";
				
				//{date: newDate,v1: a1,v2: a2,v3: a3}
			}
			$f_array_date = implode(",",$array_date);
			
			if(empty($f_array_date)){
				//2014-08-08
				$date = date("Y m d");
					$f_array_date = "{\"date\": '$date', \"v1\":'0', \"v2\":'0', \"v3\":'0'}";	
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
        }, {
            id: "g3",
            title: "Events",
            valueField: "v3",
            lineAlpha: 0,
            lineColor: "#3485da",
            useDataSetColors: false,
            includeInMinMax: false,
            showBalloon: false
        }],
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
        }, 
             
        {
        title: "Events",
        percentHeight: 25,
        stockGraphs: [{
            lineColor: "#3485da",
            valueField: "v3",
            useDataSetColors: false,
            type: "column",
            cornerRadiusTop: 2,
            fillAlphas: 1
        }],
        stockLegend: {
            valueTextRegular: " ",
            markerType: "none"
        }
       }
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

    /*chartScrollbarSettings: {},*/

    chartCursorSettings: {
    valueBalloonsEnabled: true
    },
    periodSelector: {
        position: "top",
        dateFormat: "YYYY-MM-DD JJ:NN",
        inputFieldsEnabled: false,

        periods: [{
            period: "dd",
            count: 1,
            label: "Month",
            selected: true
        }]
    }
});

</script>