<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class DnsTemplates extends AbstractEndpoint
{
    /**
     * @param string $name
     *
     * @return array{dnstemplate_id: int, last_change_date: string}
     * @throws Exception
     */
    public function create(string $name): array
    {
        $data = $this->http()->post($this->getEndpoint(), ['name' => $name]);

        return $data['dnstemplateInfo'];
    }

    /**
     * @param int   $dnsTemplateId
     * @param array $data
     *
     * @return array
     * @throws Exception
     */
    public function update(int $dnsTemplateId, array $data): array
    {
        $results = $this->http()->post(sprintf("%s/%d/update", $this->getEndpoint(), $dnsTemplateId), $data);

        return $results['dnstemplateInfo'];
    }

    /**
     * @param int $dnsTemplateId
     *
     * @return bool
     * @throws Exception
     */
    public function delete(int $dnsTemplateId): bool
    {
        return $this->http()->delete($this->getEndpoint() . '/' . $dnsTemplateId);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function list(): array
    {
        $data = $this->http()->get($this->getEndpoint());

        return $data['dnstemplateList'];
    }

    /**
     * @param int $dnsTemplateId
     *
     * @return array
     * @throws Exception
     */
    public function get(int $dnsTemplateId): array
    {
        $data = $this->http()->get($this->getEndpoint() . '/' . $dnsTemplateId);

        return $data['dnstemplateInfo'];
    }
}