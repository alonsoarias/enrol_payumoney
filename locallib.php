<?php
/**
 * Generate worksheet for enrol_payu export
 *
 * @param stdclass $data The data for the report
 * @param string $filename The name of the file
 * @param string $format excel|ods
 *
 */
function exporttotableed($data, $filename, $format)
{
    global $CFG;

    if ($format === 'excel') {
        require_once("$CFG->libdir/excellib.class.php");
        $filename .= ".xls";
        $workbook = new MoodleExcelWorkbook("-");
    } else {
        require_once("$CFG->libdir/odslib.class.php");
        $filename .= ".ods";
        $workbook = new MoodleODSWorkbook("-");
    }

    // Sending HTTP headers.
    $workbook->send($filename);
    // Creating the first worksheet.
    $myxls = $workbook->add_worksheet(get_string('report', 'enrol_payumoney'));
    // Format types.
    $formatbc = $workbook->add_format();
    $formatbc->set_bold(1);

    // Write course and group information
    $myxls->write(0, 0, get_string('course'), $formatbc);
    $myxls->write(0, 1, isset($data->course) ? $data->course : '');
    $myxls->write(1, 0, get_string('group'), $formatbc);
    $myxls->write(1, 1, isset($data->group) ? $data->group : '');

    $i = 3;
    $j = 0;
    if (!empty($data->tabhead)) {
        foreach ($data->tabhead as $cell) {
            // Merge cells if the heading would be empty (remarks column).
            if (empty($cell)) {
                $myxls->merge_cells($i, $j - 1, $i, $j);
            } else {
                $myxls->write($i, $j, $cell, $formatbc);
            }
            $j++;
        }
        $i++;
        $j = 0;
    }

    if (!empty($data->table)) {
        foreach ($data->table as $row) {
            foreach ($row as $cell) {
                $myxls->write($i, $j++, $cell);
            }
            $i++;
            $j = 0;
        }
    }

    $workbook->close();
}

function exporttocsv($data, $filename)
{
    $filename .= ".txt";

    header("Content-Type: application/download\n");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Expires: 0");
    header("Cache-Control: must-revalidate,post-check=0,pre-check=0");
    header("Pragma: public");

    echo get_string('course') . "\t" . (isset($data->course) ? $data->course : '') . "\n";
    echo get_string('group') . "\t" . (isset($data->group) ? $data->group : '') . "\n\n";

    if (!empty($data->tabhead)) {
        echo implode("\t", $data->tabhead) . "\n";
    }

    if (!empty($data->table)) {
        foreach ($data->table as $row) {
            echo implode("\t", $row) . "\n";
        }
    } else {
        echo get_string('norecords', 'enrol_payumoney') . "\n";
    }
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
