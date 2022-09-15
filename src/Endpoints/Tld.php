<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class Tld extends AbstractEndpoint
{
    /**
     * @param string $tld
     *
     * @return array{tldInfo: array}
     * @throws ErrorException
     */
    public function get(string $tld): array
    {
        return $this->http()->post($this->getEndpoint() . "/info/$tld");
    }

    /**
     * @return array{tldInfo: array}
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint() . '/info');
    }
}