<?php
// +--------------------------------------------------------------------------+
// | evList A calendar solution for glFusion                                  |
// +--------------------------------------------------------------------------+
// | event.php                                                                |
// |                                                                          |
// | Event management routines                                                |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2008=2010 by the following authors:                        |
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
*   Event display function for the evList plugin
*
*   @author     Mark R. Evans mark AT glfusion DOT org
*   @copyright  Copyright (c) 2008 - 2010 Mark R. Evans mark AT glfusion DOT org
*   @copyright  Copyright (c) 2010 - 2017 Lee Garner <lee@leegarner.com>
*   @package    evlist
*   @version    1.4.3
*   @license    http://opensource.org/licenses/gpl-2.0.php
*               GNU Public License v2 or later
*   @filesource
*/

/** Import core glFusion libraries */
require_once '../lib-common.php';

if (!in_array('evlist', $_PLUGINS)) {
    COM_404();
    exit;
}

// If global loginrequired is set, override the plugin's setting
if ($_CONF['loginrequired'] == 1) $_EV_CONF['allow_anon_view'] = '0';
if (COM_isAnonUser() && $_EV_CONF['allow_anon_view'] != '1') {
    $display = EVLIST_siteHeader();
    $display .= SEC_loginRequiredForm();
    $display .= EVLIST_siteFooter();
    echo $display;
    exit;
}

// Import plugin-specific function library
USES_evlist_functions();
//USES_evlist_views();

/*
 * Main function
 */
$expected = array('edit', 'cancel',
    'editfuture',
    'saveevent', 'saverepeat', 'savefuturerepeat',
    'delevent', 'delrepeat', 'delfuture',
    'savereminder', 'delreminder', 'clone',
    'register', 'cancelreg', 'search', 'print',
    'printtickets', 'tickdelete_x', 'tickreset_x',
    'view',
);
$action = 'view';
$actionval = '';
$view = '';
foreach($expected as $provided) {
    if (isset($_POST[$provided])) {
        $action = $provided;
        $actionval = $_POST[$provided];
        break;
    } elseif (isset($_GET[$provided])) {
        $action = $provided;
        $actionval = $_GET[$provided];
        break;
    }
}

// Set variables that are almost always used
if (isset($_POST['rp_id'])) {
    $rp_id = (int)$_POST['rp_id'];
} elseif (isset($_GET['rp_id'])) {
    $rp_id = (int)$_GET['rp_id'];
} else {
    $rp_id = 0;
}
if (isset($_POST['eid'])) {
    $eid = COM_sanitizeId($_POST['eid'], false);
} elseif (isset($_GET['eid'])) {
    $eid = COM_sanitizeId($_GET['eid'], false);
} else {
    $eid = '';
}
$mode = isset($_POST['mode']) ? $_POST['mode'] : 'nested';
$order = isset($_POST['order']) ? $_POST['order'] : 'ASC';
$cal_id = isset($_GET['cal']) ? (int)$_GET['cal'] : 0;
$cat_id = isset($_GET['cat']) ? $_GET['cat'] : '';

$pagetitle = '';        // Default to empty page title
$template = '';         // Use the default template if none provided
$content = '';

// Get the system message, if any.  There should only be a message if our
// next action is a view, since an action might override the message value.
// We need message queueing!
if (isset($_GET['msg'])) {
    $msg = COM_applyFilter($_GET['msg'], true);
} else {
    $msg = '';
}

