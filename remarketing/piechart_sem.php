<script type="text/javascript">
	
	var sum_impression = <?php //echo $sum_impression; ?> <?php echo empty($sum_impression) ? '0' : $sum_impression; ?>;
	var sum_adClicks = <?php echo empty($sum_adClicks) ? '0' : $sum_adClicks; ?>;
	var sum_totalEvent = <?php echo empty($sum_TotalEvent) ? '0' : $sum_TotalEvent; ?>;
	var sum_totalCall = <?php echo empty($sum_total_call) ? '0' : $sum_total_call; ?>;
	var sum_callClickRatio = <?php echo empty($sum_call_click_ratio) ? '0' : $sum_call_click_ratio; ?>;
	var customer_engagement = <?php echo round($sum_TotalEvent / $sum_adClicks * 100); ?>;
	var over_ce = 100 - customer_engagement;
	
AmCharts.makeChart("ImpressionsChart",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"innerRadius": "90%",
			"balloonText": "",
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
			<?php if($sum_impression == 0){ echo '"colors": ["#e6e6e6","#e6e6e6"],';}else{ echo '"colors": ["#61c482","#e6e6e6"],';}?>
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "title",
			"valueField": "value",
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
					"title": "Impressions",
					"value": <?php if($sum_impression == 0){ echo 100;}else{?> sum_impression <?php }?>
				}
			]
		}
	),
AmCharts.makeChart("ClicksChart",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"innerRadius": "90%",
			"balloonText": "",
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
			<?php if($sum_adClicks == 0){ echo '"colors": ["#e6e6e6","#e6e6e6"],';}else{ echo '"colors": ["#e95b5b","#e6e6e6"],';}?>
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "title",
			"valueField": "value",
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
					"title": "Clicks",
					"value": <?php if($sum_adClicks == 0){ echo 100;}else{?> sum_adClicks <?php }?>
				}
			]
		}
	),
AmCharts.makeChart("EventsChart",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"innerRadius": "90%",
			"balloonText": "",
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
			<?php if($sum_TotalEvent == 0){ echo '"colors": ["#e6e6e6","#e6e6e6"],';}else{ echo '"colors": ["#3c84da","#e6e6e6"],';}?>
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "title",
			"valueField": "value",
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
					"title": "Clicks",
					"value": <?php if($sum_TotalEvent == 0){ echo 100;}else{?> sum_totalEvent <?php }?>
				}
			]
		}
	),
AmCharts.makeChart("CallsChart",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"innerRadius": "90%",
			"balloonText": "",
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
			<?php if($sum_total_call == 0){ echo '"colors": ["#e6e6e6","#e6e6e6"],';}else{ echo '"colors": ["#e479c7","#e6e6e6"],';}?>
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "title",
			"valueField": "value",
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
					"title": "Calls",
					"value": <?php if($sum_total_call == 0){ echo 100;}else{?> sum_totalCall <?php }?>
				}
			]
		}
	),
AmCharts.makeChart("RatiosChart",
		{
			"type": "pie",
			"pathToImages": "charts/images/",
			"innerRadius": "90%",
			"balloonText": "",
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
				"#40d3cb",
				"#e6e6e6"
			],
			"labelTickAlpha": 0,
			"maxLabelWidth": 214,
			"outlineThickness": 7,
			"pullOutOnlyOne": true,
			"startDuration": 2,
			"titleField": "title",
			"valueField": "value",
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
					"title": "Customer Engagement",
					"value": customer_engagement
				},
				{
					"title": "Customer Engagement",
					"value": over_ce
				}
			]
		}
	);

</script>