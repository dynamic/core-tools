<?php

/**
 * Class CoreFormFieldExtensionTest_Object
 */
class CoreFormFieldExtensionTest_Object extends DataObject implements TestOnly
{

    /**
     * @var array
     */
    private static $extensions = array(
        CoreFormFieldExtension::class,
    );
}
