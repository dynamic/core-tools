<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\ORM\DataObject,
    SilverStripe\Dev\TestOnly;

/**
 * Class CoreToolsDataListDataExtensionTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class CoreToolsDataListDataExtensionTest extends SapphireTest
{

    /**
     * @var array
     */
    protected $extraDataObjects = [
        'Dynamic\\CoreTools\\Tests\\Extensions\\NoSlugDataObject',
        'Dynamic\\CoreTools\\Tests\\Extensions\\SlugDataObject',
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
        $this->assertInstanceOf('SilverStripe\\ORM\\DataObject', SlugDataObject::get()->byUrlSegment('i-has-url-segment'));

    }

}

/**
 * Class NoSlugDataObject
 * @package Dynamic\CoreTools\Tests\Extensions
 *
 * @property string $Title
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
 * @package Dynamic\CoreTools\Tests\Extensions
 *
 * @property string $Title
 * @property string $URLSegment
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
