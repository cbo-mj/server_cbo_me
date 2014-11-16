<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body class="hybrid" style="overflow-x:hidden;">

<?php include('head_include1.php'); ?>
                        
                      	<?php 
							//echo '<pre>';
								//print_r($_GET);
							//echo '</pre>';
						?>
                        <script type="text/javascript">
							var chart = AmCharts.makeChart("chartfunnel", {
							"type": "funnel",
							"theme": "none",
							<?php 
								$funnel_arr = array();
								$impression = number_format($_GET['impression']);
								$click = number_format($_GET['click']);
								$event = number_format($_GET['event']);
								$calls = number_format($_GET['calls']);

								$funnel_arr[] = "{\"title\": \" Impressions\",\"value\":'180',\"number\":'{$impression}'},{\"title\": \" Clicks\",\"value\":'130',\"number\":'{$click}'},{\"title\": \" Events\",\"value\":'80',\"number\":'{$event}'},{\"title\": \" Forms / Calls\",\"value\":'50',\"number\":'{$calls}'}";

								$f_funnel = implode(",",$funnel_arr);							
							?>
							
							
							<?php 
								//$funnel_arr = array();
								//foreach ($impression as $key => $impression_value) {
									//$iv = number_format($impression_value);
									//$click = number_format($click[$key]);
									//$event = number_format($event[$key]);
						//			//echo    $impression_value." : ".$click[$key]." : ".$event[$i]."</br>" ;
						//			//$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'{$impression_value}'},{\"title\": \"Click\",\"value\":'{$click[$key]}'},{\"title\": \"Event\",\"value\":'{$event[$key]}'}";
									//$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'210',\"number\":'{$iv}'},{\"title\": \"Click\",\"value\":'200',\"number\":'{$click}'},{\"title\": \"Event\",\"value\":'150',\"number\":'{$event}'}";
						//			$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'6'},{\"title\": \"Click\",\"value\":'9'},{\"title\": \"Event\",\"value\":'13'}";
								//}
						//		
								//$f_funnel = implode(",",$funnel_arr);
						?>
						
							"dataProvider": [<?php echo $f_funnel; ?>],
							"balloon": {
								"fixedPosition": true
							},
							"valueField": "value",
							"titleField": "title",
							"marginRight": 240,
							"marginLeft": 50,
							"startX": -500,
							"depth3D": 40,
							"angle": 40,
								"colors": [
									"#ce0c00",
									"#d15807",
									"#f19401",
									"#02860e"
								],
							"outlineAlpha": 1,
							"labelText": "[[title]]: [[number]]",
							"sequencedAnimation": false,
							"startDuration": 0,
							"outlineColor": "#FFFFFF",
							"outlineThickness": 2,
							"labelPosition": "right",
							"balloonText": "[[title]]: [[number]]",
							"exportConfig": {
								"menuItems": [{
									"icon": '/lib/3/images/export.png',
									"format": 'png'
								}]
							}
						});

                        </script>
                        <style>
                        #chartfunnel {width: 100%; height: 435px;font-size: 11px; float:right; clear:both;}	
                        </style>
						<div id="chartfunnel"></div>
                            <!--<div style="clear:both">
                            	<iframe src="test_debug.php" width="100%" height="480"></iframe>
                            </div>-->                            

</body>
</html>