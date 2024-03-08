#!/usr/bin/php -q
<?php

	  set_time_limit(30);
	  require('phpagi.php');
	  error_reporting(E_ALL);

	  $servername = "localhost";
	  $username = "root";
          $password = "";
	  $dbname = "as_test_log";

	  $conn = new mysqli($servername, $username, $password, $dbname);
	  
	  if($conn->connect_error){
		die("Connection failed: ". $con->connect_error);
           }


	  $agi = new AGI();
	  $agi->answer();

 	  //$agi->stream_file('', 7500);
	  //$agi->get_data('mm_intro_1', 7500, 1);
	  $result1 = $agi->get_data('hello-world', 3000, 1);
	  $result2 = $agi->get_data('hello-world', 3000, 1);
	  $result3 = $agi->get_data('hello-world', 3000, 1);

	  $jsnResult2 = json_encode($result2);
	  $result2Value = $result2['result'];
	  $result3Value = $result3['result'];


	 $sql = "INSERT INTO call_data_log (raw_log, first_value, second_value) VALUES('{$jsnResult2}', '{$result2Value}', '{$result3Value}')";
	 
         $conn->query($sql);
 	 $conn->close();


	  $agi->hangup();
	
