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

    $categ = new productCategory();
    

 ?>
    <ul>
        <li>
            <input class="input" type="text" data-tableIndex="" readonly>
            <span class="edit fa fa-edit fa-2 cur"></span>
            <span class="delete fa fa-trash-o fa-2 cur"></span>
            <span class="addSub fa fa-cogs fa-2 cur"></span>
        </li>
        <li>
            <input class="input" type="text">
            <span class="addEntry fa fa-plus-square fa-2 cur"></span>
        </li>
    </ul>


<script>
    $(".button").click(function(){
        alert("this whole thing");
    });
    $(document).on("click",".addSub",function () {    
        $('<ul> <li> <input class="input" type="text" data-tableIndex="" readonly> <span class="edit fa fa-edit fa-2 cur"></span> <span class="delete fa fa-trash-o fa-2 cur"></span> <span class="addSub fa fa-cogs fa-2 cur"></span> </li> <li> <input class="input" type="text"> <span class="addEntry fa fa-plus-square fa-2 cur"></span> </li> </ul>').insertAfter(this); 
    });
    $(document).on("click",".addEntry",function () {    
       textIn = $(this).siblings(".input").val();
       $('<li>'+textIn+'<span class="edit fa fa-edit fa-2 cur"></span> <span class="delete fa fa-trash-o fa-2 cur"></span> <span class="addSub fa fa-cogs fa-2 cur"></span> </li>').insertBefore($(this).parent()); 
    });
</script>
<?php include('template/blankEnd.php');?>