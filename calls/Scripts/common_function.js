function check_date_range(e) {
    "date_range" == e ? $("#date_range").show() : $("#date_range").hide()
}

function play_audio(e, a, t, l) {
    player = '<audio controls id="' + a + '"><source src="' + t + '" type="audio/wav">Your browser does not support the audio element. </audio>', $("#" + e).html(player), $("#" + l).hide()
}

function close_open_model(e, a, t) {
    var l = "." + t;
    jQuery(l).colorbox({
        inline: !0,
        width: "60%"
    })
}
$(document).ready(function () {
    $("#from").datepicker({
        changeMonth: !0,
        changeYear: !0,
        dateFormat: "yy-mm-dd"
    }), $("#to").datepicker({
        changeMonth: !0,
        changeYear: !0,
        dateFormat: "yy-mm-dd"
    })
}), jQuery(function () {
    function e() {
        $("#call_tracking_record").DataTable({
            paginate: !0,
            sort: !1
        });
        jQuery("#call_tracking_record").promise().done(function () {
            var e = "";
            jQuery("#call_tracking_record_length select option").each(function () {
                e += '<option value="' + jQuery(this).attr("value") + '">' + jQuery(this).attr("value") + "</option>"
            });
            var a = '<div class="tbl_foot_rec_length"><label>Page size:</label> <select id="dummy_rec_length">' + e + "</select></div>";
            jQuery(a).insertAfter(jQuery("#call_tracking_record_paginate")), jQuery("#call_tracking_record").nextAll().wrapAll("<div class='foot_wrap' />");
            var t = '<h4 class="head_title">Detailed Call Log</h4>';
            jQuery(t).insertAfter(jQuery(".dataTables_filter"))
        })
    }

    function a() {
        var e = new Array,
            a = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            t = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            l = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            i = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        jQuery("#call_tracking_record tbody tr").each(function () {
            var r = jQuery(this).find(".date_data").text().split(" - "),
                s = r[0].split("'");
            if (-1 == jQuery.inArray(s[1], e)) {
                e.push(s[1]);
                for (var o = 0; 11 >= o; o++) 79 == s[0].indexOf(i[o]) && (a[o] += 1)
            } else
                for (var o = 0; 11 >= o; o++) 79 == s[0].indexOf(i[o]) && (a[o] += 1);
            if (console.log(e.length), "Abandoned" == jQuery(this).find(".call_data").text())
                for (var d = 0; 11 >= d; d++) 79 == jQuery(this).find(".date_data").text().indexOf(i[d]) && (t[d] += 1);
            if ("Answered" == jQuery(this).find(".call_data").text())
                for (var n = 0; 11 >= n; n++) 79 == jQuery(this).find(".date_data").text().indexOf(i[n]) && (l[n] += 1)
        }), AmCharts.makeChart("linechartdiv", {
            type: "serial",
            pathToImages: "https://server.cbo.me/calls/charts/images/",
            categoryField: "date",
            dataDateFormat: "YYYY-MM",
            colors: ["#ff1b41", "#1a9bef", "#62c479"],
            theme: "light",
            categoryAxis: {
                minPeriod: "DD",
                parseDates: true
            },
            chartCursor: {
                animationDuration: .1,
                bulletSize: 15,
                categoryBalloonDateFormat: "MMM YYYY"
            },
			periodSelector: {
				position: "bottom",
				periods: [{
					period: "MM",
					selected: true,
					count: 1,
					label: "1 month"
				}]
			}, 
			
            chartScrollbar: {
				graph: "Total Calls",
				position: "bottom",
				color: "#000000",
				autoGridCount: true
			},
            trendLines: [],
            graphs: [{
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
            }],
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
            dataProvider: [{
                date: "2014-01",
                Missed: t[0],
                Total: a[0],
                Answered: l[0]
            }, {
                date: "2014-02",
                Missed: t[1],
                Total: a[1],
                Answered: l[1]
            }, {
                date: "2014-03",
                Missed: t[2],
                Total: a[2],
                Answered: l[2]
            }, {
                date: "2014-04",
                Missed: t[3],
                Total: a[3],
                Answered: l[3]
            }, {
                date: "2014-05",
                Missed: t[4],
                Total: a[4],
                Answered: l[4]
            }, {
                date: "2014-06",
                Missed: t[5],
                Total: a[5],
                Answered: l[5]
            }, {
                date: "2014-07",
                Missed: t[6],
                Total: a[6],
                Answered: l[6]
            }, {
                date: "2014-08",
                Missed: t[7],
                Total: a[7],
                Answered: l[7]
            }, {
                date: "2014-09",
                Missed: t[8],
                Total: a[8],
                Answered: l[8]
            }, {
                date: "2014-10",
                Missed: t[9],
                Total: a[9],
                Answered: l[9]
            }, {
                date: "2014-11",
                Missed: t[10],
                Total: a[10],
                Answered: l[10]
            }, {
                date: "2014-12",
                Missed: t[11],
                Total: a[11],
                Answered: l[11]
            }]
        })
    }
    function t() {
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
            colors: ["#1a9bef", "#1a9bef"],
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
                Call: "Total Calls",
                Number: s
            }]
        }), jQuery(".total_call_wrap span.item_details").text(s)
    }

    function l() {
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
            colors: ["#e95b5b", "#e6e6e6"],
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
                Call: "Missed Calls",
                Number: d
            }, {
                Call: "Answered Calls",
                Number: o
            }]
        }), jQuery(".miss_call_wrap span.item_details").text(d)
    }

    function i() {
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
            colors: ["#60c481", "#e6e6e6"],
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
                Call: "Answered Calls",
                Number: o
            }, {
                Call: "Missed Calls",
                Number: d
            }]
        }), jQuery(".ans_call_wrap span.item_details").text(o)
    }

    function r() {
        var e = "",
            a = 0,
            t = 0,
            l = 0,
            i = 0;
        jQuery(".time_data").each(function () {
            e = jQuery(this).text().split(":"), a += parseInt(e[0]), t += parseInt(e[1]), l += parseInt(e[2]), i += 1
        });
        var r = 60 * a,
            s = r + t,
            o = 60 * s,
            d = o + l,
            n = d / 60,
            u = n / i,
            c = 5 - u,
            h = u.toFixed(1);
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
            colors: ["#f1c83f", "#e6e6e6"],
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
            allLabels: [{
                align: "center",
                id: "Value",
                size: 45,
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
                Call: "Average Call Duration",
                Number: h
            }, {
                Call: "",
                Number: c
            }]
        }), jQuery(".avg_call_wrap span.item_details").text(h)
    }
    var s = 0,
        o = 0,
        d = 0,
        n = 0,
        u = jQuery("#call_tracking_record tbody .call_data").length;
    jQuery("#call_tracking_record tbody .call_data").each(function () {
        n += 1, "Answered" == jQuery(this).text() && (s += 1, o += 1), "Abandoned" == jQuery(this).text() && (s += 1, d += 1), n == u && (jQuery(".total_call_wrap span").text(s), jQuery(".miss_call_wrap span").text(d), jQuery(".ans_call_wrap span").text(o), a(), r(), t(), l(), i(), jQuery.when(a()).done(function () {
            e(), jQuery(".hideIfNotLoaded").each(function () {
                jQuery(this).removeClass("hidden")
            })
        }))
    }), jQuery("#dummy_rec_length").change(function () {
        jQuery("#call_tracking_record_length select").val(jQuery(this).val()), jQuery("#call_tracking_record_length select").trigger("change")
    }), jQuery("#show-filter-form").click(function () {
        jQuery(".filter-form").hasClass("item-hide") ? (jQuery(".filter-form").removeClass("item-hide").addClass("item-show"), jQuery(".filter-box-bg").removeClass("item-hide").addClass("item-show")) : (jQuery(".filter-form").removeClass("item-show").addClass("item-hide"), jQuery(".filter-box-bg").removeClass("item-show").addClass("item-hide"))
    }), jQuery(".filter-box-bg").click(function () {
        jQuery(".filter-form").removeClass("item-show").addClass("item-hide"), jQuery(".filter-box-bg").removeClass("item-show").addClass("item-hide")
    }), jQuery("#cmd_default").click(function () {
        return jQuery(".filter-form").removeClass("item-show").addClass("item-hide"), !1
    })
});