<?php

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
     * @var array
     */
    private static $belongs_many_many = array(
        'Pages' => 'Page',
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'Pages',
        ));

        // override folder name
        $fields->dataFieldByName('Image')->setFolderName('Uploads/Promos');

        // pages
        $config = GridFieldConfig_RecordViewer::create();
        $config->removeComponent($config->getComponentByType('GridFieldViewButton'));
        $pages = $this->Pages()->sort('Title');
        $pageField = new GridField('Pages', 'Pages', $pages, $config);

        $fields->addFieldsToTab('Root.Pages', array(
            HeaderField::create('PagesHD', 'Used on the following pages', 3),
            $pageField,
        ));

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
     * @param null $member
     *
     * @return bool|int
     */
    public function canCreate($member = null)
    {
        return Permission::check('Promo_CREATE');
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('Promo_EDIT');
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('Promo_DELETE');
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
