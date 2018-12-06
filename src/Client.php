<?php

namespace Syzn\MicropayClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use Syzn\MicropayClient\Interfaces\ActionInterface;

class Client
{

    const BASE_URI = "http://www.micropay.co.il/ExtApi/";
    protected $client;

    protected $universal_values;

    /**
     * Initialize new client instance
     *
     * @param int $user_id
     * @param string $username
     * @param array $config
     *
     * @return void
     */
    public function __construct(int $user_id, string $username, array $config = [])
    {
        $config['base_uri'] = self::BASE_URI;

        $this->universal_values = [
            'uid' => $user_id,
            'un' => $username
        ];

        $this->client = new HttpClient($config);
    }

    public function request(ActionInterface $action)
    {
        $method = $action->getMethod();

        return $this->$method($action);
    }

    protected function post(ActionInterface $action)
    {
        try {
            $body = $this->prepareValues($action->getValues());

            $request = new Request(
                $action->getMethod(),
                $action->getEndpointUri(),
                []
            );

            return $this->client->send($request, [
                'form_params' => $body
            ]);
        } catch (Exception $e) {
            // throw exception
        }
    }

    protected function get(ActionInterface $action)
    {
        try {
            $uri_with_params = $action->getEndpointUri() . '?' .
                http_build_query($this->prepareValues($action->getValues()));

            $request = new Request(
                $action->getMethod(),
                $uri_with_params
            );

            return $this->client->send($request);
        } catch (Exception $e) {
            // throw exception
        }
    }

    /**
     * Adds universal values (like authentication values)
     *
     * @param array $values
     *
     * @return array
     */
    private function prepareValues(array $values): array
    {
        return array_merge($values, $this->universal_values);
    }
}
