<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\ORM\PromoManager;
use Dynamic\CoreTools\ORM\PromoRelation;
use \Page;

/**
 * Class PromoManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
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