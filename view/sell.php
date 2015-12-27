<?php
	$bikri ="selected"; 
	include('template/blankStart.php');?>
<link rel="stylesheet" href="../view/template/css/table-panel.css">
<?php include_once '../view/sections/sell-nav.php'; 
	include('sections/modals/sell-modals.php');

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
                <form action="sell.php" method="post">
					<br>
					<label for="clientName">পার্টি নাম :</label>
					<input class="form-control txt-in-head clientName" name="clientName" list="clientNames" type="text" required>
					<?php Client::getOptions(); ?>					
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
							<th style="width:15%;">জোড়া দাম</th>
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
								<input class="form-control" name="sp[]" type="text" readonly>
							</td>
							<td>
								<!-- weighted price -->
								<span class="weightedSp">
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
							<td>কমিশন</td>
							<td>
								<div class="form-group input-group">
									<input name="commPerc" class="form-control"  type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required>
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
							<td>
								<span class="commAm"></span>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>কমিশন ছাড়া দাম</td>
							<td>
								<span class="spExclComm"></span>
							</td>
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
							<td>
								<span class="totalCredit"></span><!-- total credit of the client -->
							</td>
						</tr>
						<tr>
							<td></td>
							<td>এক্সট্রা খরচ</td>
							<td>এক্সট্রা খরচ বিবরণ</td>
							<td>
								<input class="form-control" name="extraCostDescr" type="text">
							</td>
							<td>এক্সট্রা খরচ বাবদ</td>
							<td>
								<input class="form-control" name="extraCost" type="text" title="শুধুমাত্র সংখ্যা এন্ট্রি গ্রহণযোগ্য"pattern="(?:\d*\.)?\d+">
							</td>
						</tr>		
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>পাঠানো খরচ</td>
							<td>
								<input class="form-control" name="shippingCost" type="text" title="শুধুমাত্র সংখ্যা এন্ট্রি গ্রহণযোগ্য"pattern="(?:\d*\.)?\d+">
							</td>
						</tr>	
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>ডিস্কাউন্ট</td>
							<td>
								<input class="form-control" name="discount" type="text" title="শুধুমাত্র সংখ্যা এন্ট্রি গ্রহণযোগ্য"pattern="(?:\d*\.)?\d+">
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>জমা</td>
							<td>
								<input class="form-control" name="paid" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required>
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
							<td>মোট বাকি</td>
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
<script type="text/javascript" src="js/plugins/custom/utility/sellUtility.js"></script>
<script type="text/javascript" src="js/sellScript.js"></script>
<!-- end of scripts -->
<?php include('template/blankEnd.php');?>