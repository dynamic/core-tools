<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\Tests\TestOnly\Object\NoSlugDataObject;
use Dynamic\CoreTools\Tests\TestOnly\Object\SlugDataObject;
use SilverStripe\ORM\DataObject;

/**
 * Class CoreToolsDataListDataExtensionTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class CoreToolsDataListDataExtensionTest extends SapphireTest
{

    /**
     * @var array
     */
    public static $extra_dataobjects = [
        NoSlugDataObject::class,
        SlugDataObject::class,
    ];

    /**
     *
     */
    public function testGetByUrlSegment()
    {
        $noSlug = NoSlugDataObject::create(['Title' => 'No Slug']);
        $noSlug->write();
        $slug = SlugDataObject::create([
            'Title' => 'Slug',
            'URLSegment' => 'i-has-url-segment'
        ]);
        $slug->write();


        //$this->assertFalse(NoSlugDataObject::get()->byUrlSegment('some-url-segment'));
        $this->assertInstanceOf(
            DataObject::class,
            SlugDataObject::get()->byUrlSegment('i-has-url-segment')
        );
    }

}