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

 <!--=================================
 modals
 =================================-->
 <div class="modal fade" id="factoryNameWarningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h1 class="modal-title text-center text-alert">সাবধান!</h1>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-warning">কারখানার নামটি সিলেক্ট করা নেই</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">ওকে</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- delete confirm modal -->
<div class="modal fade" id="delConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h1 class="modal-title text-center text-alert">অনুমোদন করুন</h1>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-warning">আপনি কি এন্ট্রিটি ডিলেট করতে চান?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal" id="modal-del-btn">হ্যাঁ</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">না</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- submission confirm modal -->
<div class="modal fade" id="submitConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h1 class="modal-title text-center text-info">অনুমোদন করুন</h1>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-default">আপনি কি বিক্রয়টি অনুমোদন করবেন?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" id="modal-sub-btn">হ্যাঁ</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">না</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- success modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h1 class="modal-title text-center text-primary">ক্রয় সম্পন্ন</h1>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-success">মাল ক্রয় সফল</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ধন্যবাদ</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- error modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h1 class="modal-title text-center text-warning">সাবধান!!!!</h1>
      </div>
      <div class="modal-body text-center">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ওকে</button>
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
								<input name="pid[]" class="form-control pid" type="text">
							</td>
							<td>
								<div class="descrGen col-lg-6">
								  <input type="text" class="input input-sm pCateg pull-left" list="categNames" >
								  
								  <input type="text" class="input input-sm pSubcateg pull-left" list="subcategNames" >
								  <datalist id="subcategNames" class="subcategNames"> <!-- class name provided just for modularity, id name is the required spec -->
								  </datalist>
								  <input type="text" class="input input-sm pColor pull-left" list="colorNames" >
								  
								  <textarea type="text" class="input input-sm descr" name="descr[]" readonly></textarea>
								</div>
							</td>
							<td>
								<!-- <div class="thumbnail">
									<img class="thumbnail-img" src="" 
         								alt="Generic placeholder thumbnail">
								</div> -->
								<span class="fa fa-camera fa-lg pseudo-image-upload cur"></span>
								<input name="img[]" class="btn hidden" type="file">
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
							<td><input name="paid" class="form-control" type="text"></td>
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
					<input type="submit" id="submit" class="btn btn-primary btn-lg pull-right hidden" value="কিনুন" class="">
					<span class="btn btn-info btn-lg new-line fixed-bottom-left">নতুন লাইন</span>
				</form>
            </div> <!--panel body ends -->
        </div>
    </div>
</div> <!-- panel ends -->
<?php include('template/blankEnd.php');?> 