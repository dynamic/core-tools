<?php

class YouTubeVideo extends ContentObject
{
    /**
     * @var string
     */
    private static $singular_name = 'YouTube Video';

    /**
     * @var string
     */
    private static $plural_name = 'YouTube Videos';

    /**
     * @var array
     */
    private static $db = array(
        'Video' => 'Varchar(255)',
    );

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

        $fields->addFieldToTab(
            'Root.Main',
            YoutubeField::create('Video')
                ->setTitle('Video link')
                ->setRightTitle('Paste the link from the address bar in your browser while viewing the video on YouTube'),
            'Content'
        );

        $fields->dataFieldByName('Image')->setFolderName('Uploads/YouTubeImages');

        $fields->removeByName(array(
            'Link',
        ));

        return $fields;
    }

    /**
     * @return ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Video) {
            $result->error('Video link is required');
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getVideoID()
    {
        parse_str(parse_url($this->Video, PHP_URL_QUERY), $videoParts);

        return $videoParts['v'];
    }
}
