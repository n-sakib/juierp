$(document).ready(function () {
	$(".new-line").click(function(){
		$('<tr class="products-coll"> <td></td> <td> <input name="pid[]" class="form-control" type="text"> </td> <td> <div class="descrGen col-lg-6"> <input type="text" class="input input-sm pCateg pull-left" list="categNames" > <input type="text" class="input input-sm pSubcateg pull-left" list="subcategNames" > <datalist id="subcategNames" class="subcategNames"> <!-- class name provided just for modularity, id name is the required spec --> </datalist> <input type="text" class="input input-sm pColor pull-left" list="colorNames" > <input type="text" class="btn btn-default descr" name="descr[]" readonly> </div> </td> <td> <input name="img[]" class="btn" type="file"> </td> <td> <input name="qty[]" class="form-control subToPrice" type="text"> </td> <td> <input name="sp[]" class="form-control" type="text"> </td> <td> <input name="cpDoz[]" class="form-control" type="text"> </td> <td> <span class="sub-price"></span> <button class="close close-btn" type="button">×</button> </td> </tr>').insertBefore(".last-row"); });

	$(".factoryName").change(function(){ //factoryName class was not set, rather name attribute was set
		//alert($(this).val());
		postPrevDue();
        setfactoryIndex($(this).val());
        //alert("here");
        $(this).attr("readonly","");
        //$(this).removeAttr("readonly");
	});
	function postPrevDue()
	{
		var name = $(".factoryName").val();
        var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=postPrevDue"+"&name="+name;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(postedPrevDue){
            due = postedPrevDue ;
            if(name == "" || due =="")
            {
            	due = 0;
        	}
        	
        	$(".prevDue").val(due);
        	
        	//alert("due is "+due);
        });
	}
    function setfactoryIndex(name)
        var url = '../model/ajaxHandlers/purchase.php';//checked
        var vars = "variable=variable"+"&function=setfactoryIndex"+"&name="+name; //checked
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(postedIndex){
            index = postedIndex ;
            $(".factoryName").attr(index);
            
            //alert("due is "+due);
        });
    }

	$(document).on("click",".pCateg",function(){
        var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=getCategOptions";
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(categOp){
            $(categOp).insertAfter(".pCateg");
        });
    });
    $(document).on("click",".pColor",function(){
        var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=getColorOptions";
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(subColorOp){
            //alert(subColorOp);
            $(subColorOp).insertAfter(".pColor");
        });
    });
});
