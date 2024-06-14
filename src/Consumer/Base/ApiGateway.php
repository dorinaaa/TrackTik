<?php

namespace App\Consumer\Base;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\VarDumper\VarDumper;

class ApiGateway
{
    protected string $baseUrl;

    private string $authorizationHeader;

    protected Client $guzzleClient;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!isset($this->baseUrl)) {
            throw new Exception('Base URL is not set');
        }
        $this->guzzleClient = new Client(['base_uri' => $this->baseUrl]);
    }

    /**
     * @throws Exception
     */
    public function post($endpoint, $data): array
    {
        return $this->request('POST', $endpoint, $data);
    }

    /**
     * @throws Exception
     */
    public function get($endpoint, $queryParams = []): array
    {
        $endpoint .= '?' . http_build_query($queryParams);
        return $this->request('GET', $endpoint, []);
    }

    /**
     * @throws Exception
     */
    public function put($endpoint, $data): array
    {
        return $this->request('PUT', $endpoint, $data);
    }

    public function delete($url)
    {
        // TODO: Implement delete() method.
        // Send a DELETE request to the API Gateway
    }

    public function patch($url, $data)
    {
        // TODO: Implement patch() method.
        // Send a PATCH request to the API Gateway
    }

    /**
     * @throws Exception
     */
    private function request($method, $endpoint, $data = [], $retries = 0): array
    {
        try {
            $response = $this->guzzleClient->request($method, $endpoint, [
                'json' => $data,
                'headers' => $this->getHeaders()
            ]);
            return $this->handleResponse($response);
        } catch (GuzzleException $e) {
            if ($e->getCode() === 401) {
                if ($retries > 3) {
                    throw new Exception($e->getMessage(), $e->getCode(), $e);
                }
                $retries++;
                $this->handleUnauthorized();
                return $this->request($method, $endpoint, $data, $retries);
            }
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function getAuthorizationHeader(): string
    {
        return $this->authorizationHeader;
    }

    protected function setAuthorizationHeader(string $authorizationHeader): void
    {
        $this->authorizationHeader = $authorizationHeader;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            // Add other headers as needed
        ];
        if ($this->useAuthorizationHeader()) {
            $headers['Authorization'] = $this->getAuthorizationHeader();
        }
        return $headers;
    }

    protected function useAuthorizationHeader(): bool
    {
        return isset($this->authorizationHeader);
    }

    protected function handleResponse($response): array
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $data = json_decode($body, true)['data'] ?? [];
        return [
            'status' => $statusCode,
            'data' => $data
        ];
    }

    /**
     * @throws Exception
     */
    protected function handleUnauthorized() {
       throw new Exception('Unauthorized', 401);
    }
}