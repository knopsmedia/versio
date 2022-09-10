<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class ResellerHostingPlans extends AbstractEndpoint
{
    /**
     * @return array
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * @param int $planId
     *
     * @return array
     * @throws Exception
     */
    public function get(int $planId): array
    {
        return $this->http()->get($this->getEndpoint() . '/' . $planId);
    }
}