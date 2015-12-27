<?php 
	require_once '../factory.php';//from root/model/
	require_once '../productCategory.php';
	require_once '../product.php';
	$function = @$_POST['function'];

	$factoryName = @$_POST['name'];
	
	if($function == "postPrevDue")
	{
		$factory = new Factory($factoryName);
		$prevDue = @$factory->getPrevDue();
		echo "$prevDue";
	}
	if($function == "getCategOptions")
	{
		echo productCategory::getCategOptions();
	}
	if($function == "getColorOptions")
	{
		echo productCategory::getColorOptions();
	}
	if($function == "renewFromDb")
	{
		$factory = new factory($factoryName);
		$product = new product("$factory->code"."-"."1",0);
		//echo "=== $product->pid";
		$product->renewPidFromDb();

		echo "$product->pid";
	}
	if($function == "postFactoryIndex")
	{
		$factory = new factory($factoryName);
		echo $factory->code;

	}
	if($function == "inventoryHas")
	{
		$pid = $_POST["pid"];
		$product = new product($pid,0);
		if($product->isFound())
		{
			echo "yes";
		}
		else
		{
			echo "no";
		}

	}
	if($function == "getDescr")
	{
		$pid = $_POST["pid"];
		$product = new product($pid,0);
		
		echo $product->descr;
	}
	if($function == "fetchInfo")
	{
		$pid = $_POST["pid"];
		$product = new product($pid,0);
		
		//$info = "$product->sp;$product->cpDoz";
		$info = ["sp"=>$product->sp,"cpDoz"=>$product->cpDoz];
		print json_encode($info);	}
	if($function == "fetchInfoArr")//not needed
	{
		$pid = $_POST["pid"];
		$product = new product($pid,0);
		$info = ["sp"=>$product->sp,"cpDoz"=>$product->cpDoz];
		print json_encode($info);
	}


 ?>