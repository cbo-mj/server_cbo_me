<?php require_once('header.php');?>
<?php require_once('api2.php');?>
<?php

if(isset($_GET['offset']))
	$offset = $_GET['offset'];
else
	$offset = 1;
	
if(isset($_GET['limit']))
	$limit = $_GET['limit'];
else
	$limit = 10;
 
$result = $api->getNumbers($offset, $limit);

		$list = '';
		if(!empty($result->numbers))
		{
			foreach ($result->numbers as $number) {
				//echo "Number {$number->number} is {$number->status} and valid up to {$number->next_charge}<br>";
				$clas = '';
				if($number->status != 'active')
				{
					$clas = "negetive";
				}else{
					$clas = "positive";
				}
				$list .= 	"<tr>
								<td>{$number->number}</td>
								<td>{$number->next_charge}</td>
								<td><a href='#' class='$clas'>{$number->status}</a></td>
							</tr>";
			}
			
		}else{
			$list = "<tr><td colspan='3'>There is not any number in your account.</td></tr>";
		}
?>        
    <div class="container-fluid">
		<h3>Total Numbers <span class="bal_sp_co"><?=$result->numbers_total?></span></h3>
        <!--div class="row-fluid"><div class="span12  margin_bottom"><input type="text" class="form-control search pull-right" placeholder="Search"></div></div-->
    </div>
    <!--div class="row-fluid"><div class="col-md-3">
        <div class="col-md-4 pad_left2">   <ul class="filter">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Filters <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="#">Default</a></li>
                <li class="divider"></li>
                <li><a href="#">Amelia</a></li>
              </ul>
            </li>
            
          </ul>
</div>
        <div class="col-md-8 no_pad_left"><span class="date_span">Date: All Dates</span></div>
     
        </div><div class="col-md-9 no_pad_hr"><hr></div></div-->
     
    <div class="container-fluid margin-bot">
<a class="btn btn-primary btn-sm" href="addnumber.php?y=<?=$_GET['y']?>">PURCHASE NUMBER</a>
    </div>
      <?php $msg = $_GET['msg']; if(isset($msg)){ echo '<div class="alert-message info"><a class="close" href="#">x</a><p>'.strip_tags($msg).'</p></div>'; }?>
    
   
        	<div class="table-responsive">
       
               
     <div class="container-fluid">  
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead class="background_th" >
         
                   <th>Number</th>
                    <th>Billing Date</th>
                     <th>Status</th>
                   </thead>
    <tbody>
    <?=$list?>    
<?php  echo "showing page {$result->page->number} of {$result->page->count} <hr>";?>
    <tr>
    <td colspan="4" class="pagination">
			<?php
				$total_pages = ($result->numbers_total/$limit)+1;
				$total_pages = round($total_pages);
				$bb = $offset-1;
				$ff = $offset+1;
				$href = "?y=".$_GET['y']."&limit=".$limit;
				$pageNum = pagination($result->numbers_total, $href, $limit);
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
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$total_pages?>"> <i class=" glyphicon glyphicon-step-forward"></i></a>
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