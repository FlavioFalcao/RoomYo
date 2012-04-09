<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|--------------------------------------------------------------------------
| Custom Constants
|--------------------------------------------------------------------------
|
| Eigene Konstanten
|
*/

define ('ELEMENTE_PRO_SEITE',10);
define ('LIMIT',1000);
define ('MAX_VERANSTALTUNGSDAUER',5);
define ('DATE_REGEX', '/^(0?[1-9]|[12][0-9]|3[01])[-\/.](0?[1-9]|1[012])[-\/.]([2][0-9]{3})$/');
define ('TIME_REGEX','/^(?:2[0-4]|[01]?[0-9]):[0-5][0-9]?$/');
define ('DEFAULT_TITLE', 'Standard Seitentitel');
define ('WOCHENSTUNDEN', 40);
define ('SEKUNDENEINESTAGES', 86400);

/* End of file constants.php */
/* Location: ./application/config/constants.php */