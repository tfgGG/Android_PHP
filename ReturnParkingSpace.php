
<?php
header('Content-Type: application/json; charset=utf-8');


  $content = trim(file_get_contents("php://input"));
  $decodeCon = json_decode($content, true);
  $Lat = $decodeCon["Lat"];
  $Lon = $decodeCon["Lon"];
  $type = $decodeCon["type"];



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
        $ResponseArray = array(); 

        if(strcmp("trash", $type)){
          $dismax = 1000;
          $sql = "SELECT * FROM trash";
        }
        else{
          $dismax = 1000;
          $sql = "SELECT * FROM parknig"; 
        }



        if ($result = $conn->query($sql)) 
        {
            //foreach($result as $row)
            //{
                while($row = $result->fetch_array(MYSQLI_ASSOC)) 
                {
                    $dis = CalculateDis($Lat,$Lon,$row['Lat'],$row['Lon']);

                    if($dis<$dismax){
                         $row['Distance'] = $dis;
                         $ResponseArray[] = $row; 
                    }           
                }                   

            $Resultobject->ParkingResult = $ResponseArray;
        }
        //var_dump($Resultobject);
       
  echo json_encode($Resultobject);
 
   // echo $Lat." ".$Lon;
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


?>