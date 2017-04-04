<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Controller;

use \PageController;
use SilverStripe\Dev\TestOnly;

/**
 * Class TestPageController
 * @package Dynamic\CoreTools\Tests\TestOnly\Controller
 */
class TestPageController extends PageController implements TestOnly
{
    private static $managed_object = 'Dynamic\\CoreTools\\Model\\ContentObject';
}
