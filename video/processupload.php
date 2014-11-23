<?php
ob_start();
require('./includes/header1.php');

if(isset($_POST) && !empty($_POST)){
	$arr['title']=$_POST['title'];
	$arr['description']=$_POST['description'];
	$tag = $_POST['tags'];
	$arr['tags']=$tag;
	$arr['upload']=1;	
	$response = $objectApi->call("/videos/create/",$arr);
	
	if ($response['status'] == 'error') {
		ob_end_clean();		 
		header('location:'.URL_SITE.'/upload.php?tag='.$tag);
	 }else{
		$url = 'http://'.$response['link']['address'].$response['link']['path'];
		$token = $response['link']['query']['token'];
	}
	
		  
   }else{
	ob_end_clean();	
	header('location:'.URL_SITE.'/upload.php?tag=Xtreme Rotaries');
	exit;
   }
?>
<style>
  #LoadingDiv{
  background: url("images/transbg.png") repeat scroll 0 0 transparent;
    border: 1px solid #000000;
    clear: none;
    height: 100%;
    left: 0;
    margin: 0;
    opacity: 1;
    position: fixed;
    text-align: center;
    top: 0;
    width: 100%;
    z-index: 9999;
  }
</style>

 <style>  
 .progress { position:relative; width:400px;  padding: 1px; border-radius: 3px; }  
 .bar { background-color: #1C9CF4; width:0%; height:50px;border-radius:3px;margin: -1px 0 0; }  
 .percent { position:absolute; display:inline-block; top:3px; left:48%; }  
.progresscls{margin-left:28%;display:none;border-radius: 20px 20px 20px 20px;height: 28px; }
 </style>  
<script type="text/javascript">
$(document).ready(function() {
 var width=0;
	$('#uploadForm').submit(function() {
		var i=0;
		var url = $(this).attr('action');
	
		var dataToBeSent = $(this).serialize();
		   $('.progress').show();
		  
		$.ajax({
			url: url,
			data: dataToBeSent,
			type: 'post',
			beforeSend: function() { 
			test();		   
			   },			
			success: function(result)
			{
			   
				
			}
		});
	});


				function test()	  
				{
					width = width + 1;	
					$('.bar').css('width',width+'%');
					$('.percent').html(width+'%');
					if(width<99){
						setTimeout(function(){test()}, 1000);
					}
		
				}

	
});
</script>


 <div id="LoadingDiv" style="display:none;">
    <div style="margin-top: 2%;">
   <img src="images/ajax_dot.gif" alt="" />  </div>
 </div>
<!--<div id="loader" style='display:none'><center><img src="images/ajax-loader.gif"></center></div>-->
<div id="upload-wrapper">
<div class="container-fluid margin_top"><div class="col-md-4 no_pad_mob video_sta"><p>Step 2: Upload Video</p></div>

<!--
<div class="col-md-10 no_pad_hr no_pad_mob"><hr></div>
-->
</div>
    
      <div class="row-fluid">
    <div class="col-md-12 ">    
	<form class="form-horizontal" id="uploadForm" name="uploadForm" action="<?=$url?>" method="POST" enctype="multipart/form-data">
        <fieldset>

		<div class="videofrom_in">
		
	    <div class="fields">
			<div class="form-field-names">Select File :</div>
			<div class="form-field">
				<input id="uploadFile" type="file" name="file" accept="video/*" required/>
				<input id="key" type="hidden" name="key" value="<?=$response['link']['query']['key']?>" />
				<input id="api_format" type="hidden" name="api_format" value="json" />
				<input id="uploadToken" type="hidden" name="uploadToken" value="<?=$token?>" />
				<input id="token" type="hidden" name="token" value="<?=$token?>" /> 
				<input type="hidden" name="redirect_address" value="<?php echo URL_SITE.'/play.php'?>" />	
			</div>
			<div class="clr"></div>
<br/>
		<div class="progress progresscls">  
		     <div class="bar"></div >  
		     <div class="percent">0%</div >  
   		</div> 
         </div>
		 

		 
             <button class="btn btn-primary-upload btn-sm" id="uploadbutton">Upload</button>

            
		 
		 </div>



        </fieldset>
      </form>
 
   <div id="status"></div> 
    </div><!-- /.col-lg-12 -->
          
</div><!-- /.row -->
    <div class="margin-bottom30"></div>
      <div class="container-fluid  "></div>
    
    <div class="margin-bottom30"></div>

</div>

<script>
$(document).ready(function() { 
	$('#uploadvideo').addClass('active');
});
</script>

