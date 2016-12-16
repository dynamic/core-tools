<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\ORM\DataObject;

class EmailRecipient extends DataObject
{
    /**
     * @var array
     */
    private static $db = array(
        'FirstName' => 'Varchar(200)',
        'LastName' => 'Varchar(200)',
        'Email' => 'Varchar(255)',
        'SortOrder' => 'Int',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Page' => 'SilverStripe\\CMS\\Model\\SiteTree',
    );

    /**
     * @var array
     */
    private static $summary_fields = array(
        'FirstName',
        'LastName',
        'Email',
    );

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'PageID',
            'SortOrder',
        ));

        return $fields;
    }

    /**
     * Set permissions, allow all users to access by default.
     * Override in descendant classes, or use PermissionProvider.
     *
     * @param null $member
     * @param array $context
     * @return bool
     */
    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canEdit($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canDelete($member = null)
    {
        return true;
    }
}
