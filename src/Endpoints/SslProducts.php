<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class SslProducts extends AbstractEndpoint
{
    /**
     * @param int $id
     *
     * @return array{SSLproductInfo: array}
     * @throws ErrorException
     */
    public function get(int $id): array
    {
        return $this->http()->get($this->getEndpoint() . "/$id");
    }

    /**
     * @return array{sslproductsList: array}
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }
}