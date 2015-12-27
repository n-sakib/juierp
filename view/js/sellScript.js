$(document).ready(function(){	

	/*=============================================
	//	local features
	==============================================*/
		/*=============================================
		//	client-name-input-btn
		==============================================*/
			$(document).on("change",'input[name="clientName"]',function(){
				console.log($(this).val());
				restrictInDataList(this);
			});
		/* *** end of client-name-input-btn *** */    
		
		/*=============================================
		//	new-line-btn
		==============================================*/
		$(".new-line").click(function(){
		    if(emptyField(".clientName"))
		    {
		        $('#clientNameWarningModal').modal('show');
		    }
		    else
		    {
		        $('<tr class="products-coll"> <td></td> <td> <input class="form-control" name="pid[]" type="text" pattern="(?:[0-9a-f]{1,})(?:[-]{1})(?:[0-9a-f]{1,})" title="দয়া করে আইডি দিয়ে ঘরটি পুরন করুন" required> </td> <td> <span class="descr"></span> <input class="form-control" name="descr[]" type="hidden"> <button class="btn btn-info btn-sm pull-right">স্টক : <span class="badge badge-default stock">..</span> <i class="fa fa-picture-o fa-2x fa-fw cur viewImg"></i> </button></td> <td> <input class="form-control" name="qty[]" type="text" pattern="(?:\\d*\\.)?\\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required> </td> <td> <input class="form-control" name="sp[]" type="text" readonly> </td> <td> <!-- weighted price --> <span class="weightedSp"> </span> <button class="close close-btn del-row-btn" type="button">&times;</button> </td> </tr>').insertBefore(".last-row"); // renewPid(); updateRowIndexOf(".products-coll"); // disableNameEntry();
				updateRowIndexOf(".products-coll");
				//disableNameEntry();
		    }	
		});

		$(document).on("keydown","input[name='sp[]']",function(event){
	        if (event.which == '9' || event.which == '13') { //event.which == '13' also enter key
	            $(".new-line").click();
	        }
	    });
		/* *** end of new-line-btn *** */    

		/*=============================================
		 //    delete button
		 ==============================================*/
		 $(document).on("click",".del-row-btn",function(){
		 	delRowBtn = this; 
		 	//alert($(".products-coll").length);
		    //if one row, replace row by emptyrow and reIndex
		    if($(".products-coll").length==1)
		    {
		    	$(delRowBtn).parent().parent().html('<td></td> <td> <input class="form-control" name="pid[]" type="text" pattern="(?:[0-9a-f]{1,})(?:[-]{1})(?:[0-9a-f]{1,})" title="দয়া করে আইডি দিয়ে ঘরটি পুরন করুন" required> <!-- was type="number" --> </td> <td> <span class="descr"></span> <input class="form-control" name="descr[]" type="hidden"> <button class="btn btn-info btn-sm pull-right">স্টক : <span class="badge badge-default stock">..</span> <i class="fa fa-picture-o fa-2x fa-fw cur viewImg"></i> </button> </td> <td> <input class="form-control" name="qty[]" type="text" pattern="(?:\d*\.)?\d+" title="দয়া করে সংখ্যা দিয়ে ঘরটি পুরন করুন" required> </td> <td> <input class="form-control" name="sp[]" type="text" readonly> </td> <td> <!-- weighted price --> <span class="weightedSp"> </span> <button class="close close-btn del-row-btn" type="button">&times;</button> </td>'); 
		    	updateRowIndexOf(".products-coll");
		    }
		    else //delete row
		    {
		    	$(delRowBtn).parent().parent().remove();
		    	updateRowIndexOf(".products-coll");
		    }
		 });
		 /* *** end of delete button *** */    

		$(document).on("keyup","input[name='pid[]']",function(){
			takePidInput(this);
		});
		$(document).on("change","input[name='pid[]']",function(){
			takePidInput_2(this);
		});

		function takePidInput(pidInputElement){
			// if in db, fetch otherwise empty
			takePidInput_ifInDB($(pidInputElement).val(),pidInputElement);
		}
		function takePidInput_2(pidInputElement){
			// if in db, fetch otherwise empty
			takePidInput_2_ifInDB($(pidInputElement).val(),pidInputElement);
		}
		function takePidInput_ifInDB(pid,pidElement){
			var url = '../model/ajaxHandlers/sell.php';
		    var vars = "variable=variable"+"&function=getPidInfo"+"&pid="+pid;
		    
		    var request = $.ajax({
		        url: url,
		        type: 'POST',
		        data: vars,
		        dataTpe: 'json'
		    });
		    
		    request.done(function(info){
	        	info = $.parseJSON( info );
	        	//info = JSON.stringify( info );
	        	//alert(info);
	        	//alert(info.sp);
	        	// if(info.sp == null && info.descr == null && info.qty == null )
	        	// {
	        	// 	console.log("not found");
	        	// }
		    	$(pidElement).parent().parent().find("input[name='sp[]']").val(info.sp);
		    	$(pidElement).parent().parent().find(".descr").html(info.descr);
		    	//$(pidElement).parent().parent().find("input[name='cpDoz[]']").val(info.cpDoz);

		    	//alert($(pidElement).parent().next().find("input[name='sp[]']").html());
		    	//
		    	$(pidElement).parent().parent().find("input[name='qty[]']").attr("min","1");
		    	$(pidElement).parent().parent().find("input[name='qty[]']").attr("max",info.qty);

		    	$(pidElement).parent().parent().find(".stock").html(info.qty);
		    	
	        	calculateTotal();
	        	//info = JSON.stringify( info );
	        	//console.log(info);

	        	// console.log(info);
	        	// console.log(info.sp);
	        	//calculateTotal();
        	});
		}
		function takePidInput_2_ifInDB(pid,pidElement){
			var url = '../model/ajaxHandlers/sell.php';
		    var vars = "variable=variable"+"&function=getPidInfo"+"&pid="+pid;
		    
		    var request = $.ajax({
		        url: url,
		        type: 'POST',
		        data: vars,
		        dataTpe: 'json'
		    });
		    
		    request.done(function(info){
	        		$(pidElement).val();
	        	info = $.parseJSON( info );
	        	//pageHasPid($(pidElement).val());
	        	if(info.sp == null && info.descr == null && info.qty == null ) // 'null' seem to bug, null seems ok without the quotes
	        	{	
	        		$(pidElement).val('');
	        		//$(pidElement).parent().parent().find("input[name='pid[]']").val("");
	        		$(pidElement).parent().parent().find("input[name='sp[]']").val("");
			    	$(pidElement).parent().parent().find(".descr").html("");
			    	//
			    	$(pidElement).parent().parent().find("input[name='qty[]']").attr("min","");
			    	$(pidElement).parent().parent().find("input[name='qty[]']").attr("max","");

			    	$(pidElement).parent().parent().find(".stock").html("");
	        	}

        		if(pageHasPid($(pidElement).val()))
        		{
        			//show modal
        			$(pidElement).val('');
        			$(pidElement).val('');

	        		$(pidElement).parent().parent().find("input[name='sp[]']").val("");
			    	$(pidElement).parent().parent().find(".descr").html("");
			    	//
			    	$(pidElement).parent().parent().find("input[name='qty[]']").attr("min","");
			    	$(pidElement).parent().parent().find("input[name='qty[]']").attr("max","");

			    	$(pidElement).parent().parent().find(".stock").html("");
        		}	


	        	info = JSON.stringify( info );
	        	console.log(info);
	        
        	});
		}
		/* *** end of pid-input-element *** */    
		/*=============================================
		//	image view thumbnail
		==============================================*/
		$('.viewImg').popover({
		  html: true,
		  trigger: 'hover',
		  content: function () {
		  	//associatedPid = $(this).parent().parent().find(".shoePid").html();
		  	associatedPid = $(this).parent().parent().find("input[name='pid[]']").val();
		    return '<img style="max-width:240px;" src="../media/image/product/shoe/'+associatedPid+'.jpg">';
		  }
		});
		// $(document).on("mousedown",".viewImg",function(){
		// 	$(this).addClass('fa-inverse');
		// });
		// $(document).on("mouseup",".viewImg",function(){
		// 	$(this)removeClass('fa-inverse');
		// });
		$(document).on("click",".viewImg",function(){
			associatedPid = $(this).parent().parent().find("input[name='pid[]']").val();
		    imageLink = 'http://localhost/juierp/media/image/product/shoe/'+associatedPid+'.jpg';
			window.open(imageLink, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, width=250");
		});
		/* *** end of image view thumbnail *** */    
		
		/*=============================================
		//	extra-cost-input
		==============================================*/
		
		/* *** end of extra-cost-input *** */    
		
		/*=============================================
		//	calculting major calculations
		==============================================*/
		$(document).on("keyup input","input[name='qty[]']",function(){
	        calculateTotal();
	        //calculateTotalPair();
	    });
	    $(document).on("keyup input","input[name='pid[]']",function(){
	        calculateTotal();
	        //calculateTotalPair();
	    });
	    $(document).on("keyup input", "input[name='paid']",function(){
	        calculateTotal();
	    });
	    $(document).on("keyup input", "input[name='commPerc']",function(){
	        generateComm();
	    });
	    $(document).on("keyup input", "input[name='commPerc'],input[name='extraCost'],input[name='shippingCost'],input[name='discount'],input[name='paid']",function(){
	        generateDue();
	    });
	    $(document).on("remove change", function () {
	        calculateTotal();
	    });
		/* *** end of calculting major calculations *** */    
		
	/* *** end of local features *** */    
	
	// $(".new-line").click(function(){
	// 	$('<tr class="products-coll"> <td></td> <td> <input class="form-control" name="pid[]" type="text"> </td> <td> <span class="descr"></span> <input class="form-control" name="descr[]" type="hidden"> </td> <td> <input class="form-control" name="qty[]" type="text"> </td> <td> <span calss="cp"> </span> </td> <td> <span class="subtotal"> <button class="close close-btn" type="button">&times;</button> </span> </td> </tr>').insertBefore(".last-row"); });
	$("input[name='clientName']").keydown(function(){
		showClientsPrevDue();	
	});
	$(document).on("change input",".clientName",function(){
		showClientsPrevDue();
	});

	function showClientsPrevDue()
	{
		var prevDue = '';

		var clientName = $("input[name='clientName']").val();
		var url = '../model/ajaxHandlers/sell.php';
		var vars = "variable=variable"+"&function=getPrevDue"+"&clientName="+clientName;
		var request = $.ajax({
	        url: url,
	        type: 'POST',
	        data: vars,
	        dataType: "text"
	    });
	    
	    request.done(function(dueFound){
	        prevDue = dueFound ;
			$(".prevDue").html(prevDue);			
			calculateTotal();	
	    });
	}

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

	$(document).on("change input","input[name='commPerc'], input[name='extraCost'], input[name='shippingCost'], input[name='discount'], input[name='paid']",function(){
		oldVal = $(this).val(); 
		newVal = toEng(oldVal);
		//console.log('oldVal : '+oldVal+'; newVal : '+newVal);
		$(this).val(newVal);
	});
	$(document).on("change input","input[name='qty[]']",function(){
		oldVal = $(this).val(); 
		newVal = toEng(oldVal);

		min =$(this).attr("min");
		max =$(this).attr("max");
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

	if($("#success").length)
	{
		$('#successModal').modal('show');
	}

});
// // HAS TO BE OUT OF DOCUMENT READY

// $("#success").ready(function(){
// 		$('#successModal').modal('show');
// 	});