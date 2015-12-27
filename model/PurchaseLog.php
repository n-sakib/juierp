<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
class PurchaseLog
{	
	/**
	 * the product id of the products
	 * @var string
	 */
	public $pId = '';
}

/**
 * product object has 
 * an Id , pair selling price,
 * cost price per dozen , description 
 * of the product 
 */
/**
 *	__brainstorms
 *
 * 	when we create a new product we 
 * 	set all of its attributes (which is optional)
 * 	or we can set it later if we are creating
 * 	a non-pre-existing product
 */
// class Product 
// {
// 	public $pId = '';
// 	public $cpDoz = 0;
// 	public $sp = 0;
// 	public $descr = '';

// 	function __construct($newPId='',$newCpDoz=0,$newSp=0,$newDescr='')
// 	{
// 		$this->pId = $newPId;
// 		$this->cpDoz = $newCpDoz;
// 		$this->sp = $newSp;
// 		$this->descr = $newDescr;
// 	}

// 	/**
// 	 * gets the data from the database
// 	 * using the Product Id (pId), and sets
// 	 * all those information (description, cp, sp...)	 
// 	 * 
// 	 * @param  String $pId [the product Id of the product]
// 	 */
// 	function getMeta($pId)
// 	{

// 	}	
// }

class PurchaseReceipt
{	
	public $memoNo = 0;
	public $dateOfCreation = '';
	public $companyName = '';

	public $totalPairs = 0;
	public $totalAmount = 0;
	public $discount = 0;
	public $finalAmount = $totalAmount - $discount;

	/**
	 * queries the database, and 
	 * returns a new memo no
	 * that is one greater than the 
	 * last memo that was made
	 * 	
	 * @return integer memo number
	 */
	function createNewMemo()
	{
		$newMemo = 0;

		$memoQry = ($con, "select * from purchase_memo order by table_index desc limit 1");
		$lastMemoRow = mysqli_fetch_array($memoQry);

		$newMemo = $lastMemoRow["memo_no"]+1;
		$newMemo++;

		return $newMemo;
	}
}
	function Db($query)
	{
		$qry = ($con, "$query");
		return $row = mysqli_fetch_array($qry);
	}

 ?>