<?php

/**
 * Class CoreToolsDataListDataExtensionTest
 */
class CoreToolsDataListDataExtensionTest extends SapphireTest
{

    /**
     * @var array
     */
    protected $extraDataObjects = [
        'NoSlugDataObject',
        'SlugDataObject',
    ];

    /**
     *
     */
    public function testGetByUrlSegment()
    {

        $noSlug = NoSlugDataObject::create(['Title' => 'No Slug']);
        $noSlug->write();
        $slug = SlugDataObject::create(['Title' => 'Slug', 'URLSegment' => 'i-has-url-segment']);
        $slug->write();


        //$this->assertFalse(NoSlugDataObject::get()->byUrlSegment('some-url-segment'));
        $this->assertInstanceOf('DataObject', SlugDataObject::get()->byUrlSegment('i-has-url-segment'));

    }

}

/**
 * Class NoSlugDataObject
 */
class NoSlugDataObject extends DataObject implements TestOnly
{

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(50)',
    ];

}

/**
 * Class SlugDataObject
 */
class SlugDataObject extends DataObject implements TestOnly
{

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(50)',
        'URLSegment' => 'Varchar(255)',
    ];

}
