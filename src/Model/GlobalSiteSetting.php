<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\View\TemplateGlobalProvider;

/**
 * Class GlobalSiteSetting
 */
class GlobalSiteSetting extends DataObject implements PermissionProvider, TemplateGlobalProvider
{

    /**
     * @var string
     */
    private static $singular_name = 'Global Site Setting';
    /**
     * @var string
     */
    private static $plural_name = 'Global Site Settings';
    /**
     * @var string
     */
    private static $description = 'Global settings (i.e. footer navigation)';

	/**
	 * @var string
	 */
	private static $table_name = 'GlobalSiteSettings';

	/**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = new FieldList(
            new TabSet("Root",
                $tabMain = new Tab(
                    'Main'
                )
            ),
            HiddenField::create('ID')
        );
        $tabMain->setTitle('Global Site Settings');
        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    /**
     * Get the actions that are sent to the CMS. In
     * your extensions: updateEditFormActions($actions)
     *
     * @return FieldList
     */
    public function getCMSActions()
    {
        if (Permission::check('ADMIN') || Permission::check('EDIT_GLOBAL_PERMISSION')) {
            $actions = new FieldList(
                FormAction::create('save_globalconfig', _t('CoreToolsConfig.SAVE', 'Save'))
                    ->addExtraClass('ss-ui-action-constructive')->setAttribute('data-icon', 'accept')
            );
        } else {
            $actions = new FieldList();
        }
        $this->extend('updateCMSActions', $actions);
        return $actions;
    }

    /**
     * @throws ValidationException
     * @throws null
     */
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();
        $config = GlobalSiteSetting::current_global_config();
        if (!$config) {
            self::make_global_config();
            DB::alteration_message("Added default global config", "created");
        }
    }

    /**
     * @return string
     */
    public function CMSEditLink()
    {
        return singleton('CMSSettingsController')->Link();
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
            'EDIT_GLOBAL_PERMISSION' => array(
                'name' => _t('CoreToolsConfig.EDIT_GLOBAL_PERMISSION',
                    'Manage Global Site configuration'),
                'category' => _t('Permissions.PERMISSIONS_GLOBAL_PERMISSION',
                    'Roles and access permissions'),
                'help' => _t('CoreToolsConfig.EDIT_PERMISSION_GLOBAL_PERMISSION',
                    'Ability to edit global access settings/top-level page permissions.'),
                'sort' => 400
            )
        );
    }

    /**
     * Get the current sites {@link GlobalSiteSetting}, and creates a new one
     * through {@link make_global_config()} if none is found.
     *
     * @return GlobalSiteSetting|DataObject
     */
    public static function current_global_config()
    {
        if ($config = GlobalSiteSetting::get()->first()) {
            return $config;
        }
        return self::make_global_config();
    }

    /**
     * Create {@link GlobalSiteSetting} with defaults from language file.
     *
     * @return GlobalSiteSetting
     */
    public static function make_global_config()
    {
        $config = GlobalSiteSetting::create();
        $config->write();
        return $config;
    }

    /**
     * Add $GlobalConfig to all SSViewers
     */
    public static function get_template_global_variables()
    {
        return array(
            'GlobalConfig' => 'current_global_config',
        );
    }

}