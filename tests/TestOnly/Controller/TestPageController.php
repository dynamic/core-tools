<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Controller;

use Dynamic\CoreTools\Model\ContentObject;
use PageController;
use SilverStripe\Dev\TestOnly;

/**
 * Class TestPageController.
 */
class TestPageController extends PageController implements TestOnly
{
    private static $managed_object = ContentObject::class;
}
