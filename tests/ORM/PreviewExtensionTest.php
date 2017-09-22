<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\ORM\PreviewExtension;
use SilverStripe\Forms\FieldList;

/**
 * Class PreviewExtensionTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class PreviewExtensionTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = array(
        'CoreToolsTest.yml',
        'Fixtures.yml',
    );

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        TestPage::add_extension(PreviewExtension::class);
    }

        /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = $this->objFromFixture(TestPage::class, 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('PreviewTitle'));
        $this->assertNotNull($fields->dataFieldByName('Abstract'));
        $this->assertNotNull($fields->dataFieldByName('PreviewImage'));
    }

    /**
     *
     */
    public function testGetPreviewHeadline()
    {
        $object = $this->objFromFixture(TestPage::class, 'default');
        $this->assertEquals($object->getPreviewHeadline(), $object->Title);

        $object->PreviewTitle = 'Preview';
        $this->assertEquals($object->getPreviewHeadline(), $object->PreviewTitle);
    }

    /**
     *
     */
    public function testGetPreviewThumb()
    {
        $object = $this->objFromFixture(TestPage::class, 'default');
        $image = $this->objFromFixture(Image::class, 'preview');
        $this->assertFalse($object->getPreviewThumb());

        $object->PreviewImageID = $image->ID;
        $this->assertInstanceOf(Image::class, $object->getPreviewThumb());
    }

    /**
     *
     */
    public function testGetPreviewAbstract()
    {
        $object = $this->objFromFixture(TestPage::class, 'default');
        $this->assertEquals($object->getPreviewAbstract(), $object->obj('Content')->FirstParagraph());

        $object->Abstract = 'Preview';
        $this->assertEquals($object->getPreviewAbstract(), $object->Abstract);
    }

}
