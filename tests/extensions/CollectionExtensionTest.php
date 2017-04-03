<?php

/*
namespace Dynamic\CoreTools\Tests\Extensions;

use Dynamic\CoreTools\Tests\CoreToolsTest,
    Dynamic\CoreTools\Tests\TestPage_Controller;

/**
 * Class CollectionExtensionTest
 * @package Dynamic\CoreTools\Tests\Extensions
 *
class CollectionExtensionTest extends CoreToolsTest
{
    
    /**
     * 
     *
    public function testGetCollection()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Tests\\TestPage', 'default');
        $controller = TestPage_Controller::create($object);
        $this->assertInstanceOf('SilverStripe\\ORM\\DataList', $controller->getCollection());

        $object = $controller->config()->managed_object;
        $this->assertInstanceOf($object, $controller->getCollection()->first());
    }

    /**
     * 
     *
    public function testGetManagedObject()
    {
        $object = TestPage_Controller::create();
        $two = $object->getCollectionObject();
        $this->assertEquals('Dynamic\\CoreTools\\Model\\ContentObject', $two);
    }

    /**
     * 
     *
    public function testGetPageSize()
    {
        $object = TestPage_Controller::create();
        $two = $object->getCollectionSize();
        $this->assertEquals(10, $two);
    }

    /**
     * 
     *
    public function testPaginatedList()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Tests\\TestPage', 'default');
        $controller = TestPage_Controller::create($object);
        $this->assertInstanceOf('SilverStripe\\ORM\\PaginatedList', $controller->PaginatedList());
    }

    /**
     * 
     *
    public function testGroupedList()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Tests\\TestPage', 'default');
        $controller = TestPage_Controller::create($object);
        $this->assertInstanceOf('SilverStripe\\ORM\\GroupedList', $controller->GroupedList());
    }

    /**
     * 
     *
    public function testCollectionSearchForm()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Tests\\TestPage', 'default');
        $controller = TestPage_Controller::create($object);
        $this->assertInstanceOf('SilverStripe\\Forms\\Form', $controller->CollectionSearchForm());
    }
    
}
//*/