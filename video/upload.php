<?php
ob_start();
require('./includes/header3.php');
$tag = $_SESSION['tag'];
?>
<div id="upload-wrapper">

	<div class="container-fluid margin_top video_sta">
		<div class="col-md-4 no_pad_mob"><p>Step 1: Video title and description</p></div>
		<!--
<div class="col-md-10 no_pad_hr no_pad_mob"><hr></div>
-->

</div>
	</div>   
      <div class="row-fluid">
    	<div class="col-md-12 ">
      	<form class="form-horizontal upload_vid" role="form" action='processupload.php' method='POST' enctype="multipart/form-data" id="firstUploadForm">
        <fieldset>

          

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-1 control-label" for="textinput">Title</label>
            <div class="col-sm-6 padding-left50">
               <input class='form-control' name='title' required placeholder="Title for video" size='2' type='text'>
		<input  name='tags' value="<?php echo $tag ?>"  type='hidden'>
		
            </div>
          </div>

         
          <!-- Text input-->
         <div class="form-group">
            <label class="col-sm-1 control-label" for="textinput">Description</label>
            <div class="col-sm-6 padding-left50">
             <textarea class="form-control" required name='description' rows="5" style="color: #888;"></textarea>
	     <i style='font-size:12px;'>Descriptions are used for video SEO and shown in playlists</i>
            </div>
          </div>
<div id="output"></div>
            
 	<div class="form-group">
            <label class="col-sm-1 control-label" for="textinput"></label>
            <div class="col-sm-3">
             <button class="btn btn-primary btn-sm margin-left40">Continue to upload</button>
            </div>
               <div class="col-sm-7"></div>
          </div>
        </fieldset>
      </form>
    </div><!-- /.col-lg-12 -->          
</div><!-- /.row -->
</form>
<div id="output"></div>
</div>
<script>
$(document).ready(function() { 
	$('#uploadvideo').addClass('active');
});
</script>
