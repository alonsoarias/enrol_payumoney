<?php
require_once("$CFG->libdir/formslib.php");

class discount_edit_form extends moodleform {
    public function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;

        // Discount type selection
        $discountTypes = [
            'percentage' => get_string('percentagediscount', 'enrol_payumoney'),
            'fixed' => get_string('fixeddiscount', 'enrol_payumoney'),
            'limitedtime' => get_string('limitedtimediscount', 'enrol_payumoney'),
        ];
        $mform->addElement('select', 'discounttype', get_string('discounttype', 'enrol_payumoney'), $discountTypes);
        $mform->setType('discounttype', PARAM_ALPHANUM);
        $mform->setDefault('discounttype', 'percentage'); // Default to 'percentage'
        $mform->addHelpButton('discounttype', 'discounttype', 'enrol_payumoney');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'name', get_string('discountname', 'enrol_payumoney'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addHelpButton('name', 'discountname', 'enrol_payumoney');

        $mform->addElement('editor', 'description', get_string('description', 'enrol_payumoney'));
        $mform->setType('description', PARAM_RAW);
        $mform->addHelpButton('description', 'description', 'enrol_payumoney');

        $mform->addElement('text', 'discountvalue', get_string('discountvalue', 'enrol_payumoney'));
        $mform->setType('discountvalue', PARAM_FLOAT);
        $mform->addRule('discountvalue', get_string('required'), 'required', null, 'client');
        $mform->addHelpButton('discountvalue', 'discountvalue', 'enrol_payumoney');

        // Discount Duration - Make optional and hide for 'limitedtime'
        $mform->addElement('duration', 'discountduration', get_string('discountduration', 'enrol_payumoney'), ['optional' => true, 'defaultunit' => 86400]);
        $mform->hideIf('discountduration', 'discounttype', 'eq', 'limitedtime');
        $mform->addHelpButton('discountduration', 'discountduration', 'enrol_payumoney');

        // Valid From / To - Make required for 'limitedtime'
        $mform->addElement('date_selector', 'validfrom', get_string('validfrom', 'enrol_payumoney'), ['optional' => true]);
        $mform->addHelpButton('validfrom', 'validfrom', 'enrol_payumoney');
        $mform->addElement('date_selector', 'validto', get_string('validto', 'enrol_payumoney'), ['optional' => true]);
        $mform->addHelpButton('validto', 'validto', 'enrol_payumoney');
        $mform->hideIf('validfrom', 'discounttype', 'neq', 'limitedtime');
        $mform->hideIf('validto', 'discounttype', 'neq', 'limitedtime');
        $mform->addRule('validfrom', get_string('required'), 'required', null, 'client');
        $mform->addRule('validto', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'discountcode', get_string('discountcode', 'enrol_payumoney'));
        $mform->setType('discountcode', PARAM_ALPHANUMEXT);
        $mform->addRule('discountcode', get_string('required'), 'required', null, 'client');
        $mform->hideIf('discountcode', 'discounttype', 'neq', 'limitedtime');
        $mform->addHelpButton('discountcode', 'discountcode', 'enrol_payumoney');

        $mform->addElement('button', 'generatecode', get_string('generatecode', 'enrol_payumoney'), ['onclick' => 'generateDiscountCode()']);
        $mform->hideIf('generatecode', 'discounttype', 'neq', 'limitedtime');

        $PAGE->requires->js_init_call($this->generateDiscountCodeJs());

        $this->add_action_buttons(true, get_string('savechanges'));
    }

    function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        if ($data['discounttype'] === '0') {
            $errors['discounttype'] = get_string('errordiscounttype', 'enrol_payumoney');
        }

        return $errors;
    }

    private function generateDiscountCodeJs()
    {
        $jsCode = <<<EOD
        require(['jquery'], function($) {
            window.generateDiscountCode = function() {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < 15; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                $('#id_discountcode').val(result);
            };
        });
    EOD;
        return $jsCode;
    }
}
