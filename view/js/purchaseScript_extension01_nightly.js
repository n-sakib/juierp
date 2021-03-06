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
       if(fileName!="")
       {
       	$(this).siblings(".pseudo-image-upload").addClass("btn btn-default");
       }
       //alert(fileName);
    });
	//end of photo upload=============
	
	/**
	 * 	pid input ->(check if belongs to the factory->(yes) (check if in the inventory->(yes) fetch the description)) 
	 */
	//fetching data from pid	
	$(document).on("change input","input[name='pid[]']", function(){
		pid = $(this).val();
		//console.log("input");
		if(itIsFactories(pid))
		{		
			inventoryHas(pid);	
			if(inventoryHas(pid))
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
	function inventoryHas(pid)
	{
        var url = '../model/ajaxHandlers/purchase.php';
        var vars = "variable=variable"+"&function=inventoryHas"+"&pid="+pid;
        
        var request = $.ajax({
        	async : false,
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
    //         	descr = descrOf(pid,pidElement);
				// $(pidElement).parent().next().find(".descr").val(descr);
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
        	async : false,
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(descr){
        	//console.log(descr);
        	$(pidElement).parent().next().find(".descr").val(descr);
        	console.log($(pidElement).parent().parent().html());
        	$(pidElement).parent().parent().find("input[name='qty[]']").focus();
        	$(pidElement).attr("readonly","true");
        	$(pidElement).parent().next().find(".pCateg").remove();
        	$(pidElement).parent().next().find(".pSubcateg").remove();
        	$(pidElement).parent().next().find(".pColor").remove();
            return descr;
        });
	}

	//
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
			console.log($(this).html());
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
	//end of restricting the datatable==

	//end of factoryName input=========

	// setting delfaultdate
	function setDate() {
	    var now = new Date();
	 
	    var day = ("0" + now.getDate()).slice(-2);
	    var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

	   	$("input[name='date']").val(today);       
	}
	setDate();
	// end of setting default date======

	//-----------------
	//  Validations
	//-----------------
	/**
	 * final validation
	 */
	$(".pseudo-submit").click(function() {
		msg = "";
		msg = getValidationMsgs();
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
		//deleting last <hr/>
		var pos = msg.lastIndexOf('<hr/>');
		msg = msg.substring(0,pos-1);// + otherchar + msg.substring(pos+1)

		return msg;
	}
	//sub-helper
	function allTheDescriptionsProvided()
	{
		chekeced = true;
		$(".descr").each(function(){
			if($(this).val()=="")
			{
				chekeced = false;
			}
		});
		return chekeced;
	}
	function allTheSpProvided()
	{
		chekeced = true;
		$("input[name='sp[]']").each(function(){
			if($(this).val()=="")
			{
				chekeced = false;
			}
		});
		return chekeced;
	}
	function allTheQtyProvided()
	{
		chekeced = true;
		$("input[name='qty[]']").each(function(){
			if($(this).val()=="")
			{
				chekeced = false;
			}
		});
		return chekeced;
	}
	function allThePhotoProvided()
	{
		chekeced = true;
		$("input[name='img[]']").each(function(){
			if($(this).val()=="")
			{
				chekeced = false;
			}
		});
		return chekeced;
	}
	function factoryNameProvided()
	{
		chekeced = true;
		if($("input[name='factoryName']").val()=="")
		{
			chekeced = false;
		}

		return chekeced;
	}
	//end of final validation==============
	//
	

	function parseFactoryIndex(pid)
    {
        var info = pid.split("-");
        var factoryIndex = parseInt(info[0], 16);
        return factoryIndex;
    }
	
});