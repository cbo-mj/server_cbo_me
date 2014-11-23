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


<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/upload_style.css">



<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>

<?php
session_start();
require('constant.php');
require_once('Apicore/api.php');
if(isset($_GET['tag']) && !empty($_GET['tag'])){

$_SESSION['tag']=$_GET['tag'];
}elseif(isset($_SESSION['tag'])){

$_SESSION['tag']=$_SESSION['tag'];
}else{
$_SESSION['tag']='Xtreme Rotaries';
}
$tag=$_SESSION['tag'];
$objectApi = new BotrAPI(API_KEY,API_SECRETKEY);
?>
 </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body  >
        
        <!-- Header -->

<!-- Main -->
<div class="container">
<div class="row border">
<h4 class="padding_left sms">Video Streaming</h4>
    
        
        <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
             <button type="button" class="navbar-toggle glyphicon glyphicon-align-justify" data-toggle="collapse" data-target=".navbar-collapse">
               
          <span class="icon-toggle"></span>
      </button>  <a class="navbar-brand" href="#">Menu</a>
          <div>
             <ul class="nav navbar-nav">
              <li id="videolisting"><a href="<?php echo URL_SITE?>/index.php?tag=<?php echo $tag?>" >Videos</a></li>
              <li id="uploadvideo"><a href="<?php echo URL_SITE?>/upload.php?tag=<?php echo $tag?>">Upload Video</a></li>
               <!--<li id="reporting"><a href="#">Reporting</a></li>                   -->
             
            </ul>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
<script>
$('#reporting').click(function(){
alert('This section is under development.');
return false;
});
</script>
<?php
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
