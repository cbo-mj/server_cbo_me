$(document).ready(function(){
	$('.changeMe').sSelect({ddMaxHeight: '130px'});					   
	if($(".formValidation").length>0)$(".formValidation").validate();
	if($("#userSeen").length>0)$("#userSeen").validate();

	
  })
function addToYourCart(pId,uId)
{
	 $.ajax({
		type: "POST",
		url: site_root_dir + "ajax"+file_extn+"",
		data: "action=addtocart&pId="+pId+"&uId="+uId,
		success: function(result){
			var msg = "";
			if(result=='insert')
				msg = "<span class='searchsuccess'>Successfully added.</span>"; 
			else
				msg = "<span class='searcherror'>Already added.</span>"; 
			document.getElementById('errorCart'+pId).innerHTML=msg;
			return false;
		}
	 });
}
function funSubmitQuote(pId,uId,pag)
{
	var userFName = document.frmRequestQuote.userFName.value;
	userFName = userFName.replace("&"," ");
	var userQuantity = "";
	var pageAct = "productdetails";
	if(pag=="my-cart")
	{
		pId			 = document.frmMyCart.allProductId.value;
		pageAct 	 = "mycart";
	}
	else if(pag=="product-search")
	{
		userQuantity = document.frmProductSearch1.currQuantity.value;
		pId 		 = document.frmProductSearch1.currProductId.value;
		pageAct 	 = "productsearch";
	}
	else
		userQuantity = document.frmRequestQuote.userQuantity.value;
	//alert(userQuantity+pId);
	userQuantity = userQuantity.replace("&"," ");
	var userEmail = document.frmRequestQuote.userEmail.value;
	userEmail = userEmail.replace("&","");
	var userCompany = document.frmRequestQuote.userCompany.value;
	userCompany = userCompany.replace("&"," ");
	var userPhone = document.frmRequestQuote.userPhone.value;
	userPhone = userPhone.replace("&"," ");
	var userCountry = document.frmRequestQuote.userCountry.value;
	userCountry = userCountry.replace("&"," ");
	
	 $.ajax({
		type: "POST",
		url: site_root_dir + "ajax"+file_extn+"",
		data: "action=submitquote&userFName="+userFName+"&userQuantity="+userQuantity+"&userEmail="+userEmail+"&userCompany="+userCompany+"&userPhone="+userPhone+"&userCountry="+userCountry+"&pId="+pId+"&uId="+uId+"&pageAct="+pageAct,
		success: function(result){
			if(result=='insert')
			{
				document.getElementById('quoteerror').innerHTML="";
				document.getElementById('quotesucces').innerHTML="<div><ul><li>Successfully Sent.</li></ul></div>";
				document.frmRequestQuote.userFName.value="";
				//document.frmRequestQuote.userQuantity.value="";
				document.frmRequestQuote.userEmail.value="";
				document.frmRequestQuote.userCompany.value="";
				document.frmRequestQuote.userPhone.value="";
				document.frmRequestQuote.userCountry.value="";
			}
			else
			{
				document.getElementById('quotesucces').innerHTML="";
				document.getElementById('quoteerror').innerHTML=result;
			}
				
			return false;
		}
	 });
}
function funValidateQunatity(allProductId)
{
	//alert("cxv"+allProductId);
	var flag = "";
	var mycartData = "";
	if(allProductId!="")
	{
		var prodArr = allProductId.split(",");
		var total = prodArr.length;
		for(i=0;i<total;i++)
		{
			var newBox = "txtBox_"+prodArr[i];
			var quantity = document.getElementById(''+newBox+'').value;//newBox.value;document.frmMyCart.
			if(quantity=="")
			{
				flag = "blank";
				alert("Please enter Required Quantity.");
				document.getElementById(''+newBox+'').focus();
				return false;
			}
			else if(!isNumber(quantity))
			{
				flag = "blank";
				alert("Please enter Only Number.");
				document.getElementById(''+newBox+'').value="";
				document.getElementById(''+newBox+'').focus();
				return false;
			}
			else
			{
				mycartData = mycartData+"|"+prodArr[i]+":"+quantity;
			}
		}
	}
	if(flag=="")
	{
		//alert(mycartData);
		document.getElementById('allProductId').value=mycartData;
		openbox_submitYourQuote('Submit Your Quote', 1);	
	}
}
function isNumber (o) {
  return ! isNaN (o-0);
}
function funValidateQunatityForProductSearch(productId)
{
	var flag = "";
	var quantity = "";
	if(productId!="")
	{
		
		var newBox = "productSearchQuantity_"+productId;
		quantity = document.getElementById(''+newBox+'').value;
		if(quantity=="")
		{
			flag = "blank";
			alert("Please enter Desired Quantity.");
			document.getElementById(''+newBox+'').focus();
			return false;
		}
		else if(!isNumber(quantity))
		{
			flag = "blank";
			alert("Please enter Only Number.");
			document.getElementById(''+newBox+'').value="";
			document.getElementById(''+newBox+'').focus();
			return false;
		}
		
	}
	if(flag=="")
	{
		document.getElementById('currQuantity').value=quantity;
		document.getElementById('currProductId').value=productId;
		openbox_submitYourQuote('Submit Your Quote', 1);
	}
}
function funSubmitRequest(uId)
{
	var reqName = document.frmSubmitRequest.reqName.value;
	reqName = reqName.replace("&"," ");
	var reqCompany = document.frmSubmitRequest.reqCompany.value;
	reqCompany = reqCompany.replace("&"," ");
	var reqEmail = document.frmSubmitRequest.reqEmail.value;
	reqEmail = reqEmail.replace("&","");
	var reqPartNumber = document.frmSubmitRequest.reqPartNumber.value;
	reqPartNumber = reqPartNumber.replace("&","");
	var reqQuantity = document.frmSubmitRequest.reqQuantity.value;
	//alert(userQuantity+pId);
	reqQuantity = reqQuantity.replace("&"," ");
	var reqPhone = document.frmSubmitRequest.reqPhone.value;
	reqPhone = reqPhone.replace("&"," ");
	var reqMessage = document.frmSubmitRequest.reqMessage.value;
	reqMessage = reqMessage.replace("&"," ");
	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(reqName=="")
	{
		document.getElementById('quoteerrorleft').innerHTML="<div><ul><li>Please enter Name.</li></ul></div>";
		document.frmSubmitRequest.reqName.focus();
		document.getElementById('quotesucceslef').innerHTML="";
		return false;
	}
	else if(reqEmail=="")
	{
		document.getElementById('quoteerrorleft').innerHTML="<div><ul><li>Please enter Email.</li></ul></div>";
		document.frmSubmitRequest.reqEmail.focus();
		document.getElementById('quotesucceslef').innerHTML="";
		return false;
	}
	else if(reg.test(reqEmail) == false)
	{
	 		document.getElementById('quoteerrorleft').innerHTML="<div><ul><li>Please enter Valid Email.</li></ul></div>";
			document.frmSubmitRequest.reqEmail.focus();
			document.getElementById('quotesucceslef').innerHTML="";
			return false;
	}
	else if(reqPartNumber=="")
	{
		document.getElementById('quoteerrorleft').innerHTML="<div><ul><li>Please enter Part Number.</li></ul></div>";
		document.frmSubmitRequest.reqPartNumber.focus();
		document.getElementById('quotesucceslef').innerHTML="";
		return false;
	}
	else if(reqQuantity=="")
	{
		document.getElementById('quoteerrorleft').innerHTML="<div><ul><li>Please enter Required Quantity.</li></ul></div>";
		document.frmSubmitRequest.reqQuantity.focus();
		document.getElementById('quotesucceslef').innerHTML="";
		return false;
	}
	 $.ajax({
		type: "POST",
		url: site_root_dir + "ajax"+file_extn+"",
		data: "action=submitrequest&reqName="+reqName+"&reqCompany="+reqCompany+"&reqEmail="+reqEmail+"&reqPartNumber="+reqPartNumber+"&reqQuantity="+reqQuantity+"&reqPhone="+reqPhone+"&uId="+uId+"&reqMessage="+reqMessage,
		success: function(result){
			
			if(result=='insert')
			{
				document.getElementById('quoteerrorleft').innerHTML="";
				document.getElementById('quotesucceslef').innerHTML="<div><ul><li>Successfully Sent.</li></ul></div>";
				document.frmSubmitRequest.reqName.value="";
				document.frmSubmitRequest.reqPhone.value="";
				document.frmSubmitRequest.reqCompany.value="";
				document.frmSubmitRequest.reqEmail.value="";
				document.frmSubmitRequest.reqPartNumber.value="";
				document.frmSubmitRequest.reqQuantity.value="";
				document.frmSubmitRequest.reqMessage.value="";
			}
			else
			{
				document.getElementById('quotesucceslef').innerHTML="";
				document.getElementById('quoteerrorleft').innerHTML=result;
			}
				
			return false;
		}
	 });
}
function validate(form_id,email) {
 
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.forms[form_id].elements[email].value;
   if(reg.test(address) == false) {
 
      
      return false;
   }
}
function funManuFact(valu)
{

	document.frmProductSearch.searchText.value=valu;
	$("#searchTextData").fadeOut("slow");
	//alert(valu);
}
