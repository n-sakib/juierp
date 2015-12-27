<?php include('template/blankStart.php');?>
<?php 
include_once '../model/productCategory.php';

$category = new productCategory();
 ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title text-center">ক্যাটেগরি</h3>
            </div>
            <div class="panel-body">
            	<h3 class="text-center">নতুন ক্যাটেগরি যোগ করুন</h3>
<!--             	<form action="inventory-category.php" method="post"> -->
            		<ul>
                        <li data-lvl="lvl1">
                            <span>Level 1</span>
                            <i class="edit fa fa-pencil fa-lg cur"></i>
                            <i class="delete fa fa-trash-o fa-lg cur"></i>  

                            <ul>
                                <li data-lvl="lvl2">
                                    <span>Level 2</span>
                                    <i class="edit fa fa-pencil fa-lg cur"></i>
                                    <i class="delete fa fa-trash-o fa-lg cur"></i>  
                                    
                                    <ul class="level3">
                                        <li data-lvl="lvl3">
                                            <span>Level 3</span>
                                            <i class="edit fa fa-pencil fa-lg cur"></i>
                                            <i class="delete fa fa-trash-o fa-lg cur"></i>  
                                        </li>
                                        <li data-lvl="lvl3">
                                            <input type="text">
                                            <i class="addBtn fa fa-plus-square fa-lg cur"></i>
                                        </li>
                                    </ul>       
                                </li>
                                <li data-lvl="lvl2">
                                    <input type="text">
                                    <i class="addBtn fa fa-plus-square fa-lg cur"></i>
                                </li>
                            </ul>
                        </li>
                        <li data-lvl="lvl1">
                            <input type="text">
                            <i class="addBtn fa fa-plus-square fa-lg cur"></i>
                        </li>
                    </ul>

                    <?php 
                    include_once'../model/productCategory.php';

                    echo ProductCategory::getAllTree();                    
                     ?>
            	<!-- </form> -->
            </div>
        </div>
    </div>
</div>
<script>
    function addItems()
    {
        $(".addBtn").click(function() {
            var textIn = $(this).prev().val();
            var lastLine = $(this).parent();
            if(textIn != '')//pseudo fixed
            {
                var categLvl = $(this).parent().attr("data-lvl");//li //level data that is to be fetched from every list element
                
                if(categLvl == 'lvl3')
                {
                    addLvl3($(this),textIn);
                }
                if(categLvl == 'lvl2')
                {
                    addLvl2($(this),textIn);
                }
                if(categLvl == 'lvl1')
                {                   
                    addLvl1($(this),textIn);
                }
            }
            $(this).prev().val('');           
        });
    }

    function addLvl3(clickedBtn, textIn)
    {
        $("<li>"+textIn+"<i class=\"edit fa fa-pencil fa-lg cur\"></i> <i class=\"delete fa fa-trash-o fa-lg cur\"></i></li>").insertBefore($(clickedBtn).parent());

        lvl2 = $(clickedBtn).parent().parent().parent().children("span:first").text();//li<ul<li>span        
        lvl1 = $(clickedBtn).parent().parent().parent().parent().parent().children("span:first").text();//li<ul<li<ul<li>span

        var vars = "variable=variable"+"&function=insert"+"&textIn="+textIn+"&lvl=3"+"&lvl1="+lvl1+"&lvl2="+lvl2; //"variable=variable" is just a dummy head for infinite concatenation// alternate if first method is preferred
        var url = '../model/ajaxHandlers/inventoryCategory.php';
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        request.done(function(msg){
            alert(msg);
        });
    }

    function addLvl2(clickedBtn, textIn)
    {
        $("<li>"+textIn+"<i class=\"edit fa fa-pencil fa-lg cur\"></i> <i class=\"delete fa fa-trash-o fa-lg cur\"></i><ul class=\"level3\"><li data-lvl=\"lvl3\"><span>Level 3</span> <i class=\"edit fa fa-pencil fa-lg cur\"></i> <i class=\"delete fa fa-trash-o fa-lg cur\"></i> </li> <li data-lvl=\"lvl3\"> <input type=\"text\"> <button class=\"addBtn\">add</button> </li> </ul></li>").insertBefore($(clickedBtn).parent());
        lvl1 = $(clickedBtn).parent().parent().parent().children("span:first").text();//li<ul<li>span

        var vars = "variable=variable"+"&function=insert"+"&textIn="+textIn+"&lvl=2"+"&lvl1="+lvl1; //"variable=variable" is just a dummy head for infinite concatenation// alternate if first method is preferred
        var url = '../model/ajaxHandlers/inventoryCategory.php';
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        request.done(function(msg){
            alert(msg);
        });
    }

    function addLvl1(clickedBtn, textIn)
    {
        $("<li data-lvl=\"lvl1\"><span>"+textIn+"</span> <i class=\"edit fa fa-pencil fa-lg cur\"></i> <i class=\"delete fa fa-trash-o fa-lg cur\"></i> <ul> <li data-lvl=\"lvl2\"> <span>Level 2</span> <i class=\"edit fa fa-pencil fa-lg cur\"></i> <i class=\"delete fa fa-trash-o fa-lg cur\"></i> <ul class=\"level3\"> <li data-lvl=\"lvl3\"> <span>Level 3</span> <i class=\"edit fa fa-pencil fa-lg cur\"></i> <i class=\"delete fa fa-trash-o fa-lg cur\"></i> </li> <li data-lvl=\"lvl3\"> <input type=\"text\"> <i class=\"addBtn fa fa-plus-square fa-lg cur\"></i> </li> </ul> </li> <li data-lvl=\"lvl2\"> <input type=\"text\"> <i class=\"addBtn fa fa-plus-square fa-lg cur\"></i> </li> </ul> </li>").insertBefore($(clickedBtn).parent());
        var vars = "variable=variable"+"&function=insert"+"&textIn="+textIn+"&lvl=1"; //"variable=variable" is just a dummy head for infinite concatenation// alternate if first method is preferred
        var url = '../model/ajaxHandlers/inventoryCategory.php';
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        request.done(function(msg){
            alert(msg);
        });
    }

    $(document).ready(function() {
        $(".addBtn").click(function() {
            addItems();
            });
    });

</script>
<?php include('template/blankEnd.php');?>