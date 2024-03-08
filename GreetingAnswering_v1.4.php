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

 	  // intro
          $agi->stream_file('ngo_ivr/mm/mm_intro', 7000);	

	  // choose language
          $chosenLang = null;
          chooseLangaugeScript();


          // key message
	  for($i = 1; $i <= 3; $i++){


		 
	      if($chosenLang == 1){
	          // play mm script
		  $agi->stream_file('ngo_ivr/mm/mm_key_message',97000);
                  // outro
                  $agi->stream_file('ngo_ivr/mm/mm_outro', 25000);
                  
                  // break loop
                  break;
	
	      }
	      elseif($chosenLang == 2){
		  // play poe karen script
                  $agi->stream_file('ngo_ivr/pok/poe_kayin_full',236000);
                  
                  // break loop
                  break;
	      }
 	      elseif($chosenLang == 3){
		  // play karen script
                  $agi->stream_file('ngo_ivr/skk/sakaw_kayin_full_recording',189000);

                  // break loop
                  break;
                 
	  // outro
	      }
	      else{
	          // play invalid input 
                  $agi->stream_file('pm-invalid-option', 4500);
                  chooseLangaugeScript();

                 
                  // reset loop to 1
		  $i = 1;
              }

	}



	  
	
	
	 /* $result2 = $agi->get_data('ngo_ivr/mm_intro_1', 7500, 1);
	  $result3 = $agi->get_data('ngo_ivr/mm_intro_1', 7500, 1);

	  $jsnResult2 = json_encode($result2);
	  $result2Value = $result2['result'];
	  $result3Value = $result3['result'];


	 $sql = "INSERT INTO call_data_log (raw_log, first_value, second_value, dailing_number, schedule_id) VALUES('{$jsnResult2}', '{$result2Value}', '{$result3Value}', '{$dailingNumber}', {$scheduleId})";
	 
         $conn->query($sql);
 	 $conn->close();*/


        


	  $agi->hangup();


    function chooseLangaugeScript() use($agi, $chosenLang){
	$langResult = $agi->get_data('ngo_ivr/mm/mm_choice', 18000, 1);
        $chosenLang = $langResult['result'];

    }	
