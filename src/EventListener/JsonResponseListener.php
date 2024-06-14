<?php

namespace App\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\VarDumper\VarDumper;

class JsonResponseListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $statusCode = $response->getStatusCode();
        $contentType = $response->headers->get('Content-Type');

        if ($statusCode === 404) {
            // No content status code, return an empty.php response
            $response = new JsonResponse(['message' => 'Resource not found'], 404);
            $event->setResponse($response);
            return;
        }

        if ($contentType !== 'application/json' && $response instanceof JsonResponse === false) {
            $data = json_decode($response->getContent(), true);
            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                // Response content is not valid JSON, create a new JsonResponse
                $response = new JsonResponse(['message' => 'Invalid JSON response'], 500);
            } else {
                // Convert response content to JSON
                $response = new JsonResponse($data, $response->getStatusCode(), $response->headers->all());
            }

            $event->setResponse($response);
        }
    }
}
