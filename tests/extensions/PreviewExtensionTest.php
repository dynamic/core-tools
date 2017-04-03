<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\ORM\PageSectionRelation;
use Dynamic\CoreTools\ORM\PreviewExtension;
use \Page;

class PreviewExtensionTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = $this->objFromFixture('\Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('PreviewTitle'));
        $this->assertNotNull($fields->dataFieldByName('Abstract'));
        $this->assertNotNull($fields->dataFieldByName('PreviewImage'));
    }

    /**
     *
     */
    public function testGetPreviewHeadline()
    {
        $object = $this->objFromFixture('\Page', 'default');
        $this->assertEquals($object->getPreviewHeadline(), $object->Title);

        $object->PreviewTitle = 'Preview';
        $this->assertEquals($object->getPreviewHeadline(), $object->PreviewTitle);
    }

    /**
     *
     */
    public function testGetPreviewThumb()
    {
        $object = $this->objFromFixture('\Page', 'default');
        $image = $this->objFromFixture('SilverStripe\\Assets\\Image', 'preview');
        $this->assertFalse($object->getPreviewThumb());

        $object->PreviewImageID = $image->ID;
        $this->assertInstanceOf('SilverStripe\\Assets\\Image', $object->getPreviewThumb());
    }

    /**
     *
     */
    public function testGetPreviewAbstract()
    {
        $object = $this->objFromFixture('\Page', 'default');
        $this->assertEquals($object->getPreviewAbstract(), $object->obj('Content')->FirstParagraph());

        $object->Abstract = 'Preview';
        $this->assertEquals($object->getPreviewAbstract(), $object->Abstract);
    }

}

Page::add_extension(PageSectionRelation::class);
Page::add_extension(PreviewExtension::class);
