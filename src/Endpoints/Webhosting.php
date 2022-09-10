<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class Webhosting extends AbstractEndpoint
{
    /**
     * @param array{
     *     name: string,
     *     email: string,
     *     plan_id: string,
     *     term: int,
     *     auto_renew: bool|null
     * } $data
     *
     * @return array{webhostingInfo: array}
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->http()->post($this->getEndpoint(), $data);
    }

    /**
     * @param string $username
     *
     * @return bool
     * @throws Exception
     */
    public function delete(string $username): bool
    {
        return $this->http()->delete($this->getEndpoint() . "/$username");
    }

    /**
     * @param string $username
     *
     * @return array{webhostingInfo: array}
     * @throws Exception
     */
    public function get(string $username): array
    {
        return $this->http()->get($this->getEndpoint() . "/$username");
    }

    /**
     * @return array{webhostingList: array}
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * @param string    $username
     * @param int       $term
     * @param bool|null $autoRenew
     *
     * @return array{username: string, expires_at: string}
     * @throws Exception
     */
    public function renew(string $username, int $term, ?bool $autoRenew = null): array
    {
        $data = ['term' => $term];

        if ($autoRenew !== null) {
            $data['auto_renew'] = $autoRenew;
        }

        return $this->http()->post($this->getEndpoint() . "/$username/renew", $data);
    }

    /**
     * @param string    $username
     * @param bool|null $dnsManagement
     * @param bool|null $sslManagement
     * @param bool|null $autoRenew
     * @param bool|null $resetLogin
     *
     * @return array
     * @throws Exception
     */
    public function update(string $username, ?bool $dnsManagement = null, ?bool $sslManagement = null, ?bool $autoRenew = null, ?bool $resetLogin = null)
    {
        $data = [];

        if ($dnsManagement !== null) {
            $data['dns_management'] = $dnsManagement;
        }

        if ($sslManagement !== null) {
            $data['ssl_management'] = $sslManagement;
        }

        if ($autoRenew !== null) {
            $data['auto_renew'] = $autoRenew;
        }

        if ($resetLogin !== null) {
            $data['reset_login'] = $resetLogin;
        }

        return $this->http()->post($this->getEndpoint() . "/$username/update");
    }
}