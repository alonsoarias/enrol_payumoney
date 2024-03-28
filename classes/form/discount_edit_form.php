<?php
require_once("$CFG->libdir/formslib.php");

class discount_edit_form extends moodleform {
    // Añade elementos al formulario.
    public function definition() {
        $mform = $this->_form; // No elimines esto.

        // Aquí, "$this->_customdata" puede contener cualquier dato que necesites pasar al formulario.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'name', get_string('discountname', 'enrol_payumoney'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('textarea', 'description', get_string('description'), 'wrap="virtual" rows="10" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        $mform->addElement('text', 'discount', get_string('discountvalue', 'enrol_payumoney'));
        $mform->setType('discount', PARAM_FLOAT);
        $mform->addRule('discount', null, 'required', null, 'client');

        $this->add_action_buttons();
    }

    // Valida los datos del formulario.
    function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Aquí puedes incluir validaciones adicionales si es necesario.

        return $errors;
    }
}
