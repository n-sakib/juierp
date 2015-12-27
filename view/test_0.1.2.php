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
            <input class="" type="text" data-tableIndex="" readonly>
            <span class="edit fa fa-edit fa-2 cur"></span>
            <span class="delete fa fa-trash-o fa-2 cur"></span>
            <span class="addSub fa fa-cogs fa-2 cur"></span>
        </li>
        <li>
            <input class="" type="text">
            <span class="addEntry fa fa-plus-square fa-2 cur"></span>
        </li>
    </ul>


<button class="button btn btn-primary">button</button>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(".button").click(function(){
        alert("this whole thing");
        $('#myModal').modal('show');
    });
    $(document).on("click",".addSub",function () {    
        $('#myModal').modal('show');
        $('<ul> <li> <input class="" type="text" data-tableIndex="" readonly> <span class="edit fa fa-edit fa-2 cur"></span> <span class="delete fa fa-trash-o fa-2 cur"></span> <span class="addSub fa fa-cogs fa-2 cur"></span> </li> <li> <input class="" type="text"> <span class="addEntry fa fa-plus-square fa-2 cur"></span> </li> </ul>').insertAfter(this); 
    });
</script>
<?php include('template/blankEnd.php');?>