<?php 
	require_once '../productCategory.php';//from root/model/
	$function = @$_POST['function'];

	$category = @$_POST['category'];
	
	if($function == "getSubcateg")
	{
		productCategory::getSubCategOptions("$category");
	}

 ?>