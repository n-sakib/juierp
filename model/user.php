<?php 

/*==============================================
	user class
	
	@level is an arbitrary constant its values are
		1 => denotes the user is an admin
		2 => user is a moderator
		3 => user is the cashier
		404 => user is a developer

==============================================*/

class user{
	public static $name = "নাম";
	
	public $username = "";
	public $password = "";
	public $level = 0;
	/*==============================================
		is logged in
	==============================================*/
	
	public static $isLoggedIn = 0 ; //has two states true and false
	public static $isNotLoggedIn = 1;


	function __construct($user = "" , $pass ="")
	{
		user::$name = $user;
		$this->username = $user;
		$this->password = $pass;
	}

	function create()
	{
		require_once '../model/lib/conn.php';

		//echo "<h1>$this->username and the $this->password</h1>";
		mysqli_query($con, "insert into users (user, level, pass) values('$this->username', 1, '$this->password')");
	}

	function login()
	{
		require_once '../model/lib/conn.php'; //views are always one level down from root but not more than one
		$conn = mysqli_query($con, "select * from users where user = '$this->username' and pass = '$this->password'");

		//$res = mysqli_fetch_array($conn);
		if (mysqli_num_rows($conn) > 0)
		{
			@session_start();
			$_SESSION['user'] = $this->username;
		}
		else
		{
			@session_start();
			$_SESSION['user'] = "অতিথি";
		}
	} 
	function logout()
	{
		session_unset();
	}
	static function isLoggedIn()
	{
		
	}
	function isNotLoggedIn()
	{
	}
}
 ?>