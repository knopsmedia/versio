<?php

namespace Versio\Endpoints;

use Versio\HttpMethods;

abstract class AbstractEndpoint
{
    /** @var string */
    private string $endpoint;

    /**
     * @param HttpMethods $httpClient
     */
    public function __construct(private HttpMethods $httpClient)
    {
        $this->configure();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $className = static::class;
        $className = strtolower(substr($className, strrpos($className, '\\') + 1));

        $this->setEndpoint($className);
    }

    /**
     * @return HttpMethods
     */
    protected function http(): HttpMethods
    {
        return $this->httpClient;
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    protected function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }
}