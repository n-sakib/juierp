<?php 
class client{
	public $name , $phone , $email , $address , $comment= "";

	function __construct($new = [])
	{
		$this->name = $new['name'];
		$this->phone = $new['phone'];
		$this->email = $new['email'];
		$this->address = $new['address'];
	}

	function create()
	{
		require_once '../model/lib/conn.php';

		//echo "<h1>$this->username and the $this->password</h1>";
		mysqli_query($con, "insert into clients (name, phone, email, address) values('$this->name', '$this->phone', '$this->email', '$this->address')");
	}
	function isValid()
	{
		return true;
	}
	static function getAll()
	{
		require_once '../model/lib/conn.php';
		$conn = mysqli_query($con, "select * from clients");
		$result = [];

		while($rows = mysqli_fetch_array($conn))
		{
			$result[] = $rows;
		}

		return $result ;
	}
	static function get($name='')
	{
		require_once '../model/lib/conn.php';
		$conn = mysqli_query($con, "select * from clients where name = '$name' limit 1");
		$row = mysqli_fetch_array($conn);
		// $result = [];

		// while($rows = mysqli_fetch_array($conn))
		// {
		// 	$result[] = $rows;
		// }

		return $row ;
	}

}
 ?>