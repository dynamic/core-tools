<?php

namespace Dynamic\CoreTools\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\SS_List;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\ArrayData;

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
    public function sendFormEmail(
      DataObject $submission,
      $template,
      SS_List $recipients,
      $subject = 'New Form Submission'
    ) {
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
