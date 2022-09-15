<?php

namespace VersioTests\Endpoints;

use Versio\Endpoints\Domains;

final class DomainsTest extends AbstractEndpointTest
{
    private Domains $domains;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->domains = new Domains($this->http());
    }

    public function testItCan()
    {
        $domains = $this->domains->list();
        var_dump($domains);
    }
}