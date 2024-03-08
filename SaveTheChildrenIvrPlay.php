#!/usr/bin/php -q
<?php

set_time_limit(30);
require('phpagi.php');
error_reporting(E_ALL);

$servername = "localhost";
$username = "ivr_db_user";
$password = "bae7phaeVeeYooh)";
$dbname = "db_ngo_ivr_blast";
$dailingNumber = '0';
$scheduleId = 0;



if (isset($argv)) {
    $dailingNumber = $argv[1];
    $scheduleId = $argv[2];
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$agi = new AGI();
$dailStatus = $agi->get_variable('DIALSTATUS');

$sql = "UPDATE schedule_phones SET status = 'answered' WHERE schedule_id = {$scheduleId} AND phone_number = {$dailingNumber}";



$agi->answer();

$conn->query($sql);



// intro
$agi->stream_file('ngo_ivr/mm/mm_greet', 5007);

$chosenLang = null;

$q1_answer = null;
$q2_answer = null;





// key message
for ($i = 1; $i <= 3; $i++) {
    // choose language
    $chosenLang = chooseLangaugeScript($agi);



    if ($chosenLang === "") {
        continue;
    } elseif ($chosenLang == 1) {

        for ($i = 1; $i <= 3; $i++) {

            // mm intro and ask child age,  child age range (1 for 0-3, 2 for > 3)
            $childAgeRange = $agi->get_data('ngo_ivr/mm/mm_intro_1', 21051, 1);

            if ($childAgeRange['result'] == 1) {

                // key message if pressed 1
                $agi->stream_file('ngo_ivr/mm/mm_key_message_pressed_1', 130849);

                for ($i = 1; $i <= 3; $i++) {

                    // quiz if press 1
                    $quizPress1Result = $agi->get_data('ngo_ivr/mm/mm_quiz_press_1_result', 20401, 1);

                    if ($quizPress1Result['result'] == 1) {
                        // correct anaswer for press 1
                        $agi->stream_file('ngo_ivr/mm/mm_quiz_press_1_correct', 9079);
                        $q1_answer = 1;

                        $conn->close();
                        break;
                    } elseif ($quizPress1Result['result'] == 2) {
                        // incorrect answer for press 1
                        $agi->stream_file('ngo_ivr/mm/mm_quiz_press_1_incorrect', 9755);
                        $q1_answer = 2;


                        break;
                    } else {
                        // play invalid input
                        $agi->stream_file('pm-invalid-option', 4500);
                    }
                }


                break;
            } elseif ($childAgeRange['result'] == 2) {

                // key message if pressed 1
                $agi->stream_file('ngo_ivr/mm/mm_key_message_pressed_2', 144408);

                for ($i = 1; $i <= 3; $i++) {

                    // quiz if press 2
                    $quizPress1Result = $agi->get_data('ngo_ivr/mm/mm_quiz_press_2_result', 19775, 1);

                    if ($quizPress1Result['result'] == 1) {
                        // correct anaswer for press 1
                        $agi->stream_file('ngo_ivr/mm/mm_quiz_press_2_correct', 9581);
                        $q2_answer = 1;
                        break;
                    } elseif ($quizPress1Result['result'] == 2) {
                        // incorrect answer for press 1
                        $agi->stream_file('ngo_ivr/mm/mm_quiz_press_2_incorrect', 11207);
                        $q2_answer = 2;
                        break;
                    } else {
                        // play invalid input
                        $agi->stream_file('pm-invalid-option', 4500);
                    }
                }

                break;
            } else {
                // play invalid input
                $agi->stream_file('pm-invalid-option', 4500);
            }
        }

        if ($q1_answer != null) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE schedule_phones SET q1_answer = '{$q1_answer}' WHERE schedule_id = '{$scheduleId}' AND phone_number = '{$dailingNumber}'";
            $conn->query($sql);
            $conn->close();
        }


        if ($q2_answer != null) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE schedule_phones SET q2_answer = '{$q2_answer}' WHERE schedule_id = '{$scheduleId}' AND phone_number = '{$dailingNumber}'";
            $conn->query($sql);
            $conn->close();
        }




        // outro
        $agi->stream_file('ngo_ivr/mm/mm_outtro', 15409);

        // break loop
        break;
    } elseif ($chosenLang == 2) {
        for ($i = 1; $i <= 3; $i++) {

            // mm intro and ask child age,  child age range (1 for 0-3, 2 for > 3)
            $childAgeRange = $agi->get_data('ngo_ivr/pok/poe_intro', 36370, 1);

            if ($childAgeRange['result'] == 1) {

                // key message if pressed 1
                $agi->stream_file('ngo_ivr/pok/poe_key_message_pressed_1', 308175);

                for ($i = 1; $i <= 3; $i++) {

                    // quiz if press 1
                    $quizPress1Result = $agi->get_data('ngo_ivr/pok/poe_quiz_press_1_result', 28627, 1);

                    if ($quizPress1Result['result'] == 1) {
                        // correct anaswer for press 1
                        $agi->stream_file('ngo_ivr/pok/poe_quiz_press_1_correct', 17084);
                        $q1_answer = 1;

                        $conn->close();
                        break;
                    } elseif ($quizPress1Result['result'] == 2) {
                        // incorrect answer for press 1
                        $agi->stream_file('ngo_ivr/pok/poe_quiz_press_1_incorrect', 21255);
                        $q1_answer = 2;


                        break;
                    } else {
                        // play invalid input
                        $agi->stream_file('pm-invalid-option', 4500);
                    }
                }


                break;
            } elseif ($childAgeRange['result'] == 2) {

                // key message if pressed 1
                $agi->stream_file('ngo_ivr/pok/poe_key_message_pressed_2', 32499);

                for ($i = 1; $i <= 3; $i++) {

                    // quiz if press 2
                    $quizPress1Result = $agi->get_data('ngo_ivr/pok/poe_quiz_press_2_result', 53000, 1);

                    if ($quizPress1Result['result'] == 1) {
                        // correct anaswer for press 1
                        $agi->stream_file('ngo_ivr/pok/poe_quiz_press_2_correct', 13414);
                        $q2_answer = 1;
                        break;
                    } elseif ($quizPress1Result['result'] == 2) {
                        // incorrect answer for press 1
                        $agi->stream_file('ngo_ivr/pok/poe_quiz_press_2_incorrect', 14581);
                        $q2_answer = 2;
                        break;
                    } else {
                        // play invalid input
                        $agi->stream_file('pm-invalid-option', 4500);
                    }
                }

                break;
            } else {
                // play invalid input
                $agi->stream_file('pm-invalid-option', 4500);
            }
        }

        if ($q1_answer != null) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE schedule_phones SET q1_answer = '{$q1_answer}' WHERE schedule_id = '{$scheduleId}' AND phone_number = '{$dailingNumber}'";
            $conn->query($sql);
            $conn->close();
        }


        if ($q2_answer != null) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE schedule_phones SET q2_answer = '{$q2_answer}' WHERE schedule_id = '{$scheduleId}' AND phone_number = '{$dailingNumber}'";
            $conn->query($sql);
            $conn->close();
        }




        // outro
        $agi->stream_file('ngo_ivr/pok/poe_outtro', 24358);
        // break loop
        break;
    } elseif ($chosenLang == 3) {
        for ($i = 1; $i <= 3; $i++) {

            // mm intro and ask child age,  child age range (1 for 0-3, 2 for > 3)
            $childAgeRange = $agi->get_data('ngo_ivr/skk/sk_intro', 20601, 1);

            if ($childAgeRange['result'] == 1) {

                // key message if pressed 1
                $agi->stream_file('ngo_ivr/skk/sk_key_message_pressed_1', 376873);

                for ($i = 1; $i <= 3; $i++) {

                    // quiz if press 1
                    $quizPress1Result = $agi->get_data('ngo_ivr/skk/sk_quiz_press_1_result', 29344, 1);

                    if ($quizPress1Result['result'] == 1) {
                        // correct anaswer for press 1
                        $agi->stream_file('ngo_ivr/skk/sk_quiz_press_1_incorrect', 15566);
                        $q1_answer = 1;

                        $conn->close();
                        break;
                    } elseif ($quizPress1Result['result'] == 2) {
                        // incorrect answer for press 1
                        $agi->stream_file('ngo_ivr/skk/sk_quiz_press_1_correct', 13960);
                        $q1_answer = 2;


                        break;
                    } else {
                        // play invalid input
                        $agi->stream_file('pm-invalid-option', 4500);
                    }
                }


                break;
            } elseif ($childAgeRange['result'] == 2) {

                // key message if pressed 1
                $agi->stream_file('ngo_ivr/skk/sk_key_message_pressed_2', 200216);

                for ($i = 1; $i <= 3; $i++) {

                    // quiz if press 2
                    $quizPress1Result = $agi->get_data('ngo_ivr/skk/sk_quiz_press_2_result', 39884, 1);

                    if ($quizPress1Result['result'] == 1) {
                        // correct anaswer for press 1
                        $agi->stream_file('ngo_ivr/skk/sk_quiz_press_2_correct', 24911);
                        $q2_answer = 1;
                        break;
                    } elseif ($quizPress1Result['result'] == 2) {
                        // incorrect answer for press 1
                        $agi->stream_file('ngo_ivr/skk/sk_quiz_press_2_incorrect', 24345);
                        $q2_answer = 2;
                        break;
                    } else {
                        // play invalid input
                        $agi->stream_file('pm-invalid-option', 4500);
                    }
                }

                break;
            } else {
                // play invalid input
                $agi->stream_file('pm-invalid-option', 4500);
            }
        }

        if ($q1_answer != null) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE schedule_phones SET q1_answer = '{$q1_answer}' WHERE schedule_id = '{$scheduleId}' AND phone_number = '{$dailingNumber}'";
            $conn->query($sql);
            $conn->close();
        }


        if ($q2_answer != null) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE schedule_phones SET q2_answer = '{$q2_answer}' WHERE schedule_id = '{$scheduleId}' AND phone_number = '{$dailingNumber}'";
            $conn->query($sql);
            $conn->close();
        }




        // outro
        $agi->stream_file('ngo_ivr/skk/sk_outro', 26116);

        // break loop
        break;
    } else {
        // play invalid input
        $agi->stream_file('pm-invalid-option', 4500);
        // choose language
        $chosenLang = chooseLangaugeScript($agi);


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


function chooseLangaugeScript($agi)
{
    $langResult = $agi->get_data('ngo_ivr/mm/mm_choice', 18500, 1);
    $chosenLang = $langResult['result'];
    return $chosenLang;
}

