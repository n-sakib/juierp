<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
class Client 
{
	public $name = '';
	public $index = '';

	//add other infos later
	function __construct($name='')
	{
		$this->name = $name;
	}

	function createProfile()
	{
		db("insert into clients (name) values('$this->name')");
	}
	
	function getPrevDue()
	{
		$this->getClientIndex();
		$clientQry = db("select * from sell where vendorIndex = '$this->index' order by tableIndex desc limit 1");
		return $clientQry["due"];
	}
	function getClientIndex()
	{
		$vendorQry = db("select * from clients where name = '$this->name' limit 1");
		$this->index = $vendorQry["tableIndex"];
		return $vendorQry["tableIndex"];
	}
	static function getOptions()//can be generalizes. marked as duplicate, and popular functions
	{
		$clients = db("select * from clients");
		echo "<datalist id=\"clientNames\">";
		foreach ($clients as $client) 
		{
			echo "<option value=\"$client[name]\">$client[name]</option>";
		}		
		echo "</datalist>";
	}

}
 ?>