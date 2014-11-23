function check_date_range2(e) {
    var a = e;
    a = a.replace(/[\. ,:-_]+/g, " ");
    var t = $("#nav"),
        l = $(".select");
    "date_range" == e ? ($("#date_picker_holder").show(), $("#specific_field").val(e), $("#nav").text(a), $(".date_range").addClass("activeClass"), $(".menu_container").css("width", "220"), $(".menu_container").css("width", "+=360"), t.hasClass("active") ? (t.removeClass("active"), l.stop().slideUp(200)) : (t.addClass("active"), l.stop().slideDown(200)), $("#date_range").show()) : ($("#date_picker_holder").hide(), $("#specific_field").val(e), $("#nav").text(a), $(".date_range").removeClass("activeClass"), $(".menu_container").css("width", "220"), $("#date_range").hide())
}

function check_date_range(a) {
    "date_range" == a ? $("#date_range").show() : $("#date_range").hide();
}

function play_audio(a, b, c, d) {
    player = '<audio controls id="' + b + '"><source src="' + c + '" type="audio/wav">Your browser does not support the audio element. </audio>', 
    $("#" + a).html(player), $("#" + d).hide();
}

function close_open_model(a, b, c) {
    var d = "." + c;
    jQuery(d).colorbox({
        inline: !0,
        width: "60%"
    });
}

function close_open_model2(a) {
    var d = "." + c;
    jQuery(d).colorbox({
        inline: !0,
        width: "60%"
    });
}

$(document).ready(function(){
	//Examples of how to assign the Colorbox event to elements
	$(".inline").colorbox({inline:true, width:"50%"});
});

