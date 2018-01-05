
<?php
header('Content-Type: application/json; charset=utf-8');

$servername = "localhost";
    $username = "";
    $password = "";

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

    $count=0;
    $Resultobject = new stdClass();
    $InsideObject = new stdClass();
    $ResponseArray = array(); //Remember to pass other feilds 
    if ($result = $conn->query("SELECT * FROM parknig")) 
    {
        //foreach($result as $row)
        //{
            while($row = $result->fetch_array(MYSQLI_BOTH)) 
            {
                $dis = CalculateDis(25.0354351,121.4302754,$row['Lat'],$row['Lon']);
                $row['Distance'] = $dis;
                //var_dump($row);
                $ResponseArray[] = $row;

               //foreach ($row as $key=>$value) 
                 //  $InsideObject-> $key = $value;
               // $InsideObject->Lat = $row["Lat"];
                //$ResponseArray[$count]= $InsideObject;
                //echo $count++."\n";            
            }        
            
        //}

        $Resultobject->ParkingResult = $ResponseArray;
    }
    //var_dump($Resultobject);
    echo json_encode($Resultobject);
   $result->close();
    


function CalculateDis($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{
    $earthRadius = 6371000;
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $lonDelta = $lonTo - $lonFrom;
  $a = pow(cos($latTo) * sin($lonDelta), 2) +
    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

  $angle = atan2(sqrt($a), $b);
  return $angle * $earthRadius;
}

//$lat,$lon

    //$lat = $_REQUEST["lat"];
    //$lon = $_REQUEST["lon"];

    


//echo "距離 = ".CalculateDis(25.0354351,121.4302754,25.0403582,21.4449868);
?>