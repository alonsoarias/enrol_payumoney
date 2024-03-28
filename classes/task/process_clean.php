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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Process clean task.
 *
 * @package enrol_payumoney_
 * @author Jonathan Lopez Garcia <asesor@innovandoweb.com>
 * @copyright innovandoweb
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace enrol_payumoney\task;

use Exception;
defined('MOODLE_INTERNAL') || die();

class process_clean extends \core\task\scheduled_task
{

    /**
     * Name for this task.
     *
     * @return string
     */
    public function get_name()
    {
        return get_string('clean', 'enrol_payumoney');
    }

    /**
     * Clean enrolment data.
     */
    public function execute()
    {
        global $DB, $CFG;
        require_once ($CFG->dirroot . '/config.php');

        if (! enrol_is_enabled('payumoney')) {
            mtrace("El plugin no se encuentra activo");
            return;
        }

        $enrol_payumoney = $DB->get_record('config_plugins', array(
            'plugin' => 'enrol_payumoney',
            'name' => 'clean'
        ));

        if ($enrol_payumoney->value) {

            try {
                $delrow = $DB->get_records_sql('SELECT *
					FROM {enrol_payumoney_mat}');

                foreach ($delrow as $row) {

                    $DB->delete_records('enrol_payumoney_mat', [
                        'id' => $row->id,
                        'courseid' => $row->courseid,
                        'userid' => $row->userid
                    ]);
                }
            } catch (Exception $e) {
                echo "error " . $e;
            }

            $DB->execute("UPDATE {config_plugins} SET value=0 WHERE plugin like '%enrol_payumoney%' and name like '%clean%'");

            $enrol = enrol_get_plugin('payumoney');
            $trace = new \text_progress_trace();
            $enrol->sync($trace);
            mtrace("entro en la validación y la tabla ha sido limpiada");
        }
        mtrace("Process complete");
    }
}

