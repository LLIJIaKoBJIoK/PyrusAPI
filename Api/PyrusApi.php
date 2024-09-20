<?php

namespace App\Http\Controllers\ITSM\Pyrus\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PyrusApi
{
    private string $accessToken = '';

    private array $auth = [
        'login' => '',
        'security_key' => '',
    ];

    /**
     * @param $login
     * @param $securityKey
     * @return void
     */
    public function setCredentials(string $login, string $securityKey): void
    {
        $this->auth['login'] = $login;
        $this->auth['security_key'] = $securityKey;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        if ($this->accessToken == '')
        {
            $response = Http::post('https://accounts.pyrus.com/api/v4/auth', [
                'login' => $this->auth['login'],
                'security_key' => $this->auth['security_key'],
            ]);

            $this->accessToken = 'Bearer ' . $response->json('access_token');
        }

        return $this->accessToken;
    }

    /**
     * @param string $uri
     * @param $params
     * @return Response
     */
    private function sendGetRequest(string $uri, array $params = []): Response
    {
        $this->getToken();

        return Http::withHeaders([
            'Authorization' => $this->accessToken
        ])
            ->acceptJson()
            ->get($uri, $params);
    }

    /**
     * @param int $count
     * @return Response
     */
    public function getInboxTasks(array $params = []): Response
    {
        $apiUrl = 'https://api.pyrus.com/v4/inbox';

        return $this->sendGetRequest($apiUrl, $params);
    }

    /**
     * @param int $id
     * @param array $param
     * @return array
     */
    public function getTaskById(int $id, array $param = []): Response
    {
        $apiUrl = 'https://api.pyrus.com/v4/tasks/' . $id;

        return $this->sendGetRequest($apiUrl, $param);
    }

    /**
     * @param int $formId
     * @param array $param
     * @return array
     */
    public function getTasksByForm(int $formId, array $param = []): Response
    {
        $apiUrl = 'https://api.pyrus.com/v4/forms/' . $formId .
            '/register';

        return $this->sendGetRequest($apiUrl, $param);
    }

    /**
     * @param array $param
     * @return Response
     */
    public function createTask(array $param): Response
    {
        $apiUrl = 'https://api.pyrus.com/v4/tasks';

        $this->getToken();

        return Http::withHeaders([
            'Authorization' => $this->accessToken
        ])
            ->acceptJson()
            ->post($apiUrl, $param);
    }

    public function addTaskComment($id, array $param): Response
    {
        $apiUrl = 'https://api.pyrus.com/v4/tasks/' . $id . '/comments';

        $this->getToken();

        return Http::withHeaders([
            'Authorization' => $this->accessToken
        ])
            ->acceptJson()
            ->post($apiUrl, $param);
    }

    /**
     * @return Response
     */
    public function getForms(): Response
    {
        $apiUrl = 'https://api.pyrus.com/v4/forms';

        return $this->sendGetRequest($apiUrl);
    }


}
