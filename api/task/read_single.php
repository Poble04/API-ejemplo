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

$task->id_task = (isset($_GET['id_task'])) ? $_GET['id_task'] : die();

$task->getSingleTask();
$task_array = array(
    'id_task' => $task->id_task,
    'description' => $task->description,
    'done' => $task->done
);

print_r(json_encode($task_array));