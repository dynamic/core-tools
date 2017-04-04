<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Page;

use \Page;
use SilverStripe\Dev\TestOnly;
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
