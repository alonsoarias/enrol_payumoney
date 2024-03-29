<?php

require_once('../../config.php');
require_once('locallib.php');
require_once($CFG->libdir.'/adminlib.php');

// Asegúrate de estar logueado y tener la capacidad adecuada para ver este reporte.
require_login();
$context = context_system::instance();
require_capability('enrol/payumoney:viewreports', $context);

// Inicializar la página de configuración.
admin_externalpage_setup('enrol_payumoney_report');

// Obtener el formato de exportación si se ha solicitado.
$format = optional_param('format', '', PARAM_ALPHA);
if (!empty($format)) {
    $filename = 'report_' . userdate(time(), '%Y%m%d-%H%M%S');
    $data = generate_report_data();

    switch ($format) {
        case 'xlsx':
            exporttotableed($data, $filename, 'excel');
            exit;
        case 'ods':
            exporttotableed($data, $filename, 'ods');
            exit;
        case 'txt':
            exporttocsv($data, $filename);
            exit;
    }
}

$PAGE->set_url('/enrol/payumoney/report.php');
$PAGE->set_title(get_string('reporttitle', 'enrol_payumoney'));
$PAGE->set_heading(get_string('reportheading', 'enrol_payumoney'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('reportheading', 'enrol_payumoney'));

// Generar y mostrar la tabla con los datos.
$data = generate_report_data();
$table = generate_report_table($data);
echo html_writer::table($table);

// Formulario para opciones de exportación.
echo html_writer::start_tag('form', ['action' => $PAGE->url, 'method' => 'get']);
echo html_writer::select([
    'xlsx' => get_string('downloadexcel', 'enrol_payumoney'),
    'ods' => get_string('downloadods', 'enrol_payumoney'),
    'txt' => get_string('downloadtext', 'enrol_payumoney')
], 'format', '', ['' => get_string('selectformat', 'enrol_payumoney')]);
echo html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('download', 'enrol_payumoney'), 'class' => 'btn btn-primary']);
echo html_writer::end_tag('form');


echo $OUTPUT->footer();
