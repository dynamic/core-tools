<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Model\HeaderImage;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;

/**
 * Class HeaderImageDataExtensionTest.
 */
class HeaderImageDataExtensionTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        '../Fixtures.yml',
    );

    /**
     * @var array
     */
    protected static $extra_dataobjects = [
        TestPage::class,
    ];

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create(TestPage::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('HeaderImage'));
    }

    /**
     *
     */
    public function testGetPageHeaderImage()
    {
        $page = new TestPage();
        $subpage = new TestPage();
        $subpage->ParentID = $page->ID;
        $image = $this->objFromFixture(HeaderImage::class, 'header');

        $this->assertNull($subpage->getPageHeaderImage());

        $page->HeaderImageID = $image->ID;
        $page->write();

        $this->assertInstanceOf(HeaderImage::class, $page->getPageHeaderImage());
        //$this->assertInstanceOf(Image::class, $subpage->getPageHeaderImage());

        $subpage->HeaderImageID = $image->ID;
        $subpage->write();
        $this->assertInstanceOf(HeaderImage::class, $subpage->getPageHeaderImage());
    }
}
