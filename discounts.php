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

// Establece la URL de la página (importante para $PAGE).
$PAGE->set_url('/enrol/payumoney/discounts.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('managediscounts', 'enrol_payumoney'));

// Comienza la salida a la página.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('managediscounts', 'enrol_payumoney'));

// Obtener los cursos con el método de matriculación enrol_payumoney.
$courses = get_courses_with_enrol_method('payumoney');

// Comprobar si hay cursos disponibles.
if (!empty($courses)) {
    // Crear la tabla para mostrar los cursos.
    $table = new html_table();
    $table->head = array(
        get_string('courseid'),
        get_string('fullnamecourse'),
        get_string('managediscounts', 'enrol_payumoney')
    );

    // Iterar sobre cada curso para mostrarlo en la tabla.
    foreach ($courses as $course) {
        $row = new html_table_row();
        $row->cells[] = new html_table_cell($course->id);
        $row->cells[] = new html_table_cell(html_writer::link(
            new moodle_url('/course/view.php', array('id' => $course->id)),
            $course->fullname
        ));

        // Obtener los descuentos asignados al curso.
        $discounts = $DB->get_records('enrol_payumoney_discounts', ['courseid' => $course->id]);

        // Crear un enlace para gestionar los descuentos del curso.
        $manage_url = new moodle_url('/enrol/payumoney/discounts_manage.php', array('id' => $course->id));
        $manage_button = new single_button($manage_url, get_string('managediscounts', 'enrol_payumoney'));

        // Crear un botón de edición para cada descuento asignado al curso.
        $edit_buttons = '';
        foreach ($discounts as $discount) {
            $edit_url = new moodle_url('/enrol/payumoney/discounts_manage.php', array('id' => $course->id, 'discountid' => $discount->id));
            $edit_button = new single_button($edit_url, get_string('edit'));
            $edit_buttons .= $OUTPUT->render($edit_button);
        }

        // Si hay descuentos asignados al curso, mostrar el botón de gestión y los botones de edición.
        if (!empty($discounts)) {
            $row->cells[] = new html_table_cell($OUTPUT->render($manage_button) . $edit_buttons);
        } else {
            // Si no hay descuentos asignados al curso, mostrar solo el botón de gestión.
            $row->cells[] = new html_table_cell($OUTPUT->render($manage_button));
        }

        $table->data[] = $row;
    }

    // Imprimir la tabla.
    echo html_writer::table($table);
} else {
    echo get_string('nocourseswithenrol', 'enrol_payumoney');
}

echo $OUTPUT->footer();
?>
