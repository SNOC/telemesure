<?php
/* *** receive data from telemesure.net service
*/
define("MODE", "DECODED"); //use GET, POST or EXTENDED
define("FILENAME", "received_log.txt"); //name of the file
if (MODE === "GET") {
	$id = $_GET["id"];  // transmitter ID
    $data = $_GET["data"]; // payload
    file_put_contents(FILENAME, "$id,$data\n", FILE_APPEND | LOCK_EX);
	
} else if (MODE === "POST") {
    $id = $_POST["id"];  // transmitter ID
    $data = $_POST["data"]; // payload
    file_put_contents(FILENAME, "$id,$data\n", FILE_APPEND | LOCK_EX);
	
} else if (MODE === "EXTENDED") {
    $id = $_POST["id"];  // transmitter ID
    $data = $_POST["data"]; // payload
    $node_ref = $_POST["node_ref"];   // id of the receiver
    $link_quality = $_POST["link_quality"]; // level of the link quality
    $rssi = $_POST["rssi"];     // intensity of signal
    $lat = $_POST["lat"];     // geo latitude
    $lng = $_POST["lng"];     // geo longitude
    file_put_contents(FILENAME, "$id,$data\n", FILE_APPEND | LOCK_EX);
    file_put_contents(FILENAME, ">>FROM:$node_ref LinkQuality:$link_quality Rssi:$rssi lat=$lat lng=$lng\n", FILE_APPEND | LOCK_EX);
	
} else if (MODE === "DECODED") {
    $receivedData = json_decode(file_get_contents('php://input'), true); //Decode received json data
    $id = $receivedData["id"];      // transmitter ID
    $raw_data = $receivedData["raw_data"];   // Encoded raw data 
    $node_ref = $receivedData["node_ref"];   // id of the receiver
    $link_quality = $receivedData["link_quality"]; // level of the link quality
    $rssi = $receivedData["rssi"];     // intensity of signal
    $lat = $receivedData["lat"];     // geo latitude
    $lng = $receivedData["lng"];     // geo longitude

	//Unstack received data to exploit it
    $datas = $receivedData["datas"];
    $unstackedData = [];
    foreach ($datas as $data => $content) { // Iterate on each evenement
	$timestamp = $content["timestamp"];  // Get timestamp of event
	file_put_contents(FILENAME, "$timestamp\n", FILE_APPEND | LOCK_EX);		
	$values = $content["values"];
	array_push($unstackedData, [$timestamp, $values]);
	foreach ($values as $key => $value)
		file_put_contents(FILENAME, "$key:$value\n", FILE_APPEND | LOCK_EX);
    }
    file_put_contents(FILENAME, ">>FROM:$node_ref LinkQuality:$link_quality Rssi:$rssi lat=$lat lng=$lng\n", FILE_APPEND | LOCK_EX);
}
    
