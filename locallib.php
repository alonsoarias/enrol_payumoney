<?php

require_once("$CFG->libdir/excellib.class.php");
require_once("$CFG->libdir/odslib.class.php");
require_once("$CFG->libdir/csvlib.class.php");

/**
 * Export report to .xlsx or .ods format.
 *
 * @param stdClass $data The data for the report.
 * @param string $filename The base name of the file without extension.
 * @param string $format The format of the export: 'excel' or 'ods'.
 */
function exporttotableed($data, $filename, $format) {
    global $CFG;

    if ($format === 'excel') {
        $filename .= ".xlsx";
        $workbook = new MoodleExcelWorkbook("-");
    } else {
        $filename .= ".ods";
        $workbook = new MoodleODSWorkbook("-");
    }

    ob_clean(); // Clean the output buffer to fix the headers already sent error
    $workbook->send($filename);

    $sheettitle = get_string('report', 'enrol_payumoney');
    $worksheet = $workbook->add_worksheet($sheettitle);

    // Define the format for the header
    $formatbc = $workbook->add_format(array('bold' => 1));
    $headers = array(
        get_string('payment_id', 'enrol_payumoney'),
        get_string('fullname', 'enrol_payumoney'),
        get_string('email', 'enrol_payumoney'),
        get_string('amount', 'enrol_payumoney'),
        get_string('tax', 'enrol_payumoney'),
        get_string('payment_status', 'enrol_payumoney'),
        get_string('payment_date', 'enrol_payumoney')
    );

    // Write the headers
    $col = 0;
    foreach ($headers as $header) {
        $worksheet->write(0, $col++, $header, $formatbc);
    }

    // Write the data
    $row = 1;
    foreach ($data as $record) {
        $col = 0;
        foreach ($record as $value) {
            $worksheet->write($row, $col++, $value);
        }
        $row++;
    }

    $workbook->close();
    exit;
}

/**
 * Export report to .txt format.
 *
 * @param stdClass $data The data for the report.
 * @param string $filename The base name of the file.
 */
function exporttocsv($data, $filename) {
    $filename .= ".txt";

    // Prevent the error "headers already sent"
    ob_clean();
    header("Content-Type: text/plain");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    $headers = array(
        get_string('payment_id', 'enrol_payumoney'),
        get_string('fullname', 'enrol_payumoney'),
        get_string('email', 'enrol_payumoney'),
        get_string('amount', 'enrol_payumoney'),
        get_string('tax', 'enrol_payumoney'),
        get_string('payment_status', 'enrol_payumoney'),
        get_string('payment_date', 'enrol_payumoney')
    );

    echo implode("\t", $headers) . "\n";

    foreach ($data as $record) {
        echo implode("\t", (array)$record) . "\n";
    }

    exit;
}




function generate_report_data()
{
    global $DB;

    // Campos básicos que siempre estarán presentes en el reporte.
    $basicFields = [
        'e.id AS payment_id',
        'CONCAT(u.firstname, \' \', u.lastname) AS fullname',
        'u.email',
        'e.amount',
        'e.tax',
        'e.payment_status',
        'FROM_UNIXTIME(e.timeupdated, \'%Y-%m-%d %H:%i:%s\') AS payment_date'
    ];

    $fields = implode(', ', $basicFields);
    $sql = "SELECT $fields
            FROM {enrol_payumoney} e
            JOIN {user} u ON e.userid = u.id";

    // Ejecutar la consulta y retornar los resultados.
    $data = $DB->get_records_sql($sql);

    return $data;
}

function generate_report_table($data) {
    global $OUTPUT;

    // Crear una nueva instancia de la clase html_table
    $table = new html_table();

    // Encabezados de columna básicos.
    $table->head = [
        get_string('payment_id', 'enrol_payumoney'),
        get_string('fullname', 'enrol_payumoney'),
        get_string('email', 'enrol_payumoney'),
        get_string('amount', 'enrol_payumoney'),
        get_string('tax', 'enrol_payumoney'),
        get_string('payment_status', 'enrol_payumoney'),
        get_string('payment_date', 'enrol_payumoney')
    ];

    // Verificar si los datos están en el formato esperado
    if (!empty($data) && is_array($data)) {
        // Añadir filas de datos al reporte.
        foreach ($data as $record) {
            $row = [];
            foreach ($record as $field => $value) {
                // Añade el valor de cada campo a la fila.
                $row[] = $value;
            }
            $table->data[] = $row;
        }
    } 
    // Retornar el objeto html_table
    return $table;
}
