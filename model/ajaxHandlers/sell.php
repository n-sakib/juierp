<?php 
	require_once '../client.php';//from root/model/
	require_once '../product.php';
	$function = @$_POST['function'];

	$clientName = @$_POST['clientName'];
	
	if($function == "getPrevDue")
	{
		$client = new Client($clientName);
		$prevDue = @$client->getPrevDue()+0;
		echo "$prevDue";
	}
	if($function == "inventoryHas")
	{
		$pid = $_POST["pid"];
		$product = new product($pid,0);
		if($product->isFound())
		{
			echo "true";
		}
		else
		{
			echo "false";
		}

	}
	if($function == "getPidInfo")
	{
		$pid = $_POST["pid"];
		$product = new product($pid,0);
		
		//$info = "$product->sp;$product->cpDoz";
		$info = ["sp"=>$product->sp,"cpDoz"=>$product->cpDoz,"descr"=>$product->descr,"qty"=>$product->getStock()];
		print json_encode($info);
	}

 ?>