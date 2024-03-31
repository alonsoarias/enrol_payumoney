<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/enrol/payumoney/locallib.php');
require_once($CFG->dirroot.'/enrol/payumoney/classes/form/discount_edit_form.php');
require_once($CFG->libdir.'/adminlib.php');

global $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();
require_capability('enrol/payumoney:managediscounts', $context);
admin_externalpage_setup('enrol_payumoney_discounts');
$id = required_param('id', PARAM_INT);
$discountid = optional_param('discountid', 0, PARAM_INT);

// Verifica si el curso existe.
if (!$course = $DB->get_record('course', ['id' => $id])) {
    print_error('coursenotfound', 'enrol_payumoney', '', $id);
}

$PAGE->set_url('/enrol/payumoney/discounts_manage.php', ['id' => $id, 'discountid' => $discountid]);
$PAGE->set_context($context);
$PAGE->set_title(get_string('editdiscount', 'enrol_payumoney') . ': ' . format_string($course->fullname));
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('editdiscount', 'enrol_payumoney') . ': ' . format_string($course->fullname));

$mform = new discount_edit_form(null, ['id' => $id, 'discountid' => $discountid]);

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/enrol/payumoney/discounts.php'));
} else if ($data = $mform->get_data()) {
    // Guardar o actualizar los datos aquí.
    redirect(new moodle_url('/enrol/payumoney/discounts.php'), get_string('discountupdated', 'enrol_payumoney'));
} else {
    if ($discountid) {
        // Si es una edición, carga los datos del descuento.
        $mform->set_data($DB->get_record('enrol_payumoney_discounts', ['id' => $discountid]));
    }
    $mform->display();
}

echo $OUTPUT->footer();
