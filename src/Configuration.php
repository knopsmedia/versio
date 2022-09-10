<?php

namespace Versio;

final class Configuration
{
    public const PRODUCTION = 'https://www.versio.nl/api/v1';
    public const TEST = 'https://www.versio.nl/testapi/v1';

    /**
     * @param string $username
     * @param string $password
     * @param string $baseUri
     */
    public function __construct(
        private string $username,
        private string $password,
        private string $baseUri = self::PRODUCTION,
        private bool $throwExceptionOn4xx = true,
    ) {}

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return bool
     */
    public function getThrowExceptionOn4xx(): bool
    {
        return $this->throwExceptionOn4xx;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}