<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Permission;
use Page;

class PageSection extends ContentObject implements PermissionProvider
{
    /**
     * @var string
     */
    private static $singular_name = 'Page Section';

    /**
     * @var string
     */
    private static $plural_name = 'Page Sections';

    /**
     * @var array
     */
    private static $db = array(
      'SortOrder' => 'Int',
    );

    /**
     * @var array
     */
    private static $has_one = array(
      'Page' => Page::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'PageSection';

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
          'PageID',
          'SortOrder',
        ));

        // override folder name
        $fields->dataFieldByName('Image')
          ->setFolderName('Uploads/PageSections');

        return $fields;
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
          'PageSection_EDIT' => 'Page Section Edit',
          'PageSection_DELETE' => 'Page Section Delete',
          'PageSection_CREATE' => 'Page Section Create',
          'PageSection_VIEW' => 'Page Section View',
        );
    }

    /**
     * @param \SilverStripe\Security\Member $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return Permission::check('PageSection_VIEW', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('PageSection_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('PageSection_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     *
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('PageSection_CREATE', 'any', $member);
    }
}
