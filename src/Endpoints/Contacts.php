<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class Contacts extends AbstractEndpoint
{
    /**
     * Creates a new contact in your account.
     *
     * @param array{
     *     company: string|null,
     *     firstname: string,
     *     surname: string,
     *     email: string,
     *     phone: string,
     *     street: string,
     *     number: string,
     *     number_addition: string|null,
     *     zipcode: string,
     *     city: string,
     *     country: string,
     *     default: bool|null,
     *     properties: array
     * } $data
     *
     * @return array{contact_id: int}
     * @throws ErrorException
     */
    public function create(array $data): array
    {
        return $this->http()->post($this->getEndpoint(), $data);
    }

    /**
     * Deletes an existing contact from your account.
     *
     * @param int $contactId
     *
     * @return bool
     * @throws ErrorException
     */
    public function delete(int $contactId): bool
    {
        return $this->http()->delete($this->getEndpoint() . "/$contactId");
    }

    /**
     * Returns all contacts in your account.
     *
     * @return array{
     *   ContactList: array{
     *     company: string|null,
     *     firstname: string,
     *     surname: string,
     *     email: string,
     *     phone: string,
     *     street: string,
     *     number: string,
     *     number_addition: string|null,
     *     zipcode: string,
     *     city: string,
     *     country: string,
     *     default: bool|null,
     *     properties: array
     *   }
     * }
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }

    /**
     * Resends the email validation to your contact.
     *
     * @param int $contactId
     *
     * @return array{contact_id: int, validation_sent: string}
     * @throws ErrorException
     */
    public function resendValidation(int $contactId): array
    {
        return $this->http()->post($this->getEndpoint() . "/$contactId/resendvalidation");
    }
}