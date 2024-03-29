<?php
require_once("$CFG->libdir/formslib.php");

class discount_edit_form extends moodleform {
    // Add elements to the form.
    public function definition() {
        global $PAGE;

        $mform = $this->_form; // Don't delete this.

        // Add a select field for discount type.
        $mform->addElement('select', 'discounttype', get_string('discounttype', 'enrol_payumoney'), array(
            'select' => get_string('selectdiscounttype', 'enrol_payumoney'),
            'percentage' => get_string('percentagediscount', 'enrol_payumoney'),
            'fixed' => get_string('fixeddiscount', 'enrol_payumoney'),
            'limitedtime' => get_string('limitedtimediscount', 'enrol_payumoney')
        ));

        // Add hidden field for discount ID.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        // Add fields for discount name and description.
        $mform->addElement('text', 'name', get_string('discountname', 'enrol_payumoney'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('textarea', 'description', get_string('description'), 'wrap="virtual" rows="10" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        // Add field for discount value.
        $mform->addElement('text', 'discount', get_string('discountvalue', 'enrol_payumoney'));
        $mform->setType('discount', PARAM_FLOAT);
        $mform->addRule('discount', null, 'required', null, 'client');

        // Add fields for start and end dates (optional).
        $mform->addElement('date_time_selector', 'start_date', get_string('start_date', 'enrol_payumoney'), array('optional' => true));
        $mform->setDefault('start_date', 0);
        $mform->addHelpButton('start_date', 'start_date', 'enrol_payumoney');

        $mform->addElement('date_time_selector', 'end_date', get_string('end_date', 'enrol_payumoney'), array('optional' => true));
        $mform->setDefault('end_date', 0);
        $mform->addHelpButton('end_date', 'end_date', 'enrol_payumoney');

        // Add checkbox to enable/disable optional dates.
        $mform->addElement('checkbox', 'enable_dates', get_string('enable_dates', 'enrol_payumoney'));
        $mform->setDefault('enable_dates', true);

        // Add JavaScript to show/hide fields based on selected discount type.
        $PAGE->requires->js('/enrol/payumoney/js/discount_edit_form.js');

        // Add action buttons.
        $this->add_action_buttons();
    }

    // Validate form data.
    function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Additional validations can be included here if needed.

        return $errors;
    }
}
?>
