<?php require_once('header.php');?>
<?php require_once('api2.php');?>
<?php
// set parameters
$id = $_GET['id'];
	
if(isset($_GET['offset']))
	$offset = $_GET['offset'];
else
	$offset = 1;
	
if(isset($_GET['limit']))
	$limit = $_GET['limit'];
else
	$limit = 10;

	$type = (string) "all";
 $result=$api->getList($id, $type, $offset, $limit);

 if($result->error->code=='SUCCESS')
 {

	$list = '';
	if(!empty($result->members))
	{
		foreach ($result->members as $member) {
			
				$status = '';
				if($member->status  == 'active')
				{
					$status = "<span style='color: #67aa40;'>{$member->status}</span>";
				}
				elseif($member->status  == 'inactive')
				{
					$status = "<span style='color: #ff8a00;'>{$member->status}</span>";
				}
				else
				{
					$status = "<span style='color: #ea1111;'>{$member->status}</span>";
				}
		
		
		
			$list .= 	"<tr>
							<td>{$member->first_name}</td>
							<td>{$member->last_name}</td>
							<td>{$member->msisdn}</td>
							<td>".$status."</td>
							<td><a href='deletecontact.php?y=".$_GET['y']."&id=".$member->list_id."&mobile=".$member->msisdn."' onClick='return confirmDel();'>Delete</a></td>
						</tr>";
		}
	}else{
		$list = "<tr><td colspan='5'>There is not any member.</td></tr>";
	}
	 
	 
 }
 else
 {
     $msg = "Error: {$result->error->description}";
 }
?>  
    
        <div class="container-fluid">
<h3><span class="bal_sp_co">Total Contacts <?php echo $result->members_total?></span></h3>
    </div>
   
        	<div class="table-responsive">
       
               
     <div class="container-fluid">
      <?php if(isset($_GET['msg'])){ echo '<div class="alert-message info"><a class="close" href="#">x</a><p>'.$_GET['msg'].'</p></div>'; }?>
      <?php if(isset($msg)){ echo '<div class="alert-message info"><a class="close" href="#">x</a><p>'.$msg.'</p></div>'; }?>
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead class="background_th" >
         
                   <th>First Name</th>
                    <th>Last Name</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Action</th>
                   </thead>
    <tbody>
    <?=$list?>    
    <tr>

    <td colspan="5" class="pagination">
			<?php
				$total_pages = ($result->members_total/$limit)+1;
				$total_pages = round($total_pages);
				$bb = $offset-1;
				$ff = $offset+1;
				$href = "?y=".$_GET['y']."&limit=".$limit."&id=".$id;
				$pageNum = pagination($result->members_total, $href, $limit);
				if(!empty($pageNum))
				{
					if($bb > 0)
					{
			?>			
			<!-- Go to first page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=1"."&id=".$id?>"><i class="glyphicon glyphicon-step-backward"></i></a>
			<!-- Go to Previous page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$bb."&id=".$id?>"> <i class=" glyphicon glyphicon-chevron-left"></i></a>			
			<?php
				}else{
			?>			
			<!-- Go to first page-->
			<a href="javascript:void(0);"><i class="glyphicon glyphicon-step-backward"></i></a>
			<!-- Go to Previous page-->
			<a href="javascript:void(0);"> <i class=" glyphicon glyphicon-chevron-left"></i></a>			
			<?php
				}
			echo $pageNum;
				if($total_pages > $offset)
				{
			?>
			<!-- Go to Next page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$ff."&id=".$id?>"> <i class=" glyphicon glyphicon-chevron-right"></i></a>
			<!-- Go to last page-->			
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$result->page->count."&id=".$id?>"> <i class=" glyphicon glyphicon-step-forward"></i></a>
			<?php
				}else{
			?>			
			<!-- Go to first page-->
			<a href="javascript:void(0);"><i class="glyphicon glyphicon-chevron-right"></i></a>
			<!-- Go to Previous page-->
			<a href="javascript:void(0);"> <i class="glyphicon glyphicon-step-forward"></i></a>			
			<?php
				}
			}
			?>
			<span><?php echo "showing page {$result->page->number} of {$result->page->count} | 	";?></span>
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