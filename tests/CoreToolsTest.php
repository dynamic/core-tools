<?php

namespace Dynamic\CoreTools\Tests;

use SilverStripe\Dev\FunctionalTest;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use Dynamic\CoreTools\Tests\TestOnly\Controller\TestPageController;

/**
 * Class CoreToolsTest
 * @package Dynamic\CoreTools\Tests
 */
class CoreToolsTest extends FunctionalTest
{
    /**
     * @var array
     */
    protected static $extra_dataobjects = array(
        TestPage::class,
        TestPageController::class,
    );

    /**
     * @var string
     */
    protected static $fixture_file = array(
        'core-tools/tests/CoreToolsTest.yml',
        'core-tools/tests/Fixtures.yml',
    );

    /**
     * @var bool
     */
    protected static $disable_themes = true;

    /**
     * @var bool
     */
    protected static $use_draft_site = false;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    }

    /**
     *
     */
    public function logOut()
    {
        $this->session()->clear('loggedInAs');
        $this->session()->clear('logInWithPermission');
    }

    /**
     *
     */
    public function testBlank()
    {
    }

}

//TestPage_Controller::add_extension('Dynamic\\CoreTools\\Extension\\CollectionExtension');
