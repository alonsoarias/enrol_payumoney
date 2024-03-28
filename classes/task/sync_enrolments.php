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
 * Syncing enrolments task.
 *
 * @package enrol_payumoney
 * @author Jonathan Lopez Garcia <asesor@innovandoweb.com>
 * @copyright innovandoweb
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace enrol_payumoney\task;

defined('MOODLE_INTERNAL') || die();

class sync_enrolments extends \core\task\scheduled_task
{

    /**
     * Name for this task.
     *
     * @return string
     */
    public function get_name()
    {
        return get_string('syncenrolmentstask', 'enrol_payumoney');
    }

    /**
     * Check enrolment data.
     */
    public function validate($courseid, $userid)
    {
        global $DB, $CFG;
        require_once ($CFG->dirroot . '/config.php');

        if ($DB->record_exists("enrol_payumoney_mat", array(
            "courseid" => $courseid,
            "userid" => $userid
        ), "*", MUST_EXIST)) {
            /**
             * Return true when register exist
             */
            return true;
        } else {
            try {
                $matData = new \StdClass();
                $matData->courseid = $courseid;
                $matData->userid = $userid;

                $DB->insert_record('enrol_payumoney_mat', $matData, true);
            } catch (Exception $e) {
                echo "Error inserting plugin validation record: $e";
            }
            /**
             * Return false when register not exist
             */
            return false;
        }
    }

