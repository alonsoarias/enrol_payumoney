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

require_login();

global $DB,$USER,$CFG;

$merchantkey = $this->get_config('API_key');
$merchantId = $this->get_config('merchantId');
$amount =  $instance->cost; //cost
$productinfo = $coursefullname;
$label = "Pay Now";
$tax = 0;
$taxReturnBase = 0;
$accountId = $this->get_config('accountId');
$instance->currency = $instance->currency;

    $url = $this->get_config('urlprod');
  
    $testmode = "0";
    $buyerEmail = $USER->email;
    //$referenceCode = $instance->name;//rand solo para pruebas
    $referenceCode = $instance->courseid.$USER->id.rand();
    $signature = hash('md5',$merchantkey.'~'.$merchantId.'~'.$referenceCode.'~'.$amount.'~'.$instance->currency);
    
$_SESSION['timestamp'] = $timestamp = time();
$udf1 = $instance->courseid.'-'.$USER->id.'-'.$instance->id.'-'.$context->id;
$enrolperiod = $instance->enrolperiod;//extra2
$courseid = $instance->courseid;//extra1
?>
<div align="center" id="content-payu">
<p><b><?php echo get_string('paycourse','enrol_payumoney'); ?></b></p>
<p><b><?php echo $instancename; ?></b></p>
<p><b><?php echo get_string("cost").": {$instance->currency} {$localisedcost}"; ?></b></p>
<div align="center" id=content-payu-img>
<p>&nbsp;</p>
<p><img alt="PayUMoney" src="<?php echo $CFG->wwwroot; ?>/enrol/payumoney/pix/PayU_CO.png" style="width:80%" /></p>
<p>&nbsp;</p>
<p>
	<form method="post" action="<?php echo $url; ?>" >
		<input type="hidden" name="merchantId" value="<?php echo $merchantId; ?>"/>
		<input type="hidden" name="referenceCode" value="<?php echo $referenceCode; ?>"/>
		<input type="hidden" name="accountId" value="<?php echo $accountId;?>"/>
		<input type="hidden" name="description" value="<?php echo $productinfo;?>"/>
		<input name="amount"        type="hidden"  value="<?php echo $amount;?>"   >
		<input name="tax"           type="hidden"  value="<?php echo $tax;?>"  >
		<input name="taxReturnBase" type="hidden"  value="<?php echo $taxReturnBase;?>" >
		<input type="hidden" name="currency" value="<?php echo $instance->currency;?>"/>
		<input type="hidden" name="signature" value="<?php echo $signature;?>"/>
		<input type="hidden" name="buyerFullName" value="<?php echo $USER->firstname.' '.$USER->lastname;?>"/>
		<input type="hidden" name="buyerEmail" value="<?php echo $buyerEmail;?>"/>
		<input type="hidden" name="test" value="<?php echo $testmode;?>"/>
		<input type="hidden" name="extra1" value="<?php echo $udf1;?>"/>
		<input type="hidden" name="extra2" value="<?php echo $instance->id;?>"/>
		<input type="hidden" name="extra3" value="<?php echo $enrolperiod;?>"/>
		<input name="confirmationUrl"    type="hidden"  value="<?php echo $CFG->wwwroot;?>/enrol/payumoney/ipn.php" >	
		<input type="hidden" name="responseUrl" value="<?php echo $CFG->wwwroot;?>/enrol/payumoney/response.php"/> 
		<input type="submit" id="sub_button" value="" />
	</form>
</p>
</div></div>

