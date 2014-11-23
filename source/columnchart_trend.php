<script type="text/javascript">
    AmCharts.makeChart("SBHOTD", {
        type: "serial",
        theme: "none",
		<?php 
			$arr_hourly_sessions = array();
			foreach ($hour as $key => $hour_value) {
    			//if($hour_value != 00 || $hour_value != '00'){
					$arr_hourly_sessions[] = "{\"monthly\": '{$hour_value}', \"sessions\":'{$hour_session[$key]}'}" ;
				//}
			}
			$f_hourl_sessions = implode(",",$arr_hourly_sessions);
			
			if($f_hourl_sessions == "" && $hour == ""){
				$f_hourl_sessions = "{\"monthly\": '00', \"sessions\":'0'},{\"monthly\": '01', \"sessions\":'0'},{\"monthly\": '02', \"sessions\":'0'},{\"monthly\": '03', \"sessions\":'0'},{\"monthly\": '04', \"sessions\":'0'},{\"monthly\": '05', \"sessions\":'0'},{\"monthly\": '06', \"sessions\":'0'},{\"monthly\": '07', \"sessions\":'0'},{\"monthly\": '08', \"sessions\":'0'},{\"monthly\": '09', \"sessions\":'0'},{\"monthly\": '10', \"sessions\":'0'},{\"monthly\": '11', \"sessions\":'0'},{\"monthly\": '12', \"sessions\":'0'},{\"monthly\": '13', \"sessions\":'0'},{\"monthly\": '14', \"sessions\":'0'},{\"monthly\": '15', \"sessions\":'0'},{\"monthly\": '16', \"sessions\":'0'},{\"monthly\": '17', \"sessions\":'0'},{\"monthly\": '18', \"sessions\":'0'},{\"monthly\": '19', \"sessions\":'0'},{\"monthly\": '20', \"sessions\":'0'},{\"monthly\": '21', \"sessions\":'0'},{\"monthly\": '22', \"sessions\":'0'},{\"monthly\": '23', \"sessions\":'0'}";
			}
			//$sf = $f_hourl_sessions.",{\"monthly\": '24', \"sessions\":'$hour_session[0]'}";
			
			//foreach ($hour as $key => $hour_value) {
    			//echo    $hour_value." : ".$hour_session[$key]."</br>" ;
			//}
		
		?>
        <?php //$array_column_data_provider = array();
			//foreach($year_month as $key => $value) {
            //$str = str_replace("-", " ", $value);
            //$array_column_data_provider[] = "{\"monthly\": '{$value[0]}',\"sessions\":'{$total_session[$key]}',\"description\":'{$str}'}";
        //}
        //$f_data_provider = implode(",", $array_column_data_provider); ?> 
		
		dataProvider: [ <?php echo $f_hourl_sessions; ?> ],
        valueAxes: [{
            gridColor: "#858786",
            gridAlpha: .2,
            dashLength: 0
        }],
        colors: ["#2b84e2"],
        startDuration: 1,
        graphs: [{
			cornerRadiusTop: 2,
            //balloonText: "[[description]]: <b>[[value]]</b>",
			balloonText: "sessions: <b>[[value]]</b>",
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
    }), 
    AmCharts.makeChart("SBDOTW", {
        type: "serial",
        theme: "none",
		<?php 
			$arr_weekly_sessions = array();
			if(empty($week_day)|| $week_day == 0 || $week_day == ""){
				$arr_weekly_sessions[] = "{\"monthly\": 'Sun', \"sessions\":'0'},{\"monthly\": 'Mon', \"sessions\":'0'},{\"monthly\": 'Tue', \"sessions\":'0'},{\"monthly\": 'Wed', \"sessions\":'0'},{\"monthly\": 'Thu', \"sessions\":'0'},{\"monthly\": 'Fri', \"sessions\":'0'},{\"monthly\": 'Sat', \"sessions\":'0'}";	
			}else{
				foreach ($week_day as $key => $week_day_value) {
					$week = substr($week_day_value, 0, 3); 
					$arr_weekly_sessions[] = "{\"monthly\": '{$week}', \"sessions\":'{$week_session[$key]}'}" ;
				}
			}
			
			$f_weekly_sessions = implode(",",$arr_weekly_sessions);
			
			//foreach ($week_day as $week_day_value) {
				//echo $week_day_value." : ".$week_session[$i]."</br>" ;
			//}
		
		?>
		
		dataProvider: [ <?php echo $f_weekly_sessions; ?> ],
        valueAxes: [{
            gridColor: "#858786",
            gridAlpha: .2,
            dashLength: 0
        }],
        colors: ["#f3c742"],
        startDuration: 1,
        graphs: [{
			cornerRadiusTop: 2,
            //balloonText: "[[description]]: <b>[[value]]</b>",
			balloonText: "sessions: <b>[[value]]</b>",
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
    }),
    AmCharts.makeChart("SBMOTY", {
        type: "serial",
        theme: "none",
		<?php 
			$arr_yearly_sessions = array();
			foreach ($month_name as $key => $month_name_value) {
				$month = substr($month_name_value, 0, 3); 
				$arr_yearly_sessions[] = "{\"monthly\": '{$month}', \"sessions\":'{$month_session[$key]}'}" ;
			}
			$f_yearly_sessions = implode(",",$arr_yearly_sessions);
			//$extras = $f_yearly_sessions.",{\"monthly\": 'Oct', \"sessions\":'0'},{\"monthly\": 'Nov', \"sessions\":'0'},{\"monthly\": 'Dec', \"sessions\":'0'}";
			
			if($f_yearly_sessions == "" && $month_name ==""){
				$f_yearly_sessions = "{\"monthly\": 'Jan', \"sessions\":'0'},{\"monthly\": 'Feb', \"sessions\":'0'},{\"monthly\": 'Mar', \"sessions\":'0'},{\"monthly\": 'Apr', \"sessions\":'0'},{\"monthly\": 'May', \"sessions\":'0'},{\"monthly\": 'Jun', \"sessions\":'0'},{\"monthly\": 'Jul', \"sessions\":'0'},{\"monthly\": 'Aug', \"sessions\":'0'},{\"monthly\": 'Sep', \"sessions\":'0'},{\"monthly\": 'Oct', \"sessions\":'0'},{\"monthly\": 'Nov', \"sessions\":'0'},{\"monthly\": 'Dec', \"sessions\":'0'}";
			}
			//foreach ($month_name as $key => $month_name_value) {
				//echo $month_name_value." : ".$month_session[$key]."</br>" ;
			//}
		
		?>
		
		dataProvider: [ <?php echo $f_yearly_sessions; ?> ],
        valueAxes: [{
            gridColor: "#858786",
            gridAlpha: .2,
            dashLength: 0
        }],
        colors: ["#4cb95e"],
        startDuration: 1,
        graphs: [{
			cornerRadiusTop: 0,
            //balloonText: "[[description]]: <b>[[value]]</b>",
			balloonText: "sessions: <b>[[value]]</b>",
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
    });
</script>