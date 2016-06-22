<?php

class LinkableTest extends CoreToolsTest
{
    public function testGetLinkStatus()
    {
        $page = $this->objFromFixture('Page', 'default');
        $object = $this->objFromFixture('ContentObject', 'default');
        $object->LinkType = 'Internal';
        $object->PageLinkID = $page->ID;
        $this->assertEquals($object->getLinkStatus(), 'yes');

        $object = $this->objFromFixture('ContentObject', 'default');
        $object->LinkType = 'External';
        $object->ExternalLink = 'http://www.dynamicagency.com';
        $this->assertEquals($object->getLinkStatus(), 'yes');
    }

    public function testLinkStatus()
    {
        $object = $this->objFromFixture('ContentObject', 'default');
        $this->assertEquals($object->LinkStatus(), $object->getLinkStatus());
    }
}
