<!DOCTYPE html>
<html>
<head>
<title>FB</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<meta charset="UTF-8">
<script>
      $(document).ready(function() {
        // Execute some code here
				
					 $.ajaxSetup({ cache: true });
		  $.getScript('//connect.facebook.net/en_UK/all.js', function(){
			FB.init({
			  appId: '337079909801475',
			});     
			$('#loginbutton,#feedbutton').removeAttr('disabled');
			FB.getLoginStatus(updateStatusCallback);
		  });
      });
    </script>
    


</head>
<body>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }
  
  
 

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '337079909801475',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
		
    });
	
	 // get access token 
	 FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    console.log('access token = ');
	
	 document.getElementById('access_token').innerHTML = "Access Token = "+ response.authResponse.accessToken ;
	console.log(response.authResponse.accessToken);
  }
});
	
	// get loged in user profile 
	FB.api('/me', function(response) {
		
		//alert(JSON.stringify(response));
		 document.getElementById('user_info').innerHTML = "User Profile Info = "+ JSON.stringify(response);
		
		
    console.log(JSON.stringify(response));
});
	
	
	FB.login(function(response) {
		
		// document.getElementById('user_info').innerHTML = "User Profile Info = "+ JSON.stringify(response);
		
			 document.getElementById('user_friends').innerHTML = "Friend List = "+ response;
   console.log(response);
 }, {scope: 'user_friends'});
	
	
	
  }
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email,user_likes" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>

<br/><br/>
<div id="user_info">

</div>

<br/><br/>
<div id="access_token">

</div>


<br/><br/>
<div id="user_friends">

</div>




</body>
</html>