<?php

/** Über dieses Array werden verschiedene Sets an Validatoren definiert, wodurch eine einfachere
 * Wiederverwendung und Anpassung gewährleistet wird. Im jeweiligen Controller können diese Rules
 * per $this->form_validation->set_rules($this->config->item('NAME_DES_ARRAYSCHLUESSELS')); 
 * eingesetzt werden.
 */  

$config = array(
     'user_login' => array(
         array(
             'field' => 'username',
             'label' => 'Benutzername',
             'rules' => 'trim|required|min_length[5]|max_length[20]|xss_clean'
         ),
         array(
             'field' => 'password',
             'label' => 'Passwort',
             'rules' => 'trim|required|xss_clean'
         )
     ),
     'ort_valid' => array(
            array(
                    'field' => 'name',
                    'label' => 'Name des Ortes',
                    'rules' => 'trim|required'
                 ),
            array(
                    'field' => 'plz',
                    'label' => 'PLZ',
                    'rules' => 'trim|required|integer|min_length[5]|max_length[5]'
                 ),
            array(
                    'field' => 'istaktiv',
                    'label' => 'Aktiv',
                    'rules' => 'trim|integer|min_length[1]|max_length[1]'
                 )
            ),    
    'ausstattung_valid' => array (
        array(
            'field' => 'name',
            'label' => 'Name des Gegenstandes',
            'rules' => 'trim|required|xss_clean'
        ), 
        array(
            'field' => 'inventarnummer',
            'label' => 'Seriennummer',
            'rules' => 'trim|required|xss_clean'
        ), 
        array(
            'field' => 'ausstattungstyp_id',
            'label' => 'Typ',
            'rules' => 'trim|required|integer|xss_clean'
        ), 
        array(
            'field' => 'raum_id',
            'label' => 'Raum',
            'rules' => 'trim|required|integer|xss_clean'
        )
    ),
    'raum_valid' => array (
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required|xss_clean'
        ), 
        array(
            'field' => 'beschreibung',
            'label' => 'Beschreibung',
            'rules' => 'trim|xss_clean'
        ), 
        array(
            'field' => 'sitzplaetze',
            'label' => 'Sitzplätze',
            'rules' => 'trim|integer|required|xss_clean'
        ), 
        array(
            'field' => 'gebaeude_id',
            'label' => 'Gebäude',
            'rules' => 'trim|required|integer|xss_clean'
        ), 
        array(
            'field' => 'etage',
            'label' => 'Etage',
            'rules' => 'trim|required|xss_clean'
        )
    ),
    'gebaeude_valid' => array (
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required|xss_clean'
        ), 
        array(
            'field' => 'strasse',
            'label' => 'Beschreibung',
            'rules' => 'trim|required|xss_clean'
        ), 
        array(
            'field' => 'hausnummer',
            'label' => 'Hausnummer',
            'rules' => 'trim|required|xss_clean'
        ), 
        array(
            'field' => 'zusatz',
            'label' => 'Zusatz',
            'rules' => 'trim|xss_clean'
        ), 
        array(
            'field' => 'ort_id',
            'label' => 'Ort',
            'rules' => 'trim|required|integer|xss_clean'
        )
    ),
    'nutzer_create' => array(
        array(
            'field' => 'vorname',
            'label' => 'Vorname',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'nachname',
            'label' => 'Nachname',
            'rules' => 'trim|min_length[3]|required|xss_clean'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|alpha|min_length[3]|required|xss_clean|callback__check_for_duplicate[username]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|xss_clean|callback__check_for_duplicate[email]'
        ), 
        array(
            'field' => 'passwort',
            'label' => 'Passwort',
            'rules' => 'trim|required|min_length[6]|strong_password[username]|xss_clean'
        ), 
        array(
            'field' => 'passwort_repeat',
            'label' => 'Passwort wiederholen',
            'rules' => 'trim|required|matches[passwort]|xss_clean'
        ), 
        array(
            'field' => 'rolle',
            'label' => 'Rolle',
            'rules' => 'trim|integer|required|xss_clean'
        )     
    ),
     'nutzer_edit' => array(
        array(
            'field' => 'vorname',
            'label' => 'Vorname',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'nachname',
            'label' => 'Nachname',
            'rules' => 'trim|min_length[3]|required|xss_clean'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|alpha|min_length[3]|required|xss_clean|callback__check_for_duplicate[username]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|xss_clean|callback__check_for_duplicate[email]'
        ), 
        array(
            'field' => 'passwort',
            'label' => 'Passwort',
            'rules' => 'trim|min_length[6]|strong_password[username]|xss_clean'
        ), 
        array(
            'field' => 'passwort_repeat',
            'label' => 'Passwort wiederholen',
            'rules' => 'trim|matches[passwort]|xss_clean'
        ), 
        array(
            'field' => 'rolle',
            'label' => 'Rolle',
            'rules' => 'trim|integer|required|xss_clean'
        )     
    ),
    'anfrage_valid' => array(
        array(
            'field' => 'raumid',
            'label' => 'Raumid',
            'rules' => 'trim|required|xss_clean'
        ),        
        array(
            'field' => 'name',
            'label' => 'Veranstaltung',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'startdatum',
            'label' => 'Startdatum',
            'rules' => 'trim|xss_clean|required|valid_date|valid_date_range[enddatum]|valid_duration[enddatum]|callback__check_ueberschneidung|callback__check_zeitraum'
        ),
        array(
            'field' => 'enddatum',
            'label' => 'Enddatum',
            'rules' => 'trim|xss_clean|required|valid_date|callback__check_ueberschneidung'
        ),
        array(
            'field' => 'teilnehmer',
            'label' => 'Teilnehmer',
            'rules' => 'trim|required|integer|xss_clean|callback__check_sitzplaetze'
        )
    )
);