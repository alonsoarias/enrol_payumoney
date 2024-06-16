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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language strings.
 *
 * This file lists all language strings related to the PayU Money enrolment plugin.
 *
 * @package    enrol_payumoney
 * @copyright  2019 Jonathan Lopez <asesor@innovandoweb.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'PayU Money';
$string['pluginname_desc'] = 'The PayU Money module allows you to set up paid courses. If the cost for any course is zero, then students are not asked to pay for entry. There is a site-wide cost that you set here as a default for the whole site and then a course setting that you can set for each course individually. The course cost overrides the site cost.';
$string['nocost'] = 'No value defined, please update the value or change enrol method';
$string['merchantid'] = 'Merchant ID';
$string['accountid'] = 'Account ID';
$string['tax'] = 'Tax $';
$string['paycourse'] = 'This course requires payment for entry.';
$string['merchantapi'] = 'Merchant API';
$string['merchantkey'] = 'Merchant Key';
$string['merchantsalt'] = 'Transaction Salt';
$string['urlprod'] = 'PayU WebCheckout URL';
$string['mailadmins'] = 'Notify admins';
$string['mailstudents'] = 'Notify students';
$string['mailteachers'] = 'Notify teachers';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from the course during course unenrolment.';
$string['cost'] = 'Enrolment cost';
$string['costerror'] = 'The enrolment cost is not numeric';
$string['costorkey'] = 'Please choose one of the following methods of enrolment.';
$string['currency'] = 'Currency';
$string['assignrole'] = 'Assign role';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select the role that should be assigned to users during PayUMoney enrolments';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can be enrolled until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than the start date';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting from the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from the course during course unenrolment.';
$string['payumoney:config'] = 'Configure PayUMoney enrol instances';
$string['payumoney:manage'] = 'Manage enrolled users';
$string['payumoney:unenrol'] = 'Unenrol users from the course';
$string['payumoney:unenrolself'] = 'Unenrol self from the course (student)';
$string['status'] = 'Allow PayUMoney enrolments';
$string['status_desc'] = 'Allow users to use PayUMoney to enrol in a course by default.';
$string['unenrolselfconfirm'] = 'Do you really want to unenrol yourself from the course "{$a}"?';
$string['errorinsert'] = 'Unable to insert record to PayUMoney';
$string['privacy:metadata:enrol_payumoney:payu_money:item_name'] = 'Description';
$string['privacy:metadata:enrol_payumoney:payu_money:courseid'] = 'Course ID';
$string['privacy:metadata:enrol_payumoney:payu_money:userid'] = 'User ID';
$string['privacy:metadata:enrol_payumoney:payu_money:instanceid'] = 'Instance ID';
$string['privacy:metadata:enrol_payumoney:payu_money:amount'] = 'Amount';
$string['privacy:metadata:enrol_payumoney:payu_money:tax'] = 'Tax';
$string['privacy:metadata:enrol_payumoney:payu_money:paymen_status'] = 'Payment Status';
$string['privacy:metadata:enrol_payumoney:payu_money:trans_id'] = 'Transaction ID';
$string['privacy:metadata:enrol_payumoney:payu_money:payment_id'] = 'Payment ID';
$string['privacy:metadata:enrol_payumoney:payu_money:auth_json'] = 'JSON Payment';
$string['privacy:metadata:enrol_payumoney:payu_money:timeupdated'] = 'Time Updated';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney'] = 'Database information';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:item_name'] = 'Item Date';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:courseid'] = 'Course ID';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:userid'] = 'User ID';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:instanceid'] = 'Instance ID';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:amount'] = 'Amount';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:tax'] = 'Tax';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_status'] = 'Payment Status';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:trans_id'] = 'Transaction ID';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_id'] = 'Payment ID';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:auth_json'] = 'JSON Auth';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:timeupdated'] = 'Time Updated';
$string['privacy:metadata:enrol_payumoney:payu_money'] = 'The PayU Money extension sends information to PayU Money website.';
$string['paymentconfirm'] = 'Paid course summary: <div id="resume"><br>Course: "{$a->item_name}"<br>Value: "{$a->amount}"<br>Status: "{$a->payment_status}"<br>Tax: "{$a->tax}"<br></div>';
$string['paymentsorry'] = 'Thank you for your payment! Unfortunately, your payment has not yet been fully processed, and you are not yet registered to enter the course "{$a->fullname}". But if you continue to have trouble then please alert the {$a->teacher} or the site administrator.<br>Payment status: "{$a->payment_status}"';
$string['messageprovider:payumoney_enrolment'] = 'User enrolment';
$string['processexpirationstask'] = 'Process expiration for PayU';
$string['syncenrolmentstask'] = 'Synchronize PayU enrolments task';
$string['mat'] = 'Configuration section';
$string['mat_desc'] = 'Configuration and maintenance';
$string['clean'] = 'Empty database check';
$string['clean_desc'] = 'In order for payment registrations to occur only once, a temporary data repository is generated. Checking this check will clear the temporary records, and when executing the plugin, registrations will be made again based on the period chosen in the item (periodmp).';
$string['viewreports'] = 'View reports';
$string['viewreports_desc'] = 'Allow users to view payment and enrollment reports.';
$string['payment_id'] = 'Payment ID';
$string['fullname'] = 'Full Name';
$string['email'] = 'Email';
$string['amount'] = 'Paid Amount';
$string['tax'] = 'Tax';
$string['payment_status'] = 'Payment Status';
$string['payment_date'] = 'Payment Date';
$string['reporttitle'] = 'PayU Transactions Report';
$string['reportheading'] = 'PayU Transactions Details';
$string['selectformat'] = 'Select format';
$string['downloadexcel'] = 'Download in Excel format';
$string['downloadods'] = 'Download in OpenOffice format';
$string['downloadtext'] = 'Download in text format';
$string['download'] = 'Download';
$string['norecords'] = 'No records available';
$string['discountname'] = 'Discount Name';
$string['discountvalue'] = 'Discount Value';
$string['adddiscount'] = 'Add Discount';
$string['nodiscountsfound'] = 'No discounts found';
$string['assigndiscounts'] = 'Assign discounts';
$string['assigndiscountstoCourses'] = 'Assign discounts to courses';
$string['discountcode'] = 'Discount Code';
$string['discountpercent'] = 'Discount Percent';
$string['validfrom'] = 'Valid From';
$string['validto'] = 'Valid To';
$string['discountadded'] = 'Discount Added';
$string['discountupdated'] = 'Discount Updated';
$string['discountdeleted'] = 'Discount Deleted';
$string['editdiscount'] = 'Editar descuento';
$string['percentagediscount'] = 'Descuento porcentaje';
$string['fixeddiscount'] = 'Descuento fijo';
$string['limitedtimediscount'] = 'Descuento por tiempo limitado';
$string['discounttype'] = 'Tipo de descuento';
$string['selectdiscounttype'] = 'Select discount type';
$string['start_date'] = 'Start Date';
$string['end_date'] = 'End Date';
$string['start_date_help'] = 'Ayuda para la fecha de inicio';
$string['end_date_help'] = 'Ayuda para la fecha de fin';
$string['enable_dates'] = 'Habilitar fechas';
// en enrol/payumoney/lang/en/enrol_payumoney.php
$string['selectdiscounttype'] = 'Select discount type';
$string['percentagediscount'] = 'Percentage discount';
$string['fixeddiscount'] = 'Fixed amount discount';
$string['limitedtimediscount'] = 'Limited time discount';
$string['discountname'] = 'Discount name';
$string['description'] = 'Description';
$string['discountvalue'] = 'Discount value';
$string['validfrom'] = 'Valid from';
$string['validto'] = 'Valid to';
$string['discountcode'] = 'Discount code';
$string['errordiscounttype'] = 'Please select a discount type.';
$string['discountduration'] = 'Discount duration';
$string['discounts'] = 'Discounts';
$string['discountupdated'] = 'Discount updated successfully';
$string['discountname'] = 'Discount name';
$string['discountvalue'] = 'Discount value';
$string['discounttype'] = 'Discount type';
$string['selectdiscounttype'] = 'Select discount type';
$string['percentagediscount'] = 'Percentage discount';
$string['fixeddiscount'] = 'Fixed amount discount';
$string['limitedtimediscount'] = 'Limited time discount';
$string['validfrom'] = 'Valid from';
$string['validto'] = 'Valid to';
$string['discountcode'] = 'Discount code';
$string['description'] = 'Description';
$string['discountperiod'] = 'Discount duration';
$string['errordiscounttype'] = 'Please select a valid discount type';

