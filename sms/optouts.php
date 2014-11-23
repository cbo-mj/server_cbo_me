<?php require_once('header.php');?>
<?php
// set parameters

if(isset($_GET['offset']))
	$offset = $_GET['offset'];
else
	$offset = 1;
	
if(isset($_GET['limit']))
	$limit = $_GET['limit'];
else
	$limit = 10;

	
	// set parameters
	$id = $_GET['list_id'];

	// execute request
	$methodResponse = $transmitsmsAPI->getContactListRecipientsUnsubscribed($id, $offset, $limit);

	// parse response into xml object
	$xml = @simplexml_load_string($methodResponse);

	
// problem with request 
if (! $xml) { 
	exit(date("y-m-d H:i:s") . " - Problem with request : " . $methodResponse);
}

// valid response has come back
else {
	
	/******************************************************************************************	
	Following examples assume use of the SimpleXML object examples	
	SimpleXML returns objects so type casting has been used to avoid any type related issues. 
	******************************************************************************************/
	$list = '';
		if(!empty($xml->dataset->data))
		{
			foreach ($xml->dataset->data as $data) {
				$list .= 	"<tr>
								<td>{$data->firstname}</td>
								<td>{$data->mobile}</td>
								<td>{$data->datetime_entry}</td>
							</tr>";
			}
		}else{
			$list = "<tr><td colspan='3'>There is not any Number in your account.</td></tr>";
		}
	
}

?>
        	<div class="table-responsive">
       
               
     <div class="container-fluid">  
	 <?php if(isset($_GET['msg'])){echo $_GET['msg'];}?>
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead class="background_th" >
         
                   <th>First Name</th>
                    <th>Mobile Number</th>
                    <th>Date Added</th>
                   </thead>
    <tbody>
    <?=$list?>    
    <tr>

    <td colspan="3" class="pagination">
			<?php
				$total_pages = ($xml->total/$limit)+1;
				$total_pages = round($total_pages);
				$bb = $offset-1;
				$ff = $offset+1;
			?>			
			<!-- Go to first page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=1"?>"><i class="glyphicon glyphicon-step-backward"></i></a>
			<!-- Go to Previous page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$bb?>"> <i class=" glyphicon glyphicon-chevron-left"></i></a>			
			<?php
			$href = "?y=".$_GET['y']."&limit=".$limit;
			echo pagination($xml->total, $href, $limit);
			?>
			<!-- Go to Next page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$ff?>"> <i class=" glyphicon glyphicon-chevron-right"></i></a>
			<!-- Go to last page-->			
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$total_pages?>"> <i class=" glyphicon glyphicon-step-forward"></i></a>
			
			<span>Page Number: <strong><?php echo $page = isset($_GET['offset']) ? (int) $_GET['offset'] : 1;?></strong></span>
			<span>Page size:</span>
				<select id="limit_sel">
					<option value="10" <?php if($limit==10){?> selected="selected"<?php }?>>10</option>
					<option value="25" <?php if($limit==25){?> selected="selected"<?php }?>>25</option>
					<option value="50" <?php if($limit==50){?> selected="selected"<?php }?>>50</option>
				</select>
        </td>
    
    </tr>
    
   
    
   
    
    </tbody>
        
</table>




            </div>
</div>
        <br>
   
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>$(document).ready(function(){
$("#mytable #checkall").click(function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
});

 $(function () {
            $("[rel='tooltip']").tooltip();
        });</script>
     
<script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>