<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

/**
 * Class PromoManager.
 */
class PromoManager extends DataExtension
{
    public function getPromoList()
    {
        return $this->owner->Promos()->sort('SortOrder');
    }

    public function updateCMSFields(FieldList $fields)
    {
        // add Spiff grid field if record exists
        if ($this->owner->exists()) {
            $config = GridFieldConfig_RelationEditor::create()
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
                ->removeComponentsByType('GridFieldAddExistingAutocompleter')
                ->addComponent(new GridFieldAddExistingSearchButton());
            $promos = $this->owner->Promos()->sort('SortOrder');
            $promoField = GridField::create(
                'Promos',
                'Promos',
                $promos,
                $config
            );

            $fields->addFieldsToTab('Root.Promos', array(
                $promoField,
            ));
        }
    }
}
