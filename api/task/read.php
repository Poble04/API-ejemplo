<?php

/** Añadir headers */
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Connection.php';
include_once '../../models/Task.php';

/** Establecer connecion a la DB */

$connection = new Connection();
$db = $connection->connect();

/** Creación de 'task' */
$task = new Task($db);
$result = $task->getTask();

$rows = $result->rowCount();

/** Verificar si existen Tasks */
if ($rows > 0) {
    $task_array = array();
    $task_array['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $task_item = array(
            'id_task' => $id_task,
            'description' => $description,
            'done' => $done
        );

        array_push($task_array['data'], $task_item);
    }

    echo json_encode($task_array);
} else {
    echo json_encode(
        array('message' => 'No tasks')
    );
}
