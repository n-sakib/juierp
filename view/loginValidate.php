<?php 
require_once '../model/user.php';
if(isset($_POST["loginUser"]))
{
	$visitingUser = new user($_POST["loginUser"],$_POST["loginPass"]);
	@session_start();
	$visitingUser->login();
}
header('Location: index.php');

?>