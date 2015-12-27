<?php 
@session_start();
$_SESSION['user'] = "অতিথি";
header('Location: index.php')
 ?>