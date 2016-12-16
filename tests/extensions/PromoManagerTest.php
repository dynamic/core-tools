<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Core\Injector\Injector,
    \Page;

/**
 * Class PromoManagerTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class PromoManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    /**
     *
     */
    public function testGetPromoList()
    {
        $page = $this->objFromFixture('Page', 'default');
        $promo = $this->objFromFixture('Promo', 'default');

        $this->assertTrue($page->getPromoList()->Count() == 0);

        $page->Promos()->add($promo);
        $this->assertTrue($page->getPromoList()->Count() > 0);
        $this->assertInstanceOf('Promo', $page->getPromoList()->First());
    }

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create('Page');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('Promos'));

        $object = $this->objFromFixture('Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('Promos'));
    }

}

Page::add_extension('Dynamic\\CoreTools\\Extensions\\PromoManager');
Page::add_extension('Dynamic\\CoreTools\\Extensions\\PromoRelation');