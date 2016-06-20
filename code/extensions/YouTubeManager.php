<?php

class YouTubeManager extends DataExtension
{
    /**
     * @return Datalist
     */
    public function getVideoList()
    {
        return $this->owner->Videos()->sort('SortOrder');
    }

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        // add Spiff grid field if record exists
        if ($this->owner->exists()) {
            $config = GridFieldConfig_RelationEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldSortableRows('SortOrder'));
            }
            if (class_exists('GridFieldAddExistingSearchButton')) {
                $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                $config->addComponent(new GridFieldAddExistingSearchButton());
            }
            $videos = $this->owner->Videos()->sort('SortOrder');
            $videoField = GridField::create('Videos', 'YouTube Videos', $videos, $config);

            $fields->addFieldsToTab('Root.Videos', array(
                $videoField,
            ));
        }
    }

    // include video js on controller
    /**
     * @param $controller
     */
    public function contentcontrollerInit($controller)
    {
        Requirements::javascript(CORE_TOOLS_PATH.'/javascript/videos/VideoPlaylist.js');
    }
}
