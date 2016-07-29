<?php

class CoreToolsTest extends FunctionalTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/CoreToolsTest.yml';
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
    protected $extraDataObjects = array(
        'TestPage',
        'TestPage_Controller'
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

    /**
     * empty test to prevent throwing an error.
     */
    public function testCoreTools()
    {
    }
}

/**
 * Class TestPage.
 */
class TestPage extends Page implements TestOnly
{
    private static $many_many = array(
        'Tags' => 'Tag',
    );
}

class TestPage_Controller extends Page_Controller implements TestOnly
{
}

TestPage::add_extension('CoreToolsPageDataExtension');
TestPage::add_extension('HeaderImageDataExtension');
TestPage::add_extension('PageSectionManager');
TestPage::add_extension('PromoManager');
TestPage::add_extension('PreviewExtension');
TestPage::add_extension('YouTubeManager');
TestPage::add_extension('TagManager');
TestPage_Controller::add_extension('CollectionExtension');
