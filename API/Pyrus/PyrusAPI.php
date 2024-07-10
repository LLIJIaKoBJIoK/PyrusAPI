<?php

/*
  Необходимые поля из Задачи:
    ID Заявки
    Дата создания
    Площадка / Place
    Источник Заявки / Ticket source
    Телефон / Phone
    Каталог Услуг / Service catalog
    Ответственный / Responsible
    Решение / Solution
    ${Description}
    ${Attachments}

    ${Subject}
    ${Sender Name}
    ${Rating}
 */

namespace API\Pyrus;

use API\Pyrus\PyrusTask;

class PyrusAPI
{
  private array $auth = [
    'login' => '',
    'security_key' => '',
  ];

  private array $urlApiList = [
    'auth' => 'https://accounts.pyrus.com/api/v4/auth',
  ];

  private array $headers = [
    'Content-type:Application/JSON'
  ];

  private string $token = '';

  public function __construct($login, $security_key)
  {
    $this->auth['login'] = $login;
    $this->auth['security_key'] = $security_key;

    $this->setToken();
  }

  private function setToken(): void
  {
    $curl = curl_init($this->urlApiList['auth']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->auth, JSON_UNESCAPED_UNICODE));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $html = curl_exec($curl);
    curl_close($curl);

    $this->token = json_decode($html)->access_token;
  }

  public function getToken(): string
  {
    return $this->token;
  }

  public function getInboxTasks(): array
  {
    $headers = $this->headers;
    $headers [] = 'Authorization: Bearer ' . $this->getToken();

    $curl = curl_init('https://api.pyrus.com/v4/inbox?item_count=100');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $html = curl_exec($curl);
    curl_close($curl);

    return json_decode($html, true);
  }

  public function getTaskById(string $id): array
  {
    $headers = $this->headers;
    $headers [] = 'Authorization: Bearer ' . $this->getToken();

    $curl = curl_init('https://api.pyrus.com/v4/tasks/' . $id);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $html = curl_exec($curl);
    curl_close($curl);

    return json_decode($html, true);
  }
}