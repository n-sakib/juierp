<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
include_once(dirname(__FILE__)."/../model/product.php");
include_once(dirname(__FILE__)."/../model/inventory.php");
include_once(dirname(__FILE__)."/../model/factory.php");

// primary order (of refactoring)
// use camelCasing for all the cases (mysqli also supports 
//  camelcased table name)
//  
//  and always use CapitalCamelCase for class name

class PurchaseReturn{
	public $memoNo = 0;
	public $factory = "";
	// factoryindex is the serial number of factory (in decimal)
	// factoryCode is the serial number of factory in hexa
	public $factoryIndex = 0;

	public $product = [];
	public $productList = 0;

	public $rawPrice = 0;	//total gross costprice
	public $prevDue = 0;
	public $currDue = 0;

	public $totalPrice = 0;
	public $paid = 0;
	public $due = 0;

	//public $currDue = 0;

	public $comment = "";

	/**
	 * purchaseType is an enumerated string 
	 * type variable, helping to mark the 
	 * different credit type activities
	 *
	 * values are 
	 *  "defaultPurchase" ->any usual routine purchase from 
	 *  					from shoe factory
	 *  "factoryReturn"  ->return of any shoe 
	 *  					from inventory
	 *  					
	 * @var string
	 */
	public $purchaseType = "factoryReturn"; 
	function __construct($factory)
	{
		
		$this->getPostedInfo();
		$this->memoNo = $this->createNewMemo();
		$this->factory = $factory;
		$factoryData = new factory($factory);
		$this->prevDue = $factoryData->getPrevDue();

		$this->getfactoryIndex();

		//$this->getAllProducts();

		$this->calculateRawPrice();
		$this->calculateTotalPrice();
	}
	function createNewMemo()
	{
		$newMemo = 0;

		
		$lastMemoRow = db("select * from purchase order by tableIndex desc limit 1");
		//print_r($lastMemoRow);
		$newMemo = @$lastMemoRow["memoNo"]+1;
		// $newMemo++;

		return $newMemo;
	}
	// function testPurchase()
	// {
	// 	db("insert into purchase (vendor) values ('factory')");
	// }
	function makePurchaseReturn()
	{	
		$date = "$_POST[date] 02:02:02";
		$this->purchaseType = "factoryReturn";
		//insert into sell and sellLog
		//vendorType = [factory, factory, staff, bank, addition]
		//
		//do this in distraction free mode shift+f11
		//first field name, then field value, type both at once first

		db("insert into purchase
			(vendorIndex,vendor,memoNo,rawPrice,paid,due,date,purchaseType)
			values
			('$this->factoryIndex','factory','$this->memoNo','$this->rawPrice','$this->paid','$this->due','$date','$this->purchaseType')
			");
		for ($index = 0; $index < $this->productList ; $index++)
		{

			$product = $this->product[$index];
			//echo "('$this->memoNo','$product->pid','$product->descr','$product->qty','$product->sp','$product->cpDoz')";
			db("insert into purchase_log
				(memoNo,pid,descr,qty,sp,cpDoz,date)
				values
				('$this->memoNo','$product->pid','$product->descr','$product->qty','$product->sp','$product->cpDoz','$date')
				"); 

			Inventory::remove($product);
		}
	}
	function getAllProducts()
	{

		//getting product information

		$list = $_POST["pid"];
		$this->productList = count($list);
		//print_r($list);
		//echo "$this->productList";
		//reorganize posted data
		
		$pid = $_POST["pid"];
		$qty = $_POST["qty"];
		// $sp = @$_POST["sp"];
		$cpDoz = $_POST["cpDoz"];
		$descr = $_POST["descr"];

		//print_r($list);
		foreach ($list as $index => $value)
		{
			//echo "1--";
			$product = new Product("$pid[$index]","$qty[$index]");
			// $product->sp = $sp[$index];
			$product->cpDoz = $cpDoz[$index];
			$product->descr = $descr[$index];
			$product->qty = $qty[$index];
			$product->setTotalCpSp();

			$this->product[]=$product;
		}
		// $this->uploadPhotos();

	}
	function uploadPhotos()
	{
		foreach ($this->product as $index => $product) 
		{
			//echo "product/shoe/$product->pid";
			uploadPhotosIn("img",$index,"product/shoe/$product->pid");
		}
	}
	function calculateRawPrice()
	{
		$rawPrice = 0;
		//print_r($this->product);
		foreach($this->product as $product)
		{
			//echo "raw proce is $rawPrice<br>";
			$rawPrice = $rawPrice + $product->totalCp;
		}
		$this->rawPrice = $rawPrice;
		return $rawPrice;
	}

	function getPostedInfo()
	{
		$this->getAllProducts();

		$this->comment = $_POST["comment"];
		// $this->paid = $_POST["paid"];

	}

	function getPrevDue()
	{
		$this->getfactoryIndex();
		$factoryQry = db("select * from purchase_memo where vendorIndex = '$this->factoryIndex' order by tableIndex asc limit 1");
		$this->prevDue = $factoryQry["due"];
		return $factoryQry["due"];
	}

	function calculateTotalPrice()
	{
		//$this->calculateRawPrice();
		$totalPrice = $this->rawPrice +$this->prevDue - $this->paid;
		$this->totalPrice = $totalPrice;
		$this->calculateDue();
	}
	function calculateDue()
	{
		$factory = new factory($this->factory);
		$this->prevDue = $factory->getPrevDue();
		$this->due = $this->prevDue - $this->rawPrice ;//- $this->paid;
	}
	function getfactoryIndex()
	{
		//echo "$this->factory is factory";
		$vendorQry = db("select * from factories where name = '$this->factory' limit 1");
		$this->factoryIndex = $vendorQry["tableIndex"];
		return $vendorQry["tableIndex"];
	}
}
?>