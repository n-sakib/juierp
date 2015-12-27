$(document).ready(function(){
	// $(".pcateg").mouseup(function(){

	// 	category = $(".pcateg").val();
	// 	printSubCategOf(category);
	// });
	$(".pSubcateg").click(function(){

		category = $(".pCateg").val();
		printSubCategOf(category);
		genDescr();
	});
	$(".pSubcateg").change(function(){
		genDescr();
	});
	$(".pColor").change(function(){
		genDescr();
	});

	function printSubCategOf(category)
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
			$("#subcategNames").html(subCateg);
	    });
	}

	function genDescr()
	{
		categ = $(".pCateg").val();
		subcateg = $(".pSubcateg").val();
		color = $(".pColor").val();

		descr = categ + " " + subcateg +" "+ color;

		$(".descr").val(descr);
	}
});