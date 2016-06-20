<?php

class CoreToolsPageDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = array(
        'Sections' => 'PageSection',
    );

    /**
     * @var array
     */
    private static $many_many = array(
        'Promos' => 'Promo',
        'Videos' => 'YouTubeVideo',
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Promos' => array(
            'SortOrder' => 'Int',
        ),
        'Videos' => array(
            'SortOrder' => 'Int',
        ),
    );
}
