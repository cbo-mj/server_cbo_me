<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <title>Home | SMS MARKETING</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->


	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	
	<script src="http://code.jquery.com/jquery-1.6.min.js"></script>
	<script>
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
		$('#limit_sel').live('change', function() {
			var go = $(this).val();
			var pathname = window.location.pathname;
			var y = getParameterByName('y');
			var limit = getParameterByName('limit');
			var offset = getParameterByName('offset');
			if(!offset)
				offset = 0;
			
			var totmsg = getParameterByName('totmsg');
			var list_id = getParameterByName('list_id');
			var id = getParameterByName('id');
			
			window.location.href = pathname+"?y="+y+"&offset="+offset+"&limit="+go+"&totmsg="+totmsg+"&list_id="+list_id+"&id="+id;
			//alert(pathname);
		});
		$('#offset_sel').live('change', function() {
			var go = $(this).val();
			var pathname = window.location.pathname;
			var y = getParameterByName('y');
			var limit = getParameterByName('limit');
			if(!limit)
				limit = 10;
				
			var totmsg = getParameterByName('totmsg');
			var list_id = getParameterByName('list_id');
			var id = getParameterByName('id');
			
			var offset = getParameterByName('offset');
			window.location.href = pathname+"?y="+y+"&limit="+limit+"&offset="+go+"&totmsg="+totmsg+"&list_id="+list_id+"&id="+id;
			//alert(pathname);
		});
		$('.close').live('click', function() {
			$('.alert-message').hide();
		});
		function confirmDel()
		{
			var result = confirm("Are you sure to delete?");
			if (result==true) {
				return true;
			}
			return false;
		}
	</script>
	</head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body  >
        
        <!-- Header -->

<!-- Main -->
<div class="container">
<div class="row border">
  
<?php $page = basename($_SERVER['PHP_SELF'], '.php')?>
        
<!--h4 class="padding_left sms">SMS Marketing</h4-->
    
        
        <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
             <button type="button" class="navbar-toggle glyphicon glyphicon-align-justify" data-toggle="collapse" data-target=".navbar-collapse">
               
          <span class="icon-toggle"></span>
      </button><a class="navbar-brand" href="#">Menu</a>
          <div class="navbar-collapse collapse">
             <ul class="nav navbar-nav">
              <li <?php if($page == 'index' || $page == 'report'){?> class="active"<?php }?>><a href="index.php?y=<?=$_GET['y']?>">Reporting</a></li>
              <li <?php if($page == 'sendmessage'){?> class="active"<?php }?>><a href="sendmessage.php?y=<?=$_GET['y']?>">Send SMS</a></li>
              <li <?php if($page == 'numbers' || $page == 'addnumber'){?> class="active"<?php }?>><a href="numbers.php?y=<?=$_GET['y']?>">Numbers</a></li>
			  <li <?php if($page == 'contacts' || $page == 'optouts' || $page == 'viewcontacts' || $page == 'newcontactlist' || $page == 'addcontact' ){?> class="active"<?php }?>><a href="contacts.php?y=<?=$_GET['y']?>">Contacts</a></li>
              <li <?php if($page == 'billing'){?> class="active"<?php }?>><a href="billing.php?y=<?=$_GET['y']?>">Billing</a></li>
			  <li <?php if($page == 'faq'){?> class="active"<?php }?>><a href="faq.php?y=<?=$_GET['y']?>">FAQ</a></li>
              <li <?php if($page == 'spampolicy'){?> class="active"<?php }?>><a href="spampolicy.php?y=<?=$_GET['y']?>">Spam Policy</a></li>
			  <li <?php if($page == 'terms'){?> class="active"<?php }?>><a href="terms.php?y=<?=$_GET['y']?>"> Terms of Use</a>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
<?php
date_default_timezone_set('Australia/Sydney');

//function creates page links
	function pagination($count, $href, $limit) {
	$output = '';
	if(!isset($_REQUEST["offset"])) $_REQUEST["offset"] = 1;
	if($limit != 0)
	$pages  = ceil($count/$limit);

	//if pages exists after loop's lower limit
	if($pages>1) {
	if(($_REQUEST["offset"]-3)>0) {
	$output = $output . '<a href="' . $href . 'offset=1" class="">1</a>';
	}
	
	if(($_REQUEST["offset"]-3)>1) {
	$output = $output . '...';
	}

	//Loop for provides links for 2 pages before and after current page
	for($i=($_REQUEST["offset"]-2); $i<=($_REQUEST["offset"]+2); $i++)	{
	if($i<1) continue;
	if($i>$pages) break;
	if($_REQUEST["offset"] == $i)
	$output = $output . '<a href="javascript:void(0);" id='.$i.' class="active">'.$i.'</a>';
	else				
	$output = $output . '<a href="' . $href . "&offset=".$i . '" class="">'.$i.'</a>';
	}

	//if pages exists after loop's upper limit
	if(($pages-($_REQUEST["offset"]+2))>1) {
	$output = $output . '...';
	}
	if(($pages-($_REQUEST["offset"]+2))>0) {
	if($_REQUEST["offset"] == $pages)
	$output = $output . '<a href="javascript:void(0);" id=' . ($pages) .' class="active">' . ($pages) .'</a>';
	else				
	$output = $output . '<a href="' . $href .  "&offset=" .($pages) .'" class="">' . ($pages) .'</a>';
	}

	}
	return $output;
	}
?>