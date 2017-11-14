<?php

namespace Dynamic\CoreTools\ORM;

use Dynamic\CoreTools\Model\PageSection;
use SilverStripe\ORM\DataExtension;

/**
 * Class PageSectionRelation.
 */
class PageSectionRelation extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = array(
        'Sections' => PageSection::class,
    );
}
