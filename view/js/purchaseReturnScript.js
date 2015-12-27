/*=============================================
//	brief
==============================================*/
// 1.	input factory name
// 	1.2	input date
// 2.	input pid
// 	2.1	generate descr and stock
// 	2.2~ new line
// 3.	input qty
// 	3.2	new line
// 4.-1 new line
// 4.	SUBMIT
/* *** end of brief *** */ 

/*=============================================
//	brief 1.1
==============================================*/
// 1.	input factory name^
// 			[php should echo the datalist(non-ajax)]^
//	 		[should be restricted to the datalist]^
// 			[should generate data-index = factoryCode(hexadecimal) ]^
// 	1.2	input date^
// 			[date-setter custom plugin used]^
// 2.	input pid
// 			[pid input must match the factory code]^ 
// 			[must be in the inventory]^
// 			[no pid cannot be entered twice]^
// 			[needs to be revalidated before submission,
// 						-in exteme cases such as last pid is invalid
// 						-n.b. revalidation might not be necessary
// 						 if qty is set to "required"
// 						- this must be tested by entering pid, and qty
// 							in any given order]
// 	2.1	generate descr and stock^~
// 		2.1.1.	bug fixed a parseInt<noNaN on min max^
// 		2.1.2 	genrate photo 
// 	2.2~ new line^
// 3.	input qty^
// 			[cannot be greater than subsequent stock]^
// 	3.2	new line^
// 4.-2 calculate^
// 			[1. weighted price]^
// 			[2. new due (reduced)]^
// 4.-1 new line
// 4.-1.1 modals
// 4.	SUBMIT
// 
// 5. php

//------------------------------------------------
// 1. "^" suffix indicates the feature is added
// -----------------------------------------------
/* *** end of brief *** */    



