<?php require_once('header.php');?>
<?php require_once('api1.php');?>
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
$dateStart = null;
$dateEnd = null;



// execute request
$methodResponse = $api->getTransactions($offset, $limit, $dateStart, $dateEnd);

// parse response into xml object
$xml = @simplexml_load_string($methodResponse);
		$list = '';
		if(!empty($xml->dataset->data))
		{
			foreach ($xml->dataset->data as $transaction) {
				//echo "Number {$number->number} is {$number->status} and valid up to {$number->next_charge}<br>";
				$clas = '';
				if($transaction->amount<1)
				{
					$clas = "negetive";
				}else{
					$clas = "positive";
				}
				$list .= 	"<tr>
								<td>{$transaction->datetime_entry}</td>
								<td>{$transaction->description}</td>
								<td><a href='#' class='$clas'>{$transaction->amount}</a></td>
								<td>{$transaction->balance_standing}</td>
							</tr>";
			}
			
		}else{
			$list = "<tr><td colspan='4'>There has been no transaction activity for your account in the chosen period.</td></tr>";
		}
?>        
        <div class="container-fluid">
<!--h3>Balance <span class="bal_sp_co"><?php //$xml->dataset->data->balance_standing?></span></h3-->
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
     
    
    
   
        	<div class="table-responsive">
       
               
     <div class="container-fluid">  
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead class="background_th" >
         
                   <th>Date</th>
                    <th>Transaction Type</th>
                      <th>Amount</th>
                       <th>Balance</th>
                   </thead>
    <tbody>
    <?=$list?>    
    <tr>

    <td colspan="4" class="pagination">
	
			<?php
				$total_pages = ($xml->total/$limit);
				$total_pages = round($total_pages);
				$bb = $offset-1;
				$ff = $offset+1;
				$href = "?y=".$_GET['y']."&limit=".$limit;
				$pageNum = pagination($xml->total, $href, $limit);
				if($offset == 0)
					$offset = 1;
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
			<span><?php echo "showing page ".$offset." of ".$total_pages." | 	";?></span>
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

<?php /*?>
<div class="container-fluid margin_top"><div class="col-md-2 no_pad_mob"><p>Billing Settings</p>   </div><div class="col-md-10 no_pad_hr no_pad_mob"><hr></div></div>

<div class="row-fluid">
    <div class="col-md-12 ">
      <form role="form" class="form-horizontal">
        <fieldset>

          

          <!-- Text input-->
          <div class="form-group">
            <label for="textinput" class="col-sm-2 control-label">Pricing Model</label>
            <div class="col-sm-3">
              <select class="form-control">
                 <option> Power Pricing, $49 p/m</option>
                  </select>
            </div>
               <div class="col-sm-7"><em>Next Billing Date: 14th June 2014</em></div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label for="textinput" class="col-sm-2 control-label">Daily Top up Limit</label>
            <div class="col-sm-3">
            <p> $2500 <a href="#">Apply for increase</a></p>
            </div>
               <div class="col-sm-7"></div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label for="textinput" class="col-sm-2 control-label">Pricing Model</label>
            <div class="col-sm-3">
               <select class="form-control">
                 <option>Do not Auto Recharge</option>
                   <option>Do not Auto Recharge</option>
                  </select>
            </div>
               <div class="col-sm-7"><em>Auto recharge this amount when zero balance or <br>
payments required exceed available balance.</em></div>
          </div>
             <!-- Text input-->
          <div class="form-group">
            <label for="textinput" class="col-sm-2 control-label">Send Balance Working</label>
            <div class="col-sm-3">
             <select class="form-control">
                 <option>Never</option>
                 <option>Never</option>
                  </select>
            </div>
               <div class="col-sm-7"><em>Email me when balance reaches this amount.</em></div>
          </div>
 <div class="form-group">
            <label for="textinput" class="col-sm-2 control-label"></label>
            <div class="col-sm-3">
             <button class="btn btn-primary btn-sm">Update</button>
            </div>
               <div class="col-sm-7"></div>
          </div>




        </fieldset>
      </form>
    </div><!-- /.col-lg-12 -->
          
</div>

<div class="margin-bottom30"></div>
<div class="container-fluid  "><div class="col-md-2 no_pad_mob"><p>Credit Cards </p> </div><div class="col-md-10  no_pad_hr"><hr></div></div>
<div class="margin-bottom30"></div>
<div class="container-fluid">
            <form role="form" class="form-horizontal">
        <fieldset>

          

          <!-- Text input-->
          <div class="form-group">
            <label for="textinput" class="col-sm-2 control-label"></label>
            <div class="col-sm-6">
            <button class="btn btn-sm btn-dafault butm">Add Card</button><button class="btn btn-sm btn-dafault butm">Add Credit</button><button class="btn btn-sm btn-dafault butm">Transfer Credit</button>
            </div>
               <div class="col-sm-4"></div>
          </div>

        </fieldset>
      </form>
          
          
          </div>
		  <br />
		  <div class="table-responsive">
       
               
     <div class="container-fluid">  
              <table class="table table-bordred table-striped" id="mytable">
                   
                   <thead>
         
                   <tr><th>Name</th>
                    <th>Expiry</th>
                     <th>Last 4 Digits</th>
                      <th>Actions</th>
                       
                   </tr></thead>
    <tbody>
    
    <tr>
    <td>Shane Mcgeorge</td>
    <td>July 2015</td>
    <td>2311</td>
    <td><a href="#">Details</a></td>
    </tr>
     <tr>
    <td>Shane Mcgeorge</td>
    <td>July 2015</td>
    <td>2311</td>
    <td><a href="#">Details</a></td>
    </tr>
    
       <tr>
    <td>Shane Mcgeorge</td>
    <td>July 2015</td>
    <td>2311</td>
    <td><a href="#">Details</a></td>
    </tr>
     <tr>
    <td>Shane Mcgeorge</td>
    <td>July 2015</td>
    <td>2311</td>
    <td><a href="#">Details</a></td>
    </tr>
     <tr>
    <td>Shane Mcgeorge</td>
    <td>July 2015</td>
    <td>2311</td>
    <td><a href="#">Details</a></td>
    </tr>
     <tr>
    <td>Shane Mcgeorge</td>
    <td>July 2015</td>
    <td>2311</td>
    <td><a href="#">Details</a></td>
    </tr>
    
    
    

    
   
    
   
    
    </tbody>
        
</table>



        </div>
</div>
<?php */?>


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