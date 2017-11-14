<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Object;

use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\TestOnly;

/**
 * Class SlugDataObject.
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

    /**
     * @var string
     */
    private static $table_name = 'SlugDataObject_Test';

    private static $extensions = [

    ];
}
