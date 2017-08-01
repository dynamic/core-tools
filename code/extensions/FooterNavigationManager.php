<?php

class FooterNavigationManager extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = array(
        'NavigationColumns' => 'NavigationColumn',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        // footer navigation
        if ($this->owner->ID && $this->owner->ClassName != 'SiteConfig') {
            $config = GridFieldConfig_RecordEditor::create();
            if (class_exists('GridFieldOrderableRows')) {
                $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->removeComponentsByType('GridFieldDeleteAction');
            $config->addComponent(new GridFieldDeleteAction(false));
            $footerLinks = GridField::create('NavigationColumns', 'Navigation Columns', $this->owner->NavigationColumns()->sort('SortOrder'), $config);

            $fields->addFieldsToTab('Root.Footer', array(
                $footerLinks,
            ));
        }
    }
}