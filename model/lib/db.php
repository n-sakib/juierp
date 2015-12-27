<?php 
//assorted helpers
function arr($conn)
{
	$array = [];
	while($row = mysqli_fetch_array($conn))
	{

		$array[] = $row ;
	}

	return $array;
}
//db helper class
class db(){
	
}

 ?>