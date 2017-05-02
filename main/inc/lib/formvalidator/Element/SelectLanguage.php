<?php
/* For licensing terms, see /license.txt */

/**
 * Class SelectLanguage
 * A dropdownlist with all languages to use with QuickForm
 */
class SelectLanguage extends HTML_QuickForm_select
{
    /**
     * Class constructor
     */
    public function __construct(
        $elementName = null,
        $elementLabel = null,
        $options = [],
        $attributes = []
    ) {
		parent::__construct($elementName, $elementLabel, $options, $attributes);
		// Get all languages
		$languages = api_get_languages();
		$this->_options = array();
		$this->_values = array();
		foreach ($languages as $iso => $name) {
			if ($iso == api_get_setting('language.platform_language')) {
				$this->addOption($name, $iso, array('selected'=>'selected'));
			} else {
				$this->addOption($name, $iso);
			}
		}
	}
}
