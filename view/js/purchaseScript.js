$(document).ready( function () {
    //==============================
    //handle events
    //==============================

	$(".new-line").click(function(){
        if($(".factoryName").val()=="")
        {
            $('#factoryNameWarningModal').modal('show');
        }
        else if($(".factoryName").val() != "" && $("input[name='pid[]']").first().val() != "")
        {
            $('<tr class="products-coll"> <td></td> <td> <input name="pid[]" class="form-control" type="text" pattern="(?:[0-9a-f]{1,})(?:[-]{1})(?:[0-9a-f]{1,})" title="দয়া করে আইডি দিয়ে ঘরটি পুরন করুন"></td> <td> <div class="descrGen col-lg-12"> <input type="text" class="input input30 pCateg pull-left" list="categNames" > <input type="text" class="input input30 pSubcateg pull-left" list="subcategNames" > <datalist id="subcategNames" class="subcategNames"> <!-- class name provided just for modularity, id name is the required spec --> </datalist> <input type="text" class="input input30 pColor pull-left" list="colorNames" > <textarea type="text" class="input input-sm descr" name="descr[]" readonly></textarea> </div></td> <td> <span class="fa fa-camera fa-lg pseudo-image-upload cur"></span> <input name="img[]" class="btn hidden" type="file"></td> <td> <input name="qty[]" class="form-control subToPrice" type="text" pattern="(?:\\d*\\.)?\\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required></td> <td> <input name="sp[]" class="form-control" type="text" pattern="(?:\\d*\\.)?\\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required></td> <td> <input name="cpDoz[]" class="form-control" type="text" pattern="(?:\\d*\\.)?\\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন"></td> <td> <span class="sub-price"></span> <button class="close close-btn del" type="button">×</button> </td> </tr>').insertBefore(".last-row"); renewPid(); disableNameEntry();
        }	

       });
    function disableNameEntry()
    {        
        rows = $(".products-coll").length;
        if(rows > 1)
        {
            $(".factoryName").attr("readonly","");    
        }
    }
    $(document).on("click",".del",function(){
        //modal appears
        delBtn = this;
        $('#delConfirmModal').modal('show');
        $('#modal-del-btn').click(function(){
            //alert("delete clicked");
            $(delBtn).parent().parent().remove();

            generateRawTotal();
            generateTotalAmount();
            generateDue();
            
            refactorSerial();

        });
    });
    function refactorSerial()
    {
        //thank god i named each tr with products-col class in the very begining of the project
        index = 1;
        $(".products-coll").each(function(){
            $(this).children().first().text(index);
            //console.log($(this).html());
            index++;
        });
    }
    $(document).on("keydown","input[name='cpDoz[]']",function(event){
        //console.log("keydown keycode is = '"+event.which+"'");
        if (event.which == '9' || event.which == '13') { //event.which == '13' also enter key
            $(".new-line").click();
        }
    });
	$(".factoryName").change(function(){ //factoryName class was not set, rather name attribute was set
		//alert($(this).val());
		if(ifNotInList(this))
        {
            $(this).val("");//repeated from extension tho
        }
        else
        {           
            postPrevDue();
            postFactoryIndex();
            
            renewPid();
            val = $(this).val(); 
        }
	});
    function ifNotInList(inputElement)
    {
        textIn = $(inputElement).val();

        not_ListingState = true;

        //console.log("==============");
        //console.log(textIn);
        //console.log("==============");
        listName = $(inputElement).attr("list");
        $("#"+listName).children("option").each(function(){
            //console.log($(this).val());
            if($(this).val() == textIn)
            {
                //console.log("no")
                not_ListingState = false; //reverse logic tho
            }
        });
        //console.log("yes")
        return not_ListingState;
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
    //total calculation
    //subtotal
    
    $(document).on("keyup input","input[name='qty[]']",function(){
        calculateTotal();
        calculateTotalPair();
    });
    $(document).on("keyup input","input[name='cpDoz[]']",function(){
        calculateTotal();
    });
    $(document).change(function(){
        calculateTotal();
    });
    $(document).on("keyup input", "input[name='paid']",function(){
        generateDue();
    });
    $(document).on("remove", function () {
        calculateTotal();
    });



    //-------------------------------------------
    //functions
    //-------------------------------------------
    function renewPid()
    {
        newPid = $("input[name='pid[]']").last().val();
        renewFromDb();
    }
    function renewFirstPid()
    {
        newPid = $("input[name='pid[]']").first().val();
        if($(".factoryName").val()=="")
        {
            $("input[name='pid[]']").first().val("");
        }
        else
        {
            renewFirstFromDb();
        }
    }

    function renewFromDb()
    {

        var name = $(".factoryName").val();
        var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=renewFromDb"+"&name="+name;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(id){
            newId = id ;

            console.log("db "+newId);
            // $("input[name='pid[]']").last().val(newId);
            
            renewOnPage(newId); //classic callback instead of deferred
        });
    }
     function renewFirstFromDb()
    {

        var name = $(".factoryName").val();
        var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=renewFromDb"+"&name="+name;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(id){
            newId = id ;
            console.log("db "+newId);
            //$("input[name='pid[]']").first().val(newId);
            
            renewFirstOnPage(newId); //classic callback instead of deferred
        });
    }

    function renewOnPage(pid)
    {
        newPid = pid;
        factoryIndex = $(".factoryName").attr("data-index");
        while(itExistsOnPage(newPid))//pid
        {
            shoeIndex = parseShoeIndex(newPid);//pid , wrong variable
            shoeIndex++;


            shoeCode = shoeIndex.toString(16);

            newPid = factoryIndex+"-"+shoeCode;

        }  
        $("input[name='pid[]']").last().val(newPid);
        return newPid;
    }  
    function renewFirstOnPage(pid)
    {
        newPid = pid;
        factoryIndex = $(".factoryName").attr("data-index");
        while(itExistsOnPage(newPid))//pid
        {
            shoeIndex = parseShoeIndex(newPid);//pid , wrong variable
            shoeIndex++;


            shoeCode = shoeIndex.toString(16);

            newPid = factoryIndex+"-"+shoeCode;

        }  
        $("input[name='pid[]']").first().val(newPid);
        console.log(newPid);
        return newPid;
    }  
    function itExistsOnPage(pid)
    {
        found = false;
        if($("input[name='pid[]']").length > 1)
        {
            $("input[name='pid[]']").each(function(){
                //alert("itterating"+pid+"for"+$(this).val());
                if($(this).val() == pid)
                {
                    found = true;
                }
            });   
        }
        //alert("pid "+found);
        return found;
    }
    function ifPidOfThisFactory(pid)
    {
        factoryIndexReference = $(".factoryName").attr("data-index");
        
        factoryIndex = parseFactoryIndex(pid);

        if(factoryIndex == factoryIndexReference)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function postFactoryIndex()
    {
        var name = $(".factoryName").val();
        var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=postFactoryIndex"+"&name="+name;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(postedIndex){
            //index = postedIndex.toString(16) ;
            index = postedIndex;
            $(".factoryName").attr("data-index",index);
        });
    }
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
            //alert(due);
            if(name == "" || due =="")
            {
            	due = 0;
        	}
        	
        	$(".prevDue").val(due);
        	
        	//alert("due is "+due);
        });
	}
	



    //deconding the hexa number
    
    function parseFactoryIndex(pid)
    {
        var info = pid.split("-");
        var factoryIndex = parseInt(info[0], 16);
        return factoryIndex;
    }
    function parseShoeIndex(pid)
    {
        var info = pid.split("-");
        var productIndex = parseInt(info[1], 16);
        return productIndex;
    }
    function parseFactoryCode(pid)
    {
        var info = pid.split("-");
        return info[0];
    }
    function parseShoeCode(pid)
    {
        var info = pid.split("-");
        return info[1];
    }

    
    function calculateTotal()
    {
        calculateSubTotal();
        generateRawTotal();
        generateTotalAmount();
        generateDue();

    }
    function calculateSubTotal()
    {
        $( ".products-coll" ).each(function( i ) {
            qty = $(this).children("td:nth-child(5)").children("input[name='qty[]']").val();//validated by copying unique selector removing all the classes of the html element
            cpDoz = $(this).children("td:nth-child(7)").children("input[name='cpDoz[]']").val();
            subTotalPrice = noNaN(parseInt(qty*cpDoz/12));
            //alert(subTotalPrice);
            $(this).children("td:nth-child(8)").children(".sub-price").text(subTotalPrice);
          });
    }
    function generateRawTotal()
    {
        RawTotalPrice = 0;
        $(".sub-price").each(function(){
            subTotalPrice = noNaN(parseInt($(this).text()));
            //alert(subTotalPrice);
            RawTotalPrice = RawTotalPrice + subTotalPrice;
        });
        $("input[name='rawTotal']").val(RawTotalPrice);
    }
    function generateTotalAmount()
    {
        rawTotal = noNaN(parseInt($("input[name='rawTotal']").val()));
        prevDue = noNaN(parseInt($("input[name='prevDue']").val()));
        totalAmount = rawTotal+prevDue;
        $("input[name='totalAmount']").val(totalAmount);
    }
    function generateDue()
    {
        totalAmount = $("input[name='totalAmount']").val();
        paid = $("input[name='paid']").val();
        due = totalAmount-paid;
        $("input[name='due']").val(due);
    }
    function calculateTotalPair  ()
    {
        totalQty = 0;
        $( "input[name='qty[]']" ).each(function() {
            qty = noNaN(parseInt($(this).val()));//validated by copying unique selector removing all the classes of the html element
            totalQty = totalQty + qty;
          });
        $(".totalQty").text(totalQty);
    }
    /**=============================================
    //  first delete button features
    ==============================================*/
    $(document).on("click",".close-btn-first",function(){
        // /console.log($(this).parent().parent().html());
        $(this).parent().parent().html('<td>1</td> <td> <input name="pid[]" class="form-control pid" type="text"> </td> <td> <div class="descrGen col-lg-6"> <input type="text" class="input input-sm pCateg pull-left" list="categNames" > <input type="text" class="input input-sm pSubcateg pull-left" list="subcategNames" > <datalist id="subcategNames" class="subcategNames"> <!-- class name provided just for modularity, id name is the required spec --> </datalist> <input type="text" class="input input-sm pColor pull-left" list="colorNames" > <textarea type="text" class="input input-sm descr" name="descr[]" readonly></textarea> </div> </td> <td> <span class="fa fa-camera fa-lg pseudo-image-upload cur"></span> <input name="img[]" class="btn hidden" type="file"> </td> <td> <input name="qty[]" class="form-control subToPrice" type="text"> </td> <td> <input name="sp[]" class="form-control" type="text"> </td> <td> <input name="cpDoz[]" class="form-control" type="text"> </td> <td> <span class="sub-price"></span> <button class="close close-btn close-btn-first" type="button">×</button> </td>');
        renewFirstPid();// shows 0-1 as pid when pid is not selected
        //temporary woraround not possible
        // alert($("input[name='pid[]']").first().val());
        // if($("input[name='pid[]']").first().val() == "0-1")
        // {
        //     alert("invalid factoryName");
        // }
    });
    

    //**** end of first delete button features ****

    //========================= //
    //      HELPER functions   // 
    //========================//

    function noNaN(number){
        if(isNaN(number)){
            return 0;
        } else {
            return number;
        }
    }

    function toEnglish(inputField)
    {
        number = $(inputField).val();
        englishNumber = parseBanlgaToEnglish(number);
        $(inputField).val(englishNumber);
    }

    function parseBanlgaToEnglish(number)
    {
        var englishNumber = number;
        
        englishNumber = englishNumber.replaceAll('০', '0');
        englishNumber = englishNumber.replaceAll('১', '1');
        englishNumber = englishNumber.replaceAll('২', '2');
        englishNumber = englishNumber.replaceAll('৩', '3');
        englishNumber = englishNumber.replaceAll('৪', '4');
        englishNumber = englishNumber.replaceAll('৫', '5');
        englishNumber = englishNumber.replaceAll('৬', '6');
        englishNumber = englishNumber.replaceAll('৭', '7');
        englishNumber = englishNumber.replaceAll('৮', '8');
        englishNumber = englishNumber.replaceAll('৯', '9');
        
        return englishNumber;
    }

    //-------------------------------
    // commands
    //-------------------------------
if($("#success").length)
{
    $('#successModal').modal('show');
}

});


