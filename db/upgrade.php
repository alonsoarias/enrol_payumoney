<?php
defined('MOODLE_INTERNAL') || die();

function xmldb_enrol_payumoney_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    // Actualización para la versión 2022021800.
    if ($oldversion < 2022021800) {
        // Definición de la tabla enrol_payumoney_mat para ser creada.
        $table = new xmldb_table('enrol_payumoney_mat');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null, 'Comentario sobre el campo courseid');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null, 'Comentario sobre el campo userid');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_plugin_savepoint(true, 2022021800, 'enrol', 'payumoney');
    }

    // Actualización para añadir la tabla de descuentos (enrol_payumoney_discounts).
    if ($oldversion < 2021010107) {
        $table = new xmldb_table('enrol_payumoney_discounts');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('discount_percent', XMLDB_TYPE_NUMBER, '10, 2', null, XMLDB_NOTNULL, null, null);
        $table->add_field('valid_from', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('valid_to', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_index('courseid-index', XMLDB_INDEX_NOTUNIQUE, ['courseid']);

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_plugin_savepoint(true, 2021010107, 'enrol', 'payumoney');
    }

    return true;
}
