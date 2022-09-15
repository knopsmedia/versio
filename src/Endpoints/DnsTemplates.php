<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class DnsTemplates extends AbstractEndpoint
{
    /**
     * Creates a DNS template in your account.
     *
     * @param string $name
     *
     * @return array{
     *   dnstemplateInfo: array{
     *     dnstemplate_id: int,
     *     last_change_date: string,
     *     last_domain_update_date: string,
     *     name: string,
     *     dns_records: array{
     *       type: string,
     *       name: string,
     *       value: string,
     *       prio: int,
     *       ttl: int
     *     },
     *     dns_redirections: array{
     *       from: string,
     *       destination: string
     *     },
     *   }
     * }
     * @throws ErrorException
     */
    public function create(string $name): array
    {
        return $this->http()->post($this->getEndpoint(), ['name' => $name]);
    }

    /**
     * Deletes an existing DNS template from your account.
     *
     * @param int $dnsTemplateId
     *
     * @return bool
     * @throws ErrorException
     */
    public function delete(int $dnsTemplateId): bool
    {
        return $this->http()->delete($this->getEndpoint() . "/$dnsTemplateId");
    }

    /**
     * Returns a DNS template from your account.
     *
     * @param int $dnsTemplateId
     *
     * @return array{
     *   dnstemplateInfo: array{
     *     dnstemplate_id: int,
     *     last_change_date: string,
     *     last_domain_update_date: string,
     *     name: string,
     *     dns_records: array{
     *       type: string,
     *       name: string,
     *       value: string,
     *       prio: int,
     *       ttl: int
     *     },
     *     dns_redirections: array{
     *       from: string,
     *       destination: string
     *     },
     *   }
     * }
     * @throws ErrorException
     */
    public function get(int $dnsTemplateId): array
    {
        return $this->http()->get($this->getEndpoint() . "/$dnsTemplateId");
    }

    /**
     * Returns all DNS templates in your account.
     *
     * @return array{
     *   dnstemplateList: array{
     *     dnstemplate_id: int,
     *     last_change_date: string,
     *     last_domain_update_date: string,
     *     name: string,
     *     dns_records: array{
     *       type: string,
     *       name: string,
     *       value: string,
     *       prio: int,
     *       ttl: int
     *     },
     *     dns_redirections: array{
     *       from: string,
     *       destination: string
     *     },
     *   }
     * }
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * Updates an existing DNS template in your account.
     *
     * @param int   $dnsTemplateId
     * @param array $data{
     *    name: string|null,
     *    dns_records: array|null,
     *    dns_redirections: array|null
     * }
     *
     * @return array{dnstemplateInfo: array}
     * @throws ErrorException
     */
    public function update(int $dnsTemplateId, array $data): array
    {
        return $this->http()->post($this->getEndpoint() . "/$dnsTemplateId/update", $data);
    }
}