<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class ResellerHosting extends AbstractEndpoint
{
    /**
     * Gets all reseller hosting.
     *
     * @return array{resellerhostingList: array}
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * Get a specific reseller hosting.
     *
     * @param string $username
     *
     * @return array{resellerhostingInfo: array}
     * @throws ErrorException
     */
    public function get(string $username): array
    {
        return $this->http()->get($this->getEndpoint() . "/$username");
    }

    /**
     * Creates a new reseller hosting.
     *
     * @param array{
     *     name: string,
     *     email: string,
     *     plan_id: int,
     *     term: int,
     *     auto_renew: bool|null
     * } $data
     *
     * @return array{resellerhostingInfo: array}
     * @throws ErrorException
     */
    public function create(array $data): array
    {
        return $this->http()->post($this->getEndpoint(), $data);
    }

    /**
     * Updates an existing reseller hosting.
     *
     * @param string    $username
     * @param bool|null $sslManagement
     * @param bool|null $autoRenew
     * @param bool|null $resetLogin
     *
     * @return array{resellerhostingInfo: array}
     * @throws ErrorException
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
     * Renews reseller hosting.
     *
     * @param string    $username
     * @param int       $term
     * @param bool|null $autoRenew
     *
     * @return array
     * @throws ErrorException
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
     * Deletes a reseller hosting from your account.
     *
     * @param string $username
     *
     * @return bool
     * @throws ErrorException
     */
    public function delete(string $username): bool
    {
        return $this->http()->delete($this->getEndpoint() . "/$username");
    }
}