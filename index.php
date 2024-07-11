<?php

require 'vendor/autoload.php';
require_once 'template.php';

use API\Pyrus\PyrusTask;

$task = new PyrusTask();

if(isset($_POST['getTasks']))
{
  $tasks = $task->getInboxTasks();
  print_r($tasks);
}

if(isset($_POST['getTask']))
{
  $id = $_POST['taskId'];
  $task = $task->getInboxTask((int)$id);
  print_r($task);
}


