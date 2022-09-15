<?php

namespace VersioTests\Endpoints;

use GuzzleHttp\Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Versio\Configuration;
use Versio\HttpMethods;

abstract class AbstractEndpointTest extends TestCase
{
    /** @var HttpMethods|null */
    protected null|HttpMethods $httpMethods = null;

    /**
     * @return HttpMethods
     */
    protected function http(): HttpMethods
    {
        if (null === $this->httpMethods) {
            $factory = new Psr17Factory();

            $this->httpMethods = new HttpMethods(
                new Client(), $factory, $factory,
                new Configuration($_ENV['VERSIO_USERNAME'], $_ENV['VERSIO_PASSWORD'], Configuration::TEST)
            );
        }

        return $this->httpMethods;
    }
}