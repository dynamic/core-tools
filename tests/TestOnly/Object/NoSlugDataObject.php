<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Object;

use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\TestOnly;

/**
 * Class NoSlugDataObject
 * @package Dynamic\CoreTools\Tests\TestOnly\Object
 */
class NoSlugDataObject extends DataObject implements TestOnly
{

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(50)',
    ];

    /**
     * @var string
     */
    private static $table_name = 'NoSlugDataObject_Test';

}
