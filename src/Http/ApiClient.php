<?php

namespace Gupalo\NamecomClient\Http;

use JsonSerializable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class ApiClient
{
    private HttpClientInterface $httpClient;

    private string $baseUrl;

    private string $username;

    private string $apiKey;

    private ?ResponseInterface $lastResponse = null;

    public function __construct(
        HttpClientInterface $httpClient,
        string $baseUrl,
        string $username,
        string $apiKey
    ) {
        $this->httpClient = $httpClient;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->username = $username;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $path
     * @param JsonSerializable|array|null $data
     * @return array
     * @throws Throwable
     */
    public function get(string $path, $data = null): array
    {
        return $this->api($path, $data, Request::METHOD_GET);
    }

    /**
     * @param string $path
     * @param JsonSerializable|array|null $data
     * @return array
     * @throws Throwable
     */
    public function post(string $path, $data = null): array
    {
        return $this->api($path, $data, Request::METHOD_POST);
    }

    /**
     * @param string $path
     * @param JsonSerializable|array|null $data
     * @return array
     * @throws Throwable
     */
    public function put(string $path, $data = null): array
    {
        return $this->api($path, $data, Request::METHOD_PUT);
    }

    /**
     * @param string $path
     * @param JsonSerializable|array|null $data
     * @return array
     * @throws Throwable
     */
    public function delete(string $path, $data = null): array
    {
        return $this->api($path, $data, Request::METHOD_DELETE);
    }

    /**
     * @param string $path
     * @param JsonSerializable|array|null $data
     * @param string $method
     * @return array
     * @throws Throwable
     */
    private function api(string $path, $data = null, string $method = Request::METHOD_GET): array
    {
        $url = sprintf('%s%s', $this->baseUrl, $path);
        $options = [
            'auth_basic' => [$this->username, $this->apiKey],
        ];
        if ($data) {
            $options['json'] = $data;
        }

        $result = null;
        try {
            $response = $this->httpClient->request($method, $url, $options);
            $this->lastResponse = $response;

            $result = $response->toArray();
        } catch (Throwable $e) {
            throw $e;
        }
        if (!$result) {
            $result = [];
        }

        return $result;
    }

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }
}
