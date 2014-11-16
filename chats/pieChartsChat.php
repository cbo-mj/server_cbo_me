<?php 
	$str = $session_time;
	list($hour, $minute, $second) = explode(":", $str);
	
	$std = $hour.$minute.$second;
?>
<script type="text/javascript">
	AmCharts.makeChart("prospects", {
            type: "pie",
            pathToImages: "https://server.cbo.me/calls/charts/images/",
            balloonText: "",
            innerRadius: "90%",
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
			<?php if($prospect == 0){echo 'colors: [ "#e6e6e6", "#e6e6e6" ],';}else{echo 'colors: [ "#ec615e", "#e6e6e6" ],';} ?>
            labelTickAlpha: 0,
            maxLabelWidth: 214,
            outlineThickness: 7,
            pullOutOnlyOne: !0,
            startDuration: 2,
            titleField: "Not set",
            valueField: "Number",
            creditsPosition: "bottom-right",
            fontFamily: "Arial",
            fontSize: 10,
            theme: "default",
            allLabels: [ {
                align: "center",
                id: "Value",
                size: 46,
                text: "",
                x: "0",
                y: "22%"
            } ],
            balloon: {
                animationDuration: .06,
                fadeOutDuration: .18,
                fixedPosition: !0
            },
            titles: [],
            dataProvider: [ {
                Call: "Total Calls",
                Number: <?php if($prospect == 0){echo 100;}else{echo $prospect;} ?>
            } ]
        }),
	AmCharts.makeChart("leads", {
            type: "pie",
            pathToImages: "https://server.cbo.me/calls/charts/images/",
            balloonText: "",
            innerRadius: "90%",
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
            <?php if($leads == 0){echo 'colors: [ "#e6e6e6", "#e6e6e6" ],';}else{echo 'colors: [ "#ffc60d", "#e6e6e6" ],';} ?>
            labelTickAlpha: 0,
            maxLabelWidth: 214,
            outlineThickness: 7,
            pullOutOnlyOne: !0,
            startDuration: 2,
            titleField: "Not set",
            valueField: "Number",
            creditsPosition: "bottom-right",
            fontFamily: "Arial",
            fontSize: 10,
            theme: "default",
            allLabels: [ {
                align: "center",
                id: "Value",
                size: 46,
                text: "",
                x: "0",
                y: "22%"
            } ],
            balloon: {
                animationDuration: .06,
                fadeOutDuration: .18,
                fixedPosition: !0
            },
            titles: [],
			<?php if($leads == 0 && $non_bilable_leads == 0){ echo 'dataProvider: [ {
                Call: "Total Calls",
                Number: 100
            } ]';}else{ echo 'dataProvider: [ {
                Call: "Total Calls",
                Number: '.$leads.'
            },{
				Call: "N",
				Number: '.$non_bilable_leads.'
			} ]';} ?>
        }),
	AmCharts.makeChart("leadPercentage", {
            type: "pie",
            pathToImages: "https://server.cbo.me/calls/charts/images/",
            balloonText: "",
            innerRadius: "90%",
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
            colors: [ "#62c479", "#e6e6e6" ],
            labelTickAlpha: 0,
            maxLabelWidth: 214,
            outlineThickness: 7,
            pullOutOnlyOne: !0,
            startDuration: 2,
            titleField: "Not set",
            valueField: "Number",
            creditsPosition: "bottom-right",
            fontFamily: "Arial",
            fontSize: 10,
            theme: "default",
            allLabels: [ {
                align: "center",
                id: "Value",
                size: 46,
                text: "",
                x: "0",
                y: "22%"
            } ],
            balloon: {
                animationDuration: .06,
                fadeOutDuration: .18,
                fixedPosition: !0
            },
            titles: [],
            dataProvider: [ {
                Call: "Total Calls",
                Number: <?php echo $lead_perc; ?>
            },{
				Call: "N",
				Number: <?php echo $n = 100 - $lead_perc; ?>
			} ]
        }),
	AmCharts.makeChart("nonbillable", {
            type: "pie",
            pathToImages: "https://server.cbo.me/calls/charts/images/",
            balloonText: "",
            innerRadius: "90%",
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
			<?php if($non_bilable_leads == 0){echo 'colors: [ "#e6e6e6", "#e6e6e6" ],';}else{echo 'colors: [ "#eb77c8", "#e6e6e6" ],';} ?>
            labelTickAlpha: 0,
            maxLabelWidth: 214,
            outlineThickness: 7,
            pullOutOnlyOne: !0,
            startDuration: 2,
            titleField: "Not set",
            valueField: "Number",
            creditsPosition: "bottom-right",
            fontFamily: "Arial",
            fontSize: 10,
            theme: "default",
            allLabels: [ {
                align: "center",
                id: "Value",
                size: 46,
                text: "",
                x: "0",
                y: "22%"
            } ],
            balloon: {
                animationDuration: .06,
                fadeOutDuration: .18,
                fixedPosition: !0
            },
            titles: [],
            dataProvider: [ {
                Call: "Total Calls",
                Number: <?php echo $non_bilable_leads; ?>
            },
			{
				Call: "Calls",
				Number: <?php if($non_bilable_leads == 0){ echo 100; }else{echo $leads;} ?>
			} ]
        }),
AmCharts.makeChart("sessionTime", {
            type: "pie",
            pathToImages: "https://server.cbo.me/calls/charts/images/",
            balloonText: "",
            innerRadius: "90%",
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
            
			<?php if($std == 0 || $std == ''){ echo 'colors: [ "#e6e6e6", "#e6e6e6" ],';}else{ echo 'colors: [ "#ee9311", "#ee9311" ],';} ?>
            labelTickAlpha: 0,
            maxLabelWidth: 214,
            outlineThickness: 7,
            pullOutOnlyOne: !0,
            startDuration: 2,
            titleField: "Not set",
            valueField: "Number",
            creditsPosition: "bottom-right",
            fontFamily: "Arial",
            fontSize: 10,
            theme: "default",
            allLabels: [ {
                align: "center",
                id: "Value",
                size: 45,
                text: "",
                x: "0",
                y: "22%"
            } ],
            balloon: {
                animationDuration: .06,
                fadeOutDuration: .18,
                fixedPosition: !0
            },
            titles: [],
            dataProvider: [ {
                Call: "Average Call Duration",
                Number: 100
            }, {
                Call: "",
                Number: 0
            } ]
        });		

</script>