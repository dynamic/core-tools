<?php

namespace Dynamic\CoreTools\Tests\Forms;

use Dynamic\CoreTools\Tests\CoreToolsTest,
    Dynamic\CoreTools\Forms\StateDropdownField;

/**
 * Class StateDropdownFieldTest
 * @package Dynamic\CoreTools\Tests
 */
class StateDropdownFieldTest extends CoreToolsTest
{

    /**
     *
     */
    public function testField()
    {
        $field = StateDropdownField::create('State');
        $this->assertInstanceOf('SilverStripe\ORM\FieldType\DBHTMLText', $field->Field());
    }

}