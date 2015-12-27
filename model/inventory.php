<?php
include_once(dirname(__FILE__)."/../model/lib/util.php"); 
include_once(dirname(__FILE__)."/product.php"); 

class Inventory
{
	//uses dechex() for pid
	
	static function add($product)
	{
		if(static::ifOld($product))
		{
			static::addOld($product);
		}
		else
		{
			static::addNew($product);
		}
	}
	static function addOld($product)
	{
		$inventoryQry = db("select * from inventory where pid = '$product->pid' limit 1 ");
		
		$indexFound = $inventoryQry["tableIndex"];

		$prevQty = $inventoryQry["qty"];
		$newQty = $prevQty + $product->qty ;

		db("update inventory set qty = '$newQty' , cpDoz = '$product->cpDoz', sp = '$product->sp', descr = '$product->descr'  where  tableIndex = '$indexFound'");	
	}
	static function addNew($product)
	{
		db("insert into inventory (pid,descr,sp,cpDoz,qty) values('$product->pid','$product->descr','$product->sp','$product->cpDoz','$product->qty')");	
	}
	static function ifOld($product)
	{
		$products = dbEach("select * from inventory where pid = '$product->pid' limit 1 ");
		if($products != [])
		{
			return true;
		}
		return false;
	}
	static function remove($product)
	{
		$inventoryQry = db("select * from inventory where pid = '$product->pid' limit 1 ");
		
		$indexFound = $inventoryQry["tableIndex"];

		$prevQty = $inventoryQry["qty"];
		$newQty = $prevQty - $product->qty ;

		db("update inventory set qty = '$newQty'  where  tableIndex = '$indexFound'");	
	}
	static function show($entryPerPage)
	{
		$shoes = dbEach("select * from inventory");
		
		echo "<table class=\"table-panel -table-striped\" id=\"myTable\"> 
				<thead>
				<tr>
					<th>সিরিয়াল</th>
					<th>আইডি</th>
					<th>বিবরণ</th>
					<th>গায়ের দাম</th>
					<th>ডজন দাম</th>
					<th>জোড়া</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				</thead>
				<tbody>";
				//print_r($shoes);
		foreach ($shoes as $index => $eachShoe) 
		{
			$serial = $index + 1;
			//echo "$eachShoe[pid] the pid"; 
			$shoe = static::getProduct($eachShoe["pid"]);
			echo "<tr>
					<td>$serial</td>
					<td><input class=\"shoePid form-control input input-sm\" value=\"$shoe->pid\" readonly></td>
					<td class=\"shoeDescrTd\" ><span class=\"shoeDescr\">$shoe->descr</span></td>
					<td>$shoe->sp</td>
					<td>$shoe->cpDoz</td>
					<td>$shoe->qty</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>";
		}	
		echo "</tbody>
				</table>";
	}
	static function getProduct($pid)
	{
		$shoe = db(" select * from inventory where pid = '$pid' limit 1 ");
		
		$product = new product($shoe["pid"],$shoe["qty"]);
		$product->sp = $shoe["sp"]; 
		$product->cpDoz = $shoe["cpDoz"];
		return $product;
	}
}
 ?>