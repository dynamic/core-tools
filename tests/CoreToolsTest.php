<?php

namespace Dynamic\CoreTools\Tests;

use Dynamic\CoreTools\Model\PageSection;
use Dynamic\CoreTools\Model\Promo;
use Dynamic\CoreTools\Model\Tag;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Dev\TestOnly;
use \Page;
use \PageController;

/**
 * Class CoreToolsTest
 * @package Dynamic\CoreTools\Tests
 */
class CoreToolsTest extends FunctionalTest
{
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
     * @var array
     */
    public static $extra_data_objects = array(
        TestPage::class,
        TestPage_Controller::class,
    );

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

}

/**
 * Class TestPage
 * @package Dynamic\CoreTools\Tests
 */
class TestPage extends Page implements TestOnly
{

    /**
     * @var array
     */
    private static $db = [
        'TestPageDBField' => 'Varchar',
    ];

    private static $has_many = array(
        'Sections' => PageSection::class,
    );

    private static $many_many = array(
        'Promos' => Promo::class,
        'Tags' => Tag::class,
    );

    private static $many_many_extraFields = array(
        'Promos' => array(
            'SortOrder' => 'Int',
        ),
    );
}

/**
 * Class TestPage_Controller
 * @package Dynamic\CoreTools\Tests
 */
class TestPage_Controller extends PageController implements TestOnly
{
    private static $managed_object = 'Dynamic\\CoreTools\\Model\\ContentObject';
}

TestPage::add_extension('Dynamic\\CoreTools\\ORM\\PromoManager');
TestPage::add_extension('Dynamic\\CoreTools\\ORM\\PreviewExtension');
TestPage::add_extension('Dynamic\\CoreTools\\ORM\\TagManager');
//TestPage_Controller::add_extension('Dynamic\\CoreTools\\Extension\\CollectionExtension');
