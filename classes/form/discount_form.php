<?php
require_once("$CFG->libdir/formslib.php");

class discount_form extends moodleform {
    //Add elements to form
    public function definition() {
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'discount_percent', get_string('discountpercent', 'enrol_payumoney')); // Add elements
        $mform->setType('discount_percent', PARAM_INT); //Set type of element
        $mform->addRule('discount_percent', null, 'required', null, 'client');

        $mform->addElement('date_selector', 'valid_from', get_string('validfrom', 'enrol_payumoney'));
        $mform->addElement('date_selector', 'valid_to', get_string('validto', 'enrol_payumoney'));

        $this->add_action_buttons();
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
