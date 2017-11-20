
<?php

include("UpdateDB.php"); 

header('Content-Type: application/json');

SQLConnect();

function CalculateDis($lat1,$lon1,$lat2,$lon2)
{
    $earthRadius = 6371000; //meters
    $dLat = Math.toRadians($lat2-$lat1);
    $dLng = Math.toRadians($lon2-$lon1);
    $a = Math.sin($dLat/2) * Math.sin($dLat/2) +
               Math.cos(Math.toRadians($lat1)) * Math.cos(Math.toRadians($lat2)) *
               Math.sin($dLng/2) * Math.sin($dLng/2);
    $c = 2 * Math.atan2(Math.sqrt($a), Math.sqrt(1-$a));
    $dist = (float) ($earthRadius * c);

    return dist;
}

//$lat,$lon
function CalCulateRecent($lat,$lon)
{
    //$lat = $_REQUEST["lat"];
    //$lon = $_REQUEST["lon"];

    $ResponseArray = array(); //Remember to pass other feilds 
    if ($result = $mysqli->query("SELECT lat,lon,ID FROM parknig")) 
    {
        while($row = $result->fetch_array(MYSQL_ASSOC)) 
        {
                $dis = CalculateDis(25.0354351,121.4302754,$row->lat,$row->lon);
                $row->Distance = $dist;
                $ResponseArray[] = $row;
        }
    }
    $result->close();
    echo json_encode($ResponseArray);

}

//echo "距離 = ".CalculateDis(25.0354351,121.4302754,25.0403582,21.4449868);

   
?>