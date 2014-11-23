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
    .table-striped img {
        padding-right: 0px !important;
    }
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
    /*if(isset($_GET['tag']) && !empty($_GET['tag'])){
$tag='&tag='.$_GET['tag'];
}elseif(isset($_SESSION['tag'])){
$tag = $_SESSION['tag'];
$tag='&tag='.$tag;
}else{
$tag='&tag='.$tag;
}*/
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
//getting current page
/*if($currentpage>$pages){
$currentpage = $pages;
}elseif($currentpage<1){
$currentpage = 1;
}*/

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
        
        
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
    <body>        
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12  margin_bottom searchright">
                    <form id="searchform" name='searchform'  action="/video/listing.php" method='GET'>
                        <input type="text" name='search' placeholder="Search videos" id="searchbox" value="<?php echo $searchvalue?>" id="searchfilter" class="form-control search_inner pull-right"/>
                        <button class="btn btn-search-inner btn-sm searchbtn_font" style="float:none; display: none;">Search</button>
                        <?php if($searchvalue!=''){?>
                        <a id="clearsearch" href="/video/listing.php" class="btn btn-search-inner btn-sm searchbtn_font">Clear</a>
                        <?php } ?>
                        
                        
                    </form>
                </div>
            </div>
            
        </div>
        <!--
<div class="row-fluid">
<div class="col-md-3">
<div class="col-md-8 no_pad_left" style="margin-left: 15px;"><span class="date_span">Video Listing</span></div>
</div>
<div class="col-md-9 no_pad_hr"><hr></div>
</div>  
-->
        <div class="content-head">
            <div class="bg-white-client"><h4>Video List</h4></div>
            <div class="line-area"></div>
        </div>
        <div class="table-responsive">              
            <div class="container-fluid">  
                <!---table start here-->
                <table id="mytable" class="table table-bordred table-striped">                   
                    <thead class="background_th" >	
                        <th>&nbsp;</th>
                        <th>Thumbnail</th>
                        <th width="20%">Title</th>
                        <th width="10%">Status</th>
                        <th>Duration</th>
                        <th>Pageviews</th>
                        <th width="5%">Views</th>
                        <th>Date Uploaded</th>						
                        <th>Action</th>		             
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
                        <tr class="videorow">
                            <td width="25" align="center"><strong><?php echo $ctr++; ?></strong></td>
                            <td width="110"><a class="btnVideo" onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#"><img class="vidimg" src="http://content.jwplatform.com/thumbs/<?php echo $video['key']?>-80.jpg" ></a></td>		
                            <td><a class="btnVideo" onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#"><?php echo $video['title']  ?></a></td>
                            <td width="150"><?php echo $video['status'];?></td>
                            <td width="150"><?php //echo '00:' ?><?php  //echo $video['duration'] ;
                            //echo @date('i:s',$video['duration']); ?><?php echo gmdate('H:i:s', $video['duration']); ?></td>
                            <td width="150"><?php echo $video['views'];  ?></td>	
                            <td width="150"><?php echo $pageviewed;  ?></td>	
                            <td width="150"><?php //echo '00:' ?><?php echo date('Y-m-d Y h:i:s A',$video['date']);  ?></td>				
                            
                            <td width="125">
                                <span class="btn-links">
                                    <a onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#">View</a>&nbsp;|&nbsp;<a href="<?php echo URL_SITE.'/listing.php'.$querystring.'&key='.$video['key']?>" onclick="return confirm('Are you sure to delete this video?')">Delete</a>
                                </span>
                                
                            </td>					
                        </tr>
                        <?php 
                            
    }
}else{ ?>
                        <tr>
                            
                            <td colspan="8"><center><b>No Video Found</b></center></td>
                        </tr>
                        
                        <?php
}
                        ?>
                        <?php
if(isset($pages) && ($pages>0)){
                        ?>
                        <tr>
                            <td colspan="9" class="pagination" style="border-top: 1px solid #DBDBDB; background-color: #eeeeee;">
                                
                                <?php
    $total_pages = round($pages);
    $bb = $offset-1;
    if($offset==0){ $offset=$offset+1;}
    
    
    $ff = $offset+1;
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $search = 'search='.$search;				
    }elseif(isset($_GET['tag'])){
        $search = $_GET['tag'];	
        $search = 'tag='.$search;			
    }else{ $search ='';}
    $href = "?limit=".$limit."&".$search;
    
    $pageNum = pagination($total_pages, $href, $limit);
    if($offset == 0)
        $offset = 1;
    if(!empty($pageNum))
    {
        if($bb > 0)
        { if($search!=''){ $search = '&'.$search;}else{ $search='';}
                                ?>			
                                <!-- Go to first page-->
                                <a href="<?php echo '?limit='.$limit.'&offset=1'.$search?>"><i class="icon-step-backward"></i></a>
                                <!-- Go to Previous page-->
                                <a href="<?php echo '?limit='.$limit.'&offset='.$bb.$search?>"> <i class="icon-left"></i></a>			
                                <?php
        }else{
                                ?>			
                                <!-- Go to first page-->
                                <a href="javascript:void(0);"><i class="icon-step-backward"></i></a>
                                <!-- Go to Previous page-->
                                <a href="javascript:void(0);"> <i class="icon-left"></i></a>			
                                <?php
        }
        echo $pageNum;
        if($total_pages > $offset)
        {	if($search!=''){ $search = '&'.$search;}else{ $search='';}
                                ?>
                                <!-- Go to Next page-->
                                <a href="<?php echo '?limit='.$limit.'&offset='.$ff.'&'.$search?>"> <i class="icon-right"></i></a>
                                <!-- Go to last page-->			
                                <a href="<?php echo '?limit='.$limit.'&offset='.$total_pages.$search?>"> <i class="icon-step-forward"></i></a>
                                <?php
        }else{
                                ?>			
                                <!-- Go to first page-->
                                <a href="javascript:void(0);"><i class="icon-right"></i></a>
                                <!-- Go to Previous page-->
                                <a href="javascript:void(0);"> <i class="icon-step-forward"></i></a>			
                                <?php
        }
    }
                                ?>
                                <span style="float: right; margin-right: 15px; margin-top: 10px;"><?php echo "showing page ".$offset." of ".$total_pages;?></span>
                                <span>Page size:</span>
                                <select id="limit_sel">
                                    <option value="10" <?php if($limit==10){?> selected="selected"<?php }?>>10</option>
                                    <option value="25" <?php if($limit==25){?> selected="selected"<?php }?>>25</option>
                                    <option value="50" <?php if($limit==50){?> selected="selected"<?php }?>>50</option>
                                </select>
                            </td>   
                        </tr>  
                        <?php } ?>
                    </tbody>
                    
                </table>
                <!-- table ends here-->
            </div>
        </div> 
        <script type="text/javascript">
            $('#clearsearch').click(function(e){
                //e.preventDefault();
                //window.location = "/video/index.php?status=clear";
            });
        </script>
        
        <?php
require('./includes/footer.php');
        ?>
    </body>
</html>

