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
 * This files lists lang strings related to enrol_payumoney.
 *
 * @package enrol_payumoney
 * @copyright 2019 Jonathan Lopez <asesor@innovandoweb.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



require("../../config.php");
require_once("lib.php");
global $DB, $CFG;
echo '<pre>';

/*print_r($_REQUEST);
//debugfile
$file = "miarchivo.txt";
$fp = fopen($file, "w");
fwrite($fp,json_encode($_REQUEST) );
fclose($fp);
 */

$plugin = enrol_get_plugin('payumoney');
$ApiKey = $plugin->get_config('API_key');
$merchant_id = optional_param('merchant_id', '', PARAM_INT);//INT
$reference_sale = optional_param('reference_sale', '', PARAM_TEXT);//INT
$description = optional_param('description', '', PARAM_TEXT);

$extra1 = optional_param('extra1', '', PARAM_TEXT);
$TX_VALUE = optional_param('value', '', PARAM_TEXT);//FLOAT
$New_value1 = number_format($TX_VALUE, 1, '.', '');
$New_value2 = number_format($TX_VALUE, 2, '.', '');
$TX_TAX = optional_param('tax', '', PARAM_FLOAT);
$firma = optional_param('sign', '', PARAM_TEXT);
$currency = optional_param('currency', '', PARAM_TEXT);
$payment_method_id = optional_param('payment_method_id', '', PARAM_INT);
$state_pol = optional_param('state_pol', '', PARAM_INT);
$transaction_id = optional_param('transaction_id', '', PARAM_TEXT);

list($courseid,$userid,$instanceid,$contextid) = explode("-",$extra1);

$firma_cadena1 = "$ApiKey~$merchant_id~$reference_sale~$New_value1~$currency~$state_pol";
$firmacreada1 = md5($firma_cadena1);

$firma_cadena2 = "$ApiKey~$merchant_id~$reference_sale~$New_value2~$currency~$state_pol";
$firmacreada2 = md5($firma_cadena2);
echo '<pre>';
print_r("cadena1: ".$firmacreada1);
echo '<pre>';
print_r("cadena2: ".$firmacreada2);

if ($state_pol == 4 ) {
	$estadoTx = "Transacción aprobada";
}

else if ($state_pol == 6 ) {
	$estadoTx = "Transacción rechazada";
}

else if ($state_pol == 104 ) {
	$estadoTx = "Error";
}

else if ($state_pol == 7 ) {
	$estadoTx = "Transacción pendiente";
}

else {
	$estadoTx=$mensaje;
}



$enrolpayumoney = new stdClass();
$enrolpayumoney->item_name = $description;
$enrolpayumoney->courseid=$courseid;
$enrolpayumoney->userid=$userid;
$enrolpayumoney->instanceid = $instanceid;
$enrolpayumoney->amount = $TX_VALUE;
$enrolpayumoney->tax = $TX_TAX;
$enrolpayumoney->payment_status = $estadoTx;
$enrolpayumoney->trans_id = $transaction_id;
$enrolpayumoney->payment_id = $state_pol;
$enrolpayumoney->auth_json = json_encode($_REQUEST);
$enrolpayumoney->timeupdated = time();

try {
	if (strtoupper($firma) == strtoupper($firmacreada1) || strtoupper($firma) == strtoupper($firmacreada2)){
		if ($state_pol == 4){
		$ret1 = $DB->insert_record(
			'enrol_payumoney',
			$enrolpayumoney, 
			true
		);

    		redirect(new moodle_url(
	    		'update.php',
			array('id'=>$ret1)
		),
    			get_string('paymentconfirm', 'enrol_payumoney',$enrolpayumoney),
    			10
		);
		}
	}


}catch (Exception $e){
    	echo get_string('errorinsert', 'enrol_payumoney');
}

//http_response_code(200);

?>
