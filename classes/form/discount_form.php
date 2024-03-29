<?php
require_once("$CFG->libdir/formslib.php");

class discount_form extends moodleform {
    //Add elements to form
    public function definition() {
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'discountcode', get_string('discountcode', 'enrol_payumoney')); // Add elements
        $mform->setType('discountcode', PARAM_NOTAGS); //Set type of element
        $mform->addRule('discountcode', null, 'required', null, 'client');

        $mform->addElement('date_selector', 'validfrom', get_string('validfrom', 'enrol_payumoney'));
        $mform->addElement('date_selector', 'validto', get_string('validto', 'enrol_payumoney'));

        $mform->addElement('text', 'discountpercent', get_string('discountpercent', 'enrol_payumoney'));
        $mform->setType('discountpercent', PARAM_FLOAT);
        $mform->addRule('discountpercent', null, 'numeric', null, 'client');

        $this->add_action_buttons();
    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
