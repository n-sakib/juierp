<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
class Factory 
{
	public $name = '';

	public $index = null; //previously factoryIndexHex, followed by indexInt, now index
	public $code = 0; //previously indexHex, now code, representing factory code, which is the hexa value for factory table index

	//add other infos later
	function __construct($name='')
	{
		$this->name = $name;
		$this->getFactoryIndex();
		//echo "$this->indexInt===";
	}

	function createProfile()
	{
		db("insert into factories (name) values('$this->name')");
	}
	function getPrevDue()
	{
		$this->getFactoryIndex();
		$factoryQry = db("select * from purchase where vendorIndex = '$this->index' order by tableIndex desc limit 1");
		return $factoryQry["due"];
	}
	function getFactoryIndex() //int
	{
		$vendorQry = db("select * from factories where name = '$this->name' limit 1");
		//print_r($vendorQry);
		//echo "==$vendorQry[tableIndex]==";
		$this->index = $vendorQry["tableIndex"];
		$this->code = dechex($this->indexInt);
		return $vendorQry["tableIndex"];
	}
	function getNewId()
	{
		$index= $this->getFactoryIndex();
		$shoeSold = 0;
		$memos = dbEach("select * from purchase where vendorIndex = '$this->index' ");
		foreach ($memos as $memo) {
			$entrGroup = dbEach("select * from purchase_log where memoNo = '$memo[memoNo]' ");
			foreach($entrGroup as $entries)
			{
				$shoeSold = $shoeSold + count($entries);//full proof the returned goods
			}
		}
		$index = dechex($index+0);
		$shoeSold = dechex($shoeSold+1);
		return "$index-$shoeSold";
	}
	static function getOptions()//can be generalizes. marked as duplicate, and popular functions
	{
		$factories = dbEach("select * from factories");
		echo "<datalist id=\"factoryNames\">";
		foreach ($factories as $factory) 
		{
			echo "<option value=\"$factory[name]\">$factory[name]</option>";
		}		
		echo "</datalist>";
	}
}
 ?>