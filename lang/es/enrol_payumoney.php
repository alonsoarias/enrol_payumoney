<?php
// Este archivo es parte de Moodle - http://moodle.org/
//
// Moodle es un software gratuito: usted puede redistribuirlo y/o modificarlo
// bajo los términos de la Licencia Pública General GNU publicada por
// la Free Software Foundation, ya sea la versión 3 de la Licencia, o
// (a su elección) cualquier versión posterior.
//
// Moodle se distribuye con la esperanza de que sea útil,
// pero SIN NINGUNA GARANTÍA; incluso sin la garantía implícita de
// COMERCIABILIDAD o IDONEIDAD PARA UN PROPÓSITO PARTICULAR.
// Vea la Licencia Pública General de GNU para más detalles.
//
// Debería haber recibido una copia de la Licencia Pública General de GNU
// junto con Moodle. Si no es así, consulte <http://www.gnu.org/licenses/>.

/**
 * Cadenas de idioma.
 *
 * Este archivo lista las cadenas de idioma relacionadas con tool_untoken_oauth2.
 *
 * @package enrol_payumoney
 * @copyright 2019 Jonathan Lopez <asesor@innovandoweb.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 o posterior
 */
$string['pluginname'] = 'PayU Money';
$string['pluginname_desc'] = 'El módulo PayU Money te permite configurar cursos de pago. Si el costo de algún curso es cero, entonces no se pide a los estudiantes que paguen para entrar. Hay un costo a nivel de sitio que estableces aquí como un valor predeterminado para todo el sitio y luego una configuración de curso que puedes establecer para cada curso individualmente. El costo del curso anula el costo del sitio.';
$string['owner'] = 'innovandoweb.com';
$string['descriptionower'] = 'PayU Money desarrollado y mantenido por innovandoweb.com';
$string['nocost'] = 'No hay valor definido, por favor actualiza el valor o cambia el método de inscripción';
$string['merchantid'] = 'ID de comerciante';
$string['accountid'] = 'ID de cuenta';
$string['tax'] = 'Impuesto $';
$string['paycourse'] = 'Este curso requiere un pago para ingresar.';
$string['merchantapi'] = 'API de comerciante';
$string['merchantkey'] = 'Clave de comerciante';
$string['merchantsalt'] = 'Sal de transacción';
$string['urlprod'] = 'URL de PayU WebCheckout';
$string['mailadmins'] = 'Notificar a los administradores';
$string['mailstudents'] = 'Notificar a los estudiantes';
$string['mailteachers'] = 'Notificar a los profesores';
$string['expiredaction'] = 'Acción de vencimiento de la inscripción';
$string['expiredaction_help'] = 'Selecciona la acción a realizar cuando la inscripción del usuario expire. Ten en cuenta que algunos datos y configuraciones de usuario se eliminan del curso durante la desinscripción del curso.';
$string['cost'] = 'Costo de inscripción';
$string['costerror'] = 'El costo de la inscripción no es numérico';
$string['costorkey'] = 'Por favor elige uno de los siguientes métodos de inscripción.';
$string['currency'] = 'Moneda';
$string['assignrole'] = 'Asignar rol';
$string['defaultrole'] = 'Asignación de rol predeterminado';
$string['defaultrole_desc'] = 'Selecciona el rol que se debe asignar a los usuarios durante las inscripciones de PayUMoney';
$string['enrolenddate'] = 'Fecha de finalización';
$string['enrolenddate_help'] = 'Si está habilitado, los usuarios pueden inscribirse hasta esta fecha solamente.';
$string['enrolenddaterror'] = 'La fecha de finalización de la inscripción no puede ser anterior a la fecha de inicio';
$string['enrolperiod'] = 'Duración de la inscripción';
$string['enrolperiod_desc'] = 'Duración predeterminada de tiempo que la inscripción es válida. Si se establece en cero, la duración de la inscripción será ilimitada por defecto.';
$string['enrolperiod_help'] = 'Duración de tiempo que la inscripción es válida, comenzando desde el momento en que el usuario se inscribe. Si está deshabilitado, la duración de la inscripción será ilimitada.';
$string['enrolstartdate'] = 'Fecha de inicio';
$string['enrolstartdate_help'] = 'Si está habilitado, los usuarios pueden inscribirse a partir de esta fecha solamente.';
$string['expiredaction'] = 'Acción de vencimiento de la inscripción';
$string['expiredaction_help'] = 'Selecciona la acción a realizar cuando la inscripción del usuario expire. Ten en cuenta que algunos datos y configuraciones de usuario se eliminan del curso durante la desinscripción del curso.';
$string['payumoney:config'] = 'Configurar instancias de inscripción de PayUMoney';
$string['payumoney:manage'] = 'Administrar usuarios inscritos';
$string['payumoney:unenrol'] = 'Desinscribir usuarios del curso';
$string['payumoney:unenrolself'] = 'Desinscribirse del curso (estudiante)';
$string['status'] = 'Permitir inscripciones de PayUMoney';
$string['status_desc'] = 'Permitir que los usuarios utilicen PayUMoney para inscribirse en un curso de forma predeterminada.';
$string['unenrolselfconfirm'] = '¿Realmente deseas desinscribirte del curso "{$a}"?';
$string['errorinsert'] = 'No se pudo insertar el registro en PayU';

