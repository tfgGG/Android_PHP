
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
        $Resultobject = new stdClass();
        $InsideObject = new stdClass();
        $ResponseArray = array(); 

        if ($result = $conn->query("SELECT City,LineId,LineName,GROUP_CONCAT( DISTINCT Village SEPARATOR ',') AS Village
                                     FROM trash GROUP BY LineId")) 
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