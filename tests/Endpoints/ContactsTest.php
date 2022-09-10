<?php

namespace VersioTests\Endpoints;

use Versio\Endpoints\Contacts;

final class ContactsTest extends AbstractEndpointTest
{
    private Contacts $contactsApi;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->contactsApi = new Contacts($this->http());
    }

    /**
     * @covers Contacts::list()
     *
     * @return void
     * @throws \Versio\Exceptions\Exception
     */
    public function testItReturnsContacts(): void
    {
        $results = $this->contactsApi->list();
        
        $this->assertIsArray($results);
        $this->assertArrayHasKey('ContactList', $results);

        foreach ($results['ContactList'] as $result) {
            $this->assertArrayHasKey('firstname', $result);
        }
    }
}