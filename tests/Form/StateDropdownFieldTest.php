<?php

namespace Dynamic\CoreTools\Tests\Form;

use Dynamic\CoreTools\Form\StateDropdownField;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\FieldType\DBHTMLText;

/**
 * Class StateDropdownFieldTest
 * @package Dynamic\CoreTools\Tests
 */
class StateDropdownFieldTest extends SapphireTest
{

    /**
     *
     */
    public function testField()
    {
        $field = StateDropdownField::create('State');
        $this->assertInstanceOf(DBHTMLText::class, $field->Field());
    }

}
