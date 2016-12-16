<?php

namespace Dynamic\CoreTools\Extensions;

use SilverStripe\ORM\DataExtension,
    SilverStripe\Forms\FieldList,
    SilverStripe\Forms\GridField\GridField,
    SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor,
    SilverStripe\Forms\HeaderField,
    SilverStripe\Forms\TextField,
    SilverStripe\Forms\HTMLEditor\HTMLEditorField,
    SilverStripe\Core\Extension,
    SilverStripe\ORM\DataObject,
    SilverStripe\ORM\SS_List,
    SilverStripe\Control\Email\Email,
    SilverStripe\Core\Config\Config,
    SilverStripe\View\ArrayData;

/**
 * Class RecipientManager
 * @package Dynamic\CoreTools\Extensions
 *
 * @property string $EmailSubject
 * @property string $ThankYouMessage
 */
class RecipientManager extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'EmailSubject' => 'Varchar(200)',
        'ThankYouMessage' => 'HTMLText',
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'Recipients' => 'Dynamic\\CoreTools\\Model\\EmailRecipient'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(array('PageID'));

        if ($this->owner->exists()) {
            $config = GridFieldConfig_RecordEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldSortableRows('SortOrder'));
            }
            $columns = $this->owner->Recipients()->sort('SortOrder');
            $tableField = GridField::create(
                'Recipients',
                _t('RecipientManager.Settings', 'Email Recipients'),
                $columns,
                $config
            );
            $tableField->setDescription(
                'Designate people to receive email notifications when someone completes the contact form.'
            );
            $fields->addFieldsToTab('Root.ContactForm', array(
                HeaderField::create('EmailRecipientHD', 'Email Notifications', 3),
                $tableField,
                TextField::create('EmailSubject'),
                HTMLEditorField::create('ThankYouMessage'),
            ));
        }
    }
}

/**
 * Class RecipientManagerExtension
 * @package Dynamic\CoreTools\Extensions
 */
class RecipientManagerExtension extends Extension
{
    /**
     * @param DataObject $submission
     * @param $template
     * @param SS_List $recipients
     * @param string $subject
     */
    public function sendFormEmail(DataObject $submission, $template, SS_List $recipients, $subject = 'New Form Submission')
    {
        $email = new Email();
        $from = Config::inst()->get('Email', 'admin_email');

        if ($recipients->count() > 0) {
            foreach ($recipients as $recipient) {
                $to = $recipient->Email;
                $email
                    ->setFrom($from)
                    ->setTo($to)
                    ->setSubject($subject)
                    ->setTemplate($template)
                    ->populateTemplate(new ArrayData(array(
                        'Submission' => $submission,
                    )));
                $email->send();
            }
        }
    }
}
