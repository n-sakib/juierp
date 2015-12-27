<?php 
	$kena ="selected"; 
	include('template/blankStart.php');?>
<link rel="stylesheet" href="../view/template/css/table-panel.css">
<script type="text/javascript" src="js/purchaseScript.js"></script>
<script type="text/javascript" src="js/descrGenScript.js"></script>
<?php include_once '../view/sections/purchase_nav.php'; 

	if($_POST)
	{
		include_once(dirname(__FILE__)."/../model/purchase.php");
		$purchase = new Purchase("$_POST[factoryName]");
		$purchase->makePurchase();
		
		//factoryr against ae purchase and purchase memo banabe
		//and inventory barabe

	}
 ?>
<!-- panel start -->
<hr>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1 class="panel-title text-center">মাল কেনা</h1>
            </div>
            <div class="panel-body">
            	<!-- panel body -->
                <form action="purchase.php" method="post">
					<br>
					<label for="factoryName">কারখানা নাম :</label>
					<input class="form-control txt-in-head factoryName" name="factoryName" list="factoryNames" type="text">
					<?php 
						include_once(dirname(__FILE__)."/../model/factory.php");
						Factory::getOptions(); 
					?>
					<span class="divider-vertical"></span>
					
					<label for="date">তারিখ :</label>
					<input class="form-control txt-in-head" name="date" type="date">
					
					<hr>
					<table class="table-panel -table-striped">
						<tr>
							<th  style="width:4%;">#</th>
							<th>আইডি</th>
							<th>বিবরণ</th>
							<th style="width:10%;">ছবি</th>
							<th>পরিমান (জোড়া)</th>
							<th>গায়ের দাম (জোড়া)</th>
							<th>মুল্য (ডজন)</th>
							<th>হিসাব</th>
						</tr>
						<tr class="products-coll">
							<td></td>
							<td>
								<input name="pid[]" class="form-control" type="text">
							</td>
							<td>
								<div class="descrGen col-lg-6">
								  <input type="text" class="input input-sm pCateg pull-left" list="categNames" >
								  <?php //productCategory::getCategOptions(); ?>
								  <input type="text" class="input input-sm pSubcateg pull-left" list="subcategNames" >
								  <datalist id="subcategNames" class="subcategNames"> <!-- class name provided just for modularity, id name is the required spec -->
								  </datalist>
								  <input type="text" class="input input-sm pColor pull-left" list="colorNames" >
								  <?php //productCategory::getColorOptions(); ?>
								  <input type="text" class="btn btn-danger descr" name="descr[]" readonly>
								</div>
							</td>
							<td>
								<input name="img[]" class="btn" type="file">
							</td>
							<td>
								<input name="qty[]" class="form-control subToPrice" type="text">
							</td>
							<td>
								<input name="sp[]" class="form-control" type="text">
							</td>
							<td>
								<input name="cpDoz[]" class="form-control" type="text">
							</td>
							<td>
								<span class="sub-price"></span>
								<button class="close close-btn" type="button">×</button>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>মোট জোড়াঃ</td>
							<td>
								<span class="totalQty"></span>
							</td>
							<td></td>
							<td>মোট মুল্য</td>
							<td><input name="rawTotal" class="form-control" type="text" readonly></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
							</td>
							<td></td>
							<td>সাবেক</td>
							<td><input name="prevDue" class="form-control prevDue" type="text" readonly></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>মোট পাওনা</td>
							<td><input name="totalAmount" class="form-control" type="text" readonly></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>তাগাদা</td>
							<td><input name="paid" class="form-control" type="text"></td>
						</tr>
						<tr>
							<td>
								কমেন্ট
							</td>
							<td>
								<input name="comment" class="form-control" type="text" readonly>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>বাকি</td>
							<td><input name="due" class="form-control" type="text" readonly></td>
						</tr>						
					</table>
					<div class="br"></div>
					<input type="submit" value="কিনুন" class="btn btn-primary btn-lg pull-right">
					<span class="btn btn-info btn-lg new-line">নতুন লাইন</span>
				</form>
            </div> <!--panel body ends -->
        </div>
    </div>
</div> <!-- panel ends -->
<?php include('template/blankEnd.php');?>