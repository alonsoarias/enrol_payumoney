<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/enrol/payumoney/locallib.php');
require_once($CFG->dirroot.'/enrol/payumoney/classes/form/discount_edit_form.php');

global $DB, $OUTPUT, $PAGE;

// Verifica si el usuario ha iniciado sesión y tiene la capacidad necesaria.
require_login();
$context = context_system::instance();
require_capability('enrol/payumoney:managediscounts', $context);

$id = required_param('id', PARAM_INT); // ID del descuento.
$action = optional_param('action', 'edit', PARAM_ALPHA);

// Asegúrate de que el descuento existe.
if (!$discount = $DB->get_record('enrol_payumoney_discounts', ['id' => $id])) {
    print_error('discountnotfound', 'enrol_payumoney');
}

// Establece la URL de la página (importante para $PAGE).
$PAGE->set_url('/enrol/payumoney/discounts_manage.php', ['id' => $id, 'action' => $action]);
$PAGE->set_context($context);
$PAGE->set_title(get_string('editdiscount', 'enrol_payumoney'));
$PAGE->set_heading(get_string('editdiscount', 'enrol_payumoney'));

// Comienza la salida a la página.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('editdiscount', 'enrol_payumoney'));

if ($action === 'edit') {
    $mform = new discount_edit_form(null, ['id' => $id]);

    if ($mform->is_cancelled()) {
        // Manejar la acción de cancelación del formulario.
        redirect(new moodle_url('/enrol/payumoney/discounts.php'));
    } else if ($data = $mform->get_data()) {
        // Procesar los datos del formulario y actualizar el descuento.
        // Aquí deberías incluir la lógica para actualizar los datos en la base de datos.

        // Redireccionar al usuario a la página principal de descuentos después de editar.
        redirect(new moodle_url('/enrol/payumoney/discounts.php'), get_string('discountupdated', 'enrol_payumoney'));
    } else {
        // Establece los datos predeterminados del formulario.
        $mform->set_data($discount);
        $mform->display();
    }
} elseif ($action === 'delete') {
    // Confirmar la eliminación.
    $deleteurl = new moodle_url('/enrol/payumoney/discounts_manage.php', ['id' => $id, 'action' => 'delete', 'confirm' => 1]);
    $cancelurl = new moodle_url('/enrol/payumoney/discounts.php');

    if (optional_param('confirm', 0, PARAM_BOOL)) {
        // Aquí deberías incluir la lógica para eliminar el descuento de la base de datos.
        
        redirect(new moodle_url('/enrol/payumoney/discounts.php'), get_string('discountdeleted', 'enrol_payumoney'));
    } else {
        // Muestra la confirmación de eliminación.
        echo $OUTPUT->confirm(get_string('confirmdiscountdelete', 'enrol_payumoney', $discount->name), $deleteurl, $cancelurl);
    }
}

echo $OUTPUT->footer();
