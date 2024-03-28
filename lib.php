<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License along with Moodle.
// If not, see <http://www.gnu.org/licenses/>.

/**
 * Lang strings.
 *
 * This files lists lang strings related to tool_untoken_oauth2.
 *
 * @package enrol_payumoney
 * @copyright 2019 Jonathan Lopez <asesor@innovandoweb.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
/**
 * Sets up essential methods for plugin.
 * @copyright  2017 Exam Tutor, Venkatesan R Iyengar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_payumoney_plugin extends enrol_plugin
{
    /**
     * Lists all currencies available for plugin.
     * @return $currencies
     */
    public function get_currencies()
    {
        $codes = array('COP', 'USD', 'PEN', 'MXN', 'CLP', 'BRL', 'ARS');
        $currencies = array();
        foreach ($codes as $c) {
            $currencies[$c] = new lang_string($c, 'core_currencies');
        }

        return $currencies;
    }
    /**
     * Returns optional enrolment information icons.
     *
     * This is used in course list for quick overview of enrolment options.
     *
     * We are not using single instance parameter because sometimes
     * we might want to prevent icon repetition when multiple instances
     * of one type exist. One instance may also produce several icons.
     *
     * @param array $instances all enrol instances of this type in one course
     * @return array of pix_icon
     */
    public function get_info_icons(array $instances)
    {
        return array(new pix_icon('icon', get_string('pluginname', 'enrol_payumoney'), 'enrol_payumoney'));
    }
    /**
     * Lists all protected user roles.
     * @return bool(true or false)
     */
    public function roles_protected()
    {
        // Users with role assign cap may tweak the roles later.
        return false;
    }
    /**
     * Defines if user can be unenrolled.
     * @param stdClass $instance of the plugin
     * @return bool(true or false)
     */
    public function allow_unenrol(stdClass $instance)
    {
        // Users with unenrol cap may unenrol other users manually - requires enrol/payumoney:unenrol.
        return true;
    }
    /**
     * Defines if user can be managed from admin.
     * @param stdClass $instance of the plugin
     * @return bool(true or false)
     */
    public function allow_manage(stdClass $instance)
    {
        // Users with manage cap may tweak period and status - requires enrol/payumoney:manage.
        return true;
    }
    /**
     * Defines if 'enrol me' link will be shown on course page.
     * @param stdClass $instance of the plugin
     * @return bool(true or false)
     */
    public function show_enrolme_link(stdClass $instance)
    {
        return ($instance->status == ENROL_INSTANCE_ENABLED);
    }
    /**
     * Adds navigation links into course admin block.
     *
     * By defaults looks for manage links only.
     *
     * @param navigation_node $instancesnode
     * @param stdClass $instance
     * @return void
     */
    public function add_course_navigation($instancesnode, stdClass $instance)
    {
        if ($instance->enrol !== 'payumoney') {
            throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/payumoney:config', $context)) {
            $managelink = new moodle_url(
                '/enrol/payumoney/edit.php',
                array('courseid' => $instance->courseid, 'id' => $instance->id)
            );
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    /**
     * Returns edit icons for the page with list of instances
     * @param stdClass $instance
     * @return array
     */
    public function get_action_icons(stdClass $instance)
    {
        global $OUTPUT;

        if ($instance->enrol !== 'payumoney') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/payumoney:config', $context)) {
            $editlink = new moodle_url(
                "/enrol/payumoney/edit.php",
                array('courseid' => $instance->courseid, 'id' => $instance->id)
            );
            $icons[] = $OUTPUT->action_icon($editlink, new pix_icon(
                't/edit',
                get_string('edit'),
                'core',
                array('class' => 'iconsmall')
            ));
        }

        return $icons;
    }

    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid)
    {
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('moodle/course:enrolconfig', $context) or !has_capability('enrol/payumoney:config', $context)) {
            return null;
        }

        // Multiple instances supported - different cost for different roles.
        return new moodle_url('/enrol/payumoney/edit.php', array('courseid' => $courseid));
    }
    /**
     * Creates course enrol form, checks if form submitted
     * and enrols user if necessary. It can also redirect.
     *
     * @param stdClass $instance
     * @return string html text, usually a form in a text box
     */
    public function enrol_page_hook(stdClass $instance)
    {
        global $CFG, $USER, $OUTPUT, $PAGE, $DB;
        ob_start();

        if ($DB->record_exists('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instance->id))) {
            return ob_get_clean();
        }

        if ($instance->enrolstartdate != 0 && $instance->enrolstartdate > time()) {
            return ob_get_clean();
        }

        if ($instance->enrolenddate != 0 && $instance->enrolenddate < time()) {
            return ob_get_clean();
        }

        $course = $DB->get_record('course', array('id' => $instance->courseid));
        $context = context_course::instance($course->id);

        $shortname = format_string($course->shortname, true, array('context' => $context));
        $strloginto = get_string("loginto", "", $shortname);
        $strcourses = get_string("courses");

        // Pass $view=true to filter hidden caps if the user cannot see them.
        if ($users = get_users_by_capability(
            $context,
            'moodle/course:update',
            'u.*',
            'u.id ASC',
            '',
            '',
            '',
            '',
            false,
            true
        )) {
            $users = sort_by_roleassignment_authority($users, $context);
            $teacher = array_shift($users);
        } else {
            $teacher = false;
        }

        if ((float) $instance->cost <= 0) {
            $cost = (float) $this->get_config('cost');
        } else {
            $cost = (float) $instance->cost;
        }

        if (abs($cost) < 0.01) {
            // No cost, other enrolment methods (instances) should be used.
            echo '<p>' . get_string('nocost', 'enrol_payumoney') . '</p>';
        } else {

            // Calculate localised and "." cost, make sure we send Authorize.net the same value,
            // please note Authorize.net expects amount with 2 decimal places and "." separator.
            $localisedcost = format_float($cost, 2, true);
            $cost = format_float($cost, 2, false);

            if (isguestuser()) {
                // Force login only for guest user, not real users with guest role.
                if (empty($CFG->loginhttps)) {
                    $wwwroot = $CFG->wwwroot;
                } else {
                    // This actually is not so secure ;-), 'cause we're
                    // in unencrypted connection...
                    $wwwroot = str_replace("http://", "https://", $CFG->wwwroot);
                }
                echo '<div class="mdl-align"><p>' . get_string('paymentrequired') . '</p>';
                echo '<p><b>' . get_string('cost') . ": $instance->currency $localisedcost" . '</b></p>';
                echo '<p><a href="' . $wwwroot . '/login/">' . get_string('loginsite') . '</a></p>';
                echo '</div>';
            } else {
                // Sanitise some fields before building the payment form.
                $coursefullname  = format_string($course->fullname, true, array('context' => $context));
                $courseshortname = $shortname;
                $userfullname    = fullname($USER);
                $userfirstname   = $USER->firstname;
                $userlastname    = $USER->lastname;
                $useraddress     = $USER->address;
                $usercity        = $USER->city;
                $instancename    = $this->get_instance_name($instance);

                include($CFG->dirroot . '/enrol/payumoney/enrolment_form.php');
            }
        }

        return $OUTPUT->box(ob_get_clean());
    }
    /**
     * Restore instance and map settings.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $course
     * @param int $oldid
     */
    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid)
    {
        global $DB;
        if ($step->get_task()->get_target() == backup::TARGET_NEW_COURSE) {
            $merge = false;
        } else {
            $merge = array(
                'courseid'   => $data->courseid,
                'enrol'      => $this->get_name(),
                'roleid'     => $data->roleid,
                'cost'       => $data->cost,
                'currency'   => $data->currency,
            );
        }
        if ($merge and $instances = $DB->get_records('enrol', $merge, 'id')) {
            $instance = reset($instances);
            $instanceid = $instance->id;
        } else {
            $instanceid = $this->add_instance($course, (array)$data);
        }
        $step->set_mapping('enrol', $oldid, $instanceid);
    }
    /**
     * Restore user enrolment.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $instance 
     * @param int $userid
     * @param int $oldinstancestatus
     */
    public function restore_user_enrolment(restore_enrolments_structure_step $step, $data, $instance, $userid, $oldinstancestatus)
    {
        $this->enrol_user($instance, $userid, null, $data->timestart, $data->timeend, $data->status);
    }
    /**
     * Gets an array of the user enrolment actions
     *
     * @param course_enrolment_manager $manager
     * @param stdClass $ue A user enrolment object
     * @return array An array of user_enrolment_actions
     */
    public function get_user_enrolment_actions(course_enrolment_manager $manager, $ue)
    {
        $actions = array();
        $context = $manager->get_context();
        $instance = $ue->enrolmentinstance;
        $params = $manager->get_moodlepage()->url->params();
        $params['ue'] = $ue->id;
        if ($this->allow_unenrol($instance) && has_capability("enrol/payumoney:unenrol", $context)) {
            $url = new moodle_url('/enrol/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(
                new pix_icon('t/delete', ''),
                get_string('unenrol', 'enrol'),
                $url,
                array('class' => 'unenrollink', 'rel' => $ue->id)
            );
        }
        if ($this->allow_manage($instance) && has_capability("enrol/payumoney:manage", $context)) {
            $url = new moodle_url('/enrol/editenrolment.php', $params);
            $actions[] = new user_enrolment_action(
                new pix_icon('t/edit', ''),
                get_string('edit'),
                $url,
                array('class' => 'editenrollink', 'rel' => $ue->id)
            );
        }
        return $actions;
    }
    /**
     * Set up cron for the plugin (if any).
     *
     */
    public function cron()
    {
        $trace = new text_progress_trace();
        $this->process_expirations($trace);
    }
    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_delete_instance($instance)
    {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/payumoney:config', $context);
    }
    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance)
    {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/payumoney:config', $context);
    }

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
        $myxls = $workbook->add_worksheet(get_string('modulenameplural', 'attendance'));
        // Format types.
        $formatbc = $workbook->add_format();
        $formatbc->set_bold(1);

        $myxls->write(0, 0, get_string('course'), $formatbc);
        $myxls->write(0, 1, $data->course);
        $myxls->write(1, 0, get_string('group'), $formatbc);
        $myxls->write(1, 1, $data->group);

        $i = 3;
        $j = 0;
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
        foreach ($data->table as $row) {
            foreach ($row as $cell) {
                $myxls->write($i, $j++, $cell);
            }
            $i++;
            $j = 0;
        }
        $workbook->close();
    }
    /**
     * Generate csv for enrol_payu export
     *
     * @param stdclass $data The data for the report
     * @param string $filename The name of the file
     *
     */
    function exporttocsv($data, $filename)
    {
        $filename .= ".txt";

        header("Content-Type: application/download\n");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate,post-check=0,pre-check=0");
        header("Pragma: public");

        echo get_string('course') . "\t" . $data->course . "\n";
        echo get_string('group') . "\t" . $data->group . "\n\n";

        echo implode("\t", $data->tabhead) . "\n";
        foreach ($data->table as $row) {
            echo implode("\t", $row) . "\n";
        }
    }

    function generate_report_data($additionalfields = []) {
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
    
        // Agregar campos adicionales dinámicos.
        foreach ($additionalfields as $field) {
            // Asegúrate de incluir solo los campos válidos de la tabla de usuario.
            $basicFields[] = "u.$field";
        }
    
        $fields = implode(', ', $basicFields);
        $sql = "SELECT $fields
                FROM {enrol_payumoney} e
                JOIN {user} u ON e.userid = u.id";
    
        // Ejecutar la consulta y retornar los resultados.
        $data = $DB->get_records_sql($sql);
    
        return $data;
    }
    
    function generate_report_table($data, $additionalfields = []) {
        global $OUTPUT;
    
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
    
        // Añadir encabezados de columna para campos adicionales dinámicamente.
        foreach ($additionalfields as $field) {
            // Usa get_string() para intentar obtener la traducción del campo.
            // Si no existe, usa el nombre del campo directamente.
            $fieldLabel = get_string($field, 'moodle', $field);
            $table->head[] = $fieldLabel;
        }
    
        // Añadir filas de datos al reporte.
        foreach ($data as $record) {
            $row = [];
            foreach ($record as $field => $value) {
                // Añade el valor de cada campo a la fila.
                $row[] = $value;
            }
            $table->data[] = $row;
        }
    
        // Retorna la tabla HTML generada.
        return $OUTPUT->render($table);
    }

}