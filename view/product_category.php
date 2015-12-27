<?php 
	$mojud ="selected"; 
	include('template/blankStart.php');?>
<script type="text/javascript" src="js/product_categoryScript.js"></script>

<?php 
    // session_start(); //need to start the session
    // echo $_SESSION['user'];
    
    // include_once (dirname(__FILE__)."/../model/lib/util.php");
    // $qry = db("select * from inventory");
    // foreach($qry as $was)
    // {
    //  echo "pid are $was[pid]";
    // }

    //$categ = new productCategory("new category","","");
    
    

 ?>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title text-center">ক্যাটেগরি</h3>
            </div>
            <div class="panel-body">
                <?php 

                    include_once (dirname(__FILE__)."/../model/productCategory.php");
                    productCategory::showTreeR();
                 ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title text-center">কালার</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <?php 
                        productCategory::showColors();
                     ?>
                    <li>
                        <input type="text" class="input colorName">
                        <span class="fa fa-plus-square fa-2x cur addColor"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include('template/blankEnd.php');?>