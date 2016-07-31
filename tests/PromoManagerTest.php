<?php

class PromoManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    public function testGetPromoList()
    {
        $page = $this->objFromFixture('Page', 'default');
        $promo = $this->objFromFixture('Promo', 'default');

        $this->assertTrue($page->getPromoList()->Count() == 0);

        $page->Promos()->add($promo);
        $this->assertTrue($page->getPromoList()->Count() > 0);
        $this->assertInstanceOf('Promo', $page->getPromoList()->First());
    }

    public function testUpdateCMSFields()
    {
        $object = singleton('Page');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNull($fields->dataFieldByName('Promos'));

        $object = $this->objFromFixture('Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNotNull($fields->dataFieldByName('Promos'));
    }
}

Page::add_extension('PromoManager');
Page::add_extension('PromoRelation');