<?php

namespace Versio\Endpoints;

use Versio\Exceptions\ErrorException;

final class Categories extends AbstractEndpoint
{
    /**
     * Creates a new category in your account.
     *
     * @param string $name
     *
     * @return array{category_id: int}
     * @throws ErrorException
     */
    public function create(string $name): array
    {
        return $this->http()->post($this->getEndpoint(), ['name' => $name]);
    }

    /**
     * Deletes an existing category from your account.
     *
     * @param int $categoryId
     *
     * @return bool
     * @throws ErrorException
     */
    public function delete(int $categoryId): bool
    {
        return $this->http()->delete($this->getEndpoint() . "/$categoryId");
    }

    /**
     * Returns all categories in your account.
     *
     * @return array{
     *   CategoryList: array{
     *     category_id: int,
     *     name: string
     *   }
     * }
     * @throws ErrorException
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }
}