//echo $action;die;
switch ($action) {
case 'edit':
case 'view':
case 'clone':
case 'print':
case 'printtickets':
    $view = $action;
    break;

case 'search':
    // search result returned.  eid value is the event ID, not the repeat
    $view = 'home';         // default on failure
    if (!empty($_GET['eid'])) {
        $sql = "SELECT rp.rp_id
                FROM {$_TABLES['evlist_repeat']} rp
                WHERE rp.rp_ev_id = '$eid'
                AND rp.rp_date_start >= '{$_EV_CONF['_today']}'
                ORDER BY rp.rp_date_start ASC
                LIMIT 1";
        $res = DB_query($sql);
        if ($res && DB_numRows($res) == 1) {
            $A = DB_fetchArray($res, false);
            $eid = $A['rp_id'];
            $view = 'view';
        }
    }
    break;

case 'saverepeat':
case 'savefuturerepeat':
    if ($rp_id > 0) {
        $R = new Evlist\Repeat($rp_id);
        $errors = $R->Save($_POST); // save detail info
        if (!empty($errors)) {
            $content .= '<span class="alert"><ul>' . $errors . '</ul></span>';
            $content .= $R->Edit();
            $view = 'none';
        } elseif ($action == 'savefuturerepeat') {
            // Update all future repeat records.
            $det_id = $R->det_id;
            $sql = "UPDATE {$_TABLES['evlist_repeat']}
                SET rp_det_id = '{$R->det_id}'
                WHERE rp_date_start >= '{$R->date_start}'
                    AND rp_ev_id = '{$R->ev_id}'";
            DB_query($sql);
        }
    }
    if (isset($_GET['admin'])) {
        echo COM_refresh(EVLIST_ADMIN_URL);
        exit;
    }
    break;

case 'saveevent':
    $eid = isset($_POST['eid']) && !empty($_POST['eid']) ? $_POST['eid'] : '';
    $table = empty($eid) ? 'evlist_submissions' : 'evlist_events';
    $Ev = new Evlist\Event($eid);
    $errors = $Ev->Save($_POST, $table);
    if (!empty($errors)) {
        $content .= '<span class="alert"><ul>' . $errors . '</ul></span>';
        $content .= $Ev->Edit();
        $view = 'none';
    } else {
        $view = 'home';
        if ($Ev->table == 'evlist_submissions') {
            COM_setMsg($LANG_EVLIST['messages'][9]);
        } else {
            COM_setMsg($LANG_EVLIST['messages'][2]);
        }
    }
    break;

case 'delevent':
    $eid = isset($_REQUEST['eid']) && !empty($_REQUEST['eid']) ?
            $_REQUEST['eid'] : '';
    if ($eid != '') {
        Evlist\Event::Delete($eid);
    }
    $view = 'home';
    break;

case 'delrepeat':
    $rp_id = isset($_REQUEST['rp_id']) && !empty($_REQUEST['rp_id']) ?
            (int)$_REQUEST['rp_id'] : 0;
    if ($rp_id > 0) {
        $R = new Evlist\Repeat($rp_id);
        if ($R->Event && $R->Event->canEdit()) {
            $R->Delete();
        }
    }
    $view = 'home';
    break;

case 'delfuture':
    // Delete the selected and all future occurances.
    $R = new Evlist\Repeat($_REQUEST['rp_id']);
    $R->DeleteFuture();
    break;

case 'register':
    if ($rp_id < 1) {
        break;
    } elseif (COM_isAnonUser()) {
        $display = EVLIST_siteHeader();
        $display .= SEC_loginRequiredForm();
        $display .= EVLIST_siteFooter();
        echo $display;
        exit;
    }
    $Ev = new Evlist\Repeat($rp_id);
    $msg = $Ev->Register($_POST['tick_count'], $_POST['tick_type']);
    echo COM_refresh(EVLIST_URL . '/event.php?eid=' . $rp_id);
    break;

case 'cancelreg':
    if ($rp_id < 1 || COM_isAnonUser()) {
        // Anonymous users can't register
        break;
    }
    $Ev = new Evlist\Repeat($rp_id);
    $status = $Ev->CancelRegistration(0, $_POST['num_cancel']);
    if ($status) {
        // success
        COM_setMsg($LANG_EVLIST['messages'][25]);
        // See if there are any other ticket and let the user know
        $cnt = $Ev->isRegistered();
        if ($cnt > 0) {
            COM_setMsg(sprintf($LANG_EVLIST['messages'][28], $cnt));
        }
    } else {
        COM_setMsg($LANG_EVLIST['messages'][23]);
    }
    echo COM_refresh(EVLIST_URL . '/event.php?eid=' . $rp_id);
    break;

case 'cancel':
    echo COM_refresh($_CONF['site_admin_url'].'/moderation.php');
    break;

case 'tickdelete_x':
    // Delete one or more tickets, if admin or owner
    $rp = new Evlist\Repeat($_GET['rp_id']);
    if ($rp->isAdmin) {
        if (isset($_POST['delrsvp']) && is_array($_POST['delrsvp'])) {
            Evlist\Ticket::Delete($_POST['delrsvp']);
        }
    }
    COM_refresh($_CONF['site_url'] . '/evlist/event.php?eid=' . $_POST['ev_id']);
    exit;

case 'tickreset_x':
    // Reset the usage flag for one or more tickets if admin or owner
    $rp = new Evlist\Repeat($_GET['rp_id']);
    if ($rp->isAdmin) {
        if (isset($_POST['delrsvp']) && is_array($_POST['delrsvp'])) {
            Evlist\Ticket::Reset($_POST['delrsvp']);
        }
    }
    COM_refresh($_CONF['site_url'] . '/evlist/event.php?eid=' . $_POST['ev_id']);
    exit;
}

