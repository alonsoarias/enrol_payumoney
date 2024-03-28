<?php

require_once('../../config.php');
require_once('locallib.php');

require_login();
$context = context_system::instance();
require_capability('moodle/user:viewdetails', $context);
$PAGE->set_url('/enrol/payumoney/report.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('reporttitle', 'enrol_payumoney'));

// Obtener datos de reporte usando la función definida en lib.php
$data = generate_report_data();
$table = generate_report_table($data);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('reportheading', 'enrol_payumoney'));

// Opciones de exportación.
echo html_writer::start_tag('form', ['action' => new moodle_url('/enrol/payumoney/report.php'), 'method' => 'get']);
echo html_writer::select(['xlsx' => get_string('downloadexcel', 'enrol_payumoney'),
                         'ods' => get_string('downloadooo', 'enrol_payumoney'),
                         'txt' => get_string('downloadtext', 'enrol_payumoney')], 'format');
echo html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('download', 'enrol_payumoney')]);
echo html_writer::end_tag('form');

// Mostrar la tabla.
echo html_writer::table($table);

echo $OUTPUT->footer();

// Funciones para exportar a xlsx, ods y txt
if(isset($_GET['format'])) {
    $format = $_GET['format'];
    if($format === 'xlsx' || $format === 'ods' || $format === 'txt') {
        // Exportar a XLSX
        if($format === 'xlsx') {
            exporttotableed($data, 'report', 'excel');
        }
        // Exportar a ODS
        elseif($format === 'ods') {
            exporttotableed($data, 'report', 'ods');
        }
        // Exportar a TXT
        elseif($format === 'txt') {
            exporttocsv($data, 'report');
        }
    }
}
?>
