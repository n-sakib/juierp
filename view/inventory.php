<?php  
    $mojud ="selected"; 
    include('template/blankStart.php');?>
<link rel="stylesheet" href="../view/template/css/table-panel.css">
<script type="text/javascript" src="../view/template/js/jquery.tablesorter.js"></script> 

<script>
	$(document).ready(function() 
	    { 
	        $("#myTable").tablesorter(); 
	    } 
	);
</script>
<?php include('../view/sections/inventory-nav.php');?>

<?php 
 ?>

<!-- panel start -->
<hr>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1 class="panel-title text-center">মজুদ</h1>
            </div>
            <div class="panel-body">
            	<!-- panel body -->
            	<?php 
            		include_once '../model/inventory.php';
            		inventory::show(1);
            	 ?>
					<div class="br"></div>
            </div> <!--panel body ends -->
        </div>
    </div>
</div> <!-- panel ends -->


<script type="text/javascript" src="js/inventoryScript.js"></script>
<?php include('template/blankEnd.php');?>