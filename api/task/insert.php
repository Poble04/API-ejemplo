<?php

/** Añadir headers */
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Controll-Allow-Methods: POST');
header('Access-Controll-Allow-Headers: Access-Controll-Allow-Headers, Access-Controll-Allow-Methods, Content-Type, Authorization, X-Requested-With');

include_once '../../config/Connection.php';
include_once '../../models/Task.php';

/** Establecer connecion a la DB */

$connection = new Connection();
$db = $connection->connect();

/** Creación de 'task' */
$task = new Task($db);

/** Tomar la información recibida */
$data = json_decode(file_get_contents('php://input'));

$task->description = $data->description;
$task->done = $data->done;

if ($task->insert()) {
    echo json_encode(
        array('message' => 'Task created')
    );
} else {
    echo json_encode(
        array('message' => 'An error ocurred. Task not created')
    );
}
