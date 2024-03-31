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
require_login();

// Añadir enlace a la página de gestión de descuentos bajo la configuración del plugin.
if ($hassiteconfig) {
    $categoryName = 'enrol_payumoney_settings';
    $categoryVisibleName = get_string('pluginname', 'enrol_payumoney');

    if (!$ADMIN->locate($categoryName)) {
        $ADMIN->add('root', new admin_category($categoryName, $categoryVisibleName));
    }

    // Añade el enlace a Descuentos
    $ADMIN->add($categoryName, new admin_externalpage(
        'enrol_payumoney_discounts',
        get_string('discounts', 'enrol_payumoney'),
        "{$CFG->wwwroot}/enrol/payumoney/discounts.php",
        'enrol/payumoney:managediscounts'
    ));

    // Añade el enlace a Ver informes
    $ADMIN->add($categoryName, new admin_externalpage(
        'enrol_payumoney_report',
        get_string('viewreports', 'enrol_payumoney'),
        "{$CFG->wwwroot}/enrol/payumoney/report.php",
        'enrol/payumoney:viewreports'
    ));
}



if ($ADMIN->fulltree) {

    // Settings.
    $settings->add(new admin_setting_heading('enrol_payumoney_settings', '', get_string('pluginname_desc', 'enrol_payumoney')));
    $settings->add(new admin_setting_configtext('enrol_payumoney/API_login', get_string('merchantapi', 'enrol_payumoney'), 'Copy API Login from merchant account & paste here', '', PARAM_RAW));
    $settings->add(new admin_setting_configtext('enrol_payumoney/API_key', get_string('merchantkey', 'enrol_payumoney'), 'Copy API Key from merchant account & paste here', '', PARAM_RAW));
    $settings->add(new admin_setting_configtext('enrol_payumoney/merchantId', get_string('merchantid', 'enrol_payumoney'), 'Copy merchantId from your account PayU & paste here', '', PARAM_RAW));
    $settings->add(new admin_setting_configtext('enrol_payumoney/accountId', get_string('accountid', 'enrol_payumoney'), 'Copy accountId from your account PayU & paste here', '', PARAM_RAW));
    $settings->add(new admin_setting_configtext('enrol_payumoney/urlprod', get_string('urlprod', 'enrol_payumoney'), '', 'https://checkout.payulatam.com/ppp-web-gateway-payu'));
    /*
     * $settings->add(new admin_setting_configcheckbox('enrol_payumoney/mailstudents',
     * get_string('mailstudents', 'enrol_payumoney'), '', 0));
     * $settings->add(new admin_setting_configcheckbox('enrol_payumoney/mailteachers',
     * get_string('mailteachers', 'enrol_payumoney'), '', 0));
     * $settings->add(new admin_setting_configcheckbox('enrol_payumoney/mailadmins',
     * get_string('mailadmins', 'enrol_payumoney'), '', 0));
     */
    // Note: let's reuse the ext sync constants and strings here, internally it is very similar,
    // it describes what should happen when users are not supposed to be enrolled any more.
    $options = array(
        ENROL_EXT_REMOVED_KEEP => get_string('extremovedkeep', 'enrol'),
        ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string('extremovedsuspendnoroles', 'enrol'),
        ENROL_EXT_REMOVED_UNENROL => get_string('extremovedunenrol', 'enrol')
    );
    $settings->add(new admin_setting_configselect('enrol_payumoney/expiredaction', get_string('expiredaction', 'enrol_payumoney'), get_string('expiredaction_help', 'enrol_payumoney'), ENROL_EXT_REMOVED_SUSPENDNOROLES, $options));

    // Enrol instance defaults.
    $settings->add(new admin_setting_heading('enrol_payumoney_defaults', get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $options = array(
        ENROL_INSTANCE_ENABLED => get_string('yes'),
        ENROL_INSTANCE_DISABLED => get_string('no')
    );
    $settings->add(new admin_setting_configselect('enrol_payumoney/status', get_string('status', 'enrol_payumoney'), get_string('status_desc', 'enrol_payumoney'), ENROL_INSTANCE_DISABLED, $options));

    $settings->add(new admin_setting_configtext('enrol_payumoney/cost', get_string('cost', 'enrol_payumoney'), '', 0, PARAM_FLOAT, 4));

    $settings->add(new admin_setting_configtext('enrol_payumoney/tax', get_string('tax', 'enrol_payumoney'), '', 0, PARAM_FLOAT, 4));

    $currencies = enrol_get_plugin('payumoney')->get_currencies();
    $settings->add(new admin_setting_configselect('enrol_payumoney/currency', get_string('currency', 'enrol_payumoney'), '', 'COP', $currencies));
    if (!during_initial_install()) {
        $options = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $settings->add(new admin_setting_configselect('enrol_payumoney/roleid', get_string('defaultrole', 'enrol_payumoney'), get_string('defaultrole_desc', 'enrol_payumoney'), $student->id, $options));
    }

    $settings->add(new admin_setting_configduration('enrol_payumoney/enrolperiod', get_string('enrolperiod', 'enrol_payumoney'), get_string('enrolperiod_desc', 'enrol_payumoney'), 0));

    // Enrol instance defaults.
    $settings->add(new admin_setting_heading('enrol_payumoney_mat', get_string('mat', 'enrol_payumoney'), get_string('mat_desc', 'enrol_payumoney')));

    /* $optDate = date('Y');
    $settings->add(new admin_setting_configselect('enrol_payumoney/periodmp', get_string('periodmp', 'enrol_payumoney'), get_string('periodmp_desc', 'enrol_payumoney'), 0, array(
        '1' => '1',
        $optDate - 2 => $optDate - 2,
        $optDate - 1 => $optDate - 1,
        $optDate => $optDate
    )));
    */
    $settings->add(new admin_setting_configcheckbox(
        'enrol_payumoney/clean',
        get_string('clean', 'enrol_payumoney'),
        get_string('clean_desc', 'enrol_payumoney'),
        0
    ));
}
