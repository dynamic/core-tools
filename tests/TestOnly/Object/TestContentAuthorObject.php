<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Object;

use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\TestOnly;
use Dynamic\CoreTools\ORM\ContentAuthorPermissionManager;

/**
 * Class TestContentAuthorObject
 * @package Dynamic\CoreTools\Tests\TestOnlyObjects
 */
class TestContentAuthorObject extends DataObject implements TestOnly
{
    private static $extensions = [
      ContentAuthorPermissionManager::class,
    ];
}
