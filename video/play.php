<?php 
ob_start();
require('./includes/header1.php');

if(isset($_GET['video_key']) && $_GET['video_key']!=''){ 
    $videoKey = $_GET['video_key'];
}else{
    header('location:'.URL_SITE);
}
$videoArr = $objectApi->call("/videos/views/list",array('search'=>$videoKey));

if($videoArr['total']>0){
    $singlevideoArr = $videoArr['videos'][0];
}else{
    $singlevideoArr =array('pageviews'=>'0','views'=>'0','viewed'=>'0');
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <!-- BC_OBNW -->
    <head>
        <script type="text/javascript">var jslang='EN';</script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="/video/charts/amcharts.js" type="text/javascript"></script>
        <script src="/video/charts/themes/light.js" type="text/javascript"></script>
        <script src="/video/charts/pie.js" type="text/javascript"></script>
        <script src="/video/charts/serial.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <!--<script src="https://code.jquery.com/jquery-1.9.1.js"></script>-->
        <style type="text/css">
            .hd-labl {
                margin-left: 13px;
            }
            .btn-search-inner {
                float:none !important;
            }
        </style>
		<style>
            .icons {
				background: url("images/videos-icon.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
				height: 42px;
				left: 45%;
				position: absolute;
				top: -2%;
				width: 42px;
        	}
			.content1{}
			.content2{background-position: 0 141px;}
			.content3{background-position: 0 91px;}
			.content4{background-position: 0 42px;}
		
		@media only screen and (min-device-width:1280px) and (max-device-width:1366px){
            .icons {
				background: url("images/videos-icon.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
				height: 42px;
				left: 40%;
				position: absolute;
				top: -3%;
				width: 42px;
        	}
			.content1{}
			.content2{background-position: 0 141px;}
			.content3{background-position: 0 91px;}
			.content4{background-position: 0 42px;}
		}		
        </style>        
    </head>   
    <body>
        <div class="container-fluid">   
            <div class="chart-box">
                <div class="doughnut_charts">
                    <div class="doughnut_items_wrap">
                        
                        <div class="total_call_wrap doughtnut">
                            <div id="chartPageViews" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                            <div class="doughnut-img-wrap"><div class="icons content1"></div></div>
                            <span class="hideIfNotLoaded item_details"><?php echo $singlevideoArr['pageviews']?></span>
                            <h5>Pageviews</h5>
                            <p>A pageview is counted every time a player with the video loads (the video may not get viewed).</p>
                        </div>
                        <div class="total_call_wrap doughtnut">
                            <div id="chartViews" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                            <div class="doughnut-img-wrap"><div class="icons content2"></div></div>
                            <span class="hideIfNotLoaded item_details"><?php echo $singlevideoArr['views']?></span>
                            <h5>Views</h5>
                            <p>A view is counted every time a video is streamed in a player or directly downloaded</p>
                        </div>
                        <div class="total_call_wrap doughtnut">
                            <div id="chartWatchRatio" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                            <div class="doughnut-img-wrap"><div class="icons content3"></div></div>
                            <span class="hideIfNotLoaded item_details">
                            <?php
                            $a = $singlevideoArr['views'];
                            $b = $singlevideoArr['pageviews'];
                            $c = ($a / $b) * 100;
                            echo round($c,0);
                            ?>%
                            </span>
                            <h5>View to Watch Ratio</h5>
                            <p>The percentage of people that visited the page who watched the video</p>
                        </div>
                        <div class="total_call_wrap doughtnut">
                            <div id="chartTimeViewed" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                            <div class="doughnut-img-wrap"><div class="icons content4"></div></div>
                            <span class="hideIfNotLoaded item_details"><?php echo '00:' ?><?php echo @date('i:s',$singlevideoArr['viewed'])?></span>
                            <h5>Time Viewed</h5>
                            <p>This the total time that users spent watching your video(s). It shows how sticky your content is.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <ul class="page_views">
                <li>
                    <h5>Views</h5>
                    <div id="circVideoViews" class="c100">
                        <span></span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                    <p>A view is counted every time a video is streamed in a player or directly downloaded.</p>
                </li>
                
                
                <li>
                    <h5>Pageviews</h5>
                    <div id="circPageViews" class="c100">
                        <span></span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                    <p>A pageview is counted every time a player with the video loads (the video may not get viewed).</p>
                </li>
                
                
                <li>
                    <h5>Time Viewed</h5>
                    <div id="circTimeView" class="c100 blue">
                        <span></span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                    <p>This the total time that users spent watching your video(s). It shows how sticky your content is.</p>
                </li>
            </ul>
            -->
        </div>	
        <div class="container-fluid"> 		 
            <div class="table-responsive">  
                
                <center>
                    <iframe src="//content.jwplatform.com/players/<?php echo $videoKey?>-ALJ3XQCI.html" width="480" height="294" frameborder="0" scrolling="auto"></iframe>
                </center>
                
                
                
            </div>
        </div>
        
        
        <script type="text/javascript">
            $(document).ready(function(){
                var watchRatio = <?php
                            $a = $singlevideoArr['views'];
                            $b = $singlevideoArr['pageviews'];
                            $c = ($a / $b) * 100;
							$d = $singlevideoArr['pageviews'] - $singlevideoArr['views'];
                            echo round($c,0);
                            ?>;
                var views = <?php echo $singlevideoArr['views']; ?>;
				var pageviews = <?php echo $d; ?>;

				
                var watchRatioLeft = 100 - watchRatio;
                
                
                $('#videolisting').addClass('active');
                initVideoViews();
                initPageViews();
                initTimeViews();
                
                
                AmCharts.makeChart("chartViews", {
                    "type": "pie",
                    "pathToImages": "https://server.cbo.me/video/charts/images/",
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
                        "#3586d5",
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
                    "allLabels": [ {
                        "align": "center",
                        "id": "Value",
                        "size": 46,
                        "text": "",
                        "x": "0",
                        "y": "22%"
                    } ],
                    "balloon": {
                        "animationDuration": 0.06,
                        "fadeOutDuration": 0.18,
                        "fixedPosition": true
                    },
                    "titles": [],
                    "dataProvider": [ {
                        "Call": "Views",
                        "Number": 100
                    }, {
                        "Call": "Views",
                        "Number": 0
                    }]
                });
                
                AmCharts.makeChart("chartPageViews", {
                    "type": "pie",
                    "pathToImages": "https://server.cbo.me/video/charts/images/",
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
                        "#67c586",
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
                    "allLabels": [ {
                        "align": "center",
                        "id": "Value",
                        "size": 46,
                        "text": "",
                        "x": "0",
                        "y": "22%"
                    } ],
                    "balloon": {
                        "animationDuration": 0.06,
                        "fadeOutDuration": 0.18,
                        "fixedPosition": true
                    },
                    "titles": [],
                    "dataProvider": [ {
                        "Call": "Views",
                        "Number": views
                    }, {
                        "Call": "Page Views",
                        "Number": pageviews
                    }]
                });
                
                AmCharts.makeChart("chartWatchRatio", {
                    "type": "pie",
                    "pathToImages": "https://server.cbo.me/video/charts/images/",
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
                        "#f2c83e",
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
                    "allLabels": [ {
                        "align": "center",
                        "id": "Value",
                        "size": 46,
                        "text": "",
                        "x": "0",
                        "y": "22%"
                    } ],
                    "balloon": {
                        "animationDuration": 0.06,
                        "fadeOutDuration": 0.18,
                        "fixedPosition": true
                    },
                    "titles": [],
                    "dataProvider": [ {
                        "Call": "Watch Ratio",
                        "Number": watchRatio
                    }, {
                        "Call": "Watch Ratio",
                        "Number": watchRatioLeft
                    }]
                });
                
                AmCharts.makeChart("chartTimeViewed", {
                    "type": "pie",
                    "pathToImages": "https://server.cbo.me/video/charts/images/",
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
                        "#eb5e57",
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
                    "allLabels": [ {
                        "align": "center",
                        "id": "Value",
                        "size": 46,
                        "text": "",
                        "x": "0",
                        "y": "22%"
                    } ],
                    "balloon": {
                        "animationDuration": 0.06,
                        "fadeOutDuration": 0.18,
                        "fixedPosition": true
                    },
                    "titles": [],
                    "dataProvider": [ {
                        "Call": "Time Viewed",
                        "Number": 100
                    }, {
                        "Call": "Time Viewed",
                        "Number": 0
                    }]
                });
            });
            
            function initVideoViews() {
                var x = parseInt($.trim($("#circVideoViews span").html()));
                if(x <= 100) {
                    $("#circVideoViews").addClass("p"+x);
                } else {
                    $("#circVideoViews").addClass("p100");
                }
            }
            
            function initPageViews() {
                var x = parseInt($.trim($("#circPageViews span").html()));
                if(x <= 100) {
                    $("#circPageViews").addClass("p"+x);
                } else {
                    $("#circPageViews").addClass("p100");
                }
            }
            
            function initTimeViews() {
                var x = $.trim($("#circTimeView span").html()).split(":");
                var xHour = parseInt(x[0]) * 60;
                var xMin = parseInt(x[1]);
                var xSec = parseInt(x[2]);
                var xTotal = xHour + xMin;
                console.log("Total minutes and seconds played: " + xTotal + " minutes and " + xSec + " seconds");
                if(xTotal <= 100) {
                    $("#circTimeView").addClass("p"+xTotal);
                }
            }
        </script>
        
    </body>
</html>

