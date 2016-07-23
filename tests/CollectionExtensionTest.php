<?php

class CollectionExtensionTest extends CoreToolsTest
{
    public function testGetManagedObject()
    {
        $object = TestPage_Controller::create();
        $one = 'Page';
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

    public function testItems()
    {
        $object = $this->objFromFixture('TestPage', 'parent');
        $controller = new TestPage_Controller($object);
        $this->assertInstanceOf('PaginatedList', $controller->CollectionItems());
    }

    public function testAdvSearchForm()
    {
        $object = $this->objFromFixture('TestPage', 'parent');
        $controller = new TestPage_Controller($object);
        $this->assertInstanceOf('Form', $controller->CollectionSearchForm());
    }

    public function testSearch()
    {
        $object = $this->objFromFixture('TestPage', 'parent');
        $controller = new TestPage_Controller($object);
        $this->assertInstanceOf('ViewableData', $controller->collectionSearch($data, $form, $request));

        $data = $controller->getRequest();
        $data['Title'] = 'Test';
        $data['Topics__ID'] = 1;
        $this->assertInstanceOf('ViewableData', $controller->collectionSearch($data, $form, $request));
    }
}
