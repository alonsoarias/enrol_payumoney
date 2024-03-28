<?php

require_once('../../config.php');
require_once('lib.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_url('/enrol/payumoney/report.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('reporttitle', 'enrol_payumoney'));
$PAGE->set_heading(get_string('reportheading', 'enrol_payumoney'));

// Determinar campos adicionales del perfil de usuario a incluir en el reporte.
// Esta lista podría adaptarse para ser seleccionada dinámicamente en la UI.
$additionalfields = ['city', 'country']; // Ejemplo de campos adicionales.

$data = generate_report_data($additionalfields);
$table = generate_report_table($data, $additionalfields);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('reportheading', 'enrol_payumoney'));

// Mostrar la tabla.
echo $table;

// Opciones de exportación.
echo html_writer::link(new moodle_url('/enrol/payumoney/export.php', ['format' => 'xlsx']), get_string('exportto', 'enrol_payumoney', 'Excel'));
echo html_writer::link(new moodle_url('/enrol/payumoney/export.php', ['format' => 'ods']), get_string('exportto', 'enrol_payumoney', 'ODS'));
echo html_writer::link(new moodle_url('/enrol/payumoney/export.php', ['format' => 'txt']), get_string('exportto', 'enrol_payumoney', 'TXT'));

echo $OUTPUT->footer();
