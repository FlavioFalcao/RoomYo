<?php
// Konfiguration für die Autorisierung innerhalb der verschiedenen Seitenbereiche
$config = array(
    'user/dashboard'    => array('auth_required' => TRUE, 'role_required' => 'user'),
    'admin/*'           => array('auth_required' => TRUE, 'role_required' => 'admin'),
    'veranstaltung/*'    => array('auth_required' => TRUE, 'role_required' => 'user'),
);