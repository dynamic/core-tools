<?php

namespace Dynamic\CoreTools\Model;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\SiteConfig\SiteConfig;

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
     * @var string
     */
    private static $singular_name = 'Column';

    /**
     * @var string
     */
    private static $plural_name = 'Columns';

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
        'GlobalConfig' => GlobalSiteSetting::class,
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'NavigationGroups' => NavigationGroup::class,
    );

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title' => 'Title',
        'GroupList' => 'Groups',
        'LinkList' => 'Links'
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Title',
    ];

    /**
     * @return string
     */
    public function GroupList()
    {
        if ($this->NavigationGroups()) {
            $i = 0;
            foreach ($this->NavigationGroups()->sort('SortOrder') as $link) {
                ++$i;
            }
        }
        return $i;
    }

    /**
     * @return string
     */
    public function LinkList()
    {
        $i = 0;

        if ($this->NavigationGroups()) {
            foreach($this->NavigationGroups() as $group) {
                foreach ($group->NavigationLinks() as $link) {
                    ++$i;
                }
            }
        }

        return $i;
    }

	/**
	 * @var string
	 */
	private static $table_name = 'NavigationColumn';

	/**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'GlobalConfigID',
            'SortOrder',
            'NavigationGroups',
        ));

        $fields->dataFieldByName('Title')
            ->setDescription('For internal reference only');

        // navigation groups
        if ($this->ID) {
            $config = GridFieldConfig_RecordEditor::create();
	        $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->removeComponentsByType('GridFieldDeleteAction');
            $config->addComponent(new GridFieldDeleteAction(false));
            $footerLinks = GridField::create('NavigationGroups', 'Link Groups', $this->NavigationGroups()->sort('SortOrder'), $config);

            $fields->addFieldsToTab('Root.Main', array(
                $footerLinks
                    ->setDescription('Add a group of links to the footer navigation area'),
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
    public function canView($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canEdit($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canDelete($member = null, $context = [])
    {
        return true;
    }
}
