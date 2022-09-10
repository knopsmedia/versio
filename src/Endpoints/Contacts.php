<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class Contacts extends AbstractEndpoint
{
    /**
     * Creates a new contact from data.
     *
     * @param array{
     *     company: string,
     *     firstname: string,
     *     surname: string
     * } $data
     *
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->http()->post($this->getEndpoint(), $data);
    }

    /**
     * Deletes a contact by ID.
     *
     * @param int $contactId
     *
     * @return bool
     * @throws Exception
     */
    public function delete(int $contactId): bool
    {
        return $this->http()->delete($this->getEndpoint() . '/' . $contactId);
    }

    /**
     * @return array{ContactList: array}
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * @param int $contactId
     *
     * @return array{contact_id: int, validation_sent: string}
     * @throws Exception
     */
    public function resendValidation(int $contactId): array
    {
        return $this->http()->post(sprintf('%s/%d/resendvalidation', $this->getEndpoint(), $contactId));
    }
}