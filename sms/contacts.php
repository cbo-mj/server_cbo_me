<?php require_once('header.php');?>
<?php require_once('api2.php');?>
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


 $result=$api->getLists($offset, $limit);
 

 if($result->error->code=='SUCCESS')
 {
    echo "There are {$result->lists_total} lists, showing page {$result->page->number} of {$result->page->count} <hr>";
   	 
	$data = '';
	if(!empty($result->lists))
	{
		foreach ($result->lists as $list) {
		
		// execute request
		//		$methodResponse2 = $transmitsmsAPI->getContactListRecipientsUnsubscribed($list->id, $offset, $limit);
		//		$xml2 = @simplexml_load_string($methodResponse2);
		//		if($xml2->total > 0)
		//			$opts = "<td><a href='optouts.php?y=".$_GET['y']."&list_id=".$list->id."'>{$xml2->total}</a></td>";
		//		else
		//			$opts = "<td>{$xml2->total}</td>";
		$opts = '<td></td>';	
			$data .= 	"<tr>
							<td>{$list->name}</td>
							<td>{$list->members_active}</td>
							".$opts."
							<td><a href='addcontact.php?y=".$_GET['y']."&id=".$list->id."'>Add Contacts</a> / <a href='viewcontacts.php?y=".$_GET['y']."&id=".$list->id."'>View Contacts</a> / <a href='deletecontactlist.php?y=".$_GET['y']."&id=".$list->id."' onClick='return confirmDel();'>Delete</a></td>
							</tr>";
		}
	}else{
		$data = "<tr><td colspan='3'>There is not any contact list in your account.</td></tr>";
	}
 }
 else
 {
     echo "Error: {$result->error->description}";
 }
 	

?>
		<div class="container-fluid margin-bot">
<a href="newcontactlist.php?y=<?=$_GET['y']?>" class="btn btn-primary btn-sm" >NEW CONTACT LIST</a>
    </div>
   
    
   
        	<div class="table-responsive">
       
               
     <div class="container-fluid">  
	 <?php if(isset($_GET['msg'])){echo '<div class="alert-message info"><a class="close" href="#">x</a><p>'.$_GET['msg'].'</p></div>';}?>
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead class="background_th" >
         
                   <th>Contact List Name</th>
                    <th>Contacts</th>
					<th>Opt-outs</th>
                    <th>Action</th>
                   </thead>
    <tbody>
    <?=$data?>    
    <tr>

    <td colspan="4" class="pagination">
			<?php
				$total_pages = ($result->lists_total/$limit)+1;
				$total_pages = round($total_pages);
				$bb = $offset-1;
				$ff = $offset+1;
				$href = "?y=".$_GET['y']."&limit=".$limit;
				$pageNum = pagination($result->lists_total, $href, $limit);
				if(!empty($pageNum))
				{
					if($bb > 0)
					{
			?>			
			<!-- Go to first page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=1"?>"><i class="glyphicon glyphicon-step-backward"></i></a>
			<!-- Go to Previous page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$bb?>"> <i class=" glyphicon glyphicon-chevron-left"></i></a>			
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
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$ff?>"> <i class=" glyphicon glyphicon-chevron-right"></i></a>
			<!-- Go to last page-->			
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$result->page->count?>"> <i class=" glyphicon glyphicon-step-forward"></i></a>
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