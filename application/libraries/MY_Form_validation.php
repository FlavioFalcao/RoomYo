<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// CodeIgniter Library Extension for date comparation
// version 1 - May 30, 2010

class MY_Form_validation extends CI_Form_validation
{

    function __construct()
    {
        parent::__construct();
    }

    function valid_date_range($str, $field)
    {
        if (!isset($_POST[$field]))
            return FALSE;

        $field = $_POST[$field];

        try
        {

            $start = new DateTime($str . ' Europe/Berlin'); // DD-MM-YYYY
            $end = new DateTime($field . ' Europe/Berlin');

            if ($start < $end) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $e)
        {
            return FALSE;
        }
    }

    function valid_date($str)
    {
        // Datum und Uhrzeit auftrennen
        $datetimeArray = preg_split('/\s+/', $str);

        // Wenn Datum gültig
        if (preg_match(DATE_REGEX, $datetimeArray[0])) {

            //Wenn Uhrzeit gesetzt
            if (isset($datetimeArray[1])) {
                // Wenn Uhrzeit ungültig
                if (!preg_match(TIME_REGEX, $datetimeArray[1]))
                    return FALSE;
            } else {
                // Wenn keine Uhrzeit eingegeben wurde
                return FALSE;
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function strong_password($pass, $userfield)
    {
        $username = set_value($userfield);
        // Wenn Passwort und Username gleich sind, dann Fehler ausgeben.
        if ($pass == $username) {
            $this->set_message('strong_password', 'Passwort und Username dürfen nicht identisch sein.');
            return FALSE;
        }

        $messages = NULL;
        // Mindestanforderungen an ein starkes Passwort überprüfen.
        if (!preg_match('/[A-Z].*[a-z]|[a-z].*[A-Z]/', $pass))
            $messages .= 'Das Passwort muss aus Groß- und Kleinbuchstaben bestehen. ';
        if (!preg_match('/\d+/', $pass))
            $messages .= 'Das Passwort muss mindestens eine Zahl beinhalten. ';
        if (!preg_match('/\W/', $pass))
            $messages .= 'Das Passwort muss mindestens ein Sonderzeichen beinhalten. ';

        // Wenn eine Fehlermeldung gesetzt wurde, dann Fehler ausgeben.
        if (isset($messages)) {
            $this->set_message('strong_password', $messages);
            return FALSE;
        }
        return TRUE;
    }

    function valid_duration($str, $field)
    {
        // Prüfen ob
        if (self::valid_date_range($str, $field)) {

            $field = $_POST[$field];

            try
            {

                $start = new DateTime($str . ' Europe/Berlin'); // DD-MM-YYYY
                $end = new DateTime($field . ' Europe/Berlin');

                if (intval($start->diff($end)->format('%R%a') <= MAX_VERANSTALTUNGSDAUER)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } catch (Exception $e)
            {
                echo "exception";
                return FALSE;
            }
        } else {

            return FALSE;
        }
    }
}