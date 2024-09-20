Сервис по работе с задачами Pyrus

-----Задачи для выполнения------
    Добавить список параметров при выполнении запроса (Readme)
    Добавить список Объектов полей Pyrus (Readme)
    Реализовать проверку данных объекта Task перед созаднием задачи
    Реализовать автоматическое добавление значений полей, которые не должны изменяться пользователем с pyrus.com в Объекты
    (Например: Поле Topic имеет id = 3 в Pyrus, мы его получаем и присваиваем Объекту TopicField при его создании, пользователи и разработчики не должны иметь возможность изменять это значение)

--------------------------------
Примечания:
    '-' означает что метод имеет модификатор доступа private
    '+' означает что метод имеет модификатор доступа public

Сервис состоит из следующих классов:
    PyrusApi - Класс для взаимодействия приложения с api сайта pyrus.com
        -sendGetRequest(string $uri, array $params = []): Response
            Отправлят запрос на сайт pyrus.com с заданым url и параметрами. Список Параметров:

        +setCredentials(string $login, string $securityKey): void
            принимает данные для взаимодействия с API

        +getToken(): string
            Получить токен для работы с API

        +getInboxTasks(): Response
            Возвращает задачи из Папки "Входящие". Для получения в формате JSON, используйте
            ->json() или ->json(string $key), где $key - значения 'tasks' или 'has_more'

        +getTaskById(int $id, array $param = []): Response
            Возвращает задачу по её ID в Pyrus. Для получения в формате JSON, используйте
            ->json() или ->json(string $key), где $key - значение 'task'

        +getTasksByForm(int $formId, array $param = []): Response
            Возвращает список задач по заданной форме. $formId - ID формы Pyrus. Для получения в формате JSON, используйте
            ->json() или ->json(string $key), где $key - значение 'tasks'

        +getForms(): Response
            Возвращает список форм Pyrus. Для получения в формате JSON, используйте
            ->json() или ->json(string $key), где $key - значение 'forms'
        +createTask(array $param): Response
            Создает задачу по параметрам в Pyrus
        +addTaskComment($id, array $param): Response
            Добовляет комментарий к задаче Pyrus(включает в себя обновление полей в Задаче)

    PyrusTaskManager - Класс для упрощения работы с полученной задачей и набором готовых функций
        +getTaskById(int $id): Task
            Возвращает задачу Pyrus по её ID. Отличие от PyrusApi::getTaskById(...) в том, что возвращает Объект(Task) задачи
            с полями и методами для их получения, а не обычный JSON задачи
        +getTasksByForm(int $id, $param = []): array
            Возвращает список задач по заданной форме. $formId - ID формы Pyrus. Отличие от PyrusApi::getTaskById(...) в том,
            что возвращает Объект(Task) задачи с полями и методами для их получения, а не обычный JSON задачи
        +persist(Task $task): void
            Подготовливает данные для создания / обновления задачи
        +flush()
            Отправляет подготовленную задачу на сервер Pyrus

    Parser - Класс для парсинга задачи Pyrus. Имеет статические методы
        +parseTask(array $pyrusTask): Task
            Возвращает задачу Pyrus в виде Объекта Task
        +parseFields(array $pyrusFields): array
            Возвращает поля задачи Pyrus в виде пары [FIELD_ID] => [FIELD]
        -hasMethod(string $key):string

    Helper - Вспомогательный класс для констант ID

    Task - Класс, который представляет задачу Pyrus как Объект(изначально задача предоставляется в формате JSON)
        getId(): int
        getText(): string
        getFormattedText(): string
        getCreateDate(): string
        getLastModifiedDate(): string
        getAuthor(): array
        getListIds(): array
        getSubscribers(): array
        getFormId(): int
        getApprovals(): array
        getCurrentStep(): int
        getAttachments(): array
        getFields(): array
        addField(int $id, array $param = []): void
        getSteps(): array
        getComments(): array
        addComment(int $id, array $param = []): void
        isClosed(): bool
        getCloseDate(): string


--------------------------------------------------------------------------
Редактируемые поля в Pyrus
    3 - topic
    4 - description
    5 - attachment (Не реализовано)
    6 - name
    7 - email
    10 - phone
    19 - status
    27 - solution
    34 - support_group
    37 - service_catalog
    41 - place
    61 - ticket_source
Остальные поля
    63 - 'create_date'

Запись полей. Используйте вариант в зависимости от поля, которое хотите создать или редактировать
    [
        'id' => FIELD_ID
        'value' => 'ЗНАЧЕНИЕ' (string). Применять для следующих полей: 3, 4, 6, 10, 7, 27
    ]
    или
    [
        'id' => FIELD_ID
        'value' => ЗНАЧНИЕ (int)
    ]
    или
    [
        'id' => FIELD_ID
        'value' => [
            'item_id' => ID (int). Применять к следующим полям: 41, 61, 34, 37,
        ]
    ]
    или
    [
        'id' => FIELD_ID
        'value' => [
            'choice_id' => ID (int). Применять к следующим полям: 19,
        ]
    ]


Для создания поместить все нужные поля в массив с ключем "fields":
    $array['fields'] => [
        [field_1],
        [field_2],
        ....
        ]
Для редактирования поместить все нужные поля в массив с ключем "field_updates":
    $array['field_updates'] => [
        [field_1],
        [field_2],
        ....
        ]
Так же, если задача по форме, то нужно еще добавить ключ "field_id". Итоговый результат будет:
    $array = [
        ['field_id'] => $fieldId;
        ['fields'] => $fields / $fields_update
    ]

