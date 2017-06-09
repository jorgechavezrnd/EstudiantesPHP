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

    if (isset($_POST['enviar'])) {
        
        $json2 = @file_get_contents('http://localhost:8080/SisWebRest/api/v1/students/'.$_POST['studentId']);
        
        if ($json2 == TRUE) {
            echo "El id del estudiante que esta intentando ingresar ya existe";
        } else {

            if (count($_POST['classCodes']) == 0) {
                $codes = [];
            } else {
                $codes = $_POST['classCodes'];
            }

            $data = array(
                'studentId' => $_POST['studentId'],
                'lastName' => $_POST['lastName'],
                'firstName' => $_POST['firstName'],
                'classCodes' => $codes
            );

            $options = array(
                'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
                )
            );

            $url = 'http://localhost:8080/SisWebRest/api/v1/students';
            $context  = stream_context_create( $options );
            $result = file_get_contents( $url, false, $context );
            $response = json_decode( $result );
            
            echo "Se ha registrado un nuevo estudiante";
        }
    }
?>

<h3>Registro de un nuevo estudiante</h3>
<hr>
<form action="" method="POST">
    <label>Student Id:</label><br>
    <input type="number" name="studentId" maxlength="8" required="required">
    <br><br>
    <label>Last Name:</label><br>
    <input type="text" name="lastName" required="required">
    <br><br>
    <label>First Name:</label><br>
    <input type="text" name="firstName" required="required">
    <br><br>
    <label>Class Codes</label><br>
    <select multiple="yes" name="classCodes[]">
        <?php for ($i = 0; $i < count($classes); $i++): ?>
            <option value="<?php echo $classes[$i]->code; ?>"><?php echo $classes[$i]->code; ?></option>
        <?php endfor; ?>
    </select>
    <br><br>
    <input type="submit" name="enviar" value="Crear">
</form>