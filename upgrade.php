<?php
// +--------------------------------------------------------------------------+
// | evList A calendar solution for glFusion                                  |
// +--------------------------------------------------------------------------+
// | upgrade.php                                                              |
// |                                                                          |
// | Upgrade routines                                                         |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2009-2010 by the following authors:                        |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// |                                                                          |
// | Based on the evList Plugin for Geeklog CMS                               |
// | Copyright (C) 2007 by the following authors:                             |
// |                                                                          |
// | Authors: Alford Deeley     - ajdeeley AT summitpages.ca                  |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+
/**
*   Upgrade routines for the evList plugin
*
*   @author     Mark R. Evans mark AT glfusion DOT org
*   @copyright  Copyright (c) 2008 - 2010 Mark R. Evans mark AT glfusion DOT org
*   @copyright  Copyright (c) 2010 - 2016 Lee Garner <lee@leegarner.com>
*   @package    evlist
*   @version    1.4.1
*   @license    http://opensource.org/licenses/gpl-2.0.php
*               GNU Public License v2 or later
*   @filesource
*/


// this file can't be used on its own
if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

global $_DB_dbms, $c, $_CONF, $CONF_EVLIST_DEFAULT;
require_once __DIR__ . "/sql/{$_DB_dbms}_install.php";
require_once $_CONF['path'] . 'system/classes/config.class.php';
require_once __DIR__ . '/install_defaults.php';
$c = config::get_instance();

