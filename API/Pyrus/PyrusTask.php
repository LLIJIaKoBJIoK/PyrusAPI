<?php

namespace API\Pyrus;

class PyrusTask
{
  private PyrusAPI $api;

  //Полученые задачи через API в необработанном виде
  private array $rawTasks = [];

  //Обработанные задачи
  private array $tasks = [];

  public function __construct()
  {
    $this->api = new PyrusAPI('v.kobelev@danaflex.ru', 'xJd9YhVAYDtQ-Fmj-sRwRwWCmQzIHfJirAGvBcvBhRGT6W8RqGj~HPiAOWNB8O4EX2N12OLSFWyXfO1yP0C1Lk0XM~lYfM4Z');
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

    $task['created_date'] = $rawTask['task']['create_date'] ?? '';
    $task['place'] = $rawTask['task']['fields'][1]['value']['values'][0] ?? '';
    $task['ticket_source'] = $rawTask['task']['fields'][2]['value']['values'][0] ?? '';
    $task['service_catalog'] = $rawTask['task']['fields'][13]['value']['values'][0] ?? '';
    $task['Responsible'] = $rawTask['task']['fields'][17]['value'] ?? '';
    $task['Attachments'] = $rawTask['task']['fields'][10]['value'][0]['url'] ?? '';

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