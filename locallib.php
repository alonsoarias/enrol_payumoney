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


/**
 * Adds a new discount to the database.
 *
 * @param stdClass $data Data representing the discount to be added.
 * @return bool|int False on failure or id of the new record on success.
 */
function enrol_payumoney_add_discount($data) {
    global $DB;

    // Preparando el objeto de descuento para insertarlo en la base de datos.
    $discount = new stdClass();
    $discount->courseid = $data->courseid;
    $discount->discountcode = $data->discountcode; // Asumiendo que el formulario envía un código de descuento.
    $discount->discounttype = $data->discounttype; // Tipo de descuento, por ejemplo: porcentaje, fijo.
    $discount->discountvalue = $data->discountvalue; // Valor del descuento, dependiendo del tipo.
    $discount->validfrom = $data->validfrom; // Fecha de inicio de validez del descuento.
    $discount->validto = $data->validto; // Fecha de fin de validez del descuento.

    // Insertar el registro en la base de datos y devolver el ID del nuevo descuento.
    return $DB->insert_record('enrol_payumoney_discounts', $discount);
}

/**
 * Updates an existing discount in the database.
 *
 * @param stdClass $data Data representing the discount to be updated.
 * @return bool Result of the operation.
 */
function enrol_payumoney_update_discount($data) {
    global $DB;

    // Asegurándose de que el ID del descuento exista para poder actualizarlo.
    if (!isset($data->id)) {
        throw new invalid_parameter_exception('Discount ID is required.');
    }

    // Preparando el objeto de descuento con los nuevos valores para actualizarlo.
    $discount = new stdClass();
    $discount->id = $data->id;
    $discount->courseid = $data->courseid;
    $discount->discountcode = $data->discountcode;
    $discount->discounttype = $data->discounttype;
    $discount->discountvalue = $data->discountvalue;
    $discount->validfrom = $data->validfrom;
    $discount->validto = $data->validto;

    // Actualizar el registro en la base de datos.
    return $DB->update_record('enrol_payumoney_discounts', $discount);
}

/**
 * Deletes a discount from the database.
 *
 * @param int $discountid ID of the discount to be deleted.
 * @return bool Result of the operation.
 */
function enrol_payumoney_delete_discount($discountid) {
    global $DB;

    // Eliminar el descuento identificado por $discountid de la base de datos.
    return $DB->delete_records('enrol_payumoney_discounts', array('id' => $discountid));
}
/**
 * Get courses with a specific enrolment method.
 *
 * @param string $enrolmethod The enrolment method to filter courses.
 * @return array Array of courses with the specified enrolment method.
 */
function get_courses_with_enrol_method($enrolmethod) {
    global $DB;

    // Prepare the SQL query to search in the enrolment method table.
    $sql = "SELECT c.id, c.fullname
            FROM {course} c
            JOIN {enrol} e ON e.courseid = c.id
            WHERE e.enrol = :enrolmethod";

    // Execute the query with the enrolment method as parameter.
    $params = ['enrolmethod' => $enrolmethod];
    $courses = $DB->get_records_sql($sql, $params);

    return $courses;
}
