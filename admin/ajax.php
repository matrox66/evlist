<?php
/**
*   Common AJAX functions.
*
*   @author     Lee Garner <lee@leegarner.com>
*   @copyright  Copyright (c) 2009 Lee Garner <lee@leegarner.com>
*   @package    evlist
*   @version    1.3.0
*   @license    http://opensource.org/licenses/gpl-2.0.php 
*               GNU Public License v2 or later
*   @filesource
*/

/** Include required glFusion common functions */
require_once '../../../lib-common.php';

// This is for administrators only.  It's called by Javascript,
// so don't try to display a message
if (!plugin_isadmin_evlist()) {
    COM_accessLog("User {$_USER['username']} tried to illegally access the evlist admin ajax function.");
    exit;
}

switch ($_POST['action']) {
case 'toggle':
    $oldval = $_POST['oldval'] == 1 ? 1 : 0;
    switch ($_POST['component']) {
    case 'category':
        USES_evlist_class_category();

        switch ($_POST['type']) {
        case 'enabled':
            $newval = evCategory::toggleEnabled($oldval, $_POST['id']);
            break;

         default:
            exit;
        }
        break;

    case 'calendar':
        USES_evlist_class_calendar();

        switch ($_POST['type']) {
        case 'enabled':
            $newval = evCalendar::toggleEnabled($oldval, $_POST['id']);
            break;

         default:
            exit;
        }
        break;

    case 'event':
        USES_evlist_class_event();

        switch ($_POST['type']) {
        case 'enabled':
            $newval = evEvent::toggleEnabled($oldval, $_POST['id']);
            break;

         default:
            exit;
        }
        break;

    case 'tickettype':
        USES_evlist_class_tickettype();
        switch ($_POST['type']) {
        case 'enabled':
        case 'event_pass':
            $newval = evTicketType::Toggle($_POST['type'], $oldval, $_POST['id']);
            break;

         default:
            exit;
        }

         break;

    default:
        exit;
    }

    $response = array(
        'newval' => $newval,
        'id'    => $_POST['id'],
        'type'  => $_POST['type'],
        'component' => $_POST['component'],
        'baseurl'   => EVLIST_ADMIN_URL,
        'statusMessage' => $newval != $oldval ? $LANG_EVLIST['msg_item_updated'] : $LANG_EVLIST['msg_item_nochange'],
    );
    echo json_encode($response);
    break;
}

?>
