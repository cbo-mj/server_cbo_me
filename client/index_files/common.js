/* function mycarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: 1,
        wrap: 'last',
        initCallback: mycarousel_initCallback 
    });
});
 */
function validateForm()
  {
    
	var companyName = document.createAccountRequest.companyName.value;
	companyName = companyName.replace("&"," ");
	//alert(companyName.length);
	
   if(companyName=="")
   {
		document.getElementById("ecompanyName").innerHTML = "Please enter Company Name.";
		document.createAccountRequest.companyName.focus();		
		return false;
	}else{
		document.getElementById("ecompanyName").innerHTML = "";
	}
	
	/* var clientUrlLength = document.getElementsByName("clientUrl[]").length;
	var destError = "";
		for(i=0;i<clientUrlLength;i++){		
	     var clientUrlVal = document.getElementsByName("clientUrl[]").item(i).value;
		 clientUrlVal = clientUrlVal.replace("&"," ");
		 
		 var proxyUrlVal = document.getElementsByName("proxyUrl[]").item(i).value;
		 proxyUrlVal = proxyUrlVal.replace("&"," ");		 
		 
		 var landingUrlVal = document.getElementsByName("landingUrl[]").item(i).value;	
		 landingUrlVal = landingUrlVal.replace("&"," ");		 
		 
		 if(clientUrlVal==""){
		   destError = destError.concat("Please enter value of client Url "+(i+1)+". ");
		 } 
		   
		 if(proxyUrlVal==""){
		    destError = destError.concat("Please enter value of proxy Url "+(i+1)+". ");
		 }	
		  
		 if(landingUrlVal==""){
		   destError = destError.concat("Please enter value of landing Url "+(i+1)+". "); 
		 }  
		}
		destError = destError.replace("&"," ");
		 if(destError!=""){
			 document.getElementById("edestUrl").innerHTML = destError;
			 document.getElementsByName("clientUrl[]").item(0).focus();			
			 return false;
	     }else{
			document.getElementById("edestUrl").innerHTML = "";
	     }
		
		
	   var targetPhoneLength = document.getElementsByName("targetPhone[]").length;	   
	   var phoneError = "";
		
		for(i=0;i<targetPhoneLength;i++)
		{		
	     var targetPhoneVal = document.getElementsByName("targetPhone[]").item(i).value;
		 targetPhoneVal = targetPhoneVal.replace("&"," ");
		 var trackingPhoneVal = document.getElementsByName("trackingPhone[]").item(i).value;
		 trackingPhoneVal = trackingPhoneVal.replace("&"," ");		 
		 var ctcPhoneVal = document.getElementsByName("ctcPhone[]").item(i).value;	
		 ctcPhoneVal = ctcPhoneVal.replace("&"," ");		 
		 
		 if(targetPhoneVal==""){
		   phoneError = phoneError.concat("Please enter value of target Phone "+(i+1)+". ");	
		 }  
		 if(trackingPhoneVal==""){
		    phoneError = phoneError.concat("Please enter value of tracking Phone "+(i+1)+". ");		  
		}	
		 if(ctcPhoneVal==""){
		   phoneError = phoneError.concat("Please enter value of ctc Phone "+(i+1)+". ");	 
		 }  
		}
		phoneError = phoneError.replace("&"," ");
		
	 if(phoneError!=""){
		 document.getElementById("ePhone").innerHTML = phoneError;
		 document.getElementsByName("targetPhone[]").item(0).focus();			
		 return false;
	   }else{
			 document.getElementById("ePhone").innerHTML = "";
	   }		
	
   var tonotes = document.createAccountRequest.tonotes.value;
	tonotes = tonotes.replace("&"," ");
	
	 if(tonotes==""){
		document.getElementById("etonotes").innerHTML = "Please enter notes.";
		document.createAccountRequest.tonotes.focus();		
		return false;
	}else{
		document.getElementById("etonotes").innerHTML = "";
	}	
	
	
	
	var addressNameLength = document.getElementsByName("addressName[]").length;	   
	 var addressError = "";   
	  for(i=0;i<addressNameLength;i++)
		{
	     var addressNameVal = document.getElementsByName("addressName[]").item(i).value;
		 addressNameVal = addressNameVal.replace("&"," ");
		 var addressLine1Val = document.getElementsByName("addressLine1[]").item(i).value;
		 addressLine1Val = addressLine1Val.replace("&"," ");
		  var addressCityVal = document.getElementsByName("addressCity[]").item(i).value;
		 addressCityVal = addressCityVal.replace("&"," ");
		 var addressStateVal = document.getElementsByName("addressState[]").item(i).value;
		 addressStateVal = addressStateVal.replace("&"," ");
		  var addressZipVal = document.getElementsByName("addressZip[]").item(i).value;
		 addressZipVal = addressZipVal.replace("&"," ");
		  var addressPhoneVal = document.getElementsByName("addressPhone[]").item(i).value;
		 addressPhoneVal = addressPhoneVal.replace("&"," ");
		  
		  var addressLandUrlVal = document.getElementsByName("addressLandUrl[]").item(i).value;
		 addressLandUrlVal = addressLandUrlVal.replace("&"," ");
		
		 if(addressNameVal==""){
		   addressError = addressError.concat("Please enter value of address Name "+(i+1)+". ");	
		  } 
		 if(addressLine1Val==""){
		    addressError = addressError.concat("Please enter value of Address Line "+(i+1)+". ");		
		 }	
		 if(addressCityVal==""){
		   addressError = addressError.concat("Please enter value of City Name "+(i+1)+". ");
		 }  
		 if(addressStateVal==""){
		   addressNameVal = addressError.concat("Please enter value of State Name "+(i+1)+". ");		
		 }  
		 if(addressZipVal==""){
		    addressError = addressError.concat("Please enter value of Zip "+(i+1)+". ");		  
		 }	
		 if(addressPhoneVal==""){
		   addressError = addressError.concat("Please enter value of phone "+(i+1)+". ");
		  } 
		 if(addressLandUrlVal==""){
		   addressError = addressError.concat("Please enter value of Land Url "+(i+1)+". ");
		 }   
		   
		   	 
		}
		addressError = addressError.replace("&"," ");
		
	if(addressError!=""){
		document.getElementById("eaddress").innerHTML = addressError;
		document.getElementsByName("addressName[]").item(0).focus();	
		return false;
	}else{
		document.getElementById("eaddress").innerHTML = "";
	}	
		
	var contractAmountLength = document.getElementsByName("contractAmount[]").length;
	var contractError = "";
	
	for(i=0;i<contractAmountLength;i++){
		var contractAmountVal = document.getElementsByName("contractAmount[]").item(i).value;
		contractAmountVal = contractAmountVal.replace("&"," ");
		
		
		
		var contractMonthsVal = document.getElementsByName("contractMonths[]").item(i).value;
	    contractMonthsVal = contractMonthsVal.replace("&"," ");
		
		
		
		var contractPsDateVal = document.getElementsByName("contractPsDate[]").item(i).value;
		contractPsDateVal = contractPsDateVal.replace("&"," ");
		
		
		
		var contractAsDateVal = document.getElementsByName("contractAsDate[]").item(i).value;
		contractAsDateVal = contractAsDateVal.replace("&"," ");
		
		
		
		var contractNotesVal = document.getElementsByName("contractNotes[]").item(i).value;
		contractNotesVal = contractNotesVal.replace("&"," ");
		
		
		
		 if(contractAmountVal==""){
		   contractError = contractError.concat("Please enter value of contract Amount "+(i+1)+". ");	
		    
		 }  
		 if(contractMonthsVal==""){
			contractError =  contractError.concat("Please enter value of contract Month "+(i+1)+". ");
		 }
		 if(contractPsDateVal==""){
			contractError = contractError.concat("Please enter value of Planned Start Date "+(i+1)+". ");
		 }	
		 if(contractAsDateVal==""){
			contractError = contractError.concat("Please enter value of Actual Start Date "+(i+1)+". ");
		 }
		 
		
		
	}
		contractError = contractError.replace("&"," ");	
		
		
	
	if(contractError!=""){
		document.getElementById("econctract").innerHTML = contractError;
		document.getElementsByName("contractAmount[]").item(0).focus();
		return false;
	}else{
		document.getElementById("econctract").innerHTML = "";
	}
	 */
		
	//addressName addressLine1 addressLine2 addressCity addressState addressZip addressPhone addressLandUrl
	
  
	
  
   
  
   
  
	
	
	
	
	
   
  }
  
 
  $('.addressPhone').live('focus', function() {
    var noOptions = '';
   var noOptions = document.getElementsByName("addressPhone[]").item(0).length;  
	 $(this.options).remove();
   
   var opt1 = '';
   var opt1 = document.createElement('option');
	 opt1.text  = "-Please Select-";
     opt1.value = ""; 	
     $(this).append(opt1);
	 
	
	  
	var ctcLength = '';  
   var ctcLength = document.getElementsByName("ctcPhone[]").length;
     
	 var ctcVal = '';
    for(i=0;i<ctcLength;i++)
	{
     var ctcVal = document.getElementsByName("ctcPhone[]").item(i).value;
	 if(ctcVal!="")
	 {
		var opt = document.createElement('option');
         opt.text  = ctcVal;
         opt.value = ctcVal; 
	  $(this).append(opt);
	 }
	} 
  });
  
   $('.addressLandUrl').live('focus', function() {
	
	var noOptions = '';
	var noOptions = document.getElementsByName("addressLandUrl[]").item(0).length;
	$(this.options).remove();
	
	 var opt1 = '';
	 var opt1 = document.createElement('option');
	 opt1.text  = "-Please Select-";
     opt1.value = ""; 	
	 $(this).append(opt1);
     
	var urlLength = '';
	var urlLength = document.getElementsByName("landingUrl[]").length;
 
    for(i=0;i<urlLength;i++)
	{
     var urlVal = document.getElementsByName("landingUrl[]").item(i).value;
	 if(urlVal!="")
	 {
		var opt = document.createElement('option');
         opt.text  = urlVal;
         opt.value = urlVal; 
	 $(this).append(opt);
	 }
	}  
  });
  
 
