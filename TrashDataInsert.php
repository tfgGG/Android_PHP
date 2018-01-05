<?php

header('Content-Type: application/json; charset=utf-8');
ini_set("max_execution_time", "300");
$Json_Trash=file_get_contents('http://data.ntpc.gov.tw/od/data/api/EDC3AD26-8AE7-4916-A00B-BC6048D19BF8?$format=json');
$Decode_Trash = json_decode($Json_Trash);
$New_Trash = array();
$Dayarray = array("mon"=>"1","tue"=>"2","wed"=>"3","thu"=>"4","fri"=>"5","sat"=>"6","sun"=>"7");
$DefaultType='garbage';
$index = 0;
$colume="";

	$servername = "localhost";
    $username = "";
    $password = "";

        // Create connection
    $conn = mysqli_connect($servername, $username, $password);

        // Check connectionif (!$conn) {
    if (!$conn) 
        die("Connection failed: " . mysqli_connect_error());
    else
        echo "Connected successfully \n";

    $db_selected = mysqli_select_db($conn,'test');
    if (!$db_selected) 
        die ('Can\'t use: ' . mysqli_error());
    else
        echo "Connect db done\n";


foreach ($Decode_Trash as $row) 
{
	$object= new stdClass();
	foreach ($row as  $key=> $value) 
	{
		//echo $key.$value." \n";
		if(strrpos($key,"_"))
		{
			$Type = substr($key,0,-4);
			$Day = substr($key,-3);

			if(strcmp($DefaultType,$Type)!=0 )
			{
				//echo $Type." ".$colume."\n";
				$object->$Type = $colume;
				$New_Trash[$index]=$object;
				$colume="";
				$DefaultType = $Type;
			}
			
			if(strcmp($value,"Y")==0)
				$colume = $colume.$Dayarray[$Day];			
		}
		else
			$object->$key=$value;
			
	}
	$New_Trash[$index]=$object;
	//$New_Trash[] = $object;
	$index++; 
	//echo "\n\n";
}


$stmt = $conn->prepare("INSERT INTO trash (City,LineId,LineName,Rank,lon,lat,Memo,Time,Garbage,Recycle,Food,Name,Village,ID)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)" );
if ($stmt === FALSE) {
    die ("Mysql Error: " . $conn->error);
}
$stmt->bind_param("sisiddsisssssi",$City,$LineId,$LineName,$Rank,$lon,$lat,$Memo,$Time,$Garbage,$Recycle,$Food,$Name,$Village,$ID);
$count=0;
foreach ($New_Trash as $value) 
{
	try
	{
		$City= $value->city;
		$LineId= $value->lineid;
		$LineName= $value->linename;
		$Rank= $value->rank;
		$lon= $value->longitude;
		$lat= $value->latitude;
		$Memo= $value->memo;
		$Time= $value->time;
		$Garbage= $value->garbage;
		$Recycle= $value->recycling;
		$Food= $value->foodscraps;
		$Name= $value->name;
		$Village= $value->village;
		$ID = $count;
		$stmt->execute();
		//echo $value->lat." ".$value->ID."\n\n";
	}
	catch(Exception $e) {
 		echo 'Message: ' .$e->getMessage();
	}
	$count ++;
	echo $count.$LineName."\n";
	//if($count==10)
	//	break;
}

$stmt->close();
$conn->close(); 



/*
//var_dump($New_Trash)
foreach ($New_Trash as $row) 
{
	foreach ($row as $key=> $value) 
	{
		echo $key.$value." \n";
	}
	echo "\n\n";
}*/
?>