/**
*   Upgrade the evList plugin
*
*   @return boolean     True on success, False on failure
*/
function evlist_upgrade($ignore_errors = false)
{
    global $_TABLES, $_CONF, $_EV_CONF, $_DB_table_prefix, $_DB_dbms, $c,
        $CONF_EVLIST_DEFAULT, $_PLUGIN_INFO;

    if (isset($_PLUGIN_INFO[$_EV_CONF['pi_name']])) {
        if (is_array($_PLUGIN_INFO[$_EV_CONF['pi_name']])) {
            // glFusion >= 1.6.6
            $currentVersion = $_PLUGIN_INFO[$_EV_CONF['pi_name']]['pi_version'];
        } else {
            // legacy
            $currentVersion = $_PLUGIN_INFO[$_EV_CONF['pi_name']];
        }
    } else {
        return false;
    }
    $installed_ver = plugin_chkVersion_evlist();

    $_TABLES['evlist_settings'] = $_DB_table_prefix . 'evlist_settings';

    switch ($currentVersion) {
        case '1.0'   :
        case '1.0.0' :
        case '1.0.1' :
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.0.2' WHERE pi_name = '$pi_name'");
        case '1.0.2' :
            //upgrade to version 1.1
            DB_query("ALTER TABLE {$_TABLES['evlist_events']}
                ADD enable_reminders TINYINT(1) NOT NULL default '1' AFTER hits,
                CHANGE time_start1 time_start1 VARCHAR(8) NOT NULL DEFAULT '0'
                ");
            DB_query("ALTER TABLE {$_TABLES['evlist_submissions']}
                ADD enable_reminders TINYINT(1) NOT NULL default '0' AFTER hits,
                CHANGE time_start1 time_start1 VARCHAR(8) NOT NULL DEFAULT '0'
                ");
            if (file_exists ($_CONF['path'] . 'plugins/evlist/sql/def_events.php')) {
                //because the default events have been updated with new information
                include_once $_CONF['path'] . 'plugins/evlist/sql/def_events.php';
                DB_query($DEFVALUES['evlist_events']);
            } else {
                //you won't get the new info, but your default events will still work.
                DB_query("UPDATE IGNORE {$_TABLES['evlist_events']}
                    SET time_start1 = '0' WHERE id = '20070924175337252'
                    OR id = '20070922110402423' OR id = '20070924133400211'
                    ");
            }
            DB_query("CREATE TABLE {$_TABLES['evlist_remlookup']} (
                id VARCHAR(40) NOT NULL,
                eid VARCHAR(40) NOT NULL,
                date_start INT UNSIGNED NOT NULL,
                timestamp INT UNSIGNED,
                email VARCHAR(96) NOT NULL,
                days_notice SMALLINT(3) NOT NULL default '7',
                UNIQUE eid (eid,timestamp,email,days_notice)
                ) ENGINE=MyISAM
                ");
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.1' WHERE pi_name = '$pi_name'");
        case '1.1' :
        case '1.1.1.fusion' :
        case '1.1.3.fusion' :
            // need to migrate the configuration to our new online configuration.
            plugin_initconfig_evlist();
            include $_CONF['path'].'plugins/evlist/evlist.php';
            DB_query("DROP TABLE {$_TABLES['evlist_settings']}",1);
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.1.4.fusion', pi_gl_version='1.1.0',pi_homepage='http://www.glfusion.org' WHERE pi_name = '$pi_name'");
        case '1.1.4.fusion' :
            $c->add('enable_reminders',1, 'select',0, 0, 0, 80, true, 'evlist');
            $c->add('reminder_days',7, 'text',0, 0, NULL, 90, true, 'evlist');

            DB_query("ALTER TABLE {$_TABLES['evlist_remlookup']}
                ADD uid MEDIUMINT(8) NOT NULL default '1' AFTER timestamp");

            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.2.0.fusion', pi_gl_version='1.1.0',pi_homepage='http://www.glfusion.org' WHERE pi_name = '$pi_name'");
        case '1.2.0' :
        case '1.2.1' :
        case '1.2.2' :
        case '1.2.3' :
        case '1.2.4' :
        case '1.2.5' :
            $c->add('displayblocks',0, 'select',0, 1, 13, 25, true, 'evlist');
            // no db or config changes
            DB_query("UPDATE {$_TABLES['groups']} SET grp_gl_core=2 WHERE grp_name='evList Admin'",1);
            DB_query("INSERT INTO {$_TABLES['blocks']} (
                is_enabled, name, type, title, tid, blockorder, onleft,
                phpblockfn, group_id, owner_id,
                perm_owner, perm_group, perm_members, perm_anon
            ) VALUES (
                '0', 'evlist_smallmonth', 'phpblock', 'Event Calendar', 'all', 0, 0,
                'phpblock_evlist_smallmonth', 4, 2,
                3, 3, 2, 2
            )");

        case '1.2.6' :
            // Lots of updates
            $status = evlist_upgrade_1_3_0();
            if ($status > 0) return false;
            if (!EVLIST_do_set_version('1.3.0')) return false;

        case '1.3.0':
        case '1.3.0.1':
        case '1.3.0.2':
        case '1.3.1':
            $currentVersion = '1.3.2';
            if (!EVLIST_do_upgrade_sql($currentVersion)) return false;;

            // Change the recurring interval type to an array to support
            // multiple occurrences per month for DOM-type events
            $sql = "SELECT id, rec_data
                    FROM {$_TABLES['evlist_events']}
                    WHERE recurring = 1";
            $res = DB_query($sql, 1);
            if (!$res) {
                COM_errorLog("Error retrieving recurring events");
                return false;
            }
            while ($A = DB_fetchArray($res, false)) {
                $data = @unserialize($A['rec_data']);
                if (!$data) {
                    // rec_data *should* be a serialized array, but if it isn't
                    // then there's nothing useful here anyway.
                    COM_errorLog("Error unserializing rec_data- id {$A['id']}");
                    continue;
                }
                if (isset($data['interval']) && !is_array($data['interval'])) {
                    $data['interval'] = array($data['interval']);
                    $data = DB_escapeString(serialize($data));
                    DB_query("UPDATE {$_TABLES['evlist_events']}
                            SET rec_data = '$data'
                            WHERE id = '{$A['id']}'", 1);
                    if (DB_error()) return false;
                }
            }
            if (!EVLIST_do_set_version($currentVersion)) return false;

        case '1.3.4':
            // This is likely to fail, rec_option has been unused since 1.3.0
            // but was never removed via upgrading
            DB_query("ALTER TABLE {$_TABLES['evlist_events']} DROP rec_option", 1);
            if (!EVLIST_do_set_version('1.3.5')) return false;

        case '1.3.5':
            DB_query("UPDATE {$_TABLES['conf_values']}
                    SET selectionArray = 9
                    WHERE name = 'enable_centerblock'
                    AND group_name = '{$_EV_CONF['pi_name']}'");
            if (!EVLIST_do_set_version('1.3.6')) return false;

        case '1.3.6':
            $currentVersion = '1.3.7';
            if (!EVLIST_do_upgrade_sql($currentVersion)) return false;

            // Remove date and time formats, global configs are used instead.
            $c->del('week_begins', 'evlist');
            $c->del('date_format', 'evlist');
            $c->del('time_format', 'evlist');
            $c->add('cal_tmpl', 'html', 'select',
                    0, 1, 16, 130, true, 'evlist');
            $c->add('sg_rsvp', NULL, 'subgroup', 20, 0, NULL, 0, true, 'evlist');
            $c->add('fs_rsvp', NULL, 'fieldset', 20, 10, NULL, 0, true, 'evlist');
            $c->add('enable_rsvp',$CONF_EVLIST_DEFAULT['enable_rsvp'], 'select',
                    20, 10, 0, 10, true, 'evlist');
            $c->add('rsvp_print',$CONF_EVLIST_DEFAULT['rsvp_print'], 'select',
                    20, 10, 17, 20, true, 'evlist');

            if (!EVLIST_do_set_version($currentVersion)) return false;

        case '1.3.7':
        case '1.3.8':
        case '1.3.9':
            $currentVersion = '1.4.0';
            $c->add('sg_integ', NULL, 'subgroup', 30, 0, NULL, 0, true, 'evlist');
            $c->add('ev_integ_meetup', NULL, 'fieldset', 30, 10, NULL, 0, true, 'evlist');
            $c->add('meetup_enabled',$CONF_EVLIST_DEFAULT['meetup_enabled'], 'select',
                    30, 10, 0, 10, true, 'evlist');
            $c->add('meetup_key',$CONF_EVLIST_DEFAULT['meetup_key'], 'text',
                    30, 10, 0, 20, true, 'evlist');
            $c->add('meetup_gid',$CONF_EVLIST_DEFAULT['meetup_gid'], 'text',
                    30, 10, 0, 30, true, 'evlist');
            $c->add('meetup_cache_minutes',$CONF_EVLIST_DEFAULT['meetup_cache_minutes'], 'text',
                    30, 10, 0, 40, true, 'evlist');

            // SQL includes moving configuration items under the new sg_integ group,
            // so execute it last.
            if (!EVLIST_do_upgrade_sql($currentVersion)) return false;
            if (!EVLIST_do_set_version($currentVersion)) return false;

        case '1.4.0':
            $currentVersion = '1.4.1';
            $c->add('commentsupport',$CONF_EVLIST_DEFAULT['commentsupport'], 'select',
                0, 0, 0, 100, true, 'evlist');
            if (!EVLIST_do_upgrade_sql($currentVersion)) return false;
            if (!EVLIST_do_set_version($currentVersion)) return false;

        case '1.4.1':
            $currentVersion = '1.4.2';
            if (!EVLIST_do_upgrade_sql($currentVersion)) return false;
            if (!EVLIST_do_set_version($currentVersion)) return false;

        case '1.4.2':
            $currentVersion = '1.4.3';
            $c->del('cal_tmpl', 'evlist');
            $c->add('ticket_format',$CONF_EVLIST_DEFAULT['ticket_format'],
                'text', 20, 10, 0, 30, true, 'evlist');
            if (!empty($_EV_CONF['meetup_gid'])) {
                // Changing meetup_gid type to array, first get the current
                // value and convert it.
                $meetup_gid = @serialize(array($_EV_CONF['meetup_gid']));
                DB_query("UPDATE {$_TABLES['conf_values']}
                    SET value = '" . DB_escapeString($meetup_gid) . "'
                    WHERE name = 'meetup_gid' AND group_name = 'evlist'", 1);
                if (DB_error()) {
                    COM_errorLog("1.4.3 update error: $sql");
                    return false;
                }
            }

            // This column should have been there from the beginning, but on
            // at least one site it was missing. Add it here, but ignore any
            // SQL error since it's probably already there.
            DB_query("ALTER TABLE {$_TABLES['evlist_remlookup']}
                ADD date_start int(10) unsigned AFTER rp_id", 1);

            // Remove renamed class files
            $files = array(
                'evTicketType.class.php', 'evTicket.class.php',
                'evCategory.class.php', 'evCalendar.class.php',
                'evView.class.php', 'evEvent.class.php', 'evRepeat.class.php',
                'evRecur.class.php', 'evDetail.class.php',
            );
            foreach ($files as $file) {
                @unlink(__DIR__ . '/classes/' . $file);
            }
            if (!EVLIST_do_upgrade_sql($currentVersion)) return false;
            if (!EVLIST_do_set_version($currentVersion)) return false;

        case '1.4.3':
        case '1.4.4':
            $currentVersion = '1.4.5';
            $c->add('ev_integ_other', NULL, 'fieldset', 30, 20, NULL, 0, true, 'evlist');
            $c->add('pi_cal_map', $CONF_EVLIST_DEFAULT['pi_cal_map'], '*text',
                30, 20, 0, 10, true, 'evlist');
            if (!EVLIST_do_upgrade_sql($currentVersion, $ignore_errors)) return false;
            if (!EVLIST_do_set_version($currentVersion)) return false;

        case '1.4.5':
            $currentVersion = '1.4.6';
            if (!EVLIST_do_upgrade_sql($currentVersion, $ignore_errors)) return false;
            // Order the calendars, initially by name;
            Evlist\Calendar::reOrder('cal_name');
            if (!EVLIST_do_set_version($currentVersion)) return false;
     }
    if (!COM_checkVersion($currentVersion, $installed_ver)) {
        if (!EVLIST_do_set_version($installed_ver)) return false;
    }
    EVLIST_remove_old_files();
    CTL_clearCache();
    Evlist\Cache::clear();
    COM_errorLog("Successfully updated the {$_EV_CONF['pi_display_name']} Plugin", 1);
    return true;
}


/**
*   Upgrade to version 1.3.0
*   Many changes in this version, so a function was created to
*   hold them all.
*
*   @return boolean     True on success, False on failure
*/
function evlist_upgrade_1_3_0()
{
    global $_CONF, $_EV_CONF, $_TABLES, $_DB_dbms, $c, $CONF_EVLIST_DEFAULT;

    USES_evlist_class_event();
    $c->add('default_view', $CONF_EVLIST_DEFAULT['default_view'], 'select',
                0, 1, 14, 90, true, 'evlist');
    $c->add('max_upcoming_days', $CONF_EVLIST_DEFAULT['max_upcoming_days'], 'text',
                0, 1, 0, 100, true, 'evlist');

    // Combine users allowed to add events into one variable
    $can_add = 0;
    if ($EV_CONF['allow_anon_add'] > 0) $can_add += EV_ANON_CAN_ADD;
    if ($EV_CONF['allow_user_add'] > 0) $can_add += EV_USER_CAN_ADD;
    $c->add('can_add', $can_add, 'select', 0, 1, 15, 20, true, 'evlist');
    $c->del('allow_user_add', 'evlist');
    $c->del('allow_anon_add', 'evlist');
    // Add new options for plugin integration
    $c->add('use_locator', $CONF_EVLIST_DEFAULT['use_locator'], 'select',
            0, 1, 0, 110, true, 'evlist');
    $c->add('use_weather', $CONF_EVLIST_DEFAULT['use_weather'], 'select',
            0, 1, 0, 120, true, 'evlist');

    // Date & Time formats moved from the DB to simple $_CONF  variables
    $format = DB_getItem($_TABLES['evlist_dateformat'], 'format',
                "id='{$_EV_CONF['date_format']}'");
    if (empty($format)) $format = '%a %b %d, %Y';
    $c->set_default('date_format', $format, 'evlist');
    $c->set('date_format', $format, 'evlist');

    $format = DB_getItem($_TABLES['evlist_timeformat'], 'format',
                "id='{$_EV_CONF['date_format']}'");
    if (empty($format)) $format = '%I:%M %p';
    $c->set_default('time_format', $format, 'evlist');
    $c->set('time_format', $format, 'evlist');

    DB_query("DROP TABLE {$_TABLES['evlist_dateformat']}");
    DB_query("DROP TABLE {$_TABLES['evlist_timeformat']}");

    // Change feature name
    DB_query("UPDATE {$_TABLES['features']}
                SET ft_name='evlist.admin' WHERE ft_name='evlist.edit'");

    // Add new "submit" feature & map to Root group
    DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr)
            VALUES ('evlist.submit',
                    'Allowed to bypass the evList submission queue')", 1);
    if (!DB_error()) {
        $ft_id = (int)DB_insertId();
        if ($ft_id > 0) {
            DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id)
                    VALUES('$ft_id', '1')");
        }
    }

    EVLIST_do_upgrade_sql('1.3.0');

    // Add the new fields to the event & submission tables
    /*$new_sql = "ADD det_id int(10) NOT NULL,
            ADD show_upcoming tinyint(1) unsigned NOT NULL DEFAULT '1',
            ADD cal_id int(10) unsigned NOT NULL DEFAULT '1',
            ADD options varchar(255)";
    DB_query("ALTER TABLE {$_TABLES['evlist_events']} $new_sql");
    DB_query("ALTER TABLE {$_TABLES['evlist_submissions']} $new_sql");*/

    // Create the new tables
    /*DB_query($_SQL['evlist_repeat']);
    DB_query($_SQL['evlist_calendars']);
    DB_query($_SQL['evlist_detail']);
    DB_query($DEFVALUES['evlist_calendars']);*/

    // Now split out the detail and create the repeats
    $result = DB_query("SELECT * FROM {$_TABLES['evlist_events']}");
    $error = 0;
    while ($A = DB_fetchArray($result, false)) {
        $A = array_map('DB_escapeString', $A);
        $sql = "INSERT INTO {$_TABLES['evlist_detail']} (
                    ev_id, title, summary, full_description, url, location,
                    street, city, province, country, postal, contact,
                    email, phone
                ) VALUES (
                    '{$A['id']}', '{$A['title']}', '{$A['summary']}',
                    '{$A['full_description']}', '{$A['url']}',
                    '{$A['location']}', '{$A['street']}',
                    '{$A['city']}', '{$A['province']}',
                    '{$A['country']}', '{$A['postal']}',
                    '{$A['contact']}', '{$A['email']}','{$A['phone']}'
                )";
        DB_query($sql, 1);
        if (DB_error()) {
            $error = 1;
            break;
        } else {
            $DB_det_id = DB_insertID();
        }

        $rec_data = array();
        if ($A['recurring'] == 1) {
            $rec_data['type'] = $A['rec_option'];
            switch ($A['rec_option']) {
            case EV_RECUR_DAILY:
            case EV_RECUR_MONTHLY:
            case EV_RECUR_YEARLY:
                list($stop, $skip) = explode(';', $A['rec_data']);
                if (!empty($skip)) {
                    $rec_data['skip'] = (int)$skip;
                }
                break;

            case EV_RECUR_WEEKLY:
                list($listdays, $stop) = explode(';', $A['rec_data']);
                $rec_data['listdays'] = explode(',', $listdays);
                break;

            case EV_RECUR_DOM:
                list($interval, $weekday, $stop) = explode(';', $A['rec_data']);
                $rec_data['weekday'] = $weekday;
                $rec_data['interval'] = $interval;
                break;

            case EV_RECUR_DATES:
                $rec_data['custom'] = explode(',', $A['rec_data']);
                $stop = 'XX';   // unused flag
                break;

            }   // switch recurring type

            // Check the stop date for validity and format it properly
            if ($stop != 'XX') {
                if (strtotime($stop) > strtotime('2037-01-01') ||
                    $stop < '1970-01-01') {
                    $stop = '2037-12-31';
                }
                list($y, $m, $d) = explode('-', $stop);
                $rec_data['stop'] = sprintf('%d-%02d-%02d', $y, $m, $d);
            }

        } else {  // not a recurring event

            $rec_data['type'] = 0;

        }

        $DB_rec_data = DB_escapeString(serialize($rec_data));

        $sql = "UPDATE {$_TABLES['evlist_events']} SET
                    rec_data = '$DB_rec_data',
                    det_id = '$DB_det_id'
                WHERE id='{$A['id']}'";
        DB_query($sql, 1);
        if (DB_error()) {
            $error = 1;
            break;
        }

        // Now that the updated info is saved to the event record,
        // use the evEvent class to create the repeats
        $Ev = new evEvent($A['id']);
        $Ev->UpdateRepeats();

    }   // for each event record

    if ($error == 0) {
        // Now drop the no-longer-used fields
        $alter_sql = "DROP title, DROP summary, DROP full_description,
                DROP date_start2, DROP date_end2,
                DROP url, DROP location, DROP street, DROP city,
                DROP province, DROP country, DROP postal, DROP contact,
                DROP email, DROP phone";
        DB_query("ALTER TABLE {$_TABLES['evlist_events']} $alter_sql");
        DB_query("ALTER TABLE {$_TABLES['evlist_submissions']} $alter_sql");
        DB_query("ALTER TABLE {$_TABLES['evlist_remlookup']}
                DROP id,
                ADD rp_id int(10) unsigned NOT NULL default 0 AFTER eid,
                DROP date_start,
                DROP timestamp");

        // Add new options.  Set values to emulate current behavior.
        $options = array('contactlink' => 1);
        $opt_str = DB_escapeString(serialize($options));
        DB_query("UPDATE {$_TABLES['evlist_events']} SET options='$opt_str'");
        DB_query("UPDATE {$_TABLES['evlist_submissions']} SET options='$opt_str'");
    }

    CTL_clearCache();   // Clear cache to activate new configuration items.

    return $error;
}   // function evlist_upgrade_1_3_0


/**
*   Actually perform any sql updates.
*   Gets the sql statements from the $UPGRADE array defined (maybe)
*   in the SQL installation file.
*
*   @since  version 1.3.4
*   @param  string  $version    Version being upgraded TO
*   @return boolean             True on success, False after a failure
*/
function EVLIST_do_upgrade_sql($version='', $ignore_errors = false)
{
    global $_TABLES, $_EV_CONF, $_EV_UPGRADE;

    // If no sql statements passed in, return success
    if (!is_array($_EV_UPGRADE[$version])) return true;

    // Execute SQL now to perform the upgrade
    COM_errorLOG("--Updating {$_EV_CONF['pi_name']} to version $version");
    foreach($_EV_UPGRADE[$version] as $sql) {
        COM_errorLOG("{$_EV_CONF['pi_name']} Plugin $version update: Executing SQL => $sql");
        DB_query($sql, '1');
        if (DB_error()) {
            COM_errorLog("SQL Error during {$_EV_CONF['pi_name']} Plugin update", 1);
            if (!$ignore_errors) {
                return false;
            }
        }
    }
    return true;
}


/**
*   Update the plugin version number in the database.
*   Called at each version upgrade to keep up to date with
*   successful upgrades.
*
*   @param  string  $ver    New version to set
*   @return boolean         True on success, False on failure
*/
function EVLIST_do_set_version($ver)
{
    global $_TABLES, $_EV_CONF, $_PLUGIN_INFO;;

    // now update the current version number.
    $sql = "UPDATE {$_TABLES['plugins']} SET
            pi_version = '{$_EV_CONF['pi_version']}',
            pi_gl_version = '{$_EV_CONF['gl_version']}',
            pi_homepage = '{$_EV_CONF['pi_url']}'
        WHERE pi_name = '{$_EV_CONF['pi_name']}'";
    //COM_errorLog($sql);
    $res = DB_query($sql, 1);
    if (DB_error()) {
        COM_errorLog("Error updating the {$_EV_CONF['pi_display_name']} Plugin version",1);
        return false;
    } else {
        $_PLUGIN_INFO[$_EV_CONF['pi_name']]['pi_version'] = $ver;
        $_PLUGIN_INFO[$_EV_CONF['pi_name']][1] = $ver;
        $_EV_CONF['pi_version'] = $ver;
        return true;
    }
}


/**
*   Remove deprecated files
*/
function EVLIST_remove_old_files()
{
    global $_CONF;

    $paths = array(
        // private/plugins/evlist
        __DIR__ => array(
            'classes/DateCalc.class.php',
            'classes/evCalendar.class.php',
            'classes/evCategory.class.php',
            'classes/evDetail.class.php',
            'classes/evEvent.class.php',
            'classes/evRecur.class.php',
            'classes/evRepeat.class.php',
            'classes/evTicket.class.php',
            'classes/evTicketType.class.php',
            'classes/evView.class.php',
        ),
        // public_html/evlist
        $_CONF['path_html'] . 'evlist' => array(
            'js/colorpicker.js',
        ),
    );

    foreach ($paths as $path=>$files) {
        foreach ($files as $file) {
            @unlink("$path/$file");
        }
    }
}

?>
