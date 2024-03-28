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
namespace enrol_payumoney\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy Subsystem implementation for enrol_payumoney.
 *
 * @copyright 2018 Shamim Rezaie <shamim@moodle.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements 
    // Transactions store user data.
    \core_privacy\local\metadata\provider, 

    // The payu enrolment plugin contains user's transactions.
    \core_privacy\local\request\plugin\provider, 

    // This plugin is capable of determining which users have data within it.
    \core_privacy\local\request\core_userlist_provider
{

    /**
     * Returns meta data about this system.
     *
     * @param collection $collection
     *            The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection
    {
        $collection->add_external_location_link('payulatam.com', [
            'item_name' => 'privacy:metadata:enrol_payumoney:payu_money:item_name',
            'courseid' => 'privacy:metadata:enrol_payumoney:payu_money:courseid',
            'userid' => 'privacy:metadata:enrol_payumoney:payu_money:userid',
            'instanceid' => 'privacy:metadata:enrol_payumoney:payu_money:instanceid',
            'amount' => 'privacy:metadata:enrol_payumoney:payu_money:amount',
            'tax' => 'privacy:metadata:enrol_payumoney:payu_money:tax',
            'payment_status' => 'privacy:metadata:enrol_payumoney:payu_money:paymen_status',
            'trans_id' => 'privacy:metadata:enrol_payumoney:payu_money:trans_id',
            'payment_id' => 'privacy:metadata:enrol_payumoney:payu_money:payment_id',
            'auth_json' => 'privacy:metadata:enrol_payumoney:payu_money:auth_json',
            'timeupdated' => 'privacy:metadata:enrol_payumoney:payu_money:timeupdated'
        ], 'privacy:metadata:enrol_payumoney:payu_money');

        // The enrol_payumoney has a DB table that contains user data.
        $collection->add_database_table('enrol_payumoney', [
            'item_name' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:item_name',
            'courseid' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:courseid',
            'userid' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:userid',
            'instanceid' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:instanceid',
            'amount' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:amount',
            'tax' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:tax',
            'payment_status' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:payment_status',
            'trans_id' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:trans_id',
            'payment_id' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:payment_id',
            'auth_json' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:auth_json',
            'timeupdated' => 'privacy:metadata:enrol_payumoney:enrol_payumoney:timeupdated'
        ], 'privacy:metadata:enrol_payumoney:enrol_payumoney');

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid
     *            The user to search.
     * @return contextlist The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid): contextlist
    {
        $contextlist = new contextlist();

        // Values of ep.receiver_email and ep.business are already normalised to lowercase characters by PayPal,
        // therefore there is no need to use LOWER() on them in the following query.
        $sql = "SELECT ctx.id
                  FROM {enrol_payumoney} ep
                  JOIN {enrol} e ON ep.instanceid = e.id
                  JOIN {context} ctx ON e.courseid = ctx.instanceid AND ctx.contextlevel = :contextcourse
                  JOIN {user} u ON u.id = ep.userid 
                 WHERE u.id = :userid";
        $params = [
            'contextcourse' => CONTEXT_COURSE,
            'userid' => $userid
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Get the list of users who have data within a context.
     *
     * @param userlist $userlist
     *            The userlist containing the list of users who have data in this context/plugin combination.
     */
    public static function get_users_in_context(userlist $userlist)
    {
        $context = $userlist->get_context();

        if (! $context instanceof \context_course) {
            return;
        }

        // Values of ep.receiver_email and ep.business are already normalised to lowercase characters by PayPal,
        // therefore there is no need to use LOWER() on them in the following query.
        $sql = "SELECT u.id
                  FROM {enrol_payumoney} ep
                  JOIN {enrol} e ON ep.instanceid = e.id
                  JOIN {user} u ON ep.userid = u.id 
                 WHERE e.courseid = :courseid";
        $params = [
            'courseid' => $context->instanceid
        ];

        $userlist->add_from_sql('id', $sql, $params);
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist
     *            The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist)
    {
        global $DB;

        if (empty($contextlist->count())) {
            return;
        }

        $user = $contextlist->get_user();

        list ($contextsql, $contextparams) = $DB->get_in_or_equal($contextlist->get_contextids(), SQL_PARAMS_NAMED);

        // Values of ep.receiver_email and ep.business are already normalised to lowercase characters by PayPal,
        // therefore there is no need to use LOWER() on them in the following query.
        $sql = "SELECT ep.*
                  FROM {enrol_payumoney} ep
                  JOIN {enrol} e ON ep.instanceid = e.id
                  JOIN {context} ctx ON e.courseid = ctx.instanceid AND ctx.contextlevel = :contextcourse
                  JOIN {user} u ON u.id = ep.userid 
                 WHERE ctx.id {$contextsql} AND u.id = :userid
              ORDER BY e.courseid";

        $params = [
            'contextcourse' => CONTEXT_COURSE,
            'userid' => $user->id
        ];
        $params += $contextparams;

        // Reference to the course seen in the last iteration of the loop. By comparing this with the current record, and
        // because we know the results are ordered, we know when we've moved to the PayPal transactions for a new course
        // and therefore when we can export the complete data for the last course.
        $lastcourseid = null;

        $strtransactions = get_string('transactions', 'enrol_payumoney');
        $transactions = [];
        $payrecords = $DB->get_recordset_sql($sql, $params);
        foreach ($payrecords as $payrecord) {
            if ($lastcourseid != $payrecord->courseid) {
                if (! empty($transactions)) {
                    $coursecontext = \context_course::instance($payrecord->courseid);
                    writer::with_context($coursecontext)->export_data([
                        $strtransactions
                    ], (object) [
                        'transactions' => $transactions
                    ]);
                }
                $transactions = [];
            }

            $transaction = (object) [
                'item_name' => $payrecord->item_name,
                'courseid' => $payrecord->courseid,
                'userid' => $payrecord->userid,
                'amount' => $payrecord->amount,
                'tax' => $payrecord->tax,
                'instanceid' => $payrecord->instanceid,
                'payment_status' => $payrecord->payment_status,
                'trans_id' => $payrecord->trans_id,
                'payment_id' => $payrecord->payment_id,
                'auth_json' => $payrecord->auth_json,
                'timeupdated' => \core_privacy\local\request\transform::datetime($payrecord->timeupdated)
            ];
            if ($payrecord->userid == $user->id) {
                $transaction->userid = $payrecord->userid;
            }

            $transactions[] = $payrecord;

            $lastcourseid = $payrecord->courseid;
        }
        $payrecords->close();

        // The data for the last activity won't have been written yet, so make sure to write it now!
        if (! empty($transactions)) {
            $coursecontext = \context_course::instance($payrecord->courseid);
            writer::with_context($coursecontext)->export_data([
                $strtransactions
            ], (object) [
                'transactions' => $transactions
            ]);
        }
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context
     *            The specific context to delete data for.
     */
    public static function delete_data_for_all_users_in_context(\context $context)
    {
        global $DB;

        if (! $context instanceof \context_course) {
            return;
        }

        $DB->delete_records('enrol_payumoney', array(
            'courseid' => $context->instanceid
        ));
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist
     *            The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist)
    {
        global $DB;

        if (empty($contextlist->count())) {
            return;
        }

        $user = $contextlist->get_user();

        $contexts = $contextlist->get_contexts();
        $courseids = [];
        foreach ($contexts as $context) {
            if ($context instanceof \context_course) {
                $courseids[] = $context->instanceid;
            }
        }

        list ($insql, $inparams) = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED);

        $select = "userid = :userid AND courseid $insql";
        $params = $inparams + [
            'userid' => $user->id
        ];
        $DB->delete_records_select('enrol_payumoney', $select, $params);

        // We do not want to delete the payment record when the user is just the receiver of payment.
        // In that case, we just delete the receiver's info from the transaction record.
    }

    public static function delete_data_for_users(approved_userlist $userlist)
    {
        global $DB;

        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_COURSE) {
            return;
        }
    }
}

