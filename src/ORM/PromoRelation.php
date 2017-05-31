<?php

namespace Dynamic\CoreTools\ORM;

use Dynamic\CoreTools\Model\Promo;
use SilverStripe\ORM\DataExtension;

/**
 * Class PromoRelation
 * @package Dynamic\CoreTools\Extensions
 */
class PromoRelation extends DataExtension
{
    private static $many_many = array(
        'Promos' => Promo::class,
    );

    private static $many_many_extraFields = array(
        'Promos' => array(
            'SortOrder' => 'Int',
        ),
    );
}