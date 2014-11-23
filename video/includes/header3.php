<?php header("Access-Control-Allow-Origin: *");?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <title>Home | Video Streaming</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->


<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/upload_style.css" />
<link rel="stylesheet" type="text/css" href="css/thickbox.css" />
<link rel="stylesheet" type="text/css" href="css/circle.css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>
<script type="text/javascript" src="js/thickbox.js"></script>
<script type="text/javascript">
$('#reporting').click(function(){
	alert('This section is under development.');
	return false;
});
</script>
<script type="text/javascript">
function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#uploadvideo a').click(function(e) {
			e.preventDefault();
			window.location = '/video/upload.php?tag=' + getParameterByName('tag');
		});
		
		$('#videolisting a').click(function(e) {
			e.preventDefault();
			window.location = '/video/v/listing.php?tag=' + getParameterByName('tag')+'&id=1406863802244360994';
		});
		
		$('#limit_sel').change(function() {
			var go = $(this).val();
			var pathname = window.location.pathname;
			var limit = getParameterByName('limit');
			var offset = getParameterByName('offset');
			var searchs = getParameterByName('search');
			var tag = getParameterByName('tag');
			if(searchs){ searchs = '&search='+searchs; }
			if(tag){ tag = '&tag='+tag;	}
			if(!offset)
				offset = 0;			
			//window.location.href = pathname+"?offset="+offset+"&limit="+go+searchs+tag;
			window.location.href = pathname+"?limit="+go+searchs+tag;
			//alert(pathname);
		});
	});
</script>
<?php
session_start();
require('constant.php');
require_once('Apicore/api.php');
$objectApi = new BotrAPI(API_KEY,API_SECRETKEY);

if(isset($_GET['tag']) && !empty($_GET['tag'])){

$_SESSION['tag']=$_GET['tag'];
}elseif(isset($_SESSION['tag'])){

$_SESSION['tag']=$_SESSION['tag'];
}else{
$_SESSION['tag']='Xtreme Rotaries';
}
$tag=$_SESSION['tag'];
?>
 </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body >
        
        <!-- Header -->

<!-- Main -->
<div class="">
<div class="row">    
        
        <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
             <button type="button" class="navbar-toggle glyphicon glyphicon-align-justify" data-toggle="collapse" data-target=".navbar-collapse">
               
          <span class="icon-toggle"></span>
      </button>  <a class="navbar-brand" href="#">Menu</a>
          <div>
             <ul class="nav navbar-nav">
               <li id="videolisting"><a href="<?php echo URL_SITE?>/index.php?tag=<?php echo $tag?>" >Videos</a></li>
               <li id="uploadvideo"><a href="#">Upload Video</a></li>
              <!--<li id="reporting"><a href="#">Reporting</a></li>                      -->
             
            </ul>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

<?php
	function pagination($count, $href, $limit) {
	
	$output = '';
	if(!isset($_REQUEST["offset"])) $_REQUEST["offset"] = 1;
	if($limit != 0)
	$pages  = $count;//ceil($count/$limit);

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
