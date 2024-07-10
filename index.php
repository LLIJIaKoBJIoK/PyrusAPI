<?php

require 'vendor/autoload.php';
require_once 'template.php';

use API\Pyrus\PyrusAPI;
use API\Pyrus\PyrusTask;

$task = new PyrusTask();

if(isset($_POST['inboxTasks']))
{
  $task->showTasks();
}

if(isset($_POST['getTaskById']))
{
  //$api->getTaskById(225509752);
}

if(isset($_POST['getLists']))
{
  //$api->getUserLists();
}

