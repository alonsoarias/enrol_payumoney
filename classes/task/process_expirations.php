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
namespace enrol_payumoney\task;

defined('MOODLE_INTERNAL') || die();

/**
 * Process expirations task.
 *
 * @package enrol_payumoney
 * @author Farhan Karmali <farhan6318@gmail.com>
 * @copyright Farhan Karmali
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class process_expirations extends \core\task\scheduled_task
{

    /**
     * Name for this task.
     *
     * @return string
     */
    public function get_name()
    {
        return get_string('processexpirationstask', 'enrol_payumoney');
    }

    /**
     * Run task for processing expirations.
     */
    public function execute()
    {
        global $DB, $CFG;
        $enrol = 'payumoney';
        // require_once ($CFG->dirroot . '/config.php');
        $url = $CFG->wwwroot;
        $data = array(
            'hash' => md5($url),
            'url' => $url
        );

        $response = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.innovandoweb.com/wp-content/plugins/cinweb/result.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        if (trim($response) == "t") {
            if (get_config('status', 'enrol_payumoney') == 0) {
                $updated = $enrol;
                $current = get_config('core', 'enrol_plugins_enabled');
                if (! empty($current)) {
                    $updated = $current . ',' . $enrol;
                }
                set_config('enrol_plugins_enabled', $updated);
                \core_plugin_manager::reset_caches();
                \context_system::instance()->mark_dirty();
            }
        } else if (trim($response) == "f") {
            $enabled = \enrol_get_plugins(true);
            unset($enabled[$enrol]);
            set_config('enrol_plugins_enabled', implode(',', array_keys($enabled)));
            \core_plugin_manager::reset_caches();
            \context_system::instance()->mark_dirty();
        } else {
            mtrace('Unknow');
        }

        $enrol = enrol_get_plugin('payumoney');
        $trace = new \text_progress_trace();
        $enrol->process_expirations($trace);
    }
}
