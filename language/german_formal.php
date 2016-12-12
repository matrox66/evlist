<?php
// +--------------------------------------------------------------------------+
// | evList A calendar solution for glFusion                                  |
// +--------------------------------------------------------------------------+
// | german_formal.php                                                        |
// |                                                                          |
// | German language file for evList                                          |
// | Modifiziert: August 09 Tony Kluever                                      |
// +--------------------------------------------------------------------------+
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
*   German language file for the evList plugin
*   @package    evlist
*/

// this file can't be used on its own
if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

$LANG_EVLIST = array(
'pi_title'          => 'evList',
'moderation_title'  => 'evList-Ereigniseinsendungen',
'del_future'        => 'Delete this and future repeats',
'conf_del_future'   => 'Are you sure you want to delete all future occurences of this event?',
'del_all'           => 'L�schen?',
'conf_del_all'      => 'Are you sure you want to delete all occurences of this event?',
'del_repeat'        => 'Delete this occurence',
'conf_del_repeat'   => 'Are you sure you want to delete this occurence?',
'conf_del_event'    => 'M�chten Sie dieses Ereignis l�schen?',
'conf_del_item'     => 'Are you sure you want to delete this item?',
'edit_repeat'       => 'Edit this instance',
'edit_event'        => 'Ereignis bearbeiten',
'add_event'         => 'Ereignis hinzuf�gen',
'err_missing_title' => '* <i>Ereignistitel</i> ist ein ben�tigtes Feld.',
'err_missing_weekdays' => 'You must specify at least one day for a day-of-week recurrence.',
'err_times'         => 'The ending time cannot be before the starting time.',
'err_db_saving'     => 'A database error occurred while saving your record.',
'err_cal_import'    => 'There were %d errors importing from the calendar. Check your error log for details',
'err_import_event'  => 'Error importing event %s',
'err_cal_notavail' => 'The calendar plugin data is not available.',
'info'              => 'Information',
'warning'           => 'Warning',
'alert'             => 'Alert',
'editing_instance'  => 'You are editing a single instance of this event.',
'editing_series'    => 'You are editing the event series.  Any customizations made to specific instances will be lost!',
'allday'            => 'Alle Tage',
'recur_cust_format' => '(Format: YYYY-MM-DD, YYYY-MM-DD, etc.)',
'recur_cust_ignoredates' => '(Ignores the start and end dates given above.)',
'click_to_select'   => 'Click to select',
'access_denied'     => 'Zugriff verweigert',
'skip_weekends'     => 'Wochenenden �berspringen?',
'yes'               => 'Ja',
'no'                => 'In',
'next_bus_day'      => 'N�chster Werktag?',
'edit'              => 'Bearbeiten',
'event_title'       => 'Ereignistitel',
'event_summary'     => 'Ereigniszusammenfassung: %s',
'start_date'        => 'Startdatum',
'start_time'        => 'Startzeit',
'end_time'          => 'Endzeit',
'end_date'          => 'Enddatum',
'copy'              => 'Kopieren',
'id'                => 'ID',
'enabled'           => 'Aktivieren',
'enabled_q'         => 'Aktivieren',
'ical_enabled'      => 'ICal Aktivieren',
'calendar'          => 'Calendar',
'calendars'         => 'Calendars',
'select_cals'       => 'Select which calendars will be displayed',
'new_calendar'      => 'New Calendar',
'events'            => 'Ereignisse',
'new_event'         => 'Ereignis hinzuf�gen',
'categories'        => 'evList-Kategorien',
'category'          => 'Kategorie',
'new_category'      => 'New Category',
'ticket_types'      => 'Ticket Types',
'type'              => 'Type',
'fee'               => 'Fee',
'new_ticket_type'   => 'New Ticket Type',
'print_tickets'     => 'Print Tickets',
'import_calendar'   => 'Import from Calendar',
'import_from_csv'   => 'Import from CSV',
'title'             => 'Titel',
'ev_info'           => 'Allgemeine Ereignisinformation',
'ev_schedule'       => 'Schedule',
'ev_perms'          => 'Permissions',
'ev_contact'        => 'Contact',
'ev_location'       => 'Ort',
'show_upcoming'     => 'Show in Upcoming Events',
'misc'              => 'Miscellaneous',
'foreground'        => 'Foreground',
'background'        => 'Background',
'colors'            => 'Colors',
'cal_name'          => 'Calendar Name',
'cat_name'          => 'Category Name',
'reset'             => 'zur�cksetzen',
'del_cal_msg1'      => 'You are about to delete a calendar.  This is a permanent deletion and cannot be reversed.  Be sure that this is what you want to do before you click "Submit" below!
You may either move existing events to a new calendar, or delete those events.',
'del_cal_events'    => 'This calendar has %d events associated with it.  You may move these events to another calendar by selecting one below.  If you do not select a new calendar for the events, they will ALL be permanently deleted from the database.',
'confirm_del'       => 'Confirm that you want to delete the item',
'none_delete'       => 'None- delete the events',
'deleting_cal'      => 'Deleting Calendar',
'filter'            => 'Filter',
'when'              => 'When',
'where'             => 'Where',
'what'              => 'What',
'more_info'         => 'Mehr Informationen',
'click_here'        => '<a href="%s" %s>Klicken Sie hier</a>  hier f�tere Informationen',
'contact_us'        => 'Please <a href="%s">contact us</a> for more information.',
'rem_subject'       => "Eine Ereigniserinnerung von {$_CONF['site_name']}",
'rem_msg1'          => "Sie erhalten diese Erinnerung, weil Ihre Adresse an {$_CONF['site_name']} gesendet wurde.",
'rem_msg2'  => 'This is a one-time message. You will not receive another message unless you subscribe to other events.',
'rem_url'           => 'F�r mehr Informationen besuchen Sie bitte %s',
'you_are_subscribed' => 'You are subscribed to this event.',
'topic_all'         => 'All',
'topic_home'        => 'Homepage only',
'recur_stop_desc'   => ' until %s',
'recur_freq_txt' => 'Occurs every',
'interval_label'    => 'Specify the interval and day on which this event will recur',
'interval_note'     => 'The first occurance will be on the date specified above.',
'all_calendars'     => 'All Calendars',
'all_categories'    => 'Alle Kategorien',
'update_cats'       => 'Kategorien aktualisieren',
'notify_submission' => 'A new event has been submitted to {$_CONF[\'site_name\']}.  It can be approved or deleted at {$_CONF[\'site_admin_url\']}/moderation.php.',
'submitted_by'      => 'Submitted By',
'notify_subject'    => 'Event Notification from $_CONF[\'site_name\']',
'show_contactlink'  => 'Show link to contact email',
'no_match'          => 'Es gibt keine Ereignisse, die Ihren Kriterien entsprechen.',
'event_begins'      => 'Ereignisliste',
'read_more'         => 'Dieses Ereignis beginnt: %s',
'quick_del'         => 'Schnelll�schen',
'gen_evt_info'      => 'Allgemeine Ereignisinformation',
'full_desc'         => 'Volle Beschreibung',
'postmode'          => 'Beitragsmodus',
'post_html_note1'   => 'HINWEIS: Das <i>Ereignisort</i> Feld akzeptiert auch HTML.',
'enable_reminders_q' => 'E-Mail Erinnerungen aktivieren?',
'disable_reminders_note' => 'Das Deaktivieren der Erinnerungen, l�scht alle relevanten Erinnerungen.',
'submit_email_note' => 'Senden Sie ihre E-Mail Adresse, um an dieses Ereignis erinnert zu werden.',
'add_to_cats'       => 'F�gen Sie ihr Ereignis einer einzelnen oder mehreren Kategorien hinzu',
'cats_not_req'      => 'Das Hinzuf�gen Ihres Ereignisses zu einer Kategorie, ist nicht notwendig.',
'cat_note1'         => 'Erstellen Sie eine neue Kategorie f�r ihr Ereignis, an Stelle von oder zus�lich zu einer existierenden Kategorie.',
'url'               => 'URL',
'street_address'    => 'Strasse',
'city'              => 'Stadt',
'state'             => 'Bundesland',
'country'           => 'Land',
'zip'               => 'Postleitzahl',
'for_more_info'     => 'F�r mehr Informationen, kontaktieren Sie',
'email'             => 'E-Mail',
'phone'             => 'Telefon #',
'perms_desc'        => 'Berechtigungen: (R = Lesen, E = Bearbeiten, setzt Lese-Bereichtigung voraus)',
'date_time_info'    => 'Date and Time Information',
'split_q'           => 'Aufteilen?',
'rec_event_info'    => 'Ereignis wiederholen - Information',
'rec_event_q'       => 'Ist dies ein sich wiederholendes Ereignis?',
'event_recurs'      => 'Ereignis wiederholt sich',
'select_format'     => 'Format w�hlen',
'jump_today'        => 'Gehe zu Heute',
'day_view'          => 'Tagesansicht',
'week_view'         => 'Wochenansicht',
'month_view'        => 'Montsansicht',
'year_view'         => 'Jahresansicht',
'list_view'         => 'Listenansicht',
'select_range'      => 'W�hlen Sie einen Ereigniszeitraum zum Anzeigen',
'or_choose_cat'     => 'und/oder w�hlen Sie eine Kategorie',
'go'                => 'Los',
'days_prior'        => 'Tage vor diesem Ereignis.',
'email_private'     => 'Ihre E-Mail bleibt privat und wird nur zu Erinnerung an dieses Ereignis verwendet.',
'current_events'    => 'Aktuelle Ereignisse',
'past_events'       => 'Vergangene Ereignisse',
'upcoming_events'   => 'Bevorstehende Ereignisse',
'this_week_events'  => 'Ereignisse dieser Woche',
'this_month_events' => 'Ereignisse dieses Monats',
'hits'              => 'Treffer',
'top_ten'           => 'Top Ten evList-Ereignisse',
'no_events_viewable' => 'Derzeit sind keine Ereignisse im System anzeigbar.',
'date'              => 'Datum',
'time'          => 'Time',
'all_upcoming'      => 'All Upcoming Events',
'subscribe_to'      => 'Subscribe to',
'messages'          => array(
        1   => 'Erfolg! Ereignis wurde gel�scht.',
        2   => 'Erfolg! Ihr Ereignis wurde gespeichert.',
        3   => 'Ereignis wurde kopiert. Sie k�nnen nun ihr neues Ereignis bearbeiten.',
        4   => 'Erfolg! Ereignis wurde aktualisiert.',
        5   => 'Ben�tigte Felder sind leer. Bitte �berpr�fen Sie ihre Einsendung.',
        6   => 'Alarm!',
        7   => 'evList-Standardeinstellungen wurden gesetzt.',
        8   => 'evList-Konfigurationseinstellungen wurden aktualisiert.',
        9   => "Danke f�r das Einsenden Ihres Ereignisses nach {$_CONF['site_name']}. Es wude an unser Team �bersendet und muss noch best�tigt werden. Wenn es best�tigt wurde, d Ihr Ereignis anderen zug�nglich sein.",
        10  => 'Eingegebene Daten sind nicht g�ltig. Bitte �berpr�fen Sie ihre Einsendung.', 
        11  => 'Kategorien wurde aktualisiert.',
        12  => 'Erinnerung gespeichert. Sie sollten eine E-Mail vor diesem Ererignis erhalten.',
        13  => 'Sie haben eine ung�ltige oder falsch formatierte E-Mail Adressee angegeben.Bitte versuchen Sie es erneut.',
        14  => 'Sie m�ssen angeben, wieviele Tage vor dem Ereignis Sie erinnert werden m�cen.',
        15  => "Diese Seite ben�tigt mindestens {$_EV_CONF['reminder_speedlimit']} SekundenWartezeit zwischen dem Anfordern von Erinnerungen.",
        16  => "Diese Seite ben�tigt mindestens {$_EV_CONF['post_speedlimit']} Sekunden Warezeit zwischen dem Einsenden von Ereignissen.",
        17  => 'Die Ereignisse des glFusion Kalenders wurden importiert',
        18  => 'Erinnerungsmitteilung erfolgreich entfernt',
        19  => 'One or more errors occured during the calendar import.  Check the error log for details.',
    20  => 'This event doesn\'t allow registrations, or you do not have access to it.',
    21  => 'You\'re already signed up for this event.',
    22  => 'This event is full.',
    23  => 'There was an error processing your request.',
    24  => 'You have been registered for this event.',
    25  => 'Your registration has been cancelled.',
    26  => 'Payment is required, click <a href="%s">here</a> to check out',
    27  => 'This event is full and you have been added to the waiting list',
    28  => 'You have %d tickets remaining.',
    50  => 'Not Paid',
    51  => 'Already Used',
    ),
'admin_instr'       => array(
        'categories'    => 'Deleting categories <strong>will not</strong> delete events belonging to those categories.<br />Disabling a category <strong>will not</strong> disable its events.  Those events will continue to appear in the event list if it belongs to another category or if no category is selected.',
        'calendars'     => 'All events must be associated with a calendar.<br />Disabling a calendar prevents its events from being displayed. Deleting a calendar requires that events belonging to it be moved to another calendar.<br />Calendar number 1 cannot be deleted, but may be disabled.',
        'events'        => 'To create a new event, click on "New Event" above.<br />To modify or delete an event, click on that event\'s edit icon below. To enable/disable an event, check the appropriate box below.',
    'tickettypes' => 'Tickets can be created for free or paid admission, and to cover one event occurrence or all occurrences (event pass). Tickets are only used if the global &quot;Enable RSVP&quot; setting is enabled.<br />Ticket Types can only be deleted if they haven&apos;t been used for any events.',
    ),
'rec_formats'       => array(
        1   => 't�glich nach Datum, z.B., 4. April bis 7. April (sequentiell)',
        2   => 'monatlich nach Datum, z.B., der Erste jedes Monats',
        3   => 'j�hrlich nach Datum, z.B., 25. Dezember Jahr f�r Jahr',
        4   => 'w�chentlich nach Tag, z.B., Mo, Di, and Fr',
        5   => 'monatlich nach Tag, z.B., der dritte Freitag jedes Monats',
        6   => 'benutzerdef. Daten: ein Liste mit Kalenderdaten, mit Komma getrennt',
    ),
'rec_periods'       => array(
    1 => 'tag',
    2 => 'monat',
    3 => 'jahr',
    4 => 'woche',
    5 => 'monat',
    6 => '',
    ),

'postmodes'         => array(
        'plaintext'   => 'Text',
        'html'   => 'HTML',
    ),
'rec_intervals'     => array(
        1   => 'Erster',
        2   => 'Zweiter',
        3   => 'Dritter',
        4   => 'Vierter',
        5   => 'Letzter',
    ),
'ranges'            => array(
        1   => 'vergangen',
        2   => 'bevorstehend',
        3   => 'diese Woche',
        4   => 'diesen Monat',
    ),
'recur_desc'        => array(
        1   => 'Occurs every day',
        2   => 'Occurs on the same date each month',
        3   => 'Occurs on the same date each year',
        4   => 'Occurs every %interval% week on %day%',
        5   => 'Occurs %interval% month on the %daynum% %day%',
        6   => '',      // custom dates
    ),
'periods'           => array(
        'day'   => 'Tag',
        'week'  => 'Woche',
        'month' => 'Monat',
        'year'  => 'Jahr',
    ),
'on_days'   => 'on %s',
'on_the_days' => 'on the %s',
'each'      => 'each',
'every_num'  => 'every %d',
'event_editor'  => 'Ereignis-Editor',
'datestart_note' => '* <i>Startdatum</i> Jahr und Monat sind ben�tige Felder.',
'custom_label'  => 'Spezifizieren Sie den/der/die/das %s an dem/denen sich das Ereignis %s wiederholt',
'stop_label'    => 'Spezifizieren Sie den/der/die/das %s, nach dem/denen sich das Ereignis nicht %s wiederholt',
'day_by_date' => 'Tag, nach Tag',
'dates' => 'Daten',
'year_and_month' => 'Jahr und Monat',
'year' => 'Jahr',
'days_of_week' => 'Tage der Woche, nach Anzahl,',
'date_l' => 'Datum',
'if_any' => ', wenn �berhaupt,',
'all_day_event' => 'Dies ist ein Jeden-Tag-Ereignis.',
'more_from_cat' => 'Mehr Ereignisse von:&nbsp;',
'access_denied_msg' => 'Nur authorisierte Benutzer haben Zugriff auf diese Seite. Dein Benutzername und IP wurden aufgezeichnet.',
'coordinates'   => 'Coordinates',
'latitude'      => 'Latitude',
'longitude'     => 'Longitude',
'instr_coords'  => 'If zero or empty, the coordinates will be filled in automatically from the address information, if possible.',
'select_location' => 'Select Location',
'instr_sel_loc' => 'Select a location from the list, or fill in the details.',
'use_rsvp'       => 'Enable signups?',
'max_rsvp'       => 'Max. Attendees',
'max_user_rsvp' => 'Max. Registrations per User',
'signup'        => 'Register for this event',
'cancelreg'     => 'Cancel your registration',
'rsvp_none'     => 'Signups Disabled',
'rsvp_event'    => 'Allow signups for the event',
'rsvp_repeat'   => 'Allow signups for each occurrence',
'rsvp_mindays'  => 'Min. days to RSVP',
'admin_rsvp'    => 'Manage RSVP\'s',
'rsvp_date'      => 'Registration Date',
'registration'  => 'Registration',
'rsvp_waitlist' => 'Accept waitlisted reservations?',
'rsvp_cutoff'   => 'RSVP Cutoff (days)',
'sel_monthdays' => 'Select the days each month when the event will occur',
'sub_this_instance' => 'This Instance',
'sub_all_instances' => 'All occurrences',
'description'   => 'Description',
'event_pass'    => 'Event Pass',
'cancel_free'   => 'Free registrations can be cancelled here if you will not be attending.',
'free_rsvp'     => 'Free Registrations',
'ticket_num'    => 'Ticket Number',
'date_used'     => 'Date Used',
'paid'          => 'Paid',
'balance_due'   => 'Balance Due',
'login_to_register' => 'You need to log into the site to register for this event',
'conf_reset'    => 'Are your sure you want to reset this item?',
'reset_usage'   => 'Reset Usage',
'export_list'   => 'Export List',
'waitlisted'    => 'Waitlisted',
'name'          => 'Name',
'quantity'      => 'Quantity',
'edit_future' => 'Edit this and future instances',
'editing_future' => 'Your are editing all future instances of this event.',
'clk_help' => 'Click for help',
'all' => 'All',
'sel_category' => 'Select Category',
'click_for_datepicker' => 'Click for Date Selector',
);

