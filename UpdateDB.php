<?php
//Global $conn;
header('Content-Type: application/json; charset=utf-8');
ini_set("max_execution_time", "1000");


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




$Json_Parking=file_get_contents('http://data.ntpc.gov.tw/od/data/api/1A71BA9C-EF21-4524-B882-6D085DF2877A?$format=json');
$Decode_Parking = json_decode($Json_Parking);
//var_dump($data);

$count = 0 ;
//$sql_tmp = "INSERT INTO parking (".$columnName.") VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare("INSERT INTO parknig (Id,CellId,Name,Day,Hour,Pay,PayCash,Memo,RoadId,CellStatus,IsNowCash,ParkingStatus,Lat,Lon)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)" );
if ($stmt === FALSE) {
    die ("Mysql Error: " . $conn->error);
}
$stmt->bind_param("iissssssssiidd",$Id,$CellId,$Name,$Day,$Hour,$Pay,$PayCash,$Memo,$RoadId,$CellStatus,$IsNowCash,$ParkingStatus,$Lat,$Lon);

foreach ($Decode_Parking as $value) 
{
	try
	{
		$Id= $value->ID;
		$CellId= $value->CELLID;
		$Name= $value->NAME;
		$Day= $value->DAY;
		$Hour= $value->HOUR;
		$Pay= $value->PAY;
		$PayCash= $value->PAYCASH;
		$Memo= $value->MEMO;
		$RoadId= $value->ROADID;
		$CellStatus= $value->CELLSTATUS;
		$IsNowCash= $value->ISNOWCASH;
		$ParkingStatus= $value->ParkingStatus;
		$Lat= $value->lat;
		$Lon= $value->lon;
		ECHO $PayCash.$Name.$CellStatus;
		$stmt->execute();
		//echo $value->lat." ".$value->ID."\n\n";
	}
	catch(Exception $e) {
 		echo 'Message: ' .$e->getMessage();
	}
	$count ++;
	echo $count."\n";
	//if($count==10)
	//	break;
}

$stmt->close();
$conn->close(); 
?>

