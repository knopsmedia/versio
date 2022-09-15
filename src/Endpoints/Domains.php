<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class Domains extends AbstractEndpoint
{
    /**
     * Check the availability of a domain.
     *
     * @param string $domain
     *
     * @return array{domain: string, available: bool, push_required: bool}
     * @throws ErrorException
     */
    public function checkAvailability(string $domain): array
    {
        return $this->http()->get($this->getEndpoint() . "/$domain/availability");
    }

    /**
     * Deletes a domain in your account.
     *
     * @param string $domain
     *
     * @return bool
     * @throws ErrorException
     */
    public function delete(string $domain): bool
    {
        return $this->http()->delete($this->getEndpoint() . "/$domain");
    }

    /**
     * Returns WHOIS information for a domain.
     *
     * @param string $domain
     * @param bool   $showDnsRecords
     * @param bool   $showEppCode
     *
     * @return array{
     *   DomainInfo: array{
     *     domain: string,
     *     registrant_id: int,
     *     reseller_id: int,
     *     category_id: int,
     *     dnstemplate_id: int,
     *     auto_renew: bool,
     *     lock: bool,
     *     epp_code: string,
     *     dns_management: bool,
     *     ns: array{ns: string, nsip: string},
     *     dns_records: array{type: string, name: string, value: string, prio: int, ttl: int},
     *     dns_redirections: array{from: string, destination: string},
     *     dnssec_keys: array{flags: int, algorithm: int, public_key: string}
     *   }
     * }
     * @throws ErrorException
     */
    public function whois(string $domain, bool $showDnsRecords = true, bool $showEppCode = true): array
    {
        return $this->http()->get($this->getEndpoint() . "/$domain", [
            'show_dns_records' => $showDnsRecords,
            'show_epp_code'    => $showEppCode,
        ]);
    }

    /**
     * Returns all domains in your account, optionally filtered by status.
     *
     * Acceptable statuses:
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
     * @throws ErrorException
     */
    public function list(?string $status = null)
    {
        return $this->http()->get($this->getEndpoint(), $status ? ['status' => $status] : []);
    }

    /**
     * Creates a new domain in your account. Your account is billed for the purchase of the domain.
     *
     * @param string      $domain
     * @param int         $contactId
     * @param int         $years
     * @param array       $nameservers
     * @param string|null $idnLocale
     * @param bool|null   $autoRenew
     *
     * @return array{domain: string, expire_date: string}
     * @throws ErrorException
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

        return $this->http()->post($this->getEndpoint() . "/$domain", $data);
    }

    /**
     * Updates domain information. Additional fees may be charged.
     *
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
     * } $data
     *
     * @return array
     * @throws ErrorException
     */
    public function update(string $domain, array $data): array
    {
        return $this->http()->post($this->getEndpoint() . "/$domain/update", $data);
    }

    /**
     * Renews a domain.
     *
     * @param string $domain
     * @param int    $years
     *
     * @return array{domain: string, expire_date: string}
     * @throws ErrorException
     */
    public function renew(string $domain, int $years = 1): array
    {
        return $this->http()->post($this->getEndpoint() . "/$domain/renew", [
            'domain' => $domain,
            'years'  => $years,
        ]);
    }

    /**
     * Transfers a domain.
     *
     * @param string    $domain
     * @param int       $contactId
     * @param string    $authorizationCode
     * @param int       $years
     * @param array     $nameservers
     * @param bool|null $autoRenew
     *
     * @return array{domain: string, expire_date: string, status: string, process_id: int}
     * @throws ErrorException
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

        return $this->http()->post($this->getEndpoint() . "/$domain/transfer", $data);
    }

    /**
     * Get the transfer status.
     *
     * @param string $domain
     * @param int    $processId
     *
     * @return array{domain: string, status: string}
     * @throws ErrorException
     */
    public function status(string $domain, int $processId): array
    {
        return $this->http()->get($this->getEndpoint() . "/$domain/transfer/$processId");
    }
}