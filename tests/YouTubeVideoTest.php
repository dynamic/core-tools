<?php

class YouTubeVideoTest extends CoreToolsTest
{
    public function testGetCMSFields()
    {
        $object = new YouTubeVideo();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    public function testValidateVideo()
    {
        $object = $this->objFromFixture('YouTubeVideo', 'default');
        $object->Video = '';
        $this->setExpectedException('ValidationException');
        $object->write();
    }

    public function testGetVideoID()
    {
        $object = $this->objFromFixture('YouTubeVideo', 'default');
        $this->assertEquals($object->getVideoID(), 'dM15HfUYwF0');
    }
}
