<?php

class LinkableTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    public function testGetLinkStatus()
    {
        $page = $this->objFromFixture('Page', 'default');
        $object = $this->objFromFixture('ContentObject', 'default');
        $object->LinkType = 'Internal';
        $object->PageLinkID = $page->ID;
        $this->assertEquals($object->getLinkStatus(), 'internal');

        $object = $this->objFromFixture('ContentObject', 'default');
        $object->LinkType = 'External';
        $object->ExternalLink = 'http://www.dynamicagency.com';
        $this->assertEquals($object->getLinkStatus(), 'external');
    }

    public function testLinkStatus()
    {
        $object = $this->objFromFixture('ContentObject', 'default');
        $this->assertEquals($object->LinkStatus(), $object->getLinkStatus());
    }
}
