<?php
	$kena ="selected"; 
	include('template/blankStart.php');?>
<link rel="stylesheet" href="../view/template/css/table-panel.css">
<?php include_once '../view/sections/purchase_nav.php';
	include('sections/modals/purchase-modals.php'); 

	include_once(dirname(__FILE__)."/../model/client.php");

	if($_POST)
	{
		include_once(dirname(__FILE__)."/../model/purchaseReturn.php");
		
		$purchaseReturn = new PurchaseReturn($_POST["factoryName"]);
		$purchaseReturn->makePurchaseReturn();
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
        <h1 class="modal-title text-center text-primary">বিক্রি সম্পন্ন</h1>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-success">মাল বিক্রি সফল</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ধন্যবাদ</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                <form action="purchase-return.php" method="post">
					<br>
					<label for="factoryName">কারখানা নাম :</label>
					<input class="form-control txt-in-head factoryName" data-index="" name="factoryName" list="factoryNames" type="text">
					<?php 
						include_once(dirname(__FILE__)."/../model/factory.php");
						Factory::getOptions(); 
					?>
					<span class="divider-vertical"></span>
					
					<label for="date">তারিখ :</label>
					<input class="form-control txt-in-head" name="date" type="date" required>
					<span class="date-indicator btn btn-primary">...</span>
					
					<div class="br"></div>
					<!-- এইটা খাতার মেমো নং, সফটওয়্যারের মেমো নং কখনো এন্ট্রি করা যাবে না -->
					<!-- <label for="memoNo">মেমো নং :</label>
					<input class="form-control txt-in-head" name="memoNo" type="text"> -->
					
					<hr>
					<table class="table-panel -table-striped">
						<tr>
							<th style="width:5%;">#</th>
							<th style="width:10%;">আইডি</th>
							<th style="width:40%;">বিবরণ</th>
							<th style="width:15%;">জোড়া</th>
							<th style="width:15%;">ডজন দাম</th>
							<th style="width:15%;">হিসাব</th>
						</tr>
						<tr class="products-coll">
							<td></td>
							<td>
								<input class="form-control" name="pid[]" type="text" pattern="(?:[0-9a-f]{1,})(?:[-]{1})(?:[0-9a-f]{1,})" title="দয়া করে আইডি দিয়ে ঘরটি পুরন করুন" required> <!-- was type="number" -->
							</td>
							<td>
								<span class="descr"></span>
								<input class="form-control" name="descr[]" type="hidden">
								<button class="btn btn-info btn-sm pull-right">স্টক : <span class="badge badge-default stock">..</span>
									<i class="fa fa-picture-o fa-2x fa-fw cur viewImg"></i>
								</button>
							</td>
							<td>
								<input class="form-control" name="qty[]" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required>
							</td>
							<td>
								<input class="form-control" name="cpDoz[]" type="text" readonly>
							</td>
							<td>
								<!-- weighted price -->
								<span class="weightedCp">
								</span>
								<button class="close close-btn del-row-btn" type="button">&times;</button>
							</td>
						</tr>
						<tr class="last-row">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<!-- subtotal 1 -->
							<td>মোট দাম</td>
							<td>
								<span class="subtotal"></span>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>সাবেক বাকি</td>
							<td><input class="form-control prevDue" readonly></td>
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
							<td>নতুন বাকি</td>
							<td>
								<input class="form-control" name="due" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" readonly required>
							</td>
						</tr>		


					</table>
					<div class="br"></div>
					<span class="btn btn-warning btn-lg fixed-bottom-right pseudo-submit">বিক্রি</span>
					<input type="submit" id="submit" class="hidden">
					<span class="btn btn-info btn-lg new-line fixed-bottom-left">নতুন লাইন</span>
				</form>
            </div> <!--panel body ends -->
        </div>
    </div>
</div> <!-- panel ends -->
<!--=================================
||       scripts
=================================-->
<!-- functions can be called as long as its declared beforewards (in any file) -->
<script type="text/javascript" src="js/plugins/custom/utility/globalUtility.js"></script>
<script type="text/javascript" src="js/plugins/custom/inputRestrictor.js"></script>
<script type="text/javascript" src="js/plugins/custom/setDate.js"></script>
<script type="text/javascript" src="js/plugins/custom/utility/purchaseReturnUtility.js"></script>
<script type="text/javascript" src="js/purchaseReturnScript.js"></script>
<!-- end of scripts -->
<?php include('template/blankEnd.php');?>