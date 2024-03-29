<?php
require_once("$CFG->libdir/formslib.php");

class discount_edit_form extends moodleform {
    public function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;

        // Discount type selection
        $discountTypes = [
            '0' => get_string('selectdiscounttype', 'enrol_payumoney'),
            'percentage' => get_string('percentagediscount', 'enrol_payumoney'),
            'fixed' => get_string('fixeddiscount', 'enrol_payumoney'),
            'limitedtime' => get_string('limitedtimediscount', 'enrol_payumoney'),
        ];
        $mform->addElement('select', 'discounttype', get_string('discounttype', 'enrol_payumoney'), $discountTypes);
        $mform->setType('discounttype', PARAM_ALPHANUM);
        $mform->addRule('discounttype', null, 'required', null, 'client');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'name', get_string('discountname', 'enrol_payumoney'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('textarea', 'description', get_string('description', 'enrol_payumoney'), ['wrap' => "virtual", 'rows' => 10, 'cols' => 50]);
        $mform->setType('description', PARAM_CLEANHTML);

        $mform->addElement('text', 'discountvalue', get_string('discountvalue', 'enrol_payumoney'));
        $mform->setType('discountvalue', PARAM_FLOAT);

        // Correctly add the duration field only once
        $mform->addElement(
            'duration',
            'discountduration',
            get_string('discountduration', 'enrol_payumoney'),
            ['optional' => true, 'defaultunit' => 86400]
        );

        $mform->addElement('date_selector', 'validfrom', get_string('validfrom', 'enrol_payumoney'), ['optional' => true]);
        $mform->addElement('date_selector', 'validto', get_string('validto', 'enrol_payumoney'), ['optional' => true]);

        $mform->addElement('text', 'discountcode', get_string('discountcode', 'enrol_payumoney'));
        $mform->setType('discountcode', PARAM_ALPHANUMEXT);
        $mform->hideIf('discountcode', 'discounttype', 'noteq', 'limitedtime');

        $PAGE->requires->js_call_amd('enrol_payumoney/discountform', 'init');

        $this->add_action_buttons(true, get_string('savechanges'));
    }

    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        
        if ($data['discounttype'] === '0') {
            $errors['discounttype'] = get_string('errordiscounttype', 'enrol_payumoney');
        }

        return $errors;
    }
}
