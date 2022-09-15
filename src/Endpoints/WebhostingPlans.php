<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class WebhostingPlans extends AbstractEndpoint
{
    /**
     * @return array{webhostingPlansList: array}
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * @param int $id
     *
     * @return array{webhostingPlanInfo: array}
     * @throws ErrorException
     */
    public function get(int $id): array
    {
        return $this->http()->get($this->getEndpoint() . "/$id");
    }
}