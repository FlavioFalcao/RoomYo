<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Umschreiben aller post Daten in utf-8 kompatibele Streams
*/
function ob_utf8($string) {
    return utf8_decode($string);
}
ob_start('ob_utf8');

// Hier werden alle Postdaten konvertiert
foreach ($_POST as $key => $val) 
    $_POST[$key] = utf8_encode($val);
?> 