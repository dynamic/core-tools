<?php

class PromoManagerTest extends CoreToolsTest
{
    public function testGetPromoList()
    {
        $page = $this->objFromFixture('TestPage', 'parent');
        $promo = $this->objFromFixture('Promo', 'default');

        $this->assertTrue($page->getPromoList()->Count() == 0);

        $page->Promos()->add($promo);
        $this->assertTrue($page->getPromoList()->Count() > 0);
        $this->assertInstanceOf('Promo', $page->getPromoList()->First());
    }

    public function testUpdateCMSFields()
    {
        $object = singleton('TestPage');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNull($fields->dataFieldByName('Promos'));

        $object = $this->objFromFixture('TestPage', 'parent');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNotNull($fields->dataFieldByName('Promos'));
    }
}
