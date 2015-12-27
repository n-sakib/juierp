<?php
	$bikri ="selected"; 
	include('template/blankStart.php');?>
<link rel="stylesheet" href="../view/template/css/table-panel.css">
<script type="text/javascript" src="js/sellScript.js"></script>
<?php include_once '../view/sections/sell_nav.php'; 

	include_once(dirname(__FILE__)."/../model/client.php");

	if($_POST)
	{
		include_once(dirname(__FILE__)."/../model/sell.php");
		
		$sell = new Sell($_POST["clientName"]);
		$sell->makeSell();
		echo "<span id=\"success\"></span>";

		//initiate memo making process
		//get a new memo number
		//using the client name get his past due
		//then calulate the new due step by step
		// {	
		// 	each of the products should be saved in the log
		// 	the raw total is calculated 
		// }

	}
 ?>
 <!--=================================
 modals
 =================================-->
 <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">বিক্রি সম্পন্ন</h4>
      </div>
      <div class="modal-body">
        <p>মাল বিক্রি সফল</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ধন্যবাদ</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg hidden" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
 <!-- end of modals -->

<!-- panel start -->
<hr>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1 class="panel-title text-center">মাল বিক্রি</h1>
            </div>
            <div class="panel-body">
            	<!-- panel body -->
                <form action="sell.php" method="post">
					<br>
					<label for="clientName">পার্টি নাম :</label>
					<input class="form-control txt-in-head" name="clientName" list="clientNames" type="text">
					<?php Client::getOptions(); ?>					
					<span class="divider-vertical"></span>
					
					<label for="date">তারিখ :</label>
					<input class="form-control txt-in-head" name="date" type="date">
					
					<div class="br"></div>
					<label for="memoNo">মেমো নং :</label>
					<input class="form-control txt-in-head" name="memoNo" type="text">
					
					<hr>
					<table class="table-panel -table-striped">
						<tr>
							<th style="width:5%;">#</th>
							<th>আইডি</th>
							<th>বিবরণ</th>
							<th>জোড়া</th>
							<th>জোড়া দাম</th>
							<th>হিসাব</th>
						</tr>
						<tr class="products-coll">
							<td></td>
							<td>
								<input class="form-control" name="pid[]" type="text">
							</td>
							<td>
								<span class="descr"></span>
								<input class="form-control" name="descr[]" type="hidden">
							</td>
							<td>
								<input class="form-control" name="qty[]" type="text">
							</td>
							<td>
								<span calss="cp"> </span>
							</td>
							<td>
								<span class="subtotal">
								<button class="close close-btn" type="button">&times;</button>
								</span>
							</td>
						</tr>
						<tr class="last-row">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>মোট দাম</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>কমিশন</td>
							<td>
								<div class="form-group input-group">
									<input name="commPerc" class="form-control"  type="text">
									<div class="input-group-addon">%</div>
								</div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>মোট কমিশন</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>কমিশন ছাড়া দাম</td>
							<td></td>
						</tr>	
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>সাবেক বাকি</td>
							<td><span class="prevDue"></span></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>সাবেক বাকিসহ মোট</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>এক্সট্রা খরচ</td>
							<td>বিবরণ</td>
							<td>
								<input class="form-control" name="extraCostDescr" type="text">
							</td>
							<td>বাবদ</td>
							<td>
								<input class="form-control" name="extraCost" type="text">
							</td>
						</tr>		
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>পাঠানো খরচ</td>
							<td>
								<input class="form-control" name="shippingCost" type="text">
							</td>
						</tr>	
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>ডিস্কাউন্ট</td>
							<td>
								<input class="form-control" name="discount" type="text">
							</td>
						</tr>
						<tr>
							<td>
								মন্তব্য
							</td>
							<td>
								<input name="comment" class="form-control" type="text">
							</td>
							<td></td>
							<td></td>
							<td>জমা</td>
							<td>
								<input class="form-control" name="paid" type="text">
							</td>
						</tr>		


					</table>
					<div class="br"></div>
					<input type="submit" value="বিক্রি" class="btn btn-primary btn-lg pull-right">
					<span class="btn btn-info btn-lg new-line">নতুন লাইন</span>
				</form>
            </div> <!--panel body ends -->
        </div>
    </div>
</div> <!-- panel ends -->
	
<?php include('template/blankEnd.php');?>