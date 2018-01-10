<?php

ignore_user_abort();
set_time_limit(0);

$Json_Parking=file_get_contents('http://data.ntpc.gov.tw/od/data/api/1A71BA9C-EF21-4524-B882-6D085DF2877A?$format=json');
$Decode_Parking = json_decode($Json_Parking);
ini_set("max_execution_time", "1000");


 /*$content = trim(file_get_contents("php://input"));
 $decodeCon = json_decode($content, true);*/


 $servername = "localhost";
 $username = "";
 $password = "";
 $cnt=1;

//sleep time(seconds)
$interval = 100;

    // Create connection
$conn = mysqli_connect($servername, $username, $password);


do{
    //wait $interval seconds, run again
    sleep($interval);

    // Check connectionif (!$conn) {
    if (!$conn) 
        die("Connection failed: " . mysqli_connect_error());
    else
        echo "Connected successfully" . $cnt . "<br />";

    //if on second loops, break out the loop
    if($cnt == 5){
        break;
    }
    else{

        $db_selected = mysqli_select_db($conn,'test');
        if (!$db_selected) 
            die ('Can\'t use: ' . mysqli_error());
                //else
               // echo "Connect db done\n";
        $flag = 0;
        foreach ($Decode_Parking as $row) {
        	$sql = "UPDATE parknig SET CellStatus='".$row->CELLSTATUS."' WHERE Id=".$row->ID;
        	if ($conn->query($sql) === FALSE) {
                echo "Record updated successfully";
                $flag = 1 ;
                break;
            } 
        }
        
        $cnt+=1;

        if($flag == 1)
            echo "更新失敗";
        else
            echo "更新成功" . " <br />";
       }

}while(true);

$conn->close();

//http://localhost/Android_PHP/UpdateParkingStatus.php
?>