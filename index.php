<?php

require 'vendor/autoload.php';
require_once 'template.php';

use API\Pyrus\PyrusTask;
use API\Pyrus\PyrusAPI;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$userName = $_ENV['USER_NAME'];
$securityKey = $_ENV['SECURITY_KEY'];

$api = new PyrusAPI();
$api->setCredentials($userName, $securityKey);

$task = new PyrusTask($userName, $securityKey);

if(isset($_POST['getTasks']))
{
  $tasks = $api->getInboxTasks();
  print_r($tasks);
}

if(isset($_POST['getTask']))
{
  $id = $_POST['taskId'];
  $task = $task->getInboxTask((int)$id);
  print_r($task);
}

if(isset($_POST['getRawTask']))
{
  $id = $_POST['taskId'];
  $task = $api->getTaskById((int)$id);
  print_r($task);

}


