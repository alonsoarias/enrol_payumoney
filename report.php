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
 * Lang strings.
 *
 * This files lists lang strings related to enrol_payumoney.
 *
 * @package enrol_payumoney
 * @copyright 2019 Innovandoweb <asesor@innovandoweb.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once ('../../config.php');

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'enrol_payumoney'));
$PAGE->set_heading(get_string('pluginname', 'enrol_payumoney'));
$PAGE->set_url($CFG->wwwroot . '/enrol/payumoney/report.php');

echo $OUTPUT->header();
$context = context_system::instance();
require_capability('moodle/user:viewdetails', $context);

$site = get_site();

$table = new html_table();
$table->head = array(
    'id',
    'course_name',
    'userid',
    'email',
    'amount',
    'tax',
    'payment_status',
    'timeupdated'
);
$table->colclasses[] = 'centeralign';
$table->attributes['cellpadding'] = '0';
$logs = $DB->get_records('enrol_payumoney');
$fecha = new DateTime();

foreach ($logs as $log) {
    if ($DB->record_exists('user', array(
        'id' => $log->userid
    ))) {
        $user = $DB->get_record('user', array(
            'id' => $log->userid
        ));
        $log->email = $user->email;
    } else {
        $log->email = 'The record not exist';
    }

    if ($DB->record_exists('course', array(
        'id' => $log->courseid
    ))) {
        $course = $DB->get_record('course', array(
            'id' => $log->courseid
        ));
        $log->course = $course->shortname;
    } else {
        $log->course = 'The record not exist';
    }
    $fecha->setTimestamp($log->timeupdated);
    $table->data[] = array(
        $log->id,
        $log->course,
        $log->userid,
        $log->email,
        $log->amount,
        $log->tax,
        $log->payment_status,
        $fecha->format('d-m-Y H:i:s')
    );
}

echo html_writer::table($table);
echo $OUTPUT->single_button(new moodle_url('/enrol/payumoney/export_csv.php', array(
    'process' => true
)), get_string('download', 'admin'));
echo $OUTPUT->footer();

