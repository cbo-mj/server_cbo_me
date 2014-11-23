<script type="text/javascript">
    AmCharts.makeChart("ColumnChart", {
        type: "serial",
        theme: "none",
        <?php 
			$array_column_data_provider = array();
			if($year_month != "" || $year_month != 0){
				foreach($year_month as $key => $value) {
					$str = str_replace("-", " ", $value);
					$array_column_data_provider[] = "{\"monthly\": '{$value[0]}',\"sessions\":'{$total_session[$key]}',\"description\":'{$str}'}";
				}
			}else{
				$d = date('Y');
				$array_column_data_provider[] = "{\"monthly\": 'J',\"sessions\":'0',\"description\":'January {$d}'},{\"monthly\": 'F',\"sessions\":'0',\"description\":'February {$d}'},{\"monthly\": 'M',\"sessions\":'0',\"description\":'March {$d}'},{\"monthly\": 'A',\"sessions\":'0',\"description\":'April {$d}'},{\"monthly\": 'M',\"sessions\":'0',\"description\":'May {$d}'},{\"monthly\": 'J',\"sessions\":'0',\"description\":'June {$d}'},{\"monthly\": 'J',\"sessions\":'0',\"description\":'July {$d}'},{\"monthly\": 'A',\"sessions\":'0',\"description\":'August {$d}'},{\"monthly\": 'S',\"sessions\":'0',\"description\":'September {$d}'},{\"monthly\": 'O',\"sessions\":'0',\"description\":'October {$d}'},{\"monthly\": 'N',\"sessions\":'0',\"description\":'November {$d}'},{\"monthly\": 'D',\"sessions\":'0',\"description\":'December {$d}'}";	
			}
        $f_data_provider = implode(",", $array_column_data_provider); ?> 
		dataProvider: [ <?php echo $f_data_provider; ?> ],
        valueAxes: [{
            gridColor: "#858786",
            gridAlpha: .2,
            dashLength: 0
        }],
        colors: ["#60C481"],
        startDuration: 1,
        graphs: [{
			cornerRadiusTop: 2,
            balloonText: "[[description]]: <b>[[value]]</b>",
            fillAlphas: 1,
            lineAlpha: .2,
            type: "column",
            valueField: "sessions",
            descriptionField: "description"
        }],
        chartCursor: {
            categoryBalloonEnabled: !1,
            cursorAlpha: 0,
            zoomable: !1
        },
        categoryField: "monthly",
        categoryAxis: {
            gridPosition: "start",
            gridAlpha: .2,
            tickPosition: "start",
            tickLength: 20
        },
        exportConfig: {
            menuTop: 0,
            menuItems: [{
                icon: "/lib/3/images/export.png",
                format: "png"
            }]
        }
    }), AmCharts.makeChart("SessionPageViews", {
        type: "serial",
        theme: "none",
        dataProvider: [],
        valueAxes: [{
            gridColor: "#858786",
            gridAlpha: .2,
            dashLength: 0
        }],
        columnWidth: .5,
        colors: ["#63C473"],
        valueAxes: [{
            id: "ValueAxis-1",
            title: "Pageviews"
        }],
        gridAboveGraphs: !0,
        startDuration: 1,
        graphs: [{
            balloonText: "[[category]]: <b>[[value]]</b>",
            fillAlphas: .8,
            lineAlpha: .2,
            type: "column",
            valueField: "pageviews"
        }],
        chartCursor: {
            categoryBalloonEnabled: !1,
            cursorAlpha: 0,
            zoomable: !1
        },
        categoryField: "date",
        categoryAxis: {
            gridPosition: "start",
            gridAlpha: 0,
            tickPosition: "start",
            tickLength: 20
        },
        exportConfig: {
            menuTop: 0,
            menuItems: [{
                icon: "/lib/3/images/export.png",
                format: "png"
            }]
        }
    });
</script>