<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\View\TemplateGlobalProvider;
use SilverStripe\Core\Config\Config;

/**
 * Class ReviewContentDataExtension
 * @package Dynamic\CoreTools\ORM
 *
 * This DataExtensions is meant to be applied to SiteConfig to allow wrapping
 * review content in a variable of $ShowReviewContent. This allows for easily turning review content on and off.
 *
 * This DataExtension is picked up by @TemplateGlobalProvider automatically. Updating the static::$show_review_content to true,
 * $ShowReviewContent will then return true in templates.
 *
 * This variable is at the same level in scope as $SiteConfig, so when in a loop or with an $Up or $Top will be required to access.
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
        return (bool)Config::inst()
          ->get('ReviewContentDataExtension', 'show_review_content');
    }

    /**
     * Add $SiteConfig to all SSViewers
     */
    public static function get_template_global_variables()
    {
        return array(
          'ShowReviewContent' => 'get_show_review_content',
        );
    }

}