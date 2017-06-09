<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $json = @file_get_contents('http://localhost:8080/SisWebRest/api/v1/students');

    if ($json == TRUE) {
        $students = json_decode($json);
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

<h3>Students</h3>
<table border="1">
    <thead>
        <th>studentId</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Class Codes</th>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < count($students); $i++): ?>
            <tr>
                <td><?php echo $students[$i]->studentId ?></td>
                <td><?php echo $students[$i]->lastName ?></td>
                <td><?php echo $students[$i]->firstName ?></td>
                <td><?php showClassCodes($students[$i]->classCodes) ?></td>
                <td>
                    <a href="?cargar=ver&id=<?php echo $students[$i]->studentId; ?>">Ver</a>
                    <a href="?cargar=editar&id=<?php echo $students[$i]->studentId; ?>">Editar</a>
                    <a href="?cargar=eliminar&id=<?php echo $students[$i]->studentId; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>