<?php 
	$kena ="selected"; 
	include('template/blankStart.php');?>

<!-- plugins -->
<script type="text/javascript" src="js/plugins/jquery.autosize.min.js"></script>
<!-- scripts -->
<link rel="stylesheet" href="../view/template/css/table-panel.css">
<script type="text/javascript" src="js/purchaseScript.js"></script>
<script type="text/javascript" src="js/purchaseScript_extension01.js"></script>
<script type="text/javascript" src="js/descrGenScript.js"></script>
<?php include_once '../view/sections/purchase_nav.php';
	include('sections/modals/purchase-modals.php'); 

	if($_POST)
	{
		include_once(dirname(__FILE__)."/../model/purchase.php");
		$purchase = new Purchase("$_POST[factoryName]");
		$purchase->makePurchase();
		echo '<span id="success"></span>';
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
                <form action="purchase.php" method="post" enctype="multipart/form-data">
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
					<hr>
					<table class="table-panel -table-striped">
						<tr>
							<th class="text-center" style="width:5%;">#</th>
							<th class="text-center" style="width:10%;" >আইডি</th>
							<th class="text-center" style="width:40%;">বিবরণ</th>
							<th class="text-center"style="width:5%;">ছবি</th>
							<th class="text-center" style="width:10%;" >পরিমান (জোড়া)</th>
							<th class="text-center" style="width:10%;" >গায়ের দাম (জোড়া)</th>
							<th class="text-center" style="width:10%;" >মুল্য (ডজন)</th>
							<th class="text-center" style="width:10%;" >হিসাব</th>
						</tr>
						<tr class="products-coll">
							<td></td>
							<td>
								<input name="pid[]" class="form-control pid" type="text" pattern="(?:[0-9a-f]{1,})(?:[-]{1})(?:[0-9a-f]{1,})" title="দয়া করে আইডি দিয়ে ঘরটি পুরন করুন" required>
							</td>
							<td>
								<div class="descrGen col-lg-12">
								  <input type="text" class="input input30 pCateg pull-left" list="categNames" >
								  
								  <input type="text" class="input input30 pSubcateg pull-left" list="subcategNames" >
								  <datalist id="subcategNames" class="subcategNames"> <!-- class name provided just for modularity, id name is the required spec -->
								  </datalist>
								  <input type="text" class="input input30 pColor pull-left" list="colorNames" >
								  
								  <textarea type="text" class="input input-sm descr" name="descr[]" readonly></textarea>
								</div>
							</td>
							<td>
								<!-- <img src="" alt="ছবি দিন" class="img-thumb"> -->
								<!-- <i class="fa fa-camera fa-lg text-center pseudo-image-upload cur"></i> -->
								<span class="fa fa-camera fa-lg text-center pseudo-image-upload cur"></span>
								<input name="img[]" class="btn hidden" type="file">
								<image id="list"></image>
							</td>
							<td>
								<input name="qty[]" class="form-control subToPrice" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required>
							</td>
							<td>
								<input name="sp[]" class="form-control" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required>
							</td>
							<td>
								<input name="cpDoz[]" class="form-control" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন">
							</td>
							<td>
								<span class="sub-price"></span>
								<button class="close close-btn close-btn-first" type="button">×</button>
							</td>
						</tr>
						<tr class="last-row">
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
							<td><input name="paid" class="form-control" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required></td>
						</tr>
						<tr>
							<td>
								কমেন্ট
							</td>
							<td>
								<input name="comment" class="form-control" type="text" >
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
					<span class="btn btn-warning btn-lg fixed-bottom-right pseudo-submit">কিনুন</span>
					<input type="submit" id="submit" class="btn btn-primary btn-lg pull-right hidden" value="কিনুন">
					<span class="btn btn-info btn-lg new-line fixed-bottom-left">নতুন লাইন</span>
				</form>
            </div> <!--panel body ends -->
        </div>
    </div>
</div> <!-- panel ends -->

<!-- functions can be called as long as its declared beforewards (in any file) -->
<script type="text/javascript" src="js/plugins/custom/-inputRestrictor.js"></script>
<script type="text/javascript" src="js/plugins/custom/-setDate.js"></script>
<script type="text/javascript" src="js/plugins/custom/utility/-purchaseUtility.js"></script>
<script type="text/javascript" src="js/plugins/custom/utility/globalUtility.js"></script>
<!-- end of scripts -->
<?php include('template/blankEnd.php');?> 