$(document).on("change", "#datepickerdivfrom", function() {
    $("#from").val($(this).val())
}), $(document).on("change", "#datepickerdivto", function() {
    $("#to").val($(this).val())
}),
$(document).ready(function() {
    $("#datepickerdivfrom").datepicker({
        dateFormat: "yy-mm-dd"
    }), $("#datepickerdivto").datepicker({
        dateFormat: "yy-mm-dd"
    }),
    $("#from").datepicker({
        changeMonth: !0,
        changeYear: !0,
        dateFormat: "yy-mm-dd"
    }), $("#to").datepicker({
        changeMonth: !0,
        changeYear: !0,
        dateFormat: "yy-mm-dd"
    });
}), jQuery(function() {
    function a() {
        $("#call_tracking_record").DataTable({
            paginate: !0,
            sort: !1
        });
        jQuery("#call_tracking_record").promise().done(function() {
            var a = "";
            jQuery("#call_tracking_record_length select option").each(function() {
                a += '<option value="' + jQuery(this).attr("value") + '">' + jQuery(this).attr("value") + "</option>";
            });
            var b = '<div class="tbl_foot_rec_length"><label>Page size:</label> <select id="dummy_rec_length">' + a + "</select></div>";
            jQuery(b).insertAfter(jQuery("#call_tracking_record_paginate")), jQuery("#call_tracking_record").nextAll().wrapAll("<div class='foot_wrap' />");
            var c = '<h4 class="head_title">Video List</h4>';
            jQuery(c).insertAfter(jQuery(".dataTables_filter"));
        });
    }
    function b() {
        var a = new Array(), b = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ], c = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ], d = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ], e = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
        jQuery("#call_tracking_record tbody tr").each(function() {
            var f = jQuery(this).find(".date_data").text().split(" - "), g = f[0].split("'");
            if (-1 == jQuery.inArray(g[1], a)) {
                a.push(g[1]);
                for (var h = 0; 11 >= h; h++) 79 == g[0].indexOf(e[h]) && (b[h] += 1);
            } else for (var h = 0; 11 >= h; h++) 79 == g[0].indexOf(e[h]) && (b[h] += 1);
            if (console.log(a.length), "Abandoned" == jQuery(this).find(".call_data").text()) for (var i = 0; 11 >= i; i++) 79 == jQuery(this).find(".date_data").text().indexOf(e[i]) && (c[i] += 1);
            if ("Answered" == jQuery(this).find(".call_data").text()) for (var j = 0; 11 >= j; j++) 79 == jQuery(this).find(".date_data").text().indexOf(e[j]) && (d[j] += 1);
        }), 
		AmCharts.makeChart("linechartdiv", {
			
            type: "serial",
            pathToImages: "https://server.cbo.me/calls/charts/images/",
            categoryField: "date",
            dataDateFormat: "YYYY-MM",
            colors: [ "#ff1b41", "#1a9bef", "#62c479" ],
            theme: "light",
            categoryAxis: {
                minPeriod: "MM",
                parseDates: !0
            },
            chartCursor: {
                animationDuration: .1,
                bulletSize: 15,
                categoryBalloonDateFormat: "MMM YYYY"
            },
            chartScrollbar: {},
            trendLines: [],
            graphs: [ {
                bullet: "round",
                cornerRadiusTop: -3,
                dashLength: -5,
                id: "Missed Calls",
                title: "Missed Calls",
                type: "smoothedLine",
                valueField: "Missed"
            }, {
                bullet: "diamond",
                bulletBorderThickness: 0,
                columnWidth: 0,
                id: "Total Calls",
                markerType: "none",
                negativeBase: -7,
                title: "Total Calls",
                type: "smoothedLine",
                valueField: "Total"
            }, {
                bullet: "square",
                id: "Answered Calls",
                title: "Answered Calls",
                type: "smoothedLine",
                valueField: "Answered"
            } ],
            guides: [],
            valueAxes: [],
            allLabels: [],
            balloon: {},
            legend: {
                align: "center",
                marginLeft: 10,
                markerSize: 14,
                rollOverGraphAlpha: .35,
                useGraphSettings: !0,
                valueAlign: "left",
                valueWidth: 44
            },
            titles: [],
            dataProvider: [ {
                date: "2014-01",
                Missed: c[0],
                Total: b[0],
                Answered: d[0]
            }, {
                date: "2014-02",
                Missed: c[1],
                Total: b[1],
                Answered: d[1]
            }, {
                date: "2014-03",
                Missed: c[2],
                Total: b[2],
                Answered: d[2]
            }, {
                date: "2014-04",
                Missed: c[3],
                Total: b[3],
                Answered: d[3]
            }, {
                date: "2014-05",
                Missed: c[4],
                Total: b[4],
                Answered: d[4]
            }, {
                date: "2014-06",
                Missed: c[5],
                Total: b[5],
                Answered: d[5]
            }, {
                date: "2014-07",
                Missed: c[6],
                Total: b[6],
                Answered: d[6]
            }, {
                date: "2014-08",
                Missed: c[7],
                Total: b[7],
                Answered: d[7]
            }, {
                date: "2014-09",
                Missed: c[8],
                Total: b[8],
                Answered: d[8]
            }, {
                date: "2014-10",
                Missed: c[9],
                Total: b[9],
                Answered: d[9]
            }, {
                date: "2014-11",
                Missed: c[10],
                Total: b[10],
                Answered: d[10]
            }, {
                date: "2014-12",
                Missed: c[11],
                Total: b[11],
                Answered: d[11]
            } ]
        });
    }
    function c() {
        AmCharts.makeChart("chartdiv", {
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
            colors: [ "#1a9bef", "#1a9bef" ],
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
                Number: g
            } ]
        }), jQuery(".total_call_wrap span.item_details").text(g);
    }
    function d() {
        AmCharts.makeChart("missedchartdiv", {
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
            colors: [ "#e95b5b", "#e6e6e6" ],
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
                Call: "Missed Calls",
                Number: i
            }, {
                Call: "Answered Calls",
                Number: h
            } ]
        }), jQuery(".miss_call_wrap span.item_details").text(i);
    }
	
	
    function e() {
        AmCharts.makeChart("answeredchartdiv", {
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
            colors: [ "#60c481", "#e6e6e6" ],
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
                Call: "Answered Calls",
                Number: h
            }, {
                Call: "Missed Calls",
                Number: i
            } ]
        }), jQuery(".ans_call_wrap span.item_details").text(h);
    }
    function f() {
        var a = "", b = 0, c = 0, d = 0, e = 0;
        jQuery(".time_data").each(function() {
            a = jQuery(this).text().split(":"), b += parseInt(a[0]), c += parseInt(a[1]), d += parseInt(a[2]), 
            e += 1;
        });
        var f = 60 * b, g = f + c, h = 60 * g, i = h + d, j = i / 60, k = j / e, l = 5 - k, m = k.toFixed(1);
        AmCharts.makeChart("averagechartdiv", {
            type: "pie",
            pathToImages: "http://cdn.amcharts.com/lib/3/images/",
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
            colors: [ "#f1c83f", "#e6e6e6" ],
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
                Number: m
            }, {
                Call: "",
                Number: l
            } ]
        }), jQuery(".avg_call_wrap span.item_details").text(m);
    }
    var g = 0, h = 0, i = 0, j = 0, k = jQuery("#call_tracking_record tbody .call_data").length;
    jQuery("#call_tracking_record tbody .call_data").each(function() {
        j += 1, "Answered" == jQuery(this).text() && (g += 1, h += 1), "Abandoned" == jQuery(this).text() && (g += 1, 
        i += 1), j == k && (jQuery(".total_call_wrap span").text(g), jQuery(".miss_call_wrap span").text(i), 
        jQuery(".ans_call_wrap span").text(h), b(), f(), c(), d(), e(), jQuery.when(b()).done(function() {
            a(), jQuery(".hideIfNotLoaded").each(function() {
                jQuery(this).removeClass("hidden");
            });
        }));
    }), jQuery("#dummy_rec_length").change(function() {
        jQuery("#call_tracking_record_length select").val(jQuery(this).val()), jQuery("#call_tracking_record_length select").trigger("change");
    }), jQuery("#show-filter-form").click(function() {
        jQuery(".filter-form").hasClass("item-hide") ? (jQuery(".filter-form").removeClass("item-hide").addClass("item-show"), 
        jQuery(".filter-box-bg").removeClass("item-hide").addClass("item-show")) : (jQuery(".filter-form").removeClass("item-show").addClass("item-hide"), 
        jQuery(".filter-box-bg").removeClass("item-show").addClass("item-hide"));
    }), jQuery(".filter-box-bg").click(function() {
        jQuery(".filter-form").removeClass("item-show").addClass("item-hide"), jQuery(".filter-box-bg").removeClass("item-show").addClass("item-hide");
    }), jQuery("#cmd_default").click(function() {
        return jQuery(".filter-form").removeClass("item-show").addClass("item-hide"), !1;
    });
});