$string['coursenotfound'] = 'course notfound';

$string['discounttype_help'] = 'Selecciona el tipo de descuento que deseas aplicar. Las opciones pueden incluir descuento por porcentaje, descuento fijo, o descuento por tiempo limitado.';
$string['discountname_help'] = 'Introduce un nombre para identificar este descuento. Por ejemplo, "Verano2024".';
$string['description_help'] = 'Proporciona una descripción detallada del descuento. Puedes incluir información sobre los términos y condiciones.';
$string['discountvalue_help'] = 'Introduce el valor del descuento. Si es un porcentaje, solo incluye el número sin el signo de porcentaje.';
$string['discountduration_help'] = 'Especifica la duración del descuento. Por ejemplo, puede ser válido por 30 días desde la fecha de inicio.';
$string['validfrom_help'] = 'Selecciona la fecha de inicio desde cuando el descuento estará disponible.';
$string['validto_help'] = 'Selecciona la fecha final hasta cuando el descuento estará disponible.';
$string['discountcode_help'] = 'Si el descuento requiere un código, introdúcelo aquí. Este código deberá ser ingresado por el usuario al momento de la compra para aplicar el descuento.';
$string['generatecode'] = 'Generar código';

// Adicionalmente, si la cadena 'generatecode' se utiliza como etiqueta de botón y necesita ayuda:
$string['generatecode_help'] = 'Haz clic para generar automáticamente un código de descuento único. Este código puede ser compartido con potenciales compradores.';
