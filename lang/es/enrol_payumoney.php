<?php
// Este archivo es parte de Moodle - http://moodle.org/
//
// Moodle es software libre: usted puede redistribuirlo y/o modificarlo
// bajo los términos de la Licencia Pública General GNU publicada por
// la Fundación Free Software; ya sea la versión 3 de la Licencia, o
// (a su elección) cualquier versión posterior.
//
// Moodle se distribuye con la esperanza de que sea útil,
// pero SIN NINGUNA GARANTÍA; incluso sin la garantía implícita de
// COMERCIALIZACIÓN o IDONEIDAD PARA UN PROPÓSITO PARTICULAR.
// Vea la Licencia Pública General GNU para más detalles.
//
// Debería haber recibido una copia de la Licencia Pública General GNU
// junto con Moodle.  Si no, consulte <http://www.gnu.org/licenses/>.

/**
 * Cadenas de idioma.
 *
 * Este archivo lista todas las cadenas de idioma relacionadas con el plugin de inscripción de PayU Money.
 *
 * @package    enrol_payumoney
 * @copyright  2019 Jonathan Lopez <asesor@innovandoweb.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'PayU Money';
$string['pluginname_desc'] = 'El módulo de PayU Money te permite configurar cursos de pago. Si el costo de cualquier curso es cero, entonces a los estudiantes no se les pide que paguen para entrar. Hay un costo a nivel de sitio que estableces aquí como un valor predeterminado para todo el sitio y luego una configuración de curso que puedes establecer para cada curso individualmente. El costo del curso anula el costo del sitio.';
$string['nocost'] = 'No se ha definido ningún valor, por favor actualiza el valor o cambia el método de inscripción';
$string['merchantid'] = 'ID de Comerciante';
$string['accountid'] = 'ID de Cuenta';
$string['tax'] = 'Impuesto $';
$string['paycourse'] = 'Este curso requiere pago para ingresar.';
$string['merchantapi'] = 'API de Comerciante';
$string['merchantkey'] = 'Clave de Comerciante';
$string['merchantsalt'] = 'Clave de Transacción';
$string['urlprod'] = 'URL de PayU WebCheckout';
$string['mailadmins'] = 'Notificar a los administradores';
$string['mailstudents'] = 'Notificar a los estudiantes';
$string['mailteachers'] = 'Notificar a los profesores';
$string['expiredaction'] = 'Acción de expiración de la inscripción';
$string['expiredaction_help'] = 'Selecciona la acción a realizar cuando expire la inscripción del usuario. Ten en cuenta que algunos datos y configuraciones del usuario se eliminan del curso durante la desinscripción del curso.';
$string['cost'] = 'Costo de la inscripción';
$string['costerror'] = 'El costo de la inscripción no es numérico';
$string['costorkey'] = 'Por favor, elige uno de los siguientes métodos de inscripción.';
$string['currency'] = 'Moneda';
$string['assignrole'] = 'Asignar rol';
$string['defaultrole'] = 'Asignación de rol predeterminada';
$string['defaultrole_desc'] = 'Selecciona el rol que se debe asignar a los usuarios durante las inscripciones de PayUMoney';
$string['enrolenddate'] = 'Fecha de finalización';
$string['enrolenddate_help'] = 'Si está habilitado, los usuarios pueden inscribirse hasta esta fecha únicamente.';
$string['enrolenddaterror'] = 'La fecha de finalización de la inscripción no puede ser anterior a la fecha de inicio';
$string['enrolperiod'] = 'Duración de la inscripción';
$string['enrolperiod_desc'] = 'Duración predeterminada de tiempo durante el cual la inscripción es válida. Si se establece en cero, la duración de la inscripción será ilimitada por defecto.';
$string['enrolperiod_help'] = 'Duración de tiempo durante la cual la inscripción es válida, comenzando desde el momento en que el usuario se inscribe. Si está deshabilitado, la duración de la inscripción será ilimitada.';
$string['enrolstartdate'] = 'Fecha de inicio';
$string['enrolstartdate_help'] = 'Si está habilitado, los usuarios pueden inscribirse a partir de esta fecha únicamente.';
$string['expiredaction'] = 'Acción de expiración de la inscripción';
$string['expiredaction_help'] = 'Selecciona la acción a realizar cuando expire la inscripción del usuario. Ten en cuenta que algunos datos y configuraciones del usuario se eliminan del curso durante la desinscripción del curso.';
$string['payumoney:config'] = 'Configurar instancias de inscripción de PayUMoney';
$string['payumoney:manage'] = 'Gestionar usuarios inscritos';
$string['payumoney:unenrol'] = 'Desinscribir usuarios del curso';
$string['payumoney:unenrolself'] = 'Desinscribirme del curso (estudiante)';
$string['status'] = 'Permitir inscripciones de PayUMoney';
$string['status_desc'] = 'Permite que los usuarios utilicen PayUMoney para inscribirse en un curso de forma predeterminada.';
$string['unenrolselfconfirm'] = '¿Realmente quieres desinscribirte del curso "{$a}"?';
$string['errorinsert'] = 'No se puede insertar el registro en PayUMoney';
$string['privacy:metadata:enrol_payumoney:payu_money:item_name'] = 'Descripción';
$string['privacy:metadata:enrol_payumoney:payu_money:courseid'] = 'ID del curso';
$string['privacy:metadata:enrol_payumoney:payu_money:userid'] = 'ID de usuario';
$string['privacy:metadata:enrol_payumoney:payu_money:instanceid'] = 'ID de la instancia';
$string['privacy:metadata:enrol_payumoney:payu_money:amount'] = 'Cantidad';
$string['privacy:metadata:enrol_payumoney:payu_money:tax'] = 'Impuesto';
$string['privacy:metadata:enrol_payumoney:payu_money:paymen_status'] = 'Estado del pago';
$string['privacy:metadata:enrol_payumoney:payu_money:trans_id'] = 'ID de transacción';
$string['privacy:metadata:enrol_payumoney:payu_money:payment_id'] = 'ID de pago';
$string['privacy:metadata:enrol_payumoney:payu_money:auth_json'] = 'JSON de autenticación';
$string['privacy:metadata:enrol_payumoney:payu_money:timeupdated'] = 'Hora de actualización';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney'] = 'Información de la base de datos';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:item_name'] = 'Fecha del artículo';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:courseid'] = 'ID del curso';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:userid'] = 'ID de usuario';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:instanceid'] = 'ID de la instancia';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:amount'] = 'Cantidad';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:tax'] = 'Impuesto';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_status'] = 'Estado del pago';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:trans_id'] = 'ID de transacción';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:payment_id'] = 'ID de pago';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:auth_json'] = 'JSON de autenticación';
$string['privacy:metadata:enrol_payumoney:enrol_payumoney:timeupdated'] = 'Hora de actualización';
$string['privacy:metadata:enrol_payumoney:payu_money'] = 'La extensión de PayU Money envía información al sitio web de PayU Money.';
$string['paymentconfirm'] = 'Resumen del curso pagado: <div id="resume"><br>Curso: "{$a->item_name}"<br>Valor: "{$a->amount}"<br>Estado: "{$a->payment_status}"<br>Impuesto: "{$a->tax}"<br></div>';
$string['paymentsorry'] = '¡Gracias por tu pago! Desafortunadamente, tu pago aún no ha sido procesado completamente y aún no estás registrado para ingresar al curso "{$a->fullname}". Pero si continúas teniendo problemas, por favor avisa al {$a->teacher} o al administrador del sitio.<br>Estado del pago: "{$a->payment_status}"';
$string['messageprovider:payumoney_enrolment'] = 'Inscripción de usuario';
$string['processexpirationstask'] = 'Procesar expiraciones para PayU';
$string['syncenrolmentstask'] = 'Tarea de sincronización de inscripciones de PayU';
$string['mat'] = 'Sección de configuración';
$string['mat_desc'] = 'Configuración y mantenimiento';
$string['clean'] = 'Comprobación de base de datos vacía';
$string['clean_desc'] = 'Para que los registros de pago ocurran solo una vez, se genera un repositorio de datos temporales. Marcar esta casilla limpiará los registros temporales y, al ejecutar el complemento, se realizarán nuevos registros basados en el período elegido en el artículo (periodmp).';
$string['viewreports'] = 'Detalles de las Transacciones de PayU';
$string['payment_id'] = 'ID de Pago';
$string['fullname'] = 'Nombre Completo';
$string['email'] = 'Correo Electrónico';
$string['amount'] = 'Monto Pagado';
$string['tax'] = 'Impuesto';
$string['payment_status'] = 'Estado del Pago';
$string['payment_date'] = 'Fecha del Pago';
$string['course_name'] = 'Nombre del curso';
$string['reporttitle'] = 'Informe de Transacciones de PayU';
$string['reportheading'] = 'Detalles de las Transacciones de PayU';
$string['selectformat'] = 'Seleccionar formato';
$string['downloadexcel'] = 'Descargar en formato Excel';
$string['downloadods'] = 'Descargar en formato OpenOffice';
$string['downloadtext'] = 'Descargar en formato de texto';
$string['download'] = 'Descargar';
$string['norecords'] = 'No hay registros disponibles';
$string['discountname'] = 'Nombre del Descuento';
$string['discountvalue'] = 'Valor del Descuento';
$string['adddiscount'] = 'Añadir descuento';
$string['nodiscountsfound'] = 'No se encontraron descuentos';
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