$string['privacy:metadata:enrol_payumoney:payu_money:item_name'] = 'Descripción';
$string['privacy:metadata:enrol_payumoney:payu_money:courseid'] = 'ID del curso';
$string['privacy:metadata:enrol_payumoney:payu_money:userid'] = 'ID de usuario';
$string['privacy:metadata:enrol_payumoney:payu_money:instanceid'] = 'ID de instancia';
$string['privacy:metadata:enrol_payumoney:payu_money:amount'] = 'Cantidad';
$string['privacy:metadata:enrol_payumoney:payu_money:tax'] = 'Impuesto';
$string['privacy:metadata:enrol_payumoney:payu_money:paymen_status'] = 'Estado del pago';
$string['privacy:metadata:enrol_payumoney:payu_money:trans_id'] = 'ID de transacción';
$string['privacy:metadata:enrol_payumoney:payu_money:payment_id'] = 'ID de pago';
$string['privacy:metadata:enrol_payumoney:payu_money:auth_json'] = 'JSON de autorización';
$string['privacy:metadata:enrol_payumoney:payu_money:timeupdated'] = 'Tiempo actualizado';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney'] = 'Información de la base de datos';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:item_name'] = 'Fecha del ítem';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:courseid'] = 'ID del curso';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:userid'] = 'ID de usuario';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:instanceid'] = 'ID de instancia';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:amount'] = 'Cantidad';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:tax'] = 'Impuesto';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_status'] = 'Estado del pago';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:trans_id'] = 'ID de transacción';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_id'] = 'ID de pago';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:auth_json'] = 'JSON de autorización';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:timeupdated'] = 'Tiempo actualizado';
$string['privacy:metadata:enrol_payumoney:payu_money'] = 'La extensión de PayU Money envía información al sitio web de PayU Money.';
$string['paymentconfirm'] = 'Resumen del curso pagado: <div id="resume"><br>Curso: "{$a->item_name}"<br>Valor: "{$a->amount}"<br>Estado: "{$a->payment_status}"<br>Impuesto: "{$a->tax}"<br></div>';
$string['paymentsorry'] = '¡Gracias por tu pago! Desafortunadamente, tu pago aún no ha sido procesado completamente y aún no estás registrado para ingresar al curso "{$a->fullname}". Pero si continúas teniendo problemas, por favor informa a {$a->teacher} o al administrador del sitio.<br>Estado del pago: "{$a->payment_status}"';

$string['messageprovider:payumoney_enrolment'] = 'Inscripción de usuario';
$string['processexpirationstask'] = 'Proceso de vencimiento para PayU';
$string['syncenrolmentstask'] = 'Tarea de sincronización de inscripciones de PayU';
$string['mat'] = 'Sección de configuración';
$string['mat_desc'] = 'Configuración y mantenimiento';
$string['clean'] = 'Revisión de base de datos vacía';
$string['clean_desc'] = 'Para que los registros de pago ocurran solo una vez, se genera un repositorio de datos temporales. Marcar esta casilla limpiará los registros temporales y, al ejecutar el complemento, se realizarán inscripciones nuevamente en función del período elegido en el ítem (periodmp).';
$string['managediscounts'] = 'Administrar descuentos';
$string['viewreports'] = 'Ver informes';
// Descripciones adicionales para las capacidades
$string['managediscounts_desc'] = 'Permite a los usuarios administrar descuentos para las tarifas de inscripción en cursos.';
$string['viewreports_desc'] = 'Permite a los usuarios ver informes de pagos e inscripciones.';
$string['payment_id'] = 'ID de Pago';
$string['fullname'] = 'Nombre Completo';
$string['email'] = 'Correo Electrónico';
$string['amount'] = 'Monto Pagado';
$string['tax'] = 'Impuesto';
$string['payment_status'] = 'Estado del Pago';
$string['payment_date'] = 'Fecha del Pago';
// Agrega cadenas de idioma para campos adicionales aquí, si es necesario.
$string['reporttitle'] = 'Título del Informe';
$string['reportheading'] = 'Encabezado del Informe';
$string['report'] = 'Informe';

// Archivo: enrol_payumoney.php

$string['downloadexcel'] = 'Descargar en formato Excel';
$string['downloadooo'] = 'Descargar en formato OpenOffice';
$string['downloadtext'] = 'Descargar en formato de texto';
$string['download'] = 'Descargar';
// en/enrol_payumoney.php

$string['norecords'] = 'No hay registros disponibles';
