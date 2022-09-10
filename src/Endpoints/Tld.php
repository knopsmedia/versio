<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class Tld extends AbstractEndpoint
{
    /**
     * @param string $tld
     *
     * @return array{tldInfo: array}
     * @throws Exception
     */
    public function get(string $tld): array
    {
        return $this->http()->post($this->getEndpoint() . "/info/$tld");
    }

    /**
     * @return array{tldInfo: array}
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint() . '/info');
    }
}