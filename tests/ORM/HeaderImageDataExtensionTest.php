<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;

/**
 * Class HeaderImageDataExtensionTest
 * @package Dynamic\CoreTools\Tests\ORM
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