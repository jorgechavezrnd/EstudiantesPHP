<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    if (isset($_GET['id'])) {
        $json = @file_get_contents('http://localhost:8080/SisWebRest/api/v1/students/'.$_GET['id']);
        
        if ($json == TRUE) {
            $student = json_decode($json);
        }
        
    } else {
        header("Location: index.php");
    }
    
    function showClassCodes($classCodes) {

        if (count($classCodes) <= 0) {
            echo '[]';
        } else {

            echo '[';

            for ($i = 0; $i < (count($classCodes) - 1); $i++) {
                echo $classCodes[$i].', ';
            }

            echo $classCodes[count($classCodes) - 1].']';
        }

    }

?>

<b>Student Id:</b> <?php echo $student->studentId ?>
<br><br>

<b>Last Name:</b> <?php echo $student->lastName ?>
<br><br>

<b>First Name:</b> <?php echo $student->firstName ?>
<br><br>

<b>Class Codes:</b> <?php echo showClassCodes($student->classCodes) ?>
<br><br>