$(function(){
$('.manual').click(function(){
	$(this).parent().fadeOut(800,function(){ $(this).remove() });
	return false;
});

	// var removeLink1 = '<a class="remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false"><img src="'+site_root_dir+'images/min-icon.png" /></a>';
	 var removeLink1 = '<a class="remove" href="#" onclick="$(this).parent().fadeOut(800,function(){ $(this).remove() }); return false"><img src="'+site_root_dir+'images/min-icon.png" /></a>';
$('a.add1').relCopy({ append: removeLink1});	

var removeLink2 = ' <a class="remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">remove</a>';
$('a.add2').relCopy({ append: removeLink1});

var removeLink3 = ' <a class="remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">remove</a>';
$('a.add3').relCopy({ append: removeLink1});	

var removeLink4 = ' <a class="remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">remove</a>';

var contracts_clone = '<p class="contracts_clone4"><label class="lb_amount">Amount:</label><input type="text" class="input_ammount" name="contractAmount[]"><label class="month_lb_01">Months:</label><select class="select-input" name="contractMonths[]"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option> <option value="11">11</option><option value="12">12</option></select><label class="plan_date_label_01">Planned Start Date:</label><input type="text" class="datepicker psdate input_pick" value="" name="contractPsDate[]"><label>Actual Start Date:</label><input type="text" class="datepicker asdate input_pick_actual" value="" name="contractAsDate[]"><label class="note_lb_01">Notes:</label><textarea name="contractNotes[]" maxlength="500" cols="40"></textarea><a class="remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false"><img src="'+site_root_dir+'images/min-icon.png" /></a></p>';

//$('a.add4').relCopy({ append: removeLink1});

$('a.add4').click(function() {
        $(contracts_clone).fadeIn("slow").appendTo('#extender');
        return false;
    });

 $('.datepicker').live('click', function() {
		
        $(this).datepicker({changeMonth: true,changeYear: true,gotoCurrent: true,dateFormat: "yy-dd-mm",yearRange: "1900:+10",showOn:'focus'}).focus();
    });


	
});