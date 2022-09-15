<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class SslCertificates extends AbstractEndpoint
{
    /**
     * @param int $id
     *
     * @return bool
     * @throws ErrorException
     */
    public function cancel(int $id): bool
    {
        $results = $this->http()->post($this->getEndpoint() . "/$id/cancel");

        return $results['status'] === 'CANCELLED';
    }

    /**
     * @param int    $id
     * @param string $email
     *
     * @return array
     * @throws ErrorException
     */
    public function changeApprover(int $id, string $email): array
    {
        return $this->http()->post($this->getEndpoint() . "/$id/changeapprover", [
            'approver_email' => $email,
        ]);
    }

    /**
     * @param int $id
     *
     * @return array{SSLcertificateInfo: array}
     * @throws ErrorException
     */
    public function get(int $id): array
    {
        return $this->http()->get($this->getEndpoint() . "/$id");
    }

    /**
     * * ISSUED
     * * PENDING_VALIDATION
     * * PENDING
     *
     * @param string|null $status
     *
     * @return array{sslcertificatesList: array}
     * @throws ErrorException
     */
    public function list(?string $status = null): array
    {
        $data = [];

        if ($status !== null) {
            $data['status'] = $status;
        }

        return $this->http()->get($this->getEndpoint(), $data);
    }

    /**
     * @param array{
     *     csr: string,
     *     approver_email: string,
     *     product_id: int,
     *     years: int,
     *     contactperson: string,
     *     contactperson_email: string,
     *     contactperson_phone: string,
     *     address: string,
     *     postalcode: string,
     *     auto_renew: bool|null,
     *     san_names: array
     * } $data
     *
     * @return array{id: int}
     * @throws ErrorException
     */
    public function order(array $data): array
    {
        return $this->http()->post($this->getEndpoint(), $data);
    }

    /**
     * @param int $id
     * @param array{
     *     id: int,
     *     csr: string,
     *     approver_email: string,
     *     address: string,
     *     postalcode: string,
     * }          $data
     *
     * @return array{}
     * @throws ErrorException
     */
    public function reissue(int $id, array $data): array
    {
        return $this->http()->post($this->getEndpoint() . "/$id/reissue");
    }
}