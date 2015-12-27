
/*=============================================
//	restrict enter key press
==============================================*/
// $(document).keypress(
//     function(event){
//     console.log("keycode is = '"+event.which+"'");
//      if (event.which == '13') { //also restrict f5 key
//         event.preventDefault();
//       }
// });
$(document).keydown(
    function(event){
    //console.log("keydown keycode is = '"+event.which+"'");
     if (event.which == '13' || event.which == '13') { //116 also restrict f5 key
        event.preventDefault();
      }
});
/* *** end of restrict enter key press *** */    

/*=============================================
//	refresh button functionality
==============================================*/
/**
 * must have a div/block element with 
 * refresh-btn class
 * ex:
 * 	<button class="btn btn-default pull-right refresh-btn"><a href="purchase.php">
    <span class="text-default fa fa-refresh fa-lg">রিফ্রেশ</span>
	</a></button>
	<br>

	ex 2: minimal
 * 	<button class="btn btn-default pull-right refresh-btn">
    <span class="text-default fa fa-refresh fa-lg">রিফ্রেশ</span>
	</button>
 */
$(document).on("click",".refresh-btn",function(){
	document.location.reload(true);
});
/* *** end of refresh button functionality *** */    
function noNaN(number){
        if(isNaN(number)){
            return 0;
        } else {
            return number;
        }
    }

    function toEnglish(inputField)
    {
        number = $(inputField).val();
        englishNumber = toEng(number);
        $(inputField).val(englishNumber);
    }

    function toEng(number)
    {
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
/*=============================================
//  print element selected
==============================================*/
function printElem(selectedELement){
  var s = $(selectedELement).clone().wrap('<p>').parent().html();
  console.log(s);
}
/* *** end of print element selected *** */    