$(document).ready(function(){
	/*=============================================
	//	local features
	==============================================*/
		/*=============================================
		//	factory name input process
		==============================================*/
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
	            val = $(this).val(); 
	        }
		});
		/* *** end of factory name input process *** */    
		
		/*=============================================
		//	PID input validation
		==============================================*/
			$(document).on("change","input[name='pid[]']", function(){ //listening to input event makes entry so strict
				pid = $(this).val();
				//console.log("input");
				if(itIsFactories(pid))
				{			
					if(inventoryHas(pid,this)) //needs to be removed
					{
						//console.log("old pid");
						descr = descrOf(pid,this);
						// $(this).parent().next().find(".descr").val(descr);
					}
					else
					{
						//console.log("new pid");
					}
				}
				else
				{
					$(this).val("");

					pidElement = this;
					$(pidElement).parent().parent().find("input[name='sp[]']").val("");
				    $(pidElement).parent().parent().find(".descr").html("");

				    $(pidElement).parent().parent().find("input[name='qty[]']").attr("min","0");
				    $(pidElement).parent().parent().find("input[name='qty[]']").attr("max","0");

				    $(pidElement).parent().parent().find(".stock").html("..");
				    
				}
			});

		/* *** end of PID input validation *** */    
		/*=============================================
		//	qty
		==============================================*/
			$(document).on("change","input[name='qty[]']",function(){
				oldVal = $(this).val(); 
				newVal = toEng(oldVal);

				min =noNaN(parseInt($(this).attr("min")));//bug fixed
				max =noNaN(parseInt($(this).attr("max")));
				$(this).popover('destroy');

				if(newVal >= min && newVal <= max)
				{
					$(this).val(newVal);
				}
				else
				{
					$(this).val("");
					warningMsg = '<p>স্টকে আছে '+max+' টি, 1 থেকে '+max+' এর মধ্যে যেকোনো সংখ্যা এন্ট্রি দিন</p>'
					$(this).popover({trigger:'hover',placement: 'right', content: warningMsg , html: true, delay: { show: 500, hide: 2000 }});
					$(this).popover('show');
					element = this;
					setTimeout(function(){$(element).popover('destroy');},3000);

				}
				console.log('min : '+min+'; max : '+max);
				console.log('oldVal : '+oldVal+'; newVal : '+newVal);
			});
		/* *** end of qty *** */    
						
	/* *** end of local features *** */ 
	/*=============================================
	//	page specific features
	==============================================*/
		/*=============================================
		//	new line btn
		==============================================*/
		$(".new-line").click(function(){
	    if(emptyField(".factoryName"))
	    {
	        $('#FactoryNameWarningModal').modal('show');
	    }
	    else
	    {
	        $('<tr class="products-coll"> <td></td> <td> <input class="form-control" name="pid[]" type="text" pattern="(?:[0-9a-f]{1,})(?:[-]{1})(?:[0-9a-f]{1,})" title="দয়া করে আইডি দিয়ে ঘরটি পুরন করুন" required> </td> <td> <span class="descr"></span> <input class="form-control" name="descr[]" type="hidden"> <button class="btn btn-info btn-sm pull-right">স্টক : <span class="badge badge-default stock">..</span> <i class="fa fa-picture-o fa-2x fa-fw cur viewImg"></i> </button></td> <td> <input class="form-control" name="qty[]" type="text" pattern="(?:\\d*\\.)?\\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required> </td> <td> <input class="form-control" name="sp[]" type="text" readonly> </td> <td> <!-- weighted price --> <span class="weightedSp"> </span> <button class="close close-btn del-row-btn" type="button">&times;</button> </td> </tr>').insertBefore(".last-row"); // renewPid(); updateRowIndexOf(".products-coll"); // disableNameEntry();
			updateRowIndexOf(".products-coll");
			calculatedWeightedPrice()
			//disableNameEntry();
	    }	
		});

		$(document).on("keydown","input[name='cpDoz[]']",function(event){
	        if (event.which == '9' || event.which == '13') { //event.which == '13' also enter key
	            $(".new-line").click();
	        }
	    }); 
		/* *** end of new line btn *** */    
		/*=============================================
		//	del btn
		==============================================*/
		$(document).on("click",".del-row-btn",function(){
		 	delRowBtn = this; 
		 	//alert($(".products-coll").length);
		    //if one row, replace row by emptyrow and reIndex
		    if($(".products-coll").length==1)
		    {
		    	$(delRowBtn).parent().parent().html('<td></td> <td> <input class="form-control" name="pid[]" type="text" pattern="(?:[0-9a-f]{1,})(?:[-]{1})(?:[0-9a-f]{1,})" title="দয়া করে আইডি দিয়ে ঘরটি পুরন করুন" required> <!-- was type="number" --> </td> <td> <span class="descr"></span> <input class="form-control" name="descr[]" type="hidden"> <button class="btn btn-info btn-sm pull-right">স্টক : <span class="badge badge-default stock">..</span> <i class="fa fa-picture-o fa-2x fa-fw cur viewImg"></i> </button> </td> <td> <input class="form-control" name="qty[]" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required> </td> <td> <input class="form-control" name="cpDoz[]" type="text" readonly> </td> <td> <!-- weighted price --> <span class="weightedCp"> </span> <button class="close close-btn del-row-btn" type="button">&times;</button> </td>'); 
		    	updateRowIndexOf(".products-coll");

		    }
		    else //delete row
		    {
		    	$(delRowBtn).parent().parent().remove();
		    	updateRowIndexOf(".products-coll");

		    }
		 });
		/* *** end of del btn *** */    
		
	 	/*=============================================
	 	//	calculation
	 	==============================================*/
	 	
		$(document).on("change keyup", "input[name='qty[]']",function(){
			calculateDue();
		}); 
	 	/* *** end of calculation *** */    
	 	
	 	/*=============================================
	 	//	submission
	 	==============================================*/
	 	$(".pseudo-submit").click(function() {
		// msg = "";
		// msg = getValidationMsgs();
		
		// if (msg == "") {
			$("#submitConfirmModal").modal("show");

			$("#modal-sub-btn").click(function() {
				$("#submit").click();
			});
		// } else {
		// 	//alert(msg);
		// 	$('#errorModal').find(".modal-body").html(msg);
		// 	$('#errorModal').modal('show');
		// }
	});
	 	/* *** end of submission *** */    
	 	
	/* *** end of page specific features *** */    
	
});