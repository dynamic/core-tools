<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Permission;

/**
 * Class Promo.
 */
class Promo extends ContentObject implements PermissionProvider
{
    /**
     * @var string
     */
    private static $singular_name = 'Promo';

    /**
     * @var string
     */
    private static $plural_name = 'Promos';

    /**
     * @var string
     */
    private static $table_name = 'Promo';

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // override folder name
        $fields->dataFieldByName('Image')->setFolderName('Uploads/Promos');

        return $fields;
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
          'Promo_EDIT' => 'Promo Edit',
          'Promo_DELETE' => 'Promo Delete',
          'Promo_CREATE' => 'Promo Create',
        );
    }

    /**
     * @param null  $member
     * @param array $context
     *
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('Promo_CREATE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('Promo_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('Promo_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }
}