// Localization of the Admin Configuration UI
$LANG_configsections['evlist'] = array(
    'label'                 => 'evList',
    'title'                 => 'evList-Konfiguration'
);
$LANG_confignames['evlist'] = array(
    'allow_anon_view'       => 'Erlaube G�sten die Anzeige von Ereignissen?',
    'allow_anon_add'        => 'Erlaube G�sten Einsendungen?',
    'allow_user_add'        => 'Erlaube angemeldeten Benutzern Einsendungen?',
    'can_add'               => 'Users allowed to add events',
    'allow_html'            => 'Erlaube HTML beim Schreiben?',
    'usermenu_option'       => 'Benutzermen�link-Option',
    'enable_menuitem'       => 'Men�objekt aktivieren?',
    'week_begins'           => 'Woche beginnt am',
    'date_format'           => 'Datumsformat',
    'time_format'           => 'Zeitformat',
    'enable_categories'     => 'Kategorien aktivieren',
    'enable_centerblock'    => 'Centerblock aktivieren?',
    'pos_centerblock'       => 'Centerblock-Position',
    'topic_centerblock'     => 'Thema',
    'range_centerblock'     => 'Zeitraum zum Anzeigen w�hlen',
    'limit_centerblock'     => 'Anzahl der anzuzeigenden Ereignisse',
    'limit_list'            => 'Hauptliste: Anzahl der anzuzeigenden Ereignisse je Seite',
    'limit_block'           => 'Bevorstehende-Ereignisse-Block: Anzahl der anzuzeigenden Ereignisse',
    'limit_summary'         => 'Anzahl der Zeichen in der Anzeige der Ereigniszusammenfassung',
    'enable_reminders'      => 'E-Mail-Erinnerungen aktivieren?',
    'event_passing'         => 'Ein Ereignis h�rt auf <i>bevorstehend</i> zu sein',
    'default_permissions'   => 'Standardberechtigungen (Eigent�mer,Gruppe,Mitglieder,G�ste)',
    'reminder_speedlimit'   => 'Erinnerungen - Speedlimit',
    'post_speedlimit'       => 'Beitr�ge - Speedlimit',
    'reminder_days'         => 'Anzahl der Tage vor einem Ereignis, um Erinnerungen zu erlauben',
    'displayblocks'         => 'Display glFusion Blocks',
    'default_view'          => 'Default View',
    'max_upcoming_days'     => 'Max. Upcoming days to show in list',
    'use_locator'           => 'Integrate with the Locator plugin?',
    'use_weather'           => 'Integrate with the Weather plugin?',
    'cal_tmpl'              => 'Use HTML or JSON templates',
    'enable_rsvp'           => 'Enable Registration/Ticketing?',
    'rsvp_print'            => 'Enable Ticket Printing?',
    'meetup_key'            => 'Meetup API Key',
    'meetup_gid'            => 'Meetup Group ID(s)',
    'meetup_cache_minutes'  => 'Cache Minutes',
    'meetup_enabled'        => 'Enable Meetup.com integration?',
);
$LANG_configsubgroups['evlist'] = array(
    'sg_main'               => 'Haupteinstellungen',
    'sg_rsvp'               => 'RSVP/Ticketing',
    'sg_integ'              => 'Integrations',
);
$LANG_fs['evlist'] = array(
    'ev_access'             => 'Zugriffskontrolle',
    'ev_gui'                => 'GUI-Einstellungen',
    'ev_centerblock'        => 'Centerblock-Einstellungen',
    'ev_permissions'        => 'Standardberechtigungen',
    'ev_rsvp'               => 'Registration and Ticketing',
    'ev_integ_meetup'       => 'Meetup.Com',
);
$LANG_configselects['evlist'] = array(
    0 => array('Ja' => 1, 'Nein' => 0),
    1 => array('Ja' => TRUE, 'Nein' => FALSE),
    2 => array('Ereignis hinzuf�gen' => 1, 'Ereignisse auflisten' => 2),
    3 => array('Sonntag' => 1, 'Montag' => 2),
    4 => array(
            'Don Nov 20, 2008'      => '%a %b %d, %Y',
            'Don Nov 20'            => '%a %b %d',
            'Donnerstag Nov 20, 2008' => '%A %b %d, %Y',
            'Donnerstag Nov 20'       => '%A %b %d',
            'Donnerstag November 20'  => '%A %B %d',
            'November 20, 2008'     => '%B %d, %Y',
            '11/20/08'              => '%m/%d/%y',
            '11-20-08'              => '%m-%d-%y',
            '2008 11 20'            => '%Y %m %d',
            'Nov 20 2008'           => '%b %d %Y',
            'Nov 20, 2008'          => '%b %d, %Y',
        ),
    5 => array('02:38 PM' => '%I:%M %p', '14:48' => '%H:%M',),
    6 => array(
            'sobald die Startzeit um ist (wenn vorhanden)' => 1,
            'sobald das Startdatum um ist, i.R., der n�chste Tag.' => 2,
            'as soon as the end time has passed (if exists).' => 3,
            'as soon as the end date has passed.' => 4,
        ),
    7 => array('Oben auf Seite'=>1,'Nach Hauptartikel'=>2,'Unten auf Seite'=>3,'Gesamte Seite'=>0),
    8 => array('vergangen'=>1,'bevorstehend'=>2,'diese Woche'=>3,'diesen Monat'=>4),
    9 => array('disabled' => 0, 'table' => 1, 'story' => 2),
    12 => array('Kein Zugriff' => 0, 'Nur-Lesen' => 2, 'Lesen-Schreiben' => 3),
    13 => array('Left Blocks' => 0, 'Right Blocks' => 1, 'Left & Right Blocks' => 2, 'None' => 3),
    14 => array('Tag' => 'day', 'Woche' => 'week', 'Monat' => 'month', 'Jahr' => 'year', 'List' => 'list'),
    15 => array('Admins Only' => 0, 'Logged-In Users' => 1, 'Logged-In+Anon Users' => 2),
    16 => array('HTML' => 'html', 'JSON' => 'json'),
    17 => array('No' => 0, 'Default No' => 1, 'Default Paid Only' => 2,
                'Default Paid or Unpaid' => 3),
);

?>
