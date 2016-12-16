<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Core\Injector\Injector,
    SilverStripe\SiteConfig\SiteConfig;

/**
 * Class TemplateConfigTest
 * @package Dynamic\CoreTools\Tests\Extensions
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
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create('SiteConfig');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('TitleLogo'));
    }

    /**
     *
     */
    public function testGetSiteLogo()
    {
        $object = Injector::inst()->create('SiteConfig');
        $logo = $this->objFromFixture('SilverStripe\\Assets\\Image', 'logo');
        $object->LogoID = $logo->ID;
        $this->assertInstanceOf('SilverStripe\\Assets\\Image', $object->getSiteLogo());
    }

}

SiteConfig::add_extension('Dynamic\\CoreTools\\Extensions\\TemplateConfig');