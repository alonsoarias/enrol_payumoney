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

 require_once(__DIR__.'/../../config.php');
 require_login();
 require_capability('moodle/site:config', context_system::instance());
 
 // Aquí iría la lógica para manejar el formulario de descuentos
 // y la visualización de descuentos existentes.
 
 echo $OUTPUT->header();
 echo $OUTPUT->heading('Gestión de Descuentos');
 
 // Formulario de descuentos y lista de descuentos existentes
 
 echo $OUTPUT->footer();
 