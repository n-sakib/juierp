
$(document).ready(function(){
	//-------------------
	//  Feature bundles
	//-------------------
	
	/**
	 * photo upload
	 */
	$(document).on("click input blur",".pseudo-image-upload", function(){
		$(this).siblings("input[name='img[]']").click();
	});
	$(document).on("change input","input:file",function (){
       var fileName = $(this).val();

       extension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();

       //alert(extension);

       if(fileName!="" && imageHas(extension))
       {
       		$(this).siblings(".pseudo-image-upload").addClass("btn btn-default");
       		
       		pid = $(this).parent().parent().find("input[name='pid[]']").val();

       		$(this).popover('destroy');
       		// var s = $(this).clone().wrap('<p>').parent().html();
       		// console.log(s);
       		handleFileSelect(this,$(this).siblings('.pseudo-image-upload'));	
       		
       		//whoa();
       		//
       		//add a hidden input for the name  
       		//$('<input type="text" name="imgName[]" value="'+pid+'" class="hidden"/>').insertAfter(this); //fuck yeah, it works, ctrl+c // dont neet btw :S
       }
       else
       {
       		$(this).val("");//empty the file bucket if not an image
       }
       //alert(fileName);
    });
    // function whoa(thissse)
    // {
    // 	alert("works");
    // }
	function imageHas(extension) //changed from image to image has
	{
		if(extension == "jpeg" || extension == "jpg" || extension == "png")
		{
			return true;
		}
		return false;
	}

	$(document).on("click", ".img-thumb", function(){
	     imageLink = $(this).attr('src');
	    // console.log(imageLink)
	    // var s = $(this).clone().wrap('<p>').parent().html();
     //   	console.log(s);
		window.open(imageLink, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, width=250");
	});

	/**=============================================
	//	generating thumbnail
	==============================================*/
	// $(document).on("mouseover",'.pseudo-image-upload',function(){
	// 	//var image = '<img src="http://localhost/juierp/media/image/product/shoe/1-e.jpg">';
 //        var image = '<img src="../media/image/product/shoe/1-e.jpg">';
 //        $('.pseudo-image-upload').popover({trigger: 'hover',placement: 'bottom', content: image, html: true});
	// 	//$('.descr').popover({placement: 'bottom', content: image, html: true});
	// 	// $('.pseudo-image-upload').attr("template",'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner">this is custom html</div></div>');
	// 	// $('.pseudo-image-upload').tooltip('show');
	// 	//$('.pseudo-image-upload').attr("template",'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner">this is custom html</div></div>');
	// });
	function handleFileSelect(fileInputElement,pseudoBtnElement) 
	{	  
		  var file = fileInputElement.files[0];
		 
		  var readImg = new FileReader();
		   
		  readImg.readAsDataURL(file);
		   
		  readImg.onload = function(e) {
		    	
		    	imagePopover = '<img style="max-width:240px;" src="'+e.target.result+'">';
			   	//$('#list').attr('src',e.target.result).fadeIn();
			   	//console.log('image count : '+ $(pseudoBtnElement).siblings('.img-thumb').length);
			   	if($(pseudoBtnElement).siblings('.img-thumb').length)
			   	{
			   		$(pseudoBtnElement).siblings('.img-thumb').remove();
			   		// $(this).remove; //this is not the reference
			   	}
			   	imageThumb = '<img src="'+e.target.result+'" alt="ছবি দিন" class="img-thumb">'
			   	$(imageThumb).insertBefore(pseudoBtnElement);
			   	$(pseudoBtnElement).popover('destroy');
			    $(pseudoBtnElement).popover({trigger: 'hover', placement: 'right', content: imagePopover, html: true});
		  	}		    
	}
	//**** end of generating thumbnail ****
	
	//end of photo upload=============
	
	/**
	 * 	pid input ->(check if belongs to the factory->(yes) (check if in the inventory->(yes) fetch the description)) 
	 */
	//fetching data from pid	
	$(document).on("change","input[name='pid[]']", function(){ //listening to input event makes entry so strict
		pid = $(this).val();
		//console.log("input");
		if(itIsFactories(pid))
		{			
			if(inventoryHas(pid,this))
			{
				//console.log("old pid");
				descr = descrOf(pid,this);
				$(this).parent().next().find(".descr").val(descr);
			}
			else
			{
				//console.log("new pid");
			}
		}
		else
		{
			$(this).val("");
		}
	});
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
	function descrOf(pid,pidElement)
	{
		var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=getDescr"+"&pid="+pid;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(descr){
        	//console.log(descr);
        	$(pidElement).parent().next().find(".descr").val(descr);
        	$(pidElement).parent().next().find(".descr").focus();
        	//$(pidElement).parent().parent().find("input[name='qty[]']").focus();
        	$(pidElement).attr("readonly","true");
        	$(pidElement).parent().next().find(".pCateg").remove();
        	$(pidElement).parent().next().find(".pSubcateg").remove();
        	$(pidElement).parent().next().find(".pColor").remove();
        	fetchInfo(pid,pidElement);
            return descr;
        });
	}
	function fetchInfo(pid,pidElement)
	{
		var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=fetchInfo"+"&pid="+pid;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
        	dataTpe: 'json'
        });
        
        //the page returns the new entry index
        request.done(function(info){
        	info = $.parseJSON( info );
        	//info = JSON.stringify( info );
        	//alert(info);
        	//alert(info.sp);

	    	$(pidElement).parent().parent().find("input[name='sp[]']").val(info.sp);
	    	$(pidElement).parent().parent().find("input[name='cpDoz[]']").val(info.cpDoz);

	    	//alert($(pidElement).parent().next().find("input[name='sp[]']").html());

	    	
        	console.log(info);
        	console.log(info.sp);
        	// calculateTotal();
        });
	}
	refactorSerial();
	$(document).on("click",".del",function(){
		refactorSerial();
	});
	$(document).on("click",".new-line",function(){
 		refactorSerial();
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
	//
	//end of fetching data from pid==
	
	//validating if pid party	

	//end of validating if pid party==

	//end of pid input=========
	
	/**
	 * 	factoryName input
	 */
	//restricting the datatable	
	$(document).on("change", ".factoryName",function(){
		if(ifNotInList(this))
		{
			$(this).val("");
		}
		else
		{
			disableNameEntry();
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
    function disableNameEntry()
    {        
        rows = $(".products-coll").length;
        if(rows > 1)
        {
            $(".factoryName").attr("readonly","");    
        }
    }
	//end of restricting the datatable==

	//end of factoryName input=========

	//-----------------
	//  Validations
	//-----------------
	/**
	 * final validation
	 */
	$(".pseudo-submit").click(function() {
		msg = "";
		msg = getValidationMsgs();
		// //
		// firstPid = $(".pid").first().val();
		// shoeCode = parseShoeCode(firstPid);
		// alert(shoeCode);
		// if(!isHexa(shoeCode))
		// {
		// 	alert("valid code given");
		// }
		// //1
		if (msg == "") {
			$("#submitConfirmModal").modal("show");

			$("#modal-sub-btn").click(function() {
				$("#submit").click();
			});
		} else {
			//alert(msg);
			$('#errorModal').find(".modal-body").html(msg);
			$('#errorModal').modal('show');
		}
	});
	function _isHexa(sNum)
	{

		alert(parseInt(sNum, 16))
		if(sNum == "")
		{
			return false;
		}
	 //  return (typeof sNum === "string") && sNum.length >= 1 
	 //         && ! isNaN( parseInt(sNum, 16) );
	  return (typeof sNum === "string") && sNum.length >= 1 && !isNaN( parseInt(sNum, 16) );
	}
	function isHexa(sNum)
	{	if(sNum == "" || sNum === null)
		{
			return false;
		}
		// alert(sNum.match(/[a-f0-9]/));
		// alert(/\b([0-9a-f]{1,})\b/.test(shoeCode)); //regexr.com
		return /\b([0-9a-f]{1,})\b/.test(shoeCode);
	}
	/**=============================================
	//	local feautures
	==============================================*/
	$(document).on("change input","input[name='date']",function(){
		$(".date-indicator").removeClass("btn-primary");
		//alert($(this).val());
		console.log($(this).val());
		if($(this).val()!=today())
		{
			// $(".date-indicator").removeClass("btn-primary");
			// $(".date-indicator").removeClass("btn-success");
			$(".date-indicator").addClass("btn-warning"); //wanted to one query only, but kinda tricked now :S
		}
		else if ($(this).val()==today()) //but else ($(this).val()==today()) worked somehow
		{
			// $(".date-indicator").removeClass("btn-primary");
			// $(".date-indicator").removeClass("btn-warning");
			$(".date-indicator").addClass("btn-success");
		}
		else if ($(this).val()=="") //but else ($(this).val()==today()) worked somehow
		{
			// $(".date-indicator").removeClass("btn-primary");
			// $(".date-indicator").removeClass("btn-warning");
			$(".date-indicator").addClass("btn-danger");
		}
	});
	
	$(".date-indicator").click(function(){
		$("input[name='date']").val(today()); //cleverest fuckin thing :p
		$(this).removeClass("btn-primary")
					.removeClass("btn-warning")
					.addClass("btn-success");
	});

	// setting delfaultdate
	function setDate() {
	    var now = new Date();
	 
	    var day = ("0" + now.getDate()).slice(-2);
	    var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

	   	$("input[name='date']").val(today);       
	}
	function today(){
		var now = new Date();
	 
	    var day = ("0" + now.getDate()).slice(-2);
	    var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

	    return today;
	}
	setDate();
	// end of setting default date======
		
	//**** end of local feautures ****
	
	/**=============================================
	//	global feautures
	==============================================*/
	$(document).on("change keyup input","input[name='qty[]'], input[name='sp[]'], input[name='cpDoz[]'], input[name='paid']",function(){
		oldVal = $(this).val(); 
		newVal = toEng(oldVal);
		$(this).val(newVal);
	});
	//**** end of global feautures ****
	
	//helpers
	function getValidationMsgs()
	{
		msg = "";
		if(allTheDescriptionsProvided()==false)
		{
			msg = msg + "সবগুলো বিবরণ পুরন করুন <hr/>";
		}
		if(allTheSpProvided()==false)
		{
			msg = msg + "সবগুলো গায়ের দাম পুরন করুন <hr/>";
		}
		if(allTheQtyProvided()==false)
		{
			msg = msg + "সবগুলো জোড়া পরিমান পুরন করুন <hr/>";
		}
		if(allThePhotoProvided()==false)
		{
			msg = msg + "সবগুলো ছবি দিন <hr/>";
		}
		if(factoryNameProvided()==false)
		{
			msg = msg + "পার্টির নামটি সিলেক্ট করুন <hr/>";
		}
		if(allShoeCodeValid() == false)
		{
			msg = msg + "সঠিক জুতার নম্বর দিন <hr/>";
		}
		//deleting last <hr/>
		var pos = msg.lastIndexOf('<hr/>');
		msg = msg.substring(0,pos-1);// + otherchar + msg.substring(pos+1)

		return msg;
	}
	//sub-helper
	function allTheDescriptionsProvided()
	{
		checked = true;
		$(".descr").each(function(){
			if($(this).val()=="")
			{
				checked = false;
			}
		});
		return checked;
	}
	function allTheSpProvided()
	{
		checked = true;
		$("input[name='sp[]']").each(function(){
			if($(this).val()=="")
			{
				checked = false;
			}
		});
		return checked;
	}
	function allTheQtyProvided()
	{
		checked = true;
		$("input[name='qty[]']").each(function(){
			if($(this).val()=="")
			{
				checked = false;
			}
		});
		return checked;
	}
	function allThePhotoProvided()
	{
		checked = true;
		$("input[name='img[]']").each(function(){
			if($(this).val()=="")
			{
				checked = false;
			}
		});
		return checked;
	}
	function factoryNameProvided()
	{
		checked = true;
		if($("input[name='factoryName']").val()=="")
		{
			checked = false;
		}

		return checked;
	}
	function allShoeCodeValid()
	{
		checked = true;
		//
		$("input[name='pid[]']").each(function(){
			pid = $(this).val();
			shoeCode = parseShoeCode(pid);
			// alert(shoeCode +"===="+ isHexa(shoeCode));
			if(!isHexa(shoeCode))
			{
				checked = false;
				factorycode = $(".factoryName").attr("data-index");
				$(this).val(factorycode+"-");
			}
			// alert(/\b([0-9a-f]{1,})\b/.test(shoeCode)); //regexr.com
		});
		// shoeCode = parseShoeCode(firstPid);
		// alert(shoeCode);
		// if(!isHexa(shoeCode))
		// {
		// 	alert("valid code given");
		// }
		//1
		return checked;

	}
	//end of final validation==============
	//
	

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

    /**=============================================
    //	global helpers
    ==============================================*/
	function toEng(number) {
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
	String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (ignore ? "gi" : "g")), (typeof(str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
	};
    //**** end of global helpers ****
    
	
});
//priority functions , needs to be exectuted asap
//js should be used for speed
//alert("here");
$(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});