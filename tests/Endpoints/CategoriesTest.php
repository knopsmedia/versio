<?php

namespace VersioTests\Endpoints;

use Versio\Endpoints\Categories;
use Versio\Exceptions\Exception;

final class CategoriesTest extends AbstractEndpointTest
{
    private Categories $categoriesApi;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->categoriesApi = new Categories($this->http());
    }

    /**
     * @covers Categories::create()
     *
     * @return void
     * @throws Exception
     */
    public function testItCreatesCategories(): void
    {
        $results = $this->categoriesApi->create('Test');

        $this->assertIsArray($results);
        $this->assertArrayHasKey('category_id', $results);
    }

    /**
     * @covers Categories::list()
     *
     * @return void
     * @throws Exception
     */
    public function testItReturnsCategories(): void
    {
        $results = $this->categoriesApi->list();

        $this->assertIsArray($results);
        $this->assertArrayHasKey('CategoryList', $results);

        foreach ($results['CategoryList'] as $result) {
            $this->assertArrayHasKey('category_id', $result);
            $this->assertArrayHasKey('name', $result);
        }
    }

    /**
     * @covers Categories::delete()
     *
     * @return void
     * @throws Exception
     */
    public function testItDeletesCategories(): void
    {
        $data = $this->categoriesApi->list();
        $results = $this->categoriesApi->delete($data['CategoryList'][0]['category_id']);

        $this->assertTrue($results);
    }
}