$(document).ready(function(){
	/*=============================================
	//	local features
	==============================================*/
	// $(document).on("mouseover",".shoeDescr",function(){
	// 	associatedPid = $(this).parent().parent().find(".shoePid").html();
	// 	genImage = '<img style="max-width:240px;" src="../media/image/product/shoe/'+associatedPid+'.jpg">';
	// 	console.log("triggerred pid "+associatedPid+' with image '+genImage);
	// 	$('.shoeDescr').popover({placement: 'right', content: genImage, html: true});
	// 	//console.log($(this).parent().parent().html());
	// });
	
	$('.shoeDescr').popover({
	  html: true,
	  trigger: 'hover',
	  content: function () {
	  	//associatedPid = $(this).parent().parent().find(".shoePid").html();
	  	associatedPid = $(this).parent().parent().find(".shoePid").val();
	    return '<img style="max-width:240px;" src="../media/image/product/shoe/'+associatedPid+'.jpg">';
	  }
	});

	// $(document).on("hover",".shoeDescrTd",function(){
	// 	var s = $(this).clone().wrap('<p>').parent().html();
 //       	console.log(s);

 //       	//$(this).find('.shoeDescr').popover('show');
	// });
	$(document).on("mouseenter",".shoeDescr",function(){
		$(this).addClass('text-black');
	});
	$(document).on("mouseleave",".shoeDescr",function(){
		$(this).removeClass('text-black');
	});
	$(document).on("click",".shoeDescr",function(){
		associatedPid = $(this).parent().parent().find(".shoePid").val();
	    imageLink = 'http://localhost/juierp/media/image/product/shoe/'+associatedPid+'.jpg';
		window.open(imageLink, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, width=250");
	});

	/*=============================================
	//	copying pid
	==============================================*/
	$(document).on("mousedown",".shoePid",function(e){
		//console.log(e.button);
    	if( e.button == 2) 
    	{
    		//console.log("rmb Fired"); 
    		//log(this);
    		$(this).select();	
    	}
	});
	/* *** end of copying pid *** */    
	
	/* *** end of local features *** */    
	
});

function log(element){
	var s = $(element).clone().wrap('<p>').parent().html();
    console.log(s);
}