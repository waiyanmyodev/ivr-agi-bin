#!/usr/bin/php -q
<?php

	  set_time_limit(30);
	  require('phpagi.php');
	  error_reporting(E_ALL);

	  $servername = "localhost";
	  $username = "root";
          $password = "";
	  $dbname = "as_test_log";
	  $dailingNumber = '0';
	  $scheduleId = 0;

	  if(isset($argv)){
	    $dailingNumber = $argv[1];
	    $scheduleId = $argv[2];
          }

	  $conn = new mysqli($servername, $username, $password, $dbname);
	  
	  if($conn->connect_error){
		die("Connection failed: ". $con->connect_error);
           }


	  $agi = new AGI();
	  $agi->answer();

 	  //$agi->stream_file('', 7500);
	  //$agi->get_data('mm_intro_1', 7500, 1);
	  $result1 = $agi->get_data('hello-world-gsm', 3000, 1);
	  $result2 = $agi->get_data('hello-world-gsm', 3000, 1);
	  $result3 = $agi->get_data('hello-world-gsm', 3000, 1);

	  $jsnResult2 = json_encode($result2);
	  $result2Value = $result2['result'];
	  $result3Value = $result3['result'];


	 $sql = "INSERT INTO call_data_log (raw_log, first_value, second_value, dailing_number, schedule_id) VALUES('{$jsnResult2}', '{$result2Value}', '{$result3Value}', '{$dailingNumber}', {$scheduleId})";
	 
         $conn->query($sql);
 	 $conn->close();


	  $agi->hangup();
	
