<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $json = @file_get_contents('http://localhost:8080/SisWebRest/api/v1/classes');

    if ($json == TRUE) {
        $classes = json_decode($json);
    }

    if (isset($_GET['id'])) {
        $json2 = @file_get_contents('http://localhost:8080/SisWebRest/api/v1/students/'.$_GET['id']);
        
        if ($json2 == TRUE) {
            $student = json_decode($json2);
        }
    } else {
        header("Location: index.php");
    }
    
    if (isset($_POST['enviar'])) {
        
        if (count($_POST['classCodes']) == 0) {
            $codigos = [];
        } else {
            $codigos = $_POST['classCodes'];
        }
        
        $data = array(
            'studentId' => $_GET['id'],
            'lastName' => $_POST['lastName'],
            'firstName' => $_POST['firstName'],
            'classCodes' => $codigos
        );

        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:8080/SisWebRest/api/v1/students/'.$_GET['id']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        
        header('Location: index.php');
    }
?>

<form action="" method="POST">
    Student Id: <br>
    <input type="number" name="studentId" value="<?php echo $student->studentId; ?>" disabled>
    <br><br>
    Last Name: <br>
    <input type="text" name="lastName" value="<?php echo $student->lastName; ?>" required>
    <br><br>
    First Name: <br>
    <input type="text" name="firstName" value="<?php echo $student->firstName; ?>" required>
    <br><br>
    Class Codes: <br>
    <select multiple="yes" name="classCodes[]">
        <?php for ($i = 0; $i < count($classes); $i++): ?>
            <option value="<?php echo $classes[$i]->code; ?>"><?php echo $classes[$i]->code; ?></option>
        <?php endfor; ?>
    </select>
    <br><br>
    <input type="submit" name="enviar" value="Editar">
</form>