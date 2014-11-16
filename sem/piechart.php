<script type="text/javascript">

	var visits = '<?php echo $total_count; ?>';
	var total_visits = '<?php echo $total_ga_visits; ?>';
	var bounce_rate = '<?php echo $avg_ga_bounce; ?>';
	var page_views = '<?php echo $avg_ga_pageviews_day; ?>';
	var page_views_per_day = '<?php echo $avg_ga_pageviews_day; ?>';
	var ave_time = '<?php echo $avg_ga_avgSessionDuration_h_i_s; ?>';
	var total_visitors = parseInt(visits) + parseInt(total_visits);
	var desktop_user = <?php echo round($total_device_count[0]*100/$total_val); ?>;
	var mobile_user = <?php echo round($total_device_count[1]*100/$total_val); ?>;
	var tablet_user = <?php echo round($total_device_count[2]*100/$total_val); ?>;
	var desktop_second_value = 100 - parseInt(desktop_user);
	var mobile_second_value = 100 - parseInt(mobile_user);
	var tablet_second_value = 100 - parseInt(tablet_user);
	var bounce_second_value = 100 - parseInt(bounce_rate);
	var visits_value = total_visitors - parseInt(visits);

AmCharts.makeChart("VisitorsChart",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#e95b5b",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				
				{
					"Call": "Visits",
					"Number": visits
				},
				{
					"Call": "New Visitors",
					"Number": visits_value 
				}
			]
		}
	),
	AmCharts.makeChart("BounceRateChart",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#edca00",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				
				{
					"Call": "Rate",
					"Number": bounce_second_value
				}
				,{
					"Call": "Bounce Rate",
					"Number": bounce_rate 
				}
			]
		}
	),
	AmCharts.makeChart("TotalVisits",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#60c481",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				{
					"Call": "Total Visits",
					"Number": total_visitors 
				}
			]
		}
	),
	AmCharts.makeChart("PageViews",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#2c84e2",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				{
					"Call": "Page Views",
					"Number": page_views 
				}
				
			]
		}
	),
	AmCharts.makeChart("AvePageViews",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#e6a31d",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				{
					"Call": "Page Views Per Day",
					"Number": page_views_per_day 
				}
			]
		}
	)
	AmCharts.makeChart("AveTime",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#e6e6e6",
				"#de6ec4"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				{
					"Call": "Ave Time",
					"Number": ave_time 
				},
				{
					"Call": "Views",
					"Number": 100 
				}
			]
		}
	),
AmCharts.makeChart("desktop",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#e95b5b",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				{
					"Call": "Desktop User",
					"Number": desktop_user
				},
				{
					"Call": "Desktop User",
					"Number": desktop_second_value
				}
			]
		}
	),
AmCharts.makeChart("mobile",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#67ba80",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": true
			},
			"titles": [],
			"dataProvider": [
				{
					"Call": "Mobile User",
					"Number": parseInt(mobile_user) 
				},
				{
					"Call": "Mobile User",
					"Number": mobile_second_value
				}
			]
		}
	),
AmCharts.makeChart("tablet",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"balloonText": "",
			"innerRadius": "90%",
			"labelRadius": 17,
			"labelRadiusField": "Number",
			"labelText": "",
			"minRadius": 8,
			"pullOutRadius": "0%",
			"radius": 50,
			"startRadius": "0%",
			"baseColor": "",
			"brightnessStep": 163.2,
			"colorField": "Not set",
			"colors": [
				"#edca00",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "Not set",
			"valueField": "Number",
			"creditsPosition": "bottom-right",
			"fontFamily": "Arial",
			"fontSize": 10,
			"theme": "default",
			"allLabels": [
				{
					"align": "center",
					"id": "Value",
					"size": 46,
					"text": "",
					"x": "0",
					"y": "22%"
				}
			],
			"balloon": {
				"animationDuration": 0.06,
				"fadeOutDuration": 0.18,
				"fixedPosition": false
			},
			"titles": [],
			"dataProvider": [
				{
					"Call": "Mobile User",
					"Number": parseInt(tablet_user) 
				},
				{
					"Call": "Mobile User",
					"Number": tablet_second_value
				}
			]
		}
	);

</script>