    /**
     * Run task for syncing enrolments.
     */
    public function execute()
    {
        global $DB, $CFG;
        require_once ($CFG->dirroot . '/config.php');
        require_once ($CFG->dirroot . '/enrol/payumoney/lib.php');
        require_once ($CFG->libdir . '/enrollib.php');
        require_once ($CFG->libdir . '/filelib.php');

        // SDK de PayU
        $payu_sdk = $DB->get_record('config_plugins', array(
            'plugin' => 'enrol_payumoney',
            'name' => 'sdk'
        ));

        if (file_exists("/var/www/lib/PayU.php")) {
            require_once ('/var/www/lib/PayU.php');
        } else if (file_exists("C:/xampp/lib/PayU.php")) {
            require_once ('C:/xampp/lib/PayU.php');
        } else if (file_exists("C:/wampp/lib/PayU.php")) {
            require_once ('C:/wampp/lib/PayU.php');
        } else if (file_exists($payu_sdk->value)) {
            require_once $payu_sdk->value;
        } else {
            throw new Exception(get_string('sdkerr', 'enrol_payumoney'));
        }

        if (! enrol_is_enabled('payumoney')) {
            mtrace("El plugin no se encuentra activo");
            return;
        }

        $enrol = enrol_get_plugin('payumoney');
        $trace = new \text_progress_trace();
        // $enrol->sync($trace);

        $payu_apilogin = $DB->get_record('config_plugins', array(
            'plugin' => 'enrol_payumoney',
            'name' => 'API_login'
        ));

        $payu_apikey = $DB->get_record('config_plugins', array(
            'plugin' => 'enrol_payumoney',
            'name' => 'API_key'
        ));

        $payu_merchantId = $DB->get_record('config_plugins', array(
            'plugin' => 'enrol_payumoney',
            'name' => 'merchantId'
        ));

        $payu_accountId = $DB->get_record('config_plugins', array(
            'plugin' => 'enrol_payumoney',
            'name' => 'accountId'
        ));

        \PayU::$apiKey = $payu_apikey->value; // Ingrese aqui ­ su propio apiKey.
        \PayU::$apiLogin = $payu_apilogin->value; // Ingrese aqui ­ su propio apiLogin.
        \PayU::$merchantId = $payu_merchantId->value; // Ingrese aqui ­ su Id de Comercio.
        \PayU::$language = \SupportedLanguages::ES; // Seleccione el idioma.
        \PayU::$isTest = false; // Dejarlo True cuando sean pruebas.

        \Environment::setPaymentsCustomUrl('https://api.payulatam.com/payments-api/4.0/service.cgi');
        \Environment::setReportsCustomUrl('https://api.payulatam.com/reports-api/4.0/service.cgi');
        $response = \PayUReports::doPing();

        if ($response->code != "SUCCESS") {
            mtrace("No se ha podido conectar con PayU para validacion");
            return;
        }
        // echo '<pre>';
        // print_r($response);

        $transactions = $DB->get_records_menu('enrol_payumoney', $conditions = null, $sort = '', $fields = 'trans_id,auth_json', $limitfrom = 0, $limitnum = 0);

        // echo '<pre>';print_r($transactions);
        $found = 0;
        $notfound = 0;
        $is_enrolled = 0;
        echo "---------- \n";
        echo "total de registros a validar: " . sizeof($transactions);
        echo "\n";
        echo "---------- \n";
        foreach ($transactions as $key => $value) {
            echo "---------- \n";
            echo "Este es el dato de la trans_id: " . $key;
            echo "\n";
            echo "---------- \n";
            $jsonstring = json_decode($value);
            // debug
            echo $jsonstring->extra1; // 12-337-71-524
                                      // echo '<pre>';print_r($jsonstring);
            $parameters = array(
                \PayUParameters::TRANSACTION_ID => $key
            );
            $response = \PayUReports::getTransactionResponse($parameters);
            // debug
            // echo '<pre>';
            // print_r($response);
            if ($response) {
                if ($response->state == 'APPROVED' && $response->responseCode == 'APPROVED') {

                    try {

                        list ($courseid, $userid, $instanceid, $contextid) = explode("-", $jsonstring->extra1);
                        if (is_null($courseid) || is_null($userid)) {
                            echo "informacion no correspondiente a moodle \n";
                        } else {
                            /**
                             * validate old enrolments
                             */
                            if ($this->validate($courseid, $userid)) {
                                echo "Usuario ya procesado anteriormente en moodle userid:" . $userid . " courseid:" . $courseid . " \n";
                                break;
                            }

                            if ($DB->record_exists('user', array(
                                'id' => $userid,
                                'deleted' => 0
                            )) && $DB->record_exists('course', array(
                                'id' => $courseid
                            ))) {

                                $user = $DB->get_record("user", array(
                                    "id" => $userid
                                ), "*", MUST_EXIST);

                                $course = $DB->get_record("course", array(
                                    "id" => $courseid
                                ), "*", MUST_EXIST);

                                if (! $DB->record_exists("enrol", array(
                                    "id" => $instanceid,
                                    "enrol" => "payumoney",
                                    "status" => 0
                                ), "*", MUST_EXIST)) {
                                    echo "\n";
                                    echo "---------- \n";
                                    echo "La instancia de PayU asociada a este pago no existe, por favor matricule manualmente al usuario de id: " . $userid . " en el curso de id: " . $courseid;
                                    echo "\n";
                                    echo "---------- \n";
                                    $notfound ++;
                                } else {
                                    $context = \context_course::instance($courseid, MUST_EXIST);
                                    if (is_enrolled($context, $user, 'mod/assignment:submit')) {
                                        echo "---------- \n";
                                        echo "participante: " . $userid . " ya se encuentra en el curso: " . $courseid . " \n";
                                        echo "---------- \n";
                                        $is_enrolled ++;
                                    } else {

                                        // $PAGE->set_context($context);

                                        $plugin_instance = $DB->get_record("enrol", array(
                                            "id" => $instanceid,
                                            "enrol" => "payumoney",
                                            "status" => 0
                                        ), "*", MUST_EXIST);

                                        $plugin = enrol_get_plugin('payumoney');

                                        if ($plugin_instance->enrolperiod) {
                                            $timestart = time();
                                            $timeend = $timestart + $plugin_instance->enrolperiod;
                                        } else {
                                            $timestart = 0;
                                            $timeend = 0;
                                        }

                                        // Enrol user
                                        $plugin->enrol_user($plugin_instance, $userid, $plugin_instance->roleid, $timestart, $timeend);

                                        // Pass $view=true to filter hidden caps if the user cannot see them
                                        if ($users = get_users_by_capability($context, 'moodle/course:update', 'u.*', 'u.id ASC', '', '', '', '', false, true)) {
                                            $users = sort_by_roleassignment_authority($users, $context);
                                            $teacher = array_shift($users);
                                        } else {
                                            $teacher = false;
                                        }
                                        echo "---------- \n";
                                        echo "Usuario encontrado: " . $userid . "  curso encontrado: " . $courseid . "\n";
                                        echo "---------- \n";
                                        $found ++;
                                    }
                                }
                            } else {
                                echo "---------- \n";
                                echo "Usuario no encontrado: " . $userid . " o curso no encontrado: " . $courseid . "\n";
                                echo "---------- \n";
                                $notfound ++;
                            }
                        }
                    } catch (Exception $e) {
                        // echo "error ".$e;
                        continue;
                    } // fin del catch
                } // fin del response
            } else {
                echo "\n";
                echo "registro fallido";
                echo "\n";
            }
        }

        echo " \n";
        echo "proceso completado \n";
        echo "------------------- \n";
        echo "total de usuarios matriculados: " . $found . " \n";
        echo "total de usuarios no matriculados por curso, usuario o instancia de pagos en el curso no existente: " . $notfound . " \n";
        echo "total de participantes ya existentes en el curso: " . $is_enrolled . " \n";
    }
}

