<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
include_once(dirname(__FILE__)."/../model/product.php");
include_once(dirname(__FILE__)."/../model/client.php");
include_once(dirname(__FILE__)."/../model/inventory.php");

//include_once(dirname(__FILE__)."/../model/SellMemo.php");

class Sell{
	public $memoNo = 0;
	public $client = "";
	public $clientIndex = 0;

	//public $products = new Product();
	public $product = [];
	public $productList = 0;

	public $rawPrice = 0;	
	public $commPerc = 0;
	public $commission = 0;
	public $prevDue = 0;
	public $currDue = 0;//due-prevDue

	public $extraCostDescr = '';
	public $extraCost = 0;
	public $shippingCost = 0;
	public $discount = 0;

	public $totalPrice = 0;
	public $paid = 0;	
	//public $currDue = 0; //due-prevDue
	public $due = 0;

	public $comment = "";

	function __construct($client)
	{
		$this->memoNo = $this->createNewMemo();
		$this->client = $client;
		$this->clientIndex = $this->getClientIndex();
		//$sellMemo = new SellMemo("$client");

		$this->getPostedProducts();
		$this->getPostedInfo();

		$this->calculateRawPrice();
		$this->calculateCommission();
		$this->calculateTotalPrice();

		$this->getDue();
	}

	function makeSell()
	{	
		$date = "$_POST[date] 02:02:02";
		db("insert into sell (vendorIndex,vendor,memoNo,rawPrice,extraCost,extraCostDescr,shippingCost,commission,discount,totalPrice,paid,due,date,currDue,sellType) 
			values ('$this->clientIndex','client','$this->memoNo','$this->rawPrice','$this->extraCost','$this->extraCostDescr','$this->shippingCost','$this->commission','$this->discount','$this->totalPrice','$this->paid','$this->due','$date','$this->currDue','clientPurchase')");
		for ($index = 0; $index < $this->productList ; $index++)
		{
			$product = $this->product[$index];
			db("insert into sell_log
			(memoNo,pid,descr,qty,sp,cpDoz,date) values ('$this->memoNo','$product->pid','$product->descr','$product->qty','$product->sp','$product->cpDoz','$date')"); 
			Inventory::remove($product);
		}
	}

	function getPostedProducts()
	{

		//getting product information

		$list = $_POST["pid"];
		$this->productList = count($list);

		//reorganize posted data
		
		$pid = $_POST["pid"];
		$qty = $_POST["qty"];


		for($index = 0; $index < $this->productList; $index++) 
		{
			$product = new Product("$pid[$index]","$qty[$index]");
			
			$this->product[]=$product;
		}
	}
	
	function calculateRawPrice()
	{
		$rawPrice = 0;
		foreach($this->product as $product)
		{
			$rawPrice = $rawPrice + $product->totalPrice;
		}
		$this->rawPrice = $rawPrice;
		return $rawPrice;
	}

	function getPostedInfo()
	{
		//$this-> = $_POST[""];
		$this->comment = $_POST["comment"];
		$this->commPerc = $_POST["commPerc"];
		$this->extraCost = $_POST["extraCost"];
		$this->discount = $_POST["discount"];
		$this->extraCostDescr = $_POST["extraCostDescr"];
		$this->shippingCost = $_POST["shippingCost"];
		$this->paid = $_POST["paid"];

		//updated
		$this->due = $_POST["due"];

	}

	function getPrevDue()
	{
		$this->getClientIndex();

		$clientQry = db("select * from sell where vendorIndex = '$this->clientIndex' order by tableIndex desc limit 1");
		$this->prevDue = @$clientQry["due"];
		return @$clientQry["due"];
	}
	function getDue()
	{
		$prevDue = $this->getPrevDue();
		//$due = $this->totalPrice - $this->paid +$this->prevDue;
		$due = $this->due;
		$this->currDue = $due - $prevDue;
		return $due;
	}
	function calculateTotalPrice()
	{
		$this->calculateRawPrice();
		$this->prevDue = $this->getPrevDue();
		$this->totalPrice = $this->rawPrice - $this->commission - $this->extraCost + $this->shippingCost +$this->prevDue - $this->discount; //was +discount
	}
	function calculateCommission()
	{
		$this->commission = ($this->rawPrice)*($this->commPerc)*(.01);
		return $this->commission;
	}
	function getClientIndex()
	{
		$client = new Client("$this->client");
		$this->clientIndex = $client->getClientIndex();
		//echo "$this->clientIndex is the clientIndex";
		return $this->clientIndex;
	}
	function createNewMemo()
	{
		$newMemo = 0;

		
		$lastMemoRow = db("select * from sell order by tableIndex desc limit 1");
		$newMemo = @$lastMemoRow["memoNo"]+1;
		//$newMemo++;

		return $newMemo;
	}
}
 ?>