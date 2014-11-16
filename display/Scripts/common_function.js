function check_date_range2(e) {
    var mystring = e;
    mystring = mystring.replace(/[\. ,:-_]+/g, " ");
    var nav = $('#nav');
    var selection = $('.select');
    if (e == "date_range") {
        $('#date_picker_holder').show();
        $("#specific_field").val(e);
        $("#nav").text(mystring);
        $(".date_range").addClass('activeClass');
        $(".menu_container").css("width", "220");
        $(".menu_container").css("width", "+=360");
        if (nav.hasClass('active')) {
            nav.removeClass('active');
            selection.stop().slideUp(200);
        } else {
            nav.addClass('active');
            selection.stop().slideDown(200);
        }
        $("#date_range").show();
    } else {
        $('#date_picker_holder').hide();
        $("#specific_field").val(e);
        $("#nav").text(mystring);
        $(".date_range").removeClass('activeClass');
        $(".menu_container").css("width", "220");
        $("#date_range").hide();
    }
}

function onClose() {
    $(".menu_container").hide();
}
$(document).on("change", "#datepickerdivfrom", function() {
    $("#from").val($(this).val());
});
$(document).on("change", "#datepickerdivto", function() {
    $("#to").val($(this).val());
});
$(document).ready(
  /* This is the function that will get executed after the DOM is fully loaded */
  function () 
  { 
  	$('#datepickerdivfrom').datepicker({
        dateFormat: "yy-mm-dd"
    });
    $('#datepickerdivto').datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#from" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true ,//this option for allowing user to select from year range	  
	  dateFormat: 'yy-mm-dd' 
	  
    });
	
	
	$( "#to" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
	  dateFormat: 'yy-mm-dd' 
    });
	
	
  }
  

);


function check_date_range(value)
{
	if(value=="date_range")
	{
		$("#date_range").show();
	}else{
		$("#date_range").hide();	
	}
}


function  play_audio(player_div,player_id,path,play_link)
{
	
	
	player = '<audio controls id="'+player_id+'">'                           
              +'<source src="'+path+'" type="audio/wav">'
                 +'Your browser does not support the audio element. </audio>';
				 
			//	 console.log(player);
				 
	$("#"+player_div).html(player);
							
							
	$('#'+play_link).hide();				
							
							
}



function close_open_model(id,caller_id,itemClass)
{
	var elem_class = "." + itemClass;
	jQuery(elem_class).colorbox({inline:true, width:"60%"});
}

jQuery(function(){
	var total_count = 0;
	var ans_count = 0;
	var miss_count = 0;
	var itm_c = 0;
	var data_ln = jQuery("#call_tracking_record tbody .call_data").length;
	jQuery("#call_tracking_record tbody .call_data").each(function(){
		itm_c += 1;
		if(jQuery(this).text() == "Answered"){
			total_count += 1;
			ans_count += 1;
		}
		if(jQuery(this).text() == "Abandoned"){
			total_count += 1;
			miss_count += 1;
		}
		if(itm_c == data_ln){
			
			jQuery(".total_call_wrap span").text(total_count);
			jQuery(".miss_call_wrap span").text( miss_count );
			jQuery(".ans_call_wrap span").text( ans_count );
			runCharts();
			runAverageTime();
			runTotalCalls();
			runMissedCalls();
			runAnsweredCalls();
			jQuery.when( runCharts() ).done(function(){
				runTable();
				jQuery(".hideIfNotLoaded").each(function(){
					jQuery(this).removeClass("hidden");
				});
			});
		}
	});
	
	jQuery("#dummy_rec_length").change(function(){
		jQuery("#call_tracking_record_length select").val(jQuery(this).val());
		jQuery("#call_tracking_record_length select").trigger('change');
	});
	
	jQuery("#show-filter-form").click(function(){
		if(jQuery(".filter-form").hasClass("item-hide")){
			jQuery(".filter-form").removeClass("item-hide").addClass("item-show");
			jQuery(".filter-box-bg").removeClass("item-hide").addClass("item-show");
		}
		else {
			jQuery(".filter-form").removeClass("item-show").addClass("item-hide");
			jQuery(".filter-box-bg").removeClass("item-show").addClass("item-hide");
		}
	});
	jQuery(".filter-box-bg").click(function(){
		jQuery(".filter-form").removeClass("item-show").addClass("item-hide");
		jQuery(".filter-box-bg").removeClass("item-show").addClass("item-hide");
	}); 
	
	
	jQuery("#cmd_default").click(function()
	{
		jQuery(".filter-form").removeClass("item-show").addClass("item-hide");
		return false;
	});

	
	function runTable(){
		var table = $('#call_tracking_record').DataTable({"paginate": true, "sort": false});
		jQuery("#call_tracking_record").promise().done(function(){
			var dummy_cont = "";
			jQuery("#call_tracking_record_length select option").each(function(){
				dummy_cont += '<option value="' + jQuery(this).attr("value") + '">' + jQuery(this).attr("value") + '</option>';
			});
			var dummy_complete = '<div class="tbl_foot_rec_length"><label>Page size:</label> <select id="dummy_rec_length">' + dummy_cont + '</select></div>';
			jQuery( dummy_complete ).insertAfter( jQuery( "#call_tracking_record_paginate" ) );
			jQuery("#call_tracking_record").nextAll().wrapAll( "<div class='foot_wrap' />");
			
			var tbl_title = '<h4 class="head_title">Detailed Call Log</h4>';
			jQuery( tbl_title ).insertAfter( jQuery( ".dataTables_filter" ) );
		});
	}
		
function runCharts(){
	var yearItms = new Array();
	var mnthItms = [0 , 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
	var mnthItmsMiss = [0 , 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
	var mnthItmsAns = [0 , 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
	var mons = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	jQuery("#call_tracking_record tbody tr").each(function(){
		var fst_splt = jQuery(this).find(".date_data").text().split(" - ");
		var snd_split = fst_splt[0].split("'");
		if(jQuery.inArray( snd_split[1], yearItms ) == -1){
			yearItms.push(snd_split[1]);
			for(var i = 0; i <= 11;i++){
				if(snd_split[0].indexOf(mons[i]) == 79){
					mnthItms[i] += 1;						
				}
			}
		}
		else {
			for(var i = 0; i <= 11;i++){
				if(snd_split[0].indexOf(mons[i]) == 79){
					mnthItms[i] += 1;
				}
			}
		}
		console.log(yearItms.length);
		
		if(jQuery(this).find(".call_data").text() == "Abandoned"){
			for(var x = 0; x <= 11; x++){
				if(jQuery(this).find(".date_data").text().indexOf(mons[x]) == 79){
					mnthItmsMiss[x] += 1;
				}
			}
		}
		if(jQuery(this).find(".call_data").text() == "Answered"){
			for(var y = 0; y <= 11; y++){
				if(jQuery(this).find(".date_data").text().indexOf(mons[y]) == 79){
					mnthItmsAns[y] += 1;
				}
			}
		}
		
	});
	
	AmCharts.makeChart("linechartdiv",
		{
			"type": "serial",
			"pathToImages": "https://server.cbo.me/calls/charts/images/",
			"categoryField": "date",
			"dataDateFormat": "YYYY-MM",
			"colors": [
				"#ff1b41",
				"#1a9bef",
				"#62c479"
			],
			"theme": "light",
			"categoryAxis": {
				"minPeriod": "MM",
				"parseDates": true
			},
			"chartCursor": {
				"animationDuration": 0.1,
				"bulletSize": 15,
				"categoryBalloonDateFormat": "MMM YYYY"
			},
			"chartScrollbar": {},
			"trendLines": [],
			"graphs": [
				{
					"bullet": "round",
					"cornerRadiusTop": -3,
					"dashLength": -5,
					"id": "Missed Calls",
					"title": "Missed Calls",
					"type": "smoothedLine",
					"valueField": "Missed"
				},
				{
					"bullet": "diamond",
					"bulletBorderThickness": 0,
					"columnWidth": 0,
					"id": "Total Calls",
					"markerType": "none",
					"negativeBase": -7,
					"title": "Total Calls",
					"type": "smoothedLine",
					"valueField": "Total"
				},
				{
					"bullet": "square",
					"id": "Answered Calls",
					"title": "Answered Calls",
					"type": "smoothedLine",
					"valueField": "Answered"
				}
			],
			"guides": [],
			"valueAxes": [],
			"allLabels": [],
			"balloon": {},
			"legend": {
				"align": "center",
				"marginLeft": 10,
				"markerSize": 14,
				"rollOverGraphAlpha": 0.35,
				"useGraphSettings": true,
				"valueAlign": "left",
				"valueWidth": 44
			},
			"titles": [],
			"dataProvider": [
				{
					"date": "2014-01",
					"Missed": mnthItmsMiss[0],
					"Total": mnthItms[0],
					"Answered": mnthItmsAns[0]
				},
				{
					"date": "2014-02",
					"Missed": mnthItmsMiss[1],
					"Total": mnthItms[1],
					"Answered": mnthItmsAns[1]
				},
				{
					"date": "2014-03",
					"Missed": mnthItmsMiss[2],
					"Total": mnthItms[2],
					"Answered": mnthItmsAns[2]
				},
				{
					"date": "2014-04",
					"Missed": mnthItmsMiss[3],
					"Total": mnthItms[3],
					"Answered": mnthItmsAns[3]
				},
				{
					"date": "2014-05",
					"Missed": mnthItmsMiss[4],
					"Total": mnthItms[4],
					"Answered": mnthItmsAns[4]
				},
				{
					"date": "2014-06",
					"Missed": mnthItmsMiss[5],
					"Total": mnthItms[5],
					"Answered": mnthItmsAns[5]
				},
				{
					"date": "2014-07",
					"Missed": mnthItmsMiss[6],
					"Total": mnthItms[6],
					"Answered": mnthItmsAns[6]
				},
				{
					"date": "2014-08",
					"Missed": mnthItmsMiss[7],
					"Total": mnthItms[7],
					"Answered": mnthItmsAns[7]
				},
				{
					"date": "2014-09",
					"Missed": mnthItmsMiss[8],
					"Total": mnthItms[8],
					"Answered": mnthItmsAns[8]
				},
				{
					"date": "2014-10",
					"Missed": mnthItmsMiss[9],
					"Total": mnthItms[9],
					"Answered": mnthItmsAns[9]
				},
				{
					"date": "2014-11",
					"Missed": mnthItmsMiss[10],
					"Total": mnthItms[10],
					"Answered": mnthItmsAns[10]
				},
				{
					"date": "2014-12",
					"Missed": mnthItmsMiss[11],
					"Total": mnthItms[11],
					"Answered": mnthItmsAns[11]
				}
			]
		}
	);
	
}

function runTotalCalls(){
	AmCharts.makeChart("chartdiv",
		{
			"type": "pie",
			"pathToImages": "https://server.cbo.me/calls/charts/images/",
			"balloonText": "",
			"innerRadius": "85%",
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
				"#1a9bef",
				"#1a9bef"
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
					"Call": "Total Calls",
					"Number": total_count
				}
			]
		}
	);
	jQuery(".total_call_wrap span.item_details").text(total_count);
}
function runMissedCalls(){
	AmCharts.makeChart("missedchartdiv",
		{
			"type": "pie",
			"pathToImages": "https://server.cbo.me/calls/charts/images/",
			"balloonText": "",
			"innerRadius": "85%",
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
					"Call": "Missed Calls",
					"Number": miss_count
				},
				{
					"Call": "Answered Calls",
					"Number": ans_count
				}
			]
		}
	);
	jQuery(".miss_call_wrap span.item_details").text(miss_count);
}
function runAnsweredCalls(){
	AmCharts.makeChart("answeredchartdiv",
		{
			"type": "pie",
			"pathToImages": "https://server.cbo.me/calls/charts/images/",
			"balloonText": "",
			"innerRadius": "85%",
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
					"Call": "Answered Calls",
					"Number": ans_count
				},
				{
					"Call": "Missed Calls",
					"Number": miss_count
				}
			]
		}
	);
	jQuery(".ans_call_wrap span.item_details").text(ans_count);
}

		
function runAverageTime(){
	var time_raw = "";
	var h = 0;
	var m = 0;
	var s = 0;
	var count = 0;
	jQuery(".time_data").each(function(){
	  time_raw = jQuery(this).text().split(":");
	  h += parseInt(time_raw[0]);
	  m += parseInt(time_raw[1]);
	  s += parseInt(time_raw[2]);
	  count += 1;
	});
	var h_mins = h * 60;
	var total_mins = h_mins + m;
	var s_min = total_mins * 60;
	var total_sec = s_min + s;
	var total_raw = total_sec / 60;
	var x = total_raw / count;
	var avg_vs = 5.00 - x;
	var avg_min = x.toFixed(1);
	
	
	AmCharts.makeChart("averagechartdiv",
		{
			"type": "pie",
			"pathToImages": "http://cdn.amcharts.com/lib/3/images/",
			"balloonText": "",
			"innerRadius": "85%",
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
				"#f1c83f",
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
					"size": 45,
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
					"Call": "Average Call Duration",
					"Number": avg_min
				},
				{
					"Call": "",
					"Number": avg_vs
				}
			]
		}
	);
	jQuery(".avg_call_wrap span.item_details").text(avg_min);
}

});

