<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class Domains extends AbstractEndpoint
{
    /**
     * @param string $domain
     *
     * @return bool
     * @throws Exception
     */
    public function isAvailable(string $domain): bool
    {
        $data = $this->http()->get($this->getEndpoint() . '/' . $domain . '/availability');

        return $data['available'];
    }

    /**
     * @param string $domain
     *
     * @return bool
     * @throws Exception
     */
    public function delete(string $domain): bool
    {
        return $this->http()->delete($this->getEndpoint() . '/' . $domain);
    }

    /**
     * @param string $domain
     * @param bool   $showDnsRecords
     * @param bool   $showEppCode
     *
     * @return array
     * @throws Exception
     */
    public function info(string $domain, bool $showDnsRecords = true, bool $showEppCode = true): array
    {
        return $this->http()->get($this->getEndpoint() . '/' . $domain, [
            'show_dns_records' => $showDnsRecords,
            'show_epp_code'    => $showEppCode,
        ]);
    }

    /**
     * * PENDING_TRANSFER
     * * OK
     * * INACTIVE
     * * EXPIRED
     * * PENDING
     * * TRANSFERRED_OUT
     *
     * @param string|null $status
     *
     * @return array
     * @throws Exception
     */
    public function list(?string $status = null)
    {
        return $this->http()->get($this->getEndpoint(), $status ? ['status' => $status] : []);
    }

    /**
     * @param string      $domain
     * @param int         $contactId
     * @param int         $years
     * @param array       $nameservers
     * @param string|null $idnLocale
     * @param bool|null   $autoRenew
     *
     * @return array{domain: string, expire_date: string}
     * @throws Exception
     */
    public function register(string $domain, int $contactId, int $years = 1, array $nameservers = [], ?string $idnLocale = null, ?bool $autoRenew = null): array
    {
        $data = [
            'contact_id' => $contactId,
            'years'      => $years,
        ];

        if ($idnLocale !== null) {
            $data['idn_locale'] = $idnLocale;
        }

        if ($autoRenew !== null) {
            $data['auto_renew'] = $autoRenew;
        }

        if (!empty($nameservers)) {
            $data['ns'] = $nameservers;
        }

        return $this->http()->post($this->getEndpoint() . '/' . $domain, $data);
    }

    /**
     * @param string $domain
     * @param array{
     *     domain: string,
     *     registrant_id: int,
     *     reseller_id: int,
     *     category_id: int,
     *     dnstemplate_id: int,
     *     auto_renew: bool,
     *     lock: bool,
     *     dns_management: bool,
     *     ns: array,
     *     dns_records: array,
     *     dns_redirections: array,
     *     dnssec_keys: array
     * }             $data
     *
     * @return array
     * @throws Exception
     */
    public function update(string $domain, array $data): array
    {
        return $this->http()->post($this->getEndpoint() . '/' . $domain . '/update', $data);
    }

    /**
     * @param string $domain
     * @param int    $years
     *
     * @return array{domain: string, expire_date: string}
     * @throws Exception
     */
    public function renew(string $domain, int $years = 1): array
    {
        return $this->http()->post($this->getEndpoint() . '/' . $domain . '/renew', [
            'domain' => $domain,
            'years'  => $years,
        ]);
    }

    /**
     * @param string    $domain
     * @param int       $contactId
     * @param string    $authorizationCode
     * @param int       $years
     * @param array     $nameservers
     * @param bool|null $autoRenew
     *
     * @return array{domain: string, expire_date: string, status: string, process_id: int}
     * @throws Exception
     */
    public function transfer(string $domain, int $contactId, string $authorizationCode, int $years = 1, array $nameservers = [], ?bool $autoRenew = null): array
    {
        $data = [
            'contact_id' => $contactId,
            'years'      => $years,
            'auth_code'  => $authorizationCode,
        ];

        if ($autoRenew !== null) {
            $data['auto_renew'] = $autoRenew;
        }

        if (!empty($nameservers)) {
            $data['ns'] = $nameservers;
        }

        return $this->http()->post($this->getEndpoint() . '/' . $domain . '/transfer', $data);
    }

    /**
     * @param string $domain
     * @param int    $processId
     *
     * @return array{domain: string, status: string}
     * @throws Exception
     */
    public function status(string $domain, int $processId): array
    {
        return $this->http()->get($this->getEndpoint() . '/' . $domain . '/transfer/' . $processId);
    }
}