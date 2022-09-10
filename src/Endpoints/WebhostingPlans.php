<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class WebhostingPlans extends AbstractEndpoint
{
    /**
     * @return array{webhostingPlansList: array}
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * @param int $id
     *
     * @return array{webhostingPlanInfo: array}
     * @throws Exception
     */
    public function get(int $id): array
    {
        return $this->http()->get($this->getEndpoint() . "/$id");
    }
}