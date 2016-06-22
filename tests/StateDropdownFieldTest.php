<?php

class StateDropdownFieldTest extends CoreToolsTest
{
    public function testField()
    {
        $field = StateDropdownField::create('State');
        $this->assertInstanceOf('HTMLText', $field->Field());
    }
}
