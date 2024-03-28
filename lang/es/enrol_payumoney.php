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
$string['pluginname_desc'] = 'El m&oacute;dulo PayU Money le permite configurar cursos gestionando su matriculaci&oacute;n mediante un pago, si el costo de cualquier curso es cero, no se les pedir&aacute; a los estudiantes realizar pago por la entrada, en general para todo el sitio se puede establecer&aacute;n valor como predeterminado, tenga en cuenta que la configuraci&oacute;n en cada curso anula el costo definido para el sitio.';
$string['owner'] = 'innovandoweb.com';
$string['descriptionower'] = 'PayU Money es desarrolado y mantenido por innovandoweb.com';
$string['nocost'] = 'No hay un valor definido, debe actualizar el costo o cambiar el m&eacute;todo de inscripci&oacute;n';
$string['p_cust_id_cliente'] = 'Identificador de comerciante.';
$string['p_key'] = 'Llave del Integrador de comerciante.';
$string['public_key'] = 'Llave publica de comerciante.';
$string['tax'] = 'Impuesto $';
$string['paycourse'] = 'Este curso requiere pago de matricula.';
$string['merchantsalt'] = 'salto de transacci&oacute;n';
$string['mailadmins'] = 'Notificar al administador';
$string['mailstudents'] = 'Notificar a estudiantes';
$string['mailteachers'] = 'Notificar a docentes';
$string['expiredaction'] = 'Expiraci&oacute;n de matricula';
$string['expiredaction_help'] = 'Seleccione una acci&oacute;n para llevar a cabo cuando caduque la inscripci&oacute;n de usuarios. Tenga en cuenta que algunos datos y configuraciones del usuario se eliminan del curso durante la desmatriculaci&oacute;n';
$string['cost'] = 'Costo de inscripci&oacute;n al curso';
$string['costerror'] = 'El costo es num&eacute;rico';
$string['costorkey'] = 'Seleccione uno de los métodos de matriculac&oacute;n';
$string['currency'] = 'Moneda';
$string['assignrole'] = 'Asignar role';
$string['defaultrole'] = 'Rol asignado por defecto';
$string['defaultrole_desc'] = 'Seleccione el rol que ser&aacute; asignado a los usuarios durante el pago de matriculaci&oacute;n';
$string['enrolenddate'] = 'Fecha de cierre';
$string['enrolenddate_help'] = 'Si se activa, los usuarios pueden matricularse hasta esta fecha';
$string['enrolenddaterror'] = 'La fecha de finalizaci&oacute;n de matricula no puede ser anterior a la fecha de inicio';
$string['enrolperiod'] = 'Duraci&oacute;n de matricula';
$string['enrolperiod_desc'] = 'Duraci&oacute;n de la matricula por defecto el valor 0 es ilimitado';
$string['enrolperiod_help'] = 'Si se desactiva la matricula ser&aacute; por tiempo ilimitado';
$string['enrolstartdate'] = 'Fecha de inicio';
$string['enrolstartdate_help'] = 'Si se activa los usuarios pueden matricularse desde esta fecha solamente';
$string['expiredaction'] = 'Acciones sobre la expiraci&oacute;n de la matricula';
$string['expiredaction_help'] = 'Durante la desmatriculaci&oacute;n se borrar&aacute;n los aportes de los usuarios';
$string['payumoney:config'] = 'Configure la instancia de matriculaci&oacute;n PayU Money.';
$string['payumoney:manage'] = 'Administrar usuarios matriculados';
$string['payumoney:unenrol'] = 'Desmatricular usuarios del curso';
$string['payumoney:unenrolself'] = 'Des-inscribirse (darse de baja) de baja del curso';
$string['status_desc'] = 'Permitir a los usuarios matricularse en un curso mediante PayU Money.';
$string['unenrolselfconfirm'] = '¿Realmente desea desmtricularse del curso "{$a}"?';
$string['status'] = 'Permitir Matriculaci&oacute;n PayU Money.';
$string['errorinsert'] = 'Error al intentar el registro del pago';
$string['privacy:metadata:enrol_payumoney:payu_money:item_name'] = 'Descripcion.';
$string['privacy:metadata:enrol_payumoney:payu_money:courseid'] = 'Identificador de curso.';
$string['privacy:metadata:enrol_payumoney:payu_money:userid'] = 'Identificador de usuario.';
$string['privacy:metadata:enrol_payumoney:payu_money:instanceid'] = 'Identificador de instancia.';
$string['privacy:metadata:enrol_payumoney:payu_money:amount'] = 'Valor del curso.';
$string['privacy:metadata:enrol_payumoney:payu_money:tax'] = 'Impuesto.';
$string['privacy:metadata:enrol_payumoney:payu_money:paymen_status'] = 'Estado de la transaccion.';
$string['privacy:metadata:enrol_payumoney:payu_money:trans_id'] = 'Identificador de transaccion.';
$string['privacy:metadata:enrol_payumoney:payu_money:payment_id'] = 'Identificador de pago.';
$string['privacy:metadata:enrol_payumoney:payu_money:auth_json'] = 'Cadena completa de pago.';
$string['privacy:metadata:enrol_payumoney:payu_money:timeupdated'] = 'Momento en el que se registro el pago.';
$string['privacy:metadata:enrol_payumoney:payu_money'] = 'El plugin de Inscripcion PayU Money transmite datos del usuario de Moodle hacia el sitio web PayU Money.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney'] = 'Informacion para inscripciones PayU Money.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:item_name'] = 'Descripcion.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:courseid'] = 'Identificador de curso.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:userid'] = 'Identificador de usuario.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:instanceid'] = 'Identificador de instancia.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:amount'] = 'Valor del curso.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:tax'] = 'Impuesto.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_status'] = 'Estado de la transaccion.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:trans_id'] = 'Identificador de transaccion.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_id'] = 'Identificador de pago.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:auth_json'] = 'Cadena completa de pago.';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:timeupdated'] = 'Momento en el que se registro el pago.';
$string['paymentconfirm'] = 'Curso pagado, resumen: <div id="idpagopayumoney"><br>curso: "{$a->item_name}"<br>Valor: "{$a->amount}"<br>Estado: "{$a->payment_status}"<br>Impuesto: "{$a->tax}"<br></div>';
$string['paymentconfirm'] = 'Curso pagado, resumen: <div id="idpagopayumoney"><br>curso: "{$a->item_name}"<br>Valor: "{$a->amount}"<br>Estado: "{$a->payment_status}"<br>Impuesto: "{$a->tax}"<br></div>';
$string['paymentsorry'] = '¡Gracias por tu pago! Lamentablemente, su pago no se ha procesado por completo y no esta registrado para ingresar al curso "{$a->fullname}".<br>si continua teniendo poblemas, por favor avise al docente: {$a->teacher} o al administrador del sitio.<br>Estado del pago: "{$a->payment_status}"<br>';

