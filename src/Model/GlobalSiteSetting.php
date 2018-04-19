<?php

namespace Dynamic\CoreTools\Model;

use Dynamic\CoreTools\Admin\GlobalSettingsAdmin;
use Dynamic\SilverStripeGeocoder\AddressDataExtension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\TemplateGlobalProvider;
use SilverStripe\Security\Security;

/**
 * Class GlobalSiteSetting
 * @package Dynamic\CoreTools\Model
 *
 * @property string Title
 * @property string Tagline
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
     * Default permission to check for 'LoggedInUsers' to create or edit pages.
     *
     * @var array
     * @config
     */
    private static $required_permission = array('CMS_ACCESS_CMSMain', 'CMS_ACCESS_LeftAndMain');

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        Config::modify()->set(AddressDataExtension::class, 'address_tab_name', 'Company.Address');

        $fields = FieldList::create(
            TabSet::create(
                'Root',
                $tabMain = Tab::create(
                    'Main'
                )
            ),
            HiddenField::create('ID')
        );
        $tabMain->setTitle('Settings');

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * Get the actions that are sent to the CMS. In
     * your extensions: updateEditFormActions($actions).
     *
     * @return FieldList
     */
    public function getCMSActions()
    {
        if (Permission::check('ADMIN') || Permission::check('EDIT_GLOBAL_PERMISSION')) {
            $actions = new FieldList(
                FormAction::create('save_globalconfig', _t('CoreToolsConfig.SAVE', 'Save'))
                    ->addExtraClass('btn-primary font-icon-save')
            );
        } else {
            $actions = FieldList::create();
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
        $config = self::current_global_config();
        if (!$config) {
            self::make_global_config();
            DB::alteration_message('Added default global config', 'created');
        }
    }

    /**
     * @return string
     */
    public function CMSEditLink()
    {
        return GlobalSettingsAdmin::singleton()->Link();
    }

    /**
     * @param null $member
     *
     * @return bool|int|null
     */
    public function canEdit($member = null)
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }

        $extended = $this->extendedCan('canEdit', $member);
        if ($extended !== null) {
            return $extended;
        }

        return Permission::checkMember($member, 'EDIT_GLOBAL_PERMISSION');
    }

    /**
     * To duplicate into the site config (so stuff that relies on site config still works)
     */
    public function onBeforeWrite()
    {
        /** @var SiteConfig $siteconfig */
        $siteconfig = SiteConfig::current_site_config();
        $siteconfig->Title = $this->Title;
        $siteconfig->Tagline = $this->Tagline;
        $siteconfig->write();

        parent::onBeforeWrite();
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
            'EDIT_GLOBAL_PERMISSION' => array(
                'name' => _t(
                    'CoreToolsConfig.EDIT_GLOBAL_PERMISSION',
                    'Manage Global Site configuration'
                ),
                'category' => _t(
                    'Permissions.PERMISSIONS_GLOBAL_PERMISSION',
                    'Roles and access permissions'
                ),
                'help' => _t(
                    'CoreToolsConfig.EDIT_PERMISSION_GLOBAL_PERMISSION',
                    'Ability to edit global access settings/top-level page permissions.'
                ),
                'sort' => 400,
            ),
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
        if ($config = self::get()->first()) {
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
        $config = self::create();
        $config->write();

        return $config;
    }

    /**
     * Add $GlobalConfig to all SSViewers.
     */
    public static function get_template_global_variables()
    {
        return array(
            'GlobalConfig' => 'current_global_config',
        );
    }
}
