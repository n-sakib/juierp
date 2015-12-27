/*=============================================
//    factory name input helpers
==============================================*/

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
/* *** end of factory name input helpers *** */    



/*=============================================
//    pid helper funtions  
==============================================*/

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
function itIsFactories(pid)
{
	factoryIndexReference = $(".factoryName").attr("data-index");
    
    factoryIndex = parseFactoryCode(pid);
    //alert("factoryIndex"+factoryIndex+"==factoryIndexReference"+factoryIndexReference);
    if(factoryIndex == factoryIndexReference)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function inventoryHas(pid,pidElement)
{
    var url = '../model/ajaxHandlers/purchase.php';
    var vars = "variable=variable"+"&function=inventoryHas"+"&pid="+pid;
    
    var request = $.ajax({
        url: url,
        type: 'POST',
        data: vars,
        dataType: "text"
    });
    
    //the page returns the new entry index
    request.done(function(msg){
    	//console.log(msg);
        if(msg=="yes")
        {
        	descr = descrOf(pid,pidElement);
			$(pidElement).parent().next().find(".descr").val(descr);
        	return true;
        }
        else if (msg == "no")
        {
        	return false;
        }
    });
}
function pageHasPid(pidVal)
{
    occurance = 0;
    $("input[name='pid[]']").each(function(){
        if($(this).val()==pidVal)
        {   
            occurance++;
        }
    });
    if(occurance>1)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function descrOf(pid,pidElement)
{
    var url = '../model/ajaxHandlers/sell.php';
    var vars = "variable=variable"+"&function=getPidInfo"+"&pid="+pid;
    
    var request = $.ajax({
        url: url,
        type: 'POST',
        data: vars,
        dataType: "text"
    });
    
    //the page returns the new entry index
    request.done(function(info){
        console.log(info);
        info = $.parseJSON( info );
    	//console.log(descr);
    	// $(pidElement).parent().parent().next().find(".descr").val(descr);
    	// $(pidElement).parent().parent().next().find(".descr").focus();

        // $(pidElement).parent().parent().find("input[name='sp[]']").val(info.sp);
        $(pidElement).parent().parent().find(".descr").html(info.descr);
        $(pidElement).parent().parent().find("input[name='cpDoz[]']").val(info.cpDoz);

        //alert($(pidElement).parent().next().find("input[name='sp[]']").html());
        //
        $(pidElement).parent().parent().find("input[name='qty[]']").attr("min","1");
        $(pidElement).parent().parent().find("input[name='qty[]']").attr("max",info.qty);

        $(pidElement).parent().parent().find(".stock").html(info.qty);
        //calculateTotal();
    	//$(pidElement).parent().parent().find("input[name='qty[]']").focus();

        if(pageHasPid($(pidElement).val()))
        {
            $(pidElement).val("");

            $(pidElement).parent().parent().find("input[name='sp[]']").val("");
            $(pidElement).parent().parent().find(".descr").html("");

            $(pidElement).parent().parent().find("input[name='qty[]']").attr("min","0");
            $(pidElement).parent().parent().find("input[name='qty[]']").attr("max","0");

            $(pidElement).parent().parent().find(".stock").html("..");
        }
    	return descr;
    });
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
/* *** end of pid helper funtions   *** */    

/*=============================================
//    calculation of due
==============================================*/
function calculatedWeightedPrice()
{
    totalPrice = 0;

    $(".products-coll").each(function(){
        qty = $(this).find("input[name='qty[]']").val();
        cpDoz = $(this).find("input[name='cpDoz[]']").val();
        wtdPrice = parseInt(qty*cpDoz/12);
        $(this).find(".weightedCp").html(wtdPrice);

        totalPrice = totalPrice + wtdPrice;
    });

    $('.subtotal').html(totalPrice);
}
function calculateTotalPrice()
{
    totalPrice = 0;
    $(".products-coll").each(function(){
        qty = $(this).find("input[name='qty[]']").val();
        cpDoz = $(this).find("input[name='cpDoz[]']").val();
        wtdPrice = parseInt(qty*cpDoz/12);

        totalPrice = totalPrice + wtdPrice;
    });
    $('.subtotal').html(totalPrice);
}
function calculateDue()
{
    calculatedWeightedPrice();

    subtotal = $('.subtotal').html();
    prevDue = $('.prevDue').val();

    newDue = prevDue - subtotal;

    $('input[name="due"]').val(newDue);
}
/* *** end of calculation of due *** */    

    /*=============================================
    //  helpers
    ==============================================*/
    function updateRowIndexOf(productEntryRowClassSelector){ //is .product-col
        index = 1;
        $(productEntryRowClassSelector).each(function(){
            $(this).children().first().text(index);
            index++;
        });
    }
    updateRowIndexOf(".products-coll");

    function emptyField(selector){
        if($(selector).val()=="")
        {
            return true;
        }
        //else
        return false;
    }
    /* *** end of helpers *** */    