<?php

namespace App\Http\Controllers\ITSM\Pyrus\Manager;

use App\Http\Controllers\ITSM\Pyrus\Api\PyrusApi;
use App\Http\Controllers\ITSM\Pyrus\Parser\Parser;
use App\Http\Controllers\ITSM\Pyrus\Types\Task;

class PyrusManager
{

    private PyrusApi $api;
    private array $task = [];
    private int $id;
    private string $status = 'new';

    public function __construct()
    {
        $this->api = new PyrusApi();
        $this->api->setCredentials(config('pyrus.login'), config('pyrus.security_key'));
    }

    /**
     * @param int $id
     * @return Task
     */
    public function getTaskById(int $id): Task
    {
        return Parser::parseTask($this->api->getTaskById($id)->json('task'));
    }

    public function getTasksByForm(int $id, $param = []): array
    {
        $pyrusTasks = $this->api->getTasksByForm($id, $param)->json('tasks');

        $tasks = [];
        foreach ($pyrusTasks as $task)
        {
            $tasks[] = Parser::parseTask($task);
        }
        return $tasks;
    }

    public function persist(Task $task): void
    {
        try {
            $rp = new \ReflectionProperty($task, 'id');

            //Если это уже созданная задача - отправляем новые данные для внесения изменений
            if($rp->isInitialized($task))
            {
                $this->id = $task->getId();
                $this->status = 'update';

                $this->task['form_id'] = $task->getFormId();
                $fields = [];

                //Получаем переданные комментарии к задаче и проверяем на наличие новых
                foreach ($task->getComments() as $key => $comment)
                {
                    if($key == 'new')
                    {
                        $fields[] = $comment;
                    }

                }
                $this->task['field_updates'] = $fields;

            } //Если это новая задача - отправляем данные для её создания
            else {
                $this->task['form_id'] = $task->getFormId();
                $fields = [];

                foreach ($task->getFields() as $field)
                {
                    $fields[] = $field;
                }
                $this->task['fields'] = $fields;
            }

        } catch (\ReflectionException $e) {}
    }

    public function flush(): void
    {
        if($this->status == 'new') {
            dd($this->api->createTask($this->task));
        }
        if($this->status == 'update'){
            dd($this->api->addTaskComment($this->id, $this->task));
        }
    }
}
