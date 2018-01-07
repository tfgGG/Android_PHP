<?php

$Json_Parking=file_get_contents('http://data.ntpc.gov.tw/od/data/api/1A71BA9C-EF21-4524-B882-6D085DF2877A?$format=json');
$Decode_Parking = json_decode($Json_Parking);


 /*$content = trim(file_get_contents("php://input"));
 $decodeCon = json_decode($content, true);*/


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

foreach ($Decode_Parking as $row) {
	$sql = "UPDATE parknig SET CellStatus='".$row->CELLSTATUS."' WHERE Id=".$ROW->ID;
	if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
}


   $conn->close();
    

?>