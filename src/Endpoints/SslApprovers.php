<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class SslApprovers extends AbstractEndpoint
{
    /**
     * @param string $domain
     *
     * @return array{approverList: array}
     * @throws Exception
     */
    public function list(string $domain): array
    {
        return $this->http()->get($this->getEndpoint() . "/$domain");
    }
}