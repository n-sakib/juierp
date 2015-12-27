<?php include('template/blankStart.php');?>
<script type="text/javascript" src="js/descrGenScript.js"></script>

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

    $categ = new productCategory("new category","","");
    //productCategory::showSubCateg();
    
    include('sections/descr-gen.php');

    include('sections/descr-gen.php');
 ?>

   <!--  <div class="descrGen col-lg-6">
      <input type="text" class="input input-sm pCateg pull-left" list="categNames" >
      <?php productCategory::getCategOptions(); ?>
      <input type="text" class="input input-sm pSubcateg pull-left" list="subcategNames" >
      <datalist id="subcategNames">
      </datalist>
      <input type="text" class="input input-sm pColor pull-left" list="colorNames" >
      <?php productCategory::getColorOptions(); ?>
      <input type="text" class="btn btn-primary descr" readonly>
    </div> -->

<script>
</script>
<?php include('template/blankEnd.php');?>