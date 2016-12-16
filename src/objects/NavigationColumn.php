<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\ORM\DataObject,
    SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor,
    SilverStripe\Forms\GridField\GridFieldDeleteAction,
    SilverStripe\Forms\GridField\GridField;

/**
 * Class NavigationColumn
 * @package Dynamic\CoreTools\Model
 *
 * @property string $Title
 * @property int $SortOrder
 * @property int $SiteConfigID
 */
class NavigationColumn extends DataObject
{
    /**
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(255)',
        'SortOrder' => 'Int',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'SiteConfig' => 'SiteConfig',
        'GlobalConfig' => 'GlobalSiteSetting',
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'NavigationGroups' => 'Dynamic\\CoreTools\\Model\\NavigationGroup',
    );

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'SiteConfigID',
            'SortOrder',
            'NavigationGroups',
        ));

        // navigation groups
        if ($this->ID) {
            $config = GridFieldConfig_RecordEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldSortableRows('SortOrder'));
            }
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->removeComponentsByType('GridFieldDeleteAction');
            $config->addComponent(new GridFieldDeleteAction(false));
            $footerLinks = GridField::create('NavigationGroups', 'Navigation Groups', $this->NavigationGroups()->sort('SortOrder'), $config);

            $fields->addFieldsToTab('Root.Main', array(
                $footerLinks,
            ));
        }

        return $fields;
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->error('A Title is required before you can save');
        }

        return $result;
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