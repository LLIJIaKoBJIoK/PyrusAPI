<?php

require 'vendor/autoload.php';
require_once 'template.php';

use API\Pyrus\PyrusTask;

$task = new PyrusTask();

if(isset($_POST['inboxTasks']))
{
  $task->getRawInboxTasks()->format()->show();
}

if(isset($_POST['getTaskById']))
{
  $id = $_POST['taskId'] ?? NULL;
  $task->getT($id);
}


