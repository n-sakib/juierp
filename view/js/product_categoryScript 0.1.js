$(".addSub").click(function()
{
	alert("cliekced the thing ");
	$('<ul> <li> <input class="" type="text" data-tableIndex="" readonly> <span class="edit fa fa-edit fa-2 cur"></span> <span class="delete fa fa-trash-o fa-2 cur"></span> <span class="addSub fa fa-cogs fa-2 cur"></span> </li> <li> <input class="" type="text"> <span class="addEntry fa fa-plus-square fa-2 cur"></span> </li> </ul>').insertAfter($(this)); 
});