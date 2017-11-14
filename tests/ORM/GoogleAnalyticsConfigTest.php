<?php

namespace Dynamic\CoreTools\Tests;

use Dynamic\CoreTools\Model\GlobalSiteSetting;
use Dynamic\CoreTools\ORM\GoogleAnalyticsConfig;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class GoogleAnalyticsConfigTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../Fixtures.yml';

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        GlobalSiteSetting::add_extension(GoogleAnalyticsConfig::class);
    }

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = Injector::inst()->create(GlobalSiteSetting::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('GACode'));
    }
}
