<?php

namespace Dynamic\CoreTools\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\SiteConfig\SiteConfig;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use Dynamic\CoreTools\Tests\TestOnly\Controller\TestPageController;
use Dynamic\CoreTools\ORM\HeaderImageDataExtension;
use Dynamic\CoreTools\ORM\MultiLinksManager;
use Dynamic\CoreTools\ORM\PageSectionManager;
use Dynamic\CoreTools\ORM\PageSectionRelation;
use Dynamic\CoreTools\ORM\PreviewExtension;
use Dynamic\CoreTools\ORM\PromoManager;
use Dynamic\CoreTools\ORM\PromoRelation;
use Dynamic\CoreTools\ORM\RecipientManager;
use Dynamic\CoreTools\ORM\TemplateConfig;
use \Page;

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
      TestPageController::class,
    );

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        Page::add_extension(HeaderImageDataExtension::class);
        Page::add_extension(MultiLinksManager::class);
        Page::add_extension(PageSectionManager::class);
        Page::add_extension(PageSectionRelation::class);
        Page::add_extension(PreviewExtension::class);
        Page::add_extension(PromoManager::class);
        Page::add_extension(PromoRelation::class);
        Page::add_extension(RecipientManager::class);
        SiteConfig::add_extension(TemplateConfig::class);

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

//TestPage_Controller::add_extension('Dynamic\\CoreTools\\Extension\\CollectionExtension');
