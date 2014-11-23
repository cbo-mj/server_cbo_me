<?php
ob_start();
require('./includes/header1.php');
?>

<script>
    $(document).ready(function(){
        $('#videolisting').addClass('active');
    });
</script>


<style>
.table-striped img {padding-right: 0px !important;}
</style>


<?php
$querystring='';
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
    $querystring.='?limit='.$limit;
}
else{
    $limit = 10;
    $querystring.='?limit=10';
}
if(isset($_GET['offset'])){
    $offset = $_GET['offset'];
    $result_offset = $limit*($offset-1);
    $querystring.='&offset='.$offset;
}else{
    $offset = 1;
    $result_offset =0;
    $querystring.='&offset=1';
}
//creating querystring

//end query string

//deleting video
if(isset($_GET['key'])  && !empty($_GET['key'])){
    $tag = '&tag='.$_SESSION['tag'];
    $querystring = $querystring.$tag;
    $objectApi->call("/videos/delete",array('video_key'=>$_GET['key']));
    ob_end_clean();
    header('location:'.URL_SITE.'/listing.php'.$querystring);
}
//end deleting video

$videosArr =array();
//setting parameter
if(isset($_GET['tag']) && !empty($_GET['tag'])){
    $_SESSION['tag']=$_GET['tag'];
    $parameter = $_GET['tag'];
    $querystring.='&tag='.$parameter;
    $videosArr = $objectApi->call("/videos/list/",array('search:tags'=>$parameter,'order_by'=>'date','result_limit'=>$limit,'result_offset'=>$result_offset));
}elseif(isset($_GET['search']) && !empty($_GET['search'])){
    $parameter = $_GET['search'];
    $querystring.='&search='.$parameter;
    $videosArr = $objectApi->call("/videos/list/",array('search:*'=>$parameter,'order_by'=>'date','result_limit'=>$limit,'result_offset'=>$result_offset));
}else{
    $parameter ='';
    $videosArr = $objectApi->call("/videos/list/",array('order_by'=>'date','result_limit'=>$limit,'result_offset'=>$result_offset));
}

if(isset($_GET['search']) && !empty($_GET['search'])){
    $searchvalue = $_GET['search'];
}else{
    $searchvalue='';
}

//echo'<pre>';print_r($videosArr);die;

if(count($videosArr['videos'])>0) {
    $listedvideos = $videosArr['limit'];
    $totalVideos = count($videosArr['videos']);
    $totalvideos =  $videosArr['total'];
    $pages = round($totalvideos/$listedvideos);
    $pages = $pages;
    $videos =$videosArr['videos'];
}else{
    $pages=0;
    $totalVideos=0;
    $videos =array();
    $listedvideos=0;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
    <head>
        <title>Home | Video Streaming</title>
        <script type="text/javascript">var jslang='EN';</script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="/video/charts/amcharts.js" type="text/javascript"></script>
        <script src="/video/charts/themes/light.js" type="text/javascript"></script>
        <script src="/video/charts/pie.js" type="text/javascript"></script>
        <script src="/video/charts/serial.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
        <script src="js/common_function.js"></script>
        
        
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="css/jquery.dataTables.css" />
        <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <!--<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
-->
        <style>
            .hd-labl {
                margin-left: 13px;
            }
            .btn-search-inner{
                float:none !important;
            }
        </style>
    </head>

<body class="hybrid">
<div id="wrapper">
<table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
    <thead>
        <tr>
        	<th>&nbsp;</th>
            <th width="150">Thumbnail</th>
            <th width="150">Title</th>
            <th width="150">Status</th>
            <th width="230">Duration</th>
            <th width="120">Pageviews</th>
            <th width="120">Views</th>
            <th width="120">Date Uploaded</th>
            <th width="120">Action</th>
        </tr>
    </thead>
    <tbody>
<?php $ctr = 1;			
if($totalVideos>0){
    foreach($videos as $video){
        $singlevideosArr = $objectApi->call("/videos/views/list",array('search'=>$video['key']));
		//echo '<pre>';
			//print_r($video);
			//print_r($singlevideosArr);
		//echo '</pre>';
		//exit();
        if($singlevideosArr['total']>0){
            $pageviewed = $singlevideosArr['videos'][0]['pageviews'];
            $viewed = $singlevideosArr['videos'][0]['viewed'];
        }else{
            $pageviewed = 0;
            $viewed = 0;
        }
?>
    <tr class="odd">
    	<td align="center"><strong><?php echo $ctr++; ?></strong></td>
        <td>
        	<a class="btnVideo" onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#"><img class="vidimg" src="http://content.jwplatform.com/thumbs/<?php echo $video['key']?>-80.jpg" ></a>
        </td>
        <td>
        	<a class="btnVideo" onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#"><?php echo $video['title']  ?></a>
        </td>
        <td><?php echo $video['status'];?></td>
        <td><?php echo gmdate('H:i:s', $video['duration']); ?></td>
        <td><?php echo $video['views']; ?></td>
        <td><?php echo $pageviewed;  ?></td>
        <td><?php //echo '00:' ?><?php echo date('Y-m-d Y h:i:s A',$video['date']);  ?></td>
        <td>
			<span class="btn-links">
				<a onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#">View</a>&nbsp;|&nbsp;<a href="<?php echo URL_SITE.'/listing.php'.$querystring.'&key='.$video['key']?>" onclick="return confirm('Are you sure to delete this video?')">Delete</a>
			</span>        
        </td>
    </tr>
<?php 
	}
}
?>
</tbody>
</table>
</div>    

                        

</body>
</html>