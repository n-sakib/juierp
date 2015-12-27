$(document).ready(function(){
	$(document).on("click input focus",".pSubcateg",function(){

		category = $(this).siblings(".pCateg").val(); //making it modular
		//alert(category);
		printSubCategOf(category,this);
		genDescr(this);
	});
	$(document).on("click input focus mouseleave",".pColor",function(){
		genDescr(this);
	});

$(document).on("click focus",".pColor",function(){
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

	//resetting
	$(document).on("change input",".pCateg",function(){
		$(this).siblings(".descr").val("");
		$(this).siblings(".pSubcateg").val("");
		$(this).siblings(".pColor").val("");
	});


	function printSubCategOf(category,inputField)
	{
		var url = '../model/ajaxHandlers/descrGen.php';
		var vars = "variable=variable"+"&function=getSubcateg"+"&category="+category;
		var request = $.ajax({
	        url: url,
	        type: 'POST',
	        data: vars,
	        dataType: "text"
	    });
	    
	    request.done(function(subCategPosted){
	        subCateg = subCategPosted ;
	        //alert(subCateg);
	        
	        var timestamp = Number(new Date()); 
	        var listName = "subcategNames_"+timestamp; //modularity at its best, dealing with id sensative issues

	        $(inputField).attr("list",listName);
			$(inputField).siblings(".subcategNames").attr("id",listName);
			listName = "#"+listName;
			$(inputField).siblings(listName).html(subCateg);
			//$(inputField).parent().append("<span> here </span>");
	    });
	}

	function genDescr(inputField)
	{
		$(inputField).siblings(".descr").val('');//clearing

		categ = $(inputField).parent().children(".pCateg").val();     ///XXX(this)XX (inputField)to make it modular
		subcateg = $(inputField).parent().children(".pSubcateg").val(); //siblings does not work here all the time, cause the object itself sometimes calls the function
		color = $(inputField).parent().children(".pColor").val();

		descr = categ + " " + subcateg +" "+ color;

		if(categ !="" && subcateg !="" && color !="")
		{
			$(inputField).siblings(".descr").val(descr);
		}
		
	}
	$(document).on("change focus",".pCateg, .pSubcateg, .pColor",function(){
		inputElement = this;
		//console.log($(inputElement).parent().html());
		
		$(document).mousemove(function(){
			if(ifNotInList(inputElement))
			{
				$(inputElement).val("");
				$(inputElement).siblings(".descr").val("");
			}
			//console.log("moved with input"+$(inputElement).val());
		});
		$(document).on("click",".pseudo-submit",function(){
			if(ifNotInList(inputElement))
			{
				$(inputElement).val("");
				$(inputElement).siblings(".descr").val("");
			}
			//console.log("moved with input"+$(inputElement).val());
		});
		
		if(ifNotInList(this))
		{
			$(this).val("");
			$(this).siblings(".descr").val("");
		}
	});
});

$('.descr').autosize();//needs to be fixed

function ifNotInList(inputElement)
{
	textIn = $(inputElement).val();

	not_ListingState = true;
	listName = $(inputElement).attr("list");
	$("#"+listName).children("option").each(function(){
		if($(this).val() == textIn)
		{
			not_ListingState = false; //reverse logic tho
		}
	});
	return not_ListingState;
}
if (typeof String.prototype.startsWith != 'function') {
  // see below for better implementation!
  String.prototype.startsWith = function (str){
    return this.indexOf(str) == 0;
  };
}