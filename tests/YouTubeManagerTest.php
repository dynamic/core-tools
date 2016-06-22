<?php

class YouTubeManagerTest extends CoreToolsTest
{
    public function testGetVideoList()
    {
        $page = $this->objFromFixture('TestPage', 'parent');
        $video = $this->objFromFixture('YouTubeVideo', 'default');

        $this->assertTrue($page->getVideoList()->Count() == 0);

        $page->Videos()->add($video);
        $this->assertTrue($page->getVideoList()->Count() > 0);
        $this->assertInstanceOf('YouTubeVideo', $page->getVideoList()->First());
    }

    public function testUpdateCMSFields()
    {
        $object = singleton('TestPage');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNull($fields->dataFieldByName('Videos'));

        $object = $this->objFromFixture('TestPage', 'parent');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNotNull($fields->dataFieldByName('Videos'));
    }

    public function testContentcontrollerInit()
    {
    }
}
