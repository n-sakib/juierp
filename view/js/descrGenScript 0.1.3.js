$(document).ready(function(){
	// $(".pcateg").mouseup(function(){

	// 	category = $(".pcateg").val();
	// 	printSubCategOf(category);
	// });
	$(document).on("click",".pSubcateg",function(){

		category = $(this).siblings(".pCateg").val(); //making it modular
		//alert(category);
		printSubCategOf(category,this);
		genDescr(this);
	});
	// $(document).on("change",".pSubcateg",function(){
	// 	genDescr(this);
	// });
	$(document).on("click input",".pColor",function(){
		genDescr(this);
	});

	//resetting
	$(document).on("change ",".pCateg",function(){
		$(this).siblings(".descr").val("");
		$(this).siblings(".pSubcateg").val("");
		$(this).siblings(".pColor").val("");
	});
	// $(document).on("mouseup",".pColor",function(){
	// 	genDescr(this);
	// });


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
			$(inputField).siblings("#subcategNames").html(subCateg);
	    });
	}

	function genDescr(inputField)
	{
		$(inputField).siblings(".descr").val('');//clearing

		categ = $(inputField).parent().children(".pCateg").val();     ///XXX(this)XX (inputField)to make it modular
		subcateg = $(inputField).parent().children(".pSubcateg").val(); //siblings does not work here all the time, cause the object itself sometimes calls the function
		color = $(inputField).parent().children(".pColor").val();

		descr = categ + " " + subcateg +" "+ color;

		//html = $(inputField).html();
		//alert("function called "+ html);
		$(inputField).siblings(".descr").val(descr);
	}
});