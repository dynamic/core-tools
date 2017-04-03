<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\ORM\HeaderImageDataExtension;
use \Page;

/**
 * Class HeaderImageDataExtensionTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class HeaderImageDataExtensionTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create('Dynamic\\CoreTools\\Tests\\TestPage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('HeaderImage'));
    }

    /**
     *
     */
    public function testGetPageHeaderImage()
    {
        $page = $this->objFromFixture('\Page', 'default');
        $subpage = $this->objFromFixture('\Page', 'subpage');
        $image = $this->objFromFixture('SilverStripe\\Assets\\Image', 'header');

        $this->assertNull($subpage->getPageHeaderImage());

        $page->HeaderImageID = $image->ID;
        $page->write();

        $this->assertInstanceOf('SilverStripe\\Assets\\Image', $page->getPageHeaderImage());
        $this->assertInstanceOf('SilverStripe\\Assets\\Image', $subpage->getPageHeaderImage());

        $subpage->HeaderImageID = $image->ID;
        $subpage->write();
        $this->assertInstanceOf('SilverStripe\\Assets\\Image', $subpage->getPageHeaderImage());
    }

}

Page::add_extension(HeaderImageDataExtension::class);
