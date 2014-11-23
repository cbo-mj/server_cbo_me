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

<script>
$(document).ready(function() { 
	$('#uploadbutton').click(function(){
	var filevalue = $('#uploadFile').val();

		if(filevalue!='') //check empty input filed
		{	
			tb_show("","#TB_inline?height=275&amp;width=281&amp;inlineId=loader&amp;modal=true",null);	
		}
		

	});
});

</script>
<div id="loader" style='display:none'><img src="images/loader.gif"></div>
<div id="upload-wrapper">
<div class="container-fluid margin_top"><div class="col-md-4 no_pad_mob video_sta"><p>Step 2: Upload Video</p></div>

<!--
<div class="col-md-10 no_pad_hr no_pad_mob"><hr></div>
-->
</div>
    
      <div class="row-fluid">
    <div class="col-md-12 ">    
	<form class="form-horizontal" id="uploadForm" action="<?=$url?>" method="POST" enctype="multipart/form-data">
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
         </div>
		 

		 
             <button class="btn btn-primary-upload btn-sm" id="uploadbutton">Upload</button>

            
		 
		 </div>



        </fieldset>
      </form>
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


