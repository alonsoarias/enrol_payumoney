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
$string['pluginname'] = 'PayU Money';
$string['pluginname_desc'] = 'The PayU Money module allows you to set up paid courses.  If the cost for any course is zero, then students are not asked to pay for entry.  There is a site-wide cost that you set here as a default for the whole site and then a course setting that you can set for each course individually. The course cost overrides the site cost.';
$string['owner'] = 'innovandoweb.com';
$string['descriptionower'] = 'PayU Money developed and maintained by innovandoweb.com';
$string['nocost'] = 'Not value defined, please update the value or change enrol method';
$string['merchantid'] = 'merchant id';
$string['accountid'] = 'account id';
$string['tax'] = 'tax $';
$string['paycourse'] = 'This course requires a payment for entry.';
$string['merchantapi'] = 'merchant api';
$string['merchantkey'] = 'merchant key';
$string['merchantsalt'] = 'transaction salt';
$string['urlprod'] = 'url payu webcheckout';
$string['mailadmins'] = 'Notify admin';
$string['mailstudents'] = 'Notify students';
$string['mailteachers'] = 'Notify teachers';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['cost'] = 'Enrol cost';
$string['costerror'] = 'The enrolment cost is not numeric';
$string['costorkey'] = 'Please choose one of the following methods of enrolment.';
$string['currency'] = 'Currency';
$string['assignrole'] = 'Assign role';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during PayUMoney enrolments';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can be enrolled until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['payumoney:config'] = 'Configure PayUMoney enrol instances';
$string['payumoney:manage'] = 'Manage enrolled users';
$string['payumoney:unenrol'] = 'Unenrol users from course';
$string['payumoney:unenrolself'] = 'Unenrol self from the course (student)';
$string['status'] = 'Allow PayUMoney enrolments';
$string['status_desc'] = 'Allow users to use PayUMoney to enrol into a course by default.';
$string['unenrolselfconfirm'] = 'Do you really want to unenrol yourself from course "{$a}"?';
$string['errorinsert'] = 'Unable to insert record to pay';

$string['privacy:metadata:enrol_payumoney:payu_money:item_name'] = 'Description.';
$string['privacy:metadata:enrol_payumoney:payu_money:courseid'] = 'Course id.';
$string['privacy:metadata:enrol_payumoney:payu_money:userid'] = 'User id.';
$string['privacy:metadata:enrol_payumoney:payu_money:instanceid'] = 'Instance id.';
$string['privacy:metadata:enrol_payumoney:payu_money:amount'] = 'Amount.';
$string['privacy:metadata:enrol_payumoney:payu_money:tax'] = 'Tax.';
$string['privacy:metadata:enrol_payumoney:payu_money:paymen_status'] = 'Payment status.';
$string['privacy:metadata:enrol_payumoney:payu_money:trans_id'] = 'Transaction id.';
$string['privacy:metadata:enrol_payumoney:payu_money:payment_id'] = 'Payment id.';
$string['privacy:metadata:enrol_payumoney:payu_money:auth_json'] = 'Json payment.';
$string['privacy:metadata:enrol_payumoney:payu_money:timeupdated'] = 'Time update.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney'] = 'Database information';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:item_name'] = 'Item date.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:courseid'] = 'Course id.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:userid'] = 'User id.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:instanceid'] = 'Instance id.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:amount'] = 'Amount.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:tax'] = 'Tax.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_status'] = 'Payment status.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:trans_id'] = 'Transaction id.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_id'] = 'Payment id.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:auth_json'] = 'Json auth.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:timeupdated'] = 'Time update.';
$string['privacy:metadata:enrol_payumoney:payu_money'] = 'The extensión PayU Money, send informationtoweb PayU Money.';
$string['paymentconfirm'] = 'Paid course, resumen: <div id="resume"><br>course: "{$a->item_name}"<br>Value: "{$a->amount}"<br>Status: "{$a->payment_status}"<br>Tax: "{$a->tax}"<br></div>';
$string['paymentsorry'] = 'Thank you for your payment!  Unfortunately your payment has not yet been fully processed, and you are not yet registered to enter the course "{$a->fullname}".  But if you continue to have trouble then please alert the {$a->teacher} or the site administrator.<br>Payment status: "{$a->payment_status}"';

$string['messageprovider:payumoney_enrolment'] = 'User enrol';
$string['processexpirationstask'] = 'Work expiration process for PayU';
$string['syncenrolmentstask'] = 'Synchronise PayU enrolments task';
$string['mat'] = 'Config section.';
$string['mat_desc'] = 'Configuration and maintenance.';
$string['clean'] = 'Empty check database.';
$string['clean_desc'] = 'In order for payment registrations to occur only once, a temporary data repository is generated. Checking this check will clear the temporary records and when executing the plugin, registrations will be made again based on the period chosen in the &iacute;tem (periodmp).';
$string['managediscounts'] = 'Manage discounts';
$string['viewreports'] = 'View reports';
// Descripciones adicionales para las capacidades
$string['managediscounts_desc'] = 'Allow users to manage discounts for course enrollment fees.';
$string['viewreports_desc'] = 'Allow users to view payment and enrollment reports.';
$string['payment_id'] = 'ID de Pago';
$string['fullname'] = 'Nombre completo';
$string['email'] = 'Email';
$string['amount'] = 'Monto Pagado';
$string['tax'] = 'Impuesto';
$string['payment_status'] = 'Estado del Pago';
$string['payment_date'] = 'Fecha de Pago';
// Añade cadenas de idioma para los campos adicionales aquí, si es necesario.$string['reporttitle'] = 'Título del reporte';
$string['reporttitle'] = 'Título del reporte';
$string['reportheading'] = 'Encabezado del reporte';


