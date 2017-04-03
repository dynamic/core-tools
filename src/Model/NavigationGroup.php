<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\GridFieldExtensions\GridFieldAddExistingSearchButton;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\CMS\Model\SiteTree;

/**
 * Class NavigationGroup
 * @package Dynamic\CoreTools\Model
 *
 * @property string $Title
 * @property int $SortOrder
 * @property int $NavigationColumnID
 */
class NavigationGroup extends DataObject
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
      'NavigationColumn' => NavigationColumn::class,
    );

    /**
     * @var array
     */
    private static $many_many = array(
      'NavigationLinks' => SiteTree::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
      'NavigationLinks' => array(
        'SortOrder' => 'Int',
      ),
    );

    /**
     * @var string
     */
    private static $table_name = 'NavigationGroup';

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
          'SortOrder',
          'NavigationColumnID',
          'NavigationLinks',
        ));

        if ($this->ID) {
            $config = GridFieldConfig_RelationEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            if (class_exists('GridFieldAddExistingSearchButton')) {
                $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                $config->addComponent(new GridFieldAddExistingSearchButton());
            }
            $config->removeComponentsByType($config->getComponentByType('GridFieldAddNewButton'));
            $promos = $this->NavigationLinks()->sort('SortOrder');
            $linksField = GridField::create('NavigationLinks',
              'Navigation Links', $promos, $config);

            $fields->addFieldsToTab('Root.Main', array(
              $linksField,
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
            $result->addError('A Title is required before you can save');
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
