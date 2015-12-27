<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
class Product{
	//shoe, ring
	// public $productGenre = "";
	// public $productCategory = [];
	public $pid = '';
	public $descr = '';	
	public $sp = 0;
	public $qty = 0;

	public $totalPrice = 0;//deprecated


	public $totalCp = 0;
	public $totalSp = 0;

	public $factoryIndex = 0;
	public $shoeIndex = 0;

	public $factoryCode = null;
	public $shoeCode = null;

	public $cpDoz = 0;
	public $img = '';

	//function __construct($pid = '', $descr = '', $cp = 0, $qty = 0, $spDoz = 0,)
	function __construct($pid = '', $qty = 0)
	{	
		$this->pid = $pid;
		$this->descr = $this->getDescr("$pid");	
		$this->sp = $this->getSp("$pid");
		$this->qty = $qty;
		$this->spDoz = $this->getCpDoz("$pid");		

		$this->totalPrice = $this->sp * $qty;
		$this->parsePid($pid);
	}
	// function __construct($pid = '', $descr = '', $cp = 0, $qty = 0, $spDoz = 0,)
	// {
	// 	$this->pid = $pid;
	// 	$this->descr = $this->getDescr("$pid");	
	// 	$this->sp = $this->getSp("$pid");
	// 	$this->qty = $qty;
	// 	$this->cpDoz = $this->getCpDoz("$pid");		
	// }
	// function purchaseTh($table)
	// {
	// 	Db("insert into '$table'")
	// }s
	function getDescr($pid)
	{
		$pidQry = db("select * from inventory where pid = '$pid' limit 1");
		//print_r($pidQry);
		$this->descr = @$pidQry["descr"];
		return @$pidQry["descr"];
	}
	function getSp($pid)
	{
		$pidQry = db("select * from inventory where pid = '$pid' limit 1");
		$this->sp = @$pidQry["sp"];
		return @$pidQry["sp"];
	}	
	function getCpDoz($pid)
	{
		$pidQry = db("select * from inventory where pid = '$pid' limit 1");
		$this->cpDoz = @$pidQry["cpDoz"];
		return @$pidQry["cpDoz"];
	}
	function getStock()
	{
		$pidQry = db("select * from inventory where pid = '$this->pid' limit 1");
		return @$pidQry["qty"];
	}
	function setTotalCpSp()
	{
		$this->totalSp = $this->qty*$this->sp;
		$this->totalCp = $this->qty*$this->cpDoz/12;
	}
	function uploadPhoto()
	{
		
	}
	function parsePid($pid)
	{
		$info = explode("-", $pid);
		$factoryCode = $info[0];
		//$shoeCode = @$info[1];
		$shoeCode = @$info[1];
		//echo "$factoryCode and $shoeCode";

		$this->factoryIndex = hexdec($factoryCode);
		$this->shoeIndex = hexdec($shoeCode);
	}
	function updatePid()
	{
		$this->factoryCode = dechex($this->factoryIndex);
		$this->shoeCode = dechex($this->shoeIndex);

		$this->pid = "$this->factoryCode"."-"."$this->shoeCode";
	}


	function renewPidFromDb()
	{
		//$shoes = db("select * from inventory where pid = '$this->pid' ");
		
		$newPid = $this->pid;
		//echo "newpid $newPid--";
		//foreach ($shoes as $shoe) {
			while($this->found($newPid))
			{
				$this->shoeIndex++;
				$this->updatePid();
				$newPid = $this->pid;
				//echo "==$newPid==";
			}	
		return $newPid ;
		//}
	}
	function found($pid) //optimized for if() conditionals
	{
		$found = db("select * from inventory where pid = '$pid' limit 1");
		//print_r($found);
		if($found == []) //== error 
		{
			//echo "$pid not found";
			return false;
		}
		//echo "$pid found";
		return true;	
	}
	function isFound() //optimized for if() conditionals
	{
		$pid = $this->pid;
		$found = db("select * from inventory where pid = '$pid' limit 1");
		//print_r($found);
		if($found == []) //== error 
		{
			//echo "$pid not found";
			return false;
		}
		//echo "$pid found";
		return true;	
	}
	//function getFactoryIndexInt()
}
 ?>