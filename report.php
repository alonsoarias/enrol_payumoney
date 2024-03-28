<?php
require_once('../../config.php');
require_once('lib.php');

require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context); // Ajusta según la capacidad necesaria.

$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'enrol_payumoney'));
$PAGE->set_heading(get_string('pluginname', 'enrol_payumoney'));
$PAGE->set_url('/enrol/payumoney/report.php');

$download = optional_param('download', '', PARAM_ALPHA);
$selectedfields = optional_param_array('fields', [], PARAM_NOTAGS);

if (!empty($download)) {
    // Prepara los datos para la descarga.
    $data = generate_report_data($selectedfields);
    $filename = "payment_report_".date("Ymd").".{$download}";

    if ($download == 'txt') {
        exporttocsv($data, $filename);
    } else {
        // Excel o ODS.
        exporttotableed($data, $filename, $download);
    }
    exit;
}

// Opciones para campos adicionales (ejemplo simplificado).
$fieldoptions = [
    'country' => get_string('country'),
    'city' => get_string('city'),
    // Añadir más campos disponibles como desees.
];

echo $OUTPUT->header();

// Formulario simplificado para seleccionar campos adicionales.
echo '<form method="get">';
echo '<div>';
foreach ($fieldoptions as $field => $label) {
    echo '<input type="checkbox" name="fields[]" value="'.$field.'" '.(in_array($field, $selectedfields) ? 'checked' : '').'>';
    echo '<label>'.$label.'</label><br>';
}
echo '</div>';
echo '<input type="submit" value="'.get_string('updatereport', 'enrol_payumoney').'">';
echo '</form>';

// Visualizar el botón de descarga.
echo '<div>';
echo $OUTPUT->single_button(new moodle_url('/enrol/payumoney/report.php', ['download' => 'xlsx']), get_string('downloadxlsx', 'enrol_payumoney'));
echo $OUTPUT->single_button(new moodle_url('/enrol/payumoney/report.php', ['download' => 'ods']), get_string('downloadods', 'enrol_payumoney'));
echo $OUTPUT->single_button(new moodle_url('/enrol/payumoney/report.php', ['download' => 'txt']), get_string('downloadtxt', 'enrol_payumoney'));
echo '</div>';

// Mostrar los datos en formato de tabla HTML.
$data = generate_report_data($selectedfields);
echo generate_report_table($data, $selectedfields);

echo $OUTPUT->footer();
