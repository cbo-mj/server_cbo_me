function isFieldEmpty(fieldvalue,fieldtitle) {
	var returnvalue = "";
	if(fieldvalue === "") { returnvalue = "- please enter " + fieldtitle.toLowerCase() + " \n"; } 	
	return returnvalue;
}

function IsEmailValid(fieldemail) {
	var returnvalue = "";
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var ans = regex.test(fieldemail);
	if(ans == false) { returnvalue = "- please enter valid email address \n"; } else if(ans == true) { returnvalue = ""; }
	 
	return returnvalue;
}

function getParameter(sParam) {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++)  {
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam) 
		{
			return sParameterName[1];
		}
	}
}   