//functions
// named as pagename<suffix>Utility</suffix>.js
function updateRowIndexOf(productEntryRowClassSelector){ //is .product-col
	index = 1;
    $(productEntryRowClassSelector).each(function(){
        $(this).children().first().text(index);
        index++;
    });
}
updateRowIndexOf(".products-coll");
/**
 * checks if the client name is empty
 * requires following html element with
 * class="clientName"
 * 			<label for="clientName">পার্টি নাম :</label>
					<input class="form-control txt-in-head clientName" name="clientName" list="clientNames" type="text">
					
 * @return {[type]} [description]
 */
function emptyField(selector){
	if($(selector).val()=="")
	{
		return true;
	}
	//else
	return false;
}

// function oldPid(pidElement){
//    	pid = $(pidElement).val();
//    	var url = '../model/ajaxHandlers/sell.php';
//     var vars = "variable=variable"+"&function=inventoryHas"+"&pid="+pid;
    
//     var request = $.ajax({
//         async:false,
//         url: url,
//         type: 'POST',
//         data: vars,
//         dataType: "text"
//         // ,
//         // done: function(inventoryHas) {
//         // 	console.log("../model/ajaxHandlers/sell.php returned "+inventoryHas)
//         //     if(inventoryHas == 'true')
//         //     {
//         //     	return true;
//         //     }
//         //     	return false;
//         // }
//     });

//     // success: function(jsonData) {
//     //         isLoggedIn = jsonData.LoggedIn
//     //     }
    
//     //the page returns the new entry index
//     //
//     request.done(function(inventoryHas) {
//     	console.log("../model/ajaxHandlers/sell.php returned "+inventoryHas)
//         if(inventoryHas == 'true')
//         {
//         	return true;
//         }
//         	return false;
//     });
// }
function disableNameEntry()
    {        
        rows = $(".products-coll").length;
        if(rows > 1)
        {
            $(".clientName").attr("readonly","");    
        }
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
/*=============================================
//	calculating prices and others
==============================================*/
function calculateTotal()
    {
        calculateWeightedSp();
        generateSubtotal();
        generateComm();
        generateDue();

    }
    function calculateWeightedSp()
    {
        $( ".products-coll" ).each(function( i ) {
            qty = $(this).children("td:nth-child(4)").children("input[name='qty[]']").val();//validated by copying unique selector removing all the classes of the html element
            sp = $(this).children("td:nth-child(5)").children("input[name='sp[]']").val();
            //printElem($(this).children("td:nth-child(4)").children("input[name='sp[]']"));
            weightedSp = noNaN(parseInt(qty*sp));
            // alert(weightedSp);
            $(this).children("td:nth-child(6)").children(".weightedSp").html(weightedSp);
            //printElem($(this).children("td:nth-child(6)").children(".weightedSp"));
          });
    }
    function generateSubtotal()
    {
        subTotalPrice = 0;
        $(".weightedSp").each(function(){
            weightedSp = noNaN(parseInt($(this).text()));
            //alert(subTotalPrice);
            subTotalPrice = subTotalPrice + weightedSp;
        });
        $(".subtotal").html(subTotalPrice);
    }
    function generateComm(){
    	subtotal = noNaN(parseInt($(".subtotal").html()));
    	commPerc = noNaN(parseInt($("input[name='commPerc']").val()));
    	//printElem($(".commAm"));
    	commAm = parseInt(subtotal*commPerc*0.01);
    	$(".commAm").html(commAm);
    	spExclComm = subtotal - commAm;
    	$(".spExclComm").html(spExclComm);
    }
    // specially called when the other infos are entried
    function generateDue()
    {
        //making sure the subtotal is already there
    	subtotal = noNaN(parseInt($(".subtotal").html()));
    	$(".subtotal").html(subtotal);
    		
    	generateComm();
        prevDue = noNaN(parseInt($(".prevDue").html()));//rounds the due
        	$(".prevDue").html(prevDue);

    	spExclComm = noNaN(parseInt($(".spExclComm").html()));	
        totalCredit = spExclComm + prevDue;
        $(".totalCredit").html(totalCredit);

        //taking the inputs
        extraCost = noNaN(parseInt($("input[name='extraCost']").val()));
        shippingCost = noNaN(parseInt($("input[name='shippingCost']").val()));
        discount = noNaN(parseInt($("input[name='discount']").val()));
        paid = noNaN(parseInt($("input[name='paid']").val()));

        due = totalCredit - extraCost + shippingCost - discount - paid;
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
/* *** end of calculating prices and others *** */   


