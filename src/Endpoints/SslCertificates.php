<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class SslCertificates extends AbstractEndpoint
{
    /**
     * @param int $id
     *
     * @return bool
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
     */
    public function order(array $data): array
    {
        $results = $this->http()->post($this->getEndpoint(), $data);

        return $results;
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
     * @throws Exception
     */
    public function reissue(int $id, array $data): array
    {
        return $this->http()->post($this->getEndpoint() . "/$id/reissue");
    }
}