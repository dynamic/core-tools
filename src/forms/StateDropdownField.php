<?php

namespace Dynamic\CoreTools\Forms;

use SilverStripe\Forms\DropdownField;

/**
 * Class StateDropdownField
 * @package Dynamic\CoreTools\Forms
 */
class StateDropdownField extends DropdownField
{

    public static $stateSource = array(
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
        '-' => '-----',
        'AB' => 'Alberta',
        'BC' => 'British Columbia',
        'MB' => 'Manitoba',
        'NB' => 'New Brunswick',
        'NL' => 'Newfoundland and Labrador',
        'NS' => 'Nova Scotia',
        'ON' => 'Ontario',
        'PE' => 'Prince Edward Island',
        'QC' => 'Quebec',
        'SK' => 'Saskatchewan',
    );

    protected $extraClasses = array('dropdown');

    /**
     * StateDropdownField constructor.
     * @param string $name
     * @param null $title
     * @param null $source
     * @param string $value
     */
    public function __construct($name, $title = null, $source = null, $value = '')
    {
        if (!is_array($source)) {
            // Get a list of countries from Zend
            $source = self::$stateSource;
        }

        parent::__construct($name, ($title === null) ? $name : $title, $source, $value);
    }

    /**
     * @param array $properties
     * @return string
     */
    public function Field($properties = array())
    {
        $source = $this->getSource();

        if (!$this->value || !isset($source[$this->value])) {
            $this->value = $this->config()->default_state;
        }

        return parent::Field();
    }

}