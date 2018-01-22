<?php

/**
 * Class CoreFormFieldExtension
 */
class CoreFormFieldExtension extends DataExtension
{

    /**
     * @var array
     */
    private static $db = array(
        'FieldWidth' => "Enum('full,half', 'full')",
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.FormOptions',
            DropdownField::create(
                'FieldWidth',
                'Width of Fields',
                $this->owner->dbObject('FieldWidth')->enumValues()
            )
        );
    }
}
