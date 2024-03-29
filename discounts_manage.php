<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/enrol/payumoney/locallib.php');
require_once($CFG->dirroot.'/enrol/payumoney/classes/form/discount_edit_form.php');

global $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();
require_capability('enrol/payumoney:managediscounts', $context);

$id = required_param('id', PARAM_INT); // ID del descuento.
$action = optional_param('action', 'edit', PARAM_ALPHA);

// Verifica si el descuento existe.
if (!$discount = $DB->get_record('enrol_payumoney_discounts', ['id' => $id])) {
    print_error('discountnotfound', 'enrol_payumoney');
}

$PAGE->set_url('/enrol/payumoney/discounts_manage.php', ['id' => $id, 'action' => $action]);
$PAGE->set_context($context);
$PAGE->set_title(get_string('editdiscount', 'enrol_payumoney'));
$PAGE->set_heading(get_string('editdiscount', 'enrol_payumoney'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('editdiscount', 'enrol_payumoney'));

$mform = new discount_edit_form(null, ['id' => $id]);

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/enrol/payumoney/discounts.php'));
} elseif ($data = $mform->get_data()) {
    // Aquí la lógica para actualizar los datos en la base de datos.
    // Por ejemplo: $DB->update_record('enrol_payumoney_discounts', $data);
    redirect(new moodle_url('/enrol/payumoney/discounts.php'), get_string('discountupdated', 'enrol_payumoney'));
} else {
    $mform->set_data($discount);
    $mform->display();
}

echo $OUTPUT->footer();
