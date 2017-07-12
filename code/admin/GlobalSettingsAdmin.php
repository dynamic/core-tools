<?php

/**
 * Class GlobalSettingsAdmin
 */
class GlobalSettingsAdmin extends LeftAndMain
{

    /**
     * @var string
     */
    private static $url_segment = 'global-site-configuration';

    /**
     * @var string
     */
    private static $url_rule = '/$Action/$ID/$OtherID';

    /**
     * @var int
     */
    private static $menu_priority = -1;

    /**
     * @var string
     */
    private static $menu_title = 'Global Config';

    /**
     * @var array
     */
    private static $required_permission_codes = ['EDIT_GLOBAL_PERMISSION'];

    /**
     * @param null $id
     * @param null $fields
     * @return $this|CMSForm
     */
    public function getEditForm($id = null, $fields = null)
    {
        $config = GlobalSiteSetting::current_global_config();
        $fields = $config->getCMSFields();
        // Tell the CMS what URL the preview should show
        $home = Director::absoluteBaseURL();
        $fields->push(new HiddenField('PreviewURL', 'Preview URL', $home));
        // Added in-line to the form, but plucked into different view by LeftAndMain.Preview.js upon load
        $fields->push($navField = new LiteralField('SilverStripeNavigator',
            $this->getSilverStripeNavigator()));
        $navField->setAllowHTML(true);
        // Retrieve validator, if one has been setup (e.g. via data extensions).
        if ($config->hasMethod("getCMSValidator")) {
            $validator = $config->getCMSValidator();
        } else {
            $validator = null;
        }
        $actions = $config->getCMSActions();
        $form = CMSForm::create(
            $this, 'EditForm', $fields, $actions, $validator
        )->setHTMLID('Form_EditForm');
        $form->setResponseNegotiator($this->getResponseNegotiator());
        $form->addExtraClass('cms-content center cms-edit-form');
        $form->setAttribute('data-pjax-fragment', 'CurrentForm');
        if ($form->Fields()->hasTabSet()) {
            $form->Fields()->findOrMakeTab('Root')->setTemplate('CMSTabSet');
        }
        $form->setHTMLID('Form_EditForm');
        $form->loadDataFrom($config);
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));
        // Use <button> to allow full jQuery UI styling
        $actions = $actions->dataFields();
        if ($actions) {
            foreach ($actions as $action) {
                $action->setUseButtonTag(true);
            }
        }
        $this->extend('updateEditForm', $form);
        return $form;
    }

    /**
     * Used for preview controls, mainly links which switch between different states of the page.
     *
     * @return ArrayData|HTMLText
     */
    public function getSilverStripeNavigator()
    {
        return $this->renderWith('CMSSettingsController_SilverStripeNavigator');
    }

    /**
     * Save the current sites {@link GlobalSiteSetting} into the database.
     *
     * @param array $data
     * @param Form $form
     * @return String
     */
    public function save_globalconfig($data, $form)
    {
        $config = GlobalSiteSetting::current_global_config();
        $form->saveInto($config);
        try {
            $config->write();
        } catch (ValidationException $ex) {
            $form->sessionMessage($ex->getResult()->message(), 'bad');
            return $this->getResponseNegotiator()->respond($this->request);
        }
        $this->response->addHeader('X-Status',
            rawurlencode(_t('LeftAndMain.SAVEDUP', 'Saved.')));
        return $form->forTemplate();
    }

    /**
     * @param bool $unlinked
     * @return ArrayList
     */
    public function Breadcrumbs($unlinked = false)
    {
        $defaultTitle = self::menu_title_for_class(get_class($this));
        return new ArrayList(array(
            new ArrayData(array(
                'Title' => _t("{$this->class}.MENUTITLE", $defaultTitle),
                'Link' => $this->Link()
            ))
        ));
    }

}