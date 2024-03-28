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



require("../../config.php");
require_once("lib.php");
global $DB, $CFG;

require_login();

$plugin = enrol_get_plugin('payumoney');
$ApiKey = $plugin->get_config('API_key');
$merchant_id = optional_param('merchantId', '', PARAM_INT); //INT
$transactionState = optional_param('transactionState', '', PARAM_INT); //INT
$cus = optional_param('cus', '', PARAM_INT);
$lapTransactionState = optional_param('lapTransactionState', '', PARAM_TEXT);
$referenceCode = optional_param('referenceCode', '', PARAM_INT); //INT
$transactionId = optional_param('transactionId', '', PARAM_TEXT);
$lapPaymentMethod = optional_param('lapPaymentMethod', '', PARAM_TEXT);
$firma = optional_param('signature', '', PARAM_TEXT);
$TX_VALUE = optional_param('TX_VALUE', '', PARAM_TEXT); //FLOAT
$New_value = number_format($TX_VALUE, 1, '.', '');
$TX_TAX = optional_param('TX_TAX', '', PARAM_FLOAT);
$currency = optional_param('currency', '', PARAM_TEXT);
$reference_pol = optional_param('reference_pol', '', PARAM_INT);
$extra1 = optional_param('extra1', '', PARAM_TEXT);
$pseBank = optional_param('pseBank', '', PARAM_TEXT);
$mensaje = optional_param('message', '', PARAM_TEXT);
$description = optional_param('description', '', PARAM_TEXT);
list($courseid, $userid, $instanceid, $contextid) = explode("-", $extra1);
$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
$firmacreada = md5($firma_cadena);



if ($transactionState == 4) {
	$estadoTx = "Transacción aprobada";
} else if ($transactionState == 6) {
	$estadoTx = "Transacción rechazada";
} else if ($transactionState == 104) {
	$estadoTx = "Error";
} else if ($transactionState == 7) {
	$estadoTx = "Transacción pendiente";
} else {
	$estadoTx = $mensaje;
}



$enrolpayumoney = new stdClass();
$enrolpayumoney->item_name = $description;
$enrolpayumoney->courseid = $courseid;
$enrolpayumoney->userid = $userid;
$enrolpayumoney->instanceid = $instanceid;
$enrolpayumoney->amount = $TX_VALUE;
$enrolpayumoney->tax = $TX_TAX;
$enrolpayumoney->payment_status = $lapTransactionState;
$enrolpayumoney->trans_id = $transactionId;
$enrolpayumoney->payment_id = $reference_pol;
$enrolpayumoney->auth_json = json_encode($_REQUEST);
$enrolpayumoney->timeupdated = time();
$enrolpayumoney->document = $USER->profile['N_document'];

try {
	if (
		strtoupper($firma) == strtoupper($firmacreada) &&
		$enrolpayumoney->payment_status == "APPROVED" &&
		$transactionState == 4
	) {

		api_rest($enrolpayumoney->document, $enrolpayumoney->payment_status, $enrolpayumoney->amount);

		$ret1 = $DB->insert_record(
			'enrol_payumoney',
			$enrolpayumoney,
			true
		);


		redirect(
			new moodle_url(
				'update.php',
				array('id' => $ret1)
			),
			get_string('paymentconfirm', 'enrol_payumoney', $enrolpayumoney),
			10
		);
	} else {
		$course = $DB->get_record(
			"course",
			array("id" => $courseid),
			"*",
			MUST_EXIST
		);


		$ret1 = $DB->insert_record(
			'enrol_payumoney',
			$enrolpayumoney,
			true
		);

		$fullname = $course->fullname;
		$a = new stdClass();
		$a->teacher = get_string('defaultcourseteacher');
		$a->fullname = $fullname;
		$a->payment_status = $enrolpayumoney->payment_status;

		redirect(
			'/my',
			get_string('paymentsorry', 'enrol_payumoney', $a)
		);
	}
} catch (Exception $e) {
	echo get_string('errorinsert', 'enrol_payumoney');
}
function api_rest($document, $status, $amount)
{

	$curl = curl_init();
	$data = array(
		'document' => $document,
		'status' => $status,
		'amount' => $amount
	);
	$payload = json_encode($data);
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.masterslatam.com/postMasters',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $payload,
		CURLOPT_HTTPHEADER => array(
			'Content-Type: text/plain'
		),
	));

	$response = curl_exec($curl);

	//close cURL resource
	curl_close($curl);
	return $response;
}
