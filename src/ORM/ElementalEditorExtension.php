<?php
namespace Dynamic\CoreTools\ORM;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Versioned\Versioned;

/**
 * Class ElementalEditorExtension
 * @package Dynamic\CoreTools\ORM
 */
class ElementalEditorExtension extends Extension
{
    /**
     * @param GridField $field
     */
    public function updateField(GridField $field)
    {
        $field->getConfig()->removeComponentsByType(GridFieldDeleteAction::class);
    }
}
