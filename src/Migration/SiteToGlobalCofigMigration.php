<?php

namespace Dynamic\CoreTools\Migration;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataExtension;
use Symbiote\Addressable\Addressable;
use Symbiote\Addressable\Geocodable;

class SiteToGlobalCofigMigration extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'CompanyName' => 'Varchar(200)',
        'Phone' => 'Varchar(20)',
        'Email' => 'Varchar(100)',
        'ShowDirections' => 'Boolean',
        'Hours' => 'Text',
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'NavigationColumns' => NavigationColumn::class,
    );

    /**
     * @var array
     */
    private static $many_many = array(
        'UtilityLinks' => SiteTree::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'UtilityLinks' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $extensions = [
        Addressable::class,
        Geocodable::class,
    ];
    
    
}