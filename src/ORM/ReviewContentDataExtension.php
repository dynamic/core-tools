<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\View\TemplateGlobalProvider;
use SilverStripe\Core\Config\Config;

/**
 * Class ReviewContentDataExtension.
 */
class ReviewContentDataExtension extends DataExtension implements TemplateGlobalProvider
{
    /**
     * @var bool
     */
    private static $show_review_content = false;

    /**
     * @return bool
     */
    public static function get_show_review_content()
    {
        return (bool) Config::inst()
          ->get('ReviewContentDataExtension', 'show_review_content');
    }

    /**
     * Add $SiteConfig to all SSViewers.
     */
    public static function get_template_global_variables()
    {
        return array(
          'ShowReviewContent' => 'get_show_review_content',
        );
    }
}
