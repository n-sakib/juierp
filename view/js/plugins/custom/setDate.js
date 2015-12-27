/**
 * utility plugin to set date in 
 * an date type input element
 *----------------------------------------------
 * requirements:
 * 	1. following html :(mandatory)
 		<input class="form-control txt-in-head" name="date" type="date" required>
					<span class="date-indicator btn btn-primary">...</span>
	2. jquery.js
	3. bootstrap 3.2 (bootstrap.css and bootstrap.js)
	
   usage:
   	1. sets the default date on the date input element
   	3. compatible with html5 datepicker (currently available on 
   		google chrome)
   	4  can indicate default date(today), current date(today)
   		or any date in past/future, by the color of the 
   		button 
   	5. blue button (btn-primary class of bootstrap 3.2) indicates, 
   		the date input is default, ie todays date, and it has not been
   		changed ; green indicates the date is todays date ;orange 
   		indicates the date has been changed to a date other than 
   		current date (todays date)
   	options:
 * @return {[type]} [description]
 */

$(document).on("change input", "input[name='date']", function() {
	$(".date-indicator").removeClass("btn-primary");
	//alert($(this).val());
	if ($(this).val() != today()) {
		// $(".date-indicator").removeClass("btn-primary");
		// $(".date-indicator").removeClass("btn-success");
		$(".date-indicator").addClass("btn-warning"); //wanted to one query only, but kinda tricked now :S
	} 
	else if ($(this).val() == today()) {
		// $(".date-indicator").removeClass("btn-primary");
		// $(".date-indicator").removeClass("btn-warning");
		$(".date-indicator").addClass("btn-success");
	}
});

$(".date-indicator").click(function() {
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
	var today = now.getFullYear() + "-" + (month) + "-" + (day);

	$("input[name='date']").val(today);
}

function today() {
	var now = new Date();

	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);

	return today;
}
$(document).ready(function(){
	setDate();
});