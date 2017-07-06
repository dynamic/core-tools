<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\ORM\TemplateConfig;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class TemplateConfigTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class TemplateConfigTest extends SapphireTest
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
    public function setUp()
    {
        parent::setUp();

        SiteConfig::add_extension(TemplateConfig::class);
    }

        /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create('SilverStripe\\SiteConfig\\SiteConfig');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('TitleLogo'));
    }

    /**
     *
     */
    public function testGetSiteLogo()
    {
        $object = Injector::inst()->create('SilverStripe\\SiteConfig\\SiteConfig');
        $logo = $this->objFromFixture('SilverStripe\\Assets\\Image', 'logo');
        $object->LogoID = $logo->ID;
        $this->assertInstanceOf('SilverStripe\\Assets\\Image', $object->getSiteLogo());
    }

}