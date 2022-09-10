<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class ResellerHosting extends AbstractEndpoint
{
    /**
     * @return array{resellerhostingList: array}
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * @param string $username
     *
     * @return array{resellerhostingInfo: array}
     * @throws Exception
     */
    public function get(string $username): array
    {
        return $this->http()->get($this->getEndpoint() . "/$username");
    }

    /**
     * @param array{
     *     name: string,
     *     email: string,
     *     plan_id: int,
     *     term: int,
     *     auto_renew: bool|null
     * } $data
     *
     * @return array{resellerhostingInfo: array}
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->http()->post($this->getEndpoint(), $data);
    }

    /**
     * @param string    $username
     * @param bool|null $sslManagement
     * @param bool|null $autoRenew
     * @param bool|null $resetLogin
     *
     * @return array{resellerhostingInfo: array}
     * @throws Exception
     */
    public function update(string $username, ?bool $sslManagement = null, ?bool $autoRenew = null, ?bool $resetLogin = null): array
    {
        $data = [];

        if ($sslManagement !== null) {
            $data['ssl_management'] = $sslManagement;
        }

        if ($autoRenew !== null) {
            $data['auto_renew'] = $autoRenew;
        }

        if ($resetLogin !== null) {
            $data['reset_login'] = $resetLogin;
        }

        return $this->http()->post($this->getEndpoint() . "/$username/update", $data);
    }

    /**
     * @param string    $username
     * @param int       $term
     * @param bool|null $autoRenew
     *
     * @return array
     * @throws Exception
     */
    public function renew(string $username, int $term, ?bool $autoRenew = null): array
    {
        $data = ['term' => $term];

        if ($autoRenew !== null) {
            $data['auto_renew'] = $autoRenew;
        }

        return $this->http()->post($this->getEndpoint() . "/$username", $data);
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
}