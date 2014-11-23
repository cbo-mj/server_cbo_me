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
            colors: [ "#ec615e", "#ec615e" ],
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
                Number: <?php echo $prospect; ?>
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
            colors: [ "#ffc60d", "#e6e6e6" ],
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
                Number: <?php echo $leads; ?>
            },{
				Call: "N",
				Number: <?php echo $non_bilable_leads; ?>
			} ]
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
            colors: [ "#eb77c8", "#e6e6e6" ],
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
				Number: <?php echo $leads; ?>
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
            colors: [ "#ee9311", "#ee9311" ],
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