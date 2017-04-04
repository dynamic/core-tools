<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\SiteConfig\SiteConfig;
use Dynamic\CoreTools\ORM\TemplateConfig;

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

SiteConfig::add_extension(TemplateConfig::class);