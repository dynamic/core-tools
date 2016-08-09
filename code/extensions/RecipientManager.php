<?php

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
        'Recipients' => 'EmailRecipient'
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

class RecipientMangagerExtension extends Extension
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
