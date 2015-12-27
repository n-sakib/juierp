<?php 
	require_once '../productCategory.php';//from root/model/
	$function = $_POST['function'];

	$parent = @$_POST['parent'];
	$parentIndex = @$_POST['parentIndex'];
	$name = @$_POST['name'];
	
	if($function == "postNewEntry")
	{
		$category = new ProductCategory($name,$parent,$parentIndex);
		$category->create();
		echo "$category->index";
		//echo "obtainded info : $name , $parent , $parentIndex";
		//echo "$category->index is index, $category->parent";
	}
	if($function == "createNewColor")
	{
		$colorName = $name;
		productCategory::createNewColor($colorName);
		echo productCategory::getLastColorIndex();
	}

 ?>