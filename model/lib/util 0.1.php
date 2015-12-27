<?php 
function arr($conn)
{
	$array = [];
	while($row = mysqli_fetch_array($conn))
	{

		$array[] = $row ;
	}

	return $array;
}
// function Db($query)
// {
// 	$qry = ($con, "$query");
// 	return $row = mysqli_fetch_array($qry);
// }

/**
 * sends a query to the database and returns the rows 
 * back if the query is an select query
 * 
 * @param  [string] $query the query to be passed to the database
 * @return [array]        returns the data array if the query is 
 *                                an insert query
 */
function db($query)
{   
	$con=mysqli_connect("localhost","root","","juierp");
	//set bangla
	mysqli_query($con,"SET CHARACTER SET utf8");
	mysqli_query($con,"SET SESSION collation_connection='utf8_general_ci'") or die(mysqli_connect_error());
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	// echo "$query";
	$qry = mysqli_query($con, "$query");
	$array =[];



	$queryWord = explode(' ',trim($query));
	if ($queryWord[0] == 'select') 
	{
		while ($row = mysqli_fetch_array($qry))
		{
			$array[] = $row;
		}
	}

	if(count($array) == 1 )
	{
		$array = $array[0];
	}
	return $array;
}
function dbEach($query)
{   
	$con=mysqli_connect("localhost","root","","juierp");
	//set bangla
	mysqli_query($con,"SET CHARACTER SET utf8");
	mysqli_query($con,"SET SESSION collation_connection='utf8_general_ci'") or die(mysqli_connect_error());
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	// echo "$query";
	$qry = mysqli_query($con, "$query");
	$array =[];



	$queryWord = explode(' ',trim($query));
	if ($queryWord[0] == 'select') 
	{
		while ($row = mysqli_fetch_array($qry))
		{
			$array[] = $row;
		}
	}
	return $array;
}
//function findDuplicate
function ifExists($tableName, $fieldName, $fieldVal)
{
	$row = db("select * from $tableName where $fieldName = '$fieldVal' limit 1");
	if(count($row)>0)
	{
		echo "exists";
		return true;
	}
	else
	{
		echo "not found";
		return false;
	}
}
function _uploadPhoto($fileVariableName, $filepath, $fileName)
{
	//$name=	$_FILES['image']['name'];
	$name=	$_FILES[$fileVariableName]['name'];
	$temp=	$_FILES[$fileVariableName]['tmp_name'];
	$type=	$_FILES[$fileVariableName]['type'];
	$size=	$_FILES[$fileVariableName]['size'];
	
	$ext =null;

	// Recognizing the extension
	switch( $type ){
		
		// Image/Jpeg
		case 'image/jpeg':
			$ext= '.jpg';
		break;
		
		// Image/png
		case 'image/png':
			$ext= '.png';
		break;
		
		// Image/gif
		case 'image/gif':
			$ext= '.gif';
		break;
		
	}
	
	//$file_name = utf8_encode($_POST['company_name'])
	$fileName = $fileName."";
	$path= 'img/clients/' . $fileName . $ext;

	// Check for the Image post.
	if( $_POST ){
	
		// Got into the POST check.
	
		if( $_FILES ){
		
			// Got into the FILES check.
			move_uploaded_file( $temp, $path );
		}
	
	}
}
function _uploadPhotos($fileVariableName, $filepath)
{
	foreach ($_FILES[$fileVariableName]['name'] as $index => $value) {
		$fileName = $_FILES[$fileVariableName]['name'][$index];
		uploadPhoto($fileVariableName,$filepath,$fileName);
	}
}

function uploadPhoto($htmlName, $newFileName)
{
	// initial data fetching
	$name=	$_FILES[$htmlName]['name'];
	$tempName=	$_FILES[$htmlName]['tmp_name'];
	$type=	$_FILES[$htmlName]['type'];
	$size=	$_FILES[$htmlName]['size'];

	// Recognizing the extension
	switch( $type ){
		
		// Image/Jpeg
		case 'image/jpeg':
			$ext= '.jpg';
		break;
		
		// Image/png
		case 'image/png':
			$ext= '.png';
		break;
		
		// Image/gif
		case 'image/gif':
			$ext= '.gif';
		break;
		
	}
	
	//$file_name = utf8_encode($_POST['company_name'])
	$fileName = $newFileName."";

	$path = dirname(__FILE__)."/../../media/image/product/shoe/". $fileName . $ext;
	//$path = "/../../media/image/product/shoe/". $fileName . $ext;
	echo "$path";

	// Check for the Image post.
	if($_FILES){
		echo "$tempName";
		// Got into the xXxPOSTxXx and FILES check.
			move_uploaded_file( $tempName, $path );
	
	}
	if ($_FILES[$htmlName]["error"] > 0)
       {echo "Error: " . $_FILES["file"]["error"] . "<br>";}
}
 ?>