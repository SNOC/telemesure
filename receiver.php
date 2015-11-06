<?php
/* *** receive data from telemesure.net service
*/

define("MODE", "GET"); //use GET, POST or EXTENDED
define("FILENAME", "log/receive_log.txt"); //name of the file

if(MODE === "GET")
{
	$id = $_GET["id"];		// transmitter ID
	$data = $_GET["data"];	// payload
	file_put_contents(FILENAME, "$id,$data\n", FILE_APPEND | LOCK_EX);
	
} else if ( MODE === "POST"){
	$id = $_POST["id"];		// transmitter ID
	$data = $_POST["data"];	// payload
	file_put_contents(FILENAME, "$id,$data\n", FILE_APPEND | LOCK_EX);
	
} else if ( MODE === "EXTENDED") {
	$id = $_POST["id"];		// transmitter ID
	$data = $_POST["data"];	// payload
	$node_ref = $_POST["node_ref"];			// id of the receiver
	$link_quality= $_POST["link_quality"];	// level of the link quality
	$rssi= $_POST["rssi"];					// intensity of signal
	$lat= $_POST["lat"];					// geo latitude
	$lng= $_POST["lng"];					// geo longitude
	file_put_contents(FILENAME, "$id,$data\n", FILE_APPEND | LOCK_EX);
	file_put_contents(FILENAME, ">>FROM:$node_ref LinkQuality:$link_quality Rssi:$rssi lat=$lat lng=$lng\n", FILE_APPEND | LOCK_EX);
}

?>