$string['messageprovider:payumoney_enrolment'] = 'Usuario matriculado';
$string['processexpirationstask'] = 'Trabajo de enviar notificaci&oacute;n de caducidades de inscripiones para PayU';
$string['syncenrolmentstask'] = 'Trabajo para sincronizar inscripciones PayU';
$string['mat'] = 'Secci&oacute;n de configuraci&oacute;n.';
$string['mat_desc'] = 'Opciones de configuraci&oacute;n y mantenimiento.';
$string['clean'] = 'Liberar base de datos de checkeo.';
$string['clean_desc'] = 'Para que las matriculaciones de los pagos ocurran una sola vez se genera un repositorio de datos temporal, al marcar este check se limpiaran los registros temporales y al ejecutar el plugin se realizaran nuevamente matriculaciones con base al periodo elegido en el &iacute;tem (periodmp).';
$string['managediscounts'] = 'Gestionar descuentos';
$string['viewreports'] = 'Ver informes';
// Descripciones adicionales para las capacidades
$string['managediscounts_desc'] = 'Permitir a los usuarios gestionar descuentos en las tasas de inscripción de los cursos.';
$string['viewreports_desc'] = 'Permitir a los usuarios ver informes de pagos e inscripciones.';
$string['payment_id'] = 'ID de Pago';
$string['fullname'] = 'Nombre completo';
$string['email'] = 'Email';
$string['amount'] = 'Monto Pagado';
$string['tax'] = 'Impuesto';
$string['payment_status'] = 'Estado del Pago';
$string['payment_date'] = 'Fecha de Pago';
// Añade cadenas de idioma para los campos adicionales aquí, si es necesario.

