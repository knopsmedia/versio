<?php

namespace Versio\Endpoints;

use Versio\Exceptions\Exception;

final class Categories extends AbstractEndpoint
{
    /**
     * Creates a new category with name.
     *
     * @param string $name
     *
     * @return array{category_id: int}
     * @throws Exception
     */
    public function create(string $name): array
    {
        return $this->http()->post($this->getEndpoint(), ['name' => $name]);
    }

    /**
     * Deletes a category by ID.
     *
     * @param int $categoryId
     *
     * @return bool
     * @throws Exception
     */
    public function delete(int $categoryId): bool
    {
        return $this->http()->delete($this->getEndpoint() . '/' . $categoryId);
    }

    /**
     * Returns a list of categories with keys category_id & name.
     *
     * @return array{CategoryList: array}
     * @throws Exception
     */
    public function list(): array
    {
        return $this->http()->get($this->getEndpoint());
    }
}