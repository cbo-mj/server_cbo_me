<script type="text/javascript"> 
var visits = '<?php echo empty($total_count) ? '0' : $total_count; ?>'; 
var total_visits = '<?php echo empty($total_ga_visits) ? '0' : $total_ga_visits; ?>';  
var bounce_rate = '<?php echo empty($avg_ga_bounce) ? '0' : $avg_ga_bounce; ?>'; 
var page_views = '<?php echo empty($avg_ga_pageviews_day) ? '0' : $avg_ga_pageviews_day; ?>'; 
var page_views_per_day = '<?php echo empty($avg_ga_pageviews_day) ? '0' : $avg_ga_pageviews_day; ?>'; 
<?php 
	$std = $avg_ga_avgSessionDuration_h_i_s;
	list($hour, $minute, $second) = explode(":", $std);
	$std = $hour.$minute.$second;
?>
var ave_time = '<?php echo $ave_time = empty($avg_ga_avgSessionDuration_h_i_s) ? '0' : $avg_ga_avgSessionDuration_h_i_s; ?>'; 

var total_visitors = parseInt(visits) + parseInt(total_visits); 
<?php $total_visitors = $total_count + $total_ga_visits; ?>
var desktop_user = <?php echo $desktop_user = round($total_device_count[0]*100/$total_val); ?>; 
var mobile_user = <?php echo $mobile_user = round($total_device_count[1]*100/$total_val); ?>; 
var tablet_user = <?php echo $tablet_user = round($total_device_count[2]*100/$total_val); ?>; 
var desktop_second_value = 100 - parseInt(desktop_user); 
var mobile_second_value = 100 - parseInt(mobile_user); 
var tablet_second_value = 100 - parseInt(tablet_user); 
var bounce_second_value = 100 - parseInt(bounce_rate); 
var visits_value = total_visitors - parseInt(visits);

<?php $visits_value = $total_visitors - $total_count; ?>

AmCharts.makeChart("VisitorsChart", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
    <?php if($total_count == 0 && $visits_value == 0 || $total_count == '' && $visits_value == ''){ echo 'colors: ["#e6e6e6", "#e6e6e6"],'; }else{ echo 'colors: ["#e95b5b", "#e6e6e6"],'; }?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
    dataProvider: [{
        title: "New Visitors",
        value: <?php if($total_count == 0 && $visits_value == 0){ echo 0; }else{?> visits <?php }?>
    }, {
        title: "Visits",
        value:  <?php if($total_count == 0 && $visits_value == 0){ echo 100; }else{?> visits_value <?php }?>
    }]
}), AmCharts.makeChart("BounceRateChart", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if($avg_ga_bounce == 0){ echo 'colors: ["#e6e6e6", "#e6e6e6"],'; }else{ echo 'colors: ["#edca00", "#e6e6e6"],'; } ?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
	<?php if($avg_ga_bounce == 0){ echo 'dataProvider:[{ title: "Bounce Rate", value: 100 }]'; }else{ echo 'dataProvider: [{
        title: "Rate",
        value: bounce_second_value
    }, {
        title: "Bounce Rate",
        value: bounce_rate
    }]'; } ?>
}), AmCharts.makeChart("TotalVisits", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
    <?php if($total_visitors == 0){ echo 'colors: ["#e6e6e6", "#60c481"],';}else{ echo 'colors: ["#60c481", "#e6e6e6"],'; } ?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
    dataProvider: [{
        title: "Total Visits",
        value: <?php if($total_visitors == 0){ echo 100;}else{ echo $total_visitors; } ?>
    }]
}), AmCharts.makeChart("PageViews", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if($avg_ga_pageviews_day == 0){ echo 'colors: ["#e6e6e6", "#2c84e2"],';}else{ echo 'colors: ["#2c84e2", "#e6e6e6"],'; } ?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
    dataProvider: [{
        title: "Page Views",
        value: <?php if($avg_ga_pageviews_day == 0){ echo 100;}else{ echo $avg_ga_pageviews_day; } ?>
    }]
}), AmCharts.makeChart("AvePageViews", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if($avg_ga_pageviews_day == 0){ echo 'colors: ["#e6e6e6", "#e6e6e6"],';}else{ echo 'colors: ["#e6a31d", "#e6e6e6"],'; } ?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 8,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
    dataProvider: [{
        title: "Avg Page Viewed",
        value: <?php if($avg_ga_pageviews_day == 0){ echo 100;}else{ echo $avg_ga_pageviews_day; } ?>
    }]
}), AmCharts.makeChart("AveTime", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	<?php if($std != 0){ echo 'colors: ["#de6ec4", "#e6e6e6"],'; }else{ echo 'colors: ["#e6e6e6", "#e6e6e6"],'; } ?>
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
	<?php if($std != 0){ echo 'dataProvider: [{
        title: "Ave Time",
        value: 100}, {
        title: "Views",
        value: 0
    }]'; }else{ echo 'dataProvider:[{ title: "Ave Time", value: 100 }]'; } ?>
    
}), AmCharts.makeChart("desktop", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
	colors: ["#e95b5b", "#e6e6e6"],
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
	dataProvider: [{
        title: "Desktop User",
        value: desktop_user
    }, {
        title: "Others",
        value: desktop_second_value
    }]	

}), AmCharts.makeChart("mobile", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
    colors: ["#67ba80", "#e6e6e6"],
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !0
    },
    titles: [],
    dataProvider: [{
        title: "Mobile User",
        value: parseInt(mobile_user)
    }, {
        title: "Others",
        value: mobile_second_value
    }]
}), AmCharts.makeChart("tablet", {
    type: "pie",
    pathToImages: "charts/images/",
    innerRadius: "90%",
    balloonText: "",
    labelRadius: 17,
    labelRadiusField: "Number",
    labelText: "",
    minRadius: 8,
    pullOutRadius: "0%",
    radius: 50,
    startRadius: "0%",
    baseColor: "",
    brightnessStep: 163.2,
    colorField: "Not set",
    colors: ["#edca00", "#e6e6e6"],
    labelTickAlpha: 0,
    maxLabelWidth: 214,
    outlineThickness: 7,
    pullOutOnlyOne: !0,
    startDuration: 2,
    titleField: "title",
    valueField: "value",
    creditsPosition: "bottom-right",
    fontFamily: "Arial",
    fontSize: 10,
    theme: "default",
    allLabels: [{
        align: "center",
        id: "Value",
        size: 46,
        text: "",
        x: "0",
        y: "22%"
    }],
    balloon: {
        animationDuration: .06,
        fadeOutDuration: .18,
        fixedPosition: !1
    },
    titles: [],
    dataProvider: [{
        title: "Tablet User",
        value: parseInt(tablet_user)
    }, {
        title: "Others",
        value: tablet_second_value
    }]
});</script>