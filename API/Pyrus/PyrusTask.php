<?php

namespace API\Pyrus;

class PyrusTask
{
  private const FIELD_NOT_FOUND = 'FIELD NOT FOUND';

  private PyrusAPI $api;

  //Полученые задачи через API в необработанном виде
  private array $rawTasks = [];

  //Обработанные задачи
  private array $tasks = [];

  public function __construct($userName, $securityKey)
  {
    $this->api = new PyrusAPI();
    $this->api->setCredentials($userName, $securityKey)->getToken();
  }

  public function getInboxTasks(): array
  {
    $this->rawTasks = $this->api->getInboxTasks();
    $this->format();
    return $this->tasks;
  }

  //Добавить проверку $id
  public function getInboxTask(int $id): array
  {
    $this->rawTasks = $this->api->getTaskById($id);
    $this->format();
    return $this->tasks;
  }

  public function format(): void
  {
    $this->getTasksId();
    foreach ($this->tasks as $id => $value)
    {
      $task = $this->clearTaskFields($id);
      $this->tasks[$id] = $task;
    }
  }

  private function clearTaskFields(int $id): array
  {
    $task = [];
    $rawTask = $this->api->getTaskById($id);

    $task['created_date'] = $rawTask['task']['create_date'] ?? self::FIELD_NOT_FOUND;
    $task['place'] = $rawTask['task']['fields'][1]['value']['values'][0] ?? self::FIELD_NOT_FOUND;
    $task['ticket_source'] = $rawTask['task']['fields'][2]['value']['values'][0] ?? self::FIELD_NOT_FOUND;
    $task['phone'] = $rawTask['task']['fields'][5]['value'] ?? self::FIELD_NOT_FOUND;
    $task['service_catalog'] = $rawTask['task']['fields'][13]['value']['values'][0] ?? self::FIELD_NOT_FOUND;
    $task['responsible'] = $rawTask['task']['fields'][14]['value']['email'] ?? self::FIELD_NOT_FOUND;
    $task['solution'] = $rawTask['task']['fields'][17]['value'] ?? self::FIELD_NOT_FOUND;
    $task['description'] = $rawTask['task']['fields'][19]['value'] ?? self::FIELD_NOT_FOUND;
    $task['attachments'] = $rawTask['task']['fields'][10]['value'][0]['url'] ?? self::FIELD_NOT_FOUND;
    $task['topic'] = $rawTask['task']['fields'][3]['value'] ?? self::FIELD_NOT_FOUND;
    $task['sender_name'] = $rawTask['task']['fields'][7]['value'] ?? self::FIELD_NOT_FOUND;
    $task['open_closed'] = $rawTask['task']['fields'][18]['value'] ?? self::FIELD_NOT_FOUND;

    return $task;
  }

  //Получить все ID входящих задач / задачи и записать в массив задач. Нужна оптимизация этого блока
  private function getTasksId(): void
  {
    if(isset($this->rawTasks['tasks']))
    {
      foreach ($this->rawTasks['tasks'] as $task)
      {
        $id = $task['id'];
        $this->tasks[$id] = '';
      }
    } else {
      $id = $this->rawTasks['task']['id'];
      $this->tasks[$id] = '';
    }


  }
}