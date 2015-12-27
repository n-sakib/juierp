<?php include('template/blankStart.php');?>
<!-- <script type="text/javascript" src="js/descrGenScript.js"></script> -->

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
    
    //include('sections/descr-gen.php');

    //include('sections/descr-gen.php');
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

    <?php 

      // $number = 11;
      // $numberHex = dechex($number);
      // echo "number hex is $numberHex";
      if($_FILES)//post is irrelevant
      {
        echo "<p>here</p>";
        uploadPhoto("image", "newFile");
        echo "<p>your file is uploaded</p>";
      }
      echo "<p> here</p>";
      print_r($_POST);
     ?>
      <form action="test.php" method="post" enctype="multipart/form-data">
        upload photo
        <input type="file" name="image">
        <input type="submit">
      </form>
<script>
  
function fn1(pid) {
    setTimeout(function() {
        printMsg();
    } , 0);
    function printMsg(){
            console.log("**warning 1** : " + pid);
    }
}
function fn2(pidVal){
    dfr = $.Deferred();
    setTimeout(function() {
        printBar();
    } , 1500);
    setTimeout(function() {
        request_done_printmsg();
    } , 2000);
    setTimeout(function() {
        printBar();
    } , 2500);
    
    //alternative for request.done
    function request_done_printmsg(){
        console.log("warning 2 : "+ pidVal);
        withData  = pidVal;      
        dfr.resolve(withData);
    }
    function printBar(){
        console.log("========");
    }
    return dfr;
}
fn = fn2(32);
// fn = fn(5); // whoa... two level ajax deferration


// $.when(dfObject) takes dfObject
// hence the function must return a 
// dfr object
// still have this limitation
$.when(fn).then(function(pid){

    fn1(2*pid)
});

function ajaxFunction()
{
   
   setTimeout(function() {
        console.log("2.5 sec ajax function");
    
        return true;
    } , 2500);
}

function isInInventory()
{
   console.log("**tick**");
   setTimeout(function() {
        console.log("**tick**");
    } , 1000);
   // setTimeout(function() {
   //      console.log("**tick**");
   //  } , 1000);
   setTimeout(function() {
        console.log("**tick**");
    } , 2000);
   setTimeout(function() {
        console.log("2.9 sec ajax function");
    } , 2900);
   return true;
}
//need to git
// if(ajaxFunction()){
//   console.log('true returned');
// }




</script>
<?php include('template/blankEnd.php');?>