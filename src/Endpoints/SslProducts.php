<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class SslProducts extends AbstractEndpoint
{
    /**
     * @param int $id
     *
     * @return array{SSLproductInfo: array}
     * @throws Exception
     */
    public function get(int $id): array
    {
        return $this->http()->get($this->getEndpoint() . "/$id");
    }

    /**
     * @return array{sslproductsList: array}
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }
}