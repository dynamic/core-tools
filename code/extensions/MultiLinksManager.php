<?php

class MultiLinksManager extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = [
        'ContentLinks' => 'Link',
    ];

    private static $many_many_extraFields = [
        'ContentLinks' => [
            'Sort' => 'Int',
        ],
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'ContentLinks',
        ]);

        if ($this->owner->ID) {
            $config = new GridFieldConfig_RelationEditor();
            if (class_exists('GridFieldOrderableRows')) {
                $config->addComponent(new GridFieldOrderableRows('Sort'));
            }
            if (class_exists('GridFieldAddExistingSearchButton')) {
                $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                $config->addComponent(new GridFieldAddExistingSearchButton());
            }

            $links = GridField::create('ContentLinks', 'Links', $this->owner->ContentLinks()->sort('Sort'), $config);
            $fields->addFieldToTab('Root.Links', $links);
        }
    }
}