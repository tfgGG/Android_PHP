
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
    else
        echo "Connected successfully \n";

    $db_selected = mysqli_select_db($conn,'test');
    if (!$db_selected) 
        die ('Can\'t use: ' . mysqli_error());
    else
        echo "Connect db done\n";

    $ResponseArray = array(); //Remember to pass other feilds 
    if ($result = $conn->query("SELECT * FROM parknig")) 
    {
        foreach($result as $row)
        {
            while($row = $result->fetch_array(MYSQLI_ASSOC)) 
            {
                $dis = CalculateDis(25.0354351,121.4302754,$row['Lat'],$row['Lon']);
                $row['Distance'] = $dis;
                //var_dump($row);
                //$ResponseArray[] = $row;
                foreach ($row as $key=>$value) {
                    echo $value." ";
                }
                echo "\n";
            }
        }
    }

    
   $result->close();
    //echo json_encode($ResponseArray);


function CalculateDis($lat1,$lon1,$lat2,$lon2)
{
    $earthRadius = 6371000; //meters
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $latT2 = deg2rad($lat2);
    $lonT2 = deg2rad($lon2);

    $latDelta = $lat2 - $lat1;
    $lonDelta = $lon2 - $lon1;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;

}

//$lat,$lon

    //$lat = $_REQUEST["lat"];
    //$lon = $_REQUEST["lon"];

    


//echo "距離 = ".CalculateDis(25.0354351,121.4302754,25.0403582,21.4449868);
?>