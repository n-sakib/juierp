<?php include('template/blankStart.php');?>
<script type="text/javascript" src="js/test.js"></script>

<?php 
    // session_start(); //need to start the session
    // echo $_SESSION['user'];
    
    // include_once (dirname(__FILE__)."/../model/lib/util.php");
    // $qry = db("select * from inventory");
    // foreach($qry as $was)
    // {
    // 	echo "pid are $was[pid]";
    // }
    include_once (dirname(__FILE__)."/../model/inventory.php");
    include_once (dirname(__FILE__)."/../model/lib/util.php");
    include_once (dirname(__FILE__)."/../model/productCategory.php");

    //$categ = new productCategory("new category","","");
    productCategory::showTree();
    

 ?>
    <ul>
        <li>
            <input class="input" type="text">
            <span class="addEntry fa fa-plus-square fa-2x cur"></span>
        </li>
    </ul>


<script>
    
</script>
<?php include('template/blankEnd.php');?>