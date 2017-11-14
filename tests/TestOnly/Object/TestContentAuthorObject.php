<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Object;

use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\TestOnly;
use Dynamic\CoreTools\ORM\ContentAuthorPermissionManager;

/**
 * Class TestContentAuthorObject.
 */
class TestContentAuthorObject extends DataObject implements TestOnly
{
    private static $extensions = [
        ContentAuthorPermissionManager::class,
    ];

    /**
     * @var string
     */
    private static $table_name = 'TestContentAuthorObject_Test';
}
