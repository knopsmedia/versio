<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class ResellerHostingPlans extends AbstractEndpoint
{
    /**
     * @return array
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * @param int $planId
     *
     * @return array
     * @throws ErrorException
     */
    public function get(int $planId): array
    {
        return $this->http()->get($this->getEndpoint() . "/$planId");
    }
}