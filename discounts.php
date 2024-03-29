<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/enrol/payumoney/locallib.php');
require_once($CFG->dirroot.'/enrol/payumoney/classes/form/discount_form.php');
require_once($CFG->libdir.'/adminlib.php');

global $DB, $OUTPUT, $PAGE;

// Verifica si el usuario ha iniciado sesión y tiene la capacidad necesaria.
require_login();
$context = context_system::instance();
require_capability('enrol/payumoney:managediscounts', $context);

// Inicializar la página de configuración.
admin_externalpage_setup('enrol_payumoney_discounts');

// Parámetros (por ejemplo, para editar o eliminar).
$id = optional_param('id', 0, PARAM_INT); // ID del descuento para editar.
$action = optional_param('action', '', PARAM_ALPHA);

// Establece la URL de la página (importante para $PAGE).
$PAGE->set_url('/enrol/payumoney/discounts.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('managediscounts', 'enrol_payumoney'));

// Comienza la salida a la página.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('managediscounts', 'enrol_payumoney'));

// Lógica para las acciones (añadir, editar, eliminar).
switch ($action) {
    case 'add':
    case 'edit':
        // Comparten lógica similar. 'edit' necesitará cargar datos existentes.
        $mform = new discount_form();
        
        if ($mform->is_cancelled()) {
            redirect(new moodle_url('/enrol/payumoney/discounts.php'));
        } else if ($data = $mform->get_data()) {
            // Insertar o actualizar el registro del descuento en la base de datos.
            if ($action == 'add') {
                // Insertar lógica aquí.
            } else if ($action == 'edit' && !empty($id)) {
                // Actualizar lógica aquí.
            }
            redirect(new moodle_url('/enrol/payumoney/discounts.php'), get_string('discountsaved', 'enrol_payumoney'));
        } else {
            if ($action == 'edit' && !empty($id)) {
                // Cargar los datos del descuento para editar y establecer datos predeterminados en el formulario.
            }
            $mform->display();
        }
        break;

    case 'delete':
        if (!empty($id) && confirm_sesskey()) {
            // Asegúrate de pedir confirmación.
            // Eliminar lógica aquí.
            redirect(new moodle_url('/enrol/payumoney/discounts.php'), get_string('discountdeleted', 'enrol_payumoney'));
        }
        break;

    default:
        // Mostrar lista de descuentos y opciones para editar o eliminar.
        $discounts = $DB->get_records('enrol_payumoney_discounts');
        if ($discounts) {
            foreach ($discounts as $discount) {
                // Crear enlaces para 'editar' y 'eliminar'.
                // Mostrar descuentos aquí.
            }
        } else {
            echo get_string('nodiscountsfound', 'enrol_payumoney');
        }
        echo $OUTPUT->single_button(new moodle_url('/enrol/payumoney/discounts.php', ['action' => 'add']), get_string('adddiscount', 'enrol_payumoney'), 'get');
        break;
}

echo $OUTPUT->footer();
