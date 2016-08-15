<?php

class CollectionExtensionTest extends CoreToolsTest
{
    public function testGetCollection()
    {
        $object = $this->objFromFixture('TestPage', 'default');
        $controller = new TestPage_Controller($object);
        $this->assertInstanceOf('DataList', $controller->getCollection());

        $object = $controller->config()->managed_object;
        $this->assertInstanceOf($object, $controller->getCollection()->first());
    }

    public function testGetManagedObject()
    {
        $object = TestPage_Controller::create();
        $one = 'ContentObject';
        $two = $object->getCollectionObject();
        $this->assertEquals($one, $two);
    }

    public function testGetPageSize()
    {
        $object = TestPage_Controller::create();
        $one = 10;
        $two = $object->getCollectionSize();
        $this->assertEquals($one, $two);
    }

    public function testPaginatedList()
    {
        $object = $this->objFromFixture('TestPage', 'default');
        $controller = new TestPage_Controller($object);
        $this->assertInstanceOf('PaginatedList', $controller->PaginatedList());
    }

    public function testGroupedList()
    {
        $object = $this->objFromFixture('TestPage', 'default');
        $controller = new TestPage_Controller($object);
        $this->assertInstanceOf('GroupedList', $controller->GroupedList());
    }

    public function testCollectionSearchForm()
    {
        $object = $this->objFromFixture('TestPage', 'default');
        $controller = new TestPage_Controller($object);
        $this->assertInstanceOf('Form', $controller->CollectionSearchForm());
    }
}
