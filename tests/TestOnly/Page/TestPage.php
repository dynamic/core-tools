<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Page;

use Dynamic\CoreTools\ORM\CoreToolsPageFieldsDataExtension;
use Dynamic\CoreTools\ORM\Linkable;
use Dynamic\CoreTools\ORM\PageSectionManager;
use Dynamic\CoreTools\ORM\PageSectionRelation;
use Dynamic\CoreTools\ORM\PromoRelation;
use Dynamic\CoreTools\ORM\RecipientManager;
use Dynamic\CoreTools\ORM\SiteTreeSubTitleExtension;
use Page;
use SilverStripe\Dev\TestOnly;
use Dynamic\CoreTools\ORM\PromoManager;
use Dynamic\CoreTools\ORM\PreviewExtension;
use Dynamic\CoreTools\ORM\TagManager;
use Dynamic\CoreTools\ORM\HeaderImageDataExtension;
use Dynamic\CoreTools\Model\PageSection;
use Dynamic\CoreTools\Model\Tag;

/**
 * Class TestPage.
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
        'Tags' => Tag::class,
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
        PromoRelation::class,
        PageSectionManager::class,
        PageSectionRelation::class,
        PreviewExtension::class,
        TagManager::class,
        HeaderImageDataExtension::class,
        CoreToolsPageFieldsDataExtension::class,
        SiteTreeSubTitleExtension::class,
        Linkable::class,
        RecipientManager::class,
    ];
}
