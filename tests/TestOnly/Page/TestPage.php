<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Page;

use \Page;
use SilverStripe\Dev\TestOnly;
use Dynamic\CoreTools\ORM\PromoManager;
use Dynamic\CoreTools\ORM\PreviewExtension;
use Dynamic\CoreTools\ORM\TagManager;
use Dynamic\CoreTools\ORM\HeaderImageDataExtension;
use Dynamic\CoreTools\Model\PageSection;
use Dynamic\CoreTools\Model\Promo;
use Dynamic\CoreTools\Model\Tag;

/**
 * Class TestPage
 * @package Dynamic\CoreTools\Tests\TestOnly\Page
 *
 * @property string $TestPageDBField
 */
class TestPage extends Page implements TestOnly
{

    /**
     * @var array
     */
    private static $db = [
        'TestPageDBField' => 'Varchar',
    ];

    /**
     * @var array
     */
    private static $has_many = array(
        'Sections' => PageSection::class,
    );

    /**
     * @var array
     */
    private static $many_many = array(
        'Promos' => Promo::class,
        'Tags' => Tag::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Promos' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var string
     */
    private static $table_name = 'TestPage_Test';

    /**
     * @var array
     */
    private static $extensions = [
        PromoManager::class,
        PreviewExtension::class,
        TagManager::class,
    ];
}
