<?php 
	require_once '../productCategory.php';//from root/model/
	$function = $_POST['function'];

	$textIn = $_POST['textIn'];
	$lvl = $_POST['lvl'];
	$lvl1= $lvl2= $lvl3 = '' ;
	$lvl1 = @$_POST['lvl1'];
	$lvl2 = @$_POST['lvl2'];
	$lvl3 = @$_POST['lvl3'];
	
	if ($lvl == 1)
	{
		$lvl1 = $_POST['textIn'];
	}
	if ($lvl == 2)
	{
		$lvl2 = $_POST['textIn'];
	}
	if ($lvl == 3)
	{
		$lvl3 = $_POST['textIn'];
	}


	if($function == "insert")
	{
		$newCateg = new ProductCategory($lvl1,$lvl2,$lvl3);
		$newCateg->save();
		echo "the level is ==$lvl1:$lvl2:$lvl3== $newCateg->lvl";
	}

	//echo "$function successfully data returned, and the posted value is $textIn, lvl3 is $lvl3";
 ?>