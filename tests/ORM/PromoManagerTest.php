<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Model\Promo;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;

/**
 * Class PromoManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class PromoManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../Fixtures.yml';

    /**
     * @var array
     */
    protected static $extra_dataobjects = [
        TestPage::class,
    ];

        /**
     *
     */
    public function testGetPromoList()
    {
        $this->setUp();
        $page = Injector::inst()->create(TestPage::class);
        $page->writeToStage('Stage');
        $promo = $this->objFromFixture(Promo::class, 'default');

        $this->assertTrue($page->getPromoList()->Count() == 0);

        $page->Promos()->add($promo);
        $this->assertTrue($page->getPromoList()->Count() > 0);
        $this->assertInstanceOf(Promo::class, $page->getPromoList()->first());
    }

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create(TestPage::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('Promos'));

        $object = Injector::inst()->create(TestPage::class);
        $object->writeToStage('Stage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('Promos'));
    }

}