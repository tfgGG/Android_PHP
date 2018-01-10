
<?php
header('Content-Type: application/json; charset=utf-8');

  $servername = "localhost";
    $username = "";
    $password = "";
$content = trim(file_get_contents("php://input"));
$decodeCon = json_decode($content, true);
$ID = $decodeCon["ID"];

//$ID = 207002;

        // Create connection
$conn = mysqli_connect($servername, $username, $password);

        // Check connectionif (!$conn) {
if (!$conn) 
    die("Connection failed: " . mysqli_connect_error());
    //else
        //echo "Connected successfully \n";

$db_selected = mysqli_select_db($conn,'test');
if (!$db_selected) 
    die ('Can\'t use: ' . mysqli_error());
    //else
        //echo "Connect db done\n";

$Resultobject = new stdClass();
$ResponseArray = array(); 

$sql= "SELECT * FROM trash WHERE LineId =".$ID;
if ($result = $conn->query($sql)) 
{
    while($row = $result->fetch_array(MYSQLI_ASSOC)) 
    {
      $ResponseArray[] = $row;           
  }                   

  $Resultobject->ParkingResult = $ResponseArray;
}

//var_dump($Resultobject);
echo json_encode($Resultobject);

   // echo $Lat." ".$Lon;
$result->close();


?>