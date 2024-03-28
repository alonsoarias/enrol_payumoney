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
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Upgrade code for install
 *
 * @package enrol_payu
 * @copyright 2019 Jonathan L�pez <asesor@innovandoweb.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/*
 * Upgrade the untoken oauth2 plugin.
 *
 * @param int $oldversion The old version of the user tours plugin
 * @return bool
 */
/**
 *
 * @param number $oldversion
 * @return boolean
 */
function xmldb_enrol_payumoney_upgrade($oldversion)
{
    global $DB;
    $dbman = $DB->get_manager();
    
    // upgrade function.
    if ($oldversion < 2022021800) {

        // Define table enrol_mpcheckoutpro_mat to be created.
        $table = new xmldb_table('enrol_payumoney_mat');

        // Adding fields to table enrol_payumoney_mat.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table enrol_payumoney_mat.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, [
            'id'
        ]);

        // Conditionally launch create table for enrol_payumoney_mat.
        try {
            if (! $dbman->table_exists($table)) {
                $dbman->create_table($table);
            }
        } catch (Exception $e) {
            echo "Error generado: $e";
        }

        // Mpcheckoutpro savepoint reached.
        upgrade_plugin_savepoint(true, 2022021800, 'enrol', 'payumoney');
    }

    if ($oldversion < 2022021801) {
        // Mpcheckoutpro savepoint reached.
        upgrade_plugin_savepoint(true, 2022021801, 'enrol', 'payumoney');
    }
    if ($oldversion < 2021010107) { // Change this to your version
        
        // Define the new table
        $table = new xmldb_table('enrol_payumoney_discounts');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('discount_percent', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, null);
        $table->add_field('valid_from', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('valid_to', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        
        // Check if the table already exists
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Update the version number
        upgrade_mod_savepoint(true, 2021010107, 'enrol_payumoney');
    }

    return true;
}

