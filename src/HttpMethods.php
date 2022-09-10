<?php

namespace Versio;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriFactoryInterface;
use Versio\Exceptions\Exception;

final class HttpMethods
{
    /** @var ClientInterface */
    private ClientInterface $client;

    /** @var RequestFactoryInterface */
    private RequestFactoryInterface $requestFactory;

    /** @var UriFactoryInterface */
    private UriFactoryInterface $uriFactory;

    /** @var Configuration */
    private Configuration $configuration;

    /**
     * @param ClientInterface         $client
     * @param RequestFactoryInterface $requestFactory
     * @param UriFactoryInterface     $uriFactory
     * @param Configuration           $configuration
     */
    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory, UriFactoryInterface $uriFactory, Configuration $configuration)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->configuration = $configuration;
    }

    /**
     * @param string $path
     * @param array  $query
     *
     * @return array
     * @throws Exception
     */
    public function get(string $path, array $query = []): array
    {
        return $this->request('GET', $path, ['query' => $query], true);
    }

    /**
     * @param string $path
     * @param array  $data
     *
     * @return array
     * @throws Exception
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request('POST', $path, ['data' => $data], true);
    }

    /**
     * @param string $path
     *
     * @return bool
     * @throws Exception
     */
    public function delete(string $path): bool
    {
        $response = $this->request('DELETE', $path);

        return $response->getStatusCode() === 200;
    }

    /**
     * @param string                           $method
     * @param string                           $path
     * @param array{query: array, data: array} $options
     * @param bool                             $decodeResponse
     *
     * @return ResponseInterface|array
     * @throws Exception
     */
    private function request(string $method, string $path, array $options = [], bool $decodeResponse = false): ResponseInterface|array
    {
        $uri = $this->uriFactory->createUri($this->configuration->getBaseUri());
        $uri = $uri->withPath($uri->getPath() . '/' . $path);

        if (array_key_exists('query', $options) && is_array($options['query']) && $options['query']) {
            $uri = $uri->withQuery(\http_build_query($options['query']));
        }

        $request = $this->requestFactory->createRequest($method, $uri)
            ->withHeader('Authorization', 'Basic ' . base64_encode($this->configuration->getUsername() . ':' . $this->configuration->getPassword()));

        if (array_key_exists('data', $options) && is_array($options['data']) && $options['data']) {
            $request->getBody()->write(\json_encode($options['data']));
        }

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new Exception($e->getMessage(), previous: $e);
        }

        $statusCode = $response->getStatusCode();
        $throwException = $this->configuration->getThrowExceptionOn4xx() && 400 <= $statusCode && $statusCode < 500;

        if ($throwException && !$decodeResponse) {
            $decodeResponse = !$decodeResponse;
        }

        if ($decodeResponse) {
            $data = \json_decode($response->getBody()->getContents(), true);

            if ($throwException) {
                throw new Exception($data['message']);
            }

            return $data;
        }

        return $response;
    }
}