$add_link = true;   // Flag to indicate whether to show the Add Event link
switch ($view) {
case 'edit':
    switch ($actionval) {
    case 'repeat':
    case 'futurerepeat':
        if (isset($_REQUEST['rp_id'])) {
            $rp_id = (int)$_GET['rp_id'];
            $Ev = new Evlist\Repeat($rp_id);
            if ($Ev->Event->canEdit()) {
                $content .= $Ev->Edit(0, $actionval);
            } else {
                COM_404();
            }
        }
        break;
    case 'event':
    default:
        if (isset($_REQUEST['eid'])) {
            $Ev = new Evlist\Event($_REQUEST['eid']);
            if ($Ev->canEdit()) {
                // allowed to edit an existing event
                $content .= $Ev->Edit('', $rp_id, 'save'.$actionval);
                $add_link = false;
            } else {
                COM_404();
            }
        } else {
            // Submitting a new event
            if (EVLIST_canSubmit()) {
                $Ev = new Evlist\Event();
                $content .= $Ev->Edit();
                $add_link = false;
            }
        }
        break;
    }
    break;

case 'clone':
    if (isset($_GET['eid'])) {
        EVLIST_setReturn(EVLIST_URL . '/event.php?view=instance&eid=' . $_GET['rp_id']);
        $Ev = new Evlist\Event($_GET['eid']);
        if ($Ev->id == '' || !$Ev->canEdit())      // Event not found
            break;
        // Now prep it to be saved as a new record
        $Ev->id = '';
        $Ev->isNew = true;
        $add_link = false;
        $content .= $Ev->Edit();
    }
    break;

case 'none':
    // Don't display anything, it was already taken care of
    break;

case 'home':
    if (!empty($msg)) {
        $msg_url = "?msg=$msg";
    } else {
        $msg_url = '';
    }
    echo COM_refresh(EVLIST_URL . '/index.php' . $msg_url);
    exit;

case 'print':
    $rp_id = isset($_GET['rp_id']) ? $_GET['rp_id'] : '';
    if (!empty($rp_id)) {
        $Rep = new Evlist\Repeat($rp_id);
        $pagetitle = COM_stripslashes($Rep->Event->title);
        echo $Rep->Render('', '', 'print');
        exit;
    } else {
        // Shouldn't be in this file without an event ID to display or edit
        echo COM_refresh(EVLIST_URL . '/index.php');
        exit;
    }
    break;

case 'printtickets':
    // Print the current user's own tickets to the event
    if ($_EV_CONF['enable_rsvp'] && !COM_isAnonUser()) {
        $doc = Evlist\Ticket::PrintTickets($eid, $rp_id, $_USER['uid']);
        echo $doc;
        exit;
    } else {
        $content .= 'Function not available';
    }
    break;

case 'view':
case 'print':
default:
    // Default action, view the event
    if (empty($eid) && empty($rp_id)) {
        // No ID params given, try getting from the friendly URL
        COM_setArgNames(array('view', 'eid','ts','range','cat'));
        $actionval = COM_getArgument('view');
        $eid = COM_sanitizeID(COM_getArgument('eid'), false);
    }
    switch ($actionval) {
    case 'event':
        // Given an event ID, get the nearest instance to display
        $rp_id = Evlist\Repeat::getNearest($eid);
        if (!$rp_id) {
            COM_refresh($EVLIST_URL . '/index.php');
        }
        break;
    case 'instance':
    case 'repeat':
    default:
        if (empty($rp_id)) $rp_id = $eid;
        break;
    }
    if (!empty($rp_id)) {
        $Rep = Evlist\Repeat::getInstance($rp_id);
        $pagetitle = COM_stripslashes($Rep->Event->Detail->title);
        if ($view == 'print') {
            $template = 'print';
            $query = '';
        }
        $query = isset($_GET['query']) ? $_GET['query'] : '';
        $content .= $Rep->Render('', $query, $template, $mode, $order);
    } else {
        // Shouldn't be in this file without an event ID to display or edit
        echo COM_refresh(EVLIST_URL . '/index.php');
        exit;
    }
    break;
}

$display = EVLIST_siteHeader($pagetitle);
$V = new Evlist\View_detail();
$display .= $V->Header($add_link);

if (!empty($msg)) {
    $display .= COM_startBlock($LANG_EVLIST['alert'],'','blockheader-message.thtml');
    $display .= $LANG_EVLIST['messages'][$msg];
    $display .= COM_endBlock('blockfooter-message.thtml');
}

$display .= $content;
$display .= EVLIST_siteFooter();
echo $display;

?>
