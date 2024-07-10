<?php

namespace API\Pyrus;

class PyrusTask
{
  private PyrusAPI $api;

  //Полученые задачи через API в необработанном виде
  private array $rawTasks = [];

  //Обработанные задачи
  private array $tasks = [];

  private array $tasksId = [];

  public function __construct()
  {
    $this->api = new PyrusAPI('v.kobelev@danaflex.ru', 'xJd9YhVAYDtQ-Fmj-sRwRwWCmQzIHfJirAGvBcvBhRGT6W8RqGj~HPiAOWNB8O4EX2N12OLSFWyXfO1yP0C1Lk0XM~lYfM4Z');
    $this->getRawInboxTasks();
  }

  public function getRawInboxTasks(): static
  {
    $this->rawTasks = $this->api->getInboxTasks();
    //$this->getTasksId();

    return $this;
  }

  public function getRawInboxTask($id): static
  {
    $this->rawTasks = $this->api->getTaskById($id);

    return $this;
  }

  public function show(): void
  {
    print_r($this->tasks);
  }

  public function format(): static
  {
    $this->getTasksId();
    foreach ($this->tasks as $id => $value)
    {
      $task = $this->clearTaskFields($id);
      $this->tasks[$id] = $task;
    }

    return $this;
  }

  //Получить поля задачи
  private function clearTaskFields(int $id): array
  {
    $task = [];
    $rawTask = $this->api->getTaskById($id);

    //$task['id'] = $rawTask['task']['id'] ?? '';
    $task['created_date'] = $rawTask['task']['create_date'] ?? '';
    $task['place'] = $rawTask['task']['fields'][1]['value']['values'][0] ?? '';
    $task['ticket_source'] = $rawTask['task']['fields'][2]['value']['values'][0] ?? '';
    $task['service_catalog'] = $rawTask['task']['fields'][13]['value']['values'][0] ?? '';
    $task['Responsible'] = $rawTask['task']['fields'][17]['value'] ?? '';
    $task['Attachments'] = $rawTask['task']['fields'][10]['value'][0]['url'] ?? '';

    return $task;
  }

  //Получить все ID входящих задач и записать в массив задач
  private function getTasksId(): void
  {
    foreach ($this->rawTasks['tasks'] as $task)
    {
      $key = $task['id'];
      $this->tasks[$key] = '';
    }
  }
}