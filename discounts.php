<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/enrol/payumoney/locallib.php');
require_once($CFG->dirroot.'/enrol/payumoney/classes/form/discount_form.php');

global $DB, $OUTPUT, $PAGE;

// Verifica si el usuario ha iniciado sesión y tiene la capacidad necesaria.
require_login();
$context = context_system::instance();
require_capability('enrol/payumoney:managediscounts', $context);

// Parámetros (por ejemplo, para editar o eliminar).
$id = optional_param('id', 0, PARAM_INT); // ID del descuento para editar.
$action = optional_param('action', '', PARAM_ALPHA);

// Establece la URL de la página (importante para $PAGE).
$PAGE->set_url('/enrol/payumoney/discounts.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('managediscounts', 'enrol_payumoney'));
$PAGE->set_heading(get_string('managediscounts', 'enrol_payumoney'));

// Comienza la salida a la página.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('managediscounts', 'enrol_payumoney'));

switch ($action) {
    case 'add':
        // Lógica para mostrar y procesar el formulario de agregar nuevo descuento.
        $mform = new discount_form();

        if ($mform->is_cancelled()) {
            // Manejar la acción de cancelación del formulario.
            redirect(new moodle_url('/enrol/payumoney/discounts.php'));
        } else if ($data = $mform->get_data()) {
            // Procesar los datos del formulario y guardar el nuevo descuento.
            // Aquí deberías incluir la lógica para insertar los datos en la base de datos.

            // Redireccionar al usuario a la página principal de descuentos después de agregar.
            redirect(new moodle_url('/enrol/payumoney/discounts.php'), get_string('discountadded', 'enrol_payumoney'));
        } else {
            // Muestra el formulario vacío para agregar un nuevo descuento.
            $mform->display();
        }
        break;

    case 'edit':
        // Lógica similar a 'add', pero cargando los datos existentes en el formulario.
        break;

    case 'delete':
        // Lógica para eliminar un descuento. Asegúrate de solicitar confirmación.

        // Redireccionar de vuelta a la lista de descuentos después de eliminar.
        break;

    default:
        // Muestra la lista de descuentos existentes y opciones para añadir/editar/eliminar.
        // Aquí deberías obtener los descuentos de la base de datos y mostrarlos.

        echo $OUTPUT->single_button(new moodle_url('/enrol/payumoney/discounts.php', ['action' => 'add']), get_string('adddiscount', 'enrol_payumoney'), 'get');

        // Mostrar los descuentos existentes aquí.
}

echo $OUTPUT->footer();
