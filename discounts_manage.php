<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/enrol/payumoney/locallib.php');
require_once($CFG->dirroot.'/enrol/payumoney/classes/form/discount_edit_form.php');

global $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();
require_capability('enrol/payumoney:managediscounts', $context);

$id = required_param('id', PARAM_INT); // ID del curso.
$discountid = optional_param('discountid', 0, PARAM_INT); // ID del descuento.

// Verifica si el curso existe.
if (!$course = $DB->get_record('course', ['id' => $id])) {
    throw new moodle_exception('coursenotfound', 'enrol_payumoney');
}

// Si se proporciona un ID de descuento, intenta recuperar el descuento de la base de datos.
$discount = null; // Inicializamos la variable $discount
if ($discountid && !$discount = $DB->get_record('enrol_payumoney_discounts', ['id' => $discountid])) {
    throw new moodle_exception('discountnotfound', 'enrol_payumoney');
}

$PAGE->set_url('/enrol/payumoney/discounts_manage.php', ['id' => $id, 'discountid' => $discountid]);
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
    if ($discount) {
        // Si se encontró un descuento, establece los datos del formulario.
        $mform->set_data($discount);
    }
    $mform->display();
}

echo $OUTPUT->